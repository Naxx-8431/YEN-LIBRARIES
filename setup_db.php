<?php
/**
 * Run this file ONCE to set up the database.
 * Open in your browser: http://localhost/YEN-LIBRARY/setup_db.php
 * DELETE this file after setup is complete!
 */

echo "<h2>Yenepoya Libraries — Database Setup</h2>";

// Step 1: Connect to MySQL (without database name first)
$conn = mysqli_connect("localhost", "root", "");
if (!$conn) {
    die("<p style='color:red;'>❌ Connection failed: " . mysqli_connect_error() . "</p>");
}
echo "<p>✅ Connected to MySQL</p>";

// Step 2: Read and run the SQL file
$sql = file_get_contents("api/setup_database.sql");
if (!$sql) {
    die("<p style='color:red;'>❌ Could not read setup_database.sql</p>");
}

// Step 3: Execute all queries
if (mysqli_multi_query($conn, $sql)) {
    // Process all results
    do {
        if ($result = mysqli_store_result($conn)) {
            mysqli_free_result($result);
        }
    } while (mysqli_next_result($conn));
    
    // Check for errors
    if (mysqli_errno($conn)) {
        echo "<p style='color:red;'>❌ Error: " . mysqli_error($conn) . "</p>";
    } else {
        echo "<p>✅ All tables created successfully!</p>";
    }
} else {
    echo "<p style='color:red;'>❌ SQL Error: " . mysqli_error($conn) . "</p>";
}

// Step 4: Verify tables
$conn2 = mysqli_connect("localhost", "root", "", "yenepoya_library");
if ($conn2) {
    $tables = mysqli_query($conn2, "SHOW TABLES");
    echo "<h3>Tables Created:</h3><ul>";
    while ($row = mysqli_fetch_array($tables)) {
        $count = mysqli_fetch_assoc(mysqli_query($conn2, "SELECT COUNT(*) as c FROM `{$row[0]}`"));
        echo "<li><strong>{$row[0]}</strong> — {$count['c']} rows</li>";
    }
    echo "</ul>";
    mysqli_close($conn2);
}

mysqli_close($conn);
echo "<p style='color:green; font-weight:bold;'>🎉 Database setup complete! You can delete this file now.</p>";
?>
