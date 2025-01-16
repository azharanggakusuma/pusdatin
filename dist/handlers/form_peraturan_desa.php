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
  $jumlah_peraturan_yang_dimiliki_desa = (int)mysqli_real_escape_string($conn, $_POST['jumlah_peraturan_yang_dimiliki_desa']);
  $jumlah_peraturan_kepala_desa = (int)mysqli_real_escape_string($conn, $_POST['jumlah_peraturan_kepala_desa']);

  // Check if a record exists for the same year
  $check_query = "SELECT id FROM tb_peraturan_desa WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  $check_result = mysqli_query($conn, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    // Update existing record
    $sql = "UPDATE tb_peraturan_desa SET 
            jumlah_peraturan_yang_dimiliki_desa = '$jumlah_peraturan_yang_dimiliki_desa',
            jumlah_peraturan_kepala_desa = '$jumlah_peraturan_kepala_desa'
            WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  } else {
    // Insert new record
    $sql = "INSERT INTO tb_peraturan_desa (
            jumlah_peraturan_yang_dimiliki_desa, jumlah_peraturan_kepala_desa, tahun, user_id, desa_id
        ) VALUES (
            '$jumlah_peraturan_yang_dimiliki_desa', '$jumlah_peraturan_kepala_desa', '$tahun', '$user_id', '$desa_id'
        )";
  }

  if (mysqli_query($conn, $sql)) {
    header("Location: ../pages/forms/keuangan_dan_aset_desa.php?status=success");
    exit();
  } else {
    header("Location: ../pages/forms/keuangan_dan_aset_desa.php?status=error&message=" . urlencode(mysqli_error($conn)));
    exit();
  }
} else {
  header("Location: ../pages/forms/keuangan_dan_aset_desa.php?status=warning");
  exit();
}
