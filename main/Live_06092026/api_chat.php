<?php
// This file is hit directly as a standalone AJAX endpoint (no admin_headside
// include ahead of it like normal pages get), so it can't assume something
// upstream already called session_start() -- confirmed live: role detection
// intermittently read as if nobody was logged in, or as a different account,
// even on a page where the browser was clearly logged in as a specific
// admin. Starting the session explicitly here removes that dependency.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// CORS: lets the standalone menu.amhtechno.com PWA (a separate origin with
// no login of its own) call this endpoint directly from the browser.
// Every request from there arrives with no session cookie regardless (it's
// a different origin, nothing to send), so this doesn't expose anything a
// not-logged-in visitor on this site's own public login page couldn't
// already get -- ai_detect_chat_role() below treats it the same as an
// anonymous visitor. Access-Control-Allow-Origin echoes back one of a
// fixed, known list of origins (rather than "*") so this stays open to
// adding credentialed cross-origin requests later without a rewrite -- add
// more trusted AMH Techno origins to the list if another property needs
// the same access.
$allowedChatOrigins = array(
    'https://menu.amhtechno.com',
    'http://menu.amhtechno.com'
);
if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedChatOrigins, true)) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Credentials: true');
    header('Vary: Origin');
}
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Preflight request only -- the browser sends this before the real POST
    // because of the JSON Content-Type header; nothing below needs to run.
    http_response_code(200);
    exit;
}

set_time_limit(120); // embedding call + retrieval + generateContent (+ a
                      // possible retry on connection failure) can add up;
                      // default max_execution_time is 30s on this host.

include_once "../server/config.php";
include_once "../classes/ai_doc_processor.php";

// Reuses the same key/constant sub-project A's embedding calls already use
// (defined in server/config.php). This file's own previously-hardcoded key
// was found to be invalid/expired during the RAG integration work, and
// gemini-flash-latest (below) was found to be a deprecated/overloaded
// alias -- both replaced together.
$gemini_api_key = GEMINI_EMBEDDING_API_KEY;

// Menerima raw POST data (JSON)
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

if (!$input || !isset($input['messages'])) {
    echo json_encode(['status' => 'error', 'message' => 'Format request tidak valid.']);
    exit;
}

// Format messages untuk Gemini API (Google AI Studio)
$messages = $input['messages'];

// --- RAG retrieval -------------------------------------------------------
// Finds relevant chunks from documents uploaded via the "Dokumen Training
// AI" admin feature and injects them into the system instruction.
// ai_detect_chat_role() maps the logged-in session (administrator/seller/
// sponsor/member) to one of the 6 document-role buckets, so only documents
// relevant to whoever is asking get searched; it returns null (search
// every role) when the account type isn't one it recognizes yet (e.g.
// korwil) or nobody is logged in. If embedding the question fails, or
// nothing scores above the similarity threshold, $retrieved_context stays
// empty and the chat proceeds exactly as before -- this never blocks a reply.
$retrieved_context = "";
$last_user_message = "";
for ($i = count($messages) - 1; $i >= 0; $i--) {
    if (isset($messages[$i]['role']) && $messages[$i]['role'] === 'user'
        && isset($messages[$i]['parts'][0]['text'])) {
        $last_user_message = $messages[$i]['parts'][0]['text'];
        break;
    }
}
$chat_role = ai_detect_chat_role(); // computed regardless of $last_user_message -- also used in the system instruction below

