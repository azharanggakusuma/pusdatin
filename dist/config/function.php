<?php
function getPreviousYearData($conn, $user_id, $desa_id, $table_name, $columns, $form_name)
{
    $current_year = date('Y');
    $previous_year = $current_year - 1;

    // Pastikan $columns adalah array, jika tidak konversi menjadi array
    if (!is_array($columns)) {
        $columns = [$columns]; // Ubah menjadi array jika hanya satu kolom
    }

    // Membangun query untuk mengambil data kolom yang diberikan
    $columns_str = implode(", ", $columns); // Menggabungkan kolom yang diberikan menjadi string query
    $query = "
        SELECT $columns_str, user_progress.created_at 
        FROM $table_name
        INNER JOIN user_progress 
        ON $table_name.user_id = user_progress.user_id 
        AND $table_name.desa_id = user_progress.desa_id 
        WHERE $table_name.user_id = '$user_id' 
        AND $table_name.desa_id = '$desa_id'
        AND user_progress.form_name = '$form_name'
        AND YEAR(user_progress.created_at) = '$previous_year'
        ORDER BY user_progress.created_at DESC 
        LIMIT 1";

    // Debugging: Tampilkan query yang dijalankan
    echo "Query: " . $query . "<br>";

    $result = mysqli_query($conn, $query);
    
    // Debugging: Periksa hasil query
    if (!$result) {
        die('Query Error: ' . mysqli_error($conn));
    }

    // Jika data ada, ambil data dan waktu pembuatan
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $response = [];
        foreach ($columns as $column) {
            $response[$column] = $data[$column] ?? 'Belum Ada Data';
        }
        $response['created_year'] = date('Y', strtotime($data['created_at']));
        return $response;
    } else {
        // Jika tidak ada data, kembalikan default
        $response = [];
        foreach ($columns as $column) {
            $response[$column] = 'Belum Ada Data';
        }
        $response['created_year'] = '-';
        return $response;
    }
}

?>
