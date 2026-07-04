<?php
// login_process.php — API Endpoint Autentikasi Pengguna
header("Content-Type: application/json; charset=UTF-8");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Metode request tidak didukung."]);
    exit;
}

$identifier = isset($_POST['identifier']) ? trim($_POST['identifier']) : '';
$password   = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($identifier) || empty($password)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Username/email dan password wajib diisi."]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, username, email, password FROM users WHERE username = :identifier OR email = :identifier LIMIT 1");
    $stmt->execute([':identifier' => $identifier]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Username/email atau password salah."]);
        exit;
    }

    // Buat sesi login yang aman
    session_regenerate_id(true);
    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email']    = $user['email'];

    http_response_code(200);
    echo json_encode([
        "status"  => "success",
        "message" => "Berhasil masuk, selamat datang " . $user['username'] . "!"
    ]);

} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Kegagalan sistem internal saat memproses login."]);
}