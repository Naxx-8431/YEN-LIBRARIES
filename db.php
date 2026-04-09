<?php
/**
 * ═══════════════════════════════════════════════════════════
 * Yenepoya Libraries — Database Connection (db.php)
 * ═══════════════════════════════════════════════════════════
 * 
 * This file connects to the MySQL database.
 * Include this file at the TOP of every PHP page:
 *   require_once 'db.php';
 * 
 * After including, you can use the $conn variable
 * to run any MySQL query.
 */

// ─── Database Credentials ───────────────────────────────────
// Change these if your MySQL setup is different
$db_host = "localhost";    // Your MySQL server (usually localhost)
$db_user = "root";         // Your MySQL username
$db_pass = "";             // Your MySQL password (empty for XAMPP default)
$db_name = "yenepoya_library"; // The database name we will create

// ─── Connect to MySQL ───────────────────────────────────────
// mysqli_connect() creates a connection to the MySQL database
// It takes 4 parameters: host, username, password, database name
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// ─── Check if connection worked ─────────────────────────────
// If the connection fails, show an error message and stop
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// ─── Set character encoding to UTF-8 ────────────────────────
// This ensures special characters (like accents, emojis) work properly
mysqli_set_charset($conn, "utf8mb4");


// ═══════════════════════════════════════════════════════════
// HELPER FUNCTIONS
// ═══════════════════════════════════════════════════════════

/**
 * clean() — Sanitize user input to prevent XSS attacks
 * 
 * WHAT IT DOES:
 *   - Removes extra spaces from beginning and end (trim)
 *   - Converts special characters to safe HTML (htmlspecialchars)
 *   - Escapes quotes to prevent SQL issues (mysqli_real_escape_string)
 * 
 * HOW TO USE:
 *   $safe_name = clean($conn, $_POST['name']);
 */
function clean($conn, $data) {
    $data = trim($data);                          // Remove extra spaces
    $data = htmlspecialchars($data, ENT_QUOTES);   // Convert < > " ' to safe text
    $data = mysqli_real_escape_string($conn, $data); // Escape for MySQL
    return $data;
}

/**
 * redirect() — Redirect the user to another page
 * 
 * HOW TO USE:
 *   redirect('contact.php?status=success&msg=Message sent!');
 */
function redirect($url) {
    header("Location: $url");
    exit; // Always exit after redirect
}

/**
 * isLoggedIn() — Check if admin is logged in
 * 
 * HOW TO USE:
 *   if (!isLoggedIn()) { redirect('../login.php'); }
 */
function isLoggedIn() {
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Check if the admin session variable exists
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}
?>
