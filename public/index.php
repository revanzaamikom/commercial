<?php
require_once __DIR__ . '/includes/functions.php';
$s = get_settings();
$categories = get_categories();
$products = get_products();
$galeri = get_galeri(10);
$faq = get_faq();
$isOpen = buka_sekarang($s);

// foto pilihan untuk hero/tentang/foto-break (dari galeri + produk)
$heroImg   = $U2 ?? null;
$galBySlug = [];
foreach ($galeri as $g) $galBySlug[$g['kategori_slug']][] = $g;
$firstPhoto = fn(string $slug, string $fallback) => $galBySlug[$slug][0]['gambar'] ?? $fallback;
$heroPhoto   = $firstPhoto('undangan-lasercut', '/assets/uploads/lasercut-lasercut-001.webp');
$tentangBig  = $firstPhoto('undangan-lasercut', '/assets/uploads/lasercut-lasercut-008.webp');
$tentangSmall= $firstPhoto('undangan-lasercut', '/assets/uploads/undangan-avis-undangan-avis-003.webp');
$breakImg    = '/assets/uploads/p/mbiz-banner-fl280gr-5x2-5.webp';
$catPhotoDefault = [
  'banner-outdoor'        => '/assets/uploads/p/mbiz-banner-fl280gr-6x3.webp',
  'stempel-administrasi'  => '/assets/uploads/p/tisera-stempel.webp',
  'merchandise-custom'    => '/assets/uploads/p/tisera-tumbler-plastik.webp',
  'undangan-lasercut'     => '/assets/uploads/undangan-cr7-undangan-cr7-004.webp',
];
require __DIR__ . '/includes/header.php';
?>
<main>
<!--
IMPECCABLE DIRECTION CONTRACT — "Workshop Journal" — rebuild dari mockup di-approve user 100% (2026-09-05).
Fusi 3 referensi user: NFT gallery (chrome editorial, gold, serif) + CentralPrint (katalog image-forward, cara order, trust) + Bucini (ticker marquee, kategori foto, gram strip, hero foto overlay).
THESIS: workshop cetak nyata jadi panggung — foto dokumentasi & produk mengisi halaman, chrome monokrom kertas longgar, emas brand sebagai penanda; menolak template "web-printer hijau" dan layout NFT referensi yang lama.
OWN-WORLD: paper #FCFCFC, ink #111, panel #F7F7F5, hairline #E5E5E5, brand gold #F5C518 (logo asli), text-gold #7C5F04, pigment 4 kategori; Fraunces roman+italic, Anton angka, Figtree body; radius 0; tanpa eyebrow kicker.
STORY: visitor 5 detik tahu ini percetakan Temanggung; harga "mulai dari" nyata; semua CTA ke WA prefill.
FIRST VIEWPORT: ticker marquee ink-gold; topbar status; nav sticky; hero split — kiri H1 + CTA + 3 foto proof, kanan foto workshop full-height + frame + tag lokasi.
FORM: mockup disetujui sebagai law; galeri gram-strip horizontal.
FINISH: unreviewed and undocumented is unfinished; this build ends with the finish review, the verdict, DESIGN.md, and every shipping raster carrying its provenance.
-->
<div class="ticker" aria-hidden="true">
  <div class="ticker-track">
    <span>Nek Ora PAKTJIP Ora</span><span>✦</span><span>Stempel · Banner · Undangan · Lasercut</span><span>✦</span><span>Ready 1–3 Hari Kerja</span><span>✦</span>
    <span>Nek Ora PAKTJIP Ora</span><span>✦</span><span>Stempel · Banner · Undangan · Lasercut</span><span>✦</span><span>Ready 1–3 Hari Kerja</span><span>✦</span>
  </div>
</div>

<header class="topbar">
  <div class="wrap topbar-in">
    <span class="open-state" data-open-state data-hours="<?= e($s['jam_operasional']) ?>">
      <span class="dot <?= $isOpen ? 'on' : 'off' ?>" aria-hidden="true"></span>
      <?= $isOpen ? 'Buka sekarang · Sen–Sab 08.00–17.30' : 'Tutup — buka 08.00' ?>
    </span>
    <span class="topbar-badge">Terdaftar e-Procurement Nasional</span>
  </div>
</header>

<nav class="nav">
  <div class="wrap nav-in">
    <a class="brand" href="/">PAKTJIP<span class="dot" aria-hidden="true"></span></a>
    <button class="nav-toggle" aria-expanded="false" aria-controls="navmenu" aria-label="Menu">
      <span></span><span></span>
    </button>
    <div class="nav-menu" id="navmenu">
      <a href="#katalog">Katalog</a>
      <a href="#kalkulator">Estimasi</a>
      <a href="#galeri">Galeri</a>
      <a href="#tentang">Tentang</a>
      <a href="#faq">FAQ</a>
      <a class="btn btn-sm" href="<?= e(wa_order_link($s['no_whatsapp'], 'Halo PakTjip, saya mau pesan.')) ?>" target="_blank" rel="noopener">Pesan via WA</a>
    </div>
  </div>
