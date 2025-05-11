<!-- resources/views/auth/verify-email.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VocIntern') }} - Verifikasi Email</title>

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
    <div class="container verify-email-container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="verify-email-form">
                    <div class="login-logo">
                        {{-- <a href="/" class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-briefcase"></i>
                        </a> --}}
                        <h1 class="mt-2 mb-0">VocIntern</h1>
                        <p class="text-muted small">Platform Magang Khusus Mahasiswa Vokasi USU</p>
                    </div>

                    <h2 class="text-center">Verifikasi Email</h2>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success mb-4" role="alert">
                            Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <div class="verify-icon mb-3">
                            <i class="fas fa-envelope-open-text fa-4x text-primary"></i>
                        </div>
                        <p>
                            Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan? Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkan email lainnya.
                        </p>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <form method="POST" action="{{ route('verification.send') }}" class="mb-3 mb-md-0">
                            @csrf
                            <button type="submit" class="btn btn-verify">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Ulang Email Verifikasi
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="fas fa-sign-out-alt me-2"></i>Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>