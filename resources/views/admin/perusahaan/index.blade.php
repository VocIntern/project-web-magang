@extends('admin.layouts.admin')

@section('title', 'Daftar Perusahaan')

@section('content')
    <div class="container-fluid">
        <div class="card modern-card">
            <div class="card-header">
                <div class="card-toolbar">
                    <form method="GET" action="{{ route('admin.perusahaan.index') }}" class="search-form">
                        <div class="search-input-group">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="search" class="form-control" placeholder="Cari perusahaan..."
                                value="{{ request('search') }}">
                        </div>
                    </form>
                    <div class="card-actions">
                        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="fas fa-download fa-sm"></i> Export
                        </button>
                        <a href="{{ route('admin.perusahaan.create') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-plus fa-sm"></i> Tambah Perusahaan
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table modern-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Perusahaan</th>
                                <th>Bidang</th>
                                <th>Alamat</th>
                                <th class="text-center">Lowongan Aktif</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($perusahaan as $key => $p)
                                <tr>
                                    <td>{{ $perusahaan->firstItem() + $key }}</td>
                                    <td>
                                        <p class="mb-0 fw-bold">{{ $p->nama_perusahaan }}</p>
                                        <small class="text-muted">{{ $p->user->email ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{ $p->bidang }}</td>
                                    <td>{{ Str::limit($p->alamat, 35) }}</td>
                                    <td class="text-center"><span
                                            class="badge bg-success rounded-pill">{{ $p->magang_count }}</span></td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.perusahaan.edit', $p->id) }}" class="action-icon"
                                                title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('admin.perusahaan.destroy', $p->id) }}" method="POST"
                                                class="d-inline"
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
                                    <td colspan="6" class="text-center">Tidak ada data ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($perusahaan->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $perusahaan->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Data Perusahaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Data perusahaan dalam format CSV akan diunduh sesuai dengan filter pencarian yang aktif.</p>
                    <form action="{{ route('admin.perusahaan.export') }}" method="POST">
                        @csrf
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Export Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
