<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>User Management | PUP Taguig Dental Clinic</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            daisyui: {
                themes: false
            }
        }
    </script>

    <style>
        :root {
            --crimson: #8B0000;
            --crimson-dark: #6b0000;
            --crimson-light: #fef2f2;
            --header-h: 64px;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
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
            color: #6B7280;
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
            color: #6b7280;
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
            font-size: .65rem;
            color: rgba(255, 255, 255, .6);
            font-style: italic;
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

            .user-table-row td {
                padding-top: 0.65rem;
                padding-bottom: 0.65rem;
            }

            .action-btn {
                padding: 5px 6px;
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
            color: #6B7280;
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

        .stat-card {
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .1);
        }

        .user-table-row {
            transition: background .15s;
        }

        .user-table-row:hover {
            background: #fef9f9;
        }

        .badge-role {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 99px;
        }

        .badge-active {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-inactive {
            background: #f3f4f6;
            color: #6b7280;
        }

        .action-btn {
            padding: 6px 8px;
            border-radius: 7px;
            border: none;
            cursor: pointer;
            font-size: 12px;
            transition: all .15s;
        }

        .action-btn:hover {
            transform: scale(1.08);
        }

        .btn-edit {
            background: #eff6ff;
            color: #2563eb;
        }

        .btn-edit:hover {
            background: #dbeafe;
        }

        .btn-toggle-on {
            background: #fef3c7;
            color: #b45309;
        }

        .btn-toggle-on:hover {
            background: #fde68a;
        }

        .btn-toggle-off {
            background: #d1fae5;
            color: #065f46;
        }

        .btn-toggle-off:hover {
            background: #a7f3d0;
        }

        .btn-reset {
            background: #f3e8ff;
            color: #7c3aed;
        }

        .btn-reset:hover {
            background: #ede9fe;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 200;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s;
        }

        .modal-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-box {
            background: #fff;
            border-radius: 20px;
            width: 100%;
            max-width: 560px;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(.95) translateY(10px);
            transition: transform .25s cubic-bezier(.4, 0, .2, 1);
            box-shadow: 0 24px 60px rgba(0, 0, 0, .18);
        }

        .modal-overlay.open .modal-box {
            transform: scale(1) translateY(0);
        }

        .modal-sm {
            max-width: 420px;
        }

        .field-input {
            transition: border-color .15s, box-shadow .15s;
        }

        .field-input:focus {
            outline: none;
            border-color: #8B0000 !important;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, .1);
        }

        .page-btn {
            min-width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background: #fff;
            cursor: pointer;
            font-size: .78rem;
            font-weight: 600;
            color: #6b7280;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 8px;
            transition: all .15s;
        }

        .page-btn:hover {
            background: #fef2f2;
            border-color: #8B0000;
            color: #8B0000;
        }

        .page-btn.active {
            background: #8B0000;
            border-color: #8B0000;
            color: #fff;
        }

        .page-btn:disabled {
            opacity: .4;
            cursor: not-allowed;
            pointer-events: none;
        }

        .flash-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: .75rem 1rem;
            border-radius: 12px;
            font-size: .82rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
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

        [data-theme="dark"] .text-gray-800 {
            color: #e5e7eb !important;
        }

        [data-theme="dark"] .text-gray-500 {
            color: #9ca3af !important;
        }

        [data-theme="dark"] .border-gray-100 {
            border-color: #21262d !important;
        }

        [data-theme="dark"] .bg-gray-50 {
            background-color: #0d1117 !important;
        }

        [data-theme="dark"] .bg-\[\#f5f5f5\] {
            background-color: #000D1A !important;
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

        [data-theme="dark"] .user-table-row:hover {
            background: #0d1117;
        }

        [data-theme="dark"] .modal-box {
            background: #161b22;
        }

        [data-theme="dark"] .modal-box input,
        [data-theme="dark"] .modal-box select {
            background: #0d1117 !important;
            border-color: #21262d !important;
            color: #e5e7eb !important;
        }

        [data-theme="dark"] table thead tr {
            background: #0d1117 !important;
        }

        [data-theme="dark"] .page-btn {
            background: #161b22;
            border-color: #21262d;
            color: #9ca3af;
        }

        [data-theme="dark"] .page-btn:hover {
            background: rgba(139, 0, 0, .2);
            border-color: #8B0000;
            color: #f87171;
        }

        [data-theme="dark"] .border-gray-200 {
            border-color: #21262d !important;
        }

        [data-theme="dark"] .bg-gray-100 {
            background-color: #21262d !important;
        }
    </style>
</head>

<body class="bg-[#f5f5f5] text-[#333333]">

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
            @php
                $notifications = collect($notifications ?? []);
                $notifCount = $notifications->count();
            @endphp
            <div id="notifDropdown">
                <button class="hdr-icon-btn" id="notifBtn" aria-label="Notifications">
                    <i class="fa-regular fa-bell"></i>
                    @if ($notifCount > 0)
                        <span class="notif-badge">{{ $notifCount }}</span>
                    @endif
                </button>
                <div id="notifMenu">
                    <div class="notif-header"><i class="fa-solid fa-bell text-xs"></i> Notifications</div>
                    <div style="max-height:260px;overflow-y:auto;">
                        @forelse($notifications as $n)
                            <a href="{{ $n['url'] ?? '#' }}"
                                style="display:block;padding:.65rem 1rem;font-size:.76rem;color:#333;text-decoration:none;border-bottom:1px solid #fdf5f5;transition:background .1s;"
                                onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background=''">
                                <div style="font-weight:700;">{{ $n['title'] ?? 'Notification' }}</div>
                                @if (!empty($n['message']))
                                    <div style="color:#aaa;margin-top:2px;font-size:.7rem;">{{ $n['message'] }}
                                    </div>
                                @endif
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
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i
                            class="fa-solid fa-users"></i>
                        Patients</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i
                            class="fa-solid fa-calendar-check"></i>
                        Appointments</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i
                            class="fa-solid fa-tooth"></i>
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
                    class="group-trigger {{ request()->routeIs('admin.user_management*', 'admin.role_permissions', 'admin.academic_periods*', 'admin.clinic_schedule*') ? 'active-group' : '' }}">
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
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i
                            class="fa-solid fa-file-pen"></i>
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
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i
                            class="fa-solid fa-database"></i>
                        Data
                        Backup</a>
                    <a href="{{ route('admin.system_logs') }}"
                        class="nav-link {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}"><i
                            class="fa-solid fa-clipboard-list"></i> System Logs</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i
                            class="fa-solid fa-sliders"></i>
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
                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i
                        class="fa-solid fa-file-pen"></i>
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
                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i
                        class="fa-solid fa-database"></i>
                    Data
                    Backup</a>
                <a href="{{ route('admin.system_logs') }}"
                    class="drawer-link {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}"><i
                        class="fa-solid fa-clipboard-list"></i> System Logs</a>
                <a href="{{ route('admin.admin.dashboard') }}" class="drawer-link"><i
                        class="fa-solid fa-sliders"></i>
                    System
                    Settings</a>
            </div>
        </div>
        <div class="drawer-bottom">
            <div class="theme-toggle-container" id="drawerThemeToggle" style="margin-bottom:10px;">
                <button type="button" class="theme-option active" data-theme="light"><i
                        class="fa-solid fa-sun"></i></button>
                <button type="button" class="theme-option" data-theme="dark"><i
                        class="fa-regular fa-moon"></i></button>
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
        $adminCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() : $logs)
            ->where('actor_role', 'admin')
            ->count();
        $dentistCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() : $logs)
            ->where('actor_role', 'dentist')
            ->count();
        $patientCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() : $logs)
            ->where('actor_role', 'patient')
            ->count();
        $loginCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() : $logs)
            ->whereIn('action', ['login', 'Login'])
            ->count();
    @endphp

    <main id="mainContent" class="px-4 sm:px-6 pt-[82px] pb-8 min-h-screen">
        <div style="max-width:1280px; margin:0 auto;">

            <div class="mb-6">
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <i class="fa-solid fa-user-gear text-[#8B0000] text-xs"></i>
                    <p id="currentDate"></p>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-[#8B0000]">User Management</h1>
                        <p class="text-gray-500 text-sm mt-1">Manage system accounts, roles, and access permissions</p>
                    </div>
                    <button onclick="openModal('addModal')"
                        class="flex items-center justify-center gap-2 bg-[#8B0000] hover:bg-[#760000] text-white px-5 py-2.5 rounded-lg font-semibold text-sm shadow transition-all w-full sm:w-auto">
                        <i class="fa-solid fa-user-plus"></i> Add New User
                    </button>
                </div>
            </div>

            @if (session('success'))
                <div class="flash-alert bg-green-50 border border-green-200 text-green-800">
                    <i class="fa-solid fa-circle-check text-green-500"></i>
                    {{ session('success') }}
                    <button onclick="this.parentElement.remove()"
                        class="ml-auto text-green-400 hover:text-green-600"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if (session('error'))
                <div class="flash-alert bg-red-50 border border-red-200 text-red-800">
                    <i class="fa-solid fa-circle-xmark text-red-500"></i>
                    {{ session('error') }}
                    <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @php
                $totalUsers = $users->total();
                $activeCount = \App\Models\User::where('status', 'active')->count();
                $inactiveCount = \App\Models\User::where('status', 'inactive')->count();
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                <div class="stat-card bg-white rounded-xl p-4 shadow border border-gray-100 overflow-hidden relative">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-[#8B0000]/5 to-transparent rounded-full -mr-10 -mt-10">
                    </div>
                    <div class="relative">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#6B0000] flex items-center justify-center shadow mb-3">
                            <i class="fa-solid fa-users text-white text-sm"></i>
                        </div>
                        <p class="text-[10px] uppercase tracking-wide text-gray-500 font-semibold">Total Users</p>
                        <p class="text-3xl font-extrabold text-gray-800">{{ $totalUsers }}</p>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-xl p-4 shadow border border-gray-100 overflow-hidden relative">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-green-500/5 to-transparent rounded-full -mr-10 -mt-10">
                    </div>
                    <div class="relative">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow mb-3">
                            <i class="fa-solid fa-circle-check text-white text-sm"></i>
                        </div>
                        <p class="text-[10px] uppercase tracking-wide text-gray-500 font-semibold">Active</p>
                        <p class="text-3xl font-extrabold text-gray-800">{{ $activeCount }}</p>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-xl p-4 shadow border border-gray-100 overflow-hidden relative">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-gray-400/5 to-transparent rounded-full -mr-10 -mt-10">
                    </div>
                    <div class="relative">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center shadow mb-3">
                            <i class="fa-solid fa-user-slash text-white text-sm"></i>
                        </div>
                        <p class="text-[10px] uppercase tracking-wide text-gray-500 font-semibold">Inactive</p>
                        <p class="text-3xl font-extrabold text-gray-800">{{ $inactiveCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden mb-6">
                <div class="px-4 sm:px-5 py-4 border-b bg-gray-50 flex flex-col gap-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-users-gear text-[#8B0000]"></i>
                        <h2 class="font-bold text-gray-800 text-sm">All System Users</h2>
                        <span
                            class="text-[10px] font-bold bg-[#8B0000] text-white px-2 py-0.5 rounded-full">{{ $totalUsers }}</span>
                    </div>

                    <form method="GET" action="{{ route('admin.user_management') }}"
                        class="flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-2 w-full sm:w-auto"
                        id="filterForm">
                        <div class="relative w-full sm:w-auto">
                            <i
                                class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="text" name="search" id="liveSearch" value="{{ request('search') }}"
                                placeholder="Search name or email…"
                                class="field-input pl-8 pr-8 py-2 text-xs border border-gray-200 rounded-lg bg-white w-full sm:w-52"
                                oninput="liveFilter(this.value)" autocomplete="off">
                            <button type="button" id="clearSearchBtn" onclick="clearLiveSearch()"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#8B0000] transition-colors"
                                style="display:{{ request('search') ? 'flex' : 'none' }}; align-items:center;">
                                <i class="fa-solid fa-xmark text-xs"></i>
                            </button>
                        </div>

                        <div class="flex gap-2 w-full sm:w-auto">
                            <select name="role"
                                class="field-input text-xs border border-gray-200 rounded-lg px-3 py-2 bg-white text-gray-600 cursor-pointer flex-1 sm:flex-none"
                                onchange="this.form.submit()">
                                <option value="">All Roles</option>
                                <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>
                                    Admin</option>
                                <option value="dentist" {{ request('role') === 'dentist' ? 'selected' : '' }}>Dentist
                                </option>
                                <option value="patient" {{ request('role') === 'patient' ? 'selected' : '' }}>Patient
                                </option>
                            </select>

                            <select name="status"
                                class="field-input text-xs border border-gray-200 rounded-lg px-3 py-2 bg-white text-gray-600 cursor-pointer flex-1 sm:flex-none"
                                onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>

                            @if (request()->hasAny(['search', 'role', 'status']))
                                <a href="{{ route('admin.user_management') }}"
                                    class="text-xs text-gray-400 hover:text-[#8B0000] font-semibold flex items-center gap-1 transition-colors whitespace-nowrap self-center">
                                    <i class="fa-solid fa-xmark"></i> Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr class="text-[10px] uppercase tracking-wide text-[#8B0000] font-bold">
                                <th class="py-3 px-3 sm:px-5 text-left w-12 hidden sm:table-cell">#</th>
                                <th class="py-3 px-4 text-left">User</th>
                                <th class="py-3 px-4 text-left">Role</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-left hidden lg:table-cell">Registered</th>
                                <th class="py-3 px-5 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="user-table-row border-b border-gray-50 last:border-0"
                                    data-name="{{ strtolower($user->name) }}"
                                    data-email="{{ strtolower($user->email) }}"
                                    data-role="{{ strtolower(optional($user->role)->name ?? '') }}">
                                    <td class="py-3.5 px-3 sm:px-5 hidden sm:table-cell">
                                        <span
                                            class="text-xs text-gray-400 font-medium">{{ $users->firstItem() + $loop->index }}</span>
                                    </td>

                                    <td class="py-3.5 px-3 sm:px-4">
                                        <div class="flex items-center gap-2 sm:gap-3">
                                            <div
                                                class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#b00000] flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-800 text-sm leading-tight">
                                                    {{ $user->name }}
                                                </div>
                                                <div class="text-[11px] text-gray-400 mt-0.5 hidden sm:block">
                                                    {{ $user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-3.5 px-4">
                                        @php $roleSlug = optional($user->role)->slug; @endphp
                                        <span class="badge-role"
                                            style="background:
        {{ $roleSlug === 'patient' ? '#dbeafe' : ($roleSlug === 'dentist' ? '#d1fae5' : '#fee2e2') }};
        color:
        {{ $roleSlug === 'patient' ? '#1d4ed8' : ($roleSlug === 'dentist' ? '#065f46' : '#8B0000') }};">
                                            {{ optional($user->role)->name ?? 'No Role' }}
                                        </span>
                                    </td>

                                    <td class="py-3.5 px-4 text-center">
                                        <span
                                            class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $user->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>

                                    <td class="py-3.5 px-4 hidden lg:table-cell">
                                        <span
                                            class="text-xs text-gray-400">{{ $user->created_at->format('M d, Y') }}</span>
                                    </td>

                                    <td class="py-3.5 px-2 sm:px-5">
                                        <div class="flex items-center justify-center gap-1">
                                            <button type="button"
                                                onclick="openEditModal(
                                            'users',
                                            {{ $user->id }},
                                            @js($user->name),
                                            @js($user->email),
                                            @js($user->role_id),
                                            @js($user->status)
                                          )"
                                                class="action-btn btn-edit" title="Edit account">
                                                <i class="fa-solid fa-pen text-[11px]"></i>
                                            </button>

                                            <form method="POST"
                                                action="{{ route('admin.user_management.toggle_status', $user->id) }}"
                                                style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="action-btn {{ $user->status === 'active' ? 'btn-toggle-on' : 'btn-toggle-off' }}"
                                                    title="{{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                                    <i
                                                        class="fa-solid {{ $user->status === 'active' ? 'fa-toggle-on' : 'fa-toggle-off' }} text-[11px]"></i>
                                                </button>
                                            </form>

                                            <button type="button"
                                                onclick="openResetModal('users', {{ $user->id }}, @js($user->name))"
                                                class="action-btn btn-reset" title="Reset password">
                                                <i class="fa-solid fa-key text-[11px]"></i>
                                            </button>

                                            <button type="button"
                                                onclick="openViewModal(
                                            @js($user->name),
                                            @js($user->email),
                                            @js(optional($user->role)->name ?? 'No Role'),
                                            @js(ucfirst($user->status)),
                                            'Users',
                                            @js($user->created_at ? $user->created_at->format('M d, Y h:i A') : 'N/A')
                                          )"
                                                class="action-btn" style="background:#f3f4f6;color:#374151;"
                                                title="View details">
                                                <i class="fa-solid fa-eye text-[11px]"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="dbEmptyRow">
                                    <td colspan="6" class="text-center py-14">
                                        <i class="fa-solid fa-users-slash text-5xl text-gray-300 mb-3 block"></i>
                                        <p class="text-gray-400 text-sm">No users found</p>
                                        @if (request()->hasAny(['search', 'role', 'status']))
                                            <a href="{{ route('admin.user_management') }}"
                                                class="text-xs text-[#8B0000] font-semibold hover:underline mt-2 inline-block">Clear
                                                filters</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                            <tr id="noResultsRow" style="display:none;">
                                <td colspan="6" class="text-center py-14">
                                    <i class="fa-solid fa-magnifying-glass text-4xl text-gray-300 mb-3 block"></i>
                                    <p class="text-gray-400 text-sm">No users found for "<span id="noResultsQuery"
                                            class="font-semibold text-gray-500"></span>"</p>
                                    <button type="button" onclick="clearLiveSearch()"
                                        class="text-xs text-[#8B0000] font-semibold hover:underline mt-2 inline-flex items-center gap-1">
                                        <i class="fa-solid fa-xmark"></i> Clear search
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div
                    class="px-4 sm:px-5 py-4 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-xs text-gray-500">
                        Showing <span class="font-semibold">{{ $users->firstItem() ?? 0 }}</span>–<span
                            class="font-semibold">{{ $users->lastItem() ?? 0 }}</span>
                        of <span class="font-semibold">{{ $users->total() }}</span> users
                    </p>
                    <div class="flex items-center gap-1.5">
                        @if ($users->onFirstPage())
                            <button class="page-btn" disabled><i
                                    class="fa-solid fa-chevron-left text-[10px]"></i></button>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="page-btn"><i
                                    class="fa-solid fa-chevron-left text-[10px]"></i></a>
                        @endif

                        @php
                            $start = max(1, $users->currentPage() - 2);
                            $end = min($users->lastPage(), $users->currentPage() + 2);
                        @endphp

                        @if ($start > 1)
                            <a href="{{ $users->url(1) }}" class="page-btn">1</a>
                            @if ($start > 2)
                                <span class="text-gray-400 text-xs px-1">…</span>
                            @endif
                        @endif

                        @for ($p = $start; $p <= $end; $p++)
                            <a href="{{ $users->url($p) }}"
                                class="page-btn {{ $p === $users->currentPage() ? 'active' : '' }}">{{ $p }}</a>
                        @endfor

                        @if ($end < $users->lastPage())
                            @if ($end < $users->lastPage() - 1)
                                <span class="text-gray-400 text-xs px-1">…</span>
                            @endif
                            <a href="{{ $users->url($users->lastPage()) }}"
                                class="page-btn">{{ $users->lastPage() }}</a>
                        @endif

                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="page-btn"><i
                                    class="fa-solid fa-chevron-right text-[10px]"></i></a>
                        @else
                            <button class="page-btn" disabled><i
                                    class="fa-solid fa-chevron-right text-[10px]"></i></button>
                        @endif
                    </div>
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

    <div class="modal-overlay" id="addModal" onclick="closeModalOutside(event,'addModal')">
        <div class="modal-box">
            <div
                class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#6B0000] flex items-center justify-center shadow">
                        <i class="fa-solid fa-user-plus text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-gray-800 text-base">Add New User</h3>
                        <p class="text-[10px] text-gray-500">Fill in the user's details below</p>
                    </div>
                </div>
                <button onclick="closeModal('addModal')"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.user_management.store') }}" class="p-6 space-y-4">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-xs text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-center gap-1.5"><i class="fa-solid fa-circle-xmark"></i>
                                {{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Full Name
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        placeholder="e.g. Juan dela Cruz"
                        class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm" required>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Email
                        Address <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i
                            class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="user@pup.edu.ph"
                            class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm"
                            required>
                    </div>
                </div>

                <div>
                    <label
                        class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Role</label>
                    <select name="role_id"
                        class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white">
                        <option value="">— No Role —</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Status
                        <span class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="active"
                                {{ old('status', 'active') === 'active' ? 'checked' : '' }}
                                style="accent-color:#8B0000;">
                            <span class="text-sm text-gray-700 font-medium">Active</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="inactive"
                                {{ old('status') === 'inactive' ? 'checked' : '' }}
                                style="accent-color:#8B0000;">
                            <span class="text-sm text-gray-700 font-medium">Inactive</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Password
                        <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="password" name="password" id="addPassword" placeholder="Min. 8 characters"
                            class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-10 py-2.5 text-sm"
                            required>
                        <button type="button" onclick="togglePassVis('addPassword','addEye')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fa-regular fa-eye text-xs" id="addEye"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Confirm
                        Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="password" name="password_confirmation" id="addPasswordConf"
                            placeholder="Repeat password"
                            class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-10 py-2.5 text-sm"
                            required>
                        <button type="button" onclick="togglePassVis('addPasswordConf','addEye2')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fa-regular fa-eye text-xs" id="addEye2"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('addModal')"
                        class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-[#8B0000] hover:bg-[#760000] text-white text-sm font-bold shadow transition-all flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Save User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="editModal" onclick="closeModalOutside(event,'editModal')">
        <div class="modal-box">
            <div
                class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow">
                        <i class="fa-solid fa-user-pen text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-gray-800 text-base">Edit User</h3>
                        <p class="text-[10px] text-gray-500" id="editModalSubtitle">Updating user details</p>
                    </div>
                </div>
                <button onclick="closeModal('editModal')"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form method="POST" id="editForm" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Full Name
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="editName" placeholder="Full name"
                        class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm" required>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Email
                        Address <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i
                            class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="email" name="email" id="editEmail" placeholder="user@pup.edu.ph"
                            class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm"
                            required>
                    </div>
                </div>

                <div>
                    <label
                        class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Role</label>
                    <select name="role_id" id="editRole"
                        class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white">
                        <option value="">— No Role —</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Status
                        <span class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" id="editStatusActive" value="active"
                                style="accent-color:#8B0000;">
                            <span class="text-sm text-gray-700 font-medium">Active</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" id="editStatusInactive" value="inactive"
                                style="accent-color:#8B0000;">
                            <span class="text-sm text-gray-700 font-medium">Inactive</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('editModal')"
                        class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold shadow transition-all flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Update User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div class="modal-overlay" id="resetModal" onclick="closeModalOutside(event,'resetModal')">
        <div class="modal-box modal-sm">
            <div
                class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow">
                        <i class="fa-solid fa-key text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-gray-800 text-base">Reset Password</h3>
                        <p class="text-[10px] text-gray-500" id="resetModalSubtitle">Set a new password</p>
                    </div>
                </div>
                <button onclick="closeModal('resetModal')"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>



            <form method="POST" id="resetForm" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">New
                        Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="password" name="password" id="resetPassword" placeholder="Min. 8 characters"
                            class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-10 py-2.5 text-sm"
                            required>
                        <button type="button" onclick="togglePassVis('resetPassword','resetEye')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fa-regular fa-eye text-xs" id="resetEye"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Confirm
                        Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="password" name="password_confirmation" id="resetPasswordConf"
                            placeholder="Repeat password"
                            class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-10 py-2.5 text-sm"
                            required>
                        <button type="button" onclick="togglePassVis('resetPasswordConf','resetEye2')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fa-regular fa-eye text-xs" id="resetEye2"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('resetModal')"
                        class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold shadow transition-all flex items-center gap-2">
                        <i class="fa-solid fa-key"></i> Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- View Details Modal -->
    <div class="modal-overlay" id="viewModal" onclick="closeModalOutside(event,'viewModal')">
        <div class="modal-box modal-sm">
            <div
                class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center shadow">
                        <i class="fa-solid fa-eye text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-gray-800 text-base">Account Details</h3>
                        <p class="text-[10px] text-gray-500">View selected account information</p>
                    </div>
                </div>
                <button onclick="closeModal('viewModal')"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="p-6 space-y-4 text-sm">
                <div>
                    <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Name</div>
                    <div id="viewName" class="text-gray-800 font-semibold mt-1"></div>
                </div>

                <div>
                    <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Email</div>
                    <div id="viewEmail" class="text-gray-800 mt-1"></div>
                </div>

                <div>
                    <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Role</div>
                    <div id="viewRole" class="text-gray-800 mt-1"></div>
                </div>

                <div>
                    <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Status</div>
                    <div id="viewStatus" class="text-gray-800 mt-1"></div>
                </div>

                <div>
                    <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Source</div>
                    <div id="viewSource" class="text-gray-800 mt-1"></div>
                </div>

                <div>
                    <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Created At</div>
                    <div id="viewCreatedAt" class="text-gray-800 mt-1"></div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="button" onclick="closeModal('viewModal')"
                        class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('currentDate').textContent = new Date().toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

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
                o.addEventListener('click', e => {
                    e.stopPropagation();
                    applyTheme(o.getAttribute('data-theme'));
                })
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
            setTimeout(() => {
                overlay.style.display = 'none';
            }, 250);
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
            const ind = document.querySelector('.theme-indicator');
            if (ind) theme === 'dark' ? ind.classList.add('dark-mode') : ind.classList.remove('dark-mode');
        }
        document.addEventListener('DOMContentLoaded', () => {
            applyTheme(localStorage.getItem('theme') || 'light');
            document.querySelectorAll('.theme-option').forEach(o =>
                o.addEventListener('click', e => {
                    e.stopPropagation();
                    applyTheme(o.getAttribute('data-theme'));
                })
            );
        });

        function openModal(id) {
            document.getElementById(id).classList.add('open');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }

        function closeModalOutside(e, id) {
            if (e.target.id === id) closeModal(id);
        }

        @if ($errors->any() && old('_method') !== 'PUT')
            document.addEventListener('DOMContentLoaded', () => openModal('addModal'));
        @endif

        function openEditModal(source, id, name, email, roleId, status) {
            const form = document.getElementById('editForm');

            if (source === 'patients') {
                form.action = `/admin/user-management/patient/${id}`;
                document.getElementById('editRole').disabled = true;
                document.getElementById('editStatusActive').disabled = true;
                document.getElementById('editStatusInactive').disabled = true;
            } else {
                form.action = `/admin/user-management/${id}`;
                document.getElementById('editRole').disabled = false;
                document.getElementById('editStatusActive').disabled = false;
                document.getElementById('editStatusInactive').disabled = false;
            }

            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('editModalSubtitle').textContent = 'Editing: ' + name;

            const roleSelect = document.getElementById('editRole');
            roleSelect.value = roleId || '';

            document.getElementById('editStatusActive').checked = (status === 'active');
            document.getElementById('editStatusInactive').checked = (status === 'inactive');

            openModal('editModal');
        }

        function openResetModal(source, id, name) {
            if (source === 'patients') {
                document.getElementById('resetForm').action = `/admin/user-management/patient/${id}/reset-password`;
            } else {
                document.getElementById('resetForm').action = `/admin/user-management/${id}/reset-password`;
            }

            document.getElementById('resetModalSubtitle').textContent = 'Resetting password for: ' + name;
            document.getElementById('resetPassword').value = '';
            document.getElementById('resetPasswordConf').value = '';
            openModal('resetModal');
        }

        function openViewModal(name, email, role, status, source, createdAt) {
            document.getElementById('viewName').textContent = name;
            document.getElementById('viewEmail').textContent = email;
            document.getElementById('viewRole').textContent = role;
            document.getElementById('viewStatus').textContent = status;
            document.getElementById('viewSource').textContent = source;
            document.getElementById('viewCreatedAt').textContent = createdAt;

            openModal('viewModal');
        }

        function togglePassVis(inputId, iconId) {
            const inp = document.getElementById(inputId);
            const ico = document.getElementById(iconId);
            if (inp.type === 'password') {
                inp.type = 'text';
                ico.className = 'fa-regular fa-eye-slash text-xs';
            } else {
                inp.type = 'password';
                ico.className = 'fa-regular fa-eye text-xs';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            applyTheme(localStorage.getItem('theme') || 'light');
            document.querySelectorAll('.theme-option').forEach(o =>
                o.addEventListener('click', e => {
                    e.stopPropagation();
                    applyTheme(o.getAttribute('data-theme'));
                })
            );

            document.querySelectorAll('.flash-alert').forEach(el => {
                setTimeout(() => {
                    el.style.transition = 'opacity .4s';
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 400);
                }, 4000);
            });
        });

        // ── LIVE SEARCH ──
        function liveFilter(query) {
            const q = query.toLowerCase().trim();
            const rows = document.querySelectorAll('.user-table-row');
            const clearBtn = document.getElementById('clearSearchBtn');
            const noResultsRow = document.getElementById('noResultsRow');
            const noResultsQuery = document.getElementById('noResultsQuery');
            const dbEmptyRow = document.getElementById('dbEmptyRow');

            clearBtn.style.display = q ? 'flex' : 'none';

            if (rows.length === 0) {
                if (dbEmptyRow) dbEmptyRow.style.display = q ? 'none' : '';
                if (noResultsRow) {
                    noResultsRow.style.display = q ? '' : 'none';
                    if (noResultsQuery) noResultsQuery.textContent = query;
                }
                return;
            }

            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.dataset.name || '';
                const email = row.dataset.email || '';
                const role = row.dataset.role || '';
                const matches = !q || name.includes(q) || email.includes(q) || role.includes(q);
                row.style.display = matches ? '' : 'none';
                if (matches) visibleCount++;
            });

            if (noResultsRow) {
                noResultsRow.style.display = (visibleCount === 0 && q) ? '' : 'none';
                if (noResultsQuery) noResultsQuery.textContent = query;
            }
        }

        function clearLiveSearch() {
            const input = document.getElementById('liveSearch');
            if (!input) return;
            input.value = '';
            liveFilter('');
            input.focus();
        }

        // Run on page load in case search value was pre-filled from URL
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('liveSearch');
            if (input && input.value.trim()) {
                liveFilter(input.value);
            }
        });
    </script>

</body>

</html>
