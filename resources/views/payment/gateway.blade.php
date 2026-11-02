@extends('layouts.app')

@section('title', 'Pembayaran - Flash-Tix')

@section('content')
<style>
    .payment-method {
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
        background-color: var(--bg-card);
        border-color: var(--border-color);
    }
    
    .payment-method.selected {
        border-color: #7c3aed;
        background: #f3e8ff;
    }
    
    body.dark-mode .payment-method.selected {
        background: #2d3748;
        border-color: #7c3aed;
    }
    
    .payment-method:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    .timer-box {
        background-color: var(--bg-card);
        border-color: var(--border-color);
    }
    
    .summary-box {
        background-color: var(--bg-body);
        border: 1px solid var(--border-color);
    }
</style>

<div class="min-h-screen py-12" style="background-color: var(--bg-body);">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            
            <!-- Timer -->
            <div class="timer-box border rounded-xl p-4 mb-8 text-center">
                <div class="flex items-center justify-center gap-3">
                    <i class="fas fa-hourglass-half text-red-500 text-2xl"></i>
                    <span class="text-red-700 font-semibold">Selesaikan pembayaran sebelum:</span>
                    <span class="text-red-600 font-bold text-2xl" id="paymentTimer">15:00</span>
                </div>
            </div>
            
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold mb-2" style="color: var(--text-primary);">Metode Pembayaran</h1>
                <p style="color: var(--text-secondary);">Pilih metode pembayaran yang tersedia</p>
            </div>
            
            <div class="rounded-2xl shadow-lg p-8" style="background-color: var(--bg-card);">
                
                <!-- Metode Pembayaran -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="payment-method border rounded-xl p-4 text-center cursor-pointer" data-method="qris">
                        <i class="fab fa-qrcode text-3xl text-green-600 mb-2"></i>
                        <p class="font-semibold" style="color: var(--text-primary);">QRIS</p>
                        <p class="text-xs" style="color: var(--text-secondary);">Scan QR Code</p>
                    </div>
                    
                    <div class="payment-method border rounded-xl p-4 text-center cursor-pointer" data-method="bca">
                        <i class="fas fa-university text-3xl text-blue-600 mb-2"></i>
                        <p class="font-semibold" style="color: var(--text-primary);">BCA</p>
                        <p class="text-xs" style="color: var(--text-secondary);">Virtual Account</p>
                    </div>
                    
                    <div class="payment-method border rounded-xl p-4 text-center cursor-pointer" data-method="gopay">
                        <i class="fab fa-google-pay text-3xl text-green-600 mb-2"></i>
                        <p class="font-semibold" style="color: var(--text-primary);">GoPay</p>
                        <p class="text-xs" style="color: var(--text-secondary);">E-Wallet</p>
                    </div>
                    
                    <div class="payment-method border rounded-xl p-4 text-center cursor-pointer" data-method="ovo">
                        <i class="fas fa-wallet text-3xl text-purple-600 mb-2"></i>
                        <p class="font-semibold" style="color: var(--text-primary);">OVO</p>
                        <p class="text-xs" style="color: var(--text-secondary);">E-Wallet</p>
                    </div>
                </div>
                
                <!-- Ringkasan Pembayaran -->
                <div class="summary-box rounded-xl p-4 mb-6">
                    <h3 class="font-semibold mb-3" style="color: var(--text-primary);">Ringkasan Pembayaran</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span style="color: var(--text-secondary);">Kategori Kursi</span>
                            <span class="font-semibold" style="color: var(--text-primary);" id="payCategory">VIP</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: var(--text-secondary);">Jumlah Tiket</span>
                            <span class="font-semibold" style="color: var(--text-primary);" id="payQuantity">2</span>
                        </div>
                        <div class="flex justify-between border-t pt-2 mt-2">
                            <span class="font-bold" style="color: var(--text-primary);">Total</span>
                            <span class="text-purple-600 font-bold text-xl" id="payTotal">Rp 0</span>
                        </div>
                    </div>
                </div>
                
                <!-- Tombol Bayar -->
                <button id="payBtn" class="w-full bg-purple-600 text-white py-3 rounded-xl font-semibold hover:bg-purple-700 transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    <i class="fas fa-credit-card mr-2"></i>
                    Bayar Sekarang
                </button>
                
                <p class="text-gray-400 text-xs text-center mt-4">
                    <i class="fas fa-shield-alt mr-1"></i> Pembayaran aman dan terenkripsi
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // ============================================
    // TIMER 15 MENIT
    // ============================================
    let selectedMethod = null;
    let paymentTimeLeft = 15 * 60;
    let paymentTimerInterval;
    
    function updatePaymentTimer() {
        const minutes = Math.floor(paymentTimeLeft / 60);
        const seconds = paymentTimeLeft % 60;
        const timerElement = document.getElementById('paymentTimer');
        if (timerElement) {
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }
        
        if (paymentTimeLeft <= 0) {
            clearInterval(paymentTimerInterval);
            alert('Waktu pembayaran habis! Pesanan dibatalkan.');
            window.location.href = "{{ route('concerts.index') }}";
        }
        paymentTimeLeft--;
    }
    
    // Mulai timer
    paymentTimerInterval = setInterval(updatePaymentTimer, 1000);
    
    // ============================================
    // DATA PEMBAYARAN (Simulasi)
    // ============================================
    // Cek apakah ada data booking dari localStorage
    let bookingData = null;
    try {
        bookingData = JSON.parse(localStorage.getItem('bookingData'));
    } catch(e) {
        console.log('No booking data found');
    }
    
    if (bookingData) {
        document.getElementById('payCategory').textContent = bookingData.category ? bookingData.category.toUpperCase() : 'VIP';
        document.getElementById('payQuantity').textContent = bookingData.quantity || 1;
        document.getElementById('payTotal').textContent = `Rp ${(bookingData.total || 0).toLocaleString('id-ID')}`;
    } else {
        // Data contoh jika tidak ada booking
        document.getElementById('payCategory').textContent = 'VIP';
        document.getElementById('payQuantity').textContent = '2';
        document.getElementById('payTotal').textContent = 'Rp 1.000.000';
    }
    
    // ============================================
    // PILIH METODE PEMBAYARAN
    // ============================================
    const paymentMethods = document.querySelectorAll('.payment-method');
    const payBtn = document.getElementById('payBtn');
    
    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            // Hapus class selected dari semua method
            paymentMethods.forEach(m => m.classList.remove('selected'));
            // Tambah class selected ke method yang dipilih
            this.classList.add('selected');
            selectedMethod = this.dataset.method;
            payBtn.disabled = false;
            payBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        });
    });
    
    // ============================================
    // PROSES PEMBAYARAN
    // ============================================
    payBtn.addEventListener('click', function() {
        if (selectedMethod) {
            // Simulasi proses pembayaran
            payBtn.disabled = true;
            payBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
            
            setTimeout(() => {
                alert('✅ Pembayaran berhasil! E-tiket akan dikirim ke email Anda.');
                // Hapus data booking dari localStorage
                localStorage.removeItem('bookingData');
                // Hentikan timer
                clearInterval(paymentTimerInterval);
                // Redirect ke dashboard
                window.location.href = "{{ route('dashboard') }}";
            }, 1500);
        }
    });
    
    // ============================================
    // CEK APAKAH USER SUDAH LOGIN (UNTUK REDIRECT)
    // ============================================
    @auth
        // Sudah login, lanjutkan
    @else
        // Belum login, redirect ke login
        alert('Silakan login terlebih dahulu untuk melakukan pembayaran');
        window.location.href = "{{ route('login') }}";
    @endauth
</script>
@endsection