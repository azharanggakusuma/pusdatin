<?php
function getPreviousYearData($conn, $user_id, $desa_id, $table_name, $columns, $form_name, $tahun)
{
    // Menentukan tahun sebelumnya
    $previous_year = $tahun - 1;

    // Pastikan $columns adalah array
    if (!is_array($columns)) {
        $columns = [$columns];
    }

    // Membangun query untuk mengambil data berdasarkan tahun sebelumnya
    $columns_str = implode(", ", $columns);
    $query = "
        SELECT $columns_str, $table_name.tahun 
        FROM $table_name
        INNER JOIN user_progress 
        ON $table_name.user_id = user_progress.user_id 
        AND $table_name.desa_id = user_progress.desa_id 
        AND $table_name.tahun = user_progress.tahun
        WHERE user_progress.user_id = '$user_id' 
        AND user_progress.desa_id = '$desa_id'
        AND user_progress.form_name = '$form_name' 
        AND user_progress.tahun = '$previous_year'
        ORDER BY user_progress.tahun DESC 
        LIMIT 1";

    $result = mysqli_query($conn, $query);

    // Jika data ada untuk tahun sebelumnya, ambil data dan tahun
    $response = [];
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        foreach ($columns as $column) {
            $response[$column] = $data[$column] ?? 'Belum Ada Data';
        }
        $response['created_year'] = $data['tahun'];
    } else {
        // Jika tidak ada data untuk tahun sebelumnya
        foreach ($columns as $column) {
            $response[$column] = 'Belum Ada Data';
        }
        $response['created_year'] = '-';
    }

    return $response;
}

function displayPreviousYearData($previous_data, $field_name, $label)
{
    if ($previous_data['created_year'] === '-') {
        return "Data untuk tahun sebelumnya belum ada.";
    }

    return "Data pada tahun sebelumnya (" . htmlspecialchars($previous_data['created_year']) . "): " . htmlspecialchars($previous_data[$field_name]);
}