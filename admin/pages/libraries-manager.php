<?php require_once 'libraries-manager-logic.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Libraries Manager — Yenepoya Libraries Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../admin/assets/css/admin.css">
</head>
<body>
  <div class="admin-layout">
    <aside class="sidebar" id="sidebar">
      <div class="sidebar__brand"><img src="../../images/logo/Central-Library-logo.png" alt="logo"></div>
      <nav class="sidebar__group">
        <div class="sidebar__group-label">Navigation</div>
        <a href="../index.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>Dashboard</a>
        <a href="home-manager.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>Homepage</a>
        <a href="libraries-manager.php" class="sidebar__link active"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>Libraries</a>
        <a href="events-manager.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Events</a>
        <a href="e-resources-manager.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>E-Resources</a>
        <a href="messages.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>Messages</a>
        <a href="notifications-manager.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>Notifications</a>
        <a href="settings.php" class="sidebar__link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9c.26.604.852.997 1.51 1H21a2 2 0 0 1 0 4h-.09c-.658.003-1.25.396-1.51 1z"/></svg>Settings</a>
      </nav>
    </aside>
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <div class="admin-main">
      <header class="topbar">
        <div class="topbar__left">
          <button class="topbar__burger" onclick="toggleSidebar()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
          <h1 class="topbar__title">Libraries Manager</h1>
        </div>
        <div class="topbar__right">
          <a href="../logout.php" class="topbar__logout"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Logout</a>
        </div>
      </header>

      <div class="admin-content">
        <div class="page-header">
          <div class="page-header__left">
            <h1>Libraries Manager</h1>
            <p>Add, edit, and manage constituent libraries</p>
          </div>
        </div>

        <?php if (!empty($message)): ?>
        <div style="padding:14px 20px; border-radius:8px; margin-bottom:20px; font-weight:500; font-size:14px;
          background: <?php echo $msg_type=='success' ? '#dcfce7' : '#fee2e2'; ?>;
          color: <?php echo $msg_type=='success' ? '#16a34a' : '#dc2626'; ?>;">
          <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <!-- ADD / EDIT FORM -->
        <div class="card mb-3">
          <div class="card__header">
            <div class="card__title"><?php echo $edit_lib ? 'Edit Library' : 'Add New Library'; ?></div>
          </div>
          <div class="card__body">
            <form method="POST" enctype="multipart/form-data">
              <?php if ($edit_lib): ?>
              <input type="hidden" name="library_id" value="<?php echo $edit_lib['id']; ?>">
              <?php endif; ?>

              <div class="form-grid">
                <div class="form-group">
                  <label class="form-label">Library Name *</label>
                  <input type="text" name="library_name" class="form-input" required value="<?php echo $edit_lib ? htmlspecialchars($edit_lib['library_name']) : ''; ?>" placeholder="e.g. Central Library">
                </div>
                <div class="form-group">
                  <label class="form-label">Slug * (URL anchor)</label>
                  <input type="text" name="slug" class="form-input" required value="<?php echo $edit_lib ? htmlspecialchars($edit_lib['slug']) : ''; ?>" placeholder="e.g. central-library">
                </div>
                <div class="form-group">
                  <label class="form-label">Section Label</label>
                  <input type="text" name="section_label" class="form-input" value="<?php echo $edit_lib ? htmlspecialchars($edit_lib['section_label']) : 'Constituent Library'; ?>">
                </div>
                <div class="form-group">
                  <label class="form-label">Icon</label>
                  <select name="icon_name" class="form-select">
                    <?php foreach ($icon_options as $ico): ?>
                    <option value="<?php echo $ico; ?>" <?php echo ($edit_lib && $edit_lib['icon_name']==$ico)?'selected':''; ?>><?php echo ucfirst($ico); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label">Established Year</label>
                  <input type="text" name="established_year" class="form-input" value="<?php echo $edit_lib ? htmlspecialchars($edit_lib['established_year']) : ''; ?>" placeholder="e.g. 2018">
                </div>
                <div class="form-group">
                  <label class="form-label">Campus / Location</label>
                  <input type="text" name="campus" class="form-input" value="<?php echo $edit_lib ? htmlspecialchars($edit_lib['campus']) : ''; ?>">
                </div>
                <div class="form-group">
                  <label class="form-label">Subject Area</label>
                  <input type="text" name="subject_area" class="form-input" value="<?php echo $edit_lib ? htmlspecialchars($edit_lib['subject_area']) : ''; ?>">
                </div>
                <div class="form-group">
                  <label class="form-label">Programmes</label>
                  <input type="text" name="programmes" class="form-input" value="<?php echo $edit_lib ? htmlspecialchars($edit_lib['programmes']) : ''; ?>">
                </div>
                <div class="form-group">
                  <label class="form-label">Books Count</label>
                  <input type="text" name="books_count" class="form-input" value="<?php echo $edit_lib ? htmlspecialchars($edit_lib['books_count']) : ''; ?>" placeholder="e.g. 8,338">
                </div>
                <div class="form-group">
                  <label class="form-label">Journals Count</label>
                  <input type="text" name="journals_count" class="form-input" value="<?php echo $edit_lib ? htmlspecialchars($edit_lib['journals_count']) : ''; ?>">
                </div>
                <div class="form-group">
                  <label class="form-label">Back Volumes</label>
                  <input type="text" name="back_volumes" class="form-input" value="<?php echo $edit_lib ? htmlspecialchars($edit_lib['back_volumes']) : ''; ?>">
                </div>
                <div class="form-group">
                  <label class="form-label">Theses Count</label>
                  <input type="text" name="theses_count" class="form-input" value="<?php echo $edit_lib ? htmlspecialchars($edit_lib['theses_count']) : ''; ?>">
                </div>
                <div class="form-group">
                  <label class="form-label">E-Journals Count</label>
                  <input type="text" name="ejournals_count" class="form-input" value="<?php echo $edit_lib ? htmlspecialchars($edit_lib['ejournals_count']) : ''; ?>">
                </div>
                <div class="form-group">
                  <label class="form-label">Card Footer Meta</label>
                  <input type="text" name="card_meta" class="form-input" value="<?php echo $edit_lib ? htmlspecialchars($edit_lib['card_meta']) : ''; ?>" placeholder="e.g. Est. 2018 · YAMCH">
                </div>
                <div class="form-group">
                  <label class="form-label">Contact Email</label>
                  <input type="email" name="contact_email" class="form-input" value="<?php echo $edit_lib ? htmlspecialchars($edit_lib['contact_email']) : ''; ?>">
                </div>
                <div class="form-group">
                  <label class="form-label">Display Order</label>
                  <input type="number" name="display_order" class="form-input" value="<?php echo $edit_lib ? $edit_lib['display_order'] : '0'; ?>">
                </div>
                <div class="form-group">
                  <label class="form-label">Status</label>
                  <select name="status" class="form-select">
                    <option value="active" <?php echo ($edit_lib && $edit_lib['status']=='active')?'selected':''; ?>>Active</option>
                    <option value="inactive" <?php echo ($edit_lib && $edit_lib['status']=='inactive')?'selected':''; ?>>Inactive</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label">Thumbnail Image</label>
                  <input type="file" name="thumbnail" class="form-input" accept="image/*">
                  <?php if ($edit_lib && $edit_lib['thumbnail']): ?>
                  <img src="../../<?php echo htmlspecialchars($edit_lib['thumbnail']); ?>" style="max-width:120px;margin-top:8px;border-radius:6px;">
                  <?php endif; ?>
                </div>
              </div>

              <div class="form-group" style="margin-top:16px;">
                <label class="form-label">Short Description (for homepage card)</label>
                <textarea name="short_description" class="form-input" rows="2"><?php echo $edit_lib ? htmlspecialchars($edit_lib['short_description']) : ''; ?></textarea>
              </div>
              <div class="form-group">
                <label class="form-label">Full Description (for about page — HTML allowed)</label>
                <textarea name="full_description" class="form-input" rows="5"><?php echo $edit_lib ? htmlspecialchars($edit_lib['full_description']) : ''; ?></textarea>
              </div>
              <div class="form-group">
                <label class="form-label">Contact Info (HTML allowed)</label>
                <textarea name="contact_info" class="form-input" rows="2"><?php echo $edit_lib ? htmlspecialchars($edit_lib['contact_info']) : ''; ?></textarea>
              </div>
              <div class="form-group">
                <label class="form-label">Working Hours (JSON)</label>
                <textarea name="working_hours_json" class="form-input" rows="4" placeholder='{"columns":["","Week Days"],"rows":[{"label":"Working Hours","values":["09.00 am to 05.00 pm"]}]}'><?php echo $edit_lib ? htmlspecialchars($edit_lib['working_hours']) : ''; ?></textarea>
              </div>

              <!-- Gallery -->
              <div class="form-group" style="margin-top:16px; padding-top:16px; border-top:1px solid #e5e7eb;">
                <label class="form-label">Gallery Images (select multiple)</label>
                <input type="file" name="gallery[]" class="form-input" accept="image/*" multiple>
                <input type="text" name="gallery_captions[]" class="form-input" placeholder="Caption for images (optional)" style="margin-top:8px;">
              </div>

              <?php if ($edit_lib && !empty($edit_gallery)): ?>
              <div style="margin-top:12px;">
                <label class="form-label">Current Gallery (<?php echo count($edit_gallery); ?> images)</label>
                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:8px;">
                  <?php foreach ($edit_gallery as $gi): ?>
                  <div style="position:relative;">
                    <img src="../../<?php echo htmlspecialchars($gi['image_path']); ?>" style="width:100px;height:70px;object-fit:cover;border-radius:6px;border:1px solid #e5e7eb;">
                    <a href="libraries-manager.php?delete_gallery=<?php echo $gi['id']; ?>&lib=<?php echo $edit_lib['id']; ?>" onclick="return confirm('Remove this image?')" style="position:absolute;top:-6px;right:-6px;width:20px;height:20px;background:#dc2626;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;text-decoration:none;">×</a>
                    <div style="font-size:10px;color:#888;margin-top:2px;max-width:100px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo htmlspecialchars($gi['caption']); ?></div>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
              <?php endif; ?>

              <div style="display:flex;gap:10px;margin-top:20px;">
                <?php if ($edit_lib): ?>
                <button type="submit" name="edit_library" class="btn btn--primary">Update Library</button>
                <a href="libraries-manager.php" class="btn btn--outline">Cancel</a>
                <?php else: ?>
                <button type="submit" name="add_library" class="btn btn--primary">Add Library</button>
                <?php endif; ?>
              </div>
            </form>
          </div>
        </div>

        <!-- LIBRARIES TABLE -->
        <div class="card">
          <div class="card__header">
            <div class="card__title">All Libraries (<?php echo mysqli_num_rows($libraries_result); ?>)</div>
          </div>
          <div class="card__body card__body--flush">
            <table class="data-table">
              <thead>
                <tr>
                  <th>Library</th>
                  <th>Slug</th>
                  <th>Order</th>
                  <th>Status</th>
                  <th style="width:140px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($lib = mysqli_fetch_assoc($libraries_result)): ?>
                <tr>
                  <td class="cell-title"><?php echo htmlspecialchars($lib['library_name']); ?></td>
                  <td><?php echo htmlspecialchars($lib['slug']); ?></td>
                  <td><?php echo $lib['display_order']; ?></td>
                  <td><span class="badge badge--<?php echo $lib['status']=='active'?'active':'pending'; ?>"><?php echo ucfirst($lib['status']); ?></span></td>
                  <td>
                    <a href="libraries-manager.php?edit=<?php echo $lib['id']; ?>" class="btn btn--ghost btn--sm" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10z"/></svg></a>
                    <?php if ($lib['status']=='active'): ?>
                    <a href="libraries-manager.php?delete=<?php echo $lib['id']; ?>" class="btn btn--ghost btn--sm" title="Deactivate" onclick="return confirm('Deactivate this library?');"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg></a>
                    <?php else: ?>
                    <a href="libraries-manager.php?activate=<?php echo $lib['id']; ?>" class="btn btn--ghost btn--sm" title="Activate" style="color:#16a34a;">✓</a>
                    <?php endif; ?>
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
