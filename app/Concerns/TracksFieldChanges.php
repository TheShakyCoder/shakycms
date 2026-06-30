<?php

namespace App\Concerns;

use App\Models\FieldChange;

/**
 * Add this trait to any Eloquent model to automatically log
 * field-level changes (created, updated, deleted) to the
 * `field_changes` table.
 *
 * Optionally define on the model:
 *
 *   // Only track these fields (whitelist).
 *   protected array $tracked = ['title', 'body', 'status'];
 *
 *   // Never track these fields (blacklist — ignored if $tracked is set).
 *   protected array $untracked = ['password', 'remember_token'];
 */
trait TracksFieldChanges
{
    public static function bootTracksFieldChanges(): void
    {
        static::created(function ($model) {
            $model->recordFieldChanges('created');
        });

        static::updated(function ($model) {
            $model->recordFieldChanges('updated');
        });

        static::deleted(function ($model) {
            $model->recordFieldChanges('deleted');
        });
    }

    public function fieldChanges()
    {
        return $this->morphMany(FieldChange::class, 'auditable');
    }

    protected function recordFieldChanges(string $event): void
    {
        $userId = auth()->id();
        $now = now();

        $rows = match ($event) {
            'created' => $this->buildCreatedRows(),
            'updated' => $this->buildUpdatedRows(),
            'deleted' => $this->buildDeletedRows(),
        };

        if (empty($rows)) {
            return;
        }

        $base = [
            'auditable_type' => $this->getMorphClass(),
            'auditable_id'   => $this->getKey(),
            'event'          => $event,
            'user_id'        => $userId,
            'changed_at'     => $now,
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $records = array_map(fn ($row) => array_merge($base, $row), $rows);

        FieldChange::insert($records);
    }

    protected function buildCreatedRows(): array
    {
        $rows = [];

        foreach ($this->getTrackedAttributes($this->getAttributes()) as $field => $value) {
            $rows[] = [
                'field'     => $field,
                'old_value' => null,
                'new_value' => $this->castToString($value),
            ];
        }

        return $rows;
    }

    protected function buildUpdatedRows(): array
    {
        $dirty = $this->getDirty();
        $rows = [];

        foreach ($this->getTrackedAttributes($dirty) as $field => $value) {
            $rows[] = [
                'field'     => $field,
                'old_value' => $this->castToString($this->getOriginal($field)),
                'new_value' => $this->castToString($value),
            ];
        }

        return $rows;
    }

    protected function buildDeletedRows(): array
    {
        // Single summary row for deletes — no per-field breakdown needed.
        return [[
            'field'     => null,
            'old_value' => json_encode($this->getTrackedAttributes($this->getAttributes())),
            'new_value' => null,
        ]];
    }

    protected function getTrackedAttributes(array $attributes): array
    {
        // Always exclude timestamp bookkeeping.
        $exclude = ['created_at', 'updated_at'];

        if (property_exists($this, 'tracked') && !empty($this->tracked)) {
            $attributes = array_intersect_key($attributes, array_flip($this->tracked));
        }

        if (property_exists($this, 'untracked') && !empty($this->untracked)) {
            $exclude = array_merge($exclude, $this->untracked);
        }

        return array_diff_key($attributes, array_flip($exclude));
    }

    protected function castToString(mixed $value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        if (is_array($value) || is_object($value)) {
            return json_encode($value);
        }

        return (string) $value;
    }
}
