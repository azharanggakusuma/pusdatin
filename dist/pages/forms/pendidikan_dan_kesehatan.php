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
$previous_bacaan_data = getPreviousYearData($conn, $user_id, $desa_id, 'tb_taman_bacaan', ['keberadaan_tbm'], 'Keberadaan Taman Bacaan Masyarakat (TBM) / Perpustakaan Desa');
$previous_bidan_data = getPreviousYearData($conn, $user_id, $desa_id, 'tb_keberadaan_bidan', ['keberadaan_bidan'], 'Keberadaan Bidan Desa yang menetap di Desa/Kelurahan');
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
            window.location.href = "pendidikan_dan_kesehatan.php";
          });
        } else if (status === 'error') {
          Swal.fire({
            title: "Gagal!",
            text: "Terjadi kesalahan saat menambahkan data.",
            icon: "error",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "pendidikan_dan_kesehatan.php";
          });
        } else if (status === 'warning') {
          Swal.fire({
            title: "Peringatan!",
            text: "Mohon lengkapi semua data.",
            icon: "warning",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "pendidikan_dan_kesehatan.php";
          });
        }
      </script>
    <?php endif; ?>

    <main class="app-main"> <!--begin::App Content Header-->
      <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Pendidikan dan Kesehatan</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Pendidikan dan Kesehatan
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
              <h3 class="card-title">Keberadaan Taman Bacaan Masyarakat (TBM) / Perpustakaan Desa</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalTBM">
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
              <?php if ($form_status['Keberadaan Taman Bacaan Masyarakat (TBM) / Perpustakaan Desa']) : ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                  <i class="fas fa-lock me-2"></i>
                  <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php else: ?>
                <form action="../../handlers/form_taman_bacaan.php" method="post">
                  <div class="row">
                    <div class="form-group mb-3">
                      <label for="keberadaan_tbm" class="form-label">Keberadaan Taman Bacaan Masyarakat (TBM) / Perpustakaan Desa</label>
                      <select name="keberadaan_tbm" id="keberadaan_tbm" class="form-select">
                        <option value="" selected disabled>--- Pilih ---</option>
                        <option value="Ada">Ada</option>
                        <option value="Tidak Ada">Tidak ada</option>
                      </select>
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_bacaan_data, 'keberadaan_tbm', 'Keberadaan Taman Bacaan Masyarakat (TBM) / Perpustakaan Desa');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <!-- Checkbox to use previous year data -->
                  <?php if ($level != 'admin'): ?>
                    <div class="form-group mb-3">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="use_previous_bacaan" name="use_previous_bacaan" value="1">
                        <label class="form-check-label" for="use_previous_bacaan">
                          Gunakan data tahun sebelumnya
                        </label>
                      </div>
                    </div>
                  <?php endif; ?>

                  <div class="mb-2">
                    <button type="submit" class="btn btn-primary mt-3">
                      <i class="fas fa-save"></i> &nbsp;Simpan
                    </button>
                  </div>
                </form>

                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    const inputNames = ['keberadaan_tbm'];
                    const previousData = [
                      "<?php echo htmlspecialchars($previous_bacaan_data['keberadaan_tbm']); ?>"
                    ];

                    const checkbox = document.getElementById('use_previous_bacaan');

                    // Function to populate the form fields with previous data
                    function populateFields() {
                      inputNames.forEach((inputName, index) => {
                        const inputField = document.getElementById(inputName);
                        if (checkbox.checked) {
                          inputField.value = previousData[index]; // Set the value of the select fields
                          inputField.readOnly = true; // Make the field read-only if checkbox is checked
                        } else {
                          inputField.value = ''; // Reset the value when checkbox is unchecked
                          inputField.readOnly = false; // Make the field editable when checkbox is unchecked
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
              <!-- /.row -->
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="modalTBM" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih 'Ada' jika di desa/kelurahan terdapat Taman Bacaan Masyarakat (TBM) atau Perpustakaan Desa.</li>
                      <li>Pilih 'Tidak Ada' jika di desa/kelurahan tidak terdapat Taman Bacaan Masyarakat (TBM) atau Perpustakaan Desa.</li>
                      <li>Pastikan untuk memilih salah satu opsi sebelum menyimpan form.</li>
                      <li>Gunakan tombol 'Simpan' untuk mengonfirmasi dan menyimpan pilihan Anda.</li>
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
              <h3 class="card-title">Keberadaan Bidan Desa yang menetap di Desa/Kelurahan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalBidan">
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
              <?php if ($form_status['Keberadaan Bidan Desa yang menetap di Desa/Kelurahan']) : ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                  <i class="fas fa-lock me-2"></i>
                  <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php else: ?>
                <form action="../../handlers/form_keberadaan_bidan.php" method="post">
                  <div class="row">
                    <div class="form-group mb-3">
                      <label for="keberadaan_bidan" class="form-label">Keberadaan Bidan Desa yang menetap di Desa/Kelurahan</label>
                      <select name="keberadaan_bidan" id="keberadaan_bidan" class="form-select">
                        <option value="" selected disabled>--- Pilih ---</option>
                        <option value="Ada">Ada</option>
                        <option value="Tidak Ada">Tidak ada</option>
                      </select>
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_bidan_data, 'keberadaan_bidan', 'Keberadaan Bidan Desa yang menetap di Desa/Kelurahan');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <!-- Checkbox to use previous year data -->
                  <?php if ($level != 'admin'): ?>
                    <div class="form-group mb-3">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="use_previous_bidan" name="use_previous_bidan" value="1">
                        <label class="form-check-label" for="use_previous_bidan">
                          Gunakan data tahun sebelumnya
                        </label>
                      </div>
                    </div>
                  <?php endif; ?>
                  <div class="mb-2">
                    <button type="submit" class="btn btn-primary mt-3">
                      <i class="fas fa-save"></i> &nbsp;Simpan
                    </button>
                  </div>
                </form>
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    const inputNames = ['keberadaan_bidan'];
                    const previousData = [
                      "<?php echo htmlspecialchars($previous_bidan_data['keberadaan_bidan']); ?>"
                    ];

                    const checkbox = document.getElementById('use_previous_bidan');

                    // Function to populate the form fields with previous data
                    function populateFields() {
                      inputNames.forEach((inputName, index) => {
                        const inputField = document.getElementById(inputName);
                        if (checkbox.checked) {
                          inputField.value = previousData[index]; // Set the value of the select fields
                          inputField.readOnly = true; // Make the field read-only if checkbox is checked
                        } else {
                          inputField.value = ''; // Reset the value when checkbox is unchecked
                          inputField.readOnly = false; // Make the field editable when checkbox is unchecked
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
              <!-- /.row -->
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="modalBidan" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih 'Ada' jika terdapat Bidan Desa yang menetap di desa/kelurahan.</li>
                      <li>Pilih 'Tidak Ada' jika tidak terdapat Bidan Desa yang menetap di desa/kelurahan.</li>
                      <li>Pilihan harus dilakukan berdasarkan keadaan aktual di lapangan.</li>
                      <li>Simpan informasi setelah memilih opsi yang sesuai untuk memastikan data tersimpan dengan benar.</li>
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
              <h3 class="card-title">Keberadaan Dukun Bayi/Paraji yang menetap di Desa/Kelurahan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalDukunBayi">
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
              <?php if ($form_status['Keberadaan Dukun Bayi/Paraji yang menetap di Desa/Kelurahan']) : ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                  <i class="fas fa-lock me-2"></i>
                  <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php else: ?>
                <form action="../../handlers/form_keberadaan_dukun_bayi.php" method="post">
                  <div class="row">
                    <div class="form-group mb-3">
                      <label for="keberadaan_dukun_bayi" class="form-label">Keberadaan Dukun Bayi/Paraji yang menetap di Desa/Kelurahan</label>
                      <select name="keberadaan_dukun_bayi" id="keberadaan_dukun_bayi" class="form-select">
                        <option value="" selected disabled>--- Pilih ---</option>
                        <option value="Ada">Ada</option>
                        <option value="Tidak Ada">Tidak ada</option>
                      </select>
                    </div>
                  </div>

                  <div class="mb-2">
                    <button type="submit" class="btn btn-primary mt-3">
                      <i class="fas fa-save"></i> &nbsp;Simpan
                    </button>
                  </div>
                </form>
              <?php endif; ?>
              <!-- /.row -->
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="modalDukunBayi" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih 'Ada' jika terdapat Dukun Bayi/Paraji yang menetap di desa/kelurahan.</li>
                      <li>Pilih 'Tidak Ada' jika tidak terdapat Dukun Bayi/Paraji yang menetap di desa/kelurahan.</li>
                      <li>Verifikasi keberadaan Dukun Bayi/Paraji sebelum membuat pilihan pada form.</li>
                      <li>Gunakan tombol 'Simpan' untuk mengonfirmasi dan menyimpan informasi yang telah dipilih.</li>
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
            <div class="card-header">
              <h3 class="card-title">Jumlah Kejadian Luar Biasa (KLB) atau Wabah Penyakit Selama Setahun Terakhir</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalKLB">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-bs-toggle="collapse" data-bs-target="#collapseForm">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="collapse show" id="collapseForm">
              <div class="card-body">
                <?php if ($form_status['Jumlah Kejadian luar biasa (KLB) atau wabah penyakit selama setahun terakhir']) : ?>
                  <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-lock me-2"></i>
                    <strong>Form Terkunci!</strong> Anda sudah mengisi form ini dan tidak dapat diubah kembali.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                <?php else: ?>
                  <form action="../../handlers/form_klb_wabah.php" method="post">
                    <div class="form-group">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Jenis KLB/Wabah Penyakit</th>
                            <th>Ada</th>
                            <th>Tidak ada</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Muntaber/diare</td>
                            <td><input type="checkbox" name="muntaber_diare" value="Ada" onchange="handleChange(this)"></td>
                            <td><input type="checkbox" name="muntaber_diare" value="Tidak Ada" onchange="handleChange(this)"></td>
                          </tr>
                          <tr>
                            <td>Demam Berdarah</td>
                            <td><input type="checkbox" name="demam_berdarah" value="Ada" onchange="handleChange(this)"></td>
                            <td><input type="checkbox" name="demam_berdarah" value="Tidak Ada" onchange="handleChange(this)"></td>
                          </tr>
                          <tr>
                            <td>Campak</td>
                            <td><input type="checkbox" name="campak" value="Ada" onchange="handleChange(this)"></td>
                            <td><input type="checkbox" name="campak" value="Tidak Ada" onchange="handleChange(this)"></td>
                          </tr>
                          <tr>
                            <td>Malaria</td>
                            <td><input type="checkbox" name="malaria" value="Ada" onchange="handleChange(this)"></td>
                            <td><input type="checkbox" name="malaria" value="Tidak Ada" onchange="handleChange(this)"></td>
                          </tr>
                          <tr>
                            <td>Flu Burung/SARS</td>
                            <td><input type="checkbox" name="flu_burung_sars" value="Ada" onchange="handleChange(this)"></td>
                            <td><input type="checkbox" name="flu_burung_sars" value="Tidak Ada" onchange="handleChange(this)"></td>
                          </tr>
                          <tr>
                            <td>Hepatitis E</td>
                            <td><input type="checkbox" name="hepatitis_e" value="Ada" onchange="handleChange(this)"></td>
                            <td><input type="checkbox" name="hepatitis_e" value="Tidak Ada" onchange="handleChange(this)"></td>
                          </tr>
                          <tr>
                            <td>Difteri</td>
                            <td><input type="checkbox" name="difteri" value="Ada" onchange="handleChange(this)"></td>
                            <td><input type="checkbox" name="difteri" value="Tidak Ada" onchange="handleChange(this)"></td>
                          </tr>
                          <tr>
                            <td>Corona/COVID-19</td>
                            <td><input type="checkbox" name="corona_covid19" value="Ada" onchange="handleChange(this)"></td>
                            <td><input type="checkbox" name="corona_covid19" value="Tidak Ada" onchange="handleChange(this)"></td>
                          </tr>
                          <tr>
                            <td>
                              <input type="text" class="form-control" id="lainnya" name="lainnya_name" placeholder="Lainnya (tuliskan: chikungunya, leptospirosis, kolera, dll)" style="border: none; width: 60%;">
                            </td>
                            <td class="checkbox-lainnya"><input type="checkbox" name="lainnya_status" value="Ada" onchange="handleChange(this)"></td>
                            <td class="checkbox-lainnya"><input type="checkbox" name="lainnya_status" value="Tidak Ada" onchange="handleChange(this)"></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="mb-2">
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> &nbsp;Simpan
                      </button>
                    </div>
                  </form>
                <?php endif; ?>
              </div>
            </div>

            <!-- Modal for Additional Information -->
            <div class="modal fade" id="modalKLB" tabindex="-1" aria-labelledby="modalPKHLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalPKHLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pastikan untuk mencentang kotak yang relevan berdasarkan kejadian pada tahun lalu.</li>
                      <li>Centang 'Ada' jika wabah penyakit terjadi, jika tidak, centang 'Tidak ada'.</li>
                      <li>Jika menandai 'Lainnya', sebutkan penyakitnya di tempat yang tersedia.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>

            <script>
              function handleChange(checkbox) {
                const allCheckboxes = document.querySelectorAll('input[name="' + checkbox.name + '"]');
                allCheckboxes.forEach((cb) => {
                  if (cb !== checkbox) cb.checked = false;
                });
              }
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