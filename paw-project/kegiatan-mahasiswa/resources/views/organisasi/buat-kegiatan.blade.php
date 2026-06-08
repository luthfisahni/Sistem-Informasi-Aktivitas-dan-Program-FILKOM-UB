@extends('layouts.app')
@section('title', 'Buat Kegiatan Baru')

@section('content')
<div class="mb-5 flex items-center gap-3">
    <a href="{{ route('organisasi.beranda') }}" class="text-gray-400 hover:text-gray-700 transition">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-xl font-bold text-gray-900">Buat Kegiatan Baru</h1>
        <p class="text-xs text-gray-400">Isi informasi kegiatan yang akan diselenggarakan</p>
    </div>
</div>

@if ($errors->any())
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('organisasi.simpan-kegiatan') }}" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-3 gap-6">
        {{-- Main Form --}}
        <div class="col-span-2 space-y-5">
            <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-4">
                <h2 class="font-bold text-gray-800">Informasi Dasar</h2>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" required
                           placeholder="Contoh: Workshop AI Development"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white">
                            <option value="">Pilih Kategori</option>
                            @foreach(['Seminar','Workshop','Kompetisi','Kepanitiaan','Lainnya'] as $kat)
                                <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kuota Peserta <span class="text-red-500">*</span></label>
                        <input type="number" name="kuota_peserta" value="{{ old('kuota_peserta') }}" required min="1"
                               placeholder="Contoh: 50"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea name="deskripsi" rows="4" required placeholder="Jelaskan tentang kegiatan ini..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Pelaksanaan <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan') }}" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Waktu</label>
                        <input type="time" name="waktu" value="{{ old('waktu') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Lokasi <span class="text-red-500">*</span></label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                               placeholder="Contoh: Gedung F 4.1"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Batas Pendaftaran</label>
                        <input type="date" name="batas_pendaftaran" value="{{ old('batas_pendaftaran') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>
            </div>

            {{-- Syarat, Benefit, Timeline --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-4">
                <h2 class="font-bold text-gray-800">Detail Tambahan</h2>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Syarat Pendaftaran</label>
                    <textarea name="syarat" rows="3" placeholder="Syarat-syarat untuk mendaftar..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none">{{ old('syarat') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Benefit</label>
                    <textarea name="benefit" rows="3" placeholder="Keuntungan yang didapat peserta..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none">{{ old('benefit') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Timeline</label>
                    <textarea name="timeline" rows="3" placeholder="Jadwal dan tahapan kegiatan..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none">{{ old('timeline') }}</textarea>
                </div>
            </div>

            {{-- Divisi --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="font-bold text-gray-800">Divisi / Departemen</h2>
                        <p class="text-xs text-gray-400">Opsional - tambah jika ada divisi tertentu</p>
                    </div>
                    <button type="button" onclick="addDivisi()"
                            class="flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-800 border border-blue-200 px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">
                        <i class="fas fa-plus text-xs"></i> Tambah Divisi
                    </button>
                </div>
                <div id="divisi-container" class="space-y-3"></div>
                <p id="empty-divisi" class="text-sm text-gray-400 text-center py-4">Belum ada divisi. Klik "Tambah Divisi" untuk menambahkan.</p>
            </div>
        </div>

        {{-- Right: Foto & Actions --}}
        <div class="space-y-5">
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <h3 class="font-bold text-gray-800 mb-3">Foto Kegiatan</h3>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center" id="foto-preview-container">
                    <i class="fas fa-image text-gray-300 text-4xl mb-2"></i>
                    <p class="text-xs text-gray-400">Klik untuk upload foto</p>
                    <img id="foto-preview" class="hidden w-full h-40 object-cover rounded-lg mt-2">
                </div>
                <input type="file" name="foto" id="foto-input" accept="image/*" class="hidden"
                       onchange="previewFoto(this)">
                <button type="button" onclick="document.getElementById('foto-input').click()"
                        class="mt-3 w-full border border-gray-200 text-gray-600 text-sm py-2 rounded-lg hover:bg-gray-50 transition">
                    Pilih Foto
                </button>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5 space-y-3">
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl text-sm transition">
                    <i class="fas fa-plus mr-1"></i> Buat Kegiatan
                </button>
                <a href="{{ route('organisasi.beranda') }}"
                   class="block w-full text-center border border-gray-200 text-gray-600 font-semibold py-3 rounded-xl text-sm hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
let divisiCount = 0;

function addDivisi() {
    divisiCount++;
    document.getElementById('empty-divisi').classList.add('hidden');
    const container = document.getElementById('divisi-container');
    const div = document.createElement('div');
    div.id = 'divisi-' + divisiCount;
    div.className = 'border border-gray-100 rounded-xl p-4 space-y-3';
    div.innerHTML = `
        <div class="flex items-center justify-between">
            <h4 class="text-sm font-semibold text-gray-700">Divisi #${divisiCount}</h4>
            <button type="button" onclick="removeDivisi(${divisiCount})" class="text-red-400 hover:text-red-600 text-xs">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </div>
        <div class="grid grid-cols-3 gap-2">
            <div class="col-span-2">
                <input type="text" name="divisi[${divisiCount}][nama]" placeholder="Nama Divisi" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <input type="number" name="divisi[${divisiCount}][kuota]" placeholder="Kuota" required min="1"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>
        <textarea name="divisi[${divisiCount}][deskripsi]" placeholder="Deskripsi singkat divisi..." rows="2"
                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none"></textarea>
    `;
    container.appendChild(div);
}

function removeDivisi(id) {
    document.getElementById('divisi-' + id).remove();
    if (document.getElementById('divisi-container').children.length === 0) {
        document.getElementById('empty-divisi').classList.remove('hidden');
    }
}

function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('foto-preview');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            document.getElementById('foto-preview-container').querySelector('i').classList.add('hidden');
            document.getElementById('foto-preview-container').querySelector('p').classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection