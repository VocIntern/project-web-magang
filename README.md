# VocIntern - Web Magang Project

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)

Platform manajemen magang untuk menghubungkan mahasiswa D1,D2,D3, dan D4 di perguruan tinggi (Vokasi) dengan perusahaan mitra.

## 🚀 Fitur Utama
- Registrasi pengguna (Mahasiswa/Perusahaan/Admin)
- Pencarian perusahaan mitra magang
- Manajemen aplikasi magang
- Tracking progress magang
- Sistem notifikasi terintegrasi
- Dashboard analitik untuk admin
- Pembuatan laporan magang otomatis


## 🗃️ Entity Relationship Diagram (ERD) - Sistem Magang Mahasiswa

Dokumen ini berisi penjelasan mengenai struktur basis data sistem magang yang dirancang untuk menghubungkan mahasiswa dengan perusahaan.


### 📌 Daftar Entitas

- <span style="background:#f0f0f0;border-radius:6px;padding:4px 8px;font-family:monospace;">users</span>  
  Menyimpan data akun untuk semua pengguna, termasuk admin, mahasiswa, dan perusahaan.

- <span style="background:#f0f0f0;border-radius:6px;padding:4px 8px;font-family:monospace;">mahasiswa</span>  
  Menyimpan data detail mahasiswa yang mendaftar magang.

- <span style="background:#f0f0f0;border-radius:6px;padding:4px 8px;font-family:monospace;">perusahaan</span>  
  Menyimpan informasi perusahaan penyedia magang.

- <span style="background:#f0f0f0;border-radius:6px;padding:4px 8px;font-family:monospace;">magang</span>  
  Menyimpan informasi lowongan magang dari perusahaan.

- <span style="background:#f0f0f0;border-radius:6px;padding:4px 8px;font-family:monospace;">pendaftaran_magang</span>  
  Menyimpan data pendaftaran mahasiswa terhadap lowongan magang tertentu.

- <span style="background:#f0f0f0;border-radius:6px;padding:4px 8px;font-family:monospace;">laporan</span>  
  Menyimpan laporan mingguan kegiatan mahasiswa selama masa magang.

---

### 🧭 Struktur Relasi

Berikut adalah hubungan antar entitas dalam sistem:

- `users` ➝ satu ke satu dengan `mahasiswa` dan `perusahaan`
- `perusahaan` ➝ satu ke banyak `magang`
- `mahasiswa` ➝ banyak ke banyak `magang` (melalui `pendaftaran_magang`)
- `pendaftaran_magang` ➝ satu ke banyak `laporan`

---

### 🖼️ Diagram ERD

Berikut adalah diagram visual dari hubungan entitas:

![VocIntern_ERD](https://github.com/user-attachments/assets/51e2f9d9-5ee7-4a22-b50f-bf2004c007cd)



## 💻 Teknologi yang Digunakan
- **Frontend**: Bootstrap 5, jQuery, HTML5, CSS3
- **Backend**: Laravel 12.x
- **Database**: MySQL
- **Tools**: Composer, npm, Git


## 📥 Instalasi


### Prasyarat
- PHP 8.2+
- Composer
- Node.js 16.x+
- MySQL

### Langkah-langkah
* Pergi ke repository [project-web-magang(branch:landing_page)](https://github.com/VocIntern/project-web-magang/tree/landingpage)

1. Clone repository:
   ```bash
   git clone https://github.com/VocIntern/project-web-magang.git
   cd vocintern
   
2. Install dependencies:
    ```bash
    composer install
    npm install
3. Salin file environment:
    ```bash
    cp .env.example .env
4. Generate app key:
   ```bash
   php artisan key:generate
  
5. Konfigurasi database di .env:
   ```env
   DB_DATABASE=vocintern_db
   DB_USERNAME=root
   DB_PASSWORD=
  
6. Migrasi database:
   ```bash
   php artisan migrate --seed
  
7. Jalankan server:
   ```bash
   php artisan serve
   npm run dev
