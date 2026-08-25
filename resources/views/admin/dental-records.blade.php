@extends('layouts.app')

@section('layout-role', $layoutRole ?? 'admin')

@section('title', 'Dental Records')

@section('content')

@php
use Carbon\Carbon;

$recordsSource =
$records ?? collect();

$recordItems =
$recordsSource instanceof
\Illuminate\Pagination\AbstractPaginator
? collect(
$recordsSource->items()
)
: collect(
$recordsSource
);

$totalRecordsCount =
$totalRecords ??
(
$recordsSource instanceof
\Illuminate\Pagination\AbstractPaginator
? $recordsSource->total()
: $recordItems->count()
);

$recordsTodayCount =
$recordsToday ?? 0;

$pendingCount =
$pending ??
$recordItems
->filter(
fn ($record) =>
strtolower(
trim(
$record->status ??
'pending'
)
) === 'pending'
)
->count();

$recordPaginationMeta =
$recordsSource instanceof
\Illuminate\Pagination\AbstractPaginator
? [
'current_page' =>
$recordsSource->currentPage(),

'last_page' =>
$recordsSource->lastPage(),

'total' =>
$recordsSource->total(),

'from' =>
$recordsSource->firstItem(),

'to' =>
$recordsSource->lastItem(),
]
: null;

$recordPerPage =
$recordsSource instanceof
\Illuminate\Pagination\AbstractPaginator
? $recordsSource->perPage()
: 10;

$recordAppliedStatus =
request(
'status',
'all'
);
@endphp

