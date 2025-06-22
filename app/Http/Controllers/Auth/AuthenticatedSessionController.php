<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Mahasiswa;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function createPerusahaan(): View
    {
        return view('auth.login-perusahaan');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input dasar
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'role' => ['required', 'string', 'in:mahasiswa,perusahaan'],
        ]);

        // 2. Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // 3. Pengecekan baru dengan pesan error spesifik
        // Case 1: User tidak ditemukan sama sekali.
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'), // Tampilkan pesan error umum untuk keamanan
            ]);
        }

        // Case 2: User ditemukan, TAPI role tidak sesuai dengan form yang diisi.
        if ($user->role !== $request->role) {
            // Mapping role ke format yang mudah dibaca
            $roleLabels = [
                'mahasiswa' => 'Mahasiswa',
                'perusahaan' => 'Perusahaan',
                'admin' => 'Admin'
            ];

            // Dapatkan label role yang seharusnya
            $expectedRole = $roleLabels[$user->role] ?? 'Unknown';

            // Buat pesan error yang spesifik berdasarkan role
            $errorMessage = "Akun Anda terdaftar sebagai {$expectedRole}. Silakan gunakan form login {$expectedRole}.";

            throw ValidationException::withMessages([
                'email' => $errorMessage,
            ]);
        }

        // 4. Jika user dan role cocok, baru coba autentikasi password (Case 3: Password salah)
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'), // Tampilkan pesan error umum
            ]);
        }

        // 5. Jika semua berhasil, regenerasi session dan redirect
        $request->session()->regenerate();

        if ($user->isMahasiswa()) {
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            if (!$mahasiswa) {
                return redirect()->route('mahasiswa.profile.create')
                    ->with('info', 'Silakan lengkapi profil Anda terlebih dahulu untuk melanjutkan.');
            }
            return redirect()->intended(route('mahasiswa.magang.search'));
        } elseif ($user->isPerusahaan()) {
            $perusahaan = Perusahaan::where('user_id', $user->id)->first();
            if (!$perusahaan) {
                return redirect()->route('perusahaan.profile.create')
                    ->with('info', 'Silakan lengkapi profil perusahaan Anda terlebih dahulu.');
            }
            return redirect()->intended(route('perusahaan.dashboard'));
        }

        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
