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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Font Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Inter'; }

    /* Fade-in animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(6px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in { animation: fadeIn 0.6s ease-out forwards; }

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
    #sidebar[style*="16rem"] .sidebar-tooltip { display: none; }
    #sidebar[style*="16rem"] .sidebar-link { justify-content: flex-start; }

    /* consistent icon column width */
    .sidebar-link i{
      width: 24px;
      min-width: 24px;
      text-align: center;
    }

    /* CLOSED: center icon only */
    #sidebar[style*="72px"] .sidebar-link { justify-content: center; gap: 0; }

    /* when expanded, align items nicely */
    #sidebar[style*="16rem"] .sidebar-link{ justify-content: flex-start; gap: 12px; }
    #sidebar[style*="16rem"] .sidebar-link:hover { transform: translateX(4px); }

    .sidebar-link:hover .sidebar-text { opacity: 1; transform: scale(1); }
    .sidebar-text { transform-origin: left center; }

    /* Notification dropdown animation */
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

    /* DARK MODE */
    [data-theme="dark"] body {
      background-color: #111827;
      color: #E5E7EB;
    }
    [data-theme="dark"] #sidebar { background-color: #1F2933; }
    [data-theme="dark"] .bg-white { background-color: #1F2937 !important; }
    [data-theme="dark"] .text-\[\#333333\] { color: #E5E7EB !important; }

    body, #sidebar, main, .card {
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* ===== Filter modal radio look (matches screenshot) ===== */
    .filter-radio {
      width: 22px;
      height: 22px;
      border-radius: 9999px;
      border: 2px solid #8B1A1A;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: #fff;
      box-sizing: border-box;
      flex-shrink: 0;
    }
    .filter-radio::after{
      content:"";
      width: 11px;
      height: 11px;
      border-radius: 9999px;
      background: #8B1A1A;
      display: none;
    }
    input[type="radio"].filter-input:checked + .filter-radio::after { display:block; }

    /* make date placeholder look subtle like sample */
    .filter-date {
      width: 240px;
      padding: 10px 14px;
      border: 1px solid #e0e0e0;
      border-radius: 6px;
      font-size: 15px;
      background: #fff;
      outline: none;
      box-sizing: border-box;
      color: #333;
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

  <div class="flex items-center gap-8">
    @php
      $notifications = collect($notifications ?? []);
      $notifCount = $notifications->count();
    @endphp

    <div id="notifDropdown" class="relative">
      <button id="notifBtn" type="button" class="btn btn-ghost btn-circle indicator text-[#F4F4F4]">
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
        <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">
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
              transition-all duration-200">
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
        <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">
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
        <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">
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
        <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">
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
        <span class="sidebar-text font-bold opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">
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
        <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">
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
      <span class="sidebar-text text-sm opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">
        Dark Mode
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
        Dark Mode
      </span>
    </button>

    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button
        class="sidebar-link w-full relative flex items-center px-3 py-2 rounded-xl text-sm
              text-red-600 hover:bg-red-50 transition-all duration-200">
        <i class="fa-solid fa-right-from-bracket text-sm"></i>
        <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">
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

<main id="mainContent" class="flex-1 pt-[100px] px-6 pb-10 w-full
transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]">

  <div class="max-w-7xl mt-4 mx-auto fade-in">
    <div class="bg-white rounded-xl shadow p-6">

      <!-- TOOLBAR -->
      <div class="flex justify-between items-center mb-4 flex-wrap gap-3">

        <!-- Search -->
        <div class="p-[2px] rounded-full bg-gradient-to-r from-[#660000] to-[#FFD700] w-72">
          <div class="flex items-center bg-white rounded-full px-4 py-2">
            <i class="fa fa-search text-[#660000]"></i>
            <input
              id="searchInput"
              class="ml-3 outline-none w-full text-sm bg-white text-gray-800 placeholder-gray-400"
              placeholder="Search Stock No., Name"
              oninput="renderTable()"
            />
          </div>
        </div>

        <div class="flex gap-2">

          <!-- FILTER BUTTON (replaces separate Show/Sort bars) -->
          <button
            type="button"
            onclick="openFilterModal()"
            class="btn btn-sm rounded-full border-none bg-white text-[#660000] hover:bg-[#F4F4F4]"
            style="box-shadow: inset 0 0 0 2px #e0e0e0;"
          >
            <i class="fa-solid fa-filter text-[#660000] mr-1"></i>
            Filter
          </button>

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
        class="hidden flex-1 flex items-center justify-center text-gray-400 text-lg font-medium"
      >
        No items in the inventory
      </div>

    </div>
  </div>

</main>

<!-- FILTER MODAL (FIXED FOOTER - NOT SCROLLING) -->
<dialog id="filterModal" class="modal">
  <div class="bg-white w-[760px] h-[700px] rounded-xl shadow-2xl overflow-hidden border border-gray-200 flex flex-col">

    <!-- Header -->
    <div class="px-7 py-4 border-b flex items-center gap-3 shrink-0">
      <i class="fa-solid fa-filter" style="color:#8B1A1A;"></i>
      <span class="text-[22px] font-bold" style="color:#8B1A1A;">Filter</span>
    </div>

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

      <label>Consumed</label>
      <input id="editUsed" type="number"
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

<!-- DELETE CONFIRMATION MODAL -->
<dialog id="deleteModal" class="modal">
  <div class="modal-box max-w-md bg-white rounded-lg text-center">
    <h3 class="font-bold text-lg text-[#8B0000] mb-4">Confirm Deletion</h3>
    <p class="mb-6">Are you sure you want to delete this item? This action cannot be undone.</p>

    <div class="modal-action justify-center gap-4">
      <button class="btn bg-gray-200 text-gray-700 hover:bg-gray-300" onclick="deleteModal.close()">Cancel</button>
      <button id="confirmDeleteBtn" class="btn bg-[#8B0000] text-white">Delete</button>
    </div>
  </div>
</dialog>

<!-- Footer -->
<footer class="footer sm:footer-horizontal mt-auto bg-[#660000] text-[#F4F4F4] p-10"></footer>

<script>
/* =========================
   DARK MODE TOGGLE
========================= */
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

/* =========================
   SIDEBAR
========================= */
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
  sidebarOpen = false;
  applyLayout('72px');
});

/* =========================
   INVENTORY DATA LOAD
========================= */
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
========================= */
let deleteId = null;

function deleteItem(id) {
  deleteId = id;
  deleteModal.showModal();
}

document.getElementById("confirmDeleteBtn").onclick = async () => {
  if (!deleteId) return;

  await fetch(`/dentist/inventory/${deleteId}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  });

  deleteModal.close();
  deleteId = null;
  loadInventory();
};

/* =========================
   FILTER PANEL STATE (NEW)
========================= */
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
========================= */
const emptyState = document.getElementById("emptyState");

function renderTable() {
  const tbody = document.getElementById("tableBody");
  tbody.innerHTML = "";

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
========================= */
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
========================= */
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
========================= */
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
========================= */
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