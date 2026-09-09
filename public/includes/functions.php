<?php
require_once __DIR__ . '/../../config/database.php';

function e(?string $s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function rupiah($n): string {
    return 'Rp' . number_format((float)$n, 0, ',', '.');
}

// price label per satuan type
function harga_label(?array $p): string {
    if (!$p) return '';
    if ($p['satuan'] === 'tanya harga' || $p['harga'] === null || (float)$p['harga'] <= 0) {
        return 'Tanya harga';
    }
    $r = rupiah($p['harga']);
    return match ($p['satuan']) {
        'per m2 mulai'  => 'Mulai dari ' . $r . '/m²',
        'mulai dari'    => 'Mulai dari ' . $r,
        'per pcs'       => $r . '/pcs',
        'per lembar mulai' => 'Mulai dari ' . $r . '/lbr',
        default         => $r,
    };
}

function wa_order_link(string $wa, string $pesan): string {
    return 'https://wa.me/' . preg_replace('/\D/', '', $wa) . '?text=' . rawurlencode($pesan);
}

function get_settings(): array {
    static $s = null;
    if ($s === null) {
        $s = db()->query('SELECT * FROM pengaturan_toko WHERE id = 1')->fetch() ?: [];
    }
    return $s;
}

function get_categories(): array {
    return db()->query('SELECT * FROM kategori_produk ORDER BY id')->fetchAll();
}

function get_products(): array {
    return db()->query(
        "SELECT p.*, k.nama_kategori, k.slug AS kategori_slug, k.warna
         FROM produk p JOIN kategori_produk k ON k.id = p.kategori_id
         WHERE p.status != 'nonaktif'
         ORDER BY p.kategori_id, p.urutan, p.id"
    )->fetchAll();
}

function get_galeri(int $limit = 24): array {
    $stmt = db()->prepare('SELECT g.*, k.nama_kategori, k.slug AS kategori_slug FROM galeri g LEFT JOIN kategori_produk k ON k.id = g.kategori_id ORDER BY g.id DESC LIMIT ?');
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_faq(): array {
    return db()->query('SELECT * FROM faq ORDER BY urutan, id')->fetchAll();
}

// parse "08:00-17:30" -> [480, 1050]; closed day -> null
function jam_to_minutes(string $range): ?array {
    if (!preg_match('/^(\d{1,2}):(\d{2})\s*-\s*(\d{1,2}):(\d{2})$/', trim($range), $m)) return null;
    return [((int)$m[1]) * 60 + (int)$m[2], ((int)$m[3]) * 60 + (int)$m[4]];
}

function buka_sekarang(array $s): bool {
    $jam = json_decode($s['jam_operasional'] ?? '{}', true) ?: [];
    $days = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
    $today = $days[(int)date('w')];
    // senin-sabtu shared range
    $range = $jam[$today] ?? ($today !== 'minggu' ? ($jam['senin-sabtu'] ?? null) : null);
    if (!$range || $range === 'tutup') return false;
    $m = jam_to_minutes($range);
    if (!$m) return false;
    $now = (int)date('H') * 60 + (int)date('i');
    return $now >= $m[0] && $now < $m[1];
}

function jam_label(array $s): string {
    return 'Senin–Sabtu 08.00–17.30 · Minggu tutup';
}

function site_url(): string {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')
        || (($_SERVER['SERVER_PORT'] ?? '') == 443);
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    return ($https ? 'https' : 'http') . '://' . $host;
}

function json_ld(array $s, array $faq): string {
    $jam = json_decode($s['jam_operasional'] ?? '{}', true) ?: [];
    $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    $spec = [];
    for ($d = 1; $d <= 6; $d++) {
        $r = $jam[$days[$d] === 'Sunday' ? 'minggu' : 'senin-sabtu'] ?? null;
        if ($r && $r !== 'tutup' && ($m = jam_to_minutes($r))) {
            $spec[] = [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => $days[$d],
                'opens' => sprintf('%02d:%02d', intdiv($m[0], 60), $m[0] % 60),
                'closes' => sprintf('%02d:%02d', intdiv($m[1], 60), $m[1] % 60),
            ];
        }
    }
    $ld = [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => 'PAKTJIP Stempel & Digiprint — CV PakTjip Digital Printing',
        'description' => $s['tentang_kami'],
        'address' => ['@type' => 'PostalAddress', 'streetAddress' => $s['alamat'], 'addressRegion' => 'Jawa Tengah', 'addressLocality' => 'Temanggung', 'addressCountry' => 'ID'],
        'telephone' => '+' . preg_replace('/\D/', '', $s['no_whatsapp']),
        'email' => $s['email'],
        'url' => site_url(),
        'openingHoursSpecification' => $spec,
        'priceRange' => 'Rp3.000 - Rp8.100.000',
        'sameAs' => [
            'https://www.instagram.com/paktjip_digital_printing/',
        ],
    ];
    $ld['@graph'] = [[
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn($f) => [
            '@type' => 'Question',
            'name' => $f['pertanyaan'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['jawaban']],
        ], $faq),
    ]];
    return json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
