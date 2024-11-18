<?php
include_once('../config/conn.php');

// Cek apakah ada ID yang diterima melalui URL
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    // Ambil data dari form
    $id = htmlspecialchars(trim($_GET['id']));
    $name = htmlspecialchars(trim($_POST['name']));
    $username = htmlspecialchars(trim($_POST['username']));
    
    // Menggunakan MD5 untuk password
    $password = !empty($_POST['password']) ? md5(trim($_POST['password'])) : null;
    
    $level = htmlspecialchars(trim($_POST['level']));

    // Debugging: Cek data yang diterima
    echo "ID: $id <br>";
    echo "Name: $name <br>";
    echo "Username: $username <br>";
    echo "Password: " . ($password ? "Updated" : "Not Changed") . "<br>";
    echo "Level: $level <br>";

    // Jika password ada, lakukan update dengan password baru
    if ($password) {
        $query = "UPDATE users SET name = ?, username = ?, password = ?, level = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $name, $username, $password, $level, $id);
    } else {
        // Jika password kosong, update data tanpa mengganti password
        $query = "UPDATE users SET name = ?, username = ?, level = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $name, $username, $level, $id);
    }

    // Eksekusi query dan periksa hasilnya
    if ($stmt->execute()) {
        header("Location: ../pages/tables/user.php?messageadd=success");
    } else {
        echo "Error: " . $stmt->error;
        header("Location: ../pages/tables/user.php?messageadd=error");
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
} else {
    header("Location: ../pages/tables/user.php");
}
?>
