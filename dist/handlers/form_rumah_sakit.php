<?php
session_start();
include "../config/conn.php";

$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

$tahun = $_SESSION['tahun'] ?? null;
$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [];
    foreach ($_POST as $key => $value) {
        if (preg_match('/^nama_rumah_sakit_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['nama_rumah_sakit'] = mysqli_real_escape_string($conn, $value);
        } elseif (preg_match('/^alamat_rumah_sakit_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['alamat_rumah_sakit'] = mysqli_real_escape_string($conn, $value);
        } elseif (preg_match('/^nama_kecamatan_rumah_sakit_(\d+)$/', $key, $matches)) {
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

    foreach ($data as $rumahSakit) {
        $sql = "INSERT INTO tb_rumah_sakit (nama_rumah_sakit, alamat_rumah_sakit, nama_kecamatan, koordinat_lintang, koordinat_bujur, tahun, user_id, desa_id)
                VALUES (
                    '{$rumahSakit['nama_rumah_sakit']}',
                    '{$rumahSakit['alamat_rumah_sakit']}',
                    '{$rumahSakit['nama_kecamatan']}',
                    '{$rumahSakit['koordinat_lintang']}',
                    '{$rumahSakit['koordinat_bujur']}',
                    '$tahun',
                    '$user_id',
                    '$desa_id'
                )";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }

    header("Location: ../pages/forms/data_lokasi_geospasial.php?status=success");
    exit();
}
?>
