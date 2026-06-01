<?php
// Simple direct file upload script
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database config
include_once("../server/config.php");
include_once("../classes/ruleconfigclass.php");
include_once("../classes/systemclass.php");

//$vMailTrx = $oRules->get

// Create a log entry
error_log("Upload attempt at " . date('Y-m-d H:i:s'));

// Set up the upload directory - use folderulesgr in memstock directory
$uploadDir = '../memstock/resi_files/';
error_log("Upload directory: " . $uploadDir);

// Create directory if it doesn't exist
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
    chmod($uploadDir, 0777);
    error_log("Created directory: " . $uploadDir);
}

// For AJAX responses
function sendResponse($success, $message, $data = null) {
    $response = array(
        'success' => $success,
        'message' => $message,
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Check for required parameters
if (!isset($_POST['transactionId'])) {
    error_log("No transaction ID provided");
    sendResponse(false, "Missing transaction ID");
}
$transactionId = $_POST['transactionId'];
error_log("Processing transaction ID: " . $transactionId);

// Check if we have a file
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    $errorMsg = "File upload error: ";
    if (isset($_FILES['file'])) {
        $errorCode = $_FILES['file']['error'];
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                $errorMsg .= "File exceeds upload_max_filesize in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $errorMsg .= "File exceeds MAX_FILE_SIZE in form";
                $errorMsg .= "File was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $errorMsg .= "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $errorMsg .= "Missing temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $errorMsg .= "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $errorMsg .= "File upload stopped by extension";
                break;
            default:
                $errorMsg .= "Unknown error code: " . $errorCode;
        }
    } else {
        $errorMsg .= "No file data received";
    }
    error_log($errorMsg);
    sendResponse(false, $errorMsg);
}

// Get file info
$fileName = $_FILES['file']['name'];
$fileTmpPath = $_FILES['file']['tmp_name'];
$fileSize = $_FILES['file']['size'];
$fileType = $_FILES['file']['type'];

error_log("File upload info - Name: $fileName, Size: $fileSize, Type: $fileType");

// Check file extension
$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
if (!in_array($fileExtension, array('jpg', 'jpeg', 'png'))) {
    error_log("Invalid file type: " . $fileExtension);
    sendResponse(false, "Only JPG, JPEG and PNG files are allowed");
}

// Define target file name
$targetFileName = $transactionId . '.' . $fileExtension;
$targetFilePath = $uploadDir . $targetFileName;

error_log("Target file path: " . $targetFilePath);

// Check if any old files exist with different extensions and remove them
$possibleExtensions = array('jpg', 'jpeg', 'png');
$isReupload = false;  // Flag to track if this is a re-upload
foreach ($possibleExtensions as $ext) {
    $oldFile = $uploadDir . $transactionId . '.' . $ext;
    if ($oldFile != $targetFilePath && file_exists($oldFile)) {
        error_log("Removing old file: " . $oldFile);
        $isReupload = true;  // Set re-upload flag
        unlink($oldFile);
    } else if ($oldFile == $targetFilePath && file_exists($oldFile)) {
        error_log("Replacing existing file with same extension: " . $oldFile);
        $isReupload = true;  // Set re-upload flag
    }
}

// Try to save the file with multiple methods
$uploadSuccess = false;

// Method 1: Try move_uploaded_file first
if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
    error_log("move_uploaded_file success");
    $uploadSuccess = true;
}
// Method 2: Try copy
else if (copy($fileTmpPath, $targetFilePath)) {
    error_log("copy success");
    $uploadSuccess = true;
}
// Method 3: Try file_put_contents
else {
    $fileContent = file_get_contents($fileTmpPath);
    if ($fileContent !== false && file_put_contents($targetFilePath, $fileContent) !== false) {
        error_log("file_put_contents success");
        $uploadSuccess = true;
    }
}

