<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeatController extends Controller
{
    public function select(Request $request, $id)
    {
        // 1. VALIDASI ALUR
        $previousUrl = url()->previous();
        $expectedUrl = route('concerts.show', $id);

        if (!str_contains($previousUrl, "/concerts/" . $id) && $previousUrl !== $expectedUrl) {
            return redirect()->route('concerts.show', $id)
                             ->with('error', 'Silakan pilih kategori tiket melalui halaman detail.');
        }

        // 2. AMBIL DATA KONSER
        $concert = Concert::findOrFail($id);
        
        // 3. AMBIL PARAMETER KATEGORI
        $categoryName = $request->query('category');

        if (!$categoryName) {
            return redirect()->route('concerts.show', $id)
                             ->with('error', 'Pilih kategori tiket terlebih dahulu.');
        }

        // 4. NORMALISASI SEMUA KATEGORI
        $allCategories = collect($concert->categories)->map(function ($item) {
            if (is_string($item)) {
                return [
                    'name' => $item,
                    'price' => 0,
                    'rows' => 5, 
                    'cols' => 10 
                ];
            }
            return $item;
        });

        // 5. CARI KATEGORI YANG DIPILIH
        $categoryData = $allCategories->first(function ($value) use ($categoryName) {
            return strtolower($value['name'] ?? '') === strtolower($categoryName);
        });

        if (!$categoryData) {
            return redirect()->route('concerts.show', $id)
                             ->with('error', 'Kategori tidak ditemukan.');
        }

        // Konversi ke array untuk manipulasi
        $currentCategory = $categoryData;

        // 6. FIX: MENGUBAH ANGKA MENJADI ARRAY HURUF (A, B, C...)
        // Jika 'rows' isinya angka (misal 5), kita ubah jadi ['A','B','C','D','E']
        if (!isset($currentCategory['rows']) || !is_array($currentCategory['rows'])) {
            $rowCount = is_numeric($currentCategory['rows'] ?? null) ? $currentCategory['rows'] : 5;
            // Membuat array huruf dari A sampai sesuai jumlah baris
            $currentCategory['rows'] = range('A', chr(64 + $rowCount));
        }

        if (!isset($currentCategory['cols']) || !is_numeric($currentCategory['cols'])) {
            $currentCategory['cols'] = 10;
        }

        // 7. CROSS-DATABASE QUERY
        $bookedSeats = DB::connection('booking')
            ->table('bookings')
            ->where('concert_id', $id)
            ->where('category', $currentCategory['name']) 
            ->pluck('seat_number')
            ->toArray();

        // 8. RENDER VIEW
        return view('seats.select', [
            'concert' => $concert,
            'allCategories' => $allCategories,
            'currentCategory' => $currentCategory,
            'id' => $id,
            'bookedSeats' => $bookedSeats
        ]);
    }
}