<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConcertController;
use App\Http\Controllers\HowItWorksController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;

// --- IMPORT CONTROLLER ADMIN ---
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ConcertController as AdminConcertController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ScannerController; // Tambahan untuk Web-Cam Scanner

/*
|--------------------------------------------------------------------------
| HALAMAN UMUM (Public Routes)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cara-kerja', [HowItWorksController::class, 'index'])->name('how-it-works');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact');

// Katalog Concert Utama
Route::get('/concerts', [ConcertController::class, 'index'])->name('concerts.index');
Route::get('/concerts/{id}', [ConcertController::class, 'show'])->name('concerts.show');

/**
 * PENTING: Route Webhook Midtrans Callback
 * Diarahkan ke PaymentController agar sinkron dengan update status & blokir kursi Flash-Tix
 */
Route::post('/payment/callback', [PaymentController::class, 'handleCallback'])->name('payment.callback');

/*
|--------------------------------------------------------------------------
| HALAMAN USER (Wajib Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    // ============================================
    // ROUTE TIKET SAYA (MANAJEMEN & SINKRONISASI DB)
    // ============================================
    Route::get('/tiket-saya', [DashboardController::class, 'tiketSaya'])->name('tiket.saya');
    
    // Dashboard User Panel Utama Hub (Memanggil DashboardController@index sesuai MVC)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // ============================================
    // FLOW WAR TIKET & PROSES PESANAN (FIXED DOUBLE METHOD HANDLING)
    // ============================================
    // Step 1: Tampilkan Denah Kursi/Seat Plan
    Route::get('/concerts/{id}/seats', [ConcertController::class, 'seats'])->name('concerts.seats');
    
    // Jembatan Pengaman: Mengantisipasi jika denah kursi submit data menggunakan POST
    Route::post('/concerts/{id}/seats', function($id) {
        return redirect()->to(route('booking.form', $id) . '?' . http_build_query(request()->all()));
    });
    
    // Step 2: Form Data Pemesanan Booking (Mendukung GET dan POST demi kelancaran alur view)
    Route::get('/booking/form/{id}', [BookingController::class, 'form'])->name('booking.form');
    Route::post('/booking/form/{id}', [BookingController::class, 'form'])->name('booking.form.post');
    
    // Step 3: Proses Checkout Data ke Snap Midtrans (Jantung Eksekusi Pembayaran)
    Route::post('/booking/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
    Route::get('/booking/checkout', function() {
        return redirect()->route('concerts.index')->with('error', 'Sesi checkout ilegal terdeteksi.');
    });
    
    // Halaman Sinkronisasi Status Pembayaran Akhir
    Route::get('/payment/status/{id}', [PaymentController::class, 'status'])->name('payment.status');

    // Route Cetak / Tampilkan E-Tiket Berkode QR
    Route::get('/ticket/{order_id}', [BookingController::class, 'showTicket'])->name('ticket.show');
    
    // ============================================
    // FITUR COMPLEMENTARY USER
    // ============================================
    // My Bookings (Fungsi penarik riwayat tiket milik user)
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my-bookings');
    Route::get('/my-bookings/{id}', [BookingController::class, 'showBooking'])->name('my-bookings.show');
    
    // Wishlist / Favorit Konser
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    
    // Notifikasi Sistem Antrean & Perbaikan Error Route Missing (Standardisasi Kapital)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/list', [NotificationController::class, 'index'])->name('notifications.get'); // Sinkronisasi app.blade
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read'); // Fitur mark all read
    
    // ============================================
    // PROFILE MANAGEMENT CUSTOM AVATAR & SAFETY DESTROY
    // ============================================
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update-fallback');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Filter Status Pembayaran & Riwayat Belanja Belanja
    Route::get('/payment/pending', [BookingController::class, 'pendingPayments'])->name('payment.pending');
    Route::get('/purchase/history', [BookingController::class, 'purchaseHistory'])->name('purchase.history');
});

/*
|--------------------------------------------------------------------------
| PANEL ADMIN (Wajib Login & Akses Hak Otorisasi Admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Kelola Data Master Katalog Konser (CRUD MongoDB)
    Route::resource('concerts', AdminConcertController::class);
    
    // Kelola Log Transaksi Pemesanan Masuk Global
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::put('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.update-status');
    Route::delete('/bookings/{id}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
    
    // Kelola Manajemen Data Akun Pengguna Sistem
    Route::resource('users', AdminUserController::class);

    // ============================================
    // FITUR PRO: GATE SCANNER (WEB-CAM)
    // ============================================
    Route::get('/scanner', [ScannerController::class, 'index'])->name('scanner.index');
    Route::post('/scanner/verify', [ScannerController::class, 'verify'])->name('scanner.verify');
});

// Memuat subsistem berkas autentikasi bawaan framework (Login, Register, Logout)
require __DIR__.'/auth.php';