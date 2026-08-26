const modalTimers = {};

function openModal(id) {
    const modal =
        document.getElementById(id);

    if (!modal) return;

    if (modalTimers[id]) {
        clearTimeout(modalTimers[id]);
        modalTimers[id] = null;
    }

    modal.classList.remove('closing');
    modal.classList.add('open');
    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add(
        'modal-lock'
    );

    document.dispatchEvent(
        new CustomEvent(
            'ui-modal:opened',
            {
                detail: {
                    modal
                }
            }
        )
    );
}

function closeModal(id) {
    const modal = document.getElementById(id);

    if (
        !modal ||
        (
            !modal.classList.contains('open') &&
            !modal.classList.contains('closing')
        )
    ) {
        return;
    }

    const focusedElement = document.activeElement;

    if (modal.contains(focusedElement)) {
        focusedElement.blur();
    }

    modal.setAttribute(
        'aria-hidden',
        'true'
    );

    modal.classList.remove('open');
    modal.classList.add('closing');

    if (modalTimers[id]) {
        clearTimeout(modalTimers[id]);
    }

    modalTimers[id] = setTimeout(() => {

        modal.classList.remove(
            'closing'
        );

        modalTimers[id] = null;

        const activeModal =
            document.querySelector(
                [
                    '.ui-modal.open',
                    '.ui-modal.closing',
                    '.modal-overlay.open',
                    '.modal-overlay.closing'
                ].join(',')
            );

        if (!activeModal) {
            document.body.classList.remove(
                'modal-lock'
            );
        }

    }, 180);
}

function closeModalOnBackdrop(event, id) {
    return false;
}

document.addEventListener(
    'click',
    function (event) {
        const openButton =
            event.target.closest(
                '[data-open-modal]'
            );

        if (!openButton) {
            return;
        }

        const modalId =
            openButton.dataset.openModal;

        if (!modalId) {
            return;
        }

        event.preventDefault();

        openModal(modalId);
    }
);

document.addEventListener('click', function (event) {
    const closeButton =
        event.target.closest(
            '[data-modal-close]'
        );

    if (!closeButton) {
        return;
    }

    const modalId =
        closeButton.dataset.modalClose;

    if (!modalId) {
        return;
    }

    event.preventDefault();
    event.stopPropagation();

    closeModal(modalId);
});

document.addEventListener(
    'click',
    function (event) {
        const confirmButton =
            event.target.closest(
                '[data-start-modal-confirm]'
            );

        if (!confirmButton) {
            return;
        }

        const modal =
            confirmButton.closest(
                '[data-start-procedure-modal]'
            );

        if (!modal) {
            return;
        }

        const startUrl =
            modal.dataset.startUrl || '';

        if (!startUrl) {
            console.error(
                'Start Procedure URL is missing.'
            );

            return;
        }

        event.preventDefault();

        window.location.href =
            startUrl;
    }
);

document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') return;

    const openModalEl =
        document.querySelector(
            [
                '.ui-modal.open',
                '.modal-overlay.open'
            ].join(',')
        );

    if (!openModalEl?.id) return;

    if (
        openModalEl.hasAttribute(
            'data-modal-static'
        )
    ) {
        event.preventDefault();
        event.stopImmediatePropagation();
        return;
    }

    const hasDiscardForm =
        Boolean(
            openModalEl.querySelector(
                'form[data-discard-form]'
            )
        );

    if (
        hasDiscardForm &&
        window.DiscardChanges
    ) {
        event.preventDefault();
        event.stopImmediatePropagation();

        window.DiscardChanges.confirmClose(
            openModalEl,
            function () {
                closeModal(openModalEl.id);
            }
        );

        return;
    }

    closeModal(openModalEl.id);
});

window.openModal = openModal;
window.closeModal = closeModal;
window.closeModalOnBackdrop = closeModalOnBackdrop;

window.openInventoryModal = openModal;
window.closeInventoryModal = closeModal;
window.closeOnBackdrop = closeModalOnBackdrop;