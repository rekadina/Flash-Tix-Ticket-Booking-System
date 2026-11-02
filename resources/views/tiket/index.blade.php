@extends('layouts.app')

@section('title', 'Tiket Saya - Flash-Tix')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    .welcome-banner {
        background: linear-gradient(135deg, #1e1b4b 0%, #4c1d95 50%, #be185d 100%);
        border-radius: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 35px -10px rgba(76, 29, 149, 0.4);
    }
    
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(255,255,255,0.15), transparent);
        border-radius: 50%;
    }
    
    .stat-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        border-color: #7c3aed;
        box-shadow: 0 12px 20px -12px rgba(0, 0, 0, 0.1);
    }
    
    .quick-menu {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .quick-menu:hover {
        transform: translateY(-4px);
        border-color: #7c3aed;
        box-shadow: 0 12px 20px -12px rgba(124, 58, 237, 0.15);
    }
    
    .ticket-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .ticket-card:hover {
        border-color: #7c3aed;
        box-shadow: 0 8px 20px -10px rgba(0, 0, 0, 0.1);
    }
    
    .badge-paid {
        background: #d1fae5;
        color: #047857;
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }
    
    .badge-pending {
        background: #fef3c7;
        color: #b45309;
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }
    
    .rec-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .rec-card:hover {
        transform: translateY(-4px);
        border-color: #7c3aed;
        box-shadow: 0 12px 20px -12px rgba(124, 58, 237, 0.15);
    }
    
    .rec-image {
        height: 140px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .info-panel {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .info-panel:hover {
        border-color: #7c3aed;
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .stat-number { font-size: 1.5rem; }
        .welcome-banner h1 { font-size: 1.5rem; }
    }
</style>

<div class="py-6 px-4" style="background: #f1f5f9; font-family: 'Inter', sans-serif;">
    <div class="container mx-auto max-w-7xl">
        
        <div class="welcome-banner rounded-3xl p-8 mb-8 text-white relative">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-5">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-crown text-yellow-400 text-sm"></i>
                        <span class="text-xs font-semibold uppercase tracking-wider text-purple-200">
                            Member sejak {{ Auth::user()->created_at ? Auth::user()->created_at->format('M Y') : '2026' }}
                        </span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2 tracking-tight">
                        Halo, <span class="bg-gradient-to-r from-yellow-200 to-pink-200 bg-clip-text text-transparent">{{ Auth::user()->name }}</span>!
                    </h1>
                    <p class="text-purple-100 text-sm md:text-base">Seluruh riwayat transaksi dan manajemen tiket aktif Anda berada di sini. 🎸</p>
                </div>
                <div class="bg-white/15 backdrop-blur-sm rounded-2xl px-5 py-3 border border-white/25">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-white"></i>
                        <span class="text-sm font-medium text-white">{{ now()->format('l, d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="stat-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Pesanan</p>
                        <p class="text-3xl font-bold text-gray-800">{{ number_format($totalPesanan ?? 0) }}</p>
                        <p class="text-xs text-gray-400 mt-2">Semua transaksi Anda</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Tiket Aktif</p>
                        <p class="text-3xl font-bold text-emerald-600">{{ number_format($pesananAktif ?? 0) }}</p>
                        <p class="text-xs text-gray-400 mt-2">Siap digunakan</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-emerald-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Belanja</p>
                        <p class="text-xl font-bold text-gray-800">Rp {{ number_format($totalBelanja ?? 0, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-400 mt-2">Total pengeluaran Anda</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-wallet text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <a href="/" class="quick-menu p-4 flex flex-col items-center text-center group">
                <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center mb-2 group-hover:bg-purple-600 transition">
                    <i class="fas fa-search text-xl text-purple-600 group-hover:text-white transition"></i>
                </div>
                <p class="font-semibold text-gray-800">Cari Tiket</p>
                <p class="text-xs text-gray-400">Temukan konser favorit</p>
            </a>
            
            <a href="{{ route('tiket.saya') }}" class="quick-menu p-4 flex flex-col items-center text-center group border-purple-500 shadow-sm bg-purple-50/10">
                <div class="w-14 h-14 rounded-full bg-purple-600 flex items-center justify-center mb-2">
                    <i class="fas fa-receipt text-xl text-white"></i>
                </div>
                <p class="font-semibold text-purple-700">Tiket Saya</p>
                <p class="text-xs text-purple-400">Halaman pengelolaan tiket</p>
            </a>
            
            <a href="{{ route('wishlist') }}" class="quick-menu p-4 flex flex-col items-center text-center group">
                <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center mb-2 group-hover:bg-purple-600 transition">
                    <i class="fas fa-heart text-xl text-purple-600 group-hover:text-white transition"></i>
                </div>
                <p class="font-semibold text-gray-800">Wishlist</p>
                <p class="text-xs text-gray-400">Konser impianmu</p>
            </a>
            
            <a href="#" class="quick-menu p-4 flex flex-col items-center text-center group">
                <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center mb-2 group-hover:bg-purple-600 transition">
                    <i class="fas fa-user-cog text-xl text-purple-600 group-hover:text-white transition"></i>
                </div>
                <p class="font-semibold text-gray-800">Profil Saya</p>
                <p class="text-xs text-gray-400">Kelola akun Anda</p>
            </a>
        </div>
        
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-ticket-alt text-purple-500"></i> Tiket Aktif
                    </h2>
                    <p class="text-xs text-gray-500">Tiket yang siap digunakan untuk check-in masuk konser</p>
                </div>
            </div>
            
            @if(isset($activeTickets) && count($activeTickets) > 0)
                <div class="grid grid-cols-1 gap-4">
                    @foreach($activeTickets as $ticket)
                    <div class="ticket-card p-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="badge-paid"><i class="fas fa-check-circle text-xs"></i> SUCCESS</span>
                                <span class="text-xs text-gray-400">#{{ $ticket->order_id ?? 'FLX001' }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $ticket->concert_name ?? 'Konser Musik' }}</h3>
                            <p class="text-sm text-gray-500">Kategori Kursi: <strong class="text-purple-600">{{ $ticket->category ?? 'TRIBUN' }}</strong></p>
                            <div class="flex flex-wrap gap-4 mt-2 text-sm text-gray-500">
                                <span><i class="fas fa-map-marker-alt mr-1 text-purple-500"></i> {{ $ticket->venue ?? 'Main Hall' }}, {{ $ticket->city ?? 'Jakarta' }}</span>
                                <span><i class="fas fa-calendar mr-1 text-purple-500"></i> {{ $ticket->date ?? '2026' }}</span>
                                <span><i class="fas fa-clock mr-1 text-purple-500"></i> {{ $ticket->time ?? '19:00' }} WIB</span>
                                <span><i class="fas fa-chair mr-1 text-purple-500"></i> Kursi: {{ is_array($ticket->seats) ? implode(', ', $ticket->seats) : $ticket->seats }}</span>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            {{-- FIX SYSTEM: Diubah dari <button onclick="alert()"> menjadi <a href="..."> --}}
                            <a href="{{ route('ticket.show', $ticket->order_id ?? $ticket->id) }}" class="bg-purple-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-purple-700 transition shadow-sm flex items-center justify-center">
                                <i class="fas fa-qrcode mr-2"></i> Cetak E-Tiket
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="ticket-card p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-ticket-alt text-2xl text-gray-300"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Belum ada tiket aktif berskala sukses</p>
                    <p class="text-gray-400 text-sm mt-1">Yuk, lakukan pesanan tiket konser di beranda utama!</p>
                    <a href="/" class="inline-block mt-4 text-purple-600 text-sm font-semibold">Cari Konser Terkini →</a>
                </div>
            @endif
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            
            <div class="lg:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-receipt text-purple-500"></i> Log Transaksi Masuk
                        </h2>
                        <p class="text-xs text-gray-500">Riwayat sinkronisasi pemesanan tiket Anda dari database</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                    @if(isset($recentOrders) && count($recentOrders) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Konser</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Order ID</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Total</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($recentOrders as $order)
                                    <tr class="hover:bg-purple-50/30 transition">
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-gray-800">{{ $order->concert_name ?? 'Flash-Tix Concert' }}</p>
                                            <p class="text-xs text-purple-600 font-medium mt-0.5">{{ $order->category ?? 'TRIBUN' }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 text-xs font-mono font-bold">{{ $order->order_id }}</td>
                                        <td class="px-6 py-4 font-bold text-gray-800">Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                            @php $status = strtolower($order->status ?? 'pending'); @endphp
                                            @if($status == 'paid' || $status == 'success' || $status == 'confirmed' || $status == 'booked')
                                                <span class="badge-paid"><i class="fas fa-check-circle text-xs"></i> SUCCESS</span>
                                            @else
                                                <div class="flex flex-col gap-1 items-start">
                                                    <span class="badge-pending"><i class="fas fa-clock text-xs"></i> PENDING</span>
                                                    {{-- Link Lanjutkan Pembayaran jika masih Pending --}}
                                                    <a href="{{ route('payment.status', $order->order_id) }}" class="text-[10px] font-bold text-purple-600 hover:underline">Bayar Sekarang</a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-8 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-inbox text-2xl text-gray-300"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada riwayat pesanan</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-fire text-orange-500"></i> Info Promosi
                    </h2>
                </div>
                
                <div class="space-y-4">
                    <div class="rec-card overflow-hidden">
                        <div class="rec-image" style="background-image: url('https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=400&h=200&fit=crop');">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <span class="absolute bottom-2 left-3 text-white text-xs font-semibold bg-red-500 px-2 py-0.5 rounded-full">🔥 WAR TIKET</span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800">Sistem Performa Tinggi</h3>
                            <p class="text-xs text-gray-500 mt-1">Menggunakan Apache Kafka broker antrean dan isolasi MongoDB cluster.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="info-panel p-5 text-center group hover:bg-purple-50/30 cursor-pointer transition">
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-3 group-hover:bg-purple-600 transition">
                    <i class="fas fa-headset text-purple-600 text-xl group-hover:text-white transition"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Pusat Bantuan</h3>
                <p class="text-xs text-gray-400 mt-1">FAQ & Panduan Server</p>
            </div>
            
            <div class="info-panel p-5 text-center group hover:bg-purple-50/30 cursor-pointer transition">
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-3 group-hover:bg-purple-600 transition">
                    <i class="fas fa-undo-alt text-purple-600 text-xl group-hover:text-white transition"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Kebijakan Tiket</h3>
                <p class="text-xs text-gray-400 mt-1">Syarat Sinkronisasi</p>
            </div>
            
            <div class="info-panel p-5 text-center group hover:bg-purple-50/30 cursor-pointer transition">
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-3 group-hover:bg-purple-600 transition">
                    <i class="fas fa-credit-card text-purple-600 text-xl group-hover:text-white transition"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Metode Pembayaran</h3>
                <p class="text-xs text-gray-400 mt-1">Midtrans Terintegrasi</p>
            </div>
            
            <div class="info-panel p-5 text-center group hover:bg-purple-50/30 cursor-pointer transition">
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-3 group-hover:bg-purple-600 transition">
                    <i class="fas fa-gift text-purple-600 text-xl group-hover:text-white transition"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Keamanan Data</h3>
                <p class="text-xs text-gray-400 mt-1">Replica Set Terjamin</p>
            </div>
        </div>
        
    </div>
</div>
@endsection