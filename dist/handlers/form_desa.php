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
    $kode_desa = mysqli_real_escape_string($conn, $_POST['kode_desa']);
    $nama_desa = mysqli_real_escape_string($conn, $_POST['nama_desa']);

    if (!empty($kode_desa) && !empty($nama_desa)) {
        // Tambahkan data desa beserta user_id
        $sql = "INSERT INTO tb_desa (kode_desa, nama_desa, user_id) VALUES ('$kode_desa', '$nama_desa', '$user_id')";

        if (mysqli_query($conn, $sql)) {
            // Tambahkan atau perbarui progres pengguna
            $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked) 
                                VALUES ('$user_id', 'Desa', TRUE)
                                ON DUPLICATE KEY UPDATE is_locked = TRUE";
            mysqli_query($conn, $query_progress);

            header("Location: ../pages/forms/desa.php?status=success");
            exit();
        } else {
            header("Location: ../pages/forms/desa.php?status=error&message=" . urlencode(mysqli_error($conn)));
            exit();
        }
    } else {
        header("Location: ../pages/forms/desa.php?status=warning");
        exit();
    }
}
