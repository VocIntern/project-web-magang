@extends('perusahaan.layouts.perusahaan-layouts')

{{-- Menambahkan section khusus untuk CSS halaman ini --}}
@push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/register_profile.css') }}"> --}}
    <style>
        /* CSS untuk placeholder ikon logo */
        .logo-placeholder-icon {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #e9ecef;
            /* Warna abu-abu muda */
            color: #6c757d;
            /* Warna ikon */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            /* Ukuran ikon */
            cursor: pointer;
            margin: 10px auto;
            border: 3px solid #dee2e6;
            transition: all 0.2s ease-in-out;
        }

        .logo-placeholder-icon:hover {
            background-color: #dde2e6;
            border-color: #b6bfc8;
        }

        /* CSS untuk preview gambar yang sudah dipilih */
        .logo-preview-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
            margin: 10px auto;
            border: 3px solid #dee2e6;
        }
    </style>
@endpush

@section('content')
    <div class="form-container">
        <h2>Lengkapi Profil Perusahaan</h2>
        <p class="text-center text-muted mb-4">Silakan isi detail informasi perusahaan Anda untuk melanjutkan.</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('perusahaan.profile.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Area Logo dengan Ikon Default --}}
            <div class="text-center mb-4">
                <label for="logo" class="form-label d-block">Logo Perusahaan</label>

                {{-- Ikon Placeholder (ditampilkan secara default) --}}
                <div id="logo-placeholder" class="logo-placeholder-icon">
                    <i class="fas fa-building"></i>
                </div>

                {{-- Image Preview (disembunyikan secara default) --}}
                <img id="logo-preview" src="#" alt="Logo preview" class="logo-preview-image d-none">

                {{-- Input file yang disembunyikan --}}
                <input type="file" class="d-none" id="logo" name="logo" onchange="previewLogo(event)"
                    accept="image/*">
                <small class="form-text text-muted mt-2">Klik ikon di atas untuk memilih logo (maks 2MB).</small>
            </div>

            <hr>

            <div class="row">
                {{-- Kolom Kiri --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_perusahaan" class="form-label">Nama Perusahaan <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan"
                            value="{{ old('nama_perusahaan') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="bidang" class="form-label">Bidang Industri <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="bidang" name="bidang" value="{{ old('bidang') }}"
                            placeholder="Contoh: Teknologi Informasi" required>
                    </div>
                    <div class="mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="url" class="form-control" id="website" name="website"
                            value="{{ old('website') }}" placeholder="https://contoh.com">
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_pendaftar" class="form-label">Nama Kontak (PIC) <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_pendaftar" name="nama_pendaftar"
                            value="{{ old('nama_pendaftar') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="4" required>{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="form-label">Deskripsi Singkat Perusahaan</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"
                    placeholder="Jelaskan secara singkat tentang perusahaan Anda...">{{ old('deskripsi') }}</textarea>
            </div>

            <button type="submit" class="btn btn-success w-100">Simpan Profil dan Lanjutkan</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function previewLogo(event) {
            // Pastikan ada file yang dipilih
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const placeholder = document.getElementById('logo-placeholder');
                    const preview = document.getElementById('logo-preview');

                    // Sembunyikan ikon placeholder
                    placeholder.classList.add('d-none');

                    // Tampilkan preview gambar dan atur sumbernya
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };

                // Baca file sebagai URL data
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        // Fungsi untuk memicu klik pada input file yang tersembunyi
        function triggerFileInput() {
            document.getElementById('logo').click();
        }

        // Tambahkan event listener ke ikon dan preview gambar
        document.getElementById('logo-placeholder').addEventListener('click', triggerFileInput);
        document.getElementById('logo-preview').addEventListener('click', triggerFileInput);
    </script>
@endpush
