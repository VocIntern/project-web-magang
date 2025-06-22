<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        // Cek jika pengguna sudah memiliki email yang terverifikasi
        if ($request->user()->hasVerifiedEmail()) {

            // Jika sudah, tentukan dashboard yang sesuai dengan rolenya
            $redirectRoute = $request->user()->role === 'perusahaan'
                ? 'perusahaan.dashboard'
                : 'mahasiswa.magang.search';

            // Arahkan ke dashboard yang seharusnya
            return redirect()->intended(route($redirectRoute, absolute: false));
        }

        // Jika belum terverifikasi, kirim email notifikasi
        $request->user()->sendEmailVerificationNotification();

        // Kembali ke halaman sebelumnya dengan pesan status
        return back()->with('status', 'verification-link-sent');
    }
}
