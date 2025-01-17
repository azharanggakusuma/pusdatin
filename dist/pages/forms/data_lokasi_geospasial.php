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
            window.location.href = "data_lokasi_geospasial.php";
          });
        } else if (status === 'error') {
          Swal.fire({
            title: "Gagal!",
            text: "Terjadi kesalahan saat menambahkan data.",
            icon: "error",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "data_lokasi_geospasial.php";
          });
        } else if (status === 'warning') {
          Swal.fire({
            title: "Peringatan!",
            text: "Mohon lengkapi semua data.",
            icon: "warning",
            timer: 3000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "data_lokasi_geospasial.php";
          });
        }
      </script>
    <?php endif; ?>

    <main class="app-main">
      <!--begin::App Content Header-->
      <div class="app-content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Data Lokasi Geospasial</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Lokasi Geospasial</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!--end::App Content Header-->

      <!--begin::App Content-->
      <div class="app-content">
        <div class="container-fluid">
          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Daftar Tempat Peribadatan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalTibadah">
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
              <form action="../../handlers/form_tempat_peribadatan.php" method="post">
                <div class="form-group mb-3">
                  <label class="mb-2">Jumlah Tempat Peribadatan</label>
                  <input
                    type="number"
                    id="jumlahTempat"
                    name="jumlah_tempat"
                    class="form-control"
                    placeholder="Isi angka/jumlah"
                    min="0"
                    max="50"
                    step="1"
                    style="width: 100%;"
                    required />
                </div>

                <!-- Container untuk Form Dinamis -->
                <div id="dynamicForms" class="mt-4"></div>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                const jumlahTempatInput = document.getElementById("jumlahTempat");
                const formContainer = document.getElementById("dynamicForms");
                const maxForms = 50;

                jumlahTempatInput.addEventListener("input", function() {
                  const jumlah = parseInt(this.value);
                  formContainer.innerHTML = ""; // Bersihkan form lama

                  if (!isNaN(jumlah) && jumlah > 0) {
                    if (jumlah > maxForms) {
                      alert("Maksimal jumlah form yang dapat dibuat adalah 50.");
                      jumlahTempatInput.value = maxForms; // Set nilai input menjadi 50 jika lebih
                    }

                    const maxJumlah = Math.min(jumlah, maxForms); // Batas maksimal adalah 50
                    for (let i = 1; i <= maxJumlah; i++) {
                      const formTemplate = `
            <div class="card mb-4">
              <div class="card-header">
                <h4 class="card-title">Tempat Peribadatan Ke-${i}</h4>
              </div>
              <div class="card-body">
                <div class="form-group mb-3">
                  <label class="mb-2">Jenis Tempat Ibadah</label>
                  <select name="jenis_tempat_peribadatan_${i}" class="form-control" required>
                    <option value="" disabled selected>---Pilih Jenis Tempat Ibadah---</option>
                    <option value="Masjid">Masjid</option>
                    <option value="Mushola">Mushola</option>
                    <option value="Gereja Protestan">Gereja Protestan</option>
                    <option value="Gereja Katolik">Gereja Katolik</option>
                    <option value="Pura">Pura</option>
                    <option value="Vihara">Vihara</option>
                    <option value="Klenteng">Klenteng</option>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label class="mb-2">Nama Tempat Peribadatan</label>
                  <input name="nama_tempat_peribadatan_${i}" type="text" placeholder="Masukkan nama tempat peribadatan" class="form-control" required>
                </div>
                <div class="titik_koordinat">
                  <label style="font-weight: bold;">Titik Koordinat</label>
                  <div class="row">
                    <div class="col-md-6">
                      <label>Koordinat Lintang</label>
                      <input name="titik_koordinat_lintang_${i}" type="text" placeholder="-6.8796 LS" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label>Koordinat Bujur</label>
                      <input name="titik_koordinat_bujur_${i}" type="text" placeholder="108.5538 BT" class="form-control" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            `;
                      formContainer.insertAdjacentHTML("beforeend", formTemplate);
                    }
                  }
                });
              });
            </script>

            <!-- Modal Info -->
            <div class="modal fade" id="modalTibadah" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi sesuai petunjuk.</li>
                      <li>Pastikan data yang dimasukkan benar.</li>
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
              <h3 class="card-title">Daftar Potensi Wisata Desa</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalWisata">
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
              <form action="../../handlers/form_potensi_wisata.php" method="post">
                <div class="form-group mb-3">
                  <label class="mb-2">Jumlah Potensi Wisata Desa</label>
                  <input
                    type="number"
                    id="jumlahPotensi"
                    name="jumlah_potensi"
                    class="form-control"
                    placeholder="Isi angka/jumlah"
                    min="0"
                    max="50"
                    step="1"
                    style="width: 100%;"
                    required />
                </div>

                <!-- Container untuk Form Dinamis -->
                <div id="dynamicFormsWisata" class="mt-4"></div>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                const jumlahPotensiInput = document.getElementById("jumlahPotensi");
                const formContainer = document.getElementById("dynamicFormsWisata");

                jumlahPotensiInput.addEventListener("input", function() {
                  const jumlah = parseInt(this.value);
                  formContainer.innerHTML = ""; // Bersihkan form lama

                  if (!isNaN(jumlah) && jumlah > 0) {
                    if (jumlah > 50) {
                      alert("Maksimal jumlah form yang dapat dibuat adalah 50.");
                      jumlahPotensiInput.value = 50; // Set nilai input menjadi 50 jika lebih
                    }

                    const maxJumlah = Math.min(jumlah, 50); // Batas maksimal adalah 50
                    for (let i = 1; i <= maxJumlah; i++) {
                      const formTemplate = `
            <div class="card mb-4">
              <div class="card-header">
                <h4 class="card-title">Potensi Wisata Desa Ke-${i}</h4>
              </div>
              <div class="card-body">
                <div class="form-group mb-3">
                  <label class="mb-2">Nama Potensi Wisata Desa</label>
                  <input name="nama_potensi_wisata_${i}" type="text" placeholder="Masukkan nama potensi wisata desa" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                  <label class="mb-2">Jenis Wisata Desa</label>
                  <select name="jenis_wisata_desa_${i}" class="form-control" required>
                    <option value="" disabled selected>---Pilih Jenis Wisata---</option>
                    <option value="alam">Wisata Alam</option>
                    <option value="buatan">Wisata Buatan</option>
                    <option value="religi">Wisata Religi</option>
                    <option value="budaya">Wisata Budaya</option>
                  </select>
                </div>
                <div class="titik_koordinat">
                  <label style="font-weight: bold;">Titik Koordinat</label>
                  <div class="row">
                    <div class="col-md-6">
                      <label>Koordinat Lintang</label>
                      <input name="titik_koordinat_lintang_${i}" type="text" placeholder="-6.8796 LS" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label>Koordinat Bujur</label>
                      <input name="titik_koordinat_bujur_${i}" type="text" placeholder="108.5538 BT" class="form-control" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          `;
                      formContainer.insertAdjacentHTML("beforeend", formTemplate);
                    }
                  }
                });
              });
            </script>
          </div>


          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Daftar Sekolah/Lembaga Pendidikan Formal</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalSekolah">
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
              <form action="../../handlers/form_sekolah.php" method="post">
                <div class="form-group mb-3">
                  <label class="mb-2">Jumlah Sekolah</label>
                  <input
                    type="number"
                    id="jumlahSekolah"
                    name="jumlah_sekolah"
                    class="form-control"
                    placeholder="Masukkan jumlah sekolah"
                    min="0"
                    max="50"
                    step="1"
                    required />
                </div>
                <div id="dynamicFormsSekolah" class="mt-4"></div>
                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                const jumlahSekolahInput = document.getElementById("jumlahSekolah");
                const formContainer = document.getElementById("dynamicFormsSekolah");

                jumlahSekolahInput.addEventListener("input", function() {
                  const jumlah = parseInt(this.value);
                  formContainer.innerHTML = "";

                  if (!isNaN(jumlah) && jumlah > 0) {
                    if (jumlah > 50) {
                      alert("Maksimal jumlah form yang dapat dibuat adalah 50.");
                      jumlahSekolahInput.value = 50;
                    }

                    const maxJumlah = Math.min(jumlah, 50);
                    for (let i = 1; i <= maxJumlah; i++) {
                      const formTemplate = `
              <div class="card mb-4">
                <div class="card-header">
                  <h4 class="card-title">Sekolah Ke-${i}</h4>
                </div>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Sekolah</label>
                    <input name="nama_sekolah_${i}" type="text" placeholder="Masukkan nama sekolah" class="form-control" required />
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Jenjang Pendidikan</label>
                    <select name="jenjang_pendidikan_${i}" class="form-control" required>
                      <option value="" disabled selected>---Pilih Jenjang Pendidikan---</option>
                      <option value="Paud">Paud</option>
                      <option value="Sekolah Dasar">Sekolah Dasar</option>
                      <option value="Sekolah Menengah Pertama">Sekolah Menengah Pertama</option>
                      <option value="Sekolah Menengah Atas">Sekolah Menengah Atas</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Status Sekolah</label>
                    <select name="status_sekolah_${i}" class="form-control" required>
                      <option value="" disabled selected>---Pilih Status Sekolah---</option>
                      <option value="Negeri">Negeri</option>
                      <option value="Swasta">Swasta</option>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Alamat Sekolah</label>
                    <textarea name="alamat_sekolah_${i}" class="form-control" rows="3" placeholder="Masukkan alamat sekolah" required></textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Kecamatan</label>
                    <input name="nama_kecamatan_${i}" type="text" placeholder="Masukkan nama kecamatan" class="form-control" required />
                  </div>
                  <div class="titik_koordinat">
                    <label style="font-weight: bold;">Titik Koordinat</label>
                    <div class="row">
                      <div class="col-md-6">
                        <label>Koordinat Lintang</label>
                        <input name="koordinat_lintang_${i}" type="text" placeholder="-6.8796 LS" class="form-control" required />
                      </div>
                      <div class="col-md-6">
                        <label>Koordinat Bujur</label>
                        <input name="koordinat_bujur_${i}" type="text" placeholder="108.5538 BT" class="form-control" required />
                      </div>
                    </div>
                  </div>
                </div>
              </div>`;
                      formContainer.insertAdjacentHTML("beforeend", formTemplate);
                    }
                  }
                });
              });
            </script>

            <!-- Modal Info -->
            <div class="modal fade" id="modalSekolah" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi Nama Sekolah</li>
                      <li>Pilih Jenjang Pendidikan yang sesuai</li>
                      <li>Pilih Status Sekolah yang sesuai</li>
                      <li>Isi Nama Kecamatan tempat sekolah</li>
                      <li>Pengisian Titik Koordinat menggunakan derajat desimal (contoh: -6.8796 LS dan 108.5538 BT)</li>
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
              <h3 class="card-title">Daftar Pondok Pesantren</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalPesantren">
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
              <form action="../../handlers/form_pondok_pesantren.php" method="post">
                <div class="form-group mb-3">
                  <label class="mb-2">Jumlah Pondok Pesantren</label>
                  <input
                    type="number"
                    id="jumlahPesantren"
                    name="jumlah_pesantren"
                    class="form-control"
                    placeholder="Masukkan jumlah pesantren"
                    min="0"
                    max="50"
                    step="1"
                    required />
                </div>

                <!-- Container untuk Form Dinamis -->
                <div id="dynamicFormsPesantren" class="mt-4"></div>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                const jumlahPesantrenInput = document.getElementById("jumlahPesantren");
                const formContainer = document.getElementById("dynamicFormsPesantren");

                jumlahPesantrenInput.addEventListener("input", function() {
                  const jumlah = parseInt(this.value);
                  formContainer.innerHTML = "";

                  if (!isNaN(jumlah) && jumlah > 0) {
                    if (jumlah > 50) {
                      alert("Maksimal jumlah form yang dapat dibuat adalah 50.");
                      jumlahPesantrenInput.value = 50;
                    }

                    const maxJumlah = Math.min(jumlah, 50);
                    for (let i = 1; i <= maxJumlah; i++) {
                      const formTemplate = `
              <div class="border p-3 mb-3">
                <div class="card-header mb-3">
                  <h4 class="card-title">Pondok Pesantren Ke-${i}</h4>
                </div>
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Pondok Pesantren</label>
                    <input name="nama_pesantren_${i}" type="text" class="form-control" placeholder="Masukkan Nama Pondok Pesantren" required />
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Alamat Pondok Pesantren</label>
                    <textarea name="alamat_pesantren_${i}" class="form-control" rows="3" placeholder="Isi Alamat Pondok Pesantren" required></textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Kecamatan</label>
                    <input name="nama_kecamatan_${i}" type="text" class="form-control" placeholder="Masukkan Nama Kecamatan" required />
                  </div>
                  <div class="titik_koordinat">
                    <label for="titik_koordinat_ke${i}">Titik Koordinat</label>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="koordinat_lintang_${i}">Koordinat Lintang</label>
                        <input name="koordinat_lintang_${i}" type="text" class="form-control" placeholder="-6.8796 LS" required />
                      </div>
                      <div class="col-md-6">
                        <label for="koordinat_bujur_${i}">Koordinat Bujur</label>
                        <input name="koordinat_bujur_${i}" type="text" class="form-control" placeholder="108.5538 BT" required />
                      </div>
                    </div>
                  </div>
                </div>
              </div>`;
                      formContainer.insertAdjacentHTML("beforeend", formTemplate);
                    }
                  }
                });
              });
            </script>

            <!-- Modal Info -->
            <div class="modal fade" id="modalPesantren" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi Nama Pondok Pesantren</li>
                      <li>Isi Alamat Pondok Pesantren</li>
                      <li>Isi Nama Kecamatan</li>
                      <li>Pengisian Titik Koordinat menggunakan derajat desimal (contoh: -6.8796 LS dan 108.5538 BT)</li>
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
              <h3 class="card-title">Daftar Rumah Sakit</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#infoModalRumahSakit">
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
              <form action="../../handlers/form_rumah_sakit.php" method="post">
                <div class="form-group mb-3">
                  <label class="mb-2">Jumlah Rumah Sakit</label>
                  <input
                    type="number"
                    id="jumlahRumahSakit"
                    name="jumlah_rumah_sakit"
                    class="form-control"
                    placeholder="Masukkan jumlah Rumah Sakit"
                    min="0"
                    max="50"
                    step="1"
                    required />
                </div>

                <!-- Container untuk Form Dinamis -->
                <div id="dynamicFormsRumahSakit" class="mt-4"></div>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                const jumlahRumahSakitInput = document.getElementById("jumlahRumahSakit");
                const formContainer = document.getElementById("dynamicFormsRumahSakit");

                jumlahRumahSakitInput.addEventListener("input", function() {
                  const jumlah = parseInt(this.value);
                  formContainer.innerHTML = "";

                  if (!isNaN(jumlah) && jumlah > 0) {
                    if (jumlah > 50) {
                      alert("Maksimal jumlah form yang dapat dibuat adalah 50.");
                      jumlahRumahSakitInput.value = 50;
                    }

                    const maxJumlah = Math.min(jumlah, 50);
                    for (let i = 1; i <= maxJumlah; i++) {
                      const formTemplate = `
              <div class="border p-3 mb-3">
                <div class="card-header mb-3">
                  <h4 class="card-title">Rumah Sakit Ke-${i}</h4>
                </div>
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Rumah Sakit</label>
                    <input
                      name="nama_rumah_sakit_${i}"
                      type="text"
                      class="form-control"
                      placeholder="Masukkan Nama Rumah Sakit"
                      required
                    />
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Alamat Rumah Sakit</label>
                    <textarea
                      name="alamat_rumah_sakit_${i}"
                      class="form-control"
                      rows="3"
                      placeholder="Isi Alamat Rumah Sakit"
                      required
                    ></textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Kecamatan</label>
                    <input
                      name="nama_kecamatan_rumah_sakit_${i}"
                      type="text"
                      class="form-control"
                      placeholder="Masukkan Nama Kecamatan"
                      required
                    />
                  </div>
                  <div class="titik_koordinat">
                    <label>Titik Koordinat</label>
                    <div class="row">
                      <div class="col-md-6">
                        <label>Koordinat Lintang</label>
                        <input
                          name="koordinat_lintang_${i}"
                          type="text"
                          class="form-control"
                          placeholder="-6.8796 LS"
                          required
                        />
                      </div>
                      <div class="col-md-6">
                        <label>Koordinat Bujur</label>
                        <input
                          name="koordinat_bujur_${i}"
                          type="text"
                          class="form-control"
                          placeholder="108.5538 BT"
                          required
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
                      formContainer.insertAdjacentHTML("beforeend", formTemplate);
                    }
                  }
                });
              });
            </script>

            <!-- Modal Info -->
            <div class="modal fade" id="infoModalRumahSakit" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Panduan Pengisian Data Rumah Sakit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi Nama Rumah Sakit dengan nama resmi yang terdaftar.</li>
                      <li>Isi Alamat Rumah Sakit dengan lengkap.</li>
                      <li>Isi Nama Kecamatan tempat Rumah Sakit berada.</li>
                      <li>Masukkan koordinat dalam format derajat desimal.</li>
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
              <h3 class="card-title">Daftar Pusat Kesehatan Masyarakat (PUSKESMAS)</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#infoModalPuskesmas">
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
              <form action="../../handlers/form_puskesmas.php" method="post">
                <div class="form-group mb-3">
                  <label class="mb-2">Jumlah PUSKESMAS</label>
                  <input
                    type="number"
                    id="jumlahPuskesmas"
                    name="jumlah_puskesmas"
                    class="form-control"
                    placeholder="Masukkan jumlah PUSKESMAS"
                    min="0"
                    max="50"
                    step="1"
                    required />
                </div>

                <!-- Container untuk Form Dinamis -->
                <div id="dynamicFormsPuskesmas" class="mt-4"></div>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                const jumlahPuskesmasInput = document.getElementById("jumlahPuskesmas");
                const formContainer = document.getElementById("dynamicFormsPuskesmas");

                jumlahPuskesmasInput.addEventListener("input", function() {
                  const jumlah = parseInt(this.value);
                  formContainer.innerHTML = "";

                  if (!isNaN(jumlah) && jumlah > 0) {
                    if (jumlah > 50) {
                      alert("Maksimal jumlah form yang dapat dibuat adalah 50.");
                      jumlahPuskesmasInput.value = 50;
                    }

                    const maxJumlah = Math.min(jumlah, 50);
                    for (let i = 1; i <= maxJumlah; i++) {
                      const formTemplate = `
              <div class="border p-3 mb-3">
                <div class="card-header mb-3">
                  <h4 class="card-title">PUSKESMAS Ke-${i}</h4>
                </div>
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama PUSKESMAS</label>
                    <input
                      name="nama_puskesmas_${i}"
                      type="text"
                      class="form-control"
                      placeholder="Masukkan Nama PUSKESMAS"
                      required
                    />
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Alamat PUSKESMAS</label>
                    <textarea
                      name="alamat_puskesmas_${i}"
                      class="form-control"
                      rows="3"
                      placeholder="Isi Alamat PUSKESMAS"
                      required
                    ></textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Kecamatan</label>
                    <input
                      name="nama_kecamatan_puskesmas_${i}"
                      type="text"
                      class="form-control"
                      placeholder="Masukkan Nama Kecamatan"
                      required
                    />
                  </div>
                  <div class="titik_koordinat">
                    <label>Titik Koordinat</label>
                    <div class="row">
                      <div class="col-md-6">
                        <label>Koordinat Lintang</label>
                        <input
                          name="koordinat_lintang_${i}"
                          type="text"
                          class="form-control"
                          placeholder="-6.8796 LS"
                          required
                        />
                      </div>
                      <div class="col-md-6">
                        <label>Koordinat Bujur</label>
                        <input
                          name="koordinat_bujur_${i}"
                          type="text"
                          class="form-control"
                          placeholder="108.5538 BT"
                          required
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
                      formContainer.insertAdjacentHTML("beforeend", formTemplate);
                    }
                  }
                });
              });
            </script>

            <!-- Modal Info -->
            <div class="modal fade" id="infoModalPuskesmas" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Panduan Pengisian Data PUSKESMAS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi Nama PUSKESMAS dengan nama resmi yang terdaftar.</li>
                      <li>Isi Alamat PUSKESMAS dengan lengkap.</li>
                      <li>Isi Nama Kecamatan tempat PUSKESMAS berada.</li>
                      <li>Masukkan koordinat dalam format derajat desimal.</li>
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
              <h3 class="card-title">Daftar Puskesmas Pembantu (PUSTU)</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#infoModalPustu">
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
              <form action="../../handlers/form_pustu.php" method="post">
                <div class="form-group mb-3">
                  <label class="mb-2">Jumlah PUSTU</label>
                  <input
                    type="number"
                    id="jumlahPustu"
                    name="jumlah_pustu"
                    class="form-control"
                    placeholder="Masukkan jumlah PUSTU"
                    min="0"
                    max="50"
                    step="1"
                    required />
                </div>

                <!-- Container untuk Form Dinamis -->
                <div id="dynamicFormsPustu" class="mt-4"></div>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> &nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                const jumlahPustuInput = document.getElementById("jumlahPustu");
                const formContainer = document.getElementById("dynamicFormsPustu");

                jumlahPustuInput.addEventListener("input", function() {
                  const jumlah = parseInt(this.value);
                  formContainer.innerHTML = "";

                  if (!isNaN(jumlah) && jumlah > 0) {
                    if (jumlah > 50) {
                      alert("Maksimal jumlah form yang dapat dibuat adalah 50.");
                      jumlahPustuInput.value = 50;
                    }

                    const maxJumlah = Math.min(jumlah, 50);
                    for (let i = 1; i <= maxJumlah; i++) {
                      const formTemplate = `
              <div class="border p-3 mb-3">
                <div class="card-header mb-3">
                  <h4 class="card-title">PUSTU Ke-${i}</h4>
                </div>
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama PUSTU</label>
                    <input
                      name="nama_pustu_${i}"
                      type="text"
                      class="form-control"
                      placeholder="Masukkan Nama PUSTU"
                      required
                    />
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Alamat PUSTU</label>
                    <textarea
                      name="alamat_pustu_${i}"
                      class="form-control"
                      rows="3"
                      placeholder="Isi Alamat PUSTU"
                      required
                    ></textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Kecamatan</label>
                    <input
                      name="nama_kecamatan_pustu_${i}"
                      type="text"
                      class="form-control"
                      placeholder="Masukkan Nama Kecamatan"
                      required
                    />
                  </div>
                  <div class="titik_koordinat">
                    <label>Titik Koordinat</label>
                    <div class="row">
                      <div class="col-md-6">
                        <label>Koordinat Lintang</label>
                        <input
                          name="koordinat_lintang_${i}"
                          type="text"
                          class="form-control"
                          placeholder="-6.8796 LS"
                          required
                        />
                      </div>
                      <div class="col-md-6">
                        <label>Koordinat Bujur</label>
                        <input
                          name="koordinat_bujur_${i}"
                          type="text"
                          class="form-control"
                          placeholder="108.5538 BT"
                          required
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
                      formContainer.insertAdjacentHTML("beforeend", formTemplate);
                    }
                  }
                });
              });
            </script>

            <!-- Modal Info -->
            <div class="modal fade" id="infoModalPustu" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Panduan Pengisian Data PUSTU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Isi Nama PUSTU dengan nama resmi yang terdaftar.</li>
                      <li>Isi Alamat PUSTU dengan lengkap.</li>
                      <li>Isi Nama Kecamatan tempat PUSTU berada.</li>
                      <li>Masukkan koordinat dalam format derajat desimal.</li>
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
              <h3 class="card-title">Daftar Poliklinik Atau Balai Pengobatan</h3>

              <!-- BEGIN:: INFO BUTTON -->
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#infoModalPoliklinik">
                <i class="fas fa-info-circle"></i>
              </button>
              <!-- Modal Info -->
              <div class="modal fade" id="infoModalPoliklinik" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="infoModalLabel">Panduan Pengisian Data Poliklinik Atau Balai Pengobatan</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <ul>
                        <li>Isi Nama Poliklinik atau Balai Pengobatan sesuai dengan nama resmi.</li>
                        <li>Isi Alamat dengan lengkap dan jelas.</li>
                        <li>Isi Nama Kecamatan di lokasi Poliklinik atau Balai Pengobatan.</li>
                        <li>Koordinat Lintang diisi dengan format derajat desimal (misalnya: -6.8796 LS).</li>
                        <li>Koordinat Bujur diisi dengan format derajat desimal (misalnya: 108.5538 BT).</li>
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
                <button type="button" class="btn btn-tool addButton5">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".addButton5").on("click", function() {
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
              <div class="form-group mb-3">
                <label class="mb-2">Jumlah Poliklinik/Balai Pengobatan</label>
                <input type="number" id="jumlahPoliklinik" class="form-control" placeholder="Masukkan jumlah Poliklinik/Balai Pengobatan" min="0" step="1" required>
              </div>

              <!-- Container untuk Form Dinamis -->
              <div id="dynamicFormsPoliklinik" class="mt-4"></div>

              <div class="mb-2">
                <button type="submit" class="btn btn-primary mt-3">
                  <i class="fas fa-save"></i> &nbsp; Simpan
                </button>
              </div>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                const jumlahPoliklinikInput = document.getElementById('jumlahPoliklinik');
                const formContainer = document.getElementById('dynamicFormsPoliklinik');

                jumlahPoliklinikInput.addEventListener('input', function() {
                  const jumlah = parseInt(this.value);
                  formContainer.innerHTML = '';

                  if (!isNaN(jumlah) && jumlah > 0) {
                    if (jumlah > 50) {
                      alert("Maksimal jumlah form yang dapat dibuat adalah 50.");
                      jumlahPoliklinikInput.value = 50; // Set nilai input menjadi 50 jika lebih
                    }

                    const maxJumlah = Math.min(jumlah, 50); // Batas maksimal adalah 50
                    for (let i = 1; i <= maxJumlah; i++) {
                      const formTemplate = `
              <div class="border p-3 mb-3">
                <div class="card-header mb-3">
                  <h2 class="card-title mb-3">Poliklinik/Balai Pengobatan Ke-${i}</h2>
                </div>
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Poliklinik/Balai Pengobatan</label>
                    <input id="nama_poliklinik_ke${i}" type="text" class="form-control" placeholder="Masukkan Nama Poliklinik/Balai Pengobatan">
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Alamat Poliklinik/Balai Pengobatan</label>
                    <textarea id="alamat_poliklinik_ke${i}" class="form-control" rows="3" placeholder="Isi Alamat Poliklinik/Balai Pengobatan"></textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Kecamatan</label>
                    <input id="nama_kecamatan_ke${i}" type="text" class="form-control" placeholder="Masukkan Nama Kecamatan">
                  </div>
                  <div class="titik_koordinat">
                    <label for="titik_koordinat_ke${i}">Titik Koordinat</label>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="koordinat_lintang_ke${i}">Koordinat Lintang</label>
                        <input id="koordinat_lintang_ke${i}" type="text" class="form-control" placeholder="-6.8796 LS">
                      </div>
                      <div class="col-md-6">
                        <label for="koordinat_bujur_ke${i}">Koordinat Bujur</label>
                        <input id="koordinat_bujur_ke${i}" type="text" class="form-control" placeholder="108.5538 BT">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
                      formContainer.insertAdjacentHTML('beforeend', formTemplate);
                    }
                  }
                });
              });
            </script>
          </div>

          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Daftar Apotek</h3>

              <!-- BEGIN:: INFO BUTTON -->
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#infoModalApotek">
                <i class="fas fa-info-circle"></i>
              </button>
              <!-- Modal Info -->
              <div class="modal fade" id="infoModalApotek" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="infoModalLabel">Panduan Pengisian Data Apotek</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <ul>
                        <li>Isi Nama Apotek dengan nama resmi apotek.</li>
                        <li>Isi Alamat Apotek dengan lengkap dan benar.</li>
                        <li>Isi Nama Kecamatan tempat Apotek berada.</li>
                        <li>Koordinat Lintang dan Bujur diisi dalam format derajat desimal.</li>
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
                <button type="button" class="btn btn-tool addButton10">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".addButton10").on("click", function() {
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
              <div class="form-group mb-3">
                <label class="mb-2">Jumlah Apotek</label>
                <input type="number" id="jumlahApotek" class="form-control" placeholder="Masukkan jumlah Apotek" min="0" step="1" required>
              </div>

              <!-- Container untuk Form Dinamis -->
              <div id="dynamicFormsApotek" class="mt-4"></div>

              <div class="mb-2">
                <button type="submit" class="btn btn-primary mt-3">
                  <i class="fas fa-save"></i> &nbsp; Simpan
                </button>
              </div>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                const jumlahApotekInput = document.getElementById('jumlahApotek');
                const formContainer = document.getElementById('dynamicFormsApotek');

                jumlahApotekInput.addEventListener('input', function() {
                  const jumlah = parseInt(this.value);
                  formContainer.innerHTML = '';

                  if (!isNaN(jumlah) && jumlah > 0) {
                    if (jumlah > 50) {
                      alert("Maksimal jumlah form yang dapat dibuat adalah 50.");
                      jumlahApotekInput.value = 50; // Set nilai input menjadi 50 jika lebih
                    }

                    const maxJumlah = Math.min(jumlah, 50); // Batas maksimal adalah 50
                    for (let i = 1; i <= maxJumlah; i++) {
                      const formTemplate = `
              <div class="border p-3 mb-3">
                <div class="card-header mb-3">
                  <h2 class="card-title mb-3">Apotek Ke-${i}</h2>
                </div>
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Apotek</label>
                    <input id="nama_apotek_ke${i}" type="text" class="form-control" placeholder="Masukkan Nama Apotek">
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Alamat Apotek</label>
                    <textarea id="alamat_apotek_ke${i}" class="form-control" rows="3" placeholder="Isi Alamat Apotek"></textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Kecamatan</label>
                    <input id="nama_kecamatan_ke${i}" type="text" class="form-control" placeholder="Masukkan Nama Kecamatan">
                  </div>
                  <div class="titik_koordinat">
                    <label for="titik_koordinat_ke${i}">Titik Koordinat</label>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="koordinat_lintang_ke${i}">Koordinat Lintang</label>
                        <input id="koordinat_lintang_ke${i}" type="text" class="form-control" placeholder="-6.8796 LS">
                      </div>
                      <div class="col-md-6">
                        <label for="koordinat_bujur_ke${i}">Koordinat Bujur</label>
                        <input id="koordinat_bujur_ke${i}" type="text" class="form-control" placeholder="108.5538 BT">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
                      formContainer.insertAdjacentHTML('beforeend', formTemplate);
                    }
                  }
                });
              });
            </script>
          </div>

          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Daftar Praktek Dokter</h3>

              <!-- BEGIN:: INFO BUTTON -->
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#infoModalPraktekDokter">
                <i class="fas fa-info-circle"></i>
              </button>
              <!-- Modal Info -->
              <div class="modal fade" id="infoModalPraktekDokter" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="infoModalLabel">Panduan Pengisian Data Praktek Dokter</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <ul>
                        <li>Isi Nama Praktek Dokter dengan nama resmi praktek.</li>
                        <li>Isi Alamat Praktek Dokter dengan lengkap dan benar.</li>
                        <li>Isi Nama Kecamatan tempat praktek dokter berada.</li>
                        <li>Koordinat Lintang dan Bujur diisi dalam format derajat desimal.</li>
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
                <button type="button" class="btn btn-tool addButton6">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".addButton6").on("click", function() {
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
              <div class="form-group mb-3">
                <label class="mb-2">Jumlah Praktek Dokter</label>
                <input type="number" id="jumlahPraktekDokter" class="form-control" placeholder="Masukkan jumlah Praktek Dokter" min="0" step="1" required>
              </div>

              <!-- Container untuk Form Dinamis -->
              <div id="dynamicFormsPraktekDokter" class="mt-4"></div>

              <div class="mb-2">
                <button type="submit" class="btn btn-primary mt-3">
                  <i class="fas fa-save"></i> &nbsp; Simpan
                </button>
              </div>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                const jumlahPraktekDokterInput = document.getElementById('jumlahPraktekDokter');
                const formContainer = document.getElementById('dynamicFormsPraktekDokter');

                jumlahPraktekDokterInput.addEventListener('input', function() {
                  const jumlah = parseInt(this.value);
                  formContainer.innerHTML = '';

                  if (!isNaN(jumlah) && jumlah > 0) {
                    if (jumlah > 50) {
                      alert("Maksimal jumlah form yang dapat dibuat adalah 50.");
                      jumlahPraktekDokterInput.value = 50; // Set nilai input menjadi 50 jika lebih
                    }

                    const maxJumlah = Math.min(jumlah, 50); // Batas maksimal adalah 50
                    for (let i = 1; i <= maxJumlah; i++) {
                      const formTemplate = `
              <div class="border p-3 mb-3">
                <div class="card-header mb-3">
                  <h2 class="card-title mb-3">Praktek Dokter Ke-${i}</h2>
                </div>
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Praktek Dokter</label>
                    <input id="nama_praktek_dokter_ke${i}" type="text" class="form-control" placeholder="Masukkan Nama Praktek Dokter">
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Alamat Praktek Dokter</label>
                    <textarea id="alamat_praktek_dokter_ke${i}" class="form-control" rows="3" placeholder="Isi Alamat Praktek Dokter"></textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Kecamatan</label>
                    <input id="nama_kecamatan_ke${i}" type="text" class="form-control" placeholder="Masukkan Nama Kecamatan">
                  </div>
                  <div class="titik_koordinat">
                    <label for="titik_koordinat_ke${i}">Titik Koordinat</label>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="koordinat_lintang_ke${i}">Koordinat Lintang</label>
                        <input id="koordinat_lintang_ke${i}" type="text" class="form-control" placeholder="-6.8796 LS">
                      </div>
                      <div class="col-md-6">
                        <label for="koordinat_bujur_ke${i}">Koordinat Bujur</label>
                        <input id="koordinat_bujur_ke${i}" type="text" class="form-control" placeholder="108.5538 BT">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
                      formContainer.insertAdjacentHTML('beforeend', formTemplate);
                    }
                  }
                });
              });
            </script>
          </div>

          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Daftar Praktek Bidan</h3>

              <!-- BEGIN:: INFO BUTTON -->
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#infoModalPraktekBidan">
                <i class="fas fa-info-circle"></i>
              </button>
              <!-- Modal Info -->
              <div class="modal fade" id="infoModalPraktekBidan" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="infoModalLabel">Panduan Pengisian Data Praktek Bidan</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <ul>
                        <li>Isi Nama Praktek Bidan dengan nama resmi praktek.</li>
                        <li>Isi Alamat Praktek Bidan dengan lengkap dan benar.</li>
                        <li>Isi Nama Kecamatan tempat praktek bidan berada.</li>
                        <li>Koordinat Lintang dan Bujur diisi dalam format derajat desimal.</li>
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
                <button type="button" class="btn btn-tool addButton7">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".addButton7").on("click", function() {
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
              <div class="form-group mb-3">
                <label class="mb-2">Jumlah Praktek Bidan</label>
                <input type="number" id="jumlahPraktekBidan" class="form-control" placeholder="Masukkan jumlah Praktek Bidan" min="0" step="1" required>
              </div>

              <!-- Container untuk Form Dinamis -->
              <div id="dynamicFormsPraktekBidan" class="mt-4"></div>

              <div class="mb-2">
                <button type="submit" class="btn btn-primary mt-3">
                  <i class="fas fa-save"></i> &nbsp; Simpan
                </button>
              </div>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                const jumlahPraktekBidanInput = document.getElementById('jumlahPraktekBidan');
                const formContainer = document.getElementById('dynamicFormsPraktekBidan');

                jumlahPraktekBidanInput.addEventListener('input', function() {
                  const jumlah = parseInt(this.value);
                  formContainer.innerHTML = '';

                  if (!isNaN(jumlah) && jumlah > 0) {
                    if (jumlah > 50) {
                      alert("Maksimal jumlah form yang dapat dibuat adalah 50.");
                      jumlahPraktekBidanInput.value = 50; // Set nilai input menjadi 50 jika lebih
                    }

                    const maxJumlah = Math.min(jumlah, 50); // Batas maksimal adalah 50
                    for (let i = 1; i <= maxJumlah; i++) {
                      const formTemplate = `
              <div class="border p-3 mb-3">
                <div class="card-header mb-3">
                  <h2 class="card-title mb-3">Praktek Bidan Ke-${i}</h2>
                </div>
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Praktek Bidan</label>
                    <input id="nama_praktek_bidan_ke${i}" type="text" class="form-control" placeholder="Masukkan Nama Praktek Bidan">
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Alamat Praktek Bidan</label>
                    <textarea id="alamat_praktek_bidan_ke${i}" class="form-control" rows="3" placeholder="Isi Alamat Praktek Bidan"></textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Kecamatan</label>
                    <input id="nama_kecamatan_ke${i}" type="text" class="form-control" placeholder="Masukkan Nama Kecamatan">
                  </div>
                  <div class="titik_koordinat">
                    <label for="titik_koordinat_ke${i}">Titik Koordinat</label>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="koordinat_lintang_ke${i}">Koordinat Lintang</label>
                        <input id="koordinat_lintang_ke${i}" type="text" class="form-control" placeholder="-6.8796 LS">
                      </div>
                      <div class="col-md-6">
                        <label for="koordinat_bujur_ke${i}">Koordinat Bujur</label>
                        <input id="koordinat_bujur_ke${i}" type="text" class="form-control" placeholder="108.5538 BT">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
                      formContainer.insertAdjacentHTML('beforeend', formTemplate);
                    }
                  }
                });
              });
            </script>
          </div>

          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Daftar Pos Kesehatan Desa (POSKESDES)</h3>

              <!-- BEGIN:: INFO BUTTON -->
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#infoModalPoskesdes">
                <i class="fas fa-info-circle"></i>
              </button>
              <!-- Modal Info -->
              <div class="modal fade" id="infoModalPoskesdes" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="infoModalLabel">Panduan Pengisian Data POSKESDES</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <ul>
                        <li>Isi Nama POSKESDES dengan nama resmi pos kesehatan desa.</li>
                        <li>Isi Alamat POSKESDES dengan lengkap dan benar.</li>
                        <li>Isi Nama Kecamatan tempat POSKESDES berada.</li>
                        <li>Koordinat Lintang dan Bujur diisi dalam format derajat desimal.</li>
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
                <button type="button" class="btn btn-tool addButton8">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".addButton8").on("click", function() {
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
              <div class="form-group mb-3">
                <label class="mb-2">Jumlah POSKESDES</label>
                <input type="number" id="jumlahPoskesdes" class="form-control" placeholder="Masukkan jumlah POSKESDES" min="0" step="1" required>
              </div>

              <!-- Container untuk Form Dinamis -->
              <div id="dynamicFormsPoskesdes" class="mt-4"></div>

              <div class="mb-2">
                <button type="submit" class="btn btn-primary mt-3">
                  <i class="fas fa-save"></i> &nbsp; Simpan
                </button>
              </div>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                const jumlahPoskesdesInput = document.getElementById('jumlahPoskesdes');
                const formContainer = document.getElementById('dynamicFormsPoskesdes');

                jumlahPoskesdesInput.addEventListener('input', function() {
                  const jumlah = parseInt(this.value);
                  formContainer.innerHTML = '';

                  if (!isNaN(jumlah) && jumlah > 0) {
                    if (jumlah > 50) {
                      alert("Maksimal jumlah form yang dapat dibuat adalah 50.");
                      jumlahPoskesdesInput.value = 50; // Set nilai input menjadi 50 jika lebih
                    }

                    const maxJumlah = Math.min(jumlah, 50); // Batas maksimal adalah 50
                    for (let i = 1; i <= maxJumlah; i++) {
                      const formTemplate = `
              <div class="border p-3 mb-3">
                <div class="card-header mb-3">
                  <h2 class="card-title mb-3">POSKESDES Ke-${i}</h2>
                </div>
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama POSKESDES</label>
                    <input id="nama_poskesdes_ke${i}" type="text" class="form-control" placeholder="Masukkan Nama POSKESDES">
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Alamat POSKESDES</label>
                    <textarea id="alamat_poskesdes_ke${i}" class="form-control" rows="3" placeholder="Isi Alamat POSKESDES"></textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Kecamatan</label>
                    <input id="nama_kecamatan_ke${i}" type="text" class="form-control" placeholder="Masukkan Nama Kecamatan">
                  </div>
                  <div class="titik_koordinat">
                    <label for="titik_koordinat_ke${i}">Titik Koordinat</label>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="koordinat_lintang_ke${i}">Koordinat Lintang</label>
                        <input id="koordinat_lintang_ke${i}" type="text" class="form-control" placeholder="-6.8796 LS">
                      </div>
                      <div class="col-md-6">
                        <label for="koordinat_bujur_ke${i}">Koordinat Bujur</label>
                        <input id="koordinat_bujur_ke${i}" type="text" class="form-control" placeholder="108.5538 BT">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
                      formContainer.insertAdjacentHTML('beforeend', formTemplate);
                    }
                  }
                });
              });
            </script>
          </div>

          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Daftar Pondok Bersalin Desa (POLINDES)</h3>

              <!-- BEGIN:: INFO BUTTON -->
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#infoModalPolindes">
                <i class="fas fa-info-circle"></i>
              </button>
              <!-- Modal Info -->
              <div class="modal fade" id="infoModalPolindes" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="infoModalLabel">Panduan Pengisian Data POLINDES</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <ul>
                        <li>Isi Nama POLINDES dengan nama resmi pondok bersalin desa.</li>
                        <li>Isi Alamat POLINDES dengan lengkap dan benar.</li>
                        <li>Isi Nama Kecamatan tempat POLINDES berada.</li>
                        <li>Koordinat Lintang dan Bujur diisi dalam format derajat desimal.</li>
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
                <button type="button" class="btn btn-tool addButton9">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".addButton9").on("click", function() {
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
              <div class="form-group mb-3">
                <label class="mb-2">Jumlah POLINDES</label>
                <input type="number" id="jumlahPolindes" class="form-control" placeholder="Masukkan jumlah POLINDES" min="0" step="1" required>
              </div>

              <!-- Container for Dynamic Forms -->
              <div id="dynamicFormsPolindes" class="mt-4"></div>

              <div class="mb-2">
                <button type="submit" class="btn btn-primary mt-3">
                  <i class="fas fa-save"></i> &nbsp; Simpan
                </button>
              </div>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                const jumlahPolindesInput = document.getElementById('jumlahPolindes');
                const formContainer = document.getElementById('dynamicFormsPolindes');

                jumlahPolindesInput.addEventListener('input', function() {
                  const jumlah = parseInt(this.value);
                  formContainer.innerHTML = '';

                  if (!isNaN(jumlah) && jumlah > 0) {
                    if (jumlah > 50) {
                      alert("Maksimal jumlah form yang dapat dibuat adalah 50.");
                      jumlahPolindesInput.value = 50; // Set nilai input menjadi 50 jika lebih
                    }

                    const maxJumlah = Math.min(jumlah, 50); // Batas maksimal adalah 50
                    for (let i = 1; i <= maxJumlah; i++) {
                      const formTemplate = `
              <div class="border p-3 mb-3">
                <div class="card-header mb-3">
                  <h2 class="card-title mb-3">POLINDES Ke-${i}</h2>
                </div>
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama POLINDES</label>
                    <input id="nama_polindes_ke${i}" type="text" class="form-control" placeholder="Masukkan Nama POLINDES">
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Alamat POLINDES</label>
                    <textarea id="alamat_polindes_ke${i}" class="form-control" rows="3" placeholder="Isi Alamat POLINDES"></textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Kecamatan</label>
                    <input id="nama_kecamatan_ke${i}" type="text" class="form-control" placeholder="Masukkan Nama Kecamatan">
                  </div>
                  <div class="titik_koordinat">
                    <label for="titik_koordinat_ke${i}">Titik Koordinat</label>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="koordinat_lintang_ke${i}">Koordinat Lintang</label>
                        <input id="koordinat_lintang_ke${i}" type="text" class="form-control" placeholder="-6.8796 LS">
                      </div>
                      <div class="col-md-6">
                        <label for="koordinat_bujur_ke${i}">Koordinat Bujur</label>
                        <input id="koordinat_bujur_ke${i}" type="text" class="form-control" placeholder="108.5538 BT">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
                      formContainer.insertAdjacentHTML('beforeend', formTemplate);
                    }
                  }
                });
              });
            </script>
          </div>

          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Daftar POSYANDU</h3>

              <!-- BEGIN:: INFO BUTTON -->
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#infoModalPosyandu">
                <i class="fas fa-info-circle"></i>
              </button>
              <!-- Modal Info -->
              <div class="modal fade" id="infoModalPosyandu" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="infoModalLabel">Panduan Pengisian Data POSYANDU</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <ul>
                        <li>Isi Nama POSYANDU dengan nama resmi POSYANDU.</li>
                        <li>Isi Alamat POSYANDU dengan lengkap dan benar.</li>
                        <li>Isi Nama Kecamatan tempat POSYANDU berada.</li>
                        <li>Koordinat Lintang dan Bujur diisi dalam format derajat desimal.</li>
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
                <button type="button" class="btn btn-tool addButton11">
                  <i class="fas fa-minus"></i>
                </button>
                <script>
                  $(document).ready(function() {
                    $(".addButton11").on("click", function() {
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
              <div class="form-group mb-3">
                <label class="mb-2">Jumlah POSYANDU</label>
                <input type="number" id="jumlahPosyandu" class="form-control" placeholder="Masukkan jumlah POSYANDU" min="0" step="1" required>
              </div>

              <!-- Container for Dynamic Forms -->
              <div id="dynamicFormsPosyandu" class="mt-4"></div>

              <div class="mb-2">
                <button type="submit" class="btn btn-primary mt-3">
                  <i class="fas fa-save"></i> &nbsp; Simpan
                </button>
              </div>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", function() {
                const jumlahPosyanduInput = document.getElementById('jumlahPosyandu');
                const formContainer = document.getElementById('dynamicFormsPosyandu');

                jumlahPosyanduInput.addEventListener('input', function() {
                  const jumlah = parseInt(this.value);
                  formContainer.innerHTML = '';

                  if (!isNaN(jumlah) && jumlah > 0) {
                    if (jumlah > 50) {
                      alert("Maksimal jumlah form yang dapat dibuat adalah 50.");
                      jumlahPosyanduInput.value = 50; // Set nilai input menjadi 50 jika lebih
                    }

                    const maxJumlah = Math.min(jumlah, 50); // Batas maksimal adalah 50
                    for (let i = 1; i <= maxJumlah; i++) {
                      const formTemplate = `
              <div class="border p-3 mb-3">
                <div class="card-header mb-3">
                  <h2 class="card-title mb-3">POSYANDU Ke-${i}</h2>
                </div>
                <div class="row">
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama POSYANDU</label>
                    <input id="nama_posyandu_ke${i}" type="text" class="form-control" placeholder="Masukkan Nama POSYANDU">
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Alamat POSYANDU</label>
                    <textarea id="alamat_posyandu_ke${i}" class="form-control" rows="3" placeholder="Isi Alamat POSYANDU"></textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label class="mb-2">Nama Kecamatan</label>
                    <input id="nama_kecamatan_ke${i}" type="text" class="form-control" placeholder="Masukkan Nama Kecamatan">
                  </div>
                  <div class="titik_koordinat">
                    <label for="titik_koordinat_ke${i}">Titik Koordinat</label>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="koordinat_lintang_ke${i}">Koordinat Lintang</label>
                        <input id="koordinat_lintang_ke${i}" type="text" class="form-control" placeholder="-6.8796 LS">
                      </div>
                      <div class="col-md-6">
                        <label for="koordinat_bujur_ke${i}">Koordinat Bujur</label>
                        <input id="koordinat_bujur_ke${i}" type="text" class="form-control" placeholder="108.5538 BT">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
                      formContainer.insertAdjacentHTML('beforeend', formTemplate);
                    }
                  }
                });
              });
            </script>
          </div>

        </div>
      </div>
      <!--end::App Content-->
    </main>
    <!--end::App Main-->
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