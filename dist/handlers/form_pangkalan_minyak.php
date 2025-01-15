<?php
session_start();
include "../config/conn.php";

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
    $keberadaan_minyak_tanah = mysqli_real_escape_string($conn, $_POST['keberadaan_minyak_tanah']);
    $keberadaan_lpg = mysqli_real_escape_string($conn, $_POST['keberadaan_lpg']);

    // Check if the record already exists for the same year
    $check_query = "SELECT id FROM tb_pangkalan_minyak WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Update existing record
        $sql = "UPDATE tb_pangkalan_minyak 
                SET keberadaan_minyak_tanah = '$keberadaan_minyak_tanah', keberadaan_lpg = '$keberadaan_lpg', tahun = '$tahun' 
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // Insert new record
        $sql = "INSERT INTO tb_pangkalan_minyak (keberadaan_minyak_tanah, keberadaan_lpg, user_id, desa_id, tahun)
                VALUES ('$keberadaan_minyak_tanah', '$keberadaan_lpg', '$user_id', '$desa_id', '$tahun')";
    }

    if (mysqli_query($conn, $sql)) {
        // Update progress
        $query_progress = "SELECT id FROM user_progress WHERE user_id = '$user_id' AND form_name = 'Keberadaan Pangkalan Minyak Tanah dan LPG' AND tahun = '$tahun'";
        $result_progress = mysqli_query($conn, $query_progress);

        $created_at = $tahun . '-01-01 00:00:00';

        if (mysqli_num_rows($result_progress) > 0) {
            $update_progress = "UPDATE user_progress 
                                SET is_locked = TRUE, desa_id = '$desa_id', created_at = '$created_at', tahun = '$tahun' 
                                WHERE user_id = '$user_id' AND form_name = 'Keberadaan Pangkalan Minyak Tanah dan LPG' AND tahun = '$tahun'";
            mysqli_query($conn, $update_progress);
        } else {
            $insert_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id, created_at, tahun) 
                                VALUES ('$user_id', 'Keberadaan Pangkalan Minyak Tanah dan LPG', TRUE, '$desa_id', '$created_at', '$tahun')";
            mysqli_query($conn, $insert_progress);
        }

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
