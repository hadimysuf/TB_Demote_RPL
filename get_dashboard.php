<?php
// Pastikan error PHP tidak tampil sebagai HTML
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
ob_start();
// koneksi.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "demote";

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => "Koneksi gagal: " . $koneksi->connect_error]);
    exit;
}

// simpan_komentar.php
if (isset($_GET['action']) && $_GET['action'] === 'komentar') {
    $input = json_decode(file_get_contents("php://input"), true);
    header('Content-Type: application/json');

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
    header('Content-Type: application/json');

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

// get_dashboard.php
if (isset($_GET['action']) && $_GET['action'] === 'dashboard') {
    header('Content-Type: application/json');
    $data = [];

    $komentar = $koneksi->query("SELECT isi AS teks, label_emosi AS label, 'Komentar' AS sumber FROM komentar ORDER BY timestamp DESC LIMIT 10");
    if ($komentar) {
        while ($row = $komentar->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $form = $koneksi->query("SELECT isi_perasaan AS teks, label_emosi AS label, 'Form' AS sumber FROM form_perasaan ORDER BY timestamp DESC LIMIT 10");
    if ($form) {
        while ($row = $form->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
    exit;
}

// Jika ada output lain, buang dan pastikan hanya JSON yang keluar
ob_end_clean();
