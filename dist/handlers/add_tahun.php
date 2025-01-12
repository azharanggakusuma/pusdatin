<?php
include_once('../config/conn.php');
include "../config/session.php";

// Pastikan tahun ada dalam POST
if (isset($_POST['year'])) {
  $year = $_POST['year'];

  // Cek apakah tahun lebih kecil dari 2024
  if ($year < 2024) {
    header("Location: ../pages/tables/manage_tahun.php?messageadd=error&reason=before2024");
    exit();
  }

  // Cek apakah tahun sudah ada di database
  $query = "SELECT * FROM tahun WHERE year = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $year);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Jika tahun sudah ada
    header("Location: ../pages/tables/manage_tahun.php?messageadd=error&reason=exists");
  } else {
    // Jika tahun belum ada, tambahkan data
    $query = "INSERT INTO tahun (year) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $year);

    if ($stmt->execute()) {
      header("Location: ../pages/tables/manage_tahun.php?messageadd=success");
    } else {
      header("Location: ../pages/tables/manage_tahun.php?messageadd=error");
    }
  }

  $stmt->close();
} else {
  header("Location: ../pages/tables/manage_tahun.php?messageadd=error");
}

$conn->close();
?>
