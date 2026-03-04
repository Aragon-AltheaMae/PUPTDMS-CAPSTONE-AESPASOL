<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Patient List</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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
        transform: translateY(8px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in {
      animation: fadeIn 0.6s ease-out forwards;
    }

    .radio-red {
      -webkit-appearance: none;
      appearance: none;
      width: 16px;
      height: 16px;
      border: 2px solid #8B0000;
      border-radius: 9999px;
      display: inline-grid;
      place-content: center;
      background: #fff;
    }

    .radio-red::before {
      content: "";
      width: 8px;
      height: 8px;
      border-radius: 9999px;
      transform: scale(0);
      transition: transform 120ms ease-in-out;
      background: #8B0000;
    }

    .radio-red:checked::before {
      transform: scale(1);
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
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }
  </style>
</head>

<body class="bg-[#F4F4F4] text-[#333333] font-normal">

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

  <!-- CONTENT -->
  <main
    id="mainContent"
    class="pt-[100px] px-6 py-6 fade-up min-h-screen">

    <div class="max-w-7xl mt-4 mx-auto fade-in">
      <div class="px-2 md:px-6">

        <!-- Title + Search / Filter -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
          <div class="mb-6">
            <h2 class="text-3xl font-bold text-[#8B0000]">
              Patient List
            </h2>
            <p class="text-gray-500 mt-1">
              Click to Access Patient Information
            </p>
          </div>

          <div class="flex items-center gap-6 w-full md:w-auto">
            <div id="searchWrapper"
              class="flex items-center bg-gradient-to-r from-[#8B0000] to-[#F2C94C] p-[2px] rounded-full w-full md:w-auto">
              <div id="searchInner"
                class="flex items-center bg-white rounded-full overflow-hidden w-full h-12">
                <!-- left: search -->
                <div class="flex items-center gap-2 pl-3 pr-5 py-2 flex-1">
                  <span class="w-7 h-7 rounded-full bg-[#8B0000] flex items-center justify-center">
                    <i class="fa-solid fa-magnifying-glass text-white text-[11px]"></i>
                  </span>

                  <input
                    id="searchInput"
                    type="text"
                    placeholder="Search"
                    class="w-full md:w-72 bg-transparent text-sm text-gray-700 placeholder:text-gray-300 focus:outline-none" />
                </div>

                <div id="searchDivider" class="w-[2px] self-stretch bg-[#F2C94C]"></div>

                <button id="openFilter"
                  type="button"
                  class="h-full px-6 flex items-center gap-2 font-semibold
                    text-[#8B0000] bg-white
                    rounded-none rounded-r-full border-0">
                  <i class="fa-solid fa-sliders"></i>
                  Filter
                </button>

              </div>
            </div>

            <button id="clearBtn" type="button" class="text-[#8B0000] text-sm font-medium hover:underline">
              Clear
            </button>
          </div>
        </div>

        <div class="w-full max-w-6xl mx-auto">

          <div class="mx-4">
            <div class="mx-4 relative">

              <div class="flex gap-4 px-6 relative z-20">

                <button
                  class="filter-btn bg-[#8B0000] text-white
                  rounded-t-2xl rounded-b-none
                  px-6 py-4 w-[210px] text-left
                  hover:opacity-90 transition-all duration-200"
                  data-filter="today"
                  type="button">
                  <h3 class="text-4xl font-medium leading-none mb-2">5</h3>
                  <p class="text-base">Scheduled Today</p>
                </button>

                <button
                  class="filter-btn bg-[#8B0000] text-white
                  rounded-t-2xl rounded-b-none
                  px-6 py-4 w-[210px] text-left
                  hover:opacity-90 transition-all duration-200"
                  data-filter="rescheduled"
                  type="button">
                  <h3 class="text-4xl font-medium leading-none mb-2">10</h3>
                  <p class="text-base">Rescheduled</p>
                </button>

                <button
                  class="filter-btn bg-[#8B0000] text-white
                  rounded-t-2xl rounded-b-none
                  px-6 py-4 w-[210px] text-left
                  hover:opacity-90 transition-all duration-200"
                  data-filter="all"
                  type="button">
                  <h3 class="text-4xl font-medium leading-none mb-2">50</h3>
                  <p class="text-base">All</p>
                </button>

              </div>
              <div class="mx-4 shadow-lg rounded-lg bg-white overflow-hidden relative">

                <div
                  id="patientContainer"
                  class="space-y-4 px-6 pb-6 pt-14 -mt-8 rounded-t-none">

                  <a href="/dentist/patient"
                    class="patient-item today block relative bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition cursor-pointer">

                    <div class="absolute left-0 top-0 h-full w-[6px] bg-[#2E2E2E] rounded-l-xl"></div>

                    <div class="flex items-center gap-6 px-8 py-6 pl-12">

                      <img
                        src="https://i.pravatar.cc/80"
                        class="w-16 h-16 rounded-full object-cover shadow"
                        alt="Patient" />

                      <div class="flex-1 grid grid-cols-12 items-center gap-6">

                        <div class="col-span-4">
                          <p class="font-semibold text-[#333333] text-sm">
                            Villanueva, Emily
                          </p>
                          <p class="text-gray-500 text-xs">
                            2023-00016 · BSECE · 2nd Year · Section 1
                          </p>
                          <span class="patient-info hidden">BSECE|2nd Year|1|2025-01-20</span>
                        </div>

                        <div class="col-span-4 flex items-start gap-3">
                          <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <i class="fa-regular fa-calendar text-blue-600"></i>
                          </div>
                          <div class="text-sm">
                            <p class="text-gray-400 text-xs uppercase tracking-wide">
                              Date and Time
                            </p>
                            <p class="font-semibold text-[#333333]">
                              20 Jan 2025
                            </p>
                            <p class="text-gray-600 text-xs">
                              1:30 PM – 2:30 PM
                            </p>
                          </div>
                        </div>

                        <div class="col-span-3 flex items-start gap-3">
                          <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <i class="fa-solid fa-tooth text-blue-600"></i>
                          </div>
                          <div class="text-sm">
                            <p class="text-gray-400 text-xs uppercase tracking-wide">
                              Service
                            </p>
                            <p class="font-semibold text-[#333333]">
                              Dental Checkup
                            </p>

                            <span class="inline-block mt-2 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                              Appointment Today
                            </span>
                          </div>
                        </div>

                        <div class="col-span-1 flex justify-end">
                          <i class="fa-solid fa-arrow-right text-[#8B0000] text-lg"></i>
                        </div>

                      </div>
                    </div>
                  </a>

                  <a href="/dentist/patient"
                    class="patient-item today block relative bg-white border border-gray-200 rounded-xl  shadow-sm hover:shadow-md transition cursor-pointer">

                    <div class="absolute left-0 top-0 h-full w-[6px] bg-[#2E2E2E] rounded-l-xl"></div>

                    <div class="flex items-center w-full px-8 py-6 pl-12 gap-6">

                      <img
                        src="https://i.pravatar.cc/52"
                        class="w-16 h-16 rounded-full object-cover shadow"
                        alt="Patient" />

                      <div class="flex-1 grid grid-cols-12 items-center gap-6">

                        <div class="col-span-4 leading-tight">
                          <p class="font-semibold text-[#333333] text-sm">
                            Dela Cruz, Mark
                          </p>
                          <p class="text-gray-500 text-xs">
                            2023-00011 · BSECE · 1st Year · Section 2
                          </p>
                          <span class="patient-info hidden">BSECE|1st Year|2|2025-01-20</span>
                        </div>

                        <div class="col-span-4 flex items-start gap-3">
                          <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <i class="fa-regular fa-calendar text-blue-600"></i>
                          </div>
                          <div class="text-sm">
                            <p class="text-gray-400 text-xs uppercase tracking-wide">
                              Date and Time
                            </p>
                            <p class="font-semibold text-[#333333]">
                              January 20, 2025
                            </p>
                            <p class="text-gray-600 text-xs">
                              11:30 AM
                            </p>
                          </div>
                        </div>

                        <div class="col-span-3 flex items-start gap-3">
                          <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <i class="fa-solid fa-tooth text-blue-600"></i>
                          </div>
                          <div class="text-sm">
                            <p class="text-gray-400 text-xs uppercase tracking-wide">
                              Service
                            </p>
                            <p class="font-semibold text-[#333333]">
                              Tooth Cleaning
                            </p>

                            <span
                              class="inline-block mt-2 px-3 py-1 rounded-full
                            bg-green-100 text-green-700 text-xs font-medium">
                              Appointment Today
                            </span>
                          </div>
                        </div>

                        <div class="col-span-1 flex justify-end items-center">
                          <i class="fa-solid fa-arrow-right text-[#8B0000] text-lg"></i>
                        </div>

                      </div>
                    </div>
                  </a>

                  <a href="/dentist/patient"
                    class="patient-item today block relative bg-white border border-gray-200 rounded-xl  shadow-sm hover:shadow-md transition cursor-pointer">

                    <div class="absolute left-0 top-0 h-full w-[6px] bg-[#2E2E2E] rounded-l-xl"></div>

                    <div class="flex items-center w-full px-8 py-6 pl-12 gap-6">

                      <img
                        src="https://i.pravatar.cc/52"
                        class="w-16 h-16 rounded-full object-cover shadow"
                        alt="Patient" />

                      <!-- Content -->
                      <div class="flex-1 grid grid-cols-12 items-center gap-6">

                        <!-- Patient info -->
                        <div class="col-span-4">
                          <p class="font-semibold text-[#333333] text-sm">
                            Villanueva, Emily
                          </p>
                          <p class="text-gray-500 text-xs">
                            2023-00016 · BSECE · 2nd Year · Section 1
                          </p>
                          <span class="patient-info hidden">BSECE|2nd Year|1|2025-01-20</span>
                        </div>

                        <!-- Date & Time -->
                        <div class="col-span-4 flex items-start gap-3">
                          <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <i class="fa-regular fa-calendar text-blue-600"></i>
                          </div>
                          <div class="text-sm">
                            <p class="text-gray-400 text-xs uppercase tracking-wide">
                              Date and Time
                            </p>
                            <p class="font-semibold text-[#333333]">
                              20 Jan 2025
                            </p>
                            <p class="text-gray-600 text-xs">
                              1:30 PM – 2:30 PM
                            </p>
                          </div>
                        </div>

                        <!-- Service -->
                        <div class="col-span-3 flex items-start gap-3">
                          <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <i class="fa-solid fa-tooth text-blue-600"></i>
                          </div>
                          <div class="text-sm">
                            <p class="text-gray-400 text-xs uppercase tracking-wide">
                              Service
                            </p>
                            <p class="font-semibold text-[#333333]">
                              Dental Checkup
                            </p>

                            <span class="inline-block mt-2 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                              Appointment Today
                            </span>
                          </div>
                        </div>

                        <!-- Arrow -->
                        <div class="col-span-1 flex justify-end">
                          <i class="fa-solid fa-arrow-right text-[#8B0000] text-lg"></i>
                        </div>

                      </div>
                    </div>
                  </a>

                  <!-- Rescheduled -->
                  <!-- Patient Card – RESCHEDULED -->
                  <a href="/dentist/patient"
                    class="patient-item rescheduled block relative bg-white border border-gray-200 rounded-xl  shadow-sm hover:shadow-md transition cursor-pointer">

                    <!-- Left accent bar -->
                    <div class="absolute left-0 top-0 h-full w-[6px] bg-orange-500 rounded-l-xl"></div>

                    <div class="flex items-center w-full px-8 py-6 pl-12 gap-6">

                      <!-- Avatar -->
                      <img
                        src="https://i.pravatar.cc/54"
                        class="w-16 h-16 rounded-full object-cover shadow"
                        alt="Patient" />

                      <!-- Main content -->
                      <div class="flex-1 grid grid-cols-12 items-center gap-6">

                        <!-- Name + ID -->
                        <div class="col-span-4 leading-tight">
                          <p class="font-semibold text-[#333333] text-sm">
                            Reyes, Joshua
                          </p>
                          <p class="text-gray-500 text-xs">
                            2023-00013 · BSED - ENG · 2nd Year · Section 1
                          </p>
                          <span class="patient-info hidden">BSED - ENG|2nd Year|1|2025-01-22</span>
                        </div>

                        <!-- DATE AND TIME -->
                        <div class="col-span-4 flex items-start gap-3">
                          <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                            <i class="fa-regular fa-calendar text-orange-600"></i>
                          </div>
                          <div class="text-sm">
                            <p class="text-gray-400 text-xs uppercase tracking-wide">
                              Date and Time
                            </p>
                            <p class="font-semibold text-[#333333]">
                              January 22, 2025
                            </p>
                            <p class="text-gray-600 text-xs">
                              10:00 AM
                            </p>
                          </div>
                        </div>

                        <!-- SERVICE -->
                        <div class="col-span-3 flex items-start gap-3">
                          <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                            <i class="fa-solid fa-tooth text-orange-600"></i>
                          </div>
                          <div class="text-sm">
                            <p class="text-gray-400 text-xs uppercase tracking-wide">
                              Service
                            </p>
                            <p class="font-semibold text-[#333333]">
                              Tooth Extraction
                            </p>

                            <span
                              class="inline-block mt-2 px-3 py-1 rounded-full
                        bg-orange-100 text-orange-600 text-xs font-medium">
                              Rescheduled
                            </span>
                          </div>
                        </div>

                        <!-- Arrow -->
                        <div class="col-span-1 flex justify-end items-center">
                          <i class="fa-solid fa-arrow-right text-[#8B0000] text-lg"></i>
                        </div>

                      </div>
                    </div>
                  </a>

                  <a href="/dentist/patient"
                    class="patient-item rescheduled block relative bg-white border border-gray-200 rounded-xl  shadow-sm hover:shadow-md transition cursor-pointer">

                    <!-- Left accent bar -->
                    <div class="absolute left-0 top-0 h-full w-[6px] bg-orange-500 rounded-l-xl"></div>

                    <div class="flex items-center w-full px-8 py-6 pl-12 gap-6">

                      <!-- Avatar -->
                      <img
                        src="https://i.pravatar.cc/55"
                        class="w-16 h-16 rounded-full object-cover shadow"
                        alt="Patient" />

                      <div class="flex-1 grid grid-cols-12 items-center gap-6">

                        <!-- Name -->
                        <div class="col-span-4 leading-tight">
                          <p class="font-semibold text-[#333333] text-sm">
                            Garcia, Nicole
                          </p>
                          <p class="text-gray-500 text-xs">
                            2023-00014 · BSOA · 1st Year · Section 2
                          </p>
                          <span class="patient-info hidden">BSOA|1st Year|2|2025-01-23</span>
                        </div>

                        <!-- Date & Time -->
                        <div class="col-span-4 flex items-start gap-3">
                          <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                            <i class="fa-regular fa-calendar text-orange-600"></i>
                          </div>
                          <div>
                            <p class="text-gray-400 text-xs uppercase">Date and Time</p>
                            <p class="font-semibold text-[#333333] text-sm">January 23, 2025</p>
                            <p class="text-gray-600 text-xs">1:00 PM</p>
                          </div>
                        </div>

                        <!-- Service -->
                        <div class="col-span-3 flex items-start gap-3">
                          <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                            <i class="fa-solid fa-tooth text-orange-600"></i>
                          </div>
                          <div>
                            <p class="text-gray-400 text-xs uppercase">Service</p>
                            <p class="font-semibold text-[#333333] text-sm">Dental Surgery</p>
                            <span class="inline-block mt-2 px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-xs font-medium">
                              Rescheduled
                            </span>
                          </div>
                        </div>

                        <!-- Arrow -->
                        <div class="col-span-1 flex justify-end">
                          <i class="fa-solid fa-arrow-right text-[#8B0000] text-lg"></i>
                        </div>

                      </div>
                    </div>
                  </a>

                  <a href="/dentist/patient"
                    class="patient-item rescheduled block relative bg-white border border-gray-200 rounded-xl  shadow-sm hover:shadow-md transition cursor-pointer">

                    <!-- Left accent bar -->
                    <div class="absolute left-0 top-0 h-full w-[6px] bg-orange-500 rounded-l-xl"></div>

                    <div class="flex items-center w-full px-8 py-6 pl-12 gap-6">

                      <!-- Avatar -->
                      <img
                        src="https://i.pravatar.cc/56"
                        class="w-16 h-16 rounded-full object-cover shadow"
                        alt="Patient" />

                      <div class="flex-1 grid grid-cols-12 items-center gap-6">

                        <!-- Name -->
                        <div class="col-span-4 leading-tight">
                          <p class="font-semibold text-[#333333] text-sm">
                            Lopez, Christian
                          </p>
                          <p class="text-gray-500 text-xs">
                            2023-00015 · BSPSYCH · 3rd Year · Section 1
                          </p>
                          <span class="patient-info hidden">BSPSYCH|3rd Year|1|2025-01-24</span>
                        </div>

                        <!-- Date & Time -->
                        <div class="col-span-4 flex items-start gap-3">
                          <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                            <i class="fa-regular fa-calendar text-orange-600"></i>
                          </div>
                          <div>
                            <p class="text-gray-400 text-xs uppercase">Date and Time</p>
                            <p class="font-semibold text-[#333333] text-sm">January 24, 2025</p>
                            <p class="text-gray-600 text-xs">4:30 PM</p>
                          </div>
                        </div>

                        <!-- Service -->
                        <div class="col-span-3 flex items-start gap-3">
                          <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                            <i class="fa-solid fa-tooth text-orange-600"></i>
                          </div>
                          <div>
                            <p class="text-gray-400 text-xs uppercase">Service</p>
                            <p class="font-semibold text-[#333333] text-sm">Dental Consultation</p>
                            <span class="inline-block mt-2 px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-xs font-medium">
                              Rescheduled
                            </span>
                          </div>
                        </div>

                        <!-- Arrow -->
                        <div class="col-span-1 flex justify-end">
                          <i class="fa-solid fa-arrow-right text-[#8B0000] text-lg"></i>
                        </div>

                      </div>
                    </div>
                  </a>

                </div> <!-- END #patientContainer -->

                <!-- Pagination -->
                <div id="pagination" class="flex items-center justify-center gap-4 py-8 text-sm text-gray-600">

                  <button
                    id="prevPage"
                    class="flex items-center gap-1 px-2 py-1 text-gray-300 cursor-not-allowed"
                    disabled>
                    <span>‹</span> Previous
                  </button>

                  <div id="pageNumbers" class="flex items-center gap-2"></div>

                  <button
                    id="nextPage"
                    class="flex items-center gap-1 px-2 py-1 text-[#8B0000] hover:underline">
                    Next <span>›</span>
                  </button>

                </div>
              </div> <!-- END tabs/card wrapper -->
            </div> <!-- END mx-4 -->
          </div>
        </div>
      </div> <!-- END w-full max-w-6xl -->
  </main>

  <!-- FILTER MODAL  -->
  <div id="filterModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-[760px] rounded-xl shadow-2xl overflow-hidden border border-gray-200 flex flex-col">

      <!-- Header -->
      <div class="px-6 py-4 flex items-center gap-3">
        <i class="fa-solid fa-sliders text-[#8B0000]"></i>
        <h2 class="text-xl font-medium text-[#8B0000]">Filter</h2>
      </div>
      <div class="h-px bg-gray-200"></div>

      <!-- Body (scrollable if needed) -->
      <div class="px-6 py-5 space-y-5 max-h-[76vh] overflow-y-auto scroll-smooth">

        <!-- Sort -->
        <div class="space-y-3">
          <p class="text-sm text-gray-500">Sort</p>
          <div class="space-y-2">
            <label class="flex items-center gap-3 text-sm text-gray-700">
              <input type="radio" name="sort" value="A-Z" class="filter-input radio-red" />
              A-Z
            </label>
            <label class="flex items-center gap-3 text-sm text-gray-700">
              <input type="radio" name="sort" value="Z-A" class="filter-input radio-red" />
              Z-A
            </label>
          </div>
        </div>

        <div class="h-px bg-gray-200"></div>

        <!-- Date Range -->
        <div class="space-y-3">
          <p class="text-sm text-gray-500">Date Range</p>

          <div class="grid grid-cols-12 gap-6 items-start">
            <!-- From/To -->
            <div class="col-span-8">
              <div class="grid grid-cols-2 gap-10">
                <div class="space-y-2">
                  <label class="text-sm text-gray-700">From:</label>
                  <input
                    type="date"
                    id="fromDate"
                    class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-200" />
                </div>

                <div class="space-y-2">
                  <label class="text-sm text-gray-700">To:</label>
                  <input
                    type="date"
                    id="toDate"
                    class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-200" />
                </div>
              </div>
            </div>

            <!-- Right radios -->
            <div class="col-span-4 space-y-2 pt-6">
              <label class="flex items-center gap-3 text-sm text-gray-700">
                <input type="radio" name="dateOrder" value="Ascending" class="radio-red" />
                Ascending
              </label>
              <label class="flex items-center gap-3 text-sm text-gray-700">
                <input type="radio" name="dateOrder" value="Descending" class="radio-red" />
                Descending
              </label>
            </div>
          </div>
        </div>

        <div class="h-px bg-gray-200"></div>

        <!-- Course -->
        <div class="space-y-3">
          <p class="text-sm text-gray-500">Course</p>

          <div class="grid grid-cols-6 gap-x-8 gap-y-4 text-sm text-gray-700">
            <label class="flex items-center gap-3"><input type="radio" name="course" value="BSIT" class="filter-input radio-red" /> BSIT</label>
            <label class="flex items-center gap-3"><input type="radio" name="course" value="BSECE" class="filter-input radio-red" /> BSECE</label>
            <label class="flex items-center gap-3"><input type="radio" name="course" value="BSBA - HRM" class="filter-input radio-red" /> BSBA - HRM</label>
            <label class="flex items-center gap-3"><input type="radio" name="course" value="BSED - ENG" class="filter-input radio-red" /> BSED - ENG</label>
            <label class="flex items-center gap-3"><input type="radio" name="course" value="BSOA" class="filter-input radio-red" /> BSOA</label>
            <label class="flex items-center gap-3"><input type="radio" name="course" value="BSPSYCH" class="filter-input radio-red" /> BSPSYCH</label>

            <label class="flex items-center gap-3"><input type="radio" name="course" value="DIT" class="filter-input radio-red" /> DIT</label>
            <label class="flex items-center gap-3"><input type="radio" name="course" value="BSME" class="filter-input radio-red" /> BSME</label>
            <label class="flex items-center gap-3"><input type="radio" name="course" value="BSBA - MM" class="filter-input radio-red" /> BSBA - MM</label>
            <label class="flex items-center gap-3"><input type="radio" name="course" value="BSED - MATH" class="filter-input radio-red" /> BSED - MATH</label>
            <label class="flex items-center gap-3"><input type="radio" name="course" value="DOMT" class="filter-input radio-red" /> DOMT</label>
          </div>
        </div>

        <div class="h-px bg-gray-200"></div>

        <!-- Year + Section -->
        <div class="grid grid-cols-12 gap-10">
          <div class="col-span-6 space-y-3">
            <p class="text-sm text-gray-500">Year</p>
            <div class="grid grid-cols-2 gap-y-3 text-sm text-gray-700">
              <label class="flex items-center gap-3"><input type="radio" name="year" value="1st Year" class="filter-input radio-red" /> 1st Year</label>
              <label class="flex items-center gap-3"><input type="radio" name="year" value="3rd Year" class="filter-input radio-red" /> 3rd Year</label>
              <label class="flex items-center gap-3"><input type="radio" name="year" value="2nd Year" class="filter-input radio-red" /> 2nd Year</label>
              <label class="flex items-center gap-3"><input type="radio" name="year" value="4th Year" class="filter-input radio-red" /> 4th Year</label>
            </div>
          </div>

          <div class="col-span-6 space-y-3">
            <p class="text-sm text-gray-500">Section</p>
            <div class="space-y-3 text-sm text-gray-700">
              <label class="flex items-center gap-3"><input type="radio" name="section" value="1" class="filter-input radio-red" /> 1</label>
              <label class="flex items-center gap-3"><input type="radio" name="section" value="2" class="filter-input radio-red" /> 2</label>
            </div>
          </div>
        </div>

        <div class="h-px bg-gray-200"></div>

        <!-- Department -->
        <div class="space-y-3">
          <p class="text-sm text-gray-500">Department</p>

          <div class="flex flex-wrap gap-x-12 gap-y-4 text-sm text-gray-700">
            <label class="flex items-center gap-3 whitespace-nowrap">
              <input type="radio" name="department" value="Administrative" class="filter-input radio-red" />
              Administrative
            </label>
            <label class="flex items-center gap-3 whitespace-nowrap">
              <input type="radio" name="department" value="Faculty" class="filter-input radio-red" />
              Faculty
            </label>
            <label class="flex items-center gap-3 whitespace-nowrap">
              <input type="radio" name="department" value="Dependent" class="filter-input radio-red" />
              Dependent
            </label>
          </div>
        </div>

      </div>

      <div class="h-px bg-gray-200"></div>

      <div class="px-6 py-4 flex items-center justify-between bg-white">
        <button id="clearFiltersModal" type="button" class="text-[#8B0000] text-sm font-medium hover:underline">
          Clear
        </button>

        <button id="applyFilters" type="button"
          class="bg-[#8B0000] text-white px-8 py-2 rounded-md text-sm font-medium shadow hover:bg-[#760000] transition">
          Save
        </button>
      </div>

    </div>
  </div>

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

    /* =========================
       PATIENT LIST FILTER
    ========================= */
    document.addEventListener("DOMContentLoaded", () => {
      const patientContainer = document.getElementById("patientContainer");
      if (!patientContainer) return;

      const allPatients = Array.from(patientContainer.querySelectorAll(".patient-item"));

      const filterModal = document.getElementById("filterModal");
      const filterPill = document.getElementById("openFilter"); // ✅ highlight this
      const clearFiltersModal = document.getElementById("clearFiltersModal");
      const applyFiltersBtn = document.getElementById("applyFilters");
      const searchInput = document.getElementById("searchInput");
      const clearBtn = document.getElementById("clearBtn");
      const filterButtons = document.querySelectorAll(".filter-btn");

      const scheduledBtnCount = document.querySelector('.filter-btn[data-filter="today"] h3');
      const rescheduledBtnCount = document.querySelector('.filter-btn[data-filter="rescheduled"] h3');
      const allBtnCount = document.querySelector('.filter-btn[data-filter="all"] h3');

      const monthPicker = document.getElementById("monthPicker"); // optional
      const openFilter = document.getElementById("openFilter");
      const searchWrapper = document.getElementById("searchWrapper");
      const searchDivider = document.getElementById("searchDivider");

      // -------------------------
      // STATE
      // -------------------------
      let activeTab = "today";
      let searchKeyword = "";

      let selectedProgram = null;
      let selectedYearLevel = null;
      let selectedSection = null;
      let selectedDepartment = null;

      let nameSort = null; // "az" | "za"
      let dateSort = null; // "asc" | "desc"

      let selectedMonth = null;
      let selectedCalendarYear = null;

      let activeFromDate = "";
      let activeToDate = "";

      // -------------------------
      // MUTUAL EXCLUSION (dept <-> course/year/section)
      // -------------------------
      const deptRadios = [...document.querySelectorAll('input[name="department"]')];
      const courseRadios = [...document.querySelectorAll('input[name="course"]')];
      const yearRadios = [...document.querySelectorAll('input[name="year"]')];
      const sectionRadios = [...document.querySelectorAll('input[name="section"]')];

      const otherRadios = [...courseRadios, ...yearRadios, ...sectionRadios];

      function anyChecked(list) {
        return list.some(i => i.checked);
      }

      function setDisabled(list, disabled) {
        list.forEach(i => {
          i.disabled = disabled;
          i.closest("label")?.classList.toggle("opacity-50", disabled);
          i.closest("label")?.classList.toggle("cursor-not-allowed", disabled);
        });
      }

      function clearChecked(list) {
        list.forEach(i => (i.checked = false));
      }

      function syncMutualExclusion() {
        const deptSelected = anyChecked(deptRadios);
        const otherSelected = anyChecked(otherRadios);

        if (deptSelected) {
          clearChecked(otherRadios);
          setDisabled(otherRadios, true);
          setDisabled(deptRadios, false);
          return;
        }

        if (otherSelected) {
          clearChecked(deptRadios);
          setDisabled(deptRadios, true);
          setDisabled(otherRadios, false);
          return;
        }

        setDisabled(deptRadios, false);
        setDisabled(otherRadios, false);
      }

      [...deptRadios, ...otherRadios].forEach(radio => {
        radio.addEventListener("change", syncMutualExclusion);
      });

      // -------------------------
      // HELPERS
      // -------------------------
      function getInfo(p) {
        const raw = p.querySelector(".patient-info")?.textContent?.trim() || "";
        const parts = raw.split("|").map(s => s.trim());

        return {
          program: parts[0] || "",
          year: parts[1] || "",
          section: parts[2] || "",
          dateStr: parts[3] || "",
          department: parts[4] || p.dataset.department || ""
        };
      }

      function getName(p) {
        return (p.querySelector(".font-semibold")?.textContent || "").trim();
      }

      function getType(p) {
        return p.dataset.type || "";
      }

      const infoLowerIncludes = (val, target) =>
        (val || "").toLowerCase().includes((target || "").toLowerCase());

      // -------------------------
      // FILTER BUTTON STATE (SAVED/APPLIED FILTERS)
      // -------------------------
      function updateFilterButtonState() {
        const hasActiveFilters = !!searchKeyword ||
          !!selectedProgram ||
          !!selectedYearLevel ||
          !!selectedSection ||
          !!selectedDepartment ||
          !!nameSort ||
          !!dateSort ||
          !!activeFromDate ||
          !!activeToDate;

        openFilter?.classList.toggle("filter-active", hasActiveFilters);
      }
      // ✅ LIVE FILTER BUTTON STATE (WHILE CLICKING INSIDE MODAL)
      function updateFilterButtonStateLiveFromModal() {
        if (!filterPill || !filterModal) return;

        const anyRadioChecked = !!filterModal.querySelector('input[type="radio"]:checked');
        const fromHasValue = !!document.getElementById("fromDate")?.value;
        const toHasValue = !!document.getElementById("toDate")?.value;

        // Light up if may pinipili sa modal OR may search OR may applied filters already
        const liveActive = anyRadioChecked || fromHasValue || toHasValue || !!searchKeyword;

        filterPill.classList.toggle("filter-active", liveActive);
      }

      // -------------------------
      // MODAL OPEN/CLOSE
      // -------------------------
      filterPill?.addEventListener("click", (e) => {
        e.preventDefault();
        filterModal?.classList.remove("hidden");
        syncMutualExclusion();

        // show live state immediately when modal opens
        updateFilterButtonStateLiveFromModal();
      });

      filterModal?.addEventListener("click", (e) => {
        if (e.target === filterModal) {
          filterModal.classList.add("hidden");
          // when closing, revert to APPLIED filters state
          updateFilterButtonState();
        }
      });

      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
          filterModal?.classList.add("hidden");
          updateFilterButtonState();
        }
      });

      // LIVE listen to any changes inside modal (radios + dates)
      filterModal?.querySelectorAll("input").forEach(inp => {
        inp.addEventListener("change", updateFilterButtonStateLiveFromModal);
        inp.addEventListener("input", updateFilterButtonStateLiveFromModal); // for date typing
      });

      // Clear search button (ONLY search)
      clearBtn?.addEventListener("click", () => {
        if (!searchInput) return;
        searchInput.value = "";
        searchInput.dispatchEvent(new Event("input"));
      });

      // -------------------------
      // PAGINATION
      // -------------------------
      const pagination = document.getElementById("pagination");
      const pageNumbers = document.getElementById("pageNumbers");
      const prevPageBtn = document.getElementById("prevPage");
      const nextPageBtn = document.getElementById("nextPage");

      const ITEMS_PER_PAGE = 5;
      let currentPage = 1;
      let currentItems = [];

      function renderPagination(items) {
        currentItems = items;
        const totalPages = Math.ceil(items.length / ITEMS_PER_PAGE);

        if (pageNumbers) pageNumbers.innerHTML = "";

        if (totalPages <= 1) {
          pagination?.classList.add("hidden");
          return;
        }
        pagination?.classList.remove("hidden");

        for (let i = 1; i <= totalPages; i++) {
          const btn = document.createElement("button");
          btn.textContent = i;
          btn.className =
            i === currentPage ?
            "px-3 py-1 text-[#8B0000] font-medium" :
            "px-3 py-1 hover:text-[#8B0000]";

          btn.addEventListener("click", () => {
            currentPage = i;
            updatePage();
          });

          pageNumbers?.appendChild(btn);
        }

        if (prevPageBtn) {
          prevPageBtn.disabled = currentPage === 1;
          prevPageBtn.classList.toggle("cursor-not-allowed", currentPage === 1);
          prevPageBtn.classList.toggle("text-gray-300", currentPage === 1);
        }

        if (nextPageBtn) {
          nextPageBtn.disabled = currentPage === totalPages;
          nextPageBtn.classList.toggle("cursor-not-allowed", currentPage === totalPages);
          nextPageBtn.classList.toggle("text-gray-300", currentPage === totalPages);
        }
      }

      function updatePage() {
        const start = (currentPage - 1) * ITEMS_PER_PAGE;
        const end = start + ITEMS_PER_PAGE;

        patientContainer.innerHTML = "";
        currentItems.slice(start, end).forEach(p => patientContainer.appendChild(p));

        renderPagination(currentItems);
      }

      prevPageBtn?.addEventListener("click", () => {
        if (currentPage > 1) {
          currentPage--;
          updatePage();
        }
      });

      nextPageBtn?.addEventListener("click", () => {
        const totalPages = Math.ceil(currentItems.length / ITEMS_PER_PAGE);
        if (currentPage < totalPages) {
          currentPage++;
          updatePage();
        }
      });

      // -------------------------
      // APPLY FILTERS TO LIST
      // -------------------------
      function applyFilters() {
        let data = [...allPatients];

        if (activeTab !== "all") {
          data = data.filter(p => p.classList.contains(activeTab));
        }

        if (searchKeyword) {
          data = data.filter(p => {
            const info = getInfo(p);
            const haystack = `${getName(p)} ${info.program} ${getType(p)} ${info.department}`.toLowerCase();
            return haystack.includes(searchKeyword);
          });
        }

        if (selectedProgram) {
          data = data.filter(p => infoLowerIncludes(getInfo(p).program, selectedProgram));
        }

        if (selectedYearLevel || selectedSection) {
          data = data.filter(p => {
            const info = getInfo(p);
            if (selectedYearLevel && !infoLowerIncludes(info.year, selectedYearLevel)) return false;
            if (selectedSection && String(info.section).trim() !== String(selectedSection).trim()) return false;
            return true;
          });
        }

        if (selectedDepartment) {
          data = data.filter(p => infoLowerIncludes(getInfo(p).department, selectedDepartment));
        }

        if (activeFromDate || activeToDate) {
          data = data.filter(p => {
            const ds = getInfo(p).dateStr;
            const d = ds ? new Date(ds) : null;
            if (!d || isNaN(d.getTime())) return false;

            if (activeFromDate && d < new Date(activeFromDate)) return false;
            if (activeToDate && d > new Date(activeToDate)) return false;

            return true;
          });
        }

        if (selectedMonth && selectedCalendarYear) {
          data = data.filter(p => {
            const ds = getInfo(p).dateStr;
            const d = ds ? new Date(ds) : null;
            if (!d || isNaN(d.getTime())) return false;

            const m = String(d.getMonth() + 1).padStart(2, "0");
            const y = String(d.getFullYear());
            return m === selectedMonth && y === selectedCalendarYear;
          });
        }

        if (nameSort === "az") data.sort((a, b) => getName(a).localeCompare(getName(b)));
        if (nameSort === "za") data.sort((a, b) => getName(b).localeCompare(getName(a)));

        if (dateSort === "asc") data.sort((a, b) => new Date(getInfo(a).dateStr) - new Date(getInfo(b).dateStr));
        if (dateSort === "desc") data.sort((a, b) => new Date(getInfo(b).dateStr) - new Date(getInfo(a).dateStr));

        currentPage = 1;
        renderPagination(data);
        updatePage();
        updateCounts();
        updateFilterButtonState();
      }

      function computeCountForTab(tab) {
        let data = [...allPatients];

        if (tab !== "all") data = data.filter(p => p.classList.contains(tab));

        if (searchKeyword) {
          data = data.filter(p => {
            const info = getInfo(p);
            const haystack = `${getName(p)} ${info.program} ${getType(p)} ${info.department}`.toLowerCase();
            return haystack.includes(searchKeyword);
          });
        }

        if (selectedProgram) data = data.filter(p => infoLowerIncludes(getInfo(p).program, selectedProgram));

        if (selectedYearLevel || selectedSection) {
          data = data.filter(p => {
            const info = getInfo(p);
            if (selectedYearLevel && !infoLowerIncludes(info.year, selectedYearLevel)) return false;
            if (selectedSection && String(info.section).trim() !== String(selectedSection).trim()) return false;
            return true;
          });
        }

        if (selectedDepartment) data = data.filter(p => infoLowerIncludes(getInfo(p).department, selectedDepartment));

        if (activeFromDate || activeToDate) {
          data = data.filter(p => {
            const ds = getInfo(p).dateStr;
            const d = ds ? new Date(ds) : null;
            if (!d || isNaN(d.getTime())) return false;
            if (activeFromDate && d < new Date(activeFromDate)) return false;
            if (activeToDate && d > new Date(activeToDate)) return false;
            return true;
          });
        }

        if (selectedMonth && selectedCalendarYear) {
          data = data.filter(p => {
            const ds = getInfo(p).dateStr;
            const d = ds ? new Date(ds) : null;
            if (!d || isNaN(d.getTime())) return false;
            const m = String(d.getMonth() + 1).padStart(2, "0");
            const y = String(d.getFullYear());
            return m === selectedMonth && y === selectedCalendarYear;
          });
        }

        return data.length;
      }

      function updateCounts() {
        const todayCount = computeCountForTab("today");
        const rescheduledCount = computeCountForTab("rescheduled");
        const allCount = computeCountForTab("all");

        if (scheduledBtnCount) scheduledBtnCount.textContent = todayCount;
        if (rescheduledBtnCount) rescheduledBtnCount.textContent = rescheduledCount;
        if (allBtnCount) allBtnCount.textContent = allCount;
      }

      filterButtons.forEach(btn => {
        btn.addEventListener("click", () => {
          activeTab = btn.dataset.filter;
          applyFilters();
        });
      });

      searchInput?.addEventListener("input", () => {
        searchKeyword = searchInput.value.trim().toLowerCase();
        applyFilters();
      });

      if (monthPicker) {
        monthPicker.addEventListener("change", (e) => {
          if (!e.target.value) {
            selectedMonth = null;
            selectedCalendarYear = null;
          } else {
            const [year, month] = e.target.value.split("-");
            selectedMonth = month;
            selectedCalendarYear = year;
          }
          applyFilters();
        });

        const now = new Date();
        const mm = String(now.getMonth() + 1).padStart(2, "0");
        const yy = String(now.getFullYear());
        monthPicker.value = `${yy}-${mm}`;
        selectedMonth = mm;
        selectedCalendarYear = yy;
      }

      applyFiltersBtn?.addEventListener("click", () => {
        selectedDepartment = filterModal?.querySelector('input[name="department"]:checked')?.value || null;
        selectedProgram = filterModal?.querySelector('input[name="course"]:checked')?.value || null;
        selectedYearLevel = filterModal?.querySelector('input[name="year"]:checked')?.value || null;
        selectedSection = filterModal?.querySelector('input[name="section"]:checked')?.value || null;

        const sortVal = filterModal?.querySelector('input[name="sort"]:checked')?.value || null;
        nameSort = (sortVal === "A-Z" || sortVal === "az") ? "az" :
          (sortVal === "Z-A" || sortVal === "za") ? "za" :
          null;

        // date order radios (Ascending/Descending) -> map to "asc/desc"
        const dateOrderVal = filterModal?.querySelector('input[name="dateOrder"]:checked')?.value || null;
        dateSort = (dateOrderVal === "Ascending" || dateOrderVal === "asc") ? "asc" :
          (dateOrderVal === "Descending" || dateOrderVal === "desc") ? "desc" :
          null;

        activeFromDate = document.getElementById("fromDate")?.value || "";
        activeToDate = document.getElementById("toDate")?.value || "";

        filterModal?.classList.add("hidden");
        syncMutualExclusion();
        applyFilters();
        updateFilterButtonState();
      });

      // -------------------------
      // CLEAR FILTERS
      // -------------------------
      clearFiltersModal?.addEventListener("click", () => {
        // Uncheck all radios inside modal
        filterModal?.querySelectorAll("input[type='radio']").forEach(i => {
          i.checked = false;
          i.disabled = false;
          i.closest("label")?.classList.remove("opacity-50", "cursor-not-allowed");
        });

        // Reset dates
        const from = document.getElementById("fromDate");
        const to = document.getElementById("toDate");
        if (from) from.value = "";
        if (to) to.value = "";

        // Reset state
        selectedDepartment = null;
        selectedProgram = null;
        selectedYearLevel = null;
        selectedSection = null;
        nameSort = null;
        dateSort = null;
        activeFromDate = "";
        activeToDate = "";

        syncMutualExclusion();
        filterModal?.classList.add("hidden");
        applyFilters();
        updateFilterButtonState();
      });

      syncMutualExclusion();
      applyFilters();
    });

    // NOTIFICATION
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

      menu.addEventListener("click", (e) => {
        e.stopPropagation();
      });

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