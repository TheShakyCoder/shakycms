<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['value', 'label', 'icon', 'order'])]
class Stat extends Model
{
    /** Stats in display order. */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('id');
    }
}
