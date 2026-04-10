<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: ../login.php");
  exit;
}
require_once '../../db.php';

$message = "";
$msg_type = "";

// DELETE
if (isset($_GET['delete'])) {
  $id = (int) $_GET['delete'];
  if (mysqli_query($conn, "DELETE FROM notifications WHERE id = $id")) {
    $message = "Notification deleted!";
    $msg_type = "success";
  } else {
    $message = "Error deleting Notification: " . mysqli_error($conn);
    $msg_type = "error";
  }
}

// FETCH
$notifs = false;
try {
  $notifs = @mysqli_query($conn, "SELECT * FROM notifications ORDER BY created_at DESC");
} catch (Exception $e) {}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifications Manager — Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../admin/assets/css/admin.css">
</head>
<body>
  <div class="admin-layout">
    <aside class="sidebar" id="sidebar">
      <div class="sidebar__brand">
        <div class="sidebar__brand-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20" />
            <path d="M8 7h6" />
            <path d="M8 11h8" />
          </svg></div>
        <div class="sidebar__brand-text">Yenepoya Libraries<small>Admin Panel</small></div>
      </div>
      <nav class="sidebar__group">
        <div class="sidebar__group-label">Navigation</div>
        <a href="../index.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="1" />
            <rect x="14" y="3" width="7" height="7" rx="1" />
            <rect x="3" y="14" width="7" height="7" rx="1" />
            <rect x="14" y="14" width="7" height="7" rx="1" />
          </svg>Dashboard</a>
        <a href="home-manager.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
            <polyline points="9 22 9 12 15 12 15 22" />
          </svg>Homepage</a>
        <a href="events-manager.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
            <line x1="16" y1="2" x2="16" y2="6" />
            <line x1="8" y1="2" x2="8" y2="6" />
            <line x1="3" y1="10" x2="21" y2="10" />
          </svg>Events</a>
        
        <a href="e-resources-manager.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
            <line x1="8" y1="21" x2="16" y2="21" />
            <line x1="12" y1="17" x2="12" y2="21" />
          </svg>E-Resources</a>
        <a href="messages.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
          </svg>Messages</a>
        <a href="notifications-manager.php" class="sidebar__link active">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
          </svg>
          Notifications
        </a>
        <a href="settings.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="3" />
            <path
              d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
          </svg>Settings</a>
      </nav>
    </aside>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <div class="admin-main">
      <header class="topbar">
        <div class="topbar__left">
          <button class="topbar__burger" onclick="toggleSidebar()"><svg
              xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="3" y1="12" x2="21" y2="12" />
              <line x1="3" y1="6" x2="21" y2="6" />
              <line x1="3" y1="18" x2="21" y2="18" />
            </svg></button>
          <h1 class="topbar__title">Notifications Manager</h1>
        </div>
        <div class="topbar__right">
          <a href="notifications-manager.php" class="topbar__btn" title="Notifications" style="margin-right:12px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
              <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
          </a>
          <a href="../logout.php" class="topbar__logout">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
              <polyline points="16 17 21 12 16 7"></polyline>
              <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            Logout
          </a>
        </div>
      </header>

      <div class="admin-content">
        <div class="page-header">
          <div class="page-header__left">
            <h1>Global Notifications</h1>
            <p>Manage the broadcasted updates across the website</p>
          </div>
        </div>

        <?php if (!empty($message)): ?>
          <div style="padding:14px 20px;border-radius:8px;margin-bottom:20px;font-weight:500;font-size:14px;background:<?php echo $msg_type == 'success' ? '#dcfce7' : '#fee2e2'; ?>;color:<?php echo $msg_type == 'success' ? '#16a34a' : '#dc2626'; ?>;">
            <?php echo $message; ?>
          </div>
        <?php endif; ?>

        <div class="card">
          <div class="card__header">
            <div class="card__title">Broadcast History</div>
          </div>
          <div class="card__body card__body--flush">
            <table class="data-table">
              <thead>
                <tr>
                  <th>Time</th>
                  <th>Title</th>
                  <th>Message</th>
                  <th>Link Route</th>
                  <th style="width:80px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if($notifs && mysqli_num_rows($notifs) > 0): ?>
                  <?php while ($n = mysqli_fetch_assoc($notifs)): ?>
                    <tr>
                      <td style="white-space:nowrap;font-size:12px;color:var(--admin-text-secondary);"><?php echo date('M d, Y h:i A', strtotime($n['created_at'])); ?></td>
                      <td class="cell-title"><?php echo htmlspecialchars($n['title']); ?></td>
                      <td><?php echo htmlspecialchars($n['message']); ?></td>
                      <td><code><?php echo htmlspecialchars($n['link_url']); ?></code></td>
                      <td>
                        <a href="notifications-manager.php?delete=<?php echo $n['id']; ?>" class="btn btn--ghost btn--sm" onclick="return confirm('Delete this global notification?');">🗑️</a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center;padding:20px;color:#999;">No active notifications broadcasted yet.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../../admin/assets/js/admin.js"></script>
</body>
</html>
