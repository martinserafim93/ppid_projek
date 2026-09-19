# AGENTS.md

Portal PPID Kanwil Kemenag Kaltara — a **CodeIgniter 4.7** (PHP `^8.2`) app for public-information request services. MySQL + Bootstrap 5.3. UI language is **Indonesian, formal ("Anda")**.

## Commands

Use the `spark` CLI (this is CodeIgniter, not Laravel — no `artisan`). Shell is Windows `pwsh`.

- `php spark serve` — dev server. Or via Laragon at `http://ppid-kaltara.test`.
- `php spark migrate` — run migrations.
- `php spark db:seed DatabaseSeeder` — master seeder (calls all sub-seeders in order).
- `php spark make:migration Name` / `make:controller` / `make:model` — codegen.
- `php spark cache:clear` — **required after changing rows in the `settings` table** (see Settings below).
- `composer test` or `vendor\bin\phpunit` — run tests.
- Single test: `vendor\bin\phpunit --filter testBaseUrlHasBeenSet` or `vendor\bin\phpunit tests\unit\HealthTest.php`.

## Setup / environment

- `.env` is already present and configured for local dev (`CI_ENVIRONMENT=development`, `baseURL=http://ppid-kaltara.test/`, DB `ppid_kaltara` on `127.0.0.1` root/no-password). `env` (no dot) is the CI4 template — don't confuse the two.
- Requires PHP ext `intl`, `mbstring`, `gd`.
- Seeded default logins: admin `admin@ppid-kaltara.go.id` / `admin123`, pimpinan `pimpinan@ppid-kaltara.go.id` / `pimpinan123`.

## Architecture / wiring

- **Auto-routing is OFF** (`app/Config/Routing.php`). Every endpoint must be declared explicitly in `app/Config/Routes.php`. Adding a controller method is not enough — add its route too.
- Route groups + filters (aliases in `app/Config/Filters.php`):
  - `admin/*` → filter `admin`, namespace `App\Controllers\Admin` (controllers live in `app/Controllers/Admin/`).
  - `pimpinan/*` → filter `pimpinan`, **no explicit namespace** — controllers referenced as `Pimpinan\Dashboard`, `Pimpinan\SurveiController` (live in `app/Controllers/Pimpinan/`).
  - `permohonan/*` — public request flow (create, track, history, objection, survey). No filter.
  - Public routes are ungrouped at the bottom of `Routes.php`.
- **Filter aliases**: `admin` → `AdminFilter`, `pimpinan` → `PimpinanFilter`, `auth` → `AuthFilter` (generic login check, registered but currently unused in routes).
- **Three roles**, session-based auth (no auth library): `admin`, `pimpinan`, `pemohon`. Login is split across two controllers: `Auth` (`/auth/login`, admin+pimpinan) and `UserAuth` (`/user/login`, pemohon). Filters check `session('logged_in')` and `session('user_role')`.
- **CSRF filter is NOT enabled globally** (commented out in `Filters.php`). Views call `csrf_field()` across ~27 files but it is currently a no-op — don't assume CSRF protection is active.

## Repo-specific conventions

- **Models return arrays** (`$returnType = 'array'`), not objects. To persist a new column you MUST add it to the model's `$allowedFields` whitelist (e.g. `RegulationModel::$allowedFields`).
- **Flash-message keys are inconsistent and rendered per-view (no global handler).** Controllers use both `->with('message', ...)` (~20x) and `->with('success', ...)` (~16x) for success; `->with('error', ...)` for single errors; `->with('errors', [...])` for validation arrays. When editing a controller/view pair, make the view read the exact key the controller sets.
- **Slugs**: `app/Helpers/slug_helper.php` (`createSlugFromTitle`, `generateSlug`, `isSlugUnique`). Default fallback word is `'halaman'`; regulations pass `'regulasi'`. Categories are referenced **by slug, not id**: `regulations.type`, `documents.category`, `public_informations.category` all store a category slug. Renaming a category regenerates its slug and must **cascade-update those columns in a transaction** (see `issue.md` for the established pattern).
- **File uploads**: use `uploadFile($file, 'dir', $opts)` / `deleteFile($path)` from `app/Helpers/upload_helper.php`. Files land in `public/uploads/{dir}/`; DB stores the relative path `uploads/{dir}/{file}`. `public/uploads/` is git-ignored.
- **Custom helpers** live in `app/Helpers/`: `admin`, `setting`, `slug`, `upload`, `date`. `BaseController` auto-loads `form, url, admin, setting` for every controller; load `slug`/`upload` in the specific controller constructor when needed.
- **Settings** are DB-backed and cached: `getSetting('key', 'default')` reads via `loadSettings()`, which caches the whole `settings` table under cache key `site_settings` for 1h. After writing to `settings`, run `php spark cache:clear` or the change won't show.

