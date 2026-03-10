<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dentist Dashboard | PUP Taguig Dental Clinic</title>
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
      font-family: 'Inter';
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(6px)
      }

      to {
        opacity: 1;
        transform: translateY(0)
      }
    }

    .fade-in {
      animation: fadeIn .6s ease-out forwards;
    }

    @keyframes wave {
      0% {
        transform: rotate(0deg)
      }

      20% {
        transform: rotate(14deg)
      }

      40% {
        transform: rotate(-8deg)
      }

      60% {
        transform: rotate(14deg)
      }

      80% {
        transform: rotate(-4deg)
      }

      100% {
        transform: rotate(0deg)
      }
    }

    .wave-hand {
      transform-origin: 70% 70%;
      animation: wave 2.5s ease-in-out infinite;
    }

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

    .sidebar-link {
      display: flex;
      align-items: center;
      transition: background-color .2s ease, transform .2s ease;
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

    body,
    #sidebar,
    main,
    .card,
    .modal-box {
      transition: background-color .3s ease, color .3s ease;
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

    .sidebar-link.bg-\[\#8B0000\] {
      box-shadow: 0 0 12px rgba(139, 0, 0, .45);
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

    [data-theme="dark"] .text-\[\#333333\] {
      color: #E5E7EB !important;
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
@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();

$dentalCasesThisMonth = $dentalCasesThisMonth ?? 0;
$totalApptsThisMonth = $totalApptsThisMonth ?? 0;

$dentalCasesDelta = $dentalCasesDelta ?? null;
$totalApptsDelta = $totalApptsDelta ?? null;

$gadLabels = $gadLabels ?? ['Student', 'Administrative', 'Faculty', 'Dependent'];
$gadFemale = $gadFemale ?? [0, 0, 0, 0];
$gadMale = $gadMale ?? [0, 0, 0, 0];

$appointmentCountsPerDay = $appointmentCountsPerDay ?? [];
$unavailableDates = $unavailableDates ?? [];
$philippineHolidays = $philippineHolidays ?? [];
$todayAppointments = $todayAppointments ?? collect();

$medicalSupplies = $medicalSupplies ?? collect();
$medicineSupplies = $medicineSupplies ?? collect();

$calendarAppointmentCounts = $appointmentCountsPerDay;

if (empty($calendarAppointmentCounts) && $todayAppointments->count() > 0) {
$calendarAppointmentCounts = [
\Carbon\Carbon::today()->format('Y-m-d') => $todayAppointments->count(),
];
}
@endphp

<body class="bg-white text-[#333333] font-normal">

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
          <div class="header-name">Dr. Nelson Angeles</div>
          <div class="header-role">Dentist</div>
        </div>
      </div>
    </div>
  </header>

  <!-- SIDEBAR -->
  <aside id="sidebar"
    class="fixed left-0 top-[72px] h-[calc(100vh-72px)] bg-white drop-shadow-xl transition-all duration-300 flex flex-col justify-between z-40 expanded"
    style="width:220px;">
    <div class="pt-4">
      <div id="sidebarToggleWrapper" class="flex items-center justify-end px-4 py-2">
        <button onclick="toggleSidebar()" id="sidebarToggleBtn"
          class="w-8 h-8 flex items-center justify-center rounded-full text-[#757575] hover:text-[#8B0000] hover:bg-[#F0F0F0] transition-all duration-300">
          <i id="sidebarIcon" class="fa-solid fa-xmark text-base"></i>
        </button>
      </div>
      <div class="section-label px-4 mb-6">Navigation</div>
      <nav class="space-y-2 px-3 text-gray-600">
        @foreach([
        ['route'=>'dentist.dentist.dashboard', 'icon'=>'fa-chart-line', 'label'=>'Dashboard'],
        ['route'=>'dentist.dentist.patients', 'icon'=>'fa-users', 'label'=>'Patients'],
        ['route'=>'dentist.dentist.appointments', 'icon'=>'fa-calendar-check', 'label'=>'Appointments'],
        ['route'=>'dentist.dentist.documentrequests', 'icon'=>'fa-file-circle-check', 'label'=>'Document Requests'],
        ['route'=>'dentist.dentist.inventory', 'icon'=>'fa-box', 'label'=>'Inventory'],
        ['route'=>'dentist.dentist.report', 'icon'=>'fa-file', 'label'=>'Reports'],
        ] as $nav)
        <a href="{{ route($nav['route']) }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8 transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs($nav['route']) ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] {{ request()->routeIs($nav['route']) ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center ml-1"><i class="fa-solid {{ $nav['icon'] }} text-lg"></i></span>
          <span class="sidebar-text ml-2 text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300">{{ $nav['label'] }}</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">{{ $nav['label'] }}</span>
        </a>
        @endforeach
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

  <!-- CONTENT -->
  <main id="mainContent" class="pt-[100px] px-6 py-6 fade-up min-h-screen">
    <div class="max-w-7xl mt-4 mx-auto fade-in">

      <!-- GREETING -->
      <div class="flex justify-between items-center mb-6">
        <div>
          <div class="flex items-center gap-2 mb-1"></div>
          <h1 class="text-4xl font-extrabold mb-8 flex items-center gap-3 fade-in">
            <span class="bg-gradient-to-r from-[#660000] to-[#FFD700] bg-clip-text text-transparent">
              Good Morning, <span id="dentistName"></span>
              <i class="fa-solid fa-hand text-[#FFD700] wave-hand"></i>
            </span>
          </h1>
        </div>
        <div class="flex items-center gap-3">
          <span class="text-sm font-medium text-[#757575]">The Dentist is</span>
          <button id="statusBtn" onclick="openStatusModal()" class="btn btn-success rounded-full px-6 font-bold shadow transition-all duration-300">
            <span id="statusLabel" class="flex items-center gap-2">
              <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span> IN
            </span>
          </button>
        </div>
      </div>

      <!-- KPI CARDS -->
      <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">

        {{-- KPI 1: Dental Cases (real data) --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#8B0000] to-[#660000] text-white p-5 shadow hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-xs font-semibold uppercase tracking-widest opacity-70 mb-1">Dental Cases</p>
              <p class="text-4xl font-extrabold tracking-tight leading-none">{{ $dentalCasesThisMonth }}</p>
              <p class="text-xs opacity-60 mt-1">{{ now()->format('F Y') }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center flex-shrink-0">
              <i class="fa-solid fa-tooth text-yellow-300 text-lg"></i>
            </div>
          </div>
          <div class="flex items-center gap-1 mt-3 text-xs font-semibold
            {{ is_null($dentalCasesDelta) ? 'text-white/50' : ($dentalCasesDelta >= 0 ? 'text-green-300' : 'text-red-300') }}">
            @if(is_null($dentalCasesDelta))
            <i class="fa-solid fa-minus text-xs"></i> No data last month
            @elseif($dentalCasesDelta >= 0)
            <i class="fa-solid fa-arrow-trend-up text-xs"></i> +{{ $dentalCasesDelta }}% vs last month
            @else
            <i class="fa-solid fa-arrow-trend-down text-xs"></i> {{ $dentalCasesDelta }}% vs last month
            @endif
          </div>
          <div class="absolute -bottom-4 -right-4 w-20 h-20 rounded-full bg-white/5"></div>
        </div>

        {{-- KPI 2: Total Appointments (real data) --}}
        <div class="relative overflow-hidden rounded-2xl bg-white border border-gray-100 text-[#333] p-5 shadow hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-xs font-semibold uppercase tracking-widest text-[#8B0000]/60 mb-1">Total Appts</p>
              <p class="text-4xl font-extrabold tracking-tight text-[#8B0000] leading-none">{{ $totalApptsThisMonth }}</p>
              <p class="text-xs text-gray-400 mt-1">{{ now()->format('F Y') }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
              <i class="fa-regular fa-calendar-check text-[#8B0000] text-lg"></i>
            </div>
          </div>
          <div class="flex items-center gap-1 mt-3 text-xs font-semibold
            {{ is_null($totalApptsDelta) ? 'text-gray-400' : ($totalApptsDelta >= 0 ? 'text-green-500' : 'text-red-500') }}">
            @if(is_null($totalApptsDelta))
            <i class="fa-solid fa-minus text-xs"></i> No data last month
            @elseif($totalApptsDelta >= 0)
            <i class="fa-solid fa-arrow-trend-up text-xs"></i> +{{ $totalApptsDelta }}% vs last month
            @else
            <i class="fa-solid fa-arrow-trend-down text-xs"></i> {{ $totalApptsDelta }}% vs last month
            @endif
          </div>
          <div class="absolute -bottom-4 -right-4 w-20 h-20 rounded-full bg-red-50/50"></div>
        </div>

        {{-- KPI 3: Today's Patients (real data — unchanged) --}}
        <div class="relative overflow-hidden rounded-2xl bg-white border border-gray-100 text-[#333] p-5 shadow hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-xs font-semibold uppercase tracking-widest text-[#8B0000]/60 mb-1">Today's Patients</p>
              <p class="text-4xl font-extrabold tracking-tight text-[#8B0000] leading-none">{{ $todayAppointments->count() }}</p>
              <p class="text-xs text-gray-400 mt-1">Scheduled today</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
              <i class="fa-solid fa-user-clock text-[#8B0000] text-lg"></i>
            </div>
          </div>
          <div class="flex items-center gap-1 mt-3 text-xs font-semibold {{ $todayAppointments->where('status','confirmed')->count() > 0 ? 'text-green-500' : 'text-gray-400' }}">
            <i class="fa-solid fa-circle-check text-xs"></i>
            {{ $todayAppointments->where('status','confirmed')->count() }} confirmed
            &nbsp;·&nbsp;
            <span class="text-yellow-500">{{ $todayAppointments->where('status','pending')->count() }} pending</span>
          </div>
          <div class="absolute -bottom-4 -right-4 w-20 h-20 rounded-full bg-red-50/50"></div>
        </div>

        {{-- KPI 4: Live Clock --}}
        <div class="relative overflow-hidden rounded-2xl p-5 shadow hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5"
          style="background: linear-gradient(135deg, #7b0c0c 0%, #4a0606 100%);">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-xs font-semibold uppercase tracking-widest opacity-60 mb-2 text-white flex items-center gap-1.5">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-red-400 animate-pulse flex-shrink-0"></span>
                Live Time
              </p>
              <p class="leading-none text-white">
                <span id="kpi-clock-hhmm" class="text-3xl font-extrabold tracking-tight" style="font-variant-numeric:tabular-nums;">12:00</span><span id="kpi-clock-ss" class="text-xl font-semibold opacity-50" style="font-variant-numeric:tabular-nums;">:00</span><span id="kpi-clock-ampm" class="text-xs font-bold opacity-60 ml-1 align-super">AM</span>
              </p>
              <p class="text-xs mt-2 text-white opacity-60 flex items-center gap-1.5">
                <i id="kpi-clock-dayicon" class="fa-solid fa-sun text-yellow-300 text-xs flex-shrink-0"></i>
                <span id="kpi-clock-date"></span>
              </p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
              <i id="kpi-clock-icon" class="fa-solid fa-sun text-yellow-300 text-lg"></i>
            </div>
          </div>
          <div class="absolute -bottom-4 -right-4 w-20 h-20 rounded-full bg-white/5"></div>
        </div>

        {{-- KPI 5: Clinic Status (unchanged) --}}
        <div class="relative overflow-hidden rounded-2xl bg-white border border-gray-100 text-[#333] p-5 shadow hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-xs font-semibold uppercase tracking-widest text-[#8B0000]/60 mb-1">Clinic Status</p>
              <p id="statusKpiLabel" class="text-2xl font-extrabold tracking-tight text-green-600 leading-none mt-1">Open</p>
              <p class="text-xs text-gray-400 mt-1">Dentist is currently IN</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
              <i id="statusKpiIcon" class="fa-solid fa-door-open text-green-600 text-lg"></i>
            </div>
          </div>
          <button onclick="openStatusModal()" class="mt-3 text-xs font-semibold text-[#8B0000] hover:underline flex items-center gap-1">
            Change status <i class="fa-solid fa-arrow-right text-[10px]"></i>
          </button>
          <div class="absolute -bottom-4 -right-4 w-20 h-20 rounded-full bg-green-50/50"></div>
        </div>

      </div>

      <!-- ROW 2: CALENDAR + SCHEDULE -->
      <div class="grid grid-cols-12 gap-6 mb-6 items-stretch">
        <div class="col-span-12 lg:col-span-7">
          <div id="dentistCalendarContainer" class="bg-white border shadow rounded-2xl p-6 w-full min-h-[420px] h-full">
            <div class="animate-pulse space-y-4">
              <div class="h-6 w-40 bg-gray-200 rounded mx-auto"></div>
              <div class="grid grid-cols-7 gap-2">
                @for($i = 0; $i < 35; $i++)
                  <div class="h-9 bg-gray-200 rounded-lg">
              </div>
              @endfor
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-12 lg:col-span-5">
        <div class="card bg-gradient-to-b from-[#8B0000] to-[#660000] text-white shadow h-full">
          <div class="card-body flex flex-col">
            <div class="flex items-center justify-between mb-3">
              <h2 class="text-base font-bold flex items-center gap-2">
                <i class="fa-regular fa-clock text-yellow-300"></i> Scheduled Today
              </h2>
              <span class="badge bg-yellow-400 text-[#660000] font-bold border-none px-3">
                {{ $todayAppointments->count() }} {{ \Illuminate\Support\Str::plural('patient', $todayAppointments->count()) }}
              </span>
            </div>
            <div class="space-y-2 flex-1 overflow-y-auto pr-1">
              @forelse($todayAppointments as $appointment)
              @php
              $name = $appointment->patient->name ?? 'Unknown Patient';
              $time = \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A');
              $service = $appointment->service_type === 'others'
              ? ($appointment->other_services ?? 'Other Service')
              : $appointment->service_type;
              $isConfirmed = $appointment->status === 'confirmed';
              @endphp
              <a href="{{ route('dentist.dentist.appointments') }}"
                class="flex items-center gap-3 bg-white/10 hover:bg-white/20 border border-white/20 p-3 rounded-xl w-full transition duration-200 hover:scale-[1.01]">
                <div class="rounded-full w-9 h-9 border-2 border-yellow-300 bg-white/20 flex items-center justify-center font-bold text-sm flex-shrink-0">
                  {{ strtoupper(substr($name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                  <p class="font-semibold text-sm truncate">{{ $name }}</p>
                  <p class="text-xs opacity-70 truncate flex items-center gap-1">
                    <i class="fa-solid fa-stethoscope text-yellow-300 flex-shrink-0 text-[10px]"></i>
                    {{ ucwords($service) }} · {{ $time }}
                  </p>
                </div>
                @if($isConfirmed)
                <span class="badge badge-sm bg-green-400 text-white border-none flex-shrink-0 text-[10px]">✓</span>
                @else
                <span class="badge badge-sm bg-yellow-400 text-[#660000] border-none flex-shrink-0 text-[10px]">!</span>
                @endif
              </a>
              @empty
              <div class="flex flex-col items-center justify-center py-10 opacity-60">
                <i class="fa-regular fa-calendar-xmark text-4xl mb-3 text-yellow-300"></i>
                <p class="text-sm font-semibold">No appointments today</p>
                <p class="text-xs opacity-70 mt-1">Enjoy your free day, Doctor!</p>
              </div>
              @endforelse
            </div>
            <a href="{{ route('dentist.dentist.appointments') }}"
              class="mt-4 flex items-center justify-center gap-2 text-xs font-semibold text-yellow-300 hover:text-yellow-200 transition border-t border-white/10 pt-3">
              View all appointments <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- ROW 3: GAD CHART + INVENTORY -->
    <div class="grid grid-cols-12 gap-6">

      <!-- GAD ANALYTICS — real data from DB -->
      <div class="col-span-12 lg:col-span-7 card bg-white shadow rounded-2xl">
        <div class="card-body p-5">
          <div class="flex items-center justify-between mb-4">
            <div>
              <h3 class="text-base font-bold text-[#8B0000]">
                <i class="fa-solid fa-chart-column mr-1.5 opacity-70"></i>GAD Analytics
              </h3>
              <p class="text-xs text-gray-400 mt-0.5">Patient cases by category and sex — {{ now()->format('F Y') }}</p>
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold">
              <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full inline-block" style="background:#FFC0CB"></span>Female</span>
              <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full inline-block" style="background:#89CFF0"></span>Male</span>
            </div>
          </div>
          <div style="height:300px; width:100%;">
            <canvas id="gadChart"></canvas>
          </div>
        </div>
      </div>

      <!-- INVENTORY COLUMN — real data from DB -->
      <div class="col-span-12 lg:col-span-5 flex flex-col gap-4">

        <!-- MEDICAL SUPPLIES -->
        <div class="relative rounded-2xl p-[2px]" style="background:linear-gradient(135deg,#660000,#FFD700);">
          <div class="card bg-white rounded-2xl">
            <div class="card-body p-4">
              <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-[#8B0000] flex items-center gap-2 text-sm">
                  <i class="fa-solid fa-boxes"></i> Medical Supplies
                </h3>
                <a href="{{ route('dentist.dentist.inventory') }}" class="text-xs text-[#8B0000] hover:underline font-semibold flex items-center gap-1">
                  View all <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
              </div>
              @if($medicalSupplies->count() > 0)
              <table class="table table-xs w-full">
                <thead>
                  <tr class="text-[#8B0000] text-[11px]">
                    <th>Item</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Used</th>
                    <th class="text-center">Balance</th>
                  </tr>
                </thead>
                <tbody class="text-xs text-[#333]">
                  @foreach($medicalSupplies as $item)
                  @php
                  $balance = $item->qty - $item->used;
                  $pct = $item->qty > 0 ? ($balance / $item->qty) * 100 : 100;
                  $isLow = $pct <= 30;
                    $badgeCls=$isLow
                    ? 'bg-red-100 text-red-700 animate-pulse'
                    : 'bg-green-100 text-green-700' ;
                    @endphp
                    <tr>
                    <td class="max-w-[140px] truncate">{{ $item->name }}</td>
                    <td class="text-center">{{ $item->qty }}</td>
                    <td class="text-center">{{ $item->used }}</td>
                    <td class="text-center">
                      <span class="badge badge-xs border-none font-semibold {{ $badgeCls }}">
                        {{ $balance }}{{ $isLow ? ' ⚠' : '' }}
                      </span>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
              @else
              <div class="flex flex-col items-center justify-center py-5 text-center opacity-50">
                <i class="fa-solid fa-box-open text-2xl mb-2 text-[#8B0000]"></i>
                <p class="text-xs font-semibold text-gray-500">No supply items yet</p>
              </div>
              @endif
            </div>
          </div>
        </div>

        <!-- MEDICINE SUPPLIES -->
        <div class="relative rounded-2xl p-[2px]" style="background:linear-gradient(135deg,#660000,#FFD700);">
          <div class="card bg-white rounded-2xl">
            <div class="card-body p-4">
              <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-[#8B0000] flex items-center gap-2 text-sm">
                  <i class="fa-solid fa-pills"></i> Medicine Supplies
                </h3>
                <a href="{{ route('dentist.dentist.inventory') }}" class="text-xs text-[#8B0000] hover:underline font-semibold flex items-center gap-1">
                  View all <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
              </div>
              @if($medicineSupplies->count() > 0)
              <table class="table table-xs w-full">
                <thead>
                  <tr class="text-[#8B0000] text-[11px]">
                    <th>Medicine</th>
                    <th class="text-center">Form</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Balance</th>
                  </tr>
                </thead>
                <tbody class="text-xs text-[#333]">
                  @foreach($medicineSupplies as $item)
                  @php
                  $balance = $item->qty - $item->used;
                  $pct = $item->qty > 0 ? ($balance / $item->qty) * 100 : 100;
                  $isLow = $pct <= 30;
                    $badgeCls=$isLow
                    ? 'bg-red-100 text-red-700 animate-pulse'
                    : 'bg-green-100 text-green-700' ;
                    @endphp
                    <tr>
                    <td class="max-w-[120px] truncate">{{ $item->name }}</td>
                    <td class="text-center">{{ $item->form ?? '—' }}</td>
                    <td class="text-center">{{ $item->qty }}</td>
                    <td class="text-center">
                      <span class="badge badge-xs border-none font-semibold {{ $badgeCls }}">
                        {{ $balance }}{{ $isLow ? ' ⚠' : '' }}
                      </span>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
              @else
              <div class="flex flex-col items-center justify-center py-5 text-center opacity-50">
                <i class="fa-solid fa-pills text-2xl mb-2 text-[#8B0000]"></i>
                <p class="text-xs font-semibold text-gray-500">No medicine items yet</p>
              </div>
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>

    </div>
  </main>

  <!-- STATUS MODAL -->
  <div id="statusModal"
    class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    <div id="statusModalBox" class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 p-0 overflow-hidden scale-90 transition-all duration-300">
      <div id="modalBanner" class="bg-gradient-to-r from-[#660000] to-[#8B0000] px-6 pt-6 pb-4 text-white text-center">
        <div id="modalIcon" class="w-16 h-16 rounded-full mx-auto mb-3 flex items-center justify-center text-2xl bg-white/20">
          <i class="fa-solid fa-door-closed"></i>
        </div>
        <h2 id="modalTitle" class="text-xl font-extrabold">Close the Clinic?</h2>
        <p id="modalSubtitle" class="text-sm opacity-80 mt-1">You are about to mark yourself as <strong>OUT</strong></p>
      </div>
      <div class="px-6 py-5">
        <p id="modalBody" class="text-sm text-[#555] text-center leading-relaxed">
          This will indicate that the clinic is <span class="font-semibold text-red-700">currently closed</span>. Patients will not be able to book new appointments while you are out.
        </p>
        <div class="flex gap-3 mt-5">
          <button onclick="closeStatusModal()" class="flex-1 btn btn-ghost border border-gray-200 rounded-xl font-semibold text-gray-600 hover:bg-gray-100">Cancel</button>
          <button id="confirmStatusBtn" onclick="confirmStatus()" class="flex-1 btn rounded-xl font-bold text-white bg-[#8B0000] hover:bg-[#660000] border-none shadow">Confirm</button>
        </div>
      </div>
    </div>
  </div>

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
    const dashboardData = {
      gadLabels: @json($gadLabels),
      gadFemale: @json($gadFemale),
      gadMale: @json($gadMale),
      apptCounts: @json($calendarAppointmentCounts),
      unavailableDates: @json($unavailableDates),
      holidays: @json($philippineHolidays),
    };

    const GAD_LABELS = dashboardData.gadLabels;
    const GAD_FEMALE = dashboardData.gadFemale;
    const GAD_MALE = dashboardData.gadMale;

    // ── Live Clock ────────────────────────────────────────────────────────────
    (function() {
      const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
      const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      function tickClock() {
        const now = new Date();
        let h = now.getHours(),
          m = now.getMinutes(),
          s = now.getSeconds();

        const ampm = h >= 12 ? 'PM' : 'AM';
        const isDaytime = h >= 6 && h < 18;

        const displayHour = h % 12 || 12;

        document.getElementById('kpi-clock-hhmm').textContent =
          String(displayHour).padStart(2, '0') + ':' + String(m).padStart(2, '0');

        document.getElementById('kpi-clock-ss').textContent =
          ':' + String(s).padStart(2, '0');

        document.getElementById('kpi-clock-ampm').textContent = ampm;

        document.getElementById('kpi-clock-date').textContent =
          days[now.getDay()] + ', ' + months[now.getMonth()] + ' ' + now.getDate();

        const dayicon = document.getElementById('kpi-clock-dayicon');
        const bigicon = document.getElementById('kpi-clock-icon');

        dayicon.className = isDaytime ?
          'fa-solid fa-sun text-xs flex-shrink-0' :
          'fa-solid fa-moon text-xs flex-shrink-0';

        dayicon.style.color = isDaytime ? '#fde68a' : '#bfdbfe';

        bigicon.className = isDaytime ?
          'fa-solid fa-sun text-lg' :
          'fa-solid fa-moon text-lg';

        bigicon.style.color = isDaytime ? '#fde68a' : '#bfdbfe';
      }
      tickClock();
      setInterval(tickClock, 1000);
    })();

    // ── Theme & Sidebar ──────────────────────────────────────────────────────
    const html = document.documentElement;

    function applyTheme(theme) {
      html.setAttribute("data-theme", theme);
      localStorage.setItem("theme", theme);
      document.querySelectorAll(".theme-option").forEach(o =>
        o.getAttribute("data-theme") === theme ? o.classList.add("active") : o.classList.remove("active"));
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
      const wrapper = document.getElementById('sidebarToggleWrapper');
      sidebarOpen = !sidebarOpen;
      if (sidebarOpen) {
        applyLayout('220px');
        sidebar.classList.replace('collapsed', 'expanded');
        texts.forEach(t => {
          t.classList.remove('opacity-0', 'w-0');
          t.classList.add('opacity-100');
        });
        wrapper.classList.replace('justify-center', 'justify-end');
        icon.classList.replace('fa-bars', 'fa-xmark');
      } else {
        applyLayout('72px');
        sidebar.classList.replace('expanded', 'collapsed');
        texts.forEach(t => {
          t.classList.add('opacity-0', 'w-0');
          t.classList.remove('opacity-100');
        });
        wrapper.classList.replace('justify-end', 'justify-center');
        icon.classList.replace('fa-xmark', 'fa-bars');
      }
      applyTheme(localStorage.getItem("theme") || "light");
    }

    // ── Greeting ─────────────────────────────────────────────────────────────
    document.getElementById("dentistName").textContent = "Dr. Nelson!";
    // document.getElementById("currentDate").textContent = new Date().toLocaleDateString("en-US", {
    //   weekday: "long",
    //   year: "numeric",
    //   month: "long",
    //   day: "numeric"
    // });
    (function() {
      const h = new Date().getHours();
      const greeting = h < 12 ? 'Good Morning,' : h < 18 ? 'Good Afternoon,' : 'Good Evening,';
      const greetEl = document.querySelector('.bg-gradient-to-r.from-\\[\\#660000\\].to-\\[\\#FFD700\\].bg-clip-text');
      if (greetEl) {
        const fn = greetEl.childNodes[0];
        if (fn && fn.nodeType === Node.TEXT_NODE) fn.textContent = greeting + ' ';
      }
    })();

    // ── Status Modal ──────────────────────────────────────────────────────────
    let dentistIsIn = true;

    function openStatusModal() {
      const modal = document.getElementById('statusModal');
      const box = document.getElementById('statusModalBox');
      const banner = document.getElementById('modalBanner');
      const icon = document.getElementById('modalIcon');
      const title = document.getElementById('modalTitle');
      const sub = document.getElementById('modalSubtitle');
      const body = document.getElementById('modalBody');
      if (dentistIsIn) {
        banner.className = 'bg-gradient-to-r from-[#660000] to-[#8B0000] px-6 pt-6 pb-4 text-white text-center';
        icon.innerHTML = '<i class="fa-solid fa-door-closed"></i>';
        title.textContent = 'Close the Clinic?';
        sub.innerHTML = 'You are about to mark yourself as <strong>OUT</strong>';
        body.innerHTML = 'This will indicate that the clinic is <span class="font-semibold text-red-700">currently closed</span>. Patients will not be able to book new appointments while you are out.';
      } else {
        banner.className = 'bg-gradient-to-r from-green-600 to-green-700 px-6 pt-6 pb-4 text-white text-center';
        icon.innerHTML = '<i class="fa-solid fa-door-open"></i>';
        title.textContent = 'Open the Clinic?';
        sub.innerHTML = 'You are about to mark yourself as <strong>IN</strong>';
        body.innerHTML = 'This will indicate that the clinic is <span class="font-semibold text-green-700">now open</span>. Patients will be able to see your availability and book appointments.';
      }
      modal.classList.remove('opacity-0', 'pointer-events-none');
      modal.classList.add('opacity-100');
      setTimeout(() => box.classList.replace('scale-90', 'scale-100'), 10);
    }

    function closeStatusModal() {
      const modal = document.getElementById('statusModal');
      const box = document.getElementById('statusModalBox');
      box.classList.replace('scale-100', 'scale-90');
      setTimeout(() => {
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100');
      }, 150);
    }

    function confirmStatus() {
      const btn = document.getElementById('statusBtn');
      const label = document.getElementById('statusLabel');
      const kpiLabel = document.getElementById('statusKpiLabel');
      const kpiIcon = document.getElementById('statusKpiIcon');
      dentistIsIn = !dentistIsIn;
      if (dentistIsIn) {
        btn.classList.replace('btn-error', 'btn-success');
        label.innerHTML = '<span class="w-2 h-2 bg-white rounded-full animate-pulse"></span> IN';
        if (kpiLabel) {
          kpiLabel.textContent = 'Open';
          kpiLabel.className = 'text-2xl font-extrabold tracking-tight text-green-600 leading-none mt-1';
        }
        if (kpiIcon) kpiIcon.className = 'fa-solid fa-door-open text-green-600 text-lg';
      } else {
        btn.classList.replace('btn-success', 'btn-error');
        label.innerHTML = '<span class="w-2 h-2 bg-white rounded-full"></span> OUT';
        if (kpiLabel) {
          kpiLabel.textContent = 'Closed';
          kpiLabel.className = 'text-2xl font-extrabold tracking-tight text-red-600 leading-none mt-1';
        }
        if (kpiIcon) kpiIcon.className = 'fa-solid fa-door-closed text-red-600 text-lg';
      }
      closeStatusModal();
    }
    document.getElementById('statusModal').addEventListener('click', function(e) {
      if (e.target === this) closeStatusModal();
    });

    // ── DOMContentLoaded ──────────────────────────────────────────────────────
    document.addEventListener("DOMContentLoaded", () => {
      applyLayout('220px');
      applyTheme(localStorage.getItem("theme") || "light");
      document.querySelectorAll(".theme-option").forEach(o =>
        o.addEventListener("click", () => applyTheme(o.getAttribute("data-theme"))));

      document.getElementById("notifBtn").addEventListener("click", e => {
        e.stopPropagation();
        document.getElementById("notifMenu").classList.toggle("open");
      });
      document.addEventListener("click", () => document.getElementById("notifMenu").classList.remove("open"));

      // ── GAD Chart (real DB data) ──
      setTimeout(() => {
        const ctx = document.getElementById('gadChart');
        if (!ctx) return;
        const hasData = [...GAD_FEMALE, ...GAD_MALE].some(v => v > 0);
        if (!hasData) {
          // Empty state drawn on canvas
          const c = ctx.getContext('2d');
          ctx.height = 300;
          c.font = '14px Inter';
          c.fillStyle = '#707070';
          c.textAlign = 'center';
          c.fillText('No treatment records this month', ctx.parentElement.offsetWidth / 2, 150);
          return;
        }
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: GAD_LABELS,
            datasets: [{
                label: 'Female',
                data: GAD_FEMALE,
                backgroundColor: 'rgba(255,192,203,0.85)',
                borderColor: '#FFB6C1',
                borderWidth: 1,
                borderRadius: 6
              },
              {
                label: 'Male',
                data: GAD_MALE,
                backgroundColor: 'rgba(137,207,240,0.85)',
                borderColor: '#7EC8E3',
                borderWidth: 1,
                borderRadius: 6
              },
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false
              },
              tooltip: {
                callbacks: {
                  label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y} cases`
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
                    family: 'Inter',
                    size: 12
                  },
                  color: '#555'
                },
                title: {
                  display: true,
                  text: 'Patient Category',
                  font: {
                    family: 'Inter',
                    size: 12
                  },
                  color: '#888'
                }
              },
              y: {
                beginAtZero: true,
                grid: {
                  borderDash: [4, 4],
                  color: '#f0f0f0'
                },
                ticks: {
                  precision: 0,
                  font: {
                    family: 'Inter',
                    size: 12
                  },
                  color: '#555'
                },
                title: {
                  display: true,
                  text: 'Number of Cases',
                  font: {
                    family: 'Inter',
                    size: 12
                  },
                  color: '#888'
                }
              }
            }
          }
        });
      }, 150);

      loadDentistCalendar();
    });

    // ── Calendar ──
    function loadDentistCalendar() {
      const MAX_PER_DAY = 5;

      const apptCounts = @json($calendarAppointmentCounts);
      const unavailableDates = @json($unavailableDates);
      const allHolidays = @json($philippineHolidays);

      const today = new Date();
      let currentYear = today.getFullYear(),
        currentMonth = today.getMonth();

      function pad(n) {
        return String(n).padStart(2, '0');
      }

      function isWeekend(y, m, d) {
        const dow = new Date(y, m, d).getDay();
        return dow === 0 || dow === 6;
      }

      function getHolidaysForMonth(year, month) {
        const out = {};
        Object.keys(allHolidays).forEach(ds => {
          const [y, m] = ds.split('-').map(Number);
          if (y === year && m === month + 1) out[ds] = allHolidays[ds];
        });
        return out;
      }

      function renderDentistCalendar(year, month) {
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const dayLabels = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        const firstDow = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();
        const holidays = getHolidaysForMonth(year, month);

        const headerHtml = dayLabels.map((l, i) =>
          `<div class="text-center text-[10px] font-bold ${(i === 0 || i === 6) ? 'text-[#8B0000]/40' : 'text-[#555]'} uppercase tracking-widest">${l}</div>`
        ).join('');

        let cells = '';

        for (let i = 0; i < firstDow; i++) {
          cells += `<div></div>`;
        }

        for (let d = 1; d <= totalDays; d++) {
          const dateStr = `${year}-${pad(month + 1)}-${pad(d)}`;
          const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
          const weekend = isWeekend(year, month, d);
          const holiday = holidays[dateStr] || null;
          const count = apptCounts[dateStr] || 0;
          const isFull = count >= MAX_PER_DAY;
          const isUnavail = unavailableDates.includes(dateStr) || weekend;
          const hasAppts = count > 0;

          let dotHtml = '';
          let badgeHtml = '';
          let tooltipTxt = '';

          if (holiday) {
            dotHtml = `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-blue-400"></span>`;
            tooltipTxt = `<i class="fa-solid fa-star mr-1 text-blue-300"></i>${holiday}`;
          }

          if (hasAppts && !isUnavail) {
            if (isFull) {
              dotHtml = `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-red-500"></span>`;
              tooltipTxt = `<i class="fa-solid fa-circle-xmark mr-1 text-red-400"></i>Fully booked — ${count} patients`;
            } else {
              dotHtml = `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full ${isToday ? 'bg-white' : 'bg-[#8B0000]'}"></span>`;
              tooltipTxt = `<i class="fa-solid fa-user-clock mr-1 text-yellow-300"></i>${count} patient${count > 1 ? 's' : ''} scheduled`;
            }

            const pillColor = isFull ?
              'bg-red-500 text-white' :
              (isToday ? 'bg-white text-[#8B0000]' : 'bg-[#8B0000] text-white');

            badgeHtml = `<span class="absolute -top-1.5 -right-1.5 text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center ${pillColor} shadow">${count}</span>`;
          }

          if (isUnavail && !holiday && !hasAppts) {
            tooltipTxt = weekend ?
              `<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Clinic closed` :
              `<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Not available`;
          }

          let bgClass = '';
          let textClass = 'text-[#333]';
          let ringClass = '';
          let cursor = 'cursor-default';

          if (isToday) {
            bgClass = 'bg-[#8B0000]';
            textClass = 'text-white font-extrabold';
            ringClass = 'ring-2 ring-[#8B0000]/30 ring-offset-1';
          } else if (holiday) {
            bgClass = 'bg-blue-50 hover:bg-blue-100';
            textClass = 'text-blue-700 font-semibold';
          } else if (isFull) {
            bgClass = 'bg-red-50 hover:bg-red-100';
            textClass = 'text-red-600 font-semibold';
            cursor = 'cursor-pointer';
          } else if (hasAppts) {
            bgClass = 'bg-[#FFF5F5] hover:bg-[#FFE8E8]';
            textClass = 'text-[#8B0000] font-semibold';
            cursor = 'cursor-pointer';
          } else if (isUnavail) {
            textClass = 'text-gray-300';
          } else {
            bgClass = 'hover:bg-gray-100';
          }

          const tooltipHtml = tooltipTxt ?
            `<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 z-50 bg-[#1a1a1a] text-white text-[11px] font-medium px-3 py-1.5 rounded-lg whitespace-nowrap shadow-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200">${tooltipTxt}<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-[#1a1a1a]"></div></div>` :
            '';

          cells += `
            <div class="relative group flex items-center justify-center">
              ${tooltipHtml}
              <div class="relative w-9 h-9 flex items-center justify-center text-sm rounded-full transition-all duration-150 ${bgClass} ${textClass} ${ringClass} ${cursor}">
                ${d}${dotHtml}${badgeHtml}
              </div>
            </div>`;
        }

        document.getElementById('dentistCalendarContainer').innerHTML = `
          <div class="h-full flex flex-col select-none">
            <div class="flex items-center justify-center gap-2 mb-3">
              <i class="fa-regular fa-calendar-check text-[#8B0000] text-xl"></i>
              <h2 class="text-lg font-extrabold text-[#333]">Clinic Appointment Schedule</h2>
            </div>
            <hr class="border-t border-gray-200 mb-2">
            <div class="flex items-center justify-between my-4">
              <button onclick="changeDentistMonth(-1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] text-[#8B0000] transition-colors">
                <i class="fa-solid fa-chevron-left text-xs"></i>
              </button>
              <div class="text-center">
                <p class="text-lg font-extrabold text-[#8B0000]">${monthNames[month]}</p>
                <p class="text-xs text-[#9CA3AF] font-semibold tracking-widest">${year}</p>
              </div>
              <button onclick="changeDentistMonth(1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] text-[#8B0000] transition-colors">
                <i class="fa-solid fa-chevron-right text-xs"></i>
              </button>
            </div>
            <div class="grid grid-cols-7 gap-2 mb-2">${headerHtml}</div>
            <div class="grid grid-cols-7 gap-2" style="row-gap:1.2rem;">${cells}</div>
            <div class="mt-5 pt-3 border-t border-gray-200 flex flex-wrap items-center justify-center gap-x-4 gap-y-1.5">
              <div class="flex items-center gap-1.5"><span class="w-4 h-4 rounded-full bg-[#8B0000] flex-shrink-0"></span><span class="text-[11px] text-[#555]">Today</span></div>
              <div class="flex items-center gap-1.5"><span class="w-4 h-4 rounded-full bg-[#FFF5F5] border border-[#8B0000] flex-shrink-0"></span><span class="text-[11px] text-[#555]">Has Patients</span></div>
              <div class="flex items-center gap-1.5"><span class="w-4 h-4 rounded-full bg-red-50 border border-red-400 flex-shrink-0"></span><span class="text-[11px] text-[#555]">Fully Booked</span></div>
              <div class="flex items-center gap-1.5"><span class="w-4 h-4 rounded-full bg-blue-50 border border-blue-400 flex-shrink-0"></span><span class="text-[11px] text-[#555]">Holiday</span></div>
              <div class="flex items-center gap-1.5"><span class="text-gray-300 text-base font-bold leading-none">–</span><span class="text-[11px] text-[#555]">Unavailable</span></div>
            </div>
          </div>`;
      }

      window.changeDentistMonth = function(dir) {
        currentMonth += dir;
        if (currentMonth > 11) {
          currentMonth = 0;
          currentYear++;
        }
        if (currentMonth < 0) {
          currentMonth = 11;
          currentYear--;
        }
        renderDentistCalendar(currentYear, currentMonth);
      };

      renderDentistCalendar(currentYear, currentMonth);
    }
  </script>
</body>

</html>