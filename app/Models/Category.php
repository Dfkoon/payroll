<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Category extends Model
{
    use HasFactory, Translatable;

    protected $fillable = ['name', 'name_en', 'stars'];

    protected $translatable = ['name'];

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }
}
