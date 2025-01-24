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
$previous_batas_desa = getPreviousYearData($conn, $user_id, $desa_id, 'tb_batas_desa', ['batas_utara', 'kec_utara', 'batas_selatan', 'kec_selatan', 'batas_timur', 'kec_timur', 'batas_barat', 'kec_barat'], 'Batas Wilayah Desa', $tahun);
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
  'tb_ketersediaan_batas_peta',
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
  'Banyaknya Dusun, Rukun Tetangga dan Rukun Warga',
  $tahun
);

// tb_luas_wilayah_desa
$previous_luas_wilayah_desa = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_luas_wilayah_desa',
  ['luas_wilayah_desa'],
  'Luas Wilayah Desa/Kelurahan',
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
  'Keberadaan, Status, Kondisi, dan Lokasi Kantor Kepala Desa/Lurah',
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
                          echo displayPreviousYearData($previous_batas_desa, 'kec_barat', 'Batas Wilayah Desa');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <?php if ($level != 'admin'): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3 mt-2">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_batas_desa" name="use_previous_batas_desa" value="1">
                      <label class="form-check-label" for="use_previous_batas_desa">
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
                document.addEventListener("DOMContentLoaded", function() {
                  // Ambil semua input field batas desa
                  const batasUtara = document.getElementById("batas_utara");
                  const kecUtara = document.getElementById("kec_utara");
                  const batasSelatan = document.getElementById("batas_selatan");
                  const kecSelatan = document.getElementById("kec_selatan");
                  const batasTimur = document.getElementById("batas_timur");
                  const kecTimur = document.getElementById("kec_timur");
                  const batasBarat = document.getElementById("batas_barat");
                  const kecBarat = document.getElementById("kec_barat");

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_batas_desa");

                  // Data tahun sebelumnya
                  const previousData = {
                    batasUtara: "<?php echo htmlspecialchars($previous_batas_desa['batas_utara'] ?? ''); ?>",
                    kecUtara: "<?php echo htmlspecialchars($previous_batas_desa['kec_utara'] ?? ''); ?>",
                    batasSelatan: "<?php echo htmlspecialchars($previous_batas_desa['batas_selatan'] ?? ''); ?>",
                    kecSelatan: "<?php echo htmlspecialchars($previous_batas_desa['kec_selatan'] ?? ''); ?>",
                    batasTimur: "<?php echo htmlspecialchars($previous_batas_desa['batas_timur'] ?? ''); ?>",
                    kecTimur: "<?php echo htmlspecialchars($previous_batas_desa['kec_timur'] ?? ''); ?>",
                    batasBarat: "<?php echo htmlspecialchars($previous_batas_desa['batas_barat'] ?? ''); ?>",
                    kecBarat: "<?php echo htmlspecialchars($previous_batas_desa['kec_barat'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke masing-masing input
                      batasUtara.value = previousData.batasUtara || "";
                      kecUtara.value = previousData.kecUtara || "";
                      batasSelatan.value = previousData.batasSelatan || "";
                      kecSelatan.value = previousData.kecSelatan || "";
                      batasTimur.value = previousData.batasTimur || "";
                      kecTimur.value = previousData.kecTimur || "";
                      batasBarat.value = previousData.batasBarat || "";
                      kecBarat.value = previousData.kecBarat || "";

                      // Buat semua input menjadi read-only
                      const inputFields = [
                        batasUtara, kecUtara,
                        batasSelatan, kecSelatan,
                        batasTimur, kecTimur,
                        batasBarat, kecBarat
                      ];

                      inputFields.forEach(input => {
                        input.setAttribute("readonly", true);
                        input.style.backgroundColor = "#f0f0f0";
                        input.style.cursor = "not-allowed";
                      });
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      batasUtara.value = "";
                      kecUtara.value = "";
                      batasSelatan.value = "";
                      kecSelatan.value = "";
                      batasTimur.value = "";
                      kecTimur.value = "";
                      batasBarat.value = "";
                      kecBarat.value = "";

                      // Hapus atribut readonly dari semua input
                      const inputFields = [
                        batasUtara, kecUtara,
                        batasSelatan, kecSelatan,
                        batasTimur, kecTimur,
                        batasBarat, kecBarat
                      ];

                      inputFields.forEach(input => {
                        input.removeAttribute("readonly");
                        input.style.backgroundColor = "";
                        input.style.cursor = "default";
                      });
                    }
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();

                  // Validasi input hanya huruf dan spasi
                  function validateTextInput(input) {
                    input.addEventListener('input', function() {
                      // Hapus karakter selain huruf dan spasi
                      this.value = this.value.replace(/[^a-zA-Z\s]/g, '');

                      // Ubah huruf pertama setiap kata menjadi kapital
                      this.value = this.value.replace(/\b\w/g, char => char.toUpperCase());
                    });
                  }

                  // Terapkan validasi pada semua input nama desa dan kecamatan
                  const textInputs = [
                    batasUtara, kecUtara,
                    batasSelatan, kecSelatan,
                    batasTimur, kecTimur,
                    batasBarat, kecBarat
                  ];

                  textInputs.forEach(validateTextInput);
                });
              </script>
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

                  <?php if ($level != 'admin'): ?>
                    <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                    <div class="form-group mb-3">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="use_previous_jarak_kantor_desa" name="use_previous_jarak_kantor_desa" value="1">
                        <label class="form-check-label" for="use_previous_jarak_kantor_desa">
                          Gunakan data tahun sebelumnya
                        </label>
                      </div>
                    </div>
                  <?php endif; ?>

                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
              <script>
                document.addEventListener("DOMContentLoaded", function() {
                  // Ambil elemen input jarak
                  const jarakIbukotaKecamatan = document.getElementById("jarak_ke_ibukota_kecamatan");
                  const jarakIbukotaKabupaten = document.getElementById("jarak_ke_ibukota_kabupaten");

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_jarak_kantor_desa");

                  // Data tahun sebelumnya
                  const previousData = {
                    jarakIbukotaKecamatan: "<?php echo htmlspecialchars($previous_jarak_kantor_desa['jarak_ke_ibukota_kecamatan'] ?? ''); ?>",
                    jarakIbukotaKabupaten: "<?php echo htmlspecialchars($previous_jarak_kantor_desa['jarak_ke_ibukota_kabupaten'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke masing-masing input
                      jarakIbukotaKecamatan.value = previousData.jarakIbukotaKecamatan || "";
                      jarakIbukotaKabupaten.value = previousData.jarakIbukotaKabupaten || "";

                      // Buat semua input menjadi read-only
                      const inputFields = [
                        jarakIbukotaKecamatan,
                        jarakIbukotaKabupaten
                      ];

                      inputFields.forEach(input => {
                        input.setAttribute("readonly", true);
                        input.style.backgroundColor = "#f0f0f0";
                        input.style.cursor = "not-allowed";
                      });
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      jarakIbukotaKecamatan.value = "";
                      jarakIbukotaKabupaten.value = "";

                      // Hapus atribut readonly dari semua input
                      const inputFields = [
                        jarakIbukotaKecamatan,
                        jarakIbukotaKabupaten
                      ];

                      inputFields.forEach(input => {
                        input.removeAttribute("readonly");
                        input.style.backgroundColor = "";
                        input.style.cursor = "default";
                      });
                    }
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Tambahan: Validasi input hanya angka dan desimal
                  function validateNumericInput(input) {
                    input.addEventListener('input', function() {
                      // Hapus karakter non-numeric kecuali titik
                      this.value = this.value.replace(/[^0-9.]/g, '');

                      // Pastikan hanya satu titik desimal
                      const parts = this.value.split('.');
                      if (parts.length > 2) {
                        this.value = parts[0] + '.' + parts.slice(1).join('');
                      }
                    });
                  }

                  // Terapkan validasi pada input
                  validateNumericInput(jarakIbukotaKecamatan);
                  validateNumericInput(jarakIbukotaKabupaten);

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();
                });
              </script>
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
                  <label class="mb-2">Status Desa Membangun (Mandiri/Maju/Berkembang/Tertinggal/Sangat Tertinggal)</label>
                  <select required name="status_2024" id="status_2024" class="form-control">
                    <option value="" disabled selected>-- Pilih Status Desa Membangun --</option>
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
                <?php if ($level != 'admin'): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3 mt-2">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_idm_status" name="use_previous_idm_status" value="1">
                      <label class="form-check-label" for="use_previous_idm_status">
                        Gunakan data tahun sebelumnya
                      </label>
                    </div>
                  </div>
                <?php endif; ?>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div> <!--end::Footer-->
              </form>
              <!-- /.row -->
            </div>
            <script>
              document.addEventListener("DOMContentLoaded", function() {
                // Ambil elemen select untuk status IDM
                const statusIdm = document.getElementById("status_2024");

                // Checkbox untuk menggunakan data tahun sebelumnya
                const usePreviousCheckbox = document.getElementById("use_previous_idm_status");

                // Data tahun sebelumnya
                const previousData = {
                  statusIdm: "<?php echo htmlspecialchars($previous_idm_status['status_idm'] ?? ''); ?>"
                };

                // Fungsi untuk mengatur data tahun sebelumnya ke form
                function populatePreviousData() {
                  if (usePreviousCheckbox.checked) {
                    // Set nilai ke select
                    statusIdm.value = previousData.statusIdm || "";

                    // Nonaktifkan pilihan lain
                    for (let i = 0; i < statusIdm.options.length; i++) {
                      if (statusIdm.options[i].value !== previousData.statusIdm) {
                        statusIdm.options[i].disabled = true;
                      }
                    }

                    // Buat select menjadi read-only
                    statusIdm.style.backgroundColor = "#f0f0f0";
                    statusIdm.style.cursor = "not-allowed";
                  } else {
                    // Reset form jika checkbox tidak dicentang
                    statusIdm.value = ""; // Kembali ke pilihan default

                    // Aktifkan kembali semua pilihan
                    for (let i = 0; i < statusIdm.options.length; i++) {
                      statusIdm.options[i].disabled = false;
                    }

                    // Kembalikan style ke default
                    statusIdm.style.backgroundColor = "";
                    statusIdm.style.cursor = "default";
                  }
                }

                // Event listener untuk checkbox
                usePreviousCheckbox.addEventListener("change", populatePreviousData);

                // Inisialisasi saat halaman dimuat
                populatePreviousData();
              });
            </script>
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
                <?php if ($level != 'admin'): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_website_medsos" name="use_previous_website_medsos" value="1">
                      <label class="form-check-label" for="use_previous_website_medsos">
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
                document.addEventListener("DOMContentLoaded", function() {
                  // Ambil semua input field
                  const alamatWebsite = document.querySelector('input[name="alamat_website"]');
                  const alamatEmail = document.querySelector('input[name="alamat_email"]');
                  const alamatFacebook = document.querySelector('input[name="alamat_facebook"]');
                  const alamatTwitter = document.querySelector('input[name="alamat_twitter"]');
                  const alamatYoutube = document.querySelector('input[name="alamat_youtube"]');

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_website_medsos");

                  // Data tahun sebelumnya
                  const previousData = {
                    alamatWebsite: "<?php echo htmlspecialchars($previous_website_medsos['alamat_website'] ?? ''); ?>",
                    alamatEmail: "<?php echo htmlspecialchars($previous_website_medsos['alamat_email'] ?? ''); ?>",
                    alamatFacebook: "<?php echo htmlspecialchars($previous_website_medsos['alamat_facebook'] ?? ''); ?>",
                    alamatTwitter: "<?php echo htmlspecialchars($previous_website_medsos['alamat_twitter'] ?? ''); ?>",
                    alamatYoutube: "<?php echo htmlspecialchars($previous_website_medsos['alamat_youtube'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke masing-masing input
                      alamatWebsite.value = previousData.alamatWebsite || "";
                      alamatEmail.value = previousData.alamatEmail || "";
                      alamatFacebook.value = previousData.alamatFacebook || "";
                      alamatTwitter.value = previousData.alamatTwitter || "";
                      alamatYoutube.value = previousData.alamatYoutube || "";

                      // Buat semua input menjadi read-only
                      const inputFields = [
                        alamatWebsite,
                        alamatEmail,
                        alamatFacebook,
                        alamatTwitter,
                        alamatYoutube
                      ];

                      inputFields.forEach(input => {
                        input.setAttribute("readonly", true);
                        input.style.backgroundColor = "#f0f0f0";
                        input.style.cursor = "not-allowed";
                      });
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      alamatWebsite.value = "";
                      alamatEmail.value = "";
                      alamatFacebook.value = "";
                      alamatTwitter.value = "";
                      alamatYoutube.value = "";

                      // Hapus atribut readonly dari semua input
                      const inputFields = [
                        alamatWebsite,
                        alamatEmail,
                        alamatFacebook,
                        alamatTwitter,
                        alamatYoutube
                      ];

                      inputFields.forEach(input => {
                        input.removeAttribute("readonly");
                        input.style.backgroundColor = "";
                        input.style.cursor = "default";
                      });
                    }
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();
                });
              </script>
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
                  <select name="status_2024" id="status_2024" class="form-control">
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
                <?php if ($level != 'admin'): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_status_pemerintahan" name="use_previous_status_pemerintahan" value="1">
                      <label class="form-check-label" for="use_previous_status_pemerintahan">
                        Gunakan data tahun sebelumnya
                      </label>
                    </div>
                  </div>
                <?php endif; ?>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div> <!--end::Footer-->
              </form>
              <script>
                document.addEventListener("DOMContentLoaded", function() {
                  // Ambil elemen select untuk status pemerintahan
                  const statusPemerintahan = document.getElementById("status_2024");

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_status_pemerintahan");

                  // Data tahun sebelumnya
                  const previousData = {
                    statusPemerintahan: "<?php echo htmlspecialchars($previous_status_pemerintahan['status_pemerintahan'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke select
                      statusPemerintahan.value = previousData.statusPemerintahan || "";

                      // Nonaktifkan pilihan lain
                      for (let i = 0; i < statusPemerintahan.options.length; i++) {
                        if (statusPemerintahan.options[i].value !== previousData.statusPemerintahan) {
                          statusPemerintahan.options[i].disabled = true;
                        }
                      }

                      // Buat select menjadi read-only
                      statusPemerintahan.style.backgroundColor = "#f0f0f0";
                      statusPemerintahan.style.cursor = "not-allowed";
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      statusPemerintahan.value = ""; // Kembali ke pilihan default

                      // Aktifkan kembali semua pilihan
                      for (let i = 0; i < statusPemerintahan.options.length; i++) {
                        statusPemerintahan.options[i].disabled = false;
                      }

                      // Kembalikan style ke default
                      statusPemerintahan.style.backgroundColor = "";
                      statusPemerintahan.style.cursor = "default";
                    }
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();
                });
              </script>
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
                          echo displayPreviousYearData($previous_ketersediaan_peta_desa, 'penetapan_batas_desa', 'Ketersediaan dan Penetapan Peta Desa');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mb-3" id="form_no_surat_batas_desa" style="display: none;">
                      <label class="mb-2">No SK/Perbup/Perda/Perdes tentang Penetapan Batas Desa</label>
                      <input required type="text" name="no_surat_batas_desa" id="no_surat_batas_desa" class="form-control" placeholder="Masukkan No Peraturan">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_ketersediaan_peta_desa, 'no_surat_batas_desa', 'Ketersediaan dan Penetapan Peta Desa');
                          ?>
                        </p>
                      <?php endif; ?>
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
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_ketersediaan_peta_desa, 'ketersediaan_peta_desa', 'Ketersediaan dan Penetapan Peta Desa');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mb-3" id="form_no_surat_peta_desa" style="display: none;">
                      <label class="mb-2">No SK/Perbup/Perda tentang Peta Desa</label>
                      <input required type="text" name="no_surat_peta_desa" id="no_surat_peta_desa" class="form-control" placeholder="Masukkan No Peraturan">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_ketersediaan_peta_desa, 'no_surat_peta_desa', 'Ketersediaan dan Penetapan Peta Desa');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <?php if ($level != 'admin'): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3 mt-2">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_ketersediaan_peta_desa" name="use_previous_ketersediaan_peta_desa" value="1">
                      <label class="form-check-label" for="use_previous_ketersediaan_peta_desa">
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
                document.addEventListener("DOMContentLoaded", function() {
                  // Ambil elemen-elemen select dan input
                  const penetapanBatasDesa = document.getElementById("penetapan_batas_desa");
                  const ketersediaanPetaDesa = document.getElementById("ketersediaan_peta_desa");
                  const noSuratBatasDesa = document.getElementById("no_surat_batas_desa");
                  const noSuratPetaDesa = document.getElementById("no_surat_peta_desa");
                  const formNoSuratBatasDesa = document.getElementById("form_no_surat_batas_desa");
                  const formNoSuratPetaDesa = document.getElementById("form_no_surat_peta_desa");

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_ketersediaan_peta_desa");

                  // Data tahun sebelumnya
                  const previousData = {
                    penetapanBatasDesa: "<?php echo htmlspecialchars($previous_ketersediaan_peta_desa['penetapan_batas_desa'] ?? ''); ?>",
                    ketersediaanPetaDesa: "<?php echo htmlspecialchars($previous_ketersediaan_peta_desa['ketersediaan_peta_desa'] ?? ''); ?>",
                    noSuratBatasDesa: "<?php echo htmlspecialchars($previous_ketersediaan_peta_desa['no_surat_batas_desa'] ?? ''); ?>",
                    noSuratPetaDesa: "<?php echo htmlspecialchars($previous_ketersediaan_peta_desa['no_surat_peta_desa'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur tampilan input tambahan
                  function toggleInputFields() {
                    // Logic untuk menampilkan/menyembunyikan input tambahan
                    formNoSuratBatasDesa.style.display = (penetapanBatasDesa.value === "SUDAH ADA") ? "block" : "none";
                    formNoSuratPetaDesa.style.display = (ketersediaanPetaDesa.value === "ADA") ? "block" : "none";
                  }

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke masing-masing input
                      penetapanBatasDesa.value = previousData.penetapanBatasDesa || "";
                      ketersediaanPetaDesa.value = previousData.ketersediaanPetaDesa || "";
                      noSuratBatasDesa.value = previousData.noSuratBatasDesa || "";
                      noSuratPetaDesa.value = previousData.noSuratPetaDesa || "";

                      // Nonaktifkan pilihan lain pada select
                      for (let i = 0; i < penetapanBatasDesa.options.length; i++) {
                        if (penetapanBatasDesa.options[i].value !== previousData.penetapanBatasDesa) {
                          penetapanBatasDesa.options[i].disabled = true;
                        }
                      }

                      for (let i = 0; i < ketersediaanPetaDesa.options.length; i++) {
                        if (ketersediaanPetaDesa.options[i].value !== previousData.ketersediaanPetaDesa) {
                          ketersediaanPetaDesa.options[i].disabled = true;
                        }
                      }

                      // Buat semua input menjadi read-only
                      const inputFields = [
                        penetapanBatasDesa,
                        ketersediaanPetaDesa,
                        noSuratBatasDesa,
                        noSuratPetaDesa
                      ];

                      inputFields.forEach(input => {
                        input.setAttribute("readonly", true);
                        input.style.backgroundColor = "#f0f0f0";
                        input.style.cursor = "not-allowed";
                      });

                      // Tampilkan input tambahan sesuai data
                      toggleInputFields();
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      penetapanBatasDesa.value = "";
                      ketersediaanPetaDesa.value = "";
                      noSuratBatasDesa.value = "";
                      noSuratPetaDesa.value = "";

                      // Aktifkan kembali semua pilihan
                      for (let i = 0; i < penetapanBatasDesa.options.length; i++) {
                        penetapanBatasDesa.options[i].disabled = false;
                      }

                      for (let i = 0; i < ketersediaanPetaDesa.options.length; i++) {
                        ketersediaanPetaDesa.options[i].disabled = false;
                      }

                      // Hapus atribut readonly dari semua input
                      const inputFields = [
                        penetapanBatasDesa,
                        ketersediaanPetaDesa,
                        noSuratBatasDesa,
                        noSuratPetaDesa
                      ];

                      inputFields.forEach(input => {
                        input.removeAttribute("readonly");
                        input.style.backgroundColor = "";
                        input.style.cursor = "default";
                      });

                      // Sembunyikan input tambahan
                      formNoSuratBatasDesa.style.display = "none";
                      formNoSuratPetaDesa.style.display = "none";
                    }
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Event listener untuk select
                  penetapanBatasDesa.addEventListener("change", toggleInputFields);
                  ketersediaanPetaDesa.addEventListener("change", toggleInputFields);

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();
                });
              </script>
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
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_banyaknya_dusun_rt_rw, 'jumlah_dusun', 'Banyaknya Dusun, Rukun Tetangga dan Rukun Warga');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div>
                    <!-- /.form-group -->
                    <div class="form-group mb-3">
                      <label class="mb-2">Banyaknya RW</label>
                      <input required type="number" name="jumlah_rw" class="form-control" placeholder="Masukkan angka/jumlah"
                        min="0" step="1" style="width: 100%;">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_banyaknya_dusun_rt_rw, 'jumlah_rw', 'Banyaknya Dusun, Rukun Tetangga dan Rukun Warga');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div>
                    <!-- /.form-group -->
                    <div class="form-group mb-3">
                      <label class="mb-2">Banyaknya RT</label>
                      <input required type="number" name="jumlah_rt" class="form-control" placeholder="Masukkan angka/jumlah"
                        min="0" step="1" style="width: 100%;">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_banyaknya_dusun_rt_rw, 'jumlah_rt', 'Banyaknya Dusun, Rukun Tetangga dan Rukun Warga');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                  <!-- /.col -->
                  <?php if ($level != 'admin'): ?>
                    <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                    <div class="form-group mb-3">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="use_previous_banyaknya_dusun_rt_rw" name="use_previous_banyaknya_dusun_rt_rw" value="1">
                        <label class="form-check-label" for="use_previous_banyaknya_dusun_rt_rw">
                          Gunakan data tahun sebelumnya
                        </label>
                      </div>
                    </div>
                  <?php endif; ?>
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
              <script>
                document.addEventListener("DOMContentLoaded", function() {
                  // Ambil elemen input
                  const jumlahDusun = document.querySelector('input[name="jumlah_dusun"]');
                  const jumlahRW = document.querySelector('input[name="jumlah_rw"]');
                  const jumlahRT = document.querySelector('input[name="jumlah_rt"]');

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_banyaknya_dusun_rt_rw");

                  // Data tahun sebelumnya
                  const previousData = {
                    jumlahDusun: "<?php echo htmlspecialchars($previous_banyaknya_dusun_rt_rw['jumlah_dusun'] ?? ''); ?>",
                    jumlahRW: "<?php echo htmlspecialchars($previous_banyaknya_dusun_rt_rw['jumlah_rw'] ?? ''); ?>",
                    jumlahRT: "<?php echo htmlspecialchars($previous_banyaknya_dusun_rt_rw['jumlah_rt'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke masing-masing input
                      jumlahDusun.value = previousData.jumlahDusun || "";
                      jumlahRW.value = previousData.jumlahRW || "";
                      jumlahRT.value = previousData.jumlahRT || "";

                      // Buat semua input menjadi read-only
                      const inputFields = [
                        jumlahDusun,
                        jumlahRW,
                        jumlahRT
                      ];

                      inputFields.forEach(input => {
                        input.setAttribute("readonly", true);
                        input.style.backgroundColor = "#f0f0f0";
                        input.style.cursor = "not-allowed";
                      });
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      jumlahDusun.value = "";
                      jumlahRW.value = "";
                      jumlahRT.value = "";

                      // Hapus atribut readonly dari semua input
                      const inputFields = [
                        jumlahDusun,
                        jumlahRW,
                        jumlahRT
                      ];

                      inputFields.forEach(input => {
                        input.removeAttribute("readonly");
                        input.style.backgroundColor = "";
                        input.style.cursor = "default";
                      });
                    }
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();
                });
              </script>
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
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_luas_wilayah_desa, 'luas_wilayah_desa', 'Luas Wilayah Desa/Kelurahan');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                  <?php if ($level != 'admin'): ?>
                    <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                    <div class="form-group mb-3">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="use_previous_luas_wilayah_desa" name="use_previous_luas_wilayah_desa" value="1">
                        <label class="form-check-label" for="use_previous_luas_wilayah_desa">
                          Gunakan data tahun sebelumnya
                        </label>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
              <script>
                document.addEventListener("DOMContentLoaded", function() {
                  // Ambil elemen input luas wilayah desa
                  const luasWilayahDesa = document.getElementById("luas_wilayah_desa");

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_luas_wilayah_desa");

                  // Data tahun sebelumnya
                  const previousData = {
                    luasWilayahDesa: "<?php echo htmlspecialchars($previous_luas_wilayah_desa['luas_wilayah_desa'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke input luas wilayah desa
                      luasWilayahDesa.value = previousData.luasWilayahDesa || "";

                      // Buat input menjadi read-only
                      luasWilayahDesa.setAttribute("readonly", true);
                      luasWilayahDesa.style.backgroundColor = "#f0f0f0";
                      luasWilayahDesa.style.cursor = "not-allowed";
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      luasWilayahDesa.value = "";

                      // Hapus atribut readonly
                      luasWilayahDesa.removeAttribute("readonly");
                      luasWilayahDesa.style.backgroundColor = "";
                      luasWilayahDesa.style.cursor = "default";
                    }
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();
                });
              </script>
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
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_topografi_wilayah_desa, 'topografi_terluas_wilayah_desa', 'Topografi Terluas Wilayah Desa');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                  <?php if ($level != 'admin'): ?>
                    <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                    <div class="form-group mb-3">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="use_previous_topografi_wilayah_desa" name="use_previous_topografi_wilayah_desa" value="1">
                        <label class="form-check-label" for="use_previous_topografi_wilayah_desa">
                          Gunakan data tahun sebelumnya
                        </label>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
              <script>
                document.addEventListener("DOMContentLoaded", function() {
                  // Ambil elemen select untuk topografi terluas wilayah desa
                  const topografiTerluasWilayahDesa = document.querySelector('select[name="topografi_terluas_wilayah_desa"]');

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_topografi_wilayah_desa");

                  // Data tahun sebelumnya
                  const previousData = {
                    topografiTerluasWilayahDesa: "<?php echo htmlspecialchars($previous_topografi_wilayah_desa['topografi_terluas_wilayah_desa'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke select
                      topografiTerluasWilayahDesa.value = previousData.topografiTerluasWilayahDesa || "";

                      // Nonaktifkan pilihan lain
                      for (let i = 0; i < topografiTerluasWilayahDesa.options.length; i++) {
                        if (topografiTerluasWilayahDesa.options[i].value !== previousData.topografiTerluasWilayahDesa) {
                          topografiTerluasWilayahDesa.options[i].disabled = true;
                        }
                      }

                      // Buat select menjadi read-only
                      topografiTerluasWilayahDesa.setAttribute("readonly", true);
                      topografiTerluasWilayahDesa.style.backgroundColor = "#f0f0f0";
                      topografiTerluasWilayahDesa.style.cursor = "not-allowed";
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      topografiTerluasWilayahDesa.value = ""; // Kembali ke pilihan default

                      // Aktifkan kembali semua pilihan
                      for (let i = 0; i < topografiTerluasWilayahDesa.options.length; i++) {
                        topografiTerluasWilayahDesa.options[i].disabled = false;
                      }

                      // Hapus atribut readonly
                      topografiTerluasWilayahDesa.removeAttribute("readonly");
                      topografiTerluasWilayahDesa.style.backgroundColor = "";
                      topografiTerluasWilayahDesa.style.cursor = "default";
                    }
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();
                });
              </script>

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
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_kepemilikan_kantor, 'keberadaan_kantor', 'Keberadaan, Status, Kondisi, dan Lokasi Kantor Kepala Desa/Lurah');
                          ?>
                        </p>
                      <?php endif; ?>
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
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_kepemilikan_kantor, 'status_kantor', 'Kepemilikan Kantor');
                          ?>
                        </p>
                      <?php endif; ?>
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
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_kepemilikan_kantor, 'kondisi_kantor', 'Kepemilikan Kantor');
                          ?>
                        </p>
                      <?php endif; ?>
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
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_kepemilikan_kantor, 'lokasi_kantor', 'Kepemilikan Kantor');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                  <?php if ($level != 'admin'): ?>
                    <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                    <div class="form-group mb-3">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="use_previous_kepemilikan_kantor" name="use_previous_kepemilikan_kantor" value="1">
                        <label class="form-check-label" for="use_previous_kepemilikan_kantor">
                          Gunakan data tahun sebelumnya
                        </label>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
              <script>
                document.addEventListener("DOMContentLoaded", function() {
                  // Ambil semua elemen select
                  const keberadaanKantor = document.getElementById("keberadaan_kantor");
                  const statusKantor = document.getElementById("status_kantor");
                  const kondisiKantor = document.getElementById("kondisi_kantor");
                  const lokasiKantor = document.getElementById("lokasi_kantor");

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_kepemilikan_kantor");

                  // Data tahun sebelumnya
                  const previousData = {
                    keberadaanKantor: "<?php echo htmlspecialchars($previous_kepemilikan_kantor['keberadaan_kantor'] ?? ''); ?>",
                    statusKantor: "<?php echo htmlspecialchars($previous_kepemilikan_kantor['status_kantor'] ?? ''); ?>",
                    kondisiKantor: "<?php echo htmlspecialchars($previous_kepemilikan_kantor['kondisi_kantor'] ?? ''); ?>",
                    lokasiKantor: "<?php echo htmlspecialchars($previous_kepemilikan_kantor['lokasi_kantor'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke masing-masing select
                      keberadaanKantor.value = previousData.keberadaanKantor || "";
                      statusKantor.value = previousData.statusKantor || "";
                      kondisiKantor.value = previousData.kondisiKantor || "";
                      lokasiKantor.value = previousData.lokasiKantor || "";

                      // Array select untuk iterasi
                      const selectFields = [
                        keberadaanKantor,
                        statusKantor,
                        kondisiKantor,
                        lokasiKantor
                      ];

                      // Nonaktifkan pilihan lain dan atur styling
                      selectFields.forEach(select => {
                        for (let i = 0; i < select.options.length; i++) {
                          if (select.options[i].value !== select.value) {
                            select.options[i].disabled = true;
                          }
                        }

                        select.style.backgroundColor = "#f0f0f0";
                        select.style.cursor = "not-allowed";
                      });
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      keberadaanKantor.value = "";
                      statusKantor.value = "";
                      kondisiKantor.value = "";
                      lokasiKantor.value = "";

                      // Array select untuk iterasi
                      const selectFields = [
                        keberadaanKantor,
                        statusKantor,
                        kondisiKantor,
                        lokasiKantor
                      ];

                      // Aktifkan kembali semua pilihan dan reset styling
                      selectFields.forEach(select => {
                        for (let i = 0; i < select.options.length; i++) {
                          select.options[i].disabled = false;
                        }

                        select.style.backgroundColor = "";
                        select.style.cursor = "default";
                      });
                    }
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();
                });
              </script>
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
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_titik_koordinat_kantor_desa, 'koordinat_lintang', 'Titik Koordinat Kantor Desa');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>

                  <div class="form-group mb-3">
                    <label class="mb-2">Koordinat Bujur (Longitude)</label>
                    <input required type="text" class="form-control" name="koordinat_bujur"
                      placeholder="Masukkan koordinat bujur" style="width: 100%;">
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_titik_koordinat_kantor_desa, 'koordinat_bujur', 'Titik Koordinat Kantor Desa');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                  <?php if ($level != 'admin'): ?>
                    <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                    <div class="form-group mb-3 mt-2">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="use_previous_titik_koordinat_kantor_desa" name="use_previous_titik_koordinat_kantor_desa" value="1">
                        <label class="form-check-label" for="use_previous_titik_koordinat_kantor_desa">
                          Gunakan data tahun sebelumnya
                        </label>
                      </div>
                    </div>
                  <?php endif; ?>
                  <div class="mb-3">
                    <div class="mb-2">
                      <button type="submit" class="btn btn-primary mt-3">
                        <i class="fas fa-save"></i> &nbsp; Simpan
                      </button>
                    </div>
                  </div> <!--end::Footer-->
              </form>
              <script>
                document.addEventListener("DOMContentLoaded", function() {
                  // Ambil elemen input koordinat
                  const koordinatLintang = document.querySelector('input[name="koordinat_lintang"]');
                  const koordinatBujur = document.querySelector('input[name="koordinat_bujur"]');

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_titik_koordinat_kantor_desa");

                  // Data tahun sebelumnya
                  const previousData = {
                    koordinatLintang: "<?php echo htmlspecialchars($previous_titik_koordinat_kantor_desa['koordinat_lintang'] ?? ''); ?>",
                    koordinatBujur: "<?php echo htmlspecialchars($previous_titik_koordinat_kantor_desa['koordinat_bujur'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke masing-masing input
                      koordinatLintang.value = previousData.koordinatLintang || "";
                      koordinatBujur.value = previousData.koordinatBujur || "";

                      // Buat semua input menjadi read-only
                      const inputFields = [
                        koordinatLintang,
                        koordinatBujur
                      ];

                      inputFields.forEach(input => {
                        input.setAttribute("readonly", true);
                        input.style.backgroundColor = "#f0f0f0";
                        input.style.cursor = "not-allowed";
                      });
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      koordinatLintang.value = "";
                      koordinatBujur.value = "";

                      // Hapus atribut readonly dari semua input
                      const inputFields = [
                        koordinatLintang,
                        koordinatBujur
                      ];

                      inputFields.forEach(input => {
                        input.removeAttribute("readonly");
                        input.style.backgroundColor = "";
                        input.style.cursor = "default";
                      });
                    }
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();
                });
              </script>
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