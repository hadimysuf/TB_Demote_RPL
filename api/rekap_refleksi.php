<?php
// Endpoint: Data rekap refleksi emosi mahasiswa untuk laporan dosen
// Output: [{timestamp, nama, isi_perasaan, label_emosi}]
require_once("koneksi.php");
header("Content-Type: application/json");
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'dosen') {
    echo json_encode([
        "status" => "error",
        "message" => "Akses ditolak. Hanya untuk dosen yang login."
    ]);
    exit;
}
$user_id = $_SESSION['user_id'];
// Ambil diskusi_id dari room yang dosen buat/join
$sqlRoom = "SELECT DISTINCT rd.diskusi_id
        FROM room_diskusi rd
        LEFT JOIN tim t ON rd.nama_tim = t.nama_tim
        LEFT JOIN anggota_tim at ON t.id = at.tim_id
        WHERE rd.host_id = ? OR at.user_id = ?";
$stmt = $koneksi->prepare($sqlRoom);
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$resultRoom = $stmt->get_result();
$diskusiIds = [];
while ($row = $resultRoom->fetch_assoc()) {
    $diskusiIds[] = $row['diskusi_id'];
}
$stmt->close();
if (count($diskusiIds) === 0) {
    echo json_encode([
        "status" => "success",
        "data" => []
    ]);
    $koneksi->close();
    exit;
}
// Query refleksi (form_perasaan) hanya untuk diskusi_id yang relevan
$in = implode(',', array_fill(0, count($diskusiIds), '?'));
$types = str_repeat('i', count($diskusiIds));
$sql = "SELECT fp.timestamp, u.nama, fp.isi_perasaan, fp.label_emosi
        FROM form_perasaan fp
        JOIN users u ON fp.user_id = u.id
        WHERE fp.diskusi_id IN ($in)
        ORDER BY fp.timestamp DESC";
$stmt2 = $koneksi->prepare($sql);
$stmt2->bind_param($types, ...$diskusiIds);
$stmt2->execute();
$result = $stmt2->get_result();
$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
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
$stmt2->close();
$koneksi->close();
