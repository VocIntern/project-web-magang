<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <title>{{ config('app.name', 'VocIntern') }} - Daftar</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
    <div class="container-fluid register-container">

        <div class="register-card">
            <div class="text-left pe-5 position-absolute">
                <a href="{{ route('welcome') }}" class="btn">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <!-- Header -->
            <div class="register-header">
                <h1>VocIntern</h1>
                <p class="definisi">Platform Magang Khusus Mahasiswa Vokasi USU</p>
            </div>

            <!-- Body -->
            <div class="register-body">

                <!-- Role Selector -->
                <div class="role-selector">
                    <button type="button" class="role-btn active" data-role="mahasiswa">
                        Mahasiswa
                    </button>
                    <button type="button" class="role-btn" data-role="perusahaan">
                        Perusahaan
                    </button>
                </div>

                <h3 class="text-center mb-4" id="form-title">Daftar Sebagai Mahasiswa</h3>

                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <!-- Form Mahasiswa -->
                <form id="mahasiswaForm" method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="role" value="mahasiswa">

                    <div class="mb-3">
                        <label for="nama_mahasiswa" class="form-label">Nama Lengkap</label>
                        <div class="input-group">

                            <input type="text" class="form-control" name="nama" id="nama_mahasiswa"
                                value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email_mahasiswa" class="form-label">Email</label>
                        <div class="input-group">

                            <input type="email" class="form-control" name="email" id="email_mahasiswa"
                                value="{{ old('email') }}" placeholder="Masukkan email anda" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_mahasiswa" class="form-label">Kata Sandi</label>
                        <div class="input-group position-relative">
                            <input type="password" class="form-control" name="password" id="password_mahasiswa"
                                placeholder="Buat kata sandi (min. 8 karakter)" required>
                            <span class="toggle-password" onclick="togglePassword('password_mahasiswa')">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-4 ">
                        <label for="password_confirmation_mahasiswa" class="form-label">Konfirmasi Kata Sandi</label>
                        <div class="input-group position-relative">

                            <input type="password" class="form-control" name="password_confirmation"
                                id="password_confirmation_mahasiswa" placeholder="Konfirmasi kata sandi" required>
                            <span class="toggle-password" onclick="togglePassword('password_confirmation_mahasiswa')">
                                <i class="fas fa-eye-slash"></i>
                            </span>

                        </div>
                        <small id="passwordMatchMessage_mahasiswa" class="text-danger mt-2"
                            style="display: none;">Password
                            tidak cocok</small>
                        <small id="passwordMatchSuccess_mahasiswa" class="text-success mt-2" style="display: none;">
                            Password cocok
                        </small>
                    </div>

                    <button type="submit" class="btn btn-register w-100 mb-3">Daftar sebagai Mahasiswa</button>
                </form>

                <!-- Form Perusahaan -->
                <form id="perusahaanForm" method="POST" action="{{ route('register') }}" style="display: none;">
                    @csrf
                    <input type="hidden" name="role" value="perusahaan">

                    <div class="mb-3">
                        <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                        <div class="input-group">

                            <input type="text" class="form-control" name="nama_perusahaan" id="nama_perusahaan"
                                value="{{ old('nama_perusahaan') }}" placeholder="Masukkan nama perusahaan" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nama_pendaftar" class="form-label">Nama Pendaftar (PIC)</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="nama_pendaftar" id="nama_pendaftar"
                                value="{{ old('nama_pendaftar') }}" placeholder="Nama person in charge" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email_perusahaan" class="form-label">Email Perusahaan</label>
                        <div class="input-group">

                            <input type="email" class="form-control" name="email" id="email_perusahaan"
                                value="{{ old('email') }}" placeholder="Email perusahaan" required>
                        </div>
                    </div>

                    <div class="mb-3 ">
                        <label for="password_perusahaan" class="form-label">Kata Sandi</label>
                        <div class="input-group position-relative">

                            <input type="password" class="form-control" name="password" id="password_perusahaan"
                                placeholder="Buat kata sandi (min. 8 karakter)" required>
                            <span class="toggle-password" onclick="togglePassword('password_perusahaan')">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation_perusahaan" class="form-label">Konfirmasi Kata Sandi</label>
                        <div class="input-group position-relative">

                            <input type="password" class="form-control" name="password_confirmation"
                                id="password_confirmation_perusahaan" placeholder="Konfirmasi kata sandi" required>
                            <span class="toggle-password"
                                onclick="togglePassword('password_confirmation_perusahaan')">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>
                        <small id="passwordMatchMessage_perusahaan" class="text-danger mt-1"
                            style="display: none;">Password tidak
                            cocok</small>
                        <small id="passwordMatchSuccess_perusahaan" class="text-success mt-1" style="display: none;">
                            Password cocok
                        </small>
                    </div>

                    <button type="submit" class="btn btn-register w-100 mb-3">Daftar sebagai Perusahaan</button>

                </form>
                <div class="d-flex justify-content-end mb-3">
                    <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Masuk
                            Sekarang</a>
                    </p>
                </div>

                <!-- Divider -->
                <div class="divider">
                    <span>atau daftar dengan</span>
                </div>

                <!-- Social Login -->
                <div class="social-login">
                    <a href="#" class="btn-google">
                        <i class="fab fa-google"></i>
                        Google
                    </a>
                    <a href="#" class="btn-facebook">
                        <i class="fab fa-facebook-f"></i>
                        Facebook
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">

                <small class="text-muted d-block mt-1">© 2025 VocIntern - Platform Magang. All rights reserved.</small>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Role Selector Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleButtons = document.querySelectorAll('.role-btn');
            const mahasiswaForm = document.getElementById('mahasiswaForm');
            const perusahaanForm = document.getElementById('perusahaanForm');
            const formTitle = document.getElementById('form-title');

            roleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    console.log('Button clicked:', this.getAttribute('data-role'));

                    // Hapus class 'active' dari semua tombol
                    roleButtons.forEach(btn => btn.classList.remove('active'));

                    // Tambahkan class 'active' ke tombol yang diklik
                    this.classList.add('active');

                    const role = this.getAttribute('data-role');

                    // Tampilkan form sesuai role
                    if (role === 'mahasiswa') {
                        console.log('Menampilkan form mahasiswa');
                        mahasiswaForm.style.display = 'block';
                        perusahaanForm.style.display = 'none';
                        formTitle.textContent = 'Daftar Sebagai Mahasiswa';
                    } else if (role === 'perusahaan') {
                        console.log('Menampilkan form perusahaan');
                        mahasiswaForm.style.display = 'none';
                        perusahaanForm.style.display = 'block';
                        formTitle.textContent = 'Daftar Sebagai Perusahaan';
                    }
                });
            });


        });

        document.addEventListener('DOMContentLoaded', function() {
            function checkPasswordMatch(prefix) {
                const passwordInput = document.getElementById(`password_${prefix}`);
                const confirmPasswordInput = document.getElementById(`password_confirmation_${prefix}`);
                const errorMsg = document.getElementById(`passwordMatchMessage_${prefix}`);
                const successMsg = document.getElementById(`passwordMatchSuccess_${prefix}`);
                const submitBtn = document.querySelector(`#${prefix}Form button[type="submit"]`);

                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                // Jika dua-duanya kosong, jangan tampilkan apa-apa
                if (confirmPassword === "") {
                    errorMsg.style.display = 'none';
                    successMsg.style.display = 'none';
                    submitBtn.disabled = false;
                    return;
                }

                if (password !== confirmPassword) {
                    errorMsg.style.display = 'block';
                    successMsg.style.display = 'none';
                    submitBtn.disabled = true;
                } else {
                    errorMsg.style.display = 'none';
                    successMsg.style.display = 'block';
                    submitBtn.disabled = false;
                }
            }

            ['mahasiswa', 'perusahaan'].forEach(prefix => {
                const password = document.getElementById(`password_${prefix}`);
                const confirmPassword = document.getElementById(`password_confirmation_${prefix}`);

                if (password && confirmPassword) {
                    password.addEventListener('input', () => checkPasswordMatch(prefix));
                    confirmPassword.addEventListener('input', () => checkPasswordMatch(prefix));
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Ambil parameter 'role' dari URL
            const urlParams = new URLSearchParams(window.location.search);
            const roleParam = urlParams.get('role');

            // Fungsi untuk mengubah tampilan form berdasarkan role
            function switchRole(role) {
                const mahasiswaBtn = document.querySelector('.role-btn[data-role="mahasiswa"]');
                const perusahaanBtn = document.querySelector('.role-btn[data-role="perusahaan"]');
                const mahasiswaForm = document.getElementById('mahasiswaForm');
                const perusahaanForm = document.getElementById('perusahaanForm');
                const formTitle = document.getElementById('form-title');

                // Reset semua button dan form
                mahasiswaBtn.classList.remove('active');
                perusahaanBtn.classList.remove('active');
                mahasiswaForm.style.display = 'none';
                perusahaanForm.style.display = 'none';

                // Tampilkan form sesuai role yang dipilih
                if (role === 'perusahaan') {
                    perusahaanBtn.classList.add('active');
                    perusahaanForm.style.display = 'block';
                    formTitle.textContent = 'Daftar Sebagai Perusahaan';
                } else {
                    // Default ke mahasiswa
                    mahasiswaBtn.classList.add('active');
                    mahasiswaForm.style.display = 'block';
                    formTitle.textContent = 'Daftar Sebagai Mahasiswa';
                }
            }

            // Jika ada parameter role di URL, langsung switch ke role tersebut
            if (roleParam) {
                switchRole(roleParam);
            }

            // Event listener untuk button role selector (untuk interaksi manual)
            document.querySelectorAll('.role-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const selectedRole = this.getAttribute('data-role');
                    switchRole(selectedRole);

                    // Update URL tanpa reload halaman (opsional)
                    const newUrl = new URL(window.location);
                    newUrl.searchParams.set('role', selectedRole);
                    window.history.replaceState(null, '', newUrl);
                });
            });
        });


        function togglePassword(id) {
            const input = document.getElementById(id);
            const span = input.parentElement.querySelector('.toggle-password');
            const icon = span.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }
    </script>
</body>

</html>
