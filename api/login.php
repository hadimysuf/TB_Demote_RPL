<?php
session_start();
header("Content-Type: application/json");
require_once("koneksi.php");

$data = json_decode(file_get_contents("php://input"), true);
$email = $data["email"] ?? '';
$password = $data["password"] ?? '';

$stmt = $koneksi->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];

    echo json_encode([
        "status" => "success",
        "message" => "Login berhasil",
        "redirect" => ($user['role'] === 'mahasiswa') ? "../TB_Demote_RPL/dashboard_mhs.php" : "../TB_Demote_RPL/dashboard_dosen.php",
        "user_id" => $user['id'],
        "role" => $user['role'],
        "nama" => $user['nama']
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Email atau password salah"
    ]);
}
