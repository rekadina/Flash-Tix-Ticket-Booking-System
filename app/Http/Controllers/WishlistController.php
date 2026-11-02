<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WishlistController extends Controller
{
    /**
     * Menampilkan Dasbor Pre-War Wishlist milik User
     */
    public function index()
    {
        try {
            $userId = (string) Auth::id();

            // 1. Tarik semua data wishlist milik user dari db_booking MongoDB
            $wishlistsRaw = DB::connection('booking')->table('wishlists')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();

            $wishlistItems = [];

            foreach ($wishlistsRaw as $item) {
                $wishlist = (array) $item;
                $concertId = $wishlist['concert_id'] ?? null;

                if ($concertId) {
                    // 2. Tarik detail data konser secara riil dari db_concert MongoDB
                    $concert = DB::connection('concert')->table('concerts')
                        ->where('_id', (string) $concertId)
                        ->first();

                    if ($concert) {
                        $wishlist['concert_details'] = (object) $concert;

                        // 3. STATISTIK SINKRONISASI: Hitung agregasi total orang yang mengincar konser ini
                        $wishlist['total_fans_count'] = DB::connection('booking')->table('wishlists')
                            ->where('concert_id', (string) $concertId)
                            ->count();

                        $wishlistItems[] = (object) $wishlist;
                    }
                }
            }

            return view('wishlist.index', compact('wishlistItems'));

        } catch (\Exception $e) {
            Log::error("Gagal memuat halaman Wishlist di WishlistController: " . $e->getMessage());
            return view('wishlist.index')->with('wishlistItems', [])->with('error', 'Gagal memuat beberapa data antrean konser.');
        }
    }

    /**
     * FITUR BARU: Menambahkan konser musik ke dalam daftar Pre-War Wishlist
     */
    public function add(Request $request)
    {
        // Validasi input data dari form katalog/detail konser
        $request->validate([
            'concert_id' => 'required|string'
        ]);

        try {
            $userId = (string) Auth::id();
            $concertId = $request->input('concert_id');

            // 1. Cek Idempotency: Apakah user sudah pernah menambahkan konser ini sebelumnya?
            $isExist = DB::connection('booking')->table('wishlists')
                ->where('user_id', $userId)
                ->where('concert_id', $concertId)
                ->first();

            if ($isExist) {
                return redirect()->route('wishlist')->with('info', 'Konser ini sudah ada di dalam daftar Pre-War Wishlist Anda.');
            }

            // 2. Jika belum ada, lakukan insert dokumen baru ke koleksi wishlists di MongoDB
            DB::connection('booking')->table('wishlists')->insert([
                'user_id' => $userId,
                'concert_id' => $concertId,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info("User {$userId} berhasil memasukkan konser {$concertId} ke daftar antrean Pre-War.");

            // Alihkan langsung ke halaman wishlist disertai feedback sukses
            return redirect()->route('wishlist')->with('success', 'Konser berhasil ditambahkan ke daftar strategi Pre-War Anda! 🎉');

        } catch (\Exception $e) {
            Log::error("Gagal menambahkan item ke wishlist: " . $e->getMessage());
            return back()->with('error', 'Gagal memproses penambahan wishlist: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus item konser dari daftar Wishlist
     */
    public function remove($id)
    {
        try {
            // Hapus dokumen berdasarkan _id unik milik wishlist di MongoDB
            DB::connection('booking')->table('wishlists')
                ->where('_id', $id)
                ->delete();

            return redirect()->route('wishlist')->with('success', 'Konser berhasil dihapus dari daftar Pre-War.');
        } catch (\Exception $e) {
            Log::error("Gagal menghapus item wishlist: " . $e->getMessage());
            return back()->with('error', 'Gagal mengeluarkan konser dari daftar.');
        }
    }
}