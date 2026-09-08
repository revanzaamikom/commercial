<?php
// Salin file ini jadi config/database.php lalu isi kredensial asli (jangan di-commit).
function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=127.0.0.1;dbname=paktjip;charset=utf8mb4',
            'GANTI_USER',
            'GANTI_PASSWORD',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
    }
    return $pdo;
}
