<?php
require 'auth.php';
require 'koneksi.php';

$id = $_GET['id_barang'] ?? '';

$stmt = $pdo->prepare("DELETE FROM barang WHERE id_barang = :id");
$stmt->execute([':id' => $id]);

header("Location: index.php");
exit;