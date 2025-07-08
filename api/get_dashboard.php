<?php


session_start();
require_once("koneksi.php");
header("Content-Type: application/json");

// Pastikan user dosen sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'dosen') {
    echo json_encode([
        "status" => "error",
        "message" => "Akses ditolak. Hanya untuk dosen yang login."
    ]);
    exit;
}
$user_id = $_SESSION['user_id'];

// Ambil room_diskusi yang dibuat oleh dosen (host_id) atau diikuti dosen (anggota_tim)
$sql = "SELECT DISTINCT rd.id, rd.nama_tim, rd.kode_room, rd.host_id, rd.diskusi_id
        FROM room_diskusi rd
        LEFT JOIN tim t ON rd.nama_tim = t.nama_tim
        LEFT JOIN anggota_tim at ON t.id = at.tim_id
        WHERE rd.host_id = ? OR at.user_id = ?
        ORDER BY rd.id DESC";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "id" => $row["id"],
            "nama_tim" => $row["nama_tim"],
            "kode_room" => $row["kode_room"],
            "host_id" => $row["host_id"],
            "diskusi_id" => $row["diskusi_id"]
        ];
    }
    echo json_encode([
        "status" => "success",
        "data" => $data
    ]);
} else {
    echo json_encode([
        "status" => "success",
        "data" => []
    ]);
}
$stmt->close();
$koneksi->close();
