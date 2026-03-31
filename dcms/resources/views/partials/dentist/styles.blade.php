<style>
    :root {
        --crimson: #8B0000;
        --crimson-dark: #6b0000;
        --crimson-light: #fef2f2;
        --crimson-mid: #fce8e8;
        --sidebar-w: 220px;
        --header-h: 64px;
    }

    body {
        font-family: 'Inter';
    }

    html.sidebar-preload #sidebar,
    html.sidebar-preload #mainContent {
        transition: none !important;
    }

    html.sidebar-collapsed-init #sidebar {
        width: 64px !important;
    }

    html.sidebar-collapsed-init #mainContent {
        margin-left: 64px !important;
    }

    html.sidebar-collapsed-init #sidebar .sidebar-nav-text,
    html.sidebar-collapsed-init #sidebar .nav-section-label {
        display: none;
    }

    html.sidebar-collapsed-init #sidebar .sidebar-nav-item {
        justify-content: center;
        width: 100%;
        padding: 8px 0;
        gap: 0;
        overflow: visible;
    }

    html.sidebar-collapsed-init #sidebar .toggle-row {
        justify-content: center !important;
    }

    .fade-in {
        animation: fadeIn .6s ease-out forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(6px)
        }

        to {
            opacity: 1;
            transform: translateY(0)
        }
    }

    /* ════════ SIDEBAR ════════ */
    #sidebar {
        position: fixed;
        left: 0;
        top: var(--header-h);
        width: var(--sidebar-w);
        height: calc(100vh - var(--header-h));
        background: #fff;
        border-right: 1px solid #eff0f2;
        box-shadow: 4px 0 24px rgba(0, 0, 0, .04);
        z-index: 40;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .sidebar-inner {
        flex: 1;
        overflow-y: auto;
        padding: 16px 10px 8px;
    }

    .sidebar-nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 10px;
        border-radius: 10px;
        color: #4a5568;
        font-size: .78rem;
        font-weight: 600;
        transition: all .15s ease;
        white-space: nowrap;
        overflow: visible;
        position: relative;
    }

    .sidebar-tooltip {
        position: absolute;
        left: calc(100% + 12px);
        top: 50%;
        transform: translateY(-50%);
        background: linear-gradient(135deg, #8B0000, #6B0000);
        color: #ffffff;
        font-size: 12px;
        font-weight: 600;
        padding: 6px 10px;
        border-radius: 8px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity .18s ease, visibility .18s ease;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .18);
        z-index: 9999;
    }

    #sidebar.collapsed .sidebar-nav-item:hover .sidebar-tooltip,
    #sidebar.collapsed .sidebar-nav-item:focus-visible .sidebar-tooltip {
        opacity: 1;
        visibility: visible;
    }

    #sidebar:not(.collapsed) .sidebar-tooltip {
        display: none;
    }

    #sidebar.collapsed {
        overflow: visible !important;
    }

    #sidebar.collapsed .sidebar-inner {
        padding-left: 8px;
        padding-right: 8px;
        overflow: visible !important;
    }

    #sidebar.collapsed nav {
        align-items: center;
        overflow: visible;
        position: relative;
    }

    #sidebar.collapsed .sidebar-nav-icon {
        margin: 0;
    }

    #sidebar.collapsed .toggle-row {
        justify-content: center !important;
    }

    .sidebar-nav-item:hover {
        background: #fef2f2;
        color: #8B0000;
    }

    .sidebar-nav-item.active {
        background: linear-gradient(135deg, #8B0000, #6b0000);
        color: #fff;
        box-shadow: 0 3px 10px rgba(139, 0, 0, .25);
    }

    .sidebar-nav-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(139, 0, 0, .07);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: #8B0000;
        flex-shrink: 0;
    }

    .sidebar-nav-item.active .sidebar-nav-icon {
        background: rgba(255, 255, 255, .2);
        color: #fff;
    }

    .nav-section-label {
        font-size: .6rem;
        font-weight: 800;
        color: #b0b7c3;
        text-transform: uppercase;
        letter-spacing: .1em;
        padding: 0 8px 6px;
        margin-top: 4px;
    }

    #sidebar.collapsed {
        width: 64px !important;
    }

    #sidebar.collapsed .sidebar-nav-text,
    #sidebar.collapsed .nav-section-label {
        display: none;
    }

    #sidebar.collapsed .sidebar-nav-item {
        justify-content: center;
        align-items: center;
        width: 100%;
        padding: 8px 0;
        gap: 0;
        overflow: visible;
    }

    #sidebar.collapsed .sidebar-tooltip {
        left: calc(100% + 12px);
    }

    /* ════════ MOBILE DRAWER ════════ */
    #mobileMenuBtn {
        display: none;
        background: rgba(255, 255, 255, .12);
        border: none;
        color: #fff;
        width: 36px;
        height: 36px;
        border-radius: 9px;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    #mobileDrawerOverlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .45);
        z-index: 998;
        backdrop-filter: blur(2px);
        opacity: 0;
        pointer-events: none;
        transition: opacity .25s;
    }

    #mobileDrawerOverlay.open {
        opacity: 1;
        pointer-events: auto;
    }

    #mobileDrawer {
        position: fixed;
        top: 0;
        left: 0;
        width: 280px;
        height: 100vh;
        background: #fff;
        z-index: 999;
        display: flex;
        flex-direction: column;
        transform: translateX(-100%);
        transition: transform .3s;
    }

    #mobileDrawer.open {
        transform: translateX(0);
    }

    .drawer-header {
        background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 100%);
        padding: 20px 18px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .drawer-brand {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .drawer-brand-text {
        font-size: .75rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: .03em;
        line-height: 1.25;
        text-transform: uppercase;
    }

    .drawer-nav {
        flex: 1;
        overflow-y: auto;
        padding: 10px 10px 6px;
    }

    .drawer-section-label {
        font-size: .6rem;
        font-weight: 800;
        color: #b0b7c3;
        text-transform: uppercase;
        padding: 6px 8px 8px;
    }

    .drawer-nav-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 10px;
        color: #4a5568;
        font-size: .8rem;
        font-weight: 600;
        transition: all .15s;
        margin-bottom: 3px;
    }

    .drawer-nav-link:hover {
        background: #fef2f2;
        color: #8B0000;
        transform: translateX(3px);
    }

    .drawer-nav-link.active {
        background: linear-gradient(135deg, #8B0000, #6b0000);
        color: #fff;
        box-shadow: 0 3px 12px rgba(139, 0, 0, .25);
    }

    .dnav-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(139, 0, 0, .08);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8B0000;
    }

    .drawer-nav-link.active .dnav-icon {
        background: rgba(255, 255, 255, .2);
        color: #fff;
    }

    .drawer-footer {
        padding: 10px 12px 16px;
        border-top: 1px solid #f3f4f6;
    }

    .drawer-close-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: rgba(255, 255, 255, .15);
        color: #fff;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        border: none;
    }

    /* ════════ MAIN CONTENT ════════ */
    #mainContent {
        margin-left: var(--sidebar-w);
        /* 220px by default */
        transition: margin-left 0.3s ease;
        /* Smooth sliding animation */
    }

    @media (max-width: 767px) {
        #sidebar {
            display: none !important;
        }

        #mainContent {
            margin-left: 0 !important;
        }

        #mobileMenuBtn {
            display: flex !important;
        }
    }


    [data-theme="dark"] body {
        background-color: #000D1A;
        color: #E5E7EB;
    }

    [data-theme="dark"] #sidebar {
        background-color: #000D1A;
        border-color: #1F1F1F;
    }

    [data-theme="dark"] .bg-white {
        background-color: #000D1A !important;
    }

    [data-theme="dark"] .text-\[\#333333\] {
        color: #E5E7EB !important;
    }
</style>