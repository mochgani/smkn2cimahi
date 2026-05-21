# Fase 1: Setup Laravel 13 Project

Estimasi: ~30 menit

## 1. Prerequisites

Pastikan sudah terinstall:
- **PHP 8.3+** — `php --version`
- **Composer 2.x** — `composer --version`
- **Node.js 18+** — `node --version`
- **Database**: MySQL 8+, atau PostgreSQL 14+, atau SQLite

## 2. Install Laravel 13

```bash
# Buat project Laravel baru
composer create-project laravel/laravel:^13.0 smkn2cimahi
cd smkn2cimahi

# Verifikasi versi
php artisan --version
# Output: Laravel Framework 13.x.x
```

## 3. Setup Database

### Option A: SQLite (paling mudah, cocok untuk development)

```bash
# Buat file database
touch database/database.sqlite
```

Lalu edit `.env`:
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/smkn2cimahi/database/database.sqlite
# Comment out / hapus: DB_HOST, DB_PORT, DB_USERNAME, DB_PASSWORD
```

### Option B: MySQL/PostgreSQL

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smkn2cimahi
DB_USERNAME=root
DB_PASSWORD=your_password
```

Buat database manual:
```sql
CREATE DATABASE smkn2cimahi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## 4. Setup Environment

Edit `.env`:
```env
APP_NAME="SMKN 2 Cimahi"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_LOCALE=id
APP_FALLBACK_LOCALE=id
APP_TIMEZONE=Asia/Jakarta

# Mail (untuk form kontak nanti)
MAIL_MAILER=log  # nanti diganti smtp
MAIL_FROM_ADDRESS="info@smkn2cmi.sch.id"
MAIL_FROM_NAME="${APP_NAME}"
```

Generate APP_KEY:
```bash
php artisan key:generate
```

## 5. Run Default Migrations

```bash
php artisan migrate
```

Ini akan create tables: `users`, `cache`, `jobs`, `password_reset_tokens`, dll.

## 6. Test Server

```bash
php artisan serve
```

Buka `http://localhost:8000`. Anda harus melihat halaman default Laravel.

## 7. Setup Logo & Public Assets

Copy logo ke `public/`:

```bash
mkdir -p public/images
# Copy logo dari migration kit
cp /path/to/migration-kit/assets/logo.png public/images/logo.png
```

## 8. Konfigurasi Bahasa Indonesia (Opsional)

```bash
# Install package translasi Indonesia
composer require codeaken/laravel-id-translations
```

Atau set manual di `config/app.php`:
```php
'locale' => 'id',
'fallback_locale' => 'id',
'timezone' => 'Asia/Jakarta',
```

## ✅ Verifikasi Fase 1

Cek:
- [ ] `php artisan --version` → Laravel 13.x
- [ ] `php artisan serve` → bisa diakses
- [ ] Database connection works (`php artisan migrate:status`)
- [ ] `.env` sudah diisi dengan benar
- [ ] Logo ada di `public/images/logo.png`

## ➡️ Lanjut ke

[`02-setup-inertia-vue.md`](./02-setup-inertia-vue.md)
