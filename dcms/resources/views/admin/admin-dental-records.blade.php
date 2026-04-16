@extends('layouts.admin')

@section('title', 'Dental Records | PUP Taguig Dental Clinic')

@section('styles')
<style>
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
        color: rgba(255, 255, 255, .68);
        margin-top: .4rem;
    }

    .banner-actions {
        display: flex;
        align-items: center;
        gap: .75rem;
        flex-wrap: wrap;
    }

    .manage-btn {
        background: rgba(255, 255, 255, .15);
        border: 1px solid rgba(255, 255, 255, .25);
        color: #fff;
        padding: .7rem 1.1rem;
        border-radius: 10px;
        font-size: .75rem;
        font-weight: 700;
        cursor: pointer;
        transition: all .15s;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        white-space: nowrap;
        text-decoration: none;
    }

    .manage-btn:hover {
        background: rgba(255, 255, 255, .25);
        transform: translateY(-1px);
    }

    .content-lift {
        margin-top: -2rem;
        padding: 0 1.75rem 2rem;
        position: relative;
        z-index: 2;
    }

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
        gap: .75rem;
        flex-wrap: wrap;
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
        white-space: nowrap;
    }

    .data-table tbody td {
        padding: .85rem 1rem;
        border-bottom: 1px solid #f9fafb;
        vertical-align: middle;
    }

    .data-table tbody tr:hover td {
        background: #fafafa;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .record-pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .28rem .6rem;
        border-radius: 999px;
        font-size: .68rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .record-pill-completed {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }

    .record-pill-pending {
        background: #fffbeb;
        color: #d97706;
        border: 1px solid #fde68a;
    }

    .record-pill-ongoing {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }

    .side-stack {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .quick-btn {
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
        text-decoration: none;
    }

    .quick-btn:last-child {
        margin-bottom: 0;
    }

    .quick-btn:hover {
        border-color: var(--crimson-mid);
        background: var(--crimson-light);
        transform: translateX(3px);
    }

    .quick-btn-icon {
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

    .quick-btn:hover .quick-btn-icon {
        background: var(--crimson);
        color: #fff;
    }

    .quick-btn-text {
        flex: 1;
    }

    .quick-btn-title {
        font-size: .8rem;
        font-weight: 700;
        color: var(--crimson);
        display: block;
    }

    .quick-btn-sub {
        font-size: .68rem;
        color: #9ca3af;
        display: block;
        margin-top: 1px;
    }

    .quick-btn-arrow {
        color: #d1d5db;
        font-size: .7rem;
        transition: all .15s;
    }

    .quick-btn:hover .quick-btn-arrow {
        color: var(--crimson);
    }

    .mini-insight {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        padding: .8rem .95rem;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: .7rem;
    }

    .mini-insight:last-child {
        margin-bottom: 0;
    }

    .mini-insight-label {
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #9ca3af;
    }

    .mini-insight-value {
        font-size: .95rem;
        font-weight: 900;
        color: #1f2937;
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
    }

    @media (max-width: 480px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }

        .stat-grid .stat-card:last-child {
            grid-column: span 1;
        }
    }

    [data-theme="dark"] .card,
    [data-theme="dark"] .stat-card {
        background: #161b22 !important;
        border-color: #21262d !important;
    }

    [data-theme="dark"] .card-header {
        background: #0d1117 !important;
        border-color: #21262d !important;
    }

    [data-theme="dark"] .stat-value,
    [data-theme="dark"] .card-title,
    [data-theme="dark"] .mini-insight-value {
        color: #f3f4f6;
    }

    [data-theme="dark"] .stat-label,
    [data-theme="dark"] .stat-footer,
    [data-theme="dark"] .mini-insight-label,
    [data-theme="dark"] .quick-btn-sub {
        color: #9ca3af;
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

    [data-theme="dark"] .quick-btn,
    [data-theme="dark"] .mini-insight {
        background: #1c2128;
        border-color: #21262d;
    }

    [data-theme="dark"] .quick-btn:hover {
        background: rgba(139, 0, 0, .15);
        border-color: #5b2020;
    }

    [data-theme="dark"] .empty-icon {
        background: #21262d;
    }
</style>
@endsection

@section('content')
@php
    use Carbon\Carbon;
@endphp

<main id="mainContent" style="padding-top: var(--header-h); min-height: 100vh;">

    <div class="page-banner">
        <div class="page-banner-inner">
            <div>
                <div class="page-greeting">
                    <i class="fa-solid fa-tooth" style="color:#fcd34d;"></i>
                    <span>Clinic Records Management</span>
                </div>
                <h1 class="page-title">Dental Records</h1>
                <p class="page-subtitle">Manage, review, and monitor patient dental treatment entries.</p>
            </div>

            <div class="banner-actions">
                <a href="{{ route('admin.dental-records.create') }}" class="manage-btn">
                    <i class="fa-solid fa-plus"></i> Add Record
                </a>
                <a href="{{ route('admin.reports.index') }}" class="manage-btn">
                    <i class="fa-solid fa-chart-column"></i> View Reports
                </a>
            </div>
        </div>
    </div>

    <div class="content-lift">

        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-card-accent" style="background: linear-gradient(90deg, var(--crimson), #c0392b);"></div>
                <div class="stat-top">
                    <div class="stat-icon" style="background:#fef2f2;">
                        <i class="fa-solid fa-folder-open" style="color:var(--crimson);"></i>
                    </div>
                    <span class="stat-badge" style="background:#fef2f2;color:var(--crimson);">All time</span>
                </div>
                <div class="stat-label">Total Records</div>
                <div class="stat-value">{{ number_format($totalRecords ?? 0) }}</div>
                <div class="stat-footer">
                    <i class="fa-solid fa-file-medical" style="font-size:.65rem;color:var(--crimson);"></i>
                    All encoded dental treatment records
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-accent" style="background: linear-gradient(90deg, #3b82f6, #2563eb);"></div>
                <div class="stat-top">
                    <div class="stat-icon" style="background:#eff6ff;">
                        <i class="fa-solid fa-calendar-day" style="color:#3b82f6;"></i>
                    </div>
                    <span class="stat-badge" style="background:#eff6ff;color:#3b82f6;">Today</span>
                </div>
                <div class="stat-label">Records Today</div>
                <div class="stat-value">{{ $recordsToday ?? 0 }}</div>
                <div class="stat-footer">
                    <i class="fa-solid fa-clock" style="font-size:.65rem;color:#3b82f6;"></i>
                    Newly added dental records today
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-accent" style="background: linear-gradient(90deg, #f59e0b, #d97706);"></div>
                <div class="stat-top">
                    <div class="stat-icon" style="background:#fffbeb;">
                        <i class="fa-solid fa-user-clock" style="color:#d97706;"></i>
                    </div>
                    <span class="stat-badge" style="background:#fffbeb;color:#d97706;">Follow-up</span>
                </div>
                <div class="stat-label">Pending Records</div>
                <div class="stat-value">{{ $pending ?? 0 }}</div>
                <div class="stat-footer">
                    <i class="fa-solid fa-bell" style="font-size:.65rem;color:#d97706;"></i>
                    Records with pending treatment status
                </div>
            </div>
        </div>

        <div class="main-grid">

            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-header-icon"><i class="fa-solid fa-notes-medical"></i></div>
                        <span class="card-title">All Dental Records</span>
                    </div>

                    <a href="{{ route('admin.dental-records.create') }}" class="card-link">
                        Add New <i class="fa-solid fa-arrow-right" style="font-size:.65rem;"></i>
                    </a>
                </div>

                @if(($records ?? collect())->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fa-solid fa-inbox"></i></div>
                        <p style="font-size:.82rem;font-weight:700;color:#6b7280;margin-bottom:.25rem;">
                            No dental records found
                        </p>
                        <p style="font-size:.72rem;color:#b0b7c3;">New records will appear here once added.</p>
                    </div>
                @else
                    <div style="overflow-x:auto;">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Procedure</th>
                                    <th>Dentist</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th style="text-align:right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($records as $record)
                                    @php
                                        $status = strtolower($record->status ?? 'pending');
                                        $statusClass = 'record-pill-pending';

                                        if ($status === 'completed') {
                                            $statusClass = 'record-pill-completed';
                                        } elseif ($status === 'ongoing') {
                                            $statusClass = 'record-pill-ongoing';
                                        }
                                    @endphp
                                    <tr>
                                        <td>
                                            <div style="font-size:.78rem;font-weight:700;color:#111827;">
                                                {{ $record->patient_name ?? 'Unknown Patient' }}
                                            </div>
                                        </td>
                                        <td>{{ $record->procedure ?? '—' }}</td>
                                        <td>{{ $record->dentist_name ?? '—' }}</td>
                                        <td>
                                            {{ !empty($record->date) ? Carbon::parse($record->date)->format('M d, Y') : '—' }}
                                        </td>
                                        <td>
                                            <span class="record-pill {{ $statusClass }}">
                                                <i class="fa-solid fa-circle" style="font-size:.45rem;"></i>
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td style="text-align:right;">
                                            @if(!empty($record->id))
                                                <a href="{{ route('admin.dental-records.show', $record->id) }}"
                                                   class="card-link"
                                                   style="display:inline-flex;">
                                                    View
                                                </a>
                                            @else
                                                <span style="font-size:.72rem;color:#9ca3af;">No action</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="side-stack">

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-header-icon"><i class="fa-solid fa-bolt"></i></div>
                            <span class="card-title">Quick Actions</span>
                        </div>
                    </div>

                    <div style="padding:1rem;">
                        <a href="{{ route('admin.dental-records.create') }}" class="quick-btn">
                            <div class="quick-btn-icon"><i class="fa-solid fa-plus"></i></div>
                            <div class="quick-btn-text">
                                <span class="quick-btn-title">Add Record</span>
                                <span class="quick-btn-sub">Create a new dental entry</span>
                            </div>
                            <i class="fa-solid fa-chevron-right quick-btn-arrow"></i>
                        </a>

                        <a href="{{ route('admin.reports.index') }}" class="quick-btn">
                            <div class="quick-btn-icon"><i class="fa-solid fa-chart-column"></i></div>
                            <div class="quick-btn-text">
                                <span class="quick-btn-title">Dental Reports</span>
                                <span class="quick-btn-sub">View analytics and summaries</span>
                            </div>
                            <i class="fa-solid fa-chevron-right quick-btn-arrow"></i>
                        </a>

                        <a href="{{ route('admin.appointments') }}" class="quick-btn">
                            <div class="quick-btn-icon"><i class="fa-solid fa-calendar-check"></i></div>
                            <div class="quick-btn-text">
                                <span class="quick-btn-title">Appointments</span>
                                <span class="quick-btn-sub">Check scheduled clinic visits</span>
                            </div>
                            <i class="fa-solid fa-chevron-right quick-btn-arrow"></i>
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-header-icon"><i class="fa-solid fa-chart-pie"></i></div>
                            <span class="card-title">Record Insights</span>
                        </div>
                    </div>

                    <div style="padding:1rem;">
                        <div class="mini-insight">
                            <div>
                                <div class="mini-insight-label">Most Common Procedure</div>
                                <div class="mini-insight-value">{{ $topProcedure ?? 'No data yet' }}</div>
                            </div>
                            <i class="fa-solid fa-tooth" style="color:var(--crimson);"></i>
                        </div>

                        <div class="mini-insight">
                            <div>
                                <div class="mini-insight-label">Completed This Week</div>
                                <div class="mini-insight-value">{{ $completedThisWeek ?? 0 }}</div>
                            </div>
                            <i class="fa-solid fa-circle-check" style="color:#16a34a;"></i>
                        </div>

                        <div class="mini-insight">
                            <div>
                                <div class="mini-insight-label">Patients For Follow-Up</div>
                                <div class="mini-insight-value">{{ $patientsForFollowUp ?? 0 }}</div>
                            </div>
                            <i class="fa-solid fa-user-clock" style="color:#d97706;"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection