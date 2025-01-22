<?php
include_once "../../config/conn.php";
include "../../config/session.php";

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
  <meta name="keywords"
    content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard">
  <!--end::Primary Meta Tags--><!--begin::Fonts-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
    integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">
  <!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css"
    integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
  <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
    integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
  <!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
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
            window.location.href = "perumahan_dan_lingkungan_hidup.php";
          });
        } else if (status === 'error') {
          Swal.fire({
            title: "Gagal!",
            text: "Terjadi kesalahan saat menambahkan data.",
            icon: "error",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "perumahan_dan_lingkungan_hidup.php";
          });
        } else if (status === 'warning') {
          Swal.fire({
            title: "Peringatan!",
            text: "Mohon lengkapi semua data.",
            icon: "warning",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "perumahan_dan_lingkungan_hidup.php";
          });
        }
      </script>
    <?php endif; ?>

    <main class="app-main"> <!--begin::App Content Header-->
      <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Perumahan dan Lingkungan Hidup</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Perumahan dan Lingkungan Hidup
                </li>
              </ol>
            </div>
          </div> <!--end::Row-->
        </div> <!--end::Container-->
      </div> <!--end::App Content Header--> <!--begin::App Content-->
      <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->

          <!-- Template Form -->

          <!-- BEGIN:: Jumlah Keluarga Pengguna Listrik Dan Lampu Tenaga Surya -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Jumlah Keluarga Pengguna Listrik dan Lampu Tenaga Surya</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#pln">
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
              <form action="../../handlers/form_pengguna_listrik.php" method="post">
                <div class="row">
                  <div class="form-group">
                    <h5 class="mb-3">A. Jumlah Keluarga Pengguna Listrik:</h5>
                    <li class="mb-1">PLN (Perusahaan Listrik Negara)</li>
                    <input name="jumlah_pln" type="number" class="form-control mb-1" placeholder="--- Masukkan jumlah ---" min="0" required>
                    <li class="mb-1">Non-PLN (Misalnya: Swasta, Swadaya, Atau Perseorangan)</li>
                    <input name="jumlah_non_pln" type="number" class="form-control mb-4" placeholder="--- Masukkan jumlah ---" min="0" required>
                    <h5 class="mb-2">B. Jumlah Keluraga Bukan Pengguna Listrik:</h5>
                    <input name="jumlah_bukan_pengguna_listrik" type="number" class="form-control mb-4" placeholder="--- Masukkan jumlah ---" min="0" required>
                    <h5 class="mb-2">C. Keluarga yang Menggunakan Lampu Tenaga Surya:</h5>
                    <select name="penggunaan_lampu_tenaga_surya" class="form-control" required>
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada, Sebagian Besar">Ada, Sebagian Besar</option>
                      <option value="Ada, Sebagian Kecil">Ada, Sebagian Kecil</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>
            <!-- Modal Info -->
            <div class="modal fade" id="pln" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalInfoLabel">Aturan Pengisian Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isikan jumlah keluarga yang menggunakan listrik PLN pada kolom pertama.</li>
                      <li>Isikan jumlah keluarga yang menggunakan listrik non-PLN pada kolom kedua.</li>
                      <li>Isikan jumlah keluarga yang tidak menggunakan listrik pada kolom ketiga.</li>
                      <li>Pilih kondisi penggunaan lampu tenaga surya pada kolom keempat sesuai dengan kondisi desa Anda.</li>
                      <li>Pastikan semua data yang dimasukkan sudah benar sebelum menyimpan.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- END::Jumlah Keluarga Pengguna Listrik Dan Lampu Tenaga Surya -->

          <!-- BEGIN:: Penerangan di jalan utama desa/kelurahan -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Penerangan di Jalan Utama Desa/Kelurahan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#penerangan">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool toggle-form_2">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".toggle-form_2").on("click", function() {
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
              <form action="../../handlers/form_penerangan_jalan.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Penerangan di Jalan Desa/Kelurahan yang Menggunakan Lampu Tenaga Surya</label>
                    <select name="lampu_tenaga_surya" class="form-control" required>
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>

                  <div class="form-group mb-3">
                    <label class="mb-2">Penerangan di Jalan Utama Desa/Kelurahan</label>
                    <select name="penerangan_jalan_utama" class="form-control" required>
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada, Sebagian Besar">Ada, Sebagian Besar</option>
                      <option value="Ada, Sebagian Kecil">Ada, Sebagian Kecil</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>

                  <div class="form-group mb-3">
                    <label class="mb-2">Sumber Penerangan di Jalan Utama Desa/Kelurahan</label>
                    <select name="sumber_penerangan" class="form-control" required>
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Listrik Diusahakan Oleh Pemerintah">Listrik Diusahakan Oleh Pemerintah</option>
                      <option value="Listrik Diusahakan Oleh Non Pemerintah">Listrik Diusahakan Oleh Non Pemerintah</option>
                      <option value="Non Listrik">Non Listrik</option>
                    </select>
                  </div>
                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>
            <!-- Modal Info -->
            <div class="modal fade" id="penerangan" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi kondisi penerangan di jalan desa/kelurahan yang menggunakan lampu tenaga surya pada kolom pertama.</li>
                      <li>Isi kondisi penerangan di jalan utama desa/kelurahan pada kolom kedua, dengan pilihan:</li>
                      <ul>
                        <li><strong>Ada, Sebagian Besar</strong> jika penerangan sudah cukup di sebagian besar jalan utama.</li>
                        <li><strong>Ada, Sebagian Kecil</strong> jika hanya sebagian kecil jalan utama yang sudah diterangi.</li>
                        <li><strong>Tidak Ada</strong> jika tidak ada penerangan di jalan utama sama sekali.</li>
                      </ul>
                      <li>Isi sumber penerangan pada kolom ketiga, dengan pilihan:</li>
                      <ul>
                        <li><strong>Listrik Diusahakan Oleh Pemerintah</strong> jika penerangan menggunakan listrik yang disediakan oleh pemerintah.</li>
                        <li><strong>Listrik Diusahakan Oleh Non Pemerintah</strong> jika penerangan menggunakan listrik yang disediakan oleh pihak swasta atau lainnya.</li>
                        <li><strong>Non Listrik</strong> jika penerangan menggunakan sumber selain listrik.</li>
                      </ul>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- END::Penerangan di jalan utama desa/kelurahan -->

          <!-- BEGIN:: Keberadaan Tempat Pembuangan Sampah Sementara (Tps) , Tempat Penampungan Sementara Reduce,Reuse,Recycle (Tps3r) Dan Bank Sampah -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Keberadaan Tempat Pembuangan Sampah Sementara (TPS), TPS3R, dan Bank Sampah</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#tps">
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
              <form action="../../handlers/form_pengelolaan_sampah.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Tempat Pembuangan Sampah Sementara (TPS)</label>
                    <select name="tps" class="form-control" required>
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada, Digunakan">Ada, Digunakan</option>
                      <option value="Ada, Tidak Digunakan">Ada, Tidak Digunakan</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Tempat Penampungan Sementara Reduce, Reuse, Recycle (TPS3R)</label>
                    <select name="tps3r" class="form-control" required>
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada, Digunakan">Ada, Digunakan</option>
                      <option value="Ada, Tidak Digunakan">Ada, Tidak Digunakan</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Bank Sampah di Desa/Kelurahan</label>
                    <select name="bank_sampah" class="form-control" required>
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                      <option value="Non Listrik">Non Listrik</option>
                    </select>
                  </div>
                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>
            <!-- Modal Info -->
            <div class="modal fade" id="tps" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi kondisi tempat pembuangan sampah sementara (TPS) pada kolom pertama.</li>
                      <li>Isi kondisi tempat penampungan sementara Reduce, Reuse, Recycle (TPS3R) pada kolom kedua.</li>
                      <li>Isi keberadaan bank sampah pada kolom ketiga.</li>
                      <li>Pastikan untuk memilih opsi yang paling sesuai dengan kondisi di desa/kelurahan Anda.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- END::Keberadaan Tempat pembuangan sampah sementara (TPS) , Tempat Penampungan Sementara Reduce,Reuse,Recycle (TPS3R) dan Bank Sampah -->

          <!-- BEGIN:: Keberadaan permukiman di bawah SUTET/SUTT/SUTTAS -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Wilayah Desa/Kelurahan Dilalui Saluran Udara Tegangan Ekstra Tinggi (Sutet) /
                Saluran Udara Tegangan Tinggi(Sutt) / Saluran Udara Tegangan Tinggi Arus Searah (Suttas)</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalPKH">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool 3_toggle-form">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".3_toggle-form").on("click", function() {
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
              <form action="../../handlers/form_sutet.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">
                      Wilayah desa/kelurahan dilalui saluran udara tegangan ekstra tinggi (SUTET) / Saluran Udara
                      Tegangan Tinggi (SUUT) / Saluran Udara Tegangan Tinggi Arus Searah (SUTTAS)
                    </label>
                    <select required name="SUTET" id="TPS" class="form-control">
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada, Digunakan">Ada, Digunakan</option>
                      <option value="Ada, Tidak Digunakan">Ada, Tidak Digunakan</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>

                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Pemukiman Di Bawah SUTET/SUTT/SUTTAS</label>
                    <select required name="keberadaan_dibawah_sutet" id="keberadaan_dibawah_sutet" class="form-control"
                      onchange="togglePemukimanInput()">
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                </div>

                <div class="form-group mb-3" id="pemukiman_form" style="display: none;">
                  <label class="mb-2">Jumlah Pemukiman di Bawah SUTET/SUTT/SUTTAS</label>
                  <input required name="jumlah_pemukiman_dibawah_sutet" type="number" min="0" class="form-control"
                    placeholder="Isi Dengan Angka" />
                </div>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>

              <script>
                function togglePemukimanInput() {
                  const keberadaan = document.getElementById('keberadaan_dibawah_sutet').value;
                  const pemukimanForm = document.getElementById('pemukiman_form');
                  if (keberadaan === 'Ada') {
                    pemukimanForm.style.display = 'block';
                  } else {
                    pemukimanForm.style.display = 'none';
                  }
                }
              </script>

              <!-- /.row -->
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="modalPKH" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih kondisi apakah wilayah desa/kelurahan dilalui oleh saluran udara tegangan ekstra tinggi
                        (SUTET), saluran udara tegangan tinggi (SUUT), atau saluran udara tegangan tinggi arus searah
                        (SUTTAS).</li>
                      <li>Jika wilayah desa/kelurahan dilalui oleh saluran udara tegangan ekstra tinggi atau saluran
                        udara tegangan tinggi, pilih salah satu dari opsi berikut:
                        <ul>
                          <li><strong>Ada, Digunakan</strong> jika saluran udara tersebut aktif dan digunakan untuk
                            distribusi energi listrik.</li>
                          <li><strong>Ada, Tidak Digunakan</strong> jika saluran udara tersebut ada, namun tidak aktif
                            atau tidak digunakan.</li>
                          <li><strong>Tidak Ada</strong> jika wilayah desa/kelurahan tidak dilalui oleh saluran udara
                            tersebut.</li>
                        </ul>
                      </li>
                      <li>Jika ada pemukiman yang terletak di bawah SUTET/SUTT/SUTTAS, pilih opsi <strong>Ada</strong>,
                        dan isikan jumlah pemukiman di bawah saluran udara tersebut pada kolom yang disediakan. Jika
                        tidak ada pemukiman di bawah saluran udara tersebut, pilih opsi <strong>Tidak Ada</strong>.</li>
                      <li>Pastikan untuk mengisi dengan angka yang sesuai untuk jumlah pemukiman, jika diperlukan.</li>
                      <li>Jika wilayah Anda tidak dilalui oleh saluran udara tegangan tinggi, cukup pilih <strong>Tidak
                          Ada</strong> untuk semua pertanyaan.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- END::Keberadaan permukiman di bawah SUTET/SUTT/SUTTAS -->

          <!-- BEGIN:: Keberadaan Sungai yang melintasi wilayah desa -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Keberadaan Sungai Yang Melintasi Wilayah Desa</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#sungai">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool toggle-form_5">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".toggle-form_5").on("click", function() {
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
              <form action="../../handlers/form_keberadaan_sungai.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Sungai Yang Melintasi</label>
                    <select name="keberadaan_sungai" id="keberadaan_sungai" class="form-control"
                      onchange="toggleSungaiInput()">
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>

                  <div id="daftar_sungai" style="display: none;">
                    <div class="form-group mb-3">
                      <label class="mb-2">Nama danau/waduk/situ yang berada di wilayah desa Yang Melintasi Ke -
                        1</label>
                      <input required name="nama_sungai_1" type="text" class="form-control"
                        placeholder="Isi Dengan nama sungai">
                    </div>

                    <div class="form-group mb-3">
                      <label class="mb-2">Nama Sungai Yang Melintasi Ke - 2</label>
                      <input required name="nama_sungai_2" type="text" class="form-control"
                        placeholder="Isi Dengan nama sungai">
                    </div>

                    <div class="form-group mb-3">
                      <label class="mb-2">Nama Sungai Yang Melintasi Ke - 3</label>
                      <input required name="nama_sungai_3" type="text" class="form-control"
                        placeholder="Isi Dengan nama sungai">
                    </div>

                    <div class="form-group mb-3">
                      <label class="mb-2">Nama Sungai Yang Melintasi Ke - 4</label>
                      <input required name="nama_sungai_4" type="text" class="form-control"
                        placeholder="Isi Dengan nama sungai">
                    </div>
                  </div>
                </div>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>

              <script>
                function toggleSungaiInput() {
                  const keberadaan = document.getElementById('keberadaan_sungai').value;
                  const pemukimanForm = document.getElementById('daftar_sungai');
                  if (keberadaan === 'Ada') {
                    pemukimanForm.style.display = 'block';
                  } else {
                    pemukimanForm.style.display = 'none';
                  }
                }
              </script>


              <!-- /.row -->
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="sungai" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isikan keberadaan sungai yang melintasi desa/kelurahan pada kolom pertama, dengan pilihan:
                        <ul>
                          <li><strong>Ada</strong> jika ada sungai yang melintasi wilayah desa/kelurahan.</li>
                          <li><strong>Tidak Ada</strong> jika tidak ada sungai yang melintasi wilayah desa/kelurahan.
                          </li>
                        </ul>
                      </li>
                      <li>Jika ada sungai yang melintasi wilayah, isikan nama-nama sungai tersebut pada kolom
                        berikutnya, dengan format:
                        <ul>
                          <li><strong>Nama Sungai Ke - 1</strong> jika ada satu sungai.</li>
                          <li><strong>Nama Sungai Ke - 2</strong> jika ada dua sungai, dan seterusnya.</li>
                          <li>Jika lebih dari 4 sungai yang melintasi wilayah, pilihlah yang paling penting atau utama.
                          </li>
                        </ul>
                      </li>
                      <li>Pastikan untuk menuliskan nama sungai dengan benar agar data yang terkumpul akurat.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END::Keberadaan Sungai yang melintasi wilayah desa -->

          <!-- BEGIN:: Keberadaan Danau/Waduk/Situ Yang Berada Di Wilayah Desa -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Keberadaan Danau/Waduk/Situ Yang Berada Di Wilayah Desa</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#danau">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool toggle-form_50">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".toggle-form_50").on("click", function() {
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
              <form action="../../handlers/form_keberadaan_danau.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Danau/Waduk/Situ Yang Berada Di Wilayah Desa</label>
                    <select name="keberadaan_danau" id="keberadaan_danau" class="form-control"
                      onchange="toggleDanauInput()">
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>

                  <div id="daftar_danau" style="display: none;">
                    <div class="form-group mb-3">
                      <label class="mb-2">Nama danau/waduk/situ yang berada di wilayah desa Ke - 1</label>
                      <input required name="nama_danau_1" type="text" class="form-control"
                        placeholder="Isi Dengan nama sungai">
                    </div>

                    <div class="form-group mb-3">
                      <label class="mb-2">Nama danau/waduk/situ yang berada di wilayah desa Ke - 2</label>
                      <input required name="nama_danau_2" type="text" class="form-control"
                        placeholder="Isi Dengan nama sungai">
                    </div>

                    <div class="form-group mb-3">
                      <label class="mb-2">Nama danau/waduk/situ yang berada di wilayah desa Ke - 3</label>
                      <input required name="nama_danau_3" type="text" class="form-control"
                        placeholder="Isi Dengan nama sungai">
                    </div>

                    <div class="form-group mb-3">
                      <label class="mb-2">Nama danau/waduk/situ yang berada di wilayah desa Ke - 4</label>
                      <input required name="nama_danau_4" type="text" class="form-control"
                        placeholder="Isi Dengan nama sungai">
                    </div>
                  </div>
                </div>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>

              <script>
                function toggleDanauInput() {
                  const keberadaan = document.getElementById('keberadaan_danau').value;
                  const pemukimanForm = document.getElementById('daftar_danau');
                  if (keberadaan === 'Ada') {
                    pemukimanForm.style.display = 'block';
                  } else {
                    pemukimanForm.style.display = 'none';
                  }
                }
              </script>


              <!-- /.row -->
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="danau" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isikan keberadaan danau/waduk/situ yang melintasi desa/kelurahan pada kolom pertama, dengan
                        pilihan:
                        <ul>
                          <li><strong>Ada</strong> jika ada danau/waduk/situ yang melintasi wilayah desa/kelurahan.</li>
                          <li><strong>Tidak Ada</strong> jika tidak ada danau/waduk/situ yang melintasi wilayah
                            desa/kelurahan.
                          </li>
                        </ul>
                      </li>
                      <li>Jika ada danau/waduk/situ yang melintasi wilayah, isikan nama-nama danau/waduk/situ tersebut
                        pada kolom
                        berikutnya, dengan format:
                        <ul>
                          <li><strong>Nama danau/waduk/situ yang berada di wilayah desa Ke - 1</strong> jika ada satu
                            danau/waduk/situ.</li>
                          <li><strong>Nama danau/waduk/situ yang berada di wilayah desa Ke - 2</strong> jika ada dua
                            danau/waduk/situ, dan seterusnya.</li>
                          <li>Jika tidak ada maka isi dengan tanda ( - )
                          </li>
                        </ul>
                      </li>
                      <li>Pastikan untuk menuliskan nama sungai dengan benar agar data yang terkumpul akurat.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END::Keberadaan Danau/Waduk/Situ Yang Berada Di Wilayah Desa -->

          <!-- BEGIN:: Keberadaan Permukiman Di Bantaran Sungai -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Keberadaan Permukiman Di Bantaran Sungai</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#danau">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool toggle-form_3123">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".toggle-form_3123").on("click", function() {
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
              <form action="../../handlers/form_keberadaan_permukiman_bantaran.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Pemukiman Di Bantaran Sungai</label>
                    <select name="keberadaan_pemukiman_bantaran" id="keberadaan_pemukiman_bantaran" class="form-control"
                      onchange="toggleBantaranInput()">
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>

                  <div id="jumlah_pemukiman_bantaran" style="display: none;">
                    <div class="form-group mb-3">
                      <label class="mb-2">Jumlah Pemukiman Di Bantaran Sungai</label>
                      <input required name="pemukiman_bantaran" type="number" min="0" class="form-control"
                        placeholder="Isi Dengan Angka">
                    </div>
                  </div>
                </div>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>

              <script>
                function toggleBantaranInput() {
                  const keberadaan = document.getElementById('keberadaan_pemukiman_bantaran').value;
                  const pemukimanForm = document.getElementById('jumlah_pemukiman_bantaran');
                  if (keberadaan === 'Ada') {
                    pemukimanForm.style.display = 'block';
                  } else {
                    pemukimanForm.style.display = 'none';
                  }
                }
              </script>


              <!-- /.row -->
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="danau" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isikan keberadaan permukiman di bantaran sungai pada kolom pertama, dengan pilihan:
                        <ul>
                          <li><strong>Ada</strong> jika terdapat permukiman di bantaran sungai di wilayah
                            desa/kelurahan.</li>
                          <li><strong>Tidak Ada</strong> jika tidak terdapat permukiman di bantaran sungai di wilayah
                            desa/kelurahan.</li>
                        </ul>
                      </li>
                      <li>Jika ada permukiman di bantaran sungai, isikan jumlahnya pada kolom berikutnya dengan format:
                        <ul>
                          <li>Masukkan angka yang mencerminkan jumlah permukiman di bantaran sungai.</li>
                          <li>Pastikan jumlah yang diisikan akurat dan berdasarkan data terkini.</li>
                        </ul>
                      </li>
                      <li>Jika tidak ada permukiman di bantaran sungai, kolom jumlah akan otomatis dinonaktifkan.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END::Keberadaan Danau/Waduk/Situ Yang Berada Di Wilayah Desa -->

          <!-- BEGIN:: Banyaknya embung dan Keberadaan Lokasi Mata Air -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Banyaknya embung dan Keberadaan Lokasi Mata Air</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#EMBUNG">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool 100_toggle-form">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".100_toggle-form").on("click", function() {
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
              <form action="../../handlers/form_embung.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Jumlah Embung</label>
                    <input required name="jumlah_embung" class="form-control" type="number" min="0"
                      placeholder="Isi Dengan Angka">
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Lokasi Mata Air</label>
                    <select name="mata_air" id="mata_air" class="form-control">
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada, Dikelola">ADA, DIKELOLA </option>
                      <option value="Ada, Tidak Dikelola">ADA, TIDAK DIKELOLA</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
              <!-- /.row -->
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="EMBUNG" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isikan jumlah embung yang ada di desa/kelurahan pada kolom pertama, dengan format angka
                        (misal: 1, 2, 3).</li>
                      <li>Untuk kolom lokasi mata air, pilih salah satu opsi yang sesuai dengan kondisi di
                        desa/kelurahan Anda:</li>
                      <ul>
                        <li><strong>Ada, Dikelola</strong> jika ada mata air yang dikelola oleh pihak tertentu.</li>
                        <li><strong>Ada, Tidak Dikelola</strong> jika ada mata air yang tidak dikelola atau tidak ada
                          pengelolaan resmi.</li>
                        <li><strong>Tidak Ada</strong> jika tidak ada mata air di wilayah tersebut.</li>
                      </ul>
                      <li>Pastikan untuk memilih opsi yang paling sesuai dengan kondisi yang ada di desa/kelurahan Anda.
                      </li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END::Banyaknya embung dan Keberadaan Lokasi Mata Air -->

          <!-- BEGIN:: Keberadaan permukiman kumuh (sanitasi lingkungan buruk, bangunan padat dan sebagian besar tidak layak huni)  ) -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Keberadaan permukiman kumuh (sanitasi lingkungan buruk, bangunan padat dan sebagian
                besar tidak layak huni) </h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#KUMUH">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool 129">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".129").on("click", function() {
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
              <form action="../../handlers/form_permukiman_kumuh.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Permukiman Kumuh (Sanitasi Lingkungan Buruk, Bangunan Padat Dan
                      Sebagian Besar Tidak Layak Huni)Di Desa/Kelurahan</label>
                    <select name="keberadaan_pemukiman_kumuh" id="keberadaan_pemukiman_kumuh" class="form-control"
                      onchange="toggleSungaiContainer()">
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                  <div id="jumlah_pemukiman_kumuh" style="display: none;">
                    <div class="form-group mb-3">
                      <label class="mb-2">Jumlah Pemukiman Kumuh</label>
                      <input required name="jumlah_pemukiman_kumuh" type="text" class="form-control"
                        placeholder="Isi Dengan nama sungai">
                    </div>
                  </div>
                </div>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>

              <script>
                function toggleSungaiContainer() {
                  const keberadaanSungai = document.getElementById('keberadaan_pemukiman_kumuh').value;
                  const daftarPemukimanKumuh = document.getElementById('jumlah_pemukiman_kumuh');
                  if (keberadaanSungai === 'Ada') {
                    daftarPemukimanKumuh.style.display = 'block';
                  } else {
                    daftarPemukimanKumuh.style.display = 'none';
                  }
                }
              </script>

              <!-- /.row -->
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="KUMUH" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isikan apakah terdapat permukiman kumuh di desa/kelurahan pada kolom pertama.</li>
                      <li>Jika jawabannya <strong>Ada</strong>, maka akan muncul kolom tambahan untuk mengisi jumlah
                        permukiman kumuh yang ada di desa/kelurahan Anda. Masukkan angka yang sesuai dengan jumlah
                        permukiman kumuh yang ada.</li>
                      <li>Jika jawabannya <strong>Tidak Ada</strong>, kolom jumlah permukiman kumuh tidak akan
                        ditampilkan.</li>
                      <li>Pastikan untuk memilih opsi yang paling sesuai dengan kondisi di desa/kelurahan Anda.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END::Keberadaan permukiman kumuh (sanitasi lingkungan buruk, bangunan padat dan sebagian besar tidak layak huni)  ) -->

          <!-- BEGIN:: Keberadaan Lokasi Penggalian Golongan C -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Keberadaan Lokasi Penggalian Golongan C</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalGolonganC">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool 200_toggle-form">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".200_toggle-form").on("click", function() {
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
              <form action="../../handlers/form_lokasi_penggalian.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">
                      Keberadaan Lokasi Penggalian Golongan C (Misalnya: Batu Kali, Pasir, Kapur, Kaolin, Pasir Kuarsa,
                      Tanah Liat, Dll.)
                    </label>
                    <select required name="galian" id="TPS" class="form-control">
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>
            <!-- /.card-body -->

            <!-- Modal Info -->
            <div class="modal fade" id="modalGolonganC" tabindex="-1" aria-labelledby="aturanModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Silahkan Pilih Antara Ada Atau Tidak Ada</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END:: Keberadaan Lokasi Penggalian Golongan C -->

          <!-- BEGIN:: Jumlah Sarana Prasarana Kebersihan -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Jumlah Sarana Prasarana Kebersihan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalKebersihan">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool 20000_toggle-form">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".20000_toggle-form").on("click", function() {
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
              <form action="../../handlers/form_prasarana_kebersihan.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Jumlah Sarana Prasarana Kebersihan</label>
                    <input required class="form-control" type="number" min="0" name="prasarana_kebersihan"
                      placeholder="Isi Dengan Angka" required>
                  </div>
                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>
            <!-- /.card-body -->

            <!-- Modal Info -->
            <div class="modal fade" id="modalKebersihan" tabindex="-1" aria-labelledby="aturanModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi Dengan Angka</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END:: Jumlah Sarana Prasarana Kebersihan -->

          <!-- BEGIN:: Jumlah Rumah Tidak Layak Huni -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Jumlah Rumah Tidak Layak Huni</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalRumah">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool 2000_toggle-form">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".2000_toggle-form").on("click", function() {
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
              <form action="../../handlers/form_rumah_tidak_layak_huni.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Jumlah Rumah Tidak Layak Huni</label>
                    <input required class="form-control" type="number" min="0" name="rumah_tidak_layak_huni"
                      placeholder="Isi Dengan Angka" required>
                  </div>
                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>
            <!-- /.card-body -->

            <!-- Modal Info -->
            <div class="modal fade" id="modalRumah" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi Dengan Angka</li>

                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END:: Jumlah Rumah Tidak Layak Huni -->

        </div> <!--end::Container-->
      </div> <!--end::App Content-->
    </main> <!--end::App Main--> <!--begin::Footer-->

    <?php include("../../components/footer.php"); ?>
  </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->

  <!-- Tambahkan library Select2 dan tema Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
    rel="stylesheet" />
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

  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"
    integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
  <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
  <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script>
  <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
  <script src="../../../dist/js/adminlte.js"></script>
  <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
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