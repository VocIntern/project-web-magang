@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>

        <!-- Statistics Cards Row -->
        <div class="row">
            <!-- Total Mahasiswa Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Mahasiswa</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalMahasiswa) }}
                                </div>
                                <div class="text-xs text-muted">+5 dari kemarin terakhir</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Perusahaan Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Perusahaan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPerusahaan) }}
                                </div>
                                <div class="text-xs text-muted">+1 dalam seminggu terakhir</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-building fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lowongan Magang Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Lowongan Magang</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalMagang) }}</div>
                                <div class="text-xs text-muted">Aktif dari Motalic 20</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aplikasi Magang Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Aplikasi Magang</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPendaftaran) }}
                                </div>
                                <div class="text-xs text-muted">Selama ini Pending 65</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Applications Table -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Aplikasi Magang Terbaru</h6>
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-download"></i> Export Data
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>NAMA MAHASISWA</th>
                                        <th>PERUSAHAAN</th>
                                        <th>POSISI</th>
                                        <th>TANGGAL APPLY</th>
                                        <th>STATUS</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentApplications as $application)
                                        <tr>
                                            <td>{{ $application['mahasiswa_nama'] }}</td>
                                            <td>{{ $application['perusahaan_nama'] }}</td>
                                            <td>{{ $application['posisi'] }}</td>
                                            <td>{{ $application['tanggal_apply'] }}</td>
                                            <td>
                                                @if ($application['status'] == 'menunggu')
                                                    <span class="badge badge-warning">Menunggu</span>
                                                @elseif($application['status'] == 'diterima')
                                                    <span class="badge badge-success">Diterima</span>
                                                @elseif($application['status'] == 'ditolak')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @else
                                                    <span
                                                        class="badge badge-info">{{ ucfirst($application['status']) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-outline-primary btn-sm">Detail</a>
                                                <a href="#" class="btn btn-outline-secondary btn-sm">Edit</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data aplikasi</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0">
                                        <li class="page-item disabled">
                                            <span class="page-link">&laquo;</span>
                                        </li>
                                        <li class="page-item active">
                                            <span class="page-link">1</span>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">&raquo;</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div>
                                <a href="#" class="text-primary">Lihat Semua Aplikasi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-lg-4">
                <!-- Recent Activities -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terbaru</h6>
                    </div>
                    <div class="card-body">
                        @forelse($recentActivities as $activity)
                            <div class="d-flex align-items-center mb-3">
                                <div class="mr-3">
                                    @if ($activity['color'] == 'success')
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-user-plus text-white"></i>
                                        </div>
                                    @elseif($activity['color'] == 'warning')
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    @else
                                        <div class="icon-circle bg-info">
                                            <i class="fas fa-info text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="small text-gray-500">{{ $activity['time'] }}</div>
                                    <div>{{ $activity['message'] }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">Tidak ada aktivitas terbaru</p>
                        @endforelse
                        <div class="text-center">
                            <a href="#" class="text-primary">Lihat Semua Aktivitas</a>
                        </div>
                    </div>
                </div>

                <!-- Companies List -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Perusahaan</h6>
                        <button class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Tambah Perusahaan
                        </button>
                    </div>
                    <div class="card-body">
                        @forelse($companies as $company)
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <div class="font-weight-bold">{{ $company['nama_perusahaan'] }}</div>
                                    <div class="small text-muted">{{ $company['industri'] }}</div>
                                    <div class="small text-muted">{{ $company['lokasi'] }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-weight-bold text-primary">{{ $company['lowongan_aktif'] }}</div>
                                    @if ($company['status'] == 'Terverifikasi')
                                        <span class="badge badge-success badge-sm">Terverifikasi</span>
                                    @else
                                        <span class="badge badge-warning badge-sm">Menunggu</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">Tidak ada data perusahaan</p>
                        @endforelse
                        <div class="text-center">
                            <a href="#" class="text-primary">Lihat Semua Perusahaan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Optional: Add any additional JavaScript for dashboard functionality
        console.log('Dashboard loaded successfully');
    </script>
@endsection

@push('styles')
    <style>
        .icon-circle {
            height: 2rem;
            width: 2rem;
            border-radius: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .text-gray-300 {
            color: #dddfeb !important;
        }

        .text-gray-800 {
            color: #5a5c69 !important;
        }

        .badge-sm {
            font-size: 0.75rem;
        }
    </style>
@endpush
