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

    @keyframes shimmer {
      0% {
        transform: translateX(-100%) skewX(-15deg)
      }

      100% {
        transform: translateX(300%) skewX(-15deg)
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
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .25), transparent);
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
      box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
      border: 1.5px solid #f0f0f0;
      transition: transform .2s, box-shadow .2s;
      text-decoration: none;
    }

    .kpi-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(139, 0, 0, .10);
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
      font-size: .72rem;
      font-weight: 500;
      color: #888;
      margin-top: 3px;
      letter-spacing: .03em;
      text-transform: uppercase;
    }

    .kpi-delta {
      font-size: .7rem;
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
      font-size: .75rem;
      align-self: center;
    }

    .kpi-card:hover .kpi-arrow {
      color: #8B0000;
    }

    /* Chart card */
    .chart-card {
      background: white;
      border-radius: 14px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
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
      font-size: .88rem;
      font-weight: 700;
      color: #8B0000;
    }

    .period-select {
      font-size: .72rem;
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
      font-size: .85rem;
      text-align: center;
      padding: 16px;
      transition: transform .2s, box-shadow .2s;
      box-shadow: 0 4px 16px rgba(139, 0, 0, .25);
      text-decoration: none;
    }

    .quick-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 28px rgba(139, 0, 0, .35);
    }

    .quick-btn .qb-icon {
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, .15);
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
      background: rgba(255, 215, 0, .12);
      border-radius: 50%;
    }

    /* Stock bars */
    .stock-row {
      padding: 10px 0;
      border-bottom: 1px solid #f5f5f5;
    }

    .stock-name {
      font-size: .78rem;
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
      transition: width .8s cubic-bezier(.4, 0, .2, 1);
    }

    /* Chart empty state */
    .chart-empty {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
      gap: 10px;
      color: #bbb;
    }

    .chart-empty i {
      font-size: 2rem;
    }

    .chart-empty p {
      font-size: .8rem;
      font-weight: 600;
    }

    .chart-empty span {
      font-size: .72rem;
      color: #ccc;
    }

    /* Chart loading spinner */
    .chart-loading {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
    }

    .chart-loading i {
      font-size: 1.5rem;
      color: #8B0000;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    /* Header */
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

    /* Sidebar */
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

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<body class="bg-[#f4f4f6] min-h-screen flex flex-col">

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

  <!-- MAIN -->
  <main id="mainContent" class="pt-[100px] px-6 py-6 min-h-screen fade-in" style="margin-left:220px;">
    <div class="max-w-7xl mt-4 mx-auto">

      <!-- PAGE TITLE -->
      <div class="flex items-center justify-between mb-6">
        <div>
          <h1 class="text-2xl font-bold text-[#660000]">Reports &amp; Analytics</h1>
          <p class="text-xs text-gray-500 mt-0.5">Overview of clinic data, trends, and inventory status</p>
        </div>
        <span class="text-xs text-gray-400 font-medium">
          <i class="fa-regular fa-clock mr-1"></i> Last updated: {{ now()->format('M d, Y h:i A') }}
        </span>
      </div>

      <!-- KPI STRIP -->
      <div class="grid grid-cols-4 gap-4 mb-7">

        <a href="{{ route('dentist.dentist.patients') }}" class="kpi-card">
          <div class="kpi-icon" style="background:#fff0f0;"><i class="fa-solid fa-users" style="color:#8B0000;"></i></div>
          <div class="flex-1">
            <div class="kpi-value">{{ $patientsThisMonth }}</div>
            <div class="kpi-label">Patients This Month</div>
            @if(!is_null($patientsDelta))
            <div class="kpi-delta {{ $patientsDelta >= 0 ? 'up' : 'down' }}">
              <i class="fa-solid fa-arrow-{{ $patientsDelta >= 0 ? 'up' : 'down' }} text-[10px]"></i> {{ abs($patientsDelta) }}% vs last month
            </div>
            @else
            <div class="kpi-delta" style="color:#888;">No data last month</div>
            @endif
          </div>
          <i class="fa-solid fa-chevron-right kpi-arrow"></i>
        </a>

        <a href="{{ route('dentist.dentist.appointments') }}" class="kpi-card">
          <div class="kpi-icon" style="background:#fffbeb;"><i class="fa-solid fa-calendar-check" style="color:#d97706;"></i></div>
          <div class="flex-1">
            <div class="kpi-value">{{ $appointmentsToday }}</div>
            <div class="kpi-label">Appointments Today</div>
            @if($appointmentsDelta > 0)
            <div class="kpi-delta up"><i class="fa-solid fa-arrow-up text-[10px]"></i> {{ $appointmentsDelta }} more than yesterday</div>
            @elseif($appointmentsDelta < 0)
              <div class="kpi-delta down"><i class="fa-solid fa-arrow-down text-[10px]"></i> {{ abs($appointmentsDelta) }} fewer than yesterday
          </div>
          @else
          <div class="kpi-delta" style="color:#888;">Same as yesterday</div>
          @endif
      </div>
      <i class="fa-solid fa-chevron-right kpi-arrow"></i>
      </a>

      <div class="kpi-card">
        <div class="kpi-icon" style="background:#f0fdf4;"><i class="fa-solid fa-tooth" style="color:#16a34a;"></i></div>
        <div>
          <div class="kpi-value">{{ $casesThisMonth }}</div>
          <div class="kpi-label">Dental Cases ({{ now()->format('M') }})</div>
          @if(!is_null($casesDelta))
          <div class="kpi-delta {{ $casesDelta >= 0 ? 'up' : 'down' }}">
            <i class="fa-solid fa-arrow-{{ $casesDelta >= 0 ? 'up' : 'down' }} text-[10px]"></i> {{ abs($casesDelta) }}% vs last month
          </div>
          @else
          <div class="kpi-delta" style="color:#888;">No data last month</div>
          @endif
        </div>
      </div>

      <a href="{{ route('dentist.dentist.inventory') }}" class="kpi-card" style="border-color:#fee2e2;">
        <div class="kpi-icon" style="background:#fff0f0;"><i class="fa-solid fa-triangle-exclamation" style="color:#dc2626;"></i></div>
        <div class="flex-1">
          <div class="kpi-value" style="color:#dc2626;">{{ $lowStockItems }}</div>
          <div class="kpi-label">Low Stock Items</div>
          @if($lowStockItems > 0)
          <div class="kpi-delta down"><i class="fa-solid fa-circle-exclamation text-[10px]"></i> Requires reorder</div>
          @else
          <div class="kpi-delta up"><i class="fa-solid fa-circle-check text-[10px]"></i> All stocked up</div>
          @endif
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
    <div class="grid grid-cols-12 gap-5 mb-5">

      <!-- GAD REPORT -->
      <div class="col-span-5 chart-card">
        <div class="chart-card-header">
          <span class="chart-title"><i class="fa-solid fa-chart-column mr-1.5 opacity-70"></i>GAD Report</span>
          <select class="period-select" id="gadPeriodSelect">
            @foreach($periodOptions as $opt)
            <option>{{ $opt }}</option>
            @endforeach
          </select>
        </div>
        {{-- wrapper toggles between canvas and empty state --}}
        <div id="gadChartWrap" style="height:300px; width:100%; position:relative;">
          <canvas id="gadChart"></canvas>
          <div id="gadEmptyState" class="chart-empty" style="display:none; position:absolute; inset:0;">
            <i class="fa-solid fa-chart-column" style="color:#e5e7eb;"></i>
            <p>No GAD records found</p>
            <span>for the selected period</span>
          </div>
          <div id="gadLoadingState" class="chart-loading" style="display:none; position:absolute; inset:0; background:white;">
            <i class="fa-solid fa-spinner"></i>
          </div>
        </div>
      </div>

      <!-- WEEKLY DENTAL CASES -->
      <div class="col-span-5 chart-card">
        <div class="chart-card-header">
          <span class="chart-title"><i class="fa-solid fa-chart-line mr-1.5 opacity-70"></i>Weekly Dental Cases</span>
          <select class="period-select" id="weeklyPeriodSelect">
            @foreach($periodOptions as $opt)
            <option>{{ $opt }}</option>
            @endforeach
          </select>
        </div>
        <div id="weeklyChartWrap" style="height:300px; width:100%; position:relative;">
          <canvas id="weeklyDentalCasesChart"></canvas>
          <div id="weeklyEmptyState" class="chart-empty" style="display:none; position:absolute; inset:0;">
            <i class="fa-solid fa-chart-line" style="color:#e5e7eb;"></i>
            <p>No appointment data found</p>
            <span>for the selected period</span>
          </div>
          <div id="weeklyLoadingState" class="chart-loading" style="display:none; position:absolute; inset:0; background:white;">
            <i class="fa-solid fa-spinner"></i>
          </div>
        </div>
      </div>

      <!-- QUICK BUTTONS -->
      <div class="col-span-2 flex flex-col gap-4" style="min-height:360px;">
        <a href="{{ route('dentist.dentist.report.dental-services') }}" class="quick-btn">
          <div class="qb-icon"><i class="fa-solid fa-tooth"></i></div>
          <span>Dental Services</span>
        </a>
        <a href="{{ route('dentist.dentist.report.daily-treatment') }}" class="quick-btn">
          <div class="qb-icon"><i class="fa-solid fa-notes-medical"></i></div>
          <span style="line-height:1.3;">Daily Treatment<br>Record</span>
        </a>
      </div>

    </div>

    <!-- INVENTORY ANALYTICS -->
    <div class="chart-card mb-5" style="border:1.5px solid #fde68a;">
      <div class="chart-card-header mb-4">
        <span class="chart-title text-base"><i class="fa-solid fa-boxes-stacked mr-1.5 opacity-70"></i>Inventory Analytics</span>
        <a href="{{ route('dentist.dentist.inventory') }}" class="text-xs font-semibold text-[#8B0000] hover:underline">
          View All <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
      </div>
      <div class="grid grid-cols-12 gap-6 items-start">

        <!-- PIE CHARTS -->
        <div class="col-span-7 grid grid-cols-2 gap-6">
          <div>
            <h3 class="text-center text-xs font-bold text-[#8B0000] mb-3 uppercase tracking-wider">Medicine Inventory</h3>
            <div style="height:280px; width:100%; position:relative;">
              @if($medicineItems->count() > 0)
              <canvas id="medicinePieChart"></canvas>
              @else
              <div class="chart-empty" style="position:absolute; inset:0;">
                <i class="fa-solid fa-capsules" style="color:#e5e7eb;"></i>
                <p>No medicine items</p>
                <span>Add inventory to see chart</span>
              </div>
              @endif
            </div>
          </div>
          <div>
            <h3 class="text-center text-xs font-bold text-[#8B0000] mb-3 uppercase tracking-wider">Medical Supplies Inventory</h3>
            <div style="height:280px; width:100%; position:relative;">
              @if($suppliesItems->count() > 0)
              <canvas id="suppliesPieChart"></canvas>
              @else
              <div class="chart-empty" style="position:absolute; inset:0;">
                <i class="fa-solid fa-box-open" style="color:#e5e7eb;"></i>
                <p>No supply items</p>
                <span>Add inventory to see chart</span>
              </div>
              @endif
            </div>
          </div>
        </div>

        <!-- LOW STOCK PANEL -->
        <div class="col-span-5">
          <div class="flex items-center gap-2 mb-3">
            <i class="fa-solid fa-triangle-exclamation text-red-500 text-sm"></i>
            <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Low Stock Alerts</span>
          </div>

          @if($lowStockMedicine->count() > 0)
          <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Medicine</p>
          @foreach($lowStockMedicine as $item)
          @php
          $remaining = $item->qty - $item->used;
          $pct = $item->qty > 0 ? round(($remaining / $item->qty) * 100) : 0;
          $barClass = $pct <= 15 ? 'bg-red-400' : 'bg-orange-400' ;
            @endphp
            <div class="stock-row">
            <div class="stock-name">
              <span>{{ $item->name }}</span>
              <span class="text-red-500 font-bold text-[11px]">{{ $remaining }} / {{ $item->qty }}</span>
            </div>
            <div class="stock-bar-bg">
              <div class="stock-bar-fill {{ $barClass }}" style="width:{{ $pct }}%"></div>
            </div>
        </div>
        @endforeach
        @endif

        @if($lowStockSupplies->count() > 0)
        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mt-4 mb-2">Medical Supplies</p>
        @foreach($lowStockSupplies as $item)
        @php
        $remaining = $item->qty - $item->used;
        $pct = $item->qty > 0 ? round(($remaining / $item->qty) * 100) : 0;
        $barClass = $pct <= 15 ? 'bg-red-400' : 'bg-orange-400' ;
          @endphp
          <div class="stock-row">
          <div class="stock-name">
            <span>{{ $item->name }}</span>
            <span class="text-red-500 font-bold text-[11px]">{{ $remaining }} / {{ $item->qty }}</span>
          </div>
          <div class="stock-bar-bg">
            <div class="stock-bar-fill {{ $barClass }}" style="width:{{ $pct }}%"></div>
          </div>
      </div>
      @endforeach
      @endif

      @if($lowStockMedicine->count() === 0 && $lowStockSupplies->count() === 0)
      <div class="flex flex-col items-center justify-center h-full py-8 text-center min-h-[200px]">
        <i class="fa-solid fa-circle-check text-green-400 text-3xl mb-2"></i>
        <p class="text-sm font-semibold text-green-600">No low stock items found.</p>
        <p class="text-xs text-gray-400 mt-1">No reorder needed at this time.</p>
      </div>
      @endif
    </div>

    </div>
    </div>

    </div>
  </main>

  <!-- CREATE REPORT MODAL -->
  <dialog id="createReportModal" class="modal">
    <div class="modal-box max-w-xl p-0 rounded-2xl overflow-hidden bg-white shadow-2xl flex flex-col" style="max-height:min(90vh,640px);">
      <div class="bg-gradient-to-r from-[#8B0000] to-[#660000] px-6 py-4 flex items-center justify-between flex-shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-file-circle-plus text-white text-base"></i></div>
          <div>
            <h2 class="text-base font-bold text-white leading-tight">Create New Report</h2>
            <p class="text-white/65 text-[11px] mt-0.5">Fields marked <span class="text-yellow-300 font-bold">*</span> are required</p>
          </div>
        </div>
        <button type="button" onclick="closeCreateModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/35 flex items-center justify-center text-white transition-all flex-shrink-0"><i class="fa-solid fa-xmark text-sm"></i></button>
      </div>
      <div class="overflow-y-auto flex-1 px-6 py-5">
        <form id="reportForm" class="space-y-4" novalidate>
          <div>
            <div class="flex items-center justify-between mb-1">
              <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider">Report Name <span class="text-red-500">*</span></label>
              <span id="reportNameCounter" class="text-[11px] font-semibold text-gray-400">0 / 100</span>
            </div>
            <input id="reportName" type="text" maxlength="100" placeholder="e.g. GAD Monthly Report — Dec 2025"
              class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors placeholder-gray-300" />
            <p id="reportNameErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> Report name is required.</p>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">Report Type <span class="text-red-500">*</span></label>
            <div class="relative">
              <select id="reportType" class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors appearance-none pr-10 text-gray-500">
                <option value="" disabled selected>Select a report type...</option>
                <option class="text-gray-800">GAD Report</option>
                <option class="text-gray-800">Medicine Supply Report</option>
                <option class="text-gray-800">Medical Supplies Report</option>
                <option class="text-gray-800">Daily Treatment Record</option>
                <option class="text-gray-800">Dental Services Report</option>
              </select>
              <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-[#8B0000] text-xs pointer-events-none"></i>
            </div>
            <p id="reportTypeErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> Please select a report type.</p>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">Date Range <span class="text-red-500">*</span></label>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <p class="text-[10px] text-gray-400 font-semibold uppercase mb-1">From <span class="text-red-400">*</span></p>
                <input id="dateFrom" type="date" class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors" />
              </div>
              <div>
                <p class="text-[10px] text-gray-400 font-semibold uppercase mb-1">To <span class="text-gray-400 normal-case font-normal">(optional)</span></p>
                <input id="dateTo" type="date" class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors" />
              </div>
            </div>
            <p class="text-[10px] text-gray-400 mt-1"><i class="fa-solid fa-circle-info mr-1"></i>Leave "To" empty to report on a single date.</p>
            <p id="dateFromErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> Start date is required.</p>
            <p id="dateFutureErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> Dates cannot be in the future.</p>
            <p id="dateRangeErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> End date must be on or after start date.</p>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">Quantity <span class="text-red-500">*</span></label>
            <input id="reportQty" type="number" min="1" max="100" step="1" placeholder="1 – 100"
              class="w-36 px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors" />
            <span class="text-[11px] text-gray-400 ml-2">Whole numbers only (1–100)</span>
            <p id="reportQtyErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
              <i class="fa-solid fa-circle-exclamation"></i> <span id="reportQtyErrMsg">Quantity must be between 1 and 100.</span>
            </p>
          </div>
          <div id="formErrorBanner" class="hidden items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-sm font-medium">
            <i class="fa-solid fa-triangle-exclamation text-red-400 flex-shrink-0"></i>
            Please complete all required fields before downloading.
          </div>
        </form>
      </div>
      <div class="flex-shrink-0 border-t border-gray-100 px-6 py-4 flex justify-end gap-3 bg-white">
        <button type="button" onclick="closeCreateModal()" class="px-5 py-2 rounded-xl border-2 border-gray-200 text-gray-500 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all">Cancel</button>
        <button type="button" id="downloadReportBtn" class="px-6 py-2 rounded-xl bg-[#8B0000] hover:bg-[#7a0000] text-white text-sm font-bold flex items-center gap-2 shadow-md hover:shadow-lg transition-all">
          <i class="fa-solid fa-download"></i> Download Report
        </button>
      </div>
    </div>
    <form method="dialog" class="modal-backdrop"><button onclick="closeCreateModal()"></button></form>
  </dialog>

  <!-- DOWNLOAD COMPLETE MODAL -->
  <dialog id="downloadCompleteModal" class="modal">
    <div class="modal-box p-0 rounded-2xl overflow-hidden bg-white shadow-2xl max-w-sm">
      <div class="h-1.5 bg-gradient-to-r from-[#8B0000] to-[#FFD700] w-full"></div>
      <div class="px-8 py-10 text-center">
        <div class="w-16 h-16 bg-green-50 border-2 border-green-200 rounded-full flex items-center justify-center mx-auto mb-5"><i class="fa-solid fa-check text-green-500 text-2xl"></i></div>
        <h3 class="text-xl font-bold text-[#8B0000] mb-2">Download Complete!</h3>
        <p class="text-gray-400 text-sm leading-relaxed mb-7">Your report has been successfully generated and downloaded.</p>
        <button onclick="closeDownloadModal()" class="px-8 py-2.5 rounded-xl bg-[#8B0000] hover:bg-[#7A0000] text-white font-bold text-sm shadow-md hover:shadow-lg transition-all duration-300">Done</button>
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

  {{-- PHP → JS data bridge --}}
  <script>
    const GAD_DATA = {
      labels: @json($gadLabels),
      female: @json($gadFemale),
      male: @json($gadMale)
    };
    const WEEKLY_DATA = {
      labels: @json($weekLabels),
      datasets: @json($weeklyDatasets)
    };
    const MEDICINE_ITEMS = @json($medicineItems);
    const SUPPLIES_ITEMS = @json($suppliesItems);
    const AJAX_GAD_URL = "{{ route('dentist.dentist.report.gad-data') }}";
    const AJAX_WEEKLY_URL = "{{ route('dentist.dentist.report.weekly-data') }}";
    const PIE_COLORS = ['#8B0000', '#b30000', '#cc3333', '#e06666', '#f4cccc', '#d9534f', '#c0392b', '#922b21', '#641e16', '#f1948a'];
  </script>

  <script>
    // ── Theme & Sidebar ──────────────────────────────────────────────────────
    const html = document.documentElement;

    function applyTheme(theme) {
      html.setAttribute('data-theme', theme);
      localStorage.setItem('theme', theme);
      document.querySelectorAll('.theme-option').forEach(o =>
        o.getAttribute('data-theme') === theme ? o.classList.add('active') : o.classList.remove('active'));
      const ind = document.querySelector('.theme-indicator');
      if (ind) theme === 'dark' ? ind.classList.add('dark-mode') : ind.classList.remove('dark-mode');
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
      applyTheme(localStorage.getItem('theme') || 'light');
    }

    // ── Modal helpers ────────────────────────────────────────────────────────
    function closeCreateModal() {
      document.getElementById('createReportModal').close();
      document.getElementById('reportForm').reset();
      document.getElementById('reportNameCounter').textContent = '0 / 100';
      document.getElementById('reportNameCounter').classList.replace('text-red-500', 'text-gray-400');
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

    // ── Chart instances (so we can destroy/recreate on period change) ────────
    let gadChartInstance = null;
    let weeklyChartInstance = null;

    // ── Chart helpers ────────────────────────────────────────────────────────
    function showGadEmpty() {
      document.getElementById('gadChart').style.display = 'none';
      document.getElementById('gadEmptyState').style.display = 'flex';
      document.getElementById('gadLoadingState').style.display = 'none';
    }

    function showGadLoading() {
      document.getElementById('gadChart').style.display = 'none';
      document.getElementById('gadEmptyState').style.display = 'none';
      document.getElementById('gadLoadingState').style.display = 'flex';
    }

    function showGadChart() {
      document.getElementById('gadChart').style.display = 'block';
      document.getElementById('gadEmptyState').style.display = 'none';
      document.getElementById('gadLoadingState').style.display = 'none';
    }

    function showWeeklyEmpty() {
      document.getElementById('weeklyDentalCasesChart').style.display = 'none';
      document.getElementById('weeklyEmptyState').style.display = 'flex';
      document.getElementById('weeklyLoadingState').style.display = 'none';
    }

    function showWeeklyLoading() {
      document.getElementById('weeklyDentalCasesChart').style.display = 'none';
      document.getElementById('weeklyEmptyState').style.display = 'none';
      document.getElementById('weeklyLoadingState').style.display = 'flex';
    }

    function showWeeklyChart() {
      document.getElementById('weeklyDentalCasesChart').style.display = 'block';
      document.getElementById('weeklyEmptyState').style.display = 'none';
      document.getElementById('weeklyLoadingState').style.display = 'none';
    }

    function buildGadChart(labels, female, male) {
      if (gadChartInstance) {
        gadChartInstance.destroy();
        gadChartInstance = null;
      }
      gadChartInstance = new Chart(document.getElementById('gadChart'), {
        type: 'bar',
        data: {
          labels,
          datasets: [{
              label: 'Female',
              data: female,
              backgroundColor: '#FFC0CB',
              borderRadius: 4
            },
            {
              label: 'Male',
              data: male,
              backgroundColor: '#89CFF0',
              borderRadius: 4
            },
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          indexAxis: 'y',
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
    }

    function buildWeeklyChart(labels, datasets) {
      if (weeklyChartInstance) {
        weeklyChartInstance.destroy();
        weeklyChartInstance = null;
      }
      weeklyChartInstance = new Chart(document.getElementById('weeklyDentalCasesChart'), {
        type: 'line',
        data: {
          labels,
          datasets
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
    }

    function makePieChart(canvasId, items) {
      if (!items || items.length === 0) return;
      new Chart(document.getElementById(canvasId), {
        type: 'doughnut',
        data: {
          labels: items.map(i => i.name),
          datasets: [{
            data: items.map(i => Math.max(0, i.qty - i.used)),
            backgroundColor: PIE_COLORS.slice(0, items.length),
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
    }

    // ── Period dropdown AJAX ─────────────────────────────────────────────────
    async function reloadGadChart(period) {
      showGadLoading();
      try {
        const res = await fetch(`${AJAX_GAD_URL}?period=${encodeURIComponent(period)}`);
        const data = await res.json();
        if (data.empty) {
          showGadEmpty();
          return;
        }
        showGadChart();
        buildGadChart(data.labels, data.female, data.male);
      } catch (e) {
        showGadEmpty();
      }
    }

    async function reloadWeeklyChart(period) {
      showWeeklyLoading();
      try {
        const res = await fetch(`${AJAX_WEEKLY_URL}?period=${encodeURIComponent(period)}`);
        const data = await res.json();
        if (data.empty || !data.datasets || data.datasets.length === 0) {
          showWeeklyEmpty();
          return;
        }
        showWeeklyChart();
        buildWeeklyChart(data.labels, data.datasets);
      } catch (e) {
        showWeeklyEmpty();
      }
    }

    // ── DOMContentLoaded ─────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', function() {
      applyLayout('220px');
      applyTheme(localStorage.getItem('theme') || 'light');
      document.querySelectorAll('.theme-option').forEach(o =>
        o.addEventListener('click', () => applyTheme(o.getAttribute('data-theme')))
      );

      setTimeout(function() {

        // Initial GAD chart
        const gadHasData = GAD_DATA.female.reduce((a, b) => a + b, 0) + GAD_DATA.male.reduce((a, b) => a + b, 0) > 0;
        if (gadHasData) {
          showGadChart();
          buildGadChart(GAD_DATA.labels, GAD_DATA.female, GAD_DATA.male);
        } else {
          showGadEmpty();
        }

        // Initial Weekly chart
        if (WEEKLY_DATA.datasets && WEEKLY_DATA.datasets.length > 0) {
          showWeeklyChart();
          buildWeeklyChart(WEEKLY_DATA.labels, WEEKLY_DATA.datasets);
        } else {
          showWeeklyEmpty();
        }

        // Inventory pies
        makePieChart('medicinePieChart', MEDICINE_ITEMS);
        makePieChart('suppliesPieChart', SUPPLIES_ITEMS);

      }, 150);

      // Period dropdowns
      document.getElementById('gadPeriodSelect').addEventListener('change', function() {
        reloadGadChart(this.value);
      });
      document.getElementById('weeklyPeriodSelect').addEventListener('change', function() {
        reloadWeeklyChart(this.value);
      });

      // Notif toggle
      document.getElementById('notifBtn').addEventListener('click', e => {
        e.stopPropagation();
        document.getElementById('notifMenu').classList.toggle('open');
      });
      document.addEventListener('click', () => document.getElementById('notifMenu').classList.remove('open'));

      // ── Modal validation ──
      const todayStr = new Date().toISOString().split('T')[0];
      document.getElementById('dateFrom').setAttribute('max', todayStr);
      document.getElementById('dateTo').setAttribute('max', todayStr);

      function setError(inputId, errId, show) {
        const input = document.getElementById(inputId),
          err = document.getElementById(errId);
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
      const clearError = (a, b) => setError(a, b, false);

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
          const fromFuture = from > todayStr,
            toFuture = to && to > todayStr;
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
        document.getElementById('reportQtyErrMsg').textContent = (isNaN(qty) || qty < 1) ? 'Quantity must be between 1 and 100.' : 'Quantity cannot exceed 100.';
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
          ['reportNameErr', 'reportTypeErr', 'dateFromErr', 'dateFutureErr', 'dateRangeErr', 'reportQtyErr'].forEach(id => {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
          });
        }
      });

      document.getElementById('reportName').addEventListener('input', function() {
        const len = this.value.length,
          counter = document.getElementById('reportNameCounter');
        counter.textContent = `${len} / 100`;
        counter.classList.toggle('text-red-500', len >= 90);
        counter.classList.toggle('text-gray-400', len < 90);
        if (this.value.trim()) clearError('reportName', 'reportNameErr');
        document.getElementById('formErrorBanner').classList.add('hidden');
      });
      document.getElementById('reportType').addEventListener('change', function() {
        if (this.value) clearError('reportType', 'reportTypeErr');
        document.getElementById('formErrorBanner').classList.add('hidden');
      });

      function checkDates() {
        const from = document.getElementById('dateFrom').value,
          to = document.getElementById('dateTo').value;
        ['dateFromErr', 'dateFutureErr', 'dateRangeErr'].forEach(id => {
          document.getElementById(id).classList.add('hidden');
          document.getElementById(id).classList.remove('flex');
        });
        ['dateFrom', 'dateTo'].forEach(id => {
          document.getElementById(id).classList.remove('border-red-400');
          document.getElementById(id).classList.add('border-gray-200');
        });
        if (!from && !to) return;
        const fromFuture = from && from > todayStr,
          toFuture = to && to > todayStr;
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

      const qtyInput = document.getElementById('reportQty');
      qtyInput.addEventListener('keydown', e => {
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
      qtyInput.addEventListener('paste', e => {
        e.preventDefault();
        const num = parseInt((e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, ''), 10);
        if (!isNaN(num)) qtyInput.value = Math.min(Math.max(num, 1), 100);
      });
    });
  </script>

</body>

</html>