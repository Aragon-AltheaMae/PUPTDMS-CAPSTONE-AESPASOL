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

                <div class="modal-section-heading">

                    <span class="modal-section-icon">
                        <i class="fa-regular fa-calendar"></i>
                    </span>

                    <div>
                        <h4>New Date &amp; Time</h4>
                    </div>

                </div>

                <div class="modal-form-grid-2 mb-2 sm:mb-3">

                    <div class="global-form-group" data-global-field>
                        <div class="global-label-row">
                            <label for="followUpDatePicker" class="global-form-label">
                                Follow-Up Date
                            </label>
                        </div>

                        <input id="followUpDatePicker" type="date" class="form-input-custom"
                            min="{{ now()->addDay()->toDateString() }}">

                        <div id="followUpDateError" class="global-field-error"
                            data-error-for="followup_appointment_date" aria-hidden="true">
                        </div>
                    </div>

                    <div class="global-form-group" data-global-field>
                        <div class="global-label-row">
                            <label for="followUpTimePicker" class="global-form-label">
                                Time Slot
                            </label>
                        </div>

                        <select id="followUpTimePicker" class="form-input-custom" disabled>
                            <option value="">Select a date first</option>
                        </select>

                        <button type="button" id="followUpClearTimeBtn"
                            class="ui-btn ui-btn-secondary ui-btn-sm hidden mt-4 mb-2 w-full">
                            <i class="fa-solid fa-xmark"></i>
                            Clear selection
                        </button>

                        <div id="followUpSelectedSlotDisplay" class="hidden appointment-selected-slot">
                            <i class="fa-solid fa-circle-check"></i>
                            Selected:
                            <span id="followUpSelectedSlotText" class="font-bold">
                            </span>
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
                    <i class="fa-solid fa-xmark"></i>
                    <span>
                        Cancel
                    </span>
                </button>

                <button type="submit" id="confirmFollowUpBtn" class="ui-btn ui-btn-warning">
                    <i class="fa-solid fa-check"></i>
                    <span>
                        Schedule Follow-Up
                    </span>
                </button>

            </div>

        </form>

    </div>

</div>
