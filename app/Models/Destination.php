<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Destination extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'name',
        'name_en',
        'slug',
        'description',
        'description_en',
        'image_path',
        'is_featured',
    ];

    protected $translatable = ['name', 'description'];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }
}
