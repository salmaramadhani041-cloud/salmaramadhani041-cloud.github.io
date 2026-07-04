<?php
// register_process.php — API Endpoint Registrasi Pengguna
header("Content-Type: application/json; charset=UTF-8");
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Metode request tidak didukung."]);
    exit;
}

$username        = isset($_POST['username']) ? trim($_POST['username']) : '';
$email           = isset($_POST['email']) ? trim($_POST['email']) : '';
$password        = isset($_POST['password']) ? $_POST['password'] : '';
$confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

// 1. Validasi wajib isi
if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Semua form wajib diisi."]);
    exit;
}

// 2. Validasi format email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Format penulisan email tidak valid."]);
    exit;
}

// 3. Validasi kecocokan konfirmasi password
if ($password !== $confirmPassword) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Konfirmasi password tidak cocok."]);
    exit;
}

// 4. Validasi kekuatan password: min 8 karakter, huruf besar, angka, karakter spesial
$strongPassword = strlen($password) >= 8
    && preg_match('/[A-Z]/', $password)
    && preg_match('/[0-9]/', $password)
    && preg_match('/[^A-Za-z0-9]/', $password);

if (!$strongPassword) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Password minimal 8 karakter dan harus mengandung huruf kapital, angka, serta karakter spesial."
    ]);
    exit;
}

try {
    // 5. Verifikasi keunikan username & email
    $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
    $stmtCheck->execute([
        ':username' => $username,
        ':email'    => $email
    ]);

    if ($stmtCheck->fetchColumn() > 0) {
        http_response_code(409);
        echo json_encode(["status" => "error", "message" => "Username atau email sudah terdaftar."]);
        exit;
    }

    // 6. Hash password dengan Bcrypt
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 7. Simpan menggunakan prepared statement
    $stmtInsert = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $stmtInsert->execute([
        ':username' => $username,
        ':email'    => $email,
        ':password' => $hashedPassword
    ]);

    http_response_code(201);
    echo json_encode([
        "status"  => "success",
        "message" => "Akun berhasil dibuat!"
    ]);

} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        "status"  => "error",
        "message" => "Kegagalan sistem internal saat menyimpan data."
    ]);
}