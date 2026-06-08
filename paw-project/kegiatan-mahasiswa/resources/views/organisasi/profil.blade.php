@extends('layouts.app')
@section('title', 'Profil Organisasi')

@section('content')
<div class="bg-gradient-to-r from-blue-500 to-blue-700 rounded-2xl p-6 mb-6 flex items-center gap-5">
    <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-white/30">
        @if($user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-blue-400 flex items-center justify-center">
                <i class="fas fa-building text-white text-2xl"></i>
            </div>
        @endif
    </div>
    <div class="text-white">
        <h1 class="text-xl font-bold">{{ $user->organisasiProfile->nama_organisasi ?? $user->name }}</h1>
        <p class="text-blue-200 text-sm">{{ $user->email }}</p>
        <p class="text-blue-100 text-xs mt-1">Organisasi FILKOM</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="font-bold text-gray-900">Informasi Profil</h2>
            <p class="text-xs text-gray-400">Kelola informasi profil organisasi</p>
        </div>
        <button onclick="toggleEdit()" id="edit-btn"
                class="flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-blue-600 border border-gray-200 px-4 py-2 rounded-lg hover:border-blue-300 transition">
            <i class="fas fa-edit text-xs"></i> Edit
        </button>
        <button onclick="toggleEdit()" id="save-cancel-btn" class="hidden text-sm text-gray-500 hover:text-gray-700">Batal</button>
    </div>

    <form method="POST" action="{{ route('organisasi.profil.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Penanggung Jawab</label>
                <input type="text" name="name" value="{{ $user->name }}" readonly
                       class="profile-field w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Email</label>
                <input type="text" value="{{ $user->email }}" readonly
                       class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-500 cursor-default">
            </div>
            <div class="col-span-2">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Organisasi</label>
                <input type="text" name="nama_organisasi" value="{{ $user->organisasiProfile->nama_organisasi ?? '' }}" readonly
                       class="profile-field w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="col-span-2">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3" readonly
                          class="profile-field w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none">{{ $user->organisasiProfile->deskripsi ?? '' }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Contact Person</label>
                <input type="text" name="contact_person_nama" value="{{ $user->organisasiProfile->contact_person_nama ?? '' }}" readonly
                       class="profile-field w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Telepon CP</label>
                <input type="text" name="contact_person_telepon" value="{{ $user->organisasiProfile->contact_person_telepon ?? '' }}" readonly
                       class="profile-field w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="col-span-2">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Email CP</label>
                <input type="email" name="contact_person_email" value="{{ $user->organisasiProfile->contact_person_email ?? '' }}" readonly
                       class="profile-field w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="col-span-2 hidden" id="photo-field">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Logo / Foto Organisasi</label>
                <input type="file" name="photo" accept="image/*"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-600">
            </div>
        </div>
        <div class="mt-5 hidden" id="save-btn-container">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition">
                <i class="fas fa-save mr-1"></i> Simpan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
let isEditing = false;
function toggleEdit() {
    isEditing = !isEditing;
    document.querySelectorAll('.profile-field').forEach(f => {
        if (isEditing) f.removeAttribute('readonly');
        else f.setAttribute('readonly', true);
    });
    document.getElementById('edit-btn').classList.toggle('hidden', isEditing);
    document.getElementById('save-cancel-btn').classList.toggle('hidden', !isEditing);
    document.getElementById('save-btn-container').classList.toggle('hidden', !isEditing);
    document.getElementById('photo-field').classList.toggle('hidden', !isEditing);
}
</script>
@endpush
@endsection