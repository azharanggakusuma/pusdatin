<?php
include_once('../config/conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $query = "DELETE FROM user_progress WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute(); // Hapus data yang tergantung

    // Sekarang hapus user
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../pages/tables/user.php?messagedelete=success");
    } else {
        header("Location: ../pages/tables/user.php?messagedelete=error");
    }


    $stmt->close();
    $conn->close();
} else {
    header("Location: ../pages/tables/user.php");
}
