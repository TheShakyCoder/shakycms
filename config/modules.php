<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Module registry
    |--------------------------------------------------------------------------
    |
    | Every module the application knows about. Each entry is a class that
    | implements App\Modules\Contracts\Module. Activation state is stored in
    | the `modules` table and synced from this list via `php artisan modules:sync`.
    |
    */

    'registry' => [
        App\Modules\Auth\AuthModule::class,
        App\Modules\Stats\StatsModule::class,
        App\Modules\Testimonial\TestimonialModule::class,
    ],

];
