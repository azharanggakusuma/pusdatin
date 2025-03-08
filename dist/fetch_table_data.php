<?php
include 'config/conn.php';

if (isset($_POST['table_name'])) {
    $table = $_POST['table_name'];
    $query = "SELECT * FROM `$table` LIMIT 10"; // Maksimal 10 data
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead class='table-dark'><tr>";
        while ($field = $result->fetch_field()) {
            echo "<th>{$field->name}</th>";
        }
        echo "</tr></thead><tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>{$value}</td>";
            }
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-warning'>Tabel ini kosong.</div>";
    }
}
?>
