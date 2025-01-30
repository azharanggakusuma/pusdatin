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

// tb_pengguna_listrik_lampu_surya
$previous_pengguna_listrik_lampu_surya = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_pengguna_listrik_lampu_surya',
  ['jumlah_pln', 'jumlah_non_pln', 'jumlah_bukan_pengguna_listrik', 'penggunaan_lampu_tenaga_surya'],
  'Pengguna Listrik dan Lampu Tenaga Surya',
  $tahun
);

// tb_penerangan_jalan
$previous_penerangan_jalan = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_penerangan_jalan',
  ['lampu_tenaga_surya', 'penerangan_jalan_utama', 'sumber_penerangan'],
  'Penerangan Jalan',
  $tahun
);

// tb_pengelolaan_sampah
$previous_pengelolaan_sampah = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_pengelolaan_sampah',
  ['tps', 'tps3r', 'bank_sampah'],
  'Pengelolaan Sampah',
  $tahun
);

// tb_sutet
$previous_sutet = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_sutet',
  ['sutet_status', 'keberadaan_pemukiman', 'jumlah_pemukiman'],
  'Wilayah SUTET/SUTT/SUTTAS',
  $tahun
);

// tb_keberadaan_sungai
$previous_keberadaan_sungai = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_keberadaan_sungai',
  ['keberadaan_sungai', 'nama_sungai_1', 'nama_sungai_2', 'nama_sungai_3', 'nama_sungai_4'],
  'Keberadaan Sungai',
  $tahun
);

// tb_keberadaan_danau
$previous_keberadaan_danau = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_keberadaan_danau',
  ['keberadaan_danau', 'nama_danau_1', 'nama_danau_2', 'nama_danau_3', 'nama_danau_4'],
  'Keberadaan Danau/Waduk/Situ',
  $tahun
);

// tb_keberadaan_pemukiman_bantaran
$previous_keberadaan_pemukiman_bantaran = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_keberadaan_pemukiman_bantaran',
  ['keberadaan_pemukiman', 'jumlah_pemukiman'],
  'Keberadaan Permukiman di Bantaran Sungai',
  $tahun
);

// tb_embung_mata_air
$previous_embung_mata_air = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_embung_mata_air',
  ['jumlah_embung', 'lokasi_mata_air'],
  'Banyaknya Embung dan Lokasi Mata Air',
  $tahun
);

// tb_permukiman_kumuh
$previous_permukiman_kumuh = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_permukiman_kumuh',
  ['keberadaan_kumuh', 'jumlah_kumuh'],
  'Keberadaan Permukiman Kumuh',
  $tahun
);

// tb_lokasi_penggalian
$previous_lokasi_penggalian = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_lokasi_penggalian',
  ['keberadaan_galian'],
  'Keberadaan Lokasi Penggalian Golongan C',
  $tahun
);

// tb_prasarana_kebersihan
$previous_prasarana_kebersihan = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_prasarana_kebersihan',
  ['jumlah_prasarana'],
  'Jumlah Sarana Prasarana Kebersihan',
  $tahun
);

