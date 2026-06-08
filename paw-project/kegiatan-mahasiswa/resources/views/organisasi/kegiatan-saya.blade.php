@extends('layouts.app')
@section('title', 'Kegiatan Saya')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Kegiatan Saya</h1>
        <p class="text-gray-500 text-sm">Semua kegiatan yang Anda selenggarakan</p>
    </div>
    <a href="{{ route('organisasi.buat-kegiatan') }}"
       class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
        <i class="fas fa-plus text-xs"></i> Buat Kegiatan
    </a>
</div>

@if($kegiatan->count() > 0)
    <div class="space-y-3">
        @foreach($kegiatan as $item)
            <div class="bg-white rounded-2xl border border-gray-100 p-4 flex items-center gap-4 hover:shadow-sm transition">
                <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                            <i class="fas fa-calendar text-blue-400 text-xl"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="font-semibold text-gray-900 text-sm truncate">{{ $item->nama_kegiatan }}</h3>
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold badge-{{ strtolower(str_replace(' ','',$item->kategori)) }} flex-shrink-0">
                            {{ $item->kategori }}
                        </span>
                    </div>
                    <div class="flex items-center gap-4 text-xs text-gray-400">
                        <span><i class="fas fa-users mr-1"></i>{{ $item->pendaftar_count }}/{{ $item->kuota_peserta }} pendaftar</span>
                        <span><i class="fas fa-calendar mr-1"></i>{{ $item->tanggal_pelaksanaan->format('d M Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                        {{ $item->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                    <a href="{{ route('organisasi.detail-kegiatan', $item) }}"
                       class="text-blue-600 hover:text-blue-800 text-xs font-semibold border border-blue-200 px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">
                        Detail
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-5">{{ $kegiatan->links() }}</div>
@else
    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
        <i class="fas fa-calendar-plus text-gray-200 text-5xl mb-4"></i>
        <h3 class="text-gray-500 font-medium">Belum ada kegiatan</h3>
        <a href="{{ route('organisasi.buat-kegiatan') }}"
           class="inline-block mt-4 bg-blue-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-blue-700 transition">
            Buat Kegiatan Pertama
        </a>
    </div>
@endif
@endsection