<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Magang;
use App\Models\Mahasiswa;
use App\Models\PendaftaranMagang;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $recentApplications = collect();
        $companies = collect();
        $recentActivities = collect();

        try {
            // Count totals
            if (Schema::hasTable('mahasiswa')) {
                $totalMahasiswa = Mahasiswa::count();
            }

            if (Schema::hasTable('perusahaan')) {
                $totalPerusahaan = Perusahaan::count();
            }

            if (Schema::hasTable('magang')) {
                $totalMagang = Magang::where('status_aktif', true)->count();
            }

            if (Schema::hasTable('pendaftaran_magang')) {
                $totalPendaftaran = PendaftaranMagang::count();

                // Count applications by status
                $menunggu = PendaftaranMagang::where('status', 'menunggu')->count();
                $diterima = PendaftaranMagang::where('status', 'diterima')->count();
                $ditolak = PendaftaranMagang::where('status', 'ditolak')->count();

                // Get recent applications with relationships
                $recentApplications = PendaftaranMagang::with([
                    'mahasiswa:id,nama',
                    'magang:id,judul,perusahaan_id',
                    'magang.perusahaan:id,nama_perusahaan'
                ])
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($application) {
                        return [
                            'id' => $application->id,
                            'mahasiswa_nama' => $application->mahasiswa->nama ?? 'N/A',
                            'perusahaan_nama' => $application->magang->perusahaan->nama_perusahaan ?? 'N/A',
                            'posisi' => $application->magang->judul ?? 'N/A',
                            'tanggal_apply' => $application->created_at->format('d M Y'),
                            'status' => $application->status,
                        ];
                    });
            }

            // Get companies with their active internship count
            if (Schema::hasTable('perusahaan') && Schema::hasTable('magang')) {
                $companies = Perusahaan::select('id', 'nama_perusahaan', 'bidang', 'alamat')
                    ->withCount(['magang as lowongan_aktif' => function ($query) {
                        $query->where('status_aktif', true);
                    }])
                    ->orderBy('created_at', 'desc')
                    ->limit(4)
                    ->get()
                    ->map(function ($company) {
                        // Extract city from address (assuming format includes city)
                        $addressParts = explode(',', $company->alamat);
                        $lokasi = trim(end($addressParts));

                        return [
                            'id' => $company->id,
                            'nama_perusahaan' => $company->nama_perusahaan,
                            'industri' => $company->bidang,
                            'lokasi' => $lokasi,
                            'lowongan_aktif' => $company->lowongan_aktif,
                            'status' => $company->lowongan_aktif > 0 ? 'Terverifikasi' : 'Menunggu'
                        ];
                    });
            }

            // Get recent activities (combining different types of activities)
            $recentActivities = collect();

            if (Schema::hasTable('mahasiswa')) {
                $newStudents = Mahasiswa::with('user:id,name,created_at')
                    ->orderBy('created_at', 'desc')
                    ->limit(2)
                    ->get()
                    ->map(function ($student) {
                        return [
                            'type' => 'new_student',
                            'message' => $student->nama . ' mendaftar akun',
                            'time' => $student->created_at->diffForHumans(),
                            'icon' => 'user-plus',
                            'color' => 'success'
                        ];
                    });
                $recentActivities = $recentActivities->merge($newStudents);
            }

            if (Schema::hasTable('pendaftaran_magang')) {
                $newApplications = PendaftaranMagang::with(['mahasiswa:id,nama', 'magang:id,judul'])
                    ->where('status', 'menunggu')
                    ->orderBy('created_at', 'desc')
                    ->limit(2)
                    ->get()
                    ->map(function ($application) {
                        return [
                            'type' => 'new_application',
                            'message' => ($application->mahasiswa->nama ?? 'Mahasiswa') . ' melamar ' . ($application->magang->judul ?? 'posisi'),
                            'time' => $application->created_at->diffForHumans(),
                            'icon' => 'file-text',
                            'color' => 'warning'
                        ];
                    });
                $recentActivities = $recentActivities->merge($newApplications);
            }

            // Sort activities by time and limit
            $recentActivities = $recentActivities->sortByDesc(function ($activity) {
                return $activity['time'];
            })->take(4)->values();
        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
        }

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalPerusahaan',
            'totalMagang',
            'totalPendaftaran',
            'menunggu',
            'diterima',
            'ditolak',
            'recentApplications',
            'companies',
            'recentActivities'
        ));
    }
}
