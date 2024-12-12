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
    // Ambil data dari form
    $batas_utara = mysqli_real_escape_string($conn, $_POST['batas_utara']);
    $kec_utara = mysqli_real_escape_string($conn, $_POST['kec_utara']);
    $batas_selatan = mysqli_real_escape_string($conn, $_POST['batas_selatan']);
    $kec_selatan = mysqli_real_escape_string($conn, $_POST['kec_selatan']);
    $batas_timur = mysqli_real_escape_string($conn, $_POST['batas_timur']);
    $kec_timur = mysqli_real_escape_string($conn, $_POST['kec_timur']);
    $batas_barat = mysqli_real_escape_string($conn, $_POST['batas_barat']);
    $kec_barat = mysqli_real_escape_string($conn, $_POST['kec_barat']);

    if ($desa_id > 0 && $user_id > 0) {  // Pastikan user_id dan desa_id ada
        // Query untuk menyisipkan data ke dalam tabel tb_batas_wilayah_desa
        $sql = "INSERT INTO tb_batas_wilayah_desa (desa_id, user_id, batas, desa, kecamatan) VALUES 
                ('$desa_id', '$user_id', 'Sebelah Utara', '$batas_utara', '$kec_utara'),
                ('$desa_id', '$user_id', 'Sebelah Selatan', '$batas_selatan', '$kec_selatan'),
                ('$desa_id', '$user_id', 'Sebelah Timur', '$batas_timur', '$kec_timur'),
                ('$desa_id', '$user_id', 'Sebelah Barat', '$batas_barat', '$kec_barat')";

        if (mysqli_query($conn, $sql)) {
            // Tambahkan atau perbarui progres pengguna
            $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id) 
                               VALUES ('$user_id', 'Batas Wilayah Desa', TRUE, '$desa_id')
                               ON DUPLICATE KEY UPDATE is_locked = TRUE, desa_id = '$desa_id'";
            mysqli_query($conn, $query_progress);

            // Redirect ke halaman sukses
            header("Location: ../pages/forms/keadaan_geografi.php?status=success");
            exit();
        } else {
            // Redirect dengan pesan error
            header("Location: ../pages/forms/keadaan_geografi.php?status=error&message=" . urlencode(mysqli_error($conn)));
            exit();
        }
    } else {
        // Redirect jika ID desa atau user tidak ditemukan
        header("Location: ../pages/forms/keadaan_geografi.php?status=warning");
        exit();
    }
}
?>
