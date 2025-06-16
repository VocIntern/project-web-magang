@extends('admin.layouts.admin')

@section('title', 'Edit Mahasiswa')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card modern-card">
                    <div class="card-header">
                        <div class="card-toolbar">
                            <h4 class="card-title mb-0">Edit Data Mahasiswa</h4>
                            <div class="card-actions">
                                <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-outline-secondary btn-sm">
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

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('admin.mahasiswa.update', $mahasiswa->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Profile Picture Section -->
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Foto Profile</h6>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <img id="foto-preview"
                                                    src="{{ $mahasiswa->foto ? asset('storage/' . $mahasiswa->foto) : asset('images/default-avatar.png') }}"
                                                    alt="Foto Mahasiswa" class="img-thumbnail"
                                                    style="width: 200px; height: 200px; object-fit: cover;">
                                            </div>
                                            <div class="mb-3">
                                                <input type="file"
                                                    class="form-control @error('foto') is-invalid @enderror" id="foto"
                                                    name="foto" accept="image/*">
                                                @error('foto')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Fields -->
                                <div class="col-md-8">
                                    <div class="row">
                                        <!-- Data Akademik -->
                                        <div class="col-12">
                                            <h6 class="text-primary mb-3">
                                                <i class="fas fa-graduation-cap"></i> Data Akademik
                                            </h6>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="nama" class="form-label">Nama Lengkap <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                id="nama" name="nama" value="{{ old('nama', $mahasiswa->nama) }}"
                                                required>
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="nim" class="form-label">NIM <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('nim') is-invalid @enderror"
                                                id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}"
                                                required>
                                            @error('nim')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="jurusan" class="form-label">Jurusan <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('jurusan') is-invalid @enderror"
                                                id="jurusan" name="jurusan" required>
                                                <option value="">Pilih Jurusan</option>
                                                <option value="Teknik Informatika"
                                                    {{ old('jurusan', $mahasiswa->jurusan) == 'Teknik Informatika' ? 'selected' : '' }}>
                                                    Teknik Informatika</option>
                                                <option value="Sistem Informasi"
                                                    {{ old('jurusan', $mahasiswa->jurusan) == 'Sistem Informasi' ? 'selected' : '' }}>
                                                    Sistem Informasi</option>
                                                <option value="Teknik Komputer"
                                                    {{ old('jurusan', $mahasiswa->jurusan) == 'Teknik Komputer' ? 'selected' : '' }}>
                                                    Teknik Komputer</option>
                                                <option value="Manajemen Informatika"
                                                    {{ old('jurusan', $mahasiswa->jurusan) == 'Manajemen Informatika' ? 'selected' : '' }}>
                                                    Manajemen Informatika</option>
                                                <option value="Teknik Elektro"
                                                    {{ old('jurusan', $mahasiswa->jurusan) == 'Teknik Elektro' ? 'selected' : '' }}>
                                                    Teknik Elektro</option>
                                                <option value="Teknik Mesin"
                                                    {{ old('jurusan', $mahasiswa->jurusan) == 'Teknik Mesin' ? 'selected' : '' }}>
                                                    Teknik Mesin</option>
                                                <option value="Akuntansi"
                                                    {{ old('jurusan', $mahasiswa->jurusan) == 'Akuntansi' ? 'selected' : '' }}>
                                                    Akuntansi</option>
                                                <option value="Manajemen"
                                                    {{ old('jurusan', $mahasiswa->jurusan) == 'Manajemen' ? 'selected' : '' }}>
                                                    Manajemen</option>
                                            </select>
                                            @error('jurusan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="semester" class="form-label">Semester <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('semester') is-invalid @enderror"
                                                id="semester" name="semester" required>
                                                <option value="">Pilih Semester</option>
                                                @for ($i = 1; $i <= 8; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ old('semester', $mahasiswa->semester) == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('semester')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Data Akun -->
                                        <div class="col-12 mt-4">
                                            <h6 class="text-primary mb-3">
                                                <i class="fas fa-user"></i> Data Akun
                                            </h6>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email"
                                                value="{{ old('email', $mahasiswa->user->email) }}" required>
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
                                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label">Konfirmasi
                                                Password</label>
                                            <input type="password"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                id="password_confirmation" name="password_confirmation">
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Bio -->
                                        <div class="col-12 mt-3">
                                            <h6 class="text-primary mb-3">
                                                <i class="fas fa-info-circle"></i> Informasi Tambahan
                                            </h6>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="bio" class="form-label">Bio/Deskripsi</label>
                                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4"
                                                placeholder="Tulis bio atau deskripsi singkat tentang mahasiswa...">{{ old('bio', $mahasiswa->bio) }}</textarea>
                                            @error('bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Preview foto sebelum upload
            document.getElementById('foto').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('foto-preview').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Show/hide password confirmation field
            document.getElementById('password').addEventListener('input', function() {
                const confirmField = document.getElementById('password_confirmation').parentElement;
                if (this.value) {
                    confirmField.style.display = 'block';
                } else {
                    confirmField.style.display = 'none';
                    document.getElementById('password_confirmation').value = '';
                }
            });

            // Initialize password confirmation visibility
            document.addEventListener('DOMContentLoaded', function() {
                const passwordField = document.getElementById('password');
                const confirmField = document.getElementById('password_confirmation').parentElement;

                if (!passwordField.value) {
                    confirmField.style.display = 'none';
                }
            });
        </script>
    @endpush
@endsection
