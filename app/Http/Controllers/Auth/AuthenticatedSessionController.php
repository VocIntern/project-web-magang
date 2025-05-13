<?php
// <!-- app\Http\Controllers\Auth\AuthenticatedSessionController.php -->
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

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
                // Admin bisa login dari mana saja (opsional)
                $roleValid = true;
            }

            // Jika role tidak sesuai, logout dan kembalikan error
            if (!$roleValid) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($role === 'mahasiswa') {
                    return back()->withErrors([
                        'email' => 'Email ini terdaftar sebagai akun perusahaan. Silakan login melalui form perusahaan.',
                    ])->onlyInput('email');
                } else {
                    return back()->withErrors([
                        'email' => 'Email ini terdaftar sebagai akun mahasiswa. Silakan login melalui form mahasiswa.',
                    ])->onlyInput('email');
                }
            }

            // Jika role valid, regenerate session dan redirect
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->isMahasiswa()) {
                return redirect()->intended(route('mahasiswa.magang.search'));
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
