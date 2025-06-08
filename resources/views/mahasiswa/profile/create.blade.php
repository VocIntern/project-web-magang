<!-- resources/views/mahasiswa/create-profile.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register_profile.css') }}">

    <title>{{ config('app.name', 'VocIntern') }} - Lengkapi Profil</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container-fluid profile-container">
        <div class="profile-card">
            <!-- Header -->
            <div class="profile-header">
                <h1>VocIntern</h1>
                <p>Lengkapi Profil Anda untuk Memulai Magang</p>
            </div>

            <!-- Body -->
            <div class="profile-body">
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    Silakan lengkapi informasi profil Anda untuk dapat mengakses platform magang.
                </div>

                <form method="POST" action="{{ route('mahasiswa.profile.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Informasi Pribadi -->
                    <div class="mb-section">
                        <h4 class="section-title">
                            <i class="fas fa-user"></i>
                            Informasi Pribadi
                        </h4>

                        <!-- Profile Photo Section -->
                        <div class="mb-4">
                            <label for="foto" class="form-label">Foto Profil</label>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                        style="width: 60px; height: 60px;">
                                        <i class="fas fa-user text-white fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                        id="foto" name="foto" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    name="nama" id="nama" value="{{ old('nama', $user->name ?? '') }}"
                                    placeholder="Masukkan nama lengkap" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nim" class="form-label">NIM *</label>
                                <input type="number" class="form-control @error('nim') is-invalid @enderror"
                                    name="nim" id="nim" value="{{ old('nim') }}"
                                    placeholder="Masukkan NIM" required>
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jurusan" class="form-label">Jurusan *</label>
                                <select class="form-select @error('jurusan') is-invalid @enderror" name="jurusan" id="jurusan" required>
                                    <option value="">Pilih Jurusan</option>
                                    <option value="Teknik Informatika" {{ old('jurusan') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                    <option value="Sistem Informasi" {{ old('jurusan') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                    <option value="Teknik Komputer" {{ old('jurusan') == 'Teknik Komputer' ? 'selected' : '' }}>Teknik Komputer</option>
                                    <option value="Manajemen Informatika" {{ old('jurusan') == 'Manajemen Informatika' ? 'selected' : '' }}>Manajemen Informatika</option>
                                    <option value="Akuntansi" {{ old('jurusan') == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
                                    <option value="Administrasi Bisnis" {{ old('jurusan') == 'Administrasi Bisnis' ? 'selected' : '' }}>Administrasi Bisnis</option>
                                    <option value="Teknik Mesin" {{ old('jurusan') == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                                    <option value="Teknik Elektro" {{ old('jurusan') == 'Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro</option>
                                </select>
                                @error('jurusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="semester" class="form-label">Semester *</label>
                                <select class="form-select @error('semester') is-invalid @enderror" name="semester" id="semester" required>
                                    <option value="">Pilih Semester</option>
                                    @for ($i = 1; $i <= 8; $i++)
                                        <option value="Semester {{ $i }}" {{ old('semester') == "Semester $i" ? 'selected' : '' }}>
                                            Semester {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <!-- Kosong untuk spacing yang konsisten -->
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio/Deskripsi Diri</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" name="bio" 
                                id="bio" rows="4" placeholder="Ceritakan tentang diri Anda, keahlian, dan minat karir...">{{ old('bio') }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-outline-success px-5">
                            <i class="fas fa-save me-2"></i>
                            Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Photo upload preview
            const fotoInput = document.getElementById('foto');
            const previewContainer = fotoInput.parentElement.previousElementSibling.querySelector('div');
            
            fotoInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        previewContainer.innerHTML = `
                            <img src="${e.target.result}" alt="Preview" 
                                 class="rounded-circle" 
                                 style="width: 60px; height: 60px; object-fit: cover;">
                        `;
                    };
                    
                    reader.readAsDataURL(file);
                }
            });

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field yang wajib diisi!');
                }
            });

            // NIM validation (numbers only)
            const nimInput = document.getElementById('nim');
            nimInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    </script>
</body>

</html>