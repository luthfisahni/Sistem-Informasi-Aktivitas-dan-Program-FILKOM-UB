<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisiKegiatan extends Model
{
    protected $table = 'divisi_kegiatan';

    protected $fillable = ['kegiatan_id', 'nama_divisi', 'deskripsi', 'kuota'];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'divisi_id');
    }

    public function getPendaftarCountAttribute(): int
    {
        return $this->pendaftaran()->where('status', '!=', 'ditolak')->count();
    }
}