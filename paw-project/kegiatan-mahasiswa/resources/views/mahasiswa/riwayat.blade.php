@extends('layouts.app')
@section('title', 'Riwayat Pendaftaran')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-gray-900">Riwayat Pendaftaran</h1>
    <p class="text-gray-500 text-sm mt-0.5">Lacak semua pendaftaran yang pernah Anda ikuti</p>
</div>

{{-- Stats --}}
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
            <i class="fas fa-list text-gray-500"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400">Total</p>
            <p class="text-xl font-bold text-gray-800">{{ $stats['total'] }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-check-circle text-green-500"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400">Diterima</p>
            <p class="text-xl font-bold text-green-600">{{ $stats['diterima'] }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-yellow-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-clock text-yellow-500"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400">Pending</p>
            <p class="text-xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-times-circle text-red-400"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400">Ditolak</p>
            <p class="text-xl font-bold text-red-500">{{ $stats['ditolak'] }}</p>
        </div>
    </div>
</div>

{{-- Filter --}}
<form method="GET" class="flex gap-3 mb-5">
    <div class="flex-1 relative">
        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kegiatan..."
               class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <select name="status" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white">
        <option value="">Semua Status</option>
        <option value="pending"  {{ request('status') == 'pending'  ? 'selected' : '' }}>Pending</option>
        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
        <option value="ditolak"  {{ request('status') == 'ditolak'  ? 'selected' : '' }}>Ditolak</option>
    </select>
    <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
        Filter
    </button>
</form>

{{-- List --}}
@if($pendaftaran->count() > 0)
    <div class="space-y-3">
        @foreach($pendaftaran as $p)
            <div class="bg-white rounded-2xl border border-gray-100 p-4 flex items-center gap-4 hover:shadow-sm transition">
                <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                    @if($p->kegiatan->foto)
                        <img src="{{ asset('storage/' . $p->kegiatan->foto) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                            <i class="fas fa-calendar text-blue-400 text-xl"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-gray-900 text-sm truncate">{{ $p->kegiatan->nama_kegiatan }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $p->kegiatan->organisasi->organisasiProfile->nama_organisasi ?? $p->kegiatan->organisasi->name }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $p->kegiatan->deskripsi ? Str::limit($p->kegiatan->deskripsi, 80) : '' }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold status-{{ $p->status }}">
                        {{ ucfirst($p->status) }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
        <i class="fas fa-calendar-times text-gray-300 text-5xl mb-4"></i>
        <h3 class="text-gray-500 font-medium">Belum ada riwayat pendaftaran</h3>
        <p class="text-gray-400 text-sm mt-1">Mulai daftar kegiatan untuk melihat riwayat Anda di sini</p>
        <a href="{{ route('mahasiswa.beranda') }}"
           class="inline-block mt-4 bg-blue-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-blue-700 transition">
            Cari Kegiatan
        </a>
    </div>
@endif
@endsection