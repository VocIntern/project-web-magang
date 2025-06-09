<!-- resources/views/welcome.blade.php -->
{{-- Autentikasi role setelah login --}}
@auth
    @php
        if (auth()->user()->isAdmin()) {
            header('Location: ' . route('admin.dashboard'));
            exit();
        } elseif (auth()->user()->isMahasiswa()) {
            header('Location: ' . route('mahasiswa.profile.create'));
            exit();
        } elseif (auth()->user()->isPerusahaan()) {
            header('Location: ' . route('perusahaan.dashboard'));
            exit();
        }
    @endphp
@endauth
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VocIntern - Platform Magang Khusus Mahasiswa Vokasi USU</title>

    <!-- Custom CSS -->
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body class="antialiased">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3 fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="/">
                <i class="fas fa-briefcase me-2 text-success"></i>VocIntern
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/magang/search">Cari Magang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}?role=perusahaan">Untuk Perusahaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/tentang">Tentang Kami</a>
                    </li>
                </ul>
                <div class="d-flex">
                    @if (Route::has('login'))
                        <div>
                            @auth
                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="btn btn-outline-success me-2">Dashboard</a>
                                @elseif(auth()->user()->isMahasiswa())
                                    <a href="{{ route('mahasiswa.profile.create') }}"
                                        class="btn btn-outline-success me-2">Cari Magang</a>
                                @elseif(auth()->user()->isPerusahaan())
                                    <a href="{{ route('perusahaan.dashboard') }}"
                                        class="btn btn-outline-success me-2">Dashboard</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-success me-2">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-success">Daftar</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section position-relative text-white d-flex align-items-center" style="min-height: 100vh;">
        <div class="hero-bg position-absolute top-0 start-0 w-100 h-100"></div>

        <div class="container position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Temukan Magang Vokasi Terbaik</h1>
                    <p class="lead mb-4">VocIntern menghubungkan mahasiswa vokasi USU dengan peluang magang terbaik di
                        perusahaan terkemuka. Raih pengalaman kerja berharga sebelum lulus!</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">Daftar Sekarang</a>
                        <a href="{{ route('mahasiswa.magang.search') }}" class="btn btn-outline-success btn-lg">Lihat
                            Lowongan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="search-section py-5">
        <div class="container">
            <div class="search-box bg-white p-4">
                <form id="searchForm" class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="posisiInput" name="posisi" class="form-control border-start-0"
                                placeholder="Posisi atau kata kunci">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-map-marker-alt text-muted"></i>
                            </span>
                            <input type="text" id="lokasiInput" name="lokasi" class="form-control border-start-0"
                                placeholder="Lokasi">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-outline-success w-100">
                            <span class="btn-text">Cari Lowongan</span>
                            <span class="btn-loading d-none">
                                <i class="fas fa-spinner fa-spin me-2"></i>Mencari...
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Filter tambahan (opsional) -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-link text-decoration-none" id="resetSearch">
                            <i class="fas fa-refresh me-1"></i>Reset Pencarian
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Internships -->
    <section class="py-5" id="magang-section">
        <div class="container">
            <h2 class="text-center text-white mb-5">
                <span id="section-title" class="text-success">Lowongan Magang Terbaru</span>
                <span id="search-count" class="d-none badge text-success ms-2"></span>
            </h2>

            <!-- Loading indicator -->
            <div id="loading-indicator" class="text-center d-none">
                <div class="spinner-border text-success" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-white">Sedang mencari lowongan...</p>
            </div>

            <!-- Container untuk hasil magang -->
            <div class="row" id="magang-container">
                @forelse($magang as $item)
                    <div class="col-md-6 col-lg-4 mb-4 magang-item">
                        <div class="job-card bg-light">
                            <div class="d-flex mb-3">
                                <div
                                    class="company-logo me-3 d-flex align-items-center justify-content-center text-success">
                                    @if ($item->perusahaan->logo)
                                        <img src="{{ asset('storage/' . $item->perusahaan->logo) }}"
                                            alt="{{ $item->perusahaan->nama_perusahaan }}" class="img-fluid rounded">
                                    @else
                                        {{ substr($item->perusahaan->nama_perusahaan, 0, 3) }}
                                    @endif
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ $item->judul }}</h5>
                                    <p class="mb-0 text-muted">{{ $item->perusahaan->nama_perusahaan }}</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <span class="badge bg-success text-white me-2">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $item->lokasi }}
                                </span>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $item->kuota }} posisi tersedia
                                </span>
                            </div>
                            <p class="text-muted small">{{ Str::limit($item->deskripsi, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    Dibuka hingga {{ $item->tanggal_selesai->format('d M Y') }}
                                </small>

                                <a href="{{ route('mahasiswa.magang.show', $item->id) }}"
                                    class="btn btn-sm btn-outline-success">Lihat Detail</a>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center" id="no-results">
                        <p class="text-muted">Tidak ada lowongan magang yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <!-- Pagination -->
            <div id="pagination-container" class="col-12">
                @if ($magang->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $magang->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                    </div>
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $magang->firstItem() }} - {{ $magang->lastItem() }} dari
                            {{ $magang->total() }} hasil
                        </small>
                    </div>
                @endif
            </div>

            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-success">Lihat Semua Lowongan</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-warning">
        <div class="container">
            <h2 class="text-center mb-5">Mengapa VocIntern?</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-card bg-white">
                        <div class="feature-icon">
                            <i class="fas fa-search" style="color: #006633;"></i>
                        </div>
                        <h4>Mudah Mencari</h4>
                        <p class="text-muted">Temukan magang yang sesuai dengan keahlian dan minat Anda dengan fitur
                            pencarian canggih.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card bg-white">
                        <div class="feature-icon">
                            <i class="fas fa-building" style="color: #006633;"></i>
                        </div>
                        <h4>Perusahaan Terpercaya</h4>
                        <p class="text-muted">Terhubung dengan perusahaan terkemuka yang menawarkan pengalaman magang
                            berkualitas.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card bg-white">
                        <div class="feature-icon">
                            <i class="fas fa-laptop-code" style="color: #006633;"></i>
                        </div>
                        <h4>Fokus Vokasi</h4>
                        <p class="text-muted">Platform khusus untuk mahasiswa vokasi USU yang mencari pengalaman
                            praktis sesuai bidang studi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-warning">
        <div class="container text-center">
            <h2 class="mb-4">Siap Memulai Karir Anda?</h2>
            <p class="lead mb-4">Daftar sekarang dan temukan magang yang sesuai dengan minat dan keahlian Anda.</p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="{{ route('register') }}?role=mahasiswa" class="btn btn-light btn-lg">Daftar Sebagai
                    Mahasiswa</a>
                <a href="{{ route('register') }}?role=perusahaan" class="btn btn-outline-light btn-lg">Daftar Sebagai
                    Perusahaan</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" style="background-color: #006633;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="fw-bold"><i class="fas fa-briefcase me-2"></i>VocIntern</h5>
                    <p class="text-muted">Platform magang khusus untuk mahasiswa vokasi USU, menghubungkan talenta
                        berbakat dengan perusahaan terkemuka.</p>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h6 class="fw-bold mb-3">Magang</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Cari Magang</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Kategori</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Lokasi</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Perusahaan</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h6 class="fw-bold mb-3">Perusahaan</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Posting
                                Lowongan</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Profil
                                Perusahaan</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Manfaat
                                Kerjasama</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Sukses Story</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h6 class="fw-bold mb-3">Bantuan</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">FAQ</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Kontak Kami</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Panduan</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Tips Magang</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="fw-bold mb-3">Kontak</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Kampus USU, Medan</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> vocintern2025@gmail.com</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center text-muted">
                <p>&copy; {{ date('Y') }} VocIntern - Universitas Sumatera Utara. All rights reserved.</p>
                <p class="small">Dikembangkan oleh Mahasiswa Vokasi USU</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JavaScript untuk pencarian AJAX -->
    <script src="{{ asset('js/config.js') }}"></script>
    <script src="{{ asset('js/welcome.js') }}"></script>
    <script>
        // Initialize with Laravel routes
        $(document).ready(function() {
            if (window.welcomePage) {
                window.welcomePage.setRoutes({
                    ajaxSearch: '{{ route('ajax.search') }}',
                    ajaxPaginate: '{{ route('ajax.paginate') }}',
                    magangShow: '{{ route('mahasiswa.magang.show', ['id' => 'MAGANG_ID']) }}'.replace(
                        'MAGANG_ID', ':id'),
                    liveSearch: '{{ route('live.search') }}'
                });
            }
        });
    </script>
</body>

</html>
