@extends('layouts.admin')

@section('title', 'Admin Dashboard | PUP Taguig Dental Clinic')

@section('styles')
    <style>
        * {
            box-sizing: border-box;
        }

        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #bbb;
        }

        [data-theme="dark"] .card,
        [data-theme="dark"] .stat-card {
            background: #161b22 !important;
            border-color: #21262d !important;
        }

        [data-theme="dark"] .card-header,
        [data-theme="dark"] .log-stats-row {
            background: #0d1117 !important;
            border-color: #21262d !important;
        }

        [data-theme="dark"] .stat-value {
            color: #f3f4f6;
        }

        [data-theme="dark"] .card-title {
            color: #f3f4f6;
        }

        [data-theme="dark"] .data-table thead th {
            background: #0d1117;
            color: #6b7280;
            border-color: #21262d;
        }

        [data-theme="dark"] .data-table tbody td {
            color: #d1d5db;
            border-color: #1c2128;
        }

        [data-theme="dark"] .data-table tbody tr:hover td {
            background: #1c2128;
        }

        [data-theme="dark"] .next-backup,
        [data-theme="dark"] .qa-btn {
            background: #1c2128;
            border-color: #21262d;
        }

        [data-theme="dark"] .qa-title {
            color: #fca5a5;
        }

        [data-theme="dark"] .qa-sub {
            color: #6b7280;
        }

        [data-theme="dark"] .qa-btn:hover {
            background: rgba(139, 0, 0, .15);
            border-color: #5b2020;
        }

        [data-theme="dark"] .next-date {
            color: #e5e7eb;
        }

        [data-theme="dark"] .empty-icon {
            background: #21262d;
        }

        [data-theme="dark"] .period-pill {
            background: rgba(255, 255, 255, .08);
        }

        /* ════════════════════════════════
           PAGE BANNER
        ════════════════════════════════ */
        .page-banner {
            background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 60%, #c0392b 100%);
            padding: 2rem 2rem 3.5rem;
            position: relative;
            overflow: hidden;
        }

        .page-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .page-banner::after {
            content: '';
            position: absolute;
            right: -60px;
            top: -60px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .04);
            pointer-events: none;
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

        .page-greeting {
            font-size: .75rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .65);
            letter-spacing: .05em;
            text-transform: uppercase;
            margin-bottom: .3rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 900;
            color: #fff;
            line-height: 1.1;
        }

        .page-subtitle {
            font-size: .78rem;
            color: rgba(255, 255, 255, .6);
            margin-top: .4rem;
        }

        .period-pill {
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 14px;
            padding: .75rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            backdrop-filter: blur(8px);
            flex-wrap: wrap;
        }

        .period-item {
            text-align: left;
        }

        .period-label {
            font-size: .6rem;
            font-weight: 700;
            color: rgba(255, 255, 255, .55);
            text-transform: uppercase;
            letter-spacing: .08em;
            display: block;
        }

        .period-value {
            font-size: .95rem;
            font-weight: 800;
            color: #fff;
            display: block;
            margin-top: 2px;
        }

        .period-divider {
            width: 1px;
            height: 32px;
            background: rgba(255, 255, 255, .2);
        }

        .manage-btn {
            background: rgba(255, 255, 255, .15);
            border: 1px solid rgba(255, 255, 255, .25);
            color: #fff;
            padding: .6rem 1.1rem;
            border-radius: 10px;
            font-size: .75rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s;
            display: flex;
            align-items: center;
            gap: .5rem;
            white-space: nowrap;
            font-family: 'Inter', sans-serif;
        }

        .manage-btn:hover {
            background: rgba(255, 255, 255, .25);
            transform: translateY(-1px);
        }

        /* ════════════════════════════════
           CONTENT LIFT
        ════════════════════════════════ */
        .content-lift {
            margin-top: -2rem;
            padding: 0 1.75rem 2rem;
            position: relative;
            z-index: 2;
        }

        /* ════════════════════════════════
           STAT CARDS
        ════════════════════════════════ */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.25rem 1.4rem;
            border: 1px solid rgba(0, 0, 0, .05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, .06), 0 1px 3px rgba(0, 0, 0, .04);
            transition: transform .2s, box-shadow .2s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, .1), 0 2px 6px rgba(0, 0, 0, .05);
        }

        .stat-card-accent {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .stat-badge {
            font-size: .68rem;
            font-weight: 700;
            padding: .3rem .75rem;
            border-radius: 20px;
        }

        .stat-label {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #9ca3af;
            margin-bottom: .3rem;
        }

        .stat-value {
            font-size: 2.4rem;
            font-weight: 900;
            line-height: 1;
            color: #1a202c;
            letter-spacing: -.03em;
            margin-bottom: .5rem;
        }

        .stat-footer {
            font-size: .7rem;
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: .35rem;
        }

        /* ════════════════════════════════
           MAIN GRID & CARDS
        ════════════════════════════════ */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 1.25rem;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, .05);
            box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
            overflow: hidden;
        }

        .card-header {
            padding: .9rem 1.25rem;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafafa;
        }

        .card-header-left {
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .card-header-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: var(--crimson-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: var(--crimson);
        }

        .card-title {
            font-size: .82rem;
            font-weight: 800;
            color: #1a202c;
        }

        .card-link {
            font-size: .72rem;
            color: var(--crimson);
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .3rem;
            transition: gap .15s;
        }

        .card-link:hover {
            gap: .5rem;
        }

        /* ════════════════════════════════
           LOG MINI-STATS
        ════════════════════════════════ */
        .log-stats-row {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: .75rem;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .log-stat {
            text-align: center;
            padding: .7rem .5rem;
            border-radius: 10px;
            cursor: pointer;
            transition: transform .15s;
        }

        .log-stat:hover {
            transform: translateY(-2px);
        }

        .log-stat-value {
            font-size: 1.4rem;
            font-weight: 900;
            line-height: 1;
        }

        .log-stat-label {
            font-size: .58rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-top: 4px;
        }

        /* ════════════════════════════════
           TABLE
        ════════════════════════════════ */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .76rem;
        }

        .data-table thead th {
            padding: .7rem 1rem;
            text-align: left;
            font-weight: 700;
            color: #9ca3af;
            font-size: .65rem;
            text-transform: uppercase;
            letter-spacing: .06em;
            background: #fafafa;
            border-bottom: 1px solid #f3f4f6;
        }

        .data-table tbody td {
            padding: .8rem 1rem;
            color: #4a5568;
            border-bottom: 1px solid #f9fafb;
        }

        .data-table tbody tr:hover td {
            background: #fafafa;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.4rem;
            color: #d1d5db;
        }

        /* ════════════════════════════════
           BOTTOM GRID
        ════════════════════════════════ */
        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-top: 1.25rem;
        }

        /* ════════════════════════════════
           QUICK ACTIONS
        ════════════════════════════════ */
        .qa-btn {
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: .85rem 1rem;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
            background: #fff;
            cursor: pointer;
            transition: all .15s;
            text-align: left;
            width: 100%;
            margin-bottom: .6rem;
            font-family: 'Inter', sans-serif;
        }

        .qa-btn:last-child {
            margin-bottom: 0;
        }

        .qa-btn:hover {
            border-color: var(--crimson-mid);
            background: var(--crimson-light);
            transform: translateX(3px);
        }

        .qa-btn:hover .qa-icon {
            background: var(--crimson);
            color: #fff;
        }

        .qa-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--crimson-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--crimson);
            font-size: .95rem;
            flex-shrink: 0;
            transition: all .15s;
        }

        .qa-text {
            flex: 1;
        }

        .qa-title {
            font-size: .8rem;
            font-weight: 700;
            color: var(--crimson);
            display: block;
        }

        .qa-sub {
            font-size: .68rem;
            color: #9ca3af;
            display: block;
            margin-top: 1px;
        }

        .qa-arrow {
            color: #d1d5db;
            font-size: .7rem;
            transition: all .15s;
        }

        .qa-btn:hover .qa-arrow {
            color: var(--crimson);
        }

        /* ════════════════════════════════
           BACKUP CARD
        ════════════════════════════════ */
        .backup-status {
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: 1rem 1.1rem;
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            margin-bottom: .75rem;
        }

        .backup-check {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #fff;
            border: 1px solid #86efac;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #16a34a;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .backup-label {
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #16a34a;
            display: block;
        }

        .backup-date {
            font-size: .85rem;
            font-weight: 800;
            color: #1a202c;
            display: block;
            margin-top: 2px;
        }

        .backup-sub {
            font-size: .65rem;
            color: #4ade80;
            margin-top: 1px;
            display: block;
        }

        .next-backup {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .75rem 1rem;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            margin-bottom: .75rem;
        }

        .next-icon {
            color: #9ca3af;
            font-size: .85rem;
        }

        .next-label {
            font-size: .62rem;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .next-date {
            font-size: .8rem;
            font-weight: 800;
            color: #374151;
            margin-top: 1px;
        }

        .run-backup-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--crimson) 0%, var(--crimson-dark) 100%);
            color: #fff;
            font-weight: 800;
            font-size: .8rem;
            padding: .8rem 1rem;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            transition: all .2s;
            box-shadow: 0 4px 14px rgba(139, 0, 0, .3);
            font-family: 'Inter', sans-serif;
        }

        .run-backup-btn:hover {
            box-shadow: 0 6px 20px rgba(139, 0, 0, .4);
            transform: translateY(-1px);
        }

        /* ════════════════════════════════
           RESPONSIVE
        ════════════════════════════════ */
        @media (max-width: 1024px) {
            .main-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767px) {
            .stat-grid {
                grid-template-columns: 1fr 1fr;
            }

            .stat-grid .stat-card:last-child {
                grid-column: span 2;
            }

            .content-lift {
                padding: 0 1rem 2rem;
            }

            .page-banner {
                padding: 1.5rem 1rem 3rem;
            }

            .period-pill {
                gap: .75rem;
            }

            .log-stats-row {
                grid-template-columns: repeat(3, 1fr);
            }

            .bottom-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .stat-grid {
                grid-template-columns: 1fr;
            }

            .stat-grid .stat-card:last-child {
                grid-column: span 1;
            }
        }

        /* ════════════════════════════════
           ANIMATIONS
        ════════════════════════════════ */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card {
            animation: fadeSlideUp .4s ease both;
        }

        .stat-card:nth-child(1) {
            animation-delay: .05s;
        }

        .stat-card:nth-child(2) {
            animation-delay: .1s;
        }

        .stat-card:nth-child(3) {
            animation-delay: .15s;
        }

        .card {
            animation: fadeSlideUp .4s ease .2s both;
        }
    </style>
