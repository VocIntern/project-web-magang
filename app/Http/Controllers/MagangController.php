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

        if ($request->has('keyword')) {
            $query->where('judul', 'like', '%' . $request->keyword . '%')
                ->orWhere('deskripsi', 'like', '%' . $request->keyword . '%');
        }

        if ($request->has('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        $magang = $query->paginate(9);

        return view('welcome', compact('magang'));
    }
}
