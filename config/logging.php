<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;

return [

    'channels' => [
        'media' => [
            'driver' => 'single',
            'bubble' => false,
            'path' => storage_path('logs/media.log'),
            'level' => 'debug',
        ],
    ],

];
