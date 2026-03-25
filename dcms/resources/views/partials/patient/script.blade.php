<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        /* ══════════════════════════════════════
           DROPDOWN MENUS (Notifications & User)
        ══════════════════════════════════════ */
        const notifBtn = document.getElementById('notifBtn');
        const notifMenu = document.getElementById('notifMenu');
        
        const userBtn = document.getElementById('userBtn');
        const userMenu = document.getElementById('userMenu');

        // Toggle Notifications Menu
        if (notifBtn && notifMenu) {
            notifBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                notifMenu.classList.toggle('open');
                // Close user menu if it's open
                if (userMenu) userMenu.classList.remove('open');
            });
        }

        // Toggle User Profile Menu
        if (userBtn && userMenu) {
            userBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                userMenu.classList.toggle('open');
                // Close notif menu if it's open
                if (notifMenu) notifMenu.classList.remove('open');
            });
        }

        // Close dropdowns when clicking outside of them
        document.addEventListener('click', function (e) {
            if (notifMenu && !notifMenu.contains(e.target) && !notifBtn.contains(e.target)) {
                notifMenu.classList.remove('open');
            }
            
            if (userMenu && !userMenu.contains(e.target) && !userBtn.contains(e.target)) {
                userMenu.classList.remove('open');
            }
        });

        /* ══════════════════════════════════════
           THEME TOGGLE (Light / Dark Mode)
        ══════════════════════════════════════ */
        const html = document.documentElement;
        const themeToggleContainer = document.getElementById("themeToggle");
        
        function applyTheme(theme) {
            html.setAttribute("data-theme", theme);
            localStorage.setItem("theme", theme);
            
            if (themeToggleContainer) {
                const themeOptions = themeToggleContainer.querySelectorAll(".theme-option");
                const themeIndicator = themeToggleContainer.querySelector(".theme-indicator");
                
                // Update active button text color
                themeOptions.forEach(function (o) {
                    o.classList.toggle("active", o.getAttribute("data-theme") === theme);
                });
                
                // Move the white indicator pill
                if (themeIndicator) {
                    themeIndicator.classList.toggle("dark-mode", theme === "dark");
                }
            }
        }

        // Initialize theme on page load (defaults to light if no preference)
        applyTheme(localStorage.getItem("theme") || "light");

        // Add click listeners to the theme toggle buttons
        if (themeToggleContainer) {
            const themeOptions = themeToggleContainer.querySelectorAll(".theme-option");
            themeOptions.forEach(function (o) {
                o.addEventListener("click", function (e) {
                    // Prevent the dropdown from closing when clicking the theme toggle
                    e.stopPropagation(); 
                    applyTheme(o.getAttribute("data-theme"));
                });
            });
        }

        /* ══════════════════════════════════════
           MOBILE FAB (Floating Action Button)
        ══════════════════════════════════════ */
        const mobFab = document.getElementById('mobFab');
        const mobFabMenu = document.getElementById('mobFabMenu');

        if (mobFab && mobFabMenu) {
            // Toggle the menu when the + button is clicked
            mobFab.addEventListener('click', function(e) {
                e.stopPropagation(); // Stop click from bleeding to the document
                mobFabMenu.classList.toggle('open');
                mobFab.classList.toggle('open'); // Rotates the + into an X
            });

            // Prevent the menu from closing if you click inside it
            mobFabMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Close the FAB menu if you click anywhere else on the screen
        document.addEventListener('click', function(e) {
            if (mobFabMenu && mobFabMenu.classList.contains('open')) {
                mobFabMenu.classList.remove('open');
                if (mobFab) mobFab.classList.remove('open');
            }
        });

    });
</script>