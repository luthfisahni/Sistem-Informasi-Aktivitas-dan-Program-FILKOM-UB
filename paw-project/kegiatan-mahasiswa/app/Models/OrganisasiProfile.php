<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganisasiProfile extends Model
{
    protected $fillable = [
        'user_id', 'nama_organisasi', 'deskripsi',
        'contact_person_nama', 'contact_person_telepon', 'contact_person_email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}