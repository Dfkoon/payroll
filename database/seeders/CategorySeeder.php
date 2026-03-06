<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'ثقافي', 'name_en' => 'Cultural', 'slug' => 'cultural', 'stars' => 4],
            ['name' => 'مغامرة', 'name_en' => 'Adventure', 'slug' => 'adventure', 'stars' => 5],
            ['name' => 'ديني', 'name_en' => 'Religious', 'slug' => 'religious', 'stars' => 3],
            ['name' => 'جولات', 'name_en' => 'Tours', 'slug' => 'tours', 'stars' => 4],
            ['name' => 'فاخر', 'name_en' => 'Luxury', 'slug' => 'luxury', 'stars' => 5],
            ['name' => 'مميز', 'name_en' => 'Premium', 'slug' => 'premium', 'stars' => 5],
            ['name' => 'أخرى', 'name_en' => 'Others', 'slug' => 'others', 'stars' => 3],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
