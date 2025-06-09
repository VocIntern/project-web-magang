<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOCintern - Seleksi Mahasiswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/seleksi.css') }}">
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-logo">
            <img src="https://i.imgur.com/your-logo.png" alt="VOCintern Logo">
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li><a href="#"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
                <li><a href="#"><i class="fas fa-briefcase"></i> <span>Lowongan Magang</span></a></li>
                <li><a href="#"><i class="fas fa-clipboard-list"></i> <span>Pendaftar</span></a></li>
                <li><a href="#"><i class="fas fa-users-cog"></i> <span>Magang Aktif</span></a></li>
                <li><a href="#" class="active"><i class="fas fa-user-graduate"></i> <span>Seleksi
                            Mahasiswa</span></a></li>
                <li><a href="#"><i class="fas fa-cog"></i> <span>Pengaturan</span></a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <div class="header">
            <h1>Seleksi Mahasiswa</h1>
            <div class="header-right">
                <i class="fas fa-user-circle"></i> PT. Tech Innova <i class="fas fa-caret-down"></i>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="number">47</div>
                <div class="label">Total Pelamar</div>
            </div>
            <div class="stat-card">
                <div class="number">12</div>
                <div class="label">Menunggu Review</div>
            </div>
            <div class="stat-card">
                <div class="number">8</div>
                <div class="label">Tahap Interview</div>
            </div>
            <div class="stat-card">
                <div class="number">5</div>
                <div class="label">Diterima</div>
            </div>
        </div>

        <div class="filter-section">
            <h2>Filter & Pencarian</h2>
            <div class="filter-row">
                <div class="filter-item">
                    <label for="jurusan">Jurusan</label>
                    <select id="jurusan">
                        <option value="">Semua Jurusan</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Sistem Informasi">Sistem Informasi</option>
                        <option value="Sistem Komputer">Sistem Komputer</option>
                        <option value="Manajemen Informatika">Manajemen Informatika</option>
                        <option value="Teknik Komputer">Teknik Komputer</option>
                        <option value="Ilmu Komputer">Ilmu Komputer</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label for="universitas">Universitas</label>
                    <select id="universitas">
                        <option value="">Semua Universitas</option>
                        <option value="Universitas Indonesia">Universitas Indonesia</option>
                        <option value="Institut Teknologi Bandung">Institut Teknologi Bandung</option>
                        <option value="Institut Teknologi Sepuluh Nopember">Institut Teknologi Sepuluh Nopember</option>
                        <option value="Universitas Bina Nusantara">Universitas Bina Nusantara</option>
                        <option value="Universitas Gadjah Mada">Universitas Gadjah Mada</option>
                        <option value="Universitas Diponegoro">Universitas Diponegoro</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label for="status">Status</label>
                    <select id="status">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Review">Menunggu Review</option>
                        <option value="Tahap Interview">Tahap Interview</option>
                        <option value="Ditolak">Ditolak</option>
                        <option value="Diterima">Diterima</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label for="cari-nama">Cari Nama</label>
                    <input type="text" id="cari-nama" placeholder="Masukkan nama mahasiswa...">
                </div>
            </div>
            <div class="filter-buttons">
                <button class="apply-filter">Terapkan Filter</button>
                <button class="reset-filter">Reset Filter</button>
            </div>
        </div>

        <div class="student-grid">
            <div class="student-card">
                <span class="status-badge">Menunggu Review</span>
                <div class="student-header">
                    <div class="avatar">AS</div>
                    <div class="student-info">
                        <h3>Ahmad Suharto</h3>
                        <p>Universitas Indonesia</p>
                    </div>
                </div>
                <div class="student-details">
                    <table>
                        <tr>
                            <td>Jurusan:</td>
                            <td>Teknik Informatika</td>
                        </tr>
                        <tr>
                            <td>Semester:</td>
                            <td>6</td>
                        </tr>
                        <tr>
                            <td>IPK:</td>
                            <td>3.75</td>
                        </tr>
                    </table>
                </div>
                <div class="skills-tags">
                    <span class="skill-tag">Javascript</span>
                    <span class="skill-tag">React</span>
                    <span class="skill-tag">Redux</span>
                    <span class="skill-tag">Python</span>
                </div>
                <div class="card-actions">
                    <button class="btn-terima">Terima</button>
                    <button class="btn-manage">Manage</button>
                    <button class="btn-tolak">Tolak</button>
                </div>
            </div>

            <div class="student-card">
                <span class="status-badge interview">Tahap Interview</span>
                <div class="student-header">
                    <div class="avatar">SP</div>
                    <div class="student-info">
                        <h3>Sari Permata</h3>
                        <p>Institut Teknologi Bandung</p>
                    </div>
                </div>
                <div class="student-details">
                    <table>
                        <tr>
                            <td>Jurusan:</td>
                            <td>Sistem Informasi</td>
                        </tr>
                        <tr>
                            <td>Semester:</td>
                            <td>7</td>
                        </tr>
                        <tr>
                            <td>IPK:</td>
                            <td>3.82</td>
                        </tr>
                    </table>
                </div>
                <div class="skills-tags">
                    <span class="skill-tag">UI/UX Design</span>
                    <span class="skill-tag">Figma</span>
                    <span class="skill-tag">Adobe XD</span>
                    <span class="skill-tag">HTML/CSS</span>
                </div>
                <div class="card-actions">
                    <button class="btn-terima">Terima</button>
                    <button class="btn-manage">Manage</button>
                    <button class="btn-tolak">Tolak</button>
                </div>
            </div>

            <div class="student-card">
                <span class="status-badge review">Menunggu Review</span>
                <div class="student-header">
                    <div class="avatar">RH</div>
                    <div class="student-info">
                        <h3>Rizky Handani</h3>
                        <p>Institut Teknologi Sepuluh Nopember</p>
                    </div>
                </div>
                <div class="student-details">
                    <table>
                        <tr>
                            <td>Jurusan:</td>
                            <td>Sistem Komputer</td>
                        </tr>
                        <tr>
                            <td>Semester:</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>IPK:</td>
                            <td>3.65</td>
                        </tr>
                    </table>
                </div>
                <div class="skills-tags">
                    <span class="skill-tag">Java</span>
                    <span class="skill-tag">Spring Boot</span>
                    <span class="skill-tag">MySQL</span>
                    <span class="skill-tag">Docker</span>
                </div>
                <div class="card-actions">
                    <button class="btn-terima">Terima</button>
                    <button class="btn-manage">Manage</button>
                    <button class="btn-tolak">Tolak</button>
                </div>
            </div>

            <div class="student-card">
                <span class="status-badge ditolak">Ditolak</span>
                <div class="student-header">
                    <div class="avatar">DF</div>
                    <div class="student-info">
                        <h3>Dewi Fortuna</h3>
                        <p>Universitas Bina Nusantara</p>
                    </div>
                </div>
                <div class="student-details">
                    <table>
                        <tr>
                            <td>Jurusan:</td>
                            <td>Manajemen Informatika</td>
                        </tr>
                        <tr>
                            <td>Semester:</td>
                            <td>6</td>
                        </tr>
                        <tr>
                            <td>IPK:</td>
                            <td>2.90</td>
                        </tr>
                    </table>
                </div>
                <div class="skills-tags">
                    <span class="skill-tag">Data Analysis</span>
                    <span class="skill-tag">Python</span>
                    <span class="skill-tag">SQL</span>
                    <span class="skill-tag">Power BI</span>
                </div>
                <div class="card-actions">
                    <button class="btn-terima">Terima</button>
                    <button class="btn-manage">Manage</button>
                    <button class="btn-tolak">Tolak</button>
                </div>
            </div>

            <div class="student-card">
                <span class="status-badge interview">Tahap Interview</span>
                <div class="student-header">
                    <div class="avatar">BP</div>
                    <div class="student-info">
                        <h3>Budi Prasetyo</h3>
                        <p>Universitas Gadjah Mada</p>
                    </div>
                </div>
                <div class="student-details">
                    <table>
                        <tr>
                            <td>Jurusan:</td>
                            <td>Teknik Informatika</td>
                        </tr>
                        <tr>
                            <td>Semester:</td>
                            <td>7</td>
                        </tr>
                        <tr>
                            <td>IPK:</td>
                            <td>3.58</td>
                        </tr>
                    </table>
                </div>
                <div class="skills-tags">
                    <span class="skill-tag">Mobile Dev</span>
                    <span class="skill-tag">Flutter</span>
                    <span class="skill-tag">Dart</span>
                    <span class="skill-tag">Firebase</span>
                </div>
                <div class="card-actions">
                    <button class="btn-terima">Terima</button>
                    <button class="btn-manage">Manage</button>
                    <button class="btn-tolak">Tolak</button>
                </div>
            </div>

            <div class="student-card">
                <span class="status-badge review">Menunggu Review</span>
                <div class="student-header">
                    <div class="avatar">AN</div>
                    <div class="student-info">
                        <h3>Andi Nugraha</h3>
                        <p>Universitas Diponegoro</p>
                    </div>
                </div>
                <div class="student-details">
                    <table>
                        <tr>
                            <td>Jurusan:</td>
                            <td>Sistem Informasi</td>
                        </tr>
                        <tr>
                            <td>Semester:</td>
                            <td>6</td>
                        </tr>
                        <tr>
                            <td>IPK:</td>
                            <td>3.72</td>
                        </tr>
                    </table>
                </div>
                <div class="skills-tags">
                    <span class="skill-tag">PHP</span>
                    <span class="skill-tag">Laravel</span>
                    <span class="skill-tag">Vue.js</span>
                    <span class="skill-tag">PostgreSQL</span>
                </div>
                <div class="card-actions">
                    <button class="btn-terima">Terima</button>
                    <button class="btn-manage">Manage</button>
                    <button class="btn-tolak">Tolak</button>
                </div>
            </div>

        </div>
    </main>

    <script>
        // JavaScript untuk Interaktivitas (Contoh Sederhana)

        // Contoh untuk filter:
        const jurusanSelect = document.getElementById('jurusan');
        const universitasSelect = document.getElementById('universitas');
        const statusSelect = document.getElementById('status');
        const searchInput = document.getElementById('cari-nama');
        const applyFilterBtn = document.querySelector('.apply-filter');
        const resetFilterBtn = document.querySelector('.reset-filter');
        const studentCards = document.querySelectorAll('.student-card'); // Semua kartu mahasiswa

        applyFilterBtn.addEventListener('click', () => {
            const selectedJurusan = jurusanSelect.value.toLowerCase();
            const selectedUniversitas = universitasSelect.value.toLowerCase();
            const selectedStatus = statusSelect.value.toLowerCase();
            const searchTerm = searchInput.value.toLowerCase();

            studentCards.forEach(card => {
                const cardJurusan = card.querySelector(
                    '.student-details table tr:nth-child(1) td:nth-child(2)').textContent.toLowerCase();
                const cardUniversitas = card.querySelector('.student-info p').textContent.toLowerCase();
                const cardStatus = card.querySelector('.status-badge').textContent.toLowerCase();
                const cardName = card.querySelector('.student-info h3').textContent.toLowerCase();

                const matchesJurusan = selectedJurusan === "" || cardJurusan.includes(selectedJurusan);
                const matchesUniversitas = selectedUniversitas === "" || cardUniversitas.includes(
                    selectedUniversitas);
                const matchesStatus = selectedStatus === "" || cardStatus.includes(selectedStatus);
                const matchesName = searchTerm === "" || cardName.includes(searchTerm);

                if (matchesJurusan && matchesUniversitas && matchesStatus && matchesName) {
                    card.style.display = 'flex'; // Tampilkan kartu
                } else {
                    card.style.display = 'none'; // Sembunyikan kartu
                }
            });
        });

        resetFilterBtn.addEventListener('click', () => {
            jurusanSelect.value = "";
            universitasSelect.value = "";
            statusSelect.value = "";
            searchInput.value = "";
            studentCards.forEach(card => {
                card.style.display = 'flex'; // Tampilkan semua kartu
            });
        });

        // Contoh untuk tombol Manage, Terima, Tolak (aksi sederhana)
        studentCards.forEach(card => {
            card.querySelector('.btn-terima').addEventListener('click', () => {
                const studentName = card.querySelector('.student-info h3').textContent;
                alert(`Mahasiswa ${studentName} Diterima! (Aksi nyata akan memerlukan backend)`);
                // Di sini Anda akan mengirim request ke backend untuk mengubah status
            });

            card.querySelector('.btn-manage').addEventListener('click', () => {
                const studentName = card.querySelector('.student-info h3').textContent;
                alert(
                    `Mengelola Mahasiswa ${studentName}. (Aksi nyata akan navigasi ke halaman detail atau modal)`);
                // Di sini Anda akan navigasi ke halaman detail atau menampilkan modal
            });

            card.querySelector('.btn-tolak').addEventListener('click', () => {
                const studentName = card.querySelector('.student-info h3').textContent;
                if (confirm(`Anda yakin ingin Menolak Mahasiswa ${studentName}?`)) {
                    alert(`Mahasiswa ${studentName} Ditolak. (Aksi nyata akan memerlukan backend)`);
                    // Di sini Anda akan mengirim request ke backend untuk mengubah status
                    card.style.display = 'none'; // Sembunyikan kartu setelah ditolak
                }
            });
        });

        // Untuk navigasi sidebar (misalnya, menyorot menu aktif)
        const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // e.preventDefault(); // Nonaktifkan jika ingin navigasi sebenarnya
                sidebarLinks.forEach(item => item.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>
