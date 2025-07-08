<?php
session_start();
header("Content-Type: application/json");
require_once("koneksi.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Anda harus login terlebih dahulu."]);
    exit;
}


$data = json_decode(file_get_contents("php://input"), true);
$nama_tim = trim($data['nama_tim'] ?? '');

if (empty($nama_tim)) {
    echo json_encode(["status" => "error", "message" => "Nama tim tidak boleh kosong."]);
    exit;
}

// 1. Tambahkan ke tabel tim
$stmtTim = $koneksi->prepare("INSERT INTO tim (nama_tim) VALUES (?)");
$stmtTim->bind_param("s", $nama_tim);
if (!$stmtTim->execute()) {
    echo json_encode(["status" => "error", "message" => "Gagal membuat tim: " . $stmtTim->error]);
    exit;
}
$tim_id = $stmtTim->insert_id;
$stmtTim->close();

// Generate kode unik room
function generateKode($length = 6)
{
    $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    return substr(str_shuffle(str_repeat($characters, $length)), 0, $length);
}

$kode_room = generateKode();
$host_id = $_SESSION['user_id'];

// Cek kode unik
$stmt = $koneksi->prepare("SELECT id FROM room_diskusi WHERE kode_room = ?");
$stmt->bind_param("s", $kode_room);
$stmt->execute();
while ($stmt->get_result()->num_rows > 0) {
    $kode_room = generateKode();
    $stmt->bind_param("s", $kode_room);
    $stmt->execute();
}
$stmt->close();


// 2. Tambahkan ke tabel diskusi, sertakan tim_id
$judul_diskusi = "Diskusi dari $nama_tim";
$stmtDiskusi = $koneksi->prepare("INSERT INTO diskusi (judul, pembuat_id, tim_id) VALUES (?, ?, ?)");
$stmtDiskusi->bind_param("sii", $judul_diskusi, $host_id, $tim_id);

if (!$stmtDiskusi->execute()) {
    echo json_encode(["status" => "error", "message" => "Gagal membuat diskusi: " . $stmtDiskusi->error]);
    exit;
}
$diskusi_id = $stmtDiskusi->insert_id;
$stmtDiskusi->close();

// 2. Tambahkan ke room_diskusi
$stmtRoom = $koneksi->prepare("INSERT INTO room_diskusi (nama_tim, kode_room, host_id, diskusi_id) VALUES (?, ?, ?, ?)");
$stmtRoom->bind_param("ssii", $nama_tim, $kode_room, $host_id, $diskusi_id);

if ($stmtRoom->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Room berhasil dibuat.",
        "kode_room" => $kode_room,
        "room_id" => $stmtRoom->insert_id,
        "diskusi_id" => $diskusi_id,
        "nama_tim" => $nama_tim
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal menyimpan room: " . $stmtRoom->error]);
}

$stmtRoom->close();
$koneksi->close();
