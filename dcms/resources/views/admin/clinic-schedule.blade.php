<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Clinic Schedule | PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <script>tailwind.config = { daisyui: { themes: false } }</script>

  <style>
    /* ── Reuse identical shell styles from admin-dashboard.blade.php ── */
    body { font-family: 'Inter', sans-serif; overflow-x: hidden; }
    .scrollbar-thin::-webkit-scrollbar { width:6px; }
    .scrollbar-thin::-webkit-scrollbar-track { background:transparent; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background:#d1d5db; border-radius:10px; }

    /* HEADER */
    .header { position:fixed; top:0; left:0; right:0; z-index:50; background:linear-gradient(135deg,#6b0000 0%,#8B0000 100%); padding:0 2rem; height:62px; display:flex; align-items:center; justify-content:space-between; box-shadow:0 2px 20px rgba(139,0,0,.25); }
    .header-left { display:flex; align-items:center; gap:.75rem; }
    .header-logo { width:36px; height:36px; object-fit:contain; }
    .header-title { font-size:.95rem; font-weight:700; color:#fff; letter-spacing:.01em; }
    .header-right { display:flex; align-items:center; gap:1.25rem; }
    .notif-btn { width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,.12); border:none; cursor:pointer; color:#fff; font-size:.95rem; display:flex; align-items:center; justify-content:center; transition:background .15s; position:relative; }
    .notif-btn:hover { background:rgba(255,255,255,.22); }
    .notif-badge { position:absolute; top:-3px; right:-3px; background:#ff6b6b; color:#fff; font-size:.6rem; font-weight:700; width:16px; height:16px; border-radius:50%; display:flex; align-items:center; justify-content:center; border:2px solid #8B0000; }
    .header-user { display:flex; align-items:center; gap:.6rem; }
    .header-avatar { width:34px; height:34px; border-radius:50%; border:2px solid rgba(255,255,255,.4); object-fit:cover; }
    .header-name { font-size:.82rem; font-weight:600; color:#fff; line-height:1.2; }
    .header-role { font-size:.7rem; color:rgba(255,255,255,.7); font-style:italic; }
    #notifMenu { position:absolute; right:0; top:calc(100% + 10px); width:300px; background:#fff; border-radius:14px; box-shadow:0 8px 32px rgba(0,0,0,.12); border:1px solid #f0e6e6; opacity:0; transform:scale(.95) translateY(-6px); pointer-events:none; transition:all .2s; transform-origin:top right; z-index:100; }
    #notifMenu.open { opacity:1; transform:scale(1) translateY(0); pointer-events:auto; }
    #notifDropdown { position:relative; }

    /* SIDEBAR */
    #sidebar { position:fixed; left:0; top:62px; width:240px; height:calc(100vh - 62px); background:#fff; box-shadow:2px 0 20px rgba(0,0,0,.07); z-index:40; display:flex; flex-direction:column; overflow:hidden; }
    .sidebar-inner { flex:1; overflow-y:auto; overflow-x:hidden; padding:12px 0 6px; }
    .sidebar-inner::-webkit-scrollbar { width:4px; }
    .sidebar-inner::-webkit-scrollbar-thumb { background:#e5e7eb; border-radius:4px; }
    .nav-group { margin:0 8px 2px; }
    .group-header { display:flex; align-items:center; padding:7px 8px 5px; color:#6b7280; }
    .group-icon { width:34px; height:34px; border-radius:8px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:15px; }
    .group-header.active-group .group-icon { background:#8B0000; color:#fff; box-shadow:0 4px 12px rgba(139,0,0,.3); }
    .group-label-wrap { flex:1; text-align:left; overflow:hidden; margin-left:10px; }
    .group-label { font-size:.72rem; font-weight:700; white-space:nowrap; line-height:1.2; display:block; text-transform:uppercase; letter-spacing:.06em; }
    .group-sublabel { font-size:.62rem; color:#b0b8c4; white-space:nowrap; display:block; margin-top:1px; }
    .group-body { padding-bottom:4px; }
    .nav-link { display:flex; align-items:center; gap:10px; padding:7px 10px 7px 44px; border-radius:8px; margin:1px 4px; font-size:.77rem; font-weight:500; color:#6b7280; text-decoration:none; transition:all .15s; white-space:nowrap; }
    .nav-link:hover { background:#fef2f2; color:#8B0000; padding-left:48px; }
    .nav-link.active { background:#8B0000; color:#fff; box-shadow:0 2px 8px rgba(139,0,0,.25); }
    .nav-link.active:hover { padding-left:44px; background:#8B0000; }
    .nav-link i { width:16px; text-align:center; font-size:12px; }
    .nav-sep { height:1px; background:#f3f4f6; margin:8px 12px; }
    .sidebar-bottom { padding:8px 8px 12px; border-top:1px solid #f3f4f6; flex-shrink:0; }
    .theme-toggle-container { position:relative; display:flex; align-items:center; justify-content:space-between; width:100%; height:34px; background:#F5F5F5; border:1px solid #E0E0E0; border-radius:24px; }
    .theme-option { position:relative; z-index:2; flex:1; height:34px; display:flex; align-items:center; justify-content:center; background:transparent; border:none; cursor:pointer; color:#9CA3AF; transition:color .2s ease; border-radius:8px; }
    .theme-option i { font-size:16px; }
    .theme-option.active { color:#374151; }
    .theme-indicator { position:absolute; background:white; border-radius:20px; box-shadow:0 2px 8px rgba(0,0,0,.1); transition:all .3s cubic-bezier(.4,0,.2,1); pointer-events:none; width:calc(50% - 4px); height:calc(100% - 8px); left:4px; top:4px; }
    .theme-indicator.dark-mode { transform:translateX(calc(100%)); }
    .logout-btn { display:flex; align-items:center; gap:10px; width:100%; padding:8px 10px; border-radius:10px; border:none; background:none; cursor:pointer; color:#ef4444; font-size:.77rem; font-weight:600; transition:background .15s; }
    .logout-btn:hover { background:#fef2f2; }
    #mainContent, #siteFooter { margin-left:240px; }

    /* DARK MODE */
    body, main, footer { transition:background-color .3s ease, color .3s ease; }
    [data-theme="dark"] body { background-color:#000D1A; color:#E5E7EB; }
    [data-theme="dark"] #sidebar { background-color:#0d1117; border-right:1px solid #21262d; }
    [data-theme="dark"] .bg-white { background-color:#161b22 !important; }
    [data-theme="dark"] .text-\[\#333333\] { color:#E5E7EB !important; }
    [data-theme="dark"] .nav-link:hover { background:rgba(139,0,0,.2); }
    [data-theme="dark"] .theme-toggle-container { background:#1F1F1F; border-color:#2A2A2A; }
    [data-theme="dark"] .theme-option { color:#6B7280; }
    [data-theme="dark"] .theme-option.active { color:#F3F4F6; }
    [data-theme="dark"] .theme-indicator { background:#2A2A2A; box-shadow:0 2px 8px rgba(0,0,0,.3); }
    [data-theme="dark"] .nav-sep, [data-theme="dark"] .sidebar-bottom { border-color:#21262d; }
    [data-theme="dark"] .group-label { color:#6b7280; }

    /* MOBILE NAV */
    #adminMobileNav { display:none; position:fixed; bottom:0; left:0; right:0; height:68px; background:#fff; border-top:1px solid #f0e0e0; z-index:200; align-items:center; justify-content:space-around; box-shadow:0 -4px 20px rgba(139,0,0,.10); }
    .adm-mob-item { flex:1; height:68px; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:3px; font-size:9.5px; font-weight:600; color:#9ca3af; text-decoration:none; transition:color .2s; position:relative; cursor:pointer; border:none; background:none; padding:0; }
    .adm-mob-item.active { color:#8B0000; }
    .adm-mob-item i { font-size:20px; }
    #admMobFabWrap { flex:1; display:flex; align-items:center; justify-content:center; }
    #admMobFab { width:50px; height:50px; border-radius:50%; background:linear-gradient(135deg,#8B0000,#660000); color:white; border:none; font-size:20px; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 16px rgba(139,0,0,.45); cursor:pointer; transition:transform .25s cubic-bezier(.34,1.56,.64,1); position:relative; top:-10px; }
    #admMobFab.open { transform:rotate(45deg) translateY(-10px); }
    #admMobFabMenu { position:fixed; bottom:86px; left:50%; transform:translateX(-50%) scaleY(0); transform-origin:bottom center; background:#fff; border-radius:16px; box-shadow:0 8px 32px rgba(139,0,0,.18); border:1px solid #f5e8e8; min-width:220px; overflow:hidden; transition:transform .25s cubic-bezier(.34,1.56,.64,1),opacity .2s; opacity:0; pointer-events:none; z-index:300; }
    #admMobFabMenu.open { transform:translateX(-50%) scaleY(1); opacity:1; pointer-events:auto; }
    .adm-fab-item { display:flex; align-items:center; gap:12px; padding:13px 18px; font-size:13.5px; font-weight:600; color:#333; text-decoration:none; transition:background .15s; border-bottom:1px solid #fdf5f5; }
    .adm-fab-item:last-child { border-bottom:none; }
    .adm-fab-item:hover { background:#fff0f0; color:#8B0000; }
    .adm-fab-item .adm-fab-icon { width:32px; height:32px; background:#fef2f2; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:13px; color:#8B0000; flex-shrink:0; }

    @media (max-width:767px) {
      #sidebar { display:none !important; }
      #mainContent { margin-left:0 !important; padding-bottom:86px !important; }
      #siteFooter { margin-left:0 !important; margin-bottom:68px; }
      #adminMobileNav { display:flex; }
      .header { padding:0 1rem; }
      .header-title { display:none; }
    }
    @media (min-width:768px) { #adminMobileNav { display:none !important; } }
    [data-theme="dark"] #adminMobileNav { background:#0a0a0a; border-top-color:#1a1a1a; }
    [data-theme="dark"] .adm-mob-item { color:#4b5563; }
    [data-theme="dark"] .adm-mob-item.active { color:#ff6b6b; }

    /* TOAST */
    #toastContainer { position:fixed !important; top:20px !important; right:20px !important; z-index:99999; display:flex; flex-direction:column; gap:10px; pointer-events:none; }
    #toastContainer .toast { min-width:300px; max-width:360px; background:white !important; border-radius:14px !important; box-shadow:0 10px 40px rgba(0,0,0,.18) !important; padding:14px 18px 14px 16px !important; display:flex !important; align-items:center !important; gap:12px; opacity:0; transform:translateX(340px); transition:all .35s cubic-bezier(.68,-.55,.265,1.55); position:relative; overflow:hidden; pointer-events:all; flex-direction:row !important; }
    #toastContainer .toast::before { content:''; position:absolute; left:0; top:0; bottom:0; width:4px; }
    #toastContainer .toast.error::before { background:#8B0000 !important; }
    #toastContainer .toast.success::before { background:#15803d !important; }
    #toastContainer .toast.show { opacity:1 !important; transform:translateX(0) !important; }
    #toastContainer .toast.hide { opacity:0 !important; transform:translateX(340px) !important; }
    #toastContainer .toast-icon-wrap { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    #toastContainer .toast.error .toast-icon-wrap { background:rgba(139,0,0,.08); }
    #toastContainer .toast.success .toast-icon-wrap { background:rgba(21,128,61,.08); }
    #toastContainer .toast-icon { font-size:17px; }
    #toastContainer .toast.error .toast-icon { color:#8B0000 !important; }
    #toastContainer .toast.success .toast-icon { color:#15803d !important; }
    #toastContainer .toast-body { flex:1; min-width:0; }
    #toastContainer .toast-title { font-size:13px; font-weight:700; color:#1A0A0A !important; }
    #toastContainer .toast-msg { font-size:12px; color:#888 !important; margin-top:2px; line-height:1.4; }
    #toastContainer .toast-close { background:none !important; border:none; cursor:pointer; color:#CCC; font-size:13px; flex-shrink:0; padding:2px 4px; }

    /* PAGE SPECIFIC */
    .stat-card { transition:transform .2s ease,box-shadow .2s ease; }
    .stat-card:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(0,0,0,.1); }
    .sched-table { width:100%; border-collapse:collapse; }
    .sched-table thead tr { background:linear-gradient(135deg,#6b0000,#8B0000); }
    .sched-table thead th { color:#fff; font-size:.72rem; font-weight:700; padding:10px 14px; text-align:left; letter-spacing:.04em; text-transform:uppercase; }
    .sched-table tbody tr { border-bottom:1px solid #f8f4f4; transition:background .12s; }
    .sched-table tbody tr:hover { background:#fef5f5; }
    .sched-table tbody td { padding:11px 14px; font-size:.8rem; color:#374151; vertical-align:middle; }
    .badge-open   { background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; padding:2px 10px; border-radius:999px; font-size:.68rem; font-weight:700; }
    .badge-closed { background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0; padding:2px 10px; border-radius:999px; font-size:.68rem; font-weight:700; }
    .badge-limited{ background:#fef3c7; color:#92400e; border:1px solid #fde68a; padding:2px 10px; border-radius:999px; font-size:.68rem; font-weight:700; }
    .badge-holiday{ background:#dbeafe; color:#1e40af; border:1px solid #bfdbfe; padding:2px 10px; border-radius:999px; font-size:.68rem; font-weight:700; }
    .cap-bar { height:6px; border-radius:999px; background:#f0e8e8; overflow:hidden; }
    .cap-fill { height:100%; border-radius:999px; background:linear-gradient(90deg,#8B0000,#c9a84c); transition:width .4s ease; }

    /* Week grid */
    .week-grid { display:grid; grid-template-columns:80px repeat(7,1fr); border-radius:12px; overflow:hidden; border:1px solid #f0e8e8; }
    .wk-hdr { padding:10px 6px; text-align:center; font-size:.72rem; font-weight:700; color:#fff; background:linear-gradient(135deg,#6b0000,#8B0000); border-right:1px solid rgba(255,255,255,.15); }
    .wk-hdr.empty { background:#fafafa; border-right:1px solid #f0e8e8; }
    .wk-hdr.weekend-hdr { background:linear-gradient(135deg,#4a0000,#6b0000); }
    .wk-hdr.today-hdr  { background:linear-gradient(135deg,#8B0000,#c9a84c); }
    .time-lbl { font-size:.65rem; font-weight:600; color:#9ca3af; padding:8px; border-bottom:1px solid #f8f4f4; display:flex; align-items:center; border-right:1px solid #f0e8e8; background:#fafafa; }
    .cal-slot { border-bottom:1px solid #f8f4f4; border-right:1px solid #f8f4f4; min-height:54px; position:relative; transition:background .15s; cursor:pointer; padding: 2px; overflow:hidden; }
    .cal-slot:hover { background:#fef5f5; }
    .cal-slot.wk-closed  { background:#f8f8f8; cursor:not-allowed; opacity:.6; }
    .cal-slot.wk-break   { background:repeating-linear-gradient(45deg,#f8f8f8,#f8f8f8 6px,#fff 6px,#fff 12px); cursor:not-allowed; }
    .cal-slot.wk-weekend { background:#fcfcfc; cursor:not-allowed; }
    .slot-label { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:.6rem; color:#d1d5db; font-weight:600; pointer-events:none; }

    /* Modal */
    .modal-backdrop { position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:200; display:flex; align-items:center; justify-content:center; opacity:0; pointer-events:none; transition:opacity .2s; }
    .modal-backdrop.open { opacity:1; pointer-events:auto; }
    .modal-box { background:#fff; border-radius:20px; width:560px; max-width:calc(100vw - 2rem); max-height:calc(100vh - 4rem); overflow-y:auto; box-shadow:0 25px 60px rgba(0,0,0,.22); transform:scale(.94) translateY(12px); transition:transform .25s cubic-bezier(.34,1.56,.64,1); }
    .modal-backdrop.open .modal-box { transform:scale(1) translateY(0); }
    .modal-hdr { background:linear-gradient(135deg,#6b0000,#8B0000); padding:1.25rem 1.5rem; color:#fff; position:sticky; top:0; z-index:10; border-radius:20px 20px 0 0; }
    .modal-body { padding:1.5rem; }
    .form-label { font-size:.72rem; font-weight:700; color:#5c5550; text-transform:uppercase; letter-spacing:.06em; margin-bottom:.4rem; display:block; }
    .form-ctrl { width:100%; border:1.5px solid #e8e2dd; border-radius:10px; padding:8px 12px; font-size:.82rem; color:#1a1410; background:#fff; outline:none; transition:border-color .15s,box-shadow .15s; font-family:'Inter',sans-serif; }
    .form-ctrl:focus { border-color:#8B0000; box-shadow:0 0 0 3px rgba(139,0,0,.08); }
    .form-sel { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 10px center; background-size:16px; padding-right:32px; }
    .break-chip { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border-radius:8px; border:1.5px solid #e8e2dd; font-size:.72rem; font-weight:600; cursor:pointer; transition:all .15s; background:#fafaf8; color:#5c5550; user-select:none; }
    .break-chip:hover { border-color:#8B0000; color:#8B0000; background:#fef2f2; }
    .break-chip.selected { background:#f59e0b; color:#fff; border-color:#f59e0b; }
    .day-toggle { width:38px; height:38px; border-radius:50%; border:2px solid #e8e2dd; display:flex; align-items:center; justify-content:center; font-size:.7rem; font-weight:700; cursor:pointer; transition:all .15s; color:#9ca3af; background:#fff; user-select:none; }
    .day-toggle:hover { border-color:#8B0000; color:#8B0000; }
    .day-toggle.active { background:#8B0000; border-color:#8B0000; color:#fff; }

    /* Dark overrides for page-specific elements */
    [data-theme="dark"] .sched-table tbody tr { border-color:#21262d; }
    [data-theme="dark"] .sched-table tbody tr:hover { background:#1c2128; }
    [data-theme="dark"] .sched-table tbody td { color:#d1d5db; }
    [data-theme="dark"] .week-grid { border-color:#21262d; }
    [data-theme="dark"] .time-lbl { background:#0d1117; color:#6b7280; border-color:#21262d; }
    [data-theme="dark"] .cal-slot { border-color:#1c2128; }
    [data-theme="dark"] .cal-slot:hover { background:rgba(139,0,0,.1); }
    [data-theme="dark"] .modal-box { background:#161b22; }
    [data-theme="dark"] .form-ctrl { background:#0d1117; border-color:#30363d; color:#e6edf3; }
    [data-theme="dark"] .break-chip { background:#0d1117; border-color:#30363d; color:#8b949e; }
    [data-theme="dark"] .day-toggle { background:#0d1117; border-color:#30363d; color:#8b949e; }
  </style>
</head>

<body class="bg-[#f5f5f5] text-[#333333]">

<div id="toastContainer" role="region" aria-live="polite"></div>

@php $notifications = collect($notifications ?? []); $notifCount = $notifications->count(); @endphp

{{-- ════ HEADER (identical to admin-dashboard) ════ --}}
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
        <div style="padding:.85rem 1rem .65rem;font-weight:700;color:#8B0000;font-size:.82rem;border-bottom:1px solid #f5e8e8;">Notifications</div>
        <div style="max-height:260px;overflow-y:auto;">
          @forelse($notifications as $n)
            <a href="{{ $n['url'] ?? '#' }}" style="display:block;padding:.65rem 1rem;font-size:.78rem;color:#333;text-decoration:none;border-bottom:1px solid #fdf5f5;">
              <div style="font-weight:600;">{{ $n['title'] ?? 'Notification' }}</div>
              @if(!empty($n['message']))<div style="color:#aaa;margin-top:2px;">{{ $n['message'] }}</div>@endif
            </a>
          @empty
            <div style="padding:2rem 1rem;text-align:center;color:#bbb;font-size:.78rem;">You're all caught up.</div>
          @endforelse
        </div>
      </div>
    </div>
    <div class="header-user">
      <img src="https://i.pravatar.cc/40" class="header-avatar" alt="Avatar">
      <div>
        <div class="header-name">{{ auth()->user()->name ?? 'Admin' }}</div>
        <div class="header-role">Admin</div>
      </div>
    </div>
  </div>
</header>

{{-- ════ SIDEBAR (identical to admin-dashboard) ════ --}}
<aside id="sidebar">
  <div class="sidebar-inner">

    <div class="nav-group">
      <div class="group-header">
        <div class="group-icon"><i class="fa-solid fa-hospital"></i></div>
        <div class="group-label-wrap">
          <span class="group-label">Clinic Management</span>
          <span class="group-sublabel">Core clinical modules</span>
        </div>
      </div>
      <div class="group-body">
        <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
        <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-users"></i> Patients</a>
        <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
        <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-tooth"></i> Dental Records</a>
        <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-file-circle-check"></i> Document Request</a>
        <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-file"></i> Reports</a>
      </div>
    </div>

    <div class="nav-sep"></div>

    <div class="nav-group">
      <div class="group-header active-group">
        <div class="group-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
        <div class="group-label-wrap">
          <span class="group-label">Maintenance</span>
          <span class="group-sublabel">Configuration &amp; scheduling</span>
        </div>
      </div>
      <div class="group-body">
        <a href="{{ route('admin.user_management') }}"  class="nav-link {{ request()->routeIs('admin.user_management*') ? 'active':'' }}"><i class="fa-solid fa-user-gear"></i> User Management</a>
        <a href="{{ route('admin.role_permissions') }}" class="nav-link {{ request()->routeIs('admin.role_permissions') ? 'active':'' }}"><i class="fa-solid fa-user-shield"></i> Roles &amp; Permissions</a>
        <a href="{{ route('admin.academic_periods') }}" class="nav-link {{ request()->routeIs('admin.academic_periods*') ? 'active':'' }}"><i class="fa-solid fa-school"></i> Academic Periods</a>
        <a href="{{ route('admin.clinic_schedule') }}"  class="nav-link active"><i class="fa-solid fa-calendar-days"></i> Clinic Schedule</a>
        <a href="{{ route('admin.admin.dashboard') }}"  class="nav-link"><i class="fa-solid fa-list-check"></i> Service Types</a>
        <a href="{{ route('admin.admin.dashboard') }}"  class="nav-link"><i class="fa-solid fa-file-pen"></i> Document Templates</a>
        <a href="{{ route('admin.admin.dashboard') }}"  class="nav-link"><i class="fa-solid fa-boxes-stacked"></i> Inventory</a>
      </div>
    </div>

    <div class="nav-sep"></div>

    <div class="nav-group">
      <div class="group-header {{ request()->routeIs('admin.system_logs') ? 'active-group':'' }}">
        <div class="group-icon"><i class="fa-solid fa-server"></i></div>
        <div class="group-label-wrap">
          <span class="group-label">System</span>
          <span class="group-sublabel">Admin &amp; configuration</span>
        </div>
      </div>
      <div class="group-body">
        <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-database"></i> Data Backup</a>
        <a href="{{ route('admin.system_logs') }}"     class="nav-link {{ request()->routeIs('admin.system_logs') ? 'active':'' }}"><i class="fa-solid fa-clipboard-list"></i> System Logs</a>
        <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-sliders"></i> System Settings</a>
      </div>
    </div>

  </div>
  <div class="sidebar-bottom">
    <div class="text-[.65rem] font-semibold tracking-widest text-gray-400 uppercase mb-2 px-1">Settings</div>
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
        <span style="width:30px;height:30px;background:#fef2f2;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fa-solid fa-right-from-bracket text-sm"></i></span>
        <span class="font-semibold">Log out</span>
      </button>
    </form>
  </div>
</aside>

{{-- ════ MOBILE BOTTOM NAV ════ --}}
<nav id="adminMobileNav">
  <a href="{{ route('admin.admin.dashboard') }}" class="adm-mob-item"><i class="fa-solid fa-chart-line"></i><span>Dashboard</span></a>
  <a href="{{ route('admin.admin.dashboard') }}" class="adm-mob-item"><i class="fa-solid fa-users"></i><span>Patients</span></a>
  <div id="admMobFabWrap">
    <div id="admMobFabMenu">
      <a href="{{ route('admin.clinic_schedule') }}" class="adm-fab-item"><span class="adm-fab-icon"><i class="fa-solid fa-calendar-days"></i></span>Clinic Schedule</a>
      <a href="{{ route('admin.system_logs') }}"     class="adm-fab-item"><span class="adm-fab-icon"><i class="fa-solid fa-clipboard-list"></i></span>System Logs</a>
      <a href="{{ route('admin.user_management') }}" class="adm-fab-item"><span class="adm-fab-icon"><i class="fa-solid fa-user-gear"></i></span>User Management</a>
    </div>
    <button id="admMobFab" aria-label="Quick navigation"><i class="fa-solid fa-bars"></i></button>
  </div>
  <a href="{{ route('admin.admin.dashboard') }}" class="adm-mob-item"><i class="fa-solid fa-calendar-check"></i><span>Appts</span></a>
  <a href="{{ route('admin.system_logs') }}"     class="adm-mob-item {{ request()->routeIs('admin.system_logs') ? 'active':'' }}"><i class="fa-solid fa-clipboard-list"></i><span>Logs</span></a>
</nav>

{{-- MAIN CONTENT --}}
@php
  /* ── Computed stats ── */
  $openRules   = $schedules->where('status','!=','closed');
  $openDays    = $openRules->sum(fn($s) => count($s->days ?? []));
  $maxSlots    = $openRules->max('max_slots') ?? 0;
  $blockedThisMonth = $blockedDates->filter(fn($b)=>\Carbon\Carbon::parse($b->date)->isCurrentMonth())->count();
  $holidaysThisMonth= collect($philippineHolidays)
      ->filter(fn($name,$date)=>\Carbon\Carbon::parse($date)->isCurrentMonth())
      ->count();

  /* ── Schedule keyed by day abbreviation for Clinic Hours card ── */
  $scheduleByDay = [];
  foreach($schedules as $s) {
      foreach(($s->days ?? []) as $d) $scheduleByDay[$d] = $s;
  }
  $dayNames = ['Monday'=>'Mon','Tuesday'=>'Tue','Wednesday'=>'Wed','Thursday'=>'Thu',
               'Friday'=>'Fri','Saturday'=>'Sat','Sunday'=>'Sun'];

  /* ── Break schedule for the quick-view footer ── */
  $breakSchedule = $openRules->first(fn($s)=> $s->break_time && $s->break_time !== 'none');
@endphp

<main id="mainContent" style="padding-top:82px;padding-bottom:2rem;padding-left:1.5rem;padding-right:1.5rem;min-height:100vh;">
<div style="max-width:1280px;margin:0 auto;">

  {{-- Flash messages → toast --}}
  @if(session('success'))
    <script>document.addEventListener('DOMContentLoaded',()=>showToast('Success','{{ addslashes(session('success')) }}','success'));</script>
  @endif
  @if($errors->any())
    <script>document.addEventListener('DOMContentLoaded',()=>showToast('Error','{{ addslashes($errors->first()) }}','error'));</script>
  @endif

  {{-- ── Title row ── --}}
  <div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
      <i class="fa-solid fa-sun text-yellow-400 text-xs"></i>
      <p id="currentDate"></p>
    </div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div>
          <h1 class="text-3xl md:text-4xl font-extrabold text-[#8B0000]">Clinic Schedule</h1>
      </div>
      <div class="flex items-center gap-3">
        <button onclick="openRuleModal()" class="flex items-center gap-2 bg-[#8B0000] hover:bg-[#760000] text-white px-4 py-2.5 rounded-xl font-semibold text-sm shadow transition-all">
          <i class="fa-solid fa-plus"></i> Add Schedule Rule
        </button>
        <button onclick="openBlockModal()" class="flex items-center gap-2 bg-white hover:bg-red-50 text-[#8B0000] border border-red-200 px-4 py-2.5 rounded-xl font-semibold text-sm shadow-sm transition-all">
          <i class="fa-solid fa-ban"></i> Block Date
        </button>
      </div>
    </div>
  </div>

  {{-- ── Stat cards ── --}}
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @php
      $statCards = [
        ['icon'=>'fa-calendar-days','color'=>'from-[#8B0000] to-[#6B0000]','val'=>$openDays,  'label'=>'Open Days/Week',  'sub'=>'Active schedule days'],
        ['icon'=>'fa-clock',        'color'=>'from-blue-500 to-blue-600',  'val'=>$maxSlots,   'label'=>'Daily Slot Cap',   'sub'=>'Max patients/day'],
        ['icon'=>'fa-ban',          'color'=>'from-green-500 to-green-600','val'=>$blockedThisMonth,'label'=>'Blocked Dates','sub'=>'This month'],
        ['icon'=>'fa-umbrella-beach','color'=>'from-amber-500 to-amber-600','val'=>$holidaysThisMonth,'label'=>'Holidays','sub'=>'This month'],
      ];
    @endphp
    @foreach($statCards as $card)
    <div class="stat-card bg-white rounded-xl p-4 shadow border border-gray-100 overflow-hidden relative">
      <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-gray-100 to-transparent rounded-full -mr-10 -mt-10"></div>
      <div class="relative">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $card['color'] }} flex items-center justify-center shadow mb-3"><i class="fa-solid {{ $card['icon'] }} text-white text-sm"></i></div>
        <p class="text-[10px] uppercase tracking-wide text-gray-500 font-semibold mb-0.5">{{ $card['label'] }}</p>
        <p class="text-3xl font-extrabold text-gray-800">{{ $card['val'] }}</p>
        <p class="text-[10px] text-gray-400 mt-0.5">{{ $card['sub'] }}</p>
      </div>
    </div>
    @endforeach
  </div>

  {{-- ── Main two-column grid ── --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- LEFT: weekly calendar + rules table --}}
    <div class="lg:col-span-2 space-y-6">

      {{-- Weekly view --}}
      <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-calendar-week text-[#8B0000]"></i>
            <h2 class="font-bold text-gray-800 text-sm">Weekly Appointment View</h2>
          </div>
          <div class="flex items-center gap-2">
            <button id="prevWeek" class="w-7 h-7 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:border-[#8B0000] hover:text-[#8B0000] transition-all text-xs"><i class="fa-solid fa-chevron-left"></i></button>
            <span id="weekRangeLabel" class="text-xs font-semibold text-gray-600 px-1 min-w-[140px] text-center"></span>
            <button id="nextWeek" class="w-7 h-7 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:border-[#8B0000] hover:text-[#8B0000] transition-all text-xs"><i class="fa-solid fa-chevron-right"></i></button>
            <button id="todayBtn" class="text-[10px] font-bold text-[#8B0000] bg-red-50 border border-red-200 px-2.5 py-1 rounded-lg hover:bg-red-100 transition-colors">Today</button>
          </div>
        </div>
        <div class="p-4 overflow-x-auto">
          <div id="weekGrid" class="week-grid" style="min-width:480px;"></div>
          <div class="flex flex-wrap gap-3 mt-3 justify-end">
            <div class="flex items-center gap-1.5 text-xs text-gray-500"><span class="w-3 h-3 rounded bg-blue-200 border-l-2 border-blue-500 inline-block"></span>Check-up</div>
            <div class="flex items-center gap-1.5 text-xs text-gray-500"><span class="w-3 h-3 rounded bg-green-200 border-l-2 border-green-500 inline-block"></span>Cleaning</div>
            <div class="flex items-center gap-1.5 text-xs text-gray-500"><span class="w-3 h-3 rounded bg-yellow-100 border-l-2 border-yellow-400 inline-block"></span>Surgery</div>
            <div class="flex items-center gap-1.5 text-xs text-gray-500"><span class="w-3 h-3 rounded bg-purple-100 border-l-2 border-purple-400 inline-block"></span>Prosthesis</div>
          </div>
        </div>
      </div>

      {{-- Schedule rules table --}}
      <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-list-check text-[#8B0000]"></i>
            <h2 class="font-bold text-gray-800 text-sm">Schedule Rules</h2>
          </div>
          <span class="text-xs text-gray-400 font-medium">{{ $schedules->count() }} rules</span>
        </div>
        <div class="overflow-x-auto">
          <table class="sched-table">
            <thead>
              <tr>
                <th>Day(s)</th><th>Opens</th><th>Closes</th>
                <th>Lunch Break</th><th>Max Slots</th><th>Status</th><th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($schedules as $rule)
              <tr>
                <td class="font-semibold text-gray-800">{{ $rule->days_label }}</td>
                <td>{{ $rule->open_time  ? date('g:i A', strtotime($rule->open_time))  : '—' }}</td>
                <td>{{ $rule->close_time ? date('g:i A', strtotime($rule->close_time)) : '—' }}</td>
                <td class="text-xs text-gray-500">
                  @if($rule->break_time && $rule->break_time !== 'none')
                    @php [$bs,$be]=explode('-',$rule->break_time); @endphp
                    {{ date('g:i A',strtotime(trim($bs).':00')) }} – {{ date('g:i A',strtotime(trim($be).':00')) }}
                  @else —
                  @endif
                </td>
                <td>
                  <div class="flex items-center gap-2">
                    <span class="font-bold text-[#8B0000]">{{ $rule->max_slots }}</span>
                    @if($rule->status !== 'closed')
                    <div class="cap-bar w-16"><div class="cap-fill" style="width:{{ min(100,($rule->max_slots/10)*100) }}%"></div></div>
                    @endif
                  </div>
                </td>
                <td>
                  @if($rule->status==='open')    <span class="badge-open">Open</span>
                  @elseif($rule->status==='limited') <span class="badge-limited">Limited</span>
                  @else <span class="badge-closed">Closed</span>
                  @endif
                </td>
                <td>
                  <div class="flex items-center gap-1.5">
                    <button onclick='openRuleModal("edit",{{ $rule->id }},{{ json_encode($rule) }})' class="w-7 h-7 rounded-lg bg-blue-50 border border-blue-200 flex items-center justify-center text-blue-600 hover:bg-blue-100 text-xs" title="Edit"><i class="fa-solid fa-pen"></i></button>
                    <form action="{{ route('admin.clinic_schedule.destroy',$rule) }}" method="POST" onsubmit="return confirm('Delete this rule?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 border border-red-200 flex items-center justify-center text-red-600 hover:bg-red-100 text-xs" title="Delete"><i class="fa-solid fa-trash"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr><td colspan="7" class="text-center py-10">
                <i class="fa-solid fa-calendar-xmark text-3xl text-gray-300 mb-2 block"></i>
                <p class="text-gray-400 text-sm">No rules yet. <button onclick="openRuleModal()" class="text-[#8B0000] font-semibold hover:underline">Add one.</button></p>
              </td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div>

    {{-- RIGHT: Clinic Hours | Blocked Dates | Holidays --}}
    <div class="space-y-6">

      {{-- Clinic Hours --}}
      <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
          <div class="flex items-center gap-2"><i class="fa-solid fa-clock text-[#8B0000]"></i><h2 class="font-bold text-gray-800 text-sm">Clinic Hours</h2></div>
          <button onclick="openRuleModal()" class="text-xs text-[#8B0000] font-semibold hover:underline flex items-center gap-1"><i class="fa-solid fa-pen text-[9px]"></i> Edit</button>
        </div>
        <div class="p-4 space-y-0.5">
          @foreach($dayNames as $fullName => $abbr)
            @php $s = $scheduleByDay[$abbr] ?? null; @endphp
            <div class="flex justify-between items-center py-1.5 {{ !$loop->last ? 'border-b border-gray-50':'' }}">
              <span class="text-xs font-semibold text-gray-600">{{ $fullName }}</span>
              @if($s && $s->status !== 'closed')
                <span class="text-xs font-bold text-[#8B0000]">{{ $s->hours_range }}</span>
              @else
                <span class="text-xs font-medium text-gray-400">Closed</span>
              @endif
            </div>
          @endforeach
          @if($breakSchedule)
          <div class="pt-2 mt-1 border-t border-gray-100">
            <div class="flex justify-between items-center">
              <span class="text-xs text-gray-400 italic flex items-center gap-1"><i class="fa-solid fa-mug-hot text-yellow-400"></i> Lunch</span>
              @php [$bs,$be]=explode('-',$breakSchedule->break_time); @endphp
              <span class="text-xs font-medium text-gray-500">{{ date('g:i A',strtotime(trim($bs).':00')) }} – {{ date('g:i A',strtotime(trim($be).':00')) }}</span>
            </div>
          </div>
          @endif
        </div>
      </div>

      {{-- Blocked Dates --}}
      <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
          <div class="flex items-center gap-2"><i class="fa-solid fa-ban text-[#8B0000]"></i><h2 class="font-bold text-gray-800 text-sm">Blocked Dates</h2></div>
          <button onclick="openBlockModal()" class="text-xs text-[#8B0000] font-semibold hover:underline flex items-center gap-1"><i class="fa-solid fa-plus text-[9px]"></i> Add</button>
        </div>
        <div class="p-4">
          @forelse($blockedDates as $blocked)
            @php
              $bd = \Carbon\Carbon::parse($blocked->date);
              $badgeCls = match($blocked->reason){
                'Holiday'=>'badge-holiday',
                'Dentist Unavailable'=>'badge-limited',
                default=>'badge-closed'
              };
            @endphp
            <div class="flex items-start gap-3 py-2.5 {{ !$loop->last ? 'border-b border-gray-50':'' }}">
              <div class="w-9 h-9 rounded-lg bg-red-50 border border-red-100 flex items-center justify-center flex-shrink-0 text-[#8B0000] text-xs font-bold">{{ $bd->day }}</div>
              <div class="flex-1 min-w-0">
                <p class="text-xs font-bold text-gray-800 truncate">{{ $bd->format('D, M j, Y') }}</p>
                <span class="{{ $badgeCls }} mt-0.5 inline-block">{{ $blocked->reason }}</span>
                @if($blocked->note)<p class="text-[10px] text-gray-400 mt-0.5 italic truncate">{{ $blocked->note }}</p>@endif
              </div>
              <form action="{{ route('admin.clinic_schedule.unblock',$blocked) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="w-6 h-6 flex items-center justify-center text-gray-300 hover:text-red-500 transition-colors" title="Remove"><i class="fa-solid fa-xmark text-xs"></i></button>
              </form>
            </div>
          @empty
            <div class="text-center py-6"><i class="fa-solid fa-check-circle text-3xl text-green-400 mb-2 block"></i><p class="text-xs text-gray-400">No blocked dates</p></div>
          @endforelse
        </div>
      </div>

      {{-- Upcoming Holidays --}}
      <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b bg-gray-50"><div class="flex items-center gap-2"><i class="fa-solid fa-umbrella-beach text-[#8B0000]"></i><h2 class="font-bold text-gray-800 text-sm">Upcoming Holidays</h2></div></div>
        <div class="p-4">
          @php
            $today  = now()->startOfDay();
            $MONTHS_SHORT = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            $upcoming = collect($philippineHolidays)
                ->filter(fn($n,$d)=>\Carbon\Carbon::parse($d)->gte($today))
                ->take(5);
          @endphp
          @forelse($upcoming as $hDate => $hName)
            @php $hC = \Carbon\Carbon::parse($hDate); $diff = (int)$today->diffInDays($hC,false); @endphp
            <div class="flex items-center gap-3 py-2 border-b border-gray-50 last:border-b-0">
              <div class="w-10 text-center flex-shrink-0">
                <div class="text-[10px] font-bold uppercase text-[#8B0000]">{{ $MONTHS_SHORT[$hC->month-1] }}</div>
                <div class="text-xl font-extrabold text-gray-800 leading-tight">{{ $hC->day }}</div>
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-gray-800 truncate">{{ $hName }}</p>
                <p class="text-[10px] text-gray-400">{{ $diff===0?'Today':($diff===1?'Tomorrow':"In $diff days") }}</p>
              </div>
              <span class="badge-holiday flex-shrink-0">Holiday</span>
            </div>
          @empty
            <p class="text-xs text-gray-400 text-center py-4">No upcoming holidays.</p>
          @endforelse
        </div>
      </div>

    </div>
  </div>
</div>
    <div id="appointmentDetailModal" class="modal-backdrop" onclick="closeAppointmentDetailModal()">
      <div class="modal-box" style="width:420px;" onclick="event.stopPropagation()">
        <div class="modal-hdr">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-lg font-bold">Appointment Details</h3>
              <p class="text-sm text-white/70 mt-0.5">Selected booked slot information</p>
            </div>
            <button onclick="closeAppointmentDetailModal()" class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white hover:bg-white/30">
              <i class="fa-solid fa-xmark text-sm"></i>
            </button>
          </div>
        </div>

        <div class="modal-body">
          <div class="space-y-4">
            <div>
              <label class="form-label">Patient Name</label>
              <div id="detailPatientName" class="form-ctrl bg-gray-50">—</div>
            </div>

            <div>
              <label class="form-label">Service Type</label>
              <div id="detailServiceType" class="form-ctrl bg-gray-50">—</div>
            </div>

            <div>
              <label class="form-label">Schedule</label>
              <div id="detailSchedule" class="form-ctrl bg-gray-50">—</div>
            </div>
          </div>

          <div class="flex justify-end gap-3 pt-4 mt-4 border-t border-gray-100">
            <button type="button" onclick="closeAppointmentDetailModal()" class="px-5 py-2 rounded-xl bg-[#8B0000] hover:bg-[#760000] text-white text-sm font-bold shadow">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
</main>

{{-- Footer --}}
<footer id="siteFooter" class="bg-[#8B0000] text-[#F4F4F4] p-6">
  <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 text-sm text-center">
    <span><span class="text-gray-300">© 2025–2026</span> <span class="font-semibold">Polytechnic University of the Philippines</span></span>
    <span class="hidden sm:inline">|</span>
    <a href="https://www.pup.edu.ph/terms/" class="hover:underline">Terms of Use</a>
    <span class="hidden sm:inline">|</span>
    <a href="https://www.pup.edu.ph/privacy/" class="hover:underline">Privacy Statement</a>
  </div>
</footer>

{{-- Schedule Rule Modal --}}
<div id="ruleModalBackdrop" class="modal-backdrop" onclick="closeRuleModal()">
  <div class="modal-box" onclick="event.stopPropagation()">
    <div class="modal-hdr">
      <div class="flex items-center justify-between">
        <div>
          <h3 class="text-lg font-bold" id="ruleModalTitle">Add Schedule Rule</h3>
          <p class="text-sm text-white/70 mt-0.5">Set availability for the selected days</p>
        </div>
        <button onclick="closeRuleModal()" class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white hover:bg-white/30 transition-colors"><i class="fa-solid fa-xmark text-sm"></i></button>
      </div>
    </div>
    <div class="modal-body">
      <form id="ruleForm" method="POST" action="{{ route('admin.clinic_schedule.store') }}">
        @csrf
        <div id="ruleMethodField"></div>

        {{-- Day toggles --}}
        <div class="mb-5">
          <label class="form-label">Select Days <span class="text-red-400">*</span></label>
          <div class="flex gap-2 flex-wrap mt-1">
            @foreach(['Mon'=>'M','Tue'=>'T','Wed'=>'W','Thu'=>'Th','Fri'=>'F','Sat'=>'S','Sun'=>'Su'] as $abbr=>$lbl)
              <div class="day-toggle" data-day="{{ $abbr }}" onclick="toggleDay(this)">{{ $lbl }}</div>
            @endforeach
          </div>
        </div>

        {{-- Status --}}
        <div class="mb-5">
          <label class="form-label" for="ruleStatus">Clinic Status</label>
          <select id="ruleStatus" class="form-ctrl form-sel" onchange="toggleStatusFields(this.value)">
            <option value="open">Open</option>
            <option value="closed">Closed</option>
            <option value="limited">Limited Hours</option>
          </select>
        </div>

        {{-- Time + slots (hidden when closed) --}}
        <div id="ruleTimeFields">
          <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
              <label class="form-label" for="ruleOpenTime">Opening Time</label>
              <select id="ruleOpenTime" class="form-ctrl form-sel">
                <option value="07:00">7:00 AM</option>
                <option value="08:00">8:00 AM</option>
                <option value="09:00" selected>9:00 AM</option>
                <option value="10:00">10:00 AM</option>
              </select>
            </div>
            <div>
              <label class="form-label" for="ruleCloseTime">Closing Time</label>
              <select id="ruleCloseTime" class="form-ctrl form-sel">
                <option value="15:00">3:00 PM</option>
                <option value="16:00">4:00 PM</option>
                <option value="17:00" selected>5:00 PM</option>
                <option value="18:00">6:00 PM</option>
              </select>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label">Lunch Break</label>
            <div class="flex gap-2 flex-wrap">
              <div class="break-chip selected" data-val="12:00-13:00" onclick="selectBreak(this)">12:00 – 1:00 PM</div>
              <div class="break-chip"          data-val="13:00-14:00" onclick="selectBreak(this)">1:00 – 2:00 PM</div>
              <div class="break-chip"          data-val="none"        onclick="selectBreak(this)"><i class="fa-solid fa-ban text-[10px]"></i> No Break</div>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label" for="ruleMaxSlots">Max Appointments / Day</label>
            <div class="flex items-center gap-3">
              <button type="button" onclick="adjSlots(-1)" class="w-9 h-9 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:border-[#8B0000] hover:text-[#8B0000] font-bold text-lg">−</button>
              <input type="number" id="ruleMaxSlots" class="form-ctrl text-center font-bold text-lg w-20" value="5" min="1" max="30">
              <button type="button" onclick="adjSlots(1)"  class="w-9 h-9 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:border-[#8B0000] hover:text-[#8B0000] font-bold text-lg">+</button>
            </div>
          </div>
        </div>

        <div class="mb-5">
          <label class="form-label" for="ruleNotes">Notes (optional)</label>
          <textarea id="ruleNotes" class="form-ctrl resize-none" rows="2" placeholder="e.g. Holiday schedule, reduced hours…"></textarea>
        </div>

        <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
          <button type="button" onclick="closeRuleModal()" class="px-5 py-2 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">Cancel</button>
          <button type="button" onclick="submitRule()" class="px-5 py-2 rounded-xl bg-[#8B0000] hover:bg-[#760000] text-white text-sm font-bold shadow"><i class="fa-solid fa-floppy-disk mr-1.5"></i>Save Rule</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Block date modal --}}
<div id="blockModalBackdrop" class="modal-backdrop" onclick="closeBlockModal()">
  <div class="modal-box" style="width:440px;" onclick="event.stopPropagation()">
    <div class="modal-hdr">
      <div class="flex items-center justify-between">
        <div><h3 class="text-lg font-bold">Block Date</h3><p class="text-sm text-white/70 mt-0.5">Mark a date as unavailable for bookings</p></div>
        <button onclick="closeBlockModal()" class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white hover:bg-white/30"><i class="fa-solid fa-xmark text-sm"></i></button>
      </div>
    </div>
    <div class="modal-body">
      <form action="{{ route('admin.clinic_schedule.block') }}" method="POST">
        @csrf
        <div class="mb-4">
          <label class="form-label" for="blockDate">Date <span class="text-red-400">*</span></label>
          <input type="date" id="blockDate" name="date" class="form-ctrl" required min="{{ date('Y-m-d') }}">
        </div>
        <div class="mb-4">
          <label class="form-label" for="blockReason">Reason <span class="text-red-400">*</span></label>
          <select id="blockReason" name="reason" class="form-ctrl form-sel">
            <option value="Holiday">Holiday</option>
            <option value="Dentist Unavailable">Dentist Unavailable</option>
            <option value="Clinic Maintenance">Clinic Maintenance</option>
            <option value="Special Event">Special Event</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div class="mb-5">
          <label class="form-label" for="blockNote">Note (optional)</label>
          <input type="text" id="blockNote" name="note" class="form-ctrl" placeholder="Additional details…">
        </div>
        <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
          <button type="button" onclick="closeBlockModal()" class="px-5 py-2 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">Cancel</button>
          <button type="submit" class="px-5 py-2 rounded-xl bg-[#8B0000] hover:bg-[#760000] text-white text-sm font-bold shadow"><i class="fa-solid fa-ban mr-1.5"></i>Block Date</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ════ SCRIPTS ════ --}}
<script>
// Blade to JS 
const scheduleRules      = @json($schedules);
const blockedDatesArr    = @json($blockedDates->pluck('date'));
const apptCounts         = @json($appointmentCountsPerDay ?? []);
const weeklyAppointments = @json($weeklyAppointments ?? []);
console.log('weeklyAppointments', weeklyAppointments);
  if (!weeklyAppointments || weeklyAppointments.length === 0) {
  console.warn('No weekly appointments were passed from the controller.');
}

// Toast
function showToast(title, message, type = 'error') {
  const c = document.getElementById('toastContainer');
  const t = document.createElement('div');
  t.className = 'toast ' + type;
  const icon = type === 'error'
    ? '<i class="fa-solid fa-circle-exclamation toast-icon"></i>'
    : '<i class="fa-solid fa-circle-check toast-icon"></i>';
  t.innerHTML = `<div class="toast-icon-wrap">${icon}</div>
    <div class="toast-body"><div class="toast-title">${title}</div>
    <div class="toast-msg">${message}</div></div>
    <button class="toast-close" onclick="this.closest('.toast').classList.add('hide')"><i class="fa-solid fa-xmark"></i></button>`;
  c.appendChild(t);
  requestAnimationFrame(() => requestAnimationFrame(() => t.classList.add('show')));
  setTimeout(() => { t.classList.remove('show'); t.classList.add('hide'); setTimeout(() => t.remove(), 400); }, 4500);
}

// Date Label
const dateEl = document.getElementById('currentDate');
if (dateEl) dateEl.textContent = new Date().toLocaleDateString('en-US',{weekday:'long',year:'numeric',month:'long',day:'numeric'});

// Notifications
document.getElementById('notifBtn').addEventListener('click', e => {
  e.stopPropagation();
  document.getElementById('notifMenu').classList.toggle('open');
});
document.addEventListener('click', () => {
  document.getElementById('notifMenu').classList.remove('open');
  const fm = document.getElementById('admMobFabMenu'), fab = document.getElementById('admMobFab');
  if (fm) fm.classList.remove('open'); if (fab) fab.classList.remove('open');
});

// Mobile
document.addEventListener('DOMContentLoaded', () => {
  const fab = document.getElementById('admMobFab'), menu = document.getElementById('admMobFabMenu');
  if (fab && menu) {
    fab.addEventListener('click', e => { e.stopPropagation(); const o = menu.classList.contains('open'); menu.classList.toggle('open',!o); fab.classList.toggle('open',!o); });
    menu.addEventListener('click', e => e.stopPropagation());
  }
});

function openAppointmentDetailModal(appt) {
  const service = appt.service_type === 'Others'
    ? (appt.other_services || 'Other Service')
    : (appt.service_type || '—');

  document.getElementById('detailPatientName').textContent = appt.patient_name || 'Unknown Patient';
  document.getElementById('detailServiceType').textContent = service;
  document.getElementById('detailSchedule').textContent = `${appt.appointment_date} ${appt.display_time || appt.appointment_time || ''}`;

  document.getElementById('appointmentDetailModal').classList.add('open');
}

function closeAppointmentDetailModal() {
  document.getElementById('appointmentDetailModal').classList.remove('open');
}

// Theme
const html = document.documentElement;
function applyTheme(theme) {
  html.setAttribute('data-theme', theme); localStorage.setItem('theme', theme);
  document.querySelectorAll('.theme-option').forEach(o => o.getAttribute('data-theme') === theme ? o.classList.add('active') : o.classList.remove('active'));
  const ind = document.querySelector('.theme-indicator'); if (ind) ind.classList.toggle('dark-mode', theme === 'dark');
}
document.addEventListener('DOMContentLoaded', () => {
  applyTheme(localStorage.getItem('theme') || 'light');
  document.querySelectorAll('.theme-option').forEach(o => o.addEventListener('click', e => { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); }));
});

// Weekly Calendar
const SHORT_MONTHS = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const DAY_ABBRS    = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
const TIME_ROWS    = [{h:9,l:'9:00 AM'},{h:10,l:'10:00 AM'},{h:11,l:'11:00 AM'},{h:12,l:'12:00 PM'},
                      {h:13,l:'1:00 PM'},{h:14,l:'2:00 PM'},{h:15,l:'3:00 PM'},{h:16,l:'4:00 PM'}];

let weekOffset = 0;

function weekStart(offset) {
  const t = new Date(); t.setHours(0,0,0,0);
  const dow = t.getDay();
  const mon = new Date(t); mon.setDate(t.getDate() - (dow===0?6:dow-1) + offset*7);
  return mon;
}

function slotState(dayAbbr, hour) {
  const rule = scheduleRules.find(r => r.is_active && (r.days||[]).includes(dayAbbr));
  if (!rule || rule.status === 'closed') return 'closed';
  const oh = rule.open_time  ? parseInt(rule.open_time)  : 9;
  const ch = rule.close_time ? parseInt(rule.close_time) : 17;
  if (hour < oh || hour >= ch) return 'closed';
  if (rule.break_time && rule.break_time !== 'none') {
    const [bs,be] = rule.break_time.split('-');
    if (hour >= parseInt(bs) && hour < parseInt(be)) return 'break';
  }
  return 'open';
}

function to24Hour(hour) {
  return String(hour).padStart(2, '0') + ':00';
}

function normalizeTimeValue(value) {
  if (!value) return '';

  const raw = String(value).trim();

  // 09:00:00 -> 09:00
  if (/^\d{2}:\d{2}:\d{2}$/.test(raw)) {
    return raw.slice(0, 5);
  }

  if (/^\d{2}:\d{2}$/.test(raw)) {
    return raw;
  }

  // 9:00 AM / 10:00 PM -> convert to 24h
  const match = raw.match(/^(\d{1,2}):(\d{2})\s*([AP]M)$/i);
  if (match) {
    let h = parseInt(match[1], 10);
    const m = match[2];
    const meridian = match[3].toUpperCase();

    if (meridian === 'PM' && h !== 12) h += 12;
    if (meridian === 'AM' && h === 12) h = 0;

    return String(h).padStart(2, '0') + ':' + m;
  }

  return raw;
}

function normalizeToHourMinute(timeValue) {
  if (!timeValue) return '';

  // already like 09:00
  if (/^\d{2}:\d{2}$/.test(timeValue)) {
    return timeValue;
  }

  // like 09:00:00
  if (/^\d{2}:\d{2}:\d{2}$/.test(timeValue)) {
    return timeValue.slice(0, 5);
  }

  // fallback for 9:00 AM style strings
  const temp = new Date(`1970-01-01 ${timeValue}`);
  if (!isNaN(temp.getTime())) {
    return `${String(temp.getHours()).padStart(2, '0')}:${String(temp.getMinutes()).padStart(2, '0')}`;
  }

  return String(timeValue).trim();
}

function getAppointmentsForSlot(isoDate, hour) {
  const slotTime = to24Hour(hour);
  console.log('Checking slot', isoDate, slotTime, weeklyAppointments.filter(appt =>
  appt.appointment_date === isoDate
));

  return weeklyAppointments.filter(appt =>
    appt.appointment_date === isoDate &&
    normalizeToHourMinute(appt.appointment_time) === slotTime
  );
}

function getServiceColor(serviceType) {
  const s = (serviceType || '').toLowerCase();

  if (s.includes('oral check')) {
    return {
      box: 'background:#dbeafe;border-left:3px solid #3b82f6;color:#1e3a8a;',
      badge: 'Check-up'
    };
  }

  if (s.includes('cleaning')) {
    return {
      box: 'background:#dcfce7;border-left:3px solid #22c55e;color:#166534;',
      badge: 'Cleaning'
    };
  }

  if (s.includes('surgery')) {
    return {
      box: 'background:#fef3c7;border-left:3px solid #f59e0b;color:#92400e;',
      badge: 'Surgery'
    };
  }

  if (s.includes('restoration') || s.includes('prosthesis')) {
    return {
      box: 'background:#f3e8ff;border-left:3px solid #a855f7;color:#6b21a8;',
      badge: 'Prosthesis'
    };
  }

  return {
    box: 'background:#f3f4f6;border-left:3px solid #6b7280;color:#374151;',
    badge: 'Other'
  };
}

function buildWeekGrid() {
  const ws    = weekStart(weekOffset);
  const days  = Array.from({length:7}, (_,i)=>{ const d=new Date(ws); d.setDate(d.getDate()+i); return d; });
  const today = new Date(); today.setHours(0,0,0,0);

  document.getElementById('weekRangeLabel').textContent =
    `${SHORT_MONTHS[days[0].getMonth()]} ${days[0].getDate()} – ${SHORT_MONTHS[days[6].getMonth()]} ${days[6].getDate()}, ${days[6].getFullYear()}`;

  // Header row
  let html = `<div class="wk-hdr empty"></div>`;
  days.forEach((d,i) => {
    const isTod = d.getTime()===today.getTime();
    const cls   = isTod ? 'today-hdr' : i>=5 ? 'weekend-hdr' : '';
    html += `<div class="wk-hdr ${cls}">
      <div style="font-size:.65rem;opacity:.75">${DAY_ABBRS[d.getDay()]}</div>
      <div style="font-size:1rem;font-weight:800;line-height:1.2">${d.getDate()}</div>
      ${isTod?'<div style="font-size:.55rem;background:rgba(255,255,255,.25);border-radius:999px;padding:1px 6px;margin-top:2px">Today</div>':''}
    </div>`;
  });

  // Time rows
  console.log('Rendered week appointments:', weeklyAppointments);
  TIME_ROWS.forEach(({h, l}) => {
    html += `<div class="time-lbl">${l}</div>`;

    days.forEach((d, i) => {
      const isoDate = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
      const abbr = d.toLocaleDateString('en-US', { weekday: 'short' }).replace('.', '');

      const state =
        i >= 5
          ? 'wk-weekend'
          : slotState(abbr, h) === 'break'
            ? 'wk-break'
            : slotState(abbr, h) === 'closed'
              ? 'wk-closed'
              : '';

      let inner = '';

      if (state === 'wk-break') {
        inner = '<span class="slot-label">BREAK</span>';
      } else if (state === 'wk-closed') {
        inner = '<span class="slot-label">CLOSED</span>';
      } else if (state === 'wk-weekend') {
        inner = '<span class="slot-label">CLOSED</span>';
      } else {
        const slotAppointments = getAppointmentsForSlot(isoDate, h);
        console.log('slot check:', isoDate, to24Hour(h), slotAppointments);

        if (slotAppointments.length > 0) {
          inner = slotAppointments.map(appt => {
            const service = appt.service_type === 'Others'
              ? (appt.other_services || 'Other Service')
              : appt.service_type;

            const style = getServiceColor(service);

            return `
            <button
              type="button"
              onclick='openAppointmentDetailModal(${JSON.stringify(appt)})'
              style="
                ${style.box}
                margin:4px;
                border-radius:8px;
                padding:6px 7px;
                font-size:.62rem;
                line-height:1.25;
                font-weight:600;
                box-shadow:0 1px 3px rgba(0,0,0,.06);
                width:calc(100% - 8px);
                text-align:left;
                cursor:pointer;
                transition:transform .15s ease, box-shadow .15s ease;
              "
              onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 4px 10px rgba(0,0,0,.10)'"
              onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 1px 3px rgba(0,0,0,.06)'"
              title="Click to view details"
            >
              <div style="font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                ${appt.patient_name}
              </div>
              <div style="font-size:.58rem; opacity:.9; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                ${service}
              </div>
            </button>
          `;
          }).join('');
        }
      }

      html += `<div class="cal-slot ${state}">${inner}</div>`;
    });
  });

  document.getElementById('weekGrid').innerHTML = html;
}

document.getElementById('prevWeek').addEventListener('click', () => { weekOffset--; buildWeekGrid(); });
document.getElementById('nextWeek').addEventListener('click', () => { weekOffset++; buildWeekGrid(); });
document.getElementById('todayBtn').addEventListener('click', () => { weekOffset=0; buildWeekGrid(); });

// Schedule Rule Modal
let selectedBreak = '12:00-13:00';
let editingId     = null;

function openRuleModal(mode, ruleId, rule) {
  editingId = null;
  document.getElementById('ruleModalTitle').textContent = 'Add Schedule Rule';
  document.getElementById('ruleForm').action = '{{ route("admin.clinic_schedule.store") }}';
  document.getElementById('ruleMethodField').innerHTML = '';

  // Reset
  document.querySelectorAll('.day-toggle').forEach(d => d.classList.remove('active'));
  document.querySelectorAll('.break-chip').forEach(c => c.classList.remove('selected'));
  document.querySelector('.break-chip[data-val="12:00-13:00"]').classList.add('selected');
  selectedBreak = '12:00-13:00';
  document.getElementById('ruleStatus').value     = 'open';
  document.getElementById('ruleOpenTime').value   = '09:00';
  document.getElementById('ruleCloseTime').value  = '17:00';
  document.getElementById('ruleMaxSlots').value   = '5';
  document.getElementById('ruleNotes').value      = '';
  document.getElementById('ruleTimeFields').style.display = '';

  if (mode === 'edit' && rule) {
    editingId = ruleId;
    document.getElementById('ruleModalTitle').textContent = 'Edit Schedule Rule';
    document.getElementById('ruleForm').action = `/admin/clinic-schedule/rules/${ruleId}`;
    document.getElementById('ruleMethodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';

    (rule.days || []).forEach(day => {
      const el = document.querySelector(`.day-toggle[data-day="${day}"]`);
      if (el) el.classList.add('active');
    });
    document.getElementById('ruleStatus').value = rule.status || 'open';
    toggleStatusFields(rule.status);
    if (rule.open_time)  document.getElementById('ruleOpenTime').value  = rule.open_time.substring(0,5);
    if (rule.close_time) document.getElementById('ruleCloseTime').value = rule.close_time.substring(0,5);
    document.getElementById('ruleMaxSlots').value = rule.max_slots || 5;
    document.getElementById('ruleNotes').value    = rule.notes || '';
    selectedBreak = rule.break_time || 'none';
    document.querySelectorAll('.break-chip').forEach(c => c.classList.toggle('selected', c.dataset.val === selectedBreak));
  }

  document.getElementById('ruleModalBackdrop').classList.add('open');
}

function closeRuleModal() {
  document.getElementById('ruleModalBackdrop').classList.remove('open');
}

function toggleDay(el) { el.classList.toggle('active'); }

function toggleStatusFields(val) {
  document.getElementById('ruleTimeFields').style.display = val === 'closed' ? 'none' : '';
}

function selectBreak(el) {
  document.querySelectorAll('.break-chip').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');
  selectedBreak = el.dataset.val;
}

function adjSlots(delta) {
  const inp = document.getElementById('ruleMaxSlots');
  inp.value = Math.max(1, Math.min(30, parseInt(inp.value||5) + delta));
}

function submitRule() {
  const activeDays = [...document.querySelectorAll('.day-toggle.active')].map(d => d.dataset.day);
  if (!activeDays.length) { showToast('No Days Selected','Please select at least one day.','error'); return; }

  const form = document.getElementById('ruleForm');
  // Remove previously injected hidden inputs
  form.querySelectorAll('.injected-hidden').forEach(el => el.remove());

  const inject = (name, val) => {
    const inp = document.createElement('input'); inp.type='hidden'; inp.name=name; inp.value=val; inp.className='injected-hidden'; form.appendChild(inp);
  };

  activeDays.forEach(d => inject('days[]', d));
  inject('status',     document.getElementById('ruleStatus').value);
  const status = document.getElementById('ruleStatus').value;
  if (status !== 'closed') {
    inject('open_time',  document.getElementById('ruleOpenTime').value);
    inject('close_time', document.getElementById('ruleCloseTime').value);
    inject('max_slots',  document.getElementById('ruleMaxSlots').value);
    inject('break_time', selectedBreak || 'none');
  }
  inject('notes', document.getElementById('ruleNotes').value);

  form.submit();
}

// Block date 
function openBlockModal() {
  document.getElementById('blockDate').min = new Date().toISOString().split('T')[0];
  document.getElementById('blockModalBackdrop').classList.add('open');
}
function closeBlockModal() {
  document.getElementById('blockModalBackdrop').classList.remove('open');
}

document.addEventListener('DOMContentLoaded', buildWeekGrid);
</script>
</body>
</html>