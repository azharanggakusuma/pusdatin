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
    // Process dynamic form data
    $data = [];
    foreach ($_POST as $key => $value) {
        if (preg_match('/^jenis_tempat_peribadatan_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['jenis_tempat_peribadatan'] = mysqli_real_escape_string($conn, $value);
        } elseif (preg_match('/^nama_tempat_peribadatan_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['nama_tempat_peribadatan'] = mysqli_real_escape_string($conn, $value);
        } elseif (preg_match('/^titik_koordinat_lintang_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['titik_koordinat_lintang'] = mysqli_real_escape_string($conn, $value);
        } elseif (preg_match('/^titik_koordinat_bujur_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['titik_koordinat_bujur'] = mysqli_real_escape_string($conn, $value);
        }
    }

    // Insert or update data into the database
    foreach ($data as $entry) {
        $jenis_tempat_peribadatan = $entry['jenis_tempat_peribadatan'] ?? '';
        $nama_tempat_peribadatan = $entry['nama_tempat_peribadatan'] ?? '';
        $titik_koordinat_lintang = $entry['titik_koordinat_lintang'] ?? '';
        $titik_koordinat_bujur = $entry['titik_koordinat_bujur'] ?? '';

        if ($jenis_tempat_peribadatan && $nama_tempat_peribadatan && $titik_koordinat_lintang && $titik_koordinat_bujur) {
            // Check if the record already exists
            $check_query = "SELECT id FROM tb_tempat_peribadatan WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun' AND jenis_tempat_peribadatan = '$jenis_tempat_peribadatan' AND nama_tempat_peribadatan = '$nama_tempat_peribadatan'";
            $check_result = mysqli_query($conn, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                // If record exists, update it
                $update_sql = "UPDATE tb_tempat_peribadatan 
                               SET titik_koordinat_lintang = '$titik_koordinat_lintang', 
                                   titik_koordinat_bujur = '$titik_koordinat_bujur', 
                                   tahun = '$tahun' 
                               WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun' 
                               AND jenis_tempat_peribadatan = '$jenis_tempat_peribadatan' 
                               AND nama_tempat_peribadatan = '$nama_tempat_peribadatan'";
                if (!mysqli_query($conn, $update_sql)) {
                    header("Location: ../pages/forms/data_lokasi_geospasial.php?status=error&message=" . urlencode(mysqli_error($conn)));
                    exit();
                }
            } else {
                // If record doesn't exist, insert a new record
                $insert_sql = "INSERT INTO tb_tempat_peribadatan 
                               (jenis_tempat_peribadatan, nama_tempat_peribadatan, titik_koordinat_lintang, titik_koordinat_bujur, user_id, desa_id, tahun)
                               VALUES ('$jenis_tempat_peribadatan', '$nama_tempat_peribadatan', '$titik_koordinat_lintang', '$titik_koordinat_bujur', '$user_id', '$desa_id', '$tahun')";
                if (!mysqli_query($conn, $insert_sql)) {
                    header("Location: ../pages/forms/data_lokasi_geospasial.php?status=error&message=" . urlencode(mysqli_error($conn)));
                    exit();
                }
            }
        }
    }

    // Check if progress entry exists for the same year
    $query_progress = "SELECT id FROM user_progress WHERE user_id = '$user_id' AND form_name = 'Tempat Peribadatan' AND tahun = '$tahun'";
    $result_progress = mysqli_query($conn, $query_progress);

    // Set created_at to the first day of the year at 00:00:00
    $created_at = $tahun . '-01-01 00:00:00';

    if (mysqli_num_rows($result_progress) > 0) {
        // If progress entry exists for the same year, update it
        $update_progress = "UPDATE user_progress 
                            SET is_locked = TRUE, desa_id = '$desa_id', created_at = '$created_at', tahun = '$tahun' 
                            WHERE user_id = '$user_id' AND form_name = 'Tempat Peribadatan' AND tahun = '$tahun'";
        mysqli_query($conn, $update_progress);
    } else {
        // If progress entry doesn't exist for the same year, insert a new entry
        $insert_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id, created_at, tahun) 
                            VALUES ('$user_id', 'Tempat Peribadatan', TRUE, '$desa_id', '$created_at', '$tahun')";
        mysqli_query($conn, $insert_progress);
    }

    header("Location: ../pages/forms/data_lokasi_geospasial.php?status=success");
    exit();
} else {
    header("Location: ../pages/forms/data_lokasi_geospasial.php?status=warning");
    exit();
}
?>