<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PUP Taguig Dental Clinic | Reports</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

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

    @keyframes shimmer {
      0% {
        transform: translateX(-100%) skewX(-15deg);
      }

      100% {
        transform: translateX(300%) skewX(-15deg);
      }
    }

    .btn-shimmer {
      position: relative;
      overflow: hidden;
    }

    .btn-shimmer::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 40%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
      animation: shimmer 2.4s infinite;
    }

    /* KPI */
    .kpi-card {
      background: white;
      border-radius: 14px;
      padding: 18px 22px;
      display: flex;
      align-items: center;
      gap: 16px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
      border: 1.5px solid #f0f0f0;
      transition: transform 0.2s, box-shadow 0.2s;
      text-decoration: none;
    }

    .kpi-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(139, 0, 0, 0.10);
    }

    .kpi-icon {
      width: 46px;
      height: 46px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      flex-shrink: 0;
    }

    .kpi-value {
      font-size: 1.55rem;
      font-weight: 800;
      line-height: 1;
      color: #1a1a1a;
    }

    .kpi-label {
      font-size: 0.72rem;
      font-weight: 500;
      color: #888;
      margin-top: 3px;
      letter-spacing: 0.03em;
      text-transform: uppercase;
    }

    .kpi-delta {
      font-size: 0.7rem;
      font-weight: 600;
      margin-top: 4px;
    }

    .kpi-delta.up {
      color: #16a34a;
    }

    .kpi-delta.down {
      color: #dc2626;
    }

    .kpi-arrow {
      margin-left: auto;
      color: #ccc;
      font-size: 0.75rem;
      align-self: center;
    }

    .kpi-card:hover .kpi-arrow {
      color: #8B0000;
    }

    /* Chart card */
    .chart-card {
      background: white;
      border-radius: 14px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
      border: 1.5px solid #f0f0f0;
      padding: 20px;
    }

    .chart-card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 12px;
    }

    .chart-title {
      font-size: 0.88rem;
      font-weight: 700;
      color: #8B0000;
    }

    .period-select {
      font-size: 0.72rem;
      font-weight: 600;
      color: #8B0000;
      background: #fff5f5;
      border: 1.5px solid #f9b2b2;
      border-radius: 20px;
      padding: 3px 24px 3px 12px;
      cursor: pointer;
      outline: none;
      appearance: none;
      -webkit-appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238B0000'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 8px center;
    }

    /* Quick buttons */
    .quick-btn {
      position: relative;
      flex: 1;
      border-radius: 14px;
      overflow: hidden;
      background: linear-gradient(135deg, #8B0000 0%, #5a0000 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 8px;
      color: white;
      font-weight: 700;
      font-size: 0.85rem;
      text-align: center;
      padding: 16px;
      transition: transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 4px 16px rgba(139, 0, 0, 0.25);
      text-decoration: none;
    }

    .quick-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 28px rgba(139, 0, 0, 0.35);
    }

    .quick-btn .qb-icon {
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.15);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }

    .quick-btn::before {
      content: '';
      position: absolute;
      top: -30%;
      right: -20%;
      width: 100px;
      height: 100px;
      background: rgba(255, 215, 0, 0.12);
      border-radius: 50%;
    }

    /* Stock bars */
    .stock-row {
      padding: 10px 0;
      border-bottom: 1px solid #f5f5f5;
    }

    .stock-name {
      font-size: 0.78rem;
      font-weight: 600;
      color: #333;
      margin-bottom: 6px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .stock-bar-bg {
      height: 7px;
      background: #f0f0f0;
      border-radius: 10px;
      overflow: hidden;
    }

    .stock-bar-fill {
      height: 100%;
      border-radius: 10px;
      transition: width 0.8s cubic-bezier(.4, 0, .2, 1);
    }

    /* Table */
    .reports-table th {
      font-size: 0.7rem;
      font-weight: 700;
      color: #888;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      padding: 10px 14px;
      background: #fafafa;
    }

    .reports-table td {
      font-size: 0.8rem;
      padding: 11px 14px;
      border-bottom: 1px solid #f5f5f5;
      color: #333;
      vertical-align: middle;
    }

    .reports-table tr:last-child td {
      border-bottom: none;
    }

    .reports-table tr:hover td {
      background: #fff8f8;
    }

    .status-badge {
      font-size: 0.67rem;
      font-weight: 700;
      padding: 3px 10px;
      border-radius: 20px;
      display: inline-block;
      letter-spacing: 0.04em;
    }

    .status-ready {
      background: #dcfce7;
      color: #15803d;
    }

    .status-pending {
      background: #fef9c3;
      color: #a16207;
    }

    /* Sidebar */
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

    .notif-open {
      opacity: 1 !important;
      transform: scale(1) !important;
      pointer-events: auto !important;
    }

    .notif-close {
      opacity: 0 !important;
      transform: scale(.95) !important;
      pointer-events: none !important;
    }

    /* Theme toggle */
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

    /* Dark mode */
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
  </style>
</head>

<body class="bg-[#f4f4f6] min-h-screen flex flex-col">

  <!-- HEADER -->
  <div class="fixed top-0 left-0 right-0 z-50
              bg-gradient-to-r from-[#660000] to-[#8B0000]
              text-[#F4F4F4] px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="w-12 rounded-full ml-5"><img src="{{ asset('images/PUP.png') }}" alt="PUP Logo" /></div>
      <div class="w-12 rounded-full"><img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUPT DMS Logo" /></div>
      <span class="font-bold text-lg">PUP TAGUIG DENTAL CLINIC</span>
    </div>
    <div class="flex items-center gap-8">
      @php
      $notifications = collect($notifications ?? []);
      $notifCount = $notifications->count();
      @endphp
      <div id="notifDropdown" class="relative">
        <button id="notifBtn" type="button" class="btn btn-ghost btn-circle indicator text-[#F4F4F4]">
          @if($notifCount > 0)
          <span class="indicator-item badge badge-secondary text-s text-[#F4F4F4] bg-[#660000] border-none">{{ $notifCount }}</span>
          @endif
          <i class="fa-regular fa-bell text-lg"></i>
        </button>
        <div id="notifMenu" class="absolute right-0 mt-3 w-80 rounded-2xl bg-white shadow-xl border border-gray-100 z-50 opacity-0 scale-95 pointer-events-none transition-all duration-200 ease-out origin-top-right">
          <div class="p-4 border-b"><span class="font-bold text-[#8B0000]">Notifications</span></div>
          <div class="max-h-80 overflow-y-auto">
            @forelse($notifications as $n)
            <a href="{{ $n['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50">
              <div class="text-sm font-semibold text-gray-900">{{ $n['title'] ?? 'Notification' }}</div>
              @if(!empty($n['message']))<div class="text-xs text-[#ADADAD] mt-0.5">{{ $n['message'] }}</div>@endif
              @if(!empty($n['time']))<div class="text-[11px] text-gray-400 mt-1">{{ $n['time'] }}</div>@endif
            </a>
            @empty
            <div class="px-4 py-10 text-center justify-items-center">
              <img src="{{ asset('images/no-notifications.png') }}" alt="No Notification">
              <div class="text-sm font-semibold text-gray-800">No notifications</div>
              <div class="text-xs text-[#757575] mt-1">You're all caught up.</div>
            </div>
            @endforelse
          </div>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <img src="https://i.pravatar.cc/40" class="rounded-full w-10 h-10">
        <div>
          <p class="text-l font-semibold text-[#F4F4F4]">Dr. Nelson Angeles</p>
          <p class="italic text-xs text-[#F4F4F4]/80">Dentist</p>
        </div>
      </div>
    </div>
  </div>

  <!-- SIDEBAR -->
  <aside id="sidebar"
    class="fixed left-0 top-[72px] h-[calc(100vh-72px)] bg-white drop-shadow-xl transition-all duration-300 flex flex-col justify-between z-40 expanded"
    style="width: 220px;">
    <div class="pt-4">
      <div id="sidebarToggleWrapper" class="flex items-center justify-end px-4 py-2">
        <button onclick="toggleSidebar()" id="sidebarToggleBtn"
          class="w-8 h-8 flex items-center justify-center rounded-full text-[#757575] hover:text-[#8B0000] hover:bg-[#F0F0F0] transition-all duration-300">
          <i id="sidebarIcon" class="fa-solid fa-xmark text-base"></i>
        </button>
      </div>
      <div class="section-label px-4 mb-6">Navigation</div>
      <nav class="space-y-2 px-3 text-gray-600">
        <a href="{{ route('dentist.dashboard') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8 transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs('dentist.dashboard') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] {{ request()->routeIs('dentist.dashboard') ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center ml-1"><i class="fa-solid fa-chart-line text-lg"></i></span>
          <span class="sidebar-text ml-2 text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300">Dashboard</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Dashboard</span>
        </a>
        <a href="{{ route('dentist.patients') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8 transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs('dentist.patients') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] {{ request()->routeIs('dentist.patients') ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center ml-1.5"><i class="fa-solid fa-users text-lg"></i></span>
          <span class="sidebar-text ml-2 text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300">Patients</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Patients</span>
        </a>
        <a href="{{ route('dentist.appointments') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8 transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs('dentist.appointments') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] {{ request()->routeIs('dentist.appointments') ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center ml-1"><i class="fa-solid fa-calendar-check text-lg"></i></span>
          <span class="sidebar-text ml-2 text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300">Appointments</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Appointments</span>
        </a>
        <a href="{{ route('dentist.documentrequests') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8 transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs('dentist.documentrequests') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] {{ request()->routeIs('dentist.documentrequests') ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center ml-1"><i class="fa-solid fa-file-circle-check text-lg"></i></span>
          <span class="sidebar-text ml-2 text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300">Document Requests</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Document Requests</span>
        </a>
        <a href="{{ route('dentist.inventory') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8 transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs('dentist.inventory') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] {{ request()->routeIs('dentist.inventory') ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center ml-1"><i class="fa-solid fa-box text-lg"></i></span>
          <span class="sidebar-text ml-2 text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300">Inventory</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Inventory</span>
        </a>
        <a href="{{ route('dentist.report') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8 transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs('dentist.report') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] {{ request()->routeIs('dentist.report') ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center ml-1"><i class="fa-solid fa-file text-lg"></i></span>
          <span class="sidebar-text ml-2 text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300">Reports</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Reports</span>
        </a>
      </nav>
    </div>
    <div class="px-3 pb-5 space-y-4">
      <div class="section-label">Settings</div>
      <div class="w-full px-3">
        <div id="themeToggle" class="theme-toggle-container">
          <button type="button" class="theme-option active" data-theme="light" aria-label="Light mode"><i class="fa-solid fa-sun"></i></button>
          <button type="button" class="theme-option" data-theme="dark" aria-label="Dark mode"><i class="fa-regular fa-moon"></i></button>
          <div class="theme-indicator" aria-hidden="true"></div>
        </div>
      </div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="group sidebar-link w-full relative flex items-center rounded-xl text-sm text-red-600 hover:bg-red-100 transition-all duration-200">
          <div class="flex items-center justify-center w-8 h-8 rounded-lg flex-shrink-0 ml-2"><i class="fa-solid fa-right-from-bracket text-sm"></i></div>
          <span class="sidebar-text ml-2 opacity-0 w-0 font-semibold overflow-hidden transition-all duration-300 delay-150">Log out</span>
          <span class="sidebar-tooltip absolute left-full ml-2 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Log out</span>
        </button>
      </form>
    </div>
  </aside>

  <!-- ═══ MAIN ═══ -->
  {{-- FIX 1: Set margin-left inline via style to match sidebar width immediately on render --}}
  <main id="mainContent" class="pt-[100px] px-6 py-6 min-h-screen fade-in" style="margin-left: 220px;">
    <div class="max-w-7xl mt-4 mx-auto">

      <!-- PAGE TITLE ROW -->
      <div class="flex items-center justify-between mb-6">
        <div>
          <h1 class="text-xl font-bold text-[#660000]">Reports &amp; Analytics</h1>
          <p class="text-xs text-gray-500 mt-0.5">Overview of clinic data, trends, and inventory status</p>
        </div>
        <span class="text-xs text-gray-400 font-medium">
          <i class="fa-regular fa-clock mr-1"></i> Last updated: {{ now()->format('M d, Y h:i A') }}
        </span>
      </div>

      <!-- KPI STRIP -->
      <div class="grid grid-cols-4 gap-4 mb-7">

        {{-- Patients This Month — clickable, goes to patients page --}}
        <a href="{{ route('dentist.patients') }}" class="kpi-card">
          <div class="kpi-icon" style="background:#fff0f0;">
            <i class="fa-solid fa-users" style="color:#8B0000;"></i>
          </div>
          <div class="flex-1">
            <div class="kpi-value">248</div>
            <div class="kpi-label">Patients This Month</div>
            <div class="kpi-delta up"><i class="fa-solid fa-arrow-up text-[10px]"></i> 12% vs last month</div>
          </div>
          <i class="fa-solid fa-chevron-right kpi-arrow"></i>
        </a>

        {{-- Appointments Today — clickable, goes to appointments page --}}
        <a href="{{ route('dentist.appointments') }}" class="kpi-card">
          <div class="kpi-icon" style="background:#fffbeb;">
            <i class="fa-solid fa-calendar-check" style="color:#d97706;"></i>
          </div>
          <div class="flex-1">
            <div class="kpi-value">34</div>
            <div class="kpi-label">Appointments Today</div>
            <div class="kpi-delta up"><i class="fa-solid fa-arrow-up text-[10px]"></i> 5 more than yesterday</div>
          </div>
          <i class="fa-solid fa-chevron-right kpi-arrow"></i>
        </a>

        {{-- Dental Cases --}}
        <div class="kpi-card">
          <div class="kpi-icon" style="background:#f0fdf4;">
            <i class="fa-solid fa-tooth" style="color:#16a34a;"></i>
          </div>
          <div>
            <div class="kpi-value">91</div>
            <div class="kpi-label">Dental Cases (Dec)</div>
            <div class="kpi-delta down"><i class="fa-solid fa-arrow-down text-[10px]"></i> 3% vs Nov</div>
          </div>
        </div>

        {{-- Low Stock — clickable, goes to inventory page --}}
        <a href="{{ route('dentist.inventory') }}" class="kpi-card" style="border-color:#fee2e2;">
          <div class="kpi-icon" style="background:#fff0f0;">
            <i class="fa-solid fa-triangle-exclamation" style="color:#dc2626;"></i>
          </div>
          <div class="flex-1">
            <div class="kpi-value" style="color:#dc2626;">5</div>
            <div class="kpi-label">Low Stock Items</div>
            <div class="kpi-delta down"><i class="fa-solid fa-circle-exclamation text-[10px]"></i> Requires reorder</div>
          </div>
          <i class="fa-solid fa-chevron-right kpi-arrow"></i>
        </a>

      </div>

      <!-- CREATE REPORT BUTTON -->
      <div class="flex justify-center mb-7">
        <button onclick="document.getElementById('createReportModal').showModal()"
          class="btn-shimmer w-full max-w-4xl bg-gradient-to-r from-[#8B0000] via-[#b30000] to-[#FFD700]
                 text-white py-4 rounded-2xl flex items-center justify-center gap-4
                 text-base font-bold shadow-lg hover:opacity-90 transition-opacity">
          <i class="fa-solid fa-file-circle-plus text-xl"></i>
          <span>Create New Report</span>
          <span class="bg-white text-[#8B0000] w-8 h-8 rounded-full flex items-center justify-center text-xl font-bold leading-none">+</span>
        </button>
      </div>

      <!-- CHARTS + QUICK BUTTONS -->
      {{-- FIX 2: Use explicit pixel heights on chart containers, not flex-1 --}}
      <div class="grid grid-cols-12 gap-5 mb-5">

        <!-- GAD REPORT -->
        <div class="col-span-5 chart-card">
          <div class="chart-card-header">
            <span class="chart-title"><i class="fa-solid fa-chart-column mr-1.5 opacity-70"></i>GAD Report</span>
            <select class="period-select">
              <option>Dec 2025</option>
              <option>Nov 2025</option>
              <option>Oct 2025</option>
            </select>
          </div>
          {{-- FIX: Give the chart div an explicit height in px --}}
          <div style="height: 300px; width: 100%;"><canvas id="gadChart"></canvas></div>
        </div>

        <!-- WEEKLY DENTAL CASES -->
        <div class="col-span-5 chart-card">
          <div class="chart-card-header">
            <span class="chart-title"><i class="fa-solid fa-chart-line mr-1.5 opacity-70"></i>Weekly Dental Cases</span>
            <select class="period-select">
              <option>Dec 2025</option>
              <option>Nov 2025</option>
              <option>Oct 2025</option>
            </select>
          </div>
          {{-- FIX: Give the chart div an explicit height in px --}}
          <div style="height: 300px; width: 100%;"><canvas id="weeklyDentalCasesChart"></canvas></div>
        </div>

        <!-- QUICK BUTTONS -->
        <div class="col-span-2 flex flex-col gap-4" style="min-height: 360px;">
          <a href="{{ route('dentist.report.dental-services') }}" class="quick-btn">
            <div class="qb-icon"><i class="fa-solid fa-tooth"></i></div>
            <span>Dental Services</span>
          </a>
          <a href="{{ route('dentist.report.daily-treatment') }}" class="quick-btn">
            <div class="qb-icon"><i class="fa-solid fa-notes-medical"></i></div>
            <span style="line-height:1.3;">Daily Treatment<br>Record</span>
          </a>
        </div>

      </div>

      <!-- INVENTORY ANALYTICS -->
      <div class="chart-card mb-5" style="border: 1.5px solid #fde68a;">
        <div class="chart-card-header mb-4">
          <span class="chart-title text-base"><i class="fa-solid fa-boxes-stacked mr-1.5 opacity-70"></i>Inventory Analytics</span>
          <a href="{{ route('dentist.inventory') }}" class="text-xs font-semibold text-[#8B0000] hover:underline">
            View All <i class="fa-solid fa-arrow-right text-[10px]"></i>
          </a>
        </div>
        <div class="grid grid-cols-12 gap-6 items-start">

          <!-- PIE CHARTS -->
          <div class="col-span-7 grid grid-cols-2 gap-6">
            <div>
              <h3 class="text-center text-xs font-bold text-[#8B0000] mb-3 uppercase tracking-wider">Medicine Inventory</h3>
              {{-- FIX: Explicit height --}}
              <div style="height: 280px; width: 100%;"><canvas id="medicinePieChart"></canvas></div>
            </div>
            <div>
              <h3 class="text-center text-xs font-bold text-[#8B0000] mb-3 uppercase tracking-wider">Medical Supplies Inventory</h3>
              {{-- FIX: Explicit height --}}
              <div style="height: 280px; width: 100%;"><canvas id="suppliesPieChart"></canvas></div>
            </div>
          </div>

          <!-- LOW STOCK -->
          <div class="col-span-5">
            <div class="flex items-center gap-2 mb-3">
              <i class="fa-solid fa-triangle-exclamation text-red-500 text-sm"></i>
              <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Low Stock Alerts</span>
            </div>
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Medicine</p>
            <div class="stock-row">
              <div class="stock-name"><span>Amoxicillin 500mg</span><span class="text-red-500 font-bold text-[11px]">25 / 100</span></div>
              <div class="stock-bar-bg">
                <div class="stock-bar-fill bg-red-400" style="width:25%"></div>
              </div>
            </div>
            <div class="stock-row">
              <div class="stock-name"><span>Paracetamol 500mg</span><span class="text-red-500 font-bold text-[11px]">30 / 100</span></div>
              <div class="stock-bar-bg">
                <div class="stock-bar-fill bg-orange-400" style="width:30%"></div>
              </div>
            </div>
            <div class="stock-row">
              <div class="stock-name"><span>Chlorhexidine Mouthwash</span><span class="text-red-500 font-bold text-[11px]">16 / 60</span></div>
              <div class="stock-bar-bg">
                <div class="stock-bar-fill bg-red-400" style="width:27%"></div>
              </div>
            </div>
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mt-4 mb-2">Medical Supplies</p>
            <div class="stock-row">
              <div class="stock-name"><span>Disposable Dental Needles</span><span class="text-red-500 font-bold text-[11px]">34 / 120</span></div>
              <div class="stock-bar-bg">
                <div class="stock-bar-fill bg-red-400" style="width:28%"></div>
              </div>
            </div>
            <div class="stock-row">
              <div class="stock-name"><span>Disposable Mouth Mirrors</span><span class="text-red-500 font-bold text-[11px]">20 / 80</span></div>
              <div class="stock-bar-bg">
                <div class="stock-bar-fill bg-orange-400" style="width:25%"></div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- RECENT REPORTS TABLE -->
      <div class="chart-card mb-5">
        <div class="chart-card-header mb-3">
          <span class="chart-title text-base"><i class="fa-solid fa-clock-rotate-left mr-1.5 opacity-70"></i>Recent Reports</span>
          <button class="text-xs font-semibold text-[#8B0000] hover:underline">View All</button>
        </div>
        <div class="overflow-x-auto rounded-xl border border-gray-100">
          <table class="reports-table w-full border-collapse">
            <thead>
              <tr>
                <th class="text-left">Report Name</th>
                <th class="text-left">Type</th>
                <th class="text-left">Date Range</th>
                <th class="text-left">Generated By</th>
                <th class="text-left">Status</th>
                <th class="text-left">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="font-semibold">GAD Monthly Report</td>
                <td>GAD Report</td>
                <td>Dec 1–31, 2025</td>
                <td>Dr. Nelson Angeles</td>
                <td><span class="status-badge status-ready">Ready</span></td>
                <td>
                  <button class="text-[#8B0000] hover:text-red-700 text-xs font-semibold mr-3"><i class="fa-solid fa-download mr-1"></i>Download</button>
                  <button class="text-gray-400 hover:text-gray-600 text-xs font-semibold"><i class="fa-solid fa-eye mr-1"></i>View</button>
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Medicine Supply — Nov</td>
                <td>Medicine Supply</td>
                <td>Nov 1–30, 2025</td>
                <td>Dr. Nelson Angeles</td>
                <td><span class="status-badge status-ready">Ready</span></td>
                <td>
                  <button class="text-[#8B0000] hover:text-red-700 text-xs font-semibold mr-3"><i class="fa-solid fa-download mr-1"></i>Download</button>
                  <button class="text-gray-400 hover:text-gray-600 text-xs font-semibold"><i class="fa-solid fa-eye mr-1"></i>View</button>
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Daily Treatment Record</td>
                <td>Daily Treatment</td>
                <td>Dec 15, 2025</td>
                <td>Dr. Nelson Angeles</td>
                <td><span class="status-badge status-pending">Pending</span></td>
                <td>
                  <button class="text-gray-300 text-xs font-semibold mr-3 cursor-not-allowed"><i class="fa-solid fa-download mr-1"></i>Download</button>
                  <button class="text-gray-400 hover:text-gray-600 text-xs font-semibold"><i class="fa-solid fa-eye mr-1"></i>View</button>
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Dental Services — Q4</td>
                <td>Dental Services</td>
                <td>Oct 1 – Dec 31, 2025</td>
                <td>Dr. Nelson Angeles</td>
                <td><span class="status-badge status-ready">Ready</span></td>
                <td>
                  <button class="text-[#8B0000] hover:text-red-700 text-xs font-semibold mr-3"><i class="fa-solid fa-download mr-1"></i>Download</button>
                  <button class="text-gray-400 hover:text-gray-600 text-xs font-semibold"><i class="fa-solid fa-eye mr-1"></i>View</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </main>

  <!-- ── CREATE REPORT MODAL ── -->
  <dialog id="createReportModal" class="modal">
    {{-- max-h + flex column so the footer buttons are ALWAYS visible --}}
    <div class="modal-box max-w-xl p-0 rounded-2xl overflow-hidden bg-white shadow-2xl flex flex-col"
      style="max-height: min(90vh, 640px);">

      <!-- Sticky Header -->
      <div class="bg-gradient-to-r from-[#8B0000] to-[#660000] px-6 py-4 flex items-center justify-between flex-shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-file-circle-plus text-white text-base"></i>
          </div>
          <div>
            <h2 class="text-base font-bold text-white leading-tight">Create New Report</h2>
            <p class="text-white/65 text-[11px] mt-0.5">Fields marked <span class="text-yellow-300 font-bold">*</span> are required</p>
          </div>
        </div>
        <button type="button" onclick="closeCreateModal()"
          class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/35 flex items-center justify-center text-white transition-all flex-shrink-0">
          <i class="fa-solid fa-xmark text-sm"></i>
        </button>
      </div>

      <!-- Scrollable Body -->
      <div class="overflow-y-auto flex-1 px-6 py-5">
        <form id="reportForm" class="space-y-4" novalidate>

          <!-- Report Name -->
          <div>
            <div class="flex items-center justify-between mb-1">
              <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider">
                Report Name <span class="text-red-500">*</span>
              </label>
              <span id="reportNameCounter" class="text-[11px] font-semibold text-gray-400">0 / 100</span>
            </div>
            <input id="reportName" type="text" maxlength="100"
              placeholder="e.g. GAD Monthly Report — Dec 2025"
              class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm
                     focus:outline-none focus:border-[#8B0000] transition-colors placeholder-gray-300" />
            <p id="reportNameErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
              <i class="fa-solid fa-circle-exclamation"></i> Report name is required.
            </p>
          </div>

          <!-- Report Type -->
          <div>
            <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">
              Report Type <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <select id="reportType"
                class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm
                       focus:outline-none focus:border-[#8B0000] transition-colors appearance-none pr-10 text-gray-500">
                <option value="" disabled selected>Select a report type...</option>
                <option class="text-gray-800">GAD Report</option>
                <option class="text-gray-800">Medicine Supply Report</option>
                <option class="text-gray-800">Medical Supplies Report</option>
                <option class="text-gray-800">Daily Treatment Record</option>
                <option class="text-gray-800">Dental Services Report</option>
              </select>
              <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-[#8B0000] text-xs pointer-events-none"></i>
            </div>
            <p id="reportTypeErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
              <i class="fa-solid fa-circle-exclamation"></i> Please select a report type.
            </p>
          </div>

          <!-- Date Range -->
          <div>
            <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">
              Date Range <span class="text-red-500">*</span>
            </label>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <p class="text-[10px] text-gray-400 font-semibold uppercase mb-1">
                  From <span class="text-red-400">*</span>
                </p>
                <input id="dateFrom" type="date"
                  class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm
                         focus:outline-none focus:border-[#8B0000] transition-colors" />
              </div>
              <div>
                <p class="text-[10px] text-gray-400 font-semibold uppercase mb-1">
                  To <span class="text-gray-400 normal-case font-normal">(optional)</span>
                </p>
                <input id="dateTo" type="date"
                  class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm
                         focus:outline-none focus:border-[#8B0000] transition-colors" />
              </div>
            </div>
            <p class="text-[10px] text-gray-400 mt-1">
              <i class="fa-solid fa-circle-info mr-1"></i>Leave "To" empty to report on a single date.
            </p>
            <p id="dateFromErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
              <i class="fa-solid fa-circle-exclamation"></i> Start date is required.
            </p>
            <p id="dateFutureErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
              <i class="fa-solid fa-circle-exclamation"></i> Dates cannot be in the future.
            </p>
            <p id="dateRangeErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
              <i class="fa-solid fa-circle-exclamation"></i> End date must be on or after start date.
            </p>
          </div>

          <!-- Quantity -->
          <div>
            <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">
              Quantity <span class="text-red-500">*</span>
            </label>
            <input id="reportQty" type="number" min="1" max="100" step="1" placeholder="1 – 100"
              class="w-36 px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm
                     focus:outline-none focus:border-[#8B0000] transition-colors" />
            <span class="text-[11px] text-gray-400 ml-2">Whole numbers only (1–100)</span>
            <p id="reportQtyErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
              <i class="fa-solid fa-circle-exclamation"></i> <span id="reportQtyErrMsg">Quantity must be between 1 and 100.</span>
            </p>
          </div>

          <!-- Global error banner -->
          <div id="formErrorBanner"
            class="hidden items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-sm font-medium">
            <i class="fa-solid fa-triangle-exclamation text-red-400 flex-shrink-0"></i>
            Please complete all required fields before downloading.
          </div>

        </form>
      </div>

      <!-- Sticky Footer — always visible -->
      <div class="flex-shrink-0 border-t border-gray-100 px-6 py-4 flex justify-end gap-3 bg-white">
        <button type="button" onclick="closeCreateModal()"
          class="px-5 py-2 rounded-xl border-2 border-gray-200 text-gray-500 text-sm font-semibold
                 hover:bg-gray-50 hover:border-gray-300 transition-all">
          Cancel
        </button>
        <button type="button" id="downloadReportBtn"
          class="px-6 py-2 rounded-xl bg-[#8B0000] hover:bg-[#7a0000] text-white text-sm font-bold
                 flex items-center gap-2 shadow-md hover:shadow-lg transition-all">
          <i class="fa-solid fa-download"></i>
          Download Report
        </button>
      </div>

    </div>
    <form method="dialog" class="modal-backdrop"><button onclick="closeCreateModal()"></button></form>
  </dialog>

  <!-- ── DOWNLOAD COMPLETE MODAL ── -->
  <dialog id="downloadCompleteModal" class="modal">
    <div class="modal-box p-0 rounded-2xl overflow-hidden bg-white shadow-2xl max-w-sm">
      <div class="h-1.5 bg-gradient-to-r from-[#8B0000] to-[#FFD700] w-full"></div>
      <div class="px-8 py-10 text-center">
        <div class="w-16 h-16 bg-green-50 border-2 border-green-200 rounded-full flex items-center justify-center mx-auto mb-5">
          <i class="fa-solid fa-check text-green-500 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-[#8B0000] mb-2">Download Complete!</h3>
        <p class="text-gray-400 text-sm leading-relaxed mb-7">
          Your report has been successfully generated and downloaded.
        </p>
        <button onclick="closeDownloadModal()"
          class="px-8 py-2.5 rounded-xl bg-[#8B0000] hover:bg-[#7A0000] text-white font-bold text-sm
                 shadow-md hover:shadow-lg transition-all duration-300">
          Done
        </button>
      </div>
    </div>
  </dialog>

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
    // ── Theme & Sidebar (defined first so DOMContentLoaded can call them) ──
    const html = document.documentElement;

    function applyTheme(theme) {
      html.setAttribute("data-theme", theme);
      localStorage.setItem("theme", theme);
      document.querySelectorAll(".theme-option").forEach(o =>
        o.getAttribute("data-theme") === theme ? o.classList.add("active") : o.classList.remove("active")
      );
      const ind = document.querySelector(".theme-indicator");
      if (ind) theme === "dark" ? ind.classList.add("dark-mode") : ind.classList.remove("dark-mode");
    }

    let sidebarOpen = true;

    function applyLayout(w) {
      document.getElementById('sidebar').style.width = w;
      document.getElementById('mainContent').style.marginLeft = w;
    }

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const texts = document.querySelectorAll('.sidebar-text');
      const icon = document.getElementById('sidebarIcon');
      const toggleWrapper = document.getElementById('sidebarToggleWrapper');
      sidebarOpen = !sidebarOpen;
      if (sidebarOpen) {
        applyLayout('220px');
        sidebar.classList.replace('collapsed', 'expanded');
        texts.forEach(t => {
          t.classList.remove('opacity-0', 'w-0');
          t.classList.add('opacity-100');
        });
        toggleWrapper.classList.replace('justify-center', 'justify-end');
        icon.classList.replace('fa-bars', 'fa-xmark');
      } else {
        applyLayout('72px');
        sidebar.classList.replace('expanded', 'collapsed');
        texts.forEach(t => {
          t.classList.add('opacity-0', 'w-0');
          t.classList.remove('opacity-100');
        });
        toggleWrapper.classList.replace('justify-end', 'justify-center');
        icon.classList.replace('fa-xmark', 'fa-bars');
      }
      applyTheme(localStorage.getItem("theme") || "light");
    }

    // ── Modal helpers ──
    function closeCreateModal() {
      document.getElementById('createReportModal').close();
      document.getElementById('reportForm').reset();
      document.getElementById('reportNameCounter').textContent = '0 / 100';
      document.getElementById('reportNameCounter').classList.remove('text-red-500');
      document.getElementById('reportNameCounter').classList.add('text-gray-400');
      ['reportNameErr', 'reportTypeErr', 'dateFromErr', 'dateFutureErr', 'dateRangeErr', 'reportQtyErr', 'formErrorBanner']
      .forEach(id => {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
      });
      ['reportName', 'reportType', 'dateFrom', 'dateTo', 'reportQty']
      .forEach(id => {
        document.getElementById(id).classList.remove('border-red-400');
        document.getElementById(id).classList.add('border-gray-200');
      });
    }

    function closeDownloadModal() {
      document.getElementById('downloadCompleteModal').close();
    }

    // ── Single DOMContentLoaded ──
    document.addEventListener('DOMContentLoaded', function() {

      // 1. Apply layout first so chart containers have correct width
      applyLayout('220px');

      // 2. Apply saved theme
      applyTheme(localStorage.getItem("theme") || "light");
      document.querySelectorAll(".theme-option").forEach(o =>
        o.addEventListener("click", () => applyTheme(o.getAttribute("data-theme")))
      );

      // 3. Init charts after a short delay so browser paints layout first
      setTimeout(function() {

        // ── GAD REPORT — Grouped Bar Chart ──
        new Chart(document.getElementById('gadChart'), {
          type: 'bar',
          data: {
            labels: ['Student', 'Administrative', 'Faculty', 'Dependent'],
            datasets: [{
                label: 'Female',
                data: [25, 10, 15, 8],
                backgroundColor: '#FFC0CB',
                borderRadius: 4
              },
              {
                label: 'Male',
                data: [20, 15, 12, 10],
                backgroundColor: '#89CFF0',
                borderRadius: 4
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'top',
                labels: {
                  font: {
                    family: 'Inter',
                    size: 12
                  }
                }
              },
              tooltip: {
                callbacks: {
                  label: ctx => `${ctx.dataset.label}: ${ctx.parsed.x} cases`
                }
              }
            },
            indexAxis: 'y',
            scales: {
              x: {
                beginAtZero: true,
                grid: {
                  borderDash: [4, 4]
                },
                title: {
                  display: true,
                  text: 'Number of Cases',
                  font: {
                    family: 'Inter'
                  }
                }
              },
              y: {
                grid: {
                  display: false
                },
                ticks: {
                  font: {
                    family: 'Inter'
                  }
                }
              }
            }
          }
        });

        // ── WEEKLY DENTAL CASES — Line Chart ──
        new Chart(document.getElementById('weeklyDentalCasesChart'), {
          type: 'line',
          data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Dental Cleaning',
                data: [12, 15, 9, 14],
                borderColor: '#8B0000',
                backgroundColor: 'rgba(139,0,0,0.08)',
                tension: 0.4,
                pointRadius: 5,
                fill: true
              },
              {
                label: 'Tooth Extraction',
                data: [5, 7, 6, 8],
                borderColor: '#F59E0B',
                backgroundColor: 'rgba(245,158,11,0.08)',
                tension: 0.4,
                pointRadius: 5,
                fill: true
              },
              {
                label: 'Consultation',
                data: [8, 10, 11, 13],
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59,130,246,0.08)',
                tension: 0.4,
                pointRadius: 5,
                fill: true
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'top',
                labels: {
                  font: {
                    family: 'Inter',
                    size: 12
                  }
                }
              },
              tooltip: {
                callbacks: {
                  label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y} cases`
                }
              }
            },
            scales: {
              x: {
                grid: {
                  display: false
                },
                ticks: {
                  font: {
                    family: 'Inter'
                  }
                }
              },
              y: {
                beginAtZero: true,
                grid: {
                  borderDash: [4, 4]
                },
                ticks: {
                  precision: 0,
                  font: {
                    family: 'Inter'
                  }
                },
                title: {
                  display: true,
                  text: 'Dental Cases',
                  font: {
                    family: 'Inter'
                  }
                }
              }
            }
          }
        });

        // ── INVENTORY PIE CHARTS ──
        const inventory = [{
            category: "Supplies",
            name: "Disposable Dental Needles",
            qty: 42,
            used: 8
          },
          {
            category: "Medicine",
            name: "Amoxicillin 500mg",
            qty: 30,
            used: 5
          },
          {
            category: "Supplies",
            name: "Latex Examination Gloves",
            qty: 50,
            used: 12
          },
          {
            category: "Medicine",
            name: "Paracetamol 500mg",
            qty: 40,
            used: 10
          },
          {
            category: "Supplies",
            name: "Dental Cotton Rolls",
            qty: 60,
            used: 15
          },
          {
            category: "Supplies",
            name: "Disposable Mouth Mirrors",
            qty: 25,
            used: 5
          },
          {
            category: "Medicine",
            name: "Ibuprofen 400mg",
            qty: 35,
            used: 7
          },
          {
            category: "Supplies",
            name: "Cotton Swabs",
            qty: 80,
            used: 20
          },
          {
            category: "Medicine",
            name: "Chlorhexidine Mouthwash 0.12%",
            qty: 20,
            used: 4
          },
          {
            category: "Supplies",
            name: "Dental Floss Packs",
            qty: 50,
            used: 10
          }
        ];
        const medicineItems = inventory.filter(i => i.category === "Medicine");
        const suppliesItems = inventory.filter(i => i.category === "Supplies");

        const pieColors = ['#8B0000', '#b30000', '#cc3333', '#e06666', '#f4cccc', '#d9534f', '#c0392b', '#922b21', '#641e16', '#f1948a'];

        const makePie = (canvasId, items) => new Chart(document.getElementById(canvasId), {
          type: 'doughnut',
          data: {
            labels: items.map(i => i.name),
            datasets: [{
              data: items.map(i => i.qty - i.used),
              backgroundColor: pieColors.slice(0, items.length),
              borderWidth: 2,
              borderColor: '#fff'
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '50%',
            plugins: {
              legend: {
                position: 'bottom',
                labels: {
                  font: {
                    family: 'Inter',
                    size: 10
                  },
                  boxWidth: 12,
                  padding: 8
                }
              },
              tooltip: {
                callbacks: {
                  label: ctx => ` ${ctx.label}: ${ctx.parsed} remaining`
                }
              }
            }
          }
        });

        makePie('medicinePieChart', medicineItems);
        makePie('suppliesPieChart', suppliesItems);

      }, 150);

      // 4. Notifications
      const notifBtn = document.getElementById("notifBtn");
      const notifMenu = document.getElementById("notifMenu");
      let notifOpen = false;
      const openNotif = () => {
        notifOpen = true;
        notifMenu.classList.remove("notif-close");
        notifMenu.classList.add("notif-open");
      };
      const closeNotif = () => {
        notifOpen = false;
        notifMenu.classList.remove("notif-open");
        notifMenu.classList.add("notif-close");
      };
      notifBtn.addEventListener("click", e => {
        e.stopPropagation();
        notifOpen ? closeNotif() : openNotif();
      });
      notifMenu.addEventListener("click", e => e.stopPropagation());
      document.addEventListener("click", () => {
        if (notifOpen) closeNotif();
      });
      document.addEventListener("keydown", e => {
        if (e.key === "Escape" && notifOpen) closeNotif();
      });
      closeNotif();

      // 5. Submit validation
      const todayStr = new Date().toISOString().split('T')[0];
      document.getElementById('dateFrom').setAttribute('max', todayStr);
      document.getElementById('dateTo').setAttribute('max', todayStr);

      function setError(inputId, errId, show) {
        const input = document.getElementById(inputId);
        const err = document.getElementById(errId);
        if (!input || !err) return;
        if (show) {
          err.classList.remove('hidden');
          err.classList.add('flex');
          input.classList.add('border-red-400');
          input.classList.remove('border-gray-200');
        } else {
          err.classList.add('hidden');
          err.classList.remove('flex');
          input.classList.remove('border-red-400');
          input.classList.add('border-gray-200');
        }
      }

      function clearError(inputId, errId) {
        setError(inputId, errId, false);
      }

      document.getElementById('downloadReportBtn').addEventListener('click', function() {
        const name = document.getElementById('reportName').value.trim();
        const type = document.getElementById('reportType').value;
        const from = document.getElementById('dateFrom').value;
        const to = document.getElementById('dateTo').value;
        const qty = parseInt(document.getElementById('reportQty').value, 10);
        let valid = true;

        setError('reportName', 'reportNameErr', !name);
        if (!name) valid = false;

        setError('reportType', 'reportTypeErr', !type);
        if (!type) valid = false;

        // Reset all date errors
        ['dateFromErr', 'dateFutureErr', 'dateRangeErr'].forEach(id => {
          document.getElementById(id).classList.add('hidden');
          document.getElementById(id).classList.remove('flex');
        });
        ['dateFrom', 'dateTo'].forEach(id => {
          document.getElementById(id).classList.remove('border-red-400');
          document.getElementById(id).classList.add('border-gray-200');
        });

        if (!from) {
          document.getElementById('dateFromErr').classList.remove('hidden');
          document.getElementById('dateFromErr').classList.add('flex');
          document.getElementById('dateFrom').classList.add('border-red-400');
          document.getElementById('dateFrom').classList.remove('border-gray-200');
          valid = false;
        } else {
          const fromFuture = from > todayStr;
          const toFuture = to && to > todayStr;
          if (fromFuture || toFuture) {
            document.getElementById('dateFutureErr').classList.remove('hidden');
            document.getElementById('dateFutureErr').classList.add('flex');
            if (fromFuture) {
              document.getElementById('dateFrom').classList.add('border-red-400');
              document.getElementById('dateFrom').classList.remove('border-gray-200');
            }
            if (toFuture) {
              document.getElementById('dateTo').classList.add('border-red-400');
              document.getElementById('dateTo').classList.remove('border-gray-200');
            }
            valid = false;
          } else if (to && new Date(to) < new Date(from)) {
            document.getElementById('dateRangeErr').classList.remove('hidden');
            document.getElementById('dateRangeErr').classList.add('flex');
            document.getElementById('dateTo').classList.add('border-red-400');
            document.getElementById('dateTo').classList.remove('border-gray-200');
            valid = false;
          }
        }

        const qtyInvalid = isNaN(qty) || qty < 1 || qty > 100;
        const errMsg = document.getElementById('reportQtyErrMsg');
        errMsg.textContent = (isNaN(qty) || qty < 1) ? 'Quantity must be between 1 and 100.' : 'Quantity cannot exceed 100.';
        setError('reportQty', 'reportQtyErr', qtyInvalid);
        if (qtyInvalid) valid = false;

        const banner = document.getElementById('formErrorBanner');
        if (!valid) {
          banner.classList.remove('hidden');
          banner.classList.add('flex');
          const btn = document.getElementById('downloadReportBtn');
          btn.classList.add('animate-bounce');
          setTimeout(() => btn.classList.remove('animate-bounce'), 600);
        } else {
          banner.classList.add('hidden');
          banner.classList.remove('flex');
          document.getElementById('createReportModal').close();
          document.getElementById('downloadCompleteModal').showModal();
          document.getElementById('reportForm').reset();
          document.getElementById('reportNameCounter').textContent = '0 / 100';
          document.getElementById('reportNameCounter').classList.remove('text-red-500');
          document.getElementById('reportNameCounter').classList.add('text-gray-400');
          ['reportNameErr', 'reportTypeErr', 'dateFromErr', 'dateFutureErr', 'dateRangeErr', 'reportQtyErr']
          .forEach(id => {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
          });
        }
      });

      // 6. Real-time validation
      // Report name counter
      document.getElementById('reportName').addEventListener('input', function() {
        const len = this.value.length;
        const counter = document.getElementById('reportNameCounter');
        counter.textContent = `${len} / 100`;
        counter.classList.toggle('text-red-500', len >= 90);
        counter.classList.toggle('text-gray-400', len < 90);
        if (this.value.trim()) clearError('reportName', 'reportNameErr');
        document.getElementById('formErrorBanner').classList.add('hidden');
      });

      // Report type
      document.getElementById('reportType').addEventListener('change', function() {
        if (this.value) clearError('reportType', 'reportTypeErr');
        document.getElementById('formErrorBanner').classList.add('hidden');
      });

      // Date real-time check
      function checkDates() {
        const from = document.getElementById('dateFrom').value;
        const to = document.getElementById('dateTo').value;
        ['dateFromErr', 'dateFutureErr', 'dateRangeErr'].forEach(id => {
          document.getElementById(id).classList.add('hidden');
          document.getElementById(id).classList.remove('flex');
        });
        ['dateFrom', 'dateTo'].forEach(id => {
          document.getElementById(id).classList.remove('border-red-400');
          document.getElementById(id).classList.add('border-gray-200');
        });
        if (!from && !to) return;
        const fromFuture = from && from > todayStr;
        const toFuture = to && to > todayStr;
        if (fromFuture || toFuture) {
          document.getElementById('dateFutureErr').classList.remove('hidden');
          document.getElementById('dateFutureErr').classList.add('flex');
          if (fromFuture) {
            document.getElementById('dateFrom').classList.add('border-red-400');
            document.getElementById('dateFrom').classList.remove('border-gray-200');
          }
          if (toFuture) {
            document.getElementById('dateTo').classList.add('border-red-400');
            document.getElementById('dateTo').classList.remove('border-gray-200');
          }
          return;
        }
        if (from && to && new Date(to) < new Date(from)) {
          document.getElementById('dateRangeErr').classList.remove('hidden');
          document.getElementById('dateRangeErr').classList.add('flex');
          document.getElementById('dateTo').classList.add('border-red-400');
          document.getElementById('dateTo').classList.remove('border-gray-200');
        }
        document.getElementById('formErrorBanner').classList.add('hidden');
      }
      document.getElementById('dateFrom').addEventListener('change', checkDates);
      document.getElementById('dateTo').addEventListener('change', checkDates);

      // Quantity restrictions
      const qtyInput = document.getElementById('reportQty');
      qtyInput.addEventListener('keydown', function(e) {
        if (['-', '+', 'e', 'E', '.', ','].includes(e.key)) e.preventDefault();
      });
      qtyInput.addEventListener('input', function() {
        let val = this.value.replace(/[^0-9]/g, '');
        if (val !== '' && parseInt(val, 10) > 100) val = '100';
        this.value = val;
        const qty = parseInt(val, 10);
        if (!isNaN(qty) && qty >= 1 && qty <= 100) clearError('reportQty', 'reportQtyErr');
        document.getElementById('formErrorBanner').classList.add('hidden');
      });
      qtyInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const num = parseInt((e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, ''), 10);
        if (!isNaN(num)) this.value = Math.min(Math.max(num, 1), 100);
      });

    }); // end DOMContentLoaded
  </script>


</body>

</html>