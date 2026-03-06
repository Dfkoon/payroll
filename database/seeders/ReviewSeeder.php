<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $tours = Tour::all();
        $users = User::all();

        if ($tours->isEmpty() || $users->isEmpty()) {
            return;
        }

        foreach ($tours as $tour) {
            $numReviews = rand(3, 8);
            $totalRating = 0;

            for ($i = 0; $i < $numReviews; $i++) {
                $rating = rand(4, 5); // Travel site reviews are usually high
                $totalRating += $rating;

                Review::create([
                    'user_id' => $users->random()->id,
                    'tour_id' => $tour->id,
                    'rating' => $rating,
                    'comment' => 'تجربة رائعة جداً، الخدمة كانت ممتازة والتنظيم دقيق. شكراً سلامين للسياحة!',
                ]);
            }

            $tour->update([
                'rating_avg' => $totalRating / $numReviews,
                'review_count' => $numReviews,
            ]);
        }
    }
}
