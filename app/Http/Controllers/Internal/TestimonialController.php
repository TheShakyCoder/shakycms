<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TestimonialController extends Controller
{
    public function index()
    {
        return Inertia::render('Internal/Testimonials/Index', [
            'testimonials' => Testimonial::ordered()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Internal/Testimonials/Create');
    }

    public function store(Request $request)
    {
        Testimonial::create($this->validated($request));

        return redirect()->route('internal.testimonials.index')->with('success', 'Testimonial created.');
    }

    public function edit(Testimonial $testimonial)
    {
        return Inertia::render('Internal/Testimonials/Edit', [
            'testimonial' => $testimonial,
        ]);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $testimonial->update($this->validated($request));

        return redirect()->route('internal.testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('internal.testimonials.index')->with('success', 'Testimonial deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'author' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'headline' => ['required', 'string', 'max:255'],
            'quote' => ['required', 'string', 'max:2000'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'homepage' => ['boolean'],
            'featured' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
