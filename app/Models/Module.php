<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

/**
 * Persists only the activation state of a module. The module's identity
 * (name, description, default state) lives in its module class — see
 * App\Modules\Contracts\Module — so this table never drifts from the code.
 */
#[Fillable(['key', 'active', 'config'])]
class Module extends Model
{
    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'config' => 'array',
        ];
    }
}
