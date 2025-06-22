@extends('admin.layouts.admin')

@section('title', 'Edit Lowongan Magang')

@section('content')
<div class="container-fluid">
    <div class="card modern-card">
        <div class="card-header">
            <div class="card-toolbar">
                <h4 class="card-title mb-0">Formulir Edit Lowongan Magang</h4>
                <div class="card-actions">
                    <a href="{{ route('admin.magang.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left fa-sm"></i> Kembali
                    </a>
                </div>
            </div>
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

            <form action="{{ route('admin.magang.update', $magang) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <!-- Judul -->
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Lowongan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $magang->judul) }}" required>
                            @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Pekerjaan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $magang->deskripsi) }}</textarea>
                            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Kualifikasi -->
                        <div class="mb-3">
                            <label for="kualifikasi" class="form-label">Kualifikasi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('kualifikasi') is-invalid @enderror" id="kualifikasi" name="kualifikasi" rows="5" required>{{ old('kualifikasi', $magang->kualifikasi) }}</textarea>
                            @error('kualifikasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <!-- Perusahaan -->
                                <div class="mb-3">
                                    <label for="perusahaan_id" class="form-label">Perusahaan <span class="text-danger">*</span></label>
                                    <select class="form-select @error('perusahaan_id') is-invalid @enderror" id="perusahaan_id" name="perusahaan_id" required>
                                        <option value="">Pilih Perusahaan</option>
                                        @foreach($perusahaans as $perusahaan)
                                            <option value="{{ $perusahaan->id }}" {{ old('perusahaan_id', $magang->perusahaan_id) == $perusahaan->id ? 'selected' : '' }}>
                                                {{ $perusahaan->nama_perusahaan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('perusahaan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                
                                <!-- Tipe Magang -->
                                <div class="mb-3">
                                    <label for="tipe" class="form-label">Tipe Magang <span class="text-danger">*</span></label>
                                    <select class="form-select @error('tipe') is-invalid @enderror" id="tipe" name="tipe" required>
                                        <option value="Full-time" {{ old('tipe', $magang->tipe) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                        <option value="Part-time" {{ old('tipe', $magang->tipe) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                        <option value="Remote" {{ old('tipe', $magang->tipe) == 'Remote' ? 'selected' : '' }}>Remote</option>
                                    </select>
                                    @error('tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                
                                <!-- Lokasi -->
                                <div class="mb-3">
                                    <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi', $magang->lokasi) }}" required>
                                    @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="Dibuka" {{ old('status', $magang->status) == 'Dibuka' ? 'selected' : '' }}>Dibuka</option>
                                        <option value="Ditutup" {{ old('status', $magang->status) == 'Ditutup' ? 'selected' : '' }}>Ditutup</option>
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Tanggal Buka & Tutup -->
                                <div class="mb-3">
                                    <label for="tanggal_buka" class="form-label">Tanggal Buka <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('tanggal_buka') is-invalid @enderror" id="tanggal_buka" name="tanggal_buka" value="{{ old('tanggal_buka', $magang->tanggal_buka) }}" required>
                                    @error('tanggal_buka')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_tutup" class="form-label">Tanggal Tutup <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('tanggal_tutup') is-invalid @enderror" id="tanggal_tutup" name="tanggal_tutup" value="{{ old('tanggal_tutup', $magang->tanggal_tutup) }}" required>
                                    @error('tanggal_tutup')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.magang.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
