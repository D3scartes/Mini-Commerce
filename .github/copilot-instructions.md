# Instruksi Copilot untuk Mini-Commerce

## Gambaran Proyek
- **Framework:** Laravel (PHP)
- **Tujuan:** Platform e-commerce dengan manajemen user, produk, dan kategori.
- **Direktori Utama:**
  - `app/Http/Controllers/`: Logika routing dan controller bisnis
  - `app/Models/`: Model Eloquent untuk entitas inti (User, Product, Category)
  - `database/migrations/`: Definisi tabel dan perubahan skema
  - `database/seeders/`: Seeder data untuk pengembangan/pengujian
  - `resources/views/`: Template Blade untuk UI (admin, auth, produk, dll)
  - `routes/`: Definisi route (`web.php`, `auth.php`, dll)

## Arsitektur & Pola
- **MVC:** Standar Laravel MVC; controller sebagai mediator antara route dan model.
- **Eloquent ORM:** Model menggunakan Eloquent untuk akses DB; relasi didefinisikan di kelas model.
- **Requests:** Validasi form di `app/Http/Requests/`.
- **Middleware:** Middleware custom dan bawaan di `app/Http/Middleware/`.
- **Blade Components:** Komponen UI di `resources/views/components/`.

## Alur Kerja Developer
- **Instal dependensi:** `composer install` (PHP), `npm install` (JS/CSS)
- **Jalankan server dev:** `php artisan serve`
- **Build aset:** `npm run dev` (untuk Vite/Tailwind)
- **Jalankan tes:** `vendor\bin\phpunit` atau `php artisan test`
- **Seed database:** `php artisan db:seed` (lihat `DatabaseSeeder`)
- **Migrasi DB:** `php artisan migrate`

## Konvensi & Praktik
- **Penamaan:**
  - Model: Tunggal, PascalCase (misal: `Product`)
  - Controller: PascalCase, diakhiri `Controller`
  - Migration: Timestamp, deskriptif
- **Testing:**
  - Feature test di `tests/Feature/`, unit test di `tests/Unit/`
  - Gunakan factory di `database/factories/` untuk data uji
- **Seeding:**
  - Seeder di `database/seeders/` (misal: `UserSeeder`, `AdminSeeder`)
  - Entry utama: `DatabaseSeeder`
- **Environment:**
  - Gunakan `.env` untuk konfigurasi; tidak dikomit ke VCS

## Titik Integrasi
- **Paket Eksternal:**
  - Dikelola via `composer.json` (PHP) dan `package.json` (JS)
  - Lihat `config/` untuk integrasi layanan (mail, cache, dll)
- **Asset Pipeline:**
  - Menggunakan Vite (`vite.config.js`) dan Tailwind (`tailwind.config.js`)

## Contoh
- **Tambah model baru:** Buat di `app/Models/`, migrasi dengan `php artisan make:migration`, daftarkan relasi di model.
- **Tambah route:** Edit `routes/web.php` atau `routes/auth.php`, arahkan ke method controller.
- **Tambah view Blade:** Tempatkan di `resources/views/`, gunakan sintaks & komponen Blade.

## Referensi
- Lihat `README.md` untuk info Laravel umum.
- Untuk konvensi Laravel, kunjungi https://laravel.com/docs
