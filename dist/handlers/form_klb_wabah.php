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

  // Insert data into database
  $sql = "INSERT INTO tb_klb_wabah (muntaber_diare, demam_berdarah, campak, malaria, flu_burung_sars, hepatitis_e, difteri, corona_covid19, lainnya_name, lainnya_status, user_id, desa_id)
            VALUES ('$muntaber_diare', '$demam_berdarah', '$campak', '$malaria', '$flu_burung_sars', '$hepatitis_e', '$difteri', '$corona_covid19', '$lainnya_name', '$lainnya_status', '$user_id', '$desa_id')";

  if (mysqli_query($conn, $sql)) {
    // Tambahkan atau perbarui progres pengguna
    $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id) 
                           VALUES ('$user_id', 'Jumlah Kejadian luar biasa (KLB) atau wabah penyakit selama setahun terakhir', TRUE, '$desa_id')
                           ON DUPLICATE KEY UPDATE is_locked = TRUE, desa_id = '$desa_id'";
    mysqli_query($conn, $query_progress);

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
