<div id="cancelAppointmentModal"
    class="fixed inset-0 bg-black/50 flex items-end sm:items-center justify-center backdrop-blur-sm hidden z-[9999] p-0 sm:p-4"
    onclick="handleCancelBackdropClick(event)">
    <div
        class="cancel-modal-panel bg-white w-full sm:w-[620px] rounded-t-2xl sm:rounded-2xl overflow-hidden shadow-2xl">
        <div class="relative bg-gradient-to-r from-[#7f0000] to-[#b91c1c] px-6 sm:px-8 pt-5 pb-7 sm:pb-8">
            <button onclick="closeCancelAppointmentModal()"
                class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white/70 hover:text-white flex items-center justify-center transition text-sm">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="flex justify-center mb-3">
                <div class="cancel-icon-ring">
                    <div class="cancel-icon-core"><i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i>
                    </div>
                </div>
            </div>
            <h2 class="text-center text-white font-bold text-lg leading-tight">Cancel Appointment</h2>
            <p class="text-center text-white/60 text-xs mt-1">This action cannot be undone.</p>
        </div>
        <div class="px-6 sm:px-8 py-5 sm:py-6 bg-gray-50">
            <div class="bg-white border border-gray-100 rounded-xl px-4 sm:px-5 py-4 mb-4 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-full bg-red-50 border border-red-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-regular fa-circle-user text-red-400 text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5">Patient</p>
                        <p class="text-[14px] font-bold text-gray-800 truncate" id="cancelPatientName">—</p>
                    </div>
                    <div class="text-left sm:text-right flex-shrink-0">
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400 mb-0.5">Scheduled</p>
                        <p class="text-[12px] font-medium text-gray-600" id="cancelAppointmentDate">—</p>
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
                    <div class="reason-chip"><input type="radio" name="cancelReason" id="r4" value="Emergency"><label
                            for="r4"><i class="fa-solid fa-bolt text-[11px]"></i>
                            Emergency</label></div>
                    <div class="reason-chip"><input type="radio" name="cancelReason" id="r5" value="Rescheduled"><label
                            for="r5"><i class="fa-solid fa-rotate text-[11px]"></i>
                            Rescheduled</label></div>
                </div>
                <div id="reasonError"
                    class="hidden mt-2.5 flex items-center gap-1.5 text-red-500 text-[12px] font-semibold">
                    <i class="fa-solid fa-circle-exclamation text-[11px]"></i> Please select a reason before
                    cancelling.
                </div>
            </div>
            <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center gap-3">
                <button onclick="closeCancelAppointmentModal()"
                    class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-600 font-semibold hover:bg-gray-50 transition text-sm shadow-sm">
                    <i class="fa-solid fa-arrow-left text-xs mr-1.5"></i>Keep
                </button>
                <button id="confirmCancelBtn" onclick="confirmCancelAppointment()"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#8b0000] to-[#c0392b] text-white font-bold hover:from-[#6f0000] hover:to-[#a93226] transition text-sm shadow-md active:scale-[.98]">
                    <i class="fa-solid fa-ban text-xs mr-1.5"></i>Yes, Cancel
                </button>
            </div>
        </div>
    </div>
</div>