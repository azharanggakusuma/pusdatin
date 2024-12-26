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
$previous_batas_data = getPreviousYearData($conn, $user_id, $desa_id, 'tb_batas_wilayah_desa', ['batas_utara', 'kecamatan_utara', 'batas_selatan', 'kecamatan_selatan', 'batas_timur', 'kecamatan_timur', 'batas_barat', 'kecamatan_barat'], 'Batas Wilayah Desa');
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
            window.location.href = "olahraga.php";
          });
        } else if (status === 'error') {
          Swal.fire({
            title: "Gagal!",
            text: "Terjadi kesalahan saat menambahkan data.",
            icon: "error",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "olahraga.php";
          });
        } else if (status === 'warning') {
          Swal.fire({
            title: "Peringatan!",
            text: "Mohon lengkapi semua data.",
            icon: "warning",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "olahraga.php";
          });
        }
      </script>
    <?php endif; ?>

    <main class="app-main"> <!--begin::App Content Header-->
      <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Olahraga</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Olahraga
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
              <h3 class="card-title">Ketersediaan fasilitas/lapangan dan kelompok kegiatan olahraga di desa/kelurahan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalOlahraga">
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
              <form action="../../handlers/form_fasilitas_olahraga.php" method="post">
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="sepakbola" class="form-label">Sepak bola</label>
                    <select id="sepakbola" name="sepakbola" class="form-select">
                      <option selected disabled>--- Pilih kondisi ---</option>
                      <option value="Ada, baik">Ada, baik</option>
                      <option value="Ada, rusak sedang">Ada, rusak sedang</option>
                      <option value="Ada, rusak parah">Ada, rusak parah</option>
                      <option value="Tidak ada">Tidak ada</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="bolavoli" class="form-label">Bola voli</label>
                    <select id="bolavoli" name="bolavoli" class="form-select">
                      <option selected disabled>--- Pilih kondisi ---</option>
                      <option value="Ada, baik">Ada, baik</option>
                      <option value="Ada, rusak sedang">Ada, rusak sedang</option>
                      <option value="Ada, rusak parah">Ada, rusak parah</option>
                      <option value="Tidak ada">Tidak ada</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="bulutangkis" class="form-label">Bulu tangkis</label>
                    <select id="bulutangkis" name="bulutangkis" class="form-select">
                      <option selected disabled>--- Pilih kondisi ---</option>
                      <option value="Ada, baik">Ada, baik</option>
                      <option value="Ada, rusak sedang">Ada, rusak sedang</option>
                      <option value="Ada, rusak parah">Ada, rusak parah</option>
                      <option value="Tidak ada">Tidak ada</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="basket" class="form-label">Bola basket</label>
                    <select id="basket" name="basket" class="form-select">
                      <option selected disabled>--- Pilih kondisi ---</option>
                      <option value="Ada, baik">Ada, baik</option>
                      <option value="Ada, rusak sedang">Ada, rusak sedang</option>
                      <option value="Ada, rusak parah">Ada, rusak parah</option>
                      <option value="Tidak ada">Tidak ada</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="tenislapangan" class="form-label">Tenis lapangan</label>
                    <select id="tenislapangan" name="tenislapangan" class="form-select">
                      <option selected disabled>--- Pilih kondisi ---</option>
                      <option value="Ada, baik">Ada, baik</option>
                      <option value="Ada, rusak sedang">Ada, rusak sedang</option>
                      <option value="Ada, rusak parah">Ada, rusak parah</option>
                      <option value="Tidak ada">Tidak ada</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="tenismeja" class="form-label">Tenis meja</label>
                    <select id="tenismeja" name="tenismeja" class="form-select">
                      <option selected disabled>--- Pilih kondisi ---</option>
                      <option value="Ada, baik">Ada, baik</option>
                      <option value="Ada, rusak sedang">Ada, rusak sedang</option>
                      <option value="Ada, rusak parah">Ada, rusak parah</option>
                      <option value="Tidak ada">Tidak ada</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="futsal" class="form-label">Futsal</label>
                    <select id="futsal" name="futsal" class="form-select">
                      <option selected disabled>--- Pilih kondisi ---</option>
                      <option value="Ada, baik">Ada, baik</option>
                      <option value="Ada, rusak sedang">Ada, rusak sedang</option>
                      <option value="Ada, rusak parah">Ada, rusak parah</option>
                      <option value="Tidak ada">Tidak ada</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="renang" class="form-label">Renang</label>
                    <select id="renang" name="renang" class="form-select">
                      <option selected disabled>--- Pilih kondisi ---</option>
                      <option value="Ada, baik">Ada, baik</option>
                      <option value="Ada, rusak sedang">Ada, rusak sedang</option>
                      <option value="Ada, rusak parah">Ada, rusak parah</option>
                      <option value="Tidak ada">Tidak ada</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="beladiri" class="form-label">Bela diri (pencak silat, karate, dll.)</label>
                    <select id="beladiri" name="beladiri" class="form-select">
                      <option selected disabled>--- Pilih kondisi ---</option>
                      <option value="Ada, baik">Ada, baik</option>
                      <option value="Ada, rusak sedang">Ada, rusak sedang</option>
                      <option value="Ada, rusak parah">Ada, rusak parah</option>
                      <option value="Tidak ada">Tidak ada</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="bilyard" class="form-label">Bilyard</label>
                    <select id="bilyard" name="bilyard" class="form-select">
                      <option selected disabled>--- Pilih kondisi ---</option>
                      <option value="Ada, baik">Ada, baik</option>
                      <option value="Ada, rusak sedang">Ada, rusak sedang</option>
                      <option value="Ada, rusak parah">Ada, rusak parah</option>
                      <option value="Tidak ada">Tidak ada</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="fitness" class="form-label">Fitness, aerobik, dll.</label>
                    <select id="fitness" name="fitness" class="form-select">
                      <option selected disabled>--- Pilih kondisi ---</option>
                      <option value="Ada, baik">Ada, baik</option>
                      <option value="Ada, rusak sedang">Ada, rusak sedang</option>
                      <option value="Ada, rusak parah">Ada, rusak parah</option>
                      <option value="Tidak ada">Tidak ada</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="lainnya" class="form-label">Lainnya (tuliskan)</label>
                    <input type="text" class="form-control" id="lainnya" name="lainnya" placeholder="Nama lainnya">
                    <select id="lainnyaSelect" name="lainnyaSelect" class="form-select mt-2" style="display: none;">
                      <option selected disabled>--- Pilih kondisi ---</option>
                      <option value="Ada, baik">Ada, baik</option>
                      <option value="Ada, rusak sedang">Ada, rusak sedang</option>
                      <option value="Ada, rusak parah">Ada, rusak parah</option>
                      <option value="Tidak ada">Tidak ada</option>
                    </select>
                  </div>
                </div>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>

              <script>
                $(document).ready(function() {
                  $('#lainnya').on('input', function() {
                    var inputVal = $(this).val();
                    if (inputVal) {
                      $('#lainnyaSelect').show();
                    } else {
                      $('#lainnyaSelect').hide();
                    }
                  });
                });
              </script>

              <!-- /.row -->
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="modalOlahraga" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih kondisi untuk setiap fasilitas olahraga yang terdaftar di form:
                        <ul>
                          <li>'Ada, baik' jika fasilitas tersedia dan dalam kondisi baik.</li>
                          <li>'Ada, rusak sedang' jika fasilitas tersedia namun mengalami kerusakan sedang.</li>
                          <li>'Ada, rusak parah' jika fasilitas tersedia namun mengalami kerusakan parah.</li>
                          <li>'Tidak ada' jika fasilitas tersebut tidak tersedia.</li>
                        </ul>
                      </li>
                      <li>Untuk opsi 'Lainnya', tuliskan nama fasilitas olahraga yang tidak terdaftar pada kolom yang disediakan. Jika ada, pilih kondisi fasilitas sesuai dengan opsi yang tersedia di dropdown yang muncul.</li>
                      <li>Pastikan untuk mengisi form berdasarkan kondisi fasilitas olahraga terkini di desa/kelurahan Anda.</li>
                      <li>Gunakan tombol 'Simpan' yang terletak di bagian bawah form untuk menyimpan pilihan Anda dan mengirim data.</li>
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