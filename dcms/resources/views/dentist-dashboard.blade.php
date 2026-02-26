<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dentist Dashboard | PUP Taguig Dental Clinic </title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- daisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Cally Calendar -->
  <script type="module" src="https://unpkg.com/cally"></script>

  <!-- Highcharts -->
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  
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

    @keyframes wave {
      0% { transform: rotate(0deg); }
      20% { transform: rotate(14deg); }
      40% { transform: rotate(-8deg); }
      60% { transform: rotate(14deg); }
      80% { transform: rotate(-4deg); }
      100% { transform: rotate(0deg); }
    }

    .wave-hand {
      transform-origin: 70% 70%;
      animation: wave 2.5s ease-in-out infinite;
    }

    /* Smooth slide animation */
    #sidebar {
      transition: width 300ms ease, transform 300ms ease;
      will-change: width, transform;
    }

    #mainContent {
      transition: margin-left 300ms ease;
    }

    .sidebar-link {
      display: flex;
      align-items: center;
      width: 100%;
      padding: 12px;
      border-radius: 12px;
      transition: background-color .2s ease, transform .2s ease;
    }

    /* Tooltip appears ONLY when collapsed */
    .sidebar-link:hover .sidebar-tooltip {
      opacity: 1;
      transform: scale(1);
    }

    /* Hide tooltip when expanded */
    #sidebar[style*="16rem"] .sidebar-tooltip {
    display: none;
    }

    #sidebar[style*="16rem"] .sidebar-link {
      justify-content: flex-start;
    }

    /* consistent icon column width */
    .sidebar-link i{
      width: 24px;           /* fixed width column */
      min-width: 24px;
      text-align: center;
    }

    /* CLOSED: center icon only */
    #sidebar[style*="72px"] .sidebar-link {
      justify-content: center;
      gap: 0;
    }

    /* when expanded, align items nicely */
    #sidebar[style*="16rem"] .sidebar-link{
      justify-content: flex-start;
      gap: 12px;             /* spacing between icon and text */
    }

    #sidebar[style*="16rem"] .sidebar-link:hover {
    transform: translateX(4px);
    }

    .sidebar-link:hover .sidebar-text {
    opacity: 1;
    transform: scale(1);
    }

    .sidebar-text {
      transform-origin: left center;
    }

    /* Notification dropdown animation */
    .notif-open {
      opacity: 1 !important;
      transform: scale(1) !important;
      pointer-events: auto !important;
    }

    .notif-close {
      opacity: 0 !important;
      transform: scale(0.95) !important; /* zoom out */
      pointer-events: none !important;
    }

    /* DARK MODE */
    [data-theme="dark"] body {
    background-color: #111827; /* slate-900 */
    color: #E5E7EB;
    }

    [data-theme="dark"] #sidebar {
      background-color: #1F2933;
    }

    [data-theme="dark"] .bg-white {
      background-color: #1F2937 !important;
    }

    [data-theme="dark"] .text-\[\#333333\] {
      color: #E5E7EB !important;
    }

    body,
    #sidebar,
    main,
    .card {
      transition: background-color 0.3s ease, color 0.3s ease;
    }
  </style>
</head>

<body class="bg-white text-[#333333] font-normal">

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

