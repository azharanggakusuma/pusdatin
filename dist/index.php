<?php
include_once "config/conn.php";
include "config/session.php";
?>

<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>PUSDATIN | Dashboard</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE v4 | Dashboard">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="./css/adminlte.css"><!--end::Required Plugin(AdminLTE)--><!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous"><!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">

    <link rel="shortcut icon" href="./img/kominfo.png" type="image/x-icon">

    <!-- Animate.css CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->

    <?php include "components/loading.php"; ?> 

    <div class="page animate__animated animate__fadeIn">
        <div class="app-wrapper"> <!--begin::Header-->
            <?php include('components/navbar.php'); ?> <!--end::Header--> <!--begin::Sidebar-->

            <?php include('components/sidebar.php'); ?>
            <!--end::Sidebar--> <!--begin::App Main-->

            <main class="app-main"> <!--begin::App Content Header-->
                <div class="app-content-header"> <!--begin::Container-->
                    <div class="container-fluid"> <!--begin::Row-->
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="mb-0">Dashboard</h3>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-end">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Dashboard
                                    </li>
                                </ol>
                            </div>
                        </div> <!--end::Row-->
                    </div> <!--end::Container-->
                </div> <!--end::App Content Header--> <!--begin::App Content-->
                <div class="app-content"> <!--begin::Container-->
                    <div class="container-fluid"> <!--begin::Row-->
                        <div class="row"> <!--begin::Col-->
                            <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                                <div class="small-box text-bg-primary">
                                    <div class="inner">
                                        <h3>422</h3>
                                        <p>Desa / Kelurahan</p>
                                    </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M12 3.172l9 9V20a1 1 0 01-1 1h-6a1 1 0 01-1-1v-4H11v4a1 1 0 01-1 1H4a1 1 0 01-1-1v-7.828l9-9zm-7 9.414V19h4v-5a1 1 0 011-1h4a1 1 0 011 1v5h4v-6.414L12 5.586l-7 7z" />
                                    </svg>
                                    <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                        More info</a>
                                </div> <!--end::Small Box Widget 1-->
                            </div> <!--end::Col-->
                            <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 2-->
                                <div class="small-box text-bg-success">
                                    <div class="inner">
                                        <h3>40<sup class="fs-5"></h3>
                                        <p>Kecamatan</p>
                                    </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M12 3.172l9 9V20a1 1 0 01-1 1h-6a1 1 0 01-1-1v-4H11v4a1 1 0 01-1 1H4a1 1 0 01-1-1v-7.828l9-9zm-7 9.414V19h4v-5a1 1 0 011-1h4a1 1 0 011 1v5h4v-6.414L12 5.586l-7 7z" />
                                    </svg>
                                    <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                        More info</a>
                                </div> <!--end::Small Box Widget 2-->
                            </div> <!--end::Col-->
                            <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 3-->
                                <div class="small-box text-bg-warning">
                                    <?php
                                    // Query untuk menghitung jumlah pengunjung
                                    $sql_user = "SELECT COUNT(*) AS total_user FROM users";
                                    $query_user = mysqli_query($conn, $sql_user);
                                    $data_user = mysqli_fetch_assoc($query_user);
                                    $total_user = $data_user['total_user'];
                                    ?>
                                    <div class="inner">
                                        <h3><?php echo $total_user; ?></h3>
                                        <p>Users</p>
                                    </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"></path>
                                    </svg> <a href="#" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                                        More info</a>
                                </div> <!--end::Small Box Widget 3-->
                            </div> <!--end::Col-->
                            <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 4-->
                                <div class="small-box text-bg-danger">
                                    <?php
                                    // Query untuk menghitung jumlah pengunjung
                                    $sql_pengunjung = "SELECT COUNT(*) AS total_pengunjung FROM pengunjung";
                                    $query_pengunjung = mysqli_query($conn, $sql_pengunjung);
                                    $data_pengunjung = mysqli_fetch_assoc($query_pengunjung);
                                    $total_pengunjung = $data_pengunjung['total_pengunjung'];
                                    ?>
                                    <div class="inner">
                                        <h3><?php echo $total_pengunjung ?></h3>
                                        <p>Pengunjung</p>
                                    </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"></path>
                                        <path clip-rule="evenodd" fill-rule="evenodd" d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"></path>
                                    </svg> <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                        More info</a>
                                </div> <!--end::Small Box Widget 4-->
                            </div> <!--end::Col-->
                        </div> <!--end::Row--> <!--begin::Row-->
                        <div class="row">
                            <!-- Start col -->
                            <div class="col-lg-7 connectedSortable">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h3 class="card-title">Pengunjung</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-default btn-sm" data-lte-toggle="card-collapse">
                                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="revenue-chart" style="height: 300px;"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.Start col -->

                            <!-- Start col -->
                            <div class="col-lg-5 connectedSortable">
                                <div class="card mb-4">
                                    <div class="card-header border-0">
                                        <h3 class="card-title">Coming Soon</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-default btn-sm" data-lte-toggle="card-collapse">
                                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="map-cirebon" style="height: 305px;"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.Start col -->
                        </div>
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

        <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
        <script src="./js/adminlte.js"></script> <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
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
        </script> <!--end::OverlayScrollbars Configure--> <!-- OPTIONAL SCRIPTS --> <!-- sortablejs -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ=" crossorigin="anonymous"></script> <!-- sortablejs -->
        <script>
            const connectedSortables =
                document.querySelectorAll(".connectedSortable");
            connectedSortables.forEach((connectedSortable) => {
                let sortable = new Sortable(connectedSortable, {
                    group: "shared",
                    handle: ".card-header",
                });
            });

            const cardHeaders = document.querySelectorAll(
                ".connectedSortable .card-header",
            );
            cardHeaders.forEach((cardHeader) => {
                cardHeader.style.cursor = "move";
            });
        </script> <!-- apexcharts -->

        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script> <!-- ChartJS -->

        <script>
            // Ambil data pengunjung dari server (PHP)
            fetch('./api/pengunjung.php') // Gantilah dengan path yang sesuai ke file PHP Anda
                .then(response => response.json())
                .then(data => {
                    // Filter data agar hanya dimulai dari bulan Oktober
                    const filteredData = data.filter(item => {
                        const date = new Date(item.tanggal);
                        return date.getMonth() >= 9;
                    });

                    const pengunjungData = filteredData.map(item => item.jumlah_pengunjung);
                    const bulanData = filteredData.map(item => item.tanggal);

                    const sales_chart_options = {
                        series: [{
                            name: "Pengunjung",
                            data: pengunjungData, // Data jumlah pengunjung bulanan
                        }],
                        chart: {
                            height: 300,
                            type: "line",
                            toolbar: {
                                show: false
                            },
                        },
                        colors: ["#0d6efd"],
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: "smooth"
                        },
                        xaxis: {
                            type: "datetime",
                            categories: bulanData, // Menggunakan data tanggal yang difilter
                        },
                        tooltip: {
                            x: {
                                format: "MMMM yyyy"
                            },
                        },
                    };

                    const sales_chart = new ApexCharts(
                        document.querySelector("#revenue-chart"),
                        sales_chart_options
                    );
                    sales_chart.render();
                })
                .catch(err => console.error("Gagal memuat data pengunjung:", err));
        </script>

        <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js" integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js" integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY=" crossorigin="anonymous"></script> <!-- jsvectormap -->


        <!--<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            // Inisialisasi peta
            const map = L.map('map-cirebon').setView([-6.732, 108.552], 10);

            // Tambahkan tile layer dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '© OpenStreetMap contributors',
            }).addTo(map);

            // Data GeoJSON untuk wilayah Kabupaten Cirebon
            fetch('./api/kab_cirebon.json')
                .then(response => response.json())
                .then(data => {
                    L.geoJSON(data, {
                        style: {
                            color: 'blue', // Warna garis wilayah
                            weight: 2, // Ketebalan garis
                            fillOpacity: 0.1 // Transparansi area
                        }
                    }).addTo(map);

                    // Sesuaikan tampilan peta ke batas wilayah
                    map.fitBounds(boundaryLayer.getBounds());
                })
                .catch(err => console.error("Gagal memuat data GeoJSON:", err));

            // Data titik kecamatan
            const kecamatanLocations = [{
                    name: "Arjawinangun",
                    coords: [-6.636017, 108.420189]
                },
                {
                    name: "Astanajapura",
                    coords: [-6.661807, 108.593200]
                },
                {
                    name: "Babakan",
                    coords: [-6.622652, 108.696152]
                },
                {
                    name: "Beber",
                    coords: [-6.700845, 108.462067]
                },
                {
                    name: "Ciledug",
                    coords: [-6.569217, 108.762627]
                },
                {
                    name: "Ciwaringin",
                    coords: [-6.685364, 108.396919]
                },
                {
                    name: "Depok",
                    coords: [-6.668016, 108.645981]
                },
                {
                    name: "Dukupuntang",
                    coords: [-6.707248, 108.510056]
                },
                {
                    name: "Gebang",
                    coords: [-6.619915, 108.653679]
                },
                {
                    name: "Gegesik",
                    coords: [-6.632848, 108.471298]
                },
                {
                    name: "Greged",
                    coords: [-6.693779, 108.415649]
                },
                {
                    name: "Gunungjati",
                    coords: [-6.662546, 108.545410]
                },
                {
                    name: "Jamblang",
                    coords: [-6.658238, 108.475258]
                },
                {
                    name: "Kaliwedi",
                    coords: [-6.635051, 108.466965]
                },
                {
                    name: "Kapetakan",
                    coords: [-6.625542, 108.580742]
                },
                {
                    name: "Karangsembung",
                    coords: [-6.596457, 108.595650]
                },
                {
                    name: "Karangwareng",
                    coords: [-6.611390, 108.524666]
                },
                {
                    name: "Kedawung",
                    coords: [-6.709171, 108.508644]
                },
                {
                    name: "Klangenan",
                    coords: [-6.649237, 108.499725]
                },
                {
                    name: "Lemahabang",
                    coords: [-6.576569, 108.701500]
                },
                {
                    name: "Losari",
                    coords: [-6.544514, 108.786911]
                },
                {
                    name: "Mundu",
                    coords: [-6.629859, 108.612610]
                },
                {
                    name: "Pabedilan",
                    coords: [-6.598938, 108.739319]
                },
                {
                    name: "Pabuaran",
                    coords: [-6.665870, 108.482788]
                },
                {
                    name: "Palimanan",
                    coords: [-6.712670, 108.460556]
                },
                {
                    name: "Panguragan",
                    coords: [-6.641382, 108.477531]
                },
                {
                    name: "Pasaleman",
                    coords: [-6.525844, 108.719261]
                },
                {
                    name: "Plered",
                    coords: [-6.676874, 108.536682]
                },
                {
                    name: "Plumbon",
                    coords: [-6.684128, 108.512932]
                },
                {
                    name: "Sedong",
                    coords: [-6.645678, 108.433762]
                },
                {
                    name: "Sumber",
                    coords: [-6.717772, 108.545319]
                },
                {
                    name: "Suranenggala",
                    coords: [-6.605973, 108.603943]
                },
                {
                    name: "Susukan",
                    coords: [-6.649884, 108.695732]
                },
                {
                    name: "Talun",
                    coords: [-6.702738, 108.506363]
                },
                {
                    name: "Tengah Tani",
                    coords: [-6.696682, 108.526703]
                },
                {
                    name: "Weru",
                    coords: [-6.635056, 108.570213]
                },
                {
                    name: "Waled",
                    coords: [-6.589117, 108.683853]
                }
            ];

            // Tambahkan marker untuk setiap kecamatan
            kecamatanLocations.forEach(location => {
                L.marker(location.coords)
                    .addTo(map)
                    .bindPopup(`<b>${location.name}</b>`);
            });
        </script>-->

    </div>
</body><!--end::Body-->

</html>