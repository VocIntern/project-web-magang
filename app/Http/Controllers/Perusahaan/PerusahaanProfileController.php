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
    public function create(): View
    {
        return view('perusahaan.profile.create');
    }

    /**
     * Store the perusahaan profile.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'bidang' => ['required', 'string', 'max:255'],
            'nama_pendaftar' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'], // max 2MB
            'deskripsi' => ['nullable', 'string'],
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('perusahaan/logo', 'public');
        }

        Perusahaan::create([
            'user_id' => Auth::id(),
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'bidang' => $request->bidang,
            'nama_pendaftar' => $request->nama_pendaftar,
            'website' => $request->website,
            'logo' => $logoPath,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('perusahaan.dashboard')
            ->with('success', 'Profil perusahaan berhasil dibuat!');
    }

    /**
     * Display the form to edit perusahaan profile.
     */
    public function edit(): View
    {
        $perusahaan = Auth::user()->perusahaan;

        return view('perusahaan.profile.edit', compact('perusahaan'));
    }

    /**
     * Update the perusahaan profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $perusahaan = Auth::user()->perusahaan;

        $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'bidang' => ['required', 'string', 'max:255'],
            'nama_pendaftar' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'], // max 2MB
            'deskripsi' => ['nullable', 'string'],
        ]);

        $data = [
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'bidang' => $request->bidang,
            'nama_pendaftar' => $request->nama_pendaftar,
            'website' => $request->website,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($perusahaan->logo) {
                Storage::disk('public')->delete($perusahaan->logo);
            }

            $data['logo'] = $request->file('logo')->store('perusahaan/logo', 'public');
        }

        $perusahaan->update($data);

        return redirect()->route('perusahaan.dashboard')
            ->with('success', 'Profil perusahaan berhasil diperbarui!');
    }
}