<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: ../login.php");
  exit;
}

require_once '../../db.php';

$message = "";
$msg_type = "";

// ─── Helper Functions ───────────────────────────────────────
function handleImageUpload($file, $prefix)
{
  $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
  if (!in_array($file['type'], $allowed_types) || $file['size'] > 5 * 1024 * 1024)
    return "";

  $upload_dir = "../../uploads/";
  if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
  }

  $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
  $new_name = $prefix . "_" . time() . "_" . rand(100, 999) . "." . $ext;

  if (move_uploaded_file($file['tmp_name'], $upload_dir . $new_name)) {
    return "uploads/" . $new_name;
  }
  return "";
}

// ─── Handle Deletions ─────────────────────────────────────────
if (isset($_GET['delete_arrival'])) {
  $id = (int) $_GET['delete_arrival'];
  if (mysqli_query($conn, "DELETE FROM new_arrivals WHERE id = $id")) {
    $message = "Book removed from New Arrivals.";
    $msg_type = "success";
  }
}
if (isset($_GET['delete_pub'])) {
  $id = (int) $_GET['delete_pub'];
  if (mysqli_query($conn, "DELETE FROM trending_publications WHERE id = $id")) {
    $message = "Publication removed.";
    $msg_type = "success";
  }
}
if (isset($_GET['delete_news'])) {
  $id = (int) $_GET['delete_news'];
  if (mysqli_query($conn, "DELETE FROM trending_news WHERE id = $id")) {
    $message = "News item removed.";
    $msg_type = "success";
  }
}

// ─── Handle Updates / Inserts ─────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // 1. Hero Settings Update
  if (isset($_POST['update_hero'])) {
    $tagline = clean($conn, $_POST['tagline']);
    $heading = clean($conn, $_POST['heading']);
    $description = clean($conn, $_POST['description']);
    $stat1_num = clean($conn, $_POST['stat1_num']);
    $stat1_label = clean($conn, $_POST['stat1_label']);
    $stat2_num = clean($conn, $_POST['stat2_num']);
    $stat2_label = clean($conn, $_POST['stat2_label']);
    $stat3_num = clean($conn, $_POST['stat3_num']);
    $stat3_label = clean($conn, $_POST['stat3_label']);
    $stat4_num = clean($conn, $_POST['stat4_num']);
    $stat4_label = clean($conn, $_POST['stat4_label']);

    $query = "UPDATE hero_settings SET 
                  tagline='$tagline', heading='$heading', description='$description',
                  stat1_num='$stat1_num', stat1_label='$stat1_label',
                  stat2_num='$stat2_num', stat2_label='$stat2_label',
                  stat3_num='$stat3_num', stat3_label='$stat3_label',
                  stat4_num='$stat4_num', stat4_label='$stat4_label' WHERE id = 1";
    if (mysqli_query($conn, $query)) {
      $message = "Hero settings safely updated!";
      $msg_type = "success";
    }
  }

  // 2. New Arrivals Add
  if (isset($_POST['add_arrival'])) {
    $title = clean($conn, $_POST['title']);
    $author = clean($conn, $_POST['author']);
    $category = clean($conn, $_POST['category']);
    $visible = isset($_POST['visible']) ? 1 : 0;

    $image_sql = "NULL";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
      $path = handleImageUpload($_FILES['image'], 'book');
      if ($path)
        $image_sql = "'$path'";
    }

    $query = "INSERT INTO new_arrivals (title, author, category, image, visible) 
                  VALUES ('$title', '$author', '$category', $image_sql, $visible)";
    mysqli_query($conn, $query);
    $message = "New Arrival added successfully!";
    $msg_type = "success";
  }

  // 3. Trending Publications Add
  if (isset($_POST['add_pub'])) {
    $title = clean($conn, $_POST['title']);
    $author_details = clean($conn, $_POST['author_details']);
    $publish_date = clean($conn, $_POST['publish_date']);
    $link_url = clean($conn, $_POST['link_url']);
    $visible = isset($_POST['visible']) ? 1 : 0;

    $query = "INSERT INTO trending_publications (title, author_details, publish_date, link_url, visible) 
                  VALUES ('$title', '$author_details', '$publish_date', '$link_url', $visible)";
    mysqli_query($conn, $query);
    $message = "Trending Publication added!";
    $msg_type = "success";
  }

  // 4. Trending News Add
  if (isset($_POST['add_news'])) {
    $title = clean($conn, $_POST['title']);
    $category_tag = clean($conn, $_POST['category_tag']);
    $link_url = clean($conn, $_POST['link_url']);
    $visible = isset($_POST['visible']) ? 1 : 0;

    $image_sql = "NULL";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
      $path = handleImageUpload($_FILES['image'], 'news');
      if ($path)
        $image_sql = "'$path'";
    }

    $query = "INSERT INTO trending_news (title, category_tag, link_url, image, visible) 
                  VALUES ('$title', '$category_tag', '$link_url', $image_sql, $visible)";
    mysqli_query($conn, $query);
    $message = "Trending News added!";
    $msg_type = "success";
  }
}

