@extends('layouts.app')

@section('title', 'Daftar Konser - Flash-Tix')

@section('content')
<style>
    /* ============================================ */
    /* CLEAN PREMIUM WHITE MODE - MODERN & ELEGANT */
    /* ============================================ */
    :root {
        --bg-primary: #f8fafc;
        --bg-card: #ffffff;
        --text-primary: #0f172a;
        --text-secondary: #475569;
        --border-color: #e2e8f0;
        --accent-purple: #7c3aed;
        --accent-pink: #db2777;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
    }
    
    body {
        background-color: var(--bg-primary);
    }
    
    .concert-page {
        background: var(--bg-primary);
        min-height: 100vh;
    }
    
    .concert-card {
        background: var(--bg-card);
        border-radius: 24px;
        border: 1px solid var(--border-color);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    
    .concert-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-xl);
        border-color: rgba(124, 58, 237, 0.25);
    }
    
    .image-container {
        position: relative;
        overflow: hidden;
        height: 200px;
        background: #f1f5f9;
    }
    
    .concert-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .concert-card:hover .concert-image {
        transform: scale(1.05);
    }
    
    .badge-available {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        font-size: 0.7rem;
        padding: 0.25rem 0.75rem;
    }
    
    .badge-limited {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        font-size: 0.7rem;
        padding: 0.25rem 0.75rem;
        animation: pulse 1.5s infinite;
    }
    
    .badge-soldout {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        font-size: 0.7rem;
        padding: 0.25rem 0.75rem;
    }
    
    .badge-popular {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        font-size: 0.65rem;
        padding: 0.2rem 0.6rem;
    }
    
    .badge-trending {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        font-size: 0.65rem;
        padding: 0.2rem 0.6rem;
    }
    
    .badge-premium-limited {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        font-size: 0.65rem;
        padding: 0.2rem 0.6rem;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.85; }
    }
    
    .price-tag {
        font-size: 1.6rem;
        font-weight: 800;
        background: linear-gradient(135deg, #7c3aed, #db2777);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .btn-premium {
        background: linear-gradient(135deg, #7c3aed, #db2777);
        transition: all 0.3s ease;
        border-radius: 14px;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.6rem 1.2rem;
        box-shadow: 0 2px 8px rgba(124, 58, 237, 0.2);
    }
    
    .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(124, 58, 237, 0.3);
    }
    
    .btn-login-required {
        background: linear-gradient(135deg, #94a3b8, #64748b);
        transition: all 0.3s ease;
        border-radius: 14px;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.6rem 1.2rem;
        cursor: pointer;
    }
    
    .btn-login-required:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #7c3aed, #db2777);
        box-shadow: 0 8px 18px rgba(124, 58, 237, 0.3);
    }
    
    .concert-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        line-height: 1.3;
    }
    
    .concert-artist {
        font-size: 0.85rem;
        font-weight: 600;
        color: #7c3aed;
        margin-bottom: 0.75rem;
    }
    
    .concert-info {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-bottom: 0.4rem;
    }
    
    .concert-info i {
        width: 1.2rem;
        color: #7c3aed;
        font-size: 0.7rem;
    }
    
    .filter-glass {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 24px;
        box-shadow: var(--shadow-md);
        padding: 1.5rem;
    }
    
    .filter-glass input,
    .filter-glass select {
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        color: var(--text-primary);
        transition: all 0.3s ease;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }
    
    .filter-glass input:focus,
    .filter-glass select:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        outline: none;
    }
    
    .pagination-btn {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        transition: all 0.3s ease;
        color: var(--text-secondary);
        width: 40px;
        height: 40px;
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    .pagination-btn:hover:not(:disabled) {
        background: #7c3aed;
        border-color: #7c3aed;
        color: white;
    }
    
    .pagination-btn.active {
        background: linear-gradient(135deg, #7c3aed, #db2777);
        border-color: transparent;
        color: white;
    }
    
    .loading-premium {
        background: white;
        backdrop-filter: blur(20px);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        box-shadow: var(--shadow-xl);
        padding: 2rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 24px;
        border: 1px solid var(--border-color);
    }
    
    /* ============================================ */
    /* GRID 4 KOLOM UNTUK DESKTOP */
    /* ============================================ */
    .concerts-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }
    
    /* Responsive Breakpoints */
    @media (max-width: 1280px) {
        .concerts-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (max-width: 900px) {
        .concerts-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 600px) {
        .concerts-grid {
            grid-template-columns: 1fr;
        }
        .price-tag { font-size: 1.3rem; }
        .concert-title { font-size: 1.1rem; }
        .image-container { height: 180px; }
    }
    
    /* List View Style */
    .concerts-grid.list-view {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .concerts-grid.list-view .concert-card {
        display: flex;
        flex-direction: row;
    }
    
    .concerts-grid.list-view .image-container {
        width: 200px;
        height: 150px;
        flex-shrink: 0;
    }
    
    .concerts-grid.list-view .p-5 {
        flex: 1;
    }
    
    @media (max-width: 640px) {
        .concerts-grid.list-view .concert-card {
            flex-direction: column;
        }
        .concerts-grid.list-view .image-container {
            width: 100%;
            height: 180px;
        }
    }
</style>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="fixed inset-0 bg-white/80 backdrop-blur-md flex items-center justify-center z-50 opacity-0 invisible transition-all duration-300">
    <div class="loading-premium text-center">
        <div class="spinner mb-4 mx-auto w-10 h-10 border-4 border-purple-200 border-t-purple-600 rounded-full animate-spin"></div>
        <p class="text-gray-600 font-semibold">Memproses pesanan...</p>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-24 left-1/2 -translate-x-1/2 translate-y-24 bg-gray-800 text-white px-5 py-3 rounded-full flex items-center gap-3 z-50 transition-transform duration-300 shadow-xl text-sm">
    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
    <span>Silakan login terlebih dahulu untuk memesan tiket</span>
</div>

<div class="concert-page py-12">
    <div class="container mx-auto px-4">
        
        <!-- HEADER SECTION -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 bg-purple-100 rounded-full px-4 py-1.5 mb-4">
                <i class="fas fa-bolt text-purple-600 text-xs"></i>
                <span class="text-purple-700 text-xs font-bold uppercase tracking-wider">LIVE NOW</span>
            </div>
            <h1 class="text-4xl md:text-6xl font-black mb-4 tracking-tight">
                <span class="bg-gradient-to-r from-purple-600 via-pink-500 to-purple-600 bg-clip-text text-transparent">
                    FLASH-TIX
                </span>
            </h1>
            <p class="text-gray-500 text-lg max-w-2xl mx-auto">Temukan dan pesan tiket konser dari artis favoritmu</p>
        </div>
        
        <!-- SEARCH & FILTER -->
        <div class="filter-glass rounded-2xl mb-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" id="searchInput" placeholder="Cari artis atau konser..." 
                           class="w-full pl-10 pr-4 py-3">
                </div>
                
                <div class="relative">
                    <i class="fas fa-map-marker-alt absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <select id="cityFilter" class="w-full pl-10 pr-4 py-3 appearance-none cursor-pointer">
                        <option value="all">Semua Kota</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Medan">Medan</option>
                        <option value="Bali">Bali</option>
                        <option value="Yogyakarta">Yogyakarta</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                </div>
                
                <div class="relative">
                    <i class="fas fa-sort-amount-down absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <select id="sortFilter" class="w-full pl-10 pr-4 py-3 appearance-none cursor-pointer">
                        <option value="default">Urutkan Berdasarkan</option>
                        <option value="date_asc">Tanggal Terdekat</option>
                        <option value="price_asc">Harga Termurah</option>
                        <option value="price_desc">Harga Termahal</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                </div>
                
                <button id="searchBtn" class="btn-premium py-3 flex items-center justify-center gap-2">
                    <i class="fas fa-search"></i>
                    <span>Cari Sekarang</span>
                </button>
            </div>
            
            <div class="flex flex-wrap gap-2 mt-4" id="activeFilters"></div>
        </div>
        
        <!-- RESULT COUNT & VIEW TOGGLE -->
        <div class="flex justify-between items-center mb-6">
            <p class="text-gray-500 text-sm">
                <span id="resultCount" class="text-purple-600 font-bold">0</span> konser ditemukan
            </p>
            <div class="flex items-center gap-2">
                <span class="text-gray-400 text-xs">Tampilan:</span>
                <button id="gridView" class="p-2 rounded-lg bg-purple-100 text-purple-600 transition">
                    <i class="fas fa-th-large"></i>
                </button>
                <button id="listView" class="p-2 rounded-lg text-gray-400 hover:text-purple-600 transition">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>
        
        <!-- CONCERTS GRID - 4 KOLOM -->
        <div id="concertsGrid" class="concerts-grid">
            @forelse($concerts as $concert)
            @php
                $availableSeats = $concert->available_seats ?? 0;
                
                if ($availableSeats <= 0) {
                    $badgeText = 'SOLD OUT';
                    $badgeClass = 'badge-soldout';
                } elseif ($availableSeats <= 10) {
                    $badgeText = 'HAMPIR HABIS';
                    $badgeClass = 'badge-limited';
                } else {
                    $badgeText = 'TERSEDIA';
                    $badgeClass = 'badge-available';
                }
                
                $premiumBadge = null;
                $premiumBadgeClass = null;
                
                if (isset($concert->label)) {
                    if ($concert->label == 'popular') {
                        $premiumBadge = '🔥 POPULAR';
                        $premiumBadgeClass = 'badge-popular';
                    } elseif ($concert->label == 'trending') {
                        $premiumBadge = '⭐ TRENDING';
                        $premiumBadgeClass = 'badge-trending';
                    } elseif ($concert->label == 'limited') {
                        $premiumBadge = '🎫 LIMITED';
                        $premiumBadgeClass = 'badge-premium-limited';
                    }
                }
                
                $imageUrl = $concert->poster ? asset('storage/' . $concert->poster) : null;
                $price = 0;
                if (isset($concert->categories) && is_array($concert->categories) && count($concert->categories) > 0) {
                    $price = $concert->categories[0]['price'];
                } elseif (isset($concert->price)) {
                    $price = $concert->price;
                }
                
                $concertName = $concert->name ?? $concert->title ?? 'Konser Musik';
                $artist = $concert->artist ?? 'Special Artist';
                $city = $concert->city ?? 'Jakarta';
                $venue = $concert->venue ?? 'Venue';
                $date = $concert->date ?? date('Y-m-d', strtotime('+30 days'));
                $time = $concert->time ?? '19:00';
                
                $isUpcoming = \Carbon\Carbon::parse($date)->isFuture();
                $dateLabel = $isUpcoming ? \Carbon\Carbon::parse($date)->diffInDays(now()) . ' hari lagi' : 'Telah berlangsung';
                $formattedDate = \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y');
            @endphp
            <div class="concert-card" data-city="{{ $city }}" data-price="{{ $price }}" data-date="{{ $date }}">
                <div class="image-container">
                    @if($concert->poster)
                        <img src="{{ $imageUrl }}" alt="{{ $concertName }}" class="concert-image">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                            <i class="fas fa-music text-4xl text-purple-300"></i>
                        </div>
                    @endif
                    
                    <div class="absolute top-3 right-3 flex flex-col gap-1.5">
                        <span class="{{ $badgeClass }} text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                            {{ $badgeText }}
                        </span>
                        @if($premiumBadge)
                        <span class="{{ $premiumBadgeClass }} text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                            {{ $premiumBadge }}
                        </span>
                        @endif
                    </div>
                    
                    <div class="absolute bottom-3 left-3 bg-black/50 backdrop-blur-sm rounded-full px-3 py-1">
                        <span class="text-white text-xs"><i class="far fa-clock mr-1"></i> {{ $dateLabel }}</span>
                    </div>
                </div>
                
                <div class="p-4">
                    <h3 class="concert-title">{{ Str::limit($concertName, 25) }}</h3>
                    <p class="concert-artist">{{ Str::limit($artist, 20) }}</p>
                    
                    <div class="space-y-1.5 mb-3">
                        <p class="concert-info"><i class="fas fa-map-marker-alt"></i> {{ Str::limit($venue, 20) }}, {{ $city }}</p>
                        <p class="concert-info"><i class="fas fa-calendar-alt"></i> {{ $formattedDate }} | {{ $time }} WIB</p>
                        @if($availableSeats > 0)
                            <p class="concert-info"><i class="fas fa-chair"></i> Sisa: <span class="text-purple-600 font-semibold">{{ number_format($availableSeats) }}</span> kursi</p>
                        @endif
                    </div>
                    
                    <!-- TOMBOL PESAN -->
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="price-tag font-black">Rp {{ number_format($price, 0, ',', '.') }}</p>
                            <span class="text-gray-400 text-xs">/tiket</span>
                        </div>
                        
                        @auth
                            <a href="{{ route('concerts.show', $concert->_id ?? $concert->id) }}" 
                               class="btn-premium text-white flex items-center gap-2 shadow-sm px-4 py-2 text-sm">
                                PESAN <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        @endauth
                        
                        @guest
                            <a href="{{ route('register') }}" 
                               onclick="return confirm('Silakan daftar atau login terlebih dahulu untuk memesan tiket Flash-Tix!') || event.preventDefault();"
                               class="btn-login-required text-white flex items-center gap-2 shadow-sm px-4 py-2 text-sm">
                                PESAN <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full empty-state">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-ticket-alt text-3xl text-gray-300"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Belum Ada Konser</h3>
                <p class="text-gray-500 text-sm mt-1">Saat ini belum ada konser yang tersedia.</p>
                <p class="text-gray-400 text-xs mt-2">Silakan cek kembali nanti.</p>
            </div>
            @endforelse
        </div>
        
        <!-- PAGINATION -->
        @if(isset($concerts) && method_exists($concerts, 'links'))
        <div class="flex justify-center gap-2 flex-wrap mt-10">
            {{ $concerts->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    const isUserLoggedIn = @json(Auth::check());
    
    const loadingOverlay = document.getElementById('loadingOverlay');
    const toast = document.getElementById('toast');
    const searchInput = document.getElementById('searchInput');
    const cityFilter = document.getElementById('cityFilter');
    const sortFilter = document.getElementById('sortFilter');
    const searchBtn = document.getElementById('searchBtn');
    const concertsGrid = document.getElementById('concertsGrid');
    const resultCountSpan = document.getElementById('resultCount');
    
    let currentPage = 1;
    const itemsPerPage = 20; // 4 kolom x 5 baris = 20 per halaman
    let filteredCards = [];
    
    function showLoading() {
        loadingOverlay.classList.remove('opacity-0', 'invisible');
        loadingOverlay.classList.add('opacity-100', 'visible');
    }
    
    function hideLoading() {
        loadingOverlay.classList.remove('opacity-100', 'visible');
        loadingOverlay.classList.add('opacity-0', 'invisible');
    }
    
    function filterAndSortCards() {
        const searchTerm = searchInput.value.toLowerCase();
        const city = cityFilter.value;
        const sort = sortFilter.value;
        
        let cards = Array.from(document.querySelectorAll('.concert-card'));
        
        if (searchTerm) {
            cards = cards.filter(card => {
                const title = card.querySelector('.concert-title')?.innerText.toLowerCase() || '';
                return title.includes(searchTerm);
            });
        }
        
        if (city !== 'all') {
            cards = cards.filter(card => card.dataset.city === city);
        }
        
        if (sort === 'price_asc') {
            cards.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
        } else if (sort === 'price_desc') {
            cards.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
        } else if (sort === 'date_asc') {
            cards.sort((a, b) => new Date(a.dataset.date) - new Date(b.dataset.date));
        }
        
        filteredCards = cards;
        updateDisplay();
        updateActiveFilters();
    }
    
    function updateDisplay() {
        const start = 0;
        const end = itemsPerPage;
        
        document.querySelectorAll('.concert-card').forEach(card => card.style.display = 'none');
        filteredCards.slice(start, end).forEach(card => card.style.display = 'block');
        resultCountSpan.innerText = filteredCards.length;
    }
    
    function updateActiveFilters() {
        const searchTerm = searchInput.value;
        const city = cityFilter.value;
        
        let activeFilters = [];
        if (city !== 'all') activeFilters.push(`Kota: ${city}`);
        if (searchTerm) activeFilters.push(`Cari: "${searchTerm}"`);
        
        const activeFiltersDiv = document.getElementById('activeFilters');
        if (activeFilters.length > 0) {
            activeFiltersDiv.innerHTML = `<span class="text-gray-500 text-sm">Filter aktif:</span> ${activeFilters.map(f => `<span class="bg-purple-100 text-purple-700 text-xs px-3 py-1 rounded-full">${f}</span>`).join('')}`;
        } else {
            activeFiltersDiv.innerHTML = '<span class="text-gray-500 text-sm">Filter aktif: Tidak ada</span>';
        }
    }
    
    searchBtn.addEventListener('click', () => { filterAndSortCards(); });
    searchInput.addEventListener('keyup', (e) => { if (e.key === 'Enter') { filterAndSortCards(); } });
    cityFilter.addEventListener('change', () => { filterAndSortCards(); });
    sortFilter.addEventListener('change', () => { filterAndSortCards(); });
    
    // View Toggle
    let isGridView = true;
    const gridViewBtn = document.getElementById('gridView');
    const listViewBtn = document.getElementById('listView');
    
    gridViewBtn.addEventListener('click', () => {
        if (!isGridView) {
            concertsGrid.classList.remove('list-view');
            gridViewBtn.classList.add('bg-purple-100', 'text-purple-600');
            listViewBtn.classList.remove('bg-purple-100', 'text-purple-600');
            listViewBtn.classList.add('text-gray-400');
            isGridView = true;
        }
    });
    
    listViewBtn.addEventListener('click', () => {
        if (isGridView) {
            concertsGrid.classList.add('list-view');
            listViewBtn.classList.add('bg-purple-100', 'text-purple-600');
            gridViewBtn.classList.remove('bg-purple-100', 'text-purple-600');
            gridViewBtn.classList.add('text-gray-400');
            isGridView = false;
        }
    });
    
    // Initialize
    filterAndSortCards();
</script>
@endsection