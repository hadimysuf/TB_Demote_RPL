<?php
header("Content-Type: application/json");
require_once("koneksi.php");

session_start();

// Cek jika user adalah dosen
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'dosen') {
    echo json_encode(["status" => "error", "message" => "Akses ditolak"]);
    exit;
}

// Ambil semua data refleksi dari form_perasaan + nama user
$query = "
    SELECT fp.*, u.nama 
    FROM form_perasaan fp 
    JOIN users u ON fp.user_id = u.id 
    ORDER BY fp.timestamp DESC
";

$result = $koneksi->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);

$koneksi->close();
