<?php
// Ambil data dari form login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $password_enkripsi = md5($password); // Enkripsi password menggunakan md5

    // Include koneksi database
    include '../config/conn.php';

    // Query untuk cek user berdasarkan username dan password
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password_enkripsi'";
    $query = mysqli_query($conn, $sql) or die("SQL Login Error: " . mysqli_error($conn));
    $jumlahdata = mysqli_num_rows($query);

    if ($jumlahdata > 0) {
        $data = mysqli_fetch_array($query); // Ambil data user

        // Aktifkan session
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['idsesi'] = session_id();
        $_SESSION['level'] = $data['level'];
        $_SESSION['name'] = $data['name'];

        // Redirect ke login.php dengan parameter sukses
        header("Location: login.php?success=true");
        exit();
    } else {
        // Redirect ke login.php dengan parameter error
        header("Location: login.php?error=true");
        exit();
    }
}
?>
