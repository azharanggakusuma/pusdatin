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
    $keberadaan = mysqli_real_escape_string($conn, $_POST['keberadaan']);
    $makanan_unggulan = $_POST['makanan_unggulan'] ?? null;
    $non_makanan_unggulan = $_POST['non_makanan_unggulan'] ?? null;

    // Jika keberadaan "Tidak Ada", pastikan makanan_unggulan dan non_makanan_unggulan bernilai NULL
    if ($keberadaan === 'Tidak Ada') {
        $makanan_unggulan = null;
        $non_makanan_unggulan = null;
    }

    $makanan_unggulan = !empty($makanan_unggulan) ? "'" . mysqli_real_escape_string($conn, $makanan_unggulan) . "'" : "NULL";
    $non_makanan_unggulan = !empty($non_makanan_unggulan) ? "'" . mysqli_real_escape_string($conn, $non_makanan_unggulan) . "'" : "NULL";

    // Check if the record already exists for the same year
    $check_query = "SELECT id FROM tb_produk_unggulan WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Update existing record
        $sql = "UPDATE tb_produk_unggulan 
                SET keberadaan = '$keberadaan', makanan_unggulan = $makanan_unggulan, non_makanan_unggulan = $non_makanan_unggulan, tahun = '$tahun' 
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // Insert new record
        $sql = "INSERT INTO tb_produk_unggulan (keberadaan, makanan_unggulan, non_makanan_unggulan, user_id, desa_id, tahun)
                VALUES ('$keberadaan', $makanan_unggulan, $non_makanan_unggulan, '$user_id', '$desa_id', '$tahun')";
    }

    if (mysqli_query($conn, $sql)) {
        // Update progress
        $query_progress = "SELECT id FROM user_progress WHERE user_id = '$user_id' AND form_name = 'Keberadaan Produk Barang Unggulan' AND tahun = '$tahun'";
        $result_progress = mysqli_query($conn, $query_progress);

        $created_at = $tahun . '-01-01 00:00:00';

        if (mysqli_num_rows($result_progress) > 0) {
            $update_progress = "UPDATE user_progress 
                                SET is_locked = TRUE, desa_id = '$desa_id', created_at = '$created_at', tahun = '$tahun' 
                                WHERE user_id = '$user_id' AND form_name = 'Keberadaan Produk Barang Unggulan' AND tahun = '$tahun'";
            mysqli_query($conn, $update_progress);
        } else {
            $insert_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id, created_at, tahun) 
                                VALUES ('$user_id', 'Keberadaan Produk Barang Unggulan', TRUE, '$desa_id', '$created_at', '$tahun')";
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
