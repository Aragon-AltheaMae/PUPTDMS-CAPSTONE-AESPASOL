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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Inter'; }

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
      <span class="sidebar-text font-bold opacity-0 w-0 overflow-hidden
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
  class="pt-[100px]
         px-6 py-10
         w-full
         transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]">

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

      <!-- ✅ UPDATED SEARCH BAR DESIGN (matches your screenshot) -->
      <div class="flex items-center gap-6 w-full md:w-auto">
        <div class="flex items-center bg-gradient-to-r from-[#8B0000] to-[#F2C94C] p-[2px] rounded-full w-full md:w-auto">
          <div class="flex items-center bg-white rounded-full overflow-hidden w-full">

            <!-- left: search -->
            <div class="flex items-center gap-2 pl-3 pr-5 py-2 flex-1">
              <span class="w-7 h-7 rounded-full bg-[#8B0000] flex items-center justify-center">
                <i class="fa-solid fa-magnifying-glass text-white text-[11px]"></i>
              </span>

              <input
                id="searchInput"
                type="text"
                placeholder="Search"
                class="w-full md:w-72 bg-transparent text-sm text-gray-700 placeholder:text-gray-300 focus:outline-none"
              />
            </div>

            <!-- divider -->
            <div class="w-[2px] self-stretch bg-[#F2C94C]"></div>

            <!-- right: filter -->
            <button
              id="openFilter"
              type="button"
              class="flex items-center gap-2 px-6 py-2 text-sm font-medium text-[#8B0000] bg-white hover:bg-[#FFF7E6] active:bg-[#FFEFC8]"
            >
              <i class="fa-solid fa-sliders text-[13px]"></i>
              <span>Filter</span>
            </button>

          </div>
        </div>

        <!-- Clear -->
        <button id="clearBtn" type="button" class="text-[#8B0000] text-sm font-medium hover:underline">
          Clear
        </button>
      </div>
    </div>

    <div class="w-full max-w-6xl mx-auto">

      <!-- Tabs -->
      <div class="mx-4">
        <div class="mx-4 relative">

        <!-- TABS (FLOATING / OVERLAPPING) -->
        <div class="flex gap-4 px-6 relative z-20">

          <!-- TODAY -->
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

          <!-- RESCHEDULED -->
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

          <!-- ALL -->
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

          <!-- Patient Container -->
          <div
            id="patientContainer"
            class="space-y-4 px-6 pb-6 pt-14 -mt-8 rounded-t-none">
            
          <!-- Patient Card 1 -->
          <a href="/dentist/patient"
          class="patient-item today block relative bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition cursor-pointer">

          <!-- Accent bar -->
          <div class="absolute left-0 top-0 h-full w-[6px] bg-[#2E2E2E] rounded-l-xl"></div>

          <div class="flex items-center gap-6 px-8 py-6 pl-12">

            <!-- Avatar -->
            <img
              src="https://i.pravatar.cc/80"
              class="w-16 h-16 rounded-full object-cover shadow"
              alt="Patient"
            />

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

          <!-- Patient Card 2 -->
          <a href="/dentist/patient"
            class="patient-item today block relative bg-white border border-gray-200 rounded-xl  shadow-sm hover:shadow-md transition cursor-pointer">

            <!-- Left accent bar -->
            <div class="absolute left-0 top-0 h-full w-[6px] bg-[#2E2E2E] rounded-l-xl"></div>

            <div class="flex items-center w-full px-8 py-6 pl-12 gap-6">

              <!-- Avatar -->
              <img
                src="https://i.pravatar.cc/52"
                class="w-16 h-16 rounded-full object-cover shadow"
                alt="Patient"
              />

              <!-- Main content -->
              <div class="flex-1 grid grid-cols-12 items-center gap-6">

                <!-- Name + ID -->
                <div class="col-span-4 leading-tight">
                  <p class="font-semibold text-[#333333] text-sm">
                    Dela Cruz, Mark
                  </p>
                  <p class="text-gray-500 text-xs">
                    2023-00011 · BSECE · 1st Year · Section 2
                  </p>
                  <span class="patient-info hidden">BSECE|1st Year|2|2025-01-20</span>
                </div>

                <!-- DATE AND TIME -->
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

                <!-- SERVICE -->
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

                <!-- Arrow -->
                <div class="col-span-1 flex justify-end items-center">
                  <i class="fa-solid fa-arrow-right text-[#8B0000] text-lg"></i>
                </div>

              </div>
            </div>
          </a>

        <!-- Patient Card 3 -->
          <a href="/dentist/patient"
            class="patient-item today block relative bg-white border border-gray-200 rounded-xl  shadow-sm hover:shadow-md transition cursor-pointer">

            <!-- Left accent bar -->
            <div class="absolute left-0 top-0 h-full w-[6px] bg-[#2E2E2E] rounded-l-xl"></div>

            <div class="flex items-center w-full px-8 py-6 pl-12 gap-6">

              <!-- Avatar -->
              <img
                src="https://i.pravatar.cc/52"
                class="w-16 h-16 rounded-full object-cover shadow"
                alt="Patient"
              />

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
            alt="Patient"
          />

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
            alt="Patient"
          />

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
            alt="Patient"
          />

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
                disabled
              >
                <span>‹</span> Previous
              </button>

              <div id="pageNumbers" class="flex items-center gap-2"></div>

              <button
                id="nextPage"
                class="flex items-center gap-1 px-2 py-1 text-[#8B0000] hover:underline"
              >
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
  <div class="bg-white w-[760px] rounded-xl shadow-2xl overflow-hidden border border-gray-200">
    <!-- Header -->
    <div class="px-6 py-4 flex items-center gap-3">
      <i class="fa-solid fa-sliders text-[#8B0000]"></i>
      <h2 class="text-xl font-medium text-[#8B0000]">Filter</h2>
    </div>
    <div class="h-px bg-gray-200"></div>

    <div class="px-6 py-5 space-y-5">

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

      <!-- Date Range + (Ascending/Descending on the right like screenshot) -->
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
                  class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-200"
                />
              </div>

              <div class="space-y-2">
                <label class="text-sm text-gray-700">To:</label>
                <input
                  type="date"
                  id="toDate"
                  class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-200"
                />
              </div>
            </div>
          </div>

          <!-- Right radios (visual only; DOES NOT affect your JS unless you want it to) -->
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
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSIT" class="filter-input radio-red"/> BSIT</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSECE" class="filter-input radio-red"/> BSECE</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSBA - HRM" class="filter-input radio-red"/> BSBA - HRM</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSED - ENG" class="filter-input radio-red"/> BSED - ENG</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSOA" class="filter-input radio-red"/> BSOA</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSPSYCH" class="filter-input radio-red"/> BSPSYCH</label>

          <label class="flex items-center gap-3"><input type="radio" name="course" value="DIT" class="filter-input radio-red"/> DIT</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSME" class="filter-input radio-red"/> BSME</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSBA - MM" class="filter-input radio-red"/> BSBA - MM</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="BSED - MATH" class="filter-input radio-red"/> BSED - MATH</label>
          <label class="flex items-center gap-3"><input type="radio" name="course" value="DOMT" class="filter-input radio-red"/> DOMT</label>
        </div>
      </div>

      <div class="h-px bg-gray-200"></div>

      <!-- Year + Section -->
      <div class="grid grid-cols-12 gap-10">
        <!-- Year -->
        <div class="col-span-6 space-y-3">
          <p class="text-sm text-gray-500">Year</p>
          <div class="grid grid-cols-2 gap-y-3 text-sm text-gray-700">
            <label class="flex items-center gap-3"><input type="radio" name="year" value="1st Year" class="filter-input radio-red"/> 1st Year</label>
            <label class="flex items-center gap-3"><input type="radio" name="year" value="3rd Year" class="filter-input radio-red"/> 3rd Year</label>
            <label class="flex items-center gap-3"><input type="radio" name="year" value="2nd Year" class="filter-input radio-red"/> 2nd Year</label>
            <label class="flex items-center gap-3"><input type="radio" name="year" value="4th Year" class="filter-input radio-red"/> 4th Year</label>
          </div>
        </div>

        <!-- Section -->
        <div class="col-span-6 space-y-3">
          <p class="text-sm text-gray-500">Section</p>
          <div class="space-y-3 text-sm text-gray-700">
            <label class="flex items-center gap-3"><input type="radio" name="section" value="1" class="filter-input radio-red"/> 1</label>
            <label class="flex items-center gap-3"><input type="radio" name="section" value="2" class="filter-input radio-red"/> 2</label>
          </div>
        </div>
      </div>

    </div>

    <div class="h-px bg-gray-200"></div>

    <!-- Footer actions -->
    <div class="px-6 py-4 flex items-center justify-between">
      <button id="clearFiltersModal" type="button" class="text-[#8B0000] text-sm font-medium hover:underline">
        Clear
      </button>

      <!-- keep id="applyFilters" so your JS still works -->
      <button id="applyFilters" type="button"
        class="bg-[#8B0000] text-white px-8 py-2 rounded-md text-sm font-medium shadow hover:bg-[#760000]">
        Save
      </button>
    </div>
  </div>
