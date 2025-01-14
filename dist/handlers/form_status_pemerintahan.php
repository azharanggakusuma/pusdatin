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
    $status_2024 = mysqli_real_escape_string($conn, $_POST['status_2024'] ?? '');

    // ============================
    // Bagian VALIDASI DASAR
    // ============================
    // 1) Pastikan user memilih status (tidak boleh kosong)
    if (empty($status_2024)) {
        $message = "Anda harus memilih salah satu Status Pemerintahan.";
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
        exit();
    }

    // (Opsional) Tambahan validasi: pastikan value sesuai pilihan yang diizinkan
    $allowed_statuses = ["DESA","KELURAHAN","KAMPUNG","NAGARI","GAMPONG"];
    if (!in_array($status_2024, $allowed_statuses)) {
        $message = "Pilihan Status Pemerintahan tidak valid.";
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
        exit();
    }

    // Cek apakah data untuk tahun yang sama sudah ada di db
    $check_query = "SELECT id 
                    FROM tb_status_pemerintahan 
                    WHERE user_id = '$user_id'
                      AND desa_id = '$desa_id'
                      AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Jika sudah ada, lakukan update
        $sql = "UPDATE tb_status_pemerintahan
                SET status_pemerintahan = '$status_2024',
                    tahun = '$tahun'
                WHERE user_id = '$user_id'
                  AND desa_id = '$desa_id'
                  AND tahun = '$tahun'";
    } else {
        // Jika belum ada, insert baru
        $sql = "INSERT INTO tb_status_pemerintahan (
                    status_pemerintahan,
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
        // Kelola user_progress
        $query_progress = "SELECT id
                           FROM user_progress
                           WHERE user_id = '$user_id'
                             AND form_name = 'Status Pemerintahan'
                             AND tahun = '$tahun'";
        $result_progress = mysqli_query($conn, $query_progress);

        // Tanggal awal tahun
        $created_at = $tahun . '-01-01 00:00:00';

        if (mysqli_num_rows($result_progress) > 0) {
            // Update progress jika sudah ada
            $update_progress = "UPDATE user_progress
                                SET is_locked = TRUE,
                                    desa_id = '$desa_id',
                                    created_at = '$created_at',
                                    tahun = '$tahun'
                                WHERE user_id = '$user_id'
                                  AND form_name = 'Status Pemerintahan'
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
                                    'Status Pemerintahan',
                                    TRUE,
                                    '$desa_id',
                                    '$created_at',
                                    '$tahun'
                                )";
            mysqli_query($conn, $insert_progress);
        }

        // Berhasil simpan
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
?>
