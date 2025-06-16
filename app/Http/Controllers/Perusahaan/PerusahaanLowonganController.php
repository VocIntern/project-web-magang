<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Models\Magang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerusahaanLowonganController extends Controller
{
    /**
     * Menampilkan form untuk membuat lowongan baru.
     */

    public function index()
    {
        // Ambil semua lowongan milik perusahaan yang sedang login, urutkan dari yang terbaru
        $lowongans = Auth::user()->perusahaan->magang()
            ->latest()
            ->paginate(10); // Gunakan paginasi

        return view('perusahaan.lowongan.index', compact('lowongans'));
    }


    public function create()
    {
        return view('perusahaan.lowongan.create');
    }

    /**
     * Menyimpan lowongan baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $validatedData = $request->validate([
            'judul'           => 'required|string|max:255',
            'bidang'          => 'required|string|max:255',
            'deskripsi'       => 'required|string',
            'lokasi'          => 'required|string|max:255',
            'kuota'           => 'required|integer|min:1',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // 2. Dapatkan ID perusahaan yang sedang login
        $perusahaanId = Auth::user()->perusahaan->id;

        // 3. Tambahkan perusahaan_id ke data yang akan disimpan
        $validatedData['perusahaan_id'] = $perusahaanId;
        $validatedData['status_aktif'] = true; // Langsung set aktif saat dibuat

        // 4. Simpan data ke database
        Magang::create($validatedData);

        // 5. Kembali ke dashboard dengan pesan sukses
        return redirect()->route('perusahaan.dashboard')
            ->with('success', 'Lowongan magang baru berhasil dibuat!');
    }

    public function edit(Magang $magang)
    {
        // Otorisasi: Pastikan perusahaan hanya bisa mengedit lowongannya sendiri.
        if ($magang->perusahaan_id !== Auth::user()->perusahaan->id) {
            abort(403, 'AKSES DITOLAK');
        }

        return view('perusahaan.lowongan.edit', compact('magang'));
    }

    /**
     * Memperbarui data lowongan di database.
     */
    public function update(Request $request, Magang $magang)
    {
        // Otorisasi: Pengecekan keamanan ganda.
        if ($magang->perusahaan_id !== Auth::user()->perusahaan->id) {
            abort(403, 'AKSES DITOLAK');
        }

        // 1. Validasi input dari form (aturannya sama seperti store)
        $validatedData = $request->validate([
            'judul'           => 'required|string|max:255',
            'bidang'          => 'required|string|max:255',
            'deskripsi'       => 'required|string',
            'lokasi'          => 'required|string|max:255',
            'kuota'           => 'required|integer|min:1',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // 2. Update data lowongan
        $magang->update($validatedData);

        // 3. Kembali ke dashboard dengan pesan sukses
        // (Nantinya lebih baik redirect ke halaman daftar lowongan)
        return redirect()->route('perusahaan.dashboard')
            ->with('success', 'Lowongan magang berhasil diperbarui!');
    }

     public function destroy(Magang $magang)
    {
        // Otorisasi: Pastikan perusahaan hanya bisa menghapus lowongannya sendiri.
        if ($magang->perusahaan_id !== Auth::user()->perusahaan->id) {
            abort(403, 'AKSES DITOLAK');
        }

        $magang->delete();

        return redirect()->route('perusahaan.lowongan.index')
            ->with('success', 'Lowongan magang berhasil dihapus.');
    }
}
