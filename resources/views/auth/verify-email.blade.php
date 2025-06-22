<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VocIntern') }} - Verifikasi Email</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-fluid auth-container">
        <div class="auth-card">
            <div class="reset-header">
                <h1>VocIntern</h1>
                <p class="definisi">Platform Magang Khusus Mahasiswa Vokasi USU</p>
            </div>
            <div class="auth-body">

                <h5 class="text-center fw-bold mb-4">Verifikasi Alamat Email Anda</h5>

                <div class="mb-3 text-center text-sm text-muted">
                    Terima kasih telah mendaftar! Silakan periksa kotak masuk email Anda untuk link verifikasi. Jika
                    tidak menerima email, kami akan mengirimkannya kembali.
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success mb-4" role="alert">
                        Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                    </div>
                @endif

                <div class="mt-4 d-grid gap-3">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted auth-link">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
