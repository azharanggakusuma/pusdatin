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

    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LfUfaUqAAAAAA_6RPB8APiOKw_ovLr3yR8QeyTT"></script>
    <script>
        function onSubmit(token) {
            document.getElementById("login-form").submit(); // Submit form after CAPTCHA is verified
        }

        function triggerCaptcha() {
            grecaptcha.enterprise.ready(function() {
                grecaptcha.enterprise.execute('6LfUfaUqAAAAAA_6RPB8APiOKw_ovLr3yR8QeyTT', {
                    action: 'login'
                }).then(function(token) {
                    document.getElementById('recaptcha_token').value = token;
                    onSubmit(token);
                });
            });
        }
    </script>
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
                    <form action="proses_login.php" method="post" id="login-form">
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <span class="bi bi-person-fill"></span>
                            </div>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <span class="bi bi-lock-fill"></span>
                            </div>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                        </div>
                        <input type="hidden" id="recaptcha_token" name="recaptcha_token">
                        <div class="row">
                            <div class="d-grid gap-2 mt-3 mb-3">
                                <input type="submit" class="btn btn-primary" value="Log In" onclick="triggerCaptcha()">
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