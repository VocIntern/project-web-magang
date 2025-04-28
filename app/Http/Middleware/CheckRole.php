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
        Auth::user()->refresh();
        // Cek apakah user sudah login dan rolenya sesuai
        if (!Auth::check() || Auth::user()->role !== $role) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
