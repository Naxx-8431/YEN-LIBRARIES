<?php
// admin/api/delete_request.php
require_once __DIR__ . '/../auth.php';
checkAuth();
require_once __DIR__ . '/../../api/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../requests.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);
$table = $_POST['table'] ?? '';

$allowedTables = ['enquiries', 'contacts', 'book_recommendations', 'journal_recommendations'];

if ($id > 0 && in_array($table, $allowedTables)) {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM $table WHERE id = :id");
        $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        // Silently fail for now, real app should log
    }
}

// Redirect back to requests page
header('Location: ../requests.php?msg=Deleted');
exit;
