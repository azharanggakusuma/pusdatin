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
// Ambil ID pengguna
$query_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Ambil ID desa
$query_desa = "SELECT id_desa FROM tb_enumerator WHERE user_id = '$user_id' ORDER BY id_desa DESC LIMIT 1";
$result_desa = mysqli_query($conn, $query_desa);
$desa = mysqli_fetch_assoc($result_desa);
$desa_id = $desa['id_desa'] ?? 0;

// Ambil tahun dari session
$tahun = $_SESSION['tahun'] ?? date('Y');

// tb_kepala_desa
$previous_kepala_desa = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_kepala_desa',
  ['nama_kepala_desa', 'umur', 'jenis_kelamin', 'pendidikan_terakhir', 'tahun_mulai_menjabat'],
  'Kepala Desa',
  $tahun
);

// tb_perangkat_desa
$previous_perangkat_desa = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_perangkat_desa',
  [
    'skd_laki',
    'skd_perempuan',
    'kaur_laki',
    'kaur_perempuan',
    'kkk_laki',
    'kkk_perempuan',
    'pk_laki',
    'pk_perempuan',
    'staf_laki',
    'staf_perempuan',
    'total_laki',
    'total_perempuan'
  ],
  'Perangkat Desa',
  $tahun
);

// tb_perangkat_desa_pendidikan
$previous_perangkat_desa_pendidikan = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_perangkat_desa_pendidikan',
  [
    'tidak_sekolah_laki',
    'tidak_sekolah_perempuan',
    'tidak_tamat_sd_laki',
    'tidak_tamat_sd_perempuan',
    'tamat_sd_laki',
    'tamat_sd_perempuan',
    'smp_laki',
    'smp_perempuan',
    'smu_laki',
    'smu_perempuan',
    'd3_laki',
    'd3_perempuan',
    's1_laki',
    's1_perempuan',
    's2_laki',
    's2_perempuan',
    's3_laki',
    's3_perempuan',
    'total_laki',
    'total_perempuan'
  ],
  'Pendidikan Perangkat Desa',
  $tahun
);

