# Perbaikan Link Login/Register Pemohon (Portal Publik)

## Tujuan
Memindahkan link yang dipakai **Pemohon (publik)** dari grup route **Admin** (`auth/*`) ke grup route **Pemohon** (`user/*`) yang benar.

- `auth/register` → **tidak ada route-nya** (menghasilkan 404).
- `auth/login` → mengarah ke **login Admin** (salah untuk pemohon).
- `user/login` dan `user/register` → route Pemohon yang benar (sudah ada, tidak perlu dibuat).

> Proyek ini memakai **CodeIgniter 4**. Kita HANYA mengubah view (file `.php` di `app/Views/`). Tidak ada perubahan route/controller.

## Ringkasan Perubahan (3 baris)

| No | File | Baris | Sebelum | Sesudah |
|----|------|-------|---------|---------|
| 1 | `app/Views/public/home.php` | 282 | `base_url('auth/register')` | `base_url('user/register')` |
| 2 | `app/Views/public/home.php` | 285 | `base_url('auth/login')` | `base_url('user/login')` |
| 3 | `app/Views/public/request/track.php` | 153 | `base_url('auth/login')` | `base_url('user/login')` |

---

## Langkah 1 — `app/Views/public/home.php` (tombol "Ya, Daftar Akun Online")

Cari baris **282**, cari-dan-ganti teks berikut (ganti hanya bagian di dalam `base_url(...)`).

**SEBELUM:**
```php
                    <a href="<?= base_url('auth/register') ?>" class="btn btn-primary-custom py-2">
```

**SESUDAH:**
```php
                    <a href="<?= base_url('user/register') ?>" class="btn btn-primary-custom py-2">
```

## Langkah 2 — `app/Views/public/home.php` (tombol "Sudah punya akun? Masuk")

Cari baris **285** (baris ini berbeda dari baris 282 karena class-nya `btn-outline-primary-custom`).

**SEBELUM:**
```php
                    <a href="<?= base_url('auth/login') ?>" class="btn btn-outline-primary-custom py-2">
```

**SESUDAH:**
```php
                    <a href="<?= base_url('user/login') ?>" class="btn btn-outline-primary-custom py-2">
```

## Langkah 3 — `app/Views/public/request/track.php` (link "Login ke Akun Anda")

Cari baris **153**.

**SEBELUM:**
```php
                                    Ingin melihat detail balasan atau mengunduh lampiran resmi? <a href="<?= base_url('auth/login') ?>" class="fw-bold text-primary">Login ke Akun Anda</a>
```

**SESUDAH:**
```php
                                    Ingin melihat detail balasan atau mengunduh lampiran resmi? <a href="<?= base_url('user/login') ?>" class="fw-bold text-primary">Login ke Akun Anda</a>
```

---

## JANGAN DIUBAH (penting!)
File-file berikut memakai `auth/login` secara **sengaja** untuk **login Admin/Pimpinan**. Biarkan apa adanya:

- `app/Controllers/Auth.php` (`view('auth/login')` dan redirect logout)
- `app/Filters/AdminFilter.php`
- `app/Filters/AuthFilter.php`
- `app/Filters/PimpinanFilter.php`
- `app/Controllers/Admin/Dashboard.php`
- `app/Views/auth/login.php` (form login admin)

Aturannya: **hanya** ubah file di dalam folder `app/Views/public/`.

---

## Verifikasi

### 1. Pastikan tidak ada sisa `auth/*` di folder public
Jalankan di PowerShell (dari root proyek `C:\laragon\www\ppid-kaltara`):

```powershell
Get-ChildItem -Path .\app\Views\public -Recurse -File -Include *.php |
  Select-String -Pattern "base_url\('auth/(login|register)'\)"
```

**Hasil yang benar:** tidak ada output sama sekali (kosong).

### 2. Tes manual di browser
- Buka `http://ppid-kaltara.test/` → buka modal "Pengajuan Permohonan Informasi".
  - Klik **"Ya, Daftar Akun Online"** → harus ke `http://ppid-kaltara.test/user/register` (halaman daftar Pemohon).
  - Klik **"Sudah punya akun? Masuk"** → harus ke `http://ppid-kaltara.test/user/login` (halaman login Pemohon).
- Lacak permohonan tanpa login → pada kotak info, klik **"Login ke Akun Anda"** → harus ke `http://ppid-kaltara.test/user/login`.

### 3. Pastikan login Admin tidak rusak
- Buka `http://ppid-kaltara.test/auth/login` → form login **Admin** harus tetap tampil normal.

---

## Checklist
- [ ] Langkah 1 selesai (home.php:282 → `user/register`)
- [ ] Langkah 2 selesai (home.php:285 → `user/login`)
- [ ] Langkah 3 selesai (track.php:153 → `user/login`)
- [ ] Verifikasi grep kosong
- [ ] Tes 3 link di browser OK
- [ ] Login admin masih normal

## Rollback (jika perlu)
Kembalikan `user/register` → `auth/register` dan `user/login` → `auth/login` pada 3 baris di atas, atau `git checkout -- app/Views/public/home.php app/Views/public/request/track.php`.
