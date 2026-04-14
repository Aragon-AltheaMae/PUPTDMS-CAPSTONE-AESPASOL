<style>
    .doc-modal::backdrop {
        background: rgba(0, 0, 0, 0.6);
    }

    .doc-modal {
        border: none;
        padding: 0;
        border-radius: 16px;
        width: 100%;
        max-width: 420px;
    }

    .doc-modal-inner {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
    }

    .doc-modal-header {
        background: linear-gradient(135deg, #660000, #8B0000);
        color: white;
        padding: 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .doc-eyebrow {
        font-size: 10px;
        text-transform: uppercase;
        opacity: .7;
    }

    .doc-title {
        font-size: 18px;
        font-weight: 700;
    }

    .doc-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        color: white;
        cursor: pointer;
    }

    .doc-form {
        padding: 16px;
    }

    .doc-group {
        margin-bottom: 14px;
    }

    .doc-group label {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 4px;
        display: block;
    }

    .doc-group input,
    .doc-group textarea {
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 8px;
        font-size: 13px;
    }

    .doc-submit {
        width: 100%;
        background: #8B0000;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 8px;
        font-weight: 600;
    }

    .doc-success-modal::backdrop {
        background: rgba(0, 0, 0, 0.6);
    }

    .doc-success-inner {
        background: white;
        padding: 24px;
        text-align: center;
        border-radius: 16px;
    }

    .doc-success-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #16a34a;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 22px;
    }

    .doc-success-btn {
        margin-top: 12px;
        background: #8B0000;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
    }

    .doc-native-select {
        width: 100%;
        max-width: 100%;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image:
            linear-gradient(45deg, transparent 50%, #8B0000 50%),
            linear-gradient(135deg, #8B0000 50%, transparent 50%);
        background-position:
            calc(100% - 18px) calc(50% - 3px),
            calc(100% - 12px) calc(50% - 3px);
        background-size: 6px 6px, 6px 6px;
        background-repeat: no-repeat;
        padding-right: 2.75rem;
    }

    .doc-native-select option {
        white-space: normal;
    }
</style>

<dialog id="dentalClearanceModal" class="modal">
    <form id="clearanceRequestForm" method="POST" action="{{ route('patient.document.requests.store') }}"
        class="modal-box w-[min(92vw,420px)] max-w-[420px] rounded-2xl bg-white shadow-xl relative" novalidate>
        @csrf
        <div id="clearanceWarning"
            class="hidden absolute top-4 left-1/2 -translate-x-1/2 px-12 py-2 rounded-full bg-red-600 text-white text-xs font-bold shadow-lg">
            Please complete all required fields.</div>
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-full bg-red-50 text-[#8B0000] flex items-center justify-center"><i
                    class="fa-solid fa-file-circle-check text-lg"></i></div>
            <h3 class="font-extrabold text-2xl text-gray-800">Clearance</h3>
        </div>
        <p class="text-sm text-gray-500 mb-6 border-b border-gray-100 pb-4">Please allow up to three (3)
            working
            days for processing.</p>

        <div class="space-y-5">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Type of
                    Clearance</label>
                <select name="document_type" required
                    class="doc-native-select w-full rounded-xl border-gray-200 bg-gray-50 text-gray-700 focus:ring-2 focus:ring-red-900 focus:border-red-900 py-3 px-4 transition-all">
                    <option value="" disabled selected>Select type of clearance</option>
                    <option value="Dental Clearance">Dental Clearance</option>
                    <option value="Annual Dental Clearance">Annual Dental Clearance</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Purpose</label>
                <select name="purpose" required
                    class="doc-native-select w-full rounded-xl border-gray-200 bg-gray-50 text-gray-700 focus:ring-2 focus:ring-red-900 focus:border-red-900 py-3 px-4 transition-all">
                    <option value="" disabled selected>Select purpose</option>
                    <option value="On-the-Job Training (OJT)">On-the-Job Training (OJT)</option>
                    <option value="Employment Requirement">Employment Requirement</option>
                    <option value="Academic Requirement">Academic Requirement</option>
                </select>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <button type="button" onclick="dentalClearanceModal.close()"
                class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition-colors">Cancel</button>
            <button type="submit"
                class="px-6 py-2.5 rounded-xl bg-[#8B0000] hover:bg-[#660000] text-white font-bold shadow-md transition-colors">Submit
                Request</button>
        </div>
    </form>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

<dialog id="dentalHealthRecordModal" class="modal">
    <form id="healthRecordRequestForm" method="POST" action="{{ route('patient.document.requests.store') }}"
        class="modal-box w-[min(92vw,420px)] max-w-[420px] rounded-2xl bg-white shadow-xl relative" novalidate>
        @csrf
        <div id="healthRecordWarning"
            class="hidden absolute top-4 left-1/2 -translate-x-1/2 px-12 py-2 rounded-full bg-red-600 text-white text-xs font-bold shadow-lg">
            Please complete all required fields.</div>
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-full bg-red-50 text-[#8B0000] flex items-center justify-center"><i
                    class="fa-solid fa-file-medical text-lg"></i></div>
            <h3 class="font-extrabold text-2xl text-gray-800">Health Record</h3>
        </div>
        <p class="text-sm text-gray-500 mb-6 border-b border-gray-100 pb-4">Please allow up to three (3)
            working
            days for processing.</p>

        <div class="space-y-5">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Type of
                    Record</label>
                <select name="document_type" required
                    class="doc-native-select w-full rounded-xl border-gray-200 bg-gray-50 text-gray-700 focus:ring-2 focus:ring-red-900 focus:border-red-900 py-3 px-4 transition-all">
                    <option value="" disabled selected>Select type</option>
                    <option value="All Dental Records">All Dental Records</option>
                    <option value="Medical Records">Medical Records</option>
                    <option value="Diagnosis and Treatment">Diagnosis and Treatment</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Purpose</label>
                <select name="purpose" required
                    class="doc-native-select w-full rounded-xl border-gray-200 bg-gray-50 text-gray-700 focus:ring-2 focus:ring-red-900 focus:border-red-900 py-3 px-4 transition-all">
                    <option value="" disabled selected>Select purpose</option>
                    <option value="Personal Record">Personal Record</option>
                    <option value="Academic Requirement">Academic Requirement</option>
                    <option value="Employment Requirement">Employment Requirement</option>
                </select>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <button type="button" onclick="dentalHealthRecordModal.close()"
                class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition-colors">Cancel</button>
            <button type="submit"
                class="px-6 py-2.5 rounded-xl bg-[#8B0000] hover:bg-[#660000] text-white font-bold shadow-md transition-colors">Submit
                Request</button>
        </div>
    </form>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

<div id="docSuccessModal"
    class="fixed inset-0 z-[20000] flex items-center justify-center bg-gray-900/70 backdrop-blur-md transition-opacity duration-300 opacity-0 pointer-events-none hidden">
    <div class="relative z-[20001] bg-white w-full max-w-sm rounded-3xl p-6 md:p-8 text-center shadow-2xl transform scale-95 transition-transform duration-300"
        id="docSuccessModalContent">

        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-5">
            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-check text-3xl text-green-500"></i>
            </div>
        </div>

        <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Request Sent!</h3>
        <p class="text-sm text-gray-500 mb-8 leading-relaxed">
            Your document request has been successfully submitted. We will process it shortly and notify you once it's
            ready. Have a great day!
        </p>

        <button onclick="closeDocSuccessModal()"
            class="w-full bg-[#8B0000] hover:bg-[#6b0000] text-white font-bold py-3.5 px-4 rounded-xl transition-colors shadow-md shadow-red-900/20">
            Okay, got it!
        </button>
    </div>
</div>

<script>
    function closeDocModal(id) {
        document.getElementById(id)?.close();
    }

    function openDocModal(id) {
        document.getElementById(id)?.showModal();
    }

    function openDocSuccessModal() {
        const modal = document.getElementById('docSuccessModal');
        const content = document.getElementById('docSuccessModalContent');

        const sidebar = document.getElementById('sidebar');
        const mobileBottomNav = document.getElementById('mobileBottomNav');
        const mobFabMenu = document.getElementById('mobFabMenu');

        sidebar?.classList.add('pointer-events-none');
        mobileBottomNav?.classList.add('pointer-events-none');
        mobFabMenu?.classList.add('pointer-events-none');

        if (!modal || !content) return;

        document.body.classList.add('overflow-hidden');

        modal.classList.remove('hidden');
        modal.classList.remove('pointer-events-none');
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }

    function closeDocSuccessModal() {
        const modal = document.getElementById('docSuccessModal');
        const content = document.getElementById('docSuccessModalContent');

        const sidebar = document.getElementById('sidebar');
        const mobileBottomNav = document.getElementById('mobileBottomNav');
        const mobFabMenu = document.getElementById('mobFabMenu');

        sidebar?.classList.remove('pointer-events-none');
        mobileBottomNav?.classList.remove('pointer-events-none');
        mobFabMenu?.classList.remove('pointer-events-none');

        if (!modal || !content) return;

        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        modal.classList.add('pointer-events-none');
        document.body.classList.remove('overflow-hidden');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function showInlineWarning(warningEl, message) {
        if (!warningEl) return;
        warningEl.textContent = message;
        warningEl.classList.remove('hidden');

        setTimeout(() => {
            warningEl.classList.add('hidden');
        }, 2500);
    }

    async function submitDocumentRequestForm(formId, modalId, warningId) {
        const form = document.getElementById(formId);
        const modal = document.getElementById(modalId);
        const warningEl = document.getElementById(warningId);

        if (!form) return;

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const documentType = form.querySelector('[name="document_type"]');
            const purpose = form.querySelector('[name="purpose"]');
            const submitBtn = form.querySelector('button[type="submit"]');

            if (!documentType?.value || !purpose?.value) {
                showInlineWarning(warningEl, 'Please complete all required fields');
                return;
            }

            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Submitting...';

            try {
                const formData = new FormData(form);

                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    showInlineWarning(warningEl, data.message || 'Failed to submit request.');
                    return;
                }

                if (modal && typeof modal.close === 'function') {
                    modal.close();
                }

                form.reset();
                openDocSuccessModal();
            } catch (error) {
                showInlineWarning(warningEl, 'Something went wrong. Please try again.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const successModal = document.getElementById('docSuccessModal');
        if (successModal) {
            successModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDocSuccessModal();
                }
            });
        }

        submitDocumentRequestForm(
            'clearanceRequestForm',
            'dentalClearanceModal',
            'clearanceWarning'
        );

        submitDocumentRequestForm(
            'healthRecordRequestForm',
            'dentalHealthRecordModal',
            'healthRecordWarning'
        );
    });
</script>
