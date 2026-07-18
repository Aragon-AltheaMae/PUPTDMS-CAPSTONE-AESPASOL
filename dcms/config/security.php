<?php

return [
    'login' => [
        'max_attempts' => (int) env('SECURITY_LOGIN_MAX_ATTEMPTS', 5),
        'decay_seconds' => (int) env('SECURITY_LOGIN_DECAY_SECONDS', 60),
        'lockout_seconds' => (int) env('SECURITY_LOGIN_LOCKOUT_SECONDS', 900),
    ],
];
