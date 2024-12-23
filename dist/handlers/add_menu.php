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

        // Lokasi file template
        $templatePath = 'template_form.php'; // Sesuaikan lokasi template sesuai dengan struktur folder Anda

        // Cek dan buat file PHP dengan isi dari template
        $filePath = '../' . $url;
        if (!file_exists($filePath)) {
            // Membaca konten dari file template
            $templateContent = file_get_contents($templatePath);
            if ($templateContent === false) {
                die("Gagal membaca file template. Cek file dan izinnya.");
            }
            
            // Menulis konten template ke file baru
            if (file_put_contents($filePath, $templateContent) === false) {
                die("Tidak dapat menulis ke file. Cek izin folder.");
            }
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
