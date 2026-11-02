@extends('layouts.app')

@section('title', 'Flash-Tix - Platform Tiket Konser No.1 di Indonesia | Pengalaman War Tiket Terbaik')

@section('content')
<style>
    /* ============================================ */
    /* GLOBAL ANIMATIONS & EFFECTS */
    /* ============================================ */
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-30px) rotate(2deg); }
    }
    @keyframes float-reverse {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(30px) rotate(-2deg); }
    }
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.4); }
        50% { box-shadow: 0 0 0 30px rgba(139, 92, 246, 0); }
    }
    @keyframes pulse-glow-2 {
        0%, 100% { box-shadow: 0 0 0 0 rgba(236, 72, 153, 0.4); }
        50% { box-shadow: 0 0 0 30px rgba(236, 72, 153, 0); }
    }
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-80px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(80px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(50px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes zoomIn {
        from { opacity: 0; transform: scale(0.8); }
        to { opacity: 1; transform: scale(1); }
    }
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }
    @keyframes typing {
        from { width: 0; }
        to { width: 100%; }
    }
    @keyframes blink-caret {
        from, to { border-color: transparent; }
        50% { border-color: white; }
    }
    
    /* Animation Classes */
    .animate-float { animation: float 4s ease-in-out infinite; }
    .animate-float-reverse { animation: float-reverse 5s ease-in-out infinite; }
    .animate-pulse-glow { animation: pulse-glow 2s infinite; }
    .animate-pulse-glow-2 { animation: pulse-glow-2 2.5s infinite; }
    .animate-slide-left { animation: slideInLeft 0.8s ease-out forwards; }
    .animate-slide-right { animation: slideInRight 0.8s ease-out forwards; }
    .animate-slide-up { animation: slideInUp 0.6s ease-out forwards; opacity: 0; }
    .animate-zoom { animation: zoomIn 0.5s ease-out forwards; }
    .animate-rotate { animation: rotate 20s linear infinite; }
    .shimmer {
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        background-size: 1000px 100%;
        animation: shimmer 2s infinite;
    }
    
    /* Delay Classes */
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.3s; }
    .delay-3 { animation-delay: 0.5s; }
    .delay-4 { animation-delay: 0.7s; }
    .delay-5 { animation-delay: 0.9s; }
    .delay-6 { animation-delay: 1.1s; }
    
    /* Text Gradient */
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
        background-size: 300% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: gradientShift 3s ease infinite;
    }
    
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* Hero Background with Particles Effect */
    .hero-gradient {
        background: radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 50%, rgba(0,0,0,0) 100%),
                    linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        position: relative;
        overflow: hidden;
    }
    
    .hero-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path fill="rgba(255,255,255,0.03)" d="M100 0L120 30H80L100 0zM100 200L80 170H120L100 200zM0 100L30 80V120L0 100zM200 100L170 120V80L200 100z"/><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="150" cy="30" r="1.5" fill="rgba(255,255,255,0.08)"/><circle cx="180" cy="80" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="20" cy="150" r="1.5" fill="rgba(255,255,255,0.08)"/><circle cx="100" cy="100" r="3" fill="rgba(255,255,255,0.05)"/></svg>');
        background-repeat: repeat;
        opacity: 0.5;
        pointer-events: none;
    }
    
    /* Card Styles */
    .premium-card {
        background: rgba(255,255,255,0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .premium-card:hover {
        transform: translateY(-10px) scale(1.02);
        border-color: rgba(139, 92, 246, 0.5);
        box-shadow: 0 25px 40px -15px rgba(0,0,0,0.3);
    }
    
    /* Concert Card */
    .concert-card-premium {
        background: linear-gradient(135deg, #1e1b4b 0%, #2e1065 100%);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
    }
    
    .concert-card-premium::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.5s;
        pointer-events: none;
    }
    
    .concert-card-premium:hover::before {
        opacity: 1;
    }
    
    .concert-card-premium:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 30px 50px -20px rgba(0,0,0,0.5);
    }
    
    /* Glow Button */
    .btn-glow {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .btn-glow::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .btn-glow:hover::before {
        width: 300px;
        height: 300px;
    }
    
    /* Typing Effect */
    .typing-text {
        overflow: hidden;
        white-space: nowrap;
        border-right: 3px solid;
        animation: typing 3.5s steps(40, end), blink-caret 0.75s step-end infinite;
        width: 0;
    }
    
    /* Scroll Progress Bar */
    .scroll-progress {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
        z-index: 10000;
        transition: width 0.3s;
    }
    
    /* Cursor Custom */
    .custom-cursor {
        width: 20px;
        height: 20px;
        border: 2px solid #667eea;
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 9999;
        transition: transform 0.1s;
    }
    
    /* Particle Background */
    .particle {
        position: absolute;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        pointer-events: none;
        animation: floatParticle 10s infinite linear;
    }
    
    @keyframes floatParticle {
        from { transform: translateY(100vh) rotate(0deg); opacity: 0; }
        to { transform: translateY(-100vh) rotate(360deg); opacity: 1; }
    }
    
    /* Marquee Text */
    .marquee {
        white-space: nowrap;
        overflow: hidden;
        display: inline-block;
        animation: marquee 20s linear infinite;
    }
    
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    
    /* Glitch Effect */
    .glitch {
        position: relative;
        animation: glitch 3s infinite;
    }
    
    @keyframes glitch {
        0%, 100% { transform: skew(0deg, 0deg); }
        95% { transform: skew(0deg, 0deg); }
        96% { transform: skew(5deg, 2deg); }
        97% { transform: skew(-3deg, -1deg); }
        98% { transform: skew(2deg, 1deg); }
    }
    
    /* Neon Border */
    .neon-border {
        border: 1px solid rgba(139,92,246,0.3);
        box-shadow: 0 0 10px rgba(139,92,246,0.2), inset 0 0 10px rgba(139,92,246,0.1);
        transition: all 0.3s;
    }
    
    .neon-border:hover {
        border-color: rgba(139,92,246,0.8);
        box-shadow: 0 0 20px rgba(139,92,246,0.5), inset 0 0 20px rgba(139,92,246,0.2);
    }
    
    /* Counter Animation */
    .counter-value {
        transition: all 0.5s ease-out;
    }
</style>

<!-- Scroll Progress Bar -->
<div class="scroll-progress" id="scrollProgress"></div>

<!-- Hero Section -->
<div class="hero-gradient min-h-screen flex items-center relative overflow-hidden" id="home">
    
    <!-- Floating Particles -->
    @for($i = 0; $i < 50; $i++)
    <div class="particle" style="left: {{ rand(0, 100) }}%; width: {{ rand(2, 8) }}px; height: {{ rand(2, 8) }}px; animation-delay: {{ rand(0, 10) }}s; animation-duration: {{ rand(8, 20) }}s;"></div>
    @endfor
    
    <div class="container mx-auto px-4 relative z-10 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <!-- Left Content -->
            <div>
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-5 py-2.5 mb-8 animate-slide-up border border-white/20">
                    <span class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></span>
                    <span class="text-white text-sm font-medium">✨ 1M+ Pengguna Percaya | #1 Tiket Konser di Indonesia</span>
                </div>
                
                <!-- Main Heading with Glitch -->
                <h1 class="text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-bold text-white leading-tight mb-8 animate-slide-left">
                    Dapatkan Tiket 
                    <span class="gradient-text glitch">Konser</span><br>
                    Impianmu 
                    <span class="inline-block animate-float">
                        <i class="fas fa-ticket-alt text-purple-400"></i>
                    </span>
                </h1>
                
                <!-- Typing Subtitle -->
                <div class="mb-6 animate-slide-left delay-1">
                    <p class="text-gray-300 text-xl flex items-center gap-2 flex-wrap">
                        <span class="text-purple-400">✨</span>
                        <span class="typing-text overflow-visible whitespace-normal border-r-0">Pengalaman War Tiket Terbaik di Indonesia!</span>
                    </p>
                </div>
                
                <!-- Description -->
                <p class="text-gray-300 text-lg mb-10 animate-slide-left delay-2 leading-relaxed max-w-xl">
                    Rasakan sensasi membeli tiket konser dengan kecepatan kilat. 
                    <span class="text-purple-400 font-semibold">Sistem terdistribusi</span>, 
                    <span class="text-pink-400 font-semibold">cadangan otomatis</span>, dan 
                    <span class="text-green-400 font-semibold">100% anti gagal</span>.
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-5 mb-10 animate-slide-left delay-3">
                    <a href="{{ route('concerts.index') }}" 
                       class="btn-glow group bg-gradient-to-r from-purple-600 to-pink-600 text-white px-10 py-5 rounded-2xl text-lg font-bold shadow-2xl hover:shadow-purple-500/25 transition-all duration-300 inline-flex items-center justify-center gap-3 relative overflow-hidden">
                        <i class="fas fa-ticket-alt text-xl group-hover:rotate-12 transition"></i>
                        <span>Pesan Tiket Sekarang</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-2 transition"></i>
                        <span class="absolute inset-0 shimmer opacity-0 group-hover:opacity-100"></span>
                    </a>
                    <a href="#how-it-works" 
                       class="btn-glow bg-white/10 backdrop-blur-sm border border-white/30 text-white px-10 py-5 rounded-2xl text-lg font-semibold hover:bg-white/20 transition-all duration-300 inline-flex items-center justify-center gap-3">
                        <i class="fas fa-play-circle"></i>
                        <span>Lihat Demo</span>
                    </a>
                </div>
                
                <!-- Trust Section -->
                <div class="flex flex-wrap items-center gap-8 animate-slide-left delay-4">
                    <!-- Avatars -->
                    <div class="flex -space-x-3">
                        <img src="https://randomuser.me/api/portraits/women/1.jpg" class="w-12 h-12 rounded-full border-2 border-white hover:z-10 hover:scale-110 transition">
                        <img src="https://randomuser.me/api/portraits/men/2.jpg" class="w-12 h-12 rounded-full border-2 border-white hover:z-10 hover:scale-110 transition">
                        <img src="https://randomuser.me/api/portraits/women/3.jpg" class="w-12 h-12 rounded-full border-2 border-white hover:z-10 hover:scale-110 transition">
                        <img src="https://randomuser.me/api/portraits/men/4.jpg" class="w-12 h-12 rounded-full border-2 border-white hover:z-10 hover:scale-110 transition">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-purple-600 to-pink-600 flex items-center justify-center text-white text-xs font-bold border-2 border-white">1M+</div>
                    </div>
                    
                    <!-- Rating -->
                    <div>
                        <div class="flex text-yellow-400 gap-1">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <span class="text-white ml-2 text-sm">4.9</span>
                        </div>
                        <p class="text-gray-400 text-sm">Dari 50.000+ ulasan positif</p>
                    </div>
                    
                    <!-- Security Badge -->
                    <div class="flex items-center gap-2 bg-green-500/20 px-3 py-1.5 rounded-full">
                        <i class="fas fa-shield-alt text-green-400 text-sm"></i>
                        <span class="text-green-400 text-xs font-semibold">100% AMAN</span>
                    </div>
                </div>
            </div>
            
            <!-- Right Content - 3D Card -->
            <div class="relative animate-slide-right">
                <!-- Main Image with 3D effect -->
                <div class="relative group perspective-1000">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl blur-3xl opacity-40 group-hover:opacity-60 transition duration-700"></div>
                    <div class="relative transform transition duration-700 group-hover:rotate-y-6 group-hover:scale-105">
                        <img src="https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=600&h=500&fit=crop" 
                             alt="Concert Experience" 
                             class="relative rounded-3xl shadow-2xl w-full h-auto border border-white/20">
                    </div>
                    
                    <!-- Floating Cards -->
                    <div class="absolute -top-10 -left-10 bg-gradient-to-r from-gray-900 to-purple-900 rounded-2xl p-4 shadow-2xl animate-float backdrop-blur-sm border border-purple-500/30">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-clock text-purple-400 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-400 text-xs">Proses Booking</p>
                                <p class="text-white font-bold text-lg">Hanya 15 Menit</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-10 -right-10 bg-gradient-to-r from-gray-900 to-pink-900 rounded-2xl p-4 shadow-2xl animate-float-reverse backdrop-blur-sm border border-pink-500/30">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-pink-500/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-shield-alt text-pink-400 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-400 text-xs">Keamanan</p>
                                <p class="text-white font-bold text-lg">Anti Double Booking</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute top-1/2 -right-5 bg-gradient-to-r from-green-900 to-emerald-900 rounded-2xl p-3 shadow-xl animate-pulse-glow backdrop-blur-sm border border-green-500/30 hidden lg:block">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-400"></i>
                            <span class="text-white text-sm font-semibold">Tiket Terjamin!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce cursor-pointer z-20">
        <a href="#stats" class="text-white/60 hover:text-white transition">
            <div class="w-8 h-12 border-2 border-white/30 rounded-full flex justify-center">
                <div class="w-1.5 h-3 bg-white/50 rounded-full mt-2 animate-pulse"></div>
            </div>
        </a>
    </div>
</div>

<!-- Marquee Breaking News -->
<div class="bg-gradient-to-r from-purple-600 via-pink-600 to-purple-600 py-3 overflow-hidden">
    <div class="marquee whitespace-nowrap">
        <span class="text-white font-medium mx-8">🎉 HOT SALE! Tiket Tulus Jakarta habis dalam 2 menit! 🎉</span>
        <span class="text-white font-medium mx-8">🔥 Sheila On 7 Surabaya trending #1! 🔥</span>
        <span class="text-white font-medium mx-8">⭐ Flash-Tix: Platform Tiket Konser Terbaik 2024 ⭐</span>
        <span class="text-white font-medium mx-8">🎫 500.000+ Tiket Terjual! 🎫</span>
        <span class="text-white font-medium mx-8">✨ Dapatkan diskon 20% untuk pembelian pertama! ✨</span>
    </div>
</div>

<!-- STATISTICS SECTION with Counters -->
<div id="stats" class="bg-gradient-to-br from-gray-900 to-gray-800 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 animate-slide-up">
            <span class="text-purple-400 text-sm font-semibold uppercase tracking-wider">Statistik Kami</span>
            <h2 class="text-4xl md:text-5xl font-bold text-white mt-3">
                Flash-Tix dalam <span class="gradient-text">Angka</span>
            </h2>
            <p class="text-gray-400 mt-3 max-w-2xl mx-auto">Pertumbuhan luar biasa dalam memberikan pengalaman terbaik</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="premium-card rounded-2xl p-8 text-center group hover:scale-105 transition-all duration-500">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:rotate-12 transition">
                    <i class="fas fa-ticket-alt text-purple-400 text-3xl"></i>
                </div>
                <div class="text-4xl md:text-5xl font-bold text-white mb-2 counter" data-target="500000">0</div>
                <p class="text-gray-400 font-medium">Tiket Terjual</p>
                <div class="w-12 h-1 bg-purple-500 mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="premium-card rounded-2xl p-8 text-center group hover:scale-105 transition-all duration-500">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:rotate-12 transition">
                    <i class="fas fa-microphone-alt text-purple-400 text-3xl"></i>
                </div>
                <div class="text-4xl md:text-5xl font-bold text-white mb-2 counter" data-target="150">0</div>
                <p class="text-gray-400 font-medium">Artis Ternama</p>
                <div class="w-12 h-1 bg-purple-500 mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="premium-card rounded-2xl p-8 text-center group hover:scale-105 transition-all duration-500">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:rotate-12 transition">
                    <i class="fas fa-city text-purple-400 text-3xl"></i>
                </div>
                <div class="text-4xl md:text-5xl font-bold text-white mb-2 counter" data-target="35">0</div>
                <p class="text-gray-400 font-medium">Kota di Indonesia</p>
                <div class="w-12 h-1 bg-purple-500 mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="premium-card rounded-2xl p-8 text-center group hover:scale-105 transition-all duration-500">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:rotate-12 transition">
                    <i class="fas fa-smile text-purple-400 text-3xl"></i>
                </div>
                <div class="text-4xl md:text-5xl font-bold text-white mb-2 counter" data-target="99">0</div>
                <p class="text-gray-400 font-medium">Kepuasan Pelanggan</p>
                <div class="w-12 h-1 bg-purple-500 mx-auto mt-4 rounded-full"></div>
            </div>
        </div>
    </div>
</div>

<!-- UPCOMING CONCERTS PREMIUM -->
<div class="py-24 bg-gradient-to-b from-gray-900 to-black">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 animate-slide-up">
            <span class="text-purple-400 text-sm font-semibold uppercase tracking-wider border-b border-purple-500 pb-2 inline-block">Jangan Lewatkan</span>
            <h2 class="text-4xl md:text-6xl font-bold text-white mt-5">
                Konser <span class="gradient-text">Mendatang</span>
            </h2>
            <p class="text-gray-400 mt-4 max-w-2xl mx-auto text-lg">
                Saksikan penampilan spektakuler dari artis favoritmu
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Concert Card 1 - Tulus -->
            <div class="concert-card-premium rounded-2xl overflow-hidden group">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=500&h=350&fit=crop" 
                         alt="Tulus Concert" 
                         class="w-full h-64 object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    
                    <!-- Badges -->
                    <div class="absolute top-4 left-4 flex gap-2">
                        <span class="bg-red-500 text-white px-3 py-1.5 rounded-full text-xs font-bold flex items-center gap-1">
                            <i class="fas fa-fire text-xs"></i> HOT
                        </span>
                        <span class="bg-purple-500 text-white px-3 py-1.5 rounded-full text-xs font-bold flex items-center gap-1">
                            <i class="fas fa-tag"></i> 20% OFF
                        </span>
                    </div>
                    
                    <!-- Timer -->
                    <div class="absolute bottom-4 right-4 bg-black/60 backdrop-blur-sm rounded-lg px-3 py-1.5">
                        <div class="flex items-center gap-1 text-white text-xs">
                            <i class="fas fa-hourglass-half"></i>
                            <span>H-7 Hari</span>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-1">Tulus</h3>
                            <p class="text-purple-400 text-sm">Tur Manusia - Jakarta</p>
                        </div>
                        <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs font-semibold">Tersedia</span>
                    </div>
                    
                    <div class="space-y-2 mb-5">
                        <div class="flex items-center gap-3 text-gray-400 text-sm">
                            <i class="fas fa-map-marker-alt text-purple-500 w-5"></i>
                            <span>Istora Senayan, Jakarta</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-400 text-sm">
                            <i class="fas fa-calendar-alt text-purple-500 w-5"></i>
                            <span>Sabtu, 15 Desember 2024</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-400 text-sm">
                            <i class="fas fa-clock text-purple-500 w-5"></i>
                            <span>19:00 WIB - Selesai</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-700 pt-4 flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-xs line-through">Rp 500.000</p>
                            <p class="text-white font-bold text-2xl">Rp 350.000</p>
                            <p class="text-gray-500 text-xs">/tiket</p>
                        </div>
                        <a href="#" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg transition flex items-center gap-2 font-semibold group-hover:scale-105">
                            Pesan <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Concert Card 2 - Sheila On 7 -->
            <div class="concert-card-premium rounded-2xl overflow-hidden group">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=500&h=350&fit=crop" 
                         alt="Sheila On 7 Concert" 
                         class="w-full h-64 object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    
                    <div class="absolute top-4 left-4">
                        <span class="bg-orange-500 text-white px-3 py-1.5 rounded-full text-xs font-bold flex items-center gap-1">
                            <i class="fas fa-chart-line"></i> TRENDING #1
                        </span>
                    </div>
                    
                    <div class="absolute bottom-4 right-4 bg-black/60 backdrop-blur-sm rounded-lg px-3 py-1.5">
                        <div class="flex items-center gap-1 text-white text-xs">
                            <i class="fas fa-hourglass-half"></i>
                            <span>H-5 Hari</span>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-1">Sheila On 7</h3>
                            <p class="text-purple-400 text-sm">Tunggu Aku di Surabaya</p>
                        </div>
                        <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-xs font-semibold">Hampir Habis</span>
                    </div>
                    
                    <div class="space-y-2 mb-5">
                        <div class="flex items-center gap-3 text-gray-400 text-sm">
                            <i class="fas fa-map-marker-alt text-purple-500 w-5"></i>
                            <span>Tennis Indoor, Surabaya</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-400 text-sm">
                            <i class="fas fa-calendar-alt text-purple-500 w-5"></i>
                            <span>Jumat, 20 Desember 2024</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-400 text-sm">
                            <i class="fas fa-clock text-purple-500 w-5"></i>
                            <span>19:30 WIB - Selesai</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-700 pt-4 flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-xs line-through">Rp 400.000</p>
                            <p class="text-white font-bold text-2xl">Rp 250.000</p>
                            <p class="text-gray-500 text-xs">/tiket</p>
                        </div>
                        <a href="#" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg transition flex items-center gap-2 font-semibold">
                            Pesan <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Concert Card 3 - Hindia -->
            <div class="concert-card-premium rounded-2xl overflow-hidden group">
                <div class="relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=500&h=350&fit=crop" 
                         alt="Hindia Concert" 
                         class="w-full h-64 object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    
                    <div class="absolute top-4 left-4">
                        <span class="bg-purple-500 text-white px-3 py-1.5 rounded-full text-xs font-bold flex items-center gap-1">
                            <i class="fas fa-gem"></i> PREMIUM
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-1">Hindia</h3>
                            <p class="text-purple-400 text-sm">Menari Dengan Bayangan</p>
                        </div>
                        <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs font-semibold">Tersedia</span>
                    </div>
                    
                    <div class="space-y-2 mb-5">
                        <div class="flex items-center gap-3 text-gray-400 text-sm">
                            <i class="fas fa-map-marker-alt text-purple-500 w-5"></i>
                            <span>Gedung Sate, Bandung</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-400 text-sm">
                            <i class="fas fa-calendar-alt text-purple-500 w-5"></i>
                            <span>Rabu, 25 Desember 2024</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-400 text-sm">
                            <i class="fas fa-clock text-purple-500 w-5"></i>
                            <span>19:00 WIB - Selesai</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-700 pt-4 flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-xs">Harga Normal</p>
                            <p class="text-white font-bold text-2xl">Rp 400.000</p>
                            <p class="text-gray-500 text-xs">/tiket</p>
                        </div>
                        <a href="#" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg transition flex items-center gap-2 font-semibold">
                            Pesan <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('concerts.index') }}" 
               class="inline-flex items-center gap-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-10 py-4 rounded-2xl text-lg font-bold hover:shadow-2xl transition-all duration-300 group">
                <span>Lihat Semua Konser</span>
                <i class="fas fa-arrow-right group-hover:translate-x-2 transition"></i>
            </a>
        </div>
    </div>
