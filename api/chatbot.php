<?php
/**
 * ═══════════════════════════════════════════════════════════
 * YEN-Bot — AI Chatbot API Endpoint
 * ═══════════════════════════════════════════════════════════
 * 
 * HYBRID ARCHITECTURE:
 *   1. User message arrives via POST
 *   2. PHP checks chat_faqs table for keyword match
 *   3. If match → return instant predefined answer
 *   4. If no match → send to Gemini API with system prompt
 *   5. Return JSON response to frontend
 * 
 * ENDPOINT: POST /api/chatbot.php
 * PAYLOAD:  { "message": "user's question" }
 * RESPONSE: { "reply": "bot's answer", "source": "faq|ai" }
 */

// ─── CORS & Headers ────────────────────────────────────────
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed. Use POST.']);
    exit;
}

// ─── Get the user's message ────────────────────────────────
$input = json_decode(file_get_contents('php://input'), true);
$user_message = trim($input['message'] ?? '');

if (empty($user_message)) {
    echo json_encode(['error' => 'Message cannot be empty.']);
    exit;
}

// ─── Database Connection ───────────────────────────────────
require_once '../db.php';

// ─── STEP 1: Check FAQ Database (Priority) ─────────────────
$faq_answer = checkFAQs($conn, $user_message);

if ($faq_answer !== null) {
    // FAQ match found — return instantly without touching Gemini
    echo json_encode([
        'reply'  => $faq_answer,
        'source' => 'faq'
    ]);
    exit;
}

// ─── STEP 2: No FAQ match — Ask Gemini AI ──────────────────
$ai_answer = askGemini($user_message);

echo json_encode([
    'reply'  => $ai_answer,
    'source' => 'ai'
]);
exit;


// ═══════════════════════════════════════════════════════════
// FUNCTIONS
// ═══════════════════════════════════════════════════════════

/**
 * checkFAQs() — Scan the chat_faqs table for keyword matches
 * 
 * HOW IT WORKS:
 *   - Takes the user's message and converts it to lowercase
 *   - Fetches all active FAQ rows from the database
 *   - For each FAQ, checks if ANY of its keywords appear in the message
 *   - Returns the answer of the BEST match (most keyword hits)
 *   - Returns null if no keywords match at all
 */
function checkFAQs($conn, $message) {
    $message = strtolower($message);
    
    // Fetch all active FAQs
    $result = mysqli_query($conn, "SELECT keywords, answer FROM chat_faqs WHERE active = 1");
    
    if (!$result || mysqli_num_rows($result) === 0) {
        return null;
    }
    
    $best_match = null;
    $best_score = 0;
    
    while ($row = mysqli_fetch_assoc($result)) {
        $keywords = explode(',', strtolower($row['keywords']));
        $score = 0;
        
        foreach ($keywords as $keyword) {
            $keyword = trim($keyword);
            if (!empty($keyword) && strpos($message, $keyword) !== false) {
                $score++;
            }
        }
        
        // Keep the FAQ with the most keyword matches
        if ($score > $best_score) {
            $best_score = $score;
            $best_match = $row['answer'];
        }
    }
    
    // Only return if we had at least 1 keyword match
    return ($best_score > 0) ? $best_match : null;
}


/**
 * askGemini() — Send a question to Google Gemini API
 * 
 * HOW IT WORKS:
 *   - Constructs a system prompt that defines YEN-Bot's personality
 *   - Sends a POST request to the Gemini REST API via cURL
 *   - Parses the JSON response and extracts the text
 *   - Returns a safe fallback message if anything goes wrong
 */
function askGemini($message) {
    // ─── API Configuration ─────────────────────────────────
    $api_key = 'AIzaSyDVfPbvk6E3GBomXdP6tYbQHqV9meUe79s';
    $model   = 'gemini-2.0-flash';
    $url     = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$api_key}";
    
    // ─── System Prompt (YEN-Bot's Personality & Rules) ─────
    $system_prompt = <<<PROMPT
You are YEN-Bot, the official AI library assistant for Yenepoya (Deemed to be University) Libraries, Mangalore, India.

RULES YOU MUST FOLLOW:
1. You ONLY answer questions related to libraries, books, academics, research, and university services.
2. If someone asks something unrelated (politics, entertainment, personal advice, coding, etc.), politely decline and redirect them to library topics.
3. NEVER fabricate or hallucinate information. If you don't know something specific about Yenepoya Libraries, say "I'm not sure about that. Please contact the library help desk at library@yenepoya.edu.in for accurate information."
4. For book searches, ALWAYS direct users to the OPAC system: https://opac.yenepoya.edu.in
5. For remote access queries, direct users to MyLOFT/Knimbus portal.
6. Keep responses concise, friendly, and helpful. Use bullet points and formatting when appropriate.
7. You may use emojis sparingly to be friendly.
8. Always respond in English unless the user writes in another language.

ABOUT YENEPOYA LIBRARIES:
- Part of Yenepoya (Deemed to be University), Mangalore, Karnataka
- 6 library branches across campus (Central, Medical, Dental, Pharmacy, Nursing, Ayurveda)
- Collection: 53,000+ print books, 2.1M+ e-resources, 8,000+ e-journals, 1,200+ print journals
- E-resources include: ClinicalKey, Scopus, ProQuest, PubMed, DOAJ
- Remote access via MyLOFT/Knimbus
- Plagiarism checking via Turnitin
- Reference management support via Zotero

Your tone should be: professional, warm, and helpful — like a friendly librarian.
PROMPT;

    // ─── Build the API Request Payload ─────────────────────
    $payload = [
        'system_instruction' => [
            'parts' => [
                ['text' => $system_prompt]
            ]
        ],
        'contents' => [
            [
                'parts' => [
                    ['text' => $message]
                ]
            ]
        ],
        'generationConfig' => [
            'temperature'     => 0.4,   // Low creativity = less hallucination
            'topP'            => 0.8,
            'maxOutputTokens' => 500,   // Keep responses concise
        ]
    ];
    
    // ─── Send cURL Request to Gemini ───────────────────────
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS     => json_encode($payload),
        CURLOPT_TIMEOUT        => 15,        // 15 second timeout
        CURLOPT_SSL_VERIFYPEER => false,  // Disable for XAMPP local dev (enable in production)
    ]);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);
    
    // ─── Handle Errors ─────────────────────────────────────
    if ($response === false || !empty($curl_error)) {
        return "I'm having trouble connecting right now. Please try again in a moment, or contact the library at library@yenepoya.edu.in for assistance.";
    }
    
    if ($http_code === 429) {
        return "I'm currently receiving too many requests. Please wait a moment and try again. In the meantime, you can ask me about library timings, OPAC, e-resources, or borrowing rules!";
    }
    
    if ($http_code !== 200) {
        return "I'm experiencing a temporary issue. Please try again shortly, or visit our help desk for immediate assistance.";
    }
    
    // ─── Parse Gemini Response ─────────────────────────────
    $data = json_decode($response, true);
    
    if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
        return $data['candidates'][0]['content']['parts'][0]['text'];
    }
    
    // Fallback if response structure is unexpected
    return "I couldn't process that request. Please try rephrasing your question, or contact the library help desk at library@yenepoya.edu.in.";
}
?>
