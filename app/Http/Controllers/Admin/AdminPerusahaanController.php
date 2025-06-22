<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class AdminPerusahaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Perusahaan::with('user')->withCount('magang');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_perusahaan', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('bidang', 'like', "%{$search}%");
            });
        }

        $perusahaan = $query->latest()->paginate(10);

        return view('admin.perusahaan.index', compact('perusahaan'));
    }

    public function create()
    {
        return view('admin.perusahaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'bidang' => 'required|string|max:255',
            'nama_pendaftar' => 'required|string|max:255',
            'website' => 'nullable|url',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'perusahaan',
        ]);

        $logoPath = $request->hasFile('logo') ? $request->file('logo')->store('perusahaan/logo', 'public') : null;

        Perusahaan::create([
            'user_id' => $user->id,
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'bidang' => $request->bidang,
            'nama_pendaftar' => $request->nama_pendaftar,
            'website' => $request->website,
            'deskripsi' => $request->deskripsi,
            'logo' => $logoPath,
        ]);

        return redirect()->route('admin.perusahaan.index')->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    public function edit(Perusahaan $perusahaan)
    {
        $perusahaan->load('user');
        return view('admin.perusahaan.edit', compact('perusahaan'));
    }

    public function update(Request $request, Perusahaan $perusahaan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($perusahaan->user_id)],
            'password' => 'nullable|string|min:8',
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'bidang' => 'required|string|max:255',
            'nama_pendaftar' => 'required|string|max:255',
            'website' => 'nullable|url',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $userData = ['name' => $request->name, 'email' => $request->email];
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        $perusahaan->user->update($userData);

        $logoPath = $perusahaan->logo;
        if ($request->hasFile('logo')) {
            if ($perusahaan->logo) Storage::disk('public')->delete($perusahaan->logo);
            $logoPath = $request->file('logo')->store('perusahaan/logo', 'public');
        }

        $perusahaan->update([
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'bidang' => $request->bidang,
            'nama_pendaftar' => $request->nama_pendaftar,
            'website' => $request->website,
            'deskripsi' => $request->deskripsi,
            'logo' => $logoPath,
        ]);

        return redirect()->route('admin.perusahaan.index')->with('success', 'Data perusahaan berhasil diperbarui.');
    }

    public function destroy(Perusahaan $perusahaan)
    {
        if ($perusahaan->logo) Storage::disk('public')->delete($perusahaan->logo);
        $perusahaan->user->delete(); // Ini akan menghapus perusahaan juga karena onDelete('cascade')
        return redirect()->route('admin.perusahaan.index')->with('success', 'Perusahaan berhasil dihapus.');
    }
    public function export(Request $request)
    {
        $fileName = 'data-perusahaan-' . date('Y-m-d') . '.csv';
        $query = Perusahaan::with('user');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_perusahaan', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('bidang', 'like', "%{$search}%");
            });
        }

        $perusahaans = $query->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Nama Perusahaan', 'Email', 'Alamat', 'Bidang', 'Website'];

        $callback = function () use ($perusahaans, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($perusahaans as $p) {
                $row['Nama Perusahaan'] = $p->nama_perusahaan;
                $row['Email']           = $p->user->email ?? 'N/A';
                $row['Alamat']          = $p->alamat;
                $row['Bidang']          = $p->bidang;
                $row['Website']         = $p->website;

                fputcsv($file, array_values($row));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Anda perlu menambahkan method lain (create, store, edit, update, destroy)
    // agar semua tombol aksi berfungsi dengan benar.
}
