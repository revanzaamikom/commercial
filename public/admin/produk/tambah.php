<?php
require_once __DIR__ . '/../includes/auth-check.php';
require_once __DIR__ . '/../includes/admin-functions.php';
$db = admin_db();

$kategoris = $db->query('SELECT * FROM kategori_produk ORDER BY id')->fetchAll();
$val = ['kategori_id' => '', 'nama_produk' => '', 'deskripsi' => '', 'harga' => '', 'satuan' => '', 'status' => 'ready', 'urutan' => '0'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $val = [
        'kategori_id' => (int)($_POST['kategori_id'] ?? 0),
        'nama_produk' => trim($_POST['nama_produk'] ?? ''),
        'deskripsi' => trim($_POST['deskripsi'] ?? ''),
        'harga' => $_POST['harga'] !== '' ? (float)$_POST['harga'] : null,
        'satuan' => trim($_POST['satuan'] ?? ''),
        'status' => in_array($_POST['status'] ?? '', ['ready', 'pre-order', 'nonaktif'], true) ? $_POST['status'] : 'ready',
        'urutan' => (int)($_POST['urutan'] ?? 0),
    ];
    if ($val['nama_produk'] === '' || !$val['kategori_id']) {
        flash('err', 'Nama produk dan kategori wajib diisi.');
    } else {
        $img = save_upload_webp($_FILES['foto'] ?? []);
        $stmt = $db->prepare('INSERT INTO produk (kategori_id, nama_produk, deskripsi, harga, satuan, status, gambar_utama, urutan) VALUES (?,?,?,?,?,?,?,?)');
        $stmt->execute([$val['kategori_id'], $val['nama_produk'], $val['deskripsi'], $val['harga'], $val['satuan'], $val['status'], $img, $val['urutan']]);
        flash('ok', 'Produk "' . $val['nama_produk'] . '" ditambahkan.' . ($img ? '' : ' (tanpa foto)'));
        header('Location: /admin/produk/');
        exit;
    }
}
$pageTitle = 'Tambah Produk';
require __DIR__ . '/../includes/header.php';
?>
<h1>Tambah Produk</h1>
<p class="desc">Foto otomatis dikonversi ke WebP (max 1200px) — jpg/png/webp, max 8MB.</p>
<div class="card">
  <form method="post" enctype="multipart/form-data">
    <label for="nama">Nama produk *</label>
    <input type="text" id="nama" name="nama_produk" required value="<?= e_admin($val['nama_produk']) ?>">
    <div class="row2">
      <div>
        <label for="kat">Kategori *</label>
        <select id="kat" name="kategori_id" required>
          <?php foreach ($kategoris as $k): ?>
          <option value="<?= (int)$k['id'] ?>" <?= $val['kategori_id'] == $k['id'] ? 'selected' : '' ?>><?= e_admin($k['nama_kategori']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label for="st">Status</label>
        <select id="st" name="status">
          <option value="ready" <?= $val['status'] === 'ready' ? 'selected' : '' ?>>Ready</option>
          <option value="pre-order" <?= $val['status'] === 'pre-order' ? 'selected' : '' ?>>Pre-order</option>
          <option value="nonaktif" <?= $val['status'] === 'nonaktif' ? 'selected' : '' ?>>Nonaktif (disembunyikan)</option>
        </select>
      </div>
    </div>
    <label for="desk">Deskripsi</label>
    <textarea id="desk" name="deskripsi"><?= e_admin($val['deskripsi']) ?></textarea>
    <div class="row2">
      <div>
        <label for="hrg">Harga (Rp, kosongkan = tanya harga)</label>
        <input type="number" id="hrg" name="harga" min="0" step="1" value="<?= e_admin($val['harga']) ?>">
      </div>
      <div>
        <label for="sat">Satuan (mis. "m2 mulai", "pcs")</label>
        <input type="text" id="sat" name="satuan" value="<?= e_admin($val['satuan']) ?>">
      </div>
    </div>
    <label for="ur">Urutan tampil</label>
    <input type="number" id="ur" name="urutan" value="<?= (int)$val['urutan'] ?>">
    <label for="foto">Foto produk</label>
    <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/webp">
    <p style="margin-top:20px"><button class="btn">Simpan Produk</button> <a class="btn btn-ghost" href="/admin/produk/">Batal</a></p>
  </form>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
