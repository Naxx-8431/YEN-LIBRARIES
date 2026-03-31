<?php
require_once __DIR__ . '/auth.php';
checkAuth();
require_once __DIR__ . '/../api/config.php';

$db = getDB();
$sql = "
    SELECT id, name, email, 'Enquiry' as type, message, created_at, IF(is_read=1, 'Closed', 'Pending') as status, 'enquiries' as source_table FROM enquiries
    UNION ALL
    SELECT id, name, email, subject as type, message, created_at, status, 'contacts' as source_table FROM contacts
    UNION ALL
    SELECT id, requester_name as name, NULL as email, 'Book Recommendation' as type, title as message, created_at, status, 'book_recommendations' as source_table FROM book_recommendations
    UNION ALL
    SELECT id, NULL as name, NULL as email, 'Journal Recommendation' as type, title as message, created_at, status, 'journal_recommendations' as source_table FROM journal_recommendations
    ORDER BY created_at DESC
";

$stmt = $db->query($sql);
$requests = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Requests | Yenepoya Libraries Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin-style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .request-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: var(--bg-white);
            padding: 20px 25px;
            border-bottom: 1px solid var(--border-color);
        }

        .filter-group {
            display: flex;
            gap: 10px;
        }

        .filter-btn {
            padding: 8px 15px;
            background-color: var(--bg-light);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-btn.active {
            background-color: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
        }

        .message-preview {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--text-muted);
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="https://library.yenepoya.edu.in/images/Central-Library-logo.png" alt="Logo">

        </div>
        <nav class="nav-menu">
            <a href="index.php" class="nav-item">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>
            <a href="events.html" class="nav-item">
                <i class="fas fa-calendar-alt"></i>
                <span>Manage Events</span>
            </a>
            <a href="new-arrivals.html" class="nav-item">
                <i class="fas fa-book"></i>
                <span>New Arrivals</span>
            </a>
            <a href="requests.php" class="nav-item active">
                <i class="fas fa-envelope-open-text"></i>
                <span>User Requests</span>
            </a>
            <div
                style="padding: 10px 20px; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-top: 20px;">
                Configuration</div>
            <a href="#" class="nav-item">
                <i class="fas fa-database"></i>
                <span>E-Resources</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-users-cog"></i>
                <span>Users & Roles</span>
            </a>
            <a href="logout.php" class="nav-item" style="color:#ef4444; margin-top:30px;">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <div class="page-container">
            <div class="page-header">
                <div class="page-title">
                    <h1>User Enquiries & Requests</h1>
                    <div class="breadcrumb">Admin / Requests</div>
                </div>
                <div class="filter-group">
                    <button class="filter-btn active">All</button>
                    <button class="filter-btn">Pending</button>
                    <button class="filter-btn">Replied</button>
                </div>
            </div>

            <!-- Requests Table -->
            <div class="data-card">
                <div class="request-header">
                    <div style="display: flex; gap: 15px;">
                        <select class="form-control" style="width: auto; padding: 5px 15px;">
                            <option>Type: All</option>
                            <option>General Enquiry</option>
                            <option>Book Recommendation</option>
                            <option>Library Card</option>
                        </select>
                        <select class="form-control" style="width: auto; padding: 5px 15px;">
                            <option>Sort: Newest</option>
                            <option>Sort: Oldest</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Message Snippet</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($requests) === 0): ?>
                            <tr>
                                <td colspan="6" style="text-align:center;padding:20px;">No requests found.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($requests as $req): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($req['name'] ?? 'User'); ?></strong><br>
                                    <?php if ($req['email']): ?>
                                    <small><a href="mailto:<?php echo htmlspecialchars($req['email']); ?>" style="color:var(--text-muted);text-decoration:underline;"><?php echo htmlspecialchars($req['email']); ?></a></small>
                                    <?php else: ?>
                                    <small><em>No email provided</em></small>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($req['type']); ?></td>
                                <td class="message-preview"><?php echo htmlspecialchars(substr($req['message'], 0, 50)) . (strlen($req['message']) > 50 ? '...' : ''); ?></td>
                                <td><?php echo date('d M, Y', strtotime($req['created_at'])); ?></td>
                                <td>
                                    <?php
                                    $statusNorm = strtolower($req['status']);
                                    $statusClass = ($statusNorm === 'pending' || $statusNorm === 'new') ? 'status-pending' : 'status-active';
                                    ?>
                                    <span class="status-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars(ucfirst($req['status'])); ?></span>
                                </td>
                                <td>
                                    <button class="action-btn" title="View Message" onclick="alert('Message:\\n\\n<?php echo htmlspecialchars(addslashes(str_replace(["\r", "\n"], ["", "\\n"], $req['message']))); ?>')"><i class="fas fa-eye"></i></button>
                                    <?php if ($req['email']): ?>
                                    <a href="mailto:<?php echo htmlspecialchars($req['email']); ?>" class="action-btn" title="Reply Email" style="display:inline-block;color:inherit;text-decoration:none;"><i class="fas fa-reply"></i></a>
                                    <?php endif; ?>
                                    <form method="POST" action="api/delete_request.php" style="display:inline;" onsubmit="return confirm('Delete this request permanentely?');">
                                        <input type="hidden" name="id" value="<?php echo $req['id']; ?>">
                                        <input type="hidden" name="table" value="<?php echo $req['source_table']; ?>">
                                        <button type="submit" class="action-btn" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="js/admin-script.js"></script>
</body>

</html>