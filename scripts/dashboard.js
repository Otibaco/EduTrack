  document.addEventListener('DOMContentLoaded', () => {

        const sidebar = document.getElementById('dashboardSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('mobileToggle');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });
        }

        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        // Close sidebar on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        });

        // Auto-close on window resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth > 820 && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        });

        // Animate bars on load
        setTimeout(() => {
            document.querySelectorAll('.bar-item .bar').forEach(bar => {
                const height = bar.style.height;
                bar.style.height = '0%';
                setTimeout(() => {
                    bar.style.height = height;
                }, 100);
            });
        }, 300);
    });

    // Search input enter key handler
    document.getElementById('searchInput')?.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            const searchTerm = encodeURIComponent(this.value.trim());
            if (searchTerm) {
                window.location.href = '../students.php?search=' + searchTerm;
            } else {
                window.location.href = '../students.php';
            }
        }
    });