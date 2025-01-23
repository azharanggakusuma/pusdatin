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

// Ambil data sebelumnya
$previous_batas_desa = getPreviousYearData($conn, $user_id, $desa_id, 'tb_batas_desa', ['batas_utara', 'kec_utara', 'batas_selatan', 'kec_selatan', 'batas_timur', 'kec_timur', 'batas_barat', 'kec_barat	'], 'Batas Wilayah Desa', $tahun);
$previous_jarak_kantor_desa = getPreviousYearData($conn, $user_id, $desa_id, 'tb_jarak_kantor_desa', ['jarak_ke_ibukota_kecamatan', 'jarak_ke_ibukota_kabupaten'], 'Jarak Kantor Desa ke Ibukota Kecamatan dan Ibukota Kabupaten/Kota', $tahun);
$previous_idm_status = getPreviousYearData($conn, $user_id, $desa_id, 'tb_idm_status', ['status_idm'], 'Status Indeks Desa Membangun (IDM)', $tahun);

// tb_website_medsos
$previous_website_medsos = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_website_medsos',
  ['alamat_website', 'alamat_email', 'alamat_facebook', 'alamat_twitter', 'alamat_youtube'],
  'Ketersediaan Alamat website dan media sosial Desa/Kelurahan yang dimiliki',
  $tahun
);

// tb_status_pemerintahan
$previous_status_pemerintahan = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_status_pemerintahan',
  ['status_pemerintahan'],
  'Status Pemerintahan Desa',
  $tahun
);

// tb_ketersediaan_penetapan_peta_desa
$previous_ketersediaan_peta_desa = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_ketersediaan_penetapan_peta_desa',
  ['penetapan_batas_desa', 'no_surat_batas_desa', 'ketersediaan_peta_desa', 'no_surat_peta_desa'],
  'Ketersediaan dan Penetapan Peta Desa',
  $tahun
);

// tb_banyaknya_dusun_rt_rw
$previous_banyaknya_dusun_rt_rw = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_banyaknya_dusun_rt_rw',
  ['jumlah_dusun', 'jumlah_rw', 'jumlah_rt'],
  'Banyaknya Dusun, RT, dan RW',
  $tahun
);

// tb_luas_wilayah_desa
$previous_luas_wilayah_desa = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_luas_wilayah_desa',
  ['luas_wilayah_desa'],
  'Luas Wilayah Desa',
  $tahun
);

// tb_topografi_terluas_wilayah_desa
$previous_topografi_wilayah_desa = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_topografi_terluas_wilayah_desa',
  ['topografi_terluas_wilayah_desa'],
  'Topografi Terluas Wilayah Desa',
  $tahun
);

// tb_kepemilikan_kantor
$previous_kepemilikan_kantor = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_kepemilikan_kantor',
  ['keberadaan_kantor', 'status_kantor', 'kondisi_kantor', 'lokasi_kantor'],
  'Kepemilikan Kantor',
  $tahun
);

