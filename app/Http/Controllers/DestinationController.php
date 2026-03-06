<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Destination;
use Inertia\Inertia;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::latest()->get();
        return Inertia::render('Destinations/Index', [
            'destinations' => $destinations
        ]);
    }

    public function show($slug)
    {
        $destination = Destination::where('slug', $slug)
            ->with(['tours.category'])
            ->firstOrFail();

        return Inertia::render('Destinations/Show', [
            'destination' => $destination
        ]);
    }
}
