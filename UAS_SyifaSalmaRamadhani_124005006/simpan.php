<?php
require 'auth.php';
require 'koneksi.php';

$stmt = $pdo->prepare("INSERT INTO barang (nama_barang, kategori, stok, harga, lokasi_rak)
                        VALUES (:nama_barang, :kategori, :stok, :harga, :lokasi_rak)");
$stmt->execute([
    ':nama_barang' => $_POST['nama_barang'],
    ':kategori'    => $_POST['kategori'],
    ':stok'        => $_POST['stok'],
    ':harga'       => $_POST['harga'],
    ':lokasi_rak'  => $_POST['lokasi_rak'],
]);

header("Location: index.php");
exit;