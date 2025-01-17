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
  $jumlah_tim_penggerak_pkk = intval($_POST['jumlah_tim_penggerak_pkk'] ?? 0);
  $jumlah_kader_pkk = intval($_POST['jumlah_kader_pkk'] ?? 0);
  $jumlah_kelompok_pkk = intval($_POST['jumlah_kelompok_pkk'] ?? 0);
  $jumlah_kelompok_dasa_wisma = intval($_POST['jumlah_kelompok_dasa_wisma'] ?? 0);

  // Check if the record already exists for the same year
  $check_query = "SELECT id FROM tb_data_pkk WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  $check_result = mysqli_query($conn, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    // If record exists for the same year, update the existing record
    $sql = "UPDATE tb_data_pkk 
                SET jumlah_tim_penggerak_pkk = '$jumlah_tim_penggerak_pkk', 
                    jumlah_kader_pkk = '$jumlah_kader_pkk', 
                    jumlah_kelompok_pkk = '$jumlah_kelompok_pkk', 
                    jumlah_kelompok_dasa_wisma = '$jumlah_kelompok_dasa_wisma', 
                    tahun = '$tahun' 
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  } else {
    // If record doesn't exist for the same year, insert a new record
    $sql = "INSERT INTO tb_data_pkk 
                (jumlah_tim_penggerak_pkk, jumlah_kader_pkk, jumlah_kelompok_pkk, jumlah_kelompok_dasa_wisma, user_id, desa_id, tahun)
                VALUES ('$jumlah_tim_penggerak_pkk', '$jumlah_kader_pkk', '$jumlah_kelompok_pkk', '$jumlah_kelompok_dasa_wisma', '$user_id', '$desa_id', '$tahun')";
  }

  if (mysqli_query($conn, $sql)) {
    header("Location: ../pages/forms/lembaga_kemasyarakatan_di_desa_kelurahan.php?status=success");
    exit();
  } else {
    header("Location: ../pages/forms/lembaga_kemasyarakatan_di_desa_kelurahan.php?status=error&message=" . urlencode(mysqli_error($conn)));
    exit();
  }
} else {
  header("Location: ../pages/forms/lembaga_kemasyarakatan_di_desa_kelurahan.php?status=warning");
  exit();
}
