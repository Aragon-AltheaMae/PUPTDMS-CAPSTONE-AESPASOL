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

    /* Notif dropdown */
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
      transition: background-color 0.2s ease, transform 0.2s ease;
    }

    #sidebar.expanded .sidebar-link {
      justify-content: flex-start;
      padding-left: 0.25rem;
    }

    #sidebar.expanded .sidebar-link i {
      margin-right: 0.75rem;
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
      font-size: 0.65rem;
      font-weight: 500;
      letter-spacing: 0.08em;
      color: #757575;
      text-transform: uppercase;
      margin-bottom: 0.25rem;
    }

    body,
    #sidebar,
    main,
    .card,
    .modal-box {
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    #sidebar.collapsed .section-label {
      display: none;
    }

    #sidebar.expanded .section-label {
      display: block;
    }

    #sidebar.collapsed .sidebar-link {
      justify-content: center;
      padding-left: 0;
      padding-right: 0;
    }

    #sidebar.collapsed .sidebar-link span:first-of-type {
      margin: 0 auto;
    }

    #sidebar.collapsed .sidebar-link i {
      margin-right: 0 !important;
      width: 100%;
      text-align: center;
    }

    #sidebar.expanded .sidebar-link {
      justify-content: flex-start;
    }

    #sidebar.expanded .sidebar-link i {
      margin-right: 0.75rem;
    }

    #sidebar.expanded .sidebar-link span i {
      margin-right: 0 !important;
    }

    #sidebar.expanded .sidebar-link:hover {
      transform: translateX(4px);
    }

    #sidebar.collapsed .sidebar-tooltip {
      display: block;
    }

    #sidebar.expanded .sidebar-tooltip {
      display: none;
    }

    .sidebar-link.bg-\[\#8B0000\] {
      box-shadow: 0 0 12px rgba(139, 0, 0, 0.45);
    }

    /* ── THEME ── */
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
      transition: all 0.3s ease;
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
      transition: color 0.2s ease;
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
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

    /* ── DARK MODE ── */
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
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    /* ══════════════════════════════════
       TABS
    ══════════════════════════════════ */
    @keyframes tabSlideUp {
      from {
        opacity: 0;
        transform: translateY(12px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
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
      cursor: pointer;
      transition: box-shadow .2s ease, transform .2s ease, border-color .2s;
      overflow: hidden;
      animation: tabSlideUp .35s ease both;
    }

    .tab-btn:nth-child(1) {
      animation-delay: .03s;
    }

    .tab-btn:nth-child(2) {
      animation-delay: .08s;
    }

    .tab-btn:nth-child(3) {
      animation-delay: .13s;
    }

    .tab-btn:nth-child(4) {
      animation-delay: .18s;
    }

    .tab-btn:nth-child(5) {
      animation-delay: .23s;
    }

    .tab-btn:nth-child(6) {
      animation-delay: .28s;
    }

    /* No top accent */
    .tab-btn::before {
      display: none;
    }

    .tab-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, .08);
      border-color: transparent;
    }

    .tab-btn:hover::after {
      opacity: 0.45;
    }

    /* Bottom accent bar (active) */
    .tab-btn::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 4px;
      border-radius: 0 0 16px 16px;
      opacity: 0;
      transition: opacity .2s;
    }

    .tab-btn.tab-active {
      border-color: transparent;
      box-shadow: 0 6px 24px rgba(0, 0, 0, .10);
      transform: translateY(-2px);
    }

    .tab-btn.tab-active::after {
      opacity: 1;
    }

    .tab-icon-wrap {
      width: 40px;
      height: 40px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 14px;
      font-size: 18px;
    }

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

    .tab-scheduled .tab-icon-wrap {
      background: #EFF6FF;
      color: #2563EB;
    }

    .tab-upcoming .tab-icon-wrap {
      background: #FFF7ED;
      color: #EA580C;
    }

    .tab-rescheduled .tab-icon-wrap {
      background: #fefce8;
      color: #ca8a04;
    }

    .tab-cancelled .tab-icon-wrap {
      background: #ffecec;
      color: #df0606;
    }

    .tab-completed .tab-icon-wrap {
      background: #F0FDF4;
      color: #16A34A;
    }

    .tab-all .tab-icon-wrap {
      background: #FFF7ED;
      color: #D97706;
    }

    .tab-scheduled::after {
      background: #2563EB;
    }

    .tab-scheduled::before {
      background: #2563EB;
    }

    .tab-upcoming::after {
      background: #EA580C;
    }

    .tab-upcoming::before {
      background: #EA580C;
    }

    .tab-rescheduled::after {
      background: #ca8a04;
    }

    .tab-rescheduled::before {
      background: #ca8a04;
    }

    .tab-cancelled::after {
      background: #df0606;
    }

    .tab-cancelled::before {
      background: #df0606;
    }

    .tab-completed::after {
      background: #16A34A;
    }

    .tab-completed::before {
      background: #16A34A;
    }

    .tab-all::after {
      background: #D97706;
    }

    .tab-all::before {
      background: #D97706;
    }

    .tab-scheduled.tab-active {
      box-shadow: 0 6px 24px rgba(37, 99, 235, .12);
    }

    .tab-upcoming.tab-active {
      box-shadow: 0 6px 24px rgba(234, 88, 12, .12);
    }

    .tab-rescheduled.tab-active {
      box-shadow: 0 6px 24px rgba(202, 138, 4, .12);
    }

    .tab-cancelled.tab-active {
      box-shadow: 0 6px 24px rgba(247, 85, 85, .12);
    }

    .tab-completed.tab-active {
      box-shadow: 0 6px 24px rgba(22, 163, 74, .12);
    }

    .tab-all.tab-active {
      box-shadow: 0 6px 24px rgba(217, 119, 6, .12);
    }

    /* ══════════════════════════════════
       PATIENT CARDS
    ══════════════════════════════════ */
    @keyframes cardIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
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

    .patient-card:nth-child(even) {
      background: #FDFAF8;
    }

    .patient-card:nth-child(1) {
      animation-delay: .05s;
    }

    .patient-card:nth-child(2) {
      animation-delay: .12s;
    }

    .patient-card:nth-child(3) {
      animation-delay: .19s;
    }

    .patient-card:nth-child(4) {
      animation-delay: .26s;
    }

    .patient-card:nth-child(5) {
      animation-delay: .33s;
    }

    .patient-card:hover {
      border-color: #D1D5DB;
      box-shadow: 0 8px 28px rgba(0, 0, 0, .09);
      transform: translateY(-2px);
    }

    .patient-card .accent-bar {
      position: absolute;
      left: 0;
      top: 14px;
      bottom: 14px;
      width: 4px;
      border-radius: 0 4px 4px 0;
    }

    .accent-upcoming {
      background: linear-gradient(180deg, #E64A19, #BF360C);
    }

    .accent-today {
      background: linear-gradient(180deg, #1E88E5, #1565C0);
    }

    .accent-rescheduled {
      background: linear-gradient(180deg, #ca8a04, #92400e);
    }

    .accent-cancelled {
      background: linear-gradient(180deg, #E53935, #B71C1C);
    }

    .accent-completed {
      background: linear-gradient(180deg, #388E3C, #1B5E20);
    }

    .accent-default {
      background: linear-gradient(180deg, #9CA3AF, #6B7280);
    }

    .card-arrow-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: #F3F4F6;
      border: 1.5px solid #E5E7EB;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #9CA3AF;
      font-size: 14px;
      flex-shrink: 0;
      transition: all .2s;
    }

    .patient-card:hover .card-arrow-btn {
      background: #8B0000;
      border-color: #8B0000;
      color: #fff;
      box-shadow: 0 4px 12px rgba(139, 0, 0, .3);
    }

    /* ── STATUS PILLS ── */
    .status-pill {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 4px 11px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 600;
      margin-top: 6px;
    }

    .status-pill .pill-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: currentColor;
      animation: pillPulse 2s infinite;
    }

    @keyframes pillPulse {

      0%,
      100% {
        opacity: 1
      }

      50% {
        opacity: .35
      }
    }

    .pill-today {
      background: #EFF6FF;
      color: #1D4ED8;
      border: 1px solid #BFDBFE;
    }

    .pill-upcoming {
      background: #FFF7ED;
      color: #C2410C;
      border: 1px solid #FED7AA;
    }

    .pill-rescheduled {
      background: #fefce8;
      color: #92400e;
      border: 1px solid #FDE68A;
    }

    .pill-cancelled {
      background: #fbd8d8;
      color: #df0606;
      border: 1px solid #FECACA;
    }

    .pill-completed {
      background: #F0FDF4;
      color: #15803D;
      border: 1px solid #BBF7D0;
    }

    .pill-default {
      background: #F9FAFB;
      color: #374151;
      border: 1px solid #E5E7EB;
    }

    .icon-box {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    /* ── FILTER ACTIVE STATE ── */
    #openFilter.filter-active {
      background-color: #8B0000 !important;
      color: #fff !important;
      border-color: #8B0000 !important;
    }

    #openFilter.filter-active i {
      color: #fff !important;
    }

    /* ── COLUMN HEADER ROW ── */
    .card-col-header {
      display: grid;
      grid-template-columns: 30px 180px 100px 176px 50px 1fr 40px;
      align-items: center;
      padding: 10px 32px 10px 40px;
      border-bottom: 1px solid #F3F4F6;
      background: #FAFAFA;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: .06em;
      text-transform: uppercase;
      color: #757575;
      border-radius: 16px 16px 0 0;
    }

    /* ── AVATAR INITIALS ── */
    .avatar-initials {
      width: 56px;
      height: 56px;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      font-weight: 700;
      color: white;
      flex-shrink: 0;
      letter-spacing: -.5px;
    }

    /* ── SEARCH ── */
    #searchInput:focus {
      box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.08);
    }

    /* ── PAGE SUMMARY BAR ── */
    .page-summary {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
      margin-top: 4px;
    }

    .summary-tag {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      background: #f9f9f9;
      border: 1px solid #e5e7eb;
      border-radius: 9999px;
      padding: 3px 10px;
      font-size: 11px;
      font-weight: 500;
      color: #6b7280;
    }

    .summary-tag-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      flex-shrink: 0;
    }

    @media (max-width: 1024px) {
      .grid-cols-6 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
      }
    }

    @media (max-width: 640px) {
      .grid-cols-6 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }
  </style>
