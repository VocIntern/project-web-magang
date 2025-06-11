@extends('admin.layouts.admin')
@section('title', 'Tambah Perusahaan Baru')
@section('content')
<div class="container-fluid">
    <div class="card modern-card">
        <div class="card-header"><h5 class="card-title">Formulir Tambah Perusahaan</h5></div>
        <div class="card-body">
            <form action="{{ route('admin.perusahaan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Tampilkan error di sini jika ada --}}
                
                <h6><i class="fas fa-user-tie me-2"></i>Informasi Akun Perusahaan</h6>
                <hr>
                <div class="row">
                    <div class="col-md-4 mb-3"><label for="name" class="form-label">Nama Pengguna</label><input type="text" class="form-control" id="name" name="name" required></div>
                    <div class="col-md-4 mb-3"><label for="email" class="form-label">Email Perusahaan</label><input type="email" class="form-control" id="email" name="email" required></div>
                    <div class="col-md-4 mb-3"><label for="password" class="form-label">Kata Sandi</label><input type="password" class="form-control" id="password" name="password" required></div>
                </div>

                <h6 class="mt-4"><i class="fas fa-building me-2"></i>Profil Perusahaan</h6>
                <hr>
                <div class="row">
                    <div class="col-md-8 mb-3"><label for="nama_perusahaan" class="form-label">Nama Perusahaan</label><input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" required></div>
                    <div class="col-md-4 mb-3"><label for="bidang" class="form-label">Bidang Industri</label><input type="text" class="form-control" id="bidang" name="bidang" required></div>
                </div>
                <div class="mb-3"><label for="alamat" class="form-label">Alamat Lengkap</label><textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea></div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label for="website" class="form-label">Website</label><input type="url" class="form-control" id="website" name="website" placeholder="https://contoh.com"></div>
                    <div class="col-md-6 mb-3"><label for="nama_pendaftar" class="form-label">Nama Kontak (HRD)</label><input type="text" class="form-control" id="nama_pendaftar" name="nama_pendaftar" required></div>
                </div>
                <div class="mb-3"><label for="deskripsi" class="form-label">Deskripsi Singkat Perusahaan</label><textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea></div>
                <div class="mb-4"><label for="logo" class="form-label">Logo Perusahaan</label><input class="form-control" type="file" id="logo" name="logo"></div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.perusahaan.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection