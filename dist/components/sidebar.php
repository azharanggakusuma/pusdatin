<?php
$current_folder = basename(dirname($_SERVER['SCRIPT_NAME']));
$base_path = ($current_folder == 'forms' || $current_folder == 'tables') ? '../../' : './';

// Query untuk mengambil menu dinamis
$query = "SELECT * FROM menu WHERE status = 1"; // Hanya menu aktif
$menu_result = $conn->query($query);
?>

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="<?php echo $base_path; ?>index.php" class="brand-link">
            <img src="<?php echo $base_path; ?>img/kominfo.png" alt="Pusdatin" class="brand-image">
            <span class="brand-text fw-bold">P U S D A T I N</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="<?php echo $base_path; ?>index.php" class="nav-link active">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

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
                                <a href="<?php echo $base_path . $menu['url']; ?>" class="nav-link">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p><?php echo $menu['name']; ?></p>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </li>

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
                                <a href="<?php echo $base_path; ?>pages/tables/user.php" class="nav-link">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Data User</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $base_path; ?>pages/tables/rekap.php" class="nav-link">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Rekap Data</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $base_path; ?>pages/tables/manage_menu.php" class="nav-link">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Pengelolaan Menu</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</aside>