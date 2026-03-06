<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'bookings_count' => Booking::count(),
            'tours_count' => Tour::count(),
            'users_count' => User::count(),
            'total_revenue' => Booking::where('status', 'confirmed')->sum('total_amount'),
            'recent_bookings' => Booking::with(['user', 'tour'])->latest()->take(5)->get(),
            'top_tours' => Tour::withCount('bookings')->orderBy('bookings_count', 'desc')->take(3)->get(),
            'booking_trends' => Booking::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as aggregate'))
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->take(7)
                ->get()
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats
        ]);
    }
}
