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
<main id="mainContent" class="booking-page page-enter">
    <div class="booking-page-inner">
        <x-booking.workflow-header :back-url="route('dentist.dentist.patient.profile', ['patient' => $patient->id])"
            back-label="Back to Patient Profile" form-target="#existingAppointmentForm"
            icon="fa-solid fa-file-circle-plus" title="Add Existing Appointment"
            subtitle="Encode the completed appointment details before continuing to the odontogram."
            :steps="['Date & Time', 'Service', 'Dental History', 'Medical History', 'Review']" />

        <div class="w-full">

            <div class="booking-workflow-card">
                <div>
                    <form id="existingAppointmentForm" method="POST"
                        action="{{ route('dentist.odontogram.existing-appointment.intake.store', ['patient' => $patient->id]) }}"
                        data-global-selects data-global-validation data-discard-form
                        data-discard-title="Discard existing appointment?"
                        data-discard-subtitle="You have unsaved appointment information."
                        data-discard-message="Leaving this page will remove the appointment details you entered. Do you want to discard your changes?">
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
                                    <div class="booking-section-card">
                                        <p class="booking-section-card-title">
                                            <i class="fa-regular fa-calendar-days text-xs"></i> Appointment Details
                                            <span class="booking-section-card-title-line"></span>
                                        </p>

                                        <input type="hidden" id="appointment_date" name="appointment_date"
                                            value="{{ old('appointment_date', $defaults['appointment_date'] ?? '') }}"
                                            required>
                                        <input type="hidden" id="appointment_time" name="appointment_time"
                                            value="{{ old('appointment_time', $defaults['appointment_time'] ?? '') }}"
                                            required>

                                        <div
                                            class="cal-time-layout grid gap-5 lg:gap-6 mx-auto w-full add-existing-cal-time-layout">
                                            <div class="calendar-shell-no-card" data-global-field>
                                                <div id="calendarSkeletonContainer"></div>
                                            </div>

                                            <div class="time-panel is-empty" data-global-field>
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

                                                <div id="appointmentTimeField" class="global-form-group"
                                                    data-global-field>
                                                    <label for="existing_time_input" class="global-form-label">
                                                        Appointment Time
                                                    </label>

                                                    <div class="global-control-wrap">
                                                        <i class="fa-regular fa-clock global-control-icon"
                                                            aria-hidden="true"></i>

                                                        <input type="text" id="existing_time_input"
                                                            class="form-input-custom global-control-with-icon js-flatpickr-time"
                                                            placeholder="Select time" readonly>
                                                    </div>

                                                    <p id="existingAppointmentTimeHint" class="field-help">
                                                        Select a date first, then enter or choose
                                                        the original appointment time.
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
                                                            name="procedure_duration_hms"
                                                            value="{{ old('procedure_duration_hms', $defaults['procedure_duration_hms'] ?? '') }}"
                                                            placeholder="HH:MM:SS" class="
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

                        <x-booking.service-step :services="$serviceTypes"
                            :selected="old('service_type', $defaults['service_type'] ?? '')"
                            title="Choose Dental Service"
                            subtitle="Select the dental service performed during this appointment." />

                        <x-booking.dental-history :questions="$dentalQuestions" mode="nested" :answers="$dentalAnswers"
                            :defaults="$defaults"
                            subtitle="Share the patient's past dental records, treatments, and dental concerns for a better assessment." />

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

                                    <x-booking.medical-history-fields :questions="$medicalQuestions"
                                        :diseases="$diseases" mode="nested" :answers="$medicalAnswers"
                                        :defaults="$defaults" :selected-diseases="$selectedDiseases"
                                        :is-female="$isFemalePatient" />

                                </div>

                            </div>
                        </div>

                        <div class="step-content hidden">
                            <div class="booking-step-shell">

                                <div id="summarySection">

                                    <div class="booking-step-header">
                                        <p class="booking-step-eyebrow">
                                            Step 5 of 5
                                        </p>

                                        <h2 class="booking-step-title">
                                            Review Before Odontogram
                                        </h2>

                                        <p class="booking-step-subtitle">
                                            Review the encoded appointment
                                            details before final confirmation.
                                        </p>
                                    </div>

                                    <div class="booking-step-body">
                                        <div id="existingAppointmentReviewGrid" class="space-y-4"></div>
                                    </div>

                                </div>


                                <div id="confirmationSection" class="hidden">

                                    <div class="booking-step-header">

                                        <p class="booking-step-eyebrow">
                                            Step 5 of 5
                                        </p>

                                        <h2 class="booking-step-title">
                                            Final Confirmation
                                        </h2>

                                        <p class="booking-step-subtitle">
                                            Confirm that the encoded
                                            appointment information is accurate
                                            before continuing to the odontogram.
                                        </p>

                                    </div>


                                    <div class="booking-step-body">

                                        <x-booking.final-confirmation
                                            message="Confirm that the encoded appointment details match the patient's actual visit record before continuing.">
                                            I have reviewed the encoded appointment
                                            information and confirm that it is accurate.
                                        </x-booking.final-confirmation>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <x-booking.navigation />

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
'disallowToday' => false,
'allowPastDates' => true,
'allowAllDates' => false,
'allowAllDatesExceptHolidays' => true,
'disableWeekends' => true,
'allowHolidaySelection' => false,
'useDynamicScheduleRules' => false,
'allowToggleOffDate' => true,
'historyMonths' => 180,
'maxFutureMonths' => 180,
'enableMonthYearShortcut' => true,
])
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const reviewGrid = document.getElementById('existingAppointmentReviewGrid');
        const timeField = document.getElementById('existing_time_input');
        const timeHint = document.getElementById('existingAppointmentTimeHint');
        const slotGridElement = document.getElementById('slotGrid');
        const timeInput = document.getElementById('appointment_time');
        const durationInput = document.getElementById('procedure_duration_hms');

        let bookingWorkflow = null;

        let step5ConfirmationActive =
            false;

        const summarySection =
            document.getElementById(
                'summarySection'
            );

        const confirmationSection =
            document.getElementById(
                'confirmationSection'
            );

        const finalConfirm =
            document.getElementById(
                'finalConfirm'
            );

        const existingAppointmentForm =
            document.getElementById(
                'existingAppointmentForm'
            );


        function showStep5Review() {
            step5ConfirmationActive =
                false;

            summarySection
                ?.classList.remove(
                    'hidden'
                );

            confirmationSection
                ?.classList.add(
                    'hidden'
                );

            bookingWorkflow
                ?.setNextButton({
                    label: 'Confirm Appointment',

                    icon: 'fa-chevron-right',
                });
        }

        function showStep5Confirmation() {
            step5ConfirmationActive =
                true;

            summarySection
                ?.classList.add(
                    'hidden'
                );

            confirmationSection
                ?.classList.remove(
                    'hidden'
                );

            bookingWorkflow
                ?.setNextButton({
                    label: 'Continue to Odontogram',

                    icon: 'fa-arrow-right',
                });
        }

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

                if (
                    shouldShow &&
                    radioName === 'medical_answers[tobacco_use]'
                ) {
                    box.querySelectorAll('[data-number-stepper]')
                        .forEach(input => {

                            if (!input.value) {
                                input.value = 1;
                            }

                        });
                }

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
                            field instanceof HTMLSelectElement
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

            const diseaseLabels =
                Array.from(
                    document.querySelectorAll(
                        'input[name="diseases[]"]:checked'
                    )
                ).map(
                    input =>
                        input
                            .nextElementSibling
                            ?.textContent
                            ?.trim()
                        || input.value
                );


            const diseaseTags =
                diseaseLabels.length
                    ? `
            <div class="booking-summary-tag-list">

                ${diseaseLabels
                        .map(
                            label => `
                            <span class="booking-summary-tag">
                                ${label}
                            </span>
                        `
                        )
                        .join('')}

            </div>
        `
                    : `
            <span class="booking-summary-muted">
                None selected
            </span>
        `;

            const row = (
                label,
                value
            ) => {
                const resolvedValue =
                    value &&
                        String(value).trim() !== ''
                        ? value
                        : `
                <span class="booking-summary-muted">
                    N/A
                </span>
            `;

                return `
        <p class="booking-summary-row">
            <span class="booking-summary-row-label">
                ${label}:
            </span>

            ${resolvedValue}
        </p>
    `;
            };

            const optionalRow = (
                label,
                value
            ) => {
                if (
                    !value ||
                    String(value).trim() === '' ||
                    value === 'N/A'
                ) {
                    return '';
                }

                return `
        <p class="booking-summary-row">
            <span class="booking-summary-row-label">
                ${label}:
            </span>

            ${value}
        </p>
    `;
            };

            const summaryCard = (
                title,
                icon,
                body
            ) => `
    <section class="booking-summary-card">

        <div class="booking-summary-card-header">
            <i class="fa-solid ${icon}"></i>

            <span>
                ${title}
            </span>
        </div>

        <div class="booking-summary-card-body">
            ${body}
        </div>

    </section>
`;

            const subSection = (
                title,
                body
            ) => `
    <section class="booking-summary-section">

        <div class="booking-summary-section-title">
            ${title}
        </div>

        <div class="booking-summary-section-body">

            <div
                class="
                    grid
                    grid-cols-2
                    gap-x-8
                    gap-y-1
                    sm-grid-1col
                "
            >
                ${body}
            </div>

        </div>

    </section>
`;

            const fullWidthSection = (
                title,
                body
            ) => `
    <section class="booking-summary-section">

        <div class="booking-summary-section-title">
            ${title}
        </div>

        <div class="booking-summary-section-body">
            ${body}
        </div>

    </section>
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

            ${fullWidthSection(
                "Medical Conditions",
                diseaseTags
            )}

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
                    timeHint.textContent =
                        'You can enter the original appointment time now, or select a date later to see suggested slots.';
                } else if (!hasDate) {
                    timeHint.textContent =
                        'Time saved. You can still select a date later to see suggested slots.';
                } else {
                    timeHint.textContent = 'Enter the original appointment time for this visit.';
                }
            }
        }

        timeField?.addEventListener(
            'change',
            function () {
                if (!timeInput) {
                    return;
                }

                const selected =
                    toTimeInputValue(
                        this.value
                    );

                timeInput.value =
                    selected;

                const matchingChip =
                    Array.from(
                        slotGridElement
                            ?.querySelectorAll(
                                '.slot-chip[data-time]'
                            ) || []
                    )
                        .find(
                            chip =>
                                toTimeInputValue(
                                    chip.dataset.time || ''
                                ) === selected
                        );

                if (matchingChip) {
                    matchingChip.click();
                    return;
                }

                const selectedSlotDisplay =
                    document.getElementById(
                        'selectedSlotDisplay'
                    );

                const selectedSlotText =
                    document.getElementById(
                        'selectedSlotText'
                    );

                if (
                    selected &&
                    selectedSlotDisplay &&
                    selectedSlotText
                ) {
                    selectedSlotText.textContent =
                        toDisplayTime(
                            selected
                        );

                    selectedSlotDisplay
                        .classList.remove(
                            'hidden'
                        );

                    selectedSlotDisplay.style.display =
                        'block';
                }
            }
        );

        durationInput?.addEventListener('input', function () {
            const formatted = formatDurationInput(this.value);
            this.value = formatted;
        });

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

        function validateCurrentStep(currentStep) {
            const currentPanel =
                bookingWorkflow
                    ?.getPanels()
                ?.[currentStep];

            if (!currentPanel) {
                return true;
            }

            if (
                currentStep === 0
            ) {
                const appointmentDate =
                    document.getElementById(
                        'appointment_date'
                    );

                const appointmentTime =
                    document.getElementById(
                        'appointment_time'
                    );

                const calendarGroup =
                    currentPanel.querySelector(
                        '.calendar-shell-no-card'
                    );

                const timeGroup =
                    document.getElementById(
                        'appointmentTimeField'
                    );

                if (
                    !appointmentDate?.value
                ) {
                    window.showGlobalGroupError?.(
                        calendarGroup,
                        'appointment_date',
                        'Please select the original appointment date.'
                    );

                    calendarGroup
                        ?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center',
                        });

                    return false;
                }

                window.clearGlobalGroupError?.(
                    calendarGroup,
                    'appointment_date'
                );

                if (
                    !appointmentTime?.value
                ) {
                    window.showGlobalGroupError?.(
                        timeGroup,
                        'appointment_time',
                        'Please select the original appointment time.'
                    );

                    timeGroup
                        ?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center',
                        });

                    return false;
                }

                window.clearGlobalGroupError?.(
                    timeGroup,
                    'appointment_time'
                );
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

        bookingWorkflow =
            window.BookingWorkflow?.create({
                panels: '#existingAppointmentForm > .step-content',

                progressFill: '#headerProgressFill',

                counter: '#stepCounterText',

                navContainer: '#navBtns',

                previousButton: '#prevBtn',

                nextButton: '#nextBtn',

                beforePrevious: currentStep => {
                    if (
                        currentStep === 4 &&
                        step5ConfirmationActive
                    ) {
                        showStep5Review();

                        return false;
                    }

                    return true;
                },

                beforeNext: currentStep => {
                    return validateCurrentStep(
                        currentStep
                    );
                },

                onLastStep: () => {
                    buildReview();
                    showStep5Review();
                },

                onLastStepNext: () => {
                    if (
                        !step5ConfirmationActive
                    ) {
                        showStep5Confirmation();

                        return true;
                    }

                    if (
                        !finalConfirm?.checked
                    ) {
                        window
                            .validateFormInputField?.(
                                finalConfirm
                            );

                        finalConfirm?.focus();

                        return false;
                    }

                    window.DiscardChanges
                        ?.markSubmitting(
                            existingAppointmentForm
                        );

                    existingAppointmentForm
                        ?.requestSubmit();

                    return true;
                },
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
    });
</script>
@endsection