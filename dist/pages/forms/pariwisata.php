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

        <?php include('../../components/navbar.php'); ?>

        <?php include('../../components/sidebar.php'); ?> <!--end::Sidebar--> <!--begin::App Main-->

        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Pariwisata</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Pariwisata
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
                            <h3 class="card-title">Daftar Potensi Wisata Desa</h3>
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalWisataDesa">
                                <i class="fas fa-info-circle"></i>
                            </button>
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
                            <form action="" method="post" id="potensiForm">
                                <div id="potensi-container">
                                    <!-- Potensi Wisata 1 -->
                                    <div class="potensi-item border p-3 mb-3">
                                        <h5 class="mb-3">Potensi Wisata <span class="potensi-id">1</span></h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="nama-wisata-1">Nama Potensi Wisata Desa</label>
                                                    <input type="text" id="nama-wisata-1" class="form-control" placeholder="Isi nama potensi" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="jenis-wisata-1">--Jenis Wisata Desa--</label>
                                                    <select id="jenis-wisata-1" class="form-control" required>
                                                        <option disabled selected>Isi Jenis Wisata</option>
                                                        <option value="alam">WISATA ALAM</option>
                                                        <option value="buatan">WISATA BUATAN</option>
                                                        <option value="religi">WISATA RELIGI</option>
                                                        <option value="budaya">WISATA BUDAYA</option>
                                                        <option value="tidakada">TIDAK ADA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="">
                                                <label class="mb-2">Titik Koordinat</label>
                                                <div class="form-group mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="lintang-wisata-1">Koordinat Lintang</label>
                                                            <input type="text" id="lintang-wisata-1" class="form-control" placeholder="-6.8796 LS" style="width: 100%;" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="bujur-wisata-1">Koordinat Bujur</label>
                                                            <input type="text" id="bujur-wisata-1" class="form-control" placeholder="108.5538 BT" style="width: 100%;" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Potensi Wisata 2 -->
                                    <div class="potensi-item border p-3 mb-3">
                                        <h5 class="mb-3">Potensi Wisata <span class="potensi-id">2</span></h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="nama-wisata-2">Nama Potensi Wisata Desa</label>
                                                    <input type="text" id="nama-wisata-2" class="form-control" placeholder="Isi nama potensi">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="jenis-wisata-2">Jenis Wisata Desa</label>
                                                    <select id="jenis-wisata-2" class="form-control">
                                                        <option disabled selected>Isi Jenis Wisata</option>
                                                        <option value="alam">WISATA ALAM</option>
                                                        <option value="buatan">WISATA BUATAN</option>
                                                        <option value="religi">WISATA RELIGI</option>
                                                        <option value="budaya">WISATA BUDAYA</option>
                                                        <option value="tidakada">TIDAK ADA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="">
                                                <label class="mb-2">Titik Koordinat</label>
                                                <div class="form-group mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="lintang-wisata-2">Koordinat Lintang</label>
                                                            <input type="text" id="lintang-wisata-2" class="form-control" placeholder="-6.8796 LS" style="width: 100%;">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="bujur-wisata-2">Koordinat Bujur</label>
                                                            <input type="text" id="bujur-wisata-2" class="form-control" placeholder="108.5538 BT" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Potensi Wisata 3 -->
                                    <div class="potensi-item border p-3 mb-3">
                                        <h5 class="mb-3">Potensi Wisata <span class="potensi-id">3</span></h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="nama-wisata-3">Nama Potensi Wisata Desa</label>
                                                    <input type="text" id="nama-wisata-3" class="form-control" placeholder="Isi nama potensi">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="jenis-wisata-3">Jenis Wisata Desa</label>
                                                    <select id="jenis-wisata-3" class="form-control">
                                                        <option disabled selected>Isi Jenis Wisata</option>
                                                        <option value="alam">WISATA ALAM</option>
                                                        <option value="buatan">WISATA BUATAN</option>
                                                        <option value="religi">WISATA RELIGI</option>
                                                        <option value="budaya">WISATA BUDAYA</option>
                                                        <option value="tidakada">TIDAK ADA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="">
                                                <label class="mb-2">Titik Koordinat</label>
                                                <div class="form-group mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="lintang-wisata-3">Koordinat Lintang</label>
                                                            <input type="text" id="lintang-wisata-3" class="form-control" placeholder="-6.8796 LS" style="width: 100%;">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="bujur-wisata-3">Koordinat Bujur</label>
                                                            <input type="text" id="bujur-wisata-3" class="form-control" placeholder="108.5538 BT" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Potensi Wisata 3 -->
                                    <div class="potensi-item border p-3 mb-3">
                                        <h5 class="mb-3">Potensi Wisata <span class="potensi-id">4</span></h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="nama-wisata-4">Nama Potensi Wisata Desa</label>
                                                    <input type="text" id="nama-wisata-4" class="form-control" placeholder="Isi nama potensi">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="jenis-wisata-4">Jenis Wisata Desa</label>
                                                    <select id="jenis-wisata-4" class="form-control">
                                                        <option disabled selected>Isi Jenis Wisata</option>
                                                        <option value="alam">WISATA ALAM</option>
                                                        <option value="buatan">WISATA BUATAN</option>
                                                        <option value="religi">WISATA RELIGI</option>
                                                        <option value="budaya">WISATA BUDAYA</option>
                                                        <option value="tidakada">TIDAK ADA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="">
                                                <label class="mb-2">Titik Koordinat</label>
                                                <div class="form-group mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="lintang-wisata-4">Koordinat Lintang</label>
                                                            <input type="text" id="lintang-wisata-4" class="form-control" placeholder="-6.8796 LS" style="width: 100%;">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="bujur-wisata-4">Koordinat Bujur</label>
                                                            <input type="text" id="bujur-wisata-4" class="form-control" placeholder="108.5538 BT" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Potensi Wisata 5 -->
                                    <div class="potensi-item border p-3 mb-3">
                                        <h5 class="mb-3">Potensi Wisata <span class="potensi-id">5</span></h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="nama-wisata-5">Nama Potensi Wisata Desa</label>
                                                    <input type="text" id="nama-wisata-5" class="form-control" placeholder="Isi nama potensi">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="jenis-wisata-5">Jenis Wisata Desa</label>
                                                    <select id="jenis-wisata-5" class="form-control">
                                                        <option disabled selected>Isi Jenis Wisata</option>
                                                        <option value="alam">WISATA ALAM</option>
                                                        <option value="buatan">WISATA BUATAN</option>
                                                        <option value="religi">WISATA RELIGI</option>
                                                        <option value="budaya">WISATA BUDAYA</option>
                                                        <option value="tidakada">TIDAK ADA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="">
                                                <label class="mb-2">Titik Koordinat</label>
                                                <div class="form-group mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="lintang-wisata-5">Koordinat Lintang</label>
                                                            <input type="text" id="lintang-wisata-5" class="form-control" placeholder="-6.8796 LS" style="width: 100%;">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="bujur-wisata-5">Koordinat Bujur</label>
                                                            <input type="text" id="bujur-wisata-5" class="form-control" placeholder="108.5538 BT" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Potensi Wisata 6 -->
                                    <div class="potensi-item border p-3 mb-3">
                                        <h5 class="mb-3">Potensi Wisata <span class="potensi-id">6</span></h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="nama-wisata-6">Nama Potensi Wisata Desa</label>
                                                    <input type="text" id="nama-wisata-6" class="form-control" placeholder="Isi nama potensi">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="jenis-wisata-6">Jenis Wisata Desa</label>
                                                    <select id="jenis-wisata-6" class="form-control">
                                                        <option disabled selected>Isi Jenis Wisata</option>
                                                        <option value="alam">WISATA ALAM</option>
                                                        <option value="buatan">WISATA BUATAN</option>
                                                        <option value="religi">WISATA RELIGI</option>
                                                        <option value="budaya">WISATA BUDAYA</option>
                                                        <option value="tidakada">TIDAK ADA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="">
                                                <label class="mb-2">Titik Koordinat</label>
                                                <div class="form-group mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="lintang-wisata-6">Koordinat Lintang</label>
                                                            <input type="text" id="lintang-wisata-6" class="form-control" placeholder="-6.8796 LS" style="width: 100%;">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="bujur-wisata-6">Koordinat Bujur</label>
                                                            <input type="text" id="bujur-wisata-6" class="form-control" placeholder="108.5538 BT" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Potensi Wisata 7 -->
                                    <div class="potensi-item border p-3 mb-3">
                                        <h5 class="mb-3">Potensi Wisata <span class="potensi-id">7</span></h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="nama-wisata-7">Nama Potensi Wisata Desa</label>
                                                    <input type="text" id="nama-wisata-7" class="form-control" placeholder="Isi nama potensi">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="jenis-wisata-7">Jenis Wisata Desa</label>
                                                    <select id="jenis-wisata-7" class="form-control">
                                                        <option disabled selected>Isi Jenis Wisata</option>
                                                        <option value="alam">WISATA ALAM</option>
                                                        <option value="buatan">WISATA BUATAN</option>
                                                        <option value="religi">WISATA RELIGI</option>
                                                        <option value="budaya">WISATA BUDAYA</option>
                                                        <option value="tidakada">TIDAK ADA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="">
                                                <label class="mb-2">Titik Koordinat</label>
                                                <div class="form-group mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="lintang-wisata-7">Koordinat Lintang</label>
                                                            <input type="text" id="lintang-wisata-7" class="form-control" placeholder="-6.8796 LS" style="width: 100%;">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="bujur-wisata-7">Koordinat Bujur</label>
                                                            <input type="text" id="bujur-wisata-7" class="form-control" placeholder="108.5538 BT" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Potensi Wisata 8 -->
                                    <div class="potensi-item border p-3 mb-3">
                                        <h5 class="mb-3">Potensi Wisata <span class="potensi-id">8</span></h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="nama-wisata-8">Nama Potensi Wisata Desa</label>
                                                    <input type="text" id="nama-wisata-8" class="form-control" placeholder="Isi nama potensi">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="jenis-wisata-8">Jenis Wisata Desa</label>
                                                    <select id="jenis-wisata-8" class="form-control">
                                                        <option disabled selected>Isi Jenis Wisata</option>
                                                        <option value="alam">WISATA ALAM</option>
                                                        <option value="buatan">WISATA BUATAN</option>
                                                        <option value="religi">WISATA RELIGI</option>
                                                        <option value="budaya">WISATA BUDAYA</option>
                                                        <option value="tidakada">TIDAK ADA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="">
                                                <label class="mb-2">Titik Koordinat</label>
                                                <div class="form-group mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="lintang-wisata-8">Koordinat Lintang</label>
                                                            <input type="text" id="lintang-wisata-8" class="form-control" placeholder="-6.8796 LS" style="width: 100%;">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="bujur-wisata-8">Koordinat Bujur</label>
                                                            <input type="text" id="bujur-wisata-8" class="form-control" placeholder="108.5538 BT" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Potensi Wisata 9 -->
                                    <div class="potensi-item border p-3 mb-3">
                                        <h5 class="mb-3">Potensi Wisata <span class="potensi-id">9</span></h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="nama-wisata-9">Nama Potensi Wisata Desa</label>
                                                    <input type="text" id="nama-wisata-9" class="form-control" placeholder="Isi nama potensi">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="jenis-wisata-9">Jenis Wisata Desa</label>
                                                    <select id="jenis-wisata-9" class="form-control">
                                                        <option disabled selected>Isi Jenis Wisata</option>
                                                        <option value="alam">WISATA ALAM</option>
                                                        <option value="buatan">WISATA BUATAN</option>
                                                        <option value="religi">WISATA RELIGI</option>
                                                        <option value="budaya">WISATA BUDAYA</option>
                                                        <option value="tidakada">TIDAK ADA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="">
                                                <label class="mb-2">Titik Koordinat</label>
                                                <div class="form-group mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="lintang-wisata-9">Koordinat Lintang</label>
                                                            <input type="text" id="lintang-wisata-9" class="form-control" placeholder="-6.8796 LS" style="width: 100%;">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="bujur-wisata-9">Koordinat Bujur</label>
                                                            <input type="text" id="bujur-wisata-9" class="form-control" placeholder="108.5538 BT" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Potensi Wisata 10 -->
                                    <div class="potensi-item border p-3 mb-3">
                                        <h5 class="mb-3">Potensi Wisata <span class="potensi-id">10</span></h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="nama-wisata-10">Nama Potensi Wisata Desa</label>
                                                    <input type="text" id="nama-wisata-10" class="form-control" placeholder="Isi nama potensi">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="mb-2" for="jenis-wisata-10">Jenis Wisata Desa</label>
                                                    <select id="jenis-wisata-10" class="form-control">
                                                        <option disabled selected>Isi Jenis Wisata</option>
                                                        <option value="alam">WISATA ALAM</option>
                                                        <option value="buatan">WISATA BUATAN</option>
                                                        <option value="religi">WISATA RELIGI</option>
                                                        <option value="budaya">WISATA BUDAYA</option>
                                                        <option value="tidakada">TIDAK ADA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="">
                                                <label class="mb-2">Titik Koordinat</label>
                                                <div class="form-group mb-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="lintang-wisata-10">Koordinat Lintang</label>
                                                            <input type="text" id="lintang-wisata-10" class="form-control" placeholder="-6.8796 LS" style="width: 100%;">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="mb-2" for="bujur-wisata-10">Koordinat Bujur</label>
                                                            <input type="text" id="bujur-wisata-10" class="form-control" placeholder="108.5538 BT" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary mb-3">Simpan Semua</button>
                                </div>
                            </form>
                        </div>

                        <!-- Modal Info -->
                        <div class="modal fade" id="modalWisataDesa" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            <li>Isi nama potensi wisata desa, Jika tidak ada isi angka 0</li>
                                            <li>Pilih jenis wisata desa, Jika tidak ada pilih TIDAK ADA</li>
                                            <li>Isi koordinat lintang, jika tidak ada isi angka 0</li>
                                            <li>Isi koordinat bujur, jika tidak ada isi angka 0</li>
                                            <li>Potensi Wisata 1 wajib diisi, untuk ke 2 dan seterusnya optional</li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Jumlah Usaha Jasa Akomodasi</h3>
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalAkomodasi">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toogle-form-1">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toogle-form-1").on("click", function() {
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
                                            <label class="mb-2 flex-shrink-0 me-3" style="width: 150px;">Hotel (unit)</label>
                                            <input type="number" class="form-control" placeholder="Isi angka/jumlah" min="0" step="1" required>
                                        </div>
                                        <div class="form-group mb-3 d-flex align-items-center " style="width:100%">
                                            <label class="mb-2 flex-shrink-0 me-3" style="width: 150px;">Penginapan (unit)</label>
                                            <input type="number" class="form-control" placeholder="Isi angka/jumlah" min="0" step="1" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                </div>
                            </form>
                        </div>

                        <!-- Modal Info -->
                        <div class="modal fade" id="modalAkomodasi" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            <li>Isi angka/jumlah hotel per unit</li>
                                            <li>Isi angka/jumlah penginapan (hotel/motel/losmen/wisma) per unit</li>
                                            <li>Jika tidak ada isi angka 0</li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
            </div>
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