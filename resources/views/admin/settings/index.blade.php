@extends('layouts.app')

@section('title', 'Pusat Kendali Sistem - Flash-Tix')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="container mx-auto px-4">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800"><i class="fas fa-cogs text-purple-600 mr-2"></i> Pusat Kendali <span class="text-purple-600">Sistem</span></h1>
            <p class="text-gray-500">Atur semua fitur modul Flash-Tix dari satu tempat.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                @if(isset($settings['concert']))
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-bold mb-6 flex items-center gap-3 text-gray-800">
                        <span class="w-10 h-10 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center"><i class="fas fa-microphone-alt"></i></span>
                        Manajemen Modul Konser
                    </h2>
                    <div class="space-y-6">
                        @foreach($settings['concert'] as $setting)
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">{{ $setting->label }}</label>
                            @if($setting->key == 'concert_module')
                                <select name="settings[{{ $setting->key }}]" class="w-full border-gray-200 rounded-xl focus:ring-purple-500 focus:border-purple-500">
                                    <option value="active" {{ $setting->value == 'active' ? 'selected' : '' }}>🟢 Aktif (Normal)</option>
                                    <option value="maintenance" {{ $setting->value == 'maintenance' ? 'selected' : '' }}>🟠 Maintenance Mode</option>
                                    <option value="disabled" {{ $setting->value == 'disabled' ? 'selected' : '' }}>🔴 Nonaktifkan Fitur</option>
                                </select>
                            @else
                                <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="w-full border-gray-200 rounded-xl">
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(isset($settings['payment']))
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-bold mb-6 flex items-center gap-3 text-gray-800">
                        <span class="w-10 h-10 bg-green-100 text-green-600 rounded-xl flex items-center justify-center"><i class="fas fa-wallet"></i></span>
                        Konfigurasi Transaksi
                    </h2>
                    <div class="space-y-6">
                        @foreach($settings['payment'] as $setting)
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">{{ $setting->label }}</label>
                            <div class="relative">
                                @if(str_contains($setting->key, 'fee') || str_contains($setting->key, 'price'))
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                                    <input type="number" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="w-full pl-10 border-gray-200 rounded-xl">
                                @else
                                    <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="w-full border-gray-200 rounded-xl">
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            <div class="mt-10 flex justify-end">
                <button type="submit" class="bg-purple-600 text-white px-12 py-4 rounded-2xl font-bold shadow-xl hover:bg-purple-700 hover:-translate-y-1 transition-all duration-300">
                    <i class="fas fa-save mr-2"></i> Simpan Konfigurasi Sistem
                </button>
            </div>
        </form>
    </div>
</div>
@endsection