</nav>

<!-- HERO SPLIT -->
<section class="hero">
  <div class="hero-copy">
    <p class="kicker-top">One-stop digital printing · Temanggung</p>
    <h1>Nek Ora PAKTJIP <em>Ora</em></h1>
    <p class="lead">Cetak digital, stempel, banner, undangan, sablon &amp; lasercut — dari pesanan satuan sampai pengadaan instansi. Dikerjakan di workshop kami di Jampiroso.</p>
    <div class="btn-row">
      <a class="btn" href="<?= e(wa_order_link($s['no_whatsapp'], 'Halo PakTjip, saya mau pesan.')) ?>" target="_blank" rel="noopener">Pesan via WhatsApp</a>
      <a class="btn btn-ghost" href="#katalog">Lihat Katalog</a>
    </div>
    <p class="wa-note">Dibalas langsung oleh tim workshop — bukan bot.</p>
    <div class="hero-proofs">
      <?php foreach (array_slice($galeri, 0, 3) as $g): if (!is_file(__DIR__ . $g['gambar'])) continue; ?>
      <figure><img src="<?= e($g['gambar']) ?>" alt="<?= e($g['judul'] ?: 'Hasil cetak PakTjip') ?>" loading="lazy" width="400" height="300"></figure>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="hero-media">
    <img src="<?= e($heroPhoto) ?>" alt="Hasil cetak di workshop PakTjip" width="900" height="1100">
    <span class="hero-tag">Workshop · Jl. Jampiroso Utara 196B</span>
  </div>
</section>

<!-- KATEGORI FOTO -->
<section class="cats" aria-label="Kategori produk">
  <div class="wrap">
    <div class="cats-head">
      <h2>Mulai dari <em>yang kamu butuh</em></h2>
      <p>Empat lini produksi, satu workshop. Klik kategori untuk melompat ke katalog.</p>
    </div>
    <div class="cat-grid">
      <?php
      $catCounts = [];
      foreach ($products as $p) $catCounts[$p['kategori_slug']] = ($catCounts[$p['kategori_slug']] ?? 0) + 1;
      foreach ($categories as $c):
        $img = $catPhotoDefault[$c['slug']] ?? '/assets/uploads/lasercut-lasercut-003.webp';
        $n = $catCounts[$c['slug']] ?? 0;
      ?>
      <a class="cat-card" href="#katalog" data-cat-link="<?= e($c['slug']) ?>" style="--pig:<?= e($c['warna']) ?>">
        <img src="<?= e($img) ?>" alt="<?= e($c['nama_kategori']) ?>" loading="lazy" width="600" height="800">
        <span class="cat-pig" aria-hidden="true"></span>
        <span class="cat-label"><strong><?= e($c['nama_kategori']) ?></strong><span><?= $n ?>+ produk</span></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- KATALOG -->
<section class="katalog" id="katalog">
  <div class="wrap">
    <div class="cats-head">
      <h2>Semua yang bisa dicetak, <em>siap order</em></h2>
      <p>Harga “mulai dari” dari katalog resmi kami. Klik produk — WhatsApp terbuka dengan pesan terisi.</p>
    </div>
    <div class="filters" role="tablist" aria-label="Filter kategori">
      <button class="chip is-active" data-filter="all" role="tab" aria-selected="true">Semua</button>
      <?php foreach ($categories as $c): ?>
      <button class="chip" data-filter="<?= e($c['slug']) ?>" role="tab" aria-selected="false">
        <span class="chip-pig" style="--pig:<?= e($c['warna']) ?>" aria-hidden="true"></span><?= e($c['nama_kategori']) ?>
      </button>
      <?php endforeach; ?>
    </div>
    <div class="prod-grid" id="prodgrid">
      <?php foreach ($products as $p): $hasImg = !empty($p['gambar_utama']) && is_file(__DIR__ . $p['gambar_utama']); ?>
      <article class="prod-card reveal" data-cat="<?= e($p['kategori_slug']) ?>" style="--pig:<?= e($p['warna']) ?>">
        <div class="prod-media">
          <img src="<?= e($hasImg ? $p['gambar_utama'] : ($catPhotoDefault[$p['kategori_slug']] ?? $heroPhoto)) ?>"
               alt="<?= e($p['nama_produk']) ?>" loading="lazy" width="600" height="600">
          <span class="status st-<?= e($p['status']) ?>"><?= e($p['status']) ?></span>
          <span class="pig" aria-hidden="true"></span>
        </div>
        <div class="prod-body">
          <h3><?= e($p['nama_produk']) ?></h3>
          <p><?= e($p['deskripsi']) ?></p>
          <div class="prod-price">
            <span class="val">
              <small><?= $p['satuan'] === 'tanya harga' ? 'Harga' : 'Mulai dari' ?></small>
              <?= e(harga_label($p)) ?>
            </span>
            <a class="btn btn-sm btn-ghost" target="_blank" rel="noopener"
               href="<?= e(wa_order_link($s['no_whatsapp'], 'Halo PakTjip, saya ingin memesan produk ' . $p['nama_produk'] . '. ' . ($p['harga'] > 0 ? 'Estimasi harga ' . harga_label($p) . '.' : 'Boleh minta info harganya?'))) ?>">Pesan</a>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <p class="empty-note" hidden>Tidak ada produk di kategori ini.</p>
  </div>
