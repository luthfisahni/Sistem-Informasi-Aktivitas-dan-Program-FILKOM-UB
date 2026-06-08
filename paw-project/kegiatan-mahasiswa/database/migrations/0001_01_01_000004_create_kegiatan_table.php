<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisasi_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_kegiatan');
            $table->enum('kategori', ['Seminar', 'Workshop', 'Kompetisi', 'Kepanitiaan', 'Lainnya']);
            $table->text('deskripsi')->nullable();
            $table->text('syarat')->nullable();
            $table->text('benefit')->nullable();
            $table->text('timeline')->nullable();
            $table->integer('kuota_peserta');
            $table->date('tanggal_pelaksanaan');
            $table->time('waktu')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('batas_pendaftaran')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};