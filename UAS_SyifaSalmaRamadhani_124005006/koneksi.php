<?php
// koneksi.php — Konfigurasi Koneksi Database Aman dengan PDO
// Sesuai Modul Praktikum PWD Pertemuan 14

$host     = "localhost";
$dbname   = "db_gudang";
$username = "root";
$password = ""; // kosongkan jika memakai XAMPP default bawaan Windows

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Mode error dilempar sebagai exception agar mudah dilacak saat development
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Default fetch mode: associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Catat detail error di log server, jangan bocorkan ke publik
    error_log("Koneksi gagal: " . $e->getMessage());
    http_response_code(500);
    die("Sistem gagal terhubung ke database. Silakan coba beberapa saat lagi.");
}