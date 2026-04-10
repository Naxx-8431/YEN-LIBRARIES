<?php
/**
 * ═══════════════════════════════════════════════════════════
 * EVENTS MANAGER — Full CRUD Example
 * ═══════════════════════════════════════════════════════════
 * 
 * This page demonstrates ALL 4 database operations:
 *   - INSERT (Add new event)
 *   - SELECT (Show all events in a table)
 *   - UPDATE (Edit an existing event)
 *   - DELETE (Remove an event)
 * 
 * All operations are handled INSIDE this same file using
 * $_POST and $_GET parameters to detect what action to perform.
 */
session_start();

// ─── Auth Check ─────────────────────────────────────────────
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: ../login.php");
  exit;
}

// Include database connection
require_once '../../db.php';

// This variable holds success/error messages to display
$message = "";
$msg_type = ""; // "success" or "error"


// ═══════════════════════════════════════════════════════════
// HANDLE FORM ACTIONS (before any HTML output)
// ═══════════════════════════════════════════════════════════

// ─── ACTION 1: DELETE an event ──────────────────────────────
// Triggered when ?delete=ID is in the URL
if (isset($_GET['delete'])) {
  $id = (int) $_GET['delete']; // Convert to integer for safety

  // Delete the row from the events table
  $query = "DELETE FROM events WHERE id = $id";

  if (mysqli_query($conn, $query)) {
    $message = "Event deleted successfully!";
    $msg_type = "success";
  } else {
    $message = "Error deleting event: " . mysqli_error($conn);
    $msg_type = "error";
  }
}


// ─── ACTION 2: ADD a new event (INSERT) ─────────────────────
// Triggered when the "Add Event" form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_event'])) {

  // Step 1: Get form data and sanitize it
  $title = clean($conn, $_POST['title']);
  $description = clean($conn, $_POST['description']);
  $category = clean($conn, $_POST['category']);
  $event_date = clean($conn, $_POST['event_date']);
  $location = clean($conn, $_POST['location']);
  $status = clean($conn, $_POST['status']);

  // Step 2: Validate — make sure title is not empty
  if (empty($title)) {
    $message = "Event title is required!";
    $msg_type = "error";
  } else {
    // Step 3: Handle image upload (if provided)
    $image_path = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
      $image_path = handleImageUpload($_FILES['image']);
    }

    // Step 4: INSERT into database
    $query = "INSERT INTO events (title, description, category, event_date, location, image, status) 
                  VALUES ('$title', '$description', '$category', '$event_date', '$location', '$image_path', '$status')";

    if (mysqli_query($conn, $query)) {
      $message = "Event added successfully!";
      $msg_type = "success";
    } else {
      $message = "Error adding event: " . mysqli_error($conn);
      $msg_type = "error";
    }
  }
}


// ─── ACTION 3: EDIT an event (UPDATE) ───────────────────────
// Triggered when the "Edit Event" form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_event'])) {

  $id = (int) $_POST['event_id'];
  $title = clean($conn, $_POST['title']);
  $description = clean($conn, $_POST['description']);
  $category = clean($conn, $_POST['category']);
  $event_date = clean($conn, $_POST['event_date']);
  $location = clean($conn, $_POST['location']);
  $status = clean($conn, $_POST['status']);

  if (empty($title)) {
    $message = "Event title is required!";
    $msg_type = "error";
  } else {
    // Handle new image upload (optional during edit)
    $image_sql = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
      $image_path = handleImageUpload($_FILES['image']);
      $image_sql = ", image = '$image_path'";
    }

    // UPDATE the row in the database
    $query = "UPDATE events SET 
                    title = '$title', 
                    description = '$description', 
                    category = '$category', 
                    event_date = '$event_date', 
                    location = '$location',
                    status = '$status'
                    $image_sql
                  WHERE id = $id";

    if (mysqli_query($conn, $query)) {
      $message = "Event updated successfully!";
      $msg_type = "success";
    } else {
      $message = "Error updating event: " . mysqli_error($conn);
      $msg_type = "error";
    }
  }
}


