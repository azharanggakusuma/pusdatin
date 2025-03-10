<?php
include('../config/conn.php');
// Query untuk mengambil data tahun
$query = "SELECT year FROM tahun ORDER BY year ASC";
$result = mysqli_query($conn, $query);

// Ambil hasil query ke dalam array
$years = [];
while ($row = mysqli_fetch_assoc($result)) {
    $years[] = $row['year'];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>PUSDATIN | Halaman Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/adminlte.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="../img/kominfo.png" type="image/x-icon">
    <style>
        .login-box {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .card-header img {
            width: 50px;
            margin-bottom: 10px;
        }

        .card-header p {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: -20px;
        }

        .input-group {
            display: flex;
            width: 100%;
        }

        .input-group .input-group-text {
            display: flex;
            align-items: center;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .position-relative {
            position: relative;
            flex-grow: 1;
        }

        .form-control {
            padding-right: 40px;
            /* Memberikan ruang untuk ikon */
            border-top-left-radius: 0;
            /* Remove left border-radius */
            border-bottom-left-radius: 0;
            /* Remove left border-radius */
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

        .d-grid {
            display: grid;
        }

        .btn-primary {
            width: 100%;
        }

        /* Styling untuk reCAPTCHA */
        .g-recaptcha {
            transform: scale(0.85);
            transform-origin: 0 0;
        }
    </style>
</head>

<body class="login-page bg-body-secondary">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="../img/kominfo.png" alt="Pusdatin" width="50px">
                <p class="login-box-msg mt-2">Pusdatin Kab. Cirebon</p>
            </div>

            <div class="card-body login-card-body">
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 'true') {
                    echo '<script>
            Swal.fire({
                title: "Login Gagal!",
                text: "Username atau password salah.",
                icon: "error",
                timer: 3000,
                timerProgressBar: true, // Menampilkan progres timer
                showConfirmButton: false // Tidak ada tombol konfirmasi
            }).then(() => {
                window.location.href = "login.php";
            });
          </script>';
                }
                if (isset($_GET['success']) && $_GET['success'] == 'true') {
                    echo '<script>
            Swal.fire({
                title: "Login Berhasil!",
                text: "Selamat datang di sistem.",
                icon: "success",
                timer: 3000,
                timerProgressBar: true, // Menampilkan progres timer
                showConfirmButton: false // Tidak ada tombol konfirmasi
            }).then(() => {
                setTimeout(() => {
                    window.location.href = "../index.php";
                }, 500);
            });
          </script>';
                }
                if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
                    echo '<script>
            Swal.fire({
                title: "Berhasil Logout!",
                text: "Anda telah logout dari sistem.",
                icon: "success",
                timer: 3000,
                timerProgressBar: true, // Menampilkan progres timer
                showConfirmButton: false // Tidak ada tombol konfirmasi
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
                            <i class="bi bi-eye-fill position-absolute" id="togglePasswordIcon" style="top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer;"></i>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <span class="bi bi-calendar-fill"></span>
                        </div>
                        <select class="form-control form-select" name="tahun" id="tahun" required>
                            <option value="" disabled selected>Pilih Tahun</option>
                            <?php
                            // Gunakan foreach untuk menampilkan tahun dalam select
                            foreach ($years as $year) {
                                echo '<option value="' . $year . '">' . $year . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="g-recaptcha" data-sitekey="6LdYSrQqAAAAAPgKD85lf9OAG6NgQX-ulVSf_-A8" id="recaptcha"></div>

                    <div class="row">
                        <div class="d-grid gap-2 mt-2 mb-3">
                            <input type="submit" class="btn btn-primary" value="Log in" id="submit-btn">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="../js/adminlte.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');
            const password = document.getElementById('password');
            const submitBtn = document.getElementById('submit-btn');

            togglePasswordIcon.addEventListener('click', function() {
                password.type = password.type === 'password' ? 'text' : 'password';
                this.className = password.type === 'password' ? 'bi bi-eye-fill position-absolute' : 'bi bi-eye-slash-fill position-absolute';
            });

            // Menambahkan event listener untuk reCAPTCHA
            const form = document.getElementById('login-form');
            form.addEventListener('submit', function(event) {
                const recaptchaResponse = grecaptcha.getResponse();
                if (!recaptchaResponse) {
                    event.preventDefault(); // Mencegah form untuk disubmit
                    Swal.fire({
                        title: "reCAPTCHA belum dicentang!",
                        text: "Harap centang kotak reCAPTCHA untuk melanjutkan.",
                        icon: "warning",
                        timer: 3000, // Menampilkan selama 3 detik
                        timerProgressBar: true, // Menampilkan progres timer
                        showConfirmButton: false // Tidak ada tombol konfirmasi
                    });
                }
            });
        });
    </script>
</body>

</html>