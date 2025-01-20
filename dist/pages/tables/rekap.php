<?php
include_once('../../config/conn.php');
include "../../config/session.php";

require __DIR__ . '/../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Mpdf\Mpdf;

// Ambil parameter jenis ekspor, kode desa, kecamatan, dan filter tahun
$type = $_GET['type'] ?? null;
$kode_desa = $_GET['kode_desa'] ?? null;
$kode_kecamatan = $_GET['kode_kecamatan'] ?? null;
$filter_tahun = $_GET['filter_tahun'] ?? null;

// Query dasar
$query = "
    SELECT DISTINCT 
        tb_enumerator.kode_desa,
        tb_enumerator.nama_desa,
        tb_enumerator.kecamatan,
        tb_sk_pembentukan.sk_pembentukan,
        tb_sk_pembentukan.tahun
    FROM
        tb_enumerator
    LEFT JOIN
        tb_sk_pembentukan
        ON tb_enumerator.id_desa = tb_sk_pembentukan.desa_id
    LEFT JOIN
        (
            SELECT DISTINCT desa_id, tahun 
            FROM user_progress
        ) AS filtered_user_progress
        ON tb_enumerator.id_desa = filtered_user_progress.desa_id
        AND tb_sk_pembentukan.tahun = filtered_user_progress.tahun
";

// Tambahkan filter berdasarkan input pengguna
$where = [];
if (!empty($kode_kecamatan)) {
    $where[] = "tb_enumerator.kecamatan = '" . mysqli_real_escape_string($conn, $kode_kecamatan) . "'";
}
if (!empty($kode_desa)) {
    $where[] = "tb_enumerator.kode_desa = '" . mysqli_real_escape_string($conn, $kode_desa) . "'";
}
if (!empty($filter_tahun)) {
    $where[] = "tb_sk_pembentukan.tahun = '" . mysqli_real_escape_string($conn, $filter_tahun) . "'";
}

if (!empty($where)) {
    $query .= " WHERE " . implode(' AND ', $where);
}

// Eksekusi query
$result = mysqli_query($conn, $query) or die("Error: " . mysqli_error($conn));

