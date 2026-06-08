<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function beranda(Request $request)
    {
        $query = Kegiatan::with(['organisasi.organisasiProfile', 'pendaftaran'])
            ->where('status', 'aktif');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('nama_kegiatan', 'like', '%' . $request->search . '%');
        }

        $kegiatan = $query->latest()->paginate(9);

        return view('mahasiswa.beranda', compact('kegiatan'));
    }

    public function detailKegiatan(Kegiatan $kegiatan)
    {
        $kegiatan->load(['organisasi.organisasiProfile', 'divisi', 'pendaftaran']);
        $sudahDaftar = Auth::user()->pendaftaran()->where('kegiatan_id', $kegiatan->id)->first();

        return view('mahasiswa.detail-kegiatan', compact('kegiatan', 'sudahDaftar'));
    }

    public function daftarKegiatan(Request $request, Kegiatan $kegiatan)
    {
        if (!$kegiatan->isOpenForRegistration()) {
            return back()->with('error', 'Pendaftaran sudah ditutup.');
        }

        $sudahDaftar = Auth::user()->pendaftaran()->where('kegiatan_id', $kegiatan->id)->exists();
        if ($sudahDaftar) {
            return back()->with('error', 'Anda sudah mendaftar kegiatan ini.');
        }

        Pendaftaran::create([
            'mahasiswa_id' => Auth::id(),
            'kegiatan_id'  => $kegiatan->id,
            'divisi_id'    => $request->divisi_id,
            'status'       => 'pending',
        ]);

        return back()->with('success', 'Pendaftaran berhasil! Menunggu konfirmasi dari organisasi.');
    }

    public function riwayat(Request $request)
    {
        $query = Auth::user()->pendaftaran()->with(['kegiatan.organisasi.organisasiProfile']);

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('kegiatan', function ($q) use ($request) {
                $q->where('nama_kegiatan', 'like', '%' . $request->search . '%');
            });
        }

        $pendaftaran = $query->latest()->get();

        $stats = [
            'total'    => Auth::user()->pendaftaran()->count(),
            'diterima' => Auth::user()->pendaftaran()->where('status', 'diterima')->count(),
            'pending'  => Auth::user()->pendaftaran()->where('status', 'pending')->count(),
            'ditolak'  => Auth::user()->pendaftaran()->where('status', 'ditolak')->count(),
        ];

        return view('mahasiswa.riwayat', compact('pendaftaran', 'stats'));
    }

    public function profil()
    {
        $user = Auth::user()->load('mahasiswaProfile');
        return view('mahasiswa.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'          => 'required|string|max:255',
            'no_telepon'    => 'nullable|string',
            'program_studi' => 'nullable|string',
            'semester'      => 'nullable|string',
            'angkatan'      => 'nullable|string',
            'alamat'        => 'nullable|string',
            'bio'           => 'nullable|string',
            'photo'         => 'nullable|image|max:2048',
        ]);

        $user->update(['name' => $request->name]);

        if ($request->hasFile('photo')) {
            if ($user->photo) Storage::delete('public/' . $user->photo);
            $path = $request->file('photo')->store('photos', 'public');
            $user->update(['photo' => $path]);
        }

        $user->mahasiswaProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['nim', 'no_telepon', 'program_studi', 'semester', 'angkatan', 'alamat', 'bio'])
        );

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function pengaturan()
    {
        return view('mahasiswa.pengaturan');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'password'              => 'required|min:8|confirmed',
        ]);

        if (!\Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        Auth::user()->update(['password' => \Hash::make($request->password)]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}