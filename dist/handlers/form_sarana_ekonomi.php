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
        'bmt_jumlah' => (int)$_POST['bmt_jumlah'],
        'bmt_jarak' => (float)$_POST['bmt_jarak'],
        'bmt_kemudahan' => mysqli_real_escape_string($conn, $_POST['bmt_kemudahan']),
        'atm_jumlah' => (int)$_POST['atm_jumlah'],
        'atm_jarak' => (float)$_POST['atm_jarak'],
        'atm_kemudahan' => mysqli_real_escape_string($conn, $_POST['atm_kemudahan']),
        'agen_bank_jumlah' => (int)$_POST['agen_bank_jumlah'],
        'agen_bank_jarak' => (float)$_POST['agen_bank_jarak'],
        'agen_bank_kemudahan' => mysqli_real_escape_string($conn, $_POST['agen_bank_kemudahan']),
        'valas_jumlah' => (int)$_POST['valas_jumlah'],
        'valas_jarak' => (float)$_POST['valas_jarak'],
        'valas_kemudahan' => mysqli_real_escape_string($conn, $_POST['valas_kemudahan']),
        'pegadaian_jumlah' => (int)$_POST['pegadaian_jumlah'],
        'pegadaian_jarak' => (float)$_POST['pegadaian_jarak'],
        'pegadaian_kemudahan' => mysqli_real_escape_string($conn, $_POST['pegadaian_kemudahan']),
        'agen_tiket_jumlah' => (int)$_POST['agen_tiket_jumlah'],
        'agen_tiket_jarak' => (float)$_POST['agen_tiket_jarak'],
        'agen_tiket_kemudahan' => mysqli_real_escape_string($conn, $_POST['agen_tiket_kemudahan']),
        'bengkel_jumlah' => (int)$_POST['bengkel_jumlah'],
        'bengkel_jarak' => (float)$_POST['bengkel_jarak'],
        'bengkel_kemudahan' => mysqli_real_escape_string($conn, $_POST['bengkel_kemudahan']),
        'salon_jumlah' => (int)$_POST['salon_jumlah'],
        'salon_jarak' => (float)$_POST['salon_jarak'],
        'salon_kemudahan' => mysqli_real_escape_string($conn, $_POST['salon_kemudahan']),
    ];

    // ============================
    // Cek apakah data untuk tahun yang sama sudah ada di database
    // ============================
    $check_query = "SELECT id FROM tb_sarana_ekonomi WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Jika data sudah ada, lakukan UPDATE
        $sql = "UPDATE tb_sarana_ekonomi SET 
            bmt_jumlah = '{$data['bmt_jumlah']}', bmt_jarak = '{$data['bmt_jarak']}', bmt_kemudahan = '{$data['bmt_kemudahan']}',
            atm_jumlah = '{$data['atm_jumlah']}', atm_jarak = '{$data['atm_jarak']}', atm_kemudahan = '{$data['atm_kemudahan']}',
            agen_bank_jumlah = '{$data['agen_bank_jumlah']}', agen_bank_jarak = '{$data['agen_bank_jarak']}', agen_bank_kemudahan = '{$data['agen_bank_kemudahan']}',
            valas_jumlah = '{$data['valas_jumlah']}', valas_jarak = '{$data['valas_jarak']}', valas_kemudahan = '{$data['valas_kemudahan']}',
            pegadaian_jumlah = '{$data['pegadaian_jumlah']}', pegadaian_jarak = '{$data['pegadaian_jarak']}', pegadaian_kemudahan = '{$data['pegadaian_kemudahan']}',
            agen_tiket_jumlah = '{$data['agen_tiket_jumlah']}', agen_tiket_jarak = '{$data['agen_tiket_jarak']}', agen_tiket_kemudahan = '{$data['agen_tiket_kemudahan']}',
            bengkel_jumlah = '{$data['bengkel_jumlah']}', bengkel_jarak = '{$data['bengkel_jarak']}', bengkel_kemudahan = '{$data['bengkel_kemudahan']}',
            salon_jumlah = '{$data['salon_jumlah']}', salon_jarak = '{$data['salon_jarak']}', salon_kemudahan = '{$data['salon_kemudahan']}'
            WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // Jika data belum ada, lakukan INSERT
        $sql = "INSERT INTO tb_sarana_ekonomi (
            bmt_jumlah, bmt_jarak, bmt_kemudahan,
            atm_jumlah, atm_jarak, atm_kemudahan,
            agen_bank_jumlah, agen_bank_jarak, agen_bank_kemudahan,
            valas_jumlah, valas_jarak, valas_kemudahan,
            pegadaian_jumlah, pegadaian_jarak, pegadaian_kemudahan,
            agen_tiket_jumlah, agen_tiket_jarak, agen_tiket_kemudahan,
            bengkel_jumlah, bengkel_jarak, bengkel_kemudahan,
            salon_jumlah, salon_jarak, salon_kemudahan,
            tahun, user_id, desa_id
        ) VALUES (
            '{$data['bmt_jumlah']}', '{$data['bmt_jarak']}', '{$data['bmt_kemudahan']}',
            '{$data['atm_jumlah']}', '{$data['atm_jarak']}', '{$data['atm_kemudahan']}',
            '{$data['agen_bank_jumlah']}', '{$data['agen_bank_jarak']}', '{$data['agen_bank_kemudahan']}',
            '{$data['valas_jumlah']}', '{$data['valas_jarak']}', '{$data['valas_kemudahan']}',
            '{$data['pegadaian_jumlah']}', '{$data['pegadaian_jarak']}', '{$data['pegadaian_kemudahan']}',
            '{$data['agen_tiket_jumlah']}', '{$data['agen_tiket_jarak']}', '{$data['agen_tiket_kemudahan']}',
            '{$data['bengkel_jumlah']}', '{$data['bengkel_jarak']}', '{$data['bengkel_kemudahan']}',
            '{$data['salon_jumlah']}', '{$data['salon_jarak']}', '{$data['salon_kemudahan']}',
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
        $form_name = 'Sarana Ekonomi';
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