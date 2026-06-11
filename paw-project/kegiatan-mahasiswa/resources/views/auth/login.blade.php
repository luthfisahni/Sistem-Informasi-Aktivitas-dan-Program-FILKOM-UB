<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIAP FILKOM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-screen bg-white flex">

    <div class="w-full lg:w-1/2 flex flex-col justify-center px-10 lg:px-20">
        <div class="max-w-md w-full mx-auto">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">SELAMAT DATANG</h1>
            <p class="text-gray-500 text-sm mb-8">Sistem Informasi Aktivitas & Program FILKOM<br>Universitas Brawijaya</p>

            <div class="flex bg-gray-100 p-1 rounded-full mb-7 w-fit gap-1">
                <button id="btn-mahasiswa" onclick="setRole('mahasiswa')"
                        class="px-5 py-1.5 rounded-full text-sm font-semibold transition-all duration-200 bg-blue-500 text-white">
                    Mahasiswa
                </button>
                <button id="btn-organisasi" onclick="setRole('organisasi')"
                        class="px-5 py-1.5 rounded-full text-sm font-semibold transition-all duration-200 text-gray-600">
                    Organisasi
                </button>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <input type="hidden" name="role" id="role-input" value="mahasiswa">

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-800 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="Ketik alamat email anda (abc@student.ub.ac.id)"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-800 mb-1.5">Password</label>
                    <input type="password" name="password" required
                           placeholder="••••••••••"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                </div>

                <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition text-sm">
                    Login
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-4" id="register-link">
                Tidak memiliki akun?
                <a href="{{ route('register') }}" class="text-red-500 font-semibold hover:underline">Buat akun sekarang!</a>
            </p>
        </div>
    </div>

    {{-- Right: Decorative --}}
    <div class="hidden lg:flex w-1/2 bg-sky-50 items-center justify-center relative overflow-hidden">
    <div class="absolute top-0 right-0 w-full h-full bg-sky-100 rounded-bl-[100px]"></div>
    <div class="relative z-10 flex flex-col items-center text-center px-8">
        <img
            src="{{ asset('img/siap.png') }}"
            alt="SIAP FILKOM"
            class="w-[450px] h-auto -mt-20 -ml-10 -ml-20"
        >
        <h2 class="text-3xl font-bold text-blue-700 -mt-20 ">
            SIAP FILKOM
        </h2>
        <p class="text-blue-500 mt-2">
            Universitas Brawijaya
        </p>
    </div>
</div>

    <script>
        function setRole(role) {
            document.getElementById('role-input').value = role;
            const btnM = document.getElementById('btn-mahasiswa');
            const btnO = document.getElementById('btn-organisasi');
            const regLink = document.getElementById('register-link');

            if (role === 'mahasiswa') {
                btnM.className = 'px-5 py-1.5 rounded-full text-sm font-semibold transition-all duration-200 bg-blue-500 text-white';
                btnO.className = 'px-5 py-1.5 rounded-full text-sm font-semibold transition-all duration-200 text-gray-600';
                regLink.style.display = 'block';
            } else {
                btnO.className = 'px-5 py-1.5 rounded-full text-sm font-semibold transition-all duration-200 bg-blue-500 text-white';
                btnM.className = 'px-5 py-1.5 rounded-full text-sm font-semibold transition-all duration-200 text-gray-600';
                regLink.style.display = 'none';
            }
        }
    </script>
</body>
</html>