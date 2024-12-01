<?php
$current_folder = basename(dirname($_SERVER['SCRIPT_NAME']));
$base_path = ($current_folder == 'forms' || $current_folder == 'tables') ? '../../' : './';
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
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/desa.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Desa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/keadaan_geografi.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Keadaan Geografi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/wilayah_administratif.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Wilayah Administratif</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/sumber_daya_manusia.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Sumber Daya Manusia</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/kelembagaan_dan_keuangan_desa.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Kelembagaan Dan Keuangan Desa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/pendudukan.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Penduduk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/pendidikan.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Pendidikan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/kesehatan.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Kesehatan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/fasilitas_umum.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Fasilitas Umum</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/sosial.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Sosial</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/pariwisata.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Pariwisata</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/transportasi.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Transportasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/komunikasi.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Komunikasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/lembaga_keuangan.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Lembaga Keuangan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/sarana_perdagangan.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Sarana Perdagangan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/infrastruktur.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Infrastruktur</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $base_path; ?>pages/forms/lingkungan.php" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Lingkungan</p>
                            </a>
                        </li>
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
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</aside>