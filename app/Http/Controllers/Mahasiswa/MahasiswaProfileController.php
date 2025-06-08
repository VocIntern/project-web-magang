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
     * Display the profile creation form for new users.
     */
    public function create(): View|RedirectResponse
    {
        $user = Auth::user();

        // Cek apakah user sudah memiliki profil mahasiswa
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        // Jika sudah ada profil, redirect ke dashboard mahasiswa
        if ($mahasiswa) {
            return redirect()->route('mahasiswa.magang.search')
                ->with('info', 'Profil Anda sudah lengkap.');
        }

        return view('mahasiswa.profile.create', compact('user'));
    }

    /**
     * Store the newly created profile.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Cek apakah user sudah memiliki profil mahasiswa
        $existingMahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if ($existingMahasiswa) {
            return redirect()->route('mahasiswa.magang.search')
                ->with('info', 'Profil Anda sudah ada.');
        }

        // Validasi input untuk pembuatan profil baru
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'nama' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'integer', 'unique:mahasiswa,nim'],
            'jurusan' => ['required', 'string', 'in:Teknik Informatika,Sistem Informasi,Teknik Komputer,Manajemen Informatika,Akuntansi,Administrasi Bisnis,Teknik Mesin,Teknik Elektro'],
            'semester' => ['required', 'string'],
            'bio' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Max 2MB
        ]);

        // Handle foto upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('mahasiswa/foto', 'public');
        }

        // Update email user jika berbeda
        if ($user->email !== $validated['email']) {
            $user->email = $validated['email'];
            $user->email_verified_at = null; // Reset verifikasi email jika email diubah
            $user->save();
        }

        // Buat data mahasiswa baru
        $mahasiswa = Mahasiswa::create([
            'user_id' => $user->id,
            'nama' => $validated['nama'],
            'nim' => $validated['nim'],
            'jurusan' => $validated['jurusan'],
            'semester' => $validated['semester'],
            'bio' => $validated['bio'],
            'foto' => $fotoPath,
        ]);

        return redirect()->route('mahasiswa.magang.search')
            ->with('success', 'Selamat! Profil mahasiswa Anda berhasil dibuat. Selamat datang di VocIntern!');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Ambil data mahasiswa berdasarkan user_id
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        // Jika belum ada profil mahasiswa, redirect ke create
        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.profile.create')
                ->with('info', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

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
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        // Jika belum ada profil mahasiswa, redirect ke create
        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.profile.create')
                ->with('info', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

        // Validasi input - sesuaikan dengan field yang ada di database
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'nama' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'integer', 'unique:mahasiswa,nim,' . $mahasiswa->id],
            'jurusan' => ['required', 'string', 'in:Teknik Informatika,Sistem Informasi,Teknik Komputer,Manajemen Informatika,Akuntansi,Administrasi Bisnis,Teknik Mesin,Teknik Elektro'],
            'semester' => ['required', 'string'],
            'bio' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Max 2MB
        ]);

        // Update data user (email)
        $user->email = $validated['email'];

        // Jika email diubah, maka atur ulang waktu verifikasi email
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

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
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        // Hapus foto jika ada
        if ($mahasiswa && $mahasiswa->foto) {
            Storage::delete('public/' . $mahasiswa->foto);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
