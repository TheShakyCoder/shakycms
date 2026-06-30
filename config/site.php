<?php

return [
    'fullname' => env('SITE_FULLNAME', 'Woodvale & Ainsdale Community Association'),
    'address' => env('SITE_ADDRESS', 'Meadow Lane, Woodvale, Merseyside. PR8 3RS'),
    'telephone' => env('SITE_TELEPHONE', '01704 573084'),
    'email' => env('SITE_EMAIL', 'manager@woodvalecentre.co.uk'),
    'established' => env('SITE_ESTABLISHED', '1991'),
    'opening_times' => [
        "Monday - Friday: 9:00am - 6:00pm",
        "Saturday: 10:00am - 4:00pm",
    ],

    'social' => [
        'instagram' => 'https://www.instagram.com',
        'facebook' => 'https://www.facebook.com',
        'tiktok' => 'https://www.tiktok.com',
    ],

    'nav_links' => [
        ['label' => 'Home', 'href' => '/'],
        ['label' => 'Our Sweets', 'href' => '#sweets'],
        ['label' => 'About', 'href' => '#about'],
        ['label' => 'Events', 'href' => '#events'],
        ['label' => 'News', 'href' => '/news-updates'],
        ['label' => 'Contact', 'href' => '#contact'],
    ],

    'robots_allowed' => env('ROBOTS_ALLOWED', false),
];