</div>


<!-- Footer -->
<footer class="footer sm:footer-horizontal bg-[#660000] text-[#F4F4F4] p-10">
  <!-- Footer content here (unchanged) -->
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

document.addEventListener("DOMContentLoaded", () => {
  const patientContainer = document.getElementById("patientContainer");
  if (!patientContainer) return;

  const allPatients = Array.from(patientContainer.querySelectorAll(".patient-item"));

  const filterModal = document.getElementById("filterModal");
  const openFilter = document.getElementById("openFilter");
  const clearFiltersModal = document.getElementById("clearFiltersModal");
  const applyFilters = document.getElementById("applyFilters");
  const searchInput = document.getElementById("searchInput");
  const clearBtn = document.getElementById("clearBtn");
  const filterButtons = document.querySelectorAll(".filter-btn");

  const scheduledBtnCount = document.querySelector('.filter-btn[data-filter="today"] h3');
  const rescheduledBtnCount = document.querySelector('.filter-btn[data-filter="rescheduled"] h3');
  const allBtnCount = document.querySelector('.filter-btn[data-filter="all"] h3');

  // --- State
  let activeTab = "today";
  let activeSearch = "";
  let activeSort = null;
  let activeCourse = null;
  let activeYear = null;
  let activeSection = null;
  let activeFromDate = "";
  let activeToDate = "";

  // Modal open/close
  openFilter?.addEventListener("click", (e) => {
    e.preventDefault();
    filterModal.classList.remove("hidden");
  });

  filterModal?.addEventListener("click", (e) => {
    if (e.target === filterModal) filterModal.classList.add("hidden");
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") filterModal.classList.add("hidden");
  });

  // Clear button next to search (clears ONLY search text)
  clearBtn?.addEventListener("click", () => {
    if (!searchInput) return;
    searchInput.value = "";
    searchInput.dispatchEvent(new Event("input"));
  });

  function getInfo(p) {
    const raw = p.querySelector(".patient-info")?.textContent?.trim() || "";
    const parts = raw.split("|");
    return {
      course: parts[0] || "",
      year: parts[1] || "",
      section: parts[2] || "",
      dateStr: parts[3] || ""
    };
  }

  function getName(p) {
    return (p.querySelector(".font-semibold")?.textContent || "").trim();
  }

  function passesFilters(p, tabOverride = null) {
    const tabToUse = tabOverride ?? activeTab;

    if (tabToUse !== "all" && !p.classList.contains(tabToUse)) return false;

    if (activeSearch) {
      const name = getName(p).toLowerCase();
      if (!name.includes(activeSearch)) return false;
    }

    const info = getInfo(p);

    if (activeCourse && !info.course.includes(activeCourse)) return false;
    if (activeYear && !info.year.includes(activeYear)) return false;
    if (activeSection && info.section !== activeSection) return false;

    if (activeFromDate || activeToDate) {
      const d = info.dateStr ? new Date(info.dateStr) : null;
      if (!d || isNaN(d.getTime())) return false;

      if (activeFromDate && d < new Date(activeFromDate)) return false;
      if (activeToDate && d > new Date(activeToDate)) return false;
    }

    return true;
  }

  // -------------------------
  // 🔢 PAGINATION
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

    pageNumbers.innerHTML = "";

    // Hide pagination if not needed
    if (totalPages <= 1) {
      pagination.classList.add("hidden");
      return;
    }
    pagination.classList.remove("hidden");

    for (let i = 1; i <= totalPages; i++) {
      const btn = document.createElement("button");
      btn.textContent = i;
      btn.className =
        i === currentPage
          ? "px-3 py-1 text-[#8B0000] font-medium"
          : "px-3 py-1 hover:text-[#8B0000]";

      btn.addEventListener("click", () => {
        currentPage = i;
        updatePage();
      });

      pageNumbers.appendChild(btn);
    }

    prevPageBtn.disabled = currentPage === 1;
    prevPageBtn.classList.toggle("cursor-not-allowed", currentPage === 1);
    prevPageBtn.classList.toggle("text-gray-300", currentPage === 1);

    nextPageBtn.disabled = currentPage === totalPages;
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


  function applyAll() {
    let filtered = allPatients.filter(p => passesFilters(p));

    if (activeSort) {
      filtered.sort((a, b) => {
        const nameA = getName(a).toUpperCase();
        const nameB = getName(b).toUpperCase();
        return activeSort === "A-Z"
          ? nameA.localeCompare(nameB)
          : nameB.localeCompare(nameA);
      });
    }

    currentPage = 1;
    renderPagination(filtered);
    updatePage();
    updateCounts();

  }

  function updateCounts() {
    const todayCount = allPatients.filter(p => passesFilters(p, "today")).length;
    const rescheduledCount = allPatients.filter(p => passesFilters(p, "rescheduled")).length;

    const prevTab = activeTab;
    activeTab = "all";
    const allCount = allPatients.filter(p => passesFilters(p, "all")).length;
    activeTab = prevTab;

    if (scheduledBtnCount) scheduledBtnCount.textContent = todayCount;
    if (rescheduledBtnCount) rescheduledBtnCount.textContent = rescheduledCount;
    if (allBtnCount) allBtnCount.textContent = allCount;
  }

  // -------------------------
  // TAB CLICK (FILTER LOGIC)
  // -------------------------
  filterButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      activeTab = btn.dataset.filter;
      applyAll();
    });
  });

  // -------------------------
  // TAB COLOR UI (NEW – SAFE)
  // -------------------------
  const setActiveTabUI = (btn) => {
    btn.classList.remove("bg-[#660000]", "text-white/75");
    btn.classList.add("bg-[#8B0000]", "text-white");
  };

  const setInactiveTabUI = (btn) => {
    btn.classList.remove("bg-[#8B0000]", "text-white");
    btn.classList.add("bg-[#660000]", "text-white/75");
  };

  // Default active tab = TODAY
  const defaultTab = document.querySelector('.filter-btn[data-filter="today"]');
  if (defaultTab) setActiveTabUI(defaultTab);

  filterButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      filterButtons.forEach(setInactiveTabUI);
      setActiveTabUI(btn);
    });
  });


  // Live search
  searchInput?.addEventListener("input", () => {
    activeSearch = searchInput.value.trim().toLowerCase();
    applyAll();
  });

  // Apply filters in modal
  applyFilters?.addEventListener("click", () => {
    activeSort = filterModal.querySelector('input[name="sort"]:checked')?.value || null;
    activeCourse = filterModal.querySelector('input[name="course"]:checked')?.value || null;
    activeYear = filterModal.querySelector('input[name="year"]:checked')?.value || null;
    activeSection = filterModal.querySelector('input[name="section"]:checked')?.value || null;
    activeFromDate = document.getElementById("fromDate").value || "";
    activeToDate = document.getElementById("toDate").value || "";

    filterModal.classList.add("hidden");
    applyAll();
  });

  // Clear filters in modal
  clearFiltersModal?.addEventListener("click", () => {
    filterModal.querySelectorAll(".filter-input").forEach(i => i.checked = false);
    document.getElementById("fromDate").value = "";
    document.getElementById("toDate").value = "";

    activeSort = null;
    activeCourse = null;
    activeYear = null;
    activeSection = null;
    activeFromDate = "";
    activeToDate = "";

    filterModal.classList.add("hidden");
    applyAll();
  });

  // Initial render
  applyAll();
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
