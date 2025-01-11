<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../config/conn.php';
    session_start();

    // Ambil data dari form login
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $tahun = trim($_POST['tahun']); // Ambil tahun dari form login

    // Validasi user
    $password_enkripsi = sha1($password);
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password_enkripsi'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        $_SESSION['username'] = $username;
        $_SESSION['idsesi'] = session_id();
        $_SESSION['level'] = $data['level'];
        $_SESSION['name'] = $data['name'];
        $_SESSION['tahun'] = $tahun; // Menyimpan tahun yang dipilih ke session

        header("Location: login.php?success=true"); 
        exit();
    } else {
        header("Location: login.php?error=true");
        exit();
    }
}