// Fungsi untuk ekspor Excel
if ($type === 'excel') {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header tabel
    $sheet->setCellValue('A1', 'Kode Desa');
    $sheet->setCellValue('B1', 'Nama Desa');
    $sheet->setCellValue('C1', 'Kecamatan');
    $sheet->setCellValue('D1', 'Sk Pembentukan');
    $sheet->setCellValue('E1', 'Tahun');

    // Style untuk header
    $headerStyle = [
        'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D3D3D3']],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

    // Data dari database
    $rowNumber = 2;
    while ($row = mysqli_fetch_assoc($result)) {
        $sheet->setCellValue('A' . $rowNumber, $row['kode_desa']);
        $sheet->setCellValue('B' . $rowNumber, $row['nama_desa']);
        $sheet->setCellValue('C' . $rowNumber, $row['kecamatan']);
        $sheet->setCellValue('D' . $rowNumber, $row['sk_pembentukan']);
        $sheet->setCellValue('E' . $rowNumber, $row['tahun']);
        $rowNumber++;
    }

    // Style untuk semua tabel
    $tableStyle = [
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    ];
    $sheet->getStyle('A1:E' . ($rowNumber - 1))->applyFromArray($tableStyle);

    // Auto-size columns
    foreach (range('A', 'E') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    // Membersihkan buffer output
    if (ob_get_level()) {
        ob_end_clean();
    }

    // Kirim file Excel ke browser
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="rekap_data_pusdatin.xlsx"');
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

// Fungsi untuk ekspor PDF
if ($type === 'pdf') {
    $mpdf = new Mpdf(['format' => 'A4-L']); // Set ukuran kertas A4 dengan orientasi landscape

    $html = '<h1 style="text-align: center;">Rekap Data</h1>';
    $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">';
    $html .= '<thead><tr style="background-color: #d3d3d3; text-align: center;">';
    $html .= '<th>Kode Desa</th>';
    $html .= '<th>Nama Desa</th>';
    $html .= '<th>Kecamatan</th>';
    $html .= '<th>Sk Pembentukan</th>';
    $html .= '<th>Tahun</th>';
    $html .= '</tr></thead><tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        $html .= '<tr>';
        $html .= '<td style="text-align: center;">' . htmlspecialchars($row['kode_desa']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['nama_desa']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['kecamatan']) . '</td>';
        $html .= '<td style="text-align: center;">' . htmlspecialchars($row['sk_pembentukan']) . '</td>';
        $html .= '<td style="text-align: center;">' . htmlspecialchars($row['tahun']) . '</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';

    $mpdf->WriteHTML($html);
    $mpdf->Output('rekap_data_pusdatin.pdf', 'D');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>PUSDATIN | Rekap Data</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE 4 | General Form Elements">
    <meta name="author" content="ColorlibHQ">
    <meta name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard">
    <!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">
    <!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css"
        integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
        integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
    <!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../../../dist/css/adminlte.css"><!--end::Required Plugin(AdminLTE)-->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="../../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="../../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="../../plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="../../plugins/dropzone/min/dropzone.min.css">
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Animate.css CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="shortcut icon" href="../../img/kominfo.png" type="image/x-icon">
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> <!--begin::Header-->

        <?php include('../../components/navbar.php'); ?>

        <?php include('../../components/sidebar.php'); ?>
        <!--end::Sidebar--> <!--begin::App Main-->

        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Data Report</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Data Report
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content Header--> <!--begin::App Content-->

            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Manage Report</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-toggle="modal"
                                    data-target="#filterModal">
                                    <i class="fas fa-filter"></i>&nbsp; Filter
                                </button>
                                <button type="button" class="btn btn-tool" data-toggle="modal"
                                    data-target="#exportModal">
                                    <i class="fas fa-download"></i>&nbsp; Export
                                </button>
                                <button type="button" class="btn btn-tool" data-toggle="modal"
                                    data-target="#previewModal">
                                    <i class="fas fa-table"></i> &nbsp; Preview
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0" style="overflow-x: auto;">
                            <table class="table table-striped" style="table-layout: auto; width: 100%;">
                                <thead>
                                    <tr style="white-space: nowrap;">
                                        <th rowspan="2">#</th>
                                        <th rowspan="2">Periode Tahun</th>
                                        <th rowspan="2">Kode Desa</th>
                                        <th rowspan="2">Nama Desa</th>
                                        <th rowspan="2">Kecamatan</th>
                                        <th rowspan="2">Sk Pembentukan/Pengesahan Desa/Kelurahan</th>
                                        <th rowspan="2">Alamat Balai Desa/Kantor Kelurahan</th>
                                        <th colspan="2">Batas Utara</th>
                                        <th colspan="2">Batas Selatan</th>
                                        <th colspan="2">Batas Timur</th>
                                        <th colspan="2">Batas Barat</th>
                                        <th rowspan="2">Jarak ke Ibu Kota Kecamatan (km)</th>
                                        <th rowspan="2">Jarak ke Ibu Kota Kabupaten (km)</th>
                                        <th rowspan="2">Status Desa Membangun</th>
                                        <th rowspan="2">Alamat Website Desa</th>
                                        <th rowspan="2">Alamat Email Desa</th>
                                        <th rowspan="2">Alamat Facebook Desa</th>
                                        <th rowspan="2">Alamat Twitter Desa</th>
                                        <th rowspan="2">Alamat YouTube Desa</th>
                                        <th rowspan="2">Status Pemerintahan</th>
                                        <th rowspan="2">Penetapan Batas Desa</th>
                                        <th rowspan="2">No SK/Perbup/Perda/Perdes tentang Penetapan Batas Desa</th>
                                        <th rowspan="2">Ketersediaan Peta Desa</th>
                                        <th rowspan="2">No SK/Perbup/Perda tentang Peta Desa</th>
                                        <th rowspan="2">Jumlah Dusun/Lingkungan/Sebutan Lain yang sejenis</th>
                                        <th rowspan="2">Banyaknya RW</th>
                                        <th rowspan="2">Banyaknya RT</th>
                                        <th rowspan="2">Luas Wilayah Desa</th>
                                        <th rowspan="2">Topografi Terluas Wilayah Desa</th>
                                        <th rowspan="2">Keberadaan kantor kepala desa/lurah</th>
                                        <th rowspan="2">Status Kantor Kepala Desa/Lurah</th>
                                        <th rowspan="2">Kondisi Kantor Kepala Desa/Balai Desa</th>
                                        <th rowspan="2">Lokasi Kantor Kepala Desa/Lurah</th>
                                        <th rowspan="2">Koordinat Lintang (Latitude)</th>
                                        <th rowspan="2">Koordinat Bujur (Longitude)</th>
                                        <th rowspan="2">Jumlah Surat Kematian Yang Dikeluarkan</th>
                                        <th rowspan="2">Jumlah Penduduk Laki-Laki</th>
                                        <th rowspan="2">Jumlah Penduduk Perempuan</th>
                                        <th rowspan="2">Jumlah Kepala Keluarga</th>
                                        <th rowspan="2">Keberadaan Warga Desa/Kelurahan yang Sedang Bekerja sebagai PMI
                                            (Pekerja Migran Indonesia)/TKI di Luar Negeri</th>
                                        <th rowspan="2">Keberadaan Agen (Seseorang/Sekelompok Orang/Perusahaan)
                                            Pengerahan Pekerja Migran Indonesia/TKI ke Luar Negeri di Desa/Kelurahan
                                        </th>
                                        <th rowspan="2">Layanan Rekomendasi/Surat Keterangan Bagi Warga Desa/Kelurahan
                                            yang Akan Bekerja Sebagai Pekerja Migran Indonesia/TKI di Luar Negeri</th>
                                        <th rowspan="2">Keberadaan Warga Negara Asing (WNA) di Desa/Kelurahan</th>
                                        <th rowspan="2">Jumlah Keluarga Pengguna Listrik PLN (Perusahaan Listrik Negara)
                                        </th>
                                        <th rowspan="2">Jumlah Keluarga Pengguna Listrik Non-PLN</th>
                                        <th rowspan="2">Jumlah Keluraga Bukan Pengguna Listrik
                                        </th>
                                        <th rowspan="2">Keluarga yang Menggunakan Lampu Tenaga Surya
                                        </th>
                                        <th rowspan="2">Penerangan di Jalan Desa/Kelurahan yang Menggunakan Lampu Tenaga
                                            Surya</th>
                                        <th rowspan="2">Penerangan di Jalan Utama Desa/Kelurahan</th>
                                        <th rowspan="2">Sumber Penerangan di Jalan Utama Desa/Kelurahan</th>
                                        <th rowspan="2">Keberadaan Tempat Pembuangan Sampah Sementara (TPS)</th>
                                        <th rowspan="2">Tempat Penampungan Sementara Reduce, Reuse, Recycle (TPS3R)</th>
                                        <th rowspan="2">Keberadaan Bank Sampah di Desa/Kelurahan</th>
                                        <th rowspan="2">Wilayah desa/kelurahan dilalui saluran udara tegangan ekstra
                                            tinggi (SUTET) / Saluran Udara Tegangan Tinggi (SUUT) / Saluran Udara
                                            Tegangan Tinggi Arus Searah (SUTTAS)</th>
                                        <th rowspan="2">Keberadaan Pemukiman Di Bawah SUTET/SUTT/SUTTAS</th>
                                        <th rowspan="2">Jumlah Pemukiman di Bawah SUTET/SUTT/SUTTAS</th>
                                        <th rowspan="2">Keberadaan Sungai Yang Melintasi</th>
                                        <th rowspan="2">Nama Sungai Yang Melintasi ke 1</th>
                                        <th rowspan="2">Nama Sungai Yang Melintasi ke 2</th>
                                        <th rowspan="2">Nama Sungai Yang Melintasi ke 3</th>
                                        <th rowspan="2">Nama Sungai Yang Melintasi ke 4</th>
                                        <th rowspan="2">Keberadaan Danau/Waduk/Situ Yang Berada Di Wilayah Desa</th>
                                        <th rowspan="2">Nama danau/waduk/situ yang berada di wilayah desa ke 1</th>
                                        <th rowspan="2">Nama danau/waduk/situ yang berada di wilayah desa ke 2</th>
                                        <th rowspan="2">Nama danau/waduk/situ yang berada di wilayah desa ke 3</th>
                                        <th rowspan="2">Nama danau/waduk/situ yang berada di wilayah desa ke 4</th>
                                        <th rowspan="2">Keberadaan Pemukiman Di Bantaran Sungai</th>
                                        <th rowspan="2">Jumlah Pemukiman Di Bantaran Sungai</th>
                                        <th rowspan="2">Jumlah Embung</th>
                                        <th rowspan="2">Lokasi Mata Air</th>
                                        <th rowspan="2">Keberadaan Permukiman Kumuh (Sanitasi Lingkungan Buruk, Bangunan
                                            Padat Dan Sebagian Besar Tidak Layak Huni)Di Desa/Kelurahan</th>
                                        <th rowspan="2">Jumlah Pemukiman Kumuh</th>
                                        <th rowspan="2">Keberadaan Lokasi Penggalian Golongan C (Misalnya: Batu Kali,
                                            Pasir, Kapur, Kaolin, Pasir Kuarsa, Tanah Liat, Dll.)</th>
                                        <th rowspan="2">Jumlah Sarana Prasarana Kebersihan</th>
                                        <th rowspan="2">Jumlah Rumah Tidak Layak Huni</th>
                                        <th rowspan="2">Tanah Longsor</th>
                                        <th rowspan="2">Banjir</th>
                                        <th rowspan="2">Banjir Bandang</th>
                                        <th rowspan="2">Gempa Bumi</th>
                                        <th rowspan="2">Tsunami</th>
                                        <th rowspan="2">Gelombang Pasang</th>
                                        <th rowspan="2">Angin Puyuh</th>
                                        <th rowspan="2">Gunung Meletus</th>
                                        <th rowspan="2">Kebakaran Hutan</th>
                                        <th rowspan="2">Kekeringan</th>
                                        <th rowspan="2">Abrasi</th>
                                        <th rowspan="2">Sistem Peringatan Dini Bencana Alam</th>
                                        <th rowspan="2">Sistem Peringatan Dini Khusus Tsunami</th>
                                        <th rowspan="2">Perlengkapan Keselamatan (Perahu Karet, Tenda, Masker, dll)</th>
                                        <th rowspan="2">Rambu-Rambu dan Jalur Evakuasi Bencana</th>
                                        <th rowspan="2">Pembuatan, Perawatan, atau Normalisasi (Sungai, Kanal, Tanggul,
                                            Parit, Drainase, Waduk, Pantai, dll.)</th>
                                        <th rowspan="2">Keberadaan Taman Bacaan Masyarakat (TBM) / Perpustakaan Desa</th>
                                        <th rowspan="2">Keberadaan Bidan Desa yang menetap di Desa/Kelurahan</th>
                                        <th rowspan="2">Keberadaan Dukun Bayi/Paraji yang menetap di Desa/Kelurahan</th>
                                        <th rowspan="2">Muntaber/diare</th>
                                        <th rowspan="2">Demam Berdarah</th>
                                        <th rowspan="2">Campak</th>
                                        <th rowspan="2">Malaria</th>
                                        <th rowspan="2">Flu Burung/SARS</th>
                                        <th rowspan="2">Hepatitis E</th>
                                        <th rowspan="2">Difteri</th>
                                        <th rowspan="2">Corona/COVID-19	</th>
                                        <th rowspan="2">Lainnya</th>
                                        <th rowspan="2">Lainnya (Status)</th>
                                    </tr>
                                    <tr style="white-space: nowrap;">
                                        <th>Wilayah</th>
                                        <th>Kecamatan</th>
                                        <th>Wilayah</th>
                                        <th>Kecamatan</th>
                                        <th>Wilayah</th>
                                        <th>Kecamatan</th>
                                        <th>Wilayah</th>
                                        <th>Kecamatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Filter data berdasarkan tahun
                                    $filter_tahun = isset($_GET['filter_tahun']) ? intval($_GET['filter_tahun']) : null;

                                    // Query untuk mengambil data desa
                                    $query = "
                                            SELECT 
                                        filtered_progress.tahun,
                                        tb_enumerator.kode_desa,
                                        tb_enumerator.nama_desa,
                                        tb_enumerator.kecamatan,
                                        tb_sk_pembentukan.sk_pembentukan,
                                        tb_balai_desa.alamat_balai,
                                        tb_batas_desa.batas_utara,
                                        tb_batas_desa.kec_utara,
                                        tb_batas_desa.batas_selatan,
                                        tb_batas_desa.kec_selatan,
                                        tb_batas_desa.batas_timur,
                                        tb_batas_desa.kec_timur,
                                        tb_batas_desa.batas_barat,
                                        tb_batas_desa.kec_barat,
                                        tb_jarak_kantor_desa.jarak_ke_ibukota_kecamatan,
                                        tb_jarak_kantor_desa.jarak_ke_ibukota_kabupaten,
                                        tb_idm_status.status_idm,
                                        tb_website_medsos.alamat_website,
                                        tb_website_medsos.alamat_email,
                                        tb_website_medsos.alamat_facebook,
                                        tb_website_medsos.alamat_twitter,
                                        tb_website_medsos.alamat_youtube,
                                        tb_status_pemerintahan.status_pemerintahan,
                                        tb_ketersediaan_penetapan_peta_desa.penetapan_batas_desa,
                                        tb_ketersediaan_penetapan_peta_desa.no_surat_batas_desa,
                                        tb_ketersediaan_penetapan_peta_desa.ketersediaan_peta_desa,
                                        tb_ketersediaan_penetapan_peta_desa.no_surat_peta_desa,
                                        tb_banyaknya_dusun_rt_rw.jumlah_dusun,
                                        tb_banyaknya_dusun_rt_rw.jumlah_rw,
                                        tb_banyaknya_dusun_rt_rw.jumlah_rt,
                                        tb_luas_wilayah_desa.luas_wilayah_desa,
                                        tb_topografi_terluas_wilayah_desa.topografi_terluas_wilayah_desa,
                                        tb_kepemilikan_kantor.keberadaan_kantor,
                                        tb_kepemilikan_kantor.status_kantor,
                                        tb_kepemilikan_kantor.kondisi_kantor,
                                        tb_kepemilikan_kantor.lokasi_kantor,
                                        tb_titik_koordinat_kantor_desa.koordinat_lintang,
                                        tb_titik_koordinat_kantor_desa.koordinat_bujur,
                                        tb_kematian.jumlah_surat_kematian,
                                        tb_penduduk_dan_keluarga.jumlah_penduduk_laki,
                                        tb_penduduk_dan_keluarga.jumlah_penduduk_perempuan,
                                        tb_penduduk_dan_keluarga.jumlah_kepala_keluarga,
                                        tb_ketenagakerjaan.pmi_bekerja,
                                        tb_ketenagakerjaan.agen_pengerahan_pmi,
                                        tb_ketenagakerjaan.layanan_rekomendasi_pmi,
                                        tb_ketenagakerjaan.keberadaan_wna,
                                        tb_pengguna_listrik_lampu_surya.jumlah_pln,
                                        tb_pengguna_listrik_lampu_surya.jumlah_non_pln,
                                        tb_pengguna_listrik_lampu_surya.jumlah_bukan_pengguna_listrik,
                                        tb_pengguna_listrik_lampu_surya.penggunaan_lampu_tenaga_surya,
                                        tb_penerangan_jalan.lampu_tenaga_surya,
                                        tb_penerangan_jalan.penerangan_jalan_utama,
                                        tb_penerangan_jalan.sumber_penerangan,
                                        tb_pengelolaan_sampah.tps,
                                        tb_pengelolaan_sampah.tps3r,
                                        tb_pengelolaan_sampah.bank_sampah,
                                        tb_sutet.sutet_status,
                                        tb_sutet.keberadaan_pemukiman AS keberadaan_pemukiman_sutet,
                                        tb_sutet.jumlah_pemukiman AS jumlah_pemukiman_sutet,
                                        tb_keberadaan_sungai.keberadaan_sungai,
                                        tb_keberadaan_sungai.nama_sungai_1,
                                        tb_keberadaan_sungai.nama_sungai_2,
                                        tb_keberadaan_sungai.nama_sungai_3,
                                        tb_keberadaan_sungai.nama_sungai_4,
                                        tb_keberadaan_danau.keberadaan_danau,
                                        tb_keberadaan_danau.nama_danau_1,
                                        tb_keberadaan_danau.nama_danau_2,
                                        tb_keberadaan_danau.nama_danau_3,
                                        tb_keberadaan_danau.nama_danau_4,
                                        tb_keberadaan_pemukiman_bantaran.keberadaan_pemukiman AS keberadaan_pemukiman_bantaran,
                                        tb_keberadaan_pemukiman_bantaran.jumlah_pemukiman AS jumlah_pemukiman_bantaran,
                                        tb_embung_mata_air.jumlah_embung,
                                        tb_embung_mata_air.lokasi_mata_air,
                                        tb_permukiman_kumuh.keberadaan_kumuh,
                                        tb_permukiman_kumuh.jumlah_kumuh,
                                        tb_lokasi_penggalian.keberadaan_galian,
                                        tb_prasarana_kebersihan.jumlah_prasarana,
                                        tb_rumah_tidak_layak_huni.jumlah_rumah,
                                        tb_bencana_alam.tanah_longsor,
                                        tb_bencana_alam.banjir,
                                        tb_bencana_alam.banjir_bandang,
                                        tb_bencana_alam.gempa_bumi,
                                        tb_bencana_alam.tsunami,
                                        tb_bencana_alam.gelombang_pasang,
                                        tb_bencana_alam.angin_puyuh,
                                        tb_bencana_alam.gunung_meletus,
                                        tb_bencana_alam.kebakaran_hutan,
                                        tb_bencana_alam.kekeringan,
                                        tb_bencana_alam.abrasi,
                                        tb_peringatan_bencana.peringatan_dini,
                                        tb_peringatan_bencana.peringatan_tsunami,
                                        tb_peringatan_bencana.perlengkapan_keselamatan,
                                        tb_peringatan_bencana.rambu_evakuasi,
                                        tb_peringatan_bencana.infrastruktur,
                                        tb_taman_bacaan.keberadaan_tbm,
                                        tb_keberadaan_bidan.keberadaan_bidan,
                                        tb_keberadaan_dukun_bayi.keberadaan_dukun_bayi,
                                        tb_klb_wabah.muntaber_diare,
                                        tb_klb_wabah.demam_berdarah,
                                        tb_klb_wabah.campak,
                                        tb_klb_wabah.malaria,
                                        tb_klb_wabah.flu_burung_sars,
                                        tb_klb_wabah.hepatitis_e,
                                        tb_klb_wabah.difteri,
                                        tb_klb_wabah.corona_covid19,
                                        tb_klb_wabah.lainnya_name,
                                        tb_klb_wabah.lainnya_status
                                    FROM
                                        (
                                            SELECT 
                                                desa_id,
                                                tahun,
                                                MIN(id) AS min_id
                                            FROM
                                                user_progress
                                            WHERE
                                                tahun IS NOT NULL
                                            GROUP BY desa_id, tahun
                                        ) AS filtered_progress
                                    LEFT JOIN
                                        tb_enumerator ON filtered_progress.desa_id = tb_enumerator.id_desa
                                    LEFT JOIN
                                        tb_sk_pembentukan ON filtered_progress.desa_id = tb_sk_pembentukan.desa_id
                                        AND filtered_progress.tahun = tb_sk_pembentukan.tahun
                                    LEFT JOIN
                                        tb_balai_desa ON filtered_progress.desa_id = tb_balai_desa.desa_id
                                        AND filtered_progress.tahun = tb_balai_desa.tahun
                                    LEFT JOIN
                                        tb_batas_desa ON filtered_progress.desa_id = tb_batas_desa.desa_id
                                        AND filtered_progress.tahun = tb_batas_desa.tahun
                                    LEFT JOIN
                                        tb_jarak_kantor_desa ON filtered_progress.desa_id = tb_jarak_kantor_desa.desa_id
                                        AND filtered_progress.tahun = tb_jarak_kantor_desa.tahun
                                    LEFT JOIN
                                        tb_idm_status ON filtered_progress.desa_id = tb_idm_status.desa_id
                                        AND filtered_progress.tahun = tb_idm_status.tahun
                                    LEFT JOIN
                                        tb_website_medsos ON filtered_progress.desa_id = tb_website_medsos.desa_id
                                        AND filtered_progress.tahun = tb_website_medsos.tahun
                                    LEFT JOIN
                                        tb_status_pemerintahan ON filtered_progress.desa_id = tb_status_pemerintahan.desa_id
                                        AND filtered_progress.tahun = tb_status_pemerintahan.tahun
                                    LEFT JOIN
                                        tb_ketersediaan_penetapan_peta_desa ON filtered_progress.desa_id = tb_ketersediaan_penetapan_peta_desa.desa_id
                                        AND filtered_progress.tahun = tb_ketersediaan_penetapan_peta_desa.tahun
                                    LEFT JOIN
                                        tb_banyaknya_dusun_rt_rw ON filtered_progress.desa_id = tb_banyaknya_dusun_rt_rw.desa_id
                                        AND filtered_progress.tahun = tb_banyaknya_dusun_rt_rw.tahun
                                    LEFT JOIN
                                        tb_luas_wilayah_desa ON filtered_progress.desa_id = tb_luas_wilayah_desa.desa_id
                                        AND filtered_progress.tahun = tb_luas_wilayah_desa.tahun
                                    LEFT JOIN
                                        tb_topografi_terluas_wilayah_desa ON filtered_progress.desa_id = tb_topografi_terluas_wilayah_desa.desa_id
                                        AND filtered_progress.tahun = tb_topografi_terluas_wilayah_desa.tahun
                                    LEFT JOIN
                                        tb_kepemilikan_kantor ON filtered_progress.desa_id = tb_kepemilikan_kantor.desa_id
                                        AND filtered_progress.tahun = tb_kepemilikan_kantor.tahun
                                    LEFT JOIN
                                        tb_titik_koordinat_kantor_desa ON filtered_progress.desa_id = tb_titik_koordinat_kantor_desa.desa_id
                                        AND filtered_progress.tahun = tb_titik_koordinat_kantor_desa.tahun
                                    LEFT JOIN
                                        tb_kematian ON filtered_progress.desa_id = tb_kematian.desa_id
                                        AND filtered_progress.tahun = tb_kematian.tahun
                                    LEFT JOIN
                                        tb_penduduk_dan_keluarga ON filtered_progress.desa_id = tb_penduduk_dan_keluarga.desa_id
                                        AND filtered_progress.tahun = tb_penduduk_dan_keluarga.tahun
                                    LEFT JOIN
                                        tb_ketenagakerjaan ON filtered_progress.desa_id = tb_ketenagakerjaan.desa_id
                                        AND filtered_progress.tahun = tb_ketenagakerjaan.tahun
                                    LEFT JOIN
                                        tb_pengguna_listrik_lampu_surya ON filtered_progress.desa_id = tb_pengguna_listrik_lampu_surya.desa_id
                                        AND filtered_progress.tahun = tb_pengguna_listrik_lampu_surya.tahun
                                    LEFT JOIN
                                        tb_penerangan_jalan ON filtered_progress.desa_id = tb_penerangan_jalan.desa_id
                                        AND filtered_progress.tahun = tb_penerangan_jalan.tahun
                                    LEFT JOIN
                                        tb_pengelolaan_sampah ON filtered_progress.desa_id = tb_pengelolaan_sampah.desa_id
                                        AND filtered_progress.tahun = tb_pengelolaan_sampah.tahun
                                    LEFT JOIN
                                        tb_sutet ON filtered_progress.desa_id = tb_sutet.desa_id
                                        AND filtered_progress.tahun = tb_sutet.tahun
                                    LEFT JOIN
                                        tb_keberadaan_sungai ON filtered_progress.desa_id = tb_keberadaan_sungai.desa_id
                                        AND filtered_progress.tahun = tb_keberadaan_sungai.tahun
                                    LEFT JOIN
                                        tb_keberadaan_danau ON filtered_progress.desa_id = tb_keberadaan_danau.desa_id
                                        AND filtered_progress.tahun = tb_keberadaan_danau.tahun
                                    LEFT JOIN
                                        tb_keberadaan_pemukiman_bantaran ON filtered_progress.desa_id = tb_keberadaan_pemukiman_bantaran.desa_id
                                        AND filtered_progress.tahun = tb_keberadaan_pemukiman_bantaran.tahun
                                    LEFT JOIN
                                        tb_embung_mata_air ON filtered_progress.desa_id = tb_embung_mata_air.desa_id
                                        AND filtered_progress.tahun = tb_embung_mata_air.tahun
                                    LEFT JOIN
                                        tb_permukiman_kumuh ON filtered_progress.desa_id = tb_permukiman_kumuh.desa_id
                                        AND filtered_progress.tahun = tb_permukiman_kumuh.tahun
                                    LEFT JOIN
                                        tb_lokasi_penggalian ON filtered_progress.desa_id = tb_lokasi_penggalian.desa_id
                                        AND filtered_progress.tahun = tb_lokasi_penggalian.tahun
                                    LEFT JOIN
                                        tb_prasarana_kebersihan ON filtered_progress.desa_id = tb_prasarana_kebersihan.desa_id
                                        AND filtered_progress.tahun = tb_prasarana_kebersihan.tahun
                                    LEFT JOIN
                                        tb_rumah_tidak_layak_huni ON filtered_progress.desa_id = tb_rumah_tidak_layak_huni.desa_id
                                        AND filtered_progress.tahun = tb_rumah_tidak_layak_huni.tahun
                                    LEFT JOIN
                                        tb_bencana_alam ON filtered_progress.desa_id = tb_bencana_alam.desa_id
                                        AND filtered_progress.tahun = tb_bencana_alam.tahun
                                    LEFT JOIN
                                        tb_peringatan_bencana ON filtered_progress.desa_id = tb_peringatan_bencana.desa_id
                                        AND filtered_progress.tahun = tb_peringatan_bencana.tahun
                                    LEFT JOIN
                                        tb_taman_bacaan ON filtered_progress.desa_id = tb_taman_bacaan.desa_id
                                        AND filtered_progress.tahun = tb_taman_bacaan.tahun
                                    LEFT JOIN
                                        tb_keberadaan_bidan ON filtered_progress.desa_id = tb_keberadaan_bidan.desa_id
                                        AND filtered_progress.tahun = tb_keberadaan_bidan.tahun
                                    LEFT JOIN
                                        tb_keberadaan_dukun_bayi ON filtered_progress.desa_id = tb_keberadaan_dukun_bayi.desa_id
                                        AND filtered_progress.tahun = tb_keberadaan_dukun_bayi.tahun
                                    LEFT JOIN
                                        tb_klb_wabah ON filtered_progress.desa_id = tb_klb_wabah.desa_id
                                        AND filtered_progress.tahun = tb_klb_wabah.tahun
                                            ";

                                    // Tambahkan filter jika tahun dipilih
                                    if ($filter_tahun) {
                                        $query .= " WHERE filtered_progress.tahun = $filter_tahun ";
                                    }

                                    // Eksekusi query
                                    $result = mysqli_query($conn, $query) or die("Error: " . mysqli_error($conn));

                                    $no = 1;
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $no++ . "</td>";
                                            echo "<td>" . htmlspecialchars($row['tahun'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kode_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kecamatan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['sk_pembentukan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['alamat_balai'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['batas_utara'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kec_utara'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['batas_selatan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kec_selatan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['batas_timur'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kec_timur'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['batas_barat'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kec_barat'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jarak_ke_ibukota_kecamatan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jarak_ke_ibukota_kabupaten'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['status_idm'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['alamat_website'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['alamat_email'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['alamat_facebook'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['alamat_twitter'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['alamat_youtube'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['status_pemerintahan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['penetapan_batas_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['no_surat_batas_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['ketersediaan_peta_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['no_surat_peta_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_dusun'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_rw'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_rt'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['luas_wilayah_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['topografi_terluas_wilayah_desa'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_kantor'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['status_kantor'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kondisi_kantor'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['lokasi_kantor'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['koordinat_lintang'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['koordinat_bujur'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_surat_kematian'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_penduduk_laki'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_penduduk_perempuan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_kepala_keluarga'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['pmi_bekerja'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['agen_pengerahan_pmi'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['layanan_rekomendasi_pmi'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_wna'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_pln'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_non_pln'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_bukan_pengguna_listrik'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['penggunaan_lampu_tenaga_surya'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['lampu_tenaga_surya'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['penerangan_jalan_utama'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['sumber_penerangan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['tps'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['tps3r'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['bank_sampah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['sutet_status'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_pemukiman_sutet'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_pemukiman_sutet'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_sungai'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_sungai_1'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_sungai_2'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_sungai_3'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_sungai_4'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_danau'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_danau_1'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_danau_2'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_danau_3'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama_danau_4'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_pemukiman_bantaran'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_pemukiman_bantaran'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_embung'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['lokasi_mata_air'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_kumuh'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_kumuh'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_galian'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_prasarana'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['jumlah_rumah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['tanah_longsor'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['banjir'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['banjir_bandang'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['gempa_bumi'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['tsunami'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['gelombang_pasang'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['angin_puyuh'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['gunung_meletus'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kebakaran_hutan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['kekeringan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['abrasi'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['peringatan_dini'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['peringatan_tsunami'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['perlengkapan_keselamatan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['rambu_evakuasi'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['infrastruktur'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_tbm'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_bidan'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['keberadaan_dukun_bayi'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['muntaber_diare'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['demam_berdarah'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['campak'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['malaria'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['flu_burung_sars'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['hepatitis_e'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['difteri'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['corona_covid19'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['lainnya_name'] ?? "Belum Mengisi") . "</td>";
                                            echo "<td>" . htmlspecialchars($row['lainnya_status'] ?? "Belum Mengisi") . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7' class='text-center'>Tidak ada data.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div> <!--end::Container-->

                <!-- Modal Filter Tahun -->
                <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="GET">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="filterModalLabel">Filter Berdasarkan Tahun</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"
                                        style="all: unset; position: absolute; top: 10px; right: 10px; cursor: pointer; font-size: 1.5rem; line-height: 1;">
                                        &times;
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <label for="filter_tahun">Pilih Tahun:</label>
                                    <select name="filter_tahun" id="filter_tahun" class="form-control mt-2">
                                        <option value="" selected disabled>Pilih Tahun</option>
                                        <?php
                                        // Ambil tahun unik dari tabel user_progress
                                        $query_tahun = "SELECT DISTINCT YEAR(created_at) AS tahun FROM user_progress ORDER BY tahun DESC";
                                        $result_tahun = mysqli_query($conn, $query_tahun) or die("Error: " . mysqli_error($conn));

                                        if ($result_tahun) {
                                            while ($row_tahun = mysqli_fetch_assoc($result_tahun)) {
                                                $selected = (isset($_GET['filter_tahun']) && $_GET['filter_tahun'] == $row_tahun['tahun']) ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($row_tahun['tahun']) . "' $selected>" . htmlspecialchars($row_tahun['tahun']) . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>-->
                                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> &nbsp;
                                        Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Export -->
                <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="GET" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Pilih Jenis Export</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Filter Kecamatan -->
                    <label for="kode_kecamatan">Pilih Kecamatan:</label>
                    <select name="kode_kecamatan" id="kode_kecamatan" class="form-control mt-2 mb-3" onchange="loadDesa(this.value)">
                        <option value="">Semua Kecamatan</option>
                        <?php
                        $kecamatanResult = mysqli_query($conn, "SELECT DISTINCT kecamatan FROM tb_enumerator ORDER BY kecamatan ASC");
                        while ($kecamatan = mysqli_fetch_assoc($kecamatanResult)) {
                            echo "<option value='{$kecamatan['kecamatan']}'>{$kecamatan['kecamatan']}</option>";
                        }
                        ?>
                    </select>

                    <!-- Filter Desa -->
                    <label for="kode_desa">Pilih Desa:</label>
                    <select name="kode_desa" id="kode_desa" class="form-control mt-2 mb-3">
                        <option value="">Semua Desa</option>
                        <!-- Desa akan dimuat dinamis berdasarkan pilihan kecamatan -->
                    </select>

                    <!-- Filter Tahun -->
                    <label for="filter_tahun">Pilih Tahun:</label>
                    <select name="filter_tahun" id="filter_tahun" class="form-control mt-2">
                        <option value="">Semua Tahun</option>
                        <?php
                        $tahunResult = mysqli_query($conn, "SELECT DISTINCT tahun FROM tb_sk_pembentukan ORDER BY tahun DESC");
                        while ($tahun = mysqli_fetch_assoc($tahunResult)) {
                            echo "<option value='{$tahun['tahun']}'>{$tahun['tahun']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="modal-footer">
                    <!-- Tombol Ekspor Excel -->
                    <button type="submit" name="type" value="excel" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> &nbsp; Export Excel
                    </button>
                    <!-- Tombol Ekspor PDF -->
                    <button type="submit" name="type" value="pdf" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> &nbsp; Export PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function loadDesa(kecamatan) {
    const desaSelect = document.getElementById('kode_desa');
    desaSelect.innerHTML = '<option value="">Memuat...</option>'; // Indikasi loading

    fetch(`get_desa.php?kecamatan=${kecamatan}`)
        .then(response => response.json())
        .then(data => {
            desaSelect.innerHTML = '<option value="">Semua Desa</option>';
            data.forEach(desa => {
                desaSelect.innerHTML += `<option value="${desa.kode_desa}">${desa.nama_desa}</option>`;
            });
        })
        .catch(error => {
            console.error('Error:', error);
            desaSelect.innerHTML = '<option value="">Gagal Memuat Data</option>';
        });
}
</script>


                <?php
                // Query untuk mengambil data desa
                $query = "
                SELECT DISTINCT
                    tb_enumerator.kode_desa,
                    tb_enumerator.nama_desa,
                    tb_enumerator.kecamatan,
                    tb_sk_pembentukan.sk_pembentukan
                FROM
                    tb_enumerator
                LEFT JOIN
                    tb_sk_pembentukan
                ON
                    tb_enumerator.id_desa = tb_sk_pembentukan.desa_id
            ";

                // Tambahkan filter jika desa dan/atau tahun dipilih
                $where = [];
                if ($kode_desa) {
                    $where[] = "tb_enumerator.kode_desa = '$kode_desa'";
                }
                if ($filter_tahun) {
                    $where[] = "YEAR(user_progress.created_at) = '$filter_tahun'";
                }

                if ($where) {
                    $query .= " LEFT JOIN user_progress ON tb_enumerator.id_desa = user_progress.desa_id WHERE " . implode(' AND ', $where);
                }

                // Modify the query to include the GROUP BY clause
                $query .= " GROUP BY tb_enumerator.kode_desa, tb_enumerator.nama_desa, tb_enumerator.kecamatan, tb_sk_pembentukan.sk_pembentukan";

                // Eksekusi query
                $result = mysqli_query($conn, $query);

                // Inisialisasi variabel untuk cek data
                $data_found = false;
                if ($result) {
                    $data_found = mysqli_num_rows($result) > 0;
                } else {
                    die('Query Error: ' . mysqli_error($conn));
                }
                ?>

                <!-- Modal Preview -->
                <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen"
                        style="max-width: 100vw; height: 100vh; margin: 0;">
                        <div class="modal-content" style="height: 100%; width: 100%;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="previewModalLabel">Preview Data</h5>
                                <button type="button" class="btn-close" data-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="height: calc(100vh - 120px); overflow-y: auto;">
                                <?php if ($data_found): ?>
                                    <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                                        <thead style="background-color: #f0f0f0;">
                                            <tr>
                                                <th style="text-align: center; padding: 10px;">Kode Desa</th>
                                                <th style="text-align: center; padding: 10px;">Nama Desa</th>
                                                <th style="text-align: center; padding: 10px;">Kecamatan</th>
                                                <th style="text-align: center; padding: 10px;">Sk Pembentukan/Pengesahan
                                                    Desa/Kelurahan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                                <tr>
                                                    <td style="text-align: center; padding: 10px;">
                                                        <?php echo htmlspecialchars($row['kode_desa']); ?></td>
                                                    <td style="padding: 10px;">
                                                        <?php echo htmlspecialchars($row['nama_desa']); ?></td>
                                                    <td style="padding: 10px;">
                                                        <?php echo htmlspecialchars($row['kecamatan']); ?></td>
                                                    <td style="text-align: center; padding: 10px;">
                                                        <?php echo htmlspecialchars($row['sk_pembentukan']); ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p>Data tidak ditemukan.</p>
                                <?php endif; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!--end::App Content-->
        </main> <!--end::App Main--> <!--begin::Footer-->

        <?php include("../../components/footer.php"); ?>
    </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->

    <!-- Tambahkan library Select2 dan tema Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="../../plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="../../plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="../../plugins/dropzone/min/dropzone.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"
        integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="../../../dist/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })

        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function () {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script> <!--end::OverlayScrollbars Configure--> <!--end::Script-->
</body><!--end::Body-->

</html>