<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\TourController as AdminTourController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\CategoryController;
use App\Models\Destination;
use App\Models\Category;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'local_destinations' => Destination::where('is_international', false)->where('is_featured', true)->take(6)->get(),
        'international_destinations' => Destination::where('is_international', true)->where('is_featured', true)->take(6)->get(),
        'featured_tours' => \App\Models\Tour::with('destination', 'category')->where('is_featured', true)->take(6)->get() ?? \App\Models\Tour::with('destination', 'category')->take(6)->get(),
        'categories' => Category::take(4)->get(),
    ]);
})->name('home');

// Public pages
Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{tour}', [TourController::class, 'show'])->name('tours.show');
Route::get('/blog', [PostController::class, 'index'])->name('blog.index');
Route::get('/blog/{post}', [PostController::class, 'show'])->name('blog.show');
Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destinations.show');
Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');
Route::get('/faq', function () {
    return Inertia::render('FAQ');
})->name('faq');
Route::get('/custom-trip', function () {
    return Inertia::render('CustomTrip');
})->name('custom-trip');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/terms', function () {
    return Inertia::render('Terms');
})->name('terms');

// User Dashboard & Profile
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/tours/{tour}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
    Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::get('/bookings/{booking}/success', [BookingController::class, 'success'])->name('bookings.success');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Tours Management
    Route::get('/tours', [AdminTourController::class, 'index'])->name('admin.tours.index');
    Route::post('/tours', [AdminTourController::class, 'store'])->name('admin.tours.store');
    Route::patch('/tours/{tour}', [AdminTourController::class, 'update'])->name('admin.tours.update');
    Route::delete('/tours/{tour}', [AdminTourController::class, 'destroy'])->name('admin.tours.destroy');

    // Bookings Management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
    Route::patch('/bookings/{booking}', [AdminBookingController::class, 'update'])->name('admin.bookings.update');
    Route::delete('/bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('admin.bookings.destroy');

    // Blog Management
    Route::get('/blog', [AdminPostController::class, 'index'])->name('admin.blog.index');
});

Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('language.switch');

require __DIR__.'/auth.php';
