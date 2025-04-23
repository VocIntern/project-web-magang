<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Cek apakah profil sudah lengkap berdasarkan role
        if ($user->role == 'mahasiswa' && !$this->isMahasiswaProfileComplete($user)) {
            return redirect()->route('profile.edit')->with('warning', 'Mohon lengkapi profil Anda terlebih dahulu.');
        }

        if ($user->role == 'perusahaan' && !$this->isCompanyProfileComplete($user)) {
            return redirect()->route('company.profile.edit')->with('warning', 'Mohon lengkapi profil perusahaan Anda terlebih dahulu.');
        }

        return $next($request);
    }

    /**
     * Check if mahasiswa profile is complete
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    private function isMahasiswaProfileComplete($user)
    {
        // Sesuaikan berdasarkan field yang dianggap wajib untuk profil mahasiswa
        return $user->mahasiswa &&
            $user->mahasiswa->nim &&
            $user->mahasiswa->study_program &&
            $user->mahasiswa->semester &&
            $user->mahasiswa->phone;
    }

    /**
     * Check if company profile is complete
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    private function isCompanyProfileComplete($user)
    {
        // Sesuaikan berdasarkan field yang dianggap wajib untuk profil perusahaan
        return $user->company &&
            $user->company->company_name &&
            $user->company->industry &&
            $user->company->address &&
            $user->company->phone;
    }
}
