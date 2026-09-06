<?php
// classes/ai_doc_processor.php
// Shared text-extraction / chunking / embedding helpers for the AI
// document-upload feature. PHP 5.3-compatible syntax throughout.
// No ZipArchive on this server (PHP 5.6.40, ext-zip not installed) --
// this file parses ZIP local file headers by hand instead.

function ai_read_zip_entry($zipPath, $entryName) {
    $data = @file_get_contents($zipPath);
    if ($data === false || $data === '') {
        return false;
    }

    // Read entry metadata from the Central Directory, not the local file
    // headers -- Word/LibreOffice write entries in "streamed" mode (general
    // purpose flag bit 3 set), which leaves compressed/uncompressed size as
    // 0 in the local header (the real sizes go in a trailing data
    // descriptor instead). The Central Directory always has the real sizes
    // regardless of that flag, so it's the reliable source. See PKZIP
    // APPNOTE sections 4.3.12 (End Of Central Directory) and 4.3.12 (Central
    // Directory Header).
    $eocdPos = strrpos($data, "\x50\x4b\x05\x06");
    if ($eocdPos === false) {
        return false;
    }
    $eocd = unpack('vdisk/vcdDisk/ventries/vtotalEntries/VcdSize/VcdOffset/vcommentLen', substr($data, $eocdPos + 4, 18));
    $pos = $eocd['cdOffset'];
    $totalEntries = $eocd['totalEntries'];

    for ($i = 0; $i < $totalEntries; $i++) {
        if (substr($data, $pos, 4) !== "\x50\x4b\x01\x02") {
            break; // malformed or unexpected structure -- stop rather than misread
        }
        $cdh = unpack(
            'vversionMade/vversionNeeded/vflags/vmethod/vmodtime/vmoddate/Vcrc/VcompSize/VuncompSize/vnameLen/vextraLen/vcommentLen/vdiskStart/vinternalAttr/VexternalAttr/VlocalOffset',
            substr($data, $pos + 4, 42)
        );
        $nameStart = $pos + 46;
        $name = substr($data, $nameStart, $cdh['nameLen']);

        if ($name === $entryName) {
            // Local header's own nameLen/extraLen tell us where the actual
            // compressed data starts; its size fields are ignored in favor
            // of the Central Directory's (see comment above).
            $localHeader = substr($data, $cdh['localOffset'], 30);
            $lh = unpack('vnameLen/vextraLen', substr($localHeader, 26, 4));
            $dataStart = $cdh['localOffset'] + 30 + $lh['nameLen'] + $lh['extraLen'];
            $raw = substr($data, $dataStart, $cdh['compSize']);

            if ($cdh['method'] === 0) {
                return $raw; // stored, no compression
            }
            if ($cdh['method'] === 8) {
                $inflated = @gzinflate($raw);
                return $inflated === false ? false : $inflated;
            }
            return false; // unsupported compression method
        }

        $pos = $nameStart + $cdh['nameLen'] + $cdh['extraLen'] + $cdh['commentLen'];
    }
    return false;
}

function ai_extract_docx_text($filePath) {
    $xml = ai_read_zip_entry($filePath, 'word/document.xml');
    if ($xml === false) {
        return false;
    }
    // Pull text out of every <w:t>...</w:t> run, in document order.
    preg_match_all('/<w:t[^>]*>(.*?)<\/w:t>/s', $xml, $matches);
    $text = implode(' ', $matches[1]);
    $text = html_entity_decode($text, ENT_QUOTES | ENT_XML1, 'UTF-8');
    $text = trim($text);
    return $text;
}

// PDF support deferred: every release of smalot/pdfparser (v1.0.0 through
// current) requires PHP >= 7.1, and this server runs PHP 5.6.40 -- confirmed
// against Packagist, there is no PHP-5.6-compatible release of this library.
// Kept as a stub (rather than removed) so the interface main/api_doc_upload.php
// expects stays stable if/when PDF support is revisited (e.g. a hand-rolled
// FlateDecode-based extractor, or an out-of-process conversion step).
function ai_extract_pdf_text($filePath) {
    return false;
}

