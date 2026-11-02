<?php

namespace Database\Seeders;

use App\Models\Concert;
use App\Models\Seat;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    public function run()
    {
        $concerts = Concert::all();
        
        $categoryRows = [
            'VIP' => ['A', 'B', 'C', 'D', 'E'],
            'Festival' => ['F', 'G', 'H', 'I', 'J'],
            'Tribun' => ['K', 'L', 'M', 'N', 'O'],
        ];
        
        $defaultCategories = [
            ['name' => 'VIP', 'price' => 500000, 'rows' => ['A', 'B', 'C', 'D', 'E']],
            ['name' => 'Festival', 'price' => 350000, 'rows' => ['F', 'G', 'H', 'I', 'J']],
            ['name' => 'Tribun', 'price' => 200000, 'rows' => ['K', 'L', 'M', 'N', 'O']],
        ];
        
        foreach ($concerts as $concert) {
            // Cek apakah sudah ada kursi
            $existingSeats = Seat::where('concert_id', $concert->_id)->count();
            
            if ($existingSeats == 0) {
                // Handle categories - bisa string atau array
                $categories = $concert->categories ?? [];
                
                // Jika categories adalah string, konversi ke array default
                if (is_string($categories)) {
                    $categories = $defaultCategories;
                }
                
                // Jika categories kosong atau bukan array, pakai default
                if (empty($categories) || !is_array($categories)) {
                    $categories = $defaultCategories;
                }
                
                foreach ($categories as $category) {
                    // Pastikan category adalah array
                    if (is_string($category)) {
                        // Cari default category berdasarkan nama
                        $categoryName = $category;
                        $found = false;
                        foreach ($defaultCategories as $defaultCat) {
                            if ($defaultCat['name'] === $categoryName) {
                                $category = $defaultCat;
                                $found = true;
                                break;
                            }
                        }
                        if (!$found) {
                            $category = ['name' => $categoryName, 'price' => 200000];
                        }
                    }
                    
                    $categoryName = $category['name'] ?? 'Festival';
                    $categoryPrice = $category['price'] ?? 200000;
                    $rows = $categoryRows[$categoryName] ?? ($category['rows'] ?? ['A', 'B', 'C', 'D', 'E']);
                    
                    foreach ($rows as $row) {
                        for ($i = 1; $i <= 7; $i++) {
                            // Cek apakah kursi sudah ada
                            $exists = Seat::where('concert_id', $concert->_id)
                                ->where('seat_code', $row . $i)
                                ->exists();
                            
                            if (!$exists) {
                                Seat::create([
                                    'concert_id' => $concert->_id,
                                    'seat_code' => $row . $i,
                                    'category' => $categoryName,
                                    'row_code' => $row,
                                    'seat_number' => $i,
                                    'status' => 'available',
                                    'price' => $categoryPrice
                                ]);
                            }
                        }
                    }
                }
                
                $this->command->info("Kursi untuk konser {$concert->name} berhasil dibuat (" . Seat::where('concert_id', $concert->_id)->count() . " kursi)");
            } else {
                $this->command->info("Kursi untuk konser {$concert->name} sudah ada (" . $existingSeats . " kursi)");
            }
        }
        
        $this->command->info("SeatSeeder selesai dijalankan!");
    }
}