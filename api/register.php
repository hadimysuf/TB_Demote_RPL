<?php
// register.php
session_start();
require_once("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $nama     = $data['nama'] ?? '';
    $email    = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $role     = $data['role'] ?? '';

    if (!$nama || !$email || !$password || !$role) {
        echo json_encode(["status" => "error", "message" => "Semua field harus diisi."]);
        exit;
    }

    // Cek apakah email sudah digunakan
    $stmt = $koneksi->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email sudah terdaftar."]);
        exit;
    }

    $stmt->close();

    // Simpan user baru
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $koneksi->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Registrasi berhasil. Silakan login."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal registrasi."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Metode tidak valid."]);
}