function ai_chunk_text($text, $chunkSize = 700, $overlap = 75) {
    $text = trim(preg_replace('/\s+/', ' ', $text));
    $length = strlen($text);
    if ($length === 0) {
        return array();
    }
    if ($length <= $chunkSize) {
        return array($text);
    }

    $chunks = array();
    $start = 0;
    while ($start < $length) {
        $end = min($start + $chunkSize, $length);
        if ($end < $length) {
            // Prefer to break at the last sentence boundary within this
            // window; fall back to the last space; fall back to a hard cut.
            $window = substr($text, $start, $end - $start);
            $lastBoundary = false;
            foreach (array('. ', '! ', '? ') as $sep) {
                $sepPos = strrpos($window, $sep);
                if ($sepPos !== false && ($lastBoundary === false || $sepPos > $lastBoundary)) {
                    $lastBoundary = $sepPos + strlen($sep) - 1; // keep the space out
                }
            }
            if ($lastBoundary === false) {
                $lastBoundary = strrpos($window, ' ');
            }
            if ($lastBoundary !== false && $lastBoundary > 0) {
                $end = $start + $lastBoundary + 1;
            }
        }
        $chunks[] = trim(substr($text, $start, $end - $start));
        if ($end >= $length) {
            break;
        }
        $start = max($end - $overlap, $start + 1); // always make forward progress
    }
    return array_values(array_filter($chunks, function ($c) { return $c !== ''; }));
}

function ai_get_embedding($text, $apiKey) {
    $payload = array(
        'content' => array(
            'parts' => array(array('text' => $text)),
        ),
    );
    // gemini-embedding-001 -- confirmed via a live ListModels call against
    // the current key that text-embedding-004 (the plan's original model
    // name) is retired; gemini-embedding-001 is the current stable
    // embedContent-capable model.
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent?key=' . $apiKey;
    $context = stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-Type: application/json',
            'content' => json_encode($payload),
            'ignore_errors' => true,
        ),
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
        ),
    ));
    $response = @file_get_contents($url, false, $context);
    if ($response === false) {
        return false;
    }
    $data = json_decode($response, true);
    if (isset($data['embedding']['values']) && is_array($data['embedding']['values'])) {
        return $data['embedding']['values'];
    }
    return false;
}

// Fallback chat completion via Groq -- called from main/api_chat.php only
// after every retry against Gemini has already failed (quota exhausted,
// Gemini-side outage, auth misconfiguration, anything), so the widget
// still answers instead of surfacing an error. Groq's API is
// OpenAI-compatible (POST /openai/v1/chat/completions, Bearer auth,
// messages: [{role, content}]), a different shape from Gemini's
// contents: [{role, parts:[{text}]}] with a separate system_instruction
// field -- $geminiMessages and $systemInstruction are translated into
// one OpenAI-style messages array here (system message first, then
// user/model turns with 'model' mapped to 'assistant').
// openai/gpt-oss-120b -- confirmed live via a real key against Groq's own
// /openai/v1/models listing (llama-3.3-70b-versatile, this function's
// original pick, no longer exists on Groq's current lineup). Large
// general-purpose open model, big context window, good instruction
// following; swap this one constant if Groq's lineup changes again.
function ai_call_groq_fallback($geminiMessages, $systemInstruction, $apiKey) {
    $groqModel = 'openai/gpt-oss-120b';

    $openaiMessages = array();
    $openaiMessages[] = array('role' => 'system', 'content' => $systemInstruction);
    foreach ($geminiMessages as $msg) {
        if (!isset($msg['role']) || !isset($msg['parts'][0]['text'])) {
            continue;
        }
        $openaiMessages[] = array(
            'role' => ($msg['role'] === 'model') ? 'assistant' : 'user',
            'content' => $msg['parts'][0]['text'],
        );
    }

    $payload = array(
        'model' => $groqModel,
        'messages' => $openaiMessages,
        'temperature' => 0.7,
        'max_tokens' => 1000,
        // gpt-oss-120b is a reasoning model -- confirmed live: without this,
        // it spent 262 of a 500-token budget on its internal reasoning
        // trace before writing anything visible, cutting the actual answer
        // off mid-sentence (finishReason "length"), the exact same failure
        // class already fixed for Gemini's own thinkingConfig above.
        // reasoning_effort=low dropped that to ~34 tokens, leaving the rest
        // for a complete answer.
        'reasoning_effort' => 'low',
    );

    $context = stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'header'  => "Content-Type: application/json\r\nAuthorization: Bearer $apiKey",
            'content' => json_encode($payload),
            'ignore_errors' => true,
        ),
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
        ),
    ));

    $response = @file_get_contents('https://api.groq.com/openai/v1/chat/completions', false, $context);
    if ($response === false) {
        return false;
    }
    $data = json_decode($response, true);
    if (isset($data['choices'][0]['message']['content'])) {
        return ai_strip_markdown($data['choices'][0]['message']['content']);
    }
    return false;
}

