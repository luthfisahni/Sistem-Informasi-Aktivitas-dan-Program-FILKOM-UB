<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'role'     => 'required|in:mahasiswa,organisasi',
        ]);

        $user = User::where('email', $request->email)->where('role', $request->role)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah, atau role tidak sesuai.'])->withInput();
        }

        Auth::login($user, $request->boolean('remember'));

        return redirect()->route($user->isMahasiswa() ? 'mahasiswa.beranda' : 'organisasi.beranda');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|min:8|confirmed',
            'nim'                   => 'required|string',
            'program_studi'         => 'required|string',
            'angkatan'              => 'required|string',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'mahasiswa',
        ]);

        MahasiswaProfile::create([
            'user_id'       => $user->id,
            'nim'           => $request->nim,
            'program_studi' => $request->program_studi,
            'angkatan'      => $request->angkatan,
        ]);

        Auth::login($user);

        return redirect()->route('mahasiswa.beranda')->with('success', 'Akun berhasil dibuat!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}