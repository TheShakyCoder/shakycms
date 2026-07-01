<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['author', 'role', 'headline', 'quote', 'rating', 'homepage', 'featured', 'order'])]
class Testimonial extends Model
{
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'homepage' => 'boolean',
            'featured' => 'boolean',
        ];
    }

    /** Testimonials in display order. */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('id');
    }
}
