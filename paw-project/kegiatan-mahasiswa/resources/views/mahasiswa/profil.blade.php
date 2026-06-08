@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
{{-- Header Card --}}
<div class="bg-gradient-to-r from-blue-500 to-blue-700 rounded-2xl p-6 mb-6 flex items-center gap-5">
    <div class="relative">
        <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-white/30">
            @if($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-blue-400 flex items-center justify-center">
                    <i class="fas fa-user text-white text-2xl"></i>
                </div>
            @endif
        </div>
    </div>
    <div class="text-white">
        <h1 class="text-xl font-bold">{{ $user->name }}</h1>
        <p class="text-blue-200 text-sm">{{ $user->email }}</p>
        <div class="flex gap-3 mt-1 text-xs text-blue-100">
            <span>{{ $user->mahasiswaProfile->program_studi ?? 'Mahasiswa' }}</span>
            @if($user->mahasiswaProfile->nim)
                <span>·</span><span>{{ $user->mahasiswaProfile->nim }}</span>
            @endif
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="font-bold text-gray-900">Informasi Profil</h2>
            <p class="text-xs text-gray-400">Kelola informasi profil anda</p>
        </div>
        <button onclick="toggleEdit()" id="edit-btn"
                class="flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-blue-600 border border-gray-200 px-4 py-2 rounded-lg hover:border-blue-300 transition">
            <i class="fas fa-edit text-xs"></i> Edit
        </button>
        <button onclick="toggleEdit()" id="save-cancel-btn" class="hidden text-sm text-gray-500 hover:text-gray-700">
            Batal
        </button>
    </div>

    <form id="profil-form" method="POST" action="{{ route('mahasiswa.profil.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            @php
                $fields = [
                    ['label'=>'Nama Lengkap','name'=>'name','value'=>$user->name,'col'=>1],
                    ['label'=>'Email','name'=>'email_display','value'=>$user->email,'col'=>1,'readonly'=>true],
                    ['label'=>'NIM','name'=>'nim','value'=>$user->mahasiswaProfile->nim ?? '','col'=>1],
                    ['label'=>'No. Telepon','name'=>'no_telepon','value'=>$user->mahasiswaProfile->no_telepon ?? '','col'=>1],
                    ['label'=>'Program Studi','name'=>'program_studi','value'=>$user->mahasiswaProfile->program_studi ?? '','col'=>1],
                    ['label'=>'Semester','name'=>'semester','value'=>$user->mahasiswaProfile->semester ?? '','col'=>1],
                    ['label'=>'Angkatan','name'=>'angkatan','value'=>$user->mahasiswaProfile->angkatan ?? '','col'=>1],
                    ['label'=>'Alamat','name'=>'alamat','value'=>$user->mahasiswaProfile->alamat ?? '','col'=>1],
                ];
            @endphp

            @foreach($fields as $f)
                <div class="{{ $f['col'] == 2 ? 'col-span-2' : '' }}">
                    <label class="block text-xs font-semibold text-gray-500 mb-1">{{ $f['label'] }}</label>
                    <input type="text" name="{{ $f['name'] }}" value="{{ $f['value'] }}"
                           {{ isset($f['readonly']) ? 'readonly' : '' }}
                           class="profile-field w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 read-only:bg-gray-50 read-only:cursor-default"
                           readonly>
                </div>
            @endforeach

            <div class="col-span-2">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Bio</label>
                <textarea name="bio" rows="3" readonly
                          class="profile-field w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none">{{ $user->mahasiswaProfile->bio ?? '' }}</textarea>
            </div>

            <div class="col-span-2 hidden" id="photo-field">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Foto Profil</label>
                <input type="file" name="photo" accept="image/*"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-600">
            </div>
        </div>

        <div class="mt-5 hidden" id="save-btn-container">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition">
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
    const fields = document.querySelectorAll('.profile-field:not([name="email_display"])');
    fields.forEach(f => {
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