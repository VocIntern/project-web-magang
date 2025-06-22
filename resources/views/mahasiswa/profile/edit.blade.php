@extends('mahasiswa.layouts.mahasiswa')

@section('title', 'Edit Profil - VocIntern')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="text-success fw-bold mb-1">Edit Profil</h2>
                        <p class="text-muted mb-0">Kelola informasi profil dan keamanan akun Anda</p>
                    </div>
                    <a href="{{ route('mahasiswa.magang.search') }}" class="btn btn-outline-success">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <!-- Profile Information Card -->
                    <div class="col-lg-8 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-success text-white py-3">
                                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Profil</h5>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="{{ route('mahasiswa.profile.update') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')

                                    <!-- Profile Photo Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center">
                                                <div class="me-4">
                                                    @if ($mahasiswa && $mahasiswa->foto)
                                                        <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="Foto Profil"
                                                            class="rounded-circle img-thumbnail"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                                            style="width: 80px; height: 80px;">
                                                            <i class="fas fa-user text-white fs-2"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label for="foto" class="form-label fw-semibold">Foto Profil</label>
                                                    <input type="file"
                                                        class="form-control @error('foto') is-invalid @enderror"
                                                        id="foto" name="foto" accept="image/*">
                                                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                                    @error('foto')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <!-- Email -->
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label fw-semibold">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email', $user->email) }}"
                                                required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Nama Lengkap (Mahasiswa table) -->
                                        <div class="col-md-6 mb-3">
                                            <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                id="nama" name="nama"
                                                value="{{ old('nama', $mahasiswa->nama ?? '') }}" required>
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- NIM -->
                                        <div class="col-md-6 mb-3">
                                            <label for="nim" class="form-label fw-semibold">NIM</label>
                                            <input type="number" class="form-control @error('nim') is-invalid @enderror"
                                                id="nim" name="nim"
                                                value="{{ old('nim', $mahasiswa->nim ?? '') }}" required>
                                            @error('nim')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Jurusan -->
                                        <div class="col-md-6 mb-3">
                                            <label for="jurusan" class="form-label fw-semibold">Jurusan</label>
                                            <select class="form-select @error('jurusan') is-invalid @enderror"
                                                id="jurusan" name="jurusan" required>
                                                <option value="">Pilih Jurusan</option>
                                                <option value="Teknik Informatika"
                                                    {{ old('jurusan', $mahasiswa->jurusan ?? '') == 'Teknik Informatika' ? 'selected' : '' }}>
                                                    Teknik Informatika</option>
                                                <option value="Sistem Informasi"
                                                    {{ old('jurusan', $mahasiswa->jurusan ?? '') == 'Sistem Informasi' ? 'selected' : '' }}>
                                                    Sistem Informasi</option>
                                                <option value="Teknik Komputer"
                                                    {{ old('jurusan', $mahasiswa->jurusan ?? '') == 'Teknik Komputer' ? 'selected' : '' }}>
                                                    Teknik Komputer</option>
                                                <option value="Manajemen Informatika"
                                                    {{ old('jurusan', $mahasiswa->jurusan ?? '') == 'Manajemen Informatika' ? 'selected' : '' }}>
                                                    Manajemen Informatika</option>
                                                <option value="Akuntansi"
                                                    {{ old('jurusan', $mahasiswa->jurusan ?? '') == 'Akuntansi' ? 'selected' : '' }}>
                                                    Akuntansi</option>
                                                <option value="Administrasi Bisnis"
                                                    {{ old('jurusan', $mahasiswa->jurusan ?? '') == 'Administrasi Bisnis' ? 'selected' : '' }}>
                                                    Administrasi Bisnis</option>
                                                <option value="Teknik Mesin"
                                                    {{ old('jurusan', $mahasiswa->jurusan ?? '') == 'Teknik Mesin' ? 'selected' : '' }}>
                                                    Teknik Mesin</option>
                                                <option value="Teknik Elektro"
                                                    {{ old('jurusan', $mahasiswa->jurusan ?? '') == 'Teknik Elektro' ? 'selected' : '' }}>
                                                    Teknik Elektro</option>
                                            </select>
                                            @error('jurusan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Semester -->
                                        <div class="col-md-6 mb-3">
                                            <label for="semester" class="form-label fw-semibold">Semester</label>
                                            <select class="form-select @error('semester') is-invalid @enderror"
                                                id="semester" name="semester" required>
                                                <option value="">Pilih Semester</option>
                                                @for ($i = 1; $i <= 8; $i++)
                                                    <option value="Semester {{ $i }}"
                                                        {{ old('semester', $mahasiswa->semester ?? '') == "Semester $i" ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('semester')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Bio -->
                                        <div class="col-12 mb-4">
                                            <label for="bio" class="form-label fw-semibold">Bio/Deskripsi
                                                Diri</label>
                                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4"
                                                placeholder="Ceritakan tentang diri Anda, keahlian, dan minat karir...">{{ old('bio', $mahasiswa->bio ?? '') }}</textarea>
                                            @error('bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Password & Security Card -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-success text-dark py-3">
                                <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Keamanan</h5>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="{{ route('mahasiswa.profile.update-password') }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-3">
                                        <label for="current_password" class="form-label fw-semibold">Password Saat
                                            Ini</label>
                                        <input type="password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            id="current_password" name="current_password" required>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label fw-semibold">Password Baru</label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                            name="password" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi
                                            Password Baru</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required>
                                    </div>

                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-key me-2"></i>Update Password
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Profile Stats -->
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-success text-white py-3">
                                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Statistik Profil</h5>
                            </div>
                            <div class="card-body p-4">
                                @php
                                    $fields = ['nama', 'nim', 'jurusan', 'semester', 'bio', 'foto'];
                                    $filledFields = 0;
                                    if ($mahasiswa) {
                                        foreach ($fields as $field) {
                                            if (!empty($mahasiswa->$field)) {
                                                $filledFields++;
                                            }
                                        }
                                    }
                                    $completion = $mahasiswa ? round(($filledFields / count($fields)) * 100) : 0;
                                @endphp
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Profil Lengkap</span>
                                    <span class="badge bg-success">{{ $completion }}%</span>
                                </div>
                                <div class="progress mb-3" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: {{ $completion }}%"></div>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Lengkapi profil untuk meningkatkan peluang diterima magang
                                </small>

                                <hr class="my-3">

                                <!-- Profile Summary -->
                                <div class="small">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">NIM:</span>
                                        <span class="fw-semibold">{{ $mahasiswa->nim ?? 'Belum diisi' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Jurusan:</span>
                                        <span class="fw-semibold">{{ $mahasiswa->jurusan ?? 'Belum diisi' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Semester:</span>
                                        <span class="fw-semibold">{{ $mahasiswa->semester ?? 'Belum diisi' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>

    </style>
@endsection
