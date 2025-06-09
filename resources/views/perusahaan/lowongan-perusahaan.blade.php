<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Lowongan Magang - VOCintern</title>
    <link rel="stylesheet" href="{{  asset('css/lowongan.css')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <div class="logo">VOCintern - Platform Magang</div>
        <ul class="menu">
            <li><a href="#"><i class="material-icons">dashboard</i> Dashboard</a></li>
            <li class="active"><a href="#"><i class="material-icons">work</i> Lowongan Magang</a></li>
            <li><a href="#"><i class="material-icons">people</i> Pelamar</a></li>
            <li><a href="#"><i class="material-icons">monetization_on</i> Marketing Apps</a></li>
            <li><a href="#"><i class="material-icons">credit_card</i> Card Mahasiswa</a></li>
            <li><a href="#"><i class="material-icons">message</i> Pesan</a></li>
            <li><a href="#"><i class="material-icons">settings</i> Pengaturan</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="header">
            <div class="user-info">
                <i class="material-icons">account_circle</i>
                <span>PT. Itech Servise</span>
                <i class="material-icons">arrow_drop_down</i>
            </div>
        </div>

        <div class="content-area">
            <h1>Upload Lowongan Magang</h1>

            <form action="#" method="POST">
                <div class="section-card">
                    <h2>Informasi Dasar</h2>
                    <div class="form-group">
                        <label for="judul_lowongan">Judul Lowongan</label>
                        <input type="text" id="judul_lowongan" name="judul_lowongan" placeholder="contoh: UI/UX Designer, Bandung, Jawa Barat, dll">
                    </div>
                    <div class="form-group">
                        <label for="departemen">Departemen</label>
                        <input type="text" id="departemen" name="departemen" placeholder="contoh: IT, Marketing, Keuangan, dll">
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" id="lokasi" name="lokasi" placeholder="contoh: Medan, Sumatera Utara, Indonesia">
                    </div>
                    <div class="form-group">
                        <label for="durasi_magang">Durasi Magang</label>
                        <select id="durasi_magang" name="durasi_magang">
                            <option value="">Pilih Durasi Magang</option>
                            <option value="1_bulan">1 Bulan</option>
                            <option value="3_bulan">3 Bulan</option>
                            <option value="6_bulan">6 Bulan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tipe_magang">Tipe Magang</label>
                        <select id="tipe_magang" name="tipe_magang">
                            <option value="">Pilih Tipe Magang</option>
                            <option value="fulltime">Full-time</option>
                            <option value="parttime">Part-time</option>
                            <option value="hybrid">Hybrid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_berakhir">Tanggal Berakhir</label>
                        <input type="date" id="tanggal_berakhir" name="tanggal_berakhir">
                    </div>
                    <div class="form-group">
                        <label for="posisi_berperan">Kompensasi</label>
                        <input type="text" id="posisi_berperan" name="posisi_berperan" placeholder="Pilih jenis kompensasi">
                    </div>
                </div>

                <div class="section-card">
                    <h2>Deskripsi Lowongan</h2>
                    <div class="form-group">
                        <label for="deskripsi_pekerjaan">Deskripsi Pekerjaan</label>
                        <textarea id="deskripsi_pekerjaan" name="deskripsi_pekerjaan" rows="4" placeholder="Jelaskan secara rinci deskripsi magang ini dan tanggung jawab yang akan dilakukan"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kualifikasi">Kualifikasi</label>
                        <textarea id="kualifikasi" name="kualifikasi" rows="4" placeholder="Detailkan kualifikasi yang dapat umum untuk posisi ini..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="benefit">Benefit</label>
                        <textarea id="benefit" name="benefit" rows="4" placeholder="Detailkan benefit yang akan didapatkan peserta magang..."></textarea>
                    </div>
                </div>

                <div class="section-card">
                    <h2>Keahlian & Persyaratan</h2>
                    <div class="form-group">
                        <label>Keahlian saat ini (Multiseleksi)</label>
                        <div class="tags-input-container">
                            <span class="tag">HTML/CSS<i class="material-icons">close</i></span>
                            <span class="tag">Adobe XD<i class="material-icons">close</i></span>
                            <span class="tag">Figma<i class="material-icons">close</i></span>
                            <input type="text" placeholder="Tambahkan keahlian...">
                        </div>
                        <small>Tekan enter untuk menambahkan keahlian</small>
                    </div>
                    <div class="form-group">
                        <label>Jurusan yang Diutamakan</label>
                        <div class="tags-input-container">
                            <span class="tag">Teknik Informatika<i class="material-icons">close</i></span>
                            <span class="tag">Desain Komunikasi Visual<i class="material-icons">close</i></span>
                            <input type="text" placeholder="Tambahkan jurusan...">
                        </div>
                        <small>Tekan enter untuk menambahkan jurusan</small>
                    </div>
                    <div class="form-group">
                        <label for="gaji_minimal">Estimasi Gaji (Opsional)</label>
                        <input type="text" id="gaji_minimal" name="gaji_minimal" placeholder="Contoh: Rp 1.500.000">
                    </div>
                    <div class="form-group">
                        <label>Persyaratan Dokumen</label>
                        <div class="checkbox-group">
                            <label><input type="checkbox" name="dokumen[]" value="CV/Resume"> CV/Resume</label>
                            <label><input type="checkbox" name="dokumen[]" value="Portofolio"> Portofolio</label>
                            <label><input type="checkbox" name="dokumen[]" value="Surat Lamaran"> Surat Lamaran</label>
                            <label><input type="checkbox" name="dokumen[]" value="Ijazah"> Ijazah</label>
                            <label><input type="checkbox" name="dokumen[]" value="Transkrip Nilai"> Transkrip Nilai</label>
                            <label><input type="checkbox" name="dokumen[]" value="Sertifikat"> Sertifikat</label>
                            <label><input type="checkbox" name="dokumen[]" value="Dokumen Tambahan"> Dokumen Tambahan</label>
                        </div>
                    </div>
                    <div class="form-group drop-area">
                        <i class="material-icons">cloud_upload</i>
                        <p>Drag and drop files di sini atau <a href="#">klik untuk memilih file</a></p>
                        <small>Maks. ukuran file 10MB, format: pdf, docx, jpg, png</small>
                    </div>
                </div>

                <div class="section-card">
                    <h2>Pengaturan Lowongan</h2>
                    <div class="toggle-switch-group">
                        <div class="toggle-switch">
                            <label for="tampilkan_di_halaman_pencarian">Tampilkan di halaman pencarian</label>
                            <label class="switch">
                                <input type="checkbox" id="tampilkan_di_halaman_pencarian" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="toggle-switch">
                            <label for="terima_aplikasi_secara_otomatis">Terima aplikasi secara otomatis</label>
                            <label class="switch">
                                <input type="checkbox" id="terima_aplikasi_secara_otomatis">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="toggle-switch">
                            <label for="kirim_notifikasi_email_saat_ada_pendaftar_baru">Kirim notifikasi email saat ada pendaftar baru</label>
                            <label class="switch">
                                <input type="checkbox" id="kirim_notifikasi_email_saat_ada_pendaftar_baru" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kuota_penerima">Kuota Penerima</label>
                        <input type="number" id="kuota_penerima" name="kuota_penerima" min="1" placeholder="Jumlah maksimum pelamar yang diterima">
                        <small>Kosongkan jika tidak ada batasan kuota.</small>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary">Simpan sebagai Draft</button>
                    <button type="submit" class="btn btn-primary">Publikasikan Lowongan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>