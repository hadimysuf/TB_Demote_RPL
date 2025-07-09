<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

require_once "api/koneksi.php";

$user_id = $_SESSION['user_id'];


// Hitung jumlah diskusi aktif (room yang diikuti/dibuat user)
$sqlDiskusi = "SELECT COUNT(DISTINCT rd.id) AS total
    FROM room_diskusi rd
    LEFT JOIN tim t ON rd.nama_tim = t.nama_tim
    LEFT JOIN anggota_tim at ON t.id = at.tim_id
    WHERE rd.host_id = ? OR at.user_id = ?";
$stmt1 = $koneksi->prepare($sqlDiskusi);
$stmt1->bind_param("ii", $user_id, $user_id);
$stmt1->execute();
$result1 = $stmt1->get_result();
$diskusi_aktif = 0;
if ($row1 = $result1->fetch_assoc()) {
    $diskusi_aktif = (int)$row1['total'];
}
$stmt1->close();

// Hitung jumlah refleksi terkirim (form_perasaan)
$sqlRefleksi = "SELECT COUNT(*) AS total FROM form_perasaan WHERE user_id = ?";
$stmt2 = $koneksi->prepare($sqlRefleksi);
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$result2 = $stmt2->get_result();
$refleksi_terkirim = 0;
if ($row2 = $result2->fetch_assoc()) {
    $refleksi_terkirim = (int)$row2['total'];
}
$stmt2->close();

echo json_encode([
    "diskusi_aktif" => $diskusi_aktif,
    "refleksi_terkirim" => $refleksi_terkirim
]);
