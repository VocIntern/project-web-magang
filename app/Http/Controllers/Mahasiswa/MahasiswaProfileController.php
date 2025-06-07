<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class MahasiswaProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Ambil data mahasiswa berdasarkan user_id
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        return view('mahasiswa.profile.edit', [
            'user' => $user,
            'mahasiswa' => $mahasiswa
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validasi input - sesuaikan dengan field yang ada di database
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'nama' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'integer', 'unique:mahasiswa,nim,' . ($user->mahasiswa->id ?? 'NULL')],
            'jurusan' => ['required', 'string', 'in:Teknik Informatika,Sistem Informasi,Teknik Komputer,Manajemen Informatika,Akuntansi,Administrasi Bisnis,Teknik Mesin,Teknik Elektro'],
            'semester' => ['required', 'string'],
            'bio' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Max 2MB
        ]);

        // Update data user
        // $user->mahasiswa->nama = $validated['nama'];
        $user->email = $validated['email'];

        // Jika email diubah, maka atur ulang waktu verifikasi email
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update atau buat data mahasiswa
        $mahasiswa = Mahasiswa::firstOrNew(['user_id' => $user->id]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($mahasiswa->foto) {
                Storage::delete('public/' . $mahasiswa->foto);
            }

            // Upload foto baru
            $fotoPath = $request->file('foto')->store('mahasiswa/foto', 'public');
            $mahasiswa->foto = $fotoPath;
        }

        // Update data mahasiswa sesuai dengan field yang ada di database
        $mahasiswa->nama = $validated['nama'];
        $mahasiswa->nim = $validated['nim'];
        $mahasiswa->jurusan = $validated['jurusan'];
        $mahasiswa->semester = $validated['semester'];
        $mahasiswa->bio = $validated['bio'] ?? null;

        $mahasiswa->save();

        return Redirect::route('mahasiswa.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Hapus foto jika ada
        if ($user->mahasiswa && $user->mahasiswa->foto) {
            Storage::delete('public/' . $user->mahasiswa->foto);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
