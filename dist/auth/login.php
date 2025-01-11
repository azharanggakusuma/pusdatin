<!DOCTYPE html>
<html lang="en">

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
</head>

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
                            <div class="position-relative flex-grow-1">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                <i class="bi bi-eye-fill position-absolute" id="togglePasswordIcon" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <span class="bi bi-calendar-fill"></span>
                            </div>
                            <select class="form-control" name="tahun" id="tahun" required>
                                <option value="" disabled selected>Pilih Tahun</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="d-grid gap-2 mt-3 mb-3">
                                <input type="submit" class="btn btn-primary" value="Log In" onclick="triggerCaptcha()">
                            </div>
                        </div>
                    </form>

                    <style>
                        .input-group {
                            display: flex;
                            width: 100%;
                        }

                        .input-group .input-group-text {
                            display: flex;
                            align-items: center;
                        }

                        .position-relative {
                            position: relative;
                            flex-grow: 1;
                        }

                        .form-control {
                            padding-right: 40px;
                            /* Memberikan ruang untuk ikon */
                        }

                        .position-absolute {
                            color: #6c757d;
                            /* Warna ikon */
                        }

                        select.form-control {
                            -webkit-appearance: none;
                            -moz-appearance: none;
                            appearance: none;
                            background-color: #ffffff;
                            border: 1px solid #ced4da;
                            padding: 0.375rem 0.75rem;
                            font-size: 1rem;
                            line-height: 1.5;
                            border-radius: 0.375rem;
                            color: #495057;
                        }

                        select.form-control:focus {
                            border-color: #80bdff;
                            outline: 0;
                            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
                        }
                    </style>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const togglePasswordIcon = document.getElementById('togglePasswordIcon');
                            const password = document.getElementById('password');

                            togglePasswordIcon.addEventListener('click', function() {
                                password.type = password.type === 'password' ? 'text' : 'password';
                                this.className = password.type === 'password' ? 'bi bi-eye-fill position-absolute' : 'bi bi-eye-slash-fill position-absolute';
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="../js/adminlte.js"></script>
</body>

</html>