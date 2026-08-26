function getCurrentRole() {
    const sidebar = document.getElementById('sidebar');

    if (
        document.body.classList.contains('role-admin') ||
        sidebar?.classList.contains('sidebar-admin')
    ) {
        return 'admin';
    }

    if (
        document.body.classList.contains('role-dentist') ||
        sidebar?.classList.contains('sidebar-dentist')
    ) {
        return 'dentist';
    }

    if (
        document.body.classList.contains('role-patient') ||
        sidebar?.classList.contains('sidebar-patient')
    ) {
        return 'patient';
    }

    return 'global';
}

function getSidebarStorageKey() {
    const role = getCurrentRole();

    return {
        admin: 'adminSidebarCollapsed',
        dentist: 'dentistSidebarCollapsed',
        patient: 'patientSidebarCollapsed',
        global: 'sidebarCollapsed',
    }[role] || 'sidebarCollapsed';
}

function getSidebarScrollStorageKey() {
    const role = getCurrentRole();

    return {
        admin: 'adminSidebarScrollTop',
        dentist: 'dentistSidebarScrollTop',
        patient: 'patientSidebarScrollTop',
        global: 'sidebarScrollTop',
    }[role] || 'sidebarScrollTop';
}

function initSidebarScrollMemory() {
    const sidebar = document.getElementById('sidebar');
    const sidebarInner = sidebar?.querySelector('.sidebar-inner');

    if (!sidebar || !sidebarInner) return;

    const storageKey = getSidebarScrollStorageKey();

    let isRestoring = true;
    let saveTimer = null;

    const getSavedScroll = () => {
        const saved = Number(localStorage.getItem(storageKey) || 0);
        return Number.isFinite(saved) && saved > 0 ? saved : 0;
    };

    const restoreSidebarScroll = () => {
        const savedScroll = getSavedScroll();

        if (savedScroll > 0) {
            sidebarInner.scrollTop = savedScroll;
        }
    };

    const saveSidebarScroll = () => {
        if (isRestoring) return;

        clearTimeout(saveTimer);

        saveTimer = setTimeout(() => {
            localStorage.setItem(storageKey, String(sidebarInner.scrollTop || 0));
        }, 80);
    };

    restoreSidebarScroll();

    requestAnimationFrame(() => {
        restoreSidebarScroll();

        requestAnimationFrame(() => {
            restoreSidebarScroll();
            isRestoring = false;
        });
    });

    sidebarInner.addEventListener('scroll', saveSidebarScroll, { passive: true });

    document.querySelectorAll('#sidebar a').forEach(link => {
        link.addEventListener('click', () => {
            localStorage.setItem(storageKey, String(sidebarInner.scrollTop || 0));
        });
    });

    window.addEventListener('beforeunload', () => {
        localStorage.setItem(storageKey, String(sidebarInner.scrollTop || 0));
    });

    window.addEventListener('pagehide', () => {
        localStorage.setItem(storageKey, String(sidebarInner.scrollTop || 0));
    });
}

function applySidebarState(isCollapsed) {
    const sidebar = document.getElementById('sidebar');

    if (!sidebar) return;

    const mainContent = document.getElementById('mainContent');
    const currentRole = getCurrentRole();
    const collapsed = Boolean(isCollapsed);

    if (window.innerWidth <= 767 && currentRole !== 'patient') {
        sidebar.classList.remove('collapsed');
        document.body.classList.remove('sidebar-collapsed');

        document.querySelectorAll('#sidebarIcon, #sidebarToggleIcon').forEach(icon => {
            icon.className = 'fa-solid fa-xmark';
        });

        return;
    }

    sidebar.classList.toggle('collapsed', collapsed);
    document.body.classList.toggle('sidebar-collapsed', collapsed);

    if (mainContent) {
        mainContent.classList.toggle('sidebar-content-collapsed', collapsed);
    }

    document.querySelectorAll('#sidebarIcon, #sidebarToggleIcon').forEach(icon => {
        icon.className = collapsed
            ? 'fa-solid fa-bars'
            : 'fa-solid fa-xmark';
    });

    document.querySelectorAll(
        '#sidebarToggleBtn, #desktopSidebarToggle, [data-sidebar-toggle]'
    ).forEach(button => {
        button.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
        button.setAttribute(
            'aria-label',
            collapsed ? 'Expand sidebar' : 'Collapse sidebar'
        );
    });
}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');

    if (!sidebar) return;

    const nextState = !sidebar.classList.contains('collapsed');

    applySidebarState(nextState);

    localStorage.setItem(
        getSidebarStorageKey(),
        nextState ? '1' : '0'
    );
}

