<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Academic Periods | PUP Taguig Dental Clinic</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <script>tailwind.config = { daisyui: { themes: false } }</script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      overflow-x: hidden;
    }

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

    /* Group header — static, not clickable for collapse */
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
      font-size: .62rem;
      color: #b0b8c4;
      white-space: nowrap;
      display: block;
      margin-top: 1px;
    }

    /* Group body always visible */
    .group-body {
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

    .nav-sep {
      height: 1px;
      background: #f3f4f6;
      margin: 8px 12px;
    }

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

    .active-banner {
      background: #fff;
      border-radius: 12px;
      border-left: 4px solid #8B0000;
      box-shadow: 0 1px 6px rgba(0, 0, 0, .06);
      overflow: hidden;
      margin-bottom: 1.5rem;
    }

    .active-banner-inner {
      padding: 1.25rem 1.5rem;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    @media (min-width:1024px) {
      .active-banner-inner {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 1.25rem;
      }
    }

    .progress-track {
      height: 6px;
      border-radius: 99px;
      background: #f3f4f6;
      overflow: hidden;
    }

    .progress-fill {
      height: 100%;
      border-radius: 99px;
      background: linear-gradient(90deg, #8B0000, #c0392b);
      transition: width .6s cubic-bezier(.4, 0, .2, 1);
    }

    .sem-pill {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 11px;
      font-weight: 700;
      padding: 3px 10px;
      border-radius: 99px;
    }

    .s-active {
      background: #fee2e2;
      color: #8B0000;
    }

    .s-upcoming {
      background: #dbeafe;
      color: #1d4ed8;
    }

    .s-ended {
      background: #f3f4f6;
      color: #6b7280;
    }

    .s-inactive {
      background: #fef9c3;
      color: #92400e;
    }

    .act {
      padding: 6px 9px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-size: 12px;
      transition: all .15s;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-weight: 600;
    }

    .act:hover {
      transform: scale(1.06);
    }

    .act-edit {
      background: #eff6ff;
      color: #2563eb;
    }

    .act-edit:hover {
      background: #dbeafe;
    }

    .act-star {
      background: #d1fae5;
      color: #065f46;
    }

    .act-star:hover {
      background: #a7f3d0;
    }

    .act-del {
      background: #fef2f2;
      color: #dc2626;
    }

    .act-del:hover {
      background: #fee2e2;
    }

    .act-pinned {
      background: #d1fae5;
      color: #065f46;
      opacity: .55;
      cursor: default;
    }

    .tbl-row {
      transition: background .12s;
    }

    .tbl-row:hover {
      background: #fef9f9;
    }

    .tbl-row.is-active {
      background: #fff7f7;
    }

    .page-btn {
      min-width: 32px;
      height: 32px;
      border-radius: 8px;
      border: 1px solid #e5e7eb;
      background: #fff;
      cursor: pointer;
      font-size: .78rem;
      font-weight: 600;
      color: #6b7280;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0 8px;
      transition: all .15s;
      text-decoration: none;
    }

    .page-btn:hover {
      background: #fef2f2;
      border-color: #8B0000;
      color: #8B0000;
    }

    .page-btn.active {
      background: #8B0000;
      border-color: #8B0000;
      color: #fff;
    }

    .page-btn.disabled {
      opacity: .35;
      cursor: not-allowed;
      pointer-events: none;
    }

    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .45);
      z-index: 200;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      opacity: 0;
      pointer-events: none;
      transition: opacity .2s;
    }

    .modal-overlay.open {
      opacity: 1;
      pointer-events: auto;
    }

    .modal-box {
      background: #fff;
      border-radius: 20px;
      width: 100%;
      max-width: 560px;
      max-height: 90vh;
      overflow-y: auto;
      transform: scale(.95) translateY(10px);
      transition: transform .25s cubic-bezier(.4, 0, .2, 1);
      box-shadow: 0 24px 60px rgba(0, 0, 0, .2);
    }

    .modal-overlay.open .modal-box {
      transform: scale(1) translateY(0);
    }

    .modal-sm .modal-box {
      max-width: 420px;
    }

    .field-input {
      transition: border-color .15s, box-shadow .15s;
    }

    .field-input:focus {
      outline: none;
      border-color: #8B0000 !important;
      box-shadow: 0 0 0 3px rgba(139, 0, 0, .1);
    }

    @keyframes pulse {

      0%,
      100% {
        opacity: 1
      }

      50% {
        opacity: .35
      }
    }

    .dot-pulse {
      animation: pulse 2s cubic-bezier(.4, 0, .6, 1) infinite;
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

    [data-theme="dark"] .bg-gray-50 {
      background-color: #0d1117 !important;
    }

    [data-theme="dark"] .bg-\[\#f5f5f5\] {
      background-color: #000D1A !important;
    }

    [data-theme="dark"] .border-gray-100 {
      border-color: #21262d !important;
    }

    [data-theme="dark"] .border-gray-200 {
      border-color: #21262d !important;
    }

    [data-theme="dark"] .text-gray-800 {
      color: #e5e7eb !important;
    }

    [data-theme="dark"] .text-gray-600 {
      color: #9ca3af !important;
    }

    [data-theme="dark"] .text-gray-500 {
      color: #9ca3af !important;
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

    [data-theme="dark"] .modal-box {
      background: #161b22;
    }

    [data-theme="dark"] .modal-box input,
    [data-theme="dark"] .modal-box select,
    [data-theme="dark"] .modal-box textarea {
      background: #0d1117 !important;
      border-color: #21262d !important;
      color: #e5e7eb !important;
    }

    [data-theme="dark"] .tbl-row:hover {
      background: #0d1117;
    }

    [data-theme="dark"] .tbl-row.is-active {
      background: rgba(139, 0, 0, .07);
    }

    [data-theme="dark"] thead tr {
      background: #0d1117 !important;
    }

    [data-theme="dark"] tr {
      border-color: #21262d !important;
    }

    [data-theme="dark"] .page-btn {
      background: #161b22;
      border-color: #21262d;
      color: #9ca3af;
    }

    [data-theme="dark"] .page-btn:hover {
      background: rgba(139, 0, 0, .2);
      border-color: #8B0000;
      color: #f87171;
    }

    [data-theme="dark"] .active-banner {
      background: #161b22 !important;
    }

    [data-theme="dark"] .progress-track {
      background: #21262d;
    }

    [data-theme="dark"] .modal-box .bg-gray-50 {
      background: #0d1117 !important;
    }

    [data-theme="dark"] .cal-card {
      background: #161b22 !important;
      border-color: #21262d !important;
    }
  </style>
</head>

<body class="bg-[#f5f5f5] text-[#333333]">

  @php
  $calendarPeriods = $academicPeriods->getCollection()
  ->sortBy('start_date')
  ->map(function ($period) {
  return [
  'id' => $period->id,
  'academic_year' => $period->academic_year,
  'semester' => $period->semester,
  'start_date' => optional($period->start_date)->format('Y-m-d'),
  'end_date' => optional($period->end_date)->format('Y-m-d'),
  ];
  })
  ->values()
  ->all();

  $holidayEvents = collect($holidays ?? [])
  ->map(function ($name, $date) {
  return [
  'date' => $date,
  'label' => $name,
  'year' => date('Y', strtotime($date)),
  'color' => '#6b7280',
  'type' => 'holiday',
  ];
  })
  ->values()
  ->all();

  $activePeriodPayload = $activePeriod ? [
  'id' => $activePeriod->id,
  'academic_year' => $activePeriod->academic_year,
  'semester' => $activePeriod->semester,
  'start_date' => optional($activePeriod->start_date)->format('Y-m-d'),
  'end_date' => optional($activePeriod->end_date)->format('Y-m-d'),
  'description' => $activePeriod->description,
  'is_active' => (bool) $activePeriod->is_active,
  ] : null;
  @endphp

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
          class="group-header {{ request()->routeIs('admin.user_management*','admin.role_permissions','admin.academic_periods*') ? 'active-group' : '' }}">
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
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
              class="fa-solid fa-calendar-days"></i> Clinic Schedule</a>
          <a href="{{ route('admin.admin.dashboard') }}" class="nav-link {{ false ? 'active' : '' }}"><i
              class="fa-solid fa-list-check"></i> Service Types</a>
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
      <form action="{{ route('logout') }}" method="POST">
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

      @if(session('success'))
      <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
      </div>
      @endif

      @if($errors->any())
      <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <div class="font-bold mb-1">Please fix the following:</div>
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
          <i class="fa-solid fa-sun text-yellow-400 text-xs" id="timeIcon"></i>
          <p id="currentDateTime"></p>
        </div>
        <div class="flex items-end justify-between flex-wrap gap-3">
          <h1 class="text-3xl md:text-4xl font-extrabold text-[#8B0000]">Academic Periods</h1>
          <button onclick="openModal('addModal')" type="button"
            class="flex items-center gap-2 bg-[#8B0000] hover:bg-[#760000] text-white px-5 py-2.5 rounded-lg font-semibold text-sm shadow transition-all">
            <i class="fa-solid fa-plus"></i> Add Period
          </button>
        </div>
      </div>

      <div class="active-banner mb-6" id="activeBannerWrap">
        <div class="active-banner-inner">
          <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div>
              <div class="flex items-center gap-2 mb-1">
                <i class="fa-solid fa-calendar text-[#8B0000] text-sm"></i>
                <p class="text-[10px] tracking-widest text-gray-500 uppercase font-semibold">Current Semester</p>
              </div>
              <p class="text-xl font-bold text-gray-800" id="bannerSem">{{ $activePeriod?->semester ?? 'No Active
                Period' }}</p>
            </div>
            <div>
              <div class="flex items-center gap-2 mb-1">
                <i class="fa-solid fa-graduation-cap text-[#8B0000] text-sm"></i>
                <p class="text-[10px] tracking-widest text-gray-500 uppercase font-semibold">Academic Year</p>
              </div>
              <p class="text-xl font-bold text-gray-800" id="bannerYear">{{ $activePeriod?->academic_year ?? '—' }}</p>
            </div>
            <div>
              <div class="flex items-center gap-2 mb-1">
                <i class="fa-solid fa-clock text-[#8B0000] text-sm"></i>
                <p class="text-[10px] tracking-widest text-gray-500 uppercase font-semibold">Period Ends</p>
              </div>
              <p class="text-xl font-bold text-gray-800" id="bannerEnd">{{ $activePeriod ?
                $activePeriod->end_date->format('F d, Y') : '—' }}</p>
            </div>
          </div>

          <div class="flex flex-col gap-3 lg:flex-shrink-0 lg:w-64">
            <div>
              <div class="flex justify-between items-center mb-1.5">
                <span class="text-[10px] text-gray-500 uppercase tracking-widest font-semibold">Semester Progress</span>
                <span class="text-[11px] font-bold text-[#8B0000]" id="bannerPct">{{ $activePeriod?->progress_percent ??
                  0 }}%</span>
              </div>
              <div class="progress-track">
                <div class="progress-fill" id="bannerFill" style="width:{{ $activePeriod?->progress_percent ?? 0 }}%;">
                </div>
              </div>
              <p class="text-[10px] text-gray-400 mt-1" id="bannerDaysLeft">
                {{ $activePeriod ? $activePeriod->days_remaining . ' day' . ($activePeriod->days_remaining !== 1 ? 's' :
                '') . ' remaining' : 'No active period' }}
              </p>
            </div>

            <button type="button" onclick='@if($activePeriodPayload) openEditModal(@json($activePeriodPayload)) @endif'
              class="bg-[#8B0000] hover:bg-[#760000] text-white px-5 py-2.5 rounded-lg font-semibold text-sm shadow transition-all flex items-center justify-center gap-2">
              <i class="fa-solid fa-gear"></i> Manage Period
            </button>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2">
          <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">

            <div
              class="px-5 py-4 border-b bg-gray-50 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
              <div class="flex items-center gap-2">
                <i class="fa-solid fa-school text-[#8B0000]"></i>
                <h2 class="font-bold text-gray-800 text-sm">All Academic Periods</h2>
                <span id="periodCount" class="text-[10px] font-bold bg-[#8B0000] text-white px-2 py-0.5 rounded-full">
                  {{ $academicPeriods->total() }}
                </span>
              </div>

              <form method="GET" action="{{ route('admin.academic_periods') }}"
                class="flex flex-wrap items-center gap-2" id="filterForm">
                <div class="relative">
                  <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                    style="font-size:11px;"></i>
                  <input type="text" name="search" value="{{ request('search') }}" placeholder="Search…"
                    class="field-input pl-8 pr-3 py-2 text-xs border border-gray-200 rounded-lg bg-white w-40"
                    id="searchInput" autocomplete="off">
                  <button type="button" id="clearSearch"
                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-300 hover:text-gray-500 hidden">
                    <i class="fa-solid fa-xmark" style="font-size:10px;"></i>
                  </button>
                </div>

                <select name="semester"
                  class="field-input text-xs border border-gray-200 rounded-lg px-3 py-2 bg-white text-gray-600"
                  style="cursor:pointer;" onchange="this.form.submit()">
                  <option value="">All Semesters</option>
                  <option value="1st Semester" {{ request('semester')==='1st Semester' ? 'selected' : '' }}>1st Semester
                  </option>
                  <option value="2nd Semester" {{ request('semester')==='2nd Semester' ? 'selected' : '' }}>2nd Semester
                  </option>
                  <option value="Summer" {{ request('semester')==='Summer' ? 'selected' : '' }}>Summer</option>
                </select>

                <select name="status"
                  class="field-input text-xs border border-gray-200 rounded-lg px-3 py-2 bg-white text-gray-600"
                  style="cursor:pointer;" onchange="this.form.submit()">
                  <option value="">All Status</option>
                  <option value="Active" {{ request('status')==='Active' ? 'selected' : '' }}>Active</option>
                  <option value="Upcoming" {{ request('status')==='Upcoming' ? 'selected' : '' }}>Upcoming</option>
                  <option value="Ended" {{ request('status')==='Ended' ? 'selected' : '' }}>Ended</option>
                  <option value="Inactive" {{ request('status')==='Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit" class="px-4 py-2 rounded-lg bg-[#8B0000] text-white text-xs font-semibold">
                  Filter
                </button>

                <a href="{{ route('admin.academic_periods') }}"
                  class="px-4 py-2 rounded-lg border border-gray-200 text-xs font-semibold text-gray-600">
                  Reset
                </a>
              </form>
            </div>

            <div class="overflow-x-auto">
              <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                  <tr class="text-[10px] uppercase tracking-wide text-[#8B0000] font-bold">
                    <th class="py-3 px-4 text-left">#</th>
                    <th class="py-3 px-4 text-left">Year</th>
                    <th class="py-3 px-4 text-left">Semester</th>
                    <th class="py-3 px-4 text-left">Start</th>
                    <th class="py-3 px-4 text-left">End</th>
                    <th class="py-3 px-4 text-center">Status</th>
                    <th class="py-3 px-4 text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($academicPeriods as $index => $period)
                  @php
                  $statusClass = match($period->status) {
                  'Active' => 's-active',
                  'Upcoming' => 's-upcoming',
                  'Ended' => 's-ended',
                  default => 's-inactive',
                  };

                  $semStyle = match($period->semester) {
                  '1st Semester' => ['bg' => '#fee2e2', 'color' => '#8B0000'],
                  '2nd Semester' => ['bg' => '#dbeafe', 'color' => '#1d4ed8'],
                  'Summer' => ['bg' => '#fef3c7', 'color' => '#92400e'],
                  default => ['bg' => '#f3f4f6', 'color' => '#6b7280'],
                  };

                  $periodPayload = [
                  'id' => $period->id,
                  'academic_year' => $period->academic_year,
                  'semester' => $period->semester,
                  'start_date' => optional($period->start_date)->format('Y-m-d'),
                  'end_date' => optional($period->end_date)->format('Y-m-d'),
                  'description' => $period->description,
                  'is_active' => (bool) $period->is_active,
                  ];
                  @endphp

                  <tr class="tbl-row {{ $period->is_active ? 'is-active' : '' }} border-b border-gray-50 last:border-0">
                    <td class="py-3 px-4 text-sm">{{ $academicPeriods->firstItem() + $index }}</td>

                    <td class="py-3 px-4">
                      <div class="flex items-center">
                        @if($period->is_active)
                        <span class="dot-pulse"
                          style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#22c55e;margin-right:6px;"></span>
                        @else
                        <span
                          style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#e5e7eb;margin-right:6px;"></span>
                        @endif
                        <span class="font-bold text-sm">{{ $period->academic_year }}</span>
                      </div>
                    </td>

                    <td class="py-3 px-4">
                      <span class="sem-pill" style="background:{{ $semStyle['bg'] }};color:{{ $semStyle['color'] }};">
                        <i class="fa-solid {{ $period->semester === 'Summer' ? 'fa-sun' : 'fa-book' }}"
                          style="font-size:9px;"></i>
                        {{ $period->semester }}
                      </span>
                    </td>

                    <td class="py-3 px-4 text-xs text-gray-600">{{ optional($period->start_date)->format('M d, Y') }}
                    </td>
                    <td class="py-3 px-4 text-xs text-gray-600">{{ optional($period->end_date)->format('M d, Y') }}</td>

                    <td class="py-3 px-4 text-center">
                      <span class="status-badge {{ $statusClass }}"
                        style="display:inline-flex;align-items:center;gap:3px;font-size:11px;font-weight:700;padding:3px 9px;border-radius:99px;">
                        {{ $period->status }}
                      </span>
                    </td>

                    <td class="py-3 px-4">
                      <div class="flex items-center justify-center gap-2">
                        <button type="button" class="act act-edit" title="Edit"
                          onclick='openEditModal(@json($periodPayload))'>
                          <i class="fa-solid fa-pen" style="font-size:10px;"></i>
                        </button>

                        @if(!$period->is_active)
                        <form method="POST" action="{{ route('admin.academic_periods.set_active', $period) }}"
                          class="inline">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="act act-star" title="Set as active">
                            <i class="fa-solid fa-circle-check" style="font-size:10px;"></i>
                          </button>
                        </form>
                        @else
                        <span class="act act-pinned"><i class="fa-solid fa-star" style="font-size:10px;"></i></span>
                        @endif

                        <button type="button" class="act act-del" title="Delete" onclick='openDeleteModal(@json(route('
                          admin.academic_periods.destroy', $period)), @json($period->academic_year . " — " .
                          $period->semester))'
                          >
                          <i class="fa-solid fa-trash" style="font-size:10px;"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr id="serverEmptyState">
                    <td colspan="7" class="text-center py-12 text-gray-400">
                      <i class="fa-solid fa-school text-3xl mb-3 opacity-30 block"></i>
                      No academic periods found.
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="px-5 py-3.5 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-3">
              <p class="text-xs text-gray-500">
                Showing {{ $academicPeriods->firstItem() ?? 0 }}–{{ $academicPeriods->lastItem() ?? 0 }} of {{
                $academicPeriods->total() }} periods
              </p>

              <div class="flex items-center gap-1.5">
                @php
                  $queryParams = array_filter([
                    'search'   => request('search'),
                    'semester' => request('semester'),
                    'status'   => request('status'),
                  ]);
                  $queryString = $queryParams ? '&' . http_build_query($queryParams) : '';
                @endphp

                @if($academicPeriods->onFirstPage())
                  <span class="page-btn disabled"><i class="fa-solid fa-chevron-left" style="font-size:10px;"></i></span>
                @else
                  <a href="{{ $academicPeriods->previousPageUrl() . $queryString }}" class="page-btn">
                    <i class="fa-solid fa-chevron-left" style="font-size:10px;"></i>
                  </a>
                @endif

                @for($page = 1; $page <= $academicPeriods->lastPage(); $page++)
                  @if($page == $academicPeriods->currentPage())
                    <span class="page-btn active">{{ $page }}</span>
                  @else
                    <a href="{{ $academicPeriods->url($page) . $queryString }}" class="page-btn">{{ $page }}</a>
                  @endif
                @endfor

                @if($academicPeriods->hasMorePages())
                  <a href="{{ $academicPeriods->nextPageUrl() . $queryString }}" class="page-btn">
                    <i class="fa-solid fa-chevron-right" style="font-size:10px;"></i>
                  </a>
                @else
                  <span class="page-btn disabled"><i class="fa-solid fa-chevron-right" style="font-size:10px;"></i></span>
                @endif
              </div>
            </div>
          </div>
        </div>

        <div class="space-y-5">
          <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b bg-gray-50 flex items-center gap-2">
              <i class="fa-solid fa-clock text-[#8B0000]"></i>
              <h2 class="font-bold text-gray-800 text-sm">Date &amp; Time</h2>
              <span class="ml-auto text-[10px] text-gray-400 font-semibold">Philippine Time</span>
            </div>
            <div class="p-5 text-center">
              <div id="liveClock" class="text-4xl font-extrabold text-[#8B0000] tracking-tight leading-none mb-1">
                00:00:00</div>
              <div id="liveAmPm" class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">AM</div>
              <div id="liveDate" class="text-sm font-semibold text-gray-700 mb-1"></div>
              <div id="liveDay" class="text-xs text-gray-400"></div>
            </div>
          </div>

          <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden cal-card">
            <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <i class="fa-solid fa-calendar-days text-[#8B0000]"></i>
                <h2 class="font-bold text-gray-800 text-sm">PUP Academic Calendar</h2>
              </div>
              <span id="calYear"
                class="text-[10px] font-bold text-[#8B0000] bg-red-50 px-2 py-0.5 rounded-full">Academic Periods</span>
            </div>
            <div id="calendarList" class="p-4 space-y-1 overflow-y-auto scrollbar-thin" style="max-height:320px;">
            </div>
            <div class="px-4 pb-4">
              <a href="https://www.pup.edu.ph/calendar/" target="_blank"
                class="flex items-center justify-center gap-2 w-full py-2 rounded-lg border border-gray-200 text-xs font-semibold text-gray-500 hover:bg-red-50 hover:border-[#8B0000] hover:text-[#8B0000] transition-all mt-2">
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                View Full PUP Calendar
              </a>
            </div>
          </div>

          <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b bg-gray-50 flex items-center gap-2">
              <i class="fa-solid fa-bolt text-[#8B0000]"></i>
              <h2 class="font-bold text-gray-800 text-sm">Quick Actions</h2>
            </div>
            <div class="p-4 space-y-2.5">
              <button onclick="openModal('addModal')" type="button"
                class="w-full flex items-center gap-3 bg-gradient-to-r from-red-50 to-white hover:from-red-100 hover:to-red-50 border border-red-100 rounded-lg px-4 py-3 text-left transition-all group">
                <div
                  class="w-10 h-10 rounded-lg bg-white border border-red-200 flex items-center justify-center text-[#8B0000] shadow-sm group-hover:scale-110 transition-transform">
                  <i class="fa-solid fa-plus"></i>
                </div>
                <div class="flex-1">
                  <div class="font-bold text-sm text-[#8B0000]">Add Period</div>
                  <div class="text-[10px] text-gray-500">Create a new academic term</div>
                </div>
                <i
                  class="fa-solid fa-chevron-right text-gray-300 text-xs group-hover:text-[#8B0000] group-hover:translate-x-1 transition-all"></i>
              </button>

              <button type="button"
                onclick='@if($activePeriodPayload) openEditModal(@json($activePeriodPayload)) @endif'
                class="w-full flex items-center gap-3 bg-gradient-to-r from-red-50 to-white hover:from-red-100 hover:to-red-50 border border-red-100 rounded-lg px-4 py-3 text-left transition-all group">
                <div
                  class="w-10 h-10 rounded-lg bg-white border border-red-200 flex items-center justify-center text-[#8B0000] shadow-sm group-hover:scale-110 transition-transform">
                  <i class="fa-solid fa-pen"></i>
                </div>
                <div class="flex-1">
                  <div class="font-bold text-sm text-[#8B0000]">Edit Active Period</div>
                  <div class="text-[10px] text-gray-500">Modify current semester</div>
                </div>
                <i
                  class="fa-solid fa-chevron-right text-gray-300 text-xs group-hover:text-[#8B0000] group-hover:translate-x-1 transition-all"></i>
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
      <span><span class="text-gray-300">© 2025–2026</span> <span class="font-semibold">Polytechnic University of
          the Philippines</span></span>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/terms/" class="hover:underline">Terms of Use</a>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/privacy/" class="hover:underline">Privacy Statement</a>
    </div>
  </footer>

  <div class="modal-overlay" id="addModal" onclick="closeModalOutside(event,'addModal')">
    <div class="modal-box">
      <form method="POST" action="{{ route('admin.academic_periods.store') }}">
        @csrf

        <div
          class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
          <div class="flex items-center gap-3">
            <div
              class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#6B0000] flex items-center justify-center shadow">
              <i class="fa-solid fa-plus text-white text-sm"></i>
            </div>
            <div>
              <h3 class="font-extrabold text-gray-800 text-base">Add Academic Period</h3>
              <p class="text-[10px] text-gray-500">Define a new semester or academic term</p>
            </div>
          </div>
          <button type="button" onclick="closeModal('addModal')"
            class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>

        <div class="p-6 space-y-4">
          <div>
            <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Academic Year <span
                class="text-red-500">*</span></label>
            <div class="relative">
              <i class="fa-solid fa-graduation-cap absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
              <input name="academic_year" type="text" placeholder="e.g. 2026-2027"
                class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm" required>
            </div>
          </div>

          <div>
            <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-2">Semester <span
                class="text-red-500">*</span></label>
            <div class="grid grid-cols-3 gap-2">
              <label class="cursor-pointer">
                <input type="radio" name="semester" value="1st Semester" class="sr-only peer" required>
                <div
                  class="peer-checked:bg-[#8B0000] peer-checked:text-white peer-checked:border-[#8B0000] border-2 border-gray-200 rounded-xl p-3 text-center text-xs font-bold text-gray-500 hover:border-[#8B0000] hover:text-[#8B0000] transition-all select-none">
                  <i class="fa-solid fa-book block text-xl mb-1.5"></i>1st Semester
                </div>
              </label>

              <label class="cursor-pointer">
                <input type="radio" name="semester" value="2nd Semester" class="sr-only peer" required>
                <div
                  class="peer-checked:bg-[#8B0000] peer-checked:text-white peer-checked:border-[#8B0000] border-2 border-gray-200 rounded-xl p-3 text-center text-xs font-bold text-gray-500 hover:border-[#8B0000] hover:text-[#8B0000] transition-all select-none">
                  <i class="fa-solid fa-book block text-xl mb-1.5"></i>2nd Semester
                </div>
              </label>

              <label class="cursor-pointer">
                <input type="radio" name="semester" value="Summer" class="sr-only peer" required>
                <div
                  class="peer-checked:bg-[#8B0000] peer-checked:text-white peer-checked:border-[#8B0000] border-2 border-gray-200 rounded-xl p-3 text-center text-xs font-bold text-gray-500 hover:border-[#8B0000] hover:text-[#8B0000] transition-all select-none">
                  <i class="fa-solid fa-sun block text-xl mb-1.5"></i>Summer
                </div>
              </label>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Start Date <span
                  class="text-red-500">*</span></label>
              <div class="relative">
                <i class="fa-solid fa-calendar-day absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input name="start_date" type="date"
                  class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm" required>
              </div>
            </div>

            <div>
              <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">End Date <span
                  class="text-red-500">*</span></label>
              <div class="relative">
                <i
                  class="fa-solid fa-calendar-check absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input name="end_date" type="date"
                  class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm" required>
              </div>
            </div>
          </div>

          <div>
            <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Description</label>
            <textarea name="description" rows="2"
              class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm resize-none"></textarea>
          </div>

          <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">
            <div class="flex items-center gap-2">
              <i class="fa-solid fa-star text-[#8B0000]"></i>
              <div>
                <div class="text-sm font-semibold text-gray-700">Set as Active Period</div>
                <div class="text-[10px] text-gray-400">Deactivates the current active period</div>
              </div>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
              <input type="hidden" name="is_active" value="0">
              <input type="checkbox" name="is_active" value="1" class="sr-only peer">
              <div
                class="w-10 h-5 bg-gray-200 rounded-full peer peer-checked:bg-[#8B0000] transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-5">
              </div>
            </label>
          </div>
        </div>

        <div class="px-6 pb-6 pt-2 flex items-center justify-end gap-3">
          <button type="button" onclick="closeModal('addModal')"
            class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">Cancel</button>
          <button type="submit"
            class="px-6 py-2.5 rounded-lg bg-[#8B0000] hover:bg-[#760000] text-white text-sm font-bold shadow transition-all flex items-center gap-2">
            <i class="fa-solid fa-floppy-disk"></i> Save Period
          </button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal-overlay" id="editModal" onclick="closeModalOutside(event,'editModal')">
    <div class="modal-box">
      <form method="POST" id="editForm">
        @csrf
        @method('PUT')

        <div
          class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
          <div class="flex items-center gap-3">
            <div
              class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow">
              <i class="fa-solid fa-pen text-white text-sm"></i>
            </div>
            <div>
              <h3 class="font-extrabold text-gray-800 text-base">Edit Academic Period</h3>
              <p class="text-[10px] text-gray-500" id="editSubtitle">Updating period details</p>
            </div>
          </div>
          <button type="button" onclick="closeModal('editModal')"
            class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>

        <div class="p-6 space-y-4">
          <div>
            <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Academic
              Year</label>
            <input type="text" name="academic_year" id="editYear"
              class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm" required>
          </div>

          <div>
            <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-2">Semester</label>
            <div class="grid grid-cols-3 gap-2">
              <label class="cursor-pointer">
                <input type="radio" name="semester" value="1st Semester" class="sr-only peer edit-sem" required>
                <div
                  class="peer-checked:bg-[#8B0000] peer-checked:text-white peer-checked:border-[#8B0000] border-2 border-gray-200 rounded-xl p-3 text-center text-xs font-bold text-gray-500">
                  1st Semester</div>
              </label>
              <label class="cursor-pointer">
                <input type="radio" name="semester" value="2nd Semester" class="sr-only peer edit-sem" required>
                <div
                  class="peer-checked:bg-[#8B0000] peer-checked:text-white peer-checked:border-[#8B0000] border-2 border-gray-200 rounded-xl p-3 text-center text-xs font-bold text-gray-500">
                  2nd Semester</div>
              </label>
              <label class="cursor-pointer">
                <input type="radio" name="semester" value="Summer" class="sr-only peer edit-sem" required>
                <div
                  class="peer-checked:bg-[#8B0000] peer-checked:text-white peer-checked:border-[#8B0000] border-2 border-gray-200 rounded-xl p-3 text-center text-xs font-bold text-gray-500">
                  Summer</div>
              </label>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Start Date</label>
              <input type="date" name="start_date" id="editStart"
                class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm" required>
            </div>
            <div>
              <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">End Date</label>
              <input type="date" name="end_date" id="editEnd"
                class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm" required>
            </div>
          </div>

          <div>
            <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Description</label>
            <textarea rows="2" name="description" id="editDesc"
              class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm resize-none"></textarea>
          </div>

          <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50 px-4 py-3">
            <div class="flex items-center gap-2">
              <i class="fa-solid fa-star text-[#8B0000]"></i>
              <div>
                <div class="text-sm font-semibold text-gray-700">Set as Active Period</div>
                <div class="text-[10px] text-gray-400">Deactivates the current active period</div>
              </div>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
              <input type="hidden" name="is_active" value="0">
              <input type="checkbox" name="is_active" id="editIsActive" value="1" class="sr-only peer">
              <div
                class="w-10 h-5 bg-gray-200 rounded-full peer peer-checked:bg-[#8B0000] transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-5">
              </div>
            </label>
          </div>
        </div>

        <div class="px-6 pb-6 pt-2 flex items-center justify-end gap-3">
          <button type="button" onclick="closeModal('editModal')"
            class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">Cancel</button>
          <button type="submit"
            class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold shadow transition-all flex items-center gap-2">
            <i class="fa-solid fa-floppy-disk"></i> Update Period
          </button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal-overlay modal-sm" id="deleteModal" onclick="closeModalOutside(event,'deleteModal')">
    <div class="modal-box">
      <form method="POST" id="deleteForm">
        @csrf
        @method('DELETE')

        <div class="p-6 text-center">
          <div
            class="w-16 h-16 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-triangle-exclamation text-[#8B0000] text-2xl"></i>
          </div>
          <h3 class="text-lg font-extrabold text-gray-800 mb-2">Delete Academic Period?</h3>
          <p class="text-sm text-gray-500 mb-1">You are about to permanently delete</p>
          <p class="font-bold text-[#8B0000] text-base mb-4" id="deletePeriodLabel">—</p>

          <div class="flex gap-3">
            <button type="button" onclick="closeModal('deleteModal')"
              class="flex-1 py-2.5 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">Cancel</button>
            <button type="submit"
              class="flex-1 py-2.5 rounded-lg bg-[#8B0000] hover:bg-[#760000] text-white text-sm font-bold shadow transition-all">
              <i class="fa-solid fa-trash mr-1.5"></i> Delete
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
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
      applyTheme(localStorage.getItem('theme') || 'light');
      document.querySelectorAll('.theme-option').forEach(o =>
        o.addEventListener('click', e => { e.stopPropagation(); applyTheme(o.getAttribute('data-theme')); })
      );
    });

    const calendarPeriods = @json($calendarPeriods);
    const holidayEvents = @json($holidayEvents);

    function renderCalendar() {
      const list = document.getElementById('calendarList');
      const calYear = document.getElementById('calYear');
      if (!list) return;

      const periodEvents = [];

      calendarPeriods.forEach(period => {

        if (period.start_date) {
          periodEvents.push({
            date: period.start_date,
            label: `${period.semester} Start`,
            year: period.academic_year,
            color: '#8B0000',
            type: 'start'
          });
        }

        if (period.end_date) {
          periodEvents.push({
            date: period.end_date,
            label: `${period.semester} End`,
            year: period.academic_year,
            color: '#2563eb',
            type: 'end'
          });
        }

      });

      const events = [...periodEvents, ...holidayEvents].sort((a, b) => a.date.localeCompare(b.date));

      const today = todayStr();
      const upcoming = events.filter(e => e.date >= today).slice(0, 8);
      const past = events.filter(e => e.date < today).slice(-3);
      const show = [...past, ...upcoming].sort((a, b) => a.date.localeCompare(b.date));

      if (show.length) {
        const years = [...new Set(show.map(e => e.year))];
        calYear.textContent = years.length === 1 ? years[0] : 'Academic Periods & Holidays';
      } else {
        calYear.textContent = 'Academic Periods & Holidays';
      }

      if (!show.length) {
        list.innerHTML = '<p class="text-xs text-gray-400 text-center py-3">No events found</p>';
        return;
      }

      list.innerHTML = show.map(e => {
        const d = new Date(e.date + 'T00:00:00');
        const isToday = e.date === today;
        const isPast = e.date < today;
        const mon = d.toLocaleDateString('en-US', { month: 'short' });
        const day = d.getDate();
        const isHoliday = e.type === 'holiday';
        let color = e.color;
        if (e.type === 'holiday') color = '#16a34a';
        if (e.type === 'start') color = '#8B0000';
        if (e.type === 'end') color = '#2563eb';

        return `
      <div class="flex items-start gap-3 py-2 border-b border-gray-50 last:border-0 ${isPast ? 'opacity-50' : ''}">
        <div style="flex-shrink:0;width:38px;text-align:center;background:${isToday ? '#8B0000' : isHoliday ? '#f3f4f6' : '#fef2f2'};
                    border-radius:8px;padding:4px 2px;border:1px solid ${isToday ? '#8B0000' : isHoliday ? '#e5e7eb' : '#fde8e8'}">
          <div style="font-size:9px;font-weight:700;text-transform:uppercase;color:${isToday ? 'rgba(255,255,255,.8)' : isHoliday ? '#6b7280' : '#8B0000'};">${mon}</div>
          <div style="font-size:16px;font-weight:900;line-height:1;color:${isToday ? '#fff' : isHoliday ? '#374151' : '#8B0000'};">${day}</div>
        </div>
        <div style="flex:1;min-width:0;">
          <div style="font-size:12px;font-weight:${isToday ? '700' : '600'};color:${isToday ? '#8B0000' : '#374151'};white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
            ${e.label}
          </div>
          <div style="font-size:10px;color:#9ca3af;margin-top:1px;">
            ${e.year}${isHoliday ? ' • Holiday' : ''}${isToday ? ' • Today' : ''}
          </div>
        </div>
        <div style="width:8px;height:8px;border-radius:50%;background:${color};flex-shrink:0;margin-top:4px;"></div>
      </div>
    `;
      }).join('');
    }

    function todayStr() {
      const now = new Date();
      const ph = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
      return `${ph.getFullYear()}-${String(ph.getMonth() + 1).padStart(2, '0')}-${String(ph.getDate()).padStart(2, '0')}`;
    }

    function openModal(id) {
      document.getElementById(id).classList.add('open');
    }

    function closeModal(id) {
      document.getElementById(id).classList.remove('open');
    }

    function closeModalOutside(e, id) {
      if (e.target.id === id) {
        closeModal(id);
      }
    }

    function openEditModal(period) {
      document.getElementById('editForm').action = `/admin/academic-periods/${period.id}`;
      document.getElementById('editYear').value = period.academic_year ?? '';
      document.getElementById('editStart').value = period.start_date ?? '';
      document.getElementById('editEnd').value = period.end_date ?? '';
      document.getElementById('editDesc').value = period.description ?? '';
      document.getElementById('editIsActive').checked = !!period.is_active;
      document.getElementById('editSubtitle').textContent = `${period.academic_year} — ${period.semester}`;

      document.querySelectorAll('.edit-sem').forEach(radio => {
        radio.checked = radio.value === period.semester;
      });

      openModal('editModal');
    }

    function openDeleteModal(action, label) {
      document.getElementById('deleteForm').action = action;
      document.getElementById('deletePeriodLabel').textContent = label;
      openModal('deleteModal');
    }

    function updateClock() {
      const now = new Date();
      const ph = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
      let h = ph.getHours();
      const m = String(ph.getMinutes()).padStart(2, '0');
      const s = String(ph.getSeconds()).padStart(2, '0');
      const ampm = h >= 12 ? 'PM' : 'AM';
      h = h % 12 || 12;
      const hh = String(h).padStart(2, '0');

      const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
      const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

      const liveClock = document.getElementById('liveClock');
      const liveAmPm = document.getElementById('liveAmPm');
      const liveDate = document.getElementById('liveDate');
      const liveDay = document.getElementById('liveDay');
      const currentDateTime = document.getElementById('currentDateTime');
      const timeIcon = document.getElementById('timeIcon');

      if (liveClock) liveClock.textContent = `${hh}:${m}:${s}`;
      if (liveAmPm) liveAmPm.textContent = ampm;
      if (liveDate) liveDate.textContent = `${months[ph.getMonth()]} ${ph.getDate()}, ${ph.getFullYear()}`;
      if (liveDay) liveDay.textContent = days[ph.getDay()];
      if (currentDateTime) currentDateTime.textContent = `${days[ph.getDay()]}, ${months[ph.getMonth()]} ${ph.getDate()}, ${ph.getFullYear()} · ${hh}:${m} ${ampm}`;

      if (timeIcon) {
        if (ph.getHours() >= 6 && ph.getHours() < 18) {
          timeIcon.className = 'fa-solid fa-sun text-yellow-400 text-xs';
        } else {
          timeIcon.className = 'fa-solid fa-moon text-indigo-400 text-xs';
        }
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      updateClock();
      renderCalendar();
      setInterval(updateClock, 1000);
    });

    // ── LIVE SEARCH ──
    document.addEventListener('DOMContentLoaded', () => {
      const searchInput = document.getElementById('searchInput');
      const clearBtn = document.getElementById('clearSearch');
      const tbody = document.querySelector('tbody');
      const allRows = () => tbody.querySelectorAll('tr.tbl-row');
      let searchTimer = null;

      function getEmptyRow() {
        return document.getElementById('jsEmptyState');
      }

      function showEmptyState(query) {
        let el = getEmptyRow();
        if (!el) {
          el = document.createElement('tr');
          el.id = 'jsEmptyState';
          el.innerHTML = `
            <td colspan="7" class="text-center py-12 text-gray-400">
              <i class="fa-solid fa-magnifying-glass text-3xl mb-3 opacity-30 block"></i>
              <p class="font-semibold text-sm text-gray-500 mb-1">No results for "<span id="jsEmptyQuery"></span>"</p>
              <p class="text-xs text-gray-400">Try a different academic year or semester name.</p>
            </td>`;
          tbody.appendChild(el);
        }
        document.getElementById('jsEmptyQuery').textContent = query;
        el.style.display = '';

        const serverEmpty = document.getElementById('serverEmptyState');
        if (serverEmpty) serverEmpty.style.display = 'none';
      }

      function hideEmptyState() {
        const el = getEmptyRow();
        if (el) el.style.display = 'none';

        const serverEmpty = document.getElementById('serverEmptyState');
        if (serverEmpty) serverEmpty.style.display = '';
      }

      function doSearch(query) {
        const q = query.trim().toLowerCase();
        const rows = allRows();

        clearBtn.classList.toggle('hidden', q === '');

        if (q === '') {
          rows.forEach(r => r.style.display = '');
          hideEmptyState();
          return;
        }

        let visibleCount = 0;
        rows.forEach(row => {
          const text = row.textContent.toLowerCase();
          if (text.includes(q)) {
            row.style.display = '';
            visibleCount++;
          } else {
            row.style.display = 'none';
          }
        });

        if (visibleCount === 0) {
          showEmptyState(query.trim());
        } else {
          hideEmptyState();
        }
      }

      searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => doSearch(searchInput.value), 250);
      });

      clearBtn.addEventListener('click', () => {
        searchInput.value = '';
        doSearch('');
        searchInput.focus();
      });

      searchInput.addEventListener('keydown', e => {
        if (e.key === 'Enter') e.preventDefault();
      });

      if (searchInput.value) doSearch(searchInput.value);
    });

  </script>

</body>

</html>