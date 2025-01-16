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
  $data = [
    'jumlah_unit_usaha_bumdes' => (int)mysqli_real_escape_string($conn, $_POST['jumlah_unit_usaha_bumdes']),
    'tanah_kas_desa_ulayat' => mysqli_real_escape_string($conn, $_POST['tanah_kas_desa_ulayat']),
    'tambatan_perahu' => mysqli_real_escape_string($conn, $_POST['tambatan_perahu']),
    'pasar_desa' => mysqli_real_escape_string($conn, $_POST['pasar_desa']),
    'bangunan_milik_desa' => mysqli_real_escape_string($conn, $_POST['bangunan_milik_desa']),
    'hutan_milik_desa' => mysqli_real_escape_string($conn, $_POST['hutan_milik_desa']),
    'mata_air_milik_desa' => mysqli_real_escape_string($conn, $_POST['mata_air_milik_desa']),
    'tempat_wisata_pemandian_umum' => mysqli_real_escape_string($conn, $_POST['tempat_wisata_pemandian_umum']),
    'aset_lainnya_milik_desa' => mysqli_real_escape_string($conn, $_POST['aset_lainnya_milik_desa']),
  ];

  // Check if a record exists for the same year
  $check_query = "SELECT id FROM tb_badan_usaha_aset_desa WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  $check_result = mysqli_query($conn, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    // Update existing record
    $sql = "UPDATE tb_badan_usaha_aset_desa SET 
            jumlah_unit_usaha_bumdes = '{$data['jumlah_unit_usaha_bumdes']}',
            tanah_kas_desa_ulayat = '{$data['tanah_kas_desa_ulayat']}',
            tambatan_perahu = '{$data['tambatan_perahu']}',
            pasar_desa = '{$data['pasar_desa']}',
            bangunan_milik_desa = '{$data['bangunan_milik_desa']}',
            hutan_milik_desa = '{$data['hutan_milik_desa']}',
            mata_air_milik_desa = '{$data['mata_air_milik_desa']}',
            tempat_wisata_pemandian_umum = '{$data['tempat_wisata_pemandian_umum']}',
            aset_lainnya_milik_desa = '{$data['aset_lainnya_milik_desa']}'
            WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
  } else {
    // Insert new record
    $sql = "INSERT INTO tb_badan_usaha_aset_desa (
            jumlah_unit_usaha_bumdes, tanah_kas_desa_ulayat, tambatan_perahu, pasar_desa, 
            bangunan_milik_desa, hutan_milik_desa, mata_air_milik_desa, 
            tempat_wisata_pemandian_umum, aset_lainnya_milik_desa, tahun, user_id, desa_id
        ) VALUES (
            '{$data['jumlah_unit_usaha_bumdes']}', '{$data['tanah_kas_desa_ulayat']}', '{$data['tambatan_perahu']}', '{$data['pasar_desa']}',
            '{$data['bangunan_milik_desa']}', '{$data['hutan_milik_desa']}', '{$data['mata_air_milik_desa']}',
            '{$data['tempat_wisata_pemandian_umum']}', '{$data['aset_lainnya_milik_desa']}', '$tahun', '$user_id', '$desa_id'
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
