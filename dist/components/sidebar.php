<?php
$current_folder = basename(dirname($_SERVER['SCRIPT_NAME']));
$base_path = ($current_folder == 'forms' || $current_folder == 'tables') ? '../../' : './';

// Query untuk mengambil menu dinamis
$query = "SELECT * FROM menu WHERE status = 1";
$menu_result = $conn->query($query);

// Dapatkan nama file saat ini
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="<?php echo $base_path; ?>index.php" class="brand-link">
            <img src="<?php echo $base_path; ?>img/kominfo.png" alt="Pusdatin" class="brand-image">
            <span class="brand-text fw-bold">P U S D A T I N</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2 mb-5">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <?php if ($level == 'user'): ?>
                    <li class="nav-header mb-2"><b><i>Periode Tahun (<?php echo htmlspecialchars($tahun); ?>)</i></b></li>
                <?php endif; ?>
                <li class="nav-item menu-open">
                    <a href="<?php echo $base_path; ?>index.php" class="nav-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <?php if ($level == 'user') { ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-pencil-square"></i>
                            <p>
                                Formulir
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php while ($menu = $menu_result->fetch_assoc()) : ?>
                                <li class="nav-item">
                                    <a href="<?php echo $base_path . $menu['url']; ?>" class="nav-link <?php echo $current_page == basename($menu['url']) ? 'active' : ''; ?>">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p><?php echo $menu['name']; ?></p>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ($level == 'admin') { ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-table"></i>
                            <p>
                                Master Data
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo $base_path; ?>pages/tables/manage_tahun.php" class="nav-link <?php echo $current_page == 'manage_tahun.php' ? 'active' : ''; ?>">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Data Tahun</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $base_path; ?>pages/tables/user.php" class="nav-link <?php echo $current_page == 'user.php' ? 'active' : ''; ?>">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Data Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $base_path; ?>pages/tables/rekap.php" class="nav-link <?php echo $current_page == 'rekap.php' ? 'active' : ''; ?>">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Data Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $base_path; ?>pages/tables/manage_menu.php" class="nav-link <?php echo $current_page == 'manage_menu.php' ? 'active' : ''; ?>">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Management Menu</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $base_path; ?>pages/tables/manage_form.php" class="nav-link <?php echo $current_page == 'manage_form.php' ? 'active' : ''; ?>">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Management Form</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
    <!-- Tombol Logout di bagian bawah -->
    <div class="sidebar-footer">
        <a href="<?php echo $base_path; ?>auth/logout.php" class="nav-link logout-button">
            <i class="nav-icon bi bi-box-arrow-right"></i>
            <span>Log out</span>
        </a>
    </div>
</aside>

<style>
    .sidebar-footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        padding: 10px 0; /* Padding vertikal */
        text-align: center; /* Rata tengah */
        background-color: #343a40; /* Sesuaikan dengan warna sidebar */
    }
    .logout-button {
        display: inline-flex; /* Menggunakan inline-flex untuk menjaga keselarasan */
        align-items: center; /* Rata tengah secara vertikal */
        color: #ffffff; /* Warna teks putih */
        font-weight: 500; /* Teks normal */
        text-decoration: none; /* Menghilangkan garis bawah */
        padding: 10px 20px; /* Padding horizontal */
        border-radius: 5px; /* Sudut membulat */
        transition: background-color 0.3s, transform 0.3s; /* Efek transisi */
    }
    .logout-button:hover {
        background-color: rgba(255, 255, 255, 0.1); /* Efek hover dengan latar belakang transparan */
        transform: scale(1.05); /* Efek zoom saat hover */
        color: #ffffff;
    }
    .logout-button i {
        margin-right: 8px; /* Jarak antara ikon dan teks */
    }
</style>