<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SIAP FILKOM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 w-full max-w-lg p-8">
    <div class="mb-6">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <span class="text-white text-xs font-bold">SF</span>
            </div>
            <span class="font-bold text-blue-600">SIAP <span class="text-gray-800">FILKOM</span></span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Buat Akun Mahasiswa</h1>
        <p class="text-gray-500 text-sm mt-1">Daftarkan diri Anda untuk mengakses kegiatan FILKOM</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="Nama lengkap Anda"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       placeholder="nim@student.ub.ac.id"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">NIM</label>
                <input type="text" name="nim" value="{{ old('nim') }}" required
                       placeholder="Contoh: 215150207111001"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Angkatan</label>
                <input type="text" name="angkatan" value="{{ old('angkatan') }}" required
                       placeholder="Contoh: 2024"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Program Studi</label>
                <select name="program_studi" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Pilih Program Studi</option>
                    <option value="Teknik Informatika" {{ old('program_studi') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                    <option value="Sistem Informasi" {{ old('program_studi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                    <option value="Teknologi Informasi" {{ old('program_studi') == 'Teknologi Informasi' ? 'selected' : '' }}>Teknologi Informasi</option>
                    <option value="Pendidikan Teknologi Informasi" {{ old('program_studi') == 'Pendidikan Teknologi Informasi' ? 'selected' : '' }}>Pendidikan Teknologi Informasi</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                       placeholder="Min. 8 karakter"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                       placeholder="Ulangi password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition text-sm mt-2">
            Buat Akun
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-4">
        Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Login di sini</a>
    </p>
</div>
</body>
</html>