<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Perusahaan;
use App\Models\Magang;
use App\Models\PendaftaranMagang;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get basic statistics - Sesuaikan dengan schema database
        $totalMahasiswa = Mahasiswa::count();
        $totalPerusahaan = Perusahaan::count();
        $totalMagang = Magang::where('status_aktif', true)->count(); // Fixed: sesuai schema
        $totalPendaftaranMagang = PendaftaranMagang::count();

        // Get application status statistics
        $menunggu = PendaftaranMagang::where('status', 'menunggu')->count();
        $diterima = PendaftaranMagang::where('status', 'diterima')->count();
        $ditolak = PendaftaranMagang::where('status', 'ditolak')->count();

        // Get recent applications (last 10) - Fixed query sesuai schema
        $recentApplications = PendaftaranMagang::with(['mahasiswa', 'magang.perusahaan'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($application) {
                return [
                    'mahasiswa_nama' => $application->mahasiswa->nama ?? 'Unknown',
                    'posisi' => $application->magang->judul ?? 'Unknown Position', // Fixed: judul bukan posisi
                    'perusahaan_nama' => $application->magang->perusahaan->nama_perusahaan ?? 'Unknown Company',
                    'tanggal_apply' => Carbon::parse($application->created_at)->format('d M Y'),
                    'status' => $application->status
                ];
            });

        // Get recent activities
        $recentActivities = $this->getRecentActivities();

        // Get company partners - Fixed query sesuai schema
        $companies = Perusahaan::withCount(['magang' => function ($query) {
            $query->where('status_aktif', true);
        }])
            ->limit(6)
            ->get()
            ->map(function ($company) {
                return [
                    'nama_perusahaan' => $company->nama_perusahaan,
                    'industri' => $company->bidang ?? 'General', // Fixed: bidang bukan industri
                    'lokasi' => $company->alamat ?? 'Unknown Location',
                    'lowongan_aktif' => $company->magang_count,
                    'status' => 'Terverifikasi' // Simplified karena tidak ada status_verifikasi di schema
                ];
            });

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalPerusahaan',
            'totalMagang',
            'totalPendaftaranMagang',
            'menunggu',
            'diterima',
            'ditolak',
            'recentApplications',
            'recentActivities',
            'companies'
        ));
    }

    private function getRecentActivities()
    {
        $activities = [];

        // Get recent registrations
        $recentMahasiswa = Mahasiswa::orderBy('created_at', 'desc')->limit(3)->get();
        foreach ($recentMahasiswa as $mahasiswa) {
            $activities[] = [
                'message' => "Mahasiswa baru {$mahasiswa->nama} telah mendaftar",
                'time' => $mahasiswa->created_at,
                'time_human' => Carbon::parse($mahasiswa->created_at)->diffForHumans(),
                'icon' => 'user-plus',
                'color' => 'success'
            ];
        }

        // Get recent company registrations
        $recentCompanies = Perusahaan::orderBy('created_at', 'desc')->limit(2)->get();
        foreach ($recentCompanies as $company) {
            $activities[] = [
                'message' => "Perusahaan {$company->nama_perusahaan} bergabung sebagai partner",
                'time' => $company->created_at,
                'time_human' => Carbon::parse($company->created_at)->diffForHumans(),
                'icon' => 'building',
                'color' => 'success'
            ];
        }

        // Get recent applications
        $recentApplications = PendaftaranMagang::with(['mahasiswa', 'magang'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        foreach ($recentApplications as $application) {
            $activities[] = [
                'message' => "{$application->mahasiswa->nama} melamar magang {$application->magang->judul}", // Fixed: judul bukan posisi
                'time' => $application->created_at,
                'time_human' => Carbon::parse($application->created_at)->diffForHumans(),
                'icon' => 'file-alt',
                'color' => 'warning'
            ];
        }

        // Sort by created_at timestamp instead of parsing time string
        $activities = collect($activities)->sortByDesc(function ($activity) {
            return Carbon::parse($activity['time'])->timestamp;
        })->take(8)->values()->all();

        return $activities;
    }

    public function getStats()
    {
        // API endpoint for real-time stats update
        return response()->json([
            'totalMahasiswa' => Mahasiswa::count(),
            'totalPerusahaan' => Perusahaan::count(),
            'totalMagang' => Magang::where('status_aktif', true)->count(), // Fixed
            'totalPendaftaranMagang' => PendaftaranMagang::count(),
            'menunggu' => PendaftaranMagang::where('status', 'menunggu')->count(),
            'diterima' => PendaftaranMagang::where('status', 'diterima')->count(),
            'ditolak' => PendaftaranMagang::where('status', 'ditolak')->count(),
        ]);
    }

    public function getRecentData()
    {
        // API endpoint for recent activities and applications
        $recentApplications = PendaftaranMagang::with(['mahasiswa', 'magang.perusahaan'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($application) {
                return [
                    'mahasiswa_nama' => $application->mahasiswa->nama ?? 'Unknown',
                    'posisi' => $application->magang->judul ?? 'Unknown Position', // Fixed
                    'perusahaan_nama' => $application->magang->perusahaan->nama_perusahaan ?? 'Unknown Company',
                    'tanggal_apply' => Carbon::parse($application->created_at)->format('d M Y H:i'),
                    'status' => $application->status
                ];
            });

        return response()->json([
            'applications' => $recentApplications,
            'activities' => $this->getRecentActivities()
        ]);
    }
}
