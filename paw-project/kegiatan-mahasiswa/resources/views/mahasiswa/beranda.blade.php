@extends('layouts.app')
@section('title', 'Beranda Mahasiswa')

@section('content')
<div class="mb-4">
    <h1 class="text-lg lg:text-xl font-bold text-gray-900">Selamat datang, {{ auth()->user()->name }}! 👋</h1>
    <p class="text-gray-500 text-xs lg:text-sm mt-0.5">Temukan kegiatan menarik untuk kamu ikuti</p>
</div>

{{-- Filter & Search --}}
<form method="GET" class="flex flex-col sm:flex-row gap-2 mb-5">
    <div class="flex-1 relative">
        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari kegiatan..."
               class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <div class="flex gap-2">
        <select name="kategori"
                class="flex-1 sm:flex-none border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white">
            <option value="">Semua Kategori</option>
            @foreach(['Seminar','Workshop','Kompetisi','Kepanitiaan','Lainnya'] as $kat)
                <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
            @endforeach
        </select>
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
            <i class="fas fa-search lg:hidden"></i>
            <span class="hidden lg:inline">Cari</span>
        </button>
        @if(request('search') || request('kategori'))
            <a href="{{ route('mahasiswa.beranda') }}"
               class="border border-gray-200 text-gray-600 px-3 py-2.5 rounded-xl text-sm hover:bg-gray-50 transition flex items-center">
                <i class="fas fa-times"></i>
            </a>
        @endif
    </div>
</form>

{{-- Kegiatan Grid --}}
@if($kegiatan->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($kegiatan as $item)
            <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-md transition group">
                <div class="relative h-40 bg-gray-100 overflow-hidden">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_kegiatan }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-blue-400 text-4xl"></i>
                        </div>
                    @endif
                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-xs font-semibold
                        badge-{{ strtolower(str_replace(' ','',$item->kategori)) }}">
                        {{ $item->kategori }}
                    </span>
                </div>

                <div class="p-4">
                    <h3 class="font-bold text-gray-900 text-sm leading-snug mb-1 line-clamp-2">{{ $item->nama_kegiatan }}</h3>
                    <p class="text-xs text-blue-600 font-medium mb-3 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full flex-shrink-0"></span>
                        <span class="truncate">{{ $item->organisasi->organisasiProfile->nama_organisasi ?? $item->organisasi->name }}</span>
                    </p>
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-users text-gray-400"></i>
                            <span>{{ $item->pendaftar_count }}/{{ $item->kuota_peserta }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="fas fa-calendar text-gray-400"></i>
                            <span>{{ $item->tanggal_pelaksanaan->format('d M Y') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('mahasiswa.detail-kegiatan', $item) }}"
                       class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2 rounded-lg transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-5">{{ $kegiatan->appends(request()->query())->links() }}</div>
@else
    <div class="text-center py-16">
        <i class="fas fa-calendar-times text-gray-300 text-5xl mb-4"></i>
        <h3 class="text-gray-500 font-medium">Belum ada kegiatan tersedia</h3>
        <p class="text-gray-400 text-sm mt-1">Coba ubah filter pencarian Anda</p>
    </div>
@endif
@endsection