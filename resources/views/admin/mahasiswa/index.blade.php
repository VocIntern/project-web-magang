@extends('admin.layouts.admin')

@section('title', 'Daftar Mahasiswa')

@section('content')
    <div class="container-fluid">
        <div class="card modern-card">
            <div class="card-header">
                <div class="card-toolbar">
                    <form method="GET" action="{{ route('admin.mahasiswa.index') }}" class="search-form">
                        <div class="search-input-group">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="search" class="form-control" placeholder="Cari mahasiswa..."
                                value="{{ request('search') }}">
                        </div>
                    </form>
                    <div class="card-actions">
                        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="fas fa-download fa-sm"></i> Export
                        </button>
                        <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-plus fa-sm"></i> Tambah Mahasiswa
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
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Semester</th>
                                <th>Email</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mahasiswas as $index => $mahasiswa)
                                <tr>
                                    <td>{{ $mahasiswas->firstItem() + $index }}</td>
                                    <td>{{ $mahasiswa->nim }}</td>
                                    <td>{{ $mahasiswa->nama }}</td>
                                    <td>{{ $mahasiswa->jurusan }}</td>
                                    <td>{{ $mahasiswa->semester }}</td>
                                    <td>{{ $mahasiswa->user->email ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.mahasiswa.edit', $mahasiswa->id) }}"
                                                class="action-icon" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" class="action-icon-danger" title="Hapus"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-id="{{ $mahasiswa->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
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

                @if ($mahasiswas->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $mahasiswas->withQueryString()->links('vendor.pagination.bootstrap-5') }}
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
                    <form action="{{ route('admin.mahasiswa.export') }}" method="POST">
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
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus lowongan ini? Tindakan ini tidak dapat dibatalkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteModal = document.getElementById('deleteModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var mahasiswaId = button.getAttribute('data-id');
                    var form = document.getElementById('deleteForm');

                    // Ini bagian paling penting: membuat URL yang benar
                    var actionUrl = "{{ url('admin/mahasiswa') }}/" + mahasiswaId;

                    form.setAttribute('action', actionUrl);
                });
            }
        });
    </script>
@endpush
