<?php
require_once 'db.php';
echo "<h2>Notifications Setup</h2>";

$sql = "CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    message VARCHAR(255) NOT NULL,
    link_url VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "<p>✅ 'notifications' table successfully created or already exists.</p>";
} else {
    echo "<p>❌ Error creating table: " . mysqli_error($conn) . "</p>";
}
?>
