<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';

    protected $fillable = [
        'organisasi_id', 'nama_kegiatan', 'kategori', 'deskripsi',
        'syarat', 'benefit', 'timeline', 'kuota_peserta',
        'tanggal_pelaksanaan', 'waktu', 'lokasi', 'batas_pendaftaran',
        'foto', 'status',
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
        'batas_pendaftaran'   => 'date',
    ];

    public function organisasi()
    {
        return $this->belongsTo(User::class, 'organisasi_id');
    }

    public function divisi()
    {
        return $this->hasMany(DivisiKegiatan::class);
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function getPendaftarCountAttribute(): int
    {
        return $this->pendaftaran()->where('status', '!=', 'ditolak')->count();
    }

    public function isFull(): bool
    {
        return $this->pendaftar_count >= $this->kuota_peserta;
    }

    public function isOpenForRegistration(): bool
    {
        return $this->status === 'aktif'
            && ($this->batas_pendaftaran === null || $this->batas_pendaftaran->isFuture() || $this->batas_pendaftaran->isToday());
    }
}