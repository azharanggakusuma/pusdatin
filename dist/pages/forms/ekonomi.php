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

// tb_sentra_industri
$previous_sentra_industri = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_sentra_industri',
  ['keberadaan', 'jumlah_sentra', 'produk_utama'],
  'Keberadaan Sentra Industri Unggulan Desa',
  $tahun
);

// tb_produk_unggulan
$previous_produk_unggulan = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_produk_unggulan',
  ['keberadaan', 'makanan_unggulan', 'non_makanan_unggulan'],
  'Keberadaan Produk Barang Unggulan',
  $tahun
);

// tb_pangkalan_minyak
$previous_pangkalan_minyak = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_pangkalan_minyak',
  ['keberadaan_minyak_tanah', 'keberadaan_lpg'],
  'Keberadaan Pangkalan Minyak Tanah dan LPG',
  $tahun
);

// tb_bank_operasi
$previous_bank_operasi = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_bank_operasi',
  ['bank_pemerintah', 'bank_swasta', 'bank_bpr', 'jarak_bank_terdekat'],
  'Bank Operasi',
  $tahun
);

// tb_koperasi
$previous_koperasi = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_koperasi',
  ['koperasi_kud', 'koperasi_kopinkra', 'koperasi_ksp', 'koperasi_lainnya', 'toko_kud', 'toko_bumdesa', 'toko_lainnya'],
  'Koperasi',
  $tahun
);

// tb_sarana_ekonomi
$previous_sarana_ekonomi = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_sarana_ekonomi',
  [
    'bmt_jumlah',
    'bmt_jarak',
    'bmt_kemudahan',
    'atm_jumlah',
    'atm_jarak',
    'atm_kemudahan',
    'agen_bank_jumlah',
    'agen_bank_jarak',
    'agen_bank_kemudahan',
    'valas_jumlah',
    'valas_jarak',
    'valas_kemudahan',
    'pegadaian_jumlah',
    'pegadaian_jarak',
    'pegadaian_kemudahan',
    'agen_tiket_jumlah',
    'agen_tiket_jarak',
    'agen_tiket_kemudahan',
    'bengkel_jumlah',
    'bengkel_jarak',
    'bengkel_kemudahan',
    'salon_jumlah',
    'salon_jarak',
    'salon_kemudahan'
  ],
  'Sarana Ekonomi',
  $tahun
);

