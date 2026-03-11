<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PUP Taguig Dental Clinic | Record</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Playfair+Display:wght@600;700;800&display=swap"
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
            --crimson-dark: #5A0000;
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

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--surface);
            color: var(--text-1);
            overflow-x: hidden;
        }

        /* ── DESKTOP SIDEBAR LAYOUT ── */
        #mainContent {
            margin-left: 220px;
            transition: margin-left .3s ease;
        }

        #sidebar {
            width: 220px;
            transition: width .3s ease;
        }

        #sidebar.collapsed {
            width: 72px !important;
        }

        /* ── MOBILE PROFILE ACCORDION ── */
        #mobileProfileAccordion {
            display: none;
        }

        /* ── MOBILE BOTTOM NAV ── */
        #mobileBottomNav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 72px;
            background: white;
            border-top: 1px solid #f0e0e0;
            z-index: 200;
            align-items: center;
            justify-content: space-around;
            box-shadow: 0 -4px 20px rgba(139, 0, 0, .10);
        }

        .mob-nav-item {
            flex: 1;
            height: 72px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 2px;
            font-size: 10px;
            font-weight: 600;
            color: #9CA3AF;
            text-decoration: none;
            transition: color .2s;
        }

        .mob-nav-item.active {
            color: #8B0000;
        }

        .mob-nav-item i {
            font-size: 22px;
        }

        #mobFabWrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: static;
        }

        #mobFab {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8B0000, #660000);
            color: white;
            border: none;
            font-size: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(139, 0, 0, .45);
            cursor: pointer;
            transition: transform .25s cubic-bezier(.34, 1.56, .64, 1);
            z-index: 10;
            position: relative;
            top: -10px;
        }

        #mobFab.open {
            transform: rotate(45deg) translateY(-10px);
        }

        #mobFabMenu {
            position: fixed;
            bottom: 90px;
            left: 50%;
            transform: translateX(-50%) scaleY(0);
            transform-origin: bottom center;
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(139, 0, 0, .18);
            border: 1px solid #f5e8e8;
            min-width: 200px;
            overflow: hidden;
            transition: transform .25s cubic-bezier(.34, 1.56, .64, 1), opacity .2s;
            opacity: 0;
            pointer-events: none;
            z-index: 300;
        }

        #mobFabMenu.open {
            transform: translateX(-50%) scaleY(1);
            opacity: 1;
            pointer-events: auto;
        }

        .fab-menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            text-decoration: none;
            transition: background .15s;
            border-bottom: 1px solid #fdf5f5;
        }

        .fab-menu-item:last-child {
            border-bottom: none;
        }

        .fab-menu-item:hover {
            background: #FFF0F0;
            color: #8B0000;
        }

        .fab-menu-item i {
            width: 32px;
            height: 32px;
            background: #FFF0F0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #8B0000;
            flex-shrink: 0;
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
            font-size: 1rem;
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

        @media (max-width: 480px) {

            .header-title,
            .header-name,
            .header-role {
                display: none;
            }

            .header {
                padding: 0 1rem;
            }
        }

        /* ── SIDEBAR ── */
        .sidebar-link {
            display: flex;
            align-items: center;
            transition: background-color .2s ease, transform .2s ease;
        }

        #sidebar.expanded .sidebar-link {
            justify-content: flex-start;
            padding-left: .25rem;
        }

        #sidebar.expanded .sidebar-link i {
            margin-right: .75rem;
        }

        #sidebar.expanded .sidebar-link:hover {
            transform: translateX(4px);
        }

        #sidebar.expanded .sidebar-tooltip {
            display: none;
        }

        #sidebar.expanded .section-label {
            display: block;
        }

        #sidebar.expanded .sidebar-text {
            opacity: 1;
            width: auto;
            overflow: visible;
        }

        #sidebar.collapsed .sidebar-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        #sidebar.collapsed .sidebar-tooltip {
            display: block;
        }

        #sidebar.collapsed .section-label {
            display: none;
        }

        #sidebar.collapsed .sidebar-link {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        #sidebar.collapsed .sidebar-link i {
            margin-right: 0 !important;
            width: 100%;
            text-align: center;
        }

        .sidebar-link:hover .sidebar-tooltip {
            opacity: 1 !important;
            transform: scale(1) !important;
        }

        .section-label {
            font-size: .65rem;
            font-weight: 500;
            letter-spacing: .08em;
            color: #757575;
            text-transform: uppercase;
            margin-bottom: .25rem;
        }

        .sidebar-link.bg-\[\#8B0000\] {
            box-shadow: 0 0 12px rgba(139, 0, 0, .45);
        }

        /* ── THEME TOGGLE ── */
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
            transition: all .3s ease;
        }

        #sidebar.collapsed .theme-toggle-container {
            flex-direction: column;
            width: 35px;
            height: 96px;
            border-radius: 24px;
            padding: 4px;
        }

        #sidebar.collapsed .w-full {
            display: flex;
            justify-content: center;
        }

        .theme-option {
            position: relative;
            z-index: 2;
            flex: 1;
            height: 40px;
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

        #sidebar.collapsed .theme-option {
            width: 35px;
            height: 40px;
            flex: none;
        }

        .theme-option i {
            font-size: 16px;
        }

        #sidebar.collapsed .theme-option i {
            font-size: 15px;
        }

        .theme-option.active {
            color: #374151;
        }

        .theme-indicator {
            position: absolute;
            background: white;
            border-radius: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
            transition: all .3s cubic-bezier(.4, 0, .2, 1);
            pointer-events: none;
        }

        #sidebar.expanded .theme-indicator {
            width: calc(50% - 2px);
            height: calc(100% - 8px);
            left: 4px;
            top: 4px;
            border-radius: 20px;
        }

        #sidebar.expanded .theme-indicator.dark-mode {
            transform: translateX(calc(100%));
        }

        #sidebar.collapsed .theme-indicator {
            width: calc(100% - 8px);
            height: calc(50% - 6px);
            left: 4px;
            top: 4px;
            border-radius: 16px;
        }

        #sidebar.collapsed .theme-indicator.dark-mode {
            transform: translateY(calc(100% + 4px));
        }

        /* ── DARK THEME ── */

        body,
        #sidebar,
        main,
        .card,
        .modal-box {
            transition: background-color .3s ease, color .3s ease;
        }

        [data-theme="dark"] body {
            background-color: #0D0D0D;
            color: #E5E7EB;
        }

        [data-theme="dark"] #sidebar {
            background-color: #111;
        }

        [data-theme="dark"] .bg-white {
            background-color: #111 !important;
        }

        [data-theme="dark"] .text-\[\#333333\] {
            color: #E5E7EB !important;
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

        [data-theme="dark"] #mobileBottomNav {
            background: #0a0a0a;
            border-top-color: #1a1a1a;
        }

        [data-theme="dark"] #mobFabMenu {
            background: #111;
            border-color: #222;
        }

        [data-theme="dark"] .fab-menu-item {
            color: #E5E7EB;
            border-bottom-color: #1a1a1a;
        }

        [data-theme="dark"] .fab-menu-item:hover {
            background: #1a1a1a;
        }

        [data-theme="dark"] .mob-nav-item {
            color: #4B5563;
        }

        [data-theme="dark"] .mob-nav-item.active {
            color: #ff6b6b;
        }

        [data-theme="dark"] #mobileProfileAccordion {
            background: #0a0a0a;
            border-bottom-color: #1a1a1a;
        }

        [data-theme="dark"] .rec-card {
            background: #161616 !important;
            border-color: #2a2020 !important;
        }

        [data-theme="dark"] .rec-service {
            color: #f87171 !important;
        }

        [data-theme="dark"] .rec-meta {
            color: #9CA3AF !important;
        }

        [data-theme="dark"] .page-shell {
            background: #0D0D0D !important;
        }

        [data-theme="dark"] .stat-pill {
            background: #1a1a1a !important;
            border-color: #2a2a2a !important;
            color: #E5E7EB !important;
        }

        [data-theme="dark"] .modal-inner-bg {
            background: #111 !important;
        }

        [data-theme="dark"] .modal-section-card {
            background: #1a1a1a !important;
            border-color: #2a2a2a !important;
        }

        [data-theme="dark"] .chip-box-bg {
            background: #1a1a1a !important;
            border-color: #2a2a2a !important;
        }

        /* ── MOBILE BREAKPOINTS ── */
        @media (max-width: 767px) {
            #sidebar {
                display: none !important;
            }

            #mainContent {
                margin-left: 0 !important;
                padding-bottom: 90px;
            }

            #mobileBottomNav {
                display: flex;
            }

            footer {
                margin-bottom: 72px;
            }

            #desktopHeaderUser {
                display: none !important;
            }

            #mobileProfileAccordion {
                display: block;
                position: fixed;
                top: 62px;
                left: 0;
                right: 0;
                z-index: 45;
                background: white;
                border-bottom: 1px solid #f0e0e0;
                box-shadow: 0 4px 20px rgba(139, 0, 0, .08);
                max-height: 0;
                overflow: hidden;
                transition: max-height .35s cubic-bezier(.4, 0, .2, 1), opacity .25s ease;
                opacity: 0;
            }

            #mobileProfileAccordion.open {
                max-height: 200px;
                opacity: 1;
            }

            #mobileProfileToggle {
                display: flex !important;
            }
        }

        @media (min-width: 768px) {
            #mobileProfileToggle {
                display: none !important;
            }

            #darkModeFab {
                display: none !important;
            }

            #mobileBottomNav {
                display: none !important;
            }
        }

        /* ════════════════════════════
       PAGE REDESIGN STYLES
    ════════════════════════════ */

        /* Hero banner at top of records */
        .records-hero {
            background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 60%, #b5282a 100%);
            border-radius: 20px;
            padding: 28px 28px 52px;
            position: relative;
            overflow: hidden;
            margin-bottom: -32px;
        }

        .records-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .records-hero::after {
            content: '';
            position: absolute;
            right: -20px;
            bottom: -20px;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, .05);
            border-radius: 50%;
        }

        .hero-eyebrow {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .55);
            margin-bottom: 6px;
        }

        .hero-title {
            font-size: 28px;
            font-weight: 800;
            color: white;
            line-height: 1.15;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 22px;
            }

            .records-hero {
                padding: 20px 18px 44px;
            }
        }

        .hero-sub {
            font-size: 13px;
            color: rgba(255, 255, 255, .65);
            margin-top: 6px;
            position: relative;
            z-index: 1;
        }

        .hero-stats {
            display: flex;
            gap: 12px;
            margin-top: 16px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .hero-stat {
            background: rgba(255, 255, 255, .13);
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 40px;
            padding: 5px 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, .9);
        }

        .hero-stat i {
            font-size: 10px;
            opacity: .7;
        }

        /* Records content card */
        .records-body {
            background: white;
            border-radius: 20px;
            border: 1px solid var(--border);
            padding: 20px;
            position: relative;
            z-index: 2;
            box-shadow: 0 4px 32px rgba(0, 0, 0, .06);
        }

        @media (max-width: 480px) {
            .records-body {
                padding: 14px 12px;
                border-radius: 16px;
            }
        }

        /* ── Individual record card ── */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .rec-row {
            display: flex;
            align-items: stretch;
            gap: 0;
            animation: slideUp .35s ease both;
        }

        /* Timeline column */
        .rec-tl {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 32px;
            flex-shrink: 0;
            padding-top: 16px;
        }

        .rec-dot {
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background: var(--crimson);
            border: 2px solid white;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, .18);
            flex-shrink: 0;
            z-index: 1;
        }

        .rec-line {
            flex: 1;
            width: 1px;
            background: linear-gradient(to bottom, rgba(139, 0, 0, .2), rgba(139, 0, 0, .04));
            margin-top: 6px;
        }

        .rec-row:last-child .rec-line {
            display: none;
        }

        /* Card body */
        .rec-card {
            flex: 1;
            min-width: 0;
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 13px 14px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            transition: box-shadow .2s, border-color .2s, transform .18s;
            cursor: default;
        }

        .rec-card:hover {
            box-shadow: 0 6px 24px rgba(139, 0, 0, .08);
            border-color: rgba(139, 0, 0, .2);
            transform: translateY(-1px);
        }

        .rec-card-left {
            min-width: 0;
            flex: 1;
        }

        .rec-service {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--crimson);
            line-height: 1.3;
            margin-bottom: 5px;
        }

        .rec-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            font-size: 11.5px;
            color: var(--text-3);
        }

        .rec-meta-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--crimson-soft);
            color: var(--crimson);
            border-radius: 20px;
            padding: 2px 8px;
            font-size: 11px;
            font-weight: 600;
        }

        .rec-meta-chip i {
            font-size: 9px;
            opacity: .7;
        }

        /* Details button */
        .rec-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 50px;
            background: var(--crimson);
            color: white;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            flex-shrink: 0;
            transition: background .18s, transform .15s, box-shadow .18s;
            box-shadow: 0 2px 10px rgba(139, 0, 0, .28);
        }

        .rec-btn:hover {
            background: var(--crimson-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(139, 0, 0, .38);
        }

        .rec-btn i {
            font-size: 11px;
        }

        @media (max-width: 480px) {
            .rec-card {
                flex-wrap: wrap;
                padding: 12px 10px;
            }

            .rec-btn {
                width: 100%;
                justify-content: center;
                margin-top: 8px;
            }
        }

        /* Empty state */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 20px;
            text-align: center;
        }

        .empty-icon-wrap {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: var(--crimson-soft);
            border: 1.5px solid rgba(139, 0, 0, .12);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .empty-icon-wrap i {
            font-size: 28px;
            color: var(--crimson);
            opacity: .4;
        }

        .empty-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-1);
            margin-bottom: 6px;
        }

        .empty-sub {
            font-size: 13px;
            color: var(--text-3);
            max-width: 260px;
            line-height: 1.6;
        }

        /* ── MODAL ── */
        dialog#record_modal {
            padding: 0;
            border: none;
            background: transparent;
        }

        dialog#record_modal::backdrop {
            background: rgba(10, 10, 10, .55);
            backdrop-filter: blur(3px);
        }

        @media (min-width: 641px) {
            dialog#record_modal {
                border-radius: 22px;
                max-width: 500px;
                width: 92%;
                overflow: hidden;
            }
        }

        @media (max-width: 640px) {
            dialog#record_modal {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                top: auto;
                width: 100%;
                max-width: 100%;
                max-height: 92vh;
                border-radius: 22px 22px 0 0;
                margin: 0;
                animation: sheetUp .3s cubic-bezier(.32, 1.1, .64, 1);
            }

            @keyframes sheetUp {
                from {
                    transform: translateY(100%);
                }

                to {
                    transform: translateY(0);
                }
            }
        }

        .modal-inner {
            background: #F7F4F2;
            border-radius: inherit;
            max-height: 92vh;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .drag-pill {
            display: none;
            width: 36px;
            height: 4px;
            background: rgba(255, 255, 255, .4);
            border-radius: 2px;
            margin: 0 auto 10px;
        }

        @media (max-width: 640px) {
            .drag-pill {
                display: block;
            }
        }

        /* Modal header */
        .modal-head {
            background: linear-gradient(135deg, var(--crimson-dark), var(--crimson));
            padding: 20px 20px 24px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .modal-head::before {
            content: '';
            position: absolute;
            right: -30px;
            top: -30px;
            width: 130px;
            height: 130px;
            background: rgba(255, 255, 255, .06);
            border-radius: 50%;
        }

        .modal-head-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .modal-eyebrow {
            font-size: 9.5px;
            font-weight: 800;
            letter-spacing: .13em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .5);
            margin-bottom: 4px;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 700;
            line-height: 1.2;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 640px) {
            .modal-title {
                font-size: 18px;
            }
        }

        .modal-close-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .15);
            border: none;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            font-size: 13px;
            transition: background .15s;
            position: relative;
            z-index: 1;
        }

        .modal-close-btn:hover {
            background: rgba(255, 255, 255, .25);
        }

        .modal-meta-strip {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 12px;
            position: relative;
            z-index: 1;
        }

        .modal-meta-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 30px;
            padding: 4px 10px;
            font-size: 11.5px;
            color: rgba(255, 255, 255, .88);
            font-weight: 500;
        }

        .modal-meta-chip i {
            font-size: 10px;
            opacity: .75;
        }

        /* Modal body */
        .modal-body {
            padding: 16px 18px 18px;
        }

        .chip-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 14px;
        }

        .chip-box {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 11px 14px;
        }

        .chip-lbl {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--text-3);
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 6px;
        }

        .chip-val {
            display: inline-flex;
            align-items: center;
            padding: 3px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
        }

        /* Section blocks */
        .msec {
            margin-bottom: 10px;
        }

        .msec-head {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }

        .msec-lbl {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--crimson);
            white-space: nowrap;
        }

        .msec-rule {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .msec-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            align-items: stretch;
        }

        .msec-accent {
            width: 4px;
            background: rgba(139, 0, 0, .15);
            flex-shrink: 0;
        }

        .msec-text {
            padding: 10px 13px;
            font-size: 13px;
            color: var(--text-2);
            line-height: 1.65;
            flex: 1;
        }

        .modal-footer {
            padding: 0 18px 18px;
        }

        .modal-close-main {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            background: #EDEAE7;
            color: var(--text-1);
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background .15s;
        }

        @media (min-width: 641px) {
            .modal-close-main {
                width: auto;
                padding: 10px 28px;
                float: right;
            }
        }

        .modal-close-main:hover {
            background: #DDD9D5;
        }
    </style>
