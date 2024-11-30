<?php
include_once('../config/conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = sha1(trim($_POST['password']));
    $level = htmlspecialchars(trim($_POST['level']));

    // Query untuk insert data
    $query = "INSERT INTO users (name, username, password, level) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $name, $username, $password, $level);

    if ($stmt->execute()) {
        // Redirect kembali ke halaman user dengan pesan sukses
        header("Location: ../pages/tables/user.php?messageadd=success");
    } else {
        // Redirect dengan pesan error
        header("Location: ../pages/tables/user.php?messageadd=error");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../pages/tables/user.php");
}
?>
