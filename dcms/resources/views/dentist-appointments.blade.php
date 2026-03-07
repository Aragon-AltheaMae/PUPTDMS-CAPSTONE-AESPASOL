<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Appointments | PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">

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

    #sidebar.collapsed .sidebar-tooltip {
      display: block;
    }

    #sidebar.expanded .sidebar-tooltip {
      display: none;
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

    /* ── APPOINTMENT CARDS ── */
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(8px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .appt-card {
      background: #ffffff;
      border: 1px solid #EDE8E3;
      border-radius: 14px;
      position: relative;
      overflow: hidden;
      transition: box-shadow .2s, border-color .2s, transform .15s;
      animation: slideIn .3s ease both;
    }

    .appt-card:nth-child(even) {
      background: #FDFAF8;
    }

    .appt-card:hover {
      border-color: rgba(139, 0, 0, .25);
      box-shadow: 0 6px 24px rgba(139, 0, 0, .09);
      transform: translateX(3px);
    }

    .appt-card::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
      background: #8B0000;
      border-radius: 14px 0 0 14px;
      opacity: 0;
      transition: opacity .2s;
    }

    .appt-card:hover::before {
      opacity: 1;
    }

    /* Today row highlight */
    .appt-card.is-today {
      background: #f0fdf4 !important;
      border-color: #86efac !important;
      box-shadow: 0 2px 12px rgba(34, 197, 94, .1);
    }

    .appt-card.is-today::before {
      background: #16a34a;
      opacity: 1;
    }

    /* ── SERVICE BADGES ── */
    .service-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 12px;
      font-weight: 500;
      padding: 3px 10px;
      border-radius: 6px;
      width: fit-content;
    }

    .service-badge-default {
      background: #f9f0f0;
      color: #8B0000;
    }

    .service-badge-surgery {
      background: #fff0f0;
      color: #C41E3A;
    }

    .service-badge-checkup {
      background: #ebf5ee;
      color: #2D7A5E;
    }

    .service-badge-whitening {
      background: #fff3e0;
      color: #B86C00;
    }

    .service-badge-extraction {
      background: #fff0e8;
      color: #B85000;
    }

    /* ── STATUS PILLS ── */
    .status-pill {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 11px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 20px;
    }

    .status-confirmed {
      background: #dcfce7;
      color: #15803d;
      border: 1px solid #86efac;
    }

    .status-pending {
      background: #fef3c7;
      color: #92400e;
      border: 1px solid #fcd34d;
    }

    .status-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: currentColor;
      flex-shrink: 0;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {

      0%,
      100% {
        opacity: 1
      }

      50% {
        opacity: .4
      }
    }

    .time-chip {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      background: #F5F0EB;
      border: 1px solid #E8E0D8;
      border-radius: 7px;
      padding: 5px 10px;
      font-size: 13px;
      font-weight: 500;
      color: #6B5E52;
    }

    /* ── TIMELINE ── */
    .timeline-dot {
      width: 18px;
      height: 18px;
      background: #8b0000;
      border-radius: 50%;
      border: 3px solid white;
      box-shadow: 0 0 0 3px rgba(139, 0, 0, .2), 0 2px 8px rgba(139, 0, 0, .3);
      flex-shrink: 0;
    }

    .timeline-dot-past {
      width: 18px;
      height: 18px;
      background: #9ca3af;
      border-radius: 50%;
      border: 3px solid white;
      box-shadow: 0 0 0 3px rgba(156, 163, 175, .2);
      flex-shrink: 0;
    }

    /* ── TAB TOGGLE ── */
    .tab-toggle-wrap {
      background: #5a0000;
      border-radius: 9999px;
      padding: 5px;
      display: flex;
      gap: 4px;
      box-shadow: 0 4px 16px rgba(139, 0, 0, .35);
    }

    .tab-btn-toggle {
      padding: 8px 20px;
      border-radius: 9999px;
      font-size: 13px;
      font-weight: 600;
      transition: all .25s ease;
      display: flex;
      align-items: center;
      gap: 8px;
      color: rgba(255, 255, 255, .6);
    }

    .tab-btn-toggle.active {
      background: white;
      color: #8b0000;
      box-shadow: 0 2px 10px rgba(0, 0, 0, .15);
    }

    .tab-count-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 20px;
      height: 20px;
      padding: 0 6px;
      border-radius: 9999px;
      font-size: 11px;
      font-weight: 700;
    }

    .tab-btn-toggle.active .tab-count-badge {
      background: #8b0000;
      color: white;
    }

    .tab-btn-toggle:not(.active) .tab-count-badge {
      background: rgba(255, 255, 255, .2);
      color: rgba(255, 255, 255, .8);
    }

    /* ── ACTION BUTTONS ── */
    .action-row {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .action-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
      height: 30px;
      padding: 0 12px;
      border-radius: 8px;
      font-size: 11px;
      font-weight: 600;
      transition: all .15s ease;
      white-space: nowrap;
    }

    .action-btn-start {
      background: #15803d;
      color: white;
      border: 1.5px solid #15803d;
    }

    .action-btn-start:hover {
      background: #166534;
      box-shadow: 0 2px 8px rgba(21, 128, 61, .3);
    }

    .action-btn-start:disabled {
      background: #d1d5db;
      border-color: #d1d5db;
      color: #9ca3af;
      cursor: not-allowed;
      box-shadow: none;
    }

    .action-btn-reschedule {
      background: #fffbeb;
      color: #92400e;
      border: 1.5px solid #fcd34d;
    }

    .action-btn-reschedule:hover {
      background: #fef3c7;
      box-shadow: 0 2px 8px rgba(251, 191, 36, .25);
    }

    .action-btn-cancel {
      background: #fff1f2;
      color: #9f1239;
      border: 1.5px solid #fecdd3;
    }

    .action-btn-cancel:hover {
      background: #ffe4e6;
      box-shadow: 0 2px 8px rgba(159, 18, 57, .15);
    }

    /* ── SUMMARY BAR ── */
    .summary-bar {
      background: linear-gradient(135deg, #7f0000 0%, #a00000 100%);
      border-bottom: 1px solid rgba(255, 255, 255, .08);
    }

    .summary-chip {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(255, 255, 255, .12);
      border: 1px solid rgba(255, 255, 255, .18);
      border-radius: 9999px;
      padding: 4px 12px;
      font-size: 12px;
      font-weight: 500;
      color: white;
    }

    .summary-chip-highlight {
      background: rgba(255, 255, 255, .22);
      border-color: rgba(255, 255, 255, .35);
      font-weight: 700;
    }

    /* ══════════════════════════════════════
       CANCEL MODAL — ENHANCED
    ══════════════════════════════════════ */

    /* Animated backdrop */
    #cancelAppointmentModal {
      animation: none;
    }

    #cancelAppointmentModal.showing {
      animation: backdropIn .2s ease forwards;
    }

    @keyframes backdropIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    /* Modal panel slide-up entrance */
    .cancel-modal-panel {
      animation: modalSlideUp .3s cubic-bezier(.34, 1.56, .64, 1) forwards;
    }

    @keyframes modalSlideUp {
      from {
        opacity: 0;
        transform: translateY(24px) scale(.97);
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    /* Warning icon pulse ring */
    .cancel-icon-ring {
      position: relative;
      width: 72px;
      height: 72px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .cancel-icon-ring::before,
    .cancel-icon-ring::after {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: 50%;
      border: 2px solid rgba(220, 38, 38, .35);
      animation: ringPulse 2s ease-out infinite;
    }

    .cancel-icon-ring::after {
      animation-delay: .7s;
    }

    @keyframes ringPulse {
      0% {
        transform: scale(.85);
        opacity: .8;
      }

      100% {
        transform: scale(1.5);
        opacity: 0;
      }
    }

    .cancel-icon-core {
      width: 56px;
      height: 56px;
      border-radius: 50%;
      background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
      border: 2px solid #fca5a5;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 16px rgba(220, 38, 38, .2);
      z-index: 1;
    }

    /* Reason radio chips */
    .reason-chip input[type="radio"] {
      display: none;
    }

    .reason-chip label {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      border-radius: 9999px;
      border: 1.5px solid #e5e7eb;
      font-size: 12px;
      font-weight: 500;
      color: #6b7280;
      cursor: pointer;
      transition: all .15s ease;
      background: white;
      user-select: none;
    }

    .reason-chip label:hover {
      border-color: #fca5a5;
      color: #9f1239;
      background: #fff1f2;
    }

    .reason-chip input[type="radio"]:checked+label {
      border-color: #dc2626;
      background: #fef2f2;
      color: #dc2626;
      font-weight: 600;
      box-shadow: 0 2px 6px rgba(220, 38, 38, .15);
    }

    /* Confirm button shake on click */
    @keyframes btnShake {

      0%,
      100% {
        transform: translateX(0);
      }

      20% {
        transform: translateX(-4px);
      }

      40% {
        transform: translateX(4px);
      }

      60% {
        transform: translateX(-3px);
      }

      80% {
        transform: translateX(3px);
      }
    }

    .btn-shake {
      animation: btnShake .35s ease;
    }

    /* ══════════════════════════════════════
       RESCHEDULE MODAL
    ══════════════════════════════════════ */
    .reschedule-modal-panel {
      animation: modalSlideUp .3s cubic-bezier(.34, 1.56, .64, 1) forwards;
    }

    /* Reason error shake */
    @keyframes errorShake {

      0%,
      100% {
        transform: translateX(0);
      }

      20% {
        transform: translateX(-5px);
      }

      40% {
        transform: translateX(5px);
      }

      60% {
        transform: translateX(-3px);
      }

      80% {
        transform: translateX(3px);
      }
    }

    .chips-error-shake {
      animation: errorShake .35s ease;
    }

    /* Reason chips invalid state */
    #cancelReasonChips.invalid .reason-chip label {
      border-color: #fca5a5;
      background: #fff5f5;
    }

    #toastContainer {
      position: fixed;
      bottom: 28px;
      right: 28px;
      z-index: 99999;
      display: flex;
      flex-direction: column;
      gap: 10px;
      pointer-events: none;
    }

    .toast-item {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      background: #1a1a1a;
      border: 1px solid #2d2d2d;
      border-radius: 14px;
      padding: 14px 16px;
      min-width: 320px;
      max-width: 380px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, .35), 0 2px 8px rgba(0, 0, 0, .2);
      pointer-events: auto;
      position: relative;
      overflow: hidden;
      animation: toastSlideIn .4s cubic-bezier(.34, 1.56, .64, 1) forwards;
    }

    .toast-item.toast-exit {
      animation: toastSlideOut .35s ease forwards;
    }

    @keyframes toastSlideIn {
      from {
        opacity: 0;
        transform: translateX(60px) scale(.95);
      }

      to {
        opacity: 1;
        transform: translateX(0) scale(1);
      }
    }

    @keyframes toastSlideOut {
      from {
        opacity: 1;
        transform: translateX(0) scale(1);
        max-height: 100px;
        margin-bottom: 0;
      }

      to {
        opacity: 0;
        transform: translateX(60px) scale(.95);
        max-height: 0;
        margin-bottom: -10px;
      }
    }

    /* Progress bar at bottom */
    .toast-progress {
      position: absolute;
      bottom: 0;
      left: 0;
      height: 3px;
      border-radius: 0 0 14px 14px;
      background: linear-gradient(90deg, #dc2626, #f87171);
      animation: toastProgress linear forwards;
    }

    @keyframes toastProgress {
      from {
        width: 100%;
      }

      to {
        width: 0%;
      }
    }

    .toast-icon-wrap {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .toast-icon-cancel {
      background: rgba(220, 38, 38, .15);
      border: 1px solid rgba(220, 38, 38, .25);
    }

    .toast-body {
      flex: 1;
      min-width: 0;
    }

    .toast-title {
      font-size: 13px;
      font-weight: 700;
      color: #f3f4f6;
      line-height: 1.3;
      margin-bottom: 2px;
    }

    .toast-message {
      font-size: 12px;
      color: #9ca3af;
      line-height: 1.4;
    }

    .toast-close {
      width: 22px;
      height: 22px;
      border-radius: 6px;
      background: rgba(255, 255, 255, .06);
      border: none;
      cursor: pointer;
      color: #6b7280;
      font-size: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      transition: background .15s, color .15s;
    }

    .toast-close:hover {
      background: rgba(255, 255, 255, .12);
      color: #e5e7eb;
    }
  </style>
</head>

<body class="bg-[#F4F4F4] text-[#333333] font-normal min-h-screen flex flex-col">

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

  @php
  $upcomingAppointments = $upcomingAppointments ?? collect();
  $pastAppointments = $pastAppointments ?? collect();
  $today = $today ?? \Carbon\Carbon::today()->toDateString();

  $todayAppts = $upcomingAppointments->filter(fn($a) => ($a->appointment_date ?? null) === $today);
  $todayCount = $todayAppts->count();
  $nextAppt = $upcomingAppointments->sortBy('appointment_date')->first();
  $nextName = $nextAppt ? (optional($nextAppt->patient)->name ?? 'Unknown') : null;
  $nextTime = $nextAppt ? \Carbon\Carbon::parse($nextAppt->appointment_time)->format('g:i A') : null;
  $nextDate = $nextAppt ? \Carbon\Carbon::parse($nextAppt->appointment_date)->format('M j') : null;

  $upcomingGrouped = $upcomingAppointments->groupBy(fn($a) => \Carbon\Carbon::parse($a->appointment_date)->format('F'));
  $pastGrouped = $pastAppointments->groupBy(fn($a) => \Carbon\Carbon::parse($a->appointment_date)->format('F'));
  $upcomingTotal = $upcomingAppointments->count();
  $pastTotal = $pastAppointments->count();
  @endphp

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

      <div class="summary-bar rounded-2xl px-6 py-3 flex items-center gap-3 flex-wrap mb-6">
        <i class="fa-solid fa-circle-info text-white/60 text-sm ml-1"></i>
        <span class="text-white/70 text-xs font-medium">Today's snapshot:</span>

        @if($todayCount > 0)
        <span class="summary-chip summary-chip-highlight">
          <i class="fa-solid fa-calendar-check text-xs"></i>
          {{ $todayCount }} appointment{{ $todayCount > 1 ? 's' : '' }} today
        </span>
        @else
        <span class="summary-chip">
          <i class="fa-regular fa-calendar text-xs"></i>
          No appointments today
        </span>
        @endif

        @if($nextAppt)
        <span class="summary-chip">
          <i class="fa-solid fa-clock text-xs"></i>
          Next: <strong>{{ $nextName }}</strong> — {{ $nextDate }} at {{ $nextTime }}
        </span>
        @endif

        <span class="summary-chip ml-auto">
          <i class="fa-solid fa-list text-xs"></i>
          {{ $upcomingTotal }} upcoming · {{ $pastTotal }} past
        </span>
      </div>

      <div class="flex items-end justify-between mt-6 mb-10 px-1">
        <div>
          <h1 class="text-2xl font-bold text-[#660000]">Appointments</h1>
          <div class="flex items-center gap-2 mt-2">
            <i class="fa-solid fa-sun text-yellow-400 text-sm"></i>
            <p id="currentDate" class="text-sm text-[#757575]"></p>
          </div>
        </div>
        <div class="tab-toggle-wrap">
          <button id="btnUpcoming" class="tab-btn-toggle active">
            <i class="fa-solid fa-calendar-clock text-xs"></i>
            Upcoming
            <span class="tab-count-badge">{{ $upcomingTotal }}</span>
          </button>
          <button id="btnPast" class="tab-btn-toggle">
            <i class="fa-solid fa-clock-rotate-left text-xs"></i>
            Past
            <span class="tab-count-badge">{{ $pastTotal }}</span>
          </button>
        </div>
      </div>

      <!-- UPCOMING SECTION -->
      <section id="upcomingSection" class="pb-16">
        @forelse($upcomingGrouped as $month => $items)
        <div class="mb-14">
          <div class="flex items-center gap-4 mb-5">
            <div class="timeline-dot"></div>
            <h2 class="text-xl font-bold text-[#8b0000]">{{ $month }}</h2>
            <span class="bg-[#f9f0f0] text-[#8b0000] text-xs font-semibold px-3 py-1 rounded-full border border-[#8b0000]/15">
              {{ $items->count() }} {{ Str::plural('appointment', $items->count()) }}
            </span>
          </div>
          <div class="relative pl-10">
            <div class="absolute left-[8px] top-0 bottom-0 w-[2px] bg-gradient-to-b from-[#8b0000]/30 to-[#8b0000]/05 rounded-full"></div>
            <div class="grid grid-cols-[180px_130px_180px_180px_130px_120px_60px]
            text-[11px] font-semibold uppercase tracking-wider text-gray-600
            pb-2 border-b border-gray-200 mb-3 px-5">
              <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-[10px]"></i>Date</span>
              <span class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-[10px]"></i>Time</span>
              <span>Service</span>
              <span>Patient</span>
              <span>Program</span>
              <span>Status</span>
              <span class="text-right">Actions</span>
            </div>
            <div class="space-y-2.5">
              @foreach($items as $i => $appt)
              @php
              $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
              $program = optional($appt->patient)->program ?? '—';
              $dateLabel = \Carbon\Carbon::parse($appt->appointment_date)->format('F j, Y');
              $weekday = \Carbon\Carbon::parse($appt->appointment_date)->format('l');
              $timeLabel = $appt->appointment_time
              ? \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') : '—';
              $serviceLabel = ($appt->service_type ?? '') === 'Others'
              ? (($appt->other_services ?? '') ?: 'Others')
              : ($appt->service_type ?? '—');
              $isToday = ($appt->appointment_date ?? null) === $today;
              $serviceLower = strtolower($serviceLabel);
              $badgeClass = 'service-badge-default';
              if (str_contains($serviceLower, 'surgery')) $badgeClass = 'service-badge-surgery';
              elseif (str_contains($serviceLower, 'check')) $badgeClass = 'service-badge-checkup';
              elseif (str_contains($serviceLower, 'whiten'))$badgeClass = 'service-badge-whitening';
              elseif (str_contains($serviceLower, 'extrac'))$badgeClass = 'service-badge-extraction';
              @endphp
              <div class="appt-card {{ $isToday ? 'is-today' : '' }}" data-appt-id="{{ $appt->id }}" style="animation-delay:{{ $i * 0.04 }}s">
                <div class="grid grid-cols-[1.4fr_1fr_1.5fr_1.5fr_1fr_0.9fr_1.6fr] items-center px-5 py-3.5 gap-2">
                  <div>
                    <p class="text-[13px] font-semibold text-gray-800">{{ $dateLabel }}</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $weekday }}</p>
                    @if($isToday)
                    <span class="inline-block mt-1 text-[9px] font-bold uppercase tracking-wide bg-green-500 text-white px-2 py-0.5 rounded-md shadow-sm">Today</span>
                    @endif
                  </div>
                  <div><span class="time-chip"><i class="fa-regular fa-clock text-xs"></i>{{ $timeLabel }}</span></div>
                  <div><span class="service-badge {{ $badgeClass }}">{{ $serviceLabel }}</span></div>
                  <div>
                    <p class="text-[13px] font-semibold text-gray-800">{{ $patientName }}</p>
                  </div>
                  <div>
                    @if($program === '—')
                    <span class="text-[12px] text-gray-400">—</span>
                    @else
                    <span class="inline-block bg-gray-100 text-gray-500 text-[11px] font-medium px-2.5 py-1 rounded-full border border-gray-200">{{ $program }}</span>
                    @endif
                  </div>
                  <div>
                    @if($isToday)
                    <span class="status-pill status-confirmed"><span class="status-dot"></span>Confirmed</span>
                    @else
                    <span class="status-pill status-pending"><span class="status-dot"></span>Upcoming</span>
                    @endif
                  </div>
                  <div class="action-row justify-end">

                    <a href="{{ route('dentist.appointments.patientProfile', $appt->id) }}"
                      class="action-btn border border-[#8B0000]/30 bg-white text-[#8B0000] hover:bg-[#8B0000] hover:text-white">
                      <i class="fa-regular fa-user text-[9px]"></i> View
                    </a>
                    
                    <button type="button"
                      class="action-btn action-btn-start"
                      onclick="openStartProcedureModal(this)"
                      data-id="{{ $appt->id }}"
                      data-name="{{ $patientName }}"
                      data-datetime="{{ $dateLabel }} | {{ $timeLabel }}"
                      {{ $isToday ? '' : 'disabled' }}
                      title="{{ $isToday ? '' : 'Only available on appointment date' }}">
                      <i class="fa-solid fa-play text-[9px]"></i> Start
                    </button>
                    <button type="button"
                      class="action-btn action-btn-reschedule"
                      onclick="openRescheduleModal(this)"
                      data-id="{{ $appt->id }}"
                      data-name="{{ $patientName }}"
                      data-datetime="{{ $dateLabel }} | {{ $timeLabel }}">
                      <i class="fa-solid fa-rotate-right text-[9px]"></i> Reschedule
                    </button>
                    <button type="button"
                      class="action-btn action-btn-cancel"
                      onclick="openCancelAppointmentModal(this)"
                      data-id="{{ $appt->id }}"
                      data-name="{{ $patientName }}"
                      data-datetime="{{ $dateLabel }} | {{ $timeLabel }}">
                      <i class="fa-solid fa-xmark text-[9px]"></i> Cancel
                    </button>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @empty
        <div class="flex flex-col items-center justify-center py-24 text-gray-400">
          <i class="fa-regular fa-calendar-xmark text-5xl mb-4 text-gray-300"></i>
          <p class="text-base font-semibold text-gray-500">No upcoming appointments</p>
          <p class="text-sm mt-1">New appointments will appear here once scheduled.</p>
        </div>
        @endforelse
      </section>

      <!-- PAST SECTION -->
      <section id="pastSection" class="pb-16 hidden">
        @forelse($pastGrouped as $month => $items)
        <div class="mb-14">
          <div class="flex items-center gap-4 mb-5 pl-2">
            <div class="timeline-dot-past"></div>
            <h2 class="text-xl font-bold text-gray-400">{{ $month }}</h2>
            <span class="bg-gray-100 text-gray-400 text-xs font-semibold px-3 py-1 rounded-full">
              {{ $items->count() }} {{ Str::plural('appointment', $items->count()) }}
            </span>
          </div>
          <div class="relative pl-10">
            <div class="absolute left-[8px] top-0 bottom-0 w-[2px] bg-gray-200 rounded-full"></div>
            <div class="grid grid-cols-[1.4fr_1fr_1.5fr_1.5fr_1fr]
                        text-[11px] font-semibold uppercase tracking-wider text-gray-400
                        pb-2 border-b border-gray-200 mb-3 px-5">
              <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-[10px]"></i>Date</span>
              <span class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-[10px]"></i>Time</span>
              <span>Service</span>
              <span>Patient</span>
              <span>Program</span>
            </div>
            <div class="space-y-2.5">
              @foreach($items as $i => $appt)
              @php
              $patientName = optional($appt->patient)->name ?? 'Unknown Patient';
              $program = optional($appt->patient)->program ?? '—';
              $dateLabel = \Carbon\Carbon::parse($appt->appointment_date)->format('F j, Y');
              $weekday = \Carbon\Carbon::parse($appt->appointment_date)->format('l');
              $timeLabel = $appt->appointment_time
              ? \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A') : '—';
              $serviceLabel = ($appt->service_type ?? '') === 'Others'
              ? (($appt->other_services ?? '') ?: 'Others')
              : ($appt->service_type ?? '—');
              $serviceLower = strtolower($serviceLabel);
              $badgeClass = 'service-badge-default';
              if (str_contains($serviceLower, 'surgery')) $badgeClass = 'service-badge-surgery';
              elseif (str_contains($serviceLower, 'check')) $badgeClass = 'service-badge-checkup';
              elseif (str_contains($serviceLower, 'whiten'))$badgeClass = 'service-badge-whitening';
              elseif (str_contains($serviceLower, 'extrac'))$badgeClass = 'service-badge-extraction';
              @endphp
              <div class="appt-card opacity-70" style="animation-delay:{{ $i * 0.04 }}s">
                <div class="grid grid-cols-[1.4fr_1fr_1.5fr_1.5fr_1fr] items-center px-5 py-3.5 gap-2">
                  <div>
                    <p class="text-[13px] font-semibold text-gray-500">{{ $dateLabel }}</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $weekday }}</p>
                  </div>
                  <div><span class="time-chip text-gray-400"><i class="fa-regular fa-clock text-xs"></i>{{ $timeLabel }}</span></div>
                  <div><span class="service-badge {{ $badgeClass }} opacity-70">{{ $serviceLabel }}</span></div>
                  <div>
                    <p class="text-[13px] font-medium text-gray-500">{{ $patientName }}</p>
                  </div>
                  <div>
                    @if($program === '—')
                    <span class="text-[12px] text-gray-400">—</span>
                    @else
                    <span class="inline-block bg-gray-100 text-gray-400 text-[11px] font-medium px-2.5 py-1 rounded-full border border-gray-200">{{ $program }}</span>
                    @endif
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @empty
        <div class="flex flex-col items-center justify-center py-24 text-gray-400">
          <i class="fa-regular fa-calendar-xmark text-5xl mb-4 text-gray-300"></i>
          <p class="text-base font-semibold text-gray-500">No past appointments</p>
          <p class="text-sm mt-1">Completed appointments will appear here.</p>
        </div>
        @endforelse
      </section>

      <div class="pb-16"></div>
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

  <!-- ═══════════════════════════════════
       TOAST CONTAINER
  ═══════════════════════════════════ -->
  <div id="toastContainer"></div>

  <!-- ═══════════════════════════════════
       RESCHEDULE MODAL — REDESIGNED
  ═══════════════════════════════════ -->
  <div id="rescheduleModal"
    class="fixed inset-0 bg-black/50 flex items-center justify-center backdrop-blur-sm hidden z-[9999]"
    onclick="handleRescheduleBackdropClick(event)">

    <div class="reschedule-modal-panel bg-white w-[580px] rounded-2xl overflow-hidden shadow-2xl">

      <!-- Two-tone header -->
      <div class="relative overflow-hidden">
        <!-- Background geometric accent -->
        <div class="absolute inset-0 bg-gradient-to-br from-amber-500 to-orange-500"></div>
        <div class="absolute -right-8 -top-8 w-40 h-40 rounded-full bg-white/10"></div>
        <div class="absolute -right-4 top-6 w-24 h-24 rounded-full bg-white/08"></div>
        <div class="absolute left-40 -bottom-6 w-28 h-28 rounded-full bg-black/08"></div>

        <div class="relative px-8 pt-6 pb-6 flex items-center gap-5">
          <!-- Icon -->
          <div class="w-14 h-14 rounded-2xl bg-white/20 border border-white/30 flex items-center justify-center flex-shrink-0 shadow-lg">
            <i class="fa-solid fa-calendar-pen text-white text-xl"></i>
          </div>
          <div class="flex-1">
            <h2 class="text-white font-bold text-xl leading-tight">Reschedule Appointment</h2>
            <p class="text-white/70 text-xs mt-0.5">The patient will be notified of the new schedule.</p>
          </div>
          <button onclick="closeRescheduleModal()"
            class="w-8 h-8 rounded-full bg-white/15 hover:bg-white/25 text-white/80 hover:text-white
                         flex items-center justify-center transition text-sm flex-shrink-0">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      </div>

      <!-- Body -->
      <div class="px-8 py-6 bg-gray-50">

        <!-- Current appointment card -->
        <div class="bg-white border border-amber-100 rounded-xl p-4 mb-5 shadow-sm">
          <p class="text-[10px] font-bold uppercase tracking-widest text-amber-500 mb-3">Current Appointment</p>
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-amber-50 border border-amber-100 flex items-center justify-center flex-shrink-0">
              <i class="fa-regular fa-circle-user text-amber-400 text-base"></i>
            </div>
            <div class="flex-1">
              <p class="text-[13px] font-bold text-gray-800" id="resPatientName">—</p>
              <p class="text-[11px] text-gray-400 mt-0.5" id="resAppointmentDate">—</p>
            </div>
            <!-- Arrow to new -->
            <div class="flex items-center gap-2">
              <div class="w-7 h-px bg-dashed border-t-2 border-dashed border-amber-300"></div>
              <div class="w-7 h-7 rounded-full bg-amber-100 flex items-center justify-center">
                <i class="fa-solid fa-arrow-right text-amber-500 text-[10px]"></i>
              </div>
              <span class="text-[11px] text-amber-600 font-semibold">New schedule</span>
            </div>
          </div>
        </div>

        <!-- Info notice -->
        <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mb-6">
          <i class="fa-solid fa-circle-info text-amber-500 text-sm mt-0.5 flex-shrink-0"></i>
          <p class="text-[12px] text-amber-700 leading-relaxed">
            You'll be taken to the scheduling page where you can pick a new date and time slot for this patient.
          </p>
        </div>

        <!-- Action buttons -->
        <div class="flex items-center gap-3">
          <button onclick="closeRescheduleModal()"
            class="flex-1 px-5 py-2.5 rounded-xl border border-gray-200 bg-white
                   text-gray-600 font-semibold hover:bg-gray-50 transition text-sm shadow-sm">
            <i class="fa-solid fa-xmark text-xs mr-1.5 text-gray-400"></i>Cancel
          </button>
          <button onclick="confirmReschedule()"
            class="flex-[2] px-5 py-2.5 rounded-xl font-bold text-sm transition
                   bg-gradient-to-r from-amber-500 to-orange-500
                   hover:from-amber-600 hover:to-orange-600
                   text-white shadow-md shadow-amber-500/25 active:scale-[.98]">
            <i class="fa-solid fa-calendar-pen text-xs mr-1.5"></i>Proceed to Reschedule
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- ═══════════════════════════════════
       START PROCEDURE MODAL (unchanged)
  ═══════════════════════════════════ -->
  <div id="startProcedureModal" class="fixed inset-0 bg-black/50 flex items-center backdrop-blur-sm justify-center hidden z-[9999]">
    <div class="bg-white w-[560px] rounded-2xl overflow-hidden shadow-2xl">
      <div class="bg-green-700 px-8 py-5 text-center">
        <h2 class="text-xl font-bold text-white">Confirm Procedure Start</h2>
      </div>
      <div class="px-10 py-7 bg-gray-50">
        <p class="text-base font-bold text-gray-900 mb-1 text-center">You are about to begin this appointment's procedure.</p>
        <p class="text-sm text-gray-500 mb-5 text-center">This will mark the appointment as in progress.</p>
        <div class="bg-white border border-gray-200 rounded-2xl px-8 py-5 text-center mb-4 shadow-sm">
          <div class="flex items-center justify-center gap-2 text-gray-700 text-sm font-bold mb-3">
            <i class="fa-regular fa-circle-user text-lg"></i><span>Appointment Details</span>
          </div>
          <p class="text-sm text-gray-800">Patient Name: <span class="font-bold" id="startPatientName">—</span></p>
          <p class="text-sm text-gray-600 mt-1" id="startAppointmentDate">—</p>
        </div>
        <div class="flex justify-end gap-3">
          <button onclick="closeStartProcedureModal()" class="px-6 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 font-semibold hover:bg-gray-100 transition text-sm shadow-sm">Cancel</button>
          <button onclick="confirmStartProcedure()" class="px-6 py-2 rounded-lg bg-green-700 text-white font-semibold hover:bg-green-800 transition text-sm shadow-sm">Start Procedure</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ═══════════════════════════════════
       CANCEL MODAL — ENHANCED
  ═══════════════════════════════════ -->
  <div id="cancelAppointmentModal"
    class="fixed inset-0 bg-black/50 flex items-center justify-center backdrop-blur-sm hidden z-[9999]"
    onclick="handleCancelBackdropClick(event)">

    <div class="cancel-modal-panel bg-white w-[620px] rounded-2xl overflow-hidden shadow-2xl">

      <!-- Header strip -->
      <div class="relative bg-gradient-to-r from-[#7f0000] to-[#b91c1c] px-8 pt-6 pb-8">
        <!-- Close X -->
        <button onclick="closeCancelAppointmentModal()"
          class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20
                       text-white/70 hover:text-white flex items-center justify-center transition text-sm">
          <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- Pulsing warning icon -->
        <div class="flex justify-center mb-3">
          <div class="cancel-icon-ring">
            <div class="cancel-icon-core">
              <i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i>
            </div>
          </div>
        </div>

        <h2 class="text-center text-white font-bold text-lg leading-tight">Cancel Appointment</h2>
        <p class="text-center text-white/60 text-xs mt-1">This action cannot be undone.</p>
      </div>

      <!-- Body -->
      <div class="px-8 py-6 bg-gray-50">

        <!-- Patient detail card -->
        <div class="bg-white border border-gray-100 rounded-xl px-5 py-4 mb-5 shadow-sm">
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-red-50 border border-red-100 flex items-center justify-center flex-shrink-0">
              <i class="fa-regular fa-circle-user text-red-400 text-sm"></i>
            </div>
            <div>
              <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5">Patient</p>
              <p class="text-[14px] font-bold text-gray-800" id="cancelPatientName">—</p>
            </div>
            <div class="ml-auto text-right">
              <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5">Scheduled</p>
              <p class="text-[12px] font-medium text-gray-600" id="cancelAppointmentDate">—</p>
            </div>
          </div>
        </div>

        <!-- Reason selector -->
        <div class="mb-5">
          <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-2.5">
            Reason for cancellation <span class="text-red-400 font-normal normal-case">* required</span>
          </p>
          <div class="flex flex-wrap gap-2" id="cancelReasonChips" onchange="clearReasonError()">
            <div class="reason-chip">
              <input type="radio" name="cancelReason" id="r1" value="Patient no-show">
              <label for="r1"><i class="fa-regular fa-circle-xmark text-[11px]"></i> Patient no-show</label>
            </div>
            <div class="reason-chip">
              <input type="radio" name="cancelReason" id="r2" value="Doctor unavailable">
              <label for="r2"><i class="fa-solid fa-user-doctor text-[11px]"></i> Doctor unavailable</label>
            </div>
            <div class="reason-chip">
              <input type="radio" name="cancelReason" id="r3" value="Patient request">
              <label for="r3"><i class="fa-regular fa-hand text-[11px]"></i> Patient request</label>
            </div>
            <div class="reason-chip">
              <input type="radio" name="cancelReason" id="r4" value="Emergency">
              <label for="r4"><i class="fa-solid fa-bolt text-[11px]"></i> Emergency</label>
            </div>
            <div class="reason-chip">
              <input type="radio" name="cancelReason" id="r5" value="Rescheduled">
              <label for="r5"><i class="fa-solid fa-rotate text-[11px]"></i> Rescheduled</label>
            </div>
          </div>
          <!-- Validation error -->
          <div id="reasonError" class="hidden mt-2.5 flex items-center gap-1.5 text-red-500 text-[12px] font-semibold">
            <i class="fa-solid fa-circle-exclamation text-[11px]"></i>
            Please select a reason before cancelling.
          </div>
        </div>

        <!-- Action buttons -->
        <div class="flex items-center justify-between gap-3">
          <button onclick="closeCancelAppointmentModal()"
            class="flex-1 px-5 py-2.5 rounded-xl border border-gray-200 bg-white
                   text-gray-600 font-semibold hover:bg-gray-50 transition text-sm shadow-sm">
            <i class="fa-solid fa-arrow-left text-xs mr-1.5"></i>Keep Appointment
          </button>

          <button id="confirmCancelBtn" onclick="confirmCancelAppointment()"
            class="flex-1 px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#8b0000] to-[#c0392b]
                   text-white font-bold hover:from-[#6f0000] hover:to-[#a93226]
                   transition text-sm shadow-md shadow-red-900/20
                   active:scale-[.98]">
            <i class="fa-solid fa-ban text-xs mr-1.5"></i>Yes, Cancel Appointment
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById("currentDate").textContent =
      new Date().toLocaleDateString("en-US", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
      });

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

    // ── TABS ──
    const btnUpcoming = document.getElementById('btnUpcoming');
    const btnPast = document.getElementById('btnPast');

    function setActiveTab(tab) {
      const isUpcoming = tab === 'upcoming';
      document.getElementById('upcomingSection')?.classList.toggle('hidden', !isUpcoming);
      document.getElementById('pastSection')?.classList.toggle('hidden', isUpcoming);
      btnUpcoming?.classList.toggle('active', isUpcoming);
      btnPast?.classList.toggle('active', !isUpcoming);
    }
    btnUpcoming?.addEventListener('click', () => setActiveTab('upcoming'));
    btnPast?.addEventListener('click', () => setActiveTab('past'));

    // ═══════════════════════════
    // TOAST SYSTEM
    // ═══════════════════════════
    function showToast({
      title = '',
      message = '',
      type = 'cancel',
      duration = 4000
    }) {
      const container = document.getElementById('toastContainer');

      const toast = document.createElement('div');
      toast.className = 'toast-item';
      toast.innerHTML = `
        <div class="toast-icon-wrap toast-icon-cancel">
          <i class="fa-solid fa-ban text-red-400 text-sm"></i>
        </div>
        <div class="toast-body">
          <div class="toast-title">${title}</div>
          ${message ? `<div class="toast-message">${message}</div>` : ''}
        </div>
        <button class="toast-close" onclick="dismissToast(this.closest('.toast-item'))">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="toast-progress" style="animation-duration: ${duration}ms;"></div>
      `;

      container.appendChild(toast);

      // Auto-dismiss
      setTimeout(() => dismissToast(toast), duration);
    }

    function dismissToast(toast) {
      if (!toast || toast.classList.contains('toast-exit')) return;
      toast.classList.add('toast-exit');
      setTimeout(() => toast.remove(), 350);
    }

    // ═══════════════════════════
    // MODALS
    // ═══════════════════════════
    let selectedApptId = null;

    // ── RESCHEDULE ──
    function openRescheduleModal(btn) {
      selectedApptId = btn.dataset.id;
      document.getElementById('resPatientName').textContent = btn.dataset.name || '—';
      document.getElementById('resAppointmentDate').textContent = btn.dataset.datetime || '—';

      const modal = document.getElementById('rescheduleModal');
      modal.classList.remove('hidden');

      // Re-trigger entrance animation
      const panel = modal.querySelector('.reschedule-modal-panel');
      panel.style.animation = 'none';
      requestAnimationFrame(() => requestAnimationFrame(() => {
        panel.style.animation = '';
      }));
    }

    function closeRescheduleModal() {
      document.getElementById('rescheduleModal').classList.add('hidden');
      selectedApptId = null;
    }

    function handleRescheduleBackdropClick(e) {
      if (e.target === document.getElementById('rescheduleModal')) closeRescheduleModal();
    }

    function confirmReschedule() {
      const url = "{{ route('dentist.appointments.reschedule', ['id' => ':id']) }}".replace(':id', selectedApptId);
      window.location.href = url;
    }

    // ── START PROCEDURE ──
    function openStartProcedureModal(btn) {
      selectedApptId = btn.dataset.id;
      document.getElementById('startPatientName').textContent = btn.dataset.name || '—';
      document.getElementById('startAppointmentDate').textContent = btn.dataset.datetime || '—';
      document.getElementById('startProcedureModal').classList.remove('hidden');
    }

    function closeStartProcedureModal() {
      document.getElementById('startProcedureModal').classList.add('hidden');
      selectedApptId = null;
    }

    function confirmStartProcedure() {
      window.location.href = `/dentist/appointments/${selectedApptId}/start`;
    }

    // ── CANCEL MODAL ──
    let cancelPatientNameCache = '';

    function openCancelAppointmentModal(btn) {
      selectedApptId = btn.dataset.id;
      cancelPatientNameCache = btn.dataset.name || 'this patient';

      document.getElementById('cancelPatientName').textContent = btn.dataset.name || '—';
      document.getElementById('cancelAppointmentDate').textContent = btn.dataset.datetime || '—';

      // Reset form + clear validation
      document.querySelectorAll('input[name="cancelReason"]').forEach(r => r.checked = false);
      clearReasonError();

      // Reset confirm button
      const btn2 = document.getElementById('confirmCancelBtn');
      btn2.disabled = false;
      btn2.innerHTML = '<i class="fa-solid fa-ban text-xs mr-1.5"></i>Yes, Cancel Appointment';

      const modal = document.getElementById('cancelAppointmentModal');
      modal.classList.remove('hidden');
      const panel = modal.querySelector('.cancel-modal-panel');
      panel.style.animation = 'none';
      requestAnimationFrame(() => requestAnimationFrame(() => {
        panel.style.animation = '';
      }));
    }

    function closeCancelAppointmentModal() {
      document.getElementById('cancelAppointmentModal').classList.add('hidden');
      selectedApptId = null;
    }

    function handleCancelBackdropClick(e) {
      if (e.target === document.getElementById('cancelAppointmentModal')) closeCancelAppointmentModal();
    }

    // Real-time validation helpers
    function clearReasonError() {
      const chips = document.getElementById('cancelReasonChips');
      const error = document.getElementById('reasonError');
      chips.classList.remove('invalid', 'chips-error-shake');
      error.classList.add('hidden');

      // Re-enable the confirm button if it was blocked by validation
      const btn = document.getElementById('confirmCancelBtn');
      if (!btn.disabled || btn.innerHTML.includes('fa-ban')) return;
      // only re-enable if disabled due to validation, not mid-redirect
    }

    // Listen for any reason radio change to immediately clear error
    document.querySelectorAll('input[name="cancelReason"]').forEach(r => {
      r.addEventListener('change', clearReasonError);
    });

    function confirmCancelAppointment() {
      const selectedReason = document.querySelector('input[name="cancelReason"]:checked')?.value || null;

      // ── VALIDATION: reason is required ──
      if (!selectedReason) {
        const chips = document.getElementById('cancelReasonChips');
        const error = document.getElementById('reasonError');
        error.classList.remove('hidden');
        chips.classList.add('invalid');
        chips.classList.remove('chips-error-shake');
        void chips.offsetWidth;
        chips.classList.add('chips-error-shake');
        return;
      }

      const btn = document.getElementById('confirmCancelBtn');
      btn.disabled = true;
      btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin text-xs mr-1.5"></i>Cancelling…';

      const patientName = cancelPatientNameCache;
      const apptId = selectedApptId;

      closeCancelAppointmentModal();

      // ── AJAX cancel — no page reload ──
      fetch(`/dentist/appointments/${apptId}/cancel`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
          },
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            // ── Remove card from DOM with animation ──
            const card = document.querySelector(`[data-appt-id="${apptId}"]`);
            if (card) {
              card.style.transition = 'all 0.35s cubic-bezier(.4,0,.2,1)';
              card.style.transformOrigin = 'top';
              card.style.overflow = 'hidden';
              // Animate out
              requestAnimationFrame(() => {
                card.style.maxHeight = card.offsetHeight + 'px';
                requestAnimationFrame(() => {
                  card.style.maxHeight = '0';
                  card.style.opacity = '0';
                  card.style.transform = 'scaleY(0.85) translateX(-8px)';
                  card.style.marginBottom = '0';
                  card.style.paddingTop = '0';
                  card.style.paddingBottom = '0';
                });
              });
              setTimeout(() => {
                card.remove();

                // Check if the group is now empty → show empty state
                const list = document.querySelector('.space-y-2\\.5, .space-y-3');
                const remaining = list ? list.querySelectorAll('[data-appt-id]') : [];
                if (remaining.length === 0) {
                  const container = list ? list.parentElement : null;
                  if (container) {
                    container.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-24 text-gray-400">
                      <i class="fa-regular fa-calendar-xmark text-5xl mb-4 text-gray-300"></i>
                      <p class="text-base font-semibold text-gray-500">No upcoming appointments</p>
                      <p class="text-sm mt-1">Cancelled appointments are moved to Past Visits.</p>
                    </div>`;
                  }
                }

                // ── Update patient badge in patients.blade (if sidebar/badge exists) ──
                const patientBadge = document.querySelector(`[data-patient-appt-badge="${apptId}"]`);
                if (patientBadge) patientBadge.remove();

                // ── Update today's snapshot bar count ──
                const countEl = document.getElementById('todayApptCount');
                if (countEl) {
                  const cur = parseInt(countEl.textContent) || 0;
                  if (cur > 0) countEl.textContent = cur - 1;
                }
              }, 380);
            }

            showToast({
              title: 'Appointment Cancelled',
              message: `${patientName}'s appointment has been successfully cancelled.`,
              duration: 5000,
            });

          } else {
            // Server returned failure
            showToast({
              title: 'Cancel Failed',
              message: data.message || 'Something went wrong. Please try again.',
              duration: 4000,
              type: 'error',
            });
            // Re-enable button in case user wants to retry (reopen modal)
          }
        })
        .catch(() => {
          showToast({
            title: 'Network Error',
            message: 'Could not reach the server. Please check your connection.',
            duration: 4000,
            type: 'error',
          });
        });
    }
  </script>

</body>

</html>