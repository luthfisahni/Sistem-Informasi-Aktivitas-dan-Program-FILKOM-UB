@extends('layouts.app')
@section('title', 'Pengaturan')
@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-gray-900">Pengaturan</h1>
    <p class="text-gray-500 text-sm">Kelola keamanan akun organisasi Anda</p>
</div>
<div class="bg-white rounded-2xl border border-gray-100 p-6 max-w-lg">
    <h2 class="font-bold text-gray-900 mb-1">Ubah Password</h2>
    <p class="text-xs text-gray-400 mb-5">Perbarui password akun organisasi Anda</p>
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('mahasiswa.password.update') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Lama</label>
            <input type="password" name="current_password" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Baru</label>
            <input type="password" name="password" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition">Simpan Password</button>
    </form>
</div>
@endsection