<main id="mainContent" class="admin-page-shell admin-dental-records-page page-enter mode-list">
    <div class="w-full">

        <div class="page-banner mt-2 mb-6">
            <div class="page-banner-inner">
                <div>
                    <h1 class="page-title">Dental Records</h1>
                </div>

                <div class="flex items-center gap-3 flex-shrink-0">
                    <span class="page-badge">
                        <span class="page-badge-dot"></span>
                        {{ number_format($totalRecordsCount) }}
                        {{ \Illuminate\Support\Str::plural('record', $totalRecordsCount) }}
                    </span>

                    <a href="{{ route('admin.reports.index') }}" class="ui-btn ui-btn-primary">
                        <i class="fa-solid fa-chart-column"></i>
                        <span>View Reports</span>
                    </a>
                </div>
            </div>
        </div>

        <div id="statCards" class="stat-grid admin-dashboard-stat-grid dental-records-stat-grid">
            <div class="stat-card s-all">
                <div class="stat-card-info">
                    <div class="stat-label">Total Records</div>
                    <div class="stat-num">{{ number_format($totalRecordsCount) }}</div>
                    <div class="stat-footer">all dental records</div>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-folder-open"></i></div>
            </div>

            <div class="stat-card s-today">
                <div class="stat-card-info">
                    <div class="stat-label">Added Today</div>
                    <div class="stat-num">{{ number_format($recordsTodayCount) }}</div>
                    <div class="stat-footer">new entries</div>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-calendar-day"></i></div>
            </div>

            <div class="stat-card s-pending">
                <div class="stat-card-info">
                    <div class="stat-label">Pending Records</div>
                    <div class="stat-num">{{ number_format($pendingCount) }}</div>
                    <div class="stat-footer">needs action</div>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-user-clock"></i></div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[minmax(0,1fr)_380px] gap-5 items-start">
            <section class="table-card dental-records-main-card">

                <div class="patient-table-toolbar record-toolbar px-4 md:px-6 py-4 border-b border-gray-100">
                    <div class="record-toolbar-layout">
                        <span id="recordRowCount" class="sr-only">
                            {{ $recordItems->count() }} records
                        </span>

                        @php
                        $recordAllCount = $totalRecordsCount;
                        $recordTodayCount = $recordsTodayCount ?? 0;
                        $recordPendingCount = $pendingCount ?? 0;
                        $recordOngoingCount = $ongoingCount ?? $recordItems->where('status', 'ongoing')->count();
                        $recordCompletedCount = $completedCount ?? $recordItems->where('status',
                        'completed')->count();
                        $recordCancelledCount = $cancelledCount ?? $recordItems->where('status',
                        'cancelled')->count();
                        @endphp

                        <x-filter-select id="recordStatusFilter" label="Sort By" value="{{ request('status', 'all') }}"
                            callback="handleDentalRecordStatusFilter" icon="fa-layer-group" :options="[
                                [
                                    'value' => 'all',
                                    'label' => 'All Records',
                                    'icon' => 'fa-layer-group',
                                    'tone' => 'status-all',
                                    'count' => $recordAllCount,
                                ],

                                [
                                    'value' => 'today',
                                    'label' => 'Added Today',
                                    'icon' => 'fa-clock',
                                    'tone' => 'status-today',
                                    'count' => $recordTodayCount,
                                ],

                                [
                                    'value' => 'pending',
                                    'label' => 'Pending',
                                    'icon' => 'fa-user-clock',
                                    'tone' => 'status-pending',
                                    'count' => $recordPendingCount,
                                ],

                                [
                                    'value' => 'ongoing',
                                    'label' => 'Ongoing',
                                    'icon' => 'fa-spinner',
                                    'tone' => 'status-ongoing',
                                    'count' => $recordOngoingCount,
                                ],

                                [
                                    'value' => 'completed',
                                    'label' => 'Completed',
                                    'icon' => 'fa-check-double',
                                    'tone' => 'status-completed',
                                    'count' => $recordCompletedCount,
                                ],

                                [
                                    'value' => 'cancelled',
                                    'label' => 'Cancelled',
                                    'icon' => 'fa-calendar-xmark',
                                    'tone' => 'status-cancelled',
                                    'count' => $recordCancelledCount,
                                ],
                            ]" />

                        <div class="record-toolbar-actions">
                            <div class="record-search-row voice-search-row">

                                <x-search-bar id="dentalRecordSearch" placeholder="Search patient name..." type="search"
                                    clear-label="Clear dental record search" class="flex-1" />

                                <x-voice-input target="#dentalRecordSearch" status-id="dentalRecordVoiceStatus"
                                    label="Voice search dental records" title="Voice search" />

                            </div>

                            <x-view-toggle id="dentalRecordViewToggle" root="#mainContent"
                                storage-key="admin_dental_records_view" list-view="#dentalRecordListView"
                                grid-view="#dentalRecordGridView" list-label="List" grid-label="Grid"
                                class="record-view-toggle" />
                        </div>
                    </div>
                </div>

                @if (
                $recordsSource instanceof
                \Illuminate\Pagination\AbstractPaginator
                )
                <x-pagination-bar id="dentalRecordsPagebarTop" info-id="dentalRecordsPageInfoTop"
                    pagination-id="dentalRecordsPaginationTop" position="top" :show-entries="true"
                    page-size-id="dentalRecordsPageSize" page-size-callback="changeDentalRecordsPageSize"
                    :page-size-value="$recordPerPage" label="records" />
                @endif

                <div id="dentalRecordsResultsRegion">
                    @if ($recordItems->isEmpty())
                    <div id="dentalRecordEmptyState" class="empty-state-host show"></div>
                    @else
                    <div id="dentalRecordListView" class="table-list-view table-scroll">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Procedure</th>
                                    <th>Dentist</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th class="table-cell-center">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="dentalRecordsTableBody">
                                @foreach ($recordsSource as $record)
                                @php
                                $rawStatus = strtolower(trim($record->status ?? 'pending'));
                                $normalizedStatus = str_replace([' ', '_'], '-', $rawStatus);
                                $statusClass = match ($normalizedStatus) {
                                'completed' => 'status-completed',
                                'ongoing', 'in-progress' => 'status-ongoing',
                                'cancelled', 'canceled' => 'status-cancelled',
                                default => 'status-pending',
                                };
                                $patientName =
                                $record->patient_name ??
                                (data_get($record, 'patient.name') ??
                                (data_get($record, 'patient.full_name') ?? 'Unknown Patient'));
                                $dentistName =
                                $record->dentist_name ??
                                (data_get($record, 'dentist.name') ??
                                (data_get($record, 'dentist.full_name') ?? '—'));
                                $procedure = $record->procedure ?? '—';
                                $recordDate = null;

                                if (!empty($record->date)) {
                                try {
                                $recordDate =
                                Carbon::parse(
                                $record->date
                                );
                                } catch (\Throwable $e) {
                                $recordDate = null;
                                }
                                }

                                $dateText =
                                $recordDate
                                ? $recordDate->format(
                                'M d, Y'
                                )
                                : '—';

                                $dateIso =
                                $recordDate
                                ? $recordDate->toDateString()
                                : '';
                                $initial = strtoupper(substr($patientName, 0, 1));
                                @endphp

                                <tr class="dental-record-row dental-record-item"
                                    data-patient="{{ strtolower($patientName) }}"
                                    data-procedure="{{ strtolower($procedure) }}"
                                    data-dentist="{{ strtolower($dentistName) }}" data-status="{{ $normalizedStatus }}"
                                    data-date="{{ $dateIso }}" @if (!empty($record->id)) onclick="openRecordPanel({{
                                    $record->id }})" @endif>
                                    <td class="table-cell-main">
                                        <div class="table-primary">
                                            <div class="patient-avatar patient-avatar-sm">
                                                <span>
                                                    {{ $initial }}
                                                </span>
                                            </div>
                                            <div class="dental-record-patient-copy">
                                                <strong class="dental-record-patient-name" data-patient-name>
                                                    {{ $patientName }}
                                                </strong>

                                                <span class="dental-record-patient-sub">
                                                    Dental record
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-cell-main">
                                        {{ $procedure }}
                                    </td>
                                    <td>
                                        {{ $dentistName }}
                                    </td>
                                    <td>
                                        <span class="table-primary">
                                            <i class="fa-solid fa-calendar-day"></i>
                                            <span>{{ $dateText }}</span>
                                        </span>
                                    </td>
                                    <td class="table-cell-main">
                                        <span class="status-pill {{ $statusClass }}">
                                            <span class="status-dot"></span>
                                            {{ ucfirst(str_replace('-', ' ', $normalizedStatus)) }}
                                        </span>
                                    </td>
                                    <td class="table-action-cell">
                                        <div class="ui-action-group">
                                            @if (!empty($record->id))
                                            <button type="button" class="ui-action-btn ui-action-view"
                                                onclick="event.stopPropagation(); openRecordPanel({{ $record->id }})"
                                                aria-label="View record" data-tooltip="View record">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div id="dentalRecordGridView" class="table-record-grid dental-record-grid-view" hidden>
                        @foreach ($recordsSource as $record)
                        @php
                        $rawStatus = strtolower(
                        trim(
                        $record->status ?? 'pending'
                        )
                        );

                        $normalizedStatus = str_replace(
                        [' ', '_'],
                        '-',
                        $rawStatus
                        );

                        $statusClass = match ($normalizedStatus) {
                        'completed' =>
                        'status-completed',

                        'ongoing',
                        'in-progress' =>
                        'status-ongoing',

                        'cancelled',
                        'canceled' =>
                        'status-cancelled',

                        default =>
                        'status-pending',
                        };

                        $patientName =
                        $record->patient_name
                        ?? data_get(
                        $record,
                        'patient.name'
                        )
                        ?? data_get(
                        $record,
                        'patient.full_name'
                        )
                        ?? 'Unknown Patient';

                        $dentistName =
                        $record->dentist_name
                        ?? data_get(
                        $record,
                        'dentist.name'
                        )
                        ?? data_get(
                        $record,
                        'dentist.full_name'
                        )
                        ?? '—';

                        $procedure =
                        $record->procedure ?? '—';

                        $recordDate = null;

                        if (!empty($record->date)) {
                        try {
                        $recordDate =
                        Carbon::parse(
                        $record->date
                        );
                        } catch (\Throwable $e) {
                        $recordDate = null;
                        }
                        }

                        $dateText =
                        $recordDate
                        ? $recordDate->format(
                        'M d, Y'
                        )
                        : '—';

                        $dateIso =
                        $recordDate
                        ? $recordDate->toDateString()
                        : '';

                        $initial =
                        strtoupper(
                        substr(
                        $patientName,
                        0,
                        1
                        )
                        );
                        @endphp

                        <article class="table-record-card dental-record-grid-card dental-record-item"
                            data-patient="{{ strtolower($patientName) }}" data-procedure="{{ strtolower($procedure) }}"
                            data-dentist="{{ strtolower($dentistName) }}" data-status="{{ $normalizedStatus }}"
                            data-date="{{ $dateIso }}" @if (!empty($record->id))
                            onclick="openRecordPanel({{ $record->id }})"
                            @endif
                            >
                            <div class="table-record-card-layout">

                                <div class="table-record-content">

                                    <div class="table-record-header">

                                        <div class="table-primary">

                                            <div class="patient-avatar patient-avatar-md">
                                                <span>
                                                    {{ $initial }}
                                                </span>
                                            </div>

                                            <div class="dental-record-patient-copy">
                                                <h3 class="table-record-title" data-patient-name>
                                                    {{ $patientName }}
                                                </h3>

                                                <span class="dental-record-patient-sub">
                                                    Dental record
                                                </span>
                                            </div>

                                        </div>

                                        <span class="status-pill {{ $statusClass }}">
                                            <span class="status-dot"></span>

                                            {{
                                            ucfirst(
                                            str_replace(
                                            '-',
                                            ' ',
                                            $normalizedStatus
                                            )
                                            )
                                            }}
                                        </span>

                                    </div>


                                    <div class="table-record-meta">

                                        <div class="table-record-row">
                                            <span class="table-record-label">
                                                Procedure
                                            </span>

                                            <span class="table-record-value">
                                                {{ $procedure }}
                                            </span>
                                        </div>

                                        <div class="table-record-row">
                                            <span class="table-record-label">
                                                Dentist
                                            </span>

                                            <span class="table-record-value">
                                                {{ $dentistName }}
                                            </span>
                                        </div>

                                        <div class="table-record-row">
                                            <span class="table-record-label">
                                                Date
                                            </span>

                                            <span class="table-record-value">
                                                <i class="fa-solid fa-calendar-day"></i>
                                                {{ $dateText }}
                                            </span>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </article>
                        @endforeach
                    </div>
                    <div id="dentalRecordEmptyState" class="empty-state-host"></div>
                    @endif
                </div>

                @if (
                $recordsSource instanceof
                \Illuminate\Pagination\AbstractPaginator
                )
                <x-pagination-bar id="dentalRecordsPagebarBottom" info-id="dentalRecordsPageInfoBottom"
                    pagination-id="dentalRecordsPaginationBottom" position="bottom" :show-entries="false"
                    :page-size-value="$recordPerPage" label="records" />
                @endif
            </section>

            <aside class="space-y-5">
                <section class="table-card dental-record-panel">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div
                            class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#8B0000] to-[#6b0000] text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                            <i class="fa-solid fa-notes-medical"></i>
                        </div>
                        <div class="min-w-0">
                            <h2 id="panelRecordTitle" class="text-sm font-black text-gray-800 truncate">Select a
                                record</h2>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Dental Record</p>
                        </div>
                    </div>

                    <div id="panelBody" class="p-5">
                        <div class="text-center py-8">
                            <div class="empty-state-icon !w-[64px] !h-[64px] !rounded-2xl !mb-4">
                                <i class="fa-solid fa-notes-medical !text-[26px]"></i>
                            </div>
                            <h3 class="empty-state-title !text-[15px]">No record selected</h3>
                            <p class="empty-state-sub !text-[13px] !mt-2">Click a row to view the record details.</p>
                        </div>
                    </div>

                    <div id="panelFoot" class="hidden px-5 py-4 border-t border-gray-100 bg-gray-50 flex-wrap gap-2">
                    </div>
                </section>

                <section class="table-card rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                        <div
                            class="dental-req-quick-actions-icon w-10 h-10 rounded-2xl bg-red-50 text-[#8B0000] border border-red-100 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <div>
                            <h2 class="text-sm font-black text-gray-800">Record Insights</h2>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Summary statistics
                            </p>
                        </div>
                    </div>

                    <div class="record-insights-list">
                        <div class="record-insight-row px-5 py-4 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <div class="text-[11px] font-black uppercase tracking-wider text-gray-400">Most Common
                                    Procedure</div>
                                <div class="text-sm font-black text-gray-800 truncate">
                                    {{ $topProcedure ?? 'No data yet' }}</div>
                            </div>
                            <span class="status-pill status-default"><i class="fa-solid fa-tooth"></i></span>
                        </div>

                        <div class="record-insight-row px-5 py-4 flex items-center justify-between gap-3">
                            <div>
                                <div class="text-[11px] font-black uppercase tracking-wider text-gray-400">Completed
                                    This Week</div>
                                <div class="text-sm font-black text-gray-800">
                                    {{ number_format($completedThisWeek ?? 0) }}</div>
                            </div>
                            <span class="status-pill status-completed"><i class="fa-solid fa-circle-check"></i></span>
                        </div>

                        <div class="record-insight-row px-5 py-4 flex items-center justify-between gap-3">
                            <div>
                                <div class="text-[11px] font-black uppercase tracking-wider text-gray-400">Patients For
                                    Follow-Up</div>
                                <div class="text-sm font-black text-gray-800">
                                    {{ number_format($patientsForFollowUp ?? 0) }}</div>
                            </div>
                            <span class="status-pill status-pending"><i class="fa-solid fa-user-clock"></i></span>
                        </div>
                    </div>
                </section>

                <section class="card quick-actions-card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-header-icon">
                                <i class="fa-solid fa-bolt"></i>
                            </div>

                            <div>
                                <h2 class="card-title">
                                    Quick Actions
                                </h2>

                                <p class="card-subtitle">
                                    Common tasks
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="quick-actions-list">
                        <a href="{{ route('admin.reports.index') }}" class="quick-action quick-action-card">
                            <span class="quick-action-icon">
                                <i class="fa-solid fa-chart-column"></i>
                            </span>

                            <span class="quick-action-copy">
                                <span class="quick-action-title">Reports</span>
                                <span class="quick-action-sub">View analytics and summaries</span>
                            </span>

                            <i class="fa-solid fa-chevron-right quick-action-arrow"></i>
                            <i class="fa-solid fa-chart-column quick-action-bg-icon"></i>
                        </a>

                        <a href="{{ route('admin.appointments') }}" class="quick-action quick-action-card">
                            <span class="quick-action-icon">
                                <i class="fa-solid fa-calendar-check"></i>
                            </span>

                            <span class="quick-action-copy">
                                <span class="quick-action-title">Appointments</span>
                                <span class="quick-action-sub">Check scheduled clinic visits</span>
                            </span>

                            <i class="fa-solid fa-chevron-right quick-action-arrow"></i>
                            <i class="fa-solid fa-calendar-check quick-action-bg-icon"></i>
                        </a>
                    </div>
                </section>
            </aside>
        </div>
    </div>
