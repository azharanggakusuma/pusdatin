<?php
require '../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_name = $_POST['menu_name'];
    $menu_status = $_POST['menu_status'];
    $menu_url = 'pages/forms/' . strtolower(str_replace(' ', '_', $menu_name)) . '.php';

    $query = "INSERT INTO menu (name, url, status) VALUES ('$menu_name', '$menu_url', '$menu_status')";
    if ($conn->query($query)) {
        header('Location: ../pages/tables/manage_menu.php?success=add');
    } else {
        echo "Error: " . $conn->error;
    }
}
?> 