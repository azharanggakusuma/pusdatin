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
    $pmi_bekerja = mysqli_real_escape_string($conn, $_POST['pmi_bekerja'] ?? '');
    $agen_pengerahan_pmi = mysqli_real_escape_string($conn, $_POST['agen_pengerahan_pmi'] ?? '');
    $layanan_rekomendasi_pmi = mysqli_real_escape_string($conn, $_POST['layanan_rekomendasi_pmi'] ?? '');
    $keberadaan_wna = mysqli_real_escape_string($conn, $_POST['keberadaan_wna'] ?? '');

    // ============================
    // Bagian VALIDASI DASAR
    // ============================

    $errors = [];

    // 1) Validasi pmi_bekerja
    $allowed_pmi = ['Ada', 'Tidak Ada'];
    if (empty($pmi_bekerja) || !in_array($pmi_bekerja, $allowed_pmi)) {
        $errors[] = "Anda harus memilih Keberadaan Warga yang Bekerja sebagai PMI/TKI.";
    }

    // 2) Validasi agen_pengerahan_pmi
    $allowed_agen = ['Ada', 'Tidak Ada'];
    if (empty($agen_pengerahan_pmi) || !in_array($agen_pengerahan_pmi, $allowed_agen)) {
        $errors[] = "Anda harus memilih Keberadaan Agen Pengerahan PMI/TKI.";
    }

    // 3) Validasi layanan_rekomendasi_pmi
    $allowed_layanan = ['Ada', 'Tidak Ada'];
    if (empty($layanan_rekomendasi_pmi) || !in_array($layanan_rekomendasi_pmi, $allowed_layanan)) {
        $errors[] = "Anda harus memilih Keberadaan Layanan Rekomendasi PMI/TKI.";
    }

    // 4) Validasi keberadaan_wna
    $allowed_wna = ['Ada', 'Tidak Ada'];
    if (empty($keberadaan_wna) || !in_array($keberadaan_wna, $allowed_wna)) {
        $errors[] = "Anda harus memilih Keberadaan WNA di Desa/Kelurahan.";
    }

    // Jika ada error, redirect dengan pesan error
    if (!empty($errors)) {
        $message = implode(" ", $errors);
        header("Location: ../pages/forms/kependudukan_dan_ketenagakerjaan.php?status=error&message=" . urlencode($message));
        exit();
    }

    // Cek apakah data untuk tahun yang sama sudah ada di db
    $check_query = "SELECT id 
                    FROM tb_ketenagakerjaan 
                    WHERE user_id = '$user_id' 
                      AND desa_id = '$desa_id' 
                      AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (!$check_result) {
        // Jika query cek gagal
        $error_message = "Terjadi kesalahan saat memeriksa data: " . mysqli_error($conn);
        header("Location: ../pages/forms/kependudukan_dan_ketenagakerjaan.php?status=error&message=" . urlencode($error_message));
        exit();
    }

    if (mysqli_num_rows($check_result) > 0) {
        // Jika sudah ada, lakukan update
        $sql = "UPDATE tb_ketenagakerjaan
                SET 
                    pmi_bekerja = '$pmi_bekerja',
                    agen_pengerahan_pmi = '$agen_pengerahan_pmi',
                    layanan_rekomendasi_pmi = '$layanan_rekomendasi_pmi',
                    keberadaan_wna = '$keberadaan_wna',
                    tahun = '$tahun'
                WHERE user_id = '$user_id'
                  AND desa_id = '$desa_id'
                  AND tahun = '$tahun'";
    } else {
        // Jika belum ada, insert data baru
        $sql = "INSERT INTO tb_ketenagakerjaan (
                    pmi_bekerja, 
                    agen_pengerahan_pmi, 
                    layanan_rekomendasi_pmi, 
                    keberadaan_wna, 
                    tahun, 
                    user_id, 
                    desa_id
                ) VALUES (
                    '$pmi_bekerja', 
                    '$agen_pengerahan_pmi', 
                    '$layanan_rekomendasi_pmi', 
                    '$keberadaan_wna', 
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
                             AND form_name = 'Ketenagakerjaan'
                             AND tahun = '$tahun'";
        $result_progress = mysqli_query($conn, $query_progress);

        if (!$result_progress) {
            $error_message = "Terjadi kesalahan saat memeriksa progress: " . mysqli_error($conn);
            header("Location: ../pages/forms/kependudukan_dan_ketenagakerjaan.php?status=error&message=" . urlencode($error_message));
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
                                  AND form_name = 'Ketenagakerjaan'
                                  AND tahun = '$tahun'";
            if (!mysqli_query($conn, $update_progress)) {
                $error_message = "Terjadi kesalahan saat memperbarui progress: " . mysqli_error($conn);
                header("Location: ../pages/forms/kependudukan_dan_ketenagakerjaan.php?status=error&message=" . urlencode($error_message));
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
                                    'Ketenagakerjaan',
                                    TRUE,
                                    '$desa_id',
                                    '$created_at',
                                    '$tahun'
                                )";
            if (!mysqli_query($conn, $insert_progress)) {
                $error_message = "Terjadi kesalahan saat menambahkan progress: " . mysqli_error($conn);
                header("Location: ../pages/forms/kependudukan_dan_ketenagakerjaan.php?status=error&message=" . urlencode($error_message));
                exit();
            }
        }

        // Sukses simpan
        header("Location: ../pages/forms/kependudukan_dan_ketenagakerjaan.php?status=success");
        exit();
    } else {
        // Gagal eksekusi query
        $error_message = "Terjadi kesalahan saat menyimpan data: " . mysqli_error($conn);
        header("Location: ../pages/forms/kependudukan_dan_ketenagakerjaan.php?status=error&message=" . urlencode($error_message));
        exit();
    }
} else {
    // Jika bukan method POST
    header("Location: ../pages/forms/kependudukan_dan_ketenagakerjaan.php?status=warning");
    exit();
}
?>
