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
    $jumlah_dusun = mysqli_real_escape_string($conn, $_POST['jumlah_dusun'] ?? '');
    $jumlah_rw = mysqli_real_escape_string($conn, $_POST['jumlah_rw'] ?? '');
    $jumlah_rt = mysqli_real_escape_string($conn, $_POST['jumlah_rt'] ?? '');

    // ============================
    // Bagian VALIDASI DASAR
    // ============================

    $errors = [];

    // 1) Pastikan semua field diisi
    if ($jumlah_dusun === '') {
        $errors[] = "Anda harus mengisi Jumlah Dusun/Lingkungan/Sebutan Lain yang sejenis.";
    }
    if ($jumlah_rw === '') {
        $errors[] = "Anda harus mengisi Banyaknya RW.";
    }
    if ($jumlah_rt === '') {
        $errors[] = "Anda harus mengisi Banyaknya RT.";
    }

    // 2) Pastikan semua input adalah angka dan tidak negatif
    if ($jumlah_dusun !== '' && (!is_numeric($jumlah_dusun) || intval($jumlah_dusun) < 0)) {
        $errors[] = "Jumlah Dusun harus berupa angka non-negatif.";
    }
    if ($jumlah_rw !== '' && (!is_numeric($jumlah_rw) || intval($jumlah_rw) < 0)) {
        $errors[] = "Banyaknya RW harus berupa angka non-negatif.";
    }
    if ($jumlah_rt !== '' && (!is_numeric($jumlah_rt) || intval($jumlah_rt) < 0)) {
        $errors[] = "Banyaknya RT harus berupa angka non-negatif.";
    }

    // Jika ada error, redirect dengan pesan error
    if (!empty($errors)) {
        $message = implode(" ", $errors);
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
        exit();
    }

    // Convert to integer
    $jumlah_dusun = intval($jumlah_dusun);
    $jumlah_rw = intval($jumlah_rw);
    $jumlah_rt = intval($jumlah_rt);

    // Cek apakah data sudah ada di db untuk tahun yang sama
    $check_query = "SELECT id 
                    FROM tb_banyaknya_dusun_rt_rw 
                    WHERE user_id = '$user_id' 
                      AND desa_id = '$desa_id' 
                      AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Jika sudah ada, lakukan update
        $sql = "UPDATE tb_banyaknya_dusun_rt_rw
                SET jumlah_dusun = '$jumlah_dusun',
                    jumlah_rw = '$jumlah_rw',
                    jumlah_rt = '$jumlah_rt',
                    tahun = '$tahun'
                WHERE user_id = '$user_id'
                  AND desa_id = '$desa_id'
                  AND tahun = '$tahun'";
    } else {
        // Jika belum ada, insert data baru
        $sql = "INSERT INTO tb_banyaknya_dusun_rt_rw (
                    jumlah_dusun, 
                    jumlah_rw, 
                    jumlah_rt, 
                    tahun, 
                    user_id, 
                    desa_id
                ) VALUES (
                    '$jumlah_dusun', 
                    '$jumlah_rw', 
                    '$jumlah_rt', 
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
                             AND form_name = 'Banyaknya Dusun, Rukun Tetangga dan Rukun Warga'
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
                                  AND form_name = 'Banyaknya Dusun, Rukun Tetangga dan Rukun Warga'
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
                                    'Banyaknya Dusun, Rukun Tetangga dan Rukun Warga',
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
?>
