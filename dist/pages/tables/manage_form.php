<?php
// Menghubungkan ke database
include '../../config/conn.php';
include '../../config/session.php';

// Ambil data pengguna yang sedang login
$name = $_SESSION['name'] ?? '';
$level = $_SESSION['level'] ?? '';

// Variabel untuk SweetAlert
$sweetalert_message = '';
$error_message = '';

if ($level !== 'admin') {
  echo "Access denied. Only admin can access this page.";
  exit;
}

// Ambil data semua user untuk memilih user berdasarkan nama
$query_all_users = "SELECT id, name FROM users";
$result_all_users = mysqli_query($conn, $query_all_users);

// Mengubah status kunci form jika form di-submit
if (isset($_POST['form_name'])) {
  $form_name = $_POST['form_name'];
  $selected_user_id = $_POST['user_id'];
  $is_locked = isset($_POST['is_locked']) ? $_POST['is_locked'] : '';

  if ($is_locked === '') {
    $error_message = "Please select a lock status.";
  } else {
    $is_locked = ($is_locked === 'true') ? 1 : 0;

    $query_check = "SELECT * FROM user_progress WHERE user_id = '$selected_user_id' AND form_name = '$form_name'";
    $result_check = mysqli_query($conn, $query_check);

    if (mysqli_num_rows($result_check) > 0) {
      $query_update = "UPDATE user_progress SET is_locked = '$is_locked', updated_at = NOW() WHERE user_id = '$selected_user_id' AND form_name = '$form_name'";
      if (mysqli_query($conn, $query_update)) {
        $sweetalert_message = "Status form berhasil diperbarui!";
      } else {
        $error_message = "Terjadi kesalahan saat memperbarui status.";
      }
    } else {
      $error_message = "Status form tidak ditemukan untuk pengguna ini.";
    }
  }
}

// Mengubah status semua form sekaligus
if (isset($_POST['all_forms_action'])) {
  $all_forms_action = $_POST['all_forms_action'];

  if ($all_forms_action === 'lock_all') {
    $query_update_all = "UPDATE user_progress SET is_locked = 1, updated_at = NOW()";
    if (mysqli_query($conn, $query_update_all)) {
      $sweetalert_message = "Semua form berhasil dikunci!";
    } else {
      $error_message = "Terjadi kesalahan saat mengunci semua form.";
    }
  } elseif ($all_forms_action === 'unlock_all') {
    $query_update_all = "UPDATE user_progress SET is_locked = 0, updated_at = NOW()";
    if (mysqli_query($conn, $query_update_all)) {
      $sweetalert_message = "Semua form berhasil dibuka!";
    } else {
      $error_message = "Terjadi kesalahan saat membuka semua form.";
    }
  }
}

// Mengambil status form untuk setiap user dan form
include('../../config/list_form.php');
?>

<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>PUSDATIN | Data Form</title><!--begin::Primary Meta Tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="title" content="AdminLTE 4 | General Form Elements">
  <meta name="author" content="ColorlibHQ">
  <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
  <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin: Plugin(AdminLTE)-->
  <link rel="stylesheet" href="../../../dist/css/adminlte.css"><!--end: Plugin(AdminLTE)-->

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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="shortcut icon" href="../../img/kominfo.png" type="image/x-icon">
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
  <div class="app-wrapper"> <!--begin::Header-->

    <?php include('../../components/navbar.php'); ?>

    <?php include('../../components/sidebar.php'); ?>
    <!--end::Sidebar--> <!--begin::App Main-->

    <main class="app-main">
      <!--begin::App Content Header-->
      <div class="app-content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Management Form</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                <li class="breadcrumb-item active" aria-current="page">Management Form</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!--end::App Content Header-->

      <!--begin::App Content-->
      <div class="app-content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Manage Forms</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#addMenuModal">
                  <i class="fas fa-file-alt"></i> &nbsp; Edit Status Form
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table table-striped table-hover align-middle">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>User (Desa/Kelurahan)</th>
                    <th>Form Name</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($forms as $form):
                    $query_form_status = "SELECT users.name, user_progress.is_locked 
                                  FROM user_progress 
                                  JOIN users ON user_progress.user_id = users.id
                                  WHERE user_progress.form_name = ?";
                    $stmt = $conn->prepare($query_form_status);
                    $stmt->bind_param('s', $form);
                    $stmt->execute();
                    $result_form_status = $stmt->get_result();

                    while ($status = $result_form_status->fetch_assoc()):
                  ?>
                      <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($status['name']); ?></td>
                        <td><?= htmlspecialchars($form); ?></td>
                        <td>
                          <span class="badge <?= $status['is_locked'] ? 'bg-danger' : 'bg-success'; ?>">
                            <?= $status['is_locked'] ? 'Locked' : 'Unlocked'; ?>
                          </span>
                        </td>
                      </tr>
                  <?php
                    endwhile;
                  endforeach;
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!--end::App Content-->

      <!-- Modal Form Pengelolaan -->
      <div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addMenuModalLabel">Edit Status Form</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="manage_form.php" method="post">
                <div class="mb-3">
                  <label for="user_id" class="form-label">Pilih User (Desa/Kelurahan)</label>
                  <select name="user_id" id="user_id" class="form-select">
                    <option value="" disabled selected>Pilih User</option>
                    <?php while ($user_data = mysqli_fetch_assoc($result_all_users)) { ?>
                      <option value="<?= $user_data['id']; ?>"><?= $user_data['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="form_name" class="form-label">Pilih Form</label>
                  <select name="form_name" id="form_name" class="form-select">
                    <option value="" disabled selected>Pilih Form</option>
                    <?php foreach ($forms as $form) { ?>
                      <option value="<?= $form; ?>"><?= $form; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="is_locked" class="form-label">Status Form</label>
                  <select name="is_locked" id="is_locked" class="form-select">
                    <option value="" disabled selected>Pilih Status Form</option>
                    <option value="true">Terkunci</option>
                    <option value="false">Tidak Terkunci</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">Aksi Massal</label>
                  <div>
                    <button type="submit" name="all_forms_action" value="lock_all" class="btn btn-danger">
                      <i class="fas fa-lock"></i>&nbsp; Kunci Semua
                    </button>
                    &nbsp;
                    <button type="submit" name="all_forms_action" value="unlock_all" class="btn btn-primary">
                      <i class="fas fa-unlock"></i>&nbsp; Buka Semua
                    </button>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i>&nbsp; Simpan
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- SweetAlert Notifikasi -->
      <?php if (!empty($sweetalert_message)): ?>
        <script>
          swal({
            title: "Berhasil!",
            text: "<?= $sweetalert_message; ?>",
            icon: "success",
            timer: 3000,
            buttons: false
          }).then(() => {
            window.location.href = "manage_form.php";
          });
        </script>
      <?php elseif (!empty($error_message)): ?>
        <script>
          swal({
            title: "Gagal!",
            text: "<?= $error_message; ?>",
            icon: "error",
            timer: 3000,
            buttons: false
          }).then(() => {
            window.location.href = "manage_form.php";
          });
        </script>
      <?php endif; ?>

    </main>

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

  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin: Plugin(popperjs for Bootstrap 5)-->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end: Plugin(popperjs for Bootstrap 5)--><!--begin: Plugin(Bootstrap 5)-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end: Plugin(Bootstrap 5)--><!--begin: Plugin(AdminLTE)-->
  <script src="../../../dist/js/adminlte.js"></script> <!--end: Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
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