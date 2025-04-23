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

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fa;
        }
        
        .register-container {
            margin-top: 3%;
            margin-bottom: 3%;
        }
        
        .register-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .register-form h2 {
            margin-bottom: 30px;
            font-weight: 600;
        }
        
        .form-control {
            height: 50px;
            border: 2px solid #eee;
            border-radius: 6px;
            padding: 0 15px;
        }
        
        .form-control:focus {
            box-shadow: none;
            border-color: #4a6cf7;
        }
        
        .btn-register {
            background-color: #4a6cf7;
            border-color: #4a6cf7;
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            height: 50px;
            border-radius: 6px;
        }
        
        .btn-register:hover {
            background-color: #3a5bd9;
            border-color: #3a5bd9;
        }
        
        .social-register {
            text-align: center;
            margin-top: 20px;
        }
        
        .social-register .btn {
            display: inline-block;
            font-weight: 500;
            border-radius: 6px;
            padding: 12px 24px;
            margin: 0 5px;
            color: #fff;
        }
        
        .btn-google {
            background-color: #ea4335;
            border-color: #ea4335;
        }
        
        .btn-google:hover {
            background-color: #d33426;
            border-color: #d33426;
            color: #fff;
        }
        
        .btn-linkedin {
            background-color: #0077b5;
            border-color: #0077b5;
        }
        
        .btn-linkedin:hover {
            background-color: #005e93;
            border-color: #005e93;
            color: #fff;
        }
        
        .register-logo {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .register-logo i {
            font-size: 48px;
            color: #4a6cf7;
        }
        
        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }
        
        .divider::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #eee;
            z-index: 1;
        }
        
        .divider span {
            position: relative;
            background-color: #fff;
            padding: 0 15px;
            z-index: 2;
            color: #999;
        }
        
        .user-type-selector {
            margin-bottom: 20px;
        }
        
        .user-type-selector label {
            cursor: pointer;
            padding: 15px;
            border: 2px solid #eee;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s;
        }
        
        .user-type-selector label:hover {
            border-color: #4a6cf7;
        }
        
        .user-type-selector input[type="radio"]:checked + label {
            border-color: #4a6cf7;
            background-color: rgba(74, 108, 247, 0.1);
        }
        
        .user-type-selector input[type="radio"] {
            display: none;
        }
        
        .user-type-selector i {
            display: block;
            font-size: 24px;
            margin-bottom: 10px;
            color: #4a6cf7;
        }
    </style>
</head>
<body>
    <div class="container register-container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="register-form">
                    <div class="register-logo">
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
                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="user-type-selector">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="radio" name="user_type" id="student" value="student" {{ old('user_type') == 'student' ? 'checked' : '' }} required>
                                    <label for="student" class="w-100">
                                        <i class="fas fa-user-graduate"></i>
                                        <span>Mahasiswa</span>
                                    </label>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="radio" name="user_type" id="company" value="company" {{ old('user_type') == 'company' ? 'checked' : '' }}>
                                    <label for="company" class="w-100">
                                        <i class="fas fa-building"></i>
                                        <span>Perusahaan</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>
                        
                        <div id="student_fields" class="mb-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <input id="nim" type="text" class="form-control" name="nim" value="{{ old('nim') }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="study_program" class="form-label">Program Studi</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                        <select id="study_program" class="form-control" name="study_program">
                                            <option value="">Pilih Program Studi</option>
                                            <option value="Teknologi Informasi">Teknologi Informasi</option>
                                            <option value="Administrasi Bisnis">Administrasi Bisnis</option>
                                            <option value="Akuntansi">Akuntansi</option>
                                            <option value="Teknik Digital">Teknik Digital</option>
                                            <option value="Perpajakan">Perpajakan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="company_fields" class="mb-3" style="display: none;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="company_name" class="form-label">Nama Perusahaan</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                        <input id="company_name" type="text" class="form-control" name="company_name" value="{{ old('company_name') }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="industry" class="form-label">Industri</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-industry"></i></span>
                                        <select id="industry" class="form-control" name="industry">
                                            <option value="">Pilih Industri</option>
                                            <option value="Teknologi">Teknologi</option>
                                            <option value="Keuangan">Keuangan</option>
                                            <option value="Pendidikan">Pendidikan</option>
                                            <option value="Manufaktur">Manufaktur</option>
                                            <option value="Kesehatan">Kesehatan</option>
                                            <option value="Retail">Retail</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="company_address" class="form-label">Alamat Perusahaan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <textarea id="company_address" class="form-control" name="company_address" rows="3">{{ old('company_address') }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Saya menyetujui <a href="#">Syarat dan Ketentuan</a> serta <a href="#">Kebijakan Privasi</a>
                            </label>
                        </div>
                        
                        <div class="mb-0">
                            <button type="submit" class="btn btn-register w-100">
                                Daftar Sekarang
                            </button>
                        </div>
                    </form>
                    
                    <div class="divider">
                        <span>atau daftar dengan</span>
                    </div>
                    
                    <div class="social-register">
                        <a href="#" class="btn btn-google">
                            <i class="fab fa-google me-2"></i> Google
                        </a>
                        <a href="#" class="btn btn-linkedin">
                            <i class="fab fa-linkedin-in me-2"></i> LinkedIn
                        </a>
                    </div>
                    
                    <div class="text-center mt-4">
                        <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle between student and company registration fields
        document.addEventListener('DOMContentLoaded', function() {
            const studentRadio = document.getElementById('student');
            const companyRadio = document.getElementById('company');
            const studentFields = document.getElementById('student_fields');
            const companyFields = document.getElementById('company_fields');
            
            // Initial state based on preselected value
            if (studentRadio.checked) {
                studentFields.style.display = 'block';
                companyFields.style.display = 'none';
            } else if (companyRadio.checked) {
                studentFields.style.display = 'none';
                companyFields.style.display = 'block';
            }
            
            // Event listeners for radio buttons
            studentRadio.addEventListener('change', function() {
                if (this.checked) {
                    studentFields.style.display = 'block';
                    companyFields.style.display = 'none';
                }
            });
            
            companyRadio.addEventListener('change', function() {
                if (this.checked) {
                    studentFields.style.display = 'none';
                    companyFields.style.display = 'block';
                }
            });
        });
    </script>
</body>
</html>