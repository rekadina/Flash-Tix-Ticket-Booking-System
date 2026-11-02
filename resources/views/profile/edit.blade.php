@extends('layouts.app')

@section('title', 'Pengaturan Profil - Flash-Tix')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .profile-body {
        background-color: #f8fafc;
        font-family: 'Inter', sans-serif;
    }
    .profile-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .input-ftix {
        width: 100%;
        padding: 0.625rem 0.875rem;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        font-size: 0.875rem;
        color: #1e293b;
        transition: all 0.2s;
    }
    .input-ftix:focus {
        outline: none;
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15);
    }
    .btn-save-ftix {
        background: linear-gradient(135deg, #4c1d95 0%, #be185d 100%);
        color: white;
        font-size: 0.813rem;
        font-weight: 700;
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .btn-save-ftix:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
</style>

<div class="profile-body min-h-screen py-10 px-4">
    <div class="container mx-auto max-w-3xl">
        
        <div class="mb-8">
            <h1 class="text-2xl font-black text-slate-800 tracking-tight uppercase flex items-center gap-2">
                <i class="fas fa-user-cog text-purple-600"></i> Pengaturan Akun
            </h1>
            <p class="text-xs text-slate-500 mt-1">Perbarui informasi data personal, avatar foto profil, atau perbarui kredensial keamanan kata sandi Anda.</p>
        </div>

        @if (session('status') === 'profile-updated' || session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl font-medium flex items-center gap-2 shadow-sm">
                <i class="fas fa-check-circle text-emerald-500 text-sm"></i> Perubahan data akun Anda berhasil disimpan!
            </div>
        @endif

        <div class="space-y-8">
            
            <div class="profile-card p-6 md:p-8">
                <div class="max-w-xl">
                    <h2 class="text-base font-bold text-slate-800 mb-1 flex items-center gap-2">
                        <i class="fas fa-id-card text-purple-500"></i> Informasi Profil
                    </h2>
                    <p class="text-xs text-slate-400 mb-6">Perbarui foto profil, nama pengguna akun Flash-Tix, dan alamat email Anda.</p>

                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('put')

                        <div class="flex items-center gap-4 mb-5 p-4 bg-slate-50 rounded-2xl border border-slate-100 shadow-inner">
                            <div class="w-16 h-16 rounded-full bg-purple-600 flex items-center justify-center text-white text-lg font-black overflow-hidden border-2 border-purple-500 shadow-md">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar Image" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                @endif
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Unggah Foto Profil Baru</label>
                                <input type="file" name="avatar" class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer" accept="image/*" />
                                <span class="text-[10px] text-slate-400 block mt-1">Format file: JPG, JPEG, PNG (Maks. 2MB)</span>
                                @error('avatar') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Pengguna</label>
                            <input type="text" name="name" class="input-ftix" value="{{ old('name', Auth::user()->name) }}" required autocomplete="name" />
                            @error('name') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Alamat Email</label>
                            <input type="email" name="email" class="input-ftix" value="{{ old('email', Auth::user()->email) }}" required autocomplete="username" />
                            @error('email') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="btn-save-ftix uppercase tracking-wider">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="profile-card p-6 md:p-8">
                <div class="max-w-xl">
                    <h2 class="text-base font-bold text-slate-800 mb-1 flex items-center gap-2">
                        <i class="fas fa-key text-purple-500"></i> Perbarui Kata Sandi
                    </h2>
                    <p class="text-xs text-slate-400 mb-6">Pastikan akun Anda menggunakan kata sandi yang panjang demi keamanan optimal.</p>

                    <form method="post" action="{{ route('profile.change-password') }}" class="space-y-4">
                        @csrf
                        @method('put')

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" class="input-ftix" autocomplete="current-password" required />
                            @error('current_password') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kata Sandi Baru</label>
                            <input type="password" name="password" class="input-ftix" autocomplete="new-password" required />
                            @error('password') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" class="input-ftix" autocomplete="new-password" required />
                            @error('password_confirmation') <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="btn-save-ftix uppercase tracking-wider">Perbarui Password</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="profile-card p-6 md:p-8 border-rose-100 bg-rose-50/10">
                <div class="max-w-xl">
                    <h2 class="text-base font-bold text-rose-800 mb-1 flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i> Hapus Akun Terpermanen
                    </h2>
                    <p class="text-xs text-rose-600/70 mb-4">Setelah akun Anda dihapus, semua log riwayat e-tiket war di sistem akan dibersihkan secara permanen dari database MongoDB.</p>

                    <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun Flash-Tix ini secara permanen? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('delete')
                        <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs uppercase tracking-wider px-4 py-2.5 rounded-lg transition shadow-sm">
                            Hapus Akun Saya
                        </button>
                    </form>
                </div>
            </div>

        </div>
        
    </div>
</div>
@endsection