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
        'kelompok_pertokoan_jumlah' => (int)$_POST['kelompok_pertokoan_jumlah'],
        'kelompok_pertokoan_kemudahan' => mysqli_real_escape_string($conn, $_POST['kelompok_pertokoan_kemudahan']),
        'pasar_permanen_jumlah' => (int)$_POST['pasar_permanen_jumlah'],
        'pasar_permanen_kemudahan' => mysqli_real_escape_string($conn, $_POST['pasar_permanen_kemudahan']),
        'pasar_semi_permanen_jumlah' => (int)$_POST['pasar_semi_permanen_jumlah'],
        'pasar_semi_permanen_kemudahan' => mysqli_real_escape_string($conn, $_POST['pasar_semi_permanen_kemudahan']),
        'pasar_tanpa_bangunan_jumlah' => (int)$_POST['pasar_tanpa_bangunan_jumlah'],
        'pasar_tanpa_bangunan_kemudahan' => mysqli_real_escape_string($conn, $_POST['pasar_tanpa_bangunan_kemudahan']),
        'minimarket_jumlah' => (int)$_POST['minimarket_jumlah'],
        'minimarket_kemudahan' => mysqli_real_escape_string($conn, $_POST['minimarket_kemudahan']),
        'restoran_jumlah' => (int)$_POST['restoran_jumlah'],
        'restoran_kemudahan' => mysqli_real_escape_string($conn, $_POST['restoran_kemudahan']),
        'warung_makan_jumlah' => (int)$_POST['warung_makan_jumlah'],
        'warung_makan_kemudahan' => mysqli_real_escape_string($conn, $_POST['warung_makan_kemudahan']),
        'toko_kelontong_jumlah' => (int)$_POST['toko_kelontong_jumlah'],
        'toko_kelontong_kemudahan' => mysqli_real_escape_string($conn, $_POST['toko_kelontong_kemudahan']),
        'hotel_jumlah' => (int)$_POST['hotel_jumlah'],
        'hotel_kemudahan' => mysqli_real_escape_string($conn, $_POST['hotel_kemudahan']),
        'penginapan_jumlah' => (int)$_POST['penginapan_jumlah'],
        'penginapan_kemudahan' => mysqli_real_escape_string($conn, $_POST['penginapan_kemudahan']),
    ];

    // ============================
    // Cek apakah data untuk tahun yang sama sudah ada di database
    // ============================
    $check_query = "SELECT id FROM tb_sarana_prasarana WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Jika data sudah ada, lakukan UPDATE
        $sql = "UPDATE tb_sarana_prasarana SET 
            kelompok_pertokoan_jumlah = '{$data['kelompok_pertokoan_jumlah']}', 
            kelompok_pertokoan_kemudahan = '{$data['kelompok_pertokoan_kemudahan']}',
            pasar_permanen_jumlah = '{$data['pasar_permanen_jumlah']}', 
            pasar_permanen_kemudahan = '{$data['pasar_permanen_kemudahan']}',
            pasar_semi_permanen_jumlah = '{$data['pasar_semi_permanen_jumlah']}', 
            pasar_semi_permanen_kemudahan = '{$data['pasar_semi_permanen_kemudahan']}',
            pasar_tanpa_bangunan_jumlah = '{$data['pasar_tanpa_bangunan_jumlah']}', 
            pasar_tanpa_bangunan_kemudahan = '{$data['pasar_tanpa_bangunan_kemudahan']}',
            minimarket_jumlah = '{$data['minimarket_jumlah']}', 
            minimarket_kemudahan = '{$data['minimarket_kemudahan']}',
            restoran_jumlah = '{$data['restoran_jumlah']}', 
            restoran_kemudahan = '{$data['restoran_kemudahan']}',
            warung_makan_jumlah = '{$data['warung_makan_jumlah']}', 
            warung_makan_kemudahan = '{$data['warung_makan_kemudahan']}',
            toko_kelontong_jumlah = '{$data['toko_kelontong_jumlah']}', 
            toko_kelontong_kemudahan = '{$data['toko_kelontong_kemudahan']}',
            hotel_jumlah = '{$data['hotel_jumlah']}', 
            hotel_kemudahan = '{$data['hotel_kemudahan']}',
            penginapan_jumlah = '{$data['penginapan_jumlah']}', 
            penginapan_kemudahan = '{$data['penginapan_kemudahan']}'
            WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // Jika data belum ada, lakukan INSERT
        $sql = "INSERT INTO tb_sarana_prasarana (
            kelompok_pertokoan_jumlah, kelompok_pertokoan_kemudahan,
            pasar_permanen_jumlah, pasar_permanen_kemudahan,
            pasar_semi_permanen_jumlah, pasar_semi_permanen_kemudahan,
            pasar_tanpa_bangunan_jumlah, pasar_tanpa_bangunan_kemudahan,
            minimarket_jumlah, minimarket_kemudahan,
            restoran_jumlah, restoran_kemudahan,
            warung_makan_jumlah, warung_makan_kemudahan,
            toko_kelontong_jumlah, toko_kelontong_kemudahan,
            hotel_jumlah, hotel_kemudahan,
            penginapan_jumlah, penginapan_kemudahan,
            tahun, user_id, desa_id
        ) VALUES (
            '{$data['kelompok_pertokoan_jumlah']}', '{$data['kelompok_pertokoan_kemudahan']}',
            '{$data['pasar_permanen_jumlah']}', '{$data['pasar_permanen_kemudahan']}',
            '{$data['pasar_semi_permanen_jumlah']}', '{$data['pasar_semi_permanen_kemudahan']}',
            '{$data['pasar_tanpa_bangunan_jumlah']}', '{$data['pasar_tanpa_bangunan_kemudahan']}',
            '{$data['minimarket_jumlah']}', '{$data['minimarket_kemudahan']}',
            '{$data['restoran_jumlah']}', '{$data['restoran_kemudahan']}',
            '{$data['warung_makan_jumlah']}', '{$data['warung_makan_kemudahan']}',
            '{$data['toko_kelontong_jumlah']}', '{$data['toko_kelontong_kemudahan']}',
            '{$data['hotel_jumlah']}', '{$data['hotel_kemudahan']}',
            '{$data['penginapan_jumlah']}', '{$data['penginapan_kemudahan']}',
            '$tahun', '$user_id', '$desa_id'
        )";
    }

    // ============================
    // Eksekusi Query
    // ============================
    if (mysqli_query($conn, $sql)) {
        // ============================
        // Kelola Progress Pengguna
        // ============================
        $form_name = 'Sarana Prasarana';
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
                header("Location: ../pages/forms/ekonomi.php?status=error&message=" . urlencode(mysqli_error($conn)));
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
                header("Location: ../pages/forms/ekonomi.php?status=error&message=" . urlencode(mysqli_error($conn)));
                exit();
            }
        }

        // Redirect ke halaman form dengan status sukses
        header("Location: ../pages/forms/ekonomi.php?status=success");
        exit();
    } else {
        // Jika eksekusi query gagal, redirect dengan pesan error
        header("Location: ../pages/forms/ekonomi.php?status=error&message=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    // Jika bukan metode POST, redirect dengan status warning
    header("Location: ../pages/forms/ekonomi.php?status=warning");
    exit();
}
?>