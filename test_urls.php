<?php
$urls = [
    'petra' => 'https://images.unsplash.com/photo-1547234935-80c7145ec969',
    'wadi_rum' => 'https://images.unsplash.com/photo-1502452213796-fbd28cf96962',
    'amman' => 'https://images.unsplash.com/photo-1628156158428-1f3f4c0a5274',
    'jerash' => 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5',
    'dead_sea' => 'https://images.unsplash.com/photo-1544971587-b842c27f8e14',
    'aqaba' => 'https://images.unsplash.com/photo-1582967788606-a171c1070db9',
    'turkey' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200',
    'egypt' => 'https://images.unsplash.com/photo-1503177119275-0aa32b3a9368',
    'uae' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c',
    'saudi' => 'https://images.unsplash.com/photo-1586724230411-48b261b29a48',
    'fallback_desert' => 'https://images.unsplash.com/photo-1509316785289-025f5b846b35', // Valid camel/desert
    'fallback_city' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c', // Valid Dubai
    'fallback_ruins' => 'https://images.unsplash.com/photo-1547234935-80c7145ec969', // Valid Petra
    'fallback_beach' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e' // Valid Beach
];

foreach ($urls as $name => $url) {
    $headers = @get_headers($url);
    if ($headers && strpos($headers[0], '200') !== false) {
        echo "[OK] $name: $url\n";
    } else {
        echo "[FAIL] $name: $url\n";
    }
}
