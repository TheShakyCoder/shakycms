<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Attribute;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

#[Fillable(['role_id', 'controller_method_name'])]
class Right extends Model
{
    use HasFactory, HasUuids;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function route():  Attribute
    {
        return Attribute::make(
            get: fn() => collect(Route::getRoutes()->getRoutes())
                ->filter(fn($item) => str_starts_with($item->uri, 'internal') && $item->action['as'] == $this->controller_method_name)
                ->first()
        );
    }
}