// tb_rumah_tidak_layak_huni
$previous_rumah_tidak_layak_huni = getPreviousYearData(
  $conn,
  $user_id,
  $desa_id,
  'tb_rumah_tidak_layak_huni',
  ['jumlah_rumah'],
  'Jumlah Rumah Tidak Layak Huni',
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
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_pengguna_listrik_lampu_surya, 'jumlah_pln', 'Pengguna Listrik dan Lampu Tenaga Surya');
                        ?>
                      </p>
                    <?php endif; ?>
                    <li class="mb-1">Non-PLN (Misalnya: Swasta, Swadaya, Atau Perseorangan)</li>
                    <input name="jumlah_non_pln" type="number" class="form-control mb-4" placeholder="--- Masukkan jumlah ---" min="0" required>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_pengguna_listrik_lampu_surya, 'jumlah_non_pln', 'Pengguna Listrik dan Lampu Tenaga Surya');
                        ?>
                      </p>
                    <?php endif; ?>
                    <h5 class="mb-2">B. Jumlah Keluraga Bukan Pengguna Listrik:</h5>
                    <input name="jumlah_bukan_pengguna_listrik" type="number" class="form-control mb-4" placeholder="--- Masukkan jumlah ---" min="0" required>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_pengguna_listrik_lampu_surya, 'jumlah_bukan_pengguna_listrik', 'Pengguna Listrik dan Lampu Tenaga Surya');
                        ?>
                      </p>
                    <?php endif; ?>
                    <h5 class="mb-2">C. Keluarga yang Menggunakan Lampu Tenaga Surya:</h5>
                    <select name="penggunaan_lampu_tenaga_surya" class="form-control" required>
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada, Sebagian Besar">Ada, Sebagian Besar</option>
                      <option value="Ada, Sebagian Kecil">Ada, Sebagian Kecil</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_pengguna_listrik_lampu_surya, 'penggunaan_lampu_tenaga_surya', 'Pengguna Listrik dan Lampu Tenaga Surya');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>
                <?php if ($level != 'admin' && $tahun != 2024): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_listrik_lampu_surya" name="use_previous_listrik_lampu_surya" value="1">
                      <label class="form-check-label" for="use_previous_listrik_lampu_surya">
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
                  // Ambil semua elemen input dan select
                  const jumlahPln = document.querySelector('input[name="jumlah_pln"]');
                  const jumlahNonPln = document.querySelector('input[name="jumlah_non_pln"]');
                  const jumlahBukanPenggunaListrik = document.querySelector('input[name="jumlah_bukan_pengguna_listrik"]');
                  const penggunaanLampuTenagaSurya = document.querySelector('select[name="penggunaan_lampu_tenaga_surya"]');

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_listrik_lampu_surya");

                  // Data tahun sebelumnya
                  const previousData = {
                    jumlahPln: "<?php echo htmlspecialchars($previous_pengguna_listrik_lampu_surya['jumlah_pln'] ?? ''); ?>",
                    jumlahNonPln: "<?php echo htmlspecialchars($previous_pengguna_listrik_lampu_surya['jumlah_non_pln'] ?? ''); ?>",
                    jumlahBukanPenggunaListrik: "<?php echo htmlspecialchars($previous_pengguna_listrik_lampu_surya['jumlah_bukan_pengguna_listrik'] ?? ''); ?>",
                    penggunaanLampuTenagaSurya: "<?php echo htmlspecialchars($previous_pengguna_listrik_lampu_surya['penggunaan_lampu_tenaga_surya'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke masing-masing input dan select
                      jumlahPln.value = previousData.jumlahPln || "";
                      jumlahNonPln.value = previousData.jumlahNonPln || "";
                      jumlahBukanPenggunaListrik.value = previousData.jumlahBukanPenggunaListrik || "";
                      penggunaanLampuTenagaSurya.value = previousData.penggunaanLampuTenagaSurya || "";

                      // Buat semua input menjadi read-only
                      const inputFields = [
                        jumlahPln,
                        jumlahNonPln,
                        jumlahBukanPenggunaListrik
                      ];

                      inputFields.forEach(input => {
                        input.setAttribute("readonly", true);
                        input.style.backgroundColor = "#f0f0f0";
                        input.style.cursor = "not-allowed";
                      });

                      // Nonaktifkan pilihan lain pada select
                      for (let i = 0; i < penggunaanLampuTenagaSurya.options.length; i++) {
                        if (penggunaanLampuTenagaSurya.options[i].value !== previousData.penggunaanLampuTenagaSurya) {
                          penggunaanLampuTenagaSurya.options[i].disabled = true;
                        }
                      }

                      // Styling select
                      penggunaanLampuTenagaSurya.style.backgroundColor = "#f0f0f0";
                      penggunaanLampuTenagaSurya.style.cursor = "not-allowed";
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      jumlahPln.value = "";
                      jumlahNonPln.value = "";
                      jumlahBukanPenggunaListrik.value = "";
                      penggunaanLampuTenagaSurya.value = "";

                      // Hapus atribut readonly dari semua input
                      const inputFields = [
                        jumlahPln,
                        jumlahNonPln,
                        jumlahBukanPenggunaListrik
                      ];

                      inputFields.forEach(input => {
                        input.removeAttribute("readonly");
                        input.style.backgroundColor = "";
                        input.style.cursor = "default";
                      });

                      // Aktifkan kembali semua pilihan pada select
                      for (let i = 0; i < penggunaanLampuTenagaSurya.options.length; i++) {
                        penggunaanLampuTenagaSurya.options[i].disabled = false;
                      }

                      // Reset styling select
                      penggunaanLampuTenagaSurya.style.backgroundColor = "";
                      penggunaanLampuTenagaSurya.style.cursor = "default";
                    }
                  }

                  // Validasi input numerik
                  function validateNumericInput() {
                    const numericInputs = [
                      jumlahPln,
                      jumlahNonPln,
                      jumlahBukanPenggunaListrik
                    ];

                    numericInputs.forEach(input => {
                      input.addEventListener('input', function() {
                        // Hapus karakter non-numerik
                        this.value = this.value.replace(/[^0-9]/g, '');

                        // Hapus angka 0 di depan
                        this.value = this.value.replace(/^0+/, '');

                        // Batasi panjang input
                        if (this.value.length > 6) {
                          this.value = this.value.slice(0, 6);
                        }
                      });

                      // Pastikan input tidak kosong
                      input.addEventListener('change', function() {
                        if (this.value === '') {
                          this.value = '0';
                        }
                      });
                    });
                  }

                  // Validasi logika total pengguna listrik
                  function validateListrikLogic() {
                    function checkListrikLogic() {
                      const pln = parseInt(jumlahPln.value || 0);
                      const nonPln = parseInt(jumlahNonPln.value || 0);
                      const bukanPengguna = parseInt(jumlahBukanPenggunaListrik.value || 0);

                      // Cek apakah total masuk akal
                      const totalKeluarga = pln + nonPln + bukanPengguna;

                      if (totalKeluarga > 10000) {
                        alert('Jumlah keluarga tampaknya terlalu besar. Mohon periksa kembali.');
                      }
                    }

                    jumlahPln.addEventListener('change', checkListrikLogic);
                    jumlahNonPln.addEventListener('change', checkListrikLogic);
                    jumlahBukanPenggunaListrik.addEventListener('change', checkListrikLogic);
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Jalankan validasi
                  validateNumericInput();
                  validateListrikLogic();

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();
                });
              </script>
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
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_penerangan_jalan, 'lampu_tenaga_surya', 'Penerangan Jalan');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>

                  <div class="form-group mb-3">
                    <label class="mb-2">Penerangan di Jalan Utama Desa/Kelurahan</label>
                    <select name="penerangan_jalan_utama" class="form-control" required>
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada, Sebagian Besar">Ada, Sebagian Besar</option>
                      <option value="Ada, Sebagian Kecil">Ada, Sebagian Kecil</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_penerangan_jalan, 'penerangan_jalan_utama', 'Penerangan Jalan');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>

                  <div class="form-group mb-3">
                    <label class="mb-2">Sumber Penerangan di Jalan Utama Desa/Kelurahan</label>
                    <select name="sumber_penerangan" class="form-control" required>
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Listrik Diusahakan Oleh Pemerintah">Listrik Diusahakan Oleh Pemerintah</option>
                      <option value="Listrik Diusahakan Oleh Non Pemerintah">Listrik Diusahakan Oleh Non Pemerintah</option>
                      <option value="Non Listrik">Non Listrik</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_penerangan_jalan, 'sumber_penerangan', 'Penerangan Jalan');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>
                <?php if ($level != 'admin' && $tahun != 2024): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_penerangan_jalan" name="use_previous_penerangan_jalan" value="1">
                      <label class="form-check-label" for="use_previous_penerangan_jalan">
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
                  // Ambil semua elemen select
                  const lampuTenagaSurya = document.querySelector('select[name="lampu_tenaga_surya"]');
                  const peneranganJalanUtama = document.querySelector('select[name="penerangan_jalan_utama"]');
                  const sumberPenerangan = document.querySelector('select[name="sumber_penerangan"]');

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_penerangan_jalan");

                  // Data tahun sebelumnya
                  const previousData = {
                    lampuTenagaSurya: "<?php echo htmlspecialchars($previous_penerangan_jalan['lampu_tenaga_surya'] ?? ''); ?>",
                    peneranganJalanUtama: "<?php echo htmlspecialchars($previous_penerangan_jalan['penerangan_jalan_utama'] ?? ''); ?>",
                    sumberPenerangan: "<?php echo htmlspecialchars($previous_penerangan_jalan['sumber_penerangan'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke masing-masing select
                      lampuTenagaSurya.value = previousData.lampuTenagaSurya || "";
                      peneranganJalanUtama.value = previousData.peneranganJalanUtama || "";
                      sumberPenerangan.value = previousData.sumberPenerangan || "";

                      // Array select untuk iterasi
                      const selectFields = [
                        lampuTenagaSurya,
                        peneranganJalanUtama,
                        sumberPenerangan
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
                      lampuTenagaSurya.value = "";
                      peneranganJalanUtama.value = "";
                      sumberPenerangan.value = "";

                      // Array select untuk iterasi
                      const selectFields = [
                        lampuTenagaSurya,
                        peneranganJalanUtama,
                        sumberPenerangan
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

                  // Fungsi untuk menambahkan validasi tambahan
                  function addAdditionalValidation() {
                    // Contoh validasi logika antar pilihan

                    // Jika lampu tenaga surya "Tidak Ada", maka batasi pilihan sumber penerangan
                    lampuTenagaSurya.addEventListener('change', function() {
                      if (this.value === "Tidak Ada") {
                        // Nonaktifkan pilihan terkait lampu tenaga surya
                        for (let i = 0; i < sumberPenerangan.options.length; i++) {
                          if (sumberPenerangan.options[i].value === "Listrik Diusahakan Oleh Pemerintah") {
                            sumberPenerangan.options[i].disabled = true;
                          }
                        }
                      } else {
                        // Aktifkan kembali semua pilihan
                        for (let i = 0; i < sumberPenerangan.options.length; i++) {
                          sumberPenerangan.options[i].disabled = false;
                        }
                      }
                    });

                    // Validasi hubungan antara penerangan jalan utama dan sumber penerangan
                    peneranganJalanUtama.addEventListener('change', function() {
                      if (this.value === "Tidak Ada") {
                        sumberPenerangan.value = "Non Listrik";
                        sumberPenerangan.disabled = true;
                      } else {
                        sumberPenerangan.disabled = false;
                      }
                    });
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Tambahkan validasi tambahan
                  addAdditionalValidation();

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();
                });
              </script>
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
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_pengelolaan_sampah, 'tps', 'Pengelolaan Sampah');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Tempat Penampungan Sementara Reduce, Reuse, Recycle (TPS3R)</label>
                    <select name="tps3r" class="form-control" required>
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada, Digunakan">Ada, Digunakan</option>
                      <option value="Ada, Tidak Digunakan">Ada, Tidak Digunakan</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_pengelolaan_sampah, 'tps3r', 'Pengelolaan Sampah');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Bank Sampah di Desa/Kelurahan</label>
                    <select name="bank_sampah" class="form-control" required>
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                      <option value="Non Listrik">Non Listrik</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_pengelolaan_sampah, 'bank_sampah', 'Pengelolaan Sampah');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>
                <?php if ($level != 'admin' && $tahun != 2024): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_pengelolaan_sampah" name="use_previous_pengelolaan_sampah" value="1">
                      <label class="form-check-label" for="use_previous_pengelolaan_sampah">
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
                  // Ambil semua elemen select
                  const tps = document.querySelector('select[name="tps"]');
                  const tps3r = document.querySelector('select[name="tps3r"]');
                  const bankSampah = document.querySelector('select[name="bank_sampah"]');

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_pengelolaan_sampah");

                  // Data tahun sebelumnya
                  const previousData = {
                    tps: "<?php echo htmlspecialchars($previous_pengelolaan_sampah['tps'] ?? ''); ?>",
                    tps3r: "<?php echo htmlspecialchars($previous_pengelolaan_sampah['tps3r'] ?? ''); ?>",
                    bankSampah: "<?php echo htmlspecialchars($previous_pengelolaan_sampah['bank_sampah'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke masing-masing select
                      tps.value = previousData.tps || "";
                      tps3r.value = previousData.tps3r || "";
                      bankSampah.value = previousData.bankSampah || "";

                      // Array select untuk iterasi
                      const selectFields = [tps, tps3r, bankSampah];

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
                      tps.value = "";
                      tps3r.value = "";
                      bankSampah.value = "";

                      // Array select untuk iterasi
                      const selectFields = [tps, tps3r, bankSampah];

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

                  // Fungsi untuk menambahkan validasi tambahan
                  function addAdditionalValidation() {
                    // Validasi logika antar pilihan

                    // Jika TPS tidak ada, maka batasi pilihan TPS3R
                    tps.addEventListener('change', function() {
                      if (this.value === "Tidak Ada") {
                        tps3r.value = "Tidak Ada";
                        tps3r.disabled = true;
                      } else {
                        tps3r.disabled = false;
                      }
                    });

                    // Jika TPS3R tidak ada, maka batasi pilihan Bank Sampah
                    tps3r.addEventListener('change', function() {
                      if (this.value === "Tidak Ada") {
                        bankSampah.value = "Tidak Ada";
                        bankSampah.disabled = true;
                      } else {
                        bankSampah.disabled = false;
                      }
                    });

                    // Tambahan validasi untuk kombinasi pilihan
                    function validateSampahCombination() {
                      const tpsValue = tps.value;
                      const tps3rValue = tps3r.value;
                      const bankSampahValue = bankSampah.value;

                      // Contoh logika validasi
                      if (tpsValue === "Tidak Ada" && tps3rValue === "Tidak Ada" && bankSampahValue === "Tidak Ada") {
                        alert('Perhatian: Semua fasilitas pengelolaan sampah tidak tersedia!');
                      }
                    }

                    // Tambahkan event listener untuk validasi
                    [tps, tps3r, bankSampah].forEach(select => {
                      select.addEventListener('change', validateSampahCombination);
                    });
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Tambahkan validasi tambahan
                  addAdditionalValidation();

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();
                });
              </script>
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
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_sutet, 'sutet_status', 'Wilayah SUTET/SUTT/SUTTAS');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>

                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Pemukiman Di Bawah SUTET/SUTT/SUTTAS</label>
                    <select required name="keberadaan_dibawah_sutet" id="keberadaan_dibawah_sutet" class="form-control"
                      onchange="togglePemukimanInput()">
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_sutet, 'keberadaan_pemukiman', 'Wilayah SUTET/SUTT/SUTTAS');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>

                <div class="form-group mb-3" id="pemukiman_form" style="display: none;">
                  <label class="mb-2">Jumlah Pemukiman di Bawah SUTET/SUTT/SUTTAS</label>
                  <input required name="jumlah_pemukiman_dibawah_sutet" type="number" min="0" class="form-control"
                    placeholder="Isi Dengan Angka" />
                  <?php if ($level != 'admin'): ?>
                    <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                      <?php
                      echo displayPreviousYearData($previous_sutet, 'jumlah_pemukiman', 'Wilayah SUTET/SUTT/SUTTAS');
                      ?>
                    </p>
                  <?php endif; ?>
                </div>

                <?php if ($level != 'admin' && $tahun != 2024): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_sutet" name="use_previous_sutet" value="1">
                      <label class="form-check-label" for="use_previous_sutet">
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
                  // Ambil semua elemen select dan input
                  const sutetStatus = document.getElementById("TPS");
                  const keberadaanDibawahSutet = document.getElementById("keberadaan_dibawah_sutet");
                  const jumlahPemukimanDibawahSutet = document.querySelector('input[name="jumlah_pemukiman_dibawah_sutet"]');
                  const pemukimanForm = document.getElementById("pemukiman_form");

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_sutet");

                  // Data tahun sebelumnya
                  const previousData = {
                    sutetStatus: "<?php echo htmlspecialchars($previous_sutet['sutet_status'] ?? ''); ?>",
                    keberadaanDibawahSutet: "<?php echo htmlspecialchars($previous_sutet['keberadaan_pemukiman'] ?? ''); ?>",
                    jumlahPemukimanDibawahSutet: "<?php echo htmlspecialchars($previous_sutet['jumlah_pemukiman'] ?? ''); ?>"
                  };

                  // Fungsi untuk menampilkan/menyembunyikan input jumlah pemukiman
                  function togglePemukimanInput() {
                    if (keberadaanDibawahSutet.value === "Ada") {
                      pemukimanForm.style.display = "block";
                      jumlahPemukimanDibawahSutet.required = true;
                    } else {
                      pemukimanForm.style.display = "none";
                      jumlahPemukimanDibawahSutet.required = false;
                      jumlahPemukimanDibawahSutet.value = "";
                    }
                  }

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke masing-masing select dan input
                      sutetStatus.value = previousData.sutetStatus || "";
                      keberadaanDibawahSutet.value = previousData.keberadaanDibawahSutet || "";

                      // Atur visibility input pemukiman
                      if (previousData.keberadaanDibawahSutet === "Ada") {
                        pemukimanForm.style.display = "block";
                        jumlahPemukimanDibawahSutet.value = previousData.jumlahPemukimanDibawahSutet || "";
                      } else {
                        pemukimanForm.style.display = "none";
                        jumlahPemukimanDibawahSutet.value = "";
                      }

                      // Array select untuk iterasi
                      const selectFields = [sutetStatus, keberadaanDibawahSutet];

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

                      // Atur input jumlah pemukiman
                      jumlahPemukimanDibawahSutet.setAttribute("readonly", true);
                      jumlahPemukimanDibawahSutet.style.backgroundColor = "#f0f0f0";
                      jumlahPemukimanDibawahSutet.style.cursor = "not-allowed";
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      sutetStatus.value = "";
                      keberadaanDibawahSutet.value = "";
                      pemukimanForm.style.display = "none";
                      jumlahPemukimanDibawahSutet.value = "";

                      // Array select untuk iterasi
                      const selectFields = [sutetStatus, keberadaanDibawahSutet];

                      // Aktifkan kembali semua pilihan dan reset styling
                      selectFields.forEach(select => {
                        for (let i = 0; i < select.options.length; i++) {
                          select.options[i].disabled = false;
                        }

                        select.style.backgroundColor = "";
                        select.style.cursor = "default";
                      });

                      // Reset input jumlah pemukiman
                      jumlahPemukimanDibawahSutet.removeAttribute("readonly");
                      jumlahPemukimanDibawahSutet.style.backgroundColor = "";
                      jumlahPemukimanDibawahSutet.style.cursor = "default";
                    }
                  }

                  // Validasi input jumlah pemukiman
                  function validatePemukimanInput() {
                    jumlahPemukimanDibawahSutet.addEventListener('input', function() {
                      // Hapus karakter non-numerik
                      this.value = this.value.replace(/[^0-9]/g, '');

                      // Batasi panjang input
                      if (this.value.length > 5) {
                        this.value = this.value.slice(0, 5);
                      }

                      // Hapus angka 0 di depan
                      this.value = this.value.replace(/^0+/, '');
                    });

                    // Validasi logika antara status SUTET dan pemukiman
                    sutetStatus.addEventListener('change', function() {
                      if (this.value === "Tidak Ada") {
                        keberadaanDibawahSutet.value = "Tidak Ada";
                        keberadaanDibawahSutet.disabled = true;
                        pemukimanForm.style.display = "none";
                        jumlahPemukimanDibawahSutet.value = "";
                      } else {
                        keberadaanDibawahSutet.disabled = false;
                      }
                    });

                    // Validasi hubungan antara keberadaan dan jumlah pemukiman
                    keberadaanDibawahSutet.addEventListener('change', function() {
                      togglePemukimanInput();

                      if (this.value === "Tidak Ada") {
                        jumlahPemukimanDibawahSutet.value = "0";
                      }
                    });
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Tambahkan validasi input
                  validatePemukimanInput();

                  // Inisialisasi fungsi saat halaman dimuat
                  togglePemukimanInput();
                  populatePreviousData();
                });

                // Fungsi untuk toggle input pemukiman (untuk compatibility dengan atribut onchange di HTML)
                function togglePemukimanInput() {
                  const keberadaanDibawahSutet = document.getElementById("keberadaan_dibawah_sutet");
                  const pemukimanForm = document.getElementById("pemukiman_form");
                  const jumlahPemukimanDibawahSutet = document.querySelector('input[name="jumlah_pemukiman_dibawah_sutet"]');

                  if (keberadaanDibawahSutet.value === "Ada") {
                    pemukimanForm.style.display = "block";
                    jumlahPemukimanDibawahSutet.required = true;
                  } else {
                    pemukimanForm.style.display = "none";
                    jumlahPemukimanDibawahSutet.required = false;
                    jumlahPemukimanDibawahSutet.value = "";
                  }
                }
              </script>

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
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_keberadaan_sungai, 'keberadaan_sungai', 'Keberadaan Sungai');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>

                  <div id="daftar_sungai" style="display: none;">
                    <div class="form-group mb-3">
                      <label class="mb-2">Nama Sungai Yang Melintasi Ke - 1</label>
                      <input required name="nama_sungai_1" type="text" class="form-control"
                        placeholder="Isi Dengan nama sungai">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_keberadaan_sungai, 'nama_sungai_1', 'Keberadaan Sungai');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>

                    <div class="form-group mb-3">
                      <label class="mb-2">Nama Sungai Yang Melintasi Ke - 2</label>
                      <input required name="nama_sungai_2" type="text" class="form-control"
                        placeholder="Isi Dengan nama sungai">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_keberadaan_sungai, 'nama_sungai_2', 'Keberadaan Sungai');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>

                    <div class="form-group mb-3">
                      <label class="mb-2">Nama Sungai Yang Melintasi Ke - 3</label>
                      <input required name="nama_sungai_3" type="text" class="form-control"
                        placeholder="Isi Dengan nama sungai">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_keberadaan_sungai, 'nama_sungai_3', 'Keberadaan Sungai');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>

                    <div class="form-group mb-3">
                      <label class="mb-2">Nama Sungai Yang Melintasi Ke - 4</label>
                      <input required name="nama_sungai_4" type="text" class="form-control"
                        placeholder="Isi Dengan nama sungai">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_keberadaan_sungai, 'nama_sungai_4', 'Keberadaan Sungai');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <?php if ($level != 'admin' && $tahun != 2024): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_keberadaan_sungai" name="use_previous_keberadaan_sungai" value="1">
                      <label class="form-check-label" for="use_previous_keberadaan_sungai">
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
                  // Ambil elemen select dan container daftar sungai
                  const keberadaanSungai = document.getElementById("keberadaan_sungai");
                  const daftarSungai = document.getElementById("daftar_sungai");

                  // Ambil input nama sungai
                  const namaSungai1 = document.querySelector('input[name="nama_sungai_1"]');
                  const namaSungai2 = document.querySelector('input[name="nama_sungai_2"]');
                  const namaSungai3 = document.querySelector('input[name="nama_sungai_3"]');
                  const namaSungai4 = document.querySelector('input[name="nama_sungai_4"]');

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_keberadaan_sungai");

                  // Data tahun sebelumnya
                  const previousData = {
                    keberadaanSungai: "<?php echo htmlspecialchars($previous_keberadaan_sungai['keberadaan_sungai'] ?? ''); ?>",
                    namaSungai1: "<?php echo htmlspecialchars($previous_keberadaan_sungai['nama_sungai_1'] ?? ''); ?>",
                    namaSungai2: "<?php echo htmlspecialchars($previous_keberadaan_sungai['nama_sungai_2'] ?? ''); ?>",
                    namaSungai3: "<?php echo htmlspecialchars($previous_keberadaan_sungai['nama_sungai_3'] ?? ''); ?>",
                    namaSungai4: "<?php echo htmlspecialchars($previous_keberadaan_sungai['nama_sungai_4'] ?? ''); ?>"
                  };

                  // Fungsi untuk menampilkan/menyembunyikan input nama sungai
                  function toggleSungaiInput() {
                    if (keberadaanSungai.value === "Ada") {
                      daftarSungai.style.display = "block";

                      // Set required untuk input nama sungai
                      const sungaiInputs = [namaSungai1, namaSungai2, namaSungai3, namaSungai4];
                      sungaiInputs.forEach(input => input.required = true);
                    } else {
                      daftarSungai.style.display = "none";

                      // Kosongkan dan hapus required dari input nama sungai
                      const sungaiInputs = [namaSungai1, namaSungai2, namaSungai3, namaSungai4];
                      sungaiInputs.forEach(input => {
                        input.value = "";
                        input.required = false;
                      });
                    }
                  }

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke select keberadaan sungai
                      keberadaanSungai.value = previousData.keberadaanSungai || "";

                      // Atur visibility input nama sungai
                      if (previousData.keberadaanSungai === "Ada") {
                        daftarSungai.style.display = "block";

                        // Set nilai input nama sungai
                        namaSungai1.value = previousData.namaSungai1 || "";
                        namaSungai2.value = previousData.namaSungai2 || "";
                        namaSungai3.value = previousData.namaSungai3 || "";
                        namaSungai4.value = previousData.namaSungai4 || "";

                        // Nonaktifkan pilihan lain pada select
                        for (let i = 0; i < keberadaanSungai.options.length; i++) {
                          if (keberadaanSungai.options[i].value !== previousData.keberadaanSungai) {
                            keberadaanSungai.options[i].disabled = true;
                          }
                        }

                        // Styling select
                        keberadaanSungai.style.backgroundColor = "#f0f0f0";
                        keberadaanSungai.style.cursor = "not-allowed";

                        // Set input nama sungai read-only
                        const sungaiInputs = [namaSungai1, namaSungai2, namaSungai3, namaSungai4];
                        sungaiInputs.forEach(input => {
                          input.setAttribute("readonly", true);
                          input.style.backgroundColor = "#f0f0f0";
                          input.style.cursor = "not-allowed";
                        });
                      } else {
                        daftarSungai.style.display = "none";
                      }
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      keberadaanSungai.value = "";
                      daftarSungai.style.display = "none";

                      // Kosongkan input nama sungai
                      const sungaiInputs = [namaSungai1, namaSungai2, namaSungai3, namaSungai4];
                      sungaiInputs.forEach(input => {
                        input.value = "";
                        input.removeAttribute("readonly");
                        input.style.backgroundColor = "";
                        input.style.cursor = "default";
                      });

                      // Aktifkan kembali semua pilihan pada select
                      for (let i = 0; i < keberadaanSungai.options.length; i++) {
                        keberadaanSungai.options[i].disabled = false;
                      }

                      // Reset styling select
                      keberadaanSungai.style.backgroundColor = "";
                      keberadaanSungai.style.cursor = "default";
                    }
                  }

                  // Validasi input nama sungai
                  function validateSungaiInput() {
                    const sungaiInputs = [namaSungai1, namaSungai2, namaSungai3, namaSungai4];

                    sungaiInputs.forEach(input => {
                      input.addEventListener('input', function() {
                        // Hapus karakter selain huruf, spasi, dan tanda hubung
                        this.value = this.value.replace(/[^a-zA-Z\s-]/g, '');

                        // Ubah huruf pertama setiap kata menjadi kapital
                        this.value = this.value.replace(/\b\w/g, char => char.toUpperCase());

                        // Batasi panjang input
                        if (this.value.length > 100) {
                          this.value = this.value.slice(0, 100);
                        }
                      });
                    });
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Tambahkan validasi input
                  validateSungaiInput();

                  // Inisialisasi fungsi saat halaman dimuat
                  toggleSungaiInput();
                  populatePreviousData();
                });

                // Fungsi untuk toggle input sungai (untuk compatibility dengan atribut onchange di HTML)
                function toggleSungaiInput() {
                  const keberadaanSungai = document.getElementById("keberadaan_sungai");
                  const daftarSungai = document.getElementById("daftar_sungai");

                  if (keberadaanSungai.value === "Ada") {
                    daftarSungai.style.display = "block";

                    // Set required untuk input nama sungai
                    const sungaiInputs = document.querySelectorAll('input[name^="nama_sungai_"]');
                    sungaiInputs.forEach(input => input.required = true);
                  } else {
                    daftarSungai.style.display = "none";

                    // Kosongkan dan hapus required dari input nama sungai
                    const sungaiInputs = document.querySelectorAll('input[name^="nama_sung ai_"]');
                    sungaiInputs.forEach(input => {
                      input.value = "";
                      input.required = false;
                    });
                  }
                }
              </script>

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
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_keberadaan_danau, 'keberadaan_danau', 'Keberadaan Danau/Waduk/Situ');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>

                  <div id="daftar_danau" style="display: none;">
                    <div class="form-group mb-3">
                      <label class="mb-2">Nama danau/waduk/situ yang berada di wilayah desa Ke - 1</label>
                      <input required name="nama_danau_1" type="text" class="form-control"
                        placeholder="Isi Dengan nama danau/waduk/situ">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_keberadaan_danau, 'nama_danau_1', 'Keberadaan Danau/Waduk/Situ');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>

                    <div class="form-group mb-3">
                      <label class="mb-2">Nama danau/waduk/situ yang berada di wilayah desa Ke - 2</label>
                      <input required name="nama_danau_2" type="text" class="form-control"
                        placeholder="Isi Dengan nama danau/waduk/situ">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_keberadaan_danau, 'nama_danau_2', 'Keberadaan Danau/Waduk/Situ');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>

                    <div class="form-group mb-3">
                      <label class="mb-2">Nama danau/waduk/situ yang berada di wilayah desa Ke - 3</label>
                      <input required name="nama_danau_3" type="text" class="form-control"
                        placeholder="Isi Dengan nama danau/waduk/situ">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_keberadaan_danau, 'nama_danau_3', 'Keberadaan Danau/Waduk/Situ');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>

                    <div class="form-group mb-3">
                      <label class="mb-2">Nama danau/waduk/situ yang berada di wilayah desa Ke - 4</label>
                      <input required name="nama_danau_4" type="text" class="form-control"
                        placeholder="Isi Dengan nama danau/waduk/situ">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_keberadaan_danau, 'nama_danau_4', 'Keberadaan Danau/Waduk/Situ');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <?php if ($level != 'admin' && $tahun != 2024): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_danau" name="use_previous_danau" value="1">
                      <label class="form-check-label" for="use_previous_danau">
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
                  // Ambil elemen select dan container daftar danau
                  const keberadaanDanau = document.getElementById("keberadaan_danau");
                  const daftarDanau = document.getElementById("daftar_danau");

                  // Ambil input nama danau
                  const namaDanau1 = document.querySelector('input[name="nama_danau_1"]');
                  const namaDanau2 = document.querySelector('input[name="nama_danau_2"]');
                  const namaDanau3 = document.querySelector('input[name="nama_danau_3"]');
                  const namaDanau4 = document.querySelector('input[name="nama_danau_4"]');

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_danau");

                  // Data tahun sebelumnya
                  const previousData = {
                    keberadaanDanau: "<?php echo htmlspecialchars($previous_keberadaan_danau['keberadaan_danau'] ?? ''); ?>",
                    namaDanau1: "<?php echo htmlspecialchars($previous_keberadaan_danau['nama_danau_1'] ?? ''); ?>",
                    namaDanau2: "<?php echo htmlspecialchars($previous_keberadaan_danau['nama_danau_2'] ?? ''); ?>",
                    namaDanau3: "<?php echo htmlspecialchars($previous_keberadaan_danau['nama_danau_3'] ?? ''); ?>",
                    namaDanau4: "<?php echo htmlspecialchars($previous_keberadaan_danau['nama_danau_4'] ?? ''); ?>"
                  };

                  // Fungsi untuk menampilkan/menyembunyikan input nama danau
                  function toggleDanauInput() {
                    if (keberadaanDanau.value === "Ada") {
                      daftarDanau.style.display = "block";

                      // Set required untuk input nama danau
                      const danauInputs = [namaDanau1, namaDanau2, namaDanau3, namaDanau4];
                      danauInputs.forEach(input => input.required = true);
                    } else {
                      daftarDanau.style.display = "none";

                      // Kosongkan dan hapus required dari input nama danau
                      const danauInputs = [namaDanau1, namaDanau2, namaDanau3, namaDanau4];
                      danauInputs.forEach(input => {
                        input.value = "";
                        input.required = false;
                      });
                    }
                  }

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke select keberadaan danau
                      keberadaanDanau.value = previousData.keberadaanDanau || "";

                      // Atur visibility input nama danau
                      if (previousData.keberadaanDanau === "Ada") {
                        daftarDanau.style.display = "block";

                        // Set nilai input nama danau
                        namaDanau1.value = previousData.namaDanau1 || "";
                        namaDanau2.value = previousData.namaDanau2 || "";
                        namaDanau3.value = previousData.namaDanau3 || "";
                        namaDanau4.value = previousData.namaDanau4 || "";

                        // Nonaktifkan pilihan lain pada select
                        for (let i = 0; i < keberadaanDanau.options.length; i++) {
                          if (keberadaanDanau.options[i].value !== previousData.keberadaanDanau) {
                            keberadaanDanau.options[i].disabled = true;
                          }
                        }

                        // Styling select
                        keberadaanDanau.style.backgroundColor = "#f0f0f0";
                        keberadaanDanau.style.cursor = "not-allowed";

                        // Set input nama danau read-only
                        const danauInputs = [namaDanau1, namaDanau2, namaDanau3, namaDanau4];
                        danauInputs.forEach(input => {
                          input.setAttribute("readonly", true);
                          input.style.backgroundColor = "#f0f0f0";
                          input.style.cursor = "not-allowed";
                        });
                      } else {
                        daftarDanau.style.display = "none";
                      }
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      keberadaanDanau.value = "";
                      daftarDanau.style.display = "none";

                      // Kosongkan input nama danau
                      const danauInputs = [namaDanau1, namaDanau2, namaDanau3, namaDanau4];
                      danauInputs.forEach(input => {
                        input.value = "";
                        input.removeAttribute("readonly");
                        input.style.backgroundColor = "";
                        input.style.cursor = "default";
                      });

                      // Aktifkan kembali semua pilihan pada select
                      for (let i = 0; i < keberadaanDanau.options.length; i++) {
                        keberadaanDanau.options[i].disabled = false;
                      }

                      // Reset styling select
                      keberadaanDanau.style.backgroundColor = "";
                      keberadaanDanau.style.cursor = "default";
                    }
                  }

                  // Validasi input nama danau
                  function validateDanauInput() {
                    const danauInputs = [namaDanau1, namaDanau2, namaDanau3, namaDanau4];

                    danauInputs.forEach(input => {
                      input.addEventListener('input', function() {
                        // Hapus karakter selain huruf, spasi, dan tanda hubung
                        this.value = this.value.replace(/[^a-zA-Z\s-]/g, '');

                        // Ubah huruf pertama setiap kata menjadi kapital
                        this.value = this.value.replace(/\b\w/g, char => char.toUpperCase());

                        // Batasi panjang input
                        if (this.value.length > 100) {
                          this.value = this.value.slice(0, 100);
                        }
                      });
                    });
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Tambahkan validasi input
                  validateDanauInput();

                  // Inisialisasi fungsi saat halaman dimuat
                  toggleDanauInput();
                  populatePreviousData();
                });

                // Fungsi untuk toggle input danau (untuk compatibility dengan atribut onchange di HTML)
                function toggleDanauInput() {
                  const keberadaanDanau = document.getElementById("keberadaan_danau");
                  const daftarDanau = document.getElementById("daftar_danau");

                  if (keberadaanDanau.value === "Ada") {
                    daftarDanau.style.display = "block";

                    // Set required untuk input nama danau
                    const danauInputs = document.querySelectorAll('input[name^="nama_danau_"]');
                    danauInputs.forEach(input => input.required = true);
                  } else {
                    daftarDanau.style.display = "none";

                    // Kosongkan dan hapus required dari input nama danau
                    const danauInputs = document.querySelectorAll('input[name^="nama_danau_"]');
                    danauInputs.forEach(input => {
                      input.value = "";
                      input.required = false;
                    });
                  }
                }
              </script>

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
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_keberadaan_pemukiman_bantaran, 'keberadaan_pemukiman', 'Keberadaan Permukiman di Bantaran Sungai');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>

                  <div id="jumlah_pemukiman_bantaran" style="display: none;">
                    <div class="form-group mb-3">
                      <label class="mb-2">Jumlah Pemukiman Di Bantaran Sungai</label>
                      <input required name="pemukiman_bantaran" type="number" min="0" class="form-control"
                        placeholder="Isi Dengan Angka">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_keberadaan_pemukiman_bantaran, 'jumlah_pemukiman', 'Keberadaan Permukiman di Bantaran Sungai');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <?php if ($level != 'admin' && $tahun != 2024): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_keberadaan_pemukiman_bantaran" name="use_previous_keberadaan_pemukiman_bantaran" value="1">
                      <label class="form-check-label" for="use_previous_keberadaan_pemukiman_bantaran">
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
                  // Ambil elemen select dan container jumlah pemukiman
                  const keberadaanPemukimanBantaran = document.getElementById("keberadaan_pemukiman_bantaran");
                  const jumlahPemukimanBantaran = document.getElementById("jumlah_pemukiman_bantaran");

                  // Ambil input jumlah pemukiman
                  const pemukimanBantaran = document.querySelector('input[name="pemukiman_bantaran"]');

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_keberadaan_pemukiman_bantaran");

                  // Data tahun sebelumnya
                  const previousData = {
                    keberadaanPemukiman: "<?php echo htmlspecialchars($previous_keberadaan_pemukiman_bantaran['keberadaan_pemukiman'] ?? ''); ?>",
                    jumlahPemukiman: "<?php echo htmlspecialchars($previous_keberadaan_pemukiman_bantaran['jumlah_pemukiman'] ?? ''); ?>"
                  };

                  // Fungsi untuk menampilkan/menyembunyikan input jumlah pemukiman
                  function toggleBantaranInput() {
                    if (keberadaanPemukimanBantaran.value === "Ada") {
                      jumlahPemukimanBantaran.style.display = "block";
                      pemukimanBantaran.required = true;
                    } else {
                      jumlahPemukimanBantaran.style.display = "none";
                      pemukimanBantaran.required = false;
                      pemukimanBantaran.value = "";
                    }
                  }

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke select keberadaan pemukiman
                      keberadaanPemukimanBantaran.value = previousData.keberadaanPemukiman || "";

                      // Atur visibility input jumlah pemukiman
                      if (previousData.keberadaanPemukiman === "Ada") {
                        jumlahPemukimanBantaran.style.display = "block";
                        pemukimanBantaran.value = previousData.jumlahPemukiman || "";

                        // Nonaktifkan pilihan lain pada select
                        for (let i = 0; i < keberadaanPemukimanBantaran.options.length; i++) {
                          if (keberadaanPemukimanBantaran.options[i].value !== previousData.keberadaanPemukiman) {
                            keberadaanPemukimanBantaran.options[i].disabled = true;
                          }
                        }

                        // Styling select
                        keberadaanPemukimanBantaran.style.backgroundColor = "#f0f0f0";
                        keberadaanPemukimanBantaran.style.cursor = "not-allowed";

                        // Set input jumlah pemukiman read-only
                        pemukimanBantaran.setAttribute("readonly", true);
                        pemukimanBantaran.style.backgroundColor = "#f0f0f0";
                        pemukimanBantaran.style.cursor = "not-allowed";
                      } else {
                        jumlahPemukimanBantaran.style.display = "none";
                      }
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      keberadaanPemukimanBantaran.value = "";
                      jumlahPemukimanBantaran.style.display = "none";

                      // Kosongkan input jumlah pemukiman
                      pemukimanBantaran.value = "";
                      pemukimanBantaran.removeAttribute("readonly");
                      pemukimanBantaran.style.backgroundColor = "";
                      pemukimanBantaran.style.cursor = "default";

                      // Aktifkan kembali semua pilihan pada select
                      for (let i = 0; i < keberadaanPemukimanBantaran.options.length; i++) {
                        keberadaanPemukimanBantaran.options[i].disabled = false;
                      }

                      // Reset styling select
                      keberadaanPemukimanBantaran.style.backgroundColor = "";
                      keberadaanPemukimanBantaran.style.cursor = "default";
                    }
                  }

                  // Validasi input jumlah pemukiman
                  function validatePemukimanInput() {
                    pemukimanBantaran.addEventListener('input', function() {
                      // Hapus karakter non-numerik
                      this.value = this.value.replace(/[^0-9]/g, '');

                      // Batasi panjang input
                      if (this.value.length > 5) {
                        this.value = this.value.slice(0, 5);
                      }

                      // Hapus angka 0 di depan
                      this.value = this.value.replace(/^0+/, '');
                    });

                    // Tambahkan validasi logika
                    function validatePemukimanLogic() {
                      // Contoh validasi: Batasi jumlah pemukiman
                      if (parseInt(pemukimanBantaran.value || 0) > 10000) {
                        alert('Jumlah pemukiman tampaknya terlalu besar. Mohon periksa kembali.');
                        pemukimanBantaran.value = '';
                      }
                    }

                    pemukimanBantaran.addEventListener('change', validatePemukimanLogic);
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Tambahkan validasi input
                  validatePemukimanInput();

                  // Inisialisasi fungsi saat halaman dimuat
                  toggleBantaranInput();
                  populatePreviousData();
                });

                // Fungsi untuk toggle input bantaran (untuk compatibility dengan atribut onchange di HTML)
                function toggleBantaranInput() {
                  const keberadaanPemukimanBantaran = document.getElementById("keberadaan_pemukiman_bantaran");
                  const jumlahPemukimanBantaran = document.getElementById("jumlah_pemukiman_bantaran");
                  const pemukimanBantaran = document.querySelector('input[name="pemukiman_bantaran"]');

                  if (keberadaanPemukimanBantaran.value === "Ada") {
                    jumlahPemukimanBantaran.style.display = "block";
                    pemukimanBantaran.required = true;
                  } else {
                    jumlahPemukimanBantaran.style.display = "none";
                    pemukimanBantaran.required = false;
                    pemukimanBantaran.value = "";
                  }
                }
              </script>

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
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_embung_mata_air, 'jumlah_embung', 'Banyaknya Embung dan Lokasi Mata Air');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Lokasi Mata Air</label>
                    <select name="mata_air" id="mata_air" class="form-control">
                      <option value="" disabled selected>-- Pilih Dengan Benar --</option>
                      <option value="Ada, Dikelola">ADA, DIKELOLA </option>
                      <option value="Ada, Tidak Dikelola">ADA, TIDAK DIKELOLA</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_embung_mata_air, 'lokasi_mata_air', 'Banyaknya Embung dan Lokasi Mata Air');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>

                <?php if ($level != 'admin' && $tahun != 2024): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_embung_mata_air"
                        name="use_previous_embung_mata_air" value="1">
                      <label class="form-check-label" for="use_previous_embung_mata_air">
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
                  // Ambil elemen input dan select
                  const jumlahEmbung = document.querySelector('input[name="jumlah_embung"]');
                  const mataAir = document.getElementById("mata_air");

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_embung_mata_air");

                  // Data tahun sebelumnya
                  const previousData = {
                    jumlahEmbung: "<?php echo htmlspecialchars($previous_embung_mata_air['jumlah_embung'] ?? ''); ?>",
                    mataAir: "<?php echo htmlspecialchars($previous_embung_mata_air['lokasi_mata_air'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke input dan select
                      jumlahEmbung.value = previousData.jumlahEmbung || "";
                      mataAir.value = previousData.mataAir || "";

                      // Buat input dan select menjadi read-only
                      const inputFields = [jumlahEmbung];
                      const selectFields = [mataAir];

                      inputFields.forEach(input => {
                        input.setAttribute("readonly", true);
                        input.style.backgroundColor = "#f0f0f0";
                        input.style.cursor = "not-allowed";
                      });

                      selectFields.forEach(select => {
                        // Nonaktifkan pilihan lain
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
                      jumlahEmbung.value = "";
                      mataAir.value = "";

                      // Hapus atribut readonly dari input
                      const inputFields = [jumlahEmbung];
                      const selectFields = [mataAir];

                      inputFields.forEach(input => {
                        input.removeAttribute("readonly");
                        input.style.backgroundColor = "";
                        input.style.cursor = "default";
                      });

                      selectFields.forEach(select => {
                        // Aktifkan kembali semua pilihan
                        for (let i = 0; i < select.options.length; i++) {
                          select.options[i].disabled = false;
                        }

                        select.style.backgroundColor = "";
                        select.style.cursor = "default";
                      });
                    }
                  }

                  // Validasi input jumlah embung
                  function validateEmbungInput() {
                    jumlahEmbung.addEventListener('input', function() {
                      // Hapus karakter non-numerik
                      this.value = this.value.replace(/[^0-9]/g, '');

                      // Batasi panjang input
                      if (this.value.length > 5) {
                        this.value = this.value.slice(0, 5);
                      }

                      // Hapus angka 0 di depan
                      this.value = this.value.replace(/^0+/, '');
                    });

                    // Tambahkan validasi logika
                    function validateEmbungLogic() {
                      const embungValue = parseInt(jumlahEmbung.value || 0);

                      // Contoh validasi: Batasi jumlah embung
                      if (embungValue > 100) {
                        alert('Jumlah embung tampaknya terlalu besar. Mohon periksa kembali.');
                        jumlahEmbung.value = '';
                      }
                    }

                    jumlahEmbung.addEventListener('change', validateEmbungLogic);
                  }

                  // Validasi hubungan antara mata air dan embung
                  function validateMataAirLogic() {
                    mataAir.addEventListener('change', function() {
                      // Jika mata air tidak ada, berikan peringatan jika jumlah embung > 0
                      if (this.value === "Tidak Ada") {
                        if (parseInt(jumlahEmbung.value || 0) > 0) {
                          alert('Perhatian: Anda menginput jumlah embung lebih dari 0 meskipun tidak ada mata air.');
                        }
                      }
                    });

                    jumlahEmbung.addEventListener('change', function() {
                      // Jika jumlah embung > 0, pastikan mata air tidak "Tidak Ada"
                      if (parseInt(this.value || 0) > 0) {
                        if (mataAir.value === "Tidak Ada") {
                          alert('Perhatian: Anda menginput jumlah embung lebih dari 0 meskipun tidak ada mata air.');
                        }
                      }
                    });
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Tambahkan validasi input
                  validateEmbungInput();
                  validateMataAirLogic();

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();
                });
              </script>
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
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_permukiman_kumuh, 'keberadaan_kumuh', 'Keberadaan Permukiman Kumuh');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                  <div id="jumlah_pemukiman_kumuh" style="display: none;">
                    <div class="form-group mb-3">
                      <label class="mb-2">Jumlah Pemukiman Kumuh</label>
                      <input required name="jumlah_pemukiman_kumuh" type="number" class="form-control"
                        placeholder="Isi Dengan Angka">
                      <?php if ($level != 'admin'): ?>
                        <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                          <?php
                          echo displayPreviousYearData($previous_permukiman_kumuh, 'jumlah_kumuh', 'Keberadaan Permukiman Kumuh');
                          ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <?php if ($level != 'admin' && $tahun != 2024): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_permukiman_kumuh"
                        name="use_previous_permukiman_kumuh" value="1">
                      <label class="form-check-label" for="use_previous_permukiman_kumuh">
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
                  // Ambil elemen select dan container jumlah pemukiman
                  const keberadaanPemukimanKumuh = document.getElementById("keberadaan_pemukiman_kumuh");
                  const jumlahPemukimanKumuh = document.getElementById("jumlah_pemukiman_kumuh");

                  // Ambil input jumlah pemukiman kumuh
                  const pemukimanKumuh = document.querySelector('input[name="jumlah_pemukiman_kumuh"]');

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_permukiman_kumuh");

                  // Data tahun sebelumnya
                  const previousData = {
                    keberadaanKumuh: "<?php echo htmlspecialchars($previous_permukiman_kumuh['keberadaan_kumuh'] ?? ''); ?>",
                    jumlahKumuh: "<?php echo htmlspecialchars($previous_permukiman_kumuh['jumlah_kumuh'] ?? ''); ?>"
                  };

                  // Fungsi untuk menampilkan/menyembunyikan input jumlah pemukiman kumuh
                  function toggleSungaiContainer() {
                    if (keberadaanPemukimanKumuh.value === "Ada") {
                      jumlahPemukimanKumuh.style.display = "block";
                      pemukimanKumuh.required = true;
                    } else {
                      jumlahPemukimanKumuh.style.display = "none";
                      pemukimanKumuh.required = false;
                      pemukimanKumuh.value = "";
                    }
                  }

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke select keberadaan pemukiman kumuh
                      keberadaanPemukimanKumuh.value = previousData.keberadaanKumuh || "";

                      // Atur visibility input jumlah pemukiman kumuh
                      if (previousData.keberadaanKumuh === "Ada") {
                        jumlahPemukimanKumuh.style.display = "block";
                        pemukimanKumuh.value = previousData.jumlahKumuh || "";

                        // Nonaktifkan pilihan lain pada select
                        for (let i = 0; i < keberadaanPemukimanKumuh.options.length; i++) {
                          if (keberadaanPemukimanKumuh.options[i].value !== previousData.keberadaanKumuh) {
                            keberadaanPemukimanKumuh.options[i].disabled = true;
                          }
                        }

                        // Styling select
                        keberadaanPemukimanKumuh.style.backgroundColor = "#f0f0f0";
                        keberadaanPemukimanKumuh.style.cursor = "not-allowed";

                        // Set input jumlah pemukiman kumuh read-only
                        pemukimanKumuh.setAttribute("readonly", true);
                        pemukimanKumuh.style.backgroundColor = "#f0f0f0";
                        pemukimanKumuh.style.cursor = "not-allowed";
                      } else {
                        jumlahPemukimanKumuh.style.display = "none";
                      }
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      keberadaanPemukimanKumuh.value = "";
                      jumlahPemukimanKumuh.style.display = "none";

                      // Kosongkan input jumlah pemukiman kumuh
                      pemukimanKumuh.value = "";
                      pemukimanKumuh.removeAttribute("readonly");
                      pemukimanKumuh.style.backgroundColor = "";
                      pemukimanKumuh.style.cursor = "default";

                      // Aktifkan kembali semua pilihan pada select
                      for (let i = 0; i < keberadaanPemukimanKumuh.options.length; i++) {
                        keberadaanPemukimanKumuh.options[i].disabled = false;
                      }

                      // Reset styling select
                      keberadaanPemukimanKumuh.style.backgroundColor = "";
                      keberadaanPemukimanKumuh.style.cursor = "default";
                    }
                  }

                  // Validasi input jumlah pemukiman kumuh
                  function validatePemukimanKumuhInput() {
                    pemukimanKumuh.addEventListener('input', function() {
                      // Hapus karakter non-numerik
                      this.value = this.value.replace(/[^0-9]/g, '');

                      // Batasi panjang input
                      if (this.value.length > 5) {
                        this.value = this.value.slice(0, 5);
                      }

                      // Hapus angka 0 di depan
                      this.value = this.value.replace(/^0+/, '');
                    });

                    // Tambahkan validasi logika
                    function validatePemukimanKumuhLogic() {
                      const pemukimanValue = parseInt(pemukimanKumuh.value || 0);

                      // Contoh validasi: Batasi jumlah pemukiman kumuh
                      if (pemukimanValue > 5000) {
                        alert('Jumlah pemukiman kumuh tampaknya terlalu besar. Mohon periksa kembali.');
                        pemukimanKumuh.value = '';
                      }

                      // Validasi persentase pemukiman kumuh
                      function validatePemukimanPercentage() {
                        // Misalkan total keluarga di desa adalah 10000
                        const totalKeluarga = 10000;
                        const persentasePemukimanKumuh = (pemukimanValue / totalKeluarga) * 100;

                        if (persentasePemukimanKumuh > 30) {
                          alert('Persentase pemukiman kumuh melebihi 30% dari total keluarga. Mohon periksa kembali.');
                        }
                      }

                      validatePemukimanPercentage();
                    }

                    pemukimanKumuh.addEventListener('change', validatePemukimanKumuhLogic);
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Tambahkan validasi input
                  validatePemukimanKumuhInput();

                  // Inisialisasi fungsi saat halaman dimuat
                  toggleSungaiContainer();
                  populatePreviousData();
                });

                // Fungsi untuk toggle input pemukiman kumuh (untuk compatibility dengan atribut onchange di HTML)
                function toggleSungaiContainer() {
                  const keberadaanPemukimanKumuh = document.getElementById("keberadaan_pemukiman_kumuh");
                  const jumlahPemukimanKumuh = document.getElementById("jumlah_pemukiman_kumuh");
                  const pemukimanKumuh = document.querySelector('input[name="jumlah_pemukiman_kumuh"]');

                  if (keberadaanPemukimanKumuh.value === "Ada") {
                    jumlahPemukimanKumuh.style.display = "block";
                    pemukimanKumuh.required = true;
                  } else {
                    jumlahPemukimanKumuh.style.display = "none";
                    pemukimanKumuh.required = false;
                    pemukimanKumuh.value = "";
                  }
                }
              </script>

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
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_lokasi_penggalian, 'keberadaan_galian', 'Keberadaan Lokasi Penggalian Golongan C');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>
                <?php if ($level != 'admin' && $tahun != 2024): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_lokasi_penggalian"
                        name="use_previous_lokasi_penggalian" value="1">
                      <label class="form-check-label" for="use_previous_lokasi_penggalian">
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
                  // Ambil elemen select untuk lokasi penggalian
                  const lokasiPenggalian = document.getElementById("TPS");

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_lokasi_penggalian");

                  // Data tahun sebelumnya
                  const previousData = {
                    keberadaanGalian: "<?php echo htmlspecialchars($previous_lokasi_penggalian['keberadaan_galian'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke select lokasi penggalian
                      lokasiPenggalian.value = previousData.keberadaanGalian || "";

                      // Nonaktifkan pilihan lain pada select
                      for (let i = 0; i < lokasiPenggalian.options.length; i++) {
                        if (lokasiPenggalian.options[i].value !== previousData.keberadaanGalian) {
                          lokasiPenggalian.options[i].disabled = true;
                        }
                      }

                      // Styling select
                      lokasiPenggalian.style.backgroundColor = "#f0f0f0";
                      lokasiPenggalian.style.cursor = "not-allowed";
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      lokasiPenggalian.value = ""; // Kembali ke pilihan default

                      // Aktifkan kembali semua pilihan
                      for (let i = 0; i < lokasiPenggalian.options.length; i++) {
                        lokasiPenggalian.options[i].disabled = false;
                      }

                      // Reset styling select
                      lokasiPenggalian.style.backgroundColor = "";
                      lokasiPenggalian.style.cursor = "default";
                    }
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();
                });
              </script>
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
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_prasarana_kebersihan, 'jumlah_prasarana', 'Jumlah Sarana Prasarana Kebersihan');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>

                <?php if ($level != 'admin' && $tahun != 2024): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_prasarana_kebersihan"
                        name="use_previous_prasarana_kebersihan" value="1">
                      <label class="form-check-label" for="use_previous_prasarana_kebersihan">
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
                  // Ambil elemen input prasarana kebersihan
                  const prasaranaKebersihan = document.querySelector('input[name="prasarana_kebersihan"]');

                  // Checkbox untuk menggunakan data tahun sebelumnya
                  const usePreviousCheckbox = document.getElementById("use_previous_prasarana_kebersihan");

                  // Data tahun sebelumnya
                  const previousData = {
                    jumlahPrasarana: "<?php echo htmlspecialchars($previous_prasarana_kebersihan['jumlah_prasarana'] ?? ''); ?>"
                  };

                  // Fungsi untuk mengatur data tahun sebelumnya ke form
                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      // Set nilai ke input prasarana kebersihan
                      prasaranaKebersihan.value = previousData.jumlahPrasarana || "";

                      // Buat input menjadi read-only
                      prasaranaKebersihan.setAttribute("readonly", true);
                      prasaranaKebersihan.style.backgroundColor = "#f0f0f0";
                      prasaranaKebersihan.style.cursor = "not-allowed";
                    } else {
                      // Reset form jika checkbox tidak dicentang
                      prasaranaKebersihan.value = "";

                      // Hapus atribut readonly
                      prasaranaKebersihan.removeAttribute("readonly");
                      prasaranaKebersihan.style.backgroundColor = "";
                      prasaranaKebersihan.style.cursor = "default";
                    }
                  }

                  // Event listener untuk checkbox
                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Inisialisasi saat halaman dimuat
                  populatePreviousData();
                });
              </script>
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
                    <?php if ($level != 'admin'): ?>
                      <p style="font-size: 12px; margin-top: 10px; margin-left: 5px;">
                        <?php
                        echo displayPreviousYearData($previous_rumah_tidak_layak_huni, 'jumlah_rumah', 'Jumlah Rumah Tidak Layak Huni');
                        ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>

                <?php if ($level != 'admin' && $tahun != 2024): ?>
                  <!-- Pilihan untuk menggunakan data tahun sebelumnya -->
                  <div class="form-group mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="use_previous_rumah_tidak_layak_huni"
                        name="use_previous_rumah_tidak_layak_huni" value="1">
                      <label class="form-check-label" for="use_previous_rumah_tidak_layak_huni">
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
                  const rumahTidakLayakHuni = document.querySelector('input[name="rumah_tidak_layak_huni"]');
                  const usePreviousCheckbox = document.getElementById("use_previous_rumah_tidak_layak_huni");

                  const previousData = {
                    jumlahRumah: "<?php echo htmlspecialchars($previous_rumah_tidak_layak_huni['jumlah_rumah'] ?? ''); ?>"
                  };

                  function populatePreviousData() {
                    if (usePreviousCheckbox.checked) {
                      rumahTidakLayakHuni.value = previousData.jumlahRumah || "";
                      rumahTidakLayakHuni.setAttribute("readonly", true);
                      rumahTidakLayakHuni.style.backgroundColor = "#f0f0f0";
                      rumahTidakLayakHuni.style.cursor = "not-allowed";
                    } else {
                      rumahTidakLayakHuni.value = "";
                      rumahTidakLayakHuni.removeAttribute("readonly");
                      rumahTidakLayakHuni.style.backgroundColor = "";
                      rumahTidakLayakHuni.style.cursor = "default";
                    }
                  }

                  // Validasi sederhana
                  function validateInput() {
                    rumahTidakLayakHuni.addEventListener('input', function() {
                      // Hapus karakter non-numerik
                      this.value = this.value.replace(/[^0-9]/g, '');

                      // Batasi panjang input
                      if (this.value.length > 5) {
                        this.value = this.value.slice(0, 5);
                      }
                    });
                  }

                  usePreviousCheckbox.addEventListener("change", populatePreviousData);

                  // Inisialisasi
                  populatePreviousData();
                  validateInput();
                });
              </script>
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