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

    :root{
    --maroon:#7b0000;
    --maroon-dark:#5d0000;
    --border:#d9d9d9;
    --bg:#f6f6f6;
    --text:#2b2b2b;
    --muted:#8a8a8a;
    --label:#8b0000;
    --pending:#ff8c1a;
    --approved:#1f9d4a;
    --rejected:#d80000;
  }

  .dr-page{
    max-width: 1200px;
    margin: 28px auto;
    padding: 0 16px 32px;
    color: var(--text);
    font-family: Arial, Helvetica, sans-serif;
  }

  /* Top bar */
  .dr-topbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    margin-bottom: 14px;
  }
  .dr-title{
    margin:0;
    font-size: 34px;
    font-weight: 800;
    color: #8b1a0e;
  }

  .dr-btn{
    border:none;
    cursor:pointer;
    border-radius: 6px;
    padding: 10px 16px;
    font-weight: 700;
  }
  .dr-btn-generate{
    background: var(--maroon);
    color:#fff;
    box-shadow: 0 2px 6px rgba(0,0,0,.18);
  }
  .dr-btn-generate:hover{ background: var(--maroon-dark); }

  /* Controls row */
  .dr-controls{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    gap: 18px;
    margin-bottom: 14px;
    flex-wrap:wrap;
  }

  /* Stat cards */
  .dr-stats{
    display:flex;
    gap: 14px;
    flex-wrap:wrap;
  }
  .dr-stat{
    width: 160px;
    height: 84px;
    background: var(--maroon);
    color:#fff;
    border-radius: 6px;
    padding: 12px 14px;
    display:flex;
    flex-direction:column;
    justify-content:center;
  }
  .dr-stat-num{ font-size: 34px; font-weight: 900; line-height: 1; }
  .dr-stat-label{ margin-top: 6px; font-size: 13px; opacity:.95; }

  /* Search/Filter */
  .dr-searchbar{
    display:flex;
    align-items:center;
    gap: 14px;
  }
  .dr-searchgroup{
    display:flex;
    align-items:center;
    border: 2px solid #f0b43a;
    border-radius: 24px;
    overflow:hidden;
    background:#fff;
    min-width: 420px;
    height: 42px;
  }
  .dr-searchicon{
    width: 44px;
    height: 42px;
    display:flex;
    align-items:center;
    justify-content:center;
    background: var(--maroon);
    color:#fff;
    font-size: 16px;
  }
  .dr-searchinput{
    flex:1;
    border:none;
    outline:none;
    padding: 0 12px;
    height: 42px;
    font-weight: 600;
  }
  .dr-btn-filter{
    height: 42px;
    background:#fff;
    color: #8b1a0e;
    border-left: 2px solid #f0b43a;
    border-radius: 0;
    padding: 0 18px;
    font-weight: 800;
  }
  .dr-clear{
    background: transparent;
    border:none;
    cursor:pointer;
    font-weight: 800;
    color:#8b1a0e;
  }

  /* List wrapper */
  .dr-listwrap{
    border: 1px solid var(--border);
    border-radius: 6px;
    background:#fff;
    padding: 14px;
  }

  /* Request row */
  .dr-row{
    position:relative;
    display:flex;
    align-items:center;
    gap: 18px;
    background: #ececec;
    border-radius: 6px;
    padding: 16px 16px 16px 0;
    margin-bottom: 12px;
  }
  .dr-row:last-child{ margin-bottom:0; }

  .dr-accent{
    width: 8px;
    height: 100%;
    border-radius: 6px 0 0 6px;
  }
  .dr-accent-green{ background: #00c853; }
  .dr-accent-orange{ background: #ff9f2d; }
  .dr-accent-red{ background: #d80000; }

  .dr-col{ min-width: 170px; }
  .dr-col-name{ min-width: 230px; padding-left: 12px; }
  .dr-name{ font-weight: 900; font-size: 18px; }
  .dr-sub{ margin-top: 4px; font-weight: 700; color:#4a4a4a; }
  .dr-link{ color:#1a66ff; text-decoration:none; font-weight:800; }

  .dr-meta-label{
    font-size: 12px;
    font-weight: 900;
    color: var(--label);
    margin-bottom: 6px;
  }
  .dr-meta-value{
    font-size: 15px;
    font-weight: 800;
    color:#2d2d2d;
  }

  .dr-col-status{ min-width: 140px; }
  .dr-status{
    font-weight: 900;
    letter-spacing: .5px;
  }
  .dr-status-approved{ color: var(--approved); }
  .dr-status-pending{ color: var(--pending); }
  .dr-status-rejected{ color: var(--rejected); }

  .dr-col-action{
    margin-left:auto;
    min-width: 110px;
    display:flex;
    justify-content:flex-end;
    padding-right: 10px;
  }
  .dr-btn-view{
    background: var(--maroon);
    color:#fff;
    padding: 10px 18px;
    border-radius: 6px;
  }
  .dr-btn-view:hover{ background: var(--maroon-dark); }

  /* Pagination */
  .dr-pagination{
    display:flex;
    align-items:center;
    justify-content:center;
    gap: 10px;
    margin-top: 16px;
    color:#5a5a5a;
  }
  .dr-pagebtn{
    border:none;
    background:transparent;
    cursor:pointer;
    font-weight: 800;
    padding: 6px 10px;
    border-radius: 6px;
  }
  .dr-pagebtn:disabled{ opacity:.4; cursor:not-allowed; }
  .dr-pagebtn-active{ color: #8b1a0e; }
  .dr-ellipsis{ padding: 0 6px; font-weight: 900; }
  .dr-next{
    border:none;
    background:transparent;
    cursor:pointer;
    font-weight: 900;
    color:#8b1a0e;
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
  <div class="px-2 md:px-6">

    <!-- Title + Generate + Search/Filter (same vibe as Patient List) -->
    <div class="flex flex-col gap-4 mb-6">
      <!-- Header Section -->
      <div class="flex flex-col md:flex-row md:justify-between gap-6 mb-6">

        <!-- LEFT SIDE -->
        <div>
          <h2 class="text-3xl font-bold text-[#8B0000]">Document Requests</h2>
          <p class="text-gray-500 mt-1">Review and manage requested documents</p>
        </div>

        <!-- RIGHT SIDE (Button + Search stacked) -->
        <div class="flex flex-col items-end gap-4 w-full md:w-auto">

          <!-- Generate Button -->
          <button
            type="button"
            class="bg-[#8B0000] text-white px-6 py-2 rounded-md text-sm font-medium shadow hover:bg-[#760000] active:scale-[0.99]"
          >
            + Generate Document
          </button>

          <!-- Search + Filter + Clear -->
          <div class="flex items-center gap-4 w-full md:w-auto">

            <div class="flex items-center bg-gradient-to-r from-[#8B0000] to-[#F2C94C] p-[2px] rounded-full w-full md:w-auto">
              <div class="flex items-center bg-white rounded-full overflow-hidden w-full">

                <!-- Search -->
                <div class="flex items-center gap-2 pl-3 pr-6 py-2 flex-1">
                  <span class="w-7 h-7 rounded-full bg-[#8B0000] flex items-center justify-center">
                    <i class="fa-solid fa-magnifying-glass text-white text-[11px]"></i>
                  </span>

                  <input
                    id="searchInput"
                    type="text"
                    placeholder="Search"
                    class="w-full md:w-80 bg-transparent text-sm text-gray-700 placeholder:text-gray-300 focus:outline-none"
                  />
                </div>

                <!-- Divider -->
                <div class="w-[2px] self-stretch bg-[#F2C94C]"></div>

                <!-- Filter -->
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
            <button
              id="clearBtn"
              type="button"
              class="text-[#8B0000] text-sm font-medium hover:underline"
            >
              Clear
            </button>

          </div>

        </div>

      </div>
    </div>

    <!-- Floating Tabs (like Patient List) -->
    <div class="w-full max-w-6xl mx-auto">
      <div class="mx-4 relative">

        <div class="flex gap-4 px-6 relative z-20">

          <button
            class="req-tab bg-[#8B0000] text-white rounded-t-2xl rounded-b-none px-6 py-4 w-[210px] text-left hover:opacity-90 transition-all duration-200"
            data-filter="all"
            type="button">
            <h3 class="req-count text-4xl font-medium leading-none mb-2">9</h3>
            <p class="text-base">All Requests</p>
          </button>

          <button
            class="req-tab bg-[#660000] text-white/75 rounded-t-2xl rounded-b-none px-6 py-4 w-[210px] text-left hover:opacity-90 transition-all duration-200"
            data-filter="pending"
            type="button">
            <h3 class="req-count text-4xl font-medium leading-none mb-2">3</h3>
            <p class="text-base">Pending Requests</p>
          </button>

          <button
            class="req-tab bg-[#660000] text-white/75 rounded-t-2xl rounded-b-none px-6 py-4 w-[210px] text-left hover:opacity-90 transition-all duration-200"
            data-filter="approved"
            type="button">
            <h3 class="req-count text-4xl font-medium leading-none mb-2">3</h3>
            <p class="text-base">Approved Requests</p>
          </button>

          <button
            class="req-tab bg-[#660000] text-white/75 rounded-t-2xl rounded-b-none px-6 py-4 w-[210px] text-left hover:opacity-90 transition-all duration-200"
            data-filter="rejected"
            type="button">
            <h3 class="req-count text-4xl font-medium leading-none mb-2">3</h3>
            <p class="text-base">Rejected Requests</p>
          </button>

        </div>

        <!-- White container like patient list -->
        <div class="mx-4 shadow-lg rounded-lg bg-white overflow-hidden relative">

          <div id="requestContainer" class="space-y-4 px-6 pb-6 pt-14 -mt-8 rounded-t-none">

            <!-- REQUEST CARD -->
            <a href="#"
              class="request-item approved block relative bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition cursor-pointer">

              <!-- Accent bar -->
              <div class="absolute left-0 top-0 h-full w-[6px] bg-green-500 rounded-l-xl"></div>

              <div class="flex items-center gap-6 px-8 py-6 pl-12">
                <div class="flex-1 grid grid-cols-12 items-center gap-6">

                  <!-- Name + Role -->
                  <div class="col-span-4">
                    <p class="font-semibold text-[#333333] text-sm">Capilitan, Beyonce</p>
                    <p class="text-gray-500 text-xs">BSIT 3-1</p>
                  </div>

                  <!-- Date -->
                  <div class="col-span-3 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                      <i class="fa-regular fa-calendar text-green-600"></i>
                    </div>
                    <div class="text-sm">
                      <p class="text-gray-400 text-xs uppercase tracking-wide">Date Requested</p>
                      <p class="font-semibold text-[#333333]">December 25, 2025</p>
                    </div>
                  </div>

                  <!-- Document -->
                  <div class="col-span-3 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                      <i class="fa-regular fa-file-lines text-green-600"></i>
                    </div>
                    <div class="text-sm">
                      <p class="text-gray-400 text-xs uppercase tracking-wide">Document</p>
                      <p class="font-semibold text-[#333333]">Dental Clearance</p>
                      <span class="inline-block mt-2 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                        Approved
                      </span>
                    </div>
                  </div>

                  <!-- Action -->
                    <div class="col-span-2 flex justify-end">
                      <button class="view-btn bg-[#8B0000] text-white text-sm px-5 py-2 rounded-md">
                        View
                      </button>
                    </div>
                </div>
              </div>
            </a>

            <!-- REQUEST CARD -->
            <a href="#"
              class="request-item pending block relative bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition cursor-pointer">

              <div class="absolute left-0 top-0 h-full w-[6px] bg-orange-500 rounded-l-xl"></div>

              <div class="flex items-center gap-6 px-8 py-6 pl-12">
                <div class="flex-1 grid grid-cols-12 items-center gap-6">

                  <div class="col-span-4">
                    <p class="font-semibold text-[#333333] text-sm">Romero, Dianna</p>
                    <p class="text-gray-500 text-xs">Faculty</p>
                  </div>

                  <div class="col-span-3 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                      <i class="fa-regular fa-calendar text-orange-600"></i>
                    </div>
                    <div class="text-sm">
                      <p class="text-gray-400 text-xs uppercase tracking-wide">Date Requested</p>
                      <p class="font-semibold text-[#333333]">December 25, 2025</p>
                    </div>
                  </div>

                  <div class="col-span-3 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                      <i class="fa-regular fa-file-lines text-orange-600"></i>
                    </div>
                    <div class="text-sm">
                      <p class="text-gray-400 text-xs uppercase tracking-wide">Document</p>
                      <p class="font-semibold text-[#333333]">Annual Dental Clearance</p>
                      <span class="inline-block mt-2 px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-xs font-medium">
                        Pending
                      </span>
                    </div>
                  </div>

                    <div class="col-span-2 flex justify-end">
                      <button class="view-btn bg-[#8B0000] text-white text-sm px-5 py-2 rounded-md">
                        View
                      </button>
                    </div>
                </div>
              </div>
            </a>

            <!-- REQUEST CARD -->
            <a href="#"
              class="request-item rejected block relative bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition cursor-pointer">

              <div class="absolute left-0 top-0 h-full w-[6px] bg-red-500 rounded-l-xl"></div>

              <div class="flex items-center gap-6 px-8 py-6 pl-12">
                <div class="flex-1 grid grid-cols-12 items-center gap-6">

                  <div class="col-span-4">
                    <p class="font-semibold text-[#333333] text-sm">Lopez, Hoshea</p>
                    <p class="text-gray-500 text-xs">Administrative</p>
                  </div>

                  <div class="col-span-3 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                      <i class="fa-regular fa-calendar text-red-600"></i>
                    </div>
                    <div class="text-sm">
                      <p class="text-gray-400 text-xs uppercase tracking-wide">Date Requested</p>
                      <p class="font-semibold text-[#333333]">December 25, 2025</p>
                    </div>
                  </div>

                  <div class="col-span-3 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                      <i class="fa-regular fa-file-lines text-red-600"></i>
                    </div>
                    <div class="text-sm">
                      <p class="text-gray-400 text-xs uppercase tracking-wide">Document</p>
                      <p class="font-semibold text-[#333333]">Dental Health Record</p>
                      <span class="inline-block mt-2 px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-medium">
                        Rejected
                      </span>
                    </div>
                  </div>

                    <div class="col-span-2 flex justify-end">
                      <button class="view-btn bg-[#8B0000] text-white text-sm px-5 py-2 rounded-md">
                        View
                      </button>
                    </div>
                </div>
              </div>
            </a>

            <!-- ✅ CLEAN, REUSABLE REQUEST ENTRY (works with filter/search + dropdown) -->
            <!-- Put this INSIDE #requestContainer -->

            <!-- ✅ ARAGON ENTRY (CARD + DROPDOWN styled like your screenshot) -->
            <div class="request-entry pending">

              <!-- COMPACT CARD (default) -->
              <div class="request-summary request-item relative bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
                
                <div class="absolute left-0 top-0 h-full w-[6px] bg-orange-500 rounded-l-xl"></div>

                <div class="flex items-center gap-6 px-8 py-6 pl-12">
                  <div class="flex-1 grid grid-cols-12 items-center gap-6">

                    <div class="col-span-4">
                      <p class="font-semibold text-[#333333] text-sm">Aragon, Althea</p>
                      <p class="text-gray-500 text-xs">Administrative</p>
                    </div>

                    <div class="col-span-3 flex items-start gap-3">
                      <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                        <i class="fa-regular fa-calendar text-orange-600"></i>
                      </div>
                      <div class="text-sm">
                        <p class="text-gray-400 text-xs uppercase">Date Requested</p>
                        <p class="font-semibold text-[#333333]">December 25, 2025</p>
                      </div>
                    </div>

                    <div class="col-span-3 flex items-start gap-3">
                      <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                        <i class="fa-regular fa-file-lines text-orange-600"></i>
                      </div>
                      <div class="text-sm">
                        <p class="text-gray-400 text-xs uppercase">Document</p>
                        <p class="font-semibold text-[#333333]">Odontogram Chart</p>
                        <span class="inline-block mt-2 px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-xs font-medium">
                          Pending
                        </span>
                      </div>
                    </div>

                    <div class="col-span-2 flex justify-end">
                      <button class="view-btn bg-[#8B0000] text-white text-sm px-5 py-2 rounded-md">
                        View
                      </button>
                    </div>

                  </div>
                </div>
              </div>


              <!-- EXPANDED VIEW -->
              <div class="request-details hidden border border-orange-300 mt-3 bg-white rounded-xl bg-white overflow-hidden">
                
                <!-- NEW HEADER -->
                <div class="flex items-cente justify-between px-8 py-6 bg-gray-50">

                  <div>
                    <p class="font-semibold text-[#333333]">Aragon, Althea</p>
                    <p class="text-sm text-gray-500">Administrative</p>
                  </div>

                  <div class="flex items-center gap-6">
                    <div>
                      <p class="text-xs text-gray-400">STATUS</p>
                      <span class="px-5 py-1 rounded-full bg-orange-100 text-orange-600 text-sm font-semibold">
                        Pending
                      </span>
                    </div>

                    <button class="close-btn bg-[#8B0000] text-white px-6 py-2 rounded-md text-sm">
                      Close
                    </button>
                  </div>
                </div>

                <!-- BODY -->
                <div class="px-10 py-8">
                  <div class="grid grid-cols-12 items-start gap-10">

                    <!-- LEFT GROUP (Office + Date + Last Visit) -->
                    <div class="col-span-5 grid grid-cols-2 gap-10">
                      <!-- Office -->
                      <div>
                        <p class="text-xs text-[#8B0000]">Office / Department</p>
                        <p class="text-lg font-semibold text-[#8B0000] mt-1">Admission</p>
                      </div>

                      <!-- Date + Last Visit -->
                      <div>
                        <p class="text-xs text-[#8B0000]">Date Requested</p>
                        <p class="text-l font-semibold text-[#8B0000] mt-1">December 25, 2025</p>

                        <div class="mt-6">
                          <p class="text-xs text-[#8B0000]">Last Dental Visit</p>
                          <p class="text-l font-semibold text-[#8B0000] mt-1">November 30, 2025</p>

                          <button type="button"
                            class="mt-3 bg-[#8B0000] text-white px-6 py-2 rounded-md text-xs hover:bg-[#6e0000] transition">
                            View Dental Record
                          </button>
                        </div>
                      </div>
                    </div>

                    <!-- CENTER LINE -->
                    <div class="col-span-1 flex justify-center">
                      <div class="w-px h-full bg-gray-300"></div>
                    </div>

                    <!-- RIGHT GROUP (Document + Purpose + Buttons) -->
                    <div class="col-span-6 flex items-start justify-between">
                      <!-- Text -->
                      <div>
                        <p class="text-xs text-[#8B0000]">Document</p>
                        <p class="text-l font-bold text-[#8B0000] mt-1">Dental Record</p>
                        <p class="text-sm text-gray-500">September 25, 2025</p>

                        <div class="mt-6">
                          <p class="text-xs text-[#8B0000]">Purpose</p>
                          <p class="text-l font-bold text-[#8B0000] mt-1">Personal Record</p>
                        </div>
                      </div>

                      <!-- Buttons (far right) -->
                      <div class="flex flex-col gap-4">
                        <button type="button"
                          class="approve-btn bg-green-600 text-white px-12 py-3 rounded-md font-semibold hover:bg-green-700 transition">
                          Approve
                        </button>

                        <button type="button"
                          class="reject-btn bg-red-600 text-white px-12 py-3 rounded-md font-semibold hover:bg-red-700 transition">
                          Reject
                        </button>
                      </div>
                    </div>

                  </div>
                </div>

              </div>

            </div>
            <!-- REQUEST CARD (REJECTED) - Lim, Grace -->
            <a href="#"
              class="request-item rejected block relative bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition cursor-pointer">

              <div class="absolute left-0 top-0 h-full w-[6px] bg-red-500 rounded-l-xl"></div>

              <div class="flex items-center gap-6 px-8 py-6 pl-12">
                <div class="flex-1 grid grid-cols-12 items-center gap-6">

                  <div class="col-span-4">
                    <p class="font-semibold text-[#333333] text-sm">Lim, Grace</p>
                    <p class="text-gray-500 text-xs">BSIT 3-1</p>
                  </div>

                  <div class="col-span-3 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                      <i class="fa-regular fa-calendar text-red-600"></i>
                    </div>
                    <div class="text-sm">
                      <p class="text-gray-400 text-xs uppercase tracking-wide">Date Requested</p>
                      <p class="font-semibold text-[#333333]">December 25, 2025</p>
                    </div>
                  </div>

                  <div class="col-span-3 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                      <i class="fa-regular fa-file-lines text-red-600"></i>
                    </div>
                    <div class="text-sm">
                      <p class="text-gray-400 text-xs uppercase tracking-wide">Document</p>
                      <p class="font-semibold text-[#333333]">Dental Health Record</p>
                      <span class="inline-block mt-2 px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-medium">
                        Rejected
                      </span>
                    </div>
                  </div>

                    <div class="col-span-2 flex justify-end">
                      <button class="view-btn bg-[#8B0000] text-white text-sm px-5 py-2 rounded-md">
                        View
                      </button>
                    </div>
                </div>
              </div>
            </a>

            <!-- NEW REQUEST (APPROVED) -->
            <a href="#"
              class="request-item approved block relative bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition cursor-pointer">

              <div class="absolute left-0 top-0 h-full w-[6px] bg-green-500 rounded-l-xl"></div>

              <div class="flex items-center gap-6 px-8 py-6 pl-12">
                <div class="flex-1 grid grid-cols-12 items-center gap-6">

                  <div class="col-span-4">
                    <p class="font-semibold text-[#333333] text-sm">Santos, John</p>
                    <p class="text-gray-500 text-xs">BSIT 2-2</p>
                  </div>

                  <div class="col-span-3 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                      <i class="fa-regular fa-calendar text-green-600"></i>
                    </div>
                    <div class="text-sm">
                      <p class="text-gray-400 text-xs uppercase tracking-wide">Date Requested</p>
                      <p class="font-semibold text-[#333333]">January 10, 2026</p>
                    </div>
                  </div>

                  <div class="col-span-3 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                      <i class="fa-regular fa-file-lines text-green-600"></i>
                    </div>
                    <div class="text-sm">
                      <p class="text-gray-400 text-xs uppercase tracking-wide">Document</p>
                      <p class="font-semibold text-[#333333]">Dental Clearance</p>
                      <span class="inline-block mt-2 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                        Approved
                      </span>
                    </div>
                  </div>

                    <div class="col-span-2 flex justify-end">
                      <button class="view-btn bg-[#8B0000] text-white text-sm px-5 py-2 rounded-md">
                        View
                      </button>
                    </div>
                </div>
              </div>
            </a>

            <!-- NEW REQUEST (PENDING) -->
            <a href="#"
              class="request-item pending block relative bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition cursor-pointer">

              <div class="absolute left-0 top-0 h-full w-[6px] bg-orange-500 rounded-l-xl"></div>

              <div class="flex items-center gap-6 px-8 py-6 pl-12">
                <div class="flex-1 grid grid-cols-12 items-center gap-6">

                  <div class="col-span-4">
                    <p class="font-semibold text-[#333333] text-sm">De Vera, Angela</p>
                    <p class="text-gray-500 text-xs">Faculty</p>
                  </div>

                  <div class="col-span-3 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                      <i class="fa-regular fa-calendar text-orange-600"></i>
                    </div>
                    <div class="text-sm">
                      <p class="text-gray-400 text-xs uppercase tracking-wide">Date Requested</p>
                      <p class="font-semibold text-[#333333]">January 11, 2026</p>
                    </div>
                  </div>

                  <div class="col-span-3 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                      <i class="fa-regular fa-file-lines text-orange-600"></i>
                    </div>
                    <div class="text-sm">
                      <p class="text-gray-400 text-xs uppercase tracking-wide">Document</p>
                      <p class="font-semibold text-[#333333]">Annual Dental Clearance</p>
                      <span class="inline-block mt-2 px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-xs font-medium">
                        Pending
                      </span>
                    </div>
                  </div>

                    <div class="col-span-2 flex justify-end">
                      <button class="view-btn bg-[#8B0000] text-white text-sm px-5 py-2 rounded-md">
                        View
                      </button>
                    </div>
                </div>
              </div>
            </a>

          </div>

          <!-- Pagination (use your patient list style) -->
          <div id="pagination" class="flex items-center justify-center gap-4 py-8 text-sm text-gray-600">
            <button id="prevPage" class="flex items-center gap-1 px-2 py-1 text-gray-300 cursor-not-allowed" disabled>
              <span>‹</span> Previous
            </button>

            <div id="pageNumbers" class="flex items-center gap-2"></div>

            <button id="nextPage" class="flex items-center gap-1 px-2 py-1 text-[#8B0000] hover:underline">
              Next <span>›</span>
            </button>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>
</main>

<!-- ✅ APPROVAL MODAL -->
<div id="approveModal"
  class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/50 p-4">

  <div class="w-full max-w-3xl rounded-2xl overflow-hidden bg-white shadow-2xl">
    <!-- Header -->
    <div class="bg-green-700 text-white text-center py-5 text-2xl font-extrabold">
      Approve Document Request
    </div>

    <!-- Body -->
    <div class="p-10 text-center">
      <h3 class="text-green-700 text-2xl font-extrabold mb-6">
        Approve the following request of<br>the patient?:
      </h3>

      <div id="approvePatientName"
        class="mx-auto max-w-2xl border-2 border-gray-400 rounded-lg py-6 px-6
               text-4xl font-extrabold text-gray-700">
        —
      </div>

      <p class="mt-8 text-gray-500 text-sm">
        The document requested will be printed after the confirmation of approval.
      </p>

      <div class="mt-10 flex justify-end gap-5">
        <button id="approveCancelBtn"
          class="bg-gray-300 text-gray-800 px-10 py-3 rounded-lg font-bold hover:bg-gray-400 transition">
          Cancel
        </button>

        <button id="approveConfirmBtn"
          class="bg-green-700 text-white px-12 py-3 rounded-lg font-extrabold hover:bg-green-800 transition">
          APPROVE
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ✅ REJECT MODAL -->
<div id="rejectModal"
  class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/50 p-4">

  <div class="w-full max-w-3xl rounded-2xl overflow-hidden bg-white shadow-2xl">
    <!-- Header -->
    <div class="bg-[#8B0000] text-white text-center py-5 text-2xl font-extrabold">
      Reject Document Request
    </div>

    <!-- Body -->
    <div class="p-10 text-center">
      <h3 class="text-gray-700 text-2xl font-extrabold mb-2">
        Reject the following request of the patient?
      </h3>
      <p class="text-gray-500 text-sm mb-6">This action cannot be undone.</p>

      <div id="rejectPatientName"
        class="mx-auto max-w-2xl border-2 border-gray-500 rounded-lg py-6 px-6
               text-4xl font-extrabold text-gray-700 bg-gray-50">
        —
      </div>

      <div class="max-w-2xl mx-auto text-left mt-6">
        <p class="text-sm font-semibold text-gray-700 mb-2">Notes for Rejection:</p>
        <textarea id="rejectNotes"
          class="w-full min-h-[110px] rounded-lg bg-gray-100 p-4 text-sm outline-none focus:ring-2 focus:ring-[#8B0000]/40"
          placeholder="Add notes here..."></textarea>
      </div>

      <div class="mt-8 flex justify-end gap-5">
        <button id="rejectCancelBtn"
          class="bg-gray-300 text-gray-800 px-10 py-3 rounded-lg font-bold hover:bg-gray-400 transition">
          Cancel
        </button>

        <button id="rejectConfirmBtn"
          class="bg-[#8B0000] text-white px-12 py-3 rounded-lg font-extrabold hover:bg-[#6e0000] transition">
          REJECT
        </button>
      </div>
    </div>
  </div>
</div>


<!-- ✅ APPROVED RESULT MODAL -->
<div id="approvedResultModal"
  class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/50 p-4">
  <div class="w-full max-w-3xl rounded-2xl overflow-hidden shadow-2xl bg-[#0B7A3B]">
    <div class="px-10 py-12 text-center text-white">
      <h2 class="text-3xl md:text-4xl font-extrabold leading-tight">
        This request has been<br/>approved.
      </h2>

      <p class="text-white/80 text-sm mt-6 leading-relaxed">
        The document will now be printed for signing and validation.<br/>
        The patient will be notified for the claiming of the document.
      </p>

      <div class="mt-7 text-white/90 text-sm font-semibold">Claiming Validity:</div>

      <div class="mt-4 flex flex-col items-center gap-3">
        <div class="flex items-center gap-3">
          <span class="w-12 text-right text-white/80 text-sm">From:</span>
          <input id="approvedFrom" type="date"
            class="w-40 h-8 rounded bg-white/90 text-gray-900 px-3 text-sm outline-none focus:ring-2 focus:ring-white/60">
        </div>

        <div class="flex items-center gap-3">
          <span class="w-12 text-right text-white/80 text-sm">Until:</span>
          <input id="approvedUntil" type="date"
            class="w-40 h-8 rounded bg-white/90 text-gray-900 px-3 text-sm outline-none focus:ring-2 focus:ring-white/60">
        </div>
      </div>

      <div class="mt-10 flex justify-end">
        <button id="approvedResultClose"
          class="bg-gray-200 text-gray-800 px-8 py-2.5 rounded-lg font-bold hover:bg-gray-300 transition">
          Close
        </button>
      </div>
    </div>
  </div>
</div>


<!-- ✅ REJECTED RESULT MODAL -->
<div id="rejectedResultModal"
  class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/50 p-4">
  <div class="w-full max-w-3xl rounded-2xl overflow-hidden shadow-2xl bg-[#7B0000]">
    <div class="px-10 py-14 text-center text-white">
      <h2 class="text-3xl md:text-4xl font-extrabold leading-tight">
        This request has been<br/>rejected.
      </h2>

      <p class="text-white/70 text-sm mt-6">
        The patient will be notified of the document request status.
      </p>

      <div class="mt-12 flex justify-end">
        <button id="rejectedResultClose"
          class="bg-gray-200 text-gray-800 px-8 py-2.5 rounded-lg font-bold hover:bg-gray-300 transition">
          Close
        </button>
      </div>
    </div>
  </div>
</div>


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
    toggleWrapper.classList.add('justify-right');

    toggleBtn.classList.add('translate-x-2');
    icon.classList.replace('fa-bars', 'fa-xmark');

  } else {
    // COLLAPSE
    applyLayout('72px');

    texts.forEach(t => {
      t.classList.add('opacity-0', 'w-0');
      t.classList.remove('opacity-100', 'w-auto');
    });

    toggleWrapper.classList.remove('justify-right');
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


  document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("requestContainer");
  if (!container) return;

  const tabs = document.querySelectorAll(".req-tab");
  const searchInput = document.getElementById("searchInput");
  const clearBtn = document.getElementById("clearBtn");

  const prevBtn = document.getElementById("prevPage");
  const nextBtn = document.getElementById("nextPage");
  const pageNumbers = document.getElementById("pageNumbers");

  // ✅ IMPORTANT: Only take TOP LEVEL children
  // - .request-entry (Aragon wrapper)
  // - direct child .request-item (your <a> cards)
  const allEntries = Array.from(container.children).filter(el =>
    el.classList.contains("request-entry") || el.classList.contains("request-item")
  );

  let activeTab = "all";
  let activeSearch = "";
  let currentPage = 1;

  const perPage = 5; // ✅ change this freely now (2,3,4,10...) and it will work

  function setActiveTabUI(btn) {
    btn.classList.remove("bg-[#660000]", "text-white/75");
    btn.classList.add("bg-[#8B0000]", "text-white");
  }
  function setInactiveTabUI(btn) {
    btn.classList.remove("bg-[#8B0000]", "text-white");
    btn.classList.add("bg-[#660000]", "text-white/75");
  }

  function getNameText(entry) {
    // works for both <a.request-item> and .request-entry wrapper
    const name =
      entry.querySelector(".col-span-4 .font-semibold")?.textContent ||
      entry.querySelector(".font-semibold")?.textContent ||
      "";
    return name.trim().toLowerCase();
  }

  function entryHasStatus(entry, status) {
    // wrapper has pending/approved/rejected OR direct card has it
    return entry.classList.contains(status);
  }

  function getFilteredEntries() {
    return allEntries.filter(entry => {
      if (activeTab !== "all" && !entryHasStatus(entry, activeTab)) return false;
      if (activeSearch && !getNameText(entry).includes(activeSearch)) return false;
      return true;
    });
  }

  function render() {
    const filtered = getFilteredEntries();
    const totalPages = Math.max(1, Math.ceil(filtered.length / perPage));

    // keep currentPage valid
    if (currentPage > totalPages) currentPage = totalPages;

    const start = (currentPage - 1) * perPage;
    const pageItems = filtered.slice(start, start + perPage);

    // re-render list
    container.innerHTML = "";
    pageItems.forEach(el => container.appendChild(el));

    // prev/next state
    if (prevBtn) prevBtn.disabled = currentPage === 1;
    if (nextBtn) nextBtn.disabled = currentPage === totalPages;

    if (pageNumbers) {
      pageNumbers.innerHTML = "";
      for (let i = 1; i <= totalPages; i++) {
        const b = document.createElement("button");
        b.type = "button";
        b.textContent = i;
        b.className =
          "px-3 py-1 rounded-md font-semibold " +
          (i === currentPage ? "text-[#8B0000]" : "text-gray-400 hover:text-[#8B0000]");
        b.addEventListener("click", () => {
          currentPage = i;
          render();
        });
        pageNumbers.appendChild(b);
      }
    }
  }

  function updateTabCounts() {
  const counts = { all: 0, pending: 0, approved: 0, rejected: 0 };

  allEntries.forEach(entry => {
    counts.all++;

    if (entry.classList.contains("pending")) counts.pending++;
    if (entry.classList.contains("approved")) counts.approved++;
    if (entry.classList.contains("rejected")) counts.rejected++;
  });

  document.querySelectorAll(".req-tab").forEach(tab => {
    const key = tab.dataset.filter; // all/pending/approved/rejected
    const h3 = tab.querySelector(".req-count");
    if (h3 && counts[key] !== undefined) h3.textContent = counts[key];
  });
}

  // tabs
  tabs.forEach(btn => {
    btn.addEventListener("click", () => {
      activeTab = btn.dataset.filter;
      currentPage = 1; // ✅ reset to page 1 (prevents “missing” feeling)
      tabs.forEach(setInactiveTabUI);
      setActiveTabUI(btn);
      render();
    });
  });

  // search
  searchInput?.addEventListener("input", () => {
    activeSearch = searchInput.value.trim().toLowerCase();
    currentPage = 1;
    render();
  });

  // clear
  clearBtn?.addEventListener("click", () => {
    if (!searchInput) return;
    searchInput.value = "";
    searchInput.dispatchEvent(new Event("input"));
  });

  // prev/next
  prevBtn?.addEventListener("click", () => {
    if (currentPage > 1) {
      currentPage--;
      render();
    }
  });

  nextBtn?.addEventListener("click", () => {
    const totalPages = Math.max(1, Math.ceil(getFilteredEntries().length / perPage));
    if (currentPage < totalPages) {
      currentPage++;
      render();
    }
  });

  // default tab UI
  const defaultTab = document.querySelector('.req-tab[data-filter="all"]');
  if (defaultTab) setActiveTabUI(defaultTab);

  updateTabCounts();
  render();
});


/* ✅ DROPDOWN (opens ONLY when View is clicked; hover only affects card) */
/* ✅ Dropdown toggle ONLY for Aragon (only if its View button has class="view-btn") */
document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("requestContainer");

  container.addEventListener("click", (e) => {

    const view = e.target.closest(".view-btn");
    const close = e.target.closest(".close-btn");

    if (view) {
      const entry = view.closest(".request-entry");
      entry.querySelector(".request-summary").classList.add("hidden");
      entry.querySelector(".request-details").classList.remove("hidden");
    }

    if (close) {
      const entry = close.closest(".request-entry");
      entry.querySelector(".request-summary").classList.remove("hidden");
      entry.querySelector(".request-details").classList.add("hidden");
    }

  });
});

// ✅ APPROVAL MODAL (works even with pagination because we use event delegation)
document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("approveModal");
  const nameBox = document.getElementById("approvePatientName");
  const cancelBtn = document.getElementById("approveCancelBtn");
  const confirmBtn = document.getElementById("approveConfirmBtn");
  const container = document.getElementById("requestContainer");

  if (!modal || !nameBox || !cancelBtn || !confirmBtn || !container) return;

  let activeEntry = null; // store which request we are approving

  function getPatientName(fromEl) {
    // Works for your Aragon request-entry (summary + details)
    return (
      fromEl.querySelector(".request-summary .col-span-4 .font-semibold")?.textContent ||
      fromEl.querySelector(".request-details .font-semibold")?.textContent ||
      fromEl.querySelector(".col-span-4 .font-semibold")?.textContent ||
      "Patient"
    ).trim();
  }

  function openModal(entryEl) {
    activeEntry = entryEl;
    nameBox.textContent = getPatientName(entryEl);

    modal.classList.remove("hidden");
    modal.classList.add("flex");

    // Optional: prevent page scroll while modal open
    document.body.classList.add("overflow-hidden");
  }

  function closeModal() {
    modal.classList.add("hidden");
    modal.classList.remove("flex");
    activeEntry = null;

    document.body.classList.remove("overflow-hidden");
  }

  // Open modal when Approve is clicked
  container.addEventListener("click", (e) => {
    const approveBtn = e.target.closest(".approve-btn");
    if (!approveBtn) return;

    e.preventDefault();
    e.stopPropagation();

    const entry = approveBtn.closest(".request-entry") || approveBtn.closest(".request-item");
    if (!entry) return;

    openModal(entry);
  });

  // Cancel closes modal
  cancelBtn.addEventListener("click", closeModal);

  // Click outside the dialog closes modal
  modal.addEventListener("click", (e) => {
    if (e.target === modal) closeModal();
  });

  // ESC closes modal
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !modal.classList.contains("hidden")) closeModal();
  });

  // Confirm (placeholder — connect to backend later)
  confirmBtn.addEventListener("click", () => {
    if (!activeEntry) return;

    const patient = getPatientName(activeEntry);

    // TODO: Replace this with your real approve action (fetch/ajax/form submit)
    console.log("Approved:", patient);

    closeModal();
  });
});

