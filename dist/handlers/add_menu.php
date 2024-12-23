<?php
include_once('../config/conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars(trim($_POST['menu_name']));
    $status = htmlspecialchars(trim($_POST['menu_status']));
    
    // Generate the URL based on the menu name
    $url = 'pages/forms/' . strtolower(str_replace(' ', '_', $name)) . '.php';

    // Query to insert the menu data into the database
    $query = "INSERT INTO menu (name, url, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $name, $url, $status);

    if ($stmt->execute()) {
        // Memastikan direktori ada
        $directoryPath = '../' . dirname($url);
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true); // Buat direktori dengan rekursif
        }

        // Cek dan buat file PHP kosong jika belum ada
        $filePath = '../' . $url;
        $fileHandle = fopen($filePath, 'w');
        if ($fileHandle === false) {
            die("Tidak dapat membuat file. Cek izin folder.");
        } else {
            fclose($fileHandle); // Menutup file yang telah berhasil dibuka
        }
        
        // Redirect back to the manage menu page with success message
        header("Location: ../pages/tables/manage_menu.php?messageadd=success");
    } else {
        // Redirect with error message if something goes wrong
        header("Location: ../pages/tables/manage_menu.php?messageadd=error");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../pages/tables/manage_menu.php");
}
?>
