<style>
    :root {
        --crimson: #8B0000;
        --crimson-dark: #6b0000;
        --crimson-light: #fef2f2;
        --header-h: 64px;
        --sidebar-w: 220px;
        --crimson-soft: #FDF1F1;
        --crimson-mid: rgba(139, 0, 0, .12);
        --surface: #FAFAF8;
        --card: #FFFFFF;
        --border: #EDE8E4;
        --text-1: #1C1410;
        --text-2: #5C5550;
        --text-3: #9E9690;
        --gold: #C9A84C;
    }

    [data-theme="dark"] body {
        background-color: #000D1A;
        color: #E5E7EB;
    }

    #sidebar {
        position: fixed;
        top: var(--header-h);
        left: 0;
        width: clamp(200px, 20vw, 220px);
        height: calc(100dvh - var(--header-h));
        min-height: calc(100vh - var(--header-h));
        background: #fff;
        border-right: 1px solid #f0eaea;
        box-shadow: 2px 0 16px rgba(139, 0, 0, .05);
        z-index: 40;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .sidebar-inner {
        flex: 1;
        padding: 20px 14px 8px;
        overflow-y: auto;
    }

    .nav-section-label {
        font-size: .6rem;
        font-weight: 800;
        color: #b0b7c3;
        text-transform: uppercase;
        letter-spacing: .1em;
        padding: 0 8px 6px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        min-width: 0;
        padding: 10px 14px;
        border-radius: 12px;
        margin-bottom: 4px;
        font-size: .8rem;
        font-weight: 600;
        color: #4a5568;
        text-decoration: none;
        transition: all .2s;
        position: relative;
        overflow: visible;
    }

    .nav-link i {
        font-size: 14px;
        color: var(--crimson);
        width: 20px;
        text-align: center;
    }

    .nav-link:hover {
        background: var(--crimson-light);
        color: var(--crimson);
    }

    .nav-link.active {
        background: linear-gradient(135deg, var(--crimson) 0%, var(--crimson-dark) 100%);
        color: #fff;
        box-shadow: 0 4px 12px rgba(139, 0, 0, .25);
    }

    .nav-link.active i {
        color: #fff;
    }

    .sidebar-bottom {
        padding: 14px;
        border-top: 1px solid #f3f4f6;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        border: none;
        background: none;
        cursor: pointer;
        color: #ef4444;
        font-size: .8rem;
        font-weight: 700;
        transition: background .15s;
    }

    .logout-btn:hover {
        background: #fef2f2;
    }

    .logout-icon {
        width: 32px;
        height: 32px;
        background: #fef2f2;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #mobileBottomNav {
        width: min(calc(100vw - 32px), 420px);
        max-width: 420px;
    }

    #mobFabMenu {
        position: fixed;
        left: 50%;
        bottom: 96px;
        width: min(230px, calc(100vw - 32px));
        visibility: hidden;
        opacity: 0;
        transform: translateX(-50%) translateY(10px) scale(0.95);
        transition: opacity 0.25s cubic-bezier(0.4, 0, 0.2, 1),
            transform 0.25s cubic-bezier(0.4, 0, 0.2, 1),
            visibility 0.25s;
        pointer-events: none;
        z-index: 70;
    }

    #mobFabMenu.open {
        visibility: visible;
        opacity: 1;
        transform: translateX(-50%) translateY(0) scale(1);
        pointer-events: auto;
    }

    #mobFab i {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #mobFab.open i {
        transform: rotate(135deg);
    }

    @media only screen and (max-width: 1199px) {
        #mainContent {
            margin-left: 0 !important;
            padding-bottom: 100px;
        }

        #sidebar {
            display: none !important;
        }

        #mobileBottomNav {
            display: block !important;
        }
    }

    html {
        -webkit-text-size-adjust: 100%;
        text-size-adjust: 100%;
    }

    [data-theme="dark"] .nav-link {
        color: #d1d5db;
    }

    [data-theme="dark"] .nav-link i {
        color: #ff6b6b;
    }

    [data-theme="dark"] .nav-link.active i {
        color: #fff;
    }

    [data-theme="dark"] #sidebar,
    [data-theme="dark"] #mobileBottomNav {
        background-color: #0d1117;
        border-color: #21262d;
    }

    [data-theme="dark"] .nav-link:hover {
        background: rgba(139, 0, 0, .2);
    }

    [data-theme="dark"] .sidebar-bottom {
        border-color: #21262d;
    }

    [data-theme="dark"] #mobFab {
        border-color: #000D1A;
    }

    #termsModal {
        border: none;
        padding: 0;
        border-radius: 18px;
        width: min(94vw, 480px);
        box-shadow: 0 24px 60px rgba(0, 0, 0, .2);
        overflow: hidden;
    }

    #termsModal::backdrop {
        background: rgba(0, 0, 0, .55);
        backdrop-filter: blur(4px);
    }

    .terms-header {
        background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 100%);
        padding: 20px 22px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .terms-header-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .15);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .terms-header-icon i {
        font-size: 15px;
        color: rgba(255, 255, 255, .9);
    }

    .terms-header h2 {
        color: #fff;
        font-size: 1rem;
        font-weight: 800;
        margin: 0;
    }

    .terms-header p {
        color: rgba(255, 255, 255, .6);
        font-size: .7rem;
        margin: 2px 0 0;
    }

    .terms-body {
        padding: 20px 22px 18px;
    }

    .terms-body p {
        font-size: .83rem;
        color: #4b5563;
        line-height: 1.75;
        margin-bottom: 10px;
    }

    .terms-body strong {
        color: #1f2937;
        font-weight: 700;
    }

    .terms-divider {
        height: 1px;
        background: #f0e8e8;
        margin: 4px 0 14px;
    }

    .terms-checkbox-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: #fdf5f5;
        border: 1px solid #fce8e8;
        border-radius: 10px;
        padding: 11px 13px;
        margin-bottom: 18px;
        cursor: pointer;
    }

    .terms-checkbox-row input[type="checkbox"] {
        margin-top: 2px;
        cursor: pointer;
        accent-color: var(--crimson);
        width: 14px;
        height: 14px;
        flex-shrink: 0;
    }

    .terms-checkbox-row span {
        font-size: .8rem;
        font-weight: 600;
        color: #374151;
        line-height: 1.5;
    }

    .terms-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    .terms-cancel-btn {
        padding: 8px 18px;
        border-radius: 9px;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
        color: #6b7280;
        font-weight: 600;
        font-size: .8rem;
        cursor: pointer;
        transition: all .15s;
        font-family: 'Inter', sans-serif;
    }

    .terms-cancel-btn:hover {
        background: #f3f4f6;
        color: #374151;
    }

    .terms-continue-btn {
        padding: 8px 20px;
        border-radius: 9px;
        border: none;
        background: #9ca3af;
        color: white;
        font-weight: 700;
        font-size: .8rem;
        cursor: not-allowed;
        transition: all .2s;
        font-family: 'Inter', sans-serif;
    }

    .terms-continue-btn:not(:disabled) {
        background: var(--crimson);
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(139, 0, 0, .3);
    }

    .terms-continue-btn:not(:disabled):hover {
        background: var(--crimson-dark);
        box-shadow: 0 4px 14px rgba(139, 0, 0, .4);
    }

    [data-theme="dark"] #termsModal {
        background: #161b22;
    }

    [data-theme="dark"] .terms-body p {
        color: #9ca3af;
    }

    [data-theme="dark"] .terms-body strong {
        color: #e5e7eb;
    }

    [data-theme="dark"] .terms-divider {
        background: #21262d;
    }

    [data-theme="dark"] .terms-checkbox-row {
        background: #1c1c1c;
        border-color: #2d1a1a;
    }

    [data-theme="dark"] .terms-checkbox-row span {
        color: #d1d5db;
    }

    [data-theme="dark"] .terms-cancel-btn {
        background: #1f2937;
        border-color: #374151;
        color: #9ca3af;
    }

    [data-theme="dark"] .terms-cancel-btn:hover {
        background: #374151;
        color: #e5e7eb;
    }

    @media only screen and (min-width: 1200px) {
        #mobileBottomNav {
            display: none !important;
        }

        #sidebar {
            display: flex !important;
        }

        #mainContent {
            margin-left: clamp(200px, 20vw, 220px);
            transition: margin-left .3s;
        }

        body.role-patient.sidebar-collapsed #sidebar {
            width: 64px;
            overflow: visible;
        }

        body.role-patient.sidebar-collapsed #mainContent {
            margin-left: 64px !important;
        }

        body.role-patient.sidebar-collapsed #sidebar .sidebar-inner {
            padding-left: 8px;
            padding-right: 8px;
            overflow-x: visible;
        }

        body.role-patient.sidebar-collapsed #sidebar .sidebar-bottom {
            padding-left: 8px;
            padding-right: 8px;
        }

        body.role-patient.sidebar-collapsed #sidebar .nav-section-label,
        body.role-patient.sidebar-collapsed #sidebar .menu-text {
            display: none !important;
        }

        body.role-patient.sidebar-collapsed #sidebar .nav-link,
        body.role-patient.sidebar-collapsed #sidebar .logout-btn {
            width: 44px;
            height: 44px;
            min-width: 44px;
            justify-content: center;
            align-items: center;
            padding: 0;
            margin: 6px auto;
            border-radius: 12px;
            gap: 0;
            position: relative;
            display: flex;
        }

        body.role-patient.sidebar-collapsed #sidebar .nav-link .nav-icon-wrap,
        body.role-patient.sidebar-collapsed #sidebar .logout-btn .logout-icon {
            width: 34px;
            height: 34px;
        }

        body.role-patient.sidebar-collapsed #sidebar .nav-icon-wrap,
        body.role-patient.sidebar-collapsed #sidebar .logout-icon {
            margin: 0;
            flex-shrink: 0;
        }

        body.role-patient.sidebar-collapsed #sidebar .toggle-row {
            justify-content: center !important;
        }
    }

    #sidebar .nav-section-label,
    #sidebar .menu-text,
    #sidebar .logout-btn,
    #sidebar .nav-link {
        transition: all 0.25s ease;
    }

    .sidebar-toggle-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: none;
        background: #fef2f2;
        color: #8B0000;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        line-height: 1;
        flex-shrink: 0;
        transition: background .15s ease, color .15s ease, transform .2s ease;
    }

    .sidebar-toggle-btn i {
        font-size: 15px;
        line-height: 1;
        width: auto;
        height: auto;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .sidebar-toggle-btn:hover {
        background: #fce8e8;
        transform: translateY(-1px);
    }

    .toggle-row {
        min-height: 36px;
        align-items: center;
    }

    body.role-patient:not(.sidebar-collapsed) #sidebar .toggle-row {
        justify-content: flex-end;
        padding-right: 2px;
    }

    body.role-patient.sidebar-collapsed #sidebar .toggle-row {
        justify-content: center !important;
        padding-right: 0;
    }

    .nav-icon-wrap,
    .logout-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: rgba(139, 0, 0, .07);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #8B0000;
        flex-shrink: 0;
        margin: 0;
    }

    .logout-icon {
        background: #fef2f2;
        color: #ef4444;
    }

    .nav-icon-wrap i,
    .logout-icon i {
        font-size: 13px;
        line-height: 1;
        width: auto !important;
        margin: 0 !important;
        color: inherit !important;
    }

    .nav-link.active .nav-icon-wrap {
        background: rgba(255, 255, 255, .2);
        color: #fff;
    }

    .nav-icon-wrap i {
        font-size: 13px;
        line-height: 1;
        width: auto !important;
        margin: 0 !important;
        color: inherit !important;
    }

    .sidebar-tooltip {
        position: absolute;
        left: calc(100% + 12px);
        top: 50%;
        transform: translateY(-50%);
        background: linear-gradient(135deg, #8B0000, #6B0000);
        color: #fff;
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

    body.role-patient:not(.sidebar-collapsed) #sidebar .sidebar-tooltip {
        display: none;
    }

    body.role-patient.sidebar-collapsed #sidebar,
    body.role-patient.sidebar-collapsed #sidebar .sidebar-inner,
    body.role-patient.sidebar-collapsed #sidebar .nav-group,
    body.role-patient.sidebar-collapsed #sidebar .sidebar-bottom {
        overflow: visible !important;
    }

    body.role-patient.sidebar-collapsed #sidebar .nav-link:hover .sidebar-tooltip,
    body.role-patient.sidebar-collapsed #sidebar .nav-link:focus-visible .sidebar-tooltip,
    body.role-patient.sidebar-collapsed #sidebar .logout-btn:hover .sidebar-tooltip,
    body.role-patient.sidebar-collapsed #sidebar .logout-btn:focus-visible .sidebar-tooltip {
        opacity: 1;
        visibility: visible;
    }
</style>
