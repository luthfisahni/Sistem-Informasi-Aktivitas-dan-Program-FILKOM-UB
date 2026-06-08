<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = ['mahasiswa_id', 'kegiatan_id', 'divisi_id', 'status', 'catatan'];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function divisi()
    {
        return $this->belongsTo(DivisiKegiatan::class, 'divisi_id');
    }
}