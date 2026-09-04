-- Seed data dari riset terverifikasi (Mbizmarket, Tisera, IG resmi @paktjip_digital_printing)
SET NAMES utf8mb4;

INSERT INTO kategori_produk (nama_kategori, slug, warna) VALUES
('Banner & Outdoor', 'banner-outdoor', '#FFC72C'),
('Stempel & Administrasi', 'stempel-administrasi', '#E4572E'),
('Merchandise & Custom', 'merchandise-custom', '#2E86AB'),
('Undangan & Lasercut', 'undangan-lasercut', '#7B2FBF');

-- Harga "mulai dari" dari scraping Tisera + Mbizmarket (Sep 2026)
INSERT INTO produk (kategori_id, nama_produk, deskripsi, harga, satuan, status, urutan) VALUES
(1, 'Banner FL280gr', 'Banner flexi 280gr, cetak full color, cocok untuk promosi & event. Tersedia semua ukuran custom.', 22032.00, 'per m2 mulai', 'ready', 1),
(1, 'Baliho + Pasang', 'Baliho besar lengkap dengan jasa pemasangan di titik lokasi Anda.', 755000.00, 'mulai dari', 'ready', 2),
(1, 'Papan Nama Akrilik', 'Papan nama akrilik custom, opsi neon box untuk tampilan malam.', 40000.00, 'mulai dari', 'ready', 3),
(1, 'Kain Bendera', 'Bendera kain full printing, 7 ukuran dari 20x15 s/d 300x200 cm.', 55000.00, 'mulai dari', 'ready', 4),
(2, 'Stempel Flash', 'Stempel flash cepat & rapi, ribuan impression tanpa tinta tumpah. Bisa desain sendiri atau dibantu.', 150000.00, 'per pcs', 'ready', 1),
(2, 'ID Card', 'ID card PVC full color untuk karyawan, anggota, dan event.', 15000.00, 'per pcs', 'ready', 2),
(2, 'Kop Dinas', 'Kop surat dinas & instansi, kertas berkualitas, tajam & presisi.', 3000.00, 'per lembar mulai', 'ready', 3),
(2, 'Stopmap & Blangko', 'Stopmap, kertas blangko, dan kebutuhan administrasi kantor.', 3500.00, 'mulai dari', 'ready', 4),
(3, 'Tumbler Custom', 'Tumbler custom sablon/printing untuk merchandise & hampers.', 17000.00, 'mulai dari', 'ready', 1),
(3, 'Blocknote A5', 'Blocknote custom logo untuk souvenir kantor & sekolah.', 29999.00, 'mulai dari', 'ready', 2),
(3, 'Plakat Akrilik', 'Plakat penghargaan akrilik custom untuk wisuda, seminar & event.', 175000.00, 'mulai dari', 'ready', 3),
(3, 'Lanyard & Tali ID', 'Lanyard custom printing untuk event & komunitas.', 20000.00, 'mulai dari', 'ready', 4),
(4, 'Undangan Custom', 'Undangan pernikahan & acara, katalog lengkap: CR7, Raffa, Griya Silver, Avis, Lite.', 0.00, 'tanya harga', 'ready', 1),
(4, 'Sign Lasercut', 'Papan nama & hiasan lasercut presisi tinggi dari akrilik/kayu.', 0.00, 'tanya harga', 'ready', 2),
(4, 'Sablon & Merchandise Event', 'Sablon kaos & merchandise massal untuk event komunitas.', 0.00, 'tanya harga', 'ready', 3);

INSERT INTO faq (pertanyaan, jawaban, urutan) VALUES
('Berapa lama proses pengerjaan?', 'Umumnya 1-3 hari kerja untuk banner dan stempel, tergantung jumlah & tingkat kesulitan. Order e-comers/event besar bisa didiskusikan langsung via WhatsApp.', 1),
('Bisa dibantu desain?', 'Bisa. Kirim ide atau contoh yang kamu suka, tim PakTjip bantu susun desainnya sampai siap cetak.', 2),
('Ada minimal order?', 'Untuk stempel, ID card, dan undangan tidak ada minimal order — 1 pcs jadi. Untuk sablon & merchandise tertentu berlaku minimal sesuai produk.', 3),
('Bisa kirim ke luar kota?', 'Bisa. Pesanan dikirim via ekspedisi ke seluruh Indonesia. Untuk area Temanggung & sekitarnya bisa COD/diambil langsung.', 4);

INSERT INTO pengaturan_toko
(id, alamat, no_whatsapp, email, instagram, jam_operasional, link_mbizmarket, link_tisera, link_maps, tentang_kami) VALUES
(1,
 'Jl. Jampiroso Utara No. 196B, Kel. Jampiroso, Kec. Temanggung, Kab. Temanggung, Jawa Tengah',
 '6282137215808',
 'stempelpaktjip@gmail.com',
 '@paktjip_digital_printing',
 '{"senin-sabtu":"08:00-17:30","minggu":"tutup"}',
 'https://www.mbizmarket.co.id/p/paktjip',
 'https://tisera.id/produk/show/paktjip-digital-printing-20250322092356',
 'https://g.co/kgs/4F9mae',
 'PAKTJIP Stempel & Digiprint adalah one-stop digital printing di Temanggung, Jawa Tengah. Berpengalaman belasan tahun melayani cetak digital, stempel, banner, sablon, undangan, hingga sign lasercut — dari kebutuhan personal sampai pengadaan instansi lewat e-procurement nasional (Mbizmarket & Tisera, terdaftar sejak 2022).');

-- admin default: username admin / password admin123 (WAJIB diganti) — hash dibuat saat setup admin
INSERT INTO admin (username, password) VALUES
('admin', '$2y$10$e0NRzXkVXQK7QpVuG3sOeeZ0kqXFFqvNJlC1GTcbQLYDnMceS8cDa'); -- admin123
