<?php
require_once __DIR__ . '/includes/auth-check.php';
require_once __DIR__ . '/includes/admin-functions.php';
$db = admin_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jam = [
        'senin-sabtu' => trim($_POST['jam_seninsabtu'] ?? '') ?: '08:00-17:30',
        'minggu' => 'tutup',
    ];
    $stmt = $db->prepare('UPDATE pengaturan_toko SET alamat = ?, no_whatsapp = ?, email = ?, instagram = ?, jam_operasional = ?, link_maps = ?, tentang_kami = ? WHERE id = 1');
    $stmt->execute([
        trim($_POST['alamat'] ?? ''),
        preg_replace('/\D/', '', trim($_POST['no_whatsapp'] ?? '')),
        filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL) ?: '',
        trim($_POST['instagram'] ?? ''),
        json_encode($jam, JSON_UNESCAPED_SLASHES),
        trim($_POST['link_maps'] ?? ''),
        trim($_POST['tentang_kami'] ?? ''),
    ]);
    flash('ok', 'Pengaturan disimpan — landing page langsung ter-update.');
    header('Location: /admin/pengaturan.php');
    exit;
}

$s = $db->query('SELECT * FROM pengaturan_toko WHERE id = 1')->fetch() ?: [];
$jam = json_decode($s['jam_operasional'] ?? '{}', true) ?: [];
$pageTitle = 'Pengaturan Toko';
require __DIR__ . '/includes/header.php';
?>
<h1>Pengaturan Toko</h1>
<p class="desc">Kontak, jam operasional (dipakai badge buka/tutup otomatis), dan teks Tentang Kami.</p>
<div class="card">
  <form method="post">
    <label>Alamat lengkap</label>
    <textarea name="alamat" required><?= e_admin($s['alamat'] ?? '') ?></textarea>
    <div class="row2">
      <div>
        <label>No. WhatsApp (format 62…)</label>
        <input type="text" name="no_whatsapp" value="<?= e_admin($s['no_whatsapp'] ?? '') ?>" placeholder="6282137215808">
      </div>
      <div>
        <label>Email</label>
        <input type="text" name="email" value="<?= e_admin($s['email'] ?? '') ?>">
      </div>
    </div>
    <div class="row2">
      <div>
        <label>Instagram (@…)</label>
        <input type="text" name="instagram" value="<?= e_admin($s['instagram'] ?? '') ?>">
      </div>
      <div>
        <label>Jam Senin–Sabtu (format HH:MM-HH:MM)</label>
        <input type="text" name="jam_seninsabtu" value="<?= e_admin($jam['senin-sabtu'] ?? '08:00-17:30') ?>" placeholder="08:00-17:30">
      </div>
    </div>
    <label>Link Google Maps</label>
    <input type="url" name="link_maps" value="<?= e_admin($s['link_maps'] ?? '') ?>" placeholder="https://g.co/kgs/…">
    <label>Teks "Tentang Kami"</label>
    <textarea name="tentang_kami" style="min-height:130px"><?= e_admin($s['tentang_kami'] ?? '') ?></textarea>
    <p style="margin-top:20px"><button class="btn">Simpan Pengaturan</button></p>
  </form>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
