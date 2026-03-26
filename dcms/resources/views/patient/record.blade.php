@extends('layouts.patient')

@section('title', 'PUP Taguig Dental Clinic | Appointment')

@section('styles')

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--surface);
            color: var(--text-1);
            overflow-x: hidden;
        }

        /* ════════════════════════════
               PAGE REDESIGN STYLES
            ════════════════════════════ */

        .records-hero {
            background: linear-gradient(135deg, var(--crimson-dark) 0%, var(--crimson) 60%, #b5282a 100%);
            border-radius: 20px;
            padding: 28px 28px 52px;
            position: relative;
            overflow: hidden;
            margin-bottom: -32px;
        }

        .records-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .records-hero::after {
            content: '';
            position: absolute;
            right: -20px;
            bottom: -20px;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, .05);
            border-radius: 50%;
        }

        .hero-eyebrow {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .55);
            margin-bottom: 6px;
        }

        .hero-title {
            font-size: 28px;
            font-weight: 800;
            color: white;
            line-height: 1.15;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 22px;
            }

            .records-hero {
                padding: 20px 18px 44px;
            }
        }

        .hero-sub {
            font-size: 13px;
            color: rgba(255, 255, 255, .65);
            margin-top: 6px;
            position: relative;
            z-index: 1;
        }

        .hero-stats {
            display: flex;
            gap: 12px;
            margin-top: 16px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .hero-stat {
            background: rgba(255, 255, 255, .13);
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 40px;
            padding: 5px 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, .9);
        }

        .hero-stat i {
            font-size: 10px;
            opacity: .7;
        }

        /* Records content card */
        .records-body {
            background: white;
            border-radius: 20px;
            border: 1px solid var(--border);
            padding: 20px;
            position: relative;
            z-index: 2;
            box-shadow: 0 4px 32px rgba(0, 0, 0, .06);
        }

        @media (max-width: 480px) {
            .records-body {
                padding: 14px 12px;
                border-radius: 16px;
            }
        }

        /* ── Individual record card ── */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .rec-row {
            display: flex;
            align-items: stretch;
            gap: 0;
            animation: slideUp .35s ease both;
        }

        /* Timeline column */
        .rec-tl {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 32px;
            flex-shrink: 0;
            padding-top: 16px;
        }

        .rec-dot {
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background: var(--crimson);
            border: 2px solid white;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, .18);
            flex-shrink: 0;
            z-index: 1;
        }

        .rec-line {
            flex: 1;
            width: 1px;
            background: linear-gradient(to bottom, rgba(139, 0, 0, .2), rgba(139, 0, 0, .04));
            margin-top: 6px;
        }

        .rec-row:last-child .rec-line {
            display: none;
        }

        /* Card body */
        .rec-card {
            flex: 1;
            min-width: 0;
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 13px 14px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            transition: box-shadow .2s, border-color .2s, transform .18s;
            cursor: default;
        }

        .rec-card:hover {
            box-shadow: 0 6px 24px rgba(139, 0, 0, .08);
            border-color: rgba(139, 0, 0, .2);
            transform: translateY(-1px);
        }

        .rec-card-left {
            min-width: 0;
            flex: 1;
        }

        .rec-service {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--crimson);
            line-height: 1.3;
            margin-bottom: 5px;
        }

        .rec-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            font-size: 11.5px;
            color: var(--text-3);
        }

        .rec-meta-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--crimson-soft);
            color: var(--crimson);
            border-radius: 20px;
            padding: 2px 8px;
            font-size: 11px;
            font-weight: 600;
        }

        .rec-meta-chip i {
            font-size: 9px;
            opacity: .7;
        }

        /* Details button */
        .rec-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 50px;
            background: var(--crimson);
            color: white;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            flex-shrink: 0;
            transition: background .18s, transform .15s, box-shadow .18s;
            box-shadow: 0 2px 10px rgba(139, 0, 0, .28);
        }

        .rec-btn:hover {
            background: var(--crimson-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(139, 0, 0, .38);
        }

        .rec-btn i {
            font-size: 11px;
        }

        @media (max-width: 480px) {
            .rec-card {
                flex-wrap: wrap;
                padding: 12px 10px;
            }

            .rec-btn {
                width: 100%;
                justify-content: center;
                margin-top: 8px;
            }
        }

        /* Empty state */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 20px;
            text-align: center;
        }

        .empty-icon-wrap {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: var(--crimson-soft);
            border: 1.5px solid rgba(139, 0, 0, .12);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .empty-icon-wrap i {
            font-size: 28px;
            color: var(--crimson);
            opacity: .4;
        }

        .empty-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-1);
            margin-bottom: 6px;
        }

        .empty-sub {
            font-size: 13px;
            color: var(--text-3);
            max-width: 260px;
            line-height: 1.6;
        }

        /* ── MODAL ── */
        dialog#record_modal {
            padding: 0;
            border: none;
            background: transparent;
        }

        dialog#record_modal::backdrop {
            background: rgba(10, 10, 10, .55);
            backdrop-filter: blur(3px);
        }

        @media (min-width: 641px) {
            dialog#record_modal {
                border-radius: 22px;
                max-width: 500px;
                width: 92%;
                overflow: hidden;
            }
        }

        @media (max-width: 640px) {
            dialog#record_modal {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                top: auto;
                width: 100%;
                max-width: 100%;
                max-height: 92vh;
                border-radius: 22px 22px 0 0;
                margin: 0;
                animation: sheetUp .3s cubic-bezier(.32, 1.1, .64, 1);
            }

            @keyframes sheetUp {
                from {
                    transform: translateY(100%);
                }

                to {
                    transform: translateY(0);
                }
            }
        }

        .modal-inner {
            background: #F7F4F2;
            border-radius: inherit;
            max-height: 92vh;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .drag-pill {
            display: none;
            width: 36px;
            height: 4px;
            background: rgba(255, 255, 255, .4);
            border-radius: 2px;
            margin: 0 auto 10px;
        }

        @media (max-width: 640px) {
            .drag-pill {
                display: block;
            }
        }

        /* Modal header */
        .modal-head {
            background: linear-gradient(135deg, var(--crimson-dark), var(--crimson));
            padding: 20px 20px 24px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .modal-head::before {
            content: '';
            position: absolute;
            right: -30px;
            top: -30px;
            width: 130px;
            height: 130px;
            background: rgba(255, 255, 255, .06);
            border-radius: 50%;
        }

        .modal-head-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .modal-eyebrow {
            font-size: 9.5px;
            font-weight: 800;
            letter-spacing: .13em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .5);
            margin-bottom: 4px;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 700;
            line-height: 1.2;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 640px) {
            .modal-title {
                font-size: 18px;
            }
        }

        .modal-close-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .15);
            border: none;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            font-size: 13px;
            transition: background .15s;
            position: relative;
            z-index: 1;
        }

        .modal-close-btn:hover {
            background: rgba(255, 255, 255, .25);
        }

        .modal-meta-strip {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 12px;
            position: relative;
            z-index: 1;
        }

        .modal-meta-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 30px;
            padding: 4px 10px;
            font-size: 11.5px;
            color: rgba(255, 255, 255, .88);
            font-weight: 500;
        }

        .modal-meta-chip i {
            font-size: 10px;
            opacity: .75;
        }

        /* Modal body */
        .modal-body {
            padding: 16px 18px 18px;
        }

        .chip-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 14px;
        }

        .chip-box {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 11px 14px;
        }

        .chip-lbl {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--text-3);
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 6px;
        }

        .chip-val {
            display: inline-flex;
            align-items: center;
            padding: 3px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
        }

        /* Section blocks */
        .msec {
            margin-bottom: 10px;
        }

        .msec-head {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }

        .msec-lbl {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--crimson);
            white-space: nowrap;
        }

        .msec-rule {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .msec-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            align-items: stretch;
        }

        .msec-accent {
            width: 4px;
            background: rgba(139, 0, 0, .15);
            flex-shrink: 0;
        }

        .msec-text {
            padding: 10px 13px;
            font-size: 13px;
            color: var(--text-2);
            line-height: 1.65;
            flex: 1;
        }

        .modal-footer {
            padding: 0 18px 18px;
        }

        .modal-close-main {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            background: #EDEAE7;
            color: var(--text-1);
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background .15s;
        }

        @media (min-width: 641px) {
            .modal-close-main {
                width: auto;
                padding: 10px 28px;
                float: right;
            }
        }

        .modal-close-main:hover {
            background: #DDD9D5;
        }
    </style>
