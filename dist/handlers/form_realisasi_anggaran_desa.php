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
    $pendapatan_asli_desa = mysqli_real_escape_string($conn, $_POST['pendapatan_asli_desa']);
    $dana_desa = mysqli_real_escape_string($conn, $_POST['dana_desa']);
    $bagian_dari_hasil_pajak_daerah = mysqli_real_escape_string($conn, $_POST['bagian_dari_hasil_pajak_daerah_dan_retribusi_daerah']);
    $alokasi_dana_desa = mysqli_real_escape_string($conn, $_POST['alokasi_dana_desa']);
    $bantuan_keuangan_dari_apbd_provinsi = mysqli_real_escape_string($conn, $_POST['bantuan_keuangan_dari_apbd_provinsi']);
    $bantuan_keuangan_dari_apbd = mysqli_real_escape_string($conn, $_POST['bantuan_keuangan_dari_apbd']);
    $hibah_dan_sumbangan = mysqli_real_escape_string($conn, $_POST['hibah_dan_sumbangan_dari_pihak_ketiga']);
    $lain_lain_pendapatan = mysqli_real_escape_string($conn, $_POST['lain_lain_pendapatan_desa_yang_sah']);

    // Insert or update record
    $check_query = "SELECT id FROM tb_realisasi_anggaran_desa WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $sql = "UPDATE tb_realisasi_anggaran_desa SET 
            pendapatan_asli_desa = '$pendapatan_asli_desa',
            dana_desa = '$dana_desa',
            bagian_dari_hasil_pajak_daerah_dan_retribusi_daerah = '$bagian_dari_hasil_pajak_daerah',
            alokasi_dana_desa = '$alokasi_dana_desa',
            bantuan_keuangan_dari_apbd_provinsi = '$bantuan_keuangan_dari_apbd_provinsi',
            bantuan_keuangan_dari_apbd = '$bantuan_keuangan_dari_apbd',
            hibah_dan_sumbangan_dari_pihak_ketiga = '$hibah_dan_sumbangan',
            lain_lain_pendapatan_desa_yang_sah = '$lain_lain_pendapatan'
            WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        $sql = "INSERT INTO tb_realisasi_anggaran_desa (
            pendapatan_asli_desa, dana_desa, bagian_dari_hasil_pajak_daerah_dan_retribusi_daerah, alokasi_dana_desa, 
            bantuan_keuangan_dari_apbd_provinsi, bantuan_keuangan_dari_apbd, hibah_dan_sumbangan_dari_pihak_ketiga, 
            lain_lain_pendapatan_desa_yang_sah, tahun, user_id, desa_id
        ) VALUES (
            '$pendapatan_asli_desa', '$dana_desa', '$bagian_dari_hasil_pajak_daerah', '$alokasi_dana_desa',
            '$bantuan_keuangan_dari_apbd_provinsi', '$bantuan_keuangan_dari_apbd', '$hibah_dan_sumbangan', 
            '$lain_lain_pendapatan', '$tahun', '$user_id', '$desa_id'
        )";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: ../pages/forms/keuangan_dan_aset_desa.php?status=success");
        exit();
    } else {
        header("Location: ../pages/forms/keuangan_dan_aset_desa.php?status=error&message=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: ../pages/forms/keuangan_dan_aset_desa.php?status=warning");
    exit();
}
?>
