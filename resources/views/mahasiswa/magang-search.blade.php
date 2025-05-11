@extends('mahasiswa.layouts.mahasiswa')

@section('title', 'Cari Magang')

@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('css/mahasiswa-magang.css') }}">

    </head>
    <div class="container py-4">
        <!-- Search Header -->
        <div class="bg-primary text-white p-4 rounded-lg mb-4">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="mb-3">Cari Lowongan Magang</h2>
                    <form action="{{ route('mahasiswa.magang.search') }}" method="GET" class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword" placeholder="Cari magang..."
                                    value="{{ request('keyword') }}">
                                <button class="btn btn-light" type="submit">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 text-md-end">
                    <p class="mb-0">{{ $magang->total() }} lowongan ditemukan</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Filter</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('mahasiswa.magang.search') }}" method="GET">
                            @if (request('keyword'))
                                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                            @endif

                            <!-- Lokasi Filter -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Lokasi</label>
                                <select name="lokasi" class="form-select">
                                    <option value="">Semua Lokasi</option>
                                    <option value="Jakarta" {{ request('lokasi') == 'Jakarta' ? 'selected' : '' }}>Jakarta
                                    </option>
                                    <option value="Bandung" {{ request('lokasi') == 'Bandung' ? 'selected' : '' }}>Bandung
                                    </option>
                                    <option value="Surabaya" {{ request('lokasi') == 'Surabaya' ? 'selected' : '' }}>
                                        Surabaya</option>
                                    <option value="Remote" {{ request('lokasi') == 'Remote' ? 'selected' : '' }}>Remote
                                    </option>
                                </select>
                            </div>

                            <!-- Bidang Filter -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Bidang</label>
                                <select name="bidang" class="form-select">
                                    <option value="">Semua Bidang</option>
                                    <option value="IT" {{ request('bidang') == 'IT' ? 'selected' : '' }}>IT</option>
                                    <option value="Teknologi" {{ request('bidang') == 'Teknologi' ? 'selected' : '' }}>
                                        Teknologi</option>
                                    <option value="Akuntansi" {{ request('bidang') == 'Akuntansi' ? 'selected' : '' }}>
                                        Akuntansi</option>
                                    <option value="Keuangan" {{ request('bidang') == 'Keuangan' ? 'selected' : '' }}>
                                        Keuangan</option>
                                    <option value="Marketing" {{ request('bidang') == 'Marketing' ? 'selected' : '' }}>
                                        Marketing</option>
                                    <option value="Design" {{ request('bidang') == 'Design' ? 'selected' : '' }}>Design
                                    </option>
                                    <option value="Administrasi"
                                        {{ request('bidang') == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                                </select>
                            </div>

                            <!-- Durasi Filter -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Durasi (bulan)</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="durasi[]" value="1-3"
                                        id="durasi1"
                                        {{ is_array(request('durasi')) && in_array('1-3', request('durasi')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="durasi1">1-3 bulan</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="durasi[]" value="3-6"
                                        id="durasi2"
                                        {{ is_array(request('durasi')) && in_array('3-6', request('durasi')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="durasi2">3-6 bulan</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="durasi[]" value="6+"
                                        id="durasi3"
                                        {{ is_array(request('durasi')) && in_array('6+', request('durasi')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="durasi3">Lebih dari 6 bulan</label>
                                </div>
                            </div>

                            <!-- Sorting -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Urutkan</label>
                                <select name="sort" class="form-select">
                                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>
                                        Terbaru</option>
                                    <option value="tanggal_mulai"
                                        {{ request('sort') == 'tanggal_mulai' ? 'selected' : '' }}>Tanggal Mulai</option>
                                    <option value="judul" {{ request('sort') == 'judul' ? 'selected' : '' }}>Judul
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <select name="order" class="form-select">
                                    <option value="desc" {{ request('order', 'desc') == 'desc' ? 'selected' : '' }}>
                                        Menurun</option>
                                    <option value="asc" {{ request('order', 'desc') == 'asc' ? 'selected' : '' }}>Menaik
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Search Results -->
            <div class="col-md-9">
                <!-- Recommended Section -->
                @if ($recommended->count() > 0)
                    <div class="mb-4">
                        <h4>Rekomendasi untuk Anda</h4>
                        <div class="row">
                            @foreach ($recommended as $rekomen)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 border-primary">
                                        <div class="card-header bg-primary text-white">Direkomendasikan</div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                @if ($rekomen->perusahaan->logo)
                                                    <img src="{{ asset('storage/' . $rekomen->perusahaan->logo) }}"
                                                        class="me-2" width="40" height="40" alt="Logo">
                                                @else
                                                    <div class="bg-light me-2 d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px;">
                                                        <i class="bi bi-building"></i>
                                                    </div>
                                                @endif
                                                <h5 class="card-title mb-0">{{ $rekomen->judul }}</h5>
                                            </div>
                                            <h6 class="card-subtitle mb-2 text-muted">
                                                {{ $rekomen->perusahaan->nama_perusahaan }}</h6>
                                            <p class="card-text small text-truncate">{{ $rekomen->deskripsi }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-info">{{ $rekomen->bidang }}</span>
                                                <a href="{{ route('mahasiswa.magang.show', $rekomen->id) }}"
                                                    class="btn btn-sm btn-outline-primary">Detail</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Search Results List -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>Hasil Pencarian</h4>
                    </div>

                    @if ($magang->count() > 0)
                        @foreach ($magang as $item)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="d-flex align-items-center mb-2">
                                                @if ($item->perusahaan->logo)
                                                    <img src="{{ asset('storage/' . $item->perusahaan->logo) }}"
                                                        class="me-3" width="60" height="60" alt="Logo">
                                                @else
                                                    <div class="bg-light me-3 d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px;">
                                                        <i class="bi bi-building fs-4"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h5 class="mb-1">{{ $item->judul }}</h5>
                                                    <h6 class="text-muted mb-1">{{ $item->perusahaan->nama_perusahaan }}
                                                    </h6>
                                                    <div>
                                                        <span class="badge bg-light text-dark me-1"><i
                                                                class="bi bi-geo-alt"></i> {{ $item->lokasi }}</span>
                                                        <span class="badge bg-light text-dark me-1"><i
                                                                class="bi bi-briefcase"></i> {{ $item->bidang }}</span>
                                                        <span class="badge bg-light text-dark"><i
                                                                class="bi bi-calendar"></i>
                                                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="card-text text-truncate">{{ $item->deskripsi }}</p>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                                            <a href="{{ route('mahasiswa.magang.show', $item->id) }}"
                                                class="btn btn-primary">Detail</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-white text-muted small">
                                    <i class="bi bi-clock"></i> Diposting {{ $item->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @endforeach

                        <!-- Pagination -->

                        @if ($magang->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $magang->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <p class="mb-0 text-center">Tidak ada lowongan magang yang ditemukan. Coba ubah filter
                                pencarian Anda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
