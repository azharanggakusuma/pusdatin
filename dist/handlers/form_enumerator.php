<?php
include '../config/conn.php';
session_start();

// Ambil ID pengguna yang sedang login
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = isset($_POST['nama']) ? mysqli_real_escape_string($conn, $_POST['nama']) : '';
    $alamat = isset($_POST['alamat']) ? mysqli_real_escape_string($conn, $_POST['alamat']) : '';
    $no_hp = isset($_POST['no_hp']) ? mysqli_real_escape_string($conn, $_POST['no_hp']) : '';
    $kode_desa = isset($_POST['kode_desa']) ? mysqli_real_escape_string($conn, $_POST['kode_desa']) : '';
    $nama_desa = isset($_POST['nama_desa']) ? mysqli_real_escape_string($conn, $_POST['nama_desa']) : '';
    $kecamatan = isset($_POST['kecamatan']) ? mysqli_real_escape_string($conn, $_POST['kecamatan']) : '';

    if (!empty($kode_desa) && !empty($nama_desa) && !empty($nama_lengkap) && !empty($alamat) && !empty($no_hp) && !empty($kecamatan)) {
        // Tambahkan data desa beserta data lainnya
        $sql = "INSERT INTO tb_enumerator (kode_desa, nama_desa, nama_lengkap, alamat, no_hp, kecamatan, user_id) 
                VALUES ('$kode_desa', '$nama_desa', '$nama_lengkap', '$alamat', '$no_hp', '$kecamatan', '$user_id')";

        if (mysqli_query($conn, $sql)) {
            // Ambil ID desa yang baru ditambahkan
            $desa_id = mysqli_insert_id($conn);

            // Tambahkan atau perbarui progres pengguna dan catat desa_id
            $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id) 
                               VALUES ('$user_id', 'Data Enumerator', TRUE, '$desa_id')
                               ON DUPLICATE KEY UPDATE is_locked = TRUE, desa_id = '$desa_id'";
            mysqli_query($conn, $query_progress);

            header("Location: ../pages/forms/data_enumerator.php?status=success");
            exit();
        } else {
            header("Location: ../pages/forms/data_enumerator.php?status=error&message=" . urlencode(mysqli_error($conn)));
            exit();
        }
    } else {
        header("Location: ../pages/forms/data_enumerator.php?status=warning");
        exit();
    }
}
