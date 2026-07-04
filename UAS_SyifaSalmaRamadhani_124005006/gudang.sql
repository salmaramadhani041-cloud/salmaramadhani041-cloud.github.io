-- =========================================================
-- GUDANG PERINTILAN — Skema Database
-- Jalankan berkas ini di tab SQL phpMyAdmin
-- =========================================================

CREATE DATABASE IF NOT EXISTS db_gudang;
USE db_gudang;

-- Tabel akun pengguna (login & registrasi)
CREATE TABLE IF NOT EXISTS users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(50)  NOT NULL UNIQUE,
    email      VARCHAR(100) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel data barang gudang
CREATE TABLE IF NOT EXISTS barang (
    id_barang   INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(100) NOT NULL,
    kategori    VARCHAR(50)  NOT NULL,
    stok        INT NOT NULL DEFAULT 0,
    harga       DECIMAL(12,2) NOT NULL DEFAULT 0,
    lokasi_rak  VARCHAR(50)  NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contoh data percobaan
INSERT INTO barang (nama_barang, kategori, stok, harga, lokasi_rak) VALUES
('Pita Satin Pink',        'Perintilan',  120, 5000,  'A-1'),
('Jepit Rambut Mutiara',   'Aksesoris',   45,  12000, 'A-2'),
('Kotak Perhiasan Mini',   'Perintilan',  30,  35000, 'B-1'),
('Gantungan Kunci Boneka', 'Aksesoris',   8,   15000, 'B-3'),
('Sticker Aesthetic Pack', 'Alat Tulis',  60,  8000,  'C-1');