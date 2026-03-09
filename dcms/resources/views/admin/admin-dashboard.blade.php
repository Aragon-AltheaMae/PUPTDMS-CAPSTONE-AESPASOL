<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard | PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
      overflow-x: hidden;
    }

    /* Custom Scrollbar */
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

    /* ── STAT CARDS ── */
    .stat-card {
      transition: transform .2s ease, box-shadow .2s ease;
    }

    .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, .1);
    }
  </style>
</head>

<body class="bg-[#f5f5f5] text-[#333333]">

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

      <!-- Date + Title -->
      <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
          <i class="fa-solid fa-sun text-yellow-400 text-xs"></i>
          <p id="currentDate"></p>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-[#8B0000]">Admin Dashboard</h1>
      </div>

      <!-- Academic Period Banner -->
      <div class="bg-white rounded-xl border-l-4 border-[#8B0000] shadow-sm mb-6 overflow-hidden">
        <div class="p-5 flex flex-col lg:flex-row gap-5 lg:items-center lg:justify-between">
          <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div>
              <div class="flex items-center gap-2 mb-1">
                <i class="fa-solid fa-calendar text-[#8B0000] text-sm"></i>
                <p class="text-[10px] tracking-widest text-gray-500 uppercase font-semibold">Current Semester</p>
              </div>
              <p class="text-xl font-bold text-gray-800">2nd Semester</p>
            </div>
            <div>
              <div class="flex items-center gap-2 mb-1">
                <i class="fa-solid fa-graduation-cap text-[#8B0000] text-sm"></i>
                <p class="text-[10px] tracking-widest text-gray-500 uppercase font-semibold">Academic Year</p>
              </div>
              <p class="text-xl font-bold text-gray-800">2025-2026</p>
            </div>
            <div>
              <div class="flex items-center gap-2 mb-1">
                <i class="fa-solid fa-clock text-[#8B0000] text-sm"></i>
                <p class="text-[10px] tracking-widest text-gray-500 uppercase font-semibold">Period Ends</p>
              </div>
              <p class="text-xl font-bold text-gray-800">June 10, 2026</p>
            </div>
          </div>
          <button class="bg-[#8B0000] hover:bg-[#760000] text-white px-5 py-2.5 rounded-lg font-semibold text-sm shadow transition-all lg:flex-shrink-0">
            <i class="fa-solid fa-gear mr-2"></i> Manage Periods
          </button>
        </div>
      </div>

      <!-- STATS CARDS -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        <div class="stat-card bg-white rounded-xl p-5 shadow border border-gray-100 overflow-hidden relative group hover:border-[#8B0000] transition-all">
          <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#8B0000]/5 to-transparent rounded-full -mr-16 -mt-16"></div>
          <div class="relative">
            <div class="flex items-center justify-between mb-3">
              <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#6B0000] flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-users text-white text-xl"></i>
              </div>
              <span class="text-xs font-semibold text-gray-400 bg-gray-100 px-3 py-1 rounded-full">All time</span>
            </div>
            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold mb-1">Total Patients</p>
            <p class="text-4xl font-extrabold text-gray-800 mb-1">1,234</p>
            <div class="flex items-center gap-1 text-xs text-gray-500">
              <i class="fa-solid fa-user-plus text-[10px]"></i>
              <span>All registered patients</span>
            </div>
          </div>
        </div>

        <div class="stat-card bg-white rounded-xl p-5 shadow border border-gray-100 overflow-hidden relative group hover:border-blue-400 transition-all">
          <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500/5 to-transparent rounded-full -mr-16 -mt-16"></div>
          <div class="relative">
            <div class="flex items-center justify-between mb-3">
              <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-calendar-check text-white text-xl"></i>
              </div>
              <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">December 2025</span>
            </div>
            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold mb-1">Appointments</p>
            <p class="text-4xl font-extrabold text-gray-800 mb-1">50</p>
            <div class="flex items-center gap-1 text-xs text-gray-500">
              <i class="fa-solid fa-clock text-[10px]"></i>
              <span>This month</span>
            </div>
          </div>
        </div>

        <div class="stat-card bg-white rounded-xl p-5 shadow border border-gray-100 overflow-hidden relative group hover:border-green-400 transition-all">
          <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-500/5 to-transparent rounded-full -mr-16 -mt-16"></div>
          <div class="relative">
            <div class="flex items-center justify-between mb-3">
              <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-file-circle-check text-white text-xl"></i>
              </div>
              <span class="text-xs font-semibold text-green-600 bg-green-50 px-3 py-1 rounded-full">December 2025</span>
            </div>
            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold mb-1">Documents Issued</p>
            <p class="text-4xl font-extrabold text-gray-800 mb-1">74</p>
            <div class="flex items-center gap-1 text-xs text-gray-500">
              <i class="fa-solid fa-file-lines text-[10px]"></i>
              <span>This month</span>
            </div>
          </div>
        </div>
      </div>

      <!-- MAIN CONTENT GRID -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">

          <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-[#8B0000]"></i>
                <h2 class="font-bold text-gray-800 text-sm">System Logs Overview</h2>
              </div>
              <a href="#" class="text-xs text-[#8B0000] font-semibold hover:underline flex items-center gap-1 group">
                View All <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
              </a>
            </div>
            <div class="p-5">
              <div class="grid grid-cols-5 gap-3 mb-5">
                <div class="text-center group cursor-pointer">
                  <div class="rounded-lg bg-purple-50 border border-purple-100 p-3 group-hover:bg-purple-100 transition-colors">
                    <div class="text-2xl font-extrabold text-purple-700">0</div>
                    <div class="text-[9px] font-semibold text-purple-600 uppercase tracking-wide mt-1">This Month</div>
                  </div>
                </div>
                <div class="text-center group cursor-pointer">
                  <div class="rounded-lg bg-blue-50 border border-blue-100 p-3 group-hover:bg-blue-100 transition-colors">
                    <div class="text-2xl font-extrabold text-blue-700">0</div>
                    <div class="text-[9px] font-semibold text-blue-600 uppercase tracking-wide mt-1">Info</div>
                  </div>
                </div>
                <div class="text-center group cursor-pointer">
                  <div class="rounded-lg bg-yellow-50 border border-yellow-100 p-3 group-hover:bg-yellow-100 transition-colors">
                    <div class="text-2xl font-extrabold text-yellow-700">0</div>
                    <div class="text-[9px] font-semibold text-yellow-600 uppercase tracking-wide mt-1">Warnings</div>
                  </div>
                </div>
                <div class="text-center group cursor-pointer">
                  <div class="rounded-lg bg-green-50 border border-green-100 p-3 group-hover:bg-green-100 transition-colors">
                    <div class="text-2xl font-extrabold text-green-700">0</div>
                    <div class="text-[9px] font-semibold text-green-600 uppercase tracking-wide mt-1">Backups</div>
                  </div>
                </div>
                <div class="text-center group cursor-pointer">
                  <div class="rounded-lg bg-red-50 border border-red-100 p-3 group-hover:bg-red-100 transition-colors">
                    <div class="text-2xl font-extrabold text-red-700">0</div>
                    <div class="text-[9px] font-semibold text-red-600 uppercase tracking-wide mt-1">Errors</div>
                  </div>
                </div>
              </div>
              <div class="overflow-x-auto rounded-lg border border-gray-100">
                <table class="table w-full text-sm">
                  <thead class="bg-gray-50">
                    <tr class="text-[#8B0000] text-xs">
                      <th class="w-16 font-bold py-3">ID</th>
                      <th class="w-40 font-bold py-3">Date</th>
                      <th class="font-bold py-3 text-left">Description</th>
                      <th class="w-32 font-bold py-3">User</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="4" class="text-center py-12">
                        <i class="fa-solid fa-inbox text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-400 text-sm">No logs to display</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
              <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <i class="fa-solid fa-chart-pie text-[#8B0000]"></i>
                  <h2 class="font-bold text-gray-800 text-sm">GAD Analytics</h2>
                </div>
                <a href="#" class="text-xs text-[#8B0000] font-semibold hover:underline">View</a>
              </div>
              <div class="p-5">
                <div class="h-40 rounded-lg border-2 border-dashed border-gray-200 flex items-center justify-center bg-gradient-to-br from-gray-50 to-white">
                  <div class="text-center">
                    <i class="fa-solid fa-chart-area text-4xl text-gray-300 mb-2"></i>
                    <p class="text-xs text-gray-400">Chart Placeholder</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
              <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <i class="fa-solid fa-boxes-stacked text-[#8B0000]"></i>
                  <h2 class="font-bold text-gray-800 text-sm">Inventory</h2>
                </div>
                <a href="#" class="text-xs text-[#8B0000] font-semibold hover:underline">View</a>
              </div>
              <div class="p-5">
                <div class="h-40 rounded-lg border-2 border-dashed border-gray-200 flex items-center justify-center bg-gradient-to-br from-gray-50 to-white">
                  <div class="text-center">
                    <i class="fa-solid fa-box text-4xl text-gray-300 mb-2"></i>
                    <p class="text-xs text-gray-400">Inventory Placeholder</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- Right Column -->
        <div class="space-y-6">

          <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b bg-gray-50">
              <div class="flex items-center gap-2">
                <i class="fa-solid fa-bolt text-[#8B0000]"></i>
                <h2 class="font-bold text-gray-800 text-sm">Quick Actions</h2>
              </div>
            </div>
            <div class="p-4 space-y-2.5">
              <button class="w-full flex items-center gap-3 bg-gradient-to-r from-red-50 to-white hover:from-red-100 hover:to-red-50 border border-red-100 rounded-lg px-4 py-3 text-left transition-all group">
                <div class="w-10 h-10 rounded-lg bg-white border border-red-200 flex items-center justify-center text-[#8B0000] shadow-sm group-hover:scale-110 transition-transform">
                  <i class="fa-solid fa-file-circle-plus"></i>
                </div>
                <div class="flex-1">
                  <div class="font-bold text-sm text-[#8B0000]">New Template</div>
                  <div class="text-[10px] text-gray-500">Create Document Format</div>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-300 text-xs group-hover:text-[#8B0000] group-hover:translate-x-1 transition-all"></i>
              </button>
              <button class="w-full flex items-center gap-3 bg-gradient-to-r from-red-50 to-white hover:from-red-100 hover:to-red-50 border border-red-100 rounded-lg px-4 py-3 text-left transition-all group">
                <div class="w-10 h-10 rounded-lg bg-white border border-red-200 flex items-center justify-center text-[#8B0000] shadow-sm group-hover:scale-110 transition-transform">
                  <i class="fa-solid fa-file-invoice"></i>
                </div>
                <div class="flex-1">
                  <div class="font-bold text-sm text-[#8B0000]">Generate Report</div>
                  <div class="text-[10px] text-gray-500">Create Report Documents</div>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-300 text-xs group-hover:text-[#8B0000] group-hover:translate-x-1 transition-all"></i>
              </button>
              <button class="w-full flex items-center gap-3 bg-gradient-to-r from-red-50 to-white hover:from-red-100 hover:to-red-50 border border-red-100 rounded-lg px-4 py-3 text-left transition-all group">
                <div class="w-10 h-10 rounded-lg bg-white border border-red-200 flex items-center justify-center text-[#8B0000] shadow-sm group-hover:scale-110 transition-transform">
                  <i class="fa-solid fa-chart-column"></i>
                </div>
                <div class="flex-1">
                  <div class="font-bold text-sm text-[#8B0000]">View Reports</div>
                  <div class="text-[10px] text-gray-500">All Reports</div>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-300 text-xs group-hover:text-[#8B0000] group-hover:translate-x-1 transition-all"></i>
              </button>
            </div>
          </div>

          <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b bg-gray-50">
              <div class="flex items-center gap-2">
                <i class="fa-solid fa-database text-[#8B0000]"></i>
                <h2 class="font-bold text-gray-800 text-sm">Data Backup</h2>
              </div>
            </div>
            <div class="p-4 space-y-3">
              <div class="rounded-lg bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 p-4">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-lg bg-white border border-green-300 flex items-center justify-center text-green-600 shadow-sm flex-shrink-0">
                    <i class="fa-solid fa-check text-lg"></i>
                  </div>
                  <div class="flex-1 min-w-0">
                    <div class="text-[10px] text-green-700 font-semibold uppercase tracking-wide mb-0.5">Last Backup</div>
                    <div class="text-sm font-bold text-gray-800 truncate">December 25, 2025</div>
                    <div class="text-[10px] text-gray-600 mt-1">Status: Successful</div>
                  </div>
                </div>
              </div>
              <div class="rounded-lg bg-gray-50 border border-gray-200 p-3.5 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <i class="fa-solid fa-clock text-gray-400"></i>
                  <div>
                    <div class="text-[10px] text-gray-500 font-semibold">Next Scheduled</div>
                    <div class="text-xs font-bold text-gray-700">March 30, 2026</div>
                  </div>
                </div>
              </div>
              <button class="w-full bg-gradient-to-r from-[#8B0000] to-[#6B0000] hover:from-[#760000] hover:to-[#5B0000] text-white font-bold py-3 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 group">
                <i class="fa-solid fa-database group-hover:scale-110 transition-transform"></i>
                <span>Run Backup Now</span>
              </button>
            </div>
          </div>

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

  <script>
    // ── Date ──
    const dateEl = document.getElementById('currentDate');
    if (dateEl) {
      dateEl.textContent = new Date().toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    }

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