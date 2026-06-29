<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Inertia\Inertia;

class PageController extends Controller
{
    public function show(string $path = '')
    {
        $slug = '/'.ltrim($path, '/');

        return Inertia::render('Page/Show', [
            'page' => Page::where('slug', $slug)->firstOrFail(),
        ]);
    }
}
