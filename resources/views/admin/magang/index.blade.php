@extends('admin.layouts.admin')

@section('title', 'Kelola Lowongan Magang')

@section('header-title')
    <h1 class="mb-0">Manajemen Lowongan</h1>
    <small class="text-muted">Kelola semua lowongan magang yang tersedia.</small>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card modern-card">
            <div class="card-header">
                <div class="card-toolbar">
                    <form method="GET" action="{{ route('admin.magang.index') }}" class="search-form">
                        <div class="search-input-group">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="search" class="form-control" placeholder="Cari Data Magang..."
                                value="{{ request('search') }}">
                        </div>
                    </form>
                    <div class="card-actions">
                        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="fas fa-download fa-sm"></i> Export
                        </button>
                        <a href="{{ route('admin.magang.create') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-plus fa-sm"></i> Tambah Data Magang
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}</div>
                @endif
                {{-- Tabel Data --}}
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Lowongan</th>
                                <th>Perusahaan</th>
                                <th>Lokasi</th>
                                <th>Status</th> {{-- Kolom Tipe dihapus untuk sementara --}}
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($magangs as $index => $magang)
                                <tr>
                                    <td>{{ $magangs->firstItem() + $index }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $magang->judul }}</div>
                                        {{-- Menggunakan tanggal_mulai dan tanggal_selesai --}}
                                        <small class="text-muted">Periode:
                                            {{ \Carbon\Carbon::parse($magang->tanggal_mulai)->isoFormat('D MMM Y') }} -
                                            {{ \Carbon\Carbon::parse($magang->tanggal_selesai)->isoFormat('D MMM Y') }}
                                        </small>
                                    </td>
                                    <td>{{ $magang->perusahaan->nama_perusahaan ?? 'N/A' }}</td>
                                    <td>{{ $magang->lokasi }}</td>
                                    <td>
                                        {{-- LOGIKA STATUS DIPERBAIKI --}}
                                        @if ($magang->status_aktif)
                                            <span class="badge bg-success-subtle text-success-emphasis">Aktif</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger-emphasis">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.magang.edit', $magang->id) }}" class="action-icon"
                                                title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" class="action-icon-danger" title="Hapus"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-id="{{ $magang->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
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

                {{-- Pagination --}}
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
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data magang ini?</p>
                    <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- Pastikan script ini ada di paling bawah file --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteModal = document.getElementById('deleteModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var magangId = button.getAttribute('data-id');
                    var form = document.getElementById('deleteForm');

                    // Ini bagian paling penting: membuat URL yang benar
                    var actionUrl = "{{ url('admin/magang') }}/" + magangId;

                    form.setAttribute('action', actionUrl);
                });
            }
        });
    </script>
@endpush
