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

        // Attempt login
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $user = Auth::user();
            $request->session()->regenerate();

            // Auto redirect berdasarkan role user
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isMahasiswa()) {
                // Cek apakah mahasiswa sudah memiliki profil lengkap
                $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

                if (!$mahasiswa) {
                    return redirect()->route('mahasiswa.profile.create')
                        ->with('info', 'Silakan lengkapi profil Anda terlebih dahulu untuk melanjutkan.');
                } else {
                    return redirect()->intended(route('mahasiswa.magang.search'));
                }
            } elseif ($user->isPerusahaan()) {
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