// ─── Fetch Data ───────────────────────────────────────────────
$hero_query = mysqli_query($conn, "SELECT * FROM hero_settings LIMIT 1");
$hero = mysqli_fetch_assoc($hero_query);

$arrivals_query = mysqli_query($conn, "SELECT * FROM new_arrivals ORDER BY created_at DESC");
$pubs_query = mysqli_query($conn, "SELECT * FROM trending_publications ORDER BY sort_order ASC, created_at DESC");
$news_query = mysqli_query($conn, "SELECT * FROM trending_news ORDER BY sort_order ASC, created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page Manager — Yenepoya Libraries Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/admin.css">
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
        <a href="services-manager.php" class="sidebar__link active"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path
              d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
          </svg>Services</a>
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
          <button class="topbar__burger" onclick="toggleSidebar()"><svg xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="3" y1="12" x2="21" y2="12" />
              <line x1="3" y1="6" x2="21" y2="6" />
              <line x1="3" y1="18" x2="21" y2="18" />
            </svg></button>
          <h1 class="topbar__title">Home Page Manager</h1>
        </div>
      </header>

      <div class="admin-content">
        <div class="page-header">
          <div class="page-header__left">
            <h1>Home Page</h1>
            <p>Manage hero section, statistics, and dynamic resources like New Arrivals.</p>
          </div>
        </div>

        <?php if (!empty($message)): ?>
          <div style="padding:14px 20px; border-radius:8px; margin-bottom:20px; font-weight:500; font-size:14px;
            background: <?php echo $msg_type == 'success' ? '#dcfce7' : '#fee2e2'; ?>;
            color: <?php echo $msg_type == 'success' ? '#16a34a' : '#dc2626'; ?>;">
            <?php echo $message; ?>
          </div>
        <?php endif; ?>

        <!-- Hero Section -->
        <div class="card mb-3">
          <div class="card__header">
            <div class="card__title">Hero & Statistics</div>
          </div>
          <div class="card__body">
            <form class="form-grid" method="POST" action="">
              <div class="form-group">
                <label class="form-label">Tagline</label>
                <input type="text" name="tagline" class="form-input"
                  value="<?php echo htmlspecialchars($hero['tagline']); ?>">
              </div>
              <div class="form-group">
                <label class="form-label">Main Heading</label>
                <input type="text" name="heading" class="form-input"
                  value="<?php echo htmlspecialchars($hero['heading']); ?>">
              </div>
              <div class="form-group form-group--full">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-input"
                  rows="3"><?php echo htmlspecialchars($hero['description']); ?></textarea>
              </div>

              <div class="form-group">
                <label class="form-label">Stat 1 — Number</label>
                <input type="text" name="stat1_num" class="form-input"
                  value="<?php echo htmlspecialchars($hero['stat1_num']); ?>">
              </div>
              <div class="form-group">
                <label class="form-label">Stat 1 — Label</label>
                <input type="text" name="stat1_label" class="form-input"
                  value="<?php echo htmlspecialchars($hero['stat1_label']); ?>">
              </div>

              <div class="form-group">
                <label class="form-label">Stat 2 — Number</label>
                <input type="text" name="stat2_num" class="form-input"
                  value="<?php echo htmlspecialchars($hero['stat2_num']); ?>">
              </div>
              <div class="form-group">
                <label class="form-label">Stat 2 — Label</label>
                <input type="text" name="stat2_label" class="form-input"
                  value="<?php echo htmlspecialchars($hero['stat2_label']); ?>">
              </div>

              <div class="form-group">
                <label class="form-label">Stat 3 — Number</label>
                <input type="text" name="stat3_num" class="form-input"
                  value="<?php echo htmlspecialchars($hero['stat3_num']); ?>">
              </div>
              <div class="form-group">
                <label class="form-label">Stat 3 — Label</label>
                <input type="text" name="stat3_label" class="form-input"
                  value="<?php echo htmlspecialchars($hero['stat3_label']); ?>">
              </div>

              <div class="form-group">
                <label class="form-label">Stat 4 — Number</label>
                <input type="text" name="stat4_num" class="form-input"
                  value="<?php echo htmlspecialchars($hero['stat4_num']); ?>">
              </div>
              <div class="form-group">
                <label class="form-label">Stat 4 — Label</label>
                <input type="text" name="stat4_label" class="form-input"
                  value="<?php echo htmlspecialchars($hero['stat4_label']); ?>">
              </div>

              <div class="form-group form-group--full" style="margin-top: 10px;">
                <button type="submit" name="update_hero" class="btn btn--primary">Save Hero & Stats</button>
              </div>
            </form>
          </div>
        </div>

        <!-- New Arrivals -->
        <div class="card mb-3">
          <div class="card__header">
            <div class="card__title">New Arrivals</div>
            <button class="btn btn--sm btn--outline" onclick="openModal('addArrivalModal')">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg>
              Add Book
            </button>
          </div>
          <div class="card__body card__body--flush">
            <table class="data-table">
              <thead>
                <tr>
                  <th>Book Title</th>
                  <th>Author</th>
                  <th>Category</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_assoc($arrivals_query)): ?>
                  <tr>
                    <td class="cell-title"><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['author']); ?></td>
                    <td><span class="badge badge--info"><?php echo htmlspecialchars($row['category']); ?></span></td>
                    <td><a href="?delete_arrival=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')"
                        class="btn btn--sm btn--ghost">🗑️</a></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Trending Publications -->
        <div class="card mb-3">
          <div class="card__header">
            <div class="card__title">Faculty Publications</div>
            <button class="btn btn--sm btn--outline" onclick="openModal('addPubModal')">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg>
              Add Publication
            </button>
          </div>
          <div class="card__body card__body--flush">
            <table class="data-table">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Author Details</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_assoc($pubs_query)): ?>
                  <tr>
                    <td class="cell-title"><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['author_details']); ?></td>
                    <td><?php echo htmlspecialchars($row['publish_date']); ?></td>
                    <td><a href="?delete_pub=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')"
                        class="btn btn--sm btn--ghost">🗑️</a></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Trending News -->
        <div class="card mb-3">
          <div class="card__header">
            <div class="card__title">Trending Subjects & News</div>
            <button class="btn btn--sm btn--outline" onclick="openModal('addNewsModal')">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg>
              Add News
            </button>
          </div>
          <div class="card__body card__body--flush">
            <table class="data-table">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_assoc($news_query)): ?>
                  <tr>
                    <td class="cell-title"><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><span class="badge badge--accent"><?php echo htmlspecialchars($row['category_tag']); ?></span>
                    </td>
                    <td><a href="?delete_news=<?php echo $row['id']; ?>" onclick="return confirm('Delete?')"
                        class="btn btn--sm btn--ghost">🗑️</a></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Modals -->
  <div class="modal-overlay" id="addArrivalModal">
    <div class="modal" style="max-width:520px;">
      <div class="modal__header">
        <h2 class="modal__title">Add New Arrival</h2>
        <button class="modal__close" onclick="closeModal('addArrivalModal')"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
          </svg></button>
      </div>
      <form method="POST" action="" enctype="multipart/form-data">
        <div class="modal__body">
          <div class="form-group"><label class="form-label">Book Title <span>*</span></label><input type="text"
              name="title" class="form-input" required></div>
          <div class="form-group"><label class="form-label">Author</label><input type="text" name="author"
              class="form-input"></div>
          <div class="form-group"><label class="form-label">Category</label><input type="text" name="category"
              class="form-input"></div>
          <div class="form-group"><label class="form-label">Cover Image</label><input type="file" name="image"
              class="form-input" accept="image/*"></div>
          <div class="form-group"><label class="form-label"><input type="checkbox" name="visible" checked> Visible on
              Website</label></div>
        </div>
        <div class="modal__footer">
          <button type="button" class="btn btn--ghost" onclick="closeModal('addArrivalModal')">Cancel</button>
          <button type="submit" name="add_arrival" class="btn btn--primary">Add Book</button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal-overlay" id="addPubModal">
    <div class="modal" style="max-width:520px;">
      <div class="modal__header">
        <h2 class="modal__title">Add Publication</h2>
        <button class="modal__close" onclick="closeModal('addPubModal')"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
          </svg></button>
      </div>
      <form method="POST" action="">
        <div class="modal__body">
          <div class="form-group"><label class="form-label">Title <span>*</span></label><input type="text" name="title"
              class="form-input" required></div>
          <div class="form-group"><label class="form-label">Author & Department</label><input type="text"
              name="author_details" class="form-input"></div>
          <div class="form-group"><label class="form-label">Date (e.g. Mar 2026)</label><input type="text"
              name="publish_date" class="form-input"></div>
          <div class="form-group"><label class="form-label">URL (Optional)</label><input type="text" name="link_url"
              class="form-input" value="repository.php#publications"></div>
          <div class="form-group"><label class="form-label"><input type="checkbox" name="visible" checked>
              Visible</label></div>
        </div>
        <div class="modal__footer">
          <button type="button" class="btn btn--ghost" onclick="closeModal('addPubModal')">Cancel</button>
          <button type="submit" name="add_pub" class="btn btn--primary">Add</button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal-overlay" id="addNewsModal">
    <div class="modal" style="max-width:520px;">
      <div class="modal__header">
        <h2 class="modal__title">Add Trending News</h2>
        <button class="modal__close" onclick="closeModal('addNewsModal')"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
          </svg></button>
      </div>
      <form method="POST" action="" enctype="multipart/form-data">
        <div class="modal__body">
          <div class="form-group"><label class="form-label">Title <span>*</span></label><input type="text" name="title"
              class="form-input" required></div>
          <div class="form-group"><label class="form-label">Category / Tag</label><input type="text" name="category_tag"
              class="form-input" placeholder="e.g. Technology & Science"></div>
          <div class="form-group"><label class="form-label">URL (Optional)</label><input type="text" name="link_url"
              class="form-input" value="e-resources.php#newspapers-magazines"></div>
          <div class="form-group"><label class="form-label">Image</label><input type="file" name="image"
              class="form-input" accept="image/*"></div>
          <div class="form-group"><label class="form-label"><input type="checkbox" name="visible" checked>
              Visible</label></div>
        </div>
        <div class="modal__footer">
          <button type="button" class="btn btn--ghost" onclick="closeModal('addNewsModal')">Cancel</button>
          <button type="submit" name="add_news" class="btn btn--primary">Add</button>
        </div>
      </form>
    </div>
  </div>

  <script src="../assets/js/admin.js"></script>
</body>

</html>