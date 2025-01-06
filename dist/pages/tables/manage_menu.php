<?php
include_once('../../config/conn.php');
include "../../config/session.php";

// Variabel untuk menampilkan SweetAlert
$sweetalert_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $menu_id = $_POST['menu_id'];
  // Pastikan status ada dalam POST, jika tidak, set nilai default (0)
  $status = isset($_POST['status']) ? $_POST['status'] : 0;

  $update_query = "UPDATE menu SET status = ? WHERE id = ?";
  $stmt = $conn->prepare($update_query);
  $stmt->bind_param("ii", $status, $menu_id);
  $stmt->execute();

  // Set message untuk SweetAlert
  $sweetalert_message = "Status menu telah diperbarui!";
}

// Ambil semua menu
$menu_query = "SELECT * FROM menu";
$menus = $conn->query($menu_query);
?>

<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>PUSDATIN | Data Menu</title><!--begin::Primary Meta Tags-->
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="shortcut icon" href="../../img/kominfo.png" type="image/x-icon">
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
  <div class="app-wrapper"> <!--begin::Header-->

    <?php include('../../components/navbar.php'); ?>

    <?php include('../../components/sidebar.php'); ?>
    <!--end::Sidebar--> <!--begin::App Main-->

    <main class="app-main"> <!--begin::App Content Header-->
      <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Management Menu</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Management Menu
                </li>
              </ol>
            </div>
          </div> <!--end::Row-->
        </div> <!--end::Container-->
      </div> <!--end::App Content Header--> <!--begin::App Content-->

      <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Manage Menu</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse" data-bs-toggle="modal" data-bs-target="#addMenuModal">
                  <i class="fas fa-plus-square"></i> &nbsp; Add Menu
                </button>
              </div>
            </div>
            <div class="card-body p-0">

              <!-- Modal Tambah -->
              <div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="addMenuModalLabel">Tambah Menu Baru</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="../../handlers/add_menu.php">
                        <div class="mb-3">
                          <label for="newMenuName" class="form-label">Nama Menu</label>
                          <input type="text" class="form-control" id="newMenuName" name="menu_name" placeholder="Masukkan nama menu" required oninput="updateURL('newMenuName', 'newMenuURL')">
                        </div>
                        <div class="mb-3">
                          <label for="newMenuURL" class="form-label">URL</label>
                          <input type="text" class="form-control" id="newMenuURL" name="menu_url" value="pages/forms/" readonly>
                        </div>
                        <div class="mb-3">
                          <label for="newMenuStatus" class="form-label">Status</label>
                          <select class="form-select" id="newMenuStatus" name="menu_status">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Nonaktif</option>
                          </select>
                        </div>
                        <div class="modal-footer">
                          <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>-->
                          <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>&nbsp; Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal Edit -->
              <div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editMenuModalLabel">Edit Menu</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="edit_menu.php">
                        <input type="hidden" name="menu_id" id="editMenuId">
                        <div class="mb-3">
                          <label for="editMenuName" class="form-label">Nama Menu</label>
                          <input type="text" class="form-control" id="editMenuName" name="menu_name" required oninput="updateURL('editMenuName', 'editMenuURL')">
                        </div>
                        <div class="mb-3">
                          <label for="editMenuURL" class="form-label">URL</label>
                          <input type="text" class="form-control" id="editMenuURL" name="menu_url" readonly>
                        </div>
                        <div class="mb-3">
                          <label for="editMenuStatus" class="form-label">Status</label>
                          <select class="form-select" id="editMenuStatus" name="menu_status">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                          </select>
                        </div>
                        <div class="modal-footer">
                          <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>-->
                          <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>&nbsp; Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal Delete -->
              <div class="modal fade" id="deleteMenuModal" tabindex="-1" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form action="../../handlers/delete_menu.php" method="POST">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteMenuModalLabel">Hapus Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus menu ini?</p>
                        <input type="hidden" id="delete_menu_id" name="id">
                      </div>
                      <div class="modal-footer">
                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>-->
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i>&nbsp; Hapus</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <script>
                function updateURL(nameFieldId, urlFieldId) {
                  var name = document.getElementById(nameFieldId).value;
                  var formattedName = name.toLowerCase().replace(/\s+/g, '_') + '.php';
                  document.getElementById(urlFieldId).value = 'pages/forms/' + formattedName;
                }

                // Function to edit menu details and populate modal fields
                function editMenu(id, name, url, status) {
                  document.getElementById('editMenuId').value = id;
                  document.getElementById('editMenuName').value = name;
                  document.getElementById('editMenuURL').value = url;
                  document.getElementById('editMenuStatus').value = status;
                  document.querySelector('#editMenuModal form').action = `../../handlers/edit_menu.php?id=${id}`;
                }

                // Function to set the menu ID for deletion in the modal
                function setDeleteMenuId(id) {
                  document.getElementById('delete_menu_id').value = id;
                }
              </script>

              <!-- Notifikasi Add -->
              <?php if (isset($_GET['messageadd'])): ?>
                <script>
                  let messageadd = "<?= $_GET['messageadd'] ?>";
                  if (messageadd === 'success') {
                    swal({
                      title: "Berhasil!",
                      text: "Menu berhasil ditambahkan.",
                      icon: "success",
                      timer: 3000,
                      buttons: false
                    }).then(() => {
                      window.location.href = "manage_menu.php";
                    });
                  } else if (messageadd === 'error') {
                    swal({
                      title: "Gagal!",
                      text: "Terjadi kesalahan saat menambahkan menu.",
                      icon: "error",
                      timer: 3000,
                      buttons: false
                    }).then(() => {
                      window.location.href = "manage_menu.php";
                    });
                  }
                </script>
              <?php endif; ?>

              <!-- Notifikasi edit -->
              <?php if (isset($_GET['messageedit'])): ?>
                <script>
                  let messageedit = "<?= $_GET['messageedit'] ?>";
                  if (messageedit === 'success') {
                    swal({
                      title: "Berhasil!",
                      text: "Menu berhasil diubah.",
                      icon: "success",
                      timer: 3000,
                      buttons: false
                    }).then(() => {
                      window.location.href = "manage_menu.php";
                    });
                  } else if (messageedit === 'error') {
                    swal({
                      title: "Gagal!",
                      text: "Terjadi kesalahan saat mengubah menu.",
                      icon: "error",
                      timer: 3000,
                      buttons: false
                    }).then(() => {
                      window.location.href = "manage_menu.php";
                    });
                  }
                </script>
              <?php endif; ?>

              <!-- Notifikasi delete -->
              <?php if (isset($_GET['messagedelete'])): ?>
                <script>
                  let messagedelete = "<?= $_GET['messagedelete'] ?>";
                  if (messagedelete === 'success') {
                    swal({
                      title: "Berhasil!",
                      text: "Menu berhasil dihapus.",
                      icon: "success",
                      timer: 3000,
                      buttons: false
                    }).then(() => {
                      window.location.href = "manage_menu.php";
                    });
                  } else if (messagedelete === 'error') {
                    swal({
                      title: "Gagal!",
                      text: "Terjadi kesalahan saat menghapus menu.",
                      icon: "error",
                      timer: 3000,
                      buttons: false
                    }).then(() => {
                      window.location.href = "manage_menu.php";
                    });
                  }
                </script>
              <?php endif; ?>

              <table class="table table-striped table-hover align-middle">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Menu Name</th>
                    <!--<th>Path</th>-->
                    <th>Current Status</th>
                    <th>Status (On/Off)</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  while ($menu = $menus->fetch_assoc()) : ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $menu['name']; ?></td>
                      <!--<td><?php //echo $menu['url']; ?></td>-->
                      <td>
                        <span class="badge <?php echo $menu['status'] ? 'bg-success' : 'bg-danger'; ?>">
                          <?php echo $menu['status'] ? 'Aktif' : 'Nonaktif'; ?>
                        </span>
                      </td>
                      <td>
                        <form method="POST" class="toggle-switch-form">
                          <input type="hidden" name="menu_id" value="<?php echo $menu['id']; ?>">
                          <div class="form-check form-switch">
                            <input class="form-check-input <?php echo $menu['status'] ? 'bg-success' : ''; ?>" type="checkbox" name="status" value="<?php echo $menu['status'] ? 0 : 1; ?>" <?php echo $menu['status'] ? 'checked' : ''; ?> onchange="this.form.submit()">
                          </div>
                        </form>
                      </td>
                      <td>
                        <a class="btn btn-warning btn-sm btn-edit" href="#" data-bs-toggle="modal" data-bs-target="#editMenuModal"
                          data-id="<?php echo $menu['id']; ?>" data-name="<?php echo $menu['name']; ?>"
                          data-url="<?php echo $menu['url']; ?>" data-status="<?php echo $menu['status']; ?>"
                          onclick="editMenu(<?php echo $menu['id']; ?>, '<?php echo $menu['name']; ?>', '<?php echo $menu['url']; ?>', '<?php echo $menu['status']; ?>')">
                          <i class="fas fa-pencil-alt"></i>
                        </a>
                        &nbsp;
                        <a class="btn btn-danger btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#deleteMenuModal"
                          data-id="<?php echo $menu['id']; ?>" onclick="setDeleteMenuId(<?php echo $menu['id']; ?>)">
                          <i class="fas fa-trash-alt"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>

              <?php if ($sweetalert_message): ?>
                <script>
                  // Menampilkan SweetAlert tanpa tombol
                  swal({
                    title: "Berhasil!",
                    text: "<?php echo $sweetalert_message; ?>",
                    icon: "success",
                    timer: 2000, // Menampilkan selama 2 detik
                    buttons: false, // Menonaktifkan tombol
                    className: "swal-modal"
                  });
                </script>
              <?php endif; ?>

            </div>
            <!-- /.card-body -->
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