<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Perusahaan - VOCintern</title>
    <link rel="stylesheet" href="{{ asset('css/profil.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <div class="sidebar">
        <div class="logo">VOCintern - Platform Magang</div>
        <ul class="menu">
            <li><a href="#"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li><a href="#"><i class="material-icons">work</i> Lowongan Magang</a></li>
            <li><a href="#"><i class="material-icons">people</i> Pelamar</a></li>
            <li><a href="#"><i class="material-icons">monetization_on</i> Marketing Apps</a></li>
            <li><a href="#"><i class="material-icons">credit_card</i> Card Mahasiswa</a></li>
            <li><a href="#"><i class="material-icons">message</i> Pesan</a></li>
            <li class="active"><a href="#"><i class="material-icons">settings</i> Pengaturan</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="header">
            <div class="user-info">
                <i class="material-icons">account_circle</i>
                <span>PT. Itech Inovasi</span>
                <i class="material-icons">arrow_drop_down</i>
            </div>
        </div>

        <div class="content-area">
            <div class="profile-tabs">
                <a href="#" class="active">Informasi Perusahaan</a>
                <a href="#">Kontak</a>
                <a href="#">Galeri</a>
                <a href="#">Media Sosial</a>
                <a href="#">Keamanan</a>
            </div>

            <div class="section-card company-header">
                <div class="company-logo-placeholder"></div>
                <div class="company-details">
                    <div class="company-name-status">
                        <h2>PT. Itech Inovasi</h2>
                        <span class="verified"><i class="material-icons">check_circle</i> Terverifikasi</span>
                    </div>
                    <p class="company-tagline">Teknologi Informasi & Komunikasi</p>
                    <p class="company-location">Jakarta, Indonesia</p>
                    <a href="#" class="edit-logo-link">Ganti Logo Perusahaan</a>
                </div>
            </div>

            <div class="stats-cards">
                <div class="stat-card">
                    <span class="stat-number">24</span>
                    <span class="stat-label">Lowongan Magang</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">156</span>
                    <span class="stat-label">Pendaftar</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">18</span>
                    <span class="stat-label">Magang Aktif</span>
                </div>
            </div>

            <form action="#" method="POST">
                <div class="section-card">
                    <h2>Informasi Dasar</h2>
                    <div class="form-group">
                        <label for="nama_perusahaan">Nama Perusahaan *</label>
                        <input type="text" id="nama_perusahaan" name="nama_perusahaan" value="PT. Tech Inovasi">
                    </div>
                    <div class="form-group">
                        <label for="bidang_industri">Bidang Industri *</label>
                        <input type="text" id="bidang_industri" name="bidang_industri" value="Teknologi Informasi">
                    </div>
                    <div class="form-group">
                        <label for="ukuran_perusahaan">Ukuran Perusahaan *</label>
                        <input type="text" id="ukuran_perusahaan" name="ukuran_perusahaan" value="100 karyawan">
                    </div>
                    <div class="form-group">
                        <label for="tentang_perusahaan">Tentang Perusahaan *</label>
                        <textarea id="tentang_perusahaan" name="tentang_perusahaan" rows="5">PT. Tech Inovasi adalah perusahaan teknologi yang fokus pada pengembangan solusi digital untuk berbagai industri. Didirikan pada tahun 2016, kami telah secara konsisten memberikan inovasi terbaru dan layanan profesional kepada klien-klien kami di seluruh Indonesia. Kami berkomitmen untuk membantu meningkatkan efektivitas operasional dan pengalaman pengguna.</textarea>
                    </div>
                    <div class="form-group">
                        <label for="website">Website</label>
                        <input type="text" id="website" name="website" value="https://www.techinovasi.co.id">
                    </div>
                </div>

                <div class="section-card">
                    <h2>Alamat Perusahaan</h2>
                    <div class="form-group">
                        <label for="alamat_lengkap">Alamat Lengkap *</label>
                        <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3">Jl. Gatot Subroto No. 123, Menara Bidaraka Lt. 15</textarea>
                    </div>
                    <div class="form-group">
                        <label for="kota">Kota *</label>
                        <input type="text" id="kota" name="kota" value="Jakarta Selatan">
                    </div>
                    <div class="form-group">
                        <label for="kode_pos">Kode Pos *</label>
                        <input type="text" id="kode_pos" name="kode_pos" value="12930">
                    </div>
                    <div class="form-group">
                        <label for="provinsi">Provinsi *</label>
                        <input type="text" id="provinsi" name="provinsi" value="DKI Jakarta">
                    </div>
                </div>

                <div class="section-card">
                    <h2>Dokumen Perusahaan</h2>
                    <div class="form-group">
                        <label for="npwp">NPWP</label>
                        <input type="text" id="npwp" name="npwp" value="12.345.678.9-012.000">
                    </div>
                    <div class="form-group">
                        <label for="siup_nib">SIUP/NIB</label>
                        <input type="text" id="siup_nib" name="siup_nib" value="1234567890123">
                    </div>
                    <div class="form-group">
                        <label>Dokumen Legalitas Perusahaan</label>
                        <div class="drop-area">
                            <i class="material-icons">cloud_upload</i>
                            <p>Drag and drop files di sini atau <a href="#">klik untuk memilih file</a></p>
                            <small>Format PDF, Maksimal ukuran 5MB</small>
                            <div class="uploaded-file-name">
                                <i class="material-icons">insert_drive_file</i>
                                <span class="file-text">file_legalitas_techinovasi.pdf</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
