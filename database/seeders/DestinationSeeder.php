<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = [
            [
                'name' => 'البتراء', 
                'name_en' => 'Petra',
                'description' => 'المدينة الوردية، إحدى عجائب الدنيا السبع.',
                'description_en' => 'The Rose City, one of the Seven Wonders of the World.',
                'image_path' => '/images/destinations/petra.png',
                'is_international' => false,
                'latitude' => 30.3285,
                'longitude' => 35.4414
            ],
            [
                'name' => 'وادي رم', 
                'name_en' => 'Wadi Rum',
                'description' => 'وادي القمر، تجربة صحراوية لا مثيل لها.',
                'description_en' => 'The Valley of the Moon, an unparalleled desert experience.',
                'image_path' => '/images/destinations/wadirum.png',
                'is_international' => false,
                'latitude' => 29.5735,
                'longitude' => 35.4333
            ],
            [
                'name' => 'البحر الميت', 
                'name_en' => 'Dead Sea',
                'description' => 'أخفض نقطة على سطح الأرض والمياه الشافية.',
                'description_en' => 'The lowest point on Earth and healing waters.',
                'image_path' => '/images/destinations/deadsea.png',
                'is_international' => false,
                'latitude' => 31.5000,
                'longitude' => 35.5000
            ],
            [
                'name' => 'عمان', 
                'name_en' => 'Amman',
                'description' => 'العاصمة النابضة بالحياة والتاريخ العريق.',
                'description_en' => 'The vibrant capital with ancient history.',
                'image_path' => '/images/destinations/amman.png',
                'is_international' => false,
                'latitude' => 31.9454,
                'longitude' => 35.9284
            ],
            [
                'name' => 'جرش', 
                'name_en' => 'Jerash',
                'description' => 'مدينة الألف عام، الآثار الرومانية الخالدة.',
                'description_en' => 'The city of a thousand years, eternal Roman ruins.',
                'image_path' => '/images/destinations/jerash.png',
                'is_international' => false,
                'latitude' => 32.2723,
                'longitude' => 35.8914
            ],
            [
                'name' => 'العقبة', 
                'name_en' => 'Aqaba',
                'description' => 'جنة الغوص والبحر الأحمر الصافي.',
                'description_en' => 'A diving paradise and clear Red Sea waters.',
                'image_path' => '/images/destinations/aqaba.png',
                'is_international' => false,
                'latitude' => 29.5319,
                'longitude' => 35.0061
            ],
            [
                'name' => 'تركيا', 
                'name_en' => 'Turkey',
                'description' => 'سحر الشرق والغرب، إسطنبول وكبدوكيا.',
                'description_en' => 'Enchantment of East and West, Istanbul and Cappadocia.',
                'image_path' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?q=80&w=2000',
                'is_international' => true,
                'latitude' => 41.0082,
                'longitude' => 28.9784
            ],
            [
                'name' => 'مصر', 
                'name_en' => 'Egypt',
                'description' => 'حضارة النيل والأهرامات العظيمة ورحلات الغردقة.',
                'description_en' => 'Nile civilization, Great Pyramids, and Hurghada trips.',
                'image_path' => 'https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?q=80&w=2000',
                'is_international' => true,
                'latitude' => 29.9792,
                'longitude' => 31.1342
            ],
            [
                'name' => 'الإمارات', 
                'name_en' => 'UAE',
                'description' => 'دبي وأبو ظبي، قمة الفخامة والتطور.',
                'description_en' => 'Dubai and Abu Dhabi, the pinnacle of luxury and development.',
                'image_path' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?q=80&w=2000',
                'is_international' => true,
                'latitude' => 25.2048,
                'longitude' => 55.2708
            ],
            [
                'name' => 'السعودية', 
                'name_en' => 'Saudi Arabia',
                'description' => 'التاريخ والمستقبل في العلا ونيوم والرياض.',
                'description_en' => 'History and future in AlUla, NEOM, and Riyadh.',
                'image_path' => 'https://images.unsplash.com/photo-1586724230411-48b261b29a48?q=80&w=2000',
                'is_international' => true,
                'latitude' => 24.7136,
                'longitude' => 46.6753
            ],
        ];

        foreach ($destinations as $dest) {
            Destination::updateOrCreate(
                ['name' => $dest['name']],
                [
                    'name_en' => $dest['name_en'],
                    'slug' => Str::slug($dest['name'], '-', 'ar'),
                    'description' => $dest['description'],
                    'description_en' => $dest['description_en'],
                    'image_path' => $dest['image_path'],
                    'is_international' => $dest['is_international'],
                    'latitude' => $dest['latitude'] ?? null,
                    'longitude' => $dest['longitude'] ?? null,
                    'is_featured' => true,
                ]
            );
        }
    }
}
