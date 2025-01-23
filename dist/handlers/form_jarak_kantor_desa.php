<?php
include '../config/conn.php';
session_start();

// ============================
// Mengambil ID Pengguna dari Session
// ============================
$username = $_SESSION['username'] ?? '';
if (empty($username)) {
    echo "Username tidak ditemukan dalam session. Pastikan Anda telah login.";
    exit();
}

$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);

if (!$result_user) {
    echo "Terjadi kesalahan saat mengambil data pengguna: " . mysqli_error($conn);
    exit();
}

$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

if ($user_id === 0) {
    echo "ID pengguna tidak ditemukan. Pastikan username yang valid.";
    exit();
}

// ============================
// Mengambil Tahun dari Session
// ============================
$tahun = $_SESSION['tahun'] ?? null;

if (!$tahun) {
    echo "Tahun tidak ditemukan. Pastikan Anda telah login dengan memilih tahun.";
    exit();
}

// ============================
// Mengambil ID Desa terkait Pengguna
// ============================
$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);

if (!$result_desa) {
    echo "Terjadi kesalahan saat mengambil data desa: " . mysqli_error($conn);
    exit();
}

$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($desa_id === 0) {
    echo "ID desa tidak ditemukan untuk pengguna ini.";
    exit();
}

// ============================
// Proses Jika Metode Request adalah POST
// ============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ============================
    // Sanitasi dan Persiapan Data dari POST
    // ============================
    $jarak_ke_ibukota_kecamatan = mysqli_real_escape_string($conn, $_POST['jarak_ke_ibukota_kecamatan'] ?? '');
    $jarak_ke_ibukota_kabupaten = mysqli_real_escape_string($conn, $_POST['jarak_ke_ibukota_kabupaten'] ?? '');

    // ============================
    // VALIDASI DASAR
    // ============================

    // 1) Pastikan kedua field terisi
    if (empty($jarak_ke_ibukota_kecamatan) || empty($jarak_ke_ibukota_kabupaten)) {
        $message = "Semua kolom jarak harus diisi.";
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
        exit();
    }

    // 2) Pastikan keduanya berupa angka (numerik)
    if (!is_numeric($jarak_ke_ibukota_kecamatan) || !is_numeric($jarak_ke_ibukota_kabupaten)) {
        $message = "Input jarak harus berupa angka. Gunakan titik (.) untuk desimal.";
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
        exit();
    }

    // ============================
    // Menambahkan atau Memperbarui Data di Database
    // ============================
    // Cek apakah data sudah ada untuk tahun dan desa yang sama
    $check_query = "SELECT id FROM tb_jarak_kantor_desa WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (!$check_result) {
        $error_message = "Terjadi kesalahan saat memeriksa data: " . mysqli_error($conn);
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($error_message));
        exit();
    }

    if (mysqli_num_rows($check_result) > 0) {
        // Jika data sudah ada, lakukan UPDATE
        $sql = "UPDATE tb_jarak_kantor_desa
                SET 
                    jarak_ke_ibukota_kecamatan = '$jarak_ke_ibukota_kecamatan',
                    jarak_ke_ibukota_kabupaten = '$jarak_ke_ibukota_kabupaten',
                    tahun = '$tahun'
                WHERE 
                    user_id = '$user_id' AND 
                    desa_id = '$desa_id' AND 
                    tahun = '$tahun'";
    } else {
        // Jika data belum ada, lakukan INSERT
        $sql = "INSERT INTO tb_jarak_kantor_desa (
                    jarak_ke_ibukota_kecamatan, 
                    jarak_ke_ibukota_kabupaten, 
                    tahun, 
                    user_id, 
                    desa_id
                ) VALUES (
                    '$jarak_ke_ibukota_kecamatan', 
                    '$jarak_ke_ibukota_kabupaten', 
                    '$tahun', 
                    '$user_id', 
                    '$desa_id'
                )";
    }

    // Eksekusi Query
    if (mysqli_query($conn, $sql)) {
        // ============================
        // Kelola Progress Pengguna
        // ============================
        $form_name = 'Jarak Kantor Desa ke Ibukota Kecamatan dan Ibukota Kabupaten/Kota';
        $query_progress = "SELECT id FROM user_progress WHERE user_id = '$user_id' AND form_name = '$form_name' AND tahun = '$tahun'";
        $result_progress = mysqli_query($conn, $query_progress);

        if (!$result_progress) {
            $error_message = "Terjadi kesalahan saat memeriksa progress pengguna: " . mysqli_error($conn);
            header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($error_message));
            exit();
        }

        // Set created_at ke hari pertama tahun tersebut
        $created_at = "$tahun-01-01 00:00:00";

        if (mysqli_num_rows($result_progress) > 0) {
            // Jika progress sudah ada, lakukan UPDATE
            $update_progress = "UPDATE user_progress 
                                SET 
                                    is_locked  = TRUE, 
                                    desa_id    = '$desa_id', 
                                    created_at = '$created_at', 
                                    tahun      = '$tahun' 
                                WHERE 
                                    user_id    = '$user_id' AND 
                                    form_name  = '$form_name' AND 
                                    tahun      = '$tahun'";
            if (!mysqli_query($conn, $update_progress)) {
                $error_message = "Terjadi kesalahan saat memperbarui progress pengguna: " . mysqli_error($conn);
                header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($error_message));
                exit();
            }
        } else {
            // Jika progress belum ada, lakukan INSERT
            $insert_progress = "INSERT INTO user_progress (
                                    user_id, 
                                    form_name, 
                                    is_locked, 
                                    desa_id, 
                                    created_at, 
                                    tahun
                                ) VALUES (
                                    '$user_id',
                                    '$form_name',
                                    TRUE,
                                    '$desa_id',
                                    '$created_at',
                                    '$tahun'
                                )";
            if (!mysqli_query($conn, $insert_progress)) {
                $error_message = "Terjadi kesalahan saat menambahkan progress pengguna: " . mysqli_error($conn);
                header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($error_message));
                exit();
            }
        }

        // Redirect ke halaman form dengan status sukses
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=success");
        exit();
    } else {
        // Jika eksekusi query gagal, redirect dengan pesan error
        $error_message = "Terjadi kesalahan saat menyimpan data: " . mysqli_error($conn);
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($error_message));
        exit();
    }
} else {
    // Jika bukan metode POST, redirect dengan status warning
    header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=warning");
    exit();
}
