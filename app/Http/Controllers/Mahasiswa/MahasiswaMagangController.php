<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Magang;
use App\Models\PendaftaranMagang;
use App\Models\Perusahaan;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaMagangController extends Controller
{
    /**
     * Display a listing of internships with search and filters.
     */
    public function search(Request $request)
    {
        $query = Magang::query()
            ->with('perusahaan')
            ->where('status_aktif', true)
            ->where('tanggal_selesai', '>=', Carbon::now());

        // Apply keyword search
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                    ->orWhere('deskripsi', 'like', "%{$keyword}%")
                    ->orWhereHas('perusahaan', function ($q) use ($keyword) {
                        $q->where('nama_perusahaan', 'like', "%{$keyword}%");
                    });
            });
        }

        // Apply location filter
        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', "%{$request->lokasi}%");
        }

        // Apply field/category filter
        if ($request->filled('bidang')) {
            $query->where('bidang', $request->bidang);
        }

        // Apply duration filter
        if ($request->filled('durasi')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->durasi as $durasi) {
                    if ($durasi == '1-3') {
                        $q->orWhere(function ($subq) {
                            $subq->whereRaw('DATEDIFF(tanggal_selesai, tanggal_mulai) BETWEEN 30 AND 90');
                        });
                    } elseif ($durasi == '3-6') {
                        $q->orWhere(function ($subq) {
                            $subq->whereRaw('DATEDIFF(tanggal_selesai, tanggal_mulai) BETWEEN 91 AND 180');
                        });
                    } elseif ($durasi == '6+') {
                        $q->orWhere(function ($subq) {
                            $subq->whereRaw('DATEDIFF(tanggal_selesai, tanggal_mulai) > 180');
                        });
                    }
                }
            });
        }

        // Get recommended internships based on student's field of study
        $recommended = $this->getRecommendedInternships();

        // Sort results
        $sortBy = $request->sort ?? 'created_at';
        $sortOrder = $request->order ?? 'desc';

        $query->orderBy($sortBy, $sortOrder);

        // Paginate results
        $magang = $query->paginate(12)->withQueryString();

        return view('mahasiswa.magang-search', compact('magang', 'recommended'));
    }

    /**
     * Display the details of a specific internship.
     */
    public function show($id)
    {
        $magang = Magang::with(['perusahaan'])->findOrFail($id);

        // Check if student has already applied
        $hasApplied = false;
        if (Auth::check() && Auth::user()->isMahasiswa()) {
            $hasApplied = PendaftaranMagang::where('mahasiswa_id', Auth::user()->mahasiswa?->id)
                ->where('magang_id', $id)
                ->exists();
        }

        // Get similar internships based on field
        $similarMagang = Magang::where('bidang', $magang->bidang)
            ->where('id', '!=', $magang->id)
            ->where('status_aktif', true)
            ->where('tanggal_selesai', '>=', Carbon::now())
            ->take(3)
            ->get();

        return view('mahasiswa.magang-detail', compact('magang', 'hasApplied', 'similarMagang'));
    }

    /**
     * Show application form for an internship.
     */
    public function showApplyForm($id)
    {
        $magang = Magang::with('perusahaan')->findOrFail($id);

        // Check if student has already applied
        if (Auth::user()->mahasiswa->pendaftaranMagang()->where('magang_id', $id)->exists()) {
            return redirect()->route('mahasiswa.magang.show', $id)
                ->with('error', 'Anda sudah melamar untuk magang ini.');
        }

        return view('mahasiswa.magang-apply', compact('magang'));
    }

    /**
     * Process the application form.
     */
    public function apply(Request $request, $id)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
            'surat_pengantar' => 'nullable|mimes:pdf|max:2048',
        ]);

        $magang = Magang::findOrFail($id);
        $mahasiswa = Auth::user()->mahasiswa;

        // Check if student has already applied
        if ($mahasiswa->pendaftaranMagang()->where('magang_id', $id)->exists()) {
            return redirect()->route('mahasiswa.magang.show', $id)
                ->with('error', 'Anda sudah melamar untuk magang ini.');
        }

        // Store CV file
        $cvPath = $request->file('cv')->store('cv', 'public');

        // Store cover letter file if provided
        $suratPengantarPath = null;
        if ($request->hasFile('surat_pengantar')) {
            $suratPengantarPath = $request->file('surat_pengantar')->store('surat_pengantar', 'public');
        }

        // Create application record
        $pendaftaran = new PendaftaranMagang([
            'magang_id' => $id,
            'mahasiswa_id' => $mahasiswa->id,
            'cv' => $cvPath,
            'surat_pengantar' => $suratPengantarPath,
            'status' => 'menunggu',
            'tanggal_mulai' => $magang->tanggal_mulai,
            'tanggal_selesai' => $magang->tanggal_selesai,
            'status_magang' => 'belum_mulai'
        ]);

        $pendaftaran->save();

        return redirect()->route('mahasiswa.magang.search')
            ->with('success', 'Pendaftaran magang berhasil diajukan. Silakan tunggu konfirmasi dari perusahaan.');
    }

    /**
     * Get recommended internships based on student's field of study.
     */
    private function getRecommendedInternships()
    {
        if (!Auth::check() || !Auth::user()->isMahasiswa()) {
            return collect();
        }

        $mahasiswa = Auth::user()->mahasiswa;
        $jurusan = Auth::user()->mahasiswa?->jurusan;


        // Map jurusan to relevant bidang
        $relevantFields = $this->mapJurusanToBidang($jurusan);

        // Get internships that match the relevant fields
        $recommended = Magang::with('perusahaan')
            ->where('status_aktif', true)
            ->where('tanggal_selesai', '>=', Carbon::now())
            ->whereIn('bidang', $relevantFields)
            ->take(3)
            ->get();

        return $recommended;
    }

    /**
     * Map student's field of study to relevant internship fields.
     */
    private function mapJurusanToBidang($jurusan)
    {
        $mapping = [
            'Teknologi Informasi' => ['IT', 'Teknologi', 'Software Development'],
            'Akuntansi' => ['Akuntansi', 'Keuangan', 'Finance'],
            'Manajemen Bisnis' => ['Marketing', 'Bisnis', 'Manajemen'],
            'Administrasi' => ['Administrasi', 'Perkantoran'],
            'Desain' => ['Design', 'UI/UX', 'Graphic Design'],
        ];

        // Default to return all fields if no match
        foreach ($mapping as $key => $fields) {
            if (str_contains(strtolower($jurusan), strtolower($key))) {
                return $fields;
            }
        }

        return ['IT', 'Administrasi', 'Marketing']; // Default fields
    }
}
