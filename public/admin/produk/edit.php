<?php
require_once __DIR__ . '/../includes/auth-check.php';
require_once __DIR__ . '/../includes/admin-functions.php';
$db = admin_db();

$id = (int)($_GET['id'] ?? 0);
$stmt = $db->prepare('SELECT * FROM produk WHERE id = ?');
$stmt->execute([$id]);
$prod = $stmt->fetch();
if (!$prod) { flash('err', 'Produk tidak ditemukan.'); header('Location: /admin/produk/'); exit; }

$kategoris = $db->query('SELECT * FROM kategori_produk ORDER BY id')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_produk'] ?? '');
    $kategoriId = (int)($_POST['kategori_id'] ?? 0);
    if ($nama === '' || !$kategoriId) {
        flash('err', 'Nama produk dan kategori wajib diisi.');
    } else {
        $img = save_upload_webp($_FILES['foto'] ?? []);
        $sql = 'UPDATE produk SET kategori_id = ?, nama_produk = ?, deskripsi = ?, harga = ?, satuan = ?, status = ?, urutan = ?';
        $args = [
            $kategoriId, $nama, trim($_POST['deskripsi'] ?? ''),
            $_POST['harga'] !== '' ? (float)$_POST['harga'] : null,
            trim($_POST['satuan'] ?? ''),
            in_array($_POST['status'] ?? '', ['ready', 'pre-order', 'nonaktif'], true) ? $_POST['status'] : 'ready',
            (int)($_POST['urutan'] ?? 0),
        ];
        if ($img) { $sql .= ', gambar_utama = ?'; $args[] = $img; }
        $sql .= ' WHERE id = ?'; $args[] = $id;
        $db->prepare($sql)->execute($args);
        flash('ok', 'Produk "' . $nama . '" diperbarui.');
        header('Location: /admin/produk/');
        exit;
    }
    $prod = array_merge($prod, array_intersect_key($_POST, $prod)); // re-fill form
}
$pageTitle = 'Edit Produk';
require __DIR__ . '/../includes/header.php';
?>
<h1>Edit Produk</h1>
<p class="desc"><?= e_admin($prod['nama_produk']) ?> — unggah foto baru untuk mengganti yang lama (lama otomatis diganti, bukan ditimpa path-nya).</p>
<div class="card">
  <form method="post" enctype="multipart/form-data">
    <label for="nama">Nama produk *</label>
    <input type="text" id="nama" name="nama_produk" required value="<?= e_admin($_POST['nama_produk'] ?? $prod['nama_produk']) ?>">
    <div class="row2">
      <div>
        <label for="kat">Kategori *</label>
        <select id="kat" name="kategori_id" required>
          <?php foreach ($kategoris as $k): ?>
          <option value="<?= (int)$k['id'] ?>" <?= ($_POST['kategori_id'] ?? $prod['kategori_id']) == $k['id'] ? 'selected' : '' ?>><?= e_admin($k['nama_kategori']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label for="st">Status</label>
        <select id="st" name="status">
          <?php foreach (['ready' => 'Ready', 'pre-order' => 'Pre-order', 'nonaktif' => 'Nonaktif (disembunyikan)'] as $sv => $sl): ?>
          <option value="<?= $sv ?>" <?= ($_POST['status'] ?? $prod['status']) === $sv ? 'selected' : '' ?>><?= $sl ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <label for="desk">Deskripsi</label>
    <textarea id="desk" name="deskripsi"><?= e_admin($_POST['deskripsi'] ?? $prod['deskripsi']) ?></textarea>
    <div class="row2">
      <div>
        <label for="hrg">Harga (Rp, kosongkan = tanya harga)</label>
        <input type="number" id="hrg" name="harga" min="0" step="1" value="<?= e_admin($_POST['harga'] ?? $prod['harga']) ?>">
      </div>
      <div>
        <label for="sat">Satuan</label>
        <input type="text" id="sat" name="satuan" value="<?= e_admin($_POST['satuan'] ?? $prod['satuan']) ?>">
      </div>
    </div>
    <label for="ur">Urutan tampil</label>
    <input type="number" id="ur" name="urutan" value="<?= (int)($_POST['urutan'] ?? $prod['urutan']) ?>">
    <label>Foto saat ini</label>
    <?php if ($prod['gambar_utama'] && is_file(__DIR__ . '/../../' . $prod['gambar_utama'])): ?>
      <img class="prev" src="<?= e_admin($prod['gambar_utama']) ?>" alt="foto produk">
    <?php else: ?><p style="font-size:13px;color:#5f6368">Belum ada foto.</p><?php endif; ?>
    <label for="foto">Ganti foto (opsional)</label>
    <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/webp">
    <p style="margin-top:20px"><button class="btn">Simpan Perubahan</button> <a class="btn btn-ghost" href="/admin/produk/">Batal</a></p>
  </form>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
