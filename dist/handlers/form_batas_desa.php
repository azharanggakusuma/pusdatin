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
    $batas_utara = mysqli_real_escape_string($conn, $_POST['batas_utara'] ?? '');
    $kec_utara = mysqli_real_escape_string($conn, $_POST['kec_utara'] ?? '');
    $batas_selatan = mysqli_real_escape_string($conn, $_POST['batas_selatan'] ?? '');
    $kec_selatan = mysqli_real_escape_string($conn, $_POST['kec_selatan'] ?? '');
    $batas_timur = mysqli_real_escape_string($conn, $_POST['batas_timur'] ?? '');
    $kec_timur = mysqli_real_escape_string($conn, $_POST['kec_timur'] ?? '');
    $batas_barat = mysqli_real_escape_string($conn, $_POST['batas_barat'] ?? '');
    $kec_barat = mysqli_real_escape_string($conn, $_POST['kec_barat'] ?? '');

    // Check if the record already exists for the same year
    $check_query = "SELECT id 
                    FROM tb_batas_desa 
                    WHERE user_id = '$user_id' 
                      AND desa_id = '$desa_id' 
                      AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // If record exists for the same year, update the existing record
        $sql = "UPDATE tb_batas_desa
                SET batas_utara = '$batas_utara',
                    kec_utara = '$kec_utara',
                    batas_selatan = '$batas_selatan',
                    kec_selatan = '$kec_selatan',
                    batas_timur = '$batas_timur',
                    kec_timur = '$kec_timur',
                    batas_barat = '$batas_barat',
                    kec_barat = '$kec_barat',
                    tahun = '$tahun'
                WHERE user_id = '$user_id'
                  AND desa_id = '$desa_id'
                  AND tahun = '$tahun'";
    } else {
        // If record doesn't exist for the same year, insert a new record
        $sql = "INSERT INTO tb_batas_desa (
                    batas_utara, kec_utara, 
                    batas_selatan, kec_selatan, 
                    batas_timur, kec_timur, 
                    batas_barat, kec_barat, 
                    tahun, user_id, desa_id
                ) VALUES (
                    '$batas_utara', '$kec_utara',
                    '$batas_selatan', '$kec_selatan',
                    '$batas_timur', '$kec_timur',
                    '$batas_barat', '$kec_barat',
                    '$tahun', '$user_id', '$desa_id'
                )";
    }

    if (mysqli_query($conn, $sql)) {
        // Cek atau update progress user
        $query_progress = "SELECT id 
                           FROM user_progress 
                           WHERE user_id = '$user_id' 
                             AND form_name = 'Batas Desa'
                             AND tahun = '$tahun'";
        $result_progress = mysqli_query($conn, $query_progress);

        // Set created_at ke tanggal 1 Januari tahun terpilih
        $created_at = $tahun . '-01-01 00:00:00';

        if (mysqli_num_rows($result_progress) > 0) {
            // Update progress jika sudah ada
            $update_progress = "UPDATE user_progress
                                SET is_locked = TRUE,
                                    desa_id = '$desa_id',
                                    created_at = '$created_at',
                                    tahun = '$tahun'
                                WHERE user_id = '$user_id'
                                  AND form_name = 'Batas Desa'
                                  AND tahun = '$tahun'";
            mysqli_query($conn, $update_progress);
        } else {
            // Insert progress jika belum ada
            $insert_progress = "INSERT INTO user_progress (
                                    user_id, form_name, is_locked, 
                                    desa_id, created_at, tahun
                                ) VALUES (
                                    '$user_id', 'Batas Desa', TRUE, 
                                    '$desa_id', '$created_at', '$tahun'
                                )";
            mysqli_query($conn, $insert_progress);
        }

        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=success");
        exit();
    } else {
        // Jika ada error query
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    // Jika bukan method POST
    header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=warning");
    exit();
}
?>
