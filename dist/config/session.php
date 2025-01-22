<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: auth/login.php");
    exit();
}

// Dapatkan data level dan nama dari session
$username = $_SESSION['username'];
$name = $_SESSION['name'];
$level = $_SESSION['level'];

// Ambil tahun dari session
$tahun = $_SESSION['tahun'] ?? date('Y');

// Tentukan deskripsi berdasarkan level
$role_description = ($level == 'admin') ? 'Admin' : 'Operator';

// Periksa apakah 'progress' ada di session, jika tidak set default 0
$progress = isset($_SESSION['progress']) ? $_SESSION['progress'] : 0;

// Mendapatkan alamat IP dan User Agent pengunjung
$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// Menyimpan data pengunjung ke dalam database
$sql_pengunjung = "INSERT INTO pengunjung (ip_address, user_agent) VALUES ('$ip_address', '$user_agent')";
mysqli_query($conn, $sql_pengunjung);

// Pastikan tidak ada error saat menjalankan query
if (mysqli_error($conn)) {
    // Log error jika ada masalah
    error_log("Error mencatat pengunjung: " . mysqli_error($conn));
}