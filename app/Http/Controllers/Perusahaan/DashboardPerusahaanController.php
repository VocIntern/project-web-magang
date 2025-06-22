<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Perusahaan;
use App\Models\Magang;
use App\Models\PendaftaranMagang;
use App\Models\Mahasiswa;
use App\Models\User;

class DashboardPerusahaanController extends Controller
{

    public function index()
    {

        $perusahaan = Auth::user()->perusahaan;

        // Jika user belum punya profil perusahaan, paksa untuk membuat profil dulu.
        if (!$perusahaan) {
            return redirect()->route('perusahaan.profile.create')
                ->with('info', 'Selamat datang! Silakan lengkapi profil perusahaan Anda terlebih dahulu untuk melanjutkan.');
        }

        // --- PENGAMBILAN DATA UNTUK DASHBOARD ---

        // Dapatkan semua ID lowongan milik perusahaan ini
        $magangIds = $perusahaan->magang()->pluck('id');

        // 1. Hitung total lowongan
        $totalLowongan = $magangIds->count();

        // 2. Hitung magang yang sedang aktif (tanggal hari ini di antara tgl mulai & selesai)
        $magangAktif = $perusahaan->magang()
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->count();

        // 3. Ambil 5 lowongan terbaru
        $lowonganTerbaru = $perusahaan->magang()->latest()->take(5)->get();

        // 4. Hitung total pelamar
        $totalPelamar = PendaftaranMagang::whereIn('magang_id', $magangIds)->count();

        // 5. Ambil 5 pelamar terbaru, eager load relasi untuk performa
        $pelamarTerbaru = PendaftaranMagang::whereIn('magang_id', $magangIds)
            ->with(['mahasiswa', 'magang'])
            ->latest()
            ->take(5)
            ->get();

        return view('perusahaan.dashboard', compact(
            'perusahaan',
            'totalLowongan',
            'magangAktif',
            'totalPelamar',
            'lowonganTerbaru',
            'pelamarTerbaru'
        ));
    }

    public function seleksiMahasiswa(Request $request)
    {
        $user = Auth::user();
        $perusahaan = Perusahaan::where('user_id', $user->id)->first();

        // Statistik untuk seleksi
        $totalPelamar = PendaftaranMagang::whereHas('magang', function ($query) use ($perusahaan) {
            $query->where('perusahaan_id', $perusahaan->id);
        })->count();

        $menungguReview = PendaftaranMagang::whereHas('magang', function ($query) use ($perusahaan) {
            $query->where('perusahaan_id', $perusahaan->id);
        })->where('status', 'menunggu')->count();

        $tahapInterview = PendaftaranMagang::whereHas('magang', function ($query) use ($perusahaan) {
            $query->where('perusahaan_id', $perusahaan->id);
        })->where('status', 'interview')->count();

        $diterima = PendaftaranMagang::whereHas('magang', function ($query) use ($perusahaan) {
            $query->where('perusahaan_id', $perusahaan->id);
        })->where('status', 'diterima')->count();

        // Query untuk mahasiswa dengan filter
        $query = PendaftaranMagang::with(['mahasiswa.user', 'magang'])
            ->whereHas('magang', function ($q) use ($perusahaan) {
                $q->where('perusahaan_id', $perusahaan->id);
            });

        // Filter berdasarkan parameter request
        if ($request->filled('jurusan')) {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('jurusan', 'like', '%' . $request->jurusan . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('nama')) {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        $mahasiswaPelamar = $query->orderBy('created_at', 'desc')->paginate(12);

        // Data untuk dropdown filter
        $jurusanList = Mahasiswa::whereHas('pendaftaranMagang.magang', function ($q) use ($perusahaan) {
            $q->where('perusahaan_id', $perusahaan->id);
        })->distinct()->pluck('jurusan');

        return view('perusahaan.seleksi-mahasiswa', compact(
            'totalPelamar',
            'menungguReview',
            'tahapInterview',
            'diterima',
            'mahasiswaPelamar',
            'jurusanList'
        ));
    }

    public function updateStatusPelamar(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,interview,diterima,ditolak',
            'catatan' => 'nullable|string'
        ]);

        $pendaftaran = PendaftaranMagang::with('magang')->findOrFail($id);

        // Pastikan pendaftaran adalah milik perusahaan yang login
        $user = Auth::user();
        $perusahaan = Perusahaan::where('user_id', $user->id)->first();

        if ($pendaftaran->magang->perusahaan_id !== $perusahaan->id) {
            abort(403, 'Unauthorized');
        }

        $pendaftaran->update([
            'status' => $request->status,
            'catatan' => $request->catatan
        ]);

        // Jika diterima, set tanggal mulai dan selesai magang
        if ($request->status === 'diterima') {
            $pendaftaran->update([
                'tanggal_mulai' => $pendaftaran->magang->tanggal_mulai,
                'tanggal_selesai' => $pendaftaran->magang->tanggal_selesai,
                'status_magang' => 'belum_mulai'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status pelamar berhasil diupdate'
        ]);
    }
}
