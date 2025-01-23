<?php
include '../config/conn.php';
session_start();

// ============================
// Mengambil ID Pengguna dari Session
// ============================
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);

if (!$result_user) {
    echo "Terjadi kesalahan saat mengambil data pengguna: " . mysqli_error($conn);
    exit();
}

$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

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

// ============================
// Proses Jika Metode Request adalah POST
// ============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ============================
    // Sanitasi dan Persiapan Data dari POST
    // ============================
    $alamat_website  = mysqli_real_escape_string($conn, $_POST['alamat_website'] ?? '');
    $alamat_email    = mysqli_real_escape_string($conn, $_POST['alamat_email'] ?? '');
    $alamat_facebook = mysqli_real_escape_string($conn, $_POST['alamat_facebook'] ?? '');
    $alamat_twitter  = mysqli_real_escape_string($conn, $_POST['alamat_twitter'] ?? '');
    $alamat_youtube  = mysqli_real_escape_string($conn, $_POST['alamat_youtube'] ?? '');

    // ============================
    // VALIDASI DASAR
    // ============================

    // 1) Validasi Email (jika tidak kosong)
    if (!empty($alamat_email) && !filter_var($alamat_email, FILTER_VALIDATE_EMAIL)) {
        $message = "Alamat email tidak valid.";
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
        exit();
    }

    // 2) Validasi URL (jika tidak kosong)
    //    Cek format URL untuk website, Facebook, Twitter, YouTube
    $urlFields = [
        'Website'  => $alamat_website,
        'Facebook' => $alamat_facebook,
        'Twitter'  => $alamat_twitter,
        'YouTube'  => $alamat_youtube
    ];

    foreach ($urlFields as $fieldName => $value) {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
            $message = "Alamat $fieldName tidak valid. Pastikan menggunakan format URL (http(s)://...)";
            header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
            exit();
        }
    }

    // ============================
    // Menambahkan atau Memperbarui Data di Database
    // ============================
    // Cek apakah data sudah ada untuk tahun dan desa yang sama
    $check_query = "SELECT id FROM tb_website_medsos WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (!$check_result) {
        $error_message = "Terjadi kesalahan saat memeriksa data: " . mysqli_error($conn);
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($error_message));
        exit();
    }

    if (mysqli_num_rows($check_result) > 0) {
        // Jika data sudah ada, lakukan UPDATE
        $sql = "UPDATE tb_website_medsos
                SET 
                    alamat_website  = '$alamat_website',
                    alamat_email    = '$alamat_email',
                    alamat_facebook = '$alamat_facebook',
                    alamat_twitter  = '$alamat_twitter',
                    alamat_youtube  = '$alamat_youtube',
                    tahun           = '$tahun'
                WHERE 
                    user_id = '$user_id' AND 
                    desa_id = '$desa_id' AND 
                    tahun = '$tahun'";
    } else {
        // Jika data belum ada, lakukan INSERT
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

    // Eksekusi Query
    if (mysqli_query($conn, $sql)) {
        // ============================
        // Kelola Progress Pengguna
        // ============================
        $form_name = 'Ketersediaan Alamat website dan media sosial Desa/Kelurahan yang dimiliki';
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
?>
