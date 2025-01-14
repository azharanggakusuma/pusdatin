<?php
session_start();
include "../config/conn.php";

// Ambil user_id dari session
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Ambil tahun dari session
$tahun = $_SESSION['tahun'] ?? null;
if (!$tahun) {
  echo "Tahun tidak ditemukan. Pastikan Anda telah login dengan memilih tahun.";
  exit();
}

// Ambil desa_id yang terkait dengan user
$query_desa = "SELECT id_desa 
               FROM tb_enumerator 
               WHERE user_id = '$user_id'
               ORDER BY id_desa DESC 
               LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

// Proses hanya jika metode request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Ambil dan amankan input dari form
  $alamat_website   = mysqli_real_escape_string($conn, $_POST['alamat_website'] ?? '');
  $alamat_email     = mysqli_real_escape_string($conn, $_POST['alamat_email'] ?? '');
  $alamat_facebook  = mysqli_real_escape_string($conn, $_POST['alamat_facebook'] ?? '');
  $alamat_twitter   = mysqli_real_escape_string($conn, $_POST['alamat_twitter'] ?? '');
  $alamat_youtube   = mysqli_real_escape_string($conn, $_POST['alamat_youtube'] ?? '');

  // ============================
  // Bagian VALIDASI DASAR
  // ============================

  // 1) Validasi Email (jika tidak kosong)
  if (!empty($alamat_email) && !filter_var($alamat_email, FILTER_VALIDATE_EMAIL)) {
    $message = "Alamat email tidak valid.";
    header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
    exit();
  }

  // 2) Validasi URL (jika tidak kosong)
  //    Kita cek format URL untuk website, Facebook, Twitter, YouTube
  //    Contoh validasi sederhana dengan filter_var(..., FILTER_VALIDATE_URL)
  //    Bisa juga dipakai regex khusus jika ingin lebih ketat
  $urlFields = [
    'Website'   => $alamat_website,
    'Facebook'  => $alamat_facebook,
    'Twitter'   => $alamat_twitter,
    'YouTube'   => $alamat_youtube
  ];

  foreach ($urlFields as $fieldName => $value) {
    if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
      $message = "Alamat $fieldName tidak valid. Pastikan menggunakan format URL (http(s)://...)";
      header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
      exit();
    }
  }

  // Setelah validasi, cek apakah data sudah ada di db untuk tahun yang sama
  $check_query = "SELECT id 
                    FROM tb_website_medsos 
                    WHERE user_id = '$user_id' 
                      AND desa_id = '$desa_id' 
                      AND tahun = '$tahun'";
  $check_result = mysqli_query($conn, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    // Jika sudah ada, lakukan update
    $sql = "UPDATE tb_website_medsos
                SET alamat_website = '$alamat_website',
                    alamat_email = '$alamat_email',
                    alamat_facebook = '$alamat_facebook',
                    alamat_twitter = '$alamat_twitter',
                    alamat_youtube = '$alamat_youtube',
                    tahun = '$tahun'
                WHERE user_id = '$user_id'
                  AND desa_id = '$desa_id'
                  AND tahun = '$tahun'";
  } else {
    // Jika belum ada, insert data baru
    $sql = "INSERT INTO tb_website_medsos (
                    alamat_website, 
                    alamat_email, 
                    alamat_facebook,
                    alamat_twitter,
                    alamat_youtube,
                    tahun, 
                    user_id, 
                    desa_id
                ) VALUES (
                    '$alamat_website', 
                    '$alamat_email',
                    '$alamat_facebook',
                    '$alamat_twitter',
                    '$alamat_youtube',
                    '$tahun', 
                    '$user_id', 
                    '$desa_id'
                )";
  }

  // Eksekusi query
  if (mysqli_query($conn, $sql)) {
    // Kelola user_progress: menandakan form ini sudah diisi
    $query_progress = "SELECT id
                           FROM user_progress
                           WHERE user_id = '$user_id'
                             AND form_name = 'Website & Media Sosial'
                             AND tahun = '$tahun'";
    $result_progress = mysqli_query($conn, $query_progress);

    $created_at = $tahun . '-01-01 00:00:00';

    if (mysqli_num_rows($result_progress) > 0) {
      // Update progress jika sudah ada
      $update_progress = "UPDATE user_progress
                                SET is_locked = TRUE,
                                    desa_id = '$desa_id',
                                    created_at = '$created_at',
                                    tahun = '$tahun'
                                WHERE user_id = '$user_id'
                                  AND form_name = 'Website & Media Sosial'
                                  AND tahun = '$tahun'";
      mysqli_query($conn, $update_progress);
    } else {
      // Insert progress jika belum ada
      $insert_progress = "INSERT INTO user_progress (
                                    user_id, 
                                    form_name, 
                                    is_locked, 
                                    desa_id, 
                                    created_at, 
                                    tahun
                                ) VALUES (
                                    '$user_id',
                                    'Website & Media Sosial',
                                    TRUE,
                                    '$desa_id',
                                    '$created_at',
                                    '$tahun'
                                )";
      mysqli_query($conn, $insert_progress);
    }

    // Sukses simpan
    header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=success");
    exit();
  } else {
    // Gagal query
    $error_message = "Terjadi kesalahan saat menyimpan data: " . mysqli_error($conn);
    header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($error_message));
    exit();
  }
} else {
  // Jika bukan method POST
  header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=warning");
  exit(); 
}
