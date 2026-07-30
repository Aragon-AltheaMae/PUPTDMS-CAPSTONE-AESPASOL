@extends('layouts.app')

@section('layout-role', 'dentist')

@section('title', 'Add Existing Appointment')

@vite('resources/css/pages/dentist/historical-appointment-intake.css')

@php
$defaults = $defaults ?? [];
$dentalAnswers = $defaults['dental_answers'] ?? [];
$medicalAnswers = $defaults['medical_answers'] ?? [];
$selectedDiseases = collect($defaults['diseases'] ?? []);
$isFemalePatient = strtolower($patient->gender ?? '') === 'female';
@endphp

@section('content')
<main id="mainContent" class="book-container page-enter">
    <div id="dentistBookAppointmentPage" class="book-page-wrap historical-book-page">
        <div class="w-full pt-14 pb-2 animate-fade-up historical-hero-wrap">
            <div class="flex items-center justify-between mb-4 booking-topbar">
                <a href="{{ route('dentist.dentist.patient.profile', ['patient' => $patient->id]) }}"
                    class="back-home-btn historical-back-btn flex items-center gap-2 bg-[#8B0000] hover:bg-[#660000] text-white px-4 py-2 rounded-xl text-xs font-bold border border-[#660000] transition shadow-sm">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Back to Patient Profile
                </a>
                <span
                    class="step-counter-pill text-xs text-[#9e9690] font-semibold bg-white border border-[#e8e2dd] px-3 py-1.5 rounded-full shadow-sm">
                    Step <span id="stepCounterText">1</span> <span class="text-[#c4bfba]">of 4</span>
                </span>
            </div>

            <div class="w-full h-2 rounded-full bg-[#e8e2dd] overflow-hidden mb-5">
                <div id="headerProgressFill" class="h-full rounded-full progress-fill historical-progress-fill"></div>
            </div>

            <div class="text-center mb-1">
                <p class="text-xs font-semibold uppercase tracking-widest mb-1 text-[#8B0000]">
                    <i class="fa-regular fa-calendar-check mr-1"></i> PUP TAGUIG DENTAL CLINIC
                </p>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-[#660000]">Add Existing Appointment</h1>
                <p class="text-sm text-[#9e9690] mt-1">Complete the booking details first, then continue to the odontogram on the next page.</p>
            </div>
        </div>

        <div class="w-full pb-16">
            <div class="w-full mt-4 mb-0 animate-fade-up-1 py-3 px-2 stepper-wrap-overflow booking-stepper">
                <div class="flex items-start justify-between w-full stepper-row-padding">
                    @php
                        $steps = [
                            ['number' => 1, 'label' => 'Date & Time'],
                            ['number' => 2, 'label' => 'Dental History'],
                            ['number' => 3, 'label' => 'Medical History'],
                            ['number' => 4, 'label' => 'Review'],
                        ];
                    @endphp
                    @foreach ($steps as $step)
                        <div class="flex flex-col items-center gap-1 min-w-0 flex-1">
                            <div id="sc{{ $step['number'] }}"
                                class="step-circle w-10 h-10 rounded-full border-2 border-[#e8e2dd] bg-white flex items-center justify-center text-sm font-bold text-[#9e9690]">
                                {{ $step['number'] }}
                            </div>
                            <span id="sl{{ $step['number'] }}"
                                class="step-label text-[0.65rem] font-semibold uppercase tracking-wide text-[#9e9690] text-center hidden sm:block mt-4">
                                {{ $step['label'] }}
                            </span>
                        </div>
                        @if (!$loop->last)
                            <div id="conn{{ $step['number'] }}"
                                class="h-0.5 bg-[#e8e2dd] flex-shrink-0 self-start step-connector step-connector-size"></div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div
                class="book-card mt-6 w-full mx-auto bg-white rounded-2xl shadow-[0_4px_40px_rgba(0,0,0,0.08),0_1px_4px_rgba(0,0,0,0.04)] overflow-hidden animate-fade-up-2">
                <div class="h-1 w-full book-card-topline"></div>
                <div class="p-6 sm:p-8">
                    <form id="historicalAppointmentForm" method="POST"
                        action="{{ route('dentist.odontogram.historical.intake.store', ['patient' => $patient->id]) }}">
                        @csrf

                        <div class="step-content hidden">
                            <div class="booking-step-shell">
                                <div class="booking-step-header">
                                    <p class="booking-step-eyebrow">Step 1 of 4</p>
                                    <h2 class="booking-step-title">Select Date, Time & Service</h2>
                                    <p class="booking-step-subtitle">
                                        Enter the original appointment details for this already completed visit.
                                    </p>
                                </div>

                                <div class="booking-step-body">
                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-regular fa-calendar-days text-xs"></i> Appointment Details
                                            <span class="section-card-title-line"></span>
                                        </p>

                                        <input type="hidden" id="appointment_date" name="appointment_date" value="{{ old('appointment_date', $defaults['appointment_date'] ?? '') }}" required>
                                        <input type="hidden" id="appointment_time" name="appointment_time" value="{{ old('appointment_time', $defaults['appointment_time'] ?? '') }}" required>

                                        <div class="cal-time-layout grid gap-5 lg:gap-6 mx-auto w-full historical-cal-time-layout">
                                            <div class="calendar-shell-no-card">
                                                <div id="calendarSkeletonContainer"></div>
                                            </div>

                                            <div class="time-panel flex flex-col is-empty">
                                                <div class="mb-5">
                                                    <p class="text-[0.78rem] font-extrabold text-[#8B0000] uppercase tracking-[0.24em]">
                                                        Pick a Time Slot
                                                    </p>
                                                    <p class="text-sm text-[#8c817a] mt-1 leading-6">
                                                        Choose the original appointment time for the selected date.
                                                    </p>
                                                </div>

                                                <div id="dateBanner"
                                                    class="hidden rounded-xl px-3 py-2 text-sm font-semibold text-white mb-3 shadow-md date-banner-gradient">
                                                </div>

                                                <div class="historical-time-select-wrap mb-4">
                                                    <label for="historical_time_input"
                                                        class="block text-xs font-semibold text-[#333] mb-1.5">
                                                        Select Time
                                                    </label>
                                                    <input type="time" id="historical_time_input"
                                                        class="historical-time-select w-full rounded-xl border border-[#e8e2dd] bg-white px-3 py-2.5 text-sm text-[#2f2f2f] outline-none"
                                                        disabled>
                                                    <p id="historicalTimeHint"
                                                        class="mt-2 text-xs text-[#9e9690] leading-5">
                                                        Select a date first, then enter or choose the original appointment time.
                                                    </p>
                                                </div>

                                                <div id="slotContainer" class="hidden">
                                                    <div id="slotGrid" class="slot-grid-ui grid grid-cols-2 gap-4"></div>

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

                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">
                                            <div class="sm:col-span-2">
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5" for="service_type">Service Type</label>
                                                <div class="service-step-grid historical-service-grid">
                                                    @foreach ($serviceTypes as $service)
                                                    <label class="service-option group">
                                                        <input type="radio" name="service_type" value="{{ $service->name }}"
                                                            class="service-option-input"
                                                            @checked(old('service_type', $defaults['service_type'] ?? '') === $service->name) required>

                                                        <div class="service-option-card">
                                                            <div class="service-option-main">
                                                                <div class="service-option-icon">
                                                                    <i class="fa-solid fa-tooth"></i>
                                                                </div>

                                                                <div class="service-option-copy">
                                                                    <div class="service-option-topline">
                                                                        <p class="service-option-title">{{ $service->name }}</p>
                                                                        <span class="service-option-badge">Available</span>
                                                                    </div>
                                                                    <p class="service-option-desc">{{ $service->description ?: 'No description available.' }}</p>
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

                                            <div class="sm:col-span-2">
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5" for="procedure_duration_hms">Procedure Duration</label>
                                                <input type="text" id="procedure_duration_hms" name="procedure_duration_hms"
                                                    value="{{ old('procedure_duration_hms', $defaults['procedure_duration_hms'] ?? '') }}"
                                                    placeholder="HH:MM:SS"
                                                    class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none" required>
                                                <p class="historical-field-help">Example: `01:15:00` for 1 hour and 15 minutes.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="step-content hidden">
                            <div class="booking-step-shell">
                                <div class="booking-step-header">
                                    <p class="booking-step-eyebrow">Step 2 of 4</p>
                                    <h2 class="booking-step-title">Dental History</h2>
                                    <p class="booking-step-subtitle">
                                        Share the patient's past dental records, treatments, and dental concerns for a better
                                        assessment.
                                    </p>
                                </div>

                                <div class="booking-step-body">
                                    @php
                                        $dentalQuestionMap = collect($dentalQuestions)->keyBy('code');
                                        $dentalSymptomCodes = ['bleeding_gums', 'sensitive_temp', 'sensitive_taste', 'tooth_pain', 'sores', 'injuries'];
                                        $jawBiteCodes = ['clicking', 'joint_pain', 'difficulty_moving', 'difficulty_chewing', 'jaw_headaches', 'clench_grind', 'biting', 'teeth_loosening', 'food_teeth', 'med_reaction'];
                                        $dentalProcedureCodes = ['periodontal', 'difficult_extraction', 'prolonged_bleeding', 'dentures', 'ortho_treatment'];
                                    @endphp
                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-regular fa-calendar-days text-xs"></i> Basic Info
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5" for="last_dental_visit">Last Dental Visit</label>
                                                <input type="date" id="last_dental_visit" name="last_dental_visit"
                                                    max="{{ now()->toDateString() }}"
                                                    value="{{ old('last_dental_visit', $defaults['last_dental_visit'] ?? '') }}"
                                                    class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5" for="previous_dentist">Previous Dentist</label>
                                                <input type="text" id="previous_dentist" name="previous_dentist"
                                                    maxlength="50"
                                                    value="{{ old('previous_dentist', $defaults['previous_dentist'] ?? '') }}"
                                                    class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                            <i class="fa-solid fa-tooth text-xs"></i> Dental Symptoms
                                            <span class="flex-1 h-px bg-[#f9e8e8]"></span>
                                        </p>
                                        <div class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Question</span><span class="text-center">YES</span><span class="text-center">NO</span>
                                        </div>
                                        @foreach ($dentalSymptomCodes as $index => $code)
                                            @php
                                                $question = $dentalQuestionMap->get($code);
                                                $current = old("dental_answers.$code", $dentalAnswers[$code] ?? '');
                                            @endphp
                                            @if ($question)
                                            <div class="history-question-grid {{ $index < count($dentalSymptomCodes) - 1 ? 'border-b border-[#f0ebe6]' : '' }}">
                                                <span class="question-text">{{ $question['label'] }}</span>
                                                <input type="radio" name="dental_answers[{{ $code }}]" value="YES" @checked($current === 'YES') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer" required>
                                                <input type="radio" name="dental_answers[{{ $code }}]" value="NO" @checked($current === 'NO') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="section-card">
                                        <p class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                            <i class="fa-solid fa-circle-dot text-xs"></i> Jaw &amp; Bite Symptoms
                                            <span class="flex-1 h-px bg-[#f9e8e8]"></span>
                                        </p>
                                        <div class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Question</span><span class="text-center">YES</span><span class="text-center">NO</span>
                                        </div>
                                        @foreach ($jawBiteCodes as $index => $code)
                                            @php
                                                $question = $dentalQuestionMap->get($code);
                                                $current = old("dental_answers.$code", $dentalAnswers[$code] ?? '');
                                            @endphp
                                            @if ($question)
                                            <div class="history-question-grid {{ $index < count($jawBiteCodes) - 1 ? 'border-b border-[#f0ebe6]' : '' }}">
                                                <span class="question-text">{{ $question['label'] }}</span>
                                                <input type="radio" name="dental_answers[{{ $code }}]" value="YES" @checked($current === 'YES') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer" required>
                                                <input type="radio" name="dental_answers[{{ $code }}]" value="NO" @checked($current === 'NO') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                            </div>
                                            @endif
                                            @endforeach
                                        <p class="text-xs text-[#8B0000] mt-2 italic pl-4">
                                            <i class="fa-solid fa-circle-info mr-1"></i> If <b>YES</b>, please provide details during your consultation.
                                        </p>
                                    </div>

                                    <div class="section-card">
                                        <p class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                            <i class="fa-solid fa-notes-medical text-xs"></i> Dental Procedures
                                            <span class="flex-1 h-px bg-[#f9e8e8]"></span>
                                        </p>
                                        <div class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Question</span><span class="text-center">YES</span><span class="text-center">NO</span>
                                        </div>
                                        @foreach ($dentalProcedureCodes as $index => $code)
                                            @php
                                                $question = $dentalQuestionMap->get($code);
                                                $current = old("dental_answers.$code", $dentalAnswers[$code] ?? '');
                                            @endphp
                                            @if ($question)
                                            <div class="history-question-grid {{ $index < count($dentalProcedureCodes) - 1 ? 'border-b border-[#f0ebe6]' : '' }}">
                                                <span class="question-text">{{ $question['label'] }}</span>
                                                <input type="radio" name="dental_answers[{{ $code }}]" value="YES" @checked($current === 'YES') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer" required>
                                                <input type="radio" name="dental_answers[{{ $code }}]" value="NO" @checked($current === 'NO') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                            </div>
                                            @endif
                                        @endforeach

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5" for="extraction_date">Extraction Date</label>
                                                <input type="date" id="extraction_date" name="extraction_date"
                                                    max="{{ now()->toDateString() }}"
                                                    value="{{ old('extraction_date', $defaults['extraction_date'] ?? '') }}"
                                                    class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5" for="dentures_date">Dentures Date</label>
                                                <input type="date" id="dentures_date" name="dentures_date"
                                                    max="{{ now()->toDateString() }}"
                                                    value="{{ old('dentures_date', $defaults['dentures_date'] ?? '') }}"
                                                    class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none">
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5" for="ortho_date">Orthodontic Treatment Date</label>
                                                <input type="date" id="ortho_date" name="ortho_date"
                                                    max="{{ now()->toDateString() }}"
                                                    value="{{ old('ortho_date', $defaults['ortho_date'] ?? '') }}"
                                                    class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                            <i class="fa-regular fa-comment-dots text-xs"></i> Additional Concerns
                                            <span class="flex-1 h-px bg-[#f9e8e8]"></span>
                                        </p>
                                        <div class="grid grid-cols-1 gap-4">
                                            <div class="sm:col-span-2">
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5" for="additional_concerns">Additional Dental Concerns</label>
                                                <textarea id="additional_concerns" name="additional_concerns" rows="4"
                                                    class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none">{{ old('additional_concerns', $defaults['additional_concerns'] ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="step-content hidden">
                            <div class="booking-step-shell">
                                <div class="booking-step-header">
                                    <p class="booking-step-eyebrow">Step 3 of 4</p>
                                    <h2 class="booking-step-title">Medical History</h2>
                                    <p class="booking-step-subtitle">
                                        Encode the same emergency and medical information used in standard appointment
                                        booking.
                                    </p>
                                </div>

                                <div class="booking-step-body">
                                    @php
                                        $medicalQuestionMap = collect($medicalQuestions)->keyBy('code');
                                        $medicalValue = function ($code, $fallback = '') use ($medicalAnswers) {
                                            return old("medical_answers.$code", $medicalAnswers[$code] ?? $fallback);
                                        };
                                    @endphp
                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-heart-pulse text-xs"></i> General Health
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Question</span><span class="text-center">YES</span><span class="text-center">NO</span>
                                        </div>
                                        <div class="history-question-grid border-b border-[#f0ebe6]">
                                            <span class="question-text">{{ $medicalQuestionMap->get('good_health')['label'] ?? 'Are you in good health?' }}</span>
                                            <input type="radio" name="medical_answers[good_health]" value="YES" @checked($medicalValue('good_health') === 'YES') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer" required>
                                            <input type="radio" name="medical_answers[good_health]" value="NO" @checked($medicalValue('good_health') === 'NO') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="ml-6 mt-1 mb-2 {{ $medicalValue('good_health') === 'NO' ? '' : 'hidden' }}" id="good_health_box">
                                            <label class="text-xs text-[#8B0000] italic block mb-1">{{ $medicalQuestionMap->get('good_health_details')['label'] ?? 'If NO, please specify:' }}</label>
                                            <input type="text" name="medical_answers[good_health_details]" maxlength="150"
                                                id="good_health_details"
                                                value="{{ $medicalValue('good_health_details') }}"
                                                class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                                placeholder="Input here">
                                            <div class="text-right text-xs"><span id="goodHealthCount">{{ strlen($medicalValue('good_health_details')) }}/150</span></div>
                                        </div>

                                        <div class="history-question-grid border-b border-[#f0ebe6]">
                                            <span class="question-text">{{ $medicalQuestionMap->get('had_medical_exam')['label'] ?? 'Have you had or are you having medical treatment now?' }}</span>
                                            <input type="radio" name="medical_answers[had_medical_exam]" value="YES" @checked($medicalValue('had_medical_exam') === 'YES') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer" required>
                                            <input type="radio" name="medical_answers[had_medical_exam]" value="NO" @checked($medicalValue('had_medical_exam') === 'NO') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="ml-6 mt-1 mb-2 {{ $medicalValue('had_medical_exam') === 'YES' ? '' : 'hidden' }}" id="medical_exam_box">
                                            <label class="text-xs text-[#8B0000] italic block mb-1">{{ $medicalQuestionMap->get('medical_exam_date')['label'] ?? 'If YES, when was your last medical examination?' }}</label>
                                            <input type="date" id="medicalExamDate" name="medical_answers[medical_exam_date]"
                                                max="{{ now()->toDateString() }}"
                                                value="{{ $medicalValue('medical_exam_date') }}"
                                                class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none">
                                        </div>

                                        <div class="history-question-grid border-b border-[#f0ebe6]">
                                            <span class="question-text">{{ $medicalQuestionMap->get('under_treatment')['label'] ?? 'Are you currently receiving treatment for any illness?' }}</span>
                                            <input type="radio" name="medical_answers[under_treatment]" value="YES" @checked($medicalValue('under_treatment') === 'YES') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer" required>
                                            <input type="radio" name="medical_answers[under_treatment]" value="NO" @checked($medicalValue('under_treatment') === 'NO') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="ml-6 mt-1 mb-2 {{ $medicalValue('under_treatment') === 'YES' ? '' : 'hidden' }}" id="treatment_box">
                                            <label class="text-xs text-[#8B0000] italic">{{ $medicalQuestionMap->get('treatment_details')['label'] ?? 'If YES, please specify:' }}</label>
                                            <input type="text" name="medical_answers[treatment_details]" maxlength="150"
                                                id="treatment_details"
                                                value="{{ $medicalValue('treatment_details') }}"
                                                class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                                placeholder="Input here">
                                            <div class="text-right text-xs"><span id="treatmentCount">{{ strlen($medicalValue('treatment_details')) }}/150</span></div>
                                        </div>

                                        <div class="history-question-grid">
                                            <span class="question-text">{{ $medicalQuestionMap->get('hospitalized')['label'] ?? 'Have you ever been hospitalized?' }}</span>
                                            <input type="radio" name="medical_answers[hospitalized]" value="YES" @checked($medicalValue('hospitalized') === 'YES') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer" required>
                                            <input type="radio" name="medical_answers[hospitalized]" value="NO" @checked($medicalValue('hospitalized') === 'NO') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="ml-6 mt-1 mb-2 {{ $medicalValue('hospitalized') === 'YES' ? '' : 'hidden' }}" id="hospital_box">
                                            <label class="text-xs text-[#8B0000] italic">{{ $medicalQuestionMap->get('hospital_details')['label'] ?? 'If YES, please provide details:' }}</label>
                                            <input type="text" name="medical_answers[hospital_details]" maxlength="150"
                                                id="hospital_details"
                                                value="{{ $medicalValue('hospital_details') }}"
                                                class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                                placeholder="Input here">
                                            <div class="text-right text-xs"><span id="hospitalCount">{{ strlen($medicalValue('hospital_details')) }}/150</span></div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-triangle-exclamation text-xs"></i> Allergies
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Are you allergic to any of the following?</span><span class="text-center">YES</span><span class="text-center">NO</span>
                                        </div>
                                        <div class="history-question-grid border-b border-[#f0ebe6]">
                                            <span class="question-text">Medicines</span>
                                            <input type="radio" name="medical_answers[allergy_medicine]" value="YES" @checked($medicalValue('allergy_medicine') === 'YES') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer" required>
                                            <input type="radio" name="medical_answers[allergy_medicine]" value="NO" @checked($medicalValue('allergy_medicine') === 'NO') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="history-question-grid">
                                            <span class="question-text">Food</span>
                                            <input type="radio" name="medical_answers[allergy_food]" value="YES" @checked($medicalValue('allergy_food') === 'YES') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer" required>
                                            <input type="radio" name="medical_answers[allergy_food]" value="NO" @checked($medicalValue('allergy_food') === 'NO') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="mt-3">
                                            <label class="text-xs text-[#8B0000] italic block mb-1">{{ $medicalQuestionMap->get('allergy_others')['label'] ?? 'Others (please specify):' }}</label>
                                            <input type="text" name="medical_answers[allergy_others]"
                                                value="{{ $medicalValue('allergy_others') }}"
                                                class="form-input voice-medium border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full"
                                                placeholder="Input here">
                                        </div>
                                    </div>

                                    @if ($isFemalePatient)
                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-pills text-xs"></i> Medications
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Question</span><span class="text-center">YES</span><span class="text-center">NO</span>
                                        </div>
                                        <div class="history-question-grid">
                                            <span class="question-text">{{ $medicalQuestionMap->get('medication')['label'] ?? 'Are you taking any prescription or non-prescription medication?' }}</span>
                                            <input type="radio" name="medical_answers[medication]" value="YES" @checked($medicalValue('medication') === 'YES') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer" required>
                                            <input type="radio" name="medical_answers[medication]" value="NO" @checked($medicalValue('medication') === 'NO') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="ml-6 mt-1 mb-2 {{ $medicalValue('medication') === 'YES' ? '' : 'hidden' }}" id="medication_box">
                                            <label class="text-xs text-[#8B0000] italic">{{ $medicalQuestionMap->get('medication_details')['label'] ?? 'If YES, please specify:' }}</label>
                                            <input type="text" name="medical_answers[medication_details]" maxlength="150"
                                                id="medication_details"
                                                value="{{ $medicalValue('medication_details') }}"
                                                class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                                placeholder="Input here">
                                            <div class="text-right text-xs"><span id="medicationCount">{{ strlen($medicalValue('medication_details')) }}/150</span></div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-venus text-xs"></i> For Women Only
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Question</span><span class="text-center">YES</span><span class="text-center">NO</span>
                                        </div>
                                        @foreach ([
                                            ['name' => 'pregnant', 'label' => 'Are you pregnant?'],
                                            ['name' => 'nursing', 'label' => 'Are you nursing?'],
                                            ['name' => 'birth_control', 'label' => 'Are you taking birth control pills?'],
                                        ] as $index => $item)
                                        <div class="history-question-grid {{ $index < 2 ? 'border-b border-[#f0ebe6]' : '' }}">
                                            <span class="question-text">{{ $item['label'] }}</span>
                                            <input type="radio" name="medical_answers[{{ $item['name'] }}]" value="YES" @checked($medicalValue($item['name']) === 'YES') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer" required>
                                            <input type="radio" name="medical_answers[{{ $item['name'] }}]" value="NO" @checked($medicalValue($item['name']) === 'NO') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-pills text-xs"></i> Medications
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Question</span><span class="text-center">YES</span><span class="text-center">NO</span>
                                        </div>
                                        <div class="history-question-grid">
                                            <span class="question-text">{{ $medicalQuestionMap->get('medication')['label'] ?? 'Are you taking any prescription or non-prescription medication?' }}</span>
                                            <input type="radio" name="medical_answers[medication]" value="YES" @checked($medicalValue('medication') === 'YES') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer" required>
                                            <input type="radio" name="medical_answers[medication]" value="NO" @checked($medicalValue('medication') === 'NO') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div class="ml-6 mt-1 mb-2 {{ $medicalValue('medication') === 'YES' ? '' : 'hidden' }}" id="medication_box">
                                            <label class="text-xs text-[#8B0000] italic">{{ $medicalQuestionMap->get('medication_details')['label'] ?? 'If YES, please specify:' }}</label>
                                            <input type="text" name="medical_answers[medication_details]" maxlength="150"
                                                id="medication_details"
                                                value="{{ $medicalValue('medication_details') }}"
                                                class="form-input mt-1 w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none"
                                                placeholder="Input here">
                                            <div class="text-right text-xs"><span id="medicationCount">{{ strlen($medicalValue('medication_details')) }}/150</span></div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="medical_answers[pregnant]" value="NO">
                                    <input type="hidden" name="medical_answers[nursing]" value="NO">
                                    <input type="hidden" name="medical_answers[birth_control]" value="NO">
                                    @endif

                                    <div class="section-card mt-5">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-notes-medical text-xs"></i> Known Diseases / Conditions
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <p class="text-xs text-[#5c5550] mb-3">Please indicate below if you presently have or have ever had any of the following:</p>
                                        <div class="medical-condition-grid grid grid-cols-1 sm:grid-cols-2 gap-y-2.5 gap-x-6">
                                            @foreach ($diseases as $disease)
                                            @php $checked = collect(old('diseases', $selectedDiseases->all()))->contains($disease->code); @endphp
                                            <label class="flex items-center gap-2.5 cursor-pointer">
                                                <input type="checkbox" name="diseases[]" value="{{ $disease->code }}" @checked($checked)
                                                    class="w-4 h-4 rounded border-2 border-[#e8e2dd] cursor-pointer accent-[#8B0000] flex-shrink-0">
                                                <span class="text-[0.82rem] text-[#1a1410]">{{ $disease->label ?? $disease->name ?? $disease->code }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-smoking text-xs"></i> Tobacco Use
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Question</span><span class="text-center">YES</span><span class="text-center">NO</span>
                                        </div>
                                        <div class="history-question-grid">
                                            <span class="question-text">{{ $medicalQuestionMap->get('tobacco_use')['label'] ?? 'Do you use tobacco products or any derivatives?' }}</span>
                                            <input type="radio" name="medical_answers[tobacco_use]" value="YES" @checked($medicalValue('tobacco_use') === 'YES') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer" required>
                                            <input type="radio" name="medical_answers[tobacco_use]" value="NO" @checked($medicalValue('tobacco_use') === 'NO') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
                                        </div>
                                        <div id="tobacco_details" class="ml-6 mt-2 space-y-2 {{ $medicalValue('tobacco_use') === 'YES' ? '' : 'hidden' }} text-sm">
                                            <div class="flex items-center gap-3 flex-wrap">
                                                <span class="text-xs text-[#8B0000] italic w-28">How much per day:</span>
                                                <input type="text" name="medical_answers[tobacco_per_day]" placeholder="Input here"
                                                    value="{{ $medicalValue('tobacco_per_day') }}"
                                                    class="form-input voice-small border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full">
                                            </div>
                                            <div class="flex items-center gap-3 flex-wrap">
                                                <span class="text-xs text-[#8B0000] italic w-28">Per week:</span>
                                                <input type="text" name="medical_answers[tobacco_per_week]" placeholder="Input here"
                                                    value="{{ $medicalValue('tobacco_per_week') }}"
                                                    class="form-input voice-small border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none w-full">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-head-side-mask text-xs"></i> Do You Suffer From
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div class="grid grid-cols-[1fr_52px_52px] gap-2 text-[0.72rem] font-bold text-[#9e9690] uppercase tracking-widest pb-1">
                                            <span>Condition</span><span class="text-center">YES</span><span class="text-center">NO</span>
                                        </div>
                                        @foreach ([
                                            ['name' => 'headaches', 'label' => 'Headaches'],
                                            ['name' => 'earaches', 'label' => 'Earaches'],
                                            ['name' => 'neck_aches', 'label' => 'Neck aches'],
                                        ] as $index => $item)
                                        <div class="history-question-grid {{ $index < 2 ? 'border-b border-[#f0ebe6]' : '' }}">
                                            <span class="question-text">{{ $item['label'] }}</span>
                                            <input type="radio" name="medical_answers[{{ $item['name'] }}]" value="YES" @checked($medicalValue($item['name']) === 'YES') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer" required>
                                            <input type="radio" name="medical_answers[{{ $item['name'] }}]" value="NO" @checked($medicalValue($item['name']) === 'NO') class="q-radio appearance-none w-4 h-4 border-2 border-[#e8e2dd] rounded-full mx-auto cursor-pointer">
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
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5" for="emergency_person">Person to contact in case of emergency</label>
                                                <input type="text" id="emergency_person" name="emergency_person"
                                                    maxlength="50" pattern="[A-Za-zÑñ\s.'-]+"
                                                    title="Only letters, spaces, apostrophe, period, and hyphen are allowed."
                                                    value="{{ old('emergency_person', $defaults['emergency_person'] ?? '') }}"
                                                    class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none" required>
                                                <p id="emergency_person_feedback" class="historical-field-help">
                                                    Only letters, spaces, apostrophe, period, and hyphen are allowed.
                                                </p>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5" for="emergency_number">Contact Number</label>
                                                <input type="text" id="emergency_number" name="emergency_number"
                                                    inputmode="numeric" autocomplete="tel" maxlength="11" pattern="09[0-9]{9}"
                                                    value="{{ old('emergency_number', $defaults['emergency_number'] ?? '') }}"
                                                    class="form-input w-full border border-[#e8e2dd] rounded-xl px-3 py-2 text-sm bg-white outline-none" required>
                                                <p id="emergency_number_feedback" class="historical-field-help">
                                                    Format: 09XXXXXXXXX
                                                </p>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-[#333] mb-1.5">
                                                    Relation to Patient <span class="required-star">*</span>
                                                </label>
                                                <select name="emergency_relation" id="emergency_relation"
                                                    class="js-custom-select" data-placeholder="Select relation"
                                                    aria-label="Relation to patient" required>
                                                    <option value="" disabled {{ old('emergency_relation', $defaults['emergency_relation'] ?? '') === '' ? 'selected' : '' }}>Select relation</option>
                                                    @foreach (['Mother','Father','Sibling','Guardian','Spouse','Grandparent','Aunt','Uncle','Cousin','Child'] as $relation)
                                                        <option value="{{ $relation }}" @selected(old('emergency_relation', $defaults['emergency_relation'] ?? '') === $relation)>{{ $relation }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="step-content hidden">
                            <div class="booking-step-shell">
                                <div class="booking-step-header">
                                    <p class="booking-step-eyebrow">Step 4 of 4</p>
                                    <h2 class="booking-step-title">Review Before Odontogram</h2>
                                    <p class="booking-step-subtitle">
                                        Confirm the imported appointment details before continuing to the odontogram.
                                    </p>
                                </div>

                                <div class="booking-step-body">
                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-circle-check text-xs"></i> Summary
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div id="historicalReviewGrid" class="space-y-4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="historical-nav-actions">
                            <button type="button" id="prevStepBtn"
                                class="btn-secondary-custom inline-flex items-center justify-center gap-2 border border-[#e8e2dd] rounded-2xl px-6 py-3 text-sm font-semibold text-[#5c5550] bg-white shadow-sm transition-all duration-300">
                                <i class="fa-solid fa-chevron-left text-xs"></i> Previous
                            </button>

                            <div class="flex items-center gap-3">
                                <button type="button" id="nextStepBtn"
                                    class="btn-primary-custom inline-flex items-center justify-center gap-2 bg-[#8B0000] text-white rounded-2xl px-8 py-3 text-sm font-bold shadow-[0_10px_24px_rgba(139,0,0,0.18)] transition-all duration-300">
                                    Next <i class="fa-solid fa-chevron-right text-xs"></i>
                                </button>
                                <button type="submit" id="submitHistoricalBtn"
                                    class="hidden btn-primary-custom inline-flex items-center justify-center gap-2 bg-[#8B0000] text-white rounded-2xl px-8 py-3 text-sm font-bold shadow-[0_10px_24px_rgba(139,0,0,0.18)] transition-all duration-300">
                                    Continue to Odontogram <i class="fa-solid fa-chevron-right text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

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
'slotEndpoint' => route('dentist.odontogram.historical.slots'),
'scheduleRules' => $schedules ?? [],
'blockedDates' => $blockedDates ?? [],
'appointmentCountsPerDay' => $appointmentCountsPerDay ?? [],
'philippineHolidays' => $philippineHolidays ?? [],
'useDynamicScheduleRules' => true,
'disallowToday' => false,
'allowPastDates' => true,
'allowAllDates' => true,
'allowToggleOffDate' => true,
'historyMonths' => 180,
'maxFutureMonths' => 0,
'enableMonthYearShortcut' => true,
])
@endsection

@section('scripts')
  <script>
  document.addEventListener('DOMContentLoaded', function () {
      const panels = Array.from(document.querySelectorAll('.step-content'));
      const prevBtn = document.getElementById('prevStepBtn');
      const nextBtn = document.getElementById('nextStepBtn');
      const submitBtn = document.getElementById('submitHistoricalBtn');
      const counter = document.getElementById('stepCounterText');
      const reviewGrid = document.getElementById('historicalReviewGrid');
      const progressFill = document.getElementById('headerProgressFill');
      const timeField = document.getElementById('historical_time_input');
      const timeHint = document.getElementById('historicalTimeHint');
      const slotGridElement = document.getElementById('slotGrid');
      const timeInput = document.getElementById('appointment_time');
      const durationInput = document.getElementById('procedure_duration_hms');
      const emergencyPersonInput = document.getElementById('emergency_person');
      const emergencyPersonFeedback = document.getElementById('emergency_person_feedback');
      const emergencyNumberInput = document.getElementById('emergency_number');
      const emergencyNumberFeedback = document.getElementById('emergency_number_feedback');
      let currentStep = 0;
      const isFemalePatient = @json($isFemalePatient);

      function textValue(selector) {
          const el = document.querySelector(selector);
          return el ? (el.value || '').trim() : '';
      }

      function toTimeInputValue(value) {
          if (!value) return '';

          const raw = String(value).trim();
          if (/^\d{2}:\d{2}$/.test(raw)) return raw;
          if (/^\d{2}:\d{2}:\d{2}$/.test(raw)) return raw.slice(0, 5);

          const match = raw.match(/^(\d{1,2}):(\d{2})\s*(AM|PM)$/i);
          if (!match) return '';

          let hour = Number(match[1]);
          const minutes = match[2];
          const meridiem = match[3].toUpperCase();

          if (meridiem === 'PM' && hour !== 12) hour += 12;
          if (meridiem === 'AM' && hour === 12) hour = 0;

          return `${String(hour).padStart(2, '0')}:${minutes}`;
      }

      function toDisplayTime(value) {
          const timeValue = toTimeInputValue(value);
          if (!timeValue) return value || '';

          const [hourText, minuteText] = timeValue.split(':');
          let hour = Number(hourText);
          const suffix = hour >= 12 ? 'PM' : 'AM';
          hour = hour % 12 || 12;

          return `${hour}:${minuteText} ${suffix}`;
      }

      function formatDurationInput(value) {
          const digits = String(value || '').replace(/\D/g, '').slice(0, 6);
          const parts = [];

          if (digits.length > 0) parts.push(digits.slice(0, 2));
          if (digits.length > 2) parts.push(digits.slice(2, 4));
          if (digits.length > 4) parts.push(digits.slice(4, 6));

          return parts.join(':');
      }

      function setInlineFeedback(element, message, type = '') {
          if (!element) return;

          element.textContent = message;
          element.classList.remove('text-[#9e9690]', 'text-[#dc2626]', 'text-[#16a34a]');

          if (type === 'error') {
              element.classList.add('text-[#dc2626]');
          } else if (type === 'success') {
              element.classList.add('text-[#16a34a]');
          } else {
              element.classList.add('text-[#9e9690]');
          }
      }

      function validateEmergencyPerson(showNeutral = false) {
          if (!emergencyPersonInput) return true;

          const value = emergencyPersonInput.value.trim();
          const validNamePattern = /^[A-Za-zÑñ\s.'-]+$/;

          emergencyPersonInput.classList.remove('border-[#dc2626]', 'border-[#16a34a]');

          if (!value.length) {
              setInlineFeedback(
                  emergencyPersonFeedback,
                  showNeutral ? 'Only letters, spaces, apostrophe, period, and hyphen are allowed.' : '',
                  ''
              );
              return false;
          }

          if (!validNamePattern.test(value)) {
              emergencyPersonInput.classList.add('border-[#dc2626]');
              emergencyPersonInput.setCustomValidity('Emergency contact name must contain letters only.');
              setInlineFeedback(emergencyPersonFeedback, 'This name is invalid. Please use letters only.', 'error');
              return false;
          }

          emergencyPersonInput.classList.add('border-[#16a34a]');
          emergencyPersonInput.setCustomValidity('');
          setInlineFeedback(emergencyPersonFeedback, 'Valid emergency contact name.', 'success');
          return true;
      }

      function validateEmergencyNumber(showNeutral = false) {
          if (!emergencyNumberInput) return true;

          const value = emergencyNumberInput.value.trim();
          const validNumberPattern = /^09\d{9}$/;

          emergencyNumberInput.classList.remove('border-[#dc2626]', 'border-[#16a34a]');

          if (!value.length) {
              emergencyNumberInput.setCustomValidity('');
              setInlineFeedback(emergencyNumberFeedback, showNeutral ? 'Format: 09XXXXXXXXX' : '', '');
              return false;
          }

          if (!validNumberPattern.test(value)) {
              emergencyNumberInput.classList.add('border-[#dc2626]');
              emergencyNumberInput.setCustomValidity('Emergency contact number must start with 09 and contain exactly 11 digits.');
              setInlineFeedback(
                  emergencyNumberFeedback,
                  /\D/.test(value)
                      ? 'Letters are not allowed. Please enter numbers only.'
                      : (!value.startsWith('09')
                          ? 'Contact number must start with 09.'
                          : 'Contact number must be exactly 11 digits.'),
                  'error'
              );
              return false;
          }

          emergencyNumberInput.classList.add('border-[#16a34a]');
          emergencyNumberInput.setCustomValidity('');
          setInlineFeedback(emergencyNumberFeedback, 'Valid emergency contact number.', 'success');
          return true;
      }

      function setupCharLimit(inputId, counterId, maxLength) {
          const input = document.getElementById(inputId);
          const counter = document.getElementById(counterId);
          if (!input || !counter) return;

          const sync = () => {
              const value = input.value || '';
              if (value.length > maxLength) {
                  input.value = value.slice(0, maxLength);
              }
              counter.textContent = `${input.value.length}/${maxLength}`;
          };

          input.addEventListener('input', sync);
          sync();
      }

      function bindConditionalBox(radioName, boxId, showOn) {
          const radios = Array.from(document.querySelectorAll(`input[name="${radioName}"]`));
          const box = document.getElementById(boxId);
          if (!box || !radios.length) return;

          const sync = () => {
              const selected = radios.find((radio) => radio.checked);
              const inputs = Array.from(box.querySelectorAll('input'));

              if (selected?.value === showOn) {
                  box.classList.remove('hidden');
              } else {
                  box.classList.add('hidden');
                  inputs.forEach((input) => {
                      input.value = '';
                      input.required = false;
                  });
              }
          };

          radios.forEach((radio) => radio.addEventListener('change', sync));
          sync();
      }

      function bindMedicalExamBox() {
          const radios = Array.from(document.querySelectorAll('input[name="medical_answers[had_medical_exam]"]'));
          const box = document.getElementById('medical_exam_box');
          const input = document.getElementById('medicalExamDate');
          if (!box || !input || !radios.length) return;

          const sync = () => {
              const selected = radios.find((radio) => radio.checked);

              if (selected?.value === 'YES') {
                  box.classList.remove('hidden');
              } else {
                  box.classList.add('hidden');
                  input.value = '';
                  input.required = false;
              }
          };

          radios.forEach((radio) => radio.addEventListener('change', sync));
          sync();
      }

      function bindTobaccoDetails() {
          const radios = Array.from(document.querySelectorAll('input[name="medical_answers[tobacco_use]"]'));
          const box = document.getElementById('tobacco_details');
          if (!box || !radios.length) return;

          const sync = () => {
              const selected = radios.find((radio) => radio.checked);
              box.classList.toggle('hidden', selected?.value !== 'YES');
          };

          radios.forEach((radio) => radio.addEventListener('change', sync));
          sync();
      }

      function buildReview() {
        const form = document.getElementById('historicalAppointmentForm');
        const data = new FormData(form);
        const get = (n) => data.get(n) || 'N/A';
        const getAll = (n) => data.getAll(n);

        const diseases = Array.from(document.querySelectorAll('input[name="diseases[]"]:checked'))
            .map(el => el.nextElementSibling.textContent.trim())
            .join(', ') || 'None';

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

        const dentalHistoryBody = `
            ${subSection("Basic Info", `
                ${row("Last Dental Visit", get("last_dental_visit"))}
                ${row("Previous Dentist", get("previous_dentist"))}
            `)}

            ${subSection("Dental Symptoms", `
                ${row("Bleeding Gums", get("dental_answers[bleeding_gums]"))}
                ${row("Sensitive (Hot/Cold)", get("dental_answers[sensitive_temp]"))}
                ${row("Sensitive (Sweets/Sour)", get("dental_answers[sensitive_taste]"))}
                ${row("Tooth Pain", get("dental_answers[tooth_pain]"))}
                ${row("Sores/Lumps", get("dental_answers[sores]"))}
                ${row("Jaw Injuries", get("dental_answers[injuries]"))}
            `)}

            ${subSection("Jaw & Bite Symptoms", `
                ${row("Clicking", get("dental_answers[clicking]"))}
                ${row("Joint Pain", get("dental_answers[joint_pain]"))}
                ${row("Difficulty Moving", get("dental_answers[difficulty_moving]"))}
                ${row("Difficulty Chewing", get("dental_answers[difficulty_chewing]"))}
                ${row("Frequent Headaches", get("dental_answers[jaw_headaches]"))}
                ${row("Grinding/Clenching", get("dental_answers[clench_grind]"))}
                ${row("Lips/Cheek Biting", get("dental_answers[biting]"))}
                ${row("Teeth Loosening", get("dental_answers[teeth_loosening]"))}
                ${row("Food Caught Between Teeth", get("dental_answers[food_teeth]"))}
                ${row("Medicine Reaction", get("dental_answers[med_reaction]"))}
            `)}

            ${subSection("Dental Procedures", `
                ${row("Periodontal Treatment", get("dental_answers[periodontal]"))}
                ${row("Difficult Extraction", get("dental_answers[difficult_extraction]"))}
                ${get("dental_answers[difficult_extraction]") === "YES" ? row("Extraction Date", get("extraction_date")) : ""}
                ${row("Prolonged Bleeding", get("dental_answers[prolonged_bleeding]"))}
                ${row("Dentures", get("dental_answers[dentures]"))}
                ${get("dental_answers[dentures]") === "YES" ? row("Dentures Placement Date", get("dentures_date")) : ""}
                ${row("Orthodontic Treatment", get("dental_answers[ortho_treatment]"))}
                ${get("dental_answers[ortho_treatment]") === "YES" ? row("Orthodontic Completion Date", get("ortho_date")) : ""}
            `)}

            ${fullWidthSection("Additional Concerns", `
                ${get("additional_concerns") !== "N/A" && String(get("additional_concerns")).trim() !== ""
                    ? get("additional_concerns")
                    : '<span class="text-[#9e9690] italic">No additional concerns provided.</span>'}
            `)}
        `;

        const medicalHistoryBody = `
            ${subSection("General Health", `
                ${row("Good Health", get("medical_answers[good_health]"))}
                ${get("medical_answers[good_health]") === "NO" ? row("Health Details", get("medical_answers[good_health_details]")) : ""}
                ${row("Had Medical Exam", get("medical_answers[had_medical_exam]"))}
                ${get("medical_answers[had_medical_exam]") === "YES" ? row("Medical Exam Date", get("medical_answers[medical_exam_date]")) : ""}
                ${row("Under Treatment", get("medical_answers[under_treatment]"))}
                ${get("medical_answers[under_treatment]") === "YES" ? row("Treatment Details", get("medical_answers[treatment_details]")) : ""}
                ${row("Hospitalized", get("medical_answers[hospitalized]"))}
                ${get("medical_answers[hospitalized]") === "YES" ? row("Hospital Details", get("medical_answers[hospital_details]")) : ""}
            `)}

            ${subSection("Allergies", `
                ${row("Allergy (Medicine)", get("medical_answers[allergy_medicine]"))}
                ${row("Allergy (Food)", get("medical_answers[allergy_food]"))}
                ${optionalRow("Allergy (Others)", get("medical_answers[allergy_others]"))}
            `)}

            ${subSection("Medications", `
                ${row("Medication", get("medical_answers[medication]"))}
                ${get("medical_answers[medication]") === "YES" ? row("Medication Details", get("medical_answers[medication_details]")) : ""}
            `)}

            ${isFemalePatient ? subSection("For Women Only", `
                ${row("Pregnant", get("medical_answers[pregnant]"))}
                ${row("Nursing", get("medical_answers[nursing]"))}
                ${row("Birth Control Pills", get("medical_answers[birth_control]"))}
            `) : ""}

            ${fullWidthSection("Medical Conditions", `
                <b class="text-[#5c5550] font-semibold">Selected Conditions:</b> ${diseases}
            `)}

            ${subSection("Tobacco Use", `
                ${row("Tobacco Use", get("medical_answers[tobacco_use]"))}
                ${get("medical_answers[tobacco_use]") === "YES" ? row("Amount Per Day", get("medical_answers[tobacco_per_day]")) : ""}
                ${get("medical_answers[tobacco_use]") === "YES" ? row("Amount Per Week", get("medical_answers[tobacco_per_week]")) : ""}
            `)}

            ${subSection("Do You Suffer From", `
                ${row("Headaches", get("medical_answers[headaches]"))}
                ${row("Earaches", get("medical_answers[earaches]"))}
                ${row("Neck Aches", get("medical_answers[neck_aches]"))}
            `)}
        `;

        reviewGrid.innerHTML = `
            ${summaryCard("Appointment Details", "fa-calendar-check", `
                <div class="grid grid-cols-1 gap-y-1">
                    ${row("Service", get("service_type"))}
                    ${row("Date", get("appointment_date"))}
                    ${row("Time", toDisplayTime(get("appointment_time")) || 'N/A')}
                    ${row("Duration", get("procedure_duration_hms"))}
                </div>
            `)}
            ${summaryCard("Dental History", "fa-tooth", dentalHistoryBody)}
            ${summaryCard("Medical History", "fa-heart-pulse", medicalHistoryBody)}
            <div class="grid grid-cols-2 gap-4 sm-grid-1col">
                ${summaryCard("Emergency Contact", "fa-phone", `
                    <div class="grid grid-cols-1 gap-y-1">
                        ${row("Name", get("emergency_person"))}
                        ${row("Number", get("emergency_number"))}
                        ${row("Relation", get("emergency_relation"))}
                    </div>
                `)}
            </div>
        `;

        document.querySelectorAll(".sm-grid-1col").forEach(el => {
            if (window.innerWidth < 640) el.style.gridTemplateColumns = "1fr";
        });
      }

      function resetTimeField(message = 'Enter the original appointment time, or choose from the suggested slots after selecting a date.') {
          if (!timeField) return;

          timeField.value = '';
          timeField.disabled = false;
          if (timeHint) timeHint.textContent = message;
      }

      function syncTimeFieldFromState() {
          if (!timeField) return;

          const selectedValue = timeInput ? timeInput.value : '';
          const hasDate = !!textValue('#appointment_date');
          const hasSlots = !!slotGridElement?.querySelector('.slot-chip[data-time]');

          timeField.disabled = false;
          timeField.value = toTimeInputValue(selectedValue);

          if (timeHint) {
              if (!hasDate && !selectedValue) {
                  timeHint.textContent = 'You can enter the original appointment time now, or select a date later to see suggested slots.';
              } else if (!hasDate) {
                  timeHint.textContent = 'Time saved. You can still select a date later to see suggested slots.';
              } else if (hasSlots) {
                  timeHint.textContent = 'You can type a time here or click one of the suggested time slots below.';
              } else {
                  timeHint.textContent = 'Enter the original appointment time for this visit.';
              }
          }
      }

      timeField?.addEventListener('change', function () {
          const selected = this.value;
          if (!timeInput) return;

          timeInput.value = selected;

          const matchingChip = Array.from(slotGridElement?.querySelectorAll('.slot-chip[data-time]') || [])
              .find((chip) => toTimeInputValue(chip.dataset.time || '') === selected);
          if (matchingChip) {
              matchingChip.click();
              return;
          }

          const selectedSlotDisplay = document.getElementById('selectedSlotDisplay');
          const selectedSlotText = document.getElementById('selectedSlotText');

          if (selected && selectedSlotDisplay && selectedSlotText) {
              selectedSlotText.textContent = toDisplayTime(selected);
              selectedSlotDisplay.classList.remove('hidden');
              selectedSlotDisplay.style.display = 'block';
          }
      });

      durationInput?.addEventListener('input', function () {
          const formatted = formatDurationInput(this.value);
          this.value = formatted;
      });

      emergencyPersonInput?.addEventListener('input', function (event) {
          const sanitizedValue = event.target.value.replace(/[^A-Za-zÑñ\s.'-]/g, '');
          const hadInvalidChars = sanitizedValue !== event.target.value;

          if (hadInvalidChars) {
              event.target.value = sanitizedValue;
              emergencyPersonInput.classList.remove('border-[#16a34a]');
              emergencyPersonInput.classList.add('border-[#dc2626]');
              emergencyPersonInput.setCustomValidity('Emergency contact name must contain letters only.');
              setInlineFeedback(emergencyPersonFeedback, 'Numbers and special characters are not allowed in the name.', 'error');
          } else {
              emergencyPersonInput.setCustomValidity('');
              validateEmergencyPerson(true);
          }
      });

      emergencyPersonInput?.addEventListener('blur', function () {
          validateEmergencyPerson(true);
      });

      emergencyNumberInput?.addEventListener('input', function (event) {
          const sanitizedValue = event.target.value.replace(/\D/g, '').slice(0, 11);
          const hadInvalidChars = sanitizedValue !== event.target.value;

          if (hadInvalidChars) {
              event.target.value = sanitizedValue;
              emergencyNumberInput.classList.remove('border-[#16a34a]');
              emergencyNumberInput.classList.add('border-[#dc2626]');
              emergencyNumberInput.setCustomValidity('Emergency contact number must start with 09 and contain exactly 11 digits.');
              setInlineFeedback(emergencyNumberFeedback, 'Letters are not allowed. Please enter numbers only.', 'error');
          } else {
              emergencyNumberInput.setCustomValidity('');
              validateEmergencyNumber(true);
          }
      });

      emergencyNumberInput?.addEventListener('blur', function () {
          validateEmergencyNumber(true);
      });

      bindMedicalExamBox();
      bindConditionalBox('medical_answers[good_health]', 'good_health_box', 'NO');
      bindConditionalBox('medical_answers[under_treatment]', 'treatment_box', 'YES');
      bindConditionalBox('medical_answers[hospitalized]', 'hospital_box', 'YES');
      bindConditionalBox('medical_answers[medication]', 'medication_box', 'YES');
      bindTobaccoDetails();

      setupCharLimit('good_health_details', 'goodHealthCount', 150);
      setupCharLimit('treatment_details', 'treatmentCount', 150);
      setupCharLimit('hospital_details', 'hospitalCount', 150);
      setupCharLimit('medication_details', 'medicationCount', 150);

      if (slotGridElement) {
          const slotObserver = new MutationObserver(() => {
              syncTimeFieldFromState();
          });

          slotObserver.observe(slotGridElement, {
              childList: true,
              subtree: true,
              attributes: true,
              attributeFilter: ['class', 'data-time']
          });
      }

    function validateCurrentStep() {
        const currentPanel = panels[currentStep];
        const requiredFields = Array.from(currentPanel.querySelectorAll('input[required], select[required], textarea[required]'));

        for (const field of requiredFields) {
            if (field.type === 'radio') {
                const group = currentPanel.querySelectorAll(`input[name="${field.name}"]`);
                if (![...group].some(input => input.checked)) {
                    group[0].focus();
                    return false;
                }
            } else if (!field.value.trim()) {
                field.focus();
                return false;
            }
        }

        const duration = document.getElementById('procedure_duration_hms');
        if (currentStep === 0 && duration && !/^\d{2}:\d{2}:\d{2}$/.test(duration.value.trim())) {
            duration.focus();
            return false;
        }

        if (currentStep === 2) {
            if (!validateEmergencyPerson(true)) {
                emergencyPersonInput?.reportValidity();
                emergencyPersonInput?.focus();
                return false;
            }

            if (!validateEmergencyNumber(true)) {
                emergencyNumberInput?.reportValidity();
                emergencyNumberInput?.focus();
                return false;
            }
        }

        return true;
    }

    function syncStepper(index) {
        const total = panels.length;
        const progress = ((index + 1) / total) * 100;
        progressFill.style.width = `${progress}%`;
        counter.textContent = String(index + 1);

        for (let step = 1; step <= total; step++) {
            const circle = document.getElementById(`sc${step}`);
            const label = document.getElementById(`sl${step}`);
            const connector = document.getElementById(`conn${step}`);

            circle.className = 'step-circle w-10 h-10 rounded-full border-2 flex items-center justify-center text-sm font-bold';
            label.className = 'step-label text-[0.65rem] font-semibold uppercase tracking-wide text-center hidden sm:block mt-4';

            if (step < index + 1) {
                circle.classList.add('border-blue-600', 'bg-blue-600', 'text-white');
                label.classList.add('text-blue-600');
                if (connector) connector.classList.add('bg-blue-600');
            } else if (step === index + 1) {
                circle.classList.add('border-blue-600', 'bg-blue-600', 'text-white', 'shadow-[0_0_0_6px_rgba(37,99,235,0.12)]', 'scale-110');
                label.classList.add('text-blue-600');
                if (connector) connector.classList.remove('bg-blue-600');
            } else {
                circle.classList.add('border-[#e8e2dd]', 'bg-white', 'text-[#9e9690]');
                label.classList.add('text-[#9e9690]');
                if (connector) connector.classList.remove('bg-blue-600');
            }
        }
    }

      function syncStep() {
          panels.forEach((panel, index) => {
              panel.classList.toggle('hidden', index !== currentStep);
              panel.classList.toggle('show', index === currentStep);
          });

          prevBtn.disabled = currentStep === 0;
          const isLastStep = currentStep === panels.length - 1;

          nextBtn.classList.toggle('hidden', isLastStep);
          nextBtn.style.display = isLastStep ? 'none' : 'inline-flex';

          submitBtn.classList.toggle('hidden', !isLastStep);
          submitBtn.style.display = isLastStep ? 'inline-flex' : 'none';

          syncStepper(currentStep);

          if (isLastStep) {
              buildReview();
          }

          window.scrollTo({ top: 0, behavior: 'smooth' });
      }

    nextBtn.addEventListener('click', function () {
        if (!validateCurrentStep()) return;
        currentStep = Math.min(currentStep + 1, panels.length - 1);
        syncStep();
    });

    prevBtn.addEventListener('click', function () {
        currentStep = Math.max(currentStep - 1, 0);
        syncStep();
    });

      document.getElementById('calendarSkeletonContainer')?.addEventListener('click', function (event) {
          const dateButton = event.target.closest('[data-date]');
          if (!dateButton) return;

        const iso = dateButton.dataset.date;
        if (!iso) return;

          setTimeout(() => {
              const dateInput = document.getElementById('appointment_date');
              const slotContainer = document.getElementById('slotContainer');
              const slotGrid = document.getElementById('slotGrid');
              const hasVisibleSlots = slotContainer && !slotContainer.classList.contains('hidden') && slotGrid && slotGrid.children.length > 0;

            if (dateInput && dateInput.value !== iso) {
                dateInput.value = iso;
            }

              if (!hasVisibleSlots && typeof window.selectDate === 'function') {
                  window.selectDate(iso);
              }
          }, 60);
      });

      syncTimeFieldFromState();
      validateEmergencyPerson(true);
      validateEmergencyNumber(true);
      syncStep();
  });
  </script>
@endsection
