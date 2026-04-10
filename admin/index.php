<?php
/**
 * ═══════════════════════════════════════════════════════════
 * ADMIN DASHBOARD
 * ═══════════════════════════════════════════════════════════
 * 
 * Shows live statistics from the database using COUNT(*) queries.
 * Recent activity shows the latest messages and events.
 */
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: login.php");
  exit;
}

// Include database connection
require_once '../db.php';

// ─── Fetch LIVE counts from database ────────────────────────
// Each COUNT(*) query counts the total rows in a table

// Count contact messages
$contacts_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM contacts"))['total'];

// Count book recommendations
$books_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM book_recommendations"))['total'];

// Count journal recommendations
$journals_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM journal_recommendations"))['total'];

// Count events
$events_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM events"))['total'];

// Count e-resources
$eresources_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM e_resources"))['total'];

// Count services
$services_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM services"))['total'];

// Count gallery photos
$gallery_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM gallery_images"))['total'];

// Count unread messages (for badge)
$unread_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM contacts WHERE status = 'unread'"))['total'];

// ─── Fetch recent activity (latest 5 messages) ─────────────
$recent_query = "SELECT name, subject, created_at FROM contacts ORDER BY created_at DESC LIMIT 5";
$recent_result = mysqli_query($conn, $recent_query);

// Get admin username from session
$admin_name = $_SESSION['admin_username'] ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Yenepoya Libraries Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>

