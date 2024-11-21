<?php
include_once('../../config/conn.php');
include "../../config/session.php";
?>

<?php
require __DIR__ . '/../../../vendor/autoload.php';
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

     // Membersihkan buffer output
     if (ob_get_level()) {
        ob_end_clean();
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
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>PUSDATIN | Rekap Data</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE 4 | General Form Elements">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="shortcut icon" href="../../img/kominfo.png" type="image/x-icon">
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
                </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto"> <!--begin::Navbar Search-->
                    <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a> </li> <!--end::Fullscreen Toggle--> <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu"> <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> <img src="../people.png" class="user-image rounded-circle shadow" alt="User Image"> <span class="d-none d-md-inline"><?php echo $name; ?></span> </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <!--begin::User Image-->
                            <li class="user-header text-bg-primary"> <img src="../../img/people.png" class="rounded-circle shadow" alt="User Image">
                                <p>
                                    <?php echo $name; ?> <!-- Menampilkan nama pengguna -->
                                    <small><?php echo $role_description; ?></small> <!-- Menampilkan keterangan berdasarkan level -->
                                </p>
                            </li> <!--end::User Image-->
                    </li> <!--begin::Menu Footer-->
                    <li class="user-footer d-grid gap-2"><a href="../../auth/logout.php" class="btn btn-danger btn-flat">Sign out</a> </li> <!--end::Menu Footer-->
                </ul>
                </li> <!--end::User Menu Dropdown-->
                </ul> <!--end::End Navbar Links-->
            </div> <!--end::Container-->
        </nav> <!--end::Header--> <!--begin::Sidebar-->

        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="./index.php" class="brand-link">
                    <img src="../../img/kominfo.png" alt="Pusdatin" class="brand-image">
                    <span class="brand-text fw-bold">PUSDATIN v1.0</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="../../index.php" class="nav-link">
                                <i class="nav-icon bi bi-speedometer"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Menu formulir hanya untuk user dan admin -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-pencil-square"></i>
                                <p>
                                    Formulir
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../forms/desa.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Desa</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/keadaan_geografi.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Keadaan Geografi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/wilayah_administratif.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Wilayah Administratif</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/sumber_daya_manusia.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Sumber Daya Manusia</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/kelembagaan_dan_keuangan_desa.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Kelembagaan Dan Keungan Desa</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/pendudukan.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Penduduk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/pendidikan.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Pendidikan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/kesehatan.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Kesehatan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/fasilitas_umum.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Fasilitas Umum</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/sosial.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Sosial</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/pariwisata.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Pariwisata</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/transportasi.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Transportasi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/komunikasi.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Komunikasi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/lembaga_keuangan.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Lembaga Keuangan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/sarana_perdagangan.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Sarana Perdagangan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/infrastruktur.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Infrastruktur</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../forms/lingkungan.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Lingkungan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Jika level pengguna admin, tampilkan menu Master Data -->
                        <?php if ($level == 'admin') { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-table"></i>
                                    <p>
                                        Master Data
                                        <i class="nav-arrow bi bi-chevron-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="./user.php" class="nav-link">
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>Data User</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="./rekap.php" class="nav-link active">
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>Rekap Data</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </aside> <!--end::Sidebar--> <!--begin::App Main-->

        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Rekap Data</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Rekap data
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
                            <h3 class="card-title">Rekap Data</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#exportModal">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
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
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div> <!--end::Container-->

                <!-- Modal Export -->
                <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="GET">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exportModalLabel">Pilih Jenis Export</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" style="all: unset; position: absolute; top: 10px; right: 10px; cursor: pointer; font-size: 1.5rem; line-height: 1;">
                                        &times;
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

            </div> <!--end::App Content-->
        </main> <!--end::App Main--> <!--begin::Footer-->

        <footer class="app-footer"> <!--begin::To the end-->
            <div class="float-end d-none d-sm-inline">Version 1.0</div> <!--end::To the end--> <!--begin::Copyright-->
            <strong>
                Copyright &copy; 2024&nbsp;
                <a href="#" class="text-decoration-none">Diskominfo Kab. Cirebon</a>.
            </strong>
            All rights reserved.
            <!--end::Copyright-->
        </footer> <!--end::Footer-->
    </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->


    <!-- Tambahkan library Select2 dan tema Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
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

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="../../../dist/js/adminlte.js"></script> <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        $(function() {
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
        document.addEventListener("DOMContentLoaded", function() {
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