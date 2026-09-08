<?php require_once __DIR__ . '/auth-check.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($pageTitle) ? e_admin($pageTitle) . ' — ' : '' ?>Admin PAKTJIP</title>
<meta name="robots" content="noindex, nofollow">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,900&family=Figtree:wght@400;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:"Figtree",system-ui,sans-serif;background:#f7f7f5;color:#111;min-height:100vh}
a{color:inherit}
.layout{display:grid;grid-template-columns:230px 1fr;min-height:100vh}
.side{background:#111;color:#fff;padding:26px 18px;display:flex;flex-direction:column;gap:4px;position:sticky;top:0;height:100vh}
.side .logo{font-family:"Fraunces",serif;font-weight:900;font-size:20px;margin-bottom:26px;display:flex;gap:6px;align-items:center}
.side .logo .d{width:7px;height:7px;border-radius:50%;background:#f5c518}
.side a{display:block;text-decoration:none;color:#cfcfcf;padding:10px 14px;border-radius:8px;font-size:14px;font-weight:600}
.side a:hover{background:#2a2a2a;color:#fff}
.side a.on{background:#f5c518;color:#111}
.side .out{margin-top:auto;color:#8a8a8a;font-size:13px}
.main{padding:32px 36px;max-width:1100px}
h1{font-family:"Fraunces",serif;font-weight:900;font-size:26px;margin-bottom:4px}
.desc{color:#5f6368;font-size:14px;margin-bottom:26px}
table{width:100%;border-collapse:collapse;background:#fff;border:1px solid #e8e8e6;border-radius:12px;overflow:hidden;box-shadow:0 1px 2px rgba(17,17,17,.04)}
th{text-align:left;font-size:11.5px;text-transform:uppercase;letter-spacing:.08em;color:#5f6368;padding:12px 16px;border-bottom:1px solid #e8e8e6;background:#fafaf8}
td{padding:11px 16px;border-bottom:1px solid #f0f0ee;font-size:14px;vertical-align:middle}
tr:last-child td{border-bottom:0}
.btn{display:inline-block;background:#111;color:#fff;text-decoration:none;font-weight:700;font-size:13px;padding:9px 16px;border-radius:8px;border:0;cursor:pointer;font-family:inherit}
.btn:hover{background:#2a2a2a}
.btn-ghost{background:#fff;color:#111;border:1px solid #e8e8e6}
.btn-ghost:hover{background:#f0f0ee}
.btn-red{background:#c02626}.btn-red:hover{background:#a01f1f}
.btn-sm{padding:6px 12px;font-size:12px}
.card{background:#fff;border:1px solid #e8e8e6;border-radius:12px;padding:26px;box-shadow:0 1px 2px rgba(17,17,17,.04);margin-bottom:18px}
label{display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin:14px 0 6px;color:#2a2a2a}
input[type=text],input[type=number],input[type=url],select,textarea{width:100%;padding:11px 13px;border:1px solid #e8e8e6;border-radius:8px;font:inherit;background:#fff}
textarea{min-height:90px;resize:vertical}
input:focus,select:focus,textarea:focus{outline:2px solid #111;outline-offset:1px}
.row2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.flash{padding:12px 16px;border-radius:8px;font-size:14px;margin-bottom:18px;border:1px solid}
.flash.ok{background:#eafaf1;color:#116b3f;border-color:#bfe8d0}
.flash.err{background:#fdecec;color:#8a1f1f;border-color:#f5c2c2}
.thumb{width:52px;height:52px;object-fit:cover;border-radius:8px;background:#eee;display:block}
.actions{display:flex;gap:6px;flex-wrap:wrap}
.statrow{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:14px;margin-bottom:26px}
.stat{background:#fff;border:1px solid #e8e8e6;border-radius:12px;padding:20px;box-shadow:0 1px 2px rgba(17,17,17,.04)}
.stat b{font-family:"Fraunces",serif;font-size:30px;display:block}
.stat span{font-size:11.5px;text-transform:uppercase;letter-spacing:.1em;color:#5f6368}
img.prev{max-width:220px;border-radius:8px;display:block;margin-top:8px}
@media (max-width:820px){.layout{grid-template-columns:1fr}.side{position:static;height:auto;flex-direction:row;flex-wrap:wrap;align-items:center}.side .logo{margin-bottom:0;margin-right:12px}.main{padding:24px 18px}}
</style>
</head>
<body>
<div class="layout">
  <aside class="side">
    <div class="logo">PAKTJIP<span class="d"></span></div>
    <a href="/admin/dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'on' : '' ?>">Dashboard</a>
    <a href="/admin/produk/" class="<?= strpos($_SERVER['PHP_SELF'], '/produk/') !== false ? 'on' : '' ?>">Kelola Produk</a>
    <a href="/admin/galeri/" class="<?= strpos($_SERVER['PHP_SELF'], '/galeri/') !== false ? 'on' : '' ?>">Kelola Galeri</a>
    <a href="/admin/faq.php" class="<?= basename($_SERVER['PHP_SELF']) === 'faq.php' ? 'on' : '' ?>">Kelola FAQ</a>
    <a href="/admin/pengaturan.php" class="<?= basename($_SERVER['PHP_SELF']) === 'pengaturan.php' ? 'on' : '' ?>">Pengaturan Toko</a>
    <a href="/" target="_blank">Lihat Website ↗</a>
    <a class="out" href="/admin/logout.php">Keluar (<?= e_admin($_SESSION['admin_user'] ?? '') ?>)</a>
  </aside>
  <main class="main">
    <?php if ($f = flash_take()): ?><div class="flash <?= e_admin($f['type']) ?>"><?= e_admin($f['msg']) ?></div><?php endif; ?>
