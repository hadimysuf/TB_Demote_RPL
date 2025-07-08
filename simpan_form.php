<?php
// koneksi.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "demote";

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// simpan_komentar.php
if (isset($_GET['action']) && $_GET['action'] === 'komentar') {
    $input = json_decode(file_get_contents("php://input"), true);

    $diskusi_id = isset($input['diskusi_id']) ? (int)$input['diskusi_id'] : 1;
    $user_id    = isset($input['user_id']) ? (int)$input['user_id'] : 1;
    $isi        = $koneksi->real_escape_string($input['isi']);
    $label      = $koneksi->real_escape_string($input['label']);

    $sql = "INSERT INTO komentar (diskusi_id, user_id, isi, label_emosi) VALUES ($diskusi_id, $user_id, '$isi', '$label')";

    if ($koneksi->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Komentar berhasil disimpan."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menyimpan komentar: " . $koneksi->error]);
    }
    exit;
}

// simpan_form.php
if (isset($_GET['action']) && $_GET['action'] === 'form') {
    $input = json_decode(file_get_contents("php://input"), true);

    $diskusi_id   = isset($input['diskusi_id']) ? (int)$input['diskusi_id'] : 1;
    $user_id      = isset($input['user_id']) ? (int)$input['user_id'] : 1;
    $isi_perasaan = $koneksi->real_escape_string($input['isi']);
    $label        = $koneksi->real_escape_string($input['label']);

    $sql = "INSERT INTO form_perasaan (diskusi_id, user_id, isi_perasaan, label_emosi) VALUES ($diskusi_id, $user_id, '$isi_perasaan', '$label')";

    if ($koneksi->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Form perasaan berhasil disimpan."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menyimpan form: " . $koneksi->error]);
    }
    exit;
}
