@extends('layouts.app')

@section('title', 'Detail Pemesanan - Flash-Tix')

@section('content')
<!-- Import Google Font & Font Awesome -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    .font-poppins { font-family: 'Poppins', sans-serif; }
    
    /* Glassmorphism Effect */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Custom Input */
    .form-input-custom {
        transition: all 0.2s ease-in-out;
        border: 1.5px solid #e2e8f0;
        background-color: #f8fafc;
    }
    .form-input-custom:focus {
        border-color: #9333ea;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(147, 51, 234, 0.1);
        outline: none;
    }

    /* Stepper UI */
    .step-dot { width: 12px; height: 12px; border-radius: 50%; background: #cbd5e1; transition: all 0.3s; }
    .step-dot.active { background: #9333ea; box-shadow: 0 0 12px rgba(147, 51, 234, 0.5); }
    .step-dot.completed { background: #10b981; }
    .step-label { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; }
</style>

<div class="min-h-screen py-20 bg-slate-50">
    <div class="container mx-auto px-4">
        
        <!-- PROGRESS STEPPER -->
        <div class="flex items-center justify-center gap-6 mb-16">
            <div class="flex flex-col items-center gap-2">
                <div class="step-dot completed text-white flex items-center justify-center w-5 h-5 rounded-full bg-green-500 text-[10px]">
                    <i class="fas fa-check"></i>
                </div>
                <span class="step-label text-slate-400">Pilih Kursi</span>
            </div>
            <div class="h-[2px] w-16 bg-green-500"></div>
            <div class="flex flex-col items-center gap-2">
                <div class="step-dot active w-5 h-5 rounded-full bg-purple-600 flex items-center justify-center text-white text-[10px]">
                    <i class="fas fa-user"></i>
                </div>
                <span class="step-label text-purple-600">Detail Pemesan</span>
            </div>
            <div class="h-[2px] w-16 bg-slate-200"></div>
            <div class="flex flex-col items-center gap-2">
                <div class="step-dot w-5 h-5 rounded-full"></div>
                <span class="step-label text-slate-400">Pembayaran</span>
            </div>
        </div>

        <div class="max-w-6xl mx-auto flex flex-col lg:flex-row gap-10 items-start">
            
            <!-- FORM SECTION (LEFT) -->
            <div class="w-full lg:w-3/5">
                <div class="glass-card rounded-[2.5rem] p-10 shadow-xl shadow-slate-200/50">
                    <h2 class="text-3xl font-poppins font-bold text-slate-900 mb-2">Informasi Pemesan</h2>
                    <p class="text-slate-500 mb-8">Data ini digunakan untuk pengiriman E-Tiket Flash-Tix Anda.</p>

                    {{-- ERROR HANDLING --}}
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                                <p class="text-red-800 font-bold text-sm">Mohon perbaiki kesalahan berikut:</p>
                            </div>
                            <ul class="list-disc list-inside text-xs text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-orange-50 border-l-4 border-orange-500 p-4 mb-6 rounded-r-xl">
                            <p class="text-orange-800 font-bold text-sm">Gagal memproses:</p>
                            <p class="text-xs text-orange-700 mt-1">{{ session('error') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('booking.checkout') }}" method="POST" id="bookingForm">
                        @csrf
                        
                        {{-- Hidden Data --}}
                        <input type="hidden" name="concert_id" value="{{ $concert->_id ?? $concert->id }}">
                        <input type="hidden" name="category" id="hiddenCategory">
                        <input type="hidden" name="total_price" id="hiddenTotal">
                        <div id="seatsContainer"></div>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase mb-2 ml-1">Nama Lengkap</label>
                                <div class="relative group">
                                    <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-purple-500 transition-colors"></i>
                                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                           class="form-input-custom w-full pl-14 pr-6 py-4 rounded-2xl text-slate-800 font-semibold"
                                           placeholder="Nama sesuai KTP">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase mb-2 ml-1">Alamat Email</label>
                                <div class="relative group">
                                    <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-purple-500 transition-colors"></i>
                                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                           class="form-input-custom w-full pl-14 pr-6 py-4 rounded-2xl text-slate-800 font-semibold"
                                           placeholder="email@example.com">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase mb-2 ml-1">Nomor WhatsApp</label>
                                <div class="relative group">
                                    <i class="fab fa-whatsapp absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-purple-500 transition-colors"></i>
                                    <input type="tel" name="phone" value="{{ old('phone') }}" required
                                           class="form-input-custom w-full pl-14 pr-6 py-4 rounded-2xl text-slate-800 font-semibold"
                                           placeholder="0812XXXXXXXX">
                                </div>
                                <p class="text-xs text-slate-400 mt-1">*E-tiket akan dikirim ke WhatsApp dan Email Anda</p>
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit" id="submitBtn" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-5 rounded-2xl font-black text-sm tracking-widest shadow-lg shadow-purple-200 hover:scale-[1.02] active:scale-95 transition-all">
                                LANJUTKAN PEMBAYARAN <i class="fas fa-arrow-right ml-2 text-[10px]"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TICKET SUMMARY (RIGHT) -->
            <div class="w-full lg:w-2/5">
                <div class="bg-slate-900 rounded-[2.5rem] overflow-hidden shadow-2xl sticky top-24">
                    <!-- Ticket Top -->
                    <div class="p-8 border-b border-white/10 relative">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] font-black text-purple-400 uppercase tracking-[0.2em] mb-1">E-Ticket</p>
                                <h3 class="text-2xl font-poppins font-bold text-white uppercase tracking-tight">Flash-Tix</h3>
                            </div>
                            <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center border border-white/10">
                                <i class="fas fa-ticket-alt text-purple-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Details -->
                    <div class="p-8 space-y-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Konser</span>
                            <span class="text-white font-bold text-right">{{ $concert->name ?? 'Flash-Tix Concert' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Artis</span>
                            <span class="text-white font-bold text-right">{{ $concert->artist ?? 'Flash-Tix' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Lokasi</span>
                            <span class="text-white font-bold text-right">{{ $concert->venue ?? 'Venue' }}, {{ $concert->city ?? 'Jakarta' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Waktu</span>
                            <span class="text-white font-bold text-right">{{ \Carbon\Carbon::parse($concert->date)->format('d M Y | H:i') }} WIB</span>
                        </div>
                        
                        <div class="pt-6 border-t border-white/5 space-y-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Kategori</span>
                                <span id="summaryCategory" class="text-purple-400 font-black uppercase">-</span>
                            </div>
                            <div class="flex justify-between text-sm items-center">
                                <span class="text-slate-500">Kursi Dipilih</span>
                                <div id="summarySeats" class="flex flex-wrap gap-1 justify-end max-w-[180px]">
                                    {{-- JS akan mengisi ini --}}
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Jumlah Tiket</span>
                                <span id="summaryQuantity" class="text-white font-bold">0</span>
                            </div>
                        </div>

                        <!-- Total Price Section -->
                        <div class="pt-6 border-t border-dashed border-white/20">
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Total Pembayaran</p>
                            <div class="flex justify-between items-center">
                                <h4 id="summaryTotal" class="text-3xl font-black text-white">Rp 0</h4>
                                <div class="bg-green-500/10 text-green-400 text-[10px] font-black px-3 py-1 rounded-full border border-green-500/20">
                                    <i class="fas fa-shield-alt mr-1"></i> SECURE
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Perforation Line Decoration -->
                    <div class="h-6 flex justify-around items-center px-4">
                        @for($i=0; $i<20; $i++)
                            <div class="w-1 h-1 rounded-full bg-white/10"></div>
                        @endfor
                    </div>
                </div>
                
                <div class="mt-6 flex flex-wrap justify-center gap-6 opacity-60">
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-500"><i class="fas fa-lock"></i> Data terenkripsi</div>
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-500"><i class="fas fa-clock"></i> Sesi 15 menit</div>
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-500"><i class="fas fa-envelope"></i> E-tiket via email</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil data dari sessionStorage
        let selectedSeats = [];
        let category = '';
        let total = 0;
        
        try {
            selectedSeats = JSON.parse(sessionStorage.getItem('selected_seats') || '[]');
            category = sessionStorage.getItem('selected_category') || '';
            total = sessionStorage.getItem('selected_total') || 0;
        } catch(e) {
            console.error('Error reading session data');
        }

        // Proteksi Redirect jika data kosong
        if (!selectedSeats || selectedSeats.length === 0 || !total || total == 0) {
            alert('⚠️ Data pemesanan tidak lengkap. Silakan pilih kursi kembali.');
            window.location.href = "{{ route('concerts.index') }}";
            return;
        }

        // Tampilkan Data ke UI
        const summaryTotal = document.getElementById('summaryTotal');
        const summaryCategory = document.getElementById('summaryCategory');
        const summaryQuantity = document.getElementById('summaryQuantity');
        const summarySeats = document.getElementById('summarySeats');

        if(summaryCategory) summaryCategory.textContent = category;
        if(summaryQuantity) summaryQuantity.textContent = selectedSeats.length;
        if(summaryTotal) summaryTotal.textContent = 'Rp ' + parseInt(total).toLocaleString('id-ID');
        
        if(summarySeats) {
            summarySeats.innerHTML = '';
            for (var i = 0; i < selectedSeats.length; i++) {
                var span = document.createElement('span');
                span.className = "bg-purple-600/20 text-purple-400 text-[10px] font-black px-2 py-1 rounded-md border border-purple-600/30";
                span.textContent = selectedSeats[i];
                summarySeats.appendChild(span);
            }
        }
    
        // Masukkan ke Hidden Input Form
        document.getElementById('hiddenTotal').value = total;
        document.getElementById('hiddenCategory').value = category;

        var container = document.getElementById('seatsContainer');
        container.innerHTML = '';
        for (var i = 0; i < selectedSeats.length; i++) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'seats[]';
            input.value = selectedSeats[i];
            container.appendChild(input);
        }
        
        // Validasi form sebelum submit
        var form = document.getElementById('bookingForm');
        var submitBtn = document.getElementById('submitBtn');
        
        form.addEventListener('submit', function(e) {
            var phone = document.getElementById('phone').value;
            var phoneRegex = /^[0-9]{10,13}$/;
            
            if (!phone || !phoneRegex.test(phone.replace(/[^0-9]/g, ''))) {
                e.preventDefault();
                alert('⚠️ Nomor telepon tidak valid! Masukkan 10-13 digit angka.');
                return false;
            }
            
            // Loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> MEMPROSES...';
            
            return true;
        });
    });
</script>
@endsection