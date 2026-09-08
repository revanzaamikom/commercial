# PAKTJIP Website

Landing page + admin panel untuk **CV PakTjip Digital Printing** (percetakan, stempel, banner, merchandise — Temanggung, Jawa Tengah).

Pengganti Linktree: etalase produk dengan harga "mulai dari", kalkulator estimasi → WhatsApp, galeri portofolio, badge buka/tutup otomatis, SEO lokal (JSON-LD LocalBusiness + FAQPage).

## Stack

PHP 8 native + MySQL (tanpa framework) — dibuat untuk shared hosting cPanel murah.

## Struktur

```
paktjip-website/
├── public/            # docroot
│   ├── index.php      # landing page (dari DB)
│   ├── admin/         # panel pengelola (login-gated)
│   └── assets/        # css, js, uploads (WebP)
├── config/            # koneksi PDO (contoh: database.example.php)
├── database/          # skema + seed (tanpa kredensial)
├── tools/             # setup-admin.php (CLI)
└── dev-watch.ps1      # dev server + auto-reload
```

## Dev lokal

```powershell
powershell -File dev-watch.ps1   # PHP server + MySQL + Browsersync (buka localhost:3000)
```

Setup pertama:
1. Salin `config/database.example.php` → `config/database.php`, isi kredensial
2. Import skema: `Get-Content database/paktjip.sql | mysql -u root paktjip` lalu `database/seed.sql`
3. Buat admin: `php tools/setup-admin.php <username> <password>`

## Admin panel

`/admin/` — kelola produk (upload foto → WebP otomatis), galeri, FAQ, pengaturan toko (alamat, WA, jam buka, teks tentang).
