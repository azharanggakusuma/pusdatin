<?php
session_start();
include "../config/conn.php";

$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

$tahun = $_SESSION['tahun'] ?? null;

if (!$tahun) {
    echo "Tahun tidak ditemukan.";
    exit();
}

$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [];
    foreach ($_POST as $key => $value) {
        if (preg_match('/^nama_potensi_wisata_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['nama_potensi_wisata'] = mysqli_real_escape_string($conn, $value);
        } elseif (preg_match('/^jenis_wisata_desa_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['jenis_wisata_desa'] = mysqli_real_escape_string($conn, $value);
        } elseif (preg_match('/^titik_koordinat_lintang_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['titik_koordinat_lintang'] = mysqli_real_escape_string($conn, $value);
        } elseif (preg_match('/^titik_koordinat_bujur_(\d+)$/', $key, $matches)) {
            $index = $matches[1];
            $data[$index]['titik_koordinat_bujur'] = mysqli_real_escape_string($conn, $value);
        }
    }

    foreach ($data as $entry) {
        $nama = $entry['nama_potensi_wisata'] ?? '';
        $jenis = $entry['jenis_wisata_desa'] ?? '';
        $lintang = $entry['titik_koordinat_lintang'] ?? '';
        $bujur = $entry['titik_koordinat_bujur'] ?? '';

        if ($nama && $jenis && $lintang && $bujur) {
            $sql = "INSERT INTO tb_potensi_wisata (nama_potensi_wisata, jenis_wisata, titik_koordinat_lintang, titik_koordinat_bujur, user_id, desa_id, tahun)
                    VALUES ('$nama', '$jenis', '$lintang', '$bujur', '$user_id', '$desa_id', '$tahun')";
            if (!mysqli_query($conn, $sql)) {
                header("Location: ../pages/forms/data_lokasi_geospasial.php?status=error&message=" . urlencode(mysqli_error($conn)));
                exit();
            }
        }
    }

    header("Location: ../pages/forms/data_lokasi_geospasial.php?status=success");
    exit();
} else {
    header("Location: ../pages/forms/data_lokasi_geospasial.php?status=warning");
    exit();
}
?>
