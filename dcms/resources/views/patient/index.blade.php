<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <script>
    tailwind.config = {
      daisyui: {
        themes: false
      }
    }
  </script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      overflow-x: hidden;
    }

    /* ── DESKTOP SIDEBAR LAYOUT ── */
    #mainContent {
      margin-left: 220px;
      transition: margin-left .3s ease;
    }

    #sidebar {
      width: 220px;
      transition: width .3s ease;
    }

    #sidebar.collapsed {
      width: 72px !important;
    }

    /* ── MOBILE PROFILE ACCORDION ── */
    #mobileProfileAccordion {
      display: none;
    }

    /* ── MOBILE BOTTOM NAV ── */
    #mobileBottomNav {
      display: none;
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      height: 72px;
      background: white;
      border-top: 1px solid #f0e0e0;
      z-index: 200;
      align-items: center;
      justify-content: space-around;
      box-shadow: 0 -4px 20px rgba(139, 0, 0, .10);
    }

    .mob-nav-item {
      flex: 1;
      height: 72px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 2px;
      font-size: 10px;
      font-weight: 600;
      color: #9CA3AF;
      text-decoration: none;
      transition: color .2s;
      position: relative;
    }

    .mob-nav-item.active {
      color: #8B0000;
    }

    .mob-nav-item i {
      font-size: 22px;
    }

    #mobFabWrapper {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      position: static;
    }

    #mobFab {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      background: linear-gradient(135deg, #8B0000, #660000);
      color: white;
      border: none;
      font-size: 22px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 16px rgba(139, 0, 0, .45);
      cursor: pointer;
      transition: transform .25s cubic-bezier(.34, 1.56, .64, 1), box-shadow .2s;
      z-index: 10;
      position: relative;
      top: -10px;
    }

    #mobFab:active {
      transform: scale(.92) translateY(-2px);
    }

    #mobFab.open {
      transform: rotate(45deg) translateY(-10px);
    }

    #mobFabMenu {
      position: fixed;
      bottom: 90px;
      left: 50%;
      transform: translateX(-50%) scaleY(0);
      transform-origin: bottom center;
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(139, 0, 0, .18);
      border: 1px solid #f5e8e8;
      min-width: 200px;
      overflow: hidden;
      transition: transform .25s cubic-bezier(.34, 1.56, .64, 1), opacity .2s;
      opacity: 0;
      pointer-events: none;
      z-index: 300;
    }

    #mobFabMenu.open {
      transform: translateX(-50%) scaleY(1);
      opacity: 1;
      pointer-events: auto;
    }

    .fab-menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 18px;
      font-size: 14px;
      font-weight: 600;
      color: #333;
      text-decoration: none;
      transition: background .15s;
      border-bottom: 1px solid #fdf5f5;
    }

    .fab-menu-item:last-child {
      border-bottom: none;
    }

    .fab-menu-item:hover {
      background: #FFF0F0;
      color: #8B0000;
    }

    .fab-menu-item i {
      width: 32px;
      height: 32px;
      background: #FFF0F0;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      color: #8B0000;
      flex-shrink: 0;
    }

    /* ── ANIMATIONS ── */
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

    @keyframes softPulse {

      0%,
      100% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.05);
      }
    }

    .pulse-icon {
      animation: softPulse 2s ease-in-out infinite;
    }

    @keyframes shimmer {
      0% {
        background-position: -400px 0;
      }

      100% {
        background-position: 400px 0;
      }
    }

    .skeleton {
      background: linear-gradient(90deg, #e5e7eb 25%, #f3f4f6 37%, #e5e7eb 63%);
      background-size: 800px 100%;
      animation: shimmer 1.4s infinite linear;
      border-radius: 0.75rem;
    }

    @keyframes fadeUp {
      0% {
        opacity: 0;
        transform: translateY(10px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-up {
      animation: fadeUp 0.6s ease-out forwards;
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0) rotate(0deg);
      }

      50% {
        transform: translateY(-14px) rotate(2deg);
      }
    }

    .float-slow {
      animation: float 4.5s ease-in-out infinite;
      will-change: transform;
    }

    @keyframes shimmerBtn {
      0% {
        background-position: -200% 0;
      }

      100% {
        background-position: 200% 0;
      }
    }

    .shimmer-btn {
      background: linear-gradient(110deg, #660000 25%, rgba(255, 80, 80, .87) 37%, #660000 63%);
      background-size: 200% 100%;
      animation: shimmerBtn 10s linear infinite;
    }

    @keyframes wave {
      0% {
        transform: rotate(0);
      }

      20% {
        transform: rotate(14deg);
      }

      40% {
        transform: rotate(-8deg);
      }

      60% {
        transform: rotate(14deg);
      }

      80% {
        transform: rotate(-4deg);
      }

      100% {
        transform: rotate(0);
      }
    }

    .wave-hand {
      transform-origin: 70% 70%;
      animation: wave 2.5s ease-in-out infinite;
    }

    @keyframes spinSlow {
      from {
        transform: rotate(0);
      }

      to {
        transform: rotate(360deg);
      }
    }

    @keyframes floatMoon {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-3px);
      }
    }

    @keyframes driftCloud {

      0%,
      100% {
        transform: translateX(0);
      }

      50% {
        transform: translateX(3px);
      }
    }

    .greet-spin {
      animation: spinSlow 8s linear infinite;
      display: inline-block;
    }

    .greet-float {
      animation: floatMoon 3s ease-in-out infinite;
      display: inline-block;
    }

    .greet-drift {
      animation: driftCloud 3s ease-in-out infinite;
      display: inline-block;
    }

    /* ── HEADER ── */
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
      font-size: 1rem;
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

    /* ── SIDEBAR ── */
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

    .sidebar-link.bg-\[\#8B0000\] {
      box-shadow: 0 0 12px rgba(139, 0, 0, .45);
    }

    /* ── THEME TOGGLE ── */
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
      transform: translateX(calc(100%));
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

    /* ── DARK THEME ── */
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

    [data-theme="dark"] #mobileBottomNav {
      background: #0a0a0a;
      border-top-color: #1a1a1a;
    }

    [data-theme="dark"] #mobFabMenu {
      background: #111;
      border-color: #222;
    }

    [data-theme="dark"] .fab-menu-item {
      color: #E5E7EB;
      border-bottom-color: #1a1a1a;
    }

    [data-theme="dark"] .fab-menu-item:hover {
      background: #1a1a1a;
    }

    [data-theme="dark"] .mob-nav-item {
      color: #4B5563;
    }

    [data-theme="dark"] .mob-nav-item.active {
      color: #ff6b6b;
    }

    /* ── MODAL ── */
    dialog#activeAppointmentModal::backdrop {
      background: rgba(16, 16, 16, .45);
    }

    dialog#activeAppointmentModal .swal-card {
      opacity: 0;
      transform: translateY(10px) scale(.97);
      transition: opacity .18s ease, transform .18s ease;
    }

    dialog#activeAppointmentModal[open] .swal-card {
      opacity: 1;
      transform: translateY(0) scale(1);
    }

    /* ── TOAST ── */
    #toastContainer {
      position: fixed !important;
      top: 20px !important;
      right: 20px !important;
      bottom: unset !important;
      left: unset !important;
      z-index: 99999;
      display: flex;
      flex-direction: column;
      gap: 10px;
      pointer-events: none;
      width: auto !important;
      padding: 0 !important;
    }

    #toastContainer .toast {
      min-width: 300px;
      max-width: 360px;
      background: white !important;
      border-radius: 14px !important;
      box-shadow: 0 10px 40px rgba(0, 0, 0, .18) !important;
      padding: 14px 18px 14px 16px !important;
      display: flex !important;
      align-items: center !important;
      gap: 12px;
      opacity: 0;
      transform: translateX(340px);
      transition: all .35s cubic-bezier(.68, -.55, .265, 1.55);
      position: relative;
      overflow: hidden;
      pointer-events: all;
      flex-direction: row !important;
    }

    #toastContainer .toast::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
      background: none;
    }

    #toastContainer .toast.error::before {
      background: #8B0000 !important;
    }

    #toastContainer .toast.success::before {
      background: #15803d !important;
    }

    #toastContainer .toast.show {
      opacity: 1 !important;
      transform: translateX(0) !important;
    }

    #toastContainer .toast.hide {
      opacity: 0 !important;
      transform: translateX(340px) !important;
    }

    #toastContainer .toast-icon-wrap {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    #toastContainer .toast.error .toast-icon-wrap {
      background: rgba(139, 0, 0, .08);
    }

    #toastContainer .toast.success .toast-icon-wrap {
      background: rgba(21, 128, 61, .08);
    }

    #toastContainer .toast-icon {
      font-size: 17px;
    }

    #toastContainer .toast.error .toast-icon {
      color: #8B0000 !important;
    }

    #toastContainer .toast.success .toast-icon {
      color: #15803d !important;
    }

    #toastContainer .toast-body {
      flex: 1;
      min-width: 0;
    }

    #toastContainer .toast-title {
      font-size: 13px;
      font-weight: 700;
      color: #1A0A0A !important;
    }

    #toastContainer .toast-msg {
      font-size: 12px;
      color: #888 !important;
      margin-top: 2px;
      line-height: 1.4;
    }

    #toastContainer .toast-close {
      background: none !important;
      border: none;
      cursor: pointer;
      color: #CCC;
      font-size: 13px;
      flex-shrink: 0;
      padding: 2px 4px;
      transition: color .2s;
    }

    #toastContainer .toast-close:hover {
      color: #888;
    }

    @media(max-width:640px) {
      #toastContainer {
        left: 12px !important;
        right: 12px !important;
        top: 72px !important;
        bottom: unset !important;
        width: auto !important;
      }

      #toastContainer .toast {
        min-width: unset !important;
        width: 100% !important;
        transform: translateY(-120px) !important;
        border-radius: 12px !important;
      }

      #toastContainer .toast.show {
        transform: translateY(0) !important;
        opacity: 1 !important;
      }

      #toastContainer .toast.hide {
        transform: translateY(-120px) !important;
        opacity: 0 !important;
      }
    }

    /* --- */
    /* ── RESPONSIVE ── */
    @media (max-width:767px) {
      #sidebar {
        display: none !important;
      }

      #mainContent {
        margin-left: 0 !important;
        padding-bottom: 90px;
      }

      #mobileBottomNav {
        display: flex;
      }

      footer {
        margin-bottom: 72px;
      }

      #desktopHeaderUser {
        display: none !important;
      }

      #mobileProfileAccordion {
        display: block;
        position: fixed;
        top: 62px;
        left: 0;
        right: 0;
        z-index: 45;
        background: white;
        border-bottom: 1px solid #f0e0e0;
        box-shadow: 0 4px 20px rgba(139, 0, 0, .08);
        max-height: 0;
        overflow: hidden;
        transition: max-height .35s cubic-bezier(.4, 0, .2, 1), opacity .25s ease;
        opacity: 0;
      }

      #mobileProfileAccordion.open {
        max-height: 200px;
        opacity: 1;
      }

      #mobileProfileToggle {
        display: flex !important;
      }
    }

    @media (min-width:768px) {
      #mobileProfileToggle {
        display: none !important;
      }

      #darkModeFab {
        display: none !important;
      }

      #mobileBottomNav {
        display: none !important;
      }
    }

    @media (max-width:480px) {
      .header-title {
        display: none;
      }

      .header-name,
      .header-role {
        display: none;
      }

      .header {
        padding: 0 1rem;
      }
    }

    @media (max-width:640px) {
      .hero-tooth {
        width: 70px !important;
        opacity: .12;
      }

      .hero-text h1 {
        font-size: 1.15rem !important;
        white-space: nowrap;
      }

      .hero-text h2 {
        font-size: .75rem !important;
        margin-top: 4px !important;
        margin-bottom: 12px !important;
      }
    }
  </style>