</section>

<!-- FOTO BREAK -->
<section class="fotobreak">
  <img src="<?= e($breakImg) ?>" alt="Banner besar terpasang" loading="lazy" width="1600" height="600">
  <div class="fb-inner">
    <h2>Butuh hari ini <em>nggak bisa nunggu?</em></h2>
    <p>Chat dulu — kalau slot produksi kosong, order kamu diproses hari itu juga.</p>
    <a class="btn btn-gold" href="<?= e(wa_order_link($s['no_whatsapp'], 'Halo PakTjip, saya butuh cepat. Masih bisa diproses hari ini?')) ?>" target="_blank" rel="noopener">Cek Slot Hari Ini</a>
  </div>
</section>

<!-- KALKULATOR -->
<section id="kalkulator">
  <div class="wrap calc-wrap">
    <div class="cats-head" style="margin:0">
      <h2>Hitung dulu, <em>order kemudian</em></h2>
      <p>Estimasi dari harga katalog resmi kami. Contoh: banner 2×3 m (6 m²) ≈ Rp132.000. Harga final dikonfirmasi PakTjip.</p>
    </div>
    <form class="calc" id="calc" novalidate>
      <div class="calc-field">
        <label for="calc-prod">Produk</label>
        <select id="calc-prod" required>
          <option value="banner|m2|22032">Banner — Rp22.032/m²</option>
          <option value="stempel|pcs|150000">Stempel Flash — Rp150rb</option>
          <option value="idcard|pcs|15000">ID Card — Rp15rb</option>
          <option value="plakat|pcs|175000">Plakat — Rp175rb</option>
          <option value="tumbler|pcs|17000">Tumbler — Rp17rb</option>
        </select>
      </div>
      <div class="calc-field" id="field-size">
        <label for="calc-size">Ukuran banner (m²)</label>
        <select id="calc-size">
          <option value="2">1 × 2 m (2 m²)</option>
          <option value="3">1 × 3 m (3 m²)</option>
          <option value="6" selected>2 × 3 m (6 m²)</option>
          <option value="10">2 × 5 m (10 m²)</option>
          <option value="12.5">2.5 × 5 m (12.5 m²)</option>
          <option value="custom">Ukuran lain…</option>
        </select>
      </div>
      <div class="calc-field" id="field-custom" hidden>
        <label for="calc-custom">Luas custom (m²)</label>
        <input type="number" id="calc-custom" min="0.5" max="100" step="0.5" value="6">
      </div>
      <div class="calc-field" id="field-qty">
        <label for="calc-qty">Jumlah</label>
        <input type="number" id="calc-qty" min="1" max="1000" step="1" value="1">
      </div>
      <div class="calc-result" aria-live="polite">
        <span class="price-label">Estimasi</span>
        <strong class="calc-total" id="calc-total">—</strong>
        <span class="calc-note" id="calc-note">*Cetak saja, belum termasuk pemasangan.</span>
        <a class="btn" id="calc-wa" href="#" target="_blank" rel="noopener">Lanjut ke WhatsApp</a>
      </div>
    </form>
  </div>
</section>

<!-- TENTANG KAMI -->
<section class="tentang" id="tentang">
  <div class="wrap">
    <div class="tentang-grid">
      <div class="tentang-copy">
        <h2>Dari Jampiroso, <em>untuk seluruh Indonesia</em></h2>
        <p><?= nl2br(e($s['tentang_kami'])) ?></p>
        <p class="sig">“Nek Ora PAKTJIP Ora”</p>
      </div>
      <div class="tentang-media">
        <img class="big" src="<?= e($tentangBig) ?>" alt="Workshop PakTjip" loading="lazy" width="700" height="875">
        <img class="small" src="<?= e($tentangSmall) ?>" alt="Detail hasil cetak" loading="lazy" width="400" height="400">
      </div>
    </div>
    <div class="tentang-stats">
      <div class="tstat"><strong>10+</strong><span>Tahun beroperasi</span></div>
      <div class="tstat"><strong>2022</strong><span>Terdaftar e-procurement</span></div>
      <div class="tstat"><strong>100%</strong><span>Produk dalam negeri</span></div>
    </div>
  </div>
