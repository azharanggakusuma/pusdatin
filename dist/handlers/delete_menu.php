<?php
include_once('../config/conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Delete the menu from the database
    $query = "DELETE FROM menu WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../pages/tables/manage_menu.php?messagedelete=success");
    } else {
        header("Location: ../pages/tables/manage_menu.php?messagedelete=error");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../pages/tables/manage_menu.php");
}
?>
