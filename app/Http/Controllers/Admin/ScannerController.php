<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScannerController extends Controller
{
    /**
     * Menampilkan antarmuka Web-Cam Scanner
     */
    public function index()
    {
        return view('admin.scanner');
    }

    /**
     * Menerima data dari Web-Cam via AJAX dan memvalidasi ke MongoDB
     */
    public function verify(Request $request)
    {
        $orderId = $request->input('order_id');

        if (!$orderId) {
            return response()->json(['success' => false, 'message' => 'QR Code tidak terdeteksi.']);
        }

        try {
            // 1. Cari tiket di MongoDB db_booking
            $bookingRaw = DB::connection('booking')->table('bookings')
                ->where('order_id', $orderId)
                ->first();

            if (!$bookingRaw) {
                return response()->json([
                    'success' => false, 
                    'message' => "Tiket Tidak Ditemukan!\n(ID: {$orderId})"
                ]);
            }

            $booking = (array) $bookingRaw;
            $status = strtoupper($booking['status']);

            // 2. Cek apakah tiket sudah pernah di-scan sebelumnya (Mencegah Double Entry)
            if ($status === 'CHECKED_IN') {
                return response()->json([
                    'success' => false, 
                    'message' => "TIKET SUDAH DIGUNAKAN!\nSeseorang telah masuk menggunakan tiket ini."
                ]);
            }

            // 3. Cek apakah tiket belum dibayar / dibatalkan
            if (!in_array($status, ['SUCCESS', 'PAID', 'CONFIRMED'])) {
                return response()->json([
                    'success' => false, 
                    'message' => "AKSES DITOLAK!\nStatus tiket belum lunas ({$status})."
                ]);
            }

            // 4. JIKA LOLOS: Update status menjadi CHECKED_IN di MongoDB
            DB::connection('booking')->table('bookings')
                ->where('order_id', $orderId)
                ->update([
                    'status' => 'CHECKED_IN',
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true, 
                'message' => "CHECK-IN SUKSES!\nTiket atas ID {$orderId} Valid."
            ]);

        } catch (\Exception $e) {
            Log::error("Error Scanner: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem database.']);
        }
    }
}