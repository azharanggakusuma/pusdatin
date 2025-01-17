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
  $keberadaan_bpd = mysqli_real_escape_string($conn, $_POST['keberadaan_bpd']);
  $jumlah_laki = ($keberadaan_bpd === 'Ada') ? mysqli_real_escape_string($conn, $_POST['laki_laki']) : null;
  $jumlah_perempuan = ($keberadaan_bpd === 'Ada') ? mysqli_real_escape_string($conn, $_POST['perempuan']) : null;
  $jumlah_kegiatan = ($keberadaan_bpd === 'Ada') ? mysqli_real_escape_string($conn, $_POST['kegiatanMusyawarahDesa']) : null;

  // Check if the record already exists for the same year
  $check_query = "SELECT id FROM tb_badan_permusyawaratan_desa WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  $check_result = mysqli_query($conn, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    // If record exists for the same year, update the existing record
    $sql = "UPDATE tb_badan_permusyawaratan_desa 
                SET keberadaan_bpd = '$keberadaan_bpd', 
                    jumlah_laki = '$jumlah_laki', 
                    jumlah_perempuan = '$jumlah_perempuan', 
                    jumlah_kegiatan = '$jumlah_kegiatan', 
                    tahun = '$tahun' 
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  } else {
    // If record doesn't exist for the same year, insert a new record
    $sql = "INSERT INTO tb_badan_permusyawaratan_desa 
                (keberadaan_bpd, jumlah_laki, jumlah_perempuan, jumlah_kegiatan, user_id, desa_id, tahun)
                VALUES ('$keberadaan_bpd', '$jumlah_laki', '$jumlah_perempuan', '$jumlah_kegiatan', '$user_id', '$desa_id', '$tahun')";
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
