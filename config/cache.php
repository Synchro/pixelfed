<?php

return [

    'stores' => [
        'redis' => [
            'driver' => 'redis',
            'lock_connection' => 'default',
            'client' => env('REDIS_CLIENT', 'predis'),

            'default' => [
                'scheme' => env('REDIS_SCHEME', 'tcp'),
                'path' => env('REDIS_PATH'),
                'host' => env('REDIS_HOST', 'localhost'),
                'password' => env('REDIS_PASSWORD', null),
                'port' => env('REDIS_PORT', 6379),
                'database' => env('REDIS_DATABASE', 0),
            ],

        ],

        'redis:session' => [
            'driver' => 'redis',
            'connection' => 'default',
            'prefix' => 'pf_session',
        ],
    ],

    'limiter' => env('CACHE_LIMITER_DRIVER', 'redis'),

];
