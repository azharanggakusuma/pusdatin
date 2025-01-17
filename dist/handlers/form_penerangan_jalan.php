<?php
session_start();
include "../config/conn.php";

$username = $_SESSION['username'] ?? '';
$tahun = $_SESSION['tahun'] ?? null;

if (!$tahun || !$username) {
  echo "Tahun atau pengguna tidak ditemukan. Pastikan Anda telah login.";
  exit();
}

$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $lampu_tenaga_surya = mysqli_real_escape_string($conn, $_POST['lampu_tenaga_surya']);
  $penerangan_jalan_utama = mysqli_real_escape_string($conn, $_POST['penerangan_jalan_utama']);
  $sumber_penerangan = mysqli_real_escape_string($conn, $_POST['sumber_penerangan']);

  $check_query = "SELECT id FROM tb_penerangan_jalan WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  $check_result = mysqli_query($conn, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    $sql = "UPDATE tb_penerangan_jalan SET 
                lampu_tenaga_surya = '$lampu_tenaga_surya', 
                penerangan_jalan_utama = '$penerangan_jalan_utama', 
                sumber_penerangan = '$sumber_penerangan' 
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  } else {
    $sql = "INSERT INTO tb_penerangan_jalan (lampu_tenaga_surya, penerangan_jalan_utama, sumber_penerangan, tahun, user_id, desa_id)
                VALUES ('$lampu_tenaga_surya', '$penerangan_jalan_utama', '$sumber_penerangan', '$tahun', '$user_id', '$desa_id')";
  }

  if (mysqli_query($conn, $sql)) {
    header("Location: ../pages/forms/perumahan_dan_lingkungan_hidup.php?status=success");
    exit();
  } else {
    header("Location: ../pages/forms/perumahan_dan_lingkungan_hidup.php?status=error&message=" . urlencode(mysqli_error($conn)));
    exit();
  }
} else {
  header("Location: ../pages/forms/perumahan_dan_lingkungan_hidup.php?status=warning");
  exit();
}
