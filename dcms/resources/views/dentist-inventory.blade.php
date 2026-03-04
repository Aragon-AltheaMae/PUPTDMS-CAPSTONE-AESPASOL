<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Inventory | PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Inter'; }

    /* Fade-in animation */
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

    .sidebar-link {
      display: flex;
      align-items: center;
      transition: background-color 0.2s ease, transform 0.2s ease;
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
      font-size: 0.65rem;
      font-weight: 500;
      letter-spacing: 0.08em;
      color: #757575;
      text-transform: uppercase;
      margin-bottom: 0.25rem;
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

    #sidebar.collapsed .section-label {
      display: none;
    }

    #sidebar.expanded .section-label {
      display: block;
    }

    #sidebar.collapsed .sidebar-link {
      justify-content: center;
      padding-left: 0;
      padding-right: 0;
    }

    #sidebar.collapsed .sidebar-link span:first-of-type {
      margin: 0 auto;
    }

    #sidebar.collapsed .sidebar-link i {
      margin-right: 0 !important;
      width: 100%;
      text-align: center;
    }

    #sidebar.expanded .sidebar-link {
      justify-content: flex-start;
    }

    #sidebar.expanded .sidebar-link i {
      margin-right: 0.75rem;
    }

    #sidebar.expanded .sidebar-link span i {
      margin-right: 0 !important;
    }

    #sidebar.expanded .sidebar-link:hover {
      transform: translateX(4px);
    }

    #sidebar.collapsed .sidebar-tooltip {
      display: block;
    }

    #sidebar.expanded .sidebar-tooltip {
      display: none;
    }

    .sidebar-link.bg-\[\#8B0000\] {
      box-shadow: 0 0 12px rgba(139, 0, 0, 0.45);
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
      transition: all 0.3s ease;
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

    /* DARK MODE STYLES */
    [data-theme="dark"] body {
      background-color: #000D1A;
      color: #E5E7EB;
    }
    [data-theme="dark"] #sidebar { background-color: #1F2933; }
    [data-theme="dark"] .bg-white { background-color: #1F2937 !important; }
    [data-theme="dark"] .text-\[\#333333\] { color: #E5E7EB !important; }

    [data-theme="dark"] #sidebar {
      background-color: #000D1A;
    }

    [data-theme="dark"] .bg-white {
      background-color: #000D1A !important;
    }
    .filter-radio::after{
      content:"";
      width: 11px;
      height: 11px;
      border-radius: 9999px;
      background: #8B1A1A;
      display: none;
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

<body class="bg-[#F4F4F4] min-h-screen flex flex-col">

  <!-- HEADER (TOP BAR) -->
  <div class="fixed top-0 left-0 right-0 z-50
            bg-gradient-to-r from-[#660000] to-[#8B0000]
            text-[#F4F4F4] px-6 py-4
            flex items-center justify-between">

    <div class="flex items-center gap-3">
      <div class="w-12 rounded-full ml-5">
        <img src="{{ asset('images/PUP.png') }}" alt="PUP Logo" />
      </div>
      <div class="w-12 rounded-full">
        <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUPT DMS Logo" />
      </div>
      <span class="font-bold text-lg">PUP TAGUIG DENTAL CLINIC</span>
    </div>
    <div class="w-12 rounded-full">
      <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" alt="PUPT DMS Logo" />
    </div>
    <span class="font-bold text-lg">PUP TAGUIG DENTAL CLINIC</span>
  </div>

    <div class="flex items-center gap-8">
      @php
      // Pass $notifications from controller, or leave it empty for now
      // Expected format: [['title'=>'...', 'message'=>'...', 'time'=>'...', 'url'=>'...'], ...]
      $notifications = collect($notifications ?? []);
      $notifCount = $notifications->count();
      @endphp

      <div id="notifDropdown" class="relative">

        <button id="notifBtn" type="button"
          class="btn btn-ghost btn-circle indicator text-[#F4F4F4]">

          @if($notifCount > 0)
          <span class="indicator-item badge badge-secondary text-s text-[#F4F4F4] bg-[#660000] border-none">
            {{ $notifCount }}
          </span>
          @endif

          <i class="fa-regular fa-bell text-lg"></i>
        </button>

        <div id="notifMenu"
          class="absolute right-0 mt-3 w-80 rounded-2xl bg-white shadow-xl border border-gray-100 z-50
         opacity-0 scale-95 pointer-events-none
         transition-all duration-200 ease-out origin-top-right">

          <div class="p-4 border-b flex items-center justify-between">
            <span class="font-bold text-[#8B0000]">Notifications</span>
          </div>

          <div class="max-h-80 overflow-y-auto">
            @forelse($notifications as $n)
            <a href="{{ $n['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50">
              <div class="text-sm font-semibold text-gray-900">
                {{ $n['title'] ?? 'Notification' }}
              </div>
              @if(!empty($n['message']))
              <div class="text-xs text-[#ADADAD] mt-0.5">
                {{ $n['message'] }}
              </div>
              @endif
              @if(!empty($n['time']))
              <div class="text-[11px] text-gray-400 mt-1">
                {{ $n['time'] }}
              </div>
              @endif
            </a>
            @empty
            <div class="px-4 py-10 text-center justify-items-center">
              <img src="{{ asset('images/no-notifications.png') }}" alt="No Notification">
              <div class="text-sm font-semibold text-gray-800">No notifications</div>
              <div class="text-xs text-[#757575] mt-1">You’re all caught up.</div>
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

    <!-- Scrollable content -->
    <div class="flex-1 overflow-y-auto">

      <!-- Sort -->
      <div class="px-7 py-7 border-b">
        <div class="text-[15px] text-[#555] mb-5">Sort</div>

        <div class="flex flex-col gap-4">
          <label class="flex items-center gap-3 cursor-pointer select-none text-[15px] text-[#333]">
            <input class="filter-input hidden" type="radio" name="fp_sort" value="az">
            <span class="filter-radio"></span>
            A-Z
          </label>

          <label class="flex items-center gap-3 cursor-pointer select-none text-[15px] text-[#333]">
            <input class="filter-input hidden" type="radio" name="fp_sort" value="za">
            <span class="filter-radio"></span>
            Z-A
          </label>
        </div>
      </div>

      <!-- Date Received -->
      <div class="px-7 py-7 border-b">
        <div class="text-[15px] text-[#555] mb-5">Date Received</div>

        <div class="flex items-start gap-6 flex-wrap">
          <div class="flex flex-col gap-2">
            <span class="text-[15px] text-[#333]">From:</span>
            <input id="fp_dateFrom" type="date" class="filter-date">
          </div>

          <div class="flex flex-col gap-2">
            <span class="text-[15px] text-[#333]">To:</span>
            <input id="fp_dateTo" type="date" class="filter-date">
          </div>

          <div class="flex flex-col gap-4 pt-9">
            <label class="flex items-center gap-3 cursor-pointer select-none text-[15px] text-[#333]">
              <input class="filter-input hidden" type="radio" name="fp_dateOrder" value="asc">
              <span class="filter-radio"></span>
              Ascending
            </label>

            <label class="flex items-center gap-3 cursor-pointer select-none text-[15px] text-[#333]">
              <input class="filter-input hidden" type="radio" name="fp_dateOrder" value="desc">
              <span class="filter-radio"></span>
              Descending
            </label>
          </div>
        </div>
      </div>

      <!-- Item Type -->
      <div class="px-7 py-7 border-b">
        <div class="text-[15px] text-[#555] mb-5">Item Type</div>

        <div class="flex gap-14 flex-wrap">
          <label class="flex items-center gap-3 cursor-pointer select-none text-[15px] text-[#333]">
            <input class="filter-input hidden" type="radio" name="fp_itemType" value="medicine">
            <span class="filter-radio"></span>
            Medicine
          </label>

          <label class="flex items-center gap-3 cursor-pointer select-none text-[15px] text-[#333]">
            <input class="filter-input hidden" type="radio" name="fp_itemType" value="supplies">
            <span class="filter-radio"></span>
            Dental Supplies
          </label>
        </div>
      </div>

      <!-- Stock Level -->
      <div class="px-7 py-7 border-b">
        <div class="text-[15px] text-[#555] mb-5">Stock Level</div>

        <div class="flex gap-14 flex-wrap">
          <label class="flex items-center gap-3 cursor-pointer select-none text-[15px] text-[#333]">
            <input class="filter-input hidden" type="radio" name="fp_stock" value="low-high">
            <span class="filter-radio"></span>
            Lowest to Highest
          </label>

          <label class="flex items-center gap-3 cursor-pointer select-none text-[15px] text-[#333]">
            <input class="filter-input hidden" type="radio" name="fp_stock" value="high-low">
            <span class="filter-radio"></span>
            Highest to Lowest
          </label>
        </div>
      </div>

    </div> <!-- ✅ CLOSE SCROLLABLE CONTENT HERE -->

    <!-- Footer (STICKY / NOT SCROLLING) -->
    <div class="px-7 py-4 border-t flex items-center justify-between bg-white shrink-0">
      <button type="button" onclick="clearFilterPanel()"
        class="bg-transparent border-none font-semibold text-[16px]"
        style="color:#8B1A1A;">
        Clear
      </button>

      <button type="button" onclick="saveFilterPanel()"
        class="btn border-none"
        style="background:#8B1A1A; color:white; border-radius:8px; padding:12px 52px; font-weight:600;">
        Save
      </button>
    </div>

  </div>
</dialog>

<!-- ADD MODAL -->
<dialog id="addModal" class="modal">
  <div class="modal-box max-w-xl bg-white rounded-lg">

    <h3 class="font-bold text-lg text-[#8B0000] mb-6">
      Add Inventory Item
    </h3>

    <div class="grid grid-cols-[150px_1fr] gap-y-4 items-center">

      <!-- CATEGORY -->
      <label class="text-sm text-[#8B0000]">Category</label>
      <select id="addCategory" class="select select-bordered w-48 bg-white border-[#D9D9D9] text-[#333333]">
        <option disabled selected>Select Category</option>
        <option value="Medicine">Medicine</option>
        <option value="Supplies">Supplies</option>
      </select>

      <!-- DATE -->
      <label class="text-sm text-[#8B0000]">Date Received</label>
      <input
        id="addDate"
        type="date"
        class="input input-bordered w-40 bg-white border-[#D9D9D9] text-[#333333]"
      />

      <!-- STOCK -->
      <label class="text-sm text-[#8B0000]">Stock Number</label>
      <input id="addStock" class="input input-bordered w-40 bg-white border-[#D9D9D9] text-[#333333]" placeholder="00 - 000">

      <!-- NAME -->
      <label class="text-sm text-[#8B0000]">Supply Name</label>
      <input id="addName" class="input input-bordered w-100 bg-white border-[#D9D9D9] text-[#333333]"
        placeholder="ex. Nitrile Gloves Large">

      <!-- UNIT -->
      <label class="text-sm text-[#8B0000]">Units</label>
      <input id="addUnit" class="input input-bordered w-40 bg-white border-[#D9D9D9] text-[#333333]"
        placeholder="e.g. Box / Pack / Bottle / Piece">

      <!-- QTY -->
      <label class="text-sm text-[#8B0000]">Quantity</label>
      <input id="addQty" type="number"
        class="input input-bordered w-28 bg-white border-[#D9D9D9] text-[#333333]"
        oninput="computeAddBalance()">

      <!-- USED -->
      <label class="text-sm text-[#8B0000]">Consumed</label>
      <input id="addUsed" type="number"
        class="input input-bordered w-28 bg-white border-[#D9D9D9] text-[#333333]"
        oninput="computeAddBalance()">

      <!-- BALANCE -->
      <label class="text-sm text-[#8B0000]">Balance</label>
      <input id="addBalance"
        class="input input-bordered w-28 bg-[#F4F4F4] text-[#333333]"
        readonly>

              <input id="searchInput" class="ml-3 outline-none w-full text-sm
        bg-white text-gray-800 placeholder-gray-400"
                placeholder="Search Stock No., Name" oninput="renderTable()" />
            </div>
          </div>

          <div class="flex gap-2">

            <!-- SHOW SELECT -->
            <div class="rounded-full p-[2px] bg-gradient-to-r from-[#660000] to-[#FFD700]">
              <select
                id="showSelect"
                class="select select-sm rounded-full bg-white text-[#660000] w-full focus:outline-none"
                onchange="renderTable()">
                <option value="all">Show: All Products</option>
                <option value="medicine">Medicine</option>
                <option value="supplies">Supplies</option>
              </select>
            </div>

            <!-- SORT SELECT -->
            <div class="rounded-full p-[2px] bg-gradient-to-r from-[#660000] to-[#FFD700]">
              <select
                id="sortSelect"
                class="select select-sm rounded-full bg-white text-[#660000] w-full focus:outline-none"
                onchange="renderTable()">
                <option value="">Sort: Default</option>
                <option value="qty_asc">Quantity (Lowest to Highest)</option>
                <option value="alphabetical">Alphabetical (A–Z)</option>
                <option value="date_received">Date Received</option>
              </select>
            </div>


            <button onclick="resetAddForm(); addModal.showModal()"
              class="btn btn-sm hover:bg-[#660000] rounded-full border-none bg-[#8B0000] text-white">
              <i class="fa fa-plus mr-1"></i> Add Item
            </button>

          </div>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">
          <table class="table table-sm w-full">
            <thead>
              <tr class="text-[#8B0000] text-xs uppercase">
                <th>Date</th>
                <th>Stock No.</th>
                <th>Supplies</th>
                <th>Unit</th>
                <th>Qty</th>
                <th>Used</th>
                <th>Balance</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody id="tableBody"></tbody>
          </table>
        </div>

        <!-- EMPTY STATE -->
        <div
          id="emptyState"
          class="hidden flex-1 flex items-center justify-center text-gray-400 text-lg font-medium">
          No items in the inventory
        </div>

      </div>

  </main>

  <!-- ADD MODAL -->
  <dialog id="addModal" class="modal">
    <div class="modal-box max-w-xl bg-white rounded-lg">

      <h3 class="font-bold text-lg text-[#8B0000] mb-6">
        Add Inventory Item
      </h3>

      <div class="grid grid-cols-[150px_1fr] gap-y-4 items-center">

        <!-- CATEGORY -->
        <label class="text-sm text-[#8B0000]">Category</label>
        <select id="addCategory" class="select select-bordered w-48 bg-white border-[#D9D9D9] text-[#333333]">
          <option disabled selected>Select Category</option>
          <option value="Medicine">Medicine</option>
          <option value="Supplies">Supplies</option>
        </select>

        <!-- DATE (AUTO / DROPDOWN) -->
        <label class="text-sm text-[#8B0000]">Date Received</label>
        <input
          id="addDate"
          type="date"
          class="input input-bordered w-40 bg-white border-[#D9D9D9] text-[#333333]" />

        <!-- STOCK -->
        <label class="text-sm text-[#8B0000]">Stock Number</label>
        <input id="addStock" class="input input-bordered w-40 bg-white border-[#D9D9D9] text-[#333333]" placeholder="00 - 000">

        <!-- NAME -->
        <label class="text-sm text-[#8B0000]">Supply Name</label>
        <input id="addName" class="input input-bordered w-100 bg-white border-[#D9D9D9] text-[#333333]"
          placeholder="ex. Nitrile Gloves Large">

        <!-- UNIT -->
        <label class="text-sm text-[#8B0000]">Units</label>
        <input id="addUnit" class="input input-bordered w-40 bg-white border-[#D9D9D9] text-[#333333]"
          placeholder="e.g. Box / Pack / Bottle / Piece">

        <!-- QTY -->
        <label class="text-sm text-[#8B0000]">Quantity</label>
        <input id="addQty" type="number"
          class="input input-bordered w-28 bg-white border-[#D9D9D9] text-[#333333]"
          oninput="computeAddBalance()">

        <!-- USED -->
        <label class="text-sm text-[#8B0000]">Consumed</label>
        <input id="addUsed" type="number"
          class="input input-bordered w-28 bg-white border-[#D9D9D9] text-[#333333]"
          oninput="computeAddBalance()">

        <!-- BALANCE -->
        <label class="text-sm text-[#8B0000]">Balance</label>
        <input id="addBalance"
          class="input input-bordered w-28 bg-[#F4F4F4] text-[#333333]"
          readonly>

      </div>

      <div class="modal-action mt-6">
        <button class="btn bg-[#F4F4F4] hover:bg-[#333333] hover:text-[#F4F4F4] text-[#333333] border-[#333333]" onclick="addModal.close()">Back</button>
        <button class="btn bg-[#8B0000] hover:bg-[#F55E5E] hover:text-[#8B0000] text-[#F4F4F4] border-none" onclick="addItem()">Save</button>
      </div>

    </div>
  </dialog>

  <!-- EDIT MODAL -->
  <dialog id="editModal" class="modal">
    <div class="modal-box max-w-xl bg-white rounded-lg">

      <h3 class="font-bold text-lg text-[#8B0000] mb-6">
        Edit Inventory Item
      </h3>

      <div class="grid grid-cols-[150px_1fr] gap-y-4 items-center text-[#8B0000]">
        <label>Category</label>
        <select id="editCategory" class="select select-bordered w-48 bg-white text-[#333333]">
          <option value="Medicine">Medicine</option>
          <option value="Supplies">Supplies</option>
        </select>

        <label>Date Received</label>
        <input id="editDate" type="date"
          class="input input-bordered w-40 bg-white border-[#D9D9D9] text-[#333333]">

        <label>Stock Number</label>
        <input id="editStock" class="input input-bordered bg-white border-[#D9D9D9] text-[#333333]">

        <label>Supply Name</label>
        <input id="editName" class="input input-bordered bg-white border-[#D9D9D9] text-[#333333]">

        <label class="text-sm text-[#8B0000]">Units</label>
        <input id="editUnit" class="input input-bordered w-40 bg-white border-[#D9D9D9] text-[#333333]"
          placeholder="e.g. Box / Pack / Bottle / Piece">


      <label>Quantity</label>
      <input id="editQty" type="number"
        class="input input-bordered w-28 bg-white border-[#D9D9D9] text-[#333333]"
        oninput="computeEditBalance()">

        <label>Balance</label>
        <input id="editBalance"
          class="input input-bordered w-28 bg-[#F4F4F4] border-[#D9D9D9] text-[#333333]"
          readonly>

      </div>

      <div class="modal-action mt-6">
        <button class="btn bg-[#F4F4F4] hover:bg-[#333333] hover:text-[#F4F4F4] text-[#333333] border-[#333333]" onclick="editModal.close()">Back</button>
        <button class="btn bg-[#8B0000] hover:bg-[#F55E5E] hover:text-[#8B0000] text-[#F4F4F4] border-none" onclick="saveEdit()">Save</button>
      </div>

    </div>
  </dialog>

  </div>
</dialog>

<!-- DELETE CONFIRMATION MODAL -->
<dialog id="deleteModal" class="modal">
  <div class="modal-box max-w-md bg-white rounded-lg text-center">
    <h3 class="font-bold text-lg text-[#8B0000] mb-4">Confirm Deletion</h3>
    <p class="mb-6">Are you sure you want to delete this item? This action cannot be undone.</p>

    <div class="modal-action justify-center gap-4">
      <button class="btn bg-gray-200 text-gray-700 hover:bg-gray-300" onclick="deleteModal.close()">Cancel</button>
      <button id="confirmDeleteBtn" class="btn bg-[#8B0000] text-white">Delete</button>
    </div>
  </dialog>

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

  <script>
    /*let inventory = [
  {
    category: "Supplies",
    date: "01/20/25",
    stock: "18-001",
    name: "Disposable Dental Needles",
    unit: "Piece",
    qty: 42,
    used: 8
  },
  {
    category: "Medicine",
    date: "01/21/25",
    stock: "18-002",
    name: "Amoxicillin 500mg",
    unit: "Box",
    qty: 30,
    used: 5
  },
  {
    category: "Supplies",
    date: "01/22/25",
    stock: "18-003",
    name: "Latex Examination Gloves",
    unit: "Box",
    qty: 50,
    used: 12
  },
  {
    category: "Medicine",
    date: "01/23/25",
    stock: "18-004",
    name: "Paracetamol 500mg",
    unit: "Box",
    qty: 40,
    used: 10
  },
  {
    category: "Supplies",
    date: "01/24/25",
    stock: "18-005",
    name: "Dental Cotton Rolls",
    unit: "Pack",
    qty: 60,
    used: 15
  },
  {
    category: "Supplies",
    date: "01/25/25",
    stock: "18-006",
    name: "Disposable Mouth Mirrors",
    unit: "Piece",
    qty: 25,
    used: 5
  },
  {
    category: "Medicine",
    date: "01/26/25",
    stock: "18-007",
    name: "Ibuprofen 400mg",
    unit: "Box",
    qty: 35,
    used: 7
  },
  {
    category: "Supplies",
    date: "01/27/25",
    stock: "18-008",
    name: "Cotton Swabs",
    unit: "Pack",
    qty: 80,
    used: 20
  },
  {
    category: "Medicine",
    date: "01/28/25",
    stock: "18-009",
    name: "Chlorhexidine Mouthwash 0.12%",
    unit: "Bottle",
    qty: 20,
    used: 4
  },
  {
    category: "Supplies",
    date: "01/29/25",
    stock: "18-010",
    name: "Dental Floss Packs",
    unit: "Pack",
    qty: 50,
    used: 10
  }
];*/

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

    // NOTIFICATION
    document.addEventListener("DOMContentLoaded", () => {
      const btn = document.getElementById("notifBtn");
      const menu = document.getElementById("notifMenu");

      let isOpen = false;

  } else {
    applyLayout('72px');

      // Toggle when clicking bell
      btn.addEventListener("click", (e) => {
        e.stopPropagation();
        isOpen ? closeMenu() : openMenu();
      });

      // Keep open when clicking inside menu
      menu.addEventListener("click", (e) => {
        e.stopPropagation();
      });

      // Close when clicking outside
      document.addEventListener("click", () => {
        if (isOpen) closeMenu();
      });

      // Close on ESC
      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && isOpen) closeMenu();
      });

      // Start closed
      closeMenu();
    });

    let inventory = [];

    toggleBtn.classList.remove('translate-x-2');
    icon.classList.replace('fa-xmark', 'fa-bars');
  }
}

