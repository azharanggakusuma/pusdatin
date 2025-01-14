<?php
session_start();
include "../config/conn.php";

// Ambil user_id dari session berdasarkan username
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Ambil tahun dari session (misalnya user memilih tahun pendataan saat login)
$tahun = $_SESSION['tahun'] ?? null;
if (!$tahun) {
  echo "Tahun tidak ditemukan. Pastikan Anda telah login dengan memilih tahun.";
  exit();
}

// Ambil desa_id yang terkait dengan user (misalnya dari tb_enumerator)
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
  $status_2024 = mysqli_real_escape_string($conn, $_POST['status_2024'] ?? '');

  // ============================
  // Bagian VALIDASI DASAR
  // ============================
  // 1) Pastikan user sudah memilih status (tidak boleh kosong)
  if (empty($status_2024)) {
    $message = "Anda harus memilih Status Desa Membangun (IDM).";
    header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
    exit();
  }
  // (Opsional) Tambahan validasi: pastikan input sesuai pilihan yang diizinkan
  $allowed_statuses = ["MANDIRI", "MAJU", "BERKEMBANG", "TERTINGGAL", "SANGAT TERTINGGAL"];
  if (!in_array($status_2024, $allowed_statuses)) {
    $message = "Status Desa Membangun tidak valid.";
    header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
    exit();
  }

  // Cek apakah data IDM untuk tahun yang sama sudah pernah disimpan
  $check_query = "SELECT id 
                    FROM tb_idm_status 
                    WHERE user_id = '$user_id' 
                      AND desa_id = '$desa_id' 
                      AND tahun = '$tahun'";
  $check_result = mysqli_query($conn, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    // Jika sudah ada, lakukan update
    $sql = "UPDATE tb_idm_status
                SET status_idm = '$status_2024',
                    tahun = '$tahun'
                WHERE user_id = '$user_id'
                  AND desa_id = '$desa_id'
                  AND tahun = '$tahun'";
  } else {
    // Jika belum ada, lakukan insert
    $sql = "INSERT INTO tb_idm_status (
                    status_idm,
                    tahun,
                    user_id,
                    desa_id
                ) VALUES (
                    '$status_2024',
                    '$tahun',
                    '$user_id',
                    '$desa_id'
                )";
  }

  // Eksekusi query
  if (mysqli_query($conn, $sql)) {
    // Mengelola progress user (menandakan form IDM sudah terisi)
    $query_progress = "SELECT id 
                           FROM user_progress
                           WHERE user_id = '$user_id'
                             AND form_name = 'IDM'
                             AND tahun = '$tahun'";
    $result_progress = mysqli_query($conn, $query_progress);

    // Buat tanggal awal tahun untuk created_at
    $created_at = $tahun . '-01-01 00:00:00';

    if (mysqli_num_rows($result_progress) > 0) {
      // Update jika data progress sudah ada
      $update_progress = "UPDATE user_progress
                                SET is_locked = TRUE,
                                    desa_id = '$desa_id',
                                    created_at = '$created_at',
                                    tahun = '$tahun'
                                WHERE user_id = '$user_id'
                                  AND form_name = 'IDM'
                                  AND tahun = '$tahun'";
      mysqli_query($conn, $update_progress);
    } else {
      // Insert jika belum ada record progress
      $insert_progress = "INSERT INTO user_progress (
                                    user_id,
                                    form_name,
                                    is_locked,
                                    desa_id,
                                    created_at,
                                    tahun
                                ) VALUES (
                                    '$user_id',
                                    'IDM',
                                    TRUE,
                                    '$desa_id',
                                    '$created_at',
                                    '$tahun'
                                )";
      mysqli_query($conn, $insert_progress);
    }

    // Jika berhasil simpan
    header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=success");
    exit();
  } else {
    // Jika query gagal
    $error_message = "Terjadi kesalahan saat menyimpan data: " . mysqli_error($conn);
    header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($error_message));
    exit();
  }
} else {
  // Jika bukan metode POST, redirect
  header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=warning");
  exit();
}