</div>

<!-- FEATURES SECTION - ULTRA PREMIUM -->
<div class="py-24 bg-black relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-20 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-pink-500 rounded-full blur-3xl"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16 animate-slide-up">
            <span class="text-purple-400 text-sm font-semibold uppercase tracking-wider">Keunggulan Kami</span>
            <h2 class="text-4xl md:text-6xl font-bold text-white mt-4">
                Kenapa Harus <span class="gradient-text">Flash-Tix</span>?
            </h2>
            <p class="text-gray-400 mt-4 max-w-2xl mx-auto text-lg">
                Kami menghadirkan teknologi tercanggih untuk pengalaman terbaikmu
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="premium-card rounded-2xl p-8 group">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300">
                    <i class="fas fa-bolt text-purple-400 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">Super Cepat ⚡</h3>
                <p class="text-gray-400 leading-relaxed">Proses booking hanya hitungan detik dengan sistem terdistribusi. War tiket? Siap!</p>
                <div class="mt-4 w-16 h-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full group-hover:w-24 transition-all duration-300"></div>
            </div>
            
            <!-- Feature 2 -->
            <div class="premium-card rounded-2xl p-8 group">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300">
                    <i class="fas fa-shield-alt text-purple-400 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">Anti Double Booking 🛡️</h3>
                <p class="text-gray-400 leading-relaxed">Sistem locking canggih mencegah pembelian tiket yang sama oleh dua orang berbeda.</p>
                <div class="mt-4 w-16 h-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full group-hover:w-24 transition-all duration-300"></div>
            </div>
            
            <!-- Feature 3 -->
            <div class="premium-card rounded-2xl p-8 group">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300">
                    <i class="fas fa-database text-purple-400 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">Cadangan Otomatis 💾</h3>
                <p class="text-gray-400 leading-relaxed">Database cadangan siap mengganti jika server utama bermasalah. Transaksi tetap lancar!</p>
                <div class="mt-4 w-16 h-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full group-hover:w-24 transition-all duration-300"></div>
            </div>
            
            <!-- Feature 4 -->
            <div class="premium-card rounded-2xl p-8 group">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300">
                    <i class="fas fa-credit-card text-purple-400 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">Berbagai Metode Bayar 💳</h3>
                <p class="text-gray-400 leading-relaxed">Support QRIS, Bank Transfer, E-Wallet, Kartu Kredit, dan masih banyak lagi!</p>
                <div class="mt-4 w-16 h-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full group-hover:w-24 transition-all duration-300"></div>
            </div>
            
            <!-- Feature 5 -->
            <div class="premium-card rounded-2xl p-8 group">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300">
                    <i class="fas fa-headset text-purple-400 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">Customer Support 24/7 📞</h3>
                <p class="text-gray-400 leading-relaxed">Tim support siap membantu Anda 24 jam sehari, 7 hari seminggu melalui live chat.</p>
                <div class="mt-4 w-16 h-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full group-hover:w-24 transition-all duration-300"></div>
            </div>
            
            <!-- Feature 6 -->
            <div class="premium-card rounded-2xl p-8 group">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300">
                    <i class="fas fa-gem text-purple-400 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">Garansi 100% 💎</h3>
                <p class="text-gray-400 leading-relaxed">Uang kembali jika tiket tidak terbit. Kami jamin keamanan transaksi Anda!</p>
                <div class="mt-4 w-16 h-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full group-hover:w-24 transition-all duration-300"></div>
            </div>
        </div>
    </div>
