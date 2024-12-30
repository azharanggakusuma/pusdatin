<?php
include '../config/conn.php';
session_start();

// Ambil ID pengguna yang sedang login
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Ambil ID desa yang terkait dengan user yang sedang login
$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Menyimpan data dari form POST
  $peringatan_dini = mysqli_real_escape_string($conn, $_POST['peringatan_dini'] ?? '');
  $peringatan_tsunami = mysqli_real_escape_string($conn, $_POST['peringatan_tsunami'] ?? '');
  $perlengkapan_keselamatan = mysqli_real_escape_string($conn, $_POST['perlengkapan_keselamatan'] ?? '');
  $rambu_evakuasi = mysqli_real_escape_string($conn, $_POST['rambu_evakuasi'] ?? '');
  $infrastruktur = mysqli_real_escape_string($conn, $_POST['infrastruktur'] ?? '');

  // Check if any field is empty
  if (empty($peringatan_dini) || empty($peringatan_tsunami) || empty($perlengkapan_keselamatan) || empty($rambu_evakuasi) || empty($infrastruktur)) {
    header("Location: ../pages/forms/bencana_alam_dan_mitigasi_bencana_alam.php?status=warning&message=" . urlencode("All fields must be filled out."));
    exit();
  }

  // Masukkan data ke database
  $sql = "INSERT INTO tb_peringatan_bencana (peringatan_dini, peringatan_tsunami, perlengkapan_keselamatan, rambu_evakuasi, infrastruktur, user_id, desa_id) 
            VALUES ('$peringatan_dini', '$peringatan_tsunami', '$perlengkapan_keselamatan', '$rambu_evakuasi', '$infrastruktur', '$user_id', '$desa_id')";

  if (mysqli_query($conn, $sql)) {
    // Tambahkan atau perbarui progres pengguna
    $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id) 
                           VALUES ('$user_id', 'Fasilitas/upaya antisipasi/mitigasi bencana alam yang ada di desa/kelurahan', TRUE, '$desa_id')
                           ON DUPLICATE KEY UPDATE is_locked = TRUE, desa_id = '$desa_id'";
    mysqli_query($conn, $query_progress);

    header("Location: ../pages/forms/bencana_alam_dan_mitigasi_bencana_alam.php?status=success");
    exit();
  } else {
    header("Location: ../pages/forms/bencana_alam_dan_mitigasi_bencana_alam.php?status=error&message=" . urlencode(mysqli_error($conn)));
    exit();
  }
} else {
  header("Location: ../pages/forms/bencana_alam_dan_mitigasi_bencana_alam.php?status=warning");
  exit();
}
?>
