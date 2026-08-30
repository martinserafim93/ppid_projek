# Portal PPID Kanwil Kemenag Kaltara

Aplikasi Sistem Informasi Layanan PPID (Pejabat Pengelola Informasi dan Dokumentasi) untuk Kantor Wilayah Kementerian Agama Provinsi Kalimantan Utara.

## Fitur Utama
- **Portal Publik**: Halaman profil, standar layanan, layanan informasi publik, infografis, regulasi, dokumen SOP, statistik, dan tracking tiket permohonan.
- **Portal Pemohon**: Registrasi mandiri, pengajuan permohonan informasi, lacak tiket, riwayat permohonan, pengajuan keberatan, dan survei kepuasan.
- **Portal Pimpinan**: Dashboard analitik (Chart.js), monitoring seluruh tiket permohonan, dan hasil survei kepuasan.
- **Portal Admin**: Manajemen dinamis halaman statis (WYSIWYG), manajemen regulasi, informasi publik, dokumen, user, pengaturan website, serta pengelolaan permohonan masyarakat.

## Requirements
- **PHP** >= 8.1 (Disarankan 8.3+)
- **MySQL** >= 8.0
- **Composer** (untuk dependensi PHP)
- **Ext-intl**, **Ext-mbstring**, **Ext-gd** (Aktifkan di `php.ini`)

## Installation
1. Clone repositori ini:
   ```bash
   git clone <url-repo>
   cd ppid-kaltara
   ```
2. Install dependensi dengan composer:
   ```bash
   composer install
   ```
3. Copy file `.env` dan konfigurasi database:
   ```bash
   cp env .env
   # Buka .env, ubah CI_ENVIRONMENT = development
   # Konfigurasikan database pada [database.default]
   ```
4. Jalankan migrasi tabel database:
   ```bash
   php spark migrate
   ```
5. Jalankan master seeder untuk mengisi data awal:
   ```bash
   php spark db:seed DatabaseSeeder
   ```
6. Jalankan server lokal:
   ```bash
   php spark serve
   ```
   Atau jika menggunakan Laragon, akses `http://ppid-kaltara.test`.

## Default Login
*Setelah menjalankan seeder, akun default yang dapat digunakan adalah:*

- **Admin**
  - Email: `admin@ppid-kaltara.go.id`
  - Password: `admin` atau `admin123`
- **Pimpinan**
  - Email: `pimpinan@ppid-kaltara.go.id`
  - Password: `pimpinan123`

## Tech Stack
- [CodeIgniter 4](https://codeigniter.com/) - Backend Framework
- MySQL - Database
- Bootstrap 5 - Frontend Framework
- Chart.js - Data Visualization
- Summernote - WYSIWYG Editor

---
*Pengembangan oleh Tim IT PPID Kanwil Kemenag Provinsi Kalimantan Utara.*
