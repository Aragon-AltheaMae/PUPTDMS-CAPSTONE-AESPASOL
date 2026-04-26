@extends('layouts.dentist')

@section('title', 'Document Request | PUP Taguig Dental Clinic')

@section('styles')
<style>
  *,
  *::before,
  *::after {
    box-sizing: border-box;
  }

  :root {
    --crimson: #8B0000;
    --crimson-dark: #6b0000;
    --crimson-light: #fef2f2;
    --crimson-mid: #fce8e8;
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

  .docreq-view-toggle {
    display: inline-flex;
    align-items: center;
    background: #FFFFFF;
    border: 1px solid #E5E7EB;
    border-radius: 10px;
    padding: 3px;
    gap: 2px;
    flex-shrink: 0;
  }

  .docreq-view-btn {
    width: 36px;
    height: 34px;
    border: none;
    border-radius: 8px;
    background: transparent;
    color: #9CA3AF;
    cursor: pointer;
    transition: all .2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
  }

  .docreq-view-btn.active {
    background: #8B0000;
    color: #fff;
    box-shadow: 0 2px 8px rgba(139, 0, 0, .25);
  }

  .docreq-grid {
    display: none;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    padding: 16px;
  }

  .docreq-grid-card {
    background: #fff;
    border: 1px solid #E5E7EB;
    border-radius: 14px;
    padding: 14px 14px 14px 18px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .04);
    transition: all .2s;
    position: relative;
    overflow: hidden;
  }

  .docreq-grid-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 5px;
    background: var(--card-accent, #c2410c);
  }

  .docreq-grid-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, .08);
  }

  .docreq-grid-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 10px;
  }

  .docreq-grid-name {
    font-size: 16px;
    font-weight: 700;
    color: #1A1614;
    line-height: 1.3;
  }

  .docreq-grid-sub {
    font-size: 11px;
    color: #9CA3AF;
    margin-top: 3px;
  }

  .docreq-grid-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px 12px;
    margin-top: 12px;
  }

  .docreq-grid-label {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #9A9490;
    margin-bottom: 4px;
  }

  .docreq-grid-value {
    font-size: 13px;
    color: #333;
    font-weight: 600;
    line-height: 1.25;
  }

  .docreq-grid-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 14px;
    justify-content: flex-end;
  }

  .docreq-date-wrap {
    position: relative;
    width: 100%;
  }

  .docreq-date-wrap input {
    padding-right: 40px !important;
    cursor: pointer;
  }

  .docreq-date-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #9CA3AF;
    font-size: 14px;
    pointer-events: none;
    line-height: 1;
    z-index: 2;
  }

  @media (max-width: 1024px) {
    .docreq-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }

  .stat-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    border: 1px solid #E5E7EB;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    transition: all 0.2s ease;
    cursor: pointer;
    min-height: 80px;
  }

  .stat-card:hover {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    transform: translateY(-2px);
  }

  .stat-card-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }

  .stat-num {
    font-size: 1.75rem;
    font-weight: 800;
    color: #111827;
    line-height: 1;
    margin-bottom: 0.2rem;
  }

  .stat-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: #6B7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .stat-icon-wrapper {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    transition: all 0.2s ease;
    flex-shrink: 0;
  }

  .stat-card[data-filter="all"] .stat-icon-wrapper {
    background: #F3F4F6;
    color: #4B5563;
  }

  .stat-card[data-filter="all"].stat-active {
    border-color: #6B7280;
    box-shadow: 0 0 0 2px rgba(107, 114, 128, 0.15);
  }

  .stat-card[data-filter="pending"] .stat-icon-wrapper {
    background: #FEF3C7;
    color: #D97706;
  }

  .stat-card[data-filter="pending"].stat-active {
    border-color: #D97706;
    box-shadow: 0 0 0 2px rgba(217, 119, 6, 0.15);
  }

  .stat-card[data-filter="approved"] .stat-icon-wrapper {
    background: #DCFCE7;
    color: #15803D;
  }

  .stat-card[data-filter="approved"].stat-active {
    border-color: #15803D;
    box-shadow: 0 0 0 2px rgba(21, 128, 61, 0.15);
  }

  .stat-card[data-filter="rejected"] .stat-icon-wrapper {
    background: #FEE2E2;
    color: #B91C1C;
  }

  .stat-card[data-filter="rejected"].stat-active {
    border-color: #B91C1C;
    box-shadow: 0 0 0 2px rgba(185, 28, 28, 0.15);
  }

  [data-theme="dark"] .stat-card {
    background: #1F2937;
    border-color: #374151;
  }

  [data-theme="dark"] .stat-num {
    color: #F9FAFB;
  }

  [data-theme="dark"] .stat-label {
    color: #9CA3AF;
  }

  .active-filters-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
  }

  .filter-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    background: #F3F4F6;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 600;
    color: #4B5563;
  }

  .filter-chip-remove {
    cursor: pointer;
    color: #9CA3AF;
    transition: color 0.2s;
    display: flex;
    align-items: center;
  }

  .filter-chip-remove:hover {
    color: #111827;
  }

  .filter-chip-remove:hover {
    color: #EF4444;
  }

  .clear-all-chips {
    font-size: 12px;
    font-weight: 700;
    color: #D97706;
    background: #FFF7ED;
    border: 1px solid #FFEDD5;
    padding: 6px 14px;
    border-radius: 999px;
    cursor: pointer;
    transition: background 0.2s;
  }

  .clear-all-chips:hover {
    background: #FFEDD5;
  }

  .toolbar-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #EDE9E4;
    background: #FAFAF9;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .search-filter-row {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    flex-wrap: wrap;
  }

  @media (min-width: 1024px) {
    .search-filter-row {
      width: auto;
      flex-wrap: nowrap;
      justify-content: flex-end;
    }
  }

  .search-wrap {
    position: relative;
    display: flex;
    align-items: center;
    flex: 1;
    min-width: 250px;
  }

  .search-wrap i.search-icon {
    position: absolute;
    left: 14px;
    color: #9CA3AF;
    font-size: 14px;
    pointer-events: none;
    z-index: 10;
  }

  .search-wrap input {
    width: 100%;
    height: 42px;
    padding: 0 16px 0 38px;
    background: #ffffff;
    border: 1px solid #E5E7EB;
    border-radius: 9999px;
    font-size: 14px;
    color: #374151;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
  }

  .search-wrap input::placeholder {
    color: #9CA3AF;
  }

  .search-wrap input:focus {
    outline: none;
    border-color: #8B0000;
    box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.1);
  }

  .empty-state-wrapper {
    padding: 4.5rem 2rem 4.75rem;
    min-height: 320px;
    background: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
  }

  .empty-state-wrapper.compact {
    min-height: 260px;
    padding: 3.5rem 1.5rem 3.75rem;
  }

  .empty-icon-box {
    width: 78px;
    height: 78px;
    background: #F3F4F6;
    border-radius: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.1rem;
    box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.03);
  }

  .empty-icon-box i {
    font-size: 2rem;
    color: #a3a3a3;
  }

  .empty-title {
    font-size: 1.08rem;
    font-weight: 700;
    color: #4B5563;
    margin-bottom: 0.45rem;
  }

  .empty-sub {
    font-size: 0.88rem;
    font-weight: 400;
    color: #94A3B8;
    margin-bottom: 1.35rem;
    max-width: 420px;
    line-height: 1.55;
  }

  .empty-clear-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1.25rem;
    background: #ffffff;
    border: 1px dashed #9f9f9f;
    border-radius: 9999px;
    font-size: 0.85rem;
    font-weight: 400;
    color: #94A3B8;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .empty-clear-btn:hover {
    background: #8b00001a;
    color: #8B0000;
    border-color: #660000;
  }

  [data-theme="dark"] .empty-icon-box {
    background: #1E293B;
  }

  [data-theme="dark"] .empty-title {
    color: #F4F4F4;
  }

  [data-theme="dark"] .empty-sub {
    color: #757575;
  }

  [data-theme="dark"] .empty-clear-btn {
    background: transparent;
    border-color: #475569;
    color: #94A3B8;
  }

  [data-theme="dark"] .empty-clear-btn:hover {
    background: #1E293B;
    color: #E2E8F0;
    border-color: #757575;
  }

  .search-wrap input {
    width: 100%;
    height: 42px;
    padding: 0 38px 0 38px;
    background: #ffffff;
    border: 1px solid #E5E7EB;
    border-radius: 9999px;
    font-size: 14px;
    color: #374151;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
  }

  .search-clear-text-btn {
    font-size: 0.85rem;
    font-weight: 700;
    color: #DC2626;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0 8px;
    transition: color 0.2s;
    display: none;
  }

  .search-clear-text-btn:hover {
    color: #991B1B;
  }

  .search-clear-text-btn.visible {
    display: block;
  }

  .row-count {
    font-size: 13px;
    font-weight: 600;
    color: #6B7280;
  }

  .btn-filter-open {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    height: 42px;
    padding: 0 20px;
    background: #ffffff;
    border: 1px solid #E5E7EB;
    border-radius: 9999px;
    font-size: 14px;
    font-weight: 600;
    color: #4B5563;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    white-space: nowrap;
    flex-shrink: 0;
  }

  .btn-filter-open:hover {
    border-color: #8B0000;
    color: #8B0000;
    background: rgba(139, 0, 0, 0.03);
  }

  .btn-filter-open.has-filters {
    border-color: #8B0000;
    color: #8B0000;
    background: rgba(139, 0, 0, 0.05);
  }

  .filter-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    min-width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #8B0000;
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #ffffff;
  }

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

  .detail-panel {
    border-top: 1px solid #f3f3f3;
    background: #fafafa;
    overflow: hidden;
    max-height: 0;
    transition: max-height .35s cubic-bezier(.4, 0, .2, 1), padding .3s ease, opacity .3s ease;
    padding: 0 1.5rem;
    opacity: 0;
  }

  .detail-panel.open {
    max-height: 600px;
    padding: 1.2rem 1.5rem;
    opacity: 1;
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

  .btn-filter-open {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    height: 42px;
    padding: 0 20px;
    background: #ffffff;
    border: 1px solid #E5E7EB;
    border-radius: 9999px;
    /* Pill shape */
    font-size: 14px;
    font-weight: 600;
    color: #4B5563;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    white-space: nowrap;
    flex-shrink: 0;
  }

  .btn-filter-open:hover {
    border-color: #8B0000;
    color: #8B0000;
    background: rgba(139, 0, 0, 0.03);
  }

  .btn-filter-open.has-filters {
    border-color: #8B0000;
    color: #8B0000;
    background: rgba(139, 0, 0, 0.05);
  }

  .filter-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    min-width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #8B0000;
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #ffffff;
  }

  #fStatusGroup,
  #fSortGroup {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    background: transparent !important;
    padding: 0 !important;
    border-radius: 0;
  }

  .ftag {
    flex: 1 1 auto;
    min-height: 42px;
    padding: 0.62rem 0.95rem;
    border-radius: 999px;
    font-size: 0.78rem;
    font-weight: 700;
    color: #4B5563;
    background: #F3F4F6;
    border: 1px solid #E5E7EB;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1.2;
    box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
  }

  .ftag:hover {
    background: #E5E7EB;
    color: #111827;
    border-color: #D1D5DB;
  }

  .ftag.ftag-active {
    background: #8B0000;
    color: #ffffff;
    border-color: #8B0000;
    box-shadow: 0 6px 16px rgba(139, 0, 0, 0.22);
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

  .tfoot-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    border-top: 1px solid #EDE9E4;
    background: #FAFAF9;
  }

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

  .filter-drawer-wrapper {
    position: fixed;
    inset: 0;
    z-index: 1300;
    visibility: hidden;
  }

  .filter-drawer-wrapper.open {
    visibility: visible;
  }

  .filter-drawer-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.4);
    backdrop-filter: blur(2px);
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .filter-drawer-wrapper.open .filter-drawer-overlay {
    opacity: 1;
  }

  .filter-drawer-panel {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    max-width: 480px;
    background: #fff;
    border-radius: 24px 0 0 24px;
    box-shadow: -10px 0 40px rgba(0, 0, 0, 0.15);
    display: flex;
    flex-direction: column;
    transform: translateX(100%);
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    z-index: 1301;
  }

  .filter-drawer-wrapper.open .filter-drawer-panel {
    transform: translateX(0);
  }

  [data-theme="dark"] .filter-drawer-panel {
    background: #1e2535;
  }

  @media (max-width: 767px) {
    .docreq-view-toggle {
      display: none !important;
    }

    .docreq-grid {
      grid-template-columns: 1fr;
      gap: 10px;
      padding: 10px;
    }

    .empty-state-wrapper {
      min-height: 240px;
      padding: 3rem 1.25rem 3.25rem;
    }

    .empty-state-wrapper.compact {
      min-height: 220px;
      padding: 2.5rem 1rem 2.75rem;
    }

    .empty-icon-box {
      width: 68px;
      height: 68px;
      border-radius: 18px;
      margin-bottom: 1rem;
    }

    .empty-title {
      font-size: 1rem;
    }

    .empty-sub {
      font-size: 0.82rem;
      max-width: 280px;
    }

    .filter-drawer-panel {
      top: auto;
      bottom: 0;
      right: 0;
      left: 0;
      width: 100%;
      max-width: 100%;
      height: auto;
      max-height: min(78dvh, 720px);
      border-radius: 24px 24px 0 0;
      transform: translateY(100%);
      overflow: hidden;
    }

    .filter-drawer-wrapper.open .filter-drawer-panel {
      transform: translateY(0);
    }

    #filterModal .px-6.py-5.flex.items-center.justify-between.flex-shrink-0.bg-white {
      padding: 14px 16px;
    }

    #filterModal .px-6.py-2.flex.flex-col.gap-6.flex-1.overflow-y-auto.bg-white {
      padding: 10px 16px 8px;
      gap: 16px;
    }

    #filterModal .px-6.py-5.bg-white.flex.flex-col.sm\:flex-row.items-center.justify-between.flex-shrink-0.border-t.border-gray-100.gap-4.sm\:gap-0.relative.z-20 {
      padding: 12px 16px calc(14px + env(safe-area-inset-bottom));
      gap: 10px;
      align-items: stretch;
    }

    #filterModal #fStatusGroup {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      padding: 0;
      background: transparent;
    }

    #filterModal #fSortGroup {
      display: grid !important;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 10px;
      padding: 0;
      background: transparent;
    }

    #filterModal #fStatusGroup .ftag,
    #filterModal #fSortGroup .ftag {
      min-height: 42px;
      font-size: 11px;
      line-height: 1.2;
      padding: 8px 10px;
      border-radius: 999px;
    }

    #filterModal .docreq-date-wrap input {
      min-height: 40px;
      font-size: 13px;
    }

    #filterModal .flex.items-center.gap-3.w-full.sm\:w-auto {
      display: grid;
      grid-template-columns: 1fr 1fr;
      width: 100%;
      gap: 8px;
    }

    #filterCancelBtn,
    #filterApplyBtn {
      width: 100%;
      min-height: 42px;
    }

    #filterResetBtn {
      width: 100%;
      justify-content: center;
      border-top: 1px solid #F1F5F9;
      padding-top: 10px;
    }

    #externalClearFilterBtn {
      width: 38px;
      height: 38px;
      padding: 0;
    }
  }

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

  [data-theme="dark"] .mobile-req-card {
    background: #111827 !important;
    border-color: #2a3244 !important;
  }

  [data-theme="dark"] .mobile-req-card:hover {
    background: #1e2535 !important;
  }

  [data-theme="dark"] .mobile-detail-panel {
    background: #161e2e !important;
  }

  [data-theme="dark"] .mobile-meta-label {
    color: #6b7280 !important;
  }

  [data-theme="dark"] .mobile-meta-value {
    color: #e5e7eb !important;
  }

  [data-theme="dark"] .mobile-patient-name {
    color: #f3f4f6 !important;
  }

  [data-theme="dark"] .mobile-card-purpose {
    color: #9ca3af !important;
  }

  .mobile-req-card {
    background: #fff;
    border-bottom: 1px solid #F0ECE8;
    position: relative;
    overflow: hidden;
    transition: background .15s;
  }

  .mobile-req-card:hover {
    background: #FFF8F8;
  }

  .mobile-req-card:last-child {
    border-bottom: none;
  }

  .mobile-card-inner {
    padding: 1rem 1rem 1rem 1.25rem;
  }

  .mobile-card-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: .75rem;
    margin-bottom: .75rem;
  }

  .mobile-patient-info {
    display: flex;
    align-items: center;
    gap: .65rem;
    flex: 1;
    min-width: 0;
  }

  .mobile-avatar {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: .85rem;
  }

  .mobile-patient-name {
    font-weight: 700;
    font-size: .9rem;
    color: #1a1a1a;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .mobile-sub-label {
    font-size: .71rem;
    color: #aaa;
    margin-top: 1px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .mobile-card-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .55rem .75rem;
    margin-bottom: .85rem;
  }

  .mobile-meta-label {
    font-size: .62rem;
    font-weight: 700;
    color: #bbb;
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-bottom: .12rem;
  }

  .mobile-meta-value {
    font-size: .82rem;
    font-weight: 600;
    color: #333;
    line-height: 1.3;
  }

  .mobile-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .5rem;
    flex-wrap: wrap;
  }

  .mobile-detail-panel {
    overflow: hidden;
    max-height: 0;
    transition: max-height .35s cubic-bezier(.4, 0, .2, 1), padding .3s ease, opacity .3s ease;
    padding: 0 1rem;
    opacity: 0;
    background: #fafafa;
    border-top: 0px solid #f3f3f3;
  }

  .mobile-detail-panel.open {
    max-height: 700px;
    padding: 1rem;
    opacity: 1;
    border-top: 1px solid #f3f3f3;
  }

  .mobile-action-btns {
    display: flex;
    flex-wrap: wrap;
    gap: .5rem;
    margin-top: .85rem;
    padding-top: .85rem;
    border-top: 1px solid #f0f0f0;
  }

  .mobile-action-btns .btn-approve,
  .mobile-action-btns .btn-reject,
  .mobile-action-btns .btn-close-detail {
    flex: 1;
    min-width: 80px;
    justify-content: center;
  }

  .btn-view .btn-view-text {
    transition: opacity .2s ease;
  }

  .btn-view.loading {
    opacity: .7;
    pointer-events: none;
  }

  @media (max-width:1023px) and (min-width:768px) {

    #mainContent,
    #siteFooter {
      margin-left: 220px;
    }

    #statCards {
      grid-template-columns: repeat(2, 1fr) !important;
    }

    .stat-num {
      font-size: 2rem;
    }

    .req-inner {
      grid-template-columns: 1fr auto !important;
      row-gap: .5rem;
    }

    .req-date-col,
    .req-doc-col {
      display: none;
    }

    .req-purpose-col {
      display: none;
    }

    .search-wrap {
      width: 220px;
    }
  }

  @media (max-width:767px) {

    #statCards {
      grid-template-columns: repeat(2, 1fr) !important;
      gap: .65rem !important;
      margin-bottom: 1.25rem !important;
    }

    .stat-card {
      padding: 1rem 1.1rem;
      border-radius: 13px;
    }

    .stat-num {
      font-size: 1.8rem;
    }

    .stat-label {
      font-size: .68rem;
    }

    .stat-icon {
      font-size: 1.4rem;
    }

    .toolbar-wrap {
      flex-direction: column;
      align-items: stretch !important;
      gap: 12px !important;
      padding: 16px !important;
    }

    .search-wrap {
      width: 100% !important;
    }

    .toolbar-right-group {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .desktop-req-row {
      display: none !important;
    }

    .mobile-req-card {
      display: block !important;
    }

    .tfoot-bar {
      flex-direction: column;
      gap: .6rem;
      padding: 10px 14px !important;
      align-items: flex-start;
    }

    #pagControls {
      flex-wrap: wrap;
      gap: .3rem;
    }

    .pag-btn {
      padding: .3rem .6rem;
      font-size: .75rem;
    }

    .modal-overlay {
      padding: .5rem;
      align-items: flex-end;
    }

    .modal-box-inner {
      border-radius: 20px 20px 14px 14px;
      max-width: 100% !important;
    }

    .approve-hero,
    .reject-hero {
      padding: 1.6rem 1.25rem 1.4rem;
    }

    .approve-footer,
    .reject-footer {
      padding: 1rem 1.25rem 1.2rem;
      flex-wrap: wrap;
      gap: .5rem;
    }

    .modal-btn-confirm-approve,
    .modal-btn-confirm-reject {
      flex: 1;
      justify-content: center;
    }

    .modal-btn-ghost {
      flex: 1;
      justify-content: center;
    }

    #filterModal .modal-box-inner {
      border-radius: 20px 20px 14px 14px;
    }

    .modal-ft {
      flex-wrap: wrap;
      gap: .5rem;
    }

    .modal-ft>div {
      flex: 1;
    }

    #filterApplyBtn {
      flex: 1;
      justify-content: center;
    }

    #mainContent h1 {
      font-size: 1.4rem !important;
    }

    #mainContent>div>div:first-child {
      margin-bottom: 1.2rem !important;
    }

  }

  @media (max-width:380px) {
    #statCards {
      grid-template-columns: repeat(2, 1fr) !important;
      gap: .5rem !important;
    }

    .stat-card {
      padding: .85rem .9rem;
    }

    .stat-num {
      font-size: 1.5rem;
    }

    .stat-label {
      font-size: .62rem;
    }

    .mobile-card-meta {
      grid-template-columns: 1fr;
    }
  }


  .mobile-req-card {
    display: none;
  }
