<script>
    /* ── MOBILE DRAWER ── */
    function openDrawer() {
        document.getElementById('mobileDrawer').classList.add('open');
        document.getElementById('mobileDrawerOverlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        document.getElementById('mobileDrawer').classList.remove('open');
        document.getElementById('mobileDrawerOverlay').classList.remove('open');
        document.body.style.overflow = '';
    }

    /* ── DROPDOWNS (Notif & User) ── */
    document.getElementById('notifBtn')?.addEventListener('click', e => {
        e.stopPropagation();
        document.getElementById('notifMenu').classList.toggle('open');
        document.getElementById('userMenu').classList.remove('open');
    });

    document.getElementById('userBtn')?.addEventListener('click', e => {
        e.stopPropagation();
        document.getElementById('notifMenu').classList.remove('open');
        document.getElementById('userMenu').classList.toggle('open');
    });

    document.addEventListener('click', () => {
        document.getElementById('notifMenu')?.classList.remove('open');
        document.getElementById('userMenu')?.classList.remove('open');
    });

    /* ── SIDEBAR TOGGLE ── */
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const icon = document.getElementById('sidebarIcon');
        const isCollapsed = sidebar.classList.contains('collapsed');
        if (isCollapsed) {
            sidebar.classList.remove('collapsed');
            sidebar.style.width = '220px';
            document.getElementById('mainContent').style.marginLeft = '220px';
            icon.className = 'fa-solid fa-xmark';
        } else {
            sidebar.classList.add('collapsed');
            sidebar.style.width = '64px';
            document.getElementById('mainContent').style.marginLeft = '64px';
            icon.className = 'fa-solid fa-bars';
        }
    }

    /* ── THEME TOGGLE ── */
    function applyTheme(theme) {
        document.documentElement.setAttribute("data-theme", theme);
        localStorage.setItem("theme", theme);
        document.querySelectorAll(".theme-option").forEach(o =>
            o.getAttribute("data-theme") === theme ? o.classList.add("active") : o.classList.remove("active")
        );
        const ind = document.querySelector(".theme-indicator");
        if (ind) ind.classList.toggle("dark-mode", theme === "dark");
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('#userMenuThemeToggle .theme-option').forEach(o =>
            o.addEventListener('click', e => {
                e.stopPropagation();
                applyTheme(o.getAttribute('data-theme'));
            })
        );
        applyTheme(localStorage.getItem('theme') || 'light');
    });
</script>
