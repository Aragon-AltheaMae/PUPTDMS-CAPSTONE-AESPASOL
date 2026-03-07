<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Appointment</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind + daisyUI CDN -->
  <script type="module" src="https://unpkg.com/cally"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      daisyui: { themes: false },
    }
  </script>

  <style>
    body { font-family: 'Inter'; }

    .tabs-bordered .tab { transition: color 0.5s ease, font-weight 0.5s ease; }
    .tabs-bordered .tab::after { transition: width 0.5s ease, left 0.5s ease; }

    @keyframes fadeUp {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.8s ease-out forwards; }

    .service-card {
      position: relative;
      overflow: hidden;
      transition: transform 0.45s ease, box-shadow 0.45s ease;
    }
    .service-card::before {
      content: "";
      position: absolute;
      inset: -12px;
      background: linear-gradient(135deg, #8B0000, #660000);
      opacity: 0;
      border-radius: 1.25rem;
      transition: opacity 0.45s ease;
      z-index: 0;
    }
    .service-card:hover::before { opacity: 1; }
    .service-card:hover {
      transform: scale(1.06);
      z-index: 20;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.35);
    }
    .service-card>* { position: relative; z-index: 1; }
    .service-card img { transition: transform 0.45s ease; }
    .service-card:hover img { transform: translateX(-6px) scale(1.08); }

    /* Sidebar */
    .sidebar-link { display: flex; align-items: center; transition: background-color 0.2s ease, transform 0.2s ease; }

    #sidebar.expanded .sidebar-link { justify-content: flex-start; }
    #sidebar.expanded .sidebar-link i { margin-right: 0.75rem; }
    #sidebar.expanded .sidebar-link:hover { transform: translateX(4px); }
    #sidebar.expanded .sidebar-tooltip { display: none; }
    #sidebar.expanded .nav-section-label { display: block; }
    #sidebar.expanded .sidebar-text { opacity: 1; width: auto; overflow: visible; }

    #sidebar.collapsed .sidebar-link { justify-content: center; }
    #sidebar.collapsed .sidebar-text { opacity: 0; width: 0; overflow: hidden; }
    #sidebar.collapsed .sidebar-tooltip { display: block; }
    #sidebar.collapsed .nav-section-label { display: none; }

    .sidebar-link:hover .sidebar-tooltip { opacity: 1 !important; transform: scale(1) !important; }

    .nav-section-label {
      font-size: 0.65rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      color: #9CA3AF;
      text-transform: uppercase;
      margin-bottom: 0.25rem;
    }

    .notif-open { opacity: 1 !important; transform: scale(1) !important; pointer-events: auto !important; }
    .notif-close { opacity: 0 !important; transform: scale(0.95) !important; pointer-events: none !important; }

    [data-theme="dark"] body { background-color: #111827; color: #E5E7EB; }
    [data-theme="dark"] #sidebar { background-color: #1F2933; }
    [data-theme="dark"] .bg-white { background-color: #1F2937 !important; }
    [data-theme="dark"] .text-\[\#333333\] { color: #E5E7EB !important; }

    body, #sidebar, main, .card, .modal-box { transition: background-color 0.3s ease, color 0.3s ease; }

    .sidebar-link.bg-\[\#8B0000\] { box-shadow: 0 0 12px rgba(139, 0, 0, 0.45); }

    /* ── MY APPOINTMENTS REDESIGN ── */
    .appt-section-title {
      font-size: 1.875rem;
      font-weight: 700;
      color: #660000;
      line-height: 1.1;
    }
    .appt-section-subtitle {
      font-size: 13px;
      color: #8A8A9A;
      margin-top: 3px;
    }

    /* Book button */
    .appt-book-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #8B0000;
      color: white;
      font-family: 'DM Sans', sans-serif;
      font-size: 13.5px;
      font-weight: 600;
      padding: 11px 22px;
      border-radius: 50px;
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.2s ease;
      box-shadow: 0 4px 16px rgba(139,0,0,0.25);
      white-space: nowrap;
    }
    .appt-book-btn:hover {
      background: #A31515;
      box-shadow: 0 6px 22px rgba(139,0,0,0.35);
      transform: translateY(-1px);
      color: white;
    }

    /* Tab toggle */
    .appt-tabs {
      display: flex;
      background: #FFFFFF;
      border-radius: 14px;
      padding: 5px;
      width: fit-content;
      box-shadow: 0 1px 4px rgba(0,0,0,0.06);
      border: 1px solid #E8E0E0;
      margin-bottom: 20px;
    }
    .appt-tab {
      font-family: 'DM Sans', sans-serif;
      font-size: 13.5px;
      font-weight: 500;
      padding: 9px 22px;
      border-radius: 10px;
      border: none;
      background: transparent;
      color: #8A8A9A;
      cursor: pointer;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .appt-tab .appt-count {
      font-size: 11px;
      font-weight: 700;
      background: #E8E0E0;
      color: #8A8A9A;
      padding: 1px 7px;
      border-radius: 20px;
      transition: all 0.2s ease;
    }
    .appt-tab.appt-active {
      background: #8B0000;
      color: white;
      box-shadow: 0 2px 10px rgba(139,0,0,0.2);
    }
    .appt-tab.appt-active .appt-count {
      background: rgba(255,255,255,0.25);
      color: white;
    }

    /* Card */
    .appt-card-new {
      background: #FFFFFF;
      border-radius: 18px;
      border: 1px solid #E8E0E0;
      display: grid;
      grid-template-columns: 90px 1fr auto;
      overflow: hidden;
      transition: box-shadow 0.2s ease, transform 0.2s ease;
      box-shadow: 0 1px 6px rgba(0,0,0,0.05);
      margin-bottom: 14px;
      animation: apptSlideUp 0.35s ease backwards;
    }
    .appt-card-new:hover {
      box-shadow: 0 8px 30px rgba(0,0,0,0.10);
      transform: translateY(-2px);
    }
    .appt-card-new:nth-child(2) { animation-delay: 0.07s; }
    .appt-card-new:nth-child(3) { animation-delay: 0.14s; }
    @keyframes apptSlideUp {
      from { opacity: 0; transform: translateY(14px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Date column */
    .appt-date-col {
      background: #FDF1F1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 22px 10px;
      border-right: 1px solid #F0DADA;
      flex-shrink: 0;
    }
    .appt-card-new.appt-past .appt-date-col {
      background: #F4F4F6;
      border-right-color: #E0E0E6;
    }
    .appt-date-day {
      font-size: 36px;
      font-weight: 800;
      color: #8B0000;
      line-height: 1;
    }
    .appt-card-new.appt-past .appt-date-day { color: #8A8A9A; }
    .appt-date-month {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: #C0392B;
      margin-top: 2px;
    }
    .appt-card-new.appt-past .appt-date-month { color: #ADADAD; }
    .appt-date-year {
      font-size: 11px;
      color: #8A8A9A;
      margin-top: 1px;
    }

    /* Body */
    .appt-body-new {
      padding: 18px 22px;
      display: flex;
      flex-direction: column;
      gap: 9px;
    }
    .appt-top-row {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }
    .appt-service-name {
      font-family: 'DM Sans', sans-serif;
      font-size: 15.5px;
      font-weight: 600;
      color: #2D2D3A;
    }
    .appt-card-new.appt-past .appt-service-name { color: #5A5A6A; }

    /* Status badges */
    .appt-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-family: 'DM Sans', sans-serif;
      font-size: 10.5px;
      font-weight: 700;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      padding: 3px 10px;
      border-radius: 20px;
    }
    .appt-badge-upcoming   { background: #FEF3E2; color: #E67E22; }
    .appt-badge-confirmed { background: #E8F8EE; color: #27AE60; }
    .appt-badge-completed { background: #EAF0FB; color: #3B6CC7; }
    .appt-badge-cancelled { background: #F5F5F5; color: #999999; }
    .appt-badge-scheduled { background: #FEF3E2; color: #E67E22; }

    .appt-status-dot {
      width: 6px; height: 6px;
      border-radius: 50%;
      background: currentColor;
      animation: apptPulse 2s infinite;
    }
    @keyframes apptPulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.35; }
    }

    /* Meta row */
    .appt-meta-row {
      display: flex;
      gap: 18px;
      flex-wrap: wrap;
    }
    .appt-meta-item {
      display: flex;
      align-items: center;
      gap: 6px;
      font-family: 'DM Sans', sans-serif;
      font-size: 12.5px;
      color: #8A8A9A;
    }
    .appt-meta-item i {
      font-size: 12px;
      color: #C0392B;
      opacity: 0.7;
    }
    .appt-meta-item strong {
      color: #2D2D3A;
      font-weight: 500;
    }

    /* Actions column */
    .appt-actions-col {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      justify-content: space-between;
      padding: 18px 18px 18px 0;
      gap: 10px;
      flex-shrink: 0;
    }
    .appt-more-btn {
      width: 30px; height: 30px;
      border-radius: 50%;
      border: 1px solid #E8E0E0;
      background: transparent;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: #8A8A9A;
      transition: all 0.18s ease;
    }
    .appt-more-btn:hover {
      background: #FDF1F1;
      border-color: #C0392B;
      color: #8B0000;
    }
    .appt-countdown {
      font-family: 'DM Sans', sans-serif;
      font-size: 11px;
      font-weight: 600;
      color: #8B0000;
      background: #FDF1F1;
      padding: 4px 10px;
      border-radius: 20px;
      white-space: nowrap;
      border: 1px solid #F0DADA;
    }
    .appt-rebook-btn {
      font-family: 'DM Sans', sans-serif;
      font-size: 11px;
      font-weight: 600;
      color: #8B0000;
      background: #FDF1F1;
      border: 1px solid #F0DADA;
      padding: 4px 12px;
      border-radius: 20px;
      cursor: pointer;
      white-space: nowrap;
      transition: all 0.18s ease;
      text-decoration: none;
    }
    .appt-rebook-btn:hover {
      background: #8B0000;
      color: white;
      border-color: #8B0000;
    }

    /* Section divider label */
    .appt-divider-label {
      font-family: 'DM Sans', sans-serif;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: #ADADAD;
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .appt-divider-label::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #E8E0E0;
    }

    /* Empty state */
    .appt-empty {
      text-align: center;
      padding: 52px 20px;
      background: #FFFFFF;
      border-radius: 18px;
      border: 1px dashed #E8E0E0;
    }
    .appt-empty img { width: 80px; height: 80px; margin: 0 auto 12px; opacity: 0.6; }
    .appt-empty-title {
      font-size: 18px;
      color: #8A8A9A;
      margin-bottom: 4px;
    }
    .appt-empty-sub {
      font-family: 'DM Sans', sans-serif;
      font-size: 12.5px;
      color: #ADADAD;
    }

    /* DETAILS MODAL (matches your screenshot) */
    dialog#appt_detail_modal::backdrop {
      background: rgba(16,16,16,.45);
    }
  </style>
</head>

<body class="bg-white text-[#333333] font-normal">

  <!-- HEADER -->
  <div class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-[#660000] to-[#8B0000]
              text-[#F4F4F4] px-6 py-4 flex items-center justify-between">

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

        <div id="notifMenu" class="absolute right-0 mt-3 w-80 rounded-2xl bg-white shadow-xl border border-gray-200 z-50
                                  opacity-0 scale-95 pointer-events-none transition-all duration-200 ease-out origin-top-right">
          <div class="p-4 border-b flex items-center justify-between">
            <span class="font-bold text-[#8B0000]">Notifications</span>
          </div>
          <div class="max-h-80 overflow-y-auto">
            @forelse($notifications as $n)
              <a href="{{ $n['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50">
                <div class="text-sm font-semibold text-gray-900">{{ $n['title'] ?? 'Notification' }}</div>
                @if(!empty($n['message']))
                  <div class="text-xs text-[#ADADAD] mt-0.5">{{ $n['message'] }}</div>
                @endif
                @if(!empty($n['time']))
                  <div class="text-[11px] text-gray-400 mt-1">{{ $n['time'] }}</div>
                @endif
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

      <div class="w-px h-8 bg-white/30"></div>

      <div class="flex items-center gap-3">
        <div class="avatar">
          <div class="w-10 rounded-full overflow-hidden">
            <img
              src="{{ $patient->profile_image
                  ? asset('storage/'.$patient->profile_image)
                  : 'https://ui-avatars.com/api/?name='.urlencode($patient->name).'&background=660000&color=FFFFFF&rounded=true&size=128' }}"
              alt="Profile" />
          </div>
        </div>
        <div class="leading-tight">
          <div class="text-l font-semibold text-[#F4F4F4]">{{ ucwords(strtolower($patient->name)) }}</div>
          <div class="italic text-xs text-[#F4F4F4]/80">Student</div>
        </div>
      </div>
    </div>
  </div>

  <!-- SIDEBAR -->
  <aside id="sidebar" class="fixed left-0 top-[72px] h-[calc(100vh-72px)] bg-white drop-shadow-xl
                             transition-all duration-300 flex flex-col justify-between z-40 expanded"
         style="width: 200px;">
    <div class="pt-4">
      <div id="sidebarToggleWrapper" class="flex items-center justify-end px-4 py-2">
        <button onclick="toggleSidebar()" id="sidebarToggleBtn"
                class="w-8 h-8 flex items-center justify-center rounded-full text-[#757575]
                       hover:text-[#8B0000] hover:bg-[#F0F0F0] transition-all duration-300">
          <i id="sidebarIcon" class="fa-solid fa-bars text-base"></i>
        </button>
      </div>

      <div class="nav-section-label px-4 mb-6">Navigation</div>

      <nav class="space-y-2 px-3 text-gray-600">
        <a href="{{ route('homepage') }}"
           class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl mt-8
                  transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                  {{ request()->routeIs('homepage') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000]
                       transition-opacity duration-300 {{ request()->routeIs('homepage') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-house text-base w-5"></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Home</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4]
                       text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Home</span>
        </a>

        <a href="{{ route('appointment.index') }}"
           class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl
                  transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                  {{ request()->routeIs('appointment.index*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000]
                       transition-opacity duration-300 {{ request()->routeIs('appointment.index*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-regular fa-calendar text-base w-5"></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Appointment</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4]
                       text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Appointment</span>
        </a>

        <a href="{{ route('record') }}"
           class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl
                  transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                  {{ request()->routeIs('record*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000]
                       transition-opacity duration-300 {{ request()->routeIs('record*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-regular fa-folder-open text-base w-5"></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Record</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4]
                       text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Record</span>
        </a>

        <a href="{{ route('about.us') }}"
           class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl
                  transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                  {{ request()->routeIs('about.us*') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000]
                       transition-opacity duration-300 {{ request()->routeIs('about.us*') ? 'opacity-100' : 'opacity-0' }}"></span>
          <i class="fa-solid fa-circle-info text-base w-5"></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">About Us</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4]
                       text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">About Us</span>
        </a>
      </nav>
    </div>

    <div class="px-3 pb-5 space-y-2">
      <a href="#"
         class="sidebar-link relative flex items-center px-3 py-2.5 rounded-xl hover:bg-gray-100 transition-all duration-200 text-gray-500">
        <i class="fa-regular fa-circle-question text-base w-5"></i>
        <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Help</span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4]
                     text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Help</span>
      </a>

      <button id="themeToggle"
              class="sidebar-link relative flex items-center w-full px-3 py-2.5 rounded-xl
                     bg-[#7B6CF6] text-[#F4F4F4] transition-all duration-200 hover:scale-105"
              aria-label="Toggle dark mode">
        <i id="themeIcon" class="fa-regular fa-moon text-base w-5"></i>
        <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Dark Mode</span>
        <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4]
                     text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Dark Mode</span>
      </button>

      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="sidebar-link w-full relative flex items-center px-3 py-2.5 rounded-xl text-red-600 hover:bg-red-50 transition-all duration-200">
          <i class="fa-solid fa-right-from-bracket text-base w-5"></i>
          <span class="sidebar-text ml-3 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Log Out</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4]
                       text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Log Out</span>
        </button>
      </form>
    </div>
  </aside>

  <!-- ================= MAIN CONTENT ================= -->
  <main id="mainContent" class="pt-[100px] px-6 py-6 fade-up min-h-screen">
    <div class="max-w-7xl mt-4 mx-auto">

      <!-- BREADCRUMB -->
      <div class="text-sm mb-4 font-medium fade-up">
        <span class="text-gray-400">User</span>
        <span class="mx-1 text-gray-400">&gt;</span>
        <span class="text-[#8B0000] font-semibold">Appointment</span>
      </div>

      <!-- ===== CLINIC SCHEDULE CALENDAR ===== -->
      <section class="fade-up mb-14">
        <div id="calendarSkeletonContainer" class="bg-white border shadow-sm rounded-2xl p-6 mx-auto" style="max-width:700px; min-height:480px;">
          <div class="animate-pulse space-y-4">
            <div class="h-6 w-32 bg-gray-200 rounded mx-auto"></div>
            <div class="grid grid-cols-7 gap-2">
              @for($i = 0; $i < 35; $i++)
                <div class="h-9 bg-gray-200 rounded-lg"></div>
              @endfor
            </div>
          </div>
        </div>
      </section>

      <!-- ===== MY APPOINTMENTS (REDESIGNED) ===== -->
      <section class="max-w-6xl mx-auto fade-up mb-16">

        {{-- Section Header --}}
        <div class="flex justify-between items-end mb-6">
          <div>
            <h2 class="appt-section-title">My Appointments</h2>
            <p class="appt-section-subtitle">
              You have {{ $futureVisits->count() }} upcoming
              {{ $futureVisits->count() === 1 ? 'visit' : 'visits' }} scheduled
            </p>
          </div>
          <a href="{{ route('book.appointment.create') }}" class="appt-book-btn">
            <i class="fa-solid fa-plus text-xs"></i>
            Book Appointment
          </a>
        </div>

        {{-- Tab Toggle --}}
        @php
          $futureCount = $futureVisits->count();
          $pastCount   = $pastVisits->count();
        @endphp
        <div class="appt-tabs">
          <button class="appt-tab appt-active" id="apptFutureTab" onclick="apptShowFuture()">
            Future Visits
            <span class="appt-count">{{ $futureCount }}</span>
          </button>
          <button class="appt-tab" id="apptPastTab" onclick="apptShowPast()">
            Past Visits
            <span class="appt-count">{{ $pastCount }}</span>
          </button>
        </div>

        {{-- ── FUTURE VISITS PANEL ── --}}
        <div id="apptFuturePanel">
          @if($futureVisits->count())
            <div class="appt-divider-label">Upcoming</div>
            @foreach($futureVisits as $appt)
              @php
                $apptDate   = \Carbon\Carbon::parse($appt->appointment_date);
                $apptTime   = \Carbon\Carbon::parse($appt->appointment_time);
                $now        = \Carbon\Carbon::now();
                $diffDays   = (int) $now->startOfDay()->diffInDays($apptDate->copy()->startOfDay(), false);
                if ($diffDays === 0)      $countdown = 'Today';
                elseif ($diffDays === 1)  $countdown = 'Tomorrow';
                else                      $countdown = 'In ' . $diffDays . ' days';

                $rawStatus  = strtolower($appt->status ?? 'scheduled');
                $badgeClass = match($rawStatus) {
                  'upcoming'   => 'appt-badge-upcoming',
                  'confirmed' => 'appt-badge-confirmed',
                  default     => 'appt-badge-scheduled',
                };
                $showDot    = in_array($rawStatus, ['upcoming', 'scheduled']);
              @endphp
              <div class="appt-card-new">
                {{-- Date --}}
                <div class="appt-date-col">
                  <span class="appt-date-day">{{ $apptDate->format('d') }}</span>
                  <span class="appt-date-month">{{ $apptDate->format('M') }}</span>
                  <span class="appt-date-year">{{ $apptDate->format('Y') }}</span>
                </div>

                {{-- Body --}}
                <div class="appt-body-new">
                  <div class="appt-top-row">
                    <span class="appt-service-name">
                      {{ $appt->service_type }}{{ $appt->other_services ? ' ('.$appt->other_services.')' : '' }}
                    </span>
                    <span class="appt-badge {{ $badgeClass }}">
                      @if($showDot)<span class="appt-status-dot"></span>@endif
                      {{ ucfirst($rawStatus) }}
                    </span>
                  </div>
                  <div class="appt-meta-row">
                    <div class="appt-meta-item">
                      <i class="fa-regular fa-clock"></i>
                      <strong>{{ $apptTime->format('g:i A') }} – {{ $apptTime->copy()->addHour()->format('g:i A') }}</strong>
                    </div>
                    <div class="appt-meta-item">
                      <i class="fa-regular fa-user"></i>
                      Dr. Nelson Angeles
                    </div>
                  </div>
                </div>

                {{-- Actions --}}
                <div class="appt-actions-col">
                  <button class="appt-more-btn" title="Options">
                    <i class="fa-solid fa-ellipsis-vertical text-xs"></i>
                  </button>
                  <span class="appt-countdown">{{ $countdown }}</span>
                </div>
              </div>
            @endforeach
          @else
            <div class="appt-empty">
              <img src="{{ asset('images/future-visit.png') }}" alt="No Upcoming Visits">
              <p class="appt-empty-title">No Upcoming Visits</p>
              <p class="appt-empty-sub">You currently have no scheduled appointments.</p>
            </div>
          @endif
        </div>

        {{-- ── PAST VISITS PANEL ── --}}
        <div id="apptPastPanel" style="display:none;">
          @if($pastVisits->count())
            <div class="appt-divider-label">Recent History</div>
            @foreach($pastVisits as $appt)
              @php
                $apptDate   = \Carbon\Carbon::parse($appt->appointment_date);
                $apptTime   = \Carbon\Carbon::parse($appt->appointment_time);
               $rawStatus = 'completed';

$badgeClass = 'appt-badge-completed';
               $badgeIcon = '<i class="fa-solid fa-check" style="font-size:9px"></i>';

                // IMPORTANT: data for modal
                $modalPayload = [
                  'service' => $appt->service_type ?? '—',
                  'date' => $appt->appointment_date ? \Carbon\Carbon::parse($appt->appointment_date)->format('F d, Y') : '—',
                  'time' => $appt->appointment_time ? \Carbon\Carbon::parse($appt->appointment_time)->format('H:i:s') : '—', // matches your screenshot "10:00:00"
                  'status' => $rawStatus ?: 'completed',
                  'duration' => $appt->duration ?? '—',
                  'remarks' => $appt->remarks ?? '—',
                  'oral' => $appt->oral_examination ?? '—',
                  'diagnosis' => $appt->diagnosis ?? '—',
                  'prescription' => $appt->prescription ?? '—',
                ];
              @endphp
              <div class="appt-card-new appt-past">
                {{-- Date --}}
                <div class="appt-date-col">
                  <span class="appt-date-day">{{ $apptDate->format('d') }}</span>
                  <span class="appt-date-month">{{ $apptDate->format('M') }}</span>
                  <span class="appt-date-year">{{ $apptDate->format('Y') }}</span>
                </div>

                {{-- Body --}}
                <div class="appt-body-new">
                  <div class="appt-top-row">
                    <span class="appt-service-name">
                      {{ $appt->service_type }}{{ $appt->other_services ? ' ('.$appt->other_services.')' : '' }}
                    </span>
                    <span class="appt-badge {{ $badgeClass }}">
                      {!! $badgeIcon !!}
                      {{ ucfirst($rawStatus) }}
                    </span>
                  </div>
                  <div class="appt-meta-row">
                    <div class="appt-meta-item">
                      <i class="fa-regular fa-clock"></i>
                      <strong>{{ $apptTime->format('g:i A') }} – {{ $apptTime->copy()->addHour()->format('g:i A') }}</strong>
                    </div>
                    <div class="appt-meta-item">
                      <i class="fa-regular fa-user"></i>
                      Dr. Nelson Angeles
                    </div>
                  </div>
                </div>

                {{-- Actions --}}
                <div class="appt-actions-col">
                  <button class="appt-more-btn" title="Options">
                    <i class="fa-solid fa-ellipsis-vertical text-xs"></i>
                  </button>

                  {{-- ✅ FIX: Details now opens modal (no redirect) --}}
                  <button type="button"
                    class="appt-rebook-btn"
                    data-appt='@json($modalPayload)'
                    onclick="openApptDetailModal(this)">
                    Details
                  </button>
                </div>
              </div>
            @endforeach
          @else
            <div class="appt-empty">
              <img src="{{ asset('images/past-visit.png') }}" alt="No Past Visits">
              <p class="appt-empty-title">No Past Visits Yet</p>
              <p class="appt-empty-sub">Your completed appointments will appear here.</p>
            </div>
          @endif
        </div>

      </section>

      <!-- SERVICES OFFERED -->
      <section class="max-w-6xl mx-auto mt-4 mb-4 fade-up">
        <h2 class="text-4xl font-bold bg-gradient-to-r from-[#8B0000] to-[#FFD700]
                bg-clip-text text-transparent mb-6">
          Services Offered
        </h2>

        <div class="grid md:grid-cols-2 rounded-2xl overflow-hidden bg-[#8B0000]">
          <div class="service-card relative p-10 text-[#F4F4F4] border-b border-r border-[#F4F4F4]/60">
            <h3 class="text-2xl font-bold mb-2">Oral Check-Up</h3>
            <p class="text-sm max-w-xs">Routine oral examination • Dental consultation</p>
            <img src="{{ asset('images/oral-checkup.png') }}" class="absolute right-6 inset-y-0 my-auto w-28" alt="Oral Checkup" />
          </div>
          <div class="service-card relative p-10 text-[#F4F4F4] border-b border-r border-[#F4F4F4]/60">
            <h3 class="text-2xl font-bold mb-2">Dental Cleaning</h3>
            <p class="text-sm max-w-xs">Oral hygiene treatment • Removing surface buildup</p>
            <img src="{{ asset('images/dental-cleaning.png') }}" class="absolute right-6 inset-y-0 my-auto w-28" alt="Dental Cleaning" />
          </div>
          <div class="service-card relative p-10 text-[#F4F4F4] border-b border-r border-[#F4F4F4]/60">
            <h3 class="text-2xl font-bold mb-2">Dental Restoration & Prosthesis</h3>
            <p class="text-sm max-w-xs">Repairs/replaces damaged teeth • Fillings • Crowns • Inlay • etc.</p>
            <img src="{{ asset('images/restoration-prosthesis.png') }}" class="absolute right-6 inset-y-0 my-auto w-28" alt="Restoration & Prosthesis" />
          </div>
          <div class="service-card relative p-10 text-[#F4F4F4] border-b border-r border-[#F4F4F4]/60">
            <h3 class="text-2xl font-bold mb-2">Dental Surgery</h3>
            <p class="text-sm max-w-xs">Treating dental issues surgically • Extraction • Supernumerary • etc.</p>
            <img src="{{ asset('images/dental-surgery.png') }}" class="absolute right-6 inset-y-0 my-auto w-28" alt="Dental Surgery" />
          </div>
        </div>
      </section>

    </div>
  </main>

  <!-- ✅ DETAILS MODAL (UI matches your screenshot) -->
  <dialog id="appt_detail_modal" class="modal">
    <div class="modal-box p-0 w-full max-w-md rounded-2xl bg-[#F4F4F4] overflow-hidden">

      <!-- Header -->
      <div class="bg-[#7A0000] px-6 py-5 text-white">
        <h3 id="d_service" class="text-2xl font-extrabold leading-tight">—</h3>
        <div class="mt-2 flex items-center gap-3 text-white/90 text-sm">
          <div class="flex items-center gap-2">
            <i class="fa-regular fa-calendar"></i>
            <span id="d_date">—</span>
          </div>
          <span class="opacity-60">·</span>
          <span id="d_time">—</span>
        </div>
      </div>

      <!-- Body -->
      <div class="px-6 py-5 space-y-5">

        <!-- Status + Duration -->
        <div class="grid grid-cols-2 gap-4">
          <div class="bg-white border border-gray-200 rounded-xl px-4 py-3">
            <div class="flex items-center gap-2 text-[11px] font-extrabold tracking-widest text-gray-600">
              <i class="fa-solid fa-circle-check text-gray-800"></i>
              STATUS
            </div>
            <div class="mt-3">
              <span id="d_status"
                class="inline-flex items-center justify-center w-28 px-4 py-1 text-xs rounded-full font-bold bg-emerald-200 text-emerald-900">
                —
              </span>
            </div>
          </div>

          <div class="bg-white border border-gray-200 rounded-xl px-4 py-3">
            <div class="flex items-center gap-2 text-[11px] font-extrabold tracking-widest text-gray-600">
              <i class="fa-solid fa-circle-check text-gray-800"></i>
              DURATION
            </div>
            <div class="mt-3">
              <span id="d_duration"
                class="inline-flex items-center justify-center w-28 px-4 py-1 text-xs rounded-full font-bold bg-gray-200 text-gray-800">
                —
              </span>
            </div>
          </div>
        </div>

        <!-- Section block -->
        <div>
          <div class="flex items-center gap-4 mb-2">
            <span class="text-[11px] font-extrabold tracking-widest text-[#8B0000]">TREATMENT</span>
            <div class="h-px flex-1 bg-gray-300"></div>
          </div>
          <div class="bg-white rounded-xl overflow-hidden">
            <div class="grid grid-cols-[6px_1fr]">
              <div class="bg-gray-300"></div>
              <div class="p-4 text-gray-700 text-sm leading-relaxed">
                <span id="d_remarks">—</span>
              </div>
            </div>
          </div>
        </div>

        <div>
          <div class="flex items-center gap-4 mb-2">
            <span class="text-[11px] font-extrabold tracking-widest text-[#8B0000]">ORAL EXAMINATION</span>
            <div class="h-px flex-1 bg-gray-300"></div>
          </div>
          <div class="bg-white rounded-xl overflow-hidden">
            <div class="grid grid-cols-[6px_1fr]">
              <div class="bg-gray-300"></div>
              <div class="p-4 text-gray-700 text-sm leading-relaxed">
                <span id="d_oral">—</span>
              </div>
            </div>
          </div>
        </div>

        <div>
          <div class="flex items-center gap-4 mb-2">
            <span class="text-[11px] font-extrabold tracking-widest text-[#8B0000]">DIAGNOSIS</span>
            <div class="h-px flex-1 bg-gray-300"></div>
          </div>
          <div class="bg-white rounded-xl overflow-hidden">
            <div class="grid grid-cols-[6px_1fr]">
              <div class="bg-gray-300"></div>
              <div class="p-4 text-gray-700 text-sm leading-relaxed">
                <span id="d_diagnosis">—</span>
              </div>
            </div>
          </div>
        </div>

        <div>
          <div class="flex items-center gap-4 mb-2">
            <span class="text-[11px] font-extrabold tracking-widest text-[#8B0000]">PRESCRIPTION</span>
            <div class="h-px flex-1 bg-gray-300"></div>
          </div>
          <div class="bg-white rounded-xl overflow-hidden">
            <div class="grid grid-cols-[6px_1fr]">
              <div class="bg-gray-300"></div>
              <div class="p-4 text-gray-700 text-sm leading-relaxed">
                <span id="d_prescription">—</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Close -->
        <div class="flex justify-end pt-2">
          <form method="dialog">
            <button class="px-8 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300 transition">
              Close
            </button>
          </form>
        </div>

      </div>
    </div>

    <form method="dialog" class="modal-backdrop">
      <button>close</button>
    </form>
  </dialog>

  <!-- MODAL: one appointment only -->
  <dialog id="activeAppointmentModal" class="modal">
    <div class="modal-box swal-card rounded-2xl bg-white text-center shadow-2xl w-[min(92vw,420px)]">
      <div class="mx-auto mb-4 w-16 h-16 rounded-full bg-[#FFF0F0] flex items-center justify-center">
        <i class="fa-solid fa-calendar-xmark text-[#8B0000] text-2xl"></i>
      </div>
      <h3 class="text-xl font-extrabold text-[#8B0000] mb-2">One Appointment at a Time</h3>
      <p class="text-sm text-[#333] mb-6 leading-relaxed">
        {{ session('activeAppointmentMsg') ?? "You already have an active appointment. Please wait until it is completed before booking another one." }}
      </p>
      <div class="flex items-center justify-center gap-3">
        <a href="{{ route('appointment.index') }}" class="btn border-none bg-[#8B0000] hover:bg-[#660000] text-white rounded-xl px-5">
          <i class="fa-regular fa-calendar-check"></i>
          View My Appointment
        </a>
        <button type="button" id="closeActiveApptModalBtn" class="btn btn-ghost rounded-xl px-6">Close</button>
      </div>
    </div>
  </dialog>

  @if(session('activeAppointmentModal'))
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const modal = document.getElementById("activeAppointmentModal");
      const closeBtn = document.getElementById("closeActiveApptModalBtn");
      if (!modal) return;
      modal.showModal();
      modal.addEventListener('click', (e) => {
        const box = modal.querySelector('.modal-box');
        if (!box) return;
        if (!box.contains(e.target)) e.preventDefault();
      });
      modal.addEventListener('cancel', (e) => e.preventDefault());
      if (closeBtn) closeBtn.addEventListener("click", () => modal.close());
    });
  </script>
  @endif

  <script>
    // ✅ Appointment Details Modal
    function openApptDetailModal(btn) {
      const modal = document.getElementById('appt_detail_modal');
      if (!modal) return;

      let data = {};
      try {
        data = JSON.parse(btn.getAttribute('data-appt') || '{}');
      } catch (e) {
        data = {};
      }

      const setText = (id, val) => {
        const el = document.getElementById(id);
        if (el) el.textContent = (val ?? '').toString().trim() || '—';
      };

      setText('d_service', data.service);
      setText('d_date', data.date);
      setText('d_time', data.time);

      // status pill color
      const statusEl = document.getElementById('d_status');
      if (statusEl) {
        const s = (data.status || 'completed').toString().trim().toLowerCase();
        statusEl.textContent = s || '—';
        statusEl.className = 'inline-flex items-center justify-center w-28 px-4 py-1 text-xs rounded-full font-bold';

        if (s === 'completed') statusEl.classList.add('bg-emerald-200', 'text-emerald-900');
        else if (s === 'confirmed') statusEl.classList.add('bg-emerald-200', 'text-emerald-900');
        else if (s === 'upcoming' || s === 'scheduled') statusEl.classList.add('bg-yellow-200', 'text-yellow-900');
        else if (s === 'cancelled') statusEl.classList.add('bg-gray-200', 'text-gray-700');
        else statusEl.classList.add('bg-gray-200', 'text-gray-800');
      }

      setText('d_duration', data.duration);
      setText('d_remarks', data.remarks);
      setText('d_oral', data.oral);
      setText('d_diagnosis', data.diagnosis);
      setText('d_prescription', data.prescription);

      modal.showModal();
    }

    // ── SIDEBAR ──
    let sidebarOpen = true;

    function applyLayout(sidebarWidth) {
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('mainContent');
      if (!sidebar || !main) return;
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
        applyLayout('200px');
        sidebar.classList.remove('collapsed');
        sidebar.classList.add('expanded');
        texts.forEach(t => { t.classList.remove('opacity-0', 'w-0'); t.classList.add('opacity-100'); });
        toggleWrapper.classList.replace('justify-center', 'justify-end');
        icon.classList.replace('fa-bars', 'fa-xmark');
      } else {
        applyLayout('72px');
        sidebar.classList.remove('expanded');
        sidebar.classList.add('collapsed');
        texts.forEach(t => { t.classList.add('opacity-0', 'w-0'); t.classList.remove('opacity-100'); });
        toggleWrapper.classList.replace('justify-end', 'justify-center');
        icon.classList.replace('fa-xmark', 'fa-bars');
      }
    }

    document.addEventListener('DOMContentLoaded', () => { sidebarOpen = true; applyLayout('200px'); });

    // ── APPOINTMENT TABS ──
    function apptShowFuture() {
      document.getElementById('apptFuturePanel').style.display = 'block';
      document.getElementById('apptPastPanel').style.display   = 'none';
      document.getElementById('apptFutureTab').classList.add('appt-active');
      document.getElementById('apptPastTab').classList.remove('appt-active');
    }

    function apptShowPast() {
      document.getElementById('apptFuturePanel').style.display = 'none';
      document.getElementById('apptPastPanel').style.display   = 'block';
      document.getElementById('apptPastTab').classList.add('appt-active');
      document.getElementById('apptFutureTab').classList.remove('appt-active');
    }

    // ── NOTIFICATIONS ──
    document.addEventListener("DOMContentLoaded", () => {
      const btn  = document.getElementById("notifBtn");
      const menu = document.getElementById("notifMenu");
      if (!btn || !menu) return;
      let isOpen = false;
      const openMenu  = () => { isOpen = true;  menu.classList.replace("notif-close", "notif-open"); };
      const closeMenu = () => { isOpen = false; menu.classList.replace("notif-open", "notif-close"); };
      btn.addEventListener("click", (e) => { e.stopPropagation(); isOpen ? closeMenu() : openMenu(); });
      menu.addEventListener("click", (e) => e.stopPropagation());
      document.addEventListener("click", () => { if (isOpen) closeMenu(); });
      document.addEventListener("keydown", (e) => { if (e.key === "Escape" && isOpen) closeMenu(); });
      closeMenu();
    });

    // ── CALENDAR ──
    function loadCalendar() {
      const MAX_PER_DAY = 5;
      const myAppointments = {
        @if(isset($appointments) && $appointments->count() > 0)
          @foreach($appointments as $appt)
            "{{ \Carbon\Carbon::parse($appt->appointment_date)->format('Y-m-d') }}": "{{ addslashes($appt->service_type) }} • {{ \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') }}",
          @endforeach
        @endif
      };
      const apptCounts = {
        @if(isset($appointmentCountsPerDay) && count($appointmentCountsPerDay) > 0)
          @foreach($appointmentCountsPerDay as $date => $count)
            "{{ $date }}": {{ (int)$count }},
          @endforeach
        @endif
      };
      const unavailableDates = [
        @foreach(($unavailableDates ?? []) as $d) "{{ $d }}", @endforeach
      ];
      const allHolidays = {
        @foreach(($philippineHolidays ?? []) as $date => $name)
          "{{ $date }}": "{{ addslashes($name) }}",
        @endforeach
      };

      const today = new Date();
      let currentYear  = today.getFullYear();
      let currentMonth = today.getMonth();

      function pad(n) { return String(n).padStart(2, '0'); }
      function isWeekend(y, m, d) { const dow = new Date(y, m, d).getDay(); return dow === 0 || dow === 6; }
      function getHolidaysForMonth(y, m) {
        const filtered = {};
        Object.keys(allHolidays).forEach(ds => {
          const [hy, hm] = ds.split('-').map(Number);
          if (hy === y && hm === m + 1) filtered[ds] = allHolidays[ds];
        });
        return filtered;
      }

      function renderCalendar(year, month) {
        const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        const dayLabels  = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
        const firstDow   = new Date(year, month, 1).getDay();
        const totalDays  = new Date(year, month + 1, 0).getDate();
        const holidays   = getHolidaysForMonth(year, month);
        let cells = '';
        for (let i = 0; i < firstDow; i++) cells += `<div></div>`;
        for (let d = 1; d <= totalDays; d++) {
          const dateStr  = `${year}-${pad(month+1)}-${pad(d)}`;
          const isToday  = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
          const weekend  = isWeekend(year, month, d);
          const holiday  = holidays[dateStr] || null;
          const myAppt   = myAppointments[dateStr] || null;
          const count    = apptCounts[dateStr] || 0;
          const isFull   = count >= MAX_PER_DAY;
          const isUnavail = unavailableDates.includes(dateStr) || weekend;
          let bgClass = '', textClass = 'text-[#333333]', ringClass = '', dotHtml = '', tooltipTxt = '';
          if (isToday) { bgClass = 'bg-[#8B0000]'; textClass = 'text-white font-extrabold'; ringClass = 'ring-2 ring-[#8B0000]/30 ring-offset-1'; }
          else if (holiday) { bgClass = 'bg-blue-50 hover:bg-blue-100'; textClass = 'text-blue-700 font-semibold'; }
          else if (isUnavail) { textClass = 'text-gray-300'; }
          else { bgClass = 'hover:bg-[#FFF0F0]'; }
          if (myAppt) {
            dotHtml += `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full ${isToday ? 'bg-white' : 'bg-[#008440]'}"></span>`;
            tooltipTxt = `<i class="fa-regular fa-calendar-check mr-1 text-[#6EE7A0]"></i>${myAppt}`;
          }
          if (isFull && !myAppt && !isUnavail && !holiday) {
            dotHtml += `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-red-500"></span>`;
            tooltipTxt = `<i class="fa-solid fa-circle-xmark mr-1 text-red-400"></i>Fully booked (${count} appointments)`;
          }
          if (holiday && !myAppt) {
            dotHtml = `<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-blue-400"></span>`;
            tooltipTxt = `<i class="fa-solid fa-star mr-1 text-blue-300"></i>${holiday}`;
          }
          if (isUnavail && !holiday && !myAppt) {
            tooltipTxt = weekend ? `<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Clinic closed` : `<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Not available`;
          }
          const tooltipHtml = tooltipTxt ? `
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 z-50
                        bg-[#1a1a1a] text-white text-[11px] font-medium px-3 py-1.5 rounded-lg
                        whitespace-nowrap shadow-xl opacity-0 group-hover:opacity-100 pointer-events-none
                        transition-opacity duration-200">
              ${tooltipTxt}
              <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-[#1a1a1a]"></div>
            </div>` : '';
          cells += `
            <div class="relative group flex items-center justify-center">
              ${tooltipHtml}
              <div class="relative w-9 h-9 flex items-center justify-center text-sm rounded-full
                          transition-all duration-150 ${bgClass} ${textClass} ${ringClass} cursor-default">
                ${d}${dotHtml}
              </div>
            </div>`;
        }
        const headerHtml = dayLabels.map((l, i) =>
          `<div class="text-center text-[10px] font-bold ${(i===0||i===6)?'text-[#8B0000]/40':'text-[#333333]'} uppercase tracking-widest">${l}</div>`
        ).join('');
        document.getElementById("calendarSkeletonContainer").innerHTML = `
          <div class="h-full flex flex-col select-none">
            <div class="flex items-center justify-center gap-2 mb-3">
              <i class="fa-regular fa-calendar-check text-[#333333] text-xl"></i>
              <h2 class="text-xl font-extrabold text-[#333333]">Dental Clinic Schedule</h2>
            </div>
            <hr class="border-t border-gray-200 mb-4">
            <div class="flex items-center justify-between mt-6 mb-5">
              <button onclick="changeMonth(-1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] text-[#8B0000] transition-colors duration-150">
                <i class="fa-solid fa-chevron-left text-xs"></i>
              </button>
              <div class="text-center">
                <p class="text-lg font-extrabold text-[#8B0000]">${monthNames[month]}</p>
                <p class="text-xs text-[#9CA3AF] font-semibold tracking-widest">${year}</p>
              </div>
              <button onclick="changeMonth(1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] text-[#8B0000] transition-colors duration-150">
                <i class="fa-solid fa-chevron-right text-xs"></i>
              </button>
            </div>
            <div class="grid grid-cols-7 gap-2 mt-4 mb-2">${headerHtml}</div>
            <div class="grid grid-cols-7 space-y-4 gap-2 flex-1 content-start">${cells}</div>
          </div>`;
      }

      window.changeMonth = function(dir) {
        currentMonth += dir;
        if (currentMonth > 11) { currentMonth = 0; currentYear++; }
        if (currentMonth < 0)  { currentMonth = 11; currentYear--; }
        renderCalendar(currentYear, currentMonth);
      };

      renderCalendar(currentYear, currentMonth);
    }

    document.addEventListener('DOMContentLoaded', () => loadCalendar());
  </script>

</body>
</html>