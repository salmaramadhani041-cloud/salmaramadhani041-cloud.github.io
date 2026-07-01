<?php

include 'koneksi.php';

mysqli_query($conn, "UPDATE barang SET
nama_barang='$_POST[nama_barang]',
kategori='$_POST[kategori]',
stok='$_POST[stok]',
harga='$_POST[harga]',
lokasi_rak='$_POST[lokasi_rak]'
WHERE id_barang='$_POST[id_barang]'");

header("location:index.php");

?>