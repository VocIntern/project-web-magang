{{-- resources/views/perusahaan/profile/partials/update-profile-form.blade.php --}}

<div class="text-center mb-4">
    <label for="logo" class="form-label d-block">Logo Perusahaan</label>
    
    {{-- Ikon Placeholder (ditampilkan jika tidak ada logo) --}}
    <div id="logo-placeholder" class="logo-placeholder-icon {{ $perusahaan->logo ? 'd-none' : '' }}">
        <i class="fas fa-building"></i>
    </div>
    
    {{-- Image Preview (ditampilkan jika ada logo) --}}
    <img id="logo-preview" src="{{ $perusahaan->logo_url ?? '#' }}" alt="Logo preview" class="logo-preview-image {{ !$perusahaan->logo ? 'd-none' : '' }}">
    
    {{-- Input file yang disembunyikan --}}
    <input type="file" class="d-none" id="logo" name="logo" onchange="previewLogo(event)" accept="image/*">
    <small class="form-text text-muted mt-2">Klik gambar/ikon untuk mengganti logo (maks 2MB).</small>
</div>
<hr>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="nama_perusahaan" class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" value="{{ old('nama_perusahaan', $perusahaan->nama_perusahaan) }}" required>
        </div>
        <div class="mb-3">
            <label for="bidang" class="form-label">Bidang Industri <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="bidang" name="bidang" value="{{ old('bidang', $perusahaan->bidang) }}" required>
        </div>
         <div class="mb-3">
            <label for="website" class="form-label">Website</label>
            <input type="url" class="form-control" id="website" name="website" value="{{ old('website', $perusahaan->website) }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="nama_pendaftar" class="form-label">Nama Kontak (PIC) <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="nama_pendaftar" name="nama_pendaftar" value="{{ old('nama_pendaftar', $perusahaan->nama_pendaftar) }}" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
            <textarea class="form-control" id="alamat" name="alamat" rows="4" required>{{ old('alamat', $perusahaan->alamat) }}</textarea>
        </div>
    </div>
</div>
<div class="mb-4">
    <label for="deskripsi" class="form-label">Deskripsi Singkat Perusahaan</label>
    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $perusahaan->deskripsi) }}</textarea>
</div>
<button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>

@push('scripts')
<script>
    function previewLogo(event) {
        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const placeholder = document.getElementById('logo-placeholder');
                const preview = document.getElementById('logo-preview');

                placeholder.classList.add('d-none');
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            
            reader.readAsDataURL(event.target.files[0]);
        }
    }
    
    // --- KODE YANG DIPERBAIKI ADA DI SINI ---
    
    // Fungsi untuk memicu klik pada input file yang tersembunyi
    function triggerFileInput() {
        document.getElementById('logo').click();
    }

    // Tambahkan event listener ke ikon DAN juga ke preview gambar
    document.getElementById('logo-placeholder').addEventListener('click', triggerFileInput);
    document.getElementById('logo-preview').addEventListener('click', triggerFileInput);
</script>
@endpush