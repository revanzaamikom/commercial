# PAKTJIP Website — Agent Instructions

Landing page + admin panel untuk CV PakTjip Digital Printing (percetakan, Temanggung).

## Quick start

```powershell
# PHP built-in server (tanpa perlu Apache)
C:\xampp\php\php.exe -S localhost:8000 -t public

# MySQL (jika belum jalan)
Start-Process "C:\xampp\mysql\bin\mysqld.exe" -ArgumentList "--defaults-file=C:\xampp\mysql\bin\my.ini","--standalone" -WindowStyle Hidden

# Import skema
C:\xampp\mysql\bin\mysql.exe -u root paktjip < database\paktjip.sql
```

## Environment (terverifikasi)

- PHP 8.0.30 CLI: `C:\xampp\php\php.exe` — GD **aktif** (webp siap)
- MySQL: `C:\xampp\mysql\bin\mysql.exe`, user `root` tanpa password, DB `paktjip` (utf8mb4) sudah dibuat
- Python 3.12: `%LOCALAPPDATA%\Programs\Python\Python312\python.exe` (untuk scripts ui-ux-pro-max)
- Node 24 + git tersedia
- **Tidak ada** image generation tool; analisis gambar via API 9router combo (`http://127.0.0.1:20128/v1`, model `9ROUTER` → glm-5.3-flash, vision OK) — key di `C:\Users\REVANZA\.config\opencode\opencode.json`
- Firecrawl API key: `D:\Websites\WebsiteCampPlan\camp-plan\.env.local` (`FIRECRAWL_API_KEY`, strip kutip dulu)

## Konvensi project

- Struktur: `public/` (docroot � landing + `public/admin/` panel) + `config/` + `database/` + `tools/` (di luar docroot). Admin WAJIB tetap di dalam `public/admin/` (semua file auth-gated).
- PHP native + PDO prepared statements (jangan mysqli raw, jangan string concat query)
- Semua gambar upload → WebP max 1200px via GD
- Wa link: `https://wa.me/6282137215808?text=...` (urlencode pesan)
- **Jangan pernah** tulis klaim faktur pajak/PKP (bukan PKP)
- Bahasa kode & komentar: Inggris sederhana; copy UI: Indonesia
- DB creds dev: root/no-password; production creds via config, jangan commit

## Skills workflow

- `impeccable` — proses desain utama (PRODUCT.md sudah ada). Landing = mode **Persuade**, admin = **Operate**
- `ui-ux-pro-max` — referensi pattern/palet/UX: `python .opencode/skills/ui-ux-pro-max/scripts/search.py "query" --design-system`
- Setelah selesai edit UI: jalankan detector `node C:\Users\REVANZA\.config\opencode\skills\impeccable\scripts\detect.mjs --json <target>`
- Screenshot QA: pakai browser → screenshot → analisis via GLM combo API (model ini tidak bisa baca gambar langsung)