@endsection

@section('content')

    @php $logs = $logs ?? collect([]); @endphp

    <main id="mainContent" style="padding-top: var(--header-h); min-height: 100vh;">

        <!-- Page banner -->
        <div class="page-banner">
            <div class="page-banner-inner">
                <div>
                    <div class="page-greeting">
                        <i id="currentDateIcon" class="fa-solid fa-calendar-day" style="color:#fcd34d;"></i>
                        <span id="currentDate"></span>
                    </div>
                    <h1 class="page-title">Admin Dashboard</h1>
                    <p class="page-subtitle">Welcome back, Administrator. Here's what's happening today.</p>
                </div>
                <div class="period-pill">
                    <div class="period-item">
                        <span class="period-label"><i class="fa-solid fa-calendar" style="margin-right:3px;"></i>
                            Semester</span>
                        <span class="period-value">2nd Semester</span>
                    </div>
                    <div class="period-divider"></div>
                    <div class="period-item">
                        <span class="period-label"><i class="fa-solid fa-graduation-cap" style="margin-right:3px;"></i>
                            Academic
                            Year</span>
                        <span class="period-value">2025–2026</span>
                    </div>
                    <div class="period-divider"></div>
                    <div class="period-item">
                        <span class="period-label"><i class="fa-solid fa-clock" style="margin-right:3px;"></i> Period
                            Ends</span>
                        <span class="period-value">June 10, 2026</span>
                    </div>
                    <a href="{{ route('admin.academic_periods') }}" class="manage-btn">
                        <i class="fa-solid fa-gear"></i> Manage
                    </a>
                </div>
            </div>
        </div>

        <!-- Content (overlaps banner) -->
        <div class="content-lift">

            <!-- STAT CARDS -->
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-card-accent" style="background: linear-gradient(90deg, var(--crimson), #c0392b);">
                    </div>
                    <div class="stat-top">
                        <div class="stat-icon" style="background:#fef2f2;">
                            <i class="fa-solid fa-users" style="color:var(--crimson);"></i>
                        </div>
                        <span class="stat-badge" style="background:#fef2f2;color:var(--crimson);">All time</span>
                    </div>
                    <div class="stat-label">Total Patients</div>
                    <div class="stat-value">{{ number_format($totalPatients) }}</div>
                    <div class="stat-footer">
                        <i class="fa-solid fa-user-plus" style="font-size:.65rem;color:var(--crimson);"></i>
                        All registered patients
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-accent" style="background: linear-gradient(90deg, #3b82f6, #2563eb);"></div>
                    <div class="stat-top">
                        <div class="stat-icon" style="background:#eff6ff;">
                            <i class="fa-solid fa-calendar-check" style="color:#3b82f6;"></i>
                        </div>
                        <span class="stat-badge"
                            style="background:#eff6ff;color:#3b82f6;">{{ \Carbon\Carbon::now()->format('F Y') }}</span>
                    </div>
                    <div class="stat-label">Appointments</div>
                    <div class="stat-value">{{ $appointmentsThisMonth }}</div>
                    <div class="stat-footer">
                        <i class="fa-solid fa-clock" style="font-size:.65rem;color:#3b82f6;"></i>
                        This month
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-accent" style="background: linear-gradient(90deg, #22c55e, #16a34a);"></div>
                    <div class="stat-top">
                        <div class="stat-icon" style="background:#f0fdf4;">
                            <i class="fa-solid fa-file-arrow-up" style="color:#22c55e;"></i>
                        </div>
                        <span class="stat-badge"
                            style="background:#f0fdf4;color:#16a34a;">{{ \Carbon\Carbon::now()->format('F Y') }}</span>
                    </div>
                    <div class="stat-label">Documents Issued</div>
                    <div class="stat-value">{{ $documentsThisMonth }}</div>
                    <div class="stat-footer">
                        <i class="fa-solid fa-file-lines" style="font-size:.65rem;color:#22c55e;"></i>
                        This month
                    </div>
                </div>
            </div>

            <!-- MAIN GRID -->
            <div class="main-grid">

                <!-- LEFT COLUMN -->
                <div style="display:flex;flex-direction:column;gap:1.25rem;">

                    <!-- System Logs Card -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-left">
                                <div class="card-header-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                                <span class="card-title">System Logs Overview</span>
                            </div>
                            <a href="{{ route('admin.system_logs') }}" class="card-link">
                                View All <i class="fa-solid fa-arrow-right" style="font-size:.65rem;"></i>
                            </a>
                        </div>

                        <div class="log-stats-row">
                            <div class="log-stat" style="background:#f5f3ff;">
                                <div class="log-stat-value" style="color:#7c3aed;">{{ $logThisMonth ?? 0 }}</div>
                                <div class="log-stat-label" style="color:#7c3aed;">This Month</div>
                            </div>
                            <div class="log-stat" style="background:#eff6ff;">
                                <div class="log-stat-value" style="color:#2563eb;">{{ $logInfo ?? 0 }}</div>
                                <div class="log-stat-label" style="color:#3b82f6;">Views</div>
                            </div>
                            <div class="log-stat" style="background:#fffbeb;">
                                <div class="log-stat-value" style="color:#d97706;">{{ $logWarnings ?? 0 }}</div>
                                <div class="log-stat-label" style="color:#f59e0b;">Logins</div>
                            </div>
                            <div class="log-stat" style="background:#f0fdf4;">
                                <div class="log-stat-value" style="color:#16a34a;">{{ $logBackups ?? 0 }}</div>
                                <div class="log-stat-label" style="color:#22c55e;">Backups</div>
                            </div>
                            <div class="log-stat" style="background:#fef2f2;">
                                <div class="log-stat-value" style="color:var(--crimson);">{{ $logErrors ?? 0 }}</div>
                                <div class="log-stat-label" style="color:#ef4444;">Errors</div>
                            </div>
                        </div>

                        <div style="overflow-x:auto;">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">ID</th>
                                        <th style="width:160px;">Date & Time</th>
                                        <th>Description</th>
                                        <th style="width:120px;">User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentLogs ?? [] as $log)
                                        @php
                                            $logId = data_get($log, 'id', '—');
                                            $logDate = data_get($log, 'created_at');
                                            $logDesc = data_get($log, 'description', 'No description provided.');
                                            $logActor = data_get($log, 'actor_identifier', '—');
                                            $logRole = data_get($log, 'actor_role', '');
                                        @endphp
                                        <tr>
                                            <td style="color:#9ca3af;font-size:.72rem;">#{{ $logId }}</td>
                                            <td>
                                                <div style="font-size:.74rem;font-weight:600;color:#374151;">
                                                    {{ $logDate ? \Carbon\Carbon::parse($logDate)->format('M j, Y') : '—' }}
                                                </div>
                                                <div style="font-size:.68rem;color:#9ca3af;">
                                                    {{ $logDate ? \Carbon\Carbon::parse($logDate)->format('h:i:s A') : '—' }}
                                                </div>
                                            </td>
                                            <td style="font-size:.76rem;">{{ $logDesc }}</td>
                                            <td>
                                                <span
                                                    style="font-size:.72rem;font-weight:600;color:#4a5568;">{{ $logActor }}</span>
                                                <div style="font-size:.65rem;color:#9ca3af;text-transform:capitalize;">
                                                    {{ $logRole }}</div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <div class="empty-state">
                                                    <div class="empty-icon"><i class="fa-solid fa-inbox"></i></div>
                                                    <p
                                                        style="font-size:.82rem;font-weight:700;color:#6b7280;margin-bottom:.25rem;">
                                                        No logs yet</p>
                                                    <p style="font-size:.72rem;color:#b0b7c3;">System activity will appear
                                                        here</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Bottom row: GAD + Inventory -->
                    <div class="bottom-grid">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-header-left">
                                    <div class="card-header-icon"><i class="fa-solid fa-chart-pie"></i></div>
                                    <span class="card-title">GAD Analytics</span>
                                </div>
                                <a href="#" class="card-link">View <i class="fa-solid fa-arrow-right"
                                        style="font-size:.65rem;"></i></a>
                            </div>
                            <div style="padding:1.25rem;">
                                <div
                                    style="height:140px;border-radius:10px;border:2px dashed #e5e7eb;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#fafafa,#fff);">
                                    <div style="text-align:center;">
                                        <i class="fa-solid fa-chart-area"
                                            style="font-size:2rem;color:#e5e7eb;display:block;margin-bottom:.5rem;"></i>
                                        <span style="font-size:.72rem;color:#b0b7c3;font-weight:600;">Chart coming
                                            soon</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="card-header-left">
                                    <div class="card-header-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                                    <span class="card-title">Inventory</span>
                                </div>
                                <a href="#" class="card-link">View <i class="fa-solid fa-arrow-right"
                                        style="font-size:.65rem;"></i></a>
                            </div>
                            <div style="padding:1.25rem;">
                                <div
                                    style="height:140px;border-radius:10px;border:2px dashed #e5e7eb;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#fafafa,#fff);">
                                    <div style="text-align:center;">
                                        <i class="fa-solid fa-box"
                                            style="font-size:2rem;color:#e5e7eb;display:block;margin-bottom:.5rem;"></i>
                                        <span style="font-size:.72rem;color:#b0b7c3;font-weight:600;">Coming soon</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN -->
                <div style="display:flex;flex-direction:column;gap:1.25rem;">

                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-left">
                                <div class="card-header-icon"><i class="fa-solid fa-bolt"></i></div>
                                <span class="card-title">Quick Actions</span>
                            </div>
                        </div>
                        <div style="padding:1rem;">
                            <button class="qa-btn">
                                <div class="qa-icon"><i class="fa-solid fa-file-circle-plus"></i></div>
                                <div class="qa-text">
                                    <span class="qa-title">New Template</span>
                                    <span class="qa-sub">Create document format</span>
                                </div>
                                <i class="fa-solid fa-chevron-right qa-arrow"></i>
                            </button>
                            <button class="qa-btn">
                                <div class="qa-icon"><i class="fa-solid fa-file-invoice"></i></div>
                                <div class="qa-text">
                                    <span class="qa-title">Generate Report</span>
                                    <span class="qa-sub">Create report documents</span>
                                </div>
                                <i class="fa-solid fa-chevron-right qa-arrow"></i>
                            </button>
                            <button class="qa-btn">
                                <div class="qa-icon"><i class="fa-solid fa-chart-column"></i></div>
                                <div class="qa-text">
                                    <span class="qa-title">View Reports</span>
                                    <span class="qa-sub">All reports & analytics</span>
                                </div>
                                <i class="fa-solid fa-chevron-right qa-arrow"></i>
                            </button>
                            <a href="{{ route('admin.user_management') }}" class="qa-btn">
                                <div class="qa-icon"><i class="fa-solid fa-user-plus"></i></div>
                                <div class="qa-text">
                                    <span class="qa-title">Add User</span>
                                    <span class="qa-sub">Register new account</span>
                                </div>
                                <i class="fa-solid fa-chevron-right qa-arrow"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Data Backup -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-left">
                                <div class="card-header-icon"><i class="fa-solid fa-database"></i></div>
                                <span class="card-title">Data Backup</span>
                            </div>
                            <span
                                style="font-size:.65rem;font-weight:700;background:#f0fdf4;color:#16a34a;padding:.25rem .6rem;border-radius:20px;border:1px solid #bbf7d0;">Healthy</span>
                        </div>
                        <div style="padding:1rem;">
                            <div class="backup-status">
                                <div class="backup-check"><i class="fa-solid fa-check"></i></div>
                                <div>
                                    <span class="backup-label">Last Backup</span>
                                    <span class="backup-date">December 25, 2025</span>
                                    <span class="backup-sub">✓ Completed successfully</span>
                                </div>
                            </div>
                            <div class="next-backup">
                                <i class="fa-regular fa-clock next-icon"></i>
                                <div>
                                    <div class="next-label">Next Scheduled</div>
                                    <div class="next-date">March 30, 2026</div>
                                </div>
                            </div>
                            <button class="run-backup-btn">
                                <i class="fa-solid fa-database"></i>
                                Run Backup Now
                            </button>
                        </div>
                    </div>

                </div>
            </div><!-- /main-grid -->

        </div><!-- /content-lift -->
    </main>

@endsection

@section('scripts')
    @if (session('activeAppointmentModal'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modal = document.getElementById("activeAppointmentModal");
                var closeBtn = document.getElementById("closeActiveApptModalBtn");
                if (!modal) return;
                modal.showModal();
                modal.addEventListener('click', function(e) {
                    var box = modal.querySelector('.modal-box');
                    if (box && !box.contains(e.target)) e.preventDefault();
                });
                modal.addEventListener('cancel', function(e) {
                    e.preventDefault();
                });
                if (closeBtn) closeBtn.addEventListener("click", function() {
                    modal.close();
                });
            });
        </script>
    @endif
@endsection
