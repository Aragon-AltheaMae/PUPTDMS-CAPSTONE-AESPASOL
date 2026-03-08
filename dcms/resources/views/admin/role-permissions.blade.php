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
        body {
            font-family: 'Inter', sans-serif;
        }

        /* ── HEADER (unchanged) ── */
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
            padding: 8px 0 6px;
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
            padding: 8px 12px;
            border-bottom: 1px solid #f3f4f6;
            flex-shrink: 0;
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
            padding: 7px 8px;
            border-radius: 10px;
            color: #6b7280;
            cursor: pointer;
            transition: all .15s;
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
            font-size: .65rem;
            margin-left: auto;
            transition: transform .2s;
            display: block;
        }

        .group-chevron.open {
            transform: rotate(180deg);
        }

        #sidebar.collapsed .group-label-wrap,
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

        body,
        main,
        footer {
            transition: background-color .3s ease, color .3s ease;
        }

        #mainContent,
        footer {
            transition: margin-left .3s cubic-bezier(.4, 0, .2, 1);
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

        [data-theme="dark"] .sidebar-brand-text {
            color: #f87171;
        }

        .permission-section {
            background: #f6ebc6;
        }

        .permission-checkbox {
            width: 18px;
            height: 18px;
            accent-color: #8B0000;
            cursor: pointer;
        }

        .table-sticky thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #f9fafb;
        }
    </style>
</head>

@php $notifications = collect(value: $notifications ?? []);
$notifCount = $notifications->count();
@endphp

<body class="bg-[#F4F4F4] text-[#333333]">

    <!-- HEADER -->
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

    <!-- MAIN -->
    <main id="mainContent" class="pt-[100px] px-6 py-6 fade-up min-h-screen" style="margin-left:240px;">
        <div class="max-w-7xl mt-4 mx-auto fade-in">

            <div class="mb-5">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <i class="fa-solid fa-shield-halved text-[#8B0000] text-xs"></i>
                    <p>System Role and Permission Management</p>
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-[#8B0000] mt-1">Role Permissions</h1>
                <p class="text-gray-500 mt-2">Manage access for Super Admin, Dentist, and Patient by module and feature.</p>
            </div>

            @if(session('success'))
            <div class="mb-5 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-green-800 text-sm font-medium">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white rounded-2xl shadow border overflow-hidden">
                <div class="px-6 py-4 border-b flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-bold text-[#8B0000]">Permissions Matrix</h2>
                        <p class="text-sm text-gray-500">Check or uncheck access for each role, then save your changes.</p>
                    </div>

                    <div class="flex gap-3">
                        <form action="{{ route('admin.role_permissions.reset') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 font-semibold hover:bg-gray-50">
                                Reset Defaults
                            </button>
                        </form>

                        <button type="submit" form="permissions-form"
                            class="px-4 py-2 rounded-lg bg-[#8B0000] text-white font-semibold hover:bg-[#6f0000]">
                            Save Changes
                        </button>
                    </div>
                </div>

                <form id="permissions-form" action="{{ route('admin.role_permissions.update') }}" method="POST">
                    @csrf

                    <div class="overflow-x-auto max-h-[70vh] table-sticky">
                        <table class="min-w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="text-left px-6 py-4 border-b font-bold text-gray-700 min-w-[300px]">
                                        Module / Feature
                                    </th>

                                    @foreach($roles as $role)
                                    <th class="text-center px-6 py-4 border-b font-bold text-gray-700 min-w-[180px]">
                                        <div>{{ $role->name }}</div>
                                        <div class="text-xs font-medium text-gray-400 mt-1">
                                            {{ $role->slug }}
                                        </div>
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($groupedPermissions as $module => $permissions)
                                <tr class="permission-section">
                                    <td colspan="{{ count($roles) + 1 }}"
                                        class="px-6 py-3 border-b font-extrabold uppercase tracking-wider text-gray-800 text-sm">
                                        {{ $module }}
                                    </td>
                                </tr>

                                @foreach($permissions as $permission)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 border-b text-gray-800">
                                        <div class="font-semibold">{{ $permission->name }}</div>
                                        <div class="text-xs text-gray-400 mt-1">{{ $permission->slug }}</div>
                                    </td>

                                    @foreach($roles as $role)
                                    <td class="px-6 py-4 border-b text-center">
                                        <input
                                            type="checkbox"
                                            name="permissions[{{ $role->id }}][]"
                                            value="{{ $permission->id }}"
                                            class="permission-checkbox"
                                            {{ $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}>
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                                @empty
                                <tr>
                                    <td colspan="{{ count($roles) + 1 }}" class="px-6 py-10 text-center text-gray-500">
                                        No permissions found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <!-- <div class="mt-5">
                <a href="{{ route('admin.admin.dashboard') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#8B0000] text-white font-semibold hover:bg-[#6f0000]">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div> -->
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="footer bg-[#8B0000] text-[#F4F4F4] p-6">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 pl-24 text-sm text-center">
            <span><span class="text-gray-300">© 2025–2026</span> <span class="font-semibold">Polytechnic University of the Philippines</span></span>
            <span class="hidden sm:inline">|</span>
            <a href="https://www.pup.edu.ph/terms/" class="hover:underline">Terms of Use</a>
            <span class="hidden sm:inline">|</span>
            <a href="https://www.pup.edu.ph/privacy/" class="hover:underline">Privacy Statement</a>
        </div>
    </footer>

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
    </script>

</body>

</html>