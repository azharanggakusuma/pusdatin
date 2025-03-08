<?php
include 'config/conn.php'; // Koneksi database

// Ambil daftar tabel
$result = $conn->query("SHOW TABLES");
$tables = [];
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Isi Tabel</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
        }
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Hapus Isi Tabel</h2>

    <div class="row">
        <!-- Pilihan Tabel -->
        <div class="col-md-3">
            <label for="table_name" class="form-label">Pilih Tabel:</label>
            <select class="form-select" id="table_name">
                <option value="">-- Pilih Tabel --</option>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo $table; ?>"><?php echo $table; ?></option>
                <?php endforeach; ?>
            </select>
            <button id="deleteTable" class="btn btn-danger w-100 mt-3">Hapus Isi Tabel</button>
        </div>

        <!-- Data Tabel -->
        <div class="col-md-9">
            <h4>Isi Tabel:</h4>
            <div id="table_data" class="table-container text-center">Pilih tabel untuk melihat isinya...</div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Load data saat tabel dipilih
        $('#table_name').change(function() {
            var table = $(this).val();
            if (table) {
                $('#table_data').html('<div class="text-center"><div class="spinner-border text-primary" role="status"></div><p>Memuat data...</p></div>');
                $.post('fetch_table_data.php', {table_name: table}, function(response) {
                    $('#table_data').html(response);
                });
            } else {
                $('#table_data').html('<p class="text-muted">Pilih tabel untuk melihat isinya...</p>');
            }
        });

        // Hapus isi tabel dengan SweetAlert2
        $('#deleteTable').click(function() {
            var table = $('#table_name').val();

            if (table) {
                Swal.fire({
                    title: "Konfirmasi Penghapusan",
                    text: "Apakah Anda yakin ingin menghapus semua isi tabel '" + table + "'?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Menghapus...",
                            text: "Mohon tunggu sebentar.",
                            icon: "info",
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.post('truncate_table.php', {table_name: table}, function(response) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: response,
                                icon: "success",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Oke"
                            });

                            $('#table_data').html('<p class="text-muted">Isi tabel telah dihapus.</p>');
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: "Pilih Tabel!",
                    text: "Silakan pilih tabel yang ingin dihapus.",
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Oke"
                });
            }
        });
    });
</script>

</body>
</html>
