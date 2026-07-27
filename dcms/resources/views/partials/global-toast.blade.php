<div id="toastContainer" role="region" aria-live="polite"></div>

@php
    $flashToasts = [];
    $showSessionTimeoutModal = request('reason') === 'idle';

    if (session('success')) {
        $flashToasts[] = [
            'type' => 'success',
            'title' => 'Success',
            'message' => session('success'),
        ];
    }

    if (session('error')) {
        $flashToasts[] = [
            'type' => 'error',
            'title' => 'Error',
            'message' => session('error'),
        ];
    }

    if ($errors->any()) {
        $flashToasts[] = [
            'type' => 'error',
            'title' => 'Validation Error',
            'message' => $errors->first(),
        ];
    }

    if (session('login_as')) {
        $flashToasts[] = [
            'type' => 'success',
            'title' => 'Login Successful',
            'message' => 'Logged in successfully as <strong>' . session('login_as') . '</strong>',
        ];
    }

    if (!$showSessionTimeoutModal && request()->boolean('logged_out')) {
        $flashToasts[] = [
            'type' => 'success',
            'title' => 'Signed Out',
            'message' => 'You have been signed out successfully.',
        ];
    }
@endphp

@if ($showSessionTimeoutModal)
    <div id="sessionTimeoutModal" class="ui-modal modal-theme-warning" data-session-timeout-modal aria-hidden="true">
        <div class="ui-modal-card modal-sm" role="dialog" aria-modal="true" aria-labelledby="sessionTimeoutTitle"
            aria-describedby="sessionTimeoutDescription">
            <div class="modal-hd">
                <div class="modal-heading">
                    <div class="modal-icon">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>

                    <div class="modal-copy">
                        <h2 id="sessionTimeoutTitle" class="modal-title">
                            Session Timeout
                        </h2>

                        <p class="modal-subtitle">
                            You were signed out automatically for security.
                        </p>
                    </div>
                </div>
            </div>

            <div class="modal-bd">
                <div class="global-confirm-alert global-confirm-alert--centered">
                    <i class="fa-solid fa-triangle-exclamation"></i>

                    <div class="global-confirm-alert-copy">
                        <p id="sessionTimeoutDescription">
                            Your session ended after 10 minutes of inactivity.
                        </p>

                        <span>
                            Please sign in again to continue securely.
                        </span>
                    </div>
                </div>
            </div>

            <div class="modal-ft modal-ft--centered">
                <button type="button" class="modal-btn-primary" data-session-timeout-primary
                    data-redirect-url="{{ url('/') }}">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Sign In</span>
                </button>
            </div>
        </div>
    </div>
@endif

<script type="application/json" id="flashToastPayload">
{!! json_encode(
    $flashToasts,
    JSON_HEX_TAG |
    JSON_HEX_APOS |
    JSON_HEX_AMP |
    JSON_HEX_QUOT |
    JSON_UNESCAPED_UNICODE
) !!}
</script>
