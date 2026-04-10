<?php
if (!isset($conn)) {
    require_once __DIR__ . '/../db.php';
}

function time_elapsed_string($datetime, $full = false) {
    if (!$datetime) return 'a while ago';
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

// Fetch latest notifications logic!
$notifs_q = false;
$notif_count = 0;

// Try fetching only if table exists (graceful failure)
try {
    $notifs_q = @mysqli_query($conn, "SELECT * FROM notifications ORDER BY created_at DESC LIMIT 5");
    if ($notifs_q) {
        $notif_count = mysqli_num_rows($notifs_q);
    }
} catch (Exception $e) {
    // If table doesn't exist yet, ignore
}
?>

<!-- ═══════════════ NOTIFICATION SIDEBAR ═════════ -->
<button class="notif-toggle" onclick="toggleNotifications()" aria-label="Notifications">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
  </svg>
  <?php if($notif_count > 0): ?>
    <span class="notif-badge"><?php echo $notif_count; ?></span>
  <?php endif; ?>
</button>

<div class="notif-sidebar" id="notifSidebar">
  <div class="notif-header">
    <h3>Latest Updates</h3>
    <button class="notif-close" aria-label="Close" onclick="toggleNotifications()">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M18 6L6 18M6 6l12 12" />
      </svg>
    </button>
  </div>
  <div class="notif-body">
    <?php if($notif_count > 0): ?>
      <?php while($n = mysqli_fetch_assoc($notifs_q)): ?>
        <a href="<?php echo htmlspecialchars($n['link_url'] ?? '#'); ?>" class="notif-item" style="display:block; text-decoration:none; color:inherit; border-bottom:1px solid rgba(0,0,0,0.05); padding-bottom:12px; margin-bottom:12px;">
          <span class="notif-time" style="display:block; font-size:11px; color:var(--clr-primary, #666); font-weight:600; margin-bottom:4px;"><?php echo time_elapsed_string($n['created_at']); ?></span>
          <strong style="display:block; font-size:14px; color:#333; margin-bottom:4px;"><?php echo htmlspecialchars($n['title']); ?></strong>
          <span style="display:block; font-size:13px; color:#666; line-height:1.5;">
            <?php echo htmlspecialchars($n['message']); ?>
          </span>
        </a>
      <?php endwhile; ?>
    <?php else: ?>
      <div style="padding:20px; text-align:center; color:#999; font-size:14px;">No new updates</div>
    <?php endif; ?>
  </div>
</div>
