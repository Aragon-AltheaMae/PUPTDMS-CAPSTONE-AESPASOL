<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Reports</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- daisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Highcharts -->
  <script src="https://code.highcharts.com/highcharts.js"></script>

  <script>
    tailwind.config = {
      daisyui: {
        themes: false,
      },
    }
  </script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
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

<body class="bg-gray-100">

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
      <span class="sidebar-text font-bold opacity-0 w-0 overflow-hidden
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

  <!-- CREATE REPORT BUTTON -->
    <div class="flex justify-center mb-8">
    <button
        onclick="createReportModal.showModal()"
        class="w-full max-w-4xl 
                bg-gradient-to-r from-[#8B0000] to-[#FFD700]
                text-white py-4 rounded-xl
                flex items-center justify-center gap-4
                text-lg font-semibold shadow">
        <span>Create New Report</span>
        <span class="bg-white text-[#8B0000] w-8 h-8 rounded-full flex items-center justify-center leading-none text-xl font-bold">
            +
        </span>
        </button>

    </div>


  <!-- ================= GRID ================= -->
  <div class="grid grid-cols-12 gap-6">

    <!-- GAD REPORT -->
    <div class="col-span-5 bg-white rounded-xl shadow border-2 border-orange-400 p-4 h-[380px] flex flex-col">
      <div class="flex justify-between items-center mb-2">
        <h2 class="text-sm font-semibold text-red-700">GAD Report</h2>
        <span class="text-xs bg-red-700 text-white px-3 py-1 rounded-full">Dec 2025</span>
      </div>
      <div id="gadChart" class="flex-1"></div>
    </div>

    <!-- WEEKLY DENTAL CASES ANALYTICS -->
    <div class="col-span-5 bg-white rounded-xl shadow border-2 border-orange-400 p-4 h-[380px] flex flex-col">

      <!-- TITLE ROW -->
      <div class="flex justify-between items-center mb-2">
        <h2 class="text-sm font-semibold text-red-700">
          Weekly Dental Cases
        </h2>
        <span class="bg-red-700 text-white text-xs px-3 py-1 rounded-full">
          Dec 2025
        </span>
      </div>

      <!-- LINE CHART -->
      <div id="weeklyDentalCasesChart" class="flex-1"></div>

    </div>


    <!-- QUICK REPORT BUTTONS -->
      <div class="col-span-2 flex flex-col gap-6 h-[380px]">

        <!-- DENTAL SERVICES -->
        <a
          href="{{ route('dentist.report.dental-services') }}"
          class="relative flex-1 rounded-xl overflow-hidden
                text-white font-semibold text-lg shadow
                bg-gradient-to-r from-[#8B0000] to-[#660000]
                flex items-center justify-center
                hover:opacity-80 transition">

          <!-- BACKGROUND IMAGE ICON -->
          <img
            src="{{ asset('images/services.png') }}"
            alt="Dental Services Icon"
            class="absolute opacity-10 w-40 h-40 object-contain pointer-events-none" />

          <!-- BUTTON TEXT -->
          <span class="relative z-10">
            Dental Services
          </span>
        </a>

        <!-- DAILY TREATMENT RECORD -->
        <a
          href="{{ route('dentist.report.daily-treatment') }}"
          class="relative flex-1 rounded-xl overflow-hidden
                text-white font-semibold text-lg shadow
                bg-gradient-to-r from-[#8B0000] to-[#660000]
                flex items-center justify-center
                hover:opacity-80 transition">

          <!-- BACKGROUND IMAGE ICON -->
          <img
            src="{{ asset('images/services.png') }}"
            alt="Daily Treatment Icon"
            class="absolute opacity-10 w-40 h-40 object-contain pointer-events-none" />

          <!-- BUTTON TEXT -->
          <span class="relative z-10 text-center leading-tight">
            Daily Treatment<br> Record
          </span>
        </a>

      </div>


    
    <!-- INVENTORY ANALYTICS -->
    <div class="col-span-12 bg-white rounded-xl shadow border-2 border-orange-400 p-6">

    <h2 class="text-lg font-semibold text-red-700 mb-4">
        Inventory Analytics
    </h2>

    <div class="grid grid-cols-12 gap-6 items-center">

        <!-- PIE CHARTS -->
        <div class="col-span-7 grid grid-cols-2 gap-6">

        <!-- MEDICINE PIE -->
        <div>
            <h3 class="text-center font-semibold text-red-700 mb-2">
            Medicine Inventory
            </h3>
            <div id="medicinePieChart" class="h-[260px]"></div>
        </div>

        <!-- SUPPLIES PIE -->
        <div>
            <h3 class="text-center font-semibold text-red-700 mb-2">
            Medical Supplies Inventory
            </h3>
            <div id="suppliesPieChart" class="h-[260px]"></div>
        </div>

        </div>

        <!-- LOW STOCK LIST -->
        <div class="col-span-5">

        <!-- MEDICINE -->
        <h2 class="text-red-700 font-semibold mb-2">Medicine</h2>

        <div class="flex justify-between items-center border-b py-2">
            <span class="text-[#8B0000]"span>Amoxicillin 500mg</span>
            <span class="bg-red-600 text-white text-xs px-4 py-1 rounded-full">
            LOW
            </span>
        </div>

        <div class="flex justify-between items-center border-b py-2">
            <span class="text-[#8B0000]"span>Paracetamol 500mg</span>
            <span class="bg-red-600 text-white text-xs px-4 py-1 rounded-full">
            LOW
            </span>
        </div>

        <div class="flex justify-between items-center border-b py-2">
            <span class="text-[#8B0000]"span>Chlorhexidine Mouthwash</span>
            <span class="bg-red-600 text-white text-xs px-4 py-1 rounded-full">
            LOW
            </span>
        </div>

        <hr class="my-4 border-yellow-400">

        <!-- MEDICAL SUPPLIES -->
        <h2 class="text-red-700 font-semibold mb-2">Medical Supplies</h>

        <div class="flex justify-between items-center border-b py-2">
            <span class="text-[#8B0000]"span>Disposable Dental Needles</span>
            <span class="bg-red-600 text-white text-xs px-4 py-1 rounded-full">
            LOW
            </span>
        </div>

        <div class="flex justify-between items-center border-b py-2">
            <span class="text-[#8B0000]"span>Disposable Mouth Mirrors</span>
            <span class="bg-red-600 text-white text-xs px-4 py-1 rounded-full">
            LOW
            </span>
        </div>

        </div>

         <!-- VIEW INVENTORY BUTTON (CENTERED) -->
        <div class="col-span-12 flex justify-center mt-6">
          <a href="{{ route('dentist.inventory') }}"
            class="px-8 py-3 rounded-lg text-white text-sm font-semibold shadow
                    bg-gradient-to-r from-[#8B0000] to-[#660000]
                    hover:opacity-90 transition w-full max-w-xs text-center">
            View Inventory
          </a>
        </div>

    </div>
    </div>

  </div>
</main>


<dialog id="createReportModal" class="modal">
  <div class="modal-box max-w-4xl border-2 border-blue-400 bg-white">

    <h2 class="text-2xl font-semibold text-[#8B0000] mb-8">
      Create New Report
    </h2>

    <form class="space-y-6" id="reportForm">

      <!-- REPORT NAME -->
      <div class="grid grid-cols-4 items-center gap-4">
        <label class="col-span-1 text-[#8B0000]">Report Name</label>
        <input
          type="text"
          placeholder="Enter Report Name"
          class="col-span-3 input input-bordered w-full border-yellow-400 bg-white focus:outline-none" />
      </div>

      <!-- REPORT TYPE -->
      <div class="grid grid-cols-4 items-center gap-4">
        <label class="col-span-1 text-[#8B0000]">Report Type</label>
        <select
          class="col-span-3 select select-bordered w-full border-yellow-400 bg-white focus:outline-none">
          <option disabled selected>Select Report Type</option>
          <option>GAD Report</option>
          <option>Medicine Supply Report</option>
          <option>Medical Supplies Report</option>
          <option>Daily Treatment Record</option>
          <option>Dental Services Report</option>
        </select>
      </div>

      <!-- DATE RANGE -->
      <div class="grid grid-cols-4 items-center gap-4">
        <label class="col-span-1 text-[#8B0000]">Date Range</label>
        <div class="col-span-3 flex gap-4">
          <input
            type="date"
            class="input input-bordered border-yellow-400 bg-white w-full" />
          <input
            type="date"
            class="input input-bordered border-yellow-400 bg-white w-full" />
        </div>
      </div>

      <!-- QUANTITY -->
      <div class="grid grid-cols-4 items-center gap-4">
        <label class="col-span-1 text-[#8B0000]">Quantity</label>
        <input
          type="number"
          value="0"
          class="col-span-1 input input-bordered border-yellow-400 bg-white w-full" />
      </div>

      <!-- ACTION BUTTONS -->
      <div class="flex justify-end gap-4 pt-6">
        <button
          type="button"
          id="downloadReportBtn"
          class="btn bg-[#8B0000] text-white px-8">
          Download Report
        </button>

        <button
          type="button"
          onclick="createReportModal.close()"
          class="btn bg-gray-700 text-white px-8">
          Back
        </button>
      </div>

    </form>

<!-- DOWNLOAD COMPLETE MODAL -->
<dialog id="downloadCompleteModal" class="modal">
  <div class="modal-box p-0 rounded-2xl overflow-hidden bg-white shadow-2xl max-w-md">

    <!-- Top Accent Bar -->
    <div class="h-2 bg-[#8B0000] w-full"></div>

    <!-- Body -->
    <div class="px-10 py-10 text-center">

      <!-- Title -->
      <h3 class="text-2xl font-bold text-[#8B0000] mb-4">
        Download Complete
      </h3>

      <!-- Message -->
      <p class="text-gray-600 text-base leading-relaxed mb-8">
        Your report has been successfully downloaded.
      </p>

      <!-- Okay Button -->
      <div class="flex justify-center">
        <button
          onclick="closeDownloadModal()"
          class="px-8 py-3 rounded-xl bg-[#8B0000] hover:bg-[#7A0000]
                 text-white font-semibold tracking-wide
                 shadow-md hover:shadow-lg
                 transition-all duration-300">
          Okay
        </button>
      </div>

    </div>
  </div>
</dialog>
    </div>
  </main>
</body>


<!-- ================= SCRIPTS ================= -->
<script>
  // GAD STACKED BAR
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

  Highcharts.chart('weeklyDentalCasesChart', {
    chart: {
      type: 'line'
    },
    title: {
      text: null
    },
    xAxis: {
      categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
      title: {
        text: 'Weeks'
      }
    },
    yAxis: {
      title: {
        text: 'Number of Dental Cases'
      },
      allowDecimals: false
    },
    tooltip: {
      shared: true,
      valueSuffix: ' cases'
    },
    plotOptions: {
      line: {
        marker: {
          enabled: true
        }
      }
    },
    series: [
      {
        name: 'Dental Cleaning',
        data: [12, 15, 9, 14],
        color: '#8B0000'
      },
      {
        name: 'Tooth Extraction',
        data: [5, 7, 6, 8],
        color: '#F59E0B'
      },
      {
        name: 'Consultation',
        data: [8, 10, 11, 13],
        color: '#3B82F6'
      }
    ],
    credits: {
      enabled: false
    }
  });


  const inventory = [
    { category: "Supplies", name: "Disposable Dental Needles", qty: 42, used: 8 },
    { category: "Medicine", name: "Amoxicillin 500mg", qty: 30, used: 5 },
    { category: "Supplies", name: "Latex Examination Gloves", qty: 50, used: 12 },
    { category: "Medicine", name: "Paracetamol 500mg", qty: 40, used: 10 },
    { category: "Supplies", name: "Dental Cotton Rolls", qty: 60, used: 15 },
    { category: "Supplies", name: "Disposable Mouth Mirrors", qty: 25, used: 5 },
    { category: "Medicine", name: "Ibuprofen 400mg", qty: 35, used: 7 },
    { category: "Supplies", name: "Cotton Swabs", qty: 80, used: 20 },
    { category: "Medicine", name: "Chlorhexidine Mouthwash 0.12%", qty: 20, used: 4 },
    { category: "Supplies", name: "Dental Floss Packs", qty: 50, used: 10 }
  ];

  const medicineData = [];
  const suppliesData = [];

  inventory.forEach(item => {
    const remaining = item.qty - item.used;

    if (item.category === "Medicine") {
      medicineData.push({
        name: item.name,
        y: remaining
      });
    }

    if (item.category === "Supplies") {
      suppliesData.push({
        name: item.name,
        y: remaining
      });
    }
  });

  // MEDICINE PIE
  Highcharts.chart('medicinePieChart', {
    chart: { type: 'pie' },
    title: { text: null },
    tooltip: {
      pointFormat: '<b>{point.y}</b> remaining'
    },
    plotOptions: {
      pie: {
        dataLabels: {
          enabled: true,
          format: '{point.name}: {point.y}'
        }
      }
    },
    series: [{
      name: 'Medicine',
      data: medicineData
    }],
    credits: { enabled: false }
  });

  // SUPPLIES PIE
  Highcharts.chart('suppliesPieChart', {
    chart: { type: 'pie' },
    title: { text: null },
    tooltip: {
      pointFormat: '<b>{point.y}</b> remaining'
    },
    plotOptions: {
      pie: {
        dataLabels: {
          enabled: true,
          format: '{point.name}: {point.y}'
        }
      }
    },
    series: [{
      name: 'Medical Supplies',
      data: suppliesData
    }],
    credits: { enabled: false }
  });


  document.getElementById('downloadReportBtn').addEventListener('click', function() {
    // Simulate download (You can replace this with actual download logic)
    setTimeout(function() {
        // Show the "Download Complete" mini tab
        const downloadCompleteTab = document.getElementById('downloadCompleteTab');
        downloadCompleteTab.classList.remove('hidden');

        // Reset the form fields
        const form = document.getElementById('reportForm');
        form.reset(); // This will reset all input fields within the form

        // Hide the "Download Complete" mini tab after 3 seconds
        setTimeout(function() {
            downloadCompleteTab.classList.add('hidden');
        }, 3000); // Hide after 3 seconds
    }, 1000); // Simulating a 1-second download delay
});

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
// DOWNLOAD COMPLETE MODAL LOGIC
  const downloadBtn = document.getElementById("downloadReportBtn");
  const downloadModal = document.getElementById("downloadCompleteModal");

  downloadBtn.addEventListener("click", function () {

    // 👉 Your actual download logic should be here

    // After download completes, show modal
    downloadModal.showModal();
  });

  function closeDownloadModal() {
    downloadModal.close();
  }
</script>

</body>
</html>
