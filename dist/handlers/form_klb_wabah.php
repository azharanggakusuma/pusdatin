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

// Retrieve year from session
$tahun = $_SESSION['tahun'] ?? null;

if (!$tahun) {
    echo "Tahun tidak ditemukan. Pastikan Anda telah login dengan memilih tahun.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize and prepare data from POST
  $muntaber_diare = $_POST['muntaber_diare'] ?? 'Tidak Ada';
  $demam_berdarah = $_POST['demam_berdarah'] ?? 'Tidak Ada';
  $campak = $_POST['campak'] ?? 'Tidak Ada';
  $malaria = $_POST['malaria'] ?? 'Tidak Ada';
  $flu_burung_sars = $_POST['flu_burung_sars'] ?? 'Tidak Ada';
  $hepatitis_e = $_POST['hepatitis_e'] ?? 'Tidak Ada';
  $difteri = $_POST['difteri'] ?? 'Tidak Ada';
  $corona_covid19 = $_POST['corona_covid19'] ?? 'Tidak Ada';
  $lainnya_name = $_POST['lainnya_name'] ?? NULL;
  $lainnya_status = $_POST['lainnya_status'] ?? 'Tidak Ada';

  // Check if the record already exists for the same year
  $check_query = "SELECT id_klb FROM tb_klb_wabah WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  $check_result = mysqli_query($conn, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    // If record exists for the same year, update the existing record
    $sql = "UPDATE tb_klb_wabah 
            SET muntaber_diare = '$muntaber_diare', demam_berdarah = '$demam_berdarah', campak = '$campak', malaria = '$malaria', 
                flu_burung_sars = '$flu_burung_sars', hepatitis_e = '$hepatitis_e', difteri = '$difteri', corona_covid19 = '$corona_covid19', 
                lainnya_name = '$lainnya_name', lainnya_status = '$lainnya_status', tahun = '$tahun' 
            WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  } else {
    // If record doesn't exist for the same year, insert a new record
    $sql = "INSERT INTO tb_klb_wabah (muntaber_diare, demam_berdarah, campak, malaria, flu_burung_sars, hepatitis_e, difteri, corona_covid19, lainnya_name, lainnya_status, user_id, desa_id, tahun)
            VALUES ('$muntaber_diare', '$demam_berdarah', '$campak', '$malaria', '$flu_burung_sars', '$hepatitis_e', '$difteri', '$corona_covid19', '$lainnya_name', '$lainnya_status', '$user_id', '$desa_id', '$tahun')";
  }

  if (mysqli_query($conn, $sql)) {
    // Check if progress entry exists for the same year
    $query_progress = "SELECT id FROM user_progress WHERE user_id = '$user_id' AND form_name = 'Jumlah Kejadian luar biasa (KLB) atau wabah penyakit selama setahun terakhir' AND tahun = '$tahun'";
    $result_progress = mysqli_query($conn, $query_progress);

    // Set created_at to the first day of the year at 00:00:00
    $created_at = $tahun . '-01-01 00:00:00';

    if (mysqli_num_rows($result_progress) > 0) {
      // If progress entry exists for the same year, update it
      $update_progress = "UPDATE user_progress 
                          SET is_locked = TRUE, desa_id = '$desa_id', created_at = '$created_at', tahun = '$tahun' 
                          WHERE user_id = '$user_id' AND form_name = 'Jumlah Kejadian luar biasa (KLB) atau wabah penyakit selama setahun terakhir' AND tahun = '$tahun'";
      mysqli_query($conn, $update_progress);
    } else {
      // If progress entry doesn't exist for the same year, insert a new entry
      $insert_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id, created_at, tahun) 
                          VALUES ('$user_id', 'Jumlah Kejadian luar biasa (KLB) atau wabah penyakit selama setahun terakhir', TRUE, '$desa_id', '$created_at', '$tahun')";
      mysqli_query($conn, $insert_progress);
    }

    header("Location: ../pages/forms/pendidikan_dan_kesehatan.php?status=success");
    exit();
  } else {
    header("Location: ../pages/forms/pendidikan_dan_kesehatan.php?status=error&message=" . urlencode(mysqli_error($conn)));
    exit();
  }
} else {
  header("Location: ../pages/forms/pendidikan_dan_kesehatan.php?status=warning");
  exit();
}
?>
