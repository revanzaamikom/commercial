<?php
require_once __DIR__ . '/includes/functions.php';
$s = get_settings();
$categories = get_categories();
$products = get_products();
$galeri = get_galeri(12);
$faq = get_faq();
$isOpen = buka_sekarang($s);
require __DIR__ . '/includes/header.php';
?>
<main>
<!--
IMPECCABLE DIRECTION CONTRACT — "Galeri Cetak" (editorial print-gallery) — seed 877f1e7c, code-led, brief-pinned by user reference (NFT art-gallery demo), adapted not copied.
THESIS: an art gallery hung with real print work — monochrome paper chrome, the work is the only saturated color; refuses the generic green "web-printer" template and cream+serif AI default.
OWN-WORLD: paper #FCFCFC, panel #F7F7F5, ink #111, hairline #E5E5E5, brand gold #FFC72C, zero radius, Fraunces roman+italic display, Anton numerals-accent, Figtree text, uppercase tracked eyebrows, binary black filled/outline buttons, glass price card, pigment bars per category.
STORY: visitor reads tagline + badge in 5s, trusts via verified "mulai dari" prices and e-procurement registration, orders via prefilled WhatsApp.
FIRST VIEWPORT: hairline top bar (open/closed dot left, e-proc badge right); hero centered: eyebrow, H1 "Nek Ora PAKTJIP Ora" (Ora italic gold), one-line sub, button pair (Pesan via WA filled / Lihat Katalog outline), below: 4 pigment category tiles with counts.
FORM: brief-pinned gallery-editorial; category tiles derived from chromatophore donation, glass card from reference.
FINISH: unreviewed and undocumented is unfinished; this build ends with the finish review, the verdict, DESIGN.md, and every shipping raster carrying its provenance.
-->
<header class="topbar">
  <div class="wrap topbar-in">
    <span class="open-state" data-open-state data-hours="<?= e($s['jam_operasional']) ?>">
      <span class="dot <?= $isOpen ? 'on' : 'off' ?>" aria-hidden="true"></span>
      <?= $isOpen ? 'Buka sekarang' : 'Tutup — buka 08.00' ?>
    </span>
    <span class="topbar-badge">Terdaftar e-Procurement · Mbizmarket · Tisera</span>
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
      <a href="#kalkulator">Estimasi Harga</a>
      <a href="#galeri">Galeri</a>
      <a href="#faq">FAQ</a>
      <a href="#kontak">Kontak</a>
      <a class="btn btn-sm" href="<?= e(wa_order_link($s['no_whatsapp'], 'Halo PakTjip, saya mau pesan.')) ?>" target="_blank" rel="noopener">Pesan via WA</a>
    </div>
  </div>
</nav>

<!-- ============ HERO ============ -->
<section class="hero">
  <div class="wrap hero-in">
    <p class="eyebrow">One-stop digital printing · Temanggung</p>
    <h1 class="hero-title">Nek Ora PAKTJIP <em>Ora</em></h1>
    <p class="hero-sub">Cetak digital, stempel, banner, undangan, sablon &amp; lasercut — dari pesanan satuan sampai pengadaan instansi.</p>
    <div class="btn-row">
      <a class="btn" href="<?= e(wa_order_link($s['no_whatsapp'], 'Halo PakTjip, saya mau pesan.')) ?>" target="_blank" rel="noopener">Pesan via WhatsApp</a>
      <a class="btn btn-ghost" href="#katalog">Lihat Katalog</a>
    </div>
    <div class="cat-tiles" role="list" aria-label="Kategori produk">
      <?php foreach ($categories as $c):
        $n = count(array_filter($products, fn($p) => $p['kategori_slug'] === $c['slug'])); ?>
      <a role="listitem" class="cat-tile" href="#katalog" data-cat-link="<?= e($c['slug']) ?>">
        <span class="cat-pigment" style="--pig:<?= e($c['warna']) ?>" aria-hidden="true"></span>
        <span class="cat-name"><?= e($c['nama_kategori']) ?></span>
        <span class="cat-count"><?= $n ?> produk</span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ PROOF STRIP ============ -->
<section class="proof" aria-label="Kepercayaan">
  <div class="wrap proof-grid">
    <div class="proof-item"><strong>10+ tahun</strong><span>berpengalaman melayani cetak Temanggung</span></div>
    <div class="proof-item"><strong>2022</strong><span>terdaftar e-procurement nasional (Mbizmarket &amp; Tisera)</span></div>
    <div class="proof-item"><strong>READY</strong><span>stok ready — order hari ini, proses hari ini</span></div>
    <div class="proof-item"><strong>PDN</strong><span>produk dalam negeri · Bangga Buatan Indonesia</span></div>
  </div>
