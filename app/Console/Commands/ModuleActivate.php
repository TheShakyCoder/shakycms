<?php

namespace App\Console\Commands;

use App\Modules\ModuleManager;
use Illuminate\Console\Command;

/**
 * CLI recovery hatch: activate (or deactivate) a module from the shell.
 * Guarantees an admin can always re-enable the Auth module even if it was
 * turned off in the UI.
 *
 *   php artisan module:activate auth
 *   php artisan module:activate auth --off
 */
class ModuleActivate extends Command
{
    protected $signature = 'module:activate {key : The module key, e.g. auth} {--off : Deactivate instead of activate}';

    protected $description = 'Activate or deactivate a module by key';

    public function handle(ModuleManager $modules): int
    {
        $key = $this->argument('key');

        if (! $modules->has($key)) {
            $this->error("Unknown module [{$key}].");

            return self::FAILURE;
        }

        $active = ! $this->option('off');
        $modules->setActive($key, $active);

        $this->info("Module [{$key}] is now " . ($active ? 'active' : 'inactive') . '.');

        return self::SUCCESS;
    }
}
