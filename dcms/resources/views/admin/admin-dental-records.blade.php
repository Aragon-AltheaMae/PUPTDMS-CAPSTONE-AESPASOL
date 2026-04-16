@extends('layouts.admin')

@section('title', 'Dental Reports | PUP Taguig Dental Clinic')

@section('styles')
<style>
    :root {
        --crimson: #8B0000;
        --crimson-dark: #6b0000;
        --crimson-light: #fef2f2;
    }

    .page-banner {
        background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 60%, #c0392b 100%);
        padding: 1.75rem 2rem 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(139, 0, 0, .25);
        margin-bottom: 1.5rem;
        border-radius: 1rem;
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
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 900;
        color: #fff !important;
        line-height: 1.1;
        letter-spacing: -.02em;
    }

    .page-subtitle {
        font-size: .85rem;
        color: rgba(255, 255, 255, .78) !important;
        margin-top: .45rem;
    }

    .page-badge {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-size: .72rem;
        font-weight: 700;
        color: #8B0000;
        background: rgba(255, 255, 255, .95);
        border: 1px solid rgba(255, 255, 255, .8);
        padding: .42rem .8rem;
        border-radius: 999px;
        white-space: nowrap;
    }

    .summary-bar {
        background: linear-gradient(135deg, #7f0000 0%, #a00000 100%);
        border-bottom: 1px solid rgba(255, 255, 255, .08);
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: .6rem;
        flex-wrap: wrap;
        margin-bottom: 1.25rem;
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
        border: none;
        background: transparent;
        cursor: pointer;
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

    .report-card {
        background: #fff;
        border: 1px solid #EDE8E3;
        border-radius: 18px;
        padding: 1.25rem;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.05);
        transition: .2s ease;
    }

    .report-card:hover {
        border-color: rgba(139, 0, 0, .18);
        box-shadow: 0 12px 30px rgba(139, 0, 0, .08);
        transform: translateY(-2px);
    }

    .stat-card {
        background: #fff;
        border: 1px solid #EDE8E3;
        border-radius: 20px;
        padding: 1.35rem;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        transition: .2s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        border-color: rgba(139, 0, 0, .22);
        box-shadow: 0 12px 34px rgba(139, 0, 0, .08);
    }

    .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 1rem;
    }

    .stat-icon-red {
        background: #fef2f2;
        color: #8B0000;
    }

    .stat-icon-green {
        background: #ecfdf5;
        color: #15803d;
    }

    .stat-icon-amber {
        background: #fffbeb;
        color: #b45309;
    }

    .stat-icon-blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .stat-label {
        font-size: .78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #9ca3af;
        margin-bottom: .4rem;
    }

    .stat-value {
        font-size: 2.35rem;
        line-height: 1;
        font-weight: 900;
        color: #111827;
    }

    .stat-meta {
        margin-top: .75rem;
        font-size: .88rem;
        color: #9ca3af;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #1f2937;
    }

    .section-subtitle {
        font-size: .85rem;
        color: #9ca3af;
        margin-top: .25rem;
    }

    .table-shell {
        background: #fff;
        border: 1px solid #EDE8E3;
        border-radius: 20px;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .table-head {
        padding: 1.1rem 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .table-wrap {
        overflow-x: auto;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
    }

    .report-table th {
        text-align: left;
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #9ca3af;
        padding: .95rem 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 800;
        white-space: nowrap;
    }

    .report-table td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f8fafc;
        color: #374151;
        font-size: .92rem;
        vertical-align: middle;
    }

    .report-table tr:hover td {
        background: #fcfcfd;
    }

    .badge-soft {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .38rem .75rem;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 700;
    }

    .badge-red {
        background: #fef2f2;
        color: #8B0000;
    }

    .badge-green {
        background: #ecfdf5;
        color: #15803d;
    }

    .badge-amber {
        background: #fffbeb;
        color: #b45309;
    }

    .quick-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .55rem;
        border-radius: 14px;
        padding: .85rem 1rem;
        font-size: .9rem;
        font-weight: 700;
        transition: .2s ease;
        text-decoration: none;
    }

    .quick-btn-primary {
        background: #8B0000;
        color: #fff;
    }

    .quick-btn-primary:hover {
        background: #6b0000;
    }

    .quick-btn-light {
        background: #f9f0f0;
        color: #8B0000;
    }

    .quick-btn-light:hover {
        background: #f5e2e2;
    }

    .quick-btn-muted {
        background: #f3f4f6;
        color: #4b5563;
    }

    .quick-btn-muted:hover {
        background: #e5e7eb;
    }

    .empty-state {
        padding: 3rem 1.5rem;
        text-align: center;
        color: #9ca3af;
    }

    [hidden] {
        display: none !important;
    }

    @media (max-width: 767px) {
        .page-banner {
            padding: 1rem 1rem 1.2rem !important;
        }

        .page-title {
            font-size: 1.35rem !important;
        }

        .tab-btn-toggle {
            padding: 7px 12px;
            font-size: 11.5px;
        }

        .summary-bar {
            padding: .85rem 1rem;
        }

        .stat-value {
            font-size: 1.9rem;
        }
    }
