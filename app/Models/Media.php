<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Media extends Model
{
    use HasUuids;

    protected $fillable = ['filename', 'path', 'disk', 'mime_type', 'size', 'alt', 'uploaded_by'];

    protected $appends = ['url'];

    public function url(): Attribute
    {
        return Attribute::make(
            get: function () {
                $config  = config('filesystems.disks.s3', []);
                $baseUrl = rtrim($config['url'] ?? '', '/');

                if (! $baseUrl && isset($config['endpoint'], $config['bucket'])) {
                    $baseUrl = rtrim($config['endpoint'], '/') . '/' . $config['bucket'];
                }

                return $baseUrl . '/' . ltrim($this->path, '/');
            },
        );
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
