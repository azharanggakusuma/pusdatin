<?php
include '../config/conn.php';
session_start();
 
// Ambil ID pengguna yang sedang login
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $luas_wilayah_desa = mysqli_real_escape_string($conn, $_POST['luas_wilayah_desa']);

    if (!empty($luas_wilayah_desa)) {
        $sql = "INSERT INTO tb_luas_wilayah_desa (luas_wilayah_desa) VALUES ('$luas_wilayah_desa')";

        if (mysqli_query($conn, $sql)) {
            // Tambahkan atau perbarui progres pengguna
            $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked) 
                                VALUES ('$user_id', 'Luas Wilayah Desa', TRUE)
                                ON DUPLICATE KEY UPDATE is_locked = TRUE";
            mysqli_query($conn, $query_progress);

            header("Location: ../pages/forms/keadaan_geografi.php?status=success");
            exit();
        } else {
            header("Location: ../pages/forms/keadaan_geografi.php?status=error&message=" . urlencode(mysqli_error($conn)));
            exit();
        }
    } else {
        header("Location: ../pages/forms/keadaan_geografi.php?status=warning");
        exit();
    }
}