</div>

<!-- TESTIMONIALS SECTION with Carousel Effect -->
<div class="py-24 bg-gradient-to-br from-gray-900 to-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 animate-slide-up">
            <span class="text-purple-400 text-sm font-semibold uppercase tracking-wider">Testimonial</span>
            <h2 class="text-4xl md:text-6xl font-bold text-white mt-3">
                Apa Kata <span class="gradient-text">Mereka</span>
            </h2>
            <p class="text-gray-400 mt-3">Lebih dari 500.000 pelanggan percaya pada Flash-Tix</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="premium-card rounded-2xl p-8 transition-all duration-500 hover:translate-y-[-8px]">
                <div class="flex text-yellow-400 mb-5 text-lg">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-300 mb-6 text-lg leading-relaxed">"Pengalaman beli tiket Tulus sangat lancar! Tidak ada error, proses cepat, recommended banget!"</p>
                <div class="flex items-center gap-4">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-14 h-14 rounded-full object-cover border-2 border-purple-500">
                    <div>
                        <p class="text-white font-bold text-lg">Budi Santoso</p>
                        <p class="text-purple-400 text-sm">Pembeli Tiket Tulus</p>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="premium-card rounded-2xl p-8 transition-all duration-500 hover:translate-y-[-8px]">
                <div class="flex text-yellow-400 mb-5 text-lg">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-300 mb-6 text-lg leading-relaxed">"Sistem anti-rusaknya bagus banget! Pas war tiket Sheila On 7, aplikasi tetap stabil."</p>
                <div class="flex items-center gap-4">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" class="w-14 h-14 rounded-full object-cover border-2 border-purple-500">
                    <div>
                        <p class="text-white font-bold text-lg">Siti Aisyah</p>
                        <p class="text-purple-400 text-sm">Pembeli Tiket Sheila On 7</p>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="premium-card rounded-2xl p-8 transition-all duration-500 hover:translate-y-[-8px]">
                <div class="flex text-yellow-400 mb-5 text-lg">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-300 mb-6 text-lg leading-relaxed">"Customer support responsif banget! Bantu saya yang salah pilih kursi dengan cepat."</p>
                <div class="flex items-center gap-4">
                    <img src="https://randomuser.me/api/portraits/men/45.jpg" class="w-14 h-14 rounded-full object-cover border-2 border-purple-500">
                    <div>
                        <p class="text-white font-bold text-lg">Andi Wijaya</p>
                        <p class="text-purple-400 text-sm">Pembeli Tiket Hindia</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA SECTION - MEGA -->
