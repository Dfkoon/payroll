<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Tour extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'title', 'title_en', 'description', 'description_en',
        'category_id', 'type', 'price', 'days', 'image_path',
        'location', 'location_en', 'is_featured',
        'itinerary', 'itinerary_en', 'destination_id',
        'rating_avg', 'review_count', 'map_lat', 'map_lng'
    ];

    protected $translatable = ['title', 'description', 'location', 'itinerary'];

    protected $casts = [
        'is_featured' => 'boolean',
        'itinerary' => 'array',
        'itinerary_en' => 'array',
        'price' => 'decimal:2',
        'map_lat' => 'decimal:8',
        'map_lng' => 'decimal:8',
        'rating_avg' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
