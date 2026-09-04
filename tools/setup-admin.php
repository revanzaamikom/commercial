<?php
// CLI-only: create/reset admin account. Usage: php setup-admin.php <username> <password>
// Run once after importing database/*.sql. Never exposes the DB publicly.
if (PHP_SAPI !== 'cli') { http_response_code(403); exit("CLI only\n"); }
require __DIR__ . '/../config/database.php';

if ($argc < 3) {
    fwrite(STDERR, "Usage: php setup-admin.php <username> <password>\n");
    exit(1);
}
[$_, $username, $password] = $argv;
if (!preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username)) { fwrite(STDERR, "Invalid username\n"); exit(1); }
if (strlen($password) < 8) { fwrite(STDERR, "Password min 8 chars\n"); exit(1); }

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = db()->prepare('SELECT id FROM admin WHERE username = ?');
$stmt->execute([$username]);
if ($row = $stmt->fetch()) {
    db()->prepare('UPDATE admin SET password = ? WHERE id = ?')->execute([$hash, $row['id']]);
    echo "admin '$username' password updated\n";
} else {
    db()->prepare('INSERT INTO admin (username, password) VALUES (?, ?)')->execute([$username, $hash]);
    echo "admin '$username' created\n";
}
