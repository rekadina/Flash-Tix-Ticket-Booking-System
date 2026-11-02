<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Concert;

class ConcertSeeder extends Seeder
{
    public function run()
    {
        $concerts = [
            ['artist' => 'Tulus', 'title' => 'Tur Manusia', 'city' => 'Jakarta', 'venue' => 'Istora Senayan', 'date' => '2024-12-15', 'time' => '19:00', 'price' => 350000, 'original_price' => 500000, 'categories' => 'VIP, Festival, Tribun', 'available_seats' => 234, 'image_url' => 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=400&h=250&fit=crop', 'is_active' => true],
            ['artist' => 'Sheila On 7', 'title' => 'Tunggu Aku', 'city' => 'Surabaya', 'venue' => 'Tennis Indoor', 'date' => '2024-12-20', 'time' => '19:30', 'price' => 250000, 'original_price' => 400000, 'categories' => 'Festival, Tribun', 'available_seats' => 45, 'image_url' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=400&h=250&fit=crop', 'is_active' => true],
            // ... tambahkan 18 konser lainnya
        ];
        
        foreach ($concerts as $concert) {
            Concert::create($concert);
        }
    }
}