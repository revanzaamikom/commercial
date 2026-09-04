-- PAKTJIP Database Schema (sesuai rencana-lengkap-paktjip.pdf §4.2)
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS kategori_produk (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_kategori VARCHAR(100) NOT NULL,
  slug VARCHAR(100) NOT NULL UNIQUE,
  warna CHAR(7) NOT NULL DEFAULT '#FFC72C' -- pigmen tile per kategori (direction: Galeri Cetak)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS produk (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kategori_id INT NOT NULL,
  nama_produk VARCHAR(150) NOT NULL,
  deskripsi TEXT,
  harga DECIMAL(12,2) NULL,
  satuan VARCHAR(50) NULL, -- 'per m2', 'per pcs', 'mulai dari'
  status ENUM('ready','pre-order','nonaktif') DEFAULT 'ready',
  gambar_utama VARCHAR(255) NULL,
  urutan INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (kategori_id) REFERENCES kategori_produk(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS galeri (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(150) NULL,
  kategori_id INT NULL,
  gambar VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (kategori_id) REFERENCES kategori_produk(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS faq (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pertanyaan VARCHAR(255) NOT NULL,
  jawaban TEXT NOT NULL,
  urutan INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pengaturan_toko (
  id INT PRIMARY KEY, -- selalu 1
  alamat TEXT,
  no_whatsapp VARCHAR(20),
  email VARCHAR(100),
  instagram VARCHAR(100),
  jam_operasional VARCHAR(255), -- JSON: {"senin-sabtu":"08:00-17:30","minggu":"tutup"}
  link_mbizmarket VARCHAR(255) NULL,
  link_tisera VARCHAR(255) NULL,
  link_maps VARCHAR(255) NULL,
  tentang_kami TEXT
) ENGINE=InnoDB;
