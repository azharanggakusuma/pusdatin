<?php
include_once "../../config/conn.php";
include "../../config/session.php";
?>

<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>PUSDATIN | Formulir</title><!--begin::Primary Meta Tags-->
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

  <!-- Animate.css CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <link rel="shortcut icon" href="../../img/kominfo.png" type="image/x-icon">
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->

  <div class="app-wrapper"> <!--begin::Header-->

    <?php include('../../components/navbar.php'); ?>

    <?php include('../../components/sidebar.php'); ?> <!--end::Sidebar--> <!--begin::App Main-->

    <main class="app-main"> <!--begin::App Content Header-->
      <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Bencana Alam dan Mitigasi Bencana Alam</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Formulir</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Bencana Alam dan Mitigasi Bencana Alam
                </li>
              </ol>
            </div>
          </div> <!--end::Row-->
        </div> <!--end::Container-->
      </div> <!--end::App Content Header--> <!--begin::App Content-->
      <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->

          <!-- Template Form -->
          <div class="card card-primary card-outline mb-4">
            <div class="card-header">
              <h3 class="card-title">Kejadian/bencana alam yang terjadi</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalBencanaAlam">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapseForm">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="collapse show" id="collapseForm">
              <div class="card-body">
                <form action="/submit-your-action" method="post">
                  <div class="form-group">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Kejadian/bencana alam</th>
                          <th>Ada</th>
                          <th>Tidak ada</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Tanah longsor</td>
                          <td><input type="checkbox" name="tanah_longsor" value="Ada" onchange="handleChange(this);"></td>
                          <td><input type="checkbox" name="tanah_longsor" value="Tidak Ada" onchange="handleChange(this);"></td>
                        </tr>
                        <tr>
                          <td>Banjir</td>
                          <td><input type="checkbox" name="banjir" value="Ada" onchange="handleChange(this);"></td>
                          <td><input type="checkbox" name="banjir" value="Tidak Ada" onchange="handleChange(this);"></td>
                        </tr>
                        <tr>
                          <td>Banjir bandang</td>
                          <td><input type="checkbox" name="banjir_bandang" value="Ada" onchange="handleChange(this);"></td>
                          <td><input type="checkbox" name="banjir_bandang" value="Tidak Ada" onchange="handleChange(this);"></td>
                        </tr>
                        <tr>
                          <td>Gempa bumi</td>
                          <td><input type="checkbox" name="gempa_bumi" value="Ada" onchange="handleChange(this);"></td>
                          <td><input type="checkbox" name="gempa_bumi" value="Tidak Ada" onchange="handleChange(this);"></td>
                        </tr>
                        <tr>
                          <td>Tsunami</td>
                          <td><input type="checkbox" name="tsunami" value="Ada" onchange="handleChange(this);"></td>
                          <td><input type="checkbox" name="tsunami" value="Tidak Ada" onchange="handleChange(this);"></td>
                        </tr>
                        <tr>
                          <td>Gelombang pasang laut</td>
                          <td><input type="checkbox" name="gelombang_pasang" value="Ada" onchange="handleChange(this);"></td>
                          <td><input type="checkbox" name="gelombang_pasang" value="Tidak Ada" onchange="handleChange(this);"></td>
                        </tr>
                        <tr>
                          <td>Angin puyuh/puting beliung/topan</td>
                          <td><input type="checkbox" name="angin_puyuh" value="Ada" onchange="handleChange(this);"></td>
                          <td><input type="checkbox" name="angin_puyuh" value="Tidak Ada" onchange="handleChange(this);"></td>
                        </tr>
                        <tr>
                          <td>Gunung meletus</td>
                          <td><input type="checkbox" name="gunung_meletus" value="Ada" onchange="handleChange(this);"></td>
                          <td><input type="checkbox" name="gunung_meletus" value="Tidak Ada" onchange="handleChange(this);"></td>
                        </tr>
                        <tr>
                          <td>Kebakaran hutan dan lahan</td>
                          <td><input type="checkbox" name="kebakaran_hutan" value="Ada" onchange="handleChange(this);"></td>
                          <td><input type="checkbox" name="kebakaran_hutan" value="Tidak Ada" onchange="handleChange(this);"></td>
                        </tr>
                        <tr>
                          <td>Kekeringan (lahan)</td>
                          <td><input type="checkbox" name="kekeringan" value="Ada" onchange="handleChange(this);"></td>
                          <td><input type="checkbox" name="kekeringan" value="Tidak Ada" onchange="handleChange(this);"></td>
                        </tr>
                        <tr>
                          <td>Abrasi</td>
                          <td><input type="checkbox" name="abrasi" value="Ada" onchange="handleChange(this);"></td>
                          <td><input type="checkbox" name="abrasi" value="Tidak Ada" onchange="handleChange(this);"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="mb-2">
                    <button type="submit" class="btn btn-primary mt-3">
                      <i class="fas fa-save"></i> &nbsp;Simpan
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <div class="modal fade" id="modalBencanaAlam" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih 'Ada' jika kejadian/bencana alam tersebut telah terjadi di wilayah Anda.</li>
                      <li>Pilih 'Tidak ada' jika kejadian/bencana alam tersebut belum terjadi di wilayah Anda.</li>
                      <li>Tidak boleh menandai kedua kotak pada satu kejadian/bencana alam. Jika salah satu kotak telah dipilih, kotak lainnya tidak dapat dipilih untuk kejadian yang sama.</li>
                      <li>Pastikan untuk memberikan informasi yang akurat dan terkini.</li>
                      <li>Periksa kembali sebelum mengirimkan form untuk memastikan tidak ada kesalahan input.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>

            <script>
              function handleChange(checkbox) {
                const allCheckboxes = document.querySelectorAll('input[name="' + checkbox.name + '"]');
                allCheckboxes.forEach((cb) => {
                  if (cb !== checkbox) cb.checked = false;
                });
              }
            </script>
          </div>

          <div class="card card-primary card-outline mb-4">
            <div class="card-header mb-3">
              <h3 class="card-title">Fasilitas/Upaya Antisipasi/Mitigasi Bencana Alam yang Ada di Desa/Kelurahan</h3>
              <button type="button" class="btn btn-tool" data-bs-toggle="modal" data-bs-target="#modalFasilitasMitigasi">
                <i class="fas fa-info-circle"></i>
              </button>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-toggle="collapse" data-target="#collapseForm">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="collapse show" id="collapseForm">
              <div class="card-body">
                <form action="" method="post">
                  <!-- Form field 1 -->
                  <div class="mb-3">
                    <label for="peringatan_dini" class="form-label">Sistem Peringatan Dini Bencana Alam</label>
                    <select name="peringatan_dini" id="peringatan_dini" class="form-control">
                      <option value="" selected disabled>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak ada</option>
                    </select>
                  </div>

                  <!-- Form field 2 -->
                  <div class="mb-3">
                    <label for="peringatan_tsunami" class="form-label">Sistem Peringatan Dini Khusus Tsunami</label>
                    <select name="peringatan_tsunami" id="peringatan_tsunami" class="form-control">
                      <option value="" selected disabled>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak ada</option>
                      <option value="3">Bukan Wilayah Potensi Tsunami</option>
                    </select>
                  </div>

                  <!-- Form field 3 -->
                  <div class="mb-3">
                    <label for="perlengkapan_keselamatan" class="form-label">Perlengkapan Keselamatan (Perahu Karet, Tenda, Masker, dll)</label>
                    <select name="perlengkapan_keselamatan" id="perlengkapan_keselamatan" class="form-control">
                      <option value="" selected disabled>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak ada</option>
                    </select>
                  </div>

                  <!-- Form field 4 -->
                  <div class="mb-3">
                    <label for="rambu_evakuasi" class="form-label">Rambu-Rambu dan Jalur Evakuasi Bencana</label>
                    <select name="rambu_evakuasi" id="rambu_evakuasi" class="form-control">
                      <option value="" selected disabled>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak ada">Tidak ada</option>
                    </select>
                  </div>

                  <!-- Form field 5 -->
                  <div class="mb-3">
                    <label for="infrastruktur" class="form-label">Pembuatan, Perawatan, atau Normalisasi (Sungai, Kanal, Tanggul, Parit, Drainase, Waduk, Pantai, dll.)</label>
                    <select name="infrastruktur" id="infrastruktur" class="form-control">
                      <option value=""></option>
                      <option value="" selected disabled>--- Pilih ---</option>
                      <option value="Ada">Ada</option>
                      <option value="Tidak Ada">Tidak ada</option>
                    </select>
                  </div>

                  <!-- Submit button -->
                  <div class="mb-2">
                    <button type="submit" class="btn btn-primary mt-3">
                      <i class="fas fa-save"></i> &nbsp;Simpan
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <!-- Modal Info -->
            <div class="modal fade" id="modalFasilitasMitigasi" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pengisian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul>
                      <li>Pilih 'Ada' jika fasilitas/mitigasi tersebut tersedia di wilayah Anda.</li>
                      <li>Pilih 'Tidak ada' jika fasilitas/mitigasi tersebut tidak tersedia di wilayah Anda.</li>
                      <li>Untuk 'Sistem Peringatan Dini Khusus Tsunami', pilih 'Bukan Wilayah Potensi Tsunami' jika wilayah Anda tidak berpotensi tsunami.</li>
                      <li>Pastikan tidak memilih lebih dari satu opsi per fasilitas.</li>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
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