<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendaftaranMagang;
use App\Models\Mahasiswa;
use App\Models\Magang;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SeleksiMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil perusahaan yang sedang login
        $perusahaan = Auth::user()->perusahaan;

        if (!$perusahaan) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses sebagai perusahaan');
        }

        // Query untuk mendapatkan pendaftar magang dari perusahaan ini
        $query = PendaftaranMagang::with(['mahasiswa.user', 'magang'])
            ->whereHas('magang', function ($q) use ($perusahaan) {
                $q->where('perusahaan_id', $perusahaan->id);
            });

        // Filter berdasarkan parameter yang diterima
        if ($request->filled('jurusan')) {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('jurusan', 'like', '%' . $request->jurusan . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('cari_nama')) {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->cari_nama . '%');
            });
        }

        $pendaftaranMagang = $query->latest()->get();

        // Hitung statistik
        $totalPelamar = PendaftaranMagang::whereHas('magang', function ($q) use ($perusahaan) {
            $q->where('perusahaan_id', $perusahaan->id);
        })->count();

        $menunggueview = PendaftaranMagang::whereHas('magang', function ($q) use ($perusahaan) {
            $q->where('perusahaan_id', $perusahaan->id);
        })->where('status', 'menunggu')->count();

        $tahapInterview = PendaftaranMagang::whereHas('magang', function ($q) use ($perusahaan) {
            $q->where('perusahaan_id', $perusahaan->id);
        })->where('status', 'interview')->count();

        $diterima = PendaftaranMagang::whereHas('magang', function ($q) use ($perusahaan) {
            $q->where('perusahaan_id', $perusahaan->id);
        })->where('status', 'diterima')->count();

        // Ambil data untuk dropdown filter
        $jurusanList = Mahasiswa::select('jurusan')->distinct()->pluck('jurusan');
        $universitasList = User::whereIn('id', function ($query) {
            $query->select('user_id')->from('mahasiswa');
        })->select('email')->get()->map(function ($user) {
            // Asumsi universitas bisa diambil dari email domain atau field lain
            // Untuk sementara kita buat list manual
            return $user->email;
        });

        return view('perusahaan.seleksi-mahasiswa', compact(
            'pendaftaranMagang',
            'totalPelamar',
            'menunggueview',
            'tahapInterview',
            'diterima',
            'jurusanList',
            'perusahaan'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,interview,diterima,ditolak',
            'catatan' => 'nullable|string'
        ]);

        $pendaftaran = PendaftaranMagang::findOrFail($id);

        // Pastikan pendaftaran ini milik perusahaan yang sedang login
        $perusahaan = Auth::user()->perusahaan;
        if ($pendaftaran->magang->perusahaan_id !== $perusahaan->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $pendaftaran->update([
            'status' => $request->status,
            'catatan' => $request->catatan
        ]);

        // Update tanggal mulai dan selesai jika diterima
        if ($request->status === 'diterima') {
            $pendaftaran->update([
                'tanggal_mulai' => $pendaftaran->magang->tanggal_mulai,
                'tanggal_selesai' => $pendaftaran->magang->tanggal_selesai,
                'status_magang' => 'belum_mulai'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui'
        ]);
    }

    public function detail($id)
    {
        $pendaftaran = PendaftaranMagang::with(['mahasiswa.user', 'magang'])
            ->findOrFail($id);

        $perusahaan = Auth::user()->perusahaan;
        if ($pendaftaran->magang->perusahaan_id !== $perusahaan->id) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        return view('perusahaan.detail-mahasiswa', compact('pendaftaran'));
    }
}
