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

include("../../config/function.php");
// Ambil ID pengguna yang sedang login
$username = $_SESSION['username'] ?? '';
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Ambil ID desa yang terkait dengan user yang sedang login
$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

// Ambil data sebelumnya
$previous_luas_data = getPreviousYearData($conn, $user_id, $desa_id, 'tb_luas_wilayah_desa', ['luas_wilayah_desa'], 'Luas Wilayah Desa');
$previous_jarak_data = getPreviousYearData($conn, $user_id, $desa_id, 'tb_jarak_kantor_desa', ['jarak_ke_ibukota_kecamatan', 'jarak_ke_ibukota_kabupaten'], 'Jarak Kantor Desa');

$previous_batas_utara = getPreviousYearData($conn, $user_id, $desa_id, 'tb_batas_wilayah_desa', ['batas', 'desa', 'kecamatan'], 'Batas Wilayah Desa', 'Sebelah Utara');
$previous_batas_selatan = getPreviousYearData($conn, $user_id, $desa_id, 'tb_batas_wilayah_desa', ['batas', 'desa', 'kecamatan'], 'Batas Wilayah Desa', 'Sebelah Selatan');
$previous_batas_timur = getPreviousYearData($conn, $user_id, $desa_id, 'tb_batas_wilayah_desa', ['batas', 'desa', 'kecamatan'], 'Batas Wilayah Desa', 'Sebelah Timur');
$previous_batas_barat = getPreviousYearData($conn, $user_id, $desa_id, 'tb_batas_wilayah_desa', ['batas', 'desa', 'kecamatan'], 'Batas Wilayah Desa', 'Sebelah Barat');

