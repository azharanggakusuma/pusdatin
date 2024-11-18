<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>PUSDATIN | Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/adminlte.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="shortcut icon" href="../img/kominfo.png" type="image/x-icon">
</head> <!--end::Head-->

<body class="login-page bg-body-secondary">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1 class="mb-0">
                    <img src="../img/kominfo.png" alt="Pusdatin" width="50px">
                </h1>
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Pusdatin Kab. Cirebon</p>
                    <?php
                    // Tampilkan pesan error atau sukses jika ada
                    if (isset($_GET['error']) && $_GET['error'] == 'true') {
                        echo '<script>
                                swal({
                                    title: "Login Gagal!",
                                    text: "Username atau password salah.",
                                    icon: "error",
                                    timer: 3000,
                                    buttons: false
                                }).then(() => {
                                    window.location.href = "login.php";
                                });
                              </script>';
                    }
                    if (isset($_GET['success']) && $_GET['success'] == 'true') {
                        echo '<script>
                                swal({
                                    title: "Login Berhasil!",
                                    text: "Selamat datang di sistem.",
                                    icon: "success",
                                    timer: 3000,
                                    buttons: false
                                }).then(() => {
                                    setTimeout(() => {
                                        window.location.href = "../index.php";
                                    }, 500);
                                });
                              </script>';
                    }
                    if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
                        echo '<script>
                                swal({
                                    title: "Berhasil Logout!",
                                    text: "Anda telah logout dari sistem.",
                                    icon: "success",
                                    timer: 3000,
                                    buttons: false,
                                    className: "swal-modal-fadeout"
                                }).then(function() {
                                    window.location.href = "login.php";
                                });
                            </script>';
                    }
                    ?>
                    <form action="proses_login.php" method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                            <div class="input-group-text">
                                <span class="bi bi-person-fill"></span>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                            <div class="input-group-text">
                                <span class="bi bi-lock-fill"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-grid gap-2 mt-3 mb-3">
                                <input type="submit" class="btn btn-primary" value="Log In">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--begin::Scripts-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="../js/adminlte.js"></script>
    <script>
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
    </script>
    <!--end::Scripts-->
</body><!--end::Body-->

</html>
