<?php
include_once('../config/conn.php');

// Cek apakah ada ID yang diterima melalui URL
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    // Ambil data dari form
    $id = htmlspecialchars(trim($_GET['id']));
    $name = htmlspecialchars(trim($_POST['menu_name']));
    $url = htmlspecialchars(trim($_POST['menu_url']));
    $status = htmlspecialchars(trim($_POST['menu_status']));

    // Debugging: Cek data yang diterima
    echo "ID: $id <br>";
    echo "Name: $name <br>";
    echo "URL: $url <br>";
    echo "Status: $status <br>"; 

    // Update data menu
    $query = "UPDATE menu SET name = ?, url = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssii", $name, $url, $status, $id);

    // Eksekusi query dan periksa hasilnya
    if ($stmt->execute()) {
        header("Location: ../pages/tables/manage_menu.php?messageedit=success");
    } else {
        echo "Error: " . $stmt->error;
        header("Location: ../pages/tables/manage_menu.php?messageedit=error"); 
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
} else {
    header("Location: ../pages/tables/manage_menu.php"); 
}
?>
