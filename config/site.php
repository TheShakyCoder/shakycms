<?php

return [
    'fullname' => env('SITE_FULLNAME', 'Acme Master'),
    'shortname' => env('SITE_SHORTNAME', 'Acme'),
    'address' => env('SITE_ADDRESS', 'Moorhey Drive, Penwortham, Preston, PR1 0SS'),
    'telephone' => env('SITE_TELEPHONE', '07515 382159'),
    'email' => env('SITE_EMAIL', 'support@example.com'),
    'established' => env('SITE_ESTABLISHED', '2011'),
    'opening_times' => env('SITE_OPENING_TIMES', ["Monday - Friday: 10:00am - 5:00pm", "Saturday - Sunday: Closed"]),
    'description' => env('SITE_DESCRIPTION', 'Serving the Woodvale and Ainsdale communities with a range of activities and events.'),
    
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