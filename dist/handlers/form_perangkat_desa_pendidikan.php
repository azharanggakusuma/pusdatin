<?php
session_start();
include "../config/conn.php";

// ============================
// Mengambil ID Pengguna dan Tahun dari Session
// ============================
$username = $_SESSION['username'] ?? '';
$tahun = $_SESSION['tahun'] ?? null;

if (!$tahun || !$username) {
    echo "Tahun atau pengguna tidak ditemukan. Pastikan Anda telah login.";
    exit();
}

// ============================
// Mengambil ID Pengguna dan ID Desa
// ============================
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ============================
    // Sanitasi dan Persiapan Data dari POST
    // ============================
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

    // ============================
    // Cek apakah data untuk tahun yang sama sudah ada di database
    // ============================
    $check_query = "SELECT id FROM tb_perangkat_desa_pendidikan WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Jika data sudah ada, lakukan UPDATE
        $sql = "UPDATE tb_perangkat_desa_pendidikan 
                SET 
                    tidak_sekolah_laki = '$tidak_sekolah_laki', 
                    tidak_sekolah_perempuan = '$tidak_sekolah_perempuan', 
                    tidak_tamat_sd_laki = '$tidak_tamat_sd_laki', 
                    tidak_tamat_sd_perempuan = '$tidak_tamat_sd_perempuan', 
                    tamat_sd_laki = '$tamat_sd_laki', 
                    tamat_sd_perempuan = '$tamat_sd_perempuan', 
                    smp_laki = '$smp_laki', 
                    smp_perempuan = '$smp_perempuan', 
                    smu_laki = '$smu_laki', 
                    smu_perempuan = '$smu_perempuan', 
                    d3_laki = '$d3_laki', 
                    d3_perempuan = '$d3_perempuan', 
                    s1_laki = '$s1_laki', 
                    s1_perempuan = '$s1_perempuan', 
                    s2_laki = '$s2_laki', 
                    s2_perempuan = '$s2_perempuan', 
                    s3_laki = '$s3_laki', 
                    s3_perempuan = '$s3_perempuan', 
                    total_laki = '$total_laki', 
                    total_perempuan = '$total_perempuan' 
                WHERE 
                    user_id = '$user_id' AND 
                    desa_id = '$desa_id' AND 
                    tahun = '$tahun'";
    } else {
        // Jika data belum ada, lakukan INSERT
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

    // ============================
    // Eksekusi Query
    // ============================
    if (mysqli_query($conn, $sql)) {
        // ============================
        // Kelola Progress Pengguna
        // ============================
        $form_name = 'Pendidikan Perangkat Desa';
        $query_progress = "SELECT id FROM user_progress WHERE user_id = '$user_id' AND form_name = '$form_name' AND tahun = '$tahun'";
        $result_progress = mysqli_query($conn, $query_progress);

        // Set created_at ke hari pertama tahun tersebut
        $created_at = "$tahun-01-01 00:00:00";

        if (mysqli_num_rows($result_progress) > 0) {
            // Jika progress sudah ada, lakukan UPDATE
            $update_progress = "UPDATE user_progress 
                                SET 
                                    is_locked  = TRUE, 
                                    desa_id    = '$desa_id', 
                                    created_at = '$created_at', 
                                    tahun      = '$tahun' 
                                WHERE 
                                    user_id    = '$user_id' AND 
                                    form_name  = '$form_name' AND 
                                    tahun      = '$tahun'";
            if (!mysqli_query($conn, $update_progress)) {
                header("Location: ../pages/forms/aparatur_pemerintahan_desa.php?status=error&message=" . urlencode(mysqli_error($conn)));
                exit();
            }
        } else {
            // Jika progress belum ada, lakukan INSERT
            $insert_progress = "INSERT INTO user_progress (
                                    user_id, 
                                    form_name, 
                                    is_locked, 
                                    desa_id, 
                                    created_at, 
                                    tahun
                                ) VALUES (
                                    '$user_id',
                                    '$form_name',
                                    TRUE,
                                    '$desa_id',
                                    '$created_at',
                                    '$tahun'
                                )";
            if (!mysqli_query($conn, $insert_progress)) {
                header("Location: ../pages/forms/aparatur_pemerintahan_desa.php?status=error&message=" . urlencode(mysqli_error($conn)));
                exit();
            }
        }

        // Redirect ke halaman form dengan status sukses
        header("Location: ../pages/forms/aparatur_pemerintahan_desa.php?status=success");
        exit();
    } else {
        // Jika eksekusi query gagal, redirect dengan pesan error
        header("Location: ../pages/forms/aparatur_pemerintahan_desa.php?status=error&message=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    // Jika bukan metode POST, redirect dengan status warning
    header("Location: ../pages/forms/aparatur_pemerintahan_desa.php?status=warning");
    exit();
}
?>