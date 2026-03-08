<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard | PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <script>
    tailwind.config = { daisyui: { themes: false } }
  </script>

<style>
  body {
    font-family: 'Inter';
    overflow-x: hidden;
  }

  #sidebar {
    transition: width 300ms ease, transform 300ms ease, background-color 0.3s ease, color 0.3s ease;
    will-change: width, transform;
  }

  #mainContent {
    transition: margin-left 300ms ease, background-color 0.3s ease, color 0.3s ease;
  }

  .sidebar-link {
    display: flex;
    align-items: center;
    position: relative;
    width: 100%;
    border-radius: 12px;
    transition: background-color 0.2s ease, transform 0.2s ease, color 0.2s ease;
  }

  .sidebar-link:hover .sidebar-tooltip {
    opacity: 1 !important;
    transform: scale(1) !important;
  }

  .sidebar-text {
    white-space: nowrap;
    overflow: hidden;
    transition: opacity 0.3s ease, width 0.3s ease;
  }

  .section-label {
    font-size: 0.65rem;
    font-weight: 500;
    letter-spacing: 0.08em;
    color: #757575;
    text-transform: uppercase;
    margin-bottom: 0.25rem;
    transition: opacity 0.2s ease;
  }

  #sidebar.expanded .sidebar-link {
    justify-content: flex-start;
    padding-left: 0.25rem;
  }

  #sidebar.expanded .sidebar-link i {
    margin-right: 0.75rem;
  }

  #sidebar.expanded .sidebar-link:hover {
    transform: translateX(4px);
  }

  #sidebar.expanded .sidebar-tooltip {
    display: none;
  }

  #sidebar.expanded .section-label,
  #sidebar.expanded .sidebar-section-label {
    display: flex;
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

  #sidebar.collapsed .section-label,
  #sidebar.collapsed .sidebar-section-label {
    display: none;
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

  .sidebar-link.bg-\[\#8B0000\] {
    box-shadow: 0 0 12px rgba(139, 0, 0, 0.45);
  }

  /* Scrollable nav area */
  #sidebarNav {
    overflow-y: auto;
    overflow-x: hidden;
    flex: 1;
    scrollbar-width: thin;
    scrollbar-color: #d1d5db transparent;
  }

  #sidebarNav::-webkit-scrollbar {
    width: 4px;
  }

  #sidebarNav::-webkit-scrollbar-track {
    background: transparent;
  }

  #sidebarNav::-webkit-scrollbar-thumb {
    background-color: #d1d5db;
    border-radius: 9999px;
  }

  /* Hide scrollbar visually when collapsed */
  #sidebar.collapsed #sidebarNav {
    scrollbar-width: none;
  }

  #sidebar.collapsed #sidebarNav::-webkit-scrollbar {
    display: none;
  }

  /* Divider labels */
  .sidebar-section-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
  }

  .sidebar-section-label .label-text {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: #9ca3af;
    white-space: nowrap;
  }

  .notif-open {
    opacity: 1 !important;
    transform: scale(1) !important;
    pointer-events: auto !important;
  }

  .notif-close {
    opacity: 0 !important;
    transform: scale(0.95) !important;
    pointer-events: none !important;
  }

  body,
  #sidebar,
  main,
  .card,
  .modal-box {
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  /* THEME TOGGLE PILL */
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
    transition: all 0.3s ease;
  }

  #sidebar.collapsed .theme-toggle-container {
    flex-direction: column;
    width: 35px;
    height: 96px;
    border-radius: 24px;
    padding: 4px;
    margin: 0 auto;
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
    transition: color 0.2s ease;
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
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

  /* Optional dark mode support */
  [data-theme="dark"] body {
    background-color: #000D1A;
    color: #E5E7EB;
  }

  [data-theme="dark"] #sidebar {
    background-color: #000D1A !important;
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
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
  }
</style>
</head>

