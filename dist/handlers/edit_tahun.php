<?php
include_once('../config/conn.php');
include "../config/session.php";

// Pastikan ID dan Tahun ada dalam POST
if (isset($_POST['id']) && isset($_POST['year'])) {
  $id = $_POST['id'];
  $year = $_POST['year'];

  // Cek apakah tahun lebih kecil dari 2024
  if ($year < 2024) {
    header("Location: ../pages/tables/manage_tahun.php?messageedit=error&reason=before2024");
    exit();
  }

  // Cek apakah tahun sudah ada di database, kecuali untuk ID yang sedang diedit
  $query = "SELECT * FROM tahun WHERE year = ? AND id != ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("si", $year, $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Jika tahun sudah ada
    header("Location: ../pages/tables/manage_tahun.php?messageedit=error&reason=exists");
  } else {
    // Jika tahun belum ada, update data
    $query = "UPDATE tahun SET year = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $year, $id);

    if ($stmt->execute()) {
      header("Location: ../pages/tables/manage_tahun.php?messageedit=success");
    } else {
      header("Location: ../pages/tables/manage_tahun.php?messageedit=error");
    }
  }

  $stmt->close();
} else {
  header("Location: ../pages/tables/manage_tahun.php?messageedit=error");
}

$conn->close();
?>
