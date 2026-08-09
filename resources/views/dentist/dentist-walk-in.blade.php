@extends('layouts.app')

@section('layout-role', 'dentist')

@section('hide-sidebar')
@endsection

@section('title', 'Walk-in Appointment')

@section('content')

<main id="mainContent" class="booking-page page-enter">
    <div class="booking-page-inner">
        <x-booking.workflow-header :back-url="route('dentist.dentist.appointments')" back-label="Back to Appointments"
            form-target="#appointmentForm" icon="fa-solid fa-person-walking-arrow-right" title="Walk-in Patient Intake"
            subtitle="Register or select the patient, complete the clinical history, and prepare the patient for treatment."
            :steps="['Patient', 'Service', 'Dental History', 'Medical History', 'Start Procedure']" />

        <div class="w-full">

            <div class="booking-workflow-card">

                <div>

                    <form id="appointmentForm" action="{{ route('dentist.walk-in.start') }}" method="POST"
                        enctype="multipart/form-data" data-global-selects data-global-validation data-discard-form
                        data-discard-title="Discard walk-in intake?"
                        data-discard-subtitle="You have unsaved walk-in information."
                        data-discard-message="Leaving this page will remove the information you entered. Do you want to discard your changes?">

                        <input type="hidden" name="patient_id" id="selectedPatientId">
                        <input type="hidden" name="patient_mode" id="patientMode" value="existing">
                        @csrf

                        <div class="step-content hidden">
                            <div class="booking-step-shell walkin-step1-layout" id="patientAccountSection">
                                <div class="booking-step-header">
                                    <p class="booking-step-eyebrow">
                                        <i class="fa-solid fa-user-plus text-[11px] mr-1"></i>
                                        Step 1 of 5
                                    </p>

                                    <h2 class="booking-step-title">Patient account</h2>

                                    <p class="booking-step-subtitle">
                                        Search an existing student, faculty, or administrative patient, or create a
                                        guest account for walk-in onboarding.
                                    </p>
                                </div>

                                <div class="booking-step-body">
                                    <div class="booking-section-card" data-global-field data-walkin-patient-group>
                                        <p class="booking-section-card-title">
                                            <i class="fa-solid fa-user-magnifying-glass text-xs"></i>
                                            Select or create patient
                                            <span class="booking-section-card-title-line"></span>
                                        </p>

                                        <div class="account-tabs">
                                            <button type="button" class="account-tab active" data-tab="existing">
                                                <i class="fa-solid fa-database text-[13px]"></i>
                                                Existing / Unified DB
                                            </button>

                                            <button type="button" class="account-tab" data-tab="guest">
                                                <i class="fa-solid fa-user-plus text-[13px]"></i>
                                                Guest onboarding
                                            </button>
                                        </div>

                                        <div class="tab-panel active" id="existingPanel">

                                            <div class="patient-picker-toolbar">

                                                <x-search-bar id="patientSearch"
                                                    placeholder="Search by name, ID, or email..."
                                                    callback="handleWalkInPatientSearch" :debounce="350"
                                                    clear-label="Clear patient search" class="patient-picker-search" />

                                                <div class="global-page-size-control">
                                                    <label for="patientPageSize">
                                                        Show
                                                    </label>

                                                    <div class="global-page-size-select" data-global-page-size
                                                        data-page-size-input="#patientPageSize"
                                                        data-page-size-callback="handleWalkInPatientPerPageChange">

                                                        <select id="patientPageSize" class="global-page-size-native"
                                                            tabindex="-1" aria-hidden="true">

                                                            <option value="10" selected>10</option>
                                                            <option value="20">20</option>
                                                            <option value="50">50</option>
                                                            <option value="100">100</option>
                                                        </select>

                                                        <button type="button" class="global-page-size-trigger"
                                                            data-page-size-trigger aria-haspopup="listbox"
                                                            aria-expanded="false">

                                                            <span data-page-size-value>10</span>

                                                            <i class="fa-solid fa-chevron-down"></i>
                                                        </button>

                                                        <div class="global-page-size-menu" role="listbox">

                                                            @foreach ([10, 20, 50, 100] as $size)
                                                            <button type="button"
                                                                class="global-page-size-option {{ $size === 10 ? 'is-selected' : '' }}"
                                                                data-page-size-option data-value="{{ $size }}"
                                                                role="option"
                                                                aria-selected="{{ $size === 10 ? 'true' : 'false' }}">

                                                                <span>{{ $size }}</span>
                                                                <i class="fa-solid fa-check"></i>
                                                            </button>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <span>entries</span>
                                                </div>

                                            </div>

                                            <x-pagination-bar id="patientPaginationTopBar" info-id="patientEntriesInfo"
                                                pagination-id="patientPaginationTop" position="top" label="patients"
                                                hidden />

                                            <div id="patientResults" class="mt-5 mb-5" aria-live="polite"></div>

                                            <x-pagination-bar id="patientPaginationBar"
                                                info-id="patientEntriesInfoBottom" pagination-id="patientPagination"
                                                position="bottom" label="patients" hidden />
                                        </div>
                                        <div class="tab-panel" id="guestPanel">
                                            <div class="guest-fields-grid">

                                                <div class="global-form-group" data-global-field>
                                                    <label class="global-form-label" for="guestName">
                                                        Guest Full Name
                                                        <span class="required-mark">*</span>
                                                    </label>

                                                    <input type="text" id="guestName" name="guest_name"
                                                        class="form-input-custom" placeholder="Enter guest full name"
                                                        autocomplete="off" disabled>
                                                </div>

                                                <div class="walkin-two-col">

                                                    <div class="global-form-group" data-global-field>
                                                        <label class="global-form-label" for="guestEmail">
                                                            Email
                                                            <span class="field-optional">(Optional)</span>
                                                        </label>

                                                        <input type="email" id="guestEmail" name="guest_email"
                                                            data-required-message="Please enter a valid email address."
                                                            class="form-input-custom" placeholder="Enter email address"
                                                            autocomplete="email" disabled>
                                                    </div>

                                                    <div class="global-form-group" data-global-field>
                                                        <label class="global-form-label" for="guestPhone">
                                                            Phone
                                                            <span class="field-optional">(Optional)</span>
                                                        </label>

                                                        <input type="text" id="guestPhone" name="guest_phone"
                                                            class="form-input-custom" placeholder="09xx xxx xxxx"
                                                            autocomplete="tel" inputmode="numeric" disabled>
                                                    </div>

                                                </div>
                                            </div>

                                            <button type="button" id="createGuestBtn" class="ui-btn ui-btn-primary">

                                                <i class="fa-solid fa-user-plus"></i>
                                                Create guest account
                                            </button>
                                        </div>
                                        <div class="selected-patient-box" id="selectedPatientBox" hidden>

                                            <span>
                                                <i class="fa-solid fa-circle-check text-[11px] mr-1"></i>
                                                Selected patient
                                            </span>

                                            <strong id="selectedPatientName"></strong>

                                            <small id="selectedPatientMeta"></small>

                                            <button type="button" id="clearSelectedPatientBtn"
                                                class="ui-btn ui-btn-secondary ui-btn-sm">

                                                <i class="fa-solid fa-xmark"></i>
                                                <span>Clear Selection</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <x-booking.service-step :services="$serviceTypes" title="Choose Your Dental Service"
                            subtitle="Select the type of service for this walk-in appointment." />

                        <x-booking.dental-history :questions="$dentalQuestions" mode="flat" :defaults="[]"
                            subtitle="Record the patient's dental history before starting the procedure." />

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
                                    <x-booking.medical-history-fields :questions="$medicalQuestions"
                                        :diseases="$diseases" mode="standard" :defaults="[]"
                                        :selected-diseases="old('diseases', [])" :dynamic-female="true" />

                                    <x-booking.signature mode="draw-only" label="Patient's Signature"
                                        draw-title="Draw the patient's signature here"
                                        draw-help="Use the drawing tablet, mouse, touch, or stylus." />
                                </div>
                            </div>
                        </div>

                        <div class="step-content hidden">
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

                                    <div class="booking-review-navigation">
                                        <button type="button" id="summaryBackBtn" class="ui-btn ui-btn-secondary">
                                            <i class="fa-solid fa-chevron-left"></i>
                                            Back
                                        </button>
                                        <button type="button" id="goToConfirmationBtn" class="ui-btn ui-btn-primary">
                                            Proceed
                                            <i class="fa-solid fa-chevron-right"></i>
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

                                    <div class="booking-section-card mb-2">
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
                                            <input id="finalConfirm" type="checkbox" class="global-checkbox-input"
                                                required>
                                            <span class="text-sm text-[#1a1410] leading-relaxed">
                                                I have reviewed my dental and medical information and I accept the
                                                <a href="/privacy-policy"
                                                    class="text-[#8B0000] hover:underline font-semibold">Privacy
                                                    Policy</a>
                                                and
                                                <a href="/terms-of-service"
                                                    class="text-[#8B0000] hover:underline font-semibold">Terms of
                                                    Service</a>.
                                            </span>
                                        </label>
                                    </div>

                                    <div class="booking-review-navigation">
                                        <button type="button" id="confirmBackBtn" class="ui-btn ui-btn-secondary">
                                            <i class="fa-solid fa-chevron-left"></i>
                                            Back
                                        </button>
                                        <button type="submit" id="finalSubmitBtn" class="ui-btn ui-btn-primary">
                                            <i class="fa-solid fa-play"></i>
                                            <span>Start Procedure</span>
                                        </button>
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
                    <i class="fa-solid fa-person-walking-arrow-right"></i>
                </div>

                <div class="modal-copy">
                    <h2 class="modal-title">
                        Prepare the walk-in patient for treatment
                    </h2>

                    <p class="modal-subtitle">
                        Complete the patient intake, service selection,
                        clinical history, and signature before starting
                        the procedure.
                    </p>
                </div>
            </div>
        </div>

        <div class="modal-bd">
            <div class="booking-intro-steps">
                <div class="booking-intro-step">
                    <strong>1</strong>
                    <span>Patient</span>
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
                    <span>Start</span>
                </div>
            </div>

            <div class="booking-intro-checklist">

                <div class="booking-intro-item">
                    <div class="global-icon-box global-icon-box-sm">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <p>
                        Select an existing patient or create a guest
                        record for today's walk-in visit.
                    </p>
                </div>

                <div class="booking-intro-item">
                    <div class="global-icon-box global-icon-box-sm">
                        <i class="fa-solid fa-tooth"></i>
                    </div>

                    <p>
                        Choose the requested dental service and complete
                        the patient's dental and medical history.
                    </p>
                </div>

                <div class="booking-intro-item">
                    <div class="global-icon-box global-icon-box-sm">
                        <i class="fa-solid fa-signature"></i>
                    </div>

                    <p>
                        Ask the patient to review the information and
                        provide a drawn signature.
                    </p>
                </div>

                <div class="booking-intro-item">
                    <div class="global-icon-box global-icon-box-sm">
                        <i class="fa-solid fa-list-check"></i>
                    </div>

                    <p>
                        Verify the intake summary before starting the
                        dental procedure.
                    </p>
                </div>
            </div>
        </div>

        <div class="modal-ft">
            <a href="{{ route('dentist.dentist.appointments') }}" class="ui-btn ui-btn-primary ui-btn-sm"
                data-discard-navigation data-discard-form-target="#appointmentForm">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Appointments
            </a>

            <button type="button" id="introContinueDraftBtn" class="hidden ui-btn ui-btn-secondary">
                <i class="fa-solid fa-clock-rotate-left"></i>
                Continue Draft
            </button>

            <button type="button" id="introStartBtn" class="ui-btn ui-btn-primary">
                <i class="fa-solid fa-play"></i>
                Begin Walk-in Intake
            </button>
        </div>
    </div>
