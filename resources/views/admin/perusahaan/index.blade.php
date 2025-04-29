<!-- resources/views/admin/perusahaan/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Daftar Perusahaan')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Perusahaan</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <i class="fas fa-download me-1"></i> Export Data
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Perusahaan</th>
                                <th>Alamat</th>
                                <th>Bidang</th>
                                <th>Pendaftar</th>
                                <th>Website</th>
                                <th>Lowongan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($perusahaan as $key => $p)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                @if ($p->logo)
                                                    <img src="{{ asset('storage/' . $p->logo) }}" class="rounded"
                                                        width="40" height="40" alt="{{ $p->nama_perusahaan }}">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px;">
                                                        <span
                                                            class="text-primary fw-bold">{{ substr($p->nama_perusahaan, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-0 fw-medium">{{ $p->nama_perusahaan }}</p>
                                                <small class="text-muted">{{ $p->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($p->alamat, 30) }}</td>
                                    <td>{{ $p->bidang }}</td>
                                    <td>{{ $p->nama_pendaftar }}</td>
                                    <td>
                                        @if ($p->website)
                                            <a href="{{ $p->website }}" target="_blank" class="text-decoration-none">
                                                {{ Str::limit($p->website, 20) }} <i
                                                    class="fas fa-external-link-alt ms-1 small"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $p->magang_count ?? 0 }} Lowongan</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('admin.perusahaan.show', $p->id) }}">
                                                        <i class="fas fa-eye me-2"></i> Detail
                                                    </a></li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('admin.perusahaan.edit', $p->id) }}">
                                                        <i class="fas fa-edit me-2"></i> Edit
                                                    </a></li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('admin.perusahaan.magang', $p->id) }}">
                                                        <i class="fas fa-briefcase me-2"></i> Lowongan
                                                    </a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.perusahaan.destroy', $p->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus perusahaan ini?')">
                                                            <i class="fas fa-trash me-2"></i> Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Data Perusahaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.perusahaan.export') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="export_format" class="form-label">Format File</label>
                            <select class="form-select" id="export_format" name="format">
                                <option value="xlsx">Excel (XLSX)</option>
                                <option value="csv">CSV</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kolom yang Diekspor</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="columns[]" value="nama_perusahaan"
                                    id="col_nama" checked>
                                <label class="form-check-label" for="col_nama">Nama Perusahaan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="columns[]" value="alamat"
                                    id="col_alamat" checked>
                                <label class="form-check-label" for="col_alamat">Alamat</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="columns[]" value="bidang"
                                    id="col_bidang" checked>
                                <label class="form-check-label" for="col_bidang">Bidang</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="columns[]" value="nama_pendaftar"
                                    id="col_pendaftar" checked>
                                <label class="form-check-label" for="col_pendaftar">Nama Pendaftar</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="columns[]" value="website"
                                    id="col_website" checked>
                                <label class="form-check-label" for="col_website">Website</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="columns[]" value="email"
                                    id="col_email" checked>
                                <label class="form-check-label" for="col_email">Email</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="columns[]" value="jumlah_lowongan"
                                    id="col_lowongan" checked>
                                <label class="form-check-label" for="col_lowongan">Jumlah Lowongan</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bidang_filter" class="form-label">Filter Bidang</label>
                            <select class="form-select" id="bidang_filter" name="bidang_filter">
                                <option value="">Semua Bidang</option>
                                @foreach ($bidang_list as $bidang)
                                    <option value="{{ $bidang }}">{{ $bidang }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                },
                order: [
                    [1, 'asc']
                ]
            });
        });
    </script>
@endpush
