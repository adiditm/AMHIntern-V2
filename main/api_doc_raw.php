<?php
// main/api_doc_raw.php
// Streams the ORIGINAL uploaded .docx file's raw bytes for one document,
// gated behind the same login check every other AI-doc endpoint uses --
// the file lives under uploads/ai_docs/ (inside the public web root, see
// main/api_doc_upload.php's $destDir), so without this gate the raw file
// would be reachable by anyone who guessed/found its path directly. The
// "Lihat" modal on masterdata/aitraindocs.php fetches this as an
// ArrayBuffer and renders it client-side with mammoth.js -- this endpoint
// only ever serves bytes, no HTML.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "../server/config.php";

if (!isset($_SESSION['LoginUser']) || $_SESSION['LoginUser'] === '') {
    header('HTTP/1.1 403 Forbidden');
    header('Content-Type: text/plain');
    echo 'Login diperlukan.';
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header('HTTP/1.1 400 Bad Request');
    exit;
}

$db->query("select filename, filepath from m_ai_document where id=$id");
if (!$db->next_record()) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
$filename = $db->f('filename');
$filepath = $db->f('filepath');

if (!$filepath || !file_exists($filepath)) {
    header('HTTP/1.1 404 Not Found');
    header('Content-Type: text/plain');
    echo 'File tidak ditemukan di server.';
    exit;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: inline; filename="' . basename($filename) . '"');
header('Content-Length: ' . filesize($filepath));
readfile($filepath);