</section>

<!-- ============ KATALOG ============ -->
<section class="section" id="katalog">
  <div class="wrap">
    <div class="sec-head">
      <p class="eyebrow">Katalog produk</p>
      <h2>Semua yang bisa dicetak, <em>siap order</em></h2>
      <p class="sec-sub">Harga “mulai dari” riil dari katalog resmi kami di Mbizmarket &amp; Tisera. Klik produk — WhatsApp terbuka dengan pesan terisi.</p>
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
      <?php foreach ($products as $p): ?>
      <article class="prod-card reveal" data-cat="<?= e($p['kategori_slug']) ?>" style="--pig:<?= e($p['warna']) ?>">
        <div class="prod-head">
          <span class="prod-cat"><?= e($p['nama_kategori']) ?></span>
          <span class="prod-status st-<?= e($p['status']) ?>"><?= e($p['status']) ?></span>
        </div>
        <h3 class="prod-name"><?= e($p['nama_produk']) ?></h3>
        <p class="prod-desc"><?= e($p['deskripsi']) ?></p>
        <div class="glass prod-price">
          <span class="price-label"><?= $p['satuan'] === 'tanya harga' ? 'Harga' : 'Mulai dari' ?></span>
          <span class="price-val"><?= e(harga_label($p)) ?></span>
          <a class="btn btn-sm btn-block" target="_blank" rel="noopener"
             href="<?= e(wa_order_link($s['no_whatsapp'], 'Halo PakTjip, saya ingin memesan produk ' . $p['nama_produk'] . '. ' . ($p['harga'] > 0 ? 'Estimasi harga ' . harga_label($p) . '.' : 'Boleh minta info harganya?'))) ?>">
            Pesan produk ini
          </a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <p class="empty-note" hidden>Tidak ada produk di kategori ini.</p>
  </div>
</section>

<!-- ============ KALKULATOR ============ -->
<section class="section section-panel" id="kalkulator">
  <div class="wrap calc-wrap">
    <div class="sec-head sec-left">
      <p class="eyebrow">Kalkulator estimasi</p>
      <h2>Hitung dulu, <em>order kemudian</em></h2>
      <p class="sec-sub">Estimasi kasar berdasarkan harga katalog resmi kami. Harga final dikonfirmasi PakTjip via WhatsApp. Contoh: banner 2×3 m (6 m²) ≈ Rp132.000.</p>
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
      <div class="calc-result glass" aria-live="polite">
        <span class="price-label">Estimasi</span>
        <strong class="calc-total" id="calc-total">—</strong>
        <span class="calc-note" id="calc-note">Belum termasuk ongkir &amp; pemasangan.</span>
        <a class="btn btn-block" id="calc-wa" href="#" target="_blank" rel="noopener">Lanjut ke WhatsApp</a>
      </div>
    </form>
  </div>
</section>

<!-- ============ CARA ORDER ============ -->
<section class="section" id="cara-order" aria-label="Cara order">
  <div class="wrap">
    <div class="sec-head sec-left">
      <p class="eyebrow">Cara order</p>
      <h2>Empat langkah, <em>langsung jadi</em></h2>
    </div>
    <ol class="b2b-steps cara-steps">
      <li class="reveal"><span class="step-n">01</span><div><h3>Chat WhatsApp</h3><p>Klik “Pesan” di produk — pesan terisi otomatis. Atau langsung ke <?= e($s['no_whatsapp']) ?>.</p></div></li>
      <li class="reveal"><span class="step-n">02</span><div><h3>Konsultasi &amp; desain</h3><p>Kirim file desain atau ceritakan kebutuhan — dibantu sampai siap cetak.</p></div></li>
      <li class="reveal"><span class="step-n">03</span><div><h3>Produksi</h3><p>Cetak di workshop Jampiroso. Umumnya 1–3 hari kerja sesuai pesanan.</p></div></li>
      <li class="reveal"><span class="step-n">04</span><div><h3>Ambil atau kirim</h3><p>Ambil di workshop, atau ekspedisi ke seluruh Indonesia.</p></div></li>
    </ol>
  </div>
</section>

