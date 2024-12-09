<?php
// Menghubungkan ke database
include '../../config/conn.php'; // pastikan koneksi database di file ini

// Ambil data pengguna yang sedang login (Admin)
session_start();
$name = $_SESSION['name'] ?? '';  // Ambil nama pengguna
$level = $_SESSION['level'] ?? ''; // Ambil level pengguna

if ($level !== 'admin') {
    echo "Access denied. Only admin can access this page.";
    exit;
}

$query_user = "SELECT id FROM users WHERE name = '$name'";  // Fetch user by name
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
$user_id = $user['id'] ?? 0;

// Ambil data semua user untuk memilih user berdasarkan nama
$query_all_users = "SELECT id, name FROM users";  // Change to 'name' field
$result_all_users = mysqli_query($conn, $query_all_users);

// Mengubah status kunci form jika form di-submit
if (isset($_POST['form_name'])) {
    $form_name = $_POST['form_name'];
    $selected_user_id = $_POST['user_id'];
    $is_locked = isset($_POST['is_locked']) ? $_POST['is_locked'] : '';  // Ensure value is set

    // Make sure is_locked has a valid value
    if ($is_locked === '') {
        echo "Please select a lock status.";
        exit;
    }

    // Convert 'true' or 'false' string to integer (1 for true, 0 for false)
    $is_locked = ($is_locked === 'true') ? 1 : 0;

    // Cek apakah status form sudah ada untuk user tertentu
    $query_check = "SELECT * FROM user_progress WHERE user_id = '$selected_user_id' AND form_name = '$form_name'";
    $result_check = mysqli_query($conn, $query_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Update status form yang ada
        $query_update = "UPDATE user_progress SET is_locked = '$is_locked', updated_at = NOW() WHERE user_id = '$selected_user_id' AND form_name = '$form_name'";
        mysqli_query($conn, $query_update);
    } else {
        // Jika data belum ada, tampilkan error dan tidak insert data baru
        echo "Error: Form status not found for this user.";
        exit;
    }
}

// Mengambil status form untuk setiap user dan form
$forms = [
    'Luas Wilayah Desa',
    'Batas Wilayah Desa',
    'Jarak Kantor Desa',
    // Tambahkan form lainnya sesuai kebutuhan
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Form Lock Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Manage Form Lock Status</h2>

    <form action="manage_forms.php" method="post">
        <div class="mb-3">
            <label for="user_id" class="form-label">Select User</label>
            <select name="user_id" id="user_id" class="form-select">
                <?php while ($user_data = mysqli_fetch_assoc($result_all_users)) { ?>
                    <option value="<?= $user_data['id']; ?>"><?= $user_data['name']; ?></option>  <!-- Use name here -->
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="form_name" class="form-label">Select Form</label>
            <select name="form_name" id="form_name" class="form-select">
                <?php foreach ($forms as $form) { ?>
                    <option value="<?= $form; ?>"><?= $form; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="is_locked" class="form-label">Lock Status</label>
            <select name="is_locked" id="is_locked" class="form-select" required>
                <option value="" disabled selected>Select Lock Status</option>
                <option value="true">Locked</option>
                <option value="false">Unlocked</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>

    <hr>

    <h3 class="mt-5">Current Lock Status for Forms</h3>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Form Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Tampilkan status form untuk setiap user
            foreach ($forms as $form) {
                $query_form_status = "SELECT users.name, user_progress.is_locked 
                                      FROM user_progress 
                                      JOIN users ON user_progress.user_id = users.id
                                      WHERE user_progress.form_name = '$form'";  // Fetch by 'name'

                $result_form_status = mysqli_query($conn, $query_form_status);
                while ($status = mysqli_fetch_assoc($result_form_status)) {
                    echo "<tr>";
                    echo "<td>{$status['name']}</td>";  // Display name instead of username
                    echo "<td>$form</td>";
                    echo "<td>" . ($status['is_locked'] ? 'Locked' : 'Unlocked') . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
