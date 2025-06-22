@extends('perusahaan.layouts.perusahaan-layouts')

@section('title', 'Edit Profil Perusahaan')

@push('styles')
    {{-- CSS untuk form dan preview logo --}}
    <link rel="stylesheet" href="{{ asset('css/register_profile.css') }}">
    <style>
        /* CSS Tambahan untuk Kartu Statistik & Ganti Password */
        .profile-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            padding: 25px;
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

        /* Mengubah ukuran placeholder ikon menjadi lebih kecil */
        .logo-placeholder-icon {
            width: 130px;
            /* dari 150px */
            height: 130px;
            /* dari 150px */
            font-size: 50px;
            /* dari 60px, disesuaikan agar proporsional */
        }

        /* Mengubah ukuran preview gambar menjadi lebih kecil */
        .logo-preview-image {
            width: 130px;
            /* dari 150px */
            height: 130px;
            /* dari 150px */
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">

            {{-- KOLOM KIRI: FORM EDIT PROFIL UTAMA --}}
            <div class="col-lg-8">
                <div class="form-container">
                    <h4 class="mb-4">Informasi Perusahaan</h4>
                    <form action="{{ route('perusahaan.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Form edit profil seperti sebelumnya --}}
                        @include('perusahaan.profile.partials.update-profile-form')

                    </form>
                </div>
            </div>

            {{-- KOLOM KANAN: STATISTIK & GANTI PASSWORD --}}
            <div class="col-lg-4">

                {{-- KARTU STATISTIK PROFIL --}}
                <div class="profile-card text-center">
                    <h5 class="mb-3">Kelengkapan Profil</h5>
                    @php
                        // Definisikan field yang relevan untuk Perusahaan
                        $fields = [
                            'nama_perusahaan',
                            'alamat',
                            'bidang',
                            'nama_pendaftar',
                            'website',
                            'logo',
                            'deskripsi',
                        ];
                        $filledFields = 0;
                        foreach ($fields as $field) {
                            if (!empty($perusahaan->$field)) {
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

                    <p class="text-muted small">
                        Profil yang lengkap meningkatkan kepercayaan calon peserta magang.
                    </p>
                    <hr>
                    <div class="small text-start">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted"><i class="fas fa-industry me-2"></i>Bidang</span>
                            <span class="fw-semibold">{{ $perusahaan->bidang ?? 'Belum diisi' }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted"><i class="fas fa-globe me-2"></i>Website</span>
                            <span class="fw-semibold">{{ $perusahaan->website ?? 'Belum diisi' }}</span>
                        </div>
                    </div>
                </div>

                {{-- KARTU GANTI PASSWORD --}}
                <div class="profile-card">
                    <h5 class="mb-3">Ganti Kata Sandi</h5>

                    {{-- Notifikasi sukses ganti password --}}
                    @if (session('status') === 'password-updated')
                        <div class="alert alert-success small">
                            Kata sandi berhasil diperbarui.
                        </div>
                    @endif

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label small">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" id="current_password" class="form-control"
                                required>
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-danger small" />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label small">Kata Sandi Baru</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-danger small" />
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label small">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required>
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-danger small" />
                        </div>
                        <button type="submit" class="btn btn-secondary w-100">Perbarui Kata Sandi</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
