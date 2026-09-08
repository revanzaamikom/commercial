<?php
require_once __DIR__ . '/../includes/auth-check.php';
require_once __DIR__ . '/../includes/admin-functions.php';
$db = admin_db();
$pageTitle = 'Kelola Produk';
require __DIR__ . '/../includes/header.php';

$produk = $db->query(
    'SELECT p.*, k.nama_kategori FROM produk p JOIN kategori_produk k ON k.id = p.kategori_id ORDER BY p.kategori_id, p.urutan, p.id'
)->fetchAll();
$kategoris = $db->query('SELECT * FROM kategori_produk ORDER BY id')->fetchAll();
?>
<h1>Kelola Produk</h1>
<p class="desc">Produk "nonaktif" disembunyikan dari landing page tanpa dihapus.</p>
<p style="margin-bottom:16px"><a class="btn" href="/admin/produk/tambah.php">+ Tambah Produk</a></p>
<table>
  <tr><th>Foto</th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Status</th><th style="width:170px">Aksi</th></tr>
  <?php foreach ($produk as $p): ?>
  <tr>
    <td><?php if ($p['gambar_utama'] && is_file(__DIR__ . '/../../' . $p['gambar_utama'])): ?>
      <img class="thumb" src="<?= e_admin($p['gambar_utama']) ?>" alt="">
    <?php else: ?><span style="color:#bbb">—</span><?php endif; ?></td>
    <td><strong><?= e_admin($p['nama_produk']) ?></strong></td>
    <td><?= e_admin($p['nama_kategori']) ?></td>
    <td><?= $p['harga'] !== null ? 'Rp' . number_format((float)$p['harga'], 0, ',', '.') . ($p['satuan'] ? ' /' . e_admin($p['satuan']) : '') : '<em style="color:#bbb">tanya</em>' ?></td>
    <td><?= e_admin($p['status']) ?></td>
    <td class="actions">
      <a class="btn btn-sm btn-ghost" href="/admin/produk/edit.php?id=<?= (int)$p['id'] ?>">Edit</a>
      <form method="post" action="/admin/produk/hapus.php" style="display:contents" onsubmit="return confirm('Hapus produk <?= e_admin($p['nama_produk']) ?>?')">
        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
        <button class="btn btn-sm btn-red">Hapus</button>
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
<p style="margin-top:14px;font-size:13px;color:#5f6368">Kategori (read-only): <?= e_admin(implode(' · ', array_column($kategoris, 'nama_kategori'))) ?></p>
<?php require __DIR__ . '/../includes/footer.php'; ?>
