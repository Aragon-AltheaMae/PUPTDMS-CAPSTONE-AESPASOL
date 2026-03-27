@extends('layouts.dentist')

@section('title', 'Appointments | PUP Taguig Dental Clinic')

@section('styles')
<style>
    :root {
        --crimson: #8B0000;
        --crimson-dark: #6b0000;
        --crimson-light: #fef2f2;
        --crimson-mid: #fce8e8;
        --sidebar-w: 220px;
        --header-h: 64px;
    }

    body {
        font-family: 'Inter', sans-serif;
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

    /* ── TOAST ── */
    #toastContainer {
        position: fixed;
        bottom: 28px;
        right: 16px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
    }

    .toast-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        box-shadow: 0 6px 24px rgba(0, 0, 0, .18);
        pointer-events: auto;
        animation: toastIn .3s cubic-bezier(.4, 0, .2, 1) forwards;
        min-width: 200px;
        max-width: calc(100vw - 32px);
    }

    .toast-item.success {
        background: #1A6B34;
    }

    .toast-item.error {
        background: #C0392B;
    }

    @keyframes toastIn {
        from {
            opacity: 0;
            transform: translateY(14px) scale(.96);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes toastOut {
        from {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        to {
            opacity: 0;
            transform: translateY(14px) scale(.96);
        }
    }

    .toast-item.leaving {
        animation: toastOut .25s ease forwards;
    }

    [data-theme="dark"] .bg-white {
        background-color: #000D1A !important;
    }

    [data-theme="dark"] .text-\[\#333333\] {
        color: #E5E7EB !important;
    }

    /* ════════════════════
           STAT CARDS
        ════════════════════ */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (max-width: 1024px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 18px 16px;
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
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 30px;
        font-weight: 800;
        line-height: 1;
    }

    .stat-footer {
        font-size: 10px;
        color: #ADA9A5;
        margin-top: 6px;
    }

    @media (max-width: 480px) {
        .stat-value {
            font-size: 24px;
        }
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

    .stat-icon {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 38px;
        height: 38px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    @media (max-width: 480px) {
        .stat-icon {
            display: none;
        }
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

    /* ════════════════════
           TOOLBAR
        ════════════════════ */
    .search-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #FAFAF9;
        border: 1.5px solid #E0DDD8;
        border-radius: 12px;
        padding: 0 14px;
        height: 40px;
        transition: border-color .2s, box-shadow .2s;
        width: 240px;
        min-width: 0;
        flex-shrink: 1;
    }

    @media (max-width: 640px) {
        .search-wrap {
            width: 100%;
        }
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

    .tab-group {
        display: flex;
        background: #F5F2EE;
        border: 1px solid #E8E4DE;
        border-radius: 10px;
        padding: 3px;
        gap: 2px;
        flex-shrink: 0;
    }

    .tab-btn {
        padding: 6px 12px;
        border-radius: 7px;
        border: none;
        background: none;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        color: #9A9490;
        transition: all .2s;
        white-space: nowrap;
    }

    .tab-btn.active {
        background: #8B0000;
        color: #fff;
        box-shadow: 0 2px 8px rgba(139, 0, 0, .3);
    }

    .btn-filter {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        height: 40px;
        padding: 0 14px;
        border-radius: 10px;
        border: 1.5px solid #E0DDD8;
        background: #fff;
        font-size: 13px;
        font-weight: 600;
        color: #6B6661;
        cursor: pointer;
        transition: all .2s;
        flex-shrink: 0;
    }

    .btn-filter:hover {
        border-color: #8B0000;
        color: #8B0000;
        background: #FFF8F8;
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        height: 40px;
        padding: 0 14px;
        border-radius: 10px;
        border: none;
        background: #8B0000;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s;
        box-shadow: 0 3px 10px rgba(139, 0, 0, .3);
        flex-shrink: 0;
        white-space: nowrap;
    }

    .btn-add:hover {
        background: #660000;
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

    .row-count {
        font-size: 12px;
        color: #9A9490;
        white-space: nowrap;
    }

    /* ════════════════════
           TABLE
        ════════════════════ */
    .inv-table {
        width: 100%;
        border-collapse: collapse;
    }

    .inv-table thead tr {
        background: #FAFAF9;
        border-bottom: 2px solid #EDE9E4;
    }

    .inv-table th {
        padding: 12px 14px;
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
        padding: 12px 14px;
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
        padding: 3px 7px;
        border-radius: 6px;
        color: #7A7370;
        display: inline-block;
        white-space: nowrap;
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
        padding: 2px 7px;
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

    .bal-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 9px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .bal-chip::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
        flex-shrink: 0;
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

    .table-footer-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        border-top: 1px solid #EDE9E4;
        background: #FAFAF9;
        border-radius: 0 0 12px 12px;
    }

    /* ════════════════════
           FILTER PANEL
        ════════════════════ */
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
        width: 320px;
        z-index: 200;
        background: #fff;
        border-left: 1px solid #E8E4DE;
        box-shadow: -4px 0 24px rgba(0, 0, 0, .1);
        display: flex;
        flex-direction: column;
        transition: right .3s cubic-bezier(.4, 0, .2, 1);
    }

    @media (max-width: 480px) {
        .filter-panel {
            width: 100%;
            right: -100%;
        }
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
        transition: all .2s;
        box-shadow: 0 3px 10px rgba(139, 0, 0, .3);
    }

    .fp-btn-apply:hover {
        background: #660000;
    }

    /* ════════════════════
           MODALS
        ════════════════════ */
    .modal-box-custom {
        background: #fff;
        border-radius: 18px;
        padding: 24px;
        width: 500px;
        max-width: 95vw;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .15);
    }

    @media (max-width: 640px) {
        .modal-box-custom {
            padding: 20px;
            border-radius: 16px;
        }
    }

    .modal-header-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .modal-icon-custom {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        flex-shrink: 0;
        background: linear-gradient(135deg, #660000, #8B0000);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        color: #fff;
    }

    .modal-title-custom {
        font-size: 17px;
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
        gap: 12px;
    }

    @media (max-width: 480px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
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
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .btn-modal-cancel {
        height: 40px;
        padding: 0 18px;
        border-radius: 9px;
        border: 1.5px solid #E0DDD8;
        background: #F5F2EE;
        font-size: 13px;
        font-weight: 600;
        color: #6B6661;
        cursor: pointer;
        transition: all .2s;
    }

    .btn-modal-cancel:hover {
        background: #EDE9E4;
    }

    .btn-modal-save {
        height: 40px;
        padding: 0 20px;
        border-radius: 9px;
        border: none;
        background: #8B0000;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s;
        box-shadow: 0 3px 10px rgba(139, 0, 0, .3);
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .btn-modal-save:hover {
        background: #660000;
    }

    .form-input-custom.is-invalid,
    .form-select-custom.is-invalid {
        border-color: #C0392B !important;
        box-shadow: 0 0 0 3px rgba(192, 57, 43, .12) !important;
        background: #FFF8F7 !important;
    }

    .form-input-custom.is-valid,
    .form-select-custom.is-valid {
        border-color: #2E7D32 !important;
        box-shadow: 0 0 0 3px rgba(46, 125, 50, .1) !important;
    }

    .field-error {
        font-size: 10px;
        font-weight: 600;
        color: #C0392B;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 4px;
        min-height: 14px;
        animation: errorSlide .15s ease-out;
    }

    @keyframes errorSlide {
        from {
            opacity: 0;
            transform: translateY(-3px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .char-counter {
        font-size: 10px;
        color: #B0ABA6;
        text-align: right;
        margin-top: 3px;
        transition: color .2s;
    }

    .char-counter.warn {
        color: #E65100;
    }

    .char-counter.over {
        color: #C0392B;
        font-weight: 700;
    }
</style>
@endsection

@section('content')
@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<div id="toastContainer"></div>

<!-- ════════ MAIN ════════ -->
<main id="mainContent" class="pt-[100px] px-6 py-6 fade-in min-h-screen">
    <div class="max-w-7xl mx-auto fade-in">

        <div class="mb-5">
            <p class="text-[10px] font-bold uppercase tracking-widest text-[#C9A84C] mb-1">
                <i class="fa-solid fa-box mr-1"></i> Stock Management
            </p>
            <h1 class="text-xl sm:text-2xl font-extrabold text-[#660000] leading-tight">Inventory</h1>
            <p class="text-sm text-gray-400 mt-1">Track and manage dental supplies &amp; medicines</p>
        </div>

        <!-- STAT CARDS -->
        <div class="stat-grid">
            <div class="stat-card s-total">
                <div class="stat-label">Total Items</div>
                <div class="stat-value" id="statTotal">—</div>
                <div class="stat-footer">all categories</div>
                <div class="stat-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
            </div>
            <div class="stat-card s-medicine">
                <div class="stat-label">Medicines</div>
                <div class="stat-value" id="statMedicine">—</div>
                <div class="stat-footer">pharmaceutical</div>
                <div class="stat-icon"><i class="fa-solid fa-pills"></i></div>
            </div>
            <div class="stat-card s-supplies">
                <div class="stat-label">Supplies</div>
                <div class="stat-value" id="statSupplies">—</div>
                <div class="stat-footer">consumables</div>
                <div class="stat-icon"><i class="fa-solid fa-syringe"></i></div>
            </div>
            <div class="stat-card s-low">
                <div class="stat-label">Low Stock</div>
                <div class="stat-value" id="statLow">—</div>
                <div class="stat-footer">need restocking</div>
                <div class="stat-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="bg-white rounded-xl shadow-sm border border-[#EDE9E4] overflow-hidden">

            <!-- TOOLBAR -->
            <div class="px-4 sm:px-5 py-4 border-b border-[#EDE9E4] flex flex-col gap-3">
                <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                    <div class="search-wrap flex-1 sm:flex-none">
                        <i class="fa fa-search"></i>
                        <input id="searchInput" placeholder="Search Stock No., Name…"
                            oninput="renderTable(); toggleSearchClear(this)" />
                        <button type="button" id="searchClearBtn" class="search-clear-btn" onclick="clearSearch()"
                            title="Clear">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="tab-group">
                        <button class="tab-btn active" onclick="setTab('all',this)">All</button>
                        <button class="tab-btn" onclick="setTab('medicine',this)">Med</button>
                        <button class="tab-btn" onclick="setTab('supplies',this)">Sup</button>
                    </div>
                </div>
                <div class="flex items-center justify-between gap-2 flex-wrap">
                    <span class="row-count" id="rowCount"></span>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="openFilterPanel()" class="btn-filter">
                            <i class="fa-solid fa-sliders"></i>
                            <span class="hidden sm:inline">Filter</span>
                        </button>
                        <button onclick="resetAddForm(); document.getElementById('addModal').showModal()"
                            class="btn-add">
                            <span class="add-icon"><i class="fa-solid fa-plus"></i></span>
                            <span>Add Item</span>
                        </button>
                    </div>
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

            <div id="emptyState" style="display:none;"></div>

            <div class="table-footer-bar">
                <span class="text-xs text-gray-400" id="pageInfo"></span>
                <div></div>
            </div>
        </div>
    </div>
</main>

<!-- ════════ FILTER PANEL ════════ -->
<div class="filter-overlay" id="filterOverlay" onclick="closeFilterPanel()"></div>
<div class="filter-panel" id="filterPanel">
    <div class="fp-header">
        <span class="fp-title"><i class="fa-solid fa-sliders"></i> Filter</span>
        <button class="fp-close-btn" onclick="closeFilterPanel()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="fp-body">
        <div class="fp-section">
            <div class="fp-section-title">Sort by Name</div>
            <label class="fp-radio-item"><input type="radio" name="fp_sort" value="az"><label>A → Z</label></label>
            <label class="fp-radio-item"><input type="radio" name="fp_sort" value="za"><label>Z → A</label></label>
        </div>
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
            <label class="fp-radio-item"><input type="radio" name="fp_dateOrder"
                    value="asc"><label>Ascending</label></label>
            <label class="fp-radio-item"><input type="radio" name="fp_dateOrder"
                    value="desc"><label>Descending</label></label>
        </div>
        <div class="fp-section">
            <div class="fp-section-title">Stock Level</div>
            <label class="fp-radio-item"><input type="radio" name="fp_stock" value="low-high"><label>Lowest →
                    Highest</label></label>
            <label class="fp-radio-item"><input type="radio" name="fp_stock" value="high-low"><label>Highest →
                    Lowest</label></label>
        </div>
    </div>
    <div class="fp-footer">
        <button class="fp-btn-clear" onclick="clearFilterPanel()">Clear All</button>
        <button class="fp-btn-apply" onclick="saveFilterPanel()"><i class="fa-solid fa-check mr-1"></i>
            Apply</button>
    </div>
</div>

<!-- ════════ ADD MODAL ════════ -->
<dialog id="addModal" class="modal backdrop-blur-sm">
    <div class="modal-box-custom">
        <div class="modal-header-custom">
            <div class="modal-icon-custom"><i class="fa-solid fa-plus"></i></div>
            <div>
                <div class="modal-title-custom">Add Inventory Item</div>
                <div class="modal-sub-custom">A new row will be appended every time you save</div>
            </div>
        </div>
        <div class="form-grid-2">
            <div class="form-group-custom">
                <div class="form-label-custom">Category <span style="color:#C0392B">*</span></div>
                <select id="addCategory" class="form-select-custom" onchange="validateAddField('addCategory')">
                    <option disabled selected value="">Select…</option>
                    <option value="Medicine">Medicine</option>
                    <option value="Supplies">Supplies</option>
                </select>
                <div class="field-error" id="err-addCategory"></div>
            </div>
            <div class="form-group-custom">
                <div class="form-label-custom">Date Received <span style="color:#C0392B">*</span></div>
                <input id="addDate" type="date" class="form-input-custom" onchange="validateAddField('addDate')">
                <div class="field-error" id="err-addDate"></div>
            </div>
            <div class="form-group-custom">
                <div class="form-label-custom">Stock Number <span style="color:#C0392B">*</span></div>
                <input id="addStock" class="form-input-custom" placeholder="00-000" maxlength="6"
                    oninput="formatStockNo(this); validateAddField('addStock')" style="letter-spacing:0.15em">
                <div class="field-error" id="err-addStock"></div>
            </div>
            <div class="form-group-custom">
                <div class="form-label-custom">Unit <span style="color:#C0392B">*</span></div>
                <input id="addUnit" class="form-input-custom" placeholder="Box / Bottle / Pack" maxlength="30"
                    oninput="validateAddField('addUnit')">
                <div class="field-error" id="err-addUnit"></div>
            </div>
            <div class="form-group-custom full">
                <div class="flex justify-between items-center">
                    <div class="form-label-custom">Supply / Medicine Name <span style="color:#C0392B">*</span></div>
                    <div class="char-counter" id="charCounter-addName">0 / 100</div>
                </div>
                <input id="addName" class="form-input-custom" placeholder="e.g. Nitrile Gloves Large" maxlength="100"
                    oninput="updateCharCounter('addName',100); validateAddField('addName')">
                <div class="field-error" id="err-addName"></div>
            </div>
            <div class="form-group-custom">
                <div class="form-label-custom">Quantity <span style="color:#C0392B">*</span></div>
                <input id="addQty" type="number" class="form-input-custom" placeholder="0" min="0" max="99999"
                    oninput="computeAddBalance(); validateAddField('addQty'); validateAddField('addUsed')">
                <div class="field-error" id="err-addQty"></div>
            </div>
            <div class="form-group-custom">
                <div class="form-label-custom">Consumed</div>
                <input id="addUsed" type="number" class="form-input-custom" placeholder="0" min="0" max="99999"
                    oninput="computeAddBalance(); validateAddField('addUsed')">
                <div class="field-error" id="err-addUsed"></div>
            </div>
            <div class="form-group-custom full">
                <div class="form-label-custom">Balance (auto-calculated)</div>
                <input id="addBalance" class="form-input-custom" readonly placeholder="—">
            </div>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" onclick="document.getElementById('addModal').close()">Cancel</button>
            <button id="btnSaveAdd" class="btn-modal-save" onclick="addItem()">
                <i class="fa-solid fa-floppy-disk"></i> Save Item
            </button>
        </div>
    </div>
</dialog>

<!-- ════════ EDIT MODAL ════════ -->
<dialog id="editModal" class="modal">
    <div class="modal-box-custom">
        <div class="modal-header-custom">
            <div class="modal-icon-custom" style="background:linear-gradient(135deg,#1a4a8a,#2563EB);">
                <i class="fa-solid fa-pen"></i>
            </div>
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
            <button class="btn-modal-save" onclick="saveEdit()">
                <i class="fa-solid fa-floppy-disk"></i> Save Changes
            </button>
        </div>
    </div>
</dialog>

<!-- ════════ DELETE MODAL ════════ -->
<dialog id="deleteModal" class="modal">
    <div class="modal-box-custom" style="max-width:380px;text-align:center;">
        <div
            class="w-[60px] h-[60px] rounded-2xl bg-gradient-to-br from-[#FFE5E5] to-[#FFCDD2] flex items-center justify-center text-[26px] text-[#C0392B] mx-auto mb-3">
            <i class="fa-solid fa-trash"></i>
        </div>
        <div class="text-lg font-bold text-[#1A1614] mb-2">Delete Item?</div>
        <div class="text-[13px] text-[#9A9490] mb-6">
            This action cannot be undone. The item will be permanently removed from your inventory.
        </div>
        <div class="modal-footer-custom justify-center">
            <button class="btn-modal-cancel" onclick="document.getElementById('deleteModal').close()">Cancel</button>
            <button id="confirmDeleteBtn" class="btn-modal-save"
                style="background:#C0392B;box-shadow:0 3px 10px rgba(192,57,43,.3);">
                <i class="fa-solid fa-trash"></i> Delete
            </button>
        </div>
    </div>
</dialog>

@endsection

@section('scripts')
<script>
    /* ── Toast ── */
    function showToast(type, message, duration = 3000) {
        var container = document.getElementById('toastContainer');
        var toast = document.createElement('div');
        toast.className = 'toast-item ' + type;
        var icon = type === 'success' ? '<i class="fa-solid fa-circle-check"></i>' : '<i class="fa-solid fa-circle-exclamation"></i>';
        toast.innerHTML = icon + ' ' + message;
        container.appendChild(toast);
        setTimeout(function () {
            toast.classList.add('leaving');
            toast.addEventListener('animationend', function () { toast.remove(); });
        }, duration);
    }

    /* ════════════════════════
       INVENTORY
    ════════════════════════ */
    var inventory = [];
    var activeTab = 'all';

    async function loadInventory() {
        var res = await fetch('/dentist/inventory/data', { cache: 'no-store' });
        var ct = res.headers.get('content-type') || '';
        if (!ct.includes('application/json')) { console.error('Inventory data is not JSON.'); return; }
        inventory = await res.json();
        renderTable();
    }
    loadInventory();

    function updateStats() {
        document.getElementById('statTotal').textContent = inventory.length;
        document.getElementById('statMedicine').textContent = inventory.filter(function (i) { return i.category === 'Medicine'; }).length;
        document.getElementById('statSupplies').textContent = inventory.filter(function (i) { return i.category === 'Supplies'; }).length;
        document.getElementById('statLow').textContent = inventory.filter(function (i) { return (Number(i.qty) - Number(i.used)) <= 5; }).length;
    }

    function setTab(tab, btn) {
        activeTab = tab;
        document.querySelectorAll('.tab-btn').forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');
        renderTable();
    }

    var activeFilters = { sort: '', dateFrom: '', dateTo: '', dateOrder: '', stock: '' };

    function openFilterPanel() {
        setRadio('fp_sort', activeFilters.sort); setRadio('fp_dateOrder', activeFilters.dateOrder); setRadio('fp_stock', activeFilters.stock);
        document.getElementById('fp_dateFrom').value = activeFilters.dateFrom || '';
        document.getElementById('fp_dateTo').value = activeFilters.dateTo || '';
        document.getElementById('filterPanel').classList.add('open');
        document.getElementById('filterOverlay').classList.add('open');
    }
    function closeFilterPanel() {
        document.getElementById('filterPanel').classList.remove('open');
        document.getElementById('filterOverlay').classList.remove('open');
    }
    function setRadio(name, val) {
        document.querySelectorAll('input[name="' + name + '"]').forEach(function (r) { r.checked = (val && r.value === val); });
    }
    function getRadio(name) { var el = document.querySelector('input[name="' + name + '"]:checked'); return el ? el.value : ''; }
    function clearFilterPanel() {
        ['fp_sort', 'fp_dateOrder', 'fp_stock'].forEach(function (n) { setRadio(n, ''); });
        document.getElementById('fp_dateFrom').value = ''; document.getElementById('fp_dateTo').value = '';
        Object.keys(activeFilters).forEach(function (k) { activeFilters[k] = ''; });
        closeFilterPanel(); renderTable();
    }
    function saveFilterPanel() {
        activeFilters.sort = getRadio('fp_sort'); activeFilters.dateOrder = getRadio('fp_dateOrder'); activeFilters.stock = getRadio('fp_stock');
        activeFilters.dateFrom = document.getElementById('fp_dateFrom').value || ''; activeFilters.dateTo = document.getElementById('fp_dateTo').value || '';
        closeFilterPanel(); renderTable();
    }

    function renderTable() {
        var tbody = document.getElementById('tableBody');
        tbody.innerHTML = '';
        var data = inventory.slice();
        if (activeTab === 'medicine') data = data.filter(function (i) { return i.category === 'Medicine'; });
        if (activeTab === 'supplies') data = data.filter(function (i) { return i.category === 'Supplies'; });
        var q = (document.getElementById('searchInput').value || '').toLowerCase();
        if (q) data = data.filter(function (i) { return String(i.stock_no || '').toLowerCase().includes(q) || String(i.name || '').toLowerCase().includes(q); });
        var from = activeFilters.dateFrom ? new Date(activeFilters.dateFrom) : null;
        var to = activeFilters.dateTo ? new Date(activeFilters.dateTo) : null;
        if (from) { from.setHours(0, 0, 0, 0); data = data.filter(function (i) { return i.date_received && new Date(i.date_received) >= from; }); }
        if (to) { to.setHours(23, 59, 59, 999); data = data.filter(function (i) { return i.date_received && new Date(i.date_received) <= to; }); }
        function n(v) { var x = Number(v); return isFinite(x) ? x : 0; }
        function dt(v) { if (!v) return 0; var t = new Date(v).getTime(); return isFinite(t) ? t : 0; }
        if (activeFilters.stock === 'low-high') data.sort(function (a, b) { return (n(a.qty) - n(a.used)) - (n(b.qty) - n(b.used)); });
        else if (activeFilters.stock === 'high-low') data.sort(function (a, b) { return (n(b.qty) - n(b.used)) - (n(a.qty) - n(a.used)); });
        else if (activeFilters.sort === 'az') data.sort(function (a, b) { return String(a.name || '').localeCompare(String(b.name || '')); });
        else if (activeFilters.sort === 'za') data.sort(function (a, b) { return String(b.name || '').localeCompare(String(a.name || '')); });
        else if (activeFilters.dateOrder === 'asc') data.sort(function (a, b) { return dt(a.date_received) - dt(b.date_received); });
        else if (activeFilters.dateOrder === 'desc') data.sort(function (a, b) { return dt(b.date_received) - dt(a.date_received); });
        updateStats();
        document.getElementById('rowCount').textContent = data.length + ' item' + (data.length !== 1 ? 's' : '');
        document.getElementById('pageInfo').textContent = 'Showing ' + data.length + ' of ' + inventory.length + ' items';
        var emptyState = document.getElementById('emptyState');
        if (!data.length) {
            emptyState.style.display = 'block';
            var isSearching = q.length > 0; var hasFilters = Object.values(activeFilters).some(Boolean);
            var icon, title, sub, extraHtml = '';
            if (isSearching) {
                icon = 'fa-magnifying-glass'; title = 'No results for "' + q + '"'; sub = 'Try a different stock number or supply name.';
                extraHtml = '<button onclick="clearSearch()" class="mt-3 px-4 py-2 rounded-xl border border-dashed border-gray-300 text-sm text-gray-400 hover:border-[#8B0000] hover:text-[#8B0000] transition-all duration-200"><i class="fa-solid fa-xmark mr-1.5 text-xs"></i> Clear search</button>';
            } else if (hasFilters) {
                icon = 'fa-sliders'; title = 'No matches for your filters'; sub = 'Try removing or adjusting your filter criteria.';
                extraHtml = '<button onclick="clearFilterPanel()" class="mt-3 px-4 py-2 rounded-xl border border-dashed border-gray-300 text-sm text-gray-400 hover:border-[#8B0000] hover:text-[#8B0000] transition-all duration-200"><i class="fa-solid fa-xmark mr-1.5 text-xs"></i> Clear filters</button>';
            } else {
                var msgs = { all: { icon: 'fa-box-open', title: 'No items in the inventory', sub: 'Add your first item using the "Add Item" button above.' }, medicine: { icon: 'fa-pills', title: 'No medicines in the inventory', sub: 'Add a medicine item above.' }, supplies: { icon: 'fa-syringe', title: 'No dental supplies in the inventory', sub: 'Add a supply item above.' } };
                var msg = msgs[activeTab] || msgs.all; icon = msg.icon; title = msg.title; sub = msg.sub;
            }
            emptyState.innerHTML = '<div class="flex flex-col items-center justify-center py-16 text-center gap-2"><div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-3"><i class="fa-solid ' + icon + ' text-3xl text-gray-300"></i></div><p class="text-base font-semibold text-gray-500">' + title + '</p><p class="text-sm text-gray-400 max-w-xs">' + sub + '</p>' + extraHtml + '</div>';
            return;
        }
        emptyState.style.display = 'none';
        data.forEach(function (item) {
            var balance = n(item.qty) - n(item.used);
            var balClass = balance <= 0 ? 'critical' : balance <= 5 ? 'low' : 'ok';
            var balLabel = balance <= 0 ? 'Out of stock' : balance <= 5 ? 'Low stock' : 'In stock';
            var catClass = item.category === 'Medicine' ? 'medicine' : 'supplies';
            tbody.innerHTML += '<tr><td style="color:#9A9490;font-size:12px;white-space:nowrap;">' + (item.formatted_date || '') + '</td><td><span class="stock-no">' + (item.stock_no || '') + '</span></td><td><div class="supply-name">' + (item.name || '') + '</div><span class="supply-cat ' + catClass + '">' + (item.category || '') + '</span></td><td style="color:#9A9490;">' + (item.unit || '') + '</td><td style="font-weight:700;">' + (item.qty || 0) + '</td><td style="color:#9A9490;">' + (item.used || 0) + '</td><td><span class="bal-chip ' + balClass + '">' + balance + ' <span style="font-weight:400;font-size:10px;">' + balLabel + '</span></span></td><td><div style="display:flex;justify-content:center;gap:6px;"><button class="act-btn edit" title="Edit" onclick="openEdit(' + item.id + ')"><i class="fa fa-pen"></i></button><button class="act-btn delete" title="Delete" onclick="deleteItem(' + item.id + ')"><i class="fa fa-trash"></i></button></div></td></tr>';
        });
    }

    function toggleSearchClear(input) { document.getElementById('searchClearBtn').classList.toggle('visible', input.value.length > 0); }
    function clearSearch() { var input = document.getElementById('searchInput'); input.value = ''; document.getElementById('searchClearBtn').classList.remove('visible'); renderTable(); input.focus(); }

    function formatStockNo(input) {
        var digits = input.value.replace(/\D/g, ''); if (digits.length > 5) digits = digits.slice(0, 5);
        input.value = digits.length <= 2 ? digits : digits.slice(0, 2) + '-' + digits.slice(2);
    }
    function updateCharCounter(fieldId, max) {
        var len = document.getElementById(fieldId).value.length;
        var counter = document.getElementById('charCounter-' + fieldId); if (!counter) return;
        counter.textContent = len + ' / ' + max;
        counter.className = 'char-counter' + (len >= max ? ' over' : len >= max * 0.85 ? ' warn' : '');
    }
    function setFieldState(id, errorMsg) {
        var el = document.getElementById(id); var errEl = document.getElementById('err-' + id); if (!el) return;
        if (errorMsg) { el.classList.add('is-invalid'); el.classList.remove('is-valid'); if (errEl) errEl.innerHTML = '<i class="fa-solid fa-circle-exclamation" style="font-size:9px;"></i> ' + errorMsg; }
        else { el.classList.remove('is-invalid'); el.classList.add('is-valid'); if (errEl) errEl.innerHTML = ''; }
    }
    function validateAddField(id) {
        var el = document.getElementById(id); if (!el) return true; var val = el.value.trim();
        var today = new Date(); today.setHours(23, 59, 59, 999);
        switch (id) {
            case 'addCategory': if (!val) { setFieldState(id, 'Please select a category'); return false; } break;
            case 'addDate': { if (!val) { setFieldState(id, 'Date is required'); return false; } var picked = new Date(val); if (isNaN(picked.getTime())) { setFieldState(id, 'Invalid date'); return false; } if (picked > today) { setFieldState(id, 'Date cannot be in the future'); return false; } break; }
            case 'addStock': if (!val) { setFieldState(id, 'Stock number is required'); return false; } if (!/^\d{2}-\d{3}$/.test(val)) { setFieldState(id, 'Must be in format 00-000'); return false; } break;
            case 'addUnit': if (!val) { setFieldState(id, 'Unit is required'); return false; } break;
            case 'addName': if (!val) { setFieldState(id, 'Name is required'); return false; } if (val.length < 2) { setFieldState(id, 'Minimum 2 characters'); return false; } break;
            case 'addQty': { var raw = el.value; if (raw === '' || raw === null) { setFieldState(id, 'Quantity is required'); return false; } var qn = Number(raw); if (!Number.isInteger(qn) || qn < 0) { setFieldState(id, 'Must be a whole number ≥ 0'); return false; } if (qn > 99999) { setFieldState(id, 'Maximum quantity is 99,999'); return false; } break; }
            case 'addUsed': { var rawU = el.value; var un = Number(rawU || 0); var qnU = Number(document.getElementById('addQty').value || 0); if (rawU !== '' && (!Number.isInteger(un) || un < 0)) { setFieldState(id, 'Must be a whole number ≥ 0'); return false; } if (un > qnU) { setFieldState(id, 'Consumed cannot exceed quantity'); return false; } break; }
        }
        setFieldState(id, ''); return true;
    }
    function validateAllAddFields() { return ['addCategory', 'addDate', 'addStock', 'addUnit', 'addName', 'addQty', 'addUsed'].map(function (id) { return validateAddField(id); }).every(Boolean); }
    function resetAddForm() {
        document.getElementById('addCategory').value = '';
        ['addDate', 'addStock', 'addName', 'addUnit', 'addQty', 'addUsed', 'addBalance'].forEach(function (id) { document.getElementById(id).value = ''; });
        ['addCategory', 'addDate', 'addStock', 'addUnit', 'addName', 'addQty', 'addUsed'].forEach(function (id) { var el = document.getElementById(id); if (el) el.classList.remove('is-invalid', 'is-valid'); var err = document.getElementById('err-' + id); if (err) err.innerHTML = ''; });
        var counter = document.getElementById('charCounter-addName'); if (counter) { counter.textContent = '0 / 100'; counter.className = 'char-counter'; }
    }

    async function addItem() {
        if (!validateAllAddFields()) { var fi = document.querySelector('#addModal .is-invalid'); if (fi) fi.scrollIntoView({ behavior: 'smooth', block: 'center' }); return; }
        var btnSave = document.getElementById('btnSaveAdd'); btnSave.disabled = true; btnSave.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving…';
        var res = await fetch('/dentist/inventory', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' }, body: JSON.stringify({ category: document.getElementById('addCategory').value, date_received: document.getElementById('addDate').value, stock_no: document.getElementById('addStock').value.trim(), name: document.getElementById('addName').value.trim(), unit: document.getElementById('addUnit').value.trim(), qty: Number(document.getElementById('addQty').value), used: Number(document.getElementById('addUsed').value || 0) }) });
        btnSave.disabled = false; btnSave.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Save Item';
        if (!res.ok) { var err = await res.json().catch(function () { return {}; }); if (err.errors) { var map = { category: 'addCategory', date_received: 'addDate', stock_no: 'addStock', name: 'addName', unit: 'addUnit', qty: 'addQty', used: 'addUsed' }; Object.entries(err.errors).forEach(function ([k, v]) { if (map[k]) setFieldState(map[k], Array.isArray(v) ? v[0] : v); }); } else { showToast('error', 'Could not save item. Please try again.'); } return; }
        document.getElementById('addModal').close(); resetAddForm(); await loadInventory(); showToast('success', 'Item added successfully!');
    }

    var deleteId = null;
    function deleteItem(id) { deleteId = id; document.getElementById('deleteModal').showModal(); }
    document.getElementById('confirmDeleteBtn').onclick = async function () {
        if (!deleteId) return;
        await fetch('/dentist/inventory/' + deleteId, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') } });
        document.getElementById('deleteModal').close(); deleteId = null; await loadInventory(); showToast('success', 'Item deleted.');
    };

    var editId = null;
    function openEdit(id) {
        editId = id; var i = inventory.find(function (item) { return item.id === id; }); if (!i) return;
        document.getElementById('editCategory').value = i.category; document.getElementById('editStock').value = i.stock_no;
        document.getElementById('editName').value = i.name; document.getElementById('editUnit').value = i.unit;
        document.getElementById('editQty').value = i.qty; document.getElementById('editUsed').value = i.used;
        document.getElementById('editDate').value = i.date_received ? i.date_received.slice(0, 10) : '';
        computeEditBalance(); document.getElementById('editModal').showModal();
    }
    async function saveEdit() {
        if (!editId) return;
        var res = await fetch('/dentist/inventory/' + editId, { method: 'PUT', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }, body: JSON.stringify({ category: document.getElementById('editCategory').value, date_received: document.getElementById('editDate').value, stock_no: document.getElementById('editStock').value, name: document.getElementById('editName').value, unit: document.getElementById('editUnit').value, qty: Number(document.getElementById('editQty').value), used: Number(document.getElementById('editUsed').value) }) });
        if (!res.ok) { showToast('error', 'Edit failed — please try again.'); return; }
        document.getElementById('editModal').close(); editId = null; await loadInventory(); showToast('success', 'Item updated successfully!');
    }

    function computeAddBalance() { document.getElementById('addBalance').value = Number(document.getElementById('addQty').value || 0) - Number(document.getElementById('addUsed').value || 0); }
    function computeEditBalance() { document.getElementById('editBalance').value = Number(document.getElementById('editQty').value || 0) - Number(document.getElementById('editUsed').value || 0); }
</script>
@endsection