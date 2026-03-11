<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>System Logs | PUP Taguig Dental Clinic</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
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

        /* ── HEADER ── */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            background: linear-gradient(135deg, #6b0000 0%, #8B0000 100%);
            padding: 0 2rem;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 20px rgba(139, 0, 0, .25);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .header-logo {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }

        .header-title {
            font-size: .95rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: .01em;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .notif-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .12);
            border: none;
            cursor: pointer;
            color: #fff;
            font-size: .95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .15s;
            position: relative;
        }

        .notif-btn:hover {
            background: rgba(255, 255, 255, .22);
        }

        .notif-badge {
            position: absolute;
            top: -3px;
            right: -3px;
            background: #ff6b6b;
            color: #fff;
            font-size: .6rem;
            font-weight: 700;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #8B0000;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .header-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, .4);
            object-fit: cover;
        }

        .header-name {
            font-size: .82rem;
            font-weight: 600;
            color: #fff;
            line-height: 1.2;
        }

        .header-role {
            font-size: .7rem;
            color: rgba(255, 255, 255, .7);
            font-style: italic;
        }

        #notifMenu {
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            width: 300px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .12);
            border: 1px solid #f0e6e6;
            opacity: 0;
            transform: scale(.95) translateY(-6px);
            pointer-events: none;
            transition: all .2s;
            transform-origin: top right;
            z-index: 100;
        }

        #notifMenu.open {
            opacity: 1;
            transform: scale(1) translateY(0);
            pointer-events: auto;
        }

        #notifDropdown {
            position: relative;
        }

        /* ── SIDEBAR ── */
        #sidebar {
            position: fixed;
            left: 0;
            top: 62px;
            width: 240px;
            height: calc(100vh - 62px);
            background: #fff;
            box-shadow: 2px 0 20px rgba(0, 0, 0, .07);
            z-index: 40;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar-inner {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 12px 0 6px;
        }

        .sidebar-inner::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-inner::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 4px;
        }

        /* Group header — static, not clickable for collapse */
        .nav-group {
            margin: 0 8px 2px;
        }

        .group-header {
            display: flex;
            align-items: center;
            padding: 7px 8px 5px;
            color: #6b7280;
        }

        .group-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }

        .group-header.active-group .group-icon {
            background: #8B0000;
            color: #fff;
            box-shadow: 0 4px 12px rgba(139, 0, 0, .3);
        }

        .group-label-wrap {
            flex: 1;
            text-align: left;
            overflow: hidden;
            margin-left: 10px;
        }

        .group-label {
            font-size: .72rem;
            font-weight: 700;
            white-space: nowrap;
            line-height: 1.2;
            display: block;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .group-sublabel {
            font-size: .62rem;
            color: #b0b8c4;
            white-space: nowrap;
            display: block;
            margin-top: 1px;
        }

        /* Group body always visible */
        .group-body {
            padding-bottom: 4px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 10px 7px 44px;
            border-radius: 8px;
            margin: 1px 4px;
            font-size: .77rem;
            font-weight: 500;
            color: #6b7280;
            text-decoration: none;
            transition: all .15s;
            white-space: nowrap;
        }

        .nav-link:hover {
            background: #fef2f2;
            color: #8B0000;
            padding-left: 48px;
        }

        .nav-link.active {
            background: #8B0000;
            color: #fff;
            box-shadow: 0 2px 8px rgba(139, 0, 0, .25);
        }

        .nav-link.active:hover {
            padding-left: 44px;
            background: #8B0000;
        }

        .nav-link i {
            width: 16px;
            text-align: center;
            font-size: 12px;
        }

        .nav-sep {
            height: 1px;
            background: #f3f4f6;
            margin: 8px 12px;
        }

        .sidebar-bottom {
            padding: 8px 8px 12px;
            border-top: 1px solid #f3f4f6;
            flex-shrink: 0;
        }

        .theme-toggle-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: 34px;
            background: #F5F5F5;
            border: 1px solid #E0E0E0;
            border-radius: 24px;
        }

        .theme-option {
            position: relative;
            z-index: 2;
            flex: 1;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            cursor: pointer;
            color: #9CA3AF;
            transition: color .2s ease;
            border-radius: 8px;
        }

        .theme-option i {
            font-size: 16px;
        }

        .theme-option.active {
            color: #374151;
        }

        .theme-indicator {
            position: absolute;
            background: white;
            border-radius: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
            transition: all .3s cubic-bezier(.4, 0, .2, 1);
            pointer-events: none;
            width: calc(50% - 4px);
            height: calc(100% - 8px);
            left: 4px;
            top: 4px;
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
            font-size: .77rem;
            font-weight: 600;
            transition: background .15s;
        }

        .logout-btn:hover {
            background: #fef2f2;
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

        /* ── MOBILE BOTTOM NAV ── */
        #adminMobileNav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 68px;
            background: #fff;
            border-top: 1px solid #f0e0e0;
            z-index: 200;
            align-items: center;
            justify-content: space-around;
            box-shadow: 0 -4px 20px rgba(139, 0, 0, .10);
        }

        .adm-mob-item {
            flex: 1;
            height: 68px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            font-size: 9.5px;
            font-weight: 600;
            color: #9ca3af;
            text-decoration: none;
            transition: color .2s;
            position: relative;
            cursor: pointer;
            border: none;
            background: none;
            padding: 0;
        }

        .adm-mob-item.active {
            color: #8B0000;
        }

        .adm-mob-item i {
            font-size: 20px;
        }

        .adm-mob-item.active i {
            filter: drop-shadow(0 0 6px rgba(139, 0, 0, .35));
        }

        /* FAB center button */
        #admMobFabWrap {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #admMobFab {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8B0000, #660000);
            color: white;
            border: none;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(139, 0, 0, .45);
            cursor: pointer;
            transition: transform .25s cubic-bezier(.34, 1.56, .64, 1);
            position: relative;
            top: -10px;
        }

        #admMobFab.open {
            transform: rotate(45deg) translateY(-10px);
        }

        /* FAB menu (quick nav) */
        #admMobFabMenu {
            position: fixed;
            bottom: 86px;
            left: 50%;
            transform: translateX(-50%) scaleY(0);
            transform-origin: bottom center;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(139, 0, 0, .18);
            border: 1px solid #f5e8e8;
            min-width: 220px;
            overflow: hidden;
            transition: transform .25s cubic-bezier(.34, 1.56, .64, 1), opacity .2s;
            opacity: 0;
            pointer-events: none;
            z-index: 300;
        }

        #admMobFabMenu.open {
            transform: translateX(-50%) scaleY(1);
            opacity: 1;
            pointer-events: auto;
        }

        .adm-fab-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 18px;
            font-size: 13.5px;
            font-weight: 600;
            color: #333;
            text-decoration: none;
            transition: background .15s;
            border-bottom: 1px solid #fdf5f5;
        }

        .adm-fab-item:last-child {
            border-bottom: none;
        }

        .adm-fab-item:hover {
            background: #fff0f0;
            color: #8B0000;
        }

        .adm-fab-item .adm-fab-icon {
            width: 32px;
            height: 32px;
            background: #fef2f2;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #8B0000;
            flex-shrink: 0;
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
                margin-bottom: 68px;
            }

            #adminMobileNav {
                display: flex;
            }

            .header {
                padding: 0 1rem;
            }

            .header-title {
                display: none;
            }

            .sl-stats {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 0.65rem;
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

        @media (min-width: 768px) {
            #adminMobileNav {
                display: none !important;
            }
        }

        /* ── DARK MOBILE ── */
        [data-theme="dark"] #adminMobileNav {
            background: #0a0a0a;
            border-top-color: #1a1a1a;
        }

        [data-theme="dark"] #admMobFabMenu {
            background: #111;
            border-color: #222;
        }

        [data-theme="dark"] .adm-fab-item {
            color: #E5E7EB;
            border-bottom-color: #1a1a1a;
        }

        [data-theme="dark"] .adm-fab-item:hover {
            background: #1a1a1a;
        }

        [data-theme="dark"] .adm-mob-item {
            color: #4b5563;
        }

        [data-theme="dark"] .adm-mob-item.active {
            color: #ff6b6b;
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
            color: #6b7280;
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
            color: #6b7280;
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
            color: #9ca3af;
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
            color: #6b7280;
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
            color: #6b7280;
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
    </style>
</head>

<body class="bg-[#f5f5f5] text-[#333333] min-h-screen">

    <!-- ════════════ HEADER ════════════ -->
    <header class="header">
        <div class="header-left">
            <img src="{{ asset('images/PUP.png') }}" class="header-logo" alt="PUP">
            <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="header-logo" alt="DMS">
            <span class="header-title">PUP TAGUIG DENTAL CLINIC</span>
        </div>
        <div class="header-right">
            @php $notifications = collect($notifications ?? []); $notifCount = $notifications->count(); @endphp
            <div id="notifDropdown">
                <button class="notif-btn" id="notifBtn">
                    <i class="fa-regular fa-bell"></i>
                    @if($notifCount > 0)<span class="notif-badge">{{ $notifCount }}</span>@endif
                </button>
                <div id="notifMenu">
                    <div
                        style="padding:.85rem 1rem .65rem; font-weight:700; color:#8B0000; font-size:.82rem; border-bottom:1px solid #f5e8e8;">
                        Notifications</div>
                    <div style="max-height:260px; overflow-y:auto;">
                        @forelse($notifications as $n)
                        <a href="{{ $n['url'] ?? '#' }}"
                            style="display:block; padding:.65rem 1rem; font-size:.78rem; color:#333; text-decoration:none; border-bottom:1px solid #fdf5f5;">
                            <div style="font-weight:600;">{{ $n['title'] ?? 'Notification' }}</div>
                            @if(!empty($n['message']))<div style="color:#aaa; margin-top:2px;">{{ $n['message'] }}</div>
                            @endif
                        </a>
                        @empty
                        <div style="padding:2rem 1rem; text-align:center; color:#bbb; font-size:.78rem;">You're all
                            caught up.</div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="header-user">
                <img src="https://i.pravatar.cc/40" class="header-avatar" alt="Avatar">
                <div>
                    <div class="header-name">Admin</div>
                    <div class="header-role">Admin</div>
                </div>
            </div>
        </div>
    </header>

    <!-- ════════════ SIDEBAR ════════════ -->
    <aside id="sidebar">
        <div class="sidebar-inner">

            <!-- GROUP 1 — CLINIC MANAGEMENT -->
            <div class="nav-group" id="group-cms">
                <div class="group-header {{ request()->routeIs('admin.admin.dashboard') ? 'active-group' : '' }}">
                    <div class="group-icon"><i class="fa-solid fa-hospital"></i></div>
                    <div class="group-label-wrap">
                        <span class="group-label">Clinic Management</span>
                        <span class="group-sublabel">Core clinical modules</span>
                    </div>
                </div>
                <div class="group-body">
                    <a href="{{ route('admin.admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.admin.dashboard') ? 'active' : '' }}"><i
                            class="fa-solid fa-chart-line"></i> Dashboard</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
                            class="fa-solid fa-users"></i> Patients</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
                            class="fa-solid fa-calendar-check"></i> Appointments</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
                            class="fa-solid fa-tooth"></i> Dental Records</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
                            class="fa-solid fa-file-circle-check"></i> Document Request</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
                            class="fa-solid fa-file"></i> Reports</a>
                </div>
            </div>

            <div class="nav-sep"></div>

            <!-- GROUP 2 — MAINTENANCE -->
            <div class="nav-group" id="group-mnt">
                <div
                    class="group-header {{ request()->routeIs('admin.user_management*','admin.role_permissions','admin.academic_periods*') ? 'active-group' : '' }}">
                    <div class="group-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                    <div class="group-label-wrap">
                        <span class="group-label">Maintenance</span>
                        <span class="group-sublabel">Configuration &amp; scheduling</span>
                    </div>
                </div>
                <div class="group-body">
                    <a href="{{ route('admin.user_management') }}"
                        class="nav-link {{ request()->routeIs('admin.user_management*') ? 'active' : '' }}"><i
                            class="fa-solid fa-user-gear"></i> User Management</a>
                    <a href="{{ route('admin.role_permissions') }}"
                        class="nav-link {{ request()->routeIs('admin.role_permissions') ? 'active' : '' }}"><i
                            class="fa-solid fa-user-shield"></i> Roles &amp; Permissions</a>
                    <a href="{{ route('admin.academic_periods') }}"
                        class="nav-link {{ request()->routeIs('admin.academic_periods*') ? 'active' : '' }}"><i
                            class="fa-solid fa-school"></i> Academic Periods</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
                            class="fa-solid fa-calendar-days"></i> Clinic Schedule</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
                            class="fa-solid fa-list-check"></i> Service Types</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
                            class="fa-solid fa-file-pen"></i> Document Templates</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
                            class="fa-solid fa-boxes-stacked"></i> Inventory</a>
                </div>
            </div>

            <div class="nav-sep"></div>

            <!-- GROUP 3 — SYSTEM -->
            <div class="nav-group" id="group-sys">
                <div class="group-header {{ request()->routeIs('admin.system_logs') ? 'active-group' : '' }}">
                    <div class="group-icon"><i class="fa-solid fa-server"></i></div>
                    <div class="group-label-wrap">
                        <span class="group-label">System</span>
                        <span class="group-sublabel">Admin &amp; configuration</span>
                    </div>
                </div>
                <div class="group-body">
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
                            class="fa-solid fa-database"></i> Data Backup</a>
                    <a href="{{ route('admin.system_logs') }}"
                        class="nav-link {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}"><i
                            class="fa-solid fa-clipboard-list"></i> System Logs</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
                            class="fa-solid fa-sliders"></i> System Settings</a>
                </div>
            </div>

        </div><!-- /sidebar-inner -->

        <div class="sidebar-bottom">
            <div class="text-[.65rem] font-semibold tracking-widest text-gray-400 uppercase mb-2 px-1">Settings</div>
            <div class="w-full px-1 mb-3">
                <div id="themeToggle" class="theme-toggle-container">
                    <button type="button" class="theme-option active" data-theme="light"><i
                            class="fa-solid fa-sun"></i></button>
                    <button type="button" class="theme-option" data-theme="dark"><i
                            class="fa-regular fa-moon"></i></button>
                    <div class="theme-indicator" aria-hidden="true"></div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <span
                        style="width:30px;height:30px;background:#fef2f2;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa-solid fa-right-from-bracket text-sm"></i>
                    </span>
                    <span class="font-semibold">Log out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ════════════ MOBILE BOTTOM NAV ════════════ -->
    <nav id="adminMobileNav">
        {{-- Dashboard --}}
        <a href="{{ route('admin.admin.dashboard') }}"
            class="adm-mob-item {{ request()->routeIs('admin.admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-line"></i>
            <span>Dashboard</span>
        </a>

        {{-- Patients --}}
        <a href="{{ route('admin.admin.dashboard') }}" class="adm-mob-item {{ false ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i>
            <span>Patients</span>
        </a>

        {{-- FAB — Quick Actions --}}
        <div id="admMobFabWrap">
            <div id="admMobFabMenu">
                <a href="{{ route('admin.admin.dashboard') }}" class="adm-fab-item">
                    <span class="adm-fab-icon"><i class="fa-solid fa-calendar-check"></i></span>
                    Appointments
                </a>
                <a href="{{ route('admin.system_logs') }}" class="adm-fab-item">
                    <span class="adm-fab-icon"><i class="fa-solid fa-clipboard-list"></i></span>
                    System Logs
                </a>
                <a href="{{ route('admin.user_management') }}" class="adm-fab-item">
                    <span class="adm-fab-icon"><i class="fa-solid fa-user-gear"></i></span>
                    User Management
                </a>
                <a href="{{ route('admin.role_permissions') }}" class="adm-fab-item">
                    <span class="adm-fab-icon"><i class="fa-solid fa-user-shield"></i></span>
                    Roles &amp; Permissions
                </a>
                <a href="{{ route('admin.academic_periods') }}" class="adm-fab-item">
                    <span class="adm-fab-icon"><i class="fa-solid fa-school"></i></span>
                    Academic Periods
                </a>
            </div>
            <button id="admMobFab" aria-label="Quick navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        {{-- Appointments --}}
        <a href="{{ route('admin.admin.dashboard') }}" class="adm-mob-item {{ false ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-check"></i>
            <span>Appts</span>
        </a>

        {{-- System Logs --}}
        <a href="{{ route('admin.system_logs') }}"
            class="adm-mob-item {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}">
            <i class="fa-solid fa-clipboard-list"></i>
            <span>Logs</span>
        </a>
    </nav>

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

    <main id="mainContent"
    class="px-4 sm:px-6 pt-[82px] pb-8 min-h-screen">
        <div style="max-width:1280px; margin:0 auto;">

            {{-- Top row --}}
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-7">
                <div>
                    <h1 class="sl-page-title">System <span>Logs</span></h1>
                    <p class="sl-page-sub">View recorded activities of admin, dentist, and patient users.</p>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0 sm:pt-1">
                    <span class="sl-live"><span class="sl-live-dot"></span> Live Monitoring</span>
                    <a href="{{ route('admin.admin.dashboard') }}" class="sl-back-btn">
                        <i class="fa-solid fa-arrow-left" style="font-size:0.72rem;"></i> Back to Dashboard
                    </a>
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
                            <input type="text" id="slSearch" placeholder="Search logs…" oninput="slFilter()" class="w-full sm:w-auto">
                        </div>
                        <button class="sl-export-btn whitespace-nowrap"><i class="fa-solid fa-download"></i> Export</button>
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
                                            class="fa-solid {{ $actionIcon }}"></i>{{ str_replace('_','
                                        ',ucwords($log->action)) }}</span></td>
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

    <!-- ════════════ FOOTER ════════════ -->
    <footer id="siteFooter" class="bg-[#8B0000] text-[#F4F4F4] p-6">
        <div
            class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 text-sm text-center">
            <span><span class="text-gray-300">© 2025–2026</span> <span class="font-semibold">Polytechnic University of
                    the Philippines</span></span>
            <span class="hidden sm:inline">|</span>
            <a href="https://www.pup.edu.ph/terms/" class="hover:underline">Terms of Use</a>
            <span class="hidden sm:inline">|</span>
            <a href="https://www.pup.edu.ph/privacy/" class="hover:underline">Privacy Statement</a>
        </div>
    </footer>

    <script>
        // Notifications
        document.getElementById('notifBtn').addEventListener('click', e => {
            e.stopPropagation();
            document.getElementById('notifMenu').classList.toggle('open');
        });
        document.addEventListener('click', () => {
            document.getElementById('notifMenu').classList.remove('open');
            const fabMenu = document.getElementById('admMobFabMenu');
            const fab = document.getElementById('admMobFab');
            if (fabMenu) fabMenu.classList.remove('open');
            if (fab) fab.classList.remove('open');
        });

        // Mobile FAB
        document.addEventListener('DOMContentLoaded', () => {
            const fab = document.getElementById('admMobFab');
            const fabMenu = document.getElementById('admMobFabMenu');
            if (fab && fabMenu) {
                fab.addEventListener('click', e => {
                    e.stopPropagation();
                    const isOpen = fabMenu.classList.contains('open');
                    fabMenu.classList.toggle('open', !isOpen);
                    fab.classList.toggle('open', !isOpen);
                });
                fabMenu.addEventListener('click', e => e.stopPropagation());
            }
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
    </script>
</body>

</html>