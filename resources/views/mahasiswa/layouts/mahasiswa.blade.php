<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mahasiswa Portal')</title>
    <!-- Global CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <!-- Page-specific CSS -->
    <link rel="stylesheet" href="{{ asset('css/mahasiswa-magang.css') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
            <a class="navbar-brand fw-bold ms-5 text-white"href="/">
                <i class="fas fa-briefcase me-2 text-white"></i>VocIntern
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        <div class="container">
            <a class="navbar-brand" href="#">Portal Mahasiswa</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mahasiswa.magang.search') ? 'active' : '' }}"
                            href="{{ route('mahasiswa.magang.search') }}">Cari Lowongan</a>
                    </li>

                    <!-- Add more links as needed -->
                </ul>
                <ul class="navbar-nav"> 
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn btn-outline-dark  text-white" href="#" id="userDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-2"></i>Profil{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('mahasiswa.profile.*') ? 'active' : '' }}"
                                href="{{ route('mahasiswa.profile.edit') }}">
                                    <i class="fas fa-edit me-2"></i>Edit Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-3 bg-light">
        <div class="container">
            &copy; {{ date('Y') }} Portal Mahasiswa. All rights reserved.
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
