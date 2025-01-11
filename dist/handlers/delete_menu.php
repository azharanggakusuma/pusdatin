<?php
include_once('../config/conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Ambil URL file dari database
    $query = "SELECT url FROM menu WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $filePath = '../' . $row['url']; // Tambahkan path relatif ke file

        // Hapus data dari database
        $deleteQuery = "DELETE FROM menu WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $id);

        if ($deleteStmt->execute()) {
            // Cek apakah file ada dan hapus file
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            header("Location: ../pages/tables/manage_menu.php?messagedelete=success");
        } else {
            header("Location: ../pages/tables/manage_menu.php?messagedelete=error");
        }

        $deleteStmt->close();
    } else {
        header("Location: ../pages/tables/manage_menu.php?messagedelete=notfound");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../pages/tables/manage_menu.php");
}
?>
