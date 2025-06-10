<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Mahasiswa::with('user');

        // Search functionality
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

        // Filter by jurusan
        if ($request->has('jurusan') && $request->jurusan) {
            $query->where('jurusan', $request->jurusan);
        }

        // Filter by semester
        if ($request->has('semester') && $request->semester) {
            $query->where('semester', $request->semester);
        }

        $mahasiswas = $query->paginate(10);

        // Get unique jurusan for filter
        $jurusan_list = Mahasiswa::distinct()->pluck('jurusan')->filter();
        $semester_list = Mahasiswa::distinct()->pluck('semester')->filter();

        return view('admin.mahasiswa.index', compact('mahasiswas', 'jurusan_list', 'semester_list'));
    }

    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nama' => 'required|string|max:255',
            'nim' => 'required|integer|unique:mahasiswa',
            'jurusan' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create user first
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        // Handle photo upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('mahasiswa/foto', 'public');
        }

        // Create mahasiswa record
        Mahasiswa::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'semester' => $request->semester,
            'bio' => $request->bio,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load('user');
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load('user');
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($mahasiswa->user_id)],
            'password' => 'nullable|string|min:8',
            'nama' => 'required|string|max:255',
            'nim' => ['required', 'integer', Rule::unique('mahasiswa')->ignore($mahasiswa->id)],
            'jurusan' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $mahasiswa->user->update($userData);

        // Handle photo upload
        $fotoPath = $mahasiswa->foto;
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($mahasiswa->foto) {
                Storage::disk('public')->delete($mahasiswa->foto);
            }
            $fotoPath = $request->file('foto')->store('mahasiswa/foto', 'public');
        }

        // Update mahasiswa record
        $mahasiswa->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'semester' => $request->semester,
            'bio' => $request->bio,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        // Delete photo if exists
        if ($mahasiswa->foto) {
            Storage::disk('public')->delete($mahasiswa->foto);
        }

        // Delete user (will cascade delete mahasiswa)
        $mahasiswa->user->delete();

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil dihapus');
    }
}
