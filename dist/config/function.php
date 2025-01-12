<?php
function getPreviousYearData($conn, $user_id, $desa_id, $table_name, $columns, $form_name, $tahun)
{
    // Menentukan tahun yang sesuai untuk pencarian data
    $current_year = $tahun;
    $previous_year = $current_year - 1;

    // Pastikan $columns adalah array, jika tidak konversi menjadi array
    if (!is_array($columns)) {
        $columns = [$columns]; // Ubah menjadi array jika hanya satu kolom
    }

    // Membangun query untuk mengambil data berdasarkan tahun yang ada di kolom 'tahun'
    $columns_str = implode(", ", $columns); // Menggabungkan kolom yang diberikan menjadi string query
    $query = "
        SELECT $columns_str, user_progress.tahun 
        FROM $table_name
        INNER JOIN user_progress 
        ON $table_name.user_id = user_progress.user_id 
        AND $table_name.desa_id = user_progress.desa_id 
        WHERE user_progress.user_id = '$user_id' 
        AND user_progress.desa_id = '$desa_id'
        AND user_progress.form_name = '$form_name' 
        AND user_progress.tahun = '$previous_year'
        ORDER BY user_progress.tahun DESC 
        LIMIT 1";

    $result = mysqli_query($conn, $query);

    // Jika data ada untuk tahun sebelumnya, ambil data dan tahun
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $response = [];
        foreach ($columns as $column) {
            $response[$column] = $data[$column] ?? 'Belum Ada Data';
        }
        $response['created_year'] = $data['tahun']; // Menggunakan kolom 'tahun'
        return $response;
    } else {
        // Jika tidak ada data untuk tahun sebelumnya, kembalikan pesan default
        $response = [];
        foreach ($columns as $column) {
            $response[$column] = 'Belum Ada Data';
        }
        $response['created_year'] = '-';
        return $response;
    }
}

function displayPreviousYearData($previous_data, $field_name, $label)
{
    // Jika tidak ada data untuk tahun sebelumnya
    if ($previous_data['created_year'] === '-') {
        return "Data untuk tahun sebelumnya belum ada.";
    }
    // Jika data ditemukan untuk tahun sebelumnya
    elseif ($previous_data['created_year'] == date('Y') - 1) {
        return "Data pada tahun sebelumnya (" . htmlspecialchars($previous_data['created_year']) . "): " . htmlspecialchars($previous_data[$field_name]);
    }
    // Jika data ditemukan untuk tahun sebelumnya
    elseif ($previous_data['created_year'] == date('Y')) {
        return "Data pada tahun sebelumnya (" . htmlspecialchars($previous_data['created_year']) . "): " . htmlspecialchars($previous_data[$field_name]);
    }
    // Default jika tidak ada data
    else {
        return "Data tidak ditemukan.";
    }
}