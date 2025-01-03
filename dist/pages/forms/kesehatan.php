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

    <link rel="shortcut icon" href="../../img/kominfo.png" type="image/x-icon">
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->

    <div class="app-wrapper"> <!--begin::Header-->

        <?php include('../../components/navbar.php'); ?>

        <?php include('../../components/sidebar.php'); ?> <!--end::Sidebar--> <!--begin::App Main-->

        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Kesehatan</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Keadaan Geografi
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content"> <!--begin::Container-->

                <!-- BEGIN:: container Rumah Sakit -->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="card card-primary card-outline mb-4 card0">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Daftar Rumah Sakit</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool addButton">
                                    <i class="fas fa-minus"></i>

                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".addButton").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi

                                            // Toggle antara fa-plus dan fa-minus
                                            if ($icon.hasClass("fa-plus")) {
                                                $icon.removeClass("fa-plus").addClass("fa-minus");
                                            } else {
                                                $icon.removeClass("fa-minus").addClass("fa-plus");
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="" method="post">
                                <!-- begin:: Rumah Sakit ke 1 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Rumah Sakit Ke 1</h2>
                                    </div>
                                    <div class="row">
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Rumah Sakit</label>
                                                <input placeholder="Isi Nama Rumah Sakit" id="nama_Rumah Sakit_ke1" type="text" class="form-control">
                                            </div>


                                            <div class="form-group mb-3">
                                                <label class="mb-2">Jenis Rumah Sakit</label>
                                                <select id="Jenis_Rumah Sakit1" class="form-control select2bs4"
                                                    style="width: 100%;">
                                                    <option value="" disabled selected>---Pilih Jenis Rumah Sakit---</option>
                                                    <option value="">Rumah Sakit</option>
                                                    <option value="">Rumah Sakit Swasta</option>

                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Alamat Rumah Sakit</label>
                                                <textarea class="form-control" rows="3" placeholder="Isi Alamat Rumah Sakit Dengan Benar"></textarea>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Kecamatan</label>
                                                <input id="nama_kecamatan_ke1" type="text" class="form-control">
                                            </div>
                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                        <input id="koordinat_lintang_ke1" type="text"
                                                            class="form-control koordinat_lintang_ke1">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Rumah Sakit ke 1 -->

                                <!-- begin:: form Rumah Sakit ke 2 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">Rumah Sakit Ke 2</h2>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Rumah Sakit</label>
                                            <input placeholder="Isi Nama Rumah Sakit" id="nama_Rumah Sakit_ke2" type="text" class="form-control">
                                        </div>


                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Rumah Sakit</label>
                                            <select id="Jenis_Rumah Sakit2" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Rumah Sakit---</option>
                                                <option value="">Rumah Sakit</option>
                                                <option value="">Rumah Sakit Swasta</option>

                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat Rumah Sakit</label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Rumah Sakit Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke2" type="text" class="form-control">
                                        </div>
                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke2">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke2">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke2" type="text"
                                                        class="form-control koordinat_lintang_ke2">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke2">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke2" type="text"
                                                        class="form-control koordinat_bujur_ke2">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end:: form Rumah Sakit ke 2 -->


                                <!-- begin:: form Rumah Sakit ke 3 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">Rumah Sakit Ke 3</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Rumah Sakit</label>
                                            <input placeholder="Isi Nama Rumah Sakit" id="nama_Rumah Sakit_ke3" type="text" class="form-control">
                                        </div>


                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Rumah Sakit</label>
                                            <select id="Jenis_Rumah Sakit3" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Rumah Sakit---</option>
                                                <option value="">Rumah Sakit</option>
                                                <option value="">Rumah Sakit Swasta</option>

                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat Rumah Sakit</label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Rumah Sakit Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke3" type="text" class="form-control">
                                        </div>
                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke3">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke3">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke3" type="text" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke3">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke3" type="text"
                                                        class="form-control koordinat_bujur_ke3">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end:: form Rumah Sakit ke 3 -->




                                <div class="col-md-6">

                                    <button type="submit" class="btn btn-primary mt-3">Simpan Semua</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END:: contaainer Rumah Sakit -->

                <!-- BEGIN:: container PUSKESMAS -->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="card card-primary card-outline mb-4 card0">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Daftar Pusat Kesehatan Masyarakat (PUSKESMAS) </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool addButton2">
                                    <i class="fas fa-minus"></i>

                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".addButton2").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi

                                            // Toggle antara fa-plus dan fa-minus
                                            if ($icon.hasClass("fa-plus")) {
                                                $icon.removeClass("fa-plus").addClass("fa-minus");
                                            } else {
                                                $icon.removeClass("fa-minus").addClass("fa-plus");
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="" method="post">
                                <!-- begin:: Sekolah ke 1 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">PUSKESMAS Ke 1</h2>
                                    </div>
                                    <div class="row">
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama PUSKESMAS</label>
                                                <input id="nama_pondok_pesantren_ke1" type="text" class="form-control">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Alamat PUSKESMAS</label>
                                                <textarea class="form-control" rows="3" placeholder="Isi Alamat PUSKESMA Dengan Benar"></textarea>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Kecamatan</label>
                                                <input id="nama_kecamatan_ke1" type="text" class="form-control">
                                            </div>
                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                        <input id="koordinat_lintang_ke1" type="text"
                                                            class="form-control koordinat_lintang_ke1">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: PUSKESMAS ke 1 -->

                                <!-- begin:: form PUSKESMAS ke 2 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">PUSKESMAS Ke 2</h2>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama PUSKESMAS</label>
                                            <input id="nama_PUSKESMAS_ke2" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat PUSKESMAS</label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat PUSKESMA Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke2" type="text" class="form-control">
                                        </div>

                                    </div>
                                </div>
                                <!-- end:: form PUSKESMAS ke 2 -->


                                <!-- begin:: form PUSKESMAS ke 3 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">PUSKESMAS Ke 3</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama PUSKESMAS</label>
                                            <input id="nama_PUSKESMAS_ke3" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat PUSKESMAS</label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat PUSKESMA Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke3" type="text" class="form-control">
                                        </div>

                                    </div>
                                </div>
                                <!-- end:: form PUSKESMAS ke 3 -->

                                <div class="col-md-6">

                                    <button type="submit" class="btn btn-primary mt-3">Simpan Semua</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!--end::Container-->
                <!-- END:: container PUSKESMAS -->

                <!-- BEGIN:: container PUSTU -->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="card card-primary card-outline mb-4 card0">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Daftar Puskesmas Pembantu (PUSTU)</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool addButton4">
                                    <i class="fas fa-minus"></i>

                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".addButton4").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi

                                            // Toggle antara fa-plus dan fa-minus
                                            if ($icon.hasClass("fa-plus")) {
                                                $icon.removeClass("fa-plus").addClass("fa-minus");
                                            } else {
                                                $icon.removeClass("fa-minus").addClass("fa-plus");
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="" method="post">
                                <!-- begin:: Sekolah ke 1 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">PUSTU Ke 1</h2>
                                    </div>
                                    <div class="row">
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama PUSTU</label>
                                                <input id="nama_pondok_pesantren_ke1" type="text" class="form-control">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Alamat PUSTU</label>
                                                <textarea class="form-control" rows="3" placeholder="Isi Alamat PUSTU Dengan Benar"></textarea>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Kecamatan</label>
                                                <input id="nama_kecamatan_ke1" type="text" class="form-control">
                                            </div>
                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                        <input id="koordinat_lintang_ke1" type="text"
                                                            class="form-control koordinat_lintang_ke1">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: PUSTU ke 1 -->

                                <!-- begin:: form PUSTU ke 2 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">PUSTU Ke 2</h2>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama PUSTU</label>
                                            <input id="nama_PUSTU_ke2" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat PUSTU</label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat PUSTU Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke2" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end:: form PUSTU ke 2 -->


                                <!-- begin:: form PUSTU ke 3 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">PUSTU Ke 3</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama PUSTU</label>
                                            <input id="nama_PUSTU_ke3" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat PUSTU</label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat PUSTU Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke3" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- end:: form PUSTU ke 3 -->

                                <div class="col-md-6">

                                    <button type="submit" class="btn btn-primary mt-3">Simpan Semua</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!--end::Container-->
                <!-- END:: container PUSTU -->

                <!-- BEGIN:: container Poliklinik Atau Balai Pengobatan  -->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="card card-primary card-outline mb-4 card0">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Daftar Poliklinik Atau Balai Pengobatan </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool addButton5">
                                    <i class="fas fa-minus"></i>

                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".addButton5").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi

                                            // Toggle antara fa-plus dan fa-minus
                                            if ($icon.hasClass("fa-plus")) {
                                                $icon.removeClass("fa-plus").addClass("fa-minus");
                                            } else {
                                                $icon.removeClass("fa-minus").addClass("fa-plus");
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="" method="post">
                                <!-- begin:: Sekolah ke 1 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Poliklinik Atau Balai Pengobatan Ke 1</h2>
                                    </div>
                                    <div class="row">
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Poliklinik Atau Balai Pengobatan </label>
                                                <input id="nama_pondok_pesantren_ke1" type="text" class="form-control">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Alamat Poliklinik Atau Balai Pengobatan </label>
                                                <textarea class="form-control" rows="3" placeholder="Isi Alamat Poliklinik Atau Balai Pengobatan Dengan Benar"></textarea>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Kecamatan</label>
                                                <input id="nama_kecamatan_ke1" type="text" class="form-control">
                                            </div>
                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                        <input id="koordinat_lintang_ke1" type="text"
                                                            class="form-control koordinat_lintang_ke1">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Poliklinik Atau Balai Pengobatan  ke 1 -->

                                <!-- begin:: form Poliklinik Atau Balai Pengobatan  ke 2 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">Poliklinik Atau Balai Pengobatan Ke 2</h2>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Poliklinik Atau Balai Pengobatan </label>
                                            <input id="nama_Poliklinik Atau Balai Pengobatan _ke2" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat Poliklinik Atau Balai Pengobatan </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Poliklinik Atau Balai Pengobatan Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke2" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end:: form Poliklinik Atau Balai Pengobatan  ke 2 -->


                                <!-- begin:: form Poliklinik Atau Balai Pengobatan  ke 3 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">Poliklinik Atau Balai Pengobatan Ke 3</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Poliklinik Atau Balai Pengobatan </label>
                                            <input id="nama_Poliklinik Atau Balai Pengobatan _ke3" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat Poliklinik Atau Balai Pengobatan </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Poliklinik Atau Balai Pengobatan Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke3" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- end:: form Poliklinik Atau Balai Pengobatan  ke 3 -->

                                <div class="col-md-6">

                                    <button type="submit" class="btn btn-primary mt-3">Simpan Semua</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!--end::Container-->
                <!-- END:: container POLOKNLINIK ATAU BALAI pENGOBATAN -->

                <!-- BEGIN:: container Praktek Dokter  -->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="card card-primary card-outline mb-4 card0">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Daftar Praktek Dokter</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool addButton6">
                                    <i class="fas fa-minus"></i>

                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".addButton6").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi

                                            // Toggle antara fa-plus dan fa-minus
                                            if ($icon.hasClass("fa-plus")) {
                                                $icon.removeClass("fa-plus").addClass("fa-minus");
                                            } else {
                                                $icon.removeClass("fa-minus").addClass("fa-plus");
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="" method="post">
                                <!-- begin:: Sekolah ke 1 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Praktek Dokter Ke 1</h2>
                                    </div>
                                    <div class="row">
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Praktek Dokter </label>
                                                <input id="nama_pondok_pesantren_ke1" type="text" class="form-control">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Alamat Praktek Dokter </label>
                                                <textarea class="form-control" rows="3" placeholder="Isi Alamat Prakter Dokter Dengan Benar"></textarea>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Kecamatan</label>
                                                <input id="nama_kecamatan_ke1" type="text" class="form-control">
                                            </div>
                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                        <input id="koordinat_lintang_ke1" type="text"
                                                            class="form-control koordinat_lintang_ke1">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Praktek Dokter  ke 1 -->

                                <!-- begin:: form Praktek Dokter  ke 2 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">Nama Praktek Dokter Ke 2</h2>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Praktek Dokter </label>
                                            <input id="nama_Praktek Dokter _ke2" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat Praktek Dokter </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Prakter Dokter Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke2" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end:: form Praktek Dokter  ke 2 -->


                                <!-- begin:: form Praktek Dokter  ke 3 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">Praktek Dokter Ke 3</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Praktek Dokter </label>
                                            <input id="nama_Praktek Dokter _ke3" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat Praktek Dokter </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Prakter Dokter Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke3" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- end:: form Praktek Dokter  ke 3 -->

                                <div class="col-md-6">

                                    <button type="submit" class="btn btn-primary mt-3">Simpan Semua</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!--end::Ctainer-->
                <!-- END:: container POLOKNLINIK ATAU BALAI pENGOBATAN -->

                <!-- BEGIN:: container Praktek Bidan  -->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="card card-primary card-outline mb-4 card0">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Daftar Praktek Bidan</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool addButton7">
                                    <i class="fas fa-minus"></i>

                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".addButton7").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi

                                            // Toggle antara fa-plus dan fa-minus
                                            if ($icon.hasClass("fa-plus")) {
                                                $icon.removeClass("fa-plus").addClass("fa-minus");
                                            } else {
                                                $icon.removeClass("fa-minus").addClass("fa-plus");
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="" method="post">
                                <!-- begin:: Sekolah ke 1 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Praktek Bidan Ke 1</h2>
                                    </div>
                                    <div class="row">
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Praktek Bidan </label>
                                                <input id="nama_pondok_pesantren_ke1" type="text" class="form-control">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Alamat Praktek Bidan </label>
                                                <textarea class="form-control" rows="3" placeholder="Isi Alamat Praktek Bidan Dengan Benar"></textarea>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Kecamatan</label>
                                                <input id="nama_kecamatan_ke1" type="text" class="form-control">
                                            </div>
                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                        <input id="koordinat_lintang_ke1" type="text"
                                                            class="form-control koordinat_lintang_ke1">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Praktek Bidan  ke 1 -->

                                <!-- begin:: form Praktek Bidan  ke 2 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">Praktek Bidan Ke 2</h2>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Praktek Bidan </label>
                                            <input id="nama_Praktek Bidan _ke2" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat Praktek Bidan </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Praktek Bidan Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke2" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end:: form Praktek Bidan  ke 2 -->


                                <!-- begin:: form Praktek Bidan  ke 3 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">Praktek Bidan Ke 3</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Praktek Bidan </label>
                                            <input id="nama_Praktek Bidan _ke3" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat Praktek Bidan </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Praktek Bidan Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke3" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- end:: form Praktek Bidan  ke 3 -->

                                <div class="col-md-6">

                                    <button type="submit" class="btn btn-primary mt-3">Simpan Semua</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!--end::Ctainer-->
                <!-- END:: container Bidan -->

                <!-- BEGIN:: container Pos Kesehatan Desa (POSKESDES)  -->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="card card-primary card-outline mb-4 card0">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Daftar Pos Kesehatan Desa (POSKESDES)</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool addButton8">
                                    <i class="fas fa-minus"></i>

                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".addButton8").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi

                                            // Toggle antara fa-plus dan fa-minus
                                            if ($icon.hasClass("fa-plus")) {
                                                $icon.removeClass("fa-plus").addClass("fa-minus");
                                            } else {
                                                $icon.removeClass("fa-minus").addClass("fa-plus");
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="" method="post">
                                <!-- begin:: Sekolah ke 1 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Pos Kesehatan Desa (POSKESDES) Ke 1</h2>
                                    </div>
                                    <div class="row">
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Pos Kesehatan Desa (POSKESDES) </label>
                                                <input id="nama_pondok_pesantren_ke1" type="text" class="form-control">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Alamat Pos Kesehatan Desa (POSKESDES) </label>
                                                <textarea class="form-control" rows="3" placeholder="Isi Alamat POSKESDES Dengan Benar"></textarea>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Kecamatan</label>
                                                <input id="nama_kecamatan_ke1" type="text" class="form-control">
                                            </div>
                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                        <input id="koordinat_lintang_ke1" type="text"
                                                            class="form-control koordinat_lintang_ke1">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Pos Kesehatan Desa (POSKESDES)  ke 1 -->

                                <!-- begin:: form Pos Kesehatan Desa (POSKESDES)  ke 2 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">Pos Kesehatan Desa (POSKESDES) Ke 2</h2>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Pos Kesehatan Desa (POSKESDES) </label>
                                            <input id="nama_Pos Kesehatan Desa (POSKESDES) _ke2" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat Pos Kesehatan Desa (POSKESDES) </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat POSKESDES Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke2" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end:: form Pos Kesehatan Desa (POSKESDES)  ke 2 -->


                                <!-- begin:: form Pos Kesehatan Desa (POSKESDES)  ke 3 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">Pos Kesehatan Desa (POSKESDES) Ke 3</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Pos Kesehatan Desa (POSKESDES) </label>
                                            <input id="nama_Pos Kesehatan Desa (POSKESDES) _ke3" type="text" class="form-control">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat Pos Kesehatan Desa (POSKESDES) </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat POSKESDES Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke3" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- end:: form Pos Kesehatan Desa (POSKESDES)  ke 3 -->

                                <div class="col-md-6">

                                    <button type="submit" class="btn btn-primary mt-3">Simpan Semua</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!--end::Ctainer-->
                <!-- END:: container Pos Kesehatan Desa -->

                <!-- BEGIN:: container Pondok Bersalin Desa (POLINDES)  -->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="card card-primary card-outline mb-4 card0">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Daftar Pondok Bersalin Desa (POLINDES)</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool addButton9">
                                    <i class="fas fa-minus"></i>

                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".addButton9").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi 

                                            // Toggle antara fa-plus dan fa-minus  
                                            if ($icon.hasClass("fa-plus")) {
                                                $icon.removeClass("fa-plus").addClass("fa-minus");
                                            } else {
                                                $icon.removeClass("fa-minus").addClass("fa-plus");
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="" method="post">
                                <!-- begin:: Sekolah ke 1 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Pondok Bersalin Desa (POLINDES) Ke 1</h2>
                                    </div>
                                    <div class="row">
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Pondok Bersalin Desa (POLINDES) </label>
                                                <input id="nama_pondok_pesantren_ke1" type="text" class="form-control">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Alamat Pondok Bersalin Desa (POLINDES) </label>
                                                <textarea class="form-control" rows="3" placeholder="Isi Alamat POLINDES Dengan Benar"></textarea>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Kecamatan</label>
                                                <input id="nama_kecamatan_ke1" type="text" class="form-control">
                                            </div>
                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                        <input id="koordinat_lintang_ke1" type="text"
                                                            class="form-control koordinat_lintang_ke1">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Pondok Bersalin Desa (POLINDES)  ke 1 -->

                                <!-- begin:: form Pondok Bersalin Desa (POLINDES)  ke 2 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">Pondok Bersalin Desa (POLINDES) Ke 2</h2>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Pondok Bersalin Desa (POLINDES) </label>
                                            <input id="nama_Pondok Bersalin Desa (POLINDES) _ke2" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat Pondok Bersalin Desa (POLINDES) </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat POLINDES Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke2" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end:: form Pondok Bersalin Desa (POLINDES)  ke 2 -->


                                <!-- begin:: form Pondok Bersalin Desa (POLINDES)  ke 3 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">Pondok Bersalin Desa (POLINDES) Ke 3</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Pondok Bersalin Desa (POLINDES) </label>
                                            <input id="nama_Pondok Bersalin Desa (POLINDES) _ke3" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat Pondok Bersalin Desa (POLINDES) </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat POLINDES Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke3" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- end:: form Pondok Bersalin Desa (POLINDES)  ke 3 -->

                                <div class="col-md-6">

                                    <button type="submit" class="btn btn-primary mt-3">Simpan Semua</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!--end::Ctainer--> 
                <!-- END:: container Pos Kesehatan Desa -->

                <!-- BEGIN:: container Apotek  -->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="card card-primary card-outline mb-4 card0">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Daftar Apotek</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool addButton10">
                                    <i class="fas fa-minus"></i>

                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".addButton10").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi 

                                            // Toggle antara fa-plus dan fa-minus  
                                            if ($icon.hasClass("fa-plus")) {
                                                $icon.removeClass("fa-plus").addClass("fa-minus");
                                            } else {
                                                $icon.removeClass("fa-minus").addClass("fa-plus");
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="" method="post">
                                <!-- begin:: Sekolah ke 1 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Apotek Ke 1</h2>
                                    </div>
                                    <div class="row">
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Apotek </label>
                                                <input id="nama_pondok_pesantren_ke1" type="text" class="form-control">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Alamat Apotek </label>
                                                <textarea class="form-control" rows="3" placeholder="Isi Alamat Rumah Sakit Dengan Benar"></textarea>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Kecamatan</label>
                                                <input id="nama_kecamatan_ke1" type="text" class="form-control">
                                            </div>
                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                        <input id="koordinat_lintang_ke1" type="text"
                                                            class="form-control koordinat_lintang_ke1">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Apotek  ke 1 -->

                                <!-- begin:: form Apotek  ke 2 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">Apotek Ke 2</h2>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Apotek </label>
                                            <input id="nama_Apotek _ke2" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat Apotek </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Rumah Sakit Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke2" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end:: form Apotek  ke 2 -->


                                <!-- begin:: form Apotek  ke 3 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">Apotek Ke 3</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Apotek </label>
                                            <input id="nama_Apotek _ke3" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat Apotek </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Rumah Sakit Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke3" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- end:: form Apotek  ke 3 -->

                                <div class="col-md-6">

                                    <button type="submit" class="btn btn-primary mt-3">Simpan Semua</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!--end::Ctainer-->
                <!-- END:: container Apotek-->

                <!-- BEGIN:: container POSYANDU  -->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="card card-primary card-outline mb-4 card0">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Daftar POSYANDU</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool addButton11">
                                    <i class="fas fa-minus"></i>

                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".addButton11").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi 

                                            // Toggle antara fa-plus dan fa-minus  
                                            if ($icon.hasClass("fa-plus")) {
                                                $icon.removeClass("fa-plus").addClass("fa-minus");
                                            } else {
                                                $icon.removeClass("fa-minus").addClass("fa-plus");
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="" method="post">
                                <!-- begin:: Sekolah ke 1 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">POSYANDU Ke 1</h2>
                                    </div>
                                    <div class="row">
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama POSYANDU </label>
                                                <input id="nama_pondok_pesantren_ke1" type="text" class="form-control">
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Alamat POSYANDU </label>
                                                <textarea class="form-control" rows="3" placeholder="Isi Alamat Rumah Sakit Dengan Benar"></textarea>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Kecamatan</label>
                                                <input id="nama_kecamatan_ke1" type="text" class="form-control">
                                            </div>
                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                        <input id="koordinat_lintang_ke1" type="text"
                                                            class="form-control koordinat_lintang_ke1">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: POSYANDU  ke 1 -->

                                <!-- begin:: form POSYANDU  ke 2 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">POSYANDU Ke 2</h2>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama POSYANDU </label>
                                            <input id="nama_POSYANDU _ke2" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat POSYANDU </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Rumah Sakit Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke2" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- end:: form POSYANDU  ke 2 -->


                                <!-- begin:: form POSYANDU  ke 3 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">Nama POSYANDU Ke 3</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama POSYANDU </label>
                                            <input id="nama_POSYANDU _ke3" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat POSYANDU </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Rumah Sakit Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke3" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- end:: form POSYANDU  ke 3 -->

                                <!-- begin:: form POSYANDU  ke 4 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">POSYANDU Ke 4</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama POSYANDU </label>
                                            <input id="nama_POSYANDU _ke3" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat POSYANDU </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Rumah Sakit Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke3" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- end:: form POSYANDU  ke 4 -->

                                <!-- begin:: form POSYANDU  ke 5 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">POSYANDU Ke 5</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama POSYANDU </label>
                                            <input id="nama_POSYANDU _ke3" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat POSYANDU </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Rumah Sakit Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke3" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- end:: form POSYANDU  ke 5 -->

                                <!-- begin:: form POSYANDU  ke 6 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">POSYANDU Ke 6</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama POSYANDU </label>
                                            <input id="nama_POSYANDU _ke3" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat POSYANDU </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Rumah Sakit Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke3" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- end:: form POSYANDU  ke 6 -->

                                <!-- begin:: form POSYANDU  ke 7 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">
                                        <h2 class="card-title">POSYANDU Ke 7</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama POSYANDU </label>
                                            <input id="nama_POSYANDU _ke3" type="text" class="form-control">
                                        </div>



                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat POSYANDU </label>
                                            <textarea class="form-control" rows="3" placeholder="Isi Alamat Rumah Sakit Dengan Benar"></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Kecamatan</label>
                                            <input id="nama_kecamatan_ke3" type="text" class="form-control">
                                        </div>

                                        <div class="titik_koordinat">
                                            <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <label for="koordinat_lintang_ke1">Koordinat Lintang</label>
                                                    <input id="koordinat_lintang_ke1" type="text"
                                                        class="form-control koordinat_lintang_ke1">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                    <input id="koordinat_bujur_ke1" type="text"
                                                        class="form-control koordinat_bujur_ke1">
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- end:: form POSYANDU ke 7 -->

                                <div class="col-md-6">

                                    <button type="submit" class="btn btn-primary mt-3">Simpan Semua</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!--end::Ctainer-->
                <!-- END:: container POSYANDU-->

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