// ✅ REJECT MODAL (event delegation so it survives pagination re-render)
document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("rejectModal");
  const nameBox = document.getElementById("rejectPatientName");
  const notesEl = document.getElementById("rejectNotes");
  const cancelBtn = document.getElementById("rejectCancelBtn");
  const confirmBtn = document.getElementById("rejectConfirmBtn");
  const container = document.getElementById("requestContainer");

  if (!modal || !nameBox || !notesEl || !cancelBtn || !confirmBtn || !container) return;

  let activeEntry = null;

  function getPatientName(fromEl) {
    return (
      fromEl.querySelector(".request-summary .col-span-4 .font-semibold")?.textContent ||
      fromEl.querySelector(".request-details .font-semibold")?.textContent ||
      fromEl.querySelector(".col-span-4 .font-semibold")?.textContent ||
      "Patient"
    ).trim();
  }

  function openModal(entryEl) {
    activeEntry = entryEl;
    nameBox.textContent = getPatientName(entryEl);
    notesEl.value = "";

    modal.classList.remove("hidden");
    modal.classList.add("flex");
    document.body.classList.add("overflow-hidden");

    // focus cursor in textarea
    setTimeout(() => notesEl.focus(), 0);
  }

  function closeModal() {
    modal.classList.add("hidden");
    modal.classList.remove("flex");
    activeEntry = null;
    document.body.classList.remove("overflow-hidden");
  }

  // Open on Reject click
  container.addEventListener("click", (e) => {
    const rejectBtn = e.target.closest(".reject-btn");
    if (!rejectBtn) return;

    e.preventDefault();
    e.stopPropagation();

    const entry = rejectBtn.closest(".request-entry") || rejectBtn.closest(".request-item");
    if (!entry) return;

    openModal(entry);
  });

  // Cancel
  cancelBtn.addEventListener("click", closeModal);

  // Click outside
  modal.addEventListener("click", (e) => {
    if (e.target === modal) closeModal();
  });

  // ESC
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !modal.classList.contains("hidden")) closeModal();
  });

  // Confirm (placeholder)
  confirmBtn.addEventListener("click", () => {
    if (!activeEntry) return;

    const patient = getPatientName(activeEntry);
    const notes = notesEl.value.trim();

    // TODO: replace with backend action
    console.log("Rejected:", patient, "Notes:", notes);

    closeModal();
  });
});


