<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Concerns\TracksFieldChanges;

#[Fillable(['title', 'slug', 'description', 'content', 'thumbnail_id'])]
class Post extends Model
{
    use SoftDeletes, HasUuids, TracksFieldChanges;

    public function thumbnail()
    {
        return $this->belongsTo(\App\Models\Media::class, 'thumbnail_id');
    }
}
