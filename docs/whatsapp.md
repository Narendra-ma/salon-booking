# Notifikasi WhatsApp (link wa.me)

Setelah booking disetujui, admin melihat tombol **Kirim WA** di daftar booking. Tombol itu membuka
WhatsApp (aplikasi di HP, atau WhatsApp Web di komputer) dengan nomor pelanggan dan pesan konfirmasi
yang sudah terisi. Admin tinggal menekan kirim.

Ini bukan pengiriman otomatis. Link `wa.me` hanya membuka chat, jadi tidak perlu API berbayar
atau WhatsApp Business API.

## Bentuk URL

```
https://wa.me/<nomor>?text=<pesan>
```

Contoh:

```
https://wa.me/6281234567890?text=Halo%20Kak%20Ani%2C%20booking%20Kakak%20sudah%20kami%20konfirmasi.
```

## Format nomor Indonesia

`wa.me` memakai format internasional **tanpa** tanda `+`, spasi, strip, dan **tanpa angka 0 di depan**.
Awalan `0` diganti kode negara `62`.

| Ditulis pelanggan | Disimpan dan dipakai di URL |
|---|---|
| `0812-3456-7890` | `6281234567890` |
| `+62 812 3456 7890` | `6281234567890` |
| `81234567890` | `6281234567890` |
| `+62 0812 3456 7890` (salah ketik) | `6281234567890` |

Normalisasi dilakukan satu kali saat booking, di `App\Support\PhoneNumber::normalize()`:

1. Buang semua karakter selain angka.
2. Jika diawali `620`, buang `0` setelah `62`.
3. Jika diawali `62`, biarkan.
4. Jika diawali `0`, ganti dengan `62`.
5. Jika diawali `8`, tambahkan `62` di depan.

Setelah itu `BookingRequest` memastikan hasilnya cocok dengan pola `^628\d{8,12}$`
(nomor seluler Indonesia). Nomor telepon rumah tidak diterima karena tidak punya WhatsApp.

## Membentuk pesan

Pesan dibuat di `Booking::whatsappUrl()`, lalu di-encode dengan `rawurlencode()`:

- spasi menjadi `%20`
- baris baru menjadi `%0A`
- koma menjadi `%2C`, titik dua menjadi `%3A`, dan seterusnya

`rawurlencode` dipilih daripada `urlencode` karena `urlencode` mengubah spasi menjadi `+`,
yang di beberapa versi WhatsApp tampil sebagai tanda plus di teks.

## Yang perlu diperhatikan

- Pesan tidak terkirim sebelum admin menekan tombol kirim di WhatsApp.
- Jika nomor tidak terdaftar di WhatsApp, WhatsApp menampilkan peringatan sendiri.
- Panjang URL ada batasnya. Pesan konfirmasi dibuat singkat supaya aman.
- Nomor salon di footer dan halaman kontak (`SALON_WHATSAPP` di `.env`) memakai format yang sama.