document.addEventListener("DOMContentLoaded", () => {
  // Confirm modals you already have
  const approveConfirmModal = document.getElementById("approveModal");   // <-- change if your approve modal has different id
  const rejectConfirmModal  = document.getElementById("rejectModal");

  // Result modals (new)
  const approvedResultModal = document.getElementById("approvedResultModal");
  const rejectedResultModal = document.getElementById("rejectedResultModal");

  const approvedCloseBtn = document.getElementById("approvedResultClose");
  const rejectedCloseBtn = document.getElementById("rejectedResultClose");

  const approvedFrom  = document.getElementById("approvedFrom");
  const approvedUntil = document.getElementById("approvedUntil");

  // Your confirm buttons (from the confirm modals)
  const approveConfirmBtn = document.getElementById("approveConfirmBtn"); // <-- ensure your approve confirm button uses this id
  const rejectConfirmBtn  = document.getElementById("rejectConfirmBtn");

  function openModal(modalEl) {
    if (!modalEl) return;
    modalEl.classList.remove("hidden");
    modalEl.classList.add("flex");
    document.body.classList.add("overflow-hidden");
  }

  function closeModal(modalEl) {
    if (!modalEl) return;
    modalEl.classList.add("hidden");
    modalEl.classList.remove("flex");
    document.body.classList.remove("overflow-hidden");
  }

  // Click outside closes
  function enableOutsideClick(modalEl, onClose) {
    modalEl?.addEventListener("click", (e) => {
      if (e.target === modalEl) onClose();
    });
  }

  // Close buttons
  approvedCloseBtn?.addEventListener("click", () => closeModal(approvedResultModal));
  rejectedCloseBtn?.addEventListener("click", () => closeModal(rejectedResultModal));

  enableOutsideClick(approvedResultModal, () => closeModal(approvedResultModal));
  enableOutsideClick(rejectedResultModal, () => closeModal(rejectedResultModal));

  // ESC closes whichever result modal is open
  document.addEventListener("keydown", (e) => {
    if (e.key !== "Escape") return;
    if (approvedResultModal && !approvedResultModal.classList.contains("hidden")) closeModal(approvedResultModal);
    if (rejectedResultModal && !rejectedResultModal.classList.contains("hidden")) closeModal(rejectedResultModal);
  });

  // ✅ When APPROVE is confirmed -> show Approved Result modal
  approveConfirmBtn?.addEventListener("click", () => {
    // close confirm modal first
    if (approveConfirmModal) closeModal(approveConfirmModal);

    // optional: set default dates
    const today = new Date().toISOString().slice(0, 10);
    if (approvedFrom) approvedFrom.value = today;
    if (approvedUntil) approvedUntil.value = "";

    openModal(approvedResultModal);
  });

  // ✅ When REJECT is confirmed -> show Rejected Result modal
  rejectConfirmBtn?.addEventListener("click", () => {
    // close confirm modal first
    if (rejectConfirmModal) closeModal(rejectConfirmModal);

    openModal(rejectedResultModal);
  });
});
</script>

</body>
</html>
