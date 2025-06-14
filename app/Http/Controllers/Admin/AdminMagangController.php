<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Magang;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminMagangController extends Controller
{
    public function index(Request $request)
    {
        $query = Magang::with('perusahaan');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhere('bidang', 'like', "%{$search}%")
                    ->orWhereHas('perusahaan', function ($perusahaanQuery) use ($search) {
                        $perusahaanQuery->where('nama_perusahaan', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status_aktif', $request->status);
        }

        // Filter by bidang
        if ($request->has('bidang') && $request->bidang) {
            $query->where('bidang', $request->bidang);
        }

        // Filter by perusahaan
        if ($request->has('perusahaan') && $request->perusahaan) {
            $query->where('perusahaan_id', $request->perusahaan);
        }

        $magangs = $query->latest()->paginate(10);

        // Get filter options
        $bidang_list = Magang::distinct()->pluck('bidang')->filter();
        $perusahaan_list = Perusahaan::select('id', 'nama_perusahaan')->get();

        return view('admin.magang.index', compact('magangs', 'bidang_list', 'perusahaan_list'));
    }

    public function create()
    {
        $perusahaan = Perusahaan::select('id', 'nama_perusahaan')->get();
        return view('admin.magang.create', compact('perusahaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'perusahaan_id' => 'required|exists:perusahaan,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'kuota' => 'required|integer|min:1',
            'status_aktif' => 'required|boolean',
        ]);

        Magang::create($request->all());

        return redirect()->route('admin.magang.index')
            ->with('success', 'Lowongan magang berhasil ditambahkan');
    }


    public function edit(Magang $magang)
    {
        $perusahaans = Perusahaan::select('id', 'nama_perusahaan')->get();
        return view('admin.magang.edit', compact('magang', 'perusahaans'));
    }

    public function update(Request $request, Magang $magang)
    {
        $request->validate([
            'perusahaan_id' => 'required|exists:perusahaan,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'kuota' => 'required|integer|min:1',
            'status_aktif' => 'required|boolean',
        ]);

        $magang->update($request->all());

        return redirect()->route('admin.magang.index')
            ->with('success', 'Lowongan magang berhasil diperbarui');
    }

    public function destroy(Magang $magang)
    {
        $magang->delete();

        return redirect()->route('admin.magang.index')
            ->with('success', 'Lowongan magang berhasil dihapus');
    }


    public function export(Request $request)
    {
        $fileName = 'data-magang-' . date('Y-m-d') . '.csv';
        $query = Magang::with('perusahaan');
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhere('bidang', 'like', "%{$search}%")
                    ->orWhereHas('perusahaan', function ($perusahaanQuery) use ($search) {
                        $perusahaanQuery->where('nama_perusahaan', 'like', "%{$search}%");
                    });
            });
        }
        $magangs = $query->get();
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        $columns = ['NIM', 'Nama', 'Email', 'Jurusan', 'Semester'];
        $callback = function () use ($magangs, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($magangs as $magang) {
                fputcsv($file, [
                    $magang->judul,
                    $magang->perusahaan->nama_perusahaan,
                    $magang->lokasi,
                    $magang->tipe, // Pengaman ?? 'N/A' sudah bagus di sini
                    $magang->status,

                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
