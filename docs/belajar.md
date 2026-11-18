# Catatan Belajar

Kode di repo ini harus bisa Anda jelaskan sendiri, baris per baris, saat ditanya di wawancara
atau di tempat magang. Setelah membaca kodenya, coba jawab pertanyaan di bawah tanpa melihat jawabannya.

## Cek pemahaman

1. Di `Booking::scopeOverlapping`, mengapa booking 10:00-11:00 dan 11:00-12:00 tidak dianggap bentrok?
   Apa yang berubah kalau `<` diganti `<=`?
2. Apa gunanya `lockForUpdate()` di `BookingService`, dan apa yang bisa terjadi tanpa transaksi?
3. Mengapa `is_admin` tidak dimasukkan ke `$fillable`, dan di mana akun admin dibuat?
4. Apa bedanya fungsi `middleware('admin')` dengan `BookingPolicy`? Mengapa keduanya dipakai?
5. Mengapa nomor WhatsApp disimpan sebagai `62...`, bukan `08...`?

## Bacaan di dokumentasi resmi Laravel

- Validation, bagian Form Request Validation
- Eloquent: Relationships, Mutators & Casting, Query Scopes
- Database: Migrations, Transactions, Pessimistic Locking
- Authorization: Policies dan Gates
- Middleware, dan Blade Templates
- Testing: HTTP Tests dan Database Testing
- Laravel Breeze (autentikasi yang dipakai di repo ini)

## Latihan

- Tambah CRUD pegawai di panel admin (ikuti pola `Admin\ServiceController`).
- Buat endpoint JSON yang mengembalikan jam kosong untuk tanggal dan layanan tertentu, lalu isi
  pilihan jam di form lewat JavaScript.
- Tambah tes untuk dua booking dengan layanan berdurasi berbeda yang saling tumpang tindih.
