<?php
$conn = mysqli_connect("localhost", "root", "", "yenepoya_library");
if (!$conn) { echo "FAIL: " . mysqli_connect_error(); exit; }

$tables = mysqli_query($conn, "SHOW TABLES");
if (!$tables) { echo "FAIL: " . mysqli_error($conn); exit; }

echo "OK - Tables found:\n";
while ($row = mysqli_fetch_array($tables)) {
    $count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM `{$row[0]}`"));
    echo "{$row[0]}: {$count['c']} rows\n";
}
mysqli_close($conn);
