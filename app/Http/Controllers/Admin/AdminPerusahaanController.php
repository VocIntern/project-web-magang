<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan; // <-- Tambahkan ini
use Illuminate\Http\Request;

class AdminPerusahaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Perusahaan::with('user')->withCount('magang');

        // Fungsionalitas Pencarian
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_perusahaan', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('bidang', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('email', 'like', "%{$search}%");
                    });
            });
        }

        // Fungsionalitas Filter
        if ($request->has('bidang_filter') && $request->bidang_filter) {
            $query->where('bidang', $request->bidang_filter);
        }

        $perusahaan = $query->latest()->paginate(10);

        // Data untuk dropdown filter di modal export
        $bidang_list = Perusahaan::distinct()->pluck('bidang')->filter();

        // Kirim data ke view
        return view('admin.perusahaan.index', compact('perusahaan', 'bidang_list'));
    }

    // Catatan: Fungsi lain seperti create, store, edit, update, destroy, dan export
    // perlu Anda buat di sini agar tombol-tombol di halaman bisa berfungsi.
}
