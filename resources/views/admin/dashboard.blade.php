@extends('layouts.app')

@section('title', 'Command Center - Flash-Tix Admin')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700;900&family=Plus+Jakarta+Sans:wght@400;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background-color: #050505; font-family: 'Plus Jakarta Sans', sans-serif; }
    
    .glass-card {
        background: rgba(17, 24, 39, 0.6);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    }
    
    .neon-border-green:hover {
        border-color: rgba(16, 185, 129, 0.5);
        box-shadow: 0 0 25px rgba(16, 185, 129, 0.2);
    }
    
    .neon-border-purple:hover {
        border-color: rgba(139, 92, 246, 0.5);
        box-shadow: 0 0 25px rgba(139, 92, 246, 0.2);
    }
    
    .neon-border-blue:hover {
        border-color: rgba(59, 130, 246, 0.5);
        box-shadow: 0 0 25px rgba(59, 130, 246, 0.2);
    }

    .digital-clock {
        font-family: 'JetBrains Mono', monospace;
    }
</style>

<div class="min-h-screen bg-[#050505] py-8 text-slate-200 relative overflow-hidden">
    
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        
        <div class="glass-card rounded-[2rem] p-8 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-l-4 border-l-purple-500">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(239,68,68,0.7)]"></div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">System Online</span>
                </div>
                <h1 class="text-4xl font-black uppercase tracking-tight text-white font-['Space_Grotesk']">
                    Command Center
                </h1>
                <p class="text-sm text-slate-400 mt-2">Pusat kendali admin Flash-Tix. Pantau metrik penjualan dan operasional gerbang masuk.</p>
            </div>
            
            <div class="bg-black/50 border border-slate-800 rounded-2xl px-6 py-4 text-right">
                <p class="text-[10px] text-slate-500 uppercase tracking-widest mb-1 font-bold">Waktu Server (WIB)</p>
                <p class="digital-clock text-2xl font-bold text-purple-400 tracking-wider" id="server-clock">00:00:00</p>
                <p class="text-xs text-slate-500 mt-1" id="server-date">Senin, 01 Jan 2026</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="glass-card rounded-[2rem] p-8 flex items-center justify-between relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 text-8xl text-purple-500/5 group-hover:scale-110 transition duration-500"><i class="fas fa-ticket-alt"></i></div>
                <div>
                    <p class="text-xs font-black text-purple-400 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <i class="fas fa-chart-line"></i> Total Tiket Terjual
                    </p>
                    <p class="text-6xl font-black text-white font-['Space_Grotesk']">{{ $totalTickets ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-2">Seluruh transaksi berstatus sukses</p>
                </div>
                <div class="w-20 h-20 bg-purple-500/10 rounded-full border border-purple-500/20 flex items-center justify-center text-purple-400 text-3xl shadow-[0_0_30px_rgba(168,85,247,0.15)]">
                    <i class="fas fa-receipt"></i>
                </div>
            </div>
            
            <div class="glass-card rounded-[2rem] p-8 flex items-center justify-between relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 text-8xl text-emerald-500/5 group-hover:scale-110 transition duration-500"><i class="fas fa-user-check"></i></div>
                <div>
                    <p class="text-xs font-black text-emerald-400 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <i class="fas fa-door-open"></i> Total Check-In
                    </p>
                    <p class="text-6xl font-black text-white font-['Space_Grotesk']">{{ $checkedIn ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-2">Pengunjung yang sudah scan di Gate</p>
                </div>
                <div class="w-20 h-20 bg-emerald-500/10 rounded-full border border-emerald-500/20 flex items-center justify-center text-emerald-400 text-3xl shadow-[0_0_30px_rgba(16,185,129,0.15)]">
                    <i class="fas fa-qrcode"></i>
                </div>
            </div>
        </div>

        <h2 class="text-sm font-black text-slate-500 uppercase tracking-widest mb-4 ml-2">Modul Operasional</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <a href="{{ route('admin.scanner.index') }}" class="glass-card neon-border-green rounded-[2rem] p-8 transition-all duration-300 group relative overflow-hidden flex flex-col h-full">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                
                <div class="flex justify-between items-start mb-6 relative z-10">
                    <div class="w-16 h-16 bg-emerald-500/20 rounded-2xl flex items-center justify-center text-emerald-400 text-2xl border border-emerald-500/30 group-hover:scale-110 transition duration-300">
                        <i class="fas fa-camera"></i>
                    </div>
                    <span class="bg-emerald-500/20 text-emerald-400 text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-widest flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span> Live Scan
                    </span>
                </div>
                <h3 class="text-2xl font-black mb-2 text-white font-['Space_Grotesk'] relative z-10 group-hover:text-emerald-400 transition">Gate Scanner</h3>
                <p class="text-sm text-slate-400 leading-relaxed relative z-10 flex-grow">Aktifkan kamera laptop untuk memindai QR Code e-tiket pengunjung secara real-time.</p>
                <div class="mt-6 flex items-center text-emerald-400 text-xs font-bold uppercase tracking-widest relative z-10 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">
                    Buka Scanner <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            <a href="{{ route('admin.concerts.index') }}" class="glass-card neon-border-purple rounded-[2rem] p-8 transition-all duration-300 group relative overflow-hidden flex flex-col h-full">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-600/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                
                <div class="w-16 h-16 bg-purple-500/10 rounded-2xl flex items-center justify-center text-purple-400 text-2xl mb-6 border border-purple-500/20 group-hover:scale-110 transition duration-300 relative z-10">
                    <i class="fas fa-guitar"></i>
                </div>
                <h3 class="text-2xl font-black mb-2 text-white font-['Space_Grotesk'] relative z-10 group-hover:text-purple-400 transition">Katalog Konser</h3>
                <p class="text-sm text-slate-400 leading-relaxed relative z-10 flex-grow">Kelola jadwal acara, unggah poster, atur harga tiket, dan kelola database artis.</p>
                <div class="mt-6 flex items-center text-purple-400 text-xs font-bold uppercase tracking-widest relative z-10 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">
                    Kelola Konser <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            <a href="{{ route('admin.bookings.index') }}" class="glass-card neon-border-blue rounded-[2rem] p-8 transition-all duration-300 group relative overflow-hidden flex flex-col h-full">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                
                <div class="w-16 h-16 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-400 text-2xl mb-6 border border-blue-500/20 group-hover:scale-110 transition duration-300 relative z-10">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <h3 class="text-2xl font-black mb-2 text-white font-['Space_Grotesk'] relative z-10 group-hover:text-blue-400 transition">Log Transaksi</h3>
                <p class="text-sm text-slate-400 leading-relaxed relative z-10 flex-grow">Pantau alur pemesanan tiket, riwayat pembayaran Midtrans, dan status kursi.</p>
                <div class="mt-6 flex items-center text-blue-400 text-xs font-bold uppercase tracking-widest relative z-10 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">
                    Lihat Data <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

        </div>

    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'short', day: '2-digit' };
        
        document.getElementById('server-clock').textContent = now.toLocaleTimeString('id-ID', timeOptions);
        document.getElementById('server-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection