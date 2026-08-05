<div id="cancelAppointmentModal" class="ui-modal modal-theme-danger" aria-hidden="true" role="dialog" aria-modal="true"
    aria-labelledby="cancelAppointmentModalTitle" onclick="handleCancelBackdropClick(event)">

    <div class="ui-modal-card modal-lg cancel-modal-panel">
        <div class="modal-hd appointment-modal-header cancel-modal-header">

            <div class="modal-header-custom">
                <div class="appointment-modal-header-icon cancel-modal-icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>

                <div class="appointment-modal-header-copy">
                    <span class="appointment-modal-eyebrow">
                        Appointment Action
                    </span>

                    <h2 id="cancelAppointmentModalTitle" class="appointment-modal-title">
                        Cancel Appointment
                    </h2>

                    <p class="appointment-modal-subtitle">
                        This action cannot be undone.
                    </p>
                </div>
            </div>

            <button type="button" onclick="closeCancelAppointmentModal()" class="modal-x"
                aria-label="Close cancellation modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="cancelAppointmentForm" data-discard-form data-discard-title="Discard cancellation?"
            data-discard-subtitle="A cancellation reason has been selected."
            data-discard-message="The selected cancellation reason will be cleared. Do you want to discard this change?">

            <div class="modal-bd cancel-modal-body">
                <div class="modal-profile-card modal-profile-card-single cancel-patient-summary">
                    <div class="modal-profile-main">
                        <div class="modal-profile-avatar">
                            <i class="fa-regular fa-user"></i>
                        </div>

                        <div class="modal-profile-main-copy">
                            <span class="modal-profile-eyebrow">
                                Cancelling appointment for
                            </span>

                            <strong id="cancelPatientName" class="modal-profile-name">
                                —
                            </strong>
                        </div>
                    </div>

                    <div class="modal-profile-details modal-profile-details-single">
                        <div class="modal-profile-detail">
                            <span class="modal-profile-detail-icon">
                                <i class="fa-regular fa-calendar-xmark"></i>
                            </span>

                            <div>
                                <span class="modal-profile-label">
                                    Scheduled Date
                                </span>

                                <strong id="cancelAppointmentDate" class="modal-profile-value">
                                    —
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <p class="text-[12px] font-semibold text-gray-500 uppercase tracking-wide mb-2.5">
                        Reason <span class="text-red-400 font-normal normal-case">* required</span>
                    </p>
                    <div class="flex flex-wrap gap-2" id="cancelReasonChips" onchange="clearReasonError()">
                        <div class="reason-chip"><input type="radio" name="cancelReason" id="r1"
                                value="Patient no-show"><label for="r1"><i
                                    class="fa-regular fa-circle-xmark text-[11px]"></i> Patient no-show</label></div>
                        <div class="reason-chip"><input type="radio" name="cancelReason" id="r2"
                                value="Doctor unavailable"><label for="r2"><i
                                    class="fa-solid fa-user-doctor text-[11px]"></i> Doctor unavailable</label></div>
                        <div class="reason-chip"><input type="radio" name="cancelReason" id="r3"
                                value="Patient request"><label for="r3"><i class="fa-regular fa-hand text-[11px]"></i>
                                Patient request</label></div>
                        <div class="reason-chip"><input type="radio" name="cancelReason" id="r4"
                                value="Emergency"><label for="r4"><i class="fa-solid fa-bolt text-[11px]"></i>
                                Emergency</label></div>
                        <div class="reason-chip"><input type="radio" name="cancelReason" id="r5"
                                value="Rescheduled"><label for="r5"><i class="fa-solid fa-rotate text-[11px]"></i>
                                Rescheduled</label></div>
                    </div>
                    <div id="reasonError"
                        class="hidden mt-2.5 flex items-center gap-1.5 text-red-500 text-[12px] font-semibold">
                        <i class="fa-solid fa-circle-exclamation text-[11px]"></i> Please select a reason before
                        cancelling.
                    </div>
                </div>
            </div>
            <div class="modal-ft cancel-modal-footer">

                <button type="button" onclick="closeCancelAppointmentModal()" class="ui-btn ui-btn-secondary">

                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Keep Appointment</span>
                </button>

                <button type="button" id="confirmCancelBtn" onclick="confirmCancelAppointment()"
                    class="ui-btn ui-btn-danger">

                    <i class="fa-solid fa-ban"></i>
                    <span>Yes, Cancel</span>
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    let selectedCancelUrl = null;
    let selectedCancelAppointmentId = null;

    function extractAppointmentIdFromCancelUrl(url) {
        const match = String(url || '').match(/appointments\/(\d+)/);
        return match ? match[1] : null;
    }

    function cancelAppointmentFromModal(url, patientName = 'this patient', appointmentDate = '—') {
        selectedCancelUrl = url;
        selectedCancelAppointmentId = extractAppointmentIdFromCancelUrl(url);
        document.getElementById('cancelPatientName').textContent = patientName;
        document.getElementById('cancelAppointmentDate').textContent = appointmentDate;
        document.querySelectorAll('input[name="cancelReason"]').forEach(r => r.checked = false);
        clearReasonError();
        const confirmBtn = document.getElementById('confirmCancelBtn');
        confirmBtn.disabled = false;
        confirmBtn.innerHTML = '<i class="fa-solid fa-ban text-xs mr-1.5"></i>Yes, Cancel';
        const modal = document.getElementById('cancelAppointmentModal');

        if (!modal) return;

        modal.classList.remove('closing');
        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');

        document.documentElement.classList.add('modal-lock');
        document.body.classList.add('modal-lock');

        requestAnimationFrame(() => {
            window.DiscardChanges?.captureModal(modal);
        });
    }

    function forceCloseCancelAppointmentModal() {
        const modal =
            document.getElementById('cancelAppointmentModal');

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

        selectedCancelUrl = null;
        selectedCancelAppointmentId = null;
    }

    function closeCancelAppointmentModal(options = {}) {
        const modal =
            document.getElementById('cancelAppointmentModal');

        if (!modal) return;

        if (options.force === true) {
            forceCloseCancelAppointmentModal();
            return;
        }

        if (window.DiscardChanges) {
            window.DiscardChanges.confirmClose(
                modal,
                forceCloseCancelAppointmentModal
            );

            return;
        }

        forceCloseCancelAppointmentModal();
    }

    function handleCancelBackdropClick(e) {
        if (e.target === document.getElementById('cancelAppointmentModal')) {
            closeCancelAppointmentModal();
        }
    }

    function clearReasonError() {
        document.getElementById('cancelReasonChips').classList.remove('invalid', 'chips-error-shake');
        document.getElementById('reasonError').classList.add('hidden');
    }

    document.querySelectorAll('input[name="cancelReason"]').forEach(r => {
        r.addEventListener('change', clearReasonError);
    });

    async function confirmCancelAppointment() {
        const selectedReason = document.querySelector('input[name="cancelReason"]:checked')?.value || null;

        if (!selectedReason) {
            const chips = document.getElementById('cancelReasonChips');
            document.getElementById('reasonError').classList.remove('hidden');
            chips.classList.add('invalid');
            chips.classList.remove('chips-error-shake');
            void chips.offsetWidth;
            chips.classList.add('chips-error-shake');
            return;
        }

        if (!selectedCancelUrl) {
            return;
        }

        const btn = document.getElementById('confirmCancelBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin text-xs mr-1.5"></i>Cancelling…';

        try {
            const response = await fetch(selectedCancelUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                        'content') || '',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    reason: selectedReason
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                if (selectedCancelAppointmentId) {
                    sessionStorage.setItem(`appointmentCancelReason:${selectedCancelAppointmentId}`,
                        selectedReason);
                }
                closeCancelAppointmentModal({
                    force: true
                });
                if (typeof closeDayAppointmentsModal === 'function') {
                    closeDayAppointmentsModal();
                }
                sessionStorage.setItem('dentistToast', JSON.stringify({
                    title: 'Appointment cancelled',
                    message: `${document.getElementById('cancelPatientName')?.textContent || 'Appointment'} was cancelled successfully.`,
                    tone: 'danger',
                    duration: 3500
                }));

                window.location.reload();
            } else {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-ban text-xs mr-1.5"></i>Yes, Cancel';
            }
        } catch (error) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-ban text-xs mr-1.5"></i>Yes, Cancel';
        }
    }

    document.addEventListener('keydown', event => {
        const modal =
            document.getElementById('cancelAppointmentModal');

        if (
            event.key !== 'Escape' ||
            !modal?.classList.contains('open')
        ) {
            return;
        }

        event.preventDefault();
        event.stopImmediatePropagation();

        closeCancelAppointmentModal();
    }, true);
</script>
