/**
 * GWM Admin JS
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // Command Palette Trigger (Ctrl+K or Cmd+K)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            // TODO: Open search modal
            console.log('Command Palette triggered');
            alert('Command Palette (Search) would open here.');
        }
    });

    // Sidebar Toggle for Mobile
    const toggleBtn = document.querySelector('.gwm-sidebar-toggle');
    const sidebar = document.querySelector('.gwm-sidebar');
    const mainContent = document.querySelector('.gwm-main-content');
    
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    }

    // Initialize Tooltips
    if (typeof $ !== 'undefined' && $.fn.tooltip) {
        $('[data-toggle="tooltip"]').tooltip();
    }
});
