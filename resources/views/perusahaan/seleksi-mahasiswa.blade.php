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
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>Lowongan Dilamar</th>
                                    <th>Tanggal Melamar</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 200px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($pendaftarans as $pendaftaran)
                                    <tr>
                                        <td>
                                            <div class="align-items-center">
                                                <div>
                                                    <div class="tes">{{ $pendaftaran->mahasiswa->nama }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $pendaftaran->magang->judul }}</td>
                                        <td>{{ $pendaftaran->created_at->format('d F Y') }}</td>
                                        <td class="text-center status">
                                            @if ($pendaftaran->status == 'menunggu')
                                                <span class="badge text-warning">Menunggu</span>
                                            @elseif($pendaftaran->status == 'diterima')
                                                <span class="badge text-success">Diterima</span>
                                            @elseif($pendaftaran->status == 'ditolak')
                                                <span class="badge text-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ asset('storage/' . $pendaftaran->cv) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary" style="margin-right: 5px;"
                                                title="Unduh CV">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                style="margin-right: 5px;" title="Terima Lamaran"
                                                onclick="updateStatus('{{ $pendaftaran->id }}', 'diterima', '{{ $pendaftaran->mahasiswa->nama }}')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                title="Tolak Lamaran"
                                                onclick="updateStatus('{{ $pendaftaran->id }}', 'ditolak', '{{ $pendaftaran->mahasiswa->nama }}')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- Navigasi Paginasi --}}
                    <div class="d-flex justify-content-end mt-3">
                        {{ $pendaftarans->links('vendor.pagination.bootstrap-5') }}
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

    <form id="updateStatusForm" method="POST" style="display: none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" id="statusInput">
    </form>
@endsection

@push('scripts')
    {{-- 1. Muat library SweetAlert2 dari CDN (PENTING: letakkan sebelum script-mu) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- 2. Script kustom untuk menangani update status --}}
    <script>
        function updateStatus(id, status, nama) {
            const statusText = status === 'diterima' ? 'MENERIMA' : 'MENOLAK';
            const confirmText = `Apakah Anda yakin ingin ${statusText} lamaran dari ${nama}?`;

            Swal.fire({
                title: 'Konfirmasi Tindakan',
                text: confirmText,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745', // Warna hijau untuk konfirmasi
                cancelButtonColor: '#dc3545', // Warna merah untuk batal
                confirmButtonText: `Ya, ${statusText}!`,
                cancelButtonText: 'Batal'
            }).then((result) => {
                // Cek jika pengguna menekan tombol konfirmasi ("Ya")
                if (result.isConfirmed) {
                    const form = document.getElementById('updateStatusForm');
                    const statusInput = document.getElementById('statusInput');

                    // Atur action form dan nilai status
                    form.action = `/perusahaan/seleksi-mahasiswa/${id}/status`;
                    statusInput.value = status;

                    // Kirim form
                    form.submit();
                }
            });
        }
    </script>
@endpush
