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
    $skd_laki = mysqli_real_escape_string($conn, $_POST['skd_laki_jumlah']);
    $skd_perempuan = mysqli_real_escape_string($conn, $_POST['skd_peremuan_jumlah']);
    $kaur_laki = mysqli_real_escape_string($conn, $_POST['kaur_laki_jumlah']);
    $kaur_perempuan = mysqli_real_escape_string($conn, $_POST['kaur_perempuan_jumlah']);
    $kkk_laki = mysqli_real_escape_string($conn, $_POST['kkk_laki_jumlah']);
    $kkk_perempuan = mysqli_real_escape_string($conn, $_POST['kkk_perempuan_jumlah']);
    $pk_laki = mysqli_real_escape_string($conn, $_POST['pk_laki_jumlah']);
    $pk_perempuan = mysqli_real_escape_string($conn, $_POST['pk_perempuan_jumlah']);
    $staf_laki = mysqli_real_escape_string($conn, $_POST['staf_laki_jumlah']);
    $staf_perempuan = mysqli_real_escape_string($conn, $_POST['staf_perempuan_jumlah']);
    $total_laki = mysqli_real_escape_string($conn, $_POST['jumlah_laki_jumlah']);
    $total_perempuan = mysqli_real_escape_string($conn, $_POST['jumlah_perempuan_jumlah']);

    // ============================
    // Cek apakah data untuk tahun yang sama sudah ada di database
    // ============================
    $check_query = "SELECT id FROM tb_perangkat_desa WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Jika data sudah ada, lakukan UPDATE
        $sql = "UPDATE tb_perangkat_desa SET 
                skd_laki = '$skd_laki', 
                skd_perempuan = '$skd_perempuan', 
                kaur_laki = '$kaur_laki', 
                kaur_perempuan = '$kaur_perempuan', 
                kkk_laki = '$kkk_laki', 
                kkk_perempuan = '$kkk_perempuan', 
                pk_laki = '$pk_laki', 
                pk_perempuan = '$pk_perempuan', 
                staf_laki = '$staf_laki', 
                staf_perempuan = '$staf_perempuan', 
                total_laki = '$total_laki', 
                total_perempuan = '$total_perempuan' 
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // Jika data belum ada, lakukan INSERT
        $sql = "INSERT INTO tb_perangkat_desa (
                    skd_laki, skd_perempuan, kaur_laki, kaur_perempuan, 
                    kkk_laki, kkk_perempuan, pk_laki, pk_perempuan, 
                    staf_laki, staf_perempuan, total_laki, total_perempuan, 
                    user_id, desa_id, tahun
                ) VALUES (
                    '$skd_laki', '$skd_perempuan', '$kaur_laki', '$kaur_perempuan', 
                    '$kkk_laki', '$kkk_perempuan', '$pk_laki', '$pk_perempuan', 
                    '$staf_laki', '$staf_perempuan', '$total_laki', '$total_perempuan', 
                    '$user_id', '$desa_id', '$tahun'
                )";
    }

    // ============================
    // Eksekusi Query
    // ============================
    if (mysqli_query($conn, $sql)) {
        // ============================
        // Kelola Progress Pengguna
        // ============================
        $form_name = 'Perangkat Desa';
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