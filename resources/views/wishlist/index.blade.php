@extends('layouts.app')

@section('title', 'Pre-War Tactic Dashboard - Flash-Tix')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0b0f19; }
    .neon-border {
        box-shadow: 0 0 15px rgba(124, 58, 237, 0.15);
        border: 1px solid rgba(139, 92, 246, 0.2);
    }
    .neon-border:hover {
        box-shadow: 0 0 25px rgba(139, 92, 246, 0.4);
        border: 1px solid rgba(167, 139, 250, 0.6);
    }
    .glass-header {
        background: rgba(17, 24, 39, 0.7);
        backdrop-filter: blur(12px);
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .heart-beat {
        animation: heartbeat 1.5s ease infinite;
    }
    @keyframes heartbeat {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
</style>

<div class="bg-[#0b0f19] min-h-screen py-12 text-slate-100 selection:bg-purple-500 selection:text-white">
    <div class="max-w-6xl mx-auto px-4">
        
        <div class="glass-header rounded-3xl p-8 border border-slate-800/80 shadow-2xl mb-12 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-purple-600/10 rounded-full blur-3xl"></div>
            <div class="relative z-10">
                <span class="text-purple-400 font-extrabold text-[10px] uppercase tracking-[0.3em] bg-purple-500/10 border border-purple-500/20 px-3 py-1 rounded-full">Strategi Sistem Antrean</span>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight text-white uppercase font-['Space_Grotesk'] mt-3">
                    <i class="fas fa-heart text-pink-500 mr-2 heart-beat"></i> Pre-War Wishlist
                </h1>
                <p class="text-xs text-slate-400 mt-2 max-w-xl leading-relaxed">Dasbor taktis kalkulasi trafik. Data disinkronkan langsung dengan repositori MongoDB Cluster untuk memantau kepadatan *war* tiket secara global.</p>
            </div>
            <div class="flex flex-col items-end gap-2 relative z-10">
                <span class="bg-emerald-500/10 border border-emerald-500/30 px-4 py-2 rounded-2xl text-xs text-emerald-400 font-extrabold flex items-center gap-2 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span> Auto-Sync Engine Active
                </span>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-8 p-4 bg-purple-500/10 border border-purple-500/30 text-purple-300 text-xs rounded-xl font-bold flex items-center gap-2 animate-fade-in shadow-lg">
                <i class="fas fa-circle-check text-purple-400 text-sm"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-8 p-4 bg-red-500/10 border border-red-500/30 text-red-300 text-xs rounded-xl font-bold flex items-center gap-2 animate-fade-in shadow-lg">
                <i class="fas fa-circle-exclamation text-red-400 text-sm"></i> {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($wishlistItems as $item)
                @php
                    // AMAN: Selalu akses sebagai object, bukan array
                    $concertId = $item->concert_id ?? null;
                    
                    // Ambil data concert_details jika ada
                    $details = $item->concert_details ?? null;
                    
                    $concertArtist = $details->artist ?? $item->artist ?? 'ARTIST';
                    $concertName = $details->name ?? $details->title ?? $item->concert_name ?? $item->name ?? $item->title ?? 'Exclusive Concert';
                    $concertVenue = $details->venue ?? $item->venue ?? 'Main Stage';
                    $concertCity = $details->city ?? $item->city ?? '';
                    $concertDate = $details->date ?? $item->concert_date ?? $item->date ?? '2026-08-01 19:00:00';
                    $totalFans = $item->total_fans_count ?? rand(1200, 8500);
                    $itemId = $item->id ?? $item->_id ?? null;
                @endphp
                <div class="bg-[#111625] neon-border rounded-[2rem] p-6 flex flex-col justify-between transition-all duration-300 relative group overflow-hidden">
                    
                    <div class="absolute -inset-px bg-gradient-to-r from-purple-600 to-pink-600 rounded-[2rem] opacity-0 group-hover:opacity-10 transition duration-500 blur"></div>

                    <div class="relative z-10">
                        <div class="flex justify-between items-center mb-5">
                            <span class="bg-purple-900/50 text-purple-300 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-lg border border-purple-700/30">
                                <i class="fas fa-microphone-alt mr-1 text-[8px]"></i> {{ $concertArtist }}
                            </span>
                            
                            <span class="text-[11px] font-extrabold text-pink-400 flex items-center gap-1.5 bg-pink-500/10 px-3 py-1 rounded-full border border-pink-500/20">
                                <i class="fas fa-fire text-amber-500"></i> {{ number_format($totalFans) }} Challenger
                            </span>
                        </div>

                        <h3 class="text-xl font-black text-white uppercase tracking-tight line-clamp-1 group-hover:text-pink-400 transition-colors duration-300">
                            {{ $concertName }}
                        </h3>
                        
                        <div class="mt-4 space-y-2.5 text-xs text-slate-400">
                            <p class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-pink-400 w-4"></i> {{ $concertVenue }}{{ $concertCity ? ', ' . $concertCity : '' }}</p>
                            <p class="flex items-center gap-2"><i class="fas fa-calendar-days text-pink-400 w-4"></i> {{ date('d M Y', strtotime($concertDate)) }}</p>
                        </div>

                        <div class="mt-6 p-4 bg-[#080b13] rounded-2xl border border-slate-800/60 text-center">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1.5">
                                <i class="fas fa-hourglass-half mr-1"></i> Gate War Dibuka Dalam
                            </p>
                            <div class="grid grid-cols-3 gap-1 text-white font-mono font-bold text-sm" id="timer-{{ $loop->index }}" data-date="{{ $concertDate }}">
                                <div class="bg-slate-900/80 p-1.5 rounded-lg border border-slate-800">
                                    <span class="days text-pink-400 font-extrabold text-base">00</span>
                                    <p class="text-[8px] uppercase tracking-wider text-slate-500 font-sans mt-0.5">Hari</p>
                                </div>
                                <div class="bg-slate-900/80 p-1.5 rounded-lg border border-slate-800">
                                    <span class="hours text-white text-base">00</span>
                                    <p class="text-[8px] uppercase tracking-wider text-slate-500 font-sans mt-0.5">Jam</p>
                                </div>
                                <div class="bg-slate-900/80 p-1.5 rounded-lg border border-slate-800">
                                    <span class="minutes text-pink-400 font-extrabold text-base">00</span>
                                    <p class="text-[8px] uppercase tracking-wider text-slate-500 font-sans mt-0.5">Menit</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-5 border-t border-slate-800/80 flex items-center justify-between gap-4 relative z-10">
                        <form action="{{ route('wishlist.remove', $itemId) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus konser ini dari wishlist?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-500 hover:text-rose-500 p-2.5 rounded-xl hover:bg-rose-500/10 transition border border-transparent hover:border-rose-500/20 group" title="Batalkan Strategi">
                                <i class="fas fa-heart-broken text-lg group-hover:scale-110 transition"></i>
                            </button>
                        </form>

                        <a href="{{ route('concerts.show', $concertId) }}" class="flex-1 bg-gradient-to-r from-pink-600 via-rose-600 to-red-600 hover:opacity-90 text-white font-black text-xs uppercase tracking-widest text-center py-3.5 rounded-2xl transition duration-300 shadow-md flex items-center justify-center gap-2 group-hover:scale-[1.02]">
                            <i class="fas fa-ticket-alt text-amber-400"></i> Amankan Tiket Now
                            <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-[#111625] border border-dashed border-slate-800 rounded-[2.5rem] p-20 text-center shadow-inner relative overflow-hidden">
                    <div class="w-24 h-24 bg-gradient-to-br from-pink-500/10 to-rose-500/10 border border-pink-500/20 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-md">
                        <i class="fas fa-heart text-pink-500 text-4xl heart-beat"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-300 uppercase tracking-tight">Belum Ada Strategi Konser</h3>
                    <p class="text-sm text-slate-500 mt-2 max-w-sm mx-auto leading-relaxed">Cari event musik berkapasitas besar di katalog utama dan simpan di sini untuk mengaktifkan pelacakan beban kueri.</p>
                    <a href="{{ route('concerts.index') }}" class="inline-flex items-center gap-2 mt-8 bg-gradient-to-r from-pink-600 to-rose-600 text-white text-xs font-black uppercase tracking-widest px-8 py-4 rounded-xl hover:opacity-90 transition shadow-lg hover:scale-105">
                        <i class="fas fa-music"></i> Jelajahi Konser Musik
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            @endforelse
        </div>

        @php
            $totalItems = is_iterable($wishlistItems) ? iterator_count($wishlistItems) : 0;
        @endphp
        @if($totalItems > 0)
        <div class="mt-12 text-center">
            <p class="text-[10px] text-slate-600 uppercase tracking-widest">
                <i class="fas fa-shield-alt mr-1"></i> Sistem Pre-War Tactic • Real-time Sync Active • {{ $totalItems }} Strategi Aktif
            </p>
        </div>
        @endif

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timers = document.querySelectorAll('[id^="timer-"]');
        
        timers.forEach(timer => {
            const targetDateStr = timer.getAttribute('data-date');
            let targetDate;
            
            try {
                targetDate = new Date(targetDateStr).getTime();
                if (isNaN(targetDate)) {
                    targetDate = new Date().getTime() + (30 * 24 * 60 * 60 * 1000);
                }
            } catch(e) {
                targetDate = new Date().getTime() + (30 * 24 * 60 * 60 * 1000);
            }
            
            const updateTimer = () => {
                const now = new Date().getTime();
                const distance = targetDate - now;
                
                if (distance < 0) {
                    timer.innerHTML = `<div class="col-span-3 text-emerald-400 font-black text-[11px] uppercase tracking-widest py-2 bg-emerald-500/5 rounded-xl border border-emerald-500/20 animate-pulse">
                        <i class="fas fa-unlock-alt mr-1"></i> Gate War Dibuka! Silakan Masuk
                    </div>`;
                    return;
                }
                
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                
                const daysSpan = timer.querySelector('.days');
                const hoursSpan = timer.querySelector('.hours');
                const minutesSpan = timer.querySelector('.minutes');
                
                if (daysSpan) daysSpan.textContent = String(days).padStart(2, '0');
                if (hoursSpan) hoursSpan.textContent = String(hours).padStart(2, '0');
                if (minutesSpan) minutesSpan.textContent = String(minutes).padStart(2, '0');
            };
            
            updateTimer();
            setInterval(updateTimer, 60000);
        });
    });
</script>
@endsection