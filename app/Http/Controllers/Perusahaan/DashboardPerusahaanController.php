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

        $user = Auth::user();

        if (Auth::user()->role !== 'perusahaan') {
            abort(403, 'Unauthorized');
        }
        $perusahaan = Perusahaan::where('user_id', $user->id)->first();

        // if (!$perusahaan) {
        //     return redirect()->route('perusahaan.profile.create')
        //         ->with('error', 'Silakan lengkapi profil perusahaan terlebih dahulu.');
        // }

        // Statistik Dashboard
        $totalLowongan = Magang::where('perusahaan_id', $perusahaan->id)->count();
        $totalPelamar = PendaftaranMagang::whereHas('magang', function ($query) use ($perusahaan) {
            $query->where('perusahaan_id', $perusahaan->id);
        })->count();
        $magangAktif = PendaftaranMagang::whereHas('magang', function ($query) use ($perusahaan) {
            $query->where('perusahaan_id', $perusahaan->id);
        })->where('status', 'diterima')->where('status_magang', 'berlangsung')->count();

        // Lowongan terbaru
        $lowonganTerbaru = Magang::where('perusahaan_id', $perusahaan->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pelamar terbaru yang menunggu review
        $pelamarTerbaru = PendaftaranMagang::with(['mahasiswa.user', 'magang'])
            ->whereHas('magang', function ($query) use ($perusahaan) {
                $query->where('perusahaan_id', $perusahaan->id);
            })
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('perusahaan.dashboard', compact(
            'perusahaan',
            'totalLowongan',
            'totalPelamar',
            'magangAktif',
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

    public function profilPerusahaan()
    {
        $user = Auth::user();
        $perusahaan = Perusahaan::where('user_id', $user->id)->first();

        // Statistik untuk profil
        $totalLowongan = Magang::where('perusahaan_id', $perusahaan->id)->count();
        $totalPendaftar = PendaftaranMagang::whereHas('magang', function ($query) use ($perusahaan) {
            $query->where('perusahaan_id', $perusahaan->id);
        })->count();
        $magangAktif = PendaftaranMagang::whereHas('magang', function ($query) use ($perusahaan) {
            $query->where('perusahaan_id', $perusahaan->id);
        })->where('status', 'diterima')->where('status_magang', 'berlangsung')->count();

        return view('perusahaan.profil', compact(
            'perusahaan',
            'totalLowongan',
            'totalPendaftar',
            'magangAktif'
        ));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
            'alamat' => 'required|string',
            'website' => 'nullable|url',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = Auth::user();
        $perusahaan = Perusahaan::where('user_id', $user->id)->first();

        $data = $request->only(['nama_perusahaan', 'bidang', 'alamat', 'website', 'deskripsi']);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($perusahaan->logo && file_exists(public_path('storage/' . $perusahaan->logo))) {
                unlink(public_path('storage/' . $perusahaan->logo));
            }

            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        $perusahaan->update($data);

        return redirect()->back()->with('success', 'Profil perusahaan berhasil diperbarui');
    }

    public function lowonganMagang()
    {
        $user = Auth::user();
        $perusahaan = Perusahaan::where('user_id', $user->id)->first();

        $lowonganList = Magang::where('perusahaan_id', $perusahaan->id)
            ->withCount('pendaftaranMagang')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('perusahaan.lowongan-magang', compact('lowonganList'));
    }

    public function createLowongan()
    {
        return view('perusahaan.create-lowongan');
    }

    public function storeLowongan(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'kuota' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $perusahaan = Perusahaan::where('user_id', $user->id)->first();

        $data = $request->all();
        $data['perusahaan_id'] = $perusahaan->id;

        Magang::create($data);

        return redirect()->route('perusahaan.lowongan')->with('success', 'Lowongan magang berhasil dibuat');
    }
}
