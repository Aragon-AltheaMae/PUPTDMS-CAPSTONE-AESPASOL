<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <title>Service Types | PUP Taguig Dental Clinic</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = { daisyui: { themes: false } }
    </script>

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #F8F6F3;
            color: #2D2420;
            margin: 0;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #D1C9C0; border-radius: 10px; }

        /* ── HEADER ── */
        .header {
            position: fixed; top: 0; left: 0; right: 0; z-index: 50;
            background: linear-gradient(135deg, #6b0000 0%, #8B0000 100%);
            padding: 0 2rem; height: 62px;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 2px 20px rgba(139,0,0,.25);
        }
        .header-left { display: flex; align-items: center; gap: .75rem; }
        .header-logo { width: 36px; height: 36px; object-fit: contain; }
        .header-title { font-size: .95rem; font-weight: 700; color: #fff; letter-spacing: .01em; }
        .header-right { display: flex; align-items: center; gap: 1.25rem; }
        .notif-btn {
            width: 36px; height: 36px; border-radius: 50%;
            background: rgba(255,255,255,.12); border: none; cursor: pointer;
            color: #fff; font-size: .95rem;
            display: flex; align-items: center; justify-content: center;
            transition: background .15s; position: relative;
        }
        .notif-btn:hover { background: rgba(255,255,255,.22); }
        .notif-badge {
            position: absolute; top: -3px; right: -3px;
            background: #ff6b6b; color: #fff; font-size: .6rem; font-weight: 700;
            width: 16px; height: 16px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid #8B0000;
        }
        .header-user { display: flex; align-items: center; gap: .6rem; }
        .header-avatar { width: 34px; height: 34px; border-radius: 50%; border: 2px solid rgba(255,255,255,.4); object-fit: cover; }
        .header-name { font-size: .82rem; font-weight: 600; color: #fff; line-height: 1.2; }
        .header-role { font-size: .7rem; color: rgba(255,255,255,.7); font-style: italic; }

        #notifMenu {
            position: absolute; right: 0; top: calc(100% + 10px); width: 300px;
            background: #fff; border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0,0,0,.12); border: 1px solid #f0e6e6;
            opacity: 0; transform: scale(.95) translateY(-6px); pointer-events: none;
            transition: all .2s; transform-origin: top right; z-index: 100;
        }
        #notifMenu.open { opacity: 1; transform: scale(1) translateY(0); pointer-events: auto; }
        #notifDropdown { position: relative; }

        /* ── SIDEBAR ── */
        #sidebar {
            position: fixed; left: 0; top: 62px; width: 240px; height: calc(100vh - 62px);
            background: #fff; box-shadow: 2px 0 20px rgba(0,0,0,.07);
            z-index: 40; display: flex; flex-direction: column; overflow: hidden;
        }
        .sidebar-inner { flex: 1; overflow-y: auto; overflow-x: hidden; padding: 12px 0 6px; }
        .sidebar-inner::-webkit-scrollbar { width: 4px; }
        .sidebar-inner::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 4px; }

        .nav-group { margin: 0 8px 2px; }
        .group-header { display: flex; align-items: center; padding: 7px 8px 5px; color: #6b7280; }
        .group-icon { width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 15px; }
        .group-header.active-group .group-icon { background: #8B0000; color: #fff; box-shadow: 0 4px 12px rgba(139,0,0,.3); }
        .group-label-wrap { flex: 1; text-align: left; overflow: hidden; margin-left: 10px; }
        .group-label { font-size: .72rem; font-weight: 700; white-space: nowrap; line-height: 1.2; display: block; text-transform: uppercase; letter-spacing: .06em; }
        .group-sublabel { font-size: .62rem; color: #b0b8c4; white-space: nowrap; display: block; margin-top: 1px; }
        .group-body { padding-bottom: 4px; }
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 7px 10px 7px 44px; border-radius: 8px; margin: 1px 4px;
            font-size: .77rem; font-weight: 500; color: #6b7280;
            text-decoration: none; transition: all .15s; white-space: nowrap;
        }
        .nav-link:hover { background: #fef2f2; color: #8B0000; padding-left: 48px; }
        .nav-link.active { background: #8B0000; color: #fff; box-shadow: 0 2px 8px rgba(139,0,0,.25); }
        .nav-link.active:hover { padding-left: 44px; background: #8B0000; }
        .nav-link i { width: 16px; text-align: center; font-size: 12px; }
        .nav-sep { height: 1px; background: #f3f4f6; margin: 8px 12px; }

        .sidebar-bottom { padding: 8px 8px 12px; border-top: 1px solid #f3f4f6; flex-shrink: 0; }
        .theme-toggle-container {
            position: relative; display: flex; align-items: center; justify-content: space-between;
            width: 100%; height: 34px; background: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 24px;
        }
        .theme-option {
            position: relative; z-index: 2; flex: 1; height: 34px;
            display: flex; align-items: center; justify-content: center;
            background: transparent; border: none; cursor: pointer; color: #9CA3AF;
            transition: color .2s ease; border-radius: 8px;
        }
        .theme-option i { font-size: 16px; }
        .theme-option.active { color: #374151; }
        .theme-indicator {
            position: absolute; background: white; border-radius: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,.1); transition: all .3s cubic-bezier(.4,0,.2,1);
            pointer-events: none; width: calc(50% - 4px); height: calc(100% - 8px); left: 4px; top: 4px;
        }
        .theme-indicator.dark-mode { transform: translateX(calc(100%)); }
        .logout-btn {
            display: flex; align-items: center; gap: 10px; width: 100%;
            padding: 8px 10px; border-radius: 10px; border: none; background: none;
            cursor: pointer; color: #ef4444; font-size: .77rem; font-weight: 600;
            transition: background .15s; font-family: 'Inter', sans-serif;
        }
        .logout-btn:hover { background: #fef2f2; }

        /* ── LAYOUT ── */
        #mainContent, #siteFooter { margin-left: 240px; }

        /* ── DARK MODE ── */
        body, main, footer { transition: background-color .3s ease, color .3s ease; }
        [data-theme="dark"] body { background-color: #000D1A; color: #E5E7EB; }
        [data-theme="dark"] #sidebar { background-color: #0d1117; border-right: 1px solid #21262d; }
        [data-theme="dark"] .bg-white { background-color: #161b22 !important; }
        [data-theme="dark"] .nav-link:hover { background: rgba(139,0,0,.2); }
        [data-theme="dark"] .theme-toggle-container { background: #1F1F1F; border-color: #2A2A2A; }
        [data-theme="dark"] .theme-option { color: #6B7280; }
        [data-theme="dark"] .theme-option.active { color: #F3F4F6; }
        [data-theme="dark"] .theme-indicator { background: #2A2A2A; box-shadow: 0 2px 8px rgba(0,0,0,.3); }
        [data-theme="dark"] .nav-sep, [data-theme="dark"] .sidebar-bottom { border-color: #21262d; }
        [data-theme="dark"] .group-label { color: #6b7280; }

        /* ══════════════════════════════════════
           SERVICE TYPES PAGE STYLES
        ══════════════════════════════════════ */

        .st-card {
            background: #fff;
            border: 1.5px solid #EDE8E2;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }

        .st-add-bar {
            padding: 18px 24px;
            background: #FDFCFB;
            border-bottom: 1px solid #F0EBE6;
        }

        .st-input-wrap { position: relative; flex: 1; }

        .st-input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #B5A99A; font-size: 13px; pointer-events: none;
        }

        .st-input {
            width: 100%; height: 44px; padding: 0 16px 0 38px;
            border: 1.5px solid #EDE8E2; border-radius: 10px;
            font-size: 14px; font-family: 'Inter', sans-serif;
            background: #fff; color: #2D2420; outline: none;
            transition: border-color .18s, box-shadow .18s;
        }
        .st-input::placeholder { color: #C4B8AF; }
        .st-input:focus { border-color: #7B0D0D; box-shadow: 0 0 0 3px rgba(123,13,13,.08); }

        .btn-add-service {
            height: 44px; padding: 0 22px;
            background: linear-gradient(135deg, #7B0D0D, #9B1515);
            color: #fff; border: none; border-radius: 10px;
            font-size: 14px; font-weight: 700; font-family: 'Inter', sans-serif;
            cursor: pointer; display: flex; align-items: center; gap: 8px;
            white-space: nowrap; flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(123,13,13,.25);
            transition: all .2s;
        }
        .btn-add-service:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(123,13,13,.35); }
        .btn-add-service:active { transform: translateY(0); }

        .st-field-error {
            display: flex; align-items: center; gap: 6px;
            margin-top: 8px; font-size: 12px; font-weight: 600; color: #DC2626;
        }

        /* Table header */
        .st-table-head {
            display: grid; grid-template-columns: 68px 1fr auto; gap: 16px;
            padding: 10px 24px;
            background: #F8F5F2; border-bottom: 1px solid #EDE8E2;
        }
        .st-col-label {
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .06em; color: #B5A99A;
        }

        /* Rows */
        .st-row {
            display: grid; grid-template-columns: 68px 1fr auto;
            align-items: center; gap: 16px;
            padding: 14px 24px;
            border-bottom: 1px solid #F5F0EB;
            transition: background .15s;
            animation: stRowIn .3s ease both;
        }
        .st-row:last-child { border-bottom: none; }
        .st-row:hover { background: #FBF8F5; }

        @keyframes stRowIn {
            from { opacity: 0; transform: translateX(-6px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .st-id-badge {
            display: inline-flex; align-items: center; justify-content: center;
            height: 26px; padding: 0 10px;
            background: #F5EFE9; color: #8A7A6F;
            border: 1px solid #EDE8E2; border-radius: 7px;
            font-size: 12px; font-weight: 700; letter-spacing: .02em;
        }

        .st-service-cell { display: flex; align-items: center; gap: 10px; min-width: 0; }

        .st-service-icon {
            width: 30px; height: 30px; border-radius: 8px; flex-shrink: 0;
            background: #7B0D0D12; border: 1px solid #7B0D0D22;
            color: #7B0D0D; display: flex; align-items: center; justify-content: center; font-size: 12px;
        }

        .btn-delete-service {
            height: 34px; padding: 0 14px;
            background: #FEF2F2; color: #DC2626;
            border: 1.5px solid #FECACA; border-radius: 8px;
            font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif;
            cursor: pointer; display: flex; align-items: center; gap: 6px;
            transition: all .18s; white-space: nowrap;
        }
        .btn-delete-service:hover {
            background: #DC2626; color: #fff; border-color: #DC2626;
            box-shadow: 0 3px 10px rgba(220,38,38,.3);
        }

        /* Empty state */
        .st-empty {
            padding: 64px 24px;
            display: flex; flex-direction: column; align-items: center; gap: 10px;
        }
        .st-empty-icon {
            width: 56px; height: 56px; background: #F5EFE9;
            border: 1.5px solid #EDE8E2; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; color: #C4B8AF; margin-bottom: 6px;
        }

        /* Count pill */
        .st-count-pill {
            display: inline-flex; align-items: center; gap: 6px;
            background: #7B0D0D12; color: #7B0D0D;
            border: 1px solid #7B0D0D25; border-radius: 20px;
            padding: 5px 14px; font-size: 12px; font-weight: 700;
        }

        /* Alerts */
        .st-alert {
            border-radius: 12px; padding: 12px 18px; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
            font-size: 14px; font-weight: 600;
        }
        .st-alert-success { background: #F0FDF4; border: 1px solid #BBF7D0; color: #166534; }
        .st-alert-error   { background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; }

        /* Dark mode overrides */
        [data-theme="dark"] .st-card { background: #161b22; border-color: #21262d; }
        [data-theme="dark"] .st-add-bar { background: #0d1117; border-color: #21262d; }
        [data-theme="dark"] .st-input { background: #0d1117; border-color: #21262d; color: #E5E7EB; }
        [data-theme="dark"] .st-input:focus { border-color: #9B1515; box-shadow: 0 0 0 3px rgba(155,21,21,.15); }
        [data-theme="dark"] .st-table-head { background: #0d1117; border-color: #21262d; }
        [data-theme="dark"] .st-row { border-color: #1c2128; }
        [data-theme="dark"] .st-row:hover { background: #1c2128; }
        [data-theme="dark"] .st-id-badge { background: #1c2128; border-color: #21262d; color: #8A9AB0; }
        [data-theme="dark"] .st-service-cell span { color: #E5E7EB; }
        [data-theme="dark"] .st-service-icon { background: rgba(155,21,21,.15); border-color: rgba(155,21,21,.3); color: #ff6b6b; }
        [data-theme="dark"] .st-empty-icon { background: #0d1117; border-color: #21262d; color: #374151; }
        [data-theme="dark"] .st-empty p:first-of-type { color: #E5E7EB; }

        /* ── MOBILE BOTTOM NAV ── */
        #adminMobileNav {
            display: none; position: fixed; bottom: 0; left: 0; right: 0; height: 68px;
            background: #fff; border-top: 1px solid #f0e0e0; z-index: 200;
            align-items: center; justify-content: space-around;
            box-shadow: 0 -4px 20px rgba(139,0,0,.10);
        }
        .adm-mob-item {
            flex: 1; height: 68px; display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 3px;
            font-size: 9.5px; font-weight: 600; color: #9ca3af;
            text-decoration: none; transition: color .2s;
            position: relative; cursor: pointer; border: none; background: none; padding: 0;
        }
        .adm-mob-item.active { color: #8B0000; }
        .adm-mob-item i { font-size: 20px; }
        .adm-mob-item.active i { filter: drop-shadow(0 0 6px rgba(139,0,0,.35)); }
        #admMobFabWrap { flex: 1; display: flex; align-items: center; justify-content: center; }
        #admMobFab {
            width: 50px; height: 50px; border-radius: 50%;
            background: linear-gradient(135deg, #8B0000, #660000);
            color: white; border: none; font-size: 20px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 16px rgba(139,0,0,.45); cursor: pointer;
            transition: transform .25s cubic-bezier(.34,1.56,.64,1); position: relative; top: -10px;
        }
        #admMobFab.open { transform: rotate(45deg) translateY(-10px); }
        #admMobFabMenu {
            position: fixed; bottom: 86px; left: 50%; transform: translateX(-50%) scaleY(0);
            transform-origin: bottom center; background: #fff; border-radius: 16px;
            box-shadow: 0 8px 32px rgba(139,0,0,.18); border: 1px solid #f5e8e8;
            min-width: 220px; overflow: hidden;
            transition: transform .25s cubic-bezier(.34,1.56,.64,1), opacity .2s;
            opacity: 0; pointer-events: none; z-index: 300;
        }
        #admMobFabMenu.open { transform: translateX(-50%) scaleY(1); opacity: 1; pointer-events: auto; }
        .adm-fab-item {
            display: flex; align-items: center; gap: 12px; padding: 13px 18px;
            font-size: 13.5px; font-weight: 600; color: #333; text-decoration: none;
            transition: background .15s; border-bottom: 1px solid #fdf5f5;
        }
        .adm-fab-item:last-child { border-bottom: none; }
        .adm-fab-item:hover { background: #fff0f0; color: #8B0000; }
        .adm-fab-item .adm-fab-icon {
            width: 32px; height: 32px; background: #fef2f2; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; font-size: 13px; color: #8B0000; flex-shrink: 0;
        }

        @media (max-width: 767px) {
            #sidebar { display: none !important; }
            #mainContent { margin-left: 0 !important; padding-bottom: 86px !important; }
            #siteFooter { margin-left: 0 !important; margin-bottom: 68px; }
            #adminMobileNav { display: flex; }
            .header { padding: 0 1rem; }
            .header-title { display: none; }
            .st-add-bar .flex { flex-direction: column; }
            .btn-add-service { width: 100%; justify-content: center; }
        }
        @media (min-width: 768px) { #adminMobileNav { display: none !important; } }
        [data-theme="dark"] #adminMobileNav { background: #0a0a0a; border-top-color: #1a1a1a; }
        [data-theme="dark"] #admMobFabMenu { background: #111; border-color: #222; }
        [data-theme="dark"] .adm-fab-item { color: #E5E7EB; border-bottom-color: #1a1a1a; }
        [data-theme="dark"] .adm-fab-item:hover { background: #1a1a1a; }
        [data-theme="dark"] .adm-mob-item { color: #4b5563; }
        [data-theme="dark"] .adm-mob-item.active { color: #ff6b6b; }
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
        @php $notifications = collect($notifications ?? []); $notifCount = $notifications->count(); @endphp
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
                <div class="header-name">Admin</div>
                <div class="header-role">Admin</div>
            </div>
        </div>
    </div>
</header>

<!-- ════════════ SIDEBAR ════════════ -->
<aside id="sidebar">
    <div class="sidebar-inner">

        <div class="nav-group">
            <div class="group-header {{ request()->routeIs('admin.admin.dashboard') ? 'active-group' : '' }}">
                <div class="group-icon"><i class="fa-solid fa-hospital"></i></div>
                <div class="group-label-wrap">
                    <span class="group-label">Clinic Management</span>
                    <span class="group-sublabel">Core clinical modules</span>
                </div>
            </div>
            <div class="group-body">
                <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
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
                <a href="{{ route('admin.user_management') }}" class="nav-link {{ request()->routeIs('admin.user_management*') ? 'active' : '' }}"><i class="fa-solid fa-user-gear"></i> User Management</a>
                <a href="{{ route('admin.role_permissions') }}" class="nav-link {{ request()->routeIs('admin.role_permissions') ? 'active' : '' }}"><i class="fa-solid fa-user-shield"></i> Roles &amp; Permissions</a>
                <a href="{{ route('admin.academic_periods') }}" class="nav-link {{ request()->routeIs('admin.academic_periods*') ? 'active' : '' }}"><i class="fa-solid fa-school"></i> Academic Periods</a>
                <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-calendar-days"></i> Clinic Schedule</a>
                <a href="{{ route('admin.service-types') }}" class="nav-link {{ request()->routeIs('admin.service-types*') ? 'active' : '' }}"><i class="fa-solid fa-list-check"></i> Service Types</a>
                <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-file-pen"></i> Document Templates</a>
                <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-boxes-stacked"></i> Inventory</a>
            </div>
        </div>

        <div class="nav-sep"></div>

        <div class="nav-group">
            <div class="group-header {{ request()->routeIs('admin.system_logs') ? 'active-group' : '' }}">
                <div class="group-icon"><i class="fa-solid fa-server"></i></div>
                <div class="group-label-wrap">
                    <span class="group-label">System</span>
                    <span class="group-sublabel">Admin &amp; configuration</span>
                </div>
            </div>
            <div class="group-body">
                <a href="{{ route('admin.admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-database"></i> Data Backup</a>
                <a href="{{ route('admin.system_logs') }}" class="nav-link {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}"><i class="fa-solid fa-clipboard-list"></i> System Logs</a>
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
                <span style="width:30px;height:30px;background:#fef2f2;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa-solid fa-right-from-bracket text-sm"></i>
                </span>
                <span class="font-semibold">Log out</span>
            </button>
        </form>
    </div>
</aside>

<!-- ════════════ MOBILE BOTTOM NAV ════════════ -->
<nav id="adminMobileNav">
    <a href="{{ route('admin.admin.dashboard') }}" class="adm-mob-item">
        <i class="fa-solid fa-chart-line"></i><span>Dashboard</span>
    </a>
    <a href="{{ route('admin.admin.dashboard') }}" class="adm-mob-item">
        <i class="fa-solid fa-users"></i><span>Patients</span>
    </a>
    <div id="admMobFabWrap">
        <div id="admMobFabMenu">
            <a href="{{ route('admin.admin.dashboard') }}" class="adm-fab-item">
                <span class="adm-fab-icon"><i class="fa-solid fa-calendar-check"></i></span> Appointments
            </a>
            <a href="{{ route('admin.system_logs') }}" class="adm-fab-item">
                <span class="adm-fab-icon"><i class="fa-solid fa-clipboard-list"></i></span> System Logs
            </a>
            <a href="{{ route('admin.user_management') }}" class="adm-fab-item">
                <span class="adm-fab-icon"><i class="fa-solid fa-user-gear"></i></span> User Management
            </a>
            <a href="{{ route('admin.role_permissions') }}" class="adm-fab-item">
                <span class="adm-fab-icon"><i class="fa-solid fa-user-shield"></i></span> Roles &amp; Permissions
            </a>
            <a href="{{ route('admin.service-types') }}" class="adm-fab-item">
                <span class="adm-fab-icon"><i class="fa-solid fa-list-check"></i></span> Service Types
            </a>
        </div>
        <button id="admMobFab" aria-label="Quick navigation"><i class="fa-solid fa-bars"></i></button>
    </div>
    <a href="{{ route('admin.admin.dashboard') }}" class="adm-mob-item">
        <i class="fa-solid fa-calendar-check"></i><span>Appts</span>
    </a>
    <a href="{{ route('admin.system_logs') }}" class="adm-mob-item {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}">
        <i class="fa-solid fa-clipboard-list"></i><span>Logs</span>
    </a>
</nav>

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
                <div style="font-size:11px;color:#B5A99A;letter-spacing:2px;text-transform:uppercase;margin-bottom:6px;font-weight:600;">
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
                                <input
                                    type="text"
                                    name="name"
                                    placeholder="Enter new service type name…"
                                    required
                                    autocomplete="off"
                                    value="{{ old('name') }}"
                                    class="st-input"
                                >
                            </div>

                            <button type="submit" class="btn-add-service">
                                <i class="fa-solid fa-plus" style="font-size:12px;"></i>
                                Add Service
                            </button>
                        </div>

                        <div>
                            <textarea
                                name="description"
                                placeholder="Enter service description…"
                                class="st-input"
                                style="height:90px; padding:12px 16px; resize:none;"
                            >{{ old('description') }}</textarea>
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
                    <div class="st-row" style="grid-template-columns: 68px 1fr 1.3fr auto; animation-delay: {{ $i * 45 }}ms;">

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
                            <form
                                method="POST"
                                action="{{ route('admin.service-types.destroy', $service->id) }}"
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

<!-- ════════════ FOOTER ════════════ -->
<footer id="siteFooter" class="bg-[#8B0000] text-[#F4F4F4] p-6">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 text-sm text-center">
        <span><span class="text-gray-300">© 2025–2026</span> <span class="font-semibold">Polytechnic University of the Philippines</span></span>
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
</script>

</body>
</html>