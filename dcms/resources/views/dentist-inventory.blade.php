<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Inventory | PUP Taguig Dental Clinic</title>
  <link rel="icon" type="image/png" href="{{ asset('images/PUPT-DMS-Logo.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    /* Fade-in animation */
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

    /* ── SIDEBAR (UNCHANGED) ── */
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

    /* ── NOTIFICATIONS (UNCHANGED) ── */
    .notif-open {
      opacity: 1 !important;
      transform: scale(1) !important;
      pointer-events: auto !important;
    }

    .notif-close {
      opacity: 0 !important;
      transform: scale(.95) !important;
      pointer-events: none !important;
    }

    /* ── THEME TOGGLE (UNCHANGED) ── */
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

    /* ── DARK MODE (UNCHANGED) ── */
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

    /* ══════════════════════════════════════
       NEW INVENTORY STYLES
    ══════════════════════════════════════ */

    /* ── STAT CARDS ── */
    .stat-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }

    .stat-card {
      background: #fff;
      border-radius: 16px;
      padding: 20px 22px;
      border: 1px solid #E8E4DE;
      box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
      position: relative;
      overflow: hidden;
      transition: transform .2s, box-shadow .2s;
    }

    .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, .09);
    }

    .stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
    }

    .stat-card.s-total::before {
      background: linear-gradient(90deg, #660000, #8B0000);
    }

    .stat-card.s-medicine::before {
      background: linear-gradient(90deg, #1565C0, #42A5F5);
    }

    .stat-card.s-supplies::before {
      background: linear-gradient(90deg, #2E7D32, #66BB6A);
    }

    .stat-card.s-low::before {
      background: linear-gradient(90deg, #E65100, #FFA726);
    }

    .stat-label {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .09em;
      color: #9A9490;
      margin-bottom: 10px;
    }

    .stat-value {
      font-size: 34px;
      font-weight: 800;
      line-height: 1;
    }

    .stat-card.s-total .stat-value {
      color: #8B0000;
    }

    .stat-card.s-medicine .stat-value {
      color: #1565C0;
    }

    .stat-card.s-supplies .stat-value {
      color: #2E7D32;
    }

    .stat-card.s-low .stat-value {
      color: #E65100;
    }

    .stat-footer {
      font-size: 11px;
      color: #ADA9A5;
      margin-top: 8px;
    }

    .stat-icon {
      position: absolute;
      right: 18px;
      top: 50%;
      transform: translateY(-50%);
      width: 42px;
      height: 42px;
      border-radius: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }

    .stat-card.s-total .stat-icon {
      background: #FFF0F0;
      color: #8B0000;
    }

    .stat-card.s-medicine .stat-icon {
      background: #E3F2FD;
      color: #1565C0;
    }

    .stat-card.s-supplies .stat-icon {
      background: #E8F5E9;
      color: #2E7D32;
    }

    .stat-card.s-low .stat-icon {
      background: #FFF3E0;
      color: #E65100;
    }

    /* ── SEARCH (UPDATED) ── */
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

    .search-wrap i {
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
      font-family: 'Inter', sans-serif;
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
      background: #8b000076;
      color: #fff;
    }

    .search-clear-btn.visible {
      display: flex;
    }

    /* ── CATEGORY TABS ── */
    .tab-group {
      display: flex;
      background: #F5F2EE;
      border: 1px solid #E8E4DE;
      border-radius: 10px;
      padding: 3px;
      gap: 2px;
    }

    .tab-btn {
      padding: 6px 16px;
      border-radius: 7px;
      border: none;
      background: none;
      cursor: pointer;
      font-size: 12px;
      font-weight: 600;
      color: #9A9490;
      transition: all .2s;
      white-space: nowrap;
      font-family: 'Inter', sans-serif;
    }

    .tab-btn.active {
      background: #8B0000;
      color: #fff;
      box-shadow: 0 2px 8px rgba(139, 0, 0, .3);
    }

    /* ── FILTER BTN (UPDATED) ── */
    .btn-filter {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      height: 40px;
      padding: 0 16px;
      border-radius: 10px;
      border: 1.5px solid #E0DDD8;
      background: #fff;
      font-size: 13px;
      font-weight: 600;
      color: #6B6661;
      cursor: pointer;
      transition: all .2s;
      font-family: 'Inter', sans-serif;
    }

    .btn-filter:hover {
      border-color: #8B0000;
      color: #8B0000;
      background: #FFF8F8;
    }

    /* ── ADD ITEM BTN (UPDATED) ── */
    .btn-add {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      height: 40px;
      padding: 0 18px;
      border-radius: 10px;
      border: none;
      background: #8B0000;
      color: #fff;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all .2s;
      font-family: 'Inter', sans-serif;
      box-shadow: 0 3px 10px rgba(139, 0, 0, .3);
    }

    .btn-add:hover {
      background: #660000;
      box-shadow: 0 4px 14px rgba(139, 0, 0, .4);
      transform: translateY(-1px);
    }

    .btn-add .add-icon {
      width: 20px;
      height: 20px;
      border-radius: 5px;
      background: rgba(255, 255, 255, .2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
    }

    /* ── TABLE (UPDATED) ── */
    .inv-table {
      width: 100%;
      border-collapse: collapse;
    }

    .inv-table thead tr {
      background: #FAFAF9;
      border-bottom: 2px solid #EDE9E4;
    }

    .inv-table th {
      padding: 12px 16px;
      text-align: left;
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .1em;
      color: #8B0000;
      white-space: nowrap;
    }

    .inv-table th:last-child {
      text-align: center;
    }

    .inv-table tbody tr {
      border-bottom: 1px solid #F0ECE8;
      transition: background .15s;
    }

    .inv-table tbody tr:last-child {
      border-bottom: none;
    }

    .inv-table tbody tr:hover {
      background: #FFF8F8;
    }

    .inv-table td {
      padding: 14px 16px;
      font-size: 13px;
      color: #333;
      vertical-align: middle;
    }

    .inv-table td:last-child {
      text-align: center;
    }

    .stock-no {
      font-size: 12px;
      font-weight: 500;
      background: #F5F2EE;
      border: 1px solid #E8E4DE;
      padding: 3px 8px;
      border-radius: 6px;
      color: #7A7370;
      display: inline-block;
      font-family: monospace;
    }

    .supply-name {
      font-weight: 600;
      color: #1A1614;
    }

    .supply-cat {
      display: inline-block;
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .06em;
      padding: 2px 8px;
      border-radius: 5px;
      margin-top: 3px;
    }

    .supply-cat.medicine {
      background: #E3F2FD;
      color: #1565C0;
    }

    .supply-cat.supplies {
      background: #E8F5E9;
      color: #2E7D32;
    }

    /* Balance chips */
    .bal-chip {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 4px 10px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 600;
    }

    .bal-chip::before {
      content: '';
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: currentColor;
    }

    .bal-chip.ok {
      background: #D4EDDA;
      color: #1A6B34;
    }

    .bal-chip.low {
      background: #FFF3CD;
      color: #92600A;
    }

    .bal-chip.critical {
      background: #FFE5E5;
      color: #C0392B;
    }

    /* Action buttons */
    .act-btn {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-size: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all .2s;
    }

    .act-btn.edit {
      background: #FFF0F0;
      color: #8B0000;
    }

    .act-btn.edit:hover {
      background: #8B0000;
      color: #fff;
      transform: scale(1.05);
    }

    .act-btn.delete {
      background: #FFF0F0;
      color: #C0392B;
    }

    .act-btn.delete:hover {
      background: #C0392B;
      color: #fff;
      transform: scale(1.05);
    }

    /* Row count */
    .row-count {
      font-size: 12px;
      color: #9A9490;
    }

    /* Table footer / pagination */
    .table-footer-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 16px;
      border-top: 1px solid #EDE9E4;
      background: #FAFAF9;
      border-radius: 0 0 12px 12px;
    }

    /* Empty state */
    .empty-state {
      padding: 72px 0;
      text-align: center;
    }

    .empty-icon {
      width: 68px;
      height: 68px;
      border-radius: 18px;
      background: linear-gradient(135deg, #FFF0F0, #FFE0E0);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      color: #8B0000;
      margin: 0 auto 14px;
    }

    .empty-title {
      font-size: 15px;
      font-weight: 600;
      color: #333;
      margin-bottom: 6px;
    }

    .empty-sub {
      font-size: 13px;
      color: #9A9490;
    }

    /* ── SLIDE-IN FILTER PANEL ── */
    .filter-overlay {
      display: none;
      position: fixed;
      inset: 0;
      z-index: 190;
      background: rgba(0, 0, 0, .35);
      backdrop-filter: blur(2px);
    }

    .filter-overlay.open {
      display: block;
    }

    .filter-panel {
      position: fixed;
      right: -360px;
      top: 0;
      bottom: 0;
      width: 340px;
      z-index: 200;
      background: #fff;
      border-left: 1px solid #E8E4DE;
      box-shadow: -4px 0 24px rgba(0, 0, 0, .1);
      display: flex;
      flex-direction: column;
      transition: right .3s cubic-bezier(.4, 0, .2, 1);
    }

    .filter-panel.open {
      right: 0;
    }

    .fp-header {
      padding: 18px 24px;
      border-bottom: 1px solid #EDE9E4;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .fp-title {
      font-size: 16px;
      font-weight: 700;
      color: #8B0000;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .fp-close-btn {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      border: 1.5px solid #E8E4DE;
      background: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #9A9490;
      font-size: 14px;
      transition: all .2s;
    }

    .fp-close-btn:hover {
      border-color: #8B0000;
      color: #8B0000;
      background: #FFF8F8;
    }

    .fp-body {
      flex: 1;
      overflow-y: auto;
      padding: 20px 24px;
    }

    .fp-section {
      margin-bottom: 22px;
    }

    .fp-section-title {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .1em;
      color: #9A9490;
      margin-bottom: 10px;
    }

    .fp-radio-item {
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      padding: 8px 12px;
      border-radius: 8px;
      transition: background .15s;
      margin-bottom: 2px;
    }

    .fp-radio-item:hover {
      background: #FFF5F5;
    }

    .fp-radio-item input[type="radio"] {
      accent-color: #8B0000;
      width: 16px;
      height: 16px;
    }

    .fp-radio-item label {
      font-size: 13px;
      color: #333;
      cursor: pointer;
    }

    .fp-date-row {
      display: flex;
      gap: 10px;
      margin-bottom: 10px;
    }

    .fp-date-group {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .fp-date-label {
      font-size: 11px;
      color: #9A9490;
      font-weight: 600;
    }

    .fp-date-input {
      height: 38px;
      padding: 0 12px;
      border: 1.5px solid #E0DDD8;
      border-radius: 8px;
      font-size: 12px;
      font-family: 'Inter', sans-serif;
      outline: none;
      transition: border-color .2s;
      background: #FAFAF9;
      color: #333;
    }

    .fp-date-input:focus {
      border-color: #8B0000;
      box-shadow: 0 0 0 3px rgba(139, 0, 0, .08);
    }

    .fp-footer {
      padding: 14px 24px;
      border-top: 1px solid #EDE9E4;
      display: flex;
      gap: 10px;
    }

    .fp-btn-clear {
      flex: 1;
      height: 40px;
      border-radius: 10px;
      border: 1.5px solid #E0DDD8;
      background: #fff;
      font-size: 13px;
      font-weight: 600;
      color: #8B0000;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      transition: all .2s;
    }

    .fp-btn-clear:hover {
      background: #FFF8F8;
    }

    .fp-btn-apply {
      flex: 2;
      height: 40px;
      border-radius: 10px;
      border: none;
      background: #8B0000;
      color: #fff;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      transition: all .2s;
      box-shadow: 0 3px 10px rgba(139, 0, 0, .3);
    }

    .fp-btn-apply:hover {
      background: #660000;
    }

    /* ── MODAL UPDATES ── */
    .modal-box-custom {
      background: #fff;
      border-radius: 18px;
      padding: 28px;
      width: 500px;
      max-width: 95vw;
      box-shadow: 0 20px 60px rgba(0, 0, 0, .15);
    }

    .modal-header-custom {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 24px;
    }

    .modal-icon-custom {
      width: 42px;
      height: 42px;
      border-radius: 11px;
      background: linear-gradient(135deg, #660000, #8B0000);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 17px;
      color: #fff;
    }

    .modal-title-custom {
      font-size: 18px;
      font-weight: 700;
      color: #660000;
    }

    .modal-sub-custom {
      font-size: 12px;
      color: #9A9490;
      margin-top: 1px;
    }

    .form-grid-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    .form-group-custom {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    .form-group-custom.full {
      grid-column: 1 / -1;
    }

    .form-label-custom {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: #8B0000;
    }

    .form-input-custom,
    .form-select-custom {
      height: 40px;
      padding: 0 13px;
      border-radius: 9px;
      border: 1.5px solid #E0DDD8;
      background: #FAFAF9;
      font-size: 13px;
      color: #333;
      font-family: 'Inter', sans-serif;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }

    .form-input-custom:focus,
    .form-select-custom:focus {
      border-color: #8B0000;
      box-shadow: 0 0 0 3px rgba(139, 0, 0, .1);
    }

    .form-input-custom[readonly] {
      background: #F2F0EC;
      color: #9A9490;
      cursor: not-allowed;
    }

    .modal-footer-custom {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-top: 24px;
    }

    .btn-modal-cancel {
      height: 40px;
      padding: 0 20px;
      border-radius: 9px;
      border: 1.5px solid #E0DDD8;
      background: #F5F2EE;
      font-size: 13px;
      font-weight: 600;
      color: #6B6661;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      transition: all .2s;
    }

    .btn-modal-cancel:hover {
      background: #EDE9E4;
    }

    .btn-modal-save {
      height: 40px;
      padding: 0 22px;
      border-radius: 9px;
      border: none;
      background: #8B0000;
      color: #fff;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      transition: all .2s;
      box-shadow: 0 3px 10px rgba(139, 0, 0, .3);
      display: inline-flex;
      align-items: center;
      gap: 7px;
    }

    .btn-modal-save:hover {
      background: #660000;
    }
  </style>
</head>

<body class="bg-[#F4F4F4] min-h-screen flex flex-col">

  <!-- ════════════════════════════
       HEADER (UNCHANGED)
  ════════════════════════════ -->
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

      <div class="flex items-center gap-3">
        <img src="https://i.pravatar.cc/40" class="rounded-full w-10 h-10">
        <div>
          <p class="text-l font-semibold text-[#F4F4F4]">Dr. Nelson Angeles</p>
          <p class="italic text-xs text-[#F4F4F4]/80">Dentist</p>
        </div>
      </div>
    </div>
  </div>

  <!-- ════════════════════════════
       SIDEBAR (UNCHANGED)
  ════════════════════════════ -->
  <aside id="sidebar"
    class="fixed left-0 top-[72px]
         h-[calc(100vh-72px)]
         bg-white
         drop-shadow-xl
         transition-all duration-300
         flex flex-col justify-between z-40 expanded"
    style="width: 200px;">

    <!-- TOP -->
    <div class="pt-4">
      <div id="sidebarToggleWrapper" class="flex items-center justify-end px-4 py-2">
        <button onclick="toggleSidebar()"
          id="sidebarToggleBtn"
          class="w-8 h-8 flex items-center justify-center
              rounded-full text-[#757575] hover:text-[#8B0000]
              hover:bg-[#F0F0F0] transition-all duration-300">
          <i id="sidebarIcon" class="fa-solid fa-xmark text-base"></i>
        </button>
      </div>

      <div class="section-label px-4 mb-6">Navigation</div>

      <nav class="space-y-2 px-3 text-gray-600">

        <a href="{{ route('dentist.dashboard') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8
                transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('dentist.dashboard') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                {{ request()->routeIs('dentist.dashboard') ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200 ml-1">
            <i class="fa-solid fa-chart-line text-lg"></i>
          </span>
          <span class="sidebar-text ml-2 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Dashboard</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Dashboard</span>
        </a>

        <a href="{{ route('dentist.patients') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8
                transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('dentist.patients') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                {{ request()->routeIs('dentist.patients') ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200 ml-1.5">
            <i class="fa-solid fa-users text-lg"></i>
          </span>
          <span class="sidebar-text ml-2 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Patients</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Patients</span>
        </a>

        <a href="{{ route('dentist.appointments') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8
                transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('dentist.appointments') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                {{ request()->routeIs('dentist.appointments') ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200 ml-1">
            <i class="fa-solid fa-calendar-check text-lg"></i>
          </span>
          <span class="sidebar-text ml-2 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Appointments</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Appointments</span>
        </a>

        <a href="{{ route('dentist.documentrequests') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8
                transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('dentist.documentrequests') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                {{ request()->routeIs('dentist.documentrequests') ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200 ml-1">
            <i class="fa-solid fa-file-circle-check text-lg"></i>
          </span>
          <span class="sidebar-text ml-2 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Document Requests</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Document Requests</span>
        </a>

        <a href="{{ route('dentist.inventory') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8
                transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('dentist.inventory') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                {{ request()->routeIs('dentist.inventory') ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200 ml-1">
            <i class="fa-solid fa-box text-lg"></i>
          </span>
          <span class="sidebar-text ml-2 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Inventory</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Inventory</span>
        </a>

        <a href="{{ route('dentist.report') }}"
          class="sidebar-link group relative flex items-center pl-1 pr-3 py-2 rounded-xl mt-8
                transition-all duration-200 hover:bg-[#8B0000] hover:text-[#F4F4F4]
                {{ request()->routeIs('dentist.report') ? 'bg-[#8B0000] text-[#F4F4F4]' : '' }}">
          <span class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r bg-[#8B0000] transition-opacity duration-300
                {{ request()->routeIs('dentist.report') ? 'opacity-100' : 'opacity-0' }}"></span>
          <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors duration-200 ml-1">
            <i class="fa-solid fa-file text-lg"></i>
          </span>
          <span class="sidebar-text ml-2 text-sm font-semibold opacity-100 whitespace-nowrap overflow-hidden transition-all duration-300">Reports</span>
          <span class="sidebar-tooltip absolute left-full ml-4 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Reports</span>
        </a>

      </nav>
    </div>

    <!-- BOTTOM -->
    <div class="px-3 pb-5 space-y-4">
      <div class="section-label">Settings</div>
      <div class="w-full px-3">
        <div id="themeToggle" class="theme-toggle-container">
          <button type="button" class="theme-option active" data-theme="light" aria-label="Light mode">
            <i class="fa-solid fa-sun"></i>
          </button>
          <button type="button" class="theme-option" data-theme="dark" aria-label="Dark mode">
            <i class="fa-regular fa-moon"></i>
          </button>
          <div class="theme-indicator" aria-hidden="true"></div>
        </div>
      </div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="group sidebar-link w-full relative flex items-center rounded-xl text-sm
             text-red-600 hover:bg-red-100 transition-all duration-200">
          <div class="flex items-center justify-center w-8 h-8 rounded-lg flex-shrink-0 transition-all duration-200 ml-2">
            <i class="fa-solid fa-right-from-bracket text-sm"></i>
          </div>
          <span class="sidebar-text ml-2 opacity-0 w-0 font-semibold overflow-hidden transition-all duration-300 delay-150">Log out</span>
          <span class="sidebar-tooltip absolute left-full ml-2 px-3 py-1 rounded-full bg-[#8B0000] text-[#F4F4F4] text-sm font-semibold whitespace-nowrap opacity-0 scale-95 pointer-events-none transition-all duration-200">Log out</span>
        </button>
      </form>
    </div>
  </aside>

  <!-- ════════════════════════════
       MAIN CONTENT (REDESIGNED)
  ════════════════════════════ -->
  <main id="mainContent" class="pt-[88px] px-6 pb-6 min-h-screen fade-in">
    <div class="max-w-7xl mt-4 mx-auto">

      <!-- PAGE TITLE -->
      <div class="mb-6">
        <p class="text-[10px] font-bold uppercase tracking-widest text-[#C9A84C] mb-1">
          <i class="fa-solid fa-box mr-1"></i> Stock Management
        </p>
        <h1 class="text-2xl font-extrabold text-[#660000] leading-tight">Inventory</h1>
        <p class="text-sm text-gray-400 mt-1">Track and manage dental supplies &amp; medicines</p>
      </div>

      <!-- STAT CARDS -->
      <div class="stat-grid">
        <div class="stat-card s-total">
          <div class="stat-label">Total Items</div>
          <div class="stat-value" id="statTotal">—</div>
          <div class="stat-footer">across all categories</div>
          <div class="stat-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
        </div>
        <div class="stat-card s-medicine">
          <div class="stat-label">Medicines</div>
          <div class="stat-value" id="statMedicine">—</div>
          <div class="stat-footer">pharmaceutical items</div>
          <div class="stat-icon"><i class="fa-solid fa-pills"></i></div>
        </div>
        <div class="stat-card s-supplies">
          <div class="stat-label">Dental Supplies</div>
          <div class="stat-value" id="statSupplies">—</div>
          <div class="stat-footer">consumable supplies</div>
          <div class="stat-icon"><i class="fa-solid fa-syringe"></i></div>
        </div>
        <div class="stat-card s-low">
          <div class="stat-label">Low Stock</div>
          <div class="stat-value" id="statLow">—</div>
          <div class="stat-footer">need restocking soon</div>
          <div class="stat-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
        </div>
      </div>

      <!-- TABLE CARD -->
      <div class="bg-white rounded-xl shadow-sm border border-[#EDE9E4] overflow-hidden">

        <!-- TOOLBAR -->
        <div class="flex justify-between items-center px-5 py-4 border-b border-[#EDE9E4] flex-wrap gap-3">

          <div class="flex items-center gap-3 flex-wrap">
            <!-- Search -->
            <div class="search-wrap">
              <i class="fa fa-search"></i>
              <input
                id="searchInput"
                placeholder="Search Stock No., Name…"
                oninput="renderTable(); toggleSearchClear(this)" />
              <button type="button" id="searchClearBtn" class="search-clear-btn" onclick="clearSearch()" title="Clear search">
                <i class="fa-solid fa-xmark"></i>
              </button>
            </div>

            <!-- Category Tabs -->
            <div class="tab-group">
              <button class="tab-btn active" onclick="setTab('all', this)">All</button>
              <button class="tab-btn" onclick="setTab('medicine', this)">Medicine</button>
              <button class="tab-btn" onclick="setTab('supplies', this)">Supplies</button>
            </div>
          </div>

          <div class="flex items-center gap-2">
            <span class="row-count" id="rowCount"></span>

            <button type="button" onclick="openFilterPanel()" class="btn-filter">
              <i class="fa-solid fa-sliders"></i> Filter
            </button>

            <button onclick="resetAddForm(); document.getElementById('addModal').showModal()" class="btn-add">
              <span class="add-icon"><i class="fa-solid fa-plus"></i></span>
              Add Item
            </button>
          </div>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">
          <table class="inv-table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Stock No.</th>
                <th>Supply / Medicine</th>
                <th>Unit</th>
                <th>Qty</th>
                <th>Used</th>
                <th>Balance</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="tableBody"></tbody>
          </table>
        </div>

        <!-- EMPTY STATE (dynamic) -->
        <div id="emptyState" style="display:none;"></div>

        <!-- TABLE FOOTER -->
        <div class="table-footer-bar">
          <span class="text-xs text-gray-400" id="pageInfo"></span>
          <div></div>
        </div>

      </div>
    </div>
  </main>

  <!-- ════════════════════════════
       FOOTER (UNCHANGED)
  ════════════════════════════ -->
  <footer class="footer bg-[#8B0000] text-[#F4F4F4] p-6">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 pl-24 text-sm text-center">
      <span><span class="text-gray-300">© 2025–2026</span> <span class="font-semibold">Polytechnic University of the Philippines</span></span>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/terms/" class="hover:underline">Terms of Use</a>
      <span class="hidden sm:inline">|</span>
      <a href="https://www.pup.edu.ph/privacy/" class="hover:underline">Privacy Statement</a>
    </div>
  </footer>

  <!-- ════════════════════════════
       FILTER SLIDE-IN PANEL
  ════════════════════════════ -->
  <div class="filter-overlay" id="filterOverlay" onclick="closeFilterPanel()"></div>

  <div class="filter-panel" id="filterPanel">
    <div class="fp-header">
      <span class="fp-title"><i class="fa-solid fa-sliders"></i> Filter</span>
      <button class="fp-close-btn" onclick="closeFilterPanel()"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div class="fp-body">

      <!-- Sort -->
      <div class="fp-section">
        <div class="fp-section-title">Sort by Name</div>
        <label class="fp-radio-item">
          <input type="radio" name="fp_sort" value="az">
          <label>A → Z</label>
        </label>
        <label class="fp-radio-item">
          <input type="radio" name="fp_sort" value="za">
          <label>Z → A</label>
        </label>
      </div>

      <!-- Date Received -->
      <div class="fp-section">
        <div class="fp-section-title">Date Received</div>
        <div class="fp-date-row">
          <div class="fp-date-group">
            <span class="fp-date-label">From</span>
            <input id="fp_dateFrom" type="date" class="fp-date-input">
          </div>
          <div class="fp-date-group">
            <span class="fp-date-label">To</span>
            <input id="fp_dateTo" type="date" class="fp-date-input">
          </div>
        </div>
        <label class="fp-radio-item">
          <input type="radio" name="fp_dateOrder" value="asc">
          <label>Ascending</label>
        </label>
        <label class="fp-radio-item">
          <input type="radio" name="fp_dateOrder" value="desc">
          <label>Descending</label>
        </label>
      </div>

      <!-- Stock Level -->
      <div class="fp-section">
        <div class="fp-section-title">Stock Level</div>
        <label class="fp-radio-item">
          <input type="radio" name="fp_stock" value="low-high">
          <label>Lowest → Highest</label>
        </label>
        <label class="fp-radio-item">
          <input type="radio" name="fp_stock" value="high-low">
          <label>Highest → Lowest</label>
        </label>
      </div>

    </div>

    <div class="fp-footer">
      <button class="fp-btn-clear" onclick="clearFilterPanel()">Clear All</button>
      <button class="fp-btn-apply" onclick="saveFilterPanel()"><i class="fa-solid fa-check mr-1"></i> Apply</button>
    </div>
  </div>

  <!-- ════════════════════════════
       ADD MODAL
  ════════════════════════════ -->
  <dialog id="addModal" class="modal">
    <div class="modal-box-custom">

      <div class="modal-header-custom">
        <div class="modal-icon-custom"><i class="fa-solid fa-plus"></i></div>
        <div>
          <div class="modal-title-custom">Add Inventory Item</div>
          <div class="modal-sub-custom">Fill in the details for the new item</div>
        </div>
      </div>

      <div class="form-grid-2">
        <div class="form-group-custom">
          <div class="form-label-custom">Category</div>
          <select id="addCategory" class="form-select-custom">
            <option disabled selected>Select…</option>
            <option value="Medicine">Medicine</option>
            <option value="Supplies">Supplies</option>
          </select>
        </div>
        <div class="form-group-custom">
          <div class="form-label-custom">Date Received</div>
          <input id="addDate" type="date" class="form-input-custom">
        </div>
        <div class="form-group-custom">
          <div class="form-label-custom">Stock Number</div>
          <input id="addStock" class="form-input-custom" placeholder="00-000">
        </div>
        <div class="form-group-custom">
          <div class="form-label-custom">Unit</div>
          <input id="addUnit" class="form-input-custom" placeholder="Box / Bottle / Pack">
        </div>
        <div class="form-group-custom full">
          <div class="form-label-custom">Supply / Medicine Name</div>
          <input id="addName" class="form-input-custom" placeholder="e.g. Nitrile Gloves Large">
        </div>
        <div class="form-group-custom">
          <div class="form-label-custom">Quantity</div>
          <input id="addQty" type="number" class="form-input-custom" placeholder="0" oninput="computeAddBalance()">
        </div>
        <div class="form-group-custom">
          <div class="form-label-custom">Consumed</div>
          <input id="addUsed" type="number" class="form-input-custom" placeholder="0" oninput="computeAddBalance()">
        </div>
        <div class="form-group-custom full">
          <div class="form-label-custom">Balance (auto-calculated)</div>
          <input id="addBalance" class="form-input-custom" readonly placeholder="—">
        </div>
      </div>

      <div class="modal-footer-custom">
        <button class="btn-modal-cancel" onclick="document.getElementById('addModal').close()">Cancel</button>
        <button class="btn-modal-save" onclick="addItem()"><i class="fa-solid fa-floppy-disk"></i> Save Item</button>
      </div>

    </div>
  </dialog>

  <!-- ════════════════════════════
       EDIT MODAL
  ════════════════════════════ -->
  <dialog id="editModal" class="modal">
    <div class="modal-box-custom">

      <div class="modal-header-custom">
        <div class="modal-icon-custom" style="background: linear-gradient(135deg,#1a4a8a,#2563EB);"><i class="fa-solid fa-pen"></i></div>
        <div>
          <div class="modal-title-custom">Edit Inventory Item</div>
          <div class="modal-sub-custom">Update the details for this item</div>
        </div>
      </div>

      <div class="form-grid-2">
        <div class="form-group-custom">
          <div class="form-label-custom">Category</div>
          <select id="editCategory" class="form-select-custom">
            <option value="Medicine">Medicine</option>
            <option value="Supplies">Supplies</option>
          </select>
        </div>
        <div class="form-group-custom">
          <div class="form-label-custom">Date Received</div>
          <input id="editDate" type="date" class="form-input-custom">
        </div>
        <div class="form-group-custom">
          <div class="form-label-custom">Stock Number</div>
          <input id="editStock" class="form-input-custom">
        </div>
        <div class="form-group-custom">
          <div class="form-label-custom">Unit</div>
          <input id="editUnit" class="form-input-custom" placeholder="Box / Bottle / Pack">
        </div>
        <div class="form-group-custom full">
          <div class="form-label-custom">Supply / Medicine Name</div>
          <input id="editName" class="form-input-custom">
        </div>
        <div class="form-group-custom">
          <div class="form-label-custom">Quantity</div>
          <input id="editQty" type="number" class="form-input-custom" oninput="computeEditBalance()">
        </div>
        <div class="form-group-custom">
          <div class="form-label-custom">Consumed</div>
          <input id="editUsed" type="number" class="form-input-custom" oninput="computeEditBalance()">
        </div>
        <div class="form-group-custom full">
          <div class="form-label-custom">Balance (auto-calculated)</div>
          <input id="editBalance" class="form-input-custom" readonly>
        </div>
      </div>

      <div class="modal-footer-custom">
        <button class="btn-modal-cancel" onclick="document.getElementById('editModal').close()">Cancel</button>
        <button class="btn-modal-save" onclick="saveEdit()"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
      </div>

    </div>
  </dialog>

  <!-- ════════════════════════════
       DELETE MODAL
  ════════════════════════════ -->
  <dialog id="deleteModal" class="modal">
    <div class="modal-box-custom" style="max-width:400px; text-align:center;">
      <div style="width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,#FFE5E5,#FFCDD2);
                  display:flex;align-items:center;justify-content:center;font-size:26px;
                  color:#C0392B;margin:0 auto 14px;">
        <i class="fa-solid fa-trash"></i>
      </div>
      <div style="font-size:18px;font-weight:700;color:#1A1614;margin-bottom:8px;">Delete Item?</div>
      <div style="font-size:13px;color:#9A9490;margin-bottom:24px;">
        This action cannot be undone. The item will be permanently removed from your inventory.
      </div>
      <div class="modal-footer-custom" style="justify-content:center;">
        <button class="btn-modal-cancel" onclick="document.getElementById('deleteModal').close()">Cancel</button>
        <button id="confirmDeleteBtn" class="btn-modal-save" style="background:#C0392B;box-shadow:0 3px 10px rgba(192,57,43,.3);">
          <i class="fa-solid fa-trash"></i> Delete
        </button>
      </div>
    </div>
  </dialog>

  <!-- ════════════════════════════
       SCRIPTS
  ════════════════════════════ -->
  <script>
    // =========================
    // THEME TOGGLE (UNCHANGED)
    // =========================
    const html = document.documentElement;
    const themeToggleContainer = document.getElementById("themeToggle");
    const themeIndicator = themeToggleContainer.querySelector(".theme-indicator");
    const themeOptions = themeToggleContainer.querySelectorAll(".theme-option");

    function applyTheme(theme) {
      html.setAttribute("data-theme", theme);
      localStorage.setItem("theme", theme);
      themeOptions.forEach(o => o.classList.toggle("active", o.getAttribute("data-theme") === theme));
      themeIndicator.classList.toggle("dark-mode", theme === "dark");
    }
    applyTheme(localStorage.getItem("theme") || "light");
    themeOptions.forEach(o => o.addEventListener("click", () => applyTheme(o.getAttribute("data-theme"))));

    // =========================
    // SIDEBAR TOGGLE (UNCHANGED)
    // =========================
    let sidebarOpen = true;

    function applyLayout(w) {
      document.getElementById('sidebar').style.width = w;
      document.getElementById('mainContent').style.marginLeft = w;
    }

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const texts = document.querySelectorAll('.sidebar-text');
      const icon = document.getElementById('sidebarIcon');
      const tw = document.getElementById('sidebarToggleWrapper');
      sidebarOpen = !sidebarOpen;
      if (sidebarOpen) {
        applyLayout('220px');
        sidebar.classList.replace('collapsed', 'expanded');
        texts.forEach(t => {
          t.classList.remove('opacity-0', 'w-0');
          t.classList.add('opacity-100');
        });
        tw.classList.replace('justify-center', 'justify-end');
        icon.classList.replace('fa-bars', 'fa-xmark');
      } else {
        applyLayout('72px');
        sidebar.classList.replace('expanded', 'collapsed');
        texts.forEach(t => {
          t.classList.add('opacity-0', 'w-0');
          t.classList.remove('opacity-100');
        });
        tw.classList.replace('justify-end', 'justify-center');
        icon.classList.replace('fa-xmark', 'fa-bars');
      }
      applyTheme(localStorage.getItem("theme") || "light");
    }

    document.addEventListener('DOMContentLoaded', () => {
      sidebarOpen = true;
      applyLayout('220px');
    });

    // =========================
    // NOTIFICATIONS (UNCHANGED)
    // =========================
    document.addEventListener("DOMContentLoaded", () => {
      const btn = document.getElementById("notifBtn");
      const menu = document.getElementById("notifMenu");
      let isOpen = false;
      const openMenu = () => {
        isOpen = true;
        menu.classList.replace("notif-close", "notif-open");
      };
      const closeMenu = () => {
        isOpen = false;
        menu.classList.replace("notif-open", "notif-close");
      };
      btn.addEventListener("click", e => {
        e.stopPropagation();
        isOpen ? closeMenu() : openMenu();
      });
      menu.addEventListener("click", e => e.stopPropagation());
      document.addEventListener("click", () => {
        if (isOpen) closeMenu();
      });
      document.addEventListener("keydown", e => {
        if (e.key === "Escape" && isOpen) closeMenu();
      });
      closeMenu();
    });

    /* =========================
       INVENTORY DATA
    ========================= */
    let inventory = [];
    let activeTab = 'all';

    async function loadInventory() {
      const res = await fetch('/dentist/inventory/data', {
        cache: 'no-store'
      });
      const ct = res.headers.get("content-type") || "";
      if (!ct.includes("application/json")) {
        console.error("Inventory data is not JSON.");
        return;
      }
      inventory = await res.json();
      renderTable();
    }
    loadInventory();

    /* =========================
       STAT CARDS
    ========================= */
    function updateStats() {
      document.getElementById('statTotal').textContent = inventory.length;
      document.getElementById('statMedicine').textContent = inventory.filter(i => i.category === 'Medicine').length;
      document.getElementById('statSupplies').textContent = inventory.filter(i => i.category === 'Supplies').length;
      document.getElementById('statLow').textContent = inventory.filter(i => (Number(i.qty) - Number(i.used)) <= 5).length;
    }

    /* =========================
       CATEGORY TABS
    ========================= */
    function setTab(tab, btn) {
      activeTab = tab;
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      renderTable();
    }

    /* =========================
       FILTER STATE
    ========================= */
    const activeFilters = {
      sort: "",
      dateFrom: "",
      dateTo: "",
      dateOrder: "",
      stock: ""
    };

    function openFilterPanel() {
      setRadio("fp_sort", activeFilters.sort);
      setRadio("fp_dateOrder", activeFilters.dateOrder);
      setRadio("fp_stock", activeFilters.stock);
      document.getElementById("fp_dateFrom").value = activeFilters.dateFrom || "";
      document.getElementById("fp_dateTo").value = activeFilters.dateTo || "";
      document.getElementById('filterPanel').classList.add('open');
      document.getElementById('filterOverlay').classList.add('open');
    }

    function closeFilterPanel() {
      document.getElementById('filterPanel').classList.remove('open');
      document.getElementById('filterOverlay').classList.remove('open');
    }

    function setRadio(name, val) {
      document.querySelectorAll(`input[name="${name}"]`).forEach(r => r.checked = (val && r.value === val));
    }

    function getRadio(name) {
      const el = document.querySelector(`input[name="${name}"]:checked`);
      return el ? el.value : "";
    }

    function clearFilterPanel() {
      ['fp_sort', 'fp_dateOrder', 'fp_stock'].forEach(n => setRadio(n, ""));
      document.getElementById("fp_dateFrom").value = "";
      document.getElementById("fp_dateTo").value = "";
      Object.keys(activeFilters).forEach(k => activeFilters[k] = "");
      closeFilterPanel();
      renderTable();
    }

    function saveFilterPanel() {
      activeFilters.sort = getRadio("fp_sort");
      activeFilters.dateOrder = getRadio("fp_dateOrder");
      activeFilters.stock = getRadio("fp_stock");
      activeFilters.dateFrom = document.getElementById("fp_dateFrom").value || "";
      activeFilters.dateTo = document.getElementById("fp_dateTo").value || "";
      closeFilterPanel();
      renderTable();
    }

    /* =========================
       TABLE RENDER
    ========================= */
    function renderTable() {
      const tbody = document.getElementById("tableBody");
      tbody.innerHTML = "";
      let data = [...inventory];

      // Category tab filter
      if (activeTab === 'medicine') data = data.filter(i => i.category === 'Medicine');
      if (activeTab === 'supplies') data = data.filter(i => i.category === 'Supplies');

      // Search
      const q = (document.getElementById('searchInput').value || '').toLowerCase();
      if (q) data = data.filter(i =>
        String(i.stock_no || "").toLowerCase().includes(q) ||
        String(i.name || "").toLowerCase().includes(q)
      );

      // Date range
      const from = activeFilters.dateFrom ? new Date(activeFilters.dateFrom) : null;
      const to = activeFilters.dateTo ? new Date(activeFilters.dateTo) : null;
      if (from) {
        from.setHours(0, 0, 0, 0);
        data = data.filter(i => i.date_received && new Date(i.date_received) >= from);
      }
      if (to) {
        to.setHours(23, 59, 59, 999);
        data = data.filter(i => i.date_received && new Date(i.date_received) <= to);
      }

      // Sort
      const n = v => {
        const x = Number(v);
        return isFinite(x) ? x : 0;
      };
      const dt = v => {
        if (!v) return 0;
        const t = new Date(v).getTime();
        return isFinite(t) ? t : 0;
      };
      if (activeFilters.stock === "low-high") data.sort((a, b) => (n(a.qty) - n(a.used)) - (n(b.qty) - n(b.used)));
      else if (activeFilters.stock === "high-low") data.sort((a, b) => (n(b.qty) - n(b.used)) - (n(a.qty) - n(a.used)));
      else if (activeFilters.sort === "az") data.sort((a, b) => String(a.name || "").localeCompare(String(b.name || "")));
      else if (activeFilters.sort === "za") data.sort((a, b) => String(b.name || "").localeCompare(String(a.name || "")));
      else if (activeFilters.dateOrder === "asc") data.sort((a, b) => dt(a.date_received) - dt(b.date_received));
      else if (activeFilters.dateOrder === "desc") data.sort((a, b) => dt(b.date_received) - dt(a.date_received));

      // Stats always reflect full inventory
      updateStats();

      // Row count
      document.getElementById('rowCount').textContent = `${data.length} item${data.length !== 1 ? 's' : ''}`;
      document.getElementById('pageInfo').textContent = `Showing ${data.length} of ${inventory.length} items`;

      const emptyState = document.getElementById("emptyState");

      if (!data.length) {
        emptyState.style.display = 'block';

        const searchKeyword = q;
        const isSearching = searchKeyword.length > 0;
        const hasFilters = activeFilters.sort || activeFilters.dateFrom || activeFilters.dateTo ||
          activeFilters.dateOrder || activeFilters.stock;

        const emptyMessages = {
          all: {
            icon: 'fa-box-open',
            title: 'No items in the inventory',
            sub: 'Add your first item using the "Add Item" button above.'
          },
          medicine: {
            icon: 'fa-pills',
            title: 'No medicines in the inventory',
            sub: 'Add a medicine item using the "Add Item" button above.'
          },
          supplies: {
            icon: 'fa-syringe',
            title: 'No dental supplies in the inventory',
            sub: 'Add a supply item using the "Add Item" button above.'
          },
        };

        let icon, title, sub, extraHtml = "";

        if (isSearching) {
          icon = "fa-magnifying-glass";
          title = `No results for "${searchKeyword}"`;
          sub = "Try a different stock number or supply name.";
          extraHtml = `<button onclick="clearSearch()"
            class="mt-3 px-4 py-2 rounded-xl border border-dashed border-gray-300 text-sm text-gray-400
                   hover:border-[#8B0000] hover:text-[#8B0000] hover:bg-[#8B0000]/5 transition-all duration-200">
            <i class="fa-solid fa-xmark mr-1.5 text-xs"></i> Clear search</button>`;
        } else if (hasFilters) {
          icon = "fa-sliders";
          title = "No matches for your filters";
          sub = "Try removing or adjusting your filter criteria.";
          extraHtml = `<button onclick="clearFilterPanel()"
            class="mt-3 px-4 py-2 rounded-xl border border-dashed border-gray-300 text-sm text-gray-400
                   hover:border-[#8B0000] hover:text-[#8B0000] hover:bg-[#8B0000]/5 transition-all duration-200">
            <i class="fa-solid fa-xmark mr-1.5 text-xs"></i> Clear filters</button>`;
        } else {
          const msg = emptyMessages[activeTab] || emptyMessages.all;
          icon = msg.icon;
          title = msg.title;
          sub = msg.sub;
        }

        emptyState.innerHTML = `
          <div class="flex flex-col items-center justify-center py-20 text-center gap-2">
            <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-3">
              <i class="fa-solid ${icon} text-3xl text-gray-300"></i>
            </div>
            <p class="text-base font-semibold text-gray-500">${title}</p>
            <p class="text-sm text-gray-400 max-w-xs">${sub}</p>
            ${extraHtml}
          </div>`;
        return;
      }
      emptyState.style.display = 'none';

      data.forEach(item => {
        const balance = n(item.qty) - n(item.used);
        const balClass = balance <= 0 ? 'critical' : balance <= 5 ? 'low' : 'ok';
        const balLabel = balance <= 0 ? 'Out of stock' : balance <= 5 ? 'Low stock' : 'In stock';
        const catClass = item.category === 'Medicine' ? 'medicine' : 'supplies';

        tbody.innerHTML += `
        <tr>
          <td style="color:#9A9490;font-size:12px;white-space:nowrap;">${item.formatted_date ?? ''}</td>
          <td><span class="stock-no">${item.stock_no ?? ''}</span></td>
          <td>
            <div class="supply-name">${item.name ?? ''}</div>
            <span class="supply-cat ${catClass}">${item.category ?? ''}</span>
          </td>
          <td style="color:#9A9490;">${item.unit ?? ''}</td>
          <td style="font-weight:700;">${item.qty ?? 0}</td>
          <td style="color:#9A9490;">${item.used ?? 0}</td>
          <td><span class="bal-chip ${balClass}">${balance} <span style="font-weight:400;font-size:10px;">${balLabel}</span></span></td>
          <td>
            <div style="display:flex;justify-content:center;gap:6px;">
              <button class="act-btn edit" title="Edit" onclick="openEdit(${item.id})">
                <i class="fa fa-pen"></i>
              </button>
              <button class="act-btn delete" title="Delete" onclick="deleteItem(${item.id})">
                <i class="fa fa-trash"></i>
              </button>
            </div>
          </td>
        </tr>`;
      });
    }

    /* =========================
       SEARCH CLEAR
    ========================= */
    function toggleSearchClear(input) {
      const btn = document.getElementById('searchClearBtn');
      btn.classList.toggle('visible', input.value.length > 0);
    }

    function clearSearch() {
      const input = document.getElementById('searchInput');
      input.value = '';
      document.getElementById('searchClearBtn').classList.remove('visible');
      renderTable();
      input.focus();
    }

    /* =========================
       ADD
    ========================= */
    function resetAddForm() {
      document.getElementById('addCategory').selectedIndex = 0;
      ['addDate', 'addStock', 'addName', 'addUnit', 'addQty', 'addUsed', 'addBalance']
      .forEach(id => document.getElementById(id).value = '');
    }

    async function addItem() {
      const addCategory = document.getElementById('addCategory');
      const addDate = document.getElementById('addDate');
      const addStock = document.getElementById('addStock');
      const addName = document.getElementById('addName');
      const addUnit = document.getElementById('addUnit');
      const addQty = document.getElementById('addQty');
      const addUsed = document.getElementById('addUsed');

      if (addCategory.selectedIndex === 0 || !addDate.value || !addStock.value || !addName.value || !addUnit.value || addQty.value === '') {
        alert('Please complete all required fields.');
        return;
      }

      const res = await fetch('/dentist/inventory', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          category: addCategory.value,
          date_received: addDate.value,
          stock_no: addStock.value.trim(),
          name: addName.value.trim(),
          unit: addUnit.value.trim(),
          qty: Number(addQty.value),
          used: Number(addUsed.value || 0)
        })
      });

      if (!res.ok) {
        const err = await res.json().catch(() => ({}));
        alert(err.errors ? Object.values(err.errors).join('\n') : 'Add failed — check console');
        return;
      }

      document.getElementById('addModal').close();
      resetAddForm();
      loadInventory();
    }

    /* =========================
       DELETE
    ========================= */
    let deleteId = null;

    function deleteItem(id) {
      deleteId = id;
      document.getElementById('deleteModal').showModal();
    }

    document.getElementById("confirmDeleteBtn").onclick = async () => {
      if (!deleteId) return;
      await fetch(`/dentist/inventory/${deleteId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      });
      document.getElementById('deleteModal').close();
      deleteId = null;
      loadInventory();
    };

    /* =========================
       EDIT
    ========================= */
    let editId = null;

    function openEdit(id) {
      editId = id;
      const i = inventory.find(item => item.id === id);
      if (!i) return;
      document.getElementById('editCategory').value = i.category;
      document.getElementById('editStock').value = i.stock_no;
      document.getElementById('editName').value = i.name;
      document.getElementById('editUnit').value = i.unit;
      document.getElementById('editQty').value = i.qty;
      document.getElementById('editUsed').value = i.used;
      document.getElementById('editDate').value = i.date_received?.slice(0, 10);
      computeEditBalance();
      document.getElementById('editModal').showModal();
    }

    async function saveEdit() {
      if (!editId) return;
      const res = await fetch(`/dentist/inventory/${editId}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          category: document.getElementById('editCategory').value,
          date_received: document.getElementById('editDate').value,
          stock_no: document.getElementById('editStock').value,
          name: document.getElementById('editName').value,
          unit: document.getElementById('editUnit').value,
          qty: Number(document.getElementById('editQty').value),
          used: Number(document.getElementById('editUsed').value)
        })
      });
      if (!res.ok) {
        alert('Edit failed — check console');
        return;
      }
      document.getElementById('editModal').close();
      editId = null;
      loadInventory();
    }

    /* =========================
       BALANCE HELPERS
    ========================= */
    function computeAddBalance() {
      const q = Number(document.getElementById('addQty').value || 0);
      const u = Number(document.getElementById('addUsed').value || 0);
      document.getElementById('addBalance').value = q - u;
    }

    function computeEditBalance() {
      const q = Number(document.getElementById('editQty').value || 0);
      const u = Number(document.getElementById('editUsed').value || 0);
      document.getElementById('editBalance').value = q - u;
    }
  </script>

</body>

</html>