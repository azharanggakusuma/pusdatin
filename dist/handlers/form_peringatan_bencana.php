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
    // Menyimpan data dari form POST
    $peringatan_dini = mysqli_real_escape_string($conn, $_POST['peringatan_dini'] ?? '');
    $peringatan_tsunami = mysqli_real_escape_string($conn, $_POST['peringatan_tsunami'] ?? '');
    $perlengkapan_keselamatan = mysqli_real_escape_string($conn, $_POST['perlengkapan_keselamatan'] ?? '');
    $rambu_evakuasi = mysqli_real_escape_string($conn, $_POST['rambu_evakuasi'] ?? '');
    $infrastruktur = mysqli_real_escape_string($conn, $_POST['infrastruktur'] ?? '');

    // Periksa apakah data sudah ada untuk tahun yang sama
    $check_query = "SELECT id_peringatan FROM tb_peringatan_bencana WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Jika data sudah ada, perbarui data
        $sql = "UPDATE tb_peringatan_bencana 
                SET peringatan_dini = '$peringatan_dini', peringatan_tsunami = '$peringatan_tsunami', 
                    perlengkapan_keselamatan = '$perlengkapan_keselamatan', rambu_evakuasi = '$rambu_evakuasi', 
                    infrastruktur = '$infrastruktur', tahun = '$tahun' 
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // Jika data belum ada, masukkan data baru
        $sql = "INSERT INTO tb_peringatan_bencana (peringatan_dini, peringatan_tsunami, perlengkapan_keselamatan, 
                rambu_evakuasi, infrastruktur, user_id, desa_id, tahun) 
                VALUES ('$peringatan_dini', '$peringatan_tsunami', '$perlengkapan_keselamatan', 
                '$rambu_evakuasi', '$infrastruktur', '$user_id', '$desa_id', '$tahun')";
    }

    if (mysqli_query($conn, $sql)) {
        // Tambahkan atau perbarui progres pengguna
        $query_progress = "SELECT id FROM user_progress WHERE user_id = '$user_id' AND form_name = 'Fasilitas/upaya antisipasi/mitigasi bencana alam yang ada di desa/kelurahan' AND tahun = '$tahun'";
        $result_progress = mysqli_query($conn, $query_progress);

        $created_at = $tahun . '-01-01 00:00:00';

        if (mysqli_num_rows($result_progress) > 0) {
            // Jika progres sudah ada, perbarui
            $update_progress = "UPDATE user_progress 
                                SET is_locked = TRUE, desa_id = '$desa_id', created_at = '$created_at', tahun = '$tahun' 
                                WHERE user_id = '$user_id' AND form_name = 'Fasilitas/upaya antisipasi/mitigasi bencana alam yang ada di desa/kelurahan' AND tahun = '$tahun'";
            mysqli_query($conn, $update_progress);
        } else {
            // Jika progres belum ada, tambahkan
            $insert_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id, created_at, tahun) 
                                VALUES ('$user_id', 'Fasilitas/upaya antisipasi/mitigasi bencana alam yang ada di desa/kelurahan', TRUE, '$desa_id', '$created_at', '$tahun')";
            mysqli_query($conn, $insert_progress);
        }

        header("Location: ../pages/forms/bencana_alam_dan_mitigasi_bencana_alam.php?status=success");
        exit();
    } else {
        header("Location: ../pages/forms/bencana_alam_dan_mitigasi_bencana_alam.php?status=error&message=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: ../pages/forms/bencana_alam_dan_mitigasi_bencana_alam.php?status=warning");
    exit();
}
?>
