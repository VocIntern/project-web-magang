<!-- resources/views/layouts/sidebar.blade.php -->
<nav id="sidebar" class="sidebar-shrink col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="sidebar-green pt-3 d-flex flex-column h-100">
        <div class="px-3 py-4 d-flex align-items-center">
            <i class="fas fa-briefcase text-white me-2 fa-2x"></i>
            <h4 class="mb-0 text-white">VocIntern</h4>
        </div>

        <hr class="border-light my-0">

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.mahasiswa.*') ? 'active' : '' }}"
                    href="{{ route('admin.mahasiswa.index') }}">
                    <i class="fas fa-user-graduate"></i>
                    Mahasiswa
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.perusahaan.*') ? 'active' : '' }}"
                    href="{{ route('admin.perusahaan.index') }}">
                    <i class="fas fa-building"></i>
                    Perusahaan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.magang.*') ? 'active' : '' }}"
                    href="{{ route('admin.magang.index') }}">
                    <i class="fas fa-briefcase"></i>
                    Lowongan Magang
                </a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.laporan.*') ? 'active' : '' }}" 
                   href="{{ route('admin.laporan.index') }}">
                    <i class="fas fa-chart-bar"></i>
                    Laporan Magang
                </a>
            </li> --}}
        </ul>

        <hr class="border-light">

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('welcome') }}" target="_blank">
                    <i class="fas fa-home"></i>
                    Halaman Utama
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.settings') }}">
                    <i class="fas fa-cog"></i>
                    Pengaturan
                </a>
            </li> --}}
        </ul>

        <div class="mt-auto px-3 py-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm w-100">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>
</nav>
