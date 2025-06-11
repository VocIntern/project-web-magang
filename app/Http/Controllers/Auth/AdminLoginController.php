<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    /**
     * Menampilkan halaman/form login untuk admin.
     */
    public function showLoginForm(): View
    {
        return view('auth.admin_login');
    }

    /**
     * Menangani permintaan login yang masuk dari form admin.
     */
    public function login(Request $request): RedirectResponse
    {
        // 1. Validasi input dari form
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. Mencoba untuk melakukan autentikasi dengan kredensial yang diberikan
        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            // 3. PENTING: Lakukan pengecekan role setelah login berhasil
            // Ini adalah lapisan keamanan tambahan yang krusial.
            if (Auth::user()->role !== 'admin') {
                // Jika yang login bukan admin, paksa logout dan tolak akses
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akses ditolak. Akun ini bukan akun administrator.',
                ])->onlyInput('email');
            }

            // 4. Jika login berhasil dan role adalah 'admin'
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // 5. Jika autentikasi gagal (email/password salah)
        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }
}
