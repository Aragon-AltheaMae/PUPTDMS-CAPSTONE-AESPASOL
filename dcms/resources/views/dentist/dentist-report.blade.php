<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PUP Taguig Dental Clinic | Reports</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
  
  <script>
    tailwind.config = {
      daisyui: {
        themes: false
      }
    }
  </script>

  <style>
            :root {
      --crimson: #8B0000;
      --crimson-dark: #6b0000;
      --crimson-light: #fef2f2;
      --crimson-mid: #fce8e8;
      --sidebar-w: 256px;
      --header-h: 64px;
    }

    body {
      font-family: 'Inter', sans-serif;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(6px)
      }

      to {
        opacity: 1;
        transform: translateY(0)
      }
    }

    .fade-in {
      animation: fadeIn .6s ease-out forwards;
    }

    @keyframes shimmer {
      0% {
        transform: translateX(-100%) skewX(-15deg)
      }

      100% {
        transform: translateX(300%) skewX(-15deg)
      }
    }

    .btn-shimmer {
      position: relative;
      overflow: hidden;
    }

    .btn-shimmer::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 40%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .25), transparent);
      animation: shimmer 2.4s infinite;
    }

    /* KPI */
    .kpi-card {
      background: white;
      border-radius: 14px;
      padding: 18px 22px;
      display: flex;
      align-items: center;
      gap: 16px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
      border: 1.5px solid #f0f0f0;
      transition: transform .2s, box-shadow .2s;
      text-decoration: none;
    }

    .kpi-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(139, 0, 0, .10);
    }

    .kpi-icon {
      width: 46px;
      height: 46px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      flex-shrink: 0;
    }

    .kpi-value {
      font-size: 1.55rem;
      font-weight: 800;
      line-height: 1;
      color: #1a1a1a;
    }

    .kpi-label {
      font-size: .72rem;
      font-weight: 500;
      color: #888;
      margin-top: 3px;
      letter-spacing: .03em;
      text-transform: uppercase;
    }

    .kpi-delta {
      font-size: .7rem;
      font-weight: 600;
      margin-top: 4px;
    }

    .kpi-delta.up {
      color: #16a34a;
    }

    .kpi-delta.down {
      color: #dc2626;
    }

    .kpi-arrow {
      margin-left: auto;
      color: #ccc;
      font-size: .75rem;
      align-self: center;
    }

    .kpi-card:hover .kpi-arrow {
      color: #8B0000;
    }

    /* Chart card */
    .chart-card {
      background: white;
      border-radius: 14px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
      border: 1.5px solid #f0f0f0;
      padding: 20px;
    }

    .chart-card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 12px;
    }

    .chart-title {
      font-size: .88rem;
      font-weight: 700;
      color: #8B0000;
    }

    .period-select {
      font-size: .72rem;
      font-weight: 600;
      color: #8B0000;
      background: #fff5f5;
      border: 1.5px solid #f9b2b2;
      border-radius: 20px;
      padding: 3px 24px 3px 12px;
      cursor: pointer;
      outline: none;
      appearance: none;
      -webkit-appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238B0000'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 8px center;
    }

    /* Quick buttons */
    .quick-btn {
      position: relative;
      flex: 1;
      border-radius: 14px;
      overflow: hidden;
      background: linear-gradient(135deg, #8B0000 0%, #5a0000 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 8px;
      color: white;
      font-weight: 700;
      font-size: .85rem;
      text-align: center;
      padding: 16px;
      transition: transform .2s, box-shadow .2s;
      box-shadow: 0 4px 16px rgba(139, 0, 0, .25);
      text-decoration: none;
    }

    .quick-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 28px rgba(139, 0, 0, .35);
    }

    .quick-btn .qb-icon {
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, .15);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }

    .quick-btn::before {
      content: '';
      position: absolute;
      top: -30%;
      right: -20%;
      width: 100px;
      height: 100px;
      background: rgba(255, 215, 0, .12);
      border-radius: 50%;
    }

    /* Stock bars */
    .stock-row {
      padding: 10px 0;
      border-bottom: 1px solid #f5f5f5;
    }

    .stock-name {
      font-size: .78rem;
      font-weight: 600;
      color: #333;
      margin-bottom: 6px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .stock-bar-bg {
      height: 7px;
      background: #f0f0f0;
      border-radius: 10px;
      overflow: hidden;
    }

    .stock-bar-fill {
      height: 100%;
      border-radius: 10px;
      transition: width .8s cubic-bezier(.4, 0, .2, 1);
    }

    /* Chart empty state */
    .chart-empty {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
      gap: 10px;
      color: #bbb;
    }

    .chart-empty i {
      font-size: 2rem;
    }

    .chart-empty p {
      font-size: .8rem;
      font-weight: 600;
    }

    .chart-empty span {
      font-size: .72rem;
      color: #ccc;
    }

    /* Chart loading spinner */
    .chart-loading {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
    }

    .chart-loading i {
      font-size: 1.5rem;
      color: #8B0000;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    /* ════════════════════════════════
       HEADER
    ════════════════════════════════ */
    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 50;
      height: var(--header-h);
      background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 100%);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1.5rem;
      box-shadow: 0 1px 0 rgba(255, 255, 255, .08), 0 4px 24px rgba(139, 0, 0, .3);
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: .75rem;
    }

    .header-logo {
      width: 34px;
      height: 34px;
      object-fit: contain;
      filter: drop-shadow(0 2px 4px rgba(0, 0, 0, .2));
    }

    .header-divider {
      width: 1px;
      height: 28px;
      background: rgba(255, 255, 255, .2);
      margin: 0 .25rem;
    }

    .header-title {
      font-size: .85rem;
      font-weight: 700;
      color: #fff;
      letter-spacing: .02em;
      text-transform: uppercase;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: .75rem;
    }

    .hdr-icon-btn {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: rgba(255, 255, 255, .1);
      border: 1px solid rgba(255, 255, 255, .12);
      color: #fff;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .9rem;
      transition: background .15s, transform .15s;
      position: relative;
    }

        .hdr-icon-btn i,
    .hdr-icon-btn svg {
      display: block;
      line-height: 1;
      margin: 0;
    }

    .hdr-icon-btn:hover {
      background: rgba(255, 255, 255, .2);
      transform: translateY(-1px);
    }

    .notif-badge {
      position: absolute;
      top: -4px;
      right: -4px;
      background: #ff4757;
      color: #fff;
      font-size: .58rem;
      font-weight: 800;
      width: 17px;
      height: 17px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px solid var(--crimson);
      box-shadow: 0 2px 6px rgba(255, 71, 87, .5);
    }

    .header-user-btn {
      display: flex;
      align-items: center;
      gap: .6rem;
      padding: .35rem .75rem .35rem .35rem;
      background: rgba(255, 255, 255, .1);
      border: 1px solid rgba(255, 255, 255, .12);
      border-radius: 40px;
      cursor: pointer;
      transition: background .15s;
    }

    .header-user-btn:hover {
      background: rgba(255, 255, 255, .18);
    }

    .header-avatar {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      border: 2px solid rgba(255, 255, 255, .4);
      object-fit: cover;
    }

    .header-user-text {
      line-height: 1;
    }

    .header-name {
      font-size: .78rem;
      font-weight: 700;
      color: #fff;
    }

    .header-role {
      font-size: .64rem;
      color: rgba(255, 255, 255, .65);
      margin-top: 2px;
    }

    /* Notification dropdown */
    #notifDropdown {
      position: relative;
    }

    #notifMenu {
      position: absolute;
      right: 0;
      top: calc(100% + 10px);
      width: 320px;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, .15), 0 0 0 1px rgba(0, 0, 0, .06);
      opacity: 0;
      transform: scale(.95) translateY(-8px);
      pointer-events: none;
      transition: all .2s cubic-bezier(.4, 0, .2, 1);
      transform-origin: top right;
      z-index: 100;
      overflow: hidden;
    }

    #notifMenu.open {
      opacity: 1;
      transform: scale(1) translateY(0);
      pointer-events: auto;
    }

    .notif-header {
      padding: .85rem 1.1rem .7rem;
      font-weight: 800;
      color: var(--crimson);
      font-size: .8rem;
      border-bottom: 1px solid #fce8e8;
      display: flex;
      align-items: center;
      gap: .5rem;
    }

    #mainContent {
      margin-left: 220px;
      transition: margin-left .25s cubic-bezier(.4, 0, .2, 1);
    }

    @media (max-width: 767px) {
      #mainContent {
        margin-left: 0 !important;
      }
    }

    /* ════════════════════════════════
       SIDEBAR
    ════════════════════════════════ */
    #sidebar {
      position: fixed;
      left: 0;
      top: var(--header-h);
      width: 220px;
      width: var(--sidebar-w);
      height: calc(100vh - var(--header-h));
      background: #fff;
      border-right: 1px solid #eff0f2;
      box-shadow: 4px 0 24px rgba(0, 0, 0, .04);
      z-index: 40;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .sidebar-inner {
      flex: 1;
      overflow-y: auto;
      overflow-x: hidden;
      padding: 16px 10px 8px;
    }

    /* ── Sidebar nav items ── */
    .sidebar-nav-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 10px;
      border-radius: 10px;
      text-decoration: none;
      color: #4a5568;
      font-size: .78rem;
      font-weight: 600;
      transition: all .15s ease;
      white-space: nowrap;
      overflow: hidden;
      position: relative;
    }

    .sidebar-nav-item:hover {
      background: #fef2f2;
      color: #8B0000;
    }

    .sidebar-nav-item.active {
      background: linear-gradient(135deg, #8B0000, #6b0000);
      color: #fff;
      box-shadow: 0 3px 10px rgba(139, 0, 0, .25);
    }

    .sidebar-nav-icon {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: rgba(139, 0, 0, .07);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      flex-shrink: 0;
      color: #8B0000;
      transition: background .15s;
    }

    .sidebar-nav-item.active .sidebar-nav-icon {
      background: rgba(255, 255, 255, .2);
      color: #fff;
    }

    .sidebar-nav-text {
      flex: 1;
      overflow: hidden;
      transition: opacity .2s, max-width .25s;
      max-width: 160px;
      opacity: 1;
    }

    /* Collapsed state */
    #sidebar.collapsed {
      width: 64px !important;
    }

    #sidebar.collapsed .sidebar-nav-text {
      display: none;
    }

    #sidebar.collapsed .nav-section-label,
    #sidebar.collapsed #sidebarNavLabel {
      display: none;
    }

    #sidebar.collapsed .sidebar-nav-item {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 8px;
      width: 48px;
      gap: 0;
    }

    #sidebar.collapsed .theme-option {
      width: 100%;
      padding: 6px 0;
    }

    #sidebar.collapsed .sidebar-inner {
      padding: 16px 0 8px;
    }

    #sidebar.collapsed nav {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 2px;
      width: 100%;
    }

    #sidebar.collapsed .sidebar-nav-icon {
      margin: 0;
      flex-shrink: 0;
    }

    #sidebar.collapsed #sidebarToggleBtn {
      margin: 0 auto;
    }

    #sidebar.collapsed>.sidebar-inner>div:first-child {
      display: flex;
      justify-content: center;
      padding: 0;
      margin-bottom: 12px;
    }

    .nav-section-label {
      font-size: .6rem;
      font-weight: 800;
      color: #b0b7c3;
      text-transform: uppercase;
      letter-spacing: .1em;
      padding: 0 8px 6px;
      margin-top: 4px;
    }

    .nav-group {
      margin-bottom: 2px;
    }

    .group-trigger {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 10px;
      border-radius: 10px;
      cursor: default;
    }

    .group-icon-wrap {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: var(--crimson-light);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      color: var(--crimson);
      flex-shrink: 0;
      transition: all .2s;
    }

    .active-group .group-icon-wrap {
      background: var(--crimson);
      color: #fff;
      box-shadow: 0 4px 12px rgba(139, 0, 0, .3);
    }

    .group-text {
      flex: 1;
      overflow: hidden;
    }

    .group-label {
      font-size: .7rem;
      font-weight: 800;
      color: var(--crimson);
      display: block;
      text-transform: uppercase;
      letter-spacing: .06em;
      white-space: nowrap;
    }

    .group-sublabel {
      font-size: .62rem;
      color: #adb5bd;
      display: block;
      margin-top: 1px;
      white-space: nowrap;
    }

    .group-body {
      padding: 2px 0 6px;
    }

    .nav-link {
      display: flex;
      align-items: center;
      gap: 9px;
      padding: 7px 10px 7px 42px;
      border-radius: 9px;
      margin: 1px 2px;
      font-size: .76rem;
      font-weight: 500;
      color: #4a5568;
      text-decoration: none;
      transition: all .15s;
      white-space: nowrap;
    }

    .nav-link:hover {
      background: var(--crimson-light);
      color: var(--crimson);
    }

    .nav-link.active {
      background: linear-gradient(135deg, var(--crimson) 0%, var(--crimson-dark) 100%);
      color: #fff;
      box-shadow: 0 3px 10px rgba(139, 0, 0, .25);
      font-weight: 600;
    }

    .nav-link.active:hover {
      padding-left: 14px;
      background: #8B0000;
    }

    .nav-link i {
      width: 14px;
      text-align: center;
      font-size: 11px;
      flex-shrink: 0;
    }

    .nav-sep {
      height: 1px;
      background: #f3f4f6;
      margin: 10px 6px;
    }

    .theme-toggle-container {
      position: relative;
      display: flex;
      align-items: center;
      width: 100%;
      height: 36px;
      background: #f3f4f6;
      border: 1px solid #e5e7eb;
      border-radius: 40px;
      padding: 3px;
    }

    .theme-option {
      position: relative;
      z-index: 2;
      flex: 1;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: transparent;
      border: none;
      cursor: pointer;
      color: #9ca3af;
      transition: color .2s;
      border-radius: 40px;
      font-size: 13px;
    }

    .theme-option.active {
      color: #374151;
    }

    .theme-indicator {
      position: absolute;
      background: #fff;
      border-radius: 40px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
      transition: all .3s cubic-bezier(.4, 0, .2, 1);
      pointer-events: none;
      width: calc(50% - 3px);
      height: calc(100% - 6px);
      left: 3px;
      top: 3px;
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
      font-size: .76rem;
      font-weight: 600;
      transition: background .15s;
      margin-top: 6px;
      font-family: 'Inter', sans-serif;
    }

    .logout-btn:hover {
      background: #fef2f2;
    }

    .logout-icon {
      width: 28px;
      height: 28px;
      background: #fef2f2;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-size: 11px;
    }

    body,
    #sidebar,
    main,
    .card,
    .modal-box {
      transition: background-color .3s ease, color .3s ease;
    }

    /* ════════════════════════════════
       FOOTER
    ════════════════════════════════ */
    #siteFooter {
      background: var(--crimson);
      color: rgba(255, 255, 255, .8);
      padding: 1.25rem 2rem;
    }

    .footer-inner {
      max-width: 1280px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1.5rem;
      flex-wrap: wrap;
      font-size: .74rem;
    }

    .footer-inner a {
      color: rgba(255, 255, 255, .7);
      text-decoration: none;
      transition: color .15s;
    }

    .footer-inner a:hover {
      color: #fff;
    }

    .footer-dot {
      color: rgba(255, 255, 255, .3);
    }

    /* ── LAYOUT ── */
    #mainContent,
    #siteFooter {
      margin-left: 256px;
    }

    /* ════════════════════════════════
       MOBILE DRAWER
    ════════════════════════════════ */
    #mobileMenuBtn {
      display: none;
      background: rgba(255, 255, 255, .12);
      border: none;
      color: #fff;
      width: 36px;
      height: 36px;
      border-radius: 9px;
      cursor: pointer;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      transition: background .15s;
      flex-shrink: 0;
    }

    #mobileMenuBtn:hover {
      background: rgba(255, 255, 255, .22);
    }

    #mobileDrawerOverlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .45);
      z-index: 998;
      backdrop-filter: blur(2px);
      opacity: 0;
      pointer-events: none;
      transition: opacity .25s;
    }

    #mobileDrawerOverlay.open {
      opacity: 1;
      pointer-events: auto;
    }

    #mobileDrawer {
      position: fixed;
      top: 0;
      left: 0;
      width: 280px;
      height: 100vh;
      background: #fff;
      z-index: 999;
      display: flex;
      flex-direction: column;
      transform: translateX(-100%);
      transition: transform .3s cubic-bezier(.4, 0, .2, 1);
      box-shadow: 4px 0 32px rgba(0, 0, 0, .15);
      overflow: hidden;
    }

    #mobileDrawer.open {
      transform: translateX(0);
    }

    .drawer-header {
      background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 100%);
      padding: 20px 18px 16px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-shrink: 0;
    }

    .drawer-header-left {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .drawer-logo {
      width: 30px;
      height: 30px;
      object-fit: contain;
    }

    .drawer-title {
      font-size: .82rem;
      font-weight: 800;
      color: #fff;
      line-height: 1.2;
    }

    .drawer-subtitle {
      font-size: .7rem;
      color: rgba(255, 255, 255, .7);
    }

    .drawer-close {
      width: 30px;
      height: 30px;
      border-radius: 8px;
      background: rgba(255, 255, 255, .15);
      border: none;
      color: #fff;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      transition: background .15s;
    }

    .drawer-close:hover {
      background: rgba(255, 255, 255, .28);
    }

    .drawer-user {
      padding: 12px 16px;
      border-bottom: 1px solid #f3f4f6;
      display: flex;
      align-items: center;
      gap: 10px;
      background: #fdf9f9;
      flex-shrink: 0;
    }

    .drawer-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      border: 2px solid #e5e7eb;
      object-fit: cover;
    }

    .drawer-user-name {
      font-size: .8rem;
      font-weight: 700;
      color: #1f2937;
    }

    .drawer-user-role {
      font-size: .66rem;
      color: #9ca3af;
    }

    .drawer-inner {
      flex: 1;
      overflow-y: auto;
      padding: 10px 8px 6px;
    }

    .drawer-group {
      margin-bottom: 2px;
    }

    .drawer-group-header {
      display: flex;
      align-items: center;
      padding: 6px 8px 4px;
      gap: 8px;
    }

    .drawer-group-icon {
      color: var(--crimson);
      font-size: 12px;
    }

    .drawer-group-label {
      font-size: .65rem;
      font-weight: 800;
      color: var(--crimson);
      text-transform: uppercase;
      letter-spacing: .07em;
    }

    .drawer-link {
      display: flex;
      align-items: center;
      gap: 9px;
      padding: 7px 10px 7px 28px;
      border-radius: 8px;
      margin: 1px 2px;
      font-size: .76rem;
      font-weight: 500;
      color: #374151;
      text-decoration: none;
      transition: all .15s;
    }

    .drawer-link:hover {
      background: var(--crimson-light);
      color: var(--crimson);
    }

    .drawer-link.active {
      background: var(--crimson);
      color: #fff;
      box-shadow: 0 2px 8px rgba(139, 0, 0, .2);
    }

    .drawer-link i {
      width: 14px;
      text-align: center;
      font-size: 11px;
    }

    .drawer-sep {
      height: 1px;
      background: #f3f4f6;
      margin: 8px 10px;
    }

    .drawer-bottom {
      padding: 10px 10px 14px;
      border-top: 1px solid #f3f4f6;
      flex-shrink: 0;
    }

    .drawer-brand {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .drawer-brand-text {
      font-size: .75rem;
      font-weight: 800;
      color: #fff;
      letter-spacing: .03em;
      line-height: 1.25;
      text-transform: uppercase;
    }

    .drawer-nav {
      flex: 1;
      overflow-y: auto;
      padding: 10px 10px 6px;
    }

    .drawer-section-label {
      font-size: .6rem;
      font-weight: 800;
      color: #b0b7c3;
      text-transform: uppercase;
      letter-spacing: .1em;
      padding: 6px 8px 8px;
    }

    .drawer-nav-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 12px;
      border-radius: 10px;
      text-decoration: none;
      color: #4a5568;
      font-size: .8rem;
      font-weight: 600;
      transition: all .15s ease;
      margin-bottom: 3px;
    }

    .drawer-nav-link:hover {
      background: #fef2f2;
      color: #8B0000;
      transform: translateX(3px);
    }

    .drawer-nav-link.active {
      background: linear-gradient(135deg, #8B0000, #6b0000);
      color: #fff;
      box-shadow: 0 3px 12px rgba(139, 0, 0, .25);
    }

    .dnav-icon {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: rgba(139, 0, 0, .08);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      flex-shrink: 0;
      transition: background .15s;
      color: #8B0000;
    }

    .drawer-nav-link.active .dnav-icon {
      background: rgba(255, 255, 255, .2);
      color: #fff;
    }

    .drawer-nav-link:hover:not(.active) .dnav-icon {
      background: #fce8e8;
    }

    .drawer-footer {
      padding: 10px 12px 16px;
      border-top: 1px solid #f3f4f6;
      flex-shrink: 0;
    }

    .drawer-avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      border: 2px solid #e5c8c8;
      object-fit: cover;
      flex-shrink: 0;
    }

    .drawer-user-name {
      font-size: .82rem;
      font-weight: 800;
      color: #1f2937;
    }

    .drawer-user-role {
      font-size: .67rem;
      color: #9ca3af;
      margin-top: 1px;
    }

    .drawer-close-btn {
      width: 30px;
      height: 30px;
      border-radius: 8px;
      background: rgba(255, 255, 255, .15);
      border: none;
      color: #fff;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      transition: background .15s;
      flex-shrink: 0;
    }

    .drawer-close-btn:hover {
      background: rgba(255, 255, 255, .28);
    }

    /* User dropdown */
    #userDropdown {
      position: relative;
    }

    #userMenu {
      position: absolute;
      right: 0;
      top: calc(100% + 10px);
      width: 200px;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, .15), 0 0 0 1px rgba(0, 0, 0, .06);
      opacity: 0;
      transform: scale(.95) translateY(-8px);
      pointer-events: none;
      transition: all .2s cubic-bezier(.4, 0, .2, 1);
      transform-origin: top right;
      z-index: 100;
      overflow: hidden;
    }

    #userMenu.open {
      opacity: 1;
      transform: scale(1) translateY(0);
      pointer-events: auto;
    }

    .user-menu-header {
      padding: .85rem 1rem .7rem;
      border-bottom: 1px solid #f3f4f6;
      display: flex;
      align-items: center;
      gap: .6rem;
    }

    .user-menu-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      border: 2px solid #e5e7eb;
      object-fit: cover;
      flex-shrink: 0;
    }

    .user-menu-name {
      font-size: .78rem;
      font-weight: 800;
      color: #1a202c;
    }

    .user-menu-role {
      font-size: .65rem;
      color: #9ca3af;
    }

    .user-menu-item {
      display: flex;
      align-items: center;
      gap: .65rem;
      padding: .65rem 1rem;
      font-size: .76rem;
      font-weight: 600;
      color: #374151;
      text-decoration: none;
      cursor: pointer;
      transition: background .12s;
      border: none;
      background: none;
      width: 100%;
      text-align: left;
      font-family: 'Inter', sans-serif;
    }

    .user-menu-item:hover {
      background: #f9fafb;
    }

    .user-menu-item i {
      width: 14px;
      text-align: center;
      color: #9ca3af;
      font-size: 12px;
    }

    .user-menu-item.danger {
      color: #ef4444;
    }

    .user-menu-item.danger i {
      color: #ef4444;
    }

    .user-menu-item.danger:hover {
      background: #fef2f2;
    }

    .user-menu-sep {
      height: 1px;
      background: #f3f4f6;
      margin: 3px 0;
    }

    /* Dark mode user menu */
    [data-theme="dark"] #userMenu {
      background: #161b22;
      box-shadow: 0 12px 40px rgba(0, 0, 0, .4), 0 0 0 1px rgba(255, 255, 255, .06);
    }

    [data-theme="dark"] .user-menu-header {
      border-color: #21262d;
    }

    [data-theme="dark"] .user-menu-name {
      color: #f3f4f6;
    }

    [data-theme="dark"] .user-menu-item {
      color: #d1d5db;
    }

    [data-theme="dark"] .user-menu-item:hover {
      background: #1c2128;
    }

    [data-theme="dark"] .user-menu-item.danger {
      color: #f87171;
    }

    [data-theme="dark"] .user-menu-item.danger:hover {
      background: rgba(239, 68, 68, .1);
    }

    [data-theme="dark"] .user-menu-sep {
      background: #21262d;
    }

    /* Dark mode */
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

    @media (max-width: 767px) {
      #sidebar {
        display: none !important;
      }

      #mainContent,
      #siteFooter {
        margin-left: 0 !important;
      }

      #mobileMenuBtn {
        display: flex;
      }

      .header {
        padding: 0 1rem;
      }

      .header-title {
        display: none;
      }
    }

  </style>