</style>
@endsection

@section('content')

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<main id="mainContent" class="pt-[100px] px-3 md:px-6 py-6 fade-in min-h-screen flex-1">
  <div class="w-full fade-in">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-4 mb-6">

      <div class="order-1 flex items-center gap-3">
        <div>
          <h2 class="text-xl md:text-2xl font-extrabold text-[#8B0000] tracking-tight leading-none mb-0.5">
            Document Requests
          </h2>
        </div>
      </div>

      <div id="statCards" class="order-2 md:order-3 md:col-span-2 grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 mt-2">
        <button class="stat-card stat-active" data-filter="all" onclick="setFilter('all')">
          <div class="stat-card-info">
            <div class="stat-num" id="statAll">0</div>
            <div class="stat-label">Total Requests</div>
          </div>
          <div class="stat-icon-wrapper"><i class="fa-solid fa-file-medical"></i></div>
        </button>
        <button class="stat-card" data-filter="pending" onclick="setFilter('pending')">
          <div class="stat-card-info">
            <div class="stat-num" id="statPending">0</div>
            <div class="stat-label">Pending</div>
          </div>
          <div class="stat-icon-wrapper"><i class="fa-solid fa-clock-rotate-left"></i></div>
        </button>
        <button class="stat-card" data-filter="approved" onclick="setFilter('approved')">
          <div class="stat-card-info">
            <div class="stat-num" id="statApproved">0</div>
            <div class="stat-label">Approved</div>
          </div>
          <div class="stat-icon-wrapper"><i class="fa-solid fa-file-circle-check"></i></div>
        </button>
        <button class="stat-card" data-filter="rejected" onclick="setFilter('rejected')">
          <div class="stat-card-info">
            <div class="stat-num" id="statRejected">0</div>
            <div class="stat-label">Rejected</div>
          </div>
          <div class="stat-icon-wrapper"><i class="fa-solid fa-file-circle-xmark"></i></div>
        </button>
      </div>

    </div>

    <div class="table-card rounded-2xl border border-gray-200 shadow-sm overflow-hidden bg-white">

      <div class="px-4 md:px-6 py-3.5 border-b border-gray-100 bg-[#FAFAFA]/50">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">

          <div class="order-2 md:order-1">
            <span id="rowCount" class="text-[11px] md:text-sm font-bold text-gray-400 uppercase tracking-wider">
              0 requests
            </span>
          </div>

          <div class="flex items-center gap-2 order-1 md:order-2 w-full md:w-auto justify-end">
            <div class="relative flex-1 md:flex-none flex items-center gap-2">
              <div class="relative flex-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none z-10">
                  <i class="fa-solid fa-magnifying-glass text-[#333333] text-xs"></i>
                </span>
                <input id="searchInput" type="text" placeholder="Search patient name…"
                  class="pl-9 pr-4 py-2 w-full md:w-64 rounded-xl border border-gray-200 bg-white text-sm text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#8B0000]/10 focus:border-[#8B0000] transition-all"
                  oninput="onSearch(this)" />
              </div>

              <button type="button" id="searchClearBtn" onclick="clearSearch()"
                class="text-xs font-semibold text-red-600 hover:text-red-800 transition-colors hidden flex-shrink-0 px-1">
                Clear
              </button>
            </div>

            <div class="docreq-view-toggle" id="docreqViewToggle">
              <button type="button" class="docreq-view-btn active" data-view="list" onclick="setViewMode('list', this)">
                <i class="fa-solid fa-list"></i>
              </button>
              <button type="button" class="docreq-view-btn" data-view="grid" onclick="setViewMode('grid', this)">
                <i class="fa-solid fa-table-cells-large"></i>
              </button>
            </div>

            <button id="filterBtn" type="button" onclick="openFilterModal()"
              class="relative flex items-center justify-center gap-2 px-3 md:px-4 py-2 rounded-xl border border-gray-200 bg-white text-gray-600 shadow-sm hover:border-[#8B0000] hover:text-[#8B0000] transition-all flex-shrink-0">
              <i class="fa-solid fa-sliders text-sm"></i>
              <span class="text-xs md:text-sm font-bold">Filter</span>
              <span id="filterBadge" class="filter-badge" style="display:none;"></span>
            </button>

            <button id="externalClearFilterBtn" type="button" onclick="resetAllFilters()"
              class="hidden flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 bg-white text-red-600 hover:bg-red-50 hover:border-red-300 transition-all flex-shrink-0"
              title="Reset filters">
              <i class="fa-solid fa-rotate-left text-sm"></i>
            </button>
          </div>
        </div>
      </div>

      <div id="docreqTableHead"
        class="hidden md:grid gap-3 text-[10px] font-bold uppercase tracking-wider text-gray-500 py-3.5 px-6 bg-[#FAFAFA] border-b border-gray-200"
        style="grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr) minmax(0, 1.5fr) minmax(0, 1.5fr) minmax(0, 1fr) 100px;">
        <div class="text-left">Patient</div>
        <div class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-[10px]"></i>Date
          Requested</div>
        <div class="text-left">Document</div>
        <div class="text-left">Purpose</div>
        <div class="text-left">Status</div>
        <div class="text-right">Actions</div>
      </div>

      <div id="requestListContainer" class="pb-2"></div>
      <div id="requestGridContainer" class="docreq-grid"></div>

      <div class="tfoot-bar">
        <span style="font-size:12px;color:#9A9490;" id="pageInfo"></span>
        <div style="display:flex;align-items:center;gap:.4rem;flex-wrap:wrap;" id="pagControls"></div>
      </div>

    </div>
