<?php
include '../config/conn.php';
session_start();

$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status_ruang_publik = $_POST['publicSpaceStatus'] ?? '';
    $ruang_terbuka_hijau = $_POST['greenSpace'] ?? NULL; // Optional, based on visibility
    $ruang_terbuka_non_hijau = $_POST['nonGreenSpace'] ?? NULL; // Optional, based on visibility

    // Check if the required fields are filled
    if (empty($status_ruang_publik)) {
        header("Location: ../pages/forms/sosial_budaya.php?status=error&message=Public space status required");
        exit();
    }

    $sql = "INSERT INTO tb_ruang_publik (status_ruang_publik, ruang_terbuka_hijau, ruang_terbuka_non_hijau, user_id, desa_id)
            VALUES ('$status_ruang_publik', '$ruang_terbuka_hijau', '$ruang_terbuka_non_hijau', '$user_id', '$desa_id')";

    if (mysqli_query($conn, $sql)) {
        $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id)
                           VALUES ('$user_id', 'Keberadaan Ruang publik terbuka yang peruntukan utamanya sebagai tempat bagi warga desa/kelurahan untuk bersantai/bermain tanpa perlu membayar (misalnya: lapangan terbuka/alun–alun, taman, dll.)', TRUE, '$desa_id')
                           ON DUPLICATE KEY UPDATE is_locked = TRUE, desa_id = '$desa_id'";
        mysqli_query($conn, $query_progress);
        header("Location: ../pages/forms/sosial_budaya.php?status=success");
        exit();
    } else {
        header("Location: ../pages/forms/sosial_budaya.php?status=error&message=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: ../pages/forms/sosial_budaya.php?status=warning");
    exit();
}
?>
