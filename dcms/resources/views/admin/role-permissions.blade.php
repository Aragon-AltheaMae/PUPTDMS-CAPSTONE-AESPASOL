<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Role Permissions | PUP Taguig Dental Clinic</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            daisyui: {
                themes: false
            }
        }
    </script>

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F8F6F3;
            color: #2D2420;
            margin: 0;
        }

        /* ── Scrollbar ── */
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

        /* ── HEADER  ── */
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
            height: calc(100vh - 62px);
            background: #fff;
            box-shadow: 2px 0 20px rgba(0, 0, 0, .07);
            z-index: 40;
            display: flex;
            flex-direction: column;
            transition: width .3s cubic-bezier(.4, 0, .2, 1);
            overflow: hidden;
        }

        #sidebar.expanded {
            width: 240px;
        }

        #sidebar.collapsed {
            width: 68px;
        }

        /* Scrollable inner */
        .sidebar-inner {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 10px 0 6px;
        }

        .sidebar-inner::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-inner::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 4px;
        }

        /* Toggle row */
        .sidebar-toggle-row {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 6px 12px 10px;
            border-bottom: 1px solid #f3f4f6;
            margin-bottom: 4px;
        }

        #sidebar.collapsed .sidebar-toggle-row {
            justify-content: center;
        }

        .toggle-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            color: #6b7280;
            background: #f9fafb;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
        }

        .toggle-btn:hover {
            background: #fee2e2;
            color: #8B0000;
        }



        /* ── ACCORDION GROUP ── */
        .nav-group {
            margin: 0 8px 2px;
        }

        .group-header {
            display: flex;
            align-items: center;
            width: 100%;
            border: none;
            background: none;
            cursor: pointer;
            padding: 7px 8px;
            border-radius: 10px;
            transition: background .15s;
            color: #6b7280;
        }

        .group-header:hover {
            background: #fef2f2;
            color: #8B0000;
        }

        .group-header.active-group {
            background: #fef2f2;
            color: #8B0000;
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
            transition: all .2s;
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
            font-size: .78rem;
            font-weight: 700;
            white-space: nowrap;
            line-height: 1.2;
            display: block;
        }

        .group-sublabel {
            font-size: .63rem;
            color: #9ca3af;
            white-space: nowrap;
            display: block;
            margin-top: 1px;
        }

        .group-chevron {
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            transition: transform .25s;
            flex-shrink: 0;
        }

        .group-chevron.open {
            transform: rotate(180deg);
        }

        /* Hide label/chevron when collapsed */
        #sidebar.collapsed .group-label-wrap {
            display: none;
        }

        #sidebar.collapsed .group-chevron {
            display: none;
        }

        /* Accordion body */
        .group-body {
            overflow: hidden;
            max-height: 0;
            transition: max-height .3s cubic-bezier(.4, 0, .2, 1);
        }

        .group-body.open {
            max-height: 500px;
        }

        #sidebar.collapsed .group-body {
            max-height: 0 !important;
        }

        /* Nav links inside accordion */
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

        /* Separator */
        .nav-sep {
            height: 1px;
            background: #f3f4f6;
            margin: 6px 12px;
        }

        /* ── FLYOUT (collapsed state) ── */
        .flyout-wrapper {
            position: relative;
        }

        .flyout-panel {
            position: fixed;
            left: 76px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .13);
            border: 1px solid #f0e6e6;
            min-width: 200px;
            padding: 6px;
            opacity: 0;
            transform: scale(.95) translateX(-6px);
            pointer-events: none;
            transition: all .2s cubic-bezier(.4, 0, .2, 1);
            transform-origin: left center;
            z-index: 999;
        }

        .flyout-panel.open {
            opacity: 1;
            transform: scale(1) translateX(0);
            pointer-events: auto;
        }

        .flyout-title {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: #8B0000;
            padding: 4px 8px 6px;
            border-bottom: 1px solid #fde8e8;
            margin-bottom: 4px;
        }

        .flyout-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 10px;
            border-radius: 8px;
            font-size: .77rem;
            font-weight: 500;
            color: #374151;
            text-decoration: none;
            transition: all .15s;
            white-space: nowrap;
        }

        .flyout-link:hover {
            background: #fef2f2;
            color: #8B0000;
        }

        .flyout-link i {
            width: 16px;
            text-align: center;
            font-size: 12px;
            color: #8B0000;
        }

        /* ── SIDEBAR BOTTOM ── */
        .sidebar-bottom {
            padding: 8px 8px 12px;
            border-top: 1px solid #f3f4f6;
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
            transform: translateX(calc(100% + 0px));
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

        #sidebar.collapsed .logout-btn {
            justify-content: center;
            padding: 8px;
        }

        #sidebar.collapsed .logout-text {
            display: none;
        }

        #sidebar.collapsed .settings-label {
            display: none;
        }

        /* ── LAYOUT TRANSITIONS ── */
        body,
        main,
        footer {
            transition: background-color .3s ease, color .3s ease;
        }

        #mainContent,
        footer {
            transition: margin-left .3s cubic-bezier(.4, 0, .2, 1);
        }

        /* ── DARK THEME ── */
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

        [data-theme="dark"] .sidebar-brand-text {
            color: #f87171;
        }

        /* ── Role cards ── */
        .role-card {
            background: #FDFCFB;
            border: 1.5px solid #EDE8E2;
            border-radius: 14px;
            padding: 14px 16px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(.4, 0, .2, 1);
        }

        .role-card:hover {
            transform: translateX(3px);
        }

        .role-card.active {
            background: #fff;
            border-color: #7B0D0D;
            box-shadow: 0 4px 20px rgba(123, 13, 13, 0.12);
        }

        .role-avatar {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
            flex-shrink: 0;
            transition: all 0.2s;
            background: #F0EBE6;
            color: #8A7A6F;
        }

        .role-card.active .role-avatar {
            background: linear-gradient(135deg, #7B0D0D, #9B1515);
            color: #fff;
            box-shadow: 0 4px 10px rgba(123, 13, 13, 0.3);
        }

        .badge-pill {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .progress-bar {
            height: 5px;
            background: #EDE8E2;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 0.4s ease;
        }

        .role-card.active .progress-fill {
            background: linear-gradient(90deg, #7B0D0D, #C9973A);
        }

        /* ── Permission group card ── */
        .group-card {
            background: #fff;
            border: 1.5px solid #EDE8E2;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        .group-header {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            background: #FDFCFB;
            cursor: pointer;
            transition: background 0.15s;
            user-select: none;
        }

        .group-header:hover {
            background: #FAF4EF;
        }

        .group-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
            margin-right: 14px;
        }

        /* Dot progress */
        .dot-row {
            display: flex;
            gap: 3px;
            align-items: center;
        }

        .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #E5DDD5;
            transition: background 0.2s;
        }

        .dot.on {
            /* set via inline style per group color */
        }

        /* All-toggle area */
        .all-toggle-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #F5EFE9;
            border-radius: 8px;
            padding: 5px 12px;
            cursor: pointer;
        }

        /* Toggle switch */
        .toggle-switch {
            position: relative;
            width: 46px;
            height: 26px;
            display: inline-block;
            flex-shrink: 0;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }

        .toggle-track {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background: #F9FAFB;
            border: 2px solid #E5E7EB;
            border-radius: 13px;
            transition: all 0.25s cubic-bezier(.4, 0, .2, 1);
        }

        .toggle-track::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #D1D5DB;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.25);
            transition: left 0.25s cubic-bezier(.4, 0, .2, 1), background 0.2s;
        }

        .toggle-switch input:checked+.toggle-track {
            background: linear-gradient(135deg, #7B0D0D, #9B1515);
            border-color: #7B0D0D;
            box-shadow: 0 0 0 3px rgba(123, 13, 13, 0.13);
        }

        .toggle-switch input:checked+.toggle-track::after {
            left: 22px;
            background: #fff;
        }

        .toggle-switch.disabled .toggle-track {
            cursor: not-allowed;
            opacity: 0.45;
        }

        /* Permission row */
        .perm-row {
            display: flex;
            align-items: center;
            padding: 12px 20px 12px 70px;
            border-bottom: 1px solid #F5F0EB;
            transition: background 0.15s;
        }

        .perm-row:last-child {
            border-bottom: none;
        }

        .perm-row:hover {
            background: #FAF6F0;
        }

        /* Status badge */
        .status-granted {
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .status-denied {
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
            background: #F5F0EB;
            color: #B5A99A;
        }

        /* Group body collapse */
        .group-body {
            border-top: 1px solid #F0EBE6;
            overflow: hidden;
            transition: max-height 0.35s ease, opacity 0.25s ease;
            max-height: 9999px;
            opacity: 1;
        }

        .group-body.collapsed {
            max-height: 0;
            opacity: 0;
            border-top: none;
        }

        /* Chevron */
        .chevron {
            transition: transform 0.2s;
            color: #B5A99A;
            font-size: 11px;
        }

        .chevron.collapsed {
            transform: rotate(180deg);
        }

        /* Footer bar */
        .footer-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            background: #fff;
            border-radius: 14px;
            border: 1.5px solid #EDE8E2;
            margin-top: 18px;
        }

        /* Buttons */
        .btn-reset {
            background: #F5EFE9;
            color: #6B5E56;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background 0.15s;
        }

        .btn-reset:hover {
            background: #EDE5DA;
        }

        .btn-save {
            background: linear-gradient(135deg, #7B0D0D, #9B1515);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 28px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 14px rgba(123, 13, 13, 0.25);
            transition: all 0.2s;
        }

        .btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(123, 13, 13, 0.35);
        }

        /* Search */
        .search-input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            border: 1.5px solid #EDE8E2;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            background: #fff;
            outline: none;
            color: #2D2420;
            transition: border-color 0.18s;
        }

        .search-input:focus {
            border-color: #7B0D0D;
        }

        /* Collapse/expand btn */
        .btn-collapse {
            padding: 10px 16px;
            border: 1.5px solid #EDE8E2;
            border-radius: 10px;
            background: #fff;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            color: #6B5E56;
            white-space: nowrap;
            transition: background 0.15s;
        }

        .btn-collapse:hover {
            background: #F5EFE9;
        }

        /* Super admin banner */
        .protected-banner {
            background: linear-gradient(135deg, #FEF3C7, #FDE68A);
            border: 1px solid #FCD34D;
            border-radius: 12px;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        /* Accent summary card */
        .accent-card {
            background: linear-gradient(135deg, #7B0D0D 0%, #9B1515 100%);
            border-radius: 14px;
            padding: 18px 20px;
            color: #fff;
            margin-top: 16px;
        }

        /* Fade-in on load */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeUp 0.45s ease both;
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 5, 5, 0.55);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 200;
            backdrop-filter: blur(4px);
        }

        .modal-box {
            background: #fff;
            border-radius: 20px;
            padding: 36px 36px 28px;
            width: 420px;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>

<body>

    <!-- ════════════════ HEADER  ════════════════ -->
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
                    <div style="padding:.85rem 1rem .65rem; font-weight:700; color:#8B0000; font-size:.82rem; border-bottom:1px solid #f5e8e8;">Notifications</div>
                    <div style="max-height:260px; overflow-y:auto;">
                        @forelse($notifications as $n)
                        <a href="{{ $n['url'] ?? '#' }}" style="display:block; padding:.65rem 1rem; font-size:.78rem; color:#333; text-decoration:none; border-bottom:1px solid #fdf5f5;">
                            <div style="font-weight:600;">{{ $n['title'] ?? 'Notification' }}</div>
                            @if(!empty($n['message']))<div style="color:#aaa; margin-top:2px;">{{ $n['message'] }}</div>@endif
                        </a>
                        @empty
                        <div style="padding:2rem 1rem; text-align:center; color:#bbb; font-size:.78rem;">You're all caught up.</div>
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

    <!-- SIDEBAR -->
    <aside id="sidebar" class="expanded">

        <!-- Toggle pinned above scroll area -->
        <div class="sidebar-toggle-row">
            <button class="toggle-btn" onclick="toggleSidebar()" id="sidebarToggleBtn">
                <i id="sidebarIcon" class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <div class="sidebar-inner">

            <div class="nav-group flyout-wrapper" id="group-cms">
                <div class="group-header active-group" onclick="toggleGroup('cms', event)">
                    <div class="group-icon"><i class="fa-solid fa-hospital"></i></div>
                    <div class="group-label-wrap">
                        <span class="group-label">Clinic Management</span>
                        <span class="group-sublabel">Core clinical modules</span>
                    </div>
                    <i class="fa-solid fa-chevron-down group-chevron" id="chevron-cms"></i>
                </div>
                <div class="group-body open" id="body-cms">
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-users"></i> Patients</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-school"></i> Academic Periods</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-file-circle-check"></i> Document Requests</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-file-pen"></i> Document Template</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-file"></i> Reports</a>
                </div>
                <div class="flyout-panel" id="flyout-cms">
                    <div class="flyout-title">Clinic Management</div>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i class="fa-solid fa-users"></i> Patients</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i class="fa-solid fa-school"></i> Academic Periods</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i class="fa-solid fa-file-circle-check"></i> Document Requests</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i class="fa-solid fa-file-pen"></i> Document Template</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i class="fa-solid fa-file"></i> Reports</a>
                </div>
            </div>

            <div class="nav-sep"></div>

            <div class="nav-group flyout-wrapper" id="group-sys">
                <div class="group-header active-group" onclick="toggleGroup('sys', event)">
                    <div class="group-icon"><i class="fa-solid fa-server"></i></div>
                    <div class="group-label-wrap">
                        <span class="group-label">System</span>
                        <span class="group-sublabel">Admin &amp; configuration</span>
                    </div>
                    <i class="fa-solid fa-chevron-down group-chevron" id="chevron-sys"></i>
                </div>
                <div class="group-body open" id="body-sys">
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-database"></i> Data Backup</a>
                    <a href="{{ route('admin.system_logs') }}" class="nav-link {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}"><i class="fa-solid fa-clipboard-list"></i> System Logs</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-gear"></i> System Settings</a>
                    <a href="{{ route('admin.role_permissions') }}" class="nav-link {{ request()->routeIs('admin.role_permissions') ? 'active' : '' }}"><i class="fa-solid fa-user-shield"></i> Roles &amp; Permissions</a>
                </div>
                <div class="flyout-panel" id="flyout-sys">
                    <div class="flyout-title">System</div>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i class="fa-solid fa-database"></i> Data Backup</a>
                    <a href="{{ route('admin.system_logs') }}" class="flyout-link"><i class="fa-solid fa-clipboard-list"></i> System Logs</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i class="fa-solid fa-gear"></i> System Settings</a>
                    <a href="{{ route('admin.role_permissions') }}" class="flyout-link"><i class="fa-solid fa-user-shield"></i> Roles &amp; Permissions</a>
                </div>
            </div>
        </div><!-- /sidebar-inner -->

        <div class="sidebar-bottom">
            <div class="text-[.65rem] font-semibold tracking-widest text-gray-400 uppercase mb-2 px-1 settings-label">Settings</div>
            <div class="w-full px-1 mb-3">
                <div id="themeToggle" class="theme-toggle-container">
                    <button type="button" class="theme-option active" data-theme="light"><i class="fa-solid fa-sun"></i></button>
                    <button type="button" class="theme-option" data-theme="dark"><i class="fa-regular fa-moon"></i></button>
                    <div class="theme-indicator" aria-hidden="true"></div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <span style="width:30px;height:30px;background:#fef2f2;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa-solid fa-right-from-bracket text-sm"></i>
                    </span>
                    <span class="logout-text font-semibold">Log out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ════════════════ MAIN  ════════════════ -->
    <main id="mainContent" class="pt-[100px] px-6 py-6 fade-up min-h-screen" style="margin-left:240px;">
        <div class="max-w-7xl mt-4 mx-auto fade-in">

            @if(session('success'))
            <div style="background:#F0FDF4; border:1px solid #BBF7D0; border-radius:12px; padding:12px 18px; margin-bottom:20px; display:flex; align-items:center; gap:10px; font-size:14px; font-weight:600; color:#166534;">
                <i class="fa-solid fa-circle-check" style="color:#22C55E;"></i> {{ session('success') }}
            </div>
            @endif

            <!-- Page title -->
            <div style="display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:28px; gap:12px; flex-wrap:wrap;">
                <div>
                    <div style="font-size:11px; color:#B5A99A; letter-spacing:2px; text-transform:uppercase; margin-bottom:6px; font-weight:600;">System Administration</div>
                    <h1 style="margin:0; font-size:30px; font-weight:800; color:#7B0D0D; line-height:1;">Role &amp; Permissions</h1>
                    <p style="margin:8px 0 0; font-size:14px; color:#8A7A6F;">Define what each role can see and do across the clinic system.</p>
                </div>

                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">


                    <button onclick="document.getElementById('newRoleModal').style.display='flex'"
                        style="background:linear-gradient(135deg,#7B0D0D,#9B1515);color:#fff;border:none;border-radius:10px;padding:11px 22px;font-weight:700;font-size:14px;cursor:pointer;font-family:'Inter',sans-serif;display:flex;align-items:center;gap:8px;box-shadow:0 4px 14px rgba(123,13,13,0.25);transition:all 0.2s;"
                        onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 8px 24px rgba(123,13,13,0.35)'"
                        onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(123,13,13,0.25)'">
                        <i class="fa-solid fa-plus" style="font-size:13px;"></i> New Role
                    </button>
                </div>
            </div>

            <!-- Two-column grid -->
            <div style="display:grid; grid-template-columns:280px 1fr; gap:24px; align-items:start;">

                <!-- ══ LEFT: Role Cards ══════════════════════ -->
                <div>
                    @php
                    // Badge resolved by role name/slug — not positional
                    function getRoleBadge($name, $slug) {
                    $n = strtolower($name); $s = strtolower($slug);
                    if (str_contains($n,'super')||str_contains($s,'super')) return ['badgeColor'=>'#7B0D0D','label'=>'Full Access'];
                    if (str_contains($n,'dentist')||str_contains($s,'dentist')) return ['badgeColor'=>'#B45309','label'=>'Clinical'];
                    if (str_contains($n,'staff')||str_contains($s,'staff')||str_contains($n,'clinic')) return ['badgeColor'=>'#065F46','label'=>'Front Desk'];
                    if (str_contains($n,'student')||str_contains($s,'student')||str_contains($n,'patient')||str_contains($s,'patient')) return ['badgeColor'=>'#4B5563','label'=>'Limited'];
                    return ['badgeColor'=>'#6B7280','label'=>'Custom'];
                    }
                    $paletteColors = ['#7B0D0D','#B45309','#065F46','#4B5563','#1D4ED8','#6D28D9'];
                    $totalPerms = $groupedPermissions->flatten()->count();
                    $firstRoleId = $roles->first()->id ?? null;
                    @endphp

                    <div style="font-size:11px; color:#B5A99A; letter-spacing:2px; text-transform:uppercase; margin-bottom:12px; font-weight:600;">
                        Roles ({{ $roles->count() }})
                    </div>

                    <div style="display:flex; flex-direction:column; gap:8px;">
                        @foreach($roles as $i => $role)
                        @php
                        $c = getRoleBadge($role->name, $role->slug);
                        $granted = $role->permissions->count();
                        $pct = $totalPerms > 0 ? round(($granted / $totalPerms) * 100) : 0;
                        $words = array_slice(explode(' ', $role->name), 0, 2);
                        $initials = '';
                        foreach ($words as $_w) { $initials .= strtoupper($_w[0]); }
                        $isFirst = $i === 0;
                        @endphp
                        <div class="role-card {{ $isFirst ? 'active' : '' }}"
                            data-role-id="{{ $role->id }}"
                            data-role-name="{{ $role->name }}"
                            data-granted="{{ $granted }}"
                            data-total="{{ $totalPerms }}"
                            data-pct="{{ $pct }}"
                            data-slug="{{ $role->slug }}"
                            onclick="selectRole(this)">

                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="role-avatar">{{ $initials }}</div>
                                <div style="flex:1;">
                                    <div style="display:flex; align-items:center; gap:7px; margin-bottom:3px;">
                                        <span style="font-weight:600; font-size:14px; color:#2D2420;" class="role-name-label">{{ $role->name }}</span>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                                        <span class="badge-pill" style="background:{{ $c['badgeColor'] }}18; color:{{ $c['badgeColor'] }}; border:1px solid {{ $c['badgeColor'] }}40; white-space:nowrap;">{{ $c['label'] }}</span>
                                        <span style="font-size:11px; color:#B5A99A; white-space:nowrap;">{{ $role->slug }}</span>
                                    </div>
                                </div>
                                <div class="active-dot" style="width:8px; height:8px; border-radius:50%; background:#7B0D0D; flex-shrink:0; display:{{ $isFirst ? 'block' : 'none' }};"></div>
                            </div>

                            <div style="margin-top:12px;">
                                <div style="display:flex; justify-content:space-between; font-size:11px; color:#B5A99A; margin-bottom:5px;">
                                    <span>Access level</span>
                                    <span style="font-weight:600;" class="pct-label">{{ $pct }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width:{{ $pct }}%; background:#C4B8AF;"></div>
                                </div>
                                <div style="font-size:11px; color:#C4B8AF; margin-top:4px;" class="count-label">{{ $granted }} of {{ $totalPerms }} permissions</div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Accent summary card -->
                    <div class="accent-card" id="accentCard">
                        <div style="font-size:16px; font-weight:700; margin-bottom:4px;" id="accentRoleName">{{ $roles->first()->name ?? '' }}</div>
                        <div style="font-size:28px; font-weight:700; margin-bottom:2px;" id="accentPct">
                            @php $fr = $roles->first(); $fp = $fr ? ($totalPerms > 0 ? round(($fr->permissions->count()/$totalPerms)*100) : 0) : 0; @endphp
                            {{ $fp }}%
                        </div>
                        <div style="font-size:12px; opacity:0.75; margin-bottom:14px;" id="accentCount">
                            {{ $fr?->permissions->count() ?? 0 }} of {{ $totalPerms }} permissions active
                        </div>
                        <div style="height:6px; background:rgba(255,255,255,0.2); border-radius:10px;">
                            <div id="accentBar" style="height:100%; width:{{ $fp }}%; background:#C9973A; border-radius:10px; transition:width 0.4s;"></div>
                        </div>
                    </div>
                </div>

                <!-- ══ RIGHT: Permission Editor ══════════════ -->
                <div>
                    <!-- Toolbar -->
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:18px; flex-wrap:wrap;">
                        <div style="flex:1; position:relative; min-width:180px;">
                            <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#B5A99A; font-size:13px;"></i>
                            <input type="text" id="permSearch" placeholder="Search permissions…"
                                class="search-input" oninput="filterPerms(this.value)">
                        </div>
                        <button type="button" class="btn-collapse" id="collapseBtn" onclick="toggleAllGroups()">Collapse All</button>
                        <form action="{{ route('admin.role_permissions.reset') }}" method="POST" style="display:contents;">
                            @csrf
                            <button type="submit" class="btn-reset" style="border:1.5px solid #EDE8E2;">
                                <i class="fa-solid fa-rotate-left" style="font-size:12px; margin-right:4px;"></i> Reset Defaults
                            </button>
                        </form>
                    </div>

                    <!-- Super Admin banner (shown when Super Admin is selected) -->
                    <div class="protected-banner" id="protectedBanner" style="display:none;">
                        <i class="fa-solid fa-shield-halved" style="font-size:20px; color:#92400E;"></i>
                        <div>
                            <div style="font-weight:700; font-size:13px; color:#78350F;">Protected Role</div>
                            <div style="font-size:12px; color:#92400E;">Super Admin has unrestricted access and cannot be modified.</div>
                        </div>
                    </div>

                    <!-- Permission groups — one hidden form per role, shown/hidden by JS -->
                    @foreach($roles as $ri => $role)
                    @php
                    $isSuper = $ri === 0; // first role = super admin (adjust if needed by slug)
                    // More accurate: check by slug
                    // Match all common super admin slug/name variants including underscores
                    $isSuperRole = in_array(strtolower($role->slug), ['super_admin','super-admin','superadmin'])
                    || str_contains(strtolower($role->name), 'super');

                    $micons = [
                    'Dashboard' => ['fa-chart-line', '#7B0D0D'],
                    'Patients' => ['fa-users', '#B45309'],
                    'Appointments' => ['fa-calendar-check', '#065F46'],
                    'Document Requests' => ['fa-file-circle-check','#1D4ED8'],
                    'Document Template' => ['fa-file-pen', '#6D28D9'],
                    'Reports' => ['fa-chart-column', '#6D28D9'],
                    'Academic Periods' => ['fa-school', '#065F46'],
                    'Data Backup' => ['fa-database', '#EA580C'],
                    'System Logs' => ['fa-clipboard-list', '#6D28D9'],
                    'System Settings' => ['fa-gear', '#374151'],
                    ];
                    $mcolors = ['#7B0D0D','#B45309','#065F46','#1D4ED8','#6D28D9','#374151','#EA580C'];
                    @endphp
                    <form id="form-role-{{ $role->id }}"
                        class="role-form"
                        data-role-id="{{ $role->id }}"
                        action="{{ route('admin.role_permissions.update') }}"
                        method="POST"
                        style="display:{{ $ri === 0 ? 'block' : 'none' }};">
                        @csrf

                        <div style="display:flex; flex-direction:column; gap:10px;" class="groups-container">

                            @forelse($groupedPermissions as $module => $permissions)
                            @php
                            [$ico, $icol] = $micons[$module] ?? ['fa-shield-halved', '#374151'];
                            $mSlug = Str::slug($module);
                            $mTotal = $permissions->count();
                            $roleGranted = 0;
                            foreach ($permissions as $_p) {
                            if ($role->permissions->contains('id', $_p->id)) $roleGranted++;
                            }
                            $allOn = $roleGranted === $mTotal;
                            @endphp

                            <div class="group-card perm-group" data-group="{{ strtolower($module) }}">

                                <!-- Group header -->
                                <div class="group-header" onclick="toggleGroup(this)">
                                    <div class="group-icon" style="background:{{ $icol }}15; color:{{ $icol }}; border:1px solid {{ $icol }}25;">
                                        <i class="fa-solid {{ $ico }}"></i>
                                    </div>
                                    <div style="flex:1;">
                                        <div style="font-weight:700; font-size:14px; color:#2D2420;">{{ $module }}</div>
                                        <div style="font-size:12px; color:#B5A99A;" class="group-count">{{ $roleGranted }} of {{ $mTotal }} enabled</div>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:14px;">
                                        <!-- Dot progress -->
                                        <div class="dot-row" id="dots-{{ $role->id }}-{{ $mSlug }}">
                                            @for($d = 0; $d < $mTotal; $d++)
                                                <div class="dot {{ $d < $roleGranted ? 'on' : '' }}" style="{{ $d < $roleGranted ? 'background:'.$icol.';' : '' }}">
                                        </div>
                                        @endfor
                                    </div>
                                    <!-- All toggle -->
                                    <div class="all-toggle-wrap" onclick="event.stopPropagation(); toggleGroupPerms(this, '{{ $role->id }}', '{{ $mSlug }}', {{ $allOn ? 'true' : 'false' }})">
                                        <span style="font-size:11px; color:#6B5E56; font-weight:600;">All</span>
                                        <label class="toggle-switch {{ $isSuperRole ? 'disabled' : '' }}" onclick="event.preventDefault();">
                                            <input type="checkbox" class="group-master"
                                                data-role="{{ $role->id }}"
                                                data-module="{{ $mSlug }}"
                                                {{ $allOn ? 'checked' : '' }}
                                                {{ $isSuperRole ? 'disabled' : '' }}>
                                            <span class="toggle-track"></span>
                                        </label>
                                    </div>
                                    <i class="fa-solid fa-chevron-up chevron"></i>
                                </div>
                            </div>

                            <!-- Permission rows -->
                            <div class="group-body">
                                @foreach($permissions as $pi => $permission)
                                @php $isGranted = $role->permissions->contains('id', $permission->id); @endphp
                                <div class="perm-row"
                                    style="{{ $isGranted ? 'background:'.$icol.'06;' : '' }}"
                                    data-perm-search="{{ strtolower($permission->name . ' ' . $permission->slug) }}">

                                    <div style="flex:1;">
                                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:2px;">
                                            <div class="perm-dot" style="width:7px; height:7px; border-radius:50%; flex-shrink:0; transition:background 0.2s; background:{{ $isGranted ? $icol : '#D5CEC8' }};"></div>
                                            <span style="font-weight:600; font-size:13px; color:{{ $isGranted ? '#2D2420' : '#8A7A6F' }};" class="perm-label">{{ $permission->name }}</span>
                                        </div>
                                        <div style="font-size:12px; color:#B5A99A; padding-left:15px;">{{ $permission->slug }}</div>
                                    </div>

                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <span class="perm-status {{ $isGranted ? 'status-granted' : 'status-denied' }}"
                                            style="{{ $isGranted ? 'background:'.$icol.'18; color:'.$icol.';' : '' }}">
                                            {{ $isGranted ? 'Granted' : 'Denied' }}
                                        </span>
                                        <label class="toggle-switch {{ $isSuperRole ? 'disabled' : '' }}">
                                            <input type="checkbox"
                                                name="permissions[{{ $role->id }}][]"
                                                value="{{ $permission->id }}"
                                                class="perm-toggle"
                                                data-role="{{ $role->id }}"
                                                data-module="{{ $mSlug }}"
                                                data-color="{{ $icol }}"
                                                {{ $isGranted ? 'checked' : '' }}
                                                {{ $isSuperRole ? 'disabled' : '' }}
                                                onchange="onPermChange(this)">
                                            <span class="toggle-track"></span>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @empty
                        <div style="text-align:center; padding:60px 20px;">
                            <div style="font-size:40px; opacity:0.2; margin-bottom:12px;">🛡️</div>
                            <p style="font-size:14px; font-weight:600; color:#8A7A6F;">No permissions found.</p>
                        </div>
                        @endforelse

                </div>

                <!-- Footer actions -->
                @if(!$isSuperRole)
                <div class="footer-bar">
                    <div style="font-size:13px; color:#8A7A6F;" id="footer-msg-{{ $role->id }}">
                        {{ $role->permissions->count() }} permissions enabled for {{ $role->name }}
                    </div>
                    <div style="display:flex; gap:10px;">
                        <button type="submit" class="btn-save">
                            <i class="fa-solid fa-floppy-disk" style="margin-right:6px; font-size:13px;"></i> Save Changes
                        </button>
                    </div>
                </div>
                @endif
                </form>
                @endforeach

            </div>
        </div>

        </div>
    </main>

    <!-- ════════════════ FOOTER  ════════════════ -->
    <footer id="siteFooter" class="footer bg-[#8B0000] text-[#F4F4F4] p-6 transition-all duration-300" style="margin-left:240px;">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 text-sm text-center">
            <span><span class="text-gray-300">© 2025–2026</span> <span class="font-semibold">Polytechnic University of the Philippines</span></span>
            <span class="hidden sm:inline">|</span>
            <a href="https://www.pup.edu.ph/terms/" class="hover:underline">Terms of Use</a>
            <span class="hidden sm:inline">|</span>
            <a href="https://www.pup.edu.ph/privacy/" class="hover:underline">Privacy Statement</a>
        </div>
    </footer>

    <!-- ══ SCRIPTS ═════════════════════════════════════════════ -->
    <script>
        // ── Sidebar state ──
        let sidebarExpanded = true;
        let openFlyout = null;

        function applyLayout(w) {
            document.getElementById('mainContent').style.marginLeft = w;
            document.getElementById('siteFooter').style.marginLeft = w;
        }

        function toggleSidebar() {
            sidebarExpanded = !sidebarExpanded;
            const sidebar = document.getElementById('sidebar');
            const icon = document.getElementById('sidebarIcon');

            if (sidebarExpanded) {
                sidebar.classList.replace('collapsed', 'expanded');
                applyLayout('240px');
                icon.className = 'fa-solid fa-xmark text-base';
                closeAllFlyouts();
            } else {
                sidebar.classList.replace('expanded', 'collapsed');
                applyLayout('68px');
                icon.className = 'fa-solid fa-bars text-base';
            }
        }

        // ── Accordion (expanded) / Flyout (collapsed) ── FIXED
        function toggleGroup(id, e) {
            e.stopPropagation();

            if (!sidebarExpanded) {
                // Collapsed mode → show flyout
                const btn = e.currentTarget;
                const flyout = document.getElementById('flyout-' + id);

                // Position flyout vertically aligned with the button
                const rect = btn.getBoundingClientRect();
                flyout.style.top = rect.top + 'px';

                // Close other flyouts
                if (openFlyout && openFlyout !== flyout) {
                    openFlyout.classList.remove('open');
                }

                flyout.classList.toggle('open');
                openFlyout = flyout.classList.contains('open') ? flyout : null;
                return;
            }

            // Expanded mode → accordion
            const body = document.getElementById('body-' + id);
            const chevron = document.getElementById('chevron-' + id);
            const header = e.currentTarget;
            const isOpen = body.classList.contains('open');

            body.classList.toggle('open');
            if (chevron) chevron.classList.toggle('open');
            header.classList.toggle('active-group', !isOpen);
        }

        function closeAllFlyouts() {
            document.querySelectorAll('.flyout-panel').forEach(f => f.classList.remove('open'));
            openFlyout = null;
        }

        // Close flyouts when clicking outside
        document.addEventListener('click', () => {
            closeAllFlyouts();
            document.getElementById('notifMenu').classList.remove('open');
        });

        // ── Notifications ──
        document.getElementById('notifBtn').addEventListener('click', e => {
            e.stopPropagation();
            document.getElementById('notifMenu').classList.toggle('open');
        });

        // ── Theme ──
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
            applyLayout('240px');
            applyTheme(localStorage.getItem('theme') || 'light');

            document.querySelectorAll('.theme-option').forEach(o =>
                o.addEventListener('click', e => {
                    e.stopPropagation();
                    applyTheme(o.getAttribute('data-theme'));
                })
            );
        });

        /* ── Role card selection ─────────────────────────── */
        function selectRole(card) {
            // Deactivate all cards
            document.querySelectorAll('.role-card').forEach(c => {
                c.classList.remove('active');
                c.querySelector('.active-dot').style.display = 'none';
                c.querySelector('.progress-fill').style.background = '#C4B8AF';
                c.querySelector('.role-name-label').style.color = '#2D2420';
            });

            // Activate clicked card
            card.classList.add('active');
            card.querySelector('.active-dot').style.display = 'block';
            card.querySelector('.progress-fill').style.background = 'linear-gradient(90deg, #7B0D0D, #C9973A)';

            const roleId = card.dataset.roleId;
            const roleName = card.dataset.roleName;
            const granted = parseInt(card.dataset.granted);
            const total = parseInt(card.dataset.total);
            const pct = parseInt(card.dataset.pct);

            // Update accent card
            document.getElementById('accentRoleName').textContent = roleName;
            document.getElementById('accentPct').textContent = pct + '%';
            document.getElementById('accentCount').textContent = granted + ' of ' + total + ' permissions active';
            document.getElementById('accentBar').style.width = pct + '%';

            // Show/hide protected banner
            const slug = card.dataset.slug.toLowerCase();
            const isSuper = ['super_admin', 'super-admin', 'superadmin'].includes(slug) || roleName.toLowerCase().includes('super');
            document.getElementById('protectedBanner').style.display = isSuper ? 'flex' : 'none';

            // Switch the visible form
            document.querySelectorAll('.role-form').forEach(f => f.style.display = 'none');
            const targetForm = document.getElementById('form-role-' + roleId);
            if (targetForm) targetForm.style.display = 'block';

            // Clear search
            document.getElementById('permSearch').value = '';
            filterPerms('');
        }

        /* ── Group collapse ──────────────────────────────── */
        let allExpanded = true;

        function toggleGroup(header) {
            const body = header.nextElementSibling;
            const chev = header.querySelector('.chevron');
            const isCollapsed = body.classList.contains('collapsed');
            body.classList.toggle('collapsed');
            chev.classList.toggle('collapsed', !isCollapsed);
        }

        function toggleAllGroups() {
            const btn = document.getElementById('collapseBtn');
            // Only affect the visible form's groups
            const visibleForm = document.querySelector('.role-form[style*="block"]');
            if (!visibleForm) return;
            const bodies = visibleForm.querySelectorAll('.group-body');
            const chevs = visibleForm.querySelectorAll('.chevron');
            allExpanded = !allExpanded;
            bodies.forEach(b => b.classList.toggle('collapsed', !allExpanded));
            chevs.forEach(c => c.classList.toggle('collapsed', !allExpanded));
            btn.textContent = allExpanded ? 'Collapse All' : 'Expand All';
        }

        /* ── Per-permission toggle ───────────────────────── */
        function onPermChange(input) {
            const row = input.closest('.perm-row');
            const badge = row.querySelector('.perm-status');
            const dot = row.querySelector('.perm-dot');
            const label = row.querySelector('.perm-label');
            const color = input.dataset.color;
            const roleId = input.dataset.role;
            const mSlug = input.dataset.module;

            if (input.checked) {
                badge.textContent = 'Granted';
                badge.className = 'perm-status status-granted';
                badge.style.background = color + '18';
                badge.style.color = color;
                dot.style.background = color;
                label.style.color = '#2D2420';
                row.style.background = color + '06';
            } else {
                badge.textContent = 'Denied';
                badge.className = 'perm-status status-denied';
                badge.style.background = '';
                badge.style.color = '';
                dot.style.background = '#D5CEC8';
                label.style.color = '#8A7A6F';
                row.style.background = 'transparent';
            }

            updateDots(roleId, mSlug, color);
            updateGroupCount(roleId, mSlug);
            syncGroupMaster(roleId, mSlug);
            updateAccentCard(roleId);
            updateFooterMsg(roleId);
        }

        /* ── Group "All" toggle ──────────────────────────── */
        function toggleGroupPerms(wrapper, roleId, mSlug, currentlyAllOn) {
            const newState = !currentlyAllOn;
            // Update the data attribute so next click flips correctly
            wrapper.setAttribute('onclick', `event.stopPropagation(); toggleGroupPerms(this, '${roleId}', '${mSlug}', ${newState})`);

            const form = document.getElementById('form-role-' + roleId);
            if (!form) return;
            const toggles = form.querySelectorAll(`.perm-toggle[data-module="${mSlug}"]`);
            toggles.forEach(t => {
                if (t.disabled) return;
                t.checked = newState;
                onPermChange(t);
            });

            const master = form.querySelector(`.group-master[data-module="${mSlug}"]`);
            if (master) master.checked = newState;
        }

        function syncGroupMaster(roleId, mSlug) {
            const form = document.getElementById('form-role-' + roleId);
            if (!form) return;
            const all = [...form.querySelectorAll(`.perm-toggle[data-module="${mSlug}"]`)];
            const checked = all.filter(t => t.checked).length;
            const master = form.querySelector(`.group-master[data-module="${mSlug}"]`);
            if (!master) return;
            master.checked = checked === all.length;
            master.indeterminate = checked > 0 && checked < all.length;
        }

        function updateDots(roleId, mSlug, color) {
            const cont = document.getElementById(`dots-${roleId}-${mSlug}`);
            if (!cont) return;
            const form = document.getElementById('form-role-' + roleId);
            if (!form) return;
            const toggles = [...form.querySelectorAll(`.perm-toggle[data-module="${mSlug}"]`)];
            const dots = cont.querySelectorAll('.dot');
            toggles.forEach((t, i) => {
                if (!dots[i]) return;
                dots[i].style.background = t.checked ? color : '#E5DDD5';
            });
        }

        function updateGroupCount(roleId, mSlug) {
            const form = document.getElementById('form-role-' + roleId);
            if (!form) return;
            // Find the group card that has this mSlug's dots container
            const dotsEl = form.querySelector(`[id="dots-${roleId}-${mSlug}"]`);
            if (!dotsEl) return;
            const groupCard = dotsEl.closest('.group-card');
            if (!groupCard) return;
            const all = [...groupCard.querySelectorAll('.perm-toggle')];
            const checked = all.filter(t => t.checked).length;
            const countEl = groupCard.querySelector('.group-count');
            if (countEl) countEl.textContent = `${checked} of ${all.length} enabled`;
        }

        function updateAccentCard(roleId) {
            const form = document.getElementById('form-role-' + roleId);
            if (!form) return;
            const all = [...form.querySelectorAll('.perm-toggle')];
            const total = all.length;
            const checked = all.filter(t => t.checked).length;
            const pct = total > 0 ? Math.round(checked / total * 100) : 0;

            document.getElementById('accentPct').textContent = pct + '%';
            document.getElementById('accentCount').textContent = `${checked} of ${total} permissions active`;
            document.getElementById('accentBar').style.width = pct + '%';

            // Also update the role card itself
            const card = document.querySelector(`.role-card[data-role-id="${roleId}"]`);
            if (card) {
                card.querySelector('.pct-label').textContent = pct + '%';
                card.querySelector('.count-label').textContent = `${checked} of ${total} permissions`;
                card.querySelector('.progress-fill').style.width = pct + '%';
                card.dataset.granted = checked;
                card.dataset.pct = pct;
            }
        }

        function updateFooterMsg(roleId) {
            const el = document.getElementById('footer-msg-' + roleId);
            if (!el) return;
            const form = document.getElementById('form-role-' + roleId);
            if (!form) return;
            const checked = [...form.querySelectorAll('.perm-toggle')].filter(t => t.checked).length;
            const roleName = document.querySelector(`.role-card[data-role-id="${roleId}"]`)?.dataset.roleName || '';
            el.textContent = `${checked} permissions enabled for ${roleName}`;
        }

        /* ── Search ──────────────────────────────────────── */
        function filterPerms(q) {
            q = q.toLowerCase().trim();
            const visibleForm = document.querySelector('.role-form[style*="block"]');
            if (!visibleForm) return;

            visibleForm.querySelectorAll('.perm-row').forEach(row => {
                const match = !q || (row.dataset.permSearch || '').includes(q);
                row.style.display = match ? '' : 'none';
            });
            visibleForm.querySelectorAll('.perm-group').forEach(group => {
                const visible = [...group.querySelectorAll('.perm-row')].some(r => r.style.display !== 'none');
                group.style.display = visible ? '' : 'none';
                if (q && visible) group.querySelector('.group-body').classList.remove('collapsed');
            });
        }


        /* ── New Role Modal ──────────────────────────────── */
        document.getElementById('newRoleName').addEventListener('input', function() {
            const slug = this.value.toLowerCase().trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('newRoleSlug').value = slug;
        });

        function closeNewRoleModal() {
            document.getElementById('newRoleModal').style.display = 'none';
            document.getElementById('newRoleName').value = '';
            document.getElementById('newRoleSlug').value = '';
            document.getElementById('newRoleError').style.display = 'none';
        }

        function createNewRole() {
            const name = document.getElementById('newRoleName').value.trim();
            const slug = document.getElementById('newRoleSlug').value.trim();
            const errEl = document.getElementById('newRoleError');

            if (!name) {
                errEl.textContent = 'Please enter a role name.';
                errEl.style.display = 'block';
                return;
            }
            if (!slug) {
                errEl.textContent = 'Please enter a slug.';
                errEl.style.display = 'block';
                return;
            }

            document.getElementById('createRoleName').value = name;
            document.getElementById('createRoleSlug').value = slug;
            document.getElementById('createRoleForm').submit();
        }

        // Close modal on overlay click
        document.getElementById('newRoleModal').addEventListener('click', function(e) {
            if (e.target === this) closeNewRoleModal();
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && document.getElementById('newRoleModal').style.display !== 'none') closeNewRoleModal();
        });

        /* ── Init ────────────────────────────────────────── */
        document.addEventListener('DOMContentLoaded', () => {
            // Show banner if first role is super admin
            const firstCard = document.querySelector('.role-card');
            if (firstCard) {
                const slug = firstCard.dataset.slug;
                const name = firstCard.dataset.roleName;
                if (['super_admin', 'super-admin', 'superadmin'].includes(slug) || name.toLowerCase().includes('super')) {
                    document.getElementById('protectedBanner').style.display = 'flex';
                }
            }
        });
    </script>

    <!-- ══ NEW ROLE MODAL ══════════════════════════════════════ -->
    <div id="newRoleModal" style="display:none;position:fixed;inset:0;background:rgba(15,5,5,0.55);align-items:center;justify-content:center;z-index:200;backdrop-filter:blur(4px);">
        <div style="background:#fff;border-radius:20px;padding:36px 36px 28px;width:440px;box-shadow:0 32px 80px rgba(0,0,0,0.25);">
            <div style="width:48px;height:48px;border-radius:14px;background:#FFF0F0;border:1.5px solid #7B0D0D30;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:16px;">
                <i class="fa-solid fa-user-shield" style="color:#7B0D0D;"></i>
            </div>
            <h2 style="margin:0 0 6px;font-size:22px;font-weight:800;color:#7B0D0D;">Create New Role</h2>
            <p style="margin:0 0 22px;font-size:14px;color:#8A7A6F;">Define a new role and assign permissions right after creating it.</p>

            <label style="display:block;font-size:12px;font-weight:700;color:#6B5E56;letter-spacing:0.5px;text-transform:uppercase;margin-bottom:6px;">Role Name</label>
            <input id="newRoleName" type="text" placeholder="e.g. Dental Intern"
                style="width:100%;padding:12px 16px;border:1.5px solid #EDE8E2;border-radius:10px;font-size:15px;font-family:'Inter',sans-serif;outline:none;color:#2D2420;margin-bottom:10px;transition:border-color 0.18s;"
                onfocus="this.style.borderColor='#7B0D0D'" onblur="this.style.borderColor='#EDE8E2'"
                onkeydown="if(event.key==='Enter') createNewRole()">

            <label style="display:block;font-size:12px;font-weight:700;color:#6B5E56;letter-spacing:0.5px;text-transform:uppercase;margin-bottom:6px;">Role Slug</label>
            <input id="newRoleSlug" type="text" placeholder="e.g. dental-intern"
                style="width:100%;padding:12px 16px;border:1.5px solid #EDE8E2;border-radius:10px;font-size:15px;font-family:'Inter',sans-serif;outline:none;color:#2D2420;margin-bottom:22px;transition:border-color 0.18s;"
                onfocus="this.style.borderColor='#7B0D0D'" onblur="this.style.borderColor='#EDE8E2'">

            <div id="newRoleError" style="display:none;color:#B91C1C;font-size:13px;margin-bottom:12px;"></div>

            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button onclick="closeNewRoleModal()"
                    style="background:#F5EFE9;color:#6B5E56;border:none;border-radius:10px;padding:11px 22px;font-weight:600;font-size:14px;cursor:pointer;font-family:'Inter',sans-serif;">
                    Cancel
                </button>
                <form id="createRoleForm" action="{{ route('admin.role_permissions.store_role') }}" method="POST" style="display:contents;">
                    @csrf
                    <input type="hidden" name="name" id="createRoleName">
                    <input type="hidden" name="slug" id="createRoleSlug">
                    <button type="button" onclick="createNewRole()"
                        style="background:linear-gradient(135deg,#7B0D0D,#9B1515);color:#fff;border:none;border-radius:10px;padding:11px 24px;font-weight:700;font-size:14px;cursor:pointer;font-family:'Inter',sans-serif;">
                        Create Role
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>