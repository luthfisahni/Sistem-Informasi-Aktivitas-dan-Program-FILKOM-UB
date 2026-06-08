<?php

namespace App\Http\Controllers;

use App\Models\DivisiKegiatan;
use App\Models\Kegiatan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrganisasiController extends Controller
{
    public function beranda()
    {
        $user = Auth::user()->load('organisasiProfile');

        $kegiatan = Kegiatan::where('organisasi_id', Auth::id())
            ->withCount(['pendaftaran as pendaftar_count' => function ($q) {
                $q->where('status', '!=', 'ditolak');
            }])
            ->latest()
            ->get();

        $stats = [
            'total_kegiatan'    => $kegiatan->count(),
            'kegiatan_aktif'    => $kegiatan->where('status', 'aktif')->count(),
            'total_pendaftar'   => Pendaftaran::whereIn('kegiatan_id', $kegiatan->pluck('id'))
                                    ->where('status', '!=', 'ditolak')->count(),
        ];

        return view('organisasi.beranda', compact('kegiatan', 'stats', 'user'));
    }

    public function kegiatanSaya()
    {
        $kegiatan = Kegiatan::where('organisasi_id', Auth::id())
            ->withCount(['pendaftaran as pendaftar_count' => function ($q) {
                $q->where('status', '!=', 'ditolak');
            }])
            ->latest()
            ->paginate(10);

        return view('organisasi.kegiatan-saya', compact('kegiatan'));
    }

    public function buatKegiatan()
    {
        return view('organisasi.buat-kegiatan');
    }

    public function simpanKegiatan(Request $request)
    {
        $request->validate([
            'nama_kegiatan'       => 'required|string|max:255',
            'kategori'            => 'required|in:Seminar,Workshop,Kompetisi,Kepanitiaan,Lainnya',
            'deskripsi'           => 'required|string',
            'kuota_peserta'       => 'required|integer|min:1',
            'tanggal_pelaksanaan' => 'required|date',
            'waktu'               => 'nullable|string',
            'lokasi'              => 'required|string',
            'batas_pendaftaran'   => 'nullable|date|before_or_equal:tanggal_pelaksanaan',
            'foto'                => 'nullable|image|max:5120',
            'divisi.*.nama'       => 'required_with:divisi|string',
            'divisi.*.kuota'      => 'required_with:divisi|integer|min:1',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('kegiatan', 'public');
        }

        $kegiatan = Kegiatan::create([
            'organisasi_id'       => Auth::id(),
            'nama_kegiatan'       => $request->nama_kegiatan,
            'kategori'            => $request->kategori,
            'deskripsi'           => $request->deskripsi,
            'syarat'              => $request->syarat,
            'benefit'             => $request->benefit,
            'timeline'            => $request->timeline,
            'kuota_peserta'       => $request->kuota_peserta,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'waktu'               => $request->waktu,
            'lokasi'              => $request->lokasi,
            'batas_pendaftaran'   => $request->batas_pendaftaran,
            'foto'                => $fotoPath,
        ]);

        if ($request->has('divisi')) {
            foreach ($request->divisi as $divisi) {
                if (!empty($divisi['nama'])) {
                    DivisiKegiatan::create([
                        'kegiatan_id' => $kegiatan->id,
                        'nama_divisi' => $divisi['nama'],
                        'deskripsi'   => $divisi['deskripsi'] ?? null,
                        'kuota'       => $divisi['kuota'],
                    ]);
                }
            }
        }

        return redirect()->route('organisasi.beranda')->with('success', 'Kegiatan berhasil dibuat!');
    }

    public function detailKegiatan(Kegiatan $kegiatan)
    {
        if ($kegiatan->organisasi_id !== Auth::id()) abort(403);

        $kegiatan->load(['divisi', 'pendaftaran.mahasiswa.mahasiswaProfile']);

        return view('organisasi.detail-kegiatan', compact('kegiatan'));
    }

    public function updateStatusPendaftaran(Request $request, Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->kegiatan->organisasi_id !== Auth::id()) abort(403);

        $request->validate(['status' => 'required|in:diterima,ditolak,pending']);

        $pendaftaran->update([
            'status'  => $request->status,
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function profil()
    {
        $user = Auth::user()->load('organisasiProfile');
        return view('organisasi.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'                    => 'required|string|max:255',
            'nama_organisasi'         => 'required|string',
            'deskripsi'               => 'nullable|string',
            'contact_person_nama'     => 'nullable|string',
            'contact_person_telepon'  => 'nullable|string',
            'contact_person_email'    => 'nullable|email',
            'photo'                   => 'nullable|image|max:2048',
        ]);

        $user->update(['name' => $request->name]);

        if ($request->hasFile('photo')) {
            if ($user->photo) Storage::delete('public/' . $user->photo);
            $path = $request->file('photo')->store('photos', 'public');
            $user->update(['photo' => $path]);
        }

        $user->organisasiProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['nama_organisasi', 'deskripsi', 'contact_person_nama', 'contact_person_telepon', 'contact_person_email'])
        );

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function pengaturan()
    {
        return view('organisasi.pengaturan');
    }
}