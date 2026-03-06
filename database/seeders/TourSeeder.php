<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\Category;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $destinations = \App\Models\Destination::all();

        if ($categories->isEmpty() || $destinations->isEmpty()) {
            return;
        }

        $tours = [
            [
                'title' => 'مغامرة البتراء ووادي رم',
                'title_en' => 'Petra & Wadi Rum Adventure',
                'description' => "استكشف سحر الأردن مع هذه الجولة الشاملة للبتراء ووادي رم. ركوب الجمال في الصحراء، المبيت تحت النجوم في مخيم بدوي فاخر، واستكشاف المدينة الوردية القديمة.",
                'description_en' => "Explore the magic of Jordan with this all-inclusive tour of Petra and Wadi Rum. Camel riding, stargazing in a luxury bedouin camp, and exploring the ancient Rose City.",
                'category_id' => $categories->where('slug', 'adventure')->first()->id,
                'destination_id' => $destinations->where('name', 'البتراء')->first()->id,
                'type' => 'package',
                'price' => 599.00,
                'days' => 3,
                'image_path' => 'https://images.unsplash.com/photo-1579606030126-d1af49a92d77?q=80&w=1200',
                'location' => 'البتراء ووادي رم',
                'location_en' => 'Petra & Wadi Rum',
                'map_lat' => 30.3285,
                'map_lng' => 35.4444,
            ],
            [
                'title' => 'الاسترخاء في البحر الميت',
                'title_en' => 'Dead Sea Relaxation',
                'description' => "انعم بالهدوء في مياه البحر الميت الغنية بالمعادن واستمتع بعلاجات السبا الفاخرة في منتجع 5 نجوم. الملاذ الخاص المثالي لتجديد طاقتك.",
                'description_en' => "Bask in the serenity of mineral-rich Dead Sea waters and enjoy luxury spa treatments. The perfect private getaway to recharge.",
                'category_id' => $categories->where('slug', 'cultural')->first()->id,
                'destination_id' => $destinations->where('name', 'البحر الميت')->first()->id,
                'type' => 'private',
                'price' => 199.00,
                'days' => 1,
                'image_path' => 'https://images.unsplash.com/photo-1544971587-b842c27f8e14?q=80&w=1200',
                'location' => 'البحر الميت',
                'location_en' => 'Dead Sea',
                'map_lat' => 31.7100,
                'map_lng' => 35.5858,
            ],
            [
                'title' => 'عمان: جولة في قلب العاصمة',
                'title_en' => 'Amman: Heart of the Capital',
                'description' => "جولة سيراً على الأقدام مع دليل في العاصمة الصاخبة. قم بزيارة القلعة، المدرج الروماني، واستمتع بأطعمة الشارع الأصلية في وسط البلد.",
                'description_en' => "Guided walking tour in the bustling capital. Visit the Citadel, Roman Theater, and enjoy authentic street food downtown.",
                'category_id' => $categories->where('slug', 'tours')->first()->id,
                'destination_id' => $destinations->where('name', 'عمان')->first()->id,
                'type' => 'group',
                'price' => 45.00,
                'days' => 1,
                'image_path' => 'https://images.unsplash.com/photo-1628156158428-1f3f4c0a5274?q=80&w=1200',
                'location' => 'عمان',
                'location_en' => 'Amman',
                'map_lat' => 31.9454,
                'map_lng' => 35.9284,
            ],
            [
                'title' => 'رحلة اليوم الواحد لجرش وعجلون',
                'title_en' => 'Jerash & Ajloun Day Trip',
                'description' => "اكتشف الآثار الرومانية العظيمة في جرش وقلعة عجلون الإسلامية في يوم واحد مليء بالتاريخ والطبيعة الخلابة.",
                'description_en' => "Discover the grand Roman ruins of Jerash and the Islamic Ajloun Castle in one day full of history and stunning nature.",
                'category_id' => $categories->where('slug', 'cultural')->first()->id,
                'destination_id' => $destinations->where('name', 'جرش')->first()->id,
                'type' => 'group',
                'price' => 45.00,
                'days' => 1,
                'image_path' => 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?q=80&w=1200',
                'location' => 'جرش وعجلون',
                'location_en' => 'Jerash & Ajloun',
                'map_lat' => 32.2723,
                'map_lng' => 35.8914,
            ],
            [
                'title' => 'سحر إسطنبول وكبدوكيا',
                'title_en' => 'Istanbul & Cappadocia Magic',
                'description' => "استكشف جمال تركيا الفريد، من مساجد إسطنبول التاريخية إلى مناطيد كبدوكيا الحرارية. رحلة العمر بين قارتين.",
                'description_en' => "Explore Turkey's unique beauty, from Istanbul's historic mosques to Cappadocia's hot air balloons. The trip of a lifetime.",
                'category_id' => $categories->where('slug', 'tours')->first()->id,
                'destination_id' => $destinations->where('name', 'تركيا')->first()->id,
                'type' => 'package',
                'price' => 899.00,
                'days' => 7,
                'image_path' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?q=80&w=1200',
                'location' => 'تركيا',
                'location_en' => 'Turkey',
                'map_lat' => 41.0082,
                'map_lng' => 28.9784,
            ],
            [
                'title' => 'أسرار الفراعنة والنيل',
                'title_en' => 'Pharaohs & Nile Secrets',
                'description' => "اكتشف عظمة الأهرامات في الجيزة واستمتع برحلة نيلية كلاسيكية بين الأقصر وأسوان. مصر تفتح لك أبواب التاريخ.",
                'description_en' => "Discover the grandeur of the Giza Pyramids and enjoy a classic Nile cruise between Luxor and Aswan. Egypt opens the doors of history.",
                'category_id' => $categories->where('slug', 'cultural')->first()->id,
                'destination_id' => $destinations->where('name', 'مصر')->first()->id,
                'type' => 'group',
                'price' => 499.00,
                'days' => 5,
                'image_path' => 'https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?q=80&w=1200',
                'location' => 'مصر',
                'location_en' => 'Egypt',
                'map_lat' => 29.9792,
                'map_lng' => 31.1342,
            ],
            [
                'title' => 'العلا: رحلة عبر الزمن',
                'title_en' => 'AlUla: Journey Through Time',
                'description' => "اكتشف جمال العلا المبهر، من الحجر إلى جبل الفيل. تجربة تجمع بين الفخامة وتاريخ الجزيرة العربية العريق.",
                'description_en' => "Discover the stunning beauty of AlUla, from Hegra to Elephant Rock. An experience combining luxury with deep Arabian history.",
                'category_id' => $categories->where('slug', 'luxury')->first()->id,
                'destination_id' => $destinations->where('name', 'السعودية')->first()->id,
                'type' => 'private',
                'price' => 1299.00,
                'days' => 4,
                'image_path' => 'https://images.unsplash.com/photo-1586724230411-48b261b29a48?q=80&w=1200',
                'location' => 'العلا، السعودية',
                'location_en' => 'AlUla, Saudi Arabia',
                'map_lat' => 26.6917,
                'map_lng' => 37.9189,
            ],
            [
                'title' => 'أنوار دبي الصاخبة',
                'title_en' => 'Dubai City Lights',
                'description' => "استمتع بأفضل ما في دبي، من برج خليفة إلى رحلات السفاري الصحراوية وتسوق فاخر في دبي مول.",
                'description_en' => "Enjoy the best of Dubai, from Burj Khalifa to desert safaris and luxury shopping at Dubai Mall.",
                'category_id' => $categories->where('slug', 'premium')->first()->id,
                'destination_id' => $destinations->where('name', 'الإمارات')->first()->id,
                'type' => 'package',
                'price' => 750.00,
                'days' => 5,
                'image_path' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?q=80&w=1200',
                'location' => 'دبي، الإمارات',
                'location_en' => 'Dubai, UAE',
                'map_lat' => 25.2048,
                'map_lng' => 55.2708,
            ],
        ];

        foreach ($tours as $tourData) {
            Tour::updateOrCreate(
                ['title' => $tourData['title']],
                $tourData
            );
        }
    }
}
