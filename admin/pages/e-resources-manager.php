<?php
/**
 * E-RESOURCES MANAGER — CRUD for databases, e-journals, e-books
 */
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
  if (mysqli_query($conn, "DELETE FROM e_resources WHERE id = $id")) {
    $message = "Resource deleted!";
    $msg_type = "success";
  }
}

// ADD
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_resource'])) {
  $title = clean($conn, $_POST['title']);
  $description = clean($conn, $_POST['description']);
  $category = clean($conn, $_POST['category']);
  $provider = clean($conn, $_POST['provider']);
  $access_url = clean($conn, $_POST['access_url']);

  if (empty($title)) {
    $message = "Title required!";
    $msg_type = "error";
  } else {
    $query = "INSERT INTO e_resources (title, description, category, provider, access_url) VALUES ('$title','$description','$category','$provider','$access_url')";
    if (mysqli_query($conn, $query)) {

      if (isset($_POST['send_notification']) && $_POST['send_notification'] == '1') {
        $notif_msg = clean($conn, $_POST['notif_msg']);
        if (empty($notif_msg))
          $notif_msg = "New E-Resource: " . $title;
        $link = "e-resources.php#" . $category;
        mysqli_query($conn, "INSERT INTO notifications (title, message, link_url) VALUES ('$title', '$notif_msg', '$link')");
      }

      $message = "Resource added!";
      $msg_type = "success";
    }
  }
}

// EDIT
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_resource'])) {
  $id = (int) $_POST['resource_id'];
  $title = clean($conn, $_POST['title']);
  $description = clean($conn, $_POST['description']);
  $category = clean($conn, $_POST['category']);
  $provider = clean($conn, $_POST['provider']);
  $access_url = clean($conn, $_POST['access_url']);
  $visible = isset($_POST['visible']) ? 1 : 0;

  $query = "UPDATE e_resources SET title='$title', description='$description', category='$category', provider='$provider', access_url='$access_url', visible=$visible WHERE id=$id";
  if (mysqli_query($conn, $query)) {

    if (isset($_POST['send_notification']) && $_POST['send_notification'] == '1') {
      $notif_msg = clean($conn, $_POST['notif_msg']);
      if (empty($notif_msg))
        $notif_msg = "Updated E-Resource: " . $title;
      $link = "e-resources.php#" . $category;
      mysqli_query($conn, "INSERT INTO notifications (title, message, link_url) VALUES ('$title', '$notif_msg', '$link')");
    }

    $message = "Resource updated!";
    $msg_type = "success";
  }
}

// FETCH
$tab = $_GET['cat'] ?? 'all';
$where = $tab != 'all' ? "WHERE category = '$tab'" : "";
$resources = mysqli_query($conn, "SELECT * FROM e_resources $where ORDER BY sort_order ASC");

$edit = null;
if (isset($_GET['edit'])) {
  $edit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM e_resources WHERE id = " . (int) $_GET['edit']));
}

$count_all = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM e_resources"))['c'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Resources Manager — Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../admin/assets/css/admin.css">
</head>

