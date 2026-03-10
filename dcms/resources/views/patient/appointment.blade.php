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
      daisyui: {
        themes: false
      },
    }
  </script>

  <style>
    body {
      font-family: 'Inter';
    }

    .tabs-bordered .tab {
      transition: color 0.5s ease, font-weight 0.5s ease;
    }

    .tabs-bordered .tab::after {
      transition: width 0.5s ease, left 0.5s ease;
    }

    @keyframes fadeUp {
      0% {
        opacity: 0;
        transform: translateY(20px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-up {
      animation: fadeUp 0.8s ease-out forwards;
    }

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

    .service-card:hover::before {
      opacity: 1;
    }

    .service-card:hover {
      transform: scale(1.06);
      z-index: 20;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.35);
    }

    .service-card>* {
      position: relative;
      z-index: 1;
    }

    .service-card img {
      transition: transform 0.45s ease;
    }

    .service-card:hover img {
      transform: translateX(-6px) scale(1.08);
    }

    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 50;
      background: linear-gradient(135deg, #6b0000 0%, #8B0000 100%);
      padding: 0 2rem;
      height: 62px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 20px rgba(139, 0, 0, .25);
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: .75rem;
    }

    .header-logo {
      width: 36px;
      height: 36px;
      object-fit: contain;
    }

    .header-title {
      font-size: .95rem;
      font-weight: 700;
      color: #fff;
      letter-spacing: .01em;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 1.25rem;
    }

    .notif-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .12);
      border: none;
      cursor: pointer;
      color: #fff;
      font-size: .95rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background .15s;
      position: relative;
    }

    .notif-btn:hover {
      background: rgba(255, 255, 255, .22);
    }

    .notif-badge {
      position: absolute;
      top: -3px;
      right: -3px;
      background: #ff6b6b;
      color: #fff;
      font-size: .6rem;
      font-weight: 700;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px solid #8B0000;
    }

    .header-user {
      display: flex;
      align-items: center;
      gap: .6rem;
    }

    .header-avatar {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      border: 2px solid rgba(255, 255, 255, .4);
      object-fit: cover;
    }

    .header-name {
      font-size: .82rem;
      font-weight: 600;
      color: #fff;
      line-height: 1.2;
    }

    .header-role {
      font-size: .7rem;
      color: rgba(255, 255, 255, .7);
      font-style: italic;
    }

    #notifMenu {
      position: absolute;
      right: 0;
      top: calc(100% + 10px);
      width: 300px;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, .12);
      border: 1px solid #f0e6e6;
      opacity: 0;
      transform: scale(.95) translateY(-6px);
      pointer-events: none;
      transition: all .2s;
      transform-origin: top right;
      z-index: 100;
    }

    #notifMenu.open {
      opacity: 1;
      transform: scale(1) translateY(0);
      pointer-events: auto;
    }

    #notifDropdown {
      position: relative;
    }

    .sidebar-link {
      display: flex;
      align-items: center;
      transition: background-color .2s ease, transform .2s ease;
    }

    #sidebar.expanded .sidebar-link {
      justify-content: flex-start;
      padding-left: .25rem;
    }

    #sidebar.expanded .sidebar-link i {
      margin-right: .75rem;
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
      font-size: .65rem;
      font-weight: 500;
      letter-spacing: .08em;
      color: #757575;
      text-transform: uppercase;
      margin-bottom: .25rem;
    }

    body,
    #sidebar,
    main,
    .card,
    .modal-box {
      transition: background-color .3s ease, color .3s ease;
    }

    #sidebar.collapsed .sidebar-link {
      justify-content: center;
      padding-left: 0;
      padding-right: 0;
    }

    #sidebar.collapsed .sidebar-link i {
      margin-right: 0 !important;
      width: 100%;
      text-align: center;
    }

    #sidebar.expanded .sidebar-link span i {
      margin-right: 0 !important;
    }

    .sidebar-link.bg-\[\#8B0000\] {
      box-shadow: 0 0 12px rgba(139, 0, 0, .45);
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
      transition: all .3s ease;
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
      transition: color .2s ease;
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
      box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
      transition: all .3s cubic-bezier(.4, 0, .2, 1);
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
      box-shadow: 0 2px 8px rgba(0, 0, 0, .3);
    }

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
      box-shadow: 0 4px 16px rgba(139, 0, 0, 0.25);
      white-space: nowrap;
    }

    .appt-book-btn:hover {
      background: #A31515;
      box-shadow: 0 6px 22px rgba(139, 0, 0, 0.35);
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
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
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
      box-shadow: 0 2px 10px rgba(139, 0, 0, 0.2);
    }

    .appt-tab.appt-active .appt-count {
      background: rgba(255, 255, 255, 0.25);
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
      box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
      margin-bottom: 14px;
      animation: apptSlideUp 0.35s ease backwards;
    }

    .appt-card-new:hover {
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.10);
      transform: translateY(-2px);
    }

    .appt-card-new:nth-child(2) {
      animation-delay: 0.07s;
    }

    .appt-card-new:nth-child(3) {
      animation-delay: 0.14s;
    }

    @keyframes apptSlideUp {
      from {
        opacity: 0;
        transform: translateY(14px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
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

    .appt-card-new.appt-past .appt-date-day {
      color: #8A8A9A;
    }

    .appt-date-month {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: #C0392B;
      margin-top: 2px;
    }

    .appt-card-new.appt-past .appt-date-month {
      color: #ADADAD;
    }

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

    .appt-card-new.appt-past .appt-service-name {
      color: #5A5A6A;
    }

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

    .appt-badge-upcoming {
      background: #FEF3E2;
      color: #E67E22;
    }

    .appt-badge-confirmed {
      background: #E8F8EE;
      color: #27AE60;
    }

    .appt-badge-completed {
      background: #EAF0FB;
      color: #3B6CC7;
    }

    .appt-badge-cancelled {
      background: #F5F5F5;
      color: #999999;
    }

    .appt-badge-scheduled {
      background: #FEF3E2;
      color: #E67E22;
    }

    .appt-status-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: currentColor;
      animation: apptPulse 2s infinite;
    }

    @keyframes apptPulse {

      0%,
      100% {
        opacity: 1;
      }

      50% {
        opacity: 0.35;
      }
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
      width: 30px;
      height: 30px;
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

    .appt-empty img {
      width: 80px;
      height: 80px;
      margin: 0 auto 12px;
      opacity: 0.6;
    }

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
      background: rgba(16, 16, 16, .45);
    }
  </style>
</head>

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<body class="bg-white text-[#333333] font-normal">

  <!-- HEADER -->
  <header class="header">
    <div class="header-left">
      <img src="{{ asset('images/PUP.png') }}" class="header-logo" alt="PUP">
      <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="header-logo" alt="DMS">
      <span class="header-title">PUP TAGUIG DENTAL CLINIC</span>
    </div>
    <div class="header-right">
      <div id="notifDropdown">
        <button class="notif-btn" id="notifBtn">
          <i class="fa-regular fa-bell"></i>
          @if($notifCount > 0)<span class="notif-badge">{{ $notifCount }}</span>@endif
        </button>
        <div id="notifMenu">
          <div style="padding:.85rem 1rem .65rem; font-weight:700; color:#8B0000; font-size:.82rem; border-bottom:1px solid #f5e8e8;">Notifications</div>
          <div style="max-height:260px; overflow-y:auto;">
            @forelse($notifications as $n)
            <a href="{{ $n['url'] ?? '#' }}" style="display:block; padding:.65rem 1rem; font-size:.78rem; color:#333; text-decoration:none; border-bottom:1px solid #fdf5f5;">
              <div style="font-weight:600;">{{ $n['title'] ?? 'Notification' }}</div>
              @if(!empty($n['message']))<div style="color:#aaa; margin-top:2px;">{{ $n['message'] }}</div>@endif
            </a>
            @empty
            <div style="padding:2rem 1rem; text-align:center; color:#bbb; font-size:.78rem;">You're all caught up.</div>
            @endforelse
          </div>
        </div>
      </div>
      <div class="header-user">
        <img src="{{ $patient->profile_image
                ? asset('storage/'.$patient->profile_image)
                : 'https://ui-avatars.com/api/?name='.urlencode($patient->name).'&background=660000&color=FFFFFF&rounded=true&size=36' }}"
          alt="Profile" />
        <div>
          <div class="header-name">{{ ucwords(strtolower($patient->name)) }}</div>
          <div class="header-role">Student</div>
        </div>
      </div>
    </div>
  </header>

  <!-- SIDEBAR -->
  <aside id="sidebar"
    class="fixed left-0 top-[72px] h-[calc(100vh-72px)] bg-white drop-shadow-xl transition-all duration-300 flex flex-col justify-between z-40 expanded"
    style="width:220px;">
    <div class="pt-4">
      <div id="sidebarToggleWrapper" class="flex items-center justify-end px-4 py-2">
        <button onclick="toggleSidebar()" id="sidebarToggleBtn"
          class="w-8 h-8 flex items-center justify-center rounded-full text-[#757575] hover:text-[#8B0000] hover:bg-[#F0F0F0] transition-all duration-300">
          <i id="sidebarIcon" class="fa-solid fa-xmark text-base"></i>
        </button>
      </div>
      <div class="section-label px-4 mb-6">Navigation</div>
      <nav class="space-y-2 px-3 text-gray-600">
        @foreach([
        ['route'=>'homepage', 'icon'=>'fa-house', 'label'=>'Home'],
        ['route'=>'patient.appointment.index', 'icon'=>'fa-calendar', 'label'=>'Appointment'],
        ['route'=>'patient.record', 'icon'=>'fa-folder-open', 'label'=>'Record'],
        ['route'=>'patient.about.us', 'icon'=>'fa-file-circle-check', 'label'=>'About Us'],
        ] as $nav)
        <a href="{{ route($nav['route']) }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8 transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs($nav['route']) ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] {{ request()->routeIs($nav['route']) ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center ml-1"><i class="fa-solid {{ $nav['icon'] }} text-lg"></i></span>
          <span class="sidebar-text ml-2 text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300">{{ $nav['label'] }}</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">{{ $nav['label'] }}</span>
        </a>
        @endforeach
      </nav>
    </div>
    <div class="px-3 pb-5 space-y-4">
      <div class="section-label">Settings</div>
      <div class="w-full px-3">
        <div id="themeToggle" class="theme-toggle-container">
          <button type="button" class="theme-option active" data-theme="light" aria-label="Light mode"><i class="fa-solid fa-sun"></i></button>
          <button type="button" class="theme-option" data-theme="dark" aria-label="Dark mode"><i class="fa-regular fa-moon"></i></button>
          <div class="theme-indicator" aria-hidden="true"></div>
        </div>
      </div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="group sidebar-link w-full relative flex items-center rounded-xl text-sm text-red-600 hover:bg-red-100 transition-all duration-200">
          <div class="flex items-center justify-center w-8 h-8 rounded-lg flex-shrink-0 ml-2"><i class="fa-solid fa-right-from-bracket text-sm"></i></div>
          <span class="sidebar-text ml-2 opacity-0 w-0 font-semibold overflow-hidden transition-all duration-300 delay-150">Log out</span>
          <span class="sidebar-tooltip absolute left-full ml-2 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Log out</span>
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
                <div class="h-9 bg-gray-200 rounded-lg">
            </div>
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
      $pastCount = $pastVisits->count();
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
        $apptDate = \Carbon\Carbon::parse($appt->appointment_date);
        $apptTime = \Carbon\Carbon::parse($appt->appointment_time);
        $now = \Carbon\Carbon::now();
        $diffDays = (int) $now->startOfDay()->diffInDays($apptDate->copy()->startOfDay(), false);
        if ($diffDays === 0) $countdown = 'Today';
        elseif ($diffDays === 1) $countdown = 'Tomorrow';
        else $countdown = 'In ' . $diffDays . ' days';

        $rawStatus = strtolower($appt->status ?? 'scheduled');
        $badgeClass = match($rawStatus) {
        'upcoming' => 'appt-badge-upcoming',
        'confirmed' => 'appt-badge-confirmed',
        default => 'appt-badge-scheduled',
        };
        $showDot = in_array($rawStatus, ['upcoming', 'scheduled']);
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
        $apptDate = \Carbon\Carbon::parse($appt->appointment_date);
        $apptTime = \Carbon\Carbon::parse($appt->appointment_time);
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
        <a href="{{ route('patient.appointment.index') }}" class="btn border-none bg-[#8B0000] hover:bg-[#660000] text-white rounded-xl px-5">
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

    // ── THEME TOGGLE ──
    const html = document.documentElement;
    const themeToggleContainer = document.getElementById("themeToggle");
    const themeIndicator = themeToggleContainer.querySelector(".theme-indicator");
    const themeOptions = themeToggleContainer.querySelectorAll(".theme-option");

    function applyTheme(theme) {
      html.setAttribute("data-theme", theme);
      localStorage.setItem("theme", theme);
      themeOptions.forEach(opt => opt.classList.toggle("active", opt.getAttribute("data-theme") === theme));
      themeIndicator.classList.toggle("dark-mode", theme === "dark");
    }

    applyTheme(localStorage.getItem("theme") || "light");
    themeOptions.forEach(opt => opt.addEventListener("click", () => applyTheme(opt.getAttribute("data-theme"))));

    // ── SIDEBAR ──
    let sidebarOpen = true;

    function applyLayout(sidebarWidth) {
      document.getElementById('sidebar').style.width = sidebarWidth;
      document.getElementById('mainContent').style.marginLeft = sidebarWidth;
    }

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const texts = document.querySelectorAll('.sidebar-text');
      const icon = document.getElementById('sidebarIcon');
      const toggleWrapper = document.getElementById('sidebarToggleWrapper');
      sidebarOpen = !sidebarOpen;
      if (sidebarOpen) {
        applyLayout('220px');
        sidebar.classList.replace('collapsed', 'expanded');
        texts.forEach(t => {
          t.classList.remove('opacity-0', 'w-0');
          t.classList.add('opacity-100');
        });
        toggleWrapper.classList.replace('justify-center', 'justify-end');
        icon.classList.replace('fa-bars', 'fa-xmark');
      } else {
        applyLayout('72px');
        sidebar.classList.replace('expanded', 'collapsed');
        texts.forEach(t => {
          t.classList.add('opacity-0', 'w-0');
          t.classList.remove('opacity-100');
        });
        toggleWrapper.classList.replace('justify-end', 'justify-center');
        icon.classList.replace('fa-xmark', 'fa-bars');
      }
      applyTheme(localStorage.getItem("theme") || "light");
    }

    document.addEventListener('DOMContentLoaded', () => {
      sidebarOpen = true;
      applyLayout('220px');
    });

    // ── NOTIF ──
    document.getElementById("notifBtn").addEventListener("click", e => {
      e.stopPropagation();
      document.getElementById("notifMenu").classList.toggle("open");
    });
    document.addEventListener("click", () => document.getElementById("notifMenu").classList.remove("open"));

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
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const dayLabels = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        const firstDow = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();
        const holidays = getHolidaysForMonth(year, month);
        let cells = '';
        for (let i = 0; i < firstDow; i++) cells += `<div></div>`;
        for (let d = 1; d <= totalDays; d++) {
          const dateStr = `${year}-${pad(month+1)}-${pad(d)}`;
          const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
          const weekend = isWeekend(year, month, d);
          const holiday = holidays[dateStr] || null;
          const myAppt = myAppointments[dateStr] || null;
          const count = apptCounts[dateStr] || 0;
          const isFull = count >= MAX_PER_DAY;
          const isUnavail = unavailableDates.includes(dateStr) || weekend;
          let bgClass = '',
            textClass = 'text-[#333333]',
            ringClass = '',
            dotHtml = '',
            tooltipTxt = '';
          if (isToday) {
            bgClass = 'bg-[#8B0000]';
            textClass = 'text-white font-extrabold';
            ringClass = 'ring-2 ring-[#8B0000]/30 ring-offset-1';
          } else if (holiday) {
            bgClass = 'bg-blue-50 hover:bg-blue-100';
            textClass = 'text-blue-700 font-semibold';
          } else if (isUnavail) {
            textClass = 'text-gray-300';
          } else {
            bgClass = 'hover:bg-[#FFF0F0]';
          }
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

              <div class="flex flex-wrap items-center gap-x-5 gap-y-2 mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center gap-2 text-xs text-gray-500">
                  <span class="w-2.5 h-2.5 rounded-full bg-[#008440] inline-block flex-shrink-0 ring-2 ring-[#008440]/30 ring-offset-1"></span>
                  My Appointment
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                  <span class="w-2.5 h-2.5 rounded-full bg-blue-400 inline-block flex-shrink-0 ring-2 ring-blue-400/30 ring-offset-1"></span>
                  Holiday
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                  <span class="w-2.5 h-2.5 rounded-full bg-red-500 inline-block flex-shrink-0 ring-2 ring-red-500/30 ring-offset-1"></span>
                  Fully Booked
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                  <span class="w-2.5 h-2.5 rounded-full bg-[#8B0000] inline-block flex-shrink-0 ring-2 ring-[#8B0000]/30 ring-offset-1"></span>
                  Today
                </div>
              </div>
          </div>`;
      }

      window.changeMonth = function(dir) {
        currentMonth += dir;
        if (currentMonth > 11) {
          currentMonth = 0;
          currentYear++;
        }
        if (currentMonth < 0) {
          currentMonth = 11;
          currentYear--;
        }
        renderCalendar(currentYear, currentMonth);
      };

      renderCalendar(currentYear, currentMonth);
    }

    document.addEventListener('DOMContentLoaded', () => loadCalendar());
  </script>

</body>

</html>