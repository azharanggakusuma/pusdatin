<?php
include '../config/conn.php';
session_start();

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
    // Retrieve and sanitize POST data
    $status_ruang_publik = $_POST['publicSpaceStatus'] ?? '';
    $ruang_terbuka_hijau = $_POST['greenSpace'] ?? NULL; // Optional, based on visibility
    $ruang_terbuka_non_hijau = $_POST['nonGreenSpace'] ?? NULL; // Optional, based on visibility

    // Check if the required fields are filled
    if (empty($status_ruang_publik)) {
        header("Location: ../pages/forms/sosial_budaya.php?status=error&message=Public space status required");
        exit();
    }

    // Prepared statement for inserting data
    $sql = "INSERT INTO tb_ruang_publik (status_ruang_publik, ruang_terbuka_hijau, ruang_terbuka_non_hijau, user_id, desa_id, tahun)
            VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssiis", $status_ruang_publik, $ruang_terbuka_hijau, $ruang_terbuka_non_hijau, $user_id, $desa_id, $tahun);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Insert or update progress
            $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id, tahun)
                               VALUES (?, 'Keberadaan Ruang publik terbuka yang peruntukan utamanya sebagai tempat bagi warga desa/kelurahan untuk bersantai/bermain tanpa perlu membayar (misalnya: lapangan terbuka/alun–alun, taman, dll.)', TRUE, ?, ?)
                               ON DUPLICATE KEY UPDATE is_locked = TRUE, desa_id = ?, tahun = ?";

            if ($stmt_progress = mysqli_prepare($conn, $query_progress)) {
                // Bind parameters for progress update
                mysqli_stmt_bind_param($stmt_progress, "siisi", $user_id, $desa_id, $tahun, $desa_id, $tahun);

                // Execute the progress query
                mysqli_stmt_execute($stmt_progress);
            } else {
                echo "Error preparing progress query: " . mysqli_error($conn);
                exit();
            }

            // Redirect on success
            header("Location: ../pages/forms/sosial_budaya.php?status=success");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);  // Output any error that occurs
            exit();
        }
    } else {
        echo "Error preparing query: " . mysqli_error($conn);  // Output any error that occurs
        exit();
    }
} else {
    header("Location: ../pages/forms/sosial_budaya.php?status=warning");
    exit();
}
?>
