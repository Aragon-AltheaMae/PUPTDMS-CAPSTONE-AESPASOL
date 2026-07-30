<div id="toastContainer" role="region" aria-live="polite"></div>

@php
$flashToasts = [];

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

if (request('reason') === 'idle') {
$flashToasts[] = [
'type' => 'warning',
'title' => 'Session Timeout',
'message' => 'Your session ended after 10 minutes of inactivity. Please sign in again.',
];
} elseif (request()->boolean('logged_out')) {
$flashToasts[] = [
'type' => 'success',
'title' => 'Signed Out',
'message' => 'You have been signed out successfully.',
];
}
@endphp

<script type="application/json" id="flashToastPayload">
{!! json_encode($flashToasts, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) !!}
</script>