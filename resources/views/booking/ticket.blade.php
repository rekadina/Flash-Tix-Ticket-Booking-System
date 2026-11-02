@extends('layouts.app')

@section('title', 'E-Tiket Resmi - Flash-Tix')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700;900&family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Libre+Barcode+39&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { 
        background-color: #0b0f19; 
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    /* Layout Tiket Boarding Pass */
    .ticket-wrapper {
        display: flex;
        flex-direction: column;
        background: #ffffff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(124, 58, 237, 0.25);
        max-width: 900px;
        margin: 0 auto;
    }

    @media (min-width: 768px) {
        .ticket-wrapper {
            flex-direction: row;
        }
    }

    /* Bagian Kiri: Info Konser */
    .ticket-info {
        flex: 2;
        padding: 2.5rem;
        position: relative;
        background: #ffffff;
        border-right: 2px dashed #cbd5e1;
    }

    /* Bagian Kanan: QR Code & Kursi */
    .ticket-qr {
        flex: 1;
        padding: 2.5rem;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    /* Efek Potongan Kertas (Perforasi) Khas Tiket */
    .ticket-info::before, .ticket-info::after {
        content: '';
        position: absolute;
        right: -15px;
        width: 30px;
        height: 30px;
        background-color: #0b0f19;
        border-radius: 50%;
        z-index: 10;
    }
    .ticket-info::before { top: -15px; }
    .ticket-info::after { bottom: -15px; }

    /* Barcode Font untuk Estetika */
    .barcode-text {
        font-family: 'Libre Barcode 39', cursive;
        font-size: 3rem;
        color: #1e293b;
        line-height: 1;
    }

    /* Sembunyikan Navbar & Tombol Saat Masuk Mode Print PDF */
    @media print {
        body { background-color: #ffffff; }
        nav, footer, .no-print { display: none !important; }
        .ticket-wrapper { box-shadow: none; border: 1px solid #cbd5e1; }
        .ticket-info::before, .ticket-info::after { background-color: #ffffff; }
    }
</style>

<div class="min-h-screen py-12 px-4 relative">
    
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-purple-600/20 rounded-full blur-[100px] pointer-events-none no-print"></div>

    <div class="relative z-10">
        <div class="max-w-[900px] mx-auto mb-6 flex justify-between items-center no-print">
            <a href="{{ route('tiket.saya') }}" class="text-slate-400 hover:text-white flex items-center gap-2 transition font-semibold">
                <i class="fas fa-arrow-left"></i> Kembali ke Dasbor
            </a>
            <button onclick="window.print()" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white px-5 py-2.5 rounded-xl text-sm font-black uppercase tracking-widest flex items-center gap-2 transition shadow-lg shadow-purple-600/30">
                <i class="fas fa-print"></i> Cetak / Simpan PDF
            </button>
        </div>

        <div class="ticket-wrapper">
            
            <div class="ticket-info">
                
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h2 class="text-3xl font-black text-slate-900 uppercase font-['Space_Grotesk'] tracking-tighter">
                            FLASH-TIX<span class="text-purple-600">.</span>
                        </h2>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1">Official E-Ticket Manifes</p>
                    </div>
                    <div class="text-right">
                        <span class="bg-emerald-100 text-emerald-700 font-black text-[10px] uppercase tracking-widest px-3 py-1.5 rounded-lg">
                            <i class="fas fa-check-circle mr-1"></i> VALID / LUNAS
                        </span>
                    </div>
                </div>

                <div class="mb-8">
                    <p class="text-[10px] font-black text-purple-600 uppercase tracking-widest mb-1">Event Name</p>
                    <h3 class="text-3xl font-black text-slate-900 uppercase font-['Space_Grotesk'] leading-none">
                        {{ $concert->name ?? 'Konser Flash-Tix' }}
                    </h3>
                    <p class="text-sm font-bold text-slate-500 mt-2 flex items-center gap-2">
                        <i class="fas fa-microphone-alt text-purple-500"></i> {{ $concert->artist ?? 'Official Artist' }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-8 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal & Waktu</p>
                        <p class="text-sm font-bold text-slate-800">{{ date('l, d M Y', strtotime($concert->date ?? '2026-01-01')) }}</p>
                        <p class="text-xs font-bold text-slate-500 mt-0.5">{{ $concert->time ?? '19:00' }} WIB</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Lokasi (Venue)</p>
                        <p class="text-sm font-bold text-slate-800 line-clamp-1">{{ $concert->venue ?? 'Main Stadium' }}</p>
                        <p class="text-xs font-bold text-slate-500 mt-0.5">{{ $concert->city ?? 'Jakarta' }}</p>
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-6 flex justify-between items-end">
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Detail Pemesan</p>
                        <p class="text-sm font-black text-slate-800 uppercase">{{ $user->name ?? 'NAMA PEMESAN' }}</p>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">{{ $user->email ?? 'email@example.com' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Pembayaran</p>
                        <p class="text-lg font-black text-purple-600">Rp {{ number_format($booking['total_price'] ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="ticket-qr text-center">
                
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Gate Scan Area</p>
                
                @php
                    $qrData = $booking['order_id'] ?? 'FLX000';
                @endphp
                <div class="bg-white p-3 rounded-2xl shadow-sm border border-slate-200 mb-2">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&color=1e293b&data={{ urlencode($qrData) }}" alt="QR Code" class="w-32 h-32 md:w-40 md:h-40 object-contain mx-auto">
                </div>
                
                <p class="text-[11px] font-mono font-bold text-slate-500 mb-6">{{ $booking['order_id'] ?? 'FLX-00000000' }}</p>

                <div class="w-full bg-slate-900 rounded-2xl p-4 text-left relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-10 text-6xl text-white">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Kategori</p>
                    <p class="text-lg font-black text-white uppercase mb-3">{{ $booking['category'] ?? 'VIP' }}</p>
                    
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Nomor Kursi</p>
                    @php
                        $seats = is_array($booking['seats']) ? implode(', ', $booking['seats']) : ($booking['seats'] ?? 'AUTO');
                    @endphp
                    <p class="text-xl font-black text-amber-400 font-['Space_Grotesk'] leading-tight">{{ $seats }}</p>
                </div>

                <div class="mt-6 w-full overflow-hidden text-center opacity-30 select-none">
                    <p class="barcode-text">*{{ $booking['order_id'] ?? 'FLX-0000' }}*</p>
                </div>

            </div>
        </div>
        
        <p class="text-center text-xs text-slate-500 mt-8 font-medium no-print">
            <i class="fas fa-shield-alt text-purple-500 mr-1"></i> Simpan E-Tiket ini secara rahasia. Jangan membagikan QR Code ke publik.
        </p>

    </div>
</div>
@endsection