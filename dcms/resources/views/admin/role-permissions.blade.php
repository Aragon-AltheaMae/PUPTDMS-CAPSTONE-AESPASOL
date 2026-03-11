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

        #sidebar.collapsed .group-label-wrap {
            display: none;
        }

        #sidebar.collapsed .group-chevron {
            display: none;
        }

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
            margin: 6px 12px;
        }

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

        /* ── Layout transitions ── */
        body,
        main,
        footer {
            transition: background-color .3s ease, color .3s ease;
        }

        #mainContent,
        footer {
            transition: margin-left .3s cubic-bezier(.4, 0, .2, 1);
        }

        /* ── Dark theme ── */
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

        .perm-group-header {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            background: #FDFCFB;
            cursor: pointer;
            transition: background 0.15s;
            user-select: none;
        }

        .perm-group-header:hover {
            background: #FAF4EF;
        }

        .perm-group-icon {
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

        .all-toggle-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #F5EFE9;
            border-radius: 8px;
            padding: 5px 12px;
            cursor: pointer;
        }

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

        .perm-group-body {
            border-top: 1px solid #F0EBE6;
            overflow: hidden;
            transition: max-height 0.35s ease, opacity 0.25s ease;
            max-height: 9999px;
            opacity: 1;
        }

        .perm-group-body.collapsed {
            max-height: 0;
            opacity: 0;
            border-top: none;
        }

        .chevron {
            transition: transform 0.2s;
            color: #B5A99A;
            font-size: 11px;
        }

        .chevron.collapsed {
            transform: rotate(180deg);
        }

        /* ── Footer bar ── */
        .footer-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            background: #fff;
            border-radius: 14px;
            border: 1.5px solid #EDE8E2;
            margin-top: 18px;
            gap: 12px;
            flex-wrap: wrap;
        }

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
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(123, 13, 13, 0.35);
        }

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

        .accent-card {
            background: linear-gradient(135deg, #7B0D0D 0%, #9B1515 100%);
            border-radius: 14px;
            padding: 18px 20px;
            color: #fff;
            margin-top: 16px;
        }

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

        /* ════════════════════════════════════════════
           NEW: View As button (footer — right side)
        ════════════════════════════════════════════ */
        .btn-view-as {
            display: none;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #1D4ED8, #3B82F6);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 14px rgba(29, 78, 216, 0.3);
            transition: all 0.2s;
            position: relative;
            white-space: nowrap;
        }

        .btn-view-as.show {
            display: flex;
            animation: popSlide .45s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        .btn-view-as:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(29, 78, 216, .4);
        }

        @keyframes popSlide {
            from {
                opacity: 0;
                transform: translateX(16px) scale(.9);
            }

            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        .va-count-badge {
            position: absolute;
            top: -7px;
            right: -7px;
            background: #EF4444;
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(239, 68, 68, .4);
        }

        /* Pending-grant chips in footer */
        .grant-chips {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .grant-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 700;
            animation: chipIn .35s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        @keyframes chipIn {
            from {
                opacity: 0;
                transform: scale(.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .hint-save {
            display: none;
            align-items: center;
            gap: 6px;
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            color: #1D4ED8;
        }

        .hint-save.show {
            display: flex;
        }

        /* NEW: View As modal */
        .va-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 5, 5, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 300;
            backdrop-filter: blur(6px);
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s;
        }

        .va-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        .va-panel {
            background: #fff;
            border-radius: 22px;
            width: 680px;
            max-width: calc(100vw - 32px);
            max-height: calc(100vh - 60px);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 40px 100px rgba(0, 0, 0, .3);
            transform: scale(.94) translateY(16px);
            transition: transform .35s cubic-bezier(.34, 1.56, .64, 1);
        }

        .va-overlay.open .va-panel {
            transform: scale(1) translateY(0);
        }

        .va-head {
            padding: 22px 26px 18px;
            border-bottom: 1px solid #F0EBE6;
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .va-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px 26px;
        }

        .va-foot {
            padding: 14px 26px 20px;
            border-top: 1px solid #F0EBE6;
            display: flex;
            justify-content: flex-end;
        }

        .va-summary {
            background: linear-gradient(135deg, #7B0D0D, #9B1515);
            border-radius: 12px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 18px;
            color: #fff;
        }

        .va-role-row {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #FDFCFB;
            border: 1.5px solid #EDE8E2;
            border-radius: 14px;
            padding: 16px 18px;
            cursor: pointer;
            transition: all .2s;
            position: relative;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .va-role-row:last-child {
            margin-bottom: 0;
        }

        .va-role-row:hover {
            border-color: #93C5FD;
            box-shadow: 0 4px 18px rgba(29, 78, 216, .1);
            transform: translateY(-1px);
        }

        .va-role-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            flex-shrink: 0;
        }

        .va-perm-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .va-go-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #1D4ED8, #3B82F6);
            color: #fff;
            border: none;
            border-radius: 9px;
            padding: 9px 16px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            white-space: nowrap;
            flex-shrink: 0;
            transition: all .2s;
            box-shadow: 0 3px 10px rgba(29, 78, 216, .25);
        }

        .va-go-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(29, 78, 216, .35);
        }

        /* NEW: Redirect overlay */
        .redirect-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s;
        }

        .redirect-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        .redirect-spinner {
            width: 48px;
            height: 48px;
            border: 3px solid rgba(255, 255, 255, .2);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
            margin-bottom: 16px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* NEW: Toast */
        .toast-pop {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 600;
            background: #fff;
            border: 1.5px solid #BBF7D0;
            border-radius: 14px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            transform: translateY(80px);
            opacity: 0;
            transition: all .4s cubic-bezier(.34, 1.56, .64, 1);
            min-width: 300px;
        }

        .toast-pop.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #F0FDF4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #22C55E;
            flex-shrink: 0;
        }

        /* NEW: Role card slide-in animation */
        @keyframes cardSlide {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .card-new {
            animation: cardSlide 0.4s cubic-bezier(.34, 1.56, .64, 1) both;
        }
    </style>
</head>

<body>

    <!-- ════════════════ HEADER ════════════════ -->
    <header class="header">
        <div class="header-left">
            <img src="{{ asset('images/PUP.png') }}" class="header-logo" alt="PUP">
            <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="header-logo" alt="DMS">
            <span class="header-title">PUP TAGUIG DENTAL CLINIC</span>
        </div>
        <div class="header-right">
            @php
                $notifications = collect($notifications ?? []);
                $notifCount = $notifications->count();
            @endphp
            <div id="notifDropdown">
                <button class="notif-btn" id="notifBtn">
                    <i class="fa-regular fa-bell"></i>
                    @if ($notifCount > 0)
                        <span class="notif-badge">{{ $notifCount }}</span>
                    @endif
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
                                @if (!empty($n['message']))
                                    <div style="color:#aaa; margin-top:2px;">{{ $n['message'] }}</div>
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

    <!-- ════════════════ SIDEBAR ════════════════ -->
    <aside id="sidebar" class="expanded">
        <div class="sidebar-toggle-row">
            <button class="toggle-btn" onclick="toggleSidebar()" id="sidebarToggleBtn">
                <i id="sidebarIcon" class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <div class="sidebar-inner">
            <div class="nav-group flyout-wrapper" id="group-cms">
                <div class="group-header active-group" onclick="toggleSidebarGroup('cms', event)">
                    <div class="group-icon"><i class="fa-solid fa-hospital"></i></div>
                    <div class="group-label-wrap">
                        <span class="group-label">Clinic Management</span>
                        <span class="group-sublabel">Core clinical modules</span>
                    </div>
                    <i class="fa-solid fa-chevron-down group-chevron" id="chevron-cms"></i>
                </div>
                <div class="group-body open" id="body-cms">
                    <a href="{{ route('admin.admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.admin.dashboard') ? 'active' : '' }}"><i
                            class="fa-solid fa-chart-line"></i> Dashboard</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-users"></i>
                        Patients</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i
                            class="fa-solid fa-calendar-check"></i> Appointments</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-school"></i>
                        Academic Periods</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i
                            class="fa-solid fa-file-circle-check"></i> Document Requests</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i
                            class="fa-solid fa-file-pen"></i> Document Template</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-file"></i>
                        Reports</a>
                </div>
                <div class="flyout-panel" id="flyout-cms">
                    <div class="flyout-title">Clinic Management</div>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i
                            class="fa-solid fa-chart-line"></i> Dashboard</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i
                            class="fa-solid fa-users"></i> Patients</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i
                            class="fa-solid fa-calendar-check"></i> Appointments</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i
                            class="fa-solid fa-school"></i> Academic Periods</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i
                            class="fa-solid fa-file-circle-check"></i> Document Requests</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i
                            class="fa-solid fa-file-pen"></i> Document Template</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i
                            class="fa-solid fa-file"></i> Reports</a>
                </div>
            </div>

            <div class="nav-sep"></div>

            <div class="nav-group flyout-wrapper" id="group-sys">
                <div class="group-header active-group" onclick="toggleSidebarGroup('sys', event)">
                    <div class="group-icon"><i class="fa-solid fa-server"></i></div>
                    <div class="group-label-wrap">
                        <span class="group-label">System</span>
                        <span class="group-sublabel">Admin &amp; configuration</span>
                    </div>
                    <i class="fa-solid fa-chevron-down group-chevron" id="chevron-sys"></i>
                </div>
                <div class="group-body open" id="body-sys">
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i
                            class="fa-solid fa-database"></i> Data Backup</a>
                    <a href="{{ route('admin.system_logs') }}"
                        class="nav-link {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}"><i
                            class="fa-solid fa-clipboard-list"></i> System Logs</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-gear"></i>
                        System Settings</a>
                    <a href="{{ route('admin.role_permissions') }}"
                        class="nav-link {{ request()->routeIs('admin.role_permissions') ? 'active' : '' }}"><i
                            class="fa-solid fa-user-shield"></i> Roles &amp; Permissions</a>
                </div>
                <div class="flyout-panel" id="flyout-sys">
                    <div class="flyout-title">System</div>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i
                            class="fa-solid fa-database"></i> Data Backup</a>
                    <a href="{{ route('admin.system_logs') }}" class="flyout-link"><i
                            class="fa-solid fa-clipboard-list"></i> System Logs</a>
                    <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i
                            class="fa-solid fa-gear"></i> System Settings</a>
                    <a href="{{ route('admin.role_permissions') }}" class="flyout-link"><i
                            class="fa-solid fa-user-shield"></i> Roles &amp; Permissions</a>
                </div>
            </div>
        </div>

        <div class="sidebar-bottom">
            <div class="text-[.65rem] font-semibold tracking-widest text-gray-400 uppercase mb-2 px-1 settings-label">
                Settings</div>
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
                    <span class="logout-text font-semibold">Log out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ════════════════ MAIN ════════════════ -->
    <main id="mainContent" class="pt-[100px] px-6 py-6 fade-up min-h-screen" style="margin-left:240px;">
        <div class="max-w-7xl mt-4 mx-auto fade-in">

            @if (session('success'))
                <div
                    style="background:#F0FDF4; border:1px solid #BBF7D0; border-radius:12px; padding:12px 18px; margin-bottom:20px; display:flex; align-items:center; gap:10px; font-size:14px; font-weight:600; color:#166534;">
                    <i class="fa-solid fa-circle-check" style="color:#22C55E;"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Page title -->
            <div
                style="display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:28px; gap:12px; flex-wrap:wrap;">
                <div>
                    <div
                        style="font-size:11px; color:#B5A99A; letter-spacing:2px; text-transform:uppercase; margin-bottom:6px; font-weight:600;">
                        System Administration</div>
                    <h1 style="margin:0; font-size:30px; font-weight:800; color:#7B0D0D; line-height:1;">Role &amp;
                        Permissions</h1>
                    <p style="margin:8px 0 0; font-size:14px; color:#8A7A6F;">Define what each role can see and do
                        across the clinic system.</p>
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

                <!-- ══ LEFT: Role Cards ══ -->
                <div>
                    @php
                        function getRoleBadge($name, $slug)
                        {
                            $n = strtolower($name);
                            $s = strtolower($slug);
                            if (str_contains($n, 'super') || str_contains($s, 'super')) {
                                return ['badgeColor' => '#7B0D0D', 'label' => 'Full Access'];
                            }
                            if (str_contains($n, 'dentist') || str_contains($s, 'dentist')) {
                                return ['badgeColor' => '#B45309', 'label' => 'Clinical'];
                            }
                            if (str_contains($n, 'staff') || str_contains($s, 'staff') || str_contains($n, 'clinic')) {
                                return ['badgeColor' => '#065F46', 'label' => 'Front Desk'];
                            }
                            if (
                                str_contains($n, 'student') ||
                                str_contains($s, 'student') ||
                                str_contains($n, 'patient') ||
                                str_contains($s, 'patient')
                            ) {
                                return ['badgeColor' => '#4B5563', 'label' => 'Limited'];
                            }
                            return ['badgeColor' => '#6B7280', 'label' => 'Custom'];
                        }
                        $totalPerms = $groupedPermissions->flatten()->count();
                    @endphp

                    <div style="font-size:11px; color:#B5A99A; letter-spacing:2px; text-transform:uppercase; margin-bottom:12px; font-weight:600;"
                        id="roleCountLabel">
                        Roles ({{ $roles->count() }})
                    </div>

                    <div style="display:flex; flex-direction:column; gap:8px;" id="roleCardList">
                        @foreach ($roles as $i => $role)
                            @php
                                $c = getRoleBadge($role->name, $role->slug);
                                $granted = $role->permissions->count();
                                $pct = $totalPerms > 0 ? round(($granted / $totalPerms) * 100) : 0;
                                $words = array_slice(explode(' ', $role->name), 0, 2);
                                $initials = '';
                                foreach ($words as $_w) {
                                    $initials .= strtoupper($_w[0]);
                                }
                                $isHighlighted = isset($highlightRoleId) && (int) $highlightRoleId === (int) $role->id;
                                $isFirst = isset($highlightRoleId) ? $isHighlighted : $i === 0;
                                $isSuperRole =
                                    in_array(strtolower($role->slug), ['super_admin', 'super-admin', 'superadmin']) ||
                                    str_contains(strtolower($role->name), 'super');
                            @endphp
                            <div class="role-card {{ $isFirst ? 'active' : '' }}" data-role-id="{{ $role->id }}"
                                data-role-name="{{ $role->name }}" data-granted="{{ $granted }}"
                                data-total="{{ $totalPerms }}" data-pct="{{ $pct }}"
                                data-slug="{{ $role->slug }}" data-is-super="{{ $isSuperRole ? '1' : '0' }}"
                                onclick="selectRole(this)">

                                <div style="display:flex; align-items:center; gap:12px;">
                                    <div class="role-avatar">{{ $initials }}</div>
                                    <div style="flex:1;">
                                        <div style="display:flex; align-items:center; gap:7px; margin-bottom:3px;">
                                            <span style="font-weight:600; font-size:14px; color:#2D2420;"
                                                class="role-name-label">{{ $role->name }}</span>
                                        </div>
                                        <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                                            <span class="badge-pill"
                                                style="background:{{ $c['badgeColor'] }}18; color:{{ $c['badgeColor'] }}; border:1px solid {{ $c['badgeColor'] }}40; white-space:nowrap;">{{ $c['label'] }}</span>
                                            <span
                                                style="font-size:11px; color:#B5A99A; white-space:nowrap;">{{ $role->slug }}</span>
                                        </div>
                                    </div>
                                    <div class="active-dot"
                                        style="width:8px; height:8px; border-radius:50%; background:#7B0D0D; flex-shrink:0; display:{{ $isFirst ? 'block' : 'none' }};">
                                    </div>
                                </div>

                                <div style="margin-top:12px;">
                                    <div
                                        style="display:flex; justify-content:space-between; font-size:11px; color:#B5A99A; margin-bottom:5px;">
                                        <span>Access level</span>
                                        <span style="font-weight:600;" class="pct-label">{{ $pct }}%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill"
                                            style="width:{{ $pct }}%; background:{{ $isFirst ? 'linear-gradient(90deg,#7B0D0D,#C9973A)' : '#C4B8AF' }};">
                                        </div>
                                    </div>
                                    <div style="font-size:11px; color:#C4B8AF; margin-top:4px;" class="count-label">
                                        {{ $granted }} of {{ $totalPerms }} permissions</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Accent summary card -->
                    <div class="accent-card">
                        @php
                            $fr = isset($highlightRoleId)
                                ? $roles->firstWhere('id', (int) $highlightRoleId)
                                : $roles->first();

                            $fp = $fr
                                ? ($totalPerms > 0
                                    ? round(($fr->permissions->count() / $totalPerms) * 100)
                                    : 0)
                                : 0;
                        @endphp
                        <div style="font-size:16px; font-weight:700; margin-bottom:4px;" id="accentRoleName">
                            {{ $fr->name ?? '' }}</div>
                        <div style="font-size:28px; font-weight:700; margin-bottom:2px;" id="accentPct">
                            {{ $fp }}%</div>
                        <div style="font-size:12px; opacity:0.75; margin-bottom:14px;" id="accentCount">
                            {{ $fr?->permissions->count() ?? 0 }} of {{ $totalPerms }} permissions active</div>
                        <div style="height:6px; background:rgba(255,255,255,0.2); border-radius:10px;">
                            <div id="accentBar"
                                style="height:100%; width:{{ $fp }}%; background:#C9973A; border-radius:10px; transition:width 0.4s;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ══ RIGHT: Permission Editor ══ -->
                <div>
                    <!-- Toolbar -->
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:18px; flex-wrap:wrap;">
                        <div style="flex:1; position:relative; min-width:180px;">
                            <i class="fa-solid fa-magnifying-glass"
                                style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#B5A99A; font-size:13px;"></i>
                            <input type="text" id="permSearch" placeholder="Search permissions…"
                                class="search-input" oninput="filterPerms(this.value)">
                        </div>
                        <button type="button" class="btn-collapse" id="collapseBtn"
                            onclick="toggleAllGroups()">Collapse All</button>
                        <form action="{{ route('admin.role_permissions.reset') }}" method="POST"
                            style="display:contents;">
                            @csrf
                            <button type="submit" class="btn-reset" style="border:1.5px solid #EDE8E2;">
                                <i class="fa-solid fa-rotate-left" style="font-size:12px; margin-right:4px;"></i>
                                Reset Defaults
                            </button>
                        </form>
                    </div>

                    <!-- Protected banner -->
                    <div class="protected-banner" id="protectedBanner" style="display:none;">
                        <i class="fa-solid fa-shield-halved" style="font-size:20px; color:#92400E;"></i>
                        <div>
                            <div style="font-weight:700; font-size:13px; color:#78350F;">Protected Role</div>
                            <div style="font-size:12px; color:#92400E;">Super Admin has unrestricted access and cannot
                                be modified.</div>
                        </div>
                    </div>

                    <!-- Permission forms — one per role, shown/hidden by JS -->
                    @foreach ($roles as $ri => $role)
                        @php
                            $isSuperRole =
                                in_array(strtolower($role->slug), ['super_admin', 'super-admin', 'superadmin']) ||
                                str_contains(strtolower($role->name), 'super');

                            $isActiveRole = isset($highlightRoleId)
                                ? (int) $highlightRoleId === (int) $role->id
                                : $ri === 0;

                            $micons = [
                                'Dental Records' => ['fa-notes-medical', '#7B0D0D'],
                                'Patients' => ['fa-user-group', '#B45309'],
                                'Appointments' => ['fa-calendar-days', '#065F46'],
                                'Document Requests' => ['fa-envelope-open-text', '#1D4ED8'],
                                'Document Templates' => ['fa-file-lines', '#6D28D9'],
                                'Reports' => ['fa-chart-pie', '#6D28D9'],
                                'General Access' => ['fa-user-shield', '#065F46'],
                                'Inventory' => ['fa-boxes-stacked', '#EA580C'],
                                'User Management' => ['fa-user-cog', '#DC2626'],
                                'System Settings' => ['fa-screwdriver-wrench', '#374151'],
                            ];
                        @endphp

                        <form id="form-role-{{ $role->id }}" class="role-form"
                            data-role-id="{{ $role->id }}" action="{{ route('admin.role_permissions.update') }}"
                            method="POST" style="display:{{ $isActiveRole ? 'block' : 'none' }};"
                            onsubmit="onFormSubmit('{{ $role->id }}')">

                            @csrf
                            <input type="hidden" name="role_id" value="{{ $role->id }}">

                            <div style="display:flex; flex-direction:column; gap:10px;" class="groups-container">
                                @forelse($groupedPermissions as $module => $permissions)
                                    @php
                                        [$ico, $icol] = $micons[$module] ?? ['fa-shield-halved', '#374151'];
                                        $mSlug = Str::slug($module);
                                        $mTotal = $permissions->count();
                                        $roleGranted = 0;
                                        foreach ($permissions as $_p) {
                                            if ($role->permissions->contains('id', $_p->id)) {
                                                $roleGranted++;
                                            }
                                        }
                                        $allOn = $roleGranted === $mTotal;
                                    @endphp

                                    <div class="group-card perm-group" data-group="{{ strtolower($module) }}">

                                        <!-- Group header — uses perm-specific handler -->
                                        <div class="perm-group-header" onclick="togglePermGroup(this)">
                                            <div class="perm-group-icon"
                                                style="background:{{ $icol }}15; color:{{ $icol }}; border:1px solid {{ $icol }}25;">
                                                <i class="fa-solid {{ $ico }}"></i>
                                            </div>
                                            <div style="flex:1;">
                                                <div style="font-weight:700; font-size:14px; color:#2D2420;">
                                                    {{ $module }}</div>
                                                <div style="font-size:12px; color:#B5A99A;" class="group-count">
                                                    {{ $roleGranted }} of {{ $mTotal }} enabled</div>
                                            </div>
                                            <div style="display:flex; align-items:center; gap:14px;">
                                                <div class="dot-row"
                                                    id="dots-{{ $role->id }}-{{ $mSlug }}">
                                                    @for ($d = 0; $d < $mTotal; $d++)
                                                        <div class="dot {{ $d < $roleGranted ? 'on' : '' }}"
                                                            style="{{ $d < $roleGranted ? 'background:' . $icol . ';' : '' }}">
                                                        </div>
                                                    @endfor
                                                </div>
                                                <div class="all-toggle-wrap"
                                                    onclick="event.stopPropagation(); toggleGroupPerms(this, '{{ $role->id }}', '{{ $mSlug }}', {{ $allOn ? 'true' : 'false' }})">
                                                    <span
                                                        style="font-size:11px; color:#6B5E56; font-weight:600;">All</span>
                                                    <label class="toggle-switch {{ $isSuperRole ? 'disabled' : '' }}"
                                                        onclick="event.preventDefault();">
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

                                        <div class="perm-group-body">
                                            @foreach ($permissions as $permission)
                                                @php $isGranted = $role->permissions->contains('id', $permission->id); @endphp
                                                <div class="perm-row"
                                                    style="{{ $isGranted ? 'background:' . $icol . '06;' : '' }}"
                                                    data-perm-search="{{ strtolower($permission->name . ' ' . $permission->slug) }}">
                                                    <div style="flex:1;">
                                                        <div
                                                            style="display:flex; align-items:center; gap:8px; margin-bottom:2px;">
                                                            <div class="perm-dot"
                                                                style="width:7px; height:7px; border-radius:50%; flex-shrink:0; transition:background 0.2s; background:{{ $isGranted ? $icol : '#D5CEC8' }};">
                                                            </div>
                                                            <span
                                                                style="font-weight:600; font-size:13px; color:{{ $isGranted ? '#2D2420' : '#8A7A6F' }};"
                                                                class="perm-label">{{ $permission->name }}</span>
                                                        </div>
                                                        <div style="font-size:12px; color:#B5A99A; padding-left:15px;">
                                                            {{ $permission->slug }}</div>
                                                    </div>
                                                    <div style="display:flex; align-items:center; gap:10px;">
                                                        <span
                                                            class="perm-status {{ $isGranted ? 'status-granted' : 'status-denied' }}"
                                                            style="{{ $isGranted ? 'background:' . $icol . '18; color:' . $icol . ';' : '' }}">
                                                            {{ $isGranted ? 'Granted' : 'Denied' }}
                                                        </span>
                                                        <label
                                                            class="toggle-switch {{ $isSuperRole ? 'disabled' : '' }}">
                                                            <input type="checkbox"
                                                                name="permissions[{{ $role->id }}][]"
                                                                value="{{ $permission->id }}" class="perm-toggle"
                                                                data-role="{{ $role->id }}"
                                                                data-module="{{ $mSlug }}"
                                                                data-color="{{ $icol }}"
                                                                data-perm-name="{{ $permission->name }}"
                                                                data-perm-slug="{{ $permission->slug }}"
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
                                        <p style="font-size:14px; font-weight:600; color:#8A7A6F;">No permissions
                                            found.</p>
                                    </div>
                                @endforelse
                            </div>

                            @if (!$isSuperRole)
                                <!-- ── Footer bar with View As ── -->
                                <div class="footer-bar" id="footer-bar-{{ $role->id }}">
                                    <div style="display:flex; flex-direction:column; gap:6px; flex:1; min-width:0;">
                                        <div style="font-size:13px; color:#8A7A6F;"
                                            id="footer-msg-{{ $role->id }}">
                                            {{ $role->permissions->count() }} permissions enabled for
                                            {{ $role->name }}
                                        </div>
                                        <!-- Pending chips appear here when toggles changed but not yet saved -->
                                        <div class="grant-chips" id="chips-{{ $role->id }}"></div>
                                        <!-- Hint: visible only when there are pending (unsaved) grants -->
                                        <div class="hint-save" id="hint-{{ $role->id }}">
                                            <i class="fa-solid fa-eye" style="font-size:11px;"></i> Save changes to
                                            unlock "View As"
                                        </div>
                                    </div>
                                    <div style="display:flex; gap:10px; align-items:center; flex-shrink:0;">
                                        <!-- View As button — only appears after at least one save with grants -->
                                        <button type="button" class="btn-view-as" id="viewas-{{ $role->id }}"
                                            onclick="openViewAs()">
                                            <i class="fa-solid fa-eye" style="font-size:13px;"></i> View As
                                            <span class="va-count-badge" id="va-badge-{{ $role->id }}">0</span>
                                        </button>
                                        <button type="submit" class="btn-save">
                                            <i class="fa-solid fa-floppy-disk" style="font-size:13px;"></i> Save
                                            Changes
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

    <!-- ════════════════ FOOTER ════════════════ -->
    <footer id="siteFooter" class="footer bg-[#8B0000] text-[#F4F4F4] p-6 transition-all duration-300"
        style="margin-left:240px;">
        <div
            class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 text-sm text-center">
            <span><span class="text-gray-300">© 2025–2026</span> <span class="font-semibold">Polytechnic
                    University of
                    the Philippines</span></span>
            <span class="hidden sm:inline">|</span>
            <a href="https://www.pup.edu.ph/terms/" class="hover:underline">Terms of Use</a>
            <span class="hidden sm:inline">|</span>
            <a href="https://www.pup.edu.ph/privacy/" class="hover:underline">Privacy Statement</a>
        </div>
    </footer>

    <!-- ════ VIEW AS MODAL ════ -->
    <div class="va-overlay" id="vaOverlay" onclick="if(event.target===this)closeViewAs()">
        <div class="va-panel">
            <div class="va-head">
                <div
                    style="width:46px;height:46px;border-radius:13px;background:linear-gradient(135deg,#EFF6FF,#DBEAFE);border:1.5px solid #BFDBFE;display:flex;align-items:center;justify-content:center;font-size:19px;color:#1D4ED8;flex-shrink:0;">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-size:19px;font-weight:800;color:#1E293B;margin-bottom:3px;">View As —
                        Select Role
                    </div>
                    <div style="font-size:13px;color:#8A7A6F;" id="vaSubtitle">Select a role to preview their
                        dashboard access</div>
                </div>
                <button onclick="closeViewAs()"
                    style="margin-left:auto;width:34px;height:34px;border-radius:9px;background:#F5EFE9;border:none;cursor:pointer;color:#8A7A6F;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="va-body">
                <div class="va-summary">
                    <div
                        style="width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <div style="font-size:12px;opacity:.75;margin-bottom:2px;">Total newly granted &amp;
                            saved
                            permissions</div>
                        <div style="display:flex;align-items:baseline;gap:6px;">
                            <span style="font-size:22px;font-weight:800;" id="vaTotalPerms">0</span>
                            <span style="font-size:13px;opacity:.8;">permissions across</span>
                            <span style="font-size:22px;font-weight:800;" id="vaTotalRoles">0</span>
                            <span style="font-size:13px;opacity:.8;">roles</span>
                        </div>
                    </div>
                </div>
                <div
                    style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#B5A99A;margin-bottom:10px;">
                    Roles with newly granted access</div>
                <div id="vaRoleList"></div>
            </div>
            <div class="va-foot">
                <button onclick="closeViewAs()"
                    style="background:#F5EFE9;color:#6B5E56;border:none;border-radius:10px;padding:10px 22px;font-weight:600;font-size:14px;cursor:pointer;font-family:'Inter',sans-serif;">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- REDIRECT OVERLAY -->
    <div class="redirect-overlay" id="redirectOverlay">
        <div class="redirect-spinner"></div>
        <div id="redirectText" style="font-size:16px;font-weight:700;color:#fff;margin-bottom:6px;"></div>
        <div id="redirectSub" style="font-size:13px;color:rgba(255,255,255,.7);"></div>
    </div>

    <!-- TOAST -->
    <div class="toast-pop" id="toastPop">
        <div class="toast-icon"><i class="fa-solid fa-circle-check"></i></div>
        <div>
            <div id="toastTitle" style="font-weight:700;font-size:14px;color:#2D2420;"></div>
            <div id="toastSub" style="font-size:12px;color:#6B7280;margin-top:2px;"></div>
        </div>
    </div>

    <!-- ════ NEW ROLE MODAL ════ -->
    <div id="newRoleModal"
        style="display:none;position:fixed;inset:0;background:rgba(15,5,5,0.55);align-items:center;justify-content:center;z-index:200;backdrop-filter:blur(4px);">
        <div
            style="background:#fff;border-radius:20px;padding:36px 36px 28px;width:440px;box-shadow:0 32px 80px rgba(0,0,0,0.25);">
            <div
                style="width:48px;height:48px;border-radius:14px;background:#FFF0F0;border:1.5px solid #7B0D0D30;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:16px;">
                <i class="fa-solid fa-user-shield" style="color:#7B0D0D;"></i>
            </div>
            <h2 style="margin:0 0 6px;font-size:22px;font-weight:800;color:#7B0D0D;">Create New Role</h2>
            <p style="margin:0 0 22px;font-size:14px;color:#8A7A6F;">Define a new role and assign permissions
                right
                after creating it.</p>

            <label
                style="display:block;font-size:12px;font-weight:700;color:#6B5E56;letter-spacing:0.5px;text-transform:uppercase;margin-bottom:6px;">Role
                Name</label>
            <input id="newRoleName" type="text" placeholder="e.g. Dental Intern"
                style="width:100%;padding:12px 16px;border:1.5px solid #EDE8E2;border-radius:10px;font-size:15px;font-family:'Inter',sans-serif;outline:none;color:#2D2420;margin-bottom:10px;transition:border-color 0.18s;"
                onfocus="this.style.borderColor='#7B0D0D'" onblur="this.style.borderColor='#EDE8E2'"
                onkeydown="if(event.key==='Enter') createNewRole()">

            <label
                style="display:block;font-size:12px;font-weight:700;color:#6B5E56;letter-spacing:0.5px;text-transform:uppercase;margin-bottom:6px;">Role
                Slug</label>
            <input id="newRoleSlug" type="text" placeholder="e.g. dental-intern"
                style="width:100%;padding:12px 16px;border:1.5px solid #EDE8E2;border-radius:10px;font-size:15px;font-family:'Inter',sans-serif;outline:none;color:#2D2420;margin-bottom:22px;transition:border-color 0.18s;"
                onfocus="this.style.borderColor='#7B0D0D'" onblur="this.style.borderColor='#EDE8E2'">

            <div id="newRoleError"
                style="display:none;color:#B91C1C;font-size:13px;margin-bottom:12px;background:#FEF2F2;border-radius:8px;padding:8px 12px;">
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button onclick="closeNewRoleModal()"
                    style="background:#F5EFE9;color:#6B5E56;border:none;border-radius:10px;padding:11px 22px;font-weight:600;font-size:14px;cursor:pointer;font-family:'Inter',sans-serif;">
                    Cancel
                </button>
                <form id="createRoleForm" action="{{ route('admin.role_permissions.store_role') }}" method="POST"
                    style="display:contents;">
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


    <div class="va-overlay" id="patientPickerOverlay" onclick="if(event.target===this)closePatientPicker()">
        <div class="va-panel" style="width:760px;">
            <div class="va-head">
                <div
                    style="width:46px;height:46px;border-radius:13px;background:linear-gradient(135deg,#EFF6FF,#DBEAFE);border:1.5px solid #BFDBFE;display:flex;align-items:center;justify-content:center;font-size:19px;color:#1D4ED8;flex-shrink:0;">
                    <i class="fa-solid fa-user-injured"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-size:19px;font-weight:800;color:#1E293B;margin-bottom:3px;">Select Patient Account
                    </div>
                    <div style="font-size:13px;color:#8A7A6F;">Choose which patient account to impersonate</div>
                </div>
                <button onclick="closePatientPicker()"
                    style="margin-left:auto;width:34px;height:34px;border-radius:9px;background:#F5EFE9;border:none;cursor:pointer;color:#8A7A6F;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="va-body">
                <div style="margin-bottom:14px; position:relative;">

                    <i class="fa-solid fa-magnifying-glass"
                        style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#B5A99A; font-size:13px;">
                    </i>

                    <input type="text" id="patientPickerSearch" placeholder="Search patient name or email..."
                        class="search-input" style="padding-left:38px; padding-right:36px;"
                        oninput="filterPatientPicker(this.value)">

                    <!-- CLEAR BUTTON -->
                    <button onclick="clearPatientSearch()"
                        style="
        position:absolute;
        right:10px;
        top:50%;
        transform:translateY(-50%);
        border:none;
        background:none;
        color:#7B0D0D;
        font-size:13px;
        font-weight:600;
        cursor:pointer;
        font-family:'Inter',sans-serif;
    ">
                        Clear
                    </button>
                </div>

                <div id="patientPickerList"></div>
            </div>

            <div class="va-foot"
                style="
    display:flex;
    justify-content:flex-end;
    padding:18px 22px;
    border-top:1px solid #EDE8E2;
    background:#FAF8F6;
">

                <button onclick="closePatientPicker()"
                    style="
            background:#F5EFE9;
            color:#6B5E56;
            border:none;
            border-radius:10px;
            padding:10px 22px;
            font-weight:600;
            font-size:14px;
            cursor:pointer;
            font-family:'Inter',sans-serif;
            transition:all .15s ease;
        "
                    onmouseover="this.style.background='#EDE6DF'" onmouseout="this.style.background='#F5EFE9'">
                    Cancel
                </button>

            </div>

            <!-- ══════════════════════════════════════
         SCRIPTS
    ══════════════════════════════════════ -->
            <script>
                /* ══════════════════════════════════════
                                                               MODULE LIST — mirrors your DB exactly
                                                            ══════════════════════════════════════ */
                const PERM_MODULES = [{
                        module: 'Dashboard',
                        icon: 'fa-chart-line',
                        color: '#7B0D0D'
                    },
                    {
                        module: 'Patients',
                        icon: 'fa-users',
                        color: '#B45309'
                    },
                    {
                        module: 'Appointments',
                        icon: 'fa-calendar-check',
                        color: '#065F46'
                    },
                    {
                        module: 'Document Requests',
                        icon: 'fa-file-circle-check',
                        color: '#1D4ED8'
                    },
                    {
                        module: 'Document Template',
                        icon: 'fa-file-pen',
                        color: '#6D28D9'
                    },
                    {
                        module: 'Reports',
                        icon: 'fa-chart-column',
                        color: '#6D28D9'
                    },
                    {
                        module: 'Academic Periods',
                        icon: 'fa-school',
                        color: '#065F46'
                    },
                    {
                        module: 'Data Backup',
                        icon: 'fa-database',
                        color: '#EA580C'
                    },
                    {
                        module: 'System Logs',
                        icon: 'fa-clipboard-list',
                        color: '#6D28D9'
                    },
                    {
                        module: 'System Settings',
                        icon: 'fa-gear',
                        color: '#374151'
                    },
                ];

                function getModuleColor(module) {
                    const found = PERM_MODULES.find(m => m.module === module);
                    return found ? found.color : '#374151';
                }

                /* ══════════════════════════════════════
                   View-As state
                ══════════════════════════════════════ */
                const savedGrants = {};
                const pendingGrants = {};

                const flashedViewAs = JSON.parse('@json(session('saved_view_as') ?? 'null')');

                if (flashedViewAs && flashedViewAs.role_id) {
                    savedGrants[String(flashedViewAs.role_id)] = (flashedViewAs.permissions || []).map(p => ({
                        name: p.name,
                        slug: p.slug,
                        color: getModuleColor(p.module)
                    }));
                }

                /* ══════════════════════════════════════
                   SIDEBAR
                ══════════════════════════════════════ */
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

                function toggleSidebarGroup(id, e) {
                    e.stopPropagation();

                    if (!sidebarExpanded) {
                        const flyout = document.getElementById('flyout-' + id);
                        const rect = e.currentTarget.getBoundingClientRect();
                        flyout.style.top = rect.top + 'px';

                        if (openFlyout && openFlyout !== flyout) {
                            openFlyout.classList.remove('open');
                        }

                        flyout.classList.toggle('open');
                        openFlyout = flyout.classList.contains('open') ? flyout : null;
                        return;
                    }

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

                document.addEventListener('click', () => {
                    closeAllFlyouts();
                    const notifMenu = document.getElementById('notifMenu');
                    if (notifMenu) notifMenu.classList.remove('open');
                });

                document.getElementById('notifBtn')?.addEventListener('click', e => {
                    e.stopPropagation();
                    document.getElementById('notifMenu')?.classList.toggle('open');
                });

                /* ══════════════════════════════════════
                   THEME
                ══════════════════════════════════════ */
                const html = document.documentElement;

                function applyTheme(theme) {
                    html.setAttribute('data-theme', theme);
                    localStorage.setItem('theme', theme);

                    document.querySelectorAll('.theme-option').forEach(o => {
                        if (o.getAttribute('data-theme') === theme) {
                            o.classList.add('active');
                        } else {
                            o.classList.remove('active');
                        }
                    });

                    const ind = document.querySelector('.theme-indicator');
                    if (ind) {
                        if (theme === 'dark') ind.classList.add('dark-mode');
                        else ind.classList.remove('dark-mode');
                    }
                }

                document.addEventListener('DOMContentLoaded', () => {
                    applyLayout('240px');
                    applyTheme(localStorage.getItem('theme') || 'light');

                    document.querySelectorAll('.theme-option').forEach(o => {
                        o.addEventListener('click', e => {
                            e.stopPropagation();
                            applyTheme(o.getAttribute('data-theme'));
                        });
                    });

                    const firstCard = document.querySelector('.role-card');
                    const protectedBanner = document.getElementById('protectedBanner');

                    if (firstCard && protectedBanner && firstCard.dataset.isSuper === '1') {
                        protectedBanner.style.display = 'flex';
                    }

                    document.querySelectorAll('.role-form').forEach(form => {
                        const roleId = form.dataset.roleId;
                        if (!roleId) return;

                        if (!savedGrants[roleId]) savedGrants[roleId] = [];
                        if (!pendingGrants[roleId]) pendingGrants[roleId] = [];

                        const checkedPerms = form.querySelectorAll('.perm-toggle:checked');
                        checkedPerms.forEach(input => {
                            if (!savedGrants[roleId].find(p => p.slug === input.dataset.permSlug)) {
                                savedGrants[roleId].push({
                                    name: input.dataset.permName || '',
                                    slug: input.dataset.permSlug || '',
                                    color: input.dataset.color || '#374151'
                                });
                            }
                        });

                        updateFooterMsg(roleId);
                        updateFooterExtras(roleId);

                        const toggles = form.querySelectorAll('.perm-toggle');
                        const modules = [...new Set(Array.from(toggles).map(t => t.dataset.module).filter(
                            Boolean))];

                        modules.forEach(module => {
                            const sample = form.querySelector(`.perm-toggle[data-module="${module}"]`);
                            if (!sample) return;

                            syncGroupMaster(roleId, module);
                            updateGroupCount(roleId, module);
                            updateDots(roleId, module, sample.dataset.color || '#374151');
                        });
                    });
                });

                /* ══════════════════════════════════════
                   ROLE CARD SELECT
                ══════════════════════════════════════ */
                function selectRole(card) {
                    document.querySelectorAll('.role-card').forEach(c => {
                        c.classList.remove('active');

                        const activeDot = c.querySelector('.active-dot');
                        if (activeDot) activeDot.style.display = 'none';

                        const progressFill = c.querySelector('.progress-fill');
                        if (progressFill) progressFill.style.background = '#C4B8AF';

                        const roleNameLabel = c.querySelector('.role-name-label');
                        if (roleNameLabel) roleNameLabel.style.color = '#2D2420';
                    });

                    card.classList.add('active');

                    const activeDot = card.querySelector('.active-dot');
                    if (activeDot) activeDot.style.display = 'block';

                    const progressFill = card.querySelector('.progress-fill');
                    if (progressFill) progressFill.style.background = 'linear-gradient(90deg,#7B0D0D,#C9973A)';

                    const roleId = card.dataset.roleId;
                    const roleName = card.dataset.roleName || '';
                    const granted = parseInt(card.dataset.granted || '0', 10);
                    const total = parseInt(card.dataset.total || '0', 10);
                    const pct = parseInt(card.dataset.pct || '0', 10);

                    document.getElementById('accentRoleName').textContent = roleName;
                    document.getElementById('accentPct').textContent = pct + '%';
                    document.getElementById('accentCount').textContent = granted + ' of ' + total + ' permissions active';
                    document.getElementById('accentBar').style.width = pct + '%';

                    const slug = (card.dataset.slug || '').toLowerCase();
                    const isSuper = ['super_admin', 'super-admin', 'superadmin'].includes(slug) || roleName.toLowerCase().includes(
                        'super');

                    const protectedBanner = document.getElementById('protectedBanner');
                    if (protectedBanner) {
                        protectedBanner.style.display = isSuper ? 'flex' : 'none';
                    }

                    document.querySelectorAll('.role-form').forEach(f => {
                        f.style.display = 'none';
                    });

                    const form = document.getElementById('form-role-' + roleId);
                    if (form) form.style.display = 'block';

                    const permSearch = document.getElementById('permSearch');
                    if (permSearch) permSearch.value = '';

                    filterPerms('');
                }

                /* ══════════════════════════════════════
                   PERMISSION GROUP COLLAPSE
                ══════════════════════════════════════ */
                let allExpanded = true;

                function togglePermGroup(header) {
                    const body = header.nextElementSibling;
                    const chev = header.querySelector('.chevron');
                    const isCollapsed = body.classList.contains('collapsed');

                    body.classList.toggle('collapsed');
                    chev.classList.toggle('collapsed', !isCollapsed);
                }

                function toggleAllGroups() {
                    const btn = document.getElementById('collapseBtn');
                    const visibleForm = [...document.querySelectorAll('.role-form')].find(f => f.style.display === 'block');
                    if (!visibleForm) return;

                    const bodies = visibleForm.querySelectorAll('.perm-group-body');
                    const chevs = visibleForm.querySelectorAll('.chevron');

                    allExpanded = !allExpanded;
                    bodies.forEach(b => b.classList.toggle('collapsed', !allExpanded));
                    chevs.forEach(c => c.classList.toggle('collapsed', !allExpanded));
                    btn.textContent = allExpanded ? 'Collapse All' : 'Expand All';
                }

                /* ══════════════════════════════════════
                   PER-PERMISSION TOGGLE
                ══════════════════════════════════════ */
                function onPermChange(input) {
                    const row = input.closest('.perm-row');
                    const badge = row.querySelector('.perm-status');
                    const dot = row.querySelector('.perm-dot');
                    const label = row.querySelector('.perm-label');
                    const color = input.dataset.color;
                    const roleId = input.dataset.role;
                    const mSlug = input.dataset.module;
                    const pName = input.dataset.permName;
                    const pSlug = input.dataset.permSlug;

                    if (input.checked) {
                        badge.textContent = 'Granted';
                        badge.className = 'perm-status status-granted';
                        badge.style.background = color + '18';
                        badge.style.color = color;
                        dot.style.background = color;
                        label.style.color = '#2D2420';
                        row.style.background = color + '06';

                        if (!pendingGrants[roleId]) pendingGrants[roleId] = [];
                        if (!pendingGrants[roleId].find(p => p.slug === pSlug)) {
                            pendingGrants[roleId].push({
                                name: pName,
                                slug: pSlug,
                                color
                            });
                        }
                    } else {
                        badge.textContent = 'Denied';
                        badge.className = 'perm-status status-denied';
                        badge.style.background = '';
                        badge.style.color = '';
                        dot.style.background = '#D5CEC8';
                        label.style.color = '#8A7A6F';
                        row.style.background = 'transparent';

                        if (pendingGrants[roleId]) {
                            pendingGrants[roleId] = pendingGrants[roleId].filter(p => p.slug !== pSlug);
                        }
                        if (savedGrants[roleId]) {
                            savedGrants[roleId] = savedGrants[roleId].filter(p => p.slug !== pSlug);
                        }
                    }

                    updateDots(roleId, mSlug, color);
                    updateGroupCount(roleId, mSlug);
                    syncGroupMaster(roleId, mSlug);
                    updateAccentCard(roleId);
                    updateFooterMsg(roleId);
                    updateFooterExtras(roleId);
                }

                /* ══════════════════════════════════════
                   GROUP "ALL" TOGGLE
                ══════════════════════════════════════ */
                function toggleGroupPerms(wrapper, roleId, mSlug, currentlyAllOn) {
                    const newState = !currentlyAllOn;
                    wrapper.setAttribute('onclick',
                        `event.stopPropagation(); toggleGroupPerms(this, '${roleId}', '${mSlug}', ${newState})`);

                    const form = document.getElementById('form-role-' + roleId);
                    if (!form) return;

                    form.querySelectorAll(`.perm-toggle[data-module="${mSlug}"]`).forEach(t => {
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
                        if (dots[i]) dots[i].style.background = t.checked ? color : '#E5DDD5';
                    });
                }

                function updateGroupCount(roleId, mSlug) {
                    const form = document.getElementById('form-role-' + roleId);
                    if (!form) return;

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

                /* ══════════════════════════════════════
                   FOOTER EXTRAS — chips + hint + View As
                ══════════════════════════════════════ */
                function updateFooterExtras(roleId) {
                    const pending = pendingGrants[roleId] || [];
                    const chipsEl = document.getElementById('chips-' + roleId);
                    const hintEl = document.getElementById('hint-' + roleId);
                    const vaBtn = document.getElementById('viewas-' + roleId);
                    const roleName = document.querySelector(`.role-card[data-role-id="${roleId}"]`)?.dataset.roleName || '';

                    if (chipsEl) {
                        chipsEl.innerHTML = '';
                        if (pending.length) {
                            const col = pending[0]?.color || '#374151';
                            chipsEl.innerHTML = `<span class="grant-chip" style="background:${col}18;color:${col};border:1px solid ${col}40;">
                <i class="fa-solid fa-circle-plus" style="font-size:9px;"></i>
                ${pending.length} new grant${pending.length > 1 ? 's' : ''} pending for ${roleName}
            </span>`;
                        }
                    }

                    if (hintEl) {
                        hintEl.classList.toggle('show', pending.length > 0);
                    }

                    if (vaBtn) {
                        const totalSavedRoles = Object.values(savedGrants).filter(a => a.length > 0).length;
                        const badge = document.getElementById('va-badge-' + roleId);

                        if (totalSavedRoles > 0) {
                            vaBtn.classList.add('show');
                            if (badge) badge.textContent = totalSavedRoles;
                        } else {
                            vaBtn.classList.remove('show');
                            if (badge) badge.textContent = '0';
                        }
                    }
                }

                /* ══════════════════════════════════════
                   FORM SUBMIT — move pending → saved
                ══════════════════════════════════════ */
                function onFormSubmit(roleId) {
                    const pending = pendingGrants[roleId] || [];
                    if (!savedGrants[roleId]) savedGrants[roleId] = [];

                    pending.forEach(p => {
                        if (!savedGrants[roleId].find(s => s.slug === p.slug)) {
                            savedGrants[roleId].push(p);
                        }
                    });

                    pendingGrants[roleId] = [];

                    document.querySelectorAll('[id^="viewas-"]').forEach(btn => {
                        const rid = btn.id.replace('viewas-', '');
                        const total = Object.values(savedGrants).filter(a => a.length > 0).length;
                        const badge = document.getElementById('va-badge-' + rid);

                        if (total > 0) {
                            btn.classList.add('show');
                            if (badge) badge.textContent = total;
                        } else {
                            btn.classList.remove('show');
                            if (badge) badge.textContent = '0';
                        }
                    });
                }

                /* ══════════════════════════════════════
                   SEARCH
                ══════════════════════════════════════ */
                function filterPerms(q) {
                    q = q.toLowerCase().trim();
                    const visibleForm = [...document.querySelectorAll('.role-form')].find(f => f.style.display === 'block');
                    if (!visibleForm) return;

                    visibleForm.querySelectorAll('.perm-row').forEach(row => {
                        const match = !q || (row.dataset.permSearch || '').includes(q);
                        row.style.display = match ? '' : 'none';
                    });

                    visibleForm.querySelectorAll('.perm-group').forEach(group => {
                        const visible = [...group.querySelectorAll('.perm-row')].some(r => r.style.display !== 'none');
                        group.style.display = visible ? '' : 'none';

                        if (q && visible) {
                            const b = group.querySelector('.perm-group-body');
                            if (b) b.classList.remove('collapsed');
                        }
                    });
                }

                /* ══════════════════════════════════════
                   VIEW AS MODAL
                ══════════════════════════════════════ */
                function openViewAs() {
                    const overlay = document.getElementById('vaOverlay');
                    const list = document.getElementById('vaRoleList');

                    if (!overlay || !list) return;

                    list.innerHTML = '';
                    let totalPerms = 0;
                    let totalRoles = 0;

                    Object.entries(savedGrants).forEach(([roleId, perms]) => {
                        if (!perms.length) return;

                        totalRoles++;
                        totalPerms += perms.length;

                        const card = document.querySelector(`.role-card[data-role-id="${roleId}"]`);
                        const roleName = card?.dataset.roleName || 'Role';
                        const roleSlug = card?.dataset.slug || '';
                        const words = roleName.split(' ').slice(0, 2);
                        const initials = words.map(w => w[0].toUpperCase()).join('');
                        const color = perms[0]?.color || '#374151';
                        const grad = `linear-gradient(135deg,${color},${hexDarken(color)})`;

                        const tags = perms.map(p => `
            <span class="va-perm-tag" style="background:${color}18;color:${color};border:1px solid ${color}40;">
                <i class="fa-solid fa-circle-check" style="font-size:8px;"></i> ${p.name}
            </span>
        `).join('');

                        list.innerHTML += `
            <div class="va-role-row" onclick="redirectToRole('${roleId}','${roleName}','${roleSlug}','${color}')">
                <div style="position:absolute;left:0;top:0;bottom:0;width:4px;background:${grad};border-radius:14px 0 0 14px;"></div>
                <div class="va-role-avatar" style="background:${grad};color:#fff;">${initials}</div>
                <div style="flex:1;">
                    <div style="font-size:14px;font-weight:700;color:#2D2420;margin-bottom:3px;">${roleName}</div>
                    <div style="font-size:12px;color:#8A7A6F;">${perms.length} new permission${perms.length > 1 ? 's' : ''} granted</div>
                    <div style="display:flex;flex-wrap:wrap;gap:5px;margin-top:7px;">${tags}</div>
                </div>
                <button class="va-go-btn" onclick="event.stopPropagation();redirectToRole('${roleId}','${roleName}','${roleSlug}','${color}')">
                    <i class="fa-solid fa-arrow-right" style="font-size:11px;"></i> Go to Dashboard
                </button>
            </div>`;
                    });

                    document.getElementById('vaTotalPerms').textContent = totalPerms;
                    document.getElementById('vaTotalRoles').textContent = totalRoles;
                    document.getElementById('vaSubtitle').textContent =
                        `${totalRoles} role${totalRoles > 1 ? 's' : ''} with newly granted access — select one to redirect`;

                    overlay.classList.add('open');
                    document.body.style.overflow = 'hidden';
                }

                function closeViewAs() {
                    const overlay = document.getElementById('vaOverlay');
                    if (overlay) overlay.classList.remove('open');
                    document.body.style.overflow = '';
                }

                function redirectToRole(roleId, roleName, roleSlug, color) {
                    if (roleSlug === 'patient') {
                        closeViewAs();
                        openPatientPicker(roleName, roleSlug, color);
                        return;
                    }

                    closeViewAs();

                    const ol = document.getElementById('redirectOverlay');

                    ol.style.background = `linear-gradient(135deg,${color},${hexDarken(color)})`;
                    document.getElementById('redirectText').textContent = `Redirecting to ${roleName} Dashboard…`;
                    document.getElementById('redirectSub').textContent = `Loading ${roleName} view for Super Admin`;

                    ol.classList.add('show');

                    fetch("{{ route('admin.impersonate') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Accept": "application/json"
                            },
                            body: JSON.stringify({
                                role: roleSlug
                            })
                        })
                        .then(async response => {
                            const data = await response.json();

                            if (!response.ok) {
                                throw new Error(data.message || "Unable to start impersonation.");
                            }

                            if (data.redirect) {
                                window.location.href = data.redirect;
                                return;
                            }

                            throw new Error("No redirect URL returned.");
                        })
                        .catch(error => {
                            ol.classList.remove('show');
                            showToast('Error', error.message || 'Something went wrong');
                        });
                }


                /* ══════════════════════════════════════
                   NEW ROLE MODAL
                ══════════════════════════════════════ */
                document.getElementById('newRoleName')?.addEventListener('input', function() {
                    document.getElementById('newRoleSlug').value = this.value.toLowerCase().trim()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
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

                    if (document.querySelector(`.role-card[data-slug="${slug}"]`)) {
                        errEl.textContent = 'A role with this slug already exists.';
                        errEl.style.display = 'block';
                        return;
                    }

                    errEl.style.display = 'none';

                    document.getElementById('createRoleName').value = name;
                    document.getElementById('createRoleSlug').value = slug;
                    document.getElementById('createRoleForm').submit();


                    const words = name.split(' ').slice(0, 2);
                    const initials = words.map(w => w[0].toUpperCase()).join('');
                    const badgeInfo = getRoleBadgeJS(name, slug);
                    const tempId = 'new-' + Date.now();

                    const card = document.createElement('div');
                    card.className = 'role-card card-new';
                    card.dataset.roleId = tempId;
                    card.dataset.roleName = name;
                    card.dataset.granted = '0';
                    card.dataset.total = '0';
                    card.dataset.pct = '0';
                    card.dataset.slug = slug;
                    card.dataset.isSuper = '0';
                    card.onclick = function() {
                        selectRole(this);
                    };

                    card.innerHTML = `
        <div style="display:flex;align-items:center;gap:12px;">
            <div class="role-avatar">${initials}</div>
            <div style="flex:1;">
                <div style="display:flex;align-items:center;gap:7px;margin-bottom:3px;">
                    <span style="font-weight:600;font-size:14px;color:#2D2420;" class="role-name-label">${name}</span>
                </div>
                <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                    <span class="badge-pill" style="background:${badgeInfo.color}18;color:${badgeInfo.color};border:1px solid ${badgeInfo.color}40;white-space:nowrap;">${badgeInfo.label}</span>
                    <span style="font-size:11px;color:#B5A99A;white-space:nowrap;">${slug}</span>
                </div>
            </div>
            <div class="active-dot" style="width:8px;height:8px;border-radius:50%;background:#7B0D0D;flex-shrink:0;display:none;"></div>
        </div>
        <div style="margin-top:12px;">
            <div style="display:flex;justify-content:space-between;font-size:11px;color:#B5A99A;margin-bottom:5px;">
                <span>Access level</span>
                <span style="font-weight:600;" class="pct-label">0%</span>
            </div>
            <div class="progress-bar"><div class="progress-fill" style="width:0%;background:#C4B8AF;"></div></div>
            <div style="font-size:11px;color:#C4B8AF;margin-top:4px;" class="count-label">0 of 0 permissions</div>
        </div>`;

                    document.getElementById('roleCardList').appendChild(card);
                    document.getElementById('roleCountLabel').textContent =
                        `Roles (${document.querySelectorAll('.role-card').length})`;

                    buildRoleForm(tempId, name, slug, badgeInfo.color);

                    savedGrants[tempId] = [];
                    pendingGrants[tempId] = [];

                    closeNewRoleModal();
                    showToast('Role created!', `"${name}" added. Grant permissions then save.`);

                    setTimeout(() => selectRole(card), 150);
                    document.getElementById('createRoleForm').submit();
                }

                function getRoleBadgeJS(name, slug) {
                    const n = name.toLowerCase();
                    const s = slug.toLowerCase();

                    if (n.includes('super') || s.includes('super')) return {
                        color: '#7B0D0D',
                        label: 'Full Access'
                    };
                    if (n.includes('dentist') || s.includes('dentist')) return {
                        color: '#B45309',
                        label: 'Clinical'
                    };
                    if (n.includes('staff') || s.includes('staff') || n.includes('clinic')) return {
                        color: '#065F46',
                        label: 'Front Desk'
                    };
                    if (n.includes('student') || s.includes('student') || n.includes('patient')) return {
                        color: '#4B5563',
                        label: 'Limited'
                    };

                    return {
                        color: '#6B7280',
                        label: 'Custom'
                    };
                }

                function buildRoleForm(roleId, roleName, slug, accentColor) {
                    let groupsHtml = '';

                    PERM_MODULES.forEach(grp => {
                        const mSlug = grp.module.toLowerCase().replace(/\s+/g, '-');
                        groupsHtml += `
        <div class="group-card perm-group" data-group="${grp.module.toLowerCase()}">
            <div class="perm-group-header" onclick="togglePermGroup(this)">
                <div class="perm-group-icon" style="background:${grp.color}15;color:${grp.color};border:1px solid ${grp.color}25;">
                    <i class="fa-solid ${grp.icon}"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-weight:700;font-size:14px;color:#2D2420;">${grp.module}</div>
                    <div style="font-size:12px;color:#B5A99A;" class="group-count">0 of 0 enabled</div>
                </div>
                <div style="display:flex;align-items:center;gap:14px;">
                    <div class="dot-row" id="dots-${roleId}-${mSlug}"></div>
                    <div class="all-toggle-wrap" onclick="event.stopPropagation();toggleGroupPerms(this,'${roleId}','${mSlug}',false)">
                        <span style="font-size:11px;color:#6B5E56;font-weight:600;">All</span>
                        <label class="toggle-switch" onclick="event.preventDefault();">
                            <input type="checkbox" class="group-master" data-role="${roleId}" data-module="${mSlug}">
                            <span class="toggle-track"></span>
                        </label>
                    </div>
                    <i class="fa-solid fa-chevron-up chevron"></i>
                </div>
            </div>
            <div class="perm-group-body">
                <div style="text-align:center;padding:16px;font-size:12px;color:#B5A99A;font-style:italic;">
                    <i class="fa-solid fa-circle-info" style="margin-right:5px;opacity:.6;"></i>
                    Permissions load after the role is saved to the database.
                </div>
            </div>
        </div>`;
                    });

                    const footerHtml = `
    <div class="footer-bar" id="footer-bar-${roleId}">
        <div style="display:flex;flex-direction:column;gap:6px;flex:1;min-width:0;">
            <div style="font-size:13px;color:#8A7A6F;" id="footer-msg-${roleId}">0 permissions enabled for ${roleName}</div>
            <div class="grant-chips" id="chips-${roleId}"></div>
            <div class="hint-save" id="hint-${roleId}">
                <i class="fa-solid fa-eye" style="font-size:11px;"></i> Save changes to unlock "View As"
            </div>
        </div>
        <div style="display:flex;gap:10px;align-items:center;flex-shrink:0;">
            <button type="button" class="btn-view-as" id="viewas-${roleId}" onclick="openViewAs()">
                <i class="fa-solid fa-eye" style="font-size:13px;"></i> View As
                <span class="va-count-badge" id="va-badge-${roleId}">0</span>
            </button>
            <button type="button" class="btn-save"
                onclick="showToast('Save in progress…','Role will be fully available after page reloads.')">
                <i class="fa-solid fa-floppy-disk" style="font-size:13px;"></i> Save Changes
            </button>
        </div>
    </div>`;

                    const form = document.createElement('form');
                    form.id = 'form-role-' + roleId;
                    form.className = 'role-form';
                    form.dataset.roleId = roleId;
                    form.style.display = 'none';
                    form.innerHTML =
                        `<div style="display:flex;flex-direction:column;gap:10px;" class="groups-container">${groupsHtml}</div>${footerHtml}`;

                    const allForms = document.querySelectorAll('.role-form');
                    const last = allForms[allForms.length - 1];
                    last.parentNode.insertBefore(form, last.nextSibling);
                }

                /* ══════════════════════════════════════
                   HELPERS
                ══════════════════════════════════════ */
                function hexDarken(hex) {
                    const r = parseInt(hex.slice(1, 3), 16);
                    const g = parseInt(hex.slice(3, 5), 16);
                    const b = parseInt(hex.slice(5, 7), 16);

                    return '#' +
                        Math.max(0, r - 45).toString(16).padStart(2, '0') +
                        Math.max(0, g - 45).toString(16).padStart(2, '0') +
                        Math.max(0, b - 45).toString(16).padStart(2, '0');
                }

                function showToast(title, sub) {
                    document.getElementById('toastTitle').textContent = title;
                    document.getElementById('toastSub').textContent = sub;

                    const t = document.getElementById('toastPop');
                    t.classList.add('show');

                    setTimeout(() => t.classList.remove('show'), 4500);
                }

                /* Keyboard shortcuts */
                document.addEventListener('keydown', e => {
                    if (e.key === 'Escape') {
                        closeViewAs();
                        if (document.getElementById('newRoleModal').style.display !== 'none') {
                            closeNewRoleModal();
                        }
                    }
                });

                document.getElementById('newRoleModal')?.addEventListener('click', function(e) {
                    if (e.target === this) closeNewRoleModal();
                });


                let patientAccountsCache = [];

                function escapeHtml(value) {
                    return String(value)
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        .replace(/"/g, '&quot;')
                        .replace(/'/g, '&#039;');
                }

                function closePatientPicker() {
                    const overlay = document.getElementById('patientPickerOverlay');
                    if (overlay) overlay.classList.remove('open');
                    document.body.style.overflow = '';
                }

                function openPatientPicker(roleName, roleSlug, color) {
                    fetch("{{ route('admin.patients.list') }}", {
                            method: "GET",
                            headers: {
                                "Accept": "application/json"
                            }
                        })
                        .then(async response => {
                            const data = await response.json();

                            if (!response.ok) {
                                throw new Error(data.message || 'Unable to load patients.');
                            }

                            patientAccountsCache = Array.isArray(data) ? data : [];
                            renderPatientPicker(patientAccountsCache);

                            const searchInput = document.getElementById('patientPickerSearch');
                            if (searchInput) {
                                searchInput.value = '';
                            }

                            document.getElementById('patientPickerOverlay').classList.add('open');
                            document.body.style.overflow = 'hidden';
                        })
                        .catch(error => {
                            showToast('Error', error.message || 'Unable to load patients');
                        });
                }

                function renderPatientPicker(patients) {
    const list = document.getElementById('patientPickerList');

    if (!list) return;

    if (!patients.length) {
        list.innerHTML = `
            <div style="
                text-align:center;
                padding:32px 20px;
                color:#8A7A6F;
                font-size:14px;
            ">
                No patient accounts found.
            </div>
        `;
        return;
    }

    list.innerHTML = patients.map(patient => {
        const patientName = (patient.name || 'Patient').replace(/'/g, "\\'");
        const patientEmail = patient.email || 'No email';
        const patientPhone = patient.phone || '';
        const patientInitial = (patient.name || 'P').charAt(0).toUpperCase();
        const searchText = ((patient.name || '') + ' ' + (patient.email || '')).toLowerCase();

        return `
            <div class="va-role-row" data-patient-search="${searchText}">
                <div class="va-role-avatar" style="background:linear-gradient(135deg,#065F46,#047857);color:#fff;">
                    ${patientInitial}
                </div>

                <div style="flex:1;">
                    <div style="font-size:14px;font-weight:700;color:#2D2420;margin-bottom:3px;">
                        ${escapeHtml(patient.name || 'Unnamed Patient')}
                    </div>
                    <div style="font-size:12px;color:#8A7A6F;">
                        ${escapeHtml(patientEmail)}
                    </div>
                    <div style="font-size:12px;color:#B5A99A;margin-top:4px;">
                        ID: ${patient.id}${patientPhone ? ' • ' + escapeHtml(patientPhone) : ''}
                    </div>
                </div>

                <button
                    type="button"
                    class="va-go-btn"
                    onclick="event.stopPropagation(); startPatientImpersonation('patient', 'patient', '#065F46', ${patient.id}, '${patientName}')">
                    <i class="fa-solid fa-arrow-right" style="font-size:11px;"></i> Impersonate
                </button>
            </div>
        `;
    }).join('');
}

                function filterPatientPicker(query) {
                    const q = query.toLowerCase().trim();
                    const list = document.getElementById('patientPickerList');

                    if (!list) return;

                    if (q === '') {
                        renderPatientPicker(patientAccountsCache);
                        return;
                    }

                    const filteredPatients = patientAccountsCache.filter(patient => {
                        const name = (patient.name || '').toLowerCase();
                        const email = (patient.email || '').toLowerCase();
                        return name.includes(q) || email.includes(q);
                    });

                    if (!filteredPatients.length) {
                        list.innerHTML = `
            <div style="
                text-align:center;
                padding:32px 20px;
                color:#8A7A6F;
            ">
                <div style="
                    font-size:16px;
                    font-weight:700;
                    color:#7B0D0D;
                    margin-bottom:8px;
                ">
                    No results for "${escapeHtml(query)}"
                </div>
                <div style="
                    font-size:14px;
                    color:#8A7A6F;
                ">
                    Try a different patient name.
                </div>
            </div>
        `;
                        return;
                    }

                    renderPatientPicker(filteredPatients);
                }

                function startPatientImpersonation(roleName, roleSlug, color, patientId, patientName) {
                    closePatientPicker();

                    const ol = document.getElementById('redirectOverlay');
                    ol.style.background = `linear-gradient(135deg,${color},${hexDarken(color)})`;
                    document.getElementById('redirectText').textContent = `Redirecting as ${patientName}…`;
                    document.getElementById('redirectSub').textContent = `Loading patient dashboard for Super Admin`;
                    ol.classList.add('show');

                    fetch("{{ route('admin.impersonate') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Accept": "application/json"
                            },
                            body: JSON.stringify({
                                role: roleSlug,
                                patient_id: patientId
                            })
                        })
                        .then(async response => {
                            const data = await response.json();

                            if (!response.ok) {
                                throw new Error(data.message || "Unable to start impersonation.");
                            }

                            if (data.redirect) {
                                window.location.href = data.redirect;
                                return;
                            }

                            throw new Error("No redirect URL returned.");
                        })
                        .catch(error => {
                            ol.classList.remove('show');
                            showToast('Error', error.message || 'Something went wrong');
                        });
                }

                function toggleClearBtn(value) {
                    const btn = document.getElementById('patientSearchClear');
                    if (!btn) return;

                    btn.style.display = value.trim() !== '' ? 'flex' : 'none';
                }

                function clearPatientSearch() {
                    const input = document.getElementById('patientPickerSearch');
                    const btn = document.getElementById('patientSearchClear');

                    if (!input) return;

                    input.value = '';
                    if (btn) btn.style.display = 'none';

                    filterPatientPicker('');
                }
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closePatientPicker();
                    }
                });

                function clearPatientSearch() {
                    const input = document.getElementById('patientPickerSearch');

                    if (!input) return;

                    input.value = '';
                    filterPatientPicker('');
                }
            </script>

</body>

</html>
