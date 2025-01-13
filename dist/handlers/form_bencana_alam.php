<?php
include '../config/conn.php';
session_start();

// Ambil ID pengguna yang sedang login
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Ambil tahun dari sesi
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
    // Menyimpan data bencana alam dari POST
    $tanah_longsor = isset($_POST['tanah_longsor']) && $_POST['tanah_longsor'] === 'Ada' ? 'Ada' : 'Tidak Ada';
    $banjir = isset($_POST['banjir']) && $_POST['banjir'] === 'Ada' ? 'Ada' : 'Tidak Ada';
    $banjir_bandang = isset($_POST['banjir_bandang']) && $_POST['banjir_bandang'] === 'Ada' ? 'Ada' : 'Tidak Ada';
    $gempa_bumi = isset($_POST['gempa_bumi']) && $_POST['gempa_bumi'] === 'Ada' ? 'Ada' : 'Tidak Ada';
    $tsunami = isset($_POST['tsunami']) && $_POST['tsunami'] === 'Ada' ? 'Ada' : 'Tidak Ada';
    $gelombang_pasang = isset($_POST['gelombang_pasang']) && $_POST['gelombang_pasang'] === 'Ada' ? 'Ada' : 'Tidak Ada';
    $angin_puyuh = isset($_POST['angin_puyuh']) && $_POST['angin_puyuh'] === 'Ada' ? 'Ada' : 'Tidak Ada';
    $gunung_meletus = isset($_POST['gunung_meletus']) && $_POST['gunung_meletus'] === 'Ada' ? 'Ada' : 'Tidak Ada';
    $kebakaran_hutan = isset($_POST['kebakaran_hutan']) && $_POST['kebakaran_hutan'] === 'Ada' ? 'Ada' : 'Tidak Ada';
    $kekeringan = isset($_POST['kekeringan']) && $_POST['kekeringan'] === 'Ada' ? 'Ada' : 'Tidak Ada';
    $abrasi = isset($_POST['abrasi']) && $_POST['abrasi'] === 'Ada' ? 'Ada' : 'Tidak Ada';

    // Check if the record already exists for the same year
    $check_query = "SELECT id_bencana_alam FROM tb_bencana_alam WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Update the existing record
        $sql = "UPDATE tb_bencana_alam 
                SET tanah_longsor = '$tanah_longsor', banjir = '$banjir', banjir_bandang = '$banjir_bandang',
                    gempa_bumi = '$gempa_bumi', tsunami = '$tsunami', gelombang_pasang = '$gelombang_pasang',
                    angin_puyuh = '$angin_puyuh', gunung_meletus = '$gunung_meletus',
                    kebakaran_hutan = '$kebakaran_hutan', kekeringan = '$kekeringan', abrasi = '$abrasi', tahun = '$tahun'
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // Insert a new record
        $sql = "INSERT INTO tb_bencana_alam (tanah_longsor, banjir, banjir_bandang, gempa_bumi, tsunami, gelombang_pasang,
                angin_puyuh, gunung_meletus, kebakaran_hutan, kekeringan, abrasi, user_id, desa_id, tahun) 
                VALUES ('$tanah_longsor', '$banjir', '$banjir_bandang', '$gempa_bumi', '$tsunami', '$gelombang_pasang',
                '$angin_puyuh', '$gunung_meletus', '$kebakaran_hutan', '$kekeringan', '$abrasi', '$user_id', '$desa_id', '$tahun')";
    }

    if (mysqli_query($conn, $sql)) {
        // Tambahkan atau perbarui progres pengguna
        $query_progress = "SELECT id FROM user_progress WHERE user_id = '$user_id' AND form_name = 'Kejadian/bencana alam (mengganggu kehidupan dan menyebabkan kerugian bagi masyarakat) yang terjadi' AND tahun = '$tahun'";
        $result_progress = mysqli_query($conn, $query_progress);

        $created_at = $tahun . '-01-01 00:00:00';

        if (mysqli_num_rows($result_progress) > 0) {
            $update_progress = "UPDATE user_progress 
                                SET is_locked = TRUE, desa_id = '$desa_id', created_at = '$created_at', tahun = '$tahun' 
                                WHERE user_id = '$user_id' AND form_name = 'Kejadian/bencana alam (mengganggu kehidupan dan menyebabkan kerugian bagi masyarakat) yang terjadi' AND tahun = '$tahun'";
            mysqli_query($conn, $update_progress);
        } else {
            $insert_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id, created_at, tahun) 
                                VALUES ('$user_id', 'Kejadian/bencana alam (mengganggu kehidupan dan menyebabkan kerugian bagi masyarakat) yang terjadi', TRUE, '$desa_id', '$created_at', '$tahun')";
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
