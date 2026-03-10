<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>PUP Taguig Dental Clinic | Document Requests</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=DM+Serif+Display&display=swap" rel="stylesheet">

  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #f4f4f4;
      overflow-x: hidden;
    }

    .fade-up {
      animation: fadeUp .45s ease both;
    }

    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* ════ HEADER ════ */
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

    /* ════ SIDEBAR ════ */
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

    #sidebar.expanded .sidebar-link span i {
      margin-right: 0 !important;
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
    main {
      transition: background-color .3s ease, color .3s ease;
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

    /* ── Dark mode ── */
    [data-theme="dark"] body {
      background-color: #000D1A;
      color: #E5E7EB;
    }

    [data-theme="dark"] #sidebar {
      background-color: #111827;
    }

    [data-theme="dark"] .bg-white {
      background-color: #111827 !important;
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

    [data-theme="dark"] .table-card {
      background: #111827 !important;
      border-color: #2a3244 !important;
    }

    [data-theme="dark"] .toolbar-wrap {
      background: #1a2234 !important;
      border-color: #2a3244 !important;
    }

    [data-theme="dark"] .req-row {
      background: #111827;
      border-bottom-color: #2a3244 !important;
    }

    [data-theme="dark"] .req-row:hover {
      background: #1e2535 !important;
    }

    [data-theme="dark"] .detail-panel {
      background: #161e2e !important;
      border-top-color: #2a3244 !important;
    }

    [data-theme="dark"] .search-wrap {
      background: #1e2535;
      border-color: #2a3244;
    }

    [data-theme="dark"] .search-wrap input {
      color: #e5e7eb;
      background: transparent;
    }

    [data-theme="dark"] .modal-box-inner {
      background: #1e2535;
    }

    [data-theme="dark"] .form-input {
      background: #161e2e;
      border-color: #2a3244;
      color: #e5e7eb;
    }

    [data-theme="dark"] .btn-close-modal {
      background: #2a3244;
      color: #aaa;
    }

    [data-theme="dark"] .tfoot-bar {
      background: #1a2234 !important;
      border-color: #2a3244 !important;
    }

    [data-theme="dark"] .dv {
      color: #e5e7eb;
    }

    /* ════ PAGE STYLES ════ */

    /* Stat cards */
    .stat-card {
      background: #8B0000;
      border-radius: 16px;
      padding: 1.35rem 1.5rem;
      color: #fff;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition: transform .18s, box-shadow .18s, background .18s;
      text-decoration: none;
      display: block;
      border: 2px solid transparent;
    }

    .stat-card::before {
      content: '';
      position: absolute;
      right: -16px;
      top: -16px;
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .07);
    }

    .stat-card::after {
      content: '';
      position: absolute;
      right: 12px;
      bottom: -20px;
      width: 55px;
      height: 55px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .05);
    }

    .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(139, 0, 0, .3);
    }

    .stat-card.stat-active {
      background: #6b0000;
      border-color: rgba(255, 255, 255, .2);
      box-shadow: 0 6px 20px rgba(139, 0, 0, .45);
    }

    .stat-num {
      font-size: 2.5rem;
      line-height: 1;
    }

    .stat-label {
      font-size: .75rem;
      font-weight: 700;
      opacity: .8;
      margin-top: .3rem;
      letter-spacing: .04em;
      text-transform: uppercase;
    }

    .stat-icon {
      position: absolute;
      right: 1.1rem;
      top: 50%;
      transform: translateY(-50%);
      font-size: 1.7rem;
      opacity: .15;
    }

    /* Search — inventory style */
    .search-wrap {
      display: flex;
      align-items: center;
      gap: 10px;
      background: #FAFAF9;
      border: 1.5px solid #E0DDD8;
      border-radius: 12px;
      padding: 0 16px;
      height: 40px;
      transition: border-color .2s, box-shadow .2s;
      width: 288px;
    }

    .search-wrap:focus-within {
      border-color: #8B0000;
      box-shadow: 0 0 0 3px rgba(139, 0, 0, .1);
    }

    .search-wrap i.search-icon {
      color: #8B0000;
      font-size: 13px;
      flex-shrink: 0;
    }

    .search-wrap input {
      border: none;
      background: none;
      outline: none;
      font-size: 13px;
      color: #333;
      width: 100%;
    }

    .search-wrap input::placeholder {
      color: #B0ABA6;
    }

    .search-clear-btn {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      border: none;
      background: #E0DDD8;
      color: #7A7370;
      font-size: 10px;
      cursor: pointer;
      display: none;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      transition: all .2s;
      padding: 0;
    }

    .search-clear-btn:hover {
      background: rgba(139, 0, 0, .47);
      color: #fff;
    }

    .search-clear-btn.visible {
      display: flex;
    }

    .row-count {
      font-size: 12px;
      color: #9A9490;
    }

    /* Table card */
    .table-card {
      background: #fff;
      border-radius: 14px;
      border: 1px solid #EDE9E4;
      box-shadow: 0 1px 4px rgba(0, 0, 0, .05);
      overflow: hidden;
    }

    .toolbar-wrap {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 14px 20px;
      border-bottom: 1px solid #EDE9E4;
      background: #FAFAF9;
      flex-wrap: wrap;
      gap: .75rem;
    }

    /* Request rows */
    .req-row {
      position: relative;
      background: #fff;
      border-bottom: 1px solid #F0ECE8;
      overflow: hidden;
      transition: background .15s;
    }

    .req-row:hover {
      background: #FFF8F8;
    }

    .req-row:last-child {
      border-bottom: none;
    }

    .accent-bar {
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
    }

    .req-inner {
      padding: 1rem 1.3rem 1rem 1.5rem;
    }

    /* Status badge */
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: .3rem;
      padding: .22rem .7rem;
      border-radius: 999px;
      font-size: .7rem;
      font-weight: 700;
      letter-spacing: .04em;
      text-transform: uppercase;
    }

    .status-badge::before {
      content: '';
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: currentColor;
      opacity: .7;
    }

    .badge-approved {
      background: #dcfce7;
      color: #15803d;
    }

    .badge-pending {
      background: #fff7ed;
      color: #c2410c;
    }

    .badge-rejected {
      background: #fee2e2;
      color: #b91c1c;
    }

    /* Detail panel */
    .detail-panel {
      border-top: 1px solid #f3f3f3;
      background: #fafafa;
      padding: 1.2rem 1.5rem;
      display: none;
    }

    .detail-panel.open {
      display: block;
    }

    .dl {
      font-size: .67rem;
      font-weight: 700;
      color: #8B0000;
      text-transform: uppercase;
      letter-spacing: .07em;
      margin-bottom: .2rem;
    }

    .dv {
      font-size: .88rem;
      font-weight: 600;
      color: #222;
    }

    /* Buttons */
    .btn-approve {
      background: #15803d;
      color: #fff;
      border: none;
      cursor: pointer;
      border-radius: 9px;
      padding: .5rem 1.2rem;
      font-weight: 700;
      font-size: .8rem;
      display: flex;
      align-items: center;
      gap: .35rem;
      transition: background .15s, transform .1s;
    }

    .btn-approve:hover {
      background: #166534;
      transform: scale(1.02);
    }

    .btn-reject {
      background: #fff;
      color: #b91c1c;
      border: 2px solid #fca5a5;
      cursor: pointer;
      border-radius: 9px;
      padding: .5rem 1.2rem;
      font-weight: 700;
      font-size: .8rem;
      display: flex;
      align-items: center;
      gap: .35rem;
      transition: all .15s;
    }

    .btn-reject:hover {
      background: #b91c1c;
      color: #fff;
      border-color: #b91c1c;
    }

    .btn-view {
      background: #8B0000;
      color: #fff;
      border: none;
      cursor: pointer;
      border-radius: 9px;
      padding: .45rem 1.1rem;
      font-weight: 700;
      font-size: .78rem;
      display: flex;
      align-items: center;
      gap: .35rem;
      transition: background .15s;
      white-space: nowrap;
    }

    .btn-view:hover {
      background: #6b0000;
    }

    .btn-close-detail {
      background: #f3f3f3;
      color: #666;
      border: none;
      cursor: pointer;
      border-radius: 9px;
      padding: .45rem .9rem;
      font-weight: 600;
      font-size: .78rem;
      transition: background .15s;
    }

    .btn-close-detail:hover {
      background: #e8e8e8;
    }

    /* ════ FILTER BUTTON ════ */
    .btn-filter-open {
      display: flex;
      align-items: center;
      gap: .45rem;
      padding: .42rem 1rem;
      background: #fff;
      border: 2px solid #e8e0e0;
      border-radius: 10px;
      font-size: .8rem;
      font-weight: 700;
      color: #555;
      cursor: pointer;
      transition: all .18s;
      position: relative;
    }

    .btn-filter-open:hover {
      border-color: #8B0000;
      color: #8B0000;
      background: #fff8f8;
    }

    .btn-filter-open.has-filters {
      border-color: #8B0000;
      color: #8B0000;
      background: #fff1f1;
    }

    .filter-badge {
      min-width: 18px;
      height: 18px;
      border-radius: 999px;
      background: #8B0000;
      color: #fff;
      font-size: .65rem;
      font-weight: 800;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0 4px;
      margin-left: .1rem;
    }

    /* ════ FILTER TAGS (pill toggles) ════ */
    .ftag {
      display: inline-flex;
      align-items: center;
      gap: .35rem;
      padding: .38rem .9rem;
      border-radius: 999px;
      border: 2px solid #e8e0e0;
      background: #fafafa;
      color: #666;
      font-size: .78rem;
      font-weight: 600;
      cursor: pointer;
      transition: all .15s;
      white-space: nowrap;
    }

    .ftag:hover {
      border-color: #8B0000;
      color: #8B0000;
      background: #fff8f8;
    }

    .ftag.ftag-active {
      background: #8B0000;
      border-color: #8B0000;
      color: #fff;
    }

    .ftag-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      flex-shrink: 0;
    }

    .ftag.ftag-active .ftag-dot {
      background: rgba(255, 255, 255, .8) !important;
    }

    /* dark mode for filter tags */
    [data-theme="dark"] .ftag {
      background: #1e2535;
      border-color: #2a3244;
      color: #aaa;
    }

    [data-theme="dark"] .ftag:hover {
      border-color: #8B0000;
      color: #fca5a5;
    }

    [data-theme="dark"] .btn-filter-open {
      background: #1e2535;
      border-color: #2a3244;
      color: #aaa;
    }

    [data-theme="dark"] .btn-filter-open:hover,
    [data-theme="dark"] .btn-filter-open.has-filters {
      border-color: #8B0000;
      color: #fca5a5;
      background: #1e2535;
    }

    /* ════ EMPTY STATE ════ */
    .state-box {
      text-align: center;
      padding: 4rem 2rem;
      color: #ccc;
    }

    .state-box i {
      font-size: 2.5rem;
      margin-bottom: .75rem;
      display: block;
    }

    .state-box strong {
      display: block;
      font-size: .95rem;
      font-weight: 700;
      color: #bbb;
      margin-bottom: .3rem;
    }

    .state-box span {
      font-size: .8rem;
    }

    /* Clear filter button inside empty state */
    .btn-clear-filter {
      display: inline-flex;
      align-items: center;
      gap: .4rem;
      margin-top: 1.1rem;
      padding: .5rem 1.3rem;
      background: #fff;
      color: #8B0000;
      border: 2px solid #f3c6c6;
      border-radius: 999px;
      font-size: .78rem;
      font-weight: 700;
      cursor: pointer;
      transition: all .2s;
      letter-spacing: .02em;
    }

    .btn-clear-filter:hover {
      background: #8B0000;
      color: #fff;
      border-color: #8B0000;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(139, 0, 0, .2);
    }

    .btn-clear-filter i {
      font-size: .72rem;
      display: inline !important;
      margin: 0 !important;
    }

    /* Tfoot bar */
    .tfoot-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 20px;
      border-top: 1px solid #EDE9E4;
      background: #FAFAF9;
    }

    /* Pagination */
    .pag-btn {
      padding: .38rem .8rem;
      border-radius: 8px;
      font-weight: 600;
      font-size: .8rem;
      border: none;
      cursor: pointer;
      transition: all .15s;
      background: transparent;
      color: #888;
    }

    .pag-btn:disabled {
      color: #ddd;
      cursor: not-allowed;
    }

    .pag-btn.pag-active {
      background: #8B0000;
      color: #fff;
    }

    .pag-btn:not(.pag-active):not(:disabled):hover {
      background: #f3e8e8;
      color: #8B0000;
    }

    /* Modals */
    .modal-overlay {
      position: fixed;
      inset: 0;
      z-index: 999;
      background: rgba(0, 0, 0, .5);
      backdrop-filter: blur(2px);
      display: none;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }

    .modal-overlay.open {
      display: flex;
    }

    .modal-box-inner {
      width: 100%;
      max-width: 500px;
      background: #fff;
      border-radius: 20px;
      overflow: hidden;
      position: relative;
      box-shadow: 0 24px 64px rgba(0, 0, 0, .2);
      animation: popIn .25s cubic-bezier(.34, 1.56, .64, 1) both;
    }

    @keyframes popIn {
      from {
        opacity: 0;
        transform: scale(.9)
      }

      to {
        opacity: 1;
        transform: scale(1)
      }
    }

    .modal-hd {
      padding: 1.3rem 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .modal-bd {
      padding: 1.1rem 1.5rem;
    }

    .modal-ft {
      padding: .75rem 1.5rem 1.3rem;
      display: flex;
      justify-content: flex-end;
      gap: .65rem;
      background: #fafafa;
      border-top: 1px solid #f0f0f0;
    }

    .modal-title {
      font-size: 1.2rem;
    }

    .modal-x {
      background: none;
      border: none;
      cursor: pointer;
      color: #bbb;
      font-size: .95rem;
      padding: .25rem;
      border-radius: 6px;
      transition: color .15s;
    }

    .modal-x:hover {
      color: #333;
    }

    .form-label {
      display: block;
      font-size: .75rem;
      font-weight: 700;
      color: #555;
      margin-bottom: .3rem;
      letter-spacing: .03em;
    }

    .form-input {
      width: 100%;
      border: 2px solid #ebebeb;
      border-radius: 9px;
      padding: .58rem .9rem;
      font-size: .87rem;
      outline: none;
      transition: border-color .2s;
      background: #fff;
    }

    .form-input:focus {
      border-color: #8B0000;
    }

    .btn-close-modal {
      background: #f3f3f3;
      color: #555;
      border: none;
      cursor: pointer;
      border-radius: 9px;
      padding: .55rem 1.2rem;
      font-weight: 600;
      font-size: .82rem;
      transition: background .15s;
    }

    .btn-close-modal:hover {
      background: #e8e8e8;
    }

    /* ════ REDESIGNED APPROVE MODAL ════ */
    .approve-hero {
      background: linear-gradient(145deg, #052e16 0%, #14532d 40%, #166534 100%);
      padding: 2.2rem 1.75rem 1.8rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .approve-hero::before {
      content: '';
      position: absolute;
      top: -40px;
      right: -40px;
      width: 130px;
      height: 130px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .04);
    }

    .approve-hero::after {
      content: '';
      position: absolute;
      bottom: -30px;
      left: -20px;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .03);
    }

    .approve-icon-ring {
      width: 68px;
      height: 68px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .1);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
      position: relative;
      z-index: 1;
      border: 2px solid rgba(255, 255, 255, .15);
    }

    .approve-icon-inner {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .15);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .approve-icon-inner i {
      font-size: 1.3rem;
      color: #86efac;
    }

    .approve-hero-title {
      font-size: 1.4rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: .3rem;
      position: relative;
      z-index: 1;
    }

    .approve-hero-sub {
      font-size: .75rem;
      color: rgba(255, 255, 255, .55);
      position: relative;
      z-index: 1;
    }

    .approve-patient-card {
      display: flex;
      align-items: center;
      gap: 1rem;
      background: #f0fdf4;
      border: 1.5px solid #bbf7d0;
      border-radius: 14px;
      padding: .9rem 1.1rem;
    }

    .approve-patient-avatar {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      background: #dcfce7;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .approve-patient-avatar i {
      color: #15803d;
      font-size: 1rem;
    }

    .approve-info-row {
      display: flex;
      align-items: flex-start;
      gap: .55rem;
      background: #f0fdf4;
      border-radius: 10px;
      padding: .65rem .85rem;
      margin-top: .85rem;
      font-size: .75rem;
      color: #166534;
      line-height: 1.5;
    }

    .approve-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1.25rem 1.75rem 1.5rem;
      margin-top: 1.25rem;
      border-top: 1px solid #f0f0f0;
      background: #fafaf9;
    }

    /* ════ REDESIGNED REJECT MODAL ════ */
    .reject-hero {
      background: linear-gradient(145deg, #450a0a 0%, #7f1d1d 40%, #991b1b 100%);
      padding: 2.2rem 1.75rem 1.8rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .reject-hero::before {
      content: '';
      position: absolute;
      top: -40px;
      right: -40px;
      width: 130px;
      height: 130px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .04);
    }

    .reject-hero::after {
      content: '';
      position: absolute;
      bottom: -30px;
      left: -20px;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .03);
    }

    .reject-icon-ring {
      width: 68px;
      height: 68px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .1);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
      position: relative;
      z-index: 1;
      border: 2px solid rgba(255, 255, 255, .15);
    }

    .reject-icon-inner {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .15);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .reject-icon-inner i {
      font-size: 1.3rem;
      color: #fca5a5;
    }

    .reject-hero-title {
      font-size: 1.4rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: .3rem;
      position: relative;
      z-index: 1;
    }

    .reject-hero-sub {
      font-size: .75rem;
      color: rgba(255, 255, 255, .5);
      position: relative;
      z-index: 1;
    }

    .reject-patient-card {
      display: flex;
      align-items: center;
      gap: 1rem;
      background: #fff5f5;
      border: 1.5px solid #fecaca;
      border-radius: 14px;
      padding: .9rem 1.1rem;
    }

    .reject-patient-avatar {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      background: #fee2e2;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .reject-patient-avatar i {
      color: #b91c1c;
      font-size: 1rem;
    }

    .reject-field-label {
      display: block;
      font-size: .72rem;
      font-weight: 700;
      color: #6b2020;
      letter-spacing: .04em;
      text-transform: uppercase;
      margin-bottom: .45rem;
    }

    .reject-textarea {
      width: 100%;
      border: 2px solid #fecaca;
      border-radius: 12px;
      padding: .7rem .9rem;
      font-size: .85rem;
      font-family: inherit;
      outline: none;
      resize: none;
      background: #fff5f5;
      color: #450a0a;
      transition: border-color .2s, box-shadow .2s;
      line-height: 1.5;
    }

    .reject-textarea::placeholder {
      color: #d1a3a3;
    }

    .reject-textarea:focus {
      border-color: #b91c1c;
      box-shadow: 0 0 0 3px rgba(185, 28, 28, .1);
      background: #fff;
    }

    .reject-warning-row {
      display: flex;
      align-items: flex-start;
      gap: .55rem;
      background: #fff5f5;
      border-radius: 10px;
      padding: .65rem .85rem;
      margin-top: .85rem;
      font-size: .75rem;
      color: #991b1b;
      line-height: 1.5;
    }

    .reject-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1.25rem 1.75rem 1.5rem;
      margin-top: 1.25rem;
      border-top: 1px solid #fef2f2;
      background: #fffafa;
    }

    /* ── Shared modal button styles ── */
    .modal-float-x {
      position: absolute;
      top: 1rem;
      right: 1rem;
      z-index: 10;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .15);
      border: 1px solid rgba(255, 255, 255, .2);
      color: rgba(255, 255, 255, .7);
      font-size: .8rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all .15s;
    }

    .modal-float-x:hover {
      background: rgba(255, 255, 255, .28);
      color: #fff;
    }

    .modal-btn-ghost {
      display: flex;
      align-items: center;
      gap: .4rem;
      background: transparent;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      color: #777;
      font-size: .8rem;
      font-weight: 700;
      padding: .55rem 1.1rem;
      cursor: pointer;
      transition: all .15s;
      font-family: inherit;
    }

    .modal-btn-ghost:hover {
      border-color: #aaa;
      color: #444;
    }

    .modal-btn-ghost--red {
      border-color: #fecaca;
      color: #b91c1c;
    }

    .modal-btn-ghost--red:hover {
      border-color: #b91c1c;
      background: #fff5f5;
    }

    .modal-btn-confirm-approve {
      display: flex;
      align-items: center;
      gap: .6rem;
      background: linear-gradient(135deg, #15803d, #16a34a);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: .6rem 1.4rem;
      font-size: .85rem;
      font-weight: 800;
      cursor: pointer;
      font-family: inherit;
      transition: all .18s;
      box-shadow: 0 4px 14px rgba(21, 128, 61, .3);
    }

    .modal-btn-confirm-approve:hover {
      background: linear-gradient(135deg, #166534, #15803d);
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(21, 128, 61, .4);
    }

    .modal-btn-confirm-approve:active {
      transform: translateY(0);
    }

    .modal-btn-confirm-approve:disabled {
      opacity: .6;
      cursor: not-allowed;
      transform: none;
    }

    .modal-btn-confirm-reject {
      display: flex;
      align-items: center;
      gap: .6rem;
      background: linear-gradient(135deg, #991b1b, #b91c1c);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: .6rem 1.4rem;
      font-size: .85rem;
      font-weight: 800;
      cursor: pointer;
      font-family: inherit;
      transition: all .18s;
      box-shadow: 0 4px 14px rgba(185, 28, 28, .3);
    }

    .modal-btn-confirm-reject:hover {
      background: linear-gradient(135deg, #7f1d1d, #991b1b);
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(185, 28, 28, .4);
    }

    .modal-btn-confirm-reject:active {
      transform: translateY(0);
    }

    .modal-btn-confirm-reject:disabled {
      opacity: .6;
      cursor: not-allowed;
      transform: none;
    }

    .btn-confirm-icon {
      width: 24px;
      height: 24px;
      border-radius: 6px;
      background: rgba(255, 255, 255, .2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .75rem;
      flex-shrink: 0;
    }

    /* dark mode adjustments */
    [data-theme="dark"] .approve-patient-card {
      background: #0f2d1a;
      border-color: #166534;
    }

    [data-theme="dark"] .approve-info-row {
      background: #0f2d1a;
      color: #86efac;
    }

    [data-theme="dark"] .approve-footer {
      background: #161e2e;
      border-color: #2a3244;
    }

    [data-theme="dark"] .reject-patient-card {
      background: #2d0f0f;
      border-color: #7f1d1d;
    }

    [data-theme="dark"] .reject-textarea {
      background: #2d0f0f;
      border-color: #7f1d1d;
      color: #fecaca;
    }

    [data-theme="dark"] .reject-textarea:focus {
      background: #1a0808;
    }

    [data-theme="dark"] .reject-warning-row {
      background: #2d0f0f;
      color: #fca5a5;
    }

    [data-theme="dark"] .reject-footer {
      background: #161e2e;
      border-color: #2a3244;
    }

    [data-theme="dark"] .modal-btn-ghost {
      border-color: #2a3244;
      color: #aaa;
    }

    [data-theme="dark"] .modal-btn-ghost:hover {
      border-color: #666;
      color: #ddd;
    }

    /* ════ SKELETON ════ */
    @keyframes shimmer {
      0% {
        background-position: -468px 0
      }

      100% {
        background-position: 468px 0
      }
    }

    .skeleton {
      background: linear-gradient(90deg, #f0f0f0 25%, #e8e8e8 50%, #f0f0f0 75%);
      background-size: 936px 100%;
      animation: shimmer 1.2s infinite;
      border-radius: 6px;
    }
  </style>
</head>

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<body>

  {{-- ══════════════ HEADER ══════════════ --}}
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
        ['route'=>'dentist.dentist.dashboard', 'icon'=>'fa-chart-line', 'label'=>'Dashboard'],
        ['route'=>'dentist.dentist.patients', 'icon'=>'fa-users', 'label'=>'Patients'],
        ['route'=>'dentist.dentist.appointments', 'icon'=>'fa-calendar-check', 'label'=>'Appointments'],
        ['route'=>'dentist.dentist.documentrequests', 'icon'=>'fa-file-circle-check', 'label'=>'Document Requests'],
        ['route'=>'dentist.dentist.inventory', 'icon'=>'fa-box', 'label'=>'Inventory'],
        ['route'=>'dentist.dentist.report', 'icon'=>'fa-file', 'label'=>'Reports'],
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

  {{-- ══════════════ MAIN ══════════════ --}}
  <main id="mainContent" class="pt-[62px] min-h-screen pb-10" style="margin-left:220px;">
    <div class="max-w-7xl mx-auto px-6 py-8 fade-up">

      {{-- Page heading --}}
      <div style="margin-bottom:1.75rem;">
        <h1 style="font-size:1.9rem; font-weight:800; color:#8B0000; line-height:1.1; margin:0;">Document Requests</h1>
        <p style="color:#999; font-size:.83rem; margin:.3rem 0 0;">Review, approve or reject patient document requests</p>
      </div>

      {{-- Stat cards --}}
      <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:.9rem; margin-bottom:1.75rem;" id="statCards">
        <button class="stat-card stat-active" data-filter="all" onclick="setFilter('all')">
          <div class="stat-num" id="statAll">—</div>
          <div class="stat-label">All Requests</div>
          <i class="fa-solid fa-layer-group stat-icon"></i>
        </button>
        <button class="stat-card" data-filter="pending" onclick="setFilter('pending')">
          <div class="stat-num" id="statPending">—</div>
          <div class="stat-label">Pending</div>
          <i class="fa-solid fa-hourglass-half stat-icon"></i>
        </button>
        <button class="stat-card" data-filter="approved" onclick="setFilter('approved')">
          <div class="stat-num" id="statApproved">—</div>
          <div class="stat-label">Approved</div>
          <i class="fa-solid fa-circle-check stat-icon"></i>
        </button>
        <button class="stat-card" data-filter="rejected" onclick="setFilter('rejected')">
          <div class="stat-num" id="statRejected">—</div>
          <div class="stat-label">Rejected</div>
          <i class="fa-solid fa-circle-xmark stat-icon"></i>
        </button>
      </div>

      {{-- Table card --}}
      <div class="table-card">

        {{-- Toolbar --}}
        <div class="toolbar-wrap">
          <div class="search-wrap">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input id="searchInput" type="text" placeholder="Search by patient name…"
              oninput="onSearch(this)" />
            <button type="button" id="searchClearBtn" class="search-clear-btn" onclick="clearSearch()" title="Clear">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>
          <div style="display:flex; align-items:center; gap:.75rem;">
            <span class="row-count" id="rowCount"></span>
            <button id="filterBtn" onclick="openFilterModal()" class="btn-filter-open">
              <i class="fa-solid fa-sliders"></i>
              <span>Filter</span>
              <span id="filterBadge" class="filter-badge" style="display:none;"></span>
            </button>
          </div>
        </div>

        {{-- Request list --}}
        <div id="requestContainer"></div>

        {{-- Footer / pagination --}}
        <div class="tfoot-bar">
          <span style="font-size:12px; color:#9A9490;" id="pageInfo"></span>
          <div style="display:flex; align-items:center; gap:.4rem;" id="pagControls"></div>
        </div>

      </div>

    </div>
  </main>

  {{-- ══════════════ FOOTER ══════════════ --}}
  <footer class="footer bg-[#8B0000] text-[#F4F4F4] p-6">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 pl-24 text-sm text-center">
      <span><span class="text-gray-300">© 2025–2026</span> <span class="font-semibold">Polytechnic University of the Philippines</span></span>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/terms/" class="hover:underline">Terms of Use</a>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/privacy/" class="hover:underline">Privacy Statement</a>
    </div>
  </footer>

  {{-- ══════════ FILTER MODAL ══════════ --}}
  <div id="filterModal" class="modal-overlay">
    <div class="modal-box-inner" style="max-width:480px;">
      <div class="modal-hd" style="background:linear-gradient(135deg,#6b0000,#8B0000); border-bottom:none;">
        <div>
          <div class="modal-title" style="color:#fff; font-weight:800;">
            <i class="fa-solid fa-sliders" style="margin-right:.45rem; font-size:1rem;"></i>Filter Requests
          </div>
          <div style="font-size:.74rem; color:rgba(255,255,255,.65); margin-top:.18rem;">Narrow down the list by applying filters below</div>
        </div>
        <button class="modal-x" id="filterCloseBtn" style="color:rgba(255,255,255,.6);" onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='rgba(255,255,255,.6)'">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <div class="modal-bd" style="padding:1.4rem 1.5rem; display:flex; flex-direction:column; gap:1.25rem;">

        {{-- Status --}}
        <div>
          <label class="form-label" style="margin-bottom:.55rem;">Status</label>
          <div style="display:flex; gap:.5rem; flex-wrap:wrap;" id="fStatusGroup">
            <button class="ftag ftag-active" data-val="all">All</button>
            <button class="ftag" data-val="pending">
              <span class="ftag-dot" style="background:#c2410c;"></span> Pending
            </button>
            <button class="ftag" data-val="approved">
              <span class="ftag-dot" style="background:#15803d;"></span> Approved
            </button>
            <button class="ftag" data-val="rejected">
              <span class="ftag-dot" style="background:#b91c1c;"></span> Rejected
            </button>
          </div>
        </div>

        {{-- Document type --}}
        <div>
          <label class="form-label" style="margin-bottom:.55rem;">Document Type</label>
          <div style="position:relative;">
            <i class="fa-solid fa-file-lines" style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#8B0000;font-size:12px;pointer-events:none;"></i>
            <select id="fDocType" class="form-input" style="padding-left:2rem; appearance:none; cursor:pointer; background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2212%22 height=%2212%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%238B0000%22 stroke-width=%222.5%22%3E%3Cpath d=%22M6 9l6 6 6-6%22/%3E%3C/svg%3E'); background-repeat:no-repeat; background-position:right 12px center;">
              <option value="">All Document Types</option>
              <option>Dental Clearance</option>
              <option>Dental Health Record</option>
              <option>Annual Dental Clearance</option>
              <option>Medical Certificate</option>
              <option>Other</option>
            </select>
          </div>
        </div>

        {{-- Date range --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:.75rem;">
          <div>
            <label class="form-label">Date From</label>
            <div style="position:relative;">
              <i class="fa-regular fa-calendar" style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#8B0000;font-size:12px;pointer-events:none;"></i>
              <input id="fDateFrom" type="date" class="form-input" style="padding-left:2rem; cursor:pointer;">
            </div>
          </div>
          <div>
            <label class="form-label">Date To</label>
            <div style="position:relative;">
              <i class="fa-regular fa-calendar" style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#8B0000;font-size:12px;pointer-events:none;"></i>
              <input id="fDateTo" type="date" class="form-input" style="padding-left:2rem; cursor:pointer;">
            </div>
          </div>
        </div>

        {{-- Sort --}}
        <div>
          <label class="form-label" style="margin-bottom:.55rem;">Sort By</label>
          <div style="display:flex; gap:.5rem; flex-wrap:wrap;" id="fSortGroup">
            <button class="ftag ftag-active" data-val="newest">
              <i class="fa-solid fa-arrow-down-short-wide" style="font-size:.7rem;"></i> Newest First
            </button>
            <button class="ftag" data-val="oldest">
              <i class="fa-solid fa-arrow-up-short-wide" style="font-size:.7rem;"></i> Oldest First
            </button>
            <button class="ftag" data-val="name_asc">
              <i class="fa-solid fa-arrow-down-a-z" style="font-size:.7rem;"></i> Name A–Z
            </button>
            <button class="ftag" data-val="name_desc">
              <i class="fa-solid fa-arrow-up-a-z" style="font-size:.7rem;"></i> Name Z–A
            </button>
          </div>
        </div>

      </div>

      <div class="modal-ft" style="justify-content:space-between;">
        <button id="filterResetBtn" class="btn-close-modal" style="display:flex;align-items:center;gap:.4rem;">
          <i class="fa-solid fa-rotate-left" style="font-size:.75rem;"></i> Reset All
        </button>
        <div style="display:flex;gap:.6rem;">
          <button class="btn-close-modal" id="filterCancelBtn">Cancel</button>
          <button id="filterApplyBtn" class="btn-approve" style="padding:.55rem 1.6rem;">
            <i class="fa-solid fa-check"></i> Apply Filters
          </button>
        </div>
      </div>
    </div>
  </div>

  {{-- ══════════ APPROVE MODAL (redesigned) ══════════ --}}
  <div id="approveModal" class="modal-overlay">
    <div class="modal-box-inner" style="max-width:440px; border-radius:24px; overflow:hidden;">

      {{-- Close button (floating) --}}
      <button class="modal-float-x" id="approveCancelBtn">
        <i class="fa-solid fa-xmark"></i>
      </button>

      {{-- Hero section --}}
      <div class="approve-hero">
        <div class="approve-icon-ring">
          <div class="approve-icon-inner">
            <i class="fa-solid fa-file-circle-check"></i>
          </div>
        </div>
        <div class="approve-hero-title">Approve Request</div>
        <div class="approve-hero-sub">The patient will be notified once approved</div>
      </div>

      {{-- Body --}}
      <div style="padding:1.5rem 1.75rem 0;">

        {{-- Patient card --}}
        <div class="approve-patient-card">
          <div class="approve-patient-avatar">
            <i class="fa-solid fa-user"></i>
          </div>
          <div>
            <div style="font-size:.68rem; font-weight:700; color:#15803d; text-transform:uppercase; letter-spacing:.07em; margin-bottom:.2rem;">Patient</div>
            <div id="approvePatientName" style="font-size:1.05rem; font-weight:800; color:#14532d; line-height:1.2;">—</div>
          </div>
        </div>

        {{-- Info row --}}
        <div class="approve-info-row">
          <i class="fa-solid fa-circle-info" style="color:#86efac; font-size:.8rem; flex-shrink:0; margin-top:1px;"></i>
          <span>The document will be queued for printing and signing. This action <strong>cannot be undone.</strong></span>
        </div>

      </div>

      {{-- Footer --}}
      <div class="approve-footer">
        <button class="modal-btn-ghost" id="approveCancelBtn2">
          <i class="fa-solid fa-arrow-left" style="font-size:.72rem;"></i> Cancel
        </button>
        <button class="modal-btn-confirm-approve" id="approveConfirmBtn">
          <span class="btn-confirm-icon"><i class="fa-solid fa-check"></i></span>
          Confirm Approval
        </button>
      </div>

    </div>
  </div>
  <input type="hidden" id="approveRequestId">

  {{-- ══════════ REJECT MODAL (redesigned) ══════════ --}}
  <div id="rejectModal" class="modal-overlay">
    <div class="modal-box-inner" style="max-width:440px; border-radius:24px; overflow:hidden;">

      {{-- Close button (floating) --}}
      <button class="modal-float-x modal-float-x--red" id="rejectCancelBtn">
        <i class="fa-solid fa-xmark"></i>
      </button>

      {{-- Hero section --}}
      <div class="reject-hero">
        <div class="reject-icon-ring">
          <div class="reject-icon-inner">
            <i class="fa-solid fa-file-circle-xmark"></i>
          </div>
        </div>
        <div class="reject-hero-title">Reject Request</div>
        <div class="reject-hero-sub">This action is permanent and cannot be undone</div>
      </div>

      {{-- Body --}}
      <div style="padding:1.5rem 1.75rem 0;">

        {{-- Patient card --}}
        <div class="reject-patient-card">
          <div class="reject-patient-avatar">
            <i class="fa-solid fa-user"></i>
          </div>
          <div>
            <div style="font-size:.68rem; font-weight:700; color:#b91c1c; text-transform:uppercase; letter-spacing:.07em; margin-bottom:.2rem;">Patient</div>
            <div id="rejectPatientName" style="font-size:1.05rem; font-weight:800; color:#7f1d1d; line-height:1.2;">—</div>
          </div>
        </div>

        {{-- Reason field --}}
        <div style="margin-top:1.1rem;">
          <label class="reject-field-label">
            Reason for rejection
            <span style="font-weight:400; color:#d1a3a3; margin-left:.3rem;">(optional)</span>
          </label>
          <div style="position:relative;">
            <textarea id="rejectNotes" class="reject-textarea" rows="3"
              placeholder="Provide a reason so the patient understands the decision…"></textarea>
            <div class="reject-textarea-corner"></div>
          </div>
        </div>

        {{-- Warning row --}}
        <div class="reject-warning-row">
          <i class="fa-solid fa-triangle-exclamation" style="color:#fca5a5; font-size:.8rem; flex-shrink:0; margin-top:1px;"></i>
          <span>The patient will be notified of this rejection. Make sure you've reviewed the request carefully.</span>
        </div>

      </div>

      {{-- Footer --}}
      <div class="reject-footer">
        <button class="modal-btn-ghost modal-btn-ghost--red" id="rejectCancelBtn2">
          <i class="fa-solid fa-arrow-left" style="font-size:.72rem;"></i> Cancel
        </button>
        <button class="modal-btn-confirm-reject" id="rejectConfirmBtn">
          <span class="btn-confirm-icon btn-confirm-icon--red"><i class="fa-solid fa-ban"></i></span>
          Confirm Rejection
        </button>
      </div>

    </div>
  </div>
  <input type="hidden" id="rejectRequestId">

  {{-- ══════════ APPROVED RESULT ══════════ --}}
  <div id="approvedResultModal" class="modal-overlay">
    <div class="modal-box-inner">
      <div style="background:linear-gradient(135deg,#15803d,#16a34a); padding:2.5rem 2rem; text-align:center; color:#fff;">
        <div style="width:58px;height:58px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .9rem;">
          <i class="fa-solid fa-circle-check" style="font-size:1.7rem;"></i>
        </div>
        <div style="font-size:1.55rem;margin-bottom:.5rem;">Request Approved!</div>
        <p style="font-size:.82rem;opacity:.85;line-height:1.6;">The document has been approved and will be<br>prepared for printing. The patient will be notified.</p>
        <button id="approvedResultClose"
          style="margin-top:1.4rem;background:rgba(255,255,255,.2);color:#fff;border:2px solid rgba(255,255,255,.35);border-radius:9px;padding:.5rem 1.5rem;font-weight:700;cursor:pointer;font-size:.83rem;">
          Done
        </button>
      </div>
    </div>
  </div>

  {{-- ══════════ REJECTED RESULT ══════════ --}}
  <div id="rejectedResultModal" class="modal-overlay">
    <div class="modal-box-inner">
      <div style="background:linear-gradient(135deg,#991b1b,#b91c1c); padding:2.5rem 2rem; text-align:center; color:#fff;">
        <div style="width:58px;height:58px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .9rem;">
          <i class="fa-solid fa-circle-xmark" style="font-size:1.7rem;"></i>
        </div>
        <div style="font-size:1.55rem;margin-bottom:.5rem;">Request Rejected</div>
        <p style="font-size:.82rem;opacity:.85;line-height:1.6;">The request has been rejected. The patient<br>will be notified of the decision.</p>
        <button id="rejectedResultClose"
          style="margin-top:1.4rem;background:rgba(255,255,255,.2);color:#fff;border:2px solid rgba(255,255,255,.35);border-radius:9px;padding:.5rem 1.5rem;font-weight:700;cursor:pointer;font-size:.83rem;">
          Done
        </button>
      </div>
    </div>
  </div>

  {{-- ══════════ SCRIPTS ══════════ --}}
  <script>
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;
    const html = document.documentElement;

    /* ── Theme ── */
    function applyTheme(theme) {
      html.setAttribute("data-theme", theme);
      localStorage.setItem("theme", theme);
      document.querySelectorAll(".theme-option").forEach(o =>
        o.getAttribute("data-theme") === theme ? o.classList.add("active") : o.classList.remove("active"));
      const ind = document.querySelector(".theme-indicator");
      if (ind) theme === "dark" ? ind.classList.add("dark-mode") : ind.classList.remove("dark-mode");
    }

    /* ── Sidebar ── */
    let sidebarOpen = true;

    function applyLayout(w) {
      document.getElementById('sidebar').style.width = w;
      document.getElementById('mainContent').style.marginLeft = w;
    }

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const texts = document.querySelectorAll('.sidebar-text');
      const icon = document.getElementById('sidebarIcon');
      const wrapper = document.getElementById('sidebarToggleWrapper');
      sidebarOpen = !sidebarOpen;
      if (sidebarOpen) {
        applyLayout('220px');
        sidebar.classList.replace('collapsed', 'expanded');
        texts.forEach(t => {
          t.classList.remove('opacity-0', 'w-0');
          t.classList.add('opacity-100');
        });
        wrapper.classList.replace('justify-center', 'justify-end');
        icon.classList.replace('fa-bars', 'fa-xmark');
      } else {
        applyLayout('72px');
        sidebar.classList.replace('expanded', 'collapsed');
        texts.forEach(t => {
          t.classList.add('opacity-0', 'w-0');
          t.classList.remove('opacity-100');
        });
        wrapper.classList.replace('justify-end', 'justify-center');
        icon.classList.replace('fa-xmark', 'fa-bars');
      }
      applyTheme(localStorage.getItem("theme") || "light");
    }

    /* ════════════════════════════════════
       DATA + RENDER ENGINE
    ════════════════════════════════════ */
    let allRequests = [];
    let activeFilter = 'all';
    let searchQuery = '';
    const PER_PAGE = 8;
    let currentPage = 1;

    /* ── Advanced filter state ── */
    let filterStatus = 'all'; // mirrors activeFilter but set via modal
    let filterDocType = '';
    let filterDateFrom = '';
    let filterDateTo = '';
    let filterSort = 'newest';

    async function loadData() {
      showSkeleton();
      try {
        const res = await fetch('/dentist/document-requests/data', {
          cache: 'no-store'
        });
        const json = await res.json();
        allRequests = json.requests || [];
        updateStats(json.stats || {});
        renderList();
      } catch (e) {
        document.getElementById('requestContainer').innerHTML = `
      <div class="state-box">
        <i class="fa-solid fa-circle-exclamation" style="color:#fca5a5;"></i>
        <strong>Failed to load</strong>
        <span>Could not fetch requests. Please refresh.</span>
      </div>`;
      }
    }

    function showSkeleton() {
      let html = '';
      for (let i = 0; i < 4; i++) {
        html += `<div class="req-row">
      <div class="req-inner" style="display:grid; grid-template-columns:1fr 1fr 1.4fr auto; align-items:center; gap:1rem;">
        <div style="display:flex;align-items:center;gap:.8rem;">
          <div class="skeleton" style="width:40px;height:40px;border-radius:11px;flex-shrink:0;"></div>
          <div>
            <div class="skeleton" style="height:13px;width:110px;margin-bottom:6px;"></div>
            <div class="skeleton" style="height:10px;width:70px;"></div>
          </div>
        </div>
        <div>
          <div class="skeleton" style="height:10px;width:60px;margin-bottom:5px;"></div>
          <div class="skeleton" style="height:13px;width:80px;"></div>
        </div>
        <div>
          <div class="skeleton" style="height:10px;width:55px;margin-bottom:5px;"></div>
          <div class="skeleton" style="height:13px;width:120px;margin-bottom:6px;"></div>
          <div class="skeleton" style="height:18px;width:60px;border-radius:999px;"></div>
        </div>
        <div class="skeleton" style="height:32px;width:70px;border-radius:9px;"></div>
      </div>
    </div>`;
      }
      document.getElementById('requestContainer').innerHTML = html;
      document.getElementById('rowCount').textContent = '';
      document.getElementById('pageInfo').textContent = '';
      document.getElementById('pagControls').innerHTML = '';
    }

    function updateStats(stats) {
      document.getElementById('statAll').textContent = stats.all ?? 0;
      document.getElementById('statPending').textContent = stats.pending ?? 0;
      document.getElementById('statApproved').textContent = stats.approved ?? 0;
      document.getElementById('statRejected').textContent = stats.rejected ?? 0;
    }

    function getFiltered() {
      let data = allRequests;

      // Status (stat card OR filter modal — they stay in sync)
      if (activeFilter !== 'all') data = data.filter(r => r.status === activeFilter);

      // Search
      if (searchQuery) {
        const q = searchQuery.toLowerCase();
        data = data.filter(r => r.patient_name.toLowerCase().includes(q));
      }

      // Document type
      if (filterDocType) {
        data = data.filter(r => r.document_type === filterDocType);
      }

      // Date range
      if (filterDateFrom) {
        const from = new Date(filterDateFrom);
        data = data.filter(r => new Date(r.request_date) >= from);
      }
      if (filterDateTo) {
        const to = new Date(filterDateTo);
        to.setHours(23, 59, 59, 999);
        data = data.filter(r => new Date(r.request_date) <= to);
      }

      // Sort
      data = [...data].sort((a, b) => {
        if (filterSort === 'oldest') return new Date(a.request_date) - new Date(b.request_date);
        if (filterSort === 'name_asc') return a.patient_name.localeCompare(b.patient_name);
        if (filterSort === 'name_desc') return b.patient_name.localeCompare(a.patient_name);
        return new Date(b.request_date) - new Date(a.request_date); // newest
      });

      return data;
    }

    /* ── Determine what active filters are in play ── */
    function hasActiveFilters() {
      return searchQuery !== '' || activeFilter !== 'all' || filterDocType !== '' || filterDateFrom !== '' || filterDateTo !== '' || filterSort !== 'newest';
    }

    /* ── Count advanced modal filters (for badge) ── */
    function countAdvancedFilters() {
      let n = 0;
      if (filterStatus !== 'all') n++;
      if (filterDocType) n++;
      if (filterDateFrom || filterDateTo) n++;
      if (filterSort !== 'newest') n++;
      return n;
    }

    /* ── Update filter button appearance ── */
    function updateFilterBtn() {
      const btn = document.getElementById('filterBtn');
      const badge = document.getElementById('filterBadge');
      const count = countAdvancedFilters();
      if (count > 0) {
        btn.classList.add('has-filters');
        badge.textContent = count;
        badge.style.display = 'inline-flex';
      } else {
        btn.classList.remove('has-filters');
        badge.style.display = 'none';
      }
    }

    /* ── Build the "Clear Filter" button HTML shown in the empty state ── */
    function buildClearFilterBtn() {
      const parts = [];
      if (searchQuery) parts.push(`"${searchQuery}"`);
      if (activeFilter !== 'all') parts.push(activeFilter.charAt(0).toUpperCase() + activeFilter.slice(1));
      if (filterDocType) parts.push(filterDocType);
      if (filterDateFrom || filterDateTo) parts.push('Date range');
      if (filterSort !== 'newest') parts.push('Sort');

      const label = parts.length ?
        `Clear filter${parts.length > 1 ? 's' : ''} (${parts.join(', ')})` :
        'Clear filters';

      return `
        <div style="margin-top:1.25rem;">
          <button class="btn-clear-filter" onclick="resetAllFilters()">
            <i class="fa-solid fa-filter-circle-xmark"></i>
            ${label}
          </button>
        </div>`;
    }

    /* ── Reset both search and status filter ── */
    function resetAllFilters() {
      // Clear search
      document.getElementById('searchInput').value = '';
      document.getElementById('searchClearBtn').classList.remove('visible');
      searchQuery = '';

      // Reset to "All" filter
      activeFilter = 'all';
      filterStatus = 'all';
      filterDocType = '';
      filterDateFrom = '';
      filterDateTo = '';
      filterSort = 'newest';

      document.querySelectorAll('#statCards .stat-card').forEach(c =>
        c.getAttribute('data-filter') === 'all' ?
        c.classList.add('stat-active') :
        c.classList.remove('stat-active'));

      updateFilterBtn();
      currentPage = 1;
      renderList();
    }

    function renderList() {
      const filtered = getFiltered();
      const total = filtered.length;
      const lastPage = Math.max(1, Math.ceil(total / PER_PAGE));
      if (currentPage > lastPage) currentPage = lastPage;
      const start = (currentPage - 1) * PER_PAGE;
      const page = filtered.slice(start, start + PER_PAGE);

      document.getElementById('rowCount').textContent =
        `${total} ${total === 1 ? 'request' : 'requests'}`;

      document.getElementById('pageInfo').textContent =
        total === 0 ? '' :
        `Showing ${start + 1}–${Math.min(start + PER_PAGE, total)} of ${total} requests`;

      renderPagination(total, lastPage);

      const container = document.getElementById('requestContainer');

      if (!page.length) {
        /* ── Differentiate: search miss vs filter miss vs truly empty ── */
        const isSearchMiss = searchQuery !== '' && activeFilter === 'all';
        const isFilterMiss = searchQuery === '' && activeFilter !== 'all';
        const isCombinedMiss = searchQuery !== '' && activeFilter !== 'all';
        const isDataEmpty = allRequests.length === 0;

        let icon, title, subtitle, showClear;

        if (isDataEmpty) {
          icon = 'fa-regular fa-folder-open';
          title = 'No requests yet';
          subtitle = 'Incoming document requests will appear here.';
          showClear = false;
        } else if (isSearchMiss) {
          icon = 'fa-solid fa-magnifying-glass';
          title = `No results for "${esc(searchQuery)}"`;
          subtitle = 'Try a different name or spelling.';
          showClear = true;
        } else if (isFilterMiss) {
          icon = 'fa-regular fa-folder-open';
          title = `No ${activeFilter} requests`;
          subtitle = `There are no ${activeFilter} document requests at the moment.`;
          showClear = true;
        } else if (isCombinedMiss) {
          icon = 'fa-solid fa-magnifying-glass';
          title = 'No matching requests';
          subtitle = `No ${activeFilter} requests found for "${esc(searchQuery)}".`;
          showClear = true;
        } else {
          icon = 'fa-regular fa-folder-open';
          title = 'No requests found';
          subtitle = 'Try adjusting your filters.';
          showClear = hasActiveFilters();
        }

        container.innerHTML = `
          <div class="state-box">
            <i class="${icon}"></i>
            <strong>${title}</strong>
            <span>${subtitle}</span>
            ${showClear ? buildClearFilterBtn() : ''}
          </div>`;
        return;
      }

      container.innerHTML = page.map(r => buildRow(r)).join('');
    }

    function buildRow(r) {
      const accentHex = r.status === 'approved' ? '#15803d' : r.status === 'rejected' ? '#b91c1c' : '#c2410c';
      const avatarBg = r.status === 'approved' ? '#dcfce7' : r.status === 'rejected' ? '#fee2e2' : '#fff7ed';
      const avatarCol = r.status === 'approved' ? '#15803d' : r.status === 'rejected' ? '#b91c1c' : '#c2410c';
      const badgeCls = r.status === 'approved' ? 'badge-approved' : r.status === 'rejected' ? 'badge-rejected' : 'badge-pending';
      const sub = r.sub_label ?
        `<div style="font-size:.72rem; color:#aaa; margin-top:.08rem;">${esc(r.sub_label)}</div>` :
        `<div style="font-size:.72rem; color:#ddd;">—</div>`;

      const nameCol = `
    <div style="display:flex; align-items:center; gap:.8rem;">
      <div style="width:40px;height:40px;border-radius:11px;background:${avatarBg};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <i class="fa-solid fa-user" style="color:${avatarCol};font-size:.88rem;"></i>
      </div>
      <div>
        <div style="font-weight:700;font-size:.88rem;color:#1a1a1a;line-height:1.25;">${esc(r.patient_name)}</div>
        ${sub}
      </div>
    </div>`;

      const dateCol = `
    <div>
      <div style="font-size:.65rem;font-weight:700;color:#bbb;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.18rem;">Date Requested</div>
      <div style="font-size:.85rem;font-weight:600;color:#333;">${esc(r.request_date)}</div>
      <div style="font-size:.72rem;color:#ccc;">${esc(r.request_time)}</div>
    </div>`;

      const docCol = `
    <div>
      <div style="font-size:.65rem;font-weight:700;color:#bbb;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.18rem;">Document</div>
      <div style="font-size:.85rem;font-weight:600;color:#333;margin-bottom:.35rem;">${esc(r.document_type)}</div>
      <span class="status-badge ${badgeCls}">${r.status.charAt(0).toUpperCase()+r.status.slice(1)}</span>
    </div>`;

      if (r.status === 'pending') {
        const actionCol = `<button class="btn-view" data-id="${r.id}" onclick="toggleDetail(this, ${r.id})"><i class="fa-solid fa-eye"></i> View</button>`;
        const detail = `
      <div class="detail-panel" id="detail-${r.id}">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;margin-bottom:1.1rem;">
          <div style="font-size:.8rem;color:#888;">Pending request from <strong style="color:#333;">${esc(r.patient_name)}</strong></div>
          <div style="display:flex;align-items:center;gap:.55rem;flex-wrap:wrap;">
            <button class="btn-approve" onclick="openApprove(${r.id},'${esc(r.patient_name)}')"><i class="fa-solid fa-check"></i> Approve</button>
            <button class="btn-reject"  onclick="openReject(${r.id},'${esc(r.patient_name)}')"><i class="fa-solid fa-xmark"></i> Reject</button>
            <button class="btn-close-detail" onclick="closeDetail(${r.id})">Close</button>
          </div>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:1.1rem;padding-top:.9rem;border-top:1px solid #f0f0f0;">
          <div><div class="dl">Patient</div><div class="dv">${esc(r.patient_name)}</div></div>
          ${r.sub_label ? `<div><div class="dl">Department</div><div class="dv">${esc(r.sub_label)}</div></div>` : ''}
          <div><div class="dl">Date</div><div class="dv">${esc(r.request_date)}</div></div>
          <div><div class="dl">Time</div><div class="dv">${esc(r.request_time)}</div></div>
          <div><div class="dl">Document</div><div class="dv">${esc(r.document_type)}</div></div>
          <div><div class="dl">Purpose</div><div class="dv">${esc(r.purpose)}</div></div>
        </div>
      </div>`;

        return `<div class="req-row" id="row-${r.id}">
      <div class="accent-bar" style="background:${accentHex};"></div>
      <div class="req-inner" style="display:grid;grid-template-columns:1fr 1fr 1.4fr auto;align-items:center;gap:1rem;">
        ${nameCol}${dateCol}${docCol}${actionCol}
      </div>${detail}
    </div>`;
      }

      // Approved / Rejected — read-only
      const purposeCol = `
    <div style="text-align:right;">
      <div style="font-size:.65rem;font-weight:700;color:#bbb;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.18rem;">Purpose</div>
      <div style="font-size:.8rem;color:#666;">${esc(r.purpose)}</div>
    </div>`;

      return `<div class="req-row">
    <div class="accent-bar" style="background:${accentHex};"></div>
    <div class="req-inner" style="display:grid;grid-template-columns:1fr 1fr 1.4fr auto;align-items:center;gap:1rem;">
      ${nameCol}${dateCol}${docCol}${purposeCol}
    </div>
  </div>`;
    }

    function renderPagination(total, lastPage) {
      const ctrl = document.getElementById('pagControls');
      if (lastPage <= 1) {
        ctrl.innerHTML = '';
        return;
      }

      let html = '';
      const prev = currentPage > 1;
      const next = currentPage < lastPage;

      html += `<button class="pag-btn" ${prev?'':'disabled'} onclick="goPage(${currentPage-1})">‹ Prev</button>`;
      for (let p = 1; p <= lastPage; p++) {
        html += `<button class="pag-btn ${p===currentPage?'pag-active':''}" onclick="goPage(${p})">${p}</button>`;
      }
      html += `<button class="pag-btn" ${next?'':'disabled'} onclick="goPage(${currentPage+1})">Next ›</button>`;
      ctrl.innerHTML = html;
    }

    function goPage(p) {
      currentPage = p;
      renderList();
      document.getElementById('requestContainer').scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }

    /* ── Filter / Search ── */
    function setFilter(f) {
      activeFilter = f;
      currentPage = 1;
      document.querySelectorAll('#statCards .stat-card').forEach(c =>
        c.getAttribute('data-filter') === f ? c.classList.add('stat-active') : c.classList.remove('stat-active'));
      renderList();
    }

    function onSearch(input) {
      searchQuery = input.value.trim();
      currentPage = 1;
      document.getElementById('searchClearBtn').classList.toggle('visible', input.value.length > 0);
      renderList();
    }

    function clearSearch() {
      document.getElementById('searchInput').value = '';
      document.getElementById('searchClearBtn').classList.remove('visible');
      searchQuery = '';
      currentPage = 1;
      renderList();
    }

    /* ── Detail panel ── */
    function toggleDetail(btn, id) {
      const panel = document.getElementById(`detail-${id}`);
      const opening = !panel.classList.contains('open');
      panel.classList.toggle('open');
      btn.innerHTML = opening ?
        '<i class="fa-solid fa-eye-slash"></i> Hide' :
        '<i class="fa-solid fa-eye"></i> View';
    }

    function closeDetail(id) {
      const panel = document.getElementById(`detail-${id}`);
      if (panel) panel.classList.remove('open');
      const row = document.getElementById(`row-${id}`);
      if (row) {
        const vb = row.querySelector('.btn-view');
        if (vb) vb.innerHTML = '<i class="fa-solid fa-eye"></i> View';
      }
    }

    /* ── XSS escape ── */
    function esc(str) {
      return String(str ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    /* ── Modal helpers ── */
    function openModal(el) {
      el.classList.add('open');
      document.body.style.overflow = 'hidden';
    }

    function closeModal(el) {
      el.classList.remove('open');
      document.body.style.overflow = '';
    }

    function outside(el) {
      el.addEventListener('click', e => {
        if (e.target === el) closeModal(el);
      });
    }

    function openApprove(id, name) {
      document.getElementById('approvePatientName').textContent = name;
      document.getElementById('approveRequestId').value = id;
      openModal(document.getElementById('approveModal'));
    }

    function openReject(id, name) {
      document.getElementById('rejectPatientName').textContent = name;
      document.getElementById('rejectRequestId').value = id;
      document.getElementById('rejectNotes').value = '';
      openModal(document.getElementById('rejectModal'));
      setTimeout(() => document.getElementById('rejectNotes').focus(), 60);
    }

    /* ── Filter modal ── */
    function openFilterModal() {
      // Sync UI to current state
      syncFilterTagGroup('fStatusGroup', filterStatus);
      syncFilterTagGroup('fSortGroup', filterSort);
      document.getElementById('fDocType').value = filterDocType;
      document.getElementById('fDateFrom').value = filterDateFrom;
      document.getElementById('fDateTo').value = filterDateTo;
      openModal(document.getElementById('filterModal'));
    }

    function syncFilterTagGroup(groupId, activeVal) {
      document.querySelectorAll(`#${groupId} .ftag`).forEach(btn => {
        btn.getAttribute('data-val') === activeVal ?
          btn.classList.add('ftag-active') :
          btn.classList.remove('ftag-active');
      });
    }

    function applyFilterModal() {
      // Read status tag
      const statusActive = document.querySelector('#fStatusGroup .ftag.ftag-active');
      filterStatus = statusActive ? statusActive.getAttribute('data-val') : 'all';
      activeFilter = filterStatus;

      // Sync stat cards
      document.querySelectorAll('#statCards .stat-card').forEach(c =>
        c.getAttribute('data-filter') === activeFilter ?
        c.classList.add('stat-active') :
        c.classList.remove('stat-active'));

      // Read sort tag
      const sortActive = document.querySelector('#fSortGroup .ftag.ftag-active');
      filterSort = sortActive ? sortActive.getAttribute('data-val') : 'newest';

      filterDocType = document.getElementById('fDocType').value;
      filterDateFrom = document.getElementById('fDateFrom').value;
      filterDateTo = document.getElementById('fDateTo').value;

      updateFilterBtn();
      currentPage = 1;
      closeModal(document.getElementById('filterModal'));
      renderList();
    }

    function resetFilterModal() {
      filterStatus = 'all';
      filterDocType = '';
      filterDateFrom = '';
      filterDateTo = '';
      filterSort = 'newest';
      syncFilterTagGroup('fStatusGroup', 'all');
      syncFilterTagGroup('fSortGroup', 'newest');
      document.getElementById('fDocType').value = '';
      document.getElementById('fDateFrom').value = '';
      document.getElementById('fDateTo').value = '';
    }

    /* ── DOMContentLoaded ── */
    document.addEventListener("DOMContentLoaded", () => {
      applyLayout('220px');
      applyTheme(localStorage.getItem("theme") || "light");
      document.querySelectorAll(".theme-option").forEach(o =>
        o.addEventListener("click", () => applyTheme(o.getAttribute("data-theme"))));

      document.getElementById("notifBtn").addEventListener("click", e => {
        e.stopPropagation();
        document.getElementById("notifMenu").classList.toggle("open");
      });
      document.addEventListener("click", () => document.getElementById("notifMenu").classList.remove("open"));

      // Escape closes modals
      document.addEventListener('keydown', e => {
        if (e.key !== 'Escape') return;
        ['approveModal', 'rejectModal', 'approvedResultModal', 'rejectedResultModal', 'filterModal']
        .forEach(id => {
          const m = document.getElementById(id);
          if (m?.classList.contains('open')) closeModal(m);
        });
      });

      // Click-outside modals
      ['approveModal', 'rejectModal', 'approvedResultModal', 'rejectedResultModal', 'filterModal']
      .forEach(id => outside(document.getElementById(id)));

      // ── Filter modal wiring ──
      const filterModal = document.getElementById('filterModal');
      document.getElementById('filterCloseBtn').addEventListener('click', () => closeModal(filterModal));
      document.getElementById('filterCancelBtn').addEventListener('click', () => closeModal(filterModal));
      document.getElementById('filterApplyBtn').addEventListener('click', applyFilterModal);
      document.getElementById('filterResetBtn').addEventListener('click', resetFilterModal);

      // Tag group toggle (single-select pills)
      ['fStatusGroup', 'fSortGroup'].forEach(groupId => {
        document.getElementById(groupId).addEventListener('click', e => {
          const btn = e.target.closest('.ftag');
          if (!btn) return;
          document.querySelectorAll(`#${groupId} .ftag`).forEach(b => b.classList.remove('ftag-active'));
          btn.classList.add('ftag-active');
        });
      });

      // Approve modal buttons
      const approveModal = document.getElementById('approveModal');
      const approvedModal = document.getElementById('approvedResultModal');
      ['approveCancelBtn', 'approveCancelBtn2'].forEach(id =>
        document.getElementById(id)?.addEventListener('click', () => closeModal(approveModal)));
      document.getElementById('approvedResultClose').addEventListener('click', () => {
        closeModal(approvedModal);
        loadData();
      });
      document.getElementById('approveConfirmBtn').addEventListener('click', async () => {
        const id = document.getElementById('approveRequestId').value;
        const btn = document.getElementById('approveConfirmBtn');
        if (!id) return;
        btn.disabled = true;
        const res = await fetch(`/dentist/document-requests/${id}/approve`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF
          },
          body: '{}'
        });
        btn.disabled = false;
        if (res.ok) {
          closeModal(approveModal);
          openModal(approvedModal);
        } else alert('Something went wrong.');
      });

      // Reject modal buttons
      const rejectModal = document.getElementById('rejectModal');
      const rejectedModal = document.getElementById('rejectedResultModal');
      ['rejectCancelBtn', 'rejectCancelBtn2'].forEach(id =>
        document.getElementById(id)?.addEventListener('click', () => closeModal(rejectModal)));
      document.getElementById('rejectedResultClose').addEventListener('click', () => {
        closeModal(rejectedModal);
        loadData();
      });
      document.getElementById('rejectConfirmBtn').addEventListener('click', async () => {
        const id = document.getElementById('rejectRequestId').value;
        const btn = document.getElementById('rejectConfirmBtn');
        const notes = document.getElementById('rejectNotes').value.trim();
        if (!id) return;
        btn.disabled = true;
        const res = await fetch(`/dentist/document-requests/${id}/reject`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF
          },
          body: JSON.stringify({
            rejection_notes: notes
          })
        });
        btn.disabled = false;
        if (res.ok) {
          closeModal(rejectModal);
          openModal(rejectedModal);
        } else alert('Something went wrong.');
      });

      // Initial load
      loadData();
    });
  </script>

</body>

</html>