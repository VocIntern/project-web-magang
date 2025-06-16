@extends('perusahaan.layouts.perusahaan-layouts')

@section('title', 'Buat Lowongan Baru')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-success">Formulir Lowongan Magang Baru</h6>
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

                <form action="{{ route('perusahaan.lowongan.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Lowongan <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="judul" name="judul"
                                    value="{{ old('judul') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bidang" class="form-label">Bidang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="bidang" name="bidang"
                                    value="{{ old('bidang') }}" placeholder="Contoh: Web Development" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Pekerjaan <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lokasi" name="lokasi"
                                    value="{{ old('lokasi') }}" placeholder="Contoh: Jakarta Selatan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kuota" class="form-label">Kuota Peserta <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="kuota" name="kuota"
                                    value="{{ old('kuota', 1) }}" min="1" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                    value="{{ old('tanggal_mulai') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                    value="{{ old('tanggal_selesai') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('perusahaan.dashboard') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-success">Simpan Lowongan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
