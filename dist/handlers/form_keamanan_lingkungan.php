<?php
session_start();
include "../config/conn.php";

// ============================
// Mengambil ID Pengguna dan Tahun dari Session
// ============================
$username = $_SESSION['username'] ?? '';
$tahun = $_SESSION['tahun'] ?? null;

if (!$tahun || !$username) {
    echo "Tahun atau pengguna tidak ditemukan. Pastikan Anda telah login.";
    exit();
}

// ============================
// Mengambil ID Pengguna dan ID Desa
// ============================
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ============================
    // Sanitasi dan Persiapan Data dari POST
    // ============================
    $data = [
        'pembangunan_pos_keamanan' => mysqli_real_escape_string($conn, $_POST['pembangunan_pos_keamanan']),
        'pembentukan_regu_keamanan' => mysqli_real_escape_string($conn, $_POST['pembentukan_regu_keamanan']),
        'penambahan_anggota_hansip' => mysqli_real_escape_string($conn, $_POST['penambahan_anggota_hansip']),
        'pelaporan_tamu_menginap' => mysqli_real_escape_string($conn, $_POST['pelaporan_tamu_menginap']),
        'pengaktifan_sistem_keamanan' => mysqli_real_escape_string($conn, $_POST['pengaktifan_sistem_keamanan']),
    ];

    // ============================
    // Cek apakah data untuk tahun yang sama sudah ada di database
    // ============================
    $check_query = "SELECT id FROM tb_keamanan_lingkungan WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Jika data sudah ada, lakukan UPDATE
        $sql = "UPDATE tb_keamanan_lingkungan SET 
            pembangunan_pos_keamanan = '{$data['pembangunan_pos_keamanan']}',
            pembentukan_regu_keamanan = '{$data['pembentukan_regu_keamanan']}',
            penambahan_anggota_hansip = '{$data['penambahan_anggota_hansip']}',
            pelaporan_tamu_menginap = '{$data['pelaporan_tamu_menginap']}',
            pengaktifan_sistem_keamanan = '{$data['pengaktifan_sistem_keamanan']}'
            WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // Jika data belum ada, lakukan INSERT
        $sql = "INSERT INTO tb_keamanan_lingkungan (
            pembangunan_pos_keamanan, pembentukan_regu_keamanan, penambahan_anggota_hansip,
            pelaporan_tamu_menginap, pengaktifan_sistem_keamanan, tahun, user_id, desa_id
        ) VALUES (
            '{$data['pembangunan_pos_keamanan']}', '{$data['pembentukan_regu_keamanan']}', '{$data['penambahan_anggota_hansip']}',
            '{$data['pelaporan_tamu_menginap']}', '{$data['pengaktifan_sistem_keamanan']}', '$tahun', '$user_id', '$desa_id'
        )";
    }

    // ============================
    // Eksekusi Query
    // ============================
    if (mysqli_query($conn, $sql)) {
        // ============================
        // Kelola Progress Pengguna
        // ============================
        $form_name = 'Keamanan Lingkungan';
        $query_progress = "SELECT id FROM user_progress WHERE user_id = '$user_id' AND form_name = '$form_name' AND tahun = '$tahun'";
        $result_progress = mysqli_query($conn, $query_progress);

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
                header("Location: ../pages/forms/keamanan.php?status=error&message=" . urlencode(mysqli_error($conn)));
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
                header("Location: ../pages/forms/keamanan.php?status=error&message=" . urlencode(mysqli_error($conn)));
                exit();
            }
        }

        // Redirect ke halaman form dengan status sukses
        header("Location: ../pages/forms/keamanan.php?status=success");
        exit();
    } else {
        // Jika eksekusi query gagal, redirect dengan pesan error
        header("Location: ../pages/forms/keamanan.php?status=error&message=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    // Jika bukan metode POST, redirect dengan status warning
    header("Location: ../pages/forms/keamanan.php?status=warning");
    exit();
}
?>