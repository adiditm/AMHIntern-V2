<?php
// main/api_doc_upload.php
include_once "../server/config.php";
include_once "../classes/ai_doc_processor.php";
header('Content-Type: application/json');
set_time_limit(120); // default max_execution_time is 30s on this host;
                      // chunking + N sequential embedding calls can exceed
                      // that on a large document. No-op if the host has
                      // hard-disabled set_time_limit -- the 30s ceiling
                      // still applies in that case (see Task 10 testing).

function ai_upload_error($message) {
    echo json_encode(array('status' => 'error', 'message' => $message));
    exit;
}

if (!isset($_FILES['docfile']) || $_FILES['docfile']['error'] !== UPLOAD_ERR_OK) {
    ai_upload_error('Tidak ada file yang diupload atau upload gagal.');
}

$role = isset($_POST['role']) ? $_POST['role'] : '';
$validRoles = array('visitor', 'jamaah', 'pebisnis', 'seller', 'korwil', 'admin');
if (!in_array($role, $validRoles, true)) {
    ai_upload_error('Role tidak valid.');
}

$tmpPath = $_FILES['docfile']['tmp_name'];
$origName = $_FILES['docfile']['name'];
$size = $_FILES['docfile']['size'];

// This server's upload_max_filesize is 2M (confirmed in Task 1's diagnostic
// output) -- PHP itself rejects/truncates anything larger before this script
// even runs, so the app-level cap matches that reality instead of promising
// 10MB it can't deliver. Raising it requires a server-side php.ini change
// (e.g. cPanel's MultiPHP INI Editor, if available) -- out of scope here.
if ($size > 2 * 1024 * 1024) {
    ai_upload_error('File terlalu besar (maksimum 2MB pada server ini).');
}

$ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
// PDF deferred -- no PHP-5.6-compatible parser library exists (see
// classes/ai_doc_processor.php). Only .docx ships in this first version.
if ($ext === 'pdf') {
    ai_upload_error('Upload PDF belum didukung untuk saat ini. Silakan gunakan file Word (.docx).');
}
if ($ext !== 'docx') {
    ai_upload_error('Tipe file tidak didukung. Saat ini hanya Word (.docx).');
}

// Insert the document row first (status=pending), then move the file into
// place using that row's id in the filename so names never collide.
$roleEsc = mysql_real_escape_string($role);
$nameEsc = mysql_real_escape_string($origName);
$uploadedBy = isset($_SESSION['LoginUser']) ? mysql_real_escape_string($_SESSION['LoginUser']) : null;
$uploadedByVal = $uploadedBy === null ? 'NULL' : "'$uploadedBy'";

$db->query("INSERT INTO m_ai_document (role, filename, filepath, status, uploaded_by)
    VALUES ('$roleEsc', '$nameEsc', '', 'pending', $uploadedByVal)");
$docId = mysql_insert_id();
if (!$docId) {
    ai_upload_error('Gagal menyimpan data dokumen.');
}

$destDir = '../uploads/ai_docs/';
if (!is_dir($destDir)) {
    mkdir($destDir, 0755, true);
}
$destPath = $destDir . $docId . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $origName);
if (!move_uploaded_file($tmpPath, $destPath)) {
    $db->query("UPDATE m_ai_document SET status='error', error_message='Gagal menyimpan file ke server.' WHERE id=$docId");
    ai_upload_error('Gagal menyimpan file ke server.');
}
$filepathEsc = mysql_real_escape_string($destPath);
$db->query("UPDATE m_ai_document SET filepath='$filepathEsc' WHERE id=$docId");

// --- Extraction ---
// Only .docx reaches here -- PDF is rejected earlier (see the $ext check above).
$text = ai_extract_docx_text($destPath);

if ($text === false || strlen(trim($text)) < 20) {
    $db->query("UPDATE m_ai_document SET status='error', error_message='Tidak ada teks yang bisa diekstrak dari file ini (kemungkinan hasil scan tanpa teks asli).' WHERE id=$docId");
    ai_upload_error('Tidak ada teks yang bisa diekstrak dari file ini.');
}

// --- Chunk + embed + store ---
$chunks = ai_chunk_text($text);
if (count($chunks) === 0) {
    $db->query("UPDATE m_ai_document SET status='error', error_message='Teks kosong setelah diproses.' WHERE id=$docId");
    ai_upload_error('Teks kosong setelah diproses.');
}

$geminiEmbeddingApiKey = GEMINI_EMBEDDING_API_KEY;

$failedChunks = 0;
foreach ($chunks as $index => $chunkText) {
    $embedding = ai_get_embedding($chunkText, $geminiEmbeddingApiKey);
    if ($embedding === false) {
        $failedChunks++;
        continue;
    }
    $chunkEsc = mysql_real_escape_string($chunkText);
    $embeddingJson = mysql_real_escape_string(json_encode($embedding));
    $db->query("INSERT INTO m_ai_document_chunk (document_id, role, chunk_index, chunk_text, embedding)
        VALUES ($docId, '$roleEsc', $index, '$chunkEsc', '$embeddingJson')");
}

$totalChunks = count($chunks);
if ($failedChunks === $totalChunks) {
    $db->query("UPDATE m_ai_document SET status='error', error_message='Semua potongan gagal diubah menjadi embedding (masalah koneksi ke Gemini).' WHERE id=$docId");
    ai_upload_error('Gagal memproses dokumen (masalah koneksi ke layanan AI).');
}

$db->query("UPDATE m_ai_document SET status='processed', processed_at=NOW() WHERE id=$docId");
echo json_encode(array('status' => 'success', 'document_id' => $docId, 'chunks_stored' => $totalChunks - $failedChunks, 'chunks_failed' => $failedChunks));