<body class="bg-[#f5f5f5] text-[#333333]">

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
        <div id="notifMenu"
          class="absolute right-0 mt-3 w-80 rounded-2xl bg-white shadow-xl border border-gray-100 z-50
                 opacity-0 scale-95 pointer-events-none transition-all duration-200 ease-out origin-top-right">
          <div class="p-4 border-b flex items-center justify-between">
            <span class="font-bold text-[#8B0000]">Notifications</span>
          </div>
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
  class="fixed left-0 top-[80px] h-[calc(100vh-80px)] bg-[#FAFAFA] drop-shadow-xl
         transition-all duration-300 flex flex-col z-40 collapsed"
  style="width: 72px;">

  <!-- TOGGLE -->
  <div id="sidebarToggleWrapper" class="flex items-center justify-center px-4 py-6 transition-all duration-300 flex-shrink-0">
    <button onclick="toggleSidebar()" id="sidebarToggleBtn"
      class="w-10 h-10 flex items-center justify-center rounded-full
             text-[#757575] hover:text-[#8B0000] hover:bg-[#F0F0F0]
             transition-all duration-300">
      <i id="sidebarIcon" class="fa-solid fa-bars text-lg"></i>
    </button>
  </div>

  <!-- SCROLLABLE NAV -->
  <div id="sidebarNav" class="flex-1 px-3 text-gray-600 text-sm">
    <nav class="space-y-2 pb-4">

      <!-- Clinic Management divider -->
      <div class="sidebar-section-label pt-1 pb-1">
        <div class="flex-1 h-px bg-gray-200"></div>
        <span class="label-text">Clinic Management</span>
        <div class="flex-1 h-px bg-gray-200"></div>
      </div>

      <a href="#" class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-2 transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] bg-[#8B0000] text-[#F4F4F4]">
        <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] opacity-100"></span>
        <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200">
          <i class="fa-solid fa-chart-line text-lg"></i>
        </span>
        <span class="sidebar-text ml-2 text-sm font-semibold opacity-0 w-0 whitespace-nowrap overflow-hidden transition-all duration-300">
          Dashboard
        </span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
          Dashboard
        </span>
      </a>

      <a href="#" class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]">
        <span class="w-8 h-8 rounded-lg flex items-center justify-center">
          <i class="fa-solid fa-users text-lg"></i>
        </span>
        <span class="sidebar-text ml-2 text-sm font-semibold opacity-0 w-0 whitespace-nowrap overflow-hidden transition-all duration-300">
          Patients
        </span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
          Patients
        </span>
      </a>

      <a href="#" class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]">
        <span class="w-8 h-8 rounded-lg flex items-center justify-center">
          <i class="fa-solid fa-calendar-check text-lg"></i>
        </span>
        <span class="sidebar-text ml-2 text-sm font-semibold opacity-0 w-0 whitespace-nowrap overflow-hidden transition-all duration-300">
          Appointments
        </span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
          Appointments
        </span>
      </a>

      <a href="#" class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]">
        <span class="w-8 h-8 rounded-lg flex items-center justify-center">
          <i class="fa-solid fa-school text-lg"></i>
        </span>
        <span class="sidebar-text ml-2 text-sm font-semibold opacity-0 w-0 whitespace-nowrap overflow-hidden transition-all duration-300">
          Academic Periods
        </span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
          Academic Periods
        </span>
      </a>

      <a href="#" class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]">
        <span class="w-8 h-8 rounded-lg flex items-center justify-center">
          <i class="fa-solid fa-file-circle-check text-lg"></i>
        </span>
        <span class="sidebar-text ml-2 text-sm font-semibold opacity-0 w-0 whitespace-nowrap overflow-hidden transition-all duration-300">
          Document Requests
        </span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
          Document Requests
        </span>
      </a>

      <a href="#" class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]">
        <span class="w-8 h-8 rounded-lg flex items-center justify-center">
          <i class="fa-solid fa-file-pen text-lg"></i>
        </span>
        <span class="sidebar-text ml-2 text-sm font-semibold opacity-0 w-0 whitespace-nowrap overflow-hidden transition-all duration-300">
          Document Template
        </span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
          Document Template
        </span>
      </a>

      <a href="#" class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]">
        <span class="w-8 h-8 rounded-lg flex items-center justify-center">
          <i class="fa-solid fa-file text-lg"></i>
        </span>
        <span class="sidebar-text ml-2 text-sm font-semibold opacity-0 w-0 whitespace-nowrap overflow-hidden transition-all duration-300">
          Reports
        </span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
          Reports
        </span>
      </a>

      <!-- System divider -->
      <div class="sidebar-section-label pt-3 pb-1">
        <div class="flex-1 h-px bg-gray-200"></div>
        <span class="label-text">System</span>
        <div class="flex-1 h-px bg-gray-200"></div>
      </div>

      <a href="#" class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]">
        <span class="w-8 h-8 rounded-lg flex items-center justify-center">
          <i class="fa-solid fa-database text-lg"></i>
        </span>
        <span class="sidebar-text ml-2 text-sm font-semibold opacity-0 w-0 whitespace-nowrap overflow-hidden transition-all duration-300">
          Data Backup
        </span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
          Data Backup
        </span>
      </a>

      <a href="#" class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]">
        <span class="w-8 h-8 rounded-lg flex items-center justify-center">
          <i class="fa-solid fa-clipboard-list text-lg"></i>
        </span>
        <span class="sidebar-text ml-2 text-sm font-semibold opacity-0 w-0 whitespace-nowrap overflow-hidden transition-all duration-300">
          System Logs
        </span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
          System Logs
        </span>
      </a>

      <a href="#" class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]">
        <span class="w-8 h-8 rounded-lg flex items-center justify-center">
          <i class="fa-solid fa-gear text-lg"></i>
        </span>
        <span class="sidebar-text ml-2 text-sm font-semibold opacity-0 w-0 whitespace-nowrap overflow-hidden transition-all duration-300">
          System Settings
        </span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
          System Settings
        </span>
      </a>

      <a href="#" class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]">
        <span class="w-8 h-8 rounded-lg flex items-center justify-center">
          <i class="fa-solid fa-user-shield text-lg"></i>
        </span>
        <span class="sidebar-text ml-2 text-sm font-semibold opacity-0 w-0 whitespace-nowrap overflow-hidden transition-all duration-300">
          Roles
        </span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
          Roles
        </span>
      </a>
     <a href="{{ route('admin.role_permissions') }}" class="sidebar-link hover:bg-[#8B0000] hover:text-[#F4F4F4]">
  <i class="fa-solid fa-user-shield text-lg"></i>
  <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Roles</span>
  <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
    Roles
  </span>
