<?php

namespace App\Modules\Stats;

use App\Contracts\Module;

/**
 * Stats module.
 *
 * When active, staff can manage the homepage statistics (CRUD) from the
 * internal area. The public display of stats is independent of this module.
 */
class StatsModule implements Module
{
    public function key(): string
    {
        return 'stats';
    }

    public function name(): string
    {
        return 'Stats';
    }

    public function description(): string
    {
        return 'Manage the statistics shown on the homepage.';
    }

    public function defaultActive(): bool
    {
        return true;
    }

    public function route(): ?string
    {
        return 'internal.stats.index';
    }
}
