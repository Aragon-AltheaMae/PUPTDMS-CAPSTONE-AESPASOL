<div id="rescheduleModal" class="ui-modal modal-theme-warning" aria-hidden="true" role="dialog" aria-modal="true"
    aria-labelledby="rescheduleModalTitle" onclick="handleRescheduleBackdropClick(event)">
    <div class="ui-modal-card modal-xl modal-split-card">

        <div class="modal-hd">

            <div class="modal-heading">

                <div class="modal-icon">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>

                <div class="modal-copy">

                    <h2 id="rescheduleModalTitle" class="modal-title">
                        Reschedule Appointment
                    </h2>

                    <p class="modal-subtitle">
                        Choose a new date and time, then save the changes.
                    </p>

                </div>

            </div>

            <button type="button" onclick="closeRescheduleModal()" class="modal-x" aria-label="Close reschedule modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="rescheduleForm" method="POST" class="modal-card-form" data-discard-form
            data-discard-title="Discard reschedule changes?"
            data-discard-subtitle="The selected schedule has not been saved."
            data-discard-message="Your selected date, time, and reason will be removed. Do you want to discard these changes?">
            @csrf
            @method('PUT')

            <input type="hidden" name="service_type" value="">
            <input type="hidden" id="new_appointment_date" name="new_appointment_date" required>
            <input type="hidden" id="new_appointment_time" name="new_appointment_time" required>

            <div class="modal-bd modal-scroll-body">
                <div class="modal-profile-card">
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

                <div class="modal-section-heading">
                    <span class="modal-section-icon">
                        <i class="fa-regular fa-calendar"></i>
                    </span>

                    <div>
                        <h4>New Date &amp; Time</h4>
                    </div>
                </div>

                <div class="modal-form-grid-2 mb-2 sm:mb-3">

                    <div class="cal-wrap modal-calendar-panel calendar-shell-no-card" data-global-field>
                        <div id="calGridWrapReschedule"></div>
                    </div>

                    <div class="slots-wrap modal-option-panel time-panel" data-global-field>

                        <div class="modal-section-heading">
                            <span class="modal-section-icon">
                                <i class="fa-regular fa-clock"></i>
                            </span>

                            <div>
                                <h4>Time Slot</h4>
                            </div>
                        </div>

                        <div id="dateBanner"
                            class="
        hidden
        rounded-xl
        px-3
        py-2
        text-sm
        font-semibold
        text-white
        mb-3
        shadow-md
        date-banner-gradient
    ">
                        </div>

                        <div id="slotPlaceholder"
                            class="slot-placeholder-empty flex flex-col items-center justify-center gap-3 py-8 text-center text-[#9e9690]">

                            <div
                                class="empty-icon w-12 h-12 rounded-full bg-[#f9e8e8] flex items-center justify-center text-[#8B0000] text-lg">
                                <i class="fa-regular fa-calendar"></i>
                            </div>

                            <div>
                                <p class="empty-title text-sm font-semibold text-[#5c5550]">
                                    Choose a date
                                </p>

                                <p class="empty-subtitle text-xs mt-1">
                                    Select an available day to see time slots.
                                </p>
                            </div>
                        </div>

                        <div id="slotContainer" class="hidden">

                            <div id="slotGrid" class="slot-grid-ui grid grid-cols-2 gap-4">
                            </div>

                            <button type="button" id="clearSlotSelectionBtn"
                                class="
            ui-btn
            ui-btn-secondary
            ui-btn-sm
            hidden
            mt-4
            mb-2
            w-full
        "
                                onclick="clearRescheduleSlotSelection()">
                                <i class="fa-solid fa-xmark"></i>
                                Clear selection
                            </button>

                            <div id="selectedSlotDisplay"
                                class="
            hidden
            rounded-2xl
            px-4
            py-3
            text-sm
            font-semibold
            text-[#8B0000]
            bg-[linear-gradient(135deg,#fff5f5,#fffafa)]
            border
            border-[#e8caca]
            shadow-sm
        ">
                                <i
                                    class="
                fa-solid
                fa-circle-check
                mr-1.5
            "></i>

                                Selected:

                                <span id="selectedSlotText" class="font-bold"></span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-section-heading mt-5 sm:mt-6">

                    <span class="modal-section-icon">
                        <i class="fa-regular fa-message"></i>
                    </span>

                    <div>
                        <h4>
                            Reason for Rescheduling
                        </h4>

                        <p>
                            Optional — add a short explanation for this schedule change.
                        </p>
                    </div>

                </div>

                <div class="w-full">
                    <textarea id="reschedule_reason" name="reschedule_reason" rows="3"
                        placeholder="e.g. Patient requested a later date…" class="form-input w-full min-h-[112px] resize-none"></textarea>
                </div>
            </div>

            <div class="modal-ft modal-sticky-footer">

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
        const selectedSlotDisplay =
            document.getElementById(
                'selectedSlotDisplay'
            );

        const selectedSlotText =
            document.getElementById(
                'selectedSlotText'
            );
        const clearBtn = document.getElementById('clearSlotSelectionBtn');
        const slotGrid = document.getElementById('slotGrid');

        if (typeof selectedTime !== 'undefined') selectedTime = null;

        if (timeInput) {
            timeInput.value = '';
            timeInput.dispatchEvent(new Event('change', {
                bubbles: true
            }));
        }

        if (selectedSlotText) {
            selectedSlotText.textContent = '';
        }

        selectedSlotDisplay?.classList.add(
            'hidden'
        );

        if (clearBtn) {
            clearBtn.classList.add('hidden');
            clearBtn.setAttribute('aria-hidden', 'true');
        }

        slotGrid
            ?.querySelectorAll('.slot-chip')
            .forEach(chip => {
                chip.classList.remove(
                    'selected',
                    'bg-[#8B0000]',
                    'text-white',
                    'border-[#8B0000]'
                );

                chip.classList.add(
                    'border-[#e8e2dd]',
                    'bg-[#fafaf8]',
                    'text-[#1a1410]'
                );

                chip.setAttribute(
                    'aria-pressed',
                    'false'
                );
            });
        if (typeof markFormDirty === 'function') markFormDirty();
    }

    function resetRescheduleSlotUi() {
        const slotPlaceholder =
            document.getElementById(
                'slotPlaceholder'
            );

        const slotContainer =
            document.getElementById(
                'slotContainer'
            );

        const slotGrid =
            document.getElementById(
                'slotGrid'
            );

        const selectedSlotDisplay =
            document.getElementById(
                'selectedSlotDisplay'
            );

        const selectedSlotText =
            document.getElementById(
                'selectedSlotText'
            );

        const clearBtn =
            document.getElementById(
                'clearSlotSelectionBtn'
            );

        slotPlaceholder?.classList.remove(
            'hidden'
        );

        slotContainer?.classList.add(
            'hidden'
        );

        if (slotGrid) {
            slotGrid.innerHTML = '';
            slotGrid.style.removeProperty(
                'display'
            );
        }

        selectedSlotDisplay?.classList.add(
            'hidden'
        );

        if (selectedSlotText) {
            selectedSlotText.textContent = '';
        }

        clearBtn?.classList.add(
            'hidden'
        );

        clearBtn?.setAttribute(
            'aria-hidden',
            'true'
        );
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

        window.clearGlobalGroupError?.(
            document.querySelector(
                '#rescheduleModal .cal-wrap'
            ),
            'reschedule-date'
        );

        window.clearGlobalGroupError?.(
            document.querySelector(
                '#rescheduleModal .slots-wrap'
            ),
            'reschedule-time'
        );

        const calendarGroup =
            document.querySelector(
                '#rescheduleModal .cal-wrap'
            );

        const timeSlotGroup =
            document.querySelector(
                '#rescheduleModal .slots-wrap'
            );

        window.clearGlobalGroupError?.(
            calendarGroup,
            'reschedule-date'
        );

        window.clearGlobalGroupError?.(
            timeSlotGroup,
            'reschedule-time'
        );

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

        const calendarGroup =
            document.querySelector(
                '#rescheduleModal .cal-wrap'
            );

        const timeSlotGroup =
            document.querySelector(
                '#rescheduleModal .slots-wrap'
            );

        if (!selectedDate) {
            window.showGlobalGroupError?.(
                calendarGroup,
                'reschedule-date',
                'Please select a date.'
            );

            valid = false;
        } else {
            window.clearGlobalGroupError?.(
                calendarGroup,
                'reschedule-date'
            );
        }

        if (!selectedTime) {
            window.showGlobalGroupError?.(
                timeSlotGroup,
                'reschedule-time',
                'Please select a time slot.'
            );

            valid = false;
        } else {
            window.clearGlobalGroupError?.(
                timeSlotGroup,
                'reschedule-time'
            );
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