</head>

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<body class="bg-[#f4f4f6] min-h-screen flex flex-col">

  <!-- ════════ HEADER ════════ -->
  <header class="header">
    <div class="header-left">
      <button id="mobileMenuBtn" onclick="openDrawer()" aria-label="Open menu">
        <i class="fa-solid fa-bars"></i>
      </button>
      <img src="{{ asset('images/PUP.png') }}" class="header-logo" alt="PUP">
      <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" class="header-logo" alt="DMS">
      <div class="header-divider"></div>
      <span class="header-title">PUP Taguig Dental Clinic</span>
    </div>
    <div class="header-right">
      @php $notifications = collect($notifications ?? []); $notifCount = $notifications->count(); @endphp
      <div id="notifDropdown">
        <button class="hdr-icon-btn" id="notifBtn" aria-label="Notifications">
          <i class="fa-regular fa-bell"></i>
          @if($notifCount > 0)<span class="notif-badge">{{ $notifCount }}</span>@endif
        </button>
        <div id="notifMenu">
          <div class="notif-header"><i class="fa-solid fa-bell text-xs"></i> Notifications</div>
          <div style="max-height:260px;overflow-y:auto;">
            @forelse($notifications as $n)
            <a href="{{ $n['url'] ?? '#' }}"
              style="display:block;padding:.65rem 1rem;font-size:.76rem;color:#333;text-decoration:none;border-bottom:1px solid #fdf5f5;transition:background .1s;"
              onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background=''">
              <div style="font-weight:700;">{{ $n['title'] ?? 'Notification' }}</div>
              @if(!empty($n['message']))<div style="color:#aaa;margin-top:2px;font-size:.7rem;">{{ $n['message'] }}
              </div>@endif
            </a>
            @empty
            <div style="padding:2.5rem 1rem;text-align:center;color:#bbb;font-size:.76rem;">
              <i class="fa-regular fa-bell-slash" style="font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>
              You're all caught up.
            </div>
            @endforelse
          </div>
        </div>
      </div>

      <div id="userDropdown">
        <div class="header-user-btn" id="userBtn">
          <img src="{{ asset('images/Nelson-Angeles.jpg') }}" alt="Dr. Nelson P. Angeles" class="header-avatar"
            onerror="this.src='https://ui-avatars.com/api/?name=Nelson+Angeles&background=660000&color=FFFFFF&size=88'">
          <div class="header-user-text">
            <div class="header-name">Dr. Nelson P. Angeles</div>
            <div class="header-role">Dentist</div>
          </div>
          <i class="fa-solid fa-chevron-down"
            style="color:rgba(255,255,255,.5);font-size:.6rem;margin-left:.25rem;"></i>
        </div>
        <div id="userMenu">
          <div class="user-menu-header">
            <img src="{{ asset('images/Nelson-Angeles.jpg') }}" alt="Dr. Nelson P. Angeles" class="header-avatar"
              onerror="this.src='https://ui-avatars.com/api/?name=Nelson+Angeles&background=660000&color=FFFFFF&size=88'">
            <div>
              <div class="user-menu-name">Dr. Nelson P. Angeles</div>
              <div class="user-menu-role">Dentist</div>
            </div>
          </div>
          <!-- Dark mode toggle inside dropdown -->
          <div style="padding:.5rem .75rem; border-bottom:1px solid #f3f4f6;">
            <div
              style="font-size:.6rem;font-weight:800;letter-spacing:.08em;color:#b0b7c3;text-transform:uppercase;margin-bottom:6px;">
              Appearance</div>
            <div class="theme-toggle-container" id="userMenuThemeToggle">
              <button type="button" class="theme-option active" data-theme="light"><i
                  class="fa-solid fa-sun"></i></button>
              <button type="button" class="theme-option" data-theme="dark"><i class="fa-regular fa-moon"></i></button>
              <div class="theme-indicator" aria-hidden="true"></div>
            </div>
          </div>
          <div class="user-menu-sep"></div>
          <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="user-menu-item danger">
              <i class="fa-solid fa-right-from-bracket"></i>
              Log out
            </button>
          </form>
        </div>
      </div>
    </div>
  </header>

   <!-- SIDEBAR -->
  <aside id="sidebar" style="width:220px;">
    <div class="sidebar-inner">
      <!-- Toggle button -->
      <div style="display:flex;justify-content:flex-end;margin-bottom:12px;">
        <button onclick="toggleSidebar()" id="sidebarToggleBtn"
          style="width:30px;height:30px;border-radius:8px;border:none;background:#fef2f2;color:#8B0000;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:13px;transition:background .15s;"
          onmouseover="this.style.background='#fce8e8'" onmouseout="this.style.background='#fef2f2'">
          <i id="sidebarIcon" class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <div class="nav-section-label" id="sidebarNavLabel">Navigation</div>

      <nav style="display:flex;flex-direction:column;gap:2px;">
        @foreach([
        ['route'=>'dentist.dentist.dashboard', 'icon'=>'fa-chart-line', 'label'=>'Dashboard'],
        ['route'=>'dentist.dentist.patients', 'icon'=>'fa-users', 'label'=>'Patients'],
        ['route'=>'dentist.dentist.appointments', 'icon'=>'fa-calendar-check', 'label'=>'Appointments'],
        ['route'=>'dentist.dentist.documentrequests', 'icon'=>'fa-file-circle-check', 'label'=>'Document Requests'],
        ['route'=>'dentist.dentist.inventory', 'icon'=>'fa-box', 'label'=>'Inventory'],
        ['route'=>'dentist.dentist.report', 'icon'=>'fa-file', 'label'=>'Reports'],
        ] as $nav)
        <a href="{{ route($nav['route']) }}" title="{{ $nav['label'] }}"
          class="sidebar-nav-item {{ request()->routeIs($nav['route']) ? 'active' : '' }}">
          <span class="sidebar-nav-icon"><i class="fa-solid {{ $nav['icon'] }}"></i></span>
          <span class="sidebar-nav-text">{{ $nav['label'] }}</span>
        </a>
        @endforeach
      </nav>
    </div>
  </aside>

  <!-- MOBILE DRAWER OVERLAY -->
  <div id="mobileDrawerOverlay" onclick="closeDrawer()"></div>

  <!-- MOBILE DRAWER -->
  <div id="mobileDrawer">
    <div class="drawer-header">
      <div class="drawer-brand">
        <img src="{{ asset('images/PUP.png') }}"
          style="width:26px;height:26px;object-fit:contain;filter:drop-shadow(0 1px 3px rgba(0,0,0,.3));" alt="PUP">
        <img src="{{ asset('images/PUPT-DMS-Logo.png') }}" style="width:24px;height:24px;object-fit:contain;" alt="DMS">
        <span class="drawer-brand-text">PUP Taguig<br>Dental Clinic</span>
      </div>
      <button class="drawer-close-btn" onclick="closeDrawer()">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <nav class="drawer-nav">
      <div class="drawer-section-label">Navigation</div>
      @foreach([
      ['route'=>'dentist.dentist.dashboard', 'icon'=>'fa-chart-line', 'label'=>'Dashboard'],
      ['route'=>'dentist.dentist.patients', 'icon'=>'fa-users', 'label'=>'Patients'],
      ['route'=>'dentist.dentist.appointments', 'icon'=>'fa-calendar-check', 'label'=>'Appointments'],
      ['route'=>'dentist.dentist.documentrequests', 'icon'=>'fa-file-circle-check', 'label'=>'Document Requests'],
      ['route'=>'dentist.dentist.inventory', 'icon'=>'fa-box', 'label'=>'Inventory'],
      ['route'=>'dentist.dentist.report', 'icon'=>'fa-file', 'label'=>'Reports'],
      ] as $nav)
      <a href="{{ route($nav['route']) }}"
        class="drawer-nav-link {{ request()->routeIs($nav['route']) ? 'active' : '' }}">
        <span class="dnav-icon"><i class="fa-solid {{ $nav['icon'] }}"></i></span>
        {{ $nav['label'] }}
      </a>
      @endforeach
    </nav>

    <div class="drawer-footer">
      <form method="POST" action="{{ route('logout') }}" style="margin:0;">
        @csrf
        <button type="submit"
          style="width:100%;display:flex;align-items:center;gap:.6rem;padding:.6rem .75rem;border-radius:10px;border:1px solid #fce8e8;background:#fdf5f5;color:#8B0000;font-size:.8rem;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;transition:background .15s;">
          <i class="fa-solid fa-right-from-bracket"></i> Log out
        </button>
      </form>
    </div>
  </div>

  <!-- MAIN -->
  <main id="mainContent" class="pt-[100px] px-6 py-6 min-h-screen fade-in" style="margin-left:220px;">
    <div class="max-w-7xl mt-4 mx-auto">

      <!-- PAGE TITLE -->
      <div class="flex items-center justify-between mb-6">
        <div>
          <h1 class="text-2xl font-bold text-[#660000]">Reports &amp; Analytics</h1>
          <p class="text-xs text-gray-500 mt-0.5">Overview of clinic data, trends, and inventory status</p>
        </div>
        <span class="text-xs text-gray-400 font-medium">
          <i class="fa-regular fa-clock mr-1"></i> Last updated: {{ now()->format('M d, Y h:i A') }}
        </span>
      </div>

      <!-- KPI STRIP -->
      <div class="grid grid-cols-4 gap-4 mb-7">

        <a href="{{ route('dentist.dentist.patients') }}" class="kpi-card">
          <div class="kpi-icon" style="background:#fff0f0;"><i class="fa-solid fa-users" style="color:#8B0000;"></i></div>
          <div class="flex-1">
            <div class="kpi-value">{{ $patientsThisMonth }}</div>
            <div class="kpi-label">Patients This Month</div>
            @if(!is_null($patientsDelta))
            <div class="kpi-delta {{ $patientsDelta >= 0 ? 'up' : 'down' }}">
              <i class="fa-solid fa-arrow-{{ $patientsDelta >= 0 ? 'up' : 'down' }} text-[10px]"></i> {{ abs($patientsDelta) }}% vs last month
            </div>
            @else
            <div class="kpi-delta" style="color:#888;">No data last month</div>
            @endif
          </div>
          <i class="fa-solid fa-chevron-right kpi-arrow"></i>
        </a>

        <a href="{{ route('dentist.dentist.appointments') }}" class="kpi-card">
          <div class="kpi-icon" style="background:#fffbeb;"><i class="fa-solid fa-calendar-check" style="color:#d97706;"></i></div>
          <div class="flex-1">
            <div class="kpi-value">{{ $appointmentsToday }}</div>
            <div class="kpi-label">Appointments Today</div>
            @if($appointmentsDelta > 0)
            <div class="kpi-delta up"><i class="fa-solid fa-arrow-up text-[10px]"></i> {{ $appointmentsDelta }} more than yesterday</div>
            @elseif($appointmentsDelta < 0)
              <div class="kpi-delta down"><i class="fa-solid fa-arrow-down text-[10px]"></i> {{ abs($appointmentsDelta) }} fewer than yesterday
          </div>
          @else
          <div class="kpi-delta" style="color:#888;">Same as yesterday</div>
          @endif
      </div>
      <i class="fa-solid fa-chevron-right kpi-arrow"></i>
      </a>

      <div class="kpi-card">
        <div class="kpi-icon" style="background:#f0fdf4;"><i class="fa-solid fa-tooth" style="color:#16a34a;"></i></div>
        <div>
          <div class="kpi-value">{{ $casesThisMonth }}</div>
          <div class="kpi-label">Dental Cases ({{ now()->format('M') }})</div>
          @if(!is_null($casesDelta))
          <div class="kpi-delta {{ $casesDelta >= 0 ? 'up' : 'down' }}">
            <i class="fa-solid fa-arrow-{{ $casesDelta >= 0 ? 'up' : 'down' }} text-[10px]"></i> {{ abs($casesDelta) }}% vs last month
          </div>
          @else
          <div class="kpi-delta" style="color:#888;">No data last month</div>
          @endif
        </div>
      </div>

      <a href="{{ route('dentist.dentist.inventory') }}" class="kpi-card" style="border-color:#fee2e2;">
        <div class="kpi-icon" style="background:#fff0f0;"><i class="fa-solid fa-triangle-exclamation" style="color:#dc2626;"></i></div>
        <div class="flex-1">
          <div class="kpi-value" style="color:#dc2626;">{{ $lowStockItems }}</div>
          <div class="kpi-label">Low Stock Items</div>
          @if($lowStockItems > 0)
          <div class="kpi-delta down"><i class="fa-solid fa-circle-exclamation text-[10px]"></i> Requires reorder</div>
          @else
          <div class="kpi-delta up"><i class="fa-solid fa-circle-check text-[10px]"></i> All stocked up</div>
          @endif
        </div>
        <i class="fa-solid fa-chevron-right kpi-arrow"></i>
      </a>

    </div>

    <!-- CREATE REPORT BUTTON -->
    <div class="flex justify-center mb-7">
      <button onclick="document.getElementById('createReportModal').showModal()"
        class="btn-shimmer w-full max-w-4xl bg-gradient-to-r from-[#8B0000] via-[#b30000] to-[#FFD700]
                 text-white py-4 rounded-2xl flex items-center justify-center gap-4
                 text-base font-bold shadow-lg hover:opacity-90 transition-opacity">
        <i class="fa-solid fa-file-circle-plus text-xl"></i>
        <span>Create New Report</span>
        <span class="bg-white text-[#8B0000] w-8 h-8 rounded-full flex items-center justify-center text-xl font-bold leading-none">+</span>
      </button>
    </div>

    <!-- CHARTS + QUICK BUTTONS -->
    <div class="grid grid-cols-12 gap-5 mb-5">

      <!-- GAD REPORT -->
      <div class="col-span-5 chart-card">
        <div class="chart-card-header">
          <span class="chart-title"><i class="fa-solid fa-chart-column mr-1.5 opacity-70"></i>GAD Report</span>
          <select class="period-select" id="gadPeriodSelect">
            @foreach($periodOptions as $opt)
            <option>{{ $opt }}</option>
            @endforeach
          </select>
        </div>
        {{-- wrapper toggles between canvas and empty state --}}
        <div id="gadChartWrap" style="height:300px; width:100%; position:relative;">
          <canvas id="gadChart"></canvas>
          <div id="gadEmptyState" class="chart-empty" style="display:none; position:absolute; inset:0;">
            <i class="fa-solid fa-chart-column" style="color:#e5e7eb;"></i>
            <p>No GAD records found</p>
            <span>for the selected period</span>
          </div>
          <div id="gadLoadingState" class="chart-loading" style="display:none; position:absolute; inset:0; background:white;">
            <i class="fa-solid fa-spinner"></i>
          </div>
        </div>
      </div>

      <!-- WEEKLY DENTAL CASES -->
      <div class="col-span-5 chart-card">
        <div class="chart-card-header">
          <span class="chart-title"><i class="fa-solid fa-chart-line mr-1.5 opacity-70"></i>Weekly Dental Cases</span>
          <select class="period-select" id="weeklyPeriodSelect">
            @foreach($periodOptions as $opt)
            <option>{{ $opt }}</option>
            @endforeach
          </select>
        </div>
        <div id="weeklyChartWrap" style="height:300px; width:100%; position:relative;">
          <canvas id="weeklyDentalCasesChart"></canvas>
          <div id="weeklyEmptyState" class="chart-empty" style="display:none; position:absolute; inset:0;">
            <i class="fa-solid fa-chart-line" style="color:#e5e7eb;"></i>
            <p>No appointment data found</p>
            <span>for the selected period</span>
          </div>
          <div id="weeklyLoadingState" class="chart-loading" style="display:none; position:absolute; inset:0; background:white;">
            <i class="fa-solid fa-spinner"></i>
          </div>
        </div>
      </div>

      <!-- QUICK BUTTONS -->
      <div class="col-span-2 flex flex-col gap-4" style="min-height:360px;">
        <a href="{{ route('dentist.dentist.report.dental-services') }}" class="quick-btn">
          <div class="qb-icon"><i class="fa-solid fa-tooth"></i></div>
          <span>Dental Services</span>
        </a>
        <a href="{{ route('dentist.dentist.report.daily-treatment') }}" class="quick-btn">
          <div class="qb-icon"><i class="fa-solid fa-notes-medical"></i></div>
          <span style="line-height:1.3;">Daily Treatment<br>Record</span>
        </a>
      </div>

    </div>

    <!-- INVENTORY ANALYTICS -->
    <div class="chart-card mb-5" style="border:1.5px solid #fde68a;">
      <div class="chart-card-header mb-4">
        <span class="chart-title text-base"><i class="fa-solid fa-boxes-stacked mr-1.5 opacity-70"></i>Inventory Analytics</span>
        <a href="{{ route('dentist.dentist.inventory') }}" class="text-xs font-semibold text-[#8B0000] hover:underline">
          View All <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
      </div>
      <div class="grid grid-cols-12 gap-6 items-start">

        <!-- PIE CHARTS -->
        <div class="col-span-7 grid grid-cols-2 gap-6">
          <div>
            <h3 class="text-center text-xs font-bold text-[#8B0000] mb-3 uppercase tracking-wider">Medicine Inventory</h3>
            <div style="height:280px; width:100%; position:relative;">
              @if($medicineItems->count() > 0)
              <canvas id="medicinePieChart"></canvas>
              @else
              <div class="chart-empty" style="position:absolute; inset:0;">
                <i class="fa-solid fa-capsules" style="color:#e5e7eb;"></i>
                <p>No medicine items</p>
                <span>Add inventory to see chart</span>
              </div>
              @endif
            </div>
          </div>
          <div>
            <h3 class="text-center text-xs font-bold text-[#8B0000] mb-3 uppercase tracking-wider">Medical Supplies Inventory</h3>
            <div style="height:280px; width:100%; position:relative;">
              @if($suppliesItems->count() > 0)
              <canvas id="suppliesPieChart"></canvas>
              @else
              <div class="chart-empty" style="position:absolute; inset:0;">
                <i class="fa-solid fa-box-open" style="color:#e5e7eb;"></i>
                <p>No supply items</p>
                <span>Add inventory to see chart</span>
              </div>
              @endif
            </div>
          </div>
        </div>

        <!-- LOW STOCK PANEL -->
        <div class="col-span-5">
          <div class="flex items-center gap-2 mb-3">
            <i class="fa-solid fa-triangle-exclamation text-red-500 text-sm"></i>
            <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Low Stock Alerts</span>
          </div>

          @if($lowStockMedicine->count() > 0)
          <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Medicine</p>
          @foreach($lowStockMedicine as $item)
          @php
          $remaining = $item->qty - $item->used;
          $pct = $item->qty > 0 ? round(($remaining / $item->qty) * 100) : 0;
          $barClass = $pct <= 15 ? 'bg-red-400' : 'bg-orange-400' ;
            @endphp
            <div class="stock-row">
            <div class="stock-name">
              <span>{{ $item->name }}</span>
              <span class="text-red-500 font-bold text-[11px]">{{ $remaining }} / {{ $item->qty }}</span>
            </div>
            <div class="stock-bar-bg">
              <div class="stock-bar-fill {{ $barClass }}" style="width:{{ $pct }}%"></div>
            </div>
        </div>
        @endforeach
        @endif

        @if($lowStockSupplies->count() > 0)
        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mt-4 mb-2">Medical Supplies</p>
        @foreach($lowStockSupplies as $item)
        @php
        $remaining = $item->qty - $item->used;
        $pct = $item->qty > 0 ? round(($remaining / $item->qty) * 100) : 0;
        $barClass = $pct <= 15 ? 'bg-red-400' : 'bg-orange-400' ;
          @endphp
          <div class="stock-row">
          <div class="stock-name">
            <span>{{ $item->name }}</span>
            <span class="text-red-500 font-bold text-[11px]">{{ $remaining }} / {{ $item->qty }}</span>
          </div>
          <div class="stock-bar-bg">
            <div class="stock-bar-fill {{ $barClass }}" style="width:{{ $pct }}%"></div>
          </div>
      </div>
      @endforeach
      @endif

      @if($lowStockMedicine->count() === 0 && $lowStockSupplies->count() === 0)
      <div class="flex flex-col items-center justify-center h-full py-8 text-center min-h-[200px]">
        <i class="fa-solid fa-circle-check text-green-400 text-3xl mb-2"></i>
        <p class="text-sm font-semibold text-green-600">No low stock items found.</p>
        <p class="text-xs text-gray-400 mt-1">No reorder needed at this time.</p>
      </div>
      @endif
    </div>

    </div>
    </div>

    </div>
  </main>

  <!-- CREATE REPORT MODAL -->
  <dialog id="createReportModal" class="modal">
    <div class="modal-box max-w-xl p-0 rounded-2xl overflow-hidden bg-white shadow-2xl flex flex-col" style="max-height:min(90vh,640px);">
      <div class="bg-gradient-to-r from-[#8B0000] to-[#660000] px-6 py-4 flex items-center justify-between flex-shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-file-circle-plus text-white text-base"></i></div>
          <div>
            <h2 class="text-base font-bold text-white leading-tight">Create New Report</h2>
            <p class="text-white/65 text-[11px] mt-0.5">Fields marked <span class="text-yellow-300 font-bold">*</span> are required</p>
          </div>
        </div>
        <button type="button" onclick="closeCreateModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/35 flex items-center justify-center text-white transition-all flex-shrink-0"><i class="fa-solid fa-xmark text-sm"></i></button>
      </div>
      <div class="overflow-y-auto flex-1 px-6 py-5">
        <form id="reportForm" class="space-y-4" novalidate>
          <div>
            <div class="flex items-center justify-between mb-1">
              <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider">Report Name <span class="text-red-500">*</span></label>
              <span id="reportNameCounter" class="text-[11px] font-semibold text-gray-400">0 / 100</span>
            </div>
            <input id="reportName" type="text" maxlength="100" placeholder="e.g. GAD Monthly Report — Dec 2025"
              class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors placeholder-gray-300" />
            <p id="reportNameErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> Report name is required.</p>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">Report Type <span class="text-red-500">*</span></label>
            <div class="relative">
              <select id="reportType" class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors appearance-none pr-10 text-gray-500">
                <option value="" disabled selected>Select a report type...</option>
                <option class="text-gray-800">GAD Report</option>
                <option class="text-gray-800">Medicine Supply Report</option>
                <option class="text-gray-800">Medical Supplies Report</option>
                <option class="text-gray-800">Daily Treatment Record</option>
                <option class="text-gray-800">Dental Services Report</option>
              </select>
              <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-[#8B0000] text-xs pointer-events-none"></i>
            </div>
            <p id="reportTypeErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> Please select a report type.</p>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">Date Range <span class="text-red-500">*</span></label>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <p class="text-[10px] text-gray-400 font-semibold uppercase mb-1">From <span class="text-red-400">*</span></p>
                <input id="dateFrom" type="date" class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors" />
              </div>
              <div>
                <p class="text-[10px] text-gray-400 font-semibold uppercase mb-1">To <span class="text-gray-400 normal-case font-normal">(optional)</span></p>
                <input id="dateTo" type="date" class="w-full px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors" />
              </div>
            </div>
            <p class="text-[10px] text-gray-400 mt-1"><i class="fa-solid fa-circle-info mr-1"></i>Leave "To" empty to report on a single date.</p>
            <p id="dateFromErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> Start date is required.</p>
            <p id="dateFutureErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> Dates cannot be in the future.</p>
            <p id="dateRangeErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> End date must be on or after start date.</p>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-[#8B0000] uppercase tracking-wider mb-1">Quantity <span class="text-red-500">*</span></label>
            <input id="reportQty" type="number" min="1" max="100" step="1" placeholder="1 – 100"
              class="w-36 px-3.5 py-2 rounded-xl border-2 border-gray-200 bg-white text-sm focus:outline-none focus:border-[#8B0000] transition-colors" />
            <span class="text-[11px] text-gray-400 ml-2">Whole numbers only (1–100)</span>
            <p id="reportQtyErr" class="text-red-500 text-xs mt-1 hidden items-center gap-1">
              <i class="fa-solid fa-circle-exclamation"></i> <span id="reportQtyErrMsg">Quantity must be between 1 and 100.</span>
            </p>
          </div>
          <div id="formErrorBanner" class="hidden items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-sm font-medium">
            <i class="fa-solid fa-triangle-exclamation text-red-400 flex-shrink-0"></i>
            Please complete all required fields before downloading.
          </div>
        </form>
      </div>
      <div class="flex-shrink-0 border-t border-gray-100 px-6 py-4 flex justify-end gap-3 bg-white">
        <button type="button" onclick="closeCreateModal()" class="px-5 py-2 rounded-xl border-2 border-gray-200 text-gray-500 text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all">Cancel</button>
        <button type="button" id="downloadReportBtn" class="px-6 py-2 rounded-xl bg-[#8B0000] hover:bg-[#7a0000] text-white text-sm font-bold flex items-center gap-2 shadow-md hover:shadow-lg transition-all">
          <i class="fa-solid fa-download"></i> Download Report
        </button>
      </div>
    </div>
    <form method="dialog" class="modal-backdrop"><button onclick="closeCreateModal()"></button></form>
  </dialog>

  <!-- DOWNLOAD COMPLETE MODAL -->
  <dialog id="downloadCompleteModal" class="modal">
    <div class="modal-box p-0 rounded-2xl overflow-hidden bg-white shadow-2xl max-w-sm">
      <div class="h-1.5 bg-gradient-to-r from-[#8B0000] to-[#FFD700] w-full"></div>
      <div class="px-8 py-10 text-center">
        <div class="w-16 h-16 bg-green-50 border-2 border-green-200 rounded-full flex items-center justify-center mx-auto mb-5"><i class="fa-solid fa-check text-green-500 text-2xl"></i></div>
        <h3 class="text-xl font-bold text-[#8B0000] mb-2">Download Complete!</h3>
        <p class="text-gray-400 text-sm leading-relaxed mb-7">Your report has been successfully generated and downloaded.</p>
        <button onclick="closeDownloadModal()" class="px-8 py-2.5 rounded-xl bg-[#8B0000] hover:bg-[#7A0000] text-white font-bold text-sm shadow-md hover:shadow-lg transition-all duration-300">Done</button>
      </div>
    </div>
  </dialog>

  <!-- FOOTER -->
  <footer id="siteFooter">
    <div class="footer-inner">
      <span style="color:rgba(255,255,255,.5);">© 1998–2026</span>
      <span style="font-weight:700;color:#fff;">Polytechnic University of the Philippines</span>
      <span class="footer-dot">|</span>
      <a href="https://www.pup.edu.ph/terms/">Terms of Use</a>
      <span class="footer-dot">|</span>
      <a href="https://www.pup.edu.ph/privacy/">Privacy Statement</a>
    </div>
  </footer>

  <script>
    const GAD_DATA = {
      labels: @json($gadLabels),
      female: @json($gadFemale),
      male: @json($gadMale)
    };
    const WEEKLY_DATA = {
      labels: @json($weekLabels),
      datasets: @json($weeklyDatasets)
    };
    const MEDICINE_ITEMS = @json($medicineItems);
    const SUPPLIES_ITEMS = @json($suppliesItems);
    const AJAX_GAD_URL = "{{ route('dentist.dentist.report.gad-data') }}";
    const AJAX_WEEKLY_URL = "{{ route('dentist.dentist.report.weekly-data') }}";
    const PIE_COLORS = ['#8B0000', '#b30000', '#cc3333', '#e06666', '#f4cccc', '#d9534f', '#c0392b', '#922b21', '#641e16', '#f1948a'];
  </script>

  <script>
    // ── Mobile Drawer ────────────────────────────────────────────
    function openDrawer() {
      document.getElementById('mobileDrawer').classList.add('open');
      document.getElementById('mobileDrawerOverlay').classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function closeDrawer() {
      document.getElementById('mobileDrawer').classList.remove('open');
      document.getElementById('mobileDrawerOverlay').classList.remove('open');
      document.body.style.overflow = '';
    }

    /* NOTIF */
    document.getElementById('notifBtn').addEventListener('click', e => {
      e.stopPropagation();
      document.getElementById('notifMenu').classList.toggle('open');
    });
    document.addEventListener('click', () => document.getElementById('notifMenu').classList.remove('open'));

    /* USER DROPDOWN */
    document.getElementById('userBtn').addEventListener('click', e => {
      e.stopPropagation();
      document.getElementById('notifMenu').classList.remove('open'); // close notif if open
      document.getElementById('userMenu').classList.toggle('open');
    });
    document.addEventListener('click', () => document.getElementById('userMenu').classList.remove('open'));

    /* Sync user menu theme toggle */
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('#userMenuThemeToggle .theme-option').forEach(o =>
        o.addEventListener('click', e => { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); })
      );
    });

    // ── Theme & Sidebar
    const html = document.documentElement;

    function applyTheme(theme) {
      html.setAttribute('data-theme', theme);
      localStorage.setItem('theme', theme);
      document.querySelectorAll('.theme-option').forEach(o =>
        o.getAttribute('data-theme') === theme ? o.classList.add('active') : o.classList.remove('active'));
      const ind = document.querySelector('.theme-indicator');
      if (ind) theme === 'dark' ? ind.classList.add('dark-mode') : ind.classList.remove('dark-mode');
    }

    let sidebarOpen = true;

    function applyLayout(w) {
      document.getElementById('sidebar').style.width = w;
      document.getElementById('mainContent').style.marginLeft = w;
    }

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const icon = document.getElementById('sidebarIcon');
      const isCollapsed = sidebar.classList.contains('collapsed');

      if (isCollapsed) {
        sidebar.classList.remove('collapsed');
        sidebar.style.width = '220px';
        document.getElementById('mainContent').style.marginLeft = '220px';
        icon.className = 'fa-solid fa-xmark';
      } else {
        sidebar.classList.add('collapsed');
        sidebar.style.width = '64px';
        document.getElementById('mainContent').style.marginLeft = '64px';
        icon.className = 'fa-solid fa-bars';
      }
    }

    function applyLayout(w) {
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('mainContent');
      if (sidebar) sidebar.style.width = w;
      if (main) main.style.marginLeft = w;
    }

    // ── Modal helpers ────────────────────────────────────────────────────────
    function closeCreateModal() {
      document.getElementById('createReportModal').close();
      document.getElementById('reportForm').reset();
      document.getElementById('reportNameCounter').textContent = '0 / 100';
      document.getElementById('reportNameCounter').classList.replace('text-red-500', 'text-gray-400');
      ['reportNameErr', 'reportTypeErr', 'dateFromErr', 'dateFutureErr', 'dateRangeErr', 'reportQtyErr', 'formErrorBanner']
      .forEach(id => {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
      });
      ['reportName', 'reportType', 'dateFrom', 'dateTo', 'reportQty']
      .forEach(id => {
        document.getElementById(id).classList.remove('border-red-400');
        document.getElementById(id).classList.add('border-gray-200');
      });
    }

    function closeDownloadModal() {
      document.getElementById('downloadCompleteModal').close();
    }

    // ── Chart instances (so we can destroy/recreate on period change) ────────
    let gadChartInstance = null;
    let weeklyChartInstance = null;

    // ── Chart helpers ────────────────────────────────────────────────────────
    function showGadEmpty() {
      document.getElementById('gadChart').style.display = 'none';
      document.getElementById('gadEmptyState').style.display = 'flex';
      document.getElementById('gadLoadingState').style.display = 'none';
    }

    function showGadLoading() {
      document.getElementById('gadChart').style.display = 'none';
      document.getElementById('gadEmptyState').style.display = 'none';
      document.getElementById('gadLoadingState').style.display = 'flex';
    }

    function showGadChart() {
      document.getElementById('gadChart').style.display = 'block';
      document.getElementById('gadEmptyState').style.display = 'none';
      document.getElementById('gadLoadingState').style.display = 'none';
    }

    function showWeeklyEmpty() {
      document.getElementById('weeklyDentalCasesChart').style.display = 'none';
      document.getElementById('weeklyEmptyState').style.display = 'flex';
      document.getElementById('weeklyLoadingState').style.display = 'none';
    }

    function showWeeklyLoading() {
      document.getElementById('weeklyDentalCasesChart').style.display = 'none';
      document.getElementById('weeklyEmptyState').style.display = 'none';
      document.getElementById('weeklyLoadingState').style.display = 'flex';
    }

    function showWeeklyChart() {
      document.getElementById('weeklyDentalCasesChart').style.display = 'block';
      document.getElementById('weeklyEmptyState').style.display = 'none';
      document.getElementById('weeklyLoadingState').style.display = 'none';
    }

    function buildGadChart(labels, female, male) {
      if (gadChartInstance) {
        gadChartInstance.destroy();
        gadChartInstance = null;
      }
      gadChartInstance = new Chart(document.getElementById('gadChart'), {
        type: 'bar',
        data: {
          labels,
          datasets: [{
              label: 'Female',
              data: female,
              backgroundColor: '#FFC0CB',
              borderRadius: 4
            },
            {
              label: 'Male',
              data: male,
              backgroundColor: '#89CFF0',
              borderRadius: 4
            },
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          indexAxis: 'y',
          plugins: {
            legend: {
              position: 'top',
              labels: {
                font: {
                  family: 'Inter',
                  size: 12
                }
              }
            },
            tooltip: {
              callbacks: {
                label: ctx => `${ctx.dataset.label}: ${ctx.parsed.x} cases`
              }
            }
          },
          scales: {
            x: {
              beginAtZero: true,
              grid: {
                borderDash: [4, 4]
              },
              title: {
                display: true,
                text: 'Number of Cases',
                font: {
                  family: 'Inter'
                }
              }
            },
            y: {
              grid: {
                display: false
              },
              ticks: {
                font: {
                  family: 'Inter'
                }
              }
            }
          }
        }
      });
    }

    function buildWeeklyChart(labels, datasets) {
      if (weeklyChartInstance) {
        weeklyChartInstance.destroy();
        weeklyChartInstance = null;
      }
      weeklyChartInstance = new Chart(document.getElementById('weeklyDentalCasesChart'), {
        type: 'line',
        data: {
          labels,
          datasets
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'top',
              labels: {
                font: {
                  family: 'Inter',
                  size: 12
                }
              }
            },
            tooltip: {
              callbacks: {
                label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y} cases`
              }
            }
          },
          scales: {
            x: {
              grid: {
                display: false
              },
              ticks: {
                font: {
                  family: 'Inter'
                }
              }
            },
            y: {
              beginAtZero: true,
              grid: {
                borderDash: [4, 4]
              },
              ticks: {
                precision: 0,
                font: {
                  family: 'Inter'
                }
              },
              title: {
                display: true,
                text: 'Dental Cases',
                font: {
                  family: 'Inter'
                }
              }
            }
          }
        }
      });
    }

    function makePieChart(canvasId, items) {
      if (!items || items.length === 0) return;
      new Chart(document.getElementById(canvasId), {
        type: 'doughnut',
        data: {
          labels: items.map(i => i.name),
          datasets: [{
            data: items.map(i => Math.max(0, i.qty - i.used)),
            backgroundColor: PIE_COLORS.slice(0, items.length),
            borderWidth: 2,
            borderColor: '#fff'
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          cutout: '50%',
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                font: {
                  family: 'Inter',
                  size: 10
                },
                boxWidth: 12,
                padding: 8
              }
            },
            tooltip: {
              callbacks: {
                label: ctx => ` ${ctx.label}: ${ctx.parsed} remaining`
              }
            }
          }
        }
      });
    }

    // ── Period dropdown AJAX ─────────────────────────────────────────────────
    async function reloadGadChart(period) {
      showGadLoading();
      try {
        const res = await fetch(`${AJAX_GAD_URL}?period=${encodeURIComponent(period)}`);
        const data = await res.json();
        if (data.empty) {
          showGadEmpty();
          return;
        }
        showGadChart();
        buildGadChart(data.labels, data.female, data.male);
      } catch (e) {
        showGadEmpty();
      }
    }

    async function reloadWeeklyChart(period) {
      showWeeklyLoading();
      try {
        const res = await fetch(`${AJAX_WEEKLY_URL}?period=${encodeURIComponent(period)}`);
        const data = await res.json();
        if (data.empty || !data.datasets || data.datasets.length === 0) {
          showWeeklyEmpty();
          return;
        }
        showWeeklyChart();
        buildWeeklyChart(data.labels, data.datasets);
      } catch (e) {
        showWeeklyEmpty();
      }
    }

    // ── DOMContentLoaded ─────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', function() {
      applyLayout('220px');
      applyTheme(localStorage.getItem('theme') || 'light');
      document.querySelectorAll('.theme-option').forEach(o =>
        o.addEventListener('click', () => applyTheme(o.getAttribute('data-theme')))
      );

      setTimeout(function() {

        // Initial GAD chart
        const gadHasData = GAD_DATA.female.reduce((a, b) => a + b, 0) + GAD_DATA.male.reduce((a, b) => a + b, 0) > 0;
        if (gadHasData) {
          showGadChart();
          buildGadChart(GAD_DATA.labels, GAD_DATA.female, GAD_DATA.male);
        } else {
          showGadEmpty();
        }

        // Initial Weekly chart
        if (WEEKLY_DATA.datasets && WEEKLY_DATA.datasets.length > 0) {
          showWeeklyChart();
          buildWeeklyChart(WEEKLY_DATA.labels, WEEKLY_DATA.datasets);
        } else {
          showWeeklyEmpty();
        }

        // Inventory pies
        makePieChart('medicinePieChart', MEDICINE_ITEMS);
        makePieChart('suppliesPieChart', SUPPLIES_ITEMS);

      }, 150);

      // Period dropdowns
      document.getElementById('gadPeriodSelect').addEventListener('change', function() {
        reloadGadChart(this.value);
      });
      document.getElementById('weeklyPeriodSelect').addEventListener('change', function() {
        reloadWeeklyChart(this.value);
      });

      // ── Modal validation ──
      const todayStr = new Date().toISOString().split('T')[0];
      document.getElementById('dateFrom').setAttribute('max', todayStr);
      document.getElementById('dateTo').setAttribute('max', todayStr);

      function setError(inputId, errId, show) {
        const input = document.getElementById(inputId),
          err = document.getElementById(errId);
        if (!input || !err) return;
        if (show) {
          err.classList.remove('hidden');
          err.classList.add('flex');
          input.classList.add('border-red-400');
          input.classList.remove('border-gray-200');
        } else {
          err.classList.add('hidden');
          err.classList.remove('flex');
          input.classList.remove('border-red-400');
          input.classList.add('border-gray-200');
        }
      }
      const clearError = (a, b) => setError(a, b, false);

      document.getElementById('downloadReportBtn').addEventListener('click', function() {
        const name = document.getElementById('reportName').value.trim();
        const type = document.getElementById('reportType').value;
        const from = document.getElementById('dateFrom').value;
        const to = document.getElementById('dateTo').value;
        const qty = parseInt(document.getElementById('reportQty').value, 10);
        let valid = true;

        setError('reportName', 'reportNameErr', !name);
        if (!name) valid = false;
        setError('reportType', 'reportTypeErr', !type);
        if (!type) valid = false;

        ['dateFromErr', 'dateFutureErr', 'dateRangeErr'].forEach(id => {
          document.getElementById(id).classList.add('hidden');
          document.getElementById(id).classList.remove('flex');
        });
        ['dateFrom', 'dateTo'].forEach(id => {
          document.getElementById(id).classList.remove('border-red-400');
          document.getElementById(id).classList.add('border-gray-200');
        });

        if (!from) {
          document.getElementById('dateFromErr').classList.remove('hidden');
          document.getElementById('dateFromErr').classList.add('flex');
          document.getElementById('dateFrom').classList.add('border-red-400');
          document.getElementById('dateFrom').classList.remove('border-gray-200');
          valid = false;
        } else {
          const fromFuture = from > todayStr,
            toFuture = to && to > todayStr;
          if (fromFuture || toFuture) {
            document.getElementById('dateFutureErr').classList.remove('hidden');
            document.getElementById('dateFutureErr').classList.add('flex');
            if (fromFuture) {
              document.getElementById('dateFrom').classList.add('border-red-400');
              document.getElementById('dateFrom').classList.remove('border-gray-200');
            }
            if (toFuture) {
              document.getElementById('dateTo').classList.add('border-red-400');
              document.getElementById('dateTo').classList.remove('border-gray-200');
            }
            valid = false;
          } else if (to && new Date(to) < new Date(from)) {
            document.getElementById('dateRangeErr').classList.remove('hidden');
            document.getElementById('dateRangeErr').classList.add('flex');
            document.getElementById('dateTo').classList.add('border-red-400');
            document.getElementById('dateTo').classList.remove('border-gray-200');
            valid = false;
          }
        }

        const qtyInvalid = isNaN(qty) || qty < 1 || qty > 100;
        document.getElementById('reportQtyErrMsg').textContent = (isNaN(qty) || qty < 1) ? 'Quantity must be between 1 and 100.' : 'Quantity cannot exceed 100.';
        setError('reportQty', 'reportQtyErr', qtyInvalid);
        if (qtyInvalid) valid = false;

        const banner = document.getElementById('formErrorBanner');
        if (!valid) {
          banner.classList.remove('hidden');
          banner.classList.add('flex');
          const btn = document.getElementById('downloadReportBtn');
          btn.classList.add('animate-bounce');
          setTimeout(() => btn.classList.remove('animate-bounce'), 600);
        } else {
          banner.classList.add('hidden');
          banner.classList.remove('flex');
          document.getElementById('createReportModal').close();
          document.getElementById('downloadCompleteModal').showModal();
          document.getElementById('reportForm').reset();
          document.getElementById('reportNameCounter').textContent = '0 / 100';
          document.getElementById('reportNameCounter').classList.remove('text-red-500');
          document.getElementById('reportNameCounter').classList.add('text-gray-400');
          ['reportNameErr', 'reportTypeErr', 'dateFromErr', 'dateFutureErr', 'dateRangeErr', 'reportQtyErr'].forEach(id => {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
          });
        }
      });

      document.getElementById('reportName').addEventListener('input', function() {
        const len = this.value.length,
          counter = document.getElementById('reportNameCounter');
        counter.textContent = `${len} / 100`;
        counter.classList.toggle('text-red-500', len >= 90);
        counter.classList.toggle('text-gray-400', len < 90);
        if (this.value.trim()) clearError('reportName', 'reportNameErr');
        document.getElementById('formErrorBanner').classList.add('hidden');
      });
      document.getElementById('reportType').addEventListener('change', function() {
        if (this.value) clearError('reportType', 'reportTypeErr');
        document.getElementById('formErrorBanner').classList.add('hidden');
      });

      function checkDates() {
        const from = document.getElementById('dateFrom').value,
          to = document.getElementById('dateTo').value;
        ['dateFromErr', 'dateFutureErr', 'dateRangeErr'].forEach(id => {
          document.getElementById(id).classList.add('hidden');
          document.getElementById(id).classList.remove('flex');
        });
        ['dateFrom', 'dateTo'].forEach(id => {
          document.getElementById(id).classList.remove('border-red-400');
          document.getElementById(id).classList.add('border-gray-200');
        });
        if (!from && !to) return;
        const fromFuture = from && from > todayStr,
          toFuture = to && to > todayStr;
        if (fromFuture || toFuture) {
          document.getElementById('dateFutureErr').classList.remove('hidden');
          document.getElementById('dateFutureErr').classList.add('flex');
          if (fromFuture) {
            document.getElementById('dateFrom').classList.add('border-red-400');
            document.getElementById('dateFrom').classList.remove('border-gray-200');
          }
          if (toFuture) {
            document.getElementById('dateTo').classList.add('border-red-400');
            document.getElementById('dateTo').classList.remove('border-gray-200');
          }
          return;
        }
        if (from && to && new Date(to) < new Date(from)) {
          document.getElementById('dateRangeErr').classList.remove('hidden');
          document.getElementById('dateRangeErr').classList.add('flex');
          document.getElementById('dateTo').classList.add('border-red-400');
          document.getElementById('dateTo').classList.remove('border-gray-200');
        }
        document.getElementById('formErrorBanner').classList.add('hidden');
      }
      document.getElementById('dateFrom').addEventListener('change', checkDates);
      document.getElementById('dateTo').addEventListener('change', checkDates);

      const qtyInput = document.getElementById('reportQty');
      qtyInput.addEventListener('keydown', e => {
        if (['-', '+', 'e', 'E', '.', ','].includes(e.key)) e.preventDefault();
      });
      qtyInput.addEventListener('input', function() {
        let val = this.value.replace(/[^0-9]/g, '');
        if (val !== '' && parseInt(val, 10) > 100) val = '100';
        this.value = val;
        const qty = parseInt(val, 10);
        if (!isNaN(qty) && qty >= 1 && qty <= 100) clearError('reportQty', 'reportQtyErr');
        document.getElementById('formErrorBanner').classList.add('hidden');
      });
      qtyInput.addEventListener('paste', e => {
        e.preventDefault();
        const num = parseInt((e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, ''), 10);
        if (!isNaN(num)) qtyInput.value = Math.min(Math.max(num, 1), 100);
      });
    });
  </script>

</body>

</html>