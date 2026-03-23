<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>System Logs | PUP Taguig Dental Clinic</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        :root {
            --sidebar-w: 256px;
        }

        #mainContent,
        #siteFooter {
            margin-left: var(--sidebar-w);
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
                padding-bottom: 2rem !important;
            }

            #siteFooter {
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

            /* Banner */
            .page-banner {
                border-radius: 14px !important;
                padding: 1.25rem 1.25rem 1.5rem !important;
            }

            .page-title {
                font-size: 1.5rem !important;
            }

            .page-banner-inner {
                flex-direction: column;
                gap: .75rem;
            }

            .page-banner-inner>div:last-child {
                flex-direction: row;
                flex-wrap: wrap;
                gap: .5rem;
            }

            /* Stat cards */
            .stat-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: .75rem;
            }

            .stat-value {
                font-size: 1.8rem !important;
            }

            .stat-footer {
                display: none;
            }

            /* Card header stacks */
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: .6rem;
                padding: .75rem 1rem;
            }

            .card-header>div:first-child {
                width: 100%;
            }

            .card-header>div:last-child {
                width: 100%;
                flex-wrap: nowrap;
            }

            .search-wrap {
                width: 100% !important;
                flex: 1;
            }

            .flex.gap-1.px-5.py-2\.5 {
                padding: .5rem .75rem;
                gap: .25rem;
            }

            .tab-btn {
                padding: 5px 10px;
                font-size: 11px;
                flex-shrink: 0;
            }

            #slTable thead th {
                display: none;
            }

            #slTable tbody tr {
                display: block;
                margin: 0 1rem .75rem;
                border-radius: 12px;
                border: 1px solid #f0f0f0;
                box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
                background: #fff;
                padding: .75rem 1rem;
                border-bottom: none !important;
            }

            #slTable tbody tr:hover {
                background: #fafbff;
            }

            /* Hide all cells by default */
            #slTable tbody td {
                display: none;
                border: none !important;
                padding: 0 !important;
            }

            /* Show only the cells we want */
            /* Col 1: ID */
            #slTable tbody td:nth-child(1) {
                display: inline-block;
            }

            /* Col 2: Timestamp */
            #slTable tbody td:nth-child(2) {
                display: inline-block;
                float: right;
            }

            /* Col 3: Role */
            #slTable tbody td:nth-child(3) {
                display: block;
                margin-top: .5rem;
            }

            /* Col 4: User */
            #slTable tbody td:nth-child(4) {
                display: inline-block;
                margin-top: .35rem;
            }

            /* Col 5: Action */
            #slTable tbody td:nth-child(5) {
                display: inline-block;
                margin-top: .35rem;
                margin-left: .35rem;
            }

            /* Col 7: Description */
            #slTable tbody td:nth-child(7) {
                display: block;
                margin-top: .5rem;
                padding-top: .5rem !important;
                border-top: 1px solid #f3f4f6 !important;
            }

            .sl-desc {
                max-width: 100%;
                font-size: .72rem;
                color: #6b7280;
            }

            #slTable tbody td:nth-child(1),
            #slTable tbody td:nth-child(2) {
                vertical-align: middle;
            }

            /* Fix overflow for the table wrapper */
            #slTable {
                border-collapse: separate;
                border-spacing: 0;
            }

            /* Dark mode cards */
            [data-theme="dark"] #slTable tbody tr {
                background: #161b22;
                border-color: #21262d;
            }

            [data-theme="dark"] #slTable tbody td:nth-child(7) {
                border-color: #21262d !important;
            }

            .sl-module {
                max-width: 100px;
            }

            /* Pagebar */
            .sl-pagebar {
                flex-direction: column;
                align-items: flex-start;
                gap: .6rem;
                padding: .75rem 1rem;
            }

            .sl-pagebar>div:first-child {
                width: 100%;
                flex-wrap: wrap;
                gap: .5rem;
            }

            .sl-pagebar>div:last-child {
                width: 100%;
                overflow-x: auto;
            }

            .sl-pagebar nav {
                width: max-content;
            }

            .data-table thead th {
                padding: .5rem .5rem;
                font-size: .6rem;
            }

            .data-table tbody td {
                padding: .6rem .5rem;
                font-size: .72rem;
            }

            #entryBadge {
                white-space: nowrap;
            }
        }

        @media (max-width: 480px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: .5rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-value {
                font-size: 1.6rem !important;
            }

            .stat-badge {
                display: none;
            }

            .page-title {
                font-size: 1.3rem !important;
            }

            .sl-export-btn span {
                display: none;
            }

            .sl-export-btn {
                padding: .42rem .6rem;
            }

            .card-header {
                padding: .65rem .75rem;
            }

            .tab-btn span {
                display: none;
            }

            #slTable thead th:nth-child(5),
            #slTable tbody td:nth-child(5) {
                display: none;
            }
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

        @keyframes sl-shimmer {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
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
            white-space: normal;
            word-break: break-word;
            max-width: 130px;
            line-height: 1.35;
        }

        .sl-module i {
            color: #8B0000;
            font-size: 0.65rem;
            flex-shrink: 0;
        }

        .sl-desc {
            color: #333333;
            font-size: 0.76rem;
            max-width: 240px;
            line-height: 1.45;
            white-space: normal;
            word-break: break-word;
        }

        .sl-desc strong {
            color: #374151;
            font-weight: 600;
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

        .page-banner {
            background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 60%, #c0392b 100%);
            padding: 1.75rem 2rem 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(139, 0, 0, .25);
        }

        .page-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .page-banner-inner {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 900;
            color: #fff !important;
            line-height: 1.1;
            letter-spacing: -.02em;
        }

        .page-subtitle {
            font-size: .78rem;
            color: rgba(255, 255, 255, .65) !important;
            margin-top: .4rem;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.25rem 1.4rem;
            border: 1px solid rgba(0, 0, 0, .05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
            transition: transform .2s, box-shadow .2s;
            position: relative;
            overflow: hidden;
            animation: fadeSlideUp .4s ease both;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, .1);
        }

        .stat-card-accent {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .stat-badge {
            font-size: .68rem;
            font-weight: 700;
            padding: .3rem .75rem;
            border-radius: 20px;
        }

        .stat-label {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #9ca3af;
            margin-bottom: .3rem;
        }

        .stat-value {
            font-size: 2.4rem;
            font-weight: 900;
            line-height: 1;
            color: #1a202c;
            letter-spacing: -.03em;
            margin-bottom: .5rem;
        }

        .stat-footer {
            font-size: .7rem;
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: .35rem;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, .05);
            box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
            overflow: hidden;
            animation: fadeSlideUp .4s ease .2s both;
        }

        .card-header {
            padding: .9rem 1.25rem;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafafa;
        }

        .card-header-left {
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .card-header-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--crimson-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: var(--crimson);
        }

        .card-title {
            font-size: 1rem;
            font-weight: 800;
            color: #1a202c;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .76rem;
            table-layout: fixed;
        }

        .data-table thead th {
            padding: .7rem 1rem;
            text-align: left;
            font-weight: 700;
            color: #9ca3af;
            font-size: .65rem;
            text-transform: uppercase;
            letter-spacing: .06em;
            background: #fafafa;
            border-bottom: 1px solid #f3f4f6;
        }

        .data-table tbody td {
            padding: .8rem 1rem;
            color: #4a5568;
            border-bottom: 1px solid #f9fafb;
        }

        .data-table tbody tr:hover td {
            background: #fafafa;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* search-wrap + tab-btn (same as inventory) */
        .search-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #FAFAF9;
            border: 1.5px solid #E0DDD8;
            border-radius: 12px;
            padding: 0 14px;
            height: 38px;
            transition: border-color .2s, box-shadow .2s;
            min-width: 0;
            flex-shrink: 1;
        }

        .search-wrap:focus-within {
            border-color: var(--crimson);
            box-shadow: 0 0 0 3px rgba(139, 0, 0, .1);
        }

        .search-wrap i {
            color: var(--crimson);
            font-size: 13px;
            flex-shrink: 0;
        }

        .search-wrap input {
            border: none;
            background: none;
            outline: none;
            font-size: 13px;
            color: #333;
            width: 100%;
        }

        .search-wrap input::placeholder {
            color: #B0ABA6;
        }

        .search-clear-btn {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: none;
            background: #E0DDD8;
            color: #7A7370;
            font-size: 10px;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all .2s;
            padding: 0;
        }

        .search-clear-btn:hover {
            background: #8b000076;
            color: #fff;
        }

        .search-clear-btn.visible {
            display: flex;
        }

        .tab-group {
            display: flex;
            background: #F5F2EE;
            border: 1px solid #E8E4DE;
            border-radius: 10px;
            padding: 3px;
            gap: 2px;
            flex-shrink: 0;
        }

        .tab-btn {
            padding: 6px 14px;
            border-radius: 7px;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            color: #9A9490;
            transition: all .2s;
            white-space: nowrap;
        }

        .tab-btn.active {
            background: var(--crimson);
            color: #fff;
            box-shadow: 0 2px 8px rgba(139, 0, 0, .3);
        }

        .sl-export-btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .42rem .85rem;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            color: #374151;
            font-size: .76rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .sl-export-btn:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        .sl-live {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .72rem;
            font-weight: 600;
            color: #059669;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            padding: .3rem .7rem;
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
                box-shadow: 0 0 0 0 rgba(16, 185, 129, .5);
            }

            50% {
                box-shadow: 0 0 0 4px rgba(16, 185, 129, 0);
            }
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card:nth-child(1) {
            animation-delay: .05s;
        }

        .stat-card:nth-child(2) {
            animation-delay: .1s;
        }

        .stat-card:nth-child(3) {
            animation-delay: .15s;
        }

        .stat-card:nth-child(4) {
            animation-delay: .2s;
        }

        @media(max-width:1024px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:640px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stat-value {
                font-size: 1.8rem;
            }
        }

        /* dark mode cards */
        [data-theme="dark"] .stat-card,
        [data-theme="dark"] .card {
            background: #161b22 !important;
            border-color: #21262d !important;
        }

        [data-theme="dark"] .card-header {
            background: #0d1117 !important;
            border-color: #21262d !important;
        }

        [data-theme="dark"] .card-title,
        [data-theme="dark"] .stat-value {
            color: #f3f4f6;
        }

        [data-theme="dark"] .data-table thead th {
            background: #0d1117;
            border-color: #21262d;
        }

        [data-theme="dark"] .data-table tbody td {
            color: #d1d5db;
            border-color: #1c2128;
        }

        [data-theme="dark"] .data-table tbody tr:hover td {
            background: #1c2128;
        }
    </style>
</head>

<body class="bg-[#F4F4F4] text-[#333333] min-h-screen">

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
            <a href="{{ route('admin.system_settings') }}" class="hdr-icon-btn" aria-label="Settings">
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

    @php
    $logs = $logs ?? collect([]);
    $perPage = $perPage ?? 20;
    @endphp

    <main id="mainContent" class="pb-8 min-h-screen"
        style="padding-top: calc(var(--header-h) + 1.5rem); padding-left: 1.5rem; padding-right: 1.5rem;">
        <div class="max-w-[1280px] mx-auto">

            <!-- Page Banner -->
            <div class="page-banner rounded-2xl mb-6">
                <div class="page-banner-inner">
                    <div>
                        <h1 class="page-title">System Logs</h1>
                        <p class="page-subtitle">View recorded activities of admin, dentist, and patient users.</p>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <span class="sl-live"><span class="sl-live-dot"></span> Live Monitoring</span>
                    </div>
                </div>
            </div>

            {{-- STAT CARDS (dashboard style) --}}
            <div class="stat-grid" style="margin-bottom:1.5rem;">
                <div class="stat-card">
                    <div class="stat-card-accent" style="background:linear-gradient(90deg,var(--crimson),#c0392b);">
                    </div>
                    <div class="stat-top">
                        <div class="stat-icon" style="background:#fef2f2;">
                            <i class="fa-solid fa-clipboard-list" style="color:var(--crimson);"></i>
                        </div>
                        <span class="stat-badge" style="background:#fef2f2;color:var(--crimson);">Total</span>
                    </div>
                    <div class="stat-label">Total Logs</div>
                    <div class="stat-value" id="statTotal">{{ $totalCount }}</div>
                    <div class="stat-footer"><i class="fa-solid fa-list"
                            style="font-size:.65rem;color:var(--crimson);"></i> All recorded activity</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-accent" style="background:linear-gradient(90deg,#ef4444,#fca5a5);"></div>
                    <div class="stat-top">
                        <div class="stat-icon" style="background:#fef2f2;">
                            <i class="fa-solid fa-user-tie" style="color:#ef4444;"></i>
                        </div>
                        <span class="stat-badge" style="background:#fef2f2;color:#ef4444;">Admin</span>
                    </div>
                    <div class="stat-label">Admin Actions</div>
                    <div class="stat-value" id="statAdmin" style="color:#ef4444;">{{ $adminCount }}</div>
                    <div class="stat-footer"><i class="fa-solid fa-shield" style="font-size:.65rem;color:#ef4444;"></i>
                        Administrator activity</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-accent" style="background:linear-gradient(90deg,#3b82f6,#93c5fd);"></div>
                    <div class="stat-top">
                        <div class="stat-icon" style="background:#eff6ff;">
                            <i class="fa-solid fa-tooth" style="color:#3b82f6;"></i>
                        </div>
                        <span class="stat-badge" style="background:#eff6ff;color:#3b82f6;">Dentist</span>
                    </div>
                    <div class="stat-label">Dentist Actions</div>
                    <div class="stat-value" id="statDentist" style="color:#3b82f6;">{{ $dentistCount }}</div>
                    <div class="stat-footer"><i class="fa-solid fa-stethoscope"
                            style="font-size:.65rem;color:#3b82f6;"></i> Dentist activity</div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-accent" style="background:linear-gradient(90deg,#10b981,#6ee7b7);"></div>
                    <div class="stat-top">
                        <div class="stat-icon" style="background:#ecfdf5;">
                            <i class="fa-solid fa-user" style="color:#10b981;"></i>
                        </div>
                        <span class="stat-badge" style="background:#ecfdf5;color:#059669;">Patient</span>
                    </div>
                    <div class="stat-label">Patient Actions</div>
                    <div class="stat-value" id="statPatient" style="color:#10b981;">{{ $patientCount }}</div>
                    <div class="stat-footer"><i class="fa-solid fa-heart-pulse"
                            style="font-size:.65rem;color:#10b981;"></i> Patient activity</div>
                </div>
            </div>

            <div class="card">
                {{-- Card Header --}}
                <div class="card-header">
                    <div class="flex items-center gap-2.5">
                        <div class="card-header-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                        <span class="card-title">Audit Trail</span>
                        <span id="entryBadge"
                            class="bg-red-50 text-[#8B0000] text-[0.68rem] font-bold px-2 py-0.5 rounded-full border border-red-200 ml-1.5">
                            {{ $totalCount }} {{ Str::plural('entry', $totalCount) }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <form method="GET" action="{{ route('admin.system_logs') }}" id="searchForm"
                            class="flex items-center">
                            <input type="hidden" name="role" value="{{ $role ?? 'all' }}">
                            <input type="hidden" name="per_page" value="{{ $perPage }}">
                            <div class="search-wrap" style="width:200px;">
                                <i class="fa fa-search"></i>
                                <input id="slSearch" name="search" placeholder="Search logs…"
                                    value="{{ $search ?? '' }}"
                                    onkeydown="if(event.key==='Enter'){event.preventDefault();slState.search=this.value;slState.page=1;slFetch();}">
                                <button type="button" id="searchClearBtn"
                                    class="search-clear-btn {{ ($search ?? '') ? 'visible' : '' }}"
                                    onclick="clearSearch()" title="Clear">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </form>
                        <button class="sl-export-btn">
                            <i class="fa-solid fa-download"></i>
                            <span class="hidden sm:inline">Export</span>
                        </button>
                    </div>
                </div>

                {{-- Filter Tabs --}}
                @php $activeRole = $role ?? 'all'; @endphp
                <div class="flex gap-1 px-5 py-2.5 border-b border-gray-100 overflow-x-auto">
                    @foreach([
                    ['key' => 'all', 'label' => 'All', 'icon' => 'fa-layer-group', 'count' => $totalCount],
                    ['key' => 'admin', 'label' => 'Admin', 'icon' => 'fa-user-tie', 'count' => $adminCount],
                    ['key' => 'dentist', 'label' => 'Dentist', 'icon' => 'fa-tooth', 'count' => $dentistCount],
                    ['key' => 'patient', 'label' => 'Patient', 'icon' => 'fa-user', 'count' => $patientCount],
                    ['key' => 'login', 'label' => 'Logins', 'icon' => 'fa-right-to-bracket', 'count' => $loginCount],
                    ] as $tab)
                    <button class="tab-btn {{ $activeRole === $tab['key'] ? 'active' : '' }}"
                        onclick="slSetTab(this, '{{ $tab['key'] }}')">
                        <i class="fa-solid {{ $tab['icon'] }} mr-1 text-[0.7rem]"></i> {{ $tab['label'] }}
                        <span
                            class="tab-count {{ $activeRole === $tab['key'] ? 'bg-red-200 text-[#8B0000]' : 'bg-gray-200 text-gray-500' }} text-[0.62rem] font-bold px-1.5 py-0.5 rounded-full ml-1">
                            {{ $tab['count'] }}
                        </span>
                    </button>
                    @endforeach
                </div>

                {{-- Top pagebar --}}
                <div class="sl-pagebar" style="border-top:none; border-bottom:1px solid #f3f4f6;">
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="sl-pagebar-info">
                            @if(method_exists($logs,'total'))
                            Showing <strong>{{ $logs->firstItem() }}–{{ $logs->lastItem() }}</strong>
                            of <strong>{{ $logs->total() }}</strong> entries
                            @else
                            Showing <strong>{{ $logs->count() }}</strong> {{ Str::plural('entry', $logs->count()) }}
                            @endif
                        </span>
                        <div class="flex items-center gap-1.5">
                            <label class="text-[0.7rem] text-gray-400 font-semibold">Show</label>
                            <select id="perPageSelect"
                                class="h-[30px] px-2 border border-gray-200 rounded-lg text-xs font-semibold text-gray-700 bg-white outline-none cursor-pointer transition-colors focus:border-[#8B0000]">
                                @foreach([10, 20, 50, 100] as $size)
                                <option value="{{ $size }}" {{ $perPage == $size ? 'selected' : '' }}>{{ $size }}</option>
                                @endforeach
                            </select>
                            <span class="text-[0.7rem] text-gray-400 font-semibold">per page</span>
                        </div>
                    </div>
                    <div class="sl-pagination-wrap"></div>
                </div>

                {{-- Table --}}
                <div style="overflow-x:auto;">
                    <table class="data-table" id="slTable">
                        <thead>
                            <tr>
                                <th style="width:100px;">ID</th>
                                <th style="width:150px;">Timestamp</th>
                                <th style="width:150px;">Role</th>
                                <th style="width:130px;">User</th>
                                <th style="width:170px;">Action</th>
                                <th style="width:210px;">Module</th>
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
                                            class="fa-solid {{ $actionIcon }}"></i>{{ ucwords(str_replace('_','
                                        ',$log->action)) }}</span></td>
                                <td><span class="sl-module"><i class="fa-solid fa-cube"></i>{{ ucfirst(str_replace('_','
                                        ',$log->module)) }}</span></td>
                                <td><span class="sl-desc">{{ $log->description ?? 'No description provided.' }}</span>
                                </td>
                            </tr>
                            @empty
                            {{-- handled by JS empty state below --}}
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Empty State (JS-controlled) --}}
                <div id="emptyState" style="display:none;"></div>

                {{-- Bottom pagebar --}}
                <div class="sl-pagebar">
                    <span class="sl-pagebar-info">
                        @if(method_exists($logs,'total'))
                        Showing <strong>{{ $logs->firstItem() }}–{{ $logs->lastItem() }}</strong>
                        of <strong>{{ $logs->total() }}</strong> entries
                        @else
                        Showing <strong>{{ $logs->count() }}</strong> {{ Str::plural('entry', $logs->count()) }}
                        @endif
                    </span>
                    <div class="sl-pagination-wrap"></div>
                </div>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer id="siteFooter">
        <div class="footer-inner">
        <span style="color:rgba(255,255,255,.5);">© 1998–2026</span>
        <span style="font-weight:700;color:#fff;">Polytechnic University of the Philippines</span>
        <span class="footer-dot">|</span>
        <a href="https://www.pup.edu.ph/terms/">Terms of Use</a>
        <span class="footer-dot">|</span>
        <a href="https://www.pup.edu.ph/privacy/">Privacy Statement</a>
        </div>
    </footer>

    <script>
        /* ── NOTIF ── */
        document.getElementById('notifBtn').addEventListener('click', function (e) { e.stopPropagation(); document.getElementById('notifMenu').classList.toggle('open'); document.getElementById('userMenu').classList.remove('open'); });
        document.getElementById('userBtn').addEventListener('click', function (e) { e.stopPropagation(); document.getElementById('notifMenu').classList.remove('open'); document.getElementById('userMenu').classList.toggle('open'); });
        document.addEventListener('click', function () { document.getElementById('notifMenu').classList.remove('open'); document.getElementById('userMenu').classList.remove('open'); });

        /* ── MOBILE DRAWER ── */
        function openDrawer() { var d = document.getElementById('mobileDrawer'), o = document.getElementById('mobileDrawerOverlay'); o.style.display = 'block'; requestAnimationFrame(function () { o.classList.add('open'); d.classList.add('open'); }); document.body.style.overflow = 'hidden'; }
        function closeDrawer() { var d = document.getElementById('mobileDrawer'), o = document.getElementById('mobileDrawerOverlay'); d.classList.remove('open'); o.classList.remove('open'); setTimeout(function () { o.style.display = 'none'; }, 250); document.body.style.overflow = ''; }
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function (e) { e.stopPropagation(); openDrawer(); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeDrawer(); });

        /* ── THEME ── */
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            document.querySelectorAll('.theme-option').forEach(function (o) { o.getAttribute('data-theme') === theme ? o.classList.add('active') : o.classList.remove('active'); });
            document.querySelectorAll('.theme-indicator').forEach(function (ind) { theme === 'dark' ? ind.classList.add('dark-mode') : ind.classList.remove('dark-mode'); });
        }
        document.addEventListener('DOMContentLoaded', function () {
            applyTheme(localStorage.getItem('theme') || 'light');
            document.querySelectorAll('.theme-option').forEach(function (o) {
                o.addEventListener('click', function (e) { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); });
            });

            @if(method_exists($logs, 'total') && $logs->total() > 0)
            slRenderPagebar({
                total:        {{ $logs->total() }},
                from:         {{ $logs->firstItem() ?? 0 }},
                to:           {{ $logs->lastItem() ?? 0 }},
                current_page: {{ $logs->currentPage() }},
                last_page:    {{ $logs->lastPage() }},
                per_page:     {{ $logs->perPage() }},
            });
            @endif

            var searchInput = document.getElementById('slSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    toggleSearchClear(this);
                    clearTimeout(slSearchTimer);
                    slSearchTimer = setTimeout(function () {
                        slState.search = searchInput.value;
                        slState.page = 1;
                        slFetch(true);
                    });
                });
            }

            /* ── Per-page select ── */
            var perPageSelect = document.getElementById('perPageSelect');
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function () {
                    slState.perPage = parseInt(this.value);
                    slState.page = 1;
                    slFetch();
                });
            }

            @php $latestLogId = optional(($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() : $logs)->first())->id ?? 0; @endphp

            var lastKnownId = {{ $latestLogId }};
            var notifBanner = null;

            function checkForNewLogs() {
                fetch("{{ route('admin.system_logs.check') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
                    .then(function (res) { return res.json(); })
                    .then(function (data) {
                        if (data.latest_id > lastKnownId) { lastKnownId = data.latest_id; showNewLogBanner(); }
                    }).catch(function () { });
            }

            function showNewLogBanner() {
                if (notifBanner) notifBanner.remove();

                notifBanner = document.createElement('div');
                notifBanner.style.cssText = `
                    position:fixed;
                    top:80px;
                    left:50%;
                    transform:translateX(-50%);
                    z-index:9999;
                    display:flex;
                    align-items:center;
                    gap:.6rem;
                    background:#fff;
                    border:1.5px solid #a7f3d0;
                    border-radius:12px;
                    padding:.65rem 1.1rem;
                    box-shadow:0 8px 24px rgba(0,0,0,.12);
                    font-size:.78rem;
                    font-weight:600;
                    color:#059669;
                    white-space:nowrap;
                `;

                notifBanner.innerHTML = `
                    <i class="fa-solid fa-circle-check" style="color:#10b981;"></i>
                    New log entries detected.
                    <span style="color:#8B0000;text-decoration:underline;margin-left:.25rem;cursor:pointer;"
                        onclick="slState.page=1;slFetch(); this.closest('div').remove();">
                        Refresh to see
                    </span>
                    <button onclick="this.parentElement.remove()"
                        style="margin-left:.5rem;background:none;border:none;cursor:pointer;color:#9ca3af;font-size:.7rem;padding:0;">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                `;

                document.body.appendChild(notifBanner);
            }

            setInterval(checkForNewLogs, 5000);
        });

        /* ════════════════════════════════════════
           AJAX FILTER STATE
        ════════════════════════════════════════ */
        var slState = {
            role: '{{ $role ?? "all" }}',
            search: '{{ $search ?? "" }}',
            perPage: {{ $perPage ?? 20 }},
            page: {{ request('page', 1) }},
        };

        var slOverallTotal = {{ $totalCount }};
        var slSearchTimer = null;
        var slController = null;

        /* ── Search input ── */
        function toggleSearchClear(input) {
            document.getElementById('searchClearBtn').classList.toggle('visible', input.value.length > 0);
        }

        function clearSearch() {
            var input = document.getElementById('slSearch');
            input.value = '';
            document.getElementById('searchClearBtn').classList.remove('visible');
            slState.search = '';
            slState.page = 1;
            slFetch();
            input.focus();
        }

        /* ── Tab click ── */
        function slSetTab(el, role) {
            slState.role = role;
            slState.page = 1;
            document.querySelectorAll('.tab-btn').forEach(function (b) { b.classList.remove('active'); });
            el.classList.add('active');

            // Update tab badge colors
            document.querySelectorAll('.tab-btn .tab-count').forEach(function (span) {
                span.className = 'tab-count bg-gray-200 text-gray-500 text-[0.62rem] font-bold px-1.5 py-0.5 rounded-full ml-1';
            });
            var activeSpan = el.querySelector('.tab-count');
            if (activeSpan) activeSpan.className = 'tab-count bg-red-200 text-[#8B0000] text-[0.62rem] font-bold px-1.5 py-0.5 rounded-full ml-1';

            slFetch();
        }

        /* ── Pagination click ── */
        function slGoPage(page) {
            slState.page = page;
            slFetch();
            // Smooth scroll to table top
            document.getElementById('slTable')?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        /* ── Core fetch ── */
        function slFetch(silent) {
            if (slController) slController.abort();
            slController = new AbortController();

            var params = new URLSearchParams({
                role: slState.role,
                search: slState.search,
                per_page: slState.perPage,
                page: slState.page,
            });

            history.replaceState(null, '', window.location.pathname + '?' + params.toString());

            if (!silent) {
             document.getElementById('slTableBody').innerHTML = slSkeletonRows(slState.perPage);
            }
            document.getElementById('emptyState').style.display = 'none';
            document.getElementById('slTable').style.display = '';

            fetch('{{ route("admin.system_logs") }}?' + params.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? ''
                },
                signal: slController.signal
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                slRenderRows(data.logs);
                slRenderPagebar(data.pagination);
                slRenderCounts(data.counts);
            })
            .catch(function (e) {
                if (e.name !== 'AbortError') console.error('Fetch error:', e);
            });
        }

        /* ── Skeleton loader rows ── */
        function slSkeletonRows(count) {
            var pulse = 'style="background:linear-gradient(90deg,#f3f4f6 25%,#e5e7eb 50%,#f3f4f6 75%);background-size:200% 100%;animation:sl-shimmer 1.2s infinite;border-radius:6px;display:inline-block;"';
            var row = '<tr>';
            row += '<td><span class="sl-id" ' + pulse + ' style="width:36px;height:14px;background:linear-gradient(90deg,#f3f4f6 25%,#e5e7eb 50%,#f3f4f6 75%);background-size:200% 100%;animation:sl-shimmer 1.2s infinite;border-radius:6px;display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>';
            row += '<td><span ' + pulse + ' style="width:80px;height:14px;">&nbsp;</span></td>';
            row += '<td><span ' + pulse + ' style="width:60px;height:22px;">&nbsp;</span></td>';
            row += '<td><span ' + pulse + ' style="width:70px;height:14px;">&nbsp;</span></td>';
            row += '<td><span ' + pulse + ' style="width:55px;height:22px;">&nbsp;</span></td>';
            row += '<td><span ' + pulse + ' style="width:80px;height:14px;">&nbsp;</span></td>';
            row += '<td><span ' + pulse + ' style="width:140px;height:14px;">&nbsp;</span></td>';
            row += '</tr>';
            var html = '';
            for (var i = 0; i < Math.min(count, 5); i++) html += row;
            return html;
        }

        /* ── Render table rows ── */
        function slRenderRows(logs) {
            if (!logs || logs.length === 0) {
                document.getElementById('slTableBody').innerHTML = '';
                showEmptyState(0, slState.search);
                return;
            }

            var actionIcons = { login: 'fa-right-to-bracket', logout: 'fa-right-from-bracket', create: 'fa-plus', update: 'fa-pen', delete: 'fa-trash', default: 'fa-bolt' };
            var roleIcons = { admin: 'fa-user-tie', dentist: 'fa-tooth', patient: 'fa-user' };

            var html = '';
            logs.forEach(function (log) {
                var role = (log.actor_role || 'other').toLowerCase();
                var action = (log.action || '').toLowerCase();
                var actionClass = action.includes('login') ? 'login' : action.includes('logout') ? 'logout' : action.includes('create') ? 'create' : action.includes('update') ? 'update' : action.includes('delete') ? 'delete' : 'default';
                var actionIcon = actionIcons[actionClass] || 'fa-bolt';
                var roleIcon = roleIcons[role] || 'fa-circle-user';
                var letter = (log.actor_identifier || role).charAt(0).toUpperCase();
                var idPadded = '#' + String(log.id).padStart(3, '0');
                var actionLabel = (log.action || '').replace(/_/g, ' ').replace(/\b\w/g, function (c) { return c.toUpperCase(); });
                var moduleLabel = (log.module || '').replace(/_/g, ' ').replace(/\b\w/g, function (c) { return c.toUpperCase(); });

                html += '<tr data-role="' + role + '" data-action="' + actionClass + '" class="sl-row-new">';
                html += '<td><span class="sl-id">' + idPadded + '</span></td>';
                html += '<td><span class="sl-date-day">' + log.created_at_day + '</span><span class="sl-date-time">' + log.created_at_time + '</span></td>';
                html += '<td><span class="sl-role ' + role + '"><i class="fa-solid ' + roleIcon + '"></i>' + role.charAt(0).toUpperCase() + role.slice(1) + '</span></td>';
                html += '<td><div class="sl-user"><div class="sl-avatar ' + role + '">' + letter + '</div><span class="sl-username">' + (log.actor_identifier || '—') + '</span></div></td>';
                html += '<td><span class="sl-action ' + actionClass + '"><i class="fa-solid ' + actionIcon + '"></i>' + actionLabel + '</span></td>';
                html += '<td><span class="sl-module"><i class="fa-solid fa-cube"></i>' + moduleLabel + '</span></td>';
                html += '<td><span class="sl-desc" title="' + (log.description || '') + '">' + (log.description || 'No description provided.') + '</span></td>';
                html += '</tr>';
            });

            document.getElementById('slTableBody').innerHTML = html;
            document.getElementById('emptyState').style.display = 'none';
            document.getElementById('slTable').style.display = '';
        }

        /* ── Render both pagebars ── */
        function slRenderPagebar(p) {
            if (!p) return;

            var infoHtml = 'Showing <strong>' + p.from + '–' + p.to + '</strong> of <strong>' + p.total + '</strong> entries';
            document.querySelectorAll('.sl-pagebar-info').forEach(function (el) { el.innerHTML = infoHtml; });

            var navHtml = slBuildPagination(p);
            document.querySelectorAll('.sl-pagination-wrap').forEach(function (el) {
                el.innerHTML = navHtml;
            });

            // Update entry badge
            var badge = document.getElementById('entryBadge');
            if (badge) badge.textContent = slOverallTotal + ' ' + (slOverallTotal === 1 ? 'entry' : 'entries');
        }

        /* ── Build pagination HTML ── */
        function slBuildPagination(p) {
            if (p.last_page <= 1) return '';

            var current = p.current_page;
            var last = p.last_page;
            var window = 5;
            var half = Math.floor(window / 2);
            var start = Math.max(1, current - half);
            var end = Math.min(last, start + window - 1);
            if (end - start + 1 < window) start = Math.max(1, end - window + 1);

            var btn = 'style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #e5e7eb;background:#fff;color:#374151;font-size:.75rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;transition:all .15s;text-decoration:none;" onmouseover="this.style.borderColor=\'#8B0000\';this.style.color=\'#8B0000\';this.style.background=\'#fef2f2\';" onmouseout="this.style.borderColor=\'#e5e7eb\';this.style.color=\'#374151\';this.style.background=\'#fff\';"';
            var btnActive = 'style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #8B0000;background:linear-gradient(135deg,#8B0000,#6b0000);color:#fff;font-size:.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(139,0,0,.25);"';
            var btnDis = 'style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #e5e7eb;background:#f9fafb;color:#d1d5db;font-size:.75rem;font-weight:600;cursor:not-allowed;display:inline-flex;align-items:center;justify-content:center;"';
            var dots = '<span style="height:32px;min-width:32px;display:inline-flex;align-items:center;justify-content:center;color:#9ca3af;font-size:.75rem;font-weight:600;">…</span>';

            var html = '<nav style="display:flex;align-items:center;gap:.35rem;flex-wrap:nowrap;">';

            // Prev
            if (current <= 1) {
                html += '<button disabled ' + btnDis + '><i class="fa-solid fa-chevron-left" style="font-size:.65rem;"></i></button>';
            } else {
                html += '<button onclick="slGoPage(' + (current - 1) + ')" ' + btn + '><i class="fa-solid fa-chevron-left" style="font-size:.65rem;"></i></button>';
            }

            // First + ellipsis
            if (start > 1) {
                html += '<button onclick="slGoPage(1)" ' + btn + '>1</button>';
                if (start > 2) html += dots;
            }

            // Window pages
            for (var i = start; i <= end; i++) {
                if (i === current) {
                    html += '<span ' + btnActive + '>' + i + '</span>';
                } else {
                    html += '<button onclick="slGoPage(' + i + ')" ' + btn + '>' + i + '</button>';
                }
            }

            // Last + ellipsis
            if (end < last) {
                if (end < last - 1) html += dots;
                html += '<button onclick="slGoPage(' + last + ')" ' + btn + '>' + last + '</button>';
            }

            // Next
            if (current >= last) {
                html += '<button disabled ' + btnDis + '><i class="fa-solid fa-chevron-right" style="font-size:.65rem;"></i></button>';
            } else {
                html += '<button onclick="slGoPage(' + (current + 1) + ')" ' + btn + '><i class="fa-solid fa-chevron-right" style="font-size:.65rem;"></i></button>';
            }

            html += '</nav>';
            return html;
        }

        /* ── Update stat counts ── */
        function slRenderCounts(counts) {
            if (!counts) return;

            slOverallTotal = counts.total;

            document.getElementById('statTotal').textContent = counts.total;
            document.getElementById('statAdmin').textContent = counts.admin;
            document.getElementById('statDentist').textContent = counts.dentist;
            document.getElementById('statPatient').textContent = counts.patient;

            var badge = document.getElementById('entryBadge');
            if (badge) {
                badge.textContent = slOverallTotal + ' ' + (slOverallTotal === 1 ? 'entry' : 'entries');
            }
        }

        /* ── Empty state ── */
        function showEmptyState(count, query) {
            var emptyState = document.getElementById('emptyState');
            var table = document.getElementById('slTable');
            if (!emptyState) return;
            if (count > 0) { emptyState.style.display = 'none'; if (table) table.style.display = ''; return; }
            if (table) table.style.display = 'none';
            emptyState.style.display = 'block';

            var icon, title, sub, extra = '';
            if (query) {
                icon = 'fa-magnifying-glass'; title = 'No results for \u201c' + query + '\u201d'; sub = 'Try a different name, action, or user.';
                extra = '<button onclick="clearSearch()" style="margin-top:.75rem;padding:.5rem 1.1rem;border-radius:10px;border:1.5px dashed #d1d5db;background:none;font-size:.8rem;color:#9ca3af;cursor:pointer;" onmouseover="this.style.borderColor=\'#8B0000\';this.style.color=\'#8B0000\';" onmouseout="this.style.borderColor=\'#d1d5db\';this.style.color=\'#9ca3af\';"><i class="fa-solid fa-xmark" style="margin-right:.4rem;font-size:.7rem;"></i>Clear search</button>';
            } else if (slState.role !== 'all') {
                var labels = { admin: 'Admin', dentist: 'Dentist', patient: 'Patient', login: 'Login' };
                icon = 'fa-filter'; title = 'No ' + (labels[slState.role] || slState.role) + ' logs found'; sub = 'There are no logs matching this filter yet.';
                extra = '<button onclick="slSetTab(document.querySelector(\'.tab-btn\'),\'all\')" style="margin-top:.75rem;padding:.5rem 1.1rem;border-radius:10px;border:1.5px dashed #d1d5db;background:none;font-size:.8rem;color:#9ca3af;cursor:pointer;" onmouseover="this.style.borderColor=\'#8B0000\';this.style.color=\'#8B0000\';" onmouseout="this.style.borderColor=\'#d1d5db\';this.style.color=\'#9ca3af\';"><i class="fa-solid fa-xmark" style="margin-right:.4rem;font-size:.7rem;"></i>Show all logs</button>';
            } else {
                icon = 'fa-clipboard-list'; title = 'No system logs yet'; sub = 'Activity will appear here once users interact with the system.';
            }

            emptyState.innerHTML = '<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:3.5rem 1rem;text-align:center;gap:.5rem;"><div style="width:60px;height:60px;border-radius:16px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;margin-bottom:.75rem;"><i class="fa-solid ' + icon + '" style="font-size:1.6rem;color:#d1d5db;"></i></div><p style="font-size:.9rem;font-weight:700;color:#6b7280;margin:0;">' + title + '</p><p style="font-size:.78rem;color:#b0b7c3;margin:0;max-width:280px;">' + sub + '</p>' + extra + '</div>';
        }
    </script>
</body>

</html>