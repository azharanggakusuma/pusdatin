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
    // Validasi: Pastikan tahun ada di session
    echo "Tahun tidak ditemukan. Pastikan Anda telah login dengan memilih tahun.";
    exit();
}

// Ambil desa_id yang terkait dengan user
$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

// Hanya proses jika request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize dan siapkan data dari POST
    $jarak_ke_ibukota_kecamatan = mysqli_real_escape_string($conn, $_POST['jarak_ke_ibukota_kecamatan'] ?? '');
    $jarak_ke_ibukota_kabupaten = mysqli_real_escape_string($conn, $_POST['jarak_ke_ibukota_kabupaten'] ?? '');

    // ============================
    // Bagian VALIDASI DASAR
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

    // Cek apakah data sudah pernah diinput untuk tahun yang sama
    $check_query = "SELECT id 
                    FROM tb_jarak_kantor_desa 
                    WHERE user_id = '$user_id' 
                      AND desa_id = '$desa_id' 
                      AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Jika sudah ada, lakukan update
        $sql = "UPDATE tb_jarak_kantor_desa
                SET jarak_ke_ibukota_kecamatan = '$jarak_ke_ibukota_kecamatan',
                    jarak_ke_ibukota_kabupaten = '$jarak_ke_ibukota_kabupaten',
                    tahun = '$tahun'
                WHERE user_id = '$user_id'
                  AND desa_id = '$desa_id'
                  AND tahun = '$tahun'";
    } else {
        // Jika belum ada, lakukan insert
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

    if (mysqli_query($conn, $sql)) {
        // Kelola progress pengisian form user
        $query_progress = "SELECT id 
                           FROM user_progress 
                           WHERE user_id = '$user_id' 
                             AND form_name = 'Jarak Kantor Desa'
                             AND tahun = '$tahun'";
        $result_progress = mysqli_query($conn, $query_progress);

        // Set created_at ke 1 Januari tahun terpilih
        $created_at = $tahun . '-01-01 00:00:00';

        if (mysqli_num_rows($result_progress) > 0) {
            // Update progress jika sudah ada
            $update_progress = "UPDATE user_progress
                                SET is_locked = TRUE,
                                    desa_id = '$desa_id',
                                    created_at = '$created_at',
                                    tahun = '$tahun'
                                WHERE user_id = '$user_id'
                                  AND form_name = 'Jarak Kantor Desa'
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
                                    'Jarak Kantor Desa', 
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
        // Jika gagal query
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
