# Panduan LEMP dengan PHP 8.5, PostgreSQL, dan Nginx di Docker

Setup pengganti LAMP untuk belajar Docker. Container terpisah: **Nginx** (web server), **PHP-FPM** (pemroses PHP), **PostgreSQL** (database), **Adminer** (GUI database). Setiap file ditulis lengkap — tinggal copy-paste dan dijalankan.

## Prasyarat

1. **Docker Desktop** - [Download](https://www.docker.com/products/docker-desktop)
2. **Git Bash** atau **WSL2** di Windows - untuk perintah terminal
3. **Code editor** - VS Code, PHPStorm, atau lainnya

Pastikan Docker berjalan:

```bash
docker --version
docker compose version
```

> Jika `docker compose version` error, cek kembali instalasi Docker Desktop. Kita pakai perintah `docker compose` (v2+), bukan `docker-compose` (yang lama).

## Konsep Penting: Kenapa LEMP Beda dengan LAMP

Di LAMP, **Apache** mengeksekusi PHP langsung sebagai modul (satu container `php:7.4-apache`). Di LEMP, Nginx **tidak bisa** menjalankan PHP — Nginx hanya bisa serve file statis. Karena itu PHP jalan di process manager sendiri bernama **PHP-FPM**, di container terpisah.

```text
Browser (localhost:8080)
      │
      ▼
┌─────────────┐
│   nginx     │  port 80 (di-mapping ke 8080)
│  serve CSS/JS/img
│  file .php → diteruskan   ───────────┐
└─────────────┘                        │ fastcgi protocol (port 9000)
                                       ▼
                              ┌─────────────────┐
                              │  php-fpm (app)  │  container "app"
                              │  eksekusi PHP   │
                              └─────────────────┘
                                       │ PDO
                                       ▼
                              ┌─────────────────┐
                              │  PostgreSQL (db)│  container "db"
                              └─────────────────┘
```

Karena 2 container terpisah, folder kode (`src/`) harus **di-mount di keduanya**: nginx butuh akses file statis, fpm butuh akses file PHP untuk dieksekusi.

## Struktur Proyek Final

Buat folder baru di samping setup LAMP lama (jangan di dalamnya):

```
lemp-php8-docker/
├── docker-compose.yml
├── php/
│   ├── Dockerfile
│   └── php.ini
├── nginx/
│   └── default.conf
└── src/
    ├── index.php
    └── phpinfo.php
```

Mari buat langkah demi langkah.

## Langkah 1: Buat Folder Proyek

```bash
cd /c/Project   # ganti dengan folder tempat proyek Anda disimpan
mkdir lemp-php8-docker
cd lemp-php8-docker
mkdir php nginx src
```

## Langkah 2: File `php/Dockerfile`

Buat file `php/Dockerfile`:

```dockerfile
# PHP 8.5 dengan PHP-FPM (bukan Apache!)
FROM php:8.5-fpm

# === Extension PostgreSQL ===
# libpq-dev adalah client library PostgreSQL, PRASYARAT untuk pgsql & pdo_pgsql
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# === Dependency untuk GD (opsional, hanya jika butuh image processing) ===
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy custom php.ini
COPY php.ini /usr/local/etc/php/conf.d/custom.ini
```

**Penjelasan:**

1. **`FROM php:8.5-fpm`** — Image resmi PHP-FPM. Di LAMP kita pakai `php:7.4-apache`; sekarang 2 hal berubah: versi (8.5) dan SAPI (fpm).
2. **`libpq-dev`** — Wajib. Tanpa ini `docker-php-ext-install pdo_pgsql` gagal karena library PostgreSQL tidak ada.
3. **`docker-php-ext-install pdo_pgsql pgsql`** — Dua extension untuk koneksi PostgreSQL. Perhatikan **tidak ada `pdo`** di daftar: PDO sudah tersedia bawaan, dan mencoba meng-install-nya terpisah justru error. `pdo_pgsql` otomatis menyalakan dukungan PDO-nya.
4. **GD** — Opsional, sama seperti di panduan LAMP. Bisa dihapus blok ini jika tidak butuh image processing.
5. **`a2enmod rewrite` TIDAK ADA** — Tidak ada Apache di sini. URL rewriting ditangani Nginx di `default.conf` (Langkah 4).

## Langkah 3: File `php/php.ini`

Buat file `php/php.ini` — identik dengan yang dulu:

```ini
memory_limit = 256M
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
date.timezone = Asia/Makassar
display_errors = On
error_reporting = E_ALL
```

File ini di-copy oleh Dockerfile ke path yang sama seperti sebelumnya, jadi isi dari setup LAMP lama bisa langsung dipakai tanpa ubahan.

## Langkah 4: File `nginx/default.conf`

Buat file `nginx/default.conf` — ini perbedaan terbesar dari LAMP:

```nginx
server {
    listen 80;
    server_name localhost;

    root /var/www/html;
    index index.php index.html;

    # Pengganti mod_rewrite / .htaccess (tidak berlaku di Nginx)
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # File .php diteruskan ke PHP-FPM
    location ~ \.php$ {
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

**Penjelasan per baris:**

1. **`root /var/www/html`** — Document root. Harus cocok dengan mount `./src` di docker-compose.
2. **`try_files $uri $uri/ /index.php?$query_string`** — Coba file asli, lalu folder, terakhir fallback ke `index.php`. Ini pengganti sistem `.htaccess` Apache + `mod_rewrite` — krusial untuk router framework seperti Laravel. **Di Nginx, file `.htaccess` diabaikan total.**
3. **`location ~ \.php$`** — Setiap request yang berakhiran `.php` masuk blok ini.
4. **`fastcgi_pass app:9000`** — Tujuan forward. `app` = nama service PHP-FPM di docker-compose, `9000` = port default FPM. **Nama ini WAJIB sama persis dengan nama service di compose**, kalau tidak error 502.
5. **`fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name`** — Memberi tahu FPM file mana yang dieksekusi. **Baris ini paling sering jadi sumber error**; jika hilang, kita dapat error "File not found" / "Primary script unknown", karena FPM tidak tahu file PHP mana yang harus dijalankan.

## Langkah 5: File `docker-compose.yml`

Buat file `docker-compose.yml`:

```yaml
services:
  app:
    build: ./php
    container_name: php85-fpm
    volumes:
      - ./src:/var/www/html
    depends_on:
      - db
    networks:
      - lemp-network

  nginx:
    image: nginx:stable-alpine
    container_name: nginx
    ports:
      - "8080:80"
    volumes:
      - ./src:/var/www/html
      - ./nginx/default.conf:/etc/nginx/conf.d/default.conf:ro
    depends_on:
      - app
    networks:
      - lemp-network

  db:
    image: postgres:18
    container_name: postgres-18
    ports:
      - "5432:5432"
    environment:
      POSTGRES_DB: learn_php
      POSTGRES_USER: matrix
      POSTGRES_PASSWORD: user1234
    volumes:
      - postgres_data:/var/lib/postgresql
    networks:
      - lemp-network

  adminer:
    image: adminer:latest
    container_name: adminer
    ports:
      - "8081:8080"
    environment:
      ADMINER_DEFAULT_SERVER: db
    depends_on:
      - db
    networks:
      - lemp-network

volumes:
  postgres_data:

networks:
  lemp-network:
    driver: bridge
```

**Penjelasan service:**

1. **`app`** — PHP-FPM.
   - `build: ./php` — bangun sendiri dari Dockerfile kita.
   - Mount `./src` ke `/var/www/html` (FPM membaca file PHP dari sini).
   - **Tidak ada `ports`** — container ini tidak perlu diakses dari luar; nginx saja yang perlu. Komunikasi nginx↔fpm lewat network internal port 9000. Ini konsep penting: hanya service yang perlu diakses dari host yang punya `ports`.

2. **`nginx`** — Web server luar.
   - **Dua mount** di sini: `./src` (biar nginx bisa serve file statis) **dan** `default.conf` (konfigurasi kita).
   - `:ro` = read-only untuk file config, mencegah Nginx mengubahnya.
   - `ports: "8080:80"` — satu-satunya jalan masuk dari browser.
   - Pakai `nginx:stable-alpine` langsung tanpa Dockerfile sendiri — tidak perlu customisasi.

3. **`db`** — PostgreSQL 18.
   - Variabel environment-nya **beda nama** dengan MariaDB/MySQL. `MYSQL_*` → `POSTGRES_*`.
   - Port **5432** (bukan 3306).
   - Data persisten di volume `postgres_data`.

4. **`adminer`** — GUI database. Adminer sudah support PostgreSQL; nanti tinggal pilih "PostgreSQL" saat login.

## Langkah 6: File PHP Test

Buat `src/index.php` — test koneksi ke PostgreSQL dengan PDO:

```php
<?php
echo "<h1>LEMP Docker Jalan!</h1>" . PHP_EOL;
echo "<p>PHP Version: " . phpversion() . "</p>" . PHP_EOL;

// Test koneksi PostgreSQL via PDO
try {
    $pdo = new PDO(
        'pgsql:host=db;port=5432;dbname=learn_php',
        'matrix',
        'user1234'
    );
    echo "<p>PostgreSQL Connection SUCCESS!</p>" . PHP_EOL;
    echo "<p>PostgreSQL Version: " . $pdo->query('SELECT version()')->fetchColumn() . "</p>" . PHP_EOL;
} catch (PDOException $e) {
    echo "<p>PostgreSQL Connection FAILED: " . $e->getMessage() . "</p>" . PHP_EOL;
}

echo '<p><a href="phpinfo.php">View PHP Info</a></p>' . PHP_EOL;
```

Buat juga `src/phpinfo.php`:

```php
<?php
phpinfo();
```

**Perbedaan dari versi LAMP:**
- `new mysqli(...)` → `new PDO('pgsql:host=db;port=5432;dbname=...', user, pass)`
- DSN `pgsql:` dengan parameter `host`, `port`, `dbname`
- `host=db` = nama service di docker-compose, sama seperti dulu (`host=db` di LAMP untuk MariaDB)
- Username `matrix`, password `user1234`, database `learn_php` — diambil dari variabel `POSTGRES_*` di compose

## Menjalankan LEMP Stack

1. **Build image PHP-FPM** (pertama kali atau setelah edit Dockerfile):

```bash
docker compose build app
```

Atau tanpa cache jika build aneh:

```bash
docker compose build --no-cache app
```

2. **Start semua service**:

```bash
docker compose up -d
```

> `-d` = detach (background). Docker akan download image nginx, postgres, adminer, dan build image PHP.

3. **Cek status**:

```bash
docker compose ps
```

Semua container harus `Up`:

```text
NAME          IMAGE                    COMMAND                SERVICE   STATUS         PORTS
adminer       adminer:latest           "entrypoint.sh dock…"  adminer   Up X minutes   0.0.0.0:8081->8080/tcp
nginx         nginx:stable-alpine      ...                    nginx     Up X minutes   0.0.0.0:8080->80/tcp
php85-fpm     lemp-php8-docker-app     ...                    app       Up X minutes   80/tcp
postgres-18   postgres:18              ...                    db        Up X minutes   0.0.0.0:5432->5432/tcp
```

4. **Verifikasi extension PostgreSQL**:

```bash
docker compose exec app php -m | grep -E "(pdo_pgsql|pgsql|gd)"
```

Output:

```text
PDO
pdo_pgsql
pgsql
gd
```

5. **Akses aplikasi**:
   - Web: http://localhost:8080
   - Adminer: http://localhost:8081

6. **Login Adminer** (http://localhost:8081):
   - System: **PostgreSQL**
   - Server: `db`
   - Username: `matrix`
   - Password: `user1234`
   - Database: `learn_php`

### Masuk ke PostgreSQL via CLI (psql)

Selain Adminer (GUI), PostgreSQL bisa diakses langsung dari terminal via **psql** — klien CLI bawaan PostgreSQL.

> PostgreSQL tidak punya user "root". Superuser-nya adalah role yang ditentukan di `POSTGRES_USER` saat pertama kali database di-inisialisasi. Di setup ini, superuser-nya adalah **`matrix`**.

**Masuk interaktif ke database:**

```bash
docker compose exec db psql -U matrix -d learn_php
```

Jika berhasil, muncul prompt:

```text
psql (18.4)
Type "help" for help.

learn_php=#
```

Ketik `\q` untuk keluar dari psql.

**Alternatif dari host** (jika `psql` terinstall di Windows):

```bash
psql -h localhost -p 5432 -U matrix -d learn_php
# password: user1234
```

**Perintah dasar psql:**

| Perintah | Fungsi |
|---|---|
| `\l` | Daftar semua database |
| `\c nama_db` | Pindah ke database lain |
| `\dt` | Daftar semua tabel di database aktif |
| `\du` | Daftar semua user/role |
| `\dn` | Daftar semua schema |
| `\d nama_tabel` | Struktur kolom suatu tabel |
| `\q` | Keluar dari psql |

**Contoh query:**

```sql
-- Versi PostgreSQL
SELECT version();

-- Cari tabel yang ada
\dt

-- Lihat semua user
\du

-- Buat tabel contoh
CREATE TABLE mahasiswa (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    nim VARCHAR(20) UNIQUE NOT NULL,
    jurusan VARCHAR(50)
);

-- Insert data
INSERT INTO mahasiswa (nama, nim, jurusan) VALUES
('Budi Santoso', '2024001', 'Teknik Informatika'),
('Siti Aminah', '2024002', 'Sistem Informasi');

-- Tampilkan data
SELECT * FROM mahasiswa;
```

**Tanpa masuk interaktif** (one-liner, berguna untuk script/CI):

```bash
docker compose exec db psql -U matrix -d learn_php -c "SELECT version();"
```

### Mode Root / Superuser di PostgreSQL

PostgreSQL tidak punya user "root" seperti di Linux. Yang ada adalah role **superuser** — role yang punya hak penuh atas seluruh database cluster. Di setup ini, superuser-nya adalah **`matrix`** (dari `POSTGRES_USER` di `docker-compose.yml`).

Saat Anda masuk psql dengan `-U matrix`, Anda **sudah berada di mode superuser**.

**Cek role saat ini:**

```sql
SELECT current_user;    -- role yang sedang aktif
SELECT session_user;    -- role asli sesi ini
```

**Buat superuser baru** (opsional, jika ingin role terpisah):

```sql
CREATE ROLE root WITH SUPERUSER LOGIN PASSWORD 'password123';
```

Setelah itu bisa login dengan: `docker compose exec db psql -U root -d learn_php`

**Ganti role dalam sesi yang sudah berjalan:**

```sql
SET ROLE matrix;
SET ROLE root;
```

> **Catatan penting:** role superuser bisa menjalankan apapun — `DROP DATABASE`, `ALTER SYSTEM`, `CREATE ROLE`, dst. Jangan gunakan superuser untuk koneksi aplikasi sehari-hari. Untuk aplikasi, buat role biasa dengan hak akses terbatas:

```sql
CREATE ROLE app_user WITH LOGIN PASSWORD 'apppass123';
GRANT CONNECT ON DATABASE learn_php TO app_user;
GRANT USAGE ON SCHEMA public TO app_user;
GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO app_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT SELECT, INSERT, UPDATE, DELETE ON TABLES TO app_user;
```

### Alur Setelah Edit File

Sering ditanyakan pemula — apa yang perlu di-restart/rebuild?

| Yang diubah | Perintah |
|---|---|
| File PHP di `src/` | **Tidak perlu apa-apa.** Folder di-mount, perubahan langsung terlihat. Refresh browser. |
| `php/php.ini` atau `php/Dockerfile` | `docker compose build app && docker compose up -d` (image harus build ulang) |
| `nginx/default.conf` | `docker compose restart nginx` (atau `docker compose exec nginx nginx -s reload`) |

## Perintah Docker Dasar

```bash
# Start services
docker compose up -d

# Stop services (data aman di volume)
docker compose stop

# Stop dan hapus containers (data tetap di volume)
docker compose down

# HAPUS containers sekaligus SEMUA data volume Database
docker compose down -v --rmi all

# Lihat logs
docker compose logs nginx
docker compose logs -f app        # follow (real-time)

# Masuk ke container
docker compose exec app bash
docker compose exec db psql -U matrix -d learn_php   # masuk psql

# Jalankan query cepat
docker compose exec db psql -U matrix -d learn_php -c "SELECT 1;"

# Restart service tertentu
docker compose restart nginx

# Build image ulang
docker compose build app

# Debug konfigurasi compose (lihat hasil parsing YAML)
docker compose config
```

## Troubleshooting

### 1. Error 502 Bad Gateway

**Penyebab paling umum di LEMP.** Nginx tidak bisa menjangkau PHP-FPM.

- Nama service di `fastcgi_pass` tidak cocok dengan docker-compose: cek `fastcgi_pass app:9000` → nama service Anda harus `app`.
- Pastikan container `app` hidup: `docker compose ps`
- Cek log: `docker compose logs app`

### 2. Error "File not found" / "Primary script unknown" (404)

**Penyebab paling umum kedua.** FPM tidak tahu file mana yang dieksekusi.

- Pastikan baris `fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;` ada di `default.conf`.
- Pastikan `./src` di-mount di container **nginx** — jika hanya di `app`, Nginx tidak menemukan filenya.
- Pastikan `root` di nginx (`/var/www/html`) cocok dengan path mount.

### 3. Port Already in Use (8080, 8081, atau 5432 dipakai program lain)

Ganti port sisi kiri saja:

```yaml
services:
  nginx:
    ports:
      - "8000:80"     # ganti 8080 → 8000
  adminer:
    ports:
      - "8001:8080"
  db:
    ports:
      - "5433:5432"   # ganti 5432 → 5433 (jangan lupa update DSN PHP)
```

### 4. Beda `stop`, `down`, dan `down -v`

- `docker compose stop` → container berhenti, **semua data tetap**.
- `docker compose down` → container dihapus, **volume data tetap**.
- `docker compose down -v` → container **dan volume data dihapus** — data PostgreSQL hilang permanen!

Jika container `db` tidak muncul atau terasa "state" rusak, cek volume lama: `docker volume ls`.

### 5. Password authentication failed (PostgreSQL)

- Pastikan env di compose: `POSTGRES_USER`, `POSTGRES_PASSWORD`, `POSTGRES_DB`.
- **PENTING:** env hanya berlaku saat volume database **pertama kali dibuat**. Jika sudah pernah `up` dengan volume lama, ubah env saja tidak cukup — perlu `docker compose down -v` dulu untuk buat volume baru.
- Di Adminer pastikan System yang dipilih adalah **PostgreSQL**, bukan MySQL/MariaDB.

### 6. Container `app` Crash Loop (restart terus)

```bash
docker compose logs app
```

Cek pesan error (biasanya extension gagal load atau `php.ini` salah format). Memory container bisa dicek dengan `docker stats`.

### 7. Warning "the attribute 'version' is obsolete"

Bukan error. Compose v2+ tidak butuh `version: '3.8'` — hapus baris itu dari `docker-compose.yml`.

### 8. Error "executable file not found in $PATH"

Sintaks `docker compose exec` salah:

```bash
# BENAR - program di dalam container image PostgreSQL bernama "psql"
docker compose exec db psql -U matrix -d learn_php

# SALAH - "db" bukan nama program
docker compose exec db db -U matrix -d learn_php
```

Bentuknya selalu: `docker compose exec <nama-service> <program> <argumen>`.

### 9. Container `db` Exited (1) — Error "in 18+, these Docker images are configured to store database data"

**Khusus PostgreSQL 18+.** Image `postgres:18` menolak start jika volume di-mount di `/var/lib/postgresql/data`. Error lengkapnya:

```text
Error: in 18+, these Docker images are configured to store database data in a
       format which is compatible with "pg_ctlcluster" (specifically, using
       major-version-specific directory names)...

       Counter to that, there appears to be PostgreSQL data in:
         /var/lib/postgresql/data (unused mount/volume)
```

**Penyebab:** Mulai versi 18, PostgreSQL menyimpan data di `/var/lib/postgresql/18/docker` (bukan `/var/lib/postgresql/data` lagi). Mount di `/data` dianggap "unused" karena data tidak akan tertulis ke sana.

**Perbaikan:** Ganti path mount di `docker-compose.yml`:

```yaml
# SALAH (path lama, tidak kompatibel postgres:18)
volumes:
  - postgres_data:/var/lib/postgresql/data

# BENAR (path postgres:18+)
volumes:
  - postgres_data:/var/lib/postgresql
```

Setelah mengubah, rebuild:

```bash
docker compose down
docker volume rm lemp-php8-docker_postgres_data   # hapus volume lama (opsional tapi disarankan)
docker compose up -d
```

> **Tips upgrade:** Jika punya data postgres dari versi 17 ke 18, jangan hanya ganti image — data harus di-upgrade dulu dengan `pg_upgrade`. Untuk project baru, hapus volume lama (`docker compose down -v`) lalu `up -d` dengan mount path yang baru.

## Tips untuk Belajar

1. **Konsep yang wajib dipahami:**
   - Satu container = satu tanggung jawab (nginx hanya serve/forward, fpm hanya eksekusi PHP).
   - Container di satu network saling kenal lewat **nama service**, bukan IP.
   - `ports` hanya untuk membuka akses dari luar ke container tertentu.
   - Volume `-v` di compose andalah yang membuat data bertahan setelah container dihapus.

2. **Cek extension yang tersedia di image:**
   ```bash
   docker compose exec app php -m
   ```

3. **Xdebug (opsional) di Dockerfile:**
   ```dockerfile
   RUN pecl install xdebug && docker-php-ext-enable xdebug
   ```
   ```ini
   ; php/php.ini
   [xdebug]
   xdebug.mode=debug
   xdebug.client_host=host.docker.internal
   xdebug.start_with_request=yes
   ```

4. **Bandingkan dengan setup LAMP Anda:** Lihat `docker-compose.yml` LAMP vs LEMP — service `web` (apache) dipecah jadi 2 service (`app` + `nginx`), environment DB berubah dari `MYSQL_*` ke `POSTGRES_*`, dan `.htaccess` digitalami oleh `try_files`.

## Next Steps

1. **Git version control:**
   ```bash
   git init
   git add .
   git commit -m "Initial LEMP Docker setup"
   ```

2. **Multi-environment:** buat `docker-compose.prod.yml` untuk production (misal versi image yang di-pin, tanpa mount `src`).

3. **Add Redis:** tambah service `redis:alpine` untuk caching.

4. **Healthcheck:** tambah `healthcheck` di service db/app supaya `depends_on` menunggu service benar-benar siap, bukan hanya container jalan.

## Cleanup

```bash
docker compose down -v --rmi all   # hapus semua, termasuk data volume
docker system prune -a             # hapus semua unused Docker objects
docker system prune --volumes      # hapus volume yang tidak terpakai
```

## Resources

- [Docker Documentation](https://docs.docker.com/)
- [PHP 8.5 Docker Hub](https://hub.docker.com/_/php)
- [PostgreSQL 18 Docker Hub](https://hub.docker.com/_/postgres)
- [Nginx Docker Hub](https://hub.docker.com/_/nginx)
- [Adminer Documentation](https://www.adminer.org/)

---

**Setup siap digunakan.** Letakkan file PHP di folder `src/`, lalu:

```bash
docker compose build app
docker compose up -d
```

Akses http://localhost:8080 untuk halaman web, http://localhost:8081 untuk Adminer (PostgreSQL).
