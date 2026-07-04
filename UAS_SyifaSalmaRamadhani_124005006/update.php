<?php
require 'auth.php';
require 'koneksi.php';

$stmt = $pdo->prepare("UPDATE barang SET
    nama_barang = :nama_barang,
    kategori    = :kategori,
    stok        = :stok,
    harga       = :harga,
    lokasi_rak  = :lokasi_rak
    WHERE id_barang = :id_barang");

$stmt->execute([
    ':nama_barang' => $_POST['nama_barang'],
    ':kategori'    => $_POST['kategori'],
    ':stok'        => $_POST['stok'],
    ':harga'       => $_POST['harga'],
    ':lokasi_rak'  => $_POST['lokasi_rak'],
    ':id_barang'   => $_POST['id_barang'],
]);

header("Location: index.php");
exit;