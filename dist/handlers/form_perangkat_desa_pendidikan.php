<?php
session_start();
include "../config/conn.php";

// Retrieve user ID from session
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Retrieve year from session
$tahun = $_SESSION['tahun'] ?? null;

if (!$tahun) {
    echo "Tahun tidak ditemukan. Pastikan Anda telah login dengan memilih tahun.";
    exit();
}

// Retrieve village ID associated with the user
$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and prepare data from POST
    $tidak_sekolah_laki = mysqli_real_escape_string($conn, $_POST['tidaksekolah_laki_jumlah']);
    $tidak_sekolah_perempuan = mysqli_real_escape_string($conn, $_POST['tidaksekolah_peremuan_jumlah']);
    $tidak_tamat_sd_laki = mysqli_real_escape_string($conn, $_POST['tidaksd_laki_jumlah']);
    $tidak_tamat_sd_perempuan = mysqli_real_escape_string($conn, $_POST['tidaksd_perempuan_jumlah']);
    $tamat_sd_laki = mysqli_real_escape_string($conn, $_POST['sd_laki_jumlah']);
    $tamat_sd_perempuan = mysqli_real_escape_string($conn, $_POST['sd_perempuan_jumlah']);
    $smp_laki = mysqli_real_escape_string($conn, $_POST['smp_laki_jumlah']);
    $smp_perempuan = mysqli_real_escape_string($conn, $_POST['smp_perempuan_jumlah']);
    $smu_laki = mysqli_real_escape_string($conn, $_POST['smu_laki_jumlah']);
    $smu_perempuan = mysqli_real_escape_string($conn, $_POST['smu_perempuan_jumlah']);
    $d3_laki = mysqli_real_escape_string($conn, $_POST['d3_laki_jumlah']);
    $d3_perempuan = mysqli_real_escape_string($conn, $_POST['d3_perempuan_jumlah']);
    $s1_laki = mysqli_real_escape_string($conn, $_POST['s1_laki_jumlah']);
    $s1_perempuan = mysqli_real_escape_string($conn, $_POST['s1_perempuan_jumlah']);
    $s2_laki = mysqli_real_escape_string($conn, $_POST['s2_laki_jumlah']);
    $s2_perempuan = mysqli_real_escape_string($conn, $_POST['s2_perempuan_jumlah']);
    $s3_laki = mysqli_real_escape_string($conn, $_POST['s3_laki_jumlah']);
    $s3_perempuan = mysqli_real_escape_string($conn, $_POST['s3_perempuan_jumlah']);
    $total_laki = mysqli_real_escape_string($conn, $_POST['jumlah2_laki_jumlah']);
    $total_perempuan = mysqli_real_escape_string($conn, $_POST['jumlah2_perempuan_jumlah']);

    // Check if the record already exists for the same year
    $check_query = "SELECT id FROM tb_perangkat_desa_pendidikan WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // If record exists for the same year, update the existing record
        $sql = "UPDATE tb_perangkat_desa_pendidikan 
                SET tidak_sekolah_laki = '$tidak_sekolah_laki', tidak_sekolah_perempuan = '$tidak_sekolah_perempuan', 
                    tidak_tamat_sd_laki = '$tidak_tamat_sd_laki', tidak_tamat_sd_perempuan = '$tidak_tamat_sd_perempuan', 
                    tamat_sd_laki = '$tamat_sd_laki', tamat_sd_perempuan = '$tamat_sd_perempuan', 
                    smp_laki = '$smp_laki', smp_perempuan = '$smp_perempuan', 
                    smu_laki = '$smu_laki', smu_perempuan = '$smu_perempuan', 
                    d3_laki = '$d3_laki', d3_perempuan = '$d3_perempuan', 
                    s1_laki = '$s1_laki', s1_perempuan = '$s1_perempuan', 
                    s2_laki = '$s2_laki', s2_perempuan = '$s2_perempuan', 
                    s3_laki = '$s3_laki', s3_perempuan = '$s3_perempuan', 
                    total_laki = '$total_laki', total_perempuan = '$total_perempuan', 
                    tahun = '$tahun' 
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // If record doesn't exist for the same year, insert a new record
        $sql = "INSERT INTO tb_perangkat_desa_pendidikan 
                (tidak_sekolah_laki, tidak_sekolah_perempuan, tidak_tamat_sd_laki, tidak_tamat_sd_perempuan, 
                 tamat_sd_laki, tamat_sd_perempuan, smp_laki, smp_perempuan, 
                 smu_laki, smu_perempuan, d3_laki, d3_perempuan, 
                 s1_laki, s1_perempuan, s2_laki, s2_perempuan, 
                 s3_laki, s3_perempuan, total_laki, total_perempuan, user_id, desa_id, tahun)
                VALUES ('$tidak_sekolah_laki', '$tidak_sekolah_perempuan', '$tidak_tamat_sd_laki', '$tidak_tamat_sd_perempuan', 
                        '$tamat_sd_laki', '$tamat_sd_perempuan', '$smp_laki', '$smp_perempuan', 
                        '$smu_laki', '$smu_perempuan', '$d3_laki', '$d3_perempuan', 
                        '$s1_laki', '$s1_perempuan', '$s2_laki', '$s2_perempuan', 
                        '$s3_laki', '$s3_perempuan', '$total_laki', '$total_perempuan', 
                        '$user_id', '$desa_id', '$tahun')";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: ../pages/forms/aparatur_pemerintahan_desa.php?status=success");
        exit();
    } else {
        header("Location: ../pages/forms/aparatur_pemerintahan_desa.php?status=error&message=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: ../pages/forms/aparatur_pemerintahan_desa.php?status=warning");
    exit();
}
?>
