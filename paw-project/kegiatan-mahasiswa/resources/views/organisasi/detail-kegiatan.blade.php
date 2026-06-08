@extends('layouts.app')
@section('title', $kegiatan->nama_kegiatan)

@section('content')
<div class="mb-4">
    <a href="{{ route('organisasi.beranda') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-800">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="grid grid-cols-3 gap-6">
    <div class="col-span-2 space-y-5">
        {{-- Hero --}}
        <div class="relative rounded-2xl overflow-hidden h-56 bg-gray-100">
            @if($kegiatan->foto)
                <img src="{{ asset('storage/' . $kegiatan->foto) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-300 flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-blue-400 text-6xl"></i>
                </div>
            @endif
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-5">
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500 text-white">{{ $kegiatan->kategori }}</span>
                <h1 class="text-white font-bold text-xl mt-2">{{ $kegiatan->nama_kegiatan }}</h1>
            </div>
            <span class="absolute top-4 right-4 px-3 py-1.5 rounded-full text-xs font-bold
                {{ $kegiatan->status == 'aktif' ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
                {{ ucfirst($kegiatan->status) }}
            </span>
        </div>

        {{-- Info --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h2 class="font-bold text-gray-800 mb-4">Informasi Kegiatan</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-gray-400">Tanggal</p>
                    <p class="font-semibold text-gray-800">{{ $kegiatan->tanggal_pelaksanaan->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Waktu</p>
                    <p class="font-semibold text-gray-800">{{ $kegiatan->waktu ?? '-' }} WIB</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Lokasi</p>
                    <p class="font-semibold text-gray-800">{{ $kegiatan->lokasi ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Batas Pendaftaran</p>
                    <p class="font-semibold text-gray-800">{{ $kegiatan->batas_pendaftaran?->format('d F Y') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Kuota</p>
                    <p class="font-semibold text-gray-800">{{ $kegiatan->pendaftar_count }}/{{ $kegiatan->kuota_peserta }}</p>
                </div>
            </div>
            @if($kegiatan->deskripsi)
            <div class="mt-4 pt-4 border-t border-gray-50">
                <p class="text-xs text-gray-400 mb-1">Deskripsi</p>
                <p class="text-sm text-gray-700">{{ $kegiatan->deskripsi }}</p>
            </div>
            @endif
        </div>

        {{-- Daftar Pendaftar --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h2 class="font-bold text-gray-800 mb-4">
                Daftar Pendaftar
                <span class="ml-2 text-xs font-normal text-gray-400">({{ $kegiatan->pendaftaran->count() }} orang)</span>
            </h2>

            @if($kegiatan->pendaftaran->count() > 0)
                <div class="space-y-3">
                    @foreach($kegiatan->pendaftaran as $p)
                        <div class="flex items-center gap-3 p-3 border border-gray-100 rounded-xl">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                @if($p->mahasiswa->photo)
                                    <img src="{{ asset('storage/' . $p->mahasiswa->photo) }}" class="w-full h-full rounded-full object-cover">
                                @else
                                    <i class="fas fa-user text-blue-500 text-sm"></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $p->mahasiswa->name }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ $p->mahasiswa->mahasiswaProfile->nim ?? '' }}
                                    @if($p->divisi) · {{ $p->divisi->nama_divisi }} @endif
                                </p>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold status-{{ $p->status }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                                @if($p->status == 'pending')
                                <form method="POST" action="{{ route('organisasi.update-status', $p) }}" class="flex gap-1">
                                    @csrf
                                    <button type="submit" name="status" value="diterima"
                                            class="bg-green-100 hover:bg-green-200 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-lg transition">
                                        Terima
                                    </button>
                                    <button type="submit" name="status" value="ditolak"
                                            class="bg-red-100 hover:bg-red-200 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-lg transition">
                                        Tolak
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <i class="fas fa-users text-gray-200 text-4xl mb-3"></i>
                    <p class="text-sm text-gray-400">Belum ada yang mendaftar</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Divisi --}}
    <div class="space-y-4">
        @if($kegiatan->divisi->count() > 0)
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h3 class="font-bold text-gray-800 mb-3">Divisi</h3>
            <div class="space-y-2">
                @foreach($kegiatan->divisi as $div)
                <div class="border border-gray-100 rounded-xl p-3">
                    <div class="flex justify-between items-start">
                        <p class="text-sm font-semibold text-gray-800">{{ $div->nama_divisi }}</p>
                        <span class="text-xs text-gray-400">{{ $div->pendaftar_count }}/{{ $div->kuota }}</span>
                    </div>
                    @if($div->deskripsi)
                    <p class="text-xs text-gray-500 mt-1">{{ $div->deskripsi }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h3 class="font-bold text-gray-800 mb-3">Statistik</h3>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Pendaftar</span>
                    <span class="font-bold text-gray-800">{{ $kegiatan->pendaftaran->count() }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Diterima</span>
                    <span class="font-bold text-green-600">{{ $kegiatan->pendaftaran->where('status','diterima')->count() }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Pending</span>
                    <span class="font-bold text-yellow-600">{{ $kegiatan->pendaftaran->where('status','pending')->count() }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Ditolak</span>
                    <span class="font-bold text-red-500">{{ $kegiatan->pendaftaran->where('status','ditolak')->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection