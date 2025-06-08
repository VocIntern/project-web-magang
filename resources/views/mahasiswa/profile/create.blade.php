@extends('mahasiswa.layouts.mahasiswa')

@section('title', 'Create Profil - VocIntern')

@section('content')
    <div class="container-fluid profile-container">
        <div class="profile-card">
            <!-- Header -->
            <div class="profile-header">
                <h1>VocIntern</h1>
                <p>Lengkapi Profil Anda untuk Memulai Magang</p>
            </div>

            <!-- Body -->
            <div class="profile-body">
                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    Silakan lengkapi informasi profil Anda untuk dapat mengakses platform magang.
                </div>

                <form method="POST" action="{{ route('mahasiswa.profile.store') }}" enctype="multipart/form-data"
                    id="profileForm">
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
                                    <div id="photo-preview"
                                        class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                        style="width: 60px; height: 60px;">
                                        <i class="fas fa-user text-white fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                        id="foto" name="foto" accept="image/jpeg,image/png,image/jpg,image/gif">
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
                                <input type="text" class="form-control @error('nim') is-invalid @enderror" name="nim"
                                    id="nim" value="{{ old('nim') }}" placeholder="Masukkan NIM" required
                                    pattern="[0-9]+" title="NIM harus berupa angka">
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jurusan" class="form-label">Jurusan *</label>
                                <select class="form-select @error('jurusan') is-invalid @enderror" name="jurusan"
                                    id="jurusan" required>
                                    <option value="">Pilih Jurusan</option>
                                    <option value="Teknik Informatika"
                                        {{ old('jurusan') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika
                                    </option>
                                    <option value="Sistem Informasi"
                                        {{ old('jurusan') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi
                                    </option>
                                    <option value="Teknik Komputer"
                                        {{ old('jurusan') == 'Teknik Komputer' ? 'selected' : '' }}>Teknik Komputer
                                    </option>
                                    <option value="Manajemen Informatika"
                                        {{ old('jurusan') == 'Manajemen Informatika' ? 'selected' : '' }}>Manajemen
                                        Informatika</option>
                                    <option value="Akuntansi" {{ old('jurusan') == 'Akuntansi' ? 'selected' : '' }}>
                                        Akuntansi</option>
                                    <option value="Administrasi Bisnis"
                                        {{ old('jurusan') == 'Administrasi Bisnis' ? 'selected' : '' }}>Administrasi Bisnis
                                    </option>
                                    <option value="Teknik Mesin" {{ old('jurusan') == 'Teknik Mesin' ? 'selected' : '' }}>
                                        Teknik Mesin</option>
                                    <option value="Teknik Elektro"
                                        {{ old('jurusan') == 'Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro</option>
                                </select>
                                @error('jurusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="semester" class="form-label">Semester *</label>
                                <select class="form-select @error('semester') is-invalid @enderror" name="semester"
                                    id="semester" required>
                                    <option value="">Pilih Semester</option>
                                    @for ($i = 1; $i <= 8; $i++)
                                        <option value="Semester {{ $i }}"
                                            {{ old('semester') == "Semester $i" ? 'selected' : '' }}>
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
                            <textarea class="form-control @error('bio') is-invalid @enderror" name="bio" id="bio" rows="4"
                                placeholder="Ceritakan tentang diri Anda, keahlian, dan minat karir...">{{ old('bio') }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-outline-success px-5" id="submitBtn">
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
            const previewContainer = document.getElementById('photo-preview');

            fotoInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];

                    // Validate file size (2MB = 2 * 1024 * 1024 bytes)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar. Maksimal 2MB.');
                        this.value = '';
                        return;
                    }

                    // Validate file type
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Format file tidak valid. Hanya JPG, PNG, dan GIF yang diperbolehkan.');
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.innerHTML = `
                            <img src="${e.target.result}" alt="Preview" 
                                 class="rounded-circle" 
                                 style="width: 60px; height: 60px; object-fit: cover;">
                        `;
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Reset to default if no file selected
                    previewContainer.innerHTML = `
                        <i class="fas fa-user text-white fs-4"></i>
                    `;
                }
            });

            // NIM validation (numbers only)
            const nimInput = document.getElementById('nim');
            nimInput.addEventListener('input', function() {
                // Remove any non-numeric characters
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Real-time validation
            const requiredFields = document.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                field.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });

                field.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.classList.remove('is-invalid');
                    }
                });
            });

            // Email validation
            const emailInput = document.getElementById('email');
            emailInput.addEventListener('blur', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (this.value && !emailRegex.test(this.value)) {
                    this.classList.add('is-invalid');
                    this.parentNode.querySelector('.invalid-feedback')?.remove();
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = 'Format email tidak valid';
                    this.parentNode.appendChild(feedback);
                } else if (this.value) {
                    this.classList.remove('is-invalid');
                }
            });

            // Form submission handling
            const form = document.getElementById('profileForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                let isValid = true;
                const errors = [];

                // Validate required fields
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                        errors.push(`${field.labels[0]?.textContent || field.name} wajib diisi`);
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                // Validate email format
                const email = document.getElementById('email').value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (email && !emailRegex.test(email)) {
                    document.getElementById('email').classList.add('is-invalid');
                    isValid = false;
                    errors.push('Format email tidak valid');
                }

                // Validate NIM (should be numeric)
                const nim = document.getElementById('nim').value;
                if (nim && !/^\d+$/.test(nim)) {
                    document.getElementById('nim').classList.add('is-invalid');
                    isValid = false;
                    errors.push('NIM harus berupa angka');
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon perbaiki kesalahan berikut:\n' + errors.join('\n'));
                    return false;
                }

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            });

            // Character counter for bio
            const bioTextarea = document.getElementById('bio');
            const bioContainer = bioTextarea.parentNode;

            // Create character counter
            const charCounter = document.createElement('small');
            charCounter.className = 'text-muted';
            charCounter.style.float = 'right';
            bioContainer.appendChild(charCounter);

            function updateCharCount() {
                const length = bioTextarea.value.length;
                charCounter.textContent = `${length} karakter`;
            }

            bioTextarea.addEventListener('input', updateCharCount);
            updateCharCount(); // Initial count
        });
    </script>
@endsection
