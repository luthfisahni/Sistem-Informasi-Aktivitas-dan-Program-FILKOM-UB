<?php

namespace Database\Seeders;

use App\Models\OrganisasiProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OrganisasiSeeder extends Seeder
{
    public function run(): void
    {
        $organisasi = [
            [
                'name'  => 'BEM FILKOM',
                'email' => 'bem@filkom.ub.ac.id',
                'nama_organisasi' => 'BEM FILKOM',
                'contact_person_nama'     => 'Ketua BEM',
                'contact_person_telepon'  => '081234567890',
                'contact_person_email'    => 'bem@filkom.ub.ac.id',
            ],
            [
                'name'  => 'Himpunan Teknik Informatika',
                'email' => 'hmdtif@filkom.ub.ac.id',
                'nama_organisasi' => 'Himpunan Departemen Teknik Informatika',
                'contact_person_nama'     => 'Ketua HMDTIF',
                'contact_person_telepon'  => '082345678901',
                'contact_person_email'    => 'hmdtif@filkom.ub.ac.id',
            ],
        ];

        foreach ($organisasi as $data) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make('password123'),
                'role'     => 'organisasi',
            ]);

            OrganisasiProfile::create([
                'user_id'                => $user->id,
                'nama_organisasi'        => $data['nama_organisasi'],
                'contact_person_nama'    => $data['contact_person_nama'],
                'contact_person_telepon' => $data['contact_person_telepon'],
                'contact_person_email'   => $data['contact_person_email'],
            ]);
        }
    }
}