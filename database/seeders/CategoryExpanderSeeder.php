<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Destination;

class CategoryExpanderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $economy = Category::where('name', '3 Star Economy')->first();
        if (!$economy) return;

        // Update Category names for localization
        $economy->update([
            'name' => '3 نجوم اقتصادي',
            'name_en' => '3 Star Economy'
        ]);

        $premium = Category::where('name', '4 Star Premium')->first();
        if ($premium) {
            $premium->update([
                'name' => '4 نجوم مميز',
                'name_en' => '4 Star Premium'
            ]);
        }

        $luxury = Category::where('name', '5 Star Luxury')->first();
        if ($luxury) {
            $luxury->update([
                'name' => '5 نجوم فاخر',
                'name_en' => '5 Star Luxury'
            ]);
        }

        $destinations = Destination::all()->pluck('id', 'name');

        $tours = [
            [
                'title' => 'جولة في مأدبا التاريخية',
                'title_en' => 'Historical Madaba Walking Tour',
                'description' => 'استكشف مدينة الفسيفساء، قم بزيارة كنيسة الخارطة واستمتع بضيافة مأدبا الأصيلة في بيت ضيافة تقليدي.',
                'description_en' => 'Explore the city of mosaics, visit the Map Church, and enjoy authentic Madaba hospitality in a traditional guesthouse.',
                'location' => 'مأدبا',
                'location_en' => 'Madaba',
                'price' => 35.00,
                'days' => 1,
                'image_path' => 'https://images.unsplash.com/photo-1547234935-80c7145ec969?q=80&w=800', // Will update with generated paths later if needed
                'category_id' => $economy->id,
                'destination_id' => $destinations['مادبا'] ?? 1,
                'type' => 'group',
                'itinerary' => [['day' => 1, 'title' => 'زيارة الكنائس والسوق القديم', 'content' => 'جولة مشي شاملة']],
                'itinerary_en' => [['day' => 1, 'title' => 'Church & Old Market Visit', 'content' => 'Comprehensive walking tour']]
            ],
            [
                'title' => 'مغامرة جبل ضانا للعلائلات',
                'title_en' => 'Dana Mountain Family Adventure',
                'description' => 'مسير جبلي خفيف في واحدة من أجمل المحميات الطبيعية في العالم، مثالي للعائلات ومحبي الطبيعة.',
                'description_en' => 'Easy mountain hike in one of the world\'s most beautiful nature reserves, perfect for families and nature lovers.',
                'location' => 'محمية ضانا',
                'location_en' => 'Dana Reserve',
                'price' => 55.00,
                'days' => 2,
                'image_path' => 'https://images.unsplash.com/photo-1547234935-80c7145ec969?q=80&w=800',
                'category_id' => $economy->id,
                'destination_id' => $destinations['محمية ضانا'] ?? 1,
                'type' => 'group',
                'itinerary' => [['day' => 1, 'title' => 'الوصول والمسير', 'content' => 'الاستمتاع بالغروب']],
                'itinerary_en' => [['day' => 1, 'title' => 'Arrival & Hike', 'content' => 'Enjoy the sunset']]
            ],
            [
                'title' => 'ليالي عمان وشوارعها القديمة',
                'title_en' => 'Amman Nights & Old Streets',
                'description' => 'جولة تذوق طعام ومشي في وسط البلد، استمتع بالكنافة والقهوة العربية وأجواء المدينة الساحرة.',
                'description_en' => 'Food tasting and walking tour in Downtown Amman, enjoy Kunafa, Arabic coffee, and the city\'s magical atmosphere.',
                'location' => 'وسط البلد، عمان',
                'location_en' => 'Downtown Amman',
                'price' => 25.00,
                'days' => 1,
                'image_path' => 'https://images.unsplash.com/photo-1547234935-80c7145ec969?q=80&w=800',
                'category_id' => $economy->id,
                'destination_id' => $destinations['عمان'] ?? 1,
                'type' => 'group',
            ],
            [
                'title' => 'رحلة اليوم الواحد لجرش وعجلون',
                'title_en' => 'Jerash & Ajloun Day Trip',
                'description' => 'اكتشف الآثار الرومانية العظيمة في جرش وقلعة عجلون الإسلامية في يوم واحد مليء بالتاريخ.',
                'description_en' => 'Discover the magnificent Roman ruins in Jerash and the Islamic Ajloun Castle in one history-packed day.',
                'location' => 'جرش وعجلون',
                'location_en' => 'Jerash & Ajloun',
                'price' => 45.00,
                'days' => 1,
                'image_path' => 'https://images.unsplash.com/photo-1547234935-80c7145ec969?q=80&w=800',
                'category_id' => $economy->id,
                'destination_id' => $destinations['جرش'] ?? 1,
                'type' => 'group',
            ],
             [
                'title' => 'تخييم تحت نجوم وادي رم',
                'title_en' => 'Camping Under Wadi Rum Stars',
                'description' => 'تجربة تخييم اقتصادية في مخيم بدوي أصيل، استمتع بوجبة الزرب التقليدية ومشاهدة النجوم.',
                'description_en' => 'Economy camping experience in an authentic Bedouin camp, enjoy traditional Zarb meal and stargazing.',
                'location' => 'وادي رم',
                'location_en' => 'Wadi Rum',
                'price' => 65.00,
                'days' => 1,
                'image_path' => 'https://images.unsplash.com/photo-1547234935-80c7145ec969?q=80&w=800',
                'category_id' => $economy->id,
                'destination_id' => $destinations['وادي رم'] ?? 1,
                'type' => 'group',
            ],
        ];

        foreach ($tours as $tourData) {
            Tour::create($tourData);
        }
    }
}
