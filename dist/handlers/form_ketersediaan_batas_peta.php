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
    $penetapan_batas_desa   = mysqli_real_escape_string($conn, $_POST['penetapan_batas_desa'] ?? '');
    $no_surat_batas_desa    = !empty($_POST['no_surat_batas_desa']) ? mysqli_real_escape_string($conn, $_POST['no_surat_batas_desa']) : NULL;
    $ketersediaan_peta_desa = mysqli_real_escape_string($conn, $_POST['ketersediaan_peta_desa'] ?? '');
    $no_surat_peta_desa     = !empty($_POST['no_surat_peta_desa']) ? mysqli_real_escape_string($conn, $_POST['no_surat_peta_desa']) : NULL;

    // ============================
    // VALIDASI DASAR
    // ============================

    // 1) Pastikan field 'penetapan_batas_desa' dan 'ketersediaan_peta_desa' diisi
    if (empty($penetapan_batas_desa) || empty($ketersediaan_peta_desa)) {
        $message = "Semua kolom wajib diisi.";
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
        exit();
    }

    // 2) (Opsional) Tambahan validasi: pastikan value sesuai dengan pilihan yang diizinkan
    // Misalnya, jika 'penetapan_batas_desa' dan 'ketersediaan_peta_desa' memiliki pilihan tertentu
    $allowed_penetapan = ["Ya", "Tidak"];
    $allowed_ketersediaan = ["Ada", "Tidak Ada"];

    if (!in_array($penetapan_batas_desa, $allowed_penetapan)) {
        $message = "Pilihan Penetapan Batas Desa tidak valid.";
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
        exit();
    }

    if (!in_array($ketersediaan_peta_desa, $allowed_ketersediaan)) {
        $message = "Pilihan Ketersediaan Peta Desa tidak valid.";
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($message));
        exit();
    }

    // ============================
    // Menambahkan atau Memperbarui Data di Database
    // ============================

    // Cek apakah data untuk tahun yang sama sudah ada di database
    $check_query = "SELECT id FROM tb_ketersediaan_batas_peta WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (!$check_result) {
        $error_message = "Terjadi kesalahan saat memeriksa data: " . mysqli_error($conn);
        header("Location: ../pages/forms/keterangan_umum_desa_kelurahan.php?status=error&message=" . urlencode($error_message));
        exit();
    }

    if (mysqli_num_rows($check_result) > 0) {
        // Jika data sudah ada, lakukan UPDATE
        $sql = "UPDATE tb_ketersediaan_batas_peta
                SET 
                    penetapan_batas_desa = '$penetapan_batas_desa',
                    no_surat_batas_desa = '$no_surat_batas_desa',
                    ketersediaan_peta_desa = '$ketersediaan_peta_desa',
                    no_surat_peta_desa = '$no_surat_peta_desa'
                WHERE 
                    user_id = '$user_id' AND 
                    desa_id = '$desa_id' AND 
                    tahun = '$tahun'";
    } else {
        // Jika data belum ada, lakukan INSERT
        $sql = "INSERT INTO tb_ketersediaan_batas_peta (
                    penetapan_batas_desa, 
                    no_surat_batas_desa, 
                    ketersediaan_peta_desa, 
                    no_surat_peta_desa, 
                    tahun, 
                    user_id, 
                    desa_id
                ) VALUES (
                    '$penetapan_batas_desa', 
                    '$no_surat_batas_desa', 
                    '$ketersediaan_peta_desa', 
                    '$no_surat_peta_desa', 
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
        $form_name = 'Batas desa/kelurahan yang ditetapkan dalam Peraturan Bupati/Walikota atau Gubernur';
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
