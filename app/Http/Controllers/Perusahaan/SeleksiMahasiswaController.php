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

        $pendaftarans = $query->latest()->paginate(15);

        // Ambil semua pendaftar yang relevan SATU KALI saja
        $semuaPendaftar = PendaftaranMagang::whereHas('magang', function ($q) use ($perusahaan) {
            $q->where('perusahaan_id', $perusahaan->id);
        })->get();

        // Hitung statistik dari collection yang sudah diambil
        $totalPelamar = $semuaPendaftar->count();
        $menunggu = $semuaPendaftar->where('status', 'menunggu')->count(); // 'menunggu' bukan 'menunggueview'
        $ditolak = $semuaPendaftar->where('status', 'ditolak')->count();
        $diterima = $semuaPendaftar->where('status', 'diterima')->count();

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
            'pendaftarans',
            'totalPelamar',
            'menunggu',
            'ditolak',
            'diterima',
            'jurusanList',
            'perusahaan'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diterima,ditolak',
            'catatan' => 'nullable|string'
        ]);

        $pendaftaran = PendaftaranMagang::findOrFail($id);

        // Pastikan pendaftaran ini milik perusahaan yang sedang login
        $perusahaan = Auth::user()->perusahaan;
        if ($pendaftaran->magang->perusahaan_id !== $perusahaan->id) {
            return redirect()->back()->with('error', 'Anda tidak berwenang mengubah status ini.');
        }

        $pendaftaran->update([
            'status' => $request->status,
            'catatan' => $request->catatan
        ]);

        // Jika statusnya 'diterima', perbarui juga tanggal mulai/selesai magang
        if ($request->status === 'diterima') {
            $pendaftaran->update([
                'tanggal_mulai' => $pendaftaran->magang->tanggal_mulai,
                'tanggal_selesai' => $pendaftaran->magang->tanggal_selesai,
                'status_magang' => 'belum_mulai'
            ]);
        }

        // Alihkan kembali ke halaman seleksi dengan pesan sukses
        return redirect()->route('perusahaan.seleksi.index')->with('success', 'Status lamaran berhasil diperbarui!');
    }

    // public function detail($id)
    // {
    //     $pendaftaran = PendaftaranMagang::with(['mahasiswa.user', 'magang'])
    //         ->findOrFail($id);

    //     $perusahaan = Auth::user()->perusahaan;
    //     if ($pendaftaran->magang->perusahaan_id !== $perusahaan->id) {
    //         return redirect()->back()->with('error', 'Unauthorized');
    //     }

    //     return view('perusahaan.detail-mahasiswa', compact('pendaftaran'));
    // }
}
