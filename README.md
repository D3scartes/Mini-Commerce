# PHP dependencies
composer install

# environment & app key
cp .env.example .env         
php artisan key:generate

# Sesuaikan DB di .env, lalu kalau tidak ada ini di db maka lakukan
php artisan session:table
php artisan queue:table
php artisan cache:table

# Migrasi & seeder
php artisan migrate
php artisan db:seed

# Symlink storage (untuk akses /storage/*)
php artisan storage:link

# JS dependencies
npm install

# clear cache
php artisan optimize:clear

# Jalankan (dua terminal)
php artisan serve             # http://127.0.0.1:8000
npm run dev                   # Vite dev server (hot reload)

# Version
Framework Backend: Laravel 12.28.1
Bahasa Pemrograman: PHP 8.2.12
Database: MySQL 8.0 (XAMPP) — client terdeteksi 8.0.40
Frontend CSS: Tailwind CSS 3.4.17
    Plugin: @tailwindcss/forms 0.5.10
    Integrasi: @tailwindcss/vite 4.1.13
JavaScript (UI ringan): Alpine.js 3.15.0
Bundler & Dev Server: Vite 7.1.6
    Plugin Laravel: laravel-vite-plugin 2.0.1
HTTP Server Lokal: XAMPP (Apache & MySQL aktif)
Node.js: v22.19.0
Package Manager (JS): npm 10.9.3
Dependency Manager (PHP): Composer 2.8.11
Dependency PHP (utama):
    laravel/breeze 2.3.8 (auth scaffolding)
    laravel/tinker 2.10.1
    laravel/pint 1.24.0 (formatter)
    nunomaduro/collision 8.8.2 (CLI error handler)
    phpunit/phpunit 11.5.39, mockery/mockery 1.6.12 (testing)
    fakerphp/faker 1.24.1 (seed data)
    laravel/pail 1.2.3, laravel/sail 1.45.0 (opsional/dev)
Utility JS tambahan:
    axios 1.12.2, autoprefixer 10.4.21, postcss 8.5.6, concurrently 9.2.1
