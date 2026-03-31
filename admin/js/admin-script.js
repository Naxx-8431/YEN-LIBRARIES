document.addEventListener('DOMContentLoaded', function() {
    // Current Page Highlighting
    const currentPath = window.location.pathname;
    const navItems = document.querySelectorAll('.nav-item');
    
    navItems.forEach(item => {
        const href = item.getAttribute('href');
        if (currentPath.includes(href)) {
            item.classList.add('active');
        }
    });

    // Mobile Sidebar Toggle (Simplified for now)
    const toggleSidebar = () => {
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        if (window.innerWidth <= 992) {
            sidebar.style.left = sidebar.style.left === '0px' ? '-100%' : '0px';
            sidebar.style.width = '260px';
        }
    };

    // Generic Add/Edit Modal Logic (Mock)
    window.openModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.style.display = 'flex';
    };

    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.style.display = 'none';
    };

    // Handle Delete confirmation
    window.confirmDelete = function(itemName) {
        return confirm(`Are you sure you want to delete this ${itemName}?`);
    };

    // Form submission (Mock)
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const action = form.getAttribute('data-action') || 'Saved';
            alert(`${action} successfully!`);
            const modal = form.closest('.modal');
            if (modal) modal.style.display = 'none';
        });
    });
});
