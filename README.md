# Daily Expense Tracker

Aplikasi pencatatan keuangan harian berbasis web. Dibangun menggunakan Laravel, MySQL, dan Tailwind CSS.

## Persyaratan

- PHP >= 8.3
- Composer
- Node.js >= 18
- MySQL 8.0+
- Laragon (direkomendasikan) atau XAMPP

## Cara Setup Lokal

### 1. Clone Repository

```bash
git clone <url-repository>
cd RPL_Daily-Expense-Tracker
```

### 2. Install Dependensi

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Lalu sesuaikan konfigurasi database di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=daily_expense_tracker
DB_USERNAME=root
DB_PASSWORD=
```

> **Catatan:** Sesuaikan dengan password mysql di perangkat anda.

### 4. Generate App Key

```bash
php artisan key:generate
```

### 5. Buat Database

Buat database `daily_expense_tracker` di MySQL:

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS daily_expense_tracker;"
```

Atau buat secara manual melalui phpMyAdmin / HeidiSQL.

### 6. Jalankan Migrasi

```bash
php artisan migrate
```

Perintah ini akan membuat semua tabel yang diperlukan (`users`, `categories`, `transactions`).

### 7. Jalankan Aplikasi

Buka **dua terminal** dan jalankan:

**Terminal 1** — Server Laravel:

```bash
php artisan serve
```

**Terminal 2** — Vite (Tailwind CSS):

```bash
npm run dev
```

### 8. Akses Aplikasi

Buka browser dan akses:

```
http://localhost:8000
```

## Tech Stack

- **Backend:** Laravel 13
- **Frontend:** Blade + Tailwind CSS v4
- **Database:** MySQL 8
- **Build Tool:** Vite
- **Icons:** Lucide Icons
