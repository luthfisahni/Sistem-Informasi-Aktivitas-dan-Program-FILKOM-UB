<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIAP FILKOM - @yield('title', 'Sistem Informasi Aktivitas & Program')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-link.active { background: #EFF6FF; color: #1D4ED8; }
        .sidebar-link.active i { color: #1D4ED8; }
        .badge-seminar     { background:#DBEAFE; color:#1D4ED8; }
        .badge-workshop    { background:#D1FAE5; color:#065F46; }
        .badge-kompetisi   { background:#FEF3C7; color:#92400E; }
        .badge-kepanitiaan { background:#EDE9FE; color:#5B21B6; }
        .badge-lainnya     { background:#F3F4F6; color:#374151; }
        .status-pending    { background:#FEF3C7; color:#92400E; }
        .status-diterima   { background:#D1FAE5; color:#065F46; }
        .status-ditolak    { background:#FEE2E2; color:#991B1B; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">

<div class="flex min-h-screen">

    {{-- Sidebar Desktop --}}
    <aside class="hidden lg:flex w-56 bg-white border-r border-gray-200 flex-col fixed h-full z-10">
        <div class="p-4 border-b border-gray-100">
            <a href="{{ auth()->user()->isMahasiswa() ? route('mahasiswa.beranda') : route('organisasi.beranda') }}"
               class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-infinity text-white text-sm"></i>
                </div>
                <span class="font-bold text-blue-600">SIAP <span class="text-gray-800">FILKOM</span></span>
            </a>
        </div>

        <nav class="flex-1 p-3 space-y-1">
            @if(auth()->user()->isMahasiswa())
                <a href="{{ route('mahasiswa.beranda') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition {{ request()->routeIs('mahasiswa.beranda') ? 'active' : '' }}">
                    <i class="fas fa-home w-4"></i><span class="text-sm font-medium">Beranda</span>
                </a>
                <a href="{{ route('mahasiswa.riwayat') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition {{ request()->routeIs('mahasiswa.riwayat') ? 'active' : '' }}">
                    <i class="fas fa-history w-4"></i><span class="text-sm font-medium">Riwayat</span>
                </a>
                <a href="{{ route('mahasiswa.profil') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition {{ request()->routeIs('mahasiswa.profil') ? 'active' : '' }}">
                    <i class="fas fa-user w-4"></i><span class="text-sm font-medium">Profil</span>
                </a>
                <a href="{{ route('mahasiswa.pengaturan') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition {{ request()->routeIs('mahasiswa.pengaturan') ? 'active' : '' }}">
                    <i class="fas fa-cog w-4"></i><span class="text-sm font-medium">Pengaturan</span>
                </a>
            @else
                <a href="{{ route('organisasi.beranda') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition {{ request()->routeIs('organisasi.beranda') ? 'active' : '' }}">
                    <i class="fas fa-home w-4"></i><span class="text-sm font-medium">Beranda</span>
                </a>
                <a href="{{ route('organisasi.kegiatan-saya') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition {{ request()->routeIs('organisasi.kegiatan-saya') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt w-4"></i><span class="text-sm font-medium">Kegiatan Saya</span>
                </a>
                <a href="{{ route('organisasi.profil') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition {{ request()->routeIs('organisasi.profil') ? 'active' : '' }}">
                    <i class="fas fa-user w-4"></i><span class="text-sm font-medium">Profil</span>
                </a>
                <a href="{{ route('organisasi.pengaturan') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition {{ request()->routeIs('organisasi.pengaturan') ? 'active' : '' }}">
                    <i class="fas fa-cog w-4"></i><span class="text-sm font-medium">Pengaturan</span>
                </a>
            @endif
        </nav>

        <div class="p-3 border-t border-gray-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-red-500 hover:bg-red-50 transition text-sm font-medium">
                    <i class="fas fa-sign-out-alt w-4"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Mobile Top Bar --}}
    <div class="lg:hidden fixed top-0 left-0 right-0 z-20 bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
        <a href="{{ auth()->user()->isMahasiswa() ? route('mahasiswa.beranda') : route('organisasi.beranda') }}"
           class="flex items-center gap-2">
            <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-infinity text-white text-xs"></i>
            </div>
            <span class="font-bold text-blue-600 text-sm">SIAP <span class="text-gray-800">FILKOM</span></span>
        </a>
        <div class="flex items-center gap-2">
            <span class="text-xs text-gray-500 font-medium">{{ auth()->user()->name }}</span>
            <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center">
                @if(auth()->user()->photo)
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="w-full h-full rounded-full object-cover">
                @else
                    <i class="fas fa-user text-blue-500 text-xs"></i>
                @endif
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <main class="lg:ml-56 flex-1 p-4 lg:p-6 pt-16 lg:pt-6 pb-24 lg:pb-6">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 text-green-700 text-sm">
                <i class="fas fa-check-circle flex-shrink-0"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3 text-red-700 text-sm">
                <i class="fas fa-exclamation-circle flex-shrink-0"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

{{-- Mobile Bottom Navigation --}}
<nav class="lg:hidden fixed bottom-0 left-0 right-0 z-20 bg-white border-t border-gray-200 flex">
    @if(auth()->user()->isMahasiswa())
        <a href="{{ route('mahasiswa.beranda') }}"
           class="flex-1 flex flex-col items-center py-2.5 gap-1 {{ request()->routeIs('mahasiswa.beranda') ? 'text-blue-600' : 'text-gray-400' }}">
            <i class="fas fa-home text-lg"></i>
            <span class="text-xs font-medium">Beranda</span>
        </a>
        <a href="{{ route('mahasiswa.riwayat') }}"
           class="flex-1 flex flex-col items-center py-2.5 gap-1 {{ request()->routeIs('mahasiswa.riwayat') ? 'text-blue-600' : 'text-gray-400' }}">
            <i class="fas fa-history text-lg"></i>
            <span class="text-xs font-medium">Riwayat</span>
        </a>
        <a href="{{ route('mahasiswa.profil') }}"
           class="flex-1 flex flex-col items-center py-2.5 gap-1 {{ request()->routeIs('mahasiswa.profil') ? 'text-blue-600' : 'text-gray-400' }}">
            <i class="fas fa-user text-lg"></i>
            <span class="text-xs font-medium">Profil</span>
        </a>
        <a href="{{ route('mahasiswa.pengaturan') }}"
           class="flex-1 flex flex-col items-center py-2.5 gap-1 {{ request()->routeIs('mahasiswa.pengaturan') ? 'text-blue-600' : 'text-gray-400' }}">
            <i class="fas fa-cog text-lg"></i>
            <span class="text-xs font-medium">Pengaturan</span>
        </a>
    @else
        <a href="{{ route('organisasi.beranda') }}"
           class="flex-1 flex flex-col items-center py-2.5 gap-1 {{ request()->routeIs('organisasi.beranda') ? 'text-blue-600' : 'text-gray-400' }}">
            <i class="fas fa-home text-lg"></i>
            <span class="text-xs font-medium">Beranda</span>
        </a>
        <a href="{{ route('organisasi.kegiatan-saya') }}"
           class="flex-1 flex flex-col items-center py-2.5 gap-1 {{ request()->routeIs('organisasi.kegiatan-saya') ? 'text-blue-600' : 'text-gray-400' }}">
            <i class="fas fa-calendar-alt text-lg"></i>
            <span class="text-xs font-medium">Kegiatan</span>
        </a>
        <a href="{{ route('organisasi.profil') }}"
           class="flex-1 flex flex-col items-center py-2.5 gap-1 {{ request()->routeIs('organisasi.profil') ? 'text-blue-600' : 'text-gray-400' }}">
            <i class="fas fa-user text-lg"></i>
            <span class="text-xs font-medium">Profil</span>
        </a>
        <a href="{{ route('organisasi.pengaturan') }}"
           class="flex-1 flex flex-col items-center py-2.5 gap-1 {{ request()->routeIs('organisasi.pengaturan') ? 'text-blue-600' : 'text-gray-400' }}">
            <i class="fas fa-cog text-lg"></i>
            <span class="text-xs font-medium">Pengaturan</span>
        </a>
    @endif

    {{-- Logout di mobile --}}
    <form method="POST" action="{{ route('logout') }}" class="flex-1">
        @csrf
        <button type="submit" class="w-full flex flex-col items-center py-2.5 gap-1 text-red-400">
            <i class="fas fa-sign-out-alt text-lg"></i>
            <span class="text-xs font-medium">Keluar</span>
        </button>
    </form>
</nav>

@stack('scripts')
</body>
</html>