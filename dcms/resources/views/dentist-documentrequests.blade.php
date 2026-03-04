<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Document Requests</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter';
    }

    .fade-in {
      animation: fadeIn .4s ease-out both;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(8px); }
      to { opacity: 1; transform: translateY(0); }
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

<body class="bg-gray-100 min-h-screen flex flex-col">

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
      <span class="sidebar-text opacity-0 w-0 overflow-hidden
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
      <span class="sidebar-text font-bold opacity-0 w-0 overflow-hidden
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

<!-- MAIN CONTENT -->
<main
  id="mainContent"
  class="flex-1 pt-[100px]
         px-6 pb-10
         w-full
         transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]">

  <div class="max-w-7xl mt-4 mx-auto fade-in">

  <!-- MAIN WHITE CARD -->
  <div class="bg-white rounded-3xl shadow-xl p-8 border border-[#8B0000]/30">

    <!-- HEADER ROW -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
      <h2 class="text-2xl font-bold bg-gradient-to-r from-red-600 to-orange-400 bg-clip-text text-transparent">
        Document Requests
      </h2>

      <!-- SEARCH / FILTER -->
      <div class="flex items-center gap-6 w-full md:w-auto">
        <div class="flex items-center bg-gradient-to-r from-[#8B0000] to-[#F2C94C] p-[2px] rounded-full w-full md:w-auto">
          <div class="flex items-center bg-white rounded-full overflow-hidden w-full">

            <div class="flex items-center gap-2 pl-3 pr-5 py-2 flex-1">
              <span class="w-7 h-7 rounded-full bg-[#8B0000] flex items-center justify-center">
                <i class="fa-solid fa-magnifying-glass text-white text-[11px]"></i>
              </span>

              <input
                type="text"
                placeholder="Search"
                class="w-full md:w-72 bg-transparent text-sm text-gray-700 placeholder:text-gray-300 focus:outline-none"
              />
            </div>

            <div class="w-[2px] self-stretch bg-[#F2C94C]"></div>

            <button
              type="button"
              class="flex items-center gap-2 px-6 py-2 text-sm font-medium text-[#8B0000] bg-white hover:bg-[#FFF7E6]"
            >
              <i class="fa-solid fa-sliders text-[13px]"></i>
              <span>Filter</span>
            </button>

          </div>
        </div>

        <button class="text-[#8B0000] text-sm font-medium hover:underline">
          Clear
        </button>
      </div>
    </div>

    <!-- TABS CONTAINER -->
    <div class="mx-4 border border-gray-200 rounded-2xl bg-white overflow-hidden">

      <div class="flex gap-4 flex-wrap px-4 pt-4 -mb-px">

        <!-- ALL -->
        <button class="bg-[#8B0000] text-white rounded-t-2xl rounded-b-none px-7 py-6 w-[210px] text-left shadow">
          <h3 class="text-4xl font-medium mb-2">9</h3>
          <p class="text-base">All Requests</p>
        </button>

        <!-- PENDING -->
        <button class="bg-[#660000] text-white/75 rounded-t-2xl rounded-b-none px-7 py-6 w-[210px] text-left shadow">
          <h3 class="text-4xl font-medium mb-2">3</h3>
          <p class="text-base">Pending Requests</p>
        </button>

        <!-- APPROVED -->
        <button class="bg-[#660000] text-white/75 rounded-t-2xl rounded-b-none px-7 py-6 w-[210px] text-left shadow">
          <h3 class="text-4xl font-medium mb-2">3</h3>
          <p class="text-base">Approved Requests</p>
        </button>

        <!-- REJECTED -->
        <button class="bg-[#660000] text-white/75 rounded-t-2xl rounded-b-none px-7 py-6 w-[210px] text-left shadow">
          <h3 class="text-4xl font-medium mb-2">3</h3>
          <p class="text-base">Rejected Requests</p>
        </button>

      </div>

      <!-- SECTION LABEL -->
      <div class="px-6 py-4 text-[22px] font-medium text-gray-700">
        Click to Access Document Request
      </div>

      <!-- REQUEST LIST -->
      <div class="space-y-4 px-6 pb-6">

        <!-- APPROVED -->
        <div class="relative bg-[#EAEAEA] border border-gray-300 rounded-md shadow-sm">
          <div class="absolute left-0 top-0 h-full w-2 bg-green-600 rounded-l-md"></div>

          <div class="flex items-center w-full px-6 py-6 pl-10">
            <div class="grid grid-cols-12 gap-6 items-center w-full">

              <div class="col-span-3">
                <p class="text-[#8B0000] font-semibold">Capilitan, Beyonce</p>
                <p class="text-sm text-gray-600">BSIT 3-1</p>
              </div>

              <div class="col-span-3">
                <p class="text-xs text-gray-400">Date Requested</p>
                <p class="font-medium">December 25, 2025</p>
              </div>

              <div class="col-span-3">
                <p class="text-xs text-gray-400">Document</p>
                <p class="font-medium">Dental Clearance</p>
              </div>

              <div class="col-span-2">
                <p class="text-xs text-gray-400">Status</p>
                <p class="font-semibold text-green-600">APPROVED</p>
              </div>

              <div class="col-span-1 flex justify-end">
                <button class="bg-[#8B0000] text-white px-4 py-1 rounded-md hover:bg-[#760000]">
                  View
                </button>
              </div>

            </div>
          </div>
        </div>

        <!-- PENDING -->
        <div class="relative bg-[#EAEAEA] border border-gray-300 rounded-md shadow-sm">
          <div class="absolute left-0 top-0 h-full w-2 bg-orange-500 rounded-l-md"></div>

          <div class="flex items-center w-full px-6 py-6 pl-10">
            <div class="grid grid-cols-12 gap-6 items-center w-full">

              <div class="col-span-3">
                <p class="text-[#8B0000] font-semibold">Romero, Dianna</p>
                <p class="text-sm text-gray-600">Faculty</p>
              </div>

              <div class="col-span-3">
                <p class="text-xs text-gray-400">Date Requested</p>
                <p class="font-medium">December 25, 2025</p>
              </div>

              <div class="col-span-3">
                <p class="text-xs text-gray-400">Document</p>
                <p class="font-medium">Annual Dental Clearance</p>
              </div>

              <div class="col-span-2">
                <p class="text-xs text-gray-400">Status</p>
                <p class="font-semibold text-orange-500">PENDING</p>
              </div>

              <div class="col-span-1 flex justify-end">
                <button class="bg-[#8B0000] text-white px-4 py-1 rounded-md hover:bg-[#760000]">
                  View
                </button>
              </div>

            </div>
          </div>
        </div>

        <!-- REJECTED -->
        <div class="relative bg-[#EAEAEA] border border-gray-300 rounded-md shadow-sm">
          <div class="absolute left-0 top-0 h-full w-2 bg-red-600 rounded-l-md"></div>

          <div class="flex items-center w-full px-6 py-6 pl-10">
            <div class="grid grid-cols-12 gap-6 items-center w-full">

              <div class="col-span-3">
                <p class="text-[#8B0000] font-semibold">Lopez, Hoshea</p>
                <p class="text-sm text-blue-600 underline">Administrative</p>
              </div>

              <div class="col-span-3">
                <p class="text-xs text-gray-400">Date Requested</p>
                <p class="font-medium">December 25, 2025</p>
              </div>

              <div class="col-span-3">
                <p class="text-xs text-gray-400">Document</p>
                <p class="font-medium">Dental Health Record</p>
              </div>

              <div class="col-span-2">
                <p class="text-xs text-gray-400">Status</p>
                <p class="font-semibold text-red-600">REJECTED</p>
              </div>

              <div class="col-span-1 flex justify-end">
                <button class="bg-[#8B0000] text-white px-4 py-1 rounded-md hover:bg-[#760000]">
                  View
                </button>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Pagination -->
  <div class="flex items-center justify-center gap-4 mt-8 text-sm">
    <span class="text-gray-300">‹ Previous</span>
    <span class="text-[#8B0000] font-semibold">1</span>
    <span>2</span>
    <span>3</span>
    <span>…</span>
    <span>50</span>
    <button class="text-[#8B0000] hover:underline">Next ›</button>
  </div>
</main>

  <!-- Footer -->
    <footer class="footer sm:footer-horizontal mt-auto
      bg-[#660000] text-[#F4F4F4] p-10">
    </footer>

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
