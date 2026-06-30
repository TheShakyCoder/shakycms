<?php

namespace App\Modules\Contracts;

/**
 * A feature area that can be globally activated/deactivated by an admin.
 *
 * Modules are defined in code and registered in config/modules.php. Their
 * on/off state is persisted in the `modules` table (see App\Models\Module),
 * keyed by key(). Adding a new module is: implement this interface, add the
 * class to the registry, gate its routes with the `module:<key>` middleware.
 */
interface Module
{
    /** Stable machine key, e.g. 'auth'. Used in the DB, middleware and shared props. */
    public function key(): string;

    /** Human-readable name shown in the admin UI. */
    public function name(): string;

    /** Short description of what the module enables. */
    public function description(): string;

    /** Whether the module should be active the first time it is registered. */
    public function defaultActive(): bool;
}
