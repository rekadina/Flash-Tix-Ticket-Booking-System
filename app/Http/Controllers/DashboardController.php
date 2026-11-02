<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // WAJIB pastikan baris ini ada di paling atas file!

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman utama Dashboard Hub setelah user login
     */
    public function index()
    {
        try {
            // Ambil semua data dokumen konser dari koneksi cluster MongoDB 'concert'
            $concerts = DB::connection('concert')->table('concerts')->get();
        } catch (\Exception $e) {
            // Jika koneksi database mongo bermasalah, amankan dengan array kosong agar tidak blank putih
            $concerts = [];
        }

        // Kirim data konser ke file views/dashboard.blade.php kamu
        return view('dashboard', compact('concerts'));
    }

    /**
     * Menampilkan halaman statistik Tiket Saya
     */
    public function tiketSaya()
    {
        // Fungsi tiketSaya kamu yang kemarin tetap biarkan aman di bawah ini...
    }
}