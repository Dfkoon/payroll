<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tour;
use Inertia\Inertia;

class TourController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Tours/Index', [
            'tours' => Tour::with('category')->latest()->get(),
            'categories' => \App\Models\Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'days' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean'
        ]);

        Tour::create($validated);
        return redirect()->back()->with('success', 'Tour created successfully');
    }

    public function update(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
            'days' => 'integer',
            'category_id' => 'exists:categories,id',
            'is_featured' => 'boolean'
        ]);

        $tour->update($validated);
        return redirect()->back()->with('success', 'Tour updated successfully');
    }

    public function destroy(Tour $tour)
    {
        $tour->delete();
        return redirect()->back()->with('success', 'Tour deleted successfully');
    }
}
