@extends('perusahaan.layouts.perusahaan-layouts')

@section('title', 'Daftar Lowongan Magang')

@section('header-title')
    <h1 class="mb-0">Daftar Lowongan Magang</h1>
    <small class="text-muted">Kelola semua lowongan magang yang Anda publikasikan.</small>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-success">Lowongan Magang Anda</h6>
                <a href="{{ route('perusahaan.lowongan.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Buat Lowongan Baru
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Judul Lowongan</th>
                                <th>Bidang</th>
                                <th>Lokasi</th>
                                <th class="text-center">Kuota</th>
                                <th class="text-center">Pelamar</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lowongans as $lowongan)
                                <tr>
                                    <td>{{ $lowongan->judul }}</td>
                                    <td>{{ $lowongan->bidang }}</td>
                                    <td>{{ $lowongan->lokasi }}</td>
                                    <td class="text-center">{{ $lowongan->kuota }}</td>
                                    <td class="text-center">{{ $lowongan->pendaftarans()->count() }}</td>
                                    <td class="text-center">
                                        @if (now()->between($lowongan->tanggal_mulai, $lowongan->tanggal_selesai))
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('perusahaan.lowongan.edit', $lowongan->id) }}"
                                                class="action-icon" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            {{-- TOMBOL INI SEKARANG MEMICU MODAL --}}
                                            <button type="button" class="action-icon-danger" title="Hapus"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-id="{{ $lowongan->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center p-4">Anda belum memiliki lowongan magang.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    {{ $lowongans->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Lowongan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus lowongan ini secara permanen? Tindakan ini tidak dapat dibatalkan.
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

{{-- JAVASCRIPT UNTUK MODAL DITAMBAHKAN DI SINI --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteModal = document.getElementById('deleteModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var lowonganId = button.getAttribute('data-id');
                    var form = document.getElementById('deleteForm');
                    var actionUrl = "/perusahaan/lowongan/" + lowonganId;
                    form.setAttribute('action', actionUrl);
                });
            }
        });
    </script>
@endpush