// tb_badan_permusyawaratan_desa
$previous_badan_permusyawaratan_desa = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_badan_permusyawaratan_desa',
  ['keberadaan_bpd', 'jumlah_laki', 'jumlah_perempuan', 'jumlah_kegiatan'],
  'Badan Permusyawaratan Desa',
  $tahun
);

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
            window.location.href = "aparatur_pemerintahan_desa.php";
          });
        } else if (status === 'error') {
          Swal.fire({
            title: "Gagal!",
            text: "Terjadi kesalahan saat menambahkan data.",
            icon: "error",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "aparatur_pemerintahan_desa.php";
          });
        } else if (status === 'warning') {
          Swal.fire({
            title: "Peringatan!",
            text: "Mohon lengkapi semua data.",
            icon: "warning",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "aparatur_pemerintahan_desa.php";
          });
        }
      </script>
    <?php endif; ?>


    <main class="app-main"> <!--begin::App Content Header-->
      <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Aparatur Pemerintahan Desa</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Aparatur Pemerintahan Desa
                </li>
              </ol>
            </div>
          </div> <!--end::Row-->
        </div> <!--end::Container-->
      </div> <!--end::App Content Header--> <!--begin::App Content-->
      <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->

          <!-- Template Form -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Nama Kepala Desa/Kelurahan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalKades">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool toggle-form">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".toggle-form").on("click", function() {
                      var $icon = $(this).find("i");
                      var $cardBody = $(this).closest(".card").find(".card-body");

                      $cardBody.slideToggle();
                      $icon.toggleClass("fa-minus fa-plus");
                    });
                  });
                </script>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="../../handlers/form_kepala_desa.php" method="post">
                <div class="row"> <!-- /.col -->
                  <!-- /.form-group -->
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Kepala Desa/Lurah</label>
                    <input required type="text" class="form-control" placeholder="Masukkan nama" style="width: 100%;" required name="nama_kepala_desa">
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_kepala_desa, 'nama_kepala_desa', 'Kepala Desa');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Umur</label>
                    <input required type="number" min="0" class="form-control" placeholder="Masukkan Umur" style="width: 100%;" required name="umur_kepala_desa">
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_kepala_desa, 'umur', 'Kepala Desa');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Jenis kelamin</label>
                    <select required name="jenis_kelamin" id="" class="form-control">
                      <option value="" disabled selected>---Pilih Jenis Kelamin---</option>
                      <option value="LAKI-LAKI">LAKI - LAKI</option>
                      <option value="PEREMPUAN"> PEREMPUAN </option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_kepala_desa, 'jenis_kelamin', 'Kepala Desa');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Pendidikan Tertinggi yang ditamatkan</label>
                    <select required name="pendidikan_terakhir" id="" class="form-control">
                      <option value="" disabled selected>---Pilih Pendidikan Terakhir---</option>
                      <option value="Tidak pernah sekolah">Tidak pernah sekolah</option>
                      <option value="Tidak tamat SD/Sederajat">Tidak tamat SD/Sederajat</option>
                      <option value="Tamat SD/Sederajat">Tamat SD/Sederajat</option>
                      <option value="SMP/Sederajat">SMP/Sederajat</option>
                      <option value="SMU/Sederajat">SMU/Sederajat</option>
                      <option value="Akademi/DIII">Akademi/DIII</option>
                      <option value="Diploma IV/S1">Diploma IV/S1</option>
                      <option value="S2">S2</option>
                      <option value="S3">S3</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_kepala_desa, 'pendidikan_terakhir', 'Kepala Desa');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Tahun Mulai Menjabat</label>
                    <input required type="number" min="0" class="form-control" placeholder="Masukkan tahun mulai menjabat" style="width: 100%;" required name="tahun_mulai_menjabat">
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_kepala_desa, 'tahun_mulai_menjabat', 'Kepala Desa');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>

                <?php if ($level != 'admin'): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_keamanan_lingkungan"
                        name="use_previous_keamanan_lingkungan" value="1">
                      <label class="form-check-label" for="use_previous_keamanan_lingkungan">
                        Gunakan data tahun sebelumnya
                      </label>
                    </div>
                  </div>
                <?php endif; ?>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
              <!-- /.row -->
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="modalKades" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi form berdasarkan kepala desa saat ini</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Template Form -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Jumlah Perangkat Desa Menurut Jabatan dan Jenis Kelamin</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalPerdes">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool toggle-form">
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

            <!-- /.card-header -->
            <div class="card-body">
              <form action="../../handlers/form_perangkat_desa.php" method="post">
                <div class="row">
                  <div class="col-12 mb-3">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Jenis Jabatan</th>
                          <th>Laki-Laki</th>
                          <th>Perempuan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Sekretaris Desa/Kelurahan -->
                        <tr>
                          <td>Sekretaris Desa/Kelurahan</td>
                          <td>
                            <input type="number" name="skd_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa, 'skd_laki', 'Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="skd_peremuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa, 'skd_perempuan', 'Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <!-- Kaur (kaur keuangan, dll) -->
                        <tr>
                          <td>Kaur (kaur keuangan, dll)</td>
                          <td>
                            <input type="number" name="kaur_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa, 'kaur_laki', 'Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="kaur_perempuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa, 'kaur_perempuan', 'Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <!-- Kasi kesejahteraan, dll -->
                        <tr>
                          <td>Kasi kasi kesejahteraan, dll</td>
                          <td>
                            <input type="number" name="kkk_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa, 'kkk_laki', 'Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="kkk_perempuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa, 'kkk_perempuan', 'Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <!-- Pelaksana Kewilayahan -->
                        <tr>
                          <td>Pelaksana Kewilayahan</td>
                          <td>
                            <input type="number" name="pk_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa, 'pk_laki', 'Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="pk_perempuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa, 'pk_perempuan', 'Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <!-- Staf/Pegawai Desa Lainnya -->
                        <tr>
                          <td>Staf/Pegawai Desa Lainnya</td>
                          <td>
                            <input type="number" name="staf_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa, 'staf_laki', 'Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="staf_perempuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa, 'staf_perempuan', 'Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <!-- Jumlah Total -->
                        <tr>
                          <td>Jumlah Total</td>
                          <td>
                            <input type="number" name="jumlah_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa, 'total_laki', 'Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="jumlah_perempuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa, 'total_perempuan', 'Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <?php if ($level != 'admin'): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_keamanan_lingkungan"
                        name="use_previous_keamanan_lingkungan" value="1">
                      <label class="form-check-label" for="use_previous_keamanan_lingkungan">
                        Gunakan data tahun sebelumnya
                      </label>
                    </div>
                  </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> &nbsp; Simpan
                </button>
              </form>
              <!-- /.row -->
            </div>


            <!-- Modal Info -->
            <div class="modal fade" id="modalPerdes" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Masukkan Jumlah Laki-Laki dan Perempuan berdasarkan jenis jabatan</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Template Form -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Jumlah Perangkat Desa Menurut Tingkat Pendidikan dan Jenis Kelamin</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalPerdesPend">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool toggle-form">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".toggle-form2").on("click", function() {
                      var $icon = $(this).find("i");
                      var $cardBody = $(this).closest(".card").find(".card-body");

                      $cardBody.slideToggle();
                      $icon.toggleClass("fa-minus fa-plus");
                    });
                  });
                </script>
              </div>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
              <form action="../../handlers/form_perangkat_desa_pendidikan.php" method="post">
                <div class="row">
                  <div class="col-12 mb-3">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Tingkat Pendidikan terakhir yang ditamatkan</th>
                          <th>Laki-Laki</th>
                          <th>Perempuan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Tidak pernah sekolah -->
                        <tr>
                          <td>Tidak pernah sekolah</td>
                          <td>
                            <input type="number" name="tidaksekolah_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 'tidak_sekolah_laki', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="tidaksekolah_peremuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 'tidak_sekolah_perempuan', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <!-- Tidak tamat SD/Sederajat -->
                        <tr>
                          <td>Tidak tamat SD/Sederajat</td>
                          <td>
                            <input type="number" name="tidaksd_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 'tidak_tamat_sd_laki', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="tidaksd_perempuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 'tidak_tamat_sd_perempuan', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <!-- Tamat SD/Sederajat -->
                        <tr>
                          <td>Tamat SD/Sederajat</td>
                          <td>
                            <input type="number" name="sd_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 'tamat_sd_laki', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="sd_perempuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 'tamat_sd_perempuan', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <!-- SMP/Sederajat -->
                        <tr>
                          <td>SMP/Sederajat</td>
                          <td>
                            <input type="number" name="smp_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 'smp_laki', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="smp_perempuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 'smp_perempuan', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <!-- SMU/Sederajat -->
                        <tr>
                          <td>SMU/Sederajat</td>
                          <td>
                            <input type="number" name="smu_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 'smu_laki', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="smu_perempuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 'smu_perempuan', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <!-- Akademi/DIII -->
                        <tr>
                          <td>Akademi/DIII</td>
                          <td>
                            <input type="number" name="d3_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 'd3_laki', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="d3_perempuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 'd3_perempuan', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <!-- Diploma IV/S1 -->
                        <tr>
                          <td>Diploma IV/S1</td>
                          <td>
                            <input type="number" name="s1_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 's1_laki', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="s1_perempuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 's1_perempuan', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <!-- S2 -->
                        <tr>
                          <td>S2</td>
                          <td>
                            <input type="number" name="s2_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 's2_laki', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="s2_perempuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 's2_perempuan', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <!-- S3 -->
                        <tr>
                          <td>S3</td>
                          <td>
                            <input type="number" name="s3_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 's3_laki', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="s3_perempuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 's3_perempuan', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <!-- Jumlah Total -->
                        <tr>
                          <td>Jumlah Total</td>
                          <td>
                            <input type="number" name="jumlah2_laki_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 'total_laki', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                          <td>
                            <input type="number" name="jumlah2_perempuan_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- ">
                            <?php if ($level != 'admin'): ?>
                              <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                                <?php
                                echo displayPreviousYearData($previous_perangkat_desa_pendidikan, 'total_perempuan', 'Pendidikan Perangkat Desa');
                                ?>
                              </p>
                            <?php endif; ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <?php if ($level != 'admin'): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_keamanan_lingkungan"
                        name="use_previous_keamanan_lingkungan" value="1">
                      <label class="form-check-label" for="use_previous_keamanan_lingkungan">
                        Gunakan data tahun sebelumnya
                      </label>
                    </div>
                  </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> &nbsp; Simpan
                </button>
              </form>
              <!-- /.row -->
            </div>


            <!-- Modal Info -->
            <div class="modal fade" id="modalPerdesPend" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Masukkan Jumlah Laki-Laki dan Perempuan berdasarkan tingkat pendidikan terakhir</li>
                      <li>Jumlah total harus sama dengan jumlah total pada tabel Jabatan</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Template Form -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Badan Permusyawaratan Desa/Lembaga Musyawarah Kelurahan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalBPD">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool toggle-form">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".toggle-form3").on("click", function() {
                      var $icon = $(this).find("i");
                      var $cardBody = $(this).closest(".card").find(".card-body");

                      $cardBody.slideToggle();
                      $icon.toggleClass("fa-minus fa-plus");
                    });
                  });
                </script>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="../../handlers/form_badan_permusyawaratan_desa.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Badan Permusyawaratan Desa/Lembaga Musyawarah Kelurahan</label>
                    <select name="keberadaan_bpd" id="keberadaanBPD" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_badan_permusyawaratan_desa, 'keberadaan_bpd', 'Badan Permusyawaratan Desa');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="form-group mb-3" id="jumlahAnggotaBPD" style="display: none;">
                  <label class="mb-2" style="font-weight: bold;">Jumlah Anggota BPD</label>
                  <div class="form-group mb-3">
                    <div class="row">
                      <div class="col-md-4">
                        <label class="mb-2">Laki-Laki</label>
                        <input type="number" class="form-control" min="0" name="laki_laki" id="laki_laki" placeholder=" --- Masukkan jumlah --- ">
                        <?php if ($level != 'admin'): ?>
                          <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                            <?php
                            echo displayPreviousYearData($previous_badan_permusyawaratan_desa, 'jumlah_laki', 'Badan Permusyawaratan Desa');
                            ?>
                          </p>
                        <?php endif; ?>
                      </div>
                      <div class="col-md-4">
                        <label class="mb-2">Perempuan</label>
                        <input type="number" class="form-control" min="0" name="perempuan" id="perempuan" placeholder=" --- Masukkan jumlah --- ">
                        <?php if ($level != 'admin'): ?>
                          <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                            <?php
                            echo displayPreviousYearData($previous_badan_permusyawaratan_desa, 'jumlah_perempuan', 'Badan Permusyawaratan Desa');
                            ?>
                          </p>
                        <?php endif; ?>
                      </div>
                    </div>

                  </div>
                </div>
                <div class="form-group mb-3" id="kegiatanMusyawarahDesa" style="display: none;">
                  <label class="mb-2">Jumlah kegiatan musyawarah desa/kelurahan yang dilakukan selama setahun terakhir</label>
                  <input type="number" class="form-control" min="0" name="kegiatanMusyawarahDesa" id="kegiatanMusyawarahDesa" placeholder=" --- Masukkan jumlah --- ">
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_badan_permusyawaratan_desa, 'jumlah_kegiatan', 'Badan Permusyawaratan Desa');
                      ?>
                    </p>
                  <?php endif; ?>
                </div>

                <script>
                  document.addEventListener("DOMContentLoaded", function() {
                    const keberadaanBPD = document.getElementById('keberadaanBPD');
                    const jumlahAnggotaBPD = document.getElementById('jumlahAnggotaBPD');
                    const kegiatanMusyawarahDesa = document.getElementById('kegiatanMusyawarahDesa');

                    keberadaanBPD.addEventListener('change', function() {
                      if (this.value === 'Ada') {
                        jumlahAnggotaBPD.style.display = 'block';
                        kegiatanMusyawarahDesa.style.display = 'block';
                      } else {
                        jumlahAnggotaBPD.style.display = 'none';
                        kegiatanMusyawarahDesa.style.display = 'none';
                      }
                    });
                  });
                </script>

                <?php if ($level != 'admin'): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_keamanan_lingkungan"
                        name="use_previous_keamanan_lingkungan" value="1">
                      <label class="form-check-label" for="use_previous_keamanan_lingkungan">
                        Gunakan data tahun sebelumnya
                      </label>
                    </div>
                  </div>
                <?php endif; ?>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
              <!-- /.row -->
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="modalBPD" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi bagian Keberadaan Badan Permusyawaratan Desa/Lembaga Musyawarah Kelurahan dengan memilih Ada/Tidak Ada, jika Ada lanjut mengisi</li>
                      <li>isi jumlah anggota BPD berdasarkan laki-laki dan perempuan</li>
                      <li>Isi Jumlah kegiatan musyawarah desa/kelurahan yang dilakukan selama setahun terakhir</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div> <!--end::Container-->
      </div> <!--end::App Content-->
    </main> <!--end::App Main--> <!--begin::Footer-->

    <?php include("../../components/footer.php"); ?>
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