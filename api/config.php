<?php
/**
 * Yenepoya Libraries — Database Configuration
 * 
 * This file handles the MySQL database connection.
 * Update the credentials below to match your server environment.
 */

// ─── Database Credentials ───────────────────────────────────
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'yenepoya_library');
define('DB_USER', 'root');       // Change in production
define('DB_PASS', '');           // Change in production
define('DB_CHARSET', 'utf8mb4');

// ─── Admin Email (receives form notifications) ──────────────
define('ADMIN_EMAIL', 'library@yenepoya.edu.in');
define('ADMIN_NAME', 'Yenepoya Central Library');

// ─── Create PDO Connection ──────────────────────────────────
function getDB(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            DB_HOST,
            DB_NAME,
            DB_CHARSET
        );
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]);
            exit;
        }
    }
    return $pdo;
}

// ─── CORS Headers (for fetch requests from frontend) ────────
function setCorsHeaders(): void
{
    // Allow requests from the same origin and the production domain
    $allowed = [
        'https://library.yenepoya.edu.in',
        'http://localhost',
        'http://127.0.0.1',
    ];
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    if (in_array($origin, $allowed, true)) {
        header("Access-Control-Allow-Origin: $origin");
    }
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Type: application/json; charset=utf-8');
}

// ─── Sanitize Helper ────────────────────────────────────────
function clean(string $input): string
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// ─── Send Email Notification ────────────────────────────────
function notifyAdmin(string $subject, string $body): bool
{
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: " . ADMIN_NAME . " <noreply@yenepoya.edu.in>\r\n";
    $headers .= "Reply-To: " . ADMIN_EMAIL . "\r\n";

    return @mail(ADMIN_EMAIL, $subject, $body, $headers);
}
