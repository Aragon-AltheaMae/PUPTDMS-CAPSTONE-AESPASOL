document.addEventListener('DOMContentLoaded', function () {

    function updateSidebarToggleIcon() {
        const icon = document.getElementById('sidebarToggleIcon');
        if (!icon) return;

        if (document.body.classList.contains('sidebar-collapsed')) {
            icon.classList.remove('fa-xmark');
            icon.classList.add('fa-bars');
        } else {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-xmark');
        }
    }

    const body = document.body;
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const desktopSidebarToggle = document.getElementById('desktopSidebarToggle');
    const desktopBreakpoint = window.matchMedia('(min-width: 1024px)');

    if (desktopSidebarToggle) {
        desktopSidebarToggle.addEventListener('click', function (e) {
            if (!desktopBreakpoint.matches) return;
            e.preventDefault();
            toggleDesktopSidebar();
        });
    }

    function getRoleFromBody() {
        if (body.classList.contains('role-dentist')) return 'dentist';
        if (body.classList.contains('role-patient')) return 'patient';
        return 'default';
    }

    function getSidebarStorageKey() {
        return `sidebar-collapsed-${getRoleFromBody()}`;
    }

    function applySidebarStateFromStorage() {
        if (!desktopBreakpoint.matches) return;

        const saved = localStorage.getItem(getSidebarStorageKey());
        if (saved === 'true') {
            body.classList.add('sidebar-collapsed');
        } else {
            body.classList.remove('sidebar-collapsed');
        }
    }

    function toggleDesktopSidebar() {
        if (!desktopBreakpoint.matches) return;

        body.classList.toggle('sidebar-collapsed');
        localStorage.setItem(
            getSidebarStorageKey(),
            body.classList.contains('sidebar-collapsed') ? 'true' : 'false'
        );

        updateSidebarToggleIcon();
    }

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function (e) {
            if (desktopBreakpoint.matches) {
                e.preventDefault();
                toggleDesktopSidebar();
                return;
            }

            if (body.classList.contains('role-dentist') && typeof openDrawer === 'function') {
                openDrawer();
            }
        });
    }

    applySidebarStateFromStorage();
    updateSidebarToggleIcon();

    window.addEventListener('resize', function () {
        if (desktopBreakpoint.matches) {
            applySidebarStateFromStorage();
        } else {
            body.classList.remove('sidebar-collapsed');
        }
    });
    const notifBtn = document.getElementById('notifBtn');
    const notifMenu = document.getElementById('notifMenu');
    const notifDropdown = document.getElementById('notifDropdown');

    const userBtn = document.getElementById('userBtn');
    const userMenu = document.getElementById('userMenu');
    const userDropdown = document.getElementById('userDropdown');

    function closeMenus(except = null) {
        if (notifMenu && except !== 'notif') notifMenu.classList.remove('show');
        if (userMenu && except !== 'user') userMenu.classList.remove('show');
    }

    if (notifBtn && notifMenu) {
        notifBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = notifMenu.classList.contains('show');
            closeMenus();
            if (!isOpen) notifMenu.classList.add('show');
        });
    }

    if (userBtn && userMenu) {
        userBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = userMenu.classList.contains('show');
            closeMenus();
            if (!isOpen) userMenu.classList.add('show');
        });
    }

    document.addEventListener('click', function (e) {
        if (notifDropdown && !notifDropdown.contains(e.target)) {
            notifMenu?.classList.remove('show');
        }

        if (userDropdown && !userDropdown.contains(e.target)) {
            userMenu?.classList.remove('show');
        }
    });

    const themeCheckbox = document.getElementById('themeSwitchCheckbox');
    const themeIcon = document.getElementById('themeIcon');

    if (themeCheckbox && themeIcon) {
        const currentTheme = localStorage.getItem('theme') || 'light';

        if (currentTheme === 'dark') {
            themeCheckbox.checked = true;
            document.documentElement.setAttribute('data-theme', 'dark');
            themeIcon.className = 'fa-solid fa-moon text-gray-400 text-base';
        } else {
            themeCheckbox.checked = false;
            document.documentElement.setAttribute('data-theme', 'light');
            themeIcon.className = 'fa-regular fa-sun text-gray-400 text-base';
        }

        themeCheckbox.addEventListener('change', (e) => {
            if (e.target.checked) {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                themeIcon.className = 'fa-solid fa-moon text-gray-400 text-base';
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
                localStorage.setItem('theme', 'light');
                themeIcon.className = 'fa-regular fa-sun text-gray-400 text-base';
            }
        });
    }
});