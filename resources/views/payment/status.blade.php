@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran - Flash-Tix')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-100 py-12 px-4 flex items-center justify-center">
    <div class="max-w-2xl w-full">
        {{-- Card Utama --}}
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-white">
            
            {{-- Header: Status Animasi --}}
            <div class="bg-purple-600 p-8 text-center text-white relative">
                <div class="absolute top-4 right-6 flex items-center space-x-1 opacity-80">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                    <span class="text-xs font-bold tracking-widest uppercase">Secure Transaction</span>
                </div>
                
                <div class="mb-4 inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full backdrop-blur-sm">
                    <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-white"></div>
                </div>
                <h2 class="text-3xl font-extrabold mb-2">Menunggu Pembayaran</h2>
                <p class="text-purple-100 opacity-90">Selesaikan transaksi Anda sebelum sesi berakhir.</p>
            </div>

            <div class="p-8">
                {{-- Detail Transaksi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    {{-- Sisi Kiri: Informasi Konser --}}
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Detail Tiket</h3>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <span class="bg-purple-100 text-purple-600 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4v-3a2 2 0 00-2-2H5z"></path></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-bold text-gray-800">Flash Hour 2026</p>
                                    <p class="text-xs text-gray-500 italic">Artis: Judika</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="bg-gray-100 text-gray-600 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-bold text-gray-800">Gedung Serba Guna</p>
                                    <p class="text-xs text-gray-500">Jakarta, 01 Mei 2026</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sisi Kanan: Detail Kursi & Harga --}}
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                        <div class="flex justify-between mb-2">
                            <span class="text-xs text-gray-500 uppercase">Kategori</span>
                            <span class="text-xs font-bold text-purple-600">{{ $booking->category }}</span>
                        </div>
                        <div class="flex justify-between mb-4">
                            <span class="text-xs text-gray-500 uppercase">Kursi</span>
                            <span class="text-xs font-bold text-gray-800">{{ implode(', ', $booking->seats) }}</span>
                        </div>
                        <div class="border-t border-dashed border-gray-300 pt-4 mt-2">
                            <p class="text-xs text-gray-400 mb-1 uppercase tracking-tighter">Total Pembayaran</p>
                            <p class="text-2xl font-black text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Order ID & Badge Keamanan --}}
                <div class="flex items-center justify-between mb-8 bg-purple-50 p-4 rounded-xl border border-purple-100">
                    <div>
                        <p class="text-[10px] font-bold text-purple-400 uppercase leading-none mb-1">Transaction ID</p>
                        <p class="text-sm font-mono font-bold text-purple-900">{{ $orderId }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/GPN_logo.svg" alt="GPN" class="h-4 opacity-50 grayscale">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" class="h-4 opacity-50 grayscale">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="h-4 opacity-50 grayscale">
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="space-y-4">
                    <button id="pay-button" class="w-full bg-purple-600 text-white py-4 rounded-2xl font-black text-lg hover:bg-purple-700 transition-all transform hover:scale-[1.02] shadow-xl shadow-purple-200 flex items-center justify-center">
                        <span>BAYAR SEKARANG</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </button>
                    
                    <div class="text-center">
                        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-400 hover:text-purple-600 transition tracking-wide">
                            BATALKAN PESANAN
                        </a>
                    </div>
                </div>
            </div>

            {{-- Footer Trust --}}
            <div class="bg-gray-50 border-t border-gray-100 p-4 text-center">
                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest flex items-center justify-center">
                    <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 4.925-3.003 9.15-7.25 10.954a11.954 11.954 0 01-7.25-10.954c0-.681.056-1.35.166-2.001zm6.541 4.242L10 10.45l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 011.414-1.414z" clip-rule="evenodd"></path></svg>
                    Encypted & Secured by Midtrans
                </p>
            </div>
        </div>
        
        <p class="text-center mt-6 text-xs text-gray-400">
            &copy; 2026 Flash-Tix System. Created for Academic Purposes.
        </p>
    </div>
</div>

{{-- Script Midtrans Snap --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var snapToken = "{{ $snapToken }}";
        var payButton = document.getElementById('pay-button');

        if (snapToken) {
            function triggerSnap() {
                window.snap.pay(snapToken, {
                    onSuccess: function(result) {
                        alert("Pembayaran Berhasil! Tiket Anda sedang dibuat.");
                        window.location.href = "{{ route('dashboard') }}";
                    },
                    onPending: function(result) {
                        window.location.href = "{{ route('dashboard') }}";
                    },
                    onError: function(result) {
                        alert("Pembayaran Gagal! Silakan hubungi admin.");
                        console.error(result);
                    },
                    onClose: function() {
                        console.log('User menutup popup.');
                    }
                });
            }

            // Jalankan otomatis
            setTimeout(triggerSnap, 1500); // Beri delay 1.5 detik biar user sempat liat UI cantiknya

            payButton.onclick = function() {
                triggerSnap();
            };
        } else {
            alert('Gagal memuat sistem pembayaran.');
        }
    });
</script>
@endsection