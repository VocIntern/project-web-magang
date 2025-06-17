@extends('admin.layouts.admin')

@section('title', 'Tambah Mahasiswa Baru')

@section('content')
    <div class="container-fluid">
        <div class="card modern-card">
            <div class="card-header">
                <h5 class="card-title">Formulir Tambah Mahasiswa</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Menampilkan error validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger" style="font-size: 0.9rem;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h6><i class="fas fa-user-circle me-2"></i>Informasi Akun</h6>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <h6><i class="fas fa-id-card me-2"></i>Informasi Pribadi</h6>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Lengkap Mahasiswa</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ old('nama') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="number" class="form-control" id="nim" name="nim"
                                value="{{ old('nim') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <input type="text" class="form-control" id="jurusan" name="jurusan"
                                value="{{ old('jurusan') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <label for="semester" class="form-label">Semester *</label>
                                <select class="form-select @error('semester') is-invalid @enderror" name="semester"
                                    id="semester" required>
                                    <option value="">Pilih Semester</option>
                                    @for ($i = 1; $i <= 8; $i++)
                                        <option value="Semester {{ $i }}"
                                            {{ old('semester') == "Semester $i" ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio Singkat</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3">{{ old('bio') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="foto" class="form-label">Foto Profil</label>
                        <input class="form-control" type="file" id="foto" name="foto">
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
