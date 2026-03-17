<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>System Logs | PUP Taguig Dental Clinic</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        :root {
            --crimson: #8B0000;
            --crimson-dark: #6b0000;
            --crimson-light: #fef2f2;
            --header-h: 64px;
        }

        /* ── HEADER ── */
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

        .header-left {
            display: flex;
            align-items: center;
            gap: .75rem;
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

        .header-right {
            display: flex;
            align-items: center;
            gap: .75rem;
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
            text-decoration: none;
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
            box-shadow: 0 2px 6px rgba(255, 71, 87, .5);
        }

        .header-user-btn {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .35rem .75rem .35rem .35rem;
            background: rgba(255, 255, 255, .1);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 40px;
            cursor: pointer;
            transition: background .15s;
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

        .header-user-text {
            line-height: 1;
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

        /* Notification dropdown */
        #notifDropdown {
            position: relative;
        }

        #notifMenu {
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            width: 320px;
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

        #notifMenu.open {
            opacity: 1;
            transform: scale(1) translateY(0);
            pointer-events: auto;
        }

        .notif-header {
            padding: .85rem 1.1rem .7rem;
            font-weight: 800;
            color: var(--crimson);
            font-size: .8rem;
            border-bottom: 1px solid #fce8e8;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        /* User dropdown */
        #userDropdown {
            position: relative;
        }

        #userMenu {
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            width: 210px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, .15), 0 0 0 1px rgba(0, 0, 0, .06);
            opacity: 0;
            transform: scale(.95) translateY(-8px);
            pointer-events: none;
            transition: all .2s cubic-bezier(.4, 0, .2, 1);
            transform-origin: top right;
            z-index: 100;
            overflow: hidden;
        }

        #userMenu.open {
            opacity: 1;
            transform: scale(1) translateY(0);
            pointer-events: auto;
        }

        .user-menu-header {
            padding: .85rem 1rem .7rem;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .user-menu-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid #e5e7eb;
            object-fit: cover;
            flex-shrink: 0;
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
            text-decoration: none;
            cursor: pointer;
            transition: background .12s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-family: 'Inter', sans-serif;
        }

        .user-menu-item:hover {
            background: #f9fafb;
        }

        .user-menu-item i {
            width: 14px;
            text-align: center;
            color: #9ca3af;
            font-size: 12px;
        }

        .user-menu-item.danger {
            color: #ef4444;
        }

        .user-menu-item.danger i {
            color: #ef4444;
        }

        .user-menu-item.danger:hover {
            background: #fef2f2;
        }

        .user-menu-sep {
            height: 1px;
            background: #f3f4f6;
            margin: 3px 0;
        }

        /* Dark mode user menu */
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

        [data-theme="dark"] .user-menu-item.danger {
            color: #f87171;
        }

        [data-theme="dark"] .user-menu-item.danger:hover {
            background: rgba(239, 68, 68, .1);
        }

        [data-theme="dark"] .user-menu-sep {
            background: #21262d;
        }

        /* ════════════════════════════════
       SIDEBAR
    ════════════════════════════════ */
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
            overflow-x: hidden;
            padding: 16px 10px 8px;
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

        .nav-group {
            margin-bottom: 2px;
        }

        .group-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 10px;
            cursor: default;
        }

        .group-icon-wrap {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--crimson-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: var(--crimson);
            flex-shrink: 0;
            transition: all .2s;
        }

        .active-group .group-icon-wrap {
            background: var(--crimson);
            color: #fff;
            box-shadow: 0 4px 12px rgba(139, 0, 0, .3);
        }

        .group-text {
            flex: 1;
            overflow: hidden;
        }

        .group-label {
            font-size: .7rem;
            font-weight: 800;
            color: var(--crimson);
            display: block;
            text-transform: uppercase;
            letter-spacing: .06em;
            white-space: nowrap;
        }

        .group-sublabel {
            font-size: .62rem;
            color: #adb5bd;
            display: block;
            margin-top: 1px;
            white-space: nowrap;
        }

        .group-body {
            padding: 2px 0 6px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 7px 10px 7px 42px;
            border-radius: 9px;
            margin: 1px 2px;
            font-size: .76rem;
            font-weight: 500;
            color: #4a5568;
            text-decoration: none;
            transition: all .15s;
            white-space: nowrap;
        }

        .nav-link:hover {
            background: var(--crimson-light);
            color: var(--crimson);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--crimson) 0%, var(--crimson-dark) 100%);
            color: #fff;
            box-shadow: 0 3px 10px rgba(139, 0, 0, .25);
            font-weight: 600;
        }

        .nav-link.active:hover {
            padding-left: 14px;
            background: #8B0000;
        }

        .nav-link i {
            width: 14px;
            text-align: center;
            font-size: 11px;
            flex-shrink: 0;
        }

        .nav-sep {
            height: 1px;
            background: #f3f4f6;
            margin: 10px 6px;
        }

        /* Sidebar bottom */
        .sidebar-bottom {
            padding: 10px 10px 14px;
            border-top: 1px solid #f3f4f6;
            flex-shrink: 0;
        }

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
            position: relative;
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
            transition: color .2s;
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
            transition: all .3s cubic-bezier(.4, 0, .2, 1);
            pointer-events: none;
            width: calc(50% - 3px);
            height: calc(100% - 6px);
            left: 3px;
            top: 3px;
        }

        .theme-indicator.dark-mode {
            transform: translateX(calc(100% + 0px));
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 8px 10px;
            border-radius: 10px;
            border: none;
            background: none;
            cursor: pointer;
            color: #ef4444;
            font-size: .76rem;
            font-weight: 600;
            transition: background .15s;
            margin-top: 6px;
            font-family: 'Inter', sans-serif;
        }

        .logout-btn:hover {
            background: #fef2f2;
        }

        .logout-icon {
            width: 28px;
            height: 28px;
            background: #fef2f2;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 11px;
        }

        /* ════════════════════════════════
       FOOTER
    ════════════════════════════════ */
        #siteFooter {
            background: var(--crimson);
            color: rgba(255, 255, 255, .8);
            padding: 1.25rem 2rem;
        }

        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.5rem;
            flex-wrap: wrap;
            font-size: .74rem;
        }

        .footer-inner a {
            color: rgba(255, 255, 255, .7);
            text-decoration: none;
            transition: color .15s;
        }

        .footer-inner a:hover {
            color: #fff;
        }

        .footer-dot {
            color: rgba(255, 255, 255, .3);
        }

        /* ── LAYOUT ── */
        #mainContent,
        #siteFooter {
            margin-left: 256px;
        }

        /* ── DARK MODE ── */
        body,
        main,
        footer {
            transition: background-color .3s ease, color .3s ease;
        }

        [data-theme="dark"] body {
            background-color: #000D1A;
            color: #E5E7EB;
        }

        [data-theme="dark"] #sidebar {
            background-color: #0d1117;
            border-right: 1px solid #21262d;
        }

        [data-theme="dark"] .bg-white {
            background-color: #161b22 !important;
        }

        [data-theme="dark"] .text-\[\#333333\] {
            color: #E5E7EB !important;
        }

        [data-theme="dark"] .nav-link:hover {
            background: rgba(139, 0, 0, .2);
        }

        [data-theme="dark"] .theme-toggle-container {
            background: #1F1F1F;
            border-color: #2A2A2A;
        }

        [data-theme="dark"] .theme-option {
            color: #333333;
        }

        [data-theme="dark"] .theme-option.active {
            color: #F3F4F6;
        }

        [data-theme="dark"] .theme-indicator {
            background: #2A2A2A;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .3);
        }

        [data-theme="dark"] .nav-sep,
        [data-theme="dark"] .sidebar-bottom {
            border-color: #21262d;
        }

        [data-theme="dark"] .group-label {
            color: #333333;
        }

        [data-theme="dark"] .sl-card,
        [data-theme="dark"] .sl-stat {
            background: #161b22 !important;
            border-color: #21262d !important;
        }

        [data-theme="dark"] .sl-page-title {
            color: #f3f4f6;
        }

        [data-theme="dark"] .sl-toolbar-title {
            color: #f3f4f6;
        }

        [data-theme="dark"] .sl-table thead tr {
            background: #0d1117;
        }

        [data-theme="dark"] .sl-table tbody tr:hover {
            background: #1c2128;
        }

        [data-theme="dark"] .sl-table tbody td {
            color: #d1d5db;
        }

        [data-theme="dark"] .sl-username,
        [data-theme="dark"] .sl-date-day {
            color: #e5e7eb;
        }

        [data-theme="dark"] .sl-pagebar {
            background: #0d1117;
            border-color: #21262d;
        }

        /* ── MOBILE DRAWER ── */
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
            transition: background .15s;
            flex-shrink: 0;
        }

        #mobileMenuBtn:hover {
            background: rgba(255, 255, 255, .22);
        }

        #mobileDrawerOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 998;
            backdrop-filter: blur(2px);
            opacity: 0;
            transition: opacity .25s;
        }

        #mobileDrawerOverlay.open {
            opacity: 1;
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
            transition: transform .3s cubic-bezier(.4, 0, .2, 1);
            box-shadow: 4px 0 32px rgba(0, 0, 0, .15);
            overflow: hidden;
        }

        #mobileDrawer.open {
            transform: translateX(0);
        }

        .drawer-header {
            background: linear-gradient(135deg, #6b0000 0%, #8B0000 100%);
            padding: 20px 18px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .drawer-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .drawer-logo {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }

        .drawer-title {
            font-size: .82rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: .01em;
            line-height: 1.2;
        }

        .drawer-subtitle {
            font-size: .75rem;
            color: #F4F4F4;
            font-weight: 600;
        }

        .drawer-close {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .15);
            border: none;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: background .15s;
        }

        .drawer-close:hover {
            background: rgba(255, 255, 255, .28);
        }

        /* User info strip */
        .drawer-user {
            padding: 14px 18px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fdf9f9;
            flex-shrink: 0;
        }

        .drawer-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 2px solid #e5e7eb;
            object-fit: cover;
            flex-shrink: 0;
        }

        .drawer-user-name {
            font-size: .82rem;
            font-weight: 700;
            color: #1f2937;
        }

        .drawer-user-role {
            font-size: .68rem;
            color: #9ca3af;
            font-style: italic;
        }

        .drawer-inner {
            flex: 1;
            overflow-y: auto;
            padding: 10px 0 6px;
        }

        .drawer-inner::-webkit-scrollbar {
            width: 4px;
        }

        .drawer-inner::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 4px;
        }

        .drawer-group {
            margin: 0 8px 2px;
        }

        .drawer-group-header {
            display: flex;
            align-items: center;
            padding: 6px 8px 4px;
            color: #6b7280;
        }

        .drawer-group-icon {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #8B0000;
            flex-shrink: 0;
        }

        .drawer-group-label {
            font-size: .68rem;
            font-weight: 700;
            color: #8B0000;
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-left: 8px;
        }

        .drawer-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px 8px 40px;
            border-radius: 8px;
            margin: 1px 4px;
            font-size: .78rem;
            font-weight: 500;
            color: #374151;
            text-decoration: none;
            transition: all .15s;
        }

        .drawer-link:hover {
            background: #fef2f2;
            color: #8B0000;
            padding-left: 44px;
        }

        .drawer-link.active {
            background: #8B0000;
            color: #fff;
            box-shadow: 0 2px 8px rgba(139, 0, 0, .2);
        }

        .drawer-link.active:hover {
            padding-left: 40px;
        }

        .drawer-link i {
            width: 15px;
            text-align: center;
            font-size: 11px;
        }

        .drawer-sep {
            height: 1px;
            background: #f3f4f6;
            margin: 6px 12px;
        }

        .drawer-bottom {
            padding: 10px 12px 14px;
            border-top: 1px solid #f3f4f6;
            flex-shrink: 0;
        }

        /* dark mode drawer */
        [data-theme="dark"] #mobileDrawer {
            background: #0d1117;
        }

        [data-theme="dark"] .drawer-user {
            background: #161b22;
            border-color: #21262d;
        }

        [data-theme="dark"] .drawer-user-name {
            color: #e5e7eb;
        }

        [data-theme="dark"] .drawer-link {
            color: #d1d5db;
        }

        [data-theme="dark"] .drawer-link:hover {
            background: rgba(139, 0, 0, .2);
            color: #fff;
        }

        [data-theme="dark"] .drawer-sep {
            background: #21262d;
        }

        [data-theme="dark"] .drawer-bottom {
            border-color: #21262d;
        }

        [data-theme="dark"] .drawer-group-label {
            color: #6b7280;
        }

        /* ── MOBILE RESPONSIVE ── */
        @media (max-width: 767px) {
            #sidebar {
                display: none !important;
            }

            #mainContent {
                margin-left: 0 !important;
                padding-bottom: 86px !important;
            }

            #siteFooter {
                margin-left: 0 !important;
            }

            #mobileMenuBtn {
                display: flex;
            }

            #mainContent {
                padding-bottom: 2rem !important;
            }

            .header {
                padding: 0 1rem;
            }

            .header-title {
                display: none;
            }

            .sl-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .sl-table thead th:nth-child(6),
            .sl-table tbody td:nth-child(6),
            .sl-table thead th:nth-child(7),
            .sl-table tbody td:nth-child(7) {
                display: none;
            }


            .sl-toolbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .sl-search {
                flex: 1;
                min-width: 0;
            }

            .sl-search input {
                width: 100%;
            }

            .sl-desc {
                max-width: 160px;
                font-size: 0.7rem;
            }

            .sl-table tbody td {
                padding: 0.65rem 0.6rem;
            }

            .sl-table thead th {
                padding: 0.55rem 0.6rem;
                font-size: 0.6rem;
            }

            .sl-table tbody td:first-child,
            .sl-table thead th:first-child {
                padding-left: 0.85rem;
            }

            .sl-pagebar {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .sl-pagebar nav {
                width: 100%;
                overflow-x: auto;
            }
        }

        /* ── DARK MODE ── */
        body,
        main,
        footer {
            transition: background-color .3s ease, color .3s ease;
        }

        [data-theme="dark"] body {
            background-color: #000D1A;
            color: #E5E7EB;
        }

        [data-theme="dark"] #sidebar {
            background-color: #0d1117;
        }

        [data-theme="dark"] .bg-white {
            background-color: #161b22 !important;
        }

        [data-theme="dark"] .text-\[\#333333\] {
            color: #E5E7EB !important;
        }

        [data-theme="dark"] .group-header:hover,
        [data-theme="dark"] .nav-link:hover {
            background: rgba(139, 0, 0, .2);
        }

        [data-theme="dark"] .theme-toggle-container {
            background: #1F1F1F;
            border-color: #2A2A2A;
        }

        [data-theme="dark"] .theme-option {
            color: #333333;
        }

        [data-theme="dark"] .theme-option.active {
            color: #F3F4F6;
        }

        [data-theme="dark"] .theme-indicator {
            background: #2A2A2A;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .3);
        }

        [data-theme="dark"] .flyout-panel {
            background: #161b22;
            border-color: #2d1a1a;
        }

        [data-theme="dark"] .flyout-link {
            color: #d1d5db;
        }

        [data-theme="dark"] .nav-sep,
        [data-theme="dark"] .sidebar-bottom {
            border-color: #21262d;
        }

        [data-theme="dark"] .sidebar-toggle-row {
            border-color: #21262d;
        }

        [data-theme="dark"] .sl-card,
        [data-theme="dark"] .sl-stat {
            background: #161b22 !important;
            border-color: #21262d !important;
        }

        [data-theme="dark"] .sl-page-title {
            color: #f3f4f6;
        }

        [data-theme="dark"] .sl-toolbar-title {
            color: #f3f4f6;
        }

        [data-theme="dark"] .sl-table thead tr {
            background: #0d1117;
        }

        [data-theme="dark"] .sl-table tbody tr:hover {
            background: #1c2128;
        }

        [data-theme="dark"] .sl-table tbody td {
            color: #d1d5db;
        }

        [data-theme="dark"] .sl-username,
        [data-theme="dark"] .sl-date-day {
            color: #e5e7eb;
        }

        [data-theme="dark"] .sl-pagebar {
            background: #0d1117;
            border-color: #21262d;
        }

        /* ══════════════════════════════════════════
           MAIN CONTENT STYLES
        ══════════════════════════════════════════ */
        .sl-page-title {
            font-size: 1.85rem;
            font-weight: 800;
            color: #1a1a2e;
            letter-spacing: -0.03em;
            line-height: 1.1;
        }

        .sl-page-title span {
            color: #8B0000;
        }

        .sl-page-sub {
            font-size: 0.8rem;
            color: #9ca3af;
            margin-top: 0.3rem;
            font-weight: 400;
        }

        .sl-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.1rem;
            border-radius: 10px;
            background: #8B0000;
            color: #fff !important;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 2px 10px rgba(139, 0, 0, 0.25);
        }

        .sl-back-btn:hover {
            background: #700000;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(139, 0, 0, 0.3);
        }

        .sl-live {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.72rem;
            font-weight: 600;
            color: #059669;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            padding: 0.3rem 0.7rem;
            border-radius: 99px;
        }

        .sl-live-dot {
            width: 7px;
            height: 7px;
            background: #10b981;
            border-radius: 50%;
            animation: sl-pulse 2s infinite;
        }

        @keyframes sl-pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5);
            }

            50% {
                box-shadow: 0 0 0 4px rgba(16, 185, 129, 0);
            }
        }

        .sl-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .sl-stat {
            background: #fff;
            border-radius: 16px;
            padding: 1.1rem 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.9rem;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            animation: sl-fadeUp 0.4s ease both;
        }

        .sl-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        .sl-stat:nth-child(1) {
            animation-delay: .05s;
        }

        .sl-stat:nth-child(2) {
            animation-delay: .1s;
        }

        .sl-stat:nth-child(3) {
            animation-delay: .15s;
        }

        .sl-stat:nth-child(4) {
            animation-delay: .2s;
        }

        .sl-stat::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 3px 3px 0 0;
        }

        .sl-stat.c-all::before {
            background: linear-gradient(90deg, #8B0000, #c0392b);
        }

        .sl-stat.c-admin::before {
            background: linear-gradient(90deg, #ef4444, #fca5a5);
        }

        .sl-stat.c-dent::before {
            background: linear-gradient(90deg, #3b82f6, #93c5fd);
        }

        .sl-stat.c-pat::before {
            background: linear-gradient(90deg, #10b981, #6ee7b7);
        }

        .sl-stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .sl-stat.c-all .sl-stat-icon {
            background: #fef2f2;
            color: #8B0000;
        }

        .sl-stat.c-admin .sl-stat-icon {
            background: #fef2f2;
            color: #ef4444;
        }

        .sl-stat.c-dent .sl-stat-icon {
            background: #eff6ff;
            color: #3b82f6;
        }

        .sl-stat.c-pat .sl-stat-icon {
            background: #ecfdf5;
            color: #10b981;
        }

        .sl-stat-num {
            font-size: 1.7rem;
            font-weight: 800;
            color: #1a1a2e;
            line-height: 1;
        }

        .sl-stat-label {
            font-size: 0.68rem;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-top: 3px;
        }

        .sl-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
            overflow: hidden;
            animation: sl-fadeUp 0.4s ease 0.25s both;
        }

        .sl-toolbar {
            padding: 1rem 1.4rem;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .sl-toolbar-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1a1a2e;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sl-toolbar-title i {
            color: #8B0000;
        }

        .sl-entry-badge {
            background: #fef2f2;
            color: #8B0000;
            font-size: 0.68rem;
            font-weight: 700;
            padding: 0.18rem 0.55rem;
            border-radius: 99px;
            border: 1px solid #fecaca;
        }

        .sl-search {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 0.42rem 0.7rem;
            transition: all 0.2s;
        }

        .sl-search:focus-within {
            border-color: #8B0000;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.07);
        }

        .sl-search i {
            font-size: 0.68rem;
            color: #9ca3af;
        }

        .sl-search input {
            background: transparent;
            border: none;
            outline: none;
            font-size: 0.78rem;
            color: #374151;
            width: 155px;
        }

        .sl-search input::placeholder {
            color: #9ca3af;
        }

        .sl-export-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.42rem 0.85rem;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            color: #374151;
            font-size: 0.76rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }

        .sl-export-btn:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        .sl-tabs {
            display: flex;
            gap: 0.2rem;
            padding: 0.65rem 1.4rem;
            border-bottom: 1px solid #f3f4f6;
            overflow-x: auto;
        }

        .sl-tab {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.38rem 0.8rem;
            border-radius: 8px;
            border: none;
            font-size: 0.74rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            background: transparent;
            color: #333333;
            white-space: nowrap;
        }

        .sl-tab:hover {
            background: #f3f4f6;
            color: #374151;
        }

        .sl-tab.active {
            background: #fef2f2;
            color: #8B0000;
        }

        .sl-tab-count {
            background: #e5e7eb;
            color: #333333;
            font-size: 0.62rem;
            font-weight: 700;
            padding: 0.08rem 0.42rem;
            border-radius: 99px;
        }

        .sl-tab.active .sl-tab-count {
            background: #fecaca;
            color: #8B0000;
        }

        .sl-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .sl-table thead tr {
            background: #f8f9fb;
        }

        .sl-table thead th {
            padding: 0.7rem 1rem;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: #161616;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
            white-space: nowrap;
        }

        .sl-table thead th:first-child {
            padding-left: 1.4rem;
        }

        .sl-table thead th:last-child {
            padding-right: 1.4rem;
        }

        .sl-table tbody tr {
            transition: background 0.1s;
            border-bottom: 1px solid #f7f8fa;
        }

        .sl-table tbody tr:last-child td {
            border-bottom: none;
        }

        .sl-table tbody tr:hover {
            background: #fafbff;
        }

        .sl-table tbody td {
            padding: 0.85rem 1rem;
            font-size: 0.8rem;
            vertical-align: middle;
        }

        .sl-table tbody td:first-child {
            padding-left: 1.4rem;
        }

        .sl-table tbody td:last-child {
            padding-right: 1.4rem;
        }

        .sl-id {
            font-size: 0.7rem;
            font-weight: 500;
            color: #9ca3af;
            background: #f3f4f6;
            padding: 0.18rem 0.48rem;
            border-radius: 6px;
            display: inline-block;
        }

        .sl-date-day {
            font-weight: 600;
            color: #374151;
            font-size: 0.78rem;
            display: block;
        }

        .sl-date-time {
            font-size: 0.65rem;
            color: #9ca3af;
            display: block;
            margin-top: 1px;
        }

        .sl-role {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.6rem;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 700;
        }

        .sl-role i {
            font-size: 0.62rem;
        }

        .sl-role.admin {
            background: #fff0f0;
            color: #c0392b;
            border: 1px solid #fecaca;
        }

        .sl-role.dentist {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }

        .sl-role.patient {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .sl-user {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sl-avatar {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.68rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .sl-avatar.admin {
            background: #fef2f2;
            color: #8B0000;
        }

        .sl-avatar.dentist {
            background: #eff6ff;
            color: #2563eb;
        }

        .sl-avatar.patient {
            background: #ecfdf5;
            color: #059669;
        }

        .sl-username {
            font-weight: 600;
            color: #374151;
            font-size: 0.78rem;
        }

        .sl-action {
            display: inline-flex;
            align-items: center;
            gap: 0.28rem;
            padding: 0.22rem 0.55rem;
            border-radius: 7px;
            font-size: 0.72rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .sl-action i {
            font-size: 0.6rem;
        }

        .sl-action.login {
            background: #f0fdf4;
            color: #16a34a;
        }

        .sl-action.logout {
            background: #fff7ed;
            color: #ea580c;
        }

        .sl-action.create {
            background: #eff6ff;
            color: #2563eb;
        }

        .sl-action.update {
            background: #faf5ff;
            color: #7c3aed;
        }

        .sl-action.delete {
            background: #fff0f0;
            color: #c0392b;
        }

        .sl-action.default {
            background: #f1f5f9;
            color: #475569;
        }

        .sl-module {
            font-size: 0.74rem;
            color: #333333;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .sl-module i {
            color: #8B0000;
            font-size: 0.65rem;
        }

        .sl-desc {
            color: #333333;
            font-size: 0.76rem;
            max-width: 260px;
            line-height: 1.45;
        }

        .sl-desc strong {
            color: #374151;
            font-weight: 600;
        }

        .sl-empty {
            padding: 4rem;
            text-align: center;
        }

        .sl-empty i {
            font-size: 2.5rem;
            color: #d1d5db;
            display: block;
            margin-bottom: 0.75rem;
        }

        .sl-empty-title {
            font-weight: 700;
            color: #374151;
        }

        .sl-empty-sub {
            font-size: 0.78rem;
            color: #9ca3af;
            margin-top: 0.25rem;
        }

        .sl-pagebar {
            padding: 0.85rem 1.4rem;
            border-top: 1px solid #f3f4f6;
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sl-pagebar-info {
            font-size: 0.73rem;
            color: #9ca3af;
            font-weight: 500;
        }

        .sl-pagebar-info strong {
            color: #374151;
        }

        @keyframes sl-fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .sl-row-new {
            animation: slNewRowSlideIn 0.8s ease;
        }

        @keyframes slNewRowSlideIn {
            0% {
                opacity: 0;
                transform: translateY(-8px);
                background: rgba(16, 185, 129, 0.20);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
                background: transparent;
            }
        }

        [data-theme="dark"] .sl-row-new {
            animation: slNewRowFlashDark 1.2s ease;
        }

        @keyframes slNewRowFlashDark {
            0% {
                background: rgba(16, 185, 129, 0.18);
                transform: scale(1.01);
            }

            40% {
                background: rgba(16, 185, 129, 0.10);
            }

            100% {
                background: transparent;
                transform: scale(1);
            }
        }
    </style>
</head>

<body class="bg-[#f5f5f5] text-[#333333] min-h-screen">

    <!-- ════════ HEADER ════════ -->
    <header class="header">
        <div class="header-left">
            <button id="mobileMenuBtn" aria-label="Open menu"><i class="fa-solid fa-bars"></i></button>
            <img src="{{ asset('images/PUP.png') }}" class="header-logo" alt="PUP">
            <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="header-logo" alt="DMS">
            <div class="header-divider"></div>
            <span class="header-title">PUP Taguig Dental Clinic</span>
        </div>
        <div class="header-right">
            @php $notifications = collect($notifications ?? []); $notifCount = $notifications->count(); @endphp
            <div id="notifDropdown">
                <button class="hdr-icon-btn" id="notifBtn" aria-label="Notifications">
                    <i class="fa-regular fa-bell"></i>
                    @if($notifCount > 0)<span class="notif-badge">{{ $notifCount }}</span>@endif
                </button>
                <div id="notifMenu">
                    <div class="notif-header"><i class="fa-solid fa-bell text-xs"></i> Notifications</div>
                    <div style="max-height:260px;overflow-y:auto;">
                        @forelse($notifications as $n)
                        <a href="{{ $n['url'] ?? '#' }}"
                            style="display:block;padding:.65rem 1rem;font-size:.76rem;color:#333;text-decoration:none;border-bottom:1px solid #fdf5f5;transition:background .1s;"
                            onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background=''">
                            <div style="font-weight:700;">{{ $n['title'] ?? 'Notification' }}</div>
                            @if(!empty($n['message']))<div style="color:#aaa;margin-top:2px;font-size:.7rem;">{{
                                $n['message'] }}
                            </div>@endif
                        </a>
                        @empty
                        <div style="padding:2.5rem 1rem;text-align:center;color:#bbb;font-size:.76rem;">
                            <i class="fa-regular fa-bell-slash"
                                style="font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>
                            You're all caught up.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Palitan ng system settings na route --}}
            <a href="{{ route('admin.system_logs') }}" class="hdr-icon-btn" aria-label="Settings">
                <i class="fa-solid fa-gear"></i>
            </a>

            <div id="userDropdown">
                <div class="header-user-btn" id="userBtn">
                    <img src="https://i.pravatar.cc/40" class="header-avatar" alt="Avatar">
                    <div class="header-user-text">
                        <div class="header-name">Admin</div>
                        <div class="header-role">Administrator</div>
                    </div>
                    <i class="fa-solid fa-chevron-down"
                        style="color:rgba(255,255,255,.5);font-size:.6rem;margin-left:.25rem;"></i>
                </div>
                <div id="userMenu">
                    <div class="user-menu-header">
                        <img src="https://i.pravatar.cc/40" class="user-menu-avatar" alt="Avatar">
                        <div>
                            <div class="user-menu-name">Admin</div>
                            <div class="user-menu-role">Administrator</div>
                        </div>
                    </div>
                    <!-- Dark mode toggle inside dropdown -->
                    <div style="padding:.5rem .75rem; border-bottom:1px solid #f3f4f6;">
                        <div
                            style="font-size:.6rem;font-weight:800;letter-spacing:.08em;color:#b0b7c3;text-transform:uppercase;margin-bottom:6px;">
                            Appearance</div>
                        <div class="theme-toggle-container" id="userMenuThemeToggle">
                            <button type="button" class="theme-option active" data-theme="light"><i
                                    class="fa-solid fa-sun"></i></button>
                            <button type="button" class="theme-option" data-theme="dark"><i
                                    class="fa-regular fa-moon"></i></button>
                            <div class="theme-indicator" aria-hidden="true"></div>
                        </div>
                    </div>
                    <div class="user-menu-sep"></div>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="user-menu-item danger">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- ════════ SIDEBAR ════════ -->
    <aside id="sidebar">
        <div class="sidebar-inner">

            <div class="nav-section-label">Clinic Management</div>
            <div class="nav-group">
                <div class="group-trigger {{ request()->routeIs('admin.admin.dashboard') ? 'active-group' : '' }}">
                    <div class="group-icon-wrap"><i class="fa-solid fa-hospital"></i></div>
                    <div class="group-text">
                        <span class="group-label">Clinic</span>
                        <span class="group-sublabel">Core clinical modules</span>
                    </div>
                </div>
                <div class="group-body">
                    <a href="{{ route('admin.admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.admin.dashboard') ? 'active' : '' }}"><i
                            class="fa-solid fa-chart-line"></i> Dashboard</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-users"></i>
                        Patients</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i
                            class="fa-solid fa-calendar-check"></i>
                        Appointments</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-tooth"></i>
                        Dental
                        Records</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i
                            class="fa-solid fa-file-circle-check"></i>
                        Document Request</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-file"></i>
                        Reports</a>
                </div>
            </div>

            <div class="nav-sep"></div>
            <div class="nav-section-label">Maintenance</div>
            <div class="nav-group">
                <div
                    class="group-trigger {{ request()->routeIs('admin.user_management*','admin.role_permissions','admin.academic_periods*','admin.clinic_schedule*') ? 'active-group' : '' }}">
                    <div class="group-icon-wrap"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                    <div class="group-text">
                        <span class="group-label">Configuration</span>
                        <span class="group-sublabel">Settings & scheduling</span>
                    </div>
                </div>
                <div class="group-body">
                    <a href="{{ route('admin.user_management') }}"
                        class="nav-link {{ request()->routeIs('admin.user_management*') ? 'active' : '' }}"><i
                            class="fa-solid fa-user-gear"></i> User Management</a>
                    <a href="{{ route('admin.role_permissions') }}"
                        class="nav-link {{ request()->routeIs('admin.role_permissions') ? 'active' : '' }}"><i
                            class="fa-solid fa-user-shield"></i> Roles & Permissions</a>
                    <a href="{{ route('admin.academic_periods') }}"
                        class="nav-link {{ request()->routeIs('admin.academic_periods*') ? 'active' : '' }}"><i
                            class="fa-solid fa-school"></i> Academic Periods</a>
                    <a href="{{ route('admin.clinic_schedule') }}"
                        class="nav-link {{ request()->routeIs('admin.clinic_schedule*') ? 'active' : '' }}"><i
                            class="fa-solid fa-calendar-days"></i> Clinic Schedule</a>
                    <a href="{{ route('admin.service-types') }}"
                        class="nav-link {{ request()->routeIs('admin.service-types*') ? 'active' : '' }}"><i
                            class="fa-solid fa-list-check"></i> Service Types</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-file-pen"></i>
                        Document
                        Templates</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i
                            class="fa-solid fa-boxes-stacked"></i>
                        Inventory</a>
                </div>
            </div>

            <div class="nav-sep"></div>
            <div class="nav-section-label">System</div>
            <div class="nav-group">
                <div class="group-trigger {{ request()->routeIs('admin.system_logs') ? 'active-group' : '' }}">
                    <div class="group-icon-wrap"><i class="fa-solid fa-server"></i></div>
                    <div class="group-text">
                        <span class="group-label">System</span>
                        <span class="group-sublabel">Admin & configuration</span>
                    </div>
                </div>
                <div class="group-body">
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-database"></i>
                        Data
                        Backup</a>
                    <a href="{{ route('admin.system_logs') }}"
                        class="nav-link {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}"><i
                            class="fa-solid fa-clipboard-list"></i> System Logs</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-sliders"></i>
                        System
                        Settings</a>
                </div>
            </div>

        </div>
    </aside>

    <!-- Mobile drawer overlay -->
    <div id="mobileDrawerOverlay" onclick="closeDrawer()"></div>

    <!-- Mobile drawer -->
    <div id="mobileDrawer">
        <div class="drawer-header">
            <div class="drawer-header-left">
                <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="drawer-logo" alt="DMS">
                <div>
                    <div class="drawer-title">PUP TAGUIG</div>
                    <div class="drawer-subtitle">Dental Clinic</div>
                </div>
            </div>
            <button class="drawer-close" onclick="closeDrawer()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="drawer-user">
            <img src="https://i.pravatar.cc/40" class="drawer-avatar" alt="Avatar">
            <div>
                <div class="drawer-user-name">Admin</div>
                <div class="drawer-user-role">Administrator</div>
            </div>
        </div>
        <div class="drawer-inner">
            <div class="drawer-group">
                <div class="drawer-group-header"><i class="drawer-group-icon fa-solid fa-hospital"></i><span
                        class="drawer-group-label">Clinic Management</span></div>
                <a href="{{ route('admin.admin.dashboard') }}"
                    class="drawer-link {{ request()->routeIs('admin.admin.dashboard') ? 'active' : '' }}"><i
                        class="fa-solid fa-chart-line"></i> Dashboard</a>
                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-users"></i>
                    Patients</a>
                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i
                        class="fa-solid fa-calendar-check"></i>
                    Appointments</a>
                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-tooth"></i>
                    Dental
                    Records</a>
                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i
                        class="fa-solid fa-file-circle-check"></i>
                    Document Request</a>
                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-file"></i>
                    Reports</a>
            </div>
            <div class="drawer-sep"></div>
            <div class="drawer-group">
                <div class="drawer-group-header"><i class="drawer-group-icon fa-solid fa-screwdriver-wrench"></i><span
                        class="drawer-group-label">Maintenance</span></div>
                <a href="{{ route('admin.user_management') }}"
                    class="drawer-link {{ request()->routeIs('admin.user_management*') ? 'active' : '' }}"><i
                        class="fa-solid fa-user-gear"></i> User Management</a>
                <a href="{{ route('admin.role_permissions') }}"
                    class="drawer-link {{ request()->routeIs('admin.role_permissions') ? 'active' : '' }}"><i
                        class="fa-solid fa-user-shield"></i> Roles & Permissions</a>
                <a href="{{ route('admin.academic_periods') }}"
                    class="drawer-link {{ request()->routeIs('admin.academic_periods*') ? 'active' : '' }}"><i
                        class="fa-solid fa-school"></i> Academic Periods</a>
                <a href="{{ route('admin.clinic_schedule') }}"
                    class="drawer-link {{ request()->routeIs('admin.clinic_schedule*') ? 'active' : '' }}"><i
                        class="fa-solid fa-calendar-days"></i> Clinic Schedule</a>
                <a href="{{ route('admin.service-types') }}"
                    class="drawer-link {{ request()->routeIs('admin.service-types*') ? 'active' : '' }}"><i
                        class="fa-solid fa-list-check"></i> Service Types</a>
                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-file-pen"></i>
                    Document
                    Templates</a>
                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i
                        class="fa-solid fa-boxes-stacked"></i>
                    Inventory</a>
            </div>
            <div class="drawer-sep"></div>
            <div class="drawer-group">
                <div class="drawer-group-header"><i class="drawer-group-icon fa-solid fa-server"></i><span
                        class="drawer-group-label">System</span></div>
                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-database"></i>
                    Data
                    Backup</a>
                <a href="{{ route('admin.system_logs') }}"
                    class="drawer-link {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}"><i
                        class="fa-solid fa-clipboard-list"></i> System Logs</a>
                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i class="fa-solid fa-sliders"></i>
                    System
                    Settings</a>
            </div>
        </div>
        <div class="drawer-bottom">
            <div class="theme-toggle-container" id="drawerThemeToggle" style="margin-bottom:10px;">
                <button type="button" class="theme-option active" data-theme="light"><i
                        class="fa-solid fa-sun"></i></button>
                <button type="button" class="theme-option" data-theme="dark"><i class="fa-regular fa-moon"></i></button>
                <div class="theme-indicator" aria-hidden="true"></div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn"><span class="logout-icon"><i
                            class="fa-solid fa-right-from-bracket" style="color:#ef4444;"></i></span><span>Log
                        out</span></button>
            </form>
        </div>
    </div>

    <!-- ════════════ MAIN CONTENT ════════════ -->
    @php
    $logs = $logs ?? collect([]);
    $totalCount = $logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->total() : $logs->count();
    $adminCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() :
    $logs)->where('actor_role','admin')->count();
    $dentistCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() :
    $logs)->where('actor_role','dentist')->count();
    $patientCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() :
    $logs)->where('actor_role','patient')->count();
    $loginCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() :
    $logs)->whereIn('action',['login','Login'])->count();
    @endphp

    <main id="mainContent" class="px-4 sm:px-6 pb-8 min-h-screen" style="padding-top: var(--header-h)">
        <div style="max-width:1280px; margin:0 auto;">

            {{-- Top row --}}
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-7 mt-6">
                <div>
                    <h1 class="sl-page-title">System <span>Logs</span></h1>
                    <p class="sl-page-sub">View recorded activities of admin, dentist, and patient users.</p>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0 sm:pt-1">
                    <span class="sl-live"><span class="sl-live-dot"></span> Live Monitoring</span>
                    {{-- <a href="{{ route('admin.admin.dashboard') }}" class="sl-back-btn">
                        <i class="fa-solid fa-arrow-left" style="font-size:0.72rem;"></i> Back to Dashboard
                    </a> --}}
                </div>
            </div>

            {{-- Stats Row --}}
            <div class="sl-stats" style="grid-template-columns: repeat(4, 1fr);">
                <div class="sl-stat c-all">
                    <div class="sl-stat-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                    <div>
                        <div class="sl-stat-num">{{ $totalCount }}</div>
                        <div class="sl-stat-label">Total Logs</div>
                    </div>
                </div>
                <div class="sl-stat c-admin">
                    <div class="sl-stat-icon"><i class="fa-solid fa-user-tie"></i></div>
                    <div>
                        <div class="sl-stat-num">{{ $adminCount }}</div>
                        <div class="sl-stat-label">Admin Actions</div>
                    </div>
                </div>
                <div class="sl-stat c-dent">
                    <div class="sl-stat-icon"><i class="fa-solid fa-tooth"></i></div>
                    <div>
                        <div class="sl-stat-num">{{ $dentistCount }}</div>
                        <div class="sl-stat-label">Dentist Actions</div>
                    </div>
                </div>
                <div class="sl-stat c-pat">
                    <div class="sl-stat-icon"><i class="fa-solid fa-user"></i></div>
                    <div>
                        <div class="sl-stat-num">{{ $patientCount }}</div>
                        <div class="sl-stat-label">Patient Actions</div>
                    </div>
                </div>
            </div>

            {{-- Main Logs Card --}}
            <div class="sl-card">

                {{-- Toolbar --}}
                <div class="sl-toolbar flex-col sm:flex-row gap-3">
                    <div class="flex items-center gap-2">
                        <span class="sl-toolbar-title"><i class="fa-solid fa-list-check"></i> Audit Trail</span>
                        <span class="sl-entry-badge">{{ $totalCount }} {{ Str::plural('entry', $totalCount) }}</span>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <div class="sl-search flex-1 sm:flex-none">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="slSearch" placeholder="Search logs…" oninput="slFilter()"
                                class="w-full sm:w-auto">
                        </div>
                        <button class="sl-export-btn whitespace-nowrap"><i class="fa-solid fa-download"></i>
                            Export</button>
                    </div>
                </div>

                {{-- Filter Tabs --}}
                <div class="sl-tabs">
                    <button class="sl-tab active" onclick="slSetTab(this,'all')">
                        <i class="fa-solid fa-layer-group"></i> All <span class="sl-tab-count">{{ $totalCount }}</span>
                    </button>
                    <button class="sl-tab" onclick="slSetTab(this,'admin')">
                        <i class="fa-solid fa-user-tie"></i> Admin <span class="sl-tab-count">{{ $adminCount }}</span>
                    </button>
                    <button class="sl-tab" onclick="slSetTab(this,'dentist')">
                        <i class="fa-solid fa-tooth"></i> Dentist <span class="sl-tab-count">{{ $dentistCount }}</span>
                    </button>
                    <button class="sl-tab" onclick="slSetTab(this,'patient')">
                        <i class="fa-solid fa-user"></i> Patient <span class="sl-tab-count">{{ $patientCount }}</span>
                    </button>
                    <button class="sl-tab" onclick="slSetTab(this,'login')">
                        <i class="fa-solid fa-right-to-bracket"></i> Logins <span class="sl-tab-count">{{ $loginCount
                            }}</span>
                    </button>
                </div>

                {{-- Table --}}
                <div style="overflow-x:auto;">
                    <table class="sl-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Timestamp</th>
                                <th>Role</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Module</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody id="slTableBody">
                            @forelse($logs as $log)
                            @php
                            $role = strtolower($log->actor_role ?? 'other');
                            $action = strtolower($log->action ?? '');
                            $actionClass = match(true) {
                            str_contains($action,'login') => 'login',
                            str_contains($action,'logout') => 'logout',
                            str_contains($action,'create') => 'create',
                            str_contains($action,'update') => 'update',
                            str_contains($action,'delete') => 'delete',
                            default => 'default',
                            };
                            $actionIcon = match($actionClass) {
                            'login' => 'fa-right-to-bracket',
                            'logout' => 'fa-right-from-bracket',
                            'create' => 'fa-plus',
                            'update' => 'fa-pen',
                            'delete' => 'fa-trash',
                            default => 'fa-bolt',
                            };
                            $roleIcon = match($role) {
                            'admin' => 'fa-user-tie',
                            'dentist' => 'fa-tooth',
                            'patient' => 'fa-user',
                            default => 'fa-circle-user',
                            };
                            $avatarLetter = strtoupper(substr($log->actor_identifier ?? $role, 0, 1));
                            @endphp
                            <tr data-role="{{ $role }}" data-action="{{ $actionClass }}">
                                <td><span class="sl-id">#{{ str_pad($log->id, 3, '0', STR_PAD_LEFT) }}</span></td>
                                <td>
                                    <span class="sl-date-day">{{ $log->created_at->format('M j, Y') }}</span>
                                    <span class="sl-date-time">{{ $log->created_at->format('h:i:s A') }}</span>
                                </td>
                                <td><span class="sl-role {{ $role }}"><i class="fa-solid {{ $roleIcon }}"></i>{{
                                        ucfirst($role) }}</span></td>
                                <td>
                                    <div class="sl-user">
                                        <div class="sl-avatar {{ $role }}">{{ $avatarLetter }}</div>
                                        <span class="sl-username">{{ $log->actor_identifier ?? '—' }}</span>
                                    </div>
                                </td>
                                <td><span class="sl-action {{ $actionClass }}"><i
                                            class="fa-solid {{ $actionIcon }}"></i>{{
                                        str_replace('_','',ucwords($log->action)) }}</span></td>
                                <td><span class="sl-module"><i class="fa-solid fa-cube"></i>{{ ucfirst($log->module)
                                        }}</span></td>
                                <td><span class="sl-desc">{{ $log->description ?? 'No description provided.' }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="sl-empty">
                                        <i class="fa-solid fa-clipboard-list"></i>
                                        <div class="sl-empty-title">No system logs found</div>
                                        <div class="sl-empty-sub">Activity will appear here once users interact with the
                                            system.</div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="sl-pagebar">
                    @if(method_exists($logs, 'total'))
                    <span class="sl-pagebar-info">
                        Showing <strong>{{ $logs->firstItem() }}–{{ $logs->lastItem() }}</strong> of <strong>{{
                            $logs->total() }}</strong> entries
                    </span>
                    <div>{{ $logs->links() }}</div>
                    @else
                    <span class="sl-pagebar-info">Showing <strong>{{ $logs->count() }}</strong> {{ Str::plural('entry',
                        $logs->count()) }}</span>
                    <span></span>
                    @endif
                </div>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer id="siteFooter">
        <div class="footer-inner">
            <span style="color:rgba(255,255,255,.5);">© 1998–2026</span>
            <span style="font-weight:700;color:#fff;">Polytechnic University of the Philippines</span>
            <span class="footer-dot">·</span>
            <a href="https://www.pup.edu.ph/terms/">Terms of Use</a>
            <span class="footer-dot">·</span>
            <a href="https://www.pup.edu.ph/privacy/">Privacy Statement</a>
        </div>
    </footer>

    <script>
        /* NOTIF */
        document.getElementById('notifBtn').addEventListener('click', e => {
            e.stopPropagation();
            document.getElementById('notifMenu').classList.toggle('open');
        });
        document.addEventListener('click', () => document.getElementById('notifMenu').classList.remove('open'));

        /* USER DROPDOWN */
        document.getElementById('userBtn').addEventListener('click', e => {
            e.stopPropagation();
            document.getElementById('notifMenu').classList.remove('open'); // close notif if open
            document.getElementById('userMenu').classList.toggle('open');
        });
        document.addEventListener('click', () => document.getElementById('userMenu').classList.remove('open'));

        /* Sync user menu theme toggle */
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('#userMenuThemeToggle .theme-option').forEach(o =>
                o.addEventListener('click', e => { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); })
            );
        });

        /* ── MOBILE DRAWER ── */
        function openDrawer() {
            const drawer = document.getElementById('mobileDrawer');
            const overlay = document.getElementById('mobileDrawerOverlay');
            overlay.style.display = 'block';
            requestAnimationFrame(() => {
                overlay.classList.add('open');
                drawer.classList.add('open');
            });
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            const drawer = document.getElementById('mobileDrawer');
            const overlay = document.getElementById('mobileDrawerOverlay');
            drawer.classList.remove('open');
            overlay.classList.remove('open');
            setTimeout(() => { overlay.style.display = 'none'; }, 250);
            document.body.style.overflow = '';
        }

        document.getElementById('mobileMenuBtn')?.addEventListener('click', e => {
            e.stopPropagation();
            openDrawer();
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeDrawer();
        });

        /* Sync drawer theme toggles with main theme */
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('#drawerThemeToggle .theme-option').forEach(o =>
                o.addEventListener('click', e => {
                    e.stopPropagation();
                    applyTheme(o.getAttribute('data-theme'));
                    // sync indicator in drawer
                    const ind = document.querySelector('#drawerThemeToggle .theme-indicator');
                    if (ind) ind.classList.toggle('dark-mode', o.getAttribute('data-theme') === 'dark');
                })
            );
        });

        // Theme
        const html = document.documentElement;
        function applyTheme(theme) {
            html.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            document.querySelectorAll('.theme-option').forEach(o =>
                o.getAttribute('data-theme') === theme ? o.classList.add('active') : o.classList.remove('active')
            );
            document.querySelectorAll('.theme-indicator').forEach(ind =>
                theme === 'dark' ? ind.classList.add('dark-mode') : ind.classList.remove('dark-mode')
            );
        }
        document.addEventListener('DOMContentLoaded', () => {
            applyTheme(localStorage.getItem('theme') || 'light');
            document.querySelectorAll('.theme-option').forEach(o =>
                o.addEventListener('click', e => { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); })
            );
        });

        // Logs filtering
        let slActiveTab = 'all';
        function slSetTab(el, tab) {
            slActiveTab = tab;
            document.querySelectorAll('.sl-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            slFilter();
        }
        function slFilter() {
            const q = document.getElementById('slSearch').value.toLowerCase();
            document.querySelectorAll('#slTableBody tr').forEach(row => {
                const role = (row.dataset.role || '').toLowerCase();
                const action = (row.dataset.action || '').toLowerCase();
                const text = row.textContent.toLowerCase();
                const tabOk = slActiveTab === 'all' || slActiveTab === role || (slActiveTab === 'login' && action === 'login');
                const searchOk = !q || text.includes(q);
                row.style.display = (tabOk && searchOk) ? '' : 'none';
            });
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function getActionClass(action) {
            action = (action || '').toLowerCase();

            if (action.includes('login')) return 'login';
            if (action.includes('logout')) return 'logout';
            if (action.includes('create')) return 'create';
            if (action.includes('update')) return 'update';
            if (action.includes('delete')) return 'delete';

            return 'default';
        }

        function getActionIcon(actionClass) {
            switch (actionClass) {
                case 'login': return 'fa-right-to-bracket';
                case 'logout': return 'fa-right-from-bracket';
                case 'create': return 'fa-plus';
                case 'update': return 'fa-pen';
                case 'delete': return 'fa-trash';
                default: return 'fa-bolt';
            }
        }

        function getRoleIcon(role) {
            switch ((role || '').toLowerCase()) {
                case 'admin': return 'fa-user-tie';
                case 'dentist': return 'fa-tooth';
                case 'patient': return 'fa-user';
                default: return 'fa-circle-user';
            }
        }

        function buildLogRow(log, isNew = false) {
            const role = (log.actor_role || 'other').toLowerCase();
            const action = (log.action || '').toLowerCase();
            const actionClass = getActionClass(action);
            const actionIcon = getActionIcon(actionClass);
            const roleIcon = getRoleIcon(role);
            const avatarLetter = ((log.actor_identifier || role || '—').charAt(0) || '—').toUpperCase();

            return `
                <tr class="${isNew ? 'sl-row-new' : ''}" data-log-id="${escapeHtml(log.id)}" data-role="${escapeHtml(role)}" data-action="${escapeHtml(actionClass)}">
                    <td><span class="sl-id">#${String(log.id).padStart(3, '0')}</span></td>
                    <td>
                        <span class="sl-date-day">${escapeHtml(log.created_at_day || '')}</span>
                        <span class="sl-date-time">${escapeHtml(log.created_at_time || '')}</span>
                    </td>
                    <td>
                        <span class="sl-role ${escapeHtml(role)}">
                            <i class="fa-solid ${escapeHtml(roleIcon)}"></i>${escapeHtml(role.charAt(0).toUpperCase() + role.slice(1))}
                        </span>
                    </td>
                    <td>
                        <div class="sl-user">
                            <div class="sl-avatar ${escapeHtml(role)}">${escapeHtml(avatarLetter)}</div>
                            <span class="sl-username">${escapeHtml(log.actor_identifier || '—')}</span>
                        </div>
                    </td>
                    <td>
                        <span class="sl-action ${escapeHtml(actionClass)}">
                            <i class="fa-solid ${escapeHtml(actionIcon)}"></i>${escapeHtml(action.replace(/_/g, ' '))}
                        </span>
                    </td>
                    <td>
                        <span class="sl-module">
                            <i class="fa-solid fa-cube"></i>${escapeHtml(log.module || '')}
                        </span>
                    </td>
                    <td>
                        <span class="sl-desc">${escapeHtml(log.description || 'No description provided.')}</span>
                    </td>
                </tr>
            `;
        }

        let seenLogIds = new Set();
        let hasLoadedLogsOnce = false;
        async function fetchAuditLogs() {
            try {
                const response = await fetch("{{ route('admin.system_logs.fetch') }}", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch logs.');
                }

                const data = await response.json();
                const tableBody = document.getElementById('slTableBody');

                if (!tableBody) return;

                if (!data.logs || data.logs.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="7">
                                <div class="sl-empty">
                                    <i class="fa-solid fa-clipboard-list"></i>
                                    <div class="sl-empty-title">No system logs found</div>
                                    <div class="sl-empty-sub">Activity will appear here once users interact with the system.</div>
                                </div>
                            </td>
                        </tr>
                    `;
                    return;
                }

                const incomingIds = new Set(data.logs.map(log => String(log.id)));

                const html = data.logs.map(log => {
                    const isNew = hasLoadedLogsOnce && !seenLogIds.has(String(log.id));
                    return buildLogRow(log, isNew);
                }).join('');

                tableBody.innerHTML = html;

                seenLogIds = incomingIds;
                hasLoadedLogsOnce = true;

                slFilter();
                updateLogStats(data.logs);
            } catch (error) {
                console.error('Audit log fetch error:', error);
            }
        }

        function updateLogStats(logs) {
            const total = logs.length;
            const admin = logs.filter(log => (log.actor_role || '').toLowerCase() === 'admin').length;
            const dentist = logs.filter(log => (log.actor_role || '').toLowerCase() === 'dentist').length;
            const patient = logs.filter(log => (log.actor_role || '').toLowerCase() === 'patient').length;
            const logins = logs.filter(log => (log.action || '').toLowerCase().includes('login')).length;

            const statNums = document.querySelectorAll('.sl-stat-num');
            if (statNums.length >= 4) {
                statNums[0].textContent = total;
                statNums[1].textContent = admin;
                statNums[2].textContent = dentist;
                statNums[3].textContent = patient;
            }

            const tabCounts = document.querySelectorAll('.sl-tab-count');
            if (tabCounts.length >= 5) {
                tabCounts[0].textContent = total;
                tabCounts[1].textContent = admin;
                tabCounts[2].textContent = dentist;
                tabCounts[3].textContent = patient;
                tabCounts[4].textContent = logins;
            }

            const badge = document.querySelector('.sl-entry-badge');
            if (badge) {
                badge.textContent = `${total} ${total === 1 ? 'entry' : 'entries'}`;
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchAuditLogs();
            setInterval(fetchAuditLogs, 1000);
        });
    </script>
</body>

</html>