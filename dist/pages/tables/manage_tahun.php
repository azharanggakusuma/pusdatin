<?php
include_once('../../config/conn.php');
include "../../config/session.php";

// Query untuk mengambil data sesuai halaman
$query = "SELECT * FROM tahun";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  $years = [];
  while ($row = $result->fetch_assoc()) {
    $years[] = $row;
  }
} else {
  $years = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>PUSDATIN | Data Tahun</title>
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

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <link rel="shortcut icon" href="../../img/kominfo.png" type="image/x-icon">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <div class="app-wrapper">
    <?php include('../../components/navbar.php'); ?>
    <?php include('../../components/sidebar.php'); ?>

    <main class="app-main">
      <div class="app-content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Data Tahun</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Tahun</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="app-content">
        <div class="container-fluid">

          <?php if (isset($_GET['messageadd'])): ?>
            <script>
              let messageadd = "<?= $_GET['messageadd'] ?>";
              let reason = "<?= $_GET['reason'] ?? '' ?>";

              if (messageadd === 'success') {
                Swal.fire({
                  title: "Berhasil!",
                  text: "Data tahun berhasil ditambahkan.",
                  icon: "success",
                  timer: 3000,
                  timerProgressBar: true, // Mengaktifkan progres timer
                  showConfirmButton: false // Tombol tidak ditampilkan
                }).then(() => {
                  window.location.href = "manage_tahun.php";
                });
              } else if (messageadd === 'error') {
                let errorMessage = "";
                if (reason === 'exists') {
                  errorMessage = "Tahun yang dimasukkan sudah ada!";
                } else if (reason === 'before2024') {
                  errorMessage = "Tahun harus lebih besar atau sama dengan 2024!";
                } else {
                  errorMessage = "Terjadi kesalahan saat menambahkan data.";
                }
                Swal.fire({
                  title: "Gagal!",
                  text: errorMessage,
                  icon: "error",
                  timer: 3000,
                  timerProgressBar: true, // Mengaktifkan progres timer
                  showConfirmButton: false // Tombol tidak ditampilkan
                }).then(() => {
                  window.location.href = "manage_tahun.php";
                });
              }
            </script>
          <?php endif; ?>

          <?php if (isset($_GET['messageedit'])): ?>
            <script>
              let messageedit = "<?= $_GET['messageedit'] ?>";
              let reason = "<?= $_GET['reason'] ?? '' ?>";

              if (messageedit === 'success') {
                Swal.fire({
                  title: "Berhasil!",
                  text: "Data tahun berhasil diperbarui.",
                  icon: "success",
                  timer: 3000,
                  timerProgressBar: true, // Timer dengan progres bar
                  showConfirmButton: false // Tidak ada tombol
                }).then(() => {
                  window.location.href = "manage_tahun.php";
                });
              } else if (messageedit === 'error') {
                let errorMessage = "";
                if (reason === 'exists') {
                  errorMessage = "Tahun yang dimasukkan sudah ada!";
                } else if (reason === 'before2024') {
                  errorMessage = "Tahun harus lebih besar atau sama dengan 2024!";
                } else {
                  errorMessage = "Terjadi kesalahan saat memperbarui data.";
                }
                Swal.fire({
                  title: "Gagal!",
                  text: errorMessage,
                  icon: "error",
                  timer: 3000,
                  timerProgressBar: true,
                  showConfirmButton: false
                }).then(() => {
                  window.location.href = "manage_tahun.php";
                });
              }
            </script>
          <?php endif; ?>

          <?php if (isset($_GET['messagedelete'])): ?>
            <script>
              let messagedelete = "<?= $_GET['messagedelete'] ?>";

              if (messagedelete === 'success') {
                Swal.fire({
                  title: "Berhasil!",
                  text: "Data tahun berhasil dihapus.",
                  icon: "success",
                  timer: 3000,
                  timerProgressBar: true,
                  showConfirmButton: false
                }).then(() => {
                  window.location.href = "manage_tahun.php";
                });
              } else if (messagedelete === 'error') {
                Swal.fire({
                  title: "Gagal!",
                  text: "Terjadi kesalahan saat menghapus data.",
                  icon: "error",
                  timer: 3000,
                  timerProgressBar: true,
                  showConfirmButton: false
                }).then(() => {
                  window.location.href = "manage_tahun.php";
                });
              }
            </script>
          <?php endif; ?>

          <!-- Modal Tambah Tahun -->
          <div class="modal fade" id="addYearModal" tabindex="-1" aria-labelledby="addYearModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="../../handlers/add_tahun.php" method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addYearModalLabel">Tambah Tahun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label for="year" class="form-label">Tahun</label>
                      <input type="number" class="form-control" id="year" name="year" placeholder="Masukkan tahun" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>&nbsp; Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal Edit Tahun -->
          <div class="modal fade" id="editYearModal" tabindex="-1" aria-labelledby="editYearModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="../../handlers/edit_tahun.php" method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editYearModalLabel">Edit Tahun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" id="editYearId" name="id">
                    <div class="mb-3">
                      <label for="editYear" class="form-label">Tahun</label>
                      <input type="text" class="form-control" id="editYear" name="year" placeholder="Tahun" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i>&nbsp; Update</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <script>
            // Fungsi untuk mengisi modal dengan data tahun yang akan diedit
            function editYear(id, year) {
              // Mengisi field ID dan Tahun pada modal
              document.getElementById('editYearId').value = id;
              document.getElementById('editYear').value = year;
            }
          </script>

          <!-- Modal Hapus Tahun -->
          <div class="modal fade" id="deleteYearModal" tabindex="-1" aria-labelledby="deleteYearModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="../../handlers/delete_tahun.php" method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteYearModalLabel">Hapus Tahun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data tahun ini?</p>
                    <input type="hidden" id="deleteYearId" name="id">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i>&nbsp; Hapus</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <script>
            // Fungsi untuk mengisi modal dengan ID tahun yang akan dihapus
            function setDeleteYearId(id) {
              document.getElementById('deleteYearId').value = id;
            }
          </script>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Manage Tahun</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#addYearModal">
                  <i class="fas fa-plus"></i> &nbsp; Add Tahun
                </button>
              </div>
            </div>
            <div class="card-body p-0" style="overflow-x: auto;">
              <table class="table table-striped" style="table-layout: auto; width: 100%;">
                <thead>
                  <tr style="white-space: nowrap;">
                    <th>#</th>
                    <th>Year</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($years)): ?>
                    <?php foreach ($years as $index => $year): ?>
                      <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($year['year'] ?? 'Data tidak tersedia') ?></td>
                        <td class="project-actions">
                          <a class="btn btn-warning btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#editYearModal"
                            onclick="editYear(<?= $year['id'] ?>, '<?= htmlspecialchars($year['year'] ?? '') ?>')">
                            <i class="fas fa-edit"></i>
                          </a>
                          &nbsp;
                          <a class="btn btn-danger btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#deleteYearModal"
                            onclick="setDeleteYearId(<?= $year['id'] ?>)">
                            <i class="fas fa-trash"></i>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="3" class="text-center">Tidak ada data.</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </main>

    <?php include("../../components/footer.php"); ?>
  </div>

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
</body>

</html>