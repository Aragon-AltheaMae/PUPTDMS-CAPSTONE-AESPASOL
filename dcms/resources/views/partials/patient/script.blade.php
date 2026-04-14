<script>
    document.addEventListener('DOMContentLoaded', function() {

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
                
                const notifMenu = document.getElementById('notifMenu');
                const userMenu = document.getElementById('userMenu');
                if (notifMenu) notifMenu.classList.remove('show');
                if (userMenu) userMenu.classList.remove('show');

                mobFabMenu.classList.toggle('open');
                mobFab.classList.toggle('open');
            });

            mobFabMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        document.addEventListener('click', function(e) {
            if (!mobFabMenu || !mobFab) return;

            const clickedInsideMenu = mobFabMenu.contains(e.target);
            const clickedFab = mobFab.contains(e.target);

            if (!clickedInsideMenu && !clickedFab && mobFabMenu.classList.contains('open')) {
                mobFabMenu.classList.remove('open');
                mobFab.classList.remove('open');
            }
        });

        document.querySelectorAll('[data-quick-action]').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                if (mobFabMenu && mobFabMenu.classList.contains('open')) {
                    mobFabMenu.classList.remove('open');
                    mobFab.classList.remove('open');
                }

                openQuickAction(btn.getAttribute('data-quick-action'));
            });
        });

    });
</script>