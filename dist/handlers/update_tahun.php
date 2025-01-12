<?php
session_start();
include '../config/conn.php';

// Cek apakah form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tahun'])) {
    $tahun_aktif = trim($_POST['tahun']); // Ambil tahun yang dipilih

    // Simpan tahun yang dipilih dalam sesi
    $_SESSION['tahun'] = $tahun_aktif;

    // Redirect atau tampilkan pesan sukses
    header("Location: ../index.php"); 
    exit();
}
?>