// tb_titik_koordinat_kantor_desa
$previous_titik_koordinat_kantor_desa = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_titik_koordinat_kantor_desa',
  ['koordinat_lintang', 'koordinat_bujur'],
  'Titik Koordinat Kantor Desa',
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
            window.location.href = "keterangan_umum_desa_kelurahan.php";
          });
        } else if (status === 'error') {
          Swal.fire({
            title: "Gagal!",
            text: "Terjadi kesalahan saat menambahkan data.",
            icon: "error",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "keterangan_umum_desa_kelurahan.php";
          });
        } else if (status === 'warning') {
          Swal.fire({
            title: "Peringatan!",
            text: "Mohon lengkapi semua data.",
            icon: "warning",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "keterangan_umum_desa_kelurahan.php";
          });
        }
      </script>
    <?php endif; ?>

    <main class="app-main"> <!--begin::App Content Header-->
      <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Keterangan Umum Desa Kelurahan</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Keterangan Umum Desa Kelurahan
                </li>
              </ol>
            </div>
          </div> <!--end::Row-->
        </div> <!--end::Container-->
      </div> <!--end::App Content Header--> <!--begin::App Content-->
      <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->

          <!-- Template Form -->

          <!-- BEGIN::CONTAINER BATAS WILAYAH DESA -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Batas Wilayah Desa</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalBatasDesa">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool BATASWILAYAH">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <form id="batasDesaForm" method="post" action="../../handlers/form_batas_desa.php">
                <div class="row">
                  <!-- Sebelah Utara -->
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label for="batas_utara" class="mb-2">Sebelah Utara</label>
                      <input required type="text" id="batas_utara" name="batas_utara" class="form-control"
                        placeholder="Masukkan nama desa">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_batas_desa, 'batas_utara', 'Batas Wilayah Desa');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label for="kec_utara" class="mb-2">Kecamatan</label>
                      <input required type="text" id="kec_utara" name="kec_utara" class="form-control"
                        placeholder="Masukkan nama kecamatan">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_batas_desa, 'kec_utara', 'Batas Wilayah Desa');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <!-- Sebelah Selatan -->
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label for="batas_selatan" class="mb-2">Sebelah Selatan</label>
                      <input required type="text" id="batas_selatan" name="batas_selatan" class="form-control"
                        placeholder="Masukkan nama desa">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_batas_desa, 'batas_selatan', 'Batas Wilayah Desa');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label for="kec_selatan" class="mb-2">Kecamatan</label>
                      <input required type="text" id="kec_selatan" name="kec_selatan" class="form-control"
                        placeholder="Masukkan nama kecamatan">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_batas_desa, 'kec_selatan', 'Batas Wilayah Desa');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <!-- Sebelah Timur -->
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label for="batas_timur" class="mb-2">Sebelah Timur</label>
                      <input required type="text" id="batas_timur" name="batas_timur" class="form-control"
                        placeholder="Masukkan nama desa">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_batas_desa, 'batas_timur', 'Batas Wilayah Desa');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label for="kec_timur" class="mb-2">Kecamatan</label>
                      <input required type="text" id="kec_timur" name="kec_timur" class="form-control"
                        placeholder="Masukkan nama kecamatan">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_batas_desa, 'kec_timur', 'Batas Wilayah Desa');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>

                  <!-- Sebelah Barat -->
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label for="batas_barat" class="mb-2">Sebelah Barat</label>
                      <input required type="text" id="batas_barat" name="batas_barat" class="form-control"
                        placeholder="Masukkan nama desa">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_batas_desa, 'batas_barat', 'Batas Wilayah Desa');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label for="kec_barat" class="mb-2">Kecamatan</label>
                      <input required type="text" id="kec_barat" name="kec_barat" class="form-control"
                        placeholder="Masukkan nama kecamatan">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_batas_desa, 'kec_utara', 'Batas Wilayah Desa');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
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
            <div class="modal fade" id="modalBatasDesa" tabindex="-1" aria-labelledby="aturanModalLabel"
              aria-hidden="true">
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
            <script>
              $(document).ready(function() {
                $(".BATASWILAYAH").on("click", function() {
                  var $icon = $(this).find("i");
                  var $cardBody = $(this).closest(".card").find(".card-body");

                  $cardBody.slideToggle();
                  $icon.toggleClass("fa-minus fa-plus");
                });
              });
            </script>
          </div>
          <!-- END:: CONTAINER BATAS WILAYAH DESA -->

          <!-- BEGIN::CONTAINER JARAK KANTOR DESA -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Jarak Kantor Desa</h3>
              <!-- Aturan Pengisian Button -->
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalJarakKantorDesa">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool JARAKKANTOR">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".JARAKKANTOR").on("click", function() {
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
              <form action="../../handlers/form_jarak_kantor_desa.php" method="post">
                <div class="row">
                  <!-- Jarak ke Ibukota Kecamatan -->
                  <div class="form-group mb-3">
                    <label class="mb-2">Jarak ke Ibukota Kecamatan (km)</label>
                    <input required type="text" id="jarak_ke_ibukota_kecamatan" name="jarak_ke_ibukota_kecamatan"
                      class="form-control" placeholder="Masukkan jarak" style="width: 100%;">
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_jarak_kantor_desa, 'jarak_ke_ibukota_kecamatan', 'Jarak Kantor Desa ke Ibukota Kecamatan dan Ibukota Kabupaten/Kota');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>

                  <!-- Jarak ke Ibukota Kabupaten/Kota -->
                  <div class="form-group mb-3">
                    <label class="mb-2">Jarak ke Ibukota Kabupaten/Kota (km)</label>
                    <input required type="text" id="jarak_ke_ibukota_kabupaten" name="jarak_ke_ibukota_kabupaten"
                      class="form-control" placeholder="Masukkan jarak" style="width: 100%;">
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_jarak_kantor_desa, 'jarak_ke_ibukota_kabupaten', 'Jarak Kantor Desa ke Ibukota Kecamatan dan Ibukota Kabupaten/Kota');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>

                  <!-- Checkbox untuk menggunakan data tahun sebelumnya -->

                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>
            <!-- Modal Info -->
            <div class="modal fade" id="modalJarakKantorDesa" tabindex="-1" aria-labelledby="aturanModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Masukkan jarak dalam satuan kilometer (km) menggunakan angka desimal jika diperlukan (contoh:
                        12.5).</li>
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
          <!-- END::JARAK KANTOR DESA -->

          <!-- BEGIN::PERKEMBANGAN IDM -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Perkembangan Status Indeks Desa Membangun (IDM)</h3>
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
                        <li>Pilih Status Desa Membangun Pada Tahun</li>
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
                <button type="button" class="btn btn-tool IDM">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".IDM").on("click", function() {
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

              <form action="../../handlers/form_idm_status.php" method="post">
                <div class="mb-3">
                  <label class="mb-2">Status Desa Membangun (Mandiri/Maju/Berkembang/Tertinggal/Sangat Tertinggal)
                    2024</label>
                  <select required name="status_2024" id="" class="form-control">
                    <option value="" disabled selected>-- Pilih Status Desa Membangun 2024 --</option>
                    <option value="MANDIRI">MANDIRI</option>
                    <option value="MAJU">MAJU</option>
                    <option value="BERKEMBANG">BERKEMBANG</option>
                    <option value="TERTINGGAL">TERTINGGAL</option>
                    <option value="SANGAT TERTINGGAL">SANGAT TERTINGGAL</option>
                  </select>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_idm_status, 'status_idm', 'Status Indeks Desa Membangun (IDM)');
                      ?>
                    </p>
                  <?php endif; ?>
                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div> <!--end::Footer-->
              </form>
              <!-- /.row -->
            </div>
          </div> <!--end::Container-->
          <!-- END:: PERKEMBANGAN IDM -->

          <!-- BEGIN:: ALAMAT WEBSITE -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Alamat Website dan Media Sosial</h3>
              <!-- BEGIN:: INFO BUTTON -->
              <!-- Aturan Pengisian Button -->
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#alamatWebsite">
                <i class="fas fa-info-circle"></i>
              </button>
              <!-- Modal Info -->
              <div class="modal fade" id="alamatWebsite" tabindex="-1" aria-labelledby="aturanModalLabel"
                aria-hidden="true">
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

              <form action="../../handlers/form_alamat_website_medsos.php" method="post">
                <div class="form-group mb-3">
                  <label class="mb-2">Alamat Website Desa</label>
                  <input required type="text" name="alamat_website" class="form-control" placeholder="Masukkan alamat website">
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_website_medsos, 'alamat_website', 'Ketersediaan Alamat website dan media sosial Desa/Kelurahan yang dimiliki');
                      ?>
                    </p>
                  <?php endif; ?>
                </div>
                <div class="form-group mb-3">
                  <label class="mb-2">Alamat Email Desa</label>
                  <input required type="email" name="alamat_email" class="form-control" placeholder="Masukkan alamat email">
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_website_medsos, 'alamat_email', 'Ketersediaan Alamat website dan media sosial Desa/Kelurahan yang dimiliki');
                      ?>
                    </p>
                  <?php endif; ?>
                </div>
                <div class="form-group mb-3">
                  <label class="mb-2">Alamat Facebook Desa</label>
                  <input required type="text" name="alamat_facebook" class="form-control" placeholder="Masukkan alamat Facebook">
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_website_medsos, 'alamat_facebook', 'Ketersediaan Alamat website dan media sosial Desa/Kelurahan yang dimiliki');
                      ?>
                    </p>
                  <?php endif; ?>
                </div>
                <div class="form-group mb-3">
                  <label class="mb-2">Alamat Twitter Desa</label>
                  <input required type="text" name="alamat_twitter" class="form-control" placeholder="Masukkan alamat Twitter">
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_website_medsos, 'alamat_twitter', 'Ketersediaan Alamat website dan media sosial Desa/Kelurahan yang dimiliki');
                      ?>
                    </p>
                  <?php endif; ?>
                </div>
                <div class="form-group mb-3">
                  <label class="mb-2">Alamat YouTube Desa</label>
                  <input required type="text" name="alamat_youtube" class="form-control" placeholder="Masukkan alamat YouTube">
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_website_medsos, 'alamat_youtube', 'Ketersediaan Alamat website dan media sosial Desa/Kelurahan yang dimiliki');
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
            </div>
          </div> <!--end::Container-->
          <!-- END:: ALAMAT WEBSITE -->

          <!-- BEGIN::Status Pemerintahan Desa dan Klasifikasi Berdasarkan Tingkat Perkembangannya -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Status Pemerintahan Desa dan Klasifikasi Berdasarkan Tingkat Perkembangannya</h3>
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
                        <li>Pilih Status Desa Membangun Pada Tahun</li>
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
                <button type="button" class="btn btn-tool STATUSPEMERINTAHAN">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".STATUSPEMERINTAHAN").on("click", function() {
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

              <form action="../../handlers/form_status_pemerintahan.php" method="post">
                <div class="mb-3">
                  <label class="mb-2">Status Pemerintahan (Desa/Kelurahan/Kampung/Nagari/Gampong)</label>
                  <select name="status_2024" id="" class="form-control">
                    <option value="" disabled selected>-- Pilih Status Pemerintahan --</option>
                    <option value="DESA">DESA</option>
                    <option value="KELURAHAN">KELURAHAN</option>
                    <option value="KAMPUNG">KAMPUNG</option>
                    <option value="NAGARI">NAGARI</option>
                    <option value="GAMPONG">GAMPONG</option>
                  </select>
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_status_pemerintahan, 'status_pemerintahan', 'status_pemerintahan Desa');
                      ?>
                    </p>
                  <?php endif; ?>
                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div> <!--end::Footer-->
              </form>
              <!-- /.row -->
            </div>
          </div> <!--end::Container-->
          <!-- END:: Status Pemerintahan Desa dan Klasifikasi Berdasarkan Tingkat Perkembangannya -->

          <!-- BEGIN::Ketersediaan Penetapan Batas dan Peta Desa -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Ketersediaan Penetapan Batas dan Peta Desa</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#PenetapanBatasDesa">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="modal fade" id="PenetapanBatasDesa" tabindex="-1" aria-labelledby="aturanModalLabel"
                aria-hidden="true">
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

              <form action="../../handlers/form_ketersediaan_batas_peta.php" method="post">
                <div class="row">
                  <!-- Penetapan Batas Desa -->
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label class="mb-2">Penetapan Batas Desa</label>
                      <select name="penetapan_batas_desa" id="penetapan_batas_desa" class="form-control" onchange="toggleInputFields()" required>
                        <option value="" disabled selected>-- Pilih Penetapan Batas Desa --</option>
                        <option value="SUDAH ADA">SUDAH ADA</option>
                        <option value="BELUM ADA">BELUM ADA</option>
                      </select>
                      <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_status_pemerintahan, 'status_pemerintahan', 'status_pemerintahan Desa');
                      ?>
                    </p>
                  <?php endif; ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mb-3" id="form_no_surat_batas_desa" style="display: none;">
                      <label class="mb-2">No SK/Perbup/Perda/Perdes tentang Penetapan Batas Desa</label>
                      <input required type="text" name="no_surat_batas_desa" id="no_surat_batas_desa" class="form-control" placeholder="Masukkan No Peraturan">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <!-- Ketersediaan Peta Desa -->
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label class="mb-2">Ketersediaan Peta Desa</label>
                      <select name="ketersediaan_peta_desa" id="ketersediaan_peta_desa" class="form-control" onchange="toggleInputFields()" required>
                        <option value="" disabled selected>-- Pilih Ketersediaan Peta Desa --</option>
                        <option value="ADA">ADA</option>
                        <option value="TIDAK ADA">TIDAK ADA</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mb-3" id="form_no_surat_peta_desa" style="display: none;">
                      <label class="mb-2">No SK/Perbup/Perda tentang Peta Desa</label>
                      <input required type="text" name="no_surat_peta_desa" id="no_surat_peta_desa" class="form-control" placeholder="Masukkan No Peraturan">
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
                function toggleInputFields() {
                  // Toggle for Penetapan Batas Desa
                  const batasDesaSelect = document.getElementById('penetapan_batas_desa');
                  const batasDesaInput = document.getElementById('form_no_surat_batas_desa');
                  if (batasDesaSelect.value === 'SUDAH ADA') {
                    batasDesaInput.style.display = 'block';
                  } else {
                    batasDesaInput.style.display = 'none';
                  }

                  // Toggle for Ketersediaan Peta Desa
                  const petaDesaSelect = document.getElementById('ketersediaan_peta_desa');
                  const petaDesaInput = document.getElementById('form_no_surat_peta_desa');
                  if (petaDesaSelect.value === 'ADA') {
                    petaDesaInput.style.display = 'block';
                  } else {
                    petaDesaInput.style.display = 'none';
                  }
                }
              </script>

            </div>
          </div>
          <!-- END::Ketersediaan Penetapan Batas dan Peta Desa -->

          <!-- BEGIN::BANYAKNYA DUSUN -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Banyaknya Dusun, Rukun Tetangga dan Rukun Warga</h3>
              <!-- BEGIN:: INFO BUTTON -->
              <!-- Aturan Pengisian Button -->
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#aturanModalDesa">
                <i class="fas fa-info-circle"></i>
              </button>
              <!-- Modal Info -->
              <div class="modal fade" id="aturanModalDesa" tabindex="-1" aria-labelledby="aturanModalLabel"
                aria-hidden="true">
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
                <button type="button" class="btn btn-tool BANYAKDUSUN">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".BANYAKDUSUN").on("click", function() {
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

              <form action="../../handlers/form_banyaknya_dusun_rt_rw.php" method="post">
                <div class="row">
                  <!-- /.col -->
                  <div>
                    <!-- /.form-group -->
                    <div class="form-group mb-3">
                      <label class="mb-2">Jumlah Dusun/Lingkungan/Sebutan Lain yang sejenis</label>
                      <input required type="number" name="jumlah_dusun" class="form-control" placeholder="Masukkan angka/jumlah"
                        min="0" step="1" style="width: 100%;">
                    </div>
                  </div>
                  <!-- /.col -->
                  <div>
                    <!-- /.form-group -->
                    <div class="form-group mb-3">
                      <label class="mb-2">Banyaknya RW</label>
                      <input required type="number" name="jumlah_rw" class="form-control" placeholder="Masukkan angka/jumlah"
                        min="0" step="1" style="width: 100%;">
                    </div>
                  </div>
                  <!-- /.col -->
                  <div>
                    <!-- /.form-group -->
                    <div class="form-group mb-3">
                      <label class="mb-2">Banyaknya RT</label>
                      <input required type="number" name="jumlah_rt" class="form-control" placeholder="Masukkan angka/jumlah"
                        min="0" step="1" style="width: 100%;">
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <div class="mb-3">
                  <div class="mb-2">
                    <button type="submit" class="btn btn-primary mt-3">
                      <i class="fas fa-save"></i> &nbsp; Simpan
                    </button>
                  </div>
                </div>
                <!--end::Footer-->
              </form>
              <!-- /.row -->
            </div>
          </div>
          <!-- END::BANYAKNYA DUSUN -->

          <!-- BEGIN::LUAS WILAYAH -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Luas Wilayah Desa/Kelurahan </h3>
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

              <form action="../../handlers/form_luas_wilayah_desa.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Luas Wilayah Desa (Hektar)</label>
                    <input required type="number" id="luas_wilayah_desa" name="luas_wilayah_desa" class="form-control"
                      placeholder="Masukkan luas wilayah dalam hektar" style="width: 100%;" step="0.01" min="0">

                  </div>
                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>
            <div class="modal fade" id="modalLuasDesa" tabindex="-1" aria-labelledby="aturanModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Masukkan luas wilayah desa dalam satuan km2 (1 Ha= 0,01 km2 ) .</li>
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
          <!-- END:LUAS WILAYAH -->

          <!-- BEGIN::TOPOGRAFI TERLUAS -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Topografi Terluas Wilayah Desa</h3>
              <!-- Aturan Pengisian Button -->
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalTopografiTerluas">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool TOPOGRAFI">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".TOPOGRAFI").on("click", function() {
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
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>

              <!-- /.row -->
            </div>
            <!-- Modal Info -->
            <div class="modal fade" id="modalTopografiTerluas" tabindex="-1" aria-labelledby="aturanModalLabel"
              aria-hidden="true">
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
          <!-- END:: TOPOGRAFI TERLUAS -->

          <!-- BEGIN::Keberadaan, status, kondisi, dan lokasi kantor kepala desa/lurah -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Keberadaan, Status, Kondisi, dan Lokasi Kantor Kepala Desa/Lurah</h3>
              <!-- Aturan Pengisian Button -->
              <button type="button" class="btn btn-tool" data-bs-toggle="modal"
                data-bs-target="#modalKepemilikanKantor">
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
              <form action="../../handlers/form_kepemilikan_kantor.php" method="post">
                <div class="row">
                  <!-- KEBERADAAN KANTOR -->
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label class="mb-2">Keberadaan kantor kepala desa/lurah</label>
                      <select name="keberadaan_kantor" id="keberadaan_kantor" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Ada/Tidak Ada --</option>
                        <option value="ADA">ADA</option>
                        <option value="TIDAK ADA">TIDAK ADA</option>
                      </select>
                    </div>
                  </div>

                  <!-- Status Kantor Kepala Desa/Lurah -->
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label class="mb-2">Status Kantor Kepala Desa/Lurah</label>
                      <select name="status_kantor" id="status_kantor" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Aset Desa/Bukan Aset Desa --</option>
                        <option value="ASET DESA">ASET DESA</option>
                        <option value="BUKAN ASET DESA">BUKAN ASET DESA</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <!-- KONDISI KANTOR -->
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label class="mb-2" for="kondisi_kantor">Kondisi Kantor Kepala Desa/Balai Desa</label>
                      <select name="kondisi_kantor" id="kondisi_kantor" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Kondisi Kantor Kepala Desa --</option>
                        <option value="ADA, LAYAK">ADA, LAYAK</option>
                        <option value="ADA, TIDAK LAYAK">ADA, TIDAK LAYAK</option>
                        <option value="TIDAK ADA">TIDAK ADA</option>
                      </select>
                    </div>
                  </div>

                  <!-- Lokasi kantor kepala desa/lurah -->
                  <div class="col-md-6">
                    <div class="form-group mb-3">
                      <label class="mb-2" for="lokasi_kantor">Lokasi Kantor Kepala Desa/Lurah</label>
                      <select name="lokasi_kantor" id="lokasi_kantor" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Lokasi Kantor Kepala Desa --</option>
                        <option value="Di dalam wilayah desa/kelurahan">Di dalam wilayah desa/kelurahan</option>
                        <option value="Di Luar Wilayah Desa/Kelurahan">Di Luar Wilayah Desa/Kelurahan</option>
                      </select>
                    </div>
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
            <div class="modal fade" id="modalKepemilikanKantor" tabindex="-1" aria-labelledby="aturanModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih salah satu dari pilihan yang tersedia sesuai dengan kondisi kantor kepala desa/lurah
                        Anda.</li>
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

          <!-- END::Keberadaan, status, kondisi, dan lokasi kantor kepala desa/lurah -->

          <!-- BEGIN::TITIK KOORDINAT -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Titik Koordinat Kantor Desa</h3>
              <!-- Aturan Pengisian Button -->
              <button type="button" class="btn btn-tool" data-bs-toggle="modal"
                data-bs-target="#modalTitikKoordinatKantorDesa">
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

              <form action="../../handlers/form_titik_koordinat_kantor_desa.php" method="post">
                <div class="row"> <!-- /.col -->
                  <!-- /.form-group -->
                  <div class="form-group mb-3">
                    <label class="mb-2">Koordinat Lintang (Latitude)</label>
                    <input required type="text" class="form-control" name="koordinat_lintang"
                      placeholder="Masukkan koordinat lintang" style="width: 100%;">
                  </div>

                  <div class="form-group mb-3">
                    <label class="mb-2">Koordinat Bujur (Longitude)</label>
                    <input required type="text" class="form-control" name="koordinat_bujur"
                      placeholder="Masukkan koordinat bujur" style="width: 100%;">
                  </div>
                  <div class="mb-3">
                    <div class="mb-2">
                      <button type="submit" class="btn btn-primary mt-3">
                        <i class="fas fa-save"></i> &nbsp; Simpan
                      </button>
                    </div>
                  </div> <!--end::Footer-->
              </form>
              <!-- /.row -->
            </div>
            <!-- Modal Info -->
            <div class="modal fade" id="modalTitikKoordinatKantorDesa" tabindex="-1" aria-labelledby="aturanModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Masukkan koordinat dalam format derajat desimal (contoh: -6.8796 untuk Lintang Selatan,
                        108.5538 untuk
                        Bujur Timur).</li>
                      <li>Gunakan tanda minus (-) untuk koordinat di belahan selatan (LS) atau barat (BB).</li>
                      <li>Pastikan nilai lintang berada dalam rentang -90 hingga 90, dan bujur berada dalam rentang -180
                        hingga
                        180.</li>
                      <li>Periksa keakuratan data sesuai dengan titik lokasi kantor desa menggunakan aplikasi peta
                        seperti Google
                        Maps.</li>
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
          <!-- END::TITIK KOOREDINAT -->


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