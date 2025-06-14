<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <title>{{ config('app.name', 'VocIntern') }} - Masuk</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
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
            <!-- Header -->
            <div class="login-header">
                <h1>VocIntern</h1>
                <p class="definisi">Platform Magang Khusus Mahasiswa Vokasi USU</p>
            </div>

            <!-- Body -->
            <div class="login-body">
                <h3 class="text-center mb-4">Masuk ke Akun Anda</h3>
                <div class="role-selector">
                    <button type="button" class="role-btn active" data-role="mahasiswa">
                        Mahasiswa
                    </button>
                    <button type="button" class="role-btn" data-role="perusahaan">
                        Perusahaan
                    </button>
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

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" id="email" value="{{ old('email') }}"
                                placeholder="Masukkan email anda" required autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 ">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <div class="input-group position-relative">
                            <input type="password" class="form-control pe-5 @error('password') is-invalid @enderror"
                                name="password" id="password" placeholder="Masukkan kata sandi" required>
                            <span class="toggle-password" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Ingat saya
                        </label>
                    </div>

                    <button type="submit" class="btn btn-login w-100 mb-3">Masuk</button>

                    <div class="d-flex justify-content-between mb-3">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-decoration-none forgot-password-link">
                                Lupa kata sandi?
                            </a>
                        @endif
                        <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}" class="auth-link">Daftar
                                Sekarang</a></p>
                    </div>
                </form>

                <!-- Divider -->
                <div class="divider">
                    <span>atau masuk dengan</span>
                </div>

                <!-- Social Login -->
                <div class="social-login">
                    <a href="#" class="btn-google">
                        <i class="fab fa-google"></i>
                        Google
                    </a>
                    <a href="#" class="btn-facebook">
                        <i class="fab fa-facebook-f"></i>
                        Facebook
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">

                <small class="text-muted d-block mt-1">© 2025 VocIntern - Platform Magang. All rights reserved.</small>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Role Selector Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const roleButtons = document.querySelectorAll('.role-btn');
            const selectedRoleInput = document.getElementById('selected-role');
            const emailInput = document.getElementById('email');

            // Function to get URL parameter
            function getUrlParameter(name) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }

            // Function to update email placeholder based on role
            function updateEmailPlaceholder(role) {
                if (role === 'mahasiswa') {
                    emailInput.placeholder = 'Masukkan email anda';
                } else if (role === 'perusahaan') {
                    emailInput.placeholder = 'Masukkan email perusahaan';
                }
            }

            // Function to set active role
            function setActiveRole(role) {
                // Remove active class from all buttons
                roleButtons.forEach(btn => btn.classList.remove('active'));

                // Find and activate the target button
                const targetButton = document.querySelector(`[data-role="${role}"]`);
                if (targetButton) {
                    targetButton.classList.add('active');
                    selectedRoleInput.value = role;
                    updateEmailPlaceholder(role);
                    return true;
                }
                return false;
            }

            // Add click event listeners
            roleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const selectedRole = this.getAttribute('data-role');
                    setActiveRole(selectedRole);
                });
            });

            // Determine initial role priority:
            // 1. URL parameter (?role=perusahaan)
            // 2. Old input (for form validation errors)
            // 3. Default (mahasiswa)

            const urlRole = getUrlParameter('role');
            const oldRole = '{{ old('role') }}';

            let initialRole = 'mahasiswa'; // default

            if (urlRole && (urlRole === 'mahasiswa' || urlRole === 'perusahaan')) {
                initialRole = urlRole;
                console.log('Using URL role:', initialRole);
            } else if (oldRole && (oldRole === 'mahasiswa' || oldRole === 'perusahaan')) {
                initialRole = oldRole;
                console.log('Using old role:', initialRole);
            }

            // Set the initial active role
            setActiveRole(initialRole);
        });


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
