<?php
include '../config/conn.php';
session_start();

// Retrieve user ID from session
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Retrieve village ID associated with the user
$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

// Retrieve year from session
$tahun = $_SESSION['tahun'] ?? null;

if (!$tahun) {
    echo "Tahun tidak ditemukan. Pastikan Anda telah login dengan memilih tahun.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and prepare data from POST
    $jumlah_masjid = (int)($_POST['masjid'] ?? 0);
    $jumlah_pura = (int)($_POST['pura'] ?? 0);
    $jumlah_musala = (int)($_POST['musala'] ?? 0);
    $jumlah_wihara = (int)($_POST['wihara'] ?? 0);
    $jumlah_gereja_kristen = (int)($_POST['kristen'] ?? 0);
    $jumlah_kelenteng = (int)($_POST['kelenteng'] ?? 0);
    $jumlah_gereja_katolik = (int)($_POST['katolik'] ?? 0);
    $jumlah_balai_basarah = (int)($_POST['basarah'] ?? 0);
    $jumlah_kapel = (int)($_POST['kapel'] ?? 0);
    $lainnya = $_POST['lainnya'] ?? NULL;
    $jumlah_lainnya = (int)($_POST['lainnyaInput'] ?? 0);

    // Check if the record already exists for the same year
    $check_query = "SELECT id FROM tb_tempat_ibadah WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // If record exists for the same year, update the existing record
        $sql = "UPDATE tb_tempat_ibadah 
                SET jumlah_masjid = '$jumlah_masjid', jumlah_pura = '$jumlah_pura', jumlah_musala = '$jumlah_musala', jumlah_wihara = '$jumlah_wihara',
                    jumlah_gereja_kristen = '$jumlah_gereja_kristen', jumlah_kelenteng = '$jumlah_kelenteng', jumlah_gereja_katolik = '$jumlah_gereja_katolik',
                    jumlah_balai_basarah = '$jumlah_balai_basarah', jumlah_kapel = '$jumlah_kapel', lainnya = '$lainnya', jumlah_lainnya = '$jumlah_lainnya', tahun = '$tahun'
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // If record doesn't exist for the same year, insert a new record
        $sql = "INSERT INTO tb_tempat_ibadah (jumlah_masjid, jumlah_pura, jumlah_musala, jumlah_wihara, jumlah_gereja_kristen, jumlah_kelenteng, jumlah_gereja_katolik, jumlah_balai_basarah, jumlah_kapel, lainnya, jumlah_lainnya, user_id, desa_id, tahun)
                VALUES ('$jumlah_masjid', '$jumlah_pura', '$jumlah_musala', '$jumlah_wihara', '$jumlah_gereja_kristen', '$jumlah_kelenteng', '$jumlah_gereja_katolik', '$jumlah_balai_basarah', '$jumlah_kapel', '$lainnya', '$jumlah_lainnya', '$user_id', '$desa_id', '$tahun')";
    }

    if (mysqli_query($conn, $sql)) {
        // Update user progress
        $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id, tahun) 
        VALUES ('$user_id', 'Jumlah Tempat Ibadah di Desa/Kelurahan', TRUE, '$desa_id', '$tahun')
        ON DUPLICATE KEY UPDATE is_locked = TRUE, desa_id = '$desa_id', tahun = '$tahun'";
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
