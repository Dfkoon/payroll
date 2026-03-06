<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Bookings/Index', [
            'bookings' => Booking::with(['user', 'tour.category'])->latest()->get(),
            'stats' => [
                'total' => Booking::count(),
                'pending' => Booking::where('status', 'pending')->count(),
                'confirmed' => Booking::where('status', 'confirmed')->count(),
                'revenue' => Booking::where('status', 'confirmed')->sum('total_amount')
            ]
        ]);
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
            'hotel_category' => 'nullable|in:3,4,5'
        ]);

        $booking->update($validated);
        return redirect()->back()->with('success', 'Booking updated successfully');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->back()->with('success', 'Booking removed successfully');
    }
}
