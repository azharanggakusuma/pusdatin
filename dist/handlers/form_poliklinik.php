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
        if (preg_match('/^nama_poliklinik_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['nama_poliklinik'] = mysqli_real_escape_string($conn, $value);
        } elseif (preg_match('/^alamat_poliklinik_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['alamat_poliklinik'] = mysqli_real_escape_string($conn, $value);
        } elseif (preg_match('/^nama_kecamatan_poliklinik_(\d+)$/', $key, $matches)) {
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

    foreach ($data as $poliklinik) {
        $sql = "INSERT INTO tb_poliklinik (nama_poliklinik, alamat_poliklinik, nama_kecamatan, koordinat_lintang, koordinat_bujur, tahun, user_id, desa_id)
                VALUES (
                    '{$poliklinik['nama_poliklinik']}',
                    '{$poliklinik['alamat_poliklinik']}',
                    '{$poliklinik['nama_kecamatan']}',
                    '{$poliklinik['koordinat_lintang']}',
                    '{$poliklinik['koordinat_bujur']}',
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
