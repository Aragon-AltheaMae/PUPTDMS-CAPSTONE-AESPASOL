<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard | PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
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

    /* Custom Scrollbar */
    .scrollbar-thin::-webkit-scrollbar {
      width: 6px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
      background: transparent;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
      background: #d1d5db;
      border-radius: 10px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
      background: #9ca3af;
    }

    /* ── HEADER  ── */
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

    /* ── SIDEBAR ── */
    #sidebar {
      position: fixed;
      left: 0;
      top: 62px;
      width: 240px;
      height: calc(100vh - 62px);
      background: #fff;
      box-shadow: 2px 0 20px rgba(0, 0, 0, .07);
      z-index: 40;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .sidebar-inner {
      flex: 1;
      overflow-y: auto;
      overflow-x: hidden;
      padding: 12px 0 6px;
    }

    .sidebar-inner::-webkit-scrollbar {
      width: 4px;
    }

    .sidebar-inner::-webkit-scrollbar-thumb {
      background: #e5e7eb;
      border-radius: 4px;
    }

    /* ── ACCORDION GROUP ── */
    .nav-group {
      margin: 0 8px 2px;
    }

    .group-header {
      display: flex;
      align-items: center;
      padding: 7px 8px 5px;
      color: #6b7280;
    }

    .group-icon {
      width: 34px;
      height: 34px;
      border-radius: 8px;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 15px;
    }

    .group-header.active-group .group-icon {
      background: #8B0000;
      color: #fff;
      box-shadow: 0 4px 12px rgba(139, 0, 0, .3);
    }

    .group-label-wrap {
      flex: 1;
      text-align: left;
      overflow: hidden;
      margin-left: 10px;
    }

    .group-label {
      font-size: .72rem;
      font-weight: 700;
      white-space: nowrap;
      line-height: 1.2;
      display: block;
      text-transform: uppercase;
      letter-spacing: .06em;
    }

    .group-sublabel {
      font-size: .63rem;
      color: #9ca3af;
      font-size: .62rem;
      color: #b0b8c4;
      white-space: nowrap;
      display: block;
      margin-top: 1px;
    }

    .group-body {
      padding-bottom: 4px;
    }

    .group-body.open {
      max-height: 500px;
    }

    #sidebar.collapsed .group-body {
      padding-bottom: 4px;
    }

    .nav-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 7px 10px 7px 44px;
      border-radius: 8px;
      margin: 1px 4px;
      font-size: .77rem;
      font-weight: 500;
      color: #6b7280;
      text-decoration: none;
      transition: all .15s;
      white-space: nowrap;
    }

    .nav-link:hover {
      background: #fef2f2;
      color: #8B0000;
      padding-left: 48px;
    }

    .nav-link.active {
      background: #8B0000;
      color: #fff;
      box-shadow: 0 2px 8px rgba(139, 0, 0, .25);
    }

    .nav-link.active:hover {
      padding-left: 44px;
      background: #8B0000;
    }

    .nav-link i {
      width: 16px;
      text-align: center;
      font-size: 12px;
    }

    /* Separator */
    .nav-sep {
      height: 1px;
      background: #f3f4f6;
      margin: 8px 12px;
    }

    /* ── SIDEBAR BOTTOM ── */
    .sidebar-bottom {
      padding: 8px 8px 12px;
      border-top: 1px solid #f3f4f6;
      flex-shrink: 0;
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
    }

    .theme-option {
      position: relative;
      z-index: 2;
      flex: 1;
      height: 34px;
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

    .theme-option i {
      font-size: 16px;
    }

    .theme-option.active {
      color: #374151;
    }

    .theme-indicator {
      position: absolute;
      background: white;
      border-radius: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
      transition: all .3s cubic-bezier(.4, 0, .2, 1);
      pointer-events: none;
      width: calc(50% - 4px);
      height: calc(100% - 8px);
      left: 4px;
      top: 4px;
    }

    .theme-indicator.dark-mode {
      transform: translateX(calc(100% + 0px));
    }

    .logout-btn {
      display: flex;
      align-items: center;
      gap: 10px;
      width: 100%;
      padding: 8px 10px;
      border-radius: 10px;
      border: none;
      background: none;
      cursor: pointer;
      color: #ef4444;
      font-size: .77rem;
      font-weight: 600;
      transition: background .15s;
    }

    .logout-btn:hover {
      background: #fef2f2;
    }

    /* ── LAYOUT ── */
    #mainContent,
    #siteFooter {
      margin-left: 240px;
    }

    /* ── DARK MODE ── */
    body,
    main,
    footer {
      transition: background-color .3s ease, color .3s ease;
    }

    [data-theme="dark"] body {
      background-color: #000D1A;
      color: #E5E7EB;
    }

    [data-theme="dark"] #sidebar {
      background-color: #0d1117;
      border-right: 1px solid #21262d;
    }

    [data-theme="dark"] .bg-white {
      background-color: #161b22 !important;
    }

    [data-theme="dark"] .text-\[\#333333\] {
      color: #E5E7EB !important;
    }

    [data-theme="dark"] .nav-link:hover {
      background: rgba(139, 0, 0, .2);
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

    [data-theme="dark"] .nav-sep,
    [data-theme="dark"] .sidebar-bottom {
      border-color: #21262d;
    }

    [data-theme="dark"] .group-label {
      color: #6b7280;
    }

    [data-theme="dark"] .sl-card,
    [data-theme="dark"] .sl-stat {
      background: #161b22 !important;
      border-color: #21262d !important;
    }

    [data-theme="dark"] .sl-page-title {
      color: #f3f4f6;
    }

    [data-theme="dark"] .sl-toolbar-title {
      color: #f3f4f6;
    }

    [data-theme="dark"] .sl-table thead tr {
      background: #0d1117;
    }

    [data-theme="dark"] .sl-table tbody tr:hover {
      background: #1c2128;
    }

    [data-theme="dark"] .sl-table tbody td {
      color: #d1d5db;
    }

    [data-theme="dark"] .sl-username,
    [data-theme="dark"] .sl-date-day {
      color: #e5e7eb;
    }

    [data-theme="dark"] .sl-pagebar {
      background: #0d1117;
      border-color: #21262d;
    }

    /* ── MOBILE BOTTOM NAV ── */
    #adminMobileNav {
      display: none;
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      height: 68px;
      background: #fff;
      border-top: 1px solid #f0e0e0;
      z-index: 200;
      align-items: center;
      justify-content: space-around;
      box-shadow: 0 -4px 20px rgba(139, 0, 0, .10);
    }

    .adm-mob-item {
      flex: 1;
      height: 68px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 3px;
      font-size: 9.5px;
      font-weight: 600;
      color: #9ca3af;
      text-decoration: none;
      transition: color .2s;
      position: relative;
      cursor: pointer;
      border: none;
      background: none;
      padding: 0;
    }

    .adm-mob-item.active {
      color: #8B0000;
    }

    .adm-mob-item i {
      font-size: 20px;
    }

    .adm-mob-item.active i {
      filter: drop-shadow(0 0 6px rgba(139, 0, 0, .35));
    }

    /* FAB center button */
    #admMobFabWrap {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    #admMobFab {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: linear-gradient(135deg, #8B0000, #660000);
      color: white;
      border: none;
      font-size: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 16px rgba(139, 0, 0, .45);
      cursor: pointer;
      transition: transform .25s cubic-bezier(.34, 1.56, .64, 1);
      position: relative;
      top: -10px;
    }

    #admMobFab.open {
      transform: rotate(45deg) translateY(-10px);
    }

    /* FAB menu (quick nav) */
    #admMobFabMenu {
      position: fixed;
      bottom: 86px;
      left: 50%;
      transform: translateX(-50%) scaleY(0);
      transform-origin: bottom center;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(139, 0, 0, .18);
      border: 1px solid #f5e8e8;
      min-width: 220px;
      overflow: hidden;
      transition: transform .25s cubic-bezier(.34, 1.56, .64, 1), opacity .2s;
      opacity: 0;
      pointer-events: none;
      z-index: 300;
    }

    #admMobFabMenu.open {
      transform: translateX(-50%) scaleY(1);
      opacity: 1;
      pointer-events: auto;
    }

    .adm-fab-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 13px 18px;
      font-size: 13.5px;
      font-weight: 600;
      color: #333;
      text-decoration: none;
      transition: background .15s;
      border-bottom: 1px solid #fdf5f5;
    }

    .adm-fab-item:last-child {
      border-bottom: none;
    }

    .adm-fab-item:hover {
      background: #fff0f0;
      color: #8B0000;
    }

    .adm-fab-item .adm-fab-icon {
      width: 32px;
      height: 32px;
      background: #fef2f2;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      color: #8B0000;
      flex-shrink: 0;
    }

    /* ── MOBILE RESPONSIVE ── */
    @media (max-width: 767px) {
      #sidebar {
        display: none !important;
      }

      #mainContent {
        margin-left: 0 !important;
        padding-bottom: 86px !important;
      }

      #siteFooter {
        margin-left: 0 !important;
        margin-bottom: 68px;
      }

      #adminMobileNav {
        display: flex;
      }

      .header {
        padding: 0 1rem;
      }

      .header-title {
        display: none;
      }

      .sl-stats {
        grid-template-columns: repeat(2, 1fr);
      }

      .sl-table thead th:nth-child(6),
      .sl-table tbody td:nth-child(6),
      .sl-table thead th:nth-child(7),
      .sl-table tbody td:nth-child(7) {
        display: none;
      }
    }

    @media (min-width: 768px) {
      #adminMobileNav {
        display: none !important;
      }
    }

    /* ── DARK MOBILE ── */
    [data-theme="dark"] #adminMobileNav {
      background: #0a0a0a;
      border-top-color: #1a1a1a;
    }

    [data-theme="dark"] #admMobFabMenu {
      background: #111;
      border-color: #222;
    }

    [data-theme="dark"] .adm-fab-item {
      color: #E5E7EB;
      border-bottom-color: #1a1a1a;
    }

    [data-theme="dark"] .adm-fab-item:hover {
      background: #1a1a1a;
    }

    [data-theme="dark"] .adm-mob-item {
      color: #4b5563;
    }

    [data-theme="dark"] .adm-mob-item.active {
      color: #ff6b6b;
    }

    /* ── DARK MODE ── */
    body,
    main,
    footer {
      transition: background-color .3s ease, color .3s ease;
    }

    [data-theme="dark"] body {
      background-color: #000D1A;
      color: #E5E7EB;
    }

    [data-theme="dark"] #sidebar {
      background-color: #0d1117;
    }

    [data-theme="dark"] .bg-white {
      background-color: #161b22 !important;
    }

    [data-theme="dark"] .text-\[\#333333\] {
      color: #E5E7EB !important;
    }

    [data-theme="dark"] .group-header:hover,
    [data-theme="dark"] .nav-link:hover {
      background: rgba(139, 0, 0, .2);
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

    [data-theme="dark"] .flyout-panel {
      background: #161b22;
      border-color: #2d1a1a;
    }

    [data-theme="dark"] .flyout-link {
      color: #d1d5db;
    }

    [data-theme="dark"] .nav-sep,
    [data-theme="dark"] .sidebar-bottom {
      border-color: #21262d;
    }

    [data-theme="dark"] .sidebar-toggle-row {
      border-color: #21262d;
    }

    [data-theme="dark"] .sl-card,
    [data-theme="dark"] .sl-stat {
      background: #161b22 !important;
      border-color: #21262d !important;
    }

    [data-theme="dark"] .sl-page-title {
      color: #f3f4f6;
    }

    [data-theme="dark"] .sl-toolbar-title {
      color: #f3f4f6;
    }

    [data-theme="dark"] .sl-table thead tr {
      background: #0d1117;
    }

    [data-theme="dark"] .sl-table tbody tr:hover {
      background: #1c2128;
    }

    [data-theme="dark"] .sl-table tbody td {
      color: #d1d5db;
    }

    [data-theme="dark"] .sl-username,
    [data-theme="dark"] .sl-date-day {
      color: #e5e7eb;
    }

    [data-theme="dark"] .sl-pagebar {
      background: #0d1117;
      border-color: #21262d;
    }

    /* ── STAT CARDS ── */
    .stat-card {
      transition: transform .2s ease, box-shadow .2s ease;
    }

    .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, .1);
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

    /* ── TERMS MODAL ── */
    #termsModal {
      border: none;
      padding: 0;
      border-radius: 16px;
      width: min(94vw, 500px);
      box-shadow: 0 20px 60px rgba(0, 0, 0, .22), 0 0 0 1px rgba(139, 0, 0, .08);
      overflow: hidden;
    }

    #termsModal::backdrop {
      background: rgba(0, 0, 0, .55);
      backdrop-filter: blur(4px);
    }

    .terms-header {
      background: linear-gradient(135deg, #6b0000 0%, #8B0000 100%);
      padding: 20px 24px 18px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .terms-header-icon {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: rgba(255, 255, 255, .15);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .terms-header-icon i {
      font-size: 16px;
      color: rgba(255, 255, 255, .9);
    }

    .terms-header h2 {
      color: white;
      font-size: 1.05rem;
      font-weight: 800;
      margin: 0;
      letter-spacing: -.01em;
    }

    .terms-header p {
      color: rgba(255, 255, 255, .65);
      font-size: .72rem;
      margin: 2px 0 0;
    }

    .terms-body {
      padding: 22px 24px 20px;
    }

    .terms-body p {
      font-size: .85rem;
      color: #4B5563;
      line-height: 1.75;
      margin-bottom: 12px;
    }

    .terms-body strong {
      color: #1f2937;
      font-weight: 700;
    }

    .terms-divider {
      height: 1px;
      background: #f0e8e8;
      margin: 4px 0 16px;
    }

    .terms-checkbox-row {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      background: #fdf5f5;
      border: 1px solid #fce8e8;
      border-radius: 10px;
      padding: 12px 14px;
      margin-bottom: 20px;
      cursor: pointer;
    }

    .terms-checkbox-row input[type="checkbox"] {
      margin-top: 2px;
      cursor: pointer;
      accent-color: #8B0000;
      width: 15px;
      height: 15px;
      flex-shrink: 0;
    }

    .terms-checkbox-row span {
      font-size: .82rem;
      font-weight: 600;
      color: #374151;
      line-height: 1.5;
    }

    .terms-actions {
      display: flex;
      justify-content: flex-end;
      gap: 8px;
    }

    .terms-cancel-btn {
      padding: 9px 20px;
      border-radius: 9px;
      border: 1px solid #e5e7eb;
      background: #f9fafb;
      color: #6b7280;
      font-weight: 600;
      font-size: .82rem;
      cursor: pointer;
      transition: all .15s;
      font-family: 'Inter', sans-serif;
    }

    .terms-cancel-btn:hover {
      background: #f3f4f6;
      border-color: #d1d5db;
      color: #374151;
    }

    .terms-continue-btn {
      padding: 9px 22px;
      border-radius: 9px;
      border: none;
      background: #9CA3AF;
      color: white;
      font-weight: 700;
      font-size: .82rem;
      cursor: not-allowed;
      transition: all .2s;
      font-family: 'Inter', sans-serif;
    }

    .terms-continue-btn:not(:disabled) {
      background: #8B0000;
      cursor: pointer;
      box-shadow: 0 2px 10px rgba(139, 0, 0, .3);
    }

    .terms-continue-btn:not(:disabled):hover {
      background: #700000;
      box-shadow: 0 4px 14px rgba(139, 0, 0, .4);
    }

    [data-theme="dark"] #termsModal {
      background: #161b22;
    }

    [data-theme="dark"] .terms-body p {
      color: #9ca3af;
    }

    [data-theme="dark"] .terms-body strong {
      color: #e5e7eb;
    }

    [data-theme="dark"] .terms-divider {
      background: #21262d;
    }

    [data-theme="dark"] .terms-checkbox-row {
      background: #1c1c1c;
      border-color: #2d1a1a;
    }

    [data-theme="dark"] .terms-checkbox-row span {
      color: #d1d5db;
    }

    [data-theme="dark"] .terms-cancel-btn {
      background: #1f2937;
      border-color: #374151;
      color: #9ca3af;
    }

    [data-theme="dark"] .terms-cancel-btn:hover {
      background: #374151;
      color: #e5e7eb;
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
  </style>
</head>

<body class="bg-[#f5f5f5] text-[#333333]">

  <!-- ════════════ TERMS MODAL ════════════ -->
  <dialog id="termsModal">
    <div class="terms-header">
      <div class="terms-header-icon"><i class="fa-solid fa-file-shield"></i></div>
      <div>
        <h2>Terms and Conditions</h2>
        <p>Please read and accept before continuing</p>
      </div>
    </div>
    <div class="terms-body">
      <p>
        By clicking <strong>"Continue"</strong>, you consent to the collection, use, and
        processing of your personal data for legitimate purposes related to this service.
      </p>
      <p style="margin-bottom:0;">
        Your information will be handled in accordance with our <strong>Privacy Policy</strong>
        and in compliance with the <strong>Data Privacy Act of 2012</strong>.
      </p>
      <div class="terms-divider"></div>
      <label class="terms-checkbox-row">
        <input type="checkbox" id="termsCheckbox">
        <span>I have read and agree to the Terms and Conditions and Privacy Policy</span>
      </label>
      <div class="terms-actions">
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
          @csrf
          <button type="submit" class="terms-cancel-btn">Cancel</button>
        </form>
        <button id="termsContinueBtn" class="terms-continue-btn" disabled onclick="acceptTerms()">
          <i class="fa-solid fa-check" style="font-size:.75rem; margin-right:5px;"></i> Continue
        </button>
      </div>
    </div>
  </dialog>

  <div id="toastContainer" role="region" aria-live="polite" style="position:fixed!important;top:20px!important;right:20px!important;
         bottom:unset!important;left:unset!important;z-index:99999;
         display:flex;flex-direction:column;gap:10px;pointer-events:none;">
  </div>

  <!-- ════════════ HEADER ════════════ -->
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
          <div
            style="padding:.85rem 1rem .65rem; font-weight:700; color:#8B0000; font-size:.82rem; border-bottom:1px solid #f5e8e8;">
            Notifications</div>
          <div style="max-height:260px; overflow-y:auto;">
            @forelse($notifications as $n)
            <a href="{{ $n['url'] ?? '#' }}"
              style="display:block; padding:.65rem 1rem; font-size:.78rem; color:#333; text-decoration:none; border-bottom:1px solid #fdf5f5;">
              <div style="font-weight:600;">{{ $n['title'] ?? 'Notification' }}</div>
              @if(!empty($n['message']))<div style="color:#aaa; margin-top:2px;">{{ $n['message'] }}</div>
              @endif
            </a>
            @empty
            <div style="padding:2rem 1rem; text-align:center; color:#bbb; font-size:.78rem;">You're all
              caught up.</div>
            @endforelse
          </div>
        </div>
      </div>
      <div class="header-user">
        <img src="https://i.pravatar.cc/40" class="header-avatar" alt="Avatar">
        <div>
          <div class="header-name">Admin</div>
          <div class="header-role">Admin</div>
        </div>
      </div>
    </div>
  </header>

  <!-- ════════════ SIDEBAR ════════════ -->
  <aside id="sidebar">
    <div class="sidebar-inner">

      <!-- GROUP 1 — CLINIC MANAGEMENT -->
      <div class="nav-group" id="group-cms">
        <div class="group-header {{ request()->routeIs('admin.admin.dashboard') ? 'active-group' : '' }}">
          <div class="group-icon"><i class="fa-solid fa-hospital"></i></div>
          <div class="group-label-wrap">
            <span class="group-label">Clinic Management</span>
            <span class="group-sublabel">Core clinical modules</span>
          </div>
        </div>
        <div class="group-body">
          <a href="{{ route('admin.admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.admin.dashboard') ? 'active' : '' }}"><i
              class="fa-solid fa-chart-line"></i> Dashboard</a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
              class="fa-solid fa-users"></i> Patients</a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
              class="fa-solid fa-calendar-check"></i> Appointments</a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
              class="fa-solid fa-tooth"></i> Dental Records</a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
              class="fa-solid fa-file-circle-check"></i> Document Request</a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
              class="fa-solid fa-file"></i> Reports</a>
        </div>
      </div>

      <div class="nav-sep"></div>

      <!-- GROUP 2 — MAINTENANCE -->
      <div class="nav-group" id="group-mnt">
        <div
            class="group-header {{ request()->routeIs('admin.user_management*','admin.role_permissions','admin.academic_periods*','admin.clinic_schedule*') ? 'active-group' : '' }}">
          <div class="group-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
          <div class="group-label-wrap">
            <span class="group-label">Maintenance</span>
            <span class="group-sublabel">Configuration &amp; scheduling</span>
          </div>
        </div>
        <div class="group-body">
          <a href="{{ route('admin.user_management') }}"
            class="nav-link {{ request()->routeIs('admin.user_management*') ? 'active' : '' }}"><i
              class="fa-solid fa-user-gear"></i> User Management</a>
          <a href="{{ route('admin.role_permissions') }}"
            class="nav-link {{ request()->routeIs('admin.role_permissions') ? 'active' : '' }}"><i
              class="fa-solid fa-user-shield"></i> Roles &amp; Permissions</a>
          <a href="{{ route('admin.academic_periods') }}"
            class="nav-link {{ request()->routeIs('admin.academic_periods*') ? 'active' : '' }}"><i
              class="fa-solid fa-school"></i> Academic Periods</a>
          <a href="{{ route('admin.clinic_schedule') }}" class="nav-link {{ request()->routeIs('admin.clinic_schedule*') ? 'active' : '' }}"><i
              class="fa-solid fa-calendar-days"></i> Clinic Schedule</a>
         <a href="{{ route('admin.service-types') }}"
                class="nav-link {{ request()->routeIs('admin.service-types*') ? 'active' : '' }}">
                <i class="fa-solid fa-list-check"></i> Service Types
              </a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
              class="fa-solid fa-file-pen"></i> Document Templates</a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
              class="fa-solid fa-boxes-stacked"></i> Inventory</a>
        </div>
      </div>

      <div class="nav-sep"></div>

      <!-- GROUP 3 — SYSTEM -->
      <div class="nav-group" id="group-sys">
        <div class="group-header {{ request()->routeIs('admin.system_logs') ? 'active-group' : '' }}">
          <div class="group-icon"><i class="fa-solid fa-server"></i></div>
          <div class="group-label-wrap">
            <span class="group-label">System</span>
            <span class="group-sublabel">Admin &amp; configuration</span>
          </div>
        </div>
        <div class="group-body">
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
              class="fa-solid fa-database"></i> Data Backup</a>
          <a href="{{ route('admin.system_logs') }}"
            class="nav-link {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}"><i
              class="fa-solid fa-clipboard-list"></i> System Logs</a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
              class="fa-solid fa-sliders"></i> System Settings</a>
        </div>
      </div>

    </div><!-- /sidebar-inner -->

    <div class="sidebar-bottom">
      <div class="text-[.65rem] font-semibold tracking-widest text-gray-400 uppercase mb-2 px-1">Settings</div>
      <div class="w-full px-1 mb-3">
        <div id="themeToggle" class="theme-toggle-container">
          <button type="button" class="theme-option active" data-theme="light"><i class="fa-solid fa-sun"></i></button>
          <button type="button" class="theme-option" data-theme="dark"><i class="fa-regular fa-moon"></i></button>
          <div class="theme-indicator" aria-hidden="true"></div>
        </div>
      </div>
      <form action="{{ route('logout') }}" method="POST" onsubmit="resetTermsSession()">
        @csrf
        <button type="submit" class="logout-btn">
          <span
            style="width:30px;height:30px;background:#fef2f2;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid fa-right-from-bracket text-sm"></i>
          </span>
          <span class="font-semibold">Log out</span>
        </button>
      </form>
    </div>
  </aside>

  <!-- ════════════ MOBILE BOTTOM NAV ════════════ -->
  <nav id="adminMobileNav">
    {{-- Dashboard --}}
    <a href="{{ route('admin.admin.dashboard') }}"
      class="adm-mob-item {{ request()->routeIs('admin.admin.dashboard') ? 'active' : '' }}">
      <i class="fa-solid fa-chart-line"></i>
      <span>Dashboard</span>
    </a>

    {{-- Patients --}}
    <a href="{{ route('admin.admin.dashboard') }}" class="adm-mob-item {{ false ? 'active' : '' }}">
      <i class="fa-solid fa-users"></i>
      <span>Patients</span>
    </a>

    {{-- FAB — Quick Actions --}}
    <div id="admMobFabWrap">
      <div id="admMobFabMenu">
        <a href="{{ route('admin.admin.dashboard') }}" class="adm-fab-item">
          <span class="adm-fab-icon"><i class="fa-solid fa-calendar-check"></i></span>
          Appointments
        </a>
        <a href="{{ route('admin.system_logs') }}" class="adm-fab-item">
          <span class="adm-fab-icon"><i class="fa-solid fa-clipboard-list"></i></span>
          System Logs
        </a>
        <a href="{{ route('admin.user_management') }}" class="adm-fab-item">
          <span class="adm-fab-icon"><i class="fa-solid fa-user-gear"></i></span>
          User Management
        </a>
        <a href="{{ route('admin.role_permissions') }}" class="adm-fab-item">
          <span class="adm-fab-icon"><i class="fa-solid fa-user-shield"></i></span>
          Roles &amp; Permissions
        </a>
        <a href="{{ route('admin.academic_periods') }}" class="adm-fab-item">
          <span class="adm-fab-icon"><i class="fa-solid fa-school"></i></span>
          Academic Periods
        </a>
      </div>
      <button id="admMobFab" aria-label="Quick navigation">
        <i class="fa-solid fa-bars"></i>
      </button>
    </div>

    {{-- Appointments --}}
    <a href="{{ route('admin.admin.dashboard') }}" class="adm-mob-item {{ false ? 'active' : '' }}">
      <i class="fa-solid fa-calendar-check"></i>
      <span>Appts</span>
    </a>

    {{-- System Logs --}}
    <a href="{{ route('admin.system_logs') }}"
      class="adm-mob-item {{ request()->routeIs('admin.system_logs') ? 'active' : '' }}">
      <i class="fa-solid fa-clipboard-list"></i>
      <span>Logs</span>
    </a>
  </nav>

  <!-- ════════════ MAIN CONTENT ════════════ -->
  @php
  $logs = $logs ?? collect([]);
  $totalCount = $logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->total() : $logs->count();
  $adminCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() :
  $logs)->where('actor_role','admin')->count();
  $dentistCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() :
  $logs)->where('actor_role','dentist')->count();
  $patientCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() :
  $logs)->where('actor_role','patient')->count();
  $loginCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() :
  $logs)->whereIn('action',['login','Login'])->count();
  @endphp

  <main id="mainContent"
    style="padding-top:82px; padding-bottom:2rem; padding-left:1.5rem; padding-right:1.5rem; min-height:100vh;">
    <div style="max-width:1280px; margin:0 auto;">

      <!-- Date + Title -->
      <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
          <i class="fa-solid fa-sun text-yellow-400 text-xs"></i>
          <p id="currentDate"></p>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-[#8B0000]">Admin Dashboard</h1>
      </div>

      <!-- Academic Period Banner -->
      <div class="bg-white rounded-xl border-l-4 border-[#8B0000] shadow-sm mb-6 overflow-hidden">
        <div class="p-5 flex flex-col lg:flex-row gap-5 lg:items-center lg:justify-between">
          <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div>
              <div class="flex items-center gap-2 mb-1">
                <i class="fa-solid fa-calendar text-[#8B0000] text-sm"></i>
                <p class="text-[10px] tracking-widest text-gray-500 uppercase font-semibold">Current Semester</p>
              </div>
              <p class="text-xl font-bold text-gray-800">2nd Semester</p>
            </div>
            <div>
              <div class="flex items-center gap-2 mb-1">
                <i class="fa-solid fa-graduation-cap text-[#8B0000] text-sm"></i>
                <p class="text-[10px] tracking-widest text-gray-500 uppercase font-semibold">Academic Year</p>
              </div>
              <p class="text-xl font-bold text-gray-800">2025-2026</p>
            </div>
            <div>
              <div class="flex items-center gap-2 mb-1">
                <i class="fa-solid fa-clock text-[#8B0000] text-sm"></i>
                <p class="text-[10px] tracking-widest text-gray-500 uppercase font-semibold">Period Ends</p>
              </div>
              <p class="text-xl font-bold text-gray-800">June 10, 2026</p>
            </div>
          </div>
          <button
            class="bg-[#8B0000] hover:bg-[#760000] text-white px-5 py-2.5 rounded-lg font-semibold text-sm shadow transition-all lg:flex-shrink-0">
            <i class="fa-solid fa-gear mr-2"></i> Manage Periods
          </button>
        </div>
      </div>

      <!-- STATS CARDS -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        <div
          class="stat-card bg-white rounded-xl p-5 shadow border border-gray-100 overflow-hidden relative group hover:border-[#8B0000] transition-all">
          <div
            class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#8B0000]/5 to-transparent rounded-full -mr-16 -mt-16">
          </div>
          <div class="relative">
            <div class="flex items-center justify-between mb-3">
              <div
                class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#6B0000] flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-users text-white text-xl"></i>
              </div>
              <span class="text-xs font-semibold text-gray-400 bg-gray-100 px-3 py-1 rounded-full">All time</span>
            </div>
            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold mb-1">Total Patients</p>
            <p class="text-4xl font-extrabold text-gray-800 mb-1">1,234</p>
            <div class="flex items-center gap-1 text-xs text-gray-500">
              <i class="fa-solid fa-user-plus text-[10px]"></i>
              <span>All registered patients</span>
            </div>
          </div>
        </div>

        <div
          class="stat-card bg-white rounded-xl p-5 shadow border border-gray-100 overflow-hidden relative group hover:border-blue-400 transition-all">
          <div
            class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500/5 to-transparent rounded-full -mr-16 -mt-16">
          </div>
          <div class="relative">
            <div class="flex items-center justify-between mb-3">
              <div
                class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-calendar-check text-white text-xl"></i>
              </div>
              <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">December 2025</span>
            </div>
            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold mb-1">Appointments</p>
            <p class="text-4xl font-extrabold text-gray-800 mb-1">50</p>
            <div class="flex items-center gap-1 text-xs text-gray-500">
              <i class="fa-solid fa-clock text-[10px]"></i>
              <span>This month</span>
            </div>
          </div>
        </div>

        <div
          class="stat-card bg-white rounded-xl p-5 shadow border border-gray-100 overflow-hidden relative group hover:border-green-400 transition-all">
          <div
            class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-500/5 to-transparent rounded-full -mr-16 -mt-16">
          </div>
          <div class="relative">
            <div class="flex items-center justify-between mb-3">
              <div
                class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-file-arrow-up text-white text-xl"></i>
              </div>
              <span class="text-xs font-semibold text-green-600 bg-green-50 px-3 py-1 rounded-full">December 2025</span>
            </div>
            <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold mb-1">Documents Issued</p>
            <p class="text-4xl font-extrabold text-gray-800 mb-1">74</p>
            <div class="flex items-center gap-1 text-xs text-gray-500">
              <i class="fa-solid fa-file-lines text-[10px]"></i>
              <span>This month</span>
            </div>
          </div>
        </div>
      </div>

      <!-- MAIN CONTENT GRID -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">

          <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-[#8B0000]"></i>
                <h2 class="font-bold text-gray-800 text-sm">System Logs Overview</h2>
              </div>
              <a href="#" class="text-xs text-[#8B0000] font-semibold hover:underline flex items-center gap-1 group">
                View All <i
                  class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
              </a>
            </div>
            <div class="p-5">
              <div class="grid grid-cols-5 gap-3 mb-5">
                <div class="text-center group cursor-pointer">
                  <div
                    class="rounded-lg bg-purple-50 border border-purple-100 p-3 group-hover:bg-purple-100 transition-colors">
                    <div class="text-2xl font-extrabold text-purple-700">0</div>
                    <div class="text-[9px] font-semibold text-purple-600 uppercase tracking-wide mt-1">This Month</div>
                  </div>
                </div>
                <div class="text-center group cursor-pointer">
                  <div
                    class="rounded-lg bg-blue-50 border border-blue-100 p-3 group-hover:bg-blue-100 transition-colors">
                    <div class="text-2xl font-extrabold text-blue-700">0</div>
                    <div class="text-[9px] font-semibold text-blue-600 uppercase tracking-wide mt-1">Info</div>
                  </div>
                </div>
                <div class="text-center group cursor-pointer">
                  <div
                    class="rounded-lg bg-yellow-50 border border-yellow-100 p-3 group-hover:bg-yellow-100 transition-colors">
                    <div class="text-2xl font-extrabold text-yellow-700">0</div>
                    <div class="text-[9px] font-semibold text-yellow-600 uppercase tracking-wide mt-1">Warnings</div>
                  </div>
                </div>
                <div class="text-center group cursor-pointer">
                  <div
                    class="rounded-lg bg-green-50 border border-green-100 p-3 group-hover:bg-green-100 transition-colors">
                    <div class="text-2xl font-extrabold text-green-700">0</div>
                    <div class="text-[9px] font-semibold text-green-600 uppercase tracking-wide mt-1">Backups</div>
                  </div>
                </div>
                <div class="text-center group cursor-pointer">
                  <div class="rounded-lg bg-red-50 border border-red-100 p-3 group-hover:bg-red-100 transition-colors">
                    <div class="text-2xl font-extrabold text-red-700">0</div>
                    <div class="text-[9px] font-semibold text-red-600 uppercase tracking-wide mt-1">Errors</div>
                  </div>
                </div>
              </div>
              <div class="overflow-x-auto rounded-lg border border-gray-100">
                <table class="table w-full text-sm">
                  <thead class="bg-gray-50">
                    <tr class="text-[#8B0000] text-xs">
                      <th class="w-16 font-bold py-3">ID</th>
                      <th class="w-40 font-bold py-3">Date</th>
                      <th class="font-bold py-3 text-left">Description</th>
                      <th class="w-32 font-bold py-3">User</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="4" class="text-center py-12">
                        <i class="fa-solid fa-inbox text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-400 text-sm">No logs to display</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
              <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <i class="fa-solid fa-chart-pie text-[#8B0000]"></i>
                  <h2 class="font-bold text-gray-800 text-sm">GAD Analytics</h2>
                </div>
                <a href="#" class="text-xs text-[#8B0000] font-semibold hover:underline">View</a>
              </div>
              <div class="p-5">
                <div
                  class="h-40 rounded-lg border-2 border-dashed border-gray-200 flex items-center justify-center bg-gradient-to-br from-gray-50 to-white">
                  <div class="text-center">
                    <i class="fa-solid fa-chart-area text-4xl text-gray-300 mb-2"></i>
                    <p class="text-xs text-gray-400">Chart Placeholder</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
              <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <i class="fa-solid fa-boxes-stacked text-[#8B0000]"></i>
                  <h2 class="font-bold text-gray-800 text-sm">Inventory</h2>
                </div>
                <a href="#" class="text-xs text-[#8B0000] font-semibold hover:underline">View</a>
              </div>
              <div class="p-5">
                <div
                  class="h-40 rounded-lg border-2 border-dashed border-gray-200 flex items-center justify-center bg-gradient-to-br from-gray-50 to-white">
                  <div class="text-center">
                    <i class="fa-solid fa-box text-4xl text-gray-300 mb-2"></i>
                    <p class="text-xs text-gray-400">Inventory Placeholder</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- Right Column -->
        <div class="space-y-6">

          <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b bg-gray-50">
              <div class="flex items-center gap-2">
                <i class="fa-solid fa-bolt text-[#8B0000]"></i>
                <h2 class="font-bold text-gray-800 text-sm">Quick Actions</h2>
              </div>
            </div>
            <div class="p-4 space-y-2.5">
              <button
                class="w-full flex items-center gap-3 bg-gradient-to-r from-red-50 to-white hover:from-red-100 hover:to-red-50 border border-red-100 rounded-lg px-4 py-3 text-left transition-all group">
                <div
                  class="w-10 h-10 rounded-lg bg-white border border-red-200 flex items-center justify-center text-[#8B0000] shadow-sm group-hover:scale-110 transition-transform">
                  <i class="fa-solid fa-file-circle-plus"></i>
                </div>
                <div class="flex-1">
                  <div class="font-bold text-sm text-[#8B0000]">New Template</div>
                  <div class="text-[10px] text-gray-500">Create Document Format</div>
                </div>
                <i
                  class="fa-solid fa-chevron-right text-gray-300 text-xs group-hover:text-[#8B0000] group-hover:translate-x-1 transition-all"></i>
              </button>
              <button
                class="w-full flex items-center gap-3 bg-gradient-to-r from-red-50 to-white hover:from-red-100 hover:to-red-50 border border-red-100 rounded-lg px-4 py-3 text-left transition-all group">
                <div
                  class="w-10 h-10 rounded-lg bg-white border border-red-200 flex items-center justify-center text-[#8B0000] shadow-sm group-hover:scale-110 transition-transform">
                  <i class="fa-solid fa-file-invoice"></i>
                </div>
                <div class="flex-1">
                  <div class="font-bold text-sm text-[#8B0000]">Generate Report</div>
                  <div class="text-[10px] text-gray-500">Create Report Documents</div>
                </div>
                <i
                  class="fa-solid fa-chevron-right text-gray-300 text-xs group-hover:text-[#8B0000] group-hover:translate-x-1 transition-all"></i>
              </button>
              <button
                class="w-full flex items-center gap-3 bg-gradient-to-r from-red-50 to-white hover:from-red-100 hover:to-red-50 border border-red-100 rounded-lg px-4 py-3 text-left transition-all group">
                <div
                  class="w-10 h-10 rounded-lg bg-white border border-red-200 flex items-center justify-center text-[#8B0000] shadow-sm group-hover:scale-110 transition-transform">
                  <i class="fa-solid fa-chart-column"></i>
                </div>
                <div class="flex-1">
                  <div class="font-bold text-sm text-[#8B0000]">View Reports</div>
                  <div class="text-[10px] text-gray-500">All Reports</div>
                </div>
                <i
                  class="fa-solid fa-chevron-right text-gray-300 text-xs group-hover:text-[#8B0000] group-hover:translate-x-1 transition-all"></i>
              </button>
            </div>
          </div>

          <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b bg-gray-50">
              <div class="flex items-center gap-2">
                <i class="fa-solid fa-database text-[#8B0000]"></i>
                <h2 class="font-bold text-gray-800 text-sm">Data Backup</h2>
              </div>
            </div>
            <div class="p-4 space-y-3">
              <div class="rounded-lg bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 p-4">
                <div class="flex items-center gap-3">
                  <div
                    class="w-10 h-10 rounded-lg bg-white border border-green-300 flex items-center justify-center text-green-600 shadow-sm flex-shrink-0">
                    <i class="fa-solid fa-check text-lg"></i>
                  </div>
                  <div class="flex-1 min-w-0">
                    <div class="text-[10px] text-green-700 font-semibold uppercase tracking-wide mb-0.5">Last Backup
                    </div>
                    <div class="text-sm font-bold text-gray-800 truncate">December 25, 2025</div>
                    <div class="text-[10px] text-gray-600 mt-1">Status: Successful</div>
                  </div>
                </div>
              </div>
              <div class="rounded-lg bg-gray-50 border border-gray-200 p-3.5 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <i class="fa-solid fa-clock text-gray-400"></i>
                  <div>
                    <div class="text-[10px] text-gray-500 font-semibold">Next Scheduled</div>
                    <div class="text-xs font-bold text-gray-700">March 30, 2026</div>
                  </div>
                </div>
              </div>
              <button
                class="w-full bg-gradient-to-r from-[#8B0000] to-[#6B0000] hover:from-[#760000] hover:to-[#5B0000] text-white font-bold py-3 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 group">
                <i class="fa-solid fa-database group-hover:scale-110 transition-transform"></i>
                <span>Run Backup Now</span>
              </button>
            </div>
          </div>

        </div>
      </div>

    </div>
  </main>

  <!-- ════════════ FOOTER ════════════ -->
  <footer id="siteFooter" class="bg-[#8B0000] text-[#F4F4F4] p-6">
    <div
      class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 text-sm text-center">
      <span><span class="text-gray-300">© 1998-2026</span> <span class="font-semibold">Polytechnic University of
          the Philippines</span></span>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/terms/" class="hover:underline">Terms of Use</a>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/privacy/" class="hover:underline">Privacy Statement</a>
    </div>
  </footer>

  @if(session('activeAppointmentModal'))
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
      modal.addEventListener('cancel', function (e) { e.preventDefault(); });
      if (closeBtn) closeBtn.addEventListener("click", function () { modal.close(); });
    });
  </script>
  @endif

  @if (session('login_as'))
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      showToast(
        'Login Successful',
        'Logged in successfully as <strong>{{ session("login_as") }}</strong>',
        'success'
      );
    });
  </script>
  @endif

  <script>
