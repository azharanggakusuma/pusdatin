<?php
session_start();
include "../config/conn.php";

// Retrieve user ID and year from session
$username = $_SESSION['username'] ?? '';
$tahun = $_SESSION['tahun'] ?? null;

if (!$tahun || !$username) {
    echo "Tahun atau pengguna tidak ditemukan. Pastikan Anda telah login.";
    exit();
}

// Fetch user_id and desa_id
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and prepare data
    $data = [
        'kelompok_pertokoan_jumlah' => (int)$_POST['kelompok_pertokoan_jumlah'],
        'kelompok_pertokoan_kemudahan' => $_POST['kelompok_pertokoan_kemudahan'],
        'pasar_permanen_jumlah' => (int)$_POST['pasar_permanen_jumlah'],
        'pasar_permanen_kemudahan' => $_POST['pasar_permanen_kemudahan'],
        'pasar_semi_permanen_jumlah' => (int)$_POST['pasar_semi_permanen_jumlah'],
        'pasar_semi_permanen_kemudahan' => $_POST['pasar_semi_permanen_kemudahan'],
        'pasar_tanpa_bangunan_jumlah' => (int)$_POST['pasar_tanpa_bangunan_jumlah'],
        'pasar_tanpa_bangunan_kemudahan' => $_POST['pasar_tanpa_bangunan_kemudahan'],
        'minimarket_jumlah' => (int)$_POST['minimarket_jumlah'],
        'minimarket_kemudahan' => $_POST['minimarket_kemudahan'],
        'restoran_jumlah' => (int)$_POST['restoran_jumlah'],
        'restoran_kemudahan' => $_POST['restoran_kemudahan'],
        'warung_makan_jumlah' => (int)$_POST['warung_makan_jumlah'],
        'warung_makan_kemudahan' => $_POST['warung_makan_kemudahan'],
        'toko_kelontong_jumlah' => (int)$_POST['toko_kelontong_jumlah'],
        'toko_kelontong_kemudahan' => $_POST['toko_kelontong_kemudahan'],
        'hotel_jumlah' => (int)$_POST['hotel_jumlah'],
        'hotel_kemudahan' => $_POST['hotel_kemudahan'],
        'penginapan_jumlah' => (int)$_POST['penginapan_jumlah'],
        'penginapan_kemudahan' => $_POST['penginapan_kemudahan'],
    ];

    // Check if a record exists for the same year
    $check_query = "SELECT id FROM tb_sarana_prasarana WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Update existing record
        $sql = "UPDATE tb_sarana_prasarana SET 
            kelompok_pertokoan_jumlah = '{$data['kelompok_pertokoan_jumlah']}', kelompok_pertokoan_kemudahan = '{$data['kelompok_pertokoan_kemudahan']}',
            pasar_permanen_jumlah = '{$data['pasar_permanen_jumlah']}', pasar_permanen_kemudahan = '{$data['pasar_permanen_kemudahan']}',
            pasar_semi_permanen_jumlah = '{$data['pasar_semi_permanen_jumlah']}', pasar_semi_permanen_kemudahan = '{$data['pasar_semi_permanen_kemudahan']}',
            pasar_tanpa_bangunan_jumlah = '{$data['pasar_tanpa_bangunan_jumlah']}', pasar_tanpa_bangunan_kemudahan = '{$data['pasar_tanpa_bangunan_kemudahan']}',
            minimarket_jumlah = '{$data['minimarket_jumlah']}', minimarket_kemudahan = '{$data['minimarket_kemudahan']}',
            restoran_jumlah = '{$data['restoran_jumlah']}', restoran_kemudahan = '{$data['restoran_kemudahan']}',
            warung_makan_jumlah = '{$data['warung_makan_jumlah']}', warung_makan_kemudahan = '{$data['warung_makan_kemudahan']}',
            toko_kelontong_jumlah = '{$data['toko_kelontong_jumlah']}', toko_kelontong_kemudahan = '{$data['toko_kelontong_kemudahan']}',
            hotel_jumlah = '{$data['hotel_jumlah']}', hotel_kemudahan = '{$data['hotel_kemudahan']}',
            penginapan_jumlah = '{$data['penginapan_jumlah']}', penginapan_kemudahan = '{$data['penginapan_kemudahan']}'
            WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // Insert new record
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

    if (mysqli_query($conn, $sql)) {
        header("Location: ../pages/forms/ekonomi.php?status=success");
        exit();
    } else {
        header("Location: ../pages/forms/ekonomi.php?status=error&message=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: ../pages/forms/ekonomi.php?status=warning");
    exit();
}
?>
