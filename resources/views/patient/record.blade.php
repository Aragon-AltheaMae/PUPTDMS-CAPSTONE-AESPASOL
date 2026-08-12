@extends('layouts.app')

@section('layout-role', 'patient')

@section('title', 'Dental Records')

@section('content')

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
@endphp

<main id="mainContent" class="patient-page-shell page-enter patient-records-page">
    <div class="w-full">

        @if (isset($upcomingAppointment) && $upcomingAppointment)
        @php
        $uDate = \Carbon\Carbon::parse($upcomingAppointment->appointment_date);
        $uTime = \Carbon\Carbon::parse($upcomingAppointment->appointment_time);
        $isRescheduled = strtolower($upcomingAppointment->status) === 'rescheduled';

        $statusPillCls = $isRescheduled
        ? 'bg-yellow-100 text-yellow-800 border-yellow-200'
        : 'bg-green-100 text-green-800 border-green-200';
        $statusDotCls = $isRescheduled ? 'bg-yellow-500' : 'bg-green-500';
        $statusDarkPill = $isRescheduled
        ? 'dark:bg-yellow-400/20 dark:text-yellow-100 dark:border-yellow-400/30'
        : 'dark:bg-emerald-500/20 dark:text-emerald-100 dark:border-emerald-500/30';
        @endphp
        <div
            class="mb-6 upcoming-card-polished bg-white dark:bg-[#161B22] rounded-[1rem] border border-gray-200 dark:border-white/10 shadow-sm overflow-hidden transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
            <div class="px-4 sm:px-5 py-4 sm:py-4.5">
                <div class="grid grid-cols-1 xl:grid-cols-[minmax(0,1fr)_auto] gap-4 xl:gap-5 items-center">

                    <div class="min-w-0">
                        <div class="flex items-start gap-3">
                            <div class="relative flex-shrink-0 mt-0.5">
                                <div
                                    class="upcoming-tooth-glass w-12 h-12 rounded-[0.95rem] text-white flex items-center justify-center">
                                    <i
                                        class="fa-solid fa-tooth text-[15px] relative z-[1] drop-shadow-[0_1px_2px_rgba(0,0,0,0.22)]"></i>
                                </div>
                                <span
                                    class="upcoming-live-dot absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full {{ $statusDotCls }} border-2 border-white dark:border-[#161B22]"></span>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3
                                        class="text-lg sm:text-[1.15rem] font-extrabold text-gray-900 dark:text-[#F3F4F6] leading-tight truncate">
                                        {{ $upcomingAppointment->service_type ?? '—' }}
                                    </h3>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $statusPillCls }} {{ $statusDarkPill }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $statusDotCls }}"></span>
                                        {{ ucfirst($upcomingAppointment->status) }}
                                    </span>
                                </div>

                                <div
                                    class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-600 dark:text-gray-400">
                                    <span class="inline-flex items-center gap-2">
                                        <i class="fa-regular fa-calendar text-gray-400 dark:text-gray-500"></i>
                                        <span class="font-medium">{{ $uDate->format('M d, Y') }}</span>
                                    </span>

                                    <span class="inline-flex items-center gap-2">
                                        <i class="fa-regular fa-clock text-gray-400 dark:text-gray-500"></i>
                                        <span class="font-medium">{{ $uTime->format('g:i A') }}</span>
                                    </span>

                                    <span class="inline-flex items-center gap-2 min-w-0">
                                        <i class="fa-solid fa-user-doctor text-gray-400 dark:text-gray-500"></i>
                                        <span class="font-medium truncate">{{ $upcomingAppointment->dentist_name ?? 'Dr.
                                            Nelson P. Angeles' }}</span>
                                    </span>
                                </div>

                                <div class="mt-3 flex items-center gap-3">
                                    <div
                                        class="h-[2px] w-10 rounded-full bg-gradient-to-r from-red-200 to-red-300 dark:from-red-900/50 dark:to-red-800/50">
                                    </div>
                                    <span
                                        class="text-[11px] font-bold uppercase tracking-[0.18em] text-gray-400 dark:text-gray-500">Upcoming
                                        Visit</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="xl:min-w-[180px]">
                        <div class="flex flex-col sm:flex-row xl:flex-col items-stretch gap-2.5">
                            <div class="upcoming-reminder-chip">
                                <span class="upcoming-reminder-icon">
                                    <i class="fa-regular fa-bell text-[12px]"></i>
                                </span>
                                <span class="text-[0.76rem] font-bold text-[#7f1d1d] dark:text-[#FCA5A5]">Please
                                    arrive 10 minutes early</span>
                            </div>

                            <a href="{{ route('patient.appointment.index') }}"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-[0.85rem] bg-[#8B0000] hover:bg-[#660000] text-white text-sm font-bold transition-all duration-300 shadow-sm hover:-translate-y-0.5">
                                <span>Manage Appointment</span>
                                <i class="fa-solid fa-arrow-right text-[11px]"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endif

        @php
        $totalRecords = isset($records) ? $records->total() : 0;
        $latestDate = $totalRecords
        ? \Carbon\Carbon::parse($records->first()->appointment_date)->format('M d, Y')
        : null;
        @endphp

        <div class="records-hero">
            <h2 class="hero-title">Dental Records Overview</h2>
            <p class="hero-sub">A complete history of your dental visits, treatments, and prescriptions.</p>

            <div class="hero-stats">
                <div class="hero-stat">
                    <i class="fa-solid fa-list-check"></i>
                    {{ $totalRecords }} {{ $totalRecords === 1 ? 'Total Visit' : 'Total Visits' }}
                </div>
                @if ($latestDate)
                <div class="hero-stat">
                    <i class="fa-regular fa-calendar-check"></i>
                    Latest: {{ $latestDate }}
                </div>
                @endif
            </div>
        </div>

        <div class="records-sections">

           <section class="card records-visits-card">
                <div class="card-body">
                    <div class="records-section-title">
                        <span>
                            <i class="fa-solid fa-clock-rotate-left mr-1"></i>
                            Visit History
                        </span>

                    <div></div>
                </div>

            @if ($totalRecords)
                <x-pagination-bar
                    id="recordsPagebarTop"
                    info-id="recordsPageInfoTop"
                    pagination-id="recordsPaginationTop"
                    position="top"
                    :show-entries="true"
                    page-size-id="recordsPageSize"
                    page-size-callback="changeRecordsPageSize"
                    :page-size-value="$records->perPage()"
                    page-size-label="per page"
                    label="visits"
                />

                <div class="space-y-0">
                    @foreach ($records as $i => $record)
                        @php
                            $apptDate = \Carbon\Carbon::parse($record->appointment_date);
                            $apptTime = \Carbon\Carbon::parse($record->appointment_time);

                            $fmtDate = $apptDate->format('F d, Y');
                            $fmtTime = $apptTime->format('g:i A');

                            $recordProcedure = $record->procedure;

                            $recordDuration =
                                $recordProcedure?->procedure_duration_seconds
                                    ? \Carbon\CarbonInterval::seconds(
                                        (int) $recordProcedure->procedure_duration_seconds
                                    )
                                        ->cascade()
                                        ->forHumans([
                                            'short' => true,
                                            'minimumUnit' => 'second'
                                        ])
                                    : (
                                        $record->duration
                                        ?? $record->procedure_duration
                                        ?? $record->treatment_duration
                                        ?? '60 mins'
                                    );

                            $recordTreatment =
                                $recordProcedure?->completion_action
                                    ? \Illuminate\Support\Str::of(
                                        $recordProcedure->completion_action
                                    )
                                        ->replace('_', ' ')
                                        ->title()
                                    : ($record->remarks ?? '');
                        @endphp

                        <div
                            class="rec-row"
                            style="animation-delay:{{ $i * 0.08 }}s;"
                        >
                            <div class="rec-tl">
                                <div class="rec-dot"></div>
                                <div class="rec-line"></div>
                            </div>

                            <div class="rec-card">
                                <div class="rec-card-left">
                                    <div class="rec-service">
                                        {{ $record->service_type }}
                                    </div>

                                    <div class="rec-meta">
                                        <span class="rec-meta-chip">
                                            <i class="fa-regular fa-calendar-check text-[10px] mr-1.5"></i>
                                            {{ $fmtDate }}
                                        </span>

                                        <span class="rec-meta-chip">
                                            <i class="fa-regular fa-clock text-[10px]"></i>
                                            {{ $fmtTime }}
                                        </span>
                                    </div>
                                </div>

                                <button
                                    class="rec-btn"
                                    onclick="openRecordModal(this)"
                                    data-service="{{ $record->service_type }}"
                                    data-date="{{ $fmtDate }}"
                                    data-time="{{ $record->appointment_time }}"
                                    data-status="{{ $record->status }}"
                                    data-duration="{{ $recordDuration }}"
                                    data-remarks="{{ $recordTreatment }}"
                                    data-oral="{{ $recordProcedure?->oral_examination ?? '' }}"
                                    data-diagnosis="{{ $recordProcedure?->diagnosis ?? '' }}"
                                    data-prescription="{{ $recordProcedure?->prescriptions ?? '' }}"
                                >
                                    View Details
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <x-pagination-bar
                    id="recordsPagebarBottom"
                    info-id="recordsPageInfoBottom"
                    pagination-id="recordsPaginationBottom"
                    position="bottom"
                    :show-entries="false"
                    label="visits"
                />

            @else
                <div class="empty-state fade-up">
                    <div class="empty-state-icon">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>

                    <p class="empty-state-title">
                        No records yet
                    </p>

                    <p class="empty-state-sub">
                        Completed appointment records will appear here after your first dental visit.
                    </p>

                    <a
                        href="{{ route('patient.book.appointment') }}"
                        class="empty-state-btn"
                    >
                        <i class="fa-solid fa-calendar-plus"></i>
                        Book First Appointment
                    </a>
                </div>
            @endif
            </div>
        </section>

            <section class="card document-history-card">
            <div class="card-body">

            @php
                $documentRequests = collect($documentRequests ?? []);
            @endphp

            <div class="document-history-section">
                <div class="records-section-title">
                    <span>
                        <i class="fa-solid fa-file-lines mr-1"></i>
                        Document Request History
                    </span>

                    <div></div>
                </div>

                @if ($documentRequests->isNotEmpty())
                    <div class="document-history-list">
                        @foreach ($documentRequests as $documentRequest)
                            @php
                                $rawStatus = strtolower(
                                    str_replace(
                                        '_',
                                        '-',
                                        $documentRequest->status ?? 'pending'
                                    )
                                );

                                $displayStatus =
                                    in_array(
                                        $rawStatus,
                                        [
                                            'approved',
                                            'ready',
                                            'ready-for-pickup',
                                            'ready-for-release',
                                            'released',
                                        ],
                                        true
                                    )
                                        ? 'approved'
                                        : (
                                            $rawStatus === 'rejected'
                                                ? 'rejected'
                                                : 'pending'
                                        );

                                $requestDate =
                                    $documentRequest->request_date
                                        ? \Carbon\Carbon::parse(
                                            $documentRequest->request_date
                                        )->format('F d, Y')
                                        : optional(
                                            $documentRequest->created_at
                                        )->format('F d, Y');

                                $requestTime =
                                    $documentRequest->request_time
                                        ? \Carbon\Carbon::parse(
                                            $documentRequest->request_time
                                        )->format('g:i A')
                                        : optional(
                                            $documentRequest->created_at
                                        )->format('g:i A');

                                $processedDate =
                                    $documentRequest->approved_at
                                        ? \Carbon\Carbon::parse(
                                            $documentRequest->approved_at
                                        )->format('F d, Y')
                                        : null;

                                $statusLabel = match ($displayStatus) {
                                    'approved' => 'Approved',
                                    'rejected' => 'Rejected',
                                    default => 'Pending',
                                };
                            @endphp

                            <article
                                class="global-record-card document-request-item"
                                style="--record-accent:
                                    {{ $displayStatus === 'approved'
                                        ? 'var(--status-approved-solid)'
                                        : ($displayStatus === 'rejected'
                                            ? 'var(--status-rejected-solid)'
                                            : 'var(--status-pending-solid)') }};
                                "
                            >
                                <div class="document-request-row">

                                    <div class="document-request-content">
                                        <div class="document-request-topline">
                                            <span class="document-history-reference">
                                                {{ $documentRequest->reference_number ?? '—' }}
                                            </span>

                                            <span class="status-pill status-{{ $displayStatus }}">
                                                <span class="status-dot"></span>
                                                {{ $statusLabel }}
                                            </span>
                                        </div>

                                        <h3 class="global-record-name document-request-name">
                                            {{
                                                \Illuminate\Support\Str::of(
                                                    $documentRequest->document_type ?? 'Document'
                                                )
                                                    ->replace(['_', '-'], ' ')
                                                    ->title()
                                            }}
                                        </h3>

                                        <div class="document-request-meta">
                                            <span class="global-info-pill">
                                                <i class="fa-regular fa-calendar"></i>
                                                {{ $requestDate ?: '—' }}
                                            </span>

                                            @if ($requestTime)
                                                <span class="global-info-pill">
                                                    <i class="fa-regular fa-clock"></i>
                                                    {{ $requestTime }}
                                                </span>
                                            @endif

                                            <span class="document-request-purpose">
                                                <i class="fa-solid fa-bullseye"></i>
                                                <span class="document-request-purpose-label">
                                                    Purpose:
                                                </span>

                                                <strong>
                                                    {{ $documentRequest->purpose ?: '—' }}
                                                </strong>
                                            </span>
                                        </div>

                                        @if ($displayStatus === 'approved' && $processedDate)
                                            <div class="document-request-status-note status-approved">
                                                <i class="fa-solid fa-circle-check"></i>
                                                Processed on {{ $processedDate }}
                                            </div>

                                        @elseif ($displayStatus === 'rejected' && $documentRequest->rejection_reason)
                                            <div class="document-request-status-note status-rejected">
                                                <i class="fa-solid fa-circle-xmark"></i>
                                                {{ $documentRequest->rejection_reason }}
                                            </div>

                                        @elseif ($displayStatus === 'pending')
                                            <div class="document-request-status-note status-pending">
                                                <i class="fa-regular fa-clock"></i>
                                                Waiting for clinic review
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fa-solid fa-file-circle-question"></i>
                        </div>

                        <p class="empty-state-title">
                            No document requests yet
                        </p>

                        <p class="empty-state-sub">
                            Your submitted document requests will appear here.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    </div>
        </div>
</main>
@endsection

@section('scripts')
<script>
    function goToRecordsPage(page) {
        const url = new URL(window.location.href);

        url.searchParams.set('records_page', page);

        window.location.href = url.toString();
    }

    function changeRecordsPageSize(size) {
        const url = new URL(window.location.href);

        url.searchParams.set('per_page', size);
        url.searchParams.set('records_page', 1);

        window.location.href = url.toString();
    }

    document.addEventListener('DOMContentLoaded', function () {
        initRecordModal();

        if (typeof window.renderGlobalPagination === 'function') {
            window.renderGlobalPagination({
                currentPage: {{ $records->currentPage() }},
                lastPage: {{ $records->lastPage() }},
                total: {{ $records->total() }},
                from: {{ $records->firstItem() ?? 0 }},
                to: {{ $records->lastItem() ?? 0 }},

                containers: [
                    document.getElementById('recordsPaginationTop'),
                    document.getElementById('recordsPaginationBottom')
                ],

                infoElements: [
                    document.getElementById('recordsPageInfoTop'),
                    document.getElementById('recordsPageInfoBottom')
                ],

                bars: [
                    document.getElementById('recordsPagebarTop'),
                    document.getElementById('recordsPagebarBottom')
                ],

                itemLabel: 'visits',

                onPageChange: goToRecordsPage
            });
        }
    });

</script>
@endsection
