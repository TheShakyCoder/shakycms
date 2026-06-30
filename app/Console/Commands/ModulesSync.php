<?php

namespace App\Console\Commands;

use App\Modules\ModuleManager;
use Illuminate\Console\Command;

/**
 * Ensures every registered module has a row in the `modules` table, seeded
 * with its default state. Safe to run on every deploy (idempotent) — wired
 * into the Docker entrypoint after migrations.
 */
class ModulesSync extends Command
{
    protected $signature = 'modules:sync';

    protected $description = 'Register any new modules in the database (idempotent)';

    public function handle(ModuleManager $modules): int
    {
        $created = $modules->sync();

        if (empty($created)) {
            $this->info('Modules already in sync.');
        } else {
            $this->info('Registered new modules: ' . implode(', ', $created));
        }

        return self::SUCCESS;
    }
}