<body>
  <div class="admin-layout">
    <aside class="sidebar" id="sidebar">
      <div class="sidebar__brand">
        <img src="../../images/logo/Central-Library-logo.png" alt="logo">
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

        <a href="e-resources-manager.php" class="sidebar__link active"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
            <line x1="8" y1="21" x2="16" y2="21" />
            <line x1="12" y1="17" x2="12" y2="21" />
          </svg>E-Resources</a>
        <a href="messages.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
          </svg>Messages</a>
        <a href="notifications-manager.php" class="sidebar__link">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
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
        <div class="topbar__left"><button class="topbar__burger" onclick="toggleSidebar()"><svg
              xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="3" y1="12" x2="21" y2="12" />
              <line x1="3" y1="6" x2="21" y2="6" />
              <line x1="3" y1="18" x2="21" y2="18" />
            </svg></button>
          <h1 class="topbar__title">E-Resources Manager</h1>
        </div>
        <div class="topbar__right"><a href="notifications-manager.php" class="topbar__btn" title="Notifications"
            style="margin-right:12px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
              <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
          </a>
          <a href="../logout.php" class="topbar__logout"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
              <polyline points="16 17 21 12 16 7" />
              <line x1="21" y1="12" x2="9" y2="12" />
            </svg>Logout</a>
        </div>
      </header>
      <div class="admin-content">
        <div class="page-header">
          <div class="page-header__left">
            <h1>E-Resources</h1>
            <p>Manage databases, e-journals, e-books, and open access resources</p>
          </div>
        </div>

        <?php if (!empty($message)): ?>
          <div
            style="padding:14px 20px;border-radius:8px;margin-bottom:20px;font-weight:500;font-size:14px;background:<?php echo $msg_type == 'success' ? '#dcfce7' : '#fee2e2'; ?>;color:<?php echo $msg_type == 'success' ? '#16a34a' : '#dc2626'; ?>;">
            <?php echo $message; ?>
          </div>
        <?php endif; ?>

        <div class="card mb-3">
          <div class="card__header">
            <div class="card__title">
              <?php echo $edit ? '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></svg> Edit Resource' : '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/></svg> Add New Resource'; ?>
            </div>
          </div>
          <div class="card__body">
            <form method="POST" action="">
              <?php if ($edit): ?><input type="hidden" name="resource_id"
                  value="<?php echo $edit['id']; ?>"><?php endif; ?>
              <div class="form-grid">
                <div class="form-group"><label class="form-label">Title *</label><input type="text" name="title"
                    class="form-input" required value="<?php echo $edit ? htmlspecialchars($edit['title']) : ''; ?>"
                    placeholder="e.g. ClinicalKey"></div>
                <div class="form-group"><label class="form-label">Category</label>
                  <select name="category" class="form-select">
                    <?php foreach (['database', 'ejournal', 'ebook', 'openaccess'] as $c): ?>
                      <option value="<?php echo $c; ?>" <?php echo ($edit && $edit['category'] == $c) ? 'selected' : ''; ?>>
                        <?php echo ucfirst($c); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group"><label class="form-label">Provider</label><input type="text" name="provider"
                    class="form-input" value="<?php echo $edit ? htmlspecialchars($edit['provider']) : ''; ?>"
                    placeholder="e.g. Elsevier"></div>
                <div class="form-group"><label class="form-label">Access URL</label><input type="url" name="access_url"
                    class="form-input" value="<?php echo $edit ? htmlspecialchars($edit['access_url']) : ''; ?>"
                    placeholder="https://..."></div>
              </div>
              <div class="form-group"><label class="form-label">Description</label><textarea name="description"
                  class="form-input"
                  rows="3"><?php echo $edit ? htmlspecialchars($edit['description']) : ''; ?></textarea></div>
              <?php if ($edit): ?>
                <div class="form-group"><label><input type="checkbox" name="visible" <?php echo $edit['visible'] ? 'checked' : ''; ?>> Visible on website</label></div><?php endif; ?>

              <!-- NOTIFICATION SYSTEM HOOK -->
              <div class="form-group" style="grid-column: 1 / -1; padding-top:10px; border-top:1px solid #e5e7eb;">
                <label
                  style="display:flex; align-items:center; gap:8px; font-weight:600; font-size:13px; color:var(--admin-primary); cursor:pointer;">
                  <input type="checkbox" name="send_notification" value="1" style="width:16px; height:16px;">
                  Send Notification across website
                </label>
                <input type="text" name="notif_msg" class="form-input"
                  placeholder="Notification Message (e.g. New medical database available!)" style="margin-top:8px;">
              </div>
              <div style="display:flex;gap:10px;margin-top:16px;">
                <?php if ($edit): ?>
                  <button type="submit" name="edit_resource" class="btn btn--primary">Update Resource</button>
                  <a href="e-resources-manager.php" class="btn btn--outline">Cancel</a>
                <?php else: ?>
                  <button type="submit" name="add_resource" class="btn btn--primary">Add Resource</button>
                <?php endif; ?>
              </div>
            </form>
          </div>
        </div>

        <!-- Category Tabs -->
        <div class="table-tabs" style="margin-bottom:20px;">
          <a href="e-resources-manager.php?cat=all" class="table-tab <?php echo $tab == 'all' ? 'active' : ''; ?>">All
            <span class="table-tab__count"><?php echo $count_all; ?></span></a>
          <a href="e-resources-manager.php?cat=database"
            class="table-tab <?php echo $tab == 'database' ? 'active' : ''; ?>">Databases</a>
          <a href="e-resources-manager.php?cat=ejournal"
            class="table-tab <?php echo $tab == 'ejournal' ? 'active' : ''; ?>">E-Journals</a>
          <a href="e-resources-manager.php?cat=ebook"
            class="table-tab <?php echo $tab == 'ebook' ? 'active' : ''; ?>">E-Books</a>
          <a href="e-resources-manager.php?cat=openaccess"
            class="table-tab <?php echo $tab == 'openaccess' ? 'active' : ''; ?>">Open Access</a>
        </div>

        <div class="card">
          <div class="card__body card__body--flush">
            <table class="data-table">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Provider</th>
                  <th>Link</th>
                  <th style="width:120px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($r = mysqli_fetch_assoc($resources)): ?>
                  <tr>
                    <td class="cell-title"><?php echo htmlspecialchars($r['title']); ?></td>
                    <td><span class="badge badge--info"><?php echo ucfirst($r['category']); ?></span></td>
                    <td><?php echo htmlspecialchars($r['provider'] ?? '—'); ?></td>
                    <td>
                      <?php echo $r['access_url'] ? '<a href="' . htmlspecialchars($r['access_url']) . '" target="_blank" style="font-size:12px;">Visit →</a>' : '—'; ?>
                    </td>
                    <td>
                      <a href="e-resources-manager.php?edit=<?php echo $r['id']; ?>" class="btn btn--ghost btn--sm"><svg
                          xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                          viewBox="0 0 16 16">
                          <path
                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                        </svg></a>
                      <a href="e-resources-manager.php?delete=<?php echo $r['id']; ?>" class="btn btn--ghost btn--sm"
                        onclick="return confirm('Delete?');"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                          height="16" fill="currentColor" viewBox="0 0 16 16">
                          <path
                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                          <path fill-rule="evenodd"
                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                        </svg></a>
                    </td>
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