<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

require_once "koneksi.php";

$user_id = $_SESSION['user_id'];

$sql = "
  SELECT teks, label
  FROM komentar
  WHERE user_id = ?
  ORDER BY id DESC
  LIMIT 10
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
