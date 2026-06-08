<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MahasiswaProfile extends Model
{
    protected $fillable = [
        'user_id', 'nim', 'no_telepon', 'program_studi',
        'semester', 'angkatan', 'alamat', 'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}