<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOCintern - Seleksi Mahasiswa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <li><a href="{{ route('perusahaan.dashboard') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
                <li><a href="{{ route('perusahaan.magang.index') }}"><i class="fas fa-briefcase"></i> <span>Lowongan Magang</span></a></li>
                <li><a href="{{ route('perusahaan.pendaftar.index') }}"><i class="fas fa-clipboard-list"></i> <span>Pendaftar</span></a></li>
                <li><a href="{{ route('perusahaan.magang-aktif.index') }}"><i class="fas fa-users-cog"></i> <span>Magang Aktif</span></a></li>
                <li><a href="{{ route('perusahaan.seleksi.index') }}" class="active"><i class="fas fa-user-graduate"></i> <span>Seleksi Mahasiswa</span></a></li>
                <li><a href="{{ route('perusahaan.pengaturan') }}"><i class="fas fa-cog"></i> <span>Pengaturan</span></a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <div class="header">
            <h1>Seleksi Mahasiswa</h1>
            <div class="header-right">
                <i class="fas fa-user-circle"></i> {{ $perusahaan->nama_perusahaan }} <i class="fas fa-caret-down"></i>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <div class="number">{{ $totalPelamar }}</div>
                <div class="label">Total Pelamar</div>
            </div>
            <div class="stat-card">
                <div class="number">{{ $menunggueview }}</div>
                <div class="label">Menunggu Review</div>
            </div>
            <div class="stat-card">
                <div class="number">{{ $tahapInterview }}</div>
                <div class="label">Tahap Interview</div>
            </div>
            <div class="stat-card">
                <div class="number">{{ $diterima }}</div>
                <div class="label">Diterima</div>
            </div>
        </div>

        <div class="filter-section">
            <h2>Filter & Pencarian</h2>
            <form method="GET" action="{{ route('perusahaan.seleksi.index') }}">
                <div class="filter-row">
                    <div class="filter-item">
                        <label for="jurusan">Jurusan</label>
                        <select id="jurusan" name="jurusan">
                            <option value="">Semua Jurusan</option>
                            @foreach($jurusanList as $jurusan)
                                <option value="{{ $jurusan }}" {{ request('jurusan') == $jurusan ? 'selected' : '' }}>
                                    {{ $jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-item">
                        <label for="universitas">Universitas</label>
                        <select id="universitas" name="universitas">
                            <option value="">Semua Universitas</option>
                            <option value="Universitas Indonesia" {{ request('universitas') == 'Universitas Indonesia' ? 'selected' : '' }}>Universitas Indonesia</option>
                            <option value="Institut Teknologi Bandung" {{ request('universitas') == 'Institut Teknologi Bandung' ? 'selected' : '' }}>Institut Teknologi Bandung</option>
                            <option value="Institut Teknologi Sepuluh Nopember" {{ request('universitas') == 'Institut Teknologi Sepuluh Nopember' ? 'selected' : '' }}>Institut Teknologi Sepuluh Nopember</option>
                            <option value="Universitas Bina Nusantara" {{ request('universitas') == 'Universitas Bina Nusantara' ? 'selected' : '' }}>Universitas Bina Nusantara</option>
                            <option value="Universitas Gadjah Mada" {{ request('universitas') == 'Universitas Gadjah Mada' ? 'selected' : '' }}>Universitas Gadjah Mada</option>
                            <option value="Universitas Diponegoro" {{ request('universitas') == 'Universitas Diponegoro' ? 'selected' : '' }}>Universitas Diponegoro</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Review</option>
                            <option value="interview" {{ request('status') == 'interview' ? 'selected' : '' }}>Tahap Interview</option>
                            <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label for="cari-nama">Cari Nama</label>
                        <input type="text" id="cari-nama" name="cari_nama" value="{{ request('cari_nama') }}" placeholder="Masukkan nama mahasiswa...">
                    </div>
                </div>
                <div class="filter-buttons">
                    <button type="submit" class="apply-filter">Terapkan Filter</button>
                    <a href="{{ route('perusahaan.seleksi.index') }}" class="reset-filter">Reset Filter</a>
                </div>
            </form>
        </div>

        <div class="student-grid">
            @forelse($pendaftaranMagang as $pendaftaran)
                <div class="student-card" data-id="{{ $pendaftaran->id }}">
                    @php
                        $statusClass = '';
                        $statusText = '';
                        switch($pendaftaran->status) {
                            case 'menunggu':
                                $statusClass = 'review';
                                $statusText = 'Menunggu Review';
                                break;
                            case 'interview':
                                $statusClass = 'interview';
                                $statusText = 'Tahap Interview';
                                break;
                            case 'diterima':
                                $statusClass = '';
                                $statusText = 'Diterima';
                                break;
                            case 'ditolak':
                                $statusClass = 'ditolak';
                                $statusText = 'Ditolak';
                                break;
                        }
                    @endphp
                    
                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                    <div class="student-header">
                        <div class="avatar">
                            {{ substr($pendaftaran->mahasiswa->nama, 0, 2) }}
                        </div>
                        <div class="student-info">
                            <h3>{{ $pendaftaran->mahasiswa->nama }}</h3>
                            <p>{{ $pendaftaran->mahasiswa->user->email ?? 'Email tidak tersedia' }}</p>
                        </div>
                    </div>
                    <div class="student-details">
                        <table>
                            <tr>
                                <td>Jurusan:</td>
                                <td>{{ $pendaftaran->mahasiswa->jurusan }}</td>
                            </tr>
                            <tr>
                                <td>Semester:</td>
                                <td>{{ $pendaftaran->mahasiswa->semester }}</td>
                            </tr>
                            <tr>
                                <td>NIM:</td>
                                <td>{{ $pendaftaran->mahasiswa->nim }}</td>
                            </tr>
                            <tr>
                                <td>Posisi:</td>
                                <td>{{ $pendaftaran->magang->judul }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="skills-tags">
                        @if($pendaftaran->mahasiswa->bio)
                            @php
                                // Simulasi ekstrak skills dari bio - di implementasi nyata bisa pakai field terpisah
                                $skills = ['Web Development', 'Database', 'Framework'];
                            @endphp
                            @foreach($skills as $skill)
                                <span class="skill-tag">{{ $skill }}</span>
                            @endforeach
                        @endif
                    </div>
                    <div class="card-actions">
                        <button class="btn-terima" onclick="updateStatus({{ $pendaftaran->id }}, 'diterima')">Terima</button>
                        <button class="btn-manage" onclick="showDetail({{ $pendaftaran->id }})">Manage</button>
                        <button class="btn-tolak" onclick="updateStatus({{ $pendaftaran->id }}, 'ditolak')">Tolak</button>
                    </div>
                </div>
            @empty
                <div class="no-data">
                    <p>Belum ada mahasiswa yang mendaftar.</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Modal untuk detail mahasiswa -->
    <div id="detailModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modalBody">
                <!-- Content akan diisi melalui AJAX -->
            </div>
        </div>
    </div>

    <script>
        // Setup CSRF token untuk AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Fungsi untuk update status
        function updateStatus(pendaftaranId, status) {
            let confirmMessage = status === 'diterima' ? 'Terima mahasiswa ini?' : 'Tolak mahasiswa ini?';
            
            if (confirm(confirmMessage)) {
                fetch(`/perusahaan/seleksi-mahasiswa/${pendaftaranId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        status: status,
                        catatan: null
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses permintaan');
                });
            }
        }

        // Fungsi untuk menampilkan detail mahasiswa
        function showDetail(pendaftaranId) {
            window.open(`/perusahaan/seleksi-mahasiswa/${pendaftaranId}/detail`, '_blank');
        }

        // Untuk navigasi sidebar (menyorot menu aktif)
        const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Hanya prevent default jika tidak ada href yang valid
                if (this.getAttribute('href') === '#') {
                    e.preventDefault();
                }
                sidebarLinks.forEach(item => item.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>