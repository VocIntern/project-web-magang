<!-- resources/views/auth/forgot-password.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VocIntern') }} - Lupa Password</title>

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
    <div class="container forgot-password-container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="forgot-password-form">
                    <div class="login-logo">
                        {{-- <a href="/" class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-briefcase"></i>
                        </a> --}}
                        <h1 class="mt-2 mb-0">VocIntern</h1>
                        <p class=" small definisi">Platform Magang Khusus Mahasiswa Vokasi USU</p>
                    </div>

                    <h3 class="text-center mt-4">Lupa Password</h3>
                    <p class="text-center text-muted mb-4">
                        Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password Anda.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success mb-3" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">

                            @foreach ($errors->all() as $error)
                                <a>{{ $error }}</a>
                            @endforeach

                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">

                                <input id="email" type="email" class="form-control" name="email"
                                    value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="mb-0">
                            <button type="submit" class="btn btn-reset w-100">
                                Kirim Tautan Reset Password
                            </button>
                        </div>
                    </form>

                    <div class="text-end mt-4">
                        <p class="mb-0"><a href="{{ route('login') }}" class="auth-link"><i
                                    class="fas fa-arrow-left me-2"></i>Kembali
                                ke Halaman Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
