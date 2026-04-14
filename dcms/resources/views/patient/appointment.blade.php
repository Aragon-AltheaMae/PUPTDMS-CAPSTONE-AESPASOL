@extends('layouts.patient')

@section('title', 'PUP Taguig Dental Clinic | Appointment')

@section('styles')
    <style>
        @keyframes fadeUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeUp 0.6s ease-out forwards;
        }

        @keyframes apptSlideUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes apptPulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.35;
            }
        }

        #mainContent {
            margin-left: 220px;
            transition: margin-left .3s ease;
        }

        @media (max-width: 767px) {
            #mainContent {
                margin-left: 0 !important;
                padding-bottom: 110px;
            }
        }

        .appt-tab.appt-active {
            background: #8B0000;
            color: white;
            box-shadow: 0 4px 12px rgba(139, 0, 0, 0.2);
        }

        .appt-tab.appt-active .appt-count {
            background: rgba(255, 255, 255, 0.25);
            color: white;
        }

        .service-card {
            position: relative;
            overflow: hidden;
            transition: transform 0.45s ease, box-shadow 0.45s ease;
        }

        .service-card::before {
            content: "";
            position: absolute;
            inset: -12px;
            background: linear-gradient(135deg, #8B0000, #660000);
            opacity: 0;
            border-radius: 1.25rem;
            transition: opacity 0.45s ease;
            z-index: 0;
        }

        .service-card:hover::before {
            opacity: 1;
        }

        .service-card:hover {
            transform: scale(1.06);
            z-index: 20;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.35);
        }

        .service-card>* {
            position: relative;
            z-index: 1;
        }

        .service-card img {
            transition: transform 0.45s ease;
        }

        .service-card:hover img {
            transform: translateX(-6px) scale(1.08);
        }

        dialog#appt_detail_modal::backdrop {
            background: rgba(16, 16, 16, .45);
        }
    </style>
@endsection

