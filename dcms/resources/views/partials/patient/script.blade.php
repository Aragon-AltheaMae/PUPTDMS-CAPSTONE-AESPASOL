<script>
    document.addEventListener('DOMContentLoaded', function() {

        const notifBtn = document.getElementById('notifBtn');
        const notifMenu = document.getElementById('notifMenu');

        const userBtn = document.getElementById('userBtn');
        const userMenu = document.getElementById('userMenu');

        if (notifBtn && notifMenu) {
            notifBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                notifMenu.classList.toggle('open');
                if (userMenu) userMenu.classList.remove('open');
            });
        }

        if (userBtn && userMenu) {
            userBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userMenu.classList.toggle('open');
                if (notifMenu) notifMenu.classList.remove('open');
            });
        }

        document.addEventListener('click', function(e) {
            if (notifMenu && !notifMenu.contains(e.target) && !notifBtn.contains(e.target)) {
                notifMenu.classList.remove('open');
            }

            if (userMenu && !userMenu.contains(e.target) && !userBtn.contains(e.target)) {
                userMenu.classList.remove('open');
            }
        });

        const html = document.documentElement;
        const themeToggleContainer = document.getElementById("themeToggle");

        function applyTheme(theme) {
            html.setAttribute("data-theme", theme);
            localStorage.setItem("theme", theme);

            if (themeToggleContainer) {
                const themeOptions = themeToggleContainer.querySelectorAll(".theme-option");
                const themeIndicator = themeToggleContainer.querySelector(".theme-indicator");

                themeOptions.forEach(function(o) {
                    o.classList.toggle("active", o.getAttribute("data-theme") === theme);
                });

                if (themeIndicator) {
                    themeIndicator.classList.toggle("dark-mode", theme === "dark");
                }
            }
        }

        applyTheme(localStorage.getItem("theme") || "light");

        if (themeToggleContainer) {
            const themeOptions = themeToggleContainer.querySelectorAll(".theme-option");
            themeOptions.forEach(function(o) {
                o.addEventListener("click", function(e) {
                    e.stopPropagation();
                    applyTheme(o.getAttribute("data-theme"));
                });
            });
        }

        const mobFab = document.getElementById('mobFab');
        const mobFabMenu = document.getElementById('mobFabMenu');

        if (mobFab && mobFabMenu) {
            mobFab.addEventListener('click', function(e) {
                e.stopPropagation();
                mobFabMenu.classList.toggle('open');
                mobFab.classList.toggle('open');
            });

            mobFabMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        document.addEventListener('click', function(e) {
            if (mobFabMenu && mobFabMenu.classList.contains('open')) {
                mobFabMenu.classList.remove('open');
                if (mobFab) mobFab.classList.remove('open');
            }
        });

        const desktopSidebarToggle = document.getElementById('desktopSidebarToggle');
        const sidebarToggleIcon = document.getElementById('sidebarToggleIcon');
        const body = document.body;

        function applySidebarState() {
            const isCollapsed = body.classList.contains('sidebar-collapsed');

            if (sidebarToggleIcon) {
                sidebarToggleIcon.classList.remove('fa-bars', 'fa-xmark');
                sidebarToggleIcon.classList.add(isCollapsed ? 'fa-bars' : 'fa-xmark');
            }

            localStorage.setItem('patientSidebarCollapsed', isCollapsed ? '1' : '0');
        }

        if (localStorage.getItem('patientSidebarCollapsed') === '1') {
            body.classList.add('sidebar-collapsed');
        }

        applySidebarState();

        if (desktopSidebarToggle) {
            desktopSidebarToggle.addEventListener('click', function() {
                body.classList.toggle('sidebar-collapsed');
                applySidebarState();
            });
        }

        function closeMobFabMenu() {
            if (mobFabMenu) mobFabMenu.classList.remove('open');
            if (mobFab) mobFab.classList.remove('open');
        }

        document.querySelectorAll('[data-quick-action]').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                openQuickAction(btn.getAttribute('data-quick-action'));
            });
        });

    });
</script>
