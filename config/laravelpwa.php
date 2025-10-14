<?php

return [
    'name' => 'Repflux',
    'manifest' => [
        'name' => 'Repflux',
        'short_name' => 'Repflux',
        'start_url' => '/app',
        'background_color' => '#333333',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation' => 'natural',
        'status_bar' => 'black',
        'icons' => [
            // TODO: generate lower res versions too
            '512x512' => [
                'path' => '/logos/pwa.png',
                'purpose' => 'any',
            ],
        ],
        'splash' => [
            // TODO: generate lower res versions too
            '640x1136' => '/images/icons/splash-2048x2732.png',
            '750x1334' => '/images/icons/splash-2048x2732.png',
            '1242x2208' => '/images/icons/splash-2048x2732.png',
            '1125x2436' => '/images/icons/splash-2048x2732.png',
            '828x1792' => '/images/icons/splash-2048x2732.png',
            '1242x2688' => '/images/icons/splash-2048x2732.png',
            '1536x2048' => '/images/icons/splash-2048x2732.png',
            '1668x2224' => '/images/icons/splash-2048x2732.png',
            '1668x2388' => '/images/icons/splash-2048x2732.png',
            '2048x2732' => '/images/icons/splash-2048x2732.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Add weight',
                'description' => 'Add new weight measurement',
                'url' => '/shortcut/weights/create',
            ],
            [
                'name' => 'Record a set',
                'description' => 'Add new exercise set',
                'url' => '/shortcut/record-sets/create',
            ],
        ],
        'custom' => [],
    ],
];
