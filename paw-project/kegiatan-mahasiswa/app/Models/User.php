<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'photo'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function mahasiswaProfile()
    {
        return $this->hasOne(MahasiswaProfile::class);
    }

    public function organisasiProfile()
    {
        return $this->hasOne(OrganisasiProfile::class);
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'organisasi_id');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'mahasiswa_id');
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    public function isOrganisasi(): bool
    {
        return $this->role === 'organisasi';
    }
}