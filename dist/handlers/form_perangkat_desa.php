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
  $skd_laki = mysqli_real_escape_string($conn, $_POST['skd_laki_jumlah']);
  $skd_perempuan = mysqli_real_escape_string($conn, $_POST['skd_peremuan_jumlah']);
  $kaur_laki = mysqli_real_escape_string($conn, $_POST['kaur_laki_jumlah']);
  $kaur_perempuan = mysqli_real_escape_string($conn, $_POST['kaur_perempuan_jumlah']);
  $kkk_laki = mysqli_real_escape_string($conn, $_POST['kkk_laki_jumlah']);
  $kkk_perempuan = mysqli_real_escape_string($conn, $_POST['kkk_perempuan_jumlah']);
  $pk_laki = mysqli_real_escape_string($conn, $_POST['pk_laki_jumlah']);
  $pk_perempuan = mysqli_real_escape_string($conn, $_POST['pk_perempuan_jumlah']);
  $staf_laki = mysqli_real_escape_string($conn, $_POST['staf_laki_jumlah']);
  $staf_perempuan = mysqli_real_escape_string($conn, $_POST['staf_perempuan_jumlah']);
  $total_laki = mysqli_real_escape_string($conn, $_POST['jumlah_laki_jumlah']);
  $total_perempuan = mysqli_real_escape_string($conn, $_POST['jumlah_perempuan_jumlah']);

  // Check if the record already exists for the same year
  $check_query = "SELECT id FROM tb_perangkat_desa WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  $check_result = mysqli_query($conn, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    // If record exists for the same year, update the existing record
    $sql = "UPDATE tb_perangkat_desa 
                SET skd_laki = '$skd_laki', skd_perempuan = '$skd_perempuan', 
                    kaur_laki = '$kaur_laki', kaur_perempuan = '$kaur_perempuan', 
                    kkk_laki = '$kkk_laki', kkk_perempuan = '$kkk_perempuan', 
                    pk_laki = '$pk_laki', pk_perempuan = '$pk_perempuan', 
                    staf_laki = '$staf_laki', staf_perempuan = '$staf_perempuan', 
                    total_laki = '$total_laki', total_perempuan = '$total_perempuan', 
                    tahun = '$tahun' 
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  } else {
    // If record doesn't exist for the same year, insert a new record
    $sql = "INSERT INTO tb_perangkat_desa 
                (skd_laki, skd_perempuan, kaur_laki, kaur_perempuan, 
                 kkk_laki, kkk_perempuan, pk_laki, pk_perempuan, 
                 staf_laki, staf_perempuan, total_laki, total_perempuan, user_id, desa_id, tahun)
                VALUES ('$skd_laki', '$skd_perempuan', '$kaur_laki', '$kaur_perempuan', 
                        '$kkk_laki', '$kkk_perempuan', '$pk_laki', '$pk_perempuan', 
                        '$staf_laki', '$staf_perempuan', '$total_laki', '$total_perempuan', 
                        '$user_id', '$desa_id', '$tahun')";
  }

  if (mysqli_query($conn, $sql)) {
    header("Location: ../pages/forms/aparatur_pemerintahan_desa.php?status=success");
    exit();
  } else {
    header("Location: ../pages/forms/aparatur_pemerintahan_desa.php?status=error&message=" . urlencode(mysqli_error($conn)));
    exit();
  }
} else {
  header("Location: ../pages/forms/aparatur_pemerintahan_desa.php?status=warning");
  exit();
}