// gpt-oss-120b keeps using **bold**/bullet markdown even when told point-
// blank not to (confirmed live -- an explicit "this is an absolute rule,
// not a suggestion" system instruction still didn't stop it), unlike
// Gemini which reliably follows the same instruction already in
// $systemInstruction. Since the chat widget renders replies as raw text
// with no markdown parser (see main/api_chat.php's own no-markdown
// instruction for why that matters), this strips the common markdown
// syntax server-side as a guarantee instead of relying purely on the
// model's instruction-following.
function ai_strip_markdown($text) {
    $text = preg_replace('/\*\*(.+?)\*\*/s', '$1', $text);
    $text = preg_replace('/\*(.+?)\*/s', '$1', $text);
    $text = preg_replace('/`(.+?)`/s', '$1', $text);
    $text = preg_replace('/^#{1,6}\s*/m', '', $text);
    $text = preg_replace('/^[ \t]*[-*]\s+/m', '', $text);
    $text = str_replace('*', '', $text);
    return $text;
}

function ai_cosine_similarity($vecA, $vecB) {
    $len = min(count($vecA), count($vecB));
    if ($len === 0) {
        return 0.0;
    }
    $dot = 0.0;
    $normA = 0.0;
    $normB = 0.0;
    for ($i = 0; $i < $len; $i++) {
        $dot += $vecA[$i] * $vecB[$i];
        $normA += $vecA[$i] * $vecA[$i];
        $normB += $vecB[$i] * $vecB[$i];
    }
    if ($normA <= 0.0 || $normB <= 0.0) {
        return 0.0;
    }
    return $dot / (sqrt($normA) * sqrt($normB));
}

// Maps this app's existing login session into the document-role bucket(s)
// ("Dokumen Training AI" categories) relevant to whoever is asking, per the
// $_SESSION['Priv'] vocabulary the user confirmed directly:
//   administrator          -> Admin      -> everything (null = no filter)
//   sponsor                -> Pebisnis   -> pebisnis + jamaah
//   '' or -1                -> member/jamaah/not logged in -> jamaah
//   korwil or subkorwil     -> Korwil     -> korwil only
//   seller                 -> Seller     -> seller only
// Not logged in at all ("Umum" on the public login page) is checked first
// and takes priority over any of the above -> visitor + jamaah + seller + pebisnis.
// Returns an array of role strings to search, or null to mean "search every
// role" -- used for admin (deliberately unrestricted) and for any Priv
// value not in this list (falls back to "search everything" rather than
// guessing wrong).
function ai_detect_chat_role() {
    $isLoggedIn = isset($_SESSION['LoginUser']) && $_SESSION['LoginUser'] !== '';

    if (!$isLoggedIn) {
        return array('visitor', 'jamaah', 'seller', 'pebisnis');
    }
    if (isset($_SESSION['Kind']) && $_SESSION['Kind'] === 'member') {
        return array('jamaah');
    }
    if (isset($_SESSION['Priv'])) {
        $priv = $_SESSION['Priv'];
        if ($priv === 'administrator') {
            return null;
        }
        if ($priv === 'seller') {
            return array('seller');
        }
        if ($priv === 'sponsor') {
            return array('pebisnis', 'jamaah');
        }
        if ($priv === 'korwil' || $priv === 'subkorwil') {
            return array('korwil');
        }
        if ($priv === '' || $priv === -1 || $priv === '-1') {
            return array('jamaah');
        }
    }
    return null;
}

// Human-readable label for whatever ai_detect_chat_role() returned, meant
// to be told to the model in the system instruction -- otherwise it has no
// way to know a category was even detected, and when asked directly tends
// to give a generic "for privacy I don't know who you are" non-answer
// (confirmed live) even though role detection is real and already
// happening server-side. Telling it the category directly lets it answer
// that question honestly instead of guessing/deflecting.
function ai_chat_role_label($roles) {
    if ($roles === null) {
        return 'Admin (akses ke semua kategori dokumen)';
    }
    $labels = array(
        'visitor'  => 'Visitor',
        'jamaah'   => 'Jamaah',
        'pebisnis' => 'Pebisnis',
        'seller'   => 'Seller',
        'korwil'   => 'Korwil',
    );
    $names = array();
    foreach ($roles as $r) {
        $names[] = isset($labels[$r]) ? $labels[$r] : $r;
    }
    return implode(', ', $names);
}

// Human-facing single role name for greetings/UI, distinct from
// ai_detect_chat_role()'s document-search scope (which can span more than
// one category -- e.g. Pebisnis searches pebisnis+jamaah documents, but
// the user's own identity to display is just "Pebisnis"). Returns null
// when not logged in or unrecognized, meaning: don't mention a role.
function ai_chat_role_display_name() {
    $isLoggedIn = isset($_SESSION['LoginUser']) && $_SESSION['LoginUser'] !== '';
    if (!$isLoggedIn) {
        return null;
    }
    if (isset($_SESSION['Kind']) && $_SESSION['Kind'] === 'member') {
        return 'Jamaah';
    }
    if (isset($_SESSION['Priv'])) {
        $priv = $_SESSION['Priv'];
        if ($priv === 'administrator') {
            return 'Admin';
        }
        if ($priv === 'seller') {
            return 'Seller';
        }
        if ($priv === 'sponsor') {
            return 'Pebisnis';
        }
        if ($priv === 'korwil' || $priv === 'subkorwil') {
            return 'Korwil';
        }
        if ($priv === '' || $priv === -1 || $priv === '-1') {
            return 'Jamaah';
        }
    }
    return null;
}

