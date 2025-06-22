<?php
// app/Http/Controllers/MagangController.php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Magang;
use App\Models\Perusahaan;

class MagangController extends Controller
{
    public function index(Request $request)
    {
        // Hanya load data awal tanpa filter
        $magang = Magang::with('perusahaan')->paginate(9);

        return view('welcome', compact('magang'));
    }

    // Method untuk pencarian AJAX dengan pagination
    public function ajaxSearch(Request $request)
    {
        $query = Magang::query()->with('perusahaan');

        // Filter berdasarkan posisi/judul
        if ($request->has('posisi') && !empty($request->posisi)) {
            $query->where('judul', 'like', '%' . $request->posisi . '%')
                ->orWhere('deskripsi', 'like', '%' . $request->posisi . '%');
        }

        // Filter berdasarkan lokasi
        if ($request->has('lokasi') && !empty($request->lokasi)) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        // Filter berdasarkan perusahaan
        if ($request->has('perusahaan') && !empty($request->perusahaan)) {
            $query->whereHas('perusahaan', function ($q) use ($request) {
                $q->where('nama_perusahaan', 'like', '%' . $request->perusahaan . '%');
            });
        }

        // Get page number from request (default to 1)
        $page = $request->get('page', 1);
        $magang = $query->paginate(9, ['*'], 'page', $page);

        // Return JSON response untuk AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $magang->items(),
                'pagination' => [
                    'current_page' => $magang->currentPage(),
                    'last_page' => $magang->lastPage(),
                    'total' => $magang->total(),
                    'per_page' => $magang->perPage(),
                    'from' => $magang->firstItem(),
                    'to' => $magang->lastItem(),
                    'has_previous' => $magang->previousPageUrl() !== null,
                    'has_next' => $magang->nextPageUrl() !== null,
                    'previous_page' => $magang->currentPage() > 1 ? $magang->currentPage() - 1 : null,
                    'next_page' => $magang->hasMorePages() ? $magang->currentPage() + 1 : null,
                ]
            ]);
        }

        return view('welcome', compact('magang'));
    }

    // Method terpisah untuk pagination tanpa search
    public function ajaxPaginate(Request $request)
    {
        $page = $request->get('page', 1);
        $magang = Magang::with('perusahaan')->paginate(9, ['*'], 'page', $page);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $magang->items(),
                'pagination' => [
                    'current_page' => $magang->currentPage(),
                    'last_page' => $magang->lastPage(),
                    'total' => $magang->total(),
                    'per_page' => $magang->perPage(),
                    'from' => $magang->firstItem(),
                    'to' => $magang->lastItem(),
                    'has_previous' => $magang->previousPageUrl() !== null,
                    'has_next' => $magang->nextPageUrl() !== null,
                    'previous_page' => $magang->currentPage() > 1 ? $magang->currentPage() - 1 : null,
                    'next_page' => $magang->hasMorePages() ? $magang->currentPage() + 1 : null,
                ]
            ]);
        }

        return redirect()->route('welcome');
    }

    // Method untuk live search (pencarian saat mengetik)
    public function liveSearch(Request $request)
    {
        $query = Magang::query()->with('perusahaan');

        $searchTerm = $request->get('q');

        if (!empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul', 'like', '%' . $searchTerm . '%')
                    ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%')
                    ->orWhere('lokasi', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('perusahaan', function ($subQ) use ($searchTerm) {
                        $subQ->where('nama_perusahaan', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        $magang = $query->limit(10)->get();

        return response()->json([
            'success' => true,
            'data' => $magang
        ]);
    }
}
