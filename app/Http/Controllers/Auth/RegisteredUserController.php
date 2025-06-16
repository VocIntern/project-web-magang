<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa; // Import model Mahasiswa
use App\Models\Perusahaan;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $role = $request->query('role', 'mahasiswa');
        return view('auth.register', compact('role'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi berdasarkan role
        $role = $request->input('role', 'mahasiswa');

        if ($role === 'mahasiswa') {
            $request->validate([
                'nama' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'role' => ['required', 'string', 'in:mahasiswa'],
            ]);
        } else { // if ($role === 'perusahaan')
            $request->validate([
                'nama_perusahaan' => ['required', 'string', 'max:255'],
                'nama_pendaftar' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'role' => ['required', 'string', 'in:perusahaan'],
            ]);
        }

        // 2. Buat User baru
        // Untuk Perusahaan, kita simpan nama PIC sebagai nama user.
        $userName = ($role === 'mahasiswa') ? $request->nama : $request->nama_pendaftar;

        $user = User::create([
            'name' => $userName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        // 3. Buat profil Mahasiswa atau Perusahaan yang terhubung
        if ($role === 'mahasiswa') {
            Mahasiswa::create([
                'user_id' => $user->id,
                'nama' => $request->nama,
                'email' => $user->email, // Ambil email dari user yang baru dibuat
            ]);
        } elseif ($role === 'perusahaan') {
            Perusahaan::create([
                'user_id' => $user->id,
                'nama_perusahaan' => $request->nama_perusahaan,
                'nama_pendaftar' => $request->nama_pendaftar,
                'email_perusahaan' => $user->email,
            ]);
        }

        event(new Registered($user));

        // Auth::login($user);
        // Redirect based on role for profile completion
        // Karena kedua role redirect ke tempat yang sama, kita bisa sederhanakan
        return redirect()->route('login')->with('status', 'Pendaftaran Berahasil! Silakan periksa email Anda untuk melakukan verifikasi sebelum login.');
    }
}
