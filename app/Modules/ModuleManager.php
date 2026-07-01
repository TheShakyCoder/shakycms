<?php

namespace App\Modules;

use App\Models\Module as ModuleState;
use App\Contracts\Module;
use Illuminate\Support\Facades\Cache;

/**
 * Loads the code-defined module registry, merges it with persisted on/off
 * state, and caches the result. Resolved as a singleton (bound as 'modules'
 * in AppServiceProvider) and read on every request by the middleware and the
 * Inertia shared props, so the active map is cached and busted on change.
 */
class ModuleManager
{
    private const CACHE_KEY = 'modules.active_map';

    /** @var array<string, Module> key => module instance */
    private array $modules = [];

    /** @var array<string, bool>|null in-process memo of the active map */
    private ?array $activeMap = null;

    /**
     * @param  array<class-string<Module>>  $registry
     */
    public function __construct(array $registry)
    {
        foreach ($registry as $class) {
            $module = app($class);
            $this->modules[$module->key()] = $module;
        }
    }

    public function has(string $key): bool
    {
        return isset($this->modules[$key]);
    }

    public function isActive(string $key): bool
    {
        return $this->activeMap()[$key] ?? false;
    }

    /** [key => bool] for every registered module. */
    public function activeMap(): array
    {
        if ($this->activeMap !== null) {
            return $this->activeMap;
        }

        return $this->activeMap = Cache::rememberForever(
            self::CACHE_KEY,
            fn () => $this->loadActiveMap(),
        );
    }

    /** Only the active module keys, e.g. ['auth' => true] — shared to the frontend. */
    public function sharedMap(): array
    {
        return array_filter($this->activeMap());
    }

    /** For the admin UI: metadata + current state for every module. */
    public function all(): array
    {
        $map = $this->activeMap();

        return array_values(array_map(fn (Module $m) => [
            'key' => $m->key(),
            'name' => $m->name(),
            'description' => $m->description(),
            'active' => $map[$m->key()] ?? false,
            'route' => $m->route(),
        ], $this->modules));
    }

    /** Lightweight list for the nav menu: every module, active or not. */
    public function navList(): array
    {
        $map = $this->activeMap();

        return array_values(array_map(fn (Module $m) => [
            'key' => $m->key(),
            'name' => $m->name(),
            'active' => $map[$m->key()] ?? false,
            'route' => $m->route(),
        ], $this->modules));
    }

    /** Full info for a single module (for the info page), or null if unknown. */
    public function info(string $key): ?array
    {
        if (! $this->has($key)) {
            return null;
        }

        $module = $this->modules[$key];

        return [
            'key' => $module->key(),
            'name' => $module->name(),
            'description' => $module->description(),
            'active' => $this->isActive($key),
            'route' => $module->route(),
        ];
    }

    public function setActive(string $key, bool $active): void
    {
        if (! $this->has($key)) {
            throw new \InvalidArgumentException("Unknown module [{$key}].");
        }

        ModuleState::query()->updateOrCreate(['key' => $key], ['active' => $active]);

        $this->flush();
    }

    /**
     * Ensure a DB row exists for each registered module. Modules are always
     * installed inactive — an admin activates them explicitly. Returns the
     * keys of newly-created rows.
     *
     * @return array<int, string>
     */
    public function sync(): array
    {
        $created = [];

        foreach ($this->modules as $key => $module) {
            $row = ModuleState::query()->firstOrCreate(
                ['key' => $key],
                ['active' => false],
            );

            if ($row->wasRecentlyCreated) {
                $created[] = $key;
            }
        }

        $this->flush();

        return $created;
    }

    public function flush(): void
    {
        $this->activeMap = null;
        Cache::forget(self::CACHE_KEY);
    }

    /** @return array<string, bool> */
    private function loadActiveMap(): array
    {
        $state = $this->stateFromDb();

        $map = [];
        foreach (array_keys($this->modules) as $key) {
            // Unknown to the DB (not yet synced) → inactive by default.
            $map[$key] = $state[$key] ?? false;
        }

        return $map;
    }

    /** @return array<string, bool> */
    private function stateFromDb(): array
    {
        try {
            return ModuleState::query()
                ->pluck('active', 'key')
                ->map(fn ($active) => (bool) $active)
                ->all();
        } catch (\Throwable $e) {
            // Table not migrated yet (e.g. first boot) — fall back to defaults.
            return [];
        }
    }
}
