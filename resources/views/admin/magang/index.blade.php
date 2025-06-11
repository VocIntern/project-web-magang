@extends('admin.layouts.admin')

@section('title', 'Kelola Lowongan Magang')

@section('content')
    <div class="container-fluid">
        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card modern-card">
            <div class="card-header">
                <div class="card-toolbar">
                    <h4 class="card-title mb-0">Data Lowongan Magang</h4>
                    <div class="card-actions">
                        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="fas fa-download fa-sm"></i> Export
                        </button>
                        <a href="{{ route('admin.magang.create') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-plus fa-sm"></i> Tambah Lowongan
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col">
                        <form method="GET" action="{{ route('admin.magang.index') }}" class="search-form">
                            <div class="search-input-group">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari berdasarkan judul, perusahaan, lokasi..."
                                    value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table modern-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Lowongan</th>
                                    <th>Perusahaan</th>
                                    <th>Lokasi</th>
                                    <th>Tipe</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($magangs as $index => $magang)
                                    <tr>
                                        <td>{{ $magangs->firstItem() + $index }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $magang->judul }}</div>
                                            <small class="text-muted">Dibuka:
                                                {{ \Carbon\Carbon::parse($magang->tanggal_buka)->isoFormat('D MMM Y') }} -
                                                {{ \Carbon\Carbon::parse($magang->tanggal_tutup)->isoFormat('D MMM Y') }}</small>
                                        </td>
                                        <td>{{ $magang->perusahaan->nama_perusahaan ?? 'N/A' }}</td>
                                        <td>{{ $magang->lokasi }}</td>
                                        <td>
                                            @php
                                                $tipeClass = '';
                                                switch ($magang->tipe) {
                                                    case 'Full-time':
                                                        $tipeClass =
                                                            'bg-outline-success-subtle text-outline-success-emphasis';
                                                        break;
                                                    case 'Part-time':
                                                        $tipeClass = 'bg-info-subtle text-info-emphasis';
                                                        break;
                                                    case 'Remote':
                                                        $tipeClass = 'bg-secondary-subtle text-secondary-emphasis';
                                                        break;
                                                }
                                            @endphp
                                            <span class="badge {{ $tipeClass }}">{{ $magang->tipe }}</span>
                                        </td>
                                        <td>
                                            @if ($magang->status == 'Dibuka')
                                                <span
                                                    class="badge bg-success-subtle text-success-emphasis">{{ $magang->status }}</span>
                                            @else
                                                <span
                                                    class="badge bg-danger-subtle text-danger-emphasis">{{ $magang->status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.magang.edit', $magang->id) }}" class="action-icon"
                                                    title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <form action="{{ route('admin.magang.destroy', $magang->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-icon-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>


                <!-- Pagination -->
                @if ($magangs->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $magangs->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Data Mahasiswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Data mahasiswa dalam format CSV akan diunduh sesuai dengan filter pencarian yang aktif.</p>
                    <form action="{{ route('admin.magang.export') }}" method="POST">
                        @csrf
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-outline-success">Export Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
