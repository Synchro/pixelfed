<?php

return [

    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => 'default',
            'retry_after' => 1800,
            'block_for' => null,
            'after_commit' => true,
        ],
    ],

];
