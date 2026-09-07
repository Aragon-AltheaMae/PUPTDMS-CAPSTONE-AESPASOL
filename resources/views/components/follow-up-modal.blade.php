@props([
    'id' => 'followUpModal',
    'patientName' => '—',
    'patientAvatarUrl' => '',
    'serviceType' => '—',
    'appointmentDate' => '—',
    'appointmentTime' => '—',
    'storeUrl' => '',
])

<div id="{{ $id }}" class="ui-modal modal-theme-warning" aria-hidden="true" role="dialog" aria-modal="true"
    aria-labelledby="{{ $id }}Title">

    <div class="ui-modal-card modal-xl modal-split-card">

        <div class="modal-hd">

            <div class="modal-heading">

                <div class="modal-icon">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>

                <div class="modal-copy">

                    <h2 id="{{ $id }}Title" class="modal-title">
                        Set Follow-Up Appointment
                    </h2>

                    <p class="modal-subtitle">
                        Choose a date and time, then save the follow-up appointment.
                    </p>

                </div>

            </div>

            <button type="button" class="modal-x" data-discard-close="{{ $id }}"
                aria-label="Close follow-up modal">
                <i class="fa-solid fa-xmark"></i>
            </button>

        </div>

        <form id="followUpForm" method="POST" action="{{ $storeUrl }}" class="modal-card-form" data-discard-form
            data-discard-title="Discard follow-up schedule?"
            data-discard-subtitle="The selected schedule has not been saved."
            data-discard-message="Your selected date, time, and reason will be removed. Do you want to discard these changes?"
            novalidate>

            @csrf

            <input type="hidden" id="followup_appointment_date" name="followup_appointment_date" required>

            <input type="hidden" id="followup_appointment_time" name="followup_appointment_time" required>

            <div class="modal-bd modal-scroll-body">

                <div class="modal-profile-card">

                    <div class="modal-profile-main">

                        <span class="patient-avatar patient-avatar-lg" data-patient-avatar
                            data-patient-name="{{ $patientName }}" data-patient-url="{{ $patientAvatarUrl }}"
                            aria-label="{{ $patientName }}">
                        </span>

                        <div class="modal-profile-main-copy">

                            <span class="modal-profile-eyebrow">
                                Appointment for
                            </span>

                            <strong id="followUpPatientName" class="modal-profile-name" data-patient-name>
                                {{ $patientName }}
                            </strong>

                        </div>

                    </div>

                    <div class="modal-profile-details">

                        <div class="modal-profile-detail">

                            <span class="modal-profile-detail-icon">
                                <i class="fa-regular fa-clock"></i>
                            </span>

                            <div>

                                <span class="modal-profile-label">
                                    Current Schedule
                                </span>

                                <strong id="followUpCurrentSchedule" class="modal-profile-value">
                                    {{ $appointmentDate }} | {{ $appointmentTime }}
                                </strong>

                            </div>

                        </div>

                        <div class="modal-profile-detail">

                            <span class="modal-profile-detail-icon">
                                <i class="fa-solid fa-tooth"></i>
                            </span>

                            <div>

                                <span class="modal-profile-label">
                                    Service Type
                                </span>

                                <strong id="followUpServiceType" class="modal-profile-value">
                                    {{ $serviceType }}
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-form-grid-2 mb-2 sm:mb-3">

                    <div id="followUpCalendarWrap" class="cal-wrap modal-calendar-panel calendar-shell-no-card"
                        data-global-field data-global-linked-input="#followup_appointment_date"
                        data-global-error-key="followup_appointment_date" data-global-required="true"
                        data-global-required-message="Please select a follow-up date.">

                        <div id="followUpCalendarGrid"></div>

                        <div id="followUpDateError" class="global-field-error"
                            data-error-for="followup_appointment_date" aria-hidden="true">
                        </div>

                    </div>

                    <div id="followUpTimeWrap" class="slots-wrap time-panel appointment-time-panel" data-global-field
                        data-global-linked-input="#followup_appointment_time"
                        data-global-error-key="followup_appointment_time" data-global-required="true"
                        data-global-required-message="Please select a follow-up time slot.">

                        <div class="appointment-time-heading">

                            <span class="appointment-time-heading-icon">
                                <i class="fa-regular fa-clock"></i>
                            </span>

                            <div>
                                <h4>Pick a Time Slot</h4>

                                <p>
                                    Choose a follow-up appointment time for the selected date.
                                </p>
                            </div>

                        </div>

                        <div id="followUpDateBanner" class="hidden appointment-slot-date-banner">
                        </div>

                        <div id="followUpSlotPlaceholder" class="appointment-slot-placeholder">

                            <div class="empty-icon">
                                <i class="fa-regular fa-calendar"></i>
                            </div>

                            <p class="empty-title">
                                Choose a date
                            </p>

                            <p class="empty-subtitle">
                                Select an available day to see time slots.
                            </p>

                        </div>

                        <div id="followUpSlotContainer" class="hidden appointment-slot-container">

                            <div id="followUpSlotGrid" class="appointment-slot-grid">
                            </div>

                            <button type="button" id="followUpClearTimeBtn"
                                class="appointment-slot-clear ui-btn ui-btn-secondary ui-btn-sm hidden mt-4 mb-2 w-full"
                                aria-hidden="true">
                                Clear selection
                            </button>

                            <div id="followUpSelectedSlotDisplay" class="hidden appointment-selected-slot">
                                <i class="fa-solid fa-circle-check"></i>
                                Selected:
                                <span id="followUpSelectedSlotText" class="font-bold">
                                </span>
                            </div>

                        </div>

                        <div id="followUpTimeError" class="global-field-error"
                            data-error-for="followup_appointment_time" aria-hidden="true">
                        </div>

                    </div>

                </div>

                <div class="modal-section-heading mt-5 sm:mt-6">

                    <span class="modal-section-icon">
                        <i class="fa-regular fa-message"></i>
                    </span>

                    <div>
                        <h4>
                            Reason for Follow-Up
                        </h4>
                        <p>
                            Optional — add a short explanation for this follow-up appointment.
                        </p>
                    </div>

                </div>

                <div class="global-form-group" data-global-field>

                    <textarea id="followup_reason" name="followup_reason" rows="3" maxlength="1000"
                        placeholder="e.g. Patient requires another evaluation…" class="form-input-custom global-form-textarea"
                        data-field-label="Reason for Follow-Up"></textarea>

                    <div id="followUpReasonError" class="global-field-error" data-error-for="followup_reason"
                        aria-hidden="true">
                    </div>

                </div>

            </div>

            <div class="modal-ft modal-sticky-footer">

                <button type="button" class="ui-btn ui-btn-secondary" data-discard-close="{{ $id }}">
                    <span>
                        Cancel
                    </span>
                </button>

                <button type="submit" id="confirmFollowUpBtn" class="ui-btn ui-btn-warning">
                    <span>
                        Schedule Follow-Up
                    </span>
                </button>

            </div>

        </form>

    </div>

</div>