</style>
@endsection

@section('content')
@php
    $reportType = request('report', 'overview');

    $totalRecords = $totalRecords ?? 0;
    $recordsThisMonth = $recordsThisMonth ?? 0;
    $pendingFollowUps = $pendingFollowUps ?? 0;
    $topProcedure = $topProcedure ?? 'No data yet';

    $procedureBreakdown = collect($procedureBreakdown ?? []);
    $recentRecords = collect($recentRecords ?? []);
@endphp

<main id="mainContent" class="pt-[80px] sm:pt-[88px] px-3 sm:px-6 pb-6 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <div class="page-banner mt-2">
            <div class="page-banner-inner">
                <div>
                    <div class="page-badge mb-3">
                        <i class="fa-solid fa-chart-line"></i>
                        Dental analytics and monitoring
                    </div>
                    <h1 class="page-title">Dental Reports</h1>
                    <p class="page-subtitle">
                        Track clinic activity, treatment patterns, and follow-up workload in one place
                    </p>
                </div>

                <div class="tab-toggle-wrap">
                    <button type="button"
                        class="tab-btn-toggle {{ $reportType === 'overview' ? 'active' : '' }}"
                        onclick="switchReportTab('overview')">
                        <i class="fa-solid fa-chart-pie text-xs"></i>
                        Overview
                        <span class="tab-count-badge">{{ $totalRecords }}</span>
                    </button>

                    <button type="button"
                        class="tab-btn-toggle {{ $reportType === 'procedures' ? 'active' : '' }}"
                        onclick="switchReportTab('procedures')">
                        <i class="fa-solid fa-tooth text-xs"></i>
                        Procedures
                        <span class="tab-count-badge">{{ $procedureBreakdown->count() }}</span>
                    </button>

                    <button type="button"
                        class="tab-btn-toggle {{ $reportType === 'recent' ? 'active' : '' }}"
                        onclick="switchReportTab('recent')">
                        <i class="fa-solid fa-clock-rotate-left text-xs"></i>
                        Recent
                        <span class="tab-count-badge">{{ $recentRecords->count() }}</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="summary-bar">
            <i class="fa-solid fa-circle-info text-white/60 text-sm"></i>

            <span class="summary-chip summary-chip-highlight">
                <i class="fa-solid fa-folder-open text-xs"></i>
                {{ $totalRecords }} total dental records
            </span>

            <span class="summary-chip">
                <i class="fa-solid fa-calendar-days text-xs"></i>
                {{ $recordsThisMonth }} this month
            </span>

            <span class="summary-chip">
                <i class="fa-solid fa-user-clock text-xs"></i>
                {{ $pendingFollowUps }} pending follow-ups
            </span>

            <span class="summary-chip">
                <i class="fa-solid fa-star text-xs"></i>
                Top procedure: <strong>{{ $topProcedure }}</strong>
            </span>
        </div>

        {{-- OVERVIEW TAB --}}
        <section id="overviewSection" {{ $reportType !== 'overview' ? 'hidden' : '' }}>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
                <div class="stat-card">
                    <div class="stat-icon stat-icon-red">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <div class="stat-label">Total Dental Records</div>
                    <div class="stat-value">{{ $totalRecords }}</div>
                    <div class="stat-meta">
                        <i class="fa-solid fa-file-medical text-[#8B0000]"></i>
                        All encoded treatment records
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-green">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div class="stat-label">This Month</div>
                    <div class="stat-value">{{ $recordsThisMonth }}</div>
                    <div class="stat-meta">
                        <i class="fa-solid fa-chart-column text-green-600"></i>
                        Dental entries recorded this month
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-amber">
                        <i class="fa-solid fa-user-clock"></i>
                    </div>
                    <div class="stat-label">Pending Follow-Ups</div>
                    <div class="stat-value">{{ $pendingFollowUps }}</div>
                    <div class="stat-meta">
                        <i class="fa-solid fa-bell text-amber-600"></i>
                        Patients needing next visit
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon stat-icon-blue">
                        <i class="fa-solid fa-tooth"></i>
                    </div>
                    <div class="stat-label">Top Procedure</div>
                    <div class="stat-value text-[1.4rem] sm:text-[1.6rem] leading-tight">{{ $topProcedure }}</div>
                    <div class="stat-meta">
                        <i class="fa-solid fa-ranking-star text-blue-600"></i>
                        Most frequently recorded service
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
                <div class="xl:col-span-2 table-shell">
                    <div class="table-head">
                        <div>
                            <h3 class="section-title">Procedure Breakdown</h3>
                            <p class="section-subtitle">Most commonly performed procedures in the clinic</p>
                        </div>
                    </div>

                    <div class="table-wrap">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Procedure</th>
                                    <th>Total Cases</th>
                                    <th>Share</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($procedureBreakdown as $procedure)
                                    <tr>
                                        <td class="font-semibold text-gray-800">
                                            {{ $procedure->name ?? $procedure['name'] ?? 'Unnamed Procedure' }}
                                        </td>
                                        <td>
                                            {{ $procedure->count ?? $procedure['count'] ?? 0 }}
                                        </td>
                                        <td>
                                            {{ $procedure->percentage ?? $procedure['percentage'] ?? '0%' }}
                                        </td>
                                        <td>
                                            <span class="badge-soft badge-red">
                                                <i class="fa-solid fa-chart-simple text-[10px]"></i>
                                                Active in reports
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="empty-state">No procedure data available yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="report-card">
                        <h3 class="section-title">Quick Actions</h3>
                        <p class="section-subtitle mb-4">Fast access to report-related tasks</p>

                        <div class="flex flex-col gap-3">
                            <a href="{{ route('admin.reports.export.pdf') }}" class="quick-btn quick-btn-primary">
                                <i class="fa-solid fa-file-pdf"></i>
                                Export PDF Report
                            </a>

                            <a href="{{ route('admin.reports.export.excel') }}" class="quick-btn quick-btn-light">
                                <i class="fa-solid fa-file-excel"></i>
                                Export Excel Report
                            </a>

                            <a href="{{ route('admin.dental-records.index') }}" class="quick-btn quick-btn-muted">
                                <i class="fa-solid fa-folder-open"></i>
                                View Dental Records
                            </a>
                        </div>
                    </div>

                    <div class="report-card">
                        <h3 class="section-title">Insights</h3>
                        <p class="section-subtitle mb-4">Useful admin-level observations</p>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between rounded-2xl bg-[#faf7f5] px-4 py-3">
                                <span class="text-sm text-gray-500 font-semibold">Top Procedure</span>
                                <span class="badge-soft badge-red">{{ $topProcedure }}</span>
                            </div>

                            <div class="flex items-center justify-between rounded-2xl bg-[#faf7f5] px-4 py-3">
                                <span class="text-sm text-gray-500 font-semibold">Monthly Records</span>
                                <span class="badge-soft badge-green">{{ $recordsThisMonth }}</span>
                            </div>

                            <div class="flex items-center justify-between rounded-2xl bg-[#faf7f5] px-4 py-3">
                                <span class="text-sm text-gray-500 font-semibold">Follow-Up Load</span>
                                <span class="badge-soft badge-amber">{{ $pendingFollowUps }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- PROCEDURES TAB --}}
        <section id="proceduresSection" {{ $reportType !== 'procedures' ? 'hidden' : '' }}>
            <div class="table-shell">
                <div class="table-head">
                    <div>
                        <h3 class="section-title">Procedure Report Details</h3>
                        <p class="section-subtitle">Expanded list of procedures and clinic activity counts</p>
                    </div>
                </div>

                <div class="table-wrap">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Procedure</th>
                                <th>Total Count</th>
                                <th>Percentage</th>
                                <th>Recommendation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($procedureBreakdown as $procedure)
                                @php
                                    $procName = $procedure->name ?? $procedure['name'] ?? 'Unnamed Procedure';
                                    $procCount = $procedure->count ?? $procedure['count'] ?? 0;
                                    $procPercent = $procedure->percentage ?? $procedure['percentage'] ?? '0%';
                                @endphp
                                <tr>
                                    <td class="font-semibold text-gray-800">{{ $procName }}</td>
                                    <td>{{ $procCount }}</td>
                                    <td>{{ $procPercent }}</td>
                                    <td>
                                        @if($procCount >= 10)
                                            <span class="badge-soft badge-green">High demand</span>
                                        @elseif($procCount >= 5)
                                            <span class="badge-soft badge-amber">Monitor volume</span>
                                        @else
                                            <span class="badge-soft badge-red">Low frequency</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty-state">No procedure report data available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- RECENT TAB --}}
        <section id="recentSection" {{ $reportType !== 'recent' ? 'hidden' : '' }}>
            <div class="table-shell">
                <div class="table-head">
                    <div>
                        <h3 class="section-title">Recent Dental Records</h3>
                        <p class="section-subtitle">Latest treatment entries included in reports</p>
                    </div>
                </div>

                <div class="table-wrap">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Procedure</th>
                                <th>Dentist</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentRecords as $record)
                                <tr>
                                    <td class="font-semibold text-gray-800">
                                        {{ $record->patient_name ?? $record['patient_name'] ?? 'Unknown Patient' }}
                                    </td>
                                    <td>
                                        {{ $record->procedure ?? $record['procedure'] ?? '—' }}
                                    </td>
                                    <td>
                                        {{ $record->dentist_name ?? $record['dentist_name'] ?? '—' }}
                                    </td>
                                    <td>
                                        {{ $record->date ?? $record['date'] ?? '—' }}
                                    </td>
                                    <td>
                                        @php
                                            $status = strtolower($record->status ?? $record['status'] ?? 'completed');
                                        @endphp

                                        @if($status === 'completed')
                                            <span class="badge-soft badge-green">Completed</span>
                                        @elseif($status === 'pending')
                                            <span class="badge-soft badge-amber">Pending</span>
                                        @else
                                            <span class="badge-soft badge-red">{{ ucfirst($status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-state">No recent dental records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>
</main>
@endsection

@section('scripts')
<script>
    function switchReportTab(tab) {
        const url = new URL(window.location.href);
        url.searchParams.set('report', tab);
        window.location.href = url.toString();
    }
</script>
@endsection