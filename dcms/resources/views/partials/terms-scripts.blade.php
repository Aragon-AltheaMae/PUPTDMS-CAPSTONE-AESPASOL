<script>
    document.addEventListener('DOMContentLoaded', function () {
        const termsModal = document.getElementById('termsModal');
        const termsCheckbox = document.getElementById('termsCheckbox');
        const termsContinueBtn = document.getElementById('termsContinueBtn');

        if (termsCheckbox && termsContinueBtn) {
            termsCheckbox.checked = false;
            termsContinueBtn.disabled = true;

            termsCheckbox.addEventListener('change', function () {
                termsContinueBtn.disabled = !this.checked;
            });
        }

        // 1. Convert the Laravel session value directly into a JS boolean
        const showTermsModal = {{ session('show_terms_modal') ? 'true' : 'false' }};
        
        // 2. Use standard JavaScript logic to open the modal
        if (showTermsModal && termsModal) {
            termsModal.showModal();
        }
    });

    function acceptTerms() {
        const termsModal = document.getElementById('termsModal');
        if (termsModal) {
            termsModal.close();
        }
        // If you need to hit an endpoint to save their acceptance in the DB, 
        // you would add an AJAX/Fetch request here.
    }
</script>