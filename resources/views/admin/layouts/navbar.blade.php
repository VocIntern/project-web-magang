<!-- resources/views/layouts/navbar.blade.php -->
<nav class="navbar navbar-light bg-white px-4 py-3 rounded shadow-sm mb-4">
    <div class="d-flex justify-content-between w-100">
        <div>
            <button class="btn btn-link text-dark d-md-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebar" aria-expanded="false" aria-controls="sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <span class="h5 mb-0">@yield('title', 'Dashboard')</span>
        </div>

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://via.placeholder.com/36" width="36" height="36" class="rounded-circle me-2"
                    alt="Admin">
                <span class="d-none d-sm-inline-block">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                <li><span class="dropdown-item-text text-muted small">Admin</span></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                {{-- <li><a class="dropdown-item" href="{{ route('admin.profile') }}">
                    <i class="fas fa-user-circle me-2"></i> Profil Saya
                </a></li>
                <li><a class="dropdown-item" href="{{ route('admin.settings') }}">
                    <i class="fas fa-cog me-2"></i> Pengaturan
                </a></li> --}}
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
