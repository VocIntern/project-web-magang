<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $userId = $request->route('id');
        $providedHash = (string) $request->route('hash');

        $user = User::find($userId);

        if (!$user) {
            Log::warning("User dengan ID {$userId} tidak ditemukan");
            abort(404, 'User tidak ditemukan.');
        }

        // Debug logging
        Log::info("=== EMAIL VERIFICATION DEBUG ===");
        Log::info("User ID: {$user->id}");
        Log::info("User Email: {$user->email}");
        Log::info("User Role (Database): {$user->role}");
        Log::info("Expected Hash: " . sha1($user->getEmailForVerification()));
        Log::info("Provided Hash: {$providedHash}");
        Log::info("================================");

        // Validasi hash
        if (!hash_equals($providedHash, sha1($user->getEmailForVerification()))) {
            Log::warning("Hash tidak cocok untuk user {$user->id}");
            abort(403, 'Link verifikasi tidak valid.');
        }

        // Gunakan role dari database user, bukan dari URL
        $userRole = $user->role ?? 'mahasiswa';
        Log::info("Role yang digunakan untuk redirect: {$userRole}");

        if ($user->hasVerifiedEmail()) {
            $loginRoute = $this->getLoginRoute($userRole);
            Log::info("Email sudah terverifikasi, redirect ke: {$loginRoute}");

            return redirect()->route($loginRoute)
                ->with('status', 'Email Anda sudah terverifikasi sebelumnya. Silakan login.');
        }

        // Lakukan verifikasi
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            Log::info("Email berhasil diverifikasi untuk user {$user->id}");
        }

        $loginRoute = $this->getLoginRoute($userRole);
        Log::info("Redirect ke: {$loginRoute}");

        return redirect()->route($loginRoute)
            ->with('status', 'Email Anda berhasil diverifikasi! Silakan login untuk melanjutkan.');
    }

    /**
     * Tentukan route login berdasarkan role
     */
    private function getLoginRoute(string $role): string
    {
        Log::info("Menentukan login route untuk role: {$role}");

        return match (strtolower(trim($role))) {
            'perusahaan' => 'login.perusahaan',
            'mahasiswa' => 'login',
            default => 'login'
        };
    }
}
