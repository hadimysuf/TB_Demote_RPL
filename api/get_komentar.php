<?php
require_once("koneksi.php");
header("Content-Type: application/json");

$diskusi_id = $_GET['diskusi_id'] ?? null;

if (!$diskusi_id) {
    echo json_encode([
        "status" => "error",
        "message" => "Parameter diskusi_id tidak ditemukan"
    ]);
    exit;
}

$sql = "
    SELECT 
        k.id, 
        k.user_id, 
        u.nama AS nama_user,
        k.isi, 
        k.label_emosi, 
        k.timestamp 
    FROM komentar k
    JOIN users u ON k.user_id = u.id
    WHERE k.diskusi_id = ?
    ORDER BY k.timestamp ASC
";

$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $diskusi_id);
$stmt->execute();
$result = $stmt->get_result();

$komentar = [];
while ($row = $result->fetch_assoc()) {
    $komentar[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $komentar
]);
