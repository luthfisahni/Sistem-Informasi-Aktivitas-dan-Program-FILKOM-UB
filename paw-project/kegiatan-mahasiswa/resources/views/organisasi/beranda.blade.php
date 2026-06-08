@extends('layouts.app')
@section('title', 'Dashboard Organisasi')

@section('content')
<div class="mb-5">
    <h1 class="text-xl font-bold text-gray-900">Dashboard Organisasi</h1>
    <p class="text-gray-500 text-sm">Kelola kegiatan dan rekrut panitia untuk
        {{ $user->organisasiProfile->nama_organisasi ?? $user->name }}
    </p>
</div>

{{-- Stats --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center gap-4">
        <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-calendar-alt text-blue-500"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400">Total Kegiatan</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_kegiatan'] }}</p>
            <p class="text-xs text-gray-400">Kegiatan</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center gap-4">
        <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-chart-line text-green-500"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400">Kegiatan Aktif</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['kegiatan_aktif'] }}</p>
            <p class="text-xs text-gray-400">Aktif</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center gap-4">
        <div class="w-11 h-11 bg-purple-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-users text-purple-500"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400">Total Pendaftar</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_pendaftar'] }}</p>
            <p class="text-xs text-gray-400">Orang</p>
        </div>
    </div>
</div>

{{-- Buat Kegiatan --}}
<div class="flex items-center justify-between mb-4">
    <p class="text-sm text-gray-500">Menampilkan {{ $kegiatan->count() }} kegiatan</p>
    <a href="{{ route('organisasi.buat-kegiatan') }}"
       class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
        <i class="fas fa-plus text-xs"></i> Buat Kegiatan Baru
    </a>
</div>

{{-- Kegiatan Grid --}}
@if($kegiatan->count() > 0)
    <div class="grid grid-cols-2 gap-5">
        @foreach($kegiatan as $item)
            <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-md transition">
                <div class="relative h-44 bg-gray-100 overflow-hidden">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-blue-400 text-4xl"></i>
                        </div>
                    @endif
                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-xs font-semibold badge-{{ strtolower(str_replace(' ','',$item->kategori)) }}">
                        {{ $item->kategori }}
                    </span>
                    <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-semibold
                        {{ $item->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 text-sm leading-snug mb-1">{{ $item->nama_kegiatan }}</h3>
                    <p class="text-xs text-blue-600 font-medium mb-3">
                        {{ $user->organisasiProfile->nama_organisasi ?? $user->name }}
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
                    <a href="{{ route('organisasi.detail-kegiatan', $item) }}"
                       class="block w-full text-center bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold py-2 rounded-lg transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
        <i class="fas fa-plus-circle text-gray-300 text-5xl mb-4"></i>
        <h3 class="text-gray-500 font-medium">Belum ada kegiatan</h3>
        <p class="text-gray-400 text-sm mt-1">Mulai buat kegiatan pertama Anda</p>
        <a href="{{ route('organisasi.buat-kegiatan') }}"
           class="inline-block mt-4 bg-blue-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-blue-700 transition">
            Buat Kegiatan Baru
        </a>
    </div>
@endif
@endsection