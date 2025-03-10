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

// tb_perkelahian_massal
$previous_perkelahian_massal = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_perkelahian_massal',
  ['kejadian'],
  'Perkelahian Massal',
  $tahun
);

// tb_keamanan_lingkungan
$previous_keamanan_lingkungan = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_keamanan_lingkungan',
  [
    'pembangunan_pos_keamanan',
    'pembentukan_regu_keamanan',
    'penambahan_anggota_hansip',
    'pelaporan_tamu_menginap',
    'pengaktifan_sistem_keamanan'
  ],
  'Keamanan Lingkungan',
  $tahun
);

// tb_linmas_poskamling
$previous_linmas_poskamling = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_linmas_poskamling',
  ['jumlah_anggota_linmas'],
  'Linmas Poskamling',
  $tahun
);

// tb_keberadaan_pos_polisi
$previous_keberadaan_pos_polisi = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_keberadaan_pos_polisi',
  ['keberadaan_pos_polisi'],
  'Keberadaan Pos Polisi',
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
            window.location.href = "keamanan.php";
          });
        } else if (status === 'error') {
          Swal.fire({
            title: "Gagal!",
            text: "Terjadi kesalahan saat menambahkan data.",
            icon: "error",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "keamanan.php";
          });
        } else if (status === 'warning') {
          Swal.fire({
            title: "Peringatan!",
            text: "Mohon lengkapi semua data.",
            icon: "warning",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "keamanan.php";
          });
        }
      </script>
    <?php endif; ?>

    <main class="app-main"> <!--begin::App Content Header-->
      <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Keamanan</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Keamanan
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
              <h3 class="card-title">Kejadian perkelahian massal di desa/kelurahan selama setahun terakhir</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalperkelahian">
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
              <form action="../../handlers/form_perkelahian_massal.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Kejadian Perkelahian Massal di Desa/Kelurahan Selama Setahun Terakhir</label>
                    <select name="kejadian" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_perkelahian_massal, 'kejadian', 'Perkelahian Massal');
                      ?>
                    </p>
                  <?php endif; ?>
                  </div>
                </div>

                <?php if ($level != 'admin' && $tahun != 2024): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_perkelahian_massal"
                        name="use_previous_perkelahian_massal" value="1">
                      <label class="form-check-label" for="use_previous_perkelahian_massal">
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
            <div class="modal fade" id="modalperkelahian" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih <b>Ada</b> jika terjadi perkelahian massal di desa/kelurahan selama setahun terakhir.</li>
                      <li>Pilih <b>Tidak Ada</b> jika tidak terjadi perkelahian massal.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- end -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Kegiatan warga desa/kelurahan untuk menjaga keamanan lingkungan di desa/kelurahan selama setahun terakhir</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalkegiatanmenjagadesa">
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
              <form action="../../handlers/form_keamanan_lingkungan.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Pembangunan/pemeliharaan pos keamanan lingkungan</label>
                    <select name="pembangunan_pos_keamanan" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_keamanan_lingkungan, 'pembangunan_pos_keamanan', 'Keamanan Lingkungan');
                      ?>
                    </p>
                  <?php endif; ?>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Pembentukan/pengaturan regu keamanan</label>
                    <select name="pembentukan_regu_keamanan" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_keamanan_lingkungan, 'pembentukan_regu_keamanan', 'Keamanan Lingkungan');
                      ?>
                    </p>
                  <?php endif; ?>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Penambahan jumlah anggota hansip/linmas</label>
                    <select name="penambahan_anggota_hansip" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_keamanan_lingkungan, 'penambahan_anggota_hansip', 'Keamanan Lingkungan');
                      ?>
                    </p>
                  <?php endif; ?>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Pelaporan tamu yang menginap lebih dari 24 jam ke aparat lingkungan</label>
                    <select name="pelaporan_tamu_menginap" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_keamanan_lingkungan, 'pelaporan_tamu_menginap', 'Keamanan Lingkungan');
                      ?>
                    </p>
                  <?php endif; ?>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Pengaktifan sistem keamanan lingkungan berasal dari inisiatif warga</label>
                    <select name="pengaktifan_sistem_keamanan" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_keamanan_lingkungan, 'pengaktifan_sistem_keamanan', 'Keamanan Lingkungan');
                      ?>
                    </p>
                  <?php endif; ?>
                  </div>
                </div>

                <?php if ($level != 'admin' && $tahun != 2024): ?>
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
            <div class="modal fade" id="modalkegiatanmenjagadesa" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih Ada/Tidak Ada kegiatan warga desa/kelurahan untuk menjaga keamanan lingkungan di desa/kelurahan selama setahun terakhir</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- end -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Anggota Hansip/ Linmas dan poskamling di desa/kelurahan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modallinmas">
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
              <form action="../../handlers/form_linmas_poskamling.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Jumlah anggota linmas/hansip di desa/kelurahan</label>
                    <input type="number" name="jumlah_anggota_linmas" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_linmas_poskamling, 'jumlah_anggota_linmas', 'Linmas Poskamling');
                      ?>
                    </p>
                  <?php endif; ?>
                  </div>
                </div>

                <?php if ($level != 'admin' && $tahun != 2024): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_linmas_poskamling"
                        name="use_previous_linmas_poskamling" value="1">
                      <label class="form-check-label" for="use_previous_linmas_poskamling">
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
            <div class="modal fade" id="modallinmas" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi jumlah anggota linmas/hansip di desa/kelurahan</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- end -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Keberadaan pos polisi (termasuk kantor polisi) di desa/kelurahan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalpolisi">
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
              <form action="../../handlers/form_keberadaan_pos_polisi.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan pos polisi (termasuk kantor polisi) di desa/kelurahan</label>
                    <select name="keberadaan_pos_polisi" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_keberadaan_pos_polisi, 'keberadaan_pos_polisi', 'Keberadaan Pos Polisi');
                      ?>
                    </p>
                  <?php endif; ?>
                  </div>
                </div>

                <?php if ($level != 'admin' && $tahun != 2024): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_keberadaan_pos_polisi"
                        name="use_previous_keberadaan_pos_polisi" value="1">
                      <label class="form-check-label" for="use_previous_keberadaan_pos_polisi">
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
            <div class="modal fade" id="modalpolisi" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih <b>Ada</b> jika terdapat pos polisi (termasuk kantor polisi) di desa/kelurahan.</li>
                      <li>Pilih <b>Tidak Ada</b> jika tidak terdapat pos polisi di desa/kelurahan.</li>
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