// Release the session file lock now that role detection is done, BEFORE
// the slow external calls below (embedding + generateContent, each a
// multi-second file_get_contents to Google's API, with set_time_limit(120)
// and a retry on top). PHP's default file session handler holds an
// exclusive lock on the session file for as long as it stays open --
// without this, any OTHER request from the same browser session (a page
// navigation, the dashboard's currency-ticker poll, a second chat message)
// blocks waiting for that lock, and on this host that contention was
// confirmed live to sometimes resolve as a completely empty $_SESSION for
// the other request instead of just waiting -- session_keys:[] even with
// a valid, matching PHPSESSID cookie, traced via a diagnostic script that
// caught the underlying session file at 0 bytes mid-write. That emptied
// session then made ai_detect_chat_role() fall back to the "not logged
// in" bucket, silently cutting off all 45 admin-role document chunks from
// retrieval -- confirmed as the direct cause of wrong/hallucinated
// answers on questions whose real answer only lived in the admin bucket
// (e.g. the official TikTok/Instagram accounts), while questions with a
// partial match in the public buckets got a related-but-incomplete reply
// instead of an outright wrong one.
$sessionUserId = isset($_SESSION['LoginUser']) ? $_SESSION['LoginUser'] : '';
if (session_status() === PHP_SESSION_ACTIVE) {
    session_write_close();
}

if ($last_user_message !== "") {
    $query_embedding = ai_get_embedding($last_user_message, $gemini_api_key);
    if ($query_embedding !== false) {
        $relevant_chunks = ai_retrieve_relevant_chunks($db, $query_embedding, 5, 0.5, $chat_role);
        if (count($relevant_chunks) > 0) {
            $context_parts = array();
            foreach ($relevant_chunks as $chunk) {
                $context_parts[] = $chunk['text'];
            }
            $retrieved_context = "\n\nInformasi relevan dari dokumen internal:\n" . implode("\n---\n", $context_parts);
        }
    }
}

// Konteks pengetahuan / System Instruction
// Explicitly telling the model which category was detected (rather than
// leaving it to guess) matters: asked directly "do you know my role?"
// without this line, the model gave a generic "for privacy I don't know
// who you are" non-answer -- confirmed live -- even though the category
// detection is real and already scoping its document context below. This
// lets it answer that question honestly instead of deflecting.
$chat_role_label = ai_chat_role_label($chat_role);
$system_instruction = "Anda adalah AI Assistant untuk sistem AMH Techno (Aplikasi MLM, e-commerce, dan tour booking). Tugas Anda membantu pengguna memahami cara kerja sistem, cara klaim bonus, dan informasi umum bisnis ini. Jawablah dengan bahasa Indonesia yang ramah, profesional, dan ringkas. Jika ada bagian \"Informasi relevan dari dokumen internal\" di bawah, utamakan jawaban berdasarkan informasi tersebut.\n\nSalam: kalau ini pesan PERTAMA dari pengguna dalam percakapan ini (belum ada balasan Anda sebelumnya), buka jawaban dengan salam \"Assalamu'alaikum warahmatullahi wabarakatuh\" -- JANGAN pakai \"Halo\" atau sapaan generik lain di pesan pertama. Untuk pesan-pesan berikutnya dalam percakapan yang sama, tidak perlu mengulang salam ini lagi, langsung ke jawabannya saja.\n\nPenting soal format: jawab dengan teks polos saja, JANGAN pakai format markdown sama sekali -- jangan pakai tanda bintang (**tebal** atau *miring*), jangan pakai tanda pagar (# heading), jangan pakai backtick (`kode`), dan jangan pakai tanda hubung/bintang di awal baris untuk bullet list. Kalau perlu membuat daftar, tulis pakai angka biasa seperti \"1. \", \"2. \" atau baris baru biasa, karena tampilan chat ini menampilkan teks apa adanya dan tidak merender markdown -- kalau dipaksa pakai markdown, tanda-tandanya akan muncul mentah-mentah ke pengguna.\n\nKonteks internal (bukan rahasia, boleh disampaikan jika ditanya): sistem sudah mendeteksi kategori pengguna yang sedang chat saat ini sebagai \"$chat_role_label\", dan otomatis mencari dokumen internal yang relevan dengan kategori tersebut sebelum menjawab. Ini bukan pelacakan data pribadi -- ini cuma penyaringan dokumen berdasarkan jenis akun yang sedang login, supaya jawaban lebih relevan. Jika pengguna bertanya soal ini, jawab dengan jujur dan jelaskan mekanismenya secara singkat, jangan menolak/mengelak seolah tidak tahu." . $retrieved_context;

