<?php
include '../config/conn.php';
session_start();

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

$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize an array to collect errors
    $errors = [];

    // Helper function to check if input is set and is a number
    function validate_input($input) {
        return isset($input) && trim($input) !== '' ? (int)$input : null;
    }

    $tuna_netra = validate_input($_POST['tuna_netra']);
    $tuna_rungu = validate_input($_POST['tuna_rungu']);
    $tuna_wicara = validate_input($_POST['tuna_wicara']);
    $tuna_rungu_wicara = validate_input($_POST['tuna_rungu_wicara']);
    $tuna_daksa = validate_input($_POST['tuna_daksa']);
    $tuna_grahita = validate_input($_POST['tuna_grahita']);
    $tuna_laras = validate_input($_POST['tuna_laras']);
    $tuna_eks_kusta = validate_input($_POST['tuna_eks_kusta']);
    $tuna_ganda = validate_input($_POST['tuna_ganda']);

    // Check for null values and add errors
    if (is_null($tuna_netra)) $errors[] = "tuna netra";
    if (is_null($tuna_rungu)) $errors[] = "tuna rungu";
    if (is_null($tuna_wicara)) $errors[] = "tuna wicara";
    if (is_null($tuna_rungu_wicara)) $errors[] = "tuna rungu-wicara";
    if (is_null($tuna_daksa)) $errors[] = "tuna daksa";
    if (is_null($tuna_grahita)) $errors[] = "tuna grahita";
    if (is_null($tuna_laras)) $errors[] = "tuna laras";
    if (is_null($tuna_eks_kusta)) $errors[] = "tuna eks-kusta";
    if (is_null($tuna_ganda)) $errors[] = "tuna ganda";

    // If errors exist, redirect back with error message
    if (!empty($errors)) {
        $error_message = "Fields required: " . implode(", ", $errors);
        header("Location: ../pages/forms/sosial_budaya.php?status=error&message=" . urlencode($error_message));
        exit();
    }

    // Check if the record already exists for the same year
    $check_query = "SELECT id FROM tb_disabilitas WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // If record exists for the same year, update the existing record
        $sql = "UPDATE tb_disabilitas 
                SET jumlah_tuna_netra = '$tuna_netra', jumlah_tuna_rungu = '$tuna_rungu', jumlah_tuna_wicara = '$tuna_wicara', 
                    jumlah_tuna_rungu_wicara = '$tuna_rungu_wicara', jumlah_tuna_daksa = '$tuna_daksa', jumlah_tuna_grahita = '$tuna_grahita',
                    jumlah_tuna_laras = '$tuna_laras', jumlah_tuna_eks_kusta = '$tuna_eks_kusta', jumlah_tuna_ganda = '$tuna_ganda', tahun = '$tahun'
                WHERE user_id = '$user_id' AND desa_id = '$desa_id' AND tahun = '$tahun'";
    } else {
        // If record doesn't exist for the same year, insert a new record
        $sql = "INSERT INTO tb_disabilitas (jumlah_tuna_netra, jumlah_tuna_rungu, jumlah_tuna_wicara, jumlah_tuna_rungu_wicara, 
                                            jumlah_tuna_daksa, jumlah_tuna_grahita, jumlah_tuna_laras, jumlah_tuna_eks_kusta, 
                                            jumlah_tuna_ganda, user_id, desa_id, tahun)
                VALUES ('$tuna_netra', '$tuna_rungu', '$tuna_wicara', '$tuna_rungu_wicara', '$tuna_daksa', '$tuna_grahita', 
                        '$tuna_laras', '$tuna_eks_kusta', '$tuna_ganda', '$user_id', '$desa_id', '$tahun')";
    }

    if (mysqli_query($conn, $sql)) {
        // Check if progress entry exists for the same year
        $query_progress = "SELECT id FROM user_progress WHERE user_id = '$user_id' AND form_name = 'Banyaknya penyandang disabilitas' AND tahun = '$tahun'";
        $result_progress = mysqli_query($conn, $query_progress);

        // Set created_at to the first day of the year at 00:00:00
        $created_at = $tahun . '-01-01 00:00:00';

        if (mysqli_num_rows($result_progress) > 0) {
            // If progress entry exists for the same year, update it
            $update_progress = "UPDATE user_progress 
                                SET is_locked = TRUE, desa_id = '$desa_id', created_at = '$created_at', tahun = '$tahun' 
                                WHERE user_id = '$user_id' AND form_name = 'Banyaknya penyandang disabilitas' AND tahun = '$tahun'";
            mysqli_query($conn, $update_progress);
        } else {
            // If progress entry doesn't exist for the same year, insert a new entry
            $insert_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id, created_at, tahun) 
                                VALUES ('$user_id', 'Banyaknya penyandang disabilitas', TRUE, '$desa_id', '$created_at', '$tahun')";
            mysqli_query($conn, $insert_progress);
        }

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
