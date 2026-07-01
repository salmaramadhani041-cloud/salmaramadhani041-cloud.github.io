<?php

include 'koneksi.php';

mysqli_query($conn, "INSERT INTO barang (nama_barang, kategori, stok, harga, lokasi_rak)
VALUES (
'$_POST[nama_barang]',
'$_POST[kategori]',
'$_POST[stok]',
'$_POST[harga]',
'$_POST[lokasi_rak]'
)");

header("location:index.php");

?>