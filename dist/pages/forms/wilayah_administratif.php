<?php
include_once "../../config/conn.php";
include "../../config/session.php";
?>

<?php
// Ambil data pengguna yang sedang login
$username = $_SESSION['username'] ?? '';
$level = $_SESSION['level'] ?? '';

$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// List of forms
include('../../config/list_form.php');

// Initialize an array to store form lock status
$form_status = [];

foreach ($forms as $form) {
    // Check if the form is locked
    $is_locked = false;
    if ($level !== 'admin') { // Logika kunci hanya berlaku untuk level user
        $query_progress = "SELECT is_locked FROM user_progress WHERE user_id = '$user_id' AND form_name = '$form'";
        $result_progress = mysqli_query($conn, $query_progress);
        $progress = mysqli_fetch_assoc($result_progress);
        $is_locked = $progress['is_locked'] ?? false;
    }

    // Store the status in the array
    $form_status[$form] = $is_locked;
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

        <?php include('../../components/sidebar.php'); ?> <!--end::Sidebar--> <!--begin::App Main-->

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
                        window.location.href = "wilayah_administratif.php";
                    });
                } else if (status === 'error') {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi kesalahan saat menambahkan data.",
                        icon: "error",
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "wilayah_administratif.php";
                    });
                } else if (status === 'warning') {
                    Swal.fire({
                        title: "Peringatan!",
                        text: "Mohon lengkapi semua data.",
                        icon: "warning",
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "wilayah_administratif.php";
                    });
                }
            </script>
        <?php endif; ?>

        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Wilayah Administratif</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Wilayah Administratif
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
                            <h3 class="card-title">Status Pemerintahan Desa dan Klasifikasi Berdasarkan Tingkat Perkembangannya</h3>
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
                                                <li>Pilih Jenjang Klasifikasi Desa Yang Sesuai</li>
                                                <li>Pilih Status Pemerintahan Yang Sesuai</li>
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
                            <?php if ($form_status['Status Pemerintahan Desa dan Klasifikasi Berdasarkan Tingkat Perkembangannya']) : ?>
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form action="../../handlers/form_status_pemerintahan_desa.php" method="post">
                                    <div class="row">
                                        <!-- /.col -->
                                        <div>
                                            <!-- /.form-group -->
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Klasifikasi Desa (Swasembada/ Swakarya/ Swadaya)</label>
                                                <select name="klasifikasi_desa" class="form-control">
                                                    <option value="" disabled selected>-- Pilih Klasifikasi Desa --</option>
                                                    <option value="SWASEMBADA">SWASEMBADA</option>
                                                    <option value="SWAKARYA">SWAKARYA</option>
                                                    <option value="SWADAYA">SWADAYA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <!-- /.col -->
                                        <div>
                                            <!-- /.form-group -->
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Status Pemerintahan (Desa/Kelurahan/Kampung/Nagari/Gampong)</label>
                                                <select name="status_pemerintahan" class="form-control">
                                                    <option value="" disabled selected>-- Pilih Status Pemerintahan --</option>
                                                    <option value="DESA">DESA</option>
                                                    <option value="KELURAHAN">KELURAHAN</option>
                                                    <option value="KAMPUNG">KAMPUNG</option>
                                                    <option value="NAGARI">NAGARI</option>
                                                    <option value="GAMPONG">GAMPONG</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <div class="mb-3"> <button type="submit" class="btn btn-primary mt-3">Simpan</button> </div> <!--end::Footer-->
                                </form>
                            <?php endif; ?>
                            <!-- /.row -->
                        </div>
                    </div>

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Banyaknya Dusun, Rukun Tetangga dan Rukun Warga</h3>
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
                                                <li>Masukan Angka/Jumlah</li>
                                                <li>Masukan Angka/Jumlah</li>
                                                <li>Masukan Angka/Jumlah</li>
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
                            <?php if ($form_status['Banyaknya Dusun, Rukun Tetangga dan Rukun Warga']) : ?>
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form action="../../handlers/form_banyaknya_dusun_rt_rw.php" method="post">
                                    <div class="row">
                                        <!-- /.col -->
                                        <div>
                                            <!-- /.form-group -->
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Jumlah Dusun/Lingkungan/Sebutan Lain yang sejenis</label>
                                                <input type="number" name="jumlah_dusun" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div>
                                            <!-- /.form-group -->
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Banyaknya RW</label>
                                                <input type="number" name="jumlah_rw" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                        <div>
                                            <!-- /.form-group -->
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Banyaknya RT</label>
                                                <input type="number" name="jumlah_rt" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1" style="width: 100%;">
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <div class="mb-3"> <button type="submit" class="btn btn-primary mt-3">Simpan</button> </div> <!--end::Footer-->
                                </form>
                            <?php endif; ?>
                            <!-- /.row -->
                        </div>
                    </div>

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Alamat Balai Desa/Kantor Kelurahan</h3>
                            <!-- BEGIN:: INFO BUTTON -->
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#aturanBalaiDesa">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <!-- Modal Info -->
                            <div class="modal fade" id="aturanBalaiDesa" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Masukkan Alamat Balai Desa/Kantor Dengan Benar</li>
                                                <li>Masukkan Nama Kecamatan Tempat Balai Desa/Kantor Kelurahan</li>
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
                            <?php if ($form_status['Alamat Balai Desa/Kantor Kelurahan']) : ?>
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form action="../../handlers/form_alamat_balai_desa.php" method="post">
                                    <div class="row">
                                        <!-- /.col -->
                                        <div>
                                            <!-- /.form-group -->
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Alamat Balai Desa</label>
                                                <input type="text" name="alamat_balai_desa" class="form-control" placeholder="Masukkan alamat balai/kantor" min="0" step="1" style="width: 100%;">
                                            </div>
                                        </div>

                                        <!-- /.col -->
                                        <!-- /.col -->
                                        <div>
                                            <!-- /.form-group -->
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Kecamatan</label>
                                                <input type="text" name="kecamatan" class="form-control" placeholder="Masukkan kecamatan" min="0" step="1" style="width: 100%;">
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <div class="mb-3"> <button type="submit" class="btn btn-primary mt-3">Simpan</button> </div> <!--end::Footer-->
                                </form>
                            <?php endif; ?>
                            <!-- /.row -->
                        </div>

                    </div> <!--end::Container-->

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Dasar hukum pembentukan Pemerintah Desa / Kelurahan</h3>
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#aturanDasarHukum">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <!-- Modal Info -->
                            <div class="modal fade" id="aturanDasarHukum" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Pilih ketersediaan Dasar Hukum Yang Sesuai</li>
                                                <li>Isi No Peraturan Pembentukan Desa Berupa Perda/Perbup/Kebup/Lainnya</li>
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

                                        // Menangani perubahan pilihan dasar hukum
                                        $('select[name="dasar_hukum"]').change(function() {
                                            if ($(this).val() === 'TIDAK ADA') {
                                                $('input[name="no_peraturan"]').val('TIDAK ADA').prop('readonly', true);
                                            } else {
                                                $('input[name="no_peraturan"]').val('').prop('readonly', false);
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php if ($form_status['Dasar hukum pembentukan Pemerintah Desa / Kelurahan']) : ?>
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form action="../../handlers/form_dasar_hukum_pembentukan_desa.php" method="post">
                                    <div class="form-group mb-3">
                                        <label class="mb-2">Ketersediaan Dasar Hukum Pembentukan Pemerintah Desa / Kelurahan</label>
                                        <select name="dasar_hukum" class="form-control">
                                            <option value="" disabled selected>-- Pilih Ketersediaan Dasar Hukum --</option>
                                            <option value="ADA">ADA</option>
                                            <option value="TIDAK ADA">TIDAK ADA</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="mb-2">Jika Kolom di atas Ada, No Peraturan/Keputusan Pendirian Desa</label>
                                        <input type="text" name="no_peraturan" class="form-control" placeholder="Masukkan No Peraturan" min="0" step="1" style="width: 100%;">
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Dasar hukum pembentukan Badan Permusyawaratan Desa (BPD)</h3>
                            <!-- BEGIN:: INFO BUTTON -->
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#aturanDasarHukumBPD">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <!-- Modal Info -->
                            <div class="modal fade" id="aturanDasarHukumBPD" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Pilih ketersediaan Dasar Hukum Yang Sesuai</li>
                                                <li>Isi No Peraturan Pembentukan BPD Berupa Perda/Perbup/Kebup/Lainnya</li>
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
                            <?php if ($form_status['Dasar hukum pembentukan Badan Permusyawaratan Desa (BPD)']) : ?>
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form action="../../handlers/form_dasar_hukum_bpd.php" method="post">
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Ketersediaan Dasar Hukum Badan Permusyawaratan Desa (BPD)</label>
                                            <select name="ketersediaan_dasar_hukum" id="ketersediaan_dasar_hukum" class="form-control">
                                                <option value="" disabled selected>-- Pilih Ketersediaan Dasar Hukum --</option>
                                                <option value="ADA">ADA</option>
                                                <option value="TIDAK ADA">TIDAK ADA</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jika kolom di atas Ada, Nomor Peraturan/Keputusan Badan Permusyawaratan Desa (BPD)</label>
                                            <input type="text" name="nomor_peraturan" id="nomor_peraturan" class="form-control" placeholder="Masukkan No Peraturan" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                    <script>
                        document.getElementById('ketersediaan_dasar_hukum').addEventListener('change', function() {
                            var nomorPeraturanInput = document.getElementById('nomor_peraturan');
                            if (this.value === 'ADA') {
                                nomorPeraturanInput.removeAttribute('readonly');
                            } else {
                                nomorPeraturanInput.setAttribute('readonly', true);
                                nomorPeraturanInput.value = 'TIDAK ADA';
                            }
                        });
                    </script>

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Ketersediaan Penetapan Batas dan Peta Desa</h3>
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#PenetapanBatasDesa">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <div class="modal fade" id="PenetapanBatasDesa" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Pilih antara SUDAH ADA atau BELUM ADA untuk Penetapan Batas Desa.</li>
                                                <li>Isi No SK/Perbup/Perda/Perdes jika SUDAH ADA, atau otomatis BELUM ADA jika tidak.</li>
                                                <li>Pilih antara ADA atau TIDAK ADA untuk Ketersediaan Peta Desa.</li>
                                                <li>Isi No SK/Perbup/Perda jika ADA, atau otomatis TIDAK ADA jika tidak.</li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toggle-form5">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toggle-form5").on("click", function() {
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
                            <?php if ($form_status['Ketersediaan Penetapan Batas dan Peta Desa']) : ?>
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form action="../../handlers/form_ketersediaan_penetapan_batas.php" method="post">
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Penetapan Batas Desa</label>
                                            <select name="penetapan_batas_desa" id="penetapan_batas_desa" class="form-control">
                                                <option value="" disabled selected>-- Pilih Penetapan Batas Desa --</option>
                                                <option value="SUDAH ADA">SUDAH ADA</option>
                                                <option value="BELUM ADA">BELUM ADA</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">No SK/Perbup/Perda/Perdes tentang Penetapan Batas Desa</label>
                                            <input type="text" name="no_surat_batas_desa" id="no_surat_batas_desa" class="form-control" placeholder="Masukkan No Peraturan" readonly>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Ketersediaan Peta Desa</label>
                                            <select name="ketersediaan_peta_desa" id="ketersediaan_peta_desa" class="form-control">
                                                <option value="" disabled selected>-- Pilih Ketersediaan Peta Desa --</option>
                                                <option value="ADA">ADA</option>
                                                <option value="TIDAK ADA">TIDAK ADA</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">No SK/Perbup/Perda tentang Peta Desa</label>
                                            <input type="text" name="no_surat_peta_desa" id="no_surat_peta_desa" class="form-control" placeholder="Masukkan No Peraturan" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                    <script>
                        document.getElementById('penetapan_batas_desa').addEventListener('change', function() {
                            const noSuratBatasDesa = document.getElementById('no_surat_batas_desa');
                            if (this.value === 'SUDAH ADA') {
                                noSuratBatasDesa.readOnly = false;
                                noSuratBatasDesa.value = '';
                            } else {
                                noSuratBatasDesa.readOnly = true;
                                noSuratBatasDesa.value = 'BELUM ADA';
                            }
                        });

                        document.getElementById('ketersediaan_peta_desa').addEventListener('change', function() {
                            const noSuratPetaDesa = document.getElementById('no_surat_peta_desa');
                            if (this.value === 'ADA') {
                                noSuratPetaDesa.readOnly = false;
                                noSuratPetaDesa.value = '';
                            } else {
                                noSuratPetaDesa.readOnly = true;
                                noSuratPetaDesa.value = 'TIDAK ADA';
                            }
                        });
                    </script>

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Alamat Website dan Media Sosial</h3>
                            <!-- BEGIN:: INFO BUTTON -->
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#alamatWebsite">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <!-- Modal Info -->
                            <div class="modal fade" id="alamatWebsite" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Isi Alamat Website Desa dengan URL yang valid.</li>
                                                <li>Isi Alamat Email Desa dengan format email yang benar.</li>
                                                <li>Isi Alamat Facebook Desa dengan URL halaman Facebook.</li>
                                                <li>Isi Alamat Twitter Desa dengan URL profil Twitter.</li>
                                                <li>Isi Alamat YouTube Desa dengan URL channel YouTube.</li>
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
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php if ($form_status['Alamat Website dan Media Sosial']) : ?>
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form action="../../handlers/form_alamat_website_medsos.php" method="post">
                                    <div class="form-group mb-3">
                                        <label class="mb-2">Alamat Website Desa</label>
                                        <input type="text" name="alamat_website" class="form-control" placeholder="Masukkan alamat website">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="mb-2">Alamat Email Desa</label>
                                        <input type="email" name="alamat_email" class="form-control" placeholder="Masukkan alamat email">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="mb-2">Alamat Facebook Desa</label>
                                        <input type="text" name="alamat_facebook" class="form-control" placeholder="Masukkan alamat Facebook">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="mb-2">Alamat Twitter Desa</label>
                                        <input type="text" name="alamat_twitter" class="form-control" placeholder="Masukkan alamat Twitter">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="mb-2">Alamat YouTube Desa</label>
                                        <input type="text" name="alamat_youtube" class="form-control" placeholder="Masukkan alamat YouTube">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                </form>
                            <?php endif; ?>
                            <!-- /.row -->
                        </div>
                    </div> <!--end::Container-->

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Kepemilikan Kantor Kepala Desa/Balai Desa</h3>
                            <!-- BEGIN:: INFO BUTTON -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#kondisiDesa">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <!-- Modal Info -->
                            <div class="modal fade" id="kondisiDesa" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Pilih Kondisi Kantor Kepala Desa Antara ("ADA,LAYAK","ADA, TIDAK LAYAK","TIDAK ADA")</li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END:: INFO BUTTON -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php if ($form_status['Kepemilikan Kantor Kepala Desa/Balai Desa']) : ?>
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form action="../../handlers/form_kepemilikan_kantor.php" method="post">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Aset Desa/Bukan Aset Desa</label>
                                                <select name="aset_desa" id="aset_desa" class="form-control">
                                                    <option value="" disabled selected>-- Pilih Aset Desa/Bukan Aset Desa --</option>
                                                    <option value="ASET DESA">ASET DESA</option>
                                                    <option value="BUKAN ASET DESA">BUKAN ASET DESA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Kondisi Kantor Kepala Desa/Balai Desa</h3>
                            <!-- BEGIN:: INFO BUTTON -->
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#kondisiDesa">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <!-- Modal Info -->
                            <div class="modal fade" id="kondisiDesa" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Pilih Antara Aset Desa/Bukan Aset Desa</li>
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
                            <?php if ($form_status['Kondisi Kantor Kepala Desa/Balai Desa']) : ?>
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form action="../../handlers/form_kondisi_kantor.php" method="post">
                                    <div class="row">
                                        <!-- /.col -->
                                        <div class="col">
                                            <!-- /.form-group -->
                                            <div class="form-group mb-3">
                                                <label class="mb-2" for="kondisi_kantor">Kondisi Kantor Kepala Desa/Balai Desa</label>
                                                <select name="kondisi_kantor" id="kondisi_kantor" class="form-control">
                                                    <option value="" disabled selected>-- Pilih Kondisi Kantor Kepala Desa --</option>
                                                    <option value="ADA, LAYAK">ADA, LAYAK</option>
                                                    <option value="ADA, TIDAK LAYAK">ADA, TIDAK LAYAK</option>
                                                    <option value="TIDAK ADA">TIDAK ADA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Perkembangan Status Indeks Desa Membangun (IDM) di Kantor Desa</h3>
                            <!-- BEGIN:: INFO BUTTON -->
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#idm">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <!-- Modal Info -->
                            <div class="modal fade" id="idm" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Pilih Status Desa Membangun Pada Tahun 2024</li>
                                                <li>Pilih Status Desa Membangun Pada Tahun 2025</li>
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
                            <?php if ($form_status['Perkembangan Status Indeks Desa Membangun (IDM) di Kantor Desa']) : ?>
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form action="../../handlers/form_idm_status.php" method="post">
                                    <div class="mb-3">
                                        <label class="mb-2">Status Desa Membangun (Mandiri/Maju/Berkembang/Tertinggal/Sangat Tertinggal) 2024</label>
                                        <select name="status_2024" id="" class="form-control">
                                            <option value="" disabled selected>-- Pilih Status Desa Membangun 2024 --</option>
                                            <option value="MANDIRI">MANDIRI</option>
                                            <option value="MAJU">MAJU</option>
                                            <option value="BERKEMBANG">BERKEMBANG</option>
                                            <option value="TERTINGGAL">TERTINGGAL</option>
                                            <option value="SANGAT TERTINGGAL">SANGAT TERTINGGAL</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-2">Status Desa Membangun (Mandiri/Maju/Berkembang/Tertinggal/Sangat Tertinggal) 2025</label>
                                        <select name="status_2025" id="" class="form-control">
                                            <option value="" disabled selected>-- Pilih Status Desa Membangun 2025 --</option>
                                            <option value="MANDIRI">MANDIRI</option>
                                            <option value="MAJU">MAJU</option>
                                            <option value="BERKEMBANG">BERKEMBANG</option>
                                            <option value="TERTINGGAL">TERTINGGAL</option>
                                            <option value="SANGAT TERTINGGAL">SANGAT TERTINGGAL</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </div> <!--end::Footer-->
                                </form>
                            <?php endif; ?>
                            <!-- /.row -->
                        </div>
                    </div> <!--end::Container-->

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Ketersediaan Internet dan Komputer/PC/laptop di Kantor Desa</h3>
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#ketersediaaninternet">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <!-- Modal Info -->
                            <div class="modal fade" id="ketersediaaninternet" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Pilih Antara BERFUNGSI,JARANG BERFUNGSI,TIDAK BERFUNGSI,TIDAK ADA</li>
                                                <li>Pilih Antara CEPAT, SEDANG, LAMBAT</li>
                                                <li>Masukan Jumlah/Angka Yang Sesuai</li>
                                                <li>Pilih Antara DIGUNAKAN, JARANG DIGUNAKAN, TIDAK DIGUNAKAN, TIDAK ADA</li>
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
                                <button type="button" class="btn btn-tool toggle-form10">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                        <?php if ($form_status['Ketersediaan Internet dan Komputer/PC/laptop di Kantor Desa']) : ?>
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                            <form action="../../handlers/form_ketersediaan_internet.php" method="post">
                                <div class="row">
                                    <div class="form-group mb-3">
                                        <label class="mb-2">Ketersediaan Internet</label>
                                        <select name="internet_status" id="internet_status" class="form-control">
                                            <option value="" disabled selected>-- Pilih Ketersediaan Internet --</option>
                                            <option value="BERFUNGSI">BERFUNGSI</option>
                                            <option value="JARANG BERFUNGSI">JARANG BERFUNGSI</option>
                                            <option value="TIDAK BERFUNGSI">TIDAK BERFUNGSI</option>
                                            <option value="TIDAK ADA">TIDAK ADA</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="mb-2">Kecepatan Akses Internet</label>
                                        <select name="internet_speed" id="internet_speed" class="form-control">
                                            <option value="" disabled selected>-- Pilih Kecepatan Akses Internet --</option>
                                            <option value="CEPAT">CEPAT</option>
                                            <option value="SEDANG">SEDANG</option>
                                            <option value="LAMBAT">LAMBAT</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="mb-2">Jumlah Komputer/PC/laptop di Kantor Desa</label>
                                        <input type="number" name="computer_count" class="form-control" placeholder="Masukkan angka/jumlah" min="0" step="1">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="mb-2">Frekuensi Penggunaan Komputer/PC/laptop di Kantor Desa</label>
                                        <select name="computer_usage_frequency" id="computer_usage_frequency" class="form-control">
                                            <option value="" disabled selected>-- Pilih Frekuensi Penggunaan Komputer --</option>
                                            <option value="DIGUNAKAN">DIGUNAKAN</option>
                                            <option value="JARANG DIGUNAKAN">JARANG DIGUNAKAN</option>
                                            <option value="TIDAK DIGUNAKAN">TIDAK DIGUNAKAN</option>
                                            <option value="TIDAK ADA">TIDAK ADA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                </div>
                            </form>
                            <?php endif; ?>
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