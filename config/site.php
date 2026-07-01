<?php

return [
    'fullname' => env('SITE_FULLNAME', ''),
    'shortname' => env('SITE_SHORTNAME', ''),
    'address' => env('SITE_ADDRESS', ''),
    'telephone' => env('SITE_TELEPHONE', ''),
    'email' => env('SITE_EMAIL', ''),
    'established' => env('SITE_ESTABLISHED', ''),
    'opening_times' => explode(', ', env('SITE_OPENING_TIMES', '')),
    'description' => env('SITE_DESCRIPTION', ''),
    
    'social' => [
        'instagram' => 'https://www.instagram.com',
        'facebook' => 'https://www.facebook.com',
        'tiktok' => 'https://www.tiktok.com',
    ],

    'nav_links' => [
        ['label' => 'Home', 'href' => '/'],
    ],

    'robots_allowed' => env('ROBOTS_ALLOWED', false),
];