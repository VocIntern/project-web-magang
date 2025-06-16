@extends('mahasiswa.layouts.mahasiswa')

@section('title', 'Lamar Magang')

@push('styles')
@endpush

@section('content')
    <link rel="stylesheet" href="{{ asset('css/magang-apply.css') }}">
    <div class="container-fluid">
        <div class="internship-form-container">
            <div class="internship-form-wrapper">

                @if (session('success'))
                    <div class="alert success">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <h4>Berhasil!</h4>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <h4>Terjadi Kesalahan!</h4>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Header Halaman -->
                <h1>Lamar Posisi Magang</h1>
                <p>{{ $magang->judul }} - {{ $magang->perusahaan->nama_perusahaan }}</p>

                <!-- Form Container -->
                <form action="{{ route('mahasiswa.magang.apply.form', $magang->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert error">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>
                                <strong>Terjadi kesalahan pada form:</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Header Form -->
                    <h3><i class="fas fa-file-alt"></i>Form Lamaran Magang</h3>
                    <p>Pastikan semua data yang Anda masukkan sudah benar dan lengkap</p>

                    <!-- Informasi Pribadi -->
                    <h4><i class="fas fa-user"></i>Informasi Pribadi</h4>
                    <div class="info-grid">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" value="{{ Auth::user()->mahasiswa->nama ?? 'Nama belum diatur' }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>NIM</label>
                            <input type="text" value="{{ Auth::user()->mahasiswa->nim ?? 'NIM belum diatur' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Jurusan</label>
                            <input type="text" value="{{ Auth::user()->mahasiswa->jurusan ?? 'Jurusan belum diatur' }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="{{ Auth::user()->email }}" readonly>
                        </div>
                    </div>

                    <!-- Upload Documents -->
                    <h4><i class="fas fa-upload"></i>Dokumen Lamaran</h4>

                    <div class="form-group">
                        <label>Curriculum Vitae (CV) *</label>
                        <input type="file" name="cv" accept=".pdf" required>
                        <small class="file-info">Format: PDF, Maksimal 2MB</small>
                        @error('cv')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Surat Pengantar (Opsional)</label>
                        <input type="file" name="surat_pengantar" accept=".pdf">
                        <small class="file-info">Format: PDF, Maksimal 2MB</small>
                        @error('surat_pengantar')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="checkbox-container">
                        <label>
                            <input type="checkbox" id="terms" name="terms" required>
                            <span>Saya menyetujui <a href="#">syarat dan ketentuan</a> yang berlaku dan menyatakan
                                bahwa data yang saya berikan adalah benar dan dapat dipertanggungjawabkan.</span>
                        </label>
                    </div>

                    <!-- Form Actions -->
                    <div class="btn-container">
                        <a href="{{ route('mahasiswa.magang.show', $magang->id) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>Kembali ke Detail
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-paper-plane"></i>Kirim Lamaran
                        </button>
                    </div>
                </form>

                <!-- Tips Section -->
                <div class="tips-section">
                    <h4><i class="fas fa-lightbulb"></i>Tips Sukses Melamar Magang</h4>
                    <div class="tips-grid">
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <p>Pastikan CV Anda terbaru dan mencantumkan pengalaman yang relevan</p>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <p>Surat pengantar yang personal dapat meningkatkan peluang diterima</p>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <p>Periksa kembali semua dokumen dan pastikan tidak ada kesalahan</p>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <p>Gunakan format PDF untuk menjaga tampilan dokumen tetap konsisten</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
