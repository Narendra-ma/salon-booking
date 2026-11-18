# Hasil Review Kode

Review mandiri memakai checklist keamanan, kebenaran, performa, dan kualitas.
Saat ditulis, kode ini baru dicek sintaksnya (`php -l` dan compile Blade); aplikasinya belum
dijalankan karena Composer tidak bisa mengunduh dependensi di lingkungan penulisan.
Jalankan `php artisan test` dulu, dan lihat juga hasilnya di GitHub Actions.

## Kritis

Tidak ada temuan yang masih terbuka.

Yang sudah diperbaiki selama penulisan:

- **`AdminSeeder`**: `updateOrCreate` hanya mengisi kolom `$fillable`, sehingga `is_admin` akan
  terabaikan tanpa pesan error dan akun admin tidak punya akses. Diganti `forceFill`.
- **`booking_date`**: cast `date` biasa menyimpan `Y-m-d H:i:s`, membuat cek bentrok gagal di SQLite.
  Diganti `date:Y-m-d`.

## Penting

| Lokasi | Masalah | Mengapa penting | Status |
|---|---|---|---|
| `BookingService::create` | Dua booking bersamaan bisa sama-sama lolos cek bentrok | Jadwal ganda | Ditangani: transaksi + `lockForUpdate()` pada pegawai |
| `.env.example` | `ADMIN_PASSWORD=ganti-password-ini` | Akun admin dengan password tebakan | Seeder menolak nilai ini saat `APP_ENV=production` |
| `routes/web.php` | Form booking bisa di-spam | Jadwal penuh oleh booking palsu | Dibatasi `throttle:10,1`; belum ada captcha |
| `Employee` | Menghapus pegawai membuat `employee_id` booking menjadi null | Kapasitas jadwal salah hitung | Belum ada UI hapus pegawai; gunakan `is_active` |

## Saran

- Bootstrap dan font dimuat dari CDN tanpa SRI. Untuk produksi, pertimbangkan hosting sendiri via npm.
- Form booking belum menampilkan slot yang sudah penuh; pelanggan baru tahu setelah submit.
- Belum ada pengingat otomatis dan halaman lupa password.
- Pegawai dan galeri belum bisa dikelola lewat admin.
- Jalankan `./vendor/bin/pint` sebelum commit untuk merapikan gaya kode.

## Sudah baik

- Validasi lewat Form Request, logika booking di `BookingService`, controller tipis.
- Otorisasi berlapis: middleware `admin` untuk area admin, `BookingPolicy` untuk aturan status.
- Foreign key, index, dan `down()` di semua migration; tes mencakup bentrok, batas jam, dan hak akses.
