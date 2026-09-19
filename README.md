# PPID Kaltara — LEMP Docker

Portal PPID Kanwil Kemenag Kalimantan Utara, dijalankan dengan LEMP stack (Nginx + PHP-FPM + MariaDB) di Docker.

Aplikasi: [CodeIgniter 4.7](https://codeigniter.com/) (PHP `^8.2`) di folder `src/`. Lihat [`src/README.md`](src/README.md) untuk dokumentasi aplikasi.

## Prasyarat

- [Docker Desktop](https://www.docker.com/products/docker-desktop) (dengan Compose v2)

## Struktur

```
lemp-php8-docker/
├── docker-compose.yml      # 4 service: app (PHP-FPM), nginx, db (MariaDB), adminer
├── php/
│   ├── Dockerfile          # php:8.5-fpm-bookworm + ext: gd, pdo_mysql, mysqli, intl, mbstring, zip + composer
│   └── php.ini             # memory_limit 256M, upload 10M, tz Asia/Makassar
├── nginx/
│   └── default.conf        # root /var/www/html/public (CI4), try_files rewrite, block /writable
└── src/                    # aplikasi CodeIgniter 4 (dipasang via composer)
    ├── app/
    ├── public/             # document root nginx
    ├── writable/
    ├── composer.json
    └── .env                # konfigurasi DB (TIDAK di-commit, ada di .gitignore)
```

## Layanan

| Service  | Container      | Port  | Keterangan                        |
|----------|----------------|-------|-----------------------------------|
| `app`    | php85-fpm      | —     | PHP-FPM 8.5, internal port 9000  |
| `nginx`  | nginx          | 8080  | Web server, akses browser         |
| `db`     | mariadb-10-11  | 3306  | MariaDB 10.11, database `ppid_kaltara` |
| `adminer`| adminer        | 8081  | GUI database                      |

## Menjalankan

```bash
docker compose up -d
```

Container `app` dibuild dari `php/Dockerfile`. Saat pertama kali, Docker menarik image `nginx:stable-alpine`, `mariadb:10.11`, `adminer:latest` dan membuild image PHP.

### Setup aplikasi (CI4)

```bash
# Install dependensi PHP
docker compose exec app composer install

# Copy template env lalu edit (DB sudah pre-configured ke container `db`)
docker compose exec app cp env .env
# atau edit src/.env secara lokal — sudah ada jika project ini di-clone

# Jalankan migrasi & seeder
docker compose exec app php spark migrate
docker compose exec app php spark db:seed DatabaseSeeder
```

### Akses

- **Web**: http://localhost:8080
- **Adminer**: http://localhost:8081 — Server: `db`, User: `ppid_user`, Password: `ppid_password`, Database: `ppid_kaltara`

## Login default

Setelah seeder, akun siap pakai (lihat [`src/README.md`](src/README.md) untuk detail):

- Admin: `admin@ppid-kaltara.go.id` / `admin123`
- Pimpinan: `pimpinan@ppid-kaltara.go.id` / `pimpinan123`

## Konfigurasi database

Default di `docker-compose.yml`:

```yaml
MYSQL_DATABASE: ppid_kaltara
MYSQL_USER: ppid_user
MYSQL_PASSWORD: ppid_password
MYSQL_ROOT_PASSWORD: root
```

`src/.env` (di-git-ignore) sudah menunjuk ke service `db`:

```ini
database.default.hostname = db
database.default.database = ppid_kaltara
database.default.username = ppid_user
database.default.password = ppid_password
database.default.DBDriver = MySQLi
```

> **Jangan commit `.env`.** Ubah kredensial di `docker-compose.yml` dan `src/.env` untuk production.

## Perintah umum

```bash
docker compose up -d                # start
docker compose stop                 # stop (data aman di volume)
docker compose down                 # stop + hapus container (volume tetap)
docker compose down -v              # stop + hapus container DAN data volume
docker compose logs -f app           # log realtime PHP-FPM
docker compose exec app php spark migrate
docker compose exec app composer install
docker compose exec db mariadb -u ppid_user -pppid_password ppid_kaltara
```

## Setelah edit file

| Yang diubah               | Perintah                                      |
|---------------------------|-----------------------------------------------|
| File PHP di `src/`        | Tidak perlu apa-apa (di-mount, langsung efek) |
| `php/php.ini`, `Dockerfile` | `docker compose build app && docker compose up -d` |
| `nginx/default.conf`      | `docker compose restart nginx`                |

## Troubleshooting

- **502 Bad Gateway** — container `app` belum jalan, atau nama service di `fastcgi_pass` tidak cocok. Cek `docker compose ps` dan `docker compose logs app`.
- **"File not found" / "Primary script unknown"** — `root` nginx (`/var/www/html/public`) tidak cocok dengan mount. Pastikan `./src` di-mount di kedua service `app` dan `nginx`.
- **Port sudah dipakai** — ubah sisi kiri di `ports` (mis. `"8080:80"` → `"8090:80"`).
- **Password DB gagal setelah ganti env** — env MariaDB hanya berlaku saat volume pertama kali dibuat. Jalankan `docker compose down -v` lalu `up -d` untuk reset.
