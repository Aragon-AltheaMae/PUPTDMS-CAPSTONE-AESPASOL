<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User Management | PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <script>tailwind.config = { daisyui: { themes: false } }</script>

  <style>
    body { font-family: 'Inter', sans-serif; overflow-x: hidden; }

    .scrollbar-thin::-webkit-scrollbar { width: 6px; }
    .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
    .scrollbar-thin::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

    .header {
      position: fixed; top: 0; left: 0; right: 0; z-index: 50;
      background: linear-gradient(135deg, #6b0000 0%, #8B0000 100%);
      padding: 0 2rem; height: 62px;
      display: flex; align-items: center; justify-content: space-between;
      box-shadow: 0 2px 20px rgba(139,0,0,.25);
    }
    .header-left { display:flex; align-items:center; gap:.75rem; }
    .header-logo { width:36px; height:36px; object-fit:contain; }
    .header-title { font-size:.95rem; font-weight:700; color:#fff; letter-spacing:.01em; }
    .header-right { display:flex; align-items:center; gap:1.25rem; }
    .notif-btn {
      width:36px; height:36px; border-radius:50%;
      background:rgba(255,255,255,.12); border:none; cursor:pointer;
      color:#fff; font-size:.95rem; display:flex; align-items:center; justify-content:center;
      transition:background .15s; position:relative;
    }
    .notif-btn:hover { background:rgba(255,255,255,.22); }
    .notif-badge {
      position:absolute; top:-3px; right:-3px;
      background:#ff6b6b; color:#fff; font-size:.6rem; font-weight:700;
      width:16px; height:16px; border-radius:50%;
      display:flex; align-items:center; justify-content:center;
      border:2px solid #8B0000;
    }
    .header-user { display:flex; align-items:center; gap:.6rem; }
    .header-avatar { width:34px; height:34px; border-radius:50%; border:2px solid rgba(255,255,255,.4); object-fit:cover; }
    .header-name { font-size:.82rem; font-weight:600; color:#fff; line-height:1.2; }
    .header-role { font-size:.7rem; color:rgba(255,255,255,.7); font-style:italic; }

    #notifMenu {
      position:absolute; right:0; top:calc(100% + 10px); width:300px;
      background:#fff; border-radius:14px; box-shadow:0 8px 32px rgba(0,0,0,.12);
      border:1px solid #f0e6e6; opacity:0; transform:scale(.95) translateY(-6px);
      pointer-events:none; transition:all .2s; transform-origin:top right; z-index:100;
    }
    #notifMenu.open { opacity:1; transform:scale(1) translateY(0); pointer-events:auto; }
    #notifDropdown { position:relative; }

    #sidebar {
      position:fixed; left:0; top:62px; height:calc(100vh - 62px);
      background:#fff; box-shadow:2px 0 20px rgba(0,0,0,.07); z-index:40;
      display:flex; flex-direction:column;
      transition:width .3s cubic-bezier(.4,0,.2,1); overflow:hidden;
    }
    #sidebar.expanded { width:240px; }
    #sidebar.collapsed { width:68px; }
    .sidebar-inner { flex:1; overflow-y:auto; overflow-x:hidden; padding:10px 0 6px; }
    .sidebar-inner::-webkit-scrollbar { width:4px; }
    .sidebar-inner::-webkit-scrollbar-thumb { background:#e5e7eb; border-radius:4px; }

    .sidebar-toggle-row {
      display:flex; align-items:center; justify-content:flex-end;
      padding:6px 12px 10px; border-bottom:1px solid #f3f4f6; margin-bottom:4px;
    }
    #sidebar.collapsed .sidebar-toggle-row { justify-content:center; }
    .toggle-btn {
      width:32px; height:32px; border-radius:8px; border:none; cursor:pointer;
      color:#6b7280; background:#f9fafb; flex-shrink:0;
      display:flex; align-items:center; justify-content:center; transition:all .2s;
    }
    .toggle-btn:hover { background:#fee2e2; color:#8B0000; }

    .nav-group { margin:0 8px 2px; }
    .group-header {
      display:flex; align-items:center; width:100%; border:none; background:none;
      cursor:pointer; padding:7px 8px; border-radius:10px; transition:background .15s; color:#6b7280;
    }
    .group-header:hover { background:#fef2f2; color:#8B0000; }
    .group-header.active-group { background:#fef2f2; color:#8B0000; }
    .group-icon {
      width:34px; height:34px; border-radius:8px; flex-shrink:0;
      display:flex; align-items:center; justify-content:center; font-size:15px; transition:all .2s;
    }
    .group-header.active-group .group-icon { background:#8B0000; color:#fff; box-shadow:0 4px 12px rgba(139,0,0,.3); }
    .group-label-wrap { flex:1; text-align:left; overflow:hidden; margin-left:10px; }
    .group-label { font-size:.78rem; font-weight:700; white-space:nowrap; line-height:1.2; display:block; }
    .group-sublabel { font-size:.63rem; color:#9ca3af; white-space:nowrap; display:block; margin-top:1px; }
    .group-chevron { width:18px; height:18px; display:flex; align-items:center; justify-content:center; font-size:10px; transition:transform .25s; flex-shrink:0; }
    .group-chevron.open { transform:rotate(180deg); }
    #sidebar.collapsed .group-label-wrap { display:none; }
    #sidebar.collapsed .group-chevron { display:none; }
    .group-body { overflow:hidden; max-height:0; transition:max-height .3s cubic-bezier(.4,0,.2,1); }
    .group-body.open { max-height:500px; }
    #sidebar.collapsed .group-body { max-height:0 !important; }

    .nav-link {
      display:flex; align-items:center; gap:10px; padding:7px 10px 7px 44px;
      border-radius:8px; margin:1px 4px; font-size:.77rem; font-weight:500;
      color:#6b7280; text-decoration:none; transition:all .15s; white-space:nowrap;
    }
    .nav-link:hover { background:#fef2f2; color:#8B0000; padding-left:48px; }
    .nav-link.active { background:#8B0000; color:#fff; box-shadow:0 2px 8px rgba(139,0,0,.25); }
    .nav-link.active:hover { padding-left:44px; background:#8B0000; }
    .nav-link i { width:16px; text-align:center; font-size:12px; }
    .nav-sep { height:1px; background:#f3f4f6; margin:6px 12px; }

    .flyout-wrapper { position:relative; }
    .flyout-panel {
      position:fixed; left:76px; background:#fff; border-radius:12px;
      box-shadow:0 8px 32px rgba(0,0,0,.13); border:1px solid #f0e6e6;
      min-width:200px; padding:6px; opacity:0; transform:scale(.95) translateX(-6px);
      pointer-events:none; transition:all .2s cubic-bezier(.4,0,.2,1);
      transform-origin:left center; z-index:999;
    }
    .flyout-panel.open { opacity:1; transform:scale(1) translateX(0); pointer-events:auto; }
    .flyout-title { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#8B0000; padding:4px 8px 6px; border-bottom:1px solid #fde8e8; margin-bottom:4px; }
    .flyout-link { display:flex; align-items:center; gap:8px; padding:7px 10px; border-radius:8px; font-size:.77rem; font-weight:500; color:#374151; text-decoration:none; transition:all .15s; white-space:nowrap; }
    .flyout-link:hover { background:#fef2f2; color:#8B0000; }
    .flyout-link i { width:16px; text-align:center; font-size:12px; color:#8B0000; }

    .sidebar-bottom { padding:8px 8px 12px; border-top:1px solid #f3f4f6; }
    .theme-toggle-container {
      position:relative; display:flex; align-items:center; justify-content:space-between;
      width:100%; height:34px; background:#F5F5F5; border:1px solid #E0E0E0; border-radius:24px; transition:all .3s ease;
    }
    #sidebar.collapsed .theme-toggle-container { flex-direction:column; width:35px; height:96px; border-radius:24px; padding:4px; }
    #sidebar.collapsed .w-full { display:flex; justify-content:center; }
    .theme-option { position:relative; z-index:2; flex:1; height:40px; display:flex; align-items:center; justify-content:center; background:transparent; border:none; cursor:pointer; color:#9CA3AF; transition:color .2s ease; border-radius:8px; }
    #sidebar.collapsed .theme-option { width:35px; height:40px; flex:none; }
    .theme-option i { font-size:16px; }
    .theme-option.active { color:#374151; }
    .theme-indicator { position:absolute; background:white; border-radius:24px; box-shadow:0 2px 8px rgba(0,0,0,.1); transition:all .3s cubic-bezier(.4,0,.2,1); pointer-events:none; }
    #sidebar.expanded .theme-indicator { width:calc(50% - 2px); height:calc(100% - 8px); left:4px; top:4px; border-radius:20px; }
    #sidebar.expanded .theme-indicator.dark-mode { transform:translateX(calc(100% + 0px)); }
    #sidebar.collapsed .theme-indicator { width:calc(100% - 8px); height:calc(50% - 6px); left:4px; top:4px; border-radius:16px; }
    #sidebar.collapsed .theme-indicator.dark-mode { transform:translateY(calc(100% + 4px)); }
    .logout-btn { display:flex; align-items:center; gap:10px; width:100%; padding:8px 10px; border-radius:10px; border:none; background:none; cursor:pointer; color:#ef4444; font-size:.77rem; font-weight:600; transition:background .15s; }
    .logout-btn:hover { background:#fef2f2; }
    #sidebar.collapsed .logout-btn { justify-content:center; padding:8px; }
    #sidebar.collapsed .logout-text { display:none; }
    #sidebar.collapsed .settings-label { display:none; }

    body, main, footer { transition:background-color .3s ease, color .3s ease; }
    #mainContent, footer { transition:margin-left .3s cubic-bezier(.4,0,.2,1); }

    .stat-card { transition:transform .2s ease, box-shadow .2s ease; }
    .stat-card:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(0,0,0,.1); }

    .user-table-row { transition:background .15s; }
    .user-table-row:hover { background:#fef9f9; }

    .badge-role {
      display:inline-flex; align-items:center; gap:4px;
      font-size:11px; font-weight:700; padding:3px 10px; border-radius:99px;
    }

    .badge-active   { background:#d1fae5; color:#065f46; }
    .badge-inactive { background:#f3f4f6; color:#6b7280; }

    .action-btn { padding:6px 8px; border-radius:7px; border:none; cursor:pointer; font-size:12px; transition:all .15s; }
    .action-btn:hover { transform:scale(1.08); }
    .btn-edit   { background:#eff6ff; color:#2563eb; }
    .btn-edit:hover { background:#dbeafe; }
    .btn-toggle-on  { background:#fef3c7; color:#b45309; }
    .btn-toggle-on:hover  { background:#fde68a; }
    .btn-toggle-off { background:#d1fae5; color:#065f46; }
    .btn-toggle-off:hover { background:#a7f3d0; }
    .btn-reset  { background:#f3e8ff; color:#7c3aed; }
    .btn-reset:hover { background:#ede9fe; }

    .modal-overlay {
      position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:200;
      display:flex; align-items:center; justify-content:center; padding:1rem;
      opacity:0; pointer-events:none; transition:opacity .2s;
    }
    .modal-overlay.open { opacity:1; pointer-events:auto; }
    .modal-box {
      background:#fff; border-radius:20px; width:100%; max-width:560px;
      max-height:90vh; overflow-y:auto;
      transform:scale(.95) translateY(10px); transition:transform .25s cubic-bezier(.4,0,.2,1);
      box-shadow:0 24px 60px rgba(0,0,0,.18);
    }
    .modal-overlay.open .modal-box { transform:scale(1) translateY(0); }
    .modal-sm { max-width:420px; }

    .field-input { transition:border-color .15s, box-shadow .15s; }
    .field-input:focus { outline:none; border-color:#8B0000 !important; box-shadow:0 0 0 3px rgba(139,0,0,.1); }

    .page-btn {
      min-width:32px; height:32px; border-radius:8px; border:1px solid #e5e7eb;
      background:#fff; cursor:pointer; font-size:.78rem; font-weight:600;
      color:#6b7280; display:inline-flex; align-items:center; justify-content:center;
      padding:0 8px; transition:all .15s;
    }
    .page-btn:hover { background:#fef2f2; border-color:#8B0000; color:#8B0000; }
    .page-btn.active { background:#8B0000; border-color:#8B0000; color:#fff; }
    .page-btn:disabled { opacity:.4; cursor:not-allowed; pointer-events:none; }

    .flash-alert {
      display:flex; align-items:center; gap:10px;
      padding:.75rem 1rem; border-radius:12px; font-size:.82rem; font-weight:600; margin-bottom:1.25rem;
    }

    [data-theme="dark"] body { background-color:#000D1A; color:#E5E7EB; }
    [data-theme="dark"] #sidebar { background-color:#0d1117; }
    [data-theme="dark"] .bg-white { background-color:#161b22 !important; }
    [data-theme="dark"] .text-gray-800 { color:#e5e7eb !important; }
    [data-theme="dark"] .text-gray-500 { color:#9ca3af !important; }
    [data-theme="dark"] .border-gray-100 { border-color:#21262d !important; }
    [data-theme="dark"] .bg-gray-50 { background-color:#0d1117 !important; }
    [data-theme="dark"] .bg-\[\#f5f5f5\] { background-color:#000D1A !important; }
    [data-theme="dark"] .theme-toggle-container { background:#1F1F1F; border-color:#2A2A2A; }
    [data-theme="dark"] .theme-option { color:#6B7280; }
    [data-theme="dark"] .theme-option.active { color:#F3F4F6; }
    [data-theme="dark"] .theme-indicator { background:#2A2A2A; }
    [data-theme="dark"] .flyout-panel { background:#161b22; border-color:#2d1a1a; }
    [data-theme="dark"] .flyout-link { color:#d1d5db; }
    [data-theme="dark"] .nav-sep, [data-theme="dark"] .sidebar-bottom { border-color:#21262d; }
    [data-theme="dark"] .sidebar-toggle-row { border-color:#21262d; }
    [data-theme="dark"] .user-table-row:hover { background:#0d1117; }
    [data-theme="dark"] .modal-box { background:#161b22; }
    [data-theme="dark"] .modal-box input,
    [data-theme="dark"] .modal-box select { background:#0d1117 !important; border-color:#21262d !important; color:#e5e7eb !important; }
    [data-theme="dark"] table thead tr { background:#0d1117 !important; }
    [data-theme="dark"] .page-btn { background:#161b22; border-color:#21262d; color:#9ca3af; }
    [data-theme="dark"] .page-btn:hover { background:rgba(139,0,0,.2); border-color:#8B0000; color:#f87171; }
    [data-theme="dark"] .border-gray-200 { border-color:#21262d !important; }
    [data-theme="dark"] .bg-gray-100 { background-color:#21262d !important; }
  </style>
</head>

<body class="bg-[#f5f5f5] text-[#333333]">

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
          <div class="header-name">{{ session('admin_email') ?? 'Admin' }}</div>
          <div class="header-role">{{ session('role') ?? 'Administrator' }}</div>
        </div>
      </div>
    </div>
  </header>

  <aside id="sidebar" class="expanded">
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
          <a href="{{ route('admin.user_management') }}" class="nav-link {{ request()->routeIs('admin.user_management*') ? 'active' : '' }}"><i class="fa-solid fa-gear"></i> System Settings</a>
          <a href="{{ route('admin.role_permissions') }}" class="nav-link {{ request()->routeIs('admin.role_permissions') ? 'active' : '' }}"><i class="fa-solid fa-user-shield"></i> Roles &amp; Permissions</a>
        </div>
        <div class="flyout-panel" id="flyout-sys">
          <div class="flyout-title">System</div>
          <a href="{{ route('admin.admin.dashboard') }}" class="flyout-link"><i class="fa-solid fa-database"></i> Data Backup</a>
          <a href="{{ route('admin.system_logs') }}" class="flyout-link"><i class="fa-solid fa-clipboard-list"></i> System Logs</a>
          <a href="{{ route('admin.user_management') }}" class="flyout-link"><i class="fa-solid fa-gear"></i> System Settings</a>
          <a href="{{ route('admin.role_permissions') }}" class="flyout-link"><i class="fa-solid fa-user-shield"></i> Roles &amp; Permissions</a>
        </div>
      </div>
    </div>

    <div class="sidebar-bottom">
      <div class="text-[.65rem] font-semibold tracking-widest text-gray-400 uppercase mb-2 px-1 settings-label">Settings</div>
      <div class="w-full px-1 mb-3">
        <div id="themeToggle" class="theme-toggle-container">
          <button type="button" class="theme-option active" data-theme="light"><i class="fa-solid fa-sun"></i></button>
          <button type="button" class="theme-option" data-theme="dark"><i class="fa-regular fa-moon"></i></button>
          <div class="theme-indicator" aria-hidden="true"></div>
        </div>
      </div>
      <form action="{{ route('admin.logout') }}" method="POST">
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

  <main id="mainContent" class="pt-[100px] px-6 py-6 min-h-screen" style="margin-left:240px;">
    <div class="max-w-7xl mt-4 mx-auto">
      <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
          <i class="fa-solid fa-user-gear text-[#8B0000] text-xs"></i>
          <p id="currentDate"></p>
        </div>
        <div class="flex items-center justify-between flex-wrap gap-3">
          <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#8B0000]">User Management</h1>
            <p class="text-gray-500 text-sm mt-1">Manage system accounts, roles, and access permissions</p>
          </div>
          <button onclick="openModal('addModal')"
            class="flex items-center gap-2 bg-[#8B0000] hover:bg-[#760000] text-white px-5 py-2.5 rounded-lg font-semibold text-sm shadow transition-all">
            <i class="fa-solid fa-user-plus"></i> Add New User
          </button>
        </div>
      </div>

      @if(session('success'))
        <div class="flash-alert bg-green-50 border border-green-200 text-green-800">
          <i class="fa-solid fa-circle-check text-green-500"></i>
          {{ session('success') }}
          <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
      @endif

      @if(session('error'))
        <div class="flash-alert bg-red-50 border border-red-200 text-red-800">
          <i class="fa-solid fa-circle-xmark text-red-500"></i>
          {{ session('error') }}
          <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
      @endif

      @php
        $totalUsers    = $users->total();
        $activeCount   = \App\Models\User::where('status','active')->count();
        $inactiveCount = \App\Models\User::where('status','inactive')->count();
      @endphp

      <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
        <div class="stat-card bg-white rounded-xl p-4 shadow border border-gray-100 overflow-hidden relative">
          <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-[#8B0000]/5 to-transparent rounded-full -mr-10 -mt-10"></div>
          <div class="relative">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#6B0000] flex items-center justify-center shadow mb-3">
              <i class="fa-solid fa-users text-white text-sm"></i>
            </div>
            <p class="text-[10px] uppercase tracking-wide text-gray-500 font-semibold">Total Users</p>
            <p class="text-3xl font-extrabold text-gray-800">{{ $totalUsers }}</p>
          </div>
        </div>

        <div class="stat-card bg-white rounded-xl p-4 shadow border border-gray-100 overflow-hidden relative">
          <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-green-500/5 to-transparent rounded-full -mr-10 -mt-10"></div>
          <div class="relative">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow mb-3">
              <i class="fa-solid fa-circle-check text-white text-sm"></i>
            </div>
            <p class="text-[10px] uppercase tracking-wide text-gray-500 font-semibold">Active</p>
            <p class="text-3xl font-extrabold text-gray-800">{{ $activeCount }}</p>
          </div>
        </div>

        <div class="stat-card bg-white rounded-xl p-4 shadow border border-gray-100 overflow-hidden relative">
          <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-gray-400/5 to-transparent rounded-full -mr-10 -mt-10"></div>
          <div class="relative">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center shadow mb-3">
              <i class="fa-solid fa-user-slash text-white text-sm"></i>
            </div>
            <p class="text-[10px] uppercase tracking-wide text-gray-500 font-semibold">Inactive</p>
            <p class="text-3xl font-extrabold text-gray-800">{{ $inactiveCount }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden mb-6">
        <div class="px-5 py-4 border-b bg-gray-50 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-users-gear text-[#8B0000]"></i>
            <h2 class="font-bold text-gray-800 text-sm">All System Users</h2>
            <span class="text-[10px] font-bold bg-[#8B0000] text-white px-2 py-0.5 rounded-full">{{ $totalUsers }}</span>
          </div>

          <form method="GET" action="{{ route('admin.user_management') }}" class="flex flex-wrap items-center gap-2" id="filterForm">
            <div class="relative">
              <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
              <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search name or email…"
                class="field-input pl-8 pr-4 py-2 text-xs border border-gray-200 rounded-lg bg-white w-52"
                onchange="this.form.submit()">
            </div>

            <select name="role" class="field-input text-xs border border-gray-200 rounded-lg px-3 py-2 bg-white text-gray-600 cursor-pointer" onchange="this.form.submit()">
                <option value="">All Roles</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="dentist" {{ request('role') === 'dentist' ? 'selected' : '' }}>Dentist</option>
                <option value="patient" {{ request('role') === 'patient' ? 'selected' : '' }}>Patient</option>
            </select>

            <select name="status" class="field-input text-xs border border-gray-200 rounded-lg px-3 py-2 bg-white text-gray-600 cursor-pointer" onchange="this.form.submit()">
              <option value="">All Status</option>
              <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            @if(request()->hasAny(['search','role','status']))
              <a href="{{ route('admin.user_management') }}"
                class="text-xs text-gray-400 hover:text-[#8B0000] font-semibold flex items-center gap-1 transition-colors">
                <i class="fa-solid fa-xmark"></i> Clear
              </a>
            @endif
          </form>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
              <tr class="text-[10px] uppercase tracking-wide text-[#8B0000] font-bold">
                <th class="py-3 px-5 text-left w-12">#</th>
                <th class="py-3 px-4 text-left">User</th>
                <th class="py-3 px-4 text-left">Role</th>
                <th class="py-3 px-4 text-center">Status</th>
                <th class="py-3 px-4 text-left hidden lg:table-cell">Registered</th>
                <th class="py-3 px-5 text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
                <tr class="user-table-row border-b border-gray-50 last:border-0">
                  <td class="py-3.5 px-5">
                    <span class="text-xs text-gray-400 font-medium">{{ $users->firstItem() + $loop->index }}</span>
                  </td>

                  <td class="py-3.5 px-4">
                    <div class="flex items-center gap-3">
                      <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#b00000] flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                      </div>
                      <div>
                        <div class="font-semibold text-gray-800 text-sm leading-tight">{{ $user->name }}</div>
                        <div class="text-[11px] text-gray-400 mt-0.5">{{ $user->email }}</div>
                      </div>
                    </div>
                  </td>

                <td class="py-3.5 px-4">
                    <span class="badge-role"
                        style="background:
                        {{ $user->role_key === 'patient' ? '#dbeafe' : ($user->role_key === 'dentist' ? '#d1fae5' : '#fee2e2') }};
                        color:
                        {{ $user->role_key === 'patient' ? '#1d4ed8' : ($user->role_key === 'dentist' ? '#065f46' : '#8B0000') }};">
                        {{ $user->role_name }}
                    </span>
                </td>

                  <td class="py-3.5 px-4 text-center">
                    <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $user->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                      {{ ucfirst($user->status) }}
                    </span>
                  </td>

                  <td class="py-3.5 px-4 hidden lg:table-cell">
                    <span class="text-xs text-gray-400">{{ $user->created_at->format('M d, Y') }}</span>
                  </td>

                <td class="py-3.5 px-5">
                <div class="flex items-center justify-center gap-1.5">
                    @if($user->can_edit)
                    <button
                        onclick="openEditModal(
                        '{{ $user->source }}',
                        {{ $user->real_id }},
                        '{{ addslashes($user->name) }}',
                        '{{ addslashes($user->email) }}',
                        '{{ $user->role_id ?? '' }}',
                        '{{ $user->status }}'
                        )"
                        class="action-btn btn-edit" title="Edit account">
                        <i class="fa-solid fa-pen text-[11px]"></i>
                    </button>
                    @endif

                    @if($user->can_toggle && $user->source === 'users')
                    <form method="POST" action="{{ route('admin.user_management.toggle_status', $user->real_id) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                        class="action-btn {{ $user->status === 'active' ? 'btn-toggle-on' : 'btn-toggle-off' }}"
                        title="{{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}">
                        <i class="fa-solid {{ $user->status === 'active' ? 'fa-toggle-on' : 'fa-toggle-off' }} text-[11px]"></i>
                        </button>
                    </form>
                    @endif

                    @if($user->can_reset_password)
                    <button
                        onclick="openResetModal('{{ $user->source }}', {{ $user->real_id }}, '{{ addslashes($user->name) }}')"
                        class="action-btn btn-reset" title="Reset password">
                        <i class="fa-solid fa-key text-[11px]"></i>
                    </button>
                    @endif

                    <button
                    onclick="openViewModal(
                        '{{ addslashes($user->name) }}',
                        '{{ addslashes($user->email) }}',
                        '{{ addslashes($user->role_name) }}',
                        '{{ ucfirst($user->status) }}',
                        '{{ ucfirst($user->source) }}',
                        '{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('M d, Y h:i A') : 'N/A' }}'
                    )"
                    class="action-btn"
                    style="background:#f3f4f6;color:#374151;"
                    title="View details">
                    <i class="fa-solid fa-eye text-[11px]"></i>
                    </button>
                </div>
                </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center py-14">
                    <i class="fa-solid fa-users-slash text-5xl text-gray-300 mb-3 block"></i>
                    <p class="text-gray-400 text-sm">No users found</p>
                    @if(request()->hasAny(['search','role','status']))
                      <a href="{{ route('admin.user_management') }}" class="text-xs text-[#8B0000] font-semibold hover:underline mt-2 inline-block">Clear filters</a>
                    @endif
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-3">
          <p class="text-xs text-gray-500">
            Showing <span class="font-semibold">{{ $users->firstItem() ?? 0 }}</span>–<span class="font-semibold">{{ $users->lastItem() ?? 0 }}</span>
            of <span class="font-semibold">{{ $users->total() }}</span> users
          </p>
          <div class="flex items-center gap-1.5">
            @if($users->onFirstPage())
              <button class="page-btn" disabled><i class="fa-solid fa-chevron-left text-[10px]"></i></button>
            @else
              <a href="{{ $users->previousPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-left text-[10px]"></i></a>
            @endif

            @php
              $start = max(1, $users->currentPage() - 2);
              $end   = min($users->lastPage(), $users->currentPage() + 2);
            @endphp

            @if($start > 1)
              <a href="{{ $users->url(1) }}" class="page-btn">1</a>
              @if($start > 2)<span class="text-gray-400 text-xs px-1">…</span>@endif
            @endif

            @for($p = $start; $p <= $end; $p++)
              <a href="{{ $users->url($p) }}" class="page-btn {{ $p === $users->currentPage() ? 'active' : '' }}">{{ $p }}</a>
            @endfor

            @if($end < $users->lastPage())
              @if($end < $users->lastPage() - 1)<span class="text-gray-400 text-xs px-1">…</span>@endif
              <a href="{{ $users->url($users->lastPage()) }}" class="page-btn">{{ $users->lastPage() }}</a>
            @endif

            @if($users->hasMorePages())
              <a href="{{ $users->nextPageUrl() }}" class="page-btn"><i class="fa-solid fa-chevron-right text-[10px]"></i></a>
            @else
              <button class="page-btn" disabled><i class="fa-solid fa-chevron-right text-[10px]"></i></button>
            @endif
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer id="siteFooter" class="footer bg-[#8B0000] text-[#F4F4F4] p-6 transition-all duration-300" style="margin-left:240px;">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 text-sm text-center">
      <span><span class="text-gray-300">© 2025–2026</span> <span class="font-semibold">Polytechnic University of the Philippines</span></span>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/terms/" class="hover:underline">Terms of Use</a>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/privacy/" class="hover:underline">Privacy Statement</a>
    </div>
  </footer>

  <div class="modal-overlay" id="addModal" onclick="closeModalOutside(event,'addModal')">
    <div class="modal-box">
      <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#6B0000] flex items-center justify-center shadow">
            <i class="fa-solid fa-user-plus text-white text-sm"></i>
          </div>
          <div>
            <h3 class="font-extrabold text-gray-800 text-base">Add New User</h3>
            <p class="text-[10px] text-gray-500">Fill in the user's details below</p>
          </div>
        </div>
        <button onclick="closeModal('addModal')" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <form method="POST" action="{{ route('admin.user_management.store') }}" class="p-6 space-y-4">
        @csrf

        @if($errors->any())
          <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-xs text-red-700 space-y-1">
            @foreach($errors->all() as $error)
              <div class="flex items-center gap-1.5"><i class="fa-solid fa-circle-xmark"></i> {{ $error }}</div>
            @endforeach
          </div>
        @endif

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Full Name <span class="text-red-500">*</span></label>
          <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Juan dela Cruz"
            class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm" required>
        </div>

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Email Address <span class="text-red-500">*</span></label>
          <div class="relative">
            <i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="user@pup.edu.ph"
              class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm" required>
          </div>
        </div>

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Role</label>
          <select name="role_id" class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white">
            <option value="">— No Role —</option>
            @foreach($roles as $role)
              <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                {{ $role->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Status <span class="text-red-500">*</span></label>
          <div class="flex gap-4">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="status" value="active" {{ old('status','active') === 'active' ? 'checked' : '' }} style="accent-color:#8B0000;">
              <span class="text-sm text-gray-700 font-medium">Active</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="status" value="inactive" {{ old('status') === 'inactive' ? 'checked' : '' }} style="accent-color:#8B0000;">
              <span class="text-sm text-gray-700 font-medium">Inactive</span>
            </label>
          </div>
        </div>

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Password <span class="text-red-500">*</span></label>
          <div class="relative">
            <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="password" name="password" id="addPassword" placeholder="Min. 8 characters"
              class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-10 py-2.5 text-sm" required>
            <button type="button" onclick="togglePassVis('addPassword','addEye')"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
              <i class="fa-regular fa-eye text-xs" id="addEye"></i>
            </button>
          </div>
        </div>

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Confirm Password <span class="text-red-500">*</span></label>
          <div class="relative">
            <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="password" name="password_confirmation" id="addPasswordConf" placeholder="Repeat password"
              class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-10 py-2.5 text-sm" required>
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
      <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow">
            <i class="fa-solid fa-user-pen text-white text-sm"></i>
          </div>
          <div>
            <h3 class="font-extrabold text-gray-800 text-base">Edit User</h3>
            <p class="text-[10px] text-gray-500" id="editModalSubtitle">Updating user details</p>
          </div>
        </div>
        <button onclick="closeModal('editModal')" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <form method="POST" id="editForm" class="p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Full Name <span class="text-red-500">*</span></label>
          <input type="text" name="name" id="editName" placeholder="Full name"
            class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm" required>
        </div>

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Email Address <span class="text-red-500">*</span></label>
          <div class="relative">
            <i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="email" name="email" id="editEmail" placeholder="user@pup.edu.ph"
              class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm" required>
          </div>
        </div>

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Role</label>
          <select name="role_id" id="editRole" class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white">
            <option value="">— No Role —</option>
            @foreach($roles as $role)
              <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Status <span class="text-red-500">*</span></label>
          <div class="flex gap-4">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="status" id="editStatusActive" value="active" style="accent-color:#8B0000;">
              <span class="text-sm text-gray-700 font-medium">Active</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="status" id="editStatusInactive" value="inactive" style="accent-color:#8B0000;">
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
      <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow">
            <i class="fa-solid fa-key text-white text-sm"></i>
          </div>
          <div>
            <h3 class="font-extrabold text-gray-800 text-base">Reset Password</h3>
            <p class="text-[10px] text-gray-500" id="resetModalSubtitle">Set a new password</p>
          </div>
        </div>
        <button onclick="closeModal('resetModal')" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
    
    <!-- View Details Modal -->
    <div class="modal-overlay" id="viewModal" onclick="closeModalOutside(event,'viewModal')">
    <div class="modal-box modal-sm">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center shadow">
            <i class="fa-solid fa-eye text-white text-sm"></i>
            </div>
            <div>
            <h3 class="font-extrabold text-gray-800 text-base">Account Details</h3>
            <p class="text-[10px] text-gray-500">View selected account information</p>
            </div>
        </div>
        <button onclick="closeModal('viewModal')" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
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

      <form method="POST" id="resetForm" class="p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">New Password <span class="text-red-500">*</span></label>
          <div class="relative">
            <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="password" name="password" id="resetPassword" placeholder="Min. 8 characters"
              class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-10 py-2.5 text-sm" required>
            <button type="button" onclick="togglePassVis('resetPassword','resetEye')"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
              <i class="fa-regular fa-eye text-xs" id="resetEye"></i>
            </button>
          </div>
        </div>

        <div>
          <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Confirm Password <span class="text-red-500">*</span></label>
          <div class="relative">
            <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="password" name="password_confirmation" id="resetPasswordConf" placeholder="Repeat password"
              class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-10 py-2.5 text-sm" required>
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

  <script>
    document.getElementById('currentDate').textContent = new Date().toLocaleDateString('en-US',{weekday:'long',year:'numeric',month:'long',day:'numeric'});

    let sidebarExpanded = true;
    let openFlyout = null;

    function applyLayout(w) {
      document.getElementById('mainContent').style.marginLeft = w;
      document.getElementById('siteFooter').style.marginLeft = w;
    }

    function toggleSidebar() {
      sidebarExpanded = !sidebarExpanded;
      const s = document.getElementById('sidebar');
      const icon = document.getElementById('sidebarIcon');
      if (sidebarExpanded) {
        s.classList.replace('collapsed','expanded');
        applyLayout('240px');
        icon.className = 'fa-solid fa-xmark text-base';
        closeAllFlyouts();
      } else {
        s.classList.replace('expanded','collapsed');
        applyLayout('68px');
        icon.className = 'fa-solid fa-bars text-base';
      }
    }

    function toggleGroup(id, e) {
      e.stopPropagation();
      if (!sidebarExpanded) {
        const btn = e.currentTarget;
        const flyout = document.getElementById('flyout-' + id);
        const rect = btn.getBoundingClientRect();
        flyout.style.top = rect.top + 'px';
        if (openFlyout && openFlyout !== flyout) openFlyout.classList.remove('open');
        flyout.classList.toggle('open');
        openFlyout = flyout.classList.contains('open') ? flyout : null;
        return;
      }
      const body = document.getElementById('body-' + id);
      const chevron = document.getElementById('chevron-' + id);
      const isOpen = body.classList.contains('open');
      body.classList.toggle('open');
      if (chevron) chevron.classList.toggle('open');
      e.currentTarget.classList.toggle('active-group', !isOpen);
    }

    function closeAllFlyouts() {
      document.querySelectorAll('.flyout-panel').forEach(f => f.classList.remove('open'));
      openFlyout = null;
    }

    document.addEventListener('click', () => {
      closeAllFlyouts();
      document.getElementById('notifMenu').classList.remove('open');
    });

    document.getElementById('notifBtn').addEventListener('click', e => {
      e.stopPropagation();
      document.getElementById('notifMenu').classList.toggle('open');
    });

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

    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }
    function closeModalOutside(e, id) { if (e.target.id === id) closeModal(id); }

    @if($errors->any() && old('_method') !== 'PUT')
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
      applyLayout('240px');
      applyTheme(localStorage.getItem('theme') || 'light');
      document.querySelectorAll('.theme-option').forEach(o =>
        o.addEventListener('click', e => { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); })
      );

      document.querySelectorAll('.flash-alert').forEach(el => {
        setTimeout(() => { el.style.transition='opacity .4s'; el.style.opacity='0'; setTimeout(()=>el.remove(),400); }, 4000);
      });
    });
  </script>

</body>
</html>