<div class="relative py-32 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-purple-600 via-pink-600 to-purple-600"></div>
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=1920&h=600&fit=crop')] bg-cover bg-center opacity-20"></div>
    
    <!-- Floating Elements -->
    <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-2xl animate-float"></div>
    <div class="absolute bottom-20 right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl animate-float-reverse"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-5 py-2 mb-6">
                <i class="fas fa-ticket-alt text-white text-sm"></i>
                <span class="text-white text-sm font-medium">Promo Terbatas!</span>
            </div>
            <h2 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                Siap untuk Pengalaman <span class="text-yellow-300">Konser Terbaik</span>?
            </h2>
            <p class="text-white/90 text-xl mb-10 max-w-2xl mx-auto">
                Jangan lewatkan momen berharga bersama artis favoritmu. Tiket terbatas, pesan sekarang!
            </p>
            
            <div class="flex flex-col sm:flex-row gap-5 justify-center">
                <a href="{{ route('concerts.index') }}" 
                   class="btn-glow bg-white text-purple-600 px-10 py-5 rounded-2xl text-xl font-bold hover:shadow-2xl transition-all duration-300 transform hover:scale-105 inline-flex items-center gap-3">
                    <i class="fas fa-ticket-alt text-2xl"></i>
                    <span>Pesan Tiket Sekarang</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="#how-it-works" 
                   class="bg-white/20 backdrop-blur-sm border-2 border-white text-white px-10 py-5 rounded-2xl text-xl font-semibold hover:bg-white/30 transition-all duration-300 inline-flex items-center gap-3">
                    <i class="fas fa-info-circle"></i>
                    <span>Pelajari Lebih Lanjut</span>
                </a>
            </div>
            
            <!-- Timer -->
            <div class="mt-12 inline-flex items-center gap-6 bg-black/30 backdrop-blur-sm rounded-2xl px-8 py-4">
                <div class="text-center">
                    <div class="text-3xl font-bold text-white" id="days">00</div>
                    <div class="text-white/70 text-xs">Hari</div>
                </div>
                <div class="text-3xl font-bold text-white">:</div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white" id="hours">00</div>
                    <div class="text-white/70 text-xs">Jam</div>
                </div>
                <div class="text-3xl font-bold text-white">:</div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white" id="minutes">00</div>
                    <div class="text-white/70 text-xs">Menit</div>
                </div>
                <div class="text-3xl font-bold text-white">:</div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white" id="seconds">00</div>
                    <div class="text-white/70 text-xs">Detik</div>
                </div>
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
        document.getElementById('scrollProgress').style.width = scrolled + '%';
    });
    
    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    const speed = 200;
    
    const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute('data-target'));
        let count = 0;
        const updateCount = () => {
            const increment = target / speed;
            if (count < target) {
                count += increment;
                counter.innerText = Math.ceil(count);
                setTimeout(updateCount, 20);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    };
    
    // Intersection Observer for counters
    const observerOptions = { threshold: 0.5 };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    counters.forEach(counter => observer.observe(counter));
    
    // Countdown Timer
    function startCountdown() {
        const targetDate = new Date('December 15, 2024 19:00:00').getTime();
        
        setInterval(function() {
            const now = new Date().getTime();
            const distance = targetDate - now;
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById('days').innerHTML = days.toString().padStart(2, '0');
            document.getElementById('hours').innerHTML = hours.toString().padStart(2, '0');
            document.getElementById('minutes').innerHTML = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').innerHTML = seconds.toString().padStart(2, '0');
        }, 1000);
    }
    
    startCountdown();
    
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
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });
</script>
@endsection