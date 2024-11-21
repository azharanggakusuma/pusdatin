<?php

// Ambil data pengguna yang sedang login
$username = $_SESSION['username'] ?? '';
$level = $_SESSION['level'] ?? ''; // Ambil level pengguna

$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Cek apakah form sudah terkunci
$is_locked = false; // Default tidak terkunci
if ($level !== 'admin') { // Logika kunci hanya berlaku untuk level user
    $query_progress = "SELECT is_locked FROM user_progress WHERE user_id = '$user_id' AND form_name = 'desa'";
    $result_progress = mysqli_query($conn, $query_progress);
    $progress = mysqli_fetch_assoc($result_progress);
    $is_locked = $progress['is_locked'] ?? false;
}
?>