<aside id="sidebar"
  class="fixed left-0 top-[80px]
         h-[calc(100vh-80px)]
         w-[72px]
         bg-[#FAFAFA]
         drop-shadow-xl
         transition-all duration-300
         flex flex-col justify-between z-40">

  <!-- TOP -->
  <div>
    <div id="sidebarToggleWrapper"
     class="flex items-center justify-center px-4 py-6 transition-all duration-300">
      <button onclick="toggleSidebar()"
        id="sidebarToggleBtn"
        class="w-10 h-10 flex items-center justify-center
              rounded-full text-[#757575] hover:text-[#8B0000]
              hover:bg-[#D9D9D9] transition-all duration-300">
        <i id="sidebarIcon" class="fa-solid fa-bars text-lg"></i>
      </button>
    </div>
    
  <!-- MENU -->
  <nav class="space-y-2 px-3 text-gray-600 text-sm">

    <!-- DASHBOARD -->
    <a href="{{ route('dentist.dashboard') }}"
      class="sidebar-link relative flex items-center  rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
              {{ request()->routeIs('dentist.dashboard')
                ? 'bg-[#8B0000] text-[#F4F4F4]'
                : '' }}">

      <span
        class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000]
              transition-opacity duration-300
              {{ request()->routeIs('dentist.dashboard') ? 'opacity-100' : 'opacity-0' }}">
      </span>

      <i class="fa-solid fa-chart-line text-lg"></i>
      <span class="sidebar-text font-bold opacity-0 w-0 overflow-hidden
            transition-all duration-300 delay-150">
        Dashboard
      </span>

      <span class="sidebar-tooltip
                absolute left-full ml-8
                px-3 py-1
                rounded-full
                bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold
                whitespace-nowrap
                opacity-0 scale-95
                pointer-events-none
                transition-all duration-200
            opacity-0 scale-95 transition-all duration-200">
        Dashboard
      </span>
    </a>

    <!-- PATIENTS -->
    <a href="{{ route('dentist.patients') }}"
      class="sidebar-link relative flex items-center  rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
              {{ request()->routeIs('dentist.patients*')
                ? 'bg-[#8B0000] text-[#F4F4F4]'
                : '' }}">

      <span
        class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000]
              transition-opacity duration-300
              {{ request()->routeIs('dentist.patients*') ? 'opacity-100' : 'opacity-0' }}">
      </span>

      <i class="fa-solid fa-users text-lg"></i>
      <span class="sidebar-text opacity-0 w-0 overflow-hidden
            transition-all duration-300 delay-150">
        Patients
      </span>

      <span class="sidebar-tooltip
                absolute left-full ml-8
                px-3 py-1
                rounded-full
                bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold
                whitespace-nowrap
                opacity-0 scale-95
                pointer-events-none
                transition-all duration-200">
        Patients
      </span>
    </a>

    <!-- APPOINTMENTS -->
    <a href="{{ route('dentist.appointments') }}"
      class="sidebar-link relative flex items-center  rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
              {{ request()->routeIs('dentist.appointments*')
                ? 'bg-[#8B0000] text-[#F4F4F4]'
                : '' }}">

      <span
        class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000]
              transition-opacity duration-300
              {{ request()->routeIs('dentist.appointments*') ? 'opacity-100' : 'opacity-0' }}">
      </span>

      <i class="fa-solid fa-calendar-check text-lg"></i>
      <span class="sidebar-text opacity-0 w-0 overflow-hidden
            transition-all duration-300 delay-150">
        Appointments
      </span>

      <span class="sidebar-tooltip
                absolute left-full ml-8
                px-3 py-1
                rounded-full
                bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold
                whitespace-nowrap
                opacity-0 scale-95
                pointer-events-none
                transition-all duration-200">
        Appointments
      </span>
    </a>

    <!-- Document Requests -->
    <a href="{{ route('dentist.documentrequests') }}"
      class="sidebar-link relative flex items-center  rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
              {{ request()->routeIs('dentist.documentrequests*')
                ? 'bg-[#8B0000] text-[#F4F4F4]'
                : '' }}">

      <span
        class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000]
              transition-opacity duration-300
              {{ request()->routeIs('dentist.documentrequests*') ? 'opacity-100' : 'opacity-0' }}">
      </span>

      <i class="fa-solid fa-file-circle-check text-lg"></i>
      <span class="sidebar-text opacity-0 w-0 overflow-hidden
            transition-all duration-300 delay-150">
        Document Requests
      </span>

      <span class="sidebar-tooltip
                absolute left-full ml-8
                px-3 py-1
                rounded-full
                bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold
                whitespace-nowrap
                opacity-0 scale-95
                pointer-events-none
                transition-all duration-200">
        Document Requests
      </span>
    </a>

    <!-- INVENTORY -->
    <a href="{{ route('dentist.inventory') }}"
      class="sidebar-link relative flex items-center  rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
              {{ request()->routeIs('dentist.inventory*')
                ? 'bg-[#8B0000] text-[#F4F4F4]'
                : '' }}">

      <span
        class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000]
              transition-opacity duration-300
              {{ request()->routeIs('dentist.inventory*') ? 'opacity-100' : 'opacity-0' }}">
      </span>

      <i class="fa-solid fa-box text-lg"></i>
      <span class="sidebar-text opacity-0 w-0 overflow-hidden
            transition-all duration-300 delay-150">
        Inventory
      </span>

      <span class="sidebar-tooltip
                absolute left-full ml-8
                px-3 py-1
                rounded-full
                bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold
                whitespace-nowrap
                opacity-0 scale-95
                pointer-events-none
                transition-all duration-200">
        Inventory
      </span>
    </a>

    <!-- REPORTS -->
    <a href="{{ route('dentist.report') }}"
      class="sidebar-link relative flex items-center  rounded-xl
                transition-all duration-200
                hover:bg-[#8B0000] hover:text-[#F4F4F4]
              {{ request()->routeIs('dentist.report*')
                ? 'bg-[#8B0000] text-[#F4F4F4]'
                : '' }}">

      <span
        class="absolute left-0 top-1/2 -translate-y-1/2
              h-6 w-1 rounded-r bg-[#8B0000]
              transition-opacity duration-300
              {{ request()->routeIs('dentist.report*') ? 'opacity-100' : 'opacity-0' }}">
      </span>

      <i class="fa-solid fa-file text-lg"></i>
      <span class="sidebar-text opacity-0 w-0 overflow-hidden
            transition-all duration-300 delay-150">
        Reports
      </span>

      <span class="sidebar-tooltip
                absolute left-full ml-8
                px-3 py-1
                rounded-full
                bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold
                whitespace-nowrap
                opacity-0 scale-95
                pointer-events-none
                transition-all duration-200">
        Reports
      </span>
    </a>
  </nav>
</div>

  <!-- BOTTOM -->
  <div class="px-3 pb-5 space-y-2">

  <!-- DARK MODE TOGGLE -->
  <button
    id="themeToggle"
    class="sidebar-link relative flex items-center justify-center
          w-full px-2 py-1.5 rounded-xl
          bg-[#7B6CF6] text-[#F4F4F4]
          transition-all duration-200
          hover:scale-105"
    aria-label="Toggle dark mode">

    <i id="themeIcon" class="fa-regular fa-moon text-sm"></i>
    <span class="sidebar-text text-sm opacity-0 w-0 overflow-hidden
               transition-all duration-300 delay-150">
      Dark Mode
    </span>
    <!-- Tooltip (collapsed only) -->
    <span
      class="sidebar-tooltip
            absolute left-full ml-8
            px-3 py-1
            rounded-full
            bg-[#8B0000]
            text-[#F4F4F4] text-sm font-semibold
            whitespace-nowrap
            opacity-0 scale-95
            pointer-events-none
            transition-all duration-200">
      Dark Mode
    </span>
  </button>
    
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button
        class="sidebar-link w-full relative flex items-center px-3 py-2 rounded-xl text-sm
               text-red-600 hover:bg-red-50 transition-all duration-200">
        <i class="fa-solid fa-right-from-bracket text-sm"></i>
        <span class="sidebar-text opacity-0 w-0 overflow-hidden
             transition-all duration-300 delay-150">
          Log out
        </span>
        <span
          class="sidebar-tooltip
                absolute left-full ml-8
                px-3 py-1
                rounded-full
                bg-[#8B0000]
                text-[#F4F4F4] text-sm font-semibold
                whitespace-nowrap
                opacity-0 scale-95
                pointer-events-none
                transition-all duration-200">
          Log out
        </span>
      </button>
    </form>

  </div>
</aside>

<!-- CONTENT -->
<main
  id="mainContent"
  class="flex-1 pt-[100px]
         px-6 pb-10
         w-full
         transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]">

  <div class="max-w-7xl mt-4 mx-auto fade-in">

    <!-- GREETING -->
    <div class="flex justify-between items-center mb-6">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <i class="fa-solid fa-sun text-yellow-400 text-sm"></i>
          <p id="currentDate" class="text-sm text-[#757575]"></p>
        </div>
        <h1 class="text-4xl font-extrabold mb-8 flex items-center gap-3 fade-in">
          <span class="bg-gradient-to-r from-[#660000] to-[#FFD700] bg-clip-text text-transparent">
              Good Morning,
            <span id="dentistName"></span>
            <i class="fa-solid fa-hand text-[#FFD700] wave-hand"></i>
          </span>
        </h1>
      </div>

      <div class="flex items-center gap-3">
        <span class="text-sm">The Dentist is</span>
        <button id="statusBtn" class="btn btn-success rounded-full px-6">IN</button>
      </div>
    </div>

    <!-- ================= GRID ================= -->
    <div class="grid grid-cols-12 gap-6 items-start">

      <!-- GAD ANALYTICS -->
      <div class="col-span-12 lg:col-span-4 card bg-white shadow">
      <div class="card-body">
          <div id="gadChart" class="h-full w-full"></div>
        </div>
      </div>


      <!-- DENTAL STATS COLUMN -->
      <div class="col-span-12 lg:col-span-2 flex flex-col gap-4 h-full">

      <!-- DENTAL CASES -->
      <div class="card bg-[#8B0000] text-white shadow flex-1">
          <div class="card-body p-6 text-center justify-center">
          <p class="text-s">Dental Cases</p>
          <p class="text-4xl font-bold">45</p>
          <p class="text-xs">December 2025</p>
          </div>
      </div>

      <!-- TOTAL APPOINTMENTS -->
      <div class="card bg-white text-red-700 shadow flex-1 border border-gray-200">
          <div class="card-body p-6 text-center justify-center">
          <p class="text-s">Total Appointments</p>
          <p class="text-4xl font-bold">62</p>
          <p class="text-xs">December 2025</p>
          </div>
      </div>

      </div>


      <!-- Calendar Section -->
      <div id="calendarSkeletonContainer" class="col-span-12 lg:col-span-6 flex flex-col text-[#333333] gap-2">

          <!-- Calendar Card -->
          <div class="bg-white border shadow rounded-2xl p-6 w-full">
              <calendar-date class="cally w-full h-full flex flex-col p-2">
              <svg slot="previous" class="fill-current size-4" viewBox="0 0 24 24">
                  <path d="M15.75 19.5 8.25 12l7.5-7.5"/>
              </svg>

              <svg slot="next" class="fill-current size-4" viewBox="0 0 24 24">
                  <path d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
              </svg>

              <calendar-month class="w-full flex-1"></calendar-month>
              </calendar-date>
          </div>

          <!-- Legend -->
          <div class="flex gap-6 mt-3 text-sm justify-center">
              <div class="flex items-center gap-2">
              <span class="w-4 h-4 bg-red-500 rounded"></span> Full Schedule
              </div>
              <div class="flex items-center gap-2">
              <span class="w-4 h-4 bg-orange-400 rounded"></span> Not Available
              </div>
              <div class="flex items-center gap-2">
              <span class="w-4 h-4 bg-blue-500 rounded"></span> Holiday
              </div>
          </div>
      </div>



      <!-- INVENTORY COLUMN -->
      <div class="col-span-5 flex flex-col gap-6">

      <!-- MEDICAL SUPPLY INVENTORY -->
      <div class="relative rounded-lg p-[2px]" style="background: linear-gradient(to bottom, #660000, #FFD700);">
          <div class="card bg-white shadow border border-transparent rounded-lg">
          <div class="card-body">
              <h3 class="font-semibold text-red-700 mb-2 flex items-center gap-2">
              <i class="fa-solid fa-boxes"></i> Medical Supply Inventory
              </h3>
              <table class="table table-sm">
              <thead>
                  <tr class="text-red-700">
                  <th>Supplies</th><th>Units</th><th>Qty</th><th>Consumed</th><th>Balance</th>
                  </tr>
              </thead>
              <tbody>
                  <tr class="text-[#333333]">
                  <td>Disposable Dental Needles Short</td>
                  <td>piece</td>
                  <td>42</td>
                  <td>8</td>
                  <td>34</td>
                  </tr>
              </tbody>
              </table>
              <button class="mt-3 px-6 py-2 rounded-lg font-semibold" style="background-color: #8B0000; color: white; width: fit;">Visit Inventory
              </button>
          </div>
          </div>
      </div>

      <!-- MEDICINE SUPPLY INVENTORY -->
      <div class="relative rounded-lg p-[2px]" style="background: linear-gradient(to bottom, #660000, #FFD700);">
          <div class="card bg-white shadow border border-transparent rounded-lg">
          <div class="card-body">
              <h3 class="font-semibold text-red-700 mb-2 flex items-center gap-2">
              <i class="fa-solid fa-pills"></i> Medicine Supply Inventory
              </h3>
              <table class="table table-sm">
              <thead>
                  <tr class="text-red-700">
                  <th>Medicine</th><th>Form</th><th>Qty</th><th>Used</th><th>Balance</th>
                  </tr>
              </thead>
              <tbody>
                  <tr class="text-[#333333]">
                  <td>Amoxicillin</td>
                  <td>Capsule</td>
                  <td>120</td>
                  <td>30</td>
                  <td>90</td>
                  </tr>
              </tbody>
              </table>
              <!-- CENTERED BUTTON -->
              <button class="mt-3 px-6 py-2 rounded-lg font-semibold" style="background-color: #8B0000; color: white; width: fit;"> Visit Inventory
              </button>
          </div>
          </div>
      </div>
      </div>

      <!-- SCHEDULE -->
      <div class="col-span-7 card bg-gradient-to-b from-[#8B0000] to-[#660000] text-white shadow">
        <div class="card-body">
          <h1 class="text-lg font-bold">Scheduled Patients Today</h1>

          <div class="space-y-3">

            <!-- Patient Card -->
            <button class="flex items-center gap-4 bg-red-800 p-3 rounded-lg w-full transition duration-300 transform hover:scale-105 hover:shadow-lg hover:bg-red-700 focus:outline-none">
              <img src="https://i.pravatar.cc/40" class="rounded-full">
              <div class="flex-1 text-left">
                <p class="font-semibold">Capilitan, Beyonce</p>
                <p class="text-xs opacity-80">Dental Cleaning • 10:00 AM</p>
              </div>
              <i class="fa-solid fa-arrow-right"></i>
            </button>

            <button class="flex items-center gap-4 bg-red-800 p-3 rounded-lg w-full transition duration-300 transform hover:scale-105 hover:shadow-lg hover:bg-red-700 focus:outline-none">
              <img src="https://i.pravatar.cc/40" class="rounded-full">
              <div class="flex-1 text-left">
                <p class="font-semibold">Caculitan, Britney</p>
                <p class="text-xs opacity-80">Dental Cleaning • 10:00 AM</p>
              </div>
              <i class="fa-solid fa-arrow-right"></i>
            </button>

          </div>
        </div>
      </div>
      
    </div>
</main>

    <!-- Footer -->
    <footer class="footer sm:footer-horizontal 
      bg-[#660000] text-[#F4F4F4] p-10">
    </footer>

<!-- ================= SCRIPTS ================= -->
<script>

// =========================
// DARK MODE TOGGLE
// =========================
const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');
const html = document.documentElement;

// Load saved theme
const savedTheme = localStorage.getItem('theme') || 'light';
html.setAttribute('data-theme', savedTheme);
updateThemeIcon(savedTheme);

// Toggle on click
themeToggle.addEventListener('click', () => {
  const currentTheme = html.getAttribute('data-theme');
  const newTheme = currentTheme === 'light' ? 'dark' : 'light';

  html.setAttribute('data-theme', newTheme);
  localStorage.setItem('theme', newTheme);
  updateThemeIcon(newTheme);
});

// Icon switch
function updateThemeIcon(theme) {
  if (theme === 'dark') {
    themeIcon.classList.remove('fa-moon');
    themeIcon.classList.add('fa-sun');
  } else {
    themeIcon.classList.remove('fa-sun');
    themeIcon.classList.add('fa-moon');
  }
}

let sidebarOpen = false;

function applyLayout(sidebarWidth) {
  const sidebar = document.getElementById('sidebar');
  const main = document.getElementById('mainContent');

  sidebar.style.width = sidebarWidth;
  main.style.marginLeft = sidebarWidth;
  main.style.width = `auto`;
}

function toggleSidebar() {
  const toggleWrapper = document.getElementById('sidebarToggleWrapper');
  const toggleBtn = document.getElementById('sidebarToggleBtn');
  const texts = document.querySelectorAll('.sidebar-text');
  const icon = document.getElementById('sidebarIcon');

  sidebarOpen = !sidebarOpen;

  if (sidebarOpen) {
    // EXPAND
    applyLayout('16rem');

    texts.forEach(t => {
      t.classList.remove('opacity-0', 'w-0');
      t.classList.add('opacity-100', 'w-auto');
    });

    toggleWrapper.classList.remove('justify-center');
    toggleWrapper.classList.add('justify-end');

    toggleBtn.classList.add('translate-x-2');
    icon.classList.replace('fa-bars', 'fa-xmark');

  } else {
    // COLLAPSE
    applyLayout('72px');

    texts.forEach(t => {
      t.classList.add('opacity-0', 'w-0');
      t.classList.remove('opacity-100', 'w-auto');
    });

    toggleWrapper.classList.remove('justify-end');
    toggleWrapper.classList.add('justify-center');

    toggleBtn.classList.remove('translate-x-2');
    icon.classList.replace('fa-xmark', 'fa-bars');
  }
}

  // ✅ INITIAL STATE SYNC (CRITICAL FIX)
  document.addEventListener('DOMContentLoaded', () => {
    sidebarOpen = false;        // ensure state is correct
    applyLayout('72px');        // collapsed layout on load
  });

  // Dentist data source (API-ready)
  const dentist = { name: "Dr. Nelson" };

  document.getElementById("dentistName").textContent = dentist.name + "!";

  document.getElementById("currentDate").textContent =
    new Date().toLocaleDateString("en-US", {
      weekday: "long",
      year: "numeric",
      month: "long",
      day: "numeric"
    });

  const statusBtn = document.getElementById("statusBtn");
  statusBtn.addEventListener("click", () => {
    if (statusBtn.textContent === "IN") {
      statusBtn.textContent = "OUT";
      statusBtn.classList.replace("btn-success", "btn-error");
    } else {
      statusBtn.textContent = "IN";
      statusBtn.classList.replace("btn-error", "btn-success");
    }
  });

  // ================= HIGHCHARTS BAR CHART =================
  Highcharts.chart('gadChart', {
    chart: {
      type: 'column',
      backgroundColor: '#ffffff'
    },
    title: {
      text: 'GAD Analytics'
    },
    xAxis: {
      categories: ['Student', 'Administrative', 'Faculty', 'Dependent'],
      title: { text: 'Category' }
    },
    yAxis: {
      min: 0,
      title: { text: 'Number of Cases' }
    },
    series: [
      {
        name: 'Female',
        data: [25, 10, 15, 8], // example data
        color: '#FFC0CB' // baby pink
      },
      {
        name: 'Male',
        data: [20, 15, 12, 10], // example data
        color: '#89CFF0' // baby blue
      }
    ],
    tooltip: {
      shared: true,
      valueSuffix: ' cases'
    },
    plotOptions: {
      column: {
        pointPadding: 0.2,
        borderWidth: 0
      }
    },
    credits: { enabled: false }
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
</script>

</body>
</html>
