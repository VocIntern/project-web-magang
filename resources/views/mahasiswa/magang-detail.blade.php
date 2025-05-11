@extends('mahasiswa.layouts.mahasiswa')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('mahasiswa.magang.search') }}">Lowongan Magang</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $magang->judul }}</li>
        </ol>
    </nav>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Main Content -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        @if($magang->perusahaan->logo)
                        <img src="{{ asset('storage/' . $magang->perusahaan->logo) }}" class="me-4" width="80" height="80" alt="Logo Perusahaan">
                        @else
                        <div class="bg-light me-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-building fs-3"></i>
                        </div>
                        @endif
                        <div>
                            <h2 class="mb-1">{{ $magang->judul }}</h2>
                            <h5 class="text-muted mb-2">{{ $magang->perusahaan->nama_perusahaan }}</h5>
                            <div>
                                <span class="badge bg-light text-dark me-2 mb-1"><i class="bi bi-geo-alt"></i> {{ $magang->lokasi }}</span>
                                <span class="badge bg-light text-dark me-2 mb-1"><i class="bi bi-briefcase"></i> {{ $magang->bidang }}</span>
                                <span class="badge bg-light text-dark mb-1"><i class="bi bi-people"></i> Kuota: {{ $magang->kuota }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="card mb-3 bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-1"><i class="bi bi-calendar-event"></i> Periode Magang</h6>
                                        <p class="mb-0">{{ \Carbon\Carbon::parse($magang->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($magang->tanggal_selesai)->format('d M Y') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-1"><i class="bi bi-clock-history"></i> Durasi</h6>
                                        <p class="mb-0">{{ \Carbon\Carbon::parse($magang->tanggal_mulai)->diffInMonths($magang->tanggal_selesai) }} bulan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="mb-3">Deskripsi Magang</h5>
                        <div class="bg-light p-3 rounded">
                            <p>{!! nl2br(e($magang->deskripsi)) !!}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="mb-3">Tentang Perusahaan</h5>
                        <div class="bg-light p-3 rounded">
                            <p>{!! nl2br(e($magang->perusahaan->deskripsi ?? 'Informasi perusahaan tidak tersedia.')) !!}</p>
                            
                            @if($magang->perusahaan->website)
                            <p class="mb-0">
                                <strong>Website:</strong> 
                                <a href="{{ $magang->perusahaan->website }}" target="_blank">{{ $magang->perusahaan->website }}</a>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-grid gap-2">
                        @if($hasApplied)
                            <button class="btn btn-secondary" disabled>Anda Sudah Melamar</button>
                        @else
                            <a href="{{ route('mahasiswa.magang.apply.form', $magang->id) }}" class="btn btn-primary">Lamar Sekarang</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Similar Internships -->
            @if($similarMagang->count() > 0)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Magang Serupa</h5>
                </div>
                <div class="card-body">
                    @foreach($similarMagang as $similar)
                    <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <h6 class="mb-1">
                            <a href="{{ route('mahasiswa.magang.show', $similar->id) }}" class="text-decoration-none">{{ $similar->judul }}</a>
                        </h6>
                        <p class="mb-1 text-muted small">{{ $similar->perusahaan->nama_perusahaan }}</p>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-light text-dark me-2"><i class="bi bi-geo-alt"></i> {{ $similar->lokasi }}</span>
                            <span class="badge bg-light text-dark"><i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($similar->tanggal_mulai)->format('d M Y') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Company Info Card -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informasi Kontak</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @if($magang->perusahaan->logo)
                        <img src="{{ asset('storage/' . $magang->perusahaan->logo) }}" class="me-3" width="50" height="50" alt="Logo">
                        @else
                        <div class="bg-light me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-building"></i>
                        </div>
                        @endif
                        <div>
                            <h6 class="mb-0">{{ $magang->perusahaan->nama_perusahaan }}</h6>
                            <span class="badge bg-light text-dark">{{ $magang->perusahaan->bidang }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <p class="mb-0"><i class="bi bi-geo-alt me-2"></i> {{ $magang->perusahaan->alamat }}</p>
                    </div>
                    
                    @if($magang->perusahaan->website)
                    <div class="mb-3">
                        <p class="mb-0"><i class="bi bi-globe me-2"></i> <a href="{{ $magang->perusahaan->website }}" target="_blank">Website</a></p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Application Info Card -->
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Info Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Status</span>
                            <span class="badge bg-success">Dibuka</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Batas Pendaftaran</span>
                            <span>{{ \Carbon\Carbon::parse($magang->tanggal_mulai)->subDays(7)->format('d M Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Kuota</span>
                            <span>{{ $magang->kuota }} orang</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-grid gap-2">
                        @if($hasApplied)
                            <button class="btn btn-secondary" disabled>Anda Sudah Melamar</button>
                        @else
                            <a href="{{ route('mahasiswa.magang.apply.form', $magang->id) }}" class="btn btn-primary">Lamar Sekarang</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection