# DESIGN — PAKTJIP "Galeri Cetak"

<!-- impeccable:design-schema 1 -->

## World

Editorial print-gallery: landing page sebagai galeri hasil cetak. Chrome monokrom kertas (bukan dashboard, bukan toko), karya cetak satu-satunya sumber warna besar, aksen emas brand. Nol radius, hairline borders, tanpa shadow (kecuali glass panel). Referensi user: demo NFT art-gallery (struktur galeri editorial), diadaptasi — bukan disalin — ke dunia percetakan Temanggung.

## Palette

| Peran | Hex | Catatan |
|---|---|---|
| Paper (bg) | `#FCFCFC` | ground utama |
| Panel | `#F7F7F5` | section selang-seling, topbar, footer |
| Ink | `#111111` | teks, tombol primary, section kontak |
| Line | `#E5E5E5` | hairline semua border |
| Gold | `#FFC72C` | brand accent — pigment bar, dot, italic highlight (versi deep `#C8A21F` untuk teks) |
| WA green | `#128C4B` | status ready & badge buka |
| Pigmen kategori | `#FFC72C` / `#E4572E` / `#2E86AB` / `#7B2FBF` | banner/stempel/merch/undangan — dari DB `kategori_produk.warna` |

Hijau Linktree dilarang. Gradien hanya untuk scrim caption galeri. Dark section tunggal: kontak (`#111` ground, teks `#F4F2EC`).

## Typography

- **Display**: Fraunces 700/900 (roman + italic pairing; kata emas italic di tiap H2) — bukan Playfair/Inter/DM default
- **Angka/label mono-aksen**: Anton (harga, proof strip, nomor langkah, tabular)
- **Body/UI**: Figtree 400–700
- Eyebrow: 12px, 600, uppercase, tracking 0.16em, garis emas pendek di kiri
- Google Fonts import via header.php

## Components

- **Button biner**: filled ink / outline ink, radius 0, hover invert
- **Glass price card**: `rgba(255,255,255,.82)` + blur 4px, border hairline, di dalam prod-card & kalkulator
- **Prod card**: paper putih, hairline, pigment bar 46×5px emas/pigmen kategori di pojok kiri-atas, hover translateY(-3px)
- **Cat tile**: 4 kolom border-shared, pigment square 34px, count uppercase
- **Chip filter**: hairline, active = ink fill putih teks, pig dot 12px
- **Proof strip**: 4 kolom angka Anton + keterangan, panel bg
- **Steps**: nomor Anton emas + rule horizontal (B2B 3 baris, cara-order 4 kolom)
- **FAQ**: details/summary, nomor Anton emas, ×  CSS (dua bar, rotate)
- **Galeri**: grid 4 kolom (span-2 tiap item ke-7), aspect-ratio fixed, caption uppercase muncul saat hover, scrim gradien

## Layout & rhythm

- Max 1160px, padding-inline 24px
- Section padding 96px (64px mobile)
- Breakpoints: 1024 (grid 2 kolom), 720 (nav burger, 1 kolom), 480
- 8px rhythm; lebih besar di atas heading daripada di bawah

## Motion

Satu bahasa: reveal on scroll (opacity+translateY 14px, 0.5s) via IntersectionObserver; hover transform kecil pada kartu & pigment. `prefers-reduced-motion: no-preference` gate di CSS. Tidak ada parallax/paralaks berat, tidak ada autoplay.

## Accessibility floor

Kontras teks ≥4.5:1 (ink di paper, #F4F2EC di ink), focus-visible outline 2px ink offset 3px, [hidden]{display:none!important} dipaksa, aria-live pada hasil kalkulator, aria-selected pada chip, iframe maps bertitle, reduced-motion dihormati.

## Anti-pattern terlarang di project ini

Radius bulat pada card/button, drop shadow umum, gradient dekoratif non-scrim, emoji sebagai icon, AI purple/pink gradient, hijau Linktree, border tebal >1px (kecuali pigment bar & 1px solid ink kalkulator).

## Provenance aset

104 foto galeri: Google Photos albums resmi PakTjip (6 album, diunduh Sep 2026, `assets/_source/` → WebP 1200px q80 GD). Logo: SVG rebuild dari avatar Linktree (favicon.svg). Foto produk kartu katalog: belum ada — kartu memakai pigment bar, bukan foto (disengaja, konsep "chrome minimal").
