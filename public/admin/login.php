<?php
require_once __DIR__ . '/includes/admin-functions.php';
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
    session_start();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';
    $stmt = admin_db()->prepare('SELECT id, password FROM admin WHERE username = ?');
    $stmt->execute([$u]);
    $row = $stmt->fetch();
    if ($row && password_verify($p, $row['password'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$row['id'];
        $_SESSION['admin_user'] = $u;
        header('Location: /admin/dashboard.php');
        exit;
    }
    $error = 'Username atau password salah.';
    usleep(300000); // slow brute force
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin — PAKTJIP</title>
<meta name="robots" content="noindex, nofollow">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,900&family=Figtree:wght@400;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:"Figtree",system-ui,sans-serif;background:#f7f7f5;color:#111;min-height:100vh;display:grid;place-items:center;padding:24px}
.card{background:#fff;border:1px solid #e8e8e6;border-radius:16px;padding:40px;width:100%;max-width:380px;box-shadow:0 8px 24px rgba(17,17,17,.07)}
.brand{font-family:"Fraunces",serif;font-weight:900;font-size:24px;display:flex;align-items:center;gap:6px;margin-bottom:6px}
.brand .d{width:8px;height:8px;border-radius:50%;background:#f5c518}
.sub{font-size:13px;color:#5f6368;margin-bottom:26px}
label{display:block;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;color:#2a2a2a}
input{width:100%;padding:12px 14px;border:1px solid #e8e8e6;border-radius:8px;font:inherit;margin-bottom:16px;background:#fff}
input:focus{outline:2px solid #111;outline-offset:2px;border-color:#111}
button{width:100%;padding:13px;background:#111;color:#fff;border:0;border-radius:8px;font:inherit;font-weight:700;cursor:pointer}
button:hover{background:#2a2a2a}
.err{background:#fdecec;color:#8a1f1f;border:1px solid #f5c2c2;border-radius:8px;padding:10px 14px;font-size:13.5px;margin-bottom:16px}
.back{display:block;text-align:center;font-size:13px;color:#5f6368;margin-top:18px;text-decoration:none}
.back:hover{text-decoration:underline}
</style>
</head>
<body>
<div class="card">
  <div class="brand">PAKTJIP<span class="d"></span></div>
  <p class="sub">Panel pengelola konten landing page.</p>
  <?php if ($error): ?><div class="err"><?= e_admin($error) ?></div><?php endif; ?>
  <form method="post" autocomplete="off">
    <label for="u">Username</label>
    <input id="u" name="username" required autofocus>
    <label for="p">Password</label>
    <input id="p" name="password" type="password" required>
    <button>Masuk</button>
  </form>
  <a class="back" href="/">← Kembali ke website</a>
</div>
</body>
</html>
