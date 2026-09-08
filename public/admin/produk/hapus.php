<?php
require_once __DIR__ . '/../includes/auth-check.php';
require_once __DIR__ . '/../includes/admin-functions.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /admin/produk/'); exit; }
$db = admin_db();
$id = (int)($_POST['id'] ?? 0);
$stmt = $db->prepare('SELECT nama_produk FROM produk WHERE id = ?');
$stmt->execute([$id]);
if ($row = $stmt->fetch()) {
    $db->prepare('DELETE FROM produk WHERE id = ?')->execute([$id]);
    flash('ok', 'Produk "' . $row['nama_produk'] . '" dihapus.');
} else {
    flash('err', 'Produk tidak ditemukan.');
}
header('Location: /admin/produk/');
exit;