// ═══════════════════════════════════════════════════════════
// IMAGE UPLOAD HELPER FUNCTION
// ═══════════════════════════════════════════════════════════
function handleImageUpload($file)
{
  // Allowed file types
  $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
  $max_size = 5 * 1024 * 1024; // 5MB in bytes

  // Check file type
  if (!in_array($file['type'], $allowed_types)) {
    return ""; // Invalid type, skip
  }

  // Check file size
  if ($file['size'] > $max_size) {
    return ""; // Too large, skip
  }

  // Create uploads directory if it doesn't exist
  $upload_dir = "../../uploads/";
  if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
  }

  // Generate a unique filename using current timestamp
  $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
  $new_name = "event_" . time() . "_" . rand(100, 999) . "." . $extension;
  $destination = $upload_dir . $new_name;

  // Move the uploaded file from temp to our uploads folder
  if (move_uploaded_file($file['tmp_name'], $destination)) {
    return "uploads/" . $new_name; // Return relative path to save in DB
  }

  return ""; // Upload failed
}


// ═══════════════════════════════════════════════════════════
// FETCH ALL EVENTS (SELECT) — for displaying in the table
// ═══════════════════════════════════════════════════════════
$events_query = "SELECT * FROM events ORDER BY event_date DESC";
$events_result = mysqli_query($conn, $events_query);

