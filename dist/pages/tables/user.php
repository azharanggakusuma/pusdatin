<?php
include_once('../../config/conn.php');
include "../../config/session.php";

$perPage = 100;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

// Query untuk menghitung total data
$totalQuery = "SELECT COUNT(*) as total FROM users";
$totalResult = $conn->query($totalQuery);
$totalData = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalData / $perPage);

// Query untuk mengambil data sesuai halaman
$query = "SELECT * FROM users LIMIT $perPage OFFSET $offset";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    $users = [];
}
?>

<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>PUSDATIN | Data User</title><!--begin::Primary Meta Tags-->
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
                            <h3 class="mb-0">Data User</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Data User
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content Header--> <!--begin::App Content-->

            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <!-- Notifikasi Add -->
                    <?php if (isset($_GET['messageadd'])): ?>
                        <script>
                            let messageadd = "<?= $_GET['messageadd'] ?>";
                            if (messageadd === 'success') {
                                swal({
                                    title: "Berhasil!",
                                    text: "Data user berhasil ditambahkan.",
                                    icon: "success",
                                    timer: 3000,
                                    buttons: false
                                }).then(() => {
                                    window.location.href = "user.php";
                                });
                            } else if (messageadd === 'error') {
                                swal({
                                    title: "Gagal!",
                                    text: "Terjadi kesalahan saat menambahkan data.",
                                    icon: "error",
                                    timer: 3000,
                                    buttons: false
                                }).then(() => {
                                    window.location.href = "user.php";
                                });
                            }
                        </script>
                    <?php endif; ?>

                    <!-- Modal Tambah User -->
                    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="../../handlers/add_user.php" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama User</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="level" class="form-label">Level</label>
                                            <select class="form-select" id="level" name="level" required>
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>-->
                                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>&nbsp; Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Notifikasi edit -->
                    <?php if (isset($_GET['messageedit'])): ?>
                        <script>
                            let messageedit = "<?= $_GET['messageedit'] ?>";
                            if (messageedit === 'success') {
                                swal({
                                    title: "Berhasil!",
                                    text: "Data user berhasil diubah.",
                                    icon: "success",
                                    timer: 3000,
                                    buttons: false
                                }).then(() => {
                                    window.location.href = "user.php";
                                });
                            } else if (messageedit === 'error') {
                                swal({
                                    title: "Gagal!",
                                    text: "Terjadi kesalahan saat mengubah data.",
                                    icon: "error",
                                    timer: 3000,
                                    buttons: false
                                }).then(() => {
                                    window.location.href = "user.php";
                                });
                            }
                        </script>
                    <?php endif; ?>

                    <!-- Modal Edit User -->
                    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="../../handlers/edit_user.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="edit_name" class="form-label">Nama User</label>
                                            <input type="text" class="form-control" id="edit_name" name="name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="edit_username" name="username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="edit_password" name="password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_level" class="form-label">Level</label>
                                            <select class="form-select" id="edit_level" name="level" required>
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>-->
                                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>&nbsp; Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        function editUser(id, name, username, password, level) {
                            document.getElementById('edit_name').value = name;
                            document.getElementById('edit_username').value = username;
                            document.getElementById('edit_password').value = password;
                            document.getElementById('edit_level').value = level;
                            document.querySelector('#editUserModal form').action = `../../handlers/edit_user.php?id=${id}`;
                        }
                    </script>


                    <!-- Notifikasi delete -->
                    <?php if (isset($_GET['messagedelete'])): ?>
                        <script>
                            let messagedelete = "<?= $_GET['messagedelete'] ?>";
                            if (messagedelete === 'success') {
                                swal({
                                    title: "Berhasil!",
                                    text: "Data user berhasil dihapus.",
                                    icon: "success",
                                    timer: 3000,
                                    buttons: false
                                }).then(() => {
                                    window.location.href = "user.php";
                                });
                            } else if (messagedelete === 'error') {
                                swal({
                                    title: "Gagal!",
                                    text: "Terjadi kesalahan saat menghapus data.",
                                    icon: "error",
                                    timer: 3000,
                                    buttons: false
                                }).then(() => {
                                    window.location.href = "user.php";
                                });
                            }
                        </script>
                    <?php endif; ?>

                    <!-- Modal Delete User -->
                    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="../../handlers/delete_user.php" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteUserModalLabel">Hapus User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus user ini?</p>
                                        <input type="hidden" id="delete_user_id" name="id">
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
                        function setDeleteUserId(id) {
                            document.getElementById('delete_user_id').value = id;
                        }
                    </script>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Manage Users</h3>

                            <div class="card-tools">
                                <!-- Button Tambah User -->
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            User
                                        </th>
                                        <th>
                                            Username
                                        </th>
                                        <th>
                                            Password
                                        </th>
                                        <th>
                                            Level
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($users)): ?>
                                        <?php foreach ($users as $index => $user): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($user['name']) ?></td>
                                                <td><?= htmlspecialchars($user['username']) ?></td>
                                                <td><?= htmlspecialchars($user['password']) ?></td>
                                                <td><?= htmlspecialchars($user['level']) ?></td>

                                                <td class="project-actions">
                                                    <a class="btn btn-warning btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#editUserModal"
                                                        onclick="editUser(<?= $user['id'] ?>, '<?= htmlspecialchars($user['name']) ?>', '<?= htmlspecialchars($user['username']) ?>', '<?= htmlspecialchars($user['password']) ?>', '<?= htmlspecialchars($user['level']) ?>')">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a class="btn btn-danger btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                                                        onclick="setDeleteUserId(<?= $user['id'] ?>)">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        tr>
                                        <td colspan="5" class="text-center">Tidak ada data</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix d-flex justify-content-center">
                            <ul class="pagination pagination-sm m-0">
                                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page - 1 ?>">&laquo;</a>
                                </li>
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page + 1 ?>">&raquo;</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.card -->
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