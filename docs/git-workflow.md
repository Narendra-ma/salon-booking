# Alur Git

## Sebelum push pertama

```bash
git status                  # pastikan .env, vendor/, dan file rahasia tidak ikut
git diff
php artisan test
```

`.env` sudah ada di `.gitignore`. Hanya `.env.example` yang boleh di-commit, dan isinya
tidak boleh berisi password asli.

## Push pertama ke GitHub

```bash
git init -b main
git add .
git commit -m "feat: website salon dengan booking online dan panel admin"
git remote add origin git@github.com:<username>/<repo>.git
git push -u origin main
```

Setelah itu, jangan kerja langsung di `main`.

## Branch dan commit untuk pekerjaan berikutnya

Nama branch: `feature/<deskripsi-singkat>`, `fix/...`, `chore/...`, misalnya
`feature/crud-pegawai` atau `fix/validasi-nomor-wa`.

Commit memakai Conventional Commits, kalimat perintah, maksimal sekitar 72 karakter:

```
feat: tambah CRUD pegawai di panel admin
fix: tolak nomor WhatsApp yang diawali 0 setelah 62
docs: jelaskan format nomor di README
test: tambah tes booking bersamaan
refactor: pindahkan cek bentrok ke BookingService
chore: perbarui dependensi
```

Satu commit satu perubahan logis.

## Template deskripsi Pull Request

```markdown
## Apa dan mengapa
Menambah ... supaya ...

## Perubahan
- ...
- ...

## Cara tes
1. `php artisan migrate`
2. ...
3. `php artisan test`

## Screenshot
(untuk perubahan tampilan)
```

## Kalau salah commit

| Situasi | Perintah | Risiko |
|---|---|---|
| Belum di-commit, mau batalkan perubahan file | `git restore <file>` | Perubahan hilang permanen |
| Salah commit, belum di-push | `git reset --soft HEAD~1` | Aman, perubahan kembali ke staging |
| Sudah di-push | `git revert <hash>` | Aman, membuat commit pembatalan |
| Tidak sengaja commit `.env` | Ganti semua isinya (password, key), lalu bersihkan riwayat | Secret yang pernah di-push dianggap bocor |

Hindari `git push --force` ke branch bersama.
