<?php
include 'config/conn.php';
session_start();

require __DIR__ . '/../vendor/autoload.php'; // Pastikan path ke autoload benar
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Mpdf\Mpdf;

// Cek apakah koneksi ke database berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil parameter jenis ekspor dan kode desa
$type = $_GET['type'] ?? null;
$kode_desa = $_GET['kode_desa'] ?? null;

// Query untuk mengambil data desa
$query = "
    SELECT
        tb_desa.kode_desa,
        tb_desa.nama_desa,
        tb_luas_wilayah_desa.luas_wilayah_desa
    FROM
        tb_desa
    LEFT JOIN
        tb_luas_wilayah_desa
    ON
        tb_desa.id_desa = tb_luas_wilayah_desa.desa_id
";
if ($kode_desa) {
    $query .= " WHERE tb_desa.kode_desa = '$kode_desa'";
}

// Menjalankan query
$result = mysqli_query($conn, $query);

// Fungsi untuk ekspor Excel
if ($type === 'excel') {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header tabel
    $sheet->setCellValue('A1', 'Kode Desa');
    $sheet->setCellValue('B1', 'Nama Desa');
    $sheet->setCellValue('C1', 'Luas Wilayah Desa (Hektar)');

    /// Style untuk header
$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D3D3D3']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
];
$sheet->getStyle('A1:C1')->applyFromArray($headerStyle);


    // Data dari database
    $rowNumber = 2;
    while ($row = mysqli_fetch_assoc($result)) {
        $sheet->setCellValue('A' . $rowNumber, $row['kode_desa']);
        $sheet->setCellValue('B' . $rowNumber, $row['nama_desa']);
        $sheet->setCellValue('C' . $rowNumber, $row['luas_wilayah_desa']);
        $rowNumber++;
    }

    // Style untuk semua tabel
    $tableStyle = [
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    ];
    $sheet->getStyle('A1:C' . ($rowNumber - 1))->applyFromArray($tableStyle);

    // Auto-size kolom
    foreach (range('A', 'C') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    // Kirim file Excel ke browser
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="data_desa.xlsx"');
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

// Fungsi untuk ekspor PDF
if ($type === 'pdf') {
    $mpdf = new Mpdf();

    $html = '<h1 style="text-align: center;">Data Desa dan Luas Wilayah</h1>';
    $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">';
    $html .= '<thead><tr style="background-color: #d3d3d3; text-align: center;">';
    $html .= '<th>Kode Desa</th><th>Desa/Kelurahan</th><th>Luas Wilayah Desa(Hektar)</th>';
    $html .= '</tr></thead><tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        $html .= '<tr>';
        $html .= '<td style="text-align: center;">' . htmlspecialchars($row['kode_desa']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nama_desa']) . '</td>';
        $html .= '<td style="text-align: center;">' . htmlspecialchars($row['luas_wilayah_desa']) . '</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';

    $mpdf->WriteHTML($html);
    $mpdf->Output('data_desa.pdf', 'D');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Data Desa</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">Data Desa dan Luas Wilayah</h2>

    <!-- Tombol Ekspor dengan Modal -->
    <div class="text-right mb-3">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exportModal">Export</button>
    </div>

    <!-- Tabel Data -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Kode Desa</th>
            <th>Nama Desa</th>
            <th>Luas Wilayah Desa (Hektar)</th>
        </tr>
        </thead>
        <tbody>
        <?php
        mysqli_data_seek($result, 0);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['kode_desa']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nama_desa']) . "</td>";
                echo "<td>" . htmlspecialchars($row['luas_wilayah_desa']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Tidak ada data.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Modal Export -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="GET">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Pilih Jenis Export</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="kode_desa">Pilih Desa:</label>
                    <select name="kode_desa" id="kode_desa" class="form-control">
                        <option value="">Semua Desa</option>
                        <?php
                        $desaResult = mysqli_query($conn, "SELECT kode_desa, nama_desa FROM tb_desa");
                        while ($desa = mysqli_fetch_assoc($desaResult)) {
                            echo "<option value='{$desa['kode_desa']}'>{$desa['nama_desa']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <!-- Untuk Ekspor Excel -->
                    <button type="submit" name="type" value="excel" class="btn btn-success">Export Excel</button>
                    <!-- Untuk Ekspor PDF -->
                    <button type="submit" name="type" value="pdf" class="btn btn-danger">Export PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
