<?php
include '../config/conn.php';
session_start();

// Ambil ID pengguna yang sedang login
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Ambil tahun dari session
$tahun = $_SESSION['tahun'] ?? null;

if (!$tahun) {
    echo "Tahun tidak ditemukan. Pastikan Anda telah login dengan memilih tahun.";
    exit();
}

// Ambil ID desa yang terkait dengan user yang sedang login
$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menyimpan data fasilitas olahraga dari POST
    $sepak_bola = mysqli_real_escape_string($conn, $_POST['sepakbola'] ?? null);
    $bola_voli = mysqli_real_escape_string($conn, $_POST['bolavoli'] ?? null);
    $bulu_tangkis = mysqli_real_escape_string($conn, $_POST['bulutangkis'] ?? null);
    $bola_basket = mysqli_real_escape_string($conn, $_POST['basket'] ?? null);
    $tenis_lapangan = mysqli_real_escape_string($conn, $_POST['tenislapangan'] ?? null);
    $tenis_meja = mysqli_real_escape_string($conn, $_POST['tenismeja'] ?? null);
    $futsal = mysqli_real_escape_string($conn, $_POST['futsal'] ?? null);
    $renang = mysqli_real_escape_string($conn, $_POST['renang'] ?? null);
    $bela_diri = mysqli_real_escape_string($conn, $_POST['beladiri'] ?? null);
    $bilyard = mysqli_real_escape_string($conn, $_POST['bilyard'] ?? null);
    $fitness = mysqli_real_escape_string($conn, $_POST['fitness'] ?? null);
    $lainnya_nama = mysqli_real_escape_string($conn, $_POST['lainnya'] ?? null);
    $lainnya_kondisi = mysqli_real_escape_string($conn, $_POST['lainnyaSelect'] ?? null);

    // Jika semua field kosong
    if (!$sepak_bola && !$bola_voli && !$bulu_tangkis && !$bola_basket && !$tenis_lapangan && !$tenis_meja && !$futsal && !$renang && !$bela_diri && !$bilyard && !$fitness && !$lainnya_nama) {
        header("Location: ../pages/forms/olahraga.php?status=warning");
        exit();
    }

    // Periksa apakah data sudah ada untuk tahun yang sama
    $check_query = "SELECT id FROM tb_fasilitas_olahraga WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Jika data sudah ada, lakukan update
        $sql = "UPDATE tb_fasilitas_olahraga 
                SET sepak_bola = '$sepak_bola', bola_voli = '$bola_voli', bulu_tangkis = '$bulu_tangkis', bola_basket = '$bola_basket', 
                    tenis_lapangan = '$tenis_lapangan', tenis_meja = '$tenis_meja', futsal = '$futsal', renang = '$renang', 
                    bela_diri = '$bela_diri', bilyard = '$bilyard', fitness = '$fitness', lainnya_nama = '$lainnya_nama', 
                    lainnya_kondisi = '$lainnya_kondisi', tahun = '$tahun' 
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // Jika data belum ada, lakukan insert
        $sql = "INSERT INTO tb_fasilitas_olahraga (sepak_bola, bola_voli, bulu_tangkis, bola_basket, tenis_lapangan, tenis_meja, futsal, renang, 
                    bela_diri, bilyard, fitness, lainnya_nama, lainnya_kondisi, user_id, desa_id, tahun) 
                VALUES ('$sepak_bola', '$bola_voli', '$bulu_tangkis', '$bola_basket', '$tenis_lapangan', '$tenis_meja', '$futsal', '$renang', 
                        '$bela_diri', '$bilyard', '$fitness', '$lainnya_nama', '$lainnya_kondisi', '$user_id', '$desa_id', '$tahun')";
    }

    if (mysqli_query($conn, $sql)) {
        // Tambahkan atau perbarui progres pengguna
        $query_progress = "SELECT id FROM user_progress WHERE user_id = '$user_id' AND form_name = 'Ketersediaan fasilitas/lapangan olahraga di desa/kelurahan' AND tahun = '$tahun'";
        $result_progress = mysqli_query($conn, $query_progress);

        $created_at = $tahun . '-01-01 00:00:00';

        if (mysqli_num_rows($result_progress) > 0) {
            // Update progress jika sudah ada
            $update_progress = "UPDATE user_progress 
                                SET is_locked = TRUE, desa_id = '$desa_id', created_at = '$created_at', tahun = '$tahun' 
                                WHERE user_id = '$user_id' AND form_name = 'Ketersediaan fasilitas/lapangan olahraga di desa/kelurahan' AND tahun = '$tahun'";
            mysqli_query($conn, $update_progress);
        } else {
            // Insert progress jika belum ada
            $insert_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id, created_at, tahun) 
                                VALUES ('$user_id', 'Ketersediaan fasilitas/lapangan olahraga di desa/kelurahan', TRUE, '$desa_id', '$created_at', '$tahun')";
            mysqli_query($conn, $insert_progress);
        }

        header("Location: ../pages/forms/olahraga.php?status=success");
        exit();
    } else {
        header("Location: ../pages/forms/olahraga.php?status=error&message=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: ../pages/forms/olahraga.php?status=warning");
    exit();
}
?>
