<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if ($user->role !== $role) {
            // Redirect based on user's actual role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak.');
                case 'mahasiswa':
                    return redirect()->route('mahasiswa.profile.create')->with('error', 'Akses ditolak.');
                case 'perusahaan':
                    return redirect()->route('perusahaan.dashboard')->with('error', 'Akses ditolak.');
                default:
                    return redirect()->route('login')->with('error', 'Akses ditolak.');
            }
        }

        return $next($request);
    }
}
