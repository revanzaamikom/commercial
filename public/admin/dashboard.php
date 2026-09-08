<?php
require_once __DIR__ . '/includes/auth-check.php';
require_once __DIR__ . '/includes/admin-functions.php';
$db = admin_db();
$stats = [
    'produk' => $db->query('SELECT COUNT(*) FROM produk')->fetchColumn(),
    'produk_ready' => $db->query("SELECT COUNT(*) FROM produk WHERE status = 'ready'")->fetchColumn(),
    'galeri' => $db->query('SELECT COUNT(*) FROM galeri')->fetchColumn(),
    'faq' => $db->query('SELECT COUNT(*) FROM faq')->fetchColumn(),
];
$pageTitle = 'Dashboard';
require __DIR__ . '/includes/header.php';
?>
<h1>Dashboard</h1>
<p class="desc">Ringkasan konten landing page. Semua perubahan langsung tampil di website.</p>
<div class="statrow">
  <div class="stat"><b><?= (int)$stats['produk'] ?></b><span>Produk</span></div>
  <div class="stat"><b><?= (int)$stats['produk_ready'] ?></b><span>Produk ready</span></div>
  <div class="stat"><b><?= (int)$stats['galeri'] ?></b><span>Foto galeri</span></div>
  <div class="stat"><b><?= (int)$stats['faq'] ?></b><span>FAQ</span></div>
</div>
<div class="card">
  <h3 style="margin-bottom:10px">Mulai cepat</h3>
  <p style="font-size:14px;color:#5f6368;line-height:1.7">
    Tambah produk baru di <a href="/admin/produk/tambah.php">Kelola Produk</a> — upload foto langsung jadi WebP otomatis.<br>
    Foto portofolio masuk lewat <a href="/admin/galeri/tambah.php">Kelola Galeri</a>.<br>
    Alamat, WA, jam buka di <a href="/admin/pengaturan.php">Pengaturan Toko</a>.
  </p>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
