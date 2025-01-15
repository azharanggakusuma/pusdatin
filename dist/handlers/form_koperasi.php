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
    $koperasi_kud = (int)$_POST['koperasi_kud'];
    $koperasi_kopinkra = (int)$_POST['koperasi_kopinkra'];
    $koperasi_ksp = (int)$_POST['koperasi_ksp'];
    $koperasi_lainnya = (int)$_POST['koperasi_lainnya'];
    $toko_kud = $_POST['toko_kud'];
    $toko_bumdesa = $_POST['toko_bumdesa'];
    $toko_lainnya = $_POST['toko_lainnya'];

    // Check if the record already exists for the same year
    $check_query = "SELECT id FROM tb_koperasi WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Update the existing record
        $sql = "UPDATE tb_koperasi 
                SET koperasi_kud = '$koperasi_kud', koperasi_kopinkra = '$koperasi_kopinkra', 
                    koperasi_ksp = '$koperasi_ksp', koperasi_lainnya = '$koperasi_lainnya',
                    toko_kud = '$toko_kud', toko_bumdesa = '$toko_bumdesa', toko_lainnya = '$toko_lainnya', tahun = '$tahun' 
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // Insert a new record
        $sql = "INSERT INTO tb_koperasi (koperasi_kud, koperasi_kopinkra, koperasi_ksp, koperasi_lainnya, toko_kud, toko_bumdesa, toko_lainnya, user_id, desa_id, tahun)
                VALUES ('$koperasi_kud', '$koperasi_kopinkra', '$koperasi_ksp', '$koperasi_lainnya', '$toko_kud', '$toko_bumdesa', '$toko_lainnya', '$user_id', '$desa_id', '$tahun')";
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
