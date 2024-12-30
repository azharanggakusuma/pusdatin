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
  // Menyimpan data bencana alam dari POST
  $tanah_longsor = isset($_POST['tanah_longsor']) && $_POST['tanah_longsor'] === 'Ada' ? 'Ada' : 'Tidak Ada';
  $banjir = isset($_POST['banjir']) && $_POST['banjir'] === 'Ada' ? 'Ada' : 'Tidak Ada';
  $banjir_bandang = isset($_POST['banjir_bandang']) && $_POST['banjir_bandang'] === 'Ada' ? 'Ada' : 'Tidak Ada';
  $gempa_bumi = isset($_POST['gempa_bumi']) && $_POST['gempa_bumi'] === 'Ada' ? 'Ada' : 'Tidak Ada';
  $tsunami = isset($_POST['tsunami']) && $_POST['tsunami'] === 'Ada' ? 'Ada' : 'Tidak Ada';
  $gelombang_pasang = isset($_POST['gelombang_pasang']) && $_POST['gelombang_pasang'] === 'Ada' ? 'Ada' : 'Tidak Ada';
  $angin_puyuh = isset($_POST['angin_puyuh']) && $_POST['angin_puyuh'] === 'Ada' ? 'Ada' : 'Tidak Ada';
  $gunung_meletus = isset($_POST['gunung_meletus']) && $_POST['gunung_meletus'] === 'Ada' ? 'Ada' : 'Tidak Ada';
  $kebakaran_hutan = isset($_POST['kebakaran_hutan']) && $_POST['kebakaran_hutan'] === 'Ada' ? 'Ada' : 'Tidak Ada';
  $kekeringan = isset($_POST['kekeringan']) && $_POST['kekeringan'] === 'Ada' ? 'Ada' : 'Tidak Ada';
  $abrasi = isset($_POST['abrasi']) && $_POST['abrasi'] === 'Ada' ? 'Ada' : 'Tidak Ada';

  // Check if all fields are 'Tidak Ada'
  if ($tanah_longsor === 'Tidak Ada' && $banjir === 'Tidak Ada' && $banjir_bandang === 'Tidak Ada' && $gempa_bumi === 'Tidak Ada' && $tsunami === 'Tidak Ada' && $gelombang_pasang === 'Tidak Ada' && $angin_puyuh === 'Tidak Ada' && $gunung_meletus === 'Tidak Ada' && $kebakaran_hutan === 'Tidak Ada' && $kekeringan === 'Tidak Ada' && $abrasi === 'Tidak Ada') {
    header("Location: ../pages/forms/bencana_alam_dan_mitigasi_bencana_alam.php?status=warning&message=" . urlencode("At least one disaster must be reported as present."));
    exit();
  }

  // Masukkan data ke database
  $sql = "INSERT INTO tb_bencana_alam (tanah_longsor, banjir, banjir_bandang, gempa_bumi, tsunami, gelombang_pasang, angin_puyuh, gunung_meletus, kebakaran_hutan, kekeringan, abrasi, user_id, desa_id) 
            VALUES ('$tanah_longsor', '$banjir', '$banjir_bandang', '$gempa_bumi', '$tsunami', '$gelombang_pasang', '$angin_puyuh', '$gunung_meletus', '$kebakaran_hutan', '$kekeringan', '$abrasi', '$user_id', '$desa_id')";

  if (mysqli_query($conn, $sql)) {
    // Tambahkan atau perbarui progres pengguna
    $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id) 
                           VALUES ('$user_id', 'Kejadian/bencana alam (mengganggu kehidupan dan menyebabkan kerugian bagi masyarakat) yang terjadi', TRUE, '$desa_id')
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
