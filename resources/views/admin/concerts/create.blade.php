@extends('layouts.admin')

@section('title', 'Tambah Konser - Admin Panel')

@section('page-title', '🎫 Tambah Master Data Konser')

@section('content')
<style>
    .form-section {
        background: white;
        border-radius: 20px;
        padding: 24px;
        margin-bottom: 28px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .form-section:hover {
        border-color: #7c3aed;
        box-shadow: 0 4px 20px rgba(124, 58, 237, 0.08);
    }
    
    .form-section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .form-section-title i {
        color: #7c3aed;
        font-size: 20px;
    }
    
    .price-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
        cursor: default;
    }
    
    .price-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: #7c3aed;
    }
    
    .price-card.vip { border-top: 4px solid #fbbf24; }
    .price-card.festival { border-top: 4px solid #60a5fa; }
    .price-card.tribun { border-top: 4px solid #34d399; }
    
    .price-card .badge-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
    }
    
    .badge-icon.vip { background: linear-gradient(135deg, #fbbf24, #f59e0b); }
    .badge-icon.festival { background: linear-gradient(135deg, #60a5fa, #3b82f6); }
    .badge-icon.tribun { background: linear-gradient(135deg, #34d399, #10b981); }
    
    /* Label Badge Styles */
    .label-option {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .label-option input {
        display: none;
    }
    
    .label-option .label-card {
        padding: 12px 20px;
        border-radius: 40px;
        font-weight: 700;
        font-size: 14px;
        text-align: center;
        transition: all 0.3s ease;
        border: 2px solid #e2e8f0;
        background: white;
        cursor: pointer;
    }
    
    .label-option input:checked + .label-card {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        transform: scale(1.02);
    }
    
    .label-popular { color: #ef4444; }
    .label-popular-bg { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
    .label-trending { color: #8b5cf6; }
    .label-trending-bg { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }
    .label-limited { color: #f59e0b; }
    .label-limited-bg { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
    .label-none { color: #64748b; }
    .label-none-bg { background: #f1f5f9; color: #475569; }
    
    .input-icon {
        position: relative;
    }
    
    .input-icon i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #7c3aed;
        font-size: 14px;
    }
    
    .input-icon input,
    .input-icon textarea,
    .input-icon select {
        padding-left: 42px;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .input-icon input:focus,
    .input-icon textarea:focus,
    .input-icon select:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        outline: none;
    }
    
    .input-group {
        margin-bottom: 20px;
    }
    
    .input-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }
    
    .input-group label .required {
        color: #ef4444;
        margin-left: 4px;
    }
    
    .input-group .helper-text {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 4px;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #7c3aed, #db2777);
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        border: none;
        color: white;
        font-weight: bold;
        padding: 12px 32px;
        border-radius: 14px;
        cursor: pointer;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
    }
    
    .preview-image {
        margin-top: 12px;
        display: none;
    }
    
    .preview-image img {
        max-width: 200px;
        border-radius: 12px;
        border: 2px solid #7c3aed;
    }
    
    .btn-back {
        background: #f1f5f9;
        color: #475569;
        padding: 12px 24px;
        border-radius: 14px;
        transition: all 0.3s ease;
    }
    
    .btn-back:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
</style>

<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        
        <!-- Header Premium -->
        <div class="bg-gradient-to-r from-purple-600 via-pink-600 to-purple-600 px-8 py-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white/10 rounded-full"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white/10 rounded-full"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fas fa-plus-circle text-white text-3xl"></i>
                    <h2 class="text-2xl font-extrabold text-white">Tambah Konser Baru</h2>
                </div>
                <p class="text-purple-200 text-sm">Isi data konser dengan lengkap untuk ditampilkan di halaman utama Flash-Tix</p>
            </div>
        </div>
        
        <form action="{{ route('admin.concerts.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            
            @if ($errors->any())
            <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span class="font-bold">Terdapat kesalahan pada form:</span>
                </div>
                <ul class="ml-6 list-disc text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <!-- SECTION 1: INFORMASI DASAR -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-info-circle"></i>
                    Informasi Dasar Konser
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="input-group">
                        <label><i class="fas fa-tag text-purple-500 mr-1"></i> Nama Konser <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-music"></i>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Flash Tour 2026" required>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label><i class="fas fa-microphone-alt text-purple-500 mr-1"></i> Artis / Band <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" name="artist" value="{{ old('artist') }}" placeholder="Nama Artis" required>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label><i class="fas fa-building text-purple-500 mr-1"></i> Venue / Gedung <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-location-dot"></i>
                            <input type="text" name="venue" value="{{ old('venue') }}" placeholder="Contoh: Istora Senayan" required>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label><i class="fas fa-map-marker-alt text-purple-500 mr-1"></i> Kota <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-city"></i>
                            <input type="text" name="city" value="{{ old('city') }}" placeholder="Jakarta, Surabaya, Bandung, dll" required>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label><i class="fas fa-calendar-alt text-purple-500 mr-1"></i> Tanggal Pelaksanaan <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-calendar-day"></i>
                            <input type="date" name="date" value="{{ old('date') }}" required>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label><i class="fas fa-clock text-purple-500 mr-1"></i> Jam Pelaksanaan <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-hourglass-start"></i>
                            <input type="time" name="time" value="{{ old('time') }}" required>
                        </div>
                        <p class="helper-text">Waktu konser dimulai</p>
                    </div>
                    
                    <div class="input-group">
                        <label><i class="fas fa-door-open text-purple-500 mr-1"></i> Gate Open (Opsional)</label>
                        <div class="input-icon">
                            <i class="fas fa-clock"></i>
                            <input type="time" name="gate_open" value="{{ old('gate_open') }}">
                        </div>
                        <p class="helper-text">Biasanya 1 jam sebelum konser</p>
                    </div>
                </div>
            </div>
            
            <!-- SECTION 2: LABEL PREMIUM (POPULAR, TRENDING, LIMITED) -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-fire"></i>
                    Label Premium Konser
                </div>
                <p class="text-sm text-gray-500 mb-4">Pilih label yang akan ditampilkan di card konser (opsional)</p>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Tanpa Label -->
                    <label class="label-option">
                        <input type="radio" name="label" value="none" {{ old('label', 'none') == 'none' ? 'checked' : '' }}>
                        <div class="label-card label-none">
                            <i class="fas fa-times-circle mr-2"></i>
                            Tidak Ada
                        </div>
                    </label>
                    
                    <!-- Popular -->
                    <label class="label-option">
                        <input type="radio" name="label" value="popular" {{ old('label') == 'popular' ? 'checked' : '' }}>
                        <div class="label-card label-popular">
                            <i class="fas fa-fire mr-2"></i>
                            🔥 POPULAR
                        </div>
                    </label>
                    
                    <!-- Trending -->
                    <label class="label-option">
                        <input type="radio" name="label" value="trending" {{ old('label') == 'trending' ? 'checked' : '' }}>
                        <div class="label-card label-trending">
                            <i class="fas fa-chart-line mr-2"></i>
                            ⭐ TRENDING
                        </div>
                    </label>
                    
                    <!-- Limited -->
                    <label class="label-option">
                        <input type="radio" name="label" value="limited" {{ old('label') == 'limited' ? 'checked' : '' }}>
                        <div class="label-card label-limited">
                            <i class="fas fa-hourglass-half mr-2"></i>
                            🎫 LIMITED
                        </div>
                    </label>
                </div>
                
                <div class="mt-4 p-3 bg-purple-50 rounded-xl">
                    <p class="text-xs text-gray-600 flex items-center gap-2">
                        <i class="fas fa-info-circle text-purple-500"></i>
                        Label akan ditampilkan di pojok kanan atas card konser pada halaman utama.
                    </p>
                </div>
            </div>
            
            <!-- SECTION 3: HARGA & KAPASITAS -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-ticket-alt"></i>
                    Kategori & Harga Tiket
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
                    <!-- VIP -->
                    <div class="price-card vip">
                        <div class="badge-icon vip">
                            <i class="fas fa-crown text-white text-xl"></i>
                        </div>
                        <p class="font-bold text-gray-800 mt-2">VIP (Gold)</p>
                        <div class="input-icon mt-3">
                            <i class="fas fa-rupiah-sign"></i>
                            <input type="number" name="vip_price" value="{{ old('vip_price', 500000) }}" class="text-center" placeholder="Harga VIP" required>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">View terbaik, dekat panggung</p>
                    </div>
                    
                    <!-- Festival -->
                    <div class="price-card festival">
                        <div class="badge-icon festival">
                            <i class="fas fa-star text-white text-xl"></i>
                        </div>
                        <p class="font-bold text-gray-800 mt-2">FESTIVAL (Silver)</p>
                        <div class="input-icon mt-3">
                            <i class="fas fa-rupiah-sign"></i>
                            <input type="number" name="festival_price" value="{{ old('festival_price', 350000) }}" class="text-center" placeholder="Harga Festival" required>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Berdiri di area depan panggung</p>
                    </div>
                    
                    <!-- Tribun -->
                    <div class="price-card tribun">
                        <div class="badge-icon tribun">
                            <i class="fas fa-chair text-white text-xl"></i>
                        </div>
                        <p class="font-bold text-gray-800 mt-2">TRIBUN (Bronze)</p>
                        <div class="input-icon mt-3">
                            <i class="fas fa-rupiah-sign"></i>
                            <input type="number" name="tribun_price" value="{{ old('tribun_price', 200000) }}" class="text-center" placeholder="Harga Tribun" required>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Duduk nyaman dengan view panggung</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="input-group">
                        <label><i class="fas fa-chair text-purple-500 mr-1"></i> Kapasitas Kursi VIP</label>
                        <div class="input-icon">
                            <i class="fas fa-crown"></i>
                            <input type="number" name="vip_seats" value="{{ old('vip_seats', 100) }}" placeholder="Jumlah kursi VIP" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <label><i class="fas fa-chair text-purple-500 mr-1"></i> Kapasitas Kursi Festival</label>
                        <div class="input-icon">
                            <i class="fas fa-star"></i>
                            <input type="number" name="festival_seats" value="{{ old('festival_seats', 100) }}" placeholder="Jumlah kursi Festival" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <label><i class="fas fa-chair text-purple-500 mr-1"></i> Kapasitas Kursi Tribun</label>
                        <div class="input-icon">
                            <i class="fas fa-chair"></i>
                            <input type="number" name="tribun_seats" value="{{ old('tribun_seats', 100) }}" placeholder="Jumlah kursi Tribun" required>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 p-3 bg-purple-50 rounded-xl">
                    <p class="text-sm text-gray-600 flex items-center gap-2">
                        <i class="fas fa-info-circle text-purple-500"></i>
                        Total kapasitas keseluruhan: <strong id="totalSeats">0</strong> kursi
                    </p>
                </div>
            </div>
            
            <!-- SECTION 4: MEDIA & KONTEN -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-image"></i>
                    Media & Konten
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="input-group">
                        <label><i class="fas fa-image text-purple-500 mr-1"></i> Upload Poster <span class="required">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <input type="file" name="poster" id="posterInput" accept="image/*" required>
                        </div>
                        <p class="helper-text">Format: JPG, PNG. Rasio 16:9 (1920x1080) lebih baik</p>
                        <div id="posterPreview" class="preview-image mt-2"></div>
                    </div>
                    
                    <div class="input-group">
                        <label><i class="fab fa-youtube text-purple-500 mr-1"></i> URL YouTube (Opsional)</label>
                        <div class="input-icon">
                            <i class="fab fa-youtube"></i>
                            <input type="url" name="youtube_url" value="{{ old('youtube_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                        </div>
                        <p class="helper-text">Untuk menampilkan video trailer konser</p>
                    </div>
                    
                    <div class="input-group md:col-span-2">
                        <label><i class="fas fa-align-left text-purple-500 mr-1"></i> Deskripsi Konser</label>
                        <div class="input-icon">
                            <i class="fas fa-edit"></i>
                            <textarea name="description" rows="4" placeholder="Berikan info lengkap tentang konser, artis, dan pengalaman yang akan didapatkan...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    
                    <div class="input-group md:col-span-2">
                        <label><i class="fas fa-users text-purple-500 mr-1"></i> Line-up / Pengisi Acara</label>
                        <div class="input-icon">
                            <i class="fas fa-microphone"></i>
                            <textarea name="lineup" rows="3" placeholder="Tulus&#10;Andi Rianto&#10;Orkestra Gita Bahana">{{ old('lineup', "Tulus\nAndi Rianto\nOrkestra Gita Bahana") }}</textarea>
                        </div>
                        <p class="helper-text">Satu baris satu artis/pengisi acara</p>
                    </div>
                </div>
            </div>
            
            <!-- BUTTON SUBMIT -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <a href="{{ route('admin.concerts.index') }}" class="btn-back flex items-center gap-2 transition group">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition"></i> Kembali
                </a>
                <button type="submit" class="btn-submit flex items-center gap-2">
                    <i class="fas fa-cloud-upload-alt"></i>
                    Publish Konser Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Hitung total kapasitas kursi
    function updateTotalSeats() {
        const vipSeats = parseInt(document.querySelector('input[name="vip_seats"]')?.value) || 0;
        const festivalSeats = parseInt(document.querySelector('input[name="festival_seats"]')?.value) || 0;
        const tribunSeats = parseInt(document.querySelector('input[name="tribun_seats"]')?.value) || 0;
        const total = vipSeats + festivalSeats + tribunSeats;
        document.getElementById('totalSeats').textContent = total.toLocaleString('id-ID');
    }
    
    document.querySelector('input[name="vip_seats"]')?.addEventListener('input', updateTotalSeats);
    document.querySelector('input[name="festival_seats"]')?.addEventListener('input', updateTotalSeats);
    document.querySelector('input[name="tribun_seats"]')?.addEventListener('input', updateTotalSeats);
    updateTotalSeats();
    
    // Preview poster
    const posterInput = document.getElementById('posterInput');
    const posterPreview = document.getElementById('posterPreview');
    
    posterInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                posterPreview.innerHTML = `<img src="${event.target.result}" alt="Preview Poster" class="rounded-lg border-2 border-purple-300 shadow-md">`;
                posterPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection