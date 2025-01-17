<?php
session_start();
include "../config/conn.php";

$username = $_SESSION['username'] ?? '';
$tahun = $_SESSION['tahun'] ?? null;

if (!$tahun || !$username) {
    die("Tahun atau pengguna tidak ditemukan. Pastikan Anda telah login.");
}

// Ambil ID pengguna
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

if (!$user_id) {
    die("User ID tidak ditemukan.");
}

// Ambil ID desa
$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if (!$desa_id) {
    die("desa_id tidak ditemukan. Pastikan data enumerator valid.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tps = mysqli_real_escape_string($conn, $_POST['tps']);
    $tps3r = mysqli_real_escape_string($conn, $_POST['tps3r']);
    $bank_sampah = mysqli_real_escape_string($conn, $_POST['bank_sampah']);

    // Validasi jika data sudah ada
    $check_query = "SELECT id FROM tb_pengelolaan_sampah WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $sql = "UPDATE tb_pengelolaan_sampah SET 
                tps = '$tps', 
                tps3r = '$tps3r', 
                bank_sampah = '$bank_sampah' 
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        $sql = "INSERT INTO tb_pengelolaan_sampah (tps, tps3r, bank_sampah, tahun, user_id, desa_id)
                VALUES ('$tps', '$tps3r', '$bank_sampah', '$tahun', '$user_id', '$desa_id')";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: ../pages/forms/perumahan_dan_lingkungan_hidup.php?status=success");
        exit();
    } else {
        header("Location: ../pages/forms/perumahan_dan_lingkungan_hidup.php?status=error&message=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: ../pages/forms/perumahan_dan_lingkungan_hidup.php?status=warning");
    exit();
}
?>
