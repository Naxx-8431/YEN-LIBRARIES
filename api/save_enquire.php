<?php
/**
 * Yenepoya Libraries — Enquiry Form Handler
 * 
 * Handles the "Quick Enquiry" sidebar form submissions.
 * Used on: index.html, services.html, e-resources.html, 
 *          repository.html, about.html
 * 
 * Accepts: POST (both standard form submit and fetch/AJAX)
 * Fields:  name, email, phone, message
 */

require_once __DIR__ . '/config.php';

// Handle CORS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    setCorsHeaders();
    http_response_code(204);
    exit;
}

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setCorsHeaders();
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

setCorsHeaders();

// ─── Collect & Validate Fields ──────────────────────────────
$name    = clean($_POST['name']    ?? '');
$email   = clean($_POST['email']   ?? '');
$phone   = clean($_POST['phone']   ?? '');
$message = clean($_POST['message'] ?? '');

$errors = [];

if (empty($name)) {
    $errors[] = 'Name is required.';
}
if (empty($phone)) {
    $errors[] = 'Phone number is required.';
}
if (empty($message)) {
    $errors[] = 'Message is required.';
}
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email address.';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'errors' => $errors]);
    exit;
}

// ─── Store in Database ──────────────────────────────────────
try {
    $db = getDB();
    $stmt = $db->prepare(
        'INSERT INTO enquiries (name, email, phone, message, ip_address)
         VALUES (:name, :email, :phone, :message, :ip)'
    );
    $stmt->execute([
        ':name'    => $name,
        ':email'   => $email ?: null,
        ':phone'   => $phone,
        ':message' => $message,
        ':ip'      => $_SERVER['REMOTE_ADDR'] ?? null,
    ]);

    $insertId = $db->lastInsertId();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to save enquiry.']);
    exit;
}

// ─── Send Email Notification ────────────────────────────────
$emailBody = "
<html>
<body style='font-family: Inter, Arial, sans-serif; color: #333;'>
    <h2 style='color: #283B6A;'>📬 New Library Enquiry (#$insertId)</h2>
    <table style='border-collapse: collapse; width: 100%; max-width: 500px;'>
        <tr>
            <td style='padding: 8px 12px; font-weight: bold; border-bottom: 1px solid #eee;'>Name</td>
            <td style='padding: 8px 12px; border-bottom: 1px solid #eee;'>$name</td>
        </tr>
        <tr>
            <td style='padding: 8px 12px; font-weight: bold; border-bottom: 1px solid #eee;'>Email</td>
            <td style='padding: 8px 12px; border-bottom: 1px solid #eee;'>" . ($email ?: '<em>Not provided</em>') . "</td>
        </tr>
        <tr>
            <td style='padding: 8px 12px; font-weight: bold; border-bottom: 1px solid #eee;'>Phone</td>
            <td style='padding: 8px 12px; border-bottom: 1px solid #eee;'>$phone</td>
        </tr>
        <tr>
            <td style='padding: 8px 12px; font-weight: bold;'>Message</td>
            <td style='padding: 8px 12px;'>$message</td>
        </tr>
    </table>
    <p style='margin-top: 20px; font-size: 12px; color: #999;'>Submitted from Yenepoya Libraries website</p>
</body>
</html>
";

notifyAdmin("New Library Enquiry from $name", $emailBody);

// ─── Response ───────────────────────────────────────────────
echo json_encode([
    'status'  => 'success',
    'message' => 'Your enquiry has been submitted successfully.',
    'id'      => (int)$insertId,
]);