</main>

<div id="dentalRecordDetailsModal" class="ui-modal" role="dialog" aria-modal="true"
    aria-labelledby="dentalRecordDetailsModalTitle">
    <div class="ui-modal-card record-modal-wide">
        <div class="modal-hd appointment-modal-header">
            <div class="modal-heading">
                <div class="appointment-modal-header-icon">
                    <i class="fa-solid fa-notes-medical"></i>
                </div>
                <div class="appointment-modal-header-copy">
                    <span class="appointment-modal-eyebrow">Dental Record Details</span>
                    <h3 id="dentalRecordDetailsModalTitle" class="appointment-modal-title">Patient Record</h3>
                </div>
            </div>
            <button type="button" class="modal-x" onclick="closeDentalRecordDetailsModal()"
                aria-label="Close dental record details">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div id="dentalRecordDetailsModalBody" class="modal-bd">
            <div class="text-center py-8">
                <div class="empty-state-icon !w-[64px] !h-[64px] !rounded-2xl !mb-4">
                    <i class="fa-solid fa-notes-medical !text-[26px]"></i>
                </div>
                <h3 class="empty-state-title !text-[15px]">Select a dental record</h3>
                <p class="empty-state-sub !text-[13px] !mt-2">The full answered patient form will appear here.</p>
            </div>
        </div>

        <div class="modal-ft">
            <button type="button" class="btn-close-modal" onclick="closeDentalRecordDetailsModal()">
                Close
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.content : '';

    let dentalRecordsLoading = false;
    let dentalRecordsSearchTimer = null;

    let dentalRecordsPerPage =
        Number(
            @json($recordPerPage)
        ) || 10;

    let dentalRecordsStatus =
        @json($recordAppliedStatus);

    function escapeHtml(value) {
        return String(value ?? '—')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function normalizeStatus(value) {
        return String(value || 'pending').trim().toLowerCase().replace(/[\s_]+/g, '-');
    }

    function statusPillClass(status) {
        const normalized = normalizeStatus(status);
        if (normalized === 'completed') return 'status-completed';
        if (normalized === 'ongoing' || normalized === 'in-progress') return 'status-ongoing';
        if (normalized === 'cancelled' || normalized === 'canceled') return 'status-cancelled';
        return 'status-pending';
    }

    function statusLabel(status) {
        const normalized = normalizeStatus(status);
        return normalized
            .split('-')
            .map(part => part.charAt(0).toUpperCase() + part.slice(1))
            .join(' ');
    }

    function detailRow(label, value) {
        const normalizedValue =
            escapeHtml(value || '—')
                .replace(/\n/g, '<br>');

        return `
            <div class="flex items-start gap-3 py-2 border-b border-gray-100 last:border-0">
                <span class="w-28 flex-shrink-0 text-[11px] font-black uppercase tracking-wider text-gray-400">${escapeHtml(label)}</span>
                <span class="min-w-0 text-sm font-bold text-gray-800 break-words">${normalizedValue}</span>
            </div>`;
    }

    function profileInfoRow(item = {}) {
        const icon = item.icon || 'fa-regular fa-circle';
        const label = item.label || 'Item';
        const value = item.value || 'N/A';

        return `
            <div class="global-info-item global-info-item-compact">
                <span class="global-info-icon status-default">
                    <i class="${escapeHtml(icon)}"></i>
                </span>
                <div class="global-info-copy min-w-0">
                    <span class="global-info-label">${escapeHtml(label)}</span>
                    <strong class="global-info-value break-words">${escapeHtml(value)}</strong>
                </div>
            </div>`;
    }

    function reviewRow(label, value) {
        const hasValue =
            value &&
            String(value).trim() !== '';

        const normalizedValue =
            hasValue
                ? escapeHtml(String(value)).replace(/\n/g, '<br>')
                : '<span class="booking-summary-muted">N/A</span>';

        return `
            <p class="booking-summary-row">
                <span class="booking-summary-row-label">
                    ${escapeHtml(label)}:
                </span>
                ${normalizedValue}
            </p>`;
    }

    function reviewSubSection(title, rows = []) {
        if (!Array.isArray(rows) || rows.length === 0) {
            return '';
        }

        return `
            <section class="booking-summary-section">
                <div class="booking-summary-section-title">
                    ${escapeHtml(title)}
                </div>
                <div class="booking-summary-section-body">
                    <div class="grid grid-cols-1 gap-x-8 gap-y-1 sm:grid-cols-2">
                        ${rows.map(item => reviewRow(item.label, item.value)).join('')}
                    </div>
                </div>
            </section>`;
    }

    function reviewFullWidthSection(title, rows = []) {
        if (!Array.isArray(rows) || rows.length === 0) {
            return '';
        }

        return `
            <section class="booking-summary-section">
                <div class="booking-summary-section-title">
                    ${escapeHtml(title)}
                </div>
                <div class="booking-summary-section-body">
                    <div class="grid grid-cols-1 gap-y-1">
                        ${rows.map(item => reviewRow(item.label, item.value)).join('')}
                    </div>
                </div>
            </section>`;
    }

    function recordSummaryCard(title, icon, body) {
        return `
            <section class="booking-summary-card">
                <div class="booking-summary-card-header flex items-center justify-between gap-4 w-full">
                    <div class="flex items-center gap-2 min-w-0">
                        <i class="fa-solid ${escapeHtml(icon)}"></i>
                        <span>${escapeHtml(title)}</span>
                    </div>
                </div>
                <div class="booking-summary-card-body">
                    ${body}
                </div>
            </section>`;
    }

    function renderPatientInformationCard(profileFields = []) {
        if (!Array.isArray(profileFields) || profileFields.length === 0) {
            return '';
        }

        return recordSummaryCard(
            'Patient Information',
            'fa-user',
            `
                <div class="grid grid-cols-1 gap-y-1 sm:grid-cols-2 sm:gap-x-8">
                    ${profileFields.map(item => reviewRow(item.label || 'Field', item.value || 'N/A')).join('')}
                </div>
            `
        );
    }

    function renderRecordSection(section = {}) {
        if (Array.isArray(section.groups) && section.groups.length > 0) {
            const body = section.groups
                .map(group => reviewSubSection(group.title || 'Section', Array.isArray(group.rows) ? group.rows : []))
                .filter(Boolean)
                .join('');

            return recordSummaryCard(section.title || 'Record Section', section.icon || 'fa-regular fa-circle', body);
        }

        if (Array.isArray(section.rows) && section.rows.length > 0) {
            return recordSummaryCard(
                section.title || 'Record Section',
                section.icon || 'fa-regular fa-circle',
                reviewFullWidthSection('Details', section.rows)
            );
        }

        return '';
    }

    function openDentalRecordDetailsModal() {
        const modal = document.getElementById('dentalRecordDetailsModal');

        if (!modal) {
            return;
        }

        modal.classList.remove('closing');
        modal.classList.add('open');
        document.documentElement.classList.add('modal-lock');
        document.body.classList.add('modal-lock');
    }

    function closeDentalRecordDetailsModal() {
        const modal = document.getElementById('dentalRecordDetailsModal');

        if (!modal || !modal.classList.contains('open')) {
            return;
        }

        modal.classList.add('closing');

        setTimeout(() => {
            modal.classList.remove('open', 'closing');
            document.documentElement.classList.remove('modal-lock');
            document.body.classList.remove('modal-lock');
        }, 160);
    }

    function setDentalRecordDetailsModalData(data) {
        const title = document.getElementById('dentalRecordDetailsModalTitle');
        const body = document.getElementById('dentalRecordDetailsModalBody');

        if (!title || !body) {
            return;
        }

        title.textContent = `${data.patient_name || 'Patient'} Record`;

        const sections = Array.isArray(data.record_sections) ? data.record_sections : [];
        const profileFields = Array.isArray(data.profile_fields) ? data.profile_fields : [];

        body.innerHTML = `
            <div class="booking-step-header">
                <p class="booking-step-eyebrow">Admin Dental Record Review</p>
                <h2 class="booking-step-title">Review Your Information</h2>
                <p class="booking-step-subtitle">
                    Please review the patient's recorded dental, medical, and appointment information.
                </p>
            </div>

            <div class="space-y-4">
                ${renderPatientInformationCard(profileFields)}
                ${sections.map(section => renderRecordSection(section)).filter(Boolean).join('')}
            </div>`;
    }

    function initDentalRecordDetailsModal() {
        const modal = document.getElementById('dentalRecordDetailsModal');
        const card = modal?.querySelector('.ui-modal-card');

        if (!modal || modal.dataset.initialized === 'true') {
            return;
        }

        modal.dataset.initialized = 'true';

        modal.addEventListener('click', event => {
            if (card && !card.contains(event.target)) {
                closeDentalRecordDetailsModal();
            }
        });

        document.addEventListener('keydown', event => {
            if (event.key === 'Escape' && modal.classList.contains('open')) {
                closeDentalRecordDetailsModal();
            }
        });
    }

    async function openRecordPanel(id) {
        const title = document.getElementById('panelRecordTitle');
        const panelBody = document.getElementById('panelBody');
        const panelFoot = document.getElementById('panelFoot');

        if (!title || !panelBody || !panelFoot) return;

        title.textContent = 'Loading...';
        panelBody.innerHTML = `
            <div class="text-center py-10 text-gray-300">
                <i class="fa-solid fa-spinner fa-spin text-2xl"></i>
            </div>`;
        panelFoot.classList.add('hidden');
        panelFoot.classList.remove('flex');
        panelFoot.innerHTML = '';

        try {
            const res = await fetch(`/admin/dental-records/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (!res.ok) throw new Error('Failed to fetch record.');

            const data = await res.json();
            const status = normalizeStatus(data.status);
            const patientName = data.patient_name || 'Record Details';
            const initial = (patientName.charAt(0) || '?').toUpperCase();

            title.textContent =
                window.formatPatientName?.(patientName) ||
                patientName;

            panelBody.innerHTML = `
                <div class="rounded-2xl border border-red-100 bg-red-50/70 p-4 mb-4 flex items-center gap-3">
                    <div class="patient-avatar patient-avatar-md">
                        <span>
                            ${escapeHtml(initial)}
                        </span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-sm font-black text-gray-900 truncate"
                            data-patient-name>
                            ${escapeHtml(patientName)}
                        </div>
                        <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Selected record</div>
                    </div>
                    <span class="status-pill ${statusPillClass(status)}">
                        <span class="status-dot"></span>
                        ${escapeHtml(statusLabel(status))}
                    </span>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white px-4 py-4">
                    <div class="global-info-grid">
                        ${(data.profile_fields || []).map(item => profileInfoRow(item)).join('')}
                    </div>
                </div>`;

            window.currentDentalRecordData = data;
            setDentalRecordDetailsModalData(data);

            panelFoot.classList.remove('hidden');
            panelFoot.classList.add('flex');
            panelFoot.innerHTML = `
                <button type="button" class="ui-btn ui-btn-primary ui-btn-block" onclick="openDentalRecordDetailsModal()">
                    <i class="fa-solid fa-eye"></i>
                    <span>View Record Details</span>
                </button>`;
        } catch (error) {
            panelBody.innerHTML = `
                <div class="text-center py-8">
                    <div class="empty-state-icon !w-[64px] !h-[64px] !rounded-2xl !mb-4">
                        <i class="fa-solid fa-triangle-exclamation !text-[26px]"></i>
                    </div>
                    <h3 class="empty-state-title !text-[15px]">Failed to load details</h3>
                    <p class="empty-state-sub !text-[13px] !mt-2">Please try opening the record again.</p>
                </div>`;
        }
    }

    function todayIso() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function updateDentalRecordsPagination(
        pagination
    ) {
        if (!pagination) {
            return;
        }

        const pagebars = [
            document.getElementById(
                'dentalRecordsPagebarTop'
            ),
            document.getElementById(
                'dentalRecordsPagebarBottom'
            ),
        ].filter(Boolean);

        const infoElements = [
            document.getElementById(
                'dentalRecordsPageInfoTop'
            ),
            document.getElementById(
                'dentalRecordsPageInfoBottom'
            ),
        ].filter(Boolean);

        const paginationHosts = [
            document.getElementById(
                'dentalRecordsPaginationTop'
            ),
            document.getElementById(
                'dentalRecordsPaginationBottom'
            ),
        ].filter(Boolean);


        window.renderGlobalPagination?.({
            currentPage:
                pagination.current_page,

            lastPage:
                pagination.last_page,

            total:
                pagination.total,

            from:
                pagination.from,

            to:
                pagination.to,

            containers:
                paginationHosts,

            infoElements:
                infoElements,

            bars:
                pagebars,

            itemLabel:
                'records',

            onPageChange(page) {
                loadDentalRecordsPage(
                    page
                );
            },
        });
    }

    function updateDentalRecordFilterCounts(
        counts = {}
    ) {
        const root =
            document.getElementById(
                'recordStatusFilter'
            );

        if (!root) {
            return;
        }

        const normalized = {
            all:
                Number(counts.all) || 0,

            today:
                Number(counts.today) || 0,

            pending:
                Number(counts.pending) || 0,

            ongoing:
                Number(counts.ongoing) || 0,

            completed:
                Number(counts.completed) || 0,

            cancelled:
                Number(counts.cancelled) || 0,
        };


        root
            .querySelectorAll(
                '[data-filter-select-option]'
            )
            .forEach(option => {
                const value =
                    option.dataset.value;

                if (
                    !Object.prototype
                        .hasOwnProperty.call(
                            normalized,
                            value
                        )
                ) {
                    return;
                }

                const count =
                    normalized[value];

                option.dataset.count =
                    String(count);

                const countElement =
                    option.querySelector(
                        '.global-filter-select-option-count'
                    );

                if (countElement) {
                    countElement.textContent =
                        String(count);
                }
            });


        const selectedOption =
            root.querySelector(
                `[data-filter-select-option][data-value="${dentalRecordsStatus}"]`
            );

        const triggerCount =
            root.querySelector(
                '[data-filter-select-count]'
            );

        if (
            selectedOption &&
            triggerCount
        ) {
            const count =
                normalized[
                dentalRecordsStatus
                ] ?? normalized.all;

            triggerCount.textContent =
                String(count);

            triggerCount.classList.remove(
                'hidden'
            );
        }
    }

    function renderDentalRecordsEmptyState() {
        const host =
            document.getElementById(
                'dentalRecordEmptyState'
            );

        if (!host) {
            return;
        }

        const hasRenderedResults =
            (
                document.querySelectorAll(
                    '#dentalRecordsTableBody tr'
                ).length > 0
            ) ||
            (
                document.querySelectorAll(
                    '#dentalRecordGridView .dental-record-item'
                ).length > 0
            );

        if (hasRenderedResults) {
            host.innerHTML = '';
            host.classList.remove(
                'show'
            );

            return;
        }

        const searchInput =
            document.getElementById(
                'dentalRecordSearch'
            );

        const query =
            String(
                searchInput?.value || ''
            ).trim();


        if (query) {
            window.EmptyState?.renderSearch({
                host,

                input:
                    '#dentalRecordSearch',

                query,

                message:
                    'Try another patient name, procedure, dentist, or status.',
            });

            return;
        }


        if (
            dentalRecordsStatus !==
            'all'
        ) {
            const states = {
                today: {
                    icon:
                        'fa-clock',

                    title:
                        'No records added today',

                    message:
                        'Dental records created today will appear here.',
                },

                pending: {
                    icon:
                        'fa-user-clock',

                    title:
                        'No pending dental records',

                    message:
                        'Pending dental records will appear here once available.',
                },

                ongoing: {
                    icon:
                        'fa-spinner',

                    title:
                        'No ongoing dental records',

                    message:
                        'Ongoing dental procedures will appear here once started.',
                },

                completed: {
                    icon:
                        'fa-check-double',

                    title:
                        'No completed dental records',

                    message:
                        'Completed dental records will appear here once finalized.',
                },

                cancelled: {
                    icon:
                        'fa-calendar-xmark',

                    title:
                        'No cancelled dental records',

                    message:
                        'Cancelled dental records will appear here once available.',
                },
            };

            const copy =
                states[
                dentalRecordsStatus
                ] || {
                    icon:
                        'fa-sliders',

                    title:
                        'No matching dental records',

                    message:
                        'Try another record status.',
                };


            window.EmptyState?.render({
                host,

                icon:
                    copy.icon,

                title:
                    copy.title,

                message:
                    copy.message,
            });

            return;
        }


        window.EmptyState?.render({
            host,

            icon:
                'fa-notes-medical',

            title:
                'No dental records found',

            message:
                'New records will appear here once they are added.',
        });
    }

    async function loadDentalRecordsPage(
        page = 1
    ) {
        if (dentalRecordsLoading) {
            return;
        }

        dentalRecordsLoading = true;

        const searchInput =
            document.getElementById(
                'dentalRecordSearch'
            );

        const pagebars = [
            document.getElementById(
                'dentalRecordsPagebarTop'
            ),
            document.getElementById(
                'dentalRecordsPagebarBottom'
            ),
        ].filter(Boolean);

        const search =
            String(
                searchInput?.value || ''
            ).trim();


        const url =
            new URL(
                window.location.href
            );


        url.searchParams.set(
            'page',
            String(page)
        );

        url.searchParams.set(
            'per_page',
            String(
                dentalRecordsPerPage
            )
        );


        if (search) {
            url.searchParams.set(
                'search',
                search
            );
        } else {
            url.searchParams.delete(
                'search'
            );
        }


        if (
            dentalRecordsStatus &&
            dentalRecordsStatus !==
            'all'
        ) {
            url.searchParams.set(
                'status',
                dentalRecordsStatus
            );
        } else {
            url.searchParams.delete(
                'status'
            );
        }


        try {
            pagebars.forEach(
                pagebar => {
                    pagebar?.classList.add(
                        'is-loading'
                    );
                }
            );


            const response =
                await fetch(
                    url.toString(),
                    {
                        headers: {
                            Accept:
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',
                        },

                        credentials:
                            'same-origin',
                    }
                );


            if (!response.ok) {
                throw new Error(
                    'Unable to load dental records.'
                );
            }

            const payload =
                await response.json();


            if (
                !payload.success ||
                !payload.html
            ) {
                throw new Error(
                    'Invalid dental records response.'
                );
            }


            const parsed =
                new DOMParser()
                    .parseFromString(
                        payload.html,
                        'text/html'
                    );


            const nextRegion =
                parsed.getElementById(
                    'dentalRecordsResultsRegion'
                );

            const currentRegion =
                document.getElementById(
                    'dentalRecordsResultsRegion'
                );


            if (
                !nextRegion ||
                !currentRegion
            ) {
                throw new Error(
                    'Dental records results region was not found.'
                );
            }


            currentRegion.innerHTML =
                nextRegion.innerHTML;

            window.initGlobalPageSizeSelects?.(
                currentRegion
            );

            updateDentalRecordsPagination(
                payload.pagination
            );

            updateDentalRecordFilterCounts(
                payload.counts
            );


            window.history.replaceState(
                {},
                '',
                url.toString()
            );

            const activeMode =
                window.getGlobalViewMode?.(
                    'dentalRecordViewToggle'
                ) || 'list';

            window.setGlobalViewMode?.(
                'dentalRecordViewToggle',
                activeMode,
                {
                    persist: false,
                }
            );


            renderDentalRecordsEmptyState();

        } catch (error) {
            window.showToast?.({
                type: 'error',

                title:
                    'Unable to load records',

                message:
                    error.message ||
                    'Please try again.',
            });
        } finally {
            dentalRecordsLoading =
                false;

            pagebars.forEach(
                pagebar => {
                    pagebar?.classList.remove(
                        'is-loading'
                    );
                }
            );
        }
    }

    window.changeDentalRecordsPageSize =
        function (value) {
            const size =
                Number(value);

            dentalRecordsPerPage =
                [10, 20, 50, 100]
                    .includes(size)
                    ? size
                    : 10;

            loadDentalRecordsPage(1);
        };

    window.handleDentalRecordStatusFilter =
        function (value) {
            dentalRecordsStatus =
                value || 'all';

            loadDentalRecordsPage(1);
        };

    document.addEventListener(
        'DOMContentLoaded',
        () => {
            const searchInput =
                document.getElementById(
                    'dentalRecordSearch'
                );

            searchInput?.addEventListener(
                'input',
                () => {
                    clearTimeout(
                        dentalRecordsSearchTimer
                    );

                    dentalRecordsSearchTimer =
                        window.setTimeout(
                            () => {
                                loadDentalRecordsPage(
                                    1
                                );
                            },
                            300
                        );
                }
            );

            window.initSearchClearButtons?.();
            window.initGlobalViewToggles?.();
            window.initGlobalFilterSelects?.();
            initDentalRecordDetailsModal();

            updateDentalRecordsPagination(
                @json($recordPaginationMeta)
            );

            renderDentalRecordsEmptyState();
        });
</script>
@endsection