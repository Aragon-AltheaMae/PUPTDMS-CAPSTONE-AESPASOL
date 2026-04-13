@extends('layouts.admin')

@section('title', 'User Management | PUP Taguig Dental Clinic')

@section('body-class', 'bg-[#f4f5f7]')

@section('styles')

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
        /* Page Banner */
        .page-banner {
            background: linear-gradient(135deg, #6b0000 0%, #8B0000 60%, #c0392b 100%);
            padding: 1.75rem 2rem 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(139, 0, 0, .25);
            border-radius: 16px;
            margin-bottom: 1.5rem;
        }

        .page-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .page-banner-inner {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 900;
            color: #fff;
            line-height: 1.1;
            letter-spacing: -.02em;
        }

        .page-subtitle {
            font-size: .8rem;
            color: rgba(255, 255, 255, .7);
            margin-top: .35rem;
        }

        .page-banner-date {
            display: flex;
            align-items: center;
            gap: .45rem;
            font-size: .78rem;
            color: rgba(255, 255, 255, .82);
            margin-bottom: .35rem;
        }

        .page-banner-date i {
            color: #fff;
            font-size: .75rem;
        }

        .um-view-toggle {
            display: inline-flex;
            align-items: center;
            background: #FAFAF9;
            border: 1.5px solid #E0DDD8;
            border-radius: 12px;
            padding: 3px;
            gap: 3px;
            height: 42px;
        }

        .um-view-toggle-btn {
            width: 34px;
            height: 34px;
            padding: 0;
            border: none;
            background: transparent;
            color: #6b7280;
            border-radius: 9px;
            font-size: .82rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .15s ease;
            flex-shrink: 0;
        }

        .um-view-toggle-btn:hover {
            background: #f3f4f6;
            color: #8B0000;
        }

        .um-view-toggle-btn.active {
            background: #8B0000;
            color: #fff;
            box-shadow: 0 2px 8px rgba(139, 0, 0, .15);
        }

        .um-view[hidden] {
            display: none !important;
        }

        .um-grid-wrap {
            padding: 1rem;
        }

        .um-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .um-grid-card {
            background: #fff;
            border: 1px solid #f0eaea;
            border-radius: 16px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: .85rem;
            transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
            min-width: 0;
        }

        .um-grid-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, .06);
            border-color: #ead6d6;
        }

        .um-grid-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: .75rem;
        }

        .um-grid-number {
            font-size: .72rem;
            font-weight: 800;
            color: #8B0000;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }

        .um-grid-meta {
            display: grid;
            gap: .65rem;
        }

        .um-grid-field {
            min-width: 0;
        }

        .um-grid-label {
            font-size: .64rem;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: .28rem;
        }

        .um-grid-value {
            font-size: .8rem;
            color: #374151;
            line-height: 1.35;
            min-width: 0;
            word-break: break-word;
        }

        @media (max-width: 767px) {
            .page-banner {
                border-radius: 14px;
                padding: 1.1rem 1.1rem 1.4rem;
            }

            .page-title {
                font-size: 1.45rem;
            }

            .page-banner-inner {
                flex-direction: column;
                gap: .75rem;
            }
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

        [data-theme="dark"] .bg-white {
            background-color: #161b22 !important;
        }

        [data-theme="dark"] .text-\[\#333333\] {
            color: #E5E7EB !important;
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

        .search-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #FAFAF9;
            border: 1.5px solid #E0DDD8;
            border-radius: 12px;
            padding: 0 14px;
            height: 38px;
            transition: border-color .2s, box-shadow .2s;
            min-width: 0;
            flex-shrink: 1;
        }

        .search-wrap:focus-within {
            border-color: var(--crimson);
            box-shadow: 0 0 0 3px rgba(139, 0, 0, .1);
        }

        .search-wrap i {
            color: var(--crimson);
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

        .tab-btn {
            padding: 6px 14px;
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
            background: var(--crimson);
            color: #fff;
            box-shadow: 0 2px 8px rgba(139, 0, 0, .3);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.4s ease-out forwards;
        }

        #toastContainer {
            position: fixed !important;
            top: 80px !important;
            right: 16px !important;
            z-index: 99999 !important;
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: flex-end;
            pointer-events: none;
            width: 340px;
        }

        @media (max-width: 640px) {
            #toastContainer {
                top: 80px !important;
                right: 10px !important;
                left: 10px !important;
                width: auto !important;
                align-items: stretch;
            }

            #toastContainer>div {
                max-width: 100% !important;
                width: 100% !important;
            }
        }

        /* ── MOBILE RESPONSIVE ── */
        @media (max-width: 767px) {
            #mainContent {
                padding-bottom: 2rem !important;
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

            .user-table-row td {
                padding-top: 0.65rem;
                padding-bottom: 0.65rem;
            }

            .action-btn {
                padding: 5px 6px;
            }

            #umListView {
                display: none !important;
            }

            #umGridView {
                display: block !important;
            }

            #umViewToggle {
                display: none !important;
            }

            .um-grid {
                grid-template-columns: 1fr;
            }

            .um-grid-wrap {
                padding: .85rem;
            }
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

        .stat-card {
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .1);
        }

        .user-table-row {
            transition: background .15s;
        }

        .user-table-row:hover {
            background: #fef9f9;
        }

        .badge-role {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 99px;
        }

        .badge-active {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-inactive {
            background: #f3f4f6;
            color: #6b7280;
        }

        .action-btn {
            padding: 6px 8px;
            border-radius: 7px;
            border: none;
            cursor: pointer;
            font-size: 12px;
            transition: all .15s;
        }

        .action-btn:hover {
            transform: scale(1.08);
        }

        .btn-edit {
            background: #eff6ff;
            color: #2563eb;
        }

        .btn-edit:hover {
            background: #dbeafe;
        }

        .btn-toggle-on {
            background: #fef3c7;
            color: #b45309;
        }

        .btn-toggle-on:hover {
            background: #fde68a;
        }

        .btn-toggle-off {
            background: #d1fae5;
            color: #065f46;
        }

        .btn-toggle-off:hover {
            background: #a7f3d0;
        }

        .btn-reset {
            background: #f3e8ff;
            color: #7c3aed;
        }

        .btn-reset:hover {
            background: #ede9fe;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 200;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s;
        }

        .modal-overlay.open {
            display: flex;
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
            box-shadow: 0 24px 60px rgba(0, 0, 0, .18);
        }

        .modal-overlay.open .modal-box {
            transform: scale(1) translateY(0);
        }

        .modal-sm {
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

        .page-btn:disabled {
            opacity: .4;
            cursor: not-allowed;
            pointer-events: none;
        }

        .flash-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: .75rem 1rem;
            border-radius: 12px;
            font-size: .82rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
        }

        [data-theme="dark"] .text-gray-800 {
            color: #e5e7eb !important;
        }

        [data-theme="dark"] .text-gray-500 {
            color: #9ca3af !important;
        }

        [data-theme="dark"] .border-gray-100 {
            border-color: #21262d !important;
        }

        [data-theme="dark"] .bg-gray-50 {
            background-color: #0d1117 !important;
        }

        [data-theme="dark"] .bg-\[\#f5f5f5\] {
            background-color: #000D1A !important;
        }

        [data-theme="dark"] .user-table-row:hover {
            background: #0d1117;
        }

        [data-theme="dark"] .modal-box {
            background: #161b22;
        }

        [data-theme="dark"] .modal-box input,
        [data-theme="dark"] .modal-box select {
            background: #0d1117 !important;
            border-color: #21262d !important;
            color: #e5e7eb !important;
        }

        [data-theme="dark"] table thead tr {
            background: #0d1117 !important;
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

        [data-theme="dark"] .border-gray-200 {
            border-color: #21262d !important;
        }

        [data-theme="dark"] .bg-gray-100 {
            background-color: #21262d !important;
        }
    </style>
@endsection

@section('content')

    <!-- ════════════ MAIN CONTENT ════════════ -->
    @php
        $logs = $logs ?? collect([]);
        $totalCount = $logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->total() : $logs->count();
        $adminCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() : $logs)
            ->where('actor_role', 'admin')
            ->count();
        $dentistCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() : $logs)
            ->where('actor_role', 'dentist')
            ->count();
        $patientCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() : $logs)
            ->where('actor_role', 'patient')
            ->count();
        $loginCount = ($logs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $logs->getCollection() : $logs)
            ->whereIn('action', ['login', 'Login'])
            ->count();
    @endphp

    <main id="mainContent" class="px-4 sm:px-6 pt-[82px] pb-8 min-h-screen">
        <div style="max-width:1280px; margin:0 auto;">

            <div class="page-banner">
                    <div class="page-banner-inner">
                    <div>
                        <h1 class="page-title">User Management</h1>
                    </div>

                    <div class="flex items-center gap-3 flex-wrap w-full sm:w-auto">
                        <button
                            onclick="openModal('addModal')"
                            class="flex items-center justify-center gap-2 bg-white hover:bg-gray-100 text-[#8B0000] 
                            px-5 py-2.5 rounded-lg font-semibold text-sm shadow transition-all w-full sm:w-auto">
                            <i class="fa-solid fa-user-plus"></i>
                            Add New User
                        </button>

                        <div class="um-view-toggle" id="umViewToggle">
                            <button type="button"
                                class="um-view-toggle-btn active"
                                id="umListViewBtn"
                                title="List view"
                                aria-label="List view">
                                <i class="fa-solid fa-table-list"></i>
                            </button>
                            <button type="button"
                                class="um-view-toggle-btn"
                                id="umGridViewBtn"
                                title="Grid view"
                                aria-label="Grid view">
                                <i class="fa-solid fa-grip"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showSuccessToast("{{ session('success') }}");
                    });
                </script>
            @endif

            @if (session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showErrorToast("{{ session('error') }}");
                    });
                </script>
            @endif

            @php
                $totalUsers = $allUsersCount;
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                <div class="stat-card bg-white rounded-xl p-4 shadow border border-gray-100 overflow-hidden relative">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-[#8B0000]/5 to-transparent rounded-full -mr-10 -mt-10">
                    </div>
                    <div class="relative">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#6B0000] flex items-center justify-center shadow mb-3">
                            <i class="fa-solid fa-users text-white text-sm"></i>
                        </div>
                        <p class="text-[10px] uppercase tracking-wide text-gray-500 font-semibold">Total Users</p>
                        <p class="text-3xl font-extrabold text-gray-800" id="countTotalUsers">{{ $totalUsers }}</p>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-xl p-4 shadow border border-gray-100 overflow-hidden relative">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-green-500/5 to-transparent rounded-full -mr-10 -mt-10">
                    </div>
                    <div class="relative">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow mb-3">
                            <i class="fa-solid fa-circle-check text-white text-sm"></i>
                        </div>
                        <p class="text-[10px] uppercase tracking-wide text-gray-500 font-semibold">Active</p>
                        <p class="text-3xl font-extrabold text-gray-800" id="countActiveUsers">{{ $activeCount }}</p>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-xl p-4 shadow border border-gray-100 overflow-hidden relative">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-gray-400/5 to-transparent rounded-full -mr-10 -mt-10">
                    </div>
                    <div class="relative">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center shadow mb-3">
                            <i class="fa-solid fa-user-slash text-white text-sm"></i>
                        </div>
                        <p class="text-[10px] uppercase tracking-wide text-gray-500 font-semibold">Inactive</p>
                        <p class="text-3xl font-extrabold text-gray-800" id="countInactiveUsers">{{ $inactiveCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden mb-6">
                <div class="px-4 sm:px-5 py-4 border-b bg-gray-50 flex flex-col gap-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-users-gear text-[#8B0000]"></i>
                        <h2 class="font-bold text-gray-800 text-sm">All System Users</h2>
                        <span id="countBadgeUsers"
                            class="text-[10px] font-bold bg-[#8B0000] text-white px-2 py-0.5 rounded-full">{{ $totalUsers }}</span>
                    </div>

                    {{-- Filter bar --}}
                    <form method="GET" action="{{ route('admin.user_management') }}" id="umFilterForm"
                        class="flex items-center gap-2.5 flex-wrap">
                        {{-- Search --}}
                        <div class="search-wrap" style="width:260px;">
                            <i class="fa fa-search" style="color:#8B0000;font-size:13px;flex-shrink:0;"></i>
                            <input id="umSearch" name="search" placeholder="Search name or email…"
                                value="{{ $search ?? '' }}" autocomplete="off" oninput="toggleSearchClear(this)"
                                onkeydown="if(event.key==='Enter'){event.preventDefault();}" />
                            <button type="button" id="searchClearBtn"
                                class="search-clear-btn {{ $search ?? '' ? 'visible' : '' }}" onclick="clearSearch()"
                                title="Clear">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        {{-- Role filter --}}
                        <div
                            style="display:flex;background:#F5F2EE;border:1px solid #E8E4DE;border-radius:10px;padding:3px;gap:2px;">
                            <button type="button" onclick="setRoleFilter(this,'all')"
                                class="tab-btn {{ ($roleFilter ?? '') === '' ? 'active' : '' }}"
                                data-role="">All</button>
                            <button type="button" onclick="setRoleFilter(this,'super_admin')"
                                class="tab-btn {{ ($roleFilter ?? '') === 'super_admin' ? 'active' : '' }}"
                                data-role="super_admin">Admin</button>
                            <button type="button" onclick="setRoleFilter(this,'dentist')"
                                class="tab-btn {{ ($roleFilter ?? '') === 'dentist' ? 'active' : '' }}"
                                data-role="dentist">Dentist</button>
                            <button type="button" onclick="setRoleFilter(this,'patient')"
                                class="tab-btn {{ ($roleFilter ?? '') === 'patient' ? 'active' : '' }}"
                                data-role="patient">Patient</button>
                        </div>

                        {{-- Status filter --}}
                        <select id="statusFilter" name="status"
                            class="field-input text-xs border border-gray-200 rounded-lg px-3 py-2 bg-white text-gray-600 cursor-pointer">
                            <option value="">All Status</option>
                            <option value="active" {{ ($statusFilter ?? '') === 'active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="inactive" {{ ($statusFilter ?? '') === 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </form>
                </div>

                <div class="um-view" id="umListView">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr class="text-[10px] uppercase tracking-wide text-[#8B0000] font-bold">
                                    <th class="py-3 px-3 sm:px-5 text-left w-12 hidden sm:table-cell">#</th>
                                    <th class="py-3 px-4 text-left">User</th>
                                    <th class="py-3 px-4 text-left">Role</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                    <th class="py-3 px-4 text-left hidden lg:table-cell">Registered</th>
                                    <th class="py-3 px-5 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="umTableBody">
                                @forelse($users as $user)
                                    <tr class="user-table-row border-b border-gray-50 last:border-0"
                                        data-name="{{ strtolower($user->name) }}"
                                        data-email="{{ strtolower($user->email) }}"
                                        data-role="{{ strtolower(optional($user->role)->name ?? '') }}">
                                        <td class="py-3.5 px-3 sm:px-5 hidden sm:table-cell">
                                            <span
                                                class="text-xs text-gray-400 font-medium">{{ $users->firstItem() + $loop->index }}</span>
                                        </td>

                                        <td class="py-3.5 px-3 sm:px-4">
                                            <div class="flex items-center gap-2 sm:gap-3">
                                                <div
                                                    class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#b00000] flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-800 text-sm leading-tight">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-[11px] text-gray-400 mt-0.5 hidden sm:block">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-3.5 px-4">
                                            @php $roleSlug = optional($user->role)->slug; @endphp
                                            <span class="badge-role"
                                                style="background:
                {{ $roleSlug === 'patient' ? '#dbeafe' : ($roleSlug === 'dentist' ? '#d1fae5' : '#fee2e2') }};
                color:
                {{ $roleSlug === 'patient' ? '#1d4ed8' : ($roleSlug === 'dentist' ? '#065f46' : '#8B0000') }};">
                                                {{ optional($user->role)->name ?? 'No Role' }}
                                            </span>
                                        </td>

                                        <td class="py-3.5 px-4 text-center">
                                            <span
                                                class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $user->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>

                                        <td class="py-3.5 px-4 hidden lg:table-cell">
                                            <span
                                                class="text-xs text-gray-400">{{ $user->created_at->format('M d, Y') }}</span>
                                        </td>

                                        <td class="py-3.5 px-2 sm:px-5">
                                            <div class="flex items-center justify-center gap-1">
                                                <button type="button"
                                                    onclick="openEditModal(
                                                    'users',
                                                    {{ $user->id }},
                                                    @js($user->name),
                                                    @js($user->email),
                                                    @js($user->role_id),
                                                    @js($user->status)
                                                  )"
                                                    class="action-btn btn-edit" title="Edit account">
                                                    <i class="fa-solid fa-pen text-[11px]"></i>
                                                </button>

                                                <button type="button"
                                                    onclick="openToggleConfirm({{ $user->id }}, @js($user->status), @js($user->name))"
                                                    class="action-btn {{ $user->status === 'active' ? 'btn-toggle-on' : 'btn-toggle-off' }}"
                                                    title="{{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                                    <i
                                                        class="fa-solid {{ $user->status === 'active' ? 'fa-toggle-on' : 'fa-toggle-off' }} text-[11px]"></i>
                                                </button>

                                                <button type="button"
                                                    onclick="openResetModal('users', {{ $user->id }}, @js($user->name))"
                                                    class="action-btn btn-reset" title="Reset password">
                                                    <i class="fa-solid fa-key text-[11px]"></i>
                                                </button>

                                                <button type="button"
                                                    onclick="openViewModal(
                                                    @js($user->name),
                                                    @js($user->email),
                                                    @js(optional($user->role)->name ?? 'No Role'),
                                                    @js(ucfirst($user->status)),
                                                    'Users',
                                                    @js($user->created_at ? $user->created_at->format('M d, Y h:i A') : 'N/A')
                                                  )"
                                                    class="action-btn" style="background:#f3f4f6;color:#374151;"
                                                    title="View details">
                                                    <i class="fa-solid fa-eye text-[11px]"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="dbEmptyRow">
                                        <td colspan="6" style="padding:3.5rem 1rem;text-align:center;">
                                            <div
                                                style="display:inline-flex;align-items:center;justify-content:center;width:64px;height:64px;background:#f3f4f6;border-radius:18px;margin-bottom:1rem;">
                                                <i class="fa-solid fa-magnifying-glass"
                                                    style="font-size:1.6rem;color:#d1d5db;"></i>
                                            </div>
                                            <p style="font-size:.9rem;font-weight:700;color:#374151;margin:0 0 .3rem;">No users
                                                found</p>
                                            <p style="font-size:.78rem;color:#9ca3af;margin:0;">Try adjusting your filters.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="um-view" id="umGridView" hidden>
                    <div class="um-grid-wrap">
                        <div class="um-grid" id="umGridBody">
                            @forelse($users as $user)
                                @php
                                    $roleSlug = optional($user->role)->slug;
                                    $roleName = optional($user->role)->name ?? 'No Role';
                                    $roleBg = $roleSlug === 'patient' ? '#dbeafe' : ($roleSlug === 'dentist' ? '#d1fae5' : '#fee2e2');
                                    $roleColor = $roleSlug === 'patient' ? '#1d4ed8' : ($roleSlug === 'dentist' ? '#065f46' : '#8B0000');
                                @endphp

                                <div class="um-grid-card">
                                    <div class="um-grid-top">
                                        <div class="um-grid-number">#{{ $users->firstItem() + $loop->index }}</div>
                                        <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $user->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#b00000] flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-semibold text-gray-800 text-sm leading-tight">
                                                {{ $user->name }}
                                            </div>
                                            <div class="text-[11px] text-gray-400 mt-0.5">
                                                {{ $user->email }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="um-grid-meta">
                                        <div class="um-grid-field">
                                            <div class="um-grid-label">Role</div>
                                            <div class="um-grid-value">
                                                <span class="badge-role" style="background:{{ $roleBg }};color:{{ $roleColor }};">
                                                    {{ $roleName }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="um-grid-field">
                                            <div class="um-grid-label">Registered</div>
                                            <div class="um-grid-value">{{ $user->created_at->format('M d, Y') }}</div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-end gap-1 flex-wrap">
                                        <button type="button"
                                            onclick="openEditModal(
                                                'users',
                                                {{ $user->id }},
                                                @js($user->name),
                                                @js($user->email),
                                                @js($user->role_id),
                                                @js($user->status)
                                            )"
                                            class="action-btn btn-edit" title="Edit account">
                                            <i class="fa-solid fa-pen text-[11px]"></i>
                                        </button>

                                        <button type="button"
                                            onclick="openToggleConfirm({{ $user->id }}, @js($user->status), @js($user->name))"
                                            class="action-btn {{ $user->status === 'active' ? 'btn-toggle-on' : 'btn-toggle-off' }}"
                                            title="{{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                            <i class="fa-solid {{ $user->status === 'active' ? 'fa-toggle-on' : 'fa-toggle-off' }} text-[11px]"></i>
                                        </button>

                                        <button type="button"
                                            onclick="openResetModal('users', {{ $user->id }}, @js($user->name))"
                                            class="action-btn btn-reset" title="Reset password">
                                            <i class="fa-solid fa-key text-[11px]"></i>
                                        </button>

                                        <button type="button"
                                            onclick="openViewModal(
                                                @js($user->name),
                                                @js($user->email),
                                                @js($roleName),
                                                @js(ucfirst($user->status)),
                                                'Users',
                                                @js($user->created_at ? $user->created_at->format('M d, Y h:i A') : 'N/A')
                                            )"
                                            class="action-btn" style="background:#f3f4f6;color:#374151;"
                                            title="View details">
                                            <i class="fa-solid fa-eye text-[11px]"></i>
                                        </button>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
                
                <div
                    class="px-4 sm:px-5 py-4 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-xs text-gray-500 um-pagebar-info">
                        Showing
                        <strong>{{ $users->firstItem() ?? 0 }}</strong>–<strong>{{ $users->lastItem() ?? 0 }}</strong>
                        of <strong>{{ $users->total() }}</strong> users
                    </p>
                    <div class="um-pagination-wrap flex items-center gap-1.5"></div>
                </div>
            </div>
        </div>
    </main>

    <!-- Global Toast Container -->
    <div id="toastContainer"
        style="position:fixed;top:16px;right:16px;z-index:99999;display:flex;flex-direction:column;gap:8px;align-items:flex-end;pointer-events:none;width:340px;">
    </div>

    <div class="modal-overlay" id="addModal" onclick="closeModalOutside(event,'addModal')">
        <div class="modal-box">
            <div
                class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#6B0000] flex items-center justify-center shadow">
                        <i class="fa-solid fa-user-plus text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-gray-800 text-base">Add New User</h3>
                        <p class="text-[10px] text-gray-500">Fill in the user's details below</p>
                    </div>
                </div>
                <button onclick="closeModal('addModal')"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.user_management.store') }}" class="p-6 space-y-4">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-xs text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-center gap-1.5"><i class="fa-solid fa-circle-xmark"></i>
                                {{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Full Name
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Juan dela Cruz"
                        class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm" required>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Email
                        Address <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="user@pup.edu.ph"
                            class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm" required>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Role</label>
                    <select name="role_id"
                        class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white">
                        <option value="">— No Role —</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Status
                        <span class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="active"
                                {{ old('status', 'active') === 'active' ? 'checked' : '' }}
                                style="accent-color:#8B0000;">
                            <span class="text-sm text-gray-700 font-medium">Active</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="inactive"
                                {{ old('status') === 'inactive' ? 'checked' : '' }}
                                style="accent-color:#8B0000;">
                            <span class="text-sm text-gray-700 font-medium">Inactive</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Password
                        <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="password" name="password" id="addPassword" placeholder="Min. 8 characters"
                            class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-10 py-2.5 text-sm"
                            required>
                        <button type="button" onclick="togglePassVis('addPassword','addEye')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fa-regular fa-eye text-xs" id="addEye"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Confirm
                        Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="password" name="password_confirmation" id="addPasswordConf"
                            placeholder="Repeat password"
                            class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-10 py-2.5 text-sm"
                            required>
                        <button type="button" onclick="togglePassVis('addPasswordConf','addEye2')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fa-regular fa-eye text-xs" id="addEye2"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('addModal')"
                        class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-[#8B0000] hover:bg-[#760000] text-white text-sm font-bold shadow transition-all flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Save User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="editModal" onclick="closeModalOutside(event,'editModal')">
        <div class="modal-box">
            <div
                class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow">
                        <i class="fa-solid fa-user-pen text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-gray-800 text-base">Edit User</h3>
                        <p class="text-[10px] text-gray-500" id="editModalSubtitle">Updating user details</p>
                    </div>
                </div>
                <button onclick="closeModal('editModal')"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form method="POST" id="editForm" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Full Name
                        <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="editName" placeholder="Full name"
                        class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm" required>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Email
                        Address <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="email" name="email" id="editEmail" placeholder="user@pup.edu.ph"
                            class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm" required>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Role</label>
                    <select name="role_id" id="editRole"
                        class="field-input w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white">
                        <option value="">— No Role —</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Status
                        <span class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" id="editStatusActive" value="active"
                                style="accent-color:#8B0000;">
                            <span class="text-sm text-gray-700 font-medium">Active</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" id="editStatusInactive" value="inactive"
                                style="accent-color:#8B0000;">
                            <span class="text-sm text-gray-700 font-medium">Inactive</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('editModal')"
                        class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold shadow transition-all flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Update User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div class="modal-overlay" id="resetModal" onclick="closeModalOutside(event,'resetModal')">
        <div class="modal-box modal-sm">
            <div
                class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow">
                        <i class="fa-solid fa-key text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-gray-800 text-base">Reset Password</h3>
                        <p class="text-[10px] text-gray-500" id="resetModalSubtitle">Set a new password</p>
                    </div>
                </div>
                <button onclick="closeModal('resetModal')"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form method="POST" id="resetForm" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">New
                        Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="password" name="password" id="resetPassword" placeholder="Min. 8 characters"
                            class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-10 py-2.5 text-sm"
                            required>
                        <button type="button" onclick="togglePassVis('resetPassword','resetEye')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fa-regular fa-eye text-xs" id="resetEye"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase tracking-wide mb-1.5">Confirm
                        Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="password" name="password_confirmation" id="resetPasswordConf"
                            placeholder="Repeat password"
                            class="field-input w-full border border-gray-200 rounded-lg pl-9 pr-10 py-2.5 text-sm"
                            required>
                        <button type="button" onclick="togglePassVis('resetPasswordConf','resetEye2')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fa-regular fa-eye text-xs" id="resetEye2"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('resetModal')"
                        class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold shadow transition-all flex items-center gap-2">
                        <i class="fa-solid fa-key"></i> Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Details Modal -->
    <div class="modal-overlay" id="viewModal" onclick="closeModalOutside(event,'viewModal')">
        <div class="modal-box modal-sm">
            <div
                class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center shadow">
                        <i class="fa-solid fa-eye text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-gray-800 text-base">Account Details</h3>
                        <p class="text-[10px] text-gray-500">View selected account information</p>
                    </div>
                </div>
                <button onclick="closeModal('viewModal')"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="p-6 space-y-4 text-sm">
                <div>
                    <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Name</div>
                    <div id="viewName" class="text-gray-800 font-semibold mt-1"></div>
                </div>

                <div>
                    <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Email</div>
                    <div id="viewEmail" class="text-gray-800 mt-1"></div>
                </div>

                <div>
                    <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Role</div>
                    <div id="viewRole" class="text-gray-800 mt-1"></div>
                </div>

                <div>
                    <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Status</div>
                    <div id="viewStatus" class="text-gray-800 mt-1"></div>
                </div>

                <div>
                    <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Source</div>
                    <div id="viewSource" class="text-gray-800 mt-1"></div>
                </div>

                <div>
                    <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Created At</div>
                    <div id="viewCreatedAt" class="text-gray-800 mt-1"></div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="button" onclick="closeModal('viewModal')"
                        class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toggle Status Confirmation Modal -->
    <div class="modal-overlay" id="toggleConfirmModal" onclick="closeModalOutside(event,'toggleConfirmModal')">
        <div class="modal-box modal-sm">
            <div
                class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white rounded-t-2xl z-10">
                <div class="flex items-center gap-3">
                    <div id="toggleModalIcon" class="w-10 h-10 rounded-xl flex items-center justify-center shadow">
                    </div>
                    <div>
                        <h3 class="font-extrabold text-gray-800 text-base" id="toggleModalTitle">Confirm Action</h3>
                        <p class="text-[10px] text-gray-500" id="toggleModalSubtitle">Please confirm this change</p>
                    </div>
                </div>
                <button onclick="closeModal('toggleConfirmModal')"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-[#8B0000] transition-all">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="p-6">
                <div id="toggleModalBody" class="rounded-xl p-4 mb-5 flex items-start gap-3 text-sm"></div>

                <div class="flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('toggleConfirmModal')"
                        class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                        Cancel
                    </button>
                    <form id="toggleConfirmForm" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" id="toggleConfirmBtn"
                            class="px-6 py-2.5 rounded-lg text-white text-sm font-bold shadow transition-all flex items-center gap-2">
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const currentDateEl = document.getElementById('currentDate');
            if (currentDateEl) {
                currentDateEl.textContent = new Date().toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }

        var umState = {
            search: '{{ $search ?? '' }}',
            role: '{{ $roleFilter ?? '' }}',
            status: '{{ $statusFilter ?? '' }}',
            perPage: {{ $perPage ?? 10 }},
            page: {{ request('page', 1) }},
        };

        var umSearchTimer = null;
        var umController = null;

        function getPreferredUmView() {
            if (window.innerWidth <= 767) return 'grid';
            return localStorage.getItem('userManagementView') || 'list';
        }

        function applyUmView(view, save = true) {
            var listView = document.getElementById('umListView');
            var gridView = document.getElementById('umGridView');
            var listBtn = document.getElementById('umListViewBtn');
            var gridBtn = document.getElementById('umGridViewBtn');

            if (!listView || !gridView) return;

            var finalView = window.innerWidth <= 767 ? 'grid' : view;

            if (finalView === 'grid') {
                listView.hidden = true;
                gridView.hidden = false;
            } else {
                listView.hidden = false;
                gridView.hidden = true;
            }

            if (listBtn) listBtn.classList.toggle('active', finalView === 'list');
            if (gridBtn) gridBtn.classList.toggle('active', finalView === 'grid');

            if (save && window.innerWidth > 767) {
                localStorage.setItem('userManagementView', finalView);
            }
        }

        function initUmViewToggle() {
            var listBtn = document.getElementById('umListViewBtn');
            var gridBtn = document.getElementById('umGridViewBtn');

            applyUmView(getPreferredUmView(), false);

            if (listBtn && !listBtn.dataset.bound) {
                listBtn.dataset.bound = '1';
                listBtn.addEventListener('click', function() {
                    applyUmView('list', true);
                });
            }

            if (gridBtn && !gridBtn.dataset.bound) {
                gridBtn.dataset.bound = '1';
                gridBtn.addEventListener('click', function() {
                    applyUmView('grid', true);
                });
            }
        }

        function closeAllModals() {
            document.querySelectorAll('.modal-overlay').forEach(function(modal) {
                modal.classList.remove('open');
                modal.style.display = 'none';
            });
            document.body.style.overflow = '';
        }

        function openModal(id) {
            closeAllModals();

            var modal = document.getElementById(id);
            if (!modal) return;

            modal.style.display = 'flex';

            requestAnimationFrame(function() {
                modal.classList.add('open');
            });

            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            var modal = document.getElementById(id);
            if (!modal) return;

            modal.classList.remove('open');

            setTimeout(function() {
                modal.style.display = 'none';
            }, 200);

            document.body.style.overflow = '';
        }

        function closeModalOutside(e, id) {
            if (e.target.id === id) {
                closeModal(id);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            closeAllModals();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAllModals();
            }
        });

        @if ($errors->any() && old('_method') !== 'PUT')
            document.addEventListener('DOMContentLoaded', () => openModal('addModal'));
        @endif

        function openToggleConfirm(userId, currentStatus, userName) {
            var isActive = currentStatus === 'active';
            var icon = document.getElementById('toggleModalIcon');
            var title = document.getElementById('toggleModalTitle');
            var subtitle = document.getElementById('toggleModalSubtitle');
            var body = document.getElementById('toggleModalBody');
            var btn = document.getElementById('toggleConfirmBtn');
            var form = document.getElementById('toggleConfirmForm');

            form.dataset.userId = userId;
            form.dataset.currentStatus = currentStatus;
            form.dataset.userName = userName;
            form.action = '/admin/user-management/' + userId + '/toggle-status';

            btn.disabled = false;

            if (isActive) {
                icon.className =
                    'w-10 h-10 rounded-xl flex items-center justify-center shadow bg-gradient-to-br from-amber-400 to-orange-500';
                icon.innerHTML = '<i class="fa-solid fa-user-slash text-white text-sm"></i>';
                title.textContent = 'Deactivate User';
                subtitle.textContent = 'This will restrict their access';
                body.className = 'rounded-xl p-4 mb-5 flex items-start gap-3 text-sm bg-amber-50 border border-amber-100';
                body.innerHTML =
                    '<i class="fa-solid fa-triangle-exclamation text-amber-500 mt-0.5 flex-shrink-0"></i><div><strong class="text-amber-800">' +
                    userName +
                    '</strong><span class="text-amber-700"> will be <strong>deactivated</strong>. They will no longer be able to log in until reactivated.</span></div>';
                btn.className =
                    'px-6 py-2.5 rounded-lg text-white text-sm font-bold shadow transition-all flex items-center gap-2 bg-amber-500 hover:bg-amber-600';
                btn.innerHTML = '<i class="fa-solid fa-user-slash"></i> Yes, Deactivate';
            } else {
                icon.className =
                    'w-10 h-10 rounded-xl flex items-center justify-center shadow bg-gradient-to-br from-emerald-500 to-green-600';
                icon.innerHTML = '<i class="fa-solid fa-user-check text-white text-sm"></i>';
                title.textContent = 'Activate User';
                subtitle.textContent = 'This will restore their access';
                body.className =
                    'rounded-xl p-4 mb-5 flex items-start gap-3 text-sm bg-emerald-50 border border-emerald-100';
                body.innerHTML =
                    '<i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 flex-shrink-0"></i><div><strong class="text-emerald-800">' +
                    userName +
                    '</strong><span class="text-emerald-700"> will be <strong>activated</strong>. They will regain full access to the system.</span></div>';
                btn.className =
                    'px-6 py-2.5 rounded-lg text-white text-sm font-bold shadow transition-all flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700';
                btn.innerHTML = '<i class="fa-solid fa-user-check"></i> Yes, Activate';
            }

            btn.dataset.originalHtml = btn.innerHTML;

            openModal('toggleConfirmModal');
        }

        function openEditModal(source, id, name, email, roleId, status) {
            const form = document.getElementById('editForm');

            if (source === 'patients') {
                form.action = `/admin/user-management/patient/${id}`;
                document.getElementById('editRole').disabled = true;
                document.getElementById('editStatusActive').disabled = true;
                document.getElementById('editStatusInactive').disabled = true;
            } else {
                form.action = `/admin/user-management/${id}`;
                document.getElementById('editRole').disabled = false;
                document.getElementById('editStatusActive').disabled = false;
                document.getElementById('editStatusInactive').disabled = false;
            }

            // Store source for AJAX handler
            form.dataset.source = source;

            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('editModalSubtitle').textContent = 'Editing: ' + name;

            const roleSelect = document.getElementById('editRole');
            roleSelect.value = roleId || '';

            document.getElementById('editStatusActive').checked = (status === 'active');
            document.getElementById('editStatusInactive').checked = (status === 'inactive');

            openModal('editModal');
        }

        function openResetModal(source, id, name) {
            if (source === 'patients') {
                document.getElementById('resetForm').action = `/admin/user-management/patient/${id}/reset-password`;
            } else {
                document.getElementById('resetForm').action = `/admin/user-management/${id}/reset-password`;
            }

            document.getElementById('resetModalSubtitle').textContent = 'Resetting password for: ' + name;
            document.getElementById('resetPassword').value = '';
            document.getElementById('resetPasswordConf').value = '';
            openModal('resetModal');
        }

        function openViewModal(name, email, role, status, source, createdAt) {
            document.getElementById('viewName').textContent = name;
            document.getElementById('viewEmail').textContent = email;
            document.getElementById('viewRole').textContent = role;
            document.getElementById('viewStatus').textContent = status;
            document.getElementById('viewSource').textContent = source;
            document.getElementById('viewCreatedAt').textContent = createdAt;

            openModal('viewModal');
        }

        function togglePassVis(inputId, iconId) {
            const inp = document.getElementById(inputId);
            const ico = document.getElementById(iconId);
            if (inp.type === 'password') {
                inp.type = 'text';
                ico.className = 'fa-regular fa-eye-slash text-xs';
            } else {
                inp.type = 'password';
                ico.className = 'fa-regular fa-eye text-xs';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            applyTheme(localStorage.getItem('theme') || 'light');
            document.querySelectorAll('.theme-option').forEach(o =>
                o.addEventListener('click', e => {
                    e.stopPropagation();
                    applyTheme(o.getAttribute('data-theme'));
                })
            );

            document.querySelectorAll('.flash-alert').forEach(el => {
                setTimeout(() => {
                    el.style.transition = 'opacity .4s';
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 400);
                }, 4000);
            });
        });

        function toggleSearchClear(input) {
            document.getElementById('searchClearBtn')?.classList.toggle('visible', input.value.length > 0);
        }

        function clearSearch() {
            var input = document.getElementById('umSearch');
            if (!input) return;

            input.value = '';
            document.getElementById('searchClearBtn')?.classList.remove('visible');
            umState.search = '';
            umState.page = 1;
            umFetch();
            input.focus();
        }

        function umFetch(silent) {
            if (umController) umController.abort();
            umController = new AbortController();

            var params = new URLSearchParams({
                search: umState.search,
                role: umState.role,
                status: umState.status,
                per_page: umState.perPage,
                page: umState.page,
            });

            history.replaceState(null, '', window.location.pathname + '?' + params.toString());

            fetch('{{ route('admin.user_management') }}?' + params.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    signal: umController.signal
                })
                .then(function(res) {
                    return res.json();
                })
                .then(function(data) {
                    umRenderRows(data.users);
                    umRenderPagebar(data.pagination);
                    if (data.counts) {
                        umRenderCounts(data.counts);
                    }
                })
                .catch(function(e) {
                    if (e.name !== 'AbortError') console.error(e);
                });
        }

        function umRenderRows(users) {
            function jsAttr(value) {
                return JSON.stringify(value ?? '').replace(/"/g, '&quot;');
            }

            var tbody = document.getElementById('umTableBody');
            var gridBody = document.getElementById('umGridBody');

            if (!tbody || !gridBody) return;

            if (!users || users.length === 0) {
                var searchVal = umState.search || '';
                var emptyTitle = searchVal ?
                    'No results for &ldquo;' + searchVal + '&rdquo;' :
                    'No users found';
                var emptySub = searchVal ?
                    'Try a different name or email.' :
                    'Try adjusting your filters.';
                var clearBtn = searchVal ?
                    '<button onclick="clearSearch()" style="margin-top:.75rem;display:inline-flex;align-items:center;gap:.4rem;padding:.45rem 1rem;border-radius:99px;border:1.5px dashed #d1d5db;background:none;font-size:.78rem;color:#9ca3af;cursor:pointer;transition:all .2s;" onmouseover="this.style.borderColor=\'#8B0000\';this.style.color=\'#8B0000\';" onmouseout="this.style.borderColor=\'#d1d5db\';this.style.color=\'#9ca3af\';"><i class=\"fa-solid fa-xmark\" style=\"font-size:.7rem;\"></i> Clear search</button>' :
                    '';

                var emptyHtml = `
                    <div style="padding:3.5rem 1rem;text-align:center;grid-column:1 / -1;">
                        <div style="display:inline-flex;align-items:center;justify-content:center;width:64px;height:64px;background:#f3f4f6;border-radius:18px;margin-bottom:1rem;">
                            <i class="fa-solid fa-magnifying-glass" style="font-size:1.6rem;color:#d1d5db;"></i>
                        </div>
                        <p style="font-size:.9rem;font-weight:700;color:#374151;margin:0 0 .3rem;">${emptyTitle}</p>
                        <p style="font-size:.78rem;color:#9ca3af;margin:0;">${emptySub}</p>
                        ${clearBtn}
                    </div>
                `;

                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" style="padding:3.5rem 1rem;text-align:center;">
                            <div style="display:inline-flex;align-items:center;justify-content:center;width:64px;height:64px;background:#f3f4f6;border-radius:18px;margin-bottom:1rem;">
                                <i class="fa-solid fa-magnifying-glass" style="font-size:1.6rem;color:#d1d5db;"></i>
                            </div>
                            <p style="font-size:.9rem;font-weight:700;color:#374151;margin:0 0 .3rem;">${emptyTitle}</p>
                            <p style="font-size:.78rem;color:#9ca3af;margin:0;">${emptySub}</p>
                            ${clearBtn}
                        </td>
                    </tr>
                `;

                gridBody.innerHTML = emptyHtml;
                return;
            }

            var startNumber = ((umState.page - 1) * umState.perPage) + 1;
            var tableHtml = '';
            var gridHtml = '';

            users.forEach(function(user, index) {
                var rowNumber = startNumber + index;
                var roleSlug = (user.role_slug || '').toLowerCase();
                var roleLabel = user.role_name || 'No Role';
                var registeredDay = user.created_at_day || '—';

                var roleBg = '#fee2e2';
                var roleColor = '#8B0000';

                if (roleSlug === 'patient') {
                    roleBg = '#dbeafe';
                    roleColor = '#1d4ed8';
                } else if (roleSlug === 'dentist') {
                    roleBg = '#d1fae5';
                    roleColor = '#065f46';
                }

                var statusClass = user.status === 'active' ? 'badge-active' : 'badge-inactive';
                var initial = (user.name || 'U').charAt(0).toUpperCase();
                var statusLabel = (user.status || '').charAt(0).toUpperCase() + (user.status || '').slice(1);
                var createdFull = (user.created_at_day || '—') + (user.created_at_time ? ' ' + user.created_at_time : '');

                tableHtml += `
                <tr class="user-table-row border-b border-gray-50 last:border-0">
                    <td class="py-3.5 px-3 sm:px-5 hidden sm:table-cell">
                        <span class="text-xs text-gray-400 font-medium">${rowNumber}</span>
                    </td>

                    <td class="py-3.5 px-3 sm:px-4">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div
                                class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#b00000] flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                                ${initial}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800 text-sm leading-tight">
                                    ${user.name}
                                </div>
                                <div class="text-[11px] text-gray-400 mt-0.5 hidden sm:block">
                                    ${user.email}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="py-3.5 px-4">
                        <span class="badge-role" style="background:${roleBg};color:${roleColor};">
                            ${roleLabel}
                        </span>
                    </td>

                    <td class="py-3.5 px-4 text-center">
                        <span class="text-[11px] font-bold px-2.5 py-1 rounded-full ${statusClass}">
                            ${statusLabel}
                        </span>
                    </td>

                    <td class="py-3.5 px-4 hidden lg:table-cell">
                        <span class="text-xs text-gray-400">${registeredDay}</span>
                    </td>

                    <td class="py-3.5 px-2 sm:px-5">
                        <div class="flex items-center justify-center gap-1">
                            <button type="button"
                                onclick="openEditModal(
                                    'users',
                                    ${user.id},
                                    ${jsAttr(user.name)},
                                    ${jsAttr(user.email)},
                                    ${jsAttr(user.role_id)},
                                    ${jsAttr(user.status)}
                                )"
                                class="action-btn btn-edit" title="Edit account">
                                <i class="fa-solid fa-pen text-[11px]"></i>
                            </button>

                            <button type="button"
                                onclick="openToggleConfirm(${user.id}, ${jsAttr(user.status)}, ${jsAttr(user.name)})"
                                class="action-btn ${user.status === 'active' ? 'btn-toggle-on' : 'btn-toggle-off'}"
                                title="${user.status === 'active' ? 'Deactivate' : 'Activate'}">
                                <i class="fa-solid ${user.status === 'active' ? 'fa-toggle-on' : 'fa-toggle-off'} text-[11px]"></i>
                            </button>

                            <button type="button"
                                onclick="openResetModal('users', ${user.id}, ${jsAttr(user.name)})"
                                class="action-btn btn-reset" title="Reset password">
                                <i class="fa-solid fa-key text-[11px]"></i>
                            </button>

                            <button type="button"
                                onclick="openViewModal(
                                    ${jsAttr(user.name)},
                                    ${jsAttr(user.email)},
                                    ${jsAttr(roleLabel)},
                                    ${jsAttr(statusLabel)},
                                    'Users',
                                    ${jsAttr(createdFull)}
                                )"
                                class="action-btn" style="background:#f3f4f6;color:#374151;"
                                title="View details">
                                <i class="fa-solid fa-eye text-[11px]"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;

                gridHtml += `
                <div class="um-grid-card">
                    <div class="um-grid-top">
                        <div class="um-grid-number">#${rowNumber}</div>
                        <span class="text-[11px] font-bold px-2.5 py-1 rounded-full ${statusClass}">
                            ${statusLabel}
                        </span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#8B0000] to-[#b00000] flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                            ${initial}
                        </div>
                        <div class="min-w-0">
                            <div class="font-semibold text-gray-800 text-sm leading-tight">${user.name}</div>
                            <div class="text-[11px] text-gray-400 mt-0.5">${user.email}</div>
                        </div>
                    </div>

                    <div class="um-grid-meta">
                        <div class="um-grid-field">
                            <div class="um-grid-label">Role</div>
                            <div class="um-grid-value">
                                <span class="badge-role" style="background:${roleBg};color:${roleColor};">
                                    ${roleLabel}
                                </span>
                            </div>
                        </div>

                        <div class="um-grid-field">
                            <div class="um-grid-label">Registered</div>
                            <div class="um-grid-value">${registeredDay}</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-1 flex-wrap">
                        <button type="button"
                            onclick="openEditModal(
                                'users',
                                ${user.id},
                                ${jsAttr(user.name)},
                                ${jsAttr(user.email)},
                                ${jsAttr(user.role_id)},
                                ${jsAttr(user.status)}
                            )"
                            class="action-btn btn-edit" title="Edit account">
                            <i class="fa-solid fa-pen text-[11px]"></i>
                        </button>

                        <button type="button"
                            onclick="openToggleConfirm(${user.id}, ${jsAttr(user.status)}, ${jsAttr(user.name)})"
                            class="action-btn ${user.status === 'active' ? 'btn-toggle-on' : 'btn-toggle-off'}"
                            title="${user.status === 'active' ? 'Deactivate' : 'Activate'}">
                            <i class="fa-solid ${user.status === 'active' ? 'fa-toggle-on' : 'fa-toggle-off'} text-[11px]"></i>
                        </button>

                        <button type="button"
                            onclick="openResetModal('users', ${user.id}, ${jsAttr(user.name)})"
                            class="action-btn btn-reset" title="Reset password">
                            <i class="fa-solid fa-key text-[11px]"></i>
                        </button>

                        <button type="button"
                            onclick="openViewModal(
                                ${jsAttr(user.name)},
                                ${jsAttr(user.email)},
                                ${jsAttr(roleLabel)},
                                ${jsAttr(statusLabel)},
                                'Users',
                                ${jsAttr(createdFull)}
                            )"
                            class="action-btn" style="background:#f3f4f6;color:#374151;"
                            title="View details">
                            <i class="fa-solid fa-eye text-[11px]"></i>
                        </button>
                    </div>
                </div>
            `;
            });

            tbody.innerHTML = tableHtml;
            gridBody.innerHTML = gridHtml;
            applyUmView(getPreferredUmView(), false);
        }

        function umGoPage(page) {
            umState.page = page;
            umFetch();
        }

        function umRenderPagebar(p) {
            if (!p) return;

            document.querySelectorAll('.um-pagebar-info').forEach(function(el) {
                el.innerHTML = 'Showing <strong>' + p.from + '–' + p.to + '</strong> of <strong>' + p.total +
                    '</strong> users';
            });

            var html = umBuildPagination(p);
            document.querySelectorAll('.um-pagination-wrap').forEach(function(el) {
                el.innerHTML = html;
            });
        }

        function umRenderCounts(counts) {
            if (!counts) return;

            var totalEl = document.getElementById('countTotalUsers');
            var activeEl = document.getElementById('countActiveUsers');
            var inactiveEl = document.getElementById('countInactiveUsers');
            var badgeEl = document.getElementById('countBadgeUsers');

            if (totalEl) totalEl.textContent = counts.all ?? 0;
            if (activeEl) activeEl.textContent = counts.active ?? 0;
            if (inactiveEl) inactiveEl.textContent = counts.inactive ?? 0;
            if (badgeEl) badgeEl.textContent = counts.all ?? 0;
        }

        function umBuildPagination(p) {
            if (p.last_page <= 1) return '';

            var current = p.current_page;
            var last = p.last_page;
            var windowSize = 5;
            var half = Math.floor(windowSize / 2);
            var start = Math.max(1, current - half);
            var end = Math.min(last, start + windowSize - 1);

            if (end - start + 1 < windowSize) {
                start = Math.max(1, end - windowSize + 1);
            }

            var btn =
                'style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #e5e7eb;background:#fff;color:#374151;font-size:.75rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;"';
            var btnActive =
                'style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #8B0000;background:linear-gradient(135deg,#8B0000,#6b0000);color:#fff;font-size:.75rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;"';
            var btnDis =
                'style="height:32px;min-width:32px;padding:0 10px;border-radius:8px;border:1.5px solid #e5e7eb;background:#f9fafb;color:#d1d5db;font-size:.75rem;font-weight:600;cursor:not-allowed;display:inline-flex;align-items:center;justify-content:center;"';

            var html = '<nav style="display:flex;align-items:center;gap:.35rem;flex-wrap:nowrap;">';

            if (current <= 1) {
                html += '<button disabled ' + btnDis +
                    '><i class="fa-solid fa-chevron-left" style="font-size:.65rem;"></i></button>';
            } else {
                html += '<button onclick="umGoPage(' + (current - 1) + ')" ' + btn +
                    '><i class="fa-solid fa-chevron-left" style="font-size:.65rem;"></i></button>';
            }

            for (var i = start; i <= end; i++) {
                if (i === current) {
                    html += '<span ' + btnActive + '>' + i + '</span>';
                } else {
                    html += '<button onclick="umGoPage(' + i + ')" ' + btn + '>' + i + '</button>';
                }
            }

            if (current >= last) {
                html += '<button disabled ' + btnDis +
                    '><i class="fa-solid fa-chevron-right" style="font-size:.65rem;"></i></button>';
            } else {
                html += '<button onclick="umGoPage(' + (current + 1) + ')" ' + btn +
                    '><i class="fa-solid fa-chevron-right" style="font-size:.65rem;"></i></button>';
            }

            html += '</nav>';
            return html;
        }

        // Toast helper function
        function showSuccessToast(message) {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.style.cssText =
                'pointer-events:auto;position:relative;overflow:hidden;display:flex;align-items:flex-start;gap:10px;background:#fff;border:1px solid #d1fae5;box-shadow:0 8px 24px rgba(0,0,0,.12);border-radius:14px;padding:10px 12px;width:320px;animation:slideIn .35s ease forwards;';

            toast.innerHTML = `
                <div class="absolute inset-y-0 left-0 w-1 bg-emerald-500"></div>

                <div class="flex-shrink-0 ml-1">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
                    </div>
                </div>

                <div class="flex-1 min-w-0 pr-1">
                    <h3 class="text-[13px] sm:text-sm font-extrabold text-gray-800 leading-tight">Success</h3>
                    <p class="text-[12px] sm:text-[13px] text-gray-500 leading-4 mt-0.5 break-words">${message}</p>
                </div>

                <button
                    type="button"
                    class="flex-shrink-0 w-7 h-7 rounded-md text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition"
                    onclick="this.parentElement.remove()"
                >
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.style.transition = 'all 0.3s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-10px)';
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }

        function showErrorToast(message) {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.style.cssText =
                'pointer-events:auto;position:relative;overflow:hidden;display:flex;align-items:flex-start;gap:10px;background:#fff;border:1px solid #fee2e2;box-shadow:0 8px 24px rgba(0,0,0,.12);border-radius:14px;padding:10px 12px;width:320px;animation:slideIn .35s ease forwards;';

            toast.innerHTML = `
                <div class="absolute inset-y-0 left-0 w-1 bg-red-500"></div>

                <div class="flex-shrink-0 ml-1">
                    <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center">
                        <i class="fa-solid fa-circle-exclamation text-red-500 text-base"></i>
                    </div>
                </div>

                <div class="flex-1 min-w-0 pr-1">
                    <h3 class="text-[13px] sm:text-sm font-extrabold text-gray-800 leading-tight">Error</h3>
                    <p class="text-[12px] sm:text-[13px] text-gray-500 leading-4 mt-0.5 break-words">${message}</p>
                </div>

                <button
                    type="button"
                    class="flex-shrink-0 w-7 h-7 rounded-md text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition"
                    onclick="this.parentElement.remove()"
                >
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.style.transition = 'all 0.3s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-10px)';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        function setRoleFilter(el, role) {
            document.querySelectorAll('#umFilterForm [data-role]').forEach(function(b) {
                b.classList.remove('active');
            });
            el.classList.add('active');

            umState.role = (role === 'all' || role === '') ? '' : role;
            umState.page = 1;
            umFetch();
        }

        document.addEventListener('DOMContentLoaded', function() {
            applyTheme(localStorage.getItem('theme') || 'light');
            initUmViewToggle();
            document.querySelectorAll('.theme-option').forEach(function(o) {
                o.addEventListener('click', function(e) {
                    e.stopPropagation();
                    applyTheme(o.getAttribute('data-theme'));
                });
            });

            umRenderPagebar({
                total: {{ $users->total() }},
                from: {{ $users->firstItem() ?? 0 }},
                to: {{ $users->lastItem() ?? 0 }},
                current_page: {{ $users->currentPage() }},
                last_page: {{ $users->lastPage() }},
                per_page: {{ $users->perPage() }},
            });

            var searchInput = document.getElementById('umSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    toggleSearchClear(this);
                    clearTimeout(umSearchTimer);
                    var val = this.value;
                    umSearchTimer = setTimeout(function() {
                        umState.search = val;
                        umState.page = 1;
                        umFetch(true);
                    }, 350);
                });
            }

            var statusFilter = document.getElementById('statusFilter');
            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    umState.status = this.value;
                    umState.page = 1;
                    umFetch();
                });
            }

            var toggleForm = document.getElementById('toggleConfirmForm');
            if (toggleForm) {
                toggleForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    var form = this;
                    var url = form.action;
                    var btn = document.getElementById('toggleConfirmBtn');
                    var originalHtml = btn.dataset.originalHtml || btn.innerHTML;

                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing…';

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: '_method=PATCH&_token={{ csrf_token() }}'
                        })
                        .then(function(res) {
                            return res.json().then(function(data) {
                                return {
                                    ok: res.ok,
                                    data: data
                                };
                            });
                        })
                        .then(function(result) {
                            if (result.ok && result.data.success) {
                                closeAllModals();
                                showSuccessToast(result.data.message);
                                umFetch(true);
                            } else {
                                showErrorToast(result.data.message || 'Something went wrong.');
                            }
                        })
                        .catch(function() {
                            showErrorToast('Something went wrong. Please try again.');
                        })
                        .finally(function() {
                            btn.disabled = false;
                            btn.innerHTML = originalHtml;
                        });
                });
            }

            // ── AJAX: Edit User ──────────────────────────────────
            var editForm = document.getElementById('editForm');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    var form = this;
                    var url = form.action;
                    var submitBtn = form.querySelector('button[type="submit"]');
                    var originalHtml = submitBtn.innerHTML;

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving…';

                    var formData = new FormData(form);
                    // FormData already includes _method=PUT from the hidden input

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                            body: formData
                        })
                        .then(function(res) {
                            return res.json().then(function(data) {
                                return {
                                    ok: res.ok,
                                    status: res.status,
                                    data: data
                                };
                            });
                        })
                        .then(function(result) {
                            if (result.status === 422 && result.data.errors) {
                                var msgs = Object.values(result.data.errors).flat().join(' ');
                                showErrorToast(msgs);
                            } else if (result.ok && result.data.success) {
                                closeAllModals();
                                showSuccessToast(result.data.message || 'User updated successfully.');
                                umFetch(true);
                            } else {
                                showErrorToast(result.data.message || 'Something went wrong.');
                            }
                        })
                        .catch(function() {
                            showErrorToast('Something went wrong. Please try again.');
                        })
                        .finally(function() {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalHtml;
                        });
                });
            }

            // ── AJAX: Reset Password ─────────────────────────────
            var resetForm = document.getElementById('resetForm');
            if (resetForm) {
                resetForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    var form = this;
                    var url = form.action;
                    var submitBtn = form.querySelector('button[type="submit"]');
                    var originalHtml = submitBtn.innerHTML;

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Resetting…';

                    var formData = new FormData(form);

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                            body: formData
                        })
                        .then(function(res) {
                            return res.json().then(function(data) {
                                return {
                                    ok: res.ok,
                                    status: res.status,
                                    data: data
                                };
                            });
                        })
                        .then(function(result) {
                            if (result.status === 422 && result.data.errors) {
                                var msgs = Object.values(result.data.errors).flat().join(' ');
                                showErrorToast(msgs);
                            } else if (result.ok && result.data.success) {
                                closeAllModals();
                                showSuccessToast(result.data.message || 'Password reset successfully.');
                                // Clear fields for next use
                                document.getElementById('resetPassword').value = '';
                                document.getElementById('resetPasswordConf').value = '';
                            } else {
                                showErrorToast(result.data.message || 'Something went wrong.');
                            }
                        })
                        .catch(function() {
                            showErrorToast('Something went wrong. Please try again.');
                        })
                        .finally(function() {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalHtml;
                        });
                });
            }
        });

        window.addEventListener('resize', function() {
            applyUmView(getPreferredUmView(), false);
        });
    </script>
@endsection
