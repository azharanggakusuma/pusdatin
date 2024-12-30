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
  // Menyimpan data fasilitas olahraga dari POST
  $sepak_bola = isset($_POST['sepakbola']) ? mysqli_real_escape_string($conn, $_POST['sepakbola']) : null;
  $bola_voli = isset($_POST['bolavoli']) ? mysqli_real_escape_string($conn, $_POST['bolavoli']) : null;
  $bulu_tangkis = isset($_POST['bulutangkis']) ? mysqli_real_escape_string($conn, $_POST['bulutangkis']) : null;
  $bola_basket = isset($_POST['basket']) ? mysqli_real_escape_string($conn, $_POST['basket']) : null;
  $tenis_lapangan = isset($_POST['tenislapangan']) ? mysqli_real_escape_string($conn, $_POST['tenislapangan']) : null;
  $tenis_meja = isset($_POST['tenismeja']) ? mysqli_real_escape_string($conn, $_POST['tenismeja']) : null;
  $futsal = isset($_POST['futsal']) ? mysqli_real_escape_string($conn, $_POST['futsal']) : null;
  $renang = isset($_POST['renang']) ? mysqli_real_escape_string($conn, $_POST['renang']) : null;
  $bela_diri = isset($_POST['beladiri']) ? mysqli_real_escape_string($conn, $_POST['beladiri']) : null;
  $bilyard = isset($_POST['bilyard']) ? mysqli_real_escape_string($conn, $_POST['bilyard']) : null;
  $fitness = isset($_POST['fitness']) ? mysqli_real_escape_string($conn, $_POST['fitness']) : null;
  $lainnya_nama = isset($_POST['lainnya']) ? mysqli_real_escape_string($conn, $_POST['lainnya']) : null;
  $lainnya_kondisi = isset($_POST['lainnyaSelect']) ? mysqli_real_escape_string($conn, $_POST['lainnyaSelect']) : null;

  // Check if all fields are empty
  if (!$sepak_bola && !$bola_voli && !$bulu_tangkis && !$bola_basket && !$tenis_lapangan && !$tenis_meja && !$futsal && !$renang && !$bela_diri && !$bilyard && !$fitness && !$lainnya_nama) {
    header("Location: ../pages/forms/olahraga.php?status=warning");
    exit();
  }

  // Masukkan data ke database
  $sql = "INSERT INTO tb_fasilitas_olahraga (sepak_bola, bola_voli, bulu_tangkis, bola_basket, tenis_lapangan, tenis_meja, futsal, renang, bela_diri, bilyard, fitness, lainnya_nama, lainnya_kondisi, user_id, desa_id) 
            VALUES ('$sepak_bola', '$bola_voli', '$bulu_tangkis', '$bola_basket', '$tenis_lapangan', '$tenis_meja', '$futsal', '$renang', '$bela_diri', '$bilyard', '$fitness', '$lainnya_nama', '$lainnya_kondisi', '$user_id', '$desa_id')";

  if (mysqli_query($conn, $sql)) {
    // Tambahkan atau perbarui progres pengguna
    $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id) 
                           VALUES ('$user_id', 'Ketersediaan fasilitas/lapangan olahraga di desa/kelurahan', TRUE, '$desa_id')
                           ON DUPLICATE KEY UPDATE is_locked = TRUE, desa_id = '$desa_id'";
    mysqli_query($conn, $query_progress);

    header("Location: ../pages/forms/olahraga.php?status=success");
    exit();
  } else {
    header("Location: ../pages/forms/olahraga.php?status=error&message=" . urlencode(mysqli_error($conn)));
    exit();
  }
} else {
  header("Location: ../pages/forms/olahraga.php?status=warning");
  exit();
}
