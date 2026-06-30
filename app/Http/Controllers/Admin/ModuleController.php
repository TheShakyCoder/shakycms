<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\ModuleManager;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModuleController extends Controller
{
    public function index(ModuleManager $modules)
    {
        return Inertia::render('Admin/Modules/Index', [
            'modules' => $modules->all(),
        ]);
    }

    public function update(Request $request, ModuleManager $modules, string $key)
    {
        abort_unless($modules->has($key), 404);

        $data = $request->validate([
            'active' => ['required', 'boolean'],
        ]);

        $modules->setActive($key, $data['active']);

        return back()->with('success', 'Module updated.');
    }
}