//$previous_batas = getPreviousYearData($conn, $user_id, $desa_id, 'tb_batas_wilayah_desa', ['desa', 'kecamatan'], 'Batas Wilayah Desa');

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
                        window.location.href = "keadaan_geografi.php";
                    });
                } else if (status === 'error') {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi kesalahan saat menambahkan data.",
                        icon: "error",
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "keadaan_geografi.php";
                    });
                } else if (status === 'warning') {
                    Swal.fire({
                        title: "Peringatan!",
                        text: "Mohon lengkapi semua data.",
                        icon: "warning",
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "keadaan_geografi.php";
                    });
                }
            </script>
        <?php endif; ?>

        <script>
            // Fungsi untuk mengisi input otomatis berdasarkan checkbox
            function toggleInputWithCheckbox(checkboxId, inputIds, previousData) {
                const checkbox = document.getElementById(checkboxId);

                // Loop untuk setiap input yang diberikan
                inputIds.forEach(function(inputId, index) {
                    const inputField = document.getElementById(inputId);

                    // Tambahkan event listener untuk checkbox
                    checkbox.addEventListener('change', function() {
                        if (checkbox.checked) {
                            // Jika checkbox dicentang, isi input dengan data tahun sebelumnya
                            inputField.value = previousData[index];
                            inputField.disabled = true; // Nonaktifkan input agar tidak bisa diubah
                        } else {
                            // Jika checkbox tidak dicentang, biarkan input kosong dan bisa diubah
                            inputField.value = '';
                            inputField.disabled = false;
                        }
                    });
                });
            }

            // Contoh penggunaan fungsi untuk form tertentu
            document.addEventListener('DOMContentLoaded', function() {
                // Panggil fungsi untuk form pertama (luas_wilayah_desa)
                toggleInputWithCheckbox('use_previous_data', ['luas_wilayah_desa'], ["<?php echo htmlspecialchars($previous_luas_data['luas_wilayah_desa']); ?>"]);

                // Panggil fungsi untuk form kedua (jarak_kantor_desa)
                toggleInputWithCheckbox('use_previous_data_2', ['jarak_ke_ibukota_kecamatan', 'jarak_ke_ibukota_kabupaten'], [
                    "<?php echo htmlspecialchars($previous_jarak_data['jarak_ke_ibukota_kecamatan']); ?>",
                    "<?php echo htmlspecialchars($previous_jarak_data['jarak_ke_ibukota_kabupaten']); ?>"
                ]);
            });
        </script>

        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Keadaan Geografi</h3>
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
                <div class="container-fluid"> <!--begin::Row-->

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Luas Wilayah Desa</h3>
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalLuasDesa">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool toggle-form1">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <script>
                                    $(document).ready(function() {
                                        $(".toggle-form1").on("click", function() {
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
                            <?php if ($form_status['Luas Wilayah Desa']) : ?>
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form action="../../handlers/form_luas_wilayah_desa.php" method="post">
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Luas Wilayah Desa (Hektar)</label>
                                            <input type="number" id="luas_wilayah_desa" name="luas_wilayah_desa" class="form-control" placeholder="Masukkan luas wilayah dalam hektar" style="width: 100%;" step="0.01" min="0">
                                            <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                                Data Pada Tahun Sebelumnya (<?php echo htmlspecialchars($previous_luas_data['created_year']); ?>):
                                                <?php echo htmlspecialchars($previous_luas_data['luas_wilayah_desa']); ?> Hektar
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                                    <div class="form-group mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="use_previous_data" name="use_previous_data" value="1">
                                            <label class="form-check-label" for="use_previous_data">
                                                Gunakan data tahun sebelumnya
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                        <div class="modal fade" id="modalLuasDesa" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            <li>Masukkan luas wilayah desa dalam satuan hektar.</li>
                                            <li>Gunakan tanda titik (.) untuk angka desimal.</li>
                                            <li>Contoh pengisian: 120.75.</li>
                                            <li>Pastikan semua kolom diisi. Jika salah satu kolom kosong, data tidak akan disimpan.</li>
                                            <li>Setelah mengisi semua kolom, klik tombol <strong>Simpan</strong>.</li>
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
                            <h3 class="card-title">Batas Wilayah Desa</h3>
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalBatasDesa">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool batas-wilayah">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if ($form_status['Batas Wilayah Desa']) : ?>
                                <!-- Alert Bootstrap dengan Inovasi -->
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form id="batasDesaForm" method="post" action="../../handlers/form_batas_wilayah_desa.php">
                                    <div class="row">
                                        <!-- Sebelah Utara -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="batas-utara" class="mb-2">Sebelah Utara</label>
                                                <input type="text" id="batas-utara" name="batas_utara" class="form-control" placeholder="Masukkan nama desa">
                                                <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                                    Data Pada Tahun Sebelumnya (<?php echo htmlspecialchars($previous_batas_utara['created_year']); ?>):
                                                    <?php echo htmlspecialchars($previous_batas_utara['desa']); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="kec-utara" class="mb-2">Kecamatan</label>
                                                <input type="text" id="kec-utara" name="kec_utara" class="form-control" placeholder="Masukkan nama kecamatan">
                                                <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                                    Data Pada Tahun Sebelumnya (<?php echo htmlspecialchars($previous_batas_utara['created_year']); ?>):
                                                    <?php echo htmlspecialchars($previous_batas_utara['kecamatan']); ?>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Sebelah Selatan -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="batas-selatan" class="mb-2">Sebelah Selatan</label>
                                                <input type="text" id="batas-selatan" name="batas_selatan" class="form-control" placeholder="Masukkan nama desa">
                                                <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                                    Data Pada Tahun Sebelumnya (<?php echo htmlspecialchars($previous_batas_selatan['created_year']); ?>):
                                                    <?php echo htmlspecialchars($previous_batas_selatan['desa']); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="kec-selatan" class="mb-2">Kecamatan</label>
                                                <input type="text" id="kec-selatan" name="kec_selatan" class="form-control" placeholder="Masukkan nama kecamatan">
                                                <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                                    Data Pada Tahun Sebelumnya (<?php echo htmlspecialchars($previous_batas_selatan['created_year']); ?>):
                                                    <?php echo htmlspecialchars($previous_batas_selatan['kecamatan']); ?>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Sebelah Timur -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="batas-timur" class="mb-2">Sebelah Timur</label>
                                                <input type="text" id="batas-timur" name="batas_timur" class="form-control" placeholder="Masukkan nama desa">
                                                <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                                    Data Pada Tahun Sebelumnya (<?php echo htmlspecialchars($previous_batas_timur['created_year']); ?>):
                                                    <?php echo htmlspecialchars($previous_batas_timur['desa']); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="kec-timur" class="mb-2">Kecamatan</label>
                                                <input type="text" id="kec-timur" name="kec_timur" class="form-control" placeholder="Masukkan nama kecamatan">
                                                <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                                    Data Pada Tahun Sebelumnya (<?php echo htmlspecialchars($previous_batas_timur['created_year']); ?>):
                                                    <?php echo htmlspecialchars($previous_batas_timur['kecamatan']); ?>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Sebelah Barat -->
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="batas-barat" class="mb-2">Sebelah Barat</label>
                                                <input type="text" id="batas-barat" name="batas_barat" class="form-control" placeholder="Masukkan nama desa">
                                                <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                                    Data Pada Tahun Sebelumnya (<?php echo htmlspecialchars($previous_batas_barat['created_year']); ?>):
                                                    <?php echo htmlspecialchars($previous_batas_barat['desa']); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="kec-barat" class="mb-2">Kecamatan</label>
                                                <input type="text" id="kec-barat" name="kec_barat" class="form-control" placeholder="Masukkan nama kecamatan">
                                                <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                                    Data Pada Tahun Sebelumnya (<?php echo htmlspecialchars($previous_batas_barat['created_year']); ?>):
                                                    <?php echo htmlspecialchars($previous_batas_barat['kecamatan']); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>

                        <!-- Modal Info -->
                        <div class="modal fade" id="modalBatasDesa" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            <li>Masukkan nama desa yang berbatasan sesuai arah mata angin (Utara, Selatan, Timur, Barat).</li>
                                            <li>Masukkan nama kecamatan tempat desa tersebut berada.</li>
                                            <li>Pastikan informasi yang diisi sesuai dengan data administratif yang benar.</li>
                                            <li>Pastikan semua kolom diisi. Jika salah satu kolom kosong, data tidak akan disimpan.</li>
                                            <li>Setelah mengisi semua kolom, klik tombol <strong>Simpan</strong>.</li>
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
                            <h3 class="card-title">Jarak Kantor Desa</h3>
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalJarakKantorDesa">
                                <i class="fas fa-info-circle"></i>
                            </button>
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
                            <?php if ($form_status['Jarak Kantor Desa']) : ?>
                                <!-- Alert Bootstrap dengan Inovasi -->
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form action="../../handlers/form_jarak_kantor_desa.php" method="post">
                                    <div class="row">
                                        <!-- Jarak ke Ibukota Kecamatan -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jarak ke Ibukota Kecamatan (km)</label>
                                            <input type="text" id="jarak_ke_ibukota_kecamatan" name="jarak_ke_ibukota_kecamatan" class="form-control" placeholder="Masukkan jarak" style="width: 100%;">
                                            <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                                Data Pada Tahun Sebelumnya (<?php echo htmlspecialchars($previous_jarak_data['created_year']); ?>):
                                                <?php echo htmlspecialchars($previous_jarak_data['jarak_ke_ibukota_kecamatan']); ?>
                                            </p>
                                        </div>

                                        <!-- Jarak ke Ibukota Kabupaten/Kota -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Jarak ke Ibukota Kabupaten/Kota (km)</label>
                                            <input type="text" id="jarak_ke_ibukota_kabupaten" name="jarak_ke_ibukota_kabupaten" class="form-control" placeholder="Masukkan jarak" style="width: 100%;">
                                            <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                                Data Pada Tahun Sebelumnya (<?php echo htmlspecialchars($previous_jarak_data['created_year']); ?>):
                                                <?php echo htmlspecialchars($previous_jarak_data['jarak_ke_ibukota_kabupaten']); ?>
                                            </p>
                                        </div>

                                        <!-- Checkbox untuk menggunakan data tahun sebelumnya -->
                                        <div class="form-group mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="use_previous_data_2" name="use_previous_data_2" value="1">
                                                <label class="form-check-label" for="use_previous_data_2">
                                                    Gunakan data tahun sebelumnya
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </div>
                                </form>

                            <?php endif; ?>
                            <!-- /.row -->
                        </div>
                        <!-- Modal Info -->
                        <div class="modal fade" id="modalJarakKantorDesa" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            <li>Masukkan jarak dalam satuan kilometer (km) menggunakan angka desimal jika diperlukan (contoh: 12.5).</li>
                                            <li>Pastikan pengisian sesuai dengan data geografis atau administratif yang valid.</li>
                                            <li>Isi jarak ke Ibukota Kecamatan dan Ibukota Kabupaten/Kota dengan teliti.</li>
                                            <li>Pastikan semua kolom diisi. Jika salah satu kolom kosong, data tidak akan disimpan.</li>
                                            <li>Setelah mengisi semua kolom, klik tombol <strong>Simpan</strong>.</li>
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
                            <h3 class="card-title">Titik Koordinat Kantor Desa</h3>
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalTitikKoordinatKantorDesa">
                                <i class="fas fa-info-circle"></i>
                            </button>
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
                            <?php if ($form_status['Titik Koordinat Kantor Desa']) : ?>
                                <!-- Alert Bootstrap dengan Inovasi -->
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form action="../../handlers/form_titik_koordinat_kantor_desa.php" method="post">
                                    <div class="row"> <!-- /.col -->
                                        <!-- /.form-group -->
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Koordinat Lintang</label>
                                            <input type="text" class="form-control" name="koordinat_lintang" placeholder="Masukkan koordinat lintang" style="width: 100%;">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="mb-2">Koordinat Bujur</label>
                                            <input type="text" class="form-control" name="koordinat_bujur" placeholder="Masukkan koordinat bujur" style="width: 100%;">
                                        </div>
                                        <div class="mb-3"> <button type="submit" class="btn btn-primary mt-3">Simpan</button> </div> <!--end::Footer-->
                                </form>
                            <?php endif; ?>
                            <!-- /.row -->
                        </div>
                        <!-- Modal Info -->
                        <div class="modal fade" id="modalTitikKoordinatKantorDesa" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            <li>Masukkan koordinat dalam format derajat desimal (contoh: -6.8796 untuk Lintang Selatan, 108.5538 untuk Bujur Timur).</li>
                                            <li>Gunakan tanda minus (-) untuk koordinat di belahan selatan (LS) atau barat (BB).</li>
                                            <li>Pastikan nilai lintang berada dalam rentang -90 hingga 90, dan bujur berada dalam rentang -180 hingga 180.</li>
                                            <li>Periksa keakuratan data sesuai dengan titik lokasi kantor desa menggunakan aplikasi peta seperti Google Maps.</li>
                                            <li>Pastikan semua kolom diisi. Jika salah satu kolom kosong, data tidak akan disimpan.</li>
                                            <li>Setelah mengisi semua kolom, klik tombol <strong>Simpan</strong>.</li>
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
                            <h3 class="card-title">Topografi Terluas Wilayah Desa</h3>
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalTopografiTerluas">
                                <i class="fas fa-info-circle"></i>
                            </button>
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
                            <?php if ($form_status['Topografi Terluas Wilayah Desa']) : ?>
                                <!-- Alert Bootstrap dengan Inovasi -->
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form action="../../handlers/form_topografi_terluas_wilayah_desa.php" method="post">
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Topografi Terluas Wilayah Desa</label>
                                            <select name="topografi_terluas_wilayah_desa" class="form-control">
                                                <option value="" disabled selected>-- Silahkan Pilih --</option>
                                                <option value="LERENG/PUNCAK">LERENG/PUNCAK</option>
                                                <option value="LEMBAH">LEMBAH</option>
                                                <option value="DATARAN">DATARAN</option>
                                                <option value="PESISIR PANTAI">PESISIR PANTAI</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary me-2 mt-3">Simpan</button>
                                    </div>
                                </form>

                            <?php endif; ?>
                            <!-- /.row -->
                        </div>
                        <!-- Modal Info -->
                        <div class="modal fade" id="modalTopografiTerluas" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            <li>Pilih salah satu dari pilihan yang tersedia sesuai dengan topografi wilayah desa Anda.</li>
                                            <li>Pastikan semua kolom diisi. Jika salah satu kolom kosong, data tidak akan disimpan.</li>
                                            <li>Setelah mengisi semua kolom, klik tombol <strong>Simpan</strong>.</li>
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
                            <h3 class="card-title">Luas Tanah Kas Desa</h3>
                            <!-- Aturan Pengisian Button -->
                            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalLuasTanahKasDesa">
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
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php if ($form_status['Luas Tanah Kas Desa']) : ?>
                                <!-- Alert Bootstrap dengan Inovasi -->
                                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                    <i class="fas fa-lock me-2"></i>
                                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php else: ?>
                                <form action="../../handlers/form_luas_tanah_kas_desa.php" method="post">
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Tanah Bengkok</label>
                                            <input type="number" name="tanah_bengkok" class="form-control" placeholder="Masukkan angka/luas" step="0.01" style="width: 100%;">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Tanah Titi Sara</label>
                                            <input type="number" name="tanah_titi_sara" class="form-control" placeholder="Masukkan angka/luas" step="0.01" style="width: 100%;">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Kebun Desa</label>
                                            <input type="number" name="kebun_desa" class="form-control" placeholder="Masukkan angka/luas" step="0.01" style="width: 100%;">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2">Sawah Desa</label>
                                            <input type="number" name="sawah_desa" class="form-control" placeholder="Masukkan angka/luas" step="0.01" style="width: 100%;">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                            <!-- /.row -->
                        </div>
                        <!-- Modal Info -->
                        <div class="modal fade" id="modalLuasTanahKasDesa" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            <li>Isi setiap kolom dengan angka desimal menggunakan tanda titik sebagai pemisah desimal. Contoh: <strong>2.07</strong>.</li>
                                            <li>Jika hanya ingin mengisi angka bulat, cukup tulis angka tanpa desimal. Contoh: <strong>5</strong>.</li>
                                            <li>Jangan menggunakan tanda koma sebagai pemisah desimal, karena sistem akan otomatis menggantinya dengan tanda titik.</li>
                                            <li>Pastikan semua kolom diisi. Jika salah satu kolom kosong, data tidak akan disimpan.</li>
                                            <li>Setelah mengisi semua kolom, klik tombol <strong>Simpan</strong>.</li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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