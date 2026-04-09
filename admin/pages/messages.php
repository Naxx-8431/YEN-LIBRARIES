<?php
/**
 * ═══════════════════════════════════════════════════════════
 * MESSAGES VIEWER
 * ═══════════════════════════════════════════════════════════
 * 
 * Shows all contact messages, book & journal recommendations.
 * Admin can delete messages and mark them as read.
 */
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}
require_once '../../db.php';

$message = "";
$msg_type = "";

// ─── Handle DELETE ──────────────────────────────────────────
if (isset($_GET['delete']) && isset($_GET['table'])) {
    $id = (int)$_GET['delete'];
    $table = $_GET['table'];
    
    // Only allow specific table names (security)
    $allowed_tables = ['contacts', 'book_recommendations', 'journal_recommendations', 'enquiries'];
    if (in_array($table, $allowed_tables)) {
        $query = "DELETE FROM `$table` WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $message = "Message deleted!";
            $msg_type = "success";
        }
    }
}

// ─── Handle Mark as Read ────────────────────────────────────
if (isset($_GET['markread'])) {
    $id = (int)$_GET['markread'];
    mysqli_query($conn, "UPDATE contacts SET status = 'read' WHERE id = $id");
    $message = "Marked as read.";
    $msg_type = "success";
}

// ─── Fetch all messages ─────────────────────────────────────
$tab = $_GET['tab'] ?? 'contacts';

if ($tab == 'contacts') {
    $result = mysqli_query($conn, "SELECT * FROM contacts ORDER BY created_at DESC");
    $table_name = 'contacts';
} elseif ($tab == 'books') {
    $result = mysqli_query($conn, "SELECT * FROM book_recommendations ORDER BY created_at DESC");
    $table_name = 'book_recommendations';
} elseif ($tab == 'journals') {
    $result = mysqli_query($conn, "SELECT * FROM journal_recommendations ORDER BY created_at DESC");
    $table_name = 'journal_recommendations';
} else {
    $result = mysqli_query($conn, "SELECT * FROM enquiries ORDER BY created_at DESC");
    $table_name = 'enquiries';
}

