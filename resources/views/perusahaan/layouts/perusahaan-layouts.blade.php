{{-- resources/views/layouts/perusahaan.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VOCintern - Platform Magang')</title>

    {{-- CSS Files --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- Page Specific CSS --}}
    @stack('styles')

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="logo">VOCintern - Platform Magang</div>
        <ul class="menu">
            <li class="{{ request()->routeIs('perusahaan.dashboard') ? 'active' : '' }}">
                <a href="{{ route('perusahaan.dashboard') }}">
                    <i class="material-icons">dashboard</i> Dashboard
                </a>
            </li>
            {{-- <li class="{{ request()->routeIs('perusahaan.lowongan.*') ? 'active' : '' }}">
                <a href="{{ route('perusahaan.lowongan.index') }}">
                    <i class="material-icons">work</i> Lowongan Magang
                </a>
            </li>
            <li class="{{ request()->routeIs('perusahaan.pelamar.*') ? 'active' : '' }}">
                <a href="{{ route('perusahaan.pelamar.index') }}">
                    <i class="material-icons">people</i> Pelamar
                </a>
            </li>
            <li class="{{ request()->routeIs('perusahaan.seleksi.*') ? 'active' : '' }}">
                <a href="{{ route('perusahaan.seleksi.index') }}">
                    <i class="fas fa-user-graduate"></i> Seleksi Mahasiswa
                </a>
            </li>
            <li class="{{ request()->routeIs('perusahaan.marketing.*') ? 'active' : '' }}">
                <a href="{{ route('perusahaan.marketing.index') }}">
                    <i class="material-icons">monetization_on</i> Marketing Apps
                </a>
            </li>
            <li class="{{ request()->routeIs('perusahaan.card.*') ? 'active' : '' }}">
                <a href="{{ route('perusahaan.card.index') }}">
                    <i class="material-icons">credit_card</i> Card Mahasiswa
                </a>
            </li>
            <li class="{{ request()->routeIs('perusahaan.pesan.*') ? 'active' : '' }}">
                <a href="{{ route('perusahaan.pesan.index') }}">
                    <i class="material-icons">message</i> Pesan
                </a>
            </li>
            <li class="{{ request()->routeIs('perusahaan.pengaturan.*') ? 'active' : '' }}">
                <a href="{{ route('perusahaan.pengaturan.index') }}">
                    <i class="material-icons">settings</i> Pengaturan
                </a> --}}
            </li>
        </ul>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        {{-- Header --}}
        <div class="header">
            <div class="user-info">
                <i class="material-icons">account_circle</i>
                <span>{{ Auth::user()->perusahaan->nama_perusahaan ?? 'Nama Perusahaan' }}</span>
                <i class="material-icons">arrow_drop_down</i>
            </div>
        </div>

        {{-- Content Area --}}
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    {{-- JavaScript Files --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Page Specific Scripts --}}
    @stack('scripts')
</body>

</html>
