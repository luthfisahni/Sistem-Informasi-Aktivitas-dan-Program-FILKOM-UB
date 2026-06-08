@extends('layouts.app')
@section('title', $kegiatan->nama_kegiatan)

@section('content')
<div class="mb-4">
    <a href="{{ route('mahasiswa.beranda') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-800">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Left: Detail --}}
    <div class="lg:col-span-2 space-y-5">
        {{-- Hero Image --}}
        <div class="relative rounded-2xl overflow-hidden h-64 bg-gray-100">
            @if($kegiatan->foto)
                <img src="{{ asset('storage/' . $kegiatan->foto) }}" alt="{{ $kegiatan->nama_kegiatan }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-300 flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-blue-400 text-6xl"></i>
                </div>
            @endif
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-5">
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500 text-white">{{ $kegiatan->kategori }}</span>
                <h1 class="text-white font-bold text-xl mt-2">{{ $kegiatan->nama_kegiatan }}</h1>
                <p class="text-blue-200 text-sm">
                    {{ $kegiatan->organisasi->organisasiProfile->nama_organisasi ?? $kegiatan->organisasi->name }}
                </p>
            </div>
            @if($kegiatan->isOpenForRegistration())
                <span class="absolute top-4 right-4 bg-green-500 text-white text-xs font-bold px-3 py-1.5 rounded-full">
                    Pendaftaran Dibuka
                </span>
            @else
                <span class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full">
                    Pendaftaran Ditutup
                </span>
            @endif
        </div>

        {{-- Tabs --}}
        <div class="bg-white rounded-2xl border border-gray-100">
            <div class="flex border-b border-gray-100" id="tabs">
                @foreach(['Detail','Syarat','Benefit','Timeline'] as $tab)
                    <button onclick="showTab('{{ strtolower($tab) }}')"
                            id="tab-{{ strtolower($tab) }}"
                            class="tab-btn flex-1 py-3 text-sm font-semibold text-gray-500 hover:text-blue-600 transition border-b-2 border-transparent
                                {{ $tab == 'Detail' ? 'text-blue-600 border-blue-600' : '' }}">
                        {{ $tab }}
                    </button>
                @endforeach
            </div>

            <div class="p-5">
                {{-- Detail --}}
                <div id="content-detail">
                    <p class="text-gray-600 text-sm mb-5">{{ $kegiatan->deskripsi }}</p>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar text-blue-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Tanggal Pelaksanaan</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $kegiatan->tanggal_pelaksanaan->format('l, d F Y') }}</p>
                            </div>
                        </div>
                        @if($kegiatan->waktu)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-blue-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Waktu</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $kegiatan->waktu }} WIB</p>
                            </div>
                        </div>
                        @endif
                        @if($kegiatan->lokasi)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-blue-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Lokasi</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $kegiatan->lokasi }}</p>
                            </div>
                        </div>
                        @endif
                        @if($kegiatan->batas_pendaftaran)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-stopwatch text-red-400 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Batas Pendaftaran</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $kegiatan->batas_pendaftaran->format('l, d F Y') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($kegiatan->divisi->count() > 0)
                    <div class="mt-5">
                        <h3 class="text-sm font-bold text-gray-800 mb-3">Divisi yang Tersedia</h3>
                        <div class="space-y-2">
                            @foreach($kegiatan->divisi as $div)
                            <div class="border border-gray-100 rounded-xl p-3 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $div->nama_divisi }}</p>
                                    <p class="text-xs text-gray-500">{{ $div->deskripsi }}</p>
                                </div>
                                <span class="text-xs font-semibold text-gray-500">Kuota: {{ $div->kuota }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div id="content-syarat" class="hidden">
                    <div class="text-sm text-gray-600 leading-relaxed">
                        {!! nl2br(e($kegiatan->syarat ?? 'Tidak ada syarat khusus.')) !!}
                    </div>
                </div>
                <div id="content-benefit" class="hidden">
                    <div class="text-sm text-gray-600 leading-relaxed">
                        {!! nl2br(e($kegiatan->benefit ?? 'Informasi benefit belum tersedia.')) !!}
                    </div>
                </div>
                <div id="content-timeline" class="hidden">
                    <div class="text-sm text-gray-600 leading-relaxed">
                        {!! nl2br(e($kegiatan->timeline ?? 'Informasi timeline belum tersedia.')) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Pendaftaran & Contact --}}
    <div class="space-y-4">
        {{-- Pendaftaran Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h3 class="font-bold text-gray-800 mb-4">Pendaftaran</h3>

            <div class="bg-blue-50 rounded-xl p-4 mb-4 text-center">
                <p class="text-xs text-gray-500 mb-1">Kuota Terisi</p>
                <p class="text-2xl font-bold text-blue-600">{{ $kegiatan->pendaftar_count }}/{{ $kegiatan->kuota_peserta }}</p>
                <div class="w-full bg-blue-100 rounded-full h-2 mt-2">
                    <div class="bg-blue-500 h-2 rounded-full"
                         style="width: {{ min(100, ($kegiatan->pendaftar_count / $kegiatan->kuota_peserta) * 100) }}%"></div>
                </div>
            </div>

            @if($kegiatan->batas_pendaftaran)
            <div class="mb-4 text-center">
                <p class="text-xs text-gray-500">Batas Pendaftaran</p>
                <p class="text-sm font-bold text-red-500">{{ $kegiatan->batas_pendaftaran->format('d F Y') }}</p>
            </div>
            @endif

            @if($sudahDaftar)
                <div class="text-center py-3 rounded-xl
                    {{ $sudahDaftar->status == 'diterima' ? 'bg-green-50 text-green-700' : ($sudahDaftar->status == 'ditolak' ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-700') }}">
                    <i class="fas fa-{{ $sudahDaftar->status == 'diterima' ? 'check-circle' : ($sudahDaftar->status == 'ditolak' ? 'times-circle' : 'clock') }} mb-1"></i>
                    <p class="text-sm font-semibold">
                        {{ $sudahDaftar->status == 'diterima' ? 'Pendaftaran Diterima' : ($sudahDaftar->status == 'ditolak' ? 'Pendaftaran Ditolak' : 'Menunggu Konfirmasi') }}
                    </p>
                </div>
            @elseif($kegiatan->isOpenForRegistration() && !$kegiatan->isFull())
                <form method="POST" action="{{ route('mahasiswa.daftar-kegiatan', $kegiatan) }}">
                    @csrf
                    @if($kegiatan->divisi->count() > 0)
                        <select name="divisi_id" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm mb-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">Pilih Divisi</option>
                            @foreach($kegiatan->divisi as $div)
                                <option value="{{ $div->id }}">{{ $div->nama_divisi }} (Kuota: {{ $div->kuota }})</option>
                            @endforeach
                        </select>
                    @endif
                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl text-sm transition">
                        Daftar Sekarang
                    </button>
                </form>
            @elseif($kegiatan->isFull())
                <button disabled class="w-full bg-gray-100 text-gray-400 font-semibold py-3 rounded-xl text-sm cursor-not-allowed">
                    Kuota Penuh
                </button>
            @else
                <button disabled class="w-full bg-gray-100 text-gray-400 font-semibold py-3 rounded-xl text-sm cursor-not-allowed">
                    Pendaftaran Ditutup
                </button>
            @endif
        </div>

        {{-- Contact Person --}}
        @php $cp = $kegiatan->organisasi->organisasiProfile; @endphp
        @if($cp && ($cp->contact_person_nama || $cp->contact_person_telepon))
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h3 class="font-bold text-gray-800 mb-4">Contact Person</h3>
            <div class="space-y-3">
                @if($cp->contact_person_nama)
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-gray-500 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Nama</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $cp->contact_person_nama }}</p>
                    </div>
                </div>
                @endif
                @if($cp->contact_person_telepon)
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-phone text-gray-500 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Telepon</p>
                        <p class="text-sm font-semibold text-blue-600">{{ $cp->contact_person_telepon }}</p>
                    </div>
                </div>
                @endif
                @if($cp->contact_person_email)
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-envelope text-gray-500 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Email</p>
                        <p class="text-sm font-semibold text-blue-600">{{ $cp->contact_person_email }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function showTab(name) {
    ['detail','syarat','benefit','timeline'].forEach(t => {
        document.getElementById('content-' + t).classList.add('hidden');
        document.getElementById('tab-' + t).classList.remove('text-blue-600', 'border-blue-600');
        document.getElementById('tab-' + t).classList.add('text-gray-500', 'border-transparent');
    });
    document.getElementById('content-' + name).classList.remove('hidden');
    document.getElementById('tab-' + name).classList.add('text-blue-600', 'border-blue-600');
    document.getElementById('tab-' + name).classList.remove('text-gray-500', 'border-transparent');
}
</script>
@endpush
@endsection