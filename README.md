# Arena Z

Arena Z adalah aplikasi web untuk mengelola turnamen esports. Pengunjung dapat melihat jadwal pertandingan dan bracket, sedangkan pengguna terdaftar dapat mendaftarkan tim. Admin mengelola pendaftaran dan pertandingan.

## Fitur

- Halaman publik untuk turnamen, jadwal pertandingan, dan bracket.
- Registrasi akun pengguna serta login berdasarkan peran pengguna atau admin.
- Pendaftaran tim ke turnamen yang tersedia dan pemantauan status pendaftaran.
- Pengelolaan tim oleh admin: pencarian, filter status, persetujuan atau penolakan, perubahan data, penghapusan, dan ekspor CSV.
- Pengelolaan jadwal pertandingan: memilih tim yang disetujui, mengatur babak, tanggal, waktu, status, dan hasil pertandingan.

## Teknologi

- PHP 8.3+
- Laravel 13
- SQLite (konfigurasi database bawaan)
- Node.js dan npm
- Vite dan Tailwind CSS

## Persiapan

Pastikan PHP, Composer, Node.js, dan npm sudah terpasang. Dari direktori proyek, jalankan:

```bash
composer run setup
```

Perintah setup memasang dependensi, menyiapkan `.env` dan application key, menjalankan migrasi database, memasang dependensi frontend, serta membangun aset.

Jika ingin menjalankan langkah-langkahnya satu per satu:

```bash
composer install
```

Salin `.env.example` menjadi `.env`, lalu jalankan:

```bash
php artisan key:generate
php artisan migrate
npm install
npm run build
```

Konfigurasi `.env` bawaan menggunakan SQLite di `database/database.sqlite`. Sesuaikan nilai `DB_*` di `.env` jika menggunakan database lain.

## Menjalankan aplikasi

Jalankan server Laravel:

```bash
php artisan serve
```

Untuk pengembangan frontend dengan hot reload, jalankan juga di terminal terpisah:

```bash
npm run dev
```

Buka URL lokal yang ditampilkan oleh `php artisan serve` di browser.

## Penggunaan

Halaman yang dapat diakses tanpa login:

- `/` — halaman utama
- `/turnamen` — informasi turnamen
- `/jadwal` — jadwal pertandingan
- `/bracket` — bracket pertandingan
- `/pilih-login` — pilihan login

Pengguna dapat membuat akun melalui `/user/register`, lalu masuk melalui `/user/login` untuk mendaftarkan tim dan melihat dashboard pengguna. Admin masuk melalui `/admin/login` untuk mengelola tim dan pertandingan.

Akun yang dibuat melalui registrasi memiliki peran `user`. Proyek ini tidak menyediakan akun admin bawaan; admin harus disiapkan oleh pengelola dengan memberikan peran `admin` pada akun yang tepercaya. Jangan gunakan akun atau kredensial pengujian di lingkungan produksi.

## Pengujian

Jalankan test suite dengan:

```bash
php artisan test
```
