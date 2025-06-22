<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // Cek jika pengguna sudah memiliki email yang terverifikasi
        if ($request->user()->hasVerifiedEmail()) {
            
            // Jika sudah, tentukan dashboard yang sesuai dengan rolenya
            $redirectRoute = $request->user()->role === 'perusahaan' 
                                ? 'perusahaan.dashboard' 
                                : 'mahasiswa.magang.search';
            
            // Arahkan pengguna ke dashboard yang seharusnya
            return redirect()->intended(route($redirectRoute, absolute: false));
        }

        // Jika email belum terverifikasi, tampilkan halaman pemberitahuan
        return view('auth.verify-email');
    }
}