<?php
include '../config/conn.php';
session_start();

// Ambil ID pengguna yang sedang login
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Ambil ID desa yang terkait dengan user yang sedang login
$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jarak_ke_ibukota_kecamatan = mysqli_real_escape_string($conn, $_POST['jarak_ke_ibukota_kecamatan']);
    $jarak_ke_ibukota_kabupaten = mysqli_real_escape_string($conn, $_POST['jarak_ke_ibukota_kabupaten']);

    // Validasi input hanya angka dan menambahkan satuan km
    if (is_numeric($jarak_ke_ibukota_kecamatan) && is_numeric($jarak_ke_ibukota_kabupaten)) {
        $jarak_ke_ibukota_kecamatan .= ' km';
        $jarak_ke_ibukota_kabupaten .= ' km';

        // Perbarui query untuk memasukkan user_id dan desa_id
        $sql = "INSERT INTO tb_jarak_kantor_desa (jarak_ke_ibukota_kecamatan, jarak_ke_ibukota_kabupaten, user_id, desa_id) 
                VALUES ('$jarak_ke_ibukota_kecamatan', '$jarak_ke_ibukota_kabupaten', '$user_id', '$desa_id')";

        if (mysqli_query($conn, $sql)) {
            // Tambahkan atau perbarui progres pengguna
            $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id) 
                               VALUES ('$user_id', 'Jarak Kantor Desa', TRUE, '$desa_id')
                               ON DUPLICATE KEY UPDATE is_locked = TRUE, desa_id = '$desa_id'";
            mysqli_query($conn, $query_progress);

            header("Location: ../pages/forms/keadaan_geografi.php?status=success");
            exit();
        } else {
            header("Location: ../pages/forms/keadaan_geografi.php?status=error&message=" . urlencode(mysqli_error($conn)));
            exit();
        }
    } else {
        header("Location: ../pages/forms/keadaan_geografi.php?status=warning&message=Input harus berupa angka.");
        exit();
    }
}
?>
