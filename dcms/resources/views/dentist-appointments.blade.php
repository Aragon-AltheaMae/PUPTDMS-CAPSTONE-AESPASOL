<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Appointments | PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- daisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      daisyui: {
        themes: false,
      },
    }
  </script>

  <style>
    body {
      font-family: 'Inter';
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(6px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in {
      animation: fadeIn 0.6s ease-out forwards;
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

        /* Notif dropdown */
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
    .sidebar-link {
      display: flex;
      align-items: center;
      transition: background-color 0.2s ease, transform 0.2s ease;
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

    #sidebar.expanded .sidebar-link span i {
      margin-right: 0 !important;
    }

    #sidebar.collapsed .sidebar-tooltip {
      display: block;
    }

    #sidebar.expanded .sidebar-tooltip {
      display: none;
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

    /* ── DARK MODE ── */
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

    /* ── APPOINTMENT CARDS ── */
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(8px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .appt-card {
      background: #ffffff;
      border: 1px solid #EDE8E3;
      border-radius: 14px;
      position: relative;
      overflow: hidden;
      transition: box-shadow .2s, border-color .2s, transform .15s;
      animation: slideIn .3s ease both;
    }

    .appt-card:nth-child(even) {
      background: #FDFAF8;
    }

    .appt-card:hover {
      border-color: rgba(139, 0, 0, .25);
      box-shadow: 0 6px 24px rgba(139, 0, 0, .09);
      transform: translateX(3px);
    }

    .appt-card::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
      background: #8B0000;
      border-radius: 14px 0 0 14px;
      opacity: 0;
      transition: opacity .2s;
    }

    .appt-card:hover::before {
      opacity: 1;
    }

    /* Today row highlight */
    .appt-card.is-today {
      background: #f0fdf4 !important;
      border-color: #86efac !important;
      box-shadow: 0 2px 12px rgba(34, 197, 94, .1);
    }

    .appt-card.is-today::before {
      background: #16a34a;
      opacity: 1;
    }

    /* ── SERVICE BADGES ── */
    .service-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 12px;
      font-weight: 500;
      padding: 3px 10px;
      border-radius: 6px;
      width: fit-content;
    }

    .service-badge-default {
      background: #f9f0f0;
      color: #8B0000;
    }

    .service-badge-surgery {
      background: #fff0f0;
      color: #C41E3A;
    }

    .service-badge-checkup {
      background: #ebf5ee;
      color: #2D7A5E;
    }

    .service-badge-whitening {
      background: #fff3e0;
      color: #B86C00;
    }

    .service-badge-extraction {
      background: #fff0e8;
      color: #B85000;
    }

    /* ── STATUS PILLS ── */
    .status-pill {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 11px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 20px;
    }

    .status-confirmed {
      background: #dcfce7;
      color: #15803d;
      border: 1px solid #86efac;
    }

    .status-pending {
      background: #fef3c7;
      color: #92400e;
      border: 1px solid #fcd34d;
    }

    .status-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: currentColor;
      flex-shrink: 0;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {

      0%,
      100% {
        opacity: 1
      }

      50% {
        opacity: .4
      }
    }

    .time-chip {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      background: #F5F0EB;
      border: 1px solid #E8E0D8;
      border-radius: 7px;
      padding: 5px 10px;
      font-size: 13px;
      font-weight: 500;
      color: #6B5E52;
    }

    /* ── TIMELINE ── */
    .timeline-dot {
      width: 18px;
      height: 18px;
      background: #8b0000;
      border-radius: 50%;
      border: 3px solid white;
      box-shadow: 0 0 0 3px rgba(139, 0, 0, .2), 0 2px 8px rgba(139, 0, 0, .3);
      flex-shrink: 0;
    }

    .timeline-dot-past {
      width: 18px;
      height: 18px;
      background: #9ca3af;
      border-radius: 50%;
      border: 3px solid white;
      box-shadow: 0 0 0 3px rgba(156, 163, 175, .2);
      flex-shrink: 0;
    }

    /* ── TAB TOGGLE ── */
    .tab-toggle-wrap {
      background: #5a0000;
      border-radius: 9999px;
      padding: 5px;
      display: flex;
      gap: 4px;
      box-shadow: 0 4px 16px rgba(139, 0, 0, .35);
    }

    .tab-btn-toggle {
      padding: 8px 20px;
      border-radius: 9999px;
      font-size: 13px;
      font-weight: 600;
      transition: all .25s ease;
      display: flex;
      align-items: center;
      gap: 8px;
      color: rgba(255, 255, 255, .6);
    }

    .tab-btn-toggle.active {
      background: white;
      color: #8b0000;
      box-shadow: 0 2px 10px rgba(0, 0, 0, .15);
    }

    .tab-count-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 20px;
      height: 20px;
      padding: 0 6px;
      border-radius: 9999px;
      font-size: 11px;
      font-weight: 700;
    }

    .tab-btn-toggle.active .tab-count-badge {
      background: #8b0000;
      color: white;
    }

    .tab-btn-toggle:not(.active) .tab-count-badge {
      background: rgba(255, 255, 255, .2);
      color: rgba(255, 255, 255, .8);
    }

    /* ── ACTION BUTTONS ── */
    .action-row {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .action-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
      height: 30px;
      padding: 0 12px;
      border-radius: 8px;
      font-size: 11px;
      font-weight: 600;
      transition: all .15s ease;
      white-space: nowrap;
    }

    .action-btn-start {
      background: #15803d;
      color: white;
      border: 1.5px solid #15803d;
    }

    .action-btn-start:hover {
      background: #166534;
      box-shadow: 0 2px 8px rgba(21, 128, 61, .3);
    }

    .action-btn-start:disabled {
      background: #d1d5db;
      border-color: #d1d5db;
      color: #9ca3af;
      cursor: not-allowed;
      box-shadow: none;
    }

    .action-btn-reschedule {
      background: #fffbeb;
      color: #92400e;
      border: 1.5px solid #fcd34d;
    }

    .action-btn-reschedule:hover {
      background: #fef3c7;
      box-shadow: 0 2px 8px rgba(251, 191, 36, .25);
    }

    .action-btn-cancel {
      background: #fff1f2;
      color: #9f1239;
      border: 1.5px solid #fecdd3;
    }

    .action-btn-cancel:hover {
      background: #ffe4e6;
      box-shadow: 0 2px 8px rgba(159, 18, 57, .15);
    }

    /* ── SUMMARY BAR ── */
    .summary-bar {
      background: linear-gradient(135deg, #7f0000 0%, #a00000 100%);
      border-bottom: 1px solid rgba(255, 255, 255, .08);
    }

    .summary-chip {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(255, 255, 255, .12);
      border: 1px solid rgba(255, 255, 255, .18);
      border-radius: 9999px;
      padding: 4px 12px;
      font-size: 12px;
      font-weight: 500;
      color: white;
    }

    .summary-chip-highlight {
      background: rgba(255, 255, 255, .22);
      border-color: rgba(255, 255, 255, .35);
      font-weight: 700;
    }
  </style>
</head>

<body class="bg-[#F4F4F4] text-[#333333] font-normal min-h-screen flex flex-col">

  <!-- HEADER -->
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
                    <div style="padding:.85rem 1rem .65rem; font-weight:700; color:var(--red); font-size:.82rem; border-bottom:1px solid #f5e8e8;">
                        Notifications
                    </div>
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
                    <div class="header-name">Dr. Nelson Angeles</div>
                    <div class="header-role">Dentist</div>
                </div>
            </div>
        </div>
    </header>

  <!-- ══════════════════════════════════════
       SUMMARY BAR
  ══════════════════════════════════════ -->
  @php
  $upcomingAppointments = $upcomingAppointments ?? collect();
  $pastAppointments = $pastAppointments ?? collect();
  $today = $today ?? \Carbon\Carbon::today()->toDateString();

  $todayAppts = $upcomingAppointments->filter(fn($a) => ($a->appointment_date ?? null) === $today);
  $todayCount = $todayAppts->count();
  $nextAppt = $upcomingAppointments->sortBy('appointment_date')->first();
  $nextName = $nextAppt ? (optional($nextAppt->patient)->name ?? 'Unknown') : null;
  $nextTime = $nextAppt ? \Carbon\Carbon::parse($nextAppt->appointment_time)->format('g:i A') : null;
  $nextDate = $nextAppt ? \Carbon\Carbon::parse($nextAppt->appointment_date)->format('M j') : null;

  $upcomingGrouped = $upcomingAppointments->groupBy(fn($a) => \Carbon\Carbon::parse($a->appointment_date)->format('F'));
  $pastGrouped = $pastAppointments->groupBy(fn($a) => \Carbon\Carbon::parse($a->appointment_date)->format('F'));
  $upcomingTotal = $upcomingAppointments->count();
  $pastTotal = $pastAppointments->count();
  @endphp

  <!-- SIDEBAR -->
  <aside id="sidebar"
    class="fixed left-0 top-[72px]
         h-[calc(100vh-72px)]
         bg-white
         drop-shadow-xl
         transition-all duration-300
         flex flex-col justify-between z-40 expanded"
    style="width: 200px;">

    <!-- TOP -->
    <div class="pt-4">

      <!-- Toggle Button -->
      <div id="sidebarToggleWrapper" class="flex items-center justify-end px-4 py-2">
        <button onclick="toggleSidebar()"
          id="sidebarToggleBtn"
          class="w-8 h-8 flex items-center justify-center
              rounded-full text-[#757575] hover:text-[#8B0000]
              hover:bg-[#F0F0F0] transition-all duration-300">
          <i id="sidebarIcon" class="fa-solid fa-xmark text-base"></i>
        </button>
      </div>

      <!-- NAVIGATION LABEL -->
      <div class="section-label px-4 mb-6">Navigation</div>

      <!-- MENU -->
      <nav class="space-y-2 px-3 text-gray-600">

        <!-- DASHBOARD -->
        <a href="{{ route('dentist.dashboard') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('dentist.dashboard') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2
                h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                {{ request()->routeIs('dentist.dashboard') ? 'opacity-100' : 'opacity-0' }}"></span>

          <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200 ml-1">
            <i class="fa-solid fa-chart-line text-lg"></i>
          </span>
          <span class="sidebar-text ml-2 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">
            Dashboard
          </span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
            Dashboard
          </span>
        </a>

        <!-- PATIENTS -->
        <a href="{{ route('dentist.patients') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('dentist.patients') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2
                h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                {{ request()->routeIs('dentist.patients') ? 'opacity-100' : 'opacity-0' }}"></span>

          <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200 ml-1.5">
            <i class="fa-solid fa-users text-lg"></i>
          </span>
          <span class="sidebar-text ml-2 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">
            Patients
          </span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
            Patients
          </span>
        </a>

        <!-- APPOINTMENTS -->
        <a href="{{ route('dentist.appointments') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('dentist.appointments') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2
                h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                {{ request()->routeIs('dentist.appointments') ? 'opacity-100' : 'opacity-0' }}"></span>

          <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200 ml-1">
            <i class="fa-solid fa-calendar-check text-lg"></i>
          </span>
          <span class="sidebar-text ml-2 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">
            Appointments
          </span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
            Appointments
          </span>
        </a>

        <!-- Document Requests -->
        <a href="{{ route('dentist.documentrequests') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('dentist.documentrequests') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2
                h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                {{ request()->routeIs('dentist.documentrequests') ? 'opacity-100' : 'opacity-0' }}"></span>

          <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200 ml-1">
            <i class="fa-solid fa-file-circle-check text-lg"></i>
          </span>
          <span class="sidebar-text ml-2 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">
            Document Requests
          </span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
            Document Requests
          </span>
        </a>

        <!-- INVENTORY -->
        <a href="{{ route('dentist.inventory') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('dentist.inventory') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2
                h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                {{ request()->routeIs('dentist.inventory') ? 'opacity-100' : 'opacity-0' }}"></span>

          <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200 ml-1">
            <i class="fa-solid fa-box text-lg"></i>
          </span>
          <span class="sidebar-text ml-2 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">
            Inventory
          </span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
            Inventory
          </span>
        </a>

        <!-- REPORTS -->
        <a href="{{ route('dentist.report') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('dentist.report') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2
                h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                {{ request()->routeIs('dentist.report') ? 'opacity-100' : 'opacity-0' }}"></span>

          <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200 ml-1">
            <i class="fa-solid fa-file text-lg"></i>
          </span>
          <span class="sidebar-text ml-2 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">
            Reports
          </span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
            Reports
          </span>
        </a>
      </nav>
    </div>

    <!-- BOTTOM -->
    <div class="px-3 pb-5 space-y-4">
      <div class="section-label">Settings</div>

      <div class="w-full px-3">
        <div id="themeToggle" class="theme-toggle-container">
          <button type="button" class="theme-option active" data-theme="light" aria-label="Light mode">
            <i class="fa-solid fa-sun"></i>
          </button>
          <button type="button" class="theme-option" data-theme="dark" aria-label="Dark mode">
            <i class="fa-regular fa-moon"></i>
          </button>
          <div class="theme-indicator" aria-hidden="true"></div>
        </div>
      </div>

      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button
          class="group sidebar-link w-full relative flex items-center rounded-xl text-sm
             text-red-600 hover:bg-red-100 transition-all duration-200">
          <div class="flex items-center justify-center w-8 h-8 rounded-lg flex-shrink-0 transition-all duration-200 ml-2">
            <i class="fa-solid fa-right-from-bracket text-sm"></i>
          </div>
          <span class="sidebar-text ml-2 opacity-0 w-0 font-semibold overflow-hidden transition-all duration-300 delay-150">
            Log out
          </span>
          <span class="sidebar-tooltip absolute left-full ml-2 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
            Log out
          </span>
        </button>
      </form>

    </div>
  </aside>

  <!-- ================= MAIN ================= -->
  <main
    id="mainContent"
    class="pt-[100px] px-6 py-6 fade-up min-h-screen">
    <div class="max-w-7xl mt-4 mx-auto fade-in">

      <!-- Summary bar — inline, above title -->
      <div class="summary-bar rounded-2xl px-6 py-3 flex items-center gap-3 flex-wrap mb-6">
        <i class="fa-solid fa-circle-info text-white/60 text-sm ml-1"></i>
        <span class="text-white/70 text-xs font-medium">Today's snapshot:</span>

        @if($todayCount > 0)
        <span class="summary-chip summary-chip-highlight">
          <i class="fa-solid fa-calendar-check text-xs"></i>
          {{ $todayCount }} appointment{{ $todayCount > 1 ? 's' : '' }} today
        </span>
        @else
        <span class="summary-chip">
          <i class="fa-regular fa-calendar text-xs"></i>
          No appointments today
        </span>
        @endif

        @if($nextAppt)
        <span class="summary-chip">
          <i class="fa-solid fa-clock text-xs"></i>
          Next: <strong>{{ $nextName }}</strong> — {{ $nextDate }} at {{ $nextTime }}
        </span>
        @endif

        <span class="summary-chip ml-auto">
          <i class="fa-solid fa-list text-xs"></i>
          {{ $upcomingTotal }} upcoming · {{ $pastTotal }} past
        </span>
      </div>

      <!-- Page title row -->
      <div class="flex items-end justify-between mt-6 mb-10 px-1">
        <div>
          <h1 class="text-2xl font-bold text-[#660000]">Appointments</h1>

          <div class="flex items-center gap-2 mt-2">
            <i class="fa-solid fa-sun text-yellow-400 text-sm"></i>
            <p id="currentDate" class="text-sm text-[#757575]"></p>
          </div>
        </div>

        <!-- Improved tab toggle with counts -->
        <div class="tab-toggle-wrap">
          <button id="btnUpcoming" class="tab-btn-toggle active">
            <i class="fa-solid fa-calendar-clock text-xs"></i>
            Upcoming
            <span class="tab-count-badge">{{ $upcomingTotal }}</span>
          </button>
          <button id="btnPast" class="tab-btn-toggle">
            <i class="fa-solid fa-clock-rotate-left text-xs"></i>
            Past
            <span class="tab-count-badge">{{ $pastTotal }}</span>
          </button>
        </div>
      </div>

      <!-- ═══════ UPCOMING SECTION ═══════ -->
      <section id="upcomingSection" class="pb-16">

        @forelse($upcomingGrouped as $month => $items)
        <div class="mb-14">

          <!-- Month heading with improved timeline dot -->
          <div class="flex items-center gap-4 mb-5">
            <div class="timeline-dot"></div>
            <h2 class="text-xl font-bold text-[#8b0000]">{{ $month }}</h2>
            <span class="bg-[#f9f0f0] text-[#8b0000] text-xs font-semibold px-3 py-1 rounded-full border border-[#8b0000]/15">
              {{ $items->count() }} {{ Str::plural('appointment', $items->count()) }}
            </span>
          </div>

          <!-- Left timeline line + cards -->
          <div class="relative pl-10">
            <div class="absolute left-[8px] top-0 bottom-0 w-[2px] bg-gradient-to-b from-[#8b0000]/30 to-[#8b0000]/05 rounded-full"></div>

            <!-- Column headers -->
            <div class="grid grid-cols-[180px_130px_180px_180px_130px_120px_60px]
            text-[11px] font-semibold uppercase tracking-wider text-gray-600
            pb-2 border-b border-gray-200 mb-3 px-5">
              <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-[10px]"></i>Date</span>
              <span class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-[10px]"></i>Time</span>
              <span>Service</span>
              <span>Patient</span>
              <span>Program</span>
              <span>Status</span>
              <span class="text-right">Actions</span>
            </div>

            <!-- Cards -->
            <div class="space-y-2.5">
              @foreach($items as $i => $appt)
              @php
              $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
              $program = optional($appt->patient)->program ?? '—';
              $dateLabel = \Carbon\Carbon::parse($appt->appointment_date)->format('F j, Y');
              $weekday = \Carbon\Carbon::parse($appt->appointment_date)->format('l');
              $timeLabel = $appt->appointment_time
              ? \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') : '—';
              $serviceLabel = ($appt->service_type ?? '') === 'Others'
              ? (($appt->other_services ?? '') ?: 'Others')
              : ($appt->service_type ?? '—');
              $isToday = ($appt->appointment_date ?? null) === $today;
              $serviceLower = strtolower($serviceLabel);
              $badgeClass = 'service-badge-default';
              if (str_contains($serviceLower, 'surgery')) $badgeClass = 'service-badge-surgery';
              elseif (str_contains($serviceLower, 'check')) $badgeClass = 'service-badge-checkup';
              elseif (str_contains($serviceLower, 'whiten'))$badgeClass = 'service-badge-whitening';
              elseif (str_contains($serviceLower, 'extrac'))$badgeClass = 'service-badge-extraction';
              @endphp

              <div class="appt-card {{ $isToday ? 'is-today' : '' }}" style="animation-delay:{{ $i * 0.04 }}s">
                <div class="grid grid-cols-[1.4fr_1fr_1.5fr_1.5fr_1fr_0.9fr_1.6fr]
                            items-center px-5 py-3.5 gap-2">

                  <!-- Date -->
                  <div>
                    <p class="text-[13px] font-semibold text-gray-800">{{ $dateLabel }}</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $weekday }}</p>
                    @if($isToday)
                    <span class="inline-block mt-1 text-[9px] font-bold uppercase tracking-wide
                                 bg-green-500 text-white px-2 py-0.5 rounded-md shadow-sm">Today</span>
                    @endif
                  </div>

                  <!-- Time -->
                  <div>
                    <span class="time-chip">
                      <i class="fa-regular fa-clock text-xs"></i>{{ $timeLabel }}
                    </span>
                  </div>

                  <!-- Service -->
                  <div>
                    <span class="service-badge {{ $badgeClass }}">{{ $serviceLabel }}</span>
                  </div>

                  <!-- Patient -->
                  <div>
                    <p class="text-[13px] font-semibold text-gray-800">{{ $patientName }}</p>
                  </div>

                  <!-- Program -->
                  <div>
                    @if($program === '—')
                    <span class="text-[12px] text-gray-400">—</span>
                    @else
                    <span class="inline-block bg-gray-100 text-gray-500 text-[11px] font-medium
                                 px-2.5 py-1 rounded-full border border-gray-200">{{ $program }}</span>
                    @endif
                  </div>

                  <!-- Status -->
                  <div>
                    @if($isToday)
                    <span class="status-pill status-confirmed">
                      <span class="status-dot"></span>Confirmed
                    </span>
                    @else
                    <span class="status-pill status-pending">
                      <span class="status-dot"></span>Upcoming
                    </span>
                    @endif
                  </div>

                  <!-- Actions — horizontal row -->
                  <div class="action-row justify-end">
                    <button type="button"
                      class="action-btn action-btn-start"
                      onclick="openStartProcedureModal(this)"
                      data-id="{{ $appt->id }}"
                      data-name="{{ $patientName }}"
                      data-datetime="{{ $dateLabel }} | {{ $timeLabel }}"
                      {{ $isToday ? '' : 'disabled' }}
                      title="{{ $isToday ? '' : 'Only available on appointment date' }}">
                      <i class="fa-solid fa-play text-[9px]"></i> Start
                    </button>
                    <button type="button"
                      class="action-btn action-btn-reschedule"
                      onclick="openRescheduleModal(this)"
                      data-id="{{ $appt->id }}"
                      data-name="{{ $patientName }}"
                      data-datetime="{{ $dateLabel }} | {{ $timeLabel }}">
                      <i class="fa-solid fa-rotate-right text-[9px]"></i> Reschedule
                    </button>
                    <button type="button"
                      class="action-btn action-btn-cancel"
                      onclick="openCancelAppointmentModal(this)"
                      data-id="{{ $appt->id }}"
                      data-name="{{ $patientName }}"
                      data-datetime="{{ $dateLabel }} | {{ $timeLabel }}">
                      <i class="fa-solid fa-xmark text-[9px]"></i> Cancel
                    </button>
                  </div>

                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        @empty
        <div class="flex flex-col items-center justify-center py-24 text-gray-400">
          <i class="fa-regular fa-calendar-xmark text-5xl mb-4 text-gray-300"></i>
          <p class="text-base font-semibold text-gray-500">No upcoming appointments</p>
          <p class="text-sm mt-1">New appointments will appear here once scheduled.</p>
        </div>
        @endforelse

      </section>

      <!-- ═══════ PAST SECTION ═══════ -->
      <section id="pastSection" class="pb-16 hidden">

        @forelse($pastGrouped as $month => $items)
        <div class="mb-14">

          <div class="flex items-center gap-4 mb-5 pl-2">
            <div class="timeline-dot-past"></div>
            <h2 class="text-xl font-bold text-gray-400">{{ $month }}</h2>
            <span class="bg-gray-100 text-gray-400 text-xs font-semibold px-3 py-1 rounded-full">
              {{ $items->count() }} {{ Str::plural('appointment', $items->count()) }}
            </span>
          </div>

          <div class="relative pl-10">
            <div class="absolute left-[8px] top-0 bottom-0 w-[2px] bg-gray-200 rounded-full"></div>

            <!-- Column headers -->
            <div class="grid grid-cols-[1.4fr_1fr_1.5fr_1.5fr_1fr]
                        text-[11px] font-semibold uppercase tracking-wider text-gray-400
                        pb-2 border-b border-gray-200 mb-3 px-5">
              <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-[10px]"></i>Date</span>
              <span class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-[10px]"></i>Time</span>
              <span>Service</span>
              <span>Patient</span>
              <span>Program</span>
            </div>

            <div class="space-y-2.5">
              @foreach($items as $i => $appt)
              @php
              $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
              $program = optional($appt->patient)->program ?? '—';
              $dateLabel = \Carbon\Carbon::parse($appt->appointment_date)->format('F j, Y');
              $weekday = \Carbon\Carbon::parse($appt->appointment_date)->format('l');
              $timeLabel = $appt->appointment_time
              ? \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') : '—';
              $serviceLabel = ($appt->service_type ?? '') === 'Others'
              ? (($appt->other_services ?? '') ?: 'Others')
              : ($appt->service_type ?? '—');
              $serviceLower = strtolower($serviceLabel);
              $badgeClass = 'service-badge-default';
              if (str_contains($serviceLower, 'surgery')) $badgeClass = 'service-badge-surgery';
              elseif (str_contains($serviceLower, 'check')) $badgeClass = 'service-badge-checkup';
              elseif (str_contains($serviceLower, 'whiten'))$badgeClass = 'service-badge-whitening';
              elseif (str_contains($serviceLower, 'extrac'))$badgeClass = 'service-badge-extraction';
              @endphp

              <div class="appt-card opacity-70" style="animation-delay:{{ $i * 0.04 }}s">
                <div class="grid grid-cols-[1.4fr_1fr_1.5fr_1.5fr_1fr]
                            items-center px-5 py-3.5 gap-2">
                  <div>
                    <p class="text-[13px] font-semibold text-gray-500">{{ $dateLabel }}</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $weekday }}</p>
                  </div>
                  <div><span class="time-chip text-gray-400"><i class="fa-regular fa-clock text-xs"></i>{{ $timeLabel }}</span></div>
                  <div><span class="service-badge {{ $badgeClass }} opacity-70">{{ $serviceLabel }}</span></div>
                  <div>
                    <p class="text-[13px] font-medium text-gray-500">{{ $patientName }}</p>
                  </div>
                  <div>
                    @if($program === '—')
                    <span class="text-[12px] text-gray-400">—</span>
                    @else
                    <span class="inline-block bg-gray-100 text-gray-400 text-[11px] font-medium
                                 px-2.5 py-1 rounded-full border border-gray-200">{{ $program }}</span>
                    @endif
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        @empty
        <div class="flex flex-col items-center justify-center py-24 text-gray-400">
          <i class="fa-regular fa-calendar-xmark text-5xl mb-4 text-gray-300"></i>
          <p class="text-base font-semibold text-gray-500">No past appointments</p>
          <p class="text-sm mt-1">Completed appointments will appear here.</p>
        </div>
        @endforelse

      </section>

      <div class="pb-16"></div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="footer bg-[#8B0000] text-[#F4F4F4] p-6">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 pl-24 text-sm text-center">
      <span><span class="text-gray-300">© 2025–2026</span> <span class="font-semibold">Polytechnic University of the Philippines</span></span>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/terms/" class="hover:underline">Terms of Use</a>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/privacy/" class="hover:underline">Privacy Statement</a>
    </div>
  </footer>

  <!-- ═══════════════ MODALS ═══════════════ -->

  <!-- Reschedule Modal -->
  <div id="rescheduleModal" class="fixed inset-0 bg-black/40 flex items-center justify-center backdrop-blur-sm hidden z-[9999]">
    <div class="bg-white w-[560px] rounded-2xl overflow-hidden shadow-2xl">
      <div class="bg-amber-400 px-8 py-5 text-center">
        <h2 class="text-xl font-bold text-gray-800">Reschedule Appointment</h2>
      </div>
      <div class="px-10 py-7 bg-gray-50">
        <p class="text-base font-bold text-gray-900 mb-1 text-center">You are about to reschedule this appointment.</p>
        <p class="text-sm text-gray-500 mb-5 text-center">You will be able to select a new date and time.</p>
        <div class="bg-white border border-gray-200 rounded-2xl px-8 py-5 text-center mb-4 shadow-sm">
          <div class="flex items-center justify-center gap-2 text-gray-700 text-sm font-bold mb-3">
            <i class="fa-regular fa-circle-user text-lg"></i><span>Appointment Details</span>
          </div>
          <p class="text-sm text-gray-800">Patient Name: <span class="font-bold" id="resPatientName">—</span></p>
          <p class="text-sm text-gray-600 mt-1" id="resAppointmentDate">—</p>
        </div>
        <div class="flex justify-end gap-3">
          <button onclick="closeRescheduleModal()"
            class="px-6 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 font-semibold hover:bg-gray-100 transition text-sm shadow-sm">Cancel</button>
          <button onclick="confirmReschedule()"
            class="px-6 py-2 rounded-lg bg-amber-400 text-gray-800 font-semibold hover:bg-amber-500 transition text-sm shadow-sm">Reschedule</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Start Procedure Modal -->
  <div id="startProcedureModal" class="fixed inset-0 bg-black/50 flex items-center backdrop-blur-sm justify-center hidden z-[9999]">
    <div class="bg-white w-[560px] rounded-2xl overflow-hidden shadow-2xl">
      <div class="bg-green-700 px-8 py-5 text-center">
        <h2 class="text-xl font-bold text-white">Confirm Procedure Start</h2>
      </div>
      <div class="px-10 py-7 bg-gray-50">
        <p class="text-base font-bold text-gray-900 mb-1 text-center">You are about to begin this appointment's procedure.</p>
        <p class="text-sm text-gray-500 mb-5 text-center">This will mark the appointment as in progress.</p>
        <div class="bg-white border border-gray-200 rounded-2xl px-8 py-5 text-center mb-4 shadow-sm">
          <div class="flex items-center justify-center gap-2 text-gray-700 text-sm font-bold mb-3">
            <i class="fa-regular fa-circle-user text-lg"></i><span>Appointment Details</span>
          </div>
          <p class="text-sm text-gray-800">Patient Name: <span class="font-bold" id="startPatientName">—</span></p>
          <p class="text-sm text-gray-600 mt-1" id="startAppointmentDate">—</p>
        </div>
        <div class="flex justify-end gap-3">
          <button onclick="closeStartProcedureModal()"
            class="px-6 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 font-semibold hover:bg-gray-100 transition text-sm shadow-sm">Cancel</button>
          <button onclick="confirmStartProcedure()"
            class="px-6 py-2 rounded-lg bg-green-700 text-white font-semibold hover:bg-green-800 transition text-sm shadow-sm">Start Procedure</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Cancel Modal -->
  <div id="cancelAppointmentModal" class="fixed inset-0 bg-black/40 flex items-center backdrop-blur-sm justify-center hidden z-[9999]">
    <div class="bg-white w-[560px] rounded-2xl overflow-hidden shadow-2xl">
      <div class="bg-[#8b0000] px-8 py-5 text-center">
        <h2 class="text-xl font-bold text-white">Cancel Appointment</h2>
      </div>
      <div class="px-10 py-7 bg-gray-50">
        <p class="text-base font-bold text-gray-900 mb-1 text-center">You are about to cancel this appointment.</p>
        <p class="text-sm text-gray-500 mb-5 text-center">This action cannot be undone.</p>
        <div class="bg-white border border-gray-200 rounded-2xl px-8 py-5 text-center mb-4 shadow-sm">
          <div class="flex items-center justify-center gap-2 text-gray-700 text-sm font-bold mb-3">
            <i class="fa-regular fa-calendar-check text-lg"></i><span>Appointment Details</span>
          </div>
          <p class="text-sm text-gray-800">Patient Name: <span class="font-bold" id="cancelPatientName">—</span></p>
          <p class="text-sm text-gray-600 mt-1" id="cancelAppointmentDate">—</p>
        </div>
        <div class="flex justify-end gap-3">
          <button onclick="closeCancelAppointmentModal()"
            class="px-6 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 font-semibold hover:bg-gray-100 transition text-sm shadow-sm">Keep Appointment</button>
          <button onclick="confirmCancelAppointment()"
            class="px-6 py-2 rounded-lg bg-[#8b0000] text-white font-semibold hover:bg-[#6f0000] transition text-sm shadow-sm">Cancel Appointment</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById("currentDate").textContent =
      new Date().toLocaleDateString("en-US", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
      });

    // =========================
    // THEME TOGGLE 
    // =========================
    const html = document.documentElement;
    const themeToggleContainer = document.getElementById("themeToggle");
    const themeIndicator = themeToggleContainer.querySelector(".theme-indicator");
    const themeOptions = themeToggleContainer.querySelectorAll(".theme-option");

    function applyTheme(theme) {
      html.setAttribute("data-theme", theme);
      localStorage.setItem("theme", theme);

      themeOptions.forEach(option => {
        if (option.getAttribute("data-theme") === theme) {
          option.classList.add("active");
        } else {
          option.classList.remove("active");
        }
      });

      if (theme === "dark") {
        themeIndicator.classList.add("dark-mode");
      } else {
        themeIndicator.classList.remove("dark-mode");
      }
    }

    applyTheme(localStorage.getItem("theme") || "light");

    themeOptions.forEach(option => {
      option.addEventListener("click", () => {
        const theme = option.getAttribute("data-theme");
        applyTheme(theme);
      });
    });

    let sidebarOpen = true;

    function applyLayout(sidebarWidth) {
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('mainContent');
      sidebar.style.width = sidebarWidth;
      main.style.marginLeft = sidebarWidth;
    }

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const texts = document.querySelectorAll('.sidebar-text');
      const icon = document.getElementById('sidebarIcon');
      const toggleWrapper = document.getElementById('sidebarToggleWrapper');

      sidebarOpen = !sidebarOpen;

      if (sidebarOpen) {
        applyLayout('220px');
        sidebar.classList.remove('collapsed');
        sidebar.classList.add('expanded');
        texts.forEach(t => {
          t.classList.remove('opacity-0', 'w-0');
          t.classList.add('opacity-100');
        });
        toggleWrapper.classList.remove('justify-center');
        toggleWrapper.classList.add('justify-end');
        icon.classList.replace('fa-bars', 'fa-xmark');
      } else {
        applyLayout('72px');
        sidebar.classList.remove('expanded');
        sidebar.classList.add('collapsed');
        texts.forEach(t => {
          t.classList.add('opacity-0', 'w-0');
          t.classList.remove('opacity-100');
        });
        toggleWrapper.classList.remove('justify-end');
        toggleWrapper.classList.add('justify-center');
        icon.classList.replace('fa-xmark', 'fa-bars');
      }
      applyTheme(localStorage.getItem("theme") || "light");
    }

    document.addEventListener('DOMContentLoaded', () => {
      sidebarOpen = true;
      applyLayout('220px');
    });

    /* ── NOTIF TOGGLE ── */
        document.getElementById("notifBtn").addEventListener("click", e => {
            e.stopPropagation();
            document.getElementById("notifMenu").classList.toggle("open");
        });
        document.addEventListener("click", () => document.getElementById("notifMenu").classList.remove("open"));

    // ── TABS ──
    const btnUpcoming = document.getElementById('btnUpcoming');
    const btnPast = document.getElementById('btnPast');
    const upcomingSection = document.getElementById('upcomingSection');
    const pastSection = document.getElementById('pastSection');

    function setActiveTab(tab) {
      const isUpcoming = tab === 'upcoming';
      upcomingSection?.classList.toggle('hidden', !isUpcoming);
      pastSection?.classList.toggle('hidden', isUpcoming);
      btnUpcoming?.classList.toggle('active', isUpcoming);
      btnPast?.classList.toggle('active', !isUpcoming);
    }
    btnUpcoming?.addEventListener('click', () => setActiveTab('upcoming'));
    btnPast?.addEventListener('click', () => setActiveTab('past'));

    // ── MODALS ──
    let selectedApptId = null;

    function openRescheduleModal(btn) {
      selectedApptId = btn.dataset.id;
      document.getElementById('resPatientName').textContent = btn.dataset.name || '—';
      document.getElementById('resAppointmentDate').textContent = btn.dataset.datetime || '—';
      document.getElementById('rescheduleModal').classList.remove('hidden');
    }

    function closeRescheduleModal() {
      document.getElementById('rescheduleModal').classList.add('hidden');
      selectedApptId = null;
    }

    function confirmReschedule() {
      const url = "{{ route('dentist.appointments.reschedule', ['id' => ':id']) }}".replace(':id', selectedApptId);
      window.location.href = url;
    }

    function openStartProcedureModal(btn) {
      selectedApptId = btn.dataset.id;
      document.getElementById('startPatientName').textContent = btn.dataset.name || '—';
      document.getElementById('startAppointmentDate').textContent = btn.dataset.datetime || '—';
      document.getElementById('startProcedureModal').classList.remove('hidden');
    }

    function closeStartProcedureModal() {
      document.getElementById('startProcedureModal').classList.add('hidden');
      selectedApptId = null;
    }

    function confirmStartProcedure() {
      window.location.href = `/dentist/appointments/${selectedApptId}/start`;
    }

    function openCancelAppointmentModal(btn) {
      selectedApptId = btn.dataset.id;
      document.getElementById('cancelPatientName').textContent = btn.dataset.name || '—';
      document.getElementById('cancelAppointmentDate').textContent = btn.dataset.datetime || '—';
      document.getElementById('cancelAppointmentModal').classList.remove('hidden');
    }

    function closeCancelAppointmentModal() {
      document.getElementById('cancelAppointmentModal').classList.add('hidden');
      selectedApptId = null;
    }

    function confirmCancelAppointment() {
      window.location.href = `/dentist/appointments/${selectedApptId}/cancel`;
    }
  </script>

</body>

</html>