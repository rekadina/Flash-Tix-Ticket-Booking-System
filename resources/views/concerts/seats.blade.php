@extends('layouts.app')

@section('title', 'Pilih Kursi - ' . ($concert->name ?? 'Flash-Tix'))

@section('content')
<style>
    /* ============================================ */
    /* LIGHT MODE THEME - MODERN & FRESH */
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
    
    .cyber-bg {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
    }
    
    .stage-glow {
        background: linear-gradient(to top, rgba(124, 58, 237, 0.15), rgba(124, 58, 237, 0.05));
        border-top: 4px solid #7c3aed;
        box-shadow: 0 0 20px rgba(124, 58, 237, 0.2);
    }
    
    /* Step Progress */
    .step-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        z-index: 1;
    }
    
    .step-icon {
        width: 48px;
        height: 48px;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: all 0.3s ease;
        z-index: 2;
        position: relative;
    }
    
    .step-icon.active {
        background: linear-gradient(135deg, #7c3aed, #db2777);
        border-color: #7c3aed;
        box-shadow: 0 0 20px rgba(124, 58, 237, 0.5);
        color: white;
    }
    
    .step-icon.completed {
        background: #10b981;
        border-color: #10b981;
        color: white;
    }
    
    .step-label {
        margin-top: 8px;
        font-size: 11px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .step-label.active {
        color: #7c3aed;
    }
    
    .step-label.completed {
        color: #10b981;
    }
    
    .progress-line {
        position: absolute;
        top: 24px;
        left: calc(50% + 24px);
        width: calc(100% - 48px);
        height: 2px;
        background: #e5e7eb;
        z-index: 0;
    }
    
    .progress-line-fill {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background: linear-gradient(90deg, #7c3aed, #db2777);
        width: 0%;
        transition: width 0.5s ease;
    }
    
    .seat {
        width: 42px;
        height: 42px;
        border-radius: 12px 12px 16px 16px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 12px;
        position: relative;
    }
    
    .seat.available {
        background: linear-gradient(135deg, #e8eaf6, #c5cae9);
        border: 2px solid #9fa8da;
        color: #3949ab;
    }
    
    .seat.available:hover {
        transform: translateY(-6px) scale(1.05);
        background: linear-gradient(135deg, #c5cae9, #9fa8da);
        border-color: #7c3aed;
        box-shadow: 0 8px 20px rgba(124, 58, 237, 0.3);
    }
    
    .seat.selected {
        background: linear-gradient(135deg, #7c3aed, #db2777);
        box-shadow: 0 0 20px rgba(124, 58, 237, 0.5);
        border: 2px solid white;
        color: white;
        transform: scale(1.05);
    }
    
    .seat.selected::after {
        content: '✓';
        position: absolute;
        top: -8px;
        right: -8px;
        background: #10b981;
        color: white;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
   .seat.booked {
        background: linear-gradient(135deg, #fee2e2, #fca5a5) !important; /* Merah Muda ke Merah Terang */
        border: 2px solid #ef4444 !important; /* Border Merah Tegas */
        cursor: not-allowed;
        color: #b91c1c !important; /* Angka Merah Tua */
        opacity: 1; /* Agar warna merahnya terlihat jelas */
        text-decoration: none; 
    }
    
    .info-card-light {
        background: white;
        border-radius: 20px;
        padding: 12px 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }
    
    .timer-number {
        font-size: 28px;
        font-weight: 800;
        font-family: monospace;
        background: linear-gradient(135deg, #f43f5e, #ec4899);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .legend-dot {
        width: 24px;
        height: 24px;
        border-radius: 8px;
        display: inline-block;
        transition: all 0.2s ease;
    }
    
    .legend-dot.available { background: linear-gradient(135deg, #e8eaf6, #c5cae9); border: 2px solid #9fa8da; }
    .legend-dot.selected { background: linear-gradient(135deg, #7c3aed, #db2777); }
    .legend-dot.booked { background: linear-gradient(135deg, #fee2e2, #fca5a5); 
        border: 2px solid #ef4444; 
    }
    .floating-bar {
        background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(124, 58, 237, 0.3);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }
    
    .btn-confirm {
        background: linear-gradient(135deg, #7c3aed, #db2777);
        transition: all 0.3s ease;
        border-radius: 16px;
    }
    
    .btn-confirm:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
    }
    
    .row-label {
        font-weight: 800;
        font-size: 14px;
        background: linear-gradient(135deg, #7c3aed, #ec4899);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        width: 32px;
        text-align: center;
    }
    
    .category-badge {
        background: linear-gradient(135deg, #7c3aed, #db2777);
        color: white;
        padding: 8px 20px;
        border-radius: 40px;
        font-weight: bold;
        box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
    }
    
    .category-link {
        transition: all 0.3s ease;
    }
    
    .category-link.active {
        background: linear-gradient(135deg, #7c3aed, #db2777);
        color: white;
        box-shadow: 0 4px 10px rgba(124, 58, 237, 0.2);
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    @media (max-width: 768px) {
        .step-icon { width: 40px; height: 40px; font-size: 16px; }
        .progress-line { top: 20px; }
        .seat { width: 34px; height: 34px; font-size: 10px; }
        .timer-number { font-size: 20px; }
        .row-label { width: 28px; font-size: 11px; }
    }
    
    @media (max-width: 640px) {
        .seat { width: 28px; height: 28px; font-size: 8px; }
    }
</style>

<div class="cyber-bg py-12 px-4">
    <div class="max-w-7xl mx-auto">
        
        <!-- STEP PROGRESS - SAMA DENGAN FORM.BLADE -->
        <div class="max-w-2xl mx-auto mb-12 relative">
            <div class="flex justify-between items-start relative">
                <!-- Step 1: Pilih Kursi (Active) -->
                <div class="step-item">
                    <div class="step-icon active">
                        <i class="fas fa-chair"></i>
                    </div>
                    <span class="step-label active">Pilih Kursi</span>
                </div>
                
                <!-- Step 2: Detail Pemesan -->
                <div class="step-item">
                    <div class="step-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="step-label">Detail Pemesan</span>
                </div>
                
                <!-- Step 3: Pembayaran -->
                <div class="step-item">
                    <div class="step-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <span class="step-label">Pembayaran</span>
                </div>
                
                <!-- Progress Line -->
                <div class="progress-line">
                    <div class="progress-line-fill" style="width: 0%;"></div>
                </div>
            </div>
        </div>
        
        <!-- HEADER PREMIUM -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 bg-purple-100 rounded-full px-5 py-2 mb-5">
                <i class="fas fa-chair text-purple-600 text-sm"></i>
                <span class="text-purple-700 text-xs font-bold uppercase tracking-wider">SELECT YOUR SEAT</span>
                <i class="fas fa-music text-purple-600 text-sm"></i>
            </div>
            <h2 class="text-4xl md:text-5xl font-black mb-3">
                <span class="bg-gradient-to-r from-purple-600 via-pink-500 to-purple-600 bg-clip-text text-transparent">
                    PILIH KURSI
                </span>
            </h2>
            
            <div class="flex items-center justify-center gap-3 flex-wrap mt-4">
                <div class="category-badge">
                    <i class="fas fa-tag mr-2"></i> {{ $currentCategory['name'] }}
                </div>
                <span class="px-4 py-1.5 bg-pink-100 rounded-full text-pink-700 text-sm font-semibold">
                    <i class="fas fa-ticket-alt mr-1"></i> Rp {{ number_format($currentCategory['price'], 0, ',', '.') }}
                </span>
                <span class="px-4 py-1.5 bg-blue-100 rounded-full text-blue-700 text-sm font-semibold">
                    <i class="fas fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($concert->date)->format('d M Y') }}
                </span>
            </div>
        </div>
        
        <!-- TIMER & INFO SECTION -->
        <div class="flex justify-between items-center mb-8 flex-wrap gap-4">
            <div class="flex gap-4">
                <div class="info-card-light flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="fas fa-hourglass-half text-red-500"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold">Waktu Tersisa</p>
                        <span class="timer-number text-2xl" id="timer">15:00</span>
                    </div>
                </div>
                <div class="info-card-light flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-chair text-purple-500"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold">Kursi Dipilih</p>
                        <p class="text-2xl font-black text-purple-600" id="selectedCount">0</p>
                    </div>
                </div>
            </div>
            
            <!-- MENU GANTI KATEGORI -->
            <div class="flex gap-2">
                @foreach($allCategories as $cat)
                <a href="{{ route('concerts.seats', $concert->_id ?? $concert->id) }}?category={{ urlencode($cat['name']) }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium transition-all category-link {{ $currentCategory['name'] == $cat['name'] ? 'active' : 'bg-gray-200 text-gray-600 hover:bg-purple-100' }}">
                    {{ $cat['name'] }}
                </a>
                @endforeach
            </div>
        </div>
        
        <!-- STAGE VISUAL -->
        <div class="max-w-4xl mx-auto mb-12">
            <div class="stage-glow h-28 rounded-t-full flex items-center justify-center relative">
                <div class="absolute -top-8 left-1/2 -translate-x-1/2 w-40 h-1 bg-gradient-to-r from-transparent via-purple-500 to-transparent"></div>
                <div class="flex flex-col items-center">
                    <i class="fas fa-microphone-alt text-purple-400 text-2xl mb-1"></i>
                    <span class="text-xs font-bold tracking-[0.3em] text-purple-600 uppercase">MAIN STAGE</span>
                </div>
                <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-64 h-0.5 bg-gradient-to-r from-transparent via-purple-500 to-transparent"></div>
            </div>
        </div>
        
        <!-- SEAT GRID -->
        <div class="bg-white/50 backdrop-blur-sm rounded-3xl p-6 mb-8 shadow-sm border border-gray-100">
            <div class="text-center mb-4">
                <p class="text-sm text-gray-500">
                    <i class="fas fa-info-circle text-purple-500 mr-1"></i> 
                    Denah kursi untuk kategori <strong class="text-purple-600">{{ $currentCategory['name'] }}</strong>
                </p>
            </div>
            
            <div class="flex flex-col gap-3 items-center overflow-x-auto pb-4">
                @foreach($currentCategory['rows'] as $row)
                <div class="flex gap-2 md:gap-3 items-center">
                    <span class="row-label">{{ $row }}</span>
                    
                    @for($i = 1; $i <= $currentCategory['cols']; $i++)
                        @php 
                            $seatId = $row . $i; 
                            $isBooked = in_array($seatId, $bookedSeats); 
                        @endphp
                        <div class="seat {{ $isBooked ? 'booked' : 'available' }}" 
                             @if(!$isBooked) onclick="toggleSeat('{{ $seatId }}', this)" @endif
                             id="seat-{{ $seatId }}"
                             data-seat="{{ $seatId }}">
                            <span class="seat-number">{{ $i }}</span>
                        </div>
                    @endfor
                    
                    <span class="row-label text-right">{{ $row }}</span>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-4 text-xs text-gray-400">
                <i class="fas fa-mouse-pointer mr-1"></i> Klik pada kursi untuk memilih | Total {{ count($currentCategory['rows']) * $currentCategory['cols'] }} kursi
            </div>
        </div>
        
        <!-- LEGEND -->
        <div class="flex justify-center gap-8 mb-8 flex-wrap">
            <div class="legend-item flex items-center gap-3">
                <div class="legend-dot available"></div>
                <span class="text-sm text-gray-600">Tersedia</span>
            </div>
            <div class="legend-item flex items-center gap-3">
                <div class="legend-dot selected"></div>
                <span class="text-sm text-gray-600">Pilihan Anda</span>
            </div>
            <div class="legend-item flex items-center gap-3">
                <div class="legend-dot booked"></div>
                <span class="text-sm text-gray-600">Terisi / Dipesan</span>
            </div>
            <div class="legend-item flex items-center gap-3">
                <i class="fas fa-info-circle text-purple-500 text-sm"></i>
                <span class="text-sm text-gray-500">Maksimal 10 tiket</span>
            </div>
        </div>
        
        <!-- FLOATING BOTTOM BAR -->
        <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[95%] max-w-2xl z-50">
            <div class="floating-bar rounded-2xl p-4 flex flex-wrap items-center justify-between gap-3 shadow-2xl">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                        <i class="fas fa-chair text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">KURSI TERPILIH</p>
                        <p id="displaySeats" class="text-base font-bold text-gray-800 max-w-[200px] truncate">-</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 uppercase font-bold">TOTAL PEMBAYARAN</p>
                    <p class="text-2xl font-black bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent" id="totalPrice">Rp 0</p>
                </div>
                <button id="btnConfirm" disabled onclick="confirmBooking()" 
                        class="btn-confirm text-white px-8 py-3 rounded-xl font-bold text-sm transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-2 shadow-md">
                    <i class="fas fa-check-circle"></i> KONFIRMASI
                    <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
        </div>
        
    </div>
</div>

<script>
    // ============================================
    // VARIABLES
    // ============================================
    var selectedSeats = [];
    var timeLeft = 15 * 60;
    var timerInterval;
    var pricePerSeat = {{ $currentCategory['price'] }};
    var concertId = "{{ $concert->_id ?? $concert->id }}";
    var currentCategoryName = "{{ $currentCategory['name'] }}";
    var concertName = "{{ $concert->name ?? 'Konser Flash-Tix' }}";
    
    // ============================================
    // CEK DAN RESET JIKA KATEGORI BERUBAH
    // ============================================
    var savedCategory = sessionStorage.getItem('selected_category');
    if (savedCategory && savedCategory !== currentCategoryName) {
        sessionStorage.removeItem('selected_seats');
        sessionStorage.removeItem('selected_category');
        sessionStorage.removeItem('selected_price');
        sessionStorage.removeItem('selected_total');
        sessionStorage.removeItem('concert_id');
        selectedSeats = [];
    }
    
    // ============================================
    // TIMER FUNCTION
    // ============================================
    function updateTimer() {
        var minutes = Math.floor(timeLeft / 60);
        var seconds = timeLeft % 60;
        var timerElement = document.getElementById('timer');
        if (timerElement) {
            timerElement.textContent = minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
        }
        
        if (timeLeft <= 120) {
            timerElement.classList.add('text-red-500');
        }
        
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            alert('⏰ Waktu habis! Silakan pilih kursi kembali.');
            window.location.href = "{{ route('concerts.show', $concert->_id ?? $concert->id) }}";
        }
        timeLeft--;
    }
    
    timerInterval = setInterval(updateTimer, 1000);
    
    // ============================================
    // TOGGLE SEAT FUNCTION
    // ============================================
    function toggleSeat(seatId, element) {
        if (element.classList.contains('booked')) {
            element.style.transform = 'scale(0.95)';
            setTimeout(function() { element.style.transform = ''; }, 200);
            return;
        }
        
        if (selectedSeats.includes(seatId)) {
            selectedSeats = selectedSeats.filter(function(s) { return s !== seatId; });
            element.classList.remove('selected');
            element.style.transform = 'scale(0.95)';
            setTimeout(function() { element.style.transform = ''; }, 200);
        } else {
            if (selectedSeats.length >= 10) {
                alert('⚠️ Maksimal pemesanan 10 tiket per transaksi!');
                var bar = document.querySelector('.floating-bar');
                bar.style.animation = 'shake 0.3s ease';
                setTimeout(function() { bar.style.animation = ''; }, 300);
                return;
            }
            selectedSeats.push(seatId);
            element.classList.add('selected');
            element.style.transform = 'scale(1.1)';
            setTimeout(function() { element.style.transform = 'scale(1.05)'; }, 150);
        }
        
        updateUI();
    }
    
    // ============================================
    // UPDATE UI FUNCTION
    // ============================================
    function updateUI() {
        var total = selectedSeats.length * pricePerSeat;
        var formattedTotal = 'Rp ' + total.toLocaleString('id-ID');
        
        document.getElementById('displaySeats').textContent = selectedSeats.length > 0 ? selectedSeats.join(', ') : '-';
        document.getElementById('selectedCount').textContent = selectedSeats.length;
        document.getElementById('totalPrice').textContent = formattedTotal;
        
        var confirmBtn = document.getElementById('btnConfirm');
        confirmBtn.disabled = selectedSeats.length === 0;
        
        if (selectedSeats.length > 0) {
            sessionStorage.setItem('selected_seats', JSON.stringify(selectedSeats));
            sessionStorage.setItem('selected_category', currentCategoryName);
            sessionStorage.setItem('selected_price', pricePerSeat);
            sessionStorage.setItem('selected_total', total);
            sessionStorage.setItem('concert_id', concertId);
        }
    }
    
    // ============================================
    // CONFIRM BOOKING FUNCTION
    // ============================================
    function confirmBooking() {
        if (selectedSeats.length === 0) return;
        
        var totalPayment = selectedSeats.length * pricePerSeat;
        
        var bookingData = {
            concert_id: concertId,
            concert_name: concertName,
            category: currentCategoryName,
            seats: selectedSeats,
            quantity: selectedSeats.length,
            price_per_seat: pricePerSeat,
            total: totalPayment,
            timestamp: new Date().toISOString()
        };
        
        localStorage.setItem('flash_tix_booking', JSON.stringify(bookingData));
        sessionStorage.setItem('selected_seats', JSON.stringify(selectedSeats));
        sessionStorage.setItem('selected_category', currentCategoryName);
        sessionStorage.setItem('selected_quantity', selectedSeats.length);
        sessionStorage.setItem('selected_total', totalPayment);
        sessionStorage.setItem('concert_id', concertId);
        
        var btn = document.getElementById('btnConfirm');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> MEMPROSES...';
        btn.disabled = true;
        
        setTimeout(function() {
            window.location.href = "{{ route('booking.form', $concert->_id ?? $concert->id) }}";
        }, 500);
    }
    
    // ============================================
    // RESTORE SELECTED SEATS FROM SESSION (on refresh)
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        var savedCategoryCheck = sessionStorage.getItem('selected_category');
        if (savedCategoryCheck === currentCategoryName) {
            var savedSeats = sessionStorage.getItem('selected_seats');
            if (savedSeats && savedSeats !== '[]') {
                var seats = JSON.parse(savedSeats);
                seats.forEach(function(seatId) {
                    var seatElement = document.getElementById('seat-' + seatId);
                    if (seatElement && !seatElement.classList.contains('booked')) {
                        seatElement.classList.add('selected');
                        selectedSeats.push(seatId);
                    }
                });
                updateUI();
            }
        }
    });
</script>
@endsection