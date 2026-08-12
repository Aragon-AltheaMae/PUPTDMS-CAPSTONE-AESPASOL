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
<main id="mainContent" class="booking-page page-enter">
    <div class="booking-page-inner">
        <x-booking.workflow-header :back-url="route('homepage')" back-label="Back to Home"
            form-target="#appointmentForm" icon="fa-regular fa-calendar-check" title="Book an Appointment"
            subtitle="Complete all five steps to schedule your dental visit." :steps="[
                'Date & Time',
                'Service',
                'Dental History',
                'Medical History',
                'Confirm',
            ]" />

        <div class="w-full">

            <div class="booking-workflow-card">
                <div>

                    <form id="appointmentForm" action="{{ route('book.appointment.store') }}" method="POST"
                        enctype="multipart/form-data" data-global-selects data-global-validation data-discard-form
                        data-discard-title="Discard appointment?"
                        data-discard-subtitle="You have unsaved appointment information."
                        data-discard-message="Leaving this page will remove the appointment details you entered. Do you want to discard your changes?">
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

                                        <div class="calendar-shell-no-card" data-global-field>
                                            <div id="calendarSkeletonContainer"></div>
                                        </div>

                                        <div class="time-panel flex flex-col is-empty" data-global-field>
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
                                                    class="ui-btn ui-btn-secondary ui-btn-sm hidden mt-4 mb-2 w-full">
                                                    <i class="fa-solid fa-xmark"></i>
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

                        <x-booking.service-step :services="$serviceTypes" title="Choose Your Dental Service"
                            subtitle="Select the type of service you want to book for your appointment." />

                        <x-booking.dental-history :questions="$dentalQuestions" mode="flat" :defaults="[]"
                            subtitle="Share your past dental records, treatments, and dental concerns for a better assessment." />

                        <div class="step-content hidden" id="step4">
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

                                    <x-booking.medical-history-fields :questions="$medicalQuestions"
                                        :diseases="$diseases" mode="standard" :defaults="[]"
                                        :selected-diseases="old('diseases', [])" :is-female="$isFemalePatient" />

                                    <x-booking.signature mode="patient" label="Patient's Signature" />
                                </div>
                            </div>
                        </div>

                        <div class="step-content hidden" id="step5">
                            <div class="booking-step-shell">
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


                                    <div class="booking-step-body">

                                        <x-booking.final-confirmation
                                            message="By submitting, you confirm that all the information provided is accurate and complete.">
                                            I have reviewed my dental and medical information
                                            and agree to the

                                            <a href="https://www.pup.edu.ph/privacy/" target="_blank"
                                                rel="noopener noreferrer" data-legal-link class="booking-legal-link">
                                                Privacy Policy
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            </a>

                                            and

                                            <a href="https://www.pup.edu.ph/terms/" target="_blank"
                                                rel="noopener noreferrer" data-legal-link class="booking-legal-link">
                                                Terms and Conditions
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            </a>.
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
</main>

<div id="introBookingModal" class="ui-modal" aria-hidden="true">

    <div class="ui-modal-card modal-md">

        <div class="modal-hd">
            <div class="modal-heading">

                <div class="modal-icon">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>

                <div class="modal-copy">
                    <h2 class="modal-title">
                        Let's get your dental appointment ready
                    </h2>

                    <p class="modal-subtitle">
                        Complete the required booking information
                        before submitting your appointment request.
                    </p>
                </div>

            </div>
        </div>

        <div class="modal-bd">

            <div class="booking-intro-steps">

                <div class="booking-intro-step">
                    <strong>1</strong>
                    <span>Date</span>
                </div>

                <div class="booking-intro-step">
                    <strong>2</strong>
                    <span>Service</span>
                </div>

                <div class="booking-intro-step">
                    <strong>3</strong>
                    <span>Dental</span>
                </div>

                <div class="booking-intro-step">
                    <strong>4</strong>
                    <span>Medical</span>
                </div>

                <div class="booking-intro-step">
                    <strong>5</strong>
                    <span>Confirm</span>
                </div>

            </div>

            <div class="booking-intro-checklist">

                <div class="booking-intro-item">
                    <div class="global-icon-box global-icon-box-sm">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <p>
                        Fill out all required fields marked with
                        <strong>*</strong>.
                    </p>
                </div>

                <div class="booking-intro-item">
                    <div class="global-icon-box global-icon-box-sm">
                        <i class="fa-solid fa-phone-volume"></i>
                    </div>

                    <p>
                        Prepare your emergency contact information.
                    </p>
                </div>

                <div class="booking-intro-item">
                    <div class="global-icon-box global-icon-box-sm">
                        <i class="fa-solid fa-signature"></i>
                    </div>

                    <p>
                        Upload or draw your patient signature
                        before confirmation.
                    </p>
                </div>

                <div class="booking-intro-item">
                    <div class="global-icon-box global-icon-box-sm">
                        <i class="fa-solid fa-list-check"></i>
                    </div>

                    <p>
                        Review your appointment information
                        before submitting.
                    </p>
                </div>

            </div>

        </div>

        <div class="modal-ft">

            <a href="{{ route('homepage') }}" class="ui-btn ui-btn-primary ui-btn-sm" data-discard-navigation
                data-discard-form-target="#appointmentForm">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Home
            </a>

            <button type="button" id="introContinueDraftBtn" class="hidden ui-btn ui-btn-secondary">

                <i class="fa-solid fa-clock-rotate-left"></i>
                Continue Draft
            </button>

            <button type="button" id="introStartBtn" class="ui-btn ui-btn-primary">

                <i class="fa-solid fa-play"></i>
                Begin Booking
            </button>

        </div>

    </div>
</div>

<x-booking.confirmed-modal id="confirmModal" eyebrow="Appointment Booking" title="Appointment Confirmed"
    subtitle="Your appointment has been successfully scheduled." header-icon="fa-check" section-icon="fa-calendar-check"
    section-eyebrow="Booking Status" section-title="Booking successfully completed"
    section-message="Your selected appointment schedule has been saved and confirmed." detail-label="Appointment Status"
    result-title="Confirmed" message-title="Schedule details" message-id="confirmMessage">
    Your dental appointment has been scheduled successfully.

    <x-slot:footer>

        <button type="button" id="okBtn" class="ui-btn ui-btn-primary">
            <i class="fa-solid fa-house"></i>
            Back to Home
        </button>

    </x-slot:footer>

