<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Judul halaman akan dinamis, dengan judul default jika tidak di-set --}}
    <title>@yield('title', 'Dashboard') - VOCintern Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-logo">
            <a class="navbar-brand fw-bold text-success" href="/">
                <i class="fas fa-briefcase me-2 text-success"></i>VocIntern
            </a>
        </div>
        <nav class="sidebar-nav">
            <ul>
                {{-- Menambahkan logika untuk class 'active' secara dinamis --}}
                <li><a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i
                            class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span></a></li>
                <li><a href="{{ route('admin.mahasiswa.index') }}"
                        class="{{ request()->routeIs('admin.mahasiswa.index') ? 'active' : '' }}"><i
                            class="fas fa-user-graduate"></i>
                        <span>Mahasiswa</span></a></li>
                <li><a href="{{ route('admin.perusahaan.index') }}"
                        class="{{ request()->routeIs('admin.perusahaan.index') ? 'active' : '' }}"><i
                            class="fas fa-building"></i> <span>Perusahaan</span></a></li>
                <li><a href="{{ route('admin.magang.index') }}"
                        class="{{ request()->routeIs('admin.magang.index') ? 'active' : '' }}"><i
                            class="fas fa-briefcase"></i> <span>Lowongan Magang</span></a></li>
                <li><a href="#"><i class="fas fa-clipboard-list"></i> <span>Pendaftaran</span></a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i> <span>Laporan</span></a></li>
                <li><a href="#"><i class="fas fa-cog"></i> <span>Pengaturan</span></a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <div class="header">
            <h1>@yield('title', 'Dashboard')</h1>

            <div class="profile-dropdown">
                {{-- Ini adalah tombol yang akan memicu dropdown --}}
                <div class="header-right" id="dropdown-trigger">
                    <i class="fas fa-user-shield"></i>
                    <span>{{ Auth::user()->name ?? 'Administrator' }}</span>
                    <i class="fas fa-caret-down"></i>
                </div>

                {{-- Ini adalah menu dropdown yang tersembunyi secara default --}}
                <div class="dropdown-menu" id="dropdown-content">
                    <a href="#">
                        <i class="fas fa-user-circle"></i> Profile
                    </a>
                    <a href="#">
                        <i class="fas fa-cog"></i> Pengaturan
                    </a>
                    <div class="dropdown-divider"></div>

                    {{-- Form untuk Logout (Cara paling aman) --}}
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        {{-- Di sinilah konten spesifik dari setiap halaman akan ditampilkan --}}
        @yield('content')

    </main>

    {{-- Tempat untuk script global --}}
    <script>
        // Auto refresh data every 30 seconds (contoh)
        setInterval(() => {
            // In real application, you would make an AJAX call to refresh data
            console.log('Checking for new data...');
        }, 30000);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.getElementById('dropdown-trigger');
            const content = document.getElementById('dropdown-content');

            // Jika elemennya ada
            if (trigger && content) {
                // Tampilkan/sembunyikan dropdown saat tombol di-klik
                trigger.addEventListener('click', function(event) {
                    event.stopPropagation(); // Mencegah event "klik" menyebar ke window
                    content.classList.toggle('show');
                });

                // Sembunyikan dropdown saat user mengklik di luar area dropdown
                window.addEventListener('click', function(event) {
                    if (!content.contains(event.target) && !trigger.contains(event.target)) {
                        if (content.classList.contains('show')) {
                            content.classList.remove('show');
                        }
                    }
                });
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

    {{-- Tempat untuk menambahkan JavaScript tambahan dari halaman child --}}
    @stack('scripts')
</body>

</html>
