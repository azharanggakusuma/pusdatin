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
                            <h3 class="mb-0">Kelembagaan dan Keuangan Desa</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Kelembagaan dan Keuangan Desa
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
                            <h3 class="card-title">Jumlah Lembaga Kemasyarakatan Desa</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toggle-form1">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toggle-form1").on("click", function() {
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
                                            <label class="mb-2">Jumlah Pengurus PKK (orang)</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Anggota PKK (orang)</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class=>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Pengurus Karang Taruna (orang)</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class=>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Anggota Karang Taruna (orang)</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Pengurus Lembaga Adat (orang)</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class=>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Anggota Lembaga Adat (orang)</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Pengurus LPMD (orang)</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class=>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Anggota LPMD (orang)</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Pengurus MUI (orang)</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class=>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Anggota MUI (orang)</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Pengurus RT (orang)</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class=>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Anggota RT (orang)</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Pengurus RW (orang)</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class=>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Anggota RW (orang)</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
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
                            <h3 class="card-title">Data BUMDes</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toggle-form2">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toggle-form2").on("click", function() {
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
                                            <label class="mb-2">Nama BUMDes </label>
                                            <input type="text" class="form-control" placeholder="Masukkan nama" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>

                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Status Keaktifan (Aktif/Tidak Aktif)</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">AKTIF</option>
                                                <option value="">TIDAK AKTIF</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Status Badan Hukum</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">SUDAH MEMILIKI</option>
                                                <option value="">BELUM MEMILIKI</option>
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

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Jumlah Peraturan Yang dimiliki Desa</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toggle-form3">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toggle-form3").on("click", function() {
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
                                            <label class="mb-2">Peraturan Desa</label>
                                            <input type="number" class="form-control" placeholder="Masukkan banyaknya Peraturan Desa yang telah ditetapkan" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Peraturan Kepala Desa</label>
                                            <input type="number" class="form-control" placeholder="Masukkan banyaknya Peraturan Kepala Desa yang telah ditetapkan" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Surat Keputusan</label>
                                            <input type="number" class="form-control" placeholder="Masukkan banyaknya surat" min="0" step="1" style="width: 100%;">
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
                            <h3 class="card-title">Ketersedian RPJMDes dan RKPDes</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toggle-form4">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toggle-form4").on("click", function() {
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
                                            <label class="mb-2">Ketersediaan RPJMDes</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">ADA</option>
                                                <option value="">TIDAK ADA</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Periode Tahun RPJMDes</label>
                                            <input type="number" class="form-control" placeholder="Masukkan periode tahun" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Ketersediaan RKPDes</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">ADA</option>
                                                <option value="">TIDAK ADA</option>
                                            </select>
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
                            <h3 class="card-title">Rincian Anggaran Pendapatan Desa</h3>
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalAnggaranDesa">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toggle-form5">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toggle-form5").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi
                                            $icon.toggleClass("fa-minus fa-plus"); // Ganti ikon
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="anggaranDesaForm" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="dana_desa_apbn" class="mb-2">1. Dana Desa bersumber dari APBN</label>
                                            <input type="hidden" name="label_dana_desa_apbn" value="1. Dana Desa bersumber dari APBN">
                                            <div class="input-group">
                                                <span class="input-group-text">Rupiah</span>
                                                <input type="hidden" name="rupiah" value="Rupiah">
                                                <input type="text" id="dana_desa_apbn" name="dana_desa_apbn" class="form-control" placeholder="Masukkan anggaran" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="pades" class="mb-2">2. Pendapatan Asli Desa (PADes)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rupiah</span>
                                                <input type="text" id="pades" name="pades" class="form-control" placeholder="Masukkan anggaran" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="pajak_daerah" class="mb-2">3. Bagian dari hasil pajak daerah dan retribusi daerah</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rupiah</span>
                                                <input type="text" id="pajak_daerah" name="pajak_daerah" class="form-control" placeholder="Masukkan anggaran" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="alokasi_dana_desa" class="mb-2">4. Alokasi Dana Desa (bagian dari dana perimbangan yang diterima)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rupiah</span>
                                                <input type="text" id="alokasi_dana_desa" name="alokasi_dana_desa" class="form-control" placeholder="Masukkan anggaran" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="bantuan_apbd_provinsi" class="mb-2">5. Bantuan keuangan dari APBD Provinsi</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rupiah</span>
                                                <input type="text" id="bantuan_apbd_provinsi" name="bantuan_apbd_provinsi" class="form-control" placeholder="Masukkan anggaran" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="bantuan_apbd_kabupaten" class="mb-2">6. Bantuan keuangan dari APBD Kabupaten/kota</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rupiah</span>
                                                <input type="text" id="bantuan_apbd_kabupaten" name="bantuan_apbd_kabupaten" class="form-control" placeholder="Masukkan anggaran" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="hibah" class="mb-2">7. Hibah dan sumbangan dari pihak ketiga</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rupiah</span>
                                                <input type="text" id="hibah" name="hibah" class="form-control" placeholder="Masukkan anggaran" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="lain_lain" class="mb-2">8. Lain-lain pendapatan desa yang sah</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rupiah</span>
                                                <input type="text" id="lain_lain" name="lain_lain" class="form-control" placeholder="Masukkan anggaran" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                </div>
                            </form>
                        </div>

                        <!-- Modal Info -->
                        <div class="modal fade" id="modalAnggaranDesa" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            <li>Isi nominal anggaran sesuai dengan sumbernya.</li>
                                            <li>Pastikan semua kolom terisi dengan benar.</li>
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
                            <h3 class="card-title">Rincian Aset Desa</h3>
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalRincianAset">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toggle-form-aset">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toggle-form-aset").on("click", function() {
                                            var $icon = $(this).find("i");
                                            var $cardBody = $(this).closest(".card").find(".card-body");

                                            $cardBody.slideToggle();
                                            $icon.toggleClass("fa-minus fa-plus");
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="rincianAsetForm" method="post">
                                <div class="row">
                                    <!-- Loop untuk form 1 hingga 11 -->
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="bumdes" class="mb-2">1. Bumdes dan bumdesma</label>
                                            <div class="input-group">
                                                <input type="text" id="bumdes_volume" name="bumdes_volume" class="form-control" placeholder="Volume" required>
                                                <span class="input-group-text">Unit</span>
                                                <input type="text" id="bumdes_nilai" name="bumdes_nilai" class="form-control" placeholder="Nilai Rupiah" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="tanah_desa" class="mb-2">2. Tanah Desa</label>
                                            <div class="input-group">
                                                <input type="text" id="tanah_desa_volume" name="tanah_desa_volume" class="form-control" placeholder="Volume" required>
                                                <span class="input-group-text">Ha</span>
                                                <input type="text" id="tanah_desa_nilai" name="tanah_desa_nilai" class="form-control" placeholder="Nilai Rupiah" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="bangunan_milik_desa" class="mb-2">3. Bangunan Milik Desa</label>
                                            <div class="input-group">
                                                <input type="text" id="bangunan_milik_desa_volume" name="bangunan_milik_desa_volume" class="form-control" placeholder="Volume" required>
                                                <span class="input-group-text">Unit</span>
                                                <input type="text" id="bangunan_milik_desa_nilai" name="bangunan_milik_desa_nilai" class="form-control" placeholder="Nilai Rupiah" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="kendaraan_desa" class="mb-2">4. Kendaraan Milik Desa</label>
                                            <div class="input-group">
                                                <input type="text" id="kendaraan_desa_volume" name="kendaraan_desa_volume" class="form-control" placeholder="Volume" required>
                                                <span class="input-group-text">Unit</span>
                                                <input type="text" id="kendaraan_desa_nilai" name="kendaraan_desa_nilai" class="form-control" placeholder="Nilai Rupiah" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="peralatan_desa" class="mb-2">5. Peralatan Milik Desa</label>
                                            <div class="input-group">
                                                <input type="text" id="peralatan_desa_volume" name="peralatan_desa_volume" class="form-control" placeholder="Volume" required>
                                                <span class="input-group-text">Unit</span>
                                                <input type="text" id="peralatan_desa_nilai" name="peralatan_desa_nilai" class="form-control" placeholder="Nilai Rupiah" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="perpustakaan_desa" class="mb-2">6. Perpustakaan Desa</label>
                                            <div class="input-group">
                                                <input type="text" id="perpustakaan_desa_volume" name="perpustakaan_desa_volume" class="form-control" placeholder="Volume" required>
                                                <span class="input-group-text">Unit</span>
                                                <input type="text" id="perpustakaan_desa_nilai" name="perpustakaan_desa_nilai" class="form-control" placeholder="Nilai Rupiah" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="pasar_desa" class="mb-2">7. Pasar Desa</label>
                                            <div class="input-group">
                                                <input type="text" id="pasar_desa_volume" name="pasar_desa_volume" class="form-control" placeholder="Volume" required>
                                                <span class="input-group-text">Unit</span>
                                                <input type="text" id="pasar_desa_nilai" name="pasar_desa_nilai" class="form-control" placeholder="Nilai Rupiah" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="tempat_ibadah" class="mb-2">8. Tempat Ibadah Milik Desa</label>
                                            <div class="input-group">
                                                <input type="text" id="tempat_ibadah_volume" name="tempat_ibadah_volume" class="form-control" placeholder="Volume" required>
                                                <span class="input-group-text">Unit</span>
                                                <input type="text" id="tempat_ibadah_nilai" name="tempat_ibadah_nilai" class="form-control" placeholder="Nilai Rupiah" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="jalan_desa" class="mb-2">9. Jalan Desa</label>
                                            <div class="input-group">
                                                <input type="text" id="jalan_desa_volume" name="jalan_desa_volume" class="form-control" placeholder="Volume" required>
                                                <span class="input-group-text">Km</span>
                                                <input type="text" id="jalan_desa_nilai" name="jalan_desa_nilai" class="form-control" placeholder="Nilai Rupiah" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="irigasi_desa" class="mb-2">10. Irigasi Desa</label>
                                            <div class="input-group">
                                                <input type="text" id="irigasi_desa_volume" name="irigasi_desa_volume" class="form-control" placeholder="Volume" required>
                                                <span class="input-group-text">Km</span>
                                                <input type="text" id="irigasi_desa_nilai" name="irigasi_desa_nilai" class="form-control" placeholder="Nilai Rupiah" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="aset_lainnya" class="mb-2">11. Aset Desa Lainnya</label>
                                            <div class="input-group">
                                                <input type="text" id="aset_lainnya_volume" name="aset_lainnya_volume" class="form-control" placeholder="Volume" required>
                                                <span class="input-group-text">Unit</span>
                                                <input type="text" id="aset_lainnya_nilai" name="aset_lainnya_nilai" class="form-control" placeholder="Nilai Rupiah" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                </div>
                            </form>
                        </div>

                        <!-- Modal Info -->
                        <div class="modal fade" id="modalRincianAset" tabindex="-1" aria-labelledby="modalRincianAsetLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalRincianAsetLabel">Aturan Pengisian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            <li>Isi volume dan nilai sesuai dengan jenis aset desa.</li>
                                            <li>Gunakan satuan yang sesuai untuk volume.</li>
                                            <li>Pastikan semua data terisi dengan benar sebelum menyimpan.</li>
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
                            <h3 class="card-title"> Anggaran Belanja Desa </h3>
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalAnggaranDesa">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toggle-form6">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toggle-form6").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi
                                            $icon.toggleClass("fa-minus fa-plus"); // Ganti ikon
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="anggaranDesaForm" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="dana_desa_apbn" class="mb-2">1. Bidang penyelenggaraan pemerintahan desa</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rupiah</span>
                                                <input type="text" id="dana_desa_apbn" name="dana_desa_apbn" class="form-control" placeholder="Masukkan anggaran" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="pades" class="mb-2">2. Bidang pelaksanaan pembangunan desa</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rupiah</span>
                                                <input type="text" id="pades" name="pades" class="form-control" placeholder="Masukkan anggaran" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="pajak_daerah" class="mb-2">3. Bidang pemberdayaan masyarakat</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rupiah</span>
                                                <input type="text" id="pajak_daerah" name="pajak_daerah" class="form-control" placeholder="Masukkan anggaran" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="alokasi_dana_desa" class="mb-2">4. Bidang pembinaan kemasyarakatan</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rupiah</span>
                                                <input type="text" id="alokasi_dana_desa" name="alokasi_dana_desa" class="form-control" placeholder="Masukkan anggaran" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="bantuan_apbd_provinsi" class="mb-2">5. Belanja Modal (tanah, bangunan, jalan, jembatan, komputer, dll.)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rupiah</span>
                                                <input type="text" id="bantuan_apbd_provinsi" name="bantuan_apbd_provinsi" class="form-control" placeholder="Masukkan anggaran" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="bantuan_apbd_kabupaten" class="mb-2">6. Penyertaan modal ke BUMDes</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rupiah</span>
                                                <input type="text" id="bantuan_apbd_kabupaten" name="bantuan_apbd_kabupaten" class="form-control" placeholder="Masukkan anggaran" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="hibah" class="mb-2">7. Lainnya (belanja tak terduga, konsumsi rapat, dll.)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rupiah</span>
                                                <input type="text" id="hibah" name="hibah" class="form-control" placeholder="Masukkan anggaran" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                </div>
                            </form>
                        </div>

                        <!-- Modal Info -->
                        <div class="modal fade" id="modalAnggaranDesa" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            <li>Isi nominal anggaran sesuai dengan sumbernya.</li>
                                            <li>Pastikan semua kolom terisi dengan benar.</li>
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
                            <h3 class="card-title">Jumlah Surat Keterangan Tidak Mampu/Miskin (SKTM) yang Dikeluarkan Pemerintah Desa</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toggle-form7">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toggle-form7").on("click", function() {
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
                                            <label class="mb-2">Jumlah SKTM yang Dikeluarkan 2024</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>

                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah SKTM yang Dikeluarkan 2025</label>
                                            <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
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
                            <h3 class="card-title">Pemanfaatan Sistem Informasi Desa dan Sistem Keuangan Desa </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toggle-form8">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toggle-form8").on("click", function() {
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
                                            <label class="mb-2">Sistem Informasi Desa</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">ADA, DIGUNAKAN</option>
                                                <option value="">ADA, JARANG DIGUNAKAN</option>
                                                <option value="">ADA, TIDAK DIGUNAKAN</option>
                                                <option value="">TIDAK ADA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Sistem Keuangan Desa</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">ADA, DIGUNAKAN</option>
                                                <option value="">ADA, JARANG DIGUNAKAN</option>
                                                <option value="">ADA, TIDAK DIGUNAKAN</option>
                                                <option value="">TIDAK ADA</option>
                                            </select>
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
                            <h3 class="card-title">Kerjasama Desa</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toggle-form9">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toggle-form9").on("click", function() {
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
                                            <label class="mb-2">Pihak yang diajak kerja sama 1</label>
                                            <input type="text" class="form-control" placeholder="Masukkan nama" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Lingkup kerja sama</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">ANTARDESA</option>
                                                <option value="">DENGAN SWASTA</option>
                                                <option value="">DENGAN LEMBAGA INTERNASIONAL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Tahun kerja sama berakhir</label>
                                            <input type="number" class="form-control" placeholder="Masukkan Tahun" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Pihak yang diajak kerja sama 2</label>
                                            <input type="text" class="form-control" placeholder="Masukkan nama" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Lingkup kerja sama</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">ANTARDESA</option>
                                                <option value="">DENGAN SWASTA</option>
                                                <option value="">DENGAN LEMBAGA INTERNASIONAL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Tahun kerja sama berakhir</label>
                                            <input type="number" class="form-control" placeholder="Masukkan Tahun" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Pihak yang diajak kerja sama 3</label>
                                            <input type="text" class="form-control" placeholder="Masukkan nama" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Lingkup kerja sama</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">ANTARDESA</option>
                                                <option value="">DENGAN SWASTA</option>
                                                <option value="">DENGAN LEMBAGA INTERNASIONAL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Tahun kerja sama berakhir</label>
                                            <input type="number" class="form-control" placeholder="Masukkan Tahun" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Pihak yang diajak kerja sama 4</label>
                                            <input type="text" class="form-control" placeholder="Masukkan nama" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Lingkup kerja sama</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">ANTARDESA</option>
                                                <option value="">DENGAN SWASTA</option>
                                                <option value="">DENGAN LEMBAGA INTERNASIONAL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Tahun kerja sama berakhir</label>
                                            <input type="number" class="form-control" placeholder="Masukkan Tahun" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Pihak yang diajak kerja sama 5</label>
                                            <input type="text" class="form-control" placeholder="Masukkan nama" min="0" step="1" style="width: 100%;">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Lingkup kerja sama</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">ANTARDESA</option>
                                                <option value="">DENGAN SWASTA</option>
                                                <option value="">DENGAN LEMBAGA INTERNASIONAL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <!-- /.col -->
                                    <div class>
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Tahun kerja sama berakhir</label>
                                            <input type="number" class="form-control" placeholder="Masukkan Tahun" min="0" step="1" style="width: 100%;">
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
                            <h3 class="card-title">Jumlah pengadaan barang dan jasa di Desa</h3>
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalAnggaranDesa">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toggle-form10">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toggle-form10").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombol
                                            var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                            $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi
                                            $icon.toggleClass("fa-minus fa-plus"); // Ganti ikon
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="anggaranDesaForm" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="dana_desa_apbn" class="mb-2">Jumlah pengadaan barang dan jasa (s.d akhir tahun 2023)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Paket</span>
                                                <input type="number" id="jumlah_pengadaan_desa" name="paket" class="form-control" placeholder="Masukkan banyaknya paket" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card card-primary card-outline mb-4">
                    <div class="card-header mb-3">
                        <h3 class="card-title">Jumlah publikasi (papan, website, dll) terbuka pengadaan barang dan jasa</h3>
                        <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalAnggaranDesa">
                            <i class="fas fa-info-circle"></i>
                        </button>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool toggle-form11">
                                <i class="fas fa-minus"></i>
                            </button>
                            <script>
                                $(document).ready(function() {
                                    $(".toggle-form11").on("click", function() {
                                        var $icon = $(this).find("i"); // Ambil ikon tombol
                                        var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                        $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi
                                        $icon.toggleClass("fa-minus fa-plus"); // Ganti ikon
                                    });
                                });
                            </script>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="anggaranDesaForm" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="dana_desa_apbn" class="mb-2">Jumlah publikasi (s.d akhir tahun 2023)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Publikasi</span>
                                            <input type="number" id="jumlah_publikasi" name="publikasi" class="form-control" placeholder="Masukkan banyaknya publikasi" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card card-primary card-outline mb-4">
                <div class="card-header mb-3">
                    <h3 class="card-title">Ketersedian Data Statistik Desa dan Petugas yang menangani statistik </h3>
                    <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalAnggaranDesa">
                        <i class="fas fa-info-circle"></i>
                    </button>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool toggle-form12">
                            <i class="fas fa-minus"></i>
                        </button>
                        <script>
                            $(document).ready(function() {
                                $(".toggle-form12").on("click", function() {
                                    var $icon = $(this).find("i"); // Ambil ikon tombol
                                    var $cardBody = $(this).closest(".card").find(".card-body"); // Ambil elemen card-body

                                    $cardBody.slideToggle(); // Menampilkan/menghilangkan dengan animasi
                                    $icon.toggleClass("fa-minus fa-plus"); // Ganti ikon
                                });
                            });
                        </script>
                    </div>
                </div>
                <div class="card-body">
                    <form id="anggaranDesaForm" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="dana_desa_apbn" class="mb-2">Ketersediaan Data Statistik Desa</label>
                                    <select name="" id="" class="form-control">
                                        <option value="">ADA</option>
                                        <option value="">TIDAK ADA</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="dana_desa_apbn" class="mb-2">Jumlah petugas yang menangani statistik (orang)</label>
                                        <input type="number" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
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
    </div>

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