<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <title>Service Types | PUP Taguig Dental Clinic</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = { daisyui: { themes: false } }
    </script>

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        :root {
            --crimson: #8B0000;
            --crimson-dark: #6b0000;
            --crimson-light: #fef2f2;
            --header-h: 64px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F8F6F3;
            color: #2D2420;
            margin: 0;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #D1C9C0;
            border-radius: 10px;
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

        /* ── SIDEBAR ── */
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
            margin-left: 240px;
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

        /* ══════════════════════════════════════
           SERVICE TYPES PAGE STYLES
        ══════════════════════════════════════ */

        .st-card {
            background: #fff;
            border: 1.5px solid #EDE8E2;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .04);
        }

        .st-add-bar {
            padding: 18px 24px;
            background: #FDFCFB;
            border-bottom: 1px solid #F0EBE6;
        }

        .st-input-wrap {
            position: relative;
            flex: 1;
        }

        .st-input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #B5A99A;
            font-size: 13px;
            pointer-events: none;
        }

        .st-input {
            width: 100%;
            height: 44px;
            padding: 0 16px 0 38px;
            border: 1.5px solid #EDE8E2;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            background: #fff;
            color: #2D2420;
            outline: none;
            transition: border-color .18s, box-shadow .18s;
        }

        .st-input::placeholder {
            color: #C4B8AF;
        }

        .st-input:focus {
            border-color: #7B0D0D;
            box-shadow: 0 0 0 3px rgba(123, 13, 13, .08);
        }

        .btn-add-service {
            height: 44px;
            padding: 0 22px;
            background: linear-gradient(135deg, #7B0D0D, #9B1515);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(123, 13, 13, .25);
            transition: all .2s;
        }

        .btn-add-service:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(123, 13, 13, .35);
        }

        .btn-add-service:active {
            transform: translateY(0);
        }

        .st-field-error {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #DC2626;
        }

        /* Table header */
        .st-table-head {
            display: grid;
            grid-template-columns: 68px 1fr auto;
            gap: 16px;
            padding: 10px 24px;
            background: #F8F5F2;
            border-bottom: 1px solid #EDE8E2;
        }

        .st-col-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #B5A99A;
        }

        /* Rows */
        .st-row {
            display: grid;
            grid-template-columns: 68px 1fr auto;
            align-items: center;
            gap: 16px;
            padding: 14px 24px;
            border-bottom: 1px solid #F5F0EB;
            transition: background .15s;
            animation: stRowIn .3s ease both;
        }

        .st-row:last-child {
            border-bottom: none;
        }

        .st-row:hover {
            background: #FBF8F5;
        }

        @keyframes stRowIn {
            from {
                opacity: 0;
                transform: translateX(-6px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .st-id-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 26px;
            padding: 0 10px;
            background: #F5EFE9;
            color: #8A7A6F;
            border: 1px solid #EDE8E2;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .02em;
        }

        .st-service-cell {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .st-service-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            flex-shrink: 0;
            background: #7B0D0D12;
            border: 1px solid #7B0D0D22;
            color: #7B0D0D;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .btn-delete-service {
            height: 34px;
            padding: 0 14px;
            background: #FEF2F2;
            color: #DC2626;
            border: 1.5px solid #FECACA;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all .18s;
            white-space: nowrap;
        }

        .btn-delete-service:hover {
            background: #DC2626;
            color: #fff;
            border-color: #DC2626;
            box-shadow: 0 3px 10px rgba(220, 38, 38, .3);
        }

        /* Empty state */
        .st-empty {
            padding: 64px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .st-empty-icon {
            width: 56px;
            height: 56px;
            background: #F5EFE9;
            border: 1.5px solid #EDE8E2;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #C4B8AF;
            margin-bottom: 6px;
        }

        /* Count pill */
        .st-count-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #7B0D0D12;
            color: #7B0D0D;
            border: 1px solid #7B0D0D25;
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 12px;
            font-weight: 700;
        }

        /* Alerts */
        .st-alert {
            border-radius: 12px;
            padding: 12px 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 600;
        }

        .st-alert-success {
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            color: #166534;
        }

        .st-alert-error {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #991B1B;
        }

        /* Dark mode overrides */
        [data-theme="dark"] .st-card {
            background: #161b22;
            border-color: #21262d;
        }

        [data-theme="dark"] .st-add-bar {
            background: #0d1117;
            border-color: #21262d;
        }

        [data-theme="dark"] .st-input {
            background: #0d1117;
            border-color: #21262d;
            color: #E5E7EB;
        }

        [data-theme="dark"] .st-input:focus {
            border-color: #9B1515;
            box-shadow: 0 0 0 3px rgba(155, 21, 21, .15);
        }

        [data-theme="dark"] .st-table-head {
            background: #0d1117;
            border-color: #21262d;
        }

        [data-theme="dark"] .st-row {
            border-color: #1c2128;
        }

        [data-theme="dark"] .st-row:hover {
            background: #1c2128;
        }

        [data-theme="dark"] .st-id-badge {
            background: #1c2128;
            border-color: #21262d;
            color: #8A9AB0;
        }

        [data-theme="dark"] .st-service-cell span {
            color: #E5E7EB;
        }

        [data-theme="dark"] .st-service-icon {
            background: rgba(155, 21, 21, .15);
            border-color: rgba(155, 21, 21, .3);
            color: #ff6b6b;
        }

        [data-theme="dark"] .st-empty-icon {
            background: #0d1117;
            border-color: #21262d;
            color: #374151;
        }

        [data-theme="dark"] .st-empty p:first-of-type {
            color: #E5E7EB;
        }

        @media (max-width:767px) {
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

            .st-add-bar .flex {
                flex-direction: column;
            }

            .btn-add-service {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

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

    <!-- ════════════ MOBILE DRAWER OVERLAY ════════════ -->
    <div id="mobileDrawerOverlay" onclick="closeDrawer()"></div>

    <!-- ════════════ MOBILE DRAWER ════════════ -->
    <div id="mobileDrawer">

        <!-- Header -->
        <div class="drawer-header">
            <div class="drawer-header-left">
                <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="drawer-logo" alt="DMS">
                <div>
                    <div class="drawer-title">PUP TAGUIG</div>
                    <div class="drawer-subtitle">Dental Clinic</div>
                </div>
            </div>
            <button class="drawer-close" onclick="closeDrawer()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- User strip -->
        <div class="drawer-user">
            <img src="https://i.pravatar.cc/40" class="drawer-avatar" alt="Avatar">
            <div>
                <div class="drawer-user-name">Admin</div>
                <div class="drawer-user-role">Administrator</div>
            </div>
        </div>

        <!-- Nav -->
        <div class="drawer-inner">

            <div class="drawer-group">
                <div class="drawer-group-header">
                    <div class="drawer-group-icon"><i class="fa-solid fa-hospital"></i></div>
                    <span class="drawer-group-label">Clinic Management</span>
                </div>
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
                <div class="drawer-group-header">
                    <div class="drawer-group-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                    <span class="drawer-group-label">Maintenance</span>
                </div>
                <a href="{{ route('admin.user_management') }}"
                    class="drawer-link {{ request()->routeIs('admin.user_management*') ? 'active' : '' }}"><i
                        class="fa-solid fa-user-gear"></i> User Management</a>
                <a href="{{ route('admin.role_permissions') }}"
                    class="drawer-link {{ request()->routeIs('admin.role_permissions') ? 'active' : '' }}"><i
                        class="fa-solid fa-user-shield"></i> Roles &amp; Permissions</a>
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
                <div class="drawer-group-header">
                    <div class="drawer-group-icon"><i class="fa-solid fa-server"></i></div>
                    <span class="drawer-group-label">System</span>
                </div>
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

        <!-- Bottom: theme + logout -->
        <div class="drawer-bottom">
            <div style="margin-bottom:10px;">
                <div class="theme-toggle-container" id="drawerThemeToggle">
                    <button type="button" class="theme-option active" data-theme="light"><i
                            class="fa-solid fa-sun"></i></button>
                    <button type="button" class="theme-option" data-theme="dark"><i
                            class="fa-regular fa-moon"></i></button>
                    <div class="theme-indicator" aria-hidden="true"></div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn" style="font-size:.8rem;">
                    <span
                        style="width:28px;height:28px;background:#fef2f2;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa-solid fa-right-from-bracket text-xs"></i>
                    </span>
                    <span class="font-semibold">Log out</span>
                </button>
            </form>
        </div>
    </div>

    <!-- ════════════ MAIN CONTENT ════════════ -->
    <main id="mainContent" class="px-4 sm:px-6 pt-[82px] pb-8 min-h-screen">
        <div style="max-width:760px; margin:0 auto;">

            @if(session('success'))
            <div class="st-alert st-alert-success">
                <i class="fa-solid fa-circle-check" style="color:#22C55E;font-size:16px;flex-shrink:0;"></i>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="st-alert st-alert-error">
                <i class="fa-solid fa-circle-xmark" style="color:#DC2626;font-size:16px;flex-shrink:0;"></i>
                {{ session('error') }}
            </div>
            @endif

            <!-- Page title -->
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-7">
                <div>
                    <div
                        style="font-size:11px;color:#B5A99A;letter-spacing:2px;text-transform:uppercase;margin-bottom:6px;font-weight:600;">
                        Maintenance
                    </div>
                    <h1 style="margin:0;font-size:26px;font-weight:800;color:#7B0D0D;line-height:1;">
                        Service Types
                    </h1>
                    <p style="margin:8px 0 0;font-size:14px;color:#8A7A6F;">
                        Manage the categories of dental services offered at the clinic.
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <span class="st-count-pill">
                        <i class="fa-solid fa-layer-group" style="font-size:11px;"></i>
                        {{ $services->count() }} {{ Str::plural('Service', $services->count()) }}
                    </span>
                </div>
            </div>

            <!-- Main card -->
            <div class="st-card">

                <!-- Add form -->
                <div class="st-add-bar">
                    <form method="POST" action="{{ route('admin.service-types.store') }}">
                        @csrf

                        <div class="flex flex-col gap-3">
                            <div class="flex gap-3 items-center">
                                <div class="st-input-wrap">
                                    <i class="fa-solid fa-tag st-input-icon"></i>
                                    <input type="text" name="name" placeholder="Enter new service type name…" required
                                        autocomplete="off" value="{{ old('name') }}" class="st-input">
                                </div>

                                <button type="submit" class="btn-add-service">
                                    <i class="fa-solid fa-plus" style="font-size:12px;"></i>
                                    Add Service
                                </button>
                            </div>

                            <div>
                                <textarea name="description" placeholder="Enter service description…" class="st-input"
                                    style="height:90px; padding:12px 16px; resize:none;">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        @error('name')
                        <div class="st-field-error">
                            <i class="fa-solid fa-circle-exclamation" style="font-size:11px;"></i>
                            {{ $message }}
                        </div>
                        @enderror

                        @error('description')
                        <div class="st-field-error">
                            <i class="fa-solid fa-circle-exclamation" style="font-size:11px;"></i>
                            {{ $message }}
                        </div>
                        @enderror
                    </form>

                </div>

                <!-- Column headers -->
                <div class="st-table-head" style="grid-template-columns: 68px 1fr 1.3fr auto;">
                    <span class="st-col-label">ID</span>
                    <span class="st-col-label">Service Name</span>
                    <span class="st-col-label">Description</span>
                    <span class="st-col-label">Action</span>
                </div>

                <!-- Service rows -->
                <div>
                    @forelse($services as $i => $service)
                    <div class="st-row"
                        style="grid-template-columns: 68px 1fr 1.3fr auto; animation-delay: {{ $i * 45 }}ms;">

                        <div>
                            <span class="st-id-badge">#{{ $service->id }}</span>
                        </div>

                        <div class="st-service-cell">
                            <div class="st-service-icon">
                                <i class="fa-solid fa-tooth"></i>
                            </div>
                            <span style="font-weight:600; font-size:14px; color:#2D2420;">
                                {{ $service->name }}
                            </span>
                        </div>

                        <div style="font-size:13px; color:#8A7A6F; line-height:1.45;">
                            {{ $service->description ?: 'No description provided.' }}
                        </div>

                        <div>
                            <form method="POST" action="{{ route('admin.service-types.destroy', $service->id) }}"
                                onsubmit="return confirm('Delete \'{{ addslashes($service->name) }}\'? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete-service">
                                    <i class="fa-solid fa-trash-can" style="font-size:11px;"></i>
                                    Delete
                                </button>
                            </form>
                        </div>

                    </div>
                    @empty
                    <div class="st-empty">
                        <div class="st-empty-icon">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <p style="margin:0;font-size:15px;font-weight:700;color:#2D2420;">No service types yet</p>
                        <p style="margin:0;font-size:13px;color:#8A7A6F;text-align:center;max-width:260px;">
                            Add your first service type using the form above to get started.
                        </p>
                    </div>
                    @endforelse
                </div>

            </div>{{-- end .st-card --}}

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
            const ind = document.querySelector('.theme-indicator');
            if (ind) theme === 'dark' ? ind.classList.add('dark-mode') : ind.classList.remove('dark-mode');
        }
        document.addEventListener('DOMContentLoaded', () => {
            applyTheme(localStorage.getItem('theme') || 'light');
            document.querySelectorAll('.theme-option').forEach(o =>
                o.addEventListener('click', e => { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); })
            );
        });
    </script>

</body>

</html>