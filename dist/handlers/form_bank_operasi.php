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
    $bank_pemerintah = (int)$_POST['bank_pemerintah'];
    $bank_swasta = (int)$_POST['bank_swasta'];
    $bank_bpr = (int)$_POST['bank_bpr'];
    $jarak_bank_terdekat = isset($_POST['jarak_bank_terdekat']) && is_numeric($_POST['jarak_bank_terdekat']) ? (float)$_POST['jarak_bank_terdekat'] : 'NULL';

    // Check if the record already exists for the same year
    $check_query = "SELECT id FROM tb_bank_operasi WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Update the existing record
        $sql = "UPDATE tb_bank_operasi 
                SET bank_pemerintah = '$bank_pemerintah', bank_swasta = '$bank_swasta', 
                    bank_bpr = '$bank_bpr', jarak_bank_terdekat = $jarak_bank_terdekat, tahun = '$tahun' 
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // Insert a new record
        $sql = "INSERT INTO tb_bank_operasi (bank_pemerintah, bank_swasta, bank_bpr, jarak_bank_terdekat, user_id, desa_id, tahun)
                VALUES ('$bank_pemerintah', '$bank_swasta', '$bank_bpr', $jarak_bank_terdekat, '$user_id', '$desa_id', '$tahun')";
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
