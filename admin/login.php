<?php
/**
 * ═══════════════════════════════════════════════════════════
 * ADMIN LOGIN PAGE
 * ═══════════════════════════════════════════════════════════
 * 
 * This page handles admin login using PHP sessions.
 * 
 * HOW IT WORKS:
 * 1. Admin enters username + password
 * 2. PHP checks credentials against the admin_users table
 * 3. If correct → creates a session and redirects to dashboard
 * 4. If wrong → shows an error message on the same page
 */

// Start PHP session (needed for login tracking)
session_start();

// If already logged in, go to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
  header("Location: index.php");
  exit;
}

// Include database connection
require_once '../db.php';

// ─── Handle Login Form Submission ───────────────────────────
$error = ""; // This will hold any error message

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {

  // Step 1: Get form data and clean it
  $username = clean($conn, $_POST['username']);
  $password = $_POST['password']; // Don't clean password (affects hash matching)

  // Step 2: Check if username and password are not empty
  if (empty($username) || empty($password)) {
    $error = "Please enter both username and password.";
  } else {
    // Step 3: Look up the username in the database
    $query = "SELECT * FROM admin_users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
      // Step 4: Username found — now check the password
      $admin = mysqli_fetch_assoc($result);

      // password_verify() compares the typed password with the stored hash
      if (password_verify($password, $admin['password'])) {
        // Step 5: Password correct! Create session
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_id'] = $admin['id'];

        // Redirect to dashboard
        header("Location: index.php");
        exit;
      } else {
        $error = "Incorrect password. Please try again.";
      }
    } else {
      $error = "Username not found.";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — Yenepoya Libraries Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>
  <div class="login-page">
    <div class="login-card">
      <!-- Title -->
      <h1 class="login-card__title">Welcome back</h1>
      <p class="login-card__subtitle">Sign in to manage your library website content</p>

      <!-- Show error message if login failed -->
      <?php if (!empty($error)): ?>
        <div
          style="background:#fee2e2; color:#dc2626; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px; font-weight:500;">
          <?php echo $error; ?>
        </div>
      <?php endif; ?>

      <!-- Login Form — uses method="POST" to send data securely -->
      <form method="POST" action="">
        <div class="form-group">
          <label class="form-label">Username <span>*</span></label>
          <input type="text" name="username" class="form-input" placeholder="Enter your username" required>
        </div>
        <div class="form-group">
          <label class="form-label">Password <span>*</span></label>
          <input type="password" name="password" class="form-input" placeholder="Enter your password" required>
        </div>
        <button type="submit" name="login" class="btn btn--primary">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
            <polyline points="10 17 15 12 10 7" />
            <line x1="15" y1="12" x2="3" y2="12" />
          </svg>
          Sign In
        </button>
      </form>
    </div>
  </div>
</body>

</html>