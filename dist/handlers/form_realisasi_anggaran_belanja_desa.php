<?php
session_start();
include "../config/conn.php";

// Retrieve user ID and year from session
$username = $_SESSION['username'] ?? '';
$tahun = $_SESSION['tahun'] ?? null;

if (!$tahun || !$username) {
    echo "Tahun atau pengguna tidak ditemukan. Pastikan Anda telah login.";
    exit();
}

// Fetch user_id and desa_id
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and prepare data
    $bidang_penyelenggaraan = mysqli_real_escape_string($conn, $_POST['bidang_penyelenggaraan_pemerintahan_desa']);
    $bidang_pelaksanaan = mysqli_real_escape_string($conn, $_POST['bidang_pelaksanaan_pembangunan_desa']);
    $bidang_pembinaan = mysqli_real_escape_string($conn, $_POST['bidang_pembinaan_kemasyarakatan']);
    $bidang_pemberdayaan = mysqli_real_escape_string($conn, $_POST['bidang_pemberdayaan_masyarakat']);
    $bidang_tak_terduga = mysqli_real_escape_string($conn, $_POST['bidang_tak_terduga']);

    // Check if a record exists for the same year
    $check_query = "SELECT id FROM tb_realisasi_anggaran_belanja_desa WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $sql = "UPDATE tb_realisasi_anggaran_belanja_desa SET 
            bidang_penyelenggaraan_pemerintahan_desa = '$bidang_penyelenggaraan',
            bidang_pelaksanaan_pembangunan_desa = '$bidang_pelaksanaan',
            bidang_pembinaan_kemasyarakatan = '$bidang_pembinaan',
            bidang_pemberdayaan_masyarakat = '$bidang_pemberdayaan',
            bidang_tak_terduga = '$bidang_tak_terduga'
            WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        $sql = "INSERT INTO tb_realisasi_anggaran_belanja_desa (
            bidang_penyelenggaraan_pemerintahan_desa, bidang_pelaksanaan_pembangunan_desa, bidang_pembinaan_kemasyarakatan, 
            bidang_pemberdayaan_masyarakat, bidang_tak_terduga, tahun, user_id, desa_id
        ) VALUES (
            '$bidang_penyelenggaraan', '$bidang_pelaksanaan', '$bidang_pembinaan', 
            '$bidang_pemberdayaan', '$bidang_tak_terduga', '$tahun', '$user_id', '$desa_id'
        )";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: ../pages/forms/keuangan_dan_aset_desa.php?status=success");
        exit();
    } else {
        header("Location: ../pages/forms/keuangan_dan_aset_desa.php?status=error&message=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: ../pages/forms/keuangan_dan_aset_desa.php?status=warning");
    exit();
}
?>
