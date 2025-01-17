<?php
session_start();
include "../config/conn.php";

// Retrieve user ID and year from session
$username = $_SESSION['username'] ?? '';
$tahun = $_SESSION['tahun'] ?? null;

if (!$tahun || !$username) {
  echo "Tahun atau pengguna tidak ditemukan. Pastikan Anda telah login.";
  exit();
}

// Fetch user_id and desa_id
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize and prepare data
  $jumlah_pln = mysqli_real_escape_string($conn, $_POST['jumlah_pln']);
  $jumlah_non_pln = mysqli_real_escape_string($conn, $_POST['jumlah_non_pln']);
  $jumlah_bukan_pengguna = mysqli_real_escape_string($conn, $_POST['jumlah_bukan_pengguna_listrik']);
  $lampu_tenaga_surya = mysqli_real_escape_string($conn, $_POST['penggunaan_lampu_tenaga_surya']);

  // Insert or update record
  $check_query = "SELECT id FROM tb_pengguna_listrik_lampu_surya WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  $check_result = mysqli_query($conn, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    $sql = "UPDATE tb_pengguna_listrik_lampu_surya SET 
            jumlah_pln = '$jumlah_pln',
            jumlah_non_pln = '$jumlah_non_pln',
            jumlah_bukan_pengguna_listrik = '$jumlah_bukan_pengguna',
            penggunaan_lampu_tenaga_surya = '$lampu_tenaga_surya'
            WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  } else {
    $sql = "INSERT INTO tb_pengguna_listrik_lampu_surya (
            jumlah_pln, jumlah_non_pln, jumlah_bukan_pengguna_listrik, penggunaan_lampu_tenaga_surya, tahun, user_id, desa_id
        ) VALUES (
            '$jumlah_pln', '$jumlah_non_pln', '$jumlah_bukan_pengguna', '$lampu_tenaga_surya', '$tahun', '$user_id', '$desa_id'
        )";
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