// If editing, fetch the event data for the form
$edit_event = null;
if (isset($_GET['edit'])) {
  $edit_id = (int) $_GET['edit'];
  $edit_query = "SELECT * FROM events WHERE id = $edit_id LIMIT 1";
  $edit_result = mysqli_query($conn, $edit_query);
  $edit_event = mysqli_fetch_assoc($edit_result);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Events Manager — Yenepoya Libraries Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../admin/assets/css/admin.css">
</head>

<body>
  <div class="admin-layout">
    <!-- SIDEBAR -->
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
        <a href="events-manager.php" class="sidebar__link active"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
            <line x1="16" y1="2" x2="16" y2="6" />
            <line x1="8" y1="2" x2="8" y2="6" />
            <line x1="3" y1="10" x2="21" y2="10" />
          </svg>Events</a>
        <a href="services-manager.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2">
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
        <div class="topbar__left"><button class="topbar__burger" onclick="toggleSidebar()"><svg
              xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="3" y1="12" x2="21" y2="12" />
              <line x1="3" y1="6" x2="21" y2="6" />
              <line x1="3" y1="18" x2="21" y2="18" />
            </svg></button>
          <h1 class="topbar__title">Events Manager</h1>
        </div>
        <div class="topbar__right"><a href="../logout.php" class="topbar__logout"><svg
              xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
              <polyline points="16 17 21 12 16 7" />
              <line x1="21" y1="12" x2="9" y2="12" />
            </svg>Logout</a></div>
      </header>

      <div class="admin-content">
        <div class="page-header">
          <div class="page-header__left">
            <h1>Events Manager</h1>
            <p>Add, edit, and delete library events</p>
          </div>
        </div>

        <!-- ═══ SUCCESS / ERROR MESSAGE ═══ -->
        <?php if (!empty($message)): ?>
          <div style="padding:14px 20px; border-radius:8px; margin-bottom:20px; font-weight:500; font-size:14px;
            background: <?php echo $msg_type == 'success' ? '#dcfce7' : '#fee2e2'; ?>;
            color: <?php echo $msg_type == 'success' ? '#16a34a' : '#dc2626'; ?>;">
            <?php echo $message; ?>
          </div>
        <?php endif; ?>


        <!-- ═══ ADD / EDIT EVENT FORM ═══ -->
        <div class="card mb-3">
          <div class="card__header">
            <div class="card__title"><?php echo $edit_event ? '✏️ Edit Event' : '➕ Add New Event'; ?></div>
          </div>
          <div class="card__body">
            <!-- 
              enctype="multipart/form-data" is REQUIRED for file uploads!
              Without it, $_FILES will be empty.
            -->
            <form method="POST" action="" enctype="multipart/form-data">

              <?php if ($edit_event): ?>
                <!-- Hidden field to send the event ID when editing -->
                <input type="hidden" name="event_id" value="<?php echo $edit_event['id']; ?>">
              <?php endif; ?>

              <div class="form-grid">
                <div class="form-group">
                  <label class="form-label">Event Title *</label>
                  <input type="text" name="title" class="form-input" required
                    value="<?php echo $edit_event ? htmlspecialchars($edit_event['title']) : ''; ?>"
                    placeholder="e.g. World Book Day Celebration">
                </div>
                <div class="form-group">
                  <label class="form-label">Category</label>
                  <select name="category" class="form-select">
                    <?php
                    $categories = ['General', 'Workshop', 'Orientation', 'Exhibition', 'Lecture'];
                    foreach ($categories as $cat): ?>
                      <option value="<?php echo $cat; ?>" <?php echo ($edit_event && $edit_event['category'] == $cat) ? 'selected' : ''; ?>>
                        <?php echo $cat; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label">Event Date</label>
                  <input type="date" name="event_date" class="form-input"
                    value="<?php echo $edit_event ? $edit_event['event_date'] : ''; ?>">
                </div>
                <div class="form-group">
                  <label class="form-label">Location</label>
                  <input type="text" name="location" class="form-input"
                    value="<?php echo $edit_event ? htmlspecialchars($edit_event['location']) : ''; ?>"
                    placeholder="e.g. Central Library Auditorium">
                </div>
                <div class="form-group">
                  <label class="form-label">Status</label>
                  <select name="status" class="form-select">
                    <option value="published" <?php echo ($edit_event && $edit_event['status'] == 'published') ? 'selected' : ''; ?>>Published</option>
                    <option value="draft" <?php echo ($edit_event && $edit_event['status'] == 'draft') ? 'selected' : ''; ?>>Draft</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label">Event Image</label>
                  <input type="file" name="image" class="form-input" accept="image/*">
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-input" rows="3"
                  placeholder="Describe the event..."><?php echo $edit_event ? htmlspecialchars($edit_event['description']) : ''; ?></textarea>
              </div>
              <div style="display:flex; gap:10px; margin-top:16px;">
                <!-- Different submit button names tell PHP which action to perform -->
                <?php if ($edit_event): ?>
                  <button type="submit" name="edit_event" class="btn btn--primary">Update Event</button>
                  <a href="events-manager.php" class="btn btn--outline">Cancel</a>
                <?php else: ?>
                  <button type="submit" name="add_event" class="btn btn--primary">Add Event</button>
                <?php endif; ?>
              </div>
            </form>
          </div>
        </div>


        <!-- ═══ EVENTS TABLE (SELECT from database) ═══ -->
        <div class="card">
          <div class="card__header">
            <div class="card__title">All Events (<?php echo mysqli_num_rows($events_result); ?>)</div>
          </div>
          <div class="card__body card__body--flush">
            <table class="data-table">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Date</th>
                  <th>Location</th>
                  <th>Status</th>
                  <th style="width:120px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Loop through each event and display as a table row
                while ($event = mysqli_fetch_assoc($events_result)):
                  ?>
                  <tr>
                    <td class="cell-title"><?php echo htmlspecialchars($event['title']); ?></td>
                    <td><span class="badge badge--info"><?php echo htmlspecialchars($event['category']); ?></span></td>
                    <td><?php echo $event['event_date'] ? date('d M Y', strtotime($event['event_date'])) : '—'; ?></td>
                    <td><?php echo htmlspecialchars($event['location']); ?></td>
                    <td>
                      <span class="badge badge--<?php echo $event['status'] == 'published' ? 'active' : 'pending'; ?>">
                        <?php echo ucfirst($event['status']); ?>
                      </span>
                    </td>
                    <td>
                      <!-- Edit link: goes to same page with ?edit=ID -->
                      <a href="events-manager.php?edit=<?php echo $event['id']; ?>" class="btn btn--ghost btn--sm"
                        title="Edit">✏️</a>

                      <!-- Delete link: goes to same page with ?delete=ID -->
                      <a href="events-manager.php?delete=<?php echo $event['id']; ?>" class="btn btn--ghost btn--sm"
                        title="Delete" onclick="return confirm('Are you sure you want to delete this event?');">🗑️</a>
                    </td>
                  </tr>
                <?php endwhile; ?>

                <?php if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM events")) == 0): ?>
                  <tr>
                    <td colspan="6" style="text-align:center; padding:40px; color:#999;">
                      No events found. Add your first event above!
                    </td>
                  </tr>
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