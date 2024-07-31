<?php

return [

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'permissions' => [
                'file' => [
                    'public' => 0644,
                    'private' => 0600,
                ],
                'dir' => [
                    'public' => 0755,
                    'private' => 0700,
                ],
            ],
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => true,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'visibility' => env('AWS_VISIBILITY', 'public'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => true,
        ],

        'alt-primary' => [
            'enabled' => env('ALT_PRI_ENABLED', false),
            'driver' => 's3',
            'key' => env('ALT_PRI_AWS_ACCESS_KEY_ID'),
            'secret' => env('ALT_PRI_AWS_SECRET_ACCESS_KEY'),
            'region' => env('ALT_PRI_AWS_DEFAULT_REGION'),
            'bucket' => env('ALT_PRI_AWS_BUCKET'),
            'visibility' => 'public',
            'url' => env('ALT_PRI_AWS_URL'),
            'endpoint' => env('ALT_PRI_AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('ALT_PRI_AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => true,
        ],

        'alt-secondary' => [
            'enabled' => env('ALT_SEC_ENABLED', false),
            'driver' => 's3',
            'key' => env('ALT_SEC_AWS_ACCESS_KEY_ID'),
            'secret' => env('ALT_SEC_AWS_SECRET_ACCESS_KEY'),
            'region' => env('ALT_SEC_AWS_DEFAULT_REGION'),
            'bucket' => env('ALT_SEC_AWS_BUCKET'),
            'visibility' => 'public',
            'url' => env('ALT_SEC_AWS_URL'),
            'endpoint' => env('ALT_SEC_AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('ALT_SEC_AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => true,
        ],

        'spaces' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
            'visibility' => 'public',
            'options' => [
                'CacheControl' => 'max-age=31536000',
            ],
            'root' => env('DO_SPACES_ROOT', ''),
            'throw' => true,
            'url' => env('AWS_URL'),
        ],

        'backup' => [
            'driver' => env('PF_BACKUP_DRIVER', 's3'),
            'visibility' => 'private',
            'root' => env('PF_BACKUP_DRIVER', 'local') == 'local' ?
                storage_path('app/backups/') :
                env('PF_BACKUP_ROOT', '/'),
            'key' => env('PF_BACKUP_KEY'),
            'secret' => env('PF_BACKUP_SECRET'),
            'endpoint' => env('PF_BACKUP_ENDPOINT'),
            'region' => env('PF_BACKUP_REGION'),
            'bucket' => env('PF_BACKUP_BUCKET'),
        ],
    ],

];
