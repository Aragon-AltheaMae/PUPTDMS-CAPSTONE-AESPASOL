<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reschedule Appointment - Dentist</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet">
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- daisyUI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <!-- Font Inter -->
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
            --red: #8B0000;
            --red-mid: #a31515;
            --red-lt: #fff0f0;
            --red-pale: #fde8e8;
            --sand: #fdf6f0;
            --warm: #f9f0e8;
            --text: #2d1f1f;
            --muted: #9a7b7b;
            --border: #ecdada;
            --crimson: #8B0000;
            --crimson-dark: #6b0000;
            --crimson-light: #fef2f2;
            --crimson-mid: #fce8e8;
            --sidebar-w: 256px;
            --header-h: 64px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter';
            background: var(--sand);
            color: var(--text);
            margin: 0;
        }

        /* ════════════════════════════════
       HEADER
    ════════════════════════════════ */
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
        }

        .hdr-icon-btn i,
        .hdr-icon-btn svg {
            display: block;
            line-height: 1;
            margin: 0;
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
            gap: 10px;
            background: rgba(255,255,255,0.1);
            padding: 6px 12px;
            border-radius: 999px;
            cursor: pointer;
        }

        .header-user-btn img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
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

        body,
        #sidebar,
        main,
        .card,
        .modal-box {
            transition: background-color .3s ease, color .3s ease;
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

        /* ════════════════════════════════
       MOBILE DRAWER
    ════════════════════════════════ */
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
            transition: transform .3s cubic-bezier(.4, 0, .2, 1);
            box-shadow: 4px 0 32px rgba(0, 0, 0, .15);
            overflow: hidden;
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
            line-height: 1.2;
        }

        .drawer-subtitle {
            font-size: .7rem;
            color: rgba(255, 255, 255, .7);
        }

        .drawer-close {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .15);
            border: none;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            transition: background .15s;
        }

        .drawer-close:hover {
            background: rgba(255, 255, 255, .28);
        }

        .drawer-user {
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fdf9f9;
            flex-shrink: 0;
        }

        .drawer-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid #e5e7eb;
            object-fit: cover;
        }

        .drawer-user-name {
            font-size: .8rem;
            font-weight: 700;
            color: #1f2937;
        }

        .drawer-user-role {
            font-size: .66rem;
            color: #9ca3af;
        }

        .drawer-inner {
            flex: 1;
            overflow-y: auto;
            padding: 10px 8px 6px;
        }

        .drawer-group {
            margin-bottom: 2px;
        }

        .drawer-group-header {
            display: flex;
            align-items: center;
            padding: 6px 8px 4px;
            gap: 8px;
        }

        .drawer-group-icon {
            color: var(--crimson);
            font-size: 12px;
        }

        .drawer-group-label {
            font-size: .65rem;
            font-weight: 800;
            color: var(--crimson);
            text-transform: uppercase;
            letter-spacing: .07em;
        }

        .drawer-link {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 7px 10px 7px 28px;
            border-radius: 8px;
            margin: 1px 2px;
            font-size: .76rem;
            font-weight: 500;
            color: #374151;
            text-decoration: none;
            transition: all .15s;
        }

        .drawer-link:hover {
            background: var(--crimson-light);
            color: var(--crimson);
        }

        .drawer-link.active {
            background: var(--crimson);
            color: #fff;
            box-shadow: 0 2px 8px rgba(139, 0, 0, .2);
        }

        .drawer-link i {
            width: 14px;
            text-align: center;
            font-size: 11px;
        }

        .drawer-sep {
            height: 1px;
            background: #f3f4f6;
            margin: 8px 10px;
        }

        .drawer-bottom {
            padding: 10px 10px 14px;
            border-top: 1px solid #f3f4f6;
            flex-shrink: 0;
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
            letter-spacing: .1em;
            padding: 6px 8px 8px;
        }

        .drawer-nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            text-decoration: none;
            color: #4a5568;
            font-size: .8rem;
            font-weight: 600;
            transition: all .15s ease;
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
            font-size: 13px;
            flex-shrink: 0;
            transition: background .15s;
            color: #8B0000;
        }

        .drawer-nav-link.active .dnav-icon {
            background: rgba(255, 255, 255, .2);
            color: #fff;
        }

        .drawer-nav-link:hover:not(.active) .dnav-icon {
            background: #fce8e8;
        }

        .drawer-footer {
            padding: 10px 12px 16px;
            border-top: 1px solid #f3f4f6;
            flex-shrink: 0;
        }

        .drawer-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 2px solid #e5c8c8;
            object-fit: cover;
            flex-shrink: 0;
        }

        .drawer-user-name {
            font-size: .82rem;
            font-weight: 800;
            color: #1f2937;
        }

        .drawer-user-role {
            font-size: .67rem;
            color: #9ca3af;
            margin-top: 1px;
        }

        .drawer-close-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .15);
            border: none;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            transition: background .15s;
            flex-shrink: 0;
        }

        .drawer-close-btn:hover {
            background: rgba(255, 255, 255, .28);
        }

        /* User dropdown */
        #userDropdown {
            position: relative;
        }

        #userMenu {
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            width: 200px;
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

        /* Dark mode */
        [data-theme="dark"] body {
            background-color: #000D1A;
            color: #E5E7EB;
        }

        [data-theme="dark"] #sidebar {
            background-color: #000D1A;
        }

        [data-theme="dark"] .bg-white {
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, .3);
        }

        @media (max-width: 767px) {
            #sidebar {
                display: none !important;
            }

            #mainContent,
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
        }

        /* ── PAGE WRAPPER ── */
        .page {
            padding-top: 78px;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding-bottom: 2rem;
            background: #f4f4f4;
        }

        /* ── MAIN CARD ── */
        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 40px rgba(139, 0, 0, 0.28), 0 1px 4px rgba(0, 0, 0, .04);
            width: 100%;
            max-width: 860px;
            margin: 1.25rem 1rem;
            overflow: hidden;
        }

        /* Card top stripe */
        .card-header {
            background: linear-gradient(135deg, #6b0000, #8B0000);
            padding: 1.25rem 1.75rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .card-header-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: #fff;
            flex-shrink: 0;
        }

        .card-header h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
            line-height: 1.2;
        }

        .card-header p {
            font-size: .75rem;
            color: rgba(255, 255, 255, .7);
            margin: .15rem 0 0;
        }

        .card-body {
            padding: 1.5rem 1.75rem;
        }

        /* ── CURRENT APPOINTMENT BANNER ── */
        .appt-banner {
            background: var(--warm);
            border: 1.5px solid #f0d8c0;
            border-radius: 14px;
            padding: 1rem 1.25rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .appt-banner-item {
            flex: 1;
            min-width: 120px;
        }

        .appt-banner-label {
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: #c07b3a;
            margin-bottom: .2rem;
        }

        .appt-banner-value {
            font-size: .9rem;
            font-weight: 600;
            color: #7a4a1e;
        }

        /* ── SECTION LABEL ── */
        .section-label {
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: .75rem;
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── TWO-COL LAYOUT ── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }

        @media (max-width: 600px) {
            .two-col {
                grid-template-columns: 1fr;
            }
        }

        /* ── COMPACT CALENDAR ── */
        .cal-wrap {
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 1rem;
            background: #fff;
        }

        .cal-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: .75rem;
        }

        .cal-nav-btn {
            width: 28px;
            height: 28px;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            background: var(--red-lt);
            color: var(--red);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            transition: background .15s;
        }

        .cal-nav-btn:hover {
            background: var(--red-pale);
        }

        .cal-month {
            font-size: .95rem;
            font-weight: 700;
            color: var(--red);
        }

        .cal-year {
            font-size: .7rem;
            color: var(--muted);
        }

        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            text-align: center;
        }

        .cal-day-hdr {
            font-size: .58rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--muted);
            padding: 2px 0 6px;
        }

        .cal-day-hdr.weekend {
            color: #c07b7b;
        }

        .cal-cell-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .cal-cell {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            font-size: .75rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all .12s;
            color: var(--text);
        }

        .cal-cell:hover:not(.disabled):not(.past) {
            background: var(--red-lt);
            color: var(--red);
        }

        .cal-cell.today {
            background: var(--red);
            color: #fff;
            font-weight: 700;
        }

        .cal-cell.selected {
            background: var(--red) !important;
            color: #fff !important;
            font-weight: 700;
        }

        .cal-cell.disabled,
        .cal-cell.past {
            color: #ddd;
            cursor: not-allowed;
        }

        .cal-cell.holiday {
            background: #eff6ff;
            color: #2563eb;
            font-weight: 600;
        }

        .cal-cell.full {
            background: #fef2f2;
            color: #dc2626;
            font-weight: 600;
            cursor: not-allowed;
        }

        .cal-dot.dot-red {
            background: #ef4444;
        }

        .cal-cell.unavail {
            color: #e0e0e0;
            cursor: not-allowed;
        }

        .cal-dot {
            position: absolute;
            bottom: 1px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            border-radius: 50%;
        }

        .dot-red {
            background: #ef4444;
        }

        .dot-blue {
            background: #3b82f6;
        }

        .cal-tooltip {
            opacity: 0;
            transition: opacity 0.15s;
            pointer-events: none;
        }
        .cal-cell-wrap:hover .cal-tooltip {
            opacity: 1;
        }

        /* ── TIME SLOTS ── */
        .slots-wrap {
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 1rem;
            background: #fff;
            display: flex;
            flex-direction: column;
        }

        .slots-date-pill {
            background: linear-gradient(135deg, var(--red), #a31515);
            color: #fff;
            border-radius: 10px;
            padding: .45rem .85rem;
            font-size: .75rem;
            font-weight: 600;
            margin-bottom: .75rem;
            display: none;
        }

        .slots-date-pill.show {
            display: block;
        }

        .slots-placeholder {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: .78rem;
            gap: .4rem;
            padding: 1rem 0;
        }

        .slots-placeholder i {
            font-size: 1.4rem;
            opacity: .4;
        }

        .slots-grid {
            display: flex;
            flex-wrap: wrap;
            gap: .4rem;
        }

        .slot-chip {
            padding: .35rem .75rem;
            border-radius: 9999px;
            border: 1.5px solid var(--border);
            background: #fff;
            font-size: .72rem;
            font-weight: 600;
            cursor: pointer;
            color: var(--text);
            transition: all .12s;
        }

        .slot-chip:hover:not(.full) {
            border-color: var(--red);
            background: var(--red-lt);
            color: var(--red);
        }

        .slot-chip.selected {
            background: var(--red);
            border-color: var(--red);
            color: #fff;
        }

        .slot-chip.full {
            border-color: #eee;
            color: #ccc;
            cursor: not-allowed;
            text-decoration: line-through;
            font-size: .68rem;
        }

        .selected-time-pill {
            margin-top: .6rem;
            font-size: .75rem;
            font-weight: 600;
            color: var(--red);
            display: none;
            align-items: center;
            gap: .3rem;
        }

        .selected-time-pill.show {
            display: flex;
        }

        /* Legend */
        .legend {
            display: flex;
            flex-wrap: wrap;
            gap: .6rem .9rem;
            padding-top: .75rem;
            border-top: 1px solid var(--border);
            margin-top: .75rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: .35rem;
            font-size: .68rem;
            color: var(--muted);
        }

        .legend-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* ── REASON TEXTAREA ── */
        .reason-wrap {
            margin-bottom: 1.25rem;
        }

        .reason-textarea {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: .75rem 1rem;
            font-size: .82rem;
            resize: none;
            color: var(--text);
            background: #fff;
            transition: border-color .15s;
            outline: none;
        }

        .reason-textarea:focus {
            border-color: var(--red-mid);
        }

        .reason-textarea::placeholder {
            color: #cbb8b8;
        }

        /* ── BUTTONS ── */
        .btn-row {
            display: flex;
            justify-content: flex-end;
            gap: .75rem;
        }

        .btn {
            padding: .6rem 1.5rem;
            border-radius: 10px;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: all .15s;
            border: none;
            text-decoration: none;
        }

        .btn-cancel {
            background: #fff;
            color: var(--red);
            border: 1.5px solid var(--border);
        }

        .btn-cancel:hover {
            background: var(--red-lt);
            border-color: var(--red-pale);
        }

        .btn-confirm {
            background: linear-gradient(135deg, #6b0000, var(--red));
            color: #fff;
            box-shadow: 0 3px 12px rgba(139, 0, 0, .25);
        }

        .btn-confirm:hover {
            box-shadow: 0 5px 18px rgba(139, 0, 0, .35);
            transform: translateY(-1px);
        }

        /* ── SUCCESS MODAL ── */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .35);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 200;
        }

        .modal-backdrop.show {
            display: flex;
        }

        .modal-box {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            max-width: 360px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .15);
            animation: popIn .25s ease;
        }

        @keyframes popIn {
            from {
                transform: scale(.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #c6fde4;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: green;
        }

        .modal-title {
            font-size: 1.3rem;
            font-weight: 500;
            color: var(--text);
            margin-bottom: .4rem;
        }

        .modal-msg {
            font-size: .8rem;
            color: var(--muted);
            margin-bottom: 1.25rem;
            line-height: 1.6;
        }

        .modal-btn {
            background: var(--red);
            color: #fff;
            border: none;
            padding: .6rem 1.75rem;
            border-radius: 10px;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
        }

        .modal-btn:hover {
            background: #6b0000;
        }

        .error-msg {
            font-size: .72rem;
            font-weight: 600;
            color: #be123c;
            background: #fff1f2;
            border: 1.5px solid #fecdd3;
            border-radius: 8px;
            padding: .4rem .75rem;
            margin-bottom: .5rem;
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .cal-wrap.error,
        .slots-wrap.error {
            border-color: #fca5a5;
            background: #fffafa;
        }
    </style>
</head>

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<body>

    <!-- ════════ HEADER ════════ -->
  <header class="header">
    <div class="flex items-center gap-3">
      <button id="mobileMenuBtn" onclick="openDrawer()" aria-label="Open menu">
        <i class="fa-solid fa-bars"></i>
      </button>
      <img src="{{ asset('images/PUP.png') }}" class="header-logo" alt="PUP">
      <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="header-logo" alt="DMS">
      <div class="header-divider"></div>
      <span class="header-title">PUP Taguig Dental Clinic</span>
    </div>
    <div class="flex items-center gap-2 sm:gap-3">
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
              style="display:block;padding:.65rem 1rem;font-size:.76rem;color:#333;text-decoration:none;border-bottom:1px solid #fdf5f5;"
              onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background=''">
              <div style="font-weight:700;">{{ $n['title'] ?? 'Notification' }}</div>
              @if(!empty($n['message']))<div style="color:#aaa;margin-top:2px;font-size:.7rem;">{{ $n['message'] }}
              </div>@endif
            </a>
            @empty
            <div style="padding:2.5rem 1rem;text-align:center;color:#bbb;font-size:.76rem;">
              <i class="fa-regular fa-bell-slash" style="font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>You're
              all caught up.
            </div>
            @endforelse
          </div>
        </div>
      </div>
      <div id="userDropdown">
        <div class="header-user-btn" id="userBtn">
          <img src="{{ asset('images/Nelson-Angeles.jpg') }}" alt="Dr. Nelson P. Angeles" class="header-avatar"
            onerror="this.src='https://ui-avatars.com/api/?name=Nelson+Angeles&background=660000&color=FFFFFF&size=88'">
          <div class="hidden sm:block" style="line-height:1;">
            <div class="header-name">Dr. Nelson P. Angeles</div>
            <div class="header-role">Dentist</div>
          </div>
          <i class="fa-solid fa-chevron-down"
            style="color:rgba(255,255,255,.5);font-size:.6rem;margin-left:.25rem;"></i>
        </div>
        <div id="userMenu">
          <div class="user-menu-header">
            <img src="{{ asset('images/Nelson-Angeles.jpg') }}" alt="Dr. Nelson P. Angeles" class="header-avatar"
              onerror="this.src='https://ui-avatars.com/api/?name=Nelson+Angeles&background=660000&color=FFFFFF&size=88'">
            <div>
              <div class="user-menu-name">Dr. Nelson P. Angeles</div>
              <div class="user-menu-role">Dentist</div>
            </div>
          </div>
          <div style="padding:.5rem .75rem; border-bottom:1px solid #f3f4f6;">
            <div
              style="font-size:.6rem;font-weight:800;letter-spacing:.08em;color:#b0b7c3;text-transform:uppercase;margin-bottom:6px;">
              Appearance</div>
            <div class="theme-toggle-container" id="userMenuThemeToggle">
              <button type="button" class="theme-option active" data-theme="light"><i
                  class="fa-solid fa-sun"></i></button>
              <button type="button" class="theme-option" data-theme="dark"><i class="fa-regular fa-moon"></i></button>
              <div class="theme-indicator" aria-hidden="true"></div>
            </div>
          </div>
          <div class="user-menu-sep"></div>
          <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="user-menu-item danger"><i class="fa-solid fa-right-from-bracket"></i>Log
              out</button>
          </form>
        </div>
      </div>
    </div>
  </header>

    <!-- MOBILE DRAWER OVERLAY -->
    <div id="mobileDrawerOverlay" onclick="closeDrawer()"></div>

    <!-- MOBILE DRAWER -->
    <div id="mobileDrawer">
        <div class="drawer-header">
            <div class="drawer-brand">
                <img src="{{ asset('images/PUP.png') }}"
                    style="width:26px;height:26px;object-fit:contain;filter:drop-shadow(0 1px 3px rgba(0,0,0,.3));"
                    alt="PUP">
                <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" style="width:24px;height:24px;object-fit:contain;"
                    alt="DMS">
                <span class="drawer-brand-text">PUP Taguig<br>Dental Clinic</span>
            </div>
            <button class="drawer-close-btn" onclick="closeDrawer()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <nav class="drawer-nav">
            <div class="drawer-section-label">Navigation</div>
            @foreach([
            ['route'=>'dentist.dentist.dashboard', 'icon'=>'fa-chart-line', 'label'=>'Dashboard'],
            ['route'=>'dentist.dentist.patients', 'icon'=>'fa-users', 'label'=>'Patients'],
            ['route'=>'dentist.dentist.appointments', 'icon'=>'fa-calendar-check', 'label'=>'Appointments'],
            ['route'=>'dentist.dentist.documentrequests', 'icon'=>'fa-file-circle-check', 'label'=>'Document Requests'],
            ['route'=>'dentist.dentist.inventory', 'icon'=>'fa-box', 'label'=>'Inventory'],
            ['route'=>'dentist.dentist.report', 'icon'=>'fa-file', 'label'=>'Reports'],
            ] as $nav)
            <a href="{{ route($nav['route']) }}"
                class="drawer-nav-link {{ request()->routeIs($nav['route']) ? 'active' : '' }}">
                <span class="dnav-icon"><i class="fa-solid {{ $nav['icon'] }}"></i></span>
                {{ $nav['label'] }}
            </a>
            @endforeach
        </nav>

        <div class="drawer-footer">
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit"
                    style="width:100%;display:flex;align-items:center;gap:.6rem;padding:.6rem .75rem;border-radius:10px;border:1px solid #fce8e8;background:#fdf5f5;color:#8B0000;font-size:.8rem;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;transition:background .15s;">
                    <i class="fa-solid fa-right-from-bracket"></i> Log out
                </button>
            </form>
        </div>
    </div>

    <!-- PAGE -->
    <main class="page">
        <div class="card">

            <!-- Card Header -->
            <div class="card-header">
                <div class="card-header-icon"><i class="fa-regular fa-calendar-check"></i></div>
                <div>
                    <h1>Reschedule Appointment</h1>
                    <p>Pick a new date, time, and optionally add a reason.</p>
                </div>
            </div>

            <div class="card-body">

                <!-- Current Appointment Banner -->
                <div class="appt-banner">
                    <div class="appt-banner-item">
                        <div class="appt-banner-label"><i class="fa-solid fa-user fa-xs mr-1"></i>Patient</div>
                        <div class="appt-banner-value">{{ $appointment->patient->name ?? 'N/A' }}</div>
                    </div>
                    <div class="appt-banner-item">
                        <div class="appt-banner-label"><i class="fa-regular fa-clock fa-xs mr-1"></i>Current Schedule
                        </div>
                        <div class="appt-banner-value">{{
                            \Carbon\Carbon::parse($appointment->appointment_date)->format('M j, Y') }} · {{
                            \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</div>
                    </div>
                    <div class="appt-banner-item">
                        <div class="appt-banner-label"><i class="fa-solid fa-tooth fa-xs mr-1"></i>Service</div>
                        <div class="appt-banner-value">{{ $appointment->service_type ?? 'N/A' }}</div>
                    </div>
                </div>

                <!-- Form -->
                <form id="rescheduleForm"
                    action="{{ route('dentist.dentist.appointments.reschedule.update', $appointment->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="service_type" value="{{ $appointment->service_type }}">
                    <input type="hidden" id="new_appointment_date" name="new_appointment_date" required>
                    <input type="hidden" id="new_appointment_time" name="new_appointment_time" required>

                    <!-- Calendar + Slots -->
                    <div class="section-label"><i class="fa-regular fa-calendar fa-xs"></i> New Date & Time</div>

                    <div id="dateError" class="error-msg" style="display:none;">
                        <i class="fa-solid fa-circle-exclamation"></i> Please select a date.
                    </div>

                    <div class="two-col">

                        <!-- Calendar -->
                        <div class="cal-wrap">                        
                            <div id="calendarContainer"></div>

                            <!-- Legend -->
                            <div class="legend">
                                <div class="legend-item"><span class="legend-dot" style="background:#ef4444;"></span>
                                    Full</div>
                                <div class="legend-item"><span class="legend-dot" style="background:#3b82f6;"></span>
                                    Holiday</div>
                                <div class="legend-item"><span class="legend-dot" style="background:#d1d5db;"></span>
                                    Unavailable</div>
                                <div class="legend-item"><span class="legend-dot" style="background:#9ca3af;"></span>
                                    Today not available</div>
                            </div>
                        </div>

                        <!-- Time Slots -->
                        <div class="slots-wrap">
                            <div class="section-label" style="margin-bottom:.6rem;"><i
                                    class="fa-regular fa-clock fa-xs"></i> Time Slot</div>
                            <div class="slots-date-pill" id="datePill"></div>
                            <div id="slotPlaceholder" class="slots-placeholder">
                                <i class="fa-regular fa-calendar-xmark"></i>
                                <span>Select a date to see available slots</span>
                            </div>
                            <div id="slotGrid" class="slots-grid" style="display:none;"></div>
                            <div class="selected-time-pill" id="selectedTimePill">
                                <i class="fa-solid fa-circle-check" style="color:var(--red);"></i>
                                <span id="selectedTimeText"></span>
                            </div>
                        </div>

                        <div id="timeError" class="error-msg" style="display:none;">
                            <i class="fa-solid fa-circle-exclamation"></i> Please select a time slot.
                        </div>

                    </div>

                    <!-- Reason -->
                    <div class="section-label"><i class="fa-regular fa-message fa-xs"></i> Reason for Rescheduling <span
                            style="font-weight:400;text-transform:none;letter-spacing:0;">(optional)</span></div>
                    <div class="reason-wrap">
                        <textarea name="reschedule_reason" id="reschedule_reason" class="reason-textarea"
                            placeholder="e.g. Patient requested a later date…" rows="3"></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="btn-row">
                        <button type="button" class="btn btn-cancel" id="cancelBtn">
                            <i class="fa-solid fa-xmark"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-confirm">
                            <i class="fa-solid fa-check"></i> Confirm Reschedule
                        </button>
                    </div>

                </form>
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

    <!-- Success Modal -->
    <div class="modal-backdrop" id="successModal">
        <div class="modal-box">
            <div class="modal-icon"><i class="fa-solid fa-check text-green"></i></div>
            <div class="modal-title">All Set!</div>
            <div class="modal-msg" id="successMessage">The appointment has been rescheduled successfully.</div>
            <button class="modal-btn" id="okBtn">Back to Appointments</button>
        </div>
    </div>

    <!-- Cancel Confirmation Modal -->
    <div class="modal-backdrop" id="cancelModal">
        <div class="modal-box">
            <div class="modal-icon" style="background:#fff5f5;">
                <i class="fa-solid fa-triangle-exclamation" style="color:#f59e0b;"></i>
            </div>
            <div class="modal-title">Discard Changes?</div>
            <div class="modal-msg">Are you sure you want to cancel? Any unsaved changes will be lost.</div>
            <div style="display:flex;gap:.75rem;justify-content:center;">
                <button class="modal-btn" style="background:#e5e7eb;color:#374151;" id="cancelStayBtn">
                    Stay on Page
                </button>
                <button class="modal-btn" id="cancelConfirmBtn">
                    Yes, Cancel
                </button>
            </div>
        </div>
    </div>

    @include('components.appointment-calendar-script', [
        'mode'                    => 'reschedule',
        'renderStyle'             => 'patient',
        'calendarContainerId'     => 'calendarContainer',
        'calGridId'               => 'calendarContainer',
        'calMonthLabelId'         => 'calMonthLabel', 
        'calYearLabelId'          => 'calYearLabel',
        'dateInputId'             => 'new_appointment_date',
        'timeInputId'             => 'new_appointment_time',
        'datePillId'              => 'datePill',
        'slotPlaceholderId'       => 'slotPlaceholder',
        'slotGridId'              => 'slotGrid',
        'selectedTimePillId'      => 'selectedTimePill',
        'selectedTimeTextId'      => 'selectedTimeText',
        'dateErrorId'             => 'dateError',
        'timeErrorId'             => 'timeError',
        'calendarWrapSelector'    => '.cal-wrap',
        'slotsWrapSelector'       => '.slots-wrap',
        'slotEndpoint'            => route('dentist.appointment.slots'),
        'scheduleRules'           => $schedules ?? [],
        'blockedDates'            => $blockedDates ?? [],
        'appointmentCountsPerDay' => $appointmentCountsPerDay ?? [],
        'philippineHolidays'      => $philippineHolidays ?? [],
        'disallowToday'           => true,
        'allowToggleOffDate'      => true,
        'useDynamicScheduleRules' => true,
    ])

    <script>
        // ── Mobile Drawer ────────────────────────────────────────────
        function openDrawer() {
            document.getElementById('mobileDrawer').classList.add('open');
            document.getElementById('mobileDrawerOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeDrawer() {
            document.getElementById('mobileDrawer').classList.remove('open');
            document.getElementById('mobileDrawerOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }

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

        // ── Theme & Sidebar
        const html = document.documentElement;

        function applyTheme(theme) {
            html.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            document.querySelectorAll('.theme-option').forEach(o =>
                o.getAttribute('data-theme') === theme ? o.classList.add('active') : o.classList.remove('active'));
            const ind = document.querySelector('.theme-indicator');
            if (ind) theme === 'dark' ? ind.classList.add('dark-mode') : ind.classList.remove('dark-mode');
        }

        let sidebarOpen = true;

        function applyLayout(w) {
            document.getElementById('sidebar').style.width = w;
            document.getElementById('mainContent').style.marginLeft = w;
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const icon = document.getElementById('sidebarIcon');
            const isCollapsed = sidebar.classList.contains('collapsed');

            if (isCollapsed) {
                sidebar.classList.remove('collapsed');
                sidebar.style.width = '220px';
                document.getElementById('mainContent').style.marginLeft = '220px';
                icon.className = 'fa-solid fa-xmark';
            } else {
                sidebar.classList.add('collapsed');
                sidebar.style.width = '64px';
                document.getElementById('mainContent').style.marginLeft = '64px';
                icon.className = 'fa-solid fa-bars';
            }
        }

        function applyLayout(w) {
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('mainContent');
            if (sidebar) sidebar.style.width = w;
            if (main) main.style.marginLeft = w;
        }

        document.getElementById("cancelBtn").addEventListener("click", () => {
            document.getElementById("cancelModal").classList.add("show");
        });

        document.getElementById("cancelStayBtn").addEventListener("click", () => {
            document.getElementById("cancelModal").classList.remove("show");
        });

        document.getElementById("cancelConfirmBtn").addEventListener("click", () => {
            window.location.href = "{{ route('dentist.dentist.appointments') }}";
        });

        /* ── FORM SUBMIT ── */
        document.getElementById("rescheduleForm").addEventListener("submit", async e => {
            e.preventDefault();

            let valid = true;

            if (!selectedDate) {
                document.getElementById("dateError").style.display = "flex";
                document.querySelector(".cal-wrap").classList.add("error");
                valid = false;
            }

            if (!selectedTime) {
                document.getElementById("timeError").style.display = "flex";
                document.querySelector(".slots-wrap").classList.add("error");
                valid = false;
            }

            if (!valid) return;

            const form = document.getElementById("rescheduleForm");
            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                        "Accept": "application/json",
                    },
                    body: formData,
                });

                if (response.ok || response.redirected) {
                    document.getElementById("successModal").classList.add("show");
                } else {
                    const data = await response.json().catch(() => null);
                    alert(data?.message ?? "Something went wrong. Please try again.");
                }
            } catch (err) {
                alert("Network error. Please try again.");
            }
        });

        document.getElementById("okBtn").addEventListener("click", () => {
            document.getElementById("successModal").classList.remove("show");
            window.location.href = "{{ route('dentist.dentist.appointments') }}";
        });
    </script>
</body>

</html>