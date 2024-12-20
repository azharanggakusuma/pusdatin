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
    <!-- iCheck for checkboxes and radio input requireds -->
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
                            <h3 class="mb-0">Infrastruktur</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Infrastruktur
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
                            <h3 class="card-title">Panjang Jalan Desa</h3>
                            <!-- BEGIN:: INFO BUTTON -->
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#jalan">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <!-- Modal Info -->
                            <div class="modal fade" id="jalan" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Panjang Jalan Desa (Kilometer), isi angka/panjang</li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END:: INFO BUTTON -->
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toggle-form">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toggle-form").on("click", function() {
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
                                    <div class=>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Panjang Jalan Desa (Kilometer)</label>
                                            <input required type="number" class="form-control" placeholder="Masukkan angka/panjang" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <div class="mb-3"> <button type="submit" class="btn btn-primary mt-3">Simpan</button> </div> <!--end::Footer-->
                            </form>
                            <!-- /.row -->
                        </div>
                    </div>

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Banyaknya Embung</h3>
                            <!-- BEGIN:: INFO BUTTON -->
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#embung">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <!-- Modal Info -->
                            <div class="modal fade" id="embung" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Embung (buah), isi angka/jumlah</li>
                                                <li>Mata Air (lokasi), isi angka/jumlah</li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END:: INFO BUTTON -->
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool batas-wilayah">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".batas-wilayah").on("click", function() {
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
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Embung (buah)</label>
                                            <input required type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>

                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Mata Air (lokasi)</label>
                                            <input required type="number" class="form-control" placeholder="Masukkan angka/panjang" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <div class="mb-3"> <button type="submit" class="btn btn-primary mt-3">Simpan</button> </div> <!--end::Footer-->
                            </form>
                            <!-- /.row -->
                        </div>
                    </div>
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Nama danau/waduk/situ</h3>
                            <!-- BEGIN:: INFO BUTTON -->
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#danau">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <!-- Modal Info -->
                            <div class="modal fade" id="danau" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Keberadaan Danau/Waduk/Situ, Pilih antara ADA dan TIDAK ADA</li>
                                                <li>Nama danau/waduk/situ yang berada di wilayah desa, Masukkan nama danau/waduk/situ </li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END:: INFO BUTTON -->
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool batas-wilayah">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".batas-wilayah").on("click", function() {
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
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Keberadaan Danau/Waduk/Situ</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Ada</option>
                                                <option value="">Tidak Ada</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama danau/waduk/situ yang berada di wilayah desa 1</label>
                                            <input required type="text" id="nama-danau/waduk/situ-1" class="form-control" placeholder="Masukkan nama danau/waduk/situ" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama danau/waduk/situ yang berada di wilayah desa 2</label>
                                            <input required type="text" id="nama-danau/waduk/situ-2" class="form-control" placeholder="Masukkan nama danau/waduk/situ" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama danau/waduk/situ yang berada di wilayah desa 3</label>
                                            <input required type="text" id="nama-danau/waduk/situ-3" class="form-control" placeholder="Masukkan nama danau/waduk/situ" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <div class="mb-3"> <button type="submit" class="btn btn-primary mt-3">Simpan</button> </div> <!--end::Footer-->
                            </form>
                            <!-- /.row -->
                        </div>

                    </div> <!--end::Container-->
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Jumlah Sarana Prasarana Kebersihan</h3>
                            <!-- BEGIN:: INFO BUTTON -->
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#kebersihan">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <!-- Modal Info -->
                            <div class="modal fade" id="kebersihan" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Banyaknya Tempat Pembuangan Sementara (TPS), isi angka/jumlah</li>
                                                <li>Banyaknya Tempat Pembuangan Akhir (TPA), isi angka/jumlah</li>
                                                <li>Jumlah kendaraan pengangkut sampah dimiliki desa, isi angka/jumlah</li>
                                                <li>Alat penghancur sampah/incinerator (Ada/Tidak), pilih antara ADA dan TIDAK ADA</li>
                                                <li>Tempat pengelolaan sampah (Ada / Tidak),  pilih antara ADA dan TIDAK ADA</li>
                                                <li>Jika kolom di atas Ada, Pengelolaan sampah lingkungan dilakukan oleh (Pemerintah/Swasta/Swadaya), pilih antara Pemerintah/Swasta/Swadaya </li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END:: INFO BUTTON -->
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool batas-wilayah">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".batas-wilayah").on("click", function() {
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
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Banyaknya Tempat Pembuangan Sementara (TPS)</label>
                                            <input required type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Banyaknya Tempat Pembuangan Akhir (TPA)</label>
                                            <input required type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah kendaraan pengangkut sampah dimiliki desa</label>
                                            <input required type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alat penghancur sampah/incinerator (Ada/Tidak)</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Ada</option>
                                                <option value="">Tidak Ada</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Tempat pengelolaan sampah (Ada / Tidak)</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Ada</option>
                                                <option value="">Tidak Ada</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jika kolom di atas Ada, Pengelolaan sampah lingkungan dilakukan oleh (Pemerintah/Swasta/Swadaya)</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Pemerintah</option>
                                                <option value="">Swadaya</option>
                                                <option value="">Swasta</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <div class="mb-3"> <button type="submit" class="btn btn-primary mt-3">Simpan</button> </div> <!--end::Footer-->
                            </form>
                            <!-- /.row -->
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
    <!-- Input requiredMask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/input requiredmask/jquery.input requiredmask.min.js"></script>
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