$payload = [
    "system_instruction" => [
        "parts" => [
            ["text" => $system_instruction]
        ]
    ],
    "contents" => $messages,
    "generationConfig" => [
        "temperature" => 0.7,
        // gemini-3.6-flash spends part of maxOutputTokens on internal
        // "thinking" before the visible answer -- confirmed live: with the
        // old maxOutputTokens=800 and no thinkingConfig, a real question
        // ("proses pendaftaran umroh") burned 765 of those 800 tokens on
        // thinking alone, cutting the visible reply off after ~30 tokens
        // (finishReason MAX_TOKENS). thinkingLevel=low (gemini-3.6-flash
        // can't fully disable thinking) plus a much higher ceiling fixes
        // it -- retested with both, finishReason came back STOP with a
        // full ~2000-character answer and thinking dropped to ~290 tokens.
        "maxOutputTokens" => 2048,
        "thinkingConfig" => [
            "thinkingLevel" => "low",
        ],
    ]
];

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.6-flash:generateContent?key=" . $gemini_api_key;

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

// Up to 3 attempts total (1 initial + 2 retries), retrying on: (a) an
// outright connection-level failure (file_get_contents returning false
// before any HTTP response was even received -- confirmed live as an
// intermittent network blip between this host and Google's API), (b) HTTP
// 503 UNAVAILABLE -- confirmed live via debug_raw_error as Google's own
// "This model is currently experiencing high demand... usually temporary"
// message, or (c) HTTP 429 RESOURCE_EXHAUSTED -- confirmed live this
// project's actual free-tier limit is a real GenerateRequestsPerMinute...
// quotaValue of just 5 (not the 15 RPM the general docs describe), so 429
// is a routine, frequently-hit condition here, not just a rare abuse
// signal -- worth retrying, unlike a guessed-at delay would be, because
// Google's own 429 response body includes a precise
// RetryInfo.retryDelay (e.g. "1.3s") naming exactly how long until the
// per-minute window allows the next request; honoring that is far more
// reliable than picking an arbitrary wait. 401/403 (auth problems) are
// still NOT retried -- no delay fixes those. Each retry's base delay is
// 0.5s/1.5s (503 or connection failure) or Google's own suggested delay
// (429, capped at 5s so a single reply can't eat the whole request),
// plus up to +-20% random jitter so that if several of this widget's
// users happen to hit an error at the same moment, their retries spread
// out instead of all landing on Google's API in the same instant -- a
// low-traffic widget like this one is in no danger of causing that
// itself, but it's a one-line difference to do it the standard-correct
// way regardless.
$maxAttempts = 3;
$retryDelaysUsec = [500000, 1500000]; // 0.5s, 1.5s base -- one per retry, not per attempt
$response = false;
$http_code = 0;
for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
    $response = @file_get_contents($url, false, $context);
    $http_code = 0;
    if ($response !== false && isset($http_response_header[0])) {
        preg_match('#HTTP/[\d\.]+\s+(\d+)#i', $http_response_header[0], $matches);
        if (isset($matches[1])) {
            $http_code = intval($matches[1]);
        }
    }
    $shouldRetry = ($response === false || $http_code === 503 || $http_code === 429);
    if (!$shouldRetry || $attempt === $maxAttempts - 1) {
        break;
    }
    $baseDelay = $retryDelaysUsec[$attempt];
    if ($http_code === 429 && $response !== false) {
        $errBody = json_decode($response, true);
        if (isset($errBody['error']['details']) && is_array($errBody['error']['details'])) {
            foreach ($errBody['error']['details'] as $detail) {
                if (isset($detail['retryDelay']) && preg_match('/^([\d.]+)s$/', $detail['retryDelay'], $m)) {
                    $baseDelay = min((int)(floatval($m[1]) * 1000000), 5000000); // cap at 5s
                    break;
                }
            }
        }
    }
    $jitteredDelay = $baseDelay + mt_rand(-(int)($baseDelay * 0.2), (int)($baseDelay * 0.2));
    usleep($jitteredDelay);
}

