@extends('layouts.app')

@section('title', 'Cara Kerja Flash-Tix - Panduan Pemesanan Tiket Konser')

@section('content')
<style>
    /* ============================================ */
    /* PROFESSIONAL & CLEAN STYLES */
    /* ============================================ */
    
    /* Smooth Scroll */
    html {
        scroll-behavior: smooth;
    }
    
    /* Dark Section - Support Center Style */
    .bg-support-dark {
        background: #0f172a;
    }
    
    /* Step Cards */
    .step-card {
        transition: all 0.3s ease;
        border: 1px solid #eef2ff;
    }
    
    .step-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
        border-color: #c7d2fe;
    }
    
    .step-number {
        width: 56px;
        height: 56px;
        background: #7c3aed;
        color: white;
        font-size: 1.35rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        margin: 0 auto 1rem auto;
    }
    
    /* Timeline - Clean Version */
    .timeline {
        position: relative;
        padding: 30px 0;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 1.5px;
        height: 100%;
        background: #e2e8f0;
    }
    
    @media (max-width: 768px) {
        .timeline::before {
            left: 24px;
        }
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 40px;
    }
    
    .timeline-dot {
        position: absolute;
        top: 24px;
        left: 50%;
        transform: translateX(-50%);
        width: 10px;
        height: 10px;
        background: #7c3aed;
        border-radius: 50%;
        z-index: 10;
    }
    
    @media (max-width: 768px) {
        .timeline-dot {
            left: 24px;
        }
    }
    
    .timeline-content {
        width: 45%;
        padding: 20px 24px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
    }
    
    .timeline-item:nth-child(odd) .timeline-content {
        margin-left: auto;
    }
    
    @media (max-width: 768px) {
        .timeline-content {
            width: calc(100% - 60px);
            margin-left: 60px !important;
        }
    }
    
    /* Feature Cards */
    .feature-card {
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
        background: white;
    }
    
    .feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.05);
        border-color: #c7d2fe;
    }
    
    .feature-icon {
        width: 48px;
        height: 48px;
        background: #f5f3ff;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Progress Steps */
    .progress-step {
        transition: all 0.2s ease;
        cursor: pointer;
        font-weight: 500;
    }
    
    .progress-step.active {
        background: #7c3aed;
        color: white;
    }
    
    /* FAQ */
    .faq-item {
        border: 1px solid #f1f5f9;
        border-radius: 14px;
        transition: all 0.2s ease;
        background: white;
    }
    
    .faq-item:hover {
        border-color: #c7d2fe;
    }
    
    .faq-btn {
        width: 100%;
        padding: 16px 20px;
        text-align: left;
        font-weight: 500;
        color: #1e293b;
        background: transparent;
        border: none;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.2s ease;
    }
    
    .faq-btn:hover {
        color: #7c3aed;
    }
    
    .faq-btn i {
        transition: transform 0.2s ease;
        color: #94a3b8;
        font-size: 14px;
    }
    
    .faq-btn.active i {
        transform: rotate(180deg);
        color: #7c3aed;
    }
    
    .faq-answer {
        padding: 0 20px 20px 20px;
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
        display: none;
    }
    
    .faq-answer.show {
        display: block;
    }
    
    /* Scroll Progress */
    .scroll-progress {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: #7c3aed;
        z-index: 10000;
        transition: width 0.2s;
    }
    
    /* Hero Section - Soft Concert Background */
    .hero-support {
        position: relative;
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        min-height: 380px;
        display: flex;
        align-items: center;
    }
    
    .hero-overlay {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 30% 50%, rgba(124, 58, 237, 0.08) 0%, transparent 60%);
    }
    
    /* Subtle Music Element */
    .subtle-music {
        position: absolute;
        bottom: 20px;
        right: 30px;
        opacity: 0.15;
        font-size: 48px;
        pointer-events: none;
    }
    
    /* CTA Section */
    .cta-support {
        background: #f8fafc;
        border: 1px solid #eef2ff;
    }
    
    .btn-support {
        background: #7c3aed;
        color: white;
        padding: 12px 28px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .btn-support:hover {
        background: #6d28d9;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(124, 58, 237, 0.2);
    }
    
    .btn-outline-support {
        border: 1px solid #cbd5e1;
        background: white;
        color: #475569;
        padding: 12px 28px;
        border-radius: 40px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .btn-outline-support:hover {
        border-color: #7c3aed;
        color: #7c3aed;
        background: #faf5ff;
    }
    
    /* Waveform Decoration */
    .waveform {
        display: flex;
        align-items: center;
        gap: 3px;
        margin-top: 12px;
        justify-content: center;
    }
    
    .waveform span {
        width: 3px;
        height: 20px;
        background: #cbd5e1;
        border-radius: 2px;
        animation: wave 1s ease-in-out infinite;
    }
    
    .waveform span:nth-child(1) { height: 12px; animation-delay: 0s; }
    .waveform span:nth-child(2) { height: 24px; animation-delay: 0.1s; }
    .waveform span:nth-child(3) { height: 18px; animation-delay: 0.2s; }
    .waveform span:nth-child(4) { height: 28px; animation-delay: 0.3s; }
    .waveform span:nth-child(5) { height: 14px; animation-delay: 0.4s; }
    
    @keyframes wave {
        0%, 100% { transform: scaleY(1); opacity: 0.5; }
        50% { transform: scaleY(1.5); opacity: 1; }
    }
</style>

<!-- Scroll Progress Bar -->
<div class="scroll-progress" id="scrollProgress"></div>

<!-- ============================================ -->
<!-- HERO SECTION - CLEAN SUPPORT STYLE -->
<!-- ============================================ -->
<div class="hero-support">
    <div class="hero-overlay"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-1.5 mb-5 border border-white/20">
                <span class="text-yellow-300 text-sm">📘</span>
                <span class="text-white text-sm font-medium">Panduan Lengkap</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 tracking-tight">
                Cara Kerja <span class="text-yellow-300">Flash-Tix</span>
            </h1>
            <p class="text-white/80 text-lg max-w-2xl mx-auto">
                Panduan lengkap dari Login / Registrasi hingga Tiket Sampai di Email
            </p>
            <div class="flex flex-wrap gap-2 justify-center mt-5">
                <span class="bg-white/10 backdrop-blur-sm rounded-full px-3 py-1 text-white text-xs">✅ Mudah</span>
                <span class="bg-white/10 backdrop-blur-sm rounded-full px-3 py-1 text-white text-xs">⚡ Cepat</span>
                <span class="bg-white/10 backdrop-blur-sm rounded-full px-3 py-1 text-white text-xs">🛡️ Aman</span>
                <span class="bg-white/10 backdrop-blur-sm rounded-full px-3 py-1 text-white text-xs">⭐ Terpercaya</span>
            </div>
            <!-- Subtle Waveform -->
            <div class="waveform mt-6">
                <span></span><span></span><span></span><span></span><span></span>
            </div>
        </div>
    </div>
    <div class="subtle-music">
        <i class="fas fa-music"></i>
    </div>
</div>

<!-- ============================================ -->
<!-- PROGRESS STEPS -->
<!-- ============================================ -->
<div class="bg-white border-b border-gray-100 sticky top-16 z-20 shadow-sm">
    <div class="container mx-auto px-4 py-3">
        <div class="flex flex-wrap justify-center gap-2">
            <div class="progress-step px-4 py-1.5 rounded-full text-sm font-medium bg-purple-100 text-purple-600 active">1. Login/Register</div>
            <div class="progress-step px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-500">2. Pilih Konser</div>
            <div class="progress-step px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-500">3. Pilih Kursi</div>
            <div class="progress-step px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-500">4. Isi Data</div>
            <div class="progress-step px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-500">5. Pembayaran</div>
            <div class="progress-step px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-500">6. Tiket Dikirim</div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- 4 LANGKAH UTAMA (GRID) -->
<!-- ============================================ -->
<div class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Langkah <span class="text-purple-600">Pemesanan</span>
            </h2>
            <p class="text-gray-500 text-sm max-w-2xl mx-auto">
                Ikuti 4 langkah mudah untuk mendapatkan tiket konser impianmu
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <div class="step-card bg-white rounded-xl p-5 text-center">
                <div class="step-number mx-auto mb-3">1</div>
                <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-music text-purple-500 text-base"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1">Pilih Konser</h3>
                <p class="text-gray-500 text-xs">Cari konser dari artis favoritmu</p>
            </div>
            
            <div class="step-card bg-white rounded-xl p-5 text-center">
                <div class="step-number mx-auto mb-3">2</div>
                <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-chair text-purple-500 text-base"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1">Pilih Kursi</h3>
                <p class="text-gray-500 text-xs">Pilih kategori kursi (VIP, Festival, Tribun)</p>
            </div>
            
            <div class="step-card bg-white rounded-xl p-5 text-center">
                <div class="step-number mx-auto mb-3">3</div>
                <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-edit text-purple-500 text-base"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1">Isi Data</h3>
                <p class="text-gray-500 text-xs">Lengkapi data diri untuk pengiriman tiket</p>
            </div>
            
            <div class="step-card bg-white rounded-xl p-5 text-center">
                <div class="step-number mx-auto mb-3">4</div>
                <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-credit-card text-purple-500 text-base"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1">Bayar & Terima</h3>
                <p class="text-gray-500 text-xs">Bayar dan e-tiket akan dikirim ke email</p>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- TIMELINE DETAIL - LENGKAP 6 LANGKAH -->
<!-- ============================================ -->
<div class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Proses <span class="text-purple-600">Lengkap</span>
            </h2>
            <p class="text-gray-500 text-sm">Dari awal hingga tiket sampai di email Anda</p>
        </div>
        
        <div class="timeline">
            
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="text-purple-600 font-bold text-sm">1</span>
                        </div>
                        <h3 class="font-semibold text-gray-800">Login / Registrasi Akun</h3>
                    </div>
                    <p class="text-gray-500 text-sm mb-3">Langkah pertama, Anda harus memiliki akun Flash-Tix.</p>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500">Data yang diperlukan: Nama Lengkap, Email, Nomor Telepon, Password</p>
                    </div>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="text-purple-600 font-bold text-sm">2</span>
                        </div>
                        <h3 class="font-semibold text-gray-800">Pilih Konser</h3>
                    </div>
                    <p class="text-gray-500 text-sm mb-3">Cari konser dari artis favoritmu di berbagai kota.</p>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500">Fitur: Filter kota, cari artis, urutkan harga</p>
                    </div>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="text-purple-600 font-bold text-sm">3</span>
                        </div>
                        <h3 class="font-semibold text-gray-800">Pilih Kategori Kursi</h3>
                    </div>
                    <p class="text-gray-500 text-sm mb-3">Pilih kategori kursi yang diinginkan (VIP, Festival, Tribun).</p>
                    <div class="bg-yellow-50 rounded-lg p-3 border-l-4 border-yellow-400">
                        <p class="text-xs text-yellow-700">🔒 Locking otomatis 15 menit - kursi tidak bisa dibeli orang lain</p>
                    </div>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="text-purple-600 font-bold text-sm">4</span>
                        </div>
                        <h3 class="font-semibold text-gray-800">Isi Data Pemesanan</h3>
                    </div>
                    <p class="text-gray-500 text-sm mb-3">Lengkapi formulir data diri untuk pengiriman e-tiket.</p>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500">Data: Nama Lengkap, Email, Nomor Telepon</p>
                    </div>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="text-purple-600 font-bold text-sm">5</span>
                        </div>
                        <h3 class="font-semibold text-gray-800">Pilih Metode Pembayaran</h3>
                    </div>
                    <p class="text-gray-500 text-sm mb-3">Pilih metode pembayaran yang tersedia.</p>
                    <div class="bg-red-50 rounded-lg p-3 border-l-4 border-red-400">
                        <p class="text-xs text-red-700">⏰ Batas waktu pembayaran 15 menit</p>
                    </div>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-envelope text-purple-500 text-xs"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800">Tiket Dikirim ke Email</h3>
                    </div>
                    <p class="text-gray-500 text-sm mb-3">E-tiket akan dikirim ke alamat email Anda.</p>
                    <div class="bg-blue-50 rounded-lg p-3">
                        <p class="text-xs text-blue-700">💡 Tips: Cek folder Spam jika email tidak masuk</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- 4 FITUR UTAMA -->
<!-- ============================================ -->
<div class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                4 Fitur <span class="text-purple-600">Utama</span>
            </h2>
            <p class="text-gray-500 text-sm">Fitur canggih untuk pengalaman booking terbaik</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <div class="feature-card bg-white rounded-xl p-5 text-center">
                <div class="feature-icon mx-auto mb-3">
                    <i class="fas fa-ticket-alt text-purple-500 text-lg"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1">Katalog Konser</h3>
                <p class="text-gray-500 text-xs">Lihat daftar konser di berbagai kota dengan filter mudah</p>
            </div>
            
            <div class="feature-card bg-white rounded-xl p-5 text-center">
                <div class="feature-icon mx-auto mb-3">
                    <i class="fas fa-chair text-purple-500 text-lg"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1">Pilih Kursi</h3>
                <p class="text-gray-500 text-xs">Pilih kategori kursi dengan locking otomatis 15 menit</p>
            </div>
            
            <div class="feature-card bg-white rounded-xl p-5 text-center">
                <div class="feature-icon mx-auto mb-3">
                    <i class="fas fa-user-check text-purple-500 text-lg"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1">Isi Data</h3>
                <p class="text-gray-500 text-xs">Formulir lengkap dengan validasi data otomatis</p>
            </div>
            
            <div class="feature-card bg-white rounded-xl p-5 text-center">
                <div class="feature-icon mx-auto mb-3">
                    <i class="fas fa-credit-card text-purple-500 text-lg"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1">Bayar & Terima</h3>
                <p class="text-gray-500 text-xs">10+ metode pembayaran, e-tiket langsung dikirim</p>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- DARK SECTION - INFO PENTING (SUPPORT CENTER STYLE) -->
<!-- ============================================ -->
<div class="bg-support-dark py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-white mb-2">
                Informasi <span class="text-purple-400">Penting</span>
            </h2>
            <p class="text-gray-400 text-sm">Hal-hal yang perlu Anda ketahui sebelum memesan tiket</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-5 text-center border border-white/10">
                <div class="w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-hourglass-half text-red-400 text-sm"></i>
                </div>
                <h3 class="text-white font-semibold mb-1 text-base">Batas Waktu Pembayaran</h3>
                <p class="text-gray-400 text-xs">Anda memiliki waktu <strong class="text-red-400">15 menit</strong> untuk menyelesaikan pembayaran.</p>
            </div>
            
            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-5 text-center border border-white/10">
                <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-envelope text-green-400 text-sm"></i>
                </div>
                <h3 class="text-white font-semibold mb-1 text-base">Pengiriman E-Tiket</h3>
                <p class="text-gray-400 text-xs">E-tiket akan dikirim ke <strong class="text-green-400">alamat email</strong> yang Anda daftarkan.</p>
            </div>
            
            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-5 text-center border border-white/10">
                <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-headset text-purple-400 text-sm"></i>
                </div>
                <h3 class="text-white font-semibold mb-1 text-base">Customer Support 24/7</h3>
                <p class="text-gray-400 text-xs">Tim support siap membantu Anda <strong class="text-purple-400">24 jam sehari</strong>.</p>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- FAQ SECTION -->
<!-- ============================================ -->
<div class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Pertanyaan <span class="text-purple-600">Umum</span>
            </h2>
            <p class="text-gray-500 text-sm">Jawaban atas pertanyaan yang sering diajukan</p>
        </div>
        
        <div class="max-w-2xl mx-auto space-y-3">
            
            <div class="faq-item">
                <button class="faq-btn">
                    <span>Bagaimana cara memesan tiket?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    Ikuti 6 langkah mudah: Login/Register → Pilih Konser → Pilih Kursi → Isi Data → Bayar → Tiket dikirim ke email.
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-btn">
                    <span>Apakah tiket bisa refund?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    Tiket tidak dapat direfund kecuali konser dibatalkan oleh penyelenggara. Hubungi customer support untuk info lebih lanjut.
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-btn">
                    <span>Berapa lama tiket akan dikirim?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    E-tiket langsung dikirim ke email dalam hitungan menit setelah pembayaran berhasil dikonfirmasi.
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-btn">
                    <span>Metode pembayaran apa saja yang tersedia?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    QRIS, Bank Transfer (BCA, Mandiri, BNI, BRI), E-Wallet (GoPay, OVO, Dana, LinkAja), dan Kartu Kredit.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- CTA SECTION - PROFESSIONAL INVITATION -->
<!-- ============================================ -->
<div class="py-16">
    <div class="container mx-auto px-4">
        <div class="cta-support rounded-2xl p-8 text-center max-w-3xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Siap Pesan Tiket Konser?
            </h2>
            <p class="text-gray-500 text-sm mb-6">
                Ikuti langkah-langkah di atas dan dapatkan tiket konser impianmu sekarang!
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('concerts.index') }}" class="btn-support inline-flex items-center gap-2">
                    <i class="fas fa-ticket-alt text-sm"></i>
                    Lihat Daftar Konser
                </a>
                <a href="{{ url('/') }}" class="btn-outline-support inline-flex items-center gap-2">
                    <i class="fas fa-home text-sm"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Scroll Progress Bar
    window.addEventListener('scroll', function() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        const progressBar = document.getElementById('scrollProgress');
        if (progressBar) {
            progressBar.style.width = scrolled + '%';
        }
    });
    
    // Progress step active on scroll
    window.addEventListener('scroll', function() {
        const sections = document.querySelectorAll('.timeline-item');
        const progressSteps = document.querySelectorAll('.progress-step');
        
        sections.forEach((section, index) => {
            const rect = section.getBoundingClientRect();
            if (rect.top < window.innerHeight - 100 && rect.bottom > 100) {
                progressSteps.forEach((step, stepIndex) => {
                    if (stepIndex === index) {
                        step.classList.add('active');
                        step.classList.remove('bg-gray-100', 'text-gray-500');
                    } else if (stepIndex < index) {
                        step.classList.add('bg-purple-100', 'text-purple-600');
                        step.classList.remove('bg-gray-100', 'text-gray-500');
                    }
                });
            }
        });
    });
    
    // FAQ Accordion
    document.querySelectorAll('.faq-btn').forEach(button => {
        button.addEventListener('click', () => {
            const answer = button.nextElementSibling;
            const isActive = answer.classList.contains('show');
            
            document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('show'));
            document.querySelectorAll('.faq-btn').forEach(b => b.classList.remove('active'));
            
            if (!isActive) {
                answer.classList.add('show');
                button.classList.add('active');
            }
        });
    });
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>
@endsection