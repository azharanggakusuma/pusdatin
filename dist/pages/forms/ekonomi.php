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
                  </div>
                </div>
                <div class="form-group mb-3" id="sentraIndustriInfo" style="display: none;">
                  <label class="mb-2">Sentra Industri</label>
                  <input type="number" class="form-control" name="sentra_industri" id="sentra_industri" placeholder=" --- Masukkan jumlah --- ">
                </div>
                <div class="form-group mb-3" id="muatanUsahaInfo" style="display: none;">
                  <label class="mb-2">Produk pada sentra industri yang mempunyai muatan usaha terbanyak</label>
                  <input type="text" class="form-control" name="muatan_usaha" id="muatan_usaha" placeholder=" --- Tuliskan produk --- ">
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
                  </div>
                </div>
                <div class="form-group mb-3" id="productInfo" style="display: none;">
                  <label class="mb-2">Produk barang unggulan/utama desa/kelurahan</label>
                  <input type="text" class="form-control mb-2" name="makanan_unggulan" id="makanan_unggulan" placeholder=" --- Tuliskan Makanan --- ">
                  <input type="text" class="form-control" name="non_makanan_unggulan" id="non_makanan_unggulan" placeholder=" --- Tuliskan Non Makanan --- ">
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
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Keberadaan pangkalan/agen/penjual LPG (warung, toko, supermarket, penjual gas keliling)</label>
                    <select name="keberadaan_lpg" id="keberadaan_lpg" class="form-control" required>
                      <option value="" disabled selected> --- Pilih --- </option>
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
            <form action="" method="post">
              <div class="row">
                <div class="form-group mb-3">
                  <label class="mb-2">Jumlah bank yang beroperasi di desa/kelurahan</label>
                  <p style="margin-left: 20px;">1. Bank Umum Pemerintah (BRI, BNI, Mandiri, BPD, BTN)</p>
                  <input type="number" name="" id="" class="form-control mb-3" placeholder=" --- Masukkan jumlah ---">
                  <p style="margin-left: 20px;">2. Bank Umum Swasta (BCA, Permata, Sinarmas, CIMB, dll)</p>
                  <input type="number" name="" id="" class="form-control mb-3" placeholder=" --- Masukkan jumlah ---">
                  <p style="margin-left: 20px;">3. Bank Perkreditan Rakyat (BPR)</p>
                  <input type="number" name="" id="" class="form-control mb-3" placeholder=" --- Masukkan jumlah ---">
                </div>

                <div class="form-group mb-3">
                  <label class="mb-2">Jika tidak ada bank, perkiraan jarak ke bank terdekat</label>
                  <input type="number" name="" id="" class="form-control" placeholder=" --- Masukkan jarak ---">
                </div>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
            </form>
            <!-- /.row -->
          </div>
        </div>

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
          <form action="" method="post">
            <div class="row">
              <div class="form-group mb-3">
                <label class="mb-2">Jumlah koperasi di desa/kelurahan yang masih aktif</label>
                <p style="margin-left: 20px;">1. Koperasi Unit Desa (KUD)</p>
                <input type="number" name="" id="" class="form-control mb-3" placeholder=" --- Masukkan jumlah ---">
                <p style="margin-left: 20px;">2. Koperasi Industri Kecil dan Kerajinan Rakyat (Kopinkra)/Usaha mikro</p>
                <input type="number" name="" id="" class="form-control mb-3" placeholder=" --- Masukkan jumlah ---">
                <p style="margin-left: 20px;">3. Koperasi Simpan Pinjam (KSP/Kospin)</p>
                <input type="number" name="" id="" class="form-control mb-3" placeholder=" --- Masukkan jumlah ---">
                <p style="margin-left: 20px;">4. Koperasi lainnya</p>
                <input type="number" name="" id="" class="form-control mb-3" placeholder=" --- Tuliskan Lainnya ---">
              </div>

              <div class="row">
                <div class="form-group mb-3">
                  <label class="mb-2">Keberadaan toko/kios yang menjual sarana produksi pertanian (benih, pupuk, pestisida, cangkul, dll.) di desa/kelurahan</label>
                  <p style="margin-left: 20px;">1. Milik KUD</p>
                  <select name="" id="publicSpaceStatus" class="form-control mb-3">
                    <option value="" disabled selected> --- Pilih --- </option>
                    <option value="Ada">Ada</option>
                    <option value="Tidak Ada">Tidak Ada</option>
                  </select>
                  <p style="margin-left: 20px;">2. Milik BUM Desa</p>
                  <select name="" id="publicSpaceStatus" class="form-control mb-3">
                    <option value="" disabled selected> --- Pilih --- </option>
                    <option value="Ada">Ada</option>
                    <option value="Tidak Ada">Tidak Ada</option>
                  </select>
                  <p style="margin-left: 20px;">3. Selain milik KUD/BUM Desa</p>
                  <select name="" id="publicSpaceStatus" class="form-control mb-3">
                    <option value="" disabled selected> --- Pilih --- </option>
                    <option value="Ada">Ada</option>
                    <option value="Tidak Ada">Tidak Ada</option>
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
      </div>

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
      <form action="" method="post">
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
                <!-- BMT -->
                <tr>
                  <td>Baitul Maal Wa Tamwil (BMT)</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td><input type="text" name="bmt_jarak" class="form-control" placeholder=" --- Masukkan jarak --- "></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- ATM -->
                <tr>
                  <td>Anjungan Tunai Mandiri (ATM)</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td><input type="text" name="bmt_jarak" class="form-control" placeholder=" --- Masukkan jarak --- "></td>
                  <td>
                    <select name="atm_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- Agen Bank -->
                <tr>
                  <td>Agen Bank</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td><input type="text" name="bmt_jarak" class="form-control" placeholder=" --- Masukkan jarak --- "></td>
                  <td>
                    <select name="agen_bank_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- BMT -->
                <tr>
                  <td>Baitul Maal Wa Tamwil (BMT)</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td><input type="text" name="bmt_jarak" class="form-control" placeholder=" --- Masukkan jarak --- "></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- ATM -->
                <!-- BMT -->
                <tr>
                  <td> Pedagang Valuta Asing</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td><input type="text" name="bmt_jarak" class="form-control" placeholder=" --- Masukkan jarak --- "></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- ATM -->
                <!-- BMT -->
                <tr>
                  <td>Pergadaian</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td><input type="text" name="bmt_jarak" class="form-control" placeholder=" --- Masukkan jarak --- "></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- ATM -->
                <!-- BMT -->
                <tr>
                  <td>Agen Tiket/Travel/Biro Perjalanan</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td><input type="text" name="bmt_jarak" class="form-control" placeholder=" --- Masukkan jarak --- "></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- ATM -->
                <!-- BMT -->
                <tr>
                  <td> Bengkel Mobil/Motor</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td><input type="text" name="bmt_jarak" class="form-control" placeholder=" --- Masukkan jarak --- "></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- ATM -->
                <!-- BMT -->
                <tr>
                  <td>Salon Kecantikan</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td><input type="text" name="bmt_jarak" class="form-control" placeholder=" --- Masukkan jarak --- "></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- ATM -->

              </tbody>
            </table>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> &nbsp; Simpan
        </button>
      </form>
      <!-- /.row -->
    </div>

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
      <form action="" method="post">
        <div class="row">
          <div class="col-12 mb-3">
            <table class="table">
              <thead>
                <tr>
                  <th>Jenis sarana dan prasarana ekonomi</th>
                  <th>Jumlah Sarana</th>
                  <th>Kemudahan untuk Mencapai</th>
                </tr>
              </thead>
              <tbody>
                <!-- BMT -->
                <tr>
                  <td>Kelompok pertokoan (minimal 10 toko dan mengelompok dalam satu lokasi)</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- ATM -->
                <tr>
                  <td>Pasar dengan bangunan permanen (memiliki atap, lantai, dan dinding)</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td>
                    <select name="atm_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- Agen Bank -->
                <tr>
                  <td> Pasar dengan bangunan semi permanen (memiliki atap dan lantai, tanpa dinding)</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td>
                    <select name="agen_bank_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- BMT -->
                <tr>
                  <td>Pasar tanpa bangunan (misalnya: pasar subuh, pasar terapung, dll.)</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- ATM -->
                <!-- BMT -->
                <tr>
                  <td>Jumlah minimarket/swalayan/supermarket (tempat usaha di bangunan tetap untuk menjual berbagai jenis barang secara eceran dengan label harga, sistem pelayanan mandiri)</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- ATM -->
                <!-- BMT -->
                <tr>
                  <td>PRestoran/rumah makan (usaha pangan siap saji di bangunan tetap, pembeli biasanya dikenai pajak)</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- ATM -->
                <!-- BMT -->
                <tr>
                  <td> Warung/kedai makanan minuman (usaha pangan siap saji di bangunan tetap, pembeli biasanya tidak dikenai pajak)</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- ATM -->

                <!-- BMT -->
                <tr>
                  <td>Toko/warung kelontong (tempat usaha di bangunan tetap untuk menjual berbagai jenis barang keperluan sehari hari secara eceran, tanpa ada sistem pelayanan mandiri)</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- ATM -->
                <!-- BMT -->
                <tr>
                  <td>Hotel (menyediakan jasa akomodasi dan ada restoran, penginapan dengan izin usaha sebagai hotel)</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- ATM -->
                <!-- BMT -->
                <tr>
                  <td> Penginapan: hostel/motel/losmen/wisma (menyediakan akomodasi, penginapan dengan izin usaha bukan sebagai hotel)</td>
                  <td><input type="number" name="bmt_jumlah" class="form-control" min="0" placeholder=" --- Masukkan jumlah --- "></td>
                  <td>
                    <select name="bmt_kemudahan" class="form-control">
                      <option value="" disabled selected> --- Pilih --- </option>
                      <option value="1">Sangat Mudah</option>
                      <option value="2">Mudah</option>
                      <option value="3">Sulit</option>
                      <option value="4">Sangat Sulit</option>
                    </select>
                  </td>
                </tr>
                <!-- ATM -->
              </tbody>
            </table>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> &nbsp; Simpan
        </button>
      </form>
      <!-- /.row -->
    </div>

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
              <li>Sarana dan prasarana ekonomi di desa/kelurahan</li>
              <li>isi jenis sarana dan prasarana ekonomi</li>
              <li>isi jumlah Sarana</li>
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