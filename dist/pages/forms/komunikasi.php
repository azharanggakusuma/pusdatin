<?php
include_once "../../config/conn.php";
include "../../config/session.php";
?>

<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>PUSDATIN | Formulir</title><!--begin::Primary Meta Tags-->
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
                    <li class="user-footer d-grid gap-2"><a href="#" class="btn btn-danger btn-flat">Sign out</a> </li> <!--end::Menu Footer-->
                </ul>
                </li> <!--end::User Menu Dropdown-->
                </ul> <!--end::End Navbar Links-->
            </div> <!--end::Container-->
        </nav> <!--end::Header--> <!--begin::Sidebar-->

        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
            <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="../../index.php" class="brand-link"> <!--begin::Brand Image--> <img src="../../img/kominfo.png" alt="Pusdatin" class="brand-image"> <!--end::Brand Image--> <!--begin::Brand Text--> <span class="brand-text fw-bold">PUSDATIN v1.0</span> <!--end::Brand Text--> </a> <!--end::Brand Link--> </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2"> <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <!--<li class="nav-header">MENU</li>-->
                        <li class="nav-item"> <a href="../../index.php" class="nav-link"> <i class="nav-icon bi bi-speedometer"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-pencil-square"></i>
                                <p>
                                    Formulir
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="./keadaan_geografi.php" class="nav-link active"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Keadaan Geografi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="wilayah_administratif.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Wilayah Administratif</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="sumber_daya_manusia.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Sumber Daya Manusia</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="kelembagaan_dan_keuangan_desa.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Kelembagaan Dan Keungan Desa</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="pendudukan.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Penduduk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="pendidikan.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Pendidikan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="kesehatan.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Kesehatan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="fasilitas_umum.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Fasilitas Umum</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="sosial.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Sosial</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="pariwisata.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Pariwisata</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="transportasi.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Transportasi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="komunikasi.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Komunikasi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="lembaga_keuangan.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Lembaga Keuangan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="sarana_perdagangan.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Sarana Perdagangan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="infrastruktur.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Infrastruktur</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="lingkungan.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Lingkungan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Jika level pengguna admin, tampilkan menu Master Data -->
                        <?php if ($level == 'admin') { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link"> <i class="nav-icon bi bi-table"></i>
                                    <p>
                                        Master Data
                                        <i class="nav-arrow bi bi-chevron-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../tables/user.php" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                            <p>Data User</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../tables/rekap.php" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                            <p>Rekap Data</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul> <!--end::Sidebar Menu-->
                </nav>
            </div> <!--end::Sidebar Wrapper-->
        </aside> <!--end::Sidebar--> <!--begin::App Main-->

        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Komunikasi</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Komunikasi
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content Header--> <!--begin::App Content-->
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Jumlah Menara Base Transceiver Station (BTS)</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toogle-form">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toogle-form").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi
                                            $icon.toggleClass("fa-minus fa-plus"); // Ganti ikon
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row">
                                    <!-- /.col -->
                                    <div class="col-md-6">
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah menara Base Transceiver Station (BTS)</label>
                                            <input type="number" class="form-control" placeholder="Isi angka/jumlah" min="0" step="1" style="width: 100%;" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Operator layanan komunikasi telepon seluler/handphone yang menjangkau wilayah desa</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toogle-form1">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toogle-form1").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi
                                            $icon.toggleClass("fa-minus fa-plus"); // Ganti ikon
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row">
                                    <!-- /.col -->
                                    <div>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3 d-flex align-items-center">
                                            <label class="mb-2 flex-shrink-0 me-3" style="width: 200px;">1. Telkomsel/Halo/Loop/As</label>
                                            <input type="hidden" value="1. Telkomsel/Halo/Loop/As">
                                            <div class="me-3" style="width: 50%;">
                                                <label>Sinyal di sebagian besar wilayah</label>
                                                <select class="form-control me-3 mt-3" required>
                                                    <option disabled selected>Pilih opsi</option>
                                                    <option value="trayek-tetap">SINYAL SANGAT KUAT</option>
                                                    <option value="tanpa-trayek-tetap">SINYAL KUAT</option>
                                                    <option value="tidak-ada">SINYAL LEMAH</option>
                                                    <option value="tidak-ada">TIDAK ADA SINYAL</option>
                                                </select>
                                            </div>
                                            <div style="width: 50%;">
                                                <label>Sinyal di sebagian besar wilayah</label>
                                                <select class="form-control mt-3 ml-5" required>
                                                    <option disabled selected>Pilih opsi</option>
                                                    <option value="trayek-tetap">4G/LTE2</option>
                                                    <option value="tanpa-trayek-tetap">3G/H/H+/EVDO</option>
                                                    <option value="tidak-ada">2.5G/E/GPRS</option>
                                                    <option value="tidak-ada">TIDAK ADA SINYAL</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 d-flex align-items-center">
                                            <label class="mb-2 flex-shrink-0 me-3" style="width: 200px;">2. Indosat</label>
                                            <select class="form-control me-3" style="width: 50%;" required>
                                                <option disabled selected>Pilih opsi</option>
                                                <option value="trayek-tetap">SINYAL SANGAT KUAT</option>
                                                <option value="tanpa-trayek-tetap">SINYAL KUAT</option>
                                                <option value="tidak-ada">SINYAL LEMAH</option>
                                                <option value="tidak-ada">TIDAK ADA SINYAL</option>
                                            </select>
                                            <select class="form-control" style="width: 50%;" required>
                                                <option disabled selected>Pilih opsi</option>
                                                <option value="trayek-tetap">4G/LTE2</option>
                                                <option value="tanpa-trayek-tetap">3G/H/H+/EVDO</option>
                                                <option value="tidak-ada">2.5G/E/GPRS</option>
                                                <option value="tidak-ada">TIDAK ADA SINYAL</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3 d-flex align-items-center">
                                            <label class="mb-2 flex-shrink-0 me-3" style="width: 200px;">3. XL/Axis</label>
                                            <select class="form-control me-3" style="width: 50%;" required>
                                                <option disabled selected>Pilih opsi</option>
                                                <option value="trayek-tetap">SINYAL SANGAT KUAT</option>
                                                <option value="tanpa-trayek-tetap">SINYAL KUAT</option>
                                                <option value="tidak-ada">SINYAL LEMAH</option>
                                                <option value="tidak-ada">TIDAK ADA SINYAL</option>
                                            </select>
                                            <select class="form-control" style="width: 50%;" required>
                                                <option disabled selected>Pilih opsi</option>
                                                <option value="trayek-tetap">4G/LTE2</option>
                                                <option value="tanpa-trayek-tetap">3G/H/H+/EVDO</option>
                                                <option value="tidak-ada">2.5G/E/GPRS</option>
                                                <option value="tidak-ada">TIDAK ADA SINYAL</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3 d-flex align-items-center">
                                            <label class="mb-2 flex-shrink-0 me-3" style="width: 200px;">4. Hutchison 3</label>
                                            <select class="form-control me-3" style="width: 50%;" required>
                                                <option disabled selected>Pilih opsi</option>
                                                <option value="trayek-tetap">SINYAL SANGAT KUAT</option>
                                                <option value="tanpa-trayek-tetap">SINYAL KUAT</option>
                                                <option value="tidak-ada">SINYAL LEMAH</option>
                                                <option value="tidak-ada">TIDAK ADA SINYAL</option>
                                            </select>
                                            <select class="form-control" style="width: 50%;" required>
                                                <option disabled selected>Pilih opsi</option>
                                                <option value="trayek-tetap">4G/LTE2</option>
                                                <option value="tanpa-trayek-tetap">3G/H/H+/EVDO</option>
                                                <option value="tidak-ada">2.5G/E/GPRS</option>
                                                <option value="tidak-ada">TIDAK ADA SINYAL</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3 d-flex align-items-center">
                                            <label class="mb-2 flex-shrink-0 me-3" style="width: 200px;">5. Smartfren</label>
                                            <select class="form-control me-3" style="width: 50%;" required>
                                                <option disabled selected>Pilih opsi</option>
                                                <option value="trayek-tetap">SINYAL SANGAT KUAT</option>
                                                <option value="tanpa-trayek-tetap">SINYAL KUAT</option>
                                                <option value="tidak-ada">SINYAL LEMAH</option>
                                                <option value="tidak-ada">TIDAK ADA SINYAL</option>
                                            </select>
                                            <select class="form-control" style="width: 50%;" required>
                                                <option disabled selected>Pilih opsi</option>
                                                <option value="trayek-tetap">4G/LTE2</option>
                                                <option value="tanpa-trayek-tetap">3G/H/H+/EVDO</option>
                                                <option value="tidak-ada">2.5G/E/GPRS</option>
                                                <option value="tidak-ada">TIDAK ADA SINYAL</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3 d-flex align-items-center">
                                            <label class="mb-2 flex-shrink-0 me-3" style="width: 200px;">6. Bakrie Telecom</label>
                                            <select class="form-control me-3" style="width: 50%;" required>
                                                <option disabled selected>Pilih opsi</option>
                                                <option value="trayek-tetap">SINYAL SANGAT KUAT</option>
                                                <option value="tanpa-trayek-tetap">SINYAL KUAT</option>
                                                <option value="tidak-ada">SINYAL LEMAH</option>
                                                <option value="tidak-ada">TIDAK ADA SINYAL</option>
                                            </select>
                                            <select class="form-control" style="width: 50%;" required>
                                                <option disabled selected>Pilih opsi</option>
                                                <option value="trayek-tetap">4G/LTE2</option>
                                                <option value="tanpa-trayek-tetap">3G/H/H+/EVDO</option>
                                                <option value="tidak-ada">2.5G/E/GPRS</option>
                                                <option value="tidak-ada">TIDAK ADA SINYAL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                </div>
                            </form>

                        </div>

                    </div>

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Keberadaan Kantor Pos/Pos Pembantu/Rumah Pos, Pos Keliling, dan Perusahaan/Agen Jasa Ekspedisi Swasta</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toogle-form1">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toogle-form1").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi
                                            $icon.toggleClass("fa-minus fa-plus"); // Ganti ikon
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row">
                                    <!-- /.col -->
                                    <div>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3 d-flex align-items-center">
                                            <label class="mb-2 flex-shrink-0 me-3" style="width: 290px;">Kantor Pos/Pos Pembantu/Rumah Pos</label>
                                            <select class="form-control me-3" style="width: 100%;" required>
                                                <option disabled selected>Pilih opsi</option>
                                                <option value="trayek-tetap">ADA, BEROPERASI</option>
                                                <option value="tanpa-trayek-tetap">ADA, JARANG BEROPERASI</option>
                                                <option value="tidak-ada">ADA, TIDAK BEROPERASI</option>
                                                <option value="tidak-ada">TIDAK ADA</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3 d-flex align-items-center">
                                            <label class="mb-2 flex-shrink-0 me-3" style="width: 290px;">Pos Keliling</label>
                                            <select class="form-control me-3" style="width: 100%;" required>
                                                <option disabled selected>Pilih opsi</option>
                                                <option value="trayek-tetap">ADA</option>
                                                <option value="tanpa-trayek-tetap">TIDAK ADA</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3 d-flex align-items-center">
                                            <label class="mb-2 flex-shrink-0 me-3" style="width: 290px;">Perusahaan/Agen Jasa Ekspedisi Swasta</label>
                                            <select class="form-control me-3" style="width: 10 0%;" required>
                                                <option disabled selected>Pilih opsi</option>
                                                <option value="trayek-tetap">ADA, BEROPERASI</option>
                                                <option value="tanpa-trayek-tetap">ADA, JARANG BEROPERASI</option>
                                                <option value="tidak-ada">ADA, TIDAK BEROPERASI</option>
                                                <option value="tidak-ada">TIDAK ADA</option>
                                            </select>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </div>
                            </form>

                        </div>

                    </div>
                </div> <!--end::Container-->
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