@extends('layouts.app')

@section('layout-role', 'patient')

@section('title', 'Book Appointment')

@section('hide-sidebar')
@endsection

@section('hide-mobile-nav')
@endsection

@section('hide-patient-modals')
@endsection

@php
$notifications = collect($notifications ?? []);
$notifCount = $notifications->count();
$isFemalePatient = strtolower($patient->gender ?? '') === 'female';
@endphp

@section('content')
<main id="mainContent" class="book-container page-enter">
    <div class="book-page-wrap">

        <div class="w-full pt-10 pb-2 animate-fade-up">

            <div class="flex items-center justify-between mt-8 mb-4">
                <a href="{{ route('homepage') }}"
                    class="back-home-btn flex items-center gap-2 bg-[#8B0000] hover:bg-[#660000] text-white px-4 py-2 rounded-xl text-xs font-bold border border-[#660000] transition shadow-sm">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Back to Home
                </a>
                <span
                    class="step-counter-pill text-xs text-[#9e9690] font-semibold bg-white border border-[#e8e2dd] px-3 py-1.5 rounded-full shadow-sm">
                    Step <span id="stepCounterText">1</span> <span class="text-[#c4bfba]">of 5</span>
                </span>
            </div>

            <div class="w-full h-2 rounded-full bg-[#e8e2dd] overflow-hidden mb-5">
                <div id="headerProgressFill" class="h-full rounded-full progress-fill progress-fill-initial"></div>
            </div>

            <div class="text-center mb-1">
                <p class="text-xs font-semibold uppercase tracking-widest mb-1 text-[#8B0000]">
                    <i class="fa-regular fa-calendar-check mr-1"></i> PUP TAGUIG DENTAL CLINIC
                </p>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-[#660000]">Book an Appointment</h1>
                <p class="text-sm text-[#9e9690] mt-1">Complete all five steps to schedule your dental visit.</p>
            </div>

        </div>

        <div class="w-full pb-16">

            <div class="w-full mt-4 mb-0 animate-fade-up-1 py-3 px-2 stepper-wrap-overflow">
                <div class="flex items-start justify-between w-full stepper-row-padding">
                    <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                        <div id="sc1"
                            class="step-circle w-10 h-10 rounded-full border-2 border-blue-600 bg-blue-600 flex items-center justify-center text-sm font-bold text-white shadow-[0_0_0_6px_rgba(37,99,235,0.12)] scale-110">
                            1</div>
                        <span id="sl1"
                            class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-blue-600 text-center hidden sm:block mt-4">Date
                            &amp; Time</span>
                    </div>
                    <div id="conn1"
                        class="h-0.5 bg-[#e8e2dd] flex-shrink-0 self-start step-connector step-connector-size"></div>
                    <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                        <div id="sc2"
                            class="step-circle w-10 h-10 rounded-full border-2 border-[#e8e2dd] bg-white flex items-center justify-center text-sm font-bold text-[#9e9690]">
                            2</div>
                        <span id="sl2"
                            class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-[#9e9690] text-center hidden sm:block mt-4">Service</span>
                    </div>
                    <div id="conn2"
                        class="h-0.5 bg-[#e8e2dd] flex-shrink-0 self-start step-connector step-connector-size"></div>
                    <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                        <div id="sc3"
                            class="step-circle w-10 h-10 rounded-full border-2 border-[#e8e2dd] bg-white flex items-center justify-center text-sm font-bold text-[#9e9690]">
                            3</div>
                        <span id="sl3"
                            class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-[#9e9690] text-center hidden sm:block mt-4">Dental
                            History</span>
                    </div>
                    <div id="conn3"
                        class="h-0.5 bg-[#e8e2dd] flex-shrink-0 self-start step-connector step-connector-size"></div>
                    <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                        <div id="sc4"
                            class="step-circle w-10 h-10 rounded-full border-2 border-[#e8e2dd] bg-white flex items-center justify-center text-sm font-bold text-[#9e9690]">
                            4</div>
                        <span id="sl4"
                            class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-[#9e9690] text-center hidden sm:block mt-4">Medical
                            History</span>
                    </div>
                    <div id="conn4"
                        class="h-0.5 bg-[#e8e2dd] flex-shrink-0 self-start step-connector step-connector-size"></div>
                    <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                        <div id="sc5"
                            class="step-circle w-10 h-10 rounded-full border-2 border-[#e8e2dd] bg-white flex items-center justify-center text-sm font-bold text-[#9e9690]">
                            5</div>
                        <span id="sl5"
                            class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-[#9e9690] text-center hidden sm:block mt-4">Confirm</span>
                    </div>
                </div>
            </div>

            <div
                class="book-card mt-6 w-full mx-auto bg-white rounded-2xl shadow-[0_4px_40px_rgba(0,0,0,0.08),0_1px_4px_rgba(0,0,0,0.04)] overflow-hidden animate-fade-up-2">
                <div class="h-1 w-full book-card-topline"></div>
                <div class="p-6 sm:p-8">

                    <form id="appointmentForm" action="{{ route('book.appointment.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="step-content hidden">
                            <div class="booking-step-shell">
                                <div class="booking-step-header">
                                    <p class="booking-step-eyebrow">Step 1 of 5</p>
                                    <h2 class="booking-step-title">Select Date &amp; Time</h2>
                                    <p class="booking-step-subtitle">
                                        Choose your preferred appointment date and available clinic time slot.
                                    </p>
                                </div>

                                <div class="booking-step-body">
                                    <input type="hidden" id="appointment_date" name="appointment_date" required>
                                    <input type="hidden" id="appointment_time" name="appointment_time" required>

                                    <div class="cal-time-layout grid gap-5 lg:gap-6 mx-auto w-full">

                                        <div class="calendar-shell-no-card">
                                            <div id="calendarSkeletonContainer"></div>
                                        </div>

                                        <div class="time-panel flex flex-col is-empty">
                                            <div class="mb-5">
                                                <p
                                                    class="text-[0.78rem] font-extrabold text-[#8B0000] uppercase tracking-[0.24em]">
                                                    Pick a Time Slot
                                                </p>
                                                <p class="text-sm text-[#8c817a] mt-1 leading-6">
                                                    Choose your preferred schedule for the selected date.
                                                </p>
                                            </div>

                                            <div id="dateBanner"
                                                class="hidden rounded-xl px-3 py-2 text-sm font-semibold text-white mb-3 shadow-md date-banner-gradient">
                                            </div>

                                            <div id="slotContainer" class="hidden">
                                                <div id="slotGrid" class="slot-grid-ui grid grid-cols-2 gap-4">
                                                </div>

                                                <button type="button" id="clearSlotSelectionBtn"
                                                    class="hidden mt-4 mb-2 w-full rounded-xl border border-[#e8caca] bg-white px-4 py-2 text-xs font-bold text-[#8B0000] hover:bg-[#fff5f5] transition"
                                                    aria-hidden="true">
                                                    <i class="fa-solid fa-xmark mr-1"></i>
                                                    Clear selection
                                                </button>

                                                <div id="selectedSlotDisplay"
                                                    class="hidden rounded-2xl px-4 py-3 text-sm font-semibold text-[#8B0000] bg-[linear-gradient(135deg,#fff5f5,#fffafa)] border border-[#e8caca] shadow-sm">
                                                    <i class="fa-solid fa-circle-check mr-1.5"></i>
                                                    Selected:
                                                    <span id="selectedSlotText" class="font-bold"></span>
                                                </div>
                                            </div>

                                            <div id="slotPlaceholder"
                                                class="slot-placeholder-empty flex flex-col items-center justify-center gap-3 py-8 text-center text-[#9e9690]">
                                                <div
                                                    class="empty-icon w-12 h-12 rounded-full bg-[#f9e8e8] flex items-center justify-center text-[#8B0000] text-lg">
                                                    <i class="fa-regular fa-calendar"></i>
                                                </div>
                                                <div>
                                                    <p class="empty-title text-sm font-semibold text-[#5c5550]">Choose
                                                        a
                                                        date</p>
                                                    <p class="empty-subtitle text-xs mt-1">Select an available day to
                                                        see time slots.</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="step-content hidden">
                            <div class="booking-step-shell">
                                <div class="booking-step-header">
                                    <p class="booking-step-eyebrow">Step 2 of 5</p>
                                    <h2 class="booking-step-title">Choose Your Dental Service</h2>
                                    <p class="booking-step-subtitle">
                                        Select the type of service you want to book for your appointment.
                                    </p>
                                </div>

                                <div class="booking-step-body">
                                    <div class="service-step-grid">
                                        @foreach ($serviceTypes as $service)
                                        <label class="service-option group">
                                            <input type="radio" name="service_type" value="{{ $service['name'] }}"
                                                class="service-option-input">

                                            <div class="service-option-card">
                                                <div class="service-option-main">
                                                    <div class="service-option-icon">
                                                        @if (!empty($service['img']))
                                                        <img src="{{ asset('images/' . $service['img'] . '.png') }}"
                                                            class="w-6 h-6 service-option-img-red" />
                                                        @else
                                                        <i class="fa-solid fa-tooth"></i>
                                                        @endif
                                                    </div>

                                                    <div class="service-option-copy">
                                                        <div class="service-option-topline">
                                                            <p class="service-option-title">{{ $service['name'] }}
                                                            </p>
                                                            <span class="service-option-badge">Available</span>
                                                        </div>
                                                        <p class="service-option-desc">{{ $service['desc'] }}</p>
                                                    </div>
                                                </div>

                                                <div class="service-option-arrow">
                                                    <i class="fa-solid fa-chevron-right"></i>
                                                </div>
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="step-content hidden">
                            <div>
                                <div class="booking-step-header">
                                    <p class="booking-step-eyebrow">Step 3 of 5</p>
                                    <h2 class="booking-step-title">Dental History</h2>
                                    <p class="booking-step-subtitle">
                                        Share your past dental records, treatments, and dental concerns for a better
                                        assessment.
                                    </p>
                                </div>

                                <div class="booking-step-body">

                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-regular fa-calendar-days text-xs"></i> Basic Info
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5">Last
                                                    Dental
                                                    Visit</label>
                                                <div class="date-input-wrap compact">
                                                    <input type="text" id="lastDentalVisit" name="last_dental_visit"
                                                        class="js-flatpickr-date-max-today form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                                        placeholder="Select date" readonly required>
                                                    <i class="fa-regular fa-calendar date-input-icon"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5">Previous
                                                    Dentist</label>
                                                <input type="text" id="previous_dentist" name="previous_dentist"
                                                    maxlength="50"
                                                    class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                                    placeholder="Dr. Name" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p
                                            class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                            <i class="fa-solid fa-tooth text-xs"></i> Dental Symptoms <span
                                                class="flex-1 h-px bg-[#f9e8e8]"></span>
                                        </p>
                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Question</span><span class="text-center">YES</span><span
                                                class="text-center">NO</span>
                                        </div>
                                        @php
                                        $dentalQ1 = [
                                        [
                                        'name' => 'bleeding_gums',
                                        'q' => 'Do your gums bleed while brushing/flossing?',
                                        ],
                                        [
                                        'name' => 'sensitive_temp',
                                        'q' => 'Are your teeth sensitive to hot or cold?',
                                        ],
                                        [
                                        'name' => 'sensitive_taste',
                                        'q' => 'Are your teeth sensitive to sweets or sour?',
                                        ],
                                        [
                                        'name' => 'tooth_pain',
                                        'q' => 'Do you feel any pain in your teeth?',
                                        ],
                                        [
                                        'name' => 'sores',
                                        'q' => 'Do you have any sores/lumps in or near your mouth?',
                                        ],
                                        [
                                        'name' => 'injuries',
                                        'q' => 'Have you had any head, neck, or jaw injuries?',
                                        ],
                                        ];
                                        @endphp
                                        @foreach ($dentalQ1 as $q)
                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 {{ !$loop->last ? 'border-b border-[#f0ebe6]' : '' }} text-sm text-[#1a1410]">
                                            <span class="leading-snug question-text">{{ $q['q'] }}</span>
                                            <input type="radio" name="{{ $q['name'] }}" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="{{ $q['name'] }}" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="section-card">
                                        <p
                                            class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                            <i class="fa-solid fa-circle-dot text-xs"></i> Jaw &amp; Bite Symptoms
                                            <span class="flex-1 h-px bg-[#f9e8e8]"></span>
                                        </p>
                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Question</span><span class="text-center">YES</span><span
                                                class="text-center">NO</span>
                                        </div>
                                        @php
                                        $dentalQ2 = [
                                        ['name' => 'clicking', 'q' => 'Clicking'],
                                        ['name' => 'joint_pain', 'q' => 'Pain (joint, side of the face)'],
                                        [
                                        'name' => 'difficulty_moving',
                                        'q' => 'Difficulty in opening/closing',
                                        ],
                                        ['name' => 'difficulty_chewing', 'q' => 'Difficulty in chewing'],
                                        ['name' => 'jaw_headaches', 'q' => 'Frequent headaches'],
                                        [
                                        'name' => 'clench_grind',
                                        'q' => 'Do you clench or grind your teeth?',
                                        ],
                                        ['name' => 'biting', 'q' => 'Frequent lips/cheek biting'],
                                        [
                                        'name' => 'teeth_loosening',
                                        'q' => 'Have you noticed loosening of your teeth?',
                                        ],
                                        [
                                        'name' => 'food_teeth',
                                        'q' => 'Does food get caught between your teeth?',
                                        ],
                                        [
                                        'name' => 'med_reaction',
                                        'q' =>
                                        'Have you ever had a reaction to any medicine or dental anesthetic?',
                                        ],
                                        ];
                                        @endphp
                                        @foreach ($dentalQ2 as $q)
                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 {{ !$loop->last ? 'border-b border-[#f0ebe6]' : '' }} text-sm text-[#1a1410]">
                                            <span class="leading-snug question-text">{{ $q['q'] }}</span>
                                            <input type="radio" name="{{ $q['name'] }}" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="{{ $q['name'] }}" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        @endforeach
                                        <p class="text-xs text-[#8B0000] mt-2 italic pl-4">
                                            <i class="fa-solid fa-circle-info mr-1"></i> If <b>YES</b>, please
                                            provide
                                            details
                                            during your
                                            consultation.
                                        </p>
                                    </div>

                                    <div class="section-card">
                                        <p
                                            class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                            <i class="fa-solid fa-notes-medical text-xs"></i> Dental Procedures
                                            <span class="flex-1 h-px bg-[#f9e8e8]"></span>
                                        </p>
                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Question</span><span class="text-center">YES</span><span
                                                class="text-center">NO</span>
                                        </div>

                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                            <span class="question-text">Have you had any periodontal (gum)
                                                treatment?</span>
                                            <input type="radio" name="periodontal" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="periodontal" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>

                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                            <span class="question-text">Have you had a difficult tooth
                                                extraction?</span>
                                            <input type="radio" name="difficult_extraction" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="difficult_extraction" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="ml-6 mt-2 mb-2 hidden" id="extraction_date_box">
                                            <label class="text-xs text-[#8B0000] italic block mb-1">Date of
                                                extraction:</label>
                                            <div class="date-input-wrap compact">
                                                <input type="text" id="extractionDate" name="extraction_date"
                                                    class="js-flatpickr-date-max-today w-full form-input voice-small border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full"
                                                    placeholder="Select date" readonly>
                                                <i class="fa-regular fa-calendar date-input-icon"></i>
                                            </div>
                                        </div>

                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                            <span class="question-text">Have you had prolonged bleeding following
                                                tooth
                                                extractions?</span>
                                            <input type="radio" name="prolonged_bleeding" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="prolonged_bleeding" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>

                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                            <span class="question-text">Do you wear complete or partial
                                                dentures?</span>
                                            <input type="radio" name="dentures" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="dentures" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="ml-6 mt-2 mb-2 hidden" id="dentures_date_box">
                                            <label class="text-xs text-[#8B0000] italic block mb-1">Date of
                                                placement:</label>
                                            <div class="date-input-wrap compact">
                                                <input type="text" id="denturesDate" name="dentures_date"
                                                    class="js-flatpickr-date-max-today w-full form-input voice-small border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full"
                                                    placeholder="Select date" readonly>
                                                <i class="fa-regular fa-calendar date-input-icon"></i>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 text-sm">
                                            <span class="question-text">Have you had orthodontic treatment?</span>
                                            <input type="radio" name="ortho_treatment" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="ortho_treatment" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="ml-6 mt-2 mb-2 hidden" id="ortho_date_box">
                                            <label class="text-xs text-[#8B0000] italic block mb-1">Date of
                                                completion:</label>
                                            <div class="date-input-wrap compact">
                                                <input type="text" id="orthoDate" name="ortho_date"
                                                    class="js-flatpickr-date-max-today w-full form-input voice-small border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full"
                                                    placeholder="Select date" readonly>
                                                <i class="fa-regular fa-calendar date-input-icon"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p
                                            class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                            <i class="fa-regular fa-comment-dots text-xs"></i> Additional Concerns
                                            <span class="flex-1 h-px bg-[#f9e8e8]"></span>
                                        </p>
                                        <textarea name="additional_concerns" id="additional_concerns" rows="4"
                                            maxlength="150"
                                            class="form-input voice-full w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none resize-none"
                                            placeholder="Write any additional concerns here..."></textarea>
                                        <div class="flex justify-between items-center text-xs mt-1">
                                            <span id="concernWarning" class="text-red-500 hidden">
                                                Character limit reached
                                            </span>
                                            <span id="concernCount" class="text-[#9e9690]">0/150</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="step-content hidden">
                            <div class="booking-step-shell">
                                <div class="booking-step-header">
                                    <p class="booking-step-eyebrow">Step 4 of 5</p>
                                    <h2 class="booking-step-title">Medical History</h2>
                                    <p class="booking-step-subtitle">
                                        Provide important medical information so the clinic can prepare safe and
                                        proper
                                        dental care for you.
                                    </p>
                                </div>

                                <div class="booking-step-body">

                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-heart-pulse text-xs"></i> General Health
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Question</span><span class="text-center">YES</span><span
                                                class="text-center">NO</span>
                                        </div>

                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                            <span class="question-text">Are you in good health?</span>
                                            <input type="radio" name="good_health" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="good_health" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="ml-6 mt-1 mb-2 hidden" id="good_health_box">
                                            <label class="text-xs text-[#8B0000] italic">If NO, please provide
                                                details:</label>
                                            <input type="text" name="good_health_details" maxlength="150"
                                                id="good_health_details"
                                                class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                                placeholder="Input here">
                                            <div class="text-right text-xs"><span id="goodHealthCount">0/150</span>
                                            </div>
                                        </div>

                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                            <span class="question-text">When was your last medical
                                                examination?</span>
                                            <input type="radio" name="had_medical_exam" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="had_medical_exam" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="ml-6 mt-1 mb-2 hidden" id="medical_exam_box">
                                            <label class="text-xs text-[#8B0000] italic block mb-1">If YES, when was
                                                your
                                                last medical examination?</label>
                                            <div class="date-input-wrap compact">
                                                <input type="text" id="medicalExamDate" name="medical_exam_date"
                                                    class="js-flatpickr-date-max-today w-full form-input voice-small border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full"
                                                    placeholder="Select date" readonly>
                                                <i class="fa-regular fa-calendar date-input-icon"></i>
                                            </div>
                                        </div>

                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                            <span class="question-text">Are you currently receiving treatment for
                                                any
                                                illness?</span>
                                            <input type="radio" name="under_treatment" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="under_treatment" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="ml-6 mt-1 mb-2 hidden" id="treatment_box">
                                            <label class="text-xs text-[#8B0000] italic">If YES, please
                                                specify:</label>
                                            <input type="text" name="treatment_details" maxlength="150"
                                                id="treatment_details"
                                                class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                                placeholder="Input here">
                                            <div class="text-right text-xs"><span id="treatmentCount">0/150</span>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 text-sm">
                                            <span class="question-text">Have you ever been hospitalized?</span>
                                            <input type="radio" name="hospitalized" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="hospitalized" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="ml-6 mt-1 mb-2 hidden" id="hospital_box">
                                            <label class="text-xs text-[#8B0000] italic">If YES, please provide
                                                details:</label>
                                            <input type="text" name="hospital_details" maxlength="150"
                                                id="hospital_details"
                                                class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                                placeholder="Input here">
                                            <div class="text-right text-xs"><span id="hospitalCount">0/150</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-triangle-exclamation text-xs"></i> Allergies
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Are you allergic to any of the following?</span><span
                                                class="text-center">YES</span><span class="text-center">NO</span>
                                        </div>
                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 border-b border-[#f0ebe6] text-sm">
                                            <span class="question-text">Medicines</span>
                                            <input type="radio" name="allergy_medicine" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="allergy_medicine" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 text-sm">
                                            <span class="question-text">Food</span>
                                            <input type="radio" name="allergy_food" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="allergy_food" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="mt-3">
                                            <label class="text-xs text-[#8B0000] italic block mb-1">Others (please
                                                specify):</label>
                                            <input type="text" name="allergy_others"
                                                class="form-input voice-medium border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full"
                                                placeholder="Input here">
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-pills text-xs"></i> Medications
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Question</span><span class="text-center">YES</span><span
                                                class="text-center">NO</span>
                                        </div>
                                        <div class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 text-sm">
                                            <span class="question-text">Are you taking any prescription or
                                                non-prescription
                                                medication?</span>
                                            <input type="radio" name="medication" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="medication" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="ml-6 mt-1 mb-2 hidden" id="medication_box">
                                            <label class="text-xs text-[#8B0000] italic">If YES, please
                                                specify:</label>
                                            <input type="text" name="medication_details" maxlength="150"
                                                id="medication_details"
                                                class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                                placeholder="Input here">
                                            <div class="text-right text-xs"><span id="medicationCount">0/150</span>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($isFemalePatient)
                                    <div class="section-card" id="forWomenSection">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-venus text-xs"></i> For Women Only
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Question</span><span class="text-center">YES</span><span
                                                class="text-center">NO</span>
                                        </div>

                                        @foreach ([
                                        ['name' => 'pregnant', 'q' => 'Are you pregnant?'],
                                        ['name' => 'nursing', 'q' => 'Are you nursing?'],
                                        [
                                        'name' => 'birth_control',
                                        'q' => 'Are you taking birth
                                        control pills?',
                                        ],
                                        ] as $i => $q)
                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 {{ $i < 2 ? 'border-b border-[#f0ebe6]' : '' }} text-sm">
                                            <span class="question-text">{{ $q['q'] }}</span>
                                            <input type="radio" name="{{ $q['name'] }}" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="{{ $q['name'] }}" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <input type="hidden" name="pregnant" value="NO">
                                    <input type="hidden" name="nursing" value="NO">
                                    <input type="hidden" name="birth_control" value="NO">
                                    @endif

                                    <div class="section-card mt-5">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-stethoscope text-xs"></i> Medical Conditions
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <p class="text-xs text-[#5c5550] mb-3">Please indicate below if you
                                            presently
                                            have
                                            or have ever had any of the following:</p>
                                        <div
                                            class="medical-condition-grid grid grid-cols-1 sm:grid-cols-2 gap-y-2.5 gap-x-6">
                                            @foreach ($diseases as $d)
                                            <label class="flex items-center gap-2.5 cursor-pointer">
                                                <input type="checkbox" name="diseases[]" value="{{ $d->code }}"
                                                    class="w-4 h-4 rounded border-2 border-[#e8e2dd] cursor-pointer accent-[#8B0000] flex-shrink-0">
                                                <span class="text-[0.82rem] text-[#1a1410]">{{ $d->label }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-smoking text-xs"></i> Tobacco Use
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Question</span><span class="text-center">YES</span><span
                                                class="text-center">NO</span>
                                        </div>
                                        <div class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 text-sm">
                                            <span class="question-text">Do you use tobacco products or any
                                                derivatives?</span>
                                            <input type="radio" name="tobacco_use" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="tobacco_use" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div id="tobacco_details" class="ml-6 mt-2 space-y-2 hidden text-sm">
                                            <div class="flex items-center gap-3 flex-wrap">
                                                <span class="text-xs text-[#8B0000] italic w-28">How much per
                                                    day:</span>
                                                <input type="text" name="tobacco_per_day" placeholder="Input here"
                                                    class="form-input voice-small border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full">
                                            </div>
                                            <div class="flex items-center gap-3 flex-wrap">
                                                <span class="text-xs text-[#8B0000] italic w-28">Per week:</span>
                                                <input type="text" name="tobacco_per_week" placeholder="Input here"
                                                    class="form-input voice-small border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-head-side-mask text-xs"></i> Do You Suffer From
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Condition</span><span class="text-center">YES</span><span
                                                class="text-center">NO</span>
                                        </div>
                                        @foreach ([['name' => 'headaches', 'q' => 'Headaches'], ['name' => 'earaches',
                                        'q' => 'Earaches'], ['name' => 'neck_aches', 'q' => 'Neck aches']] as $i => $q)
                                        <div
                                            class="grid grid-cols-[1fr_52px_52px] items-center gap-2 py-2.5 {{ $i < 2 ? 'border-b border-[#f0ebe6]' : '' }} text-sm">
                                            <span class="question-text">{{ $q['q'] }}</span>
                                            <input type="radio" name="{{ $q['name'] }}" value="YES"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer"
                                                required>
                                            <input type="radio" name="{{ $q['name'] }}" value="NO"
                                                class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-phone-volume text-xs"></i> Emergency Contact
                                            <span class="section-card-title-line"></span>
                                        </p>

                                        <div class="emergency-fields-stack">
                                            <div>
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5">
                                                    Person to contact in case of emergency
                                                </label>
                                                <input type="text" id="emergency_person" name="emergency_person"
                                                    maxlength="50" pattern="[A-Za-zÑñ\s.'-]+"
                                                    title="Only letters, spaces, apostrophe, period, and hyphen are allowed."
                                                    class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                                    placeholder="Full name" required>

                                                <p id="emergency_person_feedback"
                                                    class="field-help-text text-[#9e9690]">
                                                    Only letters, spaces, apostrophe, period, and hyphen are allowed.
                                                </p>
                                            </div>

                                            <div>
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5">
                                                    Contact Number
                                                </label>
                                                <input type="tel" id="emergency_number" name="emergency_number"
                                                    inputmode="numeric" autocomplete="tel" maxlength="13"
                                                    class="form-input border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full"
                                                    placeholder="09xx xxx xxxx" required>
                                                <p id="emergency_number_feedback"
                                                    class="field-help-text text-[#9e9690]">
                                                    Format: 09xx xxx xxxx
                                                </p>
                                            </div>

                                            <div>
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5">
                                                    Relation to Patient <span class="required-star">*</span>
                                                </label>
                                                <div class="relative w-full">
                                                    <select name="emergency_relation" id="emergency_relation"
                                                        class="form-input js-custom-select" required>
                                                        <option value="" disabled selected>Select relation
                                                        </option>
                                                        <option value="Mother">Mother</option>
                                                        <option value="Father">Father</option>
                                                        <option value="Sibling">Sibling</option>
                                                        <option value="Guardian">Guardian</option>
                                                        <option value="Spouse">Spouse</option>
                                                        <option value="Grandparent">Grandparent</option>
                                                        <option value="Aunt">Aunt</option>
                                                        <option value="Uncle">Uncle</option>
                                                        <option value="Cousin">Cousin</option>
                                                        <option value="Child">Child</option>
                                                    </select>
                                                    <div
                                                        class="pointer-events-none absolute inset-y-0 right-2.5 flex items-center">
                                                        <i
                                                            class="fa-solid fa-chevron-down text-[10px] text-[#5c5550]"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="signature-section-card">
                                        <label class="block text-xs font-semibold text-[#333] mb-1.5">
                                            Patient's Signature <span class="required-star">*</span>
                                        </label>

                                        <div class="signature-methods-grid">
                                            <div
                                                class="file-upload-zone border-2 border-dashed border-[#e8e2dd] rounded-xl p-5 flex flex-col items-center justify-center text-center cursor-pointer">
                                                <i class="fa-regular fa-image text-gray-400 text-3xl mb-2"></i>

                                                <p class="text-xs text-[#5c5550] mb-1">
                                                    Select your file or drag and drop
                                                </p>
                                                <p class="text-xs text-[#9e9690] mb-3">
                                                    JPG, PNG, up to 25 MB
                                                </p>

                                                <label
                                                    class="btn-primary-custom inline-flex items-center gap-1.5 bg-[#8B0000] text-white rounded-xl px-4 py-1.5 text-xs font-bold cursor-pointer">
                                                    <i class="fa-solid fa-upload"></i> Browse
                                                    <input type="file" name="patient_signature" id="patient_signature"
                                                        class="hidden" accept=".jpg,.jpeg,.png" required>
                                                    <input type="hidden" name="signature_source" id="signature_source"
                                                        value="">
                                                </label>
                                            </div>

                                            <div class="signature-draw-card">
                                                <p class="signature-draw-title">Or draw your signature here</p>

                                                <div class="signature-pad-wrap">
                                                    <canvas id="signatureCanvas" class="signature-pad-canvas"></canvas>
                                                </div>

                                                <div class="signature-pad-footer">
                                                    <span class="signature-pad-help">Use mouse, touch, or
                                                        stylus.</span>

                                                    <div class="signature-pad-actions">
                                                        <button type="button" id="signatureUndoBtn"
                                                            class="signature-pad-btn">
                                                            Undo
                                                        </button>

                                                        <button type="button" id="signatureClearBtn"
                                                            class="signature-pad-btn">
                                                            Clear Signature
                                                        </button>

                                                        <button type="button" id="signatureUseDrawnBtn"
                                                            class="signature-pad-btn primary">
                                                            Use Drawn Signature
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="signature_result_box" class="mt-3 hidden text-left w-full max-w-full">
                                            <p id="signature_filename"
                                                class="text-xs text-[#5c5550] font-semibold truncate"></p>

                                            <div id="signature_error"
                                                class="mt-1 hidden rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-700 leading-5 font-semibold">
                                            </div>
                                        </div>

                                        @error('patient_signature')
                                        <p class="text-xs text-red-600 mt-3 font-semibold">
                                            <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="step-content hidden" id="step5">
                            <div>
                                <div id="summarySection">
                                    <div class="booking-step-header">
                                        <p class="booking-step-eyebrow">Step 5 of 5</p>
                                        <h2 class="booking-step-title">Review Your Information</h2>
                                        <p class="booking-step-subtitle">
                                            Please review all the information you provided before proceeding to
                                            final
                                            confirmation.
                                        </p>
                                    </div>

                                    <div id="summaryBox" class="space-y-4"></div>

                                    <div class="flex justify-center gap-3 mt-8 nav-btns-row">
                                        <button type="button" id="summaryBackBtn"
                                            class="btn-secondary-custom inline-flex items-center gap-2 border border-[#e8e2dd] rounded-xl px-6 py-2.5 text-sm font-semibold text-[#5c5550] bg-transparent">
                                            <i class="fa-solid fa-chevron-left text-xs"></i> Back
                                        </button>
                                        <button type="button" id="goToConfirmationBtn"
                                            class="btn-primary-custom inline-flex items-center gap-2 bg-[#8B0000] text-white rounded-xl px-6 py-2.5 text-sm font-bold">
                                            Proceed to Confirm <i class="fa-solid fa-chevron-right text-xs"></i>
                                        </button>
                                    </div>
                                </div>

                                <div id="confirmationSection" class="hidden">
                                    <div class="booking-step-header">
                                        <p class="booking-step-eyebrow">Step 5 of 5</p>
                                        <h2 class="booking-step-title">Final Confirmation</h2>
                                        <p class="booking-step-subtitle">
                                            Confirm that the information is accurate and that you accept the clinic
                                            terms
                                            and privacy policy.
                                        </p>
                                    </div>

                                    <div class="section-card mb-2">
                                        <div class="flex items-start gap-2 mb-4">
                                            <i class="fa-solid fa-shield-halved text-[#8B0000] mt-0.5"></i>
                                            <p class="text-sm text-[#5c5550]">
                                                By submitting, you confirm that all the information provided is
                                                accurate
                                                and
                                                complete.
                                            </p>
                                        </div>
                                        <label
                                            class="confirm-checkbox-wrap flex items-start gap-3 p-4 rounded-xl border border-[#e8e2dd] bg-[#fafaf8] cursor-pointer">
                                            <input id="finalConfirm" type="checkbox"
                                                class="w-5 h-5 rounded border-2 border-[#e8e2dd] bg-white cursor-pointer flex-shrink-0 mt-0.5 accent-[#8B0000]"
                                                required>
                                            <span class="text-sm text-[#1a1410] leading-relaxed">
                                                I have reviewed my dental and medical information and agree to the
                                                <a href="https://www.pup.edu.ph/privacy/" target="_blank"
                                                    rel="noopener noreferrer" data-legal-link
                                                    class="booking-legal-link">
                                                    Privacy Policy
                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                </a>
                                                and
                                                <a href="https://www.pup.edu.ph/terms/" target="_blank"
                                                    rel="noopener noreferrer" data-legal-link
                                                    class="booking-legal-link">
                                                    Terms and Conditions
                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                </a>.
                                            </span>
                                        </label>
                                    </div>

                                    <div class="flex justify-center gap-3 mt-8 nav-btns-row">
                                        <button type="button" id="confirmBackBtn"
                                            class="btn-secondary-custom inline-flex items-center gap-2 border border-[#e8e2dd] rounded-xl px-6 py-2.5 text-sm font-semibold text-[#5c5550] bg-transparent">
                                            <i class="fa-solid fa-chevron-left text-xs"></i> Back
                                        </button>
                                        <button type="button" id="finalSubmitBtn"
                                            class="btn-primary-custom inline-flex items-center gap-2 bg-[#8B0000] text-white rounded-xl px-6 py-2.5 text-sm font-bold">
                                            <i class="fa-solid fa-check"></i> Submit Appointment
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="navBtns" class="flex justify-end mt-8 gap-3 nav-btns-row">
                            <button type="button" id="prevBtn"
                                class="btn-secondary-custom inline-flex items-center gap-2 border border-[#e8e2dd] rounded-2xl px-6 py-3 text-sm font-semibold text-[#5c5550] bg-white shadow-sm">
                                <i class="fa-solid fa-chevron-left text-xs"></i> Previous
                            </button>

                            <button type="button" id="nextBtn"
                                class="btn-primary-custom inline-flex items-center gap-2 bg-[#8B0000] text-white rounded-2xl px-8 py-3 text-sm font-bold shadow-[0_10px_24px_rgba(139,0,0,0.18)]">
                                Next <i class="fa-solid fa-chevron-right text-xs"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <dialog id="introBookingModal" class="m-auto w-[calc(100vw-1.5rem)] max-w-[620px]">
            <div class="intro-booking-modal-panel">
                <div class="intro-booking-modal-hero">
                    <p class="intro-booking-modal-eyebrow">PUP Taguig Dental Clinic</p>
                    <h2 class="intro-booking-modal-title">Let’s get your dental appointment ready.</h2>
                    <p class="intro-booking-modal-subtitle">
                        This form will help the clinic prepare safe and proper care for your visit.
                    </p>
                </div>

                <div class="intro-booking-modal-body">
                    <div class="intro-step-strip">
                        <div class="intro-step-pill">1<span>Date</span></div>
                        <div class="intro-step-pill">2<span>Service</span></div>
                        <div class="intro-step-pill">3<span>Dental</span></div>
                        <div class="intro-step-pill">4<span>Medical</span></div>
                        <div class="intro-step-pill">5<span>Confirm</span></div>
                    </div>

                    <div class="intro-checklist">
                        <div class="intro-check-item">
                            <div class="intro-check-icon"><i class="fa-solid fa-check"></i></div>
                            <p>Fill out all required fields marked with <b>*</b>.</p>
                        </div>
                        <div class="intro-check-item">
                            <div class="intro-check-icon"><i class="fa-solid fa-phone-volume"></i></div>
                            <p>Prepare your emergency contact information.</p>
                        </div>
                        <div class="intro-check-item">
                            <div class="intro-check-icon"><i class="fa-solid fa-signature"></i></div>
                            <p>Prepare your patient signature image or draw it directly in the form.</p>
                        </div>
                        <div class="intro-check-item">
                            <div class="intro-check-icon"><i class="fa-solid fa-list-check"></i></div>
                            <p>Review your information before submitting.</p>
                        </div>
                    </div>

                    <div class="intro-modal-actions">
                        <button type="button" id="introStartBtn" class="intro-action-btn intro-action-primary">
                            <i class="fa-solid fa-play"></i>
                            <span>Start Booking</span>
                        </button>

                        <button type="button" id="introContinueDraftBtn"
                            class="hidden intro-action-btn intro-action-secondary">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            <span>Continue Draft</span>
                        </button>

                        <a href="{{ route('homepage') }}" class="intro-action-btn intro-action-muted">
                            <i class="fa-solid fa-house"></i>
                            <span>Back Home</span>
                        </a>
                    </div>
                </div>
            </div>
        </dialog>

        <dialog id="confirmModal"
            class="border-0 p-0 rounded-2xl overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.25)] max-w-[480px] w-[calc(100vw-2rem)]">
            <div class="bg-[#8B0000] px-8 py-10 text-center">
                <div
                    class="confirm-modal-icon w-16 h-16 rounded-full bg-white/15 flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-calendar-check text-white text-2xl"></i>
                </div>

                <h2 class="confirm-modal-title text-2xl font-extrabold text-white mb-4">
                    Appointment Confirmed!
                </h2>

                <p id="confirmMessage" class="confirm-modal-message text-white/85 text-sm leading-7 mb-6"></p>

                <button type="button" id="okBtn"
                    class="confirm-modal-button bg-white text-[#8B0000] border-0 px-8 py-2.5 rounded-xl font-bold text-sm cursor-pointer transition hover:scale-[1.03] hover:shadow-lg active:scale-[0.98]">
                    Back to Home
                </button>
            </div>
        </dialog>

        <dialog id="leaveModal"
            class="m-auto border-0 p-0 rounded-2xl overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.25)] max-w-[440px] w-[calc(100vw-2rem)]">
            <div class="bg-[#8B0000] px-6 py-5">
                <h3 class="text-lg font-bold text-white mb-0.5">Leave this page?</h3>
                <p class="text-sm text-white/80">Your appointment form has unsaved changes. You can save your draft,
                    discard it, or continue editing.</p>
            </div>
            <div class="bg-white px-6 py-5 flex justify-end gap-3 flex-wrap">
                <button type="button" id="cancelLeaveBtn"
                    class="btn-secondary-custom inline-flex items-center gap-2 border border-[#e8e2dd] rounded-xl px-4 py-2 text-sm font-semibold text-[#5c5550] bg-transparent">
                    Cancel
                </button>
                <button type="button" id="discardDraftBtn"
                    class="btn-secondary-custom inline-flex items-center gap-2 border border-red-200 text-red-600 bg-red-50 hover:bg-red-100 rounded-xl px-4 py-2 text-sm font-semibold transition-colors">
                    Discard
                </button>
                <button type="button" id="saveDraftBtn"
                    class="btn-primary-custom inline-flex items-center gap-2 bg-[#8B0000] text-white rounded-xl px-5 py-2 text-sm font-bold">
                    Save Draft
                </button>
            </div>
        </dialog>
</main>

<div id="miniTab" class="mini-tab">
    <i class="fa-solid fa-circle-exclamation text-red-400" aria-hidden="true"></i>
    <span id="miniTabText">Please complete all required fields.</span>
</div>

@include('components.appointment-calendar-script', [
'mode' => 'booking',
'renderStyle' => 'patient',
'calendarContainerId' => 'calendarSkeletonContainer',
'dateInputId' => 'appointment_date',
'timeInputId' => 'appointment_time',
'dateBannerId' => 'dateBanner',
'slotPlaceholderId' => 'slotPlaceholder',
'slotContainerId' => 'slotContainer',
'slotGridId' => 'slotGrid',
'selectedSlotDisplayId' => 'selectedSlotDisplay',
'selectedSlotTextId' => 'selectedSlotText',
'slotEndpoint' => route('book.appointment.slots'),
'scheduleRules' => $schedules ?? [],
'blockedDates' => $blockedDates ?? [],
'appointmentCountsPerDay' => $appointmentCountsPerDay ?? [],
'philippineHolidays' => $philippineHolidays ?? [],
'useDynamicScheduleRules' => true,
'disallowToday' => true,
'allowToggleOffDate' => true,
])

@endsection

@section('scripts')

<script>
    const diseaseLabelByCode = @json($diseases -> pluck('label', 'code'));
    const isFemalePatient = @json($isFemalePatient);
    const DRAFT_KEY = "appointmentDraft:v1";

    const appointmentCountsPerDay = @json($appointmentCountsPerDay ?? []);
    const MAX_SLOTS_PER_DAY = 5;

    function hasSavedDraft() {
        const raw = localStorage.getItem(DRAFT_KEY);
        if (!raw) return false;

        try {
            const parsed = JSON.parse(raw);
            const values = Object.entries(parsed).filter(([key, value]) => {
                if (key === "__meta") return false;
                if (value === null || value === undefined) return false;
                return String(value).trim() !== "";
            });

            return values.length >= 2;
        } catch {
            return false;
        }
    }

    function saveDraftData() {
        const form = document.getElementById("appointmentForm");
        if (!form) return;
        const data = new FormData(form),
            obj = {};
        for (const [key, value] of data.entries()) {
            if (key === "patient_signature") continue;
            if (obj[key] === undefined) obj[key] = value;
            else if (Array.isArray(obj[key])) obj[key].push(value);
            else obj[key] = [obj[key], value];
        }

        const draftFields = Object.keys(obj).filter(key => key !== "__meta");

        if (!draftFields.length) {
            clearDraft();
            return;
        }

        obj.__meta = {
            step: typeof step !== "undefined" ? step : 0,
            savedAt: new Date().toISOString(),
            fieldCount: draftFields.length
        };
        localStorage.setItem(DRAFT_KEY, JSON.stringify(obj));
    }

    function clearDraft() {
        localStorage.removeItem(DRAFT_KEY);
    }

    document.getElementById("appointment_date")?.addEventListener("change", markFormDirty);
    document.getElementById("appointment_time")?.addEventListener("change", markFormDirty);

    document.querySelectorAll('input[name="service_type"]').forEach(radio => {
        radio.addEventListener("change", markFormDirty);
    });

    async function restoreDraft() {
        const raw = localStorage.getItem(DRAFT_KEY);
        if (!raw) return;
        let obj;
        try {
            obj = JSON.parse(raw);
        } catch {
            return;
        }
        const form = document.getElementById("appointmentForm");
        if (!form) return;
        Object.keys(obj).forEach((name) => {
            if (name === "__meta") return;
            const value = obj[name];
            if (Array.isArray(value)) {
                form.querySelectorAll(`[name="${CSS.escape(name)}"]`).forEach((el) => {
                    if (el.type === "checkbox") el.checked = value.includes(el.value);
                });
                return;
            }
            form.querySelectorAll(`[name="${CSS.escape(name)}"]`).forEach((el) => {
                if (el.type === "radio") el.checked = (el.value === value);
                else if (el.type === "checkbox") el.checked = (value === true || value === "on" ||
                    value === el.value);
                else el.value = value;
            });
        });
        if (document.getElementById("emergency_relation")?.value === "Others") {
            const other = document.getElementById("relation_other");
            if (other) {
                other.classList.remove("hidden");
                other.setAttribute("required", "true");
            }
        }
        const restoredDate = document.getElementById("appointment_date")?.value;
        const restoredTime = document.getElementById("appointment_time")?.value;
        if (restoredDate) {
            const appointmentCount = appointmentCountsPerDay[restoredDate] || 0;
            if (appointmentCount >= MAX_SLOTS_PER_DAY) {
                showSlotFullWarning(restoredDate);
            } else {
                await selectDate(restoredDate);
                if (restoredTime) {
                    const restoredTimeChip = Array.from(document.querySelectorAll(".slot-chip")).find(c =>
                        c.dataset.time === restoredTime && !c.classList.contains("disabled")
                    );

                    if (restoredTimeChip) {
                        restoredTimeChip.click();
                    } else {
                        const timeInput = document.getElementById("appointment_time");
                        if (timeInput) timeInput.value = "";
                    }
                }
            }
        }
        formIsDirty = true;
    }

    const miniTab = document.getElementById("miniTab");
    const miniTabText = document.getElementById("miniTabText");

    function showMiniTab(msg) {
        if (!miniTab) return;
        miniTabText.textContent = msg || "Please complete all required fields.";
        miniTab.style.opacity = "1";
        miniTab.style.pointerEvents = "auto";
        miniTab.classList.add("show");

        clearTimeout(window.__mtTimer);
        window.__mtTimer = setTimeout(() => {
            miniTab.style.opacity = "0";
            miniTab.style.pointerEvents = "none";
            miniTab.classList.remove("show");
        }, 3200);
    }

    function showInputError(input) {
        if (!input) return;
        input.classList.add("border-red-500");
        input.style.animation = "shake 0.3s ease";
        setTimeout(() => input.style.animation = "", 400);
    }

    let step = 0,
        completedSteps = [];
    const steps = document.querySelectorAll(".step-content");
    const navBtns = document.getElementById("navBtns");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const summarySection = document.getElementById("summarySection");
    const confirmationSection = document.getElementById("confirmationSection");

    function updateStepperUI(i) {
        for (let idx = 0; idx < 5; idx++) {
            const circle = document.getElementById(`sc${idx + 1}`);
            const label = document.getElementById(`sl${idx + 1}`);
            const conn = document.getElementById(`conn${idx + 1}`);
            if (!circle || !label) continue;
            circle.className =
                "step-circle w-10 h-10 rounded-full border-2 flex items-center justify-center text-sm font-bold";
            label.className =
                "step-label text-[0.65rem] font-semibold uppercase tracking-wide text-center block w-full mt-4";
            if (idx < i && completedSteps.includes(idx)) {
                circle.className += " border-green-700 bg-green-700 text-white";
                label.className += " text-green-700";
                circle.innerHTML = `<i class="fa-solid fa-check text-xs"></i>`;
            } else if (idx === i) {
                circle.className +=
                    " border-blue-600 bg-blue-600 text-white shadow-[0_0_0_6px_rgba(37,99,235,0.12)] scale-110";
                label.className += " text-blue-600";
                circle.innerHTML = String(idx + 1);
            } else {
                circle.className += " border-[#e8e2dd] bg-white text-[#9e9690]";
                label.className += " text-[#9e9690]";
                circle.innerHTML = String(idx + 1);
            }
            if (conn) {
                conn.className = "h-0.5 flex-shrink-0 self-start step-connector ";
                conn.style.width = window.innerWidth < 640 ? "8px" : "40px";
                conn.style.marginTop = "20px";
                conn.className += (idx < i && completedSteps.includes(idx)) ? "bg-green-700" : (idx === i ?
                    "bg-blue-600" : "bg-[#e8e2dd]");
            }
        }
        const fill = document.getElementById("headerProgressFill");
        if (fill) fill.style.width = (((i + 1) / 5) * 100) + "%";
        const counter = document.getElementById("stepCounterText");
        if (counter) counter.textContent = i + 1;
    }

    function showStep(i) {
        steps.forEach((s, idx) => {
            s.classList.remove("show");
            s.classList.add("hidden");
            if (idx === i) {
                s.classList.remove("hidden");
                setTimeout(() => s.classList.add("show"), 40);
            }
        });
        const isLast = i === steps.length - 1;
        navBtns.style.display = isLast ? "none" : "flex";
        prevBtn.style.display = i === 0 ? "none" : "inline-flex";
        nextBtn.style.display = isLast ? "none" : "inline-flex";
        if (isLast) {
            buildSummary();
            resetStep5View();
        }
        updateStepperUI(i);
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
        if (i === 3 && typeof resizeSignatureCanvas === "function") {
            setTimeout(resizeSignatureCanvas, 120);
        }
        step = i;
    }

    function resetStep5View() {
        summarySection?.classList.remove("hidden");
        confirmationSection?.classList.add("hidden");
    }

    function scrollToInvalidTarget(target) {
        if (!target) return;

        const block =
            target.closest('.grid') ||
            target.closest('.ml-6') ||
            target.closest('.section-card') ||
            target.closest('.voice-input-wrap') ||
            target.closest('.date-input-wrap') ||
            target;

        block.scrollIntoView({
            behavior: "smooth",
            block: "center"
        });

        if (typeof target.focus === "function" && !target.hasAttribute("readonly")) {
            setTimeout(() => target.focus(), 250);
        }
    }

    function isStepComplete(s) {


        const stepEl = steps[s];
        if (!stepEl) return true;

        if (s === 0) {
            const dateInput = document.getElementById("appointment_date");
            const timeInput = document.getElementById("appointment_time");
            const slotArea = document.getElementById("slotContainer") || document.getElementById("slotPlaceholder");

            if (!dateInput?.value) {
                showMiniTab("Please select a date first.");
                scrollToInvalidTarget(document.getElementById("calendarSkeletonContainer"));
                return false;
            }

            if (!timeInput?.value) {
                showMiniTab("Please select a time slot.");
                scrollToInvalidTarget(slotArea);
                return false;
            }
        }

        if (s === 1) {
            const selectedService = stepEl.querySelector('input[name="service_type"]:checked');
            if (!selectedService) {
                showMiniTab("Please select a service type.");
                scrollToInvalidTarget(stepEl.querySelector(".service-step-grid"));
                return false;
            }
        }

        const fields = stepEl.querySelectorAll(
            "input[required]:not([type='radio']):not([type='checkbox']):not([type='hidden']):not([type='file']), select[required], textarea[required]"
        );

        for (const input of fields) {
            if (!input.value || !input.value.trim()) {
                scrollToInvalidTarget(input);
                return false;
            }
        }

        const radios = stepEl.querySelectorAll("input[type='radio']");
        if (radios.length) {
            const groups = [...new Set([...radios].map(r => r.name))];

            for (const name of groups) {
                const checked = stepEl.querySelector(`input[name="${name}"]:checked`);
                if (!checked) {
                    const firstRadio = stepEl.querySelector(`input[name="${name}"]`);
                    scrollToInvalidTarget(firstRadio);
                    return false;
                }
            }
        }
        const person = stepEl.querySelector("#emergency_person");
        if (person && !validateEmergencyPerson(true)) {
            showMiniTab("This name is invalid. Please use letters only.");
            scrollToInvalidTarget(person);
            return false;
        }
        const phone = stepEl.querySelector("#emergency_number");
        if (phone) {
            const digits = phone.value.replace(/\D/g, "");
            if (!/^09\d{9}$/.test(digits)) {
                showMiniTab("Please enter a valid contact number.");
                phone.classList.add("input-invalid");
                setPhoneFeedback("Enter a valid mobile number in the format 09xx xxx xxxx.", "error");
                scrollToInvalidTarget(phone);
                return false;
            }
        }
        if (s === 3) {
            const signatureInput = document.getElementById("patient_signature");
            const signatureBlock = signatureInput?.closest(".section-card") || signatureInput;

            if (signatureAiChecking) {
                showMiniTab("Please wait while we verify your signature.");
                scrollToInvalidTarget(signatureBlock);
                return false;
            }

            if (!signatureInput?.files?.length) {
                showMiniTab("Please upload your patient signature.");
                scrollToInvalidTarget(signatureBlock);
                return false;
            }

            if (!signatureAiValid) {
                showMiniTab("Please upload a valid signature image.");
                scrollToInvalidTarget(signatureBlock);
                return false;
            }
        }

        return true;
    }

    nextBtn?.addEventListener("click", () => {
        if (!isStepComplete(step)) {
            showMiniTab("Please complete all required fields before proceeding.");
            return;
        }
        if (!completedSteps.includes(step)) completedSteps.push(step);
        showStep(Math.min(step + 1, steps.length - 1));
    });
    prevBtn?.addEventListener("click", () => showStep(Math.max(step - 1, 0)));
    document.getElementById("summaryBackBtn")?.addEventListener("click", () => showStep(3));
    document.getElementById("goToConfirmationBtn")?.addEventListener("click", () => {
        summarySection?.classList.add("hidden");
        confirmationSection?.classList.remove("hidden");
        confirmationSection?.scrollIntoView({
            behavior: "smooth",
            block: "start"
        });
    });
    document.getElementById("confirmBackBtn")?.addEventListener("click", () => {
        confirmationSection?.classList.add("hidden");
        summarySection?.classList.remove("hidden");
        summarySection?.scrollIntoView({
            behavior: "smooth",
            block: "start"
        });
    });

    function setupCharLimit(inputId, counterId, max = 150, warningId = null) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);
        const warning = warningId ? document.getElementById(warningId) : null;

        if (!input || !counter) return;

        function updateUI() {
            let length = input.value.length;

            if (length > max) {
                input.value = input.value.slice(0, max);
                length = max;
            }

            counter.textContent = `${length}/${max}`;

            counter.classList.remove("text-red-600", "text-yellow-500");
            input.classList.remove("border-red-500", "ring-1", "ring-red-400");

            if (warning) warning.classList.add("hidden");

            if (length >= max) {
                counter.classList.add("text-red-600");
                input.classList.add("border-red-500", "ring-1", "ring-red-400");
                if (warning) warning.classList.remove("hidden");
            } else if (length >= max - 10) {
                counter.classList.add("text-yellow-500");
            }
        }

        input.addEventListener("input", updateUI);

        updateUI();
    }

    window.addEventListener("beforeunload", (e) => {
        if (formIsDirty && !formSubmitting) {
            e.preventDefault();
            e.returnValue = "";
        }
    });

    function markFormDirty() {
        formIsDirty = true;
    }

    setupCharLimit("additional_concerns", "concernCount", 150);

    function buildSummary() {
        const form = document.getElementById("appointmentForm");
        if (!form) return;

        const data = new FormData(form);
        const get = n => data.get(n) || "N/A";
        const getAll = n => data.getAll(n);

        const emergencyRelation = data.get("emergency_relation") || "N/A";

        const sigFile = data.get("patient_signature");
        let sigHTML = `<span class="text-[#9e9690] italic">Not uploaded</span>`;
        if (sigFile && sigFile.size > 0) {
            const url = URL.createObjectURL(sigFile);
            sigHTML = `
        <div class="space-y-2">
            <p><b class="text-[#5c5550] font-semibold">File:</b> ${sigFile.name}</p>
            <p class="text-emerald-700 font-semibold">
                <i class="fa-solid fa-circle-check mr-1"></i> Signature uploaded
            </p>
            <img src="${url}" alt="Signature" class="max-w-[220px] max-h-[130px] rounded-lg border border-[#e8e2dd]">
        </div>
    `;
        }

        const row = (label, val) =>
            `<p><b class="text-[#5c5550] font-semibold">${label}:</b> ${val && String(val).trim() !== "" ? val : '<span class="text-[#9e9690]">N/A</span>'}</p>`;

        const optionalRow = (label, val) => {
            if (!val || String(val).trim() === "" || val === "N/A") return "";
            return `<p><b class="text-[#5c5550] font-semibold">${label}:</b> ${val}</p>`;
        };

        const summaryCard = (title, icon, body) => `
                <div class="border border-[#e8e2dd] rounded-xl overflow-hidden bg-white">
                    <div class="bg-[#f9e8e8] px-4 py-2.5 text-xs font-bold text-[#8B0000] uppercase tracking-widest border-b border-[#e8e2dd]">
                        <i class="fa-solid ${icon} mr-2"></i>${title}
                    </div>
                    <div class="p-4 text-sm leading-7 text-[#1a1410] space-y-4">${body}</div>
                </div>
            `;

        const subSection = (title, body) => `
                <div class="rounded-xl border border-[#f1e8e3] bg-[#fffdfd] overflow-hidden">
                    <div class="px-4 py-2.5 bg-[#fff7f6] border-b border-[#f1e8e3] text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-[#8B0000]">
                        ${title}
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-2 gap-x-8 gap-y-1 sm-grid-1col">
                            ${body}
                        </div>
                    </div>
                </div>
            `;

        const fullWidthSection = (title, body) => `
                <div class="rounded-xl border border-[#f1e8e3] bg-[#fffdfd] overflow-hidden">
                    <div class="px-4 py-2.5 bg-[#fff7f6] border-b border-[#f1e8e3] text-[0.72rem] font-extrabold uppercase tracking-[0.16em] text-[#8B0000]">
                        ${title}
                    </div>
                    <div class="p-4 text-sm leading-7 text-[#1a1410]">
                        ${body}
                    </div>
                </div>
            `;

        const diseases = getAll("diseases[]");
        const diseaseText = diseases.length ?
            diseases.map(code => diseaseLabelByCode?.[code] ?? code).join(", ") :
            "None";

        const patientName = @json($patient -> name ?? 'N/A');
        const patientGender = @json($patient -> gender ?? 'N/A');
        const dentalHistoryBody = `
    ${subSection("Basic Info", `
        ${row("Last Dental Visit", get("last_dental_visit"))}
        ${row("Previous Dentist", get("previous_dentist"))}
    `)}

    ${subSection("Dental Symptoms", `
        ${row("Bleeding Gums", get("bleeding_gums"))}
        ${row("Sensitive (Hot/Cold)", get("sensitive_temp"))}
        ${row("Sensitive (Sweets/Sour)", get("sensitive_taste"))}
        ${row("Tooth Pain", get("tooth_pain"))}
        ${row("Sores/Lumps", get("sores"))}
        ${row("Jaw Injuries", get("injuries"))}
    `)}

    ${subSection("Jaw & Bite Symptoms", `
        ${row("Clicking", get("clicking"))}
        ${row("Joint Pain", get("joint_pain"))}
        ${row("Difficulty Moving", get("difficulty_moving"))}
        ${row("Difficulty Chewing", get("difficulty_chewing"))}
        ${row("Frequent Headaches", get("jaw_headaches"))}
        ${row("Grinding/Clenching", get("clench_grind"))}
        ${row("Lips/Cheek Biting", get("biting"))}
        ${row("Teeth Loosening", get("teeth_loosening"))}
        ${row("Food Caught Between Teeth", get("food_teeth"))}
        ${row("Medicine Reaction", get("med_reaction"))}
    `)}

    ${subSection("Dental Procedures", `
        ${row("Periodontal Treatment", get("periodontal"))}
        ${row("Difficult Extraction", get("difficult_extraction"))}
        ${get("difficult_extraction") === "YES" ? row("Extraction Date", get("extraction_date")) : ""}

        ${row("Prolonged Bleeding", get("prolonged_bleeding"))}
        ${row("Dentures", get("dentures"))}
        ${get("dentures") === "YES" ? row("Dentures Placement Date", get("dentures_date")) : ""}

        ${row("Orthodontic Treatment", get("ortho_treatment"))}
        ${get("ortho_treatment") === "YES" ? row("Orthodontic Completion Date", get("ortho_date")) : ""}
    `)}

    ${fullWidthSection("Additional Concerns", `
        ${get("additional_concerns") !== "N/A" && String(get("additional_concerns")).trim() !== ""
                ? get("additional_concerns")
                : '<span class="text-[#9e9690] italic">No additional concerns provided.</span>'}
    `)}
    `;

        const medicalHistoryBody = `
    ${subSection("General Health", `
        ${row("Good Health", get("good_health"))}
        ${get("good_health") === "NO" ? row("Health Details", get("good_health_details")) : ""}

        ${row("Had Medical Exam", get("had_medical_exam"))}
        ${get("had_medical_exam") === "YES" ? row("Medical Exam Date", get("medical_exam_date")) : ""}

        ${row("Under Treatment", get("under_treatment"))}
        ${get("under_treatment") === "YES" ? row("Treatment Details", get("treatment_details")) : ""}

        ${row("Hospitalized", get("hospitalized"))}
        ${get("hospitalized") === "YES" ? row("Hospital Details", get("hospital_details")) : ""}
    `)}

    ${subSection("Allergies", `
        ${row("Allergy (Medicine)", get("allergy_medicine"))}
        ${row("Allergy (Food)", get("allergy_food"))}
        ${optionalRow("Allergy (Others)", get("allergy_others"))}
    `)}

    ${subSection("Medications", `
        ${row("Medication", get("medication"))}
        ${get("medication") === "YES" ? row("Medication Details", get("medication_details")) : ""}
    `)}

    ${isFemalePatient ? subSection("For Women Only", `
        ${row("Pregnant", get("pregnant"))}
        ${row("Nursing", get("nursing"))}
        ${row("Birth Control Pills", get("birth_control"))}
    `) : ""}

    ${fullWidthSection("Medical Conditions", `
        <b class="text-[#5c5550] dark:text-[#e5e5e5] font-semibold">Selected Conditions:</b> ${diseaseText}
    `)}

    ${subSection("Tobacco Use", `
        ${row("Tobacco Use", get("tobacco_use"))}
        ${get("tobacco_use") === "YES" ? row("Amount Per Day", get("tobacco_per_day")) : ""}
        ${get("tobacco_use") === "YES" ? row("Amount Per Week", get("tobacco_per_week")) : ""}
    `)}

    ${subSection("Do You Suffer From", `
        ${row("Headaches", get("headaches"))}
        ${row("Earaches", get("earaches"))}
        ${row("Neck Aches", get("neck_aches"))}
    `)}
    `;

        document.getElementById("summaryBox").innerHTML = `
    ${summaryCard("Patient Information", "fa-user", `
        <div class="grid grid-cols-1 gap-y-1">
            ${row("Name", patientName)}
            ${row("Gender", patientGender)}
        </div>
    `)}

    <div class="grid grid-cols-2 gap-4 sm-grid-1col">
        ${summaryCard("Appointment Details", "fa-calendar-check", `
        <div class="grid grid-cols-1 gap-y-1">
            ${row("Date", get("appointment_date"))}
            ${row("Time", get("appointment_time"))}
        </div>
    `)}

        ${summaryCard("Service", "fa-tooth", `
            <div class="grid grid-cols-1 gap-y-1">
                ${row("Type", get("service_type"))}
            </div>
        `)}
    </div>

    ${summaryCard("Dental History", "fa-teeth", dentalHistoryBody)}

    ${summaryCard("Medical History", "fa-heart-pulse", medicalHistoryBody)}

    <div class="grid grid-cols-2 gap-4 sm-grid-1col">
        ${summaryCard("Emergency Contact", "fa-phone", `
            <div class="grid grid-cols-1 gap-y-1">
                ${row("Name", get("emergency_person"))}
                ${row("Number", get("emergency_number"))}
                ${row("Relation", emergencyRelation)}
            </div>
        `)}

        ${summaryCard("Signature", "fa-signature", sigHTML)}
    </div>
`;

        document.querySelectorAll(".sm-grid-1col").forEach(el => {
            if (window.innerWidth < 640) el.style.gridTemplateColumns = "1fr";
        });
    }

    const confirmModal = document.getElementById("confirmModal");
    const confirmMessage = document.getElementById("confirmMessage");
    const okBtn = document.getElementById("okBtn");

    function showSlotFullWarning(date) {
        const slotFullModal = document.getElementById("slotFullModal");
        if (!slotFullModal) return;

        const dateDisplay = new Date(date + "T00:00:00").toLocaleDateString("en-US", {
            weekday: "short",
            year: "numeric",
            month: "short",
            day: "numeric"
        });

        const msg = document.getElementById("slotFullMessage");
        if (msg) {
            msg.innerHTML =
                `<strong>The appointment slots for ${dateDisplay} are fully booked.</strong><br>Please select a different date to continue with your booking.`;
        }

        slotFullModal.showModal();
    }

    const finalSubmitBtn = document.getElementById('finalSubmitBtn');
    const finalConfirm = document.getElementById('finalConfirm');

    function replayConfirmModalAnimation() {
        if (!confirmModal) return;

        confirmModal.classList.remove("confirm-modal-animate");
        void confirmModal.offsetWidth;
        confirmModal.classList.add("confirm-modal-animate");

        confirmModal.querySelectorAll(
            ".confirm-modal-icon, .confirm-modal-title, .confirm-modal-message, .confirm-modal-button"
        ).forEach(el => {
            el.style.animation = "none";
            void el.offsetWidth;
            el.style.animation = "";
        });
    }

    if (finalSubmitBtn) {
        finalSubmitBtn.addEventListener("click", () => {
            if (!finalConfirm || !finalConfirm.checked) {
                showMiniTab("Please confirm before submitting.");
                return;
            }

            const date = document.getElementById("appointment_date")?.value || "N/A";
            const time = document.getElementById("appointment_time")?.value || "N/A";

            if (confirmMessage) {
                confirmMessage.innerHTML = `
        Your dental appointment at PUP Taguig Dental Clinic has been successfully scheduled on 
        <b>${date}</b> at <b>${time}</b>.<br>
        Please arrive on time and bring your school or office ID.
        <br>
        `;
            }

            confirmModal?.showModal();
            requestAnimationFrame(() => {
                replayConfirmModalAnimation();
            });
        });
    }

    if (okBtn) {
        okBtn.addEventListener("click", () => {
            clearDraft();
            formSubmitting = true;
            document.getElementById("appointmentForm").submit();
        });
    }

    var html = document.documentElement;
    var themeToggleContainer = document.getElementById("themeToggle");

    [{
        name: "difficult_extraction",
        boxId: "extraction_date_box",
        showOn: "YES"
    }, {
        name: "dentures",
        boxId: "dentures_date_box",
        showOn: "YES"
    }, {
        name: "ortho_treatment",
        boxId: "ortho_date_box",
        showOn: "YES"
    }].forEach(({
        name,
        boxId,
        showOn
    }) => {
        const radios = document.getElementsByName(name);
        const box = document.getElementById(boxId);
        if (!box || !radios.length) return;
        const inp = box.querySelector("input");
        radios.forEach(r => r.addEventListener("change", () => {
            if (r.checked && r.value === showOn) {
                box.classList.remove("hidden");
                if (inp) inp.required = true;
            } else if (r.checked) {
                box.classList.add("hidden");
                if (inp) {
                    inp.required = false;
                    inp.value = "";
                }
            }
        }));
    });

    function syncMedicalExamBox() {
        const sel = document.querySelector('input[name="had_medical_exam"]:checked');
        const box = document.getElementById("medical_exam_box");
        const inp = document.getElementById("medicalExamDate");
        if (!sel || !box || !inp) return;
        if (sel.value === "YES") {
            box.classList.remove("hidden");
            inp.required = true;
        } else {
            box.classList.add("hidden");
            inp.required = false;
            inp.value = "";
        }
    }
    document.querySelectorAll('input[name="had_medical_exam"]').forEach(r => r.addEventListener("change",
        syncMedicalExamBox));
    syncMedicalExamBox();
    document.getElementById("emergency_relation")
        ?.addEventListener("change", function () {
            const other = document.getElementById("relation_other");
            if (!other) return;
            if (this.value === "Others") {
                other.classList.remove("hidden");
                other.setAttribute("required", "true");
            } else {
                other.classList.add("hidden");
                other.removeAttribute("required");
                other.value = "";
            }
        });
    [{
        name: "good_health",
        boxId: "good_health_box",
        showOn: "NO"
    }, {
        name: "under_treatment",
        boxId: "treatment_box",
        showOn: "YES"
    }, {
        name: "hospitalized",
        boxId: "hospital_box",
        showOn: "YES"
    }, {
        name: "medication",
        boxId: "medication_box",
        showOn: "YES"
    }].forEach(({
        name,
        boxId,
        showOn
    }) => {
        const radios = document.getElementsByName(name);
        const box = document.getElementById(boxId);
        if (!box || !radios.length) return;
        radios.forEach(r => r.addEventListener("change", () => {
            const sel = [...radios].find(x => x.checked);
            const inputs = box.querySelectorAll("input");
            if (sel?.value === showOn) {
                box.classList.remove("hidden");
                inputs.forEach(i => i.required = true);
            } else {
                box.classList.add("hidden");
                inputs.forEach(i => {
                    i.required = false;
                    i.value = "";
                });
            }
        }));
    });
    [...document.getElementsByName("tobacco_use")].forEach(r => r.addEventListener("change", () => {
        if (r.checked && r.value === "YES") document.getElementById("tobacco_details")?.classList
            .remove(
                "hidden");
        else document.getElementById("tobacco_details")?.classList.add("hidden");
    }));
    const sigInput = document.getElementById("patient_signature");
    const signatureSourceInput = document.getElementById("signature_source");
    const sigName = document.getElementById("signature_filename");
    const sigError = document.getElementById("signature_error");
    const sigResultBox = document.getElementById("signature_result_box");

    const SIGNATURE_ACCEPTED_MESSAGE = "Signature verified and accepted";
    const SIGNATURE_DECLINED_MESSAGE = "Signature could not be processed. Please try again.";

    let signatureAiValid = false;
    let signatureAiChecking = false;

    function escapeHtml(value) {
        return String(value || "")
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");
    }

    function clearSignatureDisplay() {
        sigResultBox?.classList.add("hidden");

        if (sigName) {
            sigName.textContent = "";
            sigName.classList.remove("text-emerald-700", "text-red-600", "text-[#5c5550]");
        }

        if (sigError) {
            sigError.innerHTML = "";
            sigError.classList.add("hidden");
        }
    }

    function showSignatureStatus(fileName = "", message = "", type = "neutral") {
        sigResultBox?.classList.remove("hidden");

        if (sigName) {
            sigName.textContent = fileName;
            sigName.classList.remove("text-emerald-700", "text-red-600", "text-[#5c5550]");

            if (type === "success") {
                sigName.classList.add("text-emerald-700");
            } else if (type === "error") {
                sigName.classList.add("text-red-600");
            } else {
                sigName.classList.add("text-[#5c5550]");
            }
        }

        if (sigError) {
            let icon = `<i class="fa-solid fa-spinner fa-spin mr-1"></i>`;

            if (type === "success") {
                icon = `<i class="fa-solid fa-circle-check mr-1"></i>`;
                sigError.className =
                    "mt-1 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs text-emerald-700 leading-5 font-semibold";
            } else if (type === "error") {
                icon = `<i class="fa-solid fa-circle-exclamation mr-1"></i>`;
                sigError.className =
                    "mt-1 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-700 leading-5 font-semibold";
            } else {
                sigError.className =
                    "mt-1 rounded-xl border border-[#e8e2dd] bg-white px-3 py-2 text-xs text-[#5c5550] leading-5 font-semibold";
            }

            sigError.innerHTML = `${icon}${escapeHtml(message)}`;
            sigError.classList.remove("hidden");
        }
    }

    function showSignatureError(fileName = "", result = {}) {
        signatureAiValid = false;
        signatureAiChecking = false;

        const aiReason = result.reason || "The uploaded image did not pass signature validation.";
        const detectedType = result.detected_type || "unknown";
        const confidence = result.confidence !== undefined && result.confidence !== null ?
            Number(result.confidence).toFixed(2) :
            "N/A";

        sigResultBox?.classList.remove("hidden");

        if (sigName) {
            sigName.textContent = fileName;
            sigName.classList.remove("text-emerald-700", "text-[#5c5550]");
            sigName.classList.add("text-red-600");
        }

        if (sigError) {
            sigError.className =
                "mt-1 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-700 leading-5 font-semibold";

            sigError.innerHTML = `
            <div class="flex items-start gap-2">
                <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                <div>
                    <p>${escapeHtml(SIGNATURE_DECLINED_MESSAGE)}</p>
                    <p class="mt-1 font-medium">Reason: ${escapeHtml(aiReason)}</p>
                    <p class="mt-1 text-[0.7rem] opacity-80">
                        Detected: ${escapeHtml(detectedType)} · Confidence: ${escapeHtml(confidence)}
                    </p>
                </div>
            </div>
        `;

            sigError.classList.remove("hidden");
        }

        if (sigInput) {
            sigInput.value = "";
        }
    }

    function clearSignatureError() {
        if (sigError) {
            sigError.innerHTML = "";
            sigError.classList.add("hidden");
        }
    }

    function isDrawnSignatureFile(file) {
        return file?.name?.startsWith("drawn-signature-");
    }

    async function validateSignatureWithAi(file) {
        const formData = new FormData();
        formData.append("patient_signature", file);

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

        const response = await fetch("{{ route('book.appointment.validate-signature') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json",
            },
            body: formData,
        });

        const data = await response.json().catch(() => ({}));

        if (!response.ok || data.valid === false || data.accepted === false) {
            const error = new Error(data.message || "Signature could not be processed. Please try again.");
            error.data = data;
            throw error;
        }

        return data;
    }

    sigInput?.addEventListener("change", () => {
        const file = sigInput.files?.[0];
        const isDrawnSignature = isDrawnSignatureFile(file);

        signatureAiValid = false;
        clearSignatureError();

        if (!file) {
            if (signatureSourceInput) signatureSourceInput.value = "";
            clearSignatureDisplay();
            return;
        }

        if (signatureSourceInput) {
            signatureSourceInput.value = isDrawnSignature ? "drawn" : "";
        }

        if (!isDrawnSignature) {
            drawnSignatureWasUsed = false;
        }

        const allowedTypes = ["image/jpeg", "image/png"];
        const maxSize = 25 * 1024 * 1024;

        if (!allowedTypes.includes(file.type)) {
            showSignatureError(file?.name || "", {
                reason: "Signature must be a JPG or PNG file.",
                detected_type: "invalid_file_type",
                confidence: 0,
            });
            return;
        }

        if (file.size > maxSize) {
            showSignatureError(file.name, {
                reason: "Signature file must not exceed 25 MB.",
                detected_type: "file_too_large",
                confidence: 0,
            });
            return;
        }

        if (isDrawnSignature) {
            drawnSignatureWasUsed = true;
            signatureAiValid = true;
            signatureAiChecking = false;
            showSignatureStatus(file.name, "Drawn signature accepted.", "success");
            markFormDirty();
            return;
        }

        const img = new Image();
        const objectUrl = URL.createObjectURL(file);

        img.onload = async function () {
            const {
                width,
                height
            } = img;

            if (width < 120 || height < 60) {
                URL.revokeObjectURL(objectUrl);
                showSignatureError(file.name, {
                    reason: "Signature image is too small. Please upload a clearer signature.",
                    detected_type: "image_too_small",
                    confidence: 0,
                });
                return;
            }

            if (width > 5000 || height > 5000) {
                URL.revokeObjectURL(objectUrl);
                showSignatureError(file.name, {
                    reason: "Signature image is too large. Please upload a smaller image.",
                    detected_type: "image_too_large",
                    confidence: 0,
                });
                return;
            }

            URL.revokeObjectURL(objectUrl);

            try {
                signatureAiChecking = true;
                showSignatureStatus(file.name, "Checking signature image...", "neutral");

                const result = await validateSignatureWithAi(file);

                signatureAiValid = true;
                signatureAiChecking = false;
                clearSignatureError();

                showSignatureStatus(file.name, SIGNATURE_ACCEPTED_MESSAGE, "success");
                markFormDirty();

            } catch (error) {
                signatureAiValid = false;
                signatureAiChecking = false;

                showSignatureError(file.name, error.data || {
                    message: SIGNATURE_DECLINED_MESSAGE,
                    reason: error.message || "Unable to validate the uploaded image.",
                    detected_type: "unknown",
                    confidence: 0,
                });
            }
        };

        img.onerror = function () {
            URL.revokeObjectURL(objectUrl);
            showSignatureError(file?.name || "", {
                reason: "Invalid signature image file.",
                detected_type: "invalid_image",
                confidence: 0,
            });
        };

        img.src = objectUrl;
    });

    const signatureCanvas = document.getElementById("signatureCanvas");
    const signatureCtx = signatureCanvas?.getContext("2d");
    const signatureUndoBtn = document.getElementById("signatureUndoBtn");
    const signatureClearBtn = document.getElementById("signatureClearBtn");
    const signatureUseDrawnBtn = document.getElementById("signatureUseDrawnBtn");

    let drawnSignatureStrokes = [];
    let drawnSignatureCurrentStroke = [];
    let drawnSignatureIsDrawing = false;
    let drawnSignatureWasUsed = false;

    function resizeSignatureCanvas() {
        if (!signatureCanvas || !signatureCtx) return;

        const rect = signatureCanvas.getBoundingClientRect();
        if (!rect.width) return;

        const dpr = Math.max(window.devicePixelRatio || 1, 1);
        const cssWidth = rect.width;
        const cssHeight = signatureCanvas.offsetHeight || 220;

        signatureCanvas.width = Math.round(cssWidth * dpr);
        signatureCanvas.height = Math.round(cssHeight * dpr);

        signatureCtx.setTransform(dpr, 0, 0, dpr, 0, 0);

        redrawSignatureCanvas();
    }

    function paintSignatureCanvasBackground() {
        if (!signatureCanvas || !signatureCtx) return;

        signatureCtx.save();
        signatureCtx.setTransform(1, 0, 0, 1, 0, 0);
        signatureCtx.clearRect(0, 0, signatureCanvas.width, signatureCanvas.height);
        signatureCtx.fillStyle = "#ffffff";
        signatureCtx.fillRect(0, 0, signatureCanvas.width, signatureCanvas.height);
        signatureCtx.restore();
    }

    function drawSignatureStroke(stroke) {
        if (!signatureCtx || !stroke || !stroke.length) return;

        signatureCtx.lineWidth = 3.2;
        signatureCtx.lineCap = "round";
        signatureCtx.lineJoin = "round";
        signatureCtx.strokeStyle = "#111827";

        if (stroke.length === 1) {
            signatureCtx.beginPath();
            signatureCtx.arc(stroke[0].x, stroke[0].y, 1.8, 0, Math.PI * 2);
            signatureCtx.fillStyle = "#111827";
            signatureCtx.fill();
            return;
        }

        signatureCtx.beginPath();
        signatureCtx.moveTo(stroke[0].x, stroke[0].y);

        for (let i = 1; i < stroke.length - 1; i++) {
            const midX = (stroke[i].x + stroke[i + 1].x) / 2;
            const midY = (stroke[i].y + stroke[i + 1].y) / 2;
            signatureCtx.quadraticCurveTo(stroke[i].x, stroke[i].y, midX, midY);
        }

        const last = stroke[stroke.length - 1];
        signatureCtx.lineTo(last.x, last.y);
        signatureCtx.stroke();
    }

    function redrawSignatureCanvas() {
        if (!signatureCanvas || !signatureCtx) return;

        paintSignatureCanvasBackground();

        drawnSignatureStrokes.forEach(drawSignatureStroke);

        if (drawnSignatureCurrentStroke.length) {
            drawSignatureStroke(drawnSignatureCurrentStroke);
        }
    }

    function getSignaturePoint(event) {
        const rect = signatureCanvas.getBoundingClientRect();

        return {
            x: event.clientX - rect.left,
            y: event.clientY - rect.top,
        };
    }

    function isDrawnSignatureBlank() {
        return drawnSignatureStrokes.length === 0 && drawnSignatureCurrentStroke.length === 0;
    }

    function invalidateDrawnSignatureAfterEdit() {
        if (!drawnSignatureWasUsed) return;

        drawnSignatureWasUsed = false;
        signatureAiValid = false;

        if (sigInput) {
            sigInput.value = "";
        }

        if (signatureSourceInput) {
            signatureSourceInput.value = "";
        }

        showSignatureStatus(
            "",
            "Draw changed. Click Use Drawn Signature again to verify it.",
            "neutral"
        );
    }

    function startDrawnSignature(event) {
        if (!signatureCanvas) return;
        if (event.pointerType === "mouse" && event.button !== 0) return;

        resizeSignatureCanvas();

        event.preventDefault();

        drawnSignatureIsDrawing = true;
        drawnSignatureCurrentStroke = [getSignaturePoint(event)];

        signatureCanvas.setPointerCapture?.(event.pointerId);

        redrawSignatureCanvas();
    }

    function moveDrawnSignature(event) {
        if (!drawnSignatureIsDrawing) return;

        event.preventDefault();

        drawnSignatureCurrentStroke.push(getSignaturePoint(event));

        redrawSignatureCanvas();
    }

    function endDrawnSignature(event) {
        if (!drawnSignatureIsDrawing) return;

        event.preventDefault();

        if (drawnSignatureCurrentStroke.length) {
            drawnSignatureStrokes.push(drawnSignatureCurrentStroke);
        }

        drawnSignatureCurrentStroke = [];
        drawnSignatureIsDrawing = false;

        markFormDirty();
        invalidateDrawnSignatureAfterEdit();
        redrawSignatureCanvas();
    }

    function clearDrawnSignature() {
        drawnSignatureStrokes = [];
        drawnSignatureCurrentStroke = [];
        drawnSignatureIsDrawing = false;
        drawnSignatureWasUsed = false;

        redrawSignatureCanvas();

        signatureAiValid = false;

        if (sigInput) {
            sigInput.value = "";
        }

        if (signatureSourceInput) {
            signatureSourceInput.value = "";
        }

        clearSignatureDisplay();
        markFormDirty();
    }

    function undoDrawnSignature() {
        if (!drawnSignatureStrokes.length) return;

        drawnSignatureStrokes.pop();

        redrawSignatureCanvas();
        invalidateDrawnSignatureAfterEdit();
        markFormDirty();

        if (isDrawnSignatureBlank()) {
            drawnSignatureWasUsed = false;
            signatureAiValid = false;

            if (sigInput) {
                sigInput.value = "";
            }

            if (signatureSourceInput) {
                signatureSourceInput.value = "";
            }

            clearSignatureDisplay();
        }
    }

    function attachDrawnSignatureToFileInput(file) {
        if (!sigInput) return false;

        if (typeof DataTransfer === "undefined") {
            showMiniTab("Your browser cannot attach the drawn signature. Please upload an image instead.");
            return false;
        }

        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        sigInput.files = dataTransfer.files;

        return true;
    }

    function useDrawnSignature() {
        if (!signatureCanvas) return;

        if (isDrawnSignatureBlank()) {
            showMiniTab("Please draw your signature first.");
            return;
        }

        redrawSignatureCanvas();

        signatureCanvas.toBlob((blob) => {
            if (!blob) {
                showMiniTab("Unable to process drawn signature. Please try again.");
                return;
            }

            const file = new File(
                [blob],
                `drawn-signature-${Date.now()}.png`, {
                type: "image/png",
                lastModified: Date.now(),
            }
            );

            const attached = attachDrawnSignatureToFileInput(file);
            if (!attached) return;

            drawnSignatureWasUsed = true;
            if (signatureSourceInput) {
                signatureSourceInput.value = "drawn";
            }

            sigInput.dispatchEvent(new Event("change", {
                bubbles: true,
            }));
        }, "image/png", 0.95);
    }

    signatureCanvas?.addEventListener("pointerdown", startDrawnSignature);
    signatureCanvas?.addEventListener("pointermove", moveDrawnSignature);
    signatureCanvas?.addEventListener("pointerup", endDrawnSignature);
    signatureCanvas?.addEventListener("pointercancel", endDrawnSignature);
    signatureCanvas?.addEventListener("pointerleave", endDrawnSignature);

    signatureUndoBtn?.addEventListener("click", undoDrawnSignature);
    signatureClearBtn?.addEventListener("click", clearDrawnSignature);
    signatureUseDrawnBtn?.addEventListener("click", useDrawnSignature);

    window.addEventListener("resize", () => {
        if (step === 3) {
            resizeSignatureCanvas();
        }
    });

    setTimeout(resizeSignatureCanvas, 300);

    const emergencyNumber = document.getElementById("emergency_number");
    const emergencyNumberFeedback = document.getElementById("emergency_number_feedback");
    const emergencyPerson = document.getElementById("emergency_person");
    const emergencyPersonFeedback = document.getElementById("emergency_person_feedback");

    function setEmergencyPersonFeedback(message, type = "") {
        if (!emergencyPersonFeedback) return;

        emergencyPersonFeedback.textContent = message;
        emergencyPersonFeedback.classList.remove("error", "success", "text-[#9e9690]");

        if (type === "error") emergencyPersonFeedback.classList.add("error");
        else if (type === "success") emergencyPersonFeedback.classList.add("success");
        else emergencyPersonFeedback.classList.add("text-[#9e9690]");
    }

    function validateEmergencyPerson(showNeutral = false) {
        if (!emergencyPerson) return false;

        const value = emergencyPerson.value.trim();
        const validNamePattern = /^[A-Za-zÑñ\s.'-]+$/;

        emergencyPerson.classList.remove("input-invalid", "input-valid");

        if (!value.length) {
            if (showNeutral) {
                setEmergencyPersonFeedback("Only letters, spaces, apostrophe, period, and hyphen are allowed.");
            } else {
                setEmergencyPersonFeedback("");
            }
            return false;
        }

        if (!validNamePattern.test(value)) {
            emergencyPerson.classList.add("input-invalid");
            setEmergencyPersonFeedback("This name is invalid. Please use letters only.", "error");
            return false;
        }

        emergencyPerson.classList.add("input-valid");
        setEmergencyPersonFeedback("Valid emergency contact name.", "success");
        return true;
    }

    emergencyPerson?.addEventListener("input", (e) => {
        const sanitizedValue = e.target.value.replace(/[^A-Za-zÑñ\s.'-]/g, "");
        const hadInvalidChars = sanitizedValue !== e.target.value;

        if (hadInvalidChars) {
            e.target.value = sanitizedValue;
            showMiniTab("Emergency contact name must contain letters only.");
        }

        validateEmergencyPerson(true);
        markFormDirty();
    });

    emergencyPerson?.addEventListener("blur", () => {
        validateEmergencyPerson(true);
    });
    let emergencyNumberFeedbackTimer = null;

    function formatPhoneDisplay(rawDigits) {
        const digits = rawDigits.slice(0, 11);
        let out = "";

        if (digits.length > 0) out += digits.slice(0, 4);
        if (digits.length > 4) out += " " + digits.slice(4, 7);
        if (digits.length > 7) out += " " + digits.slice(7, 11);

        return out;
    }

    function setPhoneFeedback(message, type = "") {
        if (!emergencyNumberFeedback) return;

        if (emergencyNumberFeedbackTimer) {
            clearTimeout(emergencyNumberFeedbackTimer);
            emergencyNumberFeedbackTimer = null;
        }

        emergencyNumberFeedback.textContent = message;
        emergencyNumberFeedback.classList.remove("error", "success", "text-[#9e9690]");
        if (type === "error") emergencyNumberFeedback.classList.add("error");
        else if (type === "success") emergencyNumberFeedback.classList.add("success");
        else emergencyNumberFeedback.classList.add("text-[#9e9690]");

        if (type === "success") {
            emergencyNumberFeedbackTimer = setTimeout(() => {
                emergencyNumberFeedback.textContent = "";
                emergencyNumberFeedback.classList.remove("success");
                emergencyNumberFeedbackTimer = null;
            }, 2000);
        }
    }

    function validateEmergencyNumber(showNeutral = false) {
        if (!emergencyNumber) return false;

        const digits = emergencyNumber.value.replace(/\D/g, "");

        emergencyNumber.classList.remove("input-invalid", "input-valid", "border-red-500", "border-green-600");

        if (!digits.length) {
            if (showNeutral) setPhoneFeedback("Format: 09xx xxx xxxx");
            else setPhoneFeedback("");
            return false;
        }

        if (!digits.startsWith("09")) {
            emergencyNumber.classList.add("input-invalid");
            setPhoneFeedback("Contact number must start with 09.", "error");
            return false;
        }

        if (digits.length < 11) {
            emergencyNumber.classList.add("input-invalid");
            setPhoneFeedback("Contact number must be 11 digits.", "error");
            return false;
        }

        if (digits.length === 11) {
            emergencyNumber.classList.add("input-valid");
            setPhoneFeedback("Valid contact number.", "success");
            return true;
        }

        emergencyNumber.classList.add("input-invalid");
        setPhoneFeedback("Contact number must be 11 digits only.", "error");
        return false;
    }

    emergencyNumber?.addEventListener("input", (e) => {
        const hadNonDigit = /[^\d\s]/.test(e.target.value);

        let digits = e.target.value.replace(/\D/g, "");

        if (digits.startsWith("9")) digits = "0" + digits;
        if (digits.length > 11) digits = digits.slice(0, 11);

        emergencyNumber.value = formatPhoneDisplay(digits);

        if (hadNonDigit) {
            showMiniTab("Contact number must contain digits only.");
        }

        validateEmergencyNumber(true);
        markFormDirty();
    });

    emergencyNumber?.addEventListener("focus", () => {
        validateEmergencyNumber(true);
    });

    emergencyNumber?.addEventListener("blur", () => {
        validateEmergencyNumber(true);
    });

    let formIsDirty = false;
    let formSubmitting = false;
    let pendingNavigation = null;

    const leaveModal = document.getElementById('leaveModal');

    document.querySelectorAll('input, textarea, select').forEach(input => {
        input.addEventListener('input', () => {
            formIsDirty = true;
        });
    });
    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
        input.addEventListener('change', () => {
            formIsDirty = true;
        });
    });

    function openLeaveModal(onConfirm) {
        pendingNavigation = onConfirm;
        leaveModal.showModal();
    }

    function confirmReloadPage() {
        openLeaveModal(() => {
            window.location.reload();
        });
    }

    function closeLeaveModal() {
        if (leaveModal.open) leaveModal.close();
        pendingNavigation = null;
    }

    document.getElementById('cancelLeaveBtn')?.addEventListener('click', closeLeaveModal);

    document.getElementById('slotFullOkBtn')?.addEventListener('click', () => {
        const modal = document.getElementById('slotFullModal');
        if (modal) modal.close();
    });

    document.getElementById('saveDraftBtn')?.addEventListener('click', () => {
        saveDraftData();
        formIsDirty = false;
        leaveModal.close();

        if (typeof pendingNavigation === "function") {
            const action = pendingNavigation;
            pendingNavigation = null;
            action();
        }
    });

    document.getElementById('discardDraftBtn')?.addEventListener('click', () => {
        clearDraft();
        formIsDirty = false;
        leaveModal.close();

        if (typeof pendingNavigation === "function") {
            const action = pendingNavigation;
            pendingNavigation = null;
            action();
        }
    });

    document.querySelectorAll('a[href]').forEach(link => {
        link.addEventListener("click", e => {
            const href = link.getAttribute("href") || "";

            if (link.hasAttribute("data-legal-link")) {
                return;
            }

            if (
                href.startsWith("#") ||
                href.startsWith("javascript:") ||
                link.type === "submit"
            ) {
                return;
            }

            if (formIsDirty && !formSubmitting) {
                e.preventDefault();

                openLeaveModal(() => {
                    window.location.href = link.href;
                });
            }
        });
    });

    const clearSlotSelectionBtn = document.getElementById("clearSlotSelectionBtn");

    function clearTimeSelectionOnly() {
        const timeInput =
            document.getElementById("appointment_time");

        const selectedSlotDisplay =
            document.getElementById("selectedSlotDisplay");

        const selectedSlotText =
            document.getElementById("selectedSlotText");

        if (timeInput) {
            timeInput.value = "";

            timeInput.dispatchEvent(
                new Event("change", {
                    bubbles: true
                })
            );
        }

        if (selectedSlotText) {
            selectedSlotText.textContent = "";
        }

        selectedSlotDisplay?.classList.add("hidden");

        clearSlotSelectionBtn?.classList.add("hidden");
        clearSlotSelectionBtn?.setAttribute(
            "aria-hidden",
            "true"
        );

        document
            .querySelectorAll("#slotGrid .slot-chip")
            .forEach(chip => {
                chip.classList.remove(
                    "selected",
                    "bg-[#8B0000]",
                    "text-white",
                    "border-[#8B0000]"
                );

                chip.classList.add(
                    "border-[#e8e2dd]",
                    "bg-[#fafaf8]",
                    "text-[#1a1410]"
                );

                chip.setAttribute(
                    "aria-pressed",
                    "false"
                );
            });

        markFormDirty();
    }

    function clearDateAndTimeSelection() {
        const dateInput = document.getElementById("appointment_date");
        const dateBanner = document.getElementById("dateBanner");
        const slotContainer = document.getElementById("slotContainer");
        const slotPlaceholder = document.getElementById("slotPlaceholder");
        const slotGrid = document.getElementById("slotGrid");
        const timePanel = document.querySelector(".time-panel");

        if (dateInput) dateInput.value = "";

        clearTimeSelectionOnly();

        if (slotGrid) slotGrid.innerHTML = "";

        dateBanner?.classList.add("hidden");

        slotContainer?.classList.add("hidden");
        slotContainer?.classList.remove("slot-fade-in", "slot-fade-out");

        slotPlaceholder?.classList.remove("hidden", "slot-fade-in", "slot-fade-out");
        slotPlaceholder?.style.removeProperty("display");
        slotPlaceholder?.style.removeProperty("transform");
        slotPlaceholder?.style.removeProperty("opacity");

        timePanel?.classList.add("is-empty");
    }

    clearSlotSelectionBtn?.addEventListener("click", clearTimeSelectionOnly);

    document.getElementById("appointment_date")?.addEventListener("change", function () {
        const slotPlaceholder = document.getElementById("slotPlaceholder");
        const slotContainer = document.getElementById("slotContainer");
        const timePanel = document.querySelector(".time-panel");

        if (!this.value) {
            clearDateAndTimeSelection();
            slotPlaceholder?.classList.remove("hidden");
            slotContainer?.classList.add("hidden");
            timePanel?.classList.add("is-empty");
        } else {
            slotPlaceholder?.classList.add("hidden");
            slotContainer?.classList.remove("hidden");
            timePanel?.classList.remove("is-empty");
            animateSlotsIn();
        }
    });

    const slotContainer = document.getElementById("slotContainer");
    const slotPlaceholder = document.getElementById("slotPlaceholder");
    const timePanel = document.querySelector(".time-panel");

    let slotAnimationLock = false;

    function animateSlotsIn() {
        if (!slotContainer || slotAnimationLock) return;

        slotAnimationLock = true;

        timePanel?.classList.remove("is-empty");

        slotPlaceholder?.classList.add("hidden");
        slotPlaceholder?.style.setProperty("display", "none", "important");

        slotContainer.classList.remove("hidden", "slot-fade-out");
        slotContainer.classList.add("slot-fade-in");

        setTimeout(() => {
            slotContainer.classList.remove("slot-fade-in");
            slotAnimationLock = false;
        }, 320);
    }

    function initIntroBookingModal() {
        const modal = document.getElementById("introBookingModal");
        const startBtn = document.getElementById("introStartBtn");
        const continueDraftBtn = document.getElementById("introContinueDraftBtn");

        if (!modal) return;

        const hasDraft = hasSavedDraft();

        if (hasDraft) {
            continueDraftBtn?.classList.remove("hidden");
        } else {
            continueDraftBtn?.classList.add("hidden");
        }

        function lockPageScroll() {
            const scrollY = window.scrollY || window.pageYOffset || 0;
            document.body.dataset.lockedScrollY = String(scrollY);
            document.body.style.top = `-${scrollY}px`;
            document.documentElement.classList.add("intro-modal-open");
            document.body.classList.add("intro-modal-open");
        }

        function unlockPageScroll() {
            const scrollY = parseInt(document.body.dataset.lockedScrollY || "0", 10);
            document.documentElement.classList.remove("intro-modal-open");
            document.body.classList.remove("intro-modal-open");
            document.body.style.top = "";
            delete document.body.dataset.lockedScrollY;
            window.scrollTo(0, Number.isNaN(scrollY) ? 0 : scrollY);
        }

        modal.addEventListener("close", unlockPageScroll);

        startBtn?.addEventListener("click", () => {
            modal.close();
        });

        continueDraftBtn?.addEventListener("click", async () => {
            modal.close();
            await restoreDraft();
            showMiniTab("Saved draft loaded.");
        });

        setTimeout(() => {
            if (!modal.open) {
                lockPageScroll();
                modal.showModal();
            }
        }, 350);
    }

    showStep(0);
    initIntroBookingModal();

    window.addEventListener("resize", () => {
        document.querySelectorAll(".sm-grid-1col").forEach(el => {
            el.style.gridTemplateColumns = window.innerWidth < 640 ? "1fr" : "1fr 1fr";
        });
    });

    setupCharLimit("additional_concerns", "concernCount", 150, "concernWarning");
    setupCharLimit(
        "good_health_details", "goodHealthCount", 150);
    setupCharLimit("treatment_details", "treatmentCount",
        150);
    setupCharLimit("hospital_details", "hospitalCount", 150);
    setupCharLimit("medication_details",
        "medicationCount", 150);

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".question-text").forEach(q => {
            const row = q.closest("div");
            const hasRequiredRadio = row?.querySelector("input[required]");

            if (hasRequiredRadio && !q.querySelector(".required-star")) {
                const star = document.createElement("span");
                star.className = "required-star";
                star.textContent = " *";
                q.appendChild(star);
            }
        });

        document.querySelectorAll("input[required], select[required], textarea[required]").forEach(input => {
            if (input.tagName === "INPUT" && input.type === "hidden") return;

            let label = null;

            if (input.id) {
                label = document.querySelector(`label[for="${input.id}"]`);
            }

            if (!label) {
                label = input.closest("label");
            }

            if (!label) {
                const fieldContainer = input.closest(
                    ".space-y-4 > div, .grid > div, .ml-6, .mt-3, .mt-2, .date-input-wrap, .voice-input-wrap"
                );
                label = fieldContainer?.parentElement?.querySelector(":scope > label") || null;
            }

            if (!label) {
                const previous = input.previousElementSibling;
                if (previous && previous.tagName === "LABEL") {
                    label = previous;
                }
            }

            if (label && !label.querySelector(".required-star")) {
                const star = document.createElement("span");
                star.className = "required-star";
                star.textContent = " *";
                label.appendChild(star);
            }


        });
    });
</script>
@endsection