// tb_sarana_prasarana
$previous_sarana_prasarana = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_sarana_prasarana',
  [
    'kelompok_pertokoan_jumlah',
    'kelompok_pertokoan_kemudahan',
    'pasar_permanen_jumlah',
    'pasar_permanen_kemudahan',
    'pasar_semi_permanen_jumlah',
    'pasar_semi_permanen_kemudahan',
    'pasar_tanpa_bangunan_jumlah',
    'pasar_tanpa_bangunan_kemudahan',
    'minimarket_jumlah',
    'minimarket_kemudahan',
    'restoran_jumlah',
    'restoran_kemudahan',
    'warung_makan_jumlah',
    'warung_makan_kemudahan',
    'toko_kelontong_jumlah',
    'toko_kelontong_kemudahan',
    'hotel_jumlah',
    'hotel_kemudahan',
    'penginapan_jumlah',
    'penginapan_kemudahan'
  ],
  'Sarana Prasarana',
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
            window.location.href = "ekonomi.php";
          });
        } else if (status === 'error') {
          Swal.fire({
            title: "Gagal!",
            text: "Terjadi kesalahan saat menambahkan data.",
            icon: "error",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "ekonomi.php";
          });
        } else if (status === 'warning') {
          Swal.fire({
            title: "Peringatan!",
            text: "Mohon lengkapi semua data.",
            icon: "warning",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "ekonomi.php";
          });
        }
      </script>
    <?php endif; ?>

    <main class="app-main"> <!--begin::App Content Header-->
      <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Ekonomi</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Ekonomi
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
              <h3 class="card-title">Keberadaan Sentra Industri Unggulan Desa</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalsentraindustri">
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
              <form action="../../handlers/form_sentra_industri.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Sentra Industri Unggulan Desa</label>
                    <select name="keberadaan" id="publicSpaceStatus" class="form-control" required>
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_sentra_industri, 'keberadaan', 'Keberadaan Sentra Industri Unggulan Desa');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="form-group mb-3" id="sentraIndustriInfo" style="display: none;">
                  <label class="mb-2">Sentra Industri</label>
                  <input type="number" class="form-control" name="sentra_industri" id="sentra_industri" placeholder=" --- Masukkan jumlah --- ">
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sentra_industri, 'jumlah_sentra', 'Keberadaan Sentra Industri Unggulan Desa');
                      ?>
                    </p>
                  <?php endif; ?>
                </div>
                <div class="form-group mb-3" id="muatanUsahaInfo" style="display: none;">
                  <label class="mb-2">Produk pada sentra industri yang mempunyai muatan usaha terbanyak</label>
                  <input type="text" class="form-control" name="muatan_usaha" id="muatan_usaha" placeholder=" --- Tuliskan produk --- ">
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sentra_industri, 'produk_utama', 'Keberadaan Sentra Industri Unggulan Desa');
                      ?>
                    </p>
                  <?php endif; ?>
                </div>

                <script>
                  document.addEventListener("DOMContentLoaded", function() {
                    const publicSpaceStatus = document.getElementById('publicSpaceStatus');
                    const sentraIndustriInfo = document.getElementById('sentraIndustriInfo');
                    const muatanUsahaInfo = document.getElementById('muatanUsahaInfo');

                    publicSpaceStatus.addEventListener('change', function() {
                      if (this.value === 'Ada') {
                        sentraIndustriInfo.style.display = 'block';
                        muatanUsahaInfo.style.display = 'block';
                      } else {
                        sentraIndustriInfo.style.display = 'none';
                        muatanUsahaInfo.style.display = 'none';
                      }
                    });
                  });
                </script>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>

              <!-- /.row -->
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="modalsentraindustri" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi bagian Keberadaan Sentra Industri Unggulan Desa dengan memilih Ada/Tidak Ada, jika Ada lanjut mengisi</li>
                      <li>isi dengan jumlah Sentra Industri</li>
                      <li>Tuliskan produk pada sentra industri yang mempunyai muatan usaha terbanyak</li>
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
              <h3 class="card-title">Keberadaan Produk barang unggulan/utama di desa/kelurahan (Makanan dan Non Makanan)</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalkeberadaanproduk">
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
              <form action="../../handlers/form_produk_unggulan.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Produk barang unggulan/utama di desa/kelurahan (Makanan dan Non Makanan)</label>
                    <select name="keberadaan" id="productPresence" class="form-control" required>
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_produk_unggulan, 'keberadaan', 'Keberadaan Produk Barang Unggulan');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="form-group mb-3" id="productInfo" style="display: none;">
                  <label class="mb-2">Produk barang unggulan/utama desa/kelurahan</label>
                  <input type="text" class="form-control mb-2" name="makanan_unggulan" id="makanan_unggulan" placeholder=" --- Tuliskan Makanan --- ">
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_produk_unggulan, 'makanan_unggulan', 'Keberadaan Produk Barang Unggulan');
                      ?>
                    </p>
                  <?php endif; ?>
                  <input type="text" class="form-control" name="non_makanan_unggulan" id="non_makanan_unggulan" placeholder=" --- Tuliskan Non Makanan --- ">
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_produk_unggulan, 'non_makanan_unggulan', 'Keberadaan Produk Barang Unggulan');
                      ?>
                    </p>
                  <?php endif; ?>
                </div>

                <script>
                  document.addEventListener("DOMContentLoaded", function() {
                    const productPresence = document.getElementById('productPresence');
                    const productInfo = document.getElementById('productInfo');

                    productPresence.addEventListener('change', function() {
                      if (this.value === 'Ada') {
                        productInfo.style.display = 'block';
                      } else {
                        productInfo.style.display = 'none';
                      }
                    });
                  });
                </script>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>

              <!-- /.row -->
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="modalkeberadaanproduk" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih Ada/ Tidak Keberadaan Produk barang unggulan/utama di desa/kelurahan (Makanan dan Non Makanan), Jika Ada lanjut mengisi </li>
                      <li>isi form (Makanan dan Non Makanan)dengan produk barang unggulan/utama desa/keluraha </li>
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
              <h3 class="card-title">Keberadaan Pangkalan Minyak Tanah dan LPG</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalpangkalanminyak">
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
              <form action="../../handlers/form_pangkalan_minyak.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan pangkalan/agen/penjual minyak tanah (termasuk penjual minyak tanah keliling)</label>
                    <select name="keberadaan_minyak_tanah" id="keberadaan_minyak_tanah" class="form-control" required>
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_pangkalan_minyak, 'keberadaan_minyak_tanah', 'Keberadaan Pangkalan Minyak Tanah dan LPG');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan pangkalan/agen/penjual LPG (warung, toko, supermarket, penjual gas keliling)</label>
                    <select name="keberadaan_lpg" id="keberadaan_lpg" class="form-control" required>
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_pangkalan_minyak, 'keberadaan_lpg', 'Keberadaan Pangkalan Minyak Tanah dan LPG');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
              <div class="modal fade" id="modalpangkalanminyak" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <ul>
                        <li>Pilih Ada/Tidak Ada Keberadaan pangkalan/agen/penjual minyak tanah (termasuk penjual minyak tanah keliling)</li>
                        <li>Pilih Ada/Tidak Ada Keberadaan pangkalan/agen/penjual LPG (warung, toko, supermarket, penjual gas keliling)</li>
                      </ul>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.row -->
            </div>
          </div>

          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Bank Umum Pemerintah, Bank Umum Swasta dan BPR</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalbankumum">
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
              <form action="../../handlers/form_bank_operasi.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Jumlah bank yang beroperasi di desa/kelurahan</label>
                    <p style="margin-left: 20px;">1. Bank Umum Pemerintah (BRI, BNI, Mandiri, BPD, BTN)</p>
                    <input type="number" name="bank_pemerintah" class="form-control mb-3" placeholder=" --- Masukkan jumlah ---" required>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_bank_operasi, 'bank_pemerintah', 'Bank Operasi');
                        ?>
                      </p>
                    <?php endif; ?>
                    <p style="margin-left: 20px;">2. Bank Umum Swasta (BCA, Permata, Sinarmas, CIMB, dll)</p>
                    <input type="number" name="bank_swasta" class="form-control mb-3" placeholder=" --- Masukkan jumlah ---" required>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_bank_operasi, 'bank_swasta', 'Bank Operasi');
                        ?>
                      </p>
                    <?php endif; ?>
                    <p style="margin-left: 20px;">3. Bank Perkreditan Rakyat (BPR)</p>
                    <input type="number" name="bank_bpr" class="form-control mb-3" placeholder=" --- Masukkan jumlah ---" required>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_bank_operasi, 'bank_bpr', 'Bank Operasi');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>

                  <div class="form-group mb-3">
                    <label class="mb-2">Jika tidak ada bank, perkiraan jarak ke bank terdekat</label>
                    <input type="number" name="jarak_bank_terdekat" class="form-control" placeholder=" --- Masukkan jarak ---" step="0.01">
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_bank_operasi, 'jarak_bank_terdekat', 'Bank Operasi');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>

                  <div class="mb-2">
                    <button type="submit" class="btn btn-primary mt-3">
                      <i class="fas fa-save"></i> &nbsp; Simpan
                    </button>
                  </div>
              </form>
              <!-- /.row -->
              <!-- Modal Info -->
              <div class="modal fade" id="modalbankumum" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <ul>
                        <li>Isi jumlah bank yang beroperasi di desa/kelurahan </li>
                        <li>1. Masukkan jumlah Bank Umum Pemerintah (BRI, BNI, Mandiri, BPD, BTN)</li>
                        <li>2. Masukkan jumlah Bank Umum Swasta (BCA, Permata, Sinarmas, CIMB, dll)</li>
                        <li>3. Masukkan jumlah Bank Perkreditan Rakyat (BPR)</li>
                        <li>Jika tidak ada bank, isi dengan perkiraan jarak ke bank terdekat</li>
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
        </div>

        <div class="card card-primary card-outline mb-4">
          <div class="card-header mb-3">
            <h3 class="card-title">Koperasi di desa/kelurahan yang masih aktif</h3>
            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalkoperasi">
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
            <form action="../../handlers/form_koperasi.php" method="post">
              <div class="row">
                <div class="form-group mb-3">
                  <label class="mb-2">Jumlah koperasi di desa/kelurahan yang masih aktif</label>
                  <p style="margin-left: 20px;">1. Koperasi Unit Desa (KUD)</p>
                  <input type="number" name="koperasi_kud" class="form-control mb-3" placeholder=" --- Masukkan jumlah ---" required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_koperasi, 'koperasi_kud', 'Koperasi');
                      ?>
                    </p>
                  <?php endif; ?>
                  <p style="margin-left: 20px;">2. Koperasi Industri Kecil dan Kerajinan Rakyat (Kopinkra)/Usaha mikro</p>
                  <input type="number" name="koperasi_kopinkra" class="form-control mb-3" placeholder=" --- Masukkan jumlah ---" required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_koperasi, 'koperasi_kopinkra', 'Koperasi');
                      ?>
                    </p>
                  <?php endif; ?>
                  <p style="margin-left: 20px;">3. Koperasi Simpan Pinjam (KSP/Kospin)</p>
                  <input type="number" name="koperasi_ksp" class="form-control mb-3" placeholder=" --- Masukkan jumlah ---" required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_koperasi, 'koperasi_ksp', 'Koperasi');
                      ?>
                    </p>
                  <?php endif; ?>
                  <p style="margin-left: 20px;">4. Koperasi lainnya</p>
                  <input type="number" name="koperasi_lainnya" class="form-control mb-3" placeholder=" --- Tuliskan Lainnya ---" required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_koperasi, 'koperasi_lainnya', 'Koperasi');
                      ?>
                    </p>
                  <?php endif; ?>
                </div>

                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan toko/kios yang menjual sarana produksi pertanian</label>
                    <p style="margin-left: 20px;">1. Milik KUD</p>
                    <select name="toko_kud" class="form-control mb-3" required>
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_koperasi, 'toko_kud', 'Koperasi');
                      ?>
                    </p>
                  <?php endif; ?>
                    <p style="margin-left: 20px;">2. Milik BUM Desa</p>
                    <select name="toko_bumdesa" class="form-control mb-3" required>
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_koperasi, 'toko_bumdesa', 'Koperasi');
                      ?>
                    </p>
                  <?php endif; ?>
                    <p style="margin-left: 20px;">3. Selain milik KUD/BUM Desa</p>
                    <select name="toko_lainnya" class="form-control mb-3" required>
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_koperasi, 'toko_lainnya', 'Koperasi');
                      ?>
                    </p>
                  <?php endif; ?>
                  </div>

                  <div class="mb-2">
                    <button type="submit" class="btn btn-primary mt-3">
                      <i class="fas fa-save"></i> &nbsp; Simpan
                    </button>
                  </div>
            </form>
            <!-- /.row -->
            <!-- Modal Info -->
            <div class="modal fade" id="modalkoperasi" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>jumlah koperasi di desa/kelurahan yang masih aktif, diisikan sesuai jenis koperasi</li>
                      <li>1. isi jumlah Koperasi Unit Desa (KUD)</li>
                      <li>2. isi jumlah Koperasi Industri Kecil dan Kerajinan Rakyat (Kopinkra)/Usaha mikro</li>
                      <li>3. isi jumlah Koperasi Simpan Pinjam (KSP/Kospin)</li>
                      <li>4. isi dengan menuliskan koperasi lainnya </li>
                      <li>isi Keberadaan toko/kios yang menjual sarana produksi pertanian (benih, pupuk, pestisida, cangkul, dll.) di desa/kelurahan</li>
                      <li>1. Pilih Ada/Tidak Ada Milik KUD</li>
                      <li>2. Pilih Ada/Tidak Ada Milik BUM Desa</li>
                      <li>3. Pilih Ada/Tidak Ada Selain milik KUD/BUM Desa</li>
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
      </div>
  </div>

  <div class="card card-primary card-outline mb-4">
    <div class="card-header mb-3">
      <h3 class="card-title">Keberadaan sarana penunjang ekonomi di desa/kelurahan</h3>
      <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalsaranapenunjang">
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
      <form action="../../handlers/form_sarana_ekonomi.php" method="post">
        <div class="row">
          <div class="col-12 mb-3">
            <table class="table">
              <thead>
                <tr>
                  <th>Jenis Sarana Penunjang Ekonomi</th>
                  <th>Jumlah Sarana</th>
                  <th>Jarak (km)</th>
                  <th>Kemudahan untuk Mencapai</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Baitul Maal Wa Tamwil (BMT)</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'bmt_jumlah', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td><input type="text" name="bmt_jarak" class="form-control" placeholder=" --- Masukkan jarak --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'bmt_jarak', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control" required>
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'bmt_kemudahan', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <td>Anjungan Tunai Mandiri (ATM)</td>
                  <td><input type="number" name="atm_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'atm_jumlah', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td><input type="text" name="atm_jarak" class="form-control" placeholder=" --- Masukkan jarak --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'atm_jarak', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="atm_kemudahan" class="form-control" required>
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'atm_kemudahan', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <td>Agen Bank</td>
                  <td><input type="number" name="agen_bank_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'agen_bank_jumlah', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td><input type="text" name="agen_bank_jarak" class="form-control" placeholder=" --- Masukkan jarak --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'agen_bank_jarak', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="agen_bank_kemudahan" class="form-control" required>
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'agen_bank_kemudahan', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <td>Pedagang Valuta Asing</td>
                  <td><input type="number" name="valas_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'valas_jumlah', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td><input type="text" name="valas_jarak" class="form-control" placeholder=" --- Masukkan jarak --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'valas_jarak', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="valas_kemudahan" class="form-control" required>
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'valas_kemudahan', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <td>Pergadaian</td>
                  <td><input type="number" name="pegadaian_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'pegadaian_jumlah', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td><input type="text" name="pegadaian_jarak" class="form-control" placeholder=" --- Masukkan jarak --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'pegadaian_jarak', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="pegadaian_kemudahan" class="form-control" required>
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'pegadaian_kemudahan', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <td>Agen Tiket/Travel/Biro Perjalanan</td>
                  <td><input type="number" name="agen_tiket_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'agen_tiket_jumlah', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td><input type="text" name="agen_tiket_jarak" class="form-control" placeholder=" --- Masukkan jarak --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'agen_tiket_jarak', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="agen_tiket_kemudahan" class="form-control" required>
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'agen_tiket_kemudahan', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <td>Bengkel Mobil/Motor</td>
                  <td><input type="number" name="bengkel_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'bengkel_jumlah', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td><input type="text" name="bengkel_jarak" class="form-control" placeholder=" --- Masukkan jarak --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'bengkel_jarak', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="bengkel_kemudahan" class="form-control" required>
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'bengkel_kemudahan', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <td>Salon Kecantikan</td>
                  <td><input type="number" name="salon_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'salon_jumlah', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td><input type="text" name="salon_jarak" class="form-control" placeholder=" --- Masukkan jarak --- " required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'salon_jarak', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="salon_kemudahan" class="form-control" required>
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_ekonomi, 'salon_kemudahan', 'Sarana Ekonomi');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> &nbsp; Simpan
        </button>
      </form>


      <!-- /.row -->
      <!-- Modal Info -->
      <div class="modal fade" id="modalsaranapenunjang" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <ul>
                <li>Keberadaan sarana penunjang ekonomi di desa/kelurahan</li>
                <li>isi jenis sarana penunjang ekonomi</li>
                <li>isi jumlah sarana</li>
                <li>isi Jarak (km)</li>
                <li>Pilih kemudahan untuk mencapai </li>
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

  <!-- End Form-->

  <div class="card card-primary card-outline mb-4">
    <div class="card-header mb-3">
      <h3 class="card-title">Sarana dan prasarana ekonomi di desa/kelurahan</h3>
      <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalsaranaprasarana">
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
      <form action="../../handlers/form_sarana_prasarana.php" method="post">
        <div class="row">
          <div class="col-12 mb-3">
            <table class="table">
              <thead>
                <tr>
                  <th>Jenis Sarana dan Prasarana Ekonomi</th>
                  <th>Jumlah Sarana</th>
                  <th>Kemudahan untuk Mencapai</th>
                </tr>
              </thead>
              <tbody>
                <!-- Kelompok pertokoan -->
                <tr>
                  <td>Kelompok pertokoan</td>
                  <td><input type="number" name="kelompok_pertokoan_jumlah" class="form-control" min="0" placeholder="--- Masukkan jumlah ---" required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'kelompok_pertokoan_jumlah', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="kelompok_pertokoan_kemudahan" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'kelompok_pertokoan_kemudahan', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
                <!-- Pasar permanen -->
                <tr>
                  <td>Pasar dengan bangunan permanen</td>
                  <td><input type="number" name="pasar_permanen_jumlah" class="form-control" min="0" placeholder="--- Masukkan jumlah ---" required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'pasar_permanen_jumlah', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="pasar_permanen_kemudahan" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'pasar_permanen_kemudahan', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?>  
                  </td>
                </tr>
                <!-- Pasar semi permanen -->
                <tr>
                  <td>Pasar dengan bangunan semi permanen</td>
                  <td><input type="number" name="pasar_semi_permanen_jumlah" class="form-control" min="0" placeholder="--- Masukkan jumlah ---" required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'pasar_semi_permanen_jumlah', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="pasar_semi_permanen_kemudahan" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'pasar_semi_permanen_kemudahan', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
                <!-- Pasar tanpa bangunan -->
                <tr>
                  <td>Pasar tanpa bangunan</td>
                  <td><input type="number" name="pasar_tanpa_bangunan_jumlah" class="form-control" min="0" placeholder="--- Masukkan jumlah ---" required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'pasar_tanpa_bangunan_jumlah', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="pasar_tanpa_bangunan_kemudahan" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'pasar_tanpa_bangunan_kemudahan', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
                <!-- Minimarket -->
                <tr>
                  <td>Minimarket/swalayan/supermarket</td>
                  <td><input type="number" name="minimarket_jumlah" class="form-control" min="0" placeholder="--- Masukkan jumlah ---" required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'minimarket_jumlah', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="minimarket_kemudahan" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'minimarket_kemudahan', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
                <!-- Restoran -->
                <tr>
                  <td>Restoran/rumah makan</td>
                  <td><input type="number" name="restoran_jumlah" class="form-control" min="0" placeholder="--- Masukkan jumlah ---" required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'restoran_jumlah', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="restoran_kemudahan" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'restoran_kemudahan', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
                <!-- Warung makan -->
                <tr>
                  <td>Warung/kedai makanan minuman</td>
                  <td><input type="number" name="warung_makan_jumlah" class="form-control" min="0" placeholder="--- Masukkan jumlah ---" required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'warung_makan_jumlah', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="warung_makan_kemudahan" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'warung_makan_kemudahan', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
                <!-- Toko kelontong -->
                <tr>
                  <td>Toko/warung kelontong</td>
                  <td><input type="number" name="toko_kelontong_jumlah" class="form-control" min="0" placeholder="--- Masukkan jumlah ---" required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'toko_kelontong_jumlah', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="toko_kelontong_kemudahan" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'toko_kelontong_kemudahan', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
                <!-- Hotel -->
                <tr>
                  <td>Hotel</td>
                  <td><input type="number" name="hotel_jumlah" class="form-control" min="0" placeholder="--- Masukkan jumlah ---" required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'hotel_jumlah', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="hotel_kemudahan" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'hotel_kemudahan', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
                <!-- Penginapan -->
                <tr>
                  <td>Penginapan (hostel/motel/losmen/wisma)</td>
                  <td><input type="number" name="penginapan_jumlah" class="form-control" min="0" placeholder="--- Masukkan jumlah ---" required>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'penginapan_jumlah', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?></td>
                  <td>
                    <select name="penginapan_kemudahan" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Sangat Mudah">Sangat Mudah</option>
                      <option value="Mudah">Mudah</option>
                      <option value="Sulit">Sulit</option>
                      <option value="Sangat Sulit">Sangat Sulit</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sarana_prasarana, 'penginapan_kemudahan', 'Sarana Prasarana');
                      ?>
                    </p>
                  <?php endif; ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> &nbsp; Simpan
        </button>
      </form>
      <!-- /.row -->
      <!-- Modal Info -->
      <div class="modal fade" id="modalsaranaprasarana" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <ul>
                <li>Sarana dan Prasarana Ekonomi di Desa/Kelurahan</li>
                <li>Isi jumlah sarana:</li>
                <ul>
                  <li>Kolom <b>Jumlah Sarana</b> wajib diisi dengan angka. Gunakan angka 0 jika jenis sarana tidak tersedia.</li>
                  <li>Angka harus berupa bilangan bulat tanpa desimal.</li>
                </ul>
                <li>Pilih tingkat kemudahan untuk mencapai lokasi sarana:</li>
                <ul>
                  <li><b>Sangat Mudah:</b> Tidak ada hambatan untuk mencapai lokasi sarana tersebut.</li>
                  <li><b>Mudah:</b> Ada hambatan kecil, tetapi dapat dicapai dengan usaha minimal.</li>
                  <li><b>Sulit:</b> Hambatan cukup besar, membutuhkan usaha lebih untuk mencapai lokasi.</li>
                  <li><b>Sangat Sulit:</b> Hambatan sangat besar, sulit untuk diakses.</li>
                </ul>
                <li>Jenis Sarana dan Prasarana yang Diisi:</li>
                <ul>
                  <li><b>Kelompok Pertokoan:</b> Sekumpulan minimal 10 toko dalam satu lokasi.</li>
                  <li><b>Pasar Permanen:</b> Pasar dengan bangunan lengkap (atap, lantai, dinding).</li>
                  <li><b>Pasar Semi Permanen:</b> Pasar dengan atap dan lantai, tetapi tanpa dinding.</li>
                  <li><b>Pasar Tanpa Bangunan:</b> Pasar tradisional seperti pasar subuh atau terapung.</li>
                  <li><b>Minimarket/Swalayan/Supermarket:</b> Bangunan permanen untuk menjual barang eceran dengan sistem harga tetap dan pelayanan mandiri.</li>
                  <li><b>Restoran/Rumah Makan:</b> Tempat makan dengan fasilitas tetap dan biasanya dikenakan pajak.</li>
                  <li><b>Warung/Kedai Makanan Minuman:</b> Tempat makan kecil tanpa fasilitas formal atau pajak.</li>
                  <li><b>Toko/Warung Kelontong:</b> Tempat usaha untuk menjual barang sehari-hari tanpa sistem pelayanan mandiri.</li>
                  <li><b>Hotel:</b> Bangunan penginapan resmi dengan izin sebagai hotel.</li>
                  <li><b>Penginapan:</b> Hostel, motel, losmen, atau wisma tanpa izin usaha sebagai hotel.</li>
                </ul>
                <li>Kewajiban Pengisian:</li>
                <ul>
                  <li>Semua kolom <b>Jumlah Sarana</b> dan <b>Kemudahan</b> harus diisi.</li>
                  <li>Pastikan dropdown tidak berada pada posisi default (<b>--- Pilih ---</b>).</li>
                </ul>
                <li>Validasi Data: Sistem akan memeriksa pengisian dan memberikan peringatan jika ada kesalahan atau data yang belum diisi.</li>
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