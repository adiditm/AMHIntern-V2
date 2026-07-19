<?php
header('Content-Type: application/json');

// Jika belum diset di server/config.php, kita bisa taruh sementara di sini atau ambil dari database
$gemini_api_key = "AQ.Ab8RN6IDzngZ1_6MynN398RnPHx6eKq__mKRmaf3tadJtNSsvQ"; // TODO: Ganti dengan API Key yang valid, atau letakkan di config.php

// Menerima raw POST data (JSON)
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

if (!$input || !isset($input['messages'])) {
    echo json_encode(['status' => 'error', 'message' => 'Format request tidak valid.']);
    exit;
}

// Konteks pengetahuan / System Instruction
$system_instruction = "Anda adalah AI Assistant untuk sistem AMH Techno (Aplikasi MLM, e-commerce, dan tour booking). Tugas Anda membantu pengguna memahami cara kerja sistem, cara klaim bonus, dan informasi umum bisnis ini. Jawablah dengan bahasa Indonesia yang ramah, profesional, dan ringkas.";

// Format messages untuk Gemini API (Google AI Studio)
$messages = $input['messages'];

$payload = [
    "system_instruction" => [
        "parts" => [
            ["text" => $system_instruction]
        ]
    ],
    "contents" => $messages,
    "generationConfig" => [
        "temperature" => 0.7,
        "maxOutputTokens" => 800,
    ]
];

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=" . $gemini_api_key;

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode($payload),
        'ignore_errors' => true
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false
    ]
]);

$response = @file_get_contents($url, false, $context);

if ($response === false) {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghubungi server AI (Koneksi ditolak server).']);
    exit;
}

// Mendapatkan HTTP code dari $http_response_header (variabel ajaib bawaan PHP)
$http_code = 200;
if (isset($http_response_header[0])) {
    preg_match('#HTTP/[\d\.]+\s+(\d+)#i', $http_response_header[0], $matches);
    if (isset($matches[1])) {
        $http_code = intval($matches[1]);
    }
}

if ($http_code != 200) {
    // Jika API Key belum diubah, kita deteksi di sini
    if (strpos($gemini_api_key, 'KUNCI_API') !== false) {
         echo json_encode(['status' => 'error', 'message' => 'API Key Gemini belum diset oleh Admin.']);
         exit;
    }
    
    $errData = json_decode($response, true);
    $errMsg = isset($errData['error']['message']) ? $errData['error']['message'] : 'Gagal menghubungi server AI.';
    echo json_encode(['status' => 'error', 'message' => "HTTP $http_code: $errMsg"]);
    exit;
}

$responseData = json_decode($response, true);

if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
    $botText = $responseData['candidates'][0]['content']['parts'][0]['text'];
    echo json_encode(['status' => 'success', 'message' => $botText]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Respons tidak dikenali dari server AI.']);
}
?>
