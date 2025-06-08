<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Mahasiswa;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $role = $request->input('role', 'mahasiswa');

        // Attempt login
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {

            $user = Auth::user();

            // Validasi role sesuai dengan form yang digunakan
            $roleValid = false;

            if ($role === 'mahasiswa' && $user->isMahasiswa()) {
                $roleValid = true;
            } elseif ($role === 'perusahaan' && $user->isPerusahaan()) {
                $roleValid = true;
            } elseif ($user->isAdmin()) {
                // Admin bisa login dari mana saja
                $roleValid = true;
            }

            // Jika role tidak sesuai, logout dan kembalikan error
            if (!$roleValid) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($role === 'mahasiswa') {
                    return back()->withErrors([
                        'email' => 'Email ini tidak terdaftar sebagai akun mahasiswa atau role tidak sesuai.',
                    ])->onlyInput('email');
                } else {
                    return back()->withErrors([
                        'email' => 'Email ini tidak terdaftar sebagai akun perusahaan atau role tidak sesuai.',
                    ])->onlyInput('email');
                }
            }

            // Jika role valid, regenerate session dan redirect
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->isMahasiswa()) {
                // Cek apakah mahasiswa sudah memiliki profil lengkap
                $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

                if (!$mahasiswa) {
                    // Jika belum ada profil mahasiswa, redirect ke form create profile
                    return redirect()->route('mahasiswa.profile.create')
                        ->with('info', 'Silakan lengkapi profil Anda terlebih dahulu untuk melanjutkan.');
                } else {
                    // Jika sudah ada profil, redirect ke dashboard mahasiswa
                    return redirect()->intended(route('mahasiswa.magang.search'));
                }
            } elseif (Auth::user()->isPerusahaan()) {
                return redirect()->route('perusahaan.dashboard');
            }

            // Fallback
            return redirect('/');
        }

        // Login gagal
        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ])->onlyInput('email');
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
