# Salon Surya: website dan booking online

Website salon di Surabaya. Pelanggan bisa melihat layanan dan harga, lalu booking jadwal.
Pemilik salon mengelola booking dan layanan lewat panel admin, dan mengonfirmasi ke pelanggan
lewat WhatsApp.

Stack: Laravel 12, PHP 8.2+, MySQL, Blade, Bootstrap 5 (CDN), Laravel Breeze (login).

## Fitur

- Halaman publik: beranda, layanan dan harga, galeri, kontak dengan peta. Responsif untuk HP.
- Booking: form dengan Form Request, nomor WhatsApp dinormalisasi, cek jadwal bentrok, status awal `menunggu`.
- Admin: login, dashboard, setujui/batalkan booking, CRUD layanan, tombol kirim konfirmasi WhatsApp.
- Akses admin dibatasi middleware `admin` dan `BookingPolicy`.

## Menjalankan di komputer

Butuh PHP 8.2+, Composer, dan MySQL.

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Buat database `salon` di MySQL, lalu sesuaikan `DB_*` dan `ADMIN_PASSWORD` di `.env`.

```bash
php artisan migrate --seed
php artisan serve
```

Buka http://localhost:8000. Login admin di `/login` memakai `ADMIN_EMAIL` dan `ADMIN_PASSWORD` dari `.env`.

`--seed` mengisi akun admin, 5 layanan Salon Surya, dan 3 pegawai contoh (Rina, Dewi, Sari).
**Booking hanya bisa diterima kalau ada pegawai aktif**, karena kapasitas salon dihitung dari jumlah
pegawai. Ganti nama pegawai contoh dengan yang asli (belum ada menu pegawai di admin, ubah lewat
`php artisan tinker` atau langsung di database).

Data salon (nama, alamat, nomor WhatsApp, jam buka, peta) diatur lewat variabel `SALON_*` di `.env`.
Foto galeri diambil dari `public/images/gallery`: hapus file `contoh-*.svg`, lalu taruh foto asli (jpg/png/webp).

## Tes

```bash
php artisan test
```

Tes memakai SQLite in-memory, jadi ekstensi `pdo_sqlite` harus aktif.

Cara tes manual untuk booking:

1. Buka `/booking`, pilih layanan, tanggal besok, jam 10:00, kirim. Harus muncul halaman terima kasih.
2. Ulangi dengan data yang sama dua kali lagi. Semua berhasil karena ada 3 pegawai.
3. Ulangi sekali lagi. Harus muncul pesan jadwal sudah penuh.
4. Login admin, batalkan salah satu booking, lalu booking jam yang sama lagi. Sekarang berhasil.
5. Setujui booking di admin. Tombol **Kirim WA** muncul dan membuka WhatsApp dengan pesan konfirmasi.

## Struktur penting

```
app/Services/BookingService.php     logika booking dan cek bentrok
app/Http/Requests/                  validasi (booking, layanan, filter)
app/Http/Controllers/Admin/         dashboard, booking, layanan
app/Http/Middleware/EnsureUserIsAdmin.php
app/Policies/BookingPolicy.php
app/Support/PhoneNumber.php         normalisasi nomor 08... menjadi 62...
config/salon.php                    data dan jam operasional salon
database/migrations/                skema
resources/views/                    Blade (layouts, pages, booking, admin)
tests/Feature/                      tes booking, admin, layanan
```

## Deploy

Hosting diurus sendiri. Hal yang perlu diperhatikan:

- Document root web server diarahkan ke folder `public/`.
- `composer install --no-dev --optimize-autoloader`
- `.env` produksi: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL`, kredensial database, dan `ADMIN_PASSWORD` yang kuat.
- `php artisan key:generate`, `php artisan migrate --force`
- Pertama kali saja: `php artisan db:seed --force`, lalu ubah layanan dan pegawai contoh.
- `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- Folder `storage/` dan `bootstrap/cache/` harus bisa ditulis oleh web server.

## Dokumentasi

- [Perencanaan](docs/perencanaan.md): fitur MVP, jadwal per minggu, alur pengguna
- [Database](docs/database.md): skema, relasi, alasan desain
- [Notifikasi WhatsApp](docs/whatsapp.md): membentuk URL wa.me dan format nomor Indonesia
- [Alur Git](docs/git-workflow.md): branch, commit, pull request
- [Hasil review kode](docs/code-review.md)
- [Catatan belajar](docs/belajar.md)
