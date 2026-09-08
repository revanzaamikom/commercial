<?php
require_once __DIR__ . '/../../../config/database.php';

function admin_db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=127.0.0.1;dbname=paktjip;charset=utf8mb4',
            'root',
            '',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
    }
    return $pdo;
}

function e_admin(?string $s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

// Save uploaded image as WebP (max 1200px, q80). Returns webp path or null. Original discarded.
function save_upload_webp(array $file, string $subdir = ''): ?string {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) return null;
    if ($file['size'] > 8 * 1024 * 1024) return null;
    $info = @getimagesize($file['tmp_name']);
    if (!$info) return null;
    $im = match ($info['mime']) {
        'image/jpeg' => @imagecreatefromjpeg($file['tmp_name']),
        'image/png'  => @imagecreatefrompng($file['tmp_name']),
        'image/webp' => @imagecreatefromwebp($file['tmp_name']),
        default      => false,
    };
    if (!$im) return null;
    if ($info['mime'] === 'image/png') {
        $bg = imagecreatetruecolor(imagesx($im), imagesy($im));
        $white = imagecolorallocate($bg, 255, 255, 255);
        imagefill($bg, 0, 0, $white);
        imagecopy($bg, $im, 0, 0, 0, 0, imagesx($im), imagesy($im));
        $im = $bg;
    }
    $w = imagesx($im); $h = imagesy($im);
    if ($w > 1200) {
        $nh = (int)round($h * (1200 / $w));
        $d = imagecreatetruecolor(1200, $nh);
        imagecopyresampled($d, $im, 0, 0, 0, 0, 1200, $nh, $w, $h);
        $im = $d;
    }
    $dir = __DIR__ . '/../../../public/assets/uploads' . ($subdir !== '' ? '/' . $subdir : '');
    if (!is_dir($dir)) mkdir($dir, 0775, true);
    $name = date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.webp';
    if (!imagewebp($im, $dir . '/' . $name, 80)) return null;
    return '/assets/uploads' . ($subdir !== '' ? '/' . $subdir : '') . '/' . $name;
}

function flash(string $type, string $msg): void {
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}
function flash_take(): ?array {
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}
