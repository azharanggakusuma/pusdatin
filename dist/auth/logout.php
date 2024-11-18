<?php
session_start();

// Hancurkan session untuk pengguna yang logout
session_unset(); // Menghapus semua session variables
session_destroy(); // Menghancurkan session

// Redirect ke halaman login setelah logout
header("Location: login.php?logout=true");
exit();
?>
