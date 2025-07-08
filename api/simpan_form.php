<?php
// Aktifkan error reporting (debugging saat develop)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Header JSON
header("Content-Type: application/json");

// Koneksi ke database
require_once("koneksi.php");

// Ambil dan decode JSON dari body request
$data = json_decode(file_get_contents("php://input"), true);

// Ambil dan sanitasi data
$diskusi_id = isset($data['diskusi_id']) ? intval($data['diskusi_id']) : 0;
$user_id = isset($data['user_id']) ? intval($data['user_id']) : 0;
$isi = isset($data['isi']) ? trim($data['isi']) : '';
$label_emosi = isset($data['label_emosi']) ? trim($data['label_emosi']) : '';

// Validasi input
if ($diskusi_id <= 0 || $user_id <= 0 || $isi === '' || $label_emosi === '') {
    echo json_encode([
        "status" => "error",
        "message" => "Data tidak lengkap atau tidak valid."
    ]);
    exit;
}

// Query simpan ke tabel form_perasaan
$stmt = $koneksi->prepare("INSERT INTO form_perasaan (diskusi_id, user_id, isi_perasaan, label_emosi) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $diskusi_id, $user_id, $isi, $label_emosi);

// Eksekusi dan respons
if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Refleksi berhasil disimpan."
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Gagal menyimpan refleksi ke database."
    ]);
}

$stmt->close();
$koneksi->close();
