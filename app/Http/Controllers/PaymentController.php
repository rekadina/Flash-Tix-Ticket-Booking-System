<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Handle Webhook Callback dari Midtrans
     */
    public function handleCallback(Request $request)
    {
        Log::info("Flash-Tix Callback Masuk: ", $request->all());

        $serverKey = env('MIDTRANS_SERVER_KEY');
        $order_id = $request->order_id;
        $status_code = $request->status_code;
        $gross_amount = $request->gross_amount;
        $transaction_status = $request->transaction_status;

        // Validasi Signature Key
        $hashed = hash("sha512", $order_id . $status_code . $gross_amount . $serverKey);
        if ($hashed !== $request->signature_key) {
            Log::error("Flash-Tix Error: Signature Key tidak cocok!");
            return response()->json(['message' => 'Invalid Signature'], 403);
        }

        try {
            $bookingData = DB::connection('booking')->table('bookings')
                ->where('order_id', (string)$order_id)
                ->first();

            if (!$bookingData) {
                Log::warning("Order ID {$order_id} tidak ditemukan");
                return response()->json(['message' => 'Order tidak ditemukan'], 404);
            }

            $booking = (array) $bookingData;
            $currentStatus = strtoupper($booking['status'] ?? 'PENDING');

            // Idempotent Guard
            if (in_array($currentStatus, ['PAID', 'SUCCESS'])) {
                Log::info("Order {$order_id} sudah diproses sebelumnya");
                return response()->json(['status' => 'OK', 'message' => 'Idempotent triggered']);
            }

            // Proses berdasarkan status transaksi
            if (in_array($transaction_status, ['settlement', 'capture'])) {
                $this->processSuccessPayment($booking, $order_id);
            } elseif (in_array($transaction_status, ['deny', 'expire', 'cancel'])) {
                $this->processExpiredPayment($booking, $order_id);
            }

            return response()->json(['status' => 'OK']);

        } catch (\Exception $e) {
            Log::error("Error Payment Webhook: " . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Proses pembayaran sukses
     */
    private function processSuccessPayment($booking, $order_id)
    {
        // Update status booking
        DB::connection('booking')->table('bookings')
            ->where('order_id', (string)$order_id)
            ->update([
                'status' => 'SUCCESS',
                'updated_at' => now()
            ]);

        // Blokir kursi jika ada
        if (isset($booking['seats']) && !empty($booking['seats'])) {
            $seatsToBlock = $this->parseSeats($booking['seats']);
            foreach ($seatsToBlock as $seat_code) {
                try {
                    DB::connection('concert')->table('seats')->updateOrInsert(
                        [
                            'concert_id' => (string)$booking['concert_id'],
                            'category'   => $booking['category'] ?? 'General',
                            'seat_code'  => $seat_code
                        ],
                        ['status' => 'booked', 'updated_at' => now()]
                    );
                } catch (\Exception $e) {
                    Log::warning("Gagal blokir kursi {$seat_code}: " . $e->getMessage());
                }
            }
        }

        // Insert notifikasi
        $this->insertNotification(
            $booking['user_id'],
            $order_id,
            'Pembayaran Sukses! 🎉',
            'Selamat, pembayaran untuk Order #' . $order_id . ' berhasil diverifikasi. E-Tiket Anda sudah diterbitkan, silakan cek menu Tiket Saya.',
            'payment_success'
        );

        Log::info("Pembayaran sukses untuk order {$order_id}");
    }

    /**
     * Proses pembayaran expired/cancel
     */
    private function processExpiredPayment($booking, $order_id)
    {
        // Update status booking
        DB::connection('booking')->table('bookings')
            ->where('order_id', (string)$order_id)
            ->update([
                'status' => 'EXPIRED',
                'updated_at' => now()
            ]);

        // Release kursi jika ada
        if (isset($booking['seats']) && !empty($booking['seats'])) {
            $seatsToRelease = $this->parseSeats($booking['seats']);
            foreach ($seatsToRelease as $seat_code) {
                try {
                    DB::connection('concert')->table('seats')
                        ->where('concert_id', (string)$booking['concert_id'])
                        ->where('category', $booking['category'] ?? 'General')
                        ->where('seat_code', $seat_code)
                        ->delete();
                } catch (\Exception $e) {
                    Log::warning("Gagal release kursi {$seat_code}: " . $e->getMessage());
                }
            }
        }

        // Insert notifikasi expired
        $this->insertNotification(
            $booking['user_id'],
            $order_id,
            'Pembayaran Kadaluwarsa ⏰',
            'Mohon maaf, sesi pembayaran untuk Order #' . $order_id . ' telah berakhir. Silakan lakukan pemesanan ulang.',
            'payment_expired'
        );

        Log::info("Pembayaran expired untuk order {$order_id}");
    }

    /**
     * Parse seats dari berbagai format
     */
    private function parseSeats($seats)
    {
        if (is_array($seats)) {
            return $seats;
        }
        
        if (is_string($seats)) {
            $decoded = json_decode($seats, true);
            if (is_array($decoded)) {
                return $decoded;
            }
            return [$seats];
        }
        
        return [];
    }

    /**
     * Insert notifikasi ke database
     */
    private function insertNotification($userId, $orderId, $title, $message, $type)
    {
        try {
            DB::connection('booking')->table('notifications')->insert([
                'user_id' => (string)$userId,
                'order_id' => (string)$orderId,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            Log::info("Notifikasi dikirim ke user: {$userId}");
        } catch (\Exception $e) {
            Log::warning("Gagal insert notifikasi: " . $e->getMessage());
        }
    }

    /**
     * Halaman status pembayaran
     */
    public function status($id)
    {
        try {
            $booking = DB::connection('booking')->table('bookings')
                ->where('order_id', $id)
                ->first();

            if (!$booking) {
                abort(404, 'Data transaksi tidak ditemukan.');
            }

            return view('payment.status', compact('booking'));
        } catch (\Exception $e) {
            Log::error("Error payment status: " . $e->getMessage());
            abort(500, 'Terjadi kesalahan sistem');
        }
    }

    /**
     * Ambil notifikasi user
     */
    public function getNotifications()
    {
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $userId = Auth::id();
            
            $notifications = DB::connection('booking')->table('notifications')
                ->where('user_id', (string)$userId)
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();
            
            $unreadCount = DB::connection('booking')->table('notifications')
                ->where('user_id', (string)$userId)
                ->where('is_read', false)
                ->count();
            
            return response()->json([
                'success' => true,
                'data' => $notifications,
                'unread_count' => $unreadCount
            ]);
        } catch (\Exception $e) {
            Log::error("Error get notifications: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil notifikasi'
            ], 500);
        }
    }

    /**
     * Tandai notifikasi sudah dibaca
     */
    public function markNotificationAsRead($id)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            DB::connection('booking')->table('notifications')
                ->where('id', $id)
                ->where('user_id', (string)Auth::id())
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                    'updated_at' => now()
                ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error mark notification: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Tandai semua notifikasi sudah dibaca
     */
    public function markAllNotificationsAsRead()
    {
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            DB::connection('booking')->table('notifications')
                ->where('user_id', (string)Auth::id())
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                    'updated_at' => now()
                ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error mark all notifications: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}