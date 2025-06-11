<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Mahasiswa::with('user');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%")
                    ->orWhere('jurusan', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('email', 'like', "%{$search}%");
                    });
            });
        }

        $mahasiswas = $query->latest()->paginate(10);
        $jurusan_list = Mahasiswa::distinct()->pluck('jurusan')->filter();
        $semester_list = Mahasiswa::distinct()->pluck('semester')->filter();

        return view('admin.mahasiswa.index', compact('mahasiswas', 'jurusan_list', 'semester_list'));
    }

    public function create(): View
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|integer|unique:mahasiswa,nim',
            'jurusan' => 'required|string|max:255',
            'semester' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'bio' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Create user first
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa',
            ]);

            // Handle foto upload
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('mahasiswa/foto', 'public');
            }

            // Create mahasiswa profile
            Mahasiswa::create([
                'user_id' => $user->id,
                'nama' => $request->nama,
                'nim' => $request->nim,
                'jurusan' => $request->jurusan,
                'semester' => $request->semester,
                'bio' => $request->bio,
                'foto' => $fotoPath,
            ]);

            DB::commit();

            return redirect()->route('admin.mahasiswa.index')
                ->with('success', 'Data mahasiswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating mahasiswa: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        if (!$mahasiswa) {
            abort(404);
        }

        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $mahasiswa->load('user');

        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => [
                'required',
                'integer',
                Rule::unique('mahasiswa', 'nim')->ignore($mahasiswa->id)
            ],
            'jurusan' => 'required|string|max:255',
            'semester' => 'required|string|max:50',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($mahasiswa->user->id)
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'bio' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Update user data
            $userData = [
                'name' => $request->nama,
                'email' => $request->email,
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $mahasiswa->user->update($userData);

            // Handle foto upload
            $fotoPath = $mahasiswa->foto;
            if ($request->hasFile('foto')) {
                // Delete old foto if exists
                if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
                    Storage::disk('public')->delete($mahasiswa->foto);
                }
                $fotoPath = $request->file('foto')->store('mahasiswa/foto', 'public');
            }

            // Update mahasiswa profile
            $mahasiswa->update([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'jurusan' => $request->jurusan,
                'semester' => $request->semester,
                'bio' => $request->bio,
                'foto' => $fotoPath,
            ]);

            DB::commit();

            return redirect()->route('admin.mahasiswa.index')
                ->with('success', 'Data mahasiswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating mahasiswa: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $mahasiswa = Mahasiswa::with('user')->findOrFail($id);

            DB::beginTransaction();

            // Delete foto if exists
            if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
                Storage::disk('public')->delete($mahasiswa->foto);
            }

            // Delete user (this will cascade delete mahasiswa due to foreign key)
            $mahasiswa->user->delete();

            DB::commit();

            return redirect()->route('admin.mahasiswa.index')
                ->with('success', 'Data mahasiswa berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting mahasiswa: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }


    // ... (method export() Anda)
    public function export(Request $request)
    {
        $fileName = 'data-mahasiswa-' . date('Y-m-d') . '.csv';
        $query = Mahasiswa::with('user');
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%")
                    ->orWhere('jurusan', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('email', 'like', "%{$search}%");
                    });
            });
        }
        $mahasiswas = $query->get();
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        $columns = ['NIM', 'Nama', 'Email', 'Jurusan', 'Semester'];
        $callback = function () use ($mahasiswas, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($mahasiswas as $mahasiswa) {
                fputcsv($file, [
                    $mahasiswa->nim,
                    $mahasiswa->nama,
                    $mahasiswa->user->email ?? 'N/A', // Pengaman ?? 'N/A' sudah bagus di sini
                    $mahasiswa->jurusan,
                    $mahasiswa->semester,
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
