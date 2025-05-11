<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Magang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MahasiswaProfileController extends Controller
{
    /**
     * Display the form to create mahasiswa profile.
     */
    public function create(): View
    {
        return view('mahasiswa.profile.create');
    }

    /**
     * Store the mahasiswa profile.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'integer', 'unique:mahasiswa'],
            'jurusan' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'string', 'max:20'],
            'bio' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'], // max 2MB
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('mahasiswa/foto', 'public');
        }

        Mahasiswa::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'semester' => $request->semester,
            'bio' => $request->bio,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('magang.search')
            ->with('success', 'Profil mahasiswa berhasil dibuat!');
    }

    /**
     * Display the form to edit mahasiswa profile.
     */
    public function edit(): View
    {
        $mahasiswa = Auth::user()->mahasiswa;

        return view('mahasiswa.profile.edit', compact('mahasiswa'));
    }

    /**
     * Update the mahasiswa profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'integer', 'unique:mahasiswa,nim,' . $mahasiswa->id],
            'jurusan' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'string', 'max:20'],
            'bio' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'], // max 2MB
        ]);

        $data = [
            'nama' => $request->nama,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'semester' => $request->semester,
            'bio' => $request->bio,
        ];

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($mahasiswa->foto) {
                Storage::disk('public')->delete($mahasiswa->foto);
            }

            $data['foto'] = $request->file('foto')->store('mahasiswa/foto', 'public');
        }

        $mahasiswa->update($data);

        return redirect()->route('mahasiswa.dashboard')
            ->with('success', 'Profil mahasiswa berhasil diperbarui!');
    }
}