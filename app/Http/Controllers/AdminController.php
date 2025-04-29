<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Magang;
use App\Models\Mahasiswa;
use App\Models\PendaftaranMagang;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Initialize all counters with default values
        $totalMahasiswa = 0;
        $totalPerusahaan = 0;
        $totalMagang = 0;
        $totalPendaftaran = 0;
        $menunggu = 0;
        $diterima = 0;
        $ditolak = 0;

        // Only count if the tables exist
        try {
            if (Schema::hasTable('mahasiswa')) {
                $totalMahasiswa = Mahasiswa::count();
            }

            if (Schema::hasTable('perusahaan')) {
                $totalPerusahaan = Perusahaan::count();
            }

            if (Schema::hasTable('magang')) {
                $totalMagang = Magang::count();
            }

            if (Schema::hasTable('pendaftaran_magang')) {
                $totalPendaftaran = PendaftaranMagang::count();

                // Count applications by status
                $menunggu = PendaftaranMagang::where('status', 'menunggu')->count();
                $diterima = PendaftaranMagang::where('status', 'diterima')->count();
                $ditolak = PendaftaranMagang::where('status', 'ditolak')->count();
            }
        } catch (\Exception $e) {
            // Log the error but don't crash
            Log::error('Dashboard error: ' . $e->getMessage());
        }

        // Pass all variables to the view
        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalPerusahaan',
            'totalMagang',
            'totalPendaftaran',
            'menunggu',
            'diterima',
            'ditolak'
        ));
    }
}