// Gemini failed after every retry above (connection failure OR a non-200
// status) -- try Groq as a fallback before giving up, so the widget still
// answers instead of showing an error. Covers every failure type per
// explicit request (quota exhaustion, Gemini-side outage, our own auth
// misconfiguration, anything) rather than just the retried ones.
$logRole = is_array($chat_role) ? implode(',', $chat_role) : ($chat_role ? $chat_role : 'visitor');

if ($response === false || $http_code != 200) {
    if (function_exists('ai_call_groq_fallback') && defined('GROQ_API_KEY')) {
        $groqReply = ai_call_groq_fallback($messages, $system_instruction, GROQ_API_KEY);
        if ($groqReply !== false) {
            if (function_exists('ai_log_chat_interaction')) {
                ai_log_chat_interaction($db, $logRole, $sessionUserId, $last_user_message, $groqReply, 'success');
            }
            echo json_encode(['status' => 'success', 'message' => $groqReply]);
            exit;
        }
    }
}

if ($response === false) {
    if (function_exists('ai_log_chat_interaction')) {
        ai_log_chat_interaction($db, $logRole, $sessionUserId, $last_user_message, 'Gagal menghubungi server AI (Koneksi ditolak server).', 'error');
    }
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghubungi server AI (Koneksi ditolak server).']);
    exit;
}

if ($http_code != 200) {
    // Jika API Key belum diubah, kita deteksi di sini
    if (strpos($gemini_api_key, 'KUNCI_API') !== false) {
         echo json_encode(['status' => 'error', 'message' => 'API Key Gemini belum diset oleh Admin.']);
         exit;
    }

    // User-facing message for common cases
    if ($http_code == 429) {
        $friendlyMsg = 'Sistem AI sedang sibuk (terlalu banyak permintaan). Coba lagi dalam beberapa saat.';
    } elseif ($http_code == 401 || $http_code == 403) {
        $friendlyMsg = 'Sistem AI belum terhubung dengan benar. Mohon hubungi admin.';
    } elseif ($http_code >= 500) {
        $friendlyMsg = 'Server AI sedang gangguan. Coba lagi dalam beberapa saat.';
    } else {
        $errData = json_decode($response, true);
        $friendlyMsg = isset($errData['error']['message']) ? $errData['error']['message'] : 'Gagal menghubungi server AI.';
    }
    if (function_exists('ai_log_chat_interaction')) {
        ai_log_chat_interaction($db, $logRole, $sessionUserId, $last_user_message, $friendlyMsg, 'error');
    }
    $rawErrData = json_decode($response, true);
    echo json_encode([
        'status' => 'error',
        'message' => $friendlyMsg,
        'debug_http_code' => $http_code,
        'debug_raw_error' => isset($rawErrData['error']) ? $rawErrData['error'] : $response,
        'debug_fallback_tried' => 'groq (also failed)',
    ]);
    exit;
}

$responseData = json_decode($response, true);

if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
    $botText = $responseData['candidates'][0]['content']['parts'][0]['text'];
    if (function_exists('ai_log_chat_interaction')) {
        ai_log_chat_interaction($db, $logRole, $sessionUserId, $last_user_message, $botText, 'success');
    }
    echo json_encode(['status' => 'success', 'message' => $botText]);
} else {
    if (function_exists('ai_log_chat_interaction')) {
        ai_log_chat_interaction($db, $logRole, $sessionUserId, $last_user_message, 'Respons tidak dikenali dari server AI.', 'error');
    }
    echo json_encode(['status' => 'error', 'message' => 'Respons tidak dikenali dari server AI.']);
}
?>
