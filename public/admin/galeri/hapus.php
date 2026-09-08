<?php
require_once __DIR__ . '/../includes/auth-check.php';
require_once __DIR__ . '/../includes/admin-functions.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /admin/galeri/'); exit; }
$db = admin_db();
$id = (int)($_POST['id'] ?? 0);
$stmt = $db->prepare('SELECT gambar FROM galeri WHERE id = ?');
$stmt->execute([$id]);
if ($row = $stmt->fetch()) {
    $db->prepare('DELETE FROM galeri WHERE id = ?')->execute([$id]);
    // remove file if not referenced elsewhere
    $chk = $db->prepare('SELECT COUNT(*) FROM galeri WHERE gambar = ?');
    $chk->execute([$row['gambar']]);
    if ((int)$chk->fetchColumn() === 0 && is_file(__DIR__ . '/../../' . $row['gambar'])) {
        @unlink(__DIR__ . '/../../' . $row['gambar']);
    }
    flash('ok', 'Foto dihapus.');
} else {
    flash('err', 'Foto tidak ditemukan.');
}
header('Location: /admin/galeri/');
exit;
