# Salon Surya — Website & Sistem Booking Online

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=flat&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=flat&logo=bootstrap&logoColor=white)

Website profil dan sistem reservasi jadwal daring untuk **Salon Surya** di Surabaya. Pelanggan dapat melihat daftar layanan beserta harga, meninjau galeri, dan memesan jadwal secara online. Pemilik salon dapat mengelola reservasi serta daftar layanan melalui panel admin, sekaligus mengirimkan konfirmasi jadwal ke pelanggan langsung melalui WhatsApp.

---

## Tech Stack

* **Backend:** Laravel 12, PHP 8.2+
* **Database:** MySQL (Produksi & Lokal), SQLite in-memory (Pengujian Otomatis)
* **Frontend:** Blade Template, Bootstrap 5 (CDN)
* **Autentikasi & Otorisasi:** Laravel Breeze, Custom Middleware, Laravel Policy
* **Integrasi:** WhatsApp Click-to-Chat (`wa.me`) dengan normalisasi nomor telepon Indonesia

---

## Tampilan Aplikasi

> *Catatan: Unggah tangkapan layar aplikasi ke folder `docs/screenshots/` atau seret gambar langsung ke editor `README.md` di GitHub, lalu sesuaikan tautan di bawah ini.*

| Halaman Beranda & Layanan | Form Booking Online | Dashboard Admin & Konfirmasi WA |
| :---: | :---: | :---: |
| ![Beranda](docs/screenshots/beranda.png) | ![Booking](docs/screenshots/booking.png) | ![Admin](docs/screenshots/admin.png) |

---

## Fitur Utama

### 1. Halaman Publik
* **Beranda & Profil Salon:** Informasi lengkap mengenai Salon Surya, jam operasional, dan layanan unggulan.
* **Katalog Layanan & Harga:** Daftar perawatan salon yang dikelola secara dinamis dari database.
* **Galeri Foto:** Menampilkan hasil perawatan salon yang dimuat langsung dari direktori galeri.
* **Kontak & Lokasi:** Informasi alamat salon di Surabaya yang dilengkapi integrasi peta lokasi.
* **Desain Responsif:** Antarmuka dioptimalkan untuk tampilan perangkat seluler maupun desktop.

### 2. Sistem Reservasi (Booking Online)
* **Validasi Input Ketat:** Menggunakan Laravel `Form Request` untuk memvalidasi kelengkapan dan format data pemesanan.
* **Normalisasi Nomor WhatsApp:** Mengubah format nomor lokal Indonesia (seperti `0812...` atau `+62...`) secara otomatis menjadi format standar `62812...`.
* **Pencegahan Jadwal Bentrok:** Memeriksa ketersediaan kuota pada tanggal dan jam yang dipilih berdasarkan jumlah pegawai aktif.
* **Status Awal Terkontrol:** Setiap pemesanan baru otomatis tercatat dengan status awal `menunggu` hingga diverifikasi admin.

### 3. Panel Admin & Keamanan
* **Autentikasi Terproteksi:** Halaman login admin berbasis Laravel Breeze yang dibatasi oleh middleware `EnsureUserIsAdmin` dan `BookingPolicy`.
* **Dashboard Ringkasan:** Memantau statistik reservasi masuk, jadwal hari ini, serta status pemesanan.
* **Manajemen Booking:** Admin dapat menyetujui atau membatalkan pesanan pelanggan dengan cepat.
* **Konfirmasi WhatsApp Sekali Klik:** Tombol **Kirim WA** otomatis muncul pada pesanan yang disetujui untuk membuka WhatsApp dengan draf pesan konfirmasi siap kirim.
* **CRUD Layanan:** Mengelola penambahan, pembaruan, dan penghapusan daftar layanan serta tarif salon.

---

## Struktur Proyek Penting

```text
salon-booking/
├── app/
│   ├── Http/
│   │   ├── Controllers/Admin/        # Controller dashboard, manajemen booking, dan layanan
│   │   ├── Middleware/
│   │   │   └── EnsureUserIsAdmin.php # Pembatasan hak akses khusus akun admin
│   │   └── Requests/                 # Form Request validasi booking, layanan, dan filter
│   ├── Policies/
│   │   └── BookingPolicy.php         # Aturan otorisasi aksi pada data reservasi
│   ├── Services/
│   │   └── BookingService.php        # Logika utama booking, perhitungan kuota, dan cek bentrok
│   └── Support/
│       └── PhoneNumber.php           # Helper normalisasi nomor telepon 08... menjadi 62...
├── config/
│   └── salon.php                     # Konfigurasi identitas, kontak, dan jam operasional salon
├── database/
│   └── migrations/                   # Skema tabel database aplikasi
├── resources/
│   └── views/                        # Template Blade (layouts, pages, booking, admin)
└── tests/
    └── Feature/                      # Pengujian otomatis alur booking, admin, dan layanan
```

---

## Menjalankan di Komputer Lokal

### Prasyarat Sistem
* **PHP 8.2+** dengan ekstensi `pdo_mysql`, `pdo_sqlite`, `mbstring`, `openssl`, dan `xml` aktif
* **Composer**
* **MySQL**

### Langkah Instalasi

1. **Kloning repositori dan masuk ke direktori proyek**
   ```bash
   git clone https://github.com/Narendra-ma/salon-booking.git
   cd salon-booking
   ```

