<?php
// Include koneksi database
include '../config/conn.php';

// Periksa apakah data dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $kode_desa = isset($_POST['kode_desa']) ? mysqli_real_escape_string($conn, $_POST['kode_desa']) : '';
    $nama_desa = isset($_POST['nama_desa']) ? mysqli_real_escape_string($conn, $_POST['nama_desa']) : '';

    // Validasi data
    if (!empty($kode_desa) && !empty($nama_desa)) {
        // Query untuk menambahkan data ke database
        $sql = "INSERT INTO tb_desa (kode_desa, nama_desa) VALUES ('$kode_desa', '$nama_desa')";

        if (mysqli_query($conn, $sql)) {
            // Redirect ke desa.php dengan status sukses
            header("Location: ../pages/forms/desa.php?status=success");
            exit();
        } else {
            // Redirect ke desa.php dengan status error
            header("Location: ../pages/forms/desa.php?status=error&message=" . urlencode(mysqli_error($conn)));
            exit();
        }
    } else {
        // Redirect ke desa.php dengan status warning
        header("Location: ../pages/forms/desa.php?status=warning");
        exit();
    }
}
?>
