<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - VocIntern</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <div class="user-info">
                <div class="user-avatar">A</div>
                <div>
                    <h6 style="margin: 0; font-size: 14px;">Admin Utama</h6>
                    <small style="color: rgba(255,255,255,0.7);">Super Admin</small>
                </div>
            </div>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Menu Utama</div>
            <a href="#" class="nav-link active">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-user-graduate"></i>
                Kelola Pengguna
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-building"></i>
                Kelola Perusahaan
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-briefcase"></i>
                Kelola Magang
                <span class="badge-notification">23</span>
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-users"></i>
                Kelola Mahasiswa
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-chart-bar"></i>
                Laporan
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Pengaturan</div>
            <a href="#" class="nav-link">
                <i class="fas fa-cog"></i>
                Pengaturan Sistem
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-bell"></i>
                Notifikasi
                <span class="badge-notification">1</span>
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-file-alt"></i>
                Log Aktivitas
            </a>
        </div>
        
        <div class="nav-section">
            <div class="nav-section-title">Akun</div>
            <a href="#" class="nav-link">
                <i class="fas fa-user"></i>
                Profil Admin
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-key"></i>
                Ubah Password
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <h1 class="page-title">Dashboard Admin</h1>
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari...">
                </div>
                <button class="add-btn">
                    <i class="fas fa-plus"></i>
                    Tambah Data
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon students">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>326</h3>
                        <p>Total Mahasiswa</p>
                        <div class="change">+5 dari kemarin terakhir</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon companies">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-info">
                        <h3>42</h3>
                        <p>Total Perusahaan</p>
                        <div class="change">+1 dalam seminggu terakhir</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon internships">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="stat-info">
                        <h3>78</h3>
                        <p>Lowongan Magang</p>
                        <div class="change">Aktif dari Motivate 20</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon applications">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-info">
                        <h3>145</h3>
                        <p>Aplikasi Magang</p>
                        <div class="change">Selama ini Pending 65</div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Applications Table -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Aplikasi Magang Terbaru</h5>
                        <button class="export-btn">
                            <i class="fas fa-download"></i>
                            Export Data
                        </button>
                    </div>
                    <div class="table-container">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>Perusahaan</th>
                                    <th>Posisi</th>
                                    <th>Tanggal Apply</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Ahmad Rizky</td>
                                    <td>PT Maju Bersama</td>
                                    <td>Web Developer</td>
                                    <td>12 Apr 2025</td>
                                    <td><span class="status-badge status-menunggu">Menunggu</span></td>
                                    <td>
                                        <button class="action-btn">Detail</button>
                                        <button class="action-btn">Edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Siti Nurlaili</td>
                                    <td>PT Digital Kreatif</td>
                                    <td>UI/UX Designer</td>
                                    <td>10 Apr 2025</td>
                                    <td><span class="status-badge status-diterima">Diterima</span></td>
                                    <td>
                                        <button class="action-btn">Detail</button>
                                        <button class="action-btn">Edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Budi Santoso</td>
                                    <td>PT Tech Indonesia</td>
                                    <td>Mobile Developer</td>
                                    <td>9 Apr 2025</td>
                                    <td><span class="status-badge status-ditolak">Ditolak</span></td>
                                    <td>
                                        <button class="action-btn">Detail</button>
                                        <button class="action-btn">Edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Diana Putri</td>
                                    <td>PT Solusi Digital</td>
                                    <td>Digital Marketing</td>
                                    <td>8 Apr 2025</td>
                                    <td><span class="status-badge status-diterima">Diterima</span></td>
                                    <td>
                                        <button class="action-btn">Detail</button>
                                        <button class="action-btn">Edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Farhan Wijaya</td>
                                    <td>PT Inovasi Teknologi</td>
                                    <td>Data Analyst</td>
                                    <td>7 Apr 2025</td>
                                    <td><span class="status-badge status-selesai">Selesai</span></td>
                                    <td>
                                        <button class="action-btn">Detail</button>
                                        <button class="action-btn">Edit</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination">
                        <div class="pagination-nav">
                            <button>‹</button>
                            <button class="active">1</button>
                            <button>2</button>
                            <button>3</button>
                            <button>›</button>
                        </div>
                        <a href="#" style="color: #28a745; text-decoration: none;">Lihat Semua Aplikasi</a>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div>
                    <!-- Recent Activities -->
                    <div class="card" style="margin-bottom: 20px;">
                        <div class="card-header">
                            <h5 class="card-title">Aktivitas Terbaru</h5>
                        </div>
                        <div>
                            <div class="activity-item">
                                <div class="activity-icon success">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-time">Mei 10, 10:45</div>
                                    <div class="activity-text">PT Tech Indonesia menambahkan lowongan magang baru</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon info">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-time">Mei 10, 09:30</div>
                                    <div class="activity-text">3 mahasiswa baru mendaftar akun</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon warning">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-time">Mei 10, 08:15</div>
                                    <div class="activity-text">Permintaan verifikasi dari PT Maju Digital</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon danger">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-time">Mei 9, 16:20</div>
                                    <div class="activity-text">Laporan masalah login dari 2 pengguna</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon info">
                                    <i class="fas fa-sync"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-time">Mei 9, 14:30</div>
                                    <div class="activity-text">Update sistem berhasil dilakukan</div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="view-all-link">Lihat Semua Aktivitas</a>
                    </div>

                    <!-- Companies List -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Daftar Perusahaan</h5>
                            <button class="add-btn" style="font-size: 12px; padding: 6px 12px;">
                                <i class="fas fa-plus"></i>
                                Tambah Perusahaan
                            </button>
                        </div>
                        <div>
                            <div class="company-item">
                                <div class="company-info">
                                    <h6>PT Maju Bersama</h6>
                                    <p>Teknologi Informasi</p>
                                    <p>Jakarta</p>
                                </div>
                                <div class="company-stats">
                                    <div class="count">5</div>
                                    <span class="status-badge status-diterima">Terverifikasi</span>
                                </div>
                            </div>
                            <div class="company-item">
                                <div class="company-info">
                                    <h6>PT Digital Kreatif</h6>
                                    <p>Digital Marketing</p>
                                    <p>Bandung</p>
                                </div>
                                <div class="company-stats">
                                    <div class="count">3</div>
                                    <span class="status-badge status-diterima">Terverifikasi</span>
                                </div>
                            </div>
                            <div class="company-item">
                                <div class="company-info">
                                    <h6>PT Solusi Fintech</h6>
                                    <p>Financial Technology</p>
                                    <p>Jakarta</p>
                                </div>
                                <div class="company-stats">
                                    <div class="count">0</div>
                                    <span class="status-badge status-menunggu">Menunggu</span>
                                </div>
                            </div>
                            <div class="company-item">
                                <div class="company-info">
                                    <h6>PT Tech Indonesia</h6>
                                    <p>Teknologi Informasi</p>
                                    <p>Surabaya</p>
                                </div>
                                <div class="company-stats">
                                    <div class="count">4</div>
                                    <span class="status-badge status-diterima">Terverifikasi</span>
                                </div>
                            </div>
                        </div>
                        <div class="pagination">
                            <div class="pagination-nav">
                                <button>‹</button>
                                <button class="active">1</button>
                                <button>2</button>
                                <button>›</button>
                            </div>
                        </div>
                        <a href="#" class="view-all-link">Lihat Semua Perusahaan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple demo functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.querySelector('.sidebar-toggle');
            
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }
            
            // Table row hover effect
            const tableRows = document.querySelectorAll('.modern-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('click', function() {
                    console.log('Row clicked:', this);
                });
            });
        });
    </script>
</body>
</html>