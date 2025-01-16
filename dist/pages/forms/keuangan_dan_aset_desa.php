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
            window.location.href = "keuangan_dan_aset_desa.php";
          });
        } else if (status === 'error') {
          Swal.fire({
            title: "Gagal!",
            text: "Terjadi kesalahan saat menambahkan data.",
            icon: "error",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "keuangan_dan_aset_desa.php";
          });
        } else if (status === 'warning') {
          Swal.fire({
            title: "Peringatan!",
            text: "Mohon lengkapi semua data.",
            icon: "warning",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "keuangan_dan_aset_desa.php";
          });
        }
      </script>
    <?php endif; ?>

    <main class="app-main"> <!--begin::App Content Header-->
      <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Keuangan dan Aset Desa</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Keuangan dan Aset Desa
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
              <h3 class="card-title">Tanah Kas Desa</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalKAS">
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
              <form action="../../handlers/form_tanah_kas_desa.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Luas Tanah Kas Desa (Hektar)</label>
                    <p>1. Tanah Bengkok</p>
                    <input type="number" step="0.01" name="tanah_bengkok" class="form-control mb-3" placeholder="--- Masukkan angka (desimal) ---" required>
                    <p>2. Tanah Titi Sara</p>
                    <input type="number" step="0.01" name="tanah_titi_sara" class="form-control mb-3" placeholder="--- Masukkan angka (desimal) ---" required>
                    <p>3. Kebun Desa</p>
                    <input type="number" step="0.01" name="kebun_desa" class="form-control mb-3" placeholder="--- Masukkan angka (desimal) ---" required>
                    <p>4. Sawah Desa</p>
                    <input type="number" step="0.01" name="sawah_desa" class="form-control mb-3" placeholder="--- Masukkan angka (desimal) ---" required>
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
            <div class="modal fade" id="modalKAS" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi luas Tanah Kas Desa (Hektar) dalam angka berbentuk desimal.</li>
                      <li>Isi luas Tanah Bengkok.</li>
                      <li>Isi luas Tanah Titi Sara.</li>
                      <li>Isi luas Kebun Desa.</li>
                      <li>Isi luas Sawah Desa.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!--end::Row-->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Pemanfaatan Sistem Informasi Desa dan Sistem Keuangan Desa</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalpemanfaatan">
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
              <form action="../../handlers/form_pemanfaatan_sistem.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Sistem Informasi Desa</label>
                    <select name="keberadaan_sistem_informasi_desa" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada, Digunakan">Ada, Digunakan</option>
                      <option value="Ada, Jarang digunakan">Ada, Jarang digunakan</option>
                      <option value="Ada, Tidak digunakan">Ada, Tidak digunakan</option>
                      <option value="Tidak ada">Tidak ada</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Sistem Keuangan Desa</label>
                    <select name="keberadaan_sistem_keuangan_desa" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada, Digunakan">Ada, Digunakan</option>
                      <option value="Ada, Jarang digunakan">Ada, Jarang digunakan</option>
                      <option value="Ada, Tidak digunakan">Ada, Tidak digunakan</option>
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
              <!-- /.row -->
            </div>
            <!-- Modal Info -->
            <div class="modal fade" id="modalpemanfaatan" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih yang sesuai untuk keberadaan sistem informasi desa.</li>
                      <li>Pilih yang sesuai untuk keberadaan sistem keuangan desa.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!--end::Row-->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Kepemilikan Badan Usaha Dan Aset Desa</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalbadanusaha">
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
              <form action="../../handlers/form_badan_usaha_aset_desa.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Jumlah unit usaha BUMDes</label>
                    <input type="number" name="jumlah_unit_usaha_bumdes" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Tanah kas desa/ulayat</label>
                    <select name="tanah_kas_desa_ulayat" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Tambatan perahu</label>
                    <select name="tambatan_perahu" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Pasar desa</label>
                    <select name="pasar_desa" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Bangunan milik desa</label>
                    <select name="bangunan_milik_desa" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Hutan milik desa</label>
                    <select name="hutan_milik_desa" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Mata air milik desa</label>
                    <select name="mata_air_milik_desa" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Tempat wisata/Pemandian umum</label>
                    <select name="tempat_wisata_pemandian_umum" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Aset lainnya milik desa</label>
                    <select name="aset_lainnya_milik_desa" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
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
              <!-- /.row -->
            </div>
            <!-- Modal Info -->
            <div class="modal fade" id="modalbadanusaha" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih <b>Ada</b> atau <b>Tidak Ada</b>, sesuai dengan kepemilikan badan usaha dan aset desa.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!--end::Row-->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Ketersedian RPJMDes dan RKPDes</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalrpjmdes">
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
              <form action="../../handlers/form_ketersediaan_rpjmdes_rkpdes.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Ketersediaan RPJMDes</label>
                    <select name="ketersediaan_rpjmdes" id="ketersediaan_rpjmdes" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                  <div class="form-group mb-3" id="tahun_rpjmdes_awal" style="display: none;">
                    <label class="mb-2">Periode Tahun Awal RPJMDes</label>
                    <input type="number" name="tahun_awal_rpjmdes" class="form-control" placeholder="--- Masukkan Tahun ---">
                  </div>
                  <div class="form-group mb-3" id="tahun_rpjmdes_akhir" style="display: none;">
                    <label class="mb-2">Periode Tahun Akhir RPJMDes</label>
                    <input type="number" name="tahun_akhir_rpjmdes" class="form-control" placeholder="--- Masukkan Tahun ---">
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Ketersediaan RKPDes</label>
                    <select name="ketersediaan_rkpdes" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
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
              <!-- /.row -->
            </div>
            <!-- Modal Info -->
            <div class="modal fade" id="modalrpjmdes" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih <b>Ada</b> atau <b>Tidak Ada</b> untuk ketersediaan RPJMDes.</li>
                      <li>Jika memilih <b>Ada</b>, isi <b>Tahun Awal</b> dan <b>Tahun Akhir</b>.</li>
                      <li>Pilih <b>Ada</b> atau <b>Tidak Ada</b> untuk ketersediaan RKPDes.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>

            <script>
              document.getElementById('ketersediaan_rpjmdes').addEventListener('change', function() {
                const display = this.value === 'Ada' ? 'block' : 'none';
                document.getElementById('tahun_rpjmdes_awal').style.display = display;
                document.getElementById('tahun_rpjmdes_akhir').style.display = display;
              });
            </script>
          </div>

          <!--end::Row-->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Peraturan Yang dimiliki Desa</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalperaturan">
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
              <form action="../../handlers/form_peraturan_desa.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Jumlah Peraturan Yang Dimiliki Desa</label>
                    <input type="number" name="jumlah_peraturan_yang_dimiliki_desa" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Jumlah Peraturan Kepala Desa</label>
                    <input type="number" name="jumlah_peraturan_kepala_desa" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
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
            <div class="modal fade" id="modalperaturan" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi jumlah Peraturan Yang Dimiliki Desa.</li>
                      <li>Isi jumlah Peraturan Kepala Desa.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!--end::Row-->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Kerjasama Yang dilakukan Pemerintah Desa (Kerjasama Antar Desa dan dengan Pihak Ketiga)</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalkerjasama">
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
              <form action="../../handlers/form_kerjasama_desa.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Kerjasama Antar Desa</label>
                    <select name="keberadaan_kerjasama_antar_desa" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Kerjasama Desa dengan Pihak Ketiga</label>
                    <select name="keberadaan_kerjasama_desa_dengan_pihak_ketiga" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
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
              <!-- /.row -->
            </div>
            <!-- Modal Info -->
            <div class="modal fade" id="modalkerjasama" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih <b>Ada</b> atau <b>Tidak Ada</b>, Keberadaan Kerjasama Antar Desa.</li>
                      <li>Pilih <b>Ada</b> atau <b>Tidak Ada</b>, Keberadaan Kerjasama Desa dengan Pihak Ketiga.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!--end::Row-->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Keberadaan Pendamping Lokal Desa</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalpendamping">
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
              <form action="../../handlers/form_pendamping_lokal_desa.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan pendamping lokal desa</label>
                    <select name="keberadaan_pendamping_lokal_desa" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada, Aktif">Ada, Aktif</option>
                      <option value="Ada, Tidak Aktif">Ada, Tidak Aktif</option>
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
            <div class="modal fade" id="modalpendamping" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih <b>Ada, Aktif</b>, <b>Ada, Tidak Aktif</b>, atau <b>Tidak Ada</b>, sesuai dengan keberadaan pendamping lokal desa.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!--end::Row-->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Keberadaan Kader Pembangunan Manusia (KPM)</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalkader">
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
              <form action="../../handlers/form_kpm.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan Kader Pembangunan Manusia (KPM)</label>
                    <select name="keberadaan_kader_pembangunan_manusia" id="kpm" class="form-control" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada, Aktif">Ada, Aktif</option>
                      <option value="Ada, Tidak Aktif">Ada, Tidak Aktif</option>
                      <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                  </div>
                </div>
                <div class="form-group mb-3 KaderInfo" style="display: none;">
                  <label class="mb-2">Apakah ada KPM yang mendapatkan pembinaan dari Pemerintah Kabupaten/Kota</label>
                  <select name="pembinaan_kpm_dari_pemkab_kota" class="form-control">
                    <option value="" disabled selected>--- Pilih ---</option>
                    <option value="Ada">Ada</option>
                    <option value="Tidak Ada">Tidak Ada</option>
                  </select>
                </div>

                <script>
                  document.addEventListener("DOMContentLoaded", function() {
                    const kpmSelect = document.getElementById('kpm');
                    const kaderInfo = document.querySelector('.KaderInfo');

                    kpmSelect.addEventListener('change', function() {
                      if (this.value === 'Ada, Aktif' || this.value === 'Ada, Tidak Aktif') {
                        kaderInfo.style.display = 'block';
                      } else {
                        kaderInfo.style.display = 'none';
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
            <div class="modal fade" id="modalkader" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih Keaktifan Keberadaan Kader Pembangunan Manusia (KPM).</li>
                      <li>Jika Ada, isi informasi tambahan apakah KPM mendapatkan pembinaan dari Pemerintah Kabupaten/Kota.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!--end::Row-->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Realisasi Anggaran Pendapatan Desa</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalanggaran">
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
              <form action="../../handlers/form_realisasi_anggaran_desa.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Realisasi Pendapatan Desa Tahun Anggaran</label>
                    <p>1. Pendapatan Asli Desa (PADes)</p>
                    <input type="number" step="0.01" name="pendapatan_asli_desa" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
                    <p>2. Dana Desa (bersumber dari APBN)</p>
                    <input type="number" step="0.01" name="dana_desa" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
                    <p>3. Bagian dari hasil pajak daerah dan retribusi daerah</p>
                    <input type="number" step="0.01" name="bagian_dari_hasil_pajak_daerah_dan_retribusi_daerah" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
                    <p>4. Alokasi Dana Desa</p>
                    <input type="number" step="0.01" name="alokasi_dana_desa" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
                    <p>5. Bantuan keuangan dari APBD Provinsi</p>
                    <input type="number" step="0.01" name="bantuan_keuangan_dari_apbd_provinsi" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
                    <p>6. Bantuan keuangan dari APBD Kabupaten/Kota</p>
                    <input type="number" step="0.01" name="bantuan_keuangan_dari_apbd" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
                    <p>7. Hibah dan sumbangan dari pihak ketiga</p>
                    <input type="number" step="0.01" name="hibah_dan_sumbangan_dari_pihak_ketiga" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
                    <p>8. Lain–lain pendapatan desa yang sah</p>
                    <input type="number" step="0.01" name="lain_lain_pendapatan_desa_yang_sah" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
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

            <!--end::Row-->
          </div>

          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Realisasi Anggaran Belanja Desa</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalbelanja">
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
              <form action="../../handlers/form_realisasi_anggaran_belanja_desa.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Realisasi Belanja Desa Tahun Anggaran</label>
                    <p>1. Bidang Penyelenggaraan Pemerintahan Desa</p>
                    <input type="number" step="0.01" name="bidang_penyelenggaraan_pemerintahan_desa" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
                    <p>2. Bidang Pelaksanaan Pembangunan Desa</p>
                    <input type="number" step="0.01" name="bidang_pelaksanaan_pembangunan_desa" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
                    <p>3. Bidang Pembinaan Kemasyarakatan</p>
                    <input type="number" step="0.01" name="bidang_pembinaan_kemasyarakatan" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
                    <p>4. Bidang Pemberdayaan Masyarakat</p>
                    <input type="number" step="0.01" name="bidang_pemberdayaan_masyarakat" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
                    <p>5. Bidang Tak Terduga</p>
                    <input type="number" step="0.01" name="bidang_tak_terduga" class="form-control mb-3" placeholder="--- Masukkan jumlah ---" required>
                  </div>
                </div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
              <!-- /.row -->
              <!--end::Row-->
            </div>
          </div> <!--end::Container-->

          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Data BUMDes</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalbumdes">
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
              <form action="../../handlers/form_bumdes.php" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Status Keaktifan (Aktif/Tidak Aktif)</label>
                    <select name="status_keaktifan" class="form-control form-select" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Aktif">Aktif</option>
                      <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Status Badan Hukum</label>
                    <select name="status_badan_hukum" class="form-control form-select" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Sudah Memiliki Badan Hukum">Sudah Memiliki Badan Hukum</option>
                      <option value="Belum Memiliki Badan">Belum Memiliki Badan</option>
                    </select>
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
            <div class="modal fade" id="modalbumdes" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih Status Keaktifan (Aktif/Tidak Aktif).</li>
                      <li>Pilih Status Badan Hukum.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div> <!--end::App Content-->
        </div>

        <!--end::Row-->
        <div class="card card-primary card-outline mb-4">
          <div class="card-header mb-3">
            <h3 class="card-title">Jumlah pengadaan barang dan jasa di Desa</h3>
            <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalpengadaan">
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
            <form action="../../handlers/form_pengadaan_barang_jasa.php" method="post">
              <div class="row">
                <div class="form-group mb-3">
                  <label class="mb-2">Jumlah Paket Pengadaan Barang dan Jasa yang Dilaksanakan</label>
                  <input name="jumlah_paket_pengadaan_barang_dan_jasa_yang_dilaksanakan" type="number" class="form-control" placeholder="--- Masukkan jumlah ---" min="0" required>
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
          <div class="modal fade" id="modalpengadaan" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <ul>
                    <li>Isi dengan angka jumlah paket pengadaan barang dan jasa yang dilaksanakan.</li>
                  </ul>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
        </div>

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