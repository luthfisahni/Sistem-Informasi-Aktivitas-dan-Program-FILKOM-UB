# SIAP FILKOM
### Sistem Informasi Aktivitas dan Program FILKOM

Platform web manajemen kegiatan mahasiswa berbasis Laravel yang memudahkan mahasiswa FILKOM Universitas Brawijaya dalam menemukan dan mendaftar kegiatan organisasi secara online.

---

## Kelompok 5

| Nama | NIM |
|------|-----|
| Damar Tyaga Wistara | 245150200111060 |
| Daud Fathin Averroes | 245150200111054 |
| Luthfi Pratama Sahni | 245150200111058 |
| Rajif Aidil Putra Afina | 245150207111072 |


---
## Demo

**https://siapfilkom.up.railway.app**

### Akun Test

| Role | Email | Password |

|------|-------|----------|

| Mahasiswa | test@example.com | password123 |

| Organisasi | bem@filkom.ub.ac.id | password123 |

| Organisasi | hmdtif@filkom.ub.ac.id | password123 |

---

Platform web manajemen kegiatan mahasiswa berbasis Laravel yang memudahkan mahasiswa FILKOM Universitas Brawijaya dalam menemukan dan mendaftar kegiatan organisasi secara online.

---
## Fitur Utama

### Untuk Mahasiswa
- Jelajahi dan cari kegiatan berdasarkan kategori
- Daftar kegiatan dengan pemilihan divisi
- Pantau riwayat & status pendaftaran (pending / diterima / ditolak)
- Kelola profil dengan foto

### Untuk Organisasi
- Buat dan kelola kegiatan (CRUD lengkap)
- Manajemen divisi kegiatan beserta kuota
- Review dan update status pendaftaran mahasiswa
- Upload foto kegiatan

### Sistem
- Autentikasi multi-peran (mahasiswa & organisasi)
- Role-based access control via Middleware
- Tampilan responsif (mobile, tablet, desktop)

---

## Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Backend | Laravel 12 (PHP) |
| Frontend | Blade Templating + Tailwind CSS |
| Database | SQLite (development) |
| ORM | Eloquent ORM |
| Build Tool | Vite + Node.js |

---

## Instalasi & Menjalankan Proyek

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- Git

### Langkah Instalasi

**1. Clone repositori**
```bash
git clone https://github.com/luthfisahni/Sistem-Informasi-Aktivitas-dan-Program-FILKOM-UB.git
cd Sistem-Informasi-Aktivitas-dan-Program-FILKOM-UB/paw-project/kegiatan-mahasiswa
```

**2. Install dependencies PHP**
```bash
composer install
```

**3. Install dependencies JavaScript**
```bash
npm install
```

**4. Konfigurasi environment**
```bash
cp .env.example .env
php artisan key:generate
```

**5. Buat file database SQLite**
```bash
touch database/database.sqlite
# Windows:
# type nul > database\database.sqlite
```

**6. Jalankan migrasi database**
```bash
php artisan migrate
```

**7. Buat symlink storage**
```bash
php artisan storage:link
```

### Menjalankan Aplikasi

Buka dua terminal secara bersamaan:

```bash
# Terminal 1 — Laravel server
php artisan serve

# Terminal 2 — Vite asset bundler
npm run dev
```

Akses aplikasi di: **http://localhost:8000**
---

## Struktur Proyek

```

app/

├── Http/

│   ├── Controllers/

│   │   ├── AuthController.php

│   │   ├── MahasiswaController.php

│   │   └── OrganisasiController.php

│   └── Middleware/

│       └── RoleMiddleware.php

├── Models/

│   ├── User.php

│   ├── Kegiatan.php

│   ├── Pendaftaran.php

│   ├── DivisiKegiatan.php

│   ├── MahasiswaProfile.php

│   └── OrganisasiProfile.php

resources/

└── views/

    ├── layouts/

    ├── auth/

    ├── mahasiswa/

    └── organisasi/

routes/

└── web.php

```

---

## Testing

Pengujian dilakukan secara manual menggunakan metode **Black Box Testing** dengan 15 skenario — seluruhnya berhasil.

Skenario yang diuji meliputi: login multi-role, registrasi, CRUD kegiatan, pendaftaran kegiatan, upload foto, filter & pencarian, kontrol akses, dan logout.
