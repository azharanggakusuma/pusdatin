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
  // Sanitize and prepare data from POST
  $sutet_status = mysqli_real_escape_string($conn, $_POST['SUTET']);
  $keberadaan_pemukiman = mysqli_real_escape_string($conn, $_POST['keberadaan_dibawah_sutet']);
  $jumlah_pemukiman = isset($_POST['jumlah_pemukiman_dibawah_sutet']) ? intval($_POST['jumlah_pemukiman_dibawah_sutet']) : null;

  // Check if the record already exists for the same year
  $check_query = "SELECT id FROM tb_sutet WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  $check_result = mysqli_query($conn, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    // If record exists for the same year, update the existing record
    $sql = "UPDATE tb_sutet 
                SET sutet_status = '$sutet_status', keberadaan_pemukiman = '$keberadaan_pemukiman', 
                    jumlah_pemukiman = " . ($jumlah_pemukiman !== null ? "'$jumlah_pemukiman'" : "NULL") . ", tahun = '$tahun' 
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  } else {
    // If record doesn't exist for the same year, insert a new record
    $sql = "INSERT INTO tb_sutet (sutet_status, keberadaan_pemukiman, jumlah_pemukiman, user_id, desa_id, tahun)
                VALUES ('$sutet_status', '$keberadaan_pemukiman', " . ($jumlah_pemukiman !== null ? "'$jumlah_pemukiman'" : "NULL") . ", '$user_id', '$desa_id', '$tahun')";
  }

  if (mysqli_query($conn, $sql)) {
    // Check if progress entry exists for the same year
    $query_progress = "SELECT id FROM user_progress WHERE user_id = '$user_id' AND form_name = 'Wilayah SUTET/SUTT/SUTTAS' AND tahun = '$tahun'";
    $result_progress = mysqli_query($conn, $query_progress);

    // Set created_at to the first day of the year at 00:00:00
    $created_at = $tahun . '-01-01 00:00:00';

    if (mysqli_num_rows($result_progress) > 0) {
      // If progress entry exists for the same year, update it
      $update_progress = "UPDATE user_progress 
                                SET is_locked = TRUE, desa_id = '$desa_id', created_at = '$created_at', tahun = '$tahun' 
                                WHERE user_id = '$user_id' AND form_name = 'Wilayah SUTET/SUTT/SUTTAS' AND tahun = '$tahun'";
      mysqli_query($conn, $update_progress);
    } else {
      // If progress entry doesn't exist for the same year, insert a new entry
      $insert_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id, created_at, tahun) 
                                VALUES ('$user_id', 'Wilayah SUTET/SUTT/SUTTAS', TRUE, '$desa_id', '$created_at', '$tahun')";
      mysqli_query($conn, $insert_progress);
    }

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
