<?php
// auth.php — Penjaga sesi untuk halaman terproteksi.
// Sertakan (include) berkas ini di baris paling atas setiap halaman
// yang hanya boleh diakses oleh user yang sudah login.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}