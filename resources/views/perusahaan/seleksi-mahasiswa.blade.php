@extends('perusahaan.layouts.perusahaan-layouts')

@section('title', 'Seleksi Pelamar Magang')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold text-success">Daftar Pelamar Magang</h6>
        </div>
        <div class="card-body">
            @if ($pendaftarans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Mahasiswa</th>
                                <th>Lowongan Dilamar</th>
                                <th>Tanggal Melamar</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftarans as $pendaftaran)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{-- Bisa ditambahkan foto jika ada --}}
                                            <div class="ms-2">
                                                <div class="fw-bold">{{ $pendaftaran->mahasiswa->nama }}</div>
                                                <div class="text-muted small">{{ $pendaftaran->mahasiswa->nim ?? 'NIM tidak ada' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $pendaftaran->magang->judul }}</td>
                                    <td>{{ $pendaftaran->created_at->format('d F Y') }}</td>
                                    <td class="text-center">
                                        @if($pendaftaran->status == 'pending')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($pendaftaran->status == 'diterima')
                                            <span class="badge bg-success">Diterima</span>
                                        @elseif($pendaftaran->status == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Navigasi Paginasi --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $pendaftarans->links() }}
                </div>
            @else
                <div class="text-center p-5">
                    <i class="fas fa-user-slash fa-3x text-gray-400 mb-3"></i>
                    <p class="mb-0">Belum ada mahasiswa yang melamar ke lowongan Anda.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection