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
            window.location.href = "angkutan,_komunikasi,_dan_informasi.php";
          });
        } else if (status === 'error') {
          Swal.fire({
            title: "Gagal!",
            text: "Terjadi kesalahan saat menambahkan data.",
            icon: "error",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "angkutan,_komunikasi,_dan_informasi.php";
          });
        } else if (status === 'warning') {
          Swal.fire({
            title: "Peringatan!",
            text: "Mohon lengkapi semua data.",
            icon: "warning",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "angkutan,_komunikasi,_dan_informasi.php";
          });
        }
      </script>
    <?php endif; ?>

    <main class="app-main"> <!--begin::App Content Header-->
      <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Angkutan Komunikasi dan Informasi</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Angkutan Komunikasi dan Informasi
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
              <h3 class="card-title">Prasarana dan Sarana Transportasi Antar Desa/Kelurahan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalTransportasi">
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
              <form action="../../handlers/form_prasarana_transportasi.php" method="post">
                <div class="row">
                  <!-- Lalu Lintas -->
                  <div class="form-group mb-3">
                    <label class="mb-2" for="lalu_lintas">Lalu lintas dari/ke desa/kelurahan melalui</label>
                    <select name="lalu_lintas" id="lalu_lintas" class="form-select" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Aspal/Beton">Aspal/Beton</option>
                      <option value="Diperkeras (kerikil, batu, dll.)">Diperkeras (kerikil, batu, dll.)</option>
                      <option value="Tanah">Tanah</option>
                      <option value="Lainnya">Lainnya</option>
                    </select>
                  </div>

                  <!-- Jenis Permukaan Jalan -->
                  <div class="form-group mb-3">
                    <label class="mb-2" for="jenis_permukaan_jalan">Jenis permukaan jalan darat antar desa/kelurahan yang terluas</label>
                    <select name="jenis_permukaan_jalan" id="jenis_permukaan_jalan" class="form-select" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Sepanjang tahun">Sepanjang tahun</option>
                      <option value="Sepanjang tahun kecuali saat tertentu (ketika turun hujan, pasang, dll.)">Sepanjang tahun kecuali saat tertentu (ketika turun hujan, pasang, dll.)</option>
                      <option value="Selama musim kemarau">Selama musim kemarau</option>
                      <option value="Tidak dapat dilalui sepanjang tahun">Tidak dapat dilalui sepanjang tahun</option>
                    </select>
                  </div>

                  <!-- Jalan Darat Bisa Dilalui -->
                  <div class="form-group mb-3">
                    <label class="mb-2" for="jalan_darat_bisa_dilalui">Jalan darat antar desa/kelurahan dapat dilalui kendaraan bermotor roda 4 atau lebih</label>
                    <select name="jalan_darat_bisa_dilalui" id="jalan_darat_bisa_dilalui" class="form-select" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Sepanjang tahun">Sepanjang tahun</option>
                      <option value="Sepanjang tahun kecuali saat tertentu (ketika turun hujan, pasang, dll.)">Sepanjang tahun kecuali saat tertentu (ketika turun hujan, pasang, dll.)</option>
                      <option value="Selama musim kemarau">Selama musim kemarau</option>
                      <option value="Tidak dapat dilalui sepanjang tahun">Tidak dapat dilalui sepanjang tahun</option>
                    </select>
                  </div>

                  <!-- Keberadaan Angkutan Umum -->
                  <div class="form-group mb-3">
                    <label class="mb-2" for="keberadaan_angkutan_umum">Keberadaan angkutan umum</label>
                    <select name="keberadaan_angkutan_umum" id="keberadaan_angkutan_umum" class="form-select" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Ada, dengan trayek tetap">Ada, dengan trayek tetap</option>
                      <option value="Ada, tanpa trayek tetap">Ada, tanpa trayek tetap</option>
                      <option value="Tidak ada angkutan umum">Tidak ada angkutan umum</option>
                    </select>
                  </div>

                  <!-- Operasional Angkutan Umum yang Utama -->
                  <div class="form-group mb-3">
                    <label class="mb-2" for="operasional_angkutan_umum">Operasional angkutan umum yang utama</label>
                    <select name="operasional_angkutan_umum" id="operasional_angkutan_umum" class="form-select" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Setiap hari">Setiap hari</option>
                      <option value="Tidak setiap hari">Tidak setiap hari</option>
                    </select>
                  </div>

                  <!-- Jam Operasi Angkutan Umum yang Utama -->
                  <div class="form-group mb-3">
                    <label class="mb-2" for="jam_operasi_angkutan_umum">Jam operasi angkutan umum yang utama</label>
                    <select name="jam_operasi_angkutan_umum" id="jam_operasi_angkutan_umum" class="form-select" required>
                      <option value="" disabled selected>--- Pilih ---</option>
                      <option value="Siang dan malam hari">Siang dan malam hari</option>
                      <option value="Hanya siang/malam hari">Hanya siang/malam hari</option>
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
            <div class="modal fade" id="modalTransportasi" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih salah satu dari pilihan yang tersedia sesuai dengan kondisi prasarana dan sarana transportasi di desa/kelurahan Anda.</li>
                      <li>Pastikan semua kolom diisi. Jika salah satu kolom kosong, data tidak akan disimpan.</li>
                      <li>Gunakan pilihan <strong>--- Pilih ---</strong> dan pilih opsi yang sesuai dengan kondisi aktual.</li>
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

          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Keberadaan Internet untuk Warnet, Game Online, dan Fasilitas Lainnya di Desa/Kelurahan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalInternet">
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
              <form action="../../handlers/form_internet_transportasi.php" method="post">
                <div class="row">
                  <!-- Keberadaan Internet -->
                  <div class="form-group mb-3">
                    <label class="mb-2" for="keberadaan_internet">Keberadaan internet untuk warnet, game online, dan fasilitas lainnya di desa/kelurahan</label>
                    <select name="keberadaan_internet" id="keberadaan_internet" class="form-select" required>
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
            <div class="modal fade" id="modalInternet" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih <strong>Ada</strong> jika keberadaan internet untuk warnet, game online, dan fasilitas lainnya tersedia di desa/kelurahan Anda.</li>
                      <li>Pilih <strong>Tidak Ada</strong> jika tidak tersedia.</li>
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

          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Keberadaan Menara Telepon Seluler, Sinyal Telepon, dan Sinyal Internet di Desa/Kelurahan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalMenaraTlp">
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
              <form action="../../handlers/form_menara_telepon.php" method="post">
                <div class="mb-3">
                  <label for="bts-count" class="form-label">Jumlah menara telepon seluler atau Base Transceiver Station (BTS)</label>
                  <input type="number" name="jumlah_bts" id="bts-count" class="form-control" placeholder="--- Masukkan jumlah ---" min="0" required>
                </div>

                <div class="mb-3">
                  <label for="operator-count" class="form-label">Jumlah operator layanan komunikasi telepon seluler/handphone yang menjangkau di desa</label>
                  <input type="number" name="jumlah_operator_telekomunikasi" id="operator-count" class="form-control" placeholder="--- Masukkan jumlah ---" min="0" required>
                </div>

                <div class="mb-3">
                  <label for="sinyal_telepon" class="form-label">Sinyal telepon seluler/handphone di sebagian besar wilayah desa/kelurahan</label>
                  <select name="sinyal_telepon" id="sinyal_telepon" class="form-select" required>
                    <option value="" disabled selected>--- Pilih ---</option>
                    <option value="Sinyal sangat kuat">Sinyal sangat kuat</option>
                    <option value="Sinyal kuat">Sinyal kuat</option>
                    <option value="Sinyal lemah">Sinyal lemah</option>
                    <option value="Tidak ada sinyal">Tidak ada sinyal</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="sinyal_internet" class="form-label">Sinyal internet telepon seluler/handphone di sebagian besar wilayah desa/kelurahan</label>
                  <select name="sinyal_internet" id="sinyal_internet" class="form-select" required>
                    <option value="" disabled selected>--- Pilih ---</option>
                    <option value="5G/4G/LTE">5G/4G/LTE</option>
                    <option value="3G/H+/EVDO">3G/H+/EVDO</option>
                    <option value="2.5G/EG/GPRS">2.5G/EG/GPRS</option>
                    <option value="Tidak ada sinyal internet">Tidak ada sinyal internet</option>
                  </select>
                </div>

                <!-- Submit button -->
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
              <!-- /.row -->
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="modalMenaraTlp" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi jumlah menara telepon seluler atau Base Transceiver Station (BTS) yang ada di desa/kelurahan Anda.</li>
                      <li>Isi jumlah operator layanan komunikasi telepon seluler/handphone yang menjangkau di desa/kelurahan Anda.</li>
                      <li>Pilih kekuatan sinyal telepon seluler/handphone di sebagian besar wilayah desa/kelurahan Anda.</li>
                      <li>Pilih tipe sinyal internet telepon seluler/handphone di sebagian besar wilayah desa/kelurahan Anda.</li>
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


          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Ketersediaan Internet dan Komputer/PC/laptop di Kantor Desa</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalketersediaaninternet">
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
              <form action="" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Komputer/PC/laptop yang masih berfungsi di kantor kepala desa/lurah</label>
                    <select name="" id="" class="form-control form-select">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Digunakan">Digunakan</option>
                      <option value="Jarang	digunakan">Jarang digunakan</option>
                      <option value="Tidak	digunakan">Tidak digunakan</option>
                      <option value="Tidak	ada">Tidak ada</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Fasilitas internet di kantor kepala desa/lurah</label>
                    <select name="" id="" class="form-control form-select">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Berfungsi">Berfungsi</option>
                      <option value="Jarang	berfungsi">Jarang berfungsi</option>
                      <option value="Tidak	berfungsi">Tidak berfungsi</option>
                      <option value="Tidak	ada">Tidak ada</option>
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
            <div class="modal fade" id="modalketersediaaninternet" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih Komputer/PC/laptop yang masih berfungsi di kantor kepala desa/lurah</li>
                      <li>Pilih Fasilitas internet di kantor kepala desa/lurah</li>
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
              <h3 class="card-title">Keberadaan Kantor Pos/Pos Pembantu/Rumah Pos, Pos Keliling, dan Perusahaan/Agen Jasa Ekspedisi Swasta</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalkantorpos">
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
              <form action="" method="post">
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Kantor pos/pos pembantu/rumah pos</label>
                    <select name="" id="" class="form-control form-select">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Beroperasi">Beroperasi</option>
                      <option value="Jarang	beroperasi">Jarang beroperasi</option>
                      <option value="Tidak beroperasi">Tidak beroperasi</option>
                      <option value="Tidak	ada">Tidak ada</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Layanan pos keliling</label>
                    <select name="" id="" class="form-control form-select">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak	ada">Tidak ada</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Perusahaan/agen jasa ekspedisi (pengiriman barang/dokumen) swasta</label>
                    <select name="" id="" class="form-control form-select">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="Beroperasi">Beroperasi</option>
                      <option value="Jarang	beroperas">Jarang beroperas</option>
                      <option value="Tidak	beroperasi">Tidak beroperasi</option>
                      <option value="Tidak	ada">Tidak ada</option>
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
            <div class="modal fade" id="modalkantorpos" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih kantor pos/pos pembantu/rumah pos</li>
                      <li>Pilih layanan pos keliling</li>
                      <li>Pilih Perusahaan/agen jasa ekspedisi (pengiriman barang/dokumen) swasta</li>
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