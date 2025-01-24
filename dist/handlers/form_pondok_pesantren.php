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
    echo "Tahun tidak ditemukan.";
    exit();
}

// Retrieve village ID associated with the user
$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [];
    foreach ($_POST as $key => $value) {
        if (preg_match('/^nama_pesantren_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['nama_pesantren'] = mysqli_real_escape_string($conn, $value);
        } elseif (preg_match('/^alamat_pesantren_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['alamat_pesantren'] = mysqli_real_escape_string($conn, $value);
        } elseif (preg_match('/^nama_kecamatan_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['nama_kecamatan'] = mysqli_real_escape_string($conn, $value);
        } elseif (preg_match('/^koordinat_lintang_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['koordinat_lintang'] = mysqli_real_escape_string($conn, $value);
        } elseif (preg_match('/^koordinat_bujur_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['koordinat_bujur'] = mysqli_real_escape_string($conn, $value);
        }
    }

    // Insert or update data into the database
    foreach ($data as $pesantren) {
        $nama_pesantren = $pesantren['nama_pesantren'] ?? '';
        $alamat_pesantren = $pesantren['alamat_pesantren'] ?? '';
        $nama_kecamatan = $pesantren['nama_kecamatan'] ?? '';
        $koordinat_lintang = $pesantren['koordinat_lintang'] ?? '';
        $koordinat_bujur = $pesantren['koordinat_bujur'] ?? '';

        if ($nama_pesantren && $alamat_pesantren && $nama_kecamatan && $koordinat_lintang && $koordinat_bujur) {
            // Check if the record already exists
            $check_query = "SELECT id FROM tb_pondok_pesantren WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun' AND nama_pesantren = '$nama_pesantren'";
            $check_result = mysqli_query($conn, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                // If record exists, update it
                $update_sql = "UPDATE tb_pondok_pesantren 
                               SET alamat_pesantren = '$alamat_pesantren', 
                                   nama_kecamatan = '$nama_kecamatan', 
                                   koordinat_lintang = '$koordinat_lintang', 
                                   koordinat_bujur = '$koordinat_bujur', 
                                   tahun = '$tahun' 
                               WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun' 
                               AND nama_pesantren = '$nama_pesantren'";
                if (!mysqli_query($conn, $update_sql)) {
                    header("Location: ../pages/forms/data_lokasi_geospasial.php?status=error&message=" . urlencode(mysqli_error($conn)));
                    exit();
                }
            } else {
                // If record doesn't exist, insert a new record
                $insert_sql = "INSERT INTO tb_pondok_pesantren (nama_pesantren, alamat_pesantren, nama_kecamatan, koordinat_lintang, koordinat_bujur, tahun, user_id, desa_id)
                               VALUES ('$nama_pesantren', '$alamat_pesantren', '$nama_kecamatan', '$koordinat_lintang', '$koordinat_bujur', '$tahun', '$user_id', '$desa_id')";
                if (!mysqli_query($conn, $insert_sql)) {
                    header("Location: ../pages/forms/data_lokasi_geospasial.php?status=error&message=" . urlencode(mysqli_error($conn)));
                    exit();
                }
            }
        }
    }

    // Check if progress entry exists for the same year
    $query_progress = "SELECT id FROM user_progress WHERE user_id = '$user_id' AND form_name = 'Pondok Pesantren' AND tahun = '$tahun'";
    $result_progress = mysqli_query($conn, $query_progress);

    // Set created_at to the first day of the year at 00:00:00
    $created_at = $tahun . '-01-01 00:00:00';

    if (mysqli_num_rows($result_progress) > 0) {
        // If progress entry exists for the same year, update it
        $update_progress = "UPDATE user_progress 
                            SET is_locked = TRUE, desa_id = '$desa_id', created_at = '$created_at', tahun = '$tahun' 
                            WHERE user_id = '$user_id' AND form_name = 'Pondok Pesantren' AND tahun = '$tahun'";
        mysqli_query($conn, $update_progress);
    } else {
        // If progress entry doesn't exist for the same year, insert a new entry
        $insert_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id, created_at, tahun) 
                            VALUES ('$user_id', 'Pondok Pesantren', TRUE, '$desa_id', '$created_at', '$tahun')";
        mysqli_query($conn, $insert_progress);
    }

    header("Location: ../pages/forms/data_lokasi_geospasial.php?status=success");
    exit();
} else {
    header("Location: ../pages/forms/data_lokasi_geospasial.php?status=warning");
    exit();
}
?>