</main>

<div id="filterModal" class="filter-drawer-wrapper">
  <div class="filter-drawer-overlay" onclick="document.getElementById('filterCloseBtn').click()"></div>

  <div class="filter-drawer-panel flex flex-col bg-white">

    <div class="px-6 py-5 flex items-center justify-between flex-shrink-0 bg-white">
      <div class="flex items-center gap-2 text-[#8B0000]">
        <i class="fa-solid fa-sliders text-xl"></i>
        <h2 class="text-xl font-extrabold">Filters</h2>
      </div>
      <button class="text-gray-400 hover:text-gray-700 transition-colors" id="filterCloseBtn">
        <i class="fa-solid fa-xmark text-xl"></i>
      </button>
    </div>

    <div class="px-6 py-2 flex flex-col gap-6 flex-1 overflow-y-auto bg-white">

      <div id="activeFiltersSection" class="hidden">
        <div class="flex items-center justify-between mb-2">
          <span class="text-[13px] font-bold text-gray-800">Active Filters</span>
          <button id="clearAllChipsBtn" type="button" class="text-xs font-bold text-[#8B0000] hover:underline">Clear
            All</button>
        </div>
        <div id="activeChipsContainer" class="flex flex-wrap gap-2 pb-4 border-b border-gray-100"></div>
      </div>

      <div>
        <label class="block text-[13px] font-bold text-gray-800 mb-2">Status</label>
        <div class="flex bg-gray-100 p-1 rounded-lg w-full gap-2" id="fStatusGroup">
          <button class="ftag ftag-active flex-1" data-val="all">All</button>
          <button class="ftag flex-1" data-val="pending">Pending</button>
          <button class="ftag flex-1" data-val="approved">Approved</button>
          <button class="ftag flex-1" data-val="rejected">Rejected</button>
        </div>
      </div>

      <div>
        <label class="block text-[13px] font-bold text-gray-800 mb-2">Document Details</label>
        <div class="relative">
          <i class="fa-regular fa-file-lines absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
          <select id="fDocType"
            class="w-full pl-10 pr-8 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:border-[#8B0000] focus:ring-1 focus:ring-[#8B0000] appearance-none"
            style="background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%239CA3AF%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat:no-repeat; background-position:right 12px center; background-size:16px;">
            <option value="">Document Type</option>
            <option value="Dental Clearance">Dental Clearance</option>
            <option value="Dental Health Record">Dental Health Record</option>
            <option value="Annual Dental Clearance">Annual Dental Clearance</option>
            <option value="Medical Certificate">Medical Certificate</option>
            <option value="Other">Other</option>
          </select>
        </div>
      </div>

      <div>
        <label class="block text-[13px] font-bold text-gray-800 mb-2">Date Range</label>
        <div class="flex gap-3 flex-col sm:flex-row">
          <div class="relative flex-1">
            <div class="docreq-date-wrap">
              <input id="fDateFrom" type="text"
                class="w-full pl-3 pr-10 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 focus:outline-none focus:border-[#8B0000] focus:ring-1 focus:ring-[#8B0000] js-flatpickr-date-range-from"
                placeholder="Select date" readonly>
              <i class="fa-regular fa-calendar docreq-date-icon"></i>
            </div>
          </div>

          <div class="relative flex-1">
            <div class="docreq-date-wrap">
              <input id="fDateTo" type="text"
                class="w-full pl-3 pr-10 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 focus:outline-none focus:border-[#8B0000] focus:ring-1 focus:ring-[#8B0000] js-flatpickr-date-range-to"
                placeholder="Select date" readonly>
              <i class="fa-regular fa-calendar docreq-date-icon"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="pb-6">
        <label class="block text-[13px] font-bold text-gray-800 mb-2">Sort By</label>
        <div class="flex bg-gray-100 p-1 rounded-lg w-full" id="fSortGroup">
          <button class="ftag ftag-active flex-1 text-[11px] leading-tight" data-val="newest">Newest
            First</button>
          <button class="ftag flex-1 text-[11px] leading-tight" data-val="oldest">Oldest First</button>
          <button class="ftag flex-1 text-[11px] leading-tight" data-val="name_asc">Patient<br>Name
            A-Z</button>
          <button class="ftag flex-1 text-[11px] leading-tight" data-val="name_desc">Patient<br>Name
            Z-A</button>
        </div>
      </div>
    </div>

    <div
      class="px-6 py-5 bg-white flex flex-col sm:flex-row items-center justify-between flex-shrink-0 border-t border-gray-100 gap-4 sm:gap-0 relative z-20">

      <button id="filterResetBtn"
        class="flex items-center gap-2 text-[#8B0000] hover:text-[#6b0000] transition-colors w-full sm:w-auto justify-center sm:justify-start">
        <i class="fa-regular fa-trash-can text-base"></i>
        <span class="text-[13px] font-bold whitespace-nowrap">Clear Filters</span>
      </button>

      <div class="flex items-center gap-3 w-full sm:w-auto">
        <button id="filterCancelBtn"
          class="flex-1 sm:flex-none px-5 py-2.5 text-sm font-bold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
          Cancel
        </button>
        <button id="filterApplyBtn"
          class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-[#8B0000] rounded-lg hover:bg-[#6b0000] transition-colors shadow-sm">
          <i class="fa-solid fa-check"></i> Apply
        </button>
      </div>

    </div>
  </div>
</div>

<div id="approveModal" class="modal-overlay">
  <div class="modal-box-inner" style="max-width:440px;border-radius:24px;overflow:hidden;">
    <button class="modal-float-x" id="approveCancelBtn"><i class="fa-solid fa-xmark"></i></button>
    <div class="approve-hero">
      <div class="approve-icon-ring">
        <div class="approve-icon-inner"><i class="fa-solid fa-file-circle-check"></i></div>
      </div>
      <div class="approve-hero-title">Approve Request</div>
      <div class="approve-hero-sub">The patient will be notified once approved</div>
    </div>
    <div style="padding:1.5rem 1.75rem 0;">
      <div class="approve-patient-card">
        <div class="approve-patient-avatar"><i class="fa-solid fa-user"></i></div>
        <div>
          <div
            style="font-size:.68rem;font-weight:700;color:#15803d;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.2rem;">
            Patient</div>
          <div id="approvePatientName" style="font-size:1.05rem;font-weight:800;color:#14532d;line-height:1.2;">—
          </div>
        </div>
      </div>
      <div class="approve-info-row">
        <i class="fa-solid fa-circle-info" style="color:#86efac;font-size:.8rem;flex-shrink:0;margin-top:1px;"></i>
        <span>The document will be queued for printing and signing. This action <strong>cannot be
            undone.</strong></span>
      </div>
    </div>
    <div class="approve-footer">
      <button class="modal-btn-ghost" id="approveCancelBtn2"><i class="fa-solid fa-arrow-left"
          style="font-size:.72rem;"></i> Cancel</button>
      <button class="modal-btn-confirm-approve" id="approveConfirmBtn">
        <span class="btn-confirm-icon"><i class="fa-solid fa-check"></i></span>
        Confirm Approval
      </button>
    </div>
  </div>
</div>
<input type="hidden" id="approveRequestId">

<div id="rejectModal" class="modal-overlay">
  <div class="modal-box-inner" style="max-width:440px;border-radius:24px;overflow:hidden;">
    <button class="modal-float-x modal-float-x--red" id="rejectCancelBtn"><i class="fa-solid fa-xmark"></i></button>
    <div class="reject-hero">
      <div class="reject-icon-ring">
        <div class="reject-icon-inner"><i class="fa-solid fa-file-circle-xmark"></i></div>
      </div>
      <div class="reject-hero-title">Reject Request</div>
      <div class="reject-hero-sub">This action is permanent and cannot be undone</div>
    </div>
    <div style="padding:1.5rem 1.75rem 0;">
      <div class="reject-patient-card">
        <div class="reject-patient-avatar"><i class="fa-solid fa-user"></i></div>
        <div>
          <div
            style="font-size:.68rem;font-weight:700;color:#b91c1c;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.2rem;">
            Patient</div>
          <div id="rejectPatientName" style="font-size:1.05rem;font-weight:800;color:#7f1d1d;line-height:1.2;">—</div>
        </div>
      </div>
      <div style="margin-top:1.1rem;">
        <label class="reject-field-label">Reason for rejection <span
            style="font-weight:400;color:#d1a3a3;margin-left:.3rem;">(optional)</span></label>
        <textarea id="rejectNotes" class="reject-textarea" rows="3"
          placeholder="Provide a reason so the patient understands the decision…"></textarea>
      </div>
      <div class="reject-warning-row">
        <i class="fa-solid fa-triangle-exclamation"
          style="color:#fca5a5;font-size:.8rem;flex-shrink:0;margin-top:1px;"></i>
        <span>The patient will be notified of this rejection. Make sure you've reviewed the request
          carefully.</span>
      </div>
    </div>
    <div class="reject-footer">
      <button class="modal-btn-ghost modal-btn-ghost--red" id="rejectCancelBtn2"><i class="fa-solid fa-arrow-left"
          style="font-size:.72rem;"></i> Cancel</button>
      <button class="modal-btn-confirm-reject" id="rejectConfirmBtn">
        <span class="btn-confirm-icon"><i class="fa-solid fa-ban"></i></span>
        Confirm Rejection
      </button>
    </div>
  </div>
</div>
<input type="hidden" id="rejectRequestId">

<div id="approvedResultModal" class="modal-overlay">
  <div class="modal-box-inner">
    <div style="background:linear-gradient(135deg,#15803d,#16a34a);padding:2.5rem 2rem;text-align:center;color:#fff;">
      <div
        style="width:58px;height:58px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .9rem;">
        <i class="fa-solid fa-circle-check" style="font-size:1.7rem;"></i>
      </div>
      <div style="font-size:1.55rem;margin-bottom:.5rem;">Request Approved!</div>
      <p style="font-size:.82rem;opacity:.85;line-height:1.6;">The document has been approved and will
        be<br>prepared
        for printing. The patient will be notified.</p>
      <button id="approvedResultClose"
        style="margin-top:1.4rem;background:rgba(255,255,255,.2);color:#fff;border:2px solid rgba(255,255,255,.35);border-radius:9px;padding:.5rem 1.5rem;font-weight:700;cursor:pointer;font-size:.83rem;">
        Done
      </button>
    </div>
  </div>
</div>

<div id="rejectedResultModal" class="modal-overlay">
  <div class="modal-box-inner">
    <div style="background:linear-gradient(135deg,#991b1b,#b91c1c);padding:2.5rem 2rem;text-align:center;color:#fff;">
      <div
        style="width:58px;height:58px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .9rem;">
        <i class="fa-solid fa-circle-xmark" style="font-size:1.7rem;"></i>
      </div>
      <div style="font-size:1.55rem;margin-bottom:.5rem;">Request Rejected</div>
      <p style="font-size:.82rem;opacity:.85;line-height:1.6;">The request has been rejected. The patient<br>will
        be
        notified of the decision.</p>
      <button id="rejectedResultClose"
        style="margin-top:1.4rem;background:rgba(255,255,255,.2);color:#fff;border:2px solid rgba(255,255,255,.35);border-radius:9px;padding:.5rem 1.5rem;font-weight:700;cursor:pointer;font-size:.83rem;">
        Done
      </button>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  const CSRF = document.querySelector('meta[name="csrf-token"]').content;

  let allRequests = [];
  let activeFilter = 'all';
  let searchQuery = '';
  const PER_PAGE = 8;
  let currentPage = 1;
  let filterStatus = 'all';
  let filterDocType = '';
  let filterDateFrom = '';
  let filterDateTo = '';
  let filterSort = 'newest';

  let currentViewMode = window.innerWidth <= 767 ? 'grid' : 'list';

  function setViewMode(mode, btn) {
    currentViewMode = mode;

    document.querySelectorAll('.docreq-view-btn').forEach(function (b) {
      b.classList.remove('active');
    });

    if (btn) btn.classList.add('active');

    renderList();
  }

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
      const listContainer = document.getElementById('requestListContainer');
      const gridContainer = document.getElementById('requestGridContainer');
      const tableHead = document.getElementById('docreqTableHead');

      if (tableHead) tableHead.style.display = 'none';
      if (gridContainer) {
        gridContainer.style.display = 'none';
        gridContainer.innerHTML = '';
      }
      if (listContainer) {
        listContainer.style.display = 'block';
        listContainer.innerHTML = `
    <div class="empty-state-wrapper compact">
      <div class="empty-icon-box"><i class="fa-solid fa-circle-exclamation"></i></div>
      <div class="empty-title">Failed to load requests</div>
      <div class="empty-sub">Could not fetch document requests. Please refresh the page and try again.</div>
    </div>`;
      }
    }
  }

  function showSkeleton() {
    let html = '';
    for (let i = 0; i < 4; i++) {
      html += `
      <div class="req-row desktop-req-row border-b border-gray-100 hidden md:block">
        <div class="req-inner" style="display:grid;grid-template-columns:1.5fr 1fr 1.5fr 1.5fr 1fr 100px;align-items:center;gap:12px;">
          <div style="display:flex;align-items:center;gap:.8rem;">
            <div class="skeleton" style="width:32px;height:32px;border-radius:50%;flex-shrink:0;"></div>
            <div><div class="skeleton" style="height:13px;width:110px;margin-bottom:6px;"></div><div class="skeleton" style="height:10px;width:70px;"></div></div>
          </div>
          <div><div class="skeleton" style="height:13px;width:80px;margin-bottom:5px;"></div><div class="skeleton" style="height:10px;width:60px;"></div></div>
          <div><div class="skeleton" style="height:13px;width:120px;"></div></div>
          <div><div class="skeleton" style="height:13px;width:140px;"></div></div>
          <div><div class="skeleton" style="height:20px;width:60px;border-radius:999px;"></div></div>
          <div class="skeleton" style="height:28px;width:70px;border-radius:8px;"></div>
        </div>
      </div>
      
      <div class="mobile-req-card md:hidden bg-white border border-gray-200 rounded-xl p-4 mb-3 mx-2">
        <div class="mobile-card-inner">
          <div style="display:flex;align-items:center;gap:.65rem;margin-bottom:.75rem;">
            <div class="skeleton" style="width:38px;height:38px;border-radius:10px;flex-shrink:0;"></div>
            <div style="flex:1;">
              <div class="skeleton" style="height:13px;width:130px;margin-bottom:5px;"></div>
              <div class="skeleton" style="height:10px;width:80px;"></div>
            </div>
            <div class="skeleton" style="height:28px;width:60px;border-radius:9px;"></div>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:.55rem;">
            <div><div class="skeleton" style="height:9px;width:60px;margin-bottom:4px;"></div><div class="skeleton" style="height:12px;width:80px;"></div></div>
            <div><div class="skeleton" style="height:9px;width:50px;margin-bottom:4px;"></div><div class="skeleton" style="height:12px;width:90px;"></div></div>
          </div>
        </div>
      </div>`;
    }
    const listContainer = document.getElementById('requestListContainer');
    const gridContainer = document.getElementById('requestGridContainer');
    const tableHead = document.getElementById('docreqTableHead');

    if (tableHead && currentViewMode === 'list') {
      tableHead.style.display = '';
    } else if (tableHead) {
      tableHead.style.display = 'none';
    }

    if (gridContainer) {
      gridContainer.style.display = 'none';
      gridContainer.innerHTML = '';
    }

    if (listContainer) {
      listContainer.style.display = 'block';
      listContainer.innerHTML = html;
    }

    const rowCountEl = document.getElementById('rowCount');
    if (rowCountEl) rowCountEl.textContent = 'Loading...';

    document.getElementById('pageInfo').textContent = '';
    document.getElementById('pagControls').innerHTML = '';
  }

  function updateStats(stats) {
    stats = stats || {};
    document.getElementById('statAll').textContent = stats.all ?? 0;
    document.getElementById('statPending').textContent = stats.pending ?? 0;
    document.getElementById('statApproved').textContent = stats.approved ?? 0;
    document.getElementById('statRejected').textContent = stats.rejected ?? 0;
  }

  function getFiltered() {
    let data = allRequests;
    if (activeFilter !== 'all') data = data.filter(r => r.status === activeFilter);
    if (searchQuery) {
      const q = searchQuery.toLowerCase();
      data = data.filter(r => r.patient_name.toLowerCase().includes(q));
    }
    if (filterDocType) data = data.filter(r => r.document_type === filterDocType);
    if (filterDateFrom) {
      const from = new Date(filterDateFrom);
      data = data.filter(r => new Date(r.request_date) >= from);
    }
    if (filterDateTo) {
      const to = new Date(filterDateTo);
      to.setHours(23, 59, 59, 999);
      data = data.filter(r => new Date(r.request_date) <= to);
    }
    data = [...data].sort((a, b) => {
      if (filterSort === 'oldest') return new Date(a.request_date) - new Date(b.request_date);
      if (filterSort === 'name_asc') return a.patient_name.localeCompare(b.patient_name);
      if (filterSort === 'name_desc') return b.patient_name.localeCompare(a.patient_name);
      return new Date(b.request_date) - new Date(a.request_date);
    });
    return data;
  }

  function hasActiveFilters() {
    return searchQuery !== '' || activeFilter !== 'all' || filterDocType !== '' || filterDateFrom !== '' ||
      filterDateTo !== '' || filterSort !== 'newest';
  }

  function countAdvancedFilters() {
    let n = 0;
    if (filterStatus !== 'all') n++;
    if (filterDocType) n++;
    if (filterDateFrom || filterDateTo) n++;
    if (filterSort !== 'newest') n++;
    return n;
  }

  function updateFilterBtn() {
    const badge = document.getElementById('filterBadge');
    const externalClear = document.getElementById('externalClearFilterBtn');
    const count = countAdvancedFilters();

    if (count > 0) {
      if (badge) {
        badge.textContent = count;
        badge.style.display = 'inline-flex';
      }
      if (externalClear) externalClear.classList.remove('hidden');
    } else {
      if (badge) badge.style.display = 'none';
      if (externalClear) externalClear.classList.add('hidden');
    }
  }

  function buildClearFilterBtn() {
    const parts = [];
    if (searchQuery) parts.push(`"${esc(searchQuery)}"`);
    if (activeFilter !== 'all') parts.push(activeFilter.charAt(0).toUpperCase() + activeFilter.slice(1));
    if (filterDocType) parts.push(filterDocType);
    if (filterDateFrom || filterDateTo) parts.push('Date range');
    if (filterSort !== 'newest') parts.push('Sort');
    const label = parts.length ? `Clear filter${parts.length > 1 ? 's' : ''} (${parts.join(', ')})` :
      'Reset';
    return `<div style="margin-top:1.25rem;"><button class="btn-clear-filter" onclick="resetAllFilters()"><i class="fa-solid fa-filter-circle-xmark"></i>${label}</button></div>`;
  }

  function resetAllFilters() {
    const searchInput = document.getElementById('searchInput');
    const searchClearBtn = document.getElementById('searchClearBtn');

    if (searchInput) searchInput.value = '';
    if (searchClearBtn) searchClearBtn.classList.add('hidden');

    searchQuery = '';

    activeFilter = 'all';
    filterStatus = 'all';
    filterDocType = '';
    filterDateFrom = '';
    filterDateTo = '';
    filterSort = 'newest';

    document.querySelectorAll('#statCards .stat-card').forEach(c =>
      c.getAttribute('data-filter') === 'all' ?
        c.classList.add('stat-active') :
        c.classList.remove('stat-active')
    );

    syncFilterTagGroup('fStatusGroup', 'all');
    syncFilterTagGroup('fSortGroup', 'newest');

    const fDoc = document.getElementById('fDocType');
    if (fDoc) fDoc.value = '';

    const fFrom = document.getElementById('fDateFrom');
    if (fFrom) fFrom.value = '';

    const fTo = document.getElementById('fDateTo');
    if (fTo) fTo.value = '';

    updateFilterBtn();
    renderFilterChips();
    currentPage = 1;
    renderList();
  }

  function renderList() {
    const filtered = getFiltered();
    const total = filtered.length;
    const tableHead = document.getElementById('docreqTableHead');
    const lastPage = Math.max(1, Math.ceil(total / PER_PAGE));
    if (currentPage > lastPage) currentPage = lastPage;
    const start = (currentPage - 1) * PER_PAGE;
    const page = filtered.slice(start, start + PER_PAGE);

    const rowCountEl = document.getElementById('rowCount');
    if (rowCountEl) rowCountEl.textContent = `${total} ${total === 1 ? 'request' : 'requests'}`;

    document.getElementById('pageInfo').textContent =
      total === 0 ? '' : `Showing ${start + 1}–${Math.min(start + PER_PAGE, total)} of ${total} requests`;

    renderPagination(total, lastPage);

    const listContainer = document.getElementById('requestListContainer');
    const gridContainer = document.getElementById('requestGridContainer');

    if (listContainer) listContainer.innerHTML = '';
    if (gridContainer) gridContainer.innerHTML = '';

    if (!page.length) {
      const emptyHtml = buildEmptyStateHtml();

      if (tableHead) tableHead.style.display = 'none';

      if (currentViewMode === 'grid') {
        if (listContainer) {
          listContainer.style.display = 'none';
          listContainer.innerHTML = '';
        }
        if (gridContainer) {
          gridContainer.style.display = 'block';
          gridContainer.innerHTML = emptyHtml;
        }
      } else {
        if (gridContainer) {
          gridContainer.style.display = 'none';
          gridContainer.innerHTML = '';
        }
        if (listContainer) {
          listContainer.style.display = 'block';
          listContainer.innerHTML = emptyHtml;
        }
      }

      return;
    }

    if (currentViewMode === 'grid') {
      if (tableHead) tableHead.style.display = 'none';

      if (listContainer) {
        listContainer.style.display = 'none';
        listContainer.innerHTML = '';
      }

      if (gridContainer) {
        gridContainer.style.display = 'grid';
        gridContainer.innerHTML = page.map(r => buildGridCard(r)).join('');
      }
    } else {
      if (tableHead) tableHead.style.display = '';

      if (gridContainer) {
        gridContainer.style.display = 'none';
        gridContainer.innerHTML = '';
      }

      if (listContainer) {
        listContainer.style.display = 'block';
        listContainer.innerHTML = page.map(r => buildDesktopRow(r)).join('');
      }
    }
  }

  function buildDesktopRow(r) {
    const accentHex = r.status === 'approved' ? '#15803d' : r.status === 'rejected' ? '#b91c1c' : '#c2410c';
    const avatarBg = r.status === 'approved' ? '#dcfce7' : r.status === 'rejected' ? '#fee2e2' : '#fff7ed';
    const avatarCol = r.status === 'approved' ? '#15803d' : r.status === 'rejected' ? '#b91c1c' : '#c2410c';
    const badgeCls = r.status === 'approved' ? 'badge-approved' : r.status === 'rejected' ? 'badge-rejected' :
      'badge-pending';
    const sub = r.sub_label ?
      `<div style="font-size:.72rem;color:#aaa;margin-top:.08rem;">${esc(r.sub_label)}</div>` :
      `<div style="font-size:.72rem;color:#ddd;">—</div>`;

    const nameCol =
      `<div style="display:flex;align-items:center;gap:.8rem;"><div style="width:40px;height:40px;border-radius:11px;background:${avatarBg};display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fa-solid fa-user" style="color:${avatarCol};font-size:.88rem;"></i></div><div><div style="font-weight:700;font-size:.88rem;color:#1a1a1a;line-height:1.25;">${esc(r.patient_name)}</div>${sub}</div></div>`;
    const dateCol =
      `<div class="req-date-col"><div style="font-size:.65rem;font-weight:700;color:#bbb;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.18rem;">Date Requested</div><div style="font-size:.85rem;font-weight:600;color:#333;">${esc(r.request_date)}</div><div style="font-size:.72rem;color:#ccc;">${esc(r.request_time)}</div></div>`;
    const docCol =
      `<div class="req-doc-col"><div style="font-size:.65rem;font-weight:700;color:#bbb;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.18rem;">Document</div><div style="font-size:.85rem;font-weight:600;color:#333;margin-bottom:.35rem;">${esc(r.document_type)}</div><span class="status-badge ${badgeCls}">${r.status.charAt(0).toUpperCase() + r.status.slice(1)}</span></div>`;

    if (r.status === 'pending') {
      const actionCol =
        `<button class="btn-view" data-id="${r.id}" onclick="toggleDesktopDetail(this,${r.id})"><i class="fa-solid fa-eye"></i> View</button>`;
      const detail =
        `<div class="detail-panel" id="detail-${r.id}"><div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;margin-bottom:1.1rem;"><div style="font-size:.8rem;color:#888;">Pending request from <strong style="color:#333;">${esc(r.patient_name)}</strong></div><div style="display:flex;align-items:center;gap:.55rem;flex-wrap:wrap;"><button class="btn-approve" onclick="openApprove(${r.id},'${esc(r.patient_name)}')"><i class="fa-solid fa-check"></i> Approve</button><button class="btn-reject" onclick="openReject(${r.id},'${esc(r.patient_name)}')"><i class="fa-solid fa-xmark"></i> Reject</button><button class="btn-close-detail" onclick="closeDesktopDetail(${r.id})">Close</button></div></div><div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:1.1rem;padding-top:.9rem;border-top:1px solid #f0f0f0;"><div><div class="dl">Patient</div><div class="dv">${esc(r.patient_name)}</div></div>${r.sub_label ? `<div><div class="dl">Department</div><div class="dv">${esc(r.sub_label)}</div></div>` : ''}<div><div class="dl">Date</div><div class="dv">${esc(r.request_date)}</div></div><div><div class="dl">Time</div><div class="dv">${esc(r.request_time)}</div></div><div><div class="dl">Document</div><div class="dv">${esc(r.document_type)}</div></div><div><div class="dl">Purpose</div><div class="dv">${esc(r.purpose)}</div></div></div></div>`;
      return `<div class="req-row desktop-req-row" id="row-d-${r.id}"><div class="accent-bar" style="background:${accentHex};"></div><div class="req-inner" style="display:grid;grid-template-columns:1fr 1fr 1.4fr auto;align-items:center;gap:1rem;">${nameCol}${dateCol}${docCol}${actionCol}</div>${detail}</div>`;
    }
    const purposeCol =
      `<div class="req-purpose-col" style="text-align:right;"><div style="font-size:.65rem;font-weight:700;color:#bbb;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.18rem;">Purpose</div><div style="font-size:.8rem;color:#666;">${esc(r.purpose)}</div></div>`;
    return `<div class="req-row desktop-req-row"><div class="accent-bar" style="background:${accentHex};"></div><div class="req-inner" style="display:grid;grid-template-columns:1fr 1fr 1.4fr auto;align-items:center;gap:1rem;">${nameCol}${dateCol}${docCol}${purposeCol}</div></div>`;
  }

  function buildGridCard(r) {
    const accentHex = r.status === 'approved' ? '#15803d' : r.status === 'rejected' ? '#b91c1c' : '#c2410c';
    const badgeCls = r.status === 'approved' ? 'badge-approved' : r.status === 'rejected' ? 'badge-rejected' :
      'badge-pending';

    let actions = '';

    if (r.status === 'pending') {
      actions = `
      <div class="docreq-grid-actions">
        <button class="btn-approve" onclick="openApprove(${r.id},'${esc(r.patient_name)}')">
          <i class="fa-solid fa-check"></i> Approve
        </button>
        <button class="btn-reject" onclick="openReject(${r.id},'${esc(r.patient_name)}')">
          <i class="fa-solid fa-xmark"></i> Reject
        </button>
      </div>
    `;
    }

    return `
    <div class="docreq-grid-card" style="--card-accent:${accentHex}">
      <div class="docreq-grid-head">
        <div>
          <div class="docreq-grid-name">${esc(r.patient_name)}</div>
          <div class="docreq-grid-sub">${esc(r.sub_label || '—')}</div>
        </div>
        <span class="status-badge ${badgeCls}">${r.status.charAt(0).toUpperCase() + r.status.slice(1)}</span>
      </div>

      <div class="docreq-grid-meta">
        <div>
          <div class="docreq-grid-label">Date</div>
          <div class="docreq-grid-value">${esc(r.request_date)}</div>
        </div>
        <div>
          <div class="docreq-grid-label">Time</div>
          <div class="docreq-grid-value">${esc(r.request_time)}</div>
        </div>
        <div>
          <div class="docreq-grid-label">Document</div>
          <div class="docreq-grid-value">${esc(r.document_type)}</div>
        </div>
        <div>
          <div class="docreq-grid-label">Purpose</div>
          <div class="docreq-grid-value">${esc(r.purpose)}</div>
        </div>
      </div>

      ${actions}
    </div>
  `;
  }

  function buildEmptyStateHtml() {
    const isSearchMiss = searchQuery !== '';
    const hasAdvancedFilters =
      filterDocType !== '' ||
      filterDateFrom !== '' ||
      filterDateTo !== '' ||
      filterSort !== 'newest' ||
      activeFilter !== 'all';

    const isDataEmpty = allRequests.length === 0;

    let iconHtml, title, subtitle, buttonLabel = '',
      buttonAction = '',
      compactClass = 'compact';

    if (isDataEmpty && !isSearchMiss && !hasAdvancedFilters) {
      iconHtml = '<i class="fa-regular fa-folder-open"></i>';
      title = 'No document requests yet';
      subtitle = 'Incoming patient document requests will appear here once submitted.';
    } else if (isSearchMiss) {
      iconHtml = '<i class="fa-solid fa-magnifying-glass"></i>';
      title = `No results for "${esc(searchQuery)}"`;
      subtitle = 'Try another patient name or clear the search to see all requests.';
      buttonLabel = 'Clear search';
      buttonAction = 'clearSearch()';
    } else {
      iconHtml = '<i class="fa-solid fa-filter-circle-xmark"></i>';
      title = 'No matching requests found';
      subtitle = 'Your current filters did not return any records. Try adjusting or clearing them.';
      buttonLabel = 'Clear filters';
      buttonAction = 'resetAllFilters()';
    }

    return `
    <div class="empty-state-wrapper ${compactClass}">
      <div class="empty-icon-box">${iconHtml}</div>
      <div class="empty-title">${title}</div>
      <div class="empty-sub">${subtitle}</div>
      ${buttonLabel ? `
            <button onclick="${buttonAction}" class="empty-clear-btn">
              <i class="fa-solid fa-xmark"></i> ${buttonLabel}
            </button>
          ` : ''}
    </div>
  `;
  }

  function buildMobileCard(r) {
    const accentHex = r.status === 'approved' ? '#15803d' : r.status === 'rejected' ? '#b91c1c' : '#c2410c';
    const avatarBg = r.status === 'approved' ? '#dcfce7' : r.status === 'rejected' ? '#fee2e2' : '#fff7ed';
    const avatarCol = r.status === 'approved' ? '#15803d' : r.status === 'rejected' ? '#b91c1c' : '#c2410c';
    const badgeCls = r.status === 'approved' ? 'badge-approved' : r.status === 'rejected' ? 'badge-rejected' :
      'badge-pending';
    const sub = r.sub_label ? `<div class="mobile-sub-label">${esc(r.sub_label)}</div>` : '';

    const viewBtn = r.status === 'pending' ?
      `<button class="btn-view" style="font-size:.74rem;padding:.38rem .85rem;" id="mbtn-${r.id}" onclick="toggleMobileDetail(this,${r.id})"><i class="fa-solid fa-eye" id="micon-${r.id}"></i> <span id="mtext-${r.id}">View</span></button>` :
      `<span class="status-badge ${badgeCls}">${r.status.charAt(0).toUpperCase() + r.status.slice(1)}</span>`;

    const detailContent = r.status === 'pending' ? `
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
          <div><div class="mobile-meta-label">Date</div><div class="mobile-meta-value">${esc(r.request_date)}</div></div>
          <div><div class="mobile-meta-label">Time</div><div class="mobile-meta-value">${esc(r.request_time)}</div></div>
          <div style="grid-column:span 2;"><div class="mobile-meta-label">Document</div><div class="mobile-meta-value">${esc(r.document_type)}</div></div>
          <div style="grid-column:span 2;"><div class="mobile-meta-label">Purpose</div><div class="mobile-meta-value">${esc(r.purpose)}</div></div>
          ${r.sub_label ? `<div style="grid-column:span 2;"><div class="mobile-meta-label">Department</div><div class="mobile-meta-value">${esc(r.sub_label)}</div></div>` : ''}
        </div>
        <div class="mobile-action-btns">
          <button class="btn-approve" onclick="openApprove(${r.id},'${esc(r.patient_name)}')"><i class="fa-solid fa-check"></i> Approve</button>
          <button class="btn-reject"  onclick="openReject(${r.id},'${esc(r.patient_name)}')"><i class="fa-solid fa-xmark"></i> Reject</button>
          <button class="btn-close-detail" onclick="closeMobileDetail(${r.id})">Close</button>
        </div>` : `
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
          <div><div class="mobile-meta-label">Date</div><div class="mobile-meta-value">${esc(r.request_date)}</div></div>
          <div><div class="mobile-meta-label">Time</div><div class="mobile-meta-value">${esc(r.request_time)}</div></div>
          <div style="grid-column:span 2;"><div class="mobile-meta-label">Document</div><div class="mobile-meta-value">${esc(r.document_type)}</div></div>
          <div style="grid-column:span 2;"><div class="mobile-meta-label">Purpose</div><div class="mobile-meta-value">${esc(r.purpose)}</div></div>
        </div>`;

    return `
        <div class="mobile-req-card" id="row-m-${r.id}" style="border-left:4px solid ${accentHex};">
          <div class="mobile-card-inner">
            <div class="mobile-card-header">
              <div class="mobile-patient-info">
                <div class="mobile-avatar" style="background:${avatarBg};">
                  <i class="fa-solid fa-user" style="color:${avatarCol};"></i>
                </div>
                <div style="min-width:0;">
                  <div class="mobile-patient-name">${esc(r.patient_name)}</div>
                  ${sub}
                </div>
              </div>
              ${viewBtn}
            </div>
            <div class="mobile-card-meta">
              <div>
                <div class="mobile-meta-label">Date</div>
                <div class="mobile-meta-value">${esc(r.request_date)}</div>
              </div>
              <div>
                <div class="mobile-meta-label">Document</div>
                <div class="mobile-meta-value" style="font-size:.78rem;">${esc(r.document_type)}</div>
              </div>
            </div>
            <div class="mobile-card-footer">
              <span class="status-badge ${badgeCls}">${r.status.charAt(0).toUpperCase() + r.status.slice(1)}</span>
              <span style="font-size:.72rem;color:#aaa;">${esc(r.request_time)}</span>
            </div>
          </div>
          <div class="mobile-detail-panel" id="mdetail-${r.id}">
            ${detailContent}
          </div>
        </div>`;
  }

  function toggleDesktopDetail(btn, id) {
    const panel = document.getElementById(`detail-${id}`);
    const opening = !panel.classList.contains('open');
    panel.classList.toggle('open');
    btn.innerHTML = opening ?
      '<i class="fa-solid fa-eye-slash"></i> Hide' :
      '<i class="fa-solid fa-eye"></i> View';
  }

  function closeDesktopDetail(id) {
    const panel = document.getElementById(`detail-${id}`);
    if (panel) panel.classList.remove('open');
    const row = document.getElementById(`row-d-${id}`);
    if (row) {
      const vb = row.querySelector('.btn-view');
      if (vb) vb.innerHTML = '<i class="fa-solid fa-eye"></i> View';
    }
  }

  function toggleMobileDetail(btn, id) {
    const panel = document.getElementById(`mdetail-${id}`);
    const textEl = document.getElementById(`mtext-${id}`);
    const iconEl = document.getElementById(`micon-${id}`);
    const opening = !panel.classList.contains('open');
    panel.classList.toggle('open');
    if (textEl) textEl.textContent = opening ? 'Hide' : 'View';
    if (iconEl) iconEl.className = opening ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
  }

  function closeMobileDetail(id) {
    const panel = document.getElementById(`mdetail-${id}`);
    const textEl = document.getElementById(`mtext-${id}`);
    const iconEl = document.getElementById(`micon-${id}`);
    if (panel) panel.classList.remove('open');
    if (textEl) textEl.textContent = 'View';
    if (iconEl) iconEl.className = 'fa-solid fa-eye';
  }

  function esc(str) {
    return String(str ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g,
      '&quot;');
  }

  function renderPagination(total, lastPage) {
    const ctrl = document.getElementById('pagControls');
    if (lastPage <= 1) {
      ctrl.innerHTML = '';
      return;
    }
    let html = '';
    html +=
      `<button class="pag-btn" ${currentPage > 1 ? '' : 'disabled'} onclick="goPage(${currentPage - 1})">‹ Prev</button>`;
    for (let p = 1; p <= lastPage; p++) html +=
      `<button class="pag-btn ${p === currentPage ? 'pag-active' : ''}" onclick="goPage(${p})">${p}</button>`;
    html +=
      `<button class="pag-btn" ${currentPage < lastPage ? '' : 'disabled'} onclick="goPage(${currentPage + 1})">Next ›</button>`;
    ctrl.innerHTML = html;
  }

  function goPage(p) {
    currentPage = p;
    renderList();
    const activeContainer = currentViewMode === 'grid' ?
      document.getElementById('requestGridContainer') :
      document.getElementById('requestListContainer');

    if (activeContainer) {
      activeContainer.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  }

  function setFilter(f) {
    activeFilter = f;
    currentPage = 1;
    document.querySelectorAll('#statCards .stat-card').forEach(c =>
      c.getAttribute('data-filter') === f ? c.classList.add('stat-active') : c.classList.remove('stat-active')
    );
    renderList();
  }

  function onSearch(input) {
    searchQuery = input.value.trim();
    currentPage = 1;

    const clearBtn = document.getElementById('searchClearBtn');
    if (clearBtn) {
      if (searchQuery.length > 0) {
        clearBtn.classList.remove('hidden');
      } else {
        clearBtn.classList.add('hidden');
      }
    }
    renderList();
  }

  function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('searchClearBtn');
    if (searchInput) {
      searchInput.value = '';
      searchQuery = '';
      if (clearBtn) clearBtn.classList.add('hidden');
      currentPage = 1;
      renderList();
      searchInput.focus();
    }
  }

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

  function openFilterModal() {
    syncFilterTagGroup('fStatusGroup', filterStatus);
    syncFilterTagGroup('fSortGroup', filterSort);
    document.getElementById('fDocType').value = filterDocType;
    document.getElementById('fDateFrom').value = filterDateFrom;
    document.getElementById('fDateTo').value = filterDateTo;
    renderFilterChips();
    openModal(document.getElementById('filterModal'));
  }

  function syncFilterTagGroup(groupId, activeVal) {
    document.querySelectorAll(`#${groupId} .ftag`).forEach(btn =>
      btn.getAttribute('data-val') === activeVal ? btn.classList.add('ftag-active') : btn.classList.remove(
        'ftag-active'));
  }

  function applyFilterModal() {
    const statusActive = document.querySelector('#fStatusGroup .ftag.ftag-active');
    filterStatus = statusActive ? statusActive.getAttribute('data-val') : 'all';
    activeFilter = filterStatus;
    document.querySelectorAll('#statCards .stat-card').forEach(c =>
      c.getAttribute('data-filter') === activeFilter ? c.classList.add('stat-active') : c.classList.remove(
        'stat-active')
    );
    const sortActive = document.querySelector('#fSortGroup .ftag.ftag-active');
    filterSort = sortActive ? sortActive.getAttribute('data-val') : 'newest';
    filterDocType = document.getElementById('fDocType').value;
    filterDateFrom = document.getElementById('fDateFrom').value;
    filterDateTo = document.getElementById('fDateTo').value;

    updateFilterBtn();
    renderFilterChips();
    currentPage = 1;
    closeModal(document.getElementById('filterModal'));
    renderList();
  }

  function renderFilterChips() {
    const container = document.getElementById("activeChipsContainer");
    const section = document.getElementById("activeFiltersSection");
    if (!container || !section) return;

    container.innerHTML = "";
    let hasChips = false;

    function addChip(label, onRemove) {
      hasChips = true;
      const chip = document.createElement("div");
      chip.className = "filter-chip";
      chip.innerHTML =
        `<span>${label}</span><span class="filter-chip-remove"><i class="fa-solid fa-xmark"></i></span>`;
      chip.querySelector(".filter-chip-remove").addEventListener("click", () => {
        onRemove();
        renderFilterChips();
      });
      container.appendChild(chip);
    }

    const statusActive = document.querySelector('#fStatusGroup .ftag.ftag-active');
    if (statusActive && statusActive.getAttribute('data-val') !== 'all') {
      addChip(`Status: ${statusActive.textContent.trim()}`, () => syncFilterTagGroup('fStatusGroup', 'all'));
    }

    const docType = document.getElementById('fDocType').value;
    if (docType) {
      addChip(`Doc: ${docType}`, () => document.getElementById('fDocType').value = "");
    }

    const fDate = document.getElementById('fDateFrom').value;
    const tDate = document.getElementById('fDateTo').value;
    if (fDate || tDate) {
      let lbl = (fDate && tDate) ? `${fDate} to ${tDate}` : (fDate ? `From ${fDate}` : `Until ${tDate}`);
      addChip(`Date: ${lbl}`, () => {
        document.getElementById('fDateFrom').value = "";
        document.getElementById('fDateTo').value = "";
      });
    }

    const sortActive = document.querySelector('#fSortGroup .ftag.ftag-active');
    if (sortActive && sortActive.getAttribute('data-val') !== 'newest') {
      addChip(`Sort: ${sortActive.textContent.trim()}`, () => syncFilterTagGroup('fSortGroup', 'newest'));
    }

    if (hasChips) {
      section.classList.remove("hidden");
      // Bind the new Clear All button
      document.getElementById("clearAllChipsBtn").onclick = () => {
        syncFilterTagGroup('fStatusGroup', 'all');
        document.getElementById('fDocType').value = "";
        document.getElementById('fDateFrom').value = "";
        document.getElementById('fDateTo').value = "";
        syncFilterTagGroup('fSortGroup', 'newest');
        renderFilterChips();
      };
    } else {
      section.classList.add("hidden");
    }
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

  document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll('.docreq-view-btn').forEach(function (b) {
      b.classList.remove('active');
    });
    const defaultViewBtn = document.querySelector('.docreq-view-btn[data-view="' + currentViewMode + '"]');
    if (defaultViewBtn) defaultViewBtn.classList.add('active');

    window.addEventListener('resize', function () {
      var shouldBeGrid = window.innerWidth <= 767;
      if (shouldBeGrid && currentViewMode !== 'grid') {
        currentViewMode = 'grid';
        document.querySelectorAll('.docreq-view-btn').forEach(function (b) {
          b.classList.remove('active');
        });
        var gridBtn = document.querySelector('.docreq-view-btn[data-view="grid"]');
        if (gridBtn) gridBtn.classList.add('active');
        renderList();
      }
    });

    document.getElementById('fDocType').addEventListener('change', renderFilterChips);
    document.getElementById('fDateFrom').addEventListener('change', renderFilterChips);
    document.getElementById('fDateTo').addEventListener('change', renderFilterChips);

    ['fStatusGroup', 'fSortGroup'].forEach(groupId => {
      document.getElementById(groupId).addEventListener('click', e => {
        const btn = e.target.closest('.ftag');
        if (!btn) return;
        document.querySelectorAll(`#${groupId} .ftag`).forEach(b => b.classList.remove(
          'ftag-active'));
        btn.classList.add('ftag-active');
        renderFilterChips();
      });
    });

    document.addEventListener('keydown', e => {
      if (e.key !== 'Escape') return;
      ['approveModal', 'rejectModal', 'approvedResultModal', 'rejectedResultModal', 'filterModal']
        .forEach(id => {
          const m = document.getElementById(id);
          if (m?.classList.contains('open')) closeModal(m);
        });
    });

    ['approveModal', 'rejectModal', 'approvedResultModal', 'rejectedResultModal', 'filterModal']
      .forEach(id => outside(document.getElementById(id)));

    const filterModal = document.getElementById('filterModal');
    document.getElementById('filterCloseBtn').addEventListener('click', () => closeModal(filterModal));
    document.getElementById('filterCancelBtn').addEventListener('click', () => closeModal(filterModal));
    document.getElementById('filterApplyBtn').addEventListener('click', applyFilterModal);
    document.getElementById('filterResetBtn').addEventListener('click', () => {
      resetAllFilters();
      resetFilterModal();
      renderFilterChips();
    });

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
          reason: notes
        })
      });
      btn.disabled = false;
      if (res.ok) {
        closeModal(rejectModal);
        openModal(rejectedModal);
      } else alert('Something went wrong.');
    });

    loadData();
  });
</script>
@endsection