</head>

<body class="bg-[#F4F4F4] text-[#333333] font-normal">

  @php
  use Carbon\Carbon;
  $notifications = collect($notifications ?? []);
  $notifCount = $notifications->count();
  $homeRecords = ($records ?? collect())
  ->filter(function ($r) {
  return strtolower($r->status ?? '') === 'completed';
  })
  ->map(function ($r) {
  return [
  'service' => $r->service_type,
  'date' => $r->appointment_date ? Carbon::parse($r->appointment_date)->format('F d, Y') : '',
  'time' => $r->appointment_time ?? '',
  'status' => 'completed',
  'duration' => $r->duration ?? '',
  'remarks' => $r->remarks ?? '',
  'oral' => $r->oral_examination ?? '',
  'diagnosis' => $r->diagnosis ?? '',
  'prescription' => $r->prescription ?? '',
  ];
  })
  ->values();

  $calendarAppointments = [];
  foreach ($appointments ?? collect() as $appt) {
  $calendarAppointments[Carbon::parse($appt->appointment_date)->format('Y-m-d')] =
  $appt->service_type . ' • ' . $appt->appointment_time;
  }
  @endphp

  <script>
    const calendarData =
      {{ Illuminate\Support\Js:: from([
        'appointments' => $calendarAppointments,
        'counts' => $appointmentCountsPerDay ?? [],
        'unavailableDates' => $unavailableDates ?? [],
        'holidays' => $philippineHolidays ?? [],
      ]) }};
    const calendarAppointments = calendarData.appointments;
    const calendarCounts = calendarData.counts;
    const calendarUnavailableDates = calendarData.unavailableDates;
    const calendarHolidays = calendarData.holidays;
  </script>

  <div id="toastContainer" role="region" aria-live="polite" style="position:fixed!important;top:20px!important;right:20px!important;
         bottom:unset!important;left:unset!important;z-index:99999;
         display:flex;flex-direction:column;gap:10px;pointer-events:none;">
  </div>

  <!-- ══════ HEADER ══════ -->
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
          @if ($notifCount > 0)
          <span class="notif-badge">{{ $notifCount }}</span>
          @endif
        </button>
        <div id="notifMenu">
          <div
            style="padding:.85rem 1rem .65rem;font-weight:700;color:#8B0000;font-size:.82rem;border-bottom:1px solid #f5e8e8;">
            Notifications</div>
          <div style="max-height:260px;overflow-y:auto;">
            @forelse($notifications as $n)
            <a href="{{ $n['url'] ?? '#' }}"
              style="display:block;padding:.65rem 1rem;font-size:.78rem;color:#333;text-decoration:none;border-bottom:1px solid #fdf5f5;">
              <div style="font-weight:600;">{{ $n['title'] ?? 'Notification' }}</div>
              @if (!empty($n['message']))
              <div style="color:#aaa;margin-top:2px;">{{ $n['message'] }}</div>
              @endif
            </a>
            @empty
            <div style="padding:2rem 1rem;text-align:center;color:#bbb;font-size:.78rem;">You're all
              caught up.</div>
            @endforelse
          </div>
        </div>
      </div>
      <button id="mobileProfileToggle" onclick="toggleMobileProfile()"
        style="display:none;align-items:center;gap:.6rem;background:none;border:none;cursor:pointer;padding:0;">
        <img class="header-avatar"
          src="{{ $patient->profile_image ? asset('storage/' . $patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patient->name) . '&background=660000&color=FFFFFF&rounded=true&size=36' }}"
          alt="Profile">
        <i id="mobileProfileChevron"
          class="fa-solid fa-chevron-down text-white text-xs transition-transform duration-300"></i>
      </button>
      <div class="header-user" id="desktopHeaderUser">
        <img class="header-avatar"
          src="{{ $patient->profile_image ? asset('storage/' . $patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patient->name) . '&background=660000&color=FFFFFF&rounded=true&size=36' }}"
          alt="Profile">
        <div>
          <div class="header-name">{{ ucwords(strtolower($patient->name)) }}</div>
          <div class="header-role">Student</div>
        </div>
      </div>
    </div>
  </header>

  <!-- ══════ MOBILE PROFILE ACCORDION ══════ -->
  <div id="mobileProfileAccordion">
    <div class="flex items-center gap-4 px-5 py-4 border-b border-gray-100">
      <img class="w-12 h-12 rounded-full border-2 border-[#8B0000]/20 object-cover flex-shrink-0"
        src="{{ $patient->profile_image ? asset('storage/' . $patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patient->name) . '&background=660000&color=FFFFFF&rounded=true&size=96' }}"
        alt="Profile">
      <div>
        <p class="font-bold text-[#333333] text-base leading-tight">{{ ucwords(strtolower($patient->name)) }}
        </p>
        <p class="text-xs text-[#757575] italic">Student</p>
      </div>
    </div>
    <div class="px-5 py-3">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
          class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-red-600 bg-red-50 hover:bg-red-100 font-semibold text-sm transition-colors duration-200">
          <i class="fa-solid fa-right-from-bracket"></i> Log out
        </button>
      </form>
    </div>
  </div>

  <!-- ══════════════ DESKTOP SIDEBAR ══════════════ -->
  <aside id="sidebar"
    class="fixed left-0 top-[62px] h-[calc(100vh-62px)] bg-white drop-shadow-xl transition-all duration-300 flex flex-col justify-between z-40 expanded"
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
        ['route'=>'patient.record', 'icon'=>'fa-folder-open', 'label'=>'Dental Record'],
        ['route'=>'patient.about.us', 'icon'=>'fa-file-circle-check','label'=>'About Us'],
        ] as $nav)
        <a href="{{ route($nav['route']) }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8 transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4] {{ request()->routeIs($nav['route']) ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span
            class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] {{ request()->routeIs($nav['route']) ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center ml-1"><i
              class="fa-solid {{ $nav['icon'] }} text-lg"></i></span>
          <span
            class="sidebar-text ml-2 text-sm font-semibold whitespace-nowrap overflow-hidden transition-all duration-300">{{
            $nav['label'] }}</span>
          <span
            class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">{{
            $nav['label'] }}</span>
        </a>
        @endforeach
      </nav>
    </div>
    <div class="px-3 pb-5 space-y-4">
      <div class="section-label">Settings</div>
      <div class="w-full px-3">
        <div id="themeToggle" class="theme-toggle-container">
          <button type="button" class="theme-option active" data-theme="light" aria-label="Light mode"><i
              class="fa-solid fa-sun"></i></button>
          <button type="button" class="theme-option" data-theme="dark" aria-label="Dark mode"><i
              class="fa-regular fa-moon"></i></button>
          <div class="theme-indicator" aria-hidden="true"></div>
        </div>
      </div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button
          class="group sidebar-link w-full relative flex items-center rounded-xl text-sm text-red-600 hover:bg-red-100 transition-all duration-200">
          <div class="flex items-center justify-center w-8 h-8 rounded-lg flex-shrink-0 ml-2"><i
              class="fa-solid fa-right-from-bracket text-sm"></i></div>
          <span
            class="sidebar-text ml-2 opacity-0 w-0 font-semibold overflow-hidden transition-all duration-300 delay-150">Log
            out</span>
          <span
            class="sidebar-tooltip absolute left-full ml-2 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Log
            out</span>
        </button>
      </form>
    </div>
  </aside>

  <!-- ══════ MOBILE BOTTOM NAV ══════ -->
  <nav id="mobileBottomNav">
    <a href="{{ route('homepage') }}" class="mob-nav-item {{ request()->routeIs('homepage') ? 'active' : '' }}">
      <i class="fa-solid fa-house"></i><span>Home</span>
    </a>
    <a href="{{ route('patient.appointment.index') }}"
      class="mob-nav-item {{ request()->routeIs('patient.appointment.index') ? 'active' : '' }}">
      <i class="fa-solid fa-calendar"></i><span>Appointments</span>
    </a>
    <div id="mobFabWrapper">
      <div id="mobFabMenu">
        <a href="{{ route('patient.book.appointment') }}" class="fab-menu-item">
          <i class="fa-solid fa-calendar-plus"></i> Book Appointment
        </a>
        <a onclick="document.getElementById('dentalHealthRecordModal')?.showModal()"
          class="fab-menu-item cursor-pointer">
          <i class="fa-solid fa-file-medical"></i> Request Health Record
        </a>
        <a onclick="document.getElementById('dentalClearanceModal')?.showModal()" class="fab-menu-item cursor-pointer">
          <i class="fa-solid fa-file-circle-check"></i> Request Clearance
        </a>
      </div>
      <button id="mobFab" aria-label="Quick actions"><i class="fa-solid fa-plus"></i></button>
    </div>
    <a href="{{ route('patient.record') }}"
      class="mob-nav-item {{ request()->routeIs('patient.record') ? 'active' : '' }}">
      <i class="fa-solid fa-folder-open"></i><span>Record</span>
    </a>
    <a href="{{ route('patient.about.us') }}"
      class="mob-nav-item {{ request()->routeIs('patient.about.us') ? 'active' : '' }}">
      <i class="fa-solid fa-circle-info"></i><span>About</span>
    </a>
  </nav>

  <!-- DARK MODE FAB (mobile only) -->
  <button id="darkModeFab"
    onclick="applyTheme(document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark')" style="position:fixed;bottom:88px;right:16px;width:44px;height:44px;border-radius:50%;
           background:linear-gradient(135deg,#8B0000,#660000);color:white;border:none;font-size:18px;
           display:flex;align-items:center;justify-content:center;
           box-shadow:0 4px 16px rgba(139,0,0,.45);cursor:pointer;z-index:199;
           transition:transform .2s cubic-bezier(.34,1.56,.64,1);" aria-label="Toggle dark mode">
    <i id="darkModeFabIcon" class="fa-solid fa-moon"></i>
  </button>

  <!-- ══════ MAIN CONTENT ══════ -->
  <main id="mainContent" class="pt-[100px] px-4 sm:px-6 py-6 fade-up min-h-screen">
    <div class="mx-auto">

      {{-- Impersonation banner --}}
      @if(session('impersonated_role') === 'patient' && session('impersonator_role') === 'super_admin')
      <div
        style="background:#FEF3C7;border:1px solid #FCD34D;color:#92400E;padding:14px 18px;margin-bottom:16px;border-radius:12px;display:flex;justify-content:space-between;align-items:center;gap:12px;">
        <div>
          <strong>You are viewing as Patient</strong><br>
          <span style="font-size:13px;">Super Admin impersonation mode is active.</span>
        </div>
        <form method="POST" action="{{ route('admin.stop_impersonation') }}">
          @csrf
          <button type="submit"
            style="background:#8B0000;color:#fff;border:none;padding:10px 16px;border-radius:8px;font-weight:700;cursor:pointer;">Return
            to Admin</button>
        </form>
      </div>
      @endif

      <!-- HERO CARD -->
      <div
        class="bg-gradient-to-r from-[#8B0000] to-[#660000] text-[#F4F4F4] rounded-2xl p-4 sm:p-10 flex justify-between items-center mb-6 fade-up relative overflow-hidden">
        <div class="hero-text relative z-10 max-w-[60%] sm:max-w-[55%]">
          <div class="flex items-center gap-1.5 mb-1">
            <i class="fa-solid fa-sun text-yellow-400 text-sm greet-spin" id="greetingIcon"></i>
            <p class="text-sm sm:text-base text-[#F4F4F4]" id="greetingText">Good morning</p>
          </div>
          <h1 class="text-3xl sm:text-4xl font-extrabold mt-1 mb-2 text-[#F4F4F4] fade-up">
            <span class="bg-gradient-to-r from-[#F4F4F4] to-[#FFD700] bg-clip-text text-transparent">
              Welcome, {{ ucwords(strtolower($patient->name)) }}!
            </span>
            <i class="fa-solid fa-hand text-[#FFD700] wave-hand"></i>
          </h1>
          <h2 class="text-xs sm:text-base font-normal mt-2 sm:mt-4 mb-4 sm:mb-6 text-[#F4F4F4] fade-up">
            Healthy teeth start with one appointment.
          </h2>
          <a href="{{ route('patient.book.appointment') }}" class="flex items-center gap-2 whitespace-nowrap">
            <button
              class="btn btn-soft shimmer-btn px-3 sm:px-6 py-1.5 sm:py-3 rounded-xl sm:rounded-2xl border-none text-xs sm:text-base font-semibold text-[#F4F4F4] transition-transform duration-500 hover:-translate-y-2 hover:shadow-[0_0_10px_rgba(255,255,255,0.4)]">
              <i class="fa-solid fa-calendar-plus"></i> Book Appointment
            </button>
          </a>
        </div>
        <div class="absolute right-4 sm:right-7 top-1/2 -translate-y-1/2 pointer-events-none">
          <img src="{{ asset('images/home-tooth.png') }}" alt="Tooth"
            class="hero-tooth float-slow w-[120px] sm:w-[250px] max-w-none drop-shadow-[0_14px_26px_rgba(255,255,255,0.25)] opacity-30 sm:opacity-100" />
        </div>
      </div>

      <!-- ════ UPCOMING APPOINTMENT — skeleton shown by default, replaced by JS ════ -->
      <div class="mb-6 fade-up">
        {{-- This wrapper is what JS targets. It starts as a skeleton. --}}
        <div id="upcomingAppointmentWrapper">
          {{-- Initial skeleton — visible immediately on page load --}}
          <div class="rounded-2xl overflow-hidden border border-[#EDE8E4] shadow-sm animate-pulse">
            <div class="flex items-center justify-between gap-3 px-5 py-3"
              style="background:linear-gradient(135deg,#5A0000,#8B0000);">
              <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-white/15 flex-shrink-0"></div>
                <div class="h-4 w-40 bg-white/25 rounded-lg"></div>
              </div>
              <div class="h-6 w-20 bg-white/20 rounded-full"></div>
            </div>
            <div class="bg-white px-5 py-4">
              <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div>
                  <div class="h-2 w-16 bg-gray-200 rounded mb-2"></div>
                  <div class="h-4 w-full bg-gray-200 rounded"></div>
                </div>
                <div>
                  <div class="h-2 w-24 bg-gray-200 rounded mb-2"></div>
                  <div class="h-4 w-full bg-gray-200 rounded"></div>
                </div>
                <div>
                  <div class="h-2 w-16 bg-gray-200 rounded mb-2"></div>
                  <div class="h-4 w-full bg-gray-200 rounded"></div>
                </div>
              </div>
              <div class="mt-3 pt-3 border-t border-gray-100 flex justify-end">
                <div class="h-3 w-20 bg-gray-200 rounded"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- CALENDAR SECTION -->
      <section class="max-w-7xl mx-auto mb-10">
        <div class="flex flex-col md:flex-row gap-6">

          <!-- Profile + Request Docs column -->
          <div class="md:w-[600px] flex-shrink-0 flex flex-col gap-5">

            {{-- Profile skeleton shown by default --}}
            <div id="profileSkeletonContainer" class="rounded-2xl overflow-hidden shadow-lg">
              <div class="bg-white rounded-2xl overflow-hidden shadow-sm animate-pulse">
                <div class="bg-gray-200 h-24 w-full"></div>
                <div class="p-4 space-y-3">
                  <div class="flex gap-4">
                    <div class="h-3 w-24 skeleton"></div>
                    <div class="h-3 w-40 skeleton"></div>
                  </div>
                  <div class="flex gap-4">
                    <div class="h-3 w-24 skeleton"></div>
                    <div class="h-3 w-40 skeleton"></div>
                  </div>
                  <div class="flex gap-4">
                    <div class="h-3 w-24 skeleton"></div>
                    <div class="h-3 w-40 skeleton"></div>
                  </div>
                  <div class="flex gap-4">
                    <div class="h-3 w-24 skeleton"></div>
                    <div class="h-3 w-40 skeleton"></div>
                  </div>
                </div>
              </div>
            </div>

            {{-- Request docs skeleton shown by default --}}
            <div class="bg-white rounded-2xl shadow-lg p-5">
              <div id="requestDocsContainer">
                <div class="flex items-center gap-3 border rounded-xl p-3 animate-pulse mb-3">
                  <div class="w-10 h-10 skeleton rounded-lg flex-shrink-0"></div>
                  <div class="flex-1 space-y-2">
                    <div class="h-3 w-36 skeleton"></div>
                    <div class="h-2 w-48 skeleton"></div>
                  </div>
                </div>
                <div class="flex items-center gap-3 border rounded-xl p-3 animate-pulse">
                  <div class="w-10 h-10 skeleton rounded-lg flex-shrink-0"></div>
                  <div class="flex-1 space-y-2">
                    <div class="h-3 w-36 skeleton"></div>
                    <div class="h-2 w-48 skeleton"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Calendar column -->
          <div class="flex-1 flex flex-col gap-2">
            {{-- Calendar skeleton shown by default --}}
            <div id="calendarSkeletonContainer" class="bg-white border shadow-sm rounded-2xl p-4 sm:p-6 w-full"
              style="min-height:500px;">
              <div class="animate-pulse space-y-4">
                <div class="h-6 w-32 bg-gray-200 rounded mx-auto"></div>
                <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:8px;">
                  @for ($i = 0; $i < 35; $i++) <div class="h-9 bg-gray-200 rounded-lg">
                </div>
                @endfor
              </div>
            </div>
          </div>
        </div>

    </div>
    </section>

    <!-- ════ RECORDS SECTION ════ -->
    <div class="mb-8 fade-up">

      {{-- Hero banner (always visible) --}}
      <div class="relative overflow-hidden rounded-[20px] px-7 pt-7 pb-14 -mb-8"
        style="background:linear-gradient(135deg,#5A0000 0%,#8B0000 60%,#b5282a 100%);">
        <div class="absolute inset-0"
          style="background:url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.04\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'20\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
        </div>
        <p class="relative z-10 text-[10px] font-bold tracking-[.15em] uppercase text-white/55 mb-1.5">
          Patient Portal</p>
        <h2 class="relative z-10 text-[28px] font-extrabold text-white leading-tight">Dental Records</h2>
        <p class="relative z-10 text-[13px] text-white/65 mt-1.5">A complete history of your dental visits
          and treatments.</p>
        <div class="relative z-10 flex flex-wrap gap-3 mt-4">
          <div id="recordsStatVisits"
            class="flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-semibold text-white/90"
            style="background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.18);">
            <i class="fa-solid fa-list text-[10px] opacity-70"></i>
            <span id="recordsVisitCount">0 visits</span>
          </div>
          <div id="recordsStatLatest"
            class="hidden items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-semibold text-white/90"
            style="background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.18);">
            <i class="fa-regular fa-calendar text-[10px] opacity-70"></i>
            <span id="recordsLatestDate"></span>
          </div>
        </div>
      </div>

      {{-- Records body card --}}
      <div class="relative z-10 bg-white rounded-[20px] border border-[#EDE8E4] p-5"
        style="box-shadow:0 4px 32px rgba(0,0,0,.06);">

        {{-- Visit History header (hidden until records load) --}}
        <div id="viewAllContainer" class="hidden mb-5 pt-2">
          <div class="flex items-center gap-3">
            <span class="text-[9px] font-extrabold tracking-[.12em] uppercase text-[#9E9690] whitespace-nowrap">Visit
              History</span>
            <div class="flex-1 h-px bg-[#EDE8E4]"></div>
            <a href="{{ route('patient.record') }}"
              class="inline-flex items-center gap-1 text-[11px] font-bold text-[#8B0000] hover:text-[#5A0000] whitespace-nowrap transition-colors">
              View Full Record <i class="fa-solid fa-arrow-right text-[9px]"></i>
            </a>
          </div>
        </div>

        {{-- Records skeleton shown by default --}}
        <div id="recordsInnerContainer">
          <div class="space-y-3 animate-pulse">
            <div class="flex items-center gap-4 border rounded-xl p-4">
              <div class="w-3 h-3 rounded-full bg-gray-200 flex-shrink-0"></div>
              <div class="flex-1 space-y-2">
                <div class="h-4 w-40 skeleton"></div>
                <div class="h-3 w-56 skeleton"></div>
              </div>
              <div class="h-8 w-20 skeleton rounded-lg"></div>
            </div>
            <div class="flex items-center gap-4 border rounded-xl p-4">
              <div class="w-3 h-3 rounded-full bg-gray-200 flex-shrink-0"></div>
              <div class="flex-1 space-y-2">
                <div class="h-4 w-36 skeleton"></div>
                <div class="h-3 w-48 skeleton"></div>
              </div>
              <div class="h-8 w-20 skeleton rounded-lg"></div>
            </div>
            <div class="flex items-center gap-4 border rounded-xl p-4">
              <div class="w-3 h-3 rounded-full bg-gray-200 flex-shrink-0"></div>
              <div class="flex-1 space-y-2">
                <div class="h-4 w-44 skeleton"></div>
                <div class="h-3 w-52 skeleton"></div>
              </div>
              <div class="h-8 w-20 skeleton rounded-lg"></div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- RECORD MODAL -->
    <dialog id="record_modal" class="modal">
      <div class="modal-box p-0 w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-xl bg-[#F3F3F3]">
        <div class="bg-gradient-to-r from-[#5A0000] to-[#8B0000] px-6 sm:px-8 py-5 sm:py-6 text-white">
          <h3 id="m_service" class="text-2xl sm:text-3xl font-extrabold leading-tight">—</h3>
          <div class="mt-2 flex items-center gap-3 text-white/95">
            <i class="fa-regular fa-calendar"></i>
            <p class="text-sm sm:text-base font-medium">
              <span id="m_date">—</span><span class="mx-2">·</span><span id="m_time">—</span>
            </p>
          </div>
        </div>
        <div class="px-6 sm:px-8 py-6 sm:py-8 space-y-6 sm:space-y-8">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
            <div class="bg-white border border-gray-200 rounded-xl px-4 py-3 min-h-[90px] flex flex-col justify-center">
              <div class="flex items-center gap-2 text-xs font-bold tracking-widest text-black-600">
                <span class="flex items-center justify-center w-3 h-3 rounded-full bg-gray-800"><i
                    class="fa-solid fa-check text-white text-[8px]"></i></span> STATUS
              </div>
              <div class="mt-3 ml-4"><span id="m_status"
                  class="inline-flex items-center justify-center w-32 px-4 py-1 text-sm leading-none rounded-full font-semibold bg-gray-200 text-gray-800">—</span>
              </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl px-4 py-3 min-h-[90px] flex flex-col justify-center">
              <div class="flex items-center gap-2 text-xs font-bold tracking-widest text-black-600">
                <span class="flex items-center justify-center w-3 h-3 rounded-full bg-gray-800"><i
                    class="fa-solid fa-check text-white text-[8px]"></i></span> DURATION
              </div>
              <div class="mt-3 ml-4"><span id="m_duration"
                  class="inline-flex items-center justify-center w-32 px-4 py-1 text-sm leading-none rounded-full font-semibold bg-gray-200 text-gray-800">—</span>
              </div>
            </div>
          </div>
          @foreach ([['TREATMENT', 'm_remarks'], ['ORAL EXAMINATION', 'm_oral'], ['DIAGNOSIS', 'm_diagnosis'],
          ['PRESCRIPTION', 'm_prescription']] as [$label, $mid])
          <div>
            <div class="flex items-center gap-4 mb-3">
              <span class="text-xs font-extrabold tracking-widest text-[#8B0000]">{{ $label }}</span>
              <div class="h-px flex-1 bg-gray-300"></div>
            </div>
            <div class="bg-white rounded-md overflow-hidden">
              <div class="grid grid-cols-[6px_1fr]">
                <div class="bg-gray-300"></div>
                <div class="p-4 sm:p-6 text-gray-700 text-sm leading-relaxed"><span id="{{ $mid }}">—</span></div>
              </div>
            </div>
          </div>
          @endforeach
          <div class="flex justify-end pt-2">
            <form method="dialog">
              <button
                class="px-8 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300 transition">Close</button>
            </form>
          </div>
        </div>
      </div>
      <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    <!-- REQUEST CLEARANCE MODAL -->
    <dialog id="dentalClearanceModal" class="modal">
      <form id="clearanceRequestForm" method="POST" action="{{ route('patient.document.requests.store') }}"
        class="modal-box rounded-2xl bg-[#F4F4F4] relative" novalidate>
        @csrf
        <div id="clearanceWarning"
          class="hidden absolute top-4 left-1/2 -translate-x-1/2 px-4 py-1.5 rounded-full bg-red-600 text-[#F4F4F4] text-xs font-semibold shadow-lg">
          Please complete all required fields</div>
        <h3 class="font-extrabold text-2xl text-[#8B0000] mb-3">Request Clearance</h3>
        <p class="text-sm text-[#333333] mb-5">Please allow up to three (3) working days for processing.
        </p>
        <div class="mb-5">
          <label class="block text-sm font-bold text-[#8B0000] mb-1">Type of Clearance</label>
          <select name="document_type" required
            class="select select-bordered w-full rounded-xl bg-[#F4F4F4] text-[#333333] focus:outline-none focus:ring-0 focus:border-[#8B0000]">
            <option value="" disabled selected>Select type of clearance</option>
            <option value="Dental Clearance">Dental Clearance</option>
            <option value="Annual Dental Clearance">Annual Dental Clearance</option>
          </select>
        </div>
        <div class="mb-5">
          <label class="block text-sm font-bold text-[#8B0000] mb-1">Purpose</label>
          <select name="purpose" required
            class="select select-bordered w-full rounded-xl bg-[#F4F4F4] text-[#333333] focus:outline-none focus:ring-0 focus:border-[#8B0000]">
            <option value="" disabled selected>Select purpose</option>
            <option value="On-the-Job Training (OJT)">On-the-Job Training (OJT)</option>
            <option value="Employment Requirement">Employment Requirement</option>
            <option value="Academic Requirement">Academic Requirement</option>
          </select>
        </div>
        <div class="modal-action flex justify-between">
          <button type="button" onclick="dentalClearanceModal.close()"
            class="px-6 py-2 rounded-xl bg-gray-200 text-gray-700 font-semibold">Back</button>
          <button type="submit" class="px-6 py-2 rounded-xl bg-[#8B0000] text-[#F4F4F4] font-semibold">Save</button>
        </div>
      </form>
    </dialog>

    <!-- REQUEST DENTAL HEALTH RECORD MODAL -->
    <dialog id="dentalHealthRecordModal" class="modal">
      <form id="healthRecordRequestForm" method="POST" action="{{ route('patient.document.requests.store') }}"
        class="modal-box rounded-2xl bg-[#F4F4F4] relative" novalidate>
        @csrf
        <div id="healthRecordWarning"
          class="hidden absolute top-4 left-1/2 -translate-x-1/2 px-4 py-1.5 rounded-full bg-red-600 text-[#F4F4F4] text-xs font-semibold shadow-lg">
          Please complete all required fields</div>
        <h3 class="font-extrabold text-2xl text-[#8B0000] mb-3">Request Dental Health Record</h3>
        <p class="text-sm mb-5 text-[#333333]">Please allow up to three (3) working days for processing.
        </p>
        <div class="mb-5">
          <label class="block text-sm font-bold text-[#8B0000] mb-1">Type of Dental Health Record</label>
          <select name="document_type" required
            class="select select-bordered w-full rounded-xl bg-[#F4F4F4] text-[#333333] focus:outline-none focus:ring-0 focus:border-[#8B0000]">
            <option value="" disabled selected>Select type</option>
            <option value="All Dental Records">All Dental Records</option>
            <option value="Medical Records">Medical Records</option>
            <option value="Diagnosis and Treatment">Diagnosis and Treatment</option>
          </select>
        </div>
        <div class="mb-5">
          <label class="block text-sm font-bold text-[#8B0000] mb-1">Purpose</label>
          <select name="purpose" required
            class="select select-bordered w-full rounded-xl bg-[#F4F4F4] text-[#333333] focus:outline-none focus:ring-0 focus:border-[#8B0000]">
            <option value="" disabled selected>Select purpose</option>
            <option value="Personal Record">Personal Record</option>
            <option value="Academic Requirement">Academic Requirement</option>
            <option value="Employment Requirement">Employment Requirement</option>
          </select>
        </div>
        <div class="modal-action flex justify-between">
          <button type="button" onclick="dentalHealthRecordModal.close()"
            class="px-6 py-2 rounded-xl bg-gray-200 text-gray-700 font-semibold">Back</button>
          <button type="submit" class="px-6 py-2 rounded-xl bg-[#8B0000] text-[#F4F4F4] font-semibold">Save</button>
        </div>
      </form>
    </dialog>

    <!-- ACTIVE APPOINTMENT MODAL -->
    <dialog id="activeAppointmentModal" class="modal">
      <div class="modal-box swal-card rounded-2xl bg-white text-center shadow-2xl w-[min(92vw,420px)]">
        <div class="mx-auto mb-4 w-16 h-16 rounded-full bg-[#FFF0F0] flex items-center justify-center">
          <i class="fa-solid fa-calendar-xmark text-[#8B0000] text-2xl"></i>
        </div>
        <h3 class="text-xl font-extrabold text-[#8B0000] mb-2">Active Appointment Detected</h3>
        <p class="text-sm text-gray-600 mb-6">You already have an active appointment. Please complete or
          cancel it before booking a new one.</p>
        <div class="modal-action justify-center gap-3">
          <a href="{{ route('patient.appointment.index') }}"
            class="btn bg-[#8B0000] text-[#F4F4F4] hover:bg-[#7A0000] transition-colors duration-200">View
            My Appointments</a>
          <button id="closeActiveApptModalBtn" type="button" class="btn btn-ghost">Close</button>
        </div>
      </div>
    </dialog>

    </div>
  </main>

  <!-- ══════ FOOTER ══════ -->
  <footer class="footer bg-[#8B0000] text-[#F4F4F4] p-6">
    <div
      class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 text-sm text-center">
      <span><span class="text-gray-300">© 2025–2026</span> <span class="font-semibold">Polytechnic University of
          the Philippines</span></span>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/terms/" class="hover:underline">Terms of Use</a>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/privacy/" class="hover:underline">Privacy Statement</a>
    </div>
  </footer>

  @if (session('activeAppointmentModal'))
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var modal = document.getElementById("activeAppointmentModal");
      var closeBtn = document.getElementById("closeActiveApptModalBtn");
      if (!modal) return;
      modal.showModal();
      modal.addEventListener('click', function (e) {
        var box = modal.querySelector('.modal-box');
        if (box && !box.contains(e.target)) e.preventDefault();
      });
      modal.addEventListener('cancel', function (e) {
        e.preventDefault();
      });
      if (closeBtn) closeBtn.addEventListener("click", function () {
        modal.close();
      });
    });
  </script>
  @endif

  @if (session('login_as'))
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      showToast(
        'Login Successful',
        'Logged in successfully as <strong>{{ session('login_as') }}</strong>',
        'success'
      );
    });
  </script>
  @endif

  <script>
    /* TOAST */
    function showToast(title, message, type) {
      type = type || 'error';
      var container = document.getElementById('toastContainer');
      var t = document.createElement('div');
      t.className = 'toast ' + type;
      var icon = type === 'error' ?
        '<i class="fa-solid fa-circle-exclamation toast-icon"></i>' :
        '<i class="fa-solid fa-circle-check toast-icon"></i>';
      t.innerHTML = '<div class="toast-icon-wrap">' + icon + '</div>' +
        '<div class="toast-body"><div class="toast-title">' + title + '</div>' +
        '<div class="toast-msg">' + message + '</div></div>' +
        '<button class="toast-close" onclick="this.closest(\'.toast\').classList.add(\'hide\')">' +
        '<i class="fa-solid fa-xmark"></i></button>';
      container.appendChild(t);
      requestAnimationFrame(function () {
        requestAnimationFrame(function () {
          t.classList.add('show');
        });
      });
      setTimeout(function () {
        t.classList.remove('show');
        t.classList.add('hide');
        setTimeout(function () {
          t.remove();
        }, 400);
      }, 4500);
    }

    var HOME_RECORDS = @json($homeRecords);

    @php
    $upcomingJs = null;
    if (isset($upcomingAppointment) && $upcomingAppointment) {
      $uD = Carbon:: parse($upcomingAppointment -> appointment_date);
      $uT = Carbon:: parse($upcomingAppointment -> appointment_time);
      $upcomingJs = [
        'exists' => true,
        'service' => $upcomingAppointment -> service_type ?? '—',
        'date' => $uD -> format('M d, Y'),
        'time_raw' => $upcomingAppointment -> appointment_time,
        'time_fmt' => $uT -> format('g:i A'),
        'dentist' => $upcomingAppointment -> dentist_name ?? 'Dr. Nelson P. Angeles',
        'status' => ucfirst($upcomingAppointment -> status),
        'isRescheduled' => strtolower($upcomingAppointment -> status) === 'rescheduled',
        'indexUrl' => route('patient.appointment.index'),
        'bookUrl' => route('patient.book.appointment'),
      ];
    } else {
      $upcomingJs = [
        'exists' => false,
        'bookUrl' => route('patient.book.appointment'),
      ];
    }
    @endphp
    var UPCOMING_DATA = @json($upcomingJs);

    var PATIENT_NAME = "{{ urlencode($patient->name) }}";

    @php
    $profileRows = [['Date of Birth', $patient -> birthdate ? Carbon :: parse($patient -> birthdate) -> format('F d, Y') : '-'], ['Age', $patient -> age ?? '-'], ['Gender', $patient -> gender ?? '-'], ['Contact', $patient -> phone ?? '-'], ['Email', $patient -> email ?? '-']];
    @endphp
    var PROFILE_DATA = {
      name: "{{ ucwords(strtolower($patient->name)) }}",
      patientId: "{{ $patient->patient_id ?? 'N/A' }}",
      rows: @json($profileRows),
      avatar: "{{ $patient->profile_image ? asset('storage/' . $patient->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($patient->name) . '&background=660000&color=FFFFFF&rounded=true&size=128' }}"
    };

    var ROUTE_BOOK = "{{ route('patient.book.appointment') }}";
    var ROUTE_RECORD = "{{ route('patient.record') }}";

    /* ══════════════════════════════════════
       THEME
    ══════════════════════════════════════ */
    var html = document.documentElement;
    var themeToggleContainer = document.getElementById("themeToggle");
    var themeIndicator = themeToggleContainer.querySelector(".theme-indicator");
    var themeOptions = themeToggleContainer.querySelectorAll(".theme-option");

    function applyTheme(theme) {
      html.setAttribute("data-theme", theme);
      localStorage.setItem("theme", theme);
      themeOptions.forEach(function (o) {
        o.classList.toggle("active", o.getAttribute("data-theme") === theme);
      });
      themeIndicator.classList.toggle("dark-mode", theme === "dark");
      var fi = document.getElementById("darkModeFabIcon");
      if (fi) fi.className = theme === "dark" ? "fa-solid fa-sun" : "fa-solid fa-moon";
    }
    applyTheme(localStorage.getItem("theme") || "light");
    themeOptions.forEach(function (o) {
      o.addEventListener("click", function () {
        applyTheme(o.getAttribute("data-theme"));
      });
    });

    /* ══════════════════════════════════════
       SIDEBAR
    ══════════════════════════════════════ */
    var sidebarOpen = true;

    function applyLayout(w) {
      document.getElementById('sidebar').style.width = w;
      document.getElementById('mainContent').style.marginLeft = w;
    }

    function toggleSidebar() {
      var s = document.getElementById('sidebar'),
        tx = document.querySelectorAll('.sidebar-text');
      var ic = document.getElementById('sidebarIcon'),
        wr = document.getElementById('sidebarToggleWrapper');
      sidebarOpen = !sidebarOpen;
      if (sidebarOpen) {
        applyLayout('220px');
        s.classList.replace('collapsed', 'expanded');
        tx.forEach(function (t) {
          t.classList.remove('opacity-0', 'w-0');
          t.classList.add('opacity-100');
        });
        wr.classList.replace('justify-center', 'justify-end');
        ic.classList.replace('fa-bars', 'fa-xmark');
      } else {
        applyLayout('72px');
        s.classList.replace('expanded', 'collapsed');
        tx.forEach(function (t) {
          t.classList.add('opacity-0', 'w-0');
          t.classList.remove('opacity-100');
        });
        wr.classList.replace('justify-end', 'justify-center');
        ic.classList.replace('fa-xmark', 'fa-bars');
      }
      applyTheme(localStorage.getItem("theme") || "light");
    }

    /* ══════════════════════════════════════
       MOBILE PROFILE ACCORDION
    ══════════════════════════════════════ */
    function toggleMobileProfile() {
      var p = document.getElementById('mobileProfileAccordion'),
        c = document.getElementById('mobileProfileChevron');
      var o = p.classList.contains('open');
      p.classList.toggle('open', !o);
      if (c) c.style.transform = o ? 'rotate(0deg)' : 'rotate(180deg)';
    }

    /* ══════════════════════════════════════
       HELPERS
    ══════════════════════════════════════ */
    function escapeHtml(str) {
      return String(str ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g,
        '&quot;').replace(/'/g, '&#039;');
    }

    function formatTime(raw) {
      if (!raw) return '—';
      raw = String(raw).trim();
      if (/[AaPp][Mm]$/.test(raw)) return raw;
      var m = raw.match(/^(\d{1,2}):(\d{2})/);
      if (!m) return raw;
      var h = parseInt(m[1], 10),
        mn = m[2],
        ampm = h >= 12 ? 'PM' : 'AM',
        hr = h % 12 || 12;
      return hr + ':' + mn + ' ' + ampm;
    }

    function shortDate(raw) {
      if (!raw) return '—';
      return String(raw).replace(
        /^(January|February|March|April|May|June|July|August|September|October|November|December)/,
        function (s) {
          return s.slice(0, 3);
        });
    }

    /* ══════════════════════════════════════
       DOM READY — all rendering happens here
    ══════════════════════════════════════ */
    document.addEventListener('DOMContentLoaded', function () {

      /* Layout */
      if (window.innerWidth >= 768) {
        sidebarOpen = true;
        applyLayout('220px');
      } else {
        document.getElementById('mainContent').style.marginLeft = '0';
      }

      /* Mobile FAB */
      var mf = document.getElementById('mobFab'),
        mm = document.getElementById('mobFabMenu');
      if (mf && mm) {
        mf.addEventListener('click', function (e) {
          e.stopPropagation();
          var o = mm.classList.contains('open');
          mm.classList.toggle('open', !o);
          mf.classList.toggle('open', !o);
        });
        mm.addEventListener('click', function (e) {
          e.stopPropagation();
        });
      }

      /* Notifications */
      var nb = document.getElementById("notifBtn"),
        nm = document.getElementById("notifMenu");
      if (nb && nm) {
        nb.addEventListener("click", function (e) {
          e.stopPropagation();
          nm.classList.toggle("open");
        });
        nm.addEventListener("click", function (e) {
          e.stopPropagation();
        });
        document.addEventListener("keydown", function (e) {
          if (e.key === "Escape") nm.classList.remove("open");
        });
      }

      /* Outside click */
      document.addEventListener('click', function (e) {
        if (mm) {
          mm.classList.remove('open');
          if (mf) mf.classList.remove('open');
        }
        if (nm) nm.classList.remove('open');
        var panel = document.getElementById('mobileProfileAccordion');
        var toggle = document.getElementById('mobileProfileToggle');
        var chev = document.getElementById('mobileProfileChevron');
        if (panel && toggle && !panel.contains(e.target) && !toggle.contains(e.target)) {
          panel.classList.remove('open');
          if (chev) chev.style.transform = 'rotate(0deg)';
        }
      });

      /* Greeting */
      (function () {
        var h = new Date().getHours(),
          g, ic, an;
        if (h >= 6 && h < 12) {
          g = 'Good morning';
          ic = 'fa-solid fa-sun text-yellow-400 text-sm';
          an = 'greet-spin';
        } else if (h >= 12 && h < 18) {
          g = 'Good afternoon';
          ic = 'fa-solid fa-cloud-sun text-yellow-300 text-sm';
          an = 'greet-drift';
        } else {
          g = 'Good evening';
          ic = 'fa-solid fa-moon text-blue-300 text-sm';
          an = 'greet-float';
        }
        var el = document.getElementById('greetingText'),
          ico = document.getElementById('greetingIcon');
        if (el) el.textContent = g;
        if (ico) ico.className = ic + ' ' + an;
      })();

      /* ── Fire all renders with simulated 1s skeleton delay ── */
      setTimeout(function () {
        renderUpcomingAppointment();
        renderProfile();
        renderRequestDocs();
        renderRecords();
        loadCalendar();
      }, 1000);

    });

    /* ══════════════════════════════════════
       RENDER: UPCOMING APPOINTMENT
    ══════════════════════════════════════ */
    function renderUpcomingAppointment() {
      var wrapper = document.getElementById('upcomingAppointmentWrapper');
      if (!wrapper) return;
      var d = UPCOMING_DATA;

      if (d.exists) {
        var statusPillCls = d.isRescheduled ?
          'bg-yellow-400/20 text-yellow-100' :
          'bg-blue-500/20 text-blue-100';
        var statusDotCls = d.isRescheduled ? 'bg-yellow-300' : 'bg-blue-400';

        wrapper.innerHTML =
          '<div class="rounded-2xl overflow-hidden border border-[#EDE8E4] shadow-sm fade-up">' +

          '<div class="flex items-center justify-between gap-3 px-5 py-3" style="background:linear-gradient(135deg,#5A0000,#8B0000);">' +
          '<div class="flex items-center gap-2.5">' +
          '<div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center flex-shrink-0">' +
          '<i class="fa-regular fa-calendar-check text-white text-sm"></i>' +
          '</div>' +
          '<span class="text-white font-bold text-sm">Upcoming Appointment</span>' +
          '</div>' +
          '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold flex-shrink-0 ' +
          statusPillCls + '">' +
          '<span class="w-1.5 h-1.5 rounded-full flex-shrink-0 ' + statusDotCls + '"></span>' +
          escapeHtml(d.status) +
          '</span>' +
          '</div>' +

          '<div class="bg-white px-5 py-4">' +
          '<div class="grid grid-cols-2 sm:grid-cols-3 gap-3">' +
          '<div><p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Service</p><p class="text-sm font-bold text-[#8B0000]">' +
          escapeHtml(d.service) + '</p></div>' +
          '<div><p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Date &amp; Time</p><p class="text-sm font-bold text-[#1C1410]">' +
          escapeHtml(d.date) + '<span class="text-[#8B0000] mx-0.5">·</span>' + escapeHtml(d.time_fmt) +
          '</p></div>' +
          '<div><p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Dentist</p><p class="text-sm font-bold text-[#1C1410]">' +
          escapeHtml(d.dentist) + '</p></div>' +
          '</div>' +
          '<div class="mt-3 pt-3 border-t border-gray-100 flex justify-end">' +
          '<a href="' + escapeHtml(d.indexUrl) +
          '" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#8B0000] hover:text-[#660000] transition-colors">' +
          'View details <i class="fa-solid fa-arrow-right text-[10px]"></i>' +
          '</a>' +
          '</div>' +
          '</div></div>';

      } else {
        wrapper.innerHTML =
          '<div class="rounded-2xl overflow-hidden border border-[#EDE8E4] shadow-sm fade-up">' +
          '<div class="flex items-center gap-2.5 px-5 py-3" style="background:linear-gradient(135deg,#5A0000,#8B0000);">' +
          '<div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center flex-shrink-0">' +
          '<i class="fa-regular fa-calendar text-white text-sm"></i>' +
          '</div>' +
          '<span class="text-white font-bold text-sm">No Upcoming Appointment</span>' +
          '</div>' +
          '<div class="bg-white px-5 py-4 flex items-center justify-between gap-3 flex-wrap">' +
          '<p class="text-sm text-gray-500">Ready for your next visit? Book an appointment now.</p>' +
          '<a href="' + escapeHtml(d.bookUrl) +
          '" class="inline-flex items-center gap-1.5 bg-[#8B0000] text-white text-xs font-semibold px-4 py-2 rounded-xl hover:bg-[#660000] transition-colors flex-shrink-0">' +
          '<i class="fa-solid fa-calendar-plus text-xs"></i> Book Now' +
          '</a>' +
          '</div></div>';
      }
    }

    /* ── PROFILE ── */
    function renderProfile() {
      document.getElementById("profileSkeletonContainer").innerHTML =
        '<div class="bg-white rounded-2xl overflow-hidden shadow-sm fade-up">' +
        '<div class="bg-gradient-to-r from-[#660000] to-[#8B0000] px-6 pt-6 pb-6 text-[#F4F4F4] flex items-center gap-4">' +
        '<div class="avatar flex-shrink-0"><div class="w-14 h-14 rounded-full overflow-hidden ring-1 ring-white/30">' +
        '<img src="https://ui-avatars.com/api/?name={{ urlencode($patient->name) }}&background=660000&color=FFFFFF&rounded=true&size=128" alt="Profile">' +
        '</div></div>' +
        '<div><p class="font-bold text-xl leading-tight">{{ isset($patient->name) ? ucwords(strtolower($patient->name)) : 'Guest' }}</p>' +
          '<p class="text-sm text-[#F4F4F4]/70 mb-2">Student</p>' +
          '<span class="inline-block bg-[#FFD700]/40 text-[#FFD700] border border-[#FFD700] text-xs font-extrabold px-2.5 py-0.5 rounded-full">{{ $patient->patient_id ?? 'N / A' }}</span>' +
            '</div></div>' +
            '<div class="mx-0 bg-white divide-y divide-gray-100 text-sm rounded-b-2xl overflow-hidden">' + [
              ['Date of Birth',
                '{{ $patient->birthdate ? Carbon::parse($patient->birthdate)->format('F d, Y') : ' - ' }}'
              ],
              ['Age', '{{ $patient->age ?? ' - ' }}'],
              ['Gender', '{{ $patient->gender ?? ' - ' }}'],
              ['Contact', '{{ $patient->phone ?? ' - ' }}'],
              ['Email', '{{ $patient->email ?? ' - ' }}'],
            ].map(function (row) {
              return '<div class="flex px-4 py-3 gap-4">' +
                '<span class="text-[#757575] uppercase text-[10px] font-semibold w-28 flex-shrink-0 pt-0.5">' +
                row[0] + '</span>' +
                '<span class="font-semibold text-[#333333]">' + row[1] + '</span></div>';
            }).join('') + '</div></div>';
    }

    /* ══════════════════════════════════════
       RENDER: REQUEST DOCS
    ══════════════════════════════════════ */
    function renderRequestDocs() {
      document.getElementById("requestDocsContainer").innerHTML =
        '<div class="flex items-center gap-4 mb-4">' +
        '<div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">' +
        '<i class="fa-solid fa-folder text-[#8B0000] text-lg"></i></div>' +
        '<h3 class="font-extrabold text-lg text-[#333333]">Request Documents</h3></div>' +

        '<a onclick="document.getElementById(\'dentalHealthRecordModal\')?.showModal()" ' +
        'class="flex items-center gap-3 border border-gray-300 rounded-xl p-3 hover:border-red-800 hover:shadow-lg transition cursor-pointer fade-up">' +
        '<div class="bg-[#8B0000] w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0">' +
        '<i class="fa-solid fa-file-medical text-white text-lg"></i></div>' +
        '<div><p class="font-bold text-sm text-[#333333]">Request Dental Health Record</p>' +
        '<p class="text-xs text-[#757575]">All Dental Records • Medical Record • Diagnosis &amp; Treatments</p></div></a>' +

        '<a onclick="document.getElementById(\'dentalClearanceModal\')?.showModal()" ' +
        'class="flex items-center gap-3 border border-gray-300 rounded-xl p-3 hover:border-red-800 hover:shadow-lg transition cursor-pointer fade-up mt-3">' +
        '<div class="bg-[#8B0000] w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0">' +
        '<i class="fa-solid fa-file-circle-check text-white text-lg"></i></div>' +
        '<div><p class="font-bold text-sm text-[#333333]">Request Dental Clearance</p>' +
        '<p class="text-xs text-[#757575]">Dental Clearance • Annual Dental Clearance</p></div></a>';
    }

    /* ══════════════════════════════════════
       RENDER: RECORDS
    ══════════════════════════════════════ */
    function renderRecords() {
      var container = document.getElementById("recordsInnerContainer");
      var viewAll = document.getElementById("viewAllContainer");
      var visitCount = document.getElementById("recordsVisitCount");
      var statLatest = document.getElementById("recordsStatLatest");
      var latestDate = document.getElementById("recordsLatestDate");
      if (!container) return;

      if (!HOME_RECORDS || HOME_RECORDS.length === 0) {
        if (visitCount) visitCount.textContent = "0 visits";
        container.innerHTML =
          '<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px 20px;text-align:center;">' +
          '<div style="width:72px;height:72px;border-radius:20px;background:#FDF1F1;border:1.5px solid rgba(139,0,0,.12);display:flex;align-items:center;justify-content:center;margin-bottom:16px;">' +
          '<i class="fa-solid fa-tooth" style="font-size:28px;color:#8B0000;opacity:.4;"></i></div>' +
          '<p style="font-size:20px;font-weight:700;color:#1C1410;margin-bottom:6px;">No records yet</p>' +
          '<p style="font-size:13px;color:#9E9690;max-width:260px;line-height:1.6;">Completed appointment records will appear here after your first dental visit.</p>' +
          '<a href="' + ROUTE_BOOK +
          '" style="margin-top:24px;display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:50px;background:#8B0000;color:white;font-size:13px;font-weight:600;text-decoration:none;box-shadow:0 2px 12px rgba(139,0,0,.3);">' +
          '<i class="fa-solid fa-calendar-plus" style="font-size:11px;"></i> Book Appointment</a>' +
          '</div>';
        if (viewAll) viewAll.style.display = "none";
        return;
      }

      var count = HOME_RECORDS.length;
      if (visitCount) visitCount.textContent = count + (count === 1 ? " visit" : " visits");
      if (statLatest && latestDate && HOME_RECORDS[0].date) {
        var pts = HOME_RECORDS[0].date.split(" ");
        latestDate.textContent = "Latest: " + (pts[0] ? pts[0].slice(0, 3) : "") + " " + (pts[2] || "");
        statLatest.style.display = "flex";
      }

      if (viewAll) {
        viewAll.style.display = "block";
        viewAll.classList.remove("hidden");
      }

      var html = '<div>';
      HOME_RECORDS.forEach(function (r, idx) {
        var encoded = encodeURIComponent(JSON.stringify(r));
        var dispTime = formatTime(r.time);
        var dispDate = shortDate(r.date);
        var isLast = idx === HOME_RECORDS.length - 1;

        html +=
          '<div class="flex items-stretch">' +

          /* Timeline */
          '<div class="flex flex-col items-center w-8 flex-shrink-0 pt-4">' +
          '<div class="w-[11px] h-[11px] rounded-full bg-[#8B0000] border-2 border-white flex-shrink-0 z-10" style="box-shadow:0 0 0 3px rgba(139,0,0,.18);"></div>' +
          (isLast ? '<div class="flex-1"></div>' :
            '<div class="flex-1 w-px mt-1.5" style="background:linear-gradient(to bottom,rgba(139,0,0,.2),rgba(139,0,0,.04));"></div>'
          ) +
          '</div>' +

          /* Card */
          '<div class="flex-1 min-w-0 pb-2.5">' +
          '<div class="bg-white border border-[#EDE8E4] rounded-[14px] p-3.5 flex flex-wrap sm:flex-nowrap items-center justify-between gap-2.5 transition-all duration-200 hover:shadow-[0_6px_24px_rgba(139,0,0,.08)] hover:border-[rgba(139,0,0,.2)] hover:-translate-y-px">' +

          '<div class="min-w-0 flex-1">' +
          '<p class="text-[13.5px] font-bold text-[#8B0000] leading-snug mb-1.5">' + escapeHtml(r
            .service) + '</p>' +
          '<div class="flex flex-wrap items-center gap-1.5">' +
          '<span class="inline-flex items-center gap-1 bg-[#FDF1F1] text-[#8B0000] rounded-full px-2 py-0.5 text-[11px] font-semibold">' +
          '<i class="fa-regular fa-calendar text-[9px] opacity-70"></i>' + escapeHtml(dispDate) +
          '</span>' +
          '<span class="inline-flex items-center gap-1 bg-[#FDF1F1] text-[#8B0000] rounded-full px-2 py-0.5 text-[11px] font-semibold">' +
          '<i class="fa-regular fa-clock text-[9px] opacity-70"></i>' + escapeHtml(dispTime) + '</span>' +
          '</div></div>' +

          '<button type="button" ' +
          'class="w-full sm:w-auto flex-shrink-0 inline-flex items-center justify-center gap-1.5 px-3.5 py-[7px] rounded-full bg-[#8B0000] hover:bg-[#5A0000] text-white text-xs font-semibold border-none cursor-pointer whitespace-nowrap transition-all duration-150 hover:-translate-y-px" ' +
          'style="box-shadow:0 2px 10px rgba(139,0,0,.28);" ' +
          'onclick="openRecordModalFromData(\'' + encoded + '\')">' +
          '<i class="fa-regular fa-eye text-[11px]"></i> Details</button>' +

          '</div></div></div>';
      });
      html += '</div>';
      container.innerHTML = html;
    }

    /* ══════════════════════════════════════
       RECORD MODAL
    ══════════════════════════════════════ */
    function openRecordModalFromData(encodedJson) {
      openRecordModal(JSON.parse(decodeURIComponent(encodedJson)));
    }

    function openRecordModal(data) {
      var modal = document.getElementById('record_modal');
      if (!modal) return;
      document.getElementById('m_service').textContent = data.service || '—';
      document.getElementById('m_date').textContent = data.date || '—';
      document.getElementById('m_time').textContent = formatTime(data.time);
      var BADGE =
        'inline-flex items-center justify-center w-32 px-4 py-1 text-sm leading-none rounded-full font-semibold';
      var status = (data.status || 'completed').trim();
      var sEl = document.getElementById('m_status');
      sEl.textContent = status;
      sEl.className = BADGE;
      var s = status.toLowerCase();
      if (s === 'completed') sEl.classList.add('bg-emerald-200', 'text-emerald-900');
      else if (s === 'rescheduled') sEl.classList.add('bg-yellow-200', 'text-yellow-900');
      else if (s === 'cancelled') sEl.classList.add('bg-red-200', 'text-red-900');
      else sEl.classList.add('bg-gray-200', 'text-gray-800');
      var dEl = document.getElementById('m_duration');
      dEl.textContent = (data.duration || '—').trim() || '—';
      dEl.className = BADGE + ' bg-gray-200 text-gray-800';
      document.getElementById('m_remarks').textContent = (data.remarks || '').trim() || '—';
      document.getElementById('m_oral').textContent = (data.oral || '').trim() || '—';
      document.getElementById('m_diagnosis').textContent = (data.diagnosis || '').trim() || '—';
      document.getElementById('m_prescription').textContent = (data.prescription || '').trim() || '—';
      modal.showModal();
    }

    /* ══════════════════════════════════════
       CALENDAR
    ══════════════════════════════════════ */
    function loadCalendar() {
      var MAX_PER_DAY = 5;
      var myAppts = calendarAppointments || {};
      var apptCounts = calendarCounts || {};
      var unavail = calendarUnavailableDates || [];
      var holidays = calendarHolidays || {};
      var today = new Date();
      var curYear = today.getFullYear(),
        curMonth = today.getMonth();

      function pad(n) {
        return String(n).padStart(2, '0');
      }

      function isWeekend(y, m, d) {
        var dow = new Date(y, m, d).getDay();
        return dow === 0 || dow === 6;
      }

      function getHolidaysForMonth(y, m) {
        var f = {};
        Object.keys(holidays).forEach(function (ds) {
          var p = ds.split('-').map(Number);
          if (p[0] === y && p[1] === m + 1) f[ds] = holidays[ds];
        });
        return f;
      }

      function renderCalendar(year, month) {
        var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
          "October", "November", "December"
        ];
        var dayLabels = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        var firstDow = new Date(year, month, 1).getDay();
        var totalDays = new Date(year, month + 1, 0).getDate();
        var hl = getHolidaysForMonth(year, month);
        var cells = '';

        for (var i = 0; i < firstDow; i++) cells += '<div></div>';
        for (var d = 1; d <= totalDays; d++) {
          var ds = year + '-' + pad(month + 1) + '-' + pad(d);
          var isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
          var weekend = isWeekend(year, month, d);
          var holiday = hl[ds] || null;
          var myAppt = myAppts[ds] || null;
          var count = apptCounts[ds] || 0;
          var isFull = count >= MAX_PER_DAY;
          var isUnavail = unavail.indexOf(ds) !== -1 || weekend;
          var bgClass = '',
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
            dotHtml += '<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full ' + (
              isToday ? 'bg-white' : 'bg-[#008440]') + '"></span>';
            tooltipTxt = '<i class="fa-regular fa-calendar-check mr-1 text-[#6EE7A0]"></i>' + myAppt;
          }
          if (isFull && !myAppt && !isUnavail && !holiday) {
            dotHtml +=
              '<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-red-500"></span>';
            tooltipTxt = '<i class="fa-solid fa-circle-xmark mr-1 text-red-400"></i>Fully booked (' + count + ')';
          }
          if (holiday && !myAppt) {
            dotHtml =
              '<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-blue-400"></span>';
            tooltipTxt = '<i class="fa-solid fa-star mr-1 text-blue-300"></i>' + holiday;
          }
          if (isUnavail && !holiday && !myAppt) {
            tooltipTxt = weekend ? '<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Clinic closed' :
              '<i class="fa-solid fa-ban mr-1 text-gray-400"></i>Not available';
          }
          var tooltip = tooltipTxt ?
            '<div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 z-50 bg-[#1a1a1a] text-white text-[11px] font-medium px-3 py-1.5 rounded-lg whitespace-nowrap shadow-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200">' +
            tooltipTxt +
            '<div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-[#1a1a1a]"></div></div>' :
            '';
          cells += '<div class="relative group flex items-center justify-center">' + tooltip +
            '<div class="relative w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-xs sm:text-sm rounded-full transition-all duration-150 ' +
            bgClass + ' ' + textClass + ' ' + ringClass + ' cursor-default">' + d + dotHtml + '</div></div>';
        }

        var headerHtml = dayLabels.map(function (l, i) {
          return '<div class="text-center text-[9px] sm:text-[10px] font-bold ' + (i === 0 || i === 6 ?
            'text-[#8B0000]/40' : 'text-[#333333]') + ' uppercase tracking-widest">' + l + '</div>';
        }).join('');

        document.getElementById("calendarSkeletonContainer").innerHTML =
          '<div class="h-full flex flex-col select-none">' +
          '<div class="flex items-center justify-center gap-2 mb-3"><i class="fa-regular fa-calendar-check text-[#333333] text-lg sm:text-xl"></i><h2 class="text-lg sm:text-xl font-extrabold text-[#333333]">Dental Clinic Schedule</h2></div>' +
          '<hr class="border-t border-gray-200 mb-3 sm:mb-4">' +
          '<div class="flex items-center justify-between mt-4 sm:mt-6 mb-4 sm:mb-5">' +
          '<button onclick="changeMonth(-1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] text-[#8B0000] transition-colors duration-150"><i class="fa-solid fa-chevron-left text-xs"></i></button>' +
          '<div class="text-center"><p class="text-base sm:text-lg font-extrabold text-[#8B0000]">' + monthNames[
          month] + '</p><p class="text-xs text-[#9CA3AF] font-semibold tracking-widest">' + year +
          '</p></div>' +
          '<button onclick="changeMonth(1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-[#FFF0F0] text-[#8B0000] transition-colors duration-150"><i class="fa-solid fa-chevron-right text-xs"></i></button></div>' +
          '<div class="grid grid-cols-7 gap-1 sm:gap-2 mt-2 sm:mt-4 mb-2">' + headerHtml + '</div>' +
          '<div class="grid grid-cols-7 gap-1 sm:gap-2 flex-1 content-start">' + cells + '</div>' +
          '<div class="flex flex-wrap items-center justify-center gap-2 mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100">' +
          '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 font-medium px-2.5 py-1 rounded-full border border-gray-200 bg-gray-50">' +
          '<span class="w-2 h-2 rounded-full bg-[#008440] inline-block flex-shrink-0"></span>My Appointment</div>' +
          '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 font-medium px-2.5 py-1 rounded-full border border-gray-200 bg-gray-50">' +
          '<span class="w-2 h-2 rounded-full bg-blue-400 inline-block flex-shrink-0"></span>Holiday</div>' +
          '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 font-medium px-2.5 py-1 rounded-full border border-gray-200 bg-gray-50">' +
          '<span class="w-2 h-2 rounded-full bg-red-500 inline-block flex-shrink-0"></span>Full Schedule</div>' +
          '<div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-gray-600 font-medium px-2.5 py-1 rounded-full border border-gray-200 bg-gray-50">' +
          '<span class="w-2 h-2 rounded-full bg-[#8B0000] inline-block flex-shrink-0"></span>Today</div>' +
          '</div></div>';
      }

      window.changeMonth = function (dir) {
        curMonth += dir;
        if (curMonth > 11) {
          curMonth = 0;
          curYear++;
        }
        if (curMonth < 0) {
          curMonth = 11;
          curYear--;
        }
        renderCalendar(curYear, curMonth);
      };
      renderCalendar(curYear, curMonth);
    }
  </script>

</body>

</html>