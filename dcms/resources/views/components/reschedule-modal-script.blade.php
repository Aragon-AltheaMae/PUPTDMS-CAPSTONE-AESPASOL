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

    function openRescheduleModal(payload = {}) {
        selectedRescheduleId = payload.id || null;

        const modal = document.getElementById('rescheduleModal');
        if (!modal) return;

        const patientEl = document.getElementById('resPatientName');
        const scheduleEl = document.getElementById('resCurrentSchedule');
        const serviceEl = document.getElementById('resServiceType');

        if (patientEl) patientEl.textContent = payload.name || '—';
        if (scheduleEl) scheduleEl.textContent = payload.datetime || '—';
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

        document.querySelector('.cal-wrap')?.classList.remove('error');
        document.querySelector('.slots-wrap')?.classList.remove('error');

        document.getElementById('datePill')?.replaceChildren();

        const slotPlaceholder = document.getElementById('slotPlaceholder');
        const slotGrid = document.getElementById('slotGrid');
        const selectedTimePill = document.getElementById('selectedTimePill');
        const selectedTimeText = document.getElementById('selectedTimeText');

        if (slotPlaceholder) {
            slotPlaceholder.classList.remove('hidden');
            slotPlaceholder.style.display = 'flex';
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

        modal.classList.remove('hidden');

        const panel = modal.querySelector('.reschedule-modal-panel');
        if (panel) {
            panel.style.animation = 'none';
            requestAnimationFrame(() => requestAnimationFrame(() => {
                panel.style.animation = '';
            }));
        }

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

    }

    function closeRescheduleModal() {
        document.getElementById('rescheduleModal')?.classList.add('hidden');
        selectedRescheduleId = null;
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
            document.querySelector(".cal-wrap")?.classList.add("error");
            valid = false;
        }

        if (!selectedTime) {
            const timeError = document.getElementById("timeError");
            if (timeError) timeError.style.display = "flex";
            document.querySelector(".slots-wrap")?.classList.add("error");
            valid = false;
        }

        if (!valid) return;

        const form = document.getElementById("rescheduleForm");
        if (!form || !form.action) {
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
                closeRescheduleModal();

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
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fa-solid fa-check"></i> Confirm Reschedule';
                }
                alert(data?.message ?? "Something went wrong. Please try again.");
            }
        } catch (err) {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa-solid fa-check"></i> Confirm Reschedule';
            }
            alert("Network error. Please try again.");
        }
    });
</script>