// Counts for tab badges
$c_contacts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM contacts"))['c'];
$c_books = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM book_recommendations"))['c'];
$c_journals = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM journal_recommendations"))['c'];
$c_enquiries = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM enquiries"))['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Messages — Yenepoya Libraries Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../admin/assets/css/admin.css">
</head>
<body>
  <div class="admin-layout">
    <aside class="sidebar" id="sidebar">
      <div class="sidebar__brand"><div class="sidebar__brand-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/><path d="M8 7h6"/><path d="M8 11h8"/></svg></div><div class="sidebar__brand-text">Yenepoya Libraries<small>Admin Panel</small></div></div>
      <nav class="sidebar__group"><div class="sidebar__group-label">Navigation</div>
        <a href="../index.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>Dashboard</a>
        <a href="events-manager.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Events</a>
        <a href="services-manager.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>Services</a>
        <a href="e-resources-manager.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>E-Resources</a>
        <a href="messages.php" class="sidebar__link active"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>Messages</a>
        <a href="settings.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>Settings</a>
      </nav>
    </aside>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <div class="admin-main">
      <header class="topbar"><div class="topbar__left"><button class="topbar__burger" onclick="toggleSidebar()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button><h1 class="topbar__title">Messages</h1></div><div class="topbar__right"><a href="../logout.php" class="topbar__logout"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Logout</a></div></header>

      <div class="admin-content">
        <div class="page-header"><div class="page-header__left"><h1>Messages</h1><p>View and manage contact messages, book & journal recommendations</p></div></div>

        <?php if (!empty($message)): ?>
          <div style="padding:14px 20px; border-radius:8px; margin-bottom:20px; font-weight:500; font-size:14px;
            background: <?php echo $msg_type == 'success' ? '#dcfce7' : '#fee2e2'; ?>;
            color: <?php echo $msg_type == 'success' ? '#16a34a' : '#dc2626'; ?>;">
            <?php echo $message; ?>
          </div>
        <?php endif; ?>

        <!-- Tab Navigation -->
        <div class="table-tabs" style="margin-bottom:20px;">
          <a href="messages.php?tab=contacts" class="table-tab <?php echo $tab == 'contacts' ? 'active' : ''; ?>">Contact Messages <span class="table-tab__count"><?php echo $c_contacts; ?></span></a>
          <a href="messages.php?tab=books" class="table-tab <?php echo $tab == 'books' ? 'active' : ''; ?>">Book Recommendations <span class="table-tab__count"><?php echo $c_books; ?></span></a>
          <a href="messages.php?tab=journals" class="table-tab <?php echo $tab == 'journals' ? 'active' : ''; ?>">Journal Recommendations <span class="table-tab__count"><?php echo $c_journals; ?></span></a>
          <a href="messages.php?tab=enquiries" class="table-tab <?php echo $tab == 'enquiries' ? 'active' : ''; ?>">Enquiries <span class="table-tab__count"><?php echo $c_enquiries; ?></span></a>
        </div>

        <div class="card">
          <div class="card__body card__body--flush">
            <table class="data-table">
              <thead>
                <tr>
                  <?php if ($tab == 'contacts'): ?>
                    <th>From</th><th>Subject</th><th>Message</th><th>Date</th><th>Status</th><th>Actions</th>
                  <?php elseif ($tab == 'books'): ?>
                    <th>Book Title</th><th>Author</th><th>Publisher</th><th>Requested By</th><th>Status</th><th>Actions</th>
                  <?php elseif ($tab == 'journals'): ?>
                    <th>Journal Title</th><th>Publisher</th><th>ISSN</th><th>Description</th><th>Status</th><th>Actions</th>
                  <?php else: ?>
                    <th>Name</th><th>Phone</th><th>Message</th><th>Date</th><th>Status</th><th>Actions</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <?php if ($tab == 'contacts'): ?>
                    <td class="cell-title"><?php echo htmlspecialchars($row['name']); ?><br><small style="color:#999;"><?php echo htmlspecialchars($row['email']); ?></small></td>
                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                    <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?php echo htmlspecialchars($row['message']); ?></td>
                    <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                    <td><span class="badge badge--<?php echo $row['status'] == 'unread' ? 'pending' : 'active'; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                    <td>
                      <?php if ($row['status'] == 'unread'): ?>
                        <a href="messages.php?tab=contacts&markread=<?php echo $row['id']; ?>" class="btn btn--ghost btn--sm" title="Mark Read">✓</a>
                      <?php endif; ?>
                      <a href="messages.php?tab=contacts&delete=<?php echo $row['id']; ?>&table=contacts" class="btn btn--ghost btn--sm" title="Delete" onclick="return confirm('Delete this message?');">🗑️</a>
                    </td>
                  <?php elseif ($tab == 'books'): ?>
                    <td class="cell-title"><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['author']); ?></td>
                    <td><?php echo htmlspecialchars($row['publisher']); ?></td>
                    <td><?php echo htmlspecialchars($row['requester_name']); ?></td>
                    <td><span class="badge badge--<?php echo $row['status'] == 'pending' ? 'pending' : 'active'; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                    <td><a href="messages.php?tab=books&delete=<?php echo $row['id']; ?>&table=book_recommendations" class="btn btn--ghost btn--sm" onclick="return confirm('Delete?');">🗑️</a></td>
                  <?php elseif ($tab == 'journals'): ?>
                    <td class="cell-title"><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['publisher']); ?></td>
                    <td><?php echo htmlspecialchars($row['issn'] ?? '—'); ?></td>
                    <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><span class="badge badge--<?php echo $row['status'] == 'pending' ? 'pending' : 'active'; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                    <td><a href="messages.php?tab=journals&delete=<?php echo $row['id']; ?>&table=journal_recommendations" class="btn btn--ghost btn--sm" onclick="return confirm('Delete?');">🗑️</a></td>
                  <?php else: ?>
                    <td class="cell-title"><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?php echo htmlspecialchars($row['message']); ?></td>
                    <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                    <td><span class="badge badge--info"><?php echo ucfirst($row['status']); ?></span></td>
                    <td><a href="messages.php?tab=enquiries&delete=<?php echo $row['id']; ?>&table=enquiries" class="btn btn--ghost btn--sm" onclick="return confirm('Delete?');">🗑️</a></td>
                  <?php endif; ?>
                </tr>
                <?php endwhile; ?>
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
