<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && isset($_SESSION['nama'])) {
    echo json_encode([
        'status' => 'active',
        'user_id' => $_SESSION['user_id'],
        'role' => $_SESSION['role'],
        'nama' => $_SESSION['nama']
    ]);
} else {
    echo json_encode([
        'status' => 'inactive'
    ]);
}
