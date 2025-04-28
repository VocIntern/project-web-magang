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
                    {{-- <div class="login-logo">
                        <a href="/" class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-briefcase"></i>
                        </a>
                        <h1 class="mt-2 mb-0">VocIntern</h1>
                        <p class="text-muted small">Platform Magang Khusus Mahasiswa Vokasi USU</p>
                    </div> --}}

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
                        <input type="hidden" name="role" value="{{ request('role', 'mahasiswa') }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control" name="email"
                                    value="{{ old('email') }}" required>
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
                                <input id="password_confirmation" type="password" class="form-control"
                                    name="password_confirmation" required>
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
                        <p class="mb-0">Sudah punya akun?
                            @if (request('role') == 'perusahaan')
                                <a href="{{ route('login') }}">Masuk Sekarang</a>
                            @else
                                <a href="{{ route('login') }}">Masuk Sekarang</a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
