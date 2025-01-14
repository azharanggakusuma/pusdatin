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
    $keberadaan_kantor = mysqli_real_escape_string($conn, $_POST['keberadaan_kantor'] ?? '');
    $status_kantor = mysqli_real_escape_string($conn, $_POST['status_kantor'] ?? '');
    $kondisi_kantor = mysqli_real_escape_string($conn, $_POST['kondisi_kantor'] ?? '');
    $lokasi_kantor = mysqli_real_escape_string($conn, $_POST['lokasi_kantor'] ?? '');

    // ============================
    // Bagian VALIDASI DASAR
    // ============================

    $errors = [];

    // 1) Validasi keberadaan_kantor
    $allowed_keberadaan = ['ADA', 'TIDAK ADA'];
    if (empty($keberadaan_kantor) || !in_array($keberadaan_kantor, $allowed_keberadaan)) {
        $errors[] = "Anda harus memilih Keberadaan Kantor Kepala Desa/Lurah.";
    }

    // 2) Validasi status_kantor
    $allowed_status = ['ASET DESA', 'BUKAN ASET DESA'];
    if (empty($status_kantor) || !in_array($status_kantor, $allowed_status)) {
        $errors[] = "Anda harus memilih Status Kantor Kepala Desa/Lurah.";
    }

    // 3) Validasi kondisi_kantor
    $allowed_kondisi = ['ADA, LAYAK', 'ADA, TIDAK LAYAK', 'TIDAK ADA'];
    if (empty($kondisi_kantor) || !in_array($kondisi_kantor, $allowed_kondisi)) {
        $errors[] = "Anda harus memilih Kondisi Kantor Kepala Desa/Balai Desa.";
    }

    // 4) Validasi lokasi_kantor
    $allowed_lokasi = ['Di dalam wilayah desa/kelurahan', 'Di Luar Wilayah Desa/Kelurahan'];
    if (empty($lokasi_kantor) || !in_array($lokasi_kantor, $allowed_lokasi)) {
        $errors[] = "Anda harus memilih Lokasi Kantor Kepala Desa/Lurah.";
    }

    // Jika ada error, redirect dengan pesan error
    if (!empty($errors)) {
        $message = implode(" ", $errors);
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
        exit();
    }

    // Cek apakah data sudah ada di db untuk tahun yang sama
    $check_query = "SELECT id 
                    FROM tb_kepemilikan_kantor 
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
        $sql = "UPDATE tb_kepemilikan_kantor
                SET 
                    keberadaan_kantor = '$keberadaan_kantor',
                    status_kantor = '$status_kantor',
                    kondisi_kantor = '$kondisi_kantor',
                    lokasi_kantor = '$lokasi_kantor',
                    tahun = '$tahun'
                WHERE user_id = '$user_id'
                  AND desa_id = '$desa_id'
                  AND tahun = '$tahun'";
    } else {
        // Jika belum ada, insert data baru
        $sql = "INSERT INTO tb_kepemilikan_kantor (
                    keberadaan_kantor, 
                    status_kantor, 
                    kondisi_kantor, 
                    lokasi_kantor, 
                    tahun, 
                    user_id, 
                    desa_id
                ) VALUES (
                    '$keberadaan_kantor', 
                    '$status_kantor', 
                    '$kondisi_kantor', 
                    '$lokasi_kantor', 
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
                             AND form_name = 'Keberadaan, Status, Kondisi, dan Lokasi Kantor Kepala Desa/Lurah'
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
                                SET 
                                    is_locked = TRUE,
                                    desa_id = '$desa_id',
                                    created_at = '$created_at',
                                    tahun = '$tahun'
                                WHERE user_id = '$user_id'
                                  AND form_name = 'Keberadaan, Status, Kondisi, dan Lokasi Kantor Kepala Desa/Lurah'
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
                                    'Keberadaan, Status, Kondisi, dan Lokasi Kantor Kepala Desa/Lurah',
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
