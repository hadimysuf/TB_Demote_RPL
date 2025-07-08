<?php
// Endpoint: Data rekap aktivitas diskusi untuk laporan dosen
// Output: [{nama_tim, kode_room, jumlah_anggota, jumlah_chat}]
require_once("koneksi.php");
header("Content-Type: application/json");


// Filter hanya room yang dosen buat (host_id) atau join (anggota_tim) sesuai session user
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'dosen') {
  echo json_encode([
    "status" => "error",
    "message" => "Akses ditolak. Hanya untuk dosen yang login."
  ]);
  exit;
}
$user_id = $_SESSION['user_id'];
$sql = "SELECT rd.nama_tim, rd.kode_room,
  (SELECT COUNT(*) FROM anggota_tim at2 
    JOIN tim t2 ON at2.tim_id = t2.id WHERE t2.nama_tim = rd.nama_tim) AS jumlah_anggota,
  (SELECT COUNT(*) FROM komentar k 
    JOIN diskusi d ON k.diskusi_id = d.id 
    WHERE d.tim_id = t.id) AS jumlah_chat,
  (SELECT COUNT(*) FROM komentar k 
    JOIN diskusi d ON k.diskusi_id = d.id 
    WHERE d.tim_id = t.id AND k.label_emosi = 'positif') AS chat_positif,
  (SELECT COUNT(*) FROM komentar k 
    JOIN diskusi d ON k.diskusi_id = d.id 
    WHERE d.tim_id = t.id AND k.label_emosi = 'negatif') AS chat_negatif,
  (SELECT COUNT(*) FROM komentar k 
    JOIN diskusi d ON k.diskusi_id = d.id 
    WHERE d.tim_id = t.id AND k.label_emosi = 'netral') AS chat_netral
FROM room_diskusi rd
JOIN tim t ON rd.nama_tim = t.nama_tim
LEFT JOIN anggota_tim at ON t.id = at.tim_id
WHERE rd.host_id = ? OR at.user_id = ?
GROUP BY rd.id
ORDER BY rd.id DESC";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
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
$stmt->close();
$koneksi->close();
