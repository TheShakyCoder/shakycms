<?php

namespace App\Modules\Testimonial;

use App\Contracts\Module;

/**
 * Testimonial module.
 *
 * When active, staff can manage customer testimonials (CRUD) from the
 * internal area.
 */
class TestimonialModule implements Module
{
    public function key(): string
    {
        return 'testimonials';
    }

    public function name(): string
    {
        return 'Testimonials';
    }

    public function description(): string
    {
        return 'Manage customer testimonials.';
    }

    public function route(): ?string
    {
        return 'internal.testimonials.index';
    }
}
