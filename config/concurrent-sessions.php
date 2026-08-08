<?php

return [
    'enabled' => env('CONCURRENT_SESSIONS_ENABLED', true),

    'default_limit' => (int) env('CONCURRENT_SESSIONS_DEFAULT_LIMIT', 1),

    'role_limits' => [
        'super_admin' => (int) env('CONCURRENT_SESSIONS_SUPER_ADMIN_LIMIT', 1),
        'admin' => (int) env('CONCURRENT_SESSIONS_ADMIN_LIMIT', 1),
        'dentist' => (int) env('CONCURRENT_SESSIONS_DENTIST_LIMIT', 1),
        'patient' => (int) env('CONCURRENT_SESSIONS_PATIENT_LIMIT', 1),
    ],

    'strategy' => env('CONCURRENT_SESSIONS_STRATEGY', 'replace_oldest'),

    'notify_on_replacement' => env('CONCURRENT_SESSIONS_NOTIFY_ON_REPLACEMENT', true),
];