// ✅ INITIAL STATE SYNC (CRITICAL FIX)
document.addEventListener('DOMContentLoaded', () => {
  sidebarOpen = false;
  applyLayout('72px');
});

/* =========================
   INVENTORY DATA LOAD
let inventory = [];

async function loadInventory() {
  const res = await fetch('/dentist/inventory/data', { cache: 'no-store' });

  // if backend accidentally returns HTML (like login page), this prevents silent failure
  const ct = res.headers.get("content-type") || "";
  if (!ct.includes("application/json")) {
    console.error("Inventory data is not JSON. Check if route is protected or returning HTML.");
    return;
  }

  inventory = await res.json();
  renderTable();
}
loadInventory();

async function addItem() {
  if (
    addCategory.selectedIndex === 0 ||
    !addDate.value ||
    !addStock.value ||
    !addName.value ||
    !addUnit.value ||
    addQty.value === ''
  ) {
    alert('Please complete all required fields.');
    return;
  }

  const res = await fetch('/dentist/inventory', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept': 'application/json' // ✅ important: prevents Laravel from redirecting
    },
    body: JSON.stringify({
      category: addCategory.value,
      date_received: addDate.value,
      stock_no: addStock.value.trim(),
      name: addName.value.trim(),
      unit: addUnit.value.trim(),
      qty: Number(addQty.value),
      used: Number(addUsed.value || 0)
    })
  });

  if (!res.ok) {
    // Laravel validation errors will be JSON if Accept is application/json
    const text = await res.text();
    console.error("ADD FAILED:", text);
    alert("Add failed — check console");
    return;
  }

  addModal.close();
  resetAddForm();

  // ✅ make sure UI refresh happens AFTER the DB is updated
  await loadInventory();
}

/* =========================
   DELETE
let deleteId = null;

      await fetch(`/dentist/inventory/${deleteId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content')
        }
      });

      deleteModal.close();
      deleteId = null;
      loadInventory();
    };

  await fetch(`/dentist/inventory/${deleteId}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  });

    const emptyState = document.getElementById("emptyState");

/* =========================
   FILTER PANEL STATE (NEW)
const activeFilters = {
  sort: "",        // "az" | "za"
  dateFrom: "",
  dateTo: "",
  dateOrder: "",   // "asc" | "desc"
  itemType: "",    // "medicine" | "supplies"
  stock: ""        // "low-high" | "high-low"
};

function openFilterModal() {
  // sync UI with activeFilters before opening
  setRadioByNameValue("fp_sort", activeFilters.sort);
  setRadioByNameValue("fp_dateOrder", activeFilters.dateOrder);
  setRadioByNameValue("fp_itemType", activeFilters.itemType);
  setRadioByNameValue("fp_stock", activeFilters.stock);

  document.getElementById("fp_dateFrom").value = activeFilters.dateFrom || "";
  document.getElementById("fp_dateTo").value = activeFilters.dateTo || "";

  filterModal.showModal();
}

function setRadioByNameValue(name, value) {
  const radios = document.querySelectorAll(`input[name="${name}"]`);
  radios.forEach(r => r.checked = (value && r.value === value));
  if (!value) radios.forEach(r => r.checked = false);
}

function getCheckedValue(name) {
  const el = document.querySelector(`input[name="${name}"]:checked`);
  return el ? el.value : "";
}

function clearFilterPanel() {
  // clear modal fields
  setRadioByNameValue("fp_sort", "");
  setRadioByNameValue("fp_dateOrder", "");
  setRadioByNameValue("fp_itemType", "");
  setRadioByNameValue("fp_stock", "");
  document.getElementById("fp_dateFrom").value = "";
  document.getElementById("fp_dateTo").value = "";

  // clear active filters immediately
  activeFilters.sort = "";
  activeFilters.dateFrom = "";
  activeFilters.dateTo = "";
  activeFilters.dateOrder = "";
  activeFilters.itemType = "";
  activeFilters.stock = "";

  filterModal.close();
  renderTable();
}

function saveFilterPanel() {
  activeFilters.sort = getCheckedValue("fp_sort");
  activeFilters.dateOrder = getCheckedValue("fp_dateOrder");
  activeFilters.itemType = getCheckedValue("fp_itemType");
  activeFilters.stock = getCheckedValue("fp_stock");

  activeFilters.dateFrom = document.getElementById("fp_dateFrom").value || "";
  activeFilters.dateTo = document.getElementById("fp_dateTo").value || "";

  filterModal.close();
  renderTable();
}

/* =========================
   TABLE RENDER
const emptyState = document.getElementById("emptyState");

      const show = showSelect.value;

  let data = [...inventory];

  // Item Type filter
  if (activeFilters.itemType === "medicine") {
    data = data.filter(item => item.category === "Medicine");
  }
  if (activeFilters.itemType === "supplies") {
    data = data.filter(item => item.category === "Supplies");
  }

  // Search
  const search = searchInput.value.toLowerCase();
  if (search) {
    data = data.filter(i =>
      String(i.stock_no || "").toLowerCase().includes(search) ||
      String(i.name || "").toLowerCase().includes(search)
    );
  }

  // Date range filter (by date_received)
  const from = activeFilters.dateFrom ? new Date(activeFilters.dateFrom) : null;
  const to = activeFilters.dateTo ? new Date(activeFilters.dateTo) : null;

  if (from) from.setHours(0,0,0,0);
  if (to)   to.setHours(23,59,59,999);

  if (from) data = data.filter(i => i.date_received && new Date(i.date_received) >= from);
  if (to)   data = data.filter(i => i.date_received && new Date(i.date_received) <= to);

  // Sorting (priority: Stock Level > Sort A-Z/Z-A > Date Order)
  const toNum = (v) => {
    const n = Number(v);
    return Number.isFinite(n) ? n : 0;
  };
  const toTime = (v) => {
    if (!v) return 0;
    const t = new Date(v).getTime();
    return Number.isFinite(t) ? t : 0;
  };

  if (activeFilters.stock === "low-high") {
    data.sort((a,b) => toNum(a.qty) - toNum(b.qty));
  } else if (activeFilters.stock === "high-low") {
    data.sort((a,b) => toNum(b.qty) - toNum(a.qty));
  } else if (activeFilters.sort === "az") {
    data.sort((a,b) => String(a.name || "").localeCompare(String(b.name || "")));
  } else if (activeFilters.sort === "za") {
    data.sort((a,b) => String(b.name || "").localeCompare(String(a.name || "")));
  } else if (activeFilters.dateOrder === "asc") {
    data.sort((a,b) => toTime(a.date_received) - toTime(b.date_received));
  } else if (activeFilters.dateOrder === "desc") {
    data.sort((a,b) => toTime(b.date_received) - toTime(a.date_received));
  }

  if (data.length === 0) {
    emptyState.classList.remove("hidden");
    return;
  } else {
    emptyState.classList.add("hidden");
  }

  data.forEach((item) => {
    const balance = toNum(item.qty) - toNum(item.used);

    tbody.innerHTML += `
      <tr class="text-gray-800">
        <td class="text-[#333333]">${item.formatted_date ?? ''}</td>
        <td class="text-[#333333]">${item.stock_no ?? ''}</td>
        <td class="text-[#333333]">${item.name ?? ''}</td>
        <td class="text-[#333333]">${item.unit ?? ''}</td>
        <td class="text-[#333333]">${item.qty ?? 0}</td>
        <td class="text-[#333333]">${item.used ?? 0}</td>
        <td class="text-[#333333]">${balance}</td>
        <td class="flex justify-center gap-2">
          <button class="btn btn-xs bg-[#8B0000] text-white hover:bg-[#660000] border-none"
            onclick="openEdit(${item.id})">
            <i class="fa fa-pen"></i>
          </button>
          <button class="btn btn-xs bg-[#8B0000] text-white hover:bg-[#660000] border-none"
            onclick="deleteItem(${item.id})">
            <i class="fa fa-trash"></i>
          </button>
        </td>
      </tr>`;
  });
}

/* =========================
   ADD
function resetAddForm() {
  addCategory.selectedIndex = 0;
  addDate.value = '';
  addStock.value = '';
  addName.value = '';
  addUnit.value = '';
  addQty.value = '';
  addUsed.value = '';
  addBalance.value = '';
}

async function addItem() {
  if (
    addCategory.selectedIndex === 0 ||
    !addDate.value ||
    !addStock.value ||
    !addName.value ||
    !addUnit.value ||
    addQty.value === ''
  ) {
    alert('Please complete all required fields.');
    return;
  }

  const res = await fetch('/dentist/inventory', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
      category: addCategory.value,
      date_received: addDate.value,
      stock_no: addStock.value.trim(),
      name: addName.value.trim(),
      unit: addUnit.value,
      qty: Number(addQty.value),
      used: Number(addUsed.value || 0)
    })
  });

  if (!res.ok) {
    const err = await res.json();
    console.error(err);
    alert(Object.values(err.errors).join('\n'));
    return;
  }

  addModal.close();
  resetAddForm();
  loadInventory();
}

/* =========================
   EDIT
let editId = null;

function openEdit(id) {
  editId = id;
  const i = inventory.find(item => item.id === id);
  if (!i) return;

  editCategory.value = i.category;
  editStock.value = i.stock_no;
  editName.value = i.name;
  editUnit.value = i.unit;
  editQty.value = i.qty;
  editUsed.value = i.used;
  editDate.value = i.date_received?.slice(0, 10);

  computeEditBalance();
  editModal.showModal();
}

async function saveEdit() {
  if (!editId) return;

  const res = await fetch(`/dentist/inventory/${editId}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
      category: editCategory.value,
      date_received: editDate.value,
      stock_no: editStock.value,
      name: editName.value,
      unit: editUnit.value,
      qty: Number(editQty.value),
      used: Number(editUsed.value)
    })
  });

  if (!res.ok) {
    const err = await res.text();
    console.error(err);
    alert('EDIT FAILED — check console');
    return;
  }

  editModal.close();
  editId = null;
  loadInventory();
}

/* =========================
   BALANCE
function computeAddBalance() {
  const qty = Number(addQty.value || 0);
  const used = Number(addUsed.value || 0);
  addBalance.value = qty - used;
}

function computeEditBalance() {
  editBalance.value = Number(editQty.value || 0) - Number(editUsed.value || 0);
}

/* =========================
   NOTIFICATION
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("notifBtn");
  const menu = document.getElementById("notifMenu");

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