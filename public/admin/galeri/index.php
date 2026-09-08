<?php
require_once __DIR__ . '/../includes/auth-check.php';
require_once __DIR__ . '/../includes/admin-functions.php';
$db = admin_db();
$pageTitle = 'Kelola Galeri';
require __DIR__ . '/../includes/header.php';

$galeri = $db->query(
    'SELECT g.*, k.nama_kategori FROM galeri g LEFT JOIN kategori_produk k ON k.id = g.kategori_id ORDER BY g.id DESC'
)->fetchAll();
$kategoris = $db->query('SELECT * FROM kategori_produk ORDER BY id')->fetchAll();
?>
<h1>Kelola Galeri</h1>
<p class="desc">Foto tampil di gram strip landing page (maks 10 terbaru otomatis terpilih) + proof hero.</p>
<p style="margin-bottom:16px"><a class="btn" href="/admin/galeri/tambah.php">+ Tambah Foto</a></p>
<table>
  <tr><th>Foto</th><th>Judul</th><th>Kategori</th><th style="width:110px">Aksi</th></tr>
  <?php foreach ($galeri as $g): ?>
  <tr>
    <td><?php if (is_file(__DIR__ . '/../../' . $g['gambar'])): ?>
      <img class="thumb" src="<?= e_admin($g['gambar']) ?>" alt="">
    <?php else: ?><span style="color:#c02626">file hilang</span><?php endif; ?></td>
    <td><?= e_admin($g['judul'] ?: '—') ?></td>
    <td><?= e_admin($g['nama_kategori'] ?: '—') ?></td>
    <td class="actions">
      <form method="post" action="/admin/galeri/hapus.php" onsubmit="return confirm('Hapus foto ini?')">
        <input type="hidden" name="id" value="<?= (int)$g['id'] ?>">
        <button class="btn btn-sm btn-red">Hapus</button>
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
<?php require __DIR__ . '/../includes/footer.php'; ?>
