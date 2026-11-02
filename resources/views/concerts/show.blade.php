@extends('layouts.app')

@section('title', ($concert->name ?? $concert->title) . ' - Flash-Tix')

@section('content')
<style>
    /* ============================================ */
    /* LIGHT MODE THEME - MODERN & FRESH */
    /* TANPA OVERLAY PUTIH PADA GAMBAR */
    /* ============================================ */
    :root {
        --bg-primary: #f8fafc;
        --bg-card: #ffffff;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
        --neon-purple: #7c3aed;
        --neon-pink: #ec4899;
    }
    
    body {
        background-color: var(--bg-primary);
    }
    
    .hero-concert {
        position: relative;
        min-height: 550px;
        background-size: cover;
        background-position: center;
    }
    
    .hero-overlay-dark {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.2) 50%, rgba(0,0,0,0.35) 100%);
    }
    
    .ticket-category {
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
        background: white;
        border-color: var(--border-color);
        border-radius: 16px;
    }
    
    .ticket-category:hover {
        border-color: var(--neon-purple);
        transform: translateY(-4px);
        box-shadow: 0 0 15px rgba(124,58,237,0.2);
    }
    
    .ticket-category.selected {
        border-color: var(--neon-purple);
        background: linear-gradient(135deg, rgba(124,58,237,0.08) 0%, rgba(236,72,153,0.04) 100%);
        box-shadow: 0 0 20px rgba(124,58,237,0.15);
    }
    
    .info-card {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 20px;
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        border-color: var(--neon-purple);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #7c3aed, #db2777);
        transition: all 0.3s ease;
        color: white;
        border-radius: 14px;
    }
    
    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(124,58,237,0.3);
    }
    
    .btn-guest {
        background: linear-gradient(135deg, #94a3b8, #64748b);
        transition: all 0.3s ease;
        color: white;
        border-radius: 14px;
        cursor: pointer;
    }
    
    .btn-guest:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #7c3aed, #db2777);
        box-shadow: 0 10px 20px rgba(124,58,237,0.3);
    }
    
    .btn-wishlist {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        transition: all 0.3s ease;
        color: #f43f5e;
        border-radius: 14px;
        border: 1px solid #334155;
    }
    
    .btn-wishlist:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #f43f5e, #e11d48);
        color: white;
        box-shadow: 0 10px 20px rgba(244,63,94,0.3);
    }
    
    .btn-wishlist:hover i {
        color: white;
    }
    
    .text-gradient {
        background: linear-gradient(135deg, #7c3aed, #ec4899);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .countdown-wrapper {
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(8px);
        border-radius: 20px;
        padding: 15px 25px;
        border: 1px solid rgba(255,255,255,0.2);
    }
    
    .countdown-number {
        font-size: 32px;
        font-weight: 800;
        font-family: monospace;
        background: linear-gradient(135deg, #f43f5e, #ec4899);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .map-container {
        overflow: hidden;
        border-radius: 16px;
        height: 200px;
    }
    
    .map-container iframe {
        width: 100%;
        height: 100%;
        border: 0;
    }
    
    .badge-available { background: linear-gradient(135deg, #10b981, #059669); color: white; }
    .badge-limited { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; animation: pulse 1s infinite; }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    
    .stage-preview-full {
        background: #f1f5f9;
        border-radius: 24px;
        padding: 25px 20px;
        overflow-x: auto;
        border: 1px solid var(--border-color);
    }
    
    .preview-seat {
        width: 30px;
        height: 30px;
        border-radius: 6px 6px 10px 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 8px;
        font-weight: bold;
        transition: all 0.2s ease;
    }
    
    .preview-seat:hover {
        transform: scale(1.05);
        filter: brightness(1.05);
    }
    
    .preview-seat.vip { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #78350f; }
    .preview-seat.festival { background: linear-gradient(135deg, #60a5fa, #3b82f6); color: white; }
    .preview-seat.tribun { background: linear-gradient(135deg, #34d399, #10b981); color: white; }
    
    .category-vip { background: linear-gradient(135deg, #fbbf24, #f59e0b); }
    .category-festival { background: linear-gradient(135deg, #60a5fa, #3b82f6); }
    .category-tribun { background: linear-gradient(135deg, #34d399, #10b981); }
    
    .seat-grid-preview { display: flex; flex-direction: column; gap: 4px; }
    .seat-row-preview { display: flex; justify-content: center; gap: 4px; flex-wrap: wrap; }
    
    .hero-text-white {
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
    }
    
    @media (max-width: 768px) {
        .preview-seat { width: 24px; height: 24px; font-size: 7px; }
        .stage-preview-full { padding: 15px; }
        .countdown-number { font-size: 20px; }
        .hero-concert { min-height: 450px; }
        .text-5xl { font-size: 2.5rem; }
    }
</style>

@php
    $bgImage = 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=1920&h=600&fit=crop';
    if ($concert->poster) {
        $bgImage = asset('storage/' . $concert->poster);
    } elseif (isset($concert->image_url) && $concert->image_url) {
        $bgImage = $concert->image_url;
    }
    
    $categories = [];
    if (isset($concert->categories)) {
        if (is_array($concert->categories)) {
            $categories = $concert->categories;
        } elseif (is_string($concert->categories)) {
            $categoryNames = array_map('trim', explode(',', $concert->categories));
            foreach ($categoryNames as $name) {
                $categories[] = [
                    'name' => $name,
                    'price' => $name == 'VIP' ? 500000 : ($name == 'Festival' ? 350000 : 200000),
                    'sisa' => $concert->available_seats ?? 100,
                    'total_seats' => $concert->available_seats ?? 100
                ];
            }
        }
    }
    
    if (empty($categories)) {
        $categories = [
            ['name' => 'VIP', 'price' => 500000, 'sisa' => $concert->available_seats ?? 35, 'total_seats' => $concert->available_seats ?? 35],
            ['name' => 'Festival', 'price' => 350000, 'sisa' => $concert->available_seats ?? 35, 'total_seats' => $concert->available_seats ?? 35],
            ['name' => 'Tribun', 'price' => 200000, 'sisa' => $concert->available_seats ?? 35, 'total_seats' => $concert->available_seats ?? 35],
        ];
    }
    
    $concertName = $concert->name ?? $concert->title ?? 'Konser Flash-Tix';
    $artist = $concert->artist ?? 'Special Artist';
    $venue = $concert->venue ?? 'Venue';
    $city = $concert->city ?? 'Jakarta';
    $description = $concert->description ?? 'Nikmati pengalaman konser yang tak terlupakan bersama artis favorit Anda.';
    $lineup = $concert->lineup ?? ['Artist Utama', 'Special Guest', 'Opening Act'];
    $time = $concert->time ?? '19:00';
    
    $dateString = '';
    if (isset($concert->date)) {
        if ($concert->date instanceof \Carbon\Carbon) {
            $dateString = $concert->date->format('Y-m-d');
        } elseif (is_string($concert->date)) {
            $dateString = preg_replace('/\s.*/', '', $concert->date);
        }
    }
    if (empty($dateString)) {
        $dateString = date('Y-m-d', strtotime('+30 days'));
    }
    
    $eventDate = null;
    try {
        $eventDate = \Carbon\Carbon::parse($dateString . ' ' . $time);
    } catch (\Exception $e) {
        $eventDate = \Carbon\Carbon::now()->addDays(30);
    }
    $isUpcoming = now()->lt($eventDate);
    
    $formattedDate = '';
    try {
        $formattedDate = \Carbon\Carbon::parse($dateString)->translatedFormat('l, d F Y');
    } catch (\Exception $e) {
        $formattedDate = date('d F Y', strtotime($dateString));
    }
    
    $mapsUrl = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.802561!3d-6.211187!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f6c2cc2c5e0b%3A0x8c9f9f9f9f9f9f9f!2sIstora%20Senayan!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid';
    
    $availableSeats = $concert->available_seats ?? 100;
    $badgeText = $availableSeats <= 10 ? '⚠️ HAMPIR HABIS' : '✅ TIKET TERSEDIA';
    $badgeClass = $availableSeats <= 10 ? 'badge-limited' : 'badge-available';
@endphp

<!-- HERO SECTION -->
<div class="hero-concert" style="background-image: url('{{ $bgImage }}'); background-size: cover; background-position: center;">
    <div class="hero-overlay-dark"></div>
    <div class="container mx-auto px-4 relative z-10 pt-36 pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div>
                <div class="flex items-center gap-3 mb-5">
                    <span class="{{ $badgeClass }} text-white px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-lg">
                        {{ $badgeText }}
                    </span>
                    <span class="bg-purple-500/30 backdrop-blur-sm text-purple-300 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider border border-purple-500/50">
                        <i class="fas fa-bolt mr-1"></i> OFFICIAL TICKET
                    </span>
                </div>
                <h1 class="text-5xl md:text-7xl font-extrabold text-white mt-2 mb-3 drop-shadow-lg hero-text-white">{{ $artist }}</h1>
                <p class="text-xl md:text-2xl text-purple-300 font-medium mb-6 hero-text-white">{{ $concertName }}</p>
                
                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center gap-2 bg-black/30 backdrop-blur-sm px-4 py-2 rounded-full text-gray-200">
                        <i class="fas fa-map-marker-alt text-purple-400"></i>
                        <span>{{ $venue }}, {{ $city }}</span>
                    </div>
                    <div class="flex items-center gap-2 bg-black/30 backdrop-blur-sm px-4 py-2 rounded-full text-gray-200">
                        <i class="fas fa-calendar-alt text-purple-400"></i>
                        <span>{{ $formattedDate }}</span>
                    </div>
                    <div class="flex items-center gap-2 bg-black/30 backdrop-blur-sm px-4 py-2 rounded-full text-gray-200">
                        <i class="fas fa-clock text-purple-400"></i>
                        <span>{{ $time }} WIB</span>
                    </div>
                </div>
            </div>
            
            @if($isUpcoming)
            <div class="flex justify-end">
                <div class="countdown-wrapper text-center">
                    <p class="text-gray-300 text-xs uppercase tracking-wider mb-3">
                        <i class="fas fa-hourglass-half mr-1"></i> Konser dimulai dalam
                    </p>
                    <div class="flex gap-5" id="countdown">
                        <div><span class="countdown-number text-4xl" id="days">00</span><p class="text-xs text-gray-300 mt-1">Hari</p></div>
                        <div><span class="countdown-number text-4xl" id="hours">00</span><p class="text-xs text-gray-300 mt-1">Jam</p></div>
                        <div><span class="countdown-number text-4xl" id="minutes">00</span><p class="text-xs text-gray-300 mt-1">Menit</p></div>
                        <div><span class="countdown-number text-4xl" id="seconds">00</span><p class="text-xs text-gray-300 mt-1">Detik</p></div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- LEFT COLUMN -->
            <div class="lg:col-span-2 space-y-6">
                <div class="info-card p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-purple-500"></i> Tentang Konser
                    </h2>
                    <p class="text-gray-600 leading-relaxed">{{ $description }}</p>
                </div>
                
                <div class="info-card p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-users text-purple-500"></i> Line-up
                    </h2>
                    <div class="flex flex-wrap gap-3">
                        @foreach($lineup as $item)
                            <span class="px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm border border-purple-200">
                                <i class="fas fa-microphone-alt mr-1 text-xs"></i> {{ $item }}
                            </span>
                        @endforeach
                    </div>
                </div>
                
                <div class="info-card p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-map-marked-alt text-purple-500"></i> Lokasi & Venue
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-800 font-semibold text-lg">{{ $venue }}</p>
                            <p class="text-gray-500 text-sm mb-3">{{ $city }}</p>
                            <div class="mt-4 p-3 bg-purple-50 rounded-xl border border-purple-200">
                                <p class="text-xs text-gray-500 flex items-center gap-2">
                                    <i class="fas fa-info-circle text-purple-500"></i>
                                    Gate Open: 1 jam sebelum konser
                                </p>
                            </div>
                        </div>
                        <div class="map-container">
                            <iframe src="{{ $mapsUrl }}" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
                
                <div class="info-card p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-chair text-purple-500"></i> Denah Kursi - Preview
                    </h2>
                    
                    <div class="stage-preview-full">
                        <div class="text-center mb-6">
                            <div class="w-40 h-1 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto rounded-full mb-3"></div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider flex items-center justify-center gap-2">
                                <i class="fas fa-microphone-alt text-purple-500"></i> MAIN STAGE
                            </p>
                        </div>
                        
                        @foreach($categories as $idx => $category)
                        @php
                            $catClass = '';
                            $catName = '';
                            if ($category['name'] == 'VIP') {
                                $catClass = 'category-vip';
                                $catName = 'vip';
                            } elseif ($category['name'] == 'Festival') {
                                $catClass = 'category-festival';
                                $catName = 'festival';
                            } else {
                                $catClass = 'category-tribun';
                                $catName = 'tribun';
                            }
                            $totalSeatsPreview = min($category['total_seats'] ?? 100, 100);
                            $previewColsCount = min(10, ceil(sqrt($totalSeatsPreview)));
                            $previewRowsCount = ceil($totalSeatsPreview / $previewColsCount);
                        @endphp
                        <div class="mb-6">
                            <div class="flex items-center gap-2 mb-3 pb-2 border-b border-gray-200">
                                <div class="w-4 h-4 rounded-full {{ $catClass }}"></div>
                                <span class="text-sm font-bold text-gray-800">{{ $category['name'] }} ZONE</span>
                                <span class="text-xs text-purple-500 ml-auto">{{ $category['total_seats'] }} Kursi</span>
                            </div>
                            <div class="seat-grid-preview">
                                @for($r = 1; $r <= min($previewRowsCount, 8); $r++)
                                <div class="seat-row-preview">
                                    <span class="text-xs text-purple-500 w-5 font-bold">{{ $r }}</span>
                                    @for($c = 1; $c <= $previewColsCount; $c++)
                                    <div class="preview-seat {{ $catName }}" style="width: 28px; height: 28px;">
                                        {{ $c }}
                                    </div>
                                    @endfor
                                    <span class="text-xs text-purple-500 w-5 font-bold text-right">{{ $r }}</span>
                                </div>
                                @endfor
                            </div>
                            @if($previewRowsCount > 8)
                            <p class="text-center text-gray-400 text-xs mt-2">+{{ $previewRowsCount - 8 }} baris lainnya</p>
                            @endif
                        </div>
                        @endforeach
                        
                        <div class="flex justify-center gap-6 mt-4 pt-4 border-t border-gray-200">
                            <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-sm category-vip"></div><span class="text-xs text-gray-500">VIP</span></div>
                            <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-sm category-festival"></div><span class="text-xs text-gray-500">Festival</span></div>
                            <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-sm category-tribun"></div><span class="text-xs text-gray-500">Tribun</span></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- ============================================ -->
            <!-- RIGHT COLUMN - PEMBELIAN TIKET -->
            <!-- ============================================ -->
            <div class="lg:col-span-1">
                <div class="info-card p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-800 mb-2 flex items-center gap-2">
                        <i class="fas fa-ticket-alt text-purple-500"></i> Pilih Tiket
                    </h3>
                    <p class="text-gray-500 text-sm mb-6">Klik kategori untuk langsung pilih kursi</p>
                    
                    @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl flex items-center gap-3">
                        <i class="fas fa-exclamation-circle"></i>
                        <span class="text-sm font-bold">{{ session('error') }}</span>
                    </div>
                    @endif
                    
                    <div class="space-y-4 mb-8">
                        @foreach($categories as $category)
                        <div class="ticket-category p-4 cursor-pointer border border-gray-200 rounded-xl" 
                            data-category="{{ $category['name'] }}"
                            data-price="{{ $category['price'] }}"
                            data-total="{{ $category['total_seats'] ?? 100 }}"
                            onclick="selectCategory(this)">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-lg">{{ $category['name'] }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-chair mr-1"></i> Sisa: <span class="text-purple-600 font-semibold">{{ number_format($category['sisa'] ?? 0) }}</span> / {{ number_format($category['total_seats'] ?? 0) }} kursi
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-black text-gradient">
                                        Rp {{ number_format($category['price'], 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- ============================================ -->
                    <!-- TOMBOL BERDASARKAN STATUS LOGIN -->
                    <!-- ============================================ -->
                    @auth
                        <div class="flex flex-col gap-3">
                            <button id="btnPilihKursi" disabled class="btn-primary w-full font-bold py-4 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 text-lg">
                                <i class="fas fa-chair"></i> LANJUT PILIH KURSI
                            </button>
                            
                            <!-- TOMBOL WISHLIST -->
                            <form action="{{ route('wishlist.add') }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="concert_id" value="{{ $concert->_id ?? $concert->id }}">
                                <button type="submit" class="btn-wishlist w-full font-bold py-4 transition-all duration-300 flex items-center justify-center gap-2 text-lg">
                                    <i class="fas fa-heart"></i> TAMBAH KE PRE-WAR WISHLIST
                                </button>
                            </form>
                        </div>
                    @endauth
                    
                    @guest
                        <a href="{{ route('register') }}" 
                        onclick="alert('Silakan daftar atau login terlebih dahulu untuk memesan tiket!')"
                        class="btn-guest w-full font-bold py-4 transition-all duration-300 flex items-center justify-center gap-2 text-lg">
                            <i class="fas fa-user-plus"></i> DAFTAR / LOGIN
                        </a>
                    @endguest
                    
                    <div class="mt-4 p-3 bg-gray-100 rounded-xl">
                        <div class="flex items-center justify-center gap-4 text-xs text-gray-500">
                            <span><i class="fas fa-lock text-purple-500"></i> Kursi ditahan 15 menit</span>
                            <span><i class="fas fa-credit-card text-purple-500"></i> Pembayaran aman</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // COUNTDOWN TIMER
    @if($isUpcoming)
    function updateCountdown() {
        const eventDate = new Date('{{ $dateString }}T{{ $time }}:00').getTime();
        const now = new Date().getTime();
        const distance = eventDate - now;
        
        if (distance > 0) {
            document.getElementById('days').textContent = Math.floor(distance / (1000*60*60*24)).toString().padStart(2,'0');
            document.getElementById('hours').textContent = Math.floor((distance % (1000*60*60*24)) / (1000*60*60)).toString().padStart(2,'0');
            document.getElementById('minutes').textContent = Math.floor((distance % (1000*60*60)) / (1000*60)).toString().padStart(2,'0');
            document.getElementById('seconds').textContent = Math.floor((distance % (1000*60)) / 1000).toString().padStart(2,'0');
        }
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);
    @endif
    
    // LOGIKA PILIH KATEGORI & REDIRECT
    function selectCategory(element) {
        const category = element.getAttribute('data-category');
        const concertId = "{{ $concert->_id ?? $concert->id }}";

        if (!category) {
            console.error("Kategori tidak terbaca!");
            return;
        }

        // Efek visual seleksi
        document.querySelectorAll('.ticket-category').forEach(el => {
            el.classList.remove('selected');
        });
        element.classList.add('selected');

        // Simpan ke storage
        sessionStorage.setItem('selected_category', category);
        sessionStorage.setItem('selected_price', element.getAttribute('data-price'));
        localStorage.setItem('flash_booking_category', category);
        localStorage.setItem('flash_booking_price', element.getAttribute('data-price'));

        // Aktifkan tombol dan ubah teks (hanya untuk user yang login)
        @auth
        const btn = document.getElementById('btnPilihKursi');
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> MENUJU DENAH KURSI...';
        }
        @endauth

        // Navigasi ke halaman seats (hanya untuk user yang login)
        const targetUrl = "/concerts/" + concertId + "/seats?category=" + encodeURIComponent(category);
        console.log("Mengarahkan ke: " + targetUrl);
        
        setTimeout(() => {
            @auth
            window.location.href = targetUrl;
            @endauth
        }, 300);
    }
</script>
@endsection