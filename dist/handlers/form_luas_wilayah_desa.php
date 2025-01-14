<?php
session_start();
include "../config/conn.php";

// Ambil user_id dari session berdasarkan username
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);

if (!$result_user) {
    // Jika query gagal
    echo "Terjadi kesalahan saat mengambil data pengguna: " . mysqli_error($conn);
    exit();
}

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

if (!$result_desa) {
    echo "Terjadi kesalahan saat mengambil data desa: " . mysqli_error($conn);
    exit();
}

$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

// Proses hanya jika metode request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil dan amankan input dari form
    $luas_wilayah_desa = mysqli_real_escape_string($conn, $_POST['luas_wilayah_desa'] ?? '');

    // ============================
    // Bagian VALIDASI DASAR
    // ============================

    $errors = [];

    // 1) Pastikan field diisi
    if ($luas_wilayah_desa === '') {
        $errors[] = "Anda harus mengisi Luas Wilayah Desa.";
    }

    // 2) Pastikan input adalah angka, non-negatif, dan sesuai format desimal
    if ($luas_wilayah_desa !== '') {
        if (!is_numeric($luas_wilayah_desa)) {
            $errors[] = "Luas Wilayah Desa harus berupa angka.";
        } elseif (floatval($luas_wilayah_desa) < 0) {
            $errors[] = "Luas Wilayah Desa tidak boleh negatif.";
        }
    }

    // Jika ada error, redirect dengan pesan error
    if (!empty($errors)) {
        $message = implode(" ", $errors);
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
        exit();
    }

    // Konversi ke float dengan dua desimal
    $luas_wilayah_desa = number_format((float)$luas_wilayah_desa, 2, '.', '');

    // Cek apakah data sudah ada di db untuk tahun yang sama
    $check_query = "SELECT id 
                    FROM tb_luas_wilayah_desa 
                    WHERE user_id = '$user_id' 
                      AND desa_id = '$desa_id' 
                      AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (!$check_result) {
        // Jika query cek gagal
        $error_message = "Terjadi kesalahan saat memeriksa data: " . mysqli_error($conn);
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($error_message));
        exit();
    }

    if (mysqli_num_rows($check_result) > 0) {
        // Jika sudah ada, lakukan update
        $sql = "UPDATE tb_luas_wilayah_desa
                SET luas_wilayah_desa = '$luas_wilayah_desa',
                    tahun = '$tahun'
                WHERE user_id = '$user_id'
                  AND desa_id = '$desa_id'
                  AND tahun = '$tahun'";
    } else {
        // Jika belum ada, insert data baru
        $sql = "INSERT INTO tb_luas_wilayah_desa (
                    luas_wilayah_desa, 
                    tahun, 
                    user_id, 
                    desa_id
                ) VALUES (
                    '$luas_wilayah_desa', 
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
                             AND form_name = 'Luas Wilayah Desa/Kelurahan'
                             AND tahun = '$tahun'";
        $result_progress = mysqli_query($conn, $query_progress);

        if (!$result_progress) {
            $error_message = "Terjadi kesalahan saat memeriksa progress: " . mysqli_error($conn);
            header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($error_message));
            exit();
        }

        $created_at = $tahun . '-01-01 00:00:00';

        if (mysqli_num_rows($result_progress) > 0) {
            // Update progress jika sudah ada
            $update_progress = "UPDATE user_progress
                                SET is_locked = TRUE,
                                    desa_id = '$desa_id',
                                    created_at = '$created_at',
                                    tahun = '$tahun'
                                WHERE user_id = '$user_id'
                                  AND form_name = 'Luas Wilayah Desa/Kelurahan'
                                  AND tahun = '$tahun'";
            if (!mysqli_query($conn, $update_progress)) {
                $error_message = "Terjadi kesalahan saat memperbarui progress: " . mysqli_error($conn);
                header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($error_message));
                exit();
            }
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
                                    'Luas Wilayah Desa/Kelurahan',
                                    TRUE,
                                    '$desa_id',
                                    '$created_at',
                                    '$tahun'
                                )";
            if (!mysqli_query($conn, $insert_progress)) {
                $error_message = "Terjadi kesalahan saat menambahkan progress: " . mysqli_error($conn);
                header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($error_message));
                exit();
            }
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
