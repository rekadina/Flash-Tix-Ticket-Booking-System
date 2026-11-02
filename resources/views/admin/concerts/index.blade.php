@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Manajemen Konser</h2>
        <a href="{{ route('admin.concerts.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
            + Tambah Konser Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Poster</th>
                    <th class="py-3 px-6 text-left">Nama Konser / Artis</th>
                    <th class="py-3 px-6 text-left">Lokasi & Waktu</th>
                    <th class="py-3 px-6 text-center">Status</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($concerts as $concert)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                    <td class="py-3 px-6">
                        <img src="{{ asset('storage/' . $concert->poster) }}" class="w-16 h-20 object-cover rounded shadow-md">
                    </td>
                    <td class="py-3 px-6">
                        <span class="font-bold text-indigo-600 block">{{ $concert->name }}</span>
                        <span class="text-xs text-gray-500 italic">{{ $concert->artist }}</span>
                    </td>
                    <td class="py-3 px-6">
                        <div class="flex flex-col">
                            <span>📍 {{ $concert->venue }}, {{ $concert->city }}</span>
                            <span class="text-xs text-gray-500 mt-1">📅 {{ \Carbon\Carbon::parse($concert->date)->format('d M Y') }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs font-semibold uppercase">
                            {{ $concert->status ?? 'Published' }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center space-x-2">
                            <form action="{{ route('admin.concerts.destroy', $concert->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus konser ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection