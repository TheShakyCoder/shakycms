<?php

namespace App\Traits;

use App\Models\Link;
use App\Models\Right;
use App\Models\Role;
use Illuminate\Support\Collection;

trait HasPermissions
{
    public function hasPermissionTo(string $method): bool
    {
        $roles = Role::query()
            ->whereHas('rights', function($qb) use($method) {
                $qb->where('controller_method_name', $method);
            })
            ->get();

        foreach ($roles as $role) {
            if($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    public function getPermissions(): Collection
    {
        return $this->roles->map(function($role) {
            return $role->rights->pluck('controller_method_name');
        })->flatten();
    }
}
