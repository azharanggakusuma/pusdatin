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

// Ambil data sebelumnya
$previous_ibadah_data = getPreviousYearData($conn, $user_id, $desa_id, 'tb_tempat_ibadah', ['jumlah_masjid', 'jumlah_pura', 'jumlah_musala', 'jumlah_wihara', 'jumlah_gereja_kristen', 'jumlah_kelenteng', 'jumlah_gereja_katolik', 'jumlah_balai_basarah', 'jumlah_kapel', 'lainnya', 'jumlah_lainnya'], 'Jumlah Tempat Ibadah di Desa/Kelurahan', $tahun);
$previous_disabilitas_data = getPreviousYearData($conn, $user_id, $desa_id, 'tb_disabilitas', ['jumlah_tuna_netra', 'jumlah_tuna_rungu', 'jumlah_tuna_wicara', 'jumlah_tuna_rungu_wicara', 'jumlah_tuna_daksa', 'jumlah_tuna_grahita', 'jumlah_tuna_laras', 'jumlah_tuna_eks_kusta', 'jumlah_tuna_ganda'], 'Banyaknya penyandang disabilitas', $tahun);
$previous_ruang_publik_data = getPreviousYearData($conn, $user_id, $desa_id, 'tb_ruang_publik', ['status_ruang_publik', 'ruang_terbuka_hijau', 'ruang_terbuka_non_hijau'], 'Keberadaan Ruang publik terbuka yang peruntukan utamanya sebagai tempat bagi warga desa/kelurahan untuk bersantai/bermain tanpa perlu membayar (misalnya: lapangan terbuka/alun–alun, taman, dll.)', $tahun);
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
            window.location.href = "sosial_budaya.php";
          });
        } else if (status === 'error') {
          Swal.fire({
            title: "Gagal!",
            text: "Terjadi kesalahan saat menambahkan data.",
            icon: "error",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "sosial_budaya.php";
          });
        } else if (status === 'warning') {
          Swal.fire({
            title: "Peringatan!",
            text: "Mohon lengkapi semua data.",
            icon: "warning",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "sosial_budaya.php";
          });
        }
      </script>
    <?php endif; ?>

    <main class="app-main"> <!--begin::App Content Header-->
      <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Sosial Budaya</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Sosial Budaya
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
              <h3 class="card-title">Jumlah Tempat Ibadah di Desa/Kelurahan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalTempatIbadah">
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
            <div class="card-body">
              <?php if ($form_status['Jumlah Tempat Ibadah di Desa/Kelurahan']) : ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                  <i class="fas fa-lock me-2"></i>
                  <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php else: ?>
                <form action="../../handlers/form_tempat_ibadah.php" method="post">
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="masjid" class="form-label">Masjid</label>
                      <input type="number" name="masjid" class="form-control" id="masjid" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_ibadah_data, 'jumlah_masjid', 'Jumlah Tempat Ibadah di Desa/Kelurahan');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <label for="pura" class="form-label">Pura</label>
                      <input type="number" name="pura" class="form-control" id="pura" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_ibadah_data, 'jumlah_pura', 'Jumlah Tempat Ibadah di Desa/Kelurahan');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="musala" class="form-label">Surau/Langgar/Musala</label>
                      <input type="number" name="musala" class="form-control" id="musala" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_ibadah_data, 'jumlah_musala', 'Jumlah Tempat Ibadah di Desa/Kelurahan');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <label for="wihara" class="form-label">Wihara</label>
                      <input type="number" name="wihara" class="form-control" id="wihara" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_ibadah_data, 'jumlah_wihara', 'Jumlah Tempat Ibadah di Desa/Kelurahan');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="kristen" class="form-label">Gereja Kristen</label>
                      <input type="number" name="kristen" class="form-control" id="kristen" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_ibadah_data, 'jumlah_gereja_kristen', 'Jumlah Tempat Ibadah di Desa/Kelurahan');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <label for="kelenteng" class="form-label">Kelenteng</label>
                      <input type="number" name="kelenteng" class="form-control" id="kelenteng" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_ibadah_data, 'jumlah_kelenteng', 'Jumlah Tempat Ibadah di Desa/Kelurahan');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="katolik" class="form-label">Gereja Katolik</label>
                      <input type="number" name="katolik" class="form-control" id="katolik" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_ibadah_data, 'jumlah_gereja_katolik', 'Jumlah Tempat Ibadah di Desa/Kelurahan');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <label for="basarah" class="form-label">Balai Basarah</label>
                      <input type="number" name="basarah" class="form-control" id="basarah" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_ibadah_data, 'jumlah_balai_basarah', 'Jumlah Tempat Ibadah di Desa/Kelurahan');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="kapel" class="form-label">Kapel</label>
                      <input type="number" name="kapel" class="form-control" id="kapel" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_ibadah_data, 'jumlah_kapel', 'Jumlah Tempat Ibadah di Desa/Kelurahan');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <label for="lainnya" class="form-label">Lainnya</label>
                      <input type="text" name="lainnya" class="form-control" id="lainnya" placeholder="Tuliskan jenis tempat ibadah lainnya">
                      <input type="number" name="lainnyaInput" class="form-control mt-2" id="lainnyaInput" placeholder="Masukkan jumlah" style="display: none;">

                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_ibadah_data, 'lainnya', 'Jumlah Tempat Ibadah di Desa/Kelurahan');
                          echo " <br> ";
                          echo displayPreviousYearData($previous_ibadah_data, 'jumlah_lainnya', 'Jumlah Tempat Ibadah di Desa/Kelurahan');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <script>
                    $(document).ready(function() {
                      $('#lainnya').on('input', function() {
                        var inputVal = $(this).val();
                        if (inputVal) {
                          $('#lainnyaInput').show();
                        } else {
                          $('#lainnyaInput').hide();
                        }
                      });
                    });
                  </script>

                  <!-- Checkbox to use previous year data -->
                  <?php if ($level != 'admin'): ?>
                    <div class="form-group mb-3">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="use_previous_ibadah" name="use_previous_ibadah" value="1">
                        <label class="form-check-label" for="use_previous_ibadah">
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

                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    const inputNames = ['masjid', 'pura', 'musala', 'wihara', 'kristen', 'kelenteng', 'katolik', 'basarah', 'kapel', 'lainnya', 'lainnyaInput'];
                    const previousData = [
                      "<?php echo htmlspecialchars($previous_ibadah_data['jumlah_masjid']); ?>",
                      "<?php echo htmlspecialchars($previous_ibadah_data['jumlah_pura']); ?>",
                      "<?php echo htmlspecialchars($previous_ibadah_data['jumlah_musala']); ?>",
                      "<?php echo htmlspecialchars($previous_ibadah_data['jumlah_wihara']); ?>",
                      "<?php echo htmlspecialchars($previous_ibadah_data['jumlah_gereja_kristen']); ?>",
                      "<?php echo htmlspecialchars($previous_ibadah_data['jumlah_kelenteng']); ?>",
                      "<?php echo htmlspecialchars($previous_ibadah_data['jumlah_gereja_katolik']); ?>",
                      "<?php echo htmlspecialchars($previous_ibadah_data['jumlah_balai_basarah']); ?>",
                      "<?php echo htmlspecialchars($previous_ibadah_data['jumlah_kapel']); ?>",
                      "<?php echo htmlspecialchars($previous_ibadah_data['lainnya']); ?>",
                      "<?php echo htmlspecialchars($previous_ibadah_data['jumlah_lainnya']); ?>",
                    ];

                    const checkbox = document.getElementById('use_previous_ibadah');

                    // Function to populate the form fields with previous data
                    function populateFields() {
                      inputNames.forEach((inputName, index) => {
                        const inputField = document.getElementById(inputName);
                        if (checkbox.checked) {
                          inputField.value = previousData[index]; // Set the value of the select fields
                          inputField.readOnly = true; // Make the field read-only if checkbox is checked

                          // Show the hidden input for "lainnyaInput" if checkbox is checked
                          if (inputName === 'lainnyaInput' && previousData[index]) {
                            inputField.style.display = 'block';
                          }
                        } else {
                          inputField.value = ''; // Reset the value when checkbox is unchecked
                          inputField.readOnly = false; // Make the field editable when checkbox is unchecked

                          // Hide the "lainnyaInput" field when checkbox is unchecked
                          if (inputName === 'lainnyaInput') {
                            inputField.style.display = 'none';
                          }
                        }
                      });
                    }

                    // Set up the checkbox listener
                    checkbox.addEventListener('change', populateFields);

                    // Initialize the form based on the current checkbox state
                    populateFields();
                  });
                </script>
              <?php endif; ?>
            </div>
          </div>

          <!-- Modal Info -->
          <div class="modal fade" id="modalTempatIbadah" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <ul>
                    <li>Masukkan jumlah eksak yang ada untuk setiap jenis tempat ibadah.</li>
                    <li>Jangan membiarkan bidang input kosong; masukkan '0' jika tidak ada tempat ibadah dari jenis tersebut.</li>
                    <li>Pastikan semua angka yang dimasukkan akurat untuk mencegah kesalahan data.</li>
                    <li>Gunakan tombol 'Simpan' di bawah formulir setelah mengisi semua data.</li>
                    <li>Apabila ada jenis tempat ibadah yang tidak terdaftar, masukkan jenisnya pada 'Lainnya' dan isi jumlahnya.</li>
                  </ul>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>

          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Banyaknya penyandang disabilitas di desa/kelurahan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalDisabilitas">
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
            <div class="card-body">
              <?php if ($form_status['Banyaknya penyandang disabilitas']) : ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                  <i class="fas fa-lock me-2"></i>
                  <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php else: ?>
                <form action="../../handlers/form_disabilitas.php" method="post">
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="tuna-netra" class="form-label">Jumlah tuna netra (buta)</label>
                      <input type="number" class="form-control" name="tuna_netra" id="tuna-netra" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_disabilitas_data, 'jumlah_tuna_netra', 'Banyaknya penyandang disabilitas');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <label for="tuna-rungu" class="form-label">Jumlah tuna rungu (tuli)</label>
                      <input type="number" class="form-control" name="tuna_rungu" id="tuna-rungu" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_disabilitas_data, 'jumlah_tuna_rungu', 'Banyaknya penyandang disabilitas');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="tuna-wicara" class="form-label">Jumlah tuna wicara (bisu)</label>
                      <input type="number" class="form-control" name="tuna_wicara" id="tuna-wicara" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_disabilitas_data, 'jumlah_tuna_wicara', 'Banyaknya penyandang disabilitas');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <label for="tuna-rungu-wicara" class="form-label">Jumlah tuna rungu-wicara (tuli-bisu)</label>
                      <input type="number" class="form-control" name="tuna_rungu_wicara" id="tuna-rungu-wicara" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_disabilitas_data, 'jumlah_tuna_rungu_wicara', 'Banyaknya penyandang disabilitas');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="tuna-daksa" class="form-label">Jumlah tuna daksa (disabilitas tubuh)</label>
                      <input type="number" class="form-control" name="tuna_daksa" id="tuna-daksa" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_disabilitas_data, 'jumlah_tuna_daksa', 'Banyaknya penyandang disabilitas');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <label for="tuna-grahita" class="form-label">Jumlah tuna grahita (keterbelakangan mental)</label>
                      <input type="number" class="form-control" name="tuna_grahita" id="tuna-grahita" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_disabilitas_data, 'jumlah_tuna_grahita', 'Banyaknya penyandang disabilitas');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="tuna-laras" class="form-label">Jumlah tuna laras (eks-sakit jiwa)</label>
                      <input type="number" class="form-control" name="tuna_laras" id="tuna-laras" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_disabilitas_data, 'jumlah_tuna_laras', 'Banyaknya penyandang disabilitas');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <label for="tuna-eks-kusta" class="form-label">Jumlah tuna eks-sakit kusta</label>
                      <input type="number" class="form-control" name="tuna_eks_kusta" id="tuna-eks-kusta" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_disabilitas_data, 'jumlah_tuna_eks_kusta', 'Banyaknya penyandang disabilitas');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="tuna-ganda" class="form-label">Jumlah tuna ganda (fisik-mental)</label>
                      <input type="number" class="form-control" name="tuna_ganda" id="tuna-ganda" placeholder="Masukkan jumlah">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_disabilitas_data, 'jumlah_tuna_ganda', 'Banyaknya penyandang disabilitas');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <!-- Checkbox to use previous year data -->
                  <?php if ($level != 'admin'): ?>
                    <div class="form-group mb-3">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="use_previous_disabilitas" name="use_previous_disabilitas" value="1">
                        <label class="form-check-label" for="use_previous_disabilitas">
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
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    const inputIds = [
                      'tuna-netra', 'tuna-rungu', 'tuna-wicara', 'tuna-rungu-wicara',
                      'tuna-daksa', 'tuna-grahita', 'tuna-laras', 'tuna-eks-kusta', 'tuna-ganda'
                    ];
                    const previousData = {
                      'tuna-netra': "<?php echo htmlspecialchars($previous_disabilitas_data['jumlah_tuna_netra'] ?? ''); ?>",
                      'tuna-rungu': "<?php echo htmlspecialchars($previous_disabilitas_data['jumlah_tuna_rungu'] ?? ''); ?>",
                      'tuna-wicara': "<?php echo htmlspecialchars($previous_disabilitas_data['jumlah_tuna_wicara'] ?? ''); ?>",
                      'tuna-rungu-wicara': "<?php echo htmlspecialchars($previous_disabilitas_data['jumlah_tuna_rungu_wicara'] ?? ''); ?>",
                      'tuna-daksa': "<?php echo htmlspecialchars($previous_disabilitas_data['jumlah_tuna_daksa'] ?? ''); ?>",
                      'tuna-grahita': "<?php echo htmlspecialchars($previous_disabilitas_data['jumlah_tuna_grahita'] ?? ''); ?>",
                      'tuna-laras': "<?php echo htmlspecialchars($previous_disabilitas_data['jumlah_tuna_laras'] ?? ''); ?>",
                      'tuna-eks-kusta': "<?php echo htmlspecialchars($previous_disabilitas_data['jumlah_tuna_eks_kusta'] ?? ''); ?>",
                      'tuna-ganda': "<?php echo htmlspecialchars($previous_disabilitas_data['jumlah_tuna_ganda'] ?? ''); ?>"
                    };

                    const checkbox = document.getElementById('use_previous_disabilitas');

                    // Function to populate the form fields with previous data
                    function populateFields() {
                      inputIds.forEach((inputId) => {
                        const inputField = document.getElementById(inputId);
                        if (checkbox.checked) {
                          inputField.value = previousData[inputId] || ''; // Set value if data exists, else empty string
                          inputField.readOnly = true; // Make the field read-only
                        } else {
                          inputField.value = ''; // Clear value
                          inputField.readOnly = false; // Make the field editable
                        }
                      });
                    }

                    // Add event listener to the checkbox
                    checkbox.addEventListener('change', populateFields);

                    // Initialize the form based on the checkbox state
                    populateFields();
                  });
                </script>
              <?php endif; ?>
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="modalDisabilitas" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi jumlah penyandang disabilitas di desa/kelurahan untuk setiap kategori yang terdaftar.</li>
                      <li>Masukkan angka '0' jika tidak ada penyandang disabilitas dalam kategori tersebut.</li>
                      <li>Pastikan untuk memasukkan data yang akurat dan terverifikasi dari sumber yang dapat dipercaya.</li>
                      <li>Review kembali semua data yang telah dimasukkan sebelum menyimpan untuk memastikan tidak ada kesalahan entri.</li>
                      <li>Gunakan tombol 'Simpan' untuk menyimpan informasi yang telah diisi ke dalam basis data.</li>
                      <li>Setiap entri harus sesuai dengan kondisi nyata di lapangan untuk memastikan kevalidan data.</li>
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
              <h3 class="card-title">Ruang publik terbuka</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalRuangPublik">
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
            <div class="card-body">
              <?php if ($form_status['Keberadaan Ruang publik terbuka yang peruntukan utamanya sebagai tempat bagi warga desa/kelurahan untuk bersantai/bermain tanpa perlu membayar (misalnya: lapangan terbuka/alun–alun, taman, dll.)']) : ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                  <i class="fas fa-lock me-2"></i>
                  <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php else: ?>
                <form action="../../handlers/form_ruang_publik.php" method="post">
                  <div class="row">
                    <div class="col-12 mb-3">
                      <label for="publicSpaceStatus" class="form-label">Keberadaan Ruang publik terbuka yang peruntukan utamanya sebagai tempat bagi warga desa/kelurahan untuk bersantai/bermain tanpa perlu membayar (misalnya: lapangan terbuka/alun–alun, taman, dll.)</label>
                      <select class="form-select" id="publicSpaceStatus" name="publicSpaceStatus">
                        <option value="" disabled selected>--- Pilih ---</option>
                        <option value="Ada, dikelola">Ada, dikelola</option>
                        <option value="Ada, tidak dikelola">Ada, tidak dikelola</option>
                        <option value="Tidak Ada">Tidak ada</option>
                      </select>
                    </div>
                  </div>
                  <div class="row additional-info" style="display:none">
                    <div class="col-12 mb-3">
                      <label for="greenSpace" class="form-label">Ruang Terbuka Hijau (RTH):</label>
                      <select class="form-select" id="greenSpace" name="greenSpace">
                        <option value="" disabled selected>--- Pilih ---</option>
                        <option value="Ada">Ada</option>
                        <option value="Tidak Ada">Tidak ada</option>
                      </select>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="nonGreenSpace" class="form-label">Ruang Terbuka Non Hijau (RTNH):</label>
                      <select class="form-select" id="nonGreenSpace" name="nonGreenSpace">
                        <option value="" disabled selected>--- Pilih ---</option>
                        <option value="Ada">Ada</option>
                        <option value="Tidak Ada">Tidak ada</option>
                      </select>
                    </div>
                  </div>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_ruang_publik_data, 'status_ruang_publik', 'Keberadaan Ruang publik terbuka yang peruntukan utamanya sebagai tempat bagi warga desa/kelurahan untuk bersantai/bermain tanpa perlu membayar (misalnya: lapangan terbuka/alun–alun, taman, dll.)');
                      echo " <br> ";
                      echo displayPreviousYearData($previous_ruang_publik_data, 'ruang_terbuka_hijau', 'Keberadaan Ruang publik terbuka yang peruntukan utamanya sebagai tempat bagi warga desa/kelurahan untuk bersantai/bermain tanpa perlu membayar (misalnya: lapangan terbuka/alun–alun, taman, dll.)');
                      echo " <br> ";
                      echo displayPreviousYearData($previous_ruang_publik_data, 'ruang_terbuka_non_hijau', 'Keberadaan Ruang publik terbuka yang peruntukan utamanya sebagai tempat bagi warga desa/kelurahan untuk bersantai/bermain tanpa perlu membayar (misalnya: lapangan terbuka/alun–alun, taman, dll.)');
                      ?>
                    </p>
                  <?php endif; ?>

                  <!-- Checkbox to use previous year data -->
                  <?php if ($level != 'admin'): ?>
                    <div class="form-group mb-3">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="use_previous_ruang_publik" name="use_previous_ruang_publik" value="1">
                        <label class="form-check-label" for="use_previous_ruang_publik">
                          Gunakan data tahun sebelumnya
                        </label>
                      </div>
                    </div>
                  <?php endif; ?>

                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </form>

                <script>
                  document.addEventListener("DOMContentLoaded", function() {
                    const publicSpaceStatus = document.getElementById("publicSpaceStatus");
                    const greenSpace = document.getElementById("greenSpace");
                    const nonGreenSpace = document.getElementById("nonGreenSpace");
                    const additionalInfo = document.querySelector(".additional-info");
                    const usePreviousCheckbox = document.getElementById("use_previous_ruang_publik");

                    // Data tahun sebelumnya
                    const previousData = {
                      publicSpaceStatus: "<?php echo htmlspecialchars($previous_ruang_publik_data['status_ruang_publik'] ?? ''); ?>",
                      greenSpace: "<?php echo htmlspecialchars($previous_ruang_publik_data['ruang_terbuka_hijau'] ?? ''); ?>",
                      nonGreenSpace: "<?php echo htmlspecialchars($previous_ruang_publik_data['ruang_terbuka_non_hijau'] ?? ''); ?>"
                    };

                    // Fungsi untuk mengatur data tahun sebelumnya ke form
                    function populatePreviousData() {
                      if (usePreviousCheckbox.checked) {
                        // Set nilai ke elemen
                        publicSpaceStatus.value = previousData.publicSpaceStatus || "";
                        greenSpace.value = previousData.greenSpace || "";
                        nonGreenSpace.value = previousData.nonGreenSpace || "";

                        // Tampilkan additional-info jika status ruang publik adalah 'Ada'
                        if (previousData.publicSpaceStatus === "Ada, dikelola" || previousData.publicSpaceStatus === "Ada, tidak dikelola") {
                          additionalInfo.style.display = "block";
                        } else {
                          additionalInfo.style.display = "none";
                        }

                        // Buat elemen menjadi read-only
                        publicSpaceStatus.setAttribute("readonly", true);
                        greenSpace.setAttribute("readonly", true);
                        nonGreenSpace.setAttribute("readonly", true);
                      } else {
                        // Reset form jika checkbox tidak dicentang
                        publicSpaceStatus.value = "";
                        greenSpace.value = "";
                        nonGreenSpace.value = "";
                        additionalInfo.style.display = "none";

                        // Hapus atribut read-only
                        publicSpaceStatus.removeAttribute("readonly");
                        greenSpace.removeAttribute("readonly");
                        nonGreenSpace.removeAttribute("readonly");
                      }
                    }

                    // Event listener untuk checkbox
                    usePreviousCheckbox.addEventListener("change", populatePreviousData);

                    // Event listener untuk perubahan status ruang publik
                    publicSpaceStatus.addEventListener("change", function() {
                      if (this.value === "Ada, dikelola" || this.value === "Ada, tidak dikelola") {
                        additionalInfo.style.display = "block";
                      } else {
                        additionalInfo.style.display = "none";
                      }
                    });

                    // Inisialisasi saat halaman dimuat
                    populatePreviousData();
                  });
                </script>

                <script>
                  document.addEventListener("DOMContentLoaded", function() {
                    const publicSpaceStatus = document.getElementById('publicSpaceStatus');
                    const additionalInfo = document.querySelector('.additional-info');

                    publicSpaceStatus.addEventListener('change', function() {
                      if (this.value === 'Ada, dikelola' || this.value === 'Ada, tidak dikelola') {
                        additionalInfo.style.display = 'block';
                      } else {
                        additionalInfo.style.display = 'none';
                      }
                    });
                  });
                </script>
              <?php endif; ?>

              <!-- Modal Info -->
              <div class="modal fade" id="modalRuangPublik" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <ul>
                        <li>Pilih status ruang publik terbuka berdasarkan kondisi eksisting: "Tidak ada", "Ada, dikelola", atau "Ada, tidak dikelola".</li>
                        <li>Jika ruang publik terbuka ada, pilih status untuk Ruang Terbuka Hijau (RTH) dan Ruang Terbuka Non Hijau (RTNH).</li>
                        <li>Isi opsi "Ada" jika ruang tersebut tersedia dan "Tidak ada" jika tidak tersedia.</li>
                        <li>Data yang dimasukkan harus mencerminkan kondisi terkini untuk memastikan akurasi informasi.</li>
                        <li>Gunakan tombol 'Simpan' untuk menyimpan data yang telah diisi pada form.</li>
                        <li>Pastikan semua data telah diisi dengan benar sebelum menekan tombol 'Simpan'.</li>
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