<?php
// Koneksi ke database
include '../config/conn.php'; // Sesuaikan dengan koneksi database Anda

// Query untuk mengambil jumlah pengunjung per bulan berdasarkan visit_time
$sql = "SELECT
            YEAR(visit_time) AS tahun,
            MONTH(visit_time) AS bulan,
            COUNT(*) AS jumlah_pengunjung
        FROM pengunjung
        GROUP BY YEAR(visit_time), MONTH(visit_time)
        ORDER BY tahun DESC, bulan DESC";

$result = mysqli_query($conn, $sql);
$pengunjungData = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Format data menjadi array untuk chart
    $pengunjungData[] = [
        'tanggal' => $row['tahun'] . '-' . str_pad($row['bulan'], 2, '0', STR_PAD_LEFT) . '-01', // Format tanggal YYYY-MM-01
        'jumlah_pengunjung' => $row['jumlah_pengunjung'],
    ];
}

// Encode data dalam format JSON
echo json_encode($pengunjungData);
?>
