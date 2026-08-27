export function openFilterDrawer(panelId = 'filterModal', overlayId = null) {
    const panel = document.getElementById(panelId);

    if (!panel) return;

    const overlay = overlayId
        ? document.getElementById(overlayId)
        : panel.querySelector('.filter-drawer-overlay');

    document.documentElement.classList.add('filter-lock');
    document.body.classList.add('filter-lock');

    panel.classList.remove('closing');
    panel.classList.add('open');
    panel.setAttribute('aria-hidden', 'false');

    overlay?.classList.add('open');
}

export function closeFilterDrawer(panelId = 'filterModal', overlayId = null) {
    const panel = document.getElementById(panelId);

    if (!panel) return;

    const overlay = overlayId
        ? document.getElementById(overlayId)
        : panel.querySelector('.filter-drawer-overlay');

    overlay?.classList.remove('open');

    panel.classList.remove('open');
    panel.classList.add('closing');
    panel.setAttribute('aria-hidden', 'true');

    window.clearTimeout(panel.__filterCloseTimer);

    panel.__filterCloseTimer = window.setTimeout(() => {
        panel.classList.remove('closing');

        const anotherDrawerIsActive = document.querySelector(
            '.filter-drawer-wrapper.open, .filter-drawer-wrapper.closing'
        );

        if (!anotherDrawerIsActive) {
            document.documentElement.classList.remove('filter-lock');
            document.body.classList.remove('filter-lock');
        }
    }, 300);
}

export function openFilterPanel() {
    openFilterDrawer('filterPanel', 'filterOverlay');
}

export function closeFilterPanel() {
    closeFilterDrawer('filterPanel', 'filterOverlay');
}