</x-booking.confirmed-modal>

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

    let formIsDirty = false;
    let formSubmitting = false;

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
            step: bookingWorkflow?.getCurrentStep?.() ?? 0,
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

        form.querySelectorAll('select').forEach(select => {
            const wrapper = select.closest('.custom-select');

            if (
                wrapper &&
                typeof window.syncCustomSelect === 'function'
            ) {
                window.syncCustomSelect(wrapper);
            }
        });

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

    const summarySection =
        document.getElementById(
            'summarySection'
        );

    const confirmationSection =
        document.getElementById(
            'confirmationSection'
        );

    let bookingWorkflow = null;

    let step5ConfirmationActive =
        false;

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
                label:
                    'Confirm Appointment',

                icon:
                    'fa-chevron-right',
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
                label:
                    'Confirm Appointment',

                icon:
                    'fa-calendar-check',

                iconPosition:
                    'left',
            });
    }


    function resetStep5View() {
        showStep5Review();
    }

    function scrollToInvalidTarget(target) {
        if (!target) return;

        const block =
            target.closest('.custom-select') ||
            target.closest('.grid') ||
            target.closest('.ml-6') ||
            target.closest('.booking-section-card') ||
            target.closest('.voice-input-wrap') ||
            target.closest('.date-input-wrap') ||
            target;

        block.scrollIntoView({
            behavior: "smooth",
            block: "center"
        });

        const focusTarget =
            target.closest('.custom-select')
                ?.querySelector('.custom-select-button') ||
            target;

        if (
            typeof focusTarget.focus === 'function' &&
            !target.hasAttribute('readonly')
        ) {
            setTimeout(() => {
                focusTarget.focus({
                    preventScroll: true
                });
            }, 250);
        }
    }

    function isStepComplete(s) {
        const stepEl =
            bookingWorkflow
                ?.getPanels?.()
            ?.[s];

        if (!stepEl) {
            return true;
        }

        if (s === 0) {
            const dateInput =
                document.getElementById(
                    'appointment_date'
                );

            const timeInput =
                document.getElementById(
                    'appointment_time'
                );

            const calendarGroup =
                stepEl.querySelector(
                    '.calendar-shell-no-card'
                );

            const timeGroup =
                stepEl.querySelector(
                    '.time-panel'
                );

            if (!dateInput?.value) {
                window.showGlobalGroupError?.(
                    calendarGroup,
                    'appointment_date',
                    'Please select an appointment date.'
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

            if (!timeInput?.value) {
                window.showGlobalGroupError?.(
                    timeGroup,
                    'appointment_time',
                    'Please select an available time slot.'
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

        if (s === 1) {
            const serviceGroup =
                stepEl.querySelector(
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

                serviceGroup
                    ?.scrollIntoView({
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
                stepEl.querySelectorAll(
                    [
                        'input:not([type="hidden"])',
                        'textarea',
                        'select',
                    ].join(',')
                )
            ).filter(field => {
                return (
                    !field.disabled &&
                    field.type !== 'button' &&
                    field.type !== 'submit' &&
                    field.type !== 'file'
                );
            });

        const handledRadioGroups =
            new Set();

        let firstInvalid =
            null;

        for (const field of fields) {
            if (
                field.type === 'radio'
            ) {
                if (
                    handledRadioGroups.has(
                        field.name
                    )
                ) {
                    continue;
                }

                handledRadioGroups.add(
                    field.name
                );
            }

            const valid =
                window
                    .validateFormInputField?.(
                        field
                    ) ??
                field.checkValidity();

            if (
                !valid &&
                !firstInvalid
            ) {
                firstInvalid =
                    field;
            }
        }

        if (firstInvalid) {
            window
                .focusGlobalInvalidField?.(
                    firstInvalid
                );

            return false;
        }

        if (s === 3) {
            const signature =
                window.BookingSignature?.get(
                    stepEl
                );

            if (
                signature &&
                !signature.validate()
            ) {
                const signatureGroup =
                    stepEl.querySelector(
                        '[data-booking-signature]'
                    );

                signatureGroup
                    ?.scrollIntoView({
                        behavior:
                            'smooth',
                        block:
                            'center',
                    });

                return false;
            }
        }

        return true;
    }

    function initBookingWorkflow() {
        if (
            bookingWorkflow ||
            !window.BookingWorkflow
        ) {
            return;
        }

        bookingWorkflow =
            window.BookingWorkflow.create({
                panels:
                    '#appointmentForm > .step-content',

                progressFill:
                    '#headerProgressFill',

                counter:
                    '#stepCounterText',

                navContainer:
                    '#navBtns',

                previousButton:
                    '#prevBtn',

                nextButton:
                    '#nextBtn',

                hideNavigationOnLast:
                    false,

                beforePrevious:
                    currentStep => {
                        if (
                            currentStep === 4 &&
                            step5ConfirmationActive
                        ) {
                            showStep5Review();

                            return false;
                        }

                        return true;
                    },

                beforeNext:
                    currentStep => {
                        return isStepComplete(
                            currentStep
                        );
                    },

                onLastStep: () => {
                    buildSummary();
                    showStep5Review();
                },

                onLastStepNext: () => {
                    if (
                        !step5ConfirmationActive
                    ) {
                        showStep5Confirmation();

                        return true;
                    }

                    return confirmFinalAppointment();
                },

                onStepChange:
                    currentStep => {
                        if (
                            currentStep !== 3
                        ) {
                            return;
                        }

                        setTimeout(
                            () => {
                                window
                                    .BookingSignature
                                    ?.get(
                                        document
                                    )
                                    ?.resize();
                            },
                            120
                        );
                    },
            });
    }

    if (
        document.readyState ===
        'loading'
    ) {
        document.addEventListener(
            'DOMContentLoaded',
            initBookingWorkflow,
            {
                once: true
            }
        );
    } else {
        initBookingWorkflow();
    }

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

        const diseases =
            getAll(
                'diseases[]'
            );


        const diseaseLabels =
            diseases.map(
                code =>
                    diseaseLabelByCode?.[code]
                    ?? code
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

   ${fullWidthSection(
            "Medical Conditions",
            diseaseTags
        )}

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

    const finalConfirm =
        document.getElementById(
            'finalConfirm'
        );

    function confirmFinalAppointment() {
        if (
            !finalConfirm ||
            !finalConfirm.checked
        ) {
            showMiniTab(
                'Please confirm before submitting.'
            );

            finalConfirm?.focus();

            return false;
        }

        const date =
            document
                .getElementById(
                    'appointment_date'
                )
                ?.value ||
            'N/A';

        const time =
            document
                .getElementById(
                    'appointment_time'
                )
                ?.value ||
            'N/A';

        if (confirmMessage) {
            confirmMessage.innerHTML = `
        Your dental appointment is scheduled for
        <b>${date}</b> at <b>${time}</b>.<br>
        Please arrive on time and bring your
        school or office ID.
    `;
        }

        window.openModal?.(
            'confirmModal'
        );

        return true;
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

    document.getElementById('slotFullOkBtn')?.addEventListener('click', () => {
        const modal = document.getElementById('slotFullModal');
        if (modal) modal.close();
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
        const modal =
            document.getElementById(
                "introBookingModal"
            );

        const startBtn =
            document.getElementById(
                "introStartBtn"
            );

        const continueDraftBtn =
            document.getElementById(
                "introContinueDraftBtn"
            );

        if (!modal) return;

        const hasDraft =
            hasSavedDraft();

        continueDraftBtn?.classList.toggle(
            "hidden",
            !hasDraft
        );

        startBtn?.addEventListener(
            "click",
            () => {
                window.closeModal?.(
                    "introBookingModal"
                );
            }
        );

        continueDraftBtn?.addEventListener(
            "click",
            async () => {
                window.closeModal?.(
                    "introBookingModal"
                );

                await restoreDraft();

                showMiniTab(
                    "Saved draft loaded."
                );
            }
        );

        setTimeout(() => {
            if (
                window.__SESSION_EXPIRED__ ||
                modal.classList.contains("open")
            ) {
                return;
            }

            window.openModal?.(
                "introBookingModal"
            );
        }, 350);
    }

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
        document.querySelectorAll(".global-question-text").forEach(q => {
            const row = q.closest(".global-question-row");
            const hasRequiredRadio = row?.querySelector("input[required]");

            if (hasRequiredRadio && !q.querySelector(".required-mark")) {
                const star = document.createElement("span");
                star.className = "required-mark";
                star.textContent = " *";
                q.appendChild(star);
            }
        });

        document.querySelectorAll(
            "input[required], select[required], textarea[required]"
        ).forEach(input => {
            if (
                input.tagName === "INPUT" &&
                (
                    input.type === "hidden" ||
                    input.type === "radio" ||
                    input.type === "checkbox"
                )
            ) {
                return;
            }

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

            if (label && !label.querySelector(".required-mark")) {
                const star = document.createElement("span");
                star.className = "required-mark";
                star.textContent = " *";
                label.appendChild(star);
            }


        });
    });
</script>
@endsection