</head>

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<body class="bg-[#FAFAF8] text-[#1C1410]">

    <!-- ══════ HEADER ══════ -->
    <header class="header">
        <div class="header-left">
            <img src="{{ asset('images/PUP.png') }}" class="header-logo" alt="PUP">
            <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="header-logo" alt="DMS">
            <span class="header-title">PUP TAGUIG DENTAL CLINIC</span>
        </div>
        <div class="header-right">
            <div id="notifDropdown">
                <button class="notif-btn" id="notifBtn">
                    <i class="fa-regular fa-bell"></i>
                    @if ($notifCount > 0)
                    <span class="notif-badge">{{ $notifCount }}</span>
                    @endif
                </button>
                <div id="notifMenu">
                    <div
                        style="padding:.85rem 1rem .65rem;font-weight:700;color:#8B0000;font-size:.82rem;border-bottom:1px solid #f5e8e8;">
                        Notifications</div>
                    <div style="max-height:260px;overflow-y:auto;">
                        @forelse($notifications as $n)
                        <a href="{{ $n['url'] ?? '#' }}"
                            style="display:block;padding:.65rem 1rem;font-size:.78rem;color:#333;text-decoration:none;border-bottom:1px solid #fdf5f5;">
                            <div style="font-weight:600;">{{ $n['title'] ?? 'Notification' }}</div>
                            @if (!empty($n['message']))
                            <div style="color:#aaa;margin-top:2px;">{{ $n['message'] }}</div>
                            @endif
                        </a>
                        @empty
                        <div style="padding:2rem 1rem;text-align:center;color:#bbb;font-size:.78rem;">You're all
                            caught up.</div>
                        @endforelse
                    </div>
                </div>
            </div>
            <button id="mobileProfileToggle" onclick="toggleMobileProfile()"
                style="display:none;align-items:center;gap:.6rem;background:none;border:none;cursor:pointer;padding:0;">
                <img class="header-avatar"
                    src="{{ $patient->profile_image ? asset('storage/' . $patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patient->name) . '&background=660000&color=FFFFFF&rounded=true&size=36' }}"
                    alt="Profile">
                <i id="mobileProfileChevron"
                    class="fa-solid fa-chevron-down text-white text-xs transition-transform duration-300"></i>
            </button>
            <div class="header-user" id="desktopHeaderUser">
                <img class="header-avatar"
                    src="{{ $patient->profile_image ? asset('storage/' . $patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patient->name) . '&background=660000&color=FFFFFF&rounded=true&size=36' }}"
                    alt="Profile">
                <div>
                    <div class="header-name">{{ ucwords(strtolower($patient->name)) }}</div>
                    <div class="header-role">Student</div>
                </div>
            </div>
        </div>
    </header>

    <!-- ══════ MOBILE PROFILE ACCORDION ══════ -->
    <div id="mobileProfileAccordion">
        <div class="flex items-center gap-4 px-5 py-4 border-b border-gray-100">
            <img class="w-12 h-12 rounded-full border-2 border-[#8B0000]/20 object-cover flex-shrink-0"
                src="{{ $patient->profile_image ? asset('storage/' . $patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patient->name) . '&background=660000&color=FFFFFF&rounded=true&size=96' }}"
                alt="Profile">
            <div>
                <p class="font-bold text-[#333333] text-base leading-tight">{{ ucwords(strtolower($patient->name)) }}
                </p>
                <p class="text-xs text-[#757575] italic">Student</p>
            </div>
        </div>
        <div class="px-5 py-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-red-600 bg-red-50 hover:bg-red-100 font-semibold text-sm transition-colors duration-200">
                    <i class="fa-solid fa-right-from-bracket"></i> Log out
                </button>
            </form>
        </div>
    </div>

    <!-- ══════════════ DESKTOP SIDEBAR ══════════════ -->
    <aside id="sidebar"
        class="fixed left-0 top-[62px] h-[calc(100vh-62px)] bg-white drop-shadow-xl transition-all duration-300 flex flex-col justify-between z-40 expanded"
        style="width:220px;">
        <div class="pt-4">
            <div id="sidebarToggleWrapper" class="flex items-center justify-end px-4 py-2">
                <button onclick="toggleSidebar()" id="sidebarToggleBtn"
                    class="w-8 h-8 flex items-center justify-center rounded-full text-[#757575] hover:text-[#8B0000] hover:bg-[#F0F0F0] transition-all duration-300">
                    <i id="sidebarIcon" class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>
            <div class="section-label px-4 mb-6">Navigation</div>
            <nav class="space-y-2 px-3 text-gray-600">
                @foreach([
                ['route'=>'homepage', 'icon'=>'fa-house', 'label'=>'Home'],
                ['route'=>'patient.appointment.index', 'icon'=>'fa-calendar', 'label'=>'Appointment'],
                ['route'=>'patient.record', 'icon'=>'fa-folder-open', 'label'=>'Dental Record'],
                ['route'=>'patient.about.us', 'icon'=>'fa-file-circle-check','label'=>'About Us'],
                ] as $nav)
                <a href="{{ route($nav['route']) }}"
                    class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8 transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs($nav['route']) ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
                    <span
                        class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] {{ request()->routeIs($nav['route']) ? 'opacity-100' : 'opacity-0' }}"></span>
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center ml-1"><i
                            class="fa-solid {{ $nav['icon'] }} text-lg"></i></span>
                    <span
                        class="sidebar-text ml-2 text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300">{{
                        $nav['label'] }}</span>
                    <span
                        class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">{{
                        $nav['label'] }}</span>
                </a>
                @endforeach
            </nav>
        </div>
        <div class="px-3 pb-5 space-y-4">
            <div class="section-label">Settings</div>
            <div class="w-full px-3">
                <div id="themeToggle" class="theme-toggle-container">
                    <button type="button" class="theme-option active" data-theme="light" aria-label="Light mode"><i
                            class="fa-solid fa-sun"></i></button>
                    <button type="button" class="theme-option" data-theme="dark" aria-label="Dark mode"><i
                            class="fa-regular fa-moon"></i></button>
                    <div class="theme-indicator" aria-hidden="true"></div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    class="group sidebar-link w-full relative flex items-center rounded-xl text-sm text-red-600 hover:bg-red-100 transition-all duration-200">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg flex-shrink-0 ml-2"><i
                            class="fa-solid fa-right-from-bracket text-sm"></i></div>
                    <span
                        class="sidebar-text ml-2 opacity-0 w-0 font-semibold overflow-hidden transition-all duration-300 delay-150">Log
                        out</span>
                    <span
                        class="sidebar-tooltip absolute left-full ml-2 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Log
                        out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ══════ MOBILE BOTTOM NAV ══════ -->
    <nav id="mobileBottomNav">
        <a href="{{ route('homepage') }}" class="mob-nav-item {{ request()->routeIs('homepage') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i><span>Home</span>
        </a>
        <a href="{{ route('patient.appointment.index') }}"
            class="mob-nav-item {{ request()->routeIs('patient.appointment.index') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar"></i><span>Appointments</span>
        </a>
        <div id="mobFabWrapper">
            <div id="mobFabMenu">
                <a href="{{ route('patient.book.appointment') }}" class="fab-menu-item">
                    <i class="fa-solid fa-calendar-plus"></i> Book Appointment
                </a>
                <a onclick="document.getElementById('dentalHealthRecordModal')?.showModal()"
                    class="fab-menu-item cursor-pointer">
                    <i class="fa-solid fa-file-medical"></i> Request Health Record
                </a>
                <a onclick="document.getElementById('dentalClearanceModal')?.showModal()"
                    class="fab-menu-item cursor-pointer">
                    <i class="fa-solid fa-file-circle-check"></i> Request Clearance
                </a>
            </div>
            <button id="mobFab" aria-label="Quick actions"><i class="fa-solid fa-plus"></i></button>
        </div>
        <a href="{{ route('patient.record') }}"
            class="mob-nav-item {{ request()->routeIs('patient.record') ? 'active' : '' }}">
            <i class="fa-solid fa-folder-open"></i><span>Record</span>
        </a>
        <a href="{{ route('patient.about.us') }}"
            class="mob-nav-item {{ request()->routeIs('patient.about.us') ? 'active' : '' }}">
            <i class="fa-solid fa-circle-info"></i><span>About</span>
        </a>
    </nav>

    <!-- DARK MODE FAB -->
    <button id="darkModeFab"
        onclick="applyTheme(document.documentElement.getAttribute('data-theme')==='dark'?'light':'dark')" style="position:fixed;bottom:88px;right:16px;width:44px;height:44px;border-radius:50%;
           background:linear-gradient(135deg,#8B0000,#660000);color:white;border:none;font-size:18px;
           display:flex;align-items:center;justify-content:center;
           box-shadow:0 4px 16px rgba(139,0,0,.45);cursor:pointer;z-index:199;
           transition:transform .2s cubic-bezier(.34,1.56,.64,1);">
        <i id="darkModeFabIcon" class="fa-solid fa-moon"></i>
    </button>

    <!-- ══════ MAIN ══════ -->
    <main id="mainContent" class="pt-[100px] px-4 sm:px-6 py-6 fade-up min-h-screen">
        <div class="mx-auto">

            <!-- Breadcrumb -->
            <div class="text-xs mb-5 font-medium flex items-center gap-1.5 text-gray-400 pt-4">
                <a href="{{ route('homepage') }}" class="hover:text-[#8B0000] transition-colors">Home</a>
                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                <span class="text-[#8B0000] font-semibold">Dental Records</span>
            </div>

            @if (isset($upcomingAppointment) && $upcomingAppointment)
            @php
            $uDate = \Carbon\Carbon::parse($upcomingAppointment->appointment_date);
            $uTime = \Carbon\Carbon::parse($upcomingAppointment->appointment_time);
            $isRescheduled = strtolower($upcomingAppointment->status) === 'rescheduled';
            @endphp
            <div class="mb-5 rounded-2xl overflow-hidden border border-[#EDE8E4] shadow-sm">
                {{-- Card top --}}
                <div class="flex items-center justify-between gap-3 px-5 py-3"
                    style="background: linear-gradient(135deg, #5A0000, #8B0000);">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center flex-shrink-0">
                            <i class="fa-regular fa-calendar-check text-white text-sm"></i>
                        </div>
                        <span class="text-white font-bold text-sm">Upcoming Appointment</span>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold flex-shrink-0
                  {{ $isRescheduled ? 'bg-yellow-400/20 text-yellow-100' : 'bg-emerald-500/20 text-emerald-100' }}">
                        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0
                      {{ $isRescheduled ? 'bg-yellow-300' : 'bg-emerald-400' }}"></span>
                        {{ ucfirst($upcomingAppointment->status) }}
                    </span>
                </div>
                {{-- Card body --}}
                <div class="bg-white px-5 py-4 grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <div>
                        <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Service</p>
                        <p class="text-sm font-bold text-[#8B0000]">
                            {{ $upcomingAppointment->service_type ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Date & Time
                        </p>
                        <p class="text-sm font-bold text-[#1C1410]">
                            {{ $uDate->format('M d, Y') }}
                            <span class="text-[#8B0000] mx-0.5">·</span>
                            {{ $uTime->format('g:i A') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Dentist</p>
                        <p class="text-sm font-bold text-[#1C1410]">
                            {{ $upcomingAppointment->dentist_name ?? 'Dr. Nelson P. Angeles' }}</p>
                    </div>
                </div>
            </div>
            @endif

            @php
            $totalRecords = isset($records) ? $records->count() : 0;
            $latestDate = $totalRecords
            ? \Carbon\Carbon::parse($records->first()->appointment_date)->format('M Y')
            : null;
            @endphp

            <!-- Hero Banner -->
            <div class="records-hero">
                <div class="hero-eyebrow">Patient Portal</div>
                <h1 class="hero-title">Dental Records</h1>
                <p class="hero-sub">A complete history of your dental visits and treatments.</p>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <i class="fa-solid fa-list"></i>
                        {{ $totalRecords }} {{ $totalRecords === 1 ? 'visit' : 'visits' }}
                    </div>
                    @if ($latestDate)
                    <div class="hero-stat">
                        <i class="fa-regular fa-calendar"></i>
                        Latest: {{ $latestDate }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Records Body Card -->
            <div class="records-body">

                @if ($totalRecords)

                {{-- Section label --}}
                <div class="flex items-center gap-3 mb-5 pt-2">
                    <span
                        style="font-size:9px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:#9E9690;">Visit
                        History</span>
                    <div style="flex:1;height:1px;background:#EDE8E4;"></div>
                </div>

                {{-- Timeline --}}
                <div class="space-y-0">
                    @foreach ($records as $i => $record)
                    @php
                    $apptDate = \Carbon\Carbon::parse($record->appointment_date);
                    $apptTime = \Carbon\Carbon::parse($record->appointment_time);
                    $fmtDate = $apptDate->format('d M Y');
                    $fmtTime = $apptTime->format('g:i A');
                    $fmtRange =
                    $apptTime->format('g:i A') . ' – ' . $apptTime->copy()->addHour()->format('g:i A');
                    @endphp
                    <div class="rec-row" style="animation-delay:{{ $i * 0.06 }}s;">

                        {{-- Timeline dot + line --}}
                        <div class="rec-tl">
                            <div class="rec-dot"></div>
                            <div class="rec-line"></div>
                        </div>

                        {{-- Card --}}
                        <div class="rec-card">
                            <div class="rec-card-left">
                                <div class="rec-service">{{ $record->service_type }}</div>
                                <div class="rec-meta">
                                    <span class="rec-meta-chip">
                                        <i class="fa-regular fa-calendar"></i>{{ $fmtDate }}
                                    </span>
                                    <span class="rec-meta-chip">
                                        <i class="fa-regular fa-clock"></i>{{ $fmtTime }}
                                    </span>
                                </div>
                            </div>
                            <button type="button" class="rec-btn" onclick="openRecordModal(this)"
                                data-service="{{ $record->service_type }}" data-date="{{ $apptDate->format('F d, Y') }}"
                                data-time="{{ $fmtRange }}" data-status="completed"
                                data-duration="{{ $record->duration ?? '—' }}"
                                data-remarks="{{ $record->remarks ?? '' }}"
                                data-oral="{{ $record->oral_examination ?? '' }}"
                                data-diagnosis="{{ $record->diagnosis ?? '' }}"
                                data-prescription="{{ $record->prescription ?? '' }}">
                                <i class="fa-regular fa-eye"></i> Details
                            </button>
                        </div>

                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-icon-wrap">
                        <i class="fa-solid fa-tooth"></i>
                    </div>
                    <p class="empty-title">No records yet</p>
                    <p class="empty-sub">Completed appointment records will appear here after your first dental
                        visit.</p>
                    <a href="{{ route('patient.book.appointment') }}"
                        class="mt-6 inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#8B0000] text-white text-sm font-semibold hover:bg-[#660000] transition-colors shadow-md">
                        <i class="fa-solid fa-calendar-plus text-xs"></i> Book Appointment
                    </a>
                </div>

                @endif

            </div>

        </div>
    </main>

    <!-- ══════ FOOTER ══════ -->
    <footer class="footer bg-[#8B0000] text-[#F4F4F4] p-6">
        <div
            class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 text-sm text-center">
            <span><span class="text-gray-300">© 2025–2026</span> <span class="font-semibold">Polytechnic University of
                    the
                    Philippines</span></span>
            <span class="hidden sm:inline">|</span>
            <a href="https://www.pup.edu.ph/terms/" class="hover:underline">Terms of Use</a>
            <span class="hidden sm:inline">|</span>
            <a href="https://www.pup.edu.ph/privacy/" class="hover:underline">Privacy Statement</a>
        </div>
    </footer>

    <!-- ══════ RECORD MODAL ══════ -->
    <dialog id="record_modal">
        <div class="modal-inner">

            <!-- Header -->
            <div class="modal-head">
                <div class="drag-pill"></div>
                <div class="modal-head-top">
                    <div style="position:relative;z-index:1;">
                        <p class="modal-eyebrow">Dental Record</p>
                        <h3 class="modal-title" id="m_service">—</h3>
                    </div>
                    <button class="modal-close-btn" id="modalCloseBtn" type="button">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-meta-strip">
                    <span class="modal-meta-chip"><i class="fa-regular fa-calendar"></i> <span
                            id="m_date">—</span></span>
                    <span class="modal-meta-chip"><i class="fa-regular fa-clock"></i> <span id="m_time">—</span></span>
                </div>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <!-- Status + Duration chips -->
                <div class="chip-row">
                    <div class="chip-box">
                        <div class="chip-lbl"><i class="fa-solid fa-circle-check"
                                style="color:#15803d;font-size:9px;"></i> Status
                        </div>
                        <span id="m_status" class="chip-val bg-emerald-100 text-emerald-800">—</span>
                    </div>
                    <div class="chip-box">
                        <div class="chip-lbl"><i class="fa-regular fa-clock" style="font-size:9px;"></i> Duration
                        </div>
                        <span id="m_duration" class="chip-val bg-gray-100 text-gray-700">—</span>
                    </div>
                </div>

                <!-- Treatment -->
                <div class="msec">
                    <div class="msec-head"><span class="msec-lbl">Treatment</span>
                        <div class="msec-rule"></div>
                    </div>
                    <div class="msec-card">
                        <div class="msec-accent"></div>
                        <div class="msec-text"><span id="m_remarks">—</span></div>
                    </div>
                </div>

                <!-- Oral Examination -->
                <div class="msec">
                    <div class="msec-head"><span class="msec-lbl">Oral Examination</span>
                        <div class="msec-rule"></div>
                    </div>
                    <div class="msec-card">
                        <div class="msec-accent"></div>
                        <div class="msec-text"><span id="m_oral">—</span></div>
                    </div>
                </div>

                <!-- Diagnosis -->
                <div class="msec">
                    <div class="msec-head"><span class="msec-lbl">Diagnosis</span>
                        <div class="msec-rule"></div>
                    </div>
                    <div class="msec-card">
                        <div class="msec-accent"></div>
                        <div class="msec-text"><span id="m_diagnosis">—</span></div>
                    </div>
                </div>

                <!-- Prescription -->
                <div class="msec">
                    <div class="msec-head"><span class="msec-lbl">Prescription</span>
                        <div class="msec-rule"></div>
                    </div>
                    <div class="msec-card">
                        <div class="msec-accent"></div>
                        <div class="msec-text"><span id="m_prescription">—</span></div>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="modal-close-main" id="modalCloseFooter">Close</button>
            </div>

        </div>
    </dialog>

    <script>
        /* ── THEME ── */
        var html = document.documentElement;
        var ttc = document.getElementById("themeToggle");
        var tind = ttc.querySelector(".theme-indicator");
        var topts = ttc.querySelectorAll(".theme-option");

        function applyTheme(t) {
            html.setAttribute("data-theme", t);
            localStorage.setItem("theme", t);
            topts.forEach(function (o) {
                o.classList.toggle("active", o.getAttribute("data-theme") === t);
            });
            tind.classList.toggle("dark-mode", t === "dark");
            var fi = document.getElementById("darkModeFabIcon");
            if (fi) fi.className = t === "dark" ? "fa-solid fa-sun" : "fa-solid fa-moon";
        }
        applyTheme(localStorage.getItem("theme") || "light");
        topts.forEach(function (o) {
            o.addEventListener("click", function () {
                applyTheme(o.getAttribute("data-theme"));
            });
        });

        /* ── SIDEBAR ── */
        var sidebarOpen = true;

        function applyLayout(w) {
            document.getElementById('sidebar').style.width = w;
            document.getElementById('mainContent').style.marginLeft = w;
        }

        function toggleSidebar() {
            var s = document.getElementById('sidebar'),
                tx = document.querySelectorAll('.sidebar-text');
            var ic = document.getElementById('sidebarIcon'),
                wr = document.getElementById('sidebarToggleWrapper');
            sidebarOpen = !sidebarOpen;
            if (sidebarOpen) {
                applyLayout('220px');
                s.classList.replace('collapsed', 'expanded');
                tx.forEach(function (t) {
                    t.classList.remove('opacity-0', 'w-0');
                    t.classList.add('opacity-100');
                });
                wr.classList.replace('justify-center', 'justify-end');
                ic.classList.replace('fa-bars', 'fa-xmark');
            } else {
                applyLayout('72px');
                s.classList.replace('expanded', 'collapsed');
                tx.forEach(function (t) {
                    t.classList.add('opacity-0', 'w-0');
                    t.classList.remove('opacity-100');
                });
                wr.classList.replace('justify-end', 'justify-center');
                ic.classList.replace('fa-xmark', 'fa-bars');
            }
            applyTheme(localStorage.getItem("theme") || "light");
        }

        /* ── MOBILE PROFILE ── */
        function toggleMobileProfile() {
            var p = document.getElementById('mobileProfileAccordion'),
                c = document.getElementById('mobileProfileChevron');
            var o = p.classList.contains('open');
            p.classList.toggle('open', !o);
            if (c) c.style.transform = o ? 'rotate(0deg)' : 'rotate(180deg)';
        }

        /* ── RECORD MODAL ── */
        var recModal = document.getElementById('record_modal');

        function openRecordModal(btn) {
            document.getElementById('m_service').textContent = btn.dataset.service || '—';
            document.getElementById('m_date').textContent = btn.dataset.date || '—';
            document.getElementById('m_time').textContent = btn.dataset.time || '—';

            var st = (btn.dataset.status || 'completed').trim().toLowerCase();
            var sEl = document.getElementById('m_status');
            sEl.textContent = st.charAt(0).toUpperCase() + st.slice(1);
            sEl.className = 'chip-val';
            if (st === 'completed') sEl.classList.add('bg-emerald-100', 'text-emerald-800');
            else if (st === 'rescheduled') sEl.classList.add('bg-yellow-100', 'text-yellow-800');
            else if (st === 'cancelled') sEl.classList.add('bg-red-100', 'text-red-800');
            else sEl.classList.add('bg-gray-100', 'text-gray-700');

            var dEl = document.getElementById('m_duration');
            dEl.textContent = (btn.dataset.duration || '—').trim();
            dEl.className = 'chip-val bg-gray-100 text-gray-700';

            document.getElementById('m_remarks').textContent = (btn.dataset.remarks || '').trim() || '—';
            document.getElementById('m_oral').textContent = (btn.dataset.oral || '').trim() || '—';
            document.getElementById('m_diagnosis').textContent = (btn.dataset.diagnosis || '').trim() || '—';
            document.getElementById('m_prescription').textContent = (btn.dataset.prescription || '').trim() || '—';

            recModal.showModal();
        }

        function closeRecModal() {
            recModal.close();
        }

        /* ── DOM READY ── */
        document.addEventListener('DOMContentLoaded', function () {
            if (window.innerWidth >= 768) {
                sidebarOpen = true;
                applyLayout('220px');
            } else {
                document.getElementById('mainContent').style.marginLeft = '0';
            }

            document.getElementById('modalCloseBtn').addEventListener('click', closeRecModal);
            document.getElementById('modalCloseFooter').addEventListener('click', closeRecModal);

            recModal.addEventListener('click', function (e) {
                var r = recModal.getBoundingClientRect();
                if (e.clientX < r.left || e.clientX > r.right || e.clientY < r.top || e.clientY > r.bottom)
                    closeRecModal();
            });

            /* Mobile FAB */
            var mf = document.getElementById('mobFab'),
                mm = document.getElementById('mobFabMenu');
            if (mf && mm) {
                mf.addEventListener('click', function (e) {
                    e.stopPropagation();
                    var o = mm.classList.contains('open');
                    mm.classList.toggle('open', !o);
                    mf.classList.toggle('open', !o);
                });
                mm.addEventListener('click', function (e) {
                    e.stopPropagation();
                });
            }

            /* Notifications */
            var nb = document.getElementById("notifBtn"),
                nm = document.getElementById("notifMenu");
            if (nb && nm) {
                nb.addEventListener("click", function (e) {
                    e.stopPropagation();
                    nm.classList.toggle("open");
                });
                nm.addEventListener("click", function (e) {
                    e.stopPropagation();
                });
                document.addEventListener("keydown", function (e) {
                    if (e.key === "Escape") nm.classList.remove("open");
                });
            }

            /* Outside clicks */
            document.addEventListener('click', function (e) {
                if (mm) {
                    mm.classList.remove('open');
                    if (mf) mf.classList.remove('open');
                }
                if (nm) nm.classList.remove('open');
                var panel = document.getElementById('mobileProfileAccordion');
                var toggle = document.getElementById('mobileProfileToggle');
                var chev = document.getElementById('mobileProfileChevron');
                if (panel && toggle && !panel.contains(e.target) && !toggle.contains(e.target)) {
                    panel.classList.remove('open');
                    if (chev) chev.style.transform = 'rotate(0deg)';
                }
            });
        });
    </script>

</body>

</html>