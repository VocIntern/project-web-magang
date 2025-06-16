@extends('perusahaan.layouts.perusahaan-layouts')

@section('title', 'Dashboard Perusahaan')

@section('content')
    <div class="container-fluid">

        {{-- Kartu Statistik --}}
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-success text-uppercase mb-1">Total Lowongan</div>
                                <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalLowongan }}</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-success text-uppercase mb-1">Lowongan Aktif</div>
                                <div class="h5 mb-0 fw-bold text-gray-800">{{ $magangAktif }}</div>
                            </div>
 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-success text-uppercase mb-1">Total Pelamar</div>
                                <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalPelamar }}</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Kolom Kiri - Lowongan Terbaru --}}
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold text-success">Lowongan Terbaru Anda</h6>
                    </div>
                    <div class="card-body">
                        @if ($lowonganTerbaru->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Judul Lowongan</th>
                                            <th>Bidang</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lowonganTerbaru as $lowongan)
                                            <tr>
                                                <td>{{ $lowongan->judul }}</td>
                                                <td>{{ $lowongan->bidang }}</td>
                                                <td>
                                                    @if (now()->between($lowongan->tanggal_mulai, $lowongan->tanggal_selesai))
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-secondary">Nonaktif</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center p-4">
                                <i class="fas fa-box-open fa-3x text-gray-400 mb-3"></i>
                                <p>Anda belum membuat lowongan magang.</p>
                                <a href="{{ route('perusahaan.lowongan.create') }}" class="btn btn-success">Buat Lowongan
                                    Pertama</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan - Aksi Cepat & Pelamar Terbaru --}}
            <div class="col-lg-4">
                {{-- Aksi Cepat --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold text-success">Aksi Cepat</h6>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('perusahaan.lowongan.create') }}"
                            class="btn btn-success btn-icon-split d-block mb-2">
                            <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                            <span class="text">Buat Lowongan Baru</span>
                        </a>
                        <a href="{{ route('perusahaan.seleksi.index') }}"
                            class="btn btn-outline-success btn-icon-split d-block">
                            <span class="icon text-white-50"></span>
                            <span class="text">Lihat Semua Pelamar</span>
                        </a>
                    </div>
                </div>

                {{-- Pelamar Terbaru --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold text-success">Pelamar Terbaru</h6>
                    </div>
                    <div class="card-body">
                        @if ($pelamarTerbaru->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach ($pelamarTerbaru as $pelamar)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $pelamar->mahasiswa->nama }}</h6>
                                            <small class="text-muted">Melamar untuk:
                                                {{ Str::limit($pelamar->magang->judul, 25) }}</small>
                                        </div>
                                        <span class="badge bg-warning text-dark">Baru</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center p-3">
                                <p class="mb-0">Belum ada pelamar baru.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
