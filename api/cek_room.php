<?php
// Tampilkan semua error PHP (untuk debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
header("Content-Type: application/json");
// Pastikan file koneksi tersedia
require_once("koneksi.php");

// Ambil data JSON dari fetch
$data = json_decode(file_get_contents("php://input"), true);
$kode_room = trim($data['kode_room'] ?? '');

// Validasi input kosong
if (empty($kode_room)) {
    echo json_encode([
        "status" => "error",
        "message" => "Kode room tidak boleh kosong."
    ]);
    exit;
}

// Query untuk cek kode_room
$stmt = $koneksi->prepare("SELECT id, kode_room, nama_tim, host_id, diskusi_id FROM room_diskusi WHERE kode_room = ?");
$stmt->bind_param("s", $kode_room);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $room = $result->fetch_assoc();

    // Simpan ke session (opsional jika tidak pakai sessionStorage)
    $_SESSION['room_id'] = $room['id'];
    $_SESSION['room_kode'] = $room['kode_room'];
    $_SESSION['room_nama'] = $room['nama_tim'];
    $_SESSION['diskusi_id'] = $room['diskusi_id'];

    // Tambahkan user ke anggota_tim jika belum ada
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        // Cari tim_id dari nama_tim (pastikan nama_tim unik di tabel tim)
        $stmtTim = $koneksi->prepare("SELECT id FROM tim WHERE nama_tim = ? LIMIT 1");
        $stmtTim->bind_param("s", $room['nama_tim']);
        $stmtTim->execute();
        $resultTim = $stmtTim->get_result();
        if ($resultTim && $rowTim = $resultTim->fetch_assoc()) {
            $tim_id = $rowTim['id'];
            // Cek apakah user sudah jadi anggota
            $stmtCek = $koneksi->prepare("SELECT id FROM anggota_tim WHERE user_id = ? AND tim_id = ?");
            $stmtCek->bind_param("ii", $user_id, $tim_id);
            $stmtCek->execute();
            $resultCek = $stmtCek->get_result();
            if ($resultCek->num_rows == 0) {
                // Tambahkan user ke anggota_tim
                $stmtAdd = $koneksi->prepare("INSERT INTO anggota_tim (user_id, tim_id) VALUES (?, ?)");
                $stmtAdd->bind_param("ii", $user_id, $tim_id);
                $stmtAdd->execute();
                $stmtAdd->close();
            }
            $stmtCek->close();
        }
        $stmtTim->close();
    }

    echo json_encode([
        "status" => "success",
        "message" => "Berhasil masuk ke room.",
        "data" => [
            "id" => $room['id'],
            "nama_tim" => $room['nama_tim'],
            "kode_room" => $room['kode_room'],
            "host_id" => $room['host_id'],
            "diskusi_id" => $room['diskusi_id']
        ]
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Kode room tidak ditemukan."
    ]);
}

$stmt->close();
$koneksi->close();
