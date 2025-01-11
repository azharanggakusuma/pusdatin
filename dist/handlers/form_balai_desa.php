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

  // Check if the record already exists in `tb_balai_desa`
  $check_query = "SELECT id FROM tb_balai_desa WHERE user_id = '$user_id' AND desa_id = '$desa_id'";
  $check_result = mysqli_query($conn, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    // Update existing record
    $sql = "UPDATE tb_balai_desa 
            SET alamat_balai = '$alamat_balai', nama_kecamatan = '$nama_kecamatan' 
            WHERE user_id = '$user_id' AND desa_id = '$desa_id'";
  } else {
    // Insert new record
    $sql = "INSERT INTO tb_balai_desa (alamat_balai, nama_kecamatan, user_id, desa_id)
            VALUES ('$alamat_balai', '$nama_kecamatan', '$user_id', '$desa_id')";
  }

  if (mysqli_query($conn, $sql)) {
    // Check if progress entry exists
    $query_progress = "SELECT id FROM user_progress WHERE user_id = '$user_id' AND form_name = 'Alamat Balai Desa/Kantor Kelurahan'";
    $result_progress = mysqli_query($conn, $query_progress);

    $current_time = date('Y-m-d H:i:s');

    if (mysqli_num_rows($result_progress) > 0) {
      // Update progress if it exists, including created_at
      $update_progress = "UPDATE user_progress 
                          SET is_locked = TRUE, desa_id = '$desa_id', created_at = '$current_time' 
                          WHERE user_id = '$user_id' AND form_name = 'Alamat Balai Desa/Kantor Kelurahan'";
      mysqli_query($conn, $update_progress);
    } else {
      // Insert new progress if it doesn't exist
      $insert_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id, created_at) 
                          VALUES ('$user_id', 'Alamat Balai Desa/Kantor Kelurahan', TRUE, '$desa_id', '$current_time')";
      mysqli_query($conn, $insert_progress);
    }

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
