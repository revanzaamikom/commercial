# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Stack

PHP 8 + MySQL native (tanpa framework), dipilih karena scope kecil, murah di-hosting (cPanel shared ~Rp15rb/bln), mudah di-maintain klien. Didefinisikan di `rencana-lengkap-paktjip.pdf`, disetujui user. Dev lokal: XAMPP (`C:\xampp`), PHP built-in server, DB `paktjip`.

## Users

1. **Retail** — calon pelanggan di Temanggung & sekitarnya yang butuh cetak (banner, stempel, undangan, dll), datang dari bio IG/Linktree/Google, order via WhatsApp.
2. **B2B / instansi** — buyer e-procurement (Mbizmarket, Tisera) yang mengecek kredibilitas & katalog sebelum order.
3. **Admin (Pak Tjip / keluarga)** — satu orang, mengelola konten via admin panel sederhana.

## Product Purpose

Etalase digital resmi CV PakTjip Digital Printing, pengganti Linktree. Menampilkan produk, harga "mulai dari", portofolio, dan mengarahkan semua order ke WhatsApp. Tidak menyimpan transaksi; sukses = visitor WA-order atau percaya kredibilitas B2B.

## Positioning

One-stop digital printing di Temanggung yang **terdaftar resmi e-procurement nasional** (Mbizmarket sejak Feb 2022, Tisera, badge PDN "Bangga Buatan Indonesia") — bukan tukang cetak pinggir jalan. Tagline brand: **"Nek Ora PAKTJIP Ora"** (bahasa Jawa, witty, memorable). Tetangga lokal tidak punya website proper; tetangga e-proc tidak punya rasa lokal.

## Operating Context

- Order via WhatsApp `wa.me/6282137215808` (nomor terkonfirmasi via Linktree & IG caption)
- Email: stempelpajip@gmail.com — **koreksi: stempelpaktjip@gmail.com**
- Alamat: Jl. Jampiroso Utara No. 196B, Jampiroso, Temanggung, Jawa Tengah
- Ig: @paktjip_digital_printing
- Platform B2B: mbizmarket.co.id/p/paktjip, tisera.id (produk READY, badge PDN)
- Katalog undangan & lasercut: Google Photos albums (link di Linktree)

## Capabilities and Constraints

- Landing page publik (7 section: hero, tentang, katalog, B2B, galeri, FAQ, kontak) + kalkulator estimasi harga + badge buka/tutup otomatis + SEO LocalBusiness JSON-LD
- Admin panel: content manager murni (CRUD produk/galeri/FAQ/pengaturan) — **fase kedua, landing dulu**
- **TIDAK ada** data transaksi, keranjang, pembayaran
- **TIDAK boleh klaim** faktur pajak / PKP (Mbizmarket: Non PKP; klaim dihapus per keputusan user) — cukup "Terdaftar e-Procurement"
- Kalkulator: estimasi "mulai dari" → WA; harga final diomongkan Pak Tjip
- Upload gambar admin → convert WebP (GD), max 1200px

## Brand Commitments

- Logo: avatar Linktree (huruf "P" kuning/emas dalam kotak, ground charcoal gelap, teks "PAKTJIP" + "STEMPEL & DIGITAL PRINTING") — akan di-rebuild vector; file asli diminta ke Pak Tjip (open)
- Warna brand: kuning/emas + charcoal gelap
- Warna hijau default Linktree **diabaikan** (instruksi eksplisit user)
- Voice: Indonesia santai-percaya-diri, sela Jawa boleh di momen brand (tagline), formal di section B2B

## Evidence on Hand

- `rencana-lengkap-paktjip.pdf` — rencana lengkap (struktur, skema DB, hosting)
- Scraping Mbizmarket: 20 produk + harga (ID card Rp4.100–28.000, banner FL280gr Rp22.032–459.000, papan nama akrilik neon box mulai Rp8,1jt)
- Scraping Tisera: 24 produk + harga READY (stempel flash Rp150.000, banner 280gsm mulai Rp34.999, baliho+pasang Rp755.000, kain bendera 7 ukuran Rp55.000–680.000, plakat Rp175.000–500.000, tumbler custom Rp17.000, kop dinas Rp3.000, stopmap Rp12.000, blocknote A5 Rp29.999, lanyard Rp20.000, ID card Rp15.000, papan nama Rp40.000, kertas blangko Rp3.500)
- 6 album Google Photos (±160 foto): Sign Lasercut + 5 katalog undangan (CR7, Raffa, Griya Silver, Avis, Lite)
- Logo avatar Linktree (18KB PNG) — dianalisis via GLM vision
- Skripsi UAD 2024 tentang pemasaran CV PakTjip (ada, belum dibaca)

## Product Principles

1. **Nyata dulu, bombastis belakangan** — harga "mulai dari" dari data terverifikasi, bukan klaim karangan
2. **WA adalah checkout** — setiap CTA bermuara ke wa.me dengan pesan terisi otomatis
3. **Lokal & resmi sekaligus** — rasa Temanggung (tagline Jawa) + kredibilitas e-procurement nasional, tidak saling meniadakan
4. **Konten dikelola Pak Tjip** — semua teks/gambar harus bisa diganti dari admin panel tanpa sentuh kode

## Accessibility & Inclusion

Standar: kontras teks 4.5:1, focus visible, prefers-reduced-motion, responsif 375–1440px (checklist ui-ux-pro-max pre-delivery). Audiens campuran umur (retail muda IG + staf pengadaan B2B).
