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
    $lalu_lintas = mysqli_real_escape_string($conn, $_POST['lalu_lintas'] ?? '');
    $jenis_permukaan_jalan = mysqli_real_escape_string($conn, $_POST['jenis_permukaan_jalan'] ?? '');
    $jalan_darat_bisa_dilalui = mysqli_real_escape_string($conn, $_POST['jalan_darat_bisa_dilalui'] ?? '');
    $keberadaan_angkutan_umum = mysqli_real_escape_string($conn, $_POST['keberadaan_angkutan_umum'] ?? '');
    $operasional_angkutan_umum = mysqli_real_escape_string($conn, $_POST['operasional_angkutan_umum'] ?? '');
    $jam_operasi_angkutan_umum = mysqli_real_escape_string($conn, $_POST['jam_operasi_angkutan_umum'] ?? '');

    // ============================
    // Bagian VALIDASI DASAR
    // ============================

    $errors = [];

    // 1) Validasi lalu_lintas
    $allowed_lalu_lintas = ['Aspal/Beton', 'Diperkeras (kerikil, batu, dll.)', 'Tanah', 'Lainnya'];
    if (empty($lalu_lintas) || !in_array($lalu_lintas, $allowed_lalu_lintas)) {
        $errors[] = "Anda harus memilih jenis lalu lintas dari/ke desa/kelurahan.";
    }

    // 2) Validasi jenis_permukaan_jalan
    $allowed_jenis_permukaan = ['Sepanjang tahun', 'Sepanjang tahun kecuali saat tertentu (ketika turun hujan, pasang, dll.)', 'Selama musim kemarau', 'Tidak dapat dilalui sepanjang tahun'];
    if (empty($jenis_permukaan_jalan) || !in_array($jenis_permukaan_jalan, $allowed_jenis_permukaan)) {
        $errors[] = "Anda harus memilih jenis permukaan jalan darat yang terluas.";
    }

    // 3) Validasi jalan_darat_bisa_dilalui
    $allowed_jalan_darat = ['Sepanjang tahun', 'Sepanjang tahun kecuali saat tertentu (ketika turun hujan, pasang, dll.)', 'Selama musim kemarau', 'Tidak dapat dilalui sepanjang tahun'];
    if (empty($jalan_darat_bisa_dilalui) || !in_array($jalan_darat_bisa_dilalui, $allowed_jalan_darat)) {
        $errors[] = "Anda harus memilih kemampuan jalan darat untuk dilalui kendaraan bermotor roda 4 atau lebih.";
    }

    // 4) Validasi keberadaan_angkutan_umum
    $allowed_angkutan_umum = ['Ada, dengan trayek tetap', 'Ada, tanpa trayek tetap', 'Tidak ada angkutan umum'];
    if (empty($keberadaan_angkutan_umum) || !in_array($keberadaan_angkutan_umum, $allowed_angkutan_umum)) {
        $errors[] = "Anda harus memilih keberadaan angkutan umum.";
    }

    // 5) Validasi operasional_angkutan_umum
    $allowed_operasional = ['Setiap hari', 'Tidak setiap hari'];
    if (empty($operasional_angkutan_umum) || !in_array($operasional_angkutan_umum, $allowed_operasional)) {
        $errors[] = "Anda harus memilih operasional angkutan umum yang utama.";
    }

    // 6) Validasi jam_operasi_angkutan_umum
    $allowed_jam_operasi = ['Siang dan malam hari', 'Hanya siang/malam hari'];
    if (empty($jam_operasi_angkutan_umum) || !in_array($jam_operasi_angkutan_umum, $allowed_jam_operasi)) {
        $errors[] = "Anda harus memilih jam operasi angkutan umum yang utama.";
    }

    // Jika ada error, redirect dengan pesan error
    if (!empty($errors)) {
        $message = implode(" ", $errors);
        header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=error&message=" . urlencode($message));
        exit();
    }

    // Cek apakah data untuk tahun yang sama sudah ada di db
    $check_query = "SELECT id 
                    FROM tb_prasarana_transportasi 
                    WHERE user_id = '$user_id' 
                      AND desa_id = '$desa_id' 
                      AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (!$check_result) {
        // Jika query cek gagal
        $error_message = "Terjadi kesalahan saat memeriksa data: " . mysqli_error($conn);
        header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=error&message=" . urlencode($error_message));
        exit();
    }

    if (mysqli_num_rows($check_result) > 0) {
        // Jika sudah ada, lakukan update
        $sql = "UPDATE tb_prasarana_transportasi
                SET 
                    lalu_lintas = '$lalu_lintas',
                    jenis_permukaan_jalan = '$jenis_permukaan_jalan',
                    jalan_darat_bisa_dilalui = '$jalan_darat_bisa_dilalui',
                    keberadaan_angkutan_umum = '$keberadaan_angkutan_umum',
                    operasional_angkutan_umum = '$operasional_angkutan_umum',
                    jam_operasi_angkutan_umum = '$jam_operasi_angkutan_umum',
                    tahun = '$tahun'
                WHERE user_id = '$user_id'
                  AND desa_id = '$desa_id'
                  AND tahun = '$tahun'";
    } else {
        // Jika belum ada, insert data baru
        $sql = "INSERT INTO tb_prasarana_transportasi (
                    lalu_lintas, 
                    jenis_permukaan_jalan, 
                    jalan_darat_bisa_dilalui, 
                    keberadaan_angkutan_umum, 
                    operasional_angkutan_umum, 
                    jam_operasi_angkutan_umum, 
                    tahun, 
                    user_id, 
                    desa_id
                ) VALUES (
                    '$lalu_lintas', 
                    '$jenis_permukaan_jalan', 
                    '$jalan_darat_bisa_dilalui', 
                    '$keberadaan_angkutan_umum', 
                    '$operasional_angkutan_umum', 
                    '$jam_operasi_angkutan_umum', 
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
                             AND form_name = 'Prasarana dan Sarana Transportasi Antar Desa/Kelurahan'
                             AND tahun = '$tahun'";
        $result_progress = mysqli_query($conn, $query_progress);

        if (!$result_progress) {
            $error_message = "Terjadi kesalahan saat memeriksa progress: " . mysqli_error($conn);
            header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=error&message=" . urlencode($error_message));
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
                                  AND form_name = 'Prasarana dan Sarana Transportasi Antar Desa/Kelurahan'
                                  AND tahun = '$tahun'";
            if (!mysqli_query($conn, $update_progress)) {
                $error_message = "Terjadi kesalahan saat memperbarui progress: " . mysqli_error($conn);
                header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=error&message=" . urlencode($error_message));
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
                                    'Prasarana dan Sarana Transportasi Antar Desa/Kelurahan',
                                    TRUE,
                                    '$desa_id',
                                    '$created_at',
                                    '$tahun'
                                )";
            if (!mysqli_query($conn, $insert_progress)) {
                $error_message = "Terjadi kesalahan saat menambahkan progress: " . mysqli_error($conn);
                header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=error&message=" . urlencode($error_message));
                exit();
            }
        }

        // Sukses simpan
        header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=success");
        exit();
    } else {
        // Gagal eksekusi query
        $error_message = "Terjadi kesalahan saat menyimpan data: " . mysqli_error($conn);
        header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=error&message=" . urlencode($error_message));
        exit();
    }
} else {
    // Jika bukan method POST
    header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=warning");
    exit();
}
?>
