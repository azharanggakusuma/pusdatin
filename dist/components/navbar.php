<?php
$current_folder = basename(dirname($_SERVER['SCRIPT_NAME']));
$base_path = ($current_folder == 'forms' || $current_folder == 'tables') ? '../../' : './';
?>

<nav class="app-header navbar navbar-expand bg-body sticky-navbar">
    <div class="container-fluid">
        <!-- Begin::Start Navbar Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul>
        <!-- End::Start Navbar Links -->

        <!-- Begin::End Navbar Links -->
        <ul class="navbar-nav ms-auto">
            <!-- Begin::Fullscreen Toggle -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i>
                </a>
            </li>
            <!-- End::Fullscreen Toggle -->

            <!-- Begin::User Menu Dropdown -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="<?php echo $base_path; ?>img/people.png" class="user-image rounded-circle shadow" alt="User Image">
                    <span class="d-none d-md-inline"><?php echo $name; ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!-- Begin::User Image -->
                    <li class="user-header text-bg-primary">
                        <img src="<?php echo $base_path; ?>img/people.png" class="rounded-circle shadow" alt="User Image">
                        <p>
                            <?php echo $name; ?> <!-- Menampilkan nama pengguna -->
                            <small><?php echo $role_description; ?></small> <!-- Menampilkan keterangan berdasarkan level -->
                        </p>
                    </li>
                    <!-- End::User Image -->

                    <!-- Begin::Menu Footer -->
                    <li class="user-footer d-grid gap-2">
                        <a href="<?php echo $base_path; ?>auth/logout.php" class="btn btn-danger btn-flat">Log out</a>
                    </li>
                    <!-- End::Menu Footer -->
                </ul>
            </li>
            <!-- End::User Menu Dropdown -->
        </ul>
        <!-- End::End Navbar Links -->
    </div>
</nav>

<style>
    .sticky-navbar {
        position: sticky; /* Atau gunakan fixed jika ingin navbar tetap di atas */
        top: 0; /* Menjaga navbar tetap di atas */
        z-index: 1000; /* Pastikan navbar di atas elemen lain */
        background-color: rgba(255, 255, 255, 0.8); /* Latar belakang transparan */
        backdrop-filter: blur(10px); /* Efek blur di belakang navbar */
        transition: background-color 0.3s; /* Transisi halus saat menggulir */
    }
    .sticky-navbar.scrolled {
        background-color: rgba(255, 255, 255, 1); /* Latar belakang solid saat menggulir */
    }
</style>
<script>
    // Menambahkan kelas 'scrolled' saat menggulir
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.sticky-navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>