<?php
// Simple script to create the resi_files directory in the files directory
// This can be run directly to set up the directory

// Set up paths
$targetDir = '../files/resi_files/';
$fullPath = realpath(dirname(__FILE__) . '/' . $targetDir);

// Show header
echo "<h1>Creating Receipt Upload Directory</h1>";
echo "<p>Target directory: $targetDir</p>";
echo "<p>Full path: $fullPath</p>";

// Create the directory if it doesn't exist
if (!file_exists($targetDir)) {
    echo "<p>Directory does not exist. Creating...</p>";
    
    if (mkdir($targetDir, 0777, true)) {
        echo "<p style='color:green'>Directory created successfully!</p>";
        chmod($targetDir, 0777);
        echo "<p>Set permissions to 0777</p>";
    } else {
        echo "<p style='color:red'>Failed to create directory.</p>";
        echo "<p>Error: " . error_get_last()['message'] . "</p>";
    }
} else {
    echo "<p>Directory already exists.</p>";
    
    // Make sure it's writable
    if (!is_writable($targetDir)) {
        echo "<p>Directory is not writable. Setting permissions...</p>";
        chmod($targetDir, 0777);
        
        if (is_writable($targetDir)) {
            echo "<p style='color:green'>Successfully made directory writable.</p>";
        } else {
            echo "<p style='color:red'>Failed to make directory writable.</p>";
        }
    } else {
        echo "<p style='color:green'>Directory is writable.</p>";
    }
}

// Try to create a test file to verify permissions
$testFile = $targetDir . 'test.txt';
if (file_put_contents($testFile, 'Test file')) {
    echo "<p style='color:green'>Test file created successfully!</p>";
    unlink($testFile);
    echo "<p>Test file removed.</p>";
} else {
    echo "<p style='color:red'>Failed to create test file. Directory may not be writable.</p>";
    echo "<p>Error: " . error_get_last()['message'] . "</p>";
    echo "<p>You may need to set permissions manually:</p>";
    echo "<pre>chmod -R 777 $targetDir</pre>";
}

// Command to execute from CLI
echo "<h2>Manual Commands</h2>";
echo "<p>If the automatic creation failed, you can use these commands from the server shell:</p>";
echo "<pre>";
echo "mkdir -p " . $fullPath . "\n";
echo "chmod -R 777 " . $fullPath;
echo "</pre>";

// Show next steps
echo "<h2>Next Steps</h2>";
echo "<p>Once the directory is created successfully:</p>";
echo "<ol>";
echo "<li>Go back to the <a href='statustrans_sell.php'>Transaction Status</a> page</li>";
echo "<li>Try uploading a receipt file</li>";
echo "<li>Check if the file appears in the <a href='$targetDir' target='_blank'>$targetDir</a> directory</li>";
echo "</ol>";
?> 