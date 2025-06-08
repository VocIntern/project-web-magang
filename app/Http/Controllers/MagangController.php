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
        $query = Magang::query()->with('perusahaan');

        // Flag untuk menandai apakah ini hasil pencarian
        $isSearchResult = false;

        if ($request->has('keyword') && !empty($request->keyword)) {
            $query->where('judul', 'like', '%' . $request->keyword . '%')
                ->orWhere('deskripsi', 'like', '%' . $request->keyword . '%');
            $isSearchResult = true;
        }

        if ($request->has('lokasi') && !empty($request->lokasi)) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
            $isSearchResult = true;
        }

        $magang = $query->paginate(9);

        // Tidak perlu redirect di method index, langsung return view

        // Tambahkan flag untuk scroll jika ada pencarian
        $shouldScroll = $isSearchResult;

        return view('welcome', compact('magang', 'shouldScroll'));
    }

    // Alternatif: Method terpisah untuk pencarian
    public function search(Request $request)
    {
        $query = Magang::query()->with('perusahaan');

        if ($request->has('keyword') && !empty($request->keyword)) {
            $query->where('judul', 'like', '%' . $request->keyword . '%')
                ->orWhere('deskripsi', 'like', '%' . $request->keyword . '%');
        }

        if ($request->has('lokasi') && !empty($request->lokasi)) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        $magang = $query->paginate(9);

        // Redirect ke welcome dengan hasil pencarian dan anchor
        return redirect()->route('welcome', $request->only(['keyword', 'lokasi']))
            ->with('search_results', $magang)
            ->with('scroll_to_results', true);
    }
}
