/* ═══════════════════════════════════════════════════════
   YENEPOYA LIBRARIES — ADMIN CORE JS
   Sidebar toggle, navigation, modals, toasts, action menus
   ═══════════════════════════════════════════════════════ */

// Auth is now handled by PHP sessions (see login.php)
// No client-side auth check needed

// ── Sidebar Toggle (Mobile) ──
function toggleSidebar() {
  document.querySelector('.sidebar').classList.toggle('open');
  document.querySelector('.sidebar-overlay').classList.toggle('open');
}

// Close sidebar when overlay is clicked
document.addEventListener('click', (e) => {
  if (e.target.classList.contains('sidebar-overlay')) {
    toggleSidebar();
  }
});

// ── Active Navigation ──
(function setActiveNav() {
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.sidebar__link').forEach(link => {
    const href = link.getAttribute('href');
    if (!href) return;
    const linkPage = href.split('/').pop();
    if (linkPage === currentPage) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });
})();

// ── Modal ──
function openModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
  }
}

function closeModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.classList.remove('open');
    document.body.style.overflow = '';
  }
}

// Close modal on overlay click
document.addEventListener('click', (e) => {
  if (e.target.classList.contains('modal-overlay')) {
    e.target.classList.remove('open');
    document.body.style.overflow = '';
  }
});

// ── Action Menu (three-dot) ──
function toggleActionMenu(btn) {
  // Close all other menus first
  document.querySelectorAll('.action-menu.open').forEach(m => {
    if (m !== btn.nextElementSibling) m.classList.remove('open');
  });
  const menu = btn.nextElementSibling;
  if (menu) menu.classList.toggle('open');
}

// Close all action menus on outside click
document.addEventListener('click', (e) => {
  if (!e.target.closest('.action-btn') && !e.target.closest('.action-menu')) {
    document.querySelectorAll('.action-menu.open').forEach(m => m.classList.remove('open'));
  }
});

// ── Toast Notifications ──
function showToast(type, message) {
  const container = document.querySelector('.toast-container') || createToastContainer();
  const toast = document.createElement('div');
  toast.className = `toast toast--${type}`;
  toast.innerHTML = `
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      ${type === 'success' ? '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>' :
        type === 'error' ? '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>' :
        '<circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>'}
    </svg>
    <span>${message}</span>
    <button class="toast__close" onclick="this.parentElement.remove()">×</button>
  `;
  container.appendChild(toast);
  requestAnimationFrame(() => toast.classList.add('show'));
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 400);
  }, 3500);
}

function createToastContainer() {
  const c = document.createElement('div');
  c.className = 'toast-container';
  document.body.appendChild(c);
  return c;
}

// ── Delete Confirm ──
function confirmDelete(itemName, callback) {
  openModal('deleteModal');
  const nameEl = document.querySelector('#deleteModal .delete-item-name');
  if (nameEl) nameEl.textContent = itemName;
  const confirmBtn = document.querySelector('#deleteModal .btn--danger');
  if (confirmBtn) {
    confirmBtn.onclick = () => {
      closeModal('deleteModal');
      if (callback) callback();
      showToast('success', `"${itemName}" deleted successfully`);
    };
  }
}

// Logout is now handled by PHP (see logout.php)
// No client-side logout needed

// ── Table Search (simple client-side) ──
function initTableSearch(inputId, tableId) {
  const input = document.getElementById(inputId);
  const table = document.getElementById(tableId);
  if (!input || !table) return;

  input.addEventListener('input', () => {
    const filter = input.value.toLowerCase();
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(filter) ? '' : 'none';
    });
  });
}

// ── Form Save Simulation ──
function handleSave(formId) {
  const form = document.getElementById(formId);
  if (form && !form.checkValidity()) {
    form.reportValidity();
    return;
  }
  showToast('success', 'Changes saved successfully!');
}

// ── Keyboard shortcut: Escape closes modals ──
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    document.querySelectorAll('.modal-overlay.open').forEach(m => {
      m.classList.remove('open');
      document.body.style.overflow = '';
    });
    document.querySelectorAll('.action-menu.open').forEach(m => m.classList.remove('open'));
  }
});
