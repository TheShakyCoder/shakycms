<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Modules\ModuleManager;
use Inertia\Inertia;

class ModuleController extends Controller
{
    /**
     * Info page for a module. Reachable for inactive modules too — it's how
     * the "Modules" menu explains a module that isn't switched on yet.
     */
    public function show(ModuleManager $modules, string $key)
    {
        $module = $modules->info($key);

        abort_if($module === null, 404);

        return Inertia::render('Internal/Modules/Show', [
            'module' => $module,
        ]);
    }
}
