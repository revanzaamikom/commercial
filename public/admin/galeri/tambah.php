<?php
require_once __DIR__ . '/../includes/auth-check.php';
require_once __DIR__ . '/../includes/admin-functions.php';
$db = admin_db();
$kategoris = $db->query('SELECT * FROM kategori_produk ORDER BY id')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $img = save_upload_webp($_FILES['foto'] ?? []);
    if (!$img) {
        flash('err', 'Foto wajib dipilih (jpg/png/webp, max 8MB).');
    } else {
        $judul = trim($_POST['judul'] ?? '');
        $kat = (int)($_POST['kategori_id'] ?? 0) ?: null;
        $db->prepare('INSERT INTO galeri (judul, kategori_id, gambar) VALUES (?,?,?)')->execute([$judul ?: null, $kat, $img]);
        flash('ok', 'Foto ditambahkan ke galeri.');
        header('Location: /admin/galeri/');
        exit;
    }
}
$pageTitle = 'Tambah Foto';
require __DIR__ . '/../includes/header.php';
?>
<h1>Tambah Foto Galeri</h1>
<p class="desc">Foto dikonversi otomatis ke WebP max 1200px.</p>
<div class="card">
  <form method="post" enctype="multipart/form-data">
    <label for="foto">Foto *</label>
    <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/webp" required>
    <label for="judul">Judul (opsional)</label>
    <input type="text" id="judul" name="judul" placeholder="mis. Undangan Raffa — sablon akrilik">
    <label for="kat">Kategori (opsional)</label>
    <select id="kat" name="kategori_id">
      <option value="">— tanpa kategori —</option>
      <?php foreach ($kategoris as $k): ?>
      <option value="<?= (int)$k['id'] ?>"><?= e_admin($k['nama_kategori']) ?></option>
      <?php endforeach; ?>
    </select>
    <p style="margin-top:20px"><button class="btn">Simpan Foto</button> <a class="btn btn-ghost" href="/admin/galeri/">Batal</a></p>
  </form>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
