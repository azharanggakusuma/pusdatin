<?php
include_once "../../config/conn.php";
include "../../config/session.php";
?>


<?php

// Ambil data pengguna yang sedang login
$username = $_SESSION['username'] ?? '';
$level = $_SESSION['level'] ?? ''; // Ambil level pengguna

$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Cek apakah form sudah terkunci
$is_locked = false; // Default tidak terkunci
if ($level !== 'admin') { // Logika kunci hanya berlaku untuk level user
    $query_progress = "SELECT is_locked FROM user_progress WHERE user_id = '$user_id' AND form_name = 'Data Desa'";
    $result_progress = mysqli_query($conn, $query_progress);
    $progress = mysqli_fetch_assoc($result_progress);
    $is_locked = $progress['is_locked'] ?? false;
}
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin: Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../../../dist/css/adminlte.css"><!--end: Plugin(AdminLTE)-->

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

        <?php include('../../components/sidebar.php'); ?>
        <!--end::Sidebar--> <!--begin::App Main-->

        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Form Data Desa</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Data Desa
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
                            <h3 class="card-title">Data Desa</h3>
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#aturanModalDesa">
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
                            <?php if ($is_locked): ?>
                                <!-- Alert Bootstrap dengan Inovasi -->
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                            <?php else: ?>
                                <form action="../../handlers/form_enumerator.php" method="post">
                                    <div class="row">
                                        <!-- Nama
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Lengkap</label>
                                            <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama">
                                        </div>-->

                                        <!-- Alamat
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Alamat</label>
                                            <textarea name="alamat" class="form-control" rows="4" placeholder="Masukkan Alamat"></textarea>
                                            <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">Data Pada Tahun Sebelumnya : Lorem, ipsum dolor sit amet consectetur adipisicing elit. Blanditiis, impedit! </p>

                                        </div>-->

                                        <!-- No HP
                                        <div class="form-group mb-3">
                                            <label class="mb-2">No HP</label>
                                            <div class="input-group">
                                                <span class="input-group-text">+62</span>
                                                <input type="tel" name="no_hp" class="form-control" placeholder="Masukkan No HP tanpa 0 di awal" pattern="[0-9]
                                                {9,12}">

                                            </div>
                                            <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">Data Pada Tahun Sebelumnya : Lorem, ipsum dolor sit amet consectetur adipisicing elit. Blanditiis, impedit! </p>

                                        </div>-->

                                        <!-- Kode Desa -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Kode Desa</label>
                                            <select disabled id="villageCodeSelect" class="form-control" style="width: 100%;">
                                                <option value="" selected>Otomatis Terisi</option>
                                            </select>
                                            <!-- Hidden Input untuk Kode Desa -->
                                            <input type="hidden" name="kode_desa" id="kodeDesaHidden">
                                        </div>

                                        <!-- Nama Desa -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Nama Desa</label>
                                            <select id="villageNameSelect" class="form-control select2bs4" style="width: 100%;">
                                                <option value="" selected>Cari Nama Desa</option>
                                            </select>
                                            <!-- Hidden Input untuk Nama Desa -->
                                            <input type="hidden" name="nama_desa" id="namaDesaHidden">
                                        </div>

                                        <!-- Kecamatan -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Kecamatan</label>
                                            <select disabled id="subDistrictSelect" class="form-control" style="width: 100%;">
                                                <option value="" selected>Otomatis Terisi</option>
                                            </select>
                                            <input type="hidden" name="kecamatan" id="kecamatanHidden">
                                        </div>
                                    </div>

                                    <!-- Tombol Simpan -->
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>

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
                                            <li>Isi Nama Desa sesuai pilihan yang tersedia.</li>
                                            <li>Setelah Nama Desa dipilih, Kode Desa dan Nama Kecamatan akan terisi otomatis.</li>
                                            <li>Pastikan data lainnya seperti Nama, Alamat, dan No HP diisi dengan benar.</li>
                                            <li>Format No HP harus tanpa awalan 0, contohnya: 81234567890.</li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>

                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                            <?php if (isset($_GET['status'])): ?>
                                <script>
                                    let status = "<?= $_GET['status'] ?>";
                                    if (status === 'success') {
                                        Swal.fire({
                                            title: "Berhasil!",
                                            text: "Data berhasil ditambahkan.",
                                            icon: "success",
                                            timer: 3000,
                                            showConfirmButton: false
                                        }).then(() => {
                                            window.location.href = "data_enumerator.php";
                                        });
                                    } else if (status === 'error') {
                                        Swal.fire({
                                            title: "Gagal!",
                                            text: "Terjadi kesalahan saat menambahkan data.",
                                            icon: "error",
                                            timer: 3000,
                                            showConfirmButton: false
                                        }).then(() => {
                                            window.location.href = "data_enumerator.php";
                                        });
                                    } else if (status === 'warning') {
                                        Swal.fire({
                                            title: "Peringatan!",
                                            text: "Mohon lengkapi semua data.",
                                            icon: "warning",
                                            timer: 3000,
                                            showConfirmButton: false
                                        }).then(() => {
                                            window.location.href = "data_enumerator.php";
                                        });
                                    }
                                </script>
                            <?php endif; ?>

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
                                            const subDistrictSelect = $("#subDistrictSelect");
                                            const kodeDesaHidden = $("#kodeDesaHidden");
                                            const namaDesaHidden = $("#namaDesaHidden");
                                            const kecamatanHidden = $("#kecamatanHidden");

                                            villageCodeSelect.empty().append('<option value="" selected>Otomatis Terisi</option>');
                                            villageNameSelect.empty().append('<option value="" selected>Cari Nama Desa</option>');
                                            subDistrictSelect.empty().append('<option value="" selected>Otomatis Terisi</option>');

                                            villages.sort((a, b) => a['Nama_Desa'].localeCompare(b['Nama_Desa']));

                                            villages.forEach(village => {
                                                villageNameSelect.append(
                                                    new Option(village['Nama_Desa'], village['Kode_Desa'])
                                                );
                                            });

                                            villageNameSelect.select2({
                                                theme: "bootstrap4"
                                            });

                                            villageNameSelect.on("change", function() {
                                                const selectedKodeDesa = $(this).val();
                                                const selectedVillage = villages.find(village => village['Kode_Desa'] === selectedKodeDesa);

                                                if (selectedVillage) {
                                                    villageCodeSelect.empty().append(
                                                        new Option(selectedVillage['Kode_Desa'], selectedVillage['Kode_Desa'], true, true)
                                                    );
                                                    subDistrictSelect.empty().append(
                                                        new Option(selectedVillage['Kecamatan'], selectedVillage['Kecamatan'], true, true)
                                                    );
                                                    kodeDesaHidden.val(selectedVillage['Kode_Desa']);
                                                    namaDesaHidden.val(selectedVillage['Nama_Desa']);
                                                    kecamatanHidden.val(selectedVillage['Kecamatan']);
                                                } else {
                                                    villageCodeSelect.empty().append('<option value="" selected>Otomatis Terisi</option>');
                                                    subDistrictSelect.empty().append('<option value="" selected>Otomatis Terisi</option>');
                                                    kodeDesaHidden.val("");
                                                    namaDesaHidden.val("");
                                                    kecamatanHidden.val("");
                                                }
                                            });
                                        })
                                        .catch(error => {
                                            console.error("Terjadi kesalahan saat memuat data desa:", error);
                                        });
                                });
                            </script>

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

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin: Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end: Plugin(popperjs for Bootstrap 5)--><!--begin: Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end: Plugin(Bootstrap 5)--><!--begin: Plugin(AdminLTE)-->
    <script src="../../../dist/js/adminlte.js"></script> <!--end: Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
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