<body>
  <div class="admin-layout">
    <!-- ═══ SIDEBAR ═══ -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar__brand">
        <div class="sidebar__brand-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20" />
            <path d="M8 7h6" />
            <path d="M8 11h8" />
          </svg>
        </div>
        <div class="sidebar__brand-text">
          Yenepoya Libraries
          <small>Admin Panel</small>
        </div>
      </div>

      <nav class="sidebar__group">
        <div class="sidebar__group-label">Navigation</div>
        <a href="index.php" class="sidebar__link active">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="1" />
            <rect x="14" y="3" width="7" height="7" rx="1" />
            <rect x="3" y="14" width="7" height="7" rx="1" />
            <rect x="14" y="14" width="7" height="7" rx="1" />
          </svg>
          Dashboard
        </a>
        <a href="pages/home-manager.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
            <polyline points="9 22 9 12 15 12 15 22" />
          </svg>Homepage</a>
        <a href="pages/events-manager.php" class="sidebar__link">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
            <line x1="16" y1="2" x2="16" y2="6" />
            <line x1="8" y1="2" x2="8" y2="6" />
            <line x1="3" y1="10" x2="21" y2="10" />
          </svg>
          Events
        </a>
        <a href="pages/services-manager.php" class="sidebar__link">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <path
              d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
          </svg>
          Services
        </a>
        <a href="pages/e-resources-manager.php" class="sidebar__link">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
            <line x1="8" y1="21" x2="16" y2="21" />
            <line x1="12" y1="17" x2="12" y2="21" />
          </svg>
          E-Resources
        </a>
        <a href="pages/messages.php" class="sidebar__link">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
          </svg>
          Messages
          <?php if ($unread_count > 0): ?>
            <span class="sidebar__link-badge"><?php echo $unread_count; ?></span>
          <?php endif; ?>
        </a>
        <a href="pages/settings.php" class="sidebar__link">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <circle cx="12" cy="12" r="3" />
            <path
              d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
          </svg>
          Settings
        </a>
      </nav>
    </aside>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- ═══ MAIN ═══ -->
    <div class="admin-main">
      <!-- Top Bar -->
      <header class="topbar">
        <div class="topbar__left">
          <button class="topbar__burger" onclick="toggleSidebar()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2">
              <line x1="3" y1="12" x2="21" y2="12" />
              <line x1="3" y1="6" x2="21" y2="6" />
              <line x1="3" y1="18" x2="21" y2="18" />
            </svg>
          </button>
          <h1 class="topbar__title">Dashboard</h1>
        </div>
        <div class="topbar__right">
          <!-- Logout now destroys PHP session -->
          <a href="logout.php" class="topbar__logout">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
              <polyline points="16 17 21 12 16 7" />
              <line x1="21" y1="12" x2="9" y2="12" />
            </svg>
            Logout
          </a>
        </div>
      </header>

      <!-- Content -->
      <div class="admin-content">
        <!-- Page Header -->
        <div class="page-header">
          <div class="page-header__left">
            <h1>Welcome back, <?php echo htmlspecialchars($admin_name); ?></h1>
            <p>Here's what's happening with your library website</p>
          </div>
        </div>

        <!-- Stats Grid — numbers come from database! -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--primary">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
              </svg>
            </div>
            <div class="stat-card__content">
              <div class="stat-card__number"><?php echo $contacts_count; ?></div>
              <div class="stat-card__label">Contact Messages</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--accent">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20" />
              </svg>
            </div>
            <div class="stat-card__content">
              <div class="stat-card__number"><?php echo $books_count; ?></div>
              <div class="stat-card__label">Book Recommendations</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--warning">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
              </svg>
            </div>
            <div class="stat-card__content">
              <div class="stat-card__number"><?php echo $journals_count; ?></div>
              <div class="stat-card__label">Journal Recommendations</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--info">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                <line x1="16" y1="2" x2="16" y2="6" />
                <line x1="8" y1="2" x2="8" y2="6" />
                <line x1="3" y1="10" x2="21" y2="10" />
              </svg>
            </div>
            <div class="stat-card__content">
              <div class="stat-card__number"><?php echo $events_count; ?></div>
              <div class="stat-card__label">Total Events</div>
            </div>
          </div>
        </div>

        <!-- Two-column content -->
        <div class="content-grid">
          <!-- Recent Activity — fetched from database -->
          <div class="card">
            <div class="card__header">
              <div class="card__title">Recent Messages</div>
              <a href="pages/messages.php" class="btn btn--ghost btn--sm">View All</a>
            </div>
            <div class="card__body">
              <ul class="activity-list">
                <?php while ($msg = mysqli_fetch_assoc($recent_result)): ?>
                  <li class="activity-item">
                    <div class="activity-item__dot activity-item__dot--blue"></div>
                    <div>
                      <div class="activity-item__text">
                        <strong><?php echo htmlspecialchars($msg['subject']); ?></strong>
                        from <?php echo htmlspecialchars($msg['name']); ?>
                      </div>
                      <div class="activity-item__time"><?php echo date('d M Y', strtotime($msg['created_at'])); ?></div>
                    </div>
                  </li>
                <?php endwhile; ?>
              </ul>
            </div>
          </div>

          <!-- Quick Actions -->
          <div class="card">
            <div class="card__header">
              <div class="card__title">Quick Actions</div>
            </div>
            <div class="card__body" style="display:flex; flex-direction:column; gap:10px;">
              <a href="pages/events-manager.php" class="btn btn--outline w-full" style="justify-content:flex-start;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19" />
                  <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Add New Event
              </a>
              <a href="pages/e-resources-manager.php" class="btn btn--outline w-full"
                style="justify-content:flex-start;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19" />
                  <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Add New E-Resource
              </a>
              <a href="pages/messages.php" class="btn btn--outline w-full" style="justify-content:flex-start;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2">
                  <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                </svg>
                View Messages
                <?php if ($unread_count > 0): ?>
                  <span class="badge badge--pending" style="margin-left:auto;"><?php echo $unread_count; ?> new</span>
                <?php endif; ?>
              </a>
            </div>
          </div>
        </div>

        <!-- Content Stats -->
        <div class="stats-grid mt-3">
          <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--success">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
                <line x1="8" y1="21" x2="16" y2="21" />
                <line x1="12" y1="17" x2="12" y2="21" />
              </svg>
            </div>
            <div class="stat-card__content">
              <div class="stat-card__number"><?php echo $eresources_count; ?></div>
              <div class="stat-card__label">E-Resources</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--primary">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path
                  d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
              </svg>
            </div>
            <div class="stat-card__content">
              <div class="stat-card__number"><?php echo $services_count; ?></div>
              <div class="stat-card__label">Services</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-card__icon stat-card__icon--danger">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                <circle cx="8.5" cy="8.5" r="1.5" />
                <polyline points="21 15 16 10 5 21" />
              </svg>
            </div>
            <div class="stat-card__content">
              <div class="stat-card__number"><?php echo $gallery_count; ?></div>
              <div class="stat-card__label">Gallery Photos</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/admin.js"></script>
</body>

</html>