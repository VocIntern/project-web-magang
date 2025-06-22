<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - VocIntern</title>
    
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>VocIntern</h1>
                <p class="definisi">Admin Panel</p>
            </div>

            <div class="login-body">
                <h3 class="text-center mb-4">Masuk ke Panel Admin</h3>

                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                
                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan email admin" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan kata sandi" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>

                    <button type="submit" class="btn btn-login w-100 mb-3">Masuk</button>
                </form>
            </div>
            
            <div class="footer">
                <small class="text-muted d-block mt-1">© {{ date('Y') }} VocIntern - Platform Magang. All rights reserved.</small>
            </div>
        </div>
    </div>
</body>
</html>