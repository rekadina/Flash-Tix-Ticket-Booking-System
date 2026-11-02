<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Menampilkan semua notifikasi milik user dari MongoDB
     */
    public function index()
    {
        try {
            $userId = (string) Auth::id();

            // Ambil seluruh log notifikasi user dari koneksi 'booking'
            $notifications = DB::connection('booking')->table('notifications')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('notifications.index', compact('notifications'));
        } catch (\Exception $e) {
            Log::error("Gagal mengambil data notifikasi di NotificationController: " . $e->getMessage());
            return view('notifications.index')->with('notifications', []);
        }
    }

    /**
     * Menandai satu notifikasi spesifik sebagai sudah dibaca
     */
    public function markAsRead($id)
    {
        try {
            DB::connection('booking')->table('notifications')
                ->where('_id', $id)
                ->update([
                    'is_read' => true,
                    'updated_at' => now()
                ]);

            return back()->with('success', 'Pemberitahuan telah dibaca.');
        } catch (\Exception $e) {
            Log::error("Gagal memperbarui status single notifikasi: " . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui status pemberitahuan.');
        }
    }

    /**
     * FITUR BARU: Mengubah semua status notifikasi user menjadi sudah dibaca (is_read = true)
     * Mengatasi kendala MethodNotAllowed / Method Missing pada layouts.app
     */
    public function markAllRead()
    {
        try {
            $userId = (string) Auth::id();

            // Update semua dokumen notifikasi milik user yang masih bernilai false di MongoDB
            DB::connection('booking')->table('notifications')
                ->where('user_id', $userId)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'updated_at' => now()
                ]);

            return back()->with('success', 'Semua pemberitahuan telah ditandai sudah dibaca.');
        } catch (\Exception $e) {
            Log::error("Gagal menjalankan markAllRead pada NotificationController: " . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data seluruh notifikasi.');
        }
    }
}