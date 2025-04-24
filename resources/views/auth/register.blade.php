<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VocIntern') }} - Daftar</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container register-container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="register-form">
                    <div class="login-logo">
                        <a href="/" class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-briefcase"></i>
                        </a>
                        <h1 class="mt-2 mb-0">VocIntern</h1>
                        <p class="text-muted small">Platform Magang Khusus Mahasiswa Vokasi USU</p>
                    </div>

                    <h2 class="text-center">Buat Akun Baru</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Daftar Sebagai</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                <select id="role" name="role" class="form-select" required>
                                    <option value="">Pilih Peran</option>
                                    <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                    <option value="perusahaan" {{ old('role') == 'perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                                </select>
                            </div>
                        </div>

                        <!-- Fields for Mahasiswa -->
                        <div id="mahasiswa-fields" class="role-fields" style="display: none;">
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input id="nim" type="text" class="form-control" name="nim" value="{{ old('nim') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                    <input id="jurusan" type="text" class="form-control" name="jurusan" value="{{ old('jurusan') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="angkatan" class="form-label">Angkatan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input id="angkatan" type="number" class="form-control" name="angkatan" value="{{ old('angkatan') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="bio" class="form-label">Bio (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    <textarea id="bio" class="form-control" name="bio" rows="3">{{ old('bio') }}</textarea>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                                    <input id="foto" type="file" class="form-control" name="foto">
                                </div>
                            </div>
                        </div>

                        <!-- Fields for Perusahaan -->
                        <div id="perusahaan-fields" class="role-fields" style="display: none;">
                            <div class="mb-3">
                                <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    <input id="nama_perusahaan" type="text" class="form-control" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <textarea id="alamat" class="form-control" name="alamat" rows="3">{{ old('alamat') }}</textarea>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="bidang" class="form-label">Bidang Usaha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                    <input id="bidang" type="text" class="form-control" name="bidang" value="{{ old('bidang') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="website" class="form-label">Website (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                    <input id="website" type="url" class="form-control" name="website" value="{{ old('website') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo Perusahaan (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                                    <input id="logo" type="file" class="form-control" name="logo">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Perusahaan (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    <textarea id="deskripsi" class="form-control" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <button type="submit" class="btn btn-register w-100">
                                Daftar
                            </button>
                        </div>
                    </form>

                    <div class="divider">
                        <span>atau daftar dengan</span>
                    </div>

                    <div class="social-login">
                        <a href="#" class="btn btn-google">
                            <i class="fab fa-google me-2"></i> Google
                        </a>
                        <a href="#" class="btn btn-linkedin">
                            <i class="fab fa-linkedin-in me-2"></i> LinkedIn
                        </a>
                    </div>

                    <div class="text-center mt-4">
                        <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}">Masuk Sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Show/hide role-specific fields based on selection
        document.getElementById('role').addEventListener('change', function() {
            const mahasiswaFields = document.getElementById('mahasiswa-fields');
            const perusahaanFields = document.getElementById('perusahaan-fields');
            
            // Hide all role fields first
            mahasiswaFields.style.display = 'none';
            perusahaanFields.style.display = 'none';
            
            // Show fields based on selected role
            if (this.value === 'mahasiswa') {
                mahasiswaFields.style.display = 'block';
            } else if (this.value === 'perusahaan') {
                perusahaanFields.style.display = 'block';
            }
        });
        
        // Trigger change event if role is pre-selected (e.g., when returning with errors)
        window.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            if (roleSelect.value) {
                const event = new Event('change');
                roleSelect.dispatchEvent(event);
            }
        });
    </script>
</body>

</html>