function initGlobalSidebar() {
    const sidebar = document.getElementById('sidebar');

    if (!sidebar) {
        document.documentElement.classList.remove(
            'sidebar-preload',
            'sidebar-collapsed-init'
        );

        return;
    }

    const storageKey = getSidebarStorageKey();
    const savedState =
        localStorage.getItem(storageKey) === '1';

    applySidebarState(savedState);

    document.querySelectorAll(
        '#sidebarToggleBtn, #desktopSidebarToggle, [data-sidebar-toggle]'
    ).forEach(button => {
        if (
            button.dataset.sidebarInitialized ===
            'true'
        ) {
            return;
        }

        button.dataset.sidebarInitialized = 'true';

        if (!button.getAttribute('onclick')) {
            button.addEventListener(
                'click',
                event => {
                    event.preventDefault();
                    event.stopPropagation();

                    toggleSidebar();
                }
            );
        }
    });

    requestAnimationFrame(
        () => {
            document.documentElement
                .classList
                .remove(
                    'sidebar-preload',
                    'sidebar-collapsed-init'
                );
        }
    );
}

window.addEventListener(
    'pageshow',
    event => {
        if (!event.persisted) {
            return;
        }
        const sidebar =
            document.getElementById('sidebar');

        if (!sidebar) return;

        const savedState =
            localStorage.getItem(
                getSidebarStorageKey()
            ) === '1';

        applySidebarState(savedState);

        document.documentElement.classList.remove(
            'sidebar-preload',
            'sidebar-collapsed-init'
        );
    });

function initAdminSidebarGroupClick() {
    const sidebar = document.querySelector('#sidebar.sidebar-admin');
    if (!sidebar) return;

    const groups = Array.from(sidebar.querySelectorAll('.nav-group'));

    const isCollapsed = () =>
        sidebar.classList.contains('collapsed') ||
        document.body.classList.contains('sidebar-collapsed');

    const closeGroups = () => {
        sidebar.classList.remove('has-flyout-open');

        groups.forEach(group => {
            group.classList.remove('is-flyout-open');
            group.querySelector('[data-admin-group-toggle]')?.setAttribute('aria-expanded', 'false');
        });
    };

    const openGroup = (targetGroup) => {
        sidebar.classList.add('has-flyout-open');

        groups.forEach(group => {
            const isOpen = group === targetGroup;

            group.classList.toggle('is-flyout-open', isOpen);
            group.querySelector('[data-admin-group-toggle]')?.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    };

    groups.forEach(group => {
        const trigger = group.querySelector('[data-admin-group-toggle]');
        const panel = group.querySelector('.group-body');

        if (!trigger || trigger.dataset.groupClickInitialized === 'true') return;

        trigger.dataset.groupClickInitialized = 'true';

        trigger.addEventListener('click', event => {
            if (!isCollapsed()) return;

            event.preventDefault();
            event.stopPropagation();

            const alreadyOpen = group.classList.contains('is-flyout-open');

            closeGroups();

            if (!alreadyOpen) {
                openGroup(group);
            }
        });

        panel?.addEventListener('click', event => {
            event.stopPropagation();
        });
    });

    document.addEventListener('click', event => {
        if (!sidebar.contains(event.target)) {
            closeGroups();
        }
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            closeGroups();
        }
    });

    window.addEventListener('resize', () => {
        if (!isCollapsed()) {
            closeGroups();
        }
    });

    window.closeAdminSidebarGroups = closeGroups;
}

function openDrawer() {
    const drawer = document.getElementById('mobileDrawer');
    const overlay = document.getElementById('mobileDrawerOverlay');

    if (!drawer || !overlay) return;

    overlay.classList.add('open');
    drawer.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeDrawer() {
    const drawer = document.getElementById('mobileDrawer');
    const overlay = document.getElementById('mobileDrawerOverlay');

    if (!drawer || !overlay) return;

    drawer.classList.remove('open');
    overlay.classList.remove('open');
    document.body.style.overflow = '';
}

function initMobileDrawerControls() {
    const drawerButtons = document.querySelectorAll(
        '#mobileMenuBtn, [data-mobile-menu-toggle], [data-drawer-toggle]'
    );

    drawerButtons.forEach(button => {
        if (button.dataset.drawerToggleInitialized === 'true') return;

        button.dataset.drawerToggleInitialized = 'true';

        button.addEventListener('click', event => {
            event.preventDefault();
            event.stopPropagation();

            const drawer = document.getElementById('mobileDrawer');

            if (drawer?.classList.contains('open')) {
                closeDrawer();
            } else {
                openDrawer();
            }
        });
    });

    document.getElementById('mobileDrawerOverlay')?.addEventListener('click', closeDrawer);

    document.querySelectorAll('[data-drawer-close]').forEach(button => {
        if (button.dataset.drawerCloseInitialized === 'true') return;

        button.dataset.drawerCloseInitialized = 'true';

        button.addEventListener('click', event => {
            event.preventDefault();
            closeDrawer();
        });
    });
}

document.addEventListener(
    'DOMContentLoaded',
    () => {
        initMobileDrawerControls();
        initGlobalSidebar();
        initSidebarScrollMemory();
        initAdminSidebarGroupClick();
    }
);

document.addEventListener(
    'keydown',
    event => {
        if (event.key === 'Escape') {
            closeDrawer();
        }
    }
);

window.openDrawer = openDrawer;
window.closeDrawer = closeDrawer;
window.toggleSidebar = toggleSidebar;
window.applySidebarState = applySidebarState;