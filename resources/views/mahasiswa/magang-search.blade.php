@extends('mahasiswa.layouts.mahasiswa')

@section('title', 'Cari Magang')

@section('content')
<div class="container-fluid py-4">
    <!-- Search Bar Section - Updated Design -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="search-box bg-white p-4 rounded-4 shadow-sm">
                        <form class="row g-3" action="{{ route('mahasiswa.magang.search') }}" method="GET">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-search text-success"></i>
                                    </span>
                                    <input type="text" name="keyword" class="form-control border-start-0"
                                        placeholder="Posisi atau kata kunci" value="{{ request('keyword') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-geo-alt text-success"></i>
                                    </span>
                                    <input type="text" name="lokasi" class="form-control border-start-0"
                                        placeholder="Lokasi" value="{{ request('lokasi') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success w-100 rounded-3">
                                    <i class="bi bi-search me-2"></i>Cari Lowongan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Results Section -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Job Cards -->
            <div class="row">
                @if ($magang->count() > 0)
                    @foreach ($magang as $item)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <!-- Company Section at Top -->
                                <div class="card-header bg-white">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="company-logo me-2">
                                            @if ($item->perusahaan->logo)
                                                <img src="{{ asset('storage/' . $item->perusahaan->logo) }}" class="rounded" width="40" height="40" alt="Logo">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-building"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-center">
                                            <p class="mb-0 fw-bold text-truncate" style="max-width: 180px;">{{ $item->perusahaan->nama_perusahaan }}</p>
                                            @php
                                                $shortName = strtoupper(substr($item->perusahaan->nama_perusahaan, 0, 3));
                                            @endphp
                                            <span class="badge bg-light text-success">{{ $shortName }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-3">{{ $item->judul }}</h5>
                                    <p class="card-text small text-muted mb-3">{{ Str::limit($item->deskripsi, 100) }}</p>
                                    
                                    <div class="d-flex justify-content-center mb-2 align-items-center">
                                        <i class="bi bi-geo-alt text-muted me-2"></i>
                                        <span class="small text-muted">{{ $item->lokasi }}</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-center align-items-center mb-2">
                                        <span class="badge bg-light text-dark me-2">{{ $item->bidang }}</span>
                                        <span class="badge bg-light text-dark">
                                            <i class="bi bi-people"></i> 
                                            {{ rand(1, 20) }} posisi
                                        </span>
                                    </div>
                                    
                                    <p class="card-text small text-muted mb-0">
                                        {{ Str::limit($item->deskripsi_pendek ?? 'Magang ini mencari kandidat yang memiliki kemampuan dan semangat tinggi untuk belajar hal baru.', 100) }}
                                    </p>
                                </div>
                                
                                <div class="card-footer bg-white border-top-0 text-center">
                                    <small class="text-muted d-block mb-2">Dibuka hingga {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</small>
                                    <a href="{{ route('mahasiswa.magang.show', $item->id) }}" class="btn btn-outline-success btn-sm">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <!-- Pagination -->
                    @if ($magang->hasPages())
                        <div class="col-12">
                            <div class="d-flex justify-content-center mt-4">
                                {{ $magang->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                    
                @else
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <p class="mb-0">Tidak ada lowongan magang yang ditemukan. Coba ubah filter pencarian Anda.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Perusahaan -->
<div class="modal fade" id="companyDetailModal" tabindex="-1" aria-labelledby="companyDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="companyDetailModalLabel">Detail Perusahaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="company-info">
                    <div class="d-flex align-items-center mb-4">
                        <div class="company-logo me-3">
                            <img src="" id="modalCompanyLogo" class="rounded" width="80" height="80" alt="Logo Perusahaan">
                        </div>
                        <div>
                            <h4 id="modalCompanyName"></h4>
                            <p class="text-muted mb-0" id="modalCompanyLocation"></p>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Tentang Perusahaan</h5>
                            <p id="modalCompanyDescription"></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Informasi Kontak</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bi bi-envelope me-2"></i> <span id="modalCompanyEmail"></span></li>
                                <li class="mb-2"><i class="bi bi-telephone me-2"></i> <span id="modalCompanyPhone"></span></li>
                                <li class="mb-2"><i class="bi bi-globe me-2"></i> <span id="modalCompanyWebsite"></span></li>
                                <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> <span id="modalCompanyAddress"></span></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="lowongan-info">
                        <h5>Lowongan Magang Tersedia</h5>
                        <div id="modalCompanyInternships">
                            <!-- Lowongan magang akan ditampilkan di sini -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="#" id="viewAllPositionsBtn" class="btn btn-primary">Lihat Semua Posisi</a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Fungsi untuk menampilkan modal detail perusahaan
    $('.view-company-detail').on('click', function(e) {
        e.preventDefault();
        
        const perusahaanId = $(this).data('perusahaan-id');
        
        // Ajax request untuk mendapatkan data perusahaan
        $.ajax({
            url: `/api/perusahaan/${perusahaanId}`,
            type: 'GET',
            success: function(response) {
                // Isi data modal
                $('#modalCompanyName').text(response.nama_perusahaan);
                $('#modalCompanyLocation').text(response.lokasi);
                $('#modalCompanyDescription').text(response.deskripsi);
                $('#modalCompanyEmail').text(response.email);
                $('#modalCompanyPhone').text(response.telepon);
                $('#modalCompanyWebsite').text(response.website);
                $('#modalCompanyAddress').text(response.alamat);
                
                // Logo perusahaan
                if (response.logo) {
                    $('#modalCompanyLogo').attr('src', `/storage/${response.logo}`);
                } else {
                    $('#modalCompanyLogo').attr('src', '/img/default-company-logo.png');
                }
                
                // Set URL untuk tombol lihat semua posisi
                $('#viewAllPositionsBtn').attr('href', `/mahasiswa/perusahaan/${perusahaanId}`);
                
                // Tampilkan lowongan magang
                let internshipHTML = '';
                if (response.magang && response.magang.length > 0) {
                    response.magang.forEach(function(magang) {
                        internshipHTML += `
                            <div class="card mb-2">
                                <div class="card-body py-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">${magang.judul}</h6>
                                            <small class="text-muted">${magang.bidang} | ${magang.lokasi}</small>
                                        </div>
                                        <a href="/mahasiswa/magang/${magang.id}" class="btn btn-sm btn-outline-primary">Detail</a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    internshipHTML = '<p class="text-muted">Tidak ada lowongan magang saat ini.</p>';
                }
                $('#modalCompanyInternships').html(internshipHTML);
                
                // Tampilkan modal
                $('#companyDetailModal').modal('show');
            },
            error: function(xhr) {
                console.error('Error fetching company data:', xhr);
                alert('Gagal memuat data perusahaan. Silakan coba lagi.');
            }
        });
    });
});
</script>
@endpush


@endpush