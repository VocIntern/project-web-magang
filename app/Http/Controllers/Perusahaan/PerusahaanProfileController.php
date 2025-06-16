<?php

namespace App\Http\Controllers\Perusahaan;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

class PerusahaanProfileController extends Controller
{
    /**
     * Display the form to create perusahaan profile.
     */
    public function create(): View|RedirectResponse
    {
        // Cek jika perusahaan sudah punya profil, redirect ke dashboard
        if (Auth::user()->perusahaan) {
            return redirect()->route('perusahaan.dashboard')->with('info', 'Anda sudah memiliki profil perusahaan.');
        }
        return view('perusahaan.profile.create');
    }

    /**
     * Store the perusahaan profile.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'bidang' => ['required', 'string', 'max:255'],
            'nama_pendaftar' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'], // max 2MB
            'deskripsi' => ['nullable', 'string'],
        ]);

        // 2. Hubungkan dengan user yang sedang login
        $validatedData['user_id'] = Auth::id();

        // 3. Proses upload logo jika ada
        if ($request->hasFile('logo')) {
            // Simpan file di 'storage/app/public/logos' dan dapatkan path-nya
            $path = $request->file('logo')->store('logos', 'public');
            $validatedData['logo'] = $path;
        }

        Perusahaan::create($validatedData);

        return redirect()->route('perusahaan.dashboard')
            ->with('success', 'Profil perusahaan berhasil dibuat!');
    }

    /**
     * Display the form to edit perusahaan profile.
     */
    public function edit(): View|RedirectResponse
    {
        $perusahaan = Auth::user()->perusahaan;

        // Tambahkan pengecekan ini
        if (!$perusahaan) {
            return redirect()->route('perusahaan.profile.create')
                ->with('info', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

        return view('perusahaan.profile.edit', compact('perusahaan'));
    }

    /**
     * Update the perusahaan profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $perusahaan = Auth::user()->perusahaan;

        $validatedData = $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'bidang' => ['required', 'string', 'max:255'],
            'nama_pendaftar' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'], // max 2MB
            'deskripsi' => ['nullable', 'string'],
        ]);

        unset($validatedData['logo']);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($perusahaan->logo) {
                Storage::disk('public')->delete($perusahaan->logo);
            }

            $validatedData['logo'] = $request->file('logo')->store('perusahaan/logo', 'public');
        }

        $perusahaan->update($validatedData);

        return redirect()->route('perusahaan.dashboard')
            ->with('success', 'Profil perusahaan berhasil diperbarui!');
    }
}
