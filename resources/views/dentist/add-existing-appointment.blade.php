@extends('layouts.app')

@section('layout-role', 'dentist')

@section('hide-sidebar')
@endsection

@section('title', 'Add Existing Appointment')

@php
$defaults = $defaults ?? [];
$dentalAnswers = $defaults['dental_answers'] ?? [];
$medicalAnswers = $defaults['medical_answers'] ?? [];
$selectedDiseases = collect($defaults['diseases'] ?? []);
$isFemalePatient = strtolower($patient->gender ?? '') === 'female';
@endphp

@section('content')
<main id="mainContent" class="book-container page-enter">
    <div id="dentistBookAppointmentPage" class="book-page-wrap add-existing-book-page">
        <div class="w-full add-existing-hero-wrap">
            <div class="flex items-center justify-between mb-4 booking-topbar">
                <a href="{{ route(
        'dentist.dentist.patient.profile',
        ['patient' => $patient->id]
    ) }}" class="ui-btn ui-btn-primary ui-btn-sm">

                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Patient Profile
                </a>
                <span
                    class="step-counter-pill text-xs text-[#9e9690] font-semibold bg-white border border-[#e8e2dd] px-3 py-1.5 rounded-full shadow-sm">
                    Step <span id="stepCounterText">1</span> <span class="text-[#c4bfba]">of 4</span>
                </span>
            </div>

            <div class="w-full h-2 rounded-full bg-[#e8e2dd] overflow-hidden mb-5">
                <div id="headerProgressFill" class="h-full rounded-full progress-fill add-existing-progress-fill"></div>
            </div>

            <div class="text-center mb-1">
                <p class="text-xs font-semibold uppercase tracking-widest mb-1 text-[#8B0000]">
                    <i class="fa-regular fa-calendar-check mr-1"></i> PUP TAGUIG DENTAL CLINIC
                </p>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-[#660000]">Add Existing Appointment</h1>
                <p class="text-sm text-[#9e9690] mt-1">Complete the booking details first, then continue to the
                    odontogram on the next page.</p>
            </div>
        </div>

        <div class="w-full pb-16">
            <div class="w-full mt-4 mb-0 animate-fade-up-1 py-3 px-2 stepper-wrap-overflow booking-stepper">
                <div class="flex items-start justify-between w-full stepper-row-padding">
                    @php
                    $steps = [
                    ['number' => 1, 'label' => 'Date & Time'],
                    ['number' => 2, 'label' => 'Service'],
                    ['number' => 3, 'label' => 'Dental History'],
                    ['number' => 4, 'label' => 'Medical History'],
                    ['number' => 5, 'label' => 'Review'],
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
                    <form id="existingAppointmentForm" method="POST"
                        action="{{ route('dentist.odontogram.existing-appointment.intake.store', ['patient' => $patient->id]) }}"
                        data-global-selects data-global-validation>
                        @csrf

                        <div class="step-content hidden">
                            <div class="booking-step-shell">
                                <div class="booking-step-header">
                                    <p class="booking-step-eyebrow">Step 1 of 5</p>
                                    <h2 class="booking-step-title">
                                        Select Date &amp; Time
                                    </h2>
                                    <p class="booking-step-subtitle">
                                        Enter the original appointment date,
                                        time, and procedure duration for this
                                        completed visit.
                                    </p>
                                </div>

                                <div class="booking-step-body">
                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-regular fa-calendar-days text-xs"></i> Appointment Details
                                            <span class="section-card-title-line"></span>
                                        </p>

                                        <input type="hidden" id="appointment_date" name="appointment_date"
                                            value="{{ old('appointment_date', $defaults['appointment_date'] ?? '') }}"
                                            required>
                                        <input type="hidden" id="appointment_time" name="appointment_time"
                                            value="{{ old('appointment_time', $defaults['appointment_time'] ?? '') }}"
                                            required>

                                        <div
                                            class="cal-time-layout grid gap-5 lg:gap-6 mx-auto w-full add-existing-cal-time-layout">
                                            <div class="calendar-shell-no-card">
                                                <div id="calendarSkeletonContainer"></div>
                                            </div>

                                            <div class="time-panel flex flex-col is-empty">
                                                <div class="mb-5">
                                                    <p
                                                        class="text-[0.78rem] font-extrabold text-[#8B0000] uppercase tracking-[0.24em]">
                                                        Appointment Details
                                                    </p>
                                                    <p class="text-sm text-[#8c817a] mt-1 leading-6">
                                                        Choose the original appointment time for the selected date.
                                                    </p>
                                                </div>

                                                <div id="dateBanner"
                                                    class="hidden rounded-xl px-3 py-2 text-sm font-semibold text-white mb-3 shadow-md date-banner-gradient">
                                                </div>

                                                <div class="global-form-group">
                                                    <label for="existing_time_input" class="global-form-label">
                                                        Appointment Time
                                                    </label>

                                                    <div class="global-control-wrap">
                                                        <i class="fa-regular fa-clock global-control-icon"></i>

                                                        <input type="text" id="existing_time_input"
                                                            class="form-input-custom global-control-with-icon js-flatpickr-time"
                                                            placeholder="Select time" readonly>
                                                    </div>

                                                    <p id="existingAppointmentTimeHint" class="field-help">
                                                        Select a date first, then enter or choose the original
                                                        appointment time.
                                                    </p>
                                                </div>
                                                <div class="global-form-group mt-4" data-global-field>
                                                    <label class="global-form-label" for="procedure_duration_hms">
                                                        Procedure Duration
                                                        <span class="required-mark">*</span>
                                                    </label>

                                                    <div class="global-control-wrap">
                                                        <i class="fa-solid fa-stopwatch
                   global-control-icon"></i>

                                                        <input type="text" id="procedure_duration_hms"
                                                            name="procedure_duration_hms" value="{{ old(
                'procedure_duration_hms',
                $defaults[
                    'procedure_duration_hms'
                ] ?? ''
            ) }}" placeholder="HH:MM:SS" class="
                form-input-custom
                global-control-with-icon
            " inputmode="numeric" maxlength="8" data-validation-rule="bookingDuration" data-required-message="
                Please enter the procedure duration.
            " required>
                                                    </div>

                                                    <p class="field-help">
                                                        Example: 01:15:00 for
                                                        1 hour and 15 minutes.
                                                    </p>
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
                                    <p class="booking-step-eyebrow">
                                        Step 2 of 5
                                    </p>

                                    <h2 class="booking-step-title">
                                        Choose Dental Service
                                    </h2>

                                    <p class="booking-step-subtitle">
                                        Select the dental service
                                        performed during this
                                        appointment.
                                    </p>
                                </div>

                                <div class="booking-step-body">
                                    <div class="service-step-grid
                       add-existing-service-grid
                       global-choice-group" role="radiogroup" aria-label="Service Type" data-global-field
                                        data-global-choice-group>
                                        @foreach ($serviceTypes as $service)
                                        <label class="service-option group">
                                            <input type="radio" name="service_type" value="{{ $service->name }}"
                                                class="service-option-input"
                                                data-required-message="Please select a dental service." @checked(
                                                old( 'service_type' , $defaults['service_type'] ?? '' )===$service->name
                                            )
                                            required
                                            >

                                            <div class="service-option-card">
                                                <div class="service-option-main">
                                                    <div class="service-option-icon">
                                                        <i class="fa-solid fa-tooth"></i>
                                                    </div>

                                                    <div class="service-option-copy">
                                                        <div class="service-option-topline">
                                                            <p class="service-option-title">
                                                                {{ $service->name }}
                                                            </p>

                                                            <span class="service-option-badge">
                                                                Available
                                                            </span>
                                                        </div>

                                                        <p class="service-option-desc">
                                                            {{
                                                            $service->description
                                                            ?: 'No description available.'
                                                            }}
                                                        </p>
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
                            <div class="booking-step-shell">
                                <div class="booking-step-header">
                                    <p class="booking-step-eyebrow">Step 3 of 5</p>
                                    <h2 class="booking-step-title">Dental History</h2>
                                    <p class="booking-step-subtitle">
                                        Share the patient's past dental records, treatments, and dental concerns for a
                                        better
                                        assessment.
                                    </p>
                                </div>

                                <div class="booking-step-body">
                                    @php
                                    $dentalQuestionMap = collect($dentalQuestions)->keyBy('code');
                                    $dentalSymptomCodes = ['bleeding_gums', 'sensitive_temp', 'sensitive_taste',
                                    'tooth_pain', 'sores', 'injuries'];
                                    $jawBiteCodes = ['clicking', 'joint_pain', 'difficulty_moving',
                                    'difficulty_chewing', 'jaw_headaches', 'clench_grind', 'biting', 'teeth_loosening',
                                    'food_teeth', 'med_reaction'];
                                    $dentalProcedureCodes = ['periodontal', 'difficult_extraction',
                                    'prolonged_bleeding', 'dentures', 'ortho_treatment'];
                                    @endphp
                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-regular fa-calendar-days text-xs"></i> Basic Info
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div class="global-form-group">
                                                <label class="global-form-label" for="last_dental_visit">Last Dental
                                                    Visit</label>
                                                <div class="global-control-wrap">
                                                    <i class="fa-regular fa-calendar global-control-icon"></i>

                                                    <input type="text" id="last_dental_visit" name="last_dental_visit"
                                                        value="{{ old('last_dental_visit', $defaults['last_dental_visit'] ?? '') }}"
                                                        class="form-input-custom global-control-with-icon js-flatpickr-date-max-today"
                                                        placeholder="Select date" readonly>
                                                </div>
                                            </div>
                                            <div class="global-form-group" data-global-field>

                                                <label class="global-form-label" for="previous_dentist">

                                                    Previous Dentist
                                                    <span class="required-mark">*</span>
                                                </label>

                                                <input type="text" id="previous_dentist" name="previous_dentist"
                                                    maxlength="50" value="{{ old(
            'previous_dentist',
            $defaults['previous_dentist'] ?? ''
        ) }}" class="form-input-custom" placeholder="Dr. Name"
                                                    data-required-message="Please enter the previous dentist." required>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p
                                            class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                            <i class="fa-solid fa-tooth text-xs"></i> Dental Symptoms
                                            <span class="flex-1 h-px bg-[#f9e8e8]"></span>
                                        </p>
                                        @foreach ($dentalSymptomCodes as $code)
                                        @php
                                        $question =
                                        $dentalQuestionMap->get($code);

                                        $current = old(
                                        "dental_answers.$code",
                                        $dentalAnswers[$code] ?? ''
                                        );
                                        @endphp

                                        @if ($question)

                                        <x-booking-question name="dental_answers[{{ $code }}]"
                                            :label="$question['label']" :checked-value="$current" required />

                                        @endif
                                        @endforeach
                                    </div>

                                    <div class="section-card">
                                        <p
                                            class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                            <i class="fa-solid fa-circle-dot text-xs"></i> Jaw &amp; Bite Symptoms
                                            <span class="flex-1 h-px bg-[#f9e8e8]"></span>
                                        </p>
                                        @foreach ($jawBiteCodes as $code)

                                        @php
                                        $question =
                                        $dentalQuestionMap->get($code);

                                        $current = old(
                                        "dental_answers.$code",
                                        $dentalAnswers[$code] ?? ''
                                        );
                                        @endphp

                                        @if ($question)

                                        <x-booking-question name="dental_answers[{{ $code }}]"
                                            :label="$question['label']" :checked-value="$current" required />

                                        @endif
                                        @endforeach
                                        <p class="text-xs text-[#8B0000] mt-2 italic pl-4">
                                            <i class="fa-solid fa-circle-info mr-1"></i> If <b>YES</b>, please
                                            provide
                                            details during your consultation.
                                        </p>
                                    </div>

                                    <div class="section-card">
                                        <p
                                            class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                            <i class="fa-solid fa-notes-medical text-xs"></i> Dental Procedures
                                            <span class="flex-1 h-px bg-[#f9e8e8]"></span>
                                        </p>
                                        @foreach ($dentalProcedureCodes as $code)

                                        @php
                                        $question =
                                        $dentalQuestionMap->get($code);

                                        $current = old(
                                        "dental_answers.$code",
                                        $dentalAnswers[$code] ?? ''
                                        );
                                        @endphp

                                        @if ($question)

                                        <x-booking-question name="dental_answers[{{ $code }}]"
                                            :label="$question['label']" :checked-value="$current" required />

                                        @endif

                                        @endforeach

                                        <div id="extraction_date_box" class="{{ old(
        'dental_answers.difficult_extraction',
        $dentalAnswers['difficult_extraction'] ?? ''
    ) === 'YES' ? '' : 'hidden' }} mt-3">

                                            <div class="global-form-group">

                                                <label class="global-form-label" for="extraction_date">
                                                    Date of Extraction
                                                </label>

                                                <div class="global-control-wrap">
                                                    <i class="fa-regular fa-calendar global-control-icon"></i>

                                                    <input type="text" id="extraction_date" name="extraction_date"
                                                        value="{{ old(
                    'extraction_date',
                    $defaults['extraction_date'] ?? ''
                ) }}" class="form-input-custom global-control-with-icon js-flatpickr-date-max-today"
                                                        placeholder="Select date" readonly>
                                                </div>

                                            </div>
                                        </div>

                                        <div id="dentures_date_box" class="{{ old(
        'dental_answers.dentures',
        $dentalAnswers['dentures'] ?? ''
    ) === 'YES' ? '' : 'hidden' }} mt-3">

                                            <div class="global-form-group">

                                                <label class="global-form-label" for="dentures_date">
                                                    Date of Placement
                                                </label>

                                                <div class="global-control-wrap">
                                                    <i class="fa-regular fa-calendar global-control-icon"></i>

                                                    <input type="text" id="dentures_date" name="dentures_date" value="{{ old(
                    'dentures_date',
                    $defaults['dentures_date'] ?? ''
                ) }}" class="form-input-custom global-control-with-icon js-flatpickr-date-max-today"
                                                        placeholder="Select date" readonly>
                                                </div>

                                            </div>
                                        </div>

                                        <div id="ortho_date_box" class="{{ old(
        'dental_answers.ortho_treatment',
        $dentalAnswers['ortho_treatment'] ?? ''
    ) === 'YES' ? '' : 'hidden' }} mt-3">

                                            <div class="global-form-group">

                                                <label class="global-form-label" for="ortho_date">
                                                    Date of Completion
                                                </label>

                                                <div class="global-control-wrap">
                                                    <i class="fa-regular fa-calendar global-control-icon"></i>

                                                    <input type="text" id="ortho_date" name="ortho_date" value="{{ old(
                    'ortho_date',
                    $defaults['ortho_date'] ?? ''
                ) }}" class="form-input-custom global-control-with-icon js-flatpickr-date-max-today"
                                                        placeholder="Select date" readonly>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p
                                            class="flex items-center gap-2 text-[0.78rem] font-bold text-[#8B0000] uppercase tracking-widest mb-3">
                                            <i class="fa-regular fa-comment-dots text-xs"></i> Additional Concerns
                                            <span class="flex-1 h-px bg-[#f9e8e8]"></span>
                                        </p>
                                        <div class="grid grid-cols-1 gap-4">
                                            <div class="global-form-group">
                                                <label class="global-form-label" for="additional_concerns">Additional
                                                    Dental Concerns</label>
                                                <div class="global-form-textarea-wrap">
                                                    <textarea id="additional_concerns" name="additional_concerns"
                                                        rows="4" class="form-input-custom global-form-textarea"
                                                        placeholder="Write any additional concerns here...">{{ old('additional_concerns', $defaults['additional_concerns'] ?? '') }}</textarea>
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
                                    <p class="booking-step-eyebrow">Step 4 of 5</p>
                                    <h2 class="booking-step-title">Medical History</h2>
                                    <p class="booking-step-subtitle">
                                        Encode the same emergency and medical information used in standard
                                        appointment
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
                                        <x-booking-question name="medical_answers[good_health]" :label="$medicalQuestionMap->get('good_health')['label']
        ?? 'Are you in good health?'" :checked-value="$medicalValue('good_health')" required />


                                        <div id="good_health_box" class="{{ $medicalValue('good_health') === 'NO'
        ? ''
        : 'hidden' }} mt-3">

                                            <div class="global-form-group">

                                                <label class="global-form-label" for="good_health_details">

                                                    {{ $medicalQuestionMap->get('good_health_details')['label']
                                                    ?? 'If NO, please specify:' }}

                                                </label>

                                                <input type="text" name="medical_answers[good_health_details]"
                                                    id="good_health_details" maxlength="150"
                                                    value="{{ $medicalValue('good_health_details') }}"
                                                    class="form-input-custom" placeholder="Input here"
                                                    data-char-limit="150" data-char-counter="#goodHealthCount">

                                                <p class="field-help">
                                                    <span id="goodHealthCount">
                                                        {{ strlen(
                                                        $medicalValue(
                                                        'good_health_details'
                                                        )
                                                        ) }} / 150 characters
                                                    </span>
                                                </p>

                                            </div>
                                        </div>


                                        <x-booking-question name="medical_answers[had_medical_exam]" :label="$medicalQuestionMap->get('had_medical_exam')['label']
        ?? 'Have you had or are you having medical treatment now?'" :checked-value="$medicalValue('had_medical_exam')"
                                            required />


                                        <div id="medical_exam_box" class="{{ $medicalValue('had_medical_exam') === 'YES'
        ? ''
        : 'hidden' }} mt-3">

                                            <div class="global-form-group">

                                                <label class="global-form-label" for="medicalExamDate">

                                                    {{ $medicalQuestionMap->get('medical_exam_date')['label']
                                                    ?? 'If YES, when was your last medical examination?' }}

                                                </label>

                                                <div class="global-control-wrap">

                                                    <i class="fa-regular fa-calendar global-control-icon"></i>

                                                    <input type="text" id="medicalExamDate"
                                                        name="medical_answers[medical_exam_date]"
                                                        value="{{ $medicalValue('medical_exam_date') }}"
                                                        class="form-input-custom global-control-with-icon js-flatpickr-date-max-today"
                                                        placeholder="Select date" readonly>

                                                </div>
                                            </div>
                                        </div>



                                        <x-booking-question name="medical_answers[under_treatment]" :label="$medicalQuestionMap->get('under_treatment')['label']
        ?? 'Are you currently receiving treatment for any illness?'" :checked-value="$medicalValue('under_treatment')"
                                            required />

                                        <div id="treatment_box" class="{{ $medicalValue('under_treatment') === 'YES'
        ? ''
        : 'hidden' }} mt-3">

                                            <div class="global-form-group">

                                                <label class="global-form-label" for="treatment_details">

                                                    {{ $medicalQuestionMap->get('treatment_details')['label']
                                                    ?? 'If YES, please specify:' }}

                                                </label>

                                                <input type="text" name="medical_answers[treatment_details]"
                                                    id="treatment_details" maxlength="150"
                                                    value="{{ $medicalValue('treatment_details') }}"
                                                    class="form-input-custom" placeholder="Input here"
                                                    data-char-limit="150" data-char-counter="#treatmentCount">

                                                <p class="field-help">
                                                    <span id="treatmentCount">
                                                        {{ strlen(
                                                        $medicalValue(
                                                        'treatment_details'
                                                        )
                                                        ) }} / 150 characters
                                                    </span>
                                                </p>

                                            </div>
                                        </div>


                                        <x-booking-question name="medical_answers[hospitalized]" :label="$medicalQuestionMap->get('hospitalized')['label']
        ?? 'Have you ever been hospitalized?'" :checked-value="$medicalValue('hospitalized')" required />


                                        <div id="hospital_box" class="{{ $medicalValue('hospitalized') === 'YES'
        ? ''
        : 'hidden' }} mt-3">

                                            <div class="global-form-group">

                                                <label class="global-form-label" for="hospital_details">

                                                    {{ $medicalQuestionMap->get('hospital_details')['label']
                                                    ?? 'If YES, please provide details:' }}

                                                </label>

                                                <input type="text" name="medical_answers[hospital_details]"
                                                    id="hospital_details" maxlength="150"
                                                    value="{{ $medicalValue('hospital_details') }}"
                                                    class="form-input-custom" placeholder="Input here"
                                                    data-char-limit="150" data-char-counter="#hospitalCount">

                                                <p class="field-help">
                                                    <span id="hospitalCount">
                                                        {{ strlen(
                                                        $medicalValue(
                                                        'hospital_details'
                                                        )
                                                        ) }} / 150 characters
                                                    </span>
                                                </p>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-triangle-exclamation text-xs"></i>
                                            Allergies
                                            <span class="section-card-title-line"></span>
                                        </p>

                                        @foreach ([
                                        [
                                        'name' => 'allergy_medicine',
                                        'label' => 'Medicines',
                                        ],
                                        [
                                        'name' => 'allergy_food',
                                        'label' => 'Food',
                                        ],
                                        ] as $item)

                                        <x-booking-question name="medical_answers[{{ $item['name'] }}]"
                                            :label="$item['label']" :checked-value="$medicalValue($item['name'])"
                                            required />

                                        @endforeach

                                        <div class="global-form-group mt-3">
                                            <label class="global-form-label">
                                                {{ $medicalQuestionMap->get('allergy_others')['label']
                                                ?? 'Others (please specify):' }}
                                            </label>

                                            <input type="text" name="medical_answers[allergy_others]"
                                                value="{{ $medicalValue('allergy_others') }}" class="form-input-custom"
                                                placeholder="Input here">
                                        </div>
                                    </div>

                                    @if ($isFemalePatient)

                                    <div class="section-card">

                                        <p class="section-card-title">
                                            <i class="fa-solid fa-venus text-xs"></i>
                                            For Women Only
                                            <span class="section-card-title-line"></span>
                                        </p>

                                        @foreach ([
                                        [
                                        'name' => 'pregnant',
                                        'label' => 'Are you pregnant?'
                                        ],
                                        [
                                        'name' => 'nursing',
                                        'label' => 'Are you nursing?'
                                        ],
                                        [
                                        'name' => 'birth_control',
                                        'label' => 'Are you taking birth control pills?'
                                        ]
                                        ] as $item)

                                        <x-booking-question name="medical_answers[{{ $item['name'] }}]"
                                            :label="$item['label']" :checked-value="$medicalValue($item['name'])"
                                            required />

                                        @endforeach

                                    </div>

                                    @else

                                    <input type="hidden" name="medical_answers[pregnant]" value="NO">

                                    <input type="hidden" name="medical_answers[nursing]" value="NO">

                                    <input type="hidden" name="medical_answers[birth_control]" value="NO">

                                    @endif

                                    <div class="section-card mt-5">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-notes-medical text-xs"></i> Known Diseases /
                                            Conditions
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <p class="text-xs text-[#5c5550] mb-3">Please indicate below if you
                                            presently
                                            have or have ever had any of the following:</p>
                                        <div
                                            class="medical-condition-grid grid grid-cols-1 sm:grid-cols-2 gap-y-2.5 gap-x-6">
                                            @foreach ($diseases as $disease)
                                            @php $checked = collect(old('diseases',
                                            $selectedDiseases->all()))->contains($disease->code); @endphp
                                            <label class="flex items-center gap-2.5 cursor-pointer">
                                                <input type="checkbox" name="diseases[]" value="{{ $disease->code }}"
                                                    @checked($checked)
                                                    class="w-4 h-4 rounded border-2 border-[#e8e2dd] cursor-pointer accent-[#8B0000] flex-shrink-0">
                                                <span class="text-[0.82rem] text-[#1a1410]">{{ $disease->label ??
                                                    $disease->name ?? $disease->code }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-smoking text-xs"></i> Tobacco Use
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <x-booking-question name="medical_answers[tobacco_use]" :label="$medicalQuestionMap->get('tobacco_use')['label']
        ?? 'Do you use tobacco products or any derivatives?'" :checked-value="$medicalValue('tobacco_use')" required />

                                        <div id="tobacco_details" class="{{ $medicalValue('tobacco_use') === 'YES'
        ? ''
        : 'hidden' }} mt-3">

                                            <div class="global-form-group">

                                                <label class="global-form-label">
                                                    How much per day
                                                </label>

                                                <input type="text" name="medical_answers[tobacco_per_day]"
                                                    value="{{ $medicalValue('tobacco_per_day') }}"
                                                    class="form-input-custom" placeholder="Input here">

                                            </div>

                                            <div class="global-form-group mt-3">

                                                <label class="global-form-label">
                                                    Per week
                                                </label>

                                                <input type="text" name="medical_answers[tobacco_per_week]"
                                                    value="{{ $medicalValue('tobacco_per_week') }}"
                                                    class="form-input-custom" placeholder="Input here">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-head-side-mask text-xs"></i> Do You Suffer From
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        @foreach ([
                                        [
                                        'name' => 'headaches',
                                        'label' => 'Headaches'
                                        ],
                                        [
                                        'name' => 'earaches',
                                        'label' => 'Earaches'
                                        ],
                                        [
                                        'name' => 'neck_aches',
                                        'label' => 'Neck aches'
                                        ]
                                        ] as $item)

                                        <x-booking-question name="medical_answers[{{ $item['name'] }}]"
                                            :label="$item['label']" :checked-value="$medicalValue($item['name'])"
                                            required />

                                        @endforeach
                                    </div>

                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-phone-volume text-xs"></i> Emergency Contact
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div class="emergency-fields-stack">
                                            <div class="global-form-group" data-global-field>

                                                <label class="global-form-label" for="emergency_person">
                                                    Person to contact in case of emergency
                                                    <span class="required-mark">*</span>
                                                </label>

                                                <input type="text" id="emergency_person" name="emergency_person"
                                                    maxlength="50" pattern="[A-Za-zÑñ\s.'-]+"
                                                    value="{{ old('emergency_person', $defaults['emergency_person'] ?? '') }}"
                                                    data-pattern-message="Only letters, spaces, apostrophe, period, and hyphen are allowed."
                                                    data-required-message="Please enter the emergency contact person."
                                                    class="form-input-custom" required>
                                            </div>
                                            <div class="global-form-group" data-global-field>

                                                <label class="global-form-label" for="emergency_number">

                                                    Contact Number
                                                    <span class="required-mark">*</span>
                                                </label>

                                                <input type="text" id="emergency_number" name="emergency_number"
                                                    inputmode="numeric" autocomplete="tel" maxlength="11"
                                                    pattern="09[0-9]{9}" value="{{ old(
            'emergency_number',
            $defaults['emergency_number'] ?? ''
        ) }}" class="form-input-custom" placeholder="09XXXXXXXXX"
                                                    data-required-message="Please enter the emergency contact number."
                                                    data-pattern-message="Contact number must start with 09 and contain exactly 11 digits."
                                                    required>

                                                <p class="field-help">
                                                    Format: 09XXXXXXXXX
                                                </p>

                                            </div>
                                            <div class="global-form-group" data-global-field>

                                                <label class="global-form-label" for="emergency_relation">

                                                    Relation to Patient
                                                    <span class="required-mark">*</span>

                                                </label>

                                                <select name="emergency_relation" id="emergency_relation"
                                                    class="js-custom-select" data-placeholder="Select relation"
                                                    data-required-message="Please select the relation to the patient."
                                                    aria-label="Relation to patient" required>

                                                    <option value="" disabled @selected( old( 'emergency_relation' ,
                                                        $defaults['emergency_relation'] ?? '' )==='' )>
                                                        Select relation
                                                    </option>

                                                    @foreach ([
                                                    'Mother',
                                                    'Father',
                                                    'Sibling',
                                                    'Guardian',
                                                    'Spouse',
                                                    'Grandparent',
                                                    'Aunt',
                                                    'Uncle',
                                                    'Cousin',
                                                    'Child'
                                                    ] as $relation)

                                                    <option value="{{ $relation }}" @selected( old( 'emergency_relation'
                                                        , $defaults['emergency_relation'] ?? '' )===$relation )>
                                                        {{ $relation }}
                                                    </option>

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
                                    <p class="booking-step-eyebrow">Step 5 of 5</p>
                                    <h2 class="booking-step-title">Review Before Odontogram</h2>
                                    <p class="booking-step-subtitle">
                                        Confirm the imported appointment details before continuing to the
                                        odontogram.
                                    </p>
                                </div>

                                <div class="booking-step-body">
                                    <div class="section-card">
                                        <p class="section-card-title">
                                            <i class="fa-solid fa-circle-check text-xs"></i> Summary
                                            <span class="section-card-title-line"></span>
                                        </p>
                                        <div id="existingAppointmentReviewGrid" class="space-y-4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="add-existing-nav-actions">

                            <button type="button" id="prevStepBtn" class="ui-btn ui-btn-secondary">
                                <i class="fa-solid fa-chevron-left"></i>
                                Previous
                            </button>

                            <div class="flex items-center gap-3">

                                <button type="button" id="nextStepBtn" class="ui-btn ui-btn-primary">
                                    Next
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>

                                <button type="submit" id="submitExistingAppointmentBtn"
                                    class="hidden ui-btn ui-btn-primary">
                                    Continue to Odontogram
                                    <i class="fa-solid fa-chevron-right"></i>
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
'selectedSlotDisplayId' => 'selectedSlotDisplay',
'selectedSlotTextId' => 'selectedSlotText',
'slotEndpoint' => route('dentist.odontogram.existing-appointment.slots'),
'scheduleRules' => $schedules ?? [],
'blockedDates' => $blockedDates ?? [],
'appointmentCountsPerDay' => $appointmentCountsPerDay ?? [],
'philippineHolidays' => $philippineHolidays ?? [],
'useDynamicScheduleRules' => true,
'disallowToday' => false,
'allowPastDates' => true,
'allowAllDates' => false,
'allowAllDatesExceptHolidays' => true,
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
        const submitBtn = document.getElementById('submitExistingAppointmentBtn');
        const counter = document.getElementById('stepCounterText');
        const reviewGrid = document.getElementById('existingAppointmentReviewGrid');
        const progressFill = document.getElementById('headerProgressFill');
        const timeField = document.getElementById('existing_time_input');
        const timeHint = document.getElementById('existingAppointmentTimeHint');
        const slotGridElement = document.getElementById('slotGrid');
        const timeInput = document.getElementById('appointment_time');
        const durationInput = document.getElementById('procedure_duration_hms');
        const emergencyPersonInput = document.getElementById('emergency_person');
        const emergencyNumberInput = document.getElementById('emergency_number');
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

        function bindConditionalBox(
            radioName,
            boxId,
            showOn
        ) {
            const radios =
                Array.from(
                    document.querySelectorAll(
                        `input[name="${radioName}"]`
                    )
                );

            const box =
                document.getElementById(
                    boxId
                );

            if (
                !box ||
                !radios.length
            ) {
                return;
            }

            const sync = () => {
                const selected =
                    radios.find(
                        radio =>
                            radio.checked
                    );

                const shouldShow =
                    selected?.value ===
                    showOn;

                box.classList.toggle(
                    'hidden',
                    !shouldShow
                );

                if (shouldShow) {
                    return;
                }

                box
                    .querySelectorAll(
                        'input, textarea, select'
                    )
                    .forEach(field => {

                        if (field._flatpickr) {
                            field._flatpickr.clear();
                        } else if (
                            field instanceof
                            HTMLSelectElement
                        ) {
                            field.selectedIndex = 0;
                        } else {
                            field.value = '';
                        }

                        field.classList.remove(
                            'is-invalid',
                            'is-valid'
                        );

                        const fieldError =
                            field
                                .closest(
                                    '[data-global-field], .global-form-group'
                                )
                                ?.querySelector(
                                    '.global-field-error'
                                );

                        fieldError?.classList.remove(
                            'show',
                            'is-success'
                        );
                    });
            };

            radios.forEach(radio => {
                radio.addEventListener(
                    'change',
                    sync
                );
            });

            sync();
        }

        function buildReview() {
            const form = document.getElementById('existingAppointmentForm');
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

        function syncTimeFieldFromState() {
            if (!timeField) return;

            const selectedValue = timeInput ? timeInput.value : '';
            const hasDate = !!textValue('#appointment_date');
            const hasSlots = !!slotGridElement?.querySelector('.slot-chip[data-time]');

            timeField.disabled = false;
            const normalizedTime =
                toTimeInputValue(selectedValue);

            if (timeField._flatpickr) {
                timeField._flatpickr.setDate(
                    normalizedTime,
                    false,
                    'H:i'
                );
            } else {
                timeField.value =
                    normalizedTime;
            }

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

        bindConditionalBox(
            'dental_answers[difficult_extraction]',
            'extraction_date_box',
            'YES'
        );

        bindConditionalBox(
            'dental_answers[dentures]',
            'dentures_date_box',
            'YES'
        );

        bindConditionalBox(
            'dental_answers[ortho_treatment]',
            'ortho_date_box',
            'YES'
        );

        bindConditionalBox(
            'medical_answers[good_health]',
            'good_health_box',
            'NO'
        );

        bindConditionalBox(
            'medical_answers[had_medical_exam]',
            'medical_exam_box',
            'YES'
        );

        bindConditionalBox(
            'medical_answers[under_treatment]',
            'treatment_box',
            'YES'
        );

        bindConditionalBox(
            'medical_answers[hospitalized]',
            'hospital_box',
            'YES'
        );

        bindConditionalBox(
            'medical_answers[medication]',
            'medication_box',
            'YES'
        );

        bindConditionalBox(
            'medical_answers[tobacco_use]',
            'tobacco_details',
            'YES'
        );

        bindConditionalBox(
            'dental_answers[difficult_extraction]',
            'extraction_date_box',
            'YES'
        );

        bindConditionalBox(
            'dental_answers[dentures]',
            'dentures_date_box',
            'YES'
        );

        bindConditionalBox(
            'dental_answers[ortho_treatment]',
            'ortho_date_box',
            'YES'
        );

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
            const currentPanel =
                panels[currentStep];

            if (currentStep === 0) {

                const appointmentDate =
                    document.getElementById(
                        'appointment_date'
                    );

                const appointmentTime =
                    document.getElementById(
                        'appointment_time'
                    );

                if (
                    !appointmentDate?.value
                ) {
                    const calendarGroup =
                        document.querySelector(
                            '.calendar-shell-no-card'
                        );

                    const timeGroup =
                        document.querySelector(
                            '.time-panel'
                        );

                    if (!appointmentDate?.value) {
                        window.showGlobalGroupError?.(
                            calendarGroup,
                            'appointment_date',
                            'Please select the original appointment date.'
                        );

                        calendarGroup?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });

                        return false;
                    }

                    window.clearGlobalGroupError?.(
                        calendarGroup,
                        'appointment_date'
                    );

                    if (!appointmentTime?.value) {
                        window.showGlobalGroupError?.(
                            timeGroup,
                            'appointment_time',
                            'Please select the original appointment time.'
                        );

                        timeGroup?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });

                        return false;
                    }

                    window.clearGlobalGroupError?.(
                        timeGroup,
                        'appointment_time'
                    );

                    document
                        .getElementById(
                            'calendarSkeletonContainer'
                        )
                        ?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });

                    return false;
                }

                if (
                    !appointmentTime?.value
                ) {
                    window.showToast?.({
                        type: 'error',
                        title: 'Appointment Time Required',
                        message:
                            'Please select the original appointment time.'
                    });

                    timeField?.focus();

                    return false;
                }
            }

            if (currentStep === 1) {
                const serviceGroup =
                    currentPanel.querySelector(
                        '.service-step-grid'
                    );

                const selectedService =
                    serviceGroup?.querySelector(
                        'input[name="service_type"]:checked'
                    );

                if (!selectedService) {
                    window.showGlobalGroupError?.(
                        serviceGroup,
                        'service_type',
                        'Please select a dental service.'
                    );

                    serviceGroup?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center',
                    });

                    return false;
                }

                window.clearGlobalGroupError?.(
                    serviceGroup,
                    'service_type'
                );
            }
            const fields =
                Array.from(
                    currentPanel.querySelectorAll(
                        'input:not([type="hidden"]):not([type="button"]):not([type="submit"]), textarea, select'
                    )
                );

            const processedRadioGroups =
                new Set();

            let firstInvalid = null;

            fields.forEach(field => {
                if (
                    field.type === 'radio' &&
                    processedRadioGroups.has(
                        field.name
                    )
                ) {
                    return;
                }

                if (
                    field.type === 'radio'
                ) {
                    processedRadioGroups.add(
                        field.name
                    );
                }

                const valid =
                    window
                        .validateFormInputField?.(
                            field
                        ) ?? true;

                if (
                    !valid &&
                    !firstInvalid
                ) {
                    firstInvalid =
                        field;
                }
            });

            if (firstInvalid) {
                window
                    .focusGlobalInvalidField?.(
                        firstInvalid
                    );

                return false;
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
                const active =
                    index === currentStep;

                panel.classList.toggle(
                    'show',
                    active
                );

                panel.classList.toggle(
                    'hidden',
                    !active
                );
            });

            prevBtn.disabled =
                currentStep === 0;

            const isLastStep =
                currentStep ===
                panels.length - 1;

            nextBtn.classList.toggle(
                'hidden',
                isLastStep
            );

            nextBtn.style.display =
                isLastStep
                    ? 'none'
                    : 'inline-flex';

            submitBtn.classList.toggle(
                'hidden',
                !isLastStep
            );

            submitBtn.style.display =
                isLastStep
                    ? 'inline-flex'
                    : 'none';

            syncStepper(currentStep);

            if (isLastStep) {
                buildReview();
            }

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
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

                if (dateInput && dateInput.value !== iso) {
                    dateInput.value = iso;
                }

                if (!hasVisibleSlots && typeof window.selectDate === 'function') {
                    window.selectDate(iso);
                }
            }, 60);
        });

        syncTimeFieldFromState();
        syncStep();
    });
</script>
@endsection