document.addEventListener('DOMContentLoaded', function () {
    const termsModal = document.getElementById('termsModal');
    const termsCheckbox = document.getElementById('termsCheckbox');
    const termsContinueBtn = document.getElementById('termsContinueBtn');

    if (termsCheckbox && termsContinueBtn) {
      termsCheckbox.checked = false;
      termsContinueBtn.disabled = true;

      termsCheckbox.addEventListener('change', function () {
        termsContinueBtn.disabled = !this.checked;
      });
    }

    @if(session('show_terms_modal'))
      if (termsModal) {
        termsModal.showModal();
      }
    @endif
  });

  function acceptTerms() {
    const termsModal = document.getElementById('termsModal');
    if (termsModal) {
      termsModal.close();
    }
  }

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

    // ── Date ──
    const dateEl = document.getElementById('currentDate');
    if (dateEl) {
      dateEl.textContent = new Date().toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    }

    // Notifications
    document.getElementById('notifBtn').addEventListener('click', e => {
      e.stopPropagation();
      document.getElementById('notifMenu').classList.toggle('open');
    });
    document.addEventListener('click', () => {
      document.getElementById('notifMenu').classList.remove('open');
      const fabMenu = document.getElementById('admMobFabMenu');
      const fab = document.getElementById('admMobFab');
      if (fabMenu) fabMenu.classList.remove('open');
      if (fab) fab.classList.remove('open');
    });

    // Mobile FAB
    document.addEventListener('DOMContentLoaded', () => {
      const fab = document.getElementById('admMobFab');
      const fabMenu = document.getElementById('admMobFabMenu');
      if (fab && fabMenu) {
        fab.addEventListener('click', e => {
          e.stopPropagation();
          const isOpen = fabMenu.classList.contains('open');
          fabMenu.classList.toggle('open', !isOpen);
          fab.classList.toggle('open', !isOpen);
        });
        fabMenu.addEventListener('click', e => e.stopPropagation());
      }
    });

    // Theme
    const html = document.documentElement;
    function applyTheme(theme) {
      html.setAttribute('data-theme', theme);
      localStorage.setItem('theme', theme);
      document.querySelectorAll('.theme-option').forEach(o =>
        o.getAttribute('data-theme') === theme ? o.classList.add('active') : o.classList.remove('active')
      );
      const ind = document.querySelector('.theme-indicator');
      if (ind) theme === 'dark' ? ind.classList.add('dark-mode') : ind.classList.remove('dark-mode');
    }
    document.addEventListener('DOMContentLoaded', () => {
      // Theme
      applyTheme(localStorage.getItem('theme') || 'light');
      document.querySelectorAll('.theme-option').forEach(o =>
        o.addEventListener('click', e => { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); })
      );

      // Mobile FAB
      const fab = document.getElementById('admMobFab');
      const fabMenu = document.getElementById('admMobFabMenu');
      if (fab && fabMenu) {
        fab.addEventListener('click', e => {
          e.stopPropagation();
          const isOpen = fabMenu.classList.contains('open');
          fabMenu.classList.toggle('open', !isOpen);
          fab.classList.toggle('open', !isOpen);
        });
        fabMenu.addEventListener('click', e => e.stopPropagation());
      }

    });
  </script>

</body>

</html>