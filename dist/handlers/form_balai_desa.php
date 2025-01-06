<?php
include '../config/conn.php';
session_start();

// Retrieve user ID from session
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Retrieve village ID associated with the user
$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize and prepare data from POST
  $alamat_balai = mysqli_real_escape_string($conn, $_POST['alamat_balai']);
  $nama_kecamatan = mysqli_real_escape_string($conn, $_POST['nama_kecamatan']);

  // Insert data into database
  $sql = "INSERT INTO tb_balai_desa (alamat_balai, nama_kecamatan, user_id, desa_id)
          VALUES ('$alamat_balai', '$nama_kecamatan', '$user_id', '$desa_id')";

  if (mysqli_query($conn, $sql)) {
    // Tambahkan atau perbarui progres pengguna
    $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id) 
                       VALUES ('$user_id', 'Alamat Balai Desa/Kantor Kelurahan', TRUE, '$desa_id')
                       ON DUPLICATE KEY UPDATE is_locked = TRUE, desa_id = '$desa_id'";
    mysqli_query($conn, $query_progress);

    header("Location: ../pages/forms/keterangan_tempat.php?status=success");
    exit();
  } else {
    header("Location: ../pages/forms/keterangan_tempat.php?status=error&message=" . urlencode(mysqli_error($conn)));
    exit();
  }
} else {
  header("Location: ../pages/forms/keterangan_tempat.php?status=warning");
  exit();
}
