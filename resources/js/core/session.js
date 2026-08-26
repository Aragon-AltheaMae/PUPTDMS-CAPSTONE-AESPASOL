function initSessionTimeoutModal() {
    const modal = document.querySelector(
        '[data-session-timeout-modal]'
    );

    if (
        !modal?.id ||
        modal.dataset.sessionTimeoutInitialized ===
        'true'
    ) {
        return;
    }

    modal.dataset.sessionTimeoutInitialized =
        'true';

    const primaryButton = modal.querySelector(
        '[data-session-timeout-primary]'
    );

    const timeoutSeconds = Math.max(
        60,
        Number(
            modal.dataset.sessionTimeoutSeconds
        ) || 600
    );

    const timeoutMilliseconds =
        timeoutSeconds * 1000;

    const activityUrl =
        modal.dataset.sessionActivityUrl;

    const expireUrl =
        modal.dataset.sessionExpireUrl;

    const redirectUrl =
        modal.dataset.sessionRedirectUrl ||
        '/';

    const sharedActivityKey =
        modal.dataset.sessionActivityKey ||
        '';

    const activitySyncInterval = 60000;

    let idleTimer = null;
    let sessionExpired = false;
    let redirectStarted = false;
    const expiredByServer =
        modal.dataset.sessionExpired === 'true';

    let activityRequestRunning = false;

    let lastActivityAt = Date.now();
    let lastHandledActivityAt = 0;
    let lastServerSyncAt = 0;
    let lastSharedActivityWriteAt = 0;

    const readSharedActivity = () => {
        if (!sharedActivityKey) return 0;

        try {
            const timestamp = Number(
                window.localStorage.getItem(
                    sharedActivityKey
                )
            );

            if (
                !Number.isFinite(timestamp) ||
                timestamp <= 0 ||
                timestamp > Date.now() + 5000
            ) {
                return 0;
            }

            return timestamp;
        } catch (_) {
            return 0;
        }
    };

    const writeSharedActivity = timestamp => {
        if (
            !sharedActivityKey ||
            timestamp - lastSharedActivityWriteAt < 1000
        ) {
            return;
        }

        lastSharedActivityWriteAt = timestamp;

        try {
            window.localStorage.setItem(
                sharedActivityKey,
                String(timestamp)
            );
        } catch (_) {
        }
    };

    lastActivityAt = Math.max(
        lastActivityAt,
        readSharedActivity()
    );

    writeSharedActivity(lastActivityAt);

    const requestHeaders = () => ({
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': window.getCsrfToken?.() || '',
    });

    const showSessionTimeoutModal = () => {
        if (sessionExpired) return;

        sessionExpired = true;
        window.__SESSION_EXPIRED__ = true;

        window.clearTimeout(idleTimer);

        document.documentElement.classList.add(
            'session-expired'
        );

        document.body.classList.add(
            'session-expired'
        );

        document
            .querySelectorAll('dialog[open]')
            .forEach(dialog => {
                try {
                    dialog.close();
                } catch (_) {
                    dialog.removeAttribute('open');
                }
            });

        document.documentElement.classList.remove(
            'intro-modal-open'
        );

        document.body.classList.remove(
            'intro-modal-open'
        );

        document.body.style.removeProperty(
            'position'
        );

        document.body.style.removeProperty(
            'width'
        );

        window.openModal?.(modal.id);

        requestAnimationFrame(() => {
            primaryButton?.focus({
                preventScroll: true,
            });
        });

        document.dispatchEvent(
            new CustomEvent(
                'session:expired'
            )
        );
    };

    const scheduleIdleTimeout = () => {
        if (sessionExpired) return;

        window.clearTimeout(idleTimer);

        const elapsed =
            Date.now() - lastActivityAt;

        const remaining =
            timeoutMilliseconds - elapsed;

        if (remaining <= 0) {
            showSessionTimeoutModal();
            return;
        }

        idleTimer = window.setTimeout(
            showSessionTimeoutModal,
            remaining
        );
    };

    const syncActivityWithServer = async () => {
        if (
            sessionExpired ||
            activityRequestRunning ||
            !activityUrl
        ) {
            return;
        }

        activityRequestRunning = true;
        lastServerSyncAt = Date.now();

        try {
            const response = await fetch(
                activityUrl,
                {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: requestHeaders(),
                    cache: 'no-store',
                }
            );

            if (
                response.status === 401 ||
                response.status === 419
            ) {
                showSessionTimeoutModal();
            }
        } catch (_) {
        } finally {
            activityRequestRunning = false;
        }
    };

    const registerUserActivity = () => {
        if (sessionExpired) return;

        const now = Date.now();

        if (
            now - lastHandledActivityAt <
            800
        ) {
            return;
        }

        lastHandledActivityAt = now;
        lastActivityAt = now;
        writeSharedActivity(now);

        scheduleIdleTimeout();

        if (
            now - lastServerSyncAt >=
            activitySyncInterval
        ) {
            syncActivityWithServer();
        }
    };

    [
        'pointerdown',
        'pointermove',
        'keydown',
        'scroll',
        'touchstart',
    ].forEach(eventName => {
        document.addEventListener(
            eventName,
            registerUserActivity,
            {
                capture: true,
                passive: true,
            }
        );
    });

    const checkIdleState = () => {
        if (sessionExpired) return;

        lastActivityAt = Math.max(
            lastActivityAt,
            readSharedActivity()
        );

        const idleDuration =
            Date.now() - lastActivityAt;

        if (
            idleDuration >=
            timeoutMilliseconds
        ) {
            showSessionTimeoutModal();
            return;
        }

        scheduleIdleTimeout();
    };

    window.addEventListener(
        'focus',
        checkIdleState
    );

    document.addEventListener(
        'visibilitychange',
        () => {
            if (
                document.visibilityState !==
                'visible' ||
                sessionExpired
            ) {
                return;
            }

            checkIdleState();
        }
    );

    window.addEventListener(
        'storage',
        event => {
            if (
                sessionExpired ||
                !sharedActivityKey ||
                event.key !== sharedActivityKey
            ) {
                return;
            }

            const timestamp = Number(event.newValue);

            if (
                !Number.isFinite(timestamp) ||
                timestamp <= lastActivityAt ||
                timestamp > Date.now() + 5000
            ) {
                return;
            }

            lastActivityAt = timestamp;
            scheduleIdleTimeout();
        }
    );

    document.addEventListener(
        'submit',
        event => {
            if (!sessionExpired) return;

            event.preventDefault();
            event.stopImmediatePropagation();
        },
        true
    );

    document.addEventListener(
        'click',
        event => {
            if (!sessionExpired) return;

            const signInAgainButton =
                event.target.closest(
                    '[data-session-timeout-primary]'
                );

            if (signInAgainButton) {
                return;
            }

            event.preventDefault();
            event.stopImmediatePropagation();
        },
        true
    );

    primaryButton?.addEventListener(
        'click',
        async () => {
            if (redirectStarted) return;

            redirectStarted = true;
            primaryButton.disabled = true;

            primaryButton.innerHTML = `
                <i class="fa-solid fa-spinner fa-spin"></i>
                <span>Opening Sign In...</span>
            `;

            try {
                if (expireUrl) {
                    await fetch(
                        expireUrl,
                        {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: requestHeaders(),
                            cache: 'no-store',
                        }
                    );
                }
            } catch (_) {
            } finally {
                window.location.assign(
                    redirectUrl
                );
            }
        }
    );

    if (expiredByServer) {
        showSessionTimeoutModal();
    } else {
        scheduleIdleTimeout();
    }
}

function acceptTerms() {
    const modal = document.getElementById('termsModal');

    if (modal?.open) {
        modal.close();
    }
}

function initTermsModal() {
    const modal = document.getElementById('termsModal');
    if (!modal) return;

    const checkbox = modal.querySelector('#termsCheckbox, [data-terms-checkbox]');
    const continueBtn = modal.querySelector('#termsContinueBtn, [data-terms-continue]');

    if (checkbox && continueBtn) {
        checkbox.checked = false;
        continueBtn.disabled = true;

        checkbox.addEventListener('change', () => {
            continueBtn.disabled = !checkbox.checked;
        });

        continueBtn.addEventListener('click', acceptTerms);
    }

    const shouldShow = modal.dataset.showTerms === 'true';

    if (shouldShow && typeof modal.showModal === 'function' && !modal.open) {
        requestAnimationFrame(() => {
            modal.showModal();
        });
    }
}

document.addEventListener(
    'DOMContentLoaded',
    () => {
        initTermsModal();
        initSessionTimeoutModal();
    }
);

window.acceptTerms = acceptTerms;
window.initTermsModal = initTermsModal;
window.initSessionTimeoutModal = initSessionTimeoutModal;