<?php
include '../config/conn.php';
session_start();

// Retrieve user ID from session
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Retrieve year from session
$tahun = $_SESSION['tahun'] ?? null;

if (!$tahun) {
    echo "Tahun tidak ditemukan. Pastikan Anda telah login dengan memilih tahun.";
    exit();
}

// Retrieve village ID associated with the user
$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and prepare data from POST
    $keberadaan_dukun_bayi = mysqli_real_escape_string($conn, $_POST['keberadaan_dukun_bayi']);

    // Check if the record already exists for the same year
    $check_query = "SELECT id FROM tb_keberadaan_dukun_bayi WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // If record exists for the same year, update the existing record
        $sql = "UPDATE tb_keberadaan_dukun_bayi 
                SET keberadaan_dukun_bayi = '$keberadaan_dukun_bayi', tahun = '$tahun' 
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // If record doesn't exist for the same year, insert a new record
        $sql = "INSERT INTO tb_keberadaan_dukun_bayi (keberadaan_dukun_bayi, user_id, desa_id, tahun)
                VALUES ('$keberadaan_dukun_bayi', '$user_id', '$desa_id', '$tahun')";
    }

    if (mysqli_query($conn, $sql)) {
        // Update user progress
        $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id, tahun) 
                           VALUES ('$user_id', 'Keberadaan Dukun Bayi/Paraji yang menetap di Desa/Kelurahan', TRUE, '$desa_id', '$tahun')
                           ON DUPLICATE KEY UPDATE is_locked = TRUE, desa_id = '$desa_id', tahun = '$tahun'";
        mysqli_query($conn, $query_progress);

        header("Location: ../pages/forms/pendidikan_dan_kesehatan.php?status=success");
        exit();
    } else {
        header("Location: ../pages/forms/pendidikan_dan_kesehatan.php?status=error&message=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: ../pages/forms/pendidikan_dan_kesehatan.php?status=warning");
    exit();
}
?>
