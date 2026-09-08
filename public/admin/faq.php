<?php
require_once __DIR__ . '/includes/auth-check.php';
require_once __DIR__ . '/includes/admin-functions.php';
$db = admin_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $act = $_POST['act'] ?? '';
    if ($act === 'add') {
        $q = trim($_POST['pertanyaan'] ?? '');
        $a = trim($_POST['jawaban'] ?? '');
        if ($q !== '' && $a !== '') {
            $ur = (int)($_POST['urutan'] ?? 0);
            $db->prepare('INSERT INTO faq (pertanyaan, jawaban, urutan) VALUES (?,?,?)')->execute([$q, $a, $ur]);
            flash('ok', 'FAQ ditambahkan.');
        } else flash('err', 'Pertanyaan & jawaban wajib diisi.');
    } elseif ($act === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $q = trim($_POST['pertanyaan'] ?? '');
        $a = trim($_POST['jawaban'] ?? '');
        $ur = (int)($_POST['urutan'] ?? 0);
        if ($id && $q !== '' && $a !== '') {
            $db->prepare('UPDATE faq SET pertanyaan = ?, jawaban = ?, urutan = ? WHERE id = ?')->execute([$q, $a, $ur, $id]);
            flash('ok', 'FAQ diperbarui.');
        }
    } elseif ($act === 'delete') {
        $db->prepare('DELETE FROM faq WHERE id = ?')->execute([(int)($_POST['id'] ?? 0)]);
        flash('ok', 'FAQ dihapus.');
    }
    header('Location: /admin/faq.php');
    exit;
}

$faqs = $db->query('SELECT * FROM faq ORDER BY urutan, id')->fetchAll();
$pageTitle = 'Kelola FAQ';
require __DIR__ . '/includes/header.php';
?>
<h1>Kelola FAQ</h1>
<p class="desc">Urutan kecil tampil duluan. Nomor 0<?= count($faqs) + 1 ?> otomatis untuk FAQ baru.</p>

<div class="card">
  <h3 style="margin-bottom:8px">Tambah FAQ</h3>
  <form method="post">
    <input type="hidden" name="act" value="add">
    <label>Pertanyaan *</label>
    <input type="text" name="pertanyaan" required>
    <label>Jawaban *</label>
    <textarea name="jawaban" required></textarea>
    <label>Urutan</label>
    <input type="number" name="urutan" value="<?= count($faqs) + 1 ?>" style="max-width:120px">
    <p style="margin-top:14px"><button class="btn">Tambah</button></p>
  </form>
</div>

<?php foreach ($faqs as $f): ?>
<div class="card">
  <form method="post">
    <input type="hidden" name="act" value="edit">
    <input type="hidden" name="id" value="<?= (int)$f['id'] ?>">
    <label>Pertanyaan</label>
    <input type="text" name="pertanyaan" value="<?= e_admin($f['pertanyaan']) ?>">
    <label>Jawaban</label>
    <textarea name="jawaban"><?= e_admin($f['jawaban']) ?></textarea>
    <label>Urutan</label>
    <input type="number" name="urutan" value="<?= (int)$f['urutan'] ?>" style="max-width:120px">
    <p style="margin-top:14px" class="actions">
      <button class="btn">Simpan</button>
      <button class="btn btn-red" formaction="/admin/faq.php" onclick="this.form.act.value='delete'">Hapus</button>
    </p>
  </form>
</div>
<?php endforeach; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
