<?php
/**
 * LOGOUT — Destroys the admin session and redirects to login page
 */
session_start();
session_destroy(); // Remove all session data
header("Location: login.php");
exit;
?>
