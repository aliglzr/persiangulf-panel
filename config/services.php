<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => '/auth/google/callback',
    ],


    'recaptcha' => [
        'site_key'     => env('RECAPTCHA_SiTE_KEY'),
        'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    ],

    'facebook' => [
        'client_id'     => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect'      => '/auth/redirect/facebook',
    ],

    'telegram-bot-api' => [
        'token' => env('TELEGRAM_BOT_TOKEN', '5985430900:AAER7MHKpCm6Z-EjVHzRzbrCAJB878glaxk')
    ],

    'alchemy' => [
        'app_api_token' => env('ALCHEMY_APP_API_TOKEN', ''),
        'auth_token' => env('ALCHEMY_AUTH_TOKEN', ''),
    ],

    'backup' => [
        'take_backup_in_schedule' => env('TAKE_BACKUP_IN_SCHEDULE',false),
        'take_backup_daily_at' => env('TAKE_BACKUP_DAILY_AT','00:30'),
        'clean_backup_daily_at' => env('CLEAN_BACKUP_DAILY_AT','00:00')
    ]
];
