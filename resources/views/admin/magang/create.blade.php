@extends('admin.layouts.admin')
@section('title', 'Buat Lowongan Magang Baru')
@section('content')
    <div class="container-fluid">
        <div class="card modern-card">
            <div class="card-header">
                <h5 class="card-title">Formulir Lowongan Magang</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.magang.store') }}" method="POST">
                    @csrf
                    {{-- Tampilkan error di sini jika ada --}}

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="perusahaan_id" class="form-label">Perusahaan</label>
                            <select class="form-select" id="perusahaan_id" name="perusahaan_id" required>
                                <option value="">Pilih Perusahaan</option>
                                @foreach ($perusahaan as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="judul" class="form-label">Judul Posisi Magang</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Pekerjaan</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3"><label for="bidang" class="form-label">Bidang</label><input
                                type="text" class="form-control" id="bidang" name="bidang" required></div>
                        <div class="col-md-4 mb-3"><label for="lokasi" class="form-label">Lokasi</label><input
                                type="text" class="form-control" id="lokasi" name="lokasi" required></div>
                        <div class="col-md-4 mb-3"><label for="kuota" class="form-label">Kuota</label><input
                                type="number" class="form-control" id="kuota" name="kuota" value="1" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label for="tanggal_mulai" class="form-label">Tanggal Mulai</label><input
                                type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required></div>
                        <div class="col-md-6 mb-3"><label for="tanggal_selesai" class="form-label">Tanggal
                                Selesai</label><input type="date" class="form-control" id="tanggal_selesai"
                                name="tanggal_selesai" required></div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Status Lowongan</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status_aktif"
                                name="status_aktif" value="1" checked>
                            <label class="form-check-label" for="status_aktif">Aktif (Bisa dilamar)</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.magang.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Lowongan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
