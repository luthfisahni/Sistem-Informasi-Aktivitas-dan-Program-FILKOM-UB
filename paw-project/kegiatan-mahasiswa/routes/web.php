<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\OrganisasiController;
use Illuminate\Support\Facades\Route;

// Auth (tanpa middleware guest)
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Mahasiswa Routes
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/', [MahasiswaController::class, 'beranda'])->name('beranda');
    Route::get('/kegiatan/{kegiatan}', [MahasiswaController::class, 'detailKegiatan'])->name('detail-kegiatan');
    Route::post('/kegiatan/{kegiatan}/daftar', [MahasiswaController::class, 'daftarKegiatan'])->name('daftar-kegiatan');
    Route::get('/riwayat', [MahasiswaController::class, 'riwayat'])->name('riwayat');
    Route::get('/profil', [MahasiswaController::class, 'profil'])->name('profil');
    Route::post('/profil', [MahasiswaController::class, 'updateProfil'])->name('profil.update');
    Route::get('/pengaturan', [MahasiswaController::class, 'pengaturan'])->name('pengaturan');
    Route::post('/pengaturan/password', [MahasiswaController::class, 'updatePassword'])->name('password.update');
});

// Organisasi Routes
Route::middleware(['auth', 'role:organisasi'])->prefix('organisasi')->name('organisasi.')->group(function () {
    Route::get('/', [OrganisasiController::class, 'beranda'])->name('beranda');
    Route::get('/kegiatan', [OrganisasiController::class, 'kegiatanSaya'])->name('kegiatan-saya');
    Route::get('/kegiatan/buat', [OrganisasiController::class, 'buatKegiatan'])->name('buat-kegiatan');
    Route::post('/kegiatan/buat', [OrganisasiController::class, 'simpanKegiatan'])->name('simpan-kegiatan');
    Route::get('/kegiatan/{kegiatan}', [OrganisasiController::class, 'detailKegiatan'])->name('detail-kegiatan');
    Route::post('/pendaftaran/{pendaftaran}/status', [OrganisasiController::class, 'updateStatusPendaftaran'])->name('update-status');
    Route::get('/profil', [OrganisasiController::class, 'profil'])->name('profil');
    Route::post('/profil', [OrganisasiController::class, 'updateProfil'])->name('profil.update');
    Route::get('/pengaturan', [OrganisasiController::class, 'pengaturan'])->name('pengaturan');
});