2. **Pasang seluruh dependensi PHP**
   ```bash
   composer install
   ```

3. **Salin file konfigurasi environment dan buat application key**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database dan profil salon pada file `.env`**
   Buat database baru bernama `salon` di MySQL, lalu sesuaikan variabel berikut di dalam file `.env`:
   * Kredensial database: `DB_DATABASE=salon`, `DB_USERNAME`, dan `DB_PASSWORD`
   * Akun administrator: `ADMIN_EMAIL` dan `ADMIN_PASSWORD`
   * Identitas operasional salon: variabel berawalan `SALON_*` (nama salon, alamat, nomor WhatsApp, jam buka, dan tautan peta)

5. **Jalankan migrasi database dan isi data awal**
   ```bash
   php artisan migrate --seed
   ```
   > **Catatan Data Awal (`--seed`):**
   > * Perintah ini membuat 1 akun admin, 5 layanan awal Salon Surya, serta 3 pegawai contoh (**Rina**, **Dewi**, dan **Sari**).
   > * Pemesanan hanya dapat diproses apabila tersedia pegawai aktif karena kapasitas slot per jam dihitung dari jumlah pegawai.
   > * Menu pengelolaan pegawai belum tersedia di panel admin; ubah nama pegawai contoh menjadi nama pegawai asli melalui `php artisan tinker` atau langsung melalui tabel pegawai di database.

6. **Sesuaikan foto galeri**
   Buka direktori `public/images/gallery`, hapus seluruh file `contoh-*.svg`, lalu masukkan foto asli salon berformat `.jpg`, `.png`, atau `.webp`.

7. **Jalankan server pengembangan lokal**
   ```bash
   php artisan serve
   ```
   * **Halaman Publik:** `http://localhost:8000`
   * **Login Admin:** `http://localhost:8000/login` (gunakan `ADMIN_EMAIL` dan `ADMIN_PASSWORD` dari `.env`)

---

## Pengujian Aplikasi

### 1. Pengujian Otomatis (PHPUnit)
Pastikan ekstensi `pdo_sqlite` sudah aktif pada konfigurasi PHP karena pengujian berjalan menggunakan database SQLite in-memory:
```bash
php artisan test
```

### 2. Skenario Uji Manual Kapasitas Booking
1. Buka halaman `/booking`, pilih layanan, tanggal besok, dan jam `10:00`, lalu kirim formulir hingga halaman terima kasih tampil.
2. Ulangi pemesanan dengan tanggal dan jam yang sama sebanyak dua kali lagi. Seluruh pesanan berhasil masuk karena kapasitas awal salon berjumlah 3 pegawai.
3. Lakukan pemesanan keempat pada tanggal dan jam yang sama. Sistem akan menolak pemesanan dan menampilkan pesan bahwa jadwal sudah penuh.
4. Masuk ke panel admin (`/login`), batalkan salah satu pesanan pada jam `10:00` tersebut, lalu coba lakukan pemesanan ulang pada jam yang sama dari halaman publik. Pemesanan kini kembali berhasil diproses.
5. Setujui salah satu pesanan di panel admin, lalu pastikan tombol **Kirim WA** muncul dan mengarahkan ke WhatsApp dengan format pesan konfirmasi yang sesuai.

---

## Panduan Deploy Produksi

Untuk menayangkan aplikasi pada server produksi (*self-hosted* / VPS / shared hosting), pastikan konfigurasi berikut terpenuhi:

1. **Arahkan Document Root**
   Atur *document root* web server (Nginx atau Apache) agar mengarah langsung ke folder `public/`.

2. **Pasang Dependensi Produksi**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

3. **Sesuaikan Variabel `.env` Produksi**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://domain-salon-anda.com
   ```
   Pastikan kredensial database produksi serta `ADMIN_PASSWORD` sudah menggunakan kata sandi yang kuat.

4. **Jalankan Migrasi dan Seeder Awal**
   ```bash
   php artisan key:generate
   php artisan migrate --force
   ```
   Jalankan perintah *seeder* berikut **hanya pada saat deploy pertama kali**, kemudian segera sesuaikan data layanan dan pegawai:
   ```bash
   php artisan db:seed --force
   ```

5. **Optimasi Cache Laravel**
   ```bash
   php artisan config:cache && php artisan route:cache && php artisan view:cache
   ```

6. **Atur Hak Akses Direktori**
   Pastikan folder `storage/` dan `bootstrap/cache/` memiliki izin tulis (*writable*) oleh pengguna web server.

---

## Dokumentasi Pengembangan

Repositori ini juga mencakup dokumentasi teknis perancangan dan pengembangan sistem yang meliputi:
* **Perencanaan Sistem:** Penentuan fitur MVP, linimasa pengerjaan mingguan, dan pemetaan alur pengguna.
* **Desain Database:** Struktur skema tabel, relasi antar-entitas, dan pertimbangan arsitektur data.
* **Integrasi Notifikasi WhatsApp:** Mekanisme pembentukan URL `wa.me` dan standardisasi nomor telepon Indonesia.
* **Alur Kerja Git:** Pengelolaan *branch*, standar pesan *commit*, dan proses *pull request*.
* **Evaluasi & Pembelajaran:** Hasil tinjauan kode (*code review*) serta catatan teknis selama pengembangan.