</section>

<!-- B2B -->
<section class="b2bsec" id="b2b">
  <div class="wrap b2b-grid">
    <div class="b2b-head">
      <h2>Terdaftar di <em>e-procurement</em> nasional</h2>
      <p>Untuk instansi, sekolah, dan perusahaan: order resmi melalui platform pengadaan barang/jasa pemerintah dan swasta, dengan katalog &amp; harga terdaftar.</p>
      <div class="btn-row">
        <a class="btn btn-ghost" href="<?= e(wa_order_link($s['no_whatsapp'], 'Halo PakTjip, kami dari instansi/perusahaan, mau tanya pengadaan lewat e-procurement.')) ?>" target="_blank" rel="noopener">Konsultasi Pengadaan</a>
      </div>
    </div>
    <ol class="b2b-steps">
      <li class="reveal"><span class="step-n">01</span><div><h3>Order lewat platform</h3><p>Pesanan pengadaan diproses sesuai ketentuan platform e-procurement yang Anda gunakan — badan usaha resmi, katalog lengkap.</p></div></li>
      <li class="reveal"><span class="step-n">02</span><div><h3>Order terdaftar</h3><p>Pesan lewat platform sesuai ketentuan pengadaan — produk dengan badge PDN, status READY.</p></div></li>
      <li class="reveal"><span class="step-n">03</span><div><h3>Cetak &amp; terima</h3><p>Proses di workshop Temanggung, dikirim ke lokasi Anda. Bisa konsultasi dulu via WhatsApp.</p></div></li>
    </ol>
  </div>
</section>

<!-- GRAM STRIP -->
<section class="gram" id="galeri">
  <div class="wrap">
    <div class="gram-head">
      <h2>Langsung dari <em>workshop kami</em></h2>
      <p class="gram-hint">Geser untuk melihat →</p>
    </div>
    <div class="gram-track">
      <?php foreach ($galeri as $g): if (!is_file(__DIR__ . $g['gambar'])) continue; ?>
      <figure class="gram-item">
        <img src="<?= e($g['gambar']) ?>" alt="<?= e($g['judul'] ?: 'Hasil cetak PakTjip') ?>" width="468" height="468">
      </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="faqsec" id="faq">
  <div class="wrap">
    <div class="cats-head"><h2>Sering <em>ditanya</em></h2></div>
    <div class="faq-list">
      <?php foreach ($faq as $i => $f): ?>
      <details class="faq-item" <?= $i === 0 ? 'open' : '' ?>>
        <summary><span class="faq-n">0<?= $i + 1 ?></span><?= e($f['pertanyaan']) ?><span class="faq-x" aria-hidden="true"></span></summary>
        <div class="faq-a"><p><?= e($f['jawaban']) ?></p></div>
      </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- KONTAK -->
<section class="kontak" id="kontak">
  <div class="wrap">
    <div class="kontak-card">
      <div>
        <h2>Mampir ke <em>workshop</em></h2>
        <address class="kontak-addr"><?= e($s['alamat']) ?></address>
        <ul class="kontak-list">
          <li><a href="<?= e(wa_order_link($s['no_whatsapp'], 'Halo PakTjip!')) ?>" target="_blank" rel="noopener">WA <?= e($s['no_whatsapp']) ?></a></li>
          <li><a href="mailto:<?= e($s['email']) ?>"><?= e($s['email']) ?></a></li>
          <li><a href="https://www.instagram.com/paktjip_digital_printing/" target="_blank" rel="noopener"><?= e($s['instagram']) ?></a></li>
        </ul>
        <p class="open-state open-state-light" data-open-state data-hours="<?= e($s['jam_operasional']) ?>">
          <span class="dot <?= $isOpen ? 'on' : 'off' ?>" aria-hidden="true"></span>
          <?= $isOpen ? 'Buka sekarang · Sen–Sab 08.00–17.30' : 'Tutup · Sen–Sab 08.00–17.30 · Minggu tutup' ?>
        </p>
      </div>
      <div class="kontak-map">
        <iframe title="Lokasi PAKTJIP di Google Maps" src="https://www.google.com/maps?q=Jl.%20Jampiroso%20Utara%20No.%20196B%20Temanggung&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</section>

<script type="application/ld+json"><?= json_ld($s, $faq) ?></script>
<?php require __DIR__ . '/includes/footer.php'; ?>
