<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Cek kelengkapan profil berdasarkan role
        if ($user->role === 'mahasiswa') {
            // Memeriksa apakah mahasiswa memiliki profil
            $mahasiswa = $user->mahasiswa;

            if (
                !$mahasiswa ||
                empty($mahasiswa->nim) ||
                empty($mahasiswa->jurusan) ||
                empty($mahasiswa->angkatan)
            ) {
                return redirect()->route('mahasiswa.profile.edit')
                    ->with('warning', 'Mohon lengkapi profil Anda sebelum melanjutkan.');
            }
        } elseif ($user->role === 'perusahaan') {
            // Memeriksa apakah perusahaan memiliki profil
            $perusahaan = $user->perusahaan;

            if (
                !$perusahaan ||
                empty($perusahaan->nama_perusahaan) ||
                empty($perusahaan->alamat) ||
                empty($perusahaan->bidang)
            ) {
                return redirect()->route('perusahaan.profile.edit')
                    ->with('warning', 'Mohon lengkapi profil perusahaan Anda sebelum melanjutkan.');
            }
        }

        return $next($request);
    }
}
