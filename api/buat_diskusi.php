<?php
include "koneksi.php";
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$judul = $koneksi->real_escape_string($data["judul"] ?? "Diskusi Baru");

$sql = "INSERT INTO diskusi (judul) VALUES ('$judul')";
if ($koneksi->query($sql)) {
    echo json_encode([
        "status" => "success",
        "diskusi_id" => $koneksi->insert_id
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Gagal membuat diskusi: " . $koneksi->error
    ]);
}
