<?php

return [

    'defaults' => [
        'guard'     => 'parent',
        'passwords' => 'parents',
    ],

    'guards' => [
        'parent' => [
            'driver'   => 'jwt',
            'provider' => 'parents',
        ],
        'child' => [
            'driver'   => 'jwt',
            'provider' => 'children',
        ],
    ],

    'providers' => [
        'parents' => [
            'driver' => 'eloquent',
            'model'  => App\Models\ParentProfile::class,
        ],
        'children' => [
            'driver' => 'eloquent',
            'model'  => App\Models\ChildProfile::class,
        ],
    ],

    'passwords' => [
        'parents' => [
            'provider' => 'parents',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];