@section('content')

    @php
        $calendarAppointments = [];
        foreach (
            collect($appointments ?? [])->filter(function ($appt) {
                $status = strtolower($appt->status ?? '');
                return !in_array($status, ['completed', 'cancelled']);
            })
            as $appt
        ) {
            $calendarAppointments[\Carbon\Carbon::parse($appt->appointment_date)->format('Y-m-d')] =
                $appt->service_type . ' • ' . $appt->appointment_time;
        }
    @endphp

    <main id="mainContent" class="pt-[90px] px-3 md:px-6 py-6 fade-in min-h-screen flex-1">
        <div class="w-full fade-in">

            <section class="fade-up mb-10 sm:mb-14">
                <div id="calendarSkeletonContainer"
                    class="bg-white dark:bg-[#000D1A] border border-gray-100 dark:border-[#1a2a3a] shadow-sm rounded-2xl p-4 sm:p-6 w-full min-h-[420px]">
                    <div class="animate-pulse space-y-4">
                        <div class="h-6 w-32 bg-gray-200 dark:bg-gray-800 rounded mx-auto"></div>
                        <div class="grid grid-cols-7 gap-2">
                            @for ($i = 0; $i < 35; $i++)
                                <div class="h-8 sm:h-10 bg-gray-100 dark:bg-gray-800 rounded-lg"></div>
                            @endfor
                        </div>
                    </div>
                </div>
            </section>

            <section class="fade-up mb-12 sm:mb-16">

                <div class="flex flex-col md:flex-row md:items-end justify-between mb-6 gap-4">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#660000] dark:text-[#ff6b6b] leading-tight">My
                            Appointments</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            You have {{ $futureVisits->count() }} upcoming
                            {{ $futureVisits->count() === 1 ? 'visit' : 'visits' }} scheduled
                        </p>
                    </div>
                    <a href="{{ route('patient.book.appointment') }}"
                        class="inline-flex items-center justify-center gap-2 bg-[#8B0000] hover:bg-[#A31515] text-white px-6 py-3 rounded-full font-bold shadow-md transition-all hover:-translate-y-0.5 whitespace-nowrap w-full md:w-auto">
                        <i class="fa-solid fa-plus text-sm"></i> Book Appointment
                    </a>
                </div>

                @php
                    $futureCount = $futureVisits->count();
                    $pastCount = $pastVisits->count();
                @endphp

                <div
                    class="flex flex-row bg-white dark:bg-[#000D1A] rounded-xl p-1 shadow-sm border border-gray-200 dark:border-[#1a2a3a] mb-6 w-full md:w-max">
                    <button
                        class="appt-tab appt-active flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-2.5 text-[13px] font-bold rounded-lg text-gray-500 transition-all"
                        id="apptFutureTab" onclick="apptShowFuture()">
                        Future Visits
                        <span
                            class="appt-count text-[11px] font-extrabold px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 transition-all">{{ $futureCount }}</span>
                    </button>
                    <button
                        class="appt-tab flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-2.5 text-[13px] font-bold rounded-lg text-gray-500 transition-all"
                        id="apptPastTab" onclick="apptShowPast()">
                        Past Visits
                        <span
                            class="appt-count text-[11px] font-extrabold px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 transition-all">{{ $pastCount }}</span>
                    </button>
                </div>

                <div id="apptFuturePanel">
                    @if ($futureVisits->count())
                        <div
                            class="text-xs font-bold tracking-[0.12em] uppercase text-gray-400 mb-4 flex items-center gap-3">
                            Upcoming <div class="h-px flex-1 bg-gray-200 dark:bg-gray-800"></div>
                        </div>

                        @foreach ($futureVisits as $index => $appt)
                            @php
                                $apptDate = \Carbon\Carbon::parse($appt->appointment_date);
                                $apptTime = \Carbon\Carbon::parse($appt->appointment_time);
                                $now = \Carbon\Carbon::now();
                                $diffDays = (int) $now
                                    ->startOfDay()
                                    ->diffInDays($apptDate->copy()->startOfDay(), false);
                                if ($diffDays === 0) {
                                    $countdown = 'Today';
                                } elseif ($diffDays === 1) {
                                    $countdown = 'Tomorrow';
                                } else {
                                    $countdown = 'In ' . $diffDays . ' days';
                                }

                                $rawStatus = strtolower($appt->status ?? 'scheduled');
                                $badgeColors = match ($rawStatus) {
                                    'upcoming' => 'bg-orange-100 text-orange-700',
                                    'confirmed' => 'bg-emerald-100 text-emerald-700',
                                    default => 'bg-orange-100 text-orange-700',
                                };
                                $showDot = in_array($rawStatus, ['upcoming', 'scheduled']);
                            @endphp

                            <div class="bg-white dark:bg-[#0a1628] border border-gray-100 dark:border-[#1a2a3a] rounded-[1.25rem] shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col sm:flex-row mb-4 animate-[apptSlideUp_0.35s_ease_backwards]"
                                style="animation-delay: {{ $index * 0.08 }}s">

                                <div
                                    class="bg-red-50/70 dark:bg-[#111827] flex flex-row sm:flex-col items-center sm:justify-center px-5 py-4 sm:py-6 sm:w-[100px] border-b sm:border-b-0 sm:border-r border-red-100 dark:border-[#1a2a3a] gap-3 sm:gap-0 flex-shrink-0">
                                    <span
                                        class="text-3xl sm:text-4xl font-extrabold text-[#8B0000] dark:text-[#ff6b6b] leading-none">{{ $apptDate->format('d') }}</span>
                                    <div
                                        class="flex sm:flex-col items-baseline sm:items-center gap-1 sm:gap-0 mt-0 sm:mt-1">
                                        <span
                                            class="text-xs font-bold tracking-widest uppercase text-red-700 dark:text-red-400">{{ $apptDate->format('M') }}</span>
                                        <span class="text-[11px] text-gray-500">{{ $apptDate->format('Y') }}</span>
                                    </div>
                                </div>

                                <div class="p-4 sm:p-5 flex-1 flex flex-col gap-3 min-w-0 justify-center">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span
                                            class="text-base font-bold text-gray-800 dark:text-gray-200 truncate">{{ $appt->service_type }}{{ $appt->other_services ? ' (' . $appt->other_services . ')' : '' }}</span>
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase {{ $badgeColors }}">
                                            @if ($showDot)
                                                <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span>
                                            @endif
                                            {{ ucfirst($rawStatus) }}
                                        </span>
                                    </div>
                                    <div
                                        class="flex flex-wrap items-center gap-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center gap-1.5"><i
                                                class="fa-regular fa-clock text-red-700/70 dark:text-red-400"></i> <strong
                                                class="text-gray-700 dark:text-gray-300">{{ $apptTime->format('g:i A') }} –
                                                {{ $apptTime->copy()->addHour()->format('g:i A') }}</strong></div>
                                        <div class="flex items-center gap-1.5"><i
                                                class="fa-regular fa-user text-red-700/70 dark:text-red-400"></i> Dr. Nelson
                                            Angeles</div>
                                    </div>
                                </div>

                                <div
                                    class="p-4 sm:p-5 border-t sm:border-t-0 border-gray-50 dark:border-[#1a2a3a] flex flex-row sm:flex-col items-center sm:items-end justify-between gap-3 flex-shrink-0 bg-gray-50/30 dark:bg-transparent">
                                    <button
                                        class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:text-[#8B0000] hover:bg-red-50 dark:hover:bg-gray-800 transition-colors">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <span
                                        class="px-3 py-1.5 rounded-full bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-900/50 text-[#8B0000] dark:text-red-400 text-xs font-bold whitespace-nowrap">{{ $countdown }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div
                            class="text-center py-12 px-5 bg-white dark:bg-[#000D1A] rounded-2xl border border-dashed border-gray-200 dark:border-gray-800">
                            <img src="{{ asset('images/future-visit.png') }}" alt="No Upcoming Visits"
                                class="w-20 mx-auto mb-4 opacity-60">
                            <p class="text-lg font-bold text-gray-600 dark:text-gray-400 mb-1">No Upcoming Visits</p>
                            <p class="text-sm text-gray-400">You currently have no scheduled appointments.</p>
                        </div>
                    @endif
                </div>

                <div id="apptPastPanel" style="display:none;">
                    @if ($pastVisits->count())
                        <div
                            class="text-xs font-bold tracking-[0.12em] uppercase text-gray-400 mb-4 flex items-center gap-3">
                            Recent History <div class="h-px flex-1 bg-gray-200 dark:bg-gray-800"></div>
                        </div>

                        @foreach ($pastVisits as $index => $appt)
                            @php
                                $apptDate = \Carbon\Carbon::parse($appt->appointment_date);
                                $apptTime = \Carbon\Carbon::parse($appt->appointment_time);
                                $rawStatus = 'completed';
                                $modalPayload = [
                                    'service' => $appt->service_type ?? '—',
                                    'date' => $appt->appointment_date
                                        ? \Carbon\Carbon::parse($appt->appointment_date)->format('F d, Y')
                                        : '—',
                                    'time' => $appt->appointment_time
                                        ? \Carbon\Carbon::parse($appt->appointment_time)->format('H:i:s')
                                        : '—',
                                    'status' => $rawStatus,
                                    'duration' => $appt->duration ?? '—',
                                    'remarks' => $appt->remarks ?? '—',
                                    'oral' => $appt->oral_examination ?? '—',
                                    'diagnosis' => $appt->diagnosis ?? '—',
                                    'prescription' => $appt->prescription ?? '—',
                                ];
                            @endphp

                            <div class="bg-white dark:bg-[#0a1628] border border-gray-100 dark:border-[#1a2a3a] rounded-[1.25rem] shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col sm:flex-row mb-4 animate-[apptSlideUp_0.35s_ease_backwards]"
                                style="animation-delay: {{ $index * 0.08 }}s">

                                <div
                                    class="bg-gray-50 dark:bg-[#111827] flex flex-row sm:flex-col items-center sm:justify-center px-5 py-4 sm:py-6 sm:w-[100px] border-b sm:border-b-0 sm:border-r border-gray-100 dark:border-[#1a2a3a] gap-3 sm:gap-0 flex-shrink-0 opacity-80">
                                    <span
                                        class="text-3xl sm:text-4xl font-extrabold text-gray-500 leading-none">{{ $apptDate->format('d') }}</span>
                                    <div
                                        class="flex sm:flex-col items-baseline sm:items-center gap-1 sm:gap-0 mt-0 sm:mt-1">
                                        <span
                                            class="text-xs font-bold tracking-widest uppercase text-gray-400">{{ $apptDate->format('M') }}</span>
                                        <span class="text-[11px] text-gray-400">{{ $apptDate->format('Y') }}</span>
                                    </div>
                                </div>

                                <div class="p-4 sm:p-5 flex-1 flex flex-col gap-3 min-w-0 justify-center">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span
                                            class="text-base font-bold text-gray-600 dark:text-gray-400 truncate">{{ $appt->service_type }}{{ $appt->other_services ? ' (' . $appt->other_services . ')' : '' }}</span>
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400">
                                            <i class="fa-solid fa-check"></i> Completed
                                        </span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-4 text-sm font-medium text-gray-400">
                                        <div class="flex items-center gap-1.5"><i class="fa-regular fa-clock"></i> <strong
                                                class="text-gray-500 dark:text-gray-400">{{ $apptTime->format('g:i A') }} –
                                                {{ $apptTime->copy()->addHour()->format('g:i A') }}</strong></div>
                                        <div class="flex items-center gap-1.5"><i class="fa-regular fa-user"></i> Dr. Nelson
                                            Angeles</div>
                                    </div>
                                </div>

                                <div
                                    class="p-4 sm:p-5 border-t sm:border-t-0 border-gray-50 dark:border-[#1a2a3a] flex flex-row sm:flex-col items-center sm:items-end justify-between gap-3 flex-shrink-0 bg-gray-50/30 dark:bg-transparent">
                                    <button
                                        class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:text-[#8B0000] hover:bg-red-50 dark:hover:bg-gray-800 transition-colors hidden sm:flex">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <button type="button"
                                        class="px-4 py-1.5 rounded-full bg-white dark:bg-[#111827] border border-gray-200 dark:border-[#21262d] text-gray-700 dark:text-gray-300 hover:bg-[#8B0000] hover:text-white hover:border-[#8B0000] transition-colors text-xs font-bold"
                                        data-appt='@json($modalPayload)' onclick="openApptDetailModal(this)">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div
                            class="text-center py-12 px-5 bg-white dark:bg-[#000D1A] rounded-2xl border border-dashed border-gray-200 dark:border-gray-800">
                            <img src="{{ asset('images/past-visit.png') }}" alt="No Past Visits"
                                class="w-20 mx-auto mb-4 opacity-60">
                            <p class="text-lg font-bold text-gray-600 dark:text-gray-400 mb-1">No Past Visits Yet</p>
                            <p class="text-sm text-gray-400">Your completed appointments will appear here.</p>
                        </div>
                    @endif
                </div>

            </section>

            <section class="mt-2 mb-8 fade-up">
                <h2
                    class="text-2xl sm:text-3xl font-extrabold bg-gradient-to-r from-[#8B0000] to-[#FFD700] bg-clip-text text-transparent mb-5 sm:mb-6">
                    Services Offered
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 rounded-2xl overflow-hidden bg-[#8B0000]">
                    <div class="service-card relative p-6 sm:p-10 text-[#F4F4F4] border-b md:border-r border-[#F4F4F4]/20">
                        <h3 class="text-lg sm:text-2xl font-bold mb-1 sm:mb-2">Oral Check-Up</h3>
                        <p class="text-xs sm:text-sm max-w-[55%] sm:max-w-xs text-white/80">Routine oral examination •
                            Dental consultation</p>
                        <img src="{{ asset('images/oral-checkup.png') }}"
                            class="absolute right-4 sm:right-6 inset-y-0 my-auto w-16 sm:w-28" alt="Oral Checkup" />
                    </div>
                    <div class="service-card relative p-6 sm:p-10 text-[#F4F4F4] border-b border-[#F4F4F4]/20">
                        <h3 class="text-lg sm:text-2xl font-bold mb-1 sm:mb-2">Dental Cleaning</h3>
                        <p class="text-xs sm:text-sm max-w-[55%] sm:max-w-xs text-white/80">Oral hygiene treatment •
                            Removing surface buildup</p>
                        <img src="{{ asset('images/dental-cleaning.png') }}"
                            class="absolute right-4 sm:right-6 inset-y-0 my-auto w-16 sm:w-28" alt="Dental Cleaning" />
                    </div>
                    <div
                        class="service-card relative p-6 sm:p-10 text-[#F4F4F4] border-b md:border-b-0 md:border-r border-[#F4F4F4]/20">
                        <h3 class="text-lg sm:text-2xl font-bold mb-1 sm:mb-2">Dental Restoration</h3>
                        <p class="text-xs sm:text-sm max-w-[55%] sm:max-w-xs text-white/80">Repairs damaged teeth •
                            Fillings • Crowns</p>
                        <img src="{{ asset('images/restoration-prosthesis.png') }}"
                            class="absolute right-4 sm:right-6 inset-y-0 my-auto w-16 sm:w-28"
                            alt="Restoration & Prosthesis" />
                    </div>
                    <div class="service-card relative p-6 sm:p-10 text-[#F4F4F4]">
                        <h3 class="text-lg sm:text-2xl font-bold mb-1 sm:mb-2">Dental Surgery</h3>
                        <p class="text-xs sm:text-sm max-w-[55%] sm:max-w-xs text-white/80">Treating dental issues
                            surgically • Extraction</p>
                        <img src="{{ asset('images/dental-surgery.png') }}"
                            class="absolute right-4 sm:right-6 inset-y-0 my-auto w-16 sm:w-28" alt="Dental Surgery" />
                    </div>
                </div>
            </section>

            <dialog id="appt_detail_modal" class="modal">
                <div class="modal-box p-0 w-full max-w-md rounded-2xl bg-[#F4F4F4] overflow-hidden dark:bg-[#000D1A]">
                    <div class="bg-gradient-to-r from-[#7A0000] to-[#8B0000] px-5 sm:px-6 py-5 text-white">
                        <h3 id="d_service" class="text-xl sm:text-2xl font-extrabold leading-tight">—</h3>
                        <div class="mt-3 flex flex-wrap items-center gap-3 text-white/90 text-sm font-medium">
                            <div class="flex items-center gap-1.5"><i class="fa-regular fa-calendar"></i><span
                                    id="d_date">—</span></div>
                            <span class="opacity-50">|</span>
                            <div class="flex items-center gap-1.5"><i class="fa-regular fa-clock"></i><span
                                    id="d_time">—</span></div>
                        </div>
                    </div>
                    <div class="px-5 py-6 space-y-5">
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="bg-white dark:bg-[#0d1f35] border border-gray-200 dark:border-[#1a2a3a] rounded-xl p-4 text-center">
                                <div class="text-[10px] font-extrabold tracking-widest text-gray-500 mb-2">STATUS</div>
                                <span id="d_status"
                                    class="inline-flex px-3 py-1 text-xs rounded-full font-bold bg-emerald-100 text-emerald-800">—</span>
                            </div>
                            <div
                                class="bg-white dark:bg-[#0d1f35] border border-gray-200 dark:border-[#1a2a3a] rounded-xl p-4 text-center">
                                <div class="text-[10px] font-extrabold tracking-widest text-gray-500 mb-2">DURATION</div>
                                <span id="d_duration"
                                    class="inline-flex px-3 py-1 text-xs rounded-full font-bold bg-gray-100 text-gray-700">—</span>
                            </div>
                        </div>
                        @foreach ([['TREATMENT', 'd_remarks'], ['ORAL EXAM', 'd_oral'], ['DIAGNOSIS', 'd_diagnosis'], ['PRESCRIPTION', 'd_prescription']] as [$label, $id])
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <span
                                        class="text-[10px] font-extrabold tracking-widest text-[#8B0000] dark:text-[#ff6b6b]">{{ $label }}</span>
                                    <div class="h-px flex-1 bg-gray-200 dark:bg-[#1a2a3a]"></div>
                                </div>
                                <div
                                    class="bg-white dark:bg-[#0d1f35] rounded-xl p-4 border border-gray-100 dark:border-[#1a2a3a]">
                                    <span id="{{ $id }}"
                                        class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed break-words">—</span>
                                </div>
                            </div>
                        @endforeach
                        <div class="flex justify-end pt-2">
                            <form method="dialog">
                                <button
                                    class="px-8 py-2.5 rounded-xl bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200 font-bold hover:bg-gray-300 dark:hover:bg-gray-700 transition text-sm">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
                <form method="dialog" class="modal-backdrop"><button>close</button></form>
            </dialog>

            <dialog id="activeAppointmentModal" class="modal">
                <div
                    class="modal-box p-8 rounded-[1.5rem] bg-white dark:bg-[#000D1A] text-center shadow-2xl w-[min(92vw,400px)]">
                    <div
                        class="mx-auto mb-5 w-20 h-20 rounded-full bg-red-50 flex items-center justify-center border-4 border-white shadow-sm">
                        <i class="fa-solid fa-calendar-xmark text-[#8B0000] text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold text-gray-800 dark:text-gray-100 mb-3">One Appointment at a Time
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-8 leading-relaxed">
                        {{ session('activeAppointmentMsg') ?? 'You already have an active appointment. Please wait until it is completed before booking another one.' }}
                    </p>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('patient.appointment.index') }}"
                            class="w-full py-3.5 rounded-xl bg-[#8B0000] text-white font-bold hover:bg-[#660000] transition-colors shadow-md">
                            <i class="fa-regular fa-calendar-check mr-2"></i> View My Appointment
                        </a>
                        <button type="button" id="closeActiveApptModalBtn"
                            class="w-full py-3.5 rounded-xl bg-gray-100 text-gray-700 font-bold hover:bg-gray-200 transition-colors">Close</button>
                    </div>
                </div>
                <form method="dialog" class="modal-backdrop"><button>close</button></form>
            </dialog>

        </div>
    </main>

    @include('components.appointment-calendar-script', [
        'mode' => 'patient-appointment',
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
        /* ── TAB TOGGLE ── */
        function apptShowFuture() {
            document.getElementById('apptFuturePanel').style.display = '';
            document.getElementById('apptPastPanel').style.display = 'none';
            document.getElementById('apptFutureTab').classList.add('appt-active');
            document.getElementById('apptPastTab').classList.remove('appt-active');
        }

        function apptShowPast() {
            document.getElementById('apptFuturePanel').style.display = 'none';
            document.getElementById('apptPastPanel').style.display = '';
            document.getElementById('apptPastTab').classList.add('appt-active');
            document.getElementById('apptFutureTab').classList.remove('appt-active');
        }

        /* ── DETAIL MODAL ── */
        function openApptDetailModal(btn) {
            var modal = document.getElementById('appt_detail_modal');
            if (!modal) return;
            var data = {};
            try {
                data = JSON.parse(btn.getAttribute('data-appt') || '{}');
            } catch (e) {}

            function setText(id, val) {
                var el = document.getElementById(id);
                if (el) el.textContent = (val != null ? String(val) : '').trim() || '—';
            }
            setText('d_service', data.service);
            setText('d_date', data.date);
            setText('d_time', data.time);
            setText('d_duration', data.duration);
            setText('d_remarks', data.remarks);
            setText('d_oral', data.oral);
            setText('d_diagnosis', data.diagnosis);
            setText('d_prescription', data.prescription);

            var statusEl = document.getElementById('d_status');
            if (statusEl) {
                var s = (data.status || 'completed').toLowerCase().trim();
                statusEl.textContent = s || '—';
                statusEl.className = 'inline-flex px-3 py-1 text-xs rounded-full font-bold tracking-wider uppercase';
                if (s === 'completed' || s === 'confirmed') statusEl.classList.add('bg-emerald-100', 'text-emerald-800');
                else if (s === 'upcoming' || s === 'scheduled') statusEl.classList.add('bg-orange-100', 'text-orange-800');
                else if (s === 'cancelled') statusEl.classList.add('bg-gray-100', 'text-gray-600');
                else statusEl.classList.add('bg-gray-100', 'text-gray-700');
            }
            modal.showModal();
        }

        document.addEventListener('DOMContentLoaded', function() {
            /* ── ACTIVE APPOINTMENT MODAL ── */
            @if (session('activeAppointmentModal'))
                var activeModal = document.getElementById("activeAppointmentModal");
                var closeActiveBtn = document.getElementById("closeActiveApptModalBtn");
                if (activeModal) {
                    activeModal.showModal();
                    activeModal.addEventListener('click', function(e) {
                        var box = activeModal.querySelector('.modal-box');
                        if (box && !box.contains(e.target)) e.preventDefault();
                    });
                    activeModal.addEventListener('cancel', function(e) {
                        e.preventDefault();
                    });
                    if (closeActiveBtn) {
                        closeActiveBtn.addEventListener("click", function() {
                            activeModal.close();
                        });
                    }
                }
            @endif
        });
    </script>
@endsection
