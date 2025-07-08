<?php
// Endpoint: Daftar tim dan anggota tiap tim
require_once("koneksi.php");
header("Content-Type: application/json");

// Ambil semua tim
$sql = "SELECT t.id as tim_id, t.nama_tim, u.id as user_id, u.nama as nama_user, u.role
FROM tim t
LEFT JOIN anggota_tim at ON t.id = at.tim_id
LEFT JOIN users u ON at.user_id = u.id
ORDER BY t.id, u.nama";

$result = $koneksi->query($sql);
$tim = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tid = $row['tim_id'];
        if (!isset($tim[$tid])) {
            $tim[$tid] = [
                'tim_id' => $tid,
                'nama_tim' => $row['nama_tim'],
                'anggota' => []
            ];
        }
        if ($row['user_id']) {
            $tim[$tid]['anggota'][] = [
                'user_id' => $row['user_id'],
                'nama' => $row['nama_user'],
                'role' => $row['role']
            ];
        }
    }
    // Ubah ke array numerik
    $tim = array_values($tim);
    echo json_encode([
        "status" => "success",
        "data" => $tim
    ]);
} else {
    echo json_encode([
        "status" => "success",
        "data" => []
    ]);
}
$koneksi->close();