## Controllers & models inventory

- **Admin controllers** (`app/Controllers/Admin/`): `Dashboard`, `Category`, `Documents`, `Infographics`, `Pages`, `Pemohon`, `PublicInformations`, `Regulations`, `Requests`, `Settings`, `Users`.
- **Pimpinan controllers** (`app/Controllers/Pimpinan/`): `Dashboard` (monitoring + laporan + CSV export), `SurveiController` (manage survey data).
- **Public controllers** (root): `Home`, `Auth`, `UserAuth`, `Request_` (permohonan flow), `Document`, `Information`, `Infographic`, `Regulation`, `Service`, `Profile`, `Statistic`, `Data`.
- **Shared controller**: `ProfileController` — used by both admin and pimpinan route groups for profile editing.
- **Models** (all `$returnType = 'array'`): `ActivityLogModel`, `CategoryModel`, `DocumentModel`, `InfographicModel`, `ObjectionModel`, `PageModel`, `PublicInformationModel`, `RegulationModel`, `RequestFileModel`, `RequestModel`, `SettingModel`, `SurveyModel`, `UserModel`.

## Business flows

- **Permohonan informasi**: public can create via `permohonan/buat`, track via `permohonan/lacak`. Logged-in pemohon can view history (`permohonan/riwayat`) and detail. Admin manages requests via `admin/requests/*` (CRUD + status update). Controller: `Request_` (public) / `Admin\Requests` (admin).
- **Keberatan (objection)**: pemohon submits via `permohonan/keberatan/(:segment)`. Uses `ObjectionModel`.
- **Survei**: pemohon submits satisfaction survey via `permohonan/survei/(:segment)`. Pimpinan manages survey data via `pimpinan/survei/*`. Uses `SurveyModel`.
- **Laporan & monitoring**: pimpinan dashboard at `pimpinan/monitoring` and `pimpinan/laporan` with CSV export.

## Views / UI

- Layouts: `app/Views/layouts/{admin,pimpinan,public}.php`, extended via `$this->extend('layouts/...')` + sections.
- View directories: `admin/`, `auth/`, `components/`, `errors/`, `layouts/`, `pagers/`, `pimpinan/`, `public/`, `shared/`, `user_auth/`.
- Frontend is Bootstrap 5.3 (CDN), Bootstrap Icons, jQuery, SweetAlert2, Chart.js, Summernote. Main admin styles: `public/assets/css/admin.css`.
- The Kemenag-green primary override already exists in `admin.css` — **do not redefine it**.
- UI/design work must follow `DESIGN.md` (green `#1B5E20`, gold accent `#C9A84C`, Inter, radius 8/12px) and `PRODUCT.md`. The **`impeccable` design skill is installed and enforced via hooks** (`.claude/settings.local.json`, `.codex/hooks.json`) that run on Edit/Write of UI files and on Stop — use it for any interface work.

## Testing

- Only `tests/unit/HealthTest.php` exists so far; PHPUnit suite `App` maps to `./tests`.
- DB-touching tests need a `database.tests.*` connection configured (commented out in `.env` and `phpunit.dist.xml`); the default suite does not require it.

## Workflow notes

- **Do not commit unless explicitly asked** (repo convention, reiterated in `issue.md`).
- `issue.md` / `issue-2.md` are git-ignored task/spec files; `issue.md` currently documents the regulations/categories slug work and is a good source of established patterns.
