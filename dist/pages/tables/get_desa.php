<?php
include_once('../../config/conn.php');

// Ambil parameter kecamatan
$kecamatan = $_GET['kecamatan'] ?? '';

// Query untuk mengambil desa berdasarkan kecamatan
$query = "SELECT kode_desa, nama_desa FROM tb_enumerator";
if (!empty($kecamatan)) {
    $query .= " WHERE kecamatan = '" . mysqli_real_escape_string($conn, $kecamatan) . "'";
}

$result = mysqli_query($conn, $query);
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Pastikan output dalam format JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
