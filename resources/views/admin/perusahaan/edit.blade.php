@extends('admin.layouts.admin')

@section('title', 'Edit Data Perusahaan')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card modern-card">
                    <div class="card-header">
                        <div class="card-toolbar">
                            <h4 class="card-title mb-0">Formulir Edit Perusahaan</h4>
                            <div class="card-actions">
                                <a href="{{ route('admin.perusahaan.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-arrow-left fa-sm"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.perusahaan.update', $perusahaan) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Logo Perusahaan</h6>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <img id="logo-preview"
                                                    src="{{ $perusahaan->logo ? asset('storage/' . $perusahaan->logo) : asset('images/default-logo.png') }}"
                                                    alt="Logo Perusahaan" class="img-thumbnail"
                                                    style="width: 200px; height: 200px; object-fit: contain;">
                                            </div>
                                            <div class="mb-3">
                                                <input type="file"
                                                    class="form-control @error('logo') is-invalid @enderror" id="logo"
                                                    name="logo" accept="image/*">
                                                @error('logo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Ganti jika ingin mengubah logo</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="text-success mb-3"><i class="fas fa-building"></i> Informasi
                                                Perusahaan</h6>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="nama_perusahaan" class="form-label">Nama Perusahaan <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('nama_perusahaan') is-invalid @enderror"
                                                id="nama_perusahaan" name="nama_perusahaan"
                                                value="{{ old('nama_perusahaan', $perusahaan->nama_perusahaan) }}" required>
                                            @error('nama_perusahaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email_perusahaan" class="form-label">Email Perusahaan <span
                                                    class="text-danger">*</span></label>
                                            <input type="email"
                                                class="form-control @error('email_perusahaan') is-invalid @enderror"
                                                id="email_perusahaan" name="email_perusahaan"
                                                value="{{ old('email_perusahaan', $perusahaan->email_perusahaan) }}"
                                                required>
                                            @error('email_perusahaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="nomor_telepon" class="form-label">Nomor Telepon <span
                                                    class="text-danger">*</span></label>
                                            <input type="tel"
                                                class="form-control @error('nomor_telepon') is-invalid @enderror"
                                                id="nomor_telepon" name="nomor_telepon"
                                                value="{{ old('nomor_telepon', $perusahaan->nomor_telepon) }}" required>
                                            @error('nomor_telepon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="website" class="form-label">Website</label>
                                            <input type="url"
                                                class="form-control @error('website') is-invalid @enderror" id="website"
                                                name="website" value="{{ old('website', $perusahaan->website) }}"
                                                placeholder="https://contoh.com">
                                            @error('website')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="alamat" class="form-label">Alamat Lengkap <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                                required>{{ old('alamat', $perusahaan->alamat) }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi</label>
                                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $perusahaan->deskripsi) }}</textarea>
                                            @error('deskripsi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 mt-4">
                                            <h6 class="text-success mb-3"><i class="fas fa-user-shield"></i> Akun Login
                                                Perusahaan</h6>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email Login <span
                                                    class="text-danger">*</span></label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                name="email" value="{{ old('email', $perusahaan->user->email) }}"
                                                required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">Password Baru</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password
                                                Baru</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.perusahaan.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
