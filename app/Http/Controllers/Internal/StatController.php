<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatController extends Controller
{
    public function index()
    {
        return Inertia::render('Internal/Stats/Index', [
            'stats' => Stat::ordered()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Internal/Stats/Create');
    }

    public function store(Request $request)
    {
        Stat::create($this->validated($request));

        return redirect()->route('internal.stats.index')->with('success', 'Stat created.');
    }

    public function edit(Stat $stat)
    {
        return Inertia::render('Internal/Stats/Edit', [
            'stat' => $stat,
        ]);
    }

    public function update(Request $request, Stat $stat)
    {
        $stat->update($this->validated($request));

        return redirect()->route('internal.stats.index')->with('success', 'Stat updated.');
    }

    public function destroy(Stat $stat)
    {
        $stat->delete();

        return redirect()->route('internal.stats.index')->with('success', 'Stat deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'value' => ['required', 'string', 'max:255'],
            'label' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
