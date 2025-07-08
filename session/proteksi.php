<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit;
}
// Jika ingin membatasi role, gunakan variabel $required_role sebelum include proteksi.php
if (isset($required_role) && $_SESSION['role'] !== $required_role) {
    header('Location: ../login.html');
    exit;
}
?>
