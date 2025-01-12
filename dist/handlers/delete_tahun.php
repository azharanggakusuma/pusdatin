<?php
include_once('../config/conn.php');
include "../config/session.php";

// Pastikan ID tahun ada dalam POST
if (isset($_POST['id'])) {
  $id = $_POST['id'];

  // Query untuk menghapus data berdasarkan ID
  $query = "DELETE FROM tahun WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    header("Location: ../pages/tables/manage_tahun.php?messagedelete=success");
  } else {
    header("Location: ../pages/tables/manage_tahun.php?messagedelete=error");
  }

  $stmt->close();
} else {
  header("Location: ../pages/tables/manage_tahun.php?messagedelete=error");
}

$conn->close();
