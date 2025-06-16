@extends('mahasiswa.layouts.mahasiswa')

@section('title', 'Lamar Magang')

@section('content')
<link rel="stylesheet" href="{{ asset('css/magang-apply.css') }}">

<div class="container">
    <!-- Breadcrumb -->
    {{-- <nav class="breadcrumb">
        <ol>
            <li>
                <a href="{{ route('mahasiswa.magang.search') }}">
                    <i class="fas fa-search"></i>Cari Magang
                </a>
            </li>
            <li>
                <a href="{{ route('mahasiswa.magang.show', $magang->id) }}">Detail Magang</a>
            </li>
            <li>
                <span>Lamar Magang</span>
            </li>
        </ol>
    </nav> --}}

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <div>
                <h4>Berhasil!</h4>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <h4>Terjadi Kesalahan!</h4>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Header Card -->
    <div class="card company-card">
        <div class="card-header">
            <h1>Lamar Posisi Magang</h1>
            <p>{{ $magang->judul }} - {{ $magang->perusahaan->nama_perusahaan }}</p>
        </div>
    </div>

    <!-- Application Form -->
    <div class="card form-card">
        <div class="card-header">
            <h3><i class="fas fa-edit"></i>Form Lamaran Magang</h3>
            <p>Pastikan semua data yang Anda masukkan sudah benar dan lengkap</p>
        </div>

        <form action="{{ route('mahasiswa.magang.apply.form', $magang->id) }}" method="POST" enctype="multipart/form-data" class="form-container">
            @csrf
            
            <!-- Personal Info -->
            <div class="form-section">
                <h4><i class="fas fa-user"></i>Informasi Pribadi</h4>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" value="{{ Auth::user()->mahasiswa->nama ?? 'Nama belum diatur' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>NIM</label>
                        <input type="text" value="{{ Auth::user()->mahasiswa->nim ?? 'NIM belum diatur' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Jurusan</label>
                        <input type="text" value="{{ Auth::user()->mahasiswa->jurusan ?? 'Jurusan belum diatur' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" value="{{ Auth::user()->email }}" readonly>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-error">
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

            <!-- File Uploads -->
            <div class="form-section">
                <div class="form-group">
                    <label class="required">
                        <i class="fas fa-file-pdf"></i>Curriculum Vitae (CV)
                    </label>
                    <div class="file-input-wrapper">
                        <input type="file" name="cv" accept=".pdf" required>
                        <span class="file-input-text">Format: PDF, Maksimal 2MB</span>
                    </div>
                    @error('cv')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-envelope"></i>Surat Pengantar (Opsional)
                    </label>
                    <div class="file-input-wrapper">
                        <input type="file" name="surat_pengantar" accept=".pdf">
                        <span class="file-input-text">Format: PDF, Maksimal 2MB</span>
                    </div>
                    @error('surat_pengantar')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Terms -->
            <div class="form-section">
                <div class="checkbox-wrapper">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        Saya menyetujui <a href="#">syarat dan ketentuan</a> yang berlaku dan menyatakan bahwa data yang saya berikan adalah benar dan dapat dipertanggungjawabkan.
                    </label>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="form-actions">
                <a href="{{ route('mahasiswa.magang.show', $magang->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>Kembali ke Detail
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i>Kirim Lamaran
                </button>
            </div>
        </form>
    </div>

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
@endsection