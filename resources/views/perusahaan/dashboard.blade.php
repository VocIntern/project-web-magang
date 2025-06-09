@extends('perusahaan.layouts.perusahaan-layouts')

@section('title', 'Dashboard Perusahaan')

@section('content')
    <div class="main-content">

        <div class="content-area">
            <h1>Dashboard</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Statistik Dashboard -->
            <div class="stats-cards">
                <div class="stat-card">
                    <span class="stat-number">{{ $totalLowongan }}</span>
                    <span class="stat-label">Lowongan Magang</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">{{ $totalPelamar }}</span>
                    <span class="stat-label">Total Pelamar</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">{{ $magangAktif }}</span>
                    <span class="stat-label">Magang Aktif</span>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="section-card">
                <h2>Aksi Cepat</h2>
                <div class="quick-actions">
                    <a href="{{ route('perusahaan.lowongan.create') }}" class="btn btn-primary">
                        <i class="material-icons">add</i>
                        Buat Lowongan Baru
                    </a>
                    <a href="{{ route('perusahaan.seleksi-mahasiswa') }}" class="btn btn-secondary">
                        <i class="material-icons">people</i>
                        Lihat Pelamar
                    </a>
                    <a href="{{ route('perusahaan.profil') }}" class="btn btn-secondary">
                        <i class="material-icons">settings</i>
                        Edit Profil
                    </a>
                </div>
            </div>

            <!-- Lowongan Terbaru -->
            <div class="section-card">
                <h2>Lowongan Terbaru</h2>
                @if ($lowonganTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Judul Lowongan</th>
                                    <th>Bidang</th>
                                    <th>Lokasi</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowonganTerbaru as $lowongan)
                                    <tr>
                                        <td>{{ $lowongan->judul }}</td>
                                        <td>{{ $lowongan->bidang }}</td>
                                        <td>{{ $lowongan->lokasi }}</td>
                                        <td>{{ $lowongan->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if ($lowongan->tanggal_mulai <= now() && $lowongan->tanggal_selesai >= now())
                                                <span class="status-badge active">Aktif</span>
                                            @else
                                                <span class="status-badge inactive">Nonaktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="section-footer">
                        <a href="{{ route('perusahaan.lowongan') }}" class="btn btn-outline">Lihat Semua Lowongan</a>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="material-icons">work_off</i>
                        <p>Belum ada lowongan magang</p>
                        <a href="{{ route('perusahaan.lowongan.create') }}" class="btn btn-primary">Buat Lowongan
                            Pertama</a>
                    </div>
                @endif
            </div>

            <!-- Pelamar Terbaru -->
            <div class="section-card">
                <h2>Pelamar Terbaru</h2>
                @if ($pelamarTerbaru->count() > 0)
                    <div class="applicant-list">
                        @foreach ($pelamarTerbaru as $pelamar)
                            <div class="applicant-item">
                                <div class="applicant-info">
                                    <div class="applicant-avatar">
                                        {{ strtoupper(substr($pelamar->mahasiswa->nama, 0, 2)) }}
                                    </div>
                                    <div class="applicant-details">
                                        <h4>{{ $pelamar->mahasiswa->nama }}</h4>
                                        <p>{{ $pelamar->mahasiswa->jurusan }}</p>
                                        <small>Melamar untuk: {{ $pelamar->magang->judul }}</small>
                                    </div>
                                </div>
                                <div class="applicant-actions">
                                    <span class="status-badge pending">Menunggu Review</span>
                                    <button class="btn btn-small btn-primary"
                                        onclick="reviewApplicant({{ $pelamar->id }})">
                                        Review
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="section-footer">
                        <a href="{{ route('perusahaan.seleksi-mahasiswa') }}" class="btn btn-outline">Lihat Semua
                            Pelamar</a>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="material-icons">people_outline</i>
                        <p>Belum ada pelamar baru</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function reviewApplicant(id) {
            window.location.href = `/perusahaan/pelamar/${id}`;
        }
    </script>
@endsection
