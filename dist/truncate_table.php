<?php
include 'config/conn.php';

if (isset($_POST['table_name'])) {
    $table = $_POST['table_name'];
    $query = "TRUNCATE TABLE `$table`";

    if ($conn->query($query)) {
        echo "Isi tabel $table berhasil dihapus!";
    } else {
        echo "Gagal menghapus isi tabel $table!";
    }
}
?>
