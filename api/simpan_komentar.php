<?php
include "koneksi.php";
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);

    $diskusi_id = (int)($input["diskusi_id"] ?? 0);
    $user_id    = (int)($input["user_id"] ?? 0);
    $isi        = $koneksi->real_escape_string($input["isi"] ?? "");
    $label      = $koneksi->real_escape_string($input["label"] ?? "netral");

    if ($isi !== "" && $diskusi_id > 0 && $user_id > 0) {
        $sql = "INSERT INTO komentar (diskusi_id, user_id, isi, label_emosi) 
                VALUES ($diskusi_id, $user_id, '$isi', '$label')";
        if ($koneksi->query($sql)) {
            echo json_encode(["status" => "success", "message" => "Komentar disimpan"]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal simpan: " . $koneksi->error
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Data tidak lengkap: diskusi_id, user_id, atau isi kosong."
        ]);
    }
}