</a>
    </nav>
  </div>

  <!-- BOTTOM -->
  <div class="px-3 pb-5 space-y-4 flex-shrink-0 border-t border-gray-100 pt-3">
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
      <button class="group sidebar-link w-full relative flex items-center rounded-xl text-sm text-red-600 hover:bg-red-50 transition-all duration-200">
        <div class="flex items-center justify-center w-8 h-8 rounded-lg flex-shrink-0 transition-all duration-200 ml-2">
          <i class="fa-solid fa-right-from-bracket text-sm"></i>
        </div>
        <span class="sidebar-text ml-2 opacity-0 w-0 font-semibold overflow-hidden transition-all duration-300">
          Log out
        </span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">
          Log out
        </span>
      </button>
    </form>
  </div>
</aside>

  <!-- MAIN -->
  <main id="mainContent" class="pt-[100px] px-6 pb-10 w-full">
    <div class="max-w-7xl mx-auto">

      <!-- Date + Title -->
      <div class="mb-4">
        <div class="flex items-center gap-2 text-sm text-gray-500">
          <i class="fa-solid fa-sun text-yellow-400 text-xs"></i>
          <p id="currentDate"></p>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-[#8B0000] mt-1">Admin Dashboard</h1>
      </div>

      <!-- TOP BANNER -->
      <div class="bg-gradient-to-r from-[#6B0000] to-[#8B0000] rounded-xl text-white px-6 py-5 flex flex-col lg:flex-row gap-6 lg:items-center lg:justify-between shadow">
        <div class="flex-1 flex flex-col sm:flex-row gap-6">
          <div>
            <p class="text-[11px] tracking-widest opacity-80 uppercase">Current Academic Semester</p>
            <p class="text-2xl font-extrabold mt-1">2nd Semester</p>
          </div>
          <div class="h-auto w-px bg-white/20 hidden sm:block"></div>
          <div>
            <p class="text-[11px] tracking-widest opacity-80 uppercase">Current Academic Year</p>
            <p class="text-2xl font-extrabold mt-1">2025-2026</p>
          </div>
        </div>

        <div class="flex items-center gap-4">
          <div class="text-right">
            <p class="text-[11px] tracking-widest opacity-80 uppercase">Period Ends</p>
            <p class="font-bold">June 10, 2026</p>
          </div>
          <button class="bg-[#8B0000] border border-white/25 hover:bg-[#760000] px-5 py-2 rounded-lg font-semibold shadow">
            Manage Periods
          </button>
        </div>
      </div>

      <!-- STATS -->
      <div class="grid grid-cols-12 gap-5 mt-5">
        <div class="col-span-12 lg:col-span-4 bg-[#8B0000] rounded-xl text-white p-6 shadow">
          <p class="text-[11px] uppercase tracking-widest opacity-90">Total Patients</p>
          <p class="text-4xl font-extrabold mt-2">1234</p>
        </div>

        <div class="col-span-12 lg:col-span-4 bg-white rounded-xl p-6 shadow border">
          <p class="text-[11px] uppercase tracking-widest text-gray-400">Appointments: December 2025</p>
          <p class="text-4xl font-extrabold text-black mt-2">50</p>
        </div>

        <div class="col-span-12 lg:col-span-4 bg-white rounded-xl p-6 shadow border">
          <p class="text-[11px] uppercase tracking-widest text-gray-400">Documents Issued: December 2025</p>
          <p class="text-4xl font-extrabold text-black mt-2">74</p>
        </div>
      </div>

      <!-- MID SECTION -->
      <div class="grid grid-cols-12 gap-5 mt-5">

        <!-- System Logs Overview -->
        <div class="col-span-12 lg:col-span-8 bg-white rounded-xl shadow border overflow-hidden">
          <div class="px-5 py-3 border-b flex items-center justify-between">
            <p class="font-bold text-[#8B0000] text-sm">
              <i class="fa-solid fa-circle-info mr-2"></i> System Logs Overview
            </p>
            <a href="#" class="text-xs text-[#8B0000] font-semibold hover:underline flex items-center gap-1">
              View All <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
          </div>

          <div class="px-5 py-4">
            <div class="grid grid-cols-5 gap-3 text-center text-xs font-semibold">
              <div class="rounded-lg bg-purple-100 text-purple-700 py-2">
                <div class="text-lg font-extrabold">0</div>
                <div class="text-[10px] font-bold opacity-80">Total this month</div>
              </div>
              <div class="rounded-lg bg-blue-100 text-blue-700 py-2">
                <div class="text-lg font-extrabold">0</div>
                <div class="text-[10px] font-bold opacity-80">Information</div>
              </div>
              <div class="rounded-lg bg-yellow-100 text-yellow-700 py-2">
                <div class="text-lg font-extrabold">0</div>
                <div class="text-[10px] font-bold opacity-80">Warning(s)</div>
              </div>
              <div class="rounded-lg bg-green-100 text-green-700 py-2">
                <div class="text-lg font-extrabold">0</div>
                <div class="text-[10px] font-bold opacity-80">Backup(s)</div>
              </div>
              <div class="rounded-lg bg-red-100 text-red-700 py-2">
                <div class="text-lg font-extrabold">0</div>
                <div class="text-[10px] font-bold opacity-80">Error(s)</div>
              </div>
            </div>

            <div class="mt-4 overflow-x-auto">
              <table class="table w-full">
                <thead>
                  <tr class="text-[#8B0000] text-xs">
                    <th class="w-16">ID</th>
                    <th class="w-40">Date</th>
                    <th>Description</th>
                    <th class="w-40">User</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="text-sm">
                    <td class="text-gray-400">—</td>
                    <td class="text-gray-400">—</td>
                    <td class="text-gray-400">No logs to display</td>
                    <td class="text-gray-400">—</td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>

        <!-- Right column -->
        <div class="col-span-12 lg:col-span-4 flex flex-col gap-5">

          <!-- Quick Actions -->
          <div class="bg-white rounded-xl shadow border overflow-hidden">
            <div class="px-5 py-3 border-b">
              <p class="font-bold text-[#8B0000] text-sm">
                <i class="fa-solid fa-bolt mr-2"></i> Quick Actions
              </p>
            </div>

            <div class="p-4 space-y-3">
              <button class="w-full flex items-center gap-3 bg-[#fff1f1] hover:bg-[#ffe4e4] border border-[#f0c0c0] rounded-lg px-4 py-3 text-left">
                <span class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-[#8B0000]">
                  <i class="fa-solid fa-file-circle-plus"></i>
                </span>
                <div class="flex-1">
                  <div class="font-bold text-sm text-[#8B0000]">New Template</div>
                  <div class="text-[11px] text-gray-500">Create Document Format</div>
                </div>
              </button>

              <button class="w-full flex items-center gap-3 bg-[#fff1f1] hover:bg-[#ffe4e4] border border-[#f0c0c0] rounded-lg px-4 py-3 text-left">
                <span class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-[#8B0000]">
                  <i class="fa-solid fa-file-invoice"></i>
                </span>
                <div class="flex-1">
                  <div class="font-bold text-sm text-[#8B0000]">Generate Report</div>
                  <div class="text-[11px] text-gray-500">Create Report Documents</div>
                </div>
              </button>

              <button class="w-full flex items-center gap-3 bg-[#fff1f1] hover:bg-[#ffe4e4] border border-[#f0c0c0] rounded-lg px-4 py-3 text-left">
                <span class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-[#8B0000]">
                  <i class="fa-solid fa-chart-column"></i>
                </span>
                <div class="flex-1">
                  <div class="font-bold text-sm text-[#8B0000]">View Reports</div>
                  <div class="text-[11px] text-gray-500">All Reports</div>
                </div>
              </button>
            </div>
          </div>

          <!-- Data Backup -->
          <div class="bg-white rounded-xl shadow border overflow-hidden">
            <div class="px-5 py-3 border-b">
              <p class="font-bold text-[#8B0000] text-sm">
                <i class="fa-solid fa-database mr-2"></i> Data Backup
              </p>
            </div>

            <div class="p-4 space-y-3">
              <div class="rounded-lg bg-green-50 border border-green-200 p-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <span class="w-8 h-8 rounded-lg bg-green-100 text-green-700 flex items-center justify-center">
                    <i class="fa-solid fa-check"></i>
                  </span>
                  <div>
                    <div class="text-[11px] text-gray-500">Last Successful Backup:</div>
                    <div class="text-xs font-bold text-gray-800">December 25, 2025</div>
                  </div>
                </div>
                <div class="text-xs font-bold text-[#8B0000]">December 25, 2025</div>
              </div>

              <div class="text-xs text-gray-500">
                Next Scheduled Backup:<br/>
                <span class="font-semibold text-gray-700">March 30, 2026</span>
              </div>

              <button class="w-full bg-[#8B0000] hover:bg-[#760000] text-white font-bold py-3 rounded-lg shadow">
                Run Backup Now
              </button>
            </div>
          </div>

        </div>
      </div>

      <!-- BOTTOM SECTION -->
      <div class="grid grid-cols-12 gap-5 mt-5">
        <div class="col-span-12 lg:col-span-6 bg-white rounded-xl shadow border p-5">
          <div class="flex items-center justify-between">
            <p class="font-bold text-[#8B0000]">GAD Analytics</p>
            <a href="#" class="text-xs text-[#8B0000] font-semibold hover:underline flex items-center gap-1">
              View Reports <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
          </div>
          <div class="mt-4 h-40 rounded-lg border border-dashed flex items-center justify-center text-gray-400 text-sm">
            Chart Placeholder
          </div>
        </div>

        <div class="col-span-12 lg:col-span-6 bg-white rounded-xl shadow border p-5">
          <div class="flex items-center justify-between">
            <p class="font-bold text-[#8B0000]">Inventory</p>
            <a href="#" class="text-xs text-[#8B0000] font-semibold hover:underline flex items-center gap-1">
              View Reports <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
          </div>
          <div class="mt-4 h-40 rounded-lg border border-dashed flex items-center justify-center text-gray-400 text-sm">
            Inventory Placeholder
          </div>
        </div>
      </div>

    </div>
  </main>

  <footer class="footer sm:footer-horizontal mt-auto bg-[#660000] text-[#F4F4F4] p-10"></footer>

  <script>
  let sidebarOpen = false;

  function applyLayout(sidebarWidth) {
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('mainContent');
    sidebar.style.width = sidebarWidth;
    main.style.marginLeft = sidebarWidth;
    main.style.width = 'auto';
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
    const sidebar = document.getElementById('sidebar');

    sidebarOpen = false;
    sidebar.classList.add('collapsed');
    sidebar.classList.remove('expanded');
    applyLayout('72px');

    document.getElementById("currentDate").textContent =
      new Date().toLocaleDateString("en-US", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
      });
  });

  // Theme toggle
  document.addEventListener("DOMContentLoaded", () => {
    const html = document.documentElement;
    const themeToggleContainer = document.getElementById("themeToggle");
    const themeIndicator = themeToggleContainer?.querySelector(".theme-indicator");
    const themeOptions = themeToggleContainer?.querySelectorAll(".theme-option");

    function applyTheme(theme) {
      html.setAttribute("data-theme", theme);
      localStorage.setItem("theme", theme);

      themeOptions?.forEach(option => {
        if (option.getAttribute("data-theme") === theme) {
          option.classList.add("active");
        } else {
          option.classList.remove("active");
        }
      });

      if (theme === "dark") {
        themeIndicator?.classList.add("dark-mode");
      } else {
        themeIndicator?.classList.remove("dark-mode");
      }
    }

    window.applyTheme = applyTheme;
    applyTheme(localStorage.getItem("theme") || "light");

    themeOptions?.forEach(option => {
      option.addEventListener("click", () => {
        const theme = option.getAttribute("data-theme");
        applyTheme(theme);
      });
    });
  });

  // Notification dropdown
  document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("notifBtn");
    const menu = document.getElementById("notifMenu");
    if (!btn || !menu) return;

    let isOpen = false;

    function openMenu() {
      isOpen = true;
      menu.classList.remove("notif-close");
      menu.classList.add("notif-open");
    }

    function closeMenu() {
      isOpen = false;
      menu.classList.remove("notif-open");
      menu.classList.add("notif-close");
    }

    btn.addEventListener("click", (e) => {
      e.stopPropagation();
      isOpen ? closeMenu() : openMenu();
    });

    menu.addEventListener("click", (e) => e.stopPropagation());

    document.addEventListener("click", () => {
      if (isOpen) closeMenu();
    });

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && isOpen) closeMenu();
    });

    closeMenu();
  });
</script>

</body>
</html>