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
    <!-- iCheck for checkboxes and radio input required  -->
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
                            <h3 class="mb-0">Fasilitas Umum</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Keadaan Geografi
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content Header--> <!--begin::App Content-->
            <div class="app-content"> <!--begin::Container-->

                <!-- BEGIN:: CONTAINER JUMLAH TEMPAT PERIBADATAN -->
                <div class="container-fluid"> <!--begin::Row-->

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Jumlah Tempat Peribadatan Menurut Desa/Kelurahan</h3>
                            <!-- BEGIN:: INFO BUTTON -->
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#aturanModalDesa">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <!-- Modal Info -->
                            <div class="modal fade" id="aturanModalDesa" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Isi Dengan Angka Atau Jumlah</li>
                                                <li>Isi Dengan Angka Atau Jumlah</li>
                                                <li>Isi Dengan Angka Atau Jumlah</li>
                                                <li>Isi Dengan Angka Atau Jumlah</li>
                                                <li>Isi Dengan Angka Atau Jumlah</li>
                                                <li>Isi Dengan Angka Atau Jumlah</li>
                                                <li>Isi Dengan Angka Atau Jumlah</li>
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
                                            var $icon = $(this).find("i"); // Ambil ikon tombo l
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
                                    <div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Masjid</label>
                                            <input required type="text" class="form-control" Required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Mushola</label>
                                            <input required type="text" class="form-control" >
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Gereja Protestean</label>
                                            <input required type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Gereja Katolik</label>
                                            <input required type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Pura</label>
                                            <input required type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Vihara</label>
                                            <input required type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Klenteng</label>
                                            <input required type="text" class="form-control">
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                const apiUrl = "https://script.google.com/macros/s/AKfycbxQ6XoS1RW6UZHRxV3dBiVWb2WsIQVNcwI9_yB7FErj5cyXWZ51FTStmTlD_7bAa5zV/exec";

                                                fetch(apiUrl)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (!data || !data.data || !Array.isArray(data.data)) {
                                                            throw new Error("Data dari API tidak valid");
                                                        }

                                                        const villages = data.data;
                                                        const villageCodeSelect = $("#villageCodeSelect");
                                                        const villageNameSelect = $("#villageNameSelect");

                                                        // Bersihkan opsi lama
                                                        villageCodeSelect.empty().append('<option value="" selected>Otomatis Terisi</option>');
                                                        villageNameSelect.empty().append('<option value="" selected>Cari Nama Desa</option>');

                                                        // Sort data berdasarkan Nama Desa
                                                        villages.sort((a, b) => a['Nama_Desa'].localeCompare(b['Nama_Desa']));

                                                        // Isi dropdown Nama Desa
                                                        villages.forEach(village => {
                                                            villageNameSelect.append(
                                                                new Option(village['Nama_Desa'], village['Kode_Desa'])
                                                            );
                                                        });

                                                        // Inisialisasi Select2
                                                        villageNameSelect.select2({
                                                            theme: "bootstrap4" // Pastikan tema sesuai jika menggunakan select2bs4
                                                        });

                                                        // Event listener untuk Nama Desa
                                                        villageNameSelect.on("change", function() {
                                                            const selectedKodeDesa = $(this).val();

                                                            // Temukan pasangan Kode Desa
                                                            const selectedVillage = villages.find(village => village['Kode_Desa'] === selectedKodeDesa);

                                                            // Update dropdown Kode Desa
                                                            if (selectedVillage) {
                                                                villageCodeSelect.empty().append(
                                                                    new Option(selectedVillage['Kode_Desa'], selectedVillage['Kode_Desa'], true, true)
                                                                );
                                                            } else {
                                                                villageCodeSelect.empty().append('<option value="" selected>Otomatis Terisi</option>');
                                                            }
                                                        });

                                                        // Event listener untuk Kode Desa
                                                        villageCodeSelect.on("change", function() {
                                                            const selectedKodeDesa = $(this).val();

                                                            // Update Nama Desa sesuai Kode Desa
                                                            const selectedVillage = villages.find(village => village['Kode_Desa'] === selectedKodeDesa);

                                                            if (selectedVillage) {
                                                                villageNameSelect.val(selectedVillage['Kode_Desa']).trigger("change");
                                                            } else {
                                                                villageNameSelect.val("").trigger("change");
                                                            }
                                                        });
                                                    })
                                                    .catch(error => {
                                                        console.error("Terjadi kesalahan saat memuat data desa:", error);
                                                    });
                                            });
                                        </script>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                            </form>
                            <!-- /.row -->
                        </div>
                    </div>
                </div> <!--end::Container-->
                <!-- END:: CONTAINER TEMPAT PERIBADATAN -->

                <!-- BEGIN:: container Tempat Peribadatan -->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="card card-primary card-outline mb-4 card0">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Daftar Tempat Peribadatan</h3>

                            <!-- BEGIN:: INFO BUTTON -->
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#aturanModalDesa">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <!-- Modal Info -->
                            <div class="modal fade" id="aturanModalDesa" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Isi Nama Pondok Pesantren</li>
                                                <li>Isi Alamat Pondok Pesantren</li>
                                                <li>Pilih Status Sekolah Yang Sesuai</li>
                                                <li>Isi Nama Kecamatan Tempat Sekolah</li>
                                                <li>Pengisian Titik Kordinat Lintang Menggunakan Derajat Desimal , Contoh: -6.8796 LS</li>
                                                <li>Pengisian Titik Kordinat Bujur Menggunakan Derajat Desimal , Contoh: 108.5538 BT</li>


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
                                <!-- begin:: Tempat Peribadatan ke 1 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 1</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input required id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 1 -->

                                <!-- begin:: Tempat Peribadatan ke 2 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan ke 2</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 2 -->

                                <!-- begin:: Tempat Peribadatan ke 3 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 3</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 3 -->

                                <!-- begin:: Tempat Peribadatan ke 4 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 4</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input required id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 4 -->

                                <!-- begin:: Tempat Peribadatan ke 5 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan ke 5</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 5 -->

                                <!-- begin:: Tempat Peribadatan ke 6 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 6</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 6 -->

                                <!-- begin:: Tempat Peribadatan ke 7 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 7</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input required id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 7 -->

                                <!-- begin:: Tempat Peribadatan ke 8 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan ke 8</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 8 -->

                                <!-- begin:: Tempat Peribadatan ke 9 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 9</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 9 -->

                                <!-- begin:: Tempat Peribadatan ke 10 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 10</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input required id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 10 -->

                                <!-- begin:: Tempat Peribadatan ke 11 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan ke 11</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 11 -->

                                <!-- begin:: Tempat Peribadatan ke 12 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 12</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 12 -->

                                <!-- begin:: Tempat Peribadatan ke 13 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 13</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input required id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 13 -->

                                <!-- begin:: Tempat Peribadatan ke 14 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan ke 14</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 14 -->

                                <!-- begin:: Tempat Peribadatan ke 15 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 15</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 15 -->

                                <!-- begin:: Tempat Peribadatan ke 16 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 16</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input required id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 16 -->

                                <!-- begin:: Tempat Peribadatan ke 17 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan ke 17</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 17 -->

                                <!-- begin:: Tempat Peribadatan ke 17 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 17</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 17 -->

                                <!-- begin:: Tempat Peribadatan ke 18 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 7</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input required id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 18 -->

                                <!-- begin:: Tempat Peribadatan ke 19 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan ke 19</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 19 -->

                                <!-- begin:: Tempat Peribadatan ke 20 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 20</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 20 -->

                                <!-- begin:: Tempat Peribadatan ke 21 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 10</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="koordinat_bujur_ke1">Koordinat Bujur</label>
                                                        <input required id="koordinat_bujur_ke1" type="text"
                                                            class="form-control koordinat_bujur_ke1">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 21 -->

                                <!-- begin:: Tempat Peribadatan ke 22 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan ke 22</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" name="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat_ke1">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 22 -->

                                <!-- begin:: Tempat Peribadatan ke 23 -->
                                <div class="border p-3 mb-3">
                                    <div class="card-header mb-3">

                                        <h2 class="card-title mb-3">Tempat Peribadatan Ke 23</h2>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jenis Tempat Ibadah</label>
                                            <select id="jenis_tempat_peribadatan" name="jenis_tempat_peribadatan" class="form-control select2bs4"
                                                style="width: 100%;">
                                                <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                                                <option value="Masjid">Masjid</option>
                                                <option value="Mushola">Mushola</option>
                                                <option value="Gereja Protestan">Gereja Protestan</option>
                                                <option value="Gereja Katolik">Gereja Katolik</option>
                                                <option value="Gereja Katolik">Pura</option>
                                                <option value="Vihara">Vihara</option>
                                                <option value="Klenteng">Klenteng </option>
                                            </select>
                                        </div>
                                        <div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Nama Tempat Peribadatan</label>
                                                <input required id="nama_tempat_peribadatan" type="text" class="form-control">
                                            </div>

                                            <div class="titik_koordinat">
                                                <label for="titik_koordinat">Titik Koordinat</label>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <label for="titik_koordinat_lintang">Koordinat Lintang</label>
                                                        <input required id="titik_koordinat_lintang" type="text"
                                                            class="form-control titik_koordinat_lintang">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="titik_koordinat_bujur">Koordinat Bujur</label>
                                                        <input required id="titik_koordinat_bujur" type="text"
                                                            class="form-control titik_koordinat_bujur">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end:: Tempat Peribadatan ke 23 -->

                                <div class="col-md-6">

                                    <button type="submit" class="btn btn-primary mt-3">Simpan Semua</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END:: contaainer Tempat Peribadatan -->

                <!-- BEGIN:: CONTAINER JUMLAH TEMPAT PERIBADATAN -->
                <div class="container-fluid"> <!--begin::Row-->

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Jumlah Prasarana Olahraga yang berlokasi di Desa/Kelurahan</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool jumlah_olahraga">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".jumlah_olahraga").on("click", function() {
                                            var $icon = $(this).find("i"); // Ambil ikon tombo l
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
                                    <div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Lapangan Sepak Bola</label>
                                            <input required type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Lapangan Futsal</label>
                                            <input required type="text" class="form-control">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Lapangan Bulu tangkis</label>
                                            <input required type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Meja Pingpong</label>
                                            <input required type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Lapangan Tenis</label>
                                            <input required type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Lapangan Voli</label>
                                            <input required type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Lapangan Basket</label>
                                            <input required type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Pusat Kebugaran / GYM</label>
                                            <input required type="text" class="form-control">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jumlah Gelanggang Remaja</label>
                                            <input required type="text" class="form-control">
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                const apiUrl = "https://script.google.com/macros/s/AKfycbxQ6XoS1RW6UZHRxV3dBiVWb2WsIQVNcwI9_yB7FErj5cyXWZ51FTStmTlD_7bAa5zV/exec";

                                                fetch(apiUrl)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (!data || !data.data || !Array.isArray(data.data)) {
                                                            throw new Error("Data dari API tidak valid");
                                                        }

                                                        const villages = data.data;
                                                        const villageCodeSelect = $("#villageCodeSelect");
                                                        const villageNameSelect = $("#villageNameSelect");

                                                        // Bersihkan opsi lama
                                                        villageCodeSelect.empty().append('<option value="" selected>Otomatis Terisi</option>');
                                                        villageNameSelect.empty().append('<option value="" selected>Cari Nama Desa</option>');

                                                        // Sort data berdasarkan Nama Desa
                                                        villages.sort((a, b) => a['Nama_Desa'].localeCompare(b['Nama_Desa']));

                                                        // Isi dropdown Nama Desa
                                                        villages.forEach(village => {
                                                            villageNameSelect.append(
                                                                new Option(village['Nama_Desa'], village['Kode_Desa'])
                                                            );
                                                        });

                                                        // Inisialisasi Select2
                                                        villageNameSelect.select2({
                                                            theme: "bootstrap4" // Pastikan tema sesuai jika menggunakan select2bs4
                                                        });

                                                        // Event listener untuk Nama Desa
                                                        villageNameSelect.on("change", function() {
                                                            const selectedKodeDesa = $(this).val();

                                                            // Temukan pasangan Kode Desa
                                                            const selectedVillage = villages.find(village => village['Kode_Desa'] === selectedKodeDesa);

                                                            // Update dropdown Kode Desa
                                                            if (selectedVillage) {
                                                                villageCodeSelect.empty().append(
                                                                    new Option(selectedVillage['Kode_Desa'], selectedVillage['Kode_Desa'], true, true)
                                                                );
                                                            } else {
                                                                villageCodeSelect.empty().append('<option value="" selected>Otomatis Terisi</option>');
                                                            }
                                                        });

                                                        // Event listener untuk Kode Desa
                                                        villageCodeSelect.on("change", function() {
                                                            const selectedKodeDesa = $(this).val();

                                                            // Update Nama Desa sesuai Kode Desa
                                                            const selectedVillage = villages.find(village => village['Kode_Desa'] === selectedKodeDesa);

                                                            if (selectedVillage) {
                                                                villageNameSelect.val(selectedVillage['Kode_Desa']).trigger("change");
                                                            } else {
                                                                villageNameSelect.val("").trigger("change");
                                                            }
                                                        });
                                                    })
                                                    .catch(error => {
                                                        console.error("Terjadi kesalahan saat memuat data desa:", error);
                                                    });
                                            });
                                        </script>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                            </form>
                            <!-- /.row -->
                        </div>
                    </div>
                </div> <!--end::Container-->

                <footer class="app-footer"> <!--begin::To the end-->
                    <div class="float-end d-none d-sm-inline">Version 1.0</div> <!--end::To the end--> <!--begin::Copyright-->
                    <strong>
                        Copyright &copy; 2024&nbsp;
                        <a href="#" class="text-decoration-none">Diskominfo Kab. Cirebon</a>.
                    </strong>
                    All rights reserved.
                    <!--end::Copyright-->
                </footer> <!--end::Footer-->
                <!-- END:: CONTAINER TEMPAT PERIBADATAN -->
            </div> <!--end::App Content-->
        </main> <!--end::App Main--> <!--begin::Footer-->
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
    <!-- Input required ask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/input required ask/jquery.input required ask.min.js"></script>
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