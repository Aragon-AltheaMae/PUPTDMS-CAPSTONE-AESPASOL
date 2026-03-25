<?php

return [

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // ✅ MOVE THIS OUTSIDE
    'oidc' => [
            'authorize_url' => env('OIDC_AUTHORIZE_URL'),
            'token_url' => env('OIDC_TOKEN_URL'),
            'me_url' => env('OIDC_ME_URL'),
            'logout_url' => env('OIDC_LOGOUT_URL'),
            'client_id' => env('OIDC_CLIENT_ID'),
            'client_secret' => env('OIDC_CLIENT_SECRET'),
            'redirect' => env('OIDC_REDIRECT_URI'),
            ],

    'idp' => [
    'login_url' => env('IDP_LOGIN_URL'),
],

];
