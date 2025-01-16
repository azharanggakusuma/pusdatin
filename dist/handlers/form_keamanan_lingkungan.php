<?php
session_start();
include "../config/conn.php";

// Retrieve user ID and year from session
$username = $_SESSION['username'] ?? '';
$tahun = $_SESSION['tahun'] ?? null;

if (!$tahun || !$username) {
    echo "Tahun atau pengguna tidak ditemukan. Pastikan Anda telah login.";
    exit();
}

// Fetch user_id and desa_id
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and prepare data
    $data = [
        'pembangunan_pos_keamanan' => mysqli_real_escape_string($conn, $_POST['pembangunan_pos_keamanan']),
        'pembentukan_regu_keamanan' => mysqli_real_escape_string($conn, $_POST['pembentukan_regu_keamanan']),
        'penambahan_anggota_hansip' => mysqli_real_escape_string($conn, $_POST['penambahan_anggota_hansip']),
        'pelaporan_tamu_menginap' => mysqli_real_escape_string($conn, $_POST['pelaporan_tamu_menginap']),
        'pengaktifan_sistem_keamanan' => mysqli_real_escape_string($conn, $_POST['pengaktifan_sistem_keamanan']),
    ];

    // Check if a record exists for the same year
    $check_query = "SELECT id FROM tb_keamanan_lingkungan WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Update existing record
        $sql = "UPDATE tb_keamanan_lingkungan SET 
            pembangunan_pos_keamanan = '{$data['pembangunan_pos_keamanan']}',
            pembentukan_regu_keamanan = '{$data['pembentukan_regu_keamanan']}',
            penambahan_anggota_hansip = '{$data['penambahan_anggota_hansip']}',
            pelaporan_tamu_menginap = '{$data['pelaporan_tamu_menginap']}',
            pengaktifan_sistem_keamanan = '{$data['pengaktifan_sistem_keamanan']}'
            WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // Insert new record
        $sql = "INSERT INTO tb_keamanan_lingkungan (
            pembangunan_pos_keamanan, pembentukan_regu_keamanan, penambahan_anggota_hansip,
            pelaporan_tamu_menginap, pengaktifan_sistem_keamanan, tahun, user_id, desa_id
        ) VALUES (
            '{$data['pembangunan_pos_keamanan']}', '{$data['pembentukan_regu_keamanan']}', '{$data['penambahan_anggota_hansip']}',
            '{$data['pelaporan_tamu_menginap']}', '{$data['pengaktifan_sistem_keamanan']}', '$tahun', '$user_id', '$desa_id'
        )";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: ../pages/forms/keamanan.php?status=success");
        exit();
    } else {
        header("Location: ../pages/forms/keamanan.php?status=error&message=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: ../pages/forms/keamanan.php?status=warning");
    exit();
}
?>
