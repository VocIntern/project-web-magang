<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Judul halaman akan dinamis, dengan judul default jika tidak di-set --}}
    <title>@yield('title', 'Dashboard') - VocIntern Perusahaan</title>

    {{-- Aset CSS dan Font --}}
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- CSS untuk SweetAlert2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    {{-- Untuk CSS tambahan dari halaman child --}}
    @stack('styles')
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-logo mb-4 mx-2">
            <a class="navbar-brand fw-bold text-success" href="{{ route('perusahaan.dashboard') }}">
                <i class="fas fa-briefcase me-2 text-success"></i>VocIntern
            </a>
        </div>
        <nav class="sidebar-nav">
            <ul>
                {{-- NAVIGASI KHUSUS PERUSAHAAN --}}
                <li><a href="{{ route('perusahaan.dashboard') }}"
                        class="{{ request()->routeIs('perusahaan.dashboard') ? 'active' : '' }}"><i
                            class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span></a></li>
                <li><a href="{{ route('perusahaan.profile.edit') }}"
                        class="{{ request()->routeIs('perusahaan.profile.edit') ? 'active' : '' }}"><i
                            class="fas fa-building"></i>
                        <span>Profil Perusahaan</span></a></li>
                <li><a
                        href="{{ route('perusahaan.lowongan.index') }}"class="{{ request()->routeIs('perusahaan.lowongan.index') ? 'active' : '' }}"><i
                            class="fas fa-briefcase"></i>
                        <span>Lowongan Saya</span></a></li>
                <li><a
                        href="{{ route('perusahaan.seleksi.index') }}"class="{{ request()->routeIs('perusahaan.seleksi.index') ? 'active' : '' }}"><i
                            class="fas fa-users"></i> <span>Seleksi
                            Pelamar</span></a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i> <span>Laporan</span></a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <div class="header">
            <div class="header-title">
                <h1 class="mb-0">Halo, {{ Auth::user()->perusahaan?->nama_perusahaan ?? Auth::user()->name }}!</h1>
            </div>

            <div class="profile-dropdown">
                {{-- Tombol pemicu dropdown dengan nama perusahaan --}}
                <div class="header-right" id="dropdown-trigger">
                    {{-- Logika untuk menampilkan logo atau ikon default --}}
                    @if (Auth::user()->perusahaan && Auth::user()->perusahaan->logo)
                        {{-- Jika logo ADA, tampilkan gambar logo --}}
                        <img src="{{ Auth::user()->perusahaan->logo_url }}" alt="Logo" class="header-logo">
                    @else
                        {{-- Jika TIDAK ada logo, tampilkan ikon gedung --}}
                        <i class="fas fa-building"></i>
                    @endif

                    <span>{{ Auth::user()->perusahaan->nama_perusahaan ?? Auth::user()->name }}</span>
                    <i class="fas fa-caret-down"></i>
                </div>

                {{-- Menu dropdown --}}
                <div class="dropdown-menu" id="dropdown-content">
                    <a href="{{ route('perusahaan.profile.edit') }}">
                        <i class="fas fa-user-circle"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>

                    {{-- Form untuk Logout --}}
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

        {{-- Notifikasi (diletakkan di sini agar konsisten) --}}
        <div class="p-3">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
 
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>


        {{-- Di sinilah konten spesifik dari setiap halaman akan ditampilkan --}}
        <div class="p-3">
            @yield('content')
        </div>

    </main>

    {{-- Aset JavaScript --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

    {{-- Script untuk dropdown --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.getElementById('dropdown-trigger');
            const content = document.getElementById('dropdown-content');

            if (trigger && content) {
                trigger.addEventListener('click', function(event) {
                    event.stopPropagation();
                    content.classList.toggle('show');
                });

                window.addEventListener('click', function(event) {
                    if (!content.contains(event.target) && !trigger.contains(event.target)) {
                        if (content.classList.contains('show')) {
                            content.classList.remove('show');
                        }
                    }
                });
            }
        });

        // Script untuk memicu notifikasi SweetAlert2
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2500, // Notifikasi akan hilang setelah 2.5 detik
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                });
            @endif

            @if (session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Informasi',
                    text: '{{ session('info') }}',
                });
            @endif
        });
    </script>

    {{-- Tempat untuk menambahkan JavaScript tambahan dari halaman child --}}
    @stack('scripts')
</body>

</html>
