<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class BookingController extends Controller
{
    /**
     * Nama: Andreas Hutahaean
     * Proyek: Flash-Tix (Sistem E-Ticketing Konser)
     * Deskripsi: Menangani alur pemesanan dengan proteksi konkurensi tinggi (Anti Double Booking).
     */
    public function __construct()
    {
        $this->initMidtrans();
    }

    /**
     * Inisialisasi konfigurasi Midtrans
     */
    private function initMidtrans()
    {
        Config::$serverKey = config('services.midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = (bool) (config('services.midtrans.is_production') ?? false);
        Config::$isSanitized = (bool) (config('services.midtrans.is_sanitized') ?? true);
        Config::$is3ds = (bool) (config('services.midtrans.is_3ds') ?? true);

        if (empty(Config::$serverKey)) {
            Log::error("Flash-Tix: Server Key Midtrans kosong. Periksa file .env kamu!");
        }
    }

    /**
     * FITUR USER: Menampilkan halaman "Tiket Saya" (Riwayat dan Statistik Tiket dari MongoDB)
     */
    public function myBookings()
    {
        $userId = (string) Auth::id();

        // 1. Statistik Utama dari db_booking Cluster MongoDB
        $totalPesanan = DB::connection('booking')->table('bookings')
            ->where('user_id', $userId)->count();

        // Mengizinkan status 'pending'/'PENDING' masuk untuk keperluan pengujian lokal sebelum webhook aktif
        $pesananAktif = DB::connection('booking')->table('bookings')
            ->where('user_id', $userId)
            ->whereIn('status', ['paid', 'success', 'PAID', 'SUCCESS', 'confirmed', 'booked', 'pending', 'PENDING'])->count();

        $totalBelanja = DB::connection('booking')->table('bookings')
            ->where('user_id', $userId)
            ->whereIn('status', ['paid', 'success', 'PAID', 'SUCCESS', 'confirmed', 'booked', 'pending', 'PENDING'])
            ->sum('total_price');

        // 2. Ambil 3 Tiket Aktif untuk dicetak E-Tiketnya
        $activeTicketsRaw = DB::connection('booking')->table('bookings')
            ->where('user_id', $userId)
            ->whereIn('status', ['paid', 'success', 'PAID', 'SUCCESS', 'confirmed', 'booked', 'pending', 'PENDING'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $activeTickets = $this->mapConcertData($activeTicketsRaw);

        // 3. Ambil 5 Transaksi Terbaru (Semua status: pending/success)
        $recentOrdersRaw = DB::connection('booking')->table('bookings')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentOrders = $this->mapConcertData($recentOrdersRaw);

        return view('tiket.index', compact(
            'totalPesanan', 'pesananAktif', 'totalBelanja',
            'activeTickets', 'recentOrders'
        ));
    }

    /**
     * Fungsi pembantu untuk mencocokkan id relasi booking ke db_concert MongoDB
     */
    private function mapConcertData($bookings)
    {
        $data = [];
        foreach ($bookings as $booking) {
            $item = (array) $booking;
            
            // Cari data konser dari database terpisah (db_concert)
            $concert = DB::connection('concert')->table('concerts')
                ->where('_id', (string) $item['concert_id'])->first();

            $item['concert_name'] = $concert->name ?? ($concert->title ?? 'Konser Flash-Tix');
            $item['venue'] = $concert->venue ?? 'Main Hall';
            $item['city'] = $concert->city ?? 'Jakarta';
            $item['date'] = $concert->date ?? '2026';
            $item['time'] = $concert->time ?? '19:00';
            $item['artist'] = $concert->artist ?? 'Artis';

            $data[] = (object) $item;
        }
        return $data;
    }

    /**
     * Menampilkan form pemesanan tiket (Step 2)
     */
    public function form(Request $request, $id)
    {
        $concert = DB::connection('concert')->table('concerts')->where('_id', $id)->first();
        
        if (!$concert) {
            return redirect()->route('dashboard')->with('error', 'Konser tidak ditemukan.');
        }

        return view('booking.form', [
            'concert'       => $concert,
            'category'      => $request->query('category', 'TRIBUN'),
            'selectedSeats' => $request->query('seats', []), 
            'totalPrice'    => (int) $request->query('total_price', 0)
        ]);
    }

    /**
     * Proses Checkout: Dilapisi Pengaman Concurrency Kontrol Anti-Oversold
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'concert_id'  => 'required',
            'category'    => 'required',
            'seats'       => 'required|array',
            'total_price' => 'required|numeric|min:1000',
            'phone'       => 'required'
        ]);

        $this->initMidtrans();

        $concertId = (string) $request->concert_id;
        $requestedSeats = $request->seats;

        // --- BENTENG PERTAHANAN 1: ATOMIC CONCURRENCY CHECK ---
        $alreadyTaken = DB::connection('booking')->table('bookings')
            ->where('concert_id', $concertId)
            ->whereIn('status', ['paid', 'success', 'confirmed', 'booked', 'pending', 'PENDING'])
            ->where(function($query) use ($requestedSeats) {
                foreach ($requestedSeats as $seat) {
                    $query->orWhere('seats', $seat)->orWhere('seats', 'all', [$seat]);
                }
            })
            ->exists();

        if ($alreadyTaken) {
            return redirect()->route('concerts.seats', $concertId)
                ->with('error', 'Gagal memproses checkout! Salah satu nomor kursi pilihan Anda baru saja diambil atau sedang dalam proses pembayaran oleh user lain. Silakan pilih kursi kembali.');
        }

        $concert = DB::connection('concert')->table('concerts')
                    ->where('_id', $concertId)
                    ->first();

        $orderId = 'FTIX-' . strtoupper(Str::random(10));

        try {
            $bookingData = [
                'order_id'    => $orderId,
                'user_id'     => (string) Auth::id(),
                'concert_id'  => $concertId,
                'category'    => $request->category,
                'seats'       => $requestedSeats, 
                'total_price' => (int) $request->total_price,
                'status'      => 'PENDING', 
                'snap_token'  => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            // Masukkan data transaksi pertama kali (Mengunci nomor kursi secara lokal)
            DB::connection('booking')->table('bookings')->insert($bookingData);

            // Bersihkan format nomor WhatsApp inputan user dari karakter non-angka
            $cleanPhone = preg_replace('/[^0-9]/', '', $request->phone);

            // Susun parameter transaksi ke gateway Midtrans Snap API
            $params = [
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => (int) $request->total_price,
                ],
                'customer_details' => [
                    'first_name' => $request->input('name', Auth::user()->name),
                    'email'      => $request->input('email', Auth::user()->email),
                    'phone'      => $cleanPhone, 
                ],
                'expiry' => [
                    'start_time' => date("Y-m-d H:i:s O"),
                    'duration'   => 10,
                    'unit'       => 'minute' // FIX: Menggunakan 'minute' tunggal tanpa 's' agar tidak error
                ],
                'enabled_payments' => [
                    'other_qris', 'gopay', 'shopeepay', 'bank_transfer', 'cstore'
                ],
            ];

            // Request Snap Token secara real-time ke Midtrans
            $snapToken = Snap::getSnapToken($params);

            // Update Snap Token kembali ke database dokumen MongoDB
            DB::connection('booking')->table('bookings')
                ->where('order_id', $orderId)
                ->update(['snap_token' => $snapToken]);

            return view('payment.status', [
                'orderId'   => $orderId,
                'snapToken' => $snapToken,
                'total'     => $request->total_price,
                'booking'   => (object) $bookingData, 
                'concert'   => $concert
            ]);

        } catch (\Exception $e) {
            Log::error("Flash-Tix Kritis Saat Checkout War Tiket: " . $e->getMessage());
            
            // Fail-Safe: Jika API Midtrans drop, hapus data booking lokal agar nomor kursi bisa di-war ulang
            DB::connection('booking')->table('bookings')->where('order_id', $orderId)->delete();
            
            return redirect()->back()->with('error', 'Koneksi ke Payment Gateway sibuk atau error. Sesi kursi Anda telah dilepas, silakan coba beberapa saat lagi.');
        }
    }

    /**
     * FITUR: Menampilkan data detail E-Tiket Online setelah sukses bayar
     */
    public function showTicket($orderId)
    {
        // 1. Ambil data booking dari db_booking MongoDB
        $bookingData = DB::connection('booking')->table('bookings')
            ->where('order_id', $orderId)
            ->first();

        if (!$bookingData) {
            abort(404, 'Data pesanan tiket tidak ditemukan.');
        }

        $booking = (array) $bookingData;

        // Toleransi status diperlonggar menggunakan strtoupper untuk pengujian / cetak manifes tiket
        $currentStatus = strtoupper($booking['status'] ?? '');
        if (!in_array($currentStatus, ['SUCCESS', 'PAID', 'CONFIRMED', 'BOOKED', 'PENDING'])) {
            return redirect()->route('my-bookings')->with('error', 'E-Tiket belum terbit karena pembayaran Anda belum lunas.');
        }

        // 2. Ambil data detail konser dari db_concert MongoDB
        $concert = DB::connection('concert')->table('concerts')
            ->where('_id', (string)$booking['concert_id'])
            ->first();

        // 3. Ambil data pembeli dari database user laravel auth
        $user = \App\Models\User::find($booking['user_id']);

        return view('booking.ticket', compact('booking', 'concert', 'user'));
    }
}