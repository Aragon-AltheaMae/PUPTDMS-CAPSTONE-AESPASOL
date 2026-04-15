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
    const desktopBreakpoint = window.matchMedia('(min-width: 1200px)');

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
        if (body.classList.contains('role-admin')) return 'admin';
        return 'default';
    }

    function getSidebarStorageKey() {
        return `sidebar-collapsed-${getRoleFromBody()}`;
    }

    function applySidebarStateFromStorage() {
        if (!desktopBreakpoint.matches) return;
        const saved = localStorage.getItem(getSidebarStorageKey());
        body.classList.toggle('sidebar-collapsed', saved === 'true');
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

    function setButtonState(button, isActive) {
        if (!button) return;
        button.classList.toggle('active', isActive);
        button.setAttribute('aria-expanded', isActive ? 'true' : 'false');
    }

    function openMenu(menu, button) {
        if (!menu) return;
        menu.classList.add('show');
        setButtonState(button, true);
    }

    function closeMenu(menu, button) {
        if (!menu) return;
        menu.classList.remove('show');
        setButtonState(button, false);
    }

    function closeAllMenus(except = null) {
        if (except !== 'notif') closeMenu(notifMenu, notifBtn);
        if (except !== 'user') closeMenu(userMenu, userBtn);
    }

    function toggleMenu(type) {
        if (type === 'notif' && notifMenu) {
            const willOpen = !notifMenu.classList.contains('show');
            closeAllMenus('notif');
            if (willOpen) {
                openMenu(notifMenu, notifBtn);
            } else {
                closeMenu(notifMenu, notifBtn);
            }
        }

        if (type === 'user' && userMenu) {
            const willOpen = !userMenu.classList.contains('show');
            closeAllMenus('user');
            if (willOpen) {
                openMenu(userMenu, userBtn);
            } else {
                closeMenu(userMenu, userBtn);
            }
        }
    }

    if (notifBtn && notifMenu) {
        notifBtn.setAttribute('aria-expanded', 'false');
        notifBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMenu('notif');
        });
    }

    if (userBtn && userMenu) {
        userBtn.setAttribute('aria-expanded', 'false');
        userBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMenu('user');
        });
    }

    document.addEventListener('click', function (e) {
        const clickedNotif = notifDropdown && notifDropdown.contains(e.target);
        const clickedUser = userDropdown && userDropdown.contains(e.target);

        if (!clickedNotif && !clickedUser) {
            closeAllMenus();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeAllMenus();
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