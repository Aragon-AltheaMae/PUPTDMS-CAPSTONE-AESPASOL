<div id="rescheduleModal" class="ui-modal modal-theme-warning" aria-hidden="true" role="dialog" aria-modal="true"
    aria-labelledby="rescheduleModalTitle" onclick="handleRescheduleBackdropClick(event)">

    <div class="ui-modal-card modal-xl reschedule-modal-panel">

        <div class="modal-hd appointment-modal-header reschedule-modal-header">

            <div class="modal-header-custom">
                <div class="appointment-modal-header-icon reschedule-modal-icon">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>

                <div class="appointment-modal-header-copy">
                    <span class="appointment-modal-eyebrow">
                        Appointment Update
                    </span>

                    <h2 id="rescheduleModalTitle" class="appointment-modal-title">
                        Reschedule Appointment
                    </h2>

                    <p class="appointment-modal-subtitle">
                        Choose a new date and time, then save the changes.
                    </p>
                </div>
            </div>

            <button type="button" onclick="closeRescheduleModal()" class="modal-x" aria-label="Close reschedule modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="rescheduleForm" method="POST" class="reschedule-modal-form" data-discard-form
            data-discard-title="Discard reschedule changes?"
            data-discard-subtitle="The selected schedule has not been saved."
            data-discard-message="Your selected date, time, and reason will be removed. Do you want to discard these changes?">
            @csrf
            @method('PUT')

            <input type="hidden" name="service_type" value="">
            <input type="hidden" id="new_appointment_date" name="new_appointment_date" required>
            <input type="hidden" id="new_appointment_time" name="new_appointment_time" required>

            <div class="modal-bd reschedule-modal-body">
                <div class="modal-profile-card reschedule-patient-summary">
                    <div class="modal-profile-main">
                        <div class="modal-profile-avatar">
                            <i class="fa-solid fa-user"></i>
                        </div>

                        <div class="modal-profile-main-copy">
                            <span class="modal-profile-eyebrow">
                                Appointment for
                            </span>

                            <strong id="resPatientName" class="modal-profile-name">
                                —
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

                                <strong id="resCurrentSchedule" class="modal-profile-value">
                                    —
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

                                <strong id="resServiceType" class="modal-profile-value">
                                    —
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-label">
                    <i class="fa-regular fa-calendar fa-xs"></i> New Date &amp; Time
                </div>

                <div id="dateError" class="error-msg" style="display:none;">
                    <i class="fa-solid fa-circle-exclamation"></i> Please select a date.
                </div>

                <div class="two-col mb-2 sm:mb-3">
                    <div class="cal-wrap">
                        <div id="calGridWrapReschedule"></div>
                    </div>

                    <div class="slots-wrap">
                        <div class="section-label" style="margin-bottom:.6rem;">
                            <i class="fa-regular fa-clock fa-xs"></i> Time Slot
                        </div>

                        <div id="dateBanner" class="hidden"></div>
                        <div class="slots-date-pill" id="datePill"></div>

                        <div id="slotPlaceholder" class="slots-placeholder">
                            <i class="fa-regular fa-calendar-xmark"></i>
                            <span>Select a date to see available slots</span>
                        </div>

                        <div id="slotContainer" class="hidden">
                            <div id="slotGrid" class="slots-grid" style="display:none;"></div>
                        </div>

                        <button type="button" id="clearSlotSelectionBtn" class="slot-clear-selection hidden"
                            onclick="clearRescheduleSlotSelection()">
                            <i class="fa-solid fa-xmark"></i>
                            Clear selection
                        </button>

                        <div id="selectedTimePill" class="selected-time-card hidden">

                            <div class="selected-time-card-content">

                                <div class="selected-time-icon">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>

                                <div class="selected-time-copy">
                                    <p class="selected-time-label">
                                        Selected Time
                                    </p>

                                    <p id="selectedTimeText" class="selected-time-value">
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div id="timeError" class="error-msg" style="display:none;">
                    <i class="fa-solid fa-circle-exclamation"></i> Please select a time slot.
                </div>

                <div class="section-label mt-5 sm:mt-6">
                    <i class="fa-regular fa-message fa-xs"></i>
                    Reason for Rescheduling
                    <span style="font-weight:400;text-transform:none;letter-spacing:0;">(optional)</span>
                </div>

                <div class="reason-wrap w-full">
                    <textarea id="reschedule_reason" name="reschedule_reason" rows="3"
                        placeholder="e.g. Patient requested a later date…"
                        class="reason-textarea w-full min-h-[112px] resize-none"></textarea>
                </div>
            </div>

            <div class="modal-ft reschedule-modal-footer">

                <button type="button" id="cancelBtn" class="ui-btn ui-btn-secondary">

                    <i class="fa-solid fa-xmark"></i>
                    <span>Cancel</span>
                </button>

                <button type="submit" id="confirmRescheduleBtn" class="ui-btn ui-btn-warning">

                    <i class="fa-solid fa-check"></i>
                    <span>Confirm Reschedule</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRescheduleModalFromDay(id, name, datetime, serviceType, updateUrl) {
        openRescheduleModal({
            id,
            name,
            datetime,
            serviceType,
            updateUrl
        });
    }

    let selectedRescheduleId = null;

    function clearRescheduleSlotSelection() {
        const timeInput = document.getElementById('new_appointment_time');
        const selectedTimePill = document.getElementById('selectedTimePill');
        const selectedTimeText = document.getElementById('selectedTimeText');
        const clearBtn = document.getElementById('clearSlotSelectionBtn');
        const slotGrid = document.getElementById('slotGrid');

        if (typeof selectedTime !== 'undefined') selectedTime = null;

        if (timeInput) {
            timeInput.value = '';
            timeInput.dispatchEvent(new Event('change', {
                bubbles: true
            }));
        }

        if (selectedTimeText) selectedTimeText.textContent = '';

        if (selectedTimePill) {
            selectedTimePill.classList.remove('show');
            selectedTimePill.classList.add('hidden');
            selectedTimePill.style.display = 'none';
        }

        if (clearBtn) {
            clearBtn.classList.add('hidden');
            clearBtn.setAttribute('aria-hidden', 'true');
        }

        slotGrid?.querySelectorAll('.slot-chip').forEach(chip => {
            slotGrid?.querySelectorAll('.slot-chip').forEach(chip => {
                chip.classList.remove('selected');
                chip.setAttribute('aria-pressed', 'false');
            });
            chip.setAttribute('aria-pressed', 'false');
        });

        if (typeof markFormDirty === 'function') markFormDirty();
    }

    function resetRescheduleSlotUi() {
        const slotPlaceholder = document.getElementById('slotPlaceholder');
        const slotGrid = document.getElementById('slotGrid');
        const selectedTimePill = document.getElementById('selectedTimePill');
        const selectedTimeText = document.getElementById('selectedTimeText');
        const clearBtn = document.getElementById('clearSlotSelectionBtn');

        if (slotPlaceholder) {
            slotPlaceholder.classList.remove('hidden');
            slotPlaceholder.style.display = 'flex';
            slotPlaceholder.innerHTML = `
                <i class="fa-regular fa-calendar-xmark"></i>
                <span>Select a date to see available slots</span>
            `;
        }

        if (slotGrid) {
            slotGrid.style.display = 'none';
            slotGrid.innerHTML = '';
        }

        if (selectedTimePill) {
            selectedTimePill.classList.remove('show');
            selectedTimePill.classList.add('hidden');
            selectedTimePill.style.display = 'none';
        }

        if (selectedTimeText) selectedTimeText.textContent = '';

        if (clearBtn) {
            clearBtn.classList.add('hidden');
            clearBtn.setAttribute('aria-hidden', 'true');
        }
    }

    function openRescheduleModal(payload = {}) {
        selectedRescheduleId = payload.id || null;

        const modal = document.getElementById('rescheduleModal');
        if (!modal) return;

        const patientEl = document.getElementById('resPatientName');
        const scheduleEl = document.getElementById('resCurrentSchedule');
        const serviceEl = document.getElementById('resServiceType');

        if (patientEl) patientEl.textContent = payload.name || '—';
        if (scheduleEl) {
            scheduleEl.textContent = String(payload.datetime || '—')
                .replace(/\s*[•·]\s*/g, ' | ');
        }
        if (serviceEl) serviceEl.textContent = payload.serviceType || '—';

        const form = document.getElementById('rescheduleForm');
        if (form && payload.updateUrl) {
            form.action = payload.updateUrl;
        }

        const serviceInput = document.querySelector('#rescheduleForm input[name="service_type"]');
        if (serviceInput) {
            serviceInput.value = payload.serviceType || '';
        }

        const dateInput = document.getElementById('new_appointment_date');
        const timeInput = document.getElementById('new_appointment_time');
        const reasonInput = document.getElementById('reschedule_reason');

        if (dateInput) dateInput.value = '';
        if (timeInput) timeInput.value = '';
        if (reasonInput) reasonInput.value = '';

        if (typeof selectedDate !== 'undefined') selectedDate = null;
        if (typeof selectedTime !== 'undefined') selectedTime = null;

        const dateError = document.getElementById('dateError');
        const timeError = document.getElementById('timeError');

        if (dateError) dateError.style.display = 'none';
        if (timeError) timeError.style.display = 'none';

        document.querySelector('#rescheduleModal .cal-wrap')?.classList.remove('error');
        document.querySelector('#rescheduleModal .slots-wrap')?.classList.remove('error');

        document.getElementById('datePill')?.replaceChildren();
        document.getElementById('datePill')?.classList.remove('show');

        resetRescheduleSlotUi();

        const submitBtn = document.getElementById('confirmRescheduleBtn');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa-solid fa-check"></i> Confirm Reschedule';
        }

        modal.classList.remove('closing');
        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');

        document.documentElement.classList.add('modal-lock');
        document.body.classList.add('modal-lock');

        if (typeof renderCalendarLoading === 'function') {
            renderCalendarLoading();
        }

        if (typeof renderCalendar === 'function') {
            setTimeout(() => {
                renderCalendar();
            }, 0);
        }

        if (dateInput) dateInput.value = '';
        if (timeInput) timeInput.value = '';

        requestAnimationFrame(() => {
            window.DiscardChanges?.captureModal(modal);
        });
    }

    function forceCloseRescheduleModal() {
        const modal = document.getElementById('rescheduleModal');

        if (!modal || !modal.classList.contains('open')) {
            return;
        }

        modal.classList.remove('open');
        modal.classList.add('closing');
        modal.setAttribute('aria-hidden', 'true');

        window.setTimeout(() => {
            modal.classList.remove('closing');

            document.documentElement.classList.remove('modal-lock');

            if (!document.querySelector('.ui-modal.open')) {
                document.body.classList.remove('modal-lock');
            }
        }, 170);

        selectedRescheduleId = null;
    }

    function closeRescheduleModal(options = {}) {
        const modal = document.getElementById('rescheduleModal');

        if (!modal) return;

        if (options.force === true) {
            forceCloseRescheduleModal();
            return;
        }

        if (window.DiscardChanges) {
            window.DiscardChanges.confirmClose(
                modal,
                forceCloseRescheduleModal
            );

            return;
        }

        forceCloseRescheduleModal();
    }

    function handleRescheduleBackdropClick(e) {
        if (e.target === document.getElementById('rescheduleModal')) {
            closeRescheduleModal();
        }
    }

    document.getElementById("cancelBtn")?.addEventListener("click", () => {
        closeRescheduleModal();
    });

    document.getElementById("rescheduleForm")?.addEventListener("submit", async e => {
        e.preventDefault();

        let valid = true;

        if (!selectedDate) {
            const dateError = document.getElementById("dateError");
            if (dateError) dateError.style.display = "flex";
            document.querySelector("#rescheduleModal .cal-wrap")?.classList.add("error");
            valid = false;
        }

        if (!selectedTime) {
            const timeError = document.getElementById("timeError");
            if (timeError) timeError.style.display = "flex";
            document.querySelector("#rescheduleModal .slots-wrap")?.classList.add("error");
            valid = false;
        }

        if (!valid) {
            window.DiscardChanges?.markNotSubmitting(
                document.getElementById('rescheduleForm')
            );

            return;
        }

        const form = document.getElementById("rescheduleForm");
        if (!form || !form.action) {
            window.DiscardChanges?.markNotSubmitting(form);

            alert("Reschedule form action is missing.");
            return;
        }

        const formData = new FormData(form);

        const submitBtn = document.getElementById('confirmRescheduleBtn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Saving...';
        }

        try {
            const response = await fetch(form.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                    "Accept": "application/json",
                },
                body: formData,
            });

            const data = await response.json().catch(() => null);

            if (response.ok && (data?.success ?? true)) {
                closeRescheduleModal({
                    force: true
                });

                if (typeof closeDayAppointmentsModal === 'function') {
                    closeDayAppointmentsModal();
                }

                sessionStorage.setItem('dentistToast', JSON.stringify({
                    title: 'Appointment rescheduled',
                    message: `${document.getElementById('resPatientName')?.textContent || 'Appointment'} was updated successfully.`,
                    tone: 'success',
                    duration: 3500
                }));

                window.location.reload();
            } else {
                window.DiscardChanges?.markNotSubmitting(form);

                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fa-solid fa-check"></i> Confirm Reschedule';
                }
                alert(data?.message ?? "Something went wrong. Please try again.");
            }
        } catch (err) {
            window.DiscardChanges?.markNotSubmitting(form);

            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa-solid fa-check"></i> Confirm Reschedule';
            }
            alert("Network error. Please try again.");
        }
    });

    document.addEventListener('keydown', event => {
        const modal = document.getElementById('rescheduleModal');

        if (
            event.key !== 'Escape' ||
            !modal?.classList.contains('open')
        ) {
            return;
        }

        event.preventDefault();
        event.stopImmediatePropagation();

        closeRescheduleModal();
    }, true);
</script>