<?php
include '../config/conn.php';
session_start();

$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

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

    // If no errors, proceed to database insertion
    $sql = "INSERT INTO tb_disabilitas (jumlah_tuna_netra, jumlah_tuna_rungu, jumlah_tuna_wicara, jumlah_tuna_rungu_wicara, jumlah_tuna_daksa, jumlah_tuna_grahita, jumlah_tuna_laras, jumlah_tuna_eks_kusta, jumlah_tuna_ganda, user_id, desa_id)
            VALUES ('$tuna_netra', '$tuna_rungu', '$tuna_wicara', '$tuna_rungu_wicara', '$tuna_daksa', '$tuna_grahita', '$tuna_laras', '$tuna_eks_kusta', '$tuna_ganda', '$user_id', '$desa_id')";

    if (mysqli_query($conn, $sql)) {
        $query_progress = "INSERT INTO user_progress (user_id, form_name, is_locked, desa_id)
                           VALUES ('$user_id', 'Banyaknya penyandang disabilitas', TRUE, '$desa_id')
                           ON DUPLICATE KEY UPDATE is_locked = TRUE, desa_id = '$desa_id'";
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
