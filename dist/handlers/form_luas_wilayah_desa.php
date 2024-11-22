<?php
include '../config/conn.php';
session_start();

// Ambil ID pengguna yang sedang login
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Ambil ID desa yang terkait dengan user yang sedang login
$query_desa = "SELECT id_desa FROM tb_desa WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1"; 
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $luas_wilayah_desa = mysqli_real_escape_string($conn, $_POST['luas_wilayah_desa']);

    if (!empty($luas_wilayah_desa)) {
        // Perbarui query untuk memasukkan user_id dan desa_id
        $sql = "INSERT INTO tb_luas_wilayah_desa (luas_wilayah_desa, user_id, desa_id) 
                VALUES ('$luas_wilayah_desa', '$user_id', '$desa_id')";

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
?>
