@extends('layouts.app')

@section('title', 'Semua Pemberitahuan - Flash-Tix')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .notif-body {
        background-color: #f8fafc;
        font-family: 'Inter', sans-serif;
    }
    .notif-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }
    .btn-mark-all {
        background: #7c3aed;
        color: white;
        transition: all 0.2s ease;
    }
    .btn-mark-all:hover {
        background: #6d28d9;
    }
</style>

<div class="notif-body min-h-screen py-10 px-4">
    <div class="container mx-auto max-w-4xl">
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight uppercase flex items-center gap-2">
                    <i class="fas fa-bell text-purple-600"></i> Pusat Pemberitahuan
                </h1>
                <p class="text-xs text-slate-500 mt-1">Pantau semua log aktivitas pemesanan, konfirmasi pembayaran, dan antrean war tiket Anda.</p>
            </div>
            
            @if(count($notifications) > 0)
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-mark-all text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm flex items-center gap-2 uppercase tracking-wider">
                        <i class="fas fa-check-double"></i> Tandai Semua Telah Dibaca
                    </button>
                </form>
            @endif
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl font-medium flex items-center gap-2">
                <i class="fas fa-check-circle text-emerald-500"></i> {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            @forelse($notifications as $notif)
                @php
                    $notifId = is_object($notif) ? ($notif->_id ?? $notif->id) : ($notif['_id'] ?? $notif['id']);
                    $isRead = is_object($notif) ? ($notif->is_read) : ($notif['is_read']);
                    $title = is_object($notif) ? ($notif->title) : ($notif['title']);
                    $message = is_object($notif) ? ($notif->message) : ($notif['message']);
                    $createdAt = is_object($notif) ? ($notif->created_at) : ($notif['created_at']);
                @endphp

                <div class="notif-card p-5 flex items-start gap-4 {{ !$isRead ? 'border-l-4 border-l-purple-600 bg-purple-50/10' : '' }}">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ !$isRead ? 'bg-purple-100 text-purple-600' : 'bg-slate-100 text-slate-400' }}">
                        <i class="fas {{ !$isRead ? 'fa-envelope-open-text' : 'fa-envelope' }} text-sm"></i>
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                            <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                {{ $title }}
                                @if(!$isRead)
                                    <span class="inline-block w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                @endif
                            </h4>
                            <span class="text-[10px] text-slate-400 font-medium">
                                <i class="far fa-clock mr-1"></i> 
                                {{ $createdAt ? date('d M Y, H:i', strtotime($createdAt)) : 'Baru saja' }} WIB
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">{{ $message }}</p>
                    </div>

                    @if(!$isRead)
                        <form action="{{ route('notifications.read', $notifId) }}" method="POST" class="flex-shrink-0">
                            @csrf
                            <button type="submit" title="Tandai sudah dibaca" class="text-slate-300 hover:text-purple-600 p-1.5 text-xs transition">
                                <i class="fas fa-circle-check text-base"></i>
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="bg-white border border-dashed border-slate-300 rounded-3xl p-16 text-center shadow-inner">
                    <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300 text-xl">
                        <i class="fas fa-bell-slash"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-700">Tidak ada riwayat pemberitahuan</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">Semua info tiket masuk atau status transaksi lunas Midtrans akan terekam otomatis di halaman ini.</p>
                </div>
            @endforelse
        </div>
        
    </div>
</div>
@endsection