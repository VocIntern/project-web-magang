<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <title>{{ config('app.name', 'VocIntern') }} - Masuk Perusahaan</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container-fluid login-container">
        <div class="login-card">
            <div class="text-left pe-5 position-absolute">
                <a href="{{ route('welcome') }}" class="btn">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="login-header">
                <h1>VocIntern</h1>
                <p class="definisi">Platform Magang Khusus Mahasiswa Vokasi USU</p>
            </div>
            <div class="login-body">
                <h3 class="text-center mb-4">Masuk ke Akun Perusahaan</h3>

                <div class="role-selector">
                    <div class="role">
                        <a href="{{ route('login') }}" class="role-btn active">Mahasiswa</a>
                        <a href="{{ route('login.perusahaan') }}" class="role-btn" aria-current="page">Perusahaan</a>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success mb-3">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <input type="hidden" name="role" value="mahasiswa">

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Perusahaan</label>
                        <div class="input-group">
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" id="email" value="{{ old('email') }}"
                                placeholder="Masukkan email perusahaan" required autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <div class="input-group position-relative">
                            <input type="password" class="form-control pe-5 @error('password') is-invalid @enderror"
                                name="password" id="password" placeholder="Masukkan kata sandi" required>
                            <span class="toggle-password" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>

                    <button type="submit" class="btn btn-login w-100 mb-3">Masuk</button>

                    <div class="d-flex justify-content-between mb-3">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-decoration-none forgot-password-link">
                                Lupa kata sandi?
                            </a>
                        @endif
                        <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}?role=perusahaan"
                                class="auth-link">Daftar Sekarang</a></p>
                    </div>
                </form>
            </div>
            <div class="footer">
                <small class="text-muted d-block mt-1">© 2025 VocIntern - Platform Magang. All rights reserved.</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 3. SCRIPT ROLE SELECTOR DIHAPUS, hanya menyisakan toggle password
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>
