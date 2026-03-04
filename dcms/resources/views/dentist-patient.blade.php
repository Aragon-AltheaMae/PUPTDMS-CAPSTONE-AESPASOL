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

  <style>
    body {
      font-family: 'Inter';
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(8px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-in { animation: fadeIn 0.6s ease-out forwards; }

    .radio-red {
      -webkit-appearance: none; appearance: none;
      width: 16px; height: 16px;
      border: 2px solid #8B0000; border-radius: 9999px;
      display: inline-grid; place-content: center; background: #fff;
    }
    .radio-red::before {
      content: ""; width: 8px; height: 8px; border-radius: 9999px;
      transform: scale(0); transition: transform 120ms ease-in-out; background: #8B0000;
    }
    .radio-red:checked::before { transform: scale(1); }

    .sidebar-link {
      display: flex; align-items: center; width: 100%;
      padding: 12px; border-radius: 12px;
      transition: background-color .2s ease, transform .2s ease;
    }
    .sidebar-link:hover .sidebar-tooltip { opacity: 1; transform: scale(1); }
    #sidebar[style*="16rem"] .sidebar-tooltip { display: none; }
    #sidebar[style*="16rem"] .sidebar-link { justify-content: flex-start; }
    .sidebar-link i { width: 24px; min-width: 24px; text-align: center; }
    #sidebar[style*="72px"] .sidebar-link  { justify-content: center; gap: 0; }
    #sidebar[style*="16rem"] .sidebar-link { justify-content: flex-start; gap: 12px; }
    #sidebar[style*="16rem"] .sidebar-link:hover { transform: translateX(4px); }
    .sidebar-link:hover .sidebar-text { opacity: 1; transform: scale(1); }
    .sidebar-text { transform-origin: left center; }

    .notif-open  { opacity: 1 !important; transform: scale(1) !important; pointer-events: auto !important; }
    .notif-close { opacity: 0 !important; transform: scale(0.95) !important; pointer-events: none !important; }

    #openFilter.filter-active { background: #8B0000 !important; color: #fff !important; }
    #openFilter.filter-active i { color: #fff !important; }

    /* DARK MODE */
    [data-theme="dark"] body { background-color: #111827; color: #E5E7EB; }
    [data-theme="dark"] #sidebar { background-color: #1F2933; }
    [data-theme="dark"] .bg-white { background-color: #1F2937 !important; }
    [data-theme="dark"] .text-\[\#333333\] { color: #E5E7EB !important; }
    body, #sidebar, main, .card { transition: background-color 0.3s ease, color 0.3s ease; }

    /* =============================================
       TABS — white card style with colored icon + bottom border
    ============================================= */
    @keyframes tabSlideUp {
      from { opacity: 0; transform: translateY(12px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .tab-btn {
      position: relative;
      background: #fff;
      border: 1.5px solid #E5E7EB;
      border-radius: 16px;
      padding: 18px 16px 16px;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 0;
      cursor: pointer;
      transition: box-shadow .2s ease, transform .2s ease, border-color .2s;
      overflow: hidden;
      animation: tabSlideUp .35s ease both;
    }
    .tab-btn:nth-child(1) { animation-delay: .03s; }
    .tab-btn:nth-child(2) { animation-delay: .08s; }
    .tab-btn:nth-child(3) { animation-delay: .13s; }
    .tab-btn:nth-child(4) { animation-delay: .18s; }
    .tab-btn:nth-child(5) { animation-delay: .23s; }
    .tab-btn:nth-child(6) { animation-delay: .28s; }

    .tab-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0,0,0,.08);
      border-color: #D1D5DB;
    }

    /* bottom accent border — hidden by default, shown on active */
    .tab-btn::after {
      content: '';
      position: absolute;
      bottom: 0; left: 0; right: 0;
      height: 4px;
      border-radius: 0 0 16px 16px;
      opacity: 0;
      transition: opacity .2s;
    }
    .tab-btn.tab-active {
      border-color: transparent;
      box-shadow: 0 6px 24px rgba(0,0,0,.10);
      transform: translateY(-2px);
    }
    .tab-btn.tab-active::after { opacity: 1; }

    /* icon wrapper — rounded square with soft tinted bg */
    .tab-icon-wrap {
      width: 40px; height: 40px;
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 14px;
      font-size: 18px;
    }

    /* number + label row — icon left, number right */
    .tab-top-row {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      width: 100%;
      gap: 8px;
    }

    .tab-count {
      font-size: 34px;
      font-weight: 800;
      line-height: 1;
      letter-spacing: -1px;
      color: #111827;
    }
    .tab-label {
      font-size: 11px;
      font-weight: 600;
      letter-spacing: .6px;
      color: #6B7280;
      text-transform: uppercase;
      margin-top: 6px;
      display: block;
    }

    /* Per-tab icon + accent colors */
    .tab-scheduled  .tab-icon-wrap { background: #EFF6FF; color: #2563EB; }
    .tab-upcoming   .tab-icon-wrap { background: #FFF7ED; color: #EA580C; }
    .tab-rescheduled.tab-icon-wrap,
    .tab-rescheduled .tab-icon-wrap { background: #EFF6FF; color: #0EA5E9; }
    .tab-cancelled  .tab-icon-wrap { background: #FDF2FF; color: #A855F7; }
    .tab-completed  .tab-icon-wrap { background: #F0FDF4; color: #16A34A; }
    .tab-all        .tab-icon-wrap { background: #FFF7ED; color: #D97706; }

    /* bottom border colors per tab */
    .tab-scheduled::after  { background: #2563EB; }
    .tab-upcoming::after   { background: #EA580C; }
    .tab-rescheduled::after{ background: #0EA5E9; }
    .tab-cancelled::after  { background: #A855F7; }
    .tab-completed::after  { background: #16A34A; }
    .tab-all::after        { background: #D97706; }

    /* active border on the card itself matches accent */
    .tab-scheduled.tab-active  { border-color: #BFDBFE !important; box-shadow: 0 6px 24px rgba(37,99,235,.12); }
    .tab-upcoming.tab-active   { border-color: #FED7AA !important; box-shadow: 0 6px 24px rgba(234,88,12,.12); }
    .tab-rescheduled.tab-active{ border-color: #BAE6FD !important; box-shadow: 0 6px 24px rgba(14,165,233,.12); }
    .tab-cancelled.tab-active  { border-color: #E9D5FF !important; box-shadow: 0 6px 24px rgba(168,85,247,.12); }
    .tab-completed.tab-active  { border-color: #BBF7D0 !important; box-shadow: 0 6px 24px rgba(22,163,74,.12); }
    .tab-all.tab-active        { border-color: #FDE68A !important; box-shadow: 0 6px 24px rgba(217,119,6,.12); }

    /* =============================================
       ENHANCED PATIENT CARDS
    ============================================= */
    @keyframes cardIn {
      from { opacity: 0; transform: translateY(10px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .patient-card {
      position: relative;
      background: #fff;
      border: 1.5px solid #E5E7EB;
      border-radius: 16px;
      overflow: hidden;
      cursor: pointer;
      transition: border-color .2s, box-shadow .2s, transform .2s;
      animation: cardIn .4s ease both;
    }
    .patient-card:nth-child(1) { animation-delay: .05s; }
    .patient-card:nth-child(2) { animation-delay: .12s; }
    .patient-card:nth-child(3) { animation-delay: .19s; }
    .patient-card:nth-child(4) { animation-delay: .26s; }
    .patient-card:nth-child(5) { animation-delay: .33s; }

    .patient-card:hover {
      border-color: #D1D5DB;
      box-shadow: 0 8px 28px rgba(0,0,0,.09);
      transform: translateY(-2px);
    }

    /* left accent bar */
    .patient-card .accent-bar {
      position: absolute;
      left: 0; top: 14px; bottom: 14px;
      width: 4px;
      border-radius: 0 4px 4px 0;
    }
    .accent-upcoming    { background: linear-gradient(180deg, #E64A19, #BF360C); }
    .accent-today       { background: linear-gradient(180deg, #1E88E5, #1565C0); }
    .accent-rescheduled { background: linear-gradient(180deg, #FB8C00, #E65100); }
    .accent-cancelled   { background: linear-gradient(180deg, #E53935, #B71C1C); }
    .accent-completed   { background: linear-gradient(180deg, #388E3C, #1B5E20); }
    .accent-default     { background: linear-gradient(180deg, #9CA3AF, #6B7280); }

    /* arrow CTA */
    .card-arrow-btn {
      width: 36px; height: 36px;
      border-radius: 50%;
      background: #F3F4F6;
      border: 1.5px solid #E5E7EB;
      display: flex; align-items: center; justify-content: center;
      color: #9CA3AF; font-size: 14px;
      flex-shrink: 0;
      transition: all .2s;
    }
    .patient-card:hover .card-arrow-btn {
      background: #8B0000;
      border-color: #8B0000;
      color: #fff;
      box-shadow: 0 4px 12px rgba(139,0,0,.3);
    }

    /* status pill */
    .status-pill {
      display: inline-flex; align-items: center; gap: 5px;
      padding: 4px 11px;
      border-radius: 20px;
      font-size: 11px; font-weight: 600;
      margin-top: 6px;
    }
    .status-pill .pill-dot {
      width: 6px; height: 6px;
      border-radius: 50%;
      background: currentColor;
      animation: pillPulse 2s infinite;
    }
    @keyframes pillPulse {
      0%,100% { opacity: 1; } 50% { opacity: .35; }
    }
    .pill-today       { background: #EFF6FF; color: #1D4ED8; border: 1px solid #BFDBFE; }
    .pill-upcoming    { background: #FFF7ED; color: #C2410C; border: 1px solid #FED7AA; }
    .pill-rescheduled { background: #FFF7ED; color: #B45309; border: 1px solid #FDE68A; }
    .pill-cancelled   { background: #FEF2F2; color: #B91C1C; border: 1px solid #FECACA; }
    .pill-completed   { background: #F0FDF4; color: #15803D; border: 1px solid #BBF7D0; }
    .pill-default     { background: #F9FAFB; color: #374151; border: 1px solid #E5E7EB; }

    /* icon box */
    .icon-box {
      width: 40px; height: 40px;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }

    @media (max-width: 1024px) { .grid-cols-6 { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
    @media (max-width: 640px)  { .grid-cols-6 { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
  </style>
</head>

<body class="bg-[#F4F4F4] text-[#333333] font-normal">

  <!-- ═══════════════════════════════════════════
       HEADER — UNCHANGED
  ═══════════════════════════════════════════ -->
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

  <!-- ═══════════════════════════════════════════
       SIDEBAR — UNCHANGED
  ═══════════════════════════════════════════ -->
  <aside id="sidebar"
    class="fixed left-0 top-[80px] h-[calc(100vh-80px)] w-[72px]
           bg-[#FAFAFA] drop-shadow-xl transition-all duration-300
           flex flex-col justify-between z-40">
    <div>
      <div id="sidebarToggleWrapper"
        class="flex items-center justify-center px-4 py-6 transition-all duration-300">
        <button onclick="toggleSidebar()" id="sidebarToggleBtn"
          class="w-10 h-10 flex items-center justify-center rounded-full
                 text-[#757575] hover:text-[#8B0000] hover:bg-[#D9D9D9] transition-all duration-300">
          <i id="sidebarIcon" class="fa-solid fa-bars text-lg"></i>
        </button>
      </div>
      <nav class="space-y-2 px-3 text-gray-600 text-sm">
        <a href="{{ route('dentist.dashboard') }}"
          class="sidebar-link relative flex items-center rounded-xl transition-all duration-200
                 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                 {{ request()->routeIs('dentist.dashboard') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                       {{ request()->routeIs('dentist.dashboard') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-chart-line text-lg"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Dashboard</span>
          <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
                       text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95
                       pointer-events-none transition-all duration-200">Dashboard</span>
        </a>
        <a href="{{ route('dentist.patients') }}"
          class="sidebar-link relative flex items-center rounded-xl transition-all duration-200
                 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                 {{ request()->routeIs('dentist.patients*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                       {{ request()->routeIs('dentist.patients*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-users text-lg"></i>
          <span class="sidebar-text font-bold opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Patients</span>
          <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
                       text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95
                       pointer-events-none transition-all duration-200">Patients</span>
        </a>
        <a href="{{ route('dentist.appointments') }}"
          class="sidebar-link relative flex items-center rounded-xl transition-all duration-200
                 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                 {{ request()->routeIs('dentist.appointments*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                       {{ request()->routeIs('dentist.appointments*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-calendar-check text-lg"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Appointments</span>
          <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
                       text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95
                       pointer-events-none transition-all duration-200">Appointments</span>
        </a>
        <a href="{{ route('dentist.documentrequests') }}"
          class="sidebar-link relative flex items-center rounded-xl transition-all duration-200
                 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                 {{ request()->routeIs('dentist.documentrequests*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                       {{ request()->routeIs('dentist.documentrequests*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-file-circle-check text-lg"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Document Requests</span>
          <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
                       text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95
                       pointer-events-none transition-all duration-200">Document Requests</span>
        </a>
        <a href="{{ route('dentist.inventory') }}"
          class="sidebar-link relative flex items-center rounded-xl transition-all duration-200
                 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                 {{ request()->routeIs('dentist.inventory*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                       {{ request()->routeIs('dentist.inventory*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-box text-lg"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Inventory</span>
          <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
                       text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95
                       pointer-events-none transition-all duration-200">Inventory</span>
        </a>
        <a href="{{ route('dentist.report') }}"
          class="sidebar-link relative flex items-center rounded-xl transition-all duration-200
                 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                 {{ request()->routeIs('dentist.report*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                       {{ request()->routeIs('dentist.report*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-file text-lg"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Reports</span>
          <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
                       text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95
                       pointer-events-none transition-all duration-200">Reports</span>
        </a>
      </nav>
    </div>
    <div class="px-3 pb-5 space-y-2">
      <button id="themeToggle"
        class="sidebar-link relative flex items-center justify-center w-full px-2 py-1.5 rounded-xl
               bg-[#7B6CF6] text-[#F4F4F4] transition-all duration-200 hover:scale-105"
        aria-label="Toggle dark mode">
        <i id="themeIcon" class="fa-regular fa-moon text-sm"></i>
        <span class="sidebar-text text-sm opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Dark Mode</span>
        <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
                     text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95
                     pointer-events-none transition-all duration-200">Dark Mode</span>
      </button>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="sidebar-link w-full relative flex items-center px-3 py-2 rounded-xl text-sm
                       text-red-600 hover:bg-red-50 transition-all duration-200">
          <i class="fa-solid fa-right-from-bracket text-sm"></i>
          <span class="sidebar-text opacity-0 w-0 overflow-hidden transition-all duration-300 delay-150">Log out</span>
          <span class="sidebar-tooltip absolute left-full ml-8 px-3 py-1 rounded-full bg-[#8B0000]
                       text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95
                       pointer-events-none transition-all duration-200">Log out</span>
        </button>
      </form>
    </div>
  </aside>

  <!-- ═══════════════════════════════════════════
       MAIN CONTENT
  ═══════════════════════════════════════════ -->
  <main id="mainContent"
    class="pt-[100px] px-6 py-10 w-full transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]">

    <div class="max-w-7xl mt-4 mx-auto fade-in">
      <div class="px-2 md:px-6">

        <!-- Title + Search / Filter — UNCHANGED -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
          <div class="mb-6">
            <h2 class="text-3xl font-bold text-[#8B0000]">Patient List</h2>
            <p class="text-gray-500 mt-1">Click to Access Patient Information</p>
          </div>
          <div class="flex items-center gap-6 w-full md:w-auto">
            <div id="searchWrapper"
              class="flex items-center bg-gradient-to-r from-[#8B0000] to-[#F2C94C] p-[2px] rounded-full w-full md:w-auto">
              <div id="searchInner" class="flex items-center bg-white rounded-full overflow-hidden w-full h-12">
                <div class="flex items-center gap-2 pl-3 pr-5 py-2 flex-1">
                  <span class="w-7 h-7 rounded-full bg-[#8B0000] flex items-center justify-center">
                    <i class="fa-solid fa-magnifying-glass text-white text-[11px]"></i>
                  </span>
                  <input id="searchInput" type="text" placeholder="Search"
                    class="w-full md:w-72 bg-transparent text-sm text-gray-700 placeholder:text-gray-300 focus:outline-none" />
                </div>
                <div id="searchDivider" class="w-[2px] self-stretch bg-[#F2C94C]"></div>
                <button id="openFilter" type="button"
                  class="h-full px-6 flex items-center gap-2 font-semibold
                         text-[#8B0000] bg-white rounded-none rounded-r-full border-0">
                  <i class="fa-solid fa-sliders"></i>Filter
                </button>
              </div>
            </div>
            <button id="clearBtn" type="button" class="text-[#8B0000] text-sm font-medium hover:underline">Clear</button>
          </div>
        </div>

        @php
        use Carbon\Carbon;
        $today = Carbon::today()->toDateString();
        $appts = ($appointments instanceof \Illuminate\Pagination\AbstractPaginator)
          ? collect($appointments->items()) : collect($appointments);

        $todayCount       = $appts->filter(fn($a) => $a->appointment_date === $today && !in_array(strtolower($a->status ?? ''), ['cancelled','completed']))->count();
        $upcomingCount    = $appts->filter(fn($a) => $a->appointment_date > $today && in_array(strtolower($a->status ?? ''), ['pending','confirmed']))->count();
        $rescheduledCount = $appts->filter(fn($a) => strtolower($a->status ?? '') === 'rescheduled')->count();
        $cancelledCount   = $appts->filter(fn($a) => strtolower($a->status ?? '') === 'cancelled')->count();
        $completedCount   = $appts->filter(fn($a) => strtolower($a->status ?? '') === 'completed')->count();
        $allCount         = $appts->count();
        @endphp

        <div class="w-full max-w-6xl mx-auto">
          <div class="mx-4">
            <div class="mx-4 relative">

              <!-- ═══════════════════════════════
                   TABS — white card style
              ═══════════════════════════════ -->
              <div class="grid grid-cols-6 gap-3 px-6 relative z-20 mb-4">

                <!-- SCHEDULED TODAY -->
                <button class="filter-btn tab-btn tab-scheduled" data-filter="today" type="button">
                  <div class="tab-top-row">
                    <div class="tab-icon-wrap">
                      <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <span class="tab-count">{{ $todayCount ?? 0 }}</span>
                  </div>
                  <span class="tab-label">Scheduled Today</span>
                </button>

                <!-- UPCOMING -->
                <button class="filter-btn tab-btn tab-upcoming" data-filter="upcoming" type="button">
                  <div class="tab-top-row">
                    <div class="tab-icon-wrap">
                      <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <span class="tab-count">{{ $upcomingCount ?? 0 }}</span>
                  </div>
                  <span class="tab-label">Upcoming</span>
                </button>

                <!-- RESCHEDULED -->
                <button class="filter-btn tab-btn tab-rescheduled" data-filter="rescheduled" type="button">
                  <div class="tab-top-row">
                    <div class="tab-icon-wrap">
                      <i class="fa-solid fa-rotate"></i>
                    </div>
                    <span class="tab-count">{{ $rescheduledCount ?? 0 }}</span>
                  </div>
                  <span class="tab-label">Rescheduled</span>
                </button>

                <!-- CANCELLED -->
                <button class="filter-btn tab-btn tab-cancelled" data-filter="cancelled" type="button">
                  <div class="tab-top-row">
                    <div class="tab-icon-wrap">
                      <i class="fa-solid fa-xmark"></i>
                    </div>
                    <span class="tab-count">{{ $cancelledCount ?? 0 }}</span>
                  </div>
                  <span class="tab-label">Cancelled</span>
                </button>

                <!-- COMPLETED -->
                <button class="filter-btn tab-btn tab-completed" data-filter="completed" type="button">
                  <div class="tab-top-row">
                    <div class="tab-icon-wrap">
                      <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <span class="tab-count">{{ $completedCount ?? 0 }}</span>
                  </div>
                  <span class="tab-label">Completed</span>
                </button>

                <!-- ALL -->
                <button class="filter-btn tab-btn tab-all" data-filter="all" type="button">
                  <div class="tab-top-row">
                    <div class="tab-icon-wrap">
                      <i class="fa-solid fa-clipboard-list"></i>
                    </div>
                    <span class="tab-count">{{ $allCount ?? 0 }}</span>
                  </div>
                  <span class="tab-label">All Patients</span>
                </button>

              </div>
              <!-- /tabs -->

              <!-- ═══════════════════════════════
                   PATIENT CARDS CONTAINER
              ═══════════════════════════════ -->
              <div class="mx-4 shadow-lg rounded-2xl bg-white overflow-hidden relative">
                <div id="patientContainer" class="space-y-3 px-6 pb-6 pt-5">

                  @forelse($appointments as $appt)
                  @php
                  $status       = strtolower($appt->status ?? '');
                  $isCancelled  = $status === 'cancelled';
                  $isCompleted  = $status === 'completed';
                  $isRescheduled= $status === 'rescheduled';
                  $isToday      = ($appt->appointment_date === $today) && !$isCancelled && !$isCompleted;
                  $isUpcoming   = ($appt->appointment_date > $today) && in_array($status, ['pending','confirmed'], true);

                  $tabClass = $isCancelled ? 'cancelled' :
                    ($isCompleted   ? 'completed'    :
                    ($isRescheduled ? 'rescheduled'  :
                    ($isToday       ? 'today'        :
                    ($isUpcoming    ? 'upcoming'     : 'all'))));

                  $patientName  = $appt->patient->name ?? 'Unknown Patient';
                  $dateLabel    = Carbon::parse($appt->appointment_date)->format('d M Y');
                  $timeLabel    = Carbon::parse($appt->appointment_time)->format('g:i A');
                  $serviceLabel = ($appt->service_type === 'Others')
                    ? ($appt->other_services ?: 'Others') : $appt->service_type;

                  // accent bar class
                  $accentClass = $isCancelled   ? 'accent-cancelled'  :
                    ($isCompleted   ? 'accent-completed'  :
                    ($isRescheduled ? 'accent-rescheduled':
                    ($isToday       ? 'accent-today'      :
                    ($isUpcoming    ? 'accent-upcoming'   : 'accent-default'))));

                  // icon box classes
                  $iconBg = $isCancelled   ? 'bg-red-100'    :
                    ($isCompleted   ? 'bg-green-100'  :
                    ($isRescheduled ? 'bg-orange-100' :
                    ($isToday       ? 'bg-blue-100'   :
                    ($isUpcoming    ? 'bg-orange-100' : 'bg-gray-100'))));
                  $iconColor = $isCancelled   ? 'text-red-600'    :
                    ($isCompleted   ? 'text-green-600'  :
                    ($isRescheduled ? 'text-orange-600' :
                    ($isToday       ? 'text-blue-600'   :
                    ($isUpcoming    ? 'text-orange-600' : 'text-gray-500'))));

                  // pill class
                  $pillClass = $isCancelled   ? 'pill-cancelled'  :
                    ($isCompleted   ? 'pill-completed'  :
                    ($isRescheduled ? 'pill-rescheduled':
                    ($isToday       ? 'pill-today'      :
                    ($isUpcoming    ? 'pill-upcoming'   : 'pill-default'))));
                  $pillText  = $isCancelled   ? 'Cancelled'         :
                    ($isCompleted   ? 'Completed'         :
                    ($isRescheduled ? 'Rescheduled'       :
                    ($isToday       ? 'Appointment Today' :
                    ($isUpcoming    ? 'Upcoming · '.ucfirst($status) : ucfirst($status ?: 'Pending')))));
                  @endphp

                  <a href="{{ route('dentist.patient.profile') }}"
                    class="patient-card patient-item all {{ $tabClass }} block">

                    <!-- accent bar -->
                    <div class="accent-bar {{ $accentClass }}"></div>

                    <div class="flex items-center gap-5 px-8 py-5 pl-10">

                      <!-- Avatar -->
                      <img src="https://i.pravatar.cc/80?u={{ $appt->patient_id }}"
                        class="w-14 h-14 rounded-2xl object-cover shadow-sm border-2 border-gray-100 flex-shrink-0"
                        alt="Patient" />

                      <!-- Name + ID -->
                      <div class="w-44 flex-shrink-0">
                        <p class="font-semibold text-[#1a1a1a] text-sm leading-tight">{{ $patientName }}</p>
                        <span class="inline-block mt-1.5 px-2.5 py-0.5 rounded-full bg-gray-100
                                     text-gray-500 text-[11px] font-medium">
                          ID #{{ $appt->patient_id }}
                        </span>
                        <span class="patient-info hidden">N/A|N/A|N/A|{{ $appt->appointment_date }}|N/A</span>
                      </div>

                      <!-- Divider -->
                      <div class="w-px h-10 bg-gray-200 flex-shrink-0"></div>

                      <!-- Date & Time -->
                      <div class="flex items-start gap-3 w-44 flex-shrink-0">
                        <div class="icon-box bg-blue-50">
                          <i class="fa-regular fa-calendar text-blue-500 text-base"></i>
                        </div>
                        <div>
                          <p class="text-[10px] font-600 text-gray-400 uppercase tracking-wide mb-1">Date &amp; Time</p>
                          <p class="font-semibold text-[#1a1a1a] text-sm">{{ $dateLabel }}</p>
                          <p class="text-gray-500 text-xs mt-0.5">{{ $timeLabel }}</p>
                        </div>
                      </div>

                      <!-- Divider -->
                      <div class="w-px h-10 bg-gray-200 flex-shrink-0"></div>

                      <!-- Service + Status -->
                      <div class="flex items-start gap-3 flex-1 min-w-0">
                        <div class="icon-box {{ $iconBg }} flex-shrink-0">
                          <i class="fa-solid fa-tooth {{ $iconColor }} text-base"></i>
                        </div>
                        <div class="min-w-0">
                          <p class="text-[10px] font-600 text-gray-400 uppercase tracking-wide mb-1">Service</p>
                          <p class="font-semibold text-[#1a1a1a] text-sm truncate">{{ $serviceLabel }}</p>
                          <span class="status-pill {{ $pillClass }}">
                            <span class="pill-dot"></span>
                            {{ $pillText }}
                          </span>
                        </div>
                      </div>

                      <!-- Arrow CTA -->
                      <div class="card-arrow-btn ml-auto flex-shrink-0">
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                      </div>

                    </div>
                  </a>

                  @empty
                  <div class="py-16 text-center">
                    <div class="text-5xl mb-4 opacity-20">🦷</div>
                    <p class="text-gray-400 font-medium">No appointments found.</p>
                  </div>
                  @endforelse

                </div>

                <!-- Pagination — UNCHANGED -->
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
              <!-- /patient container -->

            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <!-- ═══════════════════════════════════════════
       FILTER MODAL — UNCHANGED
  ═══════════════════════════════════════════ -->
  <div id="filterModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-[760px] rounded-xl shadow-2xl overflow-hidden border border-gray-200 flex flex-col">
      <div class="px-6 py-4 flex items-center gap-3">
        <i class="fa-solid fa-sliders text-[#8B0000]"></i>
        <h2 class="text-xl font-medium text-[#8B0000]">Filter</h2>
      </div>
      <div class="h-px bg-gray-200"></div>
      <div class="px-6 py-5 space-y-5 max-h-[76vh] overflow-y-auto scroll-smooth">
        <div class="space-y-3">
          <p class="text-sm text-gray-500">Sort</p>
          <div class="space-y-2">
            <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="sort" value="A-Z" class="filter-input radio-red" /> A-Z</label>
            <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="sort" value="Z-A" class="filter-input radio-red" /> Z-A</label>
          </div>
        </div>
        <div class="h-px bg-gray-200"></div>
        <div class="space-y-3">
          <p class="text-sm text-gray-500">Date Range</p>
          <div class="grid grid-cols-12 gap-6 items-start">
            <div class="col-span-8">
              <div class="grid grid-cols-2 gap-10">
                <div class="space-y-2">
                  <label class="text-sm text-gray-700">From:</label>
                  <input type="date" id="fromDate" class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-200" />
                </div>
                <div class="space-y-2">
                  <label class="text-sm text-gray-700">To:</label>
                  <input type="date" id="toDate" class="w-full bg-white border border-gray-200 rounded-md px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-200" />
                </div>
              </div>
            </div>
            <div class="col-span-4 space-y-2 pt-6">
              <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="dateOrder" value="Ascending" class="radio-red" /> Ascending</label>
              <label class="flex items-center gap-3 text-sm text-gray-700"><input type="radio" name="dateOrder" value="Descending" class="radio-red" /> Descending</label>
            </div>
          </div>
        </div>
        <div class="h-px bg-gray-200"></div>
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
        <div class="space-y-3">
          <p class="text-sm text-gray-500">Department</p>
          <div class="flex flex-wrap gap-x-12 gap-y-4 text-sm text-gray-700">
            <label class="flex items-center gap-3 whitespace-nowrap"><input type="radio" name="department" value="Administrative" class="filter-input radio-red" /> Administrative</label>
            <label class="flex items-center gap-3 whitespace-nowrap"><input type="radio" name="department" value="Faculty" class="filter-input radio-red" /> Faculty</label>
            <label class="flex items-center gap-3 whitespace-nowrap"><input type="radio" name="department" value="Dependent" class="filter-input radio-red" /> Dependent</label>
          </div>
        </div>
      </div>
      <div class="h-px bg-gray-200"></div>
      <div class="px-6 py-4 flex items-center justify-between bg-white">
        <button id="clearFiltersModal" type="button" class="text-[#8B0000] text-sm font-medium hover:underline">Clear</button>
        <button id="applyFilters" type="button"
          class="bg-[#8B0000] text-white px-8 py-2 rounded-md text-sm font-medium shadow hover:bg-[#760000] transition">Save</button>
      </div>
    </div>
  </div>

  <!-- Footer — UNCHANGED -->
  <footer class="footer sm:footer-horizontal bg-[#660000] text-[#F4F4F4] p-10"></footer>

  <!-- ═══════════════════════════════════════════
       ALL JAVASCRIPT — UNCHANGED
  ═══════════════════════════════════════════ -->
  <script>
    /* DARK MODE */
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon   = document.getElementById('themeIcon');
    const html        = document.documentElement;
    const savedTheme  = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);
    themeToggle?.addEventListener('click', () => {
      const newTheme = html.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
      html.setAttribute('data-theme', newTheme);
      localStorage.setItem('theme', newTheme);
      updateThemeIcon(newTheme);
    });
    function updateThemeIcon(theme) {
      if (!themeIcon) return;
      themeIcon.classList.toggle('fa-moon', theme !== 'dark');
      themeIcon.classList.toggle('fa-sun',  theme === 'dark');
    }

    /* SIDEBAR */
    let sidebarOpen = false;
    function applyLayout(w) {
      const s = document.getElementById('sidebar');
      const m = document.getElementById('mainContent');
      if (!s || !m) return;
      s.style.width = w; m.style.marginLeft = w; m.style.width = 'auto';
    }
    function toggleSidebar() {
      const toggleWrapper = document.getElementById('sidebarToggleWrapper');
      const texts = document.querySelectorAll('.sidebar-text');
      const icon  = document.getElementById('sidebarIcon');
      sidebarOpen = !sidebarOpen;
      if (sidebarOpen) {
        applyLayout('16rem');
        texts.forEach(t => { t.classList.remove('opacity-0','w-0'); t.classList.add('opacity-100','w-auto'); });
        toggleWrapper?.classList.replace('justify-center','justify-end');
        document.getElementById('sidebarToggleBtn')?.classList.add('translate-x-2');
        icon?.classList.replace('fa-bars','fa-xmark');
      } else {
        applyLayout('72px');
        texts.forEach(t => { t.classList.add('opacity-0','w-0'); t.classList.remove('opacity-100','w-auto'); });
        toggleWrapper?.classList.replace('justify-end','justify-center');
        document.getElementById('sidebarToggleBtn')?.classList.remove('translate-x-2');
        icon?.classList.replace('fa-xmark','fa-bars');
      }
    }
    document.addEventListener('DOMContentLoaded', () => { sidebarOpen = false; applyLayout('72px'); });

    /* TAB ACTIVE STATE — add visual active class */
    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('tab-active'));
        btn.classList.add('tab-active');
      });
    });

    /* PATIENT LIST FILTER + PAGINATION */
    document.addEventListener("DOMContentLoaded", () => {
      const patientContainer = document.getElementById("patientContainer");
      if (!patientContainer) return;

      const allPatients       = Array.from(patientContainer.querySelectorAll(".patient-item"));
      const filterModal       = document.getElementById("filterModal");
      const filterPill        = document.getElementById("openFilter");
      const clearFiltersModal = document.getElementById("clearFiltersModal");
      const applyFiltersBtn   = document.getElementById("applyFilters");
      const searchInput       = document.getElementById("searchInput");
      const clearBtn          = document.getElementById("clearBtn");
      const filterButtons     = document.querySelectorAll(".filter-btn");

      const countEls = {
        today:       document.querySelector('.filter-btn[data-filter="today"] .tab-count'),
        upcoming:    document.querySelector('.filter-btn[data-filter="upcoming"] .tab-count'),
        rescheduled: document.querySelector('.filter-btn[data-filter="rescheduled"] .tab-count'),
        cancelled:   document.querySelector('.filter-btn[data-filter="cancelled"] .tab-count'),
        completed:   document.querySelector('.filter-btn[data-filter="completed"] .tab-count'),
        all:         document.querySelector('.filter-btn[data-filter="all"] .tab-count'),
      };

      let activeTab = "today", searchKeyword = "";
      let selectedProgram = null, selectedYearLevel = null, selectedSection = null, selectedDepartment = null;
      let nameSort = null, dateSort = null;
      let selectedMonth = null, selectedCalendarYear = null;
      let activeFromDate = "", activeToDate = "";

      const deptRadios  = [...document.querySelectorAll('input[name="department"]')];
      const courseRadios= [...document.querySelectorAll('input[name="course"]')];
      const yearRadios  = [...document.querySelectorAll('input[name="year"]')];
      const sectionRadios=[...document.querySelectorAll('input[name="section"]')];
      const otherRadios = [...courseRadios,...yearRadios,...sectionRadios];

      const anyChecked  = list => list.some(i => i.checked);
      const setDisabled = (list, d) => list.forEach(i => {
        i.disabled = d;
        i.closest("label")?.classList.toggle("opacity-50", d);
        i.closest("label")?.classList.toggle("cursor-not-allowed", d);
      });
      const clearChecked= list => list.forEach(i => i.checked = false);

      function syncMutualExclusion() {
        if (anyChecked(deptRadios))  { clearChecked(otherRadios); setDisabled(otherRadios,true);  setDisabled(deptRadios,false); return; }
        if (anyChecked(otherRadios)) { clearChecked(deptRadios);  setDisabled(deptRadios,true);   setDisabled(otherRadios,false); return; }
        setDisabled(deptRadios,false); setDisabled(otherRadios,false);
      }
      [...deptRadios,...otherRadios].forEach(r => r.addEventListener("change", syncMutualExclusion));

      const getInfo = p => {
        const parts = (p.querySelector(".patient-info")?.textContent?.trim() || "").split("|").map(s => s.trim());
        return { program: parts[0]||"", year: parts[1]||"", section: parts[2]||"", dateStr: parts[3]||"", department: parts[4]||p.dataset.department||"" };
      };
      const getName = p => (p.querySelector(".font-semibold")?.textContent||"").trim();
      const getType = p => p.dataset.type||"";
      const ilike   = (val,t) => (val||"").toLowerCase().includes((t||"").toLowerCase());

      function updateFilterButtonState() {
        const has = !!searchKeyword||!!selectedProgram||!!selectedYearLevel||!!selectedSection||!!selectedDepartment||!!nameSort||!!dateSort||!!activeFromDate||!!activeToDate;
        filterPill?.classList.toggle("filter-active", has);
      }

      filterPill?.addEventListener("click", e => { e.preventDefault(); filterModal?.classList.remove("hidden"); syncMutualExclusion(); });
      filterModal?.addEventListener("click", e => { if (e.target === filterModal) { filterModal.classList.add("hidden"); updateFilterButtonState(); } });
      document.addEventListener("keydown", e => { if (e.key==="Escape") { filterModal?.classList.add("hidden"); updateFilterButtonState(); } });
      clearBtn?.addEventListener("click", () => { if (!searchInput) return; searchInput.value=""; searchInput.dispatchEvent(new Event("input")); });

      const pagination = document.getElementById("pagination");
      const pageNumbers= document.getElementById("pageNumbers");
      const prevPageBtn= document.getElementById("prevPage");
      const nextPageBtn= document.getElementById("nextPage");
      const PER_PAGE   = 5;
      let currentPage  = 1, currentItems = [];

      function renderPagination(items) {
        currentItems = items;
        const total  = Math.ceil(items.length / PER_PAGE);
        if (pageNumbers) pageNumbers.innerHTML = "";
        if (total <= 1) { pagination?.classList.add("hidden"); return; }
        pagination?.classList.remove("hidden");
        for (let i = 1; i <= total; i++) {
          const btn = document.createElement("button");
          btn.textContent = i;
          btn.className = i===currentPage ? "px-3 py-1 text-[#8B0000] font-medium" : "px-3 py-1 hover:text-[#8B0000]";
          btn.addEventListener("click", () => { currentPage=i; updatePage(); });
          pageNumbers?.appendChild(btn);
        }
        if (prevPageBtn) { prevPageBtn.disabled=currentPage===1; prevPageBtn.classList.toggle("cursor-not-allowed",currentPage===1); prevPageBtn.classList.toggle("text-gray-300",currentPage===1); }
        if (nextPageBtn) { nextPageBtn.disabled=currentPage===total; nextPageBtn.classList.toggle("cursor-not-allowed",currentPage===total); nextPageBtn.classList.toggle("text-gray-300",currentPage===total); }
      }

      function updatePage() {
        const s = (currentPage-1)*PER_PAGE, e = s+PER_PAGE;
        patientContainer.innerHTML = "";
        currentItems.slice(s,e).forEach(p => patientContainer.appendChild(p));
        renderPagination(currentItems);
      }

      prevPageBtn?.addEventListener("click", () => { if (currentPage>1) { currentPage--; updatePage(); } });
      nextPageBtn?.addEventListener("click", () => { if (currentPage < Math.ceil(currentItems.length/PER_PAGE)) { currentPage++; updatePage(); } });

      function applyFilters() {
        let data = [...allPatients];
        if (activeTab !== "all") data = data.filter(p => p.classList.contains(activeTab));
        if (searchKeyword) data = data.filter(p => `${getName(p)} ${getInfo(p).program} ${getType(p)} ${getInfo(p).department}`.toLowerCase().includes(searchKeyword));
        if (selectedProgram)    data = data.filter(p => ilike(getInfo(p).program, selectedProgram));
        if (selectedYearLevel || selectedSection) data = data.filter(p => {
          const i = getInfo(p);
          if (selectedYearLevel && !ilike(i.year, selectedYearLevel)) return false;
          if (selectedSection   && String(i.section).trim() !== String(selectedSection).trim()) return false;
          return true;
        });
        if (selectedDepartment) data = data.filter(p => ilike(getInfo(p).department, selectedDepartment));
        if (activeFromDate || activeToDate) data = data.filter(p => {
          const d = new Date(getInfo(p).dateStr);
          if (isNaN(d)) return false;
          if (activeFromDate && d < new Date(activeFromDate)) return false;
          if (activeToDate   && d > new Date(activeToDate))   return false;
          return true;
        });
        if (selectedMonth && selectedCalendarYear) data = data.filter(p => {
          const d = new Date(getInfo(p).dateStr);
          if (isNaN(d)) return false;
          return String(d.getMonth()+1).padStart(2,"0")===selectedMonth && String(d.getFullYear())===selectedCalendarYear;
        });
        if (nameSort==="az") data.sort((a,b) => getName(a).localeCompare(getName(b)));
        if (nameSort==="za") data.sort((a,b) => getName(b).localeCompare(getName(a)));
        if (dateSort==="asc")  data.sort((a,b) => new Date(getInfo(a).dateStr)-new Date(getInfo(b).dateStr));
        if (dateSort==="desc") data.sort((a,b) => new Date(getInfo(b).dateStr)-new Date(getInfo(a).dateStr));

        currentPage = 1;
        renderPagination(data);
        updatePage();
        updateCounts();
        updateFilterButtonState();
      }

      function computeCount(tab) {
        let data = [...allPatients];
        if (tab!=="all") data = data.filter(p => p.classList.contains(tab));
        if (searchKeyword) data = data.filter(p => `${getName(p)} ${getInfo(p).program} ${getType(p)} ${getInfo(p).department}`.toLowerCase().includes(searchKeyword));
        if (selectedProgram)    data = data.filter(p => ilike(getInfo(p).program, selectedProgram));
        if (selectedYearLevel || selectedSection) data = data.filter(p => { const i=getInfo(p); if(selectedYearLevel&&!ilike(i.year,selectedYearLevel))return false; if(selectedSection&&String(i.section).trim()!==String(selectedSection).trim())return false; return true; });
        if (selectedDepartment) data = data.filter(p => ilike(getInfo(p).department, selectedDepartment));
        if (activeFromDate||activeToDate) data = data.filter(p => { const d=new Date(getInfo(p).dateStr); if(isNaN(d))return false; if(activeFromDate&&d<new Date(activeFromDate))return false; if(activeToDate&&d>new Date(activeToDate))return false; return true; });
        return data.length;
      }

      function updateCounts() {
        Object.keys(countEls).forEach(tab => { if (countEls[tab]) countEls[tab].textContent = computeCount(tab); });
      }

      filterButtons.forEach(btn => { btn.addEventListener("click", () => { activeTab=btn.dataset.filter; applyFilters(); }); });
      searchInput?.addEventListener("input", () => { searchKeyword=searchInput.value.trim().toLowerCase(); applyFilters(); });

      applyFiltersBtn?.addEventListener("click", () => {
        selectedDepartment = filterModal?.querySelector('input[name="department"]:checked')?.value||null;
        selectedProgram    = filterModal?.querySelector('input[name="course"]:checked')?.value||null;
        selectedYearLevel  = filterModal?.querySelector('input[name="year"]:checked')?.value||null;
        selectedSection    = filterModal?.querySelector('input[name="section"]:checked')?.value||null;
        const sv = filterModal?.querySelector('input[name="sort"]:checked')?.value||null;
        nameSort = sv==="A-Z"||sv==="az" ? "az" : sv==="Z-A"||sv==="za" ? "za" : null;
        const dv = filterModal?.querySelector('input[name="dateOrder"]:checked')?.value||null;
        dateSort = dv==="Ascending"||dv==="asc" ? "asc" : dv==="Descending"||dv==="desc" ? "desc" : null;
        activeFromDate = document.getElementById("fromDate")?.value||"";
        activeToDate   = document.getElementById("toDate")?.value||"";
        filterModal?.classList.add("hidden");
        syncMutualExclusion();
        applyFilters();
        updateFilterButtonState();
      });

      clearFiltersModal?.addEventListener("click", () => {
        filterModal?.querySelectorAll("input[type='radio']").forEach(i => { i.checked=false; i.disabled=false; i.closest("label")?.classList.remove("opacity-50","cursor-not-allowed"); });
        const f=document.getElementById("fromDate"); const t=document.getElementById("toDate");
        if(f)f.value=""; if(t)t.value="";
        selectedDepartment=selectedProgram=selectedYearLevel=selectedSection=nameSort=dateSort=null;
        activeFromDate=activeToDate="";
        syncMutualExclusion(); filterModal?.classList.add("hidden"); applyFilters(); updateFilterButtonState();
      });

      syncMutualExclusion();
      applyFilters();
    });

    /* NOTIFICATION DROPDOWN */
    document.addEventListener("DOMContentLoaded", () => {
      const btn  = document.getElementById("notifBtn");
      const menu = document.getElementById("notifMenu");
      if (!btn || !menu) return;
      let isOpen = false;
      const openMenu  = () => { isOpen=true;  menu.classList.remove("notif-close"); menu.classList.add("notif-open"); };
      const closeMenu = () => { isOpen=false; menu.classList.remove("notif-open");  menu.classList.add("notif-close"); };
      btn.addEventListener("click", e => { e.stopPropagation(); isOpen ? closeMenu() : openMenu(); });
      menu.addEventListener("click", e => e.stopPropagation());
      document.addEventListener("click", () => { if(isOpen) closeMenu(); });
      document.addEventListener("keydown", e => { if(e.key==="Escape"&&isOpen) closeMenu(); });
      closeMenu();
    });
  </script>

</body>
</html>