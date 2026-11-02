<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache; // PENTING: Mengaktifkan subsistem Caching internal

class ConcertController extends Controller
{
    /**
     * Menghitung kapasitas total konser berdasarkan kategori di MongoDB.
     */
    private function calculateTotalCapacity($concert)
    {
        $totalCapacity = 0;
        $categories = $concert->categories ?? [];
        
        if (is_array($categories) || is_object($categories)) {
            foreach ($categories as $cat) {
                $catArray = (array) $cat;
                $rows = $catArray['rows'] ?? [];
                $rowCount = is_array($rows) ? count($rows) : 0;
                $colCount = (int)($catArray['cols'] ?? 0);
                $totalCapacity += ($rowCount * $colCount);
            }
        }
        
        return $totalCapacity > 0 ? $totalCapacity : 150;
    }

    /**
     * FUNGSI UTAMA: Mengambil data kursi terbooking secara RIIL dari database BOOKING.
     * Menggunakan koneksi 'booking' untuk mencari transaksi yang sudah sukses.
     */
    private function getBookedSeatsArray($concertId, $categoryName = null)
    {
        try {
            // Mengambil data dari db_booking (koneksi 'booking')
            $query = DB::connection('booking')->table('bookings')
                ->where('concert_id', (string)$concertId)
                // Hanya memblokir kursi yang statusnya lunas/sukses
                ->whereIn('status', ['paid', 'success', 'confirmed', 'booked', 'PENDING', 'PAID']);

            if ($categoryName) {
                $query->where('category', $categoryName);
            }

            $bookings = $query->get();
            $allBookedSeats = [];
            
            foreach ($bookings as $booking) {
                // Mendukung field 'seats' atau 'selected_seats' agar fleksibel
                $seats = $booking->seats ?? $booking->selected_seats ?? ($booking->seat_number ?? []);
                
                if (is_array($seats)) {
                    foreach ($seats as $seat) {
                        $allBookedSeats[] = (string) $seat;
                    }
                } elseif (is_string($seats)) {
                    // Mendukung database jika nomor kursi disimpan sebagai string tunggal (Single seat)
                    $allBookedSeats[] = $seats;
                }
            }
            
            // Menghapus duplikasi jika ada
            return array_unique($allBookedSeats);
            
        } catch (\Exception $e) {
            Log::error("Gagal menarik data dari DB Booking: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Halaman Katalog Konser - Dilengkapi Caching Proteksi War Trafik
     */
    public function index()
    {
        try {
            // Mengunci data katalog di memori cache selama 60 detik agar query MongoDB tidak terbebani refresh masal
            $concerts = Cache::remember('ftix_public_catalog', 60, function () {
                return Concert::all();
            });
            
            foreach ($concerts as $concert) {
                $totalCapacity = $this->calculateTotalCapacity($concert);
                // Hitung kursi dari database booking
                $bookedSeats = $this->getBookedSeatsArray($concert->_id);
                $concert->available_seats = max(0, $totalCapacity - count($bookedSeats));
            }
            
            return view('concerts.index', compact('concerts'));
        } catch (\Exception $e) {
            Log::error("Kritis pada Katalog Index: " . $e->getMessage());
            // Fail-safe: Jika cache bermasalah, bypass langsung ke DB agar web tidak mati
            $concerts = Concert::all();
            return view('concerts.index', compact('concerts'));
        }
    }

    /**
     * Halaman Detail Konser
     */
    public function show($id)
    {
        $concert = Cache::remember("concert_show_{$id}", 10, function () use ($id) {
            return Concert::findOrFail($id);
        });
        
        $totalCapacity = $this->calculateTotalCapacity($concert);
        $bookedSeats = $this->getBookedSeatsArray($id);
        $concert->available_seats = max(0, $totalCapacity - count($bookedSeats));
        
        // Penanganan jika kategori tersimpan sebagai string (Fallback)
        if (is_string($concert->categories)) {
            $names = array_map('trim', explode(',', $concert->categories));
            $formatted = [];
            foreach ($names as $name) {
                $formatted[] = ['name' => $name, 'price' => 200000];
            }
            $concert->categories = $formatted;
        }
        
        return view('concerts.show', compact('concert'));
    }

    /**
     * Halaman Pilih Kursi - Dilengkapi Validasi Caching kursi terisi 1-2 detik (Sangat Akurat)
     */
    public function seats($id, Request $request)
    {
        $concert = Concert::findOrFail($id);
        $allCategories = $concert->categories ?? [];
        
        // Default kategori
        $firstCat = isset($allCategories[0]['name']) ? $allCategories[0]['name'] : 'VIP';
        $categoryName = $request->get('category', $firstCat);
        
        $currentCategory = null;
        if (is_array($allCategories)) {
            foreach ($allCategories as $cat) {
                $catArray = (array) $cat;
                if (($catArray['name'] ?? '') == $categoryName) {
                    $currentCategory = $catArray;
                    break;
                }
            }
        }

        // AMBIL DATA KURSI YANG SUDAH TERISI (Cache dikunci 1 detik agar tidak tabrakan data pas war)
        $bookedSeats = Cache::remember("booked_seats_{$id}_{$categoryName}", 1, function () use ($id, $categoryName) {
            return $this->getBookedSeatsArray($id, $categoryName);
        });

        // Penanganan Layout Kursi jika data tidak lengkap (Logika Asli Dipertahankan)
        if ($currentCategory) {
            if (!isset($currentCategory['rows']) || !is_array($currentCategory['rows'])) {
                $total = $currentCategory['total_seats'] ?? 50;
                $cols = (int)($currentCategory['cols'] ?? 10);
                $rowsNeeded = ceil($total / $cols);
                // Baris A, B, C...
                $currentCategory['rows'] = array_slice(range('A', 'Z'), 0, $rowsNeeded);
                $currentCategory['cols'] = $cols;
            }
        } else {
            // Default jika kategori tidak ditemukan
            $currentCategory = [
                'name' => $categoryName,
                'price' => 200000,
                'rows' => ['A', 'B', 'C', 'D', 'E'],
                'cols' => 10
            ];
        }

        return view('concerts.seats', compact('concert', 'bookedSeats', 'currentCategory', 'allCategories'));
    }

    public function wishlist()
    {
        return redirect()->route('concerts.index')->with('info', 'Fitur Wishlist segera hadir.');
    }
}