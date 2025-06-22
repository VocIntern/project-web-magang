@extends('admin.layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon"><i class="fas fa-users"></i></div>
            <div class="number">{{ $totalMahasiswa ?? 0 }}</div>
            <div class="label">Total Mahasiswa</div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fas fa-building"></i></div>
            <div class="number">{{ $totalPerusahaan ?? 0 }}</div>
            <div class="label">Total Perusahaan</div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fas fa-briefcase"></i></div>
            <div class="number">{{ $totalMagang ?? 0 }}</div>
            <div class="label">Lowongan Aktif</div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fas fa-file-alt"></i></div>
            <div class="number">{{ $totalPendaftaranMagang ?? 0 }}</div>
            <div class="label">Total Pendaftaran</div>
        </div>
    </div>

    {{-- Statistik Pendaftaran --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon"><i class="fas fa-clock" style="color: var(--warning-color);"></i></div>
            <div class="number">{{ $menunggu ?? 0 }}</div>
            <div class="label">Menunggu Review</div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fas fa-check-circle" style="color: var(--success-color);"></i></div>
            <div class="number">{{ $diterima ?? 0 }}</div>
            <div class="label">Diterima</div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fas fa-times-circle" style="color: var(--danger-color);"></i></div>
            <div class="number">{{ $ditolak ?? 0 }}</div>
            <div class="label">Ditolak</div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fas fa-percentage" style="color: var(--info-color);"></i></div>
            <div class="number">
                {{-- Pastikan variabel $totalPendaftaranMagang ada dan tidak nol --}}
                @php
                    $totalPendaftaran = $totalPendaftaranMagang ?? 0;
                    $diterimaCount = $diterima ?? 0;
                    $acceptanceRate = $totalPendaftaran > 0 ? round(($diterimaCount / $totalPendaftaran) * 100) : 0;
                @endphp
                {{ $acceptanceRate }}%
            </div>
            <div class="label">Tingkat Penerimaan</div>
        </div>
    </div>

    <div class="content-grid">
        <div class="recent-section">
            <h2><i class="fas fa-file-alt"></i> Pendaftaran Terbaru</h2>
            @forelse($recentApplications as $application)
                <div class="application-item">
                    {{-- <div class="application-avatar">
                        @if (!empty($application['foto']))
                            <img src="{{ asset('storage/' . $application['foto']) }}" alt="Avatar" class="rounded-circle">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div> --}}
                    <div class="application-info">
                        <div class="name">{{ $application['mahasiswa_nama'] }}</div>
                        <div class="details">{{ $application['posisi'] }} - {{ $application['perusahaan_nama'] }}
                        </div>
                        <div class="details">{{ \Carbon\Carbon::parse($application['tanggal_apply'])->format('d M Y') }}
                        </div>
                    </div>
                    <div class="application-status status-{{ strtolower($application['status']) }}">
                        {{ ucfirst($application['status']) }}
                    </div>
                </div>
            @empty
                <div class="application-item">
                    <div class="application-info">
                        <div class="name">Belum ada pendaftaran terbaru</div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="recent-section">
            <h2><i class="fas fa-clock"></i> Aktivitas Terbaru</h2>
            {{-- Controller Anda sudah menyediakan $recentActivities --}}
            @forelse($recentActivities as $activity)
                <div class="activity-item">
                    <div class="activity-icon activity-{{ $activity['color'] }}">
                        <i class="fas fa-{{ $activity['icon'] }}"></i>
                    </div>
                    <div class="activity-info">
                        <div class="activity-message">{{ $activity['message'] }}</div>
                        <div class="activity-time">{{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <div class="activity-item">
                    <div class="activity-info">
                        <div class="activity-message">Belum ada aktivitas terbaru</div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Script spesifik untuk halaman dashboard bisa ditaruh di sini.
        // Contoh: AJAX call untuk refresh data secara real-time.

        // Fungsi untuk memuat ulang statistik
        function refreshStats() {
            fetch('{{ route('admin.dashboard.stats') }}')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('.number.total-mahasiswa').textContent = data.totalMahasiswa;
                    document.querySelector('.number.total-perusahaan').textContent = data.totalPerusahaan;
                    // ... update elemen lainnya
                    console.log('Dashboard stats refreshed.');
                })
                .catch(error => console.error('Error refreshing stats:', error));
        }

        // Auto refresh data every 60 seconds
        setInterval(() => {
            console.log('Refreshing dashboard data...');
            // Anda bisa memanggil fungsi refresh di sini
            // refreshStats(); 
        }, 60000);
    </script>
@endpush
