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

  $result = mysqli_query($conn, $query);
  
  // Jika data ada untuk tahun sebelumnya, ambil data dan waktu pembuatan
  if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    $response = [];
    foreach ($columns as $column) {
      $response[$column] = $data[$column] ?? 'Belum Ada Data';
    }
    $response['created_year'] = date('Y', strtotime($data['created_at']));
    return $response;
  } else {
    // Jika tidak ada data untuk tahun sebelumnya, coba ambil data untuk tahun saat ini
    $query_current_year = "
      SELECT $columns_str, user_progress.created_at 
      FROM $table_name
      INNER JOIN user_progress 
      ON $table_name.user_id = user_progress.user_id 
      AND $table_name.desa_id = user_progress.desa_id 
      WHERE $table_name.user_id = '$user_id' 
      AND $table_name.desa_id = '$desa_id'
      AND user_progress.form_name = '$form_name'
      AND YEAR(user_progress.created_at) = '$current_year'
      ORDER BY user_progress.created_at DESC 
      LIMIT 1";
      
    $result_current_year = mysqli_query($conn, $query_current_year);
    
    if ($result_current_year && mysqli_num_rows($result_current_year) > 0) {
      $data = mysqli_fetch_assoc($result_current_year);
      $response = [];
      foreach ($columns as $column) {
        $response[$column] = $data[$column] ?? 'Belum Ada Data';
      }
      $response['created_year'] = date('Y', strtotime($data['created_at']));
      return $response;
    } else {
      // Jika tidak ada data untuk tahun ini, kembalikan pesan default
      $response = [];
      foreach ($columns as $column) {
        $response[$column] = 'Belum Ada Data';
      }
      $response['created_year'] = '-';
      return $response;
    }
  }
};

// Pemanggilan ke dalam form
function displayPreviousYearData($previous_data, $field_name, $label) {
  // Check if there's no data
  if ($previous_data['created_year'] === '-') {
      return "Anda belum mengisi data.";
  }
  // Check if the data is from the previous year
  elseif ($previous_data['created_year'] == date('Y') - 1) {
      return "Data Pada Tahun Sebelumnya (" . htmlspecialchars($previous_data['created_year']) . "): " . htmlspecialchars($previous_data[$field_name]);
  }
  // Check if the data is from the current year
  elseif ($previous_data['created_year'] == date('Y')) {
      return "Data Pada Tahun Ini (" . htmlspecialchars($previous_data['created_year']) . "): " . htmlspecialchars($previous_data[$field_name]);
  }
  // Default message if no valid data is found
  else {
      return "Data tidak ditemukan.";
  }
};
?>
