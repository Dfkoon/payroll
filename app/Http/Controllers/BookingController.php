<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display a listing of the user's bookings.
     */
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('tour.category')
            ->latest()
            ->get();

        return Inertia::render('Bookings/Index', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Tour $tour)
    {
        $request->validate([
            'booking_date' => 'required|date|after:today',
        ]);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'tour_id' => $tour->id,
            'booking_date' => $request->booking_date,
            'total_amount' => $tour->price,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.checkout', $booking->id);
    }

    /**
     * Show the checkout page for a specific booking.
     */
    public function checkout(Booking $booking)
    {
        $booking->load('tour.category');

        return Inertia::render('Bookings/Checkout', [
            'booking' => $booking,
            // In a real app, you'd pass a Stripe Client Secret here
            'stripeKey' => config('services.stripe.key'), 
        ]);
    }
    /**
     * Confirm the booking and simulate payment.
     */
    public function confirm(Request $request, Booking $booking)
    {
        $request->validate([
            'hotel_category' => 'required|in:3,4,5',
        ]);

        // Calculate final price with multipliers
        $multipliers = ['3' => 1.0, '4' => 1.2, '5' => 1.5];
        $multiplier = $multipliers[$request->hotel_category] ?? 1.0;
        
        $booking->update([
            'hotel_category' => $request->hotel_category,
            'total_amount' => $booking->tour->price * $multiplier,
            'status' => 'confirmed',
        ]);

        return redirect()->route('bookings.success', $booking->id);
    }

    /**
     * Show the success page.
     */
    public function success(Booking $booking)
    {
        $booking->load('tour.category');
        return Inertia::render('Bookings/Success', [
            'booking' => $booking
        ]);
    }
}
