<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VocIntern') }} - Login</title>

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
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="login-form">
                    <div class="login-logo">
                        <a href="/" class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-briefcase"></i>
                        </a>
                        <h1 class="mt-2 mb-0">VocIntern</h1>
                        <p class="text-muted small">Platform Magang Khusus Mahasiswa Vokasi USU</p>
                    </div>

                    <h2 class="text-center">Masuk ke Akun Anda</h2>

                    @if (session('status'))
                        <div class="alert alert-success mb-3" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control" name="email"
                                    value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="forgot-link" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>

                        <div class="mb-0">
                            <button type="submit" class="btn btn-login w-100">
                                Masuk
                            </button>
                        </div>
                    </form>

                    <div class="divider">
                        <span>atau masuk dengan</span>
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
                        <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>