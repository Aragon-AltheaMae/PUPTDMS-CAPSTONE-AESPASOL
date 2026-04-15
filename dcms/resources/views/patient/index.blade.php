@extends('layouts.patient')

@section('title', 'Patient Dashboard | PUP Taguig Dental Clinic')

@section('styles')
    <style>
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

        @keyframes softPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .pulse-icon {
            animation: softPulse 2s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -400px 0;
            }

            100% {
                background-position: 400px 0;
            }
        }

        .skeleton {
            background: linear-gradient(90deg, #e5e7eb 25%, #f9fafb 37%, #e5e7eb 63%);
            background-size: 800px 100%;
            animation: shimmer 1.4s infinite linear;
            border-radius: 0.75rem;
            opacity: 0.85;
        }

        @keyframes fadeUp {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeUp 0.6s ease-out forwards;
        }

        @keyframes shimmerBtn {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .shimmer-btn {
            background: linear-gradient(110deg, #660000 25%, rgba(255, 80, 80, .87) 37%, #660000 63%);
            background-size: 200% 100%;
            animation: shimmerBtn 10s linear infinite;
        }

        @keyframes wave {
            0% {
                transform: rotate(0);
            }

            20% {
                transform: rotate(14deg);
            }

            40% {
                transform: rotate(-8deg);
            }

            60% {
                transform: rotate(14deg);
            }

            80% {
                transform: rotate(-4deg);
            }

            100% {
                transform: rotate(0);
            }
        }

        .wave-hand {
            transform-origin: 70% 70%;
            animation: wave 2.5s ease-in-out infinite;
        }

        @keyframes spinSlow {
            from {
                transform: rotate(0);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes floatMoon {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-3px);
            }
        }

        @keyframes driftCloud {

            0%,
            100% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(3px);
            }
        }

        .greet-spin {
            animation: spinSlow 8s linear infinite;
            display: inline-block;
        }

        .greet-float {
            animation: floatMoon 3s ease-in-out infinite;
            display: inline-block;
        }

        .greet-drift {
            animation: driftCloud 3s ease-in-out infinite;
            display: inline-block;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .greeting-row {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.25rem;
            flex-wrap: nowrap;
        }

        .greeting-banner {
            position: relative;
            overflow: hidden;
            width: 100%;
            border-radius: 24px;
            padding: 22px 24px;
            background: linear-gradient(135deg,
                    rgba(139, 0, 0, 0.96) 0%,
                    rgba(102, 0, 0, 0.93) 48%,
                    rgba(179, 52, 18, 0.92) 100%);
            box-shadow: 0 14px 40px rgba(14, 116, 144, 0.10);
            border: 1px solid rgba(255, 255, 255, .20);
        }

        .greeting-banner::before,
        .greeting-banner::after {
            content: '';
            position: absolute;
            border-radius: 999px;
            background: rgba(255, 215, 0, 0.07);
            pointer-events: none;
        }

        .greeting-banner::before {
            width: 240px;
            height: 240px;
            top: -145px;
            left: -40px;
        }

        .greeting-banner::after {
            width: 220px;
            height: 220px;
            right: -55px;
            bottom: -150px;
        }

        .greeting-banner-inner {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .greeting-banner-copy {
            min-width: 0;
        }

        .greeting-heading {
            display: flex;
            flex-direction: column;
            gap: 2px;
            margin: 0;
            color: #fff;
        }

        .greeting-line {
            display: block;
        }

        #greetingText {
            font-size: 1.45rem;
            font-weight: 500;
            line-height: 1.15;
        }

        .greeting-name-line {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            font-size: clamp(1.55rem, 3vw, 2.35rem);
            font-weight: 800;
            line-height: 1.15;
        }

        .greeting-banner-copy p {
            color: rgba(255, 255, 255, .92);
            font-size: 0.95rem;
            margin-top: 0.45rem;
            font-weight: 500;
        }

        .greeting-banner-actions {
            display: flex;
            align-items: center;
            flex-shrink: 0;
            gap: 12px;
        }

        .book-appointment-btn {
            position: relative;
            overflow: hidden;
            padding: 10px 18px;
            min-width: 182px;
            font-size: 0.95rem;
            font-weight: 700;
            white-space: nowrap;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.449);
            box-shadow: 0 10px 24px rgba(0, 0, 0, .18);
            background: linear-gradient(110deg, #660000 25%, #8B0000 45%, #660000 65%);
            background-size: 200% 100%;
            animation: shimmerBtn 4s linear infinite;
        }

        .book-appointment-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.35), transparent);
            transform: skewX(-20deg);
            animation: shine 2.8s infinite;
        }

        @keyframes shine {
            0% {
                left: -100%;
            }

            100% {
                left: 120%;
            }
        }

        .book-appointment-btn i,
        .book-appointment-btn span {
            position: relative;
            z-index: 1;
        }

        .book-appointment-btn:hover {
            background: linear-gradient(110deg, #4d0000 25%, #7a0000 45%, #4d0000 65%);
            background-size: 200% 100%;
            transform: translateY(-1px);
        }

        .skeleton-section {
            margin-bottom: 1.5rem;
        }

        .skeleton-card {
            padding: 1.25rem;
            border-radius: 1.25rem;
        }

        .skeleton-inner-gap {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        @media only screen and (max-width: 600px) {
            .greeting-row {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 0.75rem !important;
                margin-bottom: 1rem !important;
            }

            .greeting-banner {
                width: 100%;
                padding: 14px 12px;
                border-radius: 18px;
            }

            .greeting-banner-inner {
                flex-direction: column;
                align-items: stretch;
                gap: 0.85rem;
            }

            .greeting-banner-actions {
                width: 100%;
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            #greetingText {
                font-size: 0.95rem;
                font-weight: 600;
            }

            .greeting-name-line {
                font-size: 1.45rem;
                line-height: 1.1;
            }

            .greeting-banner-copy p {
                font-size: 0.74rem;
                margin-top: 6px;
                opacity: 0.9;
            }

            .book-appointment-btn {
                width: 100%;
                min-width: 0;
                padding: 10px 14px;
                font-size: 0.84rem;
            }

            .upcoming-card-mobile {
                border-radius: 18px !important;
                margin-bottom: 1rem !important;
            }

            .upcoming-card-mobile .upcoming-card-header {
                padding: 0.8rem 0.9rem !important;
                gap: 0.5rem !important;
            }

            .upcoming-card-mobile .upcoming-card-header-icon {
                width: 1.95rem !important;
                height: 1.95rem !important;
                font-size: 0.88rem !important;
            }

            .upcoming-card-mobile .upcoming-card-title {
                font-size: 0.9rem !important;
                line-height: 1.2 !important;
            }

            .upcoming-card-mobile .upcoming-status-pill {
                font-size: 0.62rem !important;
                padding: 0.28rem 0.48rem !important;
                border-radius: 999px !important;
            }

            .upcoming-card-mobile .upcoming-card-body {
                padding: 0.8rem 0.9rem 0.9rem !important;
            }

            .upcoming-card-mobile .upcoming-card-grid {
                gap: 0.5rem !important;
            }

            .upcoming-card-mobile .upcoming-info-box {
                padding: 0.68rem 0.72rem !important;
                border-radius: 12px !important;
            }

            .upcoming-card-mobile .upcoming-info-label {
                font-size: 0.54rem !important;
                margin-bottom: 0.22rem !important;
            }

            .upcoming-card-mobile .upcoming-info-value {
                font-size: 0.74rem !important;
                line-height: 1.22 !important;
            }

            .upcoming-card-mobile .upcoming-card-footer {
                margin-top: 0.65rem !important;
                padding-top: 0.65rem !important;
            }

            .upcoming-card-mobile .upcoming-manage-btn {
                width: auto !important;
                min-height: 34px !important;
                padding: 0.42rem 0.75rem !important;
                font-size: 0.66rem !important;
                border-radius: 10px !important;
            }
        }

        @media only screen and (min-width: 600px) and (max-width: 767px) {

            .greeting-row {
                flex-direction: column;
                align-items: stretch;
                gap: 0.9rem;
            }

            .greeting-banner {
                padding: 18px 16px;
                border-radius: 20px;
            }

            .greeting-banner-inner {
                flex-direction: column;
                align-items: stretch;
                gap: 0.9rem;
            }

            .greeting-banner-actions {
                width: 100%;
            }

            .book-appointment-btn {
                width: 100%;
                min-width: 0;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {

            .greeting-row {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
            }

            .greeting-banner {
                padding: 20px 20px;
                border-radius: 22px;
            }

            .greeting-banner-inner {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }

            .greeting-banner-actions {
                width: auto;
            }

            .book-appointment-btn {
                width: auto;
                min-width: 170px;
            }
        }

        @media only screen and (max-width: 600px) {
            #upcomingAppointmentWrapper .upcoming-card-mobile {
                margin-bottom: 0.9rem !important;
            }

            #upcomingAppointmentWrapper .upcoming-card-grid {
                gap: 0.55rem !important;
            }

            #upcomingAppointmentWrapper .upcoming-info-box {
                padding: 0.7rem 0.75rem !important;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $notifications = collect($notifications ?? []);
        $notifCount = $notifications->count();
        $homeRecords = ($records ?? collect())
            ->filter(function ($r) {
                return in_array(strtolower($r->status ?? ''), ['completed', 'cancelled']);
            })
            ->map(function ($r) {
                return [
                    'service' => $r->service_type,
                    'date' => $r->appointment_date ? \Carbon\Carbon::parse($r->appointment_date)->format('F d, Y') : '',
                    'time' => $r->appointment_time ?? '',
                    'status' => strtolower($r->status ?? ''),
                    'duration' => $r->duration ?? '',
                    'remarks' => $r->remarks ?? '',
                    'oral' => $r->oral_examination ?? '',
                    'diagnosis' => $r->diagnosis ?? '',
                    'prescription' => $r->prescription ?? '',
                ];
            })
            ->values();

        $calendarAppointments = [];
        foreach (
            collect($appointments ?? [])->filter(function ($appt) {
                $status = strtolower($appt->status ?? '');
                return !in_array($status, ['completed', 'cancelled']);
            })
            as $appt
        ) {
            $calendarAppointments[\Carbon\Carbon::parse($appt->appointment_date)->format('Y-m-d')] =
                'My Appointment: ' .
                $appt->service_type .
                ' • ' .
                \Carbon\Carbon::parse($appt->appointment_time)->format('g:i A');
        }

        $dashboardDisplayName = ucwords(
            strtolower(optional($patient)->name ?? (auth()->user()->name ?? 'Patient User')),
        );
        $dashboardPatientImage = optional($patient)->profile_image ?? null;
        $dashboardUserImage = auth()->user()->profile_image ?? null;

        if (!empty($dashboardPatientImage)) {
            $dashboardAvatarUrl = asset('storage/' . $dashboardPatientImage);
        } elseif (!empty($dashboardUserImage)) {
            $dashboardAvatarUrl = asset('storage/' . $dashboardUserImage);
        } else {
            $dashboardAvatarUrl =
                'https://ui-avatars.com/api/?name=' .
                urlencode($dashboardDisplayName) .
                '&background=8B0000&color=ffffff&bold=true';
        }
    @endphp

    <main id="mainContent" class="pt-[96px] px-3 md:px-6 pb-6 fade-in min-h-screen flex-1">
        <div class="w-full fade-in space-y-5 xl:space-y-6">

            <div id="greetingContent" class="greeting-row">
                <div class="greeting-banner w-full">
                    <div class="greeting-banner-inner">
                        <div class="greeting-banner-copy min-w-0">
                            <h1 class="greeting-heading">
                                <span class="greeting-line">
                                    <span id="greetingText"></span>
                                </span>
                                <span class="greeting-line greeting-name-line">
                                    <span id="patientName"></span>
                                    <i class="fa-solid fa-hand text-yellow-300 wave-hand"></i>
                                </span>
                            </h1>
                            <p>Wishing you a healthy and happy day!</p>
                        </div>

                        <div class="greeting-banner-actions">
                            <a href="{{ route('patient.book.appointment') }}"
                                class="book-appointment-btn inline-flex items-center justify-center gap-2 rounded-full text-white shadow transition">
                                <i class="fa-solid fa-calendar-plus"></i>
                                <span>Book Appointment</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="upcomingAppointmentWrapper" class="skeleton-section">
                <div class="bg-white skeleton-card border border-gray-200 shadow-sm animate-pulse overflow-hidden">

                    <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full skeleton"></div>
                            <div class="h-4 w-40 skeleton"></div>
                        </div>
                        <div class="h-8 w-24 skeleton rounded-full hidden sm:block"></div>
                    </div>

                    <div class="px-6 py-5">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <div class="skeleton-inner-gap">
                                <div class="h-3 w-20 skeleton"></div>
                                <div class="h-5 w-full skeleton"></div>
                            </div>
                            <div class="skeleton-inner-gap">
                                <div class="h-3 w-28 skeleton"></div>
                                <div class="h-5 w-full skeleton"></div>
                            </div>
                            <div class="skeleton-inner-gap">
                                <div class="h-3 w-20 skeleton"></div>
                                <div class="h-5 w-full skeleton"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 xl:gap-6 items-start">

                <div class="xl:col-span-5 flex flex-col xl:gap-2">

                    <div id="profileSkeletonContainer"
                        class="bg-white rounded-[1.5rem] border border-gray-200 shadow-sm overflow-hidden skeleton-section">

                        <div class="animate-pulse">
                            <div class="bg-gray-200 px-5 sm:px-6 py-5">
                                <div class="h-3 w-28 skeleton mb-3"></div>
                                <div class="h-6 w-44 skeleton mb-2"></div>
                                <div class="h-4 w-72 max-w-full skeleton"></div>
                            </div>

                            <div class="p-4 sm:p-5 space-y-3">
                                <div class="rounded-2xl border border-gray-100 p-4">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 rounded-2xl skeleton flex-shrink-0"></div>
                                        <div class="flex-1 space-y-2">
                                            <div class="h-5 w-40 skeleton"></div>
                                            <div class="h-4 w-full skeleton"></div>
                                            <div class="flex gap-2 pt-1">
                                                <div class="h-6 w-20 skeleton rounded-full"></div>
                                                <div class="h-6 w-20 skeleton rounded-full"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-gray-100 p-4">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 rounded-2xl skeleton flex-shrink-0"></div>
                                        <div class="flex-1 space-y-2">
                                            <div class="h-5 w-36 skeleton"></div>
                                            <div class="h-4 w-full skeleton"></div>
                                            <div class="flex gap-2 pt-1">
                                                <div class="h-6 w-16 skeleton rounded-full"></div>
                                                <div class="h-6 w-16 skeleton rounded-full"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-[1.5rem] border border-gray-200 shadow-sm overflow-hidden">
                        <div id="requestDocsContainer">
                            <div class="flex items-center gap-4 border border-gray-100 rounded-xl p-4 animate-pulse mb-4">
                                <div class="w-12 h-12 skeleton rounded-xl flex-shrink-0"></div>
                                <div class="flex-1 space-y-3">
                                    <div class="h-4 w-32 skeleton"></div>
                                    <div class="h-3 w-full skeleton"></div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 border border-gray-100 rounded-xl p-4 animate-pulse">
                                <div class="w-12 h-12 skeleton rounded-xl flex-shrink-0"></div>
                                <div class="flex-1 space-y-3">
                                    <div class="h-4 w-32 skeleton"></div>
                                    <div class="h-3 w-full skeleton"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="xl:col-span-7 flex flex-col">

                    <div id="calendarSkeletonContainer"
                        class="bg-white skeleton-card border border-gray-200 shadow-sm rounded-[1.25rem] p-6 sm:p-7 w-full min-h-[450px] skeleton-section">

                        <div class="animate-pulse space-y-6">

                            <div class="h-6 w-40 skeleton mx-auto"></div>

                            <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:12px;">
                                @for ($i = 0; $i < 35; $i++)
                                    <div class="h-10 sm:h-12 skeleton rounded-xl"></div>
                                @endfor
                            </div>

                        </div>
                    </div>

                    <div class="relative">
                        <div
                            class="bg-gradient-to-r from-[#5A0000] to-[#8B0000] rounded-t-[1.25rem] px-6 py-6 pb-12 relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-1/2 translate-x-1/3">
                            </div>
                            <h2 class="relative z-10 text-2xl sm:text-3xl font-extrabold text-white">Dental Records</h2>
                            <p class="relative z-10 text-sm text-white/80 mt-1">A complete timeline of your treatments.</p>

                            <div class="relative z-10 flex flex-wrap gap-2.5 mt-4">
                                <div id="recordsStatVisits"
                                    class="flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold text-white bg-white/10 border border-white/20">
                                    <i class="fa-solid fa-list text-white/70"></i>
                                    <span id="recordsVisitCount">0 visits</span>
                                </div>
                                <div id="recordsStatLatest"
                                    class="hidden items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold text-white bg-white/10 border border-white/20">
                                    <i class="fa-regular fa-calendar text-white/70"></i>
                                    <span id="recordsLatestDate"></span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-b-[1.25rem] border border-gray-200 border-t-0 p-5 sm:p-6 -mt-6 relative z-10 shadow-sm">
                            <div id="viewAllContainer" class="hidden mb-6 flex items-center justify-between">
                                <h3 class="text-xs font-bold tracking-widest uppercase text-gray-500">Visit History</h3>
                                <a href="{{ route('patient.record') }}"
                                    class="inline-flex items-center gap-1.5 text-xs font-bold text-[#8B0000] hover:text-[#5A0000] transition-colors bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg">
                                    View All <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>

                            <div id="recordsInnerContainer">
                                <div class="space-y-4 animate-pulse">
                                    <div
                                        class="flex flex-col sm:flex-row items-start sm:items-center gap-4 border border-gray-100 rounded-xl p-4">
                                        <div class="w-10 h-10 rounded-full bg-gray-100 flex-shrink-0"></div>
                                        <div class="flex-1 space-y-2 w-full">
                                            <div class="h-4 w-40 skeleton"></div>
                                            <div class="h-3 w-56 skeleton"></div>
                                        </div>
                                        <div class="h-8 w-24 skeleton rounded-lg mt-2 sm:mt-0"></div>
                                    </div>
                                    <div
                                        class="flex flex-col sm:flex-row items-start sm:items-center gap-4 border border-gray-100 rounded-xl p-4">
                                        <div class="w-10 h-10 rounded-full bg-gray-100 flex-shrink-0"></div>
                                        <div class="flex-1 space-y-2 w-full">
                                            <div class="h-4 w-40 skeleton"></div>
                                            <div class="h-3 w-48 skeleton"></div>
                                        </div>
                                        <div class="h-8 w-24 skeleton rounded-lg mt-2 sm:mt-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <dialog id="record_modal" class="modal">
                <div class="modal-box p-0 w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl bg-gray-50">
                    <div class="bg-gradient-to-r from-[#5A0000] to-[#8B0000] px-6 sm:px-8 py-6 text-white relative">
                        <button onclick="document.getElementById('record_modal').close()"
                            class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-black/20 hover:bg-black/40 text-white transition-colors">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        <p class="text-[10px] font-bold tracking-widest text-white/60 mb-1 uppercase">Treatment Details</p>
                        <h3 id="m_service" class="text-2xl sm:text-3xl font-extrabold leading-tight">—</h3>
                        <div class="mt-4 flex flex-wrap items-center gap-3 text-sm font-medium">
                            <div class="flex items-center gap-2 bg-white/10 px-3 py-1.5 rounded-lg border border-white/20">
                                <i class="fa-regular fa-calendar"></i> <span id="m_date">—</span>
                            </div>
                            <div class="flex items-center gap-2 bg-white/10 px-3 py-1.5 rounded-lg border border-white/20">
                                <i class="fa-regular fa-clock"></i> <span id="m_time">—</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 sm:p-8 space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-4 text-center">
                                <div class="text-[10px] font-bold tracking-widest text-gray-400 mb-2 uppercase">Status
                                </div>
                                <div><span id="m_status"
                                        class="inline-flex px-3 py-1 text-xs rounded-full font-bold uppercase tracking-wider">—</span>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-4 text-center">
                                <div class="text-[10px] font-bold tracking-widest text-gray-400 mb-2 uppercase">Duration
                                </div>
                                <div><span id="m_duration"
                                        class="inline-flex px-3 py-1 text-xs rounded-full font-bold uppercase tracking-wider bg-gray-100 text-gray-700">—</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @foreach ([['TREATMENT REMARKS', 'm_remarks', 'fa-notes-medical'], ['ORAL EXAMINATION', 'm_oral', 'fa-tooth'], ['DIAGNOSIS', 'm_diagnosis', 'fa-stethoscope'], ['PRESCRIPTION', 'm_prescription', 'fa-pills']] as [$label, $mid, $icon])
                                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                                    <div class="bg-gray-50 border-b border-gray-100 px-4 py-3 flex items-center gap-2">
                                        <i class="fa-solid {{ $icon }} text-[#8B0000] opacity-80"></i>
                                        <span
                                            class="text-xs font-bold tracking-widest text-gray-700 uppercase">{{ $label }}</span>
                                    </div>
                                    <div class="p-4 text-gray-600 text-sm leading-relaxed break-words whitespace-pre-wrap">
                                        <span id="{{ $mid }}">—</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex justify-end pt-2">
                            <form method="dialog">
                                <button
                                    class="px-8 py-2.5 rounded-xl bg-gray-200 text-gray-800 font-bold hover:bg-gray-300 transition text-sm">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
                <form method="dialog" class="modal-backdrop"><button>close</button></form>
            </dialog>

            <dialog id="activeAppointmentModal" class="modal">
                <div class="modal-box p-8 rounded-[1.5rem] bg-white text-center shadow-2xl w-[min(92vw,400px)]">
                    <div
                        class="mx-auto mb-5 w-20 h-20 rounded-full bg-red-50 flex items-center justify-center border-4 border-white shadow-sm">
                        <i class="fa-solid fa-calendar-xmark text-[#8B0000] text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold text-gray-800 mb-3">Active Appointment</h3>
                    <p class="text-sm text-gray-500 mb-8 leading-relaxed">You already have an active appointment scheduled.
                        Please complete or cancel it before booking a new one.</p>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('patient.appointment.index') }}"
                            class="w-full py-3.5 rounded-xl bg-[#8B0000] text-white font-bold hover:bg-[#660000] transition-colors shadow-md">View
                            My Appointments</a>
                        <button id="closeActiveApptModalBtn" type="button"
                            class="w-full py-3.5 rounded-xl bg-gray-100 text-gray-700 font-bold hover:bg-gray-200 transition-colors">Close</button>
                    </div>
                </div>
            </dialog>

        </div>
    </main>

    @include('components.appointment-calendar-script', [
        'mode' => 'patient-dashboard',
        'renderStyle' => 'patient',
        'calendarContainerId' => 'calendarSkeletonContainer',
        'dateInputId' => null,
        'timeInputId' => null,
        'slotEndpoint' => route('book.appointment.slots'),
        'blockedDates' => $unavailableDates ?? [],
        'appointmentCountsPerDay' => $appointmentCountsPerDay ?? [],
        'philippineHolidays' => $philippineHolidays ?? [],
        'personalAppointments' => $calendarAppointments ?? [],
        'useDynamicScheduleRules' => false,
        'disallowToday' => false,
        'allowToggleOffDate' => false,
    ])
@endsection

@section('scripts')
    <script>
        function renderGreeting() {
            const nameEl = document.getElementById("patientName");
            const greetingEl = document.getElementById("greetingText");

            if (!nameEl || !greetingEl) return;

            nameEl.textContent = "{{ auth()->user()->name ?? 'Patient' }}";

            const h = new Date().getHours();
            let greeting = "";

            if (h < 12) {
                greeting = "Good Morning,";
            } else if (h < 18) {
                greeting = "Good Afternoon,";
            } else {
                greeting = "Good Evening,";
            }

            greetingEl.textContent = greeting + " ";
        }

        var HOME_RECORDS = @json($homeRecords ?? []);

        @php
            if (!isset($upcomingAppointment) || empty($upcomingAppointment)) {
                $upcomingAppointment = collect($appointments ?? [])
                    ->filter(function ($appt) {
                        $status = strtolower($appt->status ?? '');
                        return !in_array($status, ['completed', 'cancelled', 'declined']);
                    })
                    ->filter(function ($appt) {
                        return \Carbon\Carbon::parse($appt->appointment_date)->startOfDay()->gte(\Carbon\Carbon::today());
                    })
                    ->sortBy(function ($appt) {
                        return \Carbon\Carbon::parse($appt->appointment_date . ' ' . ($appt->appointment_time ?? '00:00:00'));
                    })
                    ->first();
            }

            $upcomingJs = null;
            if (isset($upcomingAppointment) && $upcomingAppointment) {
                $uD = \Carbon\Carbon::parse($upcomingAppointment->appointment_date);
                $uT = \Carbon\Carbon::parse($upcomingAppointment->appointment_time);
                $upcomingJs = [
                    'exists' => true,
                    'service' => $upcomingAppointment->service_type ?? '—',
                    'date' => $uD->format('M d, Y'),
                    'time_raw' => $upcomingAppointment->appointment_time,
                    'time_fmt' => $uT->format('g:i A'),
                    'dentist' => $upcomingAppointment->dentist_name ?? 'Dr. Nelson P. Angeles',
                    'status' => ucfirst($upcomingAppointment->status),
                    'isRescheduled' => strtolower($upcomingAppointment->status) === 'rescheduled',
                    'indexUrl' => route('patient.appointment.index'),
                    'bookUrl' => route('patient.book.appointment'),
                ];
            } else {
                $upcomingJs = [
                    'exists' => false,
                    'bookUrl' => route('patient.book.appointment'),
                ];
            }

            $profileRows = [['Date of Birth', isset($patient->birthdate) ? \Carbon\Carbon::parse($patient->birthdate)->format('F d, Y') : '—'], ['Age', $patient->age ?? '—'], ['Gender', $patient->gender ?? '—'], ['Contact', $patient->phone ?? '—'], ['Email', $patient->email ?? '—']];
        @endphp

        var UPCOMING_DATA = @json($upcomingJs);
        var PATIENT_NAME = "{{ urlencode($patient->name ?? 'Guest') }}";

        var PROFILE_DATA = {
            name: "{{ ucwords(strtolower($patient->name ?? 'Guest')) }}",
            course: "{{ $patient->faculty_code ? 'Faculty' : ($patient->student_no ? 'Student' : 'Patient') }}",
            yearLevel: "",
            facultyCode: "{{ $patient->faculty_code ?? '' }}",
            studentNo: "{{ $patient->student_no ?? '' }}",
            age: "{{ $patient->age ?? (\Carbon\Carbon::parse($patient->birthdate ?? now())->age ?? 'N/A') }}",
            birthdate: "{{ isset($patient->birthdate) ? \Carbon\Carbon::parse($patient->birthdate)->format('M d, Y') : 'N/A' }}",
            gender: "{{ $patient->gender ?? 'N/A' }}",
            contact: "{{ $patient->phone ?? 'N/A' }}",
            email: "{{ $patient->email ?? 'N/A' }}",
            emergencyName: "{{ optional($patient->medicalHistory)->emergency_person ?? 'Not specified' }}",
            emergencyNumber: "{{ optional($patient->medicalHistory)->emergency_number ?? 'N/A' }}",
            emergencyRelation: "{{ optional($patient->medicalHistory)->emergency_relation ?? '' }}",
            hasAlert: @json(
                (isset($patient->medicalHistory->diseaseAnswers) && $patient->medicalHistory->diseaseAnswers->count() > 0) ||
                    (isset($patient->medicalHistoryAnswers) &&
                        $patient->medicalHistoryAnswers->where('question.code', 'allergy_medicine')->where('answer_bool', true)->count() > 0)),
            avatar: @json($dashboardAvatarUrl)
        };

        var ROUTE_BOOK = "{{ route('patient.book.appointment') }}";
        var ROUTE_RECORD = "{{ route('patient.record') }}";

        @if (session('activeAppointmentModal'))
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
        @endif

        document.addEventListener('DOMContentLoaded', function() {
            const termsModal = document.getElementById('termsModal');
            const termsCheckbox = document.getElementById('termsCheckbox');
            const termsContinueBtn = document.getElementById('termsContinueBtn');
            const quickAction = new URLSearchParams(window.location.search).get('quick_action');

            if (termsCheckbox && termsContinueBtn) {
                termsCheckbox.checked = false;
                termsContinueBtn.disabled = true;

                termsCheckbox.addEventListener('change', function() {
                    termsContinueBtn.disabled = !this.checked;
                });
            }

            @if (session('show_terms_modal'))
                if (termsModal) {
                    termsModal.showModal();
                }
            @endif

            renderGreeting();

            if (quickAction === 'record') {
                setTimeout(() => {
                    document.getElementById('dentalHealthRecordModal')?.showModal();
                }, 150);
            }

            if (quickAction === 'clearance') {
                setTimeout(() => {
                    document.getElementById('dentalClearanceModal')?.showModal();
                }, 150);
            }

            if (quickAction) {
                const cleanUrl = new URL(window.location.href);
                cleanUrl.searchParams.delete('quick_action');
                window.history.replaceState({}, '', cleanUrl.toString());
            }

            setTimeout(function() {
                renderUpcomingAppointment();
                renderProfile();
                renderRequestDocs();
                renderRecords();
            }, 1500);
        });

        function acceptTerms() {
            const termsModal = document.getElementById('termsModal');
            if (termsModal) {
                termsModal.close();
            }
        }

        function escapeHtml(str) {
            return String(str ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g,
                '&quot;').replace(/'/g, '&#039;');
        }

        function formatTime(raw) {
            if (!raw) return '—';
            raw = String(raw).trim();
            if (/[AaPp][Mm]$/.test(raw)) return raw;
            var m = raw.match(/^(\d{1,2}):(\d{2})/);
            if (!m) return raw;
            var h = parseInt(m[1], 10),
                mn = m[2],
                ampm = h >= 12 ? 'PM' : 'AM',
                hr = h % 12 || 12;
            return hr + ':' + mn + ' ' + ampm;
        }

        function shortDate(raw) {
            if (!raw) return '—';
            return String(raw).replace(
                /^(January|February|March|April|May|June|July|August|September|October|November|December)/,
                function(s) {
                    return s.slice(0, 3);
                }
            );
        }

        function renderUpcomingAppointment() {
            var wrapper = document.getElementById('upcomingAppointmentWrapper');
            if (!wrapper) return;
            var d = UPCOMING_DATA;

            if (d.exists) {
                var statusPillCls = d.isRescheduled ? 'bg-yellow-100 text-yellow-800 border-yellow-200' :
                    'bg-green-100 text-green-800 border-green-200';
                var statusDotCls = d.isRescheduled ? 'bg-yellow-500' : 'bg-green-500';

                wrapper.innerHTML =
                    '<div class="upcoming-card-mobile bg-white rounded-[1.25rem] border border-gray-200 shadow-sm overflow-hidden fade-up">' +
                    '<div class="upcoming-card-header flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-4 sm:px-6 py-4 bg-gray-50 border-b border-gray-100">' +
                    '<div class="flex items-center gap-3">' +
                    '<div class="upcoming-card-header-icon w-10 h-10 rounded-full bg-red-50 text-[#8B0000] flex items-center justify-center flex-shrink-0">' +
                    '<i class="fa-regular fa-calendar-check text-lg"></i></div>' +
                    '<span class="upcoming-card-title text-gray-800 font-extrabold text-base">Upcoming Appointment</span></div>' +
                    '<span class="upcoming-status-pill inline-flex w-max items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold border ' +
                    statusPillCls + '">' +
                    '<span class="w-2 h-2 rounded-full ' + statusDotCls + '"></span>' + escapeHtml(d.status) +
                    '</span></div>' +
                    '<div class="upcoming-card-body px-4 sm:px-6 py-4 sm:py-5">' +
                    '<div class="upcoming-card-grid grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4">' +
                    '<div class="upcoming-info-box bg-gray-50/60 p-3.5 sm:p-4 rounded-xl border border-gray-100"><p class="upcoming-info-label text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Service</p><p class="upcoming-info-value text-sm md:text-[15px] font-extrabold text-[#8B0000]">' +
                    escapeHtml(d.service) + '</p></div>' +
                    '<div class="upcoming-info-box bg-gray-50/60 p-3.5 sm:p-4 rounded-xl border border-gray-100"><p class="upcoming-info-label text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Date &amp; Time</p><p class="upcoming-info-value text-sm md:text-[15px] font-extrabold text-gray-800">' +
                    escapeHtml(d.date) + '<span class="text-gray-300 mx-2">|</span>' + escapeHtml(d.time_fmt) +
                    '</p></div>' +
                    '<div class="upcoming-info-box bg-gray-50/60 p-3.5 sm:p-4 rounded-xl border border-gray-100"><p class="upcoming-info-label text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Dentist</p><p class="upcoming-info-value text-sm md:text-[15px] font-extrabold text-gray-800">' +
                    escapeHtml(d.dentist) + '</p></div>' +
                    '</div>' +
                    '<div class="upcoming-card-footer mt-5 pt-4 border-t border-gray-100 flex justify-end">' +
                    '<a href="' + escapeHtml(d.indexUrl) +
                    '" class="upcoming-manage-btn inline-flex items-center gap-2 text-sm font-bold text-[#8B0000] hover:text-[#5A0000] transition-colors bg-red-50 px-4 py-2 rounded-lg">Manage Appointment <i class="fa-solid fa-arrow-right text-xs"></i></a>' +
                    '</div></div></div>';
            } else {
                wrapper.innerHTML =
                    '<div class="bg-white rounded-[1.25rem] border border-gray-200 shadow-sm overflow-hidden fade-up">' +
                    '<div class="flex items-center gap-3 px-6 py-4 bg-gray-50 border-b border-gray-100">' +
                    '<div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center flex-shrink-0">' +
                    '<i class="fa-regular fa-calendar text-lg"></i></div>' +
                    '<span class="text-gray-600 font-bold text-base">No Upcoming Appointment</span></div>' +
                    '<div class="px-6 py-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">' +
                    '<p class="text-sm text-gray-500 leading-relaxed">Ready for your next visit? Book an appointment now to maintain your healthy smile.</p>' +
                    '<a href="' + escapeHtml(d.bookUrl) +
                    '" class="inline-flex items-center gap-2 bg-[#8B0000] text-white text-sm font-bold px-6 py-3 rounded-xl hover:bg-[#660000] transition-colors shadow-md w-full sm:w-auto justify-center"><i class="fa-solid fa-calendar-plus text-sm"></i> Book Now</a>' +
                    '</div></div>';
            }
        }

        function renderProfile() {
            var pData = PROFILE_DATA;
            console.log('PROFILE AVATAR:', pData.avatar);

            var emergencyRelation = pData.emergencyRelation ?
                '<span class="ml-1 text-gray-400">(' + escapeHtml(pData.emergencyRelation) + ')</span>' :
                '';

            var hasEmergency = pData.emergencyName && pData.emergencyName !== 'Not specified';

            var emergencySection = hasEmergency ?
                '<p class="text-sm font-bold text-gray-900">' + escapeHtml(pData.emergencyName) + '</p>' +
                '<p class="text-xs font-medium text-gray-600 mt-0.5">' +
                '<i class="fa-solid fa-phone text-[10px] mr-1"></i> ' +
                escapeHtml(pData.emergencyNumber) +
                emergencyRelation +
                '</p>' :
                '<div class="text-center py-2">' +
                '<i class="fa-solid fa-user-plus text-red-300 text-lg mb-1"></i>' +
                '<p class="text-xs text-gray-400 font-medium mb-2">No emergency contact added</p>' +
                '</div>';

            document.getElementById("profileSkeletonContainer").innerHTML =
                '<div class="overflow-hidden fade-up">' +

                '<div class="h-24 bg-gradient-to-r from-[#8B0000] to-[#b30000] relative"></div>' +

                '<div class="px-5 pb-5 relative flex flex-col items-center mt-[-40px]">' +
                '<div class="relative mb-3">' +
                '<img src="' + pData.avatar + '" alt="Profile" ' +
                'class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-md bg-white">' +
                '</div>' +

                '<h2 class="text-[19px] font-extrabold text-gray-900 text-center leading-tight">' +
                escapeHtml(pData.name) +
                '</h2>' +

                '<p class="text-[13px] font-medium text-gray-500 mt-1 text-center">' +
                escapeHtml(pData.course) +
                (pData.yearLevel ? ' ' + escapeHtml(pData.yearLevel) : '') +
                '</p>' +

                (
                    pData.facultyCode && pData.facultyCode !== 'null' ?
                    '<div class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-full text-xs font-bold tracking-wide">' +
                    '<i class="fa-regular fa-id-badge text-[10px]"></i> ' +
                    escapeHtml('Faculty Code: ' + pData.facultyCode) +
                    '</div>' :
                    (
                        pData.studentNo && pData.studentNo !== 'null' ?
                        '<div class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-full text-xs font-bold tracking-wide">' +
                        '<i class="fa-regular fa-id-badge text-[10px]"></i> ' +
                        escapeHtml('Student No: ' + pData.studentNo) +
                        '</div>' :
                        ''
                    )
                ) +
                '</div>' +

                '<div class="border-t border-gray-100"></div>' +

                '<div class="px-5 py-4 space-y-3 text-sm">' +

                '<div class="flex justify-between items-center gap-4">' +
                '<span class="text-gray-400 font-semibold text-xs flex items-center gap-2">' +
                '<i class="fa-solid fa-cake-candles w-3"></i> Age <br> Date of Birth' +
                '</span>' +
                '<span class="text-gray-800 font-medium text-right">' +
                escapeHtml(pData.age ? pData.age + " yrs" : "N/A") +
                '<span class="text-gray-400 text-xs font-normal block">' +
                escapeHtml(pData.birthdate) +
                '</span>' +
                '</span>' +
                '</div>' +

                '<div class="flex justify-between items-center gap-4">' +
                '<span class="text-gray-400 font-semibold text-xs flex items-center gap-2">' +
                '<i class="fa-solid fa-venus-mars w-3"></i> Gender' +
                '</span>' +
                '<span class="text-gray-800 font-medium text-right">' +
                escapeHtml(pData.gender) +
                '</span>' +
                '</div>' +

                '<div class="flex justify-between items-start gap-4">' +
                '<span class="text-gray-400 font-semibold text-xs flex items-center gap-2 mt-0.5">' +
                '<i class="fa-solid fa-phone w-3"></i> Contact' +
                '</span>' +
                '<span class="text-gray-800 font-medium text-right">' +
                escapeHtml(pData.contact) +
                '</span>' +
                '</div>' +

                '<div class="flex justify-between items-start gap-3">' +
                '<span class="text-gray-400 font-semibold text-xs flex items-center gap-2 mt-0.5 flex-shrink-0 w-[92px]">' +
                '<i class="fa-solid fa-envelope w-3"></i> Email' +
                '</span>' +
                '<span class="text-gray-800 font-medium text-right break-words leading-snug flex-1 min-w-0">' +
                escapeHtml(pData.email) +
                '</span>' +
                '</div>' +

                '</div>' +

                '<div class="bg-red-50/50 px-5 py-4 border-t border-red-100">' +
                '<p class="text-[10px] font-bold text-red-800 uppercase tracking-widest mb-2 flex items-center gap-1.5">' +
                '<i class="fa-solid fa-heart-pulse"></i> Emergency Contact' +
                '</p>' +
                emergencySection +
                '</div>' +

                '</div>';
        }

        function renderRequestDocs() {
            document.getElementById("requestDocsContainer").innerHTML =
                '<div class="bg-gradient-to-r from-[#7A0000] to-[#A40000] px-5 sm:px-6 py-5 text-white">' +
                '<div class="flex items-start sm:items-center justify-between gap-4">' +
                '<div class="min-w-0">' +
                '<div class="inline-flex items-center gap-2 text-[10px] font-bold tracking-[0.18em] uppercase text-white/70 mb-2">' +
                '<i class="fa-solid fa-file-lines"></i>' +
                '<span>Patient Services</span>' +
                '</div>' +
                '<h3 class="text-xl sm:text-2xl font-extrabold leading-tight">Request Documents</h3>' +
                '<p class="text-sm text-white/80 mt-1">Need a copy of your records or clearance? Submit a request here.</p>' +
                '</div>' +
                '<div class="hidden sm:flex w-12 h-12 rounded-2xl bg-white/10 border border-white/15 items-center justify-center flex-shrink-0">' +
                '<i class="fa-solid fa-folder-open text-lg"></i>' +
                '</div>' +
                '</div>' +
                '</div>' +

                '<div class="p-5 sm:p-6 bg-gradient-to-b from-red-50/40 to-white">' +
                '<div class="grid grid-cols-1 gap-3">' +

                '<button type="button" onclick="document.getElementById(\'dentalHealthRecordModal\')?.showModal()" ' +
                'class="group relative w-full text-left rounded-2xl border border-red-100 bg-white p-5 sm:p-6 shadow-sm hover:shadow-md hover:border-red-200 transition-all duration-200">' +
                '<div class="flex items-start gap-4">' +
                '<div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-red-50 text-[#8B0000] flex items-center justify-center flex-shrink-0 group-hover:bg-red-100 transition-colors">' +
                '<i class="fa-solid fa-file-medical text-lg sm:text-xl"></i>' +
                '</div>' +
                '<div class="min-w-0 flex-1">' +
                '<div class="flex items-center gap-2 mb-1.5">' +
                '<h4 class="text-[15px] sm:text-base font-extrabold text-gray-900 group-hover:text-[#8B0000] transition-colors">Dental Health Record</h4>' +
                '<span class="inline-flex items-center rounded-full bg-red-50 text-[#8B0000] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide">Most Requested</span>' +
                '</div>' +
                '<p class="text-sm text-gray-500 leading-relaxed">Request a copy of all dental records, medical details, diagnosis, and treatment history.</p>' +
                '<div class="mt-3 flex flex-wrap gap-2">' +
                '<span class="inline-flex items-center rounded-full bg-gray-50 text-gray-600 px-2.5 py-1 text-[11px] font-semibold">All Records</span>' +
                '<span class="inline-flex items-center rounded-full bg-gray-50 text-gray-600 px-2.5 py-1 text-[11px] font-semibold">Medical</span>' +
                '<span class="inline-flex items-center rounded-full bg-gray-50 text-gray-600 px-2.5 py-1 text-[11px] font-semibold">Diagnosis</span>' +
                '</div>' +
                '</div>' +
                '<div class="pt-1 text-gray-300 group-hover:text-[#8B0000] transition-colors">' +
                '<i class="fa-solid fa-arrow-up-right-from-square text-sm"></i>' +
                '</div>' +
                '</div>' +
                '</button>' +

                '<button type="button" onclick="document.getElementById(\'dentalClearanceModal\')?.showModal()" ' +
                'class="group relative w-full text-left rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 shadow-sm hover:shadow-md hover:border-red-200 transition-all duration-200">' +
                '<div class="flex items-start gap-4">' +
                '<div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-100 transition-colors">' +
                '<i class="fa-solid fa-file-circle-check text-lg sm:text-xl"></i>' +
                '</div>' +
                '<div class="min-w-0 flex-1">' +
                '<div class="flex items-center gap-2 mb-1.5">' +
                '<h4 class="text-[15px] sm:text-base font-extrabold text-gray-900 group-hover:text-[#8B0000] transition-colors">Dental Clearance</h4>' +
                '<span class="inline-flex items-center rounded-full bg-amber-50 text-amber-700 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide">School / Requirement</span>' +
                '</div>' +
                '<p class="text-sm text-gray-500 leading-relaxed">Request a dental clearance for school, annual compliance, or other official requirements.</p>' +
                '<div class="mt-3 flex flex-wrap gap-2">' +
                '<span class="inline-flex items-center rounded-full bg-gray-50 text-gray-600 px-2.5 py-1 text-[11px] font-semibold">Standard</span>' +
                '<span class="inline-flex items-center rounded-full bg-gray-50 text-gray-600 px-2.5 py-1 text-[11px] font-semibold">Annual</span>' +
                '</div>' +
                '</div>' +
                '<div class="pt-1 text-gray-300 group-hover:text-[#8B0000] transition-colors">' +
                '<i class="fa-solid fa-arrow-up-right-from-square text-sm"></i>' +
                '</div>' +
                '</div>' +
                '</button>' +

                '</div>' +
                '</div>';
        }

        function renderRecords() {
            var container = document.getElementById("recordsInnerContainer");
            var viewAll = document.getElementById("viewAllContainer");
            var visitCount = document.getElementById("recordsVisitCount");
            var statLatest = document.getElementById("recordsStatLatest");
            var latestDate = document.getElementById("recordsLatestDate");
            if (!container) return;

            if (!HOME_RECORDS || HOME_RECORDS.length === 0) {
                if (visitCount) visitCount.textContent = "0 visits";
                container.innerHTML =
                    '<div class="flex flex-col items-center justify-center py-12 px-6 text-center">' +
                    '<div class="w-20 h-20 rounded-full bg-gray-50 flex items-center justify-center mb-4">' +
                    '<i class="fa-solid fa-tooth text-3xl text-gray-300"></i></div>' +
                    '<p class="text-lg font-extrabold text-gray-800 mb-2">No records yet</p>' +
                    '<p class="text-sm text-gray-500 max-w-[300px] leading-relaxed mb-6">Completed appointment records will appear here after your first visit.</p>' +
                    '<a href="' + ROUTE_BOOK +
                    '" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition-colors">' +
                    '<i class="fa-solid fa-calendar-plus"></i> Book First Appointment</a>' +
                    '</div>';
                if (viewAll) viewAll.classList.add("hidden");
                return;
            }

            var count = HOME_RECORDS.length;
            if (visitCount) visitCount.textContent = count + (count === 1 ? " visit" : " visits");
            if (statLatest && latestDate && HOME_RECORDS[0].date) {
                var pts = HOME_RECORDS[0].date.split(" ");
                latestDate.textContent = "Latest: " + (pts[0] ? pts[0].slice(0, 3) : "") + " " + (pts[2] || "");
                statLatest.classList.remove("hidden");
                statLatest.classList.add("flex");
            }

            if (viewAll) {
                viewAll.classList.remove("hidden");
                viewAll.classList.add("flex");
            }

            var html = '<div class="space-y-4">';
            HOME_RECORDS.forEach(function(r, idx) {
                var encoded = encodeURIComponent(JSON.stringify(r));
                var dispTime = formatTime(r.time);
                var dispDate = shortDate(r.date);

                html +=
                    '<div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all hover:shadow-md hover:border-red-100 group">' +
                    '<div class="flex items-start sm:items-center gap-4 min-w-0">' +
                    '<div class="w-10 h-10 rounded-full bg-red-50 text-[#8B0000] flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"><i class="fa-solid fa-tooth text-sm"></i></div>' +
                    '<div class="min-w-0 flex-1">' +
                    '<p class="text-sm sm:text-base font-extrabold text-gray-800 truncate mb-1.5">' + escapeHtml(r
                        .service) + '</p>' +
                    '<div class="flex flex-wrap items-center gap-2">' +
                    '<span class="inline-flex items-center gap-1.5 bg-gray-50 border border-gray-100 text-gray-600 rounded-md px-2 py-1 text-[10px] sm:text-xs font-bold">' +
                    '<i class="fa-regular fa-calendar opacity-70"></i>' + escapeHtml(dispDate) + '</span>' +
                    '<span class="inline-flex items-center gap-1.5 bg-gray-50 border border-gray-100 text-gray-600 rounded-md px-2 py-1 text-[10px] sm:text-xs font-bold">' +
                    '<i class="fa-regular fa-clock opacity-70"></i>' + escapeHtml(dispTime) + '</span>' +
                    '</div></div></div>' +
                    '<button type="button" class="w-full sm:w-auto flex-shrink-0 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-gray-50 hover:bg-[#8B0000] hover:text-white text-gray-700 text-xs font-bold transition-all shadow-sm border border-gray-200 hover:border-transparent" onclick="openRecordModalFromData(\'' +
                    encoded + '\')">' +
                    'Details <i class="fa-solid fa-arrow-right text-[10px]"></i></button>' +
                    '</div>';
            });
            html += '</div>';
            container.innerHTML = html;
        }

        function openRecordModalFromData(encodedJson) {
            openRecordModal(JSON.parse(decodeURIComponent(encodedJson)));
        }

        function openRecordModal(data) {
            var modal = document.getElementById('record_modal');
            if (!modal) return;
            document.getElementById('m_service').textContent = data.service || '—';
            document.getElementById('m_date').textContent = data.date || '—';
            document.getElementById('m_time').textContent = formatTime(data.time);
            var BADGE = 'inline-flex px-3 py-1 text-xs rounded-full font-bold uppercase tracking-wider';
            var status = (data.status || 'completed').trim();
            var sEl = document.getElementById('m_status');
            sEl.textContent = status;
            sEl.className = BADGE;
            var s = status.toLowerCase();
            if (s === 'completed') sEl.classList.add('bg-green-100', 'text-green-800');
            else if (s === 'rescheduled') sEl.classList.add('bg-yellow-100', 'text-yellow-800');
            else if (s === 'cancelled') sEl.classList.add('bg-red-100', 'text-red-800');
            else sEl.classList.add('bg-gray-100', 'text-gray-700');

            var dEl = document.getElementById('m_duration');
            dEl.textContent = (data.duration || '—').trim() || '—';
            dEl.className = BADGE + ' bg-gray-100 text-gray-700';

            document.getElementById('m_remarks').textContent = (data.remarks || '').trim() || '—';
            document.getElementById('m_oral').textContent = (data.oral || '').trim() || '—';
            document.getElementById('m_diagnosis').textContent = (data.diagnosis || '').trim() || '—';
            document.getElementById('m_prescription').textContent = (data.prescription || '').trim() || '—';
            modal.showModal();
        }
    </script>
@endsection
