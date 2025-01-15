<?php
session_start();
include "../config/conn.php";

// Fungsi untuk menghindari SQL Injection dengan prepared statements
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Ambil user_id dari session berdasarkan username
$username = $_SESSION['username'] ?? '';
if (empty($username)) {
    echo "Username tidak ditemukan. Pastikan Anda telah login.";
    exit();
}

$query_user = "SELECT id FROM users WHERE username = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("s", $username);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if (!$result_user) {
    echo "Terjadi kesalahan saat mengambil data pengguna: " . $conn->error;
    exit();
}

$user = $result_user->fetch_assoc();
$user_id = $user['id'] ?? 0;

if ($user_id === 0) {
    echo "User ID tidak ditemukan.";
    exit();
}

// Ambil tahun dari session
$tahun = $_SESSION['tahun'] ?? null;
if (!$tahun) {
    echo "Tahun tidak ditemukan. Pastikan Anda telah login dengan memilih tahun.";
    exit();
}

// Ambil desa_id yang terkait dengan user dari tb_enumerator
$query_desa = "SELECT id_desa 
               FROM tb_enumerator 
               WHERE user_id = ?
               ORDER BY id_desa DESC 
               LIMIT 1";
$stmt_desa = $conn->prepare($query_desa);
$stmt_desa->bind_param("i", $user_id);
$stmt_desa->execute();
$result_desa = $stmt_desa->get_result();

if (!$result_desa) {
    echo "Terjadi kesalahan saat mengambil data desa: " . $conn->error;
    exit();
}

$desa = $result_desa->fetch_assoc();
$desa_id = $desa['id_desa'] ?? 0;

if ($desa_id === 0) {
    echo "Desa ID tidak ditemukan.";
    exit();
}

// Proses hanya jika metode request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil dan sanitasi input dari form
    $keberadaan_internet = sanitize_input($_POST['keberadaan_internet'] ?? '');

    // ============================
    // Bagian VALIDASI DASAR
    // ============================

    $errors = [];

    // 1) Validasi keberadaan_internet
    $allowed_options = ['Ada', 'Tidak Ada'];
    if (empty($keberadaan_internet) || !in_array($keberadaan_internet, $allowed_options)) {
        $errors[] = "Anda harus memilih keberadaan internet untuk warnet, game online, dan fasilitas lainnya.";
    }

    // Jika ada error, redirect dengan pesan error
    if (!empty($errors)) {
        $message = implode(" ", $errors);
        header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=error&message=" . urlencode($message));
        exit();
    }

    // Cek apakah data untuk tahun yang sama sudah ada di db
    $check_query = "SELECT id 
                    FROM tb_internet_transportasi 
                    WHERE user_id = ? 
                      AND desa_id = ? 
                      AND tahun = ?";
    $stmt_check = $conn->prepare($check_query);
    $stmt_check->bind_param("iis", $user_id, $desa_id, $tahun);
    $stmt_check->execute();
    $check_result = $stmt_check->get_result();

    if (!$check_result) {
        // Jika query cek gagal
        $error_message = "Terjadi kesalahan saat memeriksa data: " . $conn->error;
        header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=error&message=" . urlencode($error_message));
        exit();
    }

    if ($check_result->num_rows > 0) {
        // Jika sudah ada, lakukan update
        $sql = "UPDATE tb_internet_transportasi
                SET 
                    keberadaan_internet = ?
                WHERE user_id = ?
                  AND desa_id = ?
                  AND tahun = ?";
        $stmt_update = $conn->prepare($sql);
        $stmt_update->bind_param("siii", $keberadaan_internet, $user_id, $desa_id, $tahun);
        $execute_update = $stmt_update->execute();
    } else {
        // Jika belum ada, insert data baru
        $sql = "INSERT INTO tb_internet_transportasi (
                    keberadaan_internet, 
                    tahun, 
                    user_id, 
                    desa_id
                ) VALUES (
                    ?, 
                    ?, 
                    ?, 
                    ?
                )";
        $stmt_insert = $conn->prepare($sql);
        $stmt_insert->bind_param("siii", $keberadaan_internet, $tahun, $user_id, $desa_id);
        $execute_update = $stmt_insert->execute();
    }

    if ($execute_update) {
        // Kelola user_progress: menandakan form ini sudah diisi
        $query_progress = "SELECT id
                           FROM user_progress
                           WHERE user_id = ?
                             AND form_name = 'Keberadaan Internet'
                             AND tahun = ?";
        $stmt_progress = $conn->prepare($query_progress);
        $stmt_progress->bind_param("is", $user_id, $tahun);
        $stmt_progress->execute();
        $result_progress = $stmt_progress->get_result();

        if (!$result_progress) {
            $error_message = "Terjadi kesalahan saat memeriksa progress: " . $conn->error;
            header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=error&message=" . urlencode($error_message));
            exit();
        }

        $created_at = $tahun . '-01-01 00:00:00';

        if ($result_progress->num_rows > 0) {
            // Update progress jika sudah ada
            $update_progress = "UPDATE user_progress
                                SET 
                                    is_locked = TRUE,
                                    desa_id = ?,
                                    created_at = ?,
                                    tahun = ?
                                WHERE user_id = ?
                                  AND form_name = 'Keberadaan Internet'
                                  AND tahun = ?";
            $stmt_update_progress = $conn->prepare($update_progress);
            $stmt_update_progress->bind_param("issii", $desa_id, $created_at, $tahun, $user_id, $tahun);
            if (!$stmt_update_progress->execute()) {
                $error_message = "Terjadi kesalahan saat memperbarui progress: " . $conn->error;
                header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=error&message=" . urlencode($error_message));
                exit();
            }
        } else {
            // Insert progress jika belum ada
            $insert_progress = "INSERT INTO user_progress (
                                    user_id, 
                                    form_name, 
                                    is_locked, 
                                    desa_id, 
                                    created_at, 
                                    tahun
                                ) VALUES (
                                    ?, 
                                    'Keberadaan Internet', 
                                    TRUE, 
                                    ?, 
                                    ?, 
                                    ?
                                )";
            $stmt_insert_progress = $conn->prepare($insert_progress);
            $stmt_insert_progress->bind_param("iisi", $user_id, $desa_id, $created_at, $tahun);
            if (!$stmt_insert_progress->execute()) {
                $error_message = "Terjadi kesalahan saat menambahkan progress: " . $conn->error;
                header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=error&message=" . urlencode($error_message));
                exit();
            }
        }

        // Sukses simpan
        header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=success");
        exit();
    } else {
        // Gagal eksekusi query
        $error_message = "Terjadi kesalahan saat menyimpan data: " . $conn->error;
        header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=error&message=" . urlencode($error_message));
        exit();
    }
} else {
    // Jika bukan method POST
    header("Location: ../pages/forms/angkutan,_komunikasi,_dan_informasi.php?status=warning");
    exit();
}
?>
