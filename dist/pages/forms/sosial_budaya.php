<?php
include_once "../../config/conn.php";
include "../../config/session.php";
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
              <form action="" method="post">
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="masjid" class="form-label">Masjid</label>
                    <input type="number" class="form-control" id="masjid" placeholder="Masukkan jumlah">
                  </div>
                  <div class="col-md-6">
                    <label for="pura" class="form-label">Pura</label>
                    <input type="number" class="form-control" id="pura" placeholder="Masukkan jumlah">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="musala" class="form-label">Surau/Langgar/Musala</label>
                    <input type="number" class="form-control" id="musala" placeholder="Masukkan jumlah">
                  </div>
                  <div class="col-md-6">
                    <label for="wihara" class="form-label">Wihara</label>
                    <input type="number" class="form-control" id="wihara" placeholder="Masukkan jumlah">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="kristen" class="form-label">Gereja Kristen</label>
                    <input type="number" class="form-control" id="kristen" placeholder="Masukkan jumlah">
                  </div>
                  <div class="col-md-6">
                    <label for="kelenteng" class="form-label">Kelenteng</label>
                    <input type="number" class="form-control" id="kelenteng" placeholder="Masukkan jumlah">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="katolik" class="form-label">Gereja Katolik</label>
                    <input type="number" class="form-control" id="katolik" placeholder="Masukkan jumlah">
                  </div>
                  <div class="col-md-6">
                    <label for="basarah" class="form-label">Balai Basarah</label>
                    <input type="number" class="form-control" id="basarah" placeholder="Masukkan jumlah">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="kapel" class="form-label">Kapel</label>
                    <input type="number" class="form-control" id="kapel" placeholder="Masukkan jumlah">
                  </div>
                  <div class="col-md-6">
                    <label for="lainnya" class="form-label">Lainnya</label>
                    <input type="text" class="form-control" id="lainnya" placeholder="Tuliskan jenis tempat ibadah lainnya">
                    <input type="number" class="form-control mt-2" id="lainnyaInput" placeholder="Masukkan jumlah" style="display: none;">
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

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
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
              <form action="" method="post">
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="tuna-netra" class="form-label">Jumlah tuna netra (buta)</label>
                    <input type="number" class="form-control" id="tuna-netra" placeholder="Masukkan jumlah">
                  </div>
                  <div class="col-md-6">
                    <label for="tuna-rungu" class="form-label">Jumlah tuna rungu (tuli)</label>
                    <input type="number" class="form-control" id="tuna-rungu" placeholder="Masukkan jumlah">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="tuna-wicara" class="form-label">Jumlah tuna wicara (bisu)</label>
                    <input type="number" class="form-control" id="tuna-wicara" placeholder="Masukkan jumlah">
                  </div>
                  <div class="col-md-6">
                    <label for="tuna-rungu-wicara" class="form-label">Jumlah tuna rungu-wicara (tuli-bisu)</label>
                    <input type="number" class="form-control" id="tuna-rungu-wicara" placeholder="Masukkan jumlah">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="tuna-daksa" class="form-label">Jumlah tuna daksa (disabilitas tubuh)</label>
                    <input type="number" class="form-control" id="tuna-daksa" placeholder="Masukkan jumlah">
                  </div>
                  <div class="col-md-6">
                    <label for="tuna-grahita" class="form-label">Jumlah tuna grahita (keterbelakangan mental)</label>
                    <input type="number" class="form-control" id="tuna-grahita" placeholder="Masukkan jumlah">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="tuna-laras" class="form-label">Jumlah tuna laras (eks-sakit jiwa)</label>
                    <input type="number" class="form-control" id="tuna-laras" placeholder="Masukkan jumlah">
                  </div>
                  <div class="col-md-6">
                    <label for="tuna-eks-kusta" class="form-label">Jumlah tuna eks-sakit kusta</label>
                    <input type="number" class="form-control" id="tuna-eks-kusta" placeholder="Masukkan jumlah">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="tuna-ganda" class="form-label">Jumlah tuna ganda (fisik-mental)</label>
                    <input type="number" class="form-control" id="tuna-ganda" placeholder="Masukkan jumlah">
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
              <button type="button" class="btn btn-tool" data-bs-toggle="modalRuangPublik" data-bs-target="#modal">
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
              <form action="" method="post">
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
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak ada</option>
                    </select>
                  </div>
                  <div class="col-12 mb-3">
                    <label for="nonGreenSpace" class="form-label">Ruang Terbuka Non Hijau (RTNH):</label>
                    <select class="form-select" id="nonGreenSpace" name="nonGreenSpace">
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak ada</option>
                    </select>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">
                  <i class="fas fa-save"></i> &nbsp; Simpan
                </button>
              </form>

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