</div>

<div id="confirmModal" class="ui-modal" aria-hidden="true">
    <div class="ui-modal-card modal-md">
        <div class="modal-hd appointment-modal-header">
            <div class="flex items-center gap-3 min-w-0">
                <div class="appointment-modal-header-icon">
                    <i class="fa-solid fa-check"></i>
                </div>

                <div class="appointment-modal-header-copy">
                    <span class="appointment-modal-eyebrow">
                        Walk-in Appointment
                    </span>

                    <h2 class="appointment-modal-title">
                        Appointment Confirmed
                    </h2>

                    <p class="appointment-modal-subtitle">
                        The walk-in intake was saved successfully.
                    </p>
                </div>
            </div>
            <button type="button" class="ui-btn ui-btn-secondary" onclick="closeModal('confirmModal')">
                <i class="fa-solid fa-xmark"></i>
                Close
            </button>
        </div>

        <div class="modal-bd">
            <div class="global-confirm-alert">
                <i class="fa-solid fa-circle-check"></i>
                <div>
                    <strong>Ready to begin treatment</strong>

                    <p id="confirmMessage">
                        The walk-in appointment was recorded successfully.
                    </p>
                </div>
            </div>
        </div>

        <div class="modal-ft">
            <button type="button" class="ui-btn ui-btn-secondary" onclick="closeModal('confirmModal')">
                <i class="fa-solid fa-xmark"></i>
                Close
            </button>
            <button type="button" id="okBtn" class="ui-btn ui-btn-primary">
                <i class="fa-solid fa-play"></i>
                Start Procedure
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    const diseaseLabelByCode = @json($diseases -> pluck('label', 'code'));
    const DRAFT_KEY = "dentistWalkInDraft:v1";

    let selectedWalkInPatient = null;
    let formIsDirty = false;
    let formSubmitting = false;
    let pendingNavigation = null;

    const accountTabs = document.querySelectorAll(".account-tab");
    const existingPanel = document.getElementById("existingPanel");
    const guestPanel = document.getElementById("guestPanel");

    const patientSearch = document.getElementById("patientSearch");
    const patientResults = document.getElementById("patientResults");

    const selectedPatientId = document.getElementById("selectedPatientId");
    const patientModeInput = document.getElementById("patientMode");
    const selectedPatientBox = document.getElementById("selectedPatientBox");
    const selectedPatientName = document.getElementById("selectedPatientName");
    const selectedPatientMeta = document.getElementById("selectedPatientMeta");
    const clearSelectedPatientBtn = document.getElementById("clearSelectedPatientBtn");

    const createGuestBtn = document.getElementById("createGuestBtn");
    const guestName = document.getElementById("guestName");
    const guestEmail = document.getElementById("guestEmail");
    const guestPhone = document.getElementById("guestPhone");
    const walkInPatientGroup = document.querySelector('[data-walkin-patient-group]');

    function setGuestFieldsEnabled(enabled) {
        [guestName, guestEmail, guestPhone].forEach(input => {
            if (!input) return;

            input.disabled = !enabled;

            if (!enabled) {
                input.required = false;
                input.value = "";
                window.clearFormInputValidation?.(
                    input
                );
            }
        });

        if (guestName) {
            guestName.required = enabled;
        }
    }

    [guestName, guestEmail, guestPhone].forEach(input => {
        input?.addEventListener("input", () => {
            if (
                patientModeInput?.value === "guest" &&
                selectedPatientId?.value
            ) {
                clearSelectedPatientUI({
                    clearSearch: false,
                    reloadPatients: false,
                });
            }
        });
    });

    const forWomenSection =
        document.getElementById(
            "forWomenSection"
        );

    const nonFemaleDefaults =
        document.getElementById(
            "nonFemaleDefaults"
        );

    const womenFieldNames = [
        "pregnant",
        "nursing",
        "birth_control",
    ];

    function normalizePatientGender(
        gender
    ) {
        return String(gender || "")
            .trim()
            .toLowerCase();
    }

    function isFemaleGender(
        gender
    ) {
        const normalizedGender =
            normalizePatientGender(
                gender
            );

        return [
            "female",
            "f",
            "woman",
        ].includes(
            normalizedGender
        );
    }

    function updateWomenSection(
        gender
    ) {
        const showWomenSection =
            isFemaleGender(
                gender
            );

        forWomenSection
            ?.classList.toggle(
                "hidden",
                !showWomenSection
            );

        if (nonFemaleDefaults) {
            nonFemaleDefaults.hidden =
                showWomenSection;

            nonFemaleDefaults
                .querySelectorAll("input")
                .forEach(input => {
                    input.disabled =
                        showWomenSection;
                });
        }

        womenFieldNames.forEach(name => {
            const radios =
                document.querySelectorAll(
                    `input[type="radio"][name="${name}"]`
                );

            radios.forEach((radio, index) => {
                radio.disabled = !showWomenSection;

                radio.required =
                    showWomenSection &&
                    index === 0;

                if (!showWomenSection) {
                    radio.checked = false;

                    window
                        .clearFormInputValidation?.(
                            radio
                        );
                }
            });
        });
    }

    function clearSelectedPatientUI({
        clearSearch = true,
        reloadPatients = true,
        markDirty = true,
    } = {}) {

        selectedWalkInPatient = null;
        updateWomenSection(null);

        if (selectedPatientId) {
            selectedPatientId.value = "";
        }

        if (selectedPatientName) {
            selectedPatientName.textContent = "";
        }

        if (selectedPatientMeta) {
            selectedPatientMeta.textContent = "";
        }

        selectedPatientBox?.setAttribute(
            "hidden",
            "hidden"
        );

        document
            .querySelectorAll(
                ".patient-record-card"
            )
            .forEach(card => {
                card.classList.remove(
                    "is-selected"
                );

                const checkbox =
                    card.querySelector(
                        ".patient-card-checkbox"
                    );

                if (checkbox) {
                    checkbox.checked = false;
                }
            });

        if (clearSearch && patientSearch) {
            patientSearch.value = "";

            window.syncInputClearButton?.(
                patientSearch
            );
        }

        window.clearGlobalGroupError?.(
            document.querySelector(
                "[data-walkin-patient-group]"
            ),
            "walkin-patient"
        );

        if (reloadPatients) {
            patientCurrentPage = 1;

            loadPatients("", true);
        }

        if (markDirty) {
            markFormDirty();
        }
    }

    clearSelectedPatientBtn
        ?.addEventListener(
            "click",
            () => {
                clearSelectedPatientUI({
                    clearSearch: true,
                    reloadPatients: true,
                });

                patientSearch?.focus();
            }
        );

    function setPatientMode(mode, shouldClearSelected = false) {
        const normalizedMode = mode === "guest" ? "guest" : "existing";
        const isGuest = normalizedMode === "guest";

        if (patientModeInput) {
            patientModeInput.value = normalizedMode;
        }

        accountTabs.forEach(item => {
            item.classList.toggle("active", item.dataset.tab === normalizedMode);
        });

        existingPanel?.classList.toggle("active", !isGuest);
        guestPanel?.classList.toggle("active", isGuest);

        setGuestFieldsEnabled(isGuest);

        if (isGuest && shouldClearSelected) {
            clearSelectedPatientUI({
                clearSearch: false,
                reloadPatients: false,
            });
        }

        if (!isGuest) {
            [guestName, guestEmail, guestPhone].forEach(input => {
                if (input) input.value = "";
            });
        }
    }

    function selectWalkInPatient(patient) {
        selectedWalkInPatient = {
            ...patient,
            mode: "existing",
        };

        updateWomenSection(
            patient.gender
        );

        setPatientMode("existing", false);

        if (selectedPatientId) {
            selectedPatientId.value = patient.id;
        }

        if (selectedPatientName) {
            selectedPatientName.textContent = patient.name || "Unnamed Patient";
        }

        if (selectedPatientMeta) {
            selectedPatientMeta.textContent =
                `${patient.type || "Patient"}${patient.email ? " - " + patient.email : ""}`;
        }

        selectedPatientBox?.removeAttribute("hidden");

        [guestName, guestEmail, guestPhone].forEach(input => {
            if (input) input.value = "";
        });

        markFormDirty();

        window.clearGlobalGroupError?.(
            document.querySelector(
                "[data-walkin-patient-group]"
            ),
            "walkin-patient"
        );

        requestAnimationFrame(() => {
            selectedPatientBox?.scrollIntoView({
                behavior: "smooth",
                block: "center",
            });
        });
    }

    function selectGuestPatient(shouldProceed = true) {
        const name = guestName?.value?.trim() || "";
        const email = guestEmail?.value?.trim() || "";
        const phone = guestPhone?.value?.trim() || "";

        if (!name) {
            window.validateFormInputField?.(
                guestName
            );

            window.focusGlobalInvalidField?.(
                guestName
            );
            return false;
        }

        window.clearFormInputValidation?.(guestName);

        selectedWalkInPatient = {
            id: null,
            mode: "guest",
            name,
            email,
            phone,
            type: "Guest Patient",
        };

        updateWomenSection(null);

        if (selectedPatientId) {
            selectedPatientId.value = "";
        }

        if (patientModeInput) {
            patientModeInput.value = "guest";
        }

        if (selectedPatientName) {
            selectedPatientName.textContent = name;
        }

        if (selectedPatientMeta) {
            const metaParts = ["Guest Patient", email, phone].filter(Boolean);
            selectedPatientMeta.textContent = metaParts.join(" - ");
        }

        selectedPatientBox?.removeAttribute("hidden");
        markFormDirty();

        if (shouldProceed) {
            showMiniTab("Guest patient details saved.");
        }

        return true;
    }

    async function createGuestPatientOnServer() {
        if (!selectGuestPatient(false)) {
            return false;
        }

        const token = document.querySelector('input[name="_token"]')?.value || "";
        const payload = new FormData();
        payload.append("guest_name", guestName?.value?.trim() || "");
        payload.append("guest_email", guestEmail?.value?.trim() || "");
        payload.append("guest_phone", guestPhone?.value?.trim() || "");

        if (createGuestBtn) {
            createGuestBtn.disabled = true;
            createGuestBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Creating guest account`;
        }

        try {
            const response = await fetch(`{{ route('dentist.walk-in.guest.store') }}`, {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token,
                },
                body: payload,
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok || !data?.success || !data?.patient?.id) {
                throw new Error(data?.message || "Unable to create guest patient.");
            }

            selectedWalkInPatient = {
                ...data.patient,
                mode: "guest",
                type: data.patient.type || "Guest",
            };

            updateWomenSection(
                data.patient.gender
            );

            if (selectedPatientId) {
                selectedPatientId.value = data.patient.id;
            }

            if (selectedPatientName) {
                selectedPatientName.textContent = data.patient.name || guestName?.value?.trim() || "Guest Patient";
            }

            if (selectedPatientMeta) {
                const metaParts = [
                    data.patient.type || "Guest",
                    data.patient.email || guestEmail?.value?.trim(),
                    guestPhone?.value?.trim(),
                ].filter(Boolean);
                selectedPatientMeta.textContent = metaParts.join(" - ");
            }

            selectedPatientBox?.removeAttribute("hidden");
            showMiniTab("Guest account created.");
            markFormDirty();
            return true;
        } catch (error) {
            showMiniTab(error.message || "Unable to create guest account. Please try again.");
            return false;
        } finally {
            if (createGuestBtn) {
                createGuestBtn.disabled = false;
                createGuestBtn.innerHTML = `<i class="fa-solid fa-user-plus"></i> Create guest account`;
            }
        }
    }

    setPatientMode("existing");

    accountTabs.forEach(tab => {
        tab.addEventListener("click", function () {
            setPatientMode(this.dataset.tab, true);
            markFormDirty();
        });
    });

    createGuestBtn?.addEventListener("click", () => {
        setPatientMode("guest", false);
        createGuestPatientOnServer();
    });

    let patientCurrentPage = 1;
    let patientPageSize = 10;

    let patientPaginationMeta = {
        currentPage: 1,
        lastPage: 1,
        total: 0,
        from: null,
        to: null,
    };

    const patientEntriesInfo =
        document.getElementById(
            'patientEntriesInfo'
        );

    const patientEntriesInfoBottom =
        document.getElementById(
            'patientEntriesInfoBottom'
        );

    const patientPaginationTopBar =
        document.getElementById(
            'patientPaginationTopBar'
        );

    const patientPaginationTop =
        document.getElementById(
            'patientPaginationTop'
        );

    const patientPaginationBar =
        document.getElementById(
            'patientPaginationBar'
        );

    const patientPagination =
        document.getElementById(
            'patientPagination'
        );

    function buildWalkInPatientSkeletons(
        count = patientPageSize
    ) {
        const skeletonCount =
            Math.min(
                Math.max(
                    Number(count) || 10,
                    4
                ),
                12
            );

        const cards =
            Array
                .from({
                    length: skeletonCount
                },
                    () => `
                    <div
                        class="
                            table-record-card
                            skeleton-shell
                            p-4
                        "
                        aria-hidden="true"
                    >
                        <div
                            class="
                                flex
                                items-start
                                gap-3
                            "
                        >
                            <div
                                class="
                                    skeleton-circle
                                    w-[54px]
                                    h-[54px]
                                    flex-shrink-0
                                "
                            ></div>

                            <div
                                class="
                                    flex-1
                                    min-w-0
                                "
                            >
                                <div
                                    class="
                                        skeleton-line
                                        h-4
                                        w-3/5
                                        mb-3
                                    "
                                ></div>

                                <div
                                    class="
                                        skeleton-pill
                                        h-5
                                        w-20
                                        mb-4
                                    "
                                ></div>

                                <div
                                    class="
                                        skeleton-line
                                        h-3
                                        w-2/3
                                        mb-2
                                    "
                                ></div>

                                <div
                                    class="
                                        skeleton-line
                                        h-3
                                        w-4/5
                                    "
                                ></div>
                            </div>
                        </div>
                    </div>
                `
                )
                .join('');

        return `
    <div
        class="
            table-record-grid
            patient-record-grid
            gap-5
        "
    >
            ${cards}
        </div>
    `;
    }

    function renderWalkInPatientSkeletons() {
        if (!patientResults) {
            return;
        }

        window.EmptyState?.hide(
            patientResults
        );

        patientResults.innerHTML =
            buildWalkInPatientSkeletons();
    }

    function safePatientText(value) {
        return String(value ?? "")
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");
    }

    function renderPatientPagination() {
        window.renderGlobalPagination?.({
            ...patientPaginationMeta,

            containers: [
                patientPaginationTop,
                patientPagination,
            ],

            bars: [
                patientPaginationTopBar,
                patientPaginationBar,
            ],

            infoElements: [
                patientEntriesInfo,
                patientEntriesInfoBottom,
            ],

            itemLabel: 'patients',

            onPageChange(page) {
                patientCurrentPage =
                    page;

                const query =
                    patientSearch
                        ?.value
                        .trim() || '';

                loadPatients(
                    query,
                    query === ''
                );

                patientResults
                    ?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start',
                    });
            },
        });
    }

    function createPatientCard(patient) {
        const card =
            document.createElement(
                'div'
            );

        card.setAttribute(
            'role',
            'button'
        );

        card.setAttribute(
            'tabindex',
            '0'
        );

        card.setAttribute(
            'aria-pressed',
            'false'
        );

        card.className = [
            'card',
            'table-record-card',
            'patient-record-card',
        ].join(' ');

        card.dataset.patientId =
            patient.id;

        const patientName =
            patient.name ||
            'Unnamed Patient';

        const patientType =
            patient.type ||
            'Patient';

        const roleClass =
            window.PatientUI
                ?.getRoleClass(
                    patientType
                ) ||
            'role-none';

        const patientEmail =
            patient.email || '';

        const studentNumber =
            patient.student_number || '';

        const program =
            patient.program || '';

        const avatarUrl =
            window.PatientUI
                ?.safeUrl(
                    patient.avatar_url
                ) || '';

        card.innerHTML = `
        <span class="patient-avatar patient-avatar-md">
    ${avatarUrl
                ? `
                                    <img
                                        src="${safePatientText(
                    avatarUrl
                )}"
                                        alt="${safePatientText(
                    patientName
                )}"
                                        loading="lazy"
                                    >
                                `
                : `
                                    <span>
                                        ${safePatientText(
                    window.PatientUI
                        ?.getInitials(
                            patientName
                        ) || 'P'
                )}
                                    </span>
                                `
            }
</span>

        <span class="patient-card-content">
            <span class="patient-card-header">
                <strong class="patient-card-name">
                    ${safePatientText(
                patientName
            )}
                </strong>

                <span class="badge-role ${roleClass}">
    ${safePatientText(patientType)}
</span>
            </span>

            <span class="patient-card-meta">
                ${studentNumber
                ? `
                                                    <span>
                                                        <i class="fa-solid fa-id-card"></i>
                                                        ${safePatientText(
                    studentNumber
                )}
                                                    </span>
                                                `
                : ''
            }

                ${program
                ? `
                                                    <span>
                                                        <i class="fa-solid fa-graduation-cap"></i>
                                                        ${safePatientText(
                    program
                )}
                                                    </span>
                                                `
                : ''
            }

                ${patientEmail
                ? `
                                                    <span>
                                                        <i class="fa-solid fa-envelope"></i>
                                                        ${safePatientText(
                    patientEmail
                )}
                                                    </span>
                                                `
                : ''
            }
            </span>

            <label
    class="patient-card-checkbox-wrap"
    aria-label="Select ${safePatientText(patientName)}"
>
    <input
        type="checkbox"
        class="patient-card-checkbox global-checkbox-input"
        aria-label="Select ${safePatientText(patientName)}"
    >
</label>
    `;

        const patientCheckbox =
            card.querySelector(
                '.patient-card-checkbox'
            );

        if (
            String(selectedPatientId?.value) ===
            String(patient.id)
        ) {
            card.classList.add(
                'is-selected'
            );

            if (patientCheckbox) {
                patientCheckbox.checked = true;
            }
        }

        function isThisPatientSelected() {
            return (
                String(
                    selectedPatientId?.value || ''
                ) ===
                String(
                    patient.id || ''
                )
            );
        }

        function syncCardSelectionState(
            selected
        ) {
            card.classList.toggle(
                'is-selected',
                selected
            );

            card.setAttribute(
                'aria-pressed',
                selected ?
                    'true' :
                    'false'
            );

            if (patientCheckbox) {
                patientCheckbox.checked =
                    selected;
            }
        }

        function clearOtherPatientCards() {
            document
                .querySelectorAll(
                    '.patient-record-card'
                )
                .forEach(item => {
                    if (item === card) {
                        return;
                    }

                    item.classList.remove(
                        'is-selected'
                    );

                    item.setAttribute(
                        'aria-pressed',
                        'false'
                    );

                    const checkbox =
                        item.querySelector(
                            '.patient-card-checkbox'
                        );

                    if (checkbox) {
                        checkbox.checked = false;
                    }
                });
        }

        function selectThisPatient() {
            clearOtherPatientCards();

            selectWalkInPatient(
                patient
            );

            syncCardSelectionState(
                true
            );
        }

        function unselectThisPatient() {
            clearSelectedPatientUI({
                clearSearch: false,
                reloadPatients: false,
            });

            syncCardSelectionState(
                false
            );
        }

        function togglePatientSelection() {
            if (
                isThisPatientSelected()
            ) {
                unselectThisPatient();
                return;
            }

            selectThisPatient();
        }

        syncCardSelectionState(
            isThisPatientSelected()
        );

        card.addEventListener('click', event => {
            if (event.target.closest('.patient-card-checkbox-wrap')) {
                return;
            }
            togglePatientSelection();
        });

        card.addEventListener('keydown', event => {
            if (event.key !== 'Enter' && event.key !== ' ') {
                return;
            }
            event.preventDefault();
            togglePatientSelection();
        });

        patientCheckbox?.addEventListener('click', event => {
            event.stopPropagation();
            event.preventDefault();
            togglePatientSelection();
        });
        return card;
    }

    function renderPatients(responseData) {
        const patients =
            Array.isArray(responseData) ?
                responseData :
                Array.isArray(responseData?.data) ?
                    responseData.data : [];

        const isPaginatedResponse = !Array.isArray(responseData);

        patientPaginationMeta = {
            currentPage: isPaginatedResponse ?
                Number(responseData?.current_page) || 1 : 1,

            lastPage: isPaginatedResponse ?
                Number(responseData?.last_page) || 1 : 1,

            total: isPaginatedResponse ?
                Number(responseData?.total) || patients.length : patients.length,

            from: isPaginatedResponse ?
                responseData?.from ?? null : patients.length ?
                    1 : null,

            to: isPaginatedResponse ?
                responseData?.to ?? null : patients.length,
        };

        patientCurrentPage =
            patientPaginationMeta.currentPage;

        if (!patients.length) {
            const query =
                patientSearch
                    ?.value
                    .trim() || '';

            patientResults.innerHTML = '';

            if (query) {
                window.EmptyState?.renderSearch({
                    host: patientResults,

                    input: patientSearch,

                    query,

                    title: 'No patient record found',

                    message: 'Try another name, ID, or email address.',
                });
            } else {
                window.EmptyState?.render({
                    host: patientResults,

                    icon: 'fa-user-slash',

                    title: 'No patient records found',

                    message: 'There are currently no patient records available.',
                });
            }

            renderPatientPagination();

            return;
        }

        window.EmptyState?.hide(patientResults);

        const grid = document.createElement('div');
        grid.className = 'table-record-grid patient-record-grid';

        patients.forEach(patient => {
            grid.appendChild(createPatientCard(patient));
        });

        patientResults.replaceChildren(grid);
        renderPatientPagination();
    }

    window.handleWalkInPatientPerPageChange =
        function (value) {
            const allowed = [
                10,
                20,
                50,
                100,
            ];

            const requested =
                Number(value);

            patientPageSize =
                allowed.includes(
                    requested
                ) ?
                    requested :
                    10;

            patientCurrentPage = 1;

            const query =
                patientSearch
                    ?.value
                    .trim() || '';

            loadPatients(
                query,
                query === ''
            );
        };

    let patientSearchRequestId = 0;

    async function loadPatients(query = "", showAll = false) {
        if (!patientResults) return;

        const requestId = ++patientSearchRequestId;
        renderWalkInPatientSkeletons();

        try {
            const params = new URLSearchParams();

            if (query) {
                params.set("q", query);
            }

            if (showAll) {
                params.set("show_all", "1");
            }

            params.set(
                'page',
                String(patientCurrentPage)
            );

            params.set(
                'per_page',
                String(patientPageSize)
            );

            const response = await fetch(`{{ route('dentist.walk-in.search-patient') }}?${params.toString()}`, {
                headers: {
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            const responseData =
                await response.json().catch(() => ({}));

            if (!response.ok) {
                throw new Error(
                    responseData?.debug ||
                    responseData?.message ||
                    `Patient search failed. Status: ${response.status}`
                );
            }

            if (
                requestId !==
                patientSearchRequestId
            ) {
                return;
            }

            renderPatients(responseData);

        } catch (error) {
            if (
                requestId !==
                patientSearchRequestId
            ) {
                return;
            }

            console.error(
                'Walk-in patient loading error:',
                error
            );

            patientResults.innerHTML = '';

            window.EmptyState?.render({
                host: patientResults,

                icon: 'fa-triangle-exclamation',

                title: 'Unable to load patient records',

                message: error.message ||
                    'Check your connection, then try again.',
            });
        }
    }

    function loadInitialPatientRecords() {
        if (
            !patientResults ||
            patientResults.dataset
                .initialPatientsLoaded === "true"
        ) {
            return;
        }

        patientResults.dataset
            .initialPatientsLoaded = "true";

        loadPatients("", true);
    }

    window.handleWalkInPatientSearch =
        function (value) {
            patientCurrentPage = 1;

            const query =
                String(value || '')
                    .trim();

            loadPatients(
                query,
                query === ''
            );
        };

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
            step: bookingWorkflow
                ?.getCurrentStep?.() ?? 0,

            savedAt: new Date().toISOString(),

            fieldCount: draftFields.length
        };

        localStorage.setItem(DRAFT_KEY, JSON.stringify(obj));
    }

    function clearDraft() {
        localStorage.removeItem(DRAFT_KEY);
    }

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

        const relationSelect =
            document.getElementById("emergency_relation");

        const relationWrapper =
            relationSelect?.closest(".custom-select");

        if (relationWrapper) {
            window.syncCustomSelect?.(relationWrapper);
        }

        const restoredMode = patientModeInput?.value || "existing";
        setPatientMode(restoredMode, false);

        if (restoredMode === "guest" && guestName?.value?.trim()) {
            selectGuestPatient(false);
        }

        if (restoredMode !== "guest") {
            updateWomenSection(
                selectedWalkInPatient?.gender
            );
        }

        formIsDirty = true;
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

    function resetStep5View() {
        summarySection?.classList.remove("hidden");
        confirmationSection?.classList.add("hidden");
    }

    function scrollToInvalidTarget(target) {
        if (!target) return;

        const block =
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

        if (typeof target.focus === "function" && !target.hasAttribute("readonly")) {
            setTimeout(() => target.focus(), 250);
        }
    }

    function validateCurrentWalkInStep(stepElement) {
        if (!stepElement) {
            return {
                valid: true,
                firstInvalid: null,
            };
        }

        const fields = Array.from(
            stepElement.querySelectorAll(
                [
                    "input:not([type='hidden'])",
                    "select",
                    "textarea",
                ].join(",")
            )
        ).filter(field => {
            return (
                !field.disabled &&
                field.type !== "button" &&
                field.type !== "submit"
            );
        });

        const checkedGroups = new Set();
        let firstInvalid = null;

        fields.forEach(field => {
            if (field.type === "radio") {
                if (checkedGroups.has(field.name)) {
                    return;
                }

                checkedGroups.add(field.name);
            }

            const valid =
                window.validateFormInputField?.(field) ??
                field.checkValidity();

            if (!valid && !firstInvalid) {
                firstInvalid = field;
            }
        });

        if (firstInvalid) {
            window.focusGlobalInvalidField?.(
                firstInvalid
            );
        }

        return {
            valid: !firstInvalid,
            firstInvalid,
        };
    }

    function isStepComplete(s) {
        const stepEl =
            bookingWorkflow
                ?.getPanels()
            ?.[s];

        if (!stepEl) {
            return true;
        }

        if (s === 0) {
            const mode = patientModeInput?.value || "existing";
            const selectedPatientInput = document.getElementById("selectedPatientId");

            if (mode === "guest") {
                if (!guestName?.value?.trim()) {
                    window.validateFormInputField?.(
                        guestName
                    );

                    window.focusGlobalInvalidField?.(
                        guestName
                    );

                    return false;
                }

                if (!selectedPatientInput?.value) {
                    window.showGlobalGroupError?.(
                        walkInPatientGroup,
                        'walkin-patient',
                        'Please create the guest account before proceeding.'
                    );

                    walkInPatientGroup
                        ?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center',
                        });

                    return false;
                }

                window.clearGlobalGroupError?.(
                    walkInPatientGroup,
                    'walkin-patient'
                );

            } else if (
                !selectedPatientInput?.value
            ) {
                window.showGlobalGroupError?.(
                    walkInPatientGroup,
                    'walkin-patient',
                    'Please select an existing patient or use Guest Onboarding.'
                );

                walkInPatientGroup
                    ?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center',
                    });

                return false;
            }

            window.clearGlobalGroupError?.(
                walkInPatientGroup,
                'walkin-patient'
            );
        }

        if (s === 1) {
            const serviceGroup =
                stepEl.querySelector(
                    ".service-step-grid"
                );

            const selectedService =
                serviceGroup?.querySelector(
                    'input[name="service_type"]:checked'
                );

            if (!selectedService) {
                window.showGlobalGroupError?.(
                    serviceGroup,
                    "service_type",
                    "Please select a dental service."
                );

                serviceGroup?.scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });

                return false;
            }

            window.clearGlobalGroupError?.(
                serviceGroup,
                "service_type"
            );
        }

        const validation =
            validateCurrentWalkInStep(stepEl);

        if (!validation.valid) {
            return false;
        }

        if (s === 3) {
            const signature =
                window.BookingSignature
                    ?.get(
                        stepEl
                    );

            if (
                signature &&
                !signature.validate()
            ) {
                stepEl
                    .querySelector(
                        '[data-booking-signature]'
                    )
                    ?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center',
                    });

                return false;
            }
        }

        return true;
    }

    function initWalkInWorkflow() {
        if (
            bookingWorkflow ||
            !window.BookingWorkflow
        ) {
            return;
        }

        bookingWorkflow =
            window.BookingWorkflow.create({
                panels: '#appointmentForm > .step-content',

                progressFill: '#headerProgressFill',

                counter: '#stepCounterText',

                navContainer: '#navBtns',

                previousButton: '#prevBtn',

                nextButton: '#nextBtn',

                hideNavigationOnLast: true,

                beforeNext: currentStep => {
                    return isStepComplete(
                        currentStep
                    );
                },

                onLastStep: () => {
                    buildSummary();
                    resetStep5View();
                },

                onStepChange: currentStep => {
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
            initWalkInWorkflow, {
            once: true
        }
        );
    } else {
        initWalkInWorkflow();
    }

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

        const patientName = selectedWalkInPatient?.name || document.getElementById("selectedPatientName")
            ?.textContent || "N/A";
        const patientGender = selectedWalkInPatient?.gender || selectedWalkInPatient?.type || "N/A";
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

    ${isFemaleGender(
            selectedWalkInPatient?.gender
        )
                ? subSection(
                    "For Women Only",
                    `
                                    ${row(
                        "Pregnant",
                        get("pregnant")
                    )}

                                    ${row(
                        "Nursing",
                        get("nursing")
                    )}

                                    ${row(
                        "Birth Control Pills",
                        get("birth_control")
                    )}
                                `
                )
                : ""}

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
     ${summaryCard("Walk-in Schedule", "fa-clock", `
                                                    <div class="grid grid-cols-1 gap-y-1">
                                                        <p><b class="text-[#5c5550] font-semibold">Date & Time:</b> Recorded automatically when Start Procedure is clicked.</p>
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

    const confirmModal =
        document.getElementById(
            "confirmModal"
        );

    const confirmMessage =
        document.getElementById(
            "confirmMessage"
        );

    const okBtn =
        document.getElementById(
            "okBtn"
        );

    const finalSubmitBtn =
        document.getElementById(
            "finalSubmitBtn"
        );

    const finalConfirm =
        document.getElementById(
            "finalConfirm"
        );

    const appointmentForm =
        document.getElementById(
            "appointmentForm"
        );

    const appointmentsRedirectUrl =
        @json(route('dentist.dentist.appointments'));

    let appointmentSubmitRunning = false;

    function setFinalSubmitLoading(
        loading
    ) {
        if (!finalSubmitBtn) {
            return;
        }

        finalSubmitBtn.disabled = loading;

        finalSubmitBtn.innerHTML = loading ?
            `
            <i class="fa-solid fa-spinner fa-spin"></i>
            <span>Starting Procedure...</span>
        ` :
            `
            <i class="fa-solid fa-play"></i>
            <span>Start Procedure</span>
        `;
    }

    async function submitWalkInAppointment() {
        if (
            !appointmentForm ||
            appointmentSubmitRunning
        ) {
            return;
        }

        if (
            !finalConfirm ||
            !finalConfirm.checked
        ) {
            showMiniTab(
                "Please confirm before starting the procedure."
            );

            finalConfirm?.focus();
            return;
        }

        appointmentSubmitRunning = true;
        formSubmitting = true;

        setFinalSubmitLoading(true);

        try {
            const response = await fetch(
                appointmentForm.action, {
                method: appointmentForm.method ||
                    "POST",

                headers: {
                    Accept: "application/json",

                    "X-Requested-With": "XMLHttpRequest",
                },

                body: new FormData(
                    appointmentForm
                ),
            }
            );

            const responseData =
                await response
                    .json()
                    .catch(() => ({}));

            if (!response.ok) {
                if (
                    response.status === 422 &&
                    responseData?.errors
                ) {
                    const firstMessage =
                        Object.values(
                            responseData.errors
                        )
                            .flat()
                            .find(Boolean);

                    throw new Error(
                        firstMessage ||
                        "Please check the submitted information."
                    );
                }

                throw new Error(
                    responseData?.message ||
                    "Unable to start the procedure."
                );
            }

            clearDraft();
            formIsDirty = false;

            const patientName =
                selectedWalkInPatient?.name ||
                selectedPatientName
                    ?.textContent
                    ?.trim() ||
                "the selected patient";

            if (confirmMessage) {
                confirmMessage.textContent =
                    responseData?.message ||
                    `The walk-in appointment for ${patientName} has been recorded successfully.`;
            }

            okBtn.dataset.startUrl =
                responseData?.start_url || '';

            window.openModal?.(
                'confirmModal'
            );

            okBtn?.focus();

        } catch (error) {
            appointmentSubmitRunning = false;
            formSubmitting = false;

            setFinalSubmitLoading(false);

            showMiniTab(
                error.message ||
                "Unable to start the procedure. Please try again."
            );
        }
    }

    appointmentForm?.addEventListener(
        "submit",
        function (event) {
            event.preventDefault();

            submitWalkInAppointment();
        }
    );

    okBtn?.addEventListener(
        'click',
        () => {
            const startUrl =
                okBtn.dataset.startUrl;

            if (!startUrl) {
                return;
            }

            window.closeModal?.(
                'confirmModal'
            );

            window.location.href =
                startUrl;
        }
    );

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

    function formatPhoneDisplay(rawDigits) {
        const digits = rawDigits.slice(0, 11);
        let out = "";

        if (digits.length > 0) out += digits.slice(0, 4);
        if (digits.length > 4) out += " " + digits.slice(4, 7);
        if (digits.length > 7) out += " " + digits.slice(7, 11);

        return out;
    }

    emergencyNumber?.addEventListener("input", (e) => {
        const hadNonDigit = /[^\d\s]/.test(e.target.value);

        let digits = e.target.value.replace(/\D/g, "");

        if (digits.startsWith("9")) digits = "0" + digits;
        if (digits.length > 11) digits = digits.slice(0, 11);

        emergencyNumber.value = formatPhoneDisplay(digits);

        window.validateFormInputField?.(
            emergencyNumber
        );

        if (hadNonDigit) {
            showMiniTab("Contact number must contain digits only.");
        }

        markFormDirty();
    });

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

    function refreshWalkInGlobalControls() {
        const page =
            document.getElementById(
                'dentistWalkInPage'
            ) || document;

        window.initSearchClearButtons?.(page);
        window.initGlobalSearchBars?.(page);
        window.initCustomSelects?.(page);
        window.initGlobalPageSizeSelects?.(page);
        window.bindFormInputValidation?.(page);

        const relationSelect =
            document.getElementById(
                'emergency_relation'
            );

        const relationWrapper =
            relationSelect?.closest(
                '.custom-select'
            );

        if (relationWrapper) {
            window.syncCustomSelect?.(
                relationWrapper
            );
        }
    }

    refreshWalkInGlobalControls();
    loadInitialPatientRecords();

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