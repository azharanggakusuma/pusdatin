<?php
session_start();
include "../config/conn.php";

// Ambil user_id dari session berdasarkan username
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

// Ambil desa_id yang terkait dengan user dari tb_enumerator
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
  $penetapan_batas_desa = mysqli_real_escape_string($conn, $_POST['penetapan_batas_desa'] ?? '');
  $no_surat_batas_desa = mysqli_real_escape_string($conn, $_POST['no_surat_batas_desa'] ?? '');
  $ketersediaan_peta_desa = mysqli_real_escape_string($conn, $_POST['ketersediaan_peta_desa'] ?? '');
  $no_surat_peta_desa = mysqli_real_escape_string($conn, $_POST['no_surat_peta_desa'] ?? '');

  // ============================
  // Bagian VALIDASI DASAR
  // ============================

  // 1) Validasi penetapan_batas_desa
  $allowed_penetapan = ['SUDAH ADA', 'BELUM ADA'];
  if (empty($penetapan_batas_desa) || !in_array($penetapan_batas_desa, $allowed_penetapan)) {
    $message = "Anda harus memilih status Penetapan Batas Desa.";
    header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
    exit();
  }

  // 2) Jika penetapan_batas_desa adalah SUDAH ADA, no_surat_batas_desa wajib diisi
  if ($penetapan_batas_desa === 'SUDAH ADA' && empty($no_surat_batas_desa)) {
    $message = "Anda harus mengisi No SK/Perbup/Perda/Perdes tentang Penetapan Batas Desa.";
    header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
    exit();
  }

  // 3) Validasi ketersediaan_peta_desa
  $allowed_peta = ['ADA', 'TIDAK ADA'];
  if (empty($ketersediaan_peta_desa) || !in_array($ketersediaan_peta_desa, $allowed_peta)) {
    $message = "Anda harus memilih status Ketersediaan Peta Desa.";
    header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
    exit();
  }

  // 4) Jika ketersediaan_peta_desa adalah ADA, no_surat_peta_desa wajib diisi
  if ($ketersediaan_peta_desa === 'ADA' && empty($no_surat_peta_desa)) {
    $message = "Anda harus mengisi No SK/Perbup/Perda tentang Peta Desa.";
    header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
    exit();
  }

  // Setelah validasi, cek apakah data sudah ada di db untuk tahun yang sama
  $check_query = "SELECT id 
                    FROM tb_ketersediaan_penetapan_peta_desa 
                    WHERE user_id = '$user_id' 
                      AND desa_id = '$desa_id' 
                      AND tahun = '$tahun'";
  $check_result = mysqli_query($conn, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    // Jika sudah ada, lakukan update
    $sql = "UPDATE tb_ketersediaan_penetapan_peta_desa
                SET penetapan_batas_desa = '$penetapan_batas_desa',
                    no_surat_batas_desa = " . (!empty($no_surat_batas_desa) ? "'$no_surat_batas_desa'" : "NULL") . ",
                    ketersediaan_peta_desa = '$ketersediaan_peta_desa',
                    no_surat_peta_desa = " . (!empty($no_surat_peta_desa) ? "'$no_surat_peta_desa'" : "NULL") . ",
                    tahun = '$tahun'
                WHERE user_id = '$user_id'
                  AND desa_id = '$desa_id'
                  AND tahun = '$tahun'";
  } else {
    // Jika belum ada, insert data baru
    $sql = "INSERT INTO tb_ketersediaan_penetapan_peta_desa (
                    penetapan_batas_desa, 
                    no_surat_batas_desa, 
                    ketersediaan_peta_desa, 
                    no_surat_peta_desa, 
                    tahun, 
                    user_id, 
                    desa_id
                ) VALUES (
                    '$penetapan_batas_desa', 
                    " . (!empty($no_surat_batas_desa) ? "'$no_surat_batas_desa'" : "NULL") . ",
                    '$ketersediaan_peta_desa', 
                    " . (!empty($no_surat_peta_desa) ? "'$no_surat_peta_desa'" : "NULL") . ", 
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
                             AND form_name = 'Ketersediaan Penetapan Batas dan Peta Desa'
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
                                  AND form_name = 'Ketersediaan Penetapan Batas dan Peta Desa'
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
                                    'Ketersediaan Penetapan Batas dan Peta Desa',
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
    // Gagal eksekusi query
    $error_message = "Terjadi kesalahan saat menyimpan data: " . mysqli_error($conn);
    header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($error_message));
    exit();
  }
} else {
  // Jika bukan method POST
  header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=warning");
  exit();
}