<!-- ============ B2B ============ -->
<section class="section" id="b2b">
  <div class="wrap b2b-grid">
    <div class="sec-head sec-left">
      <p class="eyebrow">Pengadaan resmi · B2B</p>
      <h2>Terdaftar di <em>e-procurement</em> nasional</h2>
      <p class="sec-sub">Untuk instansi, sekolah, dan perusahaan: order resmi melalui platform pengadaan, dengan katalog &amp; harga terdaftar.</p>
      <div class="btn-row">
        <a class="btn btn-ghost" href="<?= e($s['link_mbizmarket']) ?>" target="_blank" rel="noopener">Katalog Mbizmarket</a>
        <a class="btn btn-ghost" href="<?= e($s['link_tisera']) ?>" target="_blank" rel="noopener">Katalog Tisera</a>
      </div>
    </div>
    <ol class="b2b-steps">
      <li class="reveal"><span class="step-n">01</span><div><h3>Temukan kami</h3><p>Cari “PakTjip Digital Printing” di Mbizmarket atau Tisera — badan usaha resmi, katalog lengkap.</p></div></li>
      <li class="reveal"><span class="step-n">02</span><div><h3>Order terdaftar</h3><p>Pesan lewat platform sesuai ketentuan pengadaan — produk dengan badge PDN, status READY.</p></div></li>
      <li class="reveal"><span class="step-n">03</span><div><h3>Cetak &amp; terima</h3><p>Proses di workshop Temanggung, dikirim ke lokasi Anda. Bisa konsultasi dulu via WhatsApp.</p></div></li>
    </ol>
  </div>
</section>

<!-- ============ GALERI ============ -->
<section class="section section-panel" id="galeri">
  <div class="wrap">
    <div class="sec-head">
      <p class="eyebrow">Galeri portofolio</p>
      <h2>Hasil cetak <em>bicara sendiri</em></h2>
      <p class="sec-sub">Foto nyata dari workshop kami — undangan dan sign lasercut.</p>
    </div>
    <?php if ($galeri): ?>
    <div class="galeri-grid">
      <?php foreach ($galeri as $i => $g): if (!is_file(__DIR__ . $g['gambar'])) continue; ?>
      <figure class="galeri-item reveal<?= $i % 7 === 0 ? ' wide' : '' ?>" data-cat="<?= e($g['kategori_slug'] ?? 'lainnya') ?>">
        <img src="<?= e($g['gambar']) ?>" alt="<?= e($g['judul'] ?: 'Hasil cetak PakTjip') ?>" loading="lazy" width="1200" height="900">
        <figcaption><?= e($g['judul'] ?: ($g['nama_kategori'] ?: 'PAKTJIP')) ?></figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-note">Galeri menyusul — foto diisi dari admin panel.</div>
    <?php endif; ?>
  </div>
</section>

<!-- ============ FAQ ============ -->
<section class="section" id="faq">
  <div class="wrap faq-wrap">
    <div class="sec-head sec-left">
      <p class="eyebrow">FAQ</p>
      <h2>Sering <em>ditanya</em></h2>
    </div>
    <div class="faq-list">
      <?php foreach ($faq as $i => $f): ?>
      <details class="faq-item reveal" <?= $i === 0 ? 'open' : '' ?>>
        <summary><span class="faq-n">0<?= $i + 1 ?></span><?= e($f['pertanyaan']) ?><span class="faq-x" aria-hidden="true"></span></summary>
        <div class="faq-a"><p><?= e($f['jawaban']) ?></p></div>
      </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ KONTAK ============ -->
<section class="section section-ink" id="kontak">
  <div class="wrap kontak-grid">
    <div class="sec-head sec-left">
      <p class="eyebrow eyebrow-light">Kontak &amp; lokasi</p>
      <h2>Mampir ke <em>workshop</em></h2>
      <address class="kontak-addr"><?= e($s['alamat']) ?></address>
      <ul class="kontak-list">
        <li><a href="<?= e(wa_order_link($s['no_whatsapp'], 'Halo PakTjip!')) ?>" target="_blank" rel="noopener">WA <?= e($s['no_whatsapp']) ?></a></li>
        <li><a href="mailto:<?= e($s['email']) ?>"><?= e($s['email']) ?></a></li>
        <li><a href="https://www.instagram.com/paktjip_digital_printing/" target="_blank" rel="noopener"><?= e($s['instagram']) ?></a></li>
      </ul>
      <p class="open-state open-state-light" data-open-state data-hours="<?= e($s['jam_operasional']) ?>">
        <span class="dot <?= $isOpen ? 'on' : 'off' ?>" aria-hidden="true"></span>
        <?= $isOpen ? 'Buka sekarang · ' . e(jam_label($s)) : 'Tutup · ' . e(jam_label($s)) ?>
      </p>
    </div>
    <div class="kontak-map">
      <iframe title="Lokasi PAKTJIP di Google Maps" src="https://www.google.com/maps?q=Jl.%20Jampiroso%20Utara%20No.%20196B%20Temanggung&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
    </div>
  </div>
</section>

<script type="application/ld+json"><?= json_ld($s, $faq) ?></script>
<?php require __DIR__ . '/includes/footer.php'; ?>