</head>

<body class="bg-[#F4F4F4] text-[#333333] font-normal">

  <!-- HEADER -->
  <header class="header">
    <div class="header-left">
      <img src="{{ asset('images/PUP.png') }}" class="header-logo" alt="PUP">
      <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="header-logo" alt="DMS">
      <span class="header-title">PUP TAGUIG DENTAL CLINIC</span>
    </div>
    <div class="header-right">
      @php $notifications = collect($notifications ?? []); $notifCount = $notifications->count(); @endphp
      <div id="notifDropdown">
        <button class="notif-btn" id="notifBtn">
          <i class="fa-regular fa-bell"></i>
          @if($notifCount > 0)<span class="notif-badge">{{ $notifCount }}</span>@endif
        </button>
        <div id="notifMenu">
          <div style="padding:.85rem 1rem .65rem; font-weight:700; color:var(--red); font-size:.82rem; border-bottom:1px solid #f5e8e8;">
            Notifications
          </div>
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
        <img src="https://i.pravatar.cc/40" class="header-avatar" alt="Avatar">
        <div>
          <div class="header-name">Dr. Nelson Angeles</div>
          <div class="header-role">Dentist</div>
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
        ['route'=>'dentist.dashboard', 'icon'=>'fa-chart-line', 'label'=>'Dashboard'],
        ['route'=>'dentist.patients', 'icon'=>'fa-users', 'label'=>'Patients'],
        ['route'=>'dentist.appointments', 'icon'=>'fa-calendar-check', 'label'=>'Appointments'],
        ['route'=>'dentist.documentrequests', 'icon'=>'fa-file-circle-check','label'=>'Document Requests'],
        ['route'=>'dentist.inventory', 'icon'=>'fa-box', 'label'=>'Inventory'],
        ['route'=>'dentist.report', 'icon'=>'fa-file', 'label'=>'Reports'],
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

  <!-- ================= MAIN ================= -->
  <main id="mainContent" class="pt-[100px] px-6 py-6 fade-up min-h-screen">
    <div class="max-w-7xl mt-4 mx-auto fade-in">
      <div class="px-2 md:px-6">

        @php
        use Carbon\Carbon;
        $today = Carbon::today()->toDateString();
        $appts = ($appointments instanceof \Illuminate\Pagination\AbstractPaginator)
            ? collect($appointments->items()) : collect($appointments);

        $todayCount       = $todayCount      ?? 0;
        $upcomingCount    = $upcomingCount   ?? 0;
        $rescheduledCount = $rescheduledCount ?? 0;
        $cancelledCount   = $cancelledCount  ?? 0;
        $completedCount   = $completedCount  ?? 0;
        $allCount         = $allCount        ?? 0;
        @endphp

        <!-- Title + Search / Filter -->
        <div class="flex flex-col md:flex-row md:items-start justify-between mb-8 gap-4">
          <div class="mb-2">
            <h2 class="text-2xl font-bold text-[#660000]">Patient List</h2>
            <p class="text-gray-500 mt-1 text-sm">Click to Access Patient Information</p>

            <!-- Page summary tags -->
            <div class="page-summary mt-3">
              <span class="summary-tag">
                <span class="summary-tag-dot bg-gray-400"></span>
                {{ $allCount }} total
              </span>
              @if($todayCount > 0)
              <span class="summary-tag">
                <span class="summary-tag-dot bg-blue-500"></span>
                {{ $todayCount }} today
              </span>
              @endif
              @if($upcomingCount > 0)
              <span class="summary-tag">
                <span class="summary-tag-dot bg-orange-500"></span>
                {{ $upcomingCount }} upcoming
              </span>
              @endif
              @if($completedCount > 0)
              <span class="summary-tag">
                <span class="summary-tag-dot bg-green-500"></span>
                {{ $completedCount }} completed
              </span>
              @endif
              @if($cancelledCount > 0)
              <span class="summary-tag">
                <span class="summary-tag-dot bg-red-500"></span>
                {{ $cancelledCount }} cancelled
              </span>
              @endif
            </div>
          </div>

          <div class="flex items-center gap-3 mt-1">
            <!-- Search Input -->
            <div class="relative flex items-center">
              <span class="absolute left-3.5 text-[#8B0000] pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
              </span>
              <input id="searchInput" type="text" placeholder="Search patients..."
                class="pl-10 pr-9 py-2.5 w-64 rounded-xl border border-gray-200 bg-white
                       text-sm text-gray-700 placeholder:text-gray-400
                       shadow-sm focus:outline-none focus:ring-2 focus:ring-[#8B0000]/10
                       focus:border-[#8B0000] transition-all duration-200" />
              <button id="searchClearBtn" type="button"
                class="absolute right-3 text-red-400 hover:text-red-600 transition-colors hidden"
                aria-label="Clear search">
                <i class="fa-solid fa-xmark text-sm"></i>
              </button>
            </div>

            <!-- Filter Button -->
            <button id="openFilter" type="button"
              class="relative flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200
                     bg-white text-sm font-semibold text-gray-600 shadow-sm
                     hover:border-[#8B0000] hover:text-[#8B0000] hover:bg-[#8B0000]/5
                     transition-all duration-200">
              <i class="fa-solid fa-sliders text-sm"></i>
              Filter
              <!-- Active indicator dot -->
              <span id="filterDot" class="hidden absolute -top-1 -right-1 w-2.5 h-2.5 bg-[#8B0000] rounded-full border-2 border-white"></span>
            </button>
          </div>
        </div>

        <div class="w-full max-w-6xl mx-auto">
          <div class="relative">

            <!-- TABS -->
            <div class="grid grid-cols-6 gap-3 relative z-20 mb-4">

              <button class="filter-btn tab-btn tab-scheduled" data-filter="today" type="button">
                <div class="tab-top-row">
                  <div class="tab-icon-wrap"><i class="fa-solid fa-calendar-days"></i></div>
                  <span class="tab-count">{{ $todayCount ?? 0 }}</span>
                </div>
                <span class="tab-label">Scheduled Today</span>
              </button>

              <button class="filter-btn tab-btn tab-upcoming" data-filter="upcoming" type="button">
                <div class="tab-top-row">
                  <div class="tab-icon-wrap"><i class="fa-solid fa-hourglass-half"></i></div>
                  <span class="tab-count">{{ $upcomingCount ?? 0 }}</span>
                </div>
                <span class="tab-label">Upcoming</span>
              </button>

              <button class="filter-btn tab-btn tab-rescheduled" data-filter="rescheduled" type="button">
                <div class="tab-top-row">
                  <div class="tab-icon-wrap"><i class="fa-solid fa-rotate"></i></div>
                  <span class="tab-count">{{ $rescheduledCount ?? 0 }}</span>
                </div>
                <span class="tab-label">Rescheduled</span>
              </button>

              <button class="filter-btn tab-btn tab-cancelled" data-filter="cancelled" type="button">
                <div class="tab-top-row">
                  <div class="tab-icon-wrap"><i class="fa-solid fa-xmark"></i></div>
                  <span class="tab-count">{{ $cancelledCount ?? 0 }}</span>
                </div>
                <span class="tab-label">Cancelled</span>
              </button>

              <button class="filter-btn tab-btn tab-completed" data-filter="completed" type="button">
                <div class="tab-top-row">
                  <div class="tab-icon-wrap"><i class="fa-solid fa-circle-check"></i></div>
                  <span class="tab-count">{{ $completedCount ?? 0 }}</span>
                </div>
                <span class="tab-label">Completed</span>
              </button>

              <button class="filter-btn tab-btn tab-all" data-filter="all" type="button">
                <div class="tab-top-row">
                  <div class="tab-icon-wrap"><i class="fa-solid fa-clipboard-list"></i></div>
                  <span class="tab-count">{{ $allCount ?? 0 }}</span>
                </div>
                <span class="tab-label">All Patients</span>
              </button>

            </div>
            <!-- /tabs -->

            <!-- PATIENT CARDS CONTAINER -->
            <div class="shadow-lg rounded-2xl bg-white overflow-hidden relative">

              <div class="card-col-header">
                <span></span>
                <span>Patient</span>
                <span></span>
                <span>Date &amp; Time</span>
                <span></span>
                <span>Service &amp; Status</span>
                <span></span>
              </div>

              <div id="patientContainer" class="space-y-3 px-6 pb-6 pt-4">

                @forelse($appointments as $appt)
                @php
                $status = strtolower($appt->status ?? '');
                $isCancelled = $status === 'cancelled';
                $isCompleted = $status === 'completed';
                $isRescheduled= $status === 'rescheduled';
                $isToday = ($appt->appointment_date === $today) && !$isCancelled && !$isCompleted;
                $isUpcoming = ($appt->appointment_date > $today) && in_array($status, ['upcoming','rescheduled','pending','confirmed'], true);

                $tabClass = $isCancelled ? 'cancelled' :
                ($isCompleted ? 'completed' :
                ($isRescheduled ? 'rescheduled' :
                ($isToday ? 'today' :
                ($isUpcoming ? 'upcoming' : 'all'))));

                $patientName = $appt->patient->name ?? 'Unknown Patient';
                $dateLabel = Carbon::parse($appt->appointment_date)->format('d M Y');
                $timeLabel = Carbon::parse($appt->appointment_time)->format('g:i A');
                $serviceLabel = ($appt->service_type === 'Others')
                ? ($appt->other_services ?: 'Others') : $appt->service_type;

                $nameParts = explode(' ', trim($patientName));
                $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                $avatarColors = ['#8B0000','#1565C0','#2E7D32','#E65100','#6A1B9A','#00695C','#AD1457'];
                $avatarColor = $avatarColors[crc32($patientName) % count($avatarColors)];

                $accentClass = $isCancelled ? 'accent-cancelled' :
                ($isCompleted ? 'accent-completed' :
                ($isRescheduled ? 'accent-rescheduled' :
                ($isToday ? 'accent-today' :
                ($isUpcoming ? 'accent-upcoming' : 'accent-default'))));

                $iconBg = $isCancelled ? 'bg-red-100' : ($isCompleted ? 'bg-green-100' : ($isRescheduled ? 'bg-yellow-100' : ($isToday ? 'bg-blue-100' : ($isUpcoming ? 'bg-orange-100' : 'bg-gray-100'))));
                $iconColor = $isCancelled ? 'text-red-600' : ($isCompleted ? 'text-green-600' : ($isRescheduled ? 'text-yellow-600' : ($isToday ? 'text-blue-600' : ($isUpcoming ? 'text-orange-600' : 'text-gray-500'))));

                $pillClass = $isCancelled ? 'pill-cancelled' : ($isCompleted ? 'pill-completed' : ($isRescheduled ? 'pill-rescheduled' : ($isToday ? 'pill-today' : ($isUpcoming ? 'pill-upcoming' : 'pill-default'))));
                $pillText = $isCancelled ? 'Cancelled' : ($isCompleted ? 'Completed' : ($isRescheduled ? 'Rescheduled' : ($isToday ? 'Appointment Today' : ($isUpcoming ? 'Upcoming · '.ucfirst($status) : ucfirst($status ?: 'Pending')))));
                @endphp

                <a href="{{ route('dentist.patient.profile', ['patient' => $appt->patient_id]) }}"
                  class="patient-card patient-item all {{ $tabClass }} block">

                  <div class="accent-bar {{ $accentClass }}"></div>
                  <div class="flex items-center gap-5 px-8 py-4 pl-10">

                    <!-- Avatar with initials fallback -->
                    <div class="relative flex-shrink-0">
                      <img src="https://i.pravatar.cc/80?u={{ $appt->patient_id }}"
                        class="w-14 h-14 rounded-2xl object-cover shadow-sm border-2 border-gray-100"
                        alt="{{ $patientName }}"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                      <div class="avatar-initials w-14 h-14 rounded-2xl hidden"
                        style="background: {{ $avatarColor }}; display: none;">
                        {{ $initials }}
                      </div>
                    </div>

                    <!-- Name + ID -->
                    <div class="w-44 flex-shrink-0">
                      <p class="font-semibold text-[#1a1a1a] text-sm leading-tight">{{ $patientName }}</p>
                      <span class="inline-block mt-1.5 px-2.5 py-0.5 rounded-full bg-gray-100
                                     text-gray-500 text-[11px] font-medium">
                        ID #{{ $appt->patient_id }}
                      </span>
                      <span class="patient-info hidden">N/A|N/A|N/A|{{ $appt->appointment_date }}|N/A</span>
                    </div>

                    <div class="w-px h-10 bg-gray-200 flex-shrink-0"></div>

                    <!-- Date & Time -->
                    <div class="flex items-start gap-3 w-44 flex-shrink-0">
                      <div class="icon-box bg-blue-50">
                        <i class="fa-regular fa-calendar text-blue-500 text-base"></i>
                      </div>
                      <div>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide mb-1 font-semibold">Date &amp; Time</p>
                        <p class="font-semibold text-[#1a1a1a] text-sm">{{ $dateLabel }}</p>
                        <p class="text-gray-500 text-xs mt-0.5">{{ $timeLabel }}</p>
                      </div>
                    </div>

                    <div class="w-px h-10 bg-gray-200 flex-shrink-0"></div>

                    <!-- Service + Status -->
                    <div class="flex items-start gap-3 flex-1 min-w-0">
                      <div class="icon-box {{ $iconBg }} flex-shrink-0">
                        <i class="fa-solid fa-tooth {{ $iconColor }} text-base"></i>
                      </div>
                      <div class="min-w-0">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide mb-1 font-semibold">Service</p>
                        <p class="font-semibold text-[#1a1a1a] text-sm truncate">{{ $serviceLabel }}</p>
                        <span class="status-pill {{ $pillClass }}">
                          <span class="pill-dot"></span>{{ $pillText }}
                        </span>
                      </div>
                    </div>

                    <!-- Arrow -->
                    <div class="card-arrow-btn ml-auto flex-shrink-0">
                      <i class="fa-solid fa-arrow-right text-xs"></i>
                    </div>

                  </div>
                </a>

                @empty
                <div class="py-20 text-center">
                  <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-tooth text-3xl text-gray-300"></i>
                  </div>
                  <p class="text-gray-500 font-semibold text-base">No appointments found</p>
                  <p class="text-gray-400 text-sm mt-1">There are no appointments in the system yet.</p>
                </div>
                @endforelse

              </div>

              <!-- Pagination -->
              <div id="pagination" class="flex items-center justify-center gap-4 py-6 text-sm text-gray-600 border-t border-gray-100">
                <button id="prevPage" class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-gray-300 cursor-not-allowed" disabled>
                  <span>‹</span> Previous
                </button>
                <div id="pageNumbers" class="flex items-center gap-2"></div>
                <button id="nextPage" class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-[#8B0000] hover:bg-[#8B0000]/5 transition">
                  Next <span>›</span>
                </button>
              </div>

            </div>
            <!-- /patient container -->

          </div>
        </div>

      </div>
    </div>
    <div class="pb-24"></div>
  </main>

  <!-- FILTER MODAL -->
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

  <script>
    // =========================
    // THEME TOGGLE 
    // =========================
    const html = document.documentElement;
    const themeToggleContainer = document.getElementById("themeToggle");
    const themeIndicator = themeToggleContainer.querySelector(".theme-indicator");
    const themeOptions = themeToggleContainer.querySelectorAll(".theme-option");

    function applyTheme(theme) {
      html.setAttribute("data-theme", theme);
      localStorage.setItem("theme", theme);

      themeOptions.forEach(option => {
        if (option.getAttribute("data-theme") === theme) {
          option.classList.add("active");
        } else {
          option.classList.remove("active");
        }
      });

      if (theme === "dark") {
        themeIndicator.classList.add("dark-mode");
      } else {
        themeIndicator.classList.remove("dark-mode");
      }
    }

    applyTheme(localStorage.getItem("theme") || "light");

    themeOptions.forEach(option => {
      option.addEventListener("click", () => {
        const theme = option.getAttribute("data-theme");
        applyTheme(theme);
      });
    });

    let sidebarOpen = true;

    function applyLayout(sidebarWidth) {
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('mainContent');
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
        applyLayout('220px');
        sidebar.classList.remove('collapsed');
        sidebar.classList.add('expanded');
        texts.forEach(t => {
          t.classList.remove('opacity-0', 'w-0');
          t.classList.add('opacity-100');
        });
        toggleWrapper.classList.remove('justify-center');
        toggleWrapper.classList.add('justify-end');
        icon.classList.replace('fa-bars', 'fa-xmark');
      } else {
        applyLayout('72px');
        sidebar.classList.remove('expanded');
        sidebar.classList.add('collapsed');
        texts.forEach(t => {
          t.classList.add('opacity-0', 'w-0');
          t.classList.remove('opacity-100');
        });
        toggleWrapper.classList.remove('justify-end');
        toggleWrapper.classList.add('justify-center');
        icon.classList.replace('fa-xmark', 'fa-bars');
      }
      applyTheme(localStorage.getItem("theme") || "light");
    }

    document.addEventListener('DOMContentLoaded', () => {
      sidebarOpen = true;
      applyLayout('220px');
    });

    /* ── NOTIF TOGGLE ── */
    document.getElementById("notifBtn").addEventListener("click", e => {
      e.stopPropagation();
      document.getElementById("notifMenu").classList.toggle("open");
    });
    document.addEventListener("click", () => document.getElementById("notifMenu").classList.remove("open"));

    /* TAB ACTIVE STATE */
    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('tab-active'));
        btn.classList.add('tab-active');
      });
    });

    document.addEventListener("DOMContentLoaded", () => {
      const patientContainer = document.getElementById("patientContainer");
      if (!patientContainer) return;

      const allPatients = Array.from(patientContainer.querySelectorAll(".patient-item"));
      const filterModal = document.getElementById("filterModal");
      const filterPill = document.getElementById("openFilter");
      const filterDot = document.getElementById("filterDot");
      const clearFiltersModal = document.getElementById("clearFiltersModal");
      const applyFiltersBtn = document.getElementById("applyFilters");
      const searchInput = document.getElementById("searchInput");
      const filterButtons = document.querySelectorAll(".filter-btn");

      const countEls = {
        today: document.querySelector('.filter-btn[data-filter="today"] .tab-count'),
        upcoming: document.querySelector('.filter-btn[data-filter="upcoming"] .tab-count'),
        rescheduled: document.querySelector('.filter-btn[data-filter="rescheduled"] .tab-count'),
        cancelled: document.querySelector('.filter-btn[data-filter="cancelled"] .tab-count'),
        completed: document.querySelector('.filter-btn[data-filter="completed"] .tab-count'),
        all: document.querySelector('.filter-btn[data-filter="all"] .tab-count'),
      };

      let activeTab = "today",
        searchKeyword = "";
      let selectedProgram = null,
        selectedYearLevel = null,
        selectedSection = null,
        selectedDepartment = null;
      let nameSort = null,
        dateSort = null;
      let selectedMonth = null,
        selectedCalendarYear = null;
      let activeFromDate = "",
        activeToDate = "";

      const deptRadios = [...document.querySelectorAll('input[name="department"]')];
      const courseRadios = [...document.querySelectorAll('input[name="course"]')];
      const yearRadios = [...document.querySelectorAll('input[name="year"]')];
      const sectionRadios = [...document.querySelectorAll('input[name="section"]')];
      const otherRadios = [...courseRadios, ...yearRadios, ...sectionRadios];

      const anyChecked = list => list.some(i => i.checked);
      const setDisabled = (list, d) => list.forEach(i => {
        i.disabled = d;
        i.closest("label")?.classList.toggle("opacity-50", d);
        i.closest("label")?.classList.toggle("cursor-not-allowed", d);
      });
      const clearChecked = list => list.forEach(i => i.checked = false);
      const ilike = (val, t) => (val || "").toLowerCase().includes((t || "").toLowerCase());

      function syncMutualExclusion() {
        if (anyChecked(deptRadios)) {
          clearChecked(otherRadios);
          setDisabled(otherRadios, true);
          setDisabled(deptRadios, false);
          return;
        }
        if (anyChecked(otherRadios)) {
          clearChecked(deptRadios);
          setDisabled(deptRadios, true);
          setDisabled(otherRadios, false);
          return;
        }
        setDisabled(deptRadios, false);
        setDisabled(otherRadios, false);
      }
      [...deptRadios, ...otherRadios].forEach(r => r.addEventListener("change", syncMutualExclusion));

      const getInfo = p => {
        const parts = (p.querySelector(".patient-info")?.textContent?.trim() || "").split("|").map(s => s.trim());
        return {
          program: parts[0] || "",
          year: parts[1] || "",
          section: parts[2] || "",
          dateStr: parts[3] || "",
          department: parts[4] || p.dataset.department || ""
        };
      };
      const getName = p => (p.querySelector(".font-semibold")?.textContent || "").trim();
      const getService = p => (p.querySelector(".truncate")?.textContent || "").trim();
      const getIdText = p => (p.querySelector(".text-gray-500.text-\\[11px\\]")?.textContent || "").trim();
      const getType = p => p.dataset.type || "";

      const matchesSearch = (p, kw) => {
        if (!kw) return true;
        const info = getInfo(p);
        const haystack = [getName(p), getService(p), getIdText(p), getType(p), info.program, info.department, info.dateStr].join(" ").toLowerCase();
        return haystack.includes(kw);
      };

      function updateFilterButtonState() {
        const has = !!searchKeyword || !!selectedProgram || !!selectedYearLevel || !!selectedSection || !!selectedDepartment || !!nameSort || !!dateSort || !!activeFromDate || !!activeToDate;
        filterPill?.classList.toggle("filter-active", has);
        filterDot?.classList.toggle("hidden", !has);
      }

      filterPill?.addEventListener("click", e => {
        e.preventDefault();
        filterModal?.classList.remove("hidden");
        syncMutualExclusion();
      });
      filterModal?.addEventListener("click", e => {
        if (e.target === filterModal) {
          filterModal.classList.add("hidden");
          updateFilterButtonState();
        }
      });
      document.addEventListener("keydown", e => {
        if (e.key === "Escape") {
          filterModal?.classList.add("hidden");
          updateFilterButtonState();
        }
      });

      const pagination = document.getElementById("pagination");
      const pageNumbers = document.getElementById("pageNumbers");
      const prevPageBtn = document.getElementById("prevPage");
      const nextPageBtn = document.getElementById("nextPage");
      const PER_PAGE = 5;
      let currentPage = 1,
        currentItems = [];

      function renderPagination(items) {
        currentItems = items;
        const total = Math.ceil(items.length / PER_PAGE);
        if (pageNumbers) pageNumbers.innerHTML = "";
        if (total <= 1) {
          pagination?.classList.add("hidden");
          return;
        }
        pagination?.classList.remove("hidden");
        for (let i = 1; i <= total; i++) {
          const btn = document.createElement("button");
          btn.textContent = i;
          btn.className = i === currentPage ?
            "px-3 py-1.5 rounded-lg bg-[#8B0000]/10 text-[#8B0000] font-semibold text-sm" :
            "px-3 py-1.5 rounded-lg hover:bg-gray-100 text-gray-600 text-sm";
          btn.addEventListener("click", () => {
            currentPage = i;
            updatePage();
          });
          pageNumbers?.appendChild(btn);
        }
        if (prevPageBtn) {
          prevPageBtn.disabled = currentPage === 1;
          prevPageBtn.classList.toggle("cursor-not-allowed", currentPage === 1);
          prevPageBtn.classList.toggle("text-gray-300", currentPage === 1);
          prevPageBtn.classList.toggle("text-[#8B0000]", currentPage !== 1);
        }
        if (nextPageBtn) {
          nextPageBtn.disabled = currentPage === total;
          nextPageBtn.classList.toggle("cursor-not-allowed", currentPage === total);
          nextPageBtn.classList.toggle("text-gray-300", currentPage === total);
          nextPageBtn.classList.toggle("text-[#8B0000]", currentPage !== total);
        }
      }

      function updatePage() {
        const s = (currentPage - 1) * PER_PAGE,
          e = s + PER_PAGE;
        patientContainer.innerHTML = "";

        if (currentItems.length === 0) {
          const isSearching = searchKeyword.trim().length > 0;
          const hasFilters = !!selectedProgram || !!selectedYearLevel || !!selectedSection || !!selectedDepartment || !!activeFromDate || !!activeToDate;
          const emptyMessages = {
            today: {
              icon: "fa-calendar-days",
              title: "No appointments today",
              sub: "Enjoy the quiet — nothing scheduled for today."
            },
            upcoming: {
              icon: "fa-hourglass-half",
              title: "No upcoming appointments",
              sub: "New bookings will show up here once confirmed."
            },
            rescheduled: {
              icon: "fa-rotate",
              title: "No rescheduled appointments",
              sub: "Any rescheduled visits will appear here."
            },
            cancelled: {
              icon: "fa-xmark-circle",
              title: "No cancelled appointments",
              sub: "That's great! Nothing has been cancelled."
            },
            completed: {
              icon: "fa-circle-check",
              title: "No completed appointments yet",
              sub: "Completed visits will be recorded here."
            },
            all: {
              icon: "fa-clipboard-list",
              title: "No appointments found",
              sub: "There are no appointments in the system yet."
            },
          };

          let icon, title, sub, extraHtml = "";
          if (isSearching) {
            icon = "fa-magnifying-glass";
            title = `No results for "${searchKeyword}"`;
            sub = "Try a different name, ID, or service type.";
            extraHtml = `<button onclick="document.getElementById('searchInput').value=''; document.getElementById('searchInput').dispatchEvent(new Event('input'));"
              class="mt-3 px-4 py-2 rounded-xl border border-dashed border-gray-300 text-sm text-gray-400
                     hover:border-[#8B0000] hover:text-[#8B0000] hover:bg-[#8B0000]/5 transition-all duration-200">
              <i class="fa-solid fa-xmark mr-1.5 text-xs"></i> Clear search</button>`;
          } else if (hasFilters) {
            icon = "fa-sliders";
            title = "No matches for your filters";
            sub = "Try removing or adjusting your filter criteria.";
            extraHtml = `<button id="clearFiltersInline"
              class="mt-3 px-4 py-2 rounded-xl border border-dashed border-gray-300 text-sm text-gray-400
                     hover:border-[#8B0000] hover:text-[#8B0000] hover:bg-[#8B0000]/5 transition-all duration-200">
              <i class="fa-solid fa-xmark mr-1.5 text-xs"></i> Clear filters</button>`;
          } else {
            const msg = emptyMessages[activeTab] || emptyMessages.all;
            icon = msg.icon;
            title = msg.title;
            sub = msg.sub;
          }

          patientContainer.innerHTML = `
            <div class="flex flex-col items-center justify-center py-20 text-center gap-2">
              <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-3">
                <i class="fa-solid ${icon} text-3xl text-gray-300"></i>
              </div>
              <p class="text-base font-semibold text-gray-500">${title}</p>
              <p class="text-sm text-gray-400 max-w-xs">${sub}</p>
              ${extraHtml}
            </div>`;

          document.getElementById("clearFiltersInline")?.addEventListener("click", () => {
            selectedDepartment = selectedProgram = selectedYearLevel = selectedSection = nameSort = dateSort = null;
            activeFromDate = activeToDate = "";
            filterModal?.querySelectorAll("input[type='radio']").forEach(i => {
              i.checked = false;
              i.disabled = false;
              i.closest("label")?.classList.remove("opacity-50", "cursor-not-allowed");
            });
            const f = document.getElementById("fromDate");
            const t = document.getElementById("toDate");
            if (f) f.value = "";
            if (t) t.value = "";
            syncMutualExclusion();
            applyFilters();
            updateFilterButtonState();
          });

          if (pagination) pagination.classList.add("hidden");
          return;
        }

        currentItems.slice(s, e).forEach(p => patientContainer.appendChild(p));
        renderPagination(currentItems);
      }

      prevPageBtn?.addEventListener("click", () => {
        if (currentPage > 1) {
          currentPage--;
          updatePage();
        }
      });
      nextPageBtn?.addEventListener("click", () => {
        if (currentPage < Math.ceil(currentItems.length / PER_PAGE)) {
          currentPage++;
          updatePage();
        }
      });

      function applyFilters() {
        let data = [...allPatients];
        if (activeTab !== "all") data = data.filter(p => p.classList.contains(activeTab));
        if (searchKeyword) data = data.filter(p => matchesSearch(p, searchKeyword));
        if (selectedProgram) data = data.filter(p => ilike(getInfo(p).program, selectedProgram));
        if (selectedYearLevel || selectedSection) data = data.filter(p => {
          const i = getInfo(p);
          if (selectedYearLevel && !ilike(i.year, selectedYearLevel)) return false;
          if (selectedSection && String(i.section).trim() !== String(selectedSection).trim()) return false;
          return true;
        });
        if (selectedDepartment) data = data.filter(p => ilike(getInfo(p).department, selectedDepartment));
        if (activeFromDate || activeToDate) data = data.filter(p => {
          const d = new Date(getInfo(p).dateStr);
          if (isNaN(d)) return false;
          if (activeFromDate && d < new Date(activeFromDate)) return false;
          if (activeToDate && d > new Date(activeToDate)) return false;
          return true;
        });
        if (nameSort === "az") data.sort((a, b) => getName(a).localeCompare(getName(b)));
        if (nameSort === "za") data.sort((a, b) => getName(b).localeCompare(getName(a)));
        if (dateSort === "asc") data.sort((a, b) => new Date(getInfo(a).dateStr) - new Date(getInfo(b).dateStr));
        if (dateSort === "desc") data.sort((a, b) => new Date(getInfo(b).dateStr) - new Date(getInfo(a).dateStr));
        currentPage = 1;
        renderPagination(data);
        updatePage();
        updateCounts();
        updateFilterButtonState();
      }

      function computeCount(tab) {
        let data = [...allPatients];
        if (tab !== "all") data = data.filter(p => p.classList.contains(tab));
        if (searchKeyword) data = data.filter(p => matchesSearch(p, searchKeyword));
        if (selectedProgram) data = data.filter(p => ilike(getInfo(p).program, selectedProgram));
        if (selectedYearLevel || selectedSection) data = data.filter(p => {
          const i = getInfo(p);
          if (selectedYearLevel && !ilike(i.year, selectedYearLevel)) return false;
          if (selectedSection && String(i.section).trim() !== String(selectedSection).trim()) return false;
          return true;
        });
        if (selectedDepartment) data = data.filter(p => ilike(getInfo(p).department, selectedDepartment));
        if (activeFromDate || activeToDate) data = data.filter(p => {
          const d = new Date(getInfo(p).dateStr);
          if (isNaN(d)) return false;
          if (activeFromDate && d < new Date(activeFromDate)) return false;
          if (activeToDate && d > new Date(activeToDate)) return false;
          return true;
        });
        return data.length;
      }

      function updateCounts() {
        Object.keys(countEls).forEach(tab => {
          if (countEls[tab]) countEls[tab].textContent = computeCount(tab);
        });
      }

      filterButtons.forEach(btn => {
        btn.addEventListener("click", () => {
          activeTab = btn.dataset.filter;
          applyFilters();
        });
      });

      searchInput?.addEventListener("input", () => {
        searchKeyword = searchInput.value.trim().toLowerCase();
        applyFilters();
      });

      const searchClearBtn = document.getElementById("searchClearBtn");
      searchInput?.addEventListener("input", () => {
        if (searchClearBtn) searchClearBtn.classList.toggle("hidden", searchInput.value.length === 0);
      });
      searchClearBtn?.addEventListener("click", () => {
        searchInput.value = "";
        searchInput.dispatchEvent(new Event("input"));
        searchClearBtn.classList.add("hidden");
        searchInput.focus();
      });

      applyFiltersBtn?.addEventListener("click", () => {
        selectedDepartment = filterModal?.querySelector('input[name="department"]:checked')?.value || null;
        selectedProgram = filterModal?.querySelector('input[name="course"]:checked')?.value || null;
        selectedYearLevel = filterModal?.querySelector('input[name="year"]:checked')?.value || null;
        selectedSection = filterModal?.querySelector('input[name="section"]:checked')?.value || null;
        const sv = filterModal?.querySelector('input[name="sort"]:checked')?.value || null;
        nameSort = sv === "A-Z" || sv === "az" ? "az" : sv === "Z-A" || sv === "za" ? "za" : null;
        const dv = filterModal?.querySelector('input[name="dateOrder"]:checked')?.value || null;
        dateSort = dv === "Ascending" || dv === "asc" ? "asc" : dv === "Descending" || dv === "desc" ? "desc" : null;
        activeFromDate = document.getElementById("fromDate")?.value || "";
        activeToDate = document.getElementById("toDate")?.value || "";
        filterModal?.classList.add("hidden");
        syncMutualExclusion();
        applyFilters();
        updateFilterButtonState();
      });

      clearFiltersModal?.addEventListener("click", () => {
        filterModal?.querySelectorAll("input[type='radio']").forEach(i => {
          i.checked = false;
          i.disabled = false;
          i.closest("label")?.classList.remove("opacity-50", "cursor-not-allowed");
        });
        const f = document.getElementById("fromDate");
        const t = document.getElementById("toDate");
        if (f) f.value = "";
        if (t) t.value = "";
        syncMutualExclusion();
        // Modal stays open — user must click Save to apply
      });

      syncMutualExclusion();

      // Activate "today" tab visually on page load
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('tab-active'));
      document.querySelector('.filter-btn[data-filter="today"]')?.classList.add('tab-active');

      applyFilters();
    });
  </script>

</body>

</html>