// Verify file was saved
if ($uploadSuccess && file_exists($targetFilePath)) {
    $fileSize = filesize($targetFilePath);
    error_log("File saved successfully: $targetFilePath ($fileSize bytes)");
    
    // Update database
    try {
        $sql = "UPDATE tb_penjualan_temp SET fsend = 1 WHERE fidpenjualan = '$transactionId'";
        error_log("Executing SQL: $sql");
        $db->query($sql);
        
        $affectedRows = $db->affected_rows();
        error_log("Database updated: $affectedRows rows affected");
        
        // Send email notification to Admin Transaction
        if ($affectedRows > 0 || $isReupload) {  // Send notification for re-uploads too
            try {
                // Get Admin Transaction email from settings
                $vAdminTrxEmail = $oRules->getSettingByField("fmailtrx");
                
                if ($vAdminTrxEmail != '-1' && $vAdminTrxEmail != '') {
                    // Get transaction details
                    $sqlDetails = "SELECT fidmember, fidseller FROM tb_penjualan_temp WHERE fidpenjualan = '$transactionId'";
                    $db->query($sqlDetails);
                    $db->next_record();
                    $vIdMember = $db->f('fidmember');
                    $vIdSeller = $db->f('fidseller');
                    
                    // Prepare email content
                    $vSubject = $isReupload ? "Bukti Pengiriman Diperbarui: $transactionId" : "Bukti Pengiriman: $transactionId";
                    $vBody = "
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; }
                            .container { padding: 20px; }
                            .header { background-color: #f0f0f0; padding: 10px; }
                            .content { padding: 15px; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h2>Pemberitahuan " . ($isReupload ? "Pembaruan " : "") . "Bukti Pengiriman</h2>
                            </div>
                            <div class='content'>
                                <p>Halo Admin,</p>
                                <p>" . ($isReupload ? "<strong>File bukti pengiriman telah diperbarui</strong> untuk transaksi berikut:" : "Bukti pengiriman untuk transaksi berikut telah diunggah:") . "</p>
                                <ul>
                                    <li><strong>No. Transaksi:</strong> $transactionId</li>
                                    <li><strong>ID Member:</strong> $vIdMember</li>
                                    <li><strong>ID Seller:</strong> $vIdSeller</li>
                                    <li><strong>Waktu Upload:</strong> " . date('Y-m-d H:i:s') . "</li>
                                    " . ($isReupload ? "<li><strong>Status:</strong> File Diperbarui</li>" : "") . "
                                </ul>
                                <p>Silahkan login ke sistem untuk melihat bukti pengiriman tersebut.</p>
                                <p>Terima kasih,<br/>
                                Sistem Notifikasi</p>
                            </div>
                        </div>
                    </body>
                    </html>
                    ";
                    
                    // Send email using system class
                 //   $oSystem = new system();
                    $result = $oSystem->smtpmailerHosting(
                        $vAdminTrxEmail, // Mail To
                        'Admin Transaction', // Mail To Name 
                        $oRules->getSettingByField('fmailadmin'), // Mail From
                        'System Notification', // From Name
                        $vSubject, // Subject
                        $vBody, // Body
                        $oRules->getSettingByField('fmailbcc'), // BCC
                        '', // BCC2
                        true, // HTML
                        0 // Debug
                    );
                    
                    if ($result) {
                        error_log("Email notification sent successfully to $vAdminTrxEmail" . ($isReupload ? " (for re-upload)" : ""));
                    } else {
                        error_log("Failed to send email notification to $vAdminTrxEmail");
                    }
                } else {
                    error_log("Admin Transaction email not found in settings");
                }
            } catch (Exception $e) {
                error_log("Email notification error: " . $e->getMessage());
            }
        }
        
        sendResponse(true, "File uploaded successfully", array(
            'transaction_id' => $transactionId,
            'file_name' => $targetFileName,
            'file_size' => $fileSize,
            'db_updated' => ($affectedRows > 0),
            'replaced' => $isReupload
        ));
        
    } catch (Exception $e) {
        error_log("Database error: " . $e->getMessage());
        sendResponse(false, "File uploaded but database update failed: " . $e->getMessage(), array(
            'transaction_id' => $transactionId,
            'file_name' => $targetFileName
        ));
    }
} else {
    error_log("Failed to save file");
    sendResponse(false, "Failed to save file. Please try again.");
}
?> 