// Retrieves the top-K most relevant chunks for a query embedding. $roles
// may be an array of role strings (only those roles' documents are
// searched) or null (search across every role -- unchanged from before
// role detection existed). $db must be an already-connected
// DB_MySQL-family object.
function ai_retrieve_relevant_chunks($db, $queryEmbedding, $topK = 5, $minSimilarity = 0.5, $roles = null) {
    if ($roles !== null && count($roles) > 0) {
        $escapedRoles = array();
        foreach ($roles as $r) {
            $escapedRoles[] = "'" . mysql_real_escape_string($r) . "'";
        }
        $inList = implode(',', $escapedRoles);
        $db->query("select chunk_text, embedding from m_ai_document_chunk where role in ($inList)");
    } else {
        $db->query("select chunk_text, embedding from m_ai_document_chunk");
    }
    $scored = array();
    while ($db->next_record()) {
        $embeddingJson = $db->f('embedding');
        $vec = json_decode($embeddingJson, true);
        if (!is_array($vec)) {
            continue;
        }
        $sim = ai_cosine_similarity($queryEmbedding, $vec);
        if ($sim >= $minSimilarity) {
            $scored[] = array('text' => $db->f('chunk_text'), 'similarity' => $sim);
        }
    }
    usort($scored, function ($a, $b) {
        if ($a['similarity'] == $b['similarity']) {
            return 0;
        }
        return ($a['similarity'] < $b['similarity']) ? 1 : -1;
    });
    return array_slice($scored, 0, $topK);
}

// Categorizes user inquiry into high-level business topics
function ai_detect_chat_topic($text) {
    $t = strtolower((string)$text);
    if (preg_match('/(daftar|registrasi|cara gabung|join|referral|pebisnis baru|member baru|formulir|ktp|syarat)/i', $t)) {
        return 'Pendaftaran & Registrasi';
    }
    if (preg_match('/(bonus|komisi|saldo|voucher|withdraw|penarikan|dompet|wallet|transfer|bayar|reward|cair|rekening)/i', $t)) {
        return 'Bonus, Komisi & Saldo';
    }
    if (preg_match('/(umrah|umroh|tour|paket|jadwal|keberangkatan|tiket|visa|hotel|pesawat|travel|makkah|madinah|jamaah|haji)/i', $t)) {
        return 'Paket Umrah & Tour';
    }
    if (preg_match('/(produk|barang|ro|repeat order|stok|pesanan|belanja|beli|ongkir|ekspedisi|kurir|jne|jnt|resi)/i', $t)) {
        return 'Produk & Repeat Order';
    }
    if (preg_match('/(jaringan|downline|upline|sponsor|korwil|subkorwil|seller|binaan|omset|titik|pohon|genealogi)/i', $t)) {
        return 'Jaringan & Member';
    }
    if (preg_match('/(password|login|lupa|reset|sandi|keamanan|username|akun|ganti password)/i', $t)) {
        return 'Akun & Keamanan';
    }
    return 'Lainnya / Umum';
}

// Logs incoming chat questions & answers into m_ai_chat_log for Analitik Percakapan
function ai_log_chat_interaction($db, $role, $userId, $userMessage, $botResponse, $status = 'success') {
    if (!$db || trim((string)$userMessage) === '') {
        return false;
    }
    $roleEsc = mysql_real_escape_string(substr((string)$role, 0, 50));
    $userEsc = mysql_real_escape_string(substr((string)$userId, 0, 50));
    $msgEsc = mysql_real_escape_string($userMessage);
    $respEsc = mysql_real_escape_string((string)$botResponse);
    $topic = ai_detect_chat_topic($userMessage);
    $topicEsc = mysql_real_escape_string($topic);
    $statusEsc = mysql_real_escape_string(substr((string)$status, 0, 20));
    
    $sql = "INSERT INTO m_ai_chat_log (user_id, role, user_message, bot_response, topic, status, created_at)
            VALUES ('$userEsc', '$roleEsc', '$msgEsc', '$respEsc', '$topicEsc', '$statusEsc', NOW())";
    return @$db->query($sql);
}
