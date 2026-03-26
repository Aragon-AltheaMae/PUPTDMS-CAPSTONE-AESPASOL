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

    /* ════════ HEADER ════════ */
    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 50;
        height: var(--header-h);
        background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 100%);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1.5rem;
        box-shadow: 0 1px 0 rgba(255, 255, 255, .08), 0 4px 24px rgba(139, 0, 0, .3);
    }

    .header-logo {
        width: 34px;
        height: 34px;
        object-fit: contain;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, .2));
    }

    .header-divider {
        width: 1px;
        height: 28px;
        background: rgba(255, 255, 255, .2);
        margin: 0 .25rem;
    }

    .header-title {
        font-size: .85rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: .02em;
        text-transform: uppercase;
    }

    .hdr-icon-btn {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .12);
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        transition: background .15s, transform .15s;
        position: relative;
    }

    .hdr-icon-btn:hover {
        background: rgba(255, 255, 255, .2);
        transform: translateY(-1px);
    }

    .notif-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        background: #ff4757;
        color: #fff;
        font-size: .58rem;
        font-weight: 800;
        width: 17px;
        height: 17px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid var(--crimson);
    }

    .header-user-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.1);
        padding: 6px 12px;
        border-radius: 999px;
        cursor: pointer;
    }

    .header-user-btn:hover {
        background: rgba(255, 255, 255, .18);
    }

    .header-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, .4);
        object-fit: cover;
    }

    .header-name {
        font-size: .78rem;
        font-weight: 700;
        color: #fff;
    }

    .header-role {
        font-size: .64rem;
        color: rgba(255, 255, 255, .65);
        margin-top: 2px;
    }

    #notifMenu,
    #userMenu {
        position: absolute;
        right: 0;
        top: calc(100% + 10px);
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, .15), 0 0 0 1px rgba(0, 0, 0, .06);
        opacity: 0;
        transform: scale(.95) translateY(-8px);
        pointer-events: none;
        transition: all .2s cubic-bezier(.4, 0, .2, 1);
        transform-origin: top right;
        z-index: 100;
        overflow: hidden;
    }

    #notifMenu {
        width: 320px;
    }

    #userMenu {
        width: 200px;
    }

    #notifMenu.open,
    #userMenu.open {
        opacity: 1;
        transform: scale(1) translateY(0);
        pointer-events: auto;
    }

    .notif-header,
    .user-menu-header {
        padding: .85rem 1rem .7rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .user-menu-name {
        font-size: .78rem;
        font-weight: 800;
        color: #1a202c;
    }

    .user-menu-role {
        font-size: .65rem;
        color: #9ca3af;
    }

    .user-menu-item {
        display: flex;
        align-items: center;
        gap: .65rem;
        padding: .65rem 1rem;
        font-size: .76rem;
        font-weight: 600;
        color: #374151;
        cursor: pointer;
        transition: background .12s;
        width: 100%;
        text-align: left;
    }

    .user-menu-item:hover {
        background: #f9fafb;
    }

    .user-menu-item.danger {
        color: #ef4444;
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
        overflow: hidden;
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
        padding: 8px;
        width: 48px;
        gap: 0;
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

    /* ════════ THEME TOGGLE ════════ */
    .theme-toggle-container {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
        height: 36px;
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 40px;
        padding: 3px;
    }

    .theme-option {
        z-index: 2;
        flex: 1;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: none;
        cursor: pointer;
        color: #9ca3af;
        border-radius: 40px;
        font-size: 13px;
    }

    .theme-option.active {
        color: #374151;
    }

    .theme-indicator {
        position: absolute;
        background: #fff;
        border-radius: 40px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
        transition: all .3s;
        pointer-events: none;
        width: calc(50% - 3px);
        height: calc(100% - 6px);
        left: 3px;
        top: 3px;
    }

    .theme-indicator.dark-mode {
        transform: translateX(calc(100% + 0px));
    }

    /* ════════ LAYOUT RESPONSIVENESS ════════ */
    #mainContent {
        margin-left: var(--sidebar-w);
        transition: margin-left .25s cubic-bezier(.4, 0, .2, 1);
    }

    @media (max-width: 767px) {
        #sidebar {
            display: none !important;
        }

        #mainContent {
            margin-left: 0 !important;
        }

        #mobileMenuBtn {
            display: flex;
        }

        .header {
            padding: 0 1rem;
        }

        .header-title {
            display: none;
        }
    }

    /* ════════ DARK MODE CORE ════════ */
    body,
    #sidebar,
    main,
    .card,
    .modal-box {
        transition: background-color .3s ease, color .3s ease;
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

    [data-theme="dark"] #userMenu {
        background: #161b22;
        box-shadow: 0 12px 40px rgba(0, 0, 0, .4), 0 0 0 1px rgba(255, 255, 255, .06);
    }

    [data-theme="dark"] .user-menu-header {
        border-color: #21262d;
    }

    [data-theme="dark"] .user-menu-name {
        color: #f3f4f6;
    }

    [data-theme="dark"] .user-menu-item {
        color: #d1d5db;
    }

    [data-theme="dark"] .user-menu-item:hover {
        background: #1c2128;
    }

    [data-theme="dark"] .theme-toggle-container {
        background: #1F1F1F;
        border-color: #2A2A2A;
    }

    [data-theme="dark"] .theme-option {
        color: #6B7280;
    }

    [data-theme="dark"] .theme-option.active {
        color: #F3F4F6;
    }

    [data-theme="dark"] .theme-indicator {
        background: #2A2A2A;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .3);
    }
</style>
