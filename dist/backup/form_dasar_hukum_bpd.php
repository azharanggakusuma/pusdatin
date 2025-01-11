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
    $ketersediaan_dasar_hukum = mysqli_real_escape_string($conn, $_POST['ketersediaan_dasar_hukum']);
    $nomor_peraturan = mysqli_real_escape_string($conn, $_POST['nomor_peraturan']);

    // Validasi input
    if (empty($ketersediaan_dasar_hukum)) {
        // Jika ada field yang kosong, arahkan kembali dengan status warning
        header("Location: ../pages/forms/wilayah_administratif.php?status=warning");
        exit();
    }

    // Jika ketersediaan dasar hukum "ADA", pastikan nomor peraturan diisi
    if ($ketersediaan_dasar_hukum === 'ADA' && empty($nomor_peraturan)) {
        // Jika nomor peraturan kosong, arahkan kembali dengan status warning
        header("Location: ../pages/forms/wilayah_administratif.php?status=warning");
        exit();
    }

    // Masukkan data ke database
    $sql = "INSERT INTO tb_dasar_hukum_bpd (ketersediaan_dasar_hukum, nomor_peraturan, user_id, desa_id) 
            VALUES ('$ketersediaan_dasar_hukum', '$nomor_peraturan', '$user_id', '$desa_id')";

    if (mysqli_query($conn, $sql)) {
        // Tambahkan atau perbarui progres pengguna
        $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id) 
                           VALUES ('$user_id', 'Dasar hukum pembentukan Badan Permusyawaratan Desa (BPD)', TRUE, '$desa_id')
                           ON DUPLICATE KEY UPDATE is_locked = TRUE, desa_id = '$desa_id'";
        mysqli_query($conn, $query_progress);

        header("Location: ../pages/forms/wilayah_administratif.php?status=success");
        exit();
    } else {
        header("Location: ../pages/forms/wilayah_administratif.php?status=error&message=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: ../pages/forms/wilayah_administratif.php?status=warning");
    exit(); 
}
?>
