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
* Pergi ke repository [project-web-magang](https://github.com/VocIntern/project-web-magang.git)
* Pindah Branch dulu ke branch [landing_page](https://github.com/VocIntern/project-web-magang/tree/landingpage)
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
