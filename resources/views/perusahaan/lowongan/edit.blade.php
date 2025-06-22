@extends('perusahaan.layouts.perusahaan-layouts')

@section('title', 'Edit Lowongan: ' . $magang->judul)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/register_profile.css') }}">
    <style>
        .profile-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            padding: 15px;
            margin-bottom: 2rem;
        }

        .profile-progress-container {
            position: relative;
            display: grid;
            place-items: center;
        }

        /* CSS untuk Radial Progress Bar yang Elegan */
        .profile-progress-circle {
            width: 105px;
            height: 105px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            /* Menggunakan variable CSS untuk nilai progres dan warna */
            background: conic-gradient(var(--progress-color, #28a745) calc(var(--progress-value) * 1%), #e9ecef 0);
            transition: background 0.5s;
        }

        /* Lingkaran dalam untuk efek "donat" */
        .profile-progress-circle::before {
            content: '';
            width: calc(100% - 20px);
            /* Ketebalan ring 10px */
            height: calc(100% - 20px);
            background: #fff;
            border-radius: 50%;
        }

        /* Teks persentase di tengah lingkaran */
        .progress-text {
            position: absolute;
            font-size: 2rem;
            font-weight: 600;
            color: #495057;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- KOLOM KIRI: FORM EDIT --}}
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 fw-bold text-success">Edit Formulir Lowongan Magang</h6>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('perusahaan.lowongan.update', $magang->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul Lowongan <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="judul" name="judul"
                                            value="{{ old('judul', $magang->judul) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bidang" class="form-label">Bidang <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="bidang" name="bidang"
                                            value="{{ old('bidang', $magang->bidang) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Pekerjaan <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $magang->deskripsi) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="lokasi" class="form-label">Lokasi <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="lokasi" name="lokasi"
                                            value="{{ old('lokasi', $magang->lokasi) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kuota" class="form-label">Kuota Peserta <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="kuota" name="kuota"
                                            value="{{ old('kuota', $magang->kuota) }}" min="1" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                            value="{{ old('tanggal_mulai', $magang->tanggal_mulai) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="tanggal_selesai"
                                            name="tanggal_selesai"
                                            value="{{ old('tanggal_selesai', $magang->tanggal_selesai) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('perusahaan.lowongan.index') }}" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: STATISTIK KELENGKAPAN LOWONGAN --}}
            <div class="col-lg-4">
                <div class="profile-card text-center">
                    
                        <h5 class="mb-3">Kelengkapan Lowongan</h5>

                        @php
                            // Definisikan field yang relevan untuk lowongan magang
                            $fields = [
                                'judul',
                                'bidang',
                                'deskripsi',
                                'lokasi',
                                'kuota',
                                'tanggal_mulai',
                                'tanggal_selesai',
                            ];
                            $filledFields = 0;
                            // Lakukan perulangan dan cek setiap field pada objek $magang
                            foreach ($fields as $field) {
                                if (!empty($magang->$field)) {
                                    $filledFields++;
                                }
                            }
                            $completion = round(($filledFields / count($fields)) * 100);
                        @endphp

                        <div class="profile-progress-container mb-3"
                            style="--progress-value: {{ $completion }}; --progress-color: #198754;">
                            <div class="profile-progress-circle"></div>
                            <div class="progress-text">{{ $completion }}<small>%</small></div>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Lowongan yang informatif akan menarik lebih banyak pelamar berkualitas.
                        </small>

                        <hr class="my-4">

                        {{-- Ringkasan Lowongan --}}
                        <div class="small text-start">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>Lokasi:</span>
                                <span class="fw-semibold">{{ $magang->lokasi ?? 'Belum diisi' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted"><i class="fas fa-users me-2"></i>Kuota:</span>
                                <span class="fw-semibold">{{ $magang->kuota ?? '0' }} Peserta</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted"><i class="fas fa-calendar-alt me-2"></i>Periode:</span>
                                <span
                                    class="fw-semibold">{{ \Carbon\Carbon::parse($magang->tanggal_mulai)->format('d M Y') }}</span>
                            </div>
                        </div>

                        {{-- Tombol Aksi Tambahan --}}
                        {{-- <div class="d-grid mt-4">
                        <a href="{{ route('perusahaan.lowongan.index') }}" class="btn btn-outline-success">
                            <i class="fas fa-list-alt me-2"></i>Lihat Semua Lowongan
                        </a>
                    </div> --}}

                    </div>
                </div>
            </div>
        </div>
    @endsection
