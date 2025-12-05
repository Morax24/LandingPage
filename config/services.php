<?php

return [
    // ... kode lainnya ...

    'postmark' => [
        // ...
    ],

    'ses' => [
        // ...
    ],

    'resend' => [
        // ...
    ],

    'slack' => [
        // ...
    ],

    // TAMBAHKAN INI ↓
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URL'),
    ],

];
