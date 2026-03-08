<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Role Permissions | PUP Taguig Dental Clinic</title>
    <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>tailwind.config = { daisyui: { themes: false } }</script>

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #F8F6F3; color: #2D2420; margin: 0; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #D1C9C0; border-radius: 10px; }

        /* ── Sidebar (original) ── */
        #sidebar { transition: width 300ms ease, transform 300ms ease; will-change: width, transform; }
        #mainContent { transition: margin-left 300ms ease; }
        .sidebar-link {
            display: flex; align-items: center; width: 100%;
            padding: 12px; border-radius: 12px;
            transition: background-color .2s ease;
            position: relative;
        }
        .sidebar-link:hover .sidebar-tooltip { opacity: 1; transform: scale(1); }
        #sidebar[style*="16rem"] .sidebar-tooltip { display: none; }
        #sidebar[style*="16rem"] .sidebar-link { justify-content: flex-start; gap: 12px; }
        .sidebar-link i { width: 24px; min-width: 24px; text-align: center; }
        #sidebar[style*="72px"] .sidebar-link { justify-content: center; gap: 0; }
        .notif-open  { opacity: 1 !important; transform: scale(1) !important; pointer-events: auto !important; }
        .notif-close { opacity: 0 !important; transform: scale(.95) !important; pointer-events: none !important; }

        /* ── Role cards ── */
        .role-card {
            background: #FDFCFB;
            border: 1.5px solid #EDE8E2;
            border-radius: 14px;
            padding: 14px 16px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(.4,0,.2,1);
        }
        .role-card:hover { transform: translateX(3px); }
        .role-card.active {
            background: #fff;
            border-color: #7B0D0D;
            box-shadow: 0 4px 20px rgba(123,13,13,0.12);
        }
        .role-avatar {
            width: 42px; height: 42px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 13px;
            flex-shrink: 0; transition: all 0.2s;
            background: #F0EBE6; color: #8A7A6F;
        }
        .role-card.active .role-avatar {
            background: linear-gradient(135deg, #7B0D0D, #9B1515);
            color: #fff;
            box-shadow: 0 4px 10px rgba(123,13,13,0.3);
        }
        .badge-pill {
            display: inline-block;
            padding: 2px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 700;
            letter-spacing: 0.5px; text-transform: uppercase;
        }
        .progress-bar { height: 5px; background: #EDE8E2; border-radius: 10px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 10px; transition: width 0.4s ease; }
        .role-card.active .progress-fill { background: linear-gradient(90deg, #7B0D0D, #C9973A); }

        /* ── Permission group card ── */
        .group-card {
            background: #fff;
            border: 1.5px solid #EDE8E2;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            transition: opacity 0.4s ease, transform 0.4s ease;
        }
        .group-header {
            display: flex; align-items: center;
            padding: 14px 20px;
            background: #FDFCFB;
            cursor: pointer;
            transition: background 0.15s;
            user-select: none;
        }
        .group-header:hover { background: #FAF4EF; }

        .group-icon {
            width: 36px; height: 36px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; flex-shrink: 0; margin-right: 14px;
        }

        /* Dot progress */
        .dot-row { display: flex; gap: 3px; align-items: center; }
        .dot { width: 6px; height: 6px; border-radius: 50%; background: #E5DDD5; transition: background 0.2s; }
        .dot.on { /* set via inline style per group color */ }

        /* All-toggle area */
        .all-toggle-wrap {
            display: flex; align-items: center; gap: 8px;
            background: #F5EFE9; border-radius: 8px;
            padding: 5px 12px; cursor: pointer;
        }

        /* Toggle switch */
        .toggle-switch {
            position: relative; width: 46px; height: 26px;
            display: inline-block; flex-shrink: 0;
        }
        .toggle-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
        .toggle-track {
            position: absolute; cursor: pointer; inset: 0;
            background: #F9FAFB;
            border: 2px solid #E5E7EB;
            border-radius: 13px;
            transition: all 0.25s cubic-bezier(.4,0,.2,1);
        }
        .toggle-track::after {
            content: '';
            position: absolute; top: 3px; left: 3px;
            width: 16px; height: 16px; border-radius: 50%;
            background: #D1D5DB;
            box-shadow: 0 1px 4px rgba(0,0,0,0.25);
            transition: left 0.25s cubic-bezier(.4,0,.2,1), background 0.2s;
        }
        .toggle-switch input:checked + .toggle-track {
            background: linear-gradient(135deg, #7B0D0D, #9B1515);
            border-color: #7B0D0D;
            box-shadow: 0 0 0 3px rgba(123,13,13,0.13);
        }
        .toggle-switch input:checked + .toggle-track::after {
            left: 22px; background: #fff;
        }
        .toggle-switch.disabled .toggle-track { cursor: not-allowed; opacity: 0.45; }

        /* Permission row */
        .perm-row {
            display: flex; align-items: center;
            padding: 12px 20px 12px 70px;
            border-bottom: 1px solid #F5F0EB;
            transition: background 0.15s;
        }
        .perm-row:last-child { border-bottom: none; }
        .perm-row:hover { background: #FAF6F0; }

        /* Status badge */
        .status-granted { font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 20px; }
        .status-denied  { font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 20px; background: #F5F0EB; color: #B5A99A; }

        /* Group body collapse */
        .group-body { border-top: 1px solid #F0EBE6; overflow: hidden; transition: max-height 0.35s ease, opacity 0.25s ease; max-height: 9999px; opacity: 1; }
        .group-body.collapsed { max-height: 0; opacity: 0; border-top: none; }

        /* Chevron */
        .chevron { transition: transform 0.2s; color: #B5A99A; font-size: 11px; }
        .chevron.collapsed { transform: rotate(180deg); }

        /* Footer bar */
        .footer-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 24px;
            background: #fff; border-radius: 14px;
            border: 1.5px solid #EDE8E2;
            margin-top: 18px;
        }

        /* Buttons */
        .btn-reset {
            background: #F5EFE9; color: #6B5E56; border: none;
            border-radius: 10px; padding: 10px 20px;
            font-weight: 600; font-size: 14px; cursor: pointer;
            font-family: 'Inter', sans-serif; transition: background 0.15s;
        }
        .btn-reset:hover { background: #EDE5DA; }
        .btn-save {
            background: linear-gradient(135deg, #7B0D0D, #9B1515);
            color: #fff; border: none; border-radius: 10px;
            padding: 10px 28px; font-weight: 700; font-size: 14px;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 14px rgba(123,13,13,0.25);
            transition: all 0.2s;
        }
        .btn-save:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(123,13,13,0.35); }

        /* Search */
        .search-input {
            width: 100%; padding: 10px 14px 10px 38px;
            border: 1.5px solid #EDE8E2; border-radius: 10px;
            font-size: 14px; font-family: 'Inter', sans-serif;
            background: #fff; outline: none; color: #2D2420;
            transition: border-color 0.18s;
        }
        .search-input:focus { border-color: #7B0D0D; }

        /* Collapse/expand btn */
        .btn-collapse {
            padding: 10px 16px; border: 1.5px solid #EDE8E2;
            border-radius: 10px; background: #fff;
            font-size: 13px; font-family: 'Inter', sans-serif;
            cursor: pointer; color: #6B5E56; white-space: nowrap;
            transition: background 0.15s;
        }
        .btn-collapse:hover { background: #F5EFE9; }

        /* Super admin banner */
        .protected-banner {
            background: linear-gradient(135deg, #FEF3C7, #FDE68A);
            border: 1px solid #FCD34D;
            border-radius: 12px;
            padding: 12px 18px;
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 16px;
        }

        /* Accent summary card */
        .accent-card {
            background: linear-gradient(135deg, #7B0D0D 0%, #9B1515 100%);
            border-radius: 14px; padding: 18px 20px;
            color: #fff; margin-top: 16px;
        }

        /* Fade-in on load */
        @keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up { animation: fadeUp 0.45s ease both; }

        /* Modal */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(15,5,5,0.55);
            display: flex; align-items: center; justify-content: center;
            z-index: 200; backdrop-filter: blur(4px);
        }
        .modal-box {
            background: #fff; border-radius: 20px;
            padding: 36px 36px 28px; width: 420px;
            box-shadow: 0 32px 80px rgba(0,0,0,0.25);
        }
    </style>
</head>

<body>

<!-- ══ HEADER (original, untouched) ═══════════════════════ -->
<div class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-[#660000] to-[#8B0000] text-[#F4F4F4] px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <div class="w-10 rounded-full ml-2"><img src="{{ asset('images/PUP.png') }}" alt="PUP Logo"/></div>
        <div class="w-10 rounded-full"><img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUPT DMS Logo"/></div>
        <span class="font-bold text-sm md:text-lg">PUP TAGUIG DENTAL CLINIC</span>
    </div>
    <div class="flex items-center gap-6">
        <div id="notifDropdown" class="relative">
            <button id="notifBtn" type="button" class="btn btn-ghost btn-circle indicator text-[#F4F4F4]">
                <i class="fa-regular fa-bell text-lg"></i>
            </button>
            <div id="notifMenu" class="absolute right-0 mt-3 w-80 rounded-2xl bg-white shadow-xl border border-gray-100 z-50 opacity-0 scale-95 pointer-events-none transition-all duration-200 ease-out origin-top-right">
                <div class="p-4 border-b"><span class="font-bold text-[#8B0000]">Notifications</span></div>
                <div class="px-4 py-10 text-center">
                    <div class="text-sm font-semibold text-gray-800">No notifications</div>
                    <div class="text-xs text-gray-500 mt-1">You're all caught up.</div>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <img src="https://i.pravatar.cc/40" class="rounded-full w-9 h-9">
            <div class="leading-tight">
                <p class="text-sm font-semibold text-[#F4F4F4]">Super Admin</p>
                <p class="italic text-[11px] text-[#F4F4F4]/80">System Administrator</p>
            </div>
        </div>
    </div>
</div>

<!-- ══ SIDEBAR (original, untouched) ══════════════════════ -->
<aside id="sidebar" class="fixed left-0 top-[80px] h-[calc(100vh-80px)] w-[72px] bg-[#FAFAFA] drop-shadow-xl transition-all duration-300 flex flex-col justify-between z-40">
    <div>
        <div id="sidebarToggleWrapper" class="flex items-center justify-center px-4 py-6 transition-all duration-300">
            <button onclick="toggleSidebar()" id="sidebarToggleBtn" class="w-10 h-10 flex items-center justify-center rounded-full text-[#757575] hover:text-[#8B0000] hover:bg-[#D9D9D9] transition-all duration-300">
                <i id="sidebarIcon" class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>
        <nav class="space-y-2 px-3 text-gray-600 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-chart-line text-lg"></i>
                <span class="sidebar-text font-bold opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Dashboard</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Dashboard</span>
            </a>
            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-users text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Patients</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Patients</span>
            </a>
            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-calendar-check text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Appointments</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Appointments</span>
            </a>
            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-school text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Academic Periods</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Academic Periods</span>
            </a>
            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-file-circle-check text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Document Requests</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Document Requests</span>
            </a>
            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-file-pen text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Document Template</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Document Template</span>
            </a>
            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-file text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Reports</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Reports</span>
            </a>
            <div class="pt-3 text-[10px] uppercase tracking-widest text-gray-400 px-2">System</div>
            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-database text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Data Backup</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Data Backup</span>
            </a>
            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-clipboard-list text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">System Logs</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">System Logs</span>
            </a>
            <a href="#" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
                <i class="fa-solid fa-gear text-lg"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">System Settings</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">System Settings</span>
            </a>
            <a href="{{ route('admin.role_permissions') }}" class="sidebar-link bg-[#8B0000] text-[#F4F4F4] hover:bg-[#8B0000] hover:text-[#F4F4F4] relative">
                <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] opacity-100"></span>
                <i class="fa-solid fa-user-shield text-lg"></i>
                <span class="sidebar-text font-bold opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Roles</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Roles</span>
            </a>
        </nav>
    </div>
    <div class="px-3 pb-5 space-y-2">
        <button id="themeToggle" class="sidebar-link relative flex items-center justify-center w-full px-2 py-1.5 rounded-xl bg-[#7B6CF6] text-[#F4F4F4] transition-all duration-200 hover:scale-105">
            <i id="themeIcon" class="fa-regular fa-moon text-sm"></i>
            <span class="sidebar-text text-sm opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Dark Mode</span>
            <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Dark Mode</span>
        </button>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="sidebar-link w-full relative flex items-center px-3 py-2 rounded-xl text-sm text-red-600 hover:bg-red-50 transition-all duration-200">
                <i class="fa-solid fa-right-from-bracket text-sm"></i>
                <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Log out</span>
                <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Log out</span>
            </button>
        </form>
    </div>
</aside>

<!-- ══ MAIN ════════════════════════════════════════════════ -->
<main id="mainContent" class="pt-[100px] pb-10 w-full" style="padding-left: 1.5rem; padding-right: 1.5rem;">
<div style="max-width: 1280px; margin: 0 auto;" class="fade-up">

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
        <a href="{{ route('admin.dashboard') }}"
            style="display:inline-flex; align-items:center; gap:8px; padding:11px 20px; border-radius:10px; background:#F5EFE9; color:#7B0D0D; font-weight:700; font-size:14px; text-decoration:none; border:1.5px solid #EDE8E2; transition:all 0.2s;"
            onmouseover="this.style.background='#EDE5DA'"
            onmouseout="this.style.background='#F5EFE9'">
            <i class="fa-solid fa-arrow-left" style="font-size:12px;"></i> Back to Dashboard
        </a>

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
                    'Dashboard'         => ['fa-chart-line',      '#7B0D0D'],
                    'Patients'          => ['fa-users',            '#B45309'],
                    'Appointments'      => ['fa-calendar-check',   '#065F46'],
                    'Document Requests' => ['fa-file-circle-check','#1D4ED8'],
                    'Document Template' => ['fa-file-pen',         '#6D28D9'],
                    'Reports'           => ['fa-chart-column',        '#6D28D9'],
                    'Academic Periods'  => ['fa-school',           '#065F46'],
                    'Data Backup'       => ['fa-database',         '#EA580C'],
                    'System Logs'       => ['fa-clipboard-list',   '#6D28D9'],
                    'System Settings'   => ['fa-gear',             '#374151'],
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
                                    <div class="dot {{ $d < $roleGranted ? 'on' : '' }}" style="{{ $d < $roleGranted ? 'background:'.$icol.';' : '' }}"></div>
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

<footer style="background:#660000; color:#F4F4F4; padding:24px; text-align:center; font-size:12px; opacity:0.8;">
    &copy; {{ date('Y') }} PUP Taguig Dental Clinic — Dental Management System
</footer>

<!-- ══ SCRIPTS ═════════════════════════════════════════════ -->
<script>
/* ── Sidebar (original) ─────────────────────────────── */
let sidebarOpen = false;
function applyLayout(w) {
    document.getElementById('sidebar').style.width = w;
    document.getElementById('mainContent').style.marginLeft = w;
    document.getElementById('mainContent').style.width = 'auto';
}
function toggleSidebar() {
    const texts = document.querySelectorAll('.sidebar-text');
    const icon  = document.getElementById('sidebarIcon');
    const wrap  = document.getElementById('sidebarToggleWrapper');
    const btn   = document.getElementById('sidebarToggleBtn');
    sidebarOpen = !sidebarOpen;
    if (sidebarOpen) {
        applyLayout('16rem');
        texts.forEach(t => { t.classList.remove('opacity-0','w-0'); t.classList.add('opacity-100','w-auto'); });
        wrap.classList.remove('justify-center'); wrap.classList.add('justify-end');
        btn.classList.add('translate-x-2');
        icon.classList.replace('fa-bars','fa-xmark');
    } else {
        applyLayout('72px');
        texts.forEach(t => { t.classList.add('opacity-0','w-0'); t.classList.remove('opacity-100','w-auto'); });
        wrap.classList.remove('justify-end'); wrap.classList.add('justify-center');
        btn.classList.remove('translate-x-2');
        icon.classList.replace('fa-xmark','fa-bars');
    }
}
document.addEventListener('DOMContentLoaded', () => { applyLayout('72px'); });

/* ── Notification (original) ─────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('notifBtn');
    const menu = document.getElementById('notifMenu');
    if (!btn || !menu) return;
    let isOpen = false;
    const openMenu  = () => { isOpen = true;  menu.classList.remove('notif-close'); menu.classList.add('notif-open'); };
    const closeMenu = () => { isOpen = false; menu.classList.remove('notif-open');  menu.classList.add('notif-close'); };
    btn.addEventListener('click', e => { e.stopPropagation(); isOpen ? closeMenu() : openMenu(); });
    menu.addEventListener('click', e => e.stopPropagation());
    document.addEventListener('click', () => { if (isOpen) closeMenu(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && isOpen) closeMenu(); });
    closeMenu();
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

    const roleId   = card.dataset.roleId;
    const roleName = card.dataset.roleName;
    const granted  = parseInt(card.dataset.granted);
    const total    = parseInt(card.dataset.total);
    const pct      = parseInt(card.dataset.pct);

    // Update accent card
    document.getElementById('accentRoleName').textContent = roleName;
    document.getElementById('accentPct').textContent = pct + '%';
    document.getElementById('accentCount').textContent = granted + ' of ' + total + ' permissions active';
    document.getElementById('accentBar').style.width = pct + '%';

    // Show/hide protected banner
    const slug = card.dataset.slug.toLowerCase();
    const isSuper = ['super_admin','super-admin','superadmin'].includes(slug) || roleName.toLowerCase().includes('super');
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
    const body  = header.nextElementSibling;
    const chev  = header.querySelector('.chevron');
    const isCollapsed = body.classList.contains('collapsed');
    body.classList.toggle('collapsed');
    chev.classList.toggle('collapsed', !isCollapsed);
}
function toggleAllGroups() {
    const btn = document.getElementById('collapseBtn');
    // Only affect the visible form's groups
    const visibleForm = document.querySelector('.role-form[style*="block"]');
    if (!visibleForm) return;
    const bodies  = visibleForm.querySelectorAll('.group-body');
    const chevs   = visibleForm.querySelectorAll('.chevron');
    allExpanded = !allExpanded;
    bodies.forEach(b => b.classList.toggle('collapsed', !allExpanded));
    chevs.forEach(c => c.classList.toggle('collapsed', !allExpanded));
    btn.textContent = allExpanded ? 'Collapse All' : 'Expand All';
}

/* ── Per-permission toggle ───────────────────────── */
function onPermChange(input) {
    const row    = input.closest('.perm-row');
    const badge  = row.querySelector('.perm-status');
    const dot    = row.querySelector('.perm-dot');
    const label  = row.querySelector('.perm-label');
    const color  = input.dataset.color;
    const roleId = input.dataset.role;
    const mSlug  = input.dataset.module;

    if (input.checked) {
        badge.textContent = 'Granted';
        badge.className   = 'perm-status status-granted';
        badge.style.background = color + '18';
        badge.style.color      = color;
        dot.style.background   = color;
        label.style.color      = '#2D2420';
        row.style.background   = color + '06';
    } else {
        badge.textContent = 'Denied';
        badge.className   = 'perm-status status-denied';
        badge.style.background = '';
        badge.style.color      = '';
        dot.style.background   = '#D5CEC8';
        label.style.color      = '#8A7A6F';
        row.style.background   = 'transparent';
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
    const all     = [...form.querySelectorAll(`.perm-toggle[data-module="${mSlug}"]`)];
    const checked = all.filter(t => t.checked).length;
    const master  = form.querySelector(`.group-master[data-module="${mSlug}"]`);
    if (!master) return;
    master.checked       = checked === all.length;
    master.indeterminate = checked > 0 && checked < all.length;
}

function updateDots(roleId, mSlug, color) {
    const cont = document.getElementById(`dots-${roleId}-${mSlug}`);
    if (!cont) return;
    const form = document.getElementById('form-role-' + roleId);
    if (!form) return;
    const toggles = [...form.querySelectorAll(`.perm-toggle[data-module="${mSlug}"]`)];
    const dots    = cont.querySelectorAll('.dot');
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
    const all     = [...groupCard.querySelectorAll('.perm-toggle')];
    const checked = all.filter(t => t.checked).length;
    const countEl = groupCard.querySelector('.group-count');
    if (countEl) countEl.textContent = `${checked} of ${all.length} enabled`;
}

function updateAccentCard(roleId) {
    const form = document.getElementById('form-role-' + roleId);
    if (!form) return;
    const all     = [...form.querySelectorAll('.perm-toggle')];
    const total   = all.length;
    const checked = all.filter(t => t.checked).length;
    const pct     = total > 0 ? Math.round(checked / total * 100) : 0;

    document.getElementById('accentPct').textContent   = pct + '%';
    document.getElementById('accentCount').textContent = `${checked} of ${total} permissions active`;
    document.getElementById('accentBar').style.width   = pct + '%';

    // Also update the role card itself
    const card = document.querySelector(`.role-card[data-role-id="${roleId}"]`);
    if (card) {
        card.querySelector('.pct-label').textContent   = pct + '%';
        card.querySelector('.count-label').textContent = `${checked} of ${total} permissions`;
        card.querySelector('.progress-fill').style.width = pct + '%';
        card.dataset.granted = checked;
        card.dataset.pct     = pct;
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
    document.getElementById('newRoleModal').style.display='none';
    document.getElementById('newRoleName').value = '';
    document.getElementById('newRoleSlug').value = '';
    document.getElementById('newRoleError').style.display = 'none';
}

function createNewRole() {
    const name = document.getElementById('newRoleName').value.trim();
    const slug = document.getElementById('newRoleSlug').value.trim();
    const errEl = document.getElementById('newRoleError');

    if (!name) { errEl.textContent = 'Please enter a role name.'; errEl.style.display = 'block'; return; }
    if (!slug) { errEl.textContent = 'Please enter a slug.'; errEl.style.display = 'block'; return; }

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
        if (['super_admin','super-admin','superadmin'].includes(slug) || name.toLowerCase().includes('super')) {
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