@extends('layouts.app')

@section('title', 'Dashboard Hub - Flash-Tix')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    * {
        font-family: 'Inter', sans-serif;
    }
    
    body {
        background: #f8fafc;
    }
    
    /* Hub Banner Styles */
    .hub-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #2e1065 100%);
        border-radius: 28px;
        border: 1px solid #334155;
        position: relative;
        overflow: hidden;
    }
    
    .hub-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    /* Card Styles */
    .hub-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .hub-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #7c3aed, #ec4899, #7c3aed);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    
    .hub-card:hover::after {
        transform: scaleX(1);
    }
    
    .hub-card:hover {
        transform: translateY(-4px);
        border-color: #7c3aed;
        box-shadow: 0 20px 30px -15px rgba(124, 58, 237, 0.2);
    }
    
    /* Status Pulse */
    .status-pulse {
        position: relative;
    }
    
    .status-pulse::after {
        content: '';
        position: absolute;
        width: 8px;
        height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        right: -14px;
        animation: pulse 1.5s infinite;
        box-shadow: 0 0 5px #10b981;
    }
    
    @keyframes pulse {
        0% { transform: translateY(-50%) scale(0.9); opacity: 1; }
        50% { transform: translateY(-50%) scale(1.3); opacity: 0.5; }
        100% { transform: translateY(-50%) scale(0.9); opacity: 1; }
    }
    
    /* Payment Logo Styles - Original Brands */
    .payment-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }
    
    .payment-item {
        background: white;
        border-radius: 14px;
        padding: 12px 8px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid #e2e8f0;
        position: relative;
        overflow: hidden;
    }
    
    .payment-item:hover {
        transform: translateY(-3px);
        border-color: #7c3aed;
        box-shadow: 0 8px 20px rgba(124, 58, 237, 0.15);
    }
    
    .payment-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 8px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    
    .payment-item:hover .payment-icon {
        transform: scale(1.05);
    }
    
    .payment-name {
        font-size: 11px;
        font-weight: 600;
        color: #1e293b;
    }
    
    /* Original Brand Colors */
    .gopay-icon { background: linear-gradient(135deg, #00A9B0, #008B8F); color: white; }
    .qris-icon { background: linear-gradient(135deg, #1E3A5F, #15294A); color: white; }
    .bca-icon { background: linear-gradient(135deg, #1A5B8E, #0D3B5E); color: white; }
    .mandiri-icon { background: linear-gradient(135deg, #E31E24, #B8161C); color: white; }
    .bni-icon { background: linear-gradient(135deg, #0A4B7A, #063456); color: white; }
    .bri-icon { background: linear-gradient(135deg, #1E6B3E, #145230); color: white; }
    .shopeepay-icon { background: linear-gradient(135deg, #EE4D2D, #CC3A1C); color: white; }
    .dana-icon { background: linear-gradient(135deg, #3A7BD5, #2A5FAE); color: white; }
    .ovo-icon { background: linear-gradient(135deg, #502D7E, #3A1F5E); color: white; }
    .linkaja-icon { background: linear-gradient(135deg, #E31C5F, #B8144A); color: white; }
    
    /* Notification Card */
    .notif-card {
        background: white;
        border-radius: 16px;
        padding: 16px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .notif-card:hover {
        border-color: #7c3aed;
        transform: translateX(4px);
    }
    
    /* Mini Concert Card */
    .mini-concert-card {
        background: white;
        border-radius: 16px;
        padding: 12px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        display: flex;
        gap: 12px;
        align-items: center;
    }
    
    .mini-concert-card:hover {
        border-color: #7c3aed;
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.1);
    }
    
    .mini-concert-image {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: linear-gradient(135deg, #7c3aed, #ec4899);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }
    
    /* Tooltip */
    .payment-tooltip {
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #1e293b;
        color: white;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 10px;
        white-space: nowrap;
        margin-bottom: 8px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        pointer-events: none;
        z-index: 50;
    }
    
    .payment-item:hover .payment-tooltip {
        opacity: 1;
        visibility: visible;
    }
    
    .payment-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-width: 5px;
        border-style: solid;
        border-color: #1e293b transparent transparent transparent;
    }
    
    /* Footer Styles */
    .footer-section {
        position: relative;
    }
    
    .footer-section h4 {
        position: relative;
        display: inline-block;
        padding-bottom: 8px;
    }
    
    .footer-section h4::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 30px;
        height: 2px;
        background: linear-gradient(90deg, #7c3aed, #ec4899);
        border-radius: 2px;
    }
    
    .footer-link {
        transition: all 0.3s ease;
        display: inline-block;
    }
    
    .footer-link:hover {
        color: #7c3aed;
        transform: translateX(4px);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .payment-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .payment-icon {
            width: 40px;
            height: 40px;
            font-size: 20px;
        }
        .hub-banner {
            padding: 20px !important;
        }
        h1 {
            font-size: 24px !important;
        }
    }
    
    /* Animation for cards */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-card {
        animation: fadeInUp 0.5s ease forwards;
    }
    
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
</style>

<div class="py-8 px-4 min-h-screen" style="background: #f8fafc;">
    
    <div class="container mx-auto max-w-7xl">
        
        <!-- ============================================ -->
        <!-- BANNER RUANG AKUN TERPROTEKSI -->
        <!-- ============================================ -->
        <div class="hub-banner p-8 mb-8 text-white relative shadow-2xl">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <span class="bg-purple-500/20 text-purple-300 border border-purple-500/30 text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full inline-flex items-center gap-1">
                        <i class="fas fa-shield-alt text-xs"></i> Ruang Akun Terproteksi
                    </span>
                    <h1 class="text-3xl md:text-4xl font-black tracking-tight mt-4 mb-2">
                        Selamat Datang Kembali, <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">{{ Auth::user()->name }}</span>
                    </h1>
                    <p class="text-slate-300 text-sm max-w-lg">
                        <i class="fas fa-crown text-yellow-500 mr-1 text-xs"></i> 
                        Akses panel utama untuk mengelola informasi, keamanan, dan penjelajahan konser aktif.
                    </p>
                </div>
                <div class="bg-slate-900/70 backdrop-blur-md rounded-2xl p-5 border border-slate-700/50 text-right min-w-[220px] shadow-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-slate-400">Status Sesi Anda</span>
                        <i class="fas fa-circle text-emerald-500 text-[8px]"></i>
                    </div>
                    <span class="text-base font-bold text-emerald-400 inline-flex items-center gap-2 status-pulse">
                        <i class="fas fa-shield-haltered"></i> Terhubung Aman
                    </span>
                    <div class="mt-3 pt-3 border-t border-slate-700/50">
                        <span class="text-[10px] text-slate-500 block">
                            <i class="fas fa-server mr-1"></i> IP Server: 127.0.0.1
                        </span>
                        <span class="text-[9px] text-slate-600 block mt-1">
                            Last login: {{ now()->format('H:i, d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- ============================================ -->
        <!-- MAIN CONTENT GRID -->
        <!-- ============================================ -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- LEFT COLUMN - Navigasi Fitur Sistem -->
            <div class="lg:col-span-2 space-y-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center">
                            <i class="fas fa-compass text-white text-sm"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">Navigasi Fitur Sistem</h2>
                            <p class="text-xs text-slate-500">Pilih menu di bawah ini untuk mengoperasikan aplikasi Flash-Tix.</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        
                        <!-- Jelajahi Concert -->
                        <a href="{{ route('concerts.index') }}" class="hub-card p-5 flex items-start gap-4 group animate-card">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center group-hover:scale-110 transition-all duration-300 shadow-md">
                                <i class="fas fa-compass text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-800 text-base group-hover:text-blue-600 transition-colors">Jelajahi Concert</h3>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Cari konser musik aktif, pilih kategori kursi Tribun/VIP, dan lakukan transaksi pembelian.</p>
                                <span class="text-[10px] text-blue-500 mt-2 inline-flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    Jelajahi <i class="fas fa-arrow-right text-[8px]"></i>
                                </span>
                            </div>
                        </a>

                        <!-- Buka Tiket Saya -->
                        <a href="{{ route('my-bookings') }}" class="hub-card p-5 flex items-start gap-4 group animate-card delay-1">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 text-white flex items-center justify-center group-hover:scale-110 transition-all duration-300 shadow-md">
                                <i class="fas fa-ticket-alt text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-800 text-base group-hover:text-purple-600 transition-colors">Buka Tiket Saya</h3>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Lihat e-tiket berkode QR, cetak invoice belanja, dan pantau log transaksi sukses dari database.</p>
                                <span class="text-[10px] text-purple-500 mt-2 inline-flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    Lihat Tiket <i class="fas fa-arrow-right text-[8px]"></i>
                                </span>
                            </div>
                        </a>

                        <!-- Pengaturan Profil -->
                        <div class="hub-card p-5 flex items-start gap-4 group animate-card delay-2">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 text-white flex items-center justify-center group-hover:scale-110 transition-all duration-300 shadow-md">
                                <i class="fas fa-user-cog text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-800 text-base group-hover:text-amber-600 transition-colors">Pengaturan Profil</h3>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Ubah kata sandi akun Anda, perbarui email notifikasi, dan kelola detail data personal data.</p>
                                <span class="text-[10px] text-amber-500 mt-2 inline-flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    Pengaturan <i class="fas fa-arrow-right text-[8px]"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Keluar Sesi -->
                        <div class="hub-card p-5 flex items-start gap-4 group animate-card delay-3">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-rose-600 text-white flex items-center justify-center group-hover:scale-110 transition-all duration-300 shadow-md">
                                <i class="fas fa-sign-out-alt text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-800 text-base group-hover:text-rose-600 transition-colors">Keluar Sesi</h3>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed mb-3">Akhiri sesi autentikasi Anda demi keamanan log aktivitas server.</p>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[11px] text-rose-600 font-bold hover:underline inline-flex items-center gap-1">
                                        Klik untuk Logout <i class="fas fa-arrow-right text-[8px]"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Catatan Infrastruktur -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-slate-300 rounded-2xl p-6 border border-slate-700 shadow-xl animate-card">
                    <h3 class="text-base font-bold text-white mb-3 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-purple-500/20 flex items-center justify-center">
                            <i class="fas fa-server text-purple-400 text-sm"></i>
                        </div>
                        Catatan Infrastruktur Flash-Tix
                    </h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Sistem ini menggunakan arsitektur <span class="text-purple-400 font-semibold">3 Database Terisolasi</span> berbasis 
                        <span class="text-emerald-400 font-semibold">MongoDB Replica Set</span> (Node 1, Node 2, & Arbiter) demi toleransi kesalahan maksimal. 
                        Setiap transaksi pemesanan kursi diproses melalui broker antrean <span class="text-amber-400 font-semibold">Apache Kafka</span> 
                        untuk menghindari tabrakan data <span class="text-slate-500">(race condition)</span>.
                    </p>
                </div>
            </div>
            
            <!-- RIGHT COLUMN - Pemberitahuan Sistem & Konser Terbaru -->
            <div class="space-y-6">
                <!-- Pemberitahuan Sistem -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center">
                            <i class="fas fa-bell text-white text-sm"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">Pemberitahuan Sistem</h2>
                            <p class="text-xs text-slate-500">Informasi dan pengumuman *war tiket* terbaru.</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Notif 1 -->
                        <div class="notif-card hover:border-purple-300 group">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                    <i class="fas fa-credit-card text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                        Integrasi Pembayaran Otomatis
                                        <span class="text-[9px] bg-green-100 text-green-600 px-2 py-0.5 rounded-full">Terbaru</span>
                                    </h4>
                                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Callback Midtrans telah dikonfigurasi melalui secure tunnel ngrok dev. Status transaksi Anda akan diperbarui instan.</p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <i class="fas fa-check-circle text-green-500 text-[8px]"></i>
                                        <span class="text-[9px] text-slate-400">Aktif</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notif 2 -->
                        <div class="notif-card hover:border-purple-300 group">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                    <i class="fas fa-bolt text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-slate-800">Tips Mengikuti War Tiket</h4>
                                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Pastikan Anda telah masuk akun sebelum war dimulai. Tombol pesan akan langsung mengarahkan Anda ke denah layout kursi secara instan.</p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <i class="fas fa-clock text-amber-500 text-[8px]"></i>
                                        <span class="text-[9px] text-slate-400">1 Jam yang lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- KONSER TERBARU - DENGAN EKSTRAKSI AMAN -->
                <!-- ============================================ -->
                @if(isset($recentConcerts) && count($recentConcerts) > 0)
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-r from-green-500 to-emerald-500 flex items-center justify-center">
                            <i class="fas fa-music text-white text-sm"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">Konser Terbaru</h2>
                            <p class="text-xs text-slate-500">Rekomendasi konser untuk Anda hari ini.</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        @foreach($recentConcerts as $concert)
                        @php
                            // ============================================
                            // EKSTRAKSI FIELD AMAN - Support Object & Array
                            // ============================================
                            $concertId = is_object($concert) ? ($concert->_id ?? $concert->id ?? '#') : ($concert['_id'] ?? $concert['id'] ?? '#');
                            $concertName = is_object($concert) ? ($concert->name ?? $concert->title ?? 'Konser Musik') : ($concert['name'] ?? $concert['title'] ?? 'Konser Musik');
                            $concertArtist = is_object($concert) ? ($concert->artist ?? 'Special Artist') : ($concert['artist'] ?? 'Special Artist');
                            $concertVenue = is_object($concert) ? ($concert->venue ?? 'Venue') : ($concert['venue'] ?? 'Venue');
                            $concertCity = is_object($concert) ? ($concert->city ?? 'Jakarta') : ($concert['city'] ?? 'Jakarta');
                            $concertPrice = 0;
                            
                            // Ekstrak harga dari categories jika ada
                            if (is_object($concert) && isset($concert->categories) && is_array($concert->categories) && count($concert->categories) > 0) {
                                $concertPrice = $concert->categories[0]['price'] ?? 250000;
                            } elseif (is_array($concert) && isset($concert['categories']) && is_array($concert['categories']) && count($concert['categories']) > 0) {
                                $concertPrice = $concert['categories'][0]['price'] ?? 250000;
                            } elseif (is_object($concert) && isset($concert->price)) {
                                $concertPrice = $concert->price;
                            } elseif (is_array($concert) && isset($concert['price'])) {
                                $concertPrice = $concert['price'];
                            } else {
                                $concertPrice = 250000;
                            }
                            
                            $availableSeats = is_object($concert) ? ($concert->available_seats ?? 0) : ($concert['available_seats'] ?? 0);
                            $date = is_object($concert) ? ($concert->date ?? date('Y-m-d')) : ($concert['date'] ?? date('Y-m-d'));
                            $formattedDate = \Carbon\Carbon::parse($date)->translatedFormat('d M Y');
                        @endphp
                        <a href="{{ route('concerts.show', $concertId) }}" class="mini-concert-card group">
                            <div class="mini-concert-image">
                                <i class="fas fa-ticket-alt text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-slate-800 text-sm truncate">{{ $concertName }}</h4>
                                <p class="text-xs text-purple-600 font-semibold">{{ $concertArtist }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] text-slate-400"><i class="fas fa-map-marker-alt mr-0.5"></i> {{ $concertCity }}</span>
                                    <span class="text-[10px] text-slate-400"><i class="fas fa-calendar mr-0.5"></i> {{ $formattedDate }}</span>
                                </div>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-sm font-bold text-gradient">Rp {{ number_format($concertPrice, 0, ',', '.') }}</span>
                                    @if($availableSeats > 0 && $availableSeats <= 10)
                                        <span class="text-[9px] bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full">Hampir Habis!</span>
                                    @elseif($availableSeats > 0)
                                        <span class="text-[9px] text-green-600">Tersedia</span>
                                    @else
                                        <span class="text-[9px] text-red-500">Sold Out</span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-purple-500 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </div>
                        </a>
                        @endforeach
                        
                        <!-- Link Lihat Semua -->
                        <a href="{{ route('concerts.index') }}" class="flex items-center justify-center gap-2 text-center text-purple-600 text-xs font-semibold mt-3 py-2 border border-purple-200 rounded-xl hover:bg-purple-50 transition-colors">
                            Lihat Semua Konser <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
    
    <!-- ============================================ -->
    <!-- FOOTER -->
    <!-- ============================================ -->
    <footer class="bg-white border-t border-slate-200 py-12 text-slate-500 text-xs w-full mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <!-- Brand Section -->
            <div class="footer-section space-y-3">
                <div class="flex items-center gap-2">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 p-2 rounded-xl text-white shadow-lg shadow-purple-600/20">
                        <i class="fas fa-bolt text-base"></i>
                    </div>
                    <span class="text-base font-black tracking-wider bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">FLASH-TIX</span>
                </div>
                <p class="leading-relaxed text-slate-400 text-[11px]">
                    Sistem distribusi tiket elektronik berkinerja tinggi, mengandalkan replikasi database terisolasi untuk mengamankan transaksi pesanan Anda.
                </p>
                <p class="font-semibold text-slate-500 text-[10px] mt-4">&copy; 2026 Flash-Tix System Architecture.</p>
            </div>

            <!-- Tentang Flash-Tix -->
            <div class="footer-section">
                <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider mb-4">Tentang Flash-Tix</h4>
                <ul class="space-y-2 text-[11px]">
                    <li><a href="#" class="footer-link text-slate-500 hover:text-purple-600 transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="footer-link text-slate-500 hover:text-purple-600 transition-colors">Infrastruktur Cluster</a></li>
                    <li><a href="#" class="footer-link text-slate-500 hover:text-purple-600 transition-colors">Mitra Promotor</a></li>
                </ul>
            </div>

            <!-- Dukungan Sistem -->
            <div class="footer-section">
                <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider mb-4">Dukungan Sistem</h4>
                <ul class="space-y-2 text-[11px]">
                    <li><a href="#" class="footer-link text-slate-500 hover:text-purple-600 transition-colors">Pusat Bantuan FAQ</a></li>
                    <li><a href="#" class="footer-link text-slate-500 hover:text-purple-600 transition-colors">Panduan Skema Kursi</a></li>
                    <li><a href="#" class="footer-link text-slate-500 hover:text-purple-600 transition-colors">Kebijakan Sesi</a></li>
                </ul>
            </div>

            <!-- Metode Pembayaran -->
            <div class="footer-section">
                <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider mb-4">Metode Pembayaran</h4>
                <div class="payment-grid">
                    <div class="payment-item"><div class="payment-icon gopay-icon"><i class="fab fa-google-pay text-xl"></i></div><span class="payment-name">GoPay</span><div class="payment-tooltip">GoPay - Dompet Digital</div></div>
                    <div class="payment-item"><div class="payment-icon qris-icon"><i class="fas fa-qrcode text-xl"></i></div><span class="payment-name">QRIS</span><div class="payment-tooltip">QRIS - Scan & Pay</div></div>
                    <div class="payment-item"><div class="payment-icon bca-icon"><i class="fas fa-university text-xl"></i></div><span class="payment-name">BCA</span><div class="payment-tooltip">Bank BCA - Virtual Account</div></div>
                    <div class="payment-item"><div class="payment-icon mandiri-icon"><i class="fas fa-bank text-xl"></i></div><span class="payment-name">Mandiri</span><div class="payment-tooltip">Bank Mandiri - Virtual Account</div></div>
                    <div class="payment-item"><div class="payment-icon bni-icon"><i class="fas fa-landmark text-xl"></i></div><span class="payment-name">BNI</span><div class="payment-tooltip">Bank BNI - Virtual Account</div></div>
                    <div class="payment-item"><div class="payment-icon bri-icon"><i class="fas fa-piggy-bank text-xl"></i></div><span class="payment-name">BRI</span><div class="payment-tooltip">Bank BRI - Virtual Account</div></div>
                    <div class="payment-item"><div class="payment-icon shopeepay-icon"><i class="fas fa-shop text-xl"></i></div><span class="payment-name">ShopeePay</span><div class="payment-tooltip">ShopeePay - Belanja & Bayar</div></div>
                    <div class="payment-item"><div class="payment-icon dana-icon"><i class="fas fa-wallet text-xl"></i></div><span class="payment-name">DANA</span><div class="payment-tooltip">DANA - Dompet Digital</div></div>
                    <div class="payment-item"><div class="payment-icon ovo-icon"><i class="fas fa-mobile-alt text-xl"></i></div><span class="payment-name">OVO</span><div class="payment-tooltip">OVO - Points & Pay</div></div>
                    <div class="payment-item"><div class="payment-icon linkaja-icon"><i class="fas fa-link text-xl"></i></div><span class="payment-name">LinkAja</span><div class="payment-tooltip">LinkAja - BUMN Digital</div></div>
                </div>
                
                <div class="mt-5 pt-4 border-t border-slate-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[9px] text-slate-400 uppercase tracking-wide">Gerbang Keamanan</span>
                        <div class="flex items-center gap-1.5"><i class="fas fa-shield-alt text-purple-500 text-[10px]"></i><i class="fas fa-lock text-purple-500 text-[10px]"></i><i class="fas fa-key text-purple-500 text-[10px]"></i></div>
                    </div>
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-2 text-center border border-purple-100">
                        <span class="inline-flex items-center gap-1.5 text-purple-700 font-bold text-[10px]"><i class="fas fa-user-shield"></i> MIDTRANS SECURE</span>
                    </div>
                    <p class="text-[8px] text-slate-400 text-center mt-2">Enkripsi 256-bit SSL</p>
                </div>
            </div>

        </div>
    </footer>

</div>
@endsection