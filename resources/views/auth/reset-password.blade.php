<!-- resources/views/auth/reset-password.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VocIntern') }} - Reset Password</title>

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
    <div class="container-fluid reset-password-container">
        <div class="reset-card">
            <!-- Header -->
            <div class="reset-header">
                <h1>VocIntern</h1>
                <p class="definisi">Platform Magang Khusus Mahasiswa Vokasi USU</p>
            </div>
            <!-- Body -->
            <div class="reset-body">
                <h3 class="text-center mb-4">Reset Password</h3>
                <p class="text-center text-muted mb-4">
                    Masukkan email dan password baru Anda
                </p>

                @if ($errors->any())
                    <div class="alert alert-danger mb-3">

                        @foreach ($errors->all() as $error)
                            <a>{{ $error }}</a>
                        @endforeach

                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Token Reset -->
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">

                            <input id="email" type="email" class="form-control" name="email"
                                value="{{ old('email', $email) }}" required autofocus>
                        </div>
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-4">
                        <label for="password" class="form-label">Password Baru</label>
                        <div class="input-group">

                            <input id="password" type="password" class="form-control" name="password" required>
                            <span class="toggle-password" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group position-relative">
                            <input id="password_confirmation" type="password" class="form-control"
                                name="password_confirmation" required>
                            <span class="toggle-password" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <small id="passwordMatchMessage" class="text-danger mt-1" style="display: none;">Password
                            tidak
                            cocok</small>
                        <small id="passwordMatchSuccess" class="text-success mt-1" style="display: none;">
                            Password cocok
                        </small>
                    </div>

                    <button type="submit" class="btn btn-login w-100">Reset Password</button>
                </form>


                <div class="text-end mt-4">
                    <p class="mb-0">
                        <a href="{{ route('login') }}" class="auth-link"><i class="fas fa-arrow-left me-2"></i>Kembali
                            ke Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');

            const errorMsg = document.getElementById('passwordMatchMessage');
            const successMsg = document.getElementById('passwordMatchSuccess');
            const submitBtn = document.querySelector('form button[type="submit"]');

            function checkMatch() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                if (confirmPassword === "") {
                    errorMsg.style.display = 'none';
                    successMsg.style.display = 'none';
                    submitBtn.disabled = false;
                    return;
                }

                if (password !== confirmPassword) {
                    errorMsg.style.display = 'block';
                    successMsg.style.display = 'none';
                    submitBtn.disabled = true;
                } else {
                    errorMsg.style.display = 'none';
                    successMsg.style.display = 'block';
                    submitBtn.disabled = false;
                }
            }

            passwordInput.addEventListener('input', checkMatch);
            confirmPasswordInput.addEventListener('input', checkMatch);
        });


        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.parentElement.querySelector('.toggle-password i');

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
