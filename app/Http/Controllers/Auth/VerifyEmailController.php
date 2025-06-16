<?php
// app/Http/Controllers/Auth/VerifyEmailController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Jika pengguna sudah login dan emailnya terverifikasi, arahkan ke dashboard yang sesuai
        if ($request->user() && $request->user()->hasVerifiedEmail()) {
            $redirectRoute = $request->user()->role . '.dashboard'; // asumsikan ada route seperti 'mahasiswa.dashboard'
            return redirect()->intended(route($redirectRoute, absolute: false) . '?verified=1');
        }

        // Jika pengguna belum login, proses verifikasi tetap berjalan berdasarkan signed URL
        // Setelah verifikasi, arahkan ke halaman login.
        if ($request->user() && !$request->user()->hasVerifiedEmail()) {
            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }
        }

        // Log out pengguna jika ada sesi yang aktif, agar dipaksa login ulang
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        // Arahkan ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('status', 'Email Anda berhasil diverifikasi! Silakan login untuk melanjutkan.');
    }
}