@endsection

@php
    $notifications = collect($notifications ?? []);
    $notifCount = $notifications->count();
@endphp

@section('content')

    <!-- ══════ MAIN ══════ -->
    <main id="mainContent" class="pt-[100px] px-4 sm:px-6 py-6 fade-up min-h-screen">
        <div class="mx-auto">

            <!-- Breadcrumb -->
            <div class="text-xs mb-5 font-medium flex items-center gap-1.5 text-gray-400 pt-4">
                <a href="{{ route('homepage') }}" class="hover:text-[#8B0000] transition-colors">Home</a>
                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                <span class="text-[#8B0000] font-semibold">Dental Records</span>
            </div>

            @if (isset($upcomingAppointment) && $upcomingAppointment)
                @php
                    $uDate = \Carbon\Carbon::parse($upcomingAppointment->appointment_date);
                    $uTime = \Carbon\Carbon::parse($upcomingAppointment->appointment_time);
                    $isRescheduled = strtolower($upcomingAppointment->status) === 'rescheduled';
                @endphp
                <div class="mb-5 rounded-2xl overflow-hidden border border-[#EDE8E4] shadow-sm">
                    {{-- Card top --}}
                    <div class="flex items-center justify-between gap-3 px-5 py-3"
                        style="background: linear-gradient(135deg, #5A0000, #8B0000);">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center flex-shrink-0">
                                <i class="fa-regular fa-calendar-check text-white text-sm"></i>
                            </div>
                            <span class="text-white font-bold text-sm">Upcoming Appointment</span>
                        </div>
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold flex-shrink-0
                  {{ $isRescheduled ? 'bg-yellow-400/20 text-yellow-100' : 'bg-emerald-500/20 text-emerald-100' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full flex-shrink-0
                      {{ $isRescheduled ? 'bg-yellow-300' : 'bg-emerald-400' }}"></span>
                            {{ ucfirst($upcomingAppointment->status) }}
                        </span>
                    </div>
                    {{-- Card body --}}
                    <div class="bg-white px-5 py-4 grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Service</p>
                            <p class="text-sm font-bold text-[#8B0000]">
                                {{ $upcomingAppointment->service_type ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Date & Time
                            </p>
                            <p class="text-sm font-bold text-[#1C1410]">
                                {{ $uDate->format('M d, Y') }}
                                <span class="text-[#8B0000] mx-0.5">·</span>
                                {{ $uTime->format('g:i A') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mb-1">Dentist</p>
                            <p class="text-sm font-bold text-[#1C1410]">
                                {{ $upcomingAppointment->dentist_name ?? 'Dr. Nelson P. Angeles' }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @php
                $totalRecords = isset($records) ? $records->count() : 0;
                $latestDate = $totalRecords
                    ? \Carbon\Carbon::parse($records->first()->appointment_date)->format('M Y')
                    : null;
            @endphp

            <!-- Hero Banner -->
            <div class="records-hero">
                <div class="hero-eyebrow">Patient Portal</div>
                <h1 class="hero-title">Dental Records</h1>
                <p class="hero-sub">A complete history of your dental visits and treatments.</p>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <i class="fa-solid fa-list"></i>
                        {{ $totalRecords }} {{ $totalRecords === 1 ? 'visit' : 'visits' }}
                    </div>
                    @if ($latestDate)
                        <div class="hero-stat">
                            <i class="fa-regular fa-calendar"></i>
                            Latest: {{ $latestDate }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Records Body Card -->
            <div class="records-body">

                @if ($totalRecords)

                    {{-- Section label --}}
                    <div class="flex items-center gap-3 mb-5 pt-2">
                        <span
                            style="font-size:9px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:#9E9690;">Visit
                            History</span>
                        <div style="flex:1;height:1px;background:#EDE8E4;"></div>
                    </div>

                    {{-- Timeline --}}
                    <div class="space-y-0">
                        @foreach ($records as $i => $record)
                            @php
                                $apptDate = \Carbon\Carbon::parse($record->appointment_date);
                                $apptTime = \Carbon\Carbon::parse($record->appointment_time);
                                $fmtDate = $apptDate->format('d M Y');
                                $fmtTime = $apptTime->format('g:i A');
                                $fmtRange =
                                    $apptTime->format('g:i A') . ' – ' . $apptTime->copy()->addHour()->format('g:i A');
                            @endphp
                            <div class="rec-row" style="animation-delay:{{ $i * 0.06 }}s;">

                                {{-- Timeline dot + line --}}
                                <div class="rec-tl">
                                    <div class="rec-dot"></div>
                                    <div class="rec-line"></div>
                                </div>

                                {{-- Card --}}
                                <div class="rec-card">
                                    <div class="rec-card-left">
                                        <div class="rec-service">{{ $record->service_type }}</div>
                                        <div class="rec-meta">
                                            <span class="rec-meta-chip">
                                                <i class="fa-regular fa-calendar"></i>{{ $fmtDate }}
                                            </span>
                                            <span class="rec-meta-chip">
                                                <i class="fa-regular fa-clock"></i>{{ $fmtTime }}
                                            </span>
                                        </div>
                                    </div>
                                    <button type="button" class="rec-btn" onclick="openRecordModal(this)"
                                        data-service="{{ $record->service_type }}"
                                        data-date="{{ $apptDate->format('F d, Y') }}" data-time="{{ $fmtRange }}"
                                        data-status="completed" data-duration="{{ $record->duration ?? '—' }}"
                                        data-remarks="{{ $record->remarks ?? '' }}"
                                        data-oral="{{ $record->oral_examination ?? '' }}"
                                        data-diagnosis="{{ $record->diagnosis ?? '' }}"
                                        data-prescription="{{ $record->prescription ?? '' }}">
                                        <i class="fa-regular fa-eye"></i> Details
                                    </button>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon-wrap">
                            <i class="fa-solid fa-tooth"></i>
                        </div>
                        <p class="empty-title">No records yet</p>
                        <p class="empty-sub">Completed appointment records will appear here after your first dental
                            visit.</p>
                        <a href="{{ route('patient.book.appointment') }}"
                            class="mt-6 inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#8B0000] text-white text-sm font-semibold hover:bg-[#660000] transition-colors shadow-md">
                            <i class="fa-solid fa-calendar-plus text-xs"></i> Book Appointment
                        </a>
                    </div>

                @endif

            </div>

        </div>
    </main>

    <!-- ══════ RECORD MODAL ══════ -->
    <dialog id="record_modal">
        <div class="modal-inner">

            <!-- Header -->
            <div class="modal-head">
                <div class="drag-pill"></div>
                <div class="modal-head-top">
                    <div style="position:relative;z-index:1;">
                        <p class="modal-eyebrow">Dental Record</p>
                        <h3 class="modal-title" id="m_service">—</h3>
                    </div>
                    <button class="modal-close-btn" id="modalCloseBtn" type="button">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-meta-strip">
                    <span class="modal-meta-chip"><i class="fa-regular fa-calendar"></i> <span
                            id="m_date">—</span></span>
                    <span class="modal-meta-chip"><i class="fa-regular fa-clock"></i> <span
                            id="m_time">—</span></span>
                </div>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <!-- Status + Duration chips -->
                <div class="chip-row">
                    <div class="chip-box">
                        <div class="chip-lbl"><i class="fa-solid fa-circle-check"
                                style="color:#15803d;font-size:9px;"></i> Status
                        </div>
                        <span id="m_status" class="chip-val bg-emerald-100 text-emerald-800">—</span>
                    </div>
                    <div class="chip-box">
                        <div class="chip-lbl"><i class="fa-regular fa-clock" style="font-size:9px;"></i> Duration
                        </div>
                        <span id="m_duration" class="chip-val bg-gray-100 text-gray-700">—</span>
                    </div>
                </div>

                <!-- Treatment -->
                <div class="msec">
                    <div class="msec-head"><span class="msec-lbl">Treatment</span>
                        <div class="msec-rule"></div>
                    </div>
                    <div class="msec-card">
                        <div class="msec-accent"></div>
                        <div class="msec-text"><span id="m_remarks">—</span></div>
                    </div>
                </div>

                <!-- Oral Examination -->
                <div class="msec">
                    <div class="msec-head"><span class="msec-lbl">Oral Examination</span>
                        <div class="msec-rule"></div>
                    </div>
                    <div class="msec-card">
                        <div class="msec-accent"></div>
                        <div class="msec-text"><span id="m_oral">—</span></div>
                    </div>
                </div>

                <!-- Diagnosis -->
                <div class="msec">
                    <div class="msec-head"><span class="msec-lbl">Diagnosis</span>
                        <div class="msec-rule"></div>
                    </div>
                    <div class="msec-card">
                        <div class="msec-accent"></div>
                        <div class="msec-text"><span id="m_diagnosis">—</span></div>
                    </div>
                </div>

                <!-- Prescription -->
                <div class="msec">
                    <div class="msec-head"><span class="msec-lbl">Prescription</span>
                        <div class="msec-rule"></div>
                    </div>
                    <div class="msec-card">
                        <div class="msec-accent"></div>
                        <div class="msec-text"><span id="m_prescription">—</span></div>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="modal-close-main" id="modalCloseFooter">Close</button>
            </div>

        </div>
    </dialog>
@endsection

@section('scripts')
    <script>
        /* ── RECORD MODAL ── */
        var recModal = document.getElementById('record_modal');

        function openRecordModal(btn) {
            document.getElementById('m_service').textContent = btn.dataset.service || '—';
            document.getElementById('m_date').textContent = btn.dataset.date || '—';
            document.getElementById('m_time').textContent = btn.dataset.time || '—';

            var st = (btn.dataset.status || 'completed').trim().toLowerCase();
            var sEl = document.getElementById('m_status');
            sEl.textContent = st.charAt(0).toUpperCase() + st.slice(1);
            sEl.className = 'chip-val';
            if (st === 'completed') sEl.classList.add('bg-emerald-100', 'text-emerald-800');
            else if (st === 'rescheduled') sEl.classList.add('bg-yellow-100', 'text-yellow-800');
            else if (st === 'cancelled') sEl.classList.add('bg-red-100', 'text-red-800');
            else sEl.classList.add('bg-gray-100', 'text-gray-700');

            var dEl = document.getElementById('m_duration');
            dEl.textContent = (btn.dataset.duration || '—').trim();
            dEl.className = 'chip-val bg-gray-100 text-gray-700';

            document.getElementById('m_remarks').textContent = (btn.dataset.remarks || '').trim() || '—';
            document.getElementById('m_oral').textContent = (btn.dataset.oral || '').trim() || '—';
            document.getElementById('m_diagnosis').textContent = (btn.dataset.diagnosis || '').trim() || '—';
            document.getElementById('m_prescription').textContent = (btn.dataset.prescription || '').trim() || '—';

            recModal.showModal();
        }

        function closeRecModal() {
            recModal.close();
        }

        /* ── DOM READY ── */
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth >= 768) {
                sidebarOpen = true;
                applyLayout('220px');
            } else {
                document.getElementById('mainContent').style.marginLeft = '0';
            }

            document.getElementById('modalCloseBtn').addEventListener('click', closeRecModal);
            document.getElementById('modalCloseFooter').addEventListener('click', closeRecModal);

            recModal.addEventListener('click', function(e) {
                var r = recModal.getBoundingClientRect();
                if (e.clientX < r.left || e.clientX > r.right || e.clientY < r.top || e.clientY > r.bottom)
                    closeRecModal();
            });

            /* Mobile FAB */
            var mf = document.getElementById('mobFab'),
                mm = document.getElementById('mobFabMenu');
            if (mf && mm) {
                mf.addEventListener('click', function(e) {
                    e.stopPropagation();
                    var o = mm.classList.contains('open');
                    mm.classList.toggle('open', !o);
                    mf.classList.toggle('open', !o);
                });
                mm.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            /* Notifications */
            var nb = document.getElementById("notifBtn"),
                nm = document.getElementById("notifMenu");
            if (nb && nm) {
                nb.addEventListener("click", function(e) {
                    e.stopPropagation();
                    nm.classList.toggle("open");
                });
                nm.addEventListener("click", function(e) {
                    e.stopPropagation();
                });
                document.addEventListener("keydown", function(e) {
                    if (e.key === "Escape") nm.classList.remove("open");
                });
            }

            /* Outside clicks */
            document.addEventListener('click', function(e) {
                if (mm) {
                    mm.classList.remove('open');
                    if (mf) mf.classList.remove('open');
                }
                if (nm) nm.classList.remove('open');
                var panel = document.getElementById('mobileProfileAccordion');
                var toggle = document.getElementById('mobileProfileToggle');
                var chev = document.getElementById('mobileProfileChevron');
                if (panel && toggle && !panel.contains(e.target) && !toggle.contains(e.target)) {
                    panel.classList.remove('open');
                    if (chev) chev.style.transform = 'rotate(0deg)';
